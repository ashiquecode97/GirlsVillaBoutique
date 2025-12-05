@component('mail::message')
# 📦 Order Status Update

Hi {{ $order->name }},

Your order **#{{ $order->id }}** status has been updated.

### Previous Status:
**{{ ucfirst($oldStatus) }}**

### New Status:
**{{ ucfirst($newStatus) }}**

@component('mail::panel')
Total Amount: ₹{{ number_format($order->total_amount) }}
@endcomponent

We will notify you of further updates.

Thanks,  
**GirlsVilla Boutique**
@endcomponent
