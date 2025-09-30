<?php

namespace vgn\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Request;
use Carbon\Carbon;

class sendforgotpwdotp extends Mailable
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
        return $this->view('vendor.sendforgotpwdotp')
             ->from("alerts@info.vgnsap.in", "VGN Projects Estates")
                     ->subject($this->applicationlist['subject'])
                     ->with(['data'=> $this->applicationlist]);
    }
}
