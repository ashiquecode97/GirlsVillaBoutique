<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice #{{ $order->id }}</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            color: #333;
            font-size: 14px;
        }
        .invoice-box {
            padding: 20px;
            border: 1px solid #ddd;
        }
        .heading {
            font-size: 22px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .section-title {
            font-weight: bold;
            margin-top: 20px;
            font-size: 16px;
            border-bottom: 1px solid #ccc;
            padding-bottom: 3px;
        }
        table {
            width: 100%;
            margin-top: 15px;
            border-collapse: collapse;
        }
        table th, table td {
            padding: 8px 10px;
            border: 1px solid #ddd;
        }
        .total {
            font-size: 16px;
            font-weight: bold;
            text-align: right;
            padding-top: 10px;
        }
        .text-right {
            text-align: right;
        }
    </style>

</head>
<body>

<div class="invoice-box">

    <!-- Header -->
    <table width="100%">
        <tr>
            <td>
                <h2 style="color:#4F46E5;">GirlsVillaBoutique</h2>
                <small>Dhupuri District · Assam</small>
            </td>
            <td class="text-right">
                <h3>Invoice #{{ $order->id }}</h3>
                Date: {{ $order->created_at->format('d M Y') }}
            </td>
        </tr>
    </table>

    <!-- Customer -->
    <div class="section-title">Customer Information</div>

    <p><strong>Name:</strong> {{ $order->name }}</p>
    <p><strong>Email:</strong> {{ $order->email }}</p>
    <p><strong>Phone:</strong> {{ $order->phone }}</p>
    <p>
        <strong>Address:</strong>  
        {{ $order->address }}, {{ $order->city }}, {{ $order->pincode }}
    </p>

    <!-- Items -->
    <div class="section-title">Order Items</div>

    <table>
        <thead style="background: #f0f0f0;">
            <tr>
                <th>Product</th>
                <th>Qty</th>
                <th>Price</th>
                <th>Total</th>
            </tr>
        </thead>

        <tbody>
            @foreach($order->items as $item)
            <tr>
                <td>{{ $item->product->name }}</td>
                <td>{{ $item->quantity }}</td>
                <td>₹{{ number_format($item->price) }}</td>
                <td>₹{{ number_format($item->quantity * $item->price) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Total -->
    <p class="total">
        Total Amount: ₹{{ number_format($order->total_amount) }}
    </p>

</div>

</body>
</html>
