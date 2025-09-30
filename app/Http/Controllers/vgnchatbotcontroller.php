<?php

namespace vgn\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use vgn\lead_data;
use vgn\projectlist;
use Carbon\Carbon;

class vgnchatbotcontroller extends Controller
{
    public function postlead()
    {

        if (count($_REQUEST) > 0) {
            
            $apikey = $_REQUEST['key'];
            $source = $_REQUEST['source'];
            $name = preg_replace("/[^A-Za-z.?! ]/","",$_REQUEST['name']);
            $location = $_REQUEST['location'];
            $mobileno = $_REQUEST['mobileno'];
            $project_name = $_REQUEST['project_name'];
            $emailid = $_REQUEST['emailid'];
            $budget_range = $_REQUEST['budget_range'];
            //VgnChatboT@123*
            if ($_REQUEST['key'] == '$2y$08$Z7T3kdJnYq/VUX6Hl5uvEu3R9.7TEm3Ssw1mFJzNs4Quig.om3nqS') {

                $removevgn_name = str_replace('VGN ', '',$project_name);
                $newlist =  projectlist::where('Project_name','=',$removevgn_name)->get();

                $plantcode = '';
                $projectid = '';
                if (count($newlist) > 0) {
                    foreach ($newlist as $key => $value) {
                        $projectid = $value->id;
                        if (!empty($value->plantcode)) {
                            $plantcode = $value->plantcode;
                        }
                    }
                }

                $digits = 3;
                    $pid_1 = rand(pow(10, $digits-1), pow(10, $digits)-1);
                    $pid_2 = Carbon::now()->format('YmdHis');
                    $campaignsource = '';
                        if ($source == 'web') {
                            $campaignsource = 'WEBSITE CHATBOT MASTER';
                        }

                        if ($source == 'Facebook') {
                            $campaignsource = 'FACEBOOK CHATBOT MASTER';
                        }

                        if ($source == 'Twitter') {
                            $campaignsource = 'TWITTER CHATBOT MASTER';
                        }

                if (!empty($projectid)) {
                    

                    if (!empty($plantcode)) {
                        
                        
                    
                    $getproject = DB::connection('mysql2')->table("campaignprocess")->where([
                        'Campaign_name' => $campaignsource,
                        'Plant_code' => $plantcode
                    ])->get();
                    if (count($getproject) > 0) {
                        
                        foreach ($getproject as $key1 => $value1) {
                            
                                $camp_code = $value1->Campaign_code;
                                $table_name = $value1->Campaign_code.'_'.$value1->Plant_code;
                                
                                $newproj_name = str_replace('VGN', 'VGND',$project_name);

                                DB::connection('mysql2')->table("$table_name")->insert([
                                    'id'=>null,
                                    'PID' => $pid_1.$pid_2,
                                    'Project_name' => $newproj_name,
                                    'Name' => $name,
                                    'Email' => $emailid,
                                    'Mobile' => $mobileno,
                                    'City' => 'None',
                                    'msg'=> 'None',
                                    'lead_datetime' => Carbon::now()->toDateTimeString(),
                                    'inserteddate' => Carbon::now()->toDateTimeString()
                                ]);

                            
                        }
                    }
                

                    }


                    //lead_common_table
                    if (empty($plantcode)) {
                        $plantcode = null;
                    }

                    $lead = new lead_data();
                $lead->Project_id = $projectid;
                $lead->PID = $pid_1.$pid_2;
                $lead->Project_name = $removevgn_name;
                $lead->Source_type = $campaignsource;
                $lead->Name = $name;
                $lead->Email = $emailid;
                $lead->Mobile = $mobileno;
                $lead->City = 'None';
                $lead->msg = null;
                $lead->lead_datetime = date('Y-m-d H:i:s');
                $lead->plantcode = $plantcode;
                $lead->google_campaigncode = null;
                $lead->facebook_campaigncode = null;
                $lead->linkedin_campaigncode = null;
                $lead->website_campaigncode = null;
                $lead->mobile_campaigncode = null;
                $lead->created_at = date('Y-m-d H:i:s');
                $lead->updated_at = date('Y-m-d H:i:s');
                $lead->save();


                }



                DB::connection('mysql2')->table("vgnchatbot_leads")->insert([
                    'source' => $_REQUEST['source'],
            'name' => $_REQUEST['name'],
            'location' => $_REQUEST['location'],
            'mobileno' => $_REQUEST['mobileno'],
            'project_name' => $_REQUEST['project_name'],
            'emailid' => $_REQUEST['emailid'],
            'budget_range' => $_REQUEST['budget_range'],
            'msg_string' => json_encode($_REQUEST),
            'created_datetime' => Carbon::now()->toDateTimeString()
                ]);

                return json_encode(['message' => 'Success', 'status' => 200]);
            }
            else{
                return json_encode(['message' => 'Invalid Api Key', 'status' => 404]);
            }

        }
        else{
            abort(403, 'Unauthorized action.');
        }
    }

public function acceptname()
    {
	$_REQUEST['name'] = preg_replace("/[^A-Za-z.?! ]/","", $_REQUEST['name']);
        if ((strlen($_REQUEST['name']) > 2) && (strlen($_REQUEST['name']) <= 30)) {
            $response = "Welcome ".$_REQUEST['name'].", We're happy to serve you. May I have your phone number please?";
            return $response;
        }
        else{
            return 0;
        }
        
    }

