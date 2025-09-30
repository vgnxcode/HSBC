<?php

namespace vgn\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use vgn\lead_data;
use vgn\projectlist;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use File;

class FBchatbotController extends Controller
{

 public function single_link_parse_path_gen_link($path)
    {

        $directory = Storage::disk('s3')->files($path);

                $floorplanfiles = array();
                if(count($directory) > 0) {
                $planfiles = Storage::disk('s3')->files($path);
                return $planfiles[0];
                }
                else{
                    return 0;
                }

    }
    public function fbchat_step2()
    {
   /* 	$access_token = "EAAKEEz6ei1kBAFzbZCmZBrWl0Q1HemgBw1UxDdy7SKimVUvz2DZABCb3stdhOWgM8LetZCNXmuexsKNI47SkvG3HcQF7c1KWW9Ck8YKISdiEmmT8uXxF4OGJBimXTXHEyQgKgj51ZBrgLva9IXRZAKQRTyf38i7ZBka9DypuZAttVwZDZD";
$verify_token = "Vgnfb123";
$hub_verify_token = null;
if(isset($_REQUEST['hub_challenge'])) {
 $challenge = $_REQUEST['hub_challenge'];
 $hub_verify_token = $_REQUEST['hub_verify_token'];
}
if ($hub_verify_token === $verify_token) {
 echo $challenge;
}*/


$input = json_decode(file_get_contents('php://input'), true);
if (isset($input['entry'][0]['messaging'][0]['sender']['id'])) {
//Log::info('Facebook Msg '.json_encode($input));
    $sender = $input['entry'][0]['messaging'][0]['sender']['id']; //sender facebook id
    $message = $input['entry'][0]['messaging'][0]['message']['text']; //text that user sent
	//Log::info('Facebook Msg '.json_encode($input));
    $url = 'https://graph.facebook.com/v2.6/me/messages?access_token=EAAHgoEjQmLMBOwJdXPUUH5ki3aeq0FKqZCQWjWrZCLM8gbuk7ZAbvEuVxBZCwvm80ZAKYZAwUTi6UFFZCbYrXeaTR78FRafqwKugTZCzlFZCq0cmNohkVHuJAAwGCXo2Wi0sZCbkNkxMScMpfEpN6Id1DgSmDac55k5DGruyfNHcb0OQUAQ6ZCAwtOb903nJEz14THRHBguC0LZB4ZCAYp9G1O2b4wRn1ZAW0ZD';

    
    /*initialize curl*/
    $ch = curl_init($url);
    /*prepare response*/
    $jsonData = '{
    "recipient":{
        "id":"' . $sender . '"
        },
        "message":{
            "text":"Hi I\'m your VGN Assistant. May I know your name please?"
        }
    }';
    /* curl setting to send a json post data */
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    if (!empty($message)) {
        $result = curl_exec($ch); // user will get the message
    }
}
    }



public function acceptname($name)
    {
	$name = preg_replace("/[^A-Za-z.?! ]/","", $name);
        if ((strlen($name) > 2) && (strlen($name) <= 30)) {
            $response = "Welcome ".$name.", We\'re happy to serve you. May I have your phone number please?";
            return $response;
        }
        else{
            return 0;
        }
        
    }

