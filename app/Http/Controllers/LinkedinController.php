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

class LinkedinController extends Controller
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

    public function checkfornewurl()
    {
         $changedurl = [
         	'nottinghilllinkedinurlnew' => "https://www.vgn.in/linkedin/flats/nungambakkam/notting_hill",
		'ovalgardenslinkedinurlnew' => "https://www.vgn.in/linkedin/plots/ambattur/oval_gardens",
		'fairmontlinkedinurlnew' => "https://www.vgn.in/linkedin/flats/guindy/fairmont",
         ];
                    $currentroute = url()->current();
                    foreach ($changedurl as $nkey => $nvalue) {
                        //dd($currentroute);
                        if ($currentroute == $nvalue) {
                            //dd($nkey);
                            return $nkey;

                        }
                    }
                    return 0;
    }

    public function checkformainurl($name)
    {
         $changedurl = [
         	'notting_hill' => "nottinghilllinkedinenquiry",
		'oval_gardens' => "ovalgardenslinkedinenquiry",
		'fairmont' => "fairmontlinkedinenquiry",
         ];
                    
                    foreach ($changedurl as $nkey => $nvalue) {
                        //dd($currentroute);
                        if ($name == $nkey) {
                            //dd($nkey);
                            return $nvalue;

                        }
                    }
                    return 0;
    }
    public function checkforotpurl()
    {
    	 $changedurl = [
         	"nottinghilllinkedinurlnew" => "https://www.vgn.in/linkedin/flats/nungambakkam/notting_hill",
		"ovalgardenslinkedinurlnew" => "https://www.vgn.in/linkedin/plots/ambattur/oval_gardens",
		"fairmontlinkedinurlnew" => "https://www.vgn.in/linkedin/flats/guindy/fairmont",
         ];
                    $currentroute = url()->current();
			//dd($currentroute);
                    foreach ($changedurl as $nkey => $nvalue) {
                        //dd($currentroute);
                        if ($currentroute == $nvalue) {
                            //dd($nkey);
                            return $nkey;

                        }
                    }
                    return 0;
    }

    public function checkforthanksurl()
    {
         $changedurl = [
         	'nottinghill_thankslinkedin' => "https://www.vgn.in/linkedin/otpverify/flats/nungambakkam/notting_hill",
		'ovalgardens_thankslinkedin' => "https://www.vgn.in/linkedin/otpverify/plots/ambattur/oval_gardens",
		'fairmont_thankslinkedin' => "https://www.vgn.in/linkedin/otpverify/flats/guindy/fairmont",
         ];
                    $currentroute = url()->current();
                    foreach ($changedurl as $nkey => $nvalue) {
                        //dd($currentroute);
                        if ($currentroute == $nvalue) {
                            //dd($nkey);
                            return $nkey;

                        }
                    }
                    return 0;
    }
     public function checkforlogouturl()
    {
         $changedurl = [
         	'https://www.vgn.in/linkedin/otplogout/notting_hill' => "https://www.vgn.in/linkedin/otpverify/flats/nungambakkam/notting_hill",
		'https://www.vgn.in/linkedin/otplogout/oval_gardens' => "https://www.vgn.in/linkedin/otpverify/plots/ambattur/oval_gardens",
		'https://www.vgn.in/linkedin/otplogout/fairmont' => "https://www.vgn.in/linkedin/otpverify/flats/guindy/fairmont",
         ];
                    $currentroute = url()->current();
		//dd($currentroute);
                    foreach ($changedurl as $nkey => $nvalue) {
                        //dd($currentroute);
                        if ($currentroute == $nvalue) {
                            //dd($nkey);
                            return $nkey;

                        }
                    }
                    return 0;
    }
    public function checkforgobackurl()
    {
    	$changedurl = [
    		'https://www.vgn.in/linkedin/flats/nungambakkam/notting_hill' => "https://www.vgn.in/linkedin/thank-you/flats/nungambakkam/notting_hill",
		'https://www.vgn.in/linkedin/plots/ambattur/oval_gardens' => "https://www.vgn.in/linkedin/thank-you/plots/ambattur/oval_gardens",
		
    	];
    	 $currentroute = url()->current();
                    foreach ($changedurl as $nkey => $nvalue) {
                        //dd($currentroute);
                        if ($currentroute == $nvalue) {
                            //dd($nkey);
                            return $nkey;

                        }
                    }
                    return 0;
    }

    public function gdshow($name = null) {

        if(session()->has('otpdata.hashedkey')){
            
            $check = $this->checkfornewurl();
        
            if ($check != '0') {
                //dd($check);
                return redirect()->route("$check");
            }
        
            return redirect()->route('gotpproject', ['name' => $name]);
            
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
                        }else{
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
                        
                        $floorplanfiles = array();
                        if(count($floordirectory) > 0) {
                        $floorplanfiles = Storage::disk('s3')->files("/images/floorplan/".$id);
                        }
        
                        $consdirectory = Storage::disk('s3')->files("/images/construction/".$id);
                        
                        $consplanfiles = array();
                        if(count($consdirectory) > 0) {
                        $consplanfiles = Storage::disk('s3')->files("/images/construction/".$id);
                        }
        
                        $ebrochdirectory = Storage::disk('s3')->files("/images/ebrochure/".$id);
                        
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
                       
                        $currentroute = url()->current();
                        //dd($sqftrange);
				    $bannerpath = "images/banner/".$id;
            $mobilebanner = "images/banner/mobile/".$id;
            $data_banner_img_url = $this->single_link_parse_path_gen_link($bannerpath);
            $data_mobile_banner_img_url = $this->single_link_parse_path_gen_link($mobilebanner);
            $banner = $data_banner_img_url;
            $mobile_banner = $data_mobile_banner_img_url;

                        return view('Linkedin.indivdisplay')->with(['list' => $list, 'sqftrange' => $sqftrange, 'floorplanfiles' => $floorplanfiles, 'consplanfiles' => $consplanfiles, 'ebrochplanfiles' => $ebrochplanfiles,'latitude'=>$latitude,'current_route' => $currentroute, 'banner' => $banner, 'mobile_banner' => $mobile_banner] );
               
                }
        
                
            }

    public function gdotpshow(Request $request, $name = null) {

        if($request->session()->has('otpdata.hashedkey')){
            $sessiondata = $request->session()->get('otpdata');
            
        }
        else
        {
             $checkformainurlinfunction = $this->checkformainurl($name);
                    if ($checkformainurlinfunction != '0') {
                        return redirect()->route("$checkformainurlinfunction");
                    }
            
            return redirect()->route('gdproject', ['name' => $name]);
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
                        }else{
			 $id = $list['id'];
			}
                    
                   /* if(count($list) == 1) {
                    $id = $list['id'];
                    }
                    else {
                        return redirect()->route('home');
                    }*/
        
                    $sqftrange =  sqft_range::where('P_id','=',$id)->get();
        
                       
        $pname = 'VGND '.$list->Project_name;
        
        if ($sessiondata['Project_name'] != $pname) {
            
        
            $request->session()->forget('otpdata');
             $checkformainurlinfunction = $this->checkformainurl($name);
                    if ($checkformainurlinfunction != '0') {
                        return redirect()->route("$checkformainurlinfunction");
                    }
            return redirect()->route('gdproject', ['name' => $name]);
        }
                        /*$spec =  specification::all();
                        $amen =  amenities::all();*/
        
                        $floordirectory = public_path()."/images/floorplan/".$id;
                        $floor_dir_exist = is_dir($floordirectory);
                        $floorplanfiles = array();
                        if($floor_dir_exist === true) {
                        $floorplanfiles = File::allFiles($floordirectory);
                        }
        
                        $consdirectory = public_path()."/images/construction/".$id;
                        $cons_dir_exist = is_dir($consdirectory);
                        $consplanfiles = array();
                        if($cons_dir_exist === true) {
                        $consplanfiles = File::allFiles($consdirectory);
                        }
        
                        $ebrochdirectory = public_path()."/images/ebrochure/".$id;
                        $ebroch_dir_exist = is_dir($ebrochdirectory);
                        $ebrochplanfiles = array();
                        if($ebroch_dir_exist === true) {
                        $ebrochplanfiles = File::allFiles($ebrochdirectory);
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
                        $getotplogouturl = $this->checkforlogouturl();
                        //dd($getotplogouturl);
                        if ($getotplogouturl == '0') {
                            //$getotplogouturl = 'https://www.vgn.in/googlead-display/otplogout/'.$name;
                        }
                        $currentroute = url()->current();
        
				    $bannerpath = "images/banner/".$id;
            $mobilebanner = "images/banner/mobile/".$id;
            $data_banner_img_url = $this->single_link_parse_path_gen_link($bannerpath);
            $data_mobile_banner_img_url = $this->single_link_parse_path_gen_link($mobilebanner);
            $banner = $data_banner_img_url;
            $mobile_banner = $data_mobile_banner_img_url;

                        return view('Linkedin.otpverify')->with(['list' => $list, 'sqftrange' => $sqftrange, 'floorplanfiles' => $floorplanfiles, 'consplanfiles' => $consplanfiles, 'ebrochplanfiles' => $ebrochplanfiles,'latitude'=>$latitude,'currentroute'=>$currentroute,'getotplogouturl'=>$getotplogouturl, 'banner' => $banner, 'mobile_banner' => $mobile_banner] );
               
                }
        
                
            }
        
            public function gfloorfn($name = null) {
        
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
                        }else{
			 $id = $list['id'];
			}
        
                    /*if(count($list) == 1) {
                    $id = $list['id'];
                    }
                    else {
                        return redirect()->route('home');
                    }*/
                     
        
                     $floordirectory = public_path()."/images/floorplan/".$id;
                        $floor_dir_exist = is_dir($floordirectory);
                        $floorplanfiles = array();
                        if($floor_dir_exist === true) {
                        $floorplanfiles = File::allFiles($floordirectory);
                        }
                        else{
                            return redirect()->route('gproject', ['name' => $name]);
                        }
                        $sqftrange =  sqft_range::where('P_id','=',$id)->get();

				    $bannerpath = "images/banner/".$id;
            $mobilebanner = "images/banner/mobile/".$id;
            $data_banner_img_url = $this->single_link_parse_path_gen_link($bannerpath);
            $data_mobile_banner_img_url = $this->single_link_parse_path_gen_link($mobilebanner);
            $banner = $data_banner_img_url;
            $mobile_banner = $data_mobile_banner_img_url;
                        
                        return view('Linkedin.floorplan')->with(['list' => $list, 'sqftrange' => $sqftrange, 'floorplanfiles' => $floorplanfiles, 'banner' => $banner, 'mobile_banner' => $mobile_banner] );
        
                }
        
            }
        
            public function gconstructionfn($name = null) {
        
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
                        }else{
			 $id = $list['id'];
			}
                    
                    /*if(count($list) == 1) {
                    $id = $list['id'];
                    }
                    else {
                        return redirect()->route('home');
                    }*/
        
                    
        
                     $consdirectory = public_path()."/images/construction/".$id;
                        $cons_dir_exist = is_dir($consdirectory);
                        $consplanfiles = array();
                        if($cons_dir_exist === true) {
                        $consplanfiles = File::allFiles($consdirectory);
                        }
                        else{
                            return redirect()->route('gproject', ['name' => $name]);
                        }
                        $sqftrange =  sqft_range::where('P_id','=',$id)->get();
                        
				    $bannerpath = "images/banner/".$id;
            $mobilebanner = "images/banner/mobile/".$id;
            $data_banner_img_url = $this->single_link_parse_path_gen_link($bannerpath);
            $data_mobile_banner_img_url = $this->single_link_parse_path_gen_link($mobilebanner);
            $banner = $data_banner_img_url;
            $mobile_banner = $data_mobile_banner_img_url;

                        return view('Linkedin.construction')->with(['list' => $list, 'sqftrange' => $sqftrange, 'consplanfiles' => $consplanfiles, 'banner' => $banner, 'mobile_banner' => $mobile_banner] );
        
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
    'message'      => $message.' - VGN Projects Estates.',
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

    public function gdinsertlead(Request $request,$name = null) {
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
                }else{
		 $id = $list['id'];
		}
            
            /* if(count($list) == 1) {
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

            
          //$currentroute = url()->current();
          //dd($currentroute);
            
           

             $pidtime = date('Ymdhis').mt_rand(5, 1500);
            $leaddttime = date('Y-m-d H:i:s');
            $addoneday = date('Y-m-d H:i:s');
            $projectlistnew = projectlist::where('id','=',$id)->get();
            $ins = 0;
            if(!empty($projectlistnew)){
                $campaigncode = $projectlistnew[0]['linkedin_campaigncode'];
                $plantcode = $projectlistnew[0]['plantcode'];

                if($campaigncode != '')
                {
                $tablename = $campaigncode.'_'.$plantcode;
                //$data = DB::connection('mysql2')->table($tablename)->where('Email','=',$request->Email)->count();
                $data = DB::connection('mysql2')->table($tablename)->select('lead_datetime')->where('Mobile','=','+'.$request->Mobile_phoneCode.$request->Mobile)->orderBy('lead_datetime', 'desc')->first();
                $pname = 'VGND '.$list->Project_name;

               
		//dd($tablename);
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
                        
                //$smscontent='Dear '.$name.',<br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Please <a href="'.$link.'">Click Here</a> to reset your password.<br><br>Thanks,<br>VGN<br><div style="    text-align: center;    font-size: 88%;    color: rgb(124, 124, 124);">For Any details : <a href="http://www.www.vgn.in">www.vgn.in</a><br><span style="    color: rgb(23, 79, 163);				font-weight: bold;">VGN Projects Estates Private Limited</span>&nbsp;- No.153, Wallace Garden, 2nd Street, Nungambakkam, Chennai-600006.<br>Call Us: +91 44 4343 9900</div>';
				$now = Carbon::now();
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
                             
        
                    $request->session()->put("otpdata", ['otp'=>$otptext,'hashedkey' => $hashedtext, 'PID'=>$pidtime, 'Project_name' => $pname,'Name'=> preg_replace("/[^A-Za-z.?! ]/","",$request->Name),
                    'Email' => $request->Email, 'Mobile' => '+'.$request->Mobile_phoneCode.$request->Mobile, 'City' => $request->City,
                    'msg'=>null, 'lead_datetime' => $leaddttime,'sourcetype'=>'Linkedin','plantcode' => $list->plantcode, 'linkedincampaigncode' => $list->linkedin_campaigncode,'triedcount' => 1 ]);


                  $check = $this->checkforotpurl();
			//dd($check);
    if ($check != '0') {
       // dd($check);
        return redirect()->route("$check");
    }

                    return redirect()->route('gotpproject', ['name' => $name]);
        }
        else{
            $request->session()->flash("24hours", $addoneday);
            //alert('You can enquire after 24 hours from the laste enquired datetime.');
            return redirect()->back();
            
        }
            
            
        }
    }


    public function gdotpinsertlead(Request $request,$name = null) {

if($request->session()->has('otpdata.hashedkey')){
    $sessiondata = $request->session()->get('otpdata');
    
}
else
{
     $checkformainurlinfunction = $this->checkformainurl($name);
            if ($checkformainurlinfunction != '0') {
                return redirect()->route("$checkformainurlinfunction");
            }
    return redirect()->route('gdproject', ['name' => $name]);
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
                }else{
		 $id = $list['id'];
                 $plantcode = $list['id'];
		}
            
            /*if(count($list) == 1) {
            $id = $list['id'];
            $plantcode = $list['id'];
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
                $campaigncode = $projectlistnew[0]['linkedin_campaigncode'];
                $plantcode = $projectlistnew[0]['plantcode'];

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
                    
                
                
                $lead_check = lead_data::where('Source_type','=','Linkedin')->where('Project_id','=',$id)->where('Email','=',$sessiondata['Email'])->count();

                $lead = new lead_data();
                $lead->Project_id = $id;
                $lead->PID = $pidtime;
                $lead->Project_name = $list->Project_name;
                $lead->Source_type = 'Linkedin';
                $lead->Name = $sessiondata['Name'];
                $lead->Email = $sessiondata['Email'];
                $lead->Mobile = $sessiondata['Mobile'];
                $lead->City = $sessiondata['City'];
                $lead->msg = null;
                $lead->lead_datetime = $leaddttime;
                $lead->plantcode = $list->plantcode;
                $lead->google_campaigncode = null;
                $lead->facebook_campaigncode = null;
                $lead->linkedin_campaigncode = $list->linkedin_campaigncode;
                $lead->website_campaigncode = null;
                $lead->mobile_campaigncode = null;
                $lead->created_at = date('Y-m-d H:i:s');
                $lead->updated_at = date('Y-m-d H:i:s');
                $lead->save();

                $request->session()->flash("thanks_session", $leaddttime);
            $sqftrange =  sqft_range::where('P_id','=',$id)->get();
            $request->session()->forget('otpdata');
            //return view('GoogleProject.thanks')->with(['list' => $list, 'sqftrange' => $sqftrange] );
            $checkforthankurlinfunction = $this->checkforthanksurl();
            if ($checkforthankurlinfunction != '0') {
                return redirect()->route("$checkforthankurlinfunction");
            }
            return redirect()->route('gdproject_thanks', ['name' => $name]);
        }
        else{
            $request->session()->flash("24hours", $addoneday);
            //alert('You can enquire after 24 hours from the laste enquired datetime.');
            
           

            $request->session()->forget('otpdata');
             $checkformainurlinfunction = $this->checkformainurl($name);
            if ($checkformainurlinfunction != '0') {
                return redirect()->route("$checkformainurlinfunction");
            }
            return redirect()->route('gdproject', ['name' => $name]);
            
        }

        }
        else{
           // dd($sessiondata);
            $count = $sessiondata['triedcount'] + 1;

            if ($sessiondata['triedcount'] > 3) {
            $request->session()->flash("error_msg", "Maximum Number of attempt tried!");
            $request->session()->forget('otpdata');

            $checkformainurlinfunction = $this->checkformainurl($name);
            if ($checkformainurlinfunction != '0') {
                return redirect()->route("$checkformainurlinfunction");
            }

            return redirect()->route('gdproject', ['name' => $name]); 
            } 
              $request->session()->put("otpdata.triedcount", $count);
            $request->session()->flash("error_msg", "OTP Code does not match!");
            
            return redirect()->back();
        }
            
            
        }
    }

    public function gdthanks($name = null) {


        if($name == null) {

           return redirect()->route('home');
       }
       else{

           if (!(session()->has('thanks_session'))) {

               $checkformainurlinfunction = $this->checkformainurl($name);
           if ($checkformainurlinfunction != '0') {
               return redirect()->route("$checkformainurlinfunction");
           }

           return redirect()->route("gdproject",['name',$name]);
       }
           
             $newname = str_replace("_"," ",strtolower($name));
                if(projectlist::where('Project_name','=',$newname)->count() == 0) {
                   
                   return redirect()->route('home');
               }

           $newlist =  projectlist::where('Project_name','=',$newname)->get();
           $list =  projectlist::find($newlist[0]['id']);
           
           if(empty($list)) {
                   
                   return redirect()->route('home');
               }else{
		 $id = $list['id'];
		}
           
           /*if(count($list) == 1) {
           $id = $list['id'];
           }
           else {
               return redirect()->route('home');
           }*/
           
                   $getthanksgobackurl = $this->checkforgobackurl();
                   if ($getthanksgobackurl == '0') {
                       //$getthanksgobackurl = 'https://www.vgn.in/googlead-display/project/'.$name;
                   }

           $sqftrange =  sqft_range::where('P_id','=',$id)->get();
		
	  	    $bannerpath = "images/banner/".$id;
            $mobilebanner = "images/banner/mobile/".$id;
            $data_banner_img_url = $this->single_link_parse_path_gen_link($bannerpath);
            $data_mobile_banner_img_url = $this->single_link_parse_path_gen_link($mobilebanner);
            $banner = $data_banner_img_url;
            $mobile_banner = $data_mobile_banner_img_url;

           return view('Linkedin.gdthanks')->with(['list' => $list, 'sqftrange' => $sqftrange,'getthanksgobackurl'=>$getthanksgobackurl, 'banner' => $banner, 'mobile_banner' => $mobile_banner] );
       }
   }

    /*start notting hill*/
   public function  nottinghilllinkedinenquiry()
   {
       return $this->gdshow('notting_hill');
   }


   public function postnottinghilllinkedinenquiry(Request $request)
   {
       return $this->gdinsertlead($request, 'notting_hill');
   }

   public function nottinghillshowotplinkedinenquiry(Request $request)
   {

    return $this->gdotpshow($request, 'notting_hill');   
   }
   public function nottinghillpostotplinkedinenquiry(Request $request)
   {
       return $this->gdotpinsertlead($request, 'notting_hill');  
   }

   public function nottinghillthanks()
   {
       return $this->gdthanks('notting_hill');  
   }

   public function nottinghillotplogout(Request $request)
   {
        if($request->session()->has('otpdata.hashedkey')){
    $request->session()->forget('otpdata');
    return redirect()->route('nottinghilllinkedinenquiry');
    
    }
    else
    {
    return redirect()->route('nottinghilllinkedinenquiry');
    }
   }
   /*end notting hill*/


