@component('mail::message')
# 🎉 Order Placed Successfully!

Hi {{ $order->name }},

Thank you for placing your order with us!

## Order Summary
- **Order ID:** {{ $order->id }}
- **Total Amount:** ₹{{ number_format($order->total_amount) }}
- **Status:** {{$order->Status}}

We will notify you once your order is processed.


Thanks,  
**GirlsVilla Boutique**
Contact : 700223386
@endcomponent
