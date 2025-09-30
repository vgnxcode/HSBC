<?php

namespace vgn\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use vgn\projectlist;
use vgn\sqft_range;
use vgn\lead_data;
use File;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class TwitterprojectController extends Controller
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

       public function smscurl($message, $mobileno)
{
/*$fullurl = "http://www.adithya.me/adithya/Api/";
$fields = array(
    'username'      => 'vgn',
    'password'      => 'vgn@123',
    'senderid'    => 'VGNALT',
    'message'      => $message,
    'msgtype'      => 'normal',
    'mobileno'      => $mobileno
);*/

/*$fullurl = "http://sms6.rmlconnect.net:8080/bulksms/bulksms";
$fields = array(
    'username'      => 'vgnotp',
    'password'      => 'Vgn@!($@',
    'type'    => 0,
    'dlr'      => 1,
    'destination'      => $mobileno,
    'source'      => 'VGNOTP',
    'message'      => $message
);*/

$fullurl = "https://api-alerts.kaleyra.com/v4/";
$fields = array(
    'api_key'      => 'A8ef4022b54eff4bb372e8b140507f763',
    'method'      => 'sms',
    'message'      => $message,
    'to'      => $mobileno,
    'sender' => 'VGNOTP'
);

//open connection
$ch = curl_init();

//set the url, number of POST vars, POST data
curl_setopt($ch, CURLOPT_URL, $fullurl);
curl_setopt($ch, CURLOPT_POST, count($fields));
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($fields));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

//execute post
$result = curl_exec($ch);

//close connection
curl_close($ch);

