@component('mail::message')
# Your Order is Completed 🎉

Hello {{ $order->name }},

Your order has been marked as **Success**.

Your invoice is attached with this email.

Thanks,  
**GirlsVillaBoutique**
@endcomponent
