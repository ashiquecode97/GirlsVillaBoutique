@component('mail::message')
# ❌ Order Cancelled

Hello **{{ $order->name }}**,

Your order **#{{ $order->id }}** has been successfully cancelled.

### 🧾 Order Details
- **Order ID:** {{ $order->id }}
- **Amount:** ₹{{ number_format($order->total_amount) }}
- **Status:** Cancelled

@if($order->payment_method !== 'cod')
💰 If you paid online, your refund will be processed within **3–5 working days**.
@endif

If this was a mistake or you need help, feel free to contact us.

Thanks,  
**{{ config('app.name') }} Team**
@endcomponent
