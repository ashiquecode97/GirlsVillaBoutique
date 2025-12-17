@component('mail::message')

<!-- BRAND HEADER -->
<div style="text-align:center; margin-bottom:15px;">
    <img src="{{ asset('storage/logo.png') }}" alt="Logo" 
         style="width:120px; margin-bottom:10px; border-radius:8px;">
    <h2 style="color:#8B3FD9; margin:0; font-weight:800;">
        GirlsVilla Boutique
    </h2>
    <small style="color:#666;">Dhubri District, Assam</small>
</div>

---

# 🎉 Your Order Has Been Placed!

Hi **{{ $order->name }}**,  
Thank you for choosing **GirlsVilla Boutique** ❤️  
Your order has been successfully placed.

---

## 🧾 Order Summary
**Order ID:** #{{ $order->id }}  
**Date:** {{ $order->created_at->format('d M Y') }}  
**Payment Method:** **{{ strtoupper($order->payment_method) }}**  
**Status:** {{ ucfirst($order->status) }}

---

## 🛍️ Items in Your Order

@foreach($order->items as $item)
**{{ $item->product->name }}**  
- Size: {{ $item->size ?? '-' }}  
- Qty: {{ $item->quantity }}  
- Price: ₹{{ number_format($item->price) }}  
- Subtotal: ₹{{ number_format($item->price * $item->quantity) }}

---
@endforeach
---

@php
    $subtotal = $order->items->sum(fn($i) => $i->price * $i->quantity);
@endphp

# 💰 Payment Summary

<div style="background:#F9F5FF; padding:12px 18px; border-left:4px solid #8B3FD9; border-radius:6px; margin-top:10px;">
    <p style="margin:0; font-size:14px;">
        <strong>Subtotal:</strong> ₹{{ number_format($subtotal) }}<br>
        <strong>Shipping:</strong> FREE<br>
        <strong style="font-size:16px; color:#8B3FD9;">Grand Total: ₹{{ number_format($order->total_amount) }}</strong>
    </p>
</div>

---

# 🚚 What Happens Next?

We are preparing your order.  
You will receive updates when your order is:

- ✔ Packed 
- ✔ Shipped  
- ✔ Out for Delivery  
- ✔ Delivered  

---

Thanks for shopping with **GirlsVilla Boutique** 💜  
If you need help, reply to this email or call us.

📞 **7002233886**  
🌸 With love,  
**GirlsVilla Boutique**

@endcomponent
