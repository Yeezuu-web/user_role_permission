<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BoostMail extends Mailable
{
    use Queueable, SerializesModels;

    public $details;
    
    public function __construct($details)
    {
        $this->details = $details;
    }

    public function build()
    {
        return $this->subject('CBS Facebook boost request.')
            ->view('mails.mail-sample');
    }
}
