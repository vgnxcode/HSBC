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

class ExternalProjectController extends Controller
{
    
    public function match($vendorlist, $tocheck)
    {
        foreach($vendorlist as $vendor){
            if (strpos($tocheck, $vendor) !== false) {
                return true;
            }
        }
        return false;
    }
    
     public function projectidmatch($vendor, $id)
    {
        $vendorlist = array();
        if($vendor == "Dinamalar"){
            $vendorlist = array("13","5","2");
        }

        if($vendor == "quikr_geo_fencing"){
            $vendorlist = array("2");
        }
		 
		 if($vendor == "Hindu"){
            $vendorlist = array("1");
        }
        if($vendor == "Times"){
            $vendorlist = array("1");
        }
         
        if(count($vendorlist) == 0){
            return false;
        }
         
        foreach($vendorlist as $vendorname){
            if (strpos($id, $vendorname) !== false) {
                return true;
            }
        }
        return false;
    }
    
    
        
    public function getthecampaigncode($vendor, $plantcode)
    {
        $campaignallowed = array();
        if($vendor == "Dinamalar"){
            $campaignallowed = array("4106" => "0000001231",
                                    "4107" => "0000001232",
                                    "4111" => "0000001233");
        }
		
		if($vendor == "Hindu"){
            $campaignallowed = array("4100" => "0000001591");
        }
        if($vendor == "Times"){
            $campaignallowed = array("4100" => "0000001592");
        }
        if($vendor == "quikr_geo_fencing"){
            $campaignallowed = array("4111" => "0000001743");
        }
         
        if(count($campaignallowed) == 0){
            return 0;
        }
         
        foreach($campaignallowed as $key => $val){
            if ($plantcode == $key) {
                return $val;
            }
        }
        return 0;
    }
    
