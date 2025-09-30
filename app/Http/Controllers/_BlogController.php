<?php

namespace vgn\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use Session;
use vgn\projectlist;
use vgn\sqft_range;
use vgn\lead_data;

class BlogController extends Controller
{
    public function index()
    {
    	return view('Blog.blogindex');
    }

    public function five_facts_why_nungambakkam_is_the_best_location_to_lives($value='')
    {
    	return view('Blog.fivefactswhynungambakkamisbesttolive');
    }

    public function postfive_facts_why_nungambakkam_is_the_best_location_to_lives(Request $request)
    {

    	$validate = $this->validate($request, [
            'Name' => 'required|regex:/^[a-zA-Z\s]+$/u|min:3|max:30',
			'Email' => 'required|email|max:40',
			'Mobile' => 'required|digits:10',
      'Mobile_phoneCode' => 'required',
            'City' => 'required|regex:/^[a-zA-Z\s]+$/u|min:4|max:20'
			]);

$id = 1;
$list =  projectlist::find($id);
             $pidtime = date('Ymdhis').mt_rand(5, 1500);
            $leaddttime = date('Y-m-d H:i:s');
            $addoneday = date('Y-m-d H:i:s');
            $projectlistnew = projectlist::where('id','=',$id)->get();
            $ins = 0;
            if(!empty($projectlistnew)){
                $campaigncode = "0000002263";
                $plantcode = "4100";

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
                
                $lead_check = lead_data::where('Source_type','=','Blog')->where('Project_id','=',$id)->where('Email','=',$request->Email)->count();

                $lead = new lead_data();
                $lead->Project_id = $id;
                $lead->PID = $pidtime;
                $lead->Project_name = $list->Project_name;
                $lead->Source_type = 'Blog';
                $lead->Name = preg_replace("/[^A-Za-z.?! ]/","",$request->Name);
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
                $lead->created_at = date('Y-m-d H:i:s');
                $lead->updated_at = date('Y-m-d H:i:s');
                $lead->save();

                $request->session()->flash("thanks_session", $leaddttime);
            $sqftrange =  sqft_range::where('P_id','=',$id)->get();
            //return view('GoogleProject.thanks')->with(['list' => $list, 'sqftrange' => $sqftrange] );
            $request->session()->flash("success", "Thanks for your input, we will get back to you shortly!");
            return redirect()->route('five_facts_nungambakkam');
        }
        else{
            $request->session()->flash("24hours", $addoneday);
            //alert('You can enquire after 24 hours from the laste enquired datetime.');
            return redirect()->back();
            
        }
    }

 public function three_reasons_why_real_estate_is_the_best_investment_in_this_pandemic_period($value='')
    {
    	return view('Blog.threereasonswhyrealestatebestinvestmentpandemicperiod');
    }

    public function postthree_reasons_why_real_estate_is_the_best_investment_in_this_pandemic_period(Request $request)
    {

    	$validate = $this->validate($request, [
            'Name' => 'required|regex:/^[a-zA-Z\s]+$/u|min:3|max:30',
			'Email' => 'required|email|max:40',
			'Mobile' => 'required|digits:10',
      'Mobile_phoneCode' => 'required',
            'City' => 'required|regex:/^[a-zA-Z\s]+$/u|min:4|max:20'
			]);

$id = 2;
$list =  projectlist::find($id);
             $pidtime = date('Ymdhis').mt_rand(5, 1500);
            $leaddttime = date('Y-m-d H:i:s');
            $addoneday = date('Y-m-d H:i:s');
            $projectlistnew = projectlist::where('id','=',$id)->get();
            $ins = 0;
            if(!empty($projectlistnew)){
                $campaigncode = "0000002262";
                $plantcode = "4311";

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
                
                $lead_check = lead_data::where('Source_type','=','Blog')->where('Project_id','=',$id)->where('Email','=',$request->Email)->count();

                $lead = new lead_data();
                $lead->Project_id = $id;
                $lead->PID = $pidtime;
                $lead->Project_name = $list->Project_name;
                $lead->Source_type = 'Blog';
                $lead->Name = preg_replace("/[^A-Za-z.?! ]/","",$request->Name);
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
                $lead->created_at = date('Y-m-d H:i:s');
                $lead->updated_at = date('Y-m-d H:i:s');
                $lead->save();

                $request->session()->flash("thanks_session", $leaddttime);
            $sqftrange =  sqft_range::where('P_id','=',$id)->get();
            //return view('GoogleProject.thanks')->with(['list' => $list, 'sqftrange' => $sqftrange] );
            $request->session()->flash("success", "Thanks for your input, we will get back to you shortly!");
            return redirect()->route('three_reasonswhyrealestate');
        }
        else{
            $request->session()->flash("24hours", $addoneday);
            //alert('You can enquire after 24 hours from the laste enquired datetime.');
            return redirect()->back();
            
        }
    }

