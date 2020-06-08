<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactTeamEmail extends Mailable
{
    use Queueable, SerializesModels;
    
    private $contact_form;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($contact_form)
    {
        $this->contact_form = $contact_form;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('info@srworld.sk')
                    ->view('emails.contactFormTeam');
    }
}
