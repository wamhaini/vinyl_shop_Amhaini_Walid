<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;



class ContactMail extends Mailable
{
    use Queueable, SerializesModels;

    public $request;

    public $contact;

    /** Create a new message instance. ...*/
    public function __construct($request)
    {
        $this->request = $request;

        $this->contact = $request['contact'];
    }

    /** Build the message. ...*/
    public function build()
    {
        return $this->from($this->contact.'@thevinylshop.com', 'The Vinyl Shop - ' .ucfirst($this->contact))
            ->cc($this->contact.'@thevinylshop.com', 'The Vinyl Shop - ' .ucfirst($this->contact))
            ->subject('The Vinyl Shop - Contact Form')
            ->markdown('email.contact');
    }
}
