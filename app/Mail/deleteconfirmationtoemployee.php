<?php

namespace vgn\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class deleteconfirmationtoemployee extends Mailable
{
    use Queueable, SerializesModels;
    protected $applicationlist;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($applicationlist)
    {
        $this->applicationlist = $applicationlist;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $sub = 'Confirmation for Leave Application deleted by HOD!';
            return $this->view('vendor.appldeleteconfirmationtoemp')
                ->from('alerts@info.vgnsap.in', 'LMS Team')
                        ->subject($sub)
                        ->with(['data'=> $this->applicationlist]);
    }
}
