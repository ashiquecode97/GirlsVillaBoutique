<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice #{{ $order->id }}</title>

    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .wrapper {
            width: 100%;
            padding: 25px 35px;
        }

        /* HEADER */
        .header {
            text-align: center;
            margin-bottom: 25px;
        }
        .header img {
            width: 110px;
            margin-bottom: 8px;
        }
        .header-title {
            font-size: 22px;
            font-weight: bold;
            color: #444;
        }

        /* INVOICE INFO BOX */
        .invoice-meta {
            margin-top: 10px;
            font-size: 14px;
            color: #444;
            text-align: center;
        }

        /* SECTION TITLE */
        .section-title {
            margin-top: 25px;
            font-size: 15px;
            font-weight: bold;
            color: #555;
            padding-bottom: 5px;
            border-bottom: 2px solid #EEE;
        }

        /* CUSTOMER BOX */
        .customer-box {
            padding: 10px 0;
            font-size: 14px;
            line-height: 1.6;
        }

        /* PRODUCT TABLE */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        table thead th {
            background: #F7F7F7;
            padding: 10px;
            font-size: 13px;
            text-align: left;
            color: #555;
            border-bottom: 1px solid #EEE;
        }

        table tbody td {
            padding: 10px 8px;
            border-bottom: 1px solid #EEE;
            font-size: 13px;
        }

        /* TOTAL SUMMARY BOX */
        .summary-box {
            width: 250px;
            margin-left: auto;
            margin-top: 20px;
            padding: 15px;
            border: 1px solid #DDD;
            border-radius: 8px;
            background: #FBFBFB;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            font-size: 14px;
        }

        .summary-row strong {
            font-weight: bold;
            color: #444;
        }

        .grand-total {
            font-size: 16px;
            font-weight: bold;
            margin-top: 10px;
            border-top: 1px solid #DDD;
            padding-top: 10px;
            text-align: right;
            color: #000;
        }

        /* SIGNATURE */
        .signature {
            margin-top: 55px;
            text-align: right;
            font-size: 14px;
        }

        /* FOOTER */
        .footer {
            margin-top: 50px;
            font-size: 12px;
            text-align: center;
            color: #777;
        }

    </style>
</head>

<body>

<div class="wrapper">

    <!-- HEADER -->
    <div class="header">
        <img src="{{ public_path('storage/logo.jpg') }}">
        <div class="header-title">GirlsVillaBoutique</div>
        <small>Dhubri District, Assam</small>
    </div>

    <!-- INVOICE META -->
    <div class="invoice-meta">
        <strong>Invoice #{{ $order->id }}</strong> • 
        {{ $order->created_at->format('d M Y') }}
    </div>

    <!-- CUSTOMER INFORMATION -->
    <div class="section-title">Customer Details</div>

    <div class="customer-box">
        <strong>Name:</strong> {{ $order->name }} <br>
        <strong>Email:</strong> {{ $order->email }} <br>
        <strong>Phone:</strong> {{ $order->phone }} <br>
        <strong>Address:</strong> {{ $order->address }}, {{ $order->city }} - {{ $order->pincode }}
    </div>

    <!-- ORDER ITEMS -->
    <div class="section-title">
    Order Summary — <span style="color:#8B3FD9;">Order #{{ $order->id }}</span>
</div>


    <table>
        <thead>
            <tr>
                <th>Product Code</th>
                <th>Product</th>
                <th>Size</th>
                <th>Unit Price</th>
                <th>Qty</th>
                <th>Subtotal</th>
            </tr>
        </thead>

        <tbody>
            @foreach($order->items as $item)
            <tr>
                <td>{{ $item->product->product_code }}</td>
                <td>{{ $item->product->name }}</td>
                <td>{{ $item->size ?? '-' }}</td>
                <td>₹{{ number_format($item->price) }}</td>
                <td>{{ $item->quantity }}</td>
                <td>₹{{ number_format($item->price * $item->quantity) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- TOTAL BOX -->
    <div class="summary-box">
        @php
            $sub = $order->items->sum(fn($i) => $i->price * $i->quantity);
        @endphp

        <div class="summary-row">
            <span>Subtotal</span>
            <strong>₹{{ number_format($sub) }}</strong>
        </div>

        <div class="summary-row">
            <span>Shipping</span>
            <strong>FREE</strong>
        </div>

        <div class="grand-total">
            Grand Total: ₹{{ number_format($order->total_amount) }}
        </div>
    </div>

    <!-- SIGNATURE -->
    <div class="signature">
        __________________________<br>
        <strong>Authorized Signature</strong>
    </div>

    <!-- FOOTER -->
    <div class="footer">
        Thank you for shopping with <strong>GirlsVillaBoutique</strong> ❤️ <br>
        Need help? Email us at support@GirlsVillaBoutique.com
    </div>

</div>

</body>
</html>
