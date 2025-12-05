<?php
namespace App\Mail;

use App\Models\Order;
use Illuminate\Mail\Mailable;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderInvoiceMail extends Mailable
{
    public $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function build()
    {
        $pdf = Pdf::loadView('admin.orders.invoice', ['order' => $this->order]);

        return $this->subject('Your Order Invoice')
                    ->markdown('emails.order-invoice')
                    ->attachData($pdf->output(), 'invoice-'.$this->order->id.'.pdf');
    }
}
