<?php

namespace vgn\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class fbapipushcontroller extends Controller
{
   public function verify_token()
    {
        $access_token = "EAAh1s3EuWrYBO8OQop8qYel3TUdOSJEheoT7r4MYIj1dLjSz6MSJhgh5rum9eaUNSvrzvLraaZCezqwRa2PzGjsKCNkSAiZAMpkl7c1DHoZCTok7FCcpCAK8tyLzLOIzzqcV9iqtzyxqYjXbfWxlynvtM96qZBsecefkbfJDCZAw8ZCywCdybrJvbR";
        $verify_token = "abc123";
        $hub_verify_token = null;

        if(isset($_REQUEST['hub_challenge'])) {
            $challenge = $_REQUEST['hub_challenge'];
            $hub_verify_token = $_REQUEST['hub_verify_token'];
        }


        if ($hub_verify_token === $verify_token) {
            echo $challenge;
        }


    }


    public function postedfromfb()
    {
        $input = json_decode(file_get_contents('php://input'), true);
	Log::info(json_encode($input));
        //$sender = $input['entry'][0]['messaging'][0]['sender']['id'];
        //$message = $input['entry'][0]['messaging'][0]['message']['text'];
        //Log::info('Facebook posted sender:'.$sender);
        //Log::info('Facebook posted message:'.$message);
        //Log::info('Facebook posted dumo:'.json_encode($input));
    }

public function fbcurlquery($formid, $currentdateunixtime)
    {
    	

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://graph.facebook.com/v4.0/$formid/leads?access_token=EAAh1s3EuWrYBO8OQop8qYel3TUdOSJEheoT7r4MYIj1dLjSz6MSJhgh5rum9eaUNSvrzvLraaZCezqwRa2PzGjsKCNkSAiZAMpkl7c1DHoZCTok7FCcpCAK8tyLzLOIzzqcV9iqtzyxqYjXbfWxlynvtM96qZBsecefkbfJDCZAw8ZCywCdybrJvbR&filtering=[{%22field%22:%20%22time_created%22,%22operator%22:%20%22GREATER_THAN%22,%22value%22:%20$currentdateunixtime}]&fields=id,field_data",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_POSTFIELDS => "",
  CURLOPT_HTTPHEADER => array(
    "cache-control: no-cache"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  return json_decode($response);
}

    }

    public function fbleadcurlquery($leadid)
    {
        

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://graph.facebook.com/v4.0/$leadid?access_token=EAAh1s3EuWrYBO8OQop8qYel3TUdOSJEheoT7r4MYIj1dLjSz6MSJhgh5rum9eaUNSvrzvLraaZCezqwRa2PzGjsKCNkSAiZAMpkl7c1DHoZCTok7FCcpCAK8tyLzLOIzzqcV9iqtzyxqYjXbfWxlynvtM96qZBsecefkbfJDCZAw8ZCywCdybrJvbR&fields=id,platform,field_data",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_POSTFIELDS => "",
  CURLOPT_HTTPHEADER => array(
    "cache-control: no-cache"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  return json_decode($response);
}

    }