/*start fairmont*/
   public function  fairmontlinkedinenquiry()
   {
       return $this->gdshow('fairmont');
   }


   public function postfairmontlinkedinenquiry(Request $request)
   {
	//dd($request);
       return $this->gdinsertlead($request, 'fairmont');
   }

   public function fairmontshowotplinkedinenquiry(Request $request)
   {

    return $this->gdotpshow($request, 'fairmont');   
   }
   public function fairmontpostotplinkedinenquiry(Request $request)
   {
       return $this->gdotpinsertlead($request, 'fairmont');  
   }

   public function fairmontthanks()
   {
       return $this->gdthanks('fairmont');  
   }

   public function fairmontotplogout(Request $request)
   {
        if($request->session()->has('otpdata.hashedkey')){
    $request->session()->forget('otpdata');
    return redirect()->route('fairmontlinkedinenquiry');
    
    }
    else
    {
    return redirect()->route('fairmontlinkedinenquiry');
    }
   }
   /*end fairmont*/

/*start oval gardens*/
   public function  ovalgardenslinkedinenquiry()
   {
       return $this->gdshow('oval_gardens');
   }


   public function postovalgardenslinkedinenquiry(Request $request)
   {
       return $this->gdinsertlead($request, 'oval_gardens');
   }

   public function ovalgardensshowotplinkedinenquiry(Request $request)
   {

    return $this->gdotpshow($request, 'oval_gardens');   
   }
   public function ovalgardenspostotplinkedinenquiry(Request $request)
   {
       return $this->gdotpinsertlead($request, 'oval_gardens');  
   }

   public function ovalgardensthanks()
   {
       return $this->gdthanks('oval_gardens');  
   }

   public function ovalgardensotplogout(Request $request)
   {
        if($request->session()->has('otpdata.hashedkey')){
    $request->session()->forget('otpdata');
    return redirect()->route('ovalgardenslinkedinenquiry');
    
    }
    else
    {
    return redirect()->route('ovalgardenslinkedinenquiry');
    }
   }
   /*end oval gardens*/

}
