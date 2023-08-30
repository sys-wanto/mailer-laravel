<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class notification extends Mailable
{
    use Queueable, SerializesModels;
    public $email, $content;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email, $content)
    {
        //
        $this->email = $email;
        $this->content = $content;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Nomor Surat telah di buat')->markdown('emails.notifications', array('no_surat' => $this->content));
    }
}