    public function getleadsfromfacebook()
    {
    	//dd(Carbon::now()->subDays(1)->toDateString());
    	$currentdateunixtime = strtotime(Carbon::now()->toDateString().' 00:00:00');
	//$currentdateunixtime = strtotime('2020-05-12 00:00:00');
    	$getformidsql = DB::connection('mysql2')->table('api_connecting_code')->whereIn('vendorname', ['Facebook', 'Instagram'])->get();
    	$ins = 0;
        $mainarray = [];
        $newkey = 0;
    	if(count($getformidsql) > 0){
    		foreach ($getformidsql as $key => $value) {
    			$formid = $value->vendorcode;
    			$campaigncode = $value->vgncampaigncode;
                
    			$getleadsdata = $this->fbcurlquery($formid, $currentdateunixtime);
                // dd($getleadsdata);
                
    			//if($formid == '630893491061095')
			//{
			// dd($getleadsdata);
			//}	
    			if(!empty($getleadsdata->data)){
    				$leaddata = [];
    				foreach ($getleadsdata->data as $key1 => $value1) {
    					$leaddata[$newkey]['unique_id'] = $value1->id;
                        //echo $value1->id.'--'.$formid;
                        $leadsource = $this->fbleadcurlquery($value1->id);
                         if (array_key_exists('platform',$leadsource) === false) {
                             $platform = 'Facebook';
                         }else{
                        
                        if ($leadsource->platform == 'ig') {
                            $platform = 'Instagram';
                        }
                        if ($leadsource->platform == 'fb') {
                            $platform = 'Facebook';
                        }
                    }
                        $leaddata[$newkey]['leadsource'] = $platform;
                        $leaddata[$newkey]['vgncampaigncode'] = $campaigncode;
                        $leaddata[$newkey]['vgnvendorname'] = $value->vendorname;

    					foreach ($value1->field_data as $ii => $vv) {
    						if ($vv->name == 'full_name') {
    							$leaddata[$newkey]['full_name'] = $value1->field_data[$ii]->values[0];
							$leaddata[$newkey]['full_name'] = preg_replace("/[^A-Za-z.?! ]/","", $leaddata[$newkey]['full_name']); 
    						}
    						if ($vv->name == 'phone_number') {

                                $mob = str_replace(' ', '', $value1->field_data[$ii]->values[0]);
                                if(strpos($mob,'+91') >= 0){
  
                                  $removed_first3charc = substr($mob, 3);
                                  
                                if((strlen($removed_first3charc) >= 11) && (substr($removed_first3charc, 0,1) == '0')){
                                $phone1 = ltrim($removed_first3charc, '0');
                                 $phone = substr($mob, 0,3).$phone1;
                                }
                                else{
                                 $phone = $mob;
                                }
                                  

                                }
                                else{
                                  $phone = $mob;
                                }

    							$leaddata[$newkey]['phone_number'] = $phone;
    						}
    						if ($vv->name == 'email') {
    							$leaddata[$newkey]['email'] = $value1->field_data[$ii]->values[0];
    						}
    					}
                        $newkey++;
    				}

    				//dd($leaddata);
                    //$mainarray[] = $leaddata;

    				if (!empty($leaddata)) {
                        foreach ($leaddata as $keykv => $valuekv) {
                            if (strtolower($valuekv['leadsource']) == strtolower($valuekv['vgnvendorname'])) {

                                $getplantcode = DB::connection('mysql2')->table('campaignprocess')->where('Campaign_code', '=', $valuekv['vgncampaigncode'])->get();
                                if (count($getplantcode) > 0) {
                                foreach ($getplantcode as $keyp => $valuep) {
                                $table_name = $valuep->Campaign_code.'_'.$valuep->Plant_code;
                                $plantname = $valuep->Plant_name;
                                $getprojname = DB::connection('mysql')->table('projectlist')->where('plantcode', '=', $valuep->Plant_code)->get();
                                $projectname = '';
                                if (count($getprojname) > 0) {
                                    foreach ($getprojname as $keyproj => $valueproj) {
                                        $projectname = $valueproj->Project_name;
                                    }
                                }
                            }

                            $checklead = DB::connection('mysql2')->table("$table_name")->where('PID', '=', $valuekv['unique_id'])->count();

                            if ($checklead == 0) {

                                DB::connection('mysql2')->table("$table_name")->insert([
                                        'id' => null,
                                        'PID' => $valuekv['unique_id'],
                                        'Project_name'=>  'VGND '.$projectname,
                                        'Name'=>  $valuekv['full_name'],
                                        'Email'=>  'None',//($valuekv['email'] == undefined) ? 'None' : $valuekv['email'],//$valuekv['email'],
                                        'Mobile'=>  $valuekv['phone_number'],
                                        'City'=>  'None',
                                        'msg'=>  'None',
                                        'lead_datetime' => Carbon::now()->toDateTimeString(),
                                        'inserteddate' => Carbon::now()->toDateTimeString()
                                    ]);
                                $ins++;
                                echo $valuekv['leadsource'].' Matched '.$valuekv['vgnvendorname'].'----'.$valuekv['unique_id'].'----'.$valuekv['vgncampaigncode'].'----'.$valuekv['full_name'].'----'.$valuekv['phone_number'].'---'.$table_name.'---'.$plantname.'---'.$projectname.'----'.$checklead.'<br>';
                            }
                                }
                            }
                        }
    					    					
    				}
    			}		
    		}
    	}

        //dd($mainarray);
    	echo 'Inserted new leads from facebook count - '.$ins;
    	Log::info('Inserted new leads from facebook count - '.$ins);
    	
    }

}
