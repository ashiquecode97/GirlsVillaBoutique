<?php
namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderConfirmedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function build()
    {
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.orders.invoice', [
            'order' => $this->order
        ])->setPaper('a4', 'portrait');

        return $this->subject('Your Order Invoice - GirlsVillaBoutique')
                    ->markdown('emails.order-confirmed')
                    ->attachData($pdf->output(), 'invoice-'.$this->order->id.'.pdf', [
                        'mime' => 'application/pdf',
                    ]);
    }
}

