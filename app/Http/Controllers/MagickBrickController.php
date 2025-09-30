<?php

namespace vgn\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use vgn\Http\Controllers\CommonLeadController;
use Illuminate\Support\Facades\Log;

class MagickBrickController extends Controller
{
    private $commonLeadController;
    public function __construct(CommonLeadController $commonLeadController)
    {
        $this->commonLeadController = $commonLeadController;
    }

    public function postdata(Request $request)
    {
        
        if (($_REQUEST['LoginID'] == 'vgnmagicbricks')&&($_REQUEST['key'] == '102bc76b10fff6f32dc6d87d1da13e69e63545a7')) {
            $logData = "\n" . json_encode([
                'date' => now(),
                'url' => request()->fullUrl(),
                'GET_parameters' => request()->all(),
            ]);
            
            Log::info($logData);
            
            $key = $_REQUEST['key'];
            
            //$campaigncode = $_REQUEST['campaigncode'];
            $leaduniqueId = $_REQUEST['leaduniqueId'];
            $ProjectId = $_REQUEST['ProjectId'];
            $projectType = 'VGN FAIRMONT';
            $enquirySourceId = 62;
            $interestedIn=null;
            
            $MobileNo = $_REQUEST['cCode'].$_REQUEST['MobileNo'];
            $ccode = $_REQUEST['cCode'];
            $Mobile = $_REQUEST['MobileNo'];
            $email = $_REQUEST['EmailID'];
            $Name = preg_replace("/[^A-Za-z.?! ]/","",$_REQUEST['Name']);
            $msg = $_REQUEST['msg'];
            
            if ($ProjectId == '93501') {
                if (strpos($msg, '5 BHK') !== false) {
                    $interestedIn = 'Fairmont Duplex';
                }
            } else if ($ProjectId == '171425') {
                $projectType = 'VGN KENSINGTON TOWERS';
            } else if ($ProjectId == '172543') {
                $projectType = 'VGN MARBLE ARCH';
            }

            $in4status = $this->commonLeadController->commonLeadData($Name,$email,$Mobile,$enquirySourceId,$projectType,$ccode,$interestedIn);
            // dd($in4status);
        
            if ((isset($_REQUEST['key']) != '')&&(isset($_REQUEST['ProjectId']) != '')&&(isset($_REQUEST['leaduniqueId']) != '')&&(isset($_REQUEST['MobileNo']) != '')&&(isset($_REQUEST['EmailID']) != '')&&(isset($_REQUEST['Name']) != '')&&(isset($_REQUEST['msg']) != '')&&(isset($_REQUEST['Date']) != '')&&(isset($_REQUEST['Time']) != '')) {
                //echo 'Success';
                
            }
            else{
                echo 'Not valid Paramters passed';
                die();
            }
        
            
        
            $leaddatetime = substr($_REQUEST['Date'],0,4).'-'.substr($_REQUEST['Date'],4,2).'-'.substr($_REQUEST['Date'],6,2).' '.substr($_REQUEST['Time'],0,2).':'.substr($_REQUEST['Time'],2,2).':'.substr($_REQUEST['Time'],4,2);
            
            $vendorname = "MAGICBRICKS";
            $getconnecting_code = DB::connection('mysql2')->table('api_connecting_code')->where(
                [
                    'vendorcode' => $ProjectId,
                    'vendorname' => $vendorname,
                ])->get();
                $Campaigncode = '';
                if (count($getconnecting_code) == 1) {
                    if ($ProjectId == '93501') {
                        if ($projectType == 'VGN Fairmont Duplex') 
                        {
                            $Campaigncode = '0000002761'; // Duplex
                        } else 
                        {
                            $Campaigncode = '0000002138'; // Apartment
                        }
                    } else if($ProjectId == '171425') {
                        $Campaigncode = '0000002841'; // KT
                    } else
                    {
                        foreach ($getconnecting_code as $key => $value) {
                            $Campaigncode = $value->vgncampaigncode;
                        }
                    }
                }
                // dd($Campaigncode);

                if ($Campaigncode != '') {
                    
                    $get_table_data = DB::connection('mysql2')->table('campaignprocess')->where(['Campaign_code' => $Campaigncode])->get();
                    if (count($get_table_data) > 0) {
                        foreach ($get_table_data as $key1 => $value1) {
                            $table_name = $value1->Campaign_code.'_'.$value1->Plant_code;
                            $plantname = $value1->Plant_name;
                            $splitdate = explode(" ",$leaddatetime);
                            $lead_date = str_replace("-","",$splitdate[0]);
                            $lead_time = str_replace(":","",$splitdate[0]);
                            //$mob = str_replace('+', '', $MobileNo);
                            //$mob = str_replace('-', '', $mob);
                            $mob = $MobileNo;
                            $pid = $leaduniqueId;

                            $checkpid = DB::connection('mysql2')->table("$table_name")->where(['PID' => $pid])->get();
                            if (count($checkpid) == 0) {
                                DB::connection('mysql2')->table("$table_name")->insert([
                                    'PID' => $pid,
                                    'Project_name' => $plantname,
                                    'Name' => strtoupper($Name),
                                    'Email' => $email,
                                    'Mobile' => $mob,
                                    'City' => 'None' ,
                                    'msg' => $msg,
                                    'lead_datetime' => $leaddatetime,
                                    'inserteddate' => Carbon::now()->toDateTimeString()
                                    ]);

                                    echo 'Success';
                                    die();
                            }
                            else{
                                echo 'Lead '.$pid.' already exists!';
                                die();
                            }
                        }
                        echo json_encode($get_table_data);
                        
                    }
                    die();

                }
                else{
                    echo 'ProjectId Not Matching with VGN Campaign Code!';
                    die();
                }




            $get_campaigncode = $process_to->getcampaignprocess($campaigncode);
                
            if (count($get_campaigncode) > 0) {
                
                foreach ($get_campaigncode as $codekey => $codevalue) {
                    $replacename = $codevalue['Plant_name'];
                    
                    
                        $splitdate = explode(" ",$leaddatetime);
                        $lead_date = str_replace("-","",$splitdate[0]);
                        $lead_time = str_replace(":","",$splitdate[0]);
                        
                        //$mob = str_replace('+', '', $MobileNo);
                        //$mob = str_replace('-', '', $mob);
                        $mob = $MobileNo;
                        $pid = $leaduniqueId;
        
                    $table_name = $codevalue['Campaign_code'].'_'.$codevalue['Plant_code'];
                    
                
                    $test = $process_to->insertleadindb($table_name,$Name, $email, $mob,$lead_date, $lead_time, $pid, $replacename,$msg, $leaddatetime);
        
                    echo $test;
                    
                }	
            }
            else
            {
                echo 'Not valid campaign code';
            }
        
        }
    }


    public function gettablename($ProjectId_from_vendor)
    {
        if (!empty($ProjectId_from_vendor)) {
            
            $getlast10applications = DB::connection('mysql2')->table('leave_processed')->where('employeeid', '=', $employeeid)->orderBy('created_date', 'desc')->take(10)->get();
        }
    }
}
