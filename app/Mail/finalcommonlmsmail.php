<?php

namespace vgn\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Request;
use Carbon\Carbon;

class finalcommonlmsmail extends Mailable
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
         //dd($this->applicationlist);

         $url =  url('/');
        
         if ($this->applicationlist['leave_processed']['saved_file_path'] != null) {
             $attachment_folder = "https:".$this->applicationlist['leave_processed']['saved_file_path'];
             
         }
         else{
             $attachment_folder = '';
         }


         $subject = $this->applicationlist['leave_processed']['type']." Application on ";

         if ($this->applicationlist['leave_processed']['no_of_days'] > 1) {
             $sub_leave_date = Carbon::parse($this->applicationlist['leave_processed']['stdate'])->format('d, M Y').' to '.Carbon::parse($this->applicationlist['leave_processed']['etdate'])->format('d, M Y');
         }
         else{
            $sub_leave_date = Carbon::parse($this->applicationlist['leave_processed']['stdate'])->format('d, M Y');
         }

            $frommail = $this->applicationlist['employee_off_mail'];
            $ccmail = $this->applicationlist['employee_off_mail'];
            $subject = $subject.$sub_leave_date;

            $this->applicationlist['leave_processed']['stdate'] = Carbon::parse($this->applicationlist['leave_processed']['stdate'])->format('d, M Y h:i:s A');
            $this->applicationlist['leave_processed']['etdate'] = Carbon::parse($this->applicationlist['leave_processed']['etdate'])->format('d, M Y h:i:s A');
            $this->applicationlist['leave_processed']['created_date'] = Carbon::parse($this->applicationlist['leave_processed']['created_date'])->format('d, M Y h:i:s A');
            if ($this->applicationlist['leave_processed']['hod_created_date'] != null) {
                $this->applicationlist['leave_processed']['hod_created_date'] = Carbon::parse($this->applicationlist['leave_processed']['hod_created_date'])->format('d, M Y h:i:s A');
            }
            if ($this->applicationlist['leave_processed']['admin_created_date'] != null) {
                $this->applicationlist['leave_processed']['admin_created_date'] = Carbon::parse($this->applicationlist['leave_processed']['admin_created_date'])->format('d, M Y h:i:s A');
            }

                 //dd($attachment_folder);
         
         if ($this->applicationlist['leave_processed']['saved_file_path'] != null) {
             return $this->view('vendor.finalmail')
             ->from("alerts@info.vgnsap.in", "VGN Leave Management System")
                     ->subject($subject)
                      ->attach($attachment_folder)
                     ->with(['data'=> $this->applicationlist]);
                     //->from($frommail, $this->applicationlist['employee_name'])
         }else{
             return $this->view('vendor.finalmail')
             ->from("alerts@info.vgnsap.in", "VGN Leave Management System")
                     ->subject($subject)
                     ->with(['data'=> $this->applicationlist]);
                     //->from($frommail, $this->applicationlist['employee_name'])
         }
    }
}
