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


class GoogleProjectController extends Controller
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
         	'coastagoogleurlnew' => "https://vgn.in/google/flats/ecr/coasta",
         	'fairmontgoogleurlnew' => "https://vgn.in/google/flats/guindy/fairmont",
         	'nottinghillgoogleurlnew' => "https://vgn.in/google/flats/nungambakkam/notting_hill",
         	'staffordgoogleurlnew' => "https://vgn.in/google/flats/ambattur/stafford",
             'brentparkgoogleurlnew' => "https://vgn.in/google/plots/ambattur/brent_park",
             'mayfieldparkgoogleurlnew' => "https://vgn.in/google/plots/tambaram/mayfield_park",
         	'templetowngoogleurlnew' => "https://vgn.in/google/flats/thiruverkadu/temple_town",
         	'croftongardensgoogleurlnew' => "https://vgn.in/google/plots/avadi/crofton_gardens",
            'croftongardensphaseiigoogleurlnew' => "https://vgn.in/google/plots/avadi/crofton_gardens_phase_ii",
	    'croftongardensphaseiiigoogleurlnew' => "https://vgn.in/google/plots/avadi/crofton_gardens_phase_iii",
			 'victoriaparkgoogleurlnew' => "https://vgn.in/google/plots/ambattur/victoria_park",
		'ovalgardensgoogleurlnew' => "https://vgn.in/google/plots/ambattur/oval_gardens",
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
         	'coasta' => "coastagoogleenquiry",
         	'fairmont' => "fairmontgoogleenquiry",
         	'notting_hill' => "nottinghillgoogleenquiry",
         	'stafford' => "staffordgoogleenquiry",
             'brent_park' => "brentparkgoogleenquiry",
             'mayfield_park' => "mayfieldparkgoogleenquiry",
         	'temple_town' => "templetowngoogleenquiry",
         	'crofton_gardens' => "croftongardensgoogleenquiry",
            'crofton_gardens_phase_ii' => "croftongardensphaseiigoogleenquiry",
	    'crofton_gardens_phase_iii' => "croftongardensphaseiiigoogleenquiry",
			 'victoria_park' => "victoriaparkgoogleenquiry",
		'oval_gardens' => "ovalgardensgoogleenquiry",
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
         	"coastagoogleurlnew" => "https://www.vgn.in/google/flats/ecr/coasta",
         	"fairmontgoogleurlnew" => "https://www.vgn.in/google/flats/guindy/fairmont",
         	"nottinghillgoogleurlnew" => "https://www.vgn.in/google/flats/nungambakkam/notting_hill",
         	"staffordgoogleurlnew" => "https://www.vgn.in/google/flats/ambattur/stafford",
             "brentparkgoogleurlnew" => "https://www.vgn.in/google/plots/ambattur/brent_park",
             "mayfieldparkgoogleurlnew" => "https://www.vgn.in/google/plots/tambaram/mayfield_park",
         	"templetowngoogleurlnew" => "https://www.vgn.in/google/flats/thiruverkadu/temple_town",
         	"croftongardensgoogleurlnew" => "https://www.vgn.in/google/plots/avadi/crofton_gardens",
            "croftongardensphaseiigoogleurlnew" => "https://www.vgn.in/google/plots/avadi/crofton_gardens_phase_ii",
	    "croftongardensphaseiiigoogleurlnew" => "https://www.vgn.in/google/plots/avadi/crofton_gardens_phase_iii",
			 "victoriaparkgoogleurlnew" => "https://www.vgn.in/google/plots/ambattur/victoria_park",
		"ovalgardensgoogleurlnew" => "https://www.vgn.in/google/plots/ambattur/oval_gardens",
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

    public function checkforthanksurl()
    {
         $changedurl = [
         	'coasta_thanks' => "https://www.vgn.in/google/otpverify/flats/ecr/coasta",
         	'fairmont_thanks' => "https://www.vgn.in/google/otpverify/flats/guindy/fairmont",
         	'nottinghill_thanks' => "https://www.vgn.in/google/otpverify/flats/nungambakkam/notting_hill",
         	'stafford_thanks' => "https://www.vgn.in/google/otpverify/flats/ambattur/stafford",
             'brentpark_thanks' => "https://www.vgn.in/google/otpverify/plots/ambattur/brent_park",
             'mayfieldpark_thanks' => "https://www.vgn.in/google/otpverify/plots/tambaram/mayfield_park",
         	'templetown_thanks' => "https://www.vgn.in/google/otpverify/flats/thiruverkadu/temple_town",
         	'croftongardens_thanks' => "https://www.vgn.in/google/otpverify/plots/avadi/crofton_gardens",
            'croftongardensphaseii_thanks' => "https://www.vgn.in/google/otpverify/plots/avadi/crofton_gardens_phase_ii",
	    'croftongardensphaseiii_thanks' => "https://www.vgn.in/google/otpverify/plots/avadi/crofton_gardens_phase_iii",
			 'victoriapark_thanks' => "https://www.vgn.in/google/otpverify/plots/ambattur/victoria_park",
			'ovalgardensgoogle_thanks' => "https://www.vgn.in/google/otpverify/plots/ambattur/oval_gardens",
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
         	'https://vgn.in/google/otplogout/coasta' => "https://www.vgn.in/google/otpverify/flats/ecr/coasta",
         	'https://vgn.in/google/otplogout/fairmont' => "https://www.vgn.in/google/otpverify/flats/guindy/fairmont",
         	'https://vgn.in/google/otplogout/notting_hill' => "https://www.vgn.in/google/otpverify/flats/nungambakkam/notting_hill",
         	'https://vgn.in/google/otplogout/stafford' => "https://www.vgn.in/google/otpverify/flats/ambattur/stafford",
             'https://vgn.in/google/otplogout/brent_park' => "https://www.vgn.in/google/otpverify/plots/ambattur/brent_park",
             'https://vgn.in/google/otplogout/mayfield_park' => "https://www.vgn.in/google/otpverify/plots/tambaram/mayfield_park",
         	'https://vgn.in/google/otplogout/temple_town' => "https://www.vgn.in/google/otpverify/flats/thiruverkadu/temple_town",
         	'https://vgn.in/google/otplogout/crofton_gardens' => "https://www.vgn.in/google/otpverify/plots/avadi/crofton_gardens",
            'https://vgn.in/google/otplogout/crofton_gardens_phase_ii' => "https://www.vgn.in/google/otpverify/plots/avadi/crofton_gardens_phase_ii",
	    'https://vgn.in/google/otplogout/crofton_gardens_phase_iii' => "https://www.vgn.in/google/otpverify/plots/avadi/crofton_gardens_phase_iii",
			 'https://vgn.in/google/otplogout/victoria_park' => "https://www.vgn.in/google/otpverify/plots/ambattur/victoria_park",
			'https://vgn.in/google/otplogout/oval_gardens' => "https://www.vgn.in/google/otpverify/plots/ambattur/oval_gardens",
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
    public function checkforgobackurl()
    {
    	$changedurl = [
    		'https://vgn.in/google/flats/ecr/coasta' => "https://www.vgn.in/google/thank-you/flats/ecr/coasta",
    		'https://vgn.in/google/flats/guindy/fairmont' => "https://www.vgn.in/google/thank-you/flats/guindy/fairmont",
    		'https://vgn.in/google/flats/nungambakkam/notting_hill' => "https://www.vgn.in/google/thank-you/flats/nungambakkam/notting_hill",
    		'https://vgn.in/google/flats/ambattur/stafford' => "https://www.vgn.in/google/thank-you/flats/ambattur/stafford",
            'https://vgn.in/google/plots/ambattur/brent_park' => "https://www.vgn.in/google/thank-you/plots/ambattur/brent_park",
            'https://vgn.in/google/plots/tambaram/mayfield_park' => "https://www.vgn.in/google/thank-you/plots/tambaram/mayfield_park",
    		'https://vgn.in/google/flats/thiruverkadu/temple_town' => "https://www.vgn.in/google/thank-you/flats/thiruverkadu/temple_town",
    		'https://vgn.in/google/plots/avadi/crofton_gardens' => "https://www.vgn.in/google/thank-you/plots/avadi/crofton_gardens",
            'https://vgn.in/google/plots/avadi/crofton_gardens_phase_ii' => "https://www.vgn.in/google/thank-you/plots/avadi/crofton_gardens_phase_ii",
	    'https://vgn.in/google/plots/avadi/crofton_gardens_phase_iii' => "https://www.vgn.in/google/thank-you/plots/avadi/crofton_gardens_phase_iii",
			'https://vgn.in/google/plots/ambattur/victoria_park' => "https://www.vgn.in/google/thank-you/plots/ambattur/victoria_park",
			'https://vgn.in/google/plots/ambattur/oval_gardens' => "https://www.vgn.in/google/thank-you/plots/ambattur/oval_gardens",
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
    public function gshow($name = null) {

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
               
                $currentroute = url()->current();
                
                return view('GoogleProject.individualprojectpage')->with(['list' => $list, 'sqftrange' => $sqftrange, 'floorplanfiles' => $floorplanfiles, 'consplanfiles' => $consplanfiles, 'ebrochplanfiles' => $ebrochplanfiles,'current_route' => $currentroute] );
       
        }

        
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

			    $bannerpath = "images/banner/".$id;
            $mobilebanner = "images/banner/mobile/".$id;
            $data_banner_img_url = $this->single_link_parse_path_gen_link($bannerpath);
            $data_mobile_banner_img_url = $this->single_link_parse_path_gen_link($mobilebanner);
            $banner = $data_banner_img_url;
            $mobile_banner = $data_mobile_banner_img_url;

            $bannerfiles = Storage::disk('s3')->files("/images/banner/".$id);
               
                $currentroute = url()->current();
                //dd($list);
                return view('GoogleProject.indivdisplay')->with(['list' => $list, 'sqftrange' => $sqftrange, 'floorplanfiles' => $floorplanfiles, 'consplanfiles' => $consplanfiles, 'ebrochplanfiles' => $ebrochplanfiles,'latitude'=>$latitude,'current_route' => $currentroute, 'banner' => $banner, 'mobile_banner' => $mobile_banner,'bannerfiles' =>$bannerfiles,'id'=>$id] );
       
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
     $checkformainurlinfunction = $this->checkformainurl($name);
            if ($checkformainurlinfunction != '0') {
                return redirect()->route("$checkformainurlinfunction");
            }
    return redirect()->route('gdproject', ['name' => $name]);
}
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
            	$getotplogouturl = $this->checkforlogouturl();
            	//dd($getotplogouturl);
            	if ($getotplogouturl == '0') {
            		$getotplogouturl = 'https://www.vgn.in/googlead-display/otplogout/'.$name;
            	}

 $bannerpath = "images/banner/".$id;
            $mobilebanner = "images/banner/mobile/".$id;
            $data_banner_img_url = $this->single_link_parse_path_gen_link($bannerpath);
            $data_mobile_banner_img_url = $this->single_link_parse_path_gen_link($mobilebanner);
            $banner = $data_banner_img_url;
            $mobile_banner = $data_mobile_banner_img_url;
                $currentroute = url()->current();

                return view('GoogleProject.otpverify')->with(['list' => $list, 'sqftrange' => $sqftrange, 'floorplanfiles' => $floorplanfiles, 'consplanfiles' => $consplanfiles, 'ebrochplanfiles' => $ebrochplanfiles,'latitude'=>$latitude,'currentroute'=>$currentroute,'getotplogouturl'=>$getotplogouturl, 'banner' => $banner, 'mobile_banner' => $mobile_banner] );
       
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

			    $bannerpath = "images/banner/".$id;
            $mobilebanner = "images/banner/mobile/".$id;
            $data_banner_img_url = $this->single_link_parse_path_gen_link($bannerpath);
            $data_mobile_banner_img_url = $this->single_link_parse_path_gen_link($mobilebanner);
            $banner = $data_banner_img_url;
            $mobile_banner = $data_mobile_banner_img_url;
                
                return view('GoogleProject.floorplan')->with(['list' => $list, 'sqftrange' => $sqftrange, 'floorplanfiles' => $floorplanfiles, 'banner' => $banner, 'mobile_banner' => $mobile_banner] );

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

			    $bannerpath = "images/banner/".$id;
            $mobilebanner = "images/banner/mobile/".$id;
            $data_banner_img_url = $this->single_link_parse_path_gen_link($bannerpath);
            $data_mobile_banner_img_url = $this->single_link_parse_path_gen_link($mobilebanner);
            $banner = $data_banner_img_url;
            $mobile_banner = $data_mobile_banner_img_url;                

                return view('GoogleProject.construction')->with(['list' => $list, 'sqftrange' => $sqftrange, 'consplanfiles' => $consplanfiles, 'banner' => $banner, 'mobile_banner' => $mobile_banner] );

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

    public function ginsertlead(Request $request,$name = null) {
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
            'Name' => 'required|regex:/^[a-zA-Z\s]+$/u|min:4|max:30',
			'Email' => 'required|email|max:40',
			'Mobile' => 'required|digits:10',
      'Mobile_phoneCode' => 'required',
            'City' => 'required|regex:/^[a-zA-Z\s]+$/u|min:4|max:20'
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
            }

            
                if($ins == 1){
             $insert = DB::connection('mysql2')->table($tablename )->insert(
                    ['Id' => null, 'PID' => $pidtime, 'Project_name' => $pname,'Name'=> preg_replace("/[^A-Za-z.?! ]/","",$request->Name),
                    'Email' => $request->Email, 'Mobile' => '+'.$request->Mobile_phoneCode.$request->Mobile, 'City' => $request->City,
                    'msg'=>null, 'lead_datetime' => $leaddttime, 'inserteddate' => date('Y-m-d H:i:s')]
                );
                
                $lead_check = lead_data::where('Source_type','=','Google')->where('Project_id','=',$id)->where('Email','=',$request->Email)->count();

                $lead = new lead_data();
                $lead->Project_id = $id;
                $lead->PID = $pidtime;
                $lead->Project_name = $list->Project_name;
                $lead->Source_type = 'Google';
                $lead->Name = preg_replace("/[^A-Za-z.?! ]/","",$request->Name);
                $lead->Email = $request->Email;
                $lead->Mobile = '+'.$request->Mobile_phoneCode.$request->Mobile;
                $lead->City = $request->City;
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
            //return view('GoogleProject.thanks')->with(['list' => $list, 'sqftrange' => $sqftrange] );
            return redirect()->route('gproject_thanks', ['name' => $name]);
        }
        else{
            $request->session()->flash("24hours", $addoneday);
            //alert('You can enquire after 24 hours from the laste enquired datetime.');
            return redirect()->back();
            
        }
            
            
        }
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
                $campaigncode = $projectlistnew[0]['google_campaigncode'];
                $plantcode = $projectlistnew[0]['plantcode'];

		$url = $request->url();
                $cpcode = '';
                //dd($url);
                if (strpos($url, 'googlead-display') !== false) {
                    $gdisp_ad = DB::connection('mysql2')->table('google_display_ad')->where(['plant_code' => $plantcode])->get();

                    if (count($gdisp_ad) > 0) {
                        foreach ($gdisp_ad as $key111 => $value111) {
                            $getcamp = $value111->campaign_code;
                            $campaigncode = $getcamp;
                        }
                    }
                    else{
                        $campaigncode = $list->google_campaigncode;    
                    }
                    
                    
                }
                else{
                    $campaigncode = $list->google_campaigncode;
                }

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
                        
                //$smscontent='Dear '.$name.',<br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Please <a href="'.$link.'">Click Here</a> to reset your password.<br><br>Thanks,<br>VGN<br><div style="    text-align: center;    font-size: 88%;    color: rgb(124, 124, 124);">For Any details : <a href="http://www.vgn.in">www.vgn.in</a><br><span style="    color: rgb(23, 79, 163);				font-weight: bold;">VGN Projects Estates Private Limited</span>&nbsp;- No.153, Wallace Garden, 2nd Street, Nungambakkam, Chennai-600006.<br>Call Us: +91 44 4343 9900</div>';
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
                    'msg'=>null, 'lead_datetime' => $leaddttime,'sourcetype'=>'Google','plantcode' => $list->plantcode, 'googlecampaigncode' => $campaigncode,'triedcount' => 1 ]);


                  $check = $this->checkforotpurl();

    if ($check != '0') {
        //dd($check);
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

		$url = $request->url();
                $cpcode = '';
                //dd($sessiondata);

                if (strpos($url, 'googlead-otpverify') !== false) {
                    $gdisp_ad = DB::connection('mysql2')->table('google_display_ad')->where(['plant_code' => $plantcode])->get();

                    if (count($gdisp_ad) > 0) {
                        foreach ($gdisp_ad as $key111 => $value111) {
                            $getcamp = $value111->campaign_code;
                            $campaigncode = $getcamp;
                        }
                    }
                    else{
                        $campaigncode = $list->google_campaigncode;    
                    }
                    
                    
                }
                else{
                    $campaigncode = $list->google_campaigncode;
                }

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
            
           /* if(count($list) == 1) {
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

            return view('GoogleProject.thanks')->with(['list' => $list, 'sqftrange' => $sqftrange, 'banner' => $banner, 'mobile_banner' => $mobile_banner] );
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
                    	$getthanksgobackurl = 'https://vgn.in/googlead-display/project/'.$name;
                    }

            $sqftrange =  sqft_range::where('P_id','=',$id)->get();
		
			    $bannerpath = "images/banner/".$id;
            $mobilebanner = "images/banner/mobile/".$id;
            $data_banner_img_url = $this->single_link_parse_path_gen_link($bannerpath);
            $data_mobile_banner_img_url = $this->single_link_parse_path_gen_link($mobilebanner);
            $banner = $data_banner_img_url;
            $mobile_banner = $data_mobile_banner_img_url;
		
            return view('GoogleProject.gdthanks')->with(['list' => $list, 'sqftrange' => $sqftrange,'getthanksgobackurl'=>$getthanksgobackurl, 'banner' => $banner, 'mobile_banner' => $mobile_banner] );
        }
    }


/*start of new google urls*/
/*start coasta*/
   public function coastagoogleenquiry()
   {
       return $this->gdshow('coasta');
   }


   public function postcoastagoogleenquiry(Request $request)
   {
       return $this->gdinsertlead($request, 'coasta');
   }

   public function coastashowotpgoogleenquiry(Request $request)
   {

    return $this->gdotpshow($request, 'coasta');   
   }
   public function coastapostotpgoogleenquiry(Request $request)
   {
       return $this->gdotpinsertlead($request, 'coasta');  
   }

   public function coastathanks()
   {
       return $this->gdthanks('coasta');  
   }

   public function coastaotplogout(Request $request)
   {
        if($request->session()->has('otpdata.hashedkey')){
    $request->session()->forget('otpdata');
    return redirect()->route('coastagoogleenquiry');
    
    }
    else
    {
    return redirect()->route('coastagoogleenquiry');
    }
   }
   /*end coasta*/

   /*start fairmont*/
   public function fairmontgoogleenquiry()
   {
       return $this->gdshow('fairmont');
   }


   public function postfairmontgoogleenquiry(Request $request)
   {
       return $this->gdinsertlead($request, 'fairmont');
   }

   public function fairmontshowotpgoogleenquiry(Request $request)
   {

    return $this->gdotpshow($request, 'fairmont');   
   }
   public function fairmontpostotpgoogleenquiry(Request $request)
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
    return redirect()->route('fairmontgoogleenquiry');
    
    }
    else
    {
    return redirect()->route('fairmontgoogleenquiry');
    }
   }
   /*end fairmont*/

   /*start notting hill*/
   public function  nottinghillgoogleenquiry()
   {
       return $this->gdshow('notting_hill');
   }


   public function postnottinghillgoogleenquiry(Request $request)
   {
       return $this->gdinsertlead($request, 'notting_hill');
   }

   public function nottinghillshowotpgoogleenquiry(Request $request)
   {

    return $this->gdotpshow($request, 'notting_hill');   
   }
   public function nottinghillpostotpgoogleenquiry(Request $request)
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
    return redirect()->route('nottinghillgoogleenquiry');
    
    }
    else
    {
    return redirect()->route('nottinghillgoogleenquiry');
    }
   }
   /*end notting hill*/

   /*start Stafford*/
   public function  staffordgoogleenquiry()
   {
       return $this->gdshow('stafford');
   }


   public function poststaffordgoogleenquiry(Request $request)
   {
       return $this->gdinsertlead($request, 'stafford');
   }

   public function staffordshowotpgoogleenquiry(Request $request)
   {

    return $this->gdotpshow($request, 'stafford');   
   }
   public function staffordpostotpgoogleenquiry(Request $request)
   {
       return $this->gdotpinsertlead($request, 'stafford');  
   }

   public function staffordthanks()
   {
       return $this->gdthanks('stafford');  
   }

   public function staffordotplogout(Request $request)
   {
        if($request->session()->has('otpdata.hashedkey')){
    $request->session()->forget('otpdata');
    return redirect()->route('staffordgoogleenquiry');
    
    }
    else
    {
    return redirect()->route('staffordgoogleenquiry');
    }
   }
   /*end Stafford*/

   /*start Brent Park*/
   public function  brentparkgoogleenquiry()
   {
       return $this->gdshow('brent_park');
   }


   public function postbrentparkgoogleenquiry(Request $request)
   {
       return $this->gdinsertlead($request, 'brent_park');
   }

   public function brentparkshowotpgoogleenquiry(Request $request)
   {

    return $this->gdotpshow($request, 'brent_park');   
   }
   public function brentparkpostotpgoogleenquiry(Request $request)
   {
       return $this->gdotpinsertlead($request, 'brent_park');  
   }

   public function brentparkthanks()
   {
       return $this->gdthanks('brent_park');  
   }

   public function brentparkotplogout(Request $request)
   {
        if($request->session()->has('otpdata.hashedkey')){
    $request->session()->forget('otpdata');
    return redirect()->route('brentparkgoogleenquiry');
    
    }
    else
    {
    return redirect()->route('brentparkgoogleenquiry');
    }
   }
   /*end Brent Park*/

   /*start mayfield Park*/
   public function  mayfieldparkgoogleenquiry()
   {
       return $this->gdshow('mayfield_park');
   }


   public function postmayfieldparkgoogleenquiry(Request $request)
   {
       return $this->gdinsertlead($request, 'mayfield_park');
   }

   public function mayfieldparkshowotpgoogleenquiry(Request $request)
   {

    return $this->gdotpshow($request, 'mayfield_park');   
   }
   public function mayfieldparkpostotpgoogleenquiry(Request $request)
   {
       return $this->gdotpinsertlead($request, 'mayfield_park');  
   }

   public function mayfieldparkthanks()
   {
       return $this->gdthanks('mayfield_park');  
   }

   public function mayfieldparkotplogout(Request $request)
   {
        if($request->session()->has('otpdata.hashedkey')){
    $request->session()->forget('otpdata');
    return redirect()->route('mayfieldparkgoogleenquiry');
    
    }
    else
    {
    return redirect()->route('mayfieldparkgoogleenquiry');
    }
   }
   /*end mayfield Park*/

   /*start Temple Town*/
   public function  templetowngoogleenquiry()
   {
       return $this->gdshow('temple_town');
   }


   public function posttempletowngoogleenquiry(Request $request)
   {
       return $this->gdinsertlead($request, 'temple_town');
   }

   public function templetownshowotpgoogleenquiry(Request $request)
   {

    return $this->gdotpshow($request, 'temple_town');   
   }
   public function templetownpostotpgoogleenquiry(Request $request)
   {
       return $this->gdotpinsertlead($request, 'temple_town');  
   }

   public function templetownthanks()
   {
       return $this->gdthanks('temple_town');  
   }

   public function templetownotplogout(Request $request)
   {
        if($request->session()->has('otpdata.hashedkey')){
    $request->session()->forget('otpdata');
    return redirect()->route('templetowngoogleenquiry');
    
    }
    else
    {
    return redirect()->route('templetowngoogleenquiry');
    }
   }
   /*end Temple Town*/

   /*start Crofton Gardens*/
   public function  croftongardensgoogleenquiry()
   {
       return $this->gdshow('crofton_gardens');
   }


   public function postcroftongardensgoogleenquiry(Request $request)
   {
       return $this->gdinsertlead($request, 'crofton_gardens');
   }

   public function croftongardensshowotpgoogleenquiry(Request $request)
   {

    return $this->gdotpshow($request, 'crofton_gardens');   
   }
   public function croftongardenspostotpgoogleenquiry(Request $request)
   {
       return $this->gdotpinsertlead($request, 'crofton_gardens');  
   }

   public function croftongardensthanks()
   {
       return $this->gdthanks('crofton_gardens');  
   }

   public function croftongardensotplogout(Request $request)
   {
        if($request->session()->has('otpdata.hashedkey')){
    $request->session()->forget('otpdata');
    return redirect()->route('croftongardensgoogleenquiry');
    
    }
    else
    {
    return redirect()->route('croftongardensgoogleenquiry');
    }
   }
   /*end Crofton Gardens*/

   /*start Crofton Gardens Phase II*/
   public function  croftongardensphaseiigoogleenquiry()
   {
       return $this->gdshow('crofton_gardens_phase_ii');
   }


   public function postcroftongardensphaseiigoogleenquiry(Request $request)
   {
       return $this->gdinsertlead($request, 'crofton_gardens_phase_ii');
   }

   public function croftongardensphaseiishowotpgoogleenquiry(Request $request)
   {

    return $this->gdotpshow($request, 'crofton_gardens_phase_ii');   
   }
   public function croftongardensphaseiipostotpgoogleenquiry(Request $request)
   {
       return $this->gdotpinsertlead($request, 'crofton_gardens_phase_ii');  
   }

   public function croftongardensphaseiithanks()
   {
       return $this->gdthanks('crofton_gardens_phase_ii');  
   }

   public function croftongardensphaseiiotplogout(Request $request)
   {
        if($request->session()->has('otpdata.hashedkey')){
    $request->session()->forget('otpdata');
    return redirect()->route('croftongardensphaseiigoogleenquiry');
    
    }
    else
    {
    return redirect()->route('croftongardensphaseiigoogleenquiry');
    }
   }
   /*end Crofton Gardens Phase II*/

