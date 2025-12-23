<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice #{{ $order->id }}</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 13px;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .container {
            padding: 30px;
        }

        /* HEADER */
        .header {
            display: table;
            width: 100%;
            margin-bottom: 25px;
            border-bottom: 3px solid #4f46e5;
            padding-bottom: 15px;
        }

        .header-left {
            display: table-cell;
            vertical-align: middle;
        }

        .header-right {
            display: table-cell;
            text-align: right;
            vertical-align: middle;
        }

        .logo {
            width: 70px;
            margin-bottom: 5px;
        }

        .brand {
            font-size: 24px;
            font-weight: bold;
            color: #4f46e5;
            letter-spacing: 0.5px;
        }

        .tagline {
            font-size: 12px;
            color: #777;
        }

        .invoice-box {
            background: #f5f7ff;
            padding: 12px 16px;
            border-radius: 6px;
            text-align: right;
            font-size: 13px;
        }

        /* SECTION TITLES */
        .section-title {
            margin: 25px 0 10px;
            font-size: 15px;
            font-weight: bold;
            color: #111;
            border-left: 4px solid #4f46e5;
            padding-left: 8px;
        }

        /* INFO TABLE */
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        .info-table td {
            padding: 8px;
            border: 1px solid #ddd;
            vertical-align: top;
        }

        /* ITEMS TABLE */
        table.items {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table.items th {
            background: #4f46e5;
            color: #fff;
            padding: 10px;
            font-size: 12px;
            text-transform: uppercase;
        }

        table.items td {
            padding: 9px;
            border: 1px solid #ddd;
            font-size: 13px;
        }

        table.items tr:nth-child(even) {
            background: #fafafa;
        }

        .right {
            text-align: right;
        }

        /* TOTAL */
        .total-box {
            margin-top: 20px;
            float: right;
            width: 45%;
            border-collapse: collapse;
        }

        .total-box td {
            padding: 10px;
            border: 1px solid #ddd;
        }

        .grand-total {
            background: #4f46e5;
            color: #fff;
            font-weight: bold;
            font-size: 15px;
        }

        /* FOOTER */
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 12px;
            color: #777;
            border-top: 1px dashed #ccc;
            padding-top: 12px;
        }
    </style>
</head>

<body>
<div class="container">

    {{-- HEADER --}}
    <div class="header">
        <div class="header-left">
            <img src="{{ public_path('storage/logo.jpg') }}" class="logo">
            <div class="brand">GirlsVilla Boutique</div>
            <div class="tagline">Dhubri District, Assam</div>
        </div>

        <div class="header-right">
            <div class="invoice-box">
                <strong>Invoice #{{ $order->id }}</strong><br>
                Date: {{ $order->created_at->format('d M Y') }}
            </div>
        </div>
    </div>

    {{-- CUSTOMER & ORDER INFO --}}
    <div class="section-title">Order & Customer Details</div>

    <table class="info-table">
        <tr>
            <td width="50%">
                <strong>Order Date:</strong> {{ $order->created_at->format('d M Y') }}<br>
                <strong>Status:</strong> {{ ucfirst($order->status) }}<br>
                <strong>Payment:</strong> {{ strtoupper($order->payment_method) }}
            </td>
            <td width="50%">
                <strong>Customer:</strong><br>
                {{ $order->name }}<br>
                {{ $order->email }}<br>
                {{ $order->phone }}<br>
                {{ $order->address }}, {{ $order->city }} - {{ $order->pincode }}
            </td>
        </tr>
    </table>

    {{-- ITEMS --}}
    <div class="section-title">Purchased Items</div>

    <table class="items">
        <thead>
            <tr>
                <th>#</th>
                <th>Product</th>
                <th>Size</th>
                <th>Qty</th>
                <th class="right">Price</th>
                <th class="right">Total</th>
            </tr>
        </thead>
        <tbody>
        @foreach($order->items as $i => $item)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $item->product->name }}</td>
                <td>{{ $item->size ?? '-' }}</td>
                <td>{{ $item->quantity }}</td>
                <td class="right">₹{{ number_format($item->price) }}</td>
                <td class="right">₹{{ number_format($item->price * $item->quantity) }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {{-- TOTAL --}}
    <table class="total-box">
        <tr class="grand-total">
            <td>Grand Total</td>
            <td class="right">₹{{ number_format($order->total_amount) }}</td>
        </tr>
    </table>

    <div style="clear: both;"></div>

    {{-- FOOTER --}}
    <div class="footer">
        Thank you for shopping with <strong>GirlsVilla Boutique</strong> 💜<br>
        This is a system-generated invoice and does not require a signature.
    </div>

</div>
</body>
</html>