    public function live_the_beach_life_in_chennai($value='')
    {
    	return view('Blog.live_the_beach_life_in_chennai');
    }

    public function postlive_the_beach_life_in_chennai(Request $request)
    {

    	$validate = $this->validate($request, [
            'Name' => 'required|regex:/^[a-zA-Z\s]+$/u|min:3|max:30',
			'Email' => 'required|email|max:40',
			'Mobile' => 'required|digits:10',
      'Mobile_phoneCode' => 'required',
            'City' => 'required|regex:/^[a-zA-Z\s]+$/u|min:4|max:20'
			]);

$id = 5;
$list =  projectlist::find($id);
             $pidtime = date('Ymdhis').mt_rand(5, 1500);
            $leaddttime = date('Y-m-d H:i:s');
            $addoneday = date('Y-m-d H:i:s');
            $projectlistnew = projectlist::where('id','=',$id)->get();
            $ins = 0;
            if(!empty($projectlistnew)){
                $campaigncode = "0000002265";
                $plantcode = "4107";

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
                
                $lead_check = lead_data::where('Source_type','=','Blog')->where('Project_id','=',$id)->where('Email','=',$request->Email)->count();

                $lead = new lead_data();
                $lead->Project_id = $id;
                $lead->PID = $pidtime;
                $lead->Project_name = $list->Project_name;
                $lead->Source_type = 'Blog';
                $lead->Name = preg_replace("/[^A-Za-z.?! ]/","",$request->Name);
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
                $lead->created_at = date('Y-m-d H:i:s');
                $lead->updated_at = date('Y-m-d H:i:s');
                $lead->save();

                $request->session()->flash("thanks_session", $leaddttime);
            $sqftrange =  sqft_range::where('P_id','=',$id)->get();
            //return view('GoogleProject.thanks')->with(['list' => $list, 'sqftrange' => $sqftrange] );
            $request->session()->flash("success", "Thanks for your input, we will get back to you shortly!");
            return redirect()->route('live_the_beach_life_in_chennai');
        }
        else{
            $request->session()->flash("24hours", $addoneday);
            //alert('You can enquire after 24 hours from the laste enquired datetime.');
            return redirect()->back();
            
        }
    }

public function importance_of_vastu_for_a_holistic_lifestyle($value='')
    {
        return view('Blog.importanceofvastu');
    }

