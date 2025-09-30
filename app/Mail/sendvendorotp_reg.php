<?php

namespace vgn\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Carbon\Carbon;

class sendvendorotp_reg extends Mailable
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
        return $this->view('vendor.sendvendorotp_reg')
             ->from("vendorreg@alerts.vgnsap.in", "VGN Projects Estates")
                     ->subject("Vendor Registration Email Verification OTP")
                     ->with(['data'=> $this->applicationlist]);
    }
}

