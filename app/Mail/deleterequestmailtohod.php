<?php

namespace vgn\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class deleterequestmailtohod extends Mailable
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
        if($this->applicationlist['ishod'] == 1){
            $sub = 'Leave Application Deletion Request from '.$this->applicationlist['empname'];
        return $this->view('vendor.deleterequestmailtohod')
            ->from('alerts@info.vgnsap.in', $this->applicationlist['empname'])
                    ->subject($sub)
                    ->with(['data'=> $this->applicationlist]);
        }

        if($this->applicationlist['ishod'] == 0){
            $sub = 'Leave Application Deletion Request submitted copy from '.$this->applicationlist['empname'];
            return $this->view('vendor.deleterequestmailtohod')
                ->from('alerts@info.vgnsap.in', 'LMS Team')
                        ->subject($sub)
                        ->with(['data'=> $this->applicationlist]);
            }

    }
}
