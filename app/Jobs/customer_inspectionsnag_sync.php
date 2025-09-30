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

class customer_inspectionsnag_sync implements ShouldQueue
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
            Log::info('Customer Inspection Snag processed '.$this->custid);
            $sapdata = $this->customerbasicinfo($this->custid);
            
            if($sapdata['Customer_Name'] != '')
                {
 $sap_proj = array();
                    
                    
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
 
}
        }
    

if ($this->status == "notpresentindb") {
    Log::info('Customer Inspection Snag processed '.$this->custid);
            $sapdata = $this->customerbasicinfo($this->custid);
            
                 
                 if($sapdata['Customer_Name'] != '')
                 {
                     
                    
                    $sap_proj = array();
                   
                    
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

                    
             }

        }


    }
}
