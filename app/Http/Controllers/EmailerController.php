<?php

namespace vgn\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use vgn\projectlist;
use vgn\sqft_range;
use vgn\lead_data;
use File;
use DB;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class EmailerController extends Controller
{

	public function showfairmont()
	{
		return view('Emailer.index');
	}
    public function show($name = null) {

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
            
           /* if(is_array($list) && count($list) == 1) {
	
            $id = $list[0]['id'];
            }
            else {
                return redirect()->route('home');
            }*/
            
            $sqftrange =  sqft_range::where('P_id','=',$id)->get();

                

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
               

                
                return view('Emailer.individualprojectpage')->with(['list' => $list, 'sqftrange' => $sqftrange, 'floorplanfiles' => $floorplanfiles, 'consplanfiles' => $consplanfiles, 'ebrochplanfiles' => $ebrochplanfiles,'latitude'=>$latitude] );
       
        }

        
    }

    public function googlemap(Request $request, $name = null) {
    	//dd($request);

    	//dd(url()->previous());
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
            
                          
            $getcoordinates =  DB::table('googlemaplocation')->where('projectid','=',$newlist[0]['id'])->get();
            //dd($newlist[0]['id']);
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
                session()->flash('error_msg', "No Map details available!");
                return Redirect::to(url()->previous());
            }

            

               

                
                return view('Emailer.googlemap')->with(['list' => $list,'latitude'=>$latitude,'longitude'=>$longitude] );
       
        }

        
    }
	
	 public function embeddedgooglemap(Request $request, $name = null) {
        //dd($request);

        //dd(url()->previous());
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
            
                          
            $getdata =  DB::table('projectlist')->where(['id' => $newlist[0]['id']])->where('googlemap_link','!=', null)->get();
            
            if(count($getdata) > 0){
                $gmapvalid = 1;
                foreach ($getdata as $key => $value) {
                    $embedlink = $value->googlemap_link;
                }
            }
            else{
                $gmapvalid = 0;
                $embedlink = 0;
                session()->flash('error_msg', "No Map details available!");
                return Redirect::to(url()->previous());
            }

            

               

                
                return view('Emailer.embeddedgooglemap')->with(['list' => $list,'embedlink'=>$embedlink,'gmapvalid' =>$gmapvalid] );
       
        }

        
    }

     public function pdshow($name = null) {

        if(session()->has('potpdata.hashedkey')){
    return redirect()->route('potpproject', ['name' => $name]);
    
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
            
            if(count($list) == 1) {
            $id = $list['id'];
            }
            else {
                return redirect()->route('home');
            }
            
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
               

                
                return view('Emailer.individualprojectpage')->with(['list' => $list, 'sqftrange' => $sqftrange, 'floorplanfiles' => $floorplanfiles, 'consplanfiles' => $consplanfiles, 'ebrochplanfiles' => $ebrochplanfiles] );
       
        }

        
    }


     public function pdinsertlead(Request $request,$name = null) {
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
            
            if(count($list) == 1) {
            $id = $list['id'];
            }
            else {
                return redirect()->route('home');
            }

            

            

            $validate = $this->validate($request, [
            'Name' => 'required|regex:/^[\pL\s\.]+$/u|min:4',
            'Email' => 'required|email',
            'Mobile' => 'required|digits:10',
            'City' => 'required|regex:/^[\pL\s]+$/u|min:4'
            ]);


           

             $pidtime = date('Ymdhis').mt_rand(5, 1500);
            $leaddttime = date('Y-m-d H:i:s');
            $addoneday = date('Y-m-d H:i:s');
            $projectlistnew = projectlist::where('id','=',$id)->get();
            $ins = 0;
            if(!empty($projectlistnew)){
                $campaigncode = $projectlistnew[0]['website_campaigncode'];
                $plantcode = $projectlistnew[0]['plantcode'];

                if($campaigncode != '')
                {
                $tablename = $campaigncode.'_'.$plantcode;
                //$data = DB::connection('mysql2')->table($tablename)->where('Email','=',$request->Email)->count();
                $data = DB::connection('mysql2')->table($tablename)->select('lead_datetime')->where('Mobile','=',$request->Mobile)->orderBy('lead_datetime', 'desc')->first();
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
                        
                //$smscontent='Dear '.$name.',<br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Please <a href="'.$link.'">Click Here</a> to reset your password.<br><br>Thanks,<br>VGN<br><div style="    text-align: center;    font-size: 88%;    color: rgb(124, 124, 124);">For Any details : <a href="http://www.vgn.in">www.vgn.in</a><br><span style="    color: rgb(23, 79, 163);              font-weight: bold;">VGN Property Developers Private Limited</span>&nbsp;- No.153, Wallace Garden, 2nd Street, Nungambakkam, Chennai-600006.<br>Call Us: +91 44 4343 9900</div>';
                $now = Carbon::now();
                //$smsurl = "http://www.adithya.me/adithya/Api/?username=vgn&password=vgn@123&senderid=VGNALT&message=$smscontent&msgtype=normal&mobileno=8754404619";
                $smscontent = 'Dear '. $request->Name.', Your One Time Password for  VGN '.$list->Project_name.' project enquiry is '.$otptext; 
                
               $sms_status = $this->smscurl($smscontent, $request->Mobile);               
                DB::table('sms_sent_data')->insert(['Mobile' => $request->Mobile,'sentdatetime' => "$now"]);
                    }
                }
                else
                {
                    session()->flash("error_msg", "Not a Valid Mobile Number!");
                    return redirect()->back();
                }
                             
        
                    $request->session()->put("potpdata", ['otp'=>$otptext,'hashedkey' => $hashedtext, 'PID'=>$pidtime, 'Project_name' => $pname,'Name'=>$request->Name,
                    'Email' => $request->Email, 'Mobile' => $request->Mobile, 'City' => $request->City,
                    'msg'=>null, 'lead_datetime' => $leaddttime,'sourcetype'=>'Website','plantcode' => $list->plantcode, 'websitecampaigncode' => $list->website_campaigncode,'triedcount' => 1 ]);
                    return redirect()->route('potpproject', ['name' => $name]);
        }
        else{
            session()->flash("24hours", $addoneday);
            //alert('You can enquire after 24 hours from the laste enquired datetime.');
            return redirect()->back();
            
        }
            
            
        }
    }

    public function potpshow(Request $request, $name = null) {

if(session()->has('potpdata.hashedkey')){
    $sessiondata = session()->get('potpdata');
    
}
else
{
    return redirect()->route('emailerproject', ['name' => $name]);
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
            
            if(count($list) == 1) {
            $id = $list['id'];
            }
            else {
                return redirect()->route('home');
            }

            $sqftrange =  sqft_range::where('P_id','=',$id)->get();

               
$pname = 'VGND '.$list->Project_name;

if ($sessiondata['Project_name'] != $pname) {
    
    $request->session()->forget('potpdata');
    return redirect()->route('emailerproject', ['name' => $name]);
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
               
    
                
                return view('Emailer.otpverify')->with(['list' => $list, 'sqftrange' => $sqftrange, 'floorplanfiles' => $floorplanfiles, 'consplanfiles' => $consplanfiles, 'ebrochplanfiles' => $ebrochplanfiles] );
       
        }

        
    }


     public function potpinsertlead(Request $request,$name = null) {

if(session()->has('potpdata.hashedkey')){
    $sessiondata = session()->get('potpdata');
    
}
else
{
    return redirect()->route('emailerproject', ['name' => $name]);
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
            
            if(count($list) == 1) {
            $id = $list['id'];
            }
            else {
                return redirect()->route('home');
            }

            

            

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
                $campaigncode = $projectlistnew[0]['website_campaigncode'];
                $plantcode = $projectlistnew[0]['plantcode'];

                if($campaigncode != '')
                {
                $tablename = $campaigncode.'_'.$plantcode;
                //dd($tablename);
                //$data = DB::connection('mysql2')->table($tablename)->where('Email','=',$request->Email)->count();
                $data = DB::connection('mysql2')->table($tablename)->select('lead_datetime')->where('Email','=',$sessiondata['Email'])->orderBy('lead_datetime', 'desc')->first();
                $pname = 'VGND '.$list->Project_name;

               //dd($data);

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
                   // dd($leaddttime);
             $insert = DB::connection('mysql2')->table($tablename )->insert(
                    ['Id' => null, 'PID' => $pidtime, 'Project_name' => $pname,'Name'=>$sessiondata['Name'],
                    'Email' => $sessiondata['Email'], 'Mobile' => $sessiondata['Mobile'], 'City' => $sessiondata['City'],
                    'msg'=>null, 'lead_datetime' => $leaddttime, 'inserteddate' => date('Y-m-d H:i:s')]
                );
                
                $lead_check = lead_data::where('Source_type','=','Website')->where('Project_id','=',$id)->where('Email','=',$sessiondata['Email'])->count();

                $lead = new lead_data();
                $lead->Project_id = $id;
                $lead->PID = $pidtime;
                $lead->Project_name = $list->Project_name;
                $lead->Source_type = 'Website';
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
                $lead->website_campaigncode = $list->website_campaigncode;
                $lead->mobile_campaigncode = null;
                $lead->created_at = date('Y-m-d H:i:s');
                $lead->updated_at = date('Y-m-d H:i:s');
                $lead->save();

                session()->flash("thanks_session", $leaddttime);
            $sqftrange =  sqft_range::where('P_id','=',$id)->get();
            $request->session()->forget('potpdata');
            //return view('GoogleProject.thanks')->with(['list' => $list, 'sqftrange' => $sqftrange] );
            return redirect()->route('project_thanks', ['name' => $name]);
        }
        else{
            session()->flash("24hours", $addoneday);
            //alert('You can enquire after 24 hours from the laste enquired datetime.');
            $request->session()->forget('potpdata');
            return redirect()->route('emailerproject', ['name' => $name]);
            
        }

        }
        else{
           // dd($sessiondata);
            $count = $sessiondata['triedcount'] + 1;

            if ($sessiondata['triedcount'] > 3) {
            session()->flash("error_msg", "Maximum Number of attempt tried!");
            $request->session()->forget('potpdata');
            return redirect()->route('emailerproject', ['name' => $name]); 
            } 
              $request->session()->put("potpdata.triedcount", $count);
            session()->flash("error_msg", "OTP Code does not match!");
            
            return redirect()->back();
        }
            
            
        }
    }

    public function floorfn($name = null) {

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


            

             $floordirectory = Storage::disk('s3')->files("/images/floorplan/".$id);
                
                $floorplanfiles = array();
                if(count($floordirectory) > 0) {
                $floorplanfiles = Storage::disk('s3')->files("/images/floorplan/".$id);
                }
                else{
                    return redirect()->route('emailerproject', ['name' => $name]);
                }
                $sqftrange =  sqft_range::where('P_id','=',$id)->get();
                
                return view('Emailer.floorplan')->with(['list' => $list, 'sqftrange' => $sqftrange, 'floorplanfiles' => $floorplanfiles] );

        }

    }

    public function linkotplogout(Request $request, $name = null, $routelink = null) {
        $url = "http://www.vgn.in/$name/$routelink";
    if(session()->has('lotpdata.hashedkey')){
    $request->session()->forget('lotpdata');
    return Redirect::to($url);
    
    }
    else
    {
    return Redirect::to($url);
    }

}

    public function otplogout(Request $request, $name = null) {

    if(session()->has('potpdata.hashedkey')){
    $request->session()->forget('potpdata');
    return redirect()->route('emailerproject', ['name' => $name]);
    
    }
    else
    {
    return redirect()->route('emailerproject', ['name' => $name]);
    }

}

    public function constructionfn($name = null) {

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
            
            if(count($list) == 1) {
            $id = $list['id'];
            }
            else {
                return redirect()->route('home');
            }

            

             $consdirectory = public_path()."/images/construction/".$id;
                $cons_dir_exist = is_dir($consdirectory);
                $consplanfiles = array();
                if($cons_dir_exist === true) {
                $consplanfiles = File::allFiles($consdirectory);

                }
                else{
                    return redirect()->route('emailerproject', ['name' => $name]);
                }
                $sqftrange =  sqft_range::where('P_id','=',$id)->get();
                
                return view('Emailer.construction')->with(['list' => $list, 'sqftrange' => $sqftrange, 'consplanfiles' => $consplanfiles] );

        }

    }

     public function constructionfntest($name = null) {

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

            
             $imagearray = array();
             
             $consdirectory = Storage::disk('s3')->files("/images/construction/".$id);
             
                
                $consplanfiles = array();
                if(count($consdirectory) > 0) {
                //$consplanfiles = File::allFiles($consdirectory);
                
               $consplanfiles = Storage::disk('s3')->files("/images/construction/".$id);
        //dd($consplanfiles);
                
                }
                else{
                    return redirect()->route('emailerproject', ['name' => $name]);
                }
                //$sqftrange =  sqft_range::where('P_id','=',$id)->get();
               // dd($imagearray);
                $folder = 0;
                
                return view('Emailer.constructionnew')->with(['list' => $list, 'consplanfiles' => $consplanfiles,'folder'=>$folder] );

        }

    }

     public function constructionfntestfolder($name = null, $folder = null) {

         if(($name == null) || ($folder == null) ) {

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
            
            if(count($list) == 1) {
            $id = $list['id'];
            }
            else {
                return redirect()->route('home');
            }

            
             $imagearray = array();
             
             $consdirectory = public_path()."/images/construction/".$id.'/'.$folder;
                $cons_dir_exist = is_dir($consdirectory);
                $consplanfiles = array();
                if($cons_dir_exist === true) {
                $consplanfiles = File::allFiles($consdirectory);
                //dd($consplanfiles);
                $k = 0;
                foreach ($consplanfiles as $value) {
                    //dd($value->getRelativePath());

                    if (!empty($value->getRelativePath())) {
                       // dd($value->getRelativePathname());
                        $imagearray[$value->getRelativePath()][] = "/images/construction/".$id."/".$value->getRelativePathname();
                        $imagearray[$value->getRelativePath()]['hasfolder'] = true;
                        $imagearray[$value->getRelativePath()]['pathname'] = $value->getRelativePath();
                    }
                    else{
                        $imagearray[$k]['image'] = "/images/construction/".$id."/$folder/".$value->getRelativePathname();
                        $imagearray[$k]['hasfolder'] = false;
                        $k++;
                    }
                }
                }
                else{
                    return redirect()->route('emailerproject', ['name' => $name]);
                }
                //$sqftrange =  sqft_range::where('P_id','=',$id)->get();
                //dd($imagearray);
                //dd($folder);

                
                return view('Emailer.constructionnew')->with(['list' => $list, 'imagearray' => $imagearray, 'consplanfiles' => $consplanfiles,'folder'=>$folder] );

        }

    }

    public function newconstructionfn($name = null) {

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
            
            if(count($list) == 1) {
            $id = $list['id'];
            }
            else {
                return redirect()->route('home');
            }

            

             $consdirectory = public_path()."/images/construction/".$id;
                $cons_dir_exist = is_dir($consdirectory);
                $consplanfiles = array();
                if($cons_dir_exist === true) {
                $consplanfiles = File::allFiles($consdirectory);
                }
                else{
                    return redirect()->route('emailerproject', ['name' => $name]);
                }
                $sqftrange =  sqft_range::where('P_id','=',$id)->get();
                
                return view('Project.newconstruction')->with(['list' => $list, 'sqftrange' => $sqftrange, 'consplanfiles' => $consplanfiles] );

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

$fullurl = "http://sms6.rmlconnect.net:8080/bulksms/bulksms";
$fields = array(
    'username'      => 'vgnotp',
    'password'      => 'Vgn@!($@',
    'type'    => 0,
    'dlr'      => 1,
    'destination'      => $mobileno,
    'source'      => 'VGNOTP',
    'message'      => $message
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

    public function insertlead(Request $request,$name = null) {
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

           

            

            $validate = $this->validate($request, [
            'Name' => 'required|regex:/^[a-zA-Z\s]+$/u|min:4|max:40',
			'Email' => 'required|email|max:40',
			'Mobile' => 'required|digits:10',
            'Mobile_phoneCode' => 'required',
            'City' => 'required|regex:/^[a-zA-Z\s]+$/u|min:4|max:20'
			]);

           // dd($request);

            $pidtime = date('Ymdhis').mt_rand(5, 1500);
            $leaddttime = date('Y-m-d H:i:s');
            $addoneday = date('Y-m-d H:i:s');
            $ins = 0;
            $insweb = 0;

             $projectlistnew = projectlist::where('id','=',$id)->where('Status','=','Ongoing')->get();
            if(!empty($projectlistnew)){


                
                $campaigncode = $projectlistnew[0]['emailer_campaigncode'];
                $plantcode = $projectlistnew[0]['plantcode'];

                if($campaigncode != '')
                {
                    
                $tablename = $campaigncode.'_'.$plantcode;
                //$data = DB::connection('mysql2')->table($tablename)->where('Email','=',$request->Email)->count();
                $data = DB::connection('mysql2')->table($tablename)->select('lead_datetime')->where('Email','=',$request->Email)->orderBy('lead_datetime', 'desc')->first();
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
                else{
                    
                $lead_check = lead_data::select('lead_datetime')->where('Source_type','=','Emailer')->where('Project_id','=',$id)->where('Email','=',$request->Email)->orderBy('lead_datetime', 'desc')->first();
                    //only website not leaddb
                    
                
                     if(!empty($lead_check)) {
                    $leadexist = $lead_check->lead_datetime;
                    
                                   
                $dt = Carbon::parse($leadexist);
                
                $now = Carbon::now();
                $dtformat = Carbon::create($dt->year, $dt->month, $dt->day, $dt->hour, $dt->minute, $dt->second);
                $addoneday = $dtformat->addHours(24);
                
                $are_different = $now->gt($addoneday);
                    
                    if($are_different === true) {
                        $insweb = 1;
                    }
                    else{
                    
                    $insweb = 0;
                    }
                    
                }

                 if(empty($lead_check)) {
                     
                   $insweb = 1;
                   
                }


                }
            }
            
            


            if(($ins == 0)&&($insweb == 0))
            {
                
                 session()->flash("24hours", $addoneday);
            //alert('You can enquire after 24 hours from the laste enquired datetime.');
            return redirect()->back();
            }
            elseif(($ins == 0)&&($insweb == 1))
            {
                
                $lead = new lead_data();
                $lead->Project_id = $id;
                $lead->PID = $pidtime;
                $lead->Project_name = $list->Project_name;
                $lead->Source_type = 'Emailer';
                $lead->Name = $request->Name;
                $lead->Email = $request->Email;
                $lead->Mobile = '+'.$request->Mobile_phoneCode.$request->Mobile;
                $lead->City = $request->City;
                $lead->msg = null;
                $lead->lead_datetime = $leaddttime;
                $lead->plantcode = $list->plantcode;
                $lead->google_campaigncode = null;
                $lead->facebook_campaigncode = null;
                $lead->linkedin_campaigncode = null;
                $lead->website_campaigncode = null;
                $lead->mobile_campaigncode = null;
                $lead->emailer_campaigncode = $list->emailer_campaigncode;
                $lead->created_at = date('Y-m-d H:i:s');
                $lead->updated_at = date('Y-m-d H:i:s');
                $lead->save();
            
            session()->flash("thanks_session", $leaddttime);
            $sqftrange =  sqft_range::where('P_id','=',$id)->get();
            //return view('Project.thanks')->with(['list' => $list, 'sqftrange' => $sqftrange] );
            return redirect()->route('project_thanks', ['name' => $name]);
            
            }
            elseif(($ins == 1)&&($insweb == 0)){
                
                 $insert = DB::connection('mysql2')->table($tablename )->insert(
                    ['Id' => null, 'PID' => $pidtime, 'Project_name' => $pname,'Name'=>$request->Name,
                    'Email' => $request->Email, 'Mobile' => '+'.$request->Mobile_phoneCode.$request->Mobile, 'City' => $request->City,
                    'msg'=>null, 'lead_datetime' => $leaddttime, 'inserteddate' => date('Y-m-d H:i:s')]
                );
                

                $lead = new lead_data();
                $lead->Project_id = $id;
                $lead->PID = $pidtime;
                $lead->Project_name = $list->Project_name;
                $lead->Source_type = 'Emailer';
                $lead->Name = $request->Name;
                $lead->Email = $request->Email;
                $lead->Mobile = '+'.$request->Mobile_phoneCode.$request->Mobile;
                $lead->City = $request->City;
                $lead->msg = null;
                $lead->lead_datetime = $leaddttime;
                $lead->plantcode = $list->plantcode;
                $lead->google_campaigncode = null;
                $lead->facebook_campaigncode = null;
                $lead->linkedin_campaigncode = null;
                $lead->website_campaigncode = null;
                $lead->mobile_campaigncode = null;
                $lead->emailer_campaigncode = $list->emailer_campaigncode;
                $lead->created_at = date('Y-m-d H:i:s');
                $lead->updated_at = date('Y-m-d H:i:s');
                $lead->save();
            
            session()->flash("thanks_session", $leaddttime);
            $sqftrange =  sqft_range::where('P_id','=',$id)->get();
            //return view('Project.thanks')->with(['list' => $list, 'sqftrange' => $sqftrange] );
            return redirect()->route('emailerproject_thanks', ['name' => $name]);
            }
            else{
                
                 session()->flash("24hours", $addoneday);
            //alert('You can enquire after 24 hours from the laste enquired datetime.');
            return redirect()->back();
            }
        }
    }

    public function thanks($name = null) {


         if($name == null) {

            return redirect()->route('home');
        }
        else{

            if (!(session()->has('thanks_session'))) {
			return redirect()->route("project",['name',$name]);
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
            
           /* if(count($list) == 1) {
            $id = $list['id'];
            }
            else {
                return redirect()->route('home');
            }*/

            

            $sqftrange =  sqft_range::where('P_id','=',$id)->get();
            return view('Emailer.thanks')->with(['list' => $list, 'sqftrange' => $sqftrange] );
        }
    }


    public function linkchangeurl($name, $url, $newpagename) {
        

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
                
                return view('linkchange.'.$url)->with(['list' => $list, 'sqftrange' => $sqftrange, 'floorplanfiles' => $floorplanfiles, 'consplanfiles' => $consplanfiles, 'ebrochplanfiles' => $ebrochplanfiles, 'newpagename'=> $newpagename,'latitude'=>$latitude] );

    }

 public function postlinkchangeotp(Request $request,$name = null, $routelink = null) {
$url = "http://vgn.in/$name/$routelink";

$thanksurl = "http://vgn.in/$name/thank-you/$routelink";
if(session()->has('lotpdata.hashedkey')){
    $sessiondata = session()->get('lotpdata');
    
}
else
{
    
    return Redirect::to($url);
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
                $campaigncode = $projectlistnew[0]['website_campaigncode'];
                $plantcode = $projectlistnew[0]['plantcode'];

                if($campaigncode != '')
                {
                $tablename = $campaigncode.'_'.$plantcode;
                //dd($tablename);
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
                   // dd($leaddttime);
             $insert = DB::connection('mysql2')->table($tablename )->insert(
                    ['Id' => null, 'PID' => $pidtime, 'Project_name' => $pname,'Name'=>$sessiondata['Name'],
                    'Email' => $sessiondata['Email'], 'Mobile' => $sessiondata['Mobile'], 'City' => $sessiondata['City'],
                    'msg'=>null, 'lead_datetime' => $leaddttime, 'inserteddate' => date('Y-m-d H:i:s')]
                );
                
                $lead_check = lead_data::where('Source_type','=','Website')->where('Project_id','=',$id)->where('Email','=',$sessiondata['Email'])->count();

                $lead = new lead_data();
                $lead->Project_id = $id;
                $lead->PID = $pidtime;
                $lead->Project_name = $list->Project_name;
                $lead->Source_type = 'Website';
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
                $lead->website_campaigncode = $list->website_campaigncode;
                $lead->mobile_campaigncode = null;
                $lead->created_at = date('Y-m-d H:i:s');
                $lead->updated_at = date('Y-m-d H:i:s');
                $lead->save();

                session()->flash("thanks_session", $leaddttime);
            $sqftrange =  sqft_range::where('P_id','=',$id)->get();
            $request->session()->forget('lotpdata');
            //return view('GoogleProject.thanks')->with(['list' => $list, 'sqftrange' => $sqftrange] );
            session()->flash("thanks_session", $leaddttime);
            return Redirect::to($thanksurl);
        }
        else{
            session()->flash("24hours", $addoneday);
            //alert('You can enquire after 24 hours from the laste enquired datetime.');
            $request->session()->forget('lotpdata');
            return Redirect::to($url);
            
        }

        }
        else{
           // dd($sessiondata);
            $count = $sessiondata['triedcount'] + 1;

            if ($sessiondata['triedcount'] > 3) {
            session()->flash("error_msg", "Maximum Number of attempt tried!");
            $request->session()->forget('potpdata');
            return redirect()->route('emailerproject', ['name' => $name]); 
            } 
              $request->session()->put("potpdata.triedcount", $count);
            session()->flash("error_msg", "OTP Code does not match!");
            
            return redirect()->back();
        }
            
            
        }
    }


     public function linkchangeinsertlead($request,$name, $routename, $newpagename) {
         
        
            

            $newlist =  projectlist::where('Project_name','=',$name)->get();
            
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



            $pidtime = date('Ymdhis').mt_rand(5, 1500);
            $leaddttime = date('Y-m-d H:i:s');

            $addoneday = date('Y-m-d H:i:s');
            $ins = 0;
            $insweb = 0;

             $projectlistnew = projectlist::where('id','=',$id)->where('Status','=','Ongoing')->get();
            if(!empty($projectlistnew)){
                
                $campaigncode = $projectlistnew[0]['website_campaigncode'];
                $plantcode = $projectlistnew[0]['plantcode'];

                if($campaigncode != '')
                {
                    
                $tablename = $campaigncode.'_'.$plantcode;
                //$data = DB::connection('mysql2')->table($tablename)->where('Email','=',$request->Email)->count();
                $data = DB::connection('mysql2')->table($tablename)->select('lead_datetime')->where('Email','=',$request->Email)->orderBy('lead_datetime', 'desc')->first();
                $pname = 'VGND '.$list->Project_name;

               
                
             if(!empty($data)) {
                  $leadexist = $data->lead_datetime;
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
                else{
                    
                $lead_check = lead_data::select('lead_datetime')->where('Source_type','=','Website')->where('Project_id','=',$id)->where('Email','=',$request->Email)->orderBy('lead_datetime', 'desc')->first();
                    //only website not leaddb
                    

                     if(!empty($lead_check)) {
                    $leadexist = $lead_check->lead_datetime;
                    
                $dt = Carbon::parse($leadexist);

                $now = Carbon::now();
                $dtformat = Carbon::create($dt->year, $dt->month, $dt->day, $dt->hour, $dt->minute, $dt->second);
                $addoneday = $dtformat->addHours(24);
                
                $are_different = $now->gt($addoneday);

                    if($are_different === true) {
                        $insweb = 1;
                    }
                    else{
                    
                    $insweb = 0;
                    }
                    
                }

                 if(empty($lead_check)) {
                     
                   $insweb = 1;
                   
                }


                }
            }
            

               if(($ins == 0)&&($insweb == 0))
            {
                
                 session()->flash("24hours", $addoneday);
            //alert('You can enquire after 24 hours from the laste enquired datetime.');
            return redirect()->back();
            }
            elseif(($ins == 0)&&($insweb == 1))
            {
                
                $lead = new lead_data();
                $lead->Project_id = $id;
                $lead->PID = $pidtime;
                $lead->Project_name = $list->Project_name;
                $lead->Source_type = 'Website';
                $lead->Name = $request->Name;
                $lead->Email = $request->Email;
                $lead->Mobile = '+'.$request->Mobile_phoneCode.$request->Mobile;
                $lead->City = $request->City;
                $lead->msg = null;
                $lead->lead_datetime = $leaddttime;
                $lead->plantcode = $list->plantcode;
                $lead->google_campaigncode = null;
                $lead->facebook_campaigncode = null;
                $lead->linkedin_campaigncode = null;
                $lead->website_campaigncode = $list->website_campaigncode;
                $lead->mobile_campaigncode = null;
                $lead->created_at = date('Y-m-d H:i:s');
                $lead->updated_at = date('Y-m-d H:i:s');
                $lead->save();
            
            session()->flash("thanks_session", $leaddttime);
            $sqftrange =  sqft_range::where('P_id','=',$id)->get();
            //return view('Project.thanks')->with(['list' => $list, 'sqftrange' => $sqftrange] );
            return redirect()->route($routename);
            
            }
            elseif(($ins == 1)&&($insweb == 0)){
                
                 $insert = DB::connection('mysql2')->table($tablename )->insert(
                    ['Id' => null, 'PID' => $pidtime, 'Project_name' => $pname,'Name'=>$request->Name,
                    'Email' => $request->Email, 'Mobile' => '+'.$request->Mobile_phoneCode.$request->Mobile, 'City' => $request->City,
                    'msg'=>null, 'lead_datetime' => $leaddttime, 'inserteddate' => date('Y-m-d H:i:s')]
                );
                

                $lead = new lead_data();
                $lead->Project_id = $id;
                $lead->PID = $pidtime;
                $lead->Project_name = $list->Project_name;
                $lead->Source_type = 'Website';
                $lead->Name = $request->Name;
                $lead->Email = $request->Email;
                $lead->Mobile = '+'.$request->Mobile_phoneCode.$request->Mobile;
                $lead->City = $request->City;
                $lead->msg = null;
                $lead->lead_datetime = $leaddttime;
                $lead->plantcode = $list->plantcode;
                $lead->google_campaigncode = null;
                $lead->facebook_campaigncode = null;
                $lead->linkedin_campaigncode = null;
                $lead->website_campaigncode = $list->website_campaigncode;
                $lead->mobile_campaigncode = null;
                $lead->created_at = date('Y-m-d H:i:s');
                $lead->updated_at = date('Y-m-d H:i:s');
                $lead->save();
            
            session()->flash("thanks_session", $leaddttime);
            $sqftrange =  sqft_range::where('P_id','=',$id)->get();
            //return view('Project.thanks')->with(['list' => $list, 'sqftrange' => $sqftrange] );
            return redirect()->route($routename);
            }
            else{
                
                 session()->flash("24hours", $addoneday);
            //alert('You can enquire after 24 hours from the laste enquired datetime.');
            return redirect()->back();
            }
        
    }


    public function linkchangethanks($name, $url, $newpagename) {


            if (!(session()->has('thanks_session'))) {
			return redirect()->route("project",['name',$name]);
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
            
           /* if(count($list) == 1) {
            $id = $list['id'];
            }
            else {
                return redirect()->route('home');
            }*/

            

            $sqftrange =  sqft_range::where('P_id','=',$id)->get();
            return view('linkchange.'.$url)->with(['list' => $list, 'sqftrange' => $sqftrange, 'newpagename'=>$newpagename] );
        
    }


     public function linkchanageinsertlead($request, $name, $routename, $newpagename, $routelink) {
        $url = "http://vgn.in/$name/$routelink";
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
            
            if(count($list) == 1) {
            $id = $list['id'];
            }
            else {
                return redirect()->route('home');
            }

                       

             $pidtime = date('Ymdhis').mt_rand(5, 1500);
            $leaddttime = date('Y-m-d H:i:s');
            $addoneday = date('Y-m-d H:i:s');
            $projectlistnew = projectlist::where('id','=',$id)->get();
            $ins = 0;
            if(!empty($projectlistnew)){
                $campaigncode = $projectlistnew[0]['website_campaigncode'];
                $plantcode = $projectlistnew[0]['plantcode'];

                if($campaigncode != '')
                {
                $tablename = $campaigncode.'_'.$plantcode;
                //$data = DB::connection('mysql2')->table($tablename)->where('Email','=',$request->Email)->count();
                $data = DB::connection('mysql2')->table($tablename)->select('lead_datetime')->where('Mobile','=',$request->Mobile)->orderBy('lead_datetime', 'desc')->first();
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
                        
                //$smscontent='Dear '.$name.',<br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Please <a href="'.$link.'">Click Here</a> to reset your password.<br><br>Thanks,<br>VGN<br><div style="    text-align: center;    font-size: 88%;    color: rgb(124, 124, 124);">For Any details : <a href="http://www.vgn.in">www.vgn.in</a><br><span style="    color: rgb(23, 79, 163);              font-weight: bold;">VGN Property Developers Private Limited</span>&nbsp;- No.153, Wallace Garden, 2nd Street, Nungambakkam, Chennai-600006.<br>Call Us: +91 44 4343 9900</div>';
                $now = Carbon::now();
                //$smsurl = "http://www.adithya.me/adithya/Api/?username=vgn&password=vgn@123&senderid=VGNALT&message=$smscontent&msgtype=normal&mobileno=8754404619";
                $smscontent = 'Dear '. $request->Name.', Your One Time Password for  VGN '.$list->Project_name.' project enquiry is '.$otptext; 
                
               $sms_status = $this->smscurl($smscontent, $request->Mobile);               
                DB::table('sms_sent_data')->insert(['Mobile' => $request->Mobile,'sentdatetime' => "$now"]);
                    }
                }
                else
                {
                    session()->flash("error_msg", "Not a Valid Mobile Number!");
                    return Redirect::to($url);
                }
                             
        
                    $request->session()->put("lotpdata", ['otp'=>$otptext,'hashedkey' => $hashedtext, 'PID'=>$pidtime, 'Project_name' => $pname,'Name'=>$request->Name,
                    'Email' => $request->Email, 'Mobile' => $request->Mobile, 'City' => $request->City,
                    'msg'=>null, 'lead_datetime' => $leaddttime,'sourcetype'=>'Website','plantcode' => $list->plantcode, 'websitecampaigncode' => $list->website_campaigncode,'triedcount' => 1 ]);
                    return redirect()->route("linkchangeotpshow", ['name'=>$name, 'routelink'=>$routelink]);
        }
        else{
            session()->flash("24hours", $addoneday);
            //alert('You can enquire after 24 hours from the laste enquired datetime.');
            return Redirect::to($url);
            
        }
            
            
        }
    }


    public function linkchangeotpshow(Request $request, $name = null, $routelink=null) {
$url = "http://vgn.in/$name/$routelink";
if(session()->has('lotpdata.hashedkey')){
    $sessiondata = session()->get('lotpdata');
    
}
else
{
    return Redirect::to($url);
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

               
$pname = 'VGND '.$list->Project_name;

if ($sessiondata['Project_name'] != $pname) {
    
    $request->session()->forget('lotpdata');
    return Redirect::to($url);
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
               
    
                
                return view('linkchange.otpverify')->with(['list' => $list, 'sqftrange' => $sqftrange, 'floorplanfiles' => $floorplanfiles, 'consplanfiles' => $consplanfiles, 'ebrochplanfiles' => $ebrochplanfiles,'name'=>$name,'routelink'=>$routelink] );
       
        }

        
    }


    public function coastawebenquiry() {
       
        $name = "coasta";
        $url = "linkchange_landing";
        $newpagename = "Luxury-Apartments-in-ECR";
        return $this->linkchangeurl($name, $url, $newpagename);
    }

    public function postcoastawebenquiry(Request $request) {



         $name = "coasta";
        $routename = "coastaproject_thanks";
        $routelink = "coastanewlink";
        $newpagename = "Luxury-Apartments-in-ECR";

         $validate = $this->validate($request, [
            'Name' => 'required|regex:/^[a-zA-Z\s]+$/u|min:4|max:40',
			'Email' => 'required|email',
			'Mobile' => 'required|digits:10',
            'Mobile_phoneCode' => 'required',
            'City' => 'required|regex:/^[a-zA-Z\s]+$/u|min:4|max:20'
			]);
         //dd($request);
         return $this->linkchangeinsertlead($request, $name, $routename, $newpagename);
        //return $this->linkchanageinsertlead($request, $name, $routename, $newpagename, $newpagename);
    }

     public function coastathanks() {
         
         $name = "coasta";
        $url = "linkchange_thanks";
        $newpagename = "Luxury-Apartments-in-ECR";
        return $this->linkchangethanks($name, $url, $newpagename);
    }


     public function nottinghillwebenquiry() {
        $name = "notting hill";
        $url = "linkchange_landing";
        $newpagename = "Flats-for-sale-nungambakkam";
        return $this->linkchangeurl($name, $url, $newpagename);
    }

    public function postnottinghillwebenquiry(Request $request) {
         $name = "notting hill";
        $routename = "nottinghillproject_thanks";
        $newpagename = "Flats-for-sale-nungambakkam";

         $validate = $this->validate($request, [
            'Name' => 'required|regex:/^[a-zA-Z\s]+$/u|min:4|max:40',
			'Email' => 'required|email|max:40',
			'Mobile' => 'required|digits:10',
            'Mobile_phoneCode' => 'required',
            'City' => 'required|regex:/^[a-zA-Z\s]+$/u|min:4|max:20'
			]);

        return $this->linkchangeinsertlead($request, $name, $routename, $newpagename);
        // return $this->linkchanageinsertlead($request, $name, $routename, $newpagename, $newpagename);
    }

     public function nottinghillthanks() {
         
         $name = "notting hill";
        $url = "linkchange_thanks";
        $newpagename = "Flats-for-sale-nungambakkam";
        return $this->linkchangethanks($name, $url, $newpagename);
    }


     public function brixtonwebenquiry() {
        $name = "brixton";
        $url = "linkchange_landing";
        $newpagename = "Residential-Property-Irungattukottai";
        return $this->linkchangeurl($name, $url, $newpagename);
    }

    public function postbrixtonwebenquiry(Request $request) {
         $name = "brixton";
        $routename = "brixtonproject_thanks";
        $newpagename = "Residential-Property-Irungattukottai";

         $validate = $this->validate($request, [
            'Name' => 'required|regex:/^[a-zA-Z\s]+$/u|min:4|max:40',
			'Email' => 'required|email|max:40',
			'Mobile' => 'required|digits:10',
            'Mobile_phoneCode' => 'required',
            'City' => 'required|regex:/^[a-zA-Z\s]+$/u|min:4|max:20'
			]);
         return $this->linkchangeinsertlead($request, $name, $routename, $newpagename);
        //return $this->linkchanageinsertlead($request, $name, $routename, $newpagename, $newpagename);
    }

     public function brixtonthanks() {
         
         $name = "brixton";
        $url = "linkchange_thanks";
        $newpagename = "Residential-Property-Irungattukottai";
        return $this->linkchangethanks($name, $url, $newpagename);
    }

     public function fairmontwebenquiry() {
        $name = "fairmont";
        $url = "linkchange_landing";
        $newpagename = "Buy-premium-flats-Guindy";
        return $this->linkchangeurl($name, $url, $newpagename);
    }

    public function postfairmontwebenquiry(Request $request) {
         $name = "fairmont";
        $routename = "fairmontproject_thanks";
        $newpagename = "Buy-premium-flats-Guindy";

         $validate = $this->validate($request, [
            'Name' => 'required|regex:/^[a-zA-Z\s]+$/u|min:4|max:40',
			'Email' => 'required|email|max:40',
			'Mobile' => 'required|digits:10',
            'Mobile_phoneCode' => 'required',
            'City' => 'required|regex:/^[a-zA-Z\s]+$/u|min:4|max:20'
			]);
         return $this->linkchangeinsertlead($request, $name, $routename, $newpagename);
        //return $this->linkchanageinsertlead($request, $name, $routename, $newpagename, $newpagename);
    }

     public function fairmontthanks() {
         
         $name = "fairmont";
        $url = "linkchange_thanks";
        $newpagename = "Buy-premium-flats-Guindy";
        return $this->linkchangethanks($name, $url, $newpagename);
    }
   

    public function krona_phase_iiwebenquiry() {
        $name = "krona phase ii";
        $url = "linkchange_landing";
        $newpagename = "Residential-property-Gerugambakkam";
        return $this->linkchangeurl($name, $url, $newpagename);
    }

    public function postkrona_phase_iiwebenquiry(Request $request) {
         $name = "krona phase ii";
        $routename = "krona_phase_iiproject_thanks";
        $newpagename = "Residential-property-Gerugambakkam";

         $validate = $this->validate($request, [
            'Name' => 'required|regex:/^[a-zA-Z\s]+$/u|min:4|max:40',
			'Email' => 'required|email|max:40',
			'Mobile' => 'required|digits:10',
            'Mobile_phoneCode' => 'required',
            'City' => 'required|regex:/^[a-zA-Z\s]+$/u|min:4|max:20'
			]);
         return $this->linkchangeinsertlead($request, $name, $routename, $newpagename);
       // return $this->linkchanageinsertlead($request, $name, $routename, $newpagename, $newpagename);
    }

     public function krona_phase_iithanks() {
         
         $name = "krona phase ii";
        $url = "linkchange_thanks";
        $newpagename = "Residential-property-Gerugambakkam";
        return $this->linkchangethanks($name, $url, $newpagename);
    }


     public function staffordwebenquiry() {
        $name = "stafford";
        $url = "linkchange_landing";
        $newpagename = "Luxury-apartment-ambattur";
        return $this->linkchangeurl($name, $url, $newpagename);
    }

    public function poststaffordwebenquiry(Request $request) {
         $name = "stafford";
        $routename = "staffordproject_thanks";
        $newpagename = "Luxury-apartment-ambattur";

         $validate = $this->validate($request, [
            'Name' => 'required|regex:/^[a-zA-Z\s]+$/u|min:4|max:40',
			'Email' => 'required|email|max:40',
			'Mobile' => 'required|digits:10',
            'Mobile_phoneCode' => 'required',
            'City' => 'required|regex:/^[a-zA-Z\s]+$/u|min:4|max:20'
			]);
         return $this->linkchangeinsertlead($request, $name, $routename, $newpagename);
        //return $this->linkchanageinsertlead($request, $name, $routename, $newpagename, $newpagename);
    }

     public function staffordthanks() {
         
         $name = "stafford";
        $url = "linkchange_thanks";
        $newpagename = "Luxury-apartment-ambattur";
        return $this->linkchangethanks($name, $url, $newpagename);
    }

     public function temple_townwebenquiry() {
        $name = "temple town";
        $url = "linkchange_landing";
        $newpagename = "Flats-for-sale-thiruverkadu";
        return $this->linkchangeurl($name, $url, $newpagename);
    }

    public function posttemple_townwebenquiry(Request $request) {
         $name = "temple town";
        $routename = "temple_townproject_thanks";
        $newpagename = "Flats-for-sale-thiruverkadu";

         $validate = $this->validate($request, [
            'Name' => 'required|regex:/^[a-zA-Z\s]+$/u|min:4|max:40',
			'Email' => 'required|email|max:40',
			'Mobile' => 'required|digits:10',
            'Mobile_phoneCode' => 'required',
            'City' => 'required|regex:/^[a-zA-Z\s]+$/u|min:4|max:20'
			]);
         return $this->linkchangeinsertlead($request, $name, $routename, $newpagename);
        //return $this->linkchanageinsertlead($request, $name, $routename, $newpagename, $newpagename);
    }

     public function temple_townthanks() {
         
         $name = "temple town";
        $url = "linkchange_thanks";
        $newpagename = "Flats-for-sale-thiruverkadu";
        return $this->linkchangethanks($name, $url, $newpagename);
    }

    public function brent_parkwebenquiry() {
        $name = "brent park";
        $url = "linkchange_landing";
        $newpagename = "Approved-plots-ambattur";
        return $this->linkchangeurl($name, $url, $newpagename);
    }

     public function postbrent_parkwebenquiry(Request $request) {
         $name = "brent park";
        $routename = "brent_parkproject_thanks";
        $newpagename = "Approved-plots-ambattur";

         $validate = $this->validate($request, [
            'Name' => 'required|regex:/^[a-zA-Z\s]+$/u|min:4|max:40',
            'Email' => 'required|email|max:40',
            'Mobile' => 'required|digits:10',
            'Mobile_phoneCode' => 'required',
            'City' => 'required|regex:/^[a-zA-Z\s]+$/u|min:4|max:20'
            ]);
         return $this->linkchangeinsertlead($request, $name, $routename, $newpagename);
        //return $this->linkchanageinsertlead($request, $name, $routename, $newpagename, $newpagename);
    }

     public function brent_parkthanks() {
         
         $name = "brent park";
        $url = "linkchange_thanks";
        $newpagename = "Approved-plots-ambattur";
        return $this->linkchangethanks($name, $url, $newpagename);
    }

    public function inserthomeslead()
    {
        if((isset($_POST['source']) != '')&&(isset($_POST['key']) != '')&&(isset($_POST['ProjectName']) != '')&&(isset($_POST['MobileNo']) != '')&&(isset($_POST['EmailID']) != '')&&(isset($_POST['Name']) != ''))
        {
        
        
    $key = $_POST['key'];	
	$ProjectName = $_POST['ProjectName'];
	$MobileNo = $_POST['MobileNo'];
	$email = $_POST['EmailID'];
	$Name = $_POST['Name'];
	$source = $_POST['source'];

    if ($key != "473ad73b5bab7757c775d9798385defb6ddfa1b2") {
    	 $response = [
                'error' => 'Invalid API Key',
                'status_code' => 204
            ];
                return $response;
    }

     if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
             $response = [
                'error' => 'Invalid EmailId',
                'status_code' => 204
            ];
                return $response;
                }

    if(ctype_digit($MobileNo)){
        if (strlen($MobileNo) != 10) {
            $response = [
                'error' => 'Mobile number must be 10 characters',
                'status_code' => 204
            ];
                return $response;
        }
    }
    else{
         $response = [
                'error' => 'Invalid Mobile number',
                'status_code' => 204
            ];
                return $response;
    }

    $mob = str_replace('+', '', $MobileNo);
                $mob = str_replace('-', '', $mob);

                $leaddatetime = date('Y-m-d H:i:s');

			DB::table('homesleads')->insert([
                'source' => $source,
                'project_name' => $ProjectName,
                'name' => $Name,
                'email' => $email,
                'mobile' => $mob,
                'created_date' => $leaddatetime

            ]);

         $response = [
                'success' => 'Successfully Inserted',
                'status_code' => 200
            ];
                return $response;
    }
    else
    {
         $response = [
                'error' => 'Invalid Request',
                'status_code' => 204
            ];
                return $response;
    }
    
    }

    public function redir_coastawebenquiry()
    {
        return redirect()->route('coastanewlink');
    }

    public function redir_nottingwebenquiry()
    {
        return redirect()->route('notting_hillnewlink');
    }
    public function redir_brixtonwebenquiry()
    {
        return redirect()->route('brixtonnewlink');
    }
    public function redir_fairmontwebenquiry()
    {
        return redirect()->route('fairmontnewlink');
    }
    public function redir_kronaphaseiiwebenquiry()
    {
        return redirect()->route('krona_phase_iinewlink');
    }
    public function redir_staffordwebenquiry()
    {
        return redirect()->route('staffordnewlink');
    }
    public function redir_temple_townwebenquiry()
    {
        return redirect()->route('temple_townnewlink');
    }


    public function postuserlatlng(Request $request)
    {
        $data = DB::connection('mysql2')->table('userlocations')->insert([
            'lat' => $request->lat,
            'lng' => $request->lng,
            'created_time' => Carbon::now()->toDateTimeString()
        ]);
        return 1;
    }



}