    public function postimportance_of_vastu_for_a_holistic_lifestyle(Request $request)
    {

        $validate = $this->validate($request, [
            'Name' => 'required|regex:/^[a-zA-Z\s]+$/u|min:3|max:30',
            'Email' => 'required|email|max:40',
            'Mobile' => 'required|digits:10',
      'Mobile_phoneCode' => 'required',
            'City' => 'required|regex:/^[a-zA-Z\s]+$/u|min:4|max:20'
            ]);

$id = 14;
$list =  projectlist::find($id);
             $pidtime = date('Ymdhis').mt_rand(5, 1500);
            $leaddttime = date('Y-m-d H:i:s');
            $addoneday = date('Y-m-d H:i:s');
            $projectlistnew = projectlist::where('id','=',$id)->get();
            $ins = 0;
            if(!empty($projectlistnew)){
                $campaigncode = "0000002266";
                $plantcode = "4109";

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
                
                $lead_check = lead_data::where('Source_type','=','Blog')->where('Project_id','=',$id)->where('Email','=',$request->Email)->count();

                $lead = new lead_data();
                $lead->Project_id = $id;
                $lead->PID = $pidtime;
                $lead->Project_name = $list->Project_name;
                $lead->Source_type = 'Blog';
                $lead->Name = preg_replace("/[^A-Za-z.?! ]/","",$request->Name);
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
                $lead->created_at = date('Y-m-d H:i:s');
                $lead->updated_at = date('Y-m-d H:i:s');
                $lead->save();

                $request->session()->flash("thanks_session", $leaddttime);
            $sqftrange =  sqft_range::where('P_id','=',$id)->get();
            //return view('GoogleProject.thanks')->with(['list' => $list, 'sqftrange' => $sqftrange] );
            $request->session()->flash("success", "Thanks for your input, we will get back to you shortly!");
            return redirect()->route('importance_of_vastu_for_a_holistic_lifestyle');
        }
        else{
            $request->session()->flash("24hours", $addoneday);
            //alert('You can enquire after 24 hours from the laste enquired datetime.');
            return redirect()->back();
            
        }
    }

 public function The_Remarkable_Transformation_Of_Ambattur($value='')
    {
        return view('Blog.remarkabletransformationofambattur');
    }

    public function postThe_Remarkable_Transformation_Of_Ambattur(Request $request)
    {

        $validate = $this->validate($request, [
            'Name' => 'required|regex:/^[a-zA-Z\s]+$/u|min:3|max:30',
            'Email' => 'required|email|max:40',
            'Mobile' => 'required|digits:10',
      'Mobile_phoneCode' => 'required',
            'City' => 'required|regex:/^[a-zA-Z\s]+$/u|min:4|max:20'
            ]);

$id = 13;
$list =  projectlist::find($id);
             $pidtime = date('Ymdhis').mt_rand(5, 1500);
            $leaddttime = date('Y-m-d H:i:s');
            $addoneday = date('Y-m-d H:i:s');
            $projectlistnew = projectlist::where('id','=',$id)->get();
            $ins = 0;
            if(!empty($projectlistnew)){
                $campaigncode = "0000002264";
                $plantcode = "4106";

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
                
                $lead_check = lead_data::where('Source_type','=','Blog')->where('Project_id','=',$id)->where('Email','=',$request->Email)->count();

                $lead = new lead_data();
                $lead->Project_id = $id;
                $lead->PID = $pidtime;
                $lead->Project_name = $list->Project_name;
                $lead->Source_type = 'Blog';
                $lead->Name = preg_replace("/[^A-Za-z.?! ]/","",$request->Name);
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
                $lead->created_at = date('Y-m-d H:i:s');
                $lead->updated_at = date('Y-m-d H:i:s');
                $lead->save();

                $request->session()->flash("thanks_session", $leaddttime);
            $sqftrange =  sqft_range::where('P_id','=',$id)->get();
            //return view('GoogleProject.thanks')->with(['list' => $list, 'sqftrange' => $sqftrange] );
            $request->session()->flash("success", "Thanks for your input, we will get back to you shortly!");
            return redirect()->route('Remarkable_Transformation_Of_Ambattur');
        }
        else{
            $request->session()->flash("24hours", $addoneday);
            //alert('You can enquire after 24 hours from the laste enquired datetime.');
            return redirect()->back();
            
        }
    }


public function five_reasons_why_Guindy_should_be_your_next_choice_to_buy_apremium_apartment($value='')
    {
        return view('Blog.fivereasonswhyGuindyshouldbeyournextchoicetobuyapremiumapartment');
    }

