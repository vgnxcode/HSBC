<?php

namespace vgn\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use vgn\Mail\vgnhomesleadsmail;
use Session;
use DB;


class vgnhomesController extends Controller
{

    public function index()
    {
        //return 1;
        return view('vgnhomes.signin');

    }

    public function postindex(Request $request)
    {
         $validate = $this->validate($request, [
            'username' => 'required|email',
			'password' => 'required|min:6|max:12'
        ]);

        $checklogin = DB::table('vgnhomeslogin')->where(['username' => $request->username,'password' => $request->password ])->count();

        if ($checklogin == 1) {
            $now = date('Y-m-d H:i:s');
            $encryptedkey = substr(bcrypt(rand(5,2334).'VGnHomes*(#'), 0,16);
            $updatekey = DB::table('vgnhomeslogin')->where(['username' => $request->username])->update(['apikey' => $encryptedkey,'lastupdated_date' => $now]);
            session()->put('vgnhomesession', $encryptedkey);
            return redirect()->route('showleads');
        }
        else{

            session()->flash("error_msg", 'Incorrect Username or Password! Try again!');

            return redirect()->back();
        }

    }

    public function showleads()
    {
        if (session()->has('vgnhomesession')) {
        $key = session()->get('vgnhomesession');       
        $verifylogin = DB::table('vgnhomeslogin')->where(['apikey' => $key ])->count();
        if ($verifylogin == 1) {
            //$getleads = DB::table('homesleads')->orderBy('created_date','desc')->get();

        return view('vgnhomes.leads');
        }
        else{
        session()->forget('vgnhomesession');
        return redirect()->route('vgnhomessignin');
        }
        
        }
        else{
            return redirect()->route('vgnhomessignin');
        }
    }

     public function postleads(Request $request)
    {


	 $validate = $this->validate($request, [
            'leadstdate' => 'required|date|date_format:Y-m-d|after:2017-09-21',
            'leadetdate' => 'required|date|date_format:Y-m-d|after:2017-09-21',
        ]);
        

        if (empty($request->leadstdate) || empty($request->leadetdate)) {
                session()->flash("error_msg", "Sorry! Enter a valid start and end date!");
                return redirect()->back()->withInput();
        }

        if (Carbon::parse($request->leadstdate.' 00:00:00')->gt(Carbon::parse($request->leadetdate.' 00:00:00'))) {
                session()->flash("error_msg", "Start Date Cannot be greater than End Date!");
                return redirect()->back()->withInput();
        }

        //$getleads = DB::table('copyofvgnhomesleads')->where('lead_datetime','LIKE','%'.$request->leaddate.'%')->orderBy('lead_datetime','desc')->get();
        $getleads = DB::table('copyofvgnhomesleads')->where('lead_datetime','>=',$request->leadstdate.' 00:00:00')->where('lead_datetime','<=',$request->leadetdate.' 23:59:59')->orderBy('lead_datetime','desc')->get();

        if (count($getleads) > 0) {
            return view('vgnhomes.leads')->with(['homesleads'=> $getleads]);
        }
        else{

            session()->flash("error_msg", 'No leads found!');

            return redirect()->back();
        }

    }

    public function changepwd()
    {
        if (session()->has('vgnhomesession')) {
        $key = session()->get('vgnhomesession');       
        $verifylogin = DB::table('vgnhomeslogin')->where(['apikey' => $key ])->count();
        if ($verifylogin == 1) {
            //$getleads = DB::table('homesleads')->orderBy('created_date','desc')->get();

        return view('vgnhomes.changepwd');
        }
        else{
        session()->forget('vgnhomesession');
        return redirect()->route('vgnhomessignin');
        }
        
        }
        else{
            return redirect()->route('vgnhomessignin');
        }
    }

    public function postchangepwd(Request $request)
    {
             if (session()->has('vgnhomesession')) {
        $key = session()->get('vgnhomesession');       
        $verifylogin = DB::table('vgnhomeslogin')->where(['apikey' => $key ])->count();
        if ($verifylogin == 1) {

         $validate = $this->validate($request, [
            'newpassword' => 'required|min:6|max:16',
            'retypepassword' => 'required|same:newpassword',
        ]);
        $now = date('Y-m-d H:i:s');

        $updatekey = DB::table('vgnhomeslogin')->where(['apikey' => $key])->update(['password' => $request->newpassword,'lastupdated_date' => $now]);

        session()->flash("suc_msg", 'Successfully password has been updated!');
        return redirect()->route('showleads');

        }
        else{
        session()->forget('vgnhomesession');
        return redirect()->route('vgnhomessignin');
        }
        
        }
        else{
            return redirect()->route('vgnhomessignin');
        }

    }

