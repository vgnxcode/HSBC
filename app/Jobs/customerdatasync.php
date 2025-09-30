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
use vgn\Http\Traits\customertrait;

class customerdatasync implements ShouldQueue
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
        Log::info('Customer Login Sync Started'.$this->custid.'  --- '.$this->status);
        if ($this->status == "presentindb") {
            Log::info('Customer Login '.$this->custid.' - present in db');
            $sapdata = $this->getCustomer($this->custid);
            
            if($sapdata['Customer_Name'] != '')
                {
 $sap_proj = array();
                    if (!array_key_exists('Project_Detail', $sapdata)) {
                      DB::connection('mysql3')->table('customer')->where('id','=',$this->custid)->delete();
                      
                        session()->flash("error_msg", "Project details not available!");
                        return redirect()->back()->withInput();
                    }
                    
                    $sapprojects = $sapdata['Project_Detail'];
                    if (array_key_exists('0', $sapprojects)) {
                        $sap_proj = $sapprojects;
                    }
                    else
                    {
                        $sap_proj[0] = $sapprojects;
                    }
                    
                     $getprojects = DB::connection('mysql3')->table('projects')->where('cust_id', '=', $this->custid)->get();

                     if(count($getprojects) != 0)
                     {
                        foreach ($sap_proj as $sapprojkey1 => $sapprojvalue1) {

                            
                                     
                    $getinspection1 = $this->get_inspection_snag($this->custid, $sapprojvalue1['Unit'], $sapprojvalue1['Plant']);        

                    
                    $sap_inspect1 = array();
                    $sapinspectionsnag1 = $getinspection1['Data'];
                    if (array_key_exists('0', $sapinspectionsnag1)) {
                        $sap_inspect1 = $sapinspectionsnag1;
                    }
                    else
                    {
                        if(($sapinspectionsnag1['Unique_No'] != '') && $sapinspectionsnag1['Unit_no'] != ''){
                        $sap_inspect1[0] = $sapinspectionsnag1;
                        }
                    }

                    $inspectcount1 = count($sap_inspect1);
                    
                    if ($inspectcount1 == 0) {
                        $inspectcount1 = null;
                    }
                    $updatedinsp1 = DB::connection('mysql3')->table('projects')->where(['cust_id' => $this->custid,'project_id'=>$sapprojvalue1['Plant'],'unit'=>$sapprojvalue1['Unit'] ])->update(['snagcreatedbyuser' => $inspectcount1
                        ]);
                    
                    

                    if ($inspectcount1 > 0) {
                        DB::connection('mysql3')->table('inspection_snag')->where(['cust_id' => $this->custid ])->delete();
                        foreach ($sap_inspect1 as $sapinskey1 => $sapinsvalue1) {
                        
                        if ($sapinsvalue1['Unique_No'] != '') {
                            
                            $checkinspectindb1 = DB::connection('mysql3')->table('inspection_snag')->where(['cust_id' => $this->custid,'project_id'=>$sapinsvalue1['Plant_code'],'unit_no'=>$sapinsvalue1['Unit_no'],'uniqueno'=>$sapinsvalue1['Unique_No'] ])->count();        
                            if($sapinsvalue1['Indicator'] == 'X'){ $sapinsvalue1['Indicator'] = 'CLOSED';}else{$sapinsvalue1['Indicator'] = 'OPEN';}
                            if($checkinspectindb1 != 0){

                                
                                DB::connection('mysql3')->table('inspection_snag')->insert(['cust_id' => $this->custid,
                                'project_id'=>$sapinsvalue1['Plant_code'],
                                'unit_no'=>$sapinsvalue1['Unit_no'],
                                'uniqueno'=>$sapinsvalue1['Unique_No'],
                                'snag_desc'=>$sapinsvalue1['Inspection_Snag'],
                                'snag_created_date'=> substr($sapinsvalue1['Created_Date'],0,4).'-'.substr($sapinsvalue1['Created_Date'],4,2).'-'.substr($sapinsvalue1['Created_Date'],6,2).' '.substr($sapinsvalue1['Time'],0,2).':'.substr($sapinsvalue1['Time'],2,2).':'.substr($sapinsvalue1['Time'],4,2),
                                'vgn_status' => $sapinsvalue1['Indicator'],
                                'Expecteddateofcomp' => substr($sapinsvalue1['Expected_Date'],0,4).'-'.substr($sapinsvalue1['Expected_Date'],4,2).'-'.substr($sapinsvalue1['Expected_Date'],6,2)
                                 ]);
                            }
                            else{
                                DB::connection('mysql3')->table('inspection_snag')->insert(['cust_id' => $this->custid,
                                'project_id'=>$sapinsvalue1['Plant_code'],
                                'unit_no'=>$sapinsvalue1['Unit_no'],
                                'snag_desc'=>$sapinsvalue1['Inspection_Snag'],
                                'uniqueno'=>$sapinsvalue1['Unique_No'],
                                'snag_created_date'=> substr($sapinsvalue1['Created_Date'],0,4).'-'.substr($sapinsvalue1['Created_Date'],4,2).'-'.substr($sapinsvalue1['Created_Date'],6,2).' '.substr($sapinsvalue1['Time'],0,2).':'.substr($sapinsvalue1['Time'],2,2).':'.substr($sapinsvalue1['Time'],4,2),
                                'vgn_status' => $sapinsvalue1['Indicator'],
                                'Expecteddateofcomp' => substr($sapinsvalue1['Expected_Date'],0,4).'-'.substr($sapinsvalue1['Expected_Date'],4,2).'-'.substr($sapinsvalue1['Expected_Date'],6,2)
                                 ]);
                            }
                        }
                    }

                    }//end of inspect count1 ifcond.
                    


                }
                     }
 if(count($getprojects) == 0)
                     {
                        foreach ($sap_proj as $sapprojkey => $sapprojvalue) {

                                                 
                    $getinspection = $this->get_inspection_snag($this->custid, $sapprojvalue['Unit'], $sapprojvalue['Plant']);        

                    
                    $sap_inspect = array();
                    $sapinspectionsnag = $getinspection['Data'];
                    if (array_key_exists('0', $sapinspectionsnag)) {
                        $sap_inspect = $sapinspectionsnag;
                    }
                    else
                    {
                        if(($sapinspectionsnag['Unique_No'] != '') && $sapinspectionsnag['Unit_no'] != ''){
                        $sap_inspect[0] = $sapinspectionsnag;
                            }
                    }

                    $inspectcount = count($sap_inspect);
                    
                    
                    DB::connection('mysql3')->table('projects')->insert(['cust_id' => $this->custid,
                                'pname' => $sapprojvalue['Plant_Name'],
                                'project_id' => $sapprojvalue['Plant'],
                                'unit' => $sapprojvalue['Unit'],
                                'unit_nm' => $sapprojvalue['Unit_Name'],
                                'milestone' => $sapprojvalue['Milestone'],
                                'posession' => $sapprojvalue['Possession'],
                                'snagcreatedbyuser' => null,
                                'projectlink' => $sapprojvalue['Link'],
                                ]);
                    
                        if ($inspectcount > 0) {
                            if ($sap_inspect[0]['Unique_No'] != '') {
                         DB::connection('mysql3')->table('projects')->where(['cust_id' => $this->custid,'project_id'=>$sap_inspect[0]['Plant_code'],'unit'=>$sap_inspect[0]['Unit_no'] ])->update(['snagcreatedbyuser' => $inspectcount]);
                     }
                        }
                     


                    
                    foreach ($sap_inspect as $sapinskey => $sapinsvalue) {
                        
                        if ($sapinsvalue['Unique_No'] != '') {
                            
                            $checkinspectindb = DB::connection('mysql3')->table('inspection_snag')->where(['cust_id' => $this->custid,'project_id'=>$sapinsvalue['Plant_code'],'unit_no'=>$sapinsvalue['Unit_no'],'uniqueno'=>$sapinsvalue['Unique_No'] ])->count();        
                            if($sapinsvalue['Indicator'] == 'X'){ $sapinsvalue['Indicator'] = 'CLOSED';}else{$sapinsvalue['Indicator'] = 'OPEN';}
                            if($checkinspectindb != 0){

                                DB::connection('mysql3')->table('inspection_snag')->where(['cust_id' => $this->custid,'project_id'=>$sapinsvalue['Plant_code'],'unit_no'=>$sapinsvalue['Unit_no'],'uniqueno'=>$sapinsvalue['Unique_No'] ])->delete();
                                DB::connection('mysql3')->table('inspection_snag')->insert(['cust_id' => $this->custid,
                                'project_id'=>$sapinsvalue['Plant_code'],
                                'unit_no'=>$sapinsvalue['Unit_no'],
                                'snag_desc'=>$sapinsvalue['Inspection_Snag'],
                                'uniqueno'=>$sapinsvalue['Unique_No'],
                                'snag_created_date'=> substr($sapinsvalue['Created_Date'],0,4).'-'.substr($sapinsvalue['Created_Date'],4,2).'-'.substr($sapinsvalue['Created_Date'],6,2).' '.substr($sapinsvalue['Time'],0,2).':'.substr($sapinsvalue['Time'],2,2).':'.substr($sapinsvalue['Time'],4,2),
                                'vgn_status' => $sapinsvalue['Indicator'],
                                'Expecteddateofcomp' => substr($sapinsvalue['Expected_Date'],0,4).'-'.substr($sapinsvalue['Expected_Date'],4,2).'-'.substr($sapinsvalue['Expected_Date'],6,2)
                                 ]);
                            }
                            else{
                                DB::connection('mysql3')->table('inspection_snag')->insert(['cust_id' => $this->custid,
                                'project_id'=>$sapinsvalue['Plant_code'],
                                'unit_no'=>$sapinsvalue['Unit_no'],
                                'snag_desc'=>$sapinsvalue['Inspection_Snag'],
                                'uniqueno'=>$sapinsvalue['Unique_No'],
                                'snag_created_date'=> substr($sapinsvalue['Created_Date'],0,4).'-'.substr($sapinsvalue['Created_Date'],4,2).'-'.substr($sapinsvalue['Created_Date'],6,2).' '.substr($sapinsvalue['Time'],0,2).':'.substr($sapinsvalue['Time'],2,2).':'.substr($sapinsvalue['Time'],4,2),
                                'vgn_status' => $sapinsvalue['Indicator'],
                                'Expecteddateofcomp' => substr($sapinsvalue['Expected_Date'],0,4).'-'.substr($sapinsvalue['Expected_Date'],4,2).'-'.substr($sapinsvalue['Expected_Date'],6,2)
                                 ]);
                            }
                        }
                    }
                            
                           
                        }
                     }


                     $sap_compl = array();
                     if (array_key_exists('Compliants', $sapdata)) {
                     
                     $sapcomplaints = $sapdata['Compliants'];
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

                  $sap_paym = array();
                  if (array_key_exists('Payment_History', $sapdata)) {
                  $sappayments = $sapdata['Payment_History'];
                  if (array_key_exists('0', $sappayments)) {
                      $sap_paym = $sappayments;
                  }
                  else
                  {
                      $sap_paym[0] = $sappayments;
                  }
                  //dd($sap_compl);
                   $getpayments = DB::connection('mysql3')->table('payments')->where('cust_id', '=', $this->custid)->get();
                   
                   if(count($getpayments) > 0)
                   {
                       DB::connection('mysql3')->table('payments')->where('cust_id', '=', $this->custid)->delete();
                       if (count($sap_paym) > 0) {
                       
                      foreach ($sap_paym as $sappaymkey => $sappaymvalue) {
                            DB::connection('mysql3')->table('payments')->insert(['cust_id' => $this->custid,
                              'posteddate' => substr($sappaymvalue['Posting_Date'],0,4)."-".substr($sappaymvalue['Posting_Date'],4,2)."-".substr($sappaymvalue['Posting_Date'],6,2),
                              'doc_no' => $sappaymvalue['Document_Number'],
                              'inv_amt' => str_replace('-','',$sappaymvalue['Invoice_Amount']),
                              'pay_type' => $sappaymvalue['Payment_Amount'],
                              'created' => Carbon::now(),
                              'updated' => Carbon::now()
                              ]);
                          
                      }

                      }
                   }
                   else{
                       if (count($sap_paym) > 0) {
                           foreach ($sap_paym as $sappaymkey => $sappaymvalue) {
                            DB::connection('mysql3')->table('payments')->insert(['cust_id' => $this->custid,
                              'posteddate' => substr($sappaymvalue['Posting_Date'],0,4)."-".substr($sappaymvalue['Posting_Date'],4,2)."-".substr($sappaymvalue['Posting_Date'],6,2),
                              'doc_no' => $sappaymvalue['Document_Number'],
                              'inv_amt' => str_replace('-','',$sappaymvalue['Invoice_Amount']),
                              'pay_type' => $sappaymvalue['Payment_Amount'],
                              'created' => Carbon::now(),
                              'updated' => Carbon::now()
                              ]);
                          
                      }
                       }

                   }
               }
}
        }
    

if ($this->status == "notpresentindb") {
    Log::info('Customer Login '.$this->custid.' - not present in db');
            $sapdata = $this->getCustomer($this->custid);
                
                
                 $nowdate = Carbon::now();
            
                 
                 if($sapdata['Customer_Name'] != '')
                 {
                     
                    
                    $sap_proj = array();
                    if (!array_key_exists('Project_Detail', $sapdata)) {
                      DB::connection('mysql3')->table('customer')->where('id','=',$this->custid)->delete();
                      
                        session()->flash("error_msg", "Project details not available!");
                        return redirect()->back()->withInput();
                    }
                    
                    $sapprojects = $sapdata['Project_Detail'];
                    if (array_key_exists('0', $sapprojects)) {
                        $sap_proj = $sapprojects;
                    }
                    else
                    {
                        $sap_proj[0] = $sapprojects;
                    }
                    
                     $getprojects = DB::connection('mysql3')->table('projects')->where('cust_id', '=', $this->custid)->get();

                     
                     if(count($getprojects) != 0)
                     {
                        foreach ($sap_proj as $sapprojkey => $sapprojvalue) {

                                                 
                    $getinspection = $this->get_inspection_snag($this->custid, $sapprojvalue['Unit'], $sapprojvalue['Plant']);        
                    
                    
                    $sap_inspect = array();
                    $sapinspectionsnag = $getinspection['Data'];
                    if (array_key_exists('0', $sapinspectionsnag)) {
                        $sap_inspect = $sapinspectionsnag;
                    }
                    else
                    {
                        if(($sapinspectionsnag['Unique_No'] != '') && $sapinspectionsnag['Unit_no'] != ''){
                        $sap_inspect[0] = $sapinspectionsnag;
                        }
                    }

                    $inspectcount = count($sap_inspect);
                    $expdt_of_comp = null;
                    $dlp_end_date = null;
                    if ($sapprojvalue['Exp_Dateof_Completion'] != '00000000') {
                        $expdt_of_comp = substr($sapprojvalue['Exp_Dateof_Completion'],0,4).'-'.substr($sapprojvalue['Exp_Dateof_Completion'],4,2).'-'.substr($sapprojvalue['Exp_Dateof_Completion'],6,2);
                    }

                    if ($sapprojvalue['DLP_End_Date'] != '00000000') {
                        $dlp_end_date = substr($sapprojvalue['DLP_End_Date'],0,4).'-'.substr($sapprojvalue['DLP_End_Date'],4,2).'-'.substr($sapprojvalue['DLP_End_Date'],6,2);
                    }
                    
                    
                    

                                if (!empty($sap_inspect)) {
                     if ($sap_inspect[0]['Unique_No'] != '') {
                         DB::connection('mysql3')->table('projects')->where(['cust_id' => $this->custid,'project_id'=>$sap_inspect[0]['Plant_code'],'unit'=>$sap_inspect[0]['Unit_no'] ])->update(['snagcreatedbyuser' => $inspectcount]);
                     }
                    }


                    
                    foreach ($sap_inspect as $sapinskey => $sapinsvalue) {
                        
                        if ($sapinsvalue['Unique_No'] != '') {
                            
                            $checkinspectindb = DB::connection('mysql3')->table('inspection_snag')->where(['cust_id' => $this->custid,'project_id'=>$sapinsvalue['Plant_code'],'unit_no'=>$sapinsvalue['Unit_no'],'uniqueno'=>$sapinsvalue['Unique_No'] ])->count();        
                            if($sapinsvalue['Indicator'] == 'X'){ $sapinsvalue['Indicator'] = 'CLOSED';}else{$sapinsvalue['Indicator'] = 'OPEN';}
                            if($checkinspectindb != 0){

                                DB::connection('mysql3')->table('inspection_snag')->where(['cust_id' => $this->custid,'project_id'=>$sapinsvalue['Plant_code'],'unit_no'=>$sapinsvalue['Unit_no'],'uniqueno'=>$sapinsvalue['Unique_No'] ])->delete();
                                DB::connection('mysql3')->table('inspection_snag')->insert(['cust_id' => $this->custid,
                                'project_id'=>$sapinsvalue['Plant_code'],
                                'unit_no'=>$sapinsvalue['Unit_no'],
                                'snag_desc'=>$sapinsvalue['Inspection_Snag'],
                                'uniqueno'=>$sapinsvalue['Unique_No'],
                                'snag_created_date'=> substr($sapinsvalue['Created_Date'],0,4).'-'.substr($sapinsvalue['Created_Date'],4,2).'-'.substr($sapinsvalue['Created_Date'],6,2).' '.substr($sapinsvalue['Time'],0,2).':'.substr($sapinsvalue['Time'],2,2).':'.substr($sapinsvalue['Time'],4,2),
                                'vgn_status' => $sapinsvalue['Indicator'],
                                'Expecteddateofcomp' => substr($sapinsvalue['Expected_Date'],0,4).'-'.substr($sapinsvalue['Expected_Date'],4,2).'-'.substr($sapinsvalue['Expected_Date'],6,2)
                                 ]);
                            }
                            else{
                                DB::connection('mysql3')->table('inspection_snag')->insert(['cust_id' => $this->custid,
                                'project_id'=>$sapinsvalue['Plant_code'],
                                'unit_no'=>$sapinsvalue['Unit_no'],
                                'snag_desc'=>$sapinsvalue['Inspection_Snag'],
                                'uniqueno'=>$sapinsvalue['Unique_No'],
                                'snag_created_date'=> substr($sapinsvalue['Created_Date'],0,4).'-'.substr($sapinsvalue['Created_Date'],4,2).'-'.substr($sapinsvalue['Created_Date'],6,2).' '.substr($sapinsvalue['Time'],0,2).':'.substr($sapinsvalue['Time'],2,2).':'.substr($sapinsvalue['Time'],4,2),
                                'vgn_status' => $sapinsvalue['Indicator'],
                                'Expecteddateofcomp' => substr($sapinsvalue['Expected_Date'],0,4).'-'.substr($sapinsvalue['Expected_Date'],4,2).'-'.substr($sapinsvalue['Expected_Date'],6,2)
                                 ]);
                            }
                        }
                    }
                            
                           
                        }
                     }


                    $sap_compl = array();
                    if (array_key_exists('Compliants', $sapdata)) {
                    
                    $sapcomplaints = $sapdata['Compliants'];
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
                    
                    

                    $sap_paym = array();
                    if (array_key_exists('Payment_History', $sapdata)) {
                    $sappayments = $sapdata['Payment_History'];
                    if (array_key_exists('0', $sappayments)) {
                        $sap_paym = $sappayments;
                    }
                    else
                    {
                        $sap_paym[0] = $sappayments;
                    }
                    //dd($sap_compl);
                     $getpayments = DB::connection('mysql3')->table('payments')->where('cust_id', '=', $this->custid)->get();
                     
                     if(count($getpayments) > 0)
                     {
                         DB::connection('mysql3')->table('payments')->where('cust_id', '=', $this->custid)->delete();
                         if (count($sap_paym) > 0) {
                         
                        foreach ($sap_paym as $sappaymkey => $sappaymvalue) {
                              DB::connection('mysql3')->table('payments')->insert(['cust_id' => $this->custid,
                                'posteddate' => substr($sappaymvalue['Posting_Date'],0,4)."-".substr($sappaymvalue['Posting_Date'],4,2)."-".substr($sappaymvalue['Posting_Date'],6,2),
                                'doc_no' => $sappaymvalue['Document_Number'],
                                'inv_amt' => str_replace('-','',$sappaymvalue['Invoice_Amount']),
                                'pay_type' => $sappaymvalue['Payment_Amount'],
                                'created' => Carbon::now(),
                                'updated' => Carbon::now()
                                ]);
                            
                        }

                        }
                     }
                     else{
                         if (count($sap_paym) > 0) {
                             foreach ($sap_paym as $sappaymkey => $sappaymvalue) {
                              DB::connection('mysql3')->table('payments')->insert(['cust_id' => $this->custid,
                                'posteddate' => substr($sappaymvalue['Posting_Date'],0,4)."-".substr($sappaymvalue['Posting_Date'],4,2)."-".substr($sappaymvalue['Posting_Date'],6,2),
                                'doc_no' => $sappaymvalue['Document_Number'],
                                'inv_amt' => str_replace('-','',$sappaymvalue['Invoice_Amount']),
                                'pay_type' => $sappaymvalue['Payment_Amount'],
                                'created' => Carbon::now(),
                                'updated' => Carbon::now()
                                ]);
                            
                        }
                         }

                     }
                 }
             }

        }


    }
}