    public function postfive_reasons_why_Guindy_should_be_your_next_choice_to_buy_apremium_apartment(Request $request)
    {

        $validate = $this->validate($request, [
            'Name' => 'required|regex:/^[a-zA-Z\s]+$/u|min:3|max:30',
            'Email' => 'required|email|max:40',
            'Mobile' => 'required|digits:10',
      'Mobile_phoneCode' => 'required',
            'City' => 'required|regex:/^[a-zA-Z\s]+$/u|min:4|max:20'
            ]);

$id = 2;
$list =  projectlist::find($id);
             $pidtime = date('Ymdhis').mt_rand(5, 1500);
            $leaddttime = date('Y-m-d H:i:s');
            $addoneday = date('Y-m-d H:i:s');
            $projectlistnew = projectlist::where('id','=',$id)->get();
            $ins = 0;
            if(!empty($projectlistnew)){
                $campaigncode = "0000002262";
                $plantcode = "4311";

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
                
                $lead_check = lead_data::where('Source_type','=','Blog')->where('Project_id','=',$id)->where('Email','=',$request->Email)->count();

                $lead = new lead_data();
                $lead->Project_id = $id;
                $lead->PID = $pidtime;
                $lead->Project_name = $list->Project_name;
                $lead->Source_type = 'Blog';
                $lead->Name = preg_replace("/[^A-Za-z.?! ]/","",$request->Name);
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
                $lead->created_at = date('Y-m-d H:i:s');
                $lead->updated_at = date('Y-m-d H:i:s');
                $lead->save();

                $request->session()->flash("thanks_session", $leaddttime);
            $sqftrange =  sqft_range::where('P_id','=',$id)->get();
            //return view('GoogleProject.thanks')->with(['list' => $list, 'sqftrange' => $sqftrange] );
            $request->session()->flash("success", "Thanks for your input, we will get back to you shortly!");
            return redirect()->route('fivereasonswhyGuindyshouldbeyournextchoicetobuyapremiumapartment');
        }
        else{
            $request->session()->flash("24hours", $addoneday);
            //alert('You can enquire after 24 hours from the laste enquired datetime.');
            return redirect()->back();
            
        }
    }

public function a_perfect_location_to_buy_your_luxury_dream_home($value='')
    {
        return view('Blog.aperfectlocationtobuyyourluxurydreamhome');
    }

    public function posta_perfect_location_to_buy_your_luxury_dream_home(Request $request)
    {

        $validate = $this->validate($request, [
            'Name' => 'required|regex:/^[a-zA-Z\s]+$/u|min:3|max:30',
            'Email' => 'required|email|max:40',
            'Mobile' => 'required|digits:10',
      'Mobile_phoneCode' => 'required',
            'City' => 'required|regex:/^[a-zA-Z\s]+$/u|min:4|max:20'
            ]);

$id = 1;
$list =  projectlist::find($id);
             $pidtime = date('Ymdhis').mt_rand(5, 1500);
            $leaddttime = date('Y-m-d H:i:s');
            $addoneday = date('Y-m-d H:i:s');
            $projectlistnew = projectlist::where('id','=',$id)->get();
            $ins = 0;
            if(!empty($projectlistnew)){
                $campaigncode = "0000002263";
                $plantcode = "4100";

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
                
                $lead_check = lead_data::where('Source_type','=','Blog')->where('Project_id','=',$id)->where('Email','=',$request->Email)->count();

                $lead = new lead_data();
                $lead->Project_id = $id;
                $lead->PID = $pidtime;
                $lead->Project_name = $list->Project_name;
                $lead->Source_type = 'Blog';
                $lead->Name = preg_replace("/[^A-Za-z.?! ]/","",$request->Name);
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
                $lead->created_at = date('Y-m-d H:i:s');
                $lead->updated_at = date('Y-m-d H:i:s');
                $lead->save();

                $request->session()->flash("thanks_session", $leaddttime);
            $sqftrange =  sqft_range::where('P_id','=',$id)->get();
            //return view('GoogleProject.thanks')->with(['list' => $list, 'sqftrange' => $sqftrange] );
            $request->session()->flash("success", "Thanks for your input, we will get back to you shortly!");
            return redirect()->route('a_perfect_location_to_buy_your_luxury_dream_home');
        }
        else{
            $request->session()->flash("24hours", $addoneday);
            //alert('You can enquire after 24 hours from the laste enquired datetime.');
            return redirect()->back();
            
        }
    }
}
