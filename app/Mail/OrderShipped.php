<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderShipped extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $order;
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $attachments = [
            storage_path('file/anh-anime.jpeg'),
            storage_path('file/img.jpg'),
        ];

        $email=  $this->view('emails.orders.thankyou')                                   // call template
                    ->with([                                                                //  Pass Data to view
                        'order_name' => $this->order->name,
                        'order_price' => $this->order->price,
                    ]);
//                    ->attach(storage_path('file/anh-anime.jpeg'),[                   // attach file send mail
//                        'as' => 'name.image',
//                        'mime' => 'image/jpeg',
//                    ])
//                    ->attach(storage_path('file/img.jpg'),[                   // attach file send mail
//                        'as' => 'name.image',
//                        'mime' => 'image/jpeg',
//                    ]);
        foreach($attachments as $file){
            $email->attach($file);
        }
        return $email;

    }
}