    public function gettypelocations()
    {
        if (($_REQUEST['projecttype_intrested'] == 'Apartments') || ($_REQUEST['projecttype_intrested'] == 'Plots')) {
            $type = $_REQUEST['projecttype_intrested'];
            $getmatchlist =  DB::table('projectlist')->select('Location')->distinct()->where(['Type' => "$type", 'Status' => 'Ongoing'])->orderBy('Location','asc')->get();
            $location_arr = $getmatchlist;
            

            return $location_arr;
        }
        else{
            return 0;
        }
    }

    public function getlocationprojectslist()
    {
        if (!empty($_REQUEST['projectlocationlist_intrested']) && !empty($_REQUEST['projecttype'])) {
            $locationlist = $_REQUEST['projectlocationlist_intrested'];
            $projecttype = $_REQUEST['projecttype'];
            $getmatchlist =  DB::table('projectlist')->select('Project_name')->distinct()->where(['Location' => "$locationlist",'Type'=> "$projecttype", 'Status' => 'Ongoing'])->orderBy('Project_name','asc')->get();
            $projectname_arr = $getmatchlist;
            

            return $projectname_arr;
        }
        else{
            return 0;
        }
    }

    public function submitprojectslist()
    {
        if (!empty($_REQUEST['projectlocationlist_intrested']) && !empty($_REQUEST['projecttype']) && !empty($_REQUEST['projectinterested'])) {
            $locationlist = $_REQUEST['projectlocationlist_intrested'];
            $projecttype = $_REQUEST['projecttype'];
            $projectinterested = $_REQUEST['projectinterested'];
            $getmatchlist =  DB::table('projectlist')->select('Project_name')->distinct()->where(['Project_name' => "$projectinterested",'Location' => "$locationlist",'Type'=> "$projecttype", 'Status' => 'Ongoing'])->orderBy('Project_name','asc')->get();
            if (count($getmatchlist) > 0) {
                return 1;    
            }
            else{
                return 0;
            }
            
            
        }
        else{
            return 0;
        }
    }

