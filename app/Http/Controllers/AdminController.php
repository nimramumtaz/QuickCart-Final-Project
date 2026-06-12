<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Models\NewsletterSubscriber;
use App\Models\Order;
use App\Models\Product;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard', [
            'orders' => Order::with('items')->latest()->take(20)->get(),
            'messages' => ContactMessage::latest()->take(20)->get(),
            'subscribers' => NewsletterSubscriber::latest()->take(20)->get(),
            'stats' => [
                'products' => Product::count(),
                'orders' => Order::count(),
                'messages' => ContactMessage::count(),
                'revenue' => Order::sum('total'),
            ],
        ]);
    }
}
