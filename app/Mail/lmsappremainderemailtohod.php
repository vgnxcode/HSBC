<?php

namespace vgn\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Request;
use Carbon\Carbon;

class lmsappremainderemailtohod extends Mailable
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
        $subject = "LMS: ".Carbon::now()->format('M Y')." Remainder Email For Pending Applications! (HIGH PRIORITY)";
        return $this->view('vendor.remainderemailtohod')
             ->from("alerts@info.vgnsap.in", "VGN Leave Management System")
                     ->subject($subject)
                     ->with(['data'=> $this->applicationlist]);
    }
}
