<?php

namespace vgn\Jobs;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use vgn\Http\Traits\customertrait;

class customer_complaints_sync implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, customertrait;
    protected $custid;
    protected $status;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($custid,$sapstatus)
    {
        $this->custid = $custid;
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
            Log::info('Customer Complaints processed '.$this->custid);
            $sapdata = $this->customer_complaints_job($this->custid);

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
                     
                      $getcomplaints = DB::connection('mysql3')->table('complaints')->where('customer_id', '=', $this->custid)->get();
                      
                      
                      if(count($getcomplaints) > 0)
                      {
                        $getlistedarr1 = [];
                         foreach ($sap_compl as $sapcomplkey => $sapcomplvalue) {
                            array_push($getlistedarr1, $sapcomplvalue['Complaint_Number']);
                             foreach ($getcomplaints as $complkey => $complvalue) {
                             $projectname =  $complvalue->project;
                             $projectcomplaint =  $complvalue->complaint_no;
                             $projectcomplaintunit =  $complvalue->unit;
                             //dd($projectname);

                             if (($projectname == $sapcomplvalue['Project_Name'])&&($projectcomplaint == $sapcomplvalue['Complaint_Number'])&&($projectcomplaintunit == $sapcomplvalue['Unit_Number'])) {

                                if ($sapcomplvalue['Scheduled_Date'] == '00000000') {
                                    $sapcomplvalue['Scheduled_Date'] = null;
                                }
                                else{
                                    $sapcomplvalue['Scheduled_Date'] = substr($sapcomplvalue['Scheduled_Date'],0,4)."-".substr($sapcomplvalue['Scheduled_Date'],4,2)."-".substr($sapcomplvalue['Scheduled_Date'],6,2);
                                }
                                if ($sapcomplvalue['Scheduled_Time'] == '000000') {
                                    $sapcomplvalue['Scheduled_Time'] = null;
                                }
                                else{
                                    $sapcomplvalue['Scheduled_Time'] = substr($sapcomplvalue['Scheduled_Time'],0,2).":".substr($sapcomplvalue['Scheduled_Time'],2,2).":".substr($sapcomplvalue['Scheduled_Time'],4,2);
                                }
                                 
                                 DB::connection('mysql3')->table('complaints')->where('customer_id', '=', $this->custid)
                                 ->where('project','=',$projectname)
                                 ->where('complaint_no','=',$projectcomplaint)
                                 ->where('unit','=',$projectcomplaintunit)
                                 ->update(['nature' => $sapcomplvalue['Nature_Of_Complaint'],
                                 'vgn_status' => $sapcomplvalue['VGN_Status'],
                                 'cust_status' => $sapcomplvalue['Customer_Status'],
                                 'final_status' => $sapcomplvalue['Final_status'],
                                 'vgn_remarks' => $sapcomplvalue['VGN_Remarks'],
                                 'date' => substr($sapcomplvalue['Date_of_complaint_raised'],0,4)."-".substr($sapcomplvalue['Date_of_complaint_raised'],4,2)."-".substr($sapcomplvalue['Date_of_complaint_raised'],6,2),
                                 'Expecteddateofcomp' => substr($sapcomplvalue['Expected_Date'],0,4)."-".substr($sapcomplvalue['Expected_Date'],4,2)."-".substr($sapcomplvalue['Expected_Date'],6,2),
                                 'Scheduled_date' => $sapcomplvalue['Scheduled_Date'],
                                 'Scheduled_time' => $sapcomplvalue['Scheduled_Time'],
                                  ]);
                             }
                            
 
                             }
                             
                         }
                         if (!empty($getlistedarr1)) {DB::connection('mysql3')->table('complaints')->where(['customer_id' => $this->custid])->whereNotIn('complaint_no',$getlistedarr1)->update([
                            'vgn_status' => 'CLOSED',
                            'cust_status' => 'CLOSED',
                            'final_status' => 'CLOSED'
                        ]); }
                      }
            else{
                 if (!empty($sap_compl)) {
                            foreach ($sap_compl as $keynew1 => $valuenew1) {
                                if (!empty($valuenew1['Scheduled_Date'])) {
                                    $scheduledate = substr($valuenew1['Scheduled_Date'],0,4).'-'.substr($valuenew1['Scheduled_Date'],4,2).'-'.substr($valuenew1['Scheduled_Date'],6,2);
                                    if (!empty($valuenew1['Scheduled_Time'])) {
                                        $scheduletime = substr($valuenew1['Scheduled_Time'],0,2).':'.substr($valuenew1['Scheduled_Time'],2,2).':'.substr($valuenew1['Scheduled_Time'],4,2);
                                    }
                                    else{
                                        $scheduletime = null;
                                    }
                                }
                                else{
                                    $scheduledate = null;
                                    $scheduletime = null;
                                }
                                
                                DB::connection('mysql3')->table('complaints')->insert(['complaint_no' => $valuenew1['Complaint_Number'],
            'project' => 'VGND '.$valuenew1['Project_Name'],
            'unit' => $valuenew1['Unit_Number'],
            'customer_id' => $this->custid,
            'nature' => $valuenew1['Nature_Of_Complaint'],
            'description' => 'Technical issue. Mail to customer care to update.',
            'vgn_status' => $valuenew1['VGN_Status'],
            'cust_status' => $valuenew1['Customer_Status'],
            'final_status' => $valuenew1['Final_status'],
            'vgn_remarks' => $valuenew1['VGN_Remarks'],
             'date' => substr($valuenew1['Date_of_complaint_raised'],0,4).'-'.substr($valuenew1['Date_of_complaint_raised'],4,2).'-'.substr($valuenew1['Date_of_complaint_raised'],6,2),
             'created' => Carbon::now()->toDateTimeString(),
             'updated' => Carbon::now()->toDateTimeString(),
             'Expecteddateofcomp' => substr($valuenew1['Expected_Date'],0,4).'-'.substr($valuenew1['Expected_Date'],4,2).'-'.substr($valuenew1['Expected_Date'],6,2),
             'Scheduled_date' => $scheduledate,
             'Scheduled_time' => $scheduletime

              ]);

                            }
                        }
            }
                  }
                  else{
                    DB::connection('mysql3')->table('complaints')->where(['customer_id' => $this->custid])->update([
                        'vgn_status' => 'CLOSED',
                        'cust_status' => 'CLOSED',
                        'final_status' => 'CLOSED'
                    ]);
                  }

                  

        }
    

