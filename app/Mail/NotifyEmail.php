<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotifyEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    /**
     * Create a new message instance.
     *
     * @param string $data
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this    
    */ 
    public function build()
    {
    return $this->subject('Graduate Tracer Study Employment Tracker Survey!')
        ->view('emails.notifyemail')
        ->with([
            'data' => $this->data,
        ]);
    }
}