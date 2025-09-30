<?php

namespace vgn\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class vgnhomesleadsmail extends Mailable
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
        $sub = 'VGN Website Lead Enquiry Details';
            return $this->view('vendor.vgnhomesleads')
                ->from('vgnhomesleads@info.vgnsap.in', 'VGN Team')
                        ->subject($sub)
                        ->with(['data'=> $this->applicationlist]);
    }
}