    public function extshow(Request $request, $vendor = null, $name = null){
        
        if($request->session()->has('otpdata.hashedkey')){
            return redirect()->route('extotpproject', ['name' => $name, 'vendor' => $vendor]);
        }
        
        
        $checkarray = array("Dinamalar","Hindu","Times","quikr_geo_fencing");
        $valid = $this->match($checkarray, $vendor);
        
        if($valid == false){
            return redirect()->route('home');
        }
        
        
        if(($name == null)||($vendor == null)) {

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

            $status = $this->projectidmatch($vendor, $id);

            if($status == false){
            return redirect()->route('home');
            }
		}
            
            /*if(count($list) == 1) {
            $id = $list['id'];
            
            $status = $this->projectidmatch($vendor, $id);
            
            if($status == false){
            return redirect()->route('home');
            }
            
            }
            else {
                return redirect()->route('home');
            }*/

            $sqftrange =  sqft_range::where('P_id','=',$id)->get();

               

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
               
                $getcoordinates =  DB::table('googlemaplocation')->where('projectid','=',$id)->get();

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
    
                
                return view('ExternalProject.indivdisplay')->with(['list' => $list, 'sqftrange' => $sqftrange, 'floorplanfiles' => $floorplanfiles, 'consplanfiles' => $consplanfiles, 'ebrochplanfiles' => $ebrochplanfiles,'latitude' =>$latitude,'longitude' => $longitude, 'vendor' => $vendor] );
       
        }
        
    }

   

    public function otplogout(Request $request, $name = null) {

    if($request->session()->has('otpdata.hashedkey')){
    $request->session()->forget('otpdata');
    return redirect()->route('gdproject', ['name' => $name]);
    
    }
    else
    {
    return redirect()->route('gdproject', ['name' => $name]);
    }

}
    public function extotplogout(Request $request, $vendor = null, $name = null) {

    if($request->session()->has('otpdata.hashedkey')){
    $request->session()->forget('otpdata');
    return redirect()->route('extproject', ['vendor'=>$vendor, 'name' => $name]);
    
    }
    else
    {
    return redirect()->route('extproject', ['vendor'=>$vendor, 'name' => $name]);
    }

}
    
    public function gdotpshow(Request $request, $name = null) {

if($request->session()->has('otpdata.hashedkey')){
    $sessiondata = $request->session()->get('otpdata');
    
}
else
{
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
            
            /*if(count($list) == 1) {
            $id = $list['id'];
            }
            else {
                return redirect()->route('home');
            }*/

            $sqftrange =  sqft_range::where('P_id','=',$id)->get();

               
$pname = 'VGND '.$list->Project_name;

if ($sessiondata['Project_name'] != $pname) {
    
    $request->session()->forget('otpdata');
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
               
    
                
                return view('GoogleProject.otpverify')->with(['list' => $list, 'sqftrange' => $sqftrange, 'floorplanfiles' => $floorplanfiles, 'consplanfiles' => $consplanfiles, 'ebrochplanfiles' => $ebrochplanfiles] );
       
        }

        
    }
    
    public function extotpshow(Request $request, $vendor = null, $name = null) {

if($request->session()->has('otpdata.hashedkey')){
    $sessiondata = $request->session()->get('otpdata');
    
}
else
{
    return redirect()->route('extproject', ['name' => $name, 'vendor' => $vendor]);
}


        $checkarray = array("Dinamalar","Hindu","Times","quikr_geo_fencing");
        $valid = $this->match($checkarray, $vendor);
        
        if($valid == false){
            return redirect()->route('home');
        }


        if(($name == null)||($vendor == null)) {

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

                $status = $this->projectidmatch($vendor, $id);

            if($status == false){
            return redirect()->route('home');
            }
		}
            
            /*if(count($list) == 1) {
            $id = $list['id'];
                
                $status = $this->projectidmatch($vendor, $id);
            
            if($status == false){
            return redirect()->route('home');
            }
                
            }
            else {
                return redirect()->route('home');
            }*/

            $sqftrange =  sqft_range::where('P_id','=',$id)->get();

               
$pname = 'VGND '.$list->Project_name;

if ($sessiondata['Project_name'] != $pname) {
    
    $request->session()->forget('otpdata');
    return redirect()->route('extproject', ['name' => $name, 'vendor' => $vendor]);
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
               
                $getcoordinates =  DB::table('googlemaplocation')->where('projectid','=',$id)->get();

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
    
                
                return view('ExternalProject.otpverify')->with(['list' => $list, 'sqftrange' => $sqftrange, 'floorplanfiles' => $floorplanfiles, 'consplanfiles' => $consplanfiles, 'ebrochplanfiles' => $ebrochplanfiles,'latitude' => $latitude,'longitude' => $longitude, 'vendor' => $vendor] );
       
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

           /* if(count($list) == 1) {
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
                
                return view('GoogleProject.floorplan')->with(['list' => $list, 'sqftrange' => $sqftrange, 'floorplanfiles' => $floorplanfiles] );

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
            
           /* if(count($list) == 1) {
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
                
                return view('GoogleProject.construction')->with(['list' => $list, 'sqftrange' => $sqftrange, 'consplanfiles' => $consplanfiles] );

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
                $campaigncode = $projectlistnew[0]['google_campaigncode'];
                $plantcode = $projectlistnew[0]['plantcode'];

                if($campaigncode != '')
                {
                $tablename = $campaigncode.'_'.$plantcode;
                //$data = DB::connection('mysql2')->table($tablename)->where('Email','=',$request->Email)->count();
                $data = DB::connection('mysql2')->table($tablename)->select('lead_datetime')->where('Mobile','=','+'.$request->Mobile_phoneCode.$request->Mobile)->orderBy('lead_datetime', 'desc')->first();
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
                    $otptext = mt_rand(1090,9997);
                    $tohashtext = "JKL@!)~@!54VlK23"."$@".$otptext; 
                    $hashedtext = md5($tohashtext);

                 if(ctype_digit($request->Mobile)){
                    if (strlen($request->Mobile) == 10) {
                        
                //$smscontent='Dear '.$name.',<br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Please <a href="'.$link.'">Click Here</a> to reset your password.<br><br>Thanks,<br>VGN<br><div style="    text-align: center;    font-size: 88%;    color: rgb(124, 124, 124);">For Any details : <a href="http://www.vgn.in">www.vgn.in</a><br><span style="    color: rgb(23, 79, 163);				font-weight: bold;">VGN Property Developers Private Limited</span>&nbsp;- No.153, Wallace Garden, 2nd Street, Nungambakkam, Chennai-600006.<br>Call Us: +91 44 4343 9900</div>';
				$now = Carbon::now();
                //$smsurl = "http://www.adithya.me/adithya/Api/?username=vgn&password=vgn@123&senderid=VGNALT&message=$smscontent&msgtype=normal&mobileno=8754404619";
                $smscontent = 'Dear '. $request->Name.', Your One Time Password for  VGN '.$list->Project_name.' project enquiry is '.$otptext; 
                
               $sms_status = $this->smscurl($smscontent, $request->Mobile);               
                DB::table('sms_sent_data')->insert(['Mobile' => $request->Mobile_phoneCode.$request->Mobile,'sentdatetime' => "$now"]);
                    }
                }
                else
                {
                    $request->session()->flash("error_msg", "Not a Valid Mobile Number!");
                    return redirect()->back();
                }
                             
        
                    $request->session()->put("otpdata", ['otp'=>$otptext,'hashedkey' => $hashedtext, 'PID'=>$pidtime, 'Project_name' => $pname,'Name'=>$request->Name,
                    'Email' => $request->Email, 'Mobile' => '+'.$request->Mobile_phoneCode.$request->Mobile, 'City' => $request->City,
                    'msg'=>null, 'lead_datetime' => $leaddttime,'sourcetype'=>'Google','plantcode' => $list->plantcode, 'googlecampaigncode' => $list->google_campaigncode,'triedcount' => 1 ]);
                    return redirect()->route('gotpproject', ['name' => $name]);
        }
        else{
            $request->session()->flash("24hours", $addoneday);
            //alert('You can enquire after 24 hours from the laste enquired datetime.');
            return redirect()->back();
            
        }
            
            
        }
    }
    
    public function extinsertlead(Request $request,$vendor = null, $name = null) {
        
        $checkarray = array("Dinamalar","Hindu","Times","quikr_geo_fencing");
        $valid = $this->match($checkarray, $vendor);
        
        if($valid == false){
            return redirect()->route('home');
        }
        
        
        if(($name == null)||($vendor == null)) {

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

            $status = $this->projectidmatch($vendor, $id);

            if($status == false){
            return redirect()->route('home');
            }
		}
            
            /*if(count($list) == 1) {
            $id = $list['id'];
                
            $status = $this->projectidmatch($vendor, $id);
            
            if($status == false){
            return redirect()->route('home');
            }
            
                
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
                //$campaigncode = $projectlistnew[0]['google_campaigncode'];
                $plantcode = $projectlistnew[0]['plantcode'];
                
                    if($status == true){
                    $campaigncode = $this->getthecampaigncode($vendor, $plantcode);
                    }
                
                

                if($campaigncode != "0")
                {
                $tablename = $campaigncode.'_'.$plantcode;
                //$data = DB::connection('mysql2')->table($tablename)->where('Email','=',$request->Email)->count();
                $data = DB::connection('mysql2')->table($tablename)->select('lead_datetime')->where('Mobile','=','+'.$request->Mobile_phoneCode.$request->Mobile)->orderBy('lead_datetime', 'desc')->first();
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
                    $otptext = mt_rand(1090,9997);
                    $tohashtext = "JKL@!)~@!54VlK23"."$@".$otptext; 
                    $hashedtext = md5($tohashtext);

                 if(ctype_digit($request->Mobile)){
                    if (strlen($request->Mobile) == 10) {
                        
                //$smscontent='Dear '.$name.',<br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Please <a href="'.$link.'">Click Here</a> to reset your password.<br><br>Thanks,<br>VGN<br><div style="    text-align: center;    font-size: 88%;    color: rgb(124, 124, 124);">For Any details : <a href="http://www.vgn.in">www.vgn.in</a><br><span style="    color: rgb(23, 79, 163);				font-weight: bold;">VGN Property Developers Private Limited</span>&nbsp;- No.153, Wallace Garden, 2nd Street, Nungambakkam, Chennai-600006.<br>Call Us: +91 44 4343 9900</div>';
				$now = Carbon::now();
                //$smsurl = "http://www.adithya.me/adithya/Api/?username=vgn&password=vgn@123&senderid=VGNALT&message=$smscontent&msgtype=normal&mobileno=8754404619";
                $smscontent = 'Dear '. $request->Name.', Your One Time Password for  VGN '.$list->Project_name.' project enquiry is '.$otptext; 
                
               $sms_status = $this->smscurl($smscontent, $request->Mobile);               
                DB::table('sms_sent_data')->insert(['Mobile' => '+'.$request->Mobile_phoneCode.$request->Mobile,'sentdatetime' => "$now"]);
                    }
                }
                else
                {
                    $request->session()->flash("error_msg", "Not a Valid Mobile Number!");
                    return redirect()->back();
                }
                             
        
                    $request->session()->put("otpdata", ['otp'=>$otptext,'hashedkey' => $hashedtext, 'PID'=>$pidtime, 'Project_name' => $pname,'Name'=>$request->Name,
                    'Email' => $request->Email, 'Mobile' => '+'.$request->Mobile_phoneCode.$request->Mobile, 'City' => $request->City,
                    'msg'=>null, 'lead_datetime' => $leaddttime,'sourcetype'=>$vendor,'plantcode' => $list->plantcode, 'campaigncode' => $campaigncode,'triedcount' => 1 ]);
                    return redirect()->route('extotpproject', ['name' => $name, 'vendor' => $vendor]);
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
                $campaigncode = $projectlistnew[0]['google_campaigncode'];
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
                
                $lead_check = lead_data::where('Source_type','=','Google')->where('Project_id','=',$id)->where('Email','=',$sessiondata['Email'])->count();

                $lead = new lead_data();
                $lead->Project_id = $id;
                $lead->PID = $pidtime;
                $lead->Project_name = $list->Project_name;
                $lead->Source_type = 'Google';
                $lead->Name = $sessiondata['Name'];
                $lead->Email = $sessiondata['Email'];
                $lead->Mobile = $sessiondata['Mobile'];
                $lead->City = $sessiondata['City'];
                $lead->msg = null;
                $lead->lead_datetime = $leaddttime;
                $lead->plantcode = $list->plantcode;
                $lead->google_campaigncode = $list->google_campaigncode;
                $lead->facebook_campaigncode = null;
                $lead->linkedin_campaigncode = null;
                $lead->website_campaigncode = null;
                $lead->mobile_campaigncode = null;
                $lead->created_at = date('Y-m-d H:i:s');
                $lead->updated_at = date('Y-m-d H:i:s');
                $lead->save();

                $request->session()->flash("thanks_session", $leaddttime);
            $sqftrange =  sqft_range::where('P_id','=',$id)->get();
            $request->session()->forget('otpdata');
            //return view('GoogleProject.thanks')->with(['list' => $list, 'sqftrange' => $sqftrange] );
            return redirect()->route('gdproject_thanks', ['name' => $name]);
        }
        else{
            $request->session()->flash("24hours", $addoneday);
            //alert('You can enquire after 24 hours from the laste enquired datetime.');
            $request->session()->forget('otpdata');
            return redirect()->route('gdproject', ['name' => $name]);
            
        }

        }
        else{
           // dd($sessiondata);
            $count = $sessiondata['triedcount'] + 1;

            if ($sessiondata['triedcount'] > 3) {
            $request->session()->flash("error_msg", "Maximum Number of attempt tried!");
            $request->session()->forget('otpdata');
            return redirect()->route('gdproject', ['name' => $name]); 
            } 
              $request->session()->put("otpdata.triedcount", $count);
            $request->session()->flash("error_msg", "OTP Code does not match!");
            
            return redirect()->back();
        }
            
            
        }
    }
    
    public function extotpinsertlead(Request $request,$vendor = null,$name = null) {

if($request->session()->has('otpdata.hashedkey')){
    $sessiondata = $request->session()->get('otpdata');
    
}
else
{
    return redirect()->route('extproject', ['name' => $name, 'vendor' => $vendor]);
}
        
         $checkarray = array("Dinamalar","Hindu","Times","quikr_geo_fencing");
        $valid = $this->match($checkarray, $vendor);
        
        if($valid == false){
            return redirect()->route('home');
        }
        
        if(($name == null)||($vendor == null)) {

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

            $status = $this->projectidmatch($vendor, $id);

            if($status == false){
            return redirect()->route('home');
            }
		}
            
            /*if(count($list) == 1) {
            $id = $list['id'];
                
            $status = $this->projectidmatch($vendor, $id);
            
            if($status == false){
            return redirect()->route('home');
            }
                
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
                //$campaigncode = $projectlistnew[0]['google_campaigncode'];
                $plantcode = $projectlistnew[0]['plantcode'];
                
                 if($status == true){
                    $campaigncode = $this->getthecampaigncode($vendor, $plantcode);
                    }

                if($campaigncode != '0')
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
                
                $lead_check = lead_data::where('Source_type','=',$vendor)->where('Project_id','=',$id)->where('Email','=',$sessiondata['Email'])->count();

                $lead = new lead_data();
                $lead->Project_id = $id;
                $lead->PID = $pidtime;
                $lead->Project_name = $list->Project_name;
                $lead->Source_type = $vendor;
                $lead->Name = $sessiondata['Name'];
                $lead->Email = $sessiondata['Email'];
                $lead->Mobile = $sessiondata['Mobile'];
                $lead->City = $sessiondata['City'];
                $lead->msg = null;
                $lead->lead_datetime = $leaddttime;
                $lead->plantcode = $list->plantcode;
                $lead->google_campaigncode = null;
                $lead->facebook_campaigncode = null;
                $lead->linkedin_campaigncode = null;
                $lead->website_campaigncode = null;
                $lead->mobile_campaigncode = null;
                $lead->created_at = date('Y-m-d H:i:s');
                $lead->updated_at = date('Y-m-d H:i:s');
                $lead->save();

            $request->session()->flash("thanks_session", $leaddttime);
            $sqftrange =  sqft_range::where('P_id','=',$id)->get();
            $request->session()->forget('otpdata');
            //return view('GoogleProject.thanks')->with(['list' => $list, 'sqftrange' => $sqftrange] );
            return redirect()->route('extproject_thanks', ['vendor' => $vendor,'name' => $name]);
        }
        else{
            $request->session()->flash("24hours", $addoneday);
            //alert('You can enquire after 24 hours from the laste enquired datetime.');
            $request->session()->forget('otpdata');
            return redirect()->route('extproject', ['vendor' => $vendor, 'name' => $name]);
            
        }

        }
        else{
           // dd($sessiondata);
            $count = $sessiondata['triedcount'] + 1;

            if ($sessiondata['triedcount'] > 3) {
            $request->session()->flash("error_msg", "Maximum Number of attempt tried!");
            $request->session()->forget('otpdata');
            return redirect()->route('extproject', ['vendor' => $vendor, 'name' => $name]);

            } 
              $request->session()->put("otpdata.triedcount", $count);
            $request->session()->flash("error_msg", "OTP Code does not match!");
            
            return redirect()->back();
        }
            
            
        }
    }

    public function gthanks(Request $request, $name = null) {


         if($name == null) {

            return redirect()->route('home');
        }
        else{

            if (!($request->session()->has('thanks_session'))) {
			return redirect()->route("gproject",['name',$name]);
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

             

            $sqftrange =  sqft_range::where('P_id','=',$id)->get();
            return view('GoogleProject.thanks')->with(['list' => $list, 'sqftrange' => $sqftrange] );
        }
    }

    public function gdthanks($name = null) {


         if($name == null) {

            return redirect()->route('home');
        }
        else{

            if (!(session()->has('thanks_session'))) {
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

             

            $sqftrange =  sqft_range::where('P_id','=',$id)->get();
            return view('GoogleProject.gdthanks')->with(['list' => $list, 'sqftrange' => $sqftrange] );
        }
    }
    
    public function extthanks(Request $request, $vendor = null, $name = null) {


         if(($name == null)||($vendor == null)) {

            return redirect()->route('home');
        }
        else{

            if (!($request->session()->has('thanks_session'))) {
			return redirect()->route('extproject', ['vendor' => $vendor, 'name' => $name]);
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

             

            $sqftrange =  sqft_range::where('P_id','=',$id)->get();
            return view('ExternalProject.thanks')->with(['list' => $list, 'sqftrange' => $sqftrange, 'vendor' => $vendor] );
        }
    }
   
}