/*start Crofton Gardens Phase III*/
   public function  croftongardensphaseiiigoogleenquiry()
   {
       return $this->gdshow('crofton_gardens_phase_iii');
   }


   public function postcroftongardensphaseiiigoogleenquiry(Request $request)
   {
       return $this->gdinsertlead($request, 'crofton_gardens_phase_iii');
   }

   public function croftongardensphaseiiishowotpgoogleenquiry(Request $request)
   {

    return $this->gdotpshow($request, 'crofton_gardens_phase_iii');   
   }
   public function croftongardensphaseiiipostotpgoogleenquiry(Request $request)
   {
       return $this->gdotpinsertlead($request, 'crofton_gardens_phase_iii');  
   }

   public function croftongardensphaseiiithanks()
   {
       return $this->gdthanks('crofton_gardens_phase_iii');  
   }

   public function croftongardensphaseiiiotplogout(Request $request)
   {
        if($request->session()->has('otpdata.hashedkey')){
    $request->session()->forget('otpdata');
    return redirect()->route('croftongardensphaseiiigoogleenquiry');
    
    }
    else
    {
    return redirect()->route('croftongardensphaseiiigoogleenquiry');
    }
   }
   /*end Crofton Gardens Phase III*/
	
	/*start Victoria Park*/
   public function  victoriaparkgoogleenquiry()
   {
       return $this->gdshow('victoria_park');
   }


   public function postvictoriaparkgoogleenquiry(Request $request)
   {
       return $this->gdinsertlead($request, 'victoria_park');
   }

   public function victoriaparkshowotpgoogleenquiry(Request $request)
   {

    return $this->gdotpshow($request, 'victoria_park');   
   }
   public function victoriaparkpostotpgoogleenquiry(Request $request)
   {
       return $this->gdotpinsertlead($request, 'victoria_park');  
   }

   public function victoriaparkthanks()
   {
       return $this->gdthanks('victoria_park');  
   }

   public function victoriaparkotplogout(Request $request)
   {
        if($request->session()->has('otpdata.hashedkey')){
    $request->session()->forget('otpdata');
    return redirect()->route('victoriaparkgoogleenquiry');
    
    }
    else
    {
    return redirect()->route('victoriaparkgoogleenquiry');
    }
   }
   /*end Victoria Park*/

   
	

/*start Oval Gardens*/
   public function  ovalgardensgoogleenquiry()
   {
       return $this->gdshow('oval_gardens');
   }


   public function postovalgardensgoogleenquiry(Request $request)
   {
       return $this->gdinsertlead($request, 'oval_gardens');
   }

   public function ovalgardensshowotpgoogleenquiry(Request $request)
   {

    return $this->gdotpshow($request, 'oval_gardens');   
   }
   public function ovalgardenspostotpgoogleenquiry(Request $request)
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
    return redirect()->route('ovalgardensgoogleenquiry');
    
    }
    else
    {
    return redirect()->route('ovalgardensgoogleenquiry');
    }
   }
   /*end Oval Gardens*/

/*end of new google urls*/

   
}
