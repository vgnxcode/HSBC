<?php

namespace vgn\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class toemployeemail extends Mailable
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
        $url =  url('/');
        
        if ($this->applicationlist['leave_type'] == 'Sick Leave') {
            $attachment_folder = $url.'/newcustomerzoneassets/sickfileupload'.'/'.$this->applicationlist['attachment'];
        }
        elseif($this->applicationlist['leave_type'] == 'Maternity Leave'){
            $attachment_folder = $url.'/newcustomerzoneassets/maternityfileupload'.'/'.$this->applicationlist['attachment'];
        }
        elseif ($this->applicationlist['leave_type'] == 'Mispunch') {
            $attachment_folder = $url.'/newcustomerzoneassets/mispunchuploads'.'/'.$this->applicationlist['attachment'];

        }
        else{
            $attachment_folder = '';
        }
                //dd($attachment_folder);
        
        if ($this->applicationlist['attachment'] != null) {
            return $this->view('vendor.employeefinalmail')
            ->from("alerts@info.vgnsap.in", $this->applicationlist['employee_name'])
                    ->subject($this->applicationlist['subject'])
                     ->attach($attachment_folder)
                    ->with(['data'=> $this->applicationlist]);
        }else{
            return $this->view('vendor.employeefinalmail')
            ->from("alerts@info.vgnsap.in", $this->applicationlist['employee_name'])
                    ->subject($this->applicationlist['subject'])
                    ->with(['data'=> $this->applicationlist]);
        }
    }
}