return $result;
}

    public function twshow($name = null) {

if(session()->has('twotpdata.hashedkey')){
    return redirect()->route('twotpproject', ['name' => $name]);
    
}

        if($name == null) {

            return redirect()->route('home');
        }
        else{
            
            
             $newname = str_replace("_"," ",strtolower($name));
                
              if(projectlist::where('Project_name','=',$newname)->count() == 0) {
                    
                    return redirect()->route('home');
                }

            $newlist =  projectlist::where('Project_name','=',$newname)->get();
            $list =  projectlist::find($newlist[0]['id']);
            
            if(empty($list)) {
                    
                    return redirect()->route('home');
                }
		else{
		$id = $list['id'];
		}
            
           /* if(count($list) == 1) {
            $id = $list['id'];
            }
            else {
                return redirect()->route('home');
            }*/

            $sqftrange =  sqft_range::where('P_id','=',$id)->get();

               

                /*$spec =  specification::all();
                $amen =  amenities::all();*/

                $floordirectory = Storage::disk('s3')->files("/images/floorplan/".$id);
                //$floor_dir_exist = is_dir($floordirectory);
                $floorplanfiles = array();
                if(count($floordirectory) > 0) {
                $floorplanfiles = Storage::disk('s3')->files("/images/floorplan/".$id);
                }

                $consdirectory = Storage::disk('s3')->files("/images/construction/".$id);
                //$cons_dir_exist = is_dir($consdirectory);
                $consplanfiles = array();
                if(count($consdirectory) > 0) {
                $consplanfiles = Storage::disk('s3')->files("/images/construction/".$id);
                }

                $ebrochdirectory = Storage::disk('s3')->files("/images/ebrochure/".$id);
                //$ebroch_dir_exist = is_dir($ebrochdirectory);
                $ebrochplanfiles = array();
                if(count($ebrochdirectory) > 0) {
                $ebrochplanfiles = Storage::disk('s3')->files("/images/ebrochure/".$id);
                }

                $getcoordinates =  DB::table('googlemaplocation')->where('projectid','=',$newlist[0]['id'])->get();

            if(count($getcoordinates) != 0){
                $gmapvalid = 1;
                $coordinates = $getcoordinates;
                foreach ($getcoordinates as $key => $value) {
                    $latitude = $value->latitude;
                    $longitude = $value->longitude;
                }
            }
            else{
                $latitude = 0;
                $longitude = 0;
                
            }
               
			    $bannerpath = "images/banner/".$id;
            $mobilebanner = "images/banner/mobile/".$id;
            $data_banner_img_url = $this->single_link_parse_path_gen_link($bannerpath);
            $data_mobile_banner_img_url = $this->single_link_parse_path_gen_link($mobilebanner);
            $banner = $data_banner_img_url;
            $mobile_banner = $data_mobile_banner_img_url;    
                
                return view('TWProject.indivdisplay')->with(['list' => $list, 'sqftrange' => $sqftrange, 'floorplanfiles' => $floorplanfiles, 'consplanfiles' => $consplanfiles, 'ebrochplanfiles' => $ebrochplanfiles,'latitude' => $latitude, 'banner' => $banner, 'mobile_banner' => $mobile_banner] );
       
        }

        
    }
    public function twinsertlead(Request $request,$name = null) {
        if($name == null) {

            return redirect()->route('home');
        }
        else{
            
              $newname = str_replace("_"," ",strtolower($name));
                 if(projectlist::where('Project_name','=',$newname)->count() == 0) {
                    
                    return redirect()->route('home');
                }

            $newlist =  projectlist::where('Project_name','=',$newname)->get();
            $list =  projectlist::find($newlist[0]['id']);
            
            if(empty($list)) {
                    
                    return redirect()->route('home');
                }
                else{
                    $id = $list['id'];        
                }
            
            /*if(count($list) == 1) {
            $id = $list['id'];
            }
            else {
                return redirect()->route('home');
            }*/

            

            

            $validate = $this->validate($request, [
            'Name' => 'required|regex:/^[\pL\s\.]+$/u|min:4',
			'Email' => 'required|email',
			'Mobile' => 'required|digits:10',
            'Mobile_phoneCode' => 'required',
            'City' => 'required|regex:/^[\pL\s]+$/u|min:4'
			]);


           

             $pidtime = date('Ymdhis').mt_rand(5, 1500);
            $leaddttime = date('Y-m-d H:i:s');
            $addoneday = date('Y-m-d H:i:s');
            $projectlistnew = projectlist::where('id','=',$id)->get();
            $ins = 0;
            if(!empty($projectlistnew)){
                //$campaigncode = $projectlistnew[0]['facebook_campaigncode'];
                $plantcode = $projectlistnew[0]['plantcode'];
                if (empty($plantcode)) {
                	return redirect()->back();
                }

                 $getcampaigncode = DB::connection('mysql2')->table('campaignprocess')->select('Campaign_code')->where('Campaign_name','LIKE','%TWITTER MASTER%')->where('Plant_code','=',$plantcode)->get();
                $campaigncode = $getcampaigncode[0]->Campaign_code;
                //dd($campaigncode);

                if($campaigncode != '')
                {
                $tablename = $campaigncode.'_'.$plantcode;
                //$data = DB::connection('mysql2')->table($tablename)->where('Email','=',$request->Email)->count();
                $data = DB::connection('mysql2')->table($tablename)->select('lead_datetime')->where('Mobile','=','+'.$request->Mobile)->orderBy('lead_datetime', 'desc')->first();
                $pname = 'VGND '.$list->Project_name;

               

                if(!empty($data)) {
                    
                  $leadexist =$data->lead_datetime;
                $dt = Carbon::parse($leadexist);

                $now = Carbon::now();
                $dtformat = Carbon::create($dt->year, $dt->month, $dt->day, $dt->hour, $dt->minute, $dt->second);
                $addoneday = $dtformat->addHours(24);
                
                $are_different = $now->gt($addoneday);

                    if($are_different === true) {
                        $ins = 1;
                    }
                    else{
                    
                    $ins = 0;
                    }
                    
                }

                if(empty($data)) {
                   $ins = 1;
                }
                
                }
            }

            
                if($ins == 1){
                    $otpdata = array();
                    $otptext = mt_rand(1000,9999);
                    $tohashtext = "JKL@!)~@!54VlK23"."$@".$otptext; 
                    $hashedtext = md5($tohashtext);

                 if(ctype_digit($request->Mobile)){
                    if (strlen($request->Mobile) == 10) {
                        
                //$smscontent='Dear '.$name.',<br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Please <a href="'.$link.'">Click Here</a> to reset your password.<br><br>Thanks,<br>VGN<br><div style="    text-align: center;    font-size: 88%;    color: rgb(124, 124, 124);">For Any details : <a href="http://www.vgn.in">www.vgn.in</a><br><span style="    color: rgb(23, 79, 163);				font-weight: bold;">VGN Property Developers Private Limited</span>&nbsp;- No.153, Wallace Garden, 2nd Street, Nungambakkam, Chennai-600006.<br>Call Us: +91 44 4343 9900</div>';
				$now = Carbon::now();
				//dd($plantcode);
                //$smsurl = "http://www.adithya.me/adithya/Api/?username=vgn&password=vgn@123&senderid=VGNALT&message=$smscontent&msgtype=normal&mobileno=8754404619";
                $smscontent = 'Dear '. preg_replace("/[^A-Za-z.?! ]/","",$request->Name).', Your One Time Password for  VGN '.$list->Project_name.' project enquiry is '.$otptext; 
                
               $sms_status = $this->smscurl($smscontent, $request->Mobile);               
                DB::table('sms_sent_data')->insert(['Mobile' => $request->Mobile,'sentdatetime' => "$now"]);
                    }
                }
                else
                {
                    $request->session()->flash("error_msg", "Not a Valid Mobile Number!");
                    return redirect()->back();
                }

               
                             
        
                    $request->session()->put("twotpdata", ['twotp'=>$otptext,'hashedkey' => $hashedtext, 'PID'=>$pidtime, 'Project_name' => $pname,'Name'=> preg_replace("/[^A-Za-z.?! ]/","",$request->Name),
                    'Email' => $request->Email, 'Mobile' => '+'.$request->Mobile_phoneCode.$request->Mobile, 'City' => $request->City,
                    'msg'=>null, 'lead_datetime' => $leaddttime,'sourcetype'=>'Twitter','plantcode' => $list->plantcode, 'twittercampaigncode' => $campaigncode,'triedcount' => 1 ]);
                    return redirect()->route('twotpproject', ['name' => $name]);
        }
        else{
            $request->session()->flash("24hours", $addoneday);
            //alert('You can enquire after 24 hours from the laste enquired datetime.');
            return redirect()->back();
            
        }
            
            
        }
    }
    
    public function twotpshow(Request $request, $name = null) {

if($request->session()->has('twotpdata.hashedkey')){
    $sessiondata = $request->session()->get('twotpdata');
}
else
{
    return redirect()->route('twproject', ['name' => $name]);
}




        if($name == null) {

            return redirect()->route('home');
        }
        else{
            
            
             $newname = str_replace("_"," ",strtolower($name));
                
              if(projectlist::where('Project_name','=',$newname)->count() == 0) {
                    
                    return redirect()->route('home');
                }

                

            $newlist =  projectlist::where('Project_name','=',$newname)->get();
            $list =  projectlist::find($newlist[0]['id']);
            
            if(empty($list)) {
                    
                    return redirect()->route('home');
                }
                else{
                    $id = $list['id'];        
                }
            
            /*if(count($list) == 1) {
            $id = $list['id'];
            }
            else {
                return redirect()->route('home');
            }*/

            $sqftrange =  sqft_range::where('P_id','=',$id)->get();

               
$pname = 'VGND '.$list->Project_name;

if ($sessiondata['Project_name'] != $pname) {
    
    $request->session()->forget('twotpdata');
    return redirect()->route('twproject', ['name' => $name]);
}
                /*$spec =  specification::all();
                $amen =  amenities::all();*/

		$floordirectory = Storage::disk('s3')->files("/images/floorplan/".$id);
                //$floor_dir_exist = is_dir($floordirectory);
                $floorplanfiles = array();
                if(count($floordirectory) > 0) {
                $floorplanfiles = Storage::disk('s3')->files("/images/floorplan/".$id);
                }

                $consdirectory = Storage::disk('s3')->files("/images/construction/".$id);
                //$cons_dir_exist = is_dir($consdirectory);
                $consplanfiles = array();
                if(count($consdirectory) > 0) {
                $consplanfiles = Storage::disk('s3')->files("/images/construction/".$id);
                }

                $ebrochdirectory = Storage::disk('s3')->files("/images/ebrochure/".$id);
                //$ebroch_dir_exist = is_dir($ebrochdirectory);
                $ebrochplanfiles = array();
                if(count($ebrochdirectory) > 0) {
                $ebrochplanfiles = Storage::disk('s3')->files("/images/ebrochure/".$id);
                }                


                $getcoordinates =  DB::table('googlemaplocation')->where('projectid','=',$newlist[0]['id'])->get();

            if(count($getcoordinates) != 0){
                $gmapvalid = 1;
                $coordinates = $getcoordinates;
                foreach ($getcoordinates as $key => $value) {
                    $latitude = $value->latitude;
                    $longitude = $value->longitude;
                }
            }
            else{
                $latitude = 0;
                $longitude = 0;
                
            }
               	    $bannerpath = "images/banner/".$id;
            $mobilebanner = "images/banner/mobile/".$id;
            $data_banner_img_url = $this->single_link_parse_path_gen_link($bannerpath);
            $data_mobile_banner_img_url = $this->single_link_parse_path_gen_link($mobilebanner);
            $banner = $data_banner_img_url;
            $mobile_banner = $data_mobile_banner_img_url;
                
                return view('TWProject.otpverify')->with(['list' => $list, 'sqftrange' => $sqftrange, 'floorplanfiles' => $floorplanfiles, 'consplanfiles' => $consplanfiles, 'ebrochplanfiles' => $ebrochplanfiles,'latitude'=>$latitude, 'banner' => $banner, 'mobile_banner' => $mobile_banner] );
       
        }

        
    }
    
    public function twotpinsertlead(Request $request,$name = null) {

if($request->session()->has('twotpdata.hashedkey')){
    $sessiondata = $request->session()->get('twotpdata');
    
}
else
{
    return redirect()->route('twproject', ['name' => $name]);
}
        if($name == null) {

            return redirect()->route('home');
        }
        else{
            
              $newname = str_replace("_"," ",strtolower($name));
                 if(projectlist::where('Project_name','=',$newname)->count() == 0) {
                    
                    return redirect()->route('home');
                }

            $newlist =  projectlist::where('Project_name','=',$newname)->get();
            $list =  projectlist::find($newlist[0]['id']);
            
            	if(empty($list)) {
                    return redirect()->route('home');
                }
                else{
                    $id = $list['id'];
                }
            
            /*if(count($list) == 1) {
            $id = $list['id'];
            }
            else {
                return redirect()->route('home');
            }*/

            

            

            $validate = $this->validate($request, [
            'otp' => 'required|digits:4'
			]);


            $otptext = $request->otp;
            $tohashtext = "JKL@!)~@!54VlK23"."$@".$otptext; 
            $hashedtext = md5($tohashtext);
            //dd($hashedtext);
            
            if ($sessiondata['hashedkey'] == $hashedtext) {
                
            

             $pidtime = date('Ymdhis').mt_rand(5, 1500);
            $leaddttime = date('Y-m-d H:i:s');
            $addoneday = date('Y-m-d H:i:s');
            $projectlistnew = projectlist::where('id','=',$id)->get();
            $ins = 0;
            if(!empty($projectlistnew)){
                //$campaigncode = $projectlistnew[0]['facebook_campaigncode'];
                $plantcode = $projectlistnew[0]['plantcode'];

                 if (empty($plantcode)) {
                	return redirect()->back();
                }

                 $getcampaigncode = DB::connection('mysql2')->table('campaignprocess')->select('Campaign_code')->where('Campaign_name','LIKE','%TWITTER MASTER%')->where('Plant_code','=',$plantcode)->get();
                $campaigncode = $getcampaigncode[0]->Campaign_code;

                if($campaigncode != '')
                {
                $tablename = $campaigncode.'_'.$plantcode;
                //$data = DB::connection('mysql2')->table($tablename)->where('Email','=',$request->Email)->count();
                $data = DB::connection('mysql2')->table($tablename)->select('lead_datetime')->where('Email','=',$sessiondata['Email'])->orderBy('lead_datetime', 'desc')->first();
                $pname = 'VGND '.$list->Project_name;

               

                if(!empty($data)) {
                  $leadexist =$data->lead_datetime;
                $dt = Carbon::parse($leadexist);

                $now = Carbon::now();
                $dtformat = Carbon::create($dt->year, $dt->month, $dt->day, $dt->hour, $dt->minute, $dt->second);
                $addoneday = $dtformat->addHours(24);
                
                $are_different = $now->gt($addoneday);

                    if($are_different === true) {
                        $ins = 1;
                    }
                    else{
                    
                    $ins = 0;
                    }
                    
                }

                if(empty($data)) {
                   $ins = 1;
                }
                
                }
            }

            
                if($ins == 1){
             $insert = DB::connection('mysql2')->table($tablename )->insert(
                    ['Id' => null, 'PID' => $pidtime, 'Project_name' => $pname,'Name'=>$sessiondata['Name'],
                    'Email' => $sessiondata['Email'], 'Mobile' => $sessiondata['Mobile'], 'City' => $sessiondata['City'],
                    'msg'=>null, 'lead_datetime' => $leaddttime, 'inserteddate' => date('Y-m-d H:i:s')]
                );
                
               
                $request->session()->flash("thanks_session", $leaddttime);
            $sqftrange =  sqft_range::where('P_id','=',$id)->get();
            $request->session()->forget('twotpdata');
            //return view('GoogleProject.thanks')->with(['list' => $list, 'sqftrange' => $sqftrange] );
            return redirect()->route('twproject_thanks', ['name' => $name]);
        }
        else{
            $request->session()->flash("24hours", $addoneday);
            //alert('You can enquire after 24 hours from the laste enquired datetime.');
            $request->session()->forget('twotpdata');
            return redirect()->route('twproject', ['name' => $name]);
            
        }

        }
        else{
           // dd($sessiondata);
            $count = $sessiondata['triedcount'] + 1;

            if ($sessiondata['triedcount'] > 3) {
            $request->session()->flash("error_msg", "Maximum Number of attempt tried!");
            $request->session()->forget('twotpdata');
            return redirect()->route('twproject', ['name' => $name]); 
            } 
              $request->session()->put("twotpdata.triedcount", $count);
            $request->session()->flash("error_msg", "OTP Code does not match!");
            
            return redirect()->back();
        }
            
            
        }
    }
    
    public function otplogout(Request $request, $name = null) {

    if($request->session()->has('twotpdata.hashedkey')){
    $request->session()->forget('twotpdata');
    return redirect()->route('twproject', ['name' => $name]);
    
    }
    else
    {
    return redirect()->route('twproject', ['name' => $name]);
    }

}
    
    public function twthanks($name = null) {


         if($name == null) {

            return redirect()->route('home');
        }
        else{

            if (!(session()->has('thanks_session'))) {
			return redirect()->route("twproject",['name',$name]);
		}
            
              $newname = str_replace("_"," ",strtolower($name));
                 if(projectlist::where('Project_name','=',$newname)->count() == 0) {
                    
                    return redirect()->route('home');
                }

            $newlist =  projectlist::where('Project_name','=',$newname)->get();
            $list =  projectlist::find($newlist[0]['id']);
            
            if(empty($list)) {
                    
                    return redirect()->route('home');
                }
                else{
                    $id = $list['id'];
                }
            
            /*if(count($list) == 1) {
            $id = $list['id'];
            }
            else {
                return redirect()->route('home');
            }*/

             

            $sqftrange =  sqft_range::where('P_id','=',$id)->get();
		
			    $bannerpath = "images/banner/".$id;
            $mobilebanner = "images/banner/mobile/".$id;
            $data_banner_img_url = $this->single_link_parse_path_gen_link($bannerpath);
            $data_mobile_banner_img_url = $this->single_link_parse_path_gen_link($mobilebanner);
            $banner = $data_banner_img_url;
            $mobile_banner = $data_mobile_banner_img_url;

            return view('TWProject.twthanks')->with(['list' => $list, 'sqftrange' => $sqftrange, 'banner' => $banner, 'mobile_banner' => $mobile_banner] );
        }
    }
}
