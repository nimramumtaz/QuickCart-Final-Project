<?php

namespace App\Http\Controllers;

use App\Mail\OrderPlacedMail;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'first_name' => ['required', 'string', 'max:80'],
            'last_name' => ['nullable', 'string', 'max:80'],
            'phone' => ['required', 'string', 'max:30'],
            'email' => ['nullable', 'email', 'max:120'],
            'address' => ['required', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:80'],
            'payment_method' => ['required', 'string', 'max:80'],
            'promo_code' => ['nullable', 'string', 'max:40'],
            'notes' => ['nullable', 'string', 'max:1000'],
            'cart' => ['required', 'array', 'min:1'],
            'cart.*.id' => ['required', 'integer', 'exists:products,id'],
            'cart.*.quantity' => ['required', 'integer', 'min:1', 'max:20'],
        ]);

        $order = DB::transaction(function () use ($data) {
            $products = Product::whereIn('id', collect($data['cart'])->pluck('id'))->get()->keyBy('id');
            $subtotal = collect($data['cart'])->sum(fn ($line) => $products[$line['id']]->price * $line['quantity']);
            $delivery = $subtotal > 0 && $subtotal < 1500 ? 150 : 0;

            $order = Order::create([
                ...collect($data)->except('cart')->all(),
                'city' => $data['city'] ?: 'Faisalabad',
                'order_number' => 'QC-' . now()->format('ymd') . '-' . Str::upper(Str::random(5)),
                'subtotal' => $subtotal,
                'delivery_fee' => $delivery,
                'total' => $subtotal + $delivery,
            ]);

            foreach ($data['cart'] as $line) {
                $product = $products[$line['id']];
                $order->items()->create([
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'unit_price' => $product->price,
                    'quantity' => $line['quantity'],
                    'line_total' => $product->price * $line['quantity'],
                ]);
            }

            return $order->load('items');
        });

        if ($order->email) {
            try {
                Mail::to($order->email)->send(new OrderPlacedMail($order));
            } catch (\Throwable $e) {
                Log::warning('Order email could not be sent', ['error' => $e->getMessage()]);
            }
        }

        return response()->json([
            'message' => 'Order placed successfully.',
            'order_number' => $order->order_number,
            'total' => $order->total,
        ]);
    }
}