    public function submitemailandclose()
    {
        if (!empty($_REQUEST['projectlocationlist_intrested']) && !empty($_REQUEST['projecttype']) && !empty($_REQUEST['projectinterested'])&& !empty($_REQUEST['name']) && !empty($_REQUEST['email']) && !empty($_REQUEST['mobile']) && !empty($_REQUEST['budget_range'])) {
            $locationlist = $_REQUEST['projectlocationlist_intrested'];
            $projecttype = $_REQUEST['projecttype'];
            $projectinterested = $_REQUEST['projectinterested'];
            $name = $_REQUEST['name'];
            $email = $_REQUEST['email'];
            $mobile = $_REQUEST['mobile'];
            $budget_range = $_REQUEST['budget_range'];
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return 0;
                }

            $getmatchlist =  DB::table('projectlist')->select('Project_name')->distinct()->where(['Project_name' => "$projectinterested",'Location' => "$locationlist",'Type'=> "$projecttype", 'Status' => 'Ongoing'])->get();
            if (count($getmatchlist) > 0) {
                $source = 'web';
               $data = $this->postleadscustom($source,$name,$locationlist,$mobile,$projectinterested,$email,$budget_range);
               return 1;
            }
            else{
                return 0;
            }
            
            
        }
        else{
            return 0;
        }
    }

    public function postleadscustom($source,$name,$locationlist,$mobile,$projectinterested,$email,$budget_range)
    {
            
            $location = $locationlist;
            $mobileno = $mobile;
            $project_name = 'VGN '.$projectinterested;
            $emailid = $email;
            $budget_range = $budget_range;
            //VgnChatboT@123*
            if (($location != '') && ($mobileno != '') && ($project_name != '') && ($emailid != '') && ($budget_range != '')) {

                $removevgn_name = str_replace('VGN ', '',$project_name);
                $newlist =  projectlist::where('Project_name','=',$removevgn_name)->get();

                $plantcode = '';
                $projectid = '';
                if (count($newlist) > 0) {
                    foreach ($newlist as $key => $value) {
                        $projectid = $value->id;
                        if (!empty($value->plantcode)) {
                            $plantcode = $value->plantcode;
                        }
                    }
                }

                $digits = 3;
                    $pid_1 = rand(pow(10, $digits-1), pow(10, $digits)-1);
                    $pid_2 = Carbon::now()->format('YmdHis');
                    $campaignsource = '';
                        if ($source == 'web') {
                            $campaignsource = 'WEBSITE CHATBOT MASTER';
                        }

                        if ($source == 'Facebook') {
                            $campaignsource = 'FACEBOOK CHATBOT MASTER';
                        }

                        if ($source == 'Twitter') {
                            $campaignsource = 'TWITTER CHATBOT MASTER';
                        }

                if (!empty($projectid)) {
                    

                    if (!empty($plantcode)) {
                        
                        
                    
                    $getproject = DB::connection('mysql2')->table("campaignprocess")->where([
                        'Campaign_name' => $campaignsource,
                        'Plant_code' => $plantcode
                    ])->get();
                    if (count($getproject) > 0) {
                        
                        foreach ($getproject as $key1 => $value1) {
                            
                                $camp_code = $value1->Campaign_code;
                                $table_name = $value1->Campaign_code.'_'.$value1->Plant_code;
                                
                                $newproj_name = str_replace('VGN', 'VGND',$project_name);

                                DB::connection('mysql2')->table("$table_name")->insert([
                                    'id'=>null,
                                    'PID' => $pid_1.$pid_2,
                                    'Project_name' => $newproj_name,
                                    'Name' => $name,
                                    'Email' => $emailid,
                                    'Mobile' => $mobileno,
                                    'City' => 'None',
                                    'msg'=> 'None',
                                    'lead_datetime' => Carbon::now()->toDateTimeString(),
                                    'inserteddate' => Carbon::now()->toDateTimeString()
                                ]);

                            
                        }
                    }
                

                    }


                    //lead_common_table
                    if (empty($plantcode)) {
                        $plantcode = null;
                    }

                    $lead = new lead_data();
                $lead->Project_id = $projectid;
                $lead->PID = $pid_1.$pid_2;
                $lead->Project_name = $removevgn_name;
                $lead->Source_type = $campaignsource;
                $lead->Name = $name;
                $lead->Email = $emailid;
                $lead->Mobile = $mobileno;
                $lead->City = 'None';
                $lead->msg = null;
                $lead->lead_datetime = date('Y-m-d H:i:s');
                $lead->plantcode = $plantcode;
                $lead->google_campaigncode = null;
                $lead->facebook_campaigncode = null;
                $lead->linkedin_campaigncode = null;
                $lead->website_campaigncode = null;
                $lead->mobile_campaigncode = null;
                $lead->created_at = date('Y-m-d H:i:s');
                $lead->updated_at = date('Y-m-d H:i:s');
                $lead->save();


                }



                DB::connection('mysql2')->table("vgnchatbot_leads")->insert([
                    'source' => $source,
            'name' => $name,
            'location' => $location,
            'mobileno' => $mobileno,
            'project_name' => $project_name,
            'emailid' => $emailid,
            'budget_range' => $budget_range,
            'msg_string' => 'Internal VGN Request',
            'created_datetime' => Carbon::now()->toDateTimeString()
                ]);

                return 1;
            }
            else{
                return 0;
            }

        
    }

    
}
