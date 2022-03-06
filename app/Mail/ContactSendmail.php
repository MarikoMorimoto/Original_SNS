<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactSendmail extends Mailable
{
    use Queueable, SerializesModels;

    private $email;
    private $title;
    private $contact;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct( $inputs )
    {
        $this->email = $inputs['email'];
        $this->title = $inputs['title'];
        $this->contact = $inputs['contact'];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
        ->from('auth@morimori02.conohawing.com')
        ->subject('お問い合わせありがとうございます')
        // view にメールの内容を記載
        ->view('contact.mail')
        ->with([
            'email' => $this->email,
            'title' => $this->title,
            'contact' => $this->contact,
        ]);
    }
}
