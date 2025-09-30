<?php

namespace vgn\Jobs;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use vgn\Http\Traits\vendortrait;

class vendor_complaints_sync implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, vendortrait;
    protected $vendid;
    protected $status;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($vendid,$sapstatus)
    {
        $this->vendid = $vendid;
        $this->status = $sapstatus;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        
        if ($this->status == "presentindb") {
            Log::info('Vendor Complaints processed '.$this->vendid);
            $sapdata = $this->vendor_complaints_job($this->vendid);

            if ($sapdata != "") {
                $sap_compl = array();
                    if (array_key_exists('COMPLAINTS', $sapdata)) {
                    
                    $sapcomplaints = $sapdata['COMPLAINTS'];
                    if (array_key_exists('0', $sapcomplaints)) {
                        $sap_compl = $sapcomplaints;
                    }
                    else
                    {
                        $sap_compl[0] = $sapcomplaints;
                    }
                    
                     $getcomplaints = DB::connection('mysql5')->table('complaints')->where('vendor_id', '=', $this->vendid)->get();
                     
                     
                     if(count($getcomplaints) > 0)
                     {
                        foreach ($sap_compl as $sapcomplkey => $sapcomplvalue) {
                            foreach ($getcomplaints as $complkey => $complvalue) {
                            $projectname =  $complvalue->project;
                            $projectcomplaint =  $complvalue->complaint_no;
                            
                            //dd($projectname);
                            if (($projectname == $sapcomplvalue['Project_Name'])&&($projectcomplaint == $sapcomplvalue['Complaint_Number'])) {
                                
                                DB::connection('mysql5')->table('complaints')->where('vendor_id', '=', $this->vendid)
                                ->where('project','=',$projectname)
                                ->where('complaint_no','=',$projectcomplaint)
                                ->update(['nature' => $sapcomplvalue['Nature_Of_Complaint'],
                                'vendor_care_name' => $sapcomplvalue['Vendor_Care_Name'],
                                'description' => '',
                                'vgn_status' => $sapcomplvalue['RO_Status'],
                                'vend_status' => $sapcomplvalue['Vendor_Status'],
                                'final_status' => $sapcomplvalue['Final_Status'],
                                'date' => substr($sapcomplvalue['Date_Complaint_Raised'],0,4)."-".substr($sapcomplvalue['Date_Complaint_Raised'],4,2)."-".substr($sapcomplvalue['Date_Complaint_Raised'],6,2)
                                 ]);
                            }
                           

                            }
                            
                        }
                     }
                 }

                    
                  

                  

        }
    }

if ($this->status == "notpresentindb") {
    Log::info('Vendor Complaints processed '.$this->vendid);
            $sapdata = $this->vendor_complaints_job($this->vendid);
                if ($sapdata != "") {
                
                $sap_compl = array();
                    if (array_key_exists('COMPLAINTS', $sapdata)) {
                    
                    $sapcomplaints = $sapdata['COMPLAINTS'];
                    if (array_key_exists('0', $sapcomplaints)) {
                        $sap_compl = $sapcomplaints;
                    }
                    else
                    {
                        $sap_compl[0] = $sapcomplaints;
                    }
                    
                     $getcomplaints = DB::connection('mysql5')->table('complaints')->where('vendor_id', '=', $this->vendid)->get();
                     
                     
                     if(count($getcomplaints) > 0)
                     {
                         
                         
                        foreach ($sap_compl as $sapcomplkey => $sapcomplvalue) {
                            foreach ($getcomplaints as $complkey => $complvalue) {
                            $projectname =  $complvalue->project;
                            $projectcomplaint =  $complvalue->complaint_no;
                            
                            
                            if ($projectcomplaint == $sapcomplvalue['Complaint_Number']) {
                                
                                
                                
                                DB::connection('mysql5')->table('complaints')->where('vendor_id', '=', $this->vendid)
                                ->where('project','=',$projectname)
                                ->where('complaint_no','=',$projectcomplaint)
                                ->update(['nature' => $sapcomplvalue['Nature_Of_Complaint'],
                                'vendor_care_name' => $sapcomplvalue['Vendor_Care_Name'],
                                'vgn_status' => $sapcomplvalue['RO_Status'],
                                'vend_status' => $sapcomplvalue['Vendor_Status'],
                                'final_status' => $sapcomplvalue['Final_Status'],
                                'date' => substr($sapcomplvalue['Date_Complaint_Raised'],0,4)."-".substr($sapcomplvalue['Date_Complaint_Raised'],4,2)."-".substr($sapcomplvalue['Date_Complaint_Raised'],6,2)
                                 ]);
                            }
                           

                            }
                            
                        }
                     }
                 }
    }
}
    
    }
}
