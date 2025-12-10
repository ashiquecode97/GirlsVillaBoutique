@component('mail::message')

# GirlsVilla Boutique  
Dhubri District, Assam  

---

# 📦 Order Status Updated

Hi **{{ $order->name }}**,  
Your order **#{{ $order->id }}** has been updated.

---

## 🔄 Status Update
- **Previous Status:** {{ ucfirst($oldStatus) }}
- **New Status:** **{{ ucfirst($newStatus) }}**

---

## 🧾 Order Details

@component('mail::panel')
**Order ID:** #{{ $order->id }}  
**Order Date:** {{ $order->created_at->format('d M Y') }}  
**Payment Method:** **{{ strtoupper($order->payment_method) }}**
@endcomponent

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

## 💰 Payment Summary
- **Subtotal:** ₹{{ number_format($order->items->sum(fn($i) => $i->price * $i->quantity)) }}
- **Shipping:** FREE
- **Grand Total:** **₹{{ number_format($order->total_amount) }}**

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