public function fbchat_step1()
{
	$input = json_decode(file_get_contents('php://input'), true);
	
		Log::info($input);
	
	$sender = $input['entry'][0]['messaging'][0]['sender']['id']; //sender facebook id


if (array_key_exists('postback', $input['entry'][0]['messaging'][0])) {
        if (array_key_exists('payload', $input['entry'][0]['messaging'][0]['postback'])) {
            if ($input['entry'][0]['messaging'][0]['postback']['payload'] == 'vgn first handshake') {
                DB::connection('mysql')->table('facbook_bot')->where(['senderid' => $sender])->delete();
            }
        }
    }

/*$prevcheck = DB::connection('mysql')->table('facbook_bot')->where(['senderid' => $sender])->get();
if (count($prevcheck) > 0) {
    foreach ($prevcheck as $keycheck => $valuecheck) {
        $get_createdtime_plus30min = Carbon::parse($valuecheck->created_time)->addMinutes(30)->toDateTimeString();
    }
    if (Carbon::now()->gt(Carbon::parse($get_createdtime_plus30min))) {
        DB::connection('mysql')->table('facbook_bot')->where(['senderid' => $sender])->delete();
    }
    
}*/

$getsender = DB::connection('mysql')->table('facbook_bot')->where(['senderid' => $sender])->get();

$instep = 0;
if (count($getsender) > 0) {
	foreach ($getsender as $key => $value) {
		$instep = $value->instep;
		$mysql_name =$value->name;
		$mysql_type =$value->type;
		$mysql_location = $value->location;
		$mysql_mobile = $value->mobilenumber;
		$mysql_project = $value->project;
		$mysql_budget = $value->budg_range;
		$mysql_id = $value->projectid;
	}
}


if (array_key_exists('message',$input['entry'][0]['messaging'][0]) || array_key_exists('postback',$input['entry'][0]['messaging'][0])) {
	
$stepgetstarted = 0;
    if (array_key_exists('postback', $input['entry'][0]['messaging'][0])) {
        if (array_key_exists('payload', $input['entry'][0]['messaging'][0]['postback'])) {
            if ($input['entry'][0]['messaging'][0]['postback']['payload'] == 'vgn first handshake') {
                $stepgetstarted = 1;
            }
        }
    }
	
if ($instep == 6){
	$message = $input['entry'][0]['messaging'][0]['postback']['payload']; //text from the user sent

}
else{
    if ($stepgetstarted == 1) {
        $message = "Get Started";
    }
    else{
    	if (array_key_exists('text', $input['entry'][0]['messaging'][0]['message'])) {
            $message = $input['entry'][0]['messaging'][0]['message']['text']; //text from the user sent
        }
        else{
            die();
            exit();
        }

        }
	}

    if ($instep == 0) {
    	$replymsg = "Hi I\'m your VGN Assistant. May I know your name please?";
    	 
        DB::connection('mysql')->table('facbook_bot')->insert(['id' => null,'senderid' => $sender,'name'=>null,'mobilenumber'=>null,'type'=>null,'budg_range'=>null,'location'=>null,'project'=>null,'projectid' => null,'emailid'=>null,'instep'=>1,'created_time'=>Carbon::now()->toDateTimeString()]);
        
    }

    if ($instep == 1) {
    	
$name = preg_replace("/[^A-Za-z.?! ]/","", $message);
        if ((strlen($name) > 2) && (strlen($name) <= 30)) {
            $replymsg = "Welcome ".$name.", We\'re happy to serve you. May I have your phone number please?";
    	 	DB::connection('mysql')->table('facbook_bot')->where(['senderid' => $sender])->update(['name'=>trim($message),'instep'=>2]);
        }
        else{
            $replymsg = "Please enter a valid name";
        }

    	
    }
$apartmentplotstep = 0;

    if ($instep == 2) {
    	
    	$mobileregex = "/^[6-9][0-9]{9}$/" ;  
if(preg_match($mobileregex, $message) === 1)
{
        
            $replymsg = $mysql_name.", are you interested in buying Apartments or Plots?";
    	 	DB::connection('mysql')->table('facbook_bot')->where(['senderid' => $sender])->update(['mobilenumber'=>trim($message),'instep'=>3]);
    	 	$apartmentplotstep = 1;
        }
        else{
            $replymsg = "Please enter a valid 10 digit mobile number.";
            $apartmentplotstep = 0;
        }

    	
    }


    if ($instep == 3) {
    	$apartorplots_arr = ["Apartments",  "Plots"];
    	if (!in_array($message, $apartorplots_arr)) {
    		$replymsg = "Please select apartments or plots option.";
    		$apartmentplotstep = 0;
    	}
    	else{
    		$replymsg = $mysql_name.", May I know your budget range please?";
    	 	DB::connection('mysql')->table('facbook_bot')->where(['senderid' => $sender])->update(['type'=>trim($message),'instep'=>4]);
    	 	$apartmentplotstep = 1;
    	}
    }


    if ($instep == 4) {
    	$budgetrange_arr = ["Upto 20 Lakhs",  "Upto 40 Lakhs","Upto 60 Lakhs","Upto 80 Lakhs","Upto 1 Crore","Upto 3 Crore","Upto 5 Crore","Upto 10 Crore","Above 10 Crore"];
    	if (!in_array($message, $budgetrange_arr)) {
    		$replymsg = "Please select the given budget range options.";
    		$budgetrangestep = 0;
    	}
    	else{
    		$msg1 = $mysql_name.", In which location would you like to buy?";
    		$getlocation = DB::table('projectlist')->select('Location')->distinct()->where(['Type' => "$mysql_type", 'Status' => 'Ongoing'])->orderBy('Location','asc')->get();
    		$contenttype = '';
	if (count($getlocation) > 0) {
		$i = 1;
		foreach ($getlocation as $valueloc) {
			$contenttype .= '\n'.$i.'.  '.$valueloc->Location;
			$i++;
		}
	}
	$replymsg = $msg1.$contenttype.'\n(Enter the serial number for the selected option.)';
    	 	DB::connection('mysql')->table('facbook_bot')->where(['senderid' => $sender])->update(['budg_range'=>trim($message),'instep'=>5]);
    	 	
    	 	$budgetrangestep = 1;
    	}
    }


    if ($instep == 5) {
    	

    	$getlocation = DB::table('projectlist')->select('Location')->distinct()->where(['Type' => "$mysql_type", 'Status' => 'Ongoing'])->orderBy('Location','asc')->get();
    		$locationarr = [];
	if (count($getlocation) > 0) {
		$i = 1;
		foreach ($getlocation as $valueloc) {
		array_push($locationarr, $valueloc->Location);
			
		}
	}



	if (($message <= count($locationarr))  && ($message > 0)) {
		$location = $locationarr[$message - 1];
Log::info($location);
$replymsg = $mysql_name.", Please select the project you are interested in";
    		
    	 	DB::connection('mysql')->table('facbook_bot')->where(['senderid' => $sender])->update(['location'=>trim($location),'instep'=>6]);
    	 	$locationstep = 1;

    	 	$getproject = DB::table('projectlist')->where(['Type' => "$mysql_type", 'Status' => 'Ongoing', 'Location' => trim($location)])->orderBy('Project_name','asc')->get();
    		$projelement = [];

 
	if (count($getproject) > 0) {
		$i = 0;
$projectvalid = 1;		
		foreach ($getproject as $valueproj) {

$indivmobbanner = "images/project_thumb/".$valueproj->id;
            $data_banner_img_url = $this->single_link_parse_path_gen_link($indivmobbanner);
Log::info("https://cdn.vgn.in/".$data_banner_img_url);
			$quote = str_replace('&#8377;', '₹', $valueproj->single_quote);
			$projelement[$i]['title'] = $valueproj->Project_name;
			$projelement[$i]['image_url'] = "https://cdn.vgn.in/".$data_banner_img_url;
			$projelement[$i]['subtitle'] = $quote;
			$projelement[$i]['buttons']	 = [['type' => "postback",'title' => "Choose this project",'payload'=>$valueproj->id]];
			$i++;
		}

		$jsonprojectdata = json_encode($projelement);
	}

	}else{
		$replymsg = "Please enter a valid serial number.";
    		$locationstep = 0;
		$projectvalid = 0;
	}



    }


    if ($instep == 6) {
    	Log::info($message);
    	$checkproject = DB::table('projectlist')->where(['Type' => "$mysql_type", 'Status' => 'Ongoing', 'Location' => trim($mysql_location), 'id' => $message])->get();
    	Log::info($checkproject);
    	if (count($checkproject) > 0) {
    		foreach ($checkproject as $keypro => $valuepro) {
    			$resproj = $valuepro->Project_name;
    			$projid = $valuepro->id;
    		}
    		DB::connection('mysql')->table('facbook_bot')->where(['senderid' => $sender])->update(['project'=>trim($resproj),'projectid' => $projid,'instep'=>7]);
    		$projectvalid = 1;
    		$replymsg = $mysql_name.", Kindly share your email address to send you the relevant project details.";
    	}
    	else{
    		$projectvalid = 0;
    		$replymsg = "Please select a valid project.";
    	}

    }

    if ($instep == 7) {
    	if (!filter_var($message, FILTER_VALIDATE_EMAIL)) {
                $emailvalid = 0;
    		$replymsg = "Please enter a valid email.";
                }
                else{
                	$replymsg = "Thank You ".$mysql_name.". Our sales representative will get in touch with you shortly.";
                	DB::connection('mysql')->table('facbook_bot')->where(['senderid' => $sender])->update(['emailid'=>trim($message),'instep'=>8]);
                	$emailvalid = 1;


//start
                	$source = 'Facebook';
                	$name = $mysql_name;
 $location = $mysql_location;
            $mobileno = $mysql_mobile;
            $project_name = 'VGN '.$mysql_project;
            $emailid = $message;
            $budget_range = $mysql_budget;
            $pids = $mysql_id;
            //VgnChatboT@123*
            if (($location != '') && ($mobileno != '') && ($project_name != '') && ($emailid != '') && ($budget_range != '')) {

                $removevgn_name = str_replace('VGN ', '',$project_name);
                $newlist =  projectlist::where('id','=',$pids)->get();

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
                       	

                        if ($source == 'Facebook') {
                            $campaignsource = 'FACEBOOK CHATBOT MASTER';
                        }

                       

                if (!empty($projectid)) {
                    

                    if (!empty($plantcode)) {
                        
                        
                    $camp_code_id = '';
                    $getproject = DB::connection('mysql2')->table("campaignprocess")->where([
                        'Campaign_name' => $campaignsource,
                        'Plant_code' => $plantcode
                    ])->get();
                    if (count($getproject) > 0) {
                        
                        foreach ($getproject as $key1 => $value1) {
                            
                                $camp_code = $value1->Campaign_code;
                                $table_name = $value1->Campaign_code.'_'.$value1->Plant_code;
                                $camp_code_id = $value1->Campaign_code;
                                
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
                $lead->facebook_campaigncode = $camp_code_id;
                $lead->linkedin_campaigncode = null;
                $lead->website_campaigncode = null;
                $lead->mobile_campaigncode = null;
                $lead->created_at = date('Y-m-d H:i:s');
                $lead->updated_at = date('Y-m-d H:i:s');
                $lead->save();


                }



                DB::connection('mysql2')->table("fbchatbot_leads")->insert([
                    'source' => $source,
            'name' => $name,
            'location' => $location,
            'mobileno' => $mobileno,
            'project_name' => $project_name,
            'emailid' => $emailid,
            'budget_range' => $budget_range,
            'msg_string' => 'Facebook Request',
            'created_datetime' => Carbon::now()->toDateTimeString()
                ]);

                
            }
            
//end
DB::connection('mysql')->table('facbook_bot')->where(['senderid' => $sender])->delete();

                }
    }
	
    $url = 'https://graph.facebook.com/v8.0/me/messages?access_token=EAAHgoEjQmLMBOwJdXPUUH5ki3aeq0FKqZCQWjWrZCLM8gbuk7ZAbvEuVxBZCwvm80ZAKYZAwUTi6UFFZCbYrXeaTR78FRafqwKugTZCzlFZCq0cmNohkVHuJAAwGCXo2Wi0sZCbkNkxMScMpfEpN6Id1DgSmDac55k5DGruyfNHcb0OQUAQ6ZCAwtOb903nJEz14THRHBguC0LZB4ZCAYp9G1O2b4wRn1ZAW0ZD';

if (($instep == 1) || ($instep == 0) || (($instep == 2) && ($apartmentplotstep == 0))) {
	

    
    /*initialize curl*/
    $ch = curl_init($url);
    /*prepare response*/
    $jsonData = '{
    "recipient":{
        "id":"' . $sender . '"
        },
        "message":{
            "text": "'.$replymsg.'"
        }
    }';
    /* curl setting to send a json post data */
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    if (!empty($message)) {
        $name_result = curl_exec($ch); // user will get the message
    }

    curl_close($ch);
}

if (($instep == 2)&&($apartmentplotstep == 1) || (($instep == 3) && ($apartmentplotstep == 0))) {
	
    /*initialize curl*/
    $ch = curl_init($url);
    /*prepare response*/
    $jsonData = '{
    "recipient":{
        "id":"' . $sender . '"
        },
      "messaging_type": "RESPONSE",
  "message":{
    "text": "'.$replymsg.'",
    "quick_replies":[
      {
        "content_type":"text",
        "title":"Apartments",
        "payload":"<POSTBACK_PAYLOAD>"
      },{
        "content_type":"text",
        "title":"Plots",
        "payload":"<POSTBACK_PAYLOAD>"
      }
    ]
  }
    }';
    /* curl setting to send a json post data */
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    if (!empty($message)) {
        $apartplots_result = curl_exec($ch); // user will get the message

    }

    curl_close($ch);
}


if ((($instep == 3)&&($apartmentplotstep == 1)) || (($instep == 4) && ($budgetrangestep == 0))) {
	
    /*initialize curl*/
    $ch = curl_init($url);
    /*prepare response*/
    $jsonData = '{
    "recipient":{
        "id":"' . $sender . '"
        },
      "messaging_type": "RESPONSE",
  "message":{
    "text": "'.$replymsg.'",
    "quick_replies":[
      {
        "content_type":"text",
        "title":"Upto 20 Lakhs",
        "payload":"<POSTBACK_PAYLOAD>"
      },{
        "content_type":"text",
        "title":"Upto 40 Lakhs",
        "payload":"<POSTBACK_PAYLOAD>"
      },
      {
        "content_type":"text",
        "title":"Upto 60 Lakhs",
        "payload":"<POSTBACK_PAYLOAD>"
      },
      {
        "content_type":"text",
        "title":"Upto 80 Lakhs",
        "payload":"<POSTBACK_PAYLOAD>"
      },
      {
        "content_type":"text",
        "title":"Upto 1 Crore",
        "payload":"<POSTBACK_PAYLOAD>"
      },
      {
        "content_type":"text",
        "title":"Upto 3 Crore",
        "payload":"<POSTBACK_PAYLOAD>"
      },
      {
        "content_type":"text",
        "title":"Upto 5 Crore",
        "payload":"<POSTBACK_PAYLOAD>"
      },
      {
        "content_type":"text",
        "title":"Upto 10 Crore",
        "payload":"<POSTBACK_PAYLOAD>"
      },
      {
        "content_type":"text",
        "title":"Above 10 Crore",
        "payload":"<POSTBACK_PAYLOAD>"
      }
    ]
  }
    }';
    /* curl setting to send a json post data */
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    if (!empty($message)) {
        $apartplots_result = curl_exec($ch); // user will get the message

    }

    curl_close($ch);
}


if ((($instep == 4)&&($budgetrangestep == 1)) || (($instep == 5)&& ($locationstep == 0)) ) {



	
    /*initialize curl*/
    $ch = curl_init($url);
    /*prepare response*/
    $jsonData = '{
    "recipient":{
        "id":"' . $sender . '"
        },
  "message":{
    "text": "'.$replymsg.'"
  }
    }';
    /* curl setting to send a json post data */
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    if (!empty($message)) {
        $apartplots_result = curl_exec($ch); // user will get the message

    }

    curl_close($ch);
}


if ((($instep == 5)&&($locationstep == 1))  ) {

	
    /*initialize curl*/
    $ch = curl_init($url);
    /*prepare response*/
    $jsonData = '{
    "recipient":{
        "id":"' . $sender . '"
        },
  "message":{
    "attachment":{
      "type":"template",
      "payload":{
        "template_type":"generic",
        "elements": '.$jsonprojectdata.'
      }
    }
  }
    }';
    /* curl setting to send a json post data */
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    if (!empty($message)) {
        $apartplots_result = curl_exec($ch); // user will get the message

    }

    curl_close($ch);
}

if ((($instep == 6)&&($projectvalid == 1)) || (($instep == 7)&&($emailvalid == 0)) || (($instep == 5)&&($projectvalid == 0)) ) {

	
    /*initialize curl*/
    $ch = curl_init($url);
    /*prepare response*/
    $jsonData = '{
    "recipient":{
        "id":"' . $sender . '"
        },
  "message":{
  	"text": "'.$replymsg.'",
  	   
  }
    }';
    /* curl setting to send a json post data */
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    if (!empty($message)) {
        $apartplots_result = curl_exec($ch); // user will get the message

    }

    curl_close($ch);
}

if ( (($instep == 7)&&($emailvalid == 1))  ) {

	
    /*initialize curl*/
    $ch = curl_init($url);
    /*prepare response*/
    $jsonData = '{
    "recipient":{
        "id":"' . $sender . '"
        },
  "message":{
  	"text": "'.$replymsg.'",
  	   
  }
    }';
    /* curl setting to send a json post data */
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    if (!empty($message)) {
        $apartplots_result = curl_exec($ch); // user will get the message

    }

    curl_close($ch);
}

		
}

}




}
