<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CallbackRequest extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function build()
    {

        return $this->subject('Новая заявка на обратный звонок с сайта MVGifts')
            ->view('emails.callback')
            ->with(['data' => $this->data]);
    }
}