if ($this->status == "notpresentindb") {
    Log::info('Customer Complaints processed '.$this->custid);
            $sapdata = $this->customer_complaints_job($this->custid);
                
                
                 $nowdate = Carbon::now();
            

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
                    
                     $getcomplaints = DB::connection('mysql3')->table('complaints')->where('customer_id', '=', $this->custid)->get();
                     
                     
                     if(count($getcomplaints) > 0)
                     {
                        $getlistedarr = [];

                        foreach ($sap_compl as $sapcomplkey => $sapcomplvalue) {
                            array_push($getlistedarr, $sapcomplvalue['Complaint_Number']);
                            foreach ($getcomplaints as $complkey => $complvalue) {
                            $projectname =  $complvalue->project;
                            $projectcomplaint =  $complvalue->complaint_no;
                            $projectcomplaintunit =  $complvalue->unit;
                            //dd($projectname);
                            if (($projectname == $sapcomplvalue['Project_Name'])&&($projectcomplaint == $sapcomplvalue['Complaint_Number'])&&($projectcomplaintunit == $sapcomplvalue['Unit_Number'])) {

                                 if ($sapcomplvalue['Scheduled_Date'] == '00000000') {
                                    $sapcomplvalue['Scheduled_Date'] = null;
                                }
                                else{
                                    $sapcomplvalue['Scheduled_Date'] = substr($sapcomplvalue['Scheduled_Date'],0,4)."-".substr($sapcomplvalue['Scheduled_Date'],4,2)."-".substr($sapcomplvalue['Scheduled_Date'],6,2);
                                }
                                if ($sapcomplvalue['Scheduled_Time'] == '000000') {
                                    $sapcomplvalue['Scheduled_Time'] = null;
                                }
                                else{
                                    $sapcomplvalue['Scheduled_Time'] = substr($sapcomplvalue['Scheduled_Time'],0,2).":".substr($sapcomplvalue['Scheduled_Time'],2,2).":".substr($sapcomplvalue['Scheduled_Time'],4,2);
                                }
                                
                                DB::connection('mysql3')->table('complaints')->where('customer_id', '=', $this->custid)
                                ->where('project','=',$projectname)
                                ->where('complaint_no','=',$projectcomplaint)
                                ->where('unit','=',$projectcomplaintunit)
                                ->update(['nature' => $sapcomplvalue['Nature_Of_Complaint'],
                                'vgn_status' => $sapcomplvalue['VGN_Status'],
                                'cust_status' => $sapcomplvalue['Customer_Status'],
                                'final_status' => $sapcomplvalue['Final_status'],
                                'vgn_remarks' => $sapcomplvalue['VGN_Remarks'],
                                'date' => substr($sapcomplvalue['Date_of_complaint_raised'],0,4)."-".substr($sapcomplvalue['Date_of_complaint_raised'],4,2)."-".substr($sapcomplvalue['Date_of_complaint_raised'],6,2),
                                'Expecteddateofcomp' => substr($sapcomplvalue['Expected_Date'],0,4)."-".substr($sapcomplvalue['Expected_Date'],4,2)."-".substr($sapcomplvalue['Expected_Date'],6,2),
                                'Scheduled_date' => $sapcomplvalue['Scheduled_Date'],
                                'Scheduled_time' => $sapcomplvalue['Scheduled_Time']
                                 ]);
                            }
                           

                            }
                            
                        }
                        if (!empty($getlistedarr)) {DB::connection('mysql3')->table('complaints')->where(['customer_id' => $this->custid])->whereNotIn('complaint_no',$getlistedarr)->update([
                            'vgn_status' => 'CLOSED',
                            'cust_status' => 'CLOSED',
                            'final_status' => 'CLOSED'
                        ]); }
                     }
                     else{
                 if (!empty($sap_compl)) {
                            foreach ($sap_compl as $keynew1 => $valuenew1) {
                                if (!empty($valuenew1['Scheduled_Date'])) {
                                    $scheduledate = substr($valuenew1['Scheduled_Date'],0,4).'-'.substr($valuenew1['Scheduled_Date'],4,2).'-'.substr($valuenew1['Scheduled_Date'],6,2);
                                    if (!empty($valuenew1['Scheduled_Time'])) {
                                        $scheduletime = substr($valuenew1['Scheduled_Time'],0,2).':'.substr($valuenew1['Scheduled_Time'],2,2).':'.substr($valuenew1['Scheduled_Time'],4,2);
                                    }
                                    else{
                                        $scheduletime = null;
                                    }
                                }
                                else{
                                    $scheduledate = null;
                                    $scheduletime = null;
                                }
                                
                                DB::connection('mysql3')->table('complaints')->insert(['complaint_no' => $valuenew1['Complaint_Number'],
            'project' => 'VGND '.$valuenew1['Project_Name'],
            'unit' => $valuenew1['Unit_Number'],
            'customer_id' => $this->custid,
            'nature' => $valuenew1['Nature_Of_Complaint'],
            'description' => 'Technical issue. Mail to customer care to update.',
            'vgn_status' => $valuenew1['VGN_Status'],
            'cust_status' => $valuenew1['Customer_Status'],
            'final_status' => $valuenew1['Final_status'],
            'vgn_remarks' => $valuenew1['VGN_Remarks'],
             'date' => substr($valuenew1['Date_of_complaint_raised'],0,4).'-'.substr($valuenew1['Date_of_complaint_raised'],4,2).'-'.substr($valuenew1['Date_of_complaint_raised'],6,2),
             'created' => Carbon::now()->toDateTimeString(),
             'updated' => Carbon::now()->toDateTimeString(),
             'Expecteddateofcomp' => substr($valuenew1['Expected_Date'],0,4).'-'.substr($valuenew1['Expected_Date'],4,2).'-'.substr($valuenew1['Expected_Date'],6,2),
             'Scheduled_date' => $scheduledate,
             'Scheduled_time' => $scheduletime

              ]);

                            }
                        }
            }
                 }
                 else{
                    DB::connection('mysql3')->table('complaints')->where(['customer_id' => $this->custid])->update([
                        'vgn_status' => 'CLOSED',
                        'cust_status' => 'CLOSED',
                        'final_status' => 'CLOSED'
                    ]);
                 }

        }
    }
    
    }


}