    public function logoutvgnhomes()
    {
         if (session()->has('vgnhomesession')) {
        session()->forget('vgnhomesession');
        return redirect()->route('vgnhomessignin');
        
        }
        else{
            return redirect()->route('vgnhomessignin');
        }
    }

public function copyvgnleadsandsendmail_to_homes()
    {
        $projectids = [6,8,11,17,18,19,22,24,91,108,110,117,119,120,124,125,126,127,128,129,130,131,132,133,134];
        $currentdate = Carbon::now()->format('Y-m');
	//$currentdate = '2019-10';
        $gethomesleads = DB::connection('mysql')->table('lead_data')->whereIn('Project_id',$projectids)->where('lead_datetime','LIKE','%'.$currentdate.'%')->get();
	
        if (count($gethomesleads) > 0) {
            $currentdatetime = Carbon::now()->toDateTimeString();
            $kk = 0;
            foreach ($gethomesleads as $key => $value) {
                $pid = $value->PID;
                $leaddatetime = $value->lead_datetime;
                $checkmoved = DB::connection('mysql')->table('copyofvgnhomesleads')->where(['pid' => $pid,'lead_datetime' => $leaddatetime])->count();
                if ($checkmoved == 0) {
                    $kk += 1;

$name = preg_replace("/[^A-Za-z.?! ]/","",$value->Name);
$dtformat = Carbon::parse($value->lead_datetime)->format('d/m/Y');
$nmob = str_replace('+91', '', $value->Mobile);
$nmob1 = trim(str_replace(' ', '', $nmob));
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "http://210.18.154.123:8088/api/values/post",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS =>"{\r\n    \"CustomerName\": \"$name\", \r\n    \"MobileNumber\": \"$nmob1\",\r\n    \"PhoneNo\": \"\",\r\n    \"CountryCode\": \"\",\r\n    \"Email\": \"$value->Email\",\r\n    \"City\": \"$value->City\",\r\n    \"Location\": \"\",\r\n    \"Date\": \"$dtformat\",\r\n    \"Address\": \"\",\r\n    \"Category\": \"\",\r\n    \"ProjectName\": \"$value->Project_name\",\r\n    \"Budget\":\"\",\r\n    \"Description\": \"\",\r\n    \"AgentName\":\"$value->Source_type\"\r\n}",
  CURLOPT_HTTPHEADER => array(
    "Content-Type: application/json"
  ),
));

$response = curl_exec($curl);
Log::info('VGN Homes Leads sent '.$response);
curl_close($curl);
                    DB::connection('mysql')->table('copyofvgnhomesleads')->insert([
                        'id' => null,
                        'Project_Id' => $value->Project_id,
                        'Project_Name' => $value->Project_name,
                        'Source_type' => $value->Source_type,
                        'Name' => preg_replace("/[^A-Za-z.?! ]/","",$value->Name),
                        'Email' => $value->Email,
                        'Mobile' => $value->Mobile,
                        'lead_datetime' => $value->lead_datetime,
                        'movedtocurrenttable_datetime' => $currentdatetime,
                        'pid' => $value->PID
                    ]);

                    //$newmaildata = [];
                    //$newmaildata['maildata'] = $value;
                    
                   // Log::info('Sending Email to vgnhomes');
                                    //Mail::to("ajay@vgngroup.org")->send(new vgnhomesleadsmail($newmaildata));
				    //Mail::to("terry@vgngroup.org")->send(new vgnhomesleadsmail($newmaildata));
				    //Mail::to("naveenv@vgn.in")->send(new vgnhomesleadsmail($newmaildata));


                    
                }
                
            }
            echo 'Completed moving...'.$kk.' leads to vgnhomes!';
Log::info('Completed moving...'.$kk.' leads to vgnhomes!');
        }
        echo 'Completed';
    }


}
