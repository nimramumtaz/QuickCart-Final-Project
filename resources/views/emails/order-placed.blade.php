<x-mail::message>
# Order Confirmed

Thank you for shopping with QuickCart. Your order **{{ $order->order_number }}** has been received.

<x-mail::panel>
Total payable: **Rs. {{ number_format($order->total) }}**  
Payment: {{ $order->payment_method }}  
Delivery city: {{ $order->city }}
</x-mail::panel>

@foreach($order->items as $item)
- {{ $item->product_name }} x {{ $item->quantity }}: Rs. {{ number_format($item->line_total) }}
@endforeach

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
