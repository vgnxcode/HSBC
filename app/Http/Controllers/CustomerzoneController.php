<?php

namespace vgn\Http\Controllers;

use Carbon\Carbon;
use Crypt;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\MessageBag;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use Session;
use vgn\Http\Traits\customertrait;
use vgn\Http\Traits\ameyotrait;
use vgn\Jobs\customer_complaints_sync;
use vgn\Jobs\customer_inspectionsnag_sync;
use vgn\Jobs\customer_paymenthistory_sync;
use vgn\Mail\saleagreementmail;
use vgn\Mail\sendforgotpwdotp;
use vgn\projectlist;
use vgn\vendor_api_key;
use vgn\whatsapp_scheduler;

use Illuminate\Support\Facades\Hash;


class CustomerzoneController extends Controller
{
    use customertrait;
    use ameyotrait;

    public function is_cust_didnt_passwordchanged($id)
    {
        $is_didnt_passwordchanged = DB::connection('mysql3')->table('customer')->where(['id' => $id])->get();
        $changed_pwd = 1;
        foreach ($is_didnt_passwordchanged as $key => $value) {
            if (($value->pwd_updated == null) || ($value->pwd_updated == '') || ($value->pwd_updated == '0000-00-00 00:00:00')) {
                $changed_pwd = 0;
            }
        }
                        return $changed_pwd;
    }
    
     public function newindex(Request $request)
    {       
	if ($request->session()->has('resetpwd')) {
            return redirect()->route('resetlink');
        } 
        if ($request->session()->has('customersession')) {
            $encrypt = $request->session()->get('customersession');
            $decrypt = Crypt::decrypt($encrypt);
            //dd($decrypt);
            $split = explode("-",$decrypt);
            $customerid = $split[0];
            return $this->newlogout($request);
           // dd($customerid);

           $getcustomerdata = DB::connection('mysql3')->table('customer')->where('id', '=', $customerid)->get();
	$getblockdates = DB::connection('mysql3')->table('projects')->where('cust_id', '=', $customerid)->where('exp_date_of_compl', '!=', '')->get();            
             $listfiles = Storage::disk('s3')->files('/newcustomerzoneassets/customersprofileimage/'.$customerid);
             if(count($listfiles) > 0){
                $profilepic = config('app.AWS_URL')."/".$listfiles[0];
            }
             else
             {
                $profilepic = config('app.AWS_URL')."/newcustomerzoneassets/img/dummy_male.png";
             }

            return view('newcustomerzone.dashboard')->with(['getcustomerdata' => $getcustomerdata, 'profilepic' => $profilepic,'getblockdates' => $getblockdates]);
        }
        return view('newcustomerzone.login');
    }

    
    public function logincheck(Request $request)
   {

    $validate = $this->validate($request, [
            'username' => 'required',
            'password' => 'required'
            ]);
  
     if (ctype_digit($request->username)) {

           if((strlen($request->username) >= 3)&&(strlen($request->username) < 10)){
                $loginmode = 'loginmode_customerid';
            }
            else{
                $request->session()->flash("error_msg", "Sorry! Enter a valid CustomerId or Mobile Number");
                return redirect()->back()->withInput();
            }
                
        }
        else{
            
                $request->session()->flash("error_msg", "Sorry! Enter a valid Username");
                return redirect()->back()->withInput();
        }

        //dd($loginmode);

       
        $arr = [];
        if ($loginmode == 'loginmode_customerid') {
            $arr['Cust_ID'] = $request->username;
        }
      

        if (!empty($arr)) {
             $sap_res = $this->customerbasicinfo($arr['Cust_ID']);
             $res['Cust_ID'] = $sap_res['Customer_ID'];
              $res['Name'] = $sap_res['Customer_Name'];
               $res['E_Mail'] = $sap_res['E_Mail'];
                $res['Pass_Word'] = $sap_res['Pass_Word'];
                 $res['Mobile_No'] = $sap_res['Mobile_No'];

            // dd($res['Name']);
            if ($res['Name'] == '0') {
                $request->session()->flash("error_msg", "Invalid User. Try with valid username");
                return redirect()->back()->withInput();
            }
            /*if (($res['Mobile_No'] == '0') && ($res['E_Mail'] == '0')) {
                $request->session()->flash("error_msg", "Please contact Customer Care. Your registered mobile number and mail id is Invalid!");
                return redirect()->back()->withInput();
            }*/

            if (($res['Cust_ID'] != '0') && ($res['Name'] != '0') ) {

                $checkcstexistindb = DB::connection('mysql3')->table('customer')->where(['id' => $res['Cust_ID']])->count();
                if ($checkcstexistindb >  0) {
                    $checklogin = DB::connection('mysql3')->table('customer')->where(['id' => $res['Cust_ID']])->get();
                    foreach ($checklogin as $keycheck => $valuecheck) {
                        $hashedPassword = $valuecheck->password;
                    }
                   // dd(count($checklogin),$checklogin,$request->password, $hashedPassword);
                    if ((count($checklogin) > 0) && (Hash::check($request->password, $hashedPassword)||($request->password ==$hashedPassword))) {
                        
                        $sapdata = $this->customerbasicinfo($res['Cust_ID']);
                         if($sapdata['Customer_Name'] != ''){

                    if($sapdata['Postal_Code'] == ''){ $sapdata['Postal_Code'] = 0; }
                    //if($sapdata['Net_amount'] != ''){ $sapdata['Net_amount'] = str_replace('-','',$sapdata['Net_amount']); }
                    $now = Carbon::now();
                    DB::connection('mysql3')->table('customer')->where(['id' => $res['Cust_ID']])->update([
                    'Name' => $sapdata['Customer_Name'],
                    'valid' => $sapdata['Customer_status'],
                    'street1'=> $sapdata['Address_Street_1'],
                    'street2'=> $sapdata['Address_Street_2'],
                    'street3'=> $sapdata['Address_Street_3'],
                    'houseno'=> $sapdata['Street_House_number'],
                    'city'=> $sapdata['City'],
                    'country'=> $sapdata['Country'],
                    'pin'=> $sapdata['Postal_Code'],
                    'region'=> $sapdata['Region'],
                    'tel'=> $sapdata['Telephone'],
                    'mobile'=> $sapdata['Mobile_No'],
                    'fax'=> $sapdata['FAX_NUMBER'],
                    'email'=> $sapdata['E_Mail'],
                    'comp_raised'=> $sapdata['No_Of_Comp_Raised'],
                    'comp_closed'=> $sapdata['No_Of_Comp_Closed'],
                    'comp_pending'=> $sapdata['No_Of_Comp_Pending'],
                    'net_amt'=> $sapdata['Net_amount'],
                    'nou'=> $sapdata['No_Of_Unit'],
                    'customer_executive'=> $sapdata['Customer_Executive'],
                    'customer_manager'=> $sapdata['Customer_Manager'],
                    'act_no'=> $sapdata['Acc_No'],
                    'branch_name'=> $sapdata['Branch_Name'],
                    'ifsc_code'=> $sapdata['IFSC_Code'],
                    'bank_name'=> $sapdata['Bank_Name']
                    ]); 

                    $sap_proj = array();
                    if (!array_key_exists('Project_Detail', $sapdata)) {
                      DB::connection('mysql3')->table('customer')->where('id','=',$res['Cust_ID'])->delete();
                      
                        $request->session()->flash("error_msg", "Project details not available!");
                        return redirect()->back()->withInput();
                    }

                    $sapprojects = $sapdata['Project_Detail'];
                    if (array_key_exists('0', $sapprojects)) {
                        $sap_proj = $sapprojects;
                    }
                    else
                    {
                        $sap_proj[0] = $sapprojects;
                    }
                    
                     $getprojects = DB::connection('mysql3')->table('projects')->where('cust_id', '=', $res['Cust_ID'])->get();

                     if(count($getprojects) != 0)
                     {
                        foreach ($sap_proj as $sapprojkey1 => $sapprojvalue1) {

                            $expdt_of_comp = null;
                            $dlp_end_date = null;
                            if ($sapprojvalue1['Exp_Dateof_Completion'] != '00000000') {
                                $expdt_of_comp = substr($sapprojvalue1['Exp_Dateof_Completion'],0,4).'-'.substr($sapprojvalue1['Exp_Dateof_Completion'],4,2).'-'.substr($sapprojvalue1['Exp_Dateof_Completion'],6,2);
                            }
        
                            if ($sapprojvalue1['DLP_End_Date'] != '00000000') {
                                $dlp_end_date = substr($sapprojvalue1['DLP_End_Date'],0,4).'-'.substr($sapprojvalue1['DLP_End_Date'],4,2).'-'.substr($sapprojvalue1['DLP_End_Date'],6,2);
                            }


                            $updatedinsp1 = DB::connection('mysql3')->table('projects')->where(['cust_id' => $res['Cust_ID'],'project_id'=>$sapprojvalue1['Plant'],'unit'=>$sapprojvalue1['Unit'] ])->update(['milestone' => $sapprojvalue1['Milestone'],
                                'posession' => $sapprojvalue1['Possession'],
                                'projectlink' => $sapprojvalue1['Link'],
                                'dlp_end_date' => $dlp_end_date,
                                'exp_date_of_compl' => $expdt_of_comp,
                                'Block_name' => $sapprojvalue1['Block_Name']
                        ]);
                                     
                        

                }
                     }

                     if(count($getprojects) == 0)
                     {
                        foreach ($sap_proj as $sapprojkey => $sapprojvalue) {
                    
                    
                    DB::connection('mysql3')->table('projects')->insert(['cust_id' => $res['Cust_ID'],
                                'pname' => $sapprojvalue['Plant_Name'],
                                'project_id' => $sapprojvalue['Plant'],
                                'unit' => $sapprojvalue['Unit'],
                                'unit_nm' => $sapprojvalue['Unit_Name'],
                                'milestone' => $sapprojvalue['Milestone'],
                                'posession' => $sapprojvalue['Possession'],
                                'snagcreatedbyuser' => null,
                                'projectlink' => $sapprojvalue['Link'],
                                ]);
                    
                        }
                     }
                     //dd([$res['Cust_ID'],'presentindb']);  
                    $toencrypt = $res['Cust_ID'].'-#Vgn@M@ain`encRyption89';
                    $encrypt = Crypt::encrypt($toencrypt);
                    $request->session()->flash("runsap", "valid");
                    $request->session()->put('customersession', $encrypt);
                 
                    $paymenthistoryjob = (new customer_paymenthistory_sync($res['Cust_ID'],'presentindb'))->delay(Carbon::now()->addSeconds(3));
                    $inspectionsnagjob = (new customer_inspectionsnag_sync($res['Cust_ID'],'presentindb'))->delay(Carbon::now()->addSeconds(3));
                    $complaintsjob = (new customer_complaints_sync($res['Cust_ID'],'presentindb'))->delay(Carbon::now()->addSeconds(3));
                 
                 
                    dispatch($inspectionsnagjob);
                    dispatch($complaintsjob);
		            dispatch($paymenthistoryjob);

                    return redirect()->route('newcustomer_dashboard',['custid' => $res['Cust_ID']]);

                }

                $request->session()->flash("error_msg", "Sorry! <b>Customer does not exist!</b>!");
                 return redirect()->back();
                        

                    }
                    else{
                        $request->session()->flash("error_msg", "Password does not match.Try Again!");
                        return redirect()->back()->withInput();
                    }
                }
                else{
                    $sapdata = $this->customerbasicinfo($res['Cust_ID']);
                    //$sapdata1 = $this->getCustomer($res['Cust_ID']);
                    //dd($sapdata1);
                    if($sapdata['Pass_Word'] == $request->password){

                        if($sapdata['Customer_Name'] != '')
                 {
                     if($sapdata['Postal_Code'] == ''){ $sapdata['Postal_Code'] = 0; }
                     //if($sapdata['Net_amount'] != ''){ $sapdata['Net_amount'] = str_replace('-','',$sapdata['Net_amount']); }
                     $now = Carbon::now();
                     DB::connection('mysql3')->table('customer')->insert([
                     'id' => $res['Cust_ID'],
                     'Name' => $sapdata['Customer_Name'],
                     'password' => Hash::make($sapdata['Pass_Word'], ['rounds' => 12]),
                     'valid' => $sapdata['Customer_status'],
                     'street1'=> $sapdata['Address_Street_1'],
                     'street2'=> $sapdata['Address_Street_2'],
                     'street3'=> $sapdata['Address_Street_3'],
                     'houseno'=> $sapdata['Street_House_number'],
                     'city'=> $sapdata['City'],
                     'country'=> $sapdata['Country'],
                     'pin'=> $sapdata['Postal_Code'],
                     'region'=> $sapdata['Region'],
                     'tel'=> $sapdata['Telephone'],
                     'mobile'=> $sapdata['Mobile_No'],
                     'fax'=> $sapdata['FAX_NUMBER'],
                     'email'=> $sapdata['E_Mail'],
                     'comp_raised'=> $sapdata['No_Of_Comp_Raised'],
                     'comp_closed'=> $sapdata['No_Of_Comp_Closed'],
                     'comp_pending'=> $sapdata['No_Of_Comp_Pending'],
                     'net_amt'=> $sapdata['Net_amount'],
                     'nou'=> $sapdata['No_Of_Unit'],
                     'customer_executive'=> $sapdata['Customer_Executive'],
                     'customer_manager'=> $sapdata['Customer_Manager'],
                     'updated'=> null,
                     'pwd_updated'=> null,
                     'pwd_count'=> 0,
                     'act_no'=> $sapdata['Acc_No'],
                     'branch_name'=> $sapdata['Branch_Name'],
                     'ifsc_code'=> $sapdata['IFSC_Code'],
                     'bank_name'=> $sapdata['Bank_Name'],
                     'created' => $now,
                     'schedular' => null
                     ]); 
                    
                    $sap_proj = array();
                    if (!array_key_exists('Project_Detail', $sapdata)) {
                      DB::connection('mysql3')->table('customer')->where('id','=',$res['Cust_ID'])->delete();
                      
                        $request->session()->flash("error_msg", "Project details not available!");
                        return redirect()->back()->withInput();
                    }
                    
                    $sapprojects = $sapdata['Project_Detail'];
                    if (array_key_exists('0', $sapprojects)) {
                        $sap_proj = $sapprojects;
                    }
                    else
                    {
                        $sap_proj[0] = $sapprojects;
                    }
                    
                     $getprojects = DB::connection('mysql3')->table('projects')->where('cust_id', '=', $res['Cust_ID'])->get();
                      if(count($getprojects) == 0)
                     {
                        foreach ($sap_proj as $sapprojkey => $sapprojvalue) {

                    $expdt_of_comp = null;
                    $dlp_end_date = null;
                    if ($sapprojvalue['Exp_Dateof_Completion'] != '00000000') {
                        $expdt_of_comp = substr($sapprojvalue['Exp_Dateof_Completion'],0,4).'-'.substr($sapprojvalue['Exp_Dateof_Completion'],4,2).'-'.substr($sapprojvalue['Exp_Dateof_Completion'],6,2);
                    }

                    if ($sapprojvalue['DLP_End_Date'] != '00000000') {
                        $dlp_end_date = substr($sapprojvalue['DLP_End_Date'],0,4).'-'.substr($sapprojvalue['DLP_End_Date'],4,2).'-'.substr($sapprojvalue['DLP_End_Date'],6,2);
                    }
                    
                    
                    DB::connection('mysql3')->table('projects')->insert(['cust_id' => $res['Cust_ID'],
                                'pname' => $sapprojvalue['Plant_Name'],
                                'project_id' => $sapprojvalue['Plant'],
                                'unit' => $sapprojvalue['Unit'],
                                'unit_nm' => $sapprojvalue['Unit_Name'],
                                'milestone' => $sapprojvalue['Milestone'],
                                'posession' => $sapprojvalue['Possession'],
                                'snagcreatedbyuser' => null,
                                'projectlink' => $sapprojvalue['Link'],
                                'dlp_end_date' => $dlp_end_date,
                                'exp_date_of_compl' => $expdt_of_comp,
                                'Block_name' => $sapprojvalue['Block_Name']
                                ]);
                           
                        }
                     }
                     
                     $sapencrypt = Crypt::encrypt($sapdata['Pass_Word']);
                     $getpwdforsap = DB::connection('mysql3')->table('sapcustomer')->where('customerid', '=', $res['Cust_ID'])->get();
                     if(count($getpwdforsap) > 0)
                     {
                         DB::connection('mysql3')->table('sapcustomer')->where('customerid', '=', $res['Cust_ID'])->delete();
                         DB::connection('mysql3')->table('sapcustomer')->insert(['customerid' => $res['Cust_ID'], 'password' => $sapencrypt]);
                     }
                     else
                     {
                        DB::connection('mysql3')->table('sapcustomer')->insert(['customerid' => $res['Cust_ID'], 'password' => $sapencrypt]);
                     }
                     //dd([$res['Cust_ID'],'notpresentindb']);
                     $toencrypt = $res['Cust_ID'].'-#Vgn@M@ain`encRyption89';
                 $encrypt = Crypt::encrypt($toencrypt);
                 $request->session()->flash("runsap", "valid");
                 $request->session()->put('customersession', $encrypt);

                 $paymenthistoryjob1 = (new customer_paymenthistory_sync($res['Cust_ID'],'notpresentindb'))->delay(Carbon::now()->addSeconds(3));
                 $inspectionsnagjob1 = (new customer_inspectionsnag_sync($res['Cust_ID'],'notpresentindb'))->delay(Carbon::now()->addSeconds(3));
                 $complaintsjob1 = (new customer_complaints_sync($res['Cust_ID'],'notpresentindb'))->delay(Carbon::now()->addSeconds(3));
                
                 dispatch($inspectionsnagjob1);
                 dispatch($complaintsjob1);
		dispatch($paymenthistoryjob1);
                 return redirect()->route('newcustomer_dashboard',['custid' => $res['Cust_ID']]);

                 }

                        $request->session()->flash("error_msg", "Sorry! <b>Customer does not exist!</b>!");
                        return redirect()->back();
                    }
                    else{
                        $request->session()->flash("error_msg", "Password does not match.Try Again!");
                        return redirect()->back()->withInput();
                    }
                }
                
            }
            else{
                $request->session()->flash("error_msg", "Not a Valid Customer!");
                        return redirect()->back()->withInput();
            }

            
        }
       
   }

    

    
     public function newdashboard(Request $request, $custid)
    {
        if ($request->session()->has('saleagree')) {
            $getsale = $request->session()->get('saleagree');

            if ($getsale == 'yes') {
                return redirect()->route('registrationdetails');
            }
        }
        
       
        if ($request->session()->has('customersession')) {
        
            $encrypt = $request->session()->get('customersession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $customerid = $split[0];

            if ($custid != $customerid) {
                return $this->newlogout($request);
            }

            $pwd_status = $this->is_cust_didnt_passwordchanged($customerid);
            if ($pwd_status == 0) {
                $request->session()->flash("error_msg", 'Please change the default password. Only if you Change the default password , other functionalities on this portal will work. This is done for security purposes. Please do not share your password with anyone');
                return redirect()->route('newcustomer_mydetails_passchange');
            }

            $getcustomerdata = DB::connection('mysql3')->table('customer')->where('id', '=', $customerid)->get();
            $getblockdates = DB::connection('mysql3')->table('projects')->where('cust_id', '=', $customerid)->where('exp_date_of_compl', '!=', '')->get();

            //dd($getcustomerdata);
             $listfiles = Storage::disk('s3')->files("/newcustomerzoneassets/customersprofileimage/".$customerid);
             
             if(count($listfiles) > 0){
                $profilepic = config('app.AWS_URL')."/".$listfiles[0];
            }
             else
             {
                $profilepic = config('app.AWS_URL')."/newcustomerzoneassets/img/dummy_male.png";
             }
            
            return view('newcustomerzone.dashboard')->with(['getcustomerdata'=>$getcustomerdata, 'profilepic' => $profilepic,'getblockdates' => $getblockdates]);
        }
        else{
            return redirect()->route('newcustomer_home');
        }
            
        
    }

    public function newmydetails(Request $request)
    {
        if ($request->session()->has('customersession')) {
            $encrypt = $request->session()->get('customersession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $customerid = $split[0];
            $getcustomerdata = DB::connection('mysql3')->table('customer')->where('id', '=', $customerid)->get();

            $pwd_status = $this->is_cust_didnt_passwordchanged($customerid);
            if ($pwd_status == 0) {
                $request->session()->flash("error_msg", 'Please change the default password. Only if you Change the default password , other functionalities on this portal will work. This is done for security purposes. Please do not share your password with anyone');
                return redirect()->route('newcustomer_mydetails_passchange');
            }
            
            $getblockdates = DB::connection('mysql3')->table('projects')->where('cust_id', '=', $customerid)->where('exp_date_of_compl', '!=', '')->get();
             $listfiles = Storage::disk('s3')->files("/newcustomerzoneassets/customersprofileimage/".$customerid);
             
             if(count($listfiles) > 0){
                $profilepic = config('app.AWS_URL')."/".$listfiles[0];
            }
             else
             {
                $profilepic = config('app.AWS_URL')."/newcustomerzoneassets/img/dummy_male.png";
             }
            
            return view('newcustomerzone.mydetails')->with(['getcustomerdata'=>$getcustomerdata, 'profilepic' => $profilepic,'getblockdates' => $getblockdates]);
        }
        else{
            return redirect()->route('newcustomer_home');
        }
            
        
    }

    public function newmydetails_passchange(Request $request)
    {
        
        if ($request->session()->has('customersession')) {
            $encrypt = $request->session()->get('customersession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $customerid = $split[0];
            $getcustomerdata = DB::connection('mysql3')->table('customer')->where('id', '=', $customerid)->get();
            $getblockdates = DB::connection('mysql3')->table('projects')->where('cust_id', '=', $customerid)->where('exp_date_of_compl', '!=', '')->get();
            
             $listfiles = Storage::disk('s3')->files("/newcustomerzoneassets/customersprofileimage/".$customerid);
             
             if(count($listfiles) > 0){
                $profilepic = config('app.AWS_URL')."/".$listfiles[0];
            }
             else
             {
                $profilepic = config('app.AWS_URL')."/newcustomerzoneassets/img/dummy_male.png";
             }
            
            return view('newcustomerzone.mydetails_changepass')->with(['getcustomerdata'=>$getcustomerdata, 'profilepic' => $profilepic,'getblockdates' => $getblockdates]);
        }
        else{
            return redirect()->route('newcustomer_home');
        }
            
        
    }

    public function newpasswordchange(Request $request) 
    {

        if ($request->session()->has('customersession')) {
            $encrypt = $request->session()->get('customersession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $customerid = $split[0];
            $getcustomerdata = DB::connection('mysql3')->table('customer')->where('id', '=', $customerid)->get();
            
       
        $validate = $this->validate($request, [
            'oldpasword' => 'required',
			'newpass' => 'required|min:6|max:12',
            'retypepass' => 'required|same:newpass'
			]);

        $checkpassword = DB::connection('mysql3')->table('customer')->where('id', '=', $customerid)->get();
        foreach ($checkpassword as $key11 => $value11) {
                $hashedpassword = $value11->password;
            }

        if (Hash::check($request->oldpasword, $hashedpassword) === false) {
            $request->session()->flash("error_msg", "Sorry! Entered Old Password is incorrect!");
            return redirect()->back();
        }
        else
        {
            if (Hash::check($request->newpass, $hashedpassword) === true) {
                $request->session()->flash("error_msg", "The New password cannot be same as old password!");
            return redirect()->back();
            }
            
            $now = Carbon::now();
            foreach ($getcustomerdata as $value) {
                $pwdcount = $value->pwd_count;
            }

            $newpwdcount = $pwdcount + 1;
            
            DB::connection('mysql3')->table('customer')->where('id', '=', $customerid)->update(['password' => Hash::make($request->newpass, ['rounds' => 12]), 'pwd_updated' => $now, 'pwd_count' => $newpwdcount ]);
            $request->session()->flash("suc_msg", "successfully New Password has been updated!");
            return redirect()->back();

        }

         }
        else{
            return redirect()->route('newcustomer_home');
        }
        


    }

    /*public function newchangemydetails(Request $request)
    {
        if ($request->session()->has('customersession')) {
            $encrypt = $request->session()->get('customersession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $customerid = $split[0];
            $getcustomerdata = DB::connection('mysql3')->table('customer')->where('id', '=', $customerid)->get();
            $getblockdates = DB::connection('mysql3')->table('projects')->where('cust_id', '=', $customerid)->where('exp_date_of_compl', '!=', '')->get();

            $pwd_status = $this->is_cust_didnt_passwordchanged($customerid);
            if ($pwd_status == 0) {
                $request->session()->flash("error_msg", 'Please change the default password. Only if you Change the default password , other functionalities on this portal will work. This is done for security purposes. Please do not share your password with anyone');
                return redirect()->route('newcustomer_mydetails_passchange');
            }
            
             $listfiles = Storage::disk('s3')->files("/newcustomerzoneassets/customersprofileimage/".$customerid);
             
             if(count($listfiles) > 0){
                $profilepic = config('app.AWS_URL')."/".$listfiles[0];
            }
             else
             {
                $profilepic = config('app.AWS_URL')."/newcustomerzoneassets/img/dummy_male.png";
             }
            
             return view('newcustomerzone.changemydetails')->with(['getcustomerdata'=>$getcustomerdata, 'profilepic' => $profilepic,'getblockdates' => $getblockdates]);
        }
        else{
            return redirect()->route('newcustomer_home');
        }
        
    }

    public function newpostchangemydetails(Request $request)
    {
        if ($request->session()->has('customersession')) {
            $encrypt = $request->session()->get('customersession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $customerid = $split[0];
            $getcustomerdata = DB::connection('mysql3')->table('customer')->where('id', '=', $customerid)->get();
            
             $validate = $this->validate($request, [
            'addr1' => 'required|max:40',
			'addr2' => 'required|max:40',
            'addr3' => 'required|max:40',
            'houseno' => 'required|max:40',
            'city' => 'required',
            'country' => 'required',
            'pincode' => 'required',
            'region' => 'required',
            'telephone' => 'required|numeric',
            'mobile' => 'required|digits:10',
            'fax' => 'required'
			]);

         $now = Carbon::now();
            foreach ($getcustomerdata as $value) {
                $pwdcount = $value->pwd_count;
                $email = $value->email;
            }
        
            $newpwdcount = $pwdcount + 1;
            $updateinsap = $this->saveUserDetails($customerid, $request->addr1, $request->addr2, $request->addr3, $request->houseno,$request->city,$request->pincode,$request->country,$request->region,$request->telephone,$request->mobile,$request->fax,$email);
            

            DB::connection('mysql3')->table('customer')->where('id', '=', $customerid)->update(['street1' => $request->addr1,
            'street2' => $request->addr2,
            'street3' => $request->addr3,
            'houseno' => $request->houseno,
            'city' => $request->city,
            'pin' => $request->pincode,
            'region' => $request->region,
            'tel' => $request->telephone,
            'mobile' => $request->mobile,
            'fax' => $request->fax,
             'updated' => $now ]);
            $request->session()->flash("suc_msg", "successfully Profile has been updated!");
            return redirect()->back();


        }
        else{
            return redirect()->route('newcustomer_home');
        }
        
    }*/

    public function newcomplaints(Request $request)
    {
        if ($request->session()->has('customersession')) {
            $encrypt = $request->session()->get('customersession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $customerid = $split[0];
            $getcustomerdata = DB::connection('mysql3')->table('customer')->where('id', '=', $customerid)->get();
            $getcomplaints = DB::connection('mysql3')->table('complaints')->where('customer_id', '=', $customerid)->orderBy('updated', 'desc')->get();
             $listfiles = Storage::disk('s3')->files("/newcustomerzoneassets/customersprofileimage/".$customerid);
             $getblockdates = DB::connection('mysql3')->table('projects')->where('cust_id', '=', $customerid)->where('exp_date_of_compl', '!=', '')->get();

             $pwd_status = $this->is_cust_didnt_passwordchanged($customerid);
            if ($pwd_status == 0) {
                $request->session()->flash("error_msg", 'Please change the default password. Only if you Change the default password , other functionalities on this portal will work. This is done for security purposes. Please do not share your password with anyone');
                return redirect()->route('newcustomer_mydetails_passchange');
            }

             $getdlpdates = DB::connection('mysql3')->table('projects')->where('cust_id', '=', $customerid)->where(function ($query) {
                $query->where('dlp_end_date', '>=', Carbon::now()->toDateTimeString())
                      ->orWhere('dlp_end_date', '=', null);
            })->get();
		//dd($getdlpdates);
             if (count($getdlpdates) > 0) {
                $validtoraisecomplaints = 0;
                foreach ($getdlpdates as $key => $value) {
                   
                        $validtoraisecomplaints += 1;
                    
                }
                 
             }
             else{
                $validtoraisecomplaints = 0;
             }
             
             if(count($listfiles) > 0){
                $profilepic = config('app.AWS_URL')."/".$listfiles[0];
            }
             else
             {
                $profilepic = config('app.AWS_URL')."/newcustomerzoneassets/img/dummy_male.png";
             }
            
            return view('newcustomerzone.complaints')->with(['getcustomerdata' => $getcustomerdata, 'getcomplaints'=> $getcomplaints, 'profilepic' => $profilepic,'getblockdates'=>$getblockdates,'validtoraisecomplaints' => $validtoraisecomplaints]);
        }
        else{
            return redirect()->route('newcustomer_home');
        }
    }

    public function newraisecomplaints(Request $request)
    {
        if ($request->session()->has('customersession')) {
            $encrypt = $request->session()->get('customersession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $customerid = $split[0];
            $getcustomerdata = DB::connection('mysql3')->table('customer')->where('id', '=', $customerid)->get();
            $getproject = DB::connection('mysql3')->table('projects')->where('cust_id', '=', $customerid)->where(function ($query) {
                $query->where('dlp_end_date', '>=', Carbon::now()->toDateTimeString())
                      ->orWhere('dlp_end_date', '=', null);
            })->get();
            //$getnoc = DB::connection('mysql3')->table('noc')->get();

            $pwd_status = $this->is_cust_didnt_passwordchanged($customerid);
            if ($pwd_status == 0) {
                $request->session()->flash("error_msg", 'Please change the default password. Only if you Change the default password , other functionalities on this portal will work. This is done for security purposes. Please do not share your password with anyone');
                return redirect()->route('newcustomer_mydetails_passchange');
            }

            $sapnoc = $this->natureofcomplaints($customerid);
            $vv = [];
            foreach ($sapnoc['Nature_Of_Comp'] as $key122 => $value122) {
                $vv[$key122]['id'] = $value122['s_no'];
                $vv[$key122]['natureofcomplaint'] = $value122['Nature_of_comp'];
            }
            $vv = json_encode($vv);
            $getnoc = collect(json_decode($vv));
            $getblockdates = DB::connection('mysql3')->table('projects')->where('cust_id', '=', $customerid)->where('exp_date_of_compl', '!=', '')->get();

             $getdlpdates = DB::connection('mysql3')->table('projects')->where('cust_id', '=', $customerid)->where(function ($query) {
                $query->where('dlp_end_date', '>=', Carbon::now()->toDateTimeString())
                      ->orWhere('dlp_end_date', '=', null);
            })->get();
             if (count($getdlpdates) > 0) {
                $validtoraisecomplaints = 0;
                foreach ($getdlpdates as $key => $value) {
                 
                        $validtoraisecomplaints += 1;
                    
                }
                 
             }
             else{
                $validtoraisecomplaints = 0;
             }

            if($validtoraisecomplaints == 0){
                return redirect()->route('newcomplaints');
            }
            
             $listfiles = Storage::disk('s3')->files("/newcustomerzoneassets/customersprofileimage/".$customerid);
             
             if(count($listfiles) > 0){
                $profilepic = config('app.AWS_URL')."/".$listfiles[0];
            }
             else
             {
                $profilepic = config('app.AWS_URL')."/newcustomerzoneassets/img/dummy_male.png";
             }
            
             return view('newcustomerzone.raisecomplaints')->with(['getcustomerdata'=> $getcustomerdata, 'getproject' => $getproject, 'getnoc'=> $getnoc, 'profilepic' => $profilepic,'getblockdates' => $getblockdates]);
        }
        else{
            return redirect()->route('newcustomer_home');
        }
    }

    public function newpostraisecomplaints(Request $request)
    {        
        if ($request->session()->has('customersession')) {
            $encrypt = $request->session()->get('customersession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $customerid = $split[0];
            $getcustomerdata = DB::connection('mysql3')->table('customer')->where('id', '=', $customerid)->get();
            $getproject = DB::connection('mysql3')->table('projects')->where('cust_id', '=', $customerid)->get();

            
                      

             $validate = $this->validate($request, [
            'complaintproject' => 'required',
			'complaintunit' => 'required',
            'complaintnature' => 'required',
            'desccomp' => 'required|max:900'
			]);

            $projectname = '';
            $unitname = ''; 

             if (!empty($getproject)) {
                foreach ($getproject as $pvalue) {
                    
                    if(($pvalue->project_id == $request->complaintproject)&&($pvalue->unit == $request->complaintunit))
                    {
                        $projectname = $pvalue->pname;
                        $unitname = $pvalue->unit_nm; 
                    }
                }
            }

            if (($projectname != '')&&($unitname != '')) {
                
            
            $now = Carbon::now();
            $SavecustomertoSAP = $this->savecomplaint($customerid, $request->complaintproject, $request->complaintunit, $request->complaintnature, $request->desccomp  );
                        
            DB::connection('mysql3')->table('complaints')->insert(['complaint_no' => $SavecustomertoSAP['Compliant_no'],
            'project' => $projectname,
            'unit' => $unitname,
            'customer_id' => $customerid,
            'nature' => $request->complaintnature,
            'description' => $request->desccomp,
            'vgn_status' => 'OPEN',
            'cust_status' => 'OPEN',
            'final_status' => 'OPEN',
            'vgn_remarks' => null,
             'date' => date('Y-m-d'),
             'created' => $now,
             'updated' => $now,
             'Expecteddateofcomp' => null ]);
            $request->session()->flash("suc_msg", "Complaint Registered Successfully! Your Complaint ID is: ".$SavecustomertoSAP['Compliant_no']);


            return redirect()->back();

            }
            else
            {
                $request->session()->flash("error_msg", "Sorry,Complaint not raised try again!");
                return redirect()->back();
            }
        }
        else{
            return redirect()->route('newcustomer_home');
        }
    }

    public function newclosecomplaints(Request $request)
    {
        if ($request->session()->has('customersession')) {
            $encrypt = $request->session()->get('customersession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $customerid = $split[0];
            $getcustomerdata = DB::connection('mysql3')->table('customer')->where('id', '=', $customerid)->get();

            $validate = $this->validate($request, [
            'close' => 'required'
			]);

            $now = Carbon::now();
            $checkcomplaint = DB::connection('mysql3')->table('complaints')->where('customer_id', '=', $customerid)->where('complaint_no', '=', $request->close)->where('cust_status', '=', 'OPEN')->count();
            
            if ($checkcomplaint == 1) {

               $Closecustomercomplaint = $this->closecomplaint($customerid, $request->close); 

               if ($Closecustomercomplaint['Status_Note']=="CLOSED") {
                   DB::connection('mysql3')->table('complaints')->where('customer_id','=', $customerid)->where('complaint_no','=',$request->close)->update(['cust_status' => 'CLOSED','final_status' => 'CLOSED', 'updated' => $now]);
                   $request->session()->flash("suc_msg", "Complaint no ".$request->close." Closed Successfully!");
                   return redirect()->back();
               }
                
            }
            else{
                 $request->session()->flash("suc_msg", "Complaint no ".$request->close." Closed Already!");
                return redirect()->back();
            }

            
            
        }
        else{
            return redirect()->route('newcustomer_home');
        }
        
    }


    public function openclosecomplaints(Request $request)
    {
        if (!empty($_REQUEST['complaintno'])) {

            $complaintno = $_REQUEST['complaintno'];

            $complaint = DB::connection('mysql3')->table('complaints')->where('complaint_no', '=', $complaintno)->get();

            if (count($complaint) > 0) {
                foreach ($complaint as $key => $value) {
                    $customerid = $value->customer_id;
                    $complaintno = $value->complaint_no;
                    $project = $value->project;
                    $unit = $value->unit;
                    $customerstatus = $value->cust_status;
                }

                $getcustomerdata = DB::connection('mysql3')->table('customer')->where('id', '=', $customerid)->get();
                if (count($getcustomerdata) > 0) {
                    foreach ($getcustomerdata as $key1 => $value1) {
                        $name = $value1->name;
                    }
                }
                
                $now = Carbon::now()->toDateTimeString();

                if ($customerstatus == 'OPEN') {
                    //dd($name);
                    return view('newcustomerzone.openclosecomplaints')->with(['name'=> $name]);
                    

                }
                else{
                    $request->session()->flash("suc_msg", "Complaint Number ".$complaintno." raised by you has been completed and closed Already!");
                    return view('newcustomerzone.openclosecomplaints')->with(['name'=> $name]);
                }

                
            }
            else{
                $name="Customer";
                return view('newcustomerzone.openclosecomplaints')->with(['name'=> $name]);    
            }
        }
        else{
            return redirect()->route('newcustomer_home');
        }
    }
    public function postopenclosecomplaints(Request $request)
    {
        $complaintno = $request->compno;
         if (!empty($complaintno)) {


            $complaint = DB::connection('mysql3')->table('complaints')->where('complaint_no', '=', $complaintno)->get();

            if (count($complaint) > 0) {
                foreach ($complaint as $key => $value) {
                    $customerid = $value->customer_id;
                    $complaintno = $value->complaint_no;
                    $project = $value->project;
                    $unit = $value->unit;
                    $customerstatus = $value->cust_status;
                }

                $getcustomerdata = DB::connection('mysql3')->table('customer')->where('id', '=', $customerid)->get();
                if (count($getcustomerdata) > 0) {
                    foreach ($getcustomerdata as $key1 => $value1) {
                        $name = $value1->name;
                    }
                }
                
                $now = Carbon::now()->toDateTimeString();

                if ($customerstatus == 'OPEN') {
                    //dd($name);
                    
                    $Closecustomercomplaint = $this->closecomplaint($customerid, $complaintno); 

               if ($Closecustomercomplaint['Status_Note']=="CLOSED") {
                  
                   DB::connection('mysql3')->table('complaints')->where('customer_id','=', $customerid)->where('complaint_no','=',$complaintno)->update(['cust_status' => 'CLOSED','final_status' => 'CLOSED', 'updated' => $now]);
                   $request->session()->flash("suc_msg", "Complaint Number ".$complaintno." raised by you has been completed and closed successfully!");
                   return 1;
               }

                }
                else{
                    $request->session()->flash("suc_msg", "Complaint Number ".$complaintno." raised by you has been completed and closed successfully!");
                    return 1;
                }

                
            }
            else{
                $Closecustomercomplaint = $this->closecomplaint('', $complaintno);
                //dd($Closecustomercomplaint);
                if (array_key_exists('code', $Closecustomercomplaint)) {
                    if ($Closecustomercomplaint['code'] == '200') {
                        $request->session()->flash("suc_msg", "Complaint Number ".$complaintno." raised by you has been completed and closed successfully!");
                    return 1;
                    }
                    else{
                        $request->session()->flash("suc_msg", "Invalid Complaint Number. Try again!");
                        return 0;
                    }    
                }
                
                //dd($Closecustomercomplaint);
                return 0;    
            }
        }
        else{
            return 0;
        }
    }

    public function newpaymenthistory(Request $request)
    {
        if ($request->session()->has('customersession')) {
            $encrypt = $request->session()->get('customersession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $customerid = $split[0];
            $getcustomerdata = DB::connection('mysql3')->table('customer')->where('id', '=', $customerid)->get();

            $pwd_status = $this->is_cust_didnt_passwordchanged($customerid);
            if ($pwd_status == 0) {
                $request->session()->flash("error_msg", 'Please change the default password. Only if you Change the default password , other functionalities on this portal will work. This is done for security purposes. Please do not share your password with anyone');
                return redirect()->route('newcustomer_mydetails_passchange');
            }

            //$funcpaymenthistoryjob1 = (new customer_paymenthistory_sync($customerid,'presentindb'));
            //dispatch($funcpaymenthistoryjob1);
            $payment = DB::connection('mysql3')->table('payments')->where('cust_id', '=', $customerid)->get();
            
            $getblockdates = DB::connection('mysql3')->table('projects')->where('cust_id', '=', $customerid)->where('exp_date_of_compl', '!=', '')->get();
             $listfiles = Storage::disk('s3')->files("/newcustomerzoneassets/customersprofileimage/".$customerid);
             
             if(count($listfiles) > 0){
                $profilepic = config('app.AWS_URL')."/".$listfiles[0];
            }
             else
             {
                $profilepic = config('app.AWS_URL')."/newcustomerzoneassets/img/dummy_male.png";
             }
           
             return view('newcustomerzone.paymenthistory')->with(['getcustomerdata'=> $getcustomerdata, 'payment' => $payment, 'profilepic' => $profilepic,'getblockdates' => $getblockdates]);
        }
        else{
            return redirect()->route('newcustomer_home');
        }
    }

    public function newprojectstatus(Request $request)
    {
        
         if ($request->session()->has('customersession')) {
            $encrypt = $request->session()->get('customersession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $customerid = $split[0];
            $getcustomerdata = DB::connection('mysql3')->table('customer')->where('id', '=', $customerid)->get();
            $getblockdates = DB::connection('mysql3')->table('projects')->where('cust_id', '=', $customerid)->where('exp_date_of_compl', '!=', '')->get();
            //$projects = DB::connection('mysql3')->table('projects')->where('cust_id', '=', $customerid)->groupBy('project_id')->get();
            $pwd_status = $this->is_cust_didnt_passwordchanged($customerid);
            if ($pwd_status == 0) {
                $request->session()->flash("error_msg", 'Please change the default password. Only if you Change the default password , other functionalities on this portal will work. This is done for security purposes. Please do not share your password with anyone');
                return redirect()->route('newcustomer_mydetails_passchange');
            }

            $projects = DB::connection('mysql3')->table('projects')
                ->select('project_id', 'pname','projectlink')->where('cust_id','=',$customerid)
                ->groupBy('project_id', 'pname','projectlink')
                ->get();
             
              $listfiles = Storage::disk('s3')->files("/newcustomerzoneassets/customersprofileimage/".$customerid);
             
             if(count($listfiles) > 0){
                $profilepic = config('app.AWS_URL')."/".$listfiles[0];
            }
             else
             {
                $profilepic = config('app.AWS_URL')."/newcustomerzoneassets/img/dummy_male.png";
             }
           
           
             return view('newcustomerzone.projectstatus')->with(['getcustomerdata'=> $getcustomerdata, 'projects' => $projects, 'profilepic' => $profilepic,'getblockdates' => $getblockdates]);
        }
        else{
            return redirect()->route('newcustomer_home');
        }

    }

    public function newinspectionsnag(Request $request)
    {
         if ($request->session()->has('customersession')) {
            $encrypt = $request->session()->get('customersession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $customerid = $split[0];
            $getcustomerdata = DB::connection('mysql3')->table('customer')->where('id', '=', $customerid)->get();
            $getblockdates = DB::connection('mysql3')->table('projects')->where('cust_id', '=', $customerid)->where('exp_date_of_compl', '!=', '')->get();
            $pwd_status = $this->is_cust_didnt_passwordchanged($customerid);
            if ($pwd_status == 0) {
                $request->session()->flash("error_msg", 'Please change the default password. Only if you Change the default password , other functionalities on this portal will work. This is done for security purposes. Please do not share your password with anyone');
                return redirect()->route('newcustomer_mydetails_passchange');
            }
            
            
          
             $projects = DB::connection('mysql3')->table('projects')->where('cust_id', '=', $customerid)->get();
            
             //dd($projects);
             
             if(!empty($projects)){
                 foreach($projects as $pro){
                     $project_unit_no = $pro->unit;
                     $project_projectid = $pro->project_id;
                 }
             }
            // dd($project_unit_no);



           if (count($projects) > 0) {
            foreach ($projects as $keypop => $valuepop) {
                
            
                 $getsnag = $this->get_inspection_snag($customerid, $valuepop->unit, $valuepop->project_id); 
                  
                //dd($getsnag['Data']);
                 if (count($getsnag['Data']) != 0) {
                     
                     
                     if (array_key_exists('0', $getsnag['Data'])) {
                         $main = $getsnag['Data'];
                     }
                     else
                     {
                        $main = array();
                        $main[] = $getsnag['Data'];
                     }

                     
                     foreach ($main as $key => $value) {
                        if($value['Unique_No'] == ''){
                            continue;
                        }
                        
                        
                         if ($value['Indicator'] == 'X') {
                             $status = 'CLOSED';
                         }
                         else{
                             $status = 'OPEN';
                         }
                    $dt = substr($value['Created_Date'],0,4).'-'.substr($value['Created_Date'],4,2).'-'.substr($value['Created_Date'],6,2);
                    $expecteddate = substr($value['Expected_Date'],0,4).'-'.substr($value['Expected_Date'],4,2).'-'.substr($value['Expected_Date'],6,2);
                    $tm = substr($value['Time'],0,2).':'.substr($value['Time'],2,2).':'.substr($value['Time'],4,2);

                    $newdtime = $dt.' '.$tm;

                   
                    
                    
                       $dd =  DB::connection('mysql3')->table('inspection_snag')->where('cust_id','=',$customerid)->where('project_id','=',$value['Plant_code'])
                         ->where('unit_no','=',$value['Unit_no'])
                         ->where('snag_desc','=',$value['Inspection_Snag'])
                         ->where('snag_created_date','=',$newdtime)
                         ->update(['uniqueno' => $value['Unique_No'], 'vgn_status' => $status, 'Expecteddateofcomp' => $expecteddate]);
                         
                         
                     }
                 }
                

            }
           }
           
             $snag = DB::connection('mysql3')->table('inspection_snag')->where('cust_id', '=', $customerid)->orderBy('snag_created_date', 'asc')->get();
             
              $listfiles = Storage::disk('s3')->files("/newcustomerzoneassets/customersprofileimage/".$customerid);
             
             if(count($listfiles) > 0){
                $profilepic = config('app.AWS_URL')."/".$listfiles[0];
            }
             else
             {
                $profilepic = config('app.AWS_URL')."/newcustomerzoneassets/img/dummy_male.png";
             }
             
             return view('newcustomerzone.inspectionsnag')->with(['getcustomerdata'=> $getcustomerdata, 'projects' => $projects, 'snag' => $snag, 'profilepic' => $profilepic,'getblockdates' => $getblockdates]);
        }
        else{
            return redirect()->route('newcustomer_home');
        }
    }

    public function newcreatesnag(Request $request)
    {
        if ($request->session()->has('customersession')) {
            $encrypt = $request->session()->get('customersession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $customerid = $split[0];
            $getcustomerdata = DB::connection('mysql3')->table('customer')->where('id', '=', $customerid)->get();

            $pwd_status = $this->is_cust_didnt_passwordchanged($customerid);
            if ($pwd_status == 0) {
                $request->session()->flash("error_msg", 'Please change the default password. Only if you Change the default password , other functionalities on this portal will work. This is done for security purposes. Please do not share your password with anyone');
                return redirect()->route('newcustomer_mydetails_passchange');
            }

            $projects = DB::connection('mysql3')->table('projects')->where('cust_id', '=', $customerid)->where(['milestone' => 'X','posession' => '','snagcreatedbyuser' => null])->get();
            //dd($projects);
            $getblockdates = DB::connection('mysql3')->table('projects')->where('cust_id', '=', $customerid)->where('exp_date_of_compl', '!=', '')->get();

            $getdlpdates = DB::connection('mysql3')->table('projects')->where('cust_id', '=', $customerid)->where('dlp_end_date', '!=', '')->get();
             if (count($getdlpdates) > 0) {
                $validtoraisecomplaints = 0;
                foreach ($getdlpdates as $key => $value) {
                    if (Carbon::now()->lte(Carbon::parse($value->dlp_end_date.' 23:59:00'))) {
                        $validtoraisecomplaints += 1;
                    }
                }
                 
             }
             else{
                $validtoraisecomplaints = 0;
             }
            
            

            if($validtoraisecomplaints == 0){
                return redirect()->route('newinspectionsnag');
            }
            
             $listfiles = Storage::disk('s3')->files("/newcustomerzoneassets/customersprofileimage/".$customerid);
             
             if(count($listfiles) > 0){
                $profilepic = config('app.AWS_URL')."/".$listfiles[0];
            }
             else
             {
                $profilepic = config('app.AWS_URL')."/newcustomerzoneassets/img/dummy_male.png";
             }
           
             return view('newcustomerzone.createsnag')->with(['getcustomerdata'=> $getcustomerdata, 'projects' => $projects, 'profilepic' => $profilepic,'getblockdates' => $getblockdates]);
        }
        else{
            return redirect()->route('newcustomer_home');
        }
    }

    public function newpostcreatesnag(Request $request)
    {
        //dd($request);
        if ($request->session()->has('customersession')) {
            $encrypt = $request->session()->get('customersession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $customerid = $split[0];
            $getcustomerdata = DB::connection('mysql3')->table('customer')->where('id', '=', $customerid)->get();
            $projects = DB::connection('mysql3')->table('projects')->where('cust_id', '=', $customerid)->get();
            
            
              $validate = $this->validate($request, [
            'projectid' => 'required',
			'unitno' => 'required'
			]);
            
            
           
           $check = 0;
           foreach($request['snag']['desc-snag'] as $k=>$v){
               
               if(!empty($v)){
               $check += 1;
               }
           }

           if ($check > 200) {
           	 $request->session()->flash("error_msg", "Snag cannot be more than 200!");
            return redirect()->route('newinspectionsnag');
           }

         
            $now = Carbon::now();
            if ($check == 0) {
                $request->session()->flash("error_msg", "Snag field cannot be empty. Atleast one snag is required!");
                return redirect()->back();
            }
            else{
                $date = Carbon::parse($now)->format('Y-m-d');
                $time = Carbon::parse($now)->format('H:i:s');
                
                $count = 0;
                foreach($request['snag']['desc-snag'] as $k=>$v){
               
               if(!empty($v)){
                   $rmdate = str_replace("-","",$date);
                   $rmtime = str_replace(":","",$time);
                   
                   
                $insertsnag = $this->insert_inspection_snag($v,'',$rmdate, $rmtime, $customerid, $request->unitno, $request->projectid, 0); 

                if($insertsnag['Status'] == 'Snag Created Sucessfully')
                {
                    $count += 1;
                DB::connection('mysql3')->table('inspection_snag')->insert(['cust_id' => $customerid,
            'project_id' => $request->projectid,
            'unit_no' => $request->unitno,
            'snag_desc' => $v,
            'uniqueno' => null,
            'snag_created_date' => $date.' '.$time,
            'vgn_status' => 'OPEN',
            'Expecteddateofcomp' => null ]);

                }

               }
            }

            DB::connection('mysql3')->table('projects')->where('cust_id','=',$customerid)->where('project_id','=',$request->projectid)->where('unit','=',$request->unitno)->update(['snagcreatedbyuser' => $count]);

            $request->session()->flash("suc_msg", "Snag Created Sucessfully");
            return redirect()->route('newinspectionsnag');

            }



            
           
            return view('newcustomerzone.createsnag')->with(['getcustomerdata'=> $getcustomerdata, 'projects' => $projects]);
        }
        else{
            return redirect()->route('newcustomer_home');
        }
    }
    
    public function newupdatesnag(Request $request, $plant, $unit)
    {
         if ($request->session()->has('customersession')) {
            $encrypt = $request->session()->get('customersession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $customerid = $split[0];
            $getcustomerdata = DB::connection('mysql3')->table('customer')->where('id', '=', $customerid)->get();
            $pwd_status = $this->is_cust_didnt_passwordchanged($customerid);
            if ($pwd_status == 0) {
                $request->session()->flash("error_msg", 'Please change the default password. Only if you Change the default password , other functionalities on this portal will work. This is done for security purposes. Please do not share your password with anyone');
                return redirect()->route('newcustomer_mydetails_passchange');
            }

            $projects = DB::connection('mysql3')->table('projects')->where('cust_id', '=', $customerid)->get();
            $getblockdates = DB::connection('mysql3')->table('projects')->where('cust_id', '=', $customerid)->where('exp_date_of_compl', '!=', '')->get();
            $snag = DB::connection('mysql3')->table('inspection_snag')->where('cust_id', '=', $customerid)->where('project_id', '=', $plant)->where('unit_no', '=', $unit)->orderBy('snag_created_date', 'asc')->get();

            

            if(count($snag) != 0){
                    $overallstatusforupdate = 0;
                foreach ($snag as $keynew => $valuenew) {
                    $date=date_create($valuenew->snag_created_date);
					date_add($date,date_interval_create_from_date_string("1 days"));
					$converteddate = date_format($date,"Y-m-d H:i:s");
    				$todaydatetime = date('Y-m-d H:i:s');
            		if ($todaydatetime > $converteddate) {
			    		$request->session()->flash("error_msg", "Snag Updation time limit exceeded!");
                        return redirect()->route('newinspectionsnag');
						}
                    break;
                }

                foreach ($snag as $keynew => $valuenew) {
                    if($valuenew->vgn_status == 'OPEN')
                    {
                        $overallstatusforupdate += 1;
                    }
                }

                if ($overallstatusforupdate == 0) {
                    $request->session()->flash("error_msg", "All Snags are closed for this Unit");
                    return redirect()->route('newinspectionsnag');
                }

                 $getsnag = $this->get_inspection_snag($customerid, $unit, $plant); 
                 
                 if (count($getsnag['Data']) != 0) {
                    
                    if (array_key_exists('0', $getsnag['Data'])) {
                         $main = $getsnag['Data'];
                     }
                     else
                     {
                        $main = array();
                        $main[] = $getsnag['Data'];
                     }

                     foreach ($main as $key => $value) {
                         if ($value['Indicator'] == 'X') {
                             $status = 'CLOSED';
                         }
                         else{
                             $status = 'OPEN';
                         }
                    $dt = substr($value['Created_Date'],0,4).'-'.substr($value['Created_Date'],4,2).'-'.substr($value['Created_Date'],6,2);
                    $expecteddate = substr($value['Expected_Date'],0,4).'-'.substr($value['Expected_Date'],4,2).'-'.substr($value['Expected_Date'],6,2);
                    $tm = substr($value['Time'],0,2).':'.substr($value['Time'],2,2).':'.substr($value['Time'],4,2);

                    $newdtime = $dt.' '.$tm;
                    
                    
                       $dd =  DB::connection('mysql3')->table('inspection_snag')->where('cust_id','=',$customerid)->where('project_id','=',$value['Plant_code'])
                         ->where('unit_no','=',$value['Unit_no'])
                         ->where('snag_desc','=',$value['Inspection_Snag'])
                         ->where('snag_created_date','=',$newdtime)
                         ->update(['uniqueno' => $value['Unique_No'], 'vgn_status' => $status, 'Expecteddateofcomp' => $expecteddate]);
                         
                         
                     }
                 }
            }
            else
            {
                $request->session()->flash("error_msg", "Invalid Snag details");
                return redirect()->route('newinspectionsnag');
            }
            $snagnew = DB::connection('mysql3')->table('inspection_snag')->where('cust_id', '=', $customerid)->where('project_id', '=', $plant)->where('unit_no', '=', $unit)->orderBy('snag_created_date', 'asc')->get();
           
             $listfiles = Storage::disk('s3')->files("/newcustomerzoneassets/customersprofileimage/".$customerid);
             
             if(count($listfiles) > 0){
                $profilepic = config('app.AWS_URL')."/".$listfiles[0];
            }
             else
             {
                $profilepic = config('app.AWS_URL')."/newcustomerzoneassets/img/dummy_male.png";
             }
             
             return view('newcustomerzone.updatesnag')->with(['getcustomerdata'=> $getcustomerdata, 'projects' => $projects, 'snag'=>$snagnew, 'profilepic' => $profilepic,'getblockdates' => $getblockdates]);
        }
        else{
            return redirect()->route('newcustomer_home');
        }
    }

    public function newpostupdatesnag(Request $request)
    {
         if ($request->session()->has('customersession')) {
            $encrypt = $request->session()->get('customersession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $customerid = $split[0];
            $getcustomerdata = DB::connection('mysql3')->table('customer')->where('id', '=', $customerid)->get();
            $projects = DB::connection('mysql3')->table('projects')->where('cust_id', '=', $customerid)->get();

           //dd($request['snag']); 
           $check =count($request['snag']['desc-snag']);
           if ($check != 0) {
               
               foreach ($request['snag']['desc-snag'] as $key => $value) {
                   
                   

                   $gettobeupdatedsnag = DB::connection('mysql3')->table('inspection_snag')
                   ->where('cust_id', '=', $customerid)
                   ->where('uniqueno', '=', $key)
                   ->where('vgn_status', '=','OPEN')
                   ->get();

                    if(count($gettobeupdatedsnag) > 0){
                        foreach ($gettobeupdatedsnag as $keypro => $valpro) {
                            
                            $splitdatetime = explode(" ",$valpro->snag_created_date);
                            
                            $rmdate = str_replace("-","",$splitdatetime[0]);
                            $rmtime = str_replace(":","",$splitdatetime[1]);
                            if ($valpro->vgn_status == 'OPEN') {
                                $indicator = '';
                            }
                            if ($valpro->vgn_status == 'CLOSED') {
                                $indicator = 'X';
                            }
                            
                            $insertsnag = $this->insert_inspection_snag($value,$indicator,$rmdate, $rmtime, $customerid, $valpro->unit_no, $valpro->project_id, $valpro->uniqueno);             
                            
                            if ($insertsnag['Status'] == 'Snag Created Sucessfully') {
                                DB::connection('mysql3')->table('inspection_snag')
                   ->where('cust_id', '=', $customerid)
                   ->where('uniqueno', '=', $key)
                   ->where('vgn_status', '=','OPEN')
                   ->update(['snag_desc' => $value]);
                            }
                            
                        }
                    }
                
               }

               $request->session()->flash("suc_msg", "Snags Updated Successfully!");
               return redirect()->route('newinspectionsnag');
           }
           else
           {
               $request->session()->flash("error_msg", "All Snags are closed for this Unit");
               return redirect()->route('newinspectionsnag');
           }
           
        }
        else{
            return redirect()->route('newcustomer_home');
        }
    }

    public function newreferfriend(Request $request)
    {
         if ($request->session()->has('customersession')) {
            $encrypt = $request->session()->get('customersession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $customerid = $split[0];
            $getcustomerdata = DB::connection('mysql3')->table('customer')->where('id', '=', $customerid)->get();
            $getblockdates = DB::connection('mysql3')->table('projects')->where('cust_id', '=', $customerid)->where('exp_date_of_compl', '!=', '')->get();
            $projects = DB::connection('mysql3')->table('projects')->where('cust_id', '=', $customerid)->get();

            $pwd_status = $this->is_cust_didnt_passwordchanged($customerid);
            if ($pwd_status == 0) {
                $request->session()->flash("error_msg", 'Please change the default password. Only if you Change the default password , other functionalities on this portal will work. This is done for security purposes. Please do not share your password with anyone');
                return redirect()->route('newcustomer_mydetails_passchange');
            }
            
           $getunsold = $this->getUnsold($customerid);
           $ongoingprojects = $getunsold['UNSOLD_PROJECTS'];
           
              $listfiles = Storage::disk('s3')->files("/newcustomerzoneassets/customersprofileimage/".$customerid);
             
             if(count($listfiles) > 0){
                $profilepic = config('app.AWS_URL')."/".$listfiles[0];
            }
             else
             {
                $profilepic = config('app.AWS_URL')."/newcustomerzoneassets/img/dummy_male.png";
             }
             
             return view('newcustomerzone.referfriend')->with(['getcustomerdata'=> $getcustomerdata, 'projects' => $projects, 'ongoingprojects' => $ongoingprojects, 'profilepic' => $profilepic,'getblockdates' => $getblockdates]);
        }
        else{
            return redirect()->route('newcustomer_home');
        }
    }

    public function newpostreferfriend(Request $request)
    {
        if ($request->session()->has('customersession')) {
            $encrypt = $request->session()->get('customersession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $customerid = $split[0];
            $getcustomerdata = DB::connection('mysql3')->table('customer')->where('id', '=', $customerid)->get();
            $projects = DB::connection('mysql3')->table('projects')->where('cust_id', '=', $customerid)->get();
            $getunsold = $this->getUnsold($customerid);
            $ongoingprojects = $getunsold['UNSOLD_PROJECTS'];

             $validate = $this->validate($request, [
            'name' => 'required',
			'mobile' => 'required|regex:/[0-9]{10}/',
            'email' => 'required|email',
            'intr' => 'required'
			]);
            
            $insertreferfriend = $this->sappostreferFriend($customerid,$request->name, $request->email, $request->mobile, $request->intr);
            //dd($insertreferfriend);
           
            if ($insertreferfriend['Save_Note'] == 'Referal Accepted Successfully') {
             $request->session()->flash("suc_msg", "Referal Accepted Successfully");
               return redirect()->route('newreferfriend');   
            }
            else{
                $request->session()->flash("error_msg", "Referal Not accepted try again!");
               return redirect()->route('newreferfriend');   
            }
             
                   
            
            return view('newcustomerzone.referfriend')->with(['getcustomerdata'=> $getcustomerdata, 'projects' => $projects, 'ongoingprojects' => $ongoingprojects]);
        }
        else{
            return redirect()->route('newcustomer_home');
        }
    }

    public function newlogout(Request $request)
    {
        if ($request->session()->has('customersession')) {
            //$encrypt = $request->session()->get('customersession');
            $request->session()->forget('customersession');
            $request->session()->forget('saleagree');
            return redirect()->route('newcustomer_home');
        }
        else{
            return redirect()->route('newcustomer_home');
        }
    }


    public function flattenParts($messageParts, $flattenedParts = array(), $prefix = '', $index = 1, $fullPrefix = true) 
	{
		if (is_array($messageParts) || is_object($messageParts))
		{
			foreach($messageParts as $part) {
				$flattenedParts[$prefix.$index] = $part;
				if(isset($part->parts)) {
				
					if($part->type == 2) {
						$flattenedParts = $this->flattenParts($part->parts, $flattenedParts, $prefix.$index.'.', 0, false);
					}
					elseif($fullPrefix) {
						$flattenedParts = $this->flattenParts($part->parts, $flattenedParts, $prefix.$index.'.');
					}
					else {
						$flattenedParts = $this->flattenParts($part->parts, $flattenedParts, $prefix);
					}
					unset($flattenedParts[$prefix.$index]->parts);
				}
				$index++;
			}
		}
		return $flattenedParts;		
	}
		
	public function getPart($connection, $messageNumber, $partNumber, $encoding) {
		
		$data = imap_fetchbody($connection, $messageNumber, $partNumber);
		
		switch($encoding) {
			case 0: return $data; // 7BIT
			case 1: return imap_8bit($data); // 8BIT
			case 2: return imap_base64(imap_binary($data)); // BINARY
			case 3: return base64_decode($data)/* imap_base64($text) */; // BASE64
			case 4: return quoted_printable_decode($data); // QUOTED_PRINTABLE
			case 5: return $data; // OTHER
		}
	}
	
	public function getFilenameFromPart($part) {
		
		$filename = '';
		
		if($part->ifdparameters) {
			foreach($part->dparameters as $object) {
				if(strtolower($object->attribute) == 'filename') {
					$filename = $object->value;
				}
			}
		}
		
		if(!$filename && $part->ifparameters) {
			foreach($part->parameters as $object) {
				if(strtolower($object->attribute) == 'name') {
					$filename = $object->value;
				}
			}
		}
		
		return $filename;
		
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
    
    public function sendmail($contents)
    {
    require_once('phpmailer/PHPMailerAutoload.php');
// $contents['toname']=>
// $contents['toemail']=>
// $contents['subject']=>
// $contents['content']=>
// $contents['html']=>
// $contents['att_url']=>
//Create a new PHPMailer instance
$mail = new \PHPMailer();
$return=array();
//Tell PHPMailer to use SMTP
$mail->isSMTP();

//Enable SMTP debugging
// 0 = off (for production use)
// 1 = client messages
// 2 = client and server messages
$mail->SMTPDebug = 0;

//Ask for HTML-friendly debug output
$mail->Debugoutput = 'html';

//Set the hostname of the mail server
// $mail->Host = 'smtp.gmail.com';
$mail->Host = 'mail.vgn.in';
// use
// $mail->Host = gethostbyname('smtp.gmail.com');
// if your network does not support SMTP over IPv6

//Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
$mail->Port = 587;
// $mail->Port = 25;

//Set the encryption system to use - ssl (deprecated) or tls
//$mail->SMTPSecure = 'tls';

//Whether to use SMTP authentication
$mail->SMTPAuth = true;

//Username to use for SMTP authentication - use full email address for gmail
$mail->Username = "customerzone3";

//Password to use for SMTP authentication
$mail->Password = "Vgn@321";

//Set who the message is to be sent from
$mail->setFrom('customerzone3@vgn.in', 'VGN Customer Zone');

//Set an alternative reply-to address
$mail->addReplyTo('no-reply@vgn.in', 'VGN Customer Zone');

//Set who the message is to be sent to
$mail->addAddress($contents['toemail'], $contents['toname']);

//Set the subject line
$mail->Subject = $contents['subject'];

//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
// $mail->msgHTML(file_get_contents($contents['html']), dirname(__FILE__));
$mail->Body=$contents['content'];

//Replace the plain text body with one created manually
$mail->AltBody = $contents['content'];

//Attach an image file
if(!empty($contents['att_url']))
$mail->addAttachment($contents['att_url']);

//send the message, check for errors
if (!$mail->send()) {
// if (0) {
    $return['code']= 500;
    $return['msg']= "Mailer Error: " . $mail->ErrorInfo."";
} else {
    $return['code']= 200;
    $return['msg']= "Mail Sent to your Registered EMail!";
}
return $return;
}

    public function newforgotpwd()
    {
    return view('newcustomerzone.forgotpwd');
}

    
    public function newpostforgotpwd(Request $request)
    {
    $validate = $this->validate($request, [
            'forgotusername' => 'required'
			]);


 if (strpos($request->forgotusername, '@') !== false) {
            $loginmode = 'loginmode_emailid';
        }
        elseif (ctype_digit($request->forgotusername)) {

            if (strlen($request->forgotusername) == 10) {
                $loginmode = 'loginmode_mobileno';
            }
            elseif((strlen($request->forgotusername) >= 3)&&(strlen($request->forgotusername) < 10)){
                $loginmode = 'loginmode_customerid';
            }
            else{
                $request->session()->flash("error_msg", "Sorry! Enter a valid CustomerId or Mobile Number");
                return redirect()->back()->withInput();
            }
                
        }
        else{
            
                $request->session()->flash("error_msg", "Sorry! Enter a valid Username");
                return redirect()->back()->withInput();
        }

        
        if ($loginmode == 'loginmode_customerid') {
            if (!ctype_digit($request->forgotusername)) {
                
                $request->session()->flash("error_msg", "Sorry! Enter a valid Customer Id");
                return redirect()->back()->withInput();
            }
            $check = DB::connection('mysql3')->table('customer')->where(['id' => $request->forgotusername])->get();
        }

        elseif ($loginmode == 'loginmode_emailid') {

            if (!filter_var($request->forgotusername, FILTER_VALIDATE_EMAIL)) {
            $request->session()->flash("error_msg", "Sorry! Enter a valid Email Id");
                return redirect()->back()->withInput();
                }
            $check = DB::connection('mysql3')->table('customer')->where(['email' => $request->forgotusername ])->get();
            
        }
        
        elseif ($loginmode == 'loginmode_mobileno') {

            if (!preg_match('/^[0-9]{10}+$/', $request->forgotusername)) {
                $request->session()->flash("error_msg", "Sorry! Enter a valid Mobile Number");
                return redirect()->back()->withInput();
                }
            $check = DB::connection('mysql3')->table('customer')->where(['mobile' => $request->forgotusername ])->get();
        }
        else{
                $request->session()->flash("error_msg", "Sorry! Enter a valid Username!");
                return redirect()->back()->withInput();
        }


if(count($check) == 1){
    foreach ($check as $newkey => $newvalue) {
        
        $request->forgotusername = $newvalue->id;
    }
}
else{
                $request->session()->flash("error_msg", "Sorry! <b>Username Does not exist!</b>!");
                return redirect()->back()->withInput();
}


    $getcustomerdatacount = DB::connection('mysql3')->table('customer')->where('id', '=', $request->forgotusername)->count();

        if ($getcustomerdatacount != 0) {
            $getcustomerdata = DB::connection('mysql3')->table('customer')->where('id', '=', $request->forgotusername)->get();
            $getresetdata = DB::connection('mysql3')->table('resetpwd')->where('customerid', '=', $request->forgotusername)->get();

            if (count($getresetdata) != 0) {
                
            
            foreach ($getresetdata as $key => $value) {
                $customerid = $value->customerid;
                $pwd_token = $value->token;
                $expiredate = $value->expiredate;
            }

            $now = Carbon::now();
           
            $date1=date_create($now);
			date_add($date1,date_interval_create_from_date_string("1 days"));
			$addedexpiredate = date_format($date1,"Y-m-d H:i:s");
            //dd($addedexpiredate);

            $str = date('YmdHis').'-42'.rand(0,189999);
            $shuffled = str_shuffle($str);
            $token = $shuffled;
            foreach ($getcustomerdata as $keycustomer => $customervalue) {
                    $name = $customervalue->name;
                    $email = $customervalue->email;
                    $mobile = $customervalue->mobile;
                }
            
            if ($now > $expiredate) {
//dd($addedexpiredate);
                $updateresetpwd = DB::connection('mysql3')->table('resetpwd')->where('customerid','=',$customerid)->update(['token'=>$token,'expiredate'=>$addedexpiredate]);
                
                $link="http://vgn.in/customerzone/resetpassword/".$customerid."/".$token;
				$newmail=array();
				$newmail['toname']=$name;
				$newmail['toemail']=$email;
				$newmail['subject']="VGN Customer Zone - Reset Password Link!";
				$newmail['content']='<div style=" margin: 0 auto;  background-color: #eef5ff;padding: 2% 4%;font-size: 14px;"><div style="text-align: center;"><img src="http://www.vgn.in/images/custom/vgn-logo.png" alt="vgn-logo.jpg"></div>Dear '.$name.',<br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Please <a href="'.$link.'">Click Here</a> to reset your password.<br><br>Thanks,<br>VGN<br><div style="    text-align: center;    font-size: 88%;    color: rgb(124, 124, 124);">For Any details : <a href="http://www.vgn.in">www.vgn.in</a><br><span style="    color: rgb(23, 79, 163);
				font-weight: bold;">VGN Property Developers Private Limited</span>&nbsp;- No.153, Wallace Garden, 2nd Street, Nungambakkam, Chennai-600006.<br>Call Us: +91 44 4343 9900</div></div>';
				$newmail['html']="user-detail-contents.html";
				//$newmail['att_url']="images/logo.jpg";
                if(ctype_digit($mobile)){
                    if (strlen($mobile) == 10) {
                        
                //$smscontent='Dear '.$name.',<br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Please <a href="'.$link.'">Click Here</a> to reset your password.<br><br>Thanks,<br>VGN<br><div style="    text-align: center;    font-size: 88%;    color: rgb(124, 124, 124);">For Any details : <a href="http://www.vgn.in">www.vgn.in</a><br><span style="    color: rgb(23, 79, 163);				font-weight: bold;">VGN Property Developers Private Limited</span>&nbsp;- No.153, Wallace Garden, 2nd Street, Nungambakkam, Chennai-600006.<br>Call Us: +91 44 4343 9900</div>';
				
                //$smsurl = "http://www.adithya.me/adithya/Api/?username=vgn&password=vgn@123&senderid=VGNALT&message=$smscontent&msgtype=normal&mobileno=8754404619";
                $smscontent = 'Dear Customer, Click the below link to reset your password '.$link; 
                
               $sms_status = $this->smscurl($smscontent, $mobile);               
                DB::connection('mysql3')->table('sms_sent_data')->insert(['customerid' => $customerid,'sentdatetime' => $now]);
                    }
                }

				$mailstatus = $this->sendmail($newmail);
                $request->session()->flash("suc_msg", "Dear Customer your password has been reset and sent successfully to your registered email and phone!");
				//$return="<suc>Password reset link was sent to your registered email address successfully! <debug>" . $customerid."</debug></suc><br/>".$mailstatus['msg'];
				return redirect()->route('newcustomer_home');
                
            }
            else{
                $link="http://vgn.in/customerzone/resetpassword/".$customerid."/".$pwd_token;
				$newmail=array();
				$newmail['toname']=$name;
				$newmail['toemail']=$email;
				$newmail['subject']="VGN Customer Zone - Reset Password Link!";
				$newmail['content']='<div style=" margin: 0 auto;  background-color: #eef5ff;padding: 2% 4%;font-size: 14px;"><div style="text-align: center;"><img src="http://www.vgn.in/images/custom/vgn-logo.png" alt="vgn-logo.jpg"></div>Dear '.$name.',<br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Please <a href="'.$link.'">Click Here</a> to reset your password.<br><br>Thanks,<br>VGN<br><div style="    text-align: center;    font-size: 88%;    color: rgb(124, 124, 124);">For Any details : <a href="http://www.vgn.in">www.vgn.in</a><br><span style="    color: rgb(23, 79, 163);
				font-weight: bold;">VGN Property Developers Private Limited</span>&nbsp;- No.153, Wallace Garden, 2nd Street, Nungambakkam, Chennai-600006.<br>Call Us: +91 44 4343 9900</div></div>';
				$newmail['html']="user-detail-contents.html";
				//$newmail['att_url']="images/logo.jpg";

                  if(ctype_digit($mobile)){
                    if (strlen($mobile) == 10) {
                        
                //$smscontent='Dear '.$name.',<br>Please <a href="'.$link.'">Click Here</a> to reset your password.<br><br>Thanks,<br>VGN<br><div style="    text-align: center;    font-size: 88%;    color: rgb(124, 124, 124);">For Any details : <a href="http://www.vgn.in">www.vgn.in</a><br><span style="    color: rgb(23, 79, 163);				font-weight: bold;">VGN Property Developers Private Limited</span>&nbsp;- No.153, Wallace Garden, 2nd Street, Nungambakkam, Chennai-600006.<br>Call Us: +91 44 4343 9900</div>';

                $smscontent = 'Dear Customer, Click the below link to reset your password '.$link;  
				
                
                $sms_status = $this->smscurl($smscontent, $mobile);
                DB::connection('mysql3')->table('sms_sent_data')->insert(['customerid' => $customerid,'sentdatetime' => $now]);
                    }
                }
				$mailstatus = $this->sendmail($newmail);
                $request->session()->flash("suc_msg", "Dear Customer your password has been reset and sent successfully to your registered email and phone!");
				//$return="<suc>Password reset link was sent to your registered email address successfully! <debug>" . $customerid."</debug></suc><br/>".$mailstatus['msg'];
				return redirect()->route('newcustomer_home');
            }

            
            $request->session()->flash("suc_msg", "Dear Customer your password has been reset and sent successfully to your registered email and phone!");
				//$return="<suc>Password reset link was sent to your registered email address successfully! <debug>" . $customerid."</debug></suc><br/>".$mailstatus['msg'];
				return redirect()->route('newcustomer_home');

            }
            else{
                
                
                $str = date('YmdHis').'-19'.rand(0,189999);
                $shuffled = str_shuffle($str);
                $token = $shuffled;
                $customerid = $request->forgotusername;
                $now = Carbon::now();
                $date=date_create($now);
				date_add($date,date_interval_create_from_date_string("1 days"));
				$expiredate = date_format($date,"Y-m-d H:i:s");
                
                $insertresetpwd = DB::connection('mysql3')->table('resetpwd')->insert(['customerid' => $customerid, 'token'=>$token,'expiredate'=>$expiredate]);
                //$last_id = mysqli_insert_id($conn);
                foreach ($getcustomerdata as $keycustomer => $customervalue) {
                    $name = $customervalue->name;
                    $email = $customervalue->email;
                    $mobile = $customervalue->mobile;
                }
                $link="http://www.vgn.in/customerzone/resetpassword/".$customerid."/".$token;
				$newmail=array();
				$newmail['toname']=$name;
				$newmail['toemail']=$email;
				$newmail['subject']="VGN Customer Zone - Reset Password Link!";
				$newmail['content']='<div style=" margin: 0 auto;  background-color: #eef5ff;padding: 2% 4%;font-size: 14px;"><div style="text-align: center;"><img src="http://www.vgn.in/images/custom/vgn-logo.png" alt="vgn-logo.jpg"></div>Dear '.$name.',<br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Please <a href="'.$link.'">Click Here</a> to reset your password.<br><br>Thanks,<br>VGN<br><div style="    text-align: center;    font-size: 88%;    color: rgb(124, 124, 124);">For Any details : <a href="http://www.vgn.in">www.vgn.in</a><br><span style="    color: rgb(23, 79, 163);
				font-weight: bold;">VGN Property Developers Private Limited</span>&nbsp;- No.153, Wallace Garden, 2nd Street, Nungambakkam, Chennai-600006.<br>Call Us: +91 44 4343 9900</div></div>';
				$newmail['html']="user-detail-contents.html";
				//$newmail['att_url']="images/logo.jpg";
                 if(ctype_digit($mobile)){
                    if (strlen($mobile) == 10) {
                        
                //$smscontent='Dear '.$name.',<br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Please <a href="'.$link.'">Click Here</a> to reset your password.<br><br>Thanks,<br>VGN<br><div style="    text-align: center;    font-size: 88%;    color: rgb(124, 124, 124);">For Any details : <a href="http://www.vgn.in">www.vgn.in</a><br><span style="    color: rgb(23, 79, 163);				font-weight: bold;">VGN Property Developers Private Limited</span>&nbsp;- No.153, Wallace Garden, 2nd Street, Nungambakkam, Chennai-600006.<br>Call Us: +91 44 4343 9900</div>';
				$smscontent = 'Dear Customer, Click the below link to reset your password '.$link; 
                $sms_status = $this->smscurl($smscontent, $mobile);
                DB::connection('mysql3')->table('sms_sent_data')->insert(['customerid' => $customerid,'sentdatetime' => $now]);
                    }
                }
				$mailstatus = $this->sendmail($newmail);
                $request->session()->flash("suc_msg", "Dear Customer your password has been reset and sent successfully to your registered email and phone!");
				//$return="<suc>Password reset link was sent to your registered email address successfully! <debug>" . $customerid."</debug></suc><br/>".$mailstatus['msg'];
				return redirect()->route('newcustomer_home');
            }
        }
        else{
            $request->session()->flash("error_msg", "Invalid or Blocked Username!");
            return redirect()->route('newforgotpassword');
        }
    //dd($getcustomerdata);

}

    public function newresetpassword(Request $request, $id, $key)
    {
    $customerid = $id;
    $token = $key;

    if(($customerid != null)&&($token != null))
    {
        $checkrestdata = DB::connection('mysql3')->table('resetpwd')->where('customerid', '=', $customerid)->where('token', '=', $token)->count();
    
        if($checkrestdata == 1){

            $getrestdata = DB::connection('mysql3')->table('resetpwd')->where('customerid', '=', $customerid)->where('token', '=', $token)->get();
            foreach ($getrestdata as $key => $value) {
                $expiredate = $value->expiredate;
            }
            
            $now = Carbon::now();
            if ($now > $expiredate) {
                $request->session()->flash("error_msg", "Password reset time limit expired!");
                return redirect()->route('newcustomer_home');
            }
            else{
                return view('newcustomerzone.resetpassword')->with(['customerid' => $customerid, 'token'=> $token]);
            }
        }
        else{
            return redirect()->route('newcustomer_home');
        }
    }
    else{
            return redirect()->route('newcustomer_home');
    }
}

    public function newpostresetpassword(Request $request, $id, $key)
    {
     $validate = $this->validate($request, [
			'newpass' => 'required|min:6|max:12',
            'retypepass' => 'required|same:newpass'
			]);

    $customerid = $id;
    $token = $key;
    

    if(($customerid != null)&&($token != null))
    {
        $checkrestdata = DB::connection('mysql3')->table('resetpwd')->where('customerid', '=', $customerid)->where('token', '=', $token)->count();

        if($checkrestdata == 1){

            $getrestdata = DB::connection('mysql3')->table('resetpwd')->where('customerid', '=', $customerid)->where('token', '=', $token)->get();
            foreach ($getrestdata as $key => $value) {
                $expiredate = $value->expiredate;
            }
            $now = Carbon::now();
            if ($now > $expiredate) {
                $request->session()->flash("error_msg", "Password reset time limit expired!");
                return redirect()->route('newcustomer_home');
            }
            else{

                $checkincustomertable = DB::connection('mysql3')->table('customer')->where('id', '=', $customerid)->count();
                
                if ($checkincustomertable == 1) {

                    DB::connection('mysql3')->table('customer')->where('id', '=', $customerid)->update(['password' => $request->newpass]);
                    DB::connection('mysql3')->table('resetpwd')->where('customerid', '=', $customerid)->delete();
                    $request->session()->flash("suc_msg", "Password reset done Successfully!");
                return redirect()->route('newcustomer_home');

                }
                //return redirect()->route('customer_home');
            }
        }
        else{
            return redirect()->route('newcustomer_home');
        }
    }
    else{
            return redirect()->route('newcustomer_home');
    }


}
    
    public function newcommunication(Request $request, $size = null, $page = null) {
      
                        if ($request->session()->has('customersession')) {
            $encrypt = $request->session()->get('customersession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $customerid = $split[0];

            $pwd_status = $this->is_cust_didnt_passwordchanged($customerid);
            if ($pwd_status == 0) {
                $request->session()->flash("error_msg", 'Please change the default password. Only if you Change the default password , other functionalities on this portal will work. This is done for security purposes. Please do not share your password with anyone');
                return redirect()->route('newcustomer_mydetails_passchange');
            }
            
              $getcustomerdata = DB::connection('mysql3')->table('customer')->where('id', '=', $customerid)->get();       
              $getblockdates = DB::connection('mysql3')->table('projects')->where('cust_id', '=', $customerid)->where('exp_date_of_compl', '!=', '')->get();
             
             foreach ($getcustomerdata as $value) {
                 $response = [
                'customerno' => $value->id,
                'name' => $value->name,
                'customerexecutive' => $value->customer_executive,
                'customermanager' => $value->customer_manager,
                             
            ];
             }


                $projects = DB::connection('mysql3')->table('projects')->where('cust_id', '=', $customerid)->get();

             $getpwdforsap = DB::connection('mysql3')->table('sapcustomer')->where('customerid', '=', $customerid)->get();
                     foreach ($getpwdforsap as $sapkey => $sapvalue) {
                         $sapcustomerid = $sapvalue->customerid;
                         $sapcustomerpassword = Crypt::decrypt($sapvalue->password);
                     }

         //dd($sapcustomerpassword);            
         if ($sapcustomerpassword != '') {
             
           
        //require_once('phpmailer/PHPMailerAutoload.php');
	require 'phpmailer_master/src/Exception.php';
	require 'phpmailer_master/src/PHPMailer.php';
	require 'phpmailer_master/src/SMTP.php';
        
        
        $pg_s=(!empty($size))?$size:10;
	    $pg_no=(!empty($page))?$page:1;
        $mailarray = array('pages' => [], 'mails' => []);

		ini_set('xdebug.var_display_max_depth', 5);
		ini_set('xdebug.var_display_max_children', 256);
		ini_set('xdebug.var_display_max_data', 1024);
		// $server = '{mail.vgn.in:143/notls}INBOX';61.8.145.222
		$server = '{client.vgn.in:143/notls}INBOX';
		$login = $customerid.'@client.vgn.in';
		$password = $sapcustomerpassword;
        $pagehtml = '';

		if($connection = @imap_open($server, $login, $password))
		{
		//dd($connection);
		$message_count = imap_num_msg($connection);
		$pagesize=$pg_s;
		$pages=max(($message_count%$pagesize==0)?($message_count/$pagesize):(int)($message_count/$pagesize)+1,1);
		$pagenum=$pg_no;
		$n=min($pagesize,$message_count-($pagenum*$pagesize)+$pagesize);
		
		$pagehtml .="<div><ul class='pagination'>";
		for($i=1;$i<=$pages;$i++)
		{
		$pagehtml.="<li class='paginate_button";		
		$pagehtml.=($pagenum==$i)?" active":"";
		//$pagehtml.="'><a href='?page=".$i."&size=".$pg_s."'>".$i."</a></li>";
        $pagehtml.="'><a href='/customerzone/communication/".$pg_s."/".$i."'>".$i."</a></li>";
        $mailarray['pages'][] =['pageno'=>$i,'link'=>"http://vgn.in/customerzone/communication/".$pg_s."/".$i];
		}
		$pagehtml.="</ul></div>";
		

        
        $kk = 0;
		//echo '<div  class="panel-group" id="accordion">';
		for ($m = 1; $m <= $n; ++$m){
			$messageNumber=$message_count-$m+1-($pagenum*$pagesize)+$pagesize;
			// if($debug)echo $messageNumber;
			$att=0;
			$structure = imap_fetchstructure($connection, $messageNumber);
			// if($debug)echo "<br>STRUCTURE<br>";
			// if($debug)print_r($structure);
			$header = imap_header($connection, $messageNumber);
			$parts = (isset($structure->parts) ? $structure->parts : array(0=>$structure));
			if(isset($debug)) {$pagehtml .= "<br>PARTS<br>";}
			if(isset($debug)){$pagehtml .= count($parts);}
			$flattenedParts = array();
			if(count($parts))
			{
                
			$flattenedParts = $this->flattenParts($parts);
				//flattenParts($parts);
                
			}
			else{
				if(isset($parts)) $flattenedParts = self::flattenParts($parts);
				else $flattenedParts[1] = $structure;
				}
			$pagehtml .= '<div class="panel"><div class="panel-heading">';
			
			// echo '<div class="tl-row"><div class="">';
			$pagehtml .= '<h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#collapse'.$messageNumber.'"><span style="font-size:14px;">'.date('d-m-Y',$header->udate).'</span>&nbsp;&nbsp;-&nbsp;&nbsp;'.imap_utf8($header->subject).'</a></h4>';
			//echo '<div class="panel-subtitle disabled">'.date('d-m-Y g:i A',$header->udate).'</div></div>';
			$pagehtml .= '</div>';
			$pagehtml .= '<div  id="collapse'.$messageNumber.'" class="panel-collapse collapse"><div class="panel-body">';
			
			foreach($flattenedParts as $partNumber => $part) {
				
			if(isset($debug)){ $pagehtml .= "TYPE - SUB TYPE - ENCODING<br>";}
			if(isset($debug)){ $pagehtml .= $part->type."-".$part->subtype."-".$part->encoding;	}
			if(isset($debug)){ $pagehtml .= "<br>";	}
			
				switch($part->type) {
					
					case 0:
					// the HTML or plain text part of the email
					$message = $this->getPart($connection, $messageNumber, $partNumber, $part->encoding);
 
					//if($part->subtype=='HTML'&&$debug)
					if($part->subtype=='HTML')
                   
					$pagehtml .= "<div class='html' >".nl2br($message)."</div>";
					else if($part->subtype=='PLAIN')
					$pagehtml .= "<div class='plain' >".nl2br($message)."</div>";
					// now do something with the message, e.g. render it
                    $mailarray['mails'][$kk] = [
                            'pagenoactive' => $pg_no,
                'subject' => date('d-m-Y',$header->udate).' - '.imap_utf8($header->subject),
                'body' => nl2br($message),
                'attachment'=> null,
                'attachmentfilename' => null
            ];
					break;
					
					case 1:
					// multi-part headers, can ignore
					break;
					case 2:
					// attached message headers, can ignore
					break;
					
					case 3: // application
					case 4: // audio
					case 5: // image
					case 6: // video
					case 7: // other
					$filename = $this->getFilenameFromPart($part);
					if($filename) {
						// it's an attachment
						++$att;
						$attachment = $this->getPart($connection, $messageNumber, $partNumber, $part->encoding);
						// now do something with the attachment, e.g. save it somewhere
						$cid="";
						if(isset($customerid))$cid=$customerid;
						$name = 'attachments/'.$cid.'-'.$messageNumber.'-'.$partNumber.'-'.$filename;
						//Storage::putFileAs('/attachments', $attachment, $cid.'-'.$messageNumber.'-'.$partNumber.'-'.$filename);
						file_put_contents($name, $attachment);
						// echo '<div class="float-left padding10"><h6>Attachment '.$att.'</h6><a href="'.$name . '" target="_blank" >'.$filename.'</a></div>';
                        $newname = "/attachments/".$cid.'-'.$messageNumber.'-'.$partNumber.'-'.$filename;
                       $mailarray['mails'][$kk] = [
                            'pagenoactive' => $pg_no,
                'subject' => date('d-m-Y',$header->udate).' - '.imap_utf8($header->subject),
                'body' => nl2br($message),
                'attachment'=> $newname,
                'attachmentfilename' => $filename
            ];
						$pagehtml .= '<div class="float-left padding10"><i class="glyph-icon icon-linecons-attach"></i> <a href="'.$newname . '" target="_blank" >'.$filename.'</a></div>';
					}
					else {
						/*$mailarray['mails'][] = [
                            'pagenoactive' => $pg_no,
                'subject' => date('d-m-Y',$header->udate).' - '.imap_utf8($header->subject),
                'body' => nl2br($message),
                'attachment' => null,
                'attachmentfilename' => null
            ];*/
					}
					break;
					
				}
                
				
			}
			
			// echo '<a href="#" class="expand"></a></div>';
			$pagehtml .= '</div></div></div>';
            
            $kk++;
		}
		$pagehtml .= '</div>';
		
		imap_close($connection);
        //dd($mailarray);
            
        $listfiles = Storage::disk('s3')->files("/newcustomerzoneassets/customersprofileimage/".$customerid);
             
             if(count($listfiles) > 0){
                $profilepic = config('app.AWS_URL')."/".$listfiles[0];
            }
             else
             {
                $profilepic = config('app.AWS_URL')."/newcustomerzoneassets/img/dummy_male.png";
             }
            
             return view('newcustomerzone.communication')->with(['getcustomerdata'=> $getcustomerdata, 'mailarray' => $mailarray, 'profilepic' => $profilepic,'getblockdates' => $getblockdates]);
            

	}
	}
                        
           

    }
    else{
                            return redirect()->route('newcustomer_home');
                        }
    
}

    

    public function ivrsfeedback()
    {
    if (!empty(isset($_GET['status'])) && !empty(isset($_GET['mobile'])) && !empty(isset($_GET['created'])) && !empty(isset($_GET['apikey'])) ) {
        
        $status = $_GET['status'];
        $mobile = $_GET['mobile'];
        $created = $_GET['created'];
        $apikey = $_GET['apikey'];
        
        if ($apikey == '6527200804') {
            
        
        DB::connection('mysql3')->table('feedbacktoivrs')->insert(['mobile' => $mobile, 'status' => $status,
        'created_datetime' => $created
        ]);

        return 'Success';
        }
        else
        {
            return 'Key Does not match';
        }

    }
}
    
    public function neweditphoto(Request $request){
        
         if ($request->session()->has('customersession')) {
            $encrypt = $request->session()->get('customersession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $customerid = $split[0];
            $getcustomerdata = DB::connection('mysql3')->table('customer')->where('id', '=', $customerid)->get();
            $getblockdates = DB::connection('mysql3')->table('projects')->where('cust_id', '=', $customerid)->where('exp_date_of_compl', '!=', '')->get();
            
            $pwd_status = $this->is_cust_didnt_passwordchanged($customerid);
            if ($pwd_status == 0) {
                $request->session()->flash("error_msg", 'Please change the default password. Only if you Change the default password , other functionalities on this portal will work. This is done for security purposes. Please do not share your password with anyone');
                return redirect()->route('newcustomer_mydetails_passchange');
            }
             
            $listfiles = Storage::disk('s3')->files("/newcustomerzoneassets/customersprofileimage/".$customerid);

             
             if(count($listfiles) > 0){
                $profilepic = config('app.AWS_URL')."/".$listfiles[0];
            }
             else
             {
                $profilepic = config('app.AWS_URL')."/newcustomerzoneassets/img/dummy_male.png";
             }
            //$exists = Storage::disk('local')->has("customersprofileimage/$customerid.jpg");
            
            return view('newcustomerzone.editphoto')->with(['getcustomerdata'=> $getcustomerdata, 'profilepic' => $profilepic,'getblockdates' => $getblockdates]);
             
         }else
         {
             return redirect()->route('newcustomer_home');
         }
        
    }
    
    public function newposteditphoto(Request $request){
        
         if ($request->session()->has('customersession')) {
            $encrypt = $request->session()->get('customersession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $customerid = $split[0];
            $getcustomerdata = DB::connection('mysql3')->table('customer')->where('id', '=', $customerid)->get();
             
            $validate = $this->validate($request, [
            'photo' => 'required|image|min:20|max:5000',
			]);
             
             $file = $request->file('photo');
             $filename = $file->getClientOriginalName();
             $destinationpath = "/newcustomerzoneassets/customersprofileimage/".$customerid;
             $ext = pathinfo($filename, PATHINFO_EXTENSION);
             
             
            $listfiles = Storage::disk('s3')->files("/newcustomerzoneassets/customersprofileimage/".$customerid);
            if(count($listfiles) > 0){
                Storage::disk('s3')->deleteDirectory("/newcustomerzoneassets/customersprofileimage/".$customerid);
            }
             $uploadeddatetime = date('Ymd');
             $randomno = rand(1, 1000000);
             $newname = bcrypt($uploadeddatetime.$randomno.'VGNcustomer');
             $uploaded = Storage::disk('s3')->putFileAs($destinationpath, $request->file('photo'), $newname.'.'.$ext);
             
             if($uploaded){
                 $request->session()->flash("suc_msg", "successfully Profile picture Uploaded!");
                return redirect()->back();     
             }
             else
             {
                 $request->session()->flash("error_msg", "Profile picture not uploaded. Try Again!");
                return redirect()->back();     
             }
             
             
             
         }else
         {
             return redirect()->route('newcustomer_home');
         }
        
    }

    public function mybankdetails(Request $request)
    {
        
        if ($request->session()->has('customersession')) {
            $encrypt = $request->session()->get('customersession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $customerid = $split[0];
            $getcustomerdata = DB::connection('mysql3')->table('customer')->where('id', '=', $customerid)->get();
            $getblockdates = DB::connection('mysql3')->table('projects')->where('cust_id', '=', $customerid)->where('exp_date_of_compl', '!=', '')->get();

            $pwd_status = $this->is_cust_didnt_passwordchanged($customerid);
            if ($pwd_status == 0) {
                $request->session()->flash("error_msg", 'Please change the default password. Only if you Change the default password , other functionalities on this portal will work. This is done for security purposes. Please do not share your password with anyone');
                return redirect()->route('newcustomer_mydetails_passchange');
            }
            
             $listfiles = Storage::disk('s3')->files("/newcustomerzoneassets/customersprofileimage/".$customerid);
             
             if(count($listfiles) > 0){
                $profilepic = config('app.AWS_URL')."/".$listfiles[0];
            }
             else
             {
                $profilepic = config('app.AWS_URL')."/newcustomerzoneassets/img/dummy_male.png";
             }
            
             return view('newcustomerzone.mybankdetails')->with(['getcustomerdata'=>$getcustomerdata, 'profilepic' => $profilepic,'getblockdates' => $getblockdates]);
        }
        else{
            return redirect()->route('newcustomer_home');
        }
            
        
    }

    public function editbankdetails(Request $request){

        if ($request->session()->has('customersession')) {
            $encrypt = $request->session()->get('customersession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $customerid = $split[0];
            $getcustomerdata = DB::connection('mysql3')->table('customer')->where('id', '=', $customerid)->get();
            $getblockdates = DB::connection('mysql3')->table('projects')->where('cust_id', '=', $customerid)->where('exp_date_of_compl', '!=', '')->get();

            $pwd_status = $this->is_cust_didnt_passwordchanged($customerid);
            if ($pwd_status == 0) {
               $request->session()->flash("error_msg", 'Please change the default password. Only if you Change the default password , other functionalities on this portal will work. This is done for security purposes. Please do not share your password with anyone');
                return redirect()->route('newcustomer_mydetails_passchange');
            }
            
             $listfiles = Storage::disk('s3')->files("/newcustomerzoneassets/customersprofileimage/".$customerid);
             
             if(count($listfiles) > 0){
                $profilepic = config('app.AWS_URL')."/".$listfiles[0];
            }
             else
             {
                $profilepic = config('app.AWS_URL')."/newcustomerzoneassets/img/dummy_male.png";
             }
            
             return view('newcustomerzone.editbankdetails')->with(['getcustomerdata'=>$getcustomerdata, 'profilepic' => $profilepic,'getblockdates' => $getblockdates]);
        }
        else{
            return redirect()->route('newcustomer_home');
        }
    }

     public function posteditbankdetails(Request $request){

        if ($request->session()->has('customersession')) {
            $encrypt = $request->session()->get('customersession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $customerid = $split[0];
            $getcustomerdata = DB::connection('mysql3')->table('customer')->where('id', '=', $customerid)->get();

                        
             $validate = $this->validate($request, [
            'bank_account_no' => 'required|regex:/(^[0-9]+$)+/|min:6|max:26',
            'retype_bank_account_no' => 'required|same:bank_account_no',
            'bank_name' => 'required|regex:/^[\pL\s]+$/u|min:3|max:40',
            'ifsc_code' => 'required|max:11',
            'branch_name' => 'required|regex:/^[\pL\s]+$/u|min:4|max:40'

            ]);


              DB::connection('mysql3')->table('customer')->where(['id' => $customerid])->update([
                    'act_no'=> $request->bank_account_no,
                     'branch_name'=> $request->branch_name,
                     'ifsc_code'=> $request->ifsc_code,
                     'bank_name'=> $request->bank_name
                     ]); 

             $updatebankinfo = $this->updatebankinfo($customerid,$request->bank_account_no,$request->branch_name,$request->ifsc_code,$request->bank_name);
             
            
            if (($updatebankinfo['Status'] == 'X')&&($updatebankinfo['code'] == '200')) {
            $request->session()->flash("suc_msg", "Bank Details Updated Successfully!");
            return redirect()->route('custbankdetails');
            }else{
                $request->session()->flash("error_msg", "Sorry! Bank Details not Updated Successfully!");
            return redirect()->back();
            }

        }
        else{
            return redirect()->route('newcustomer_home');
        }
    }

    public function customer_satisfaction_survey(Request $request)
    {
        if ($request->session()->has('customersession')) {
            $encrypt = $request->session()->get('customersession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $customerid = $split[0];
            $getcustomerdata = DB::connection('mysql3')->table('customer')->where('id', '=', $customerid)->get();
            $getblockdates = DB::connection('mysql3')->table('projects')->where('cust_id', '=', $customerid)->where('exp_date_of_compl', '!=', '')->get();

            $pwd_status = $this->is_cust_didnt_passwordchanged($customerid);
            if ($pwd_status == 0) {
                $request->session()->flash("error_msg", 'Please change the default password. Only if you Change the default password , other functionalities on this portal will work. This is done for security purposes. Please do not share your password with anyone');
                return redirect()->route('newcustomer_mydetails_passchange');
            }
           
              $listfiles = Storage::disk('s3')->files("/newcustomerzoneassets/customersprofileimage/".$customerid);
             
             if(count($listfiles) > 0){
                $profilepic = config('app.AWS_URL')."/".$listfiles[0];
            }
             else
             {
                $profilepic = config('app.AWS_URL')."/newcustomerzoneassets/img/dummy_male.png";
             }
             $rating = 0;
	       $getcustsatisfactionlist = $this->getcustdisatreasons($customerid);
            $dissatisfationlist = $getcustsatisfactionlist['Reasons'];

             $check_rating = DB::connection('mysql3')->table('satisfaction_rating')->where('customerid', '=', $customerid)->get();
             if(count($check_rating) > 0){
                 foreach ($check_rating as $key => $value) {
                     $rating = $value->rating_id;
                 }
             }

             //dd($rating);
             
             return view('newcustomerzone.customer_satisfaction_survey')->with(['getcustomerdata'=> $getcustomerdata,'rating' => $rating, 'profilepic' => $profilepic,'getblockdates' => $getblockdates,'dissatisfationlist' => $dissatisfationlist]);
        }
        else{
            return redirect()->route('newcustomer_home');
        }
    }


    public function open_customercheck_toinsert($customerid)
    {

        if (ctype_digit($customerid)) {

            if((strlen($customerid) >= 3)&&(strlen($customerid) < 10)){
                $loginmode = 'loginmode_customerid';
            }
            else{
                //dd("Sorry! Invalid CustomerId");
                return 0;
            }
                
        }

        
        if ($loginmode == 'loginmode_customerid') {
            
            $getno = DB::connection('mysql3')->table('customer')->where(['id' => $customerid])->get();
            
            if (count($getno) == 0) {
                
                 $sapdata = $this->getCustomer($customerid);
                                
                 $nowdate = Carbon::now();
            
                 
                 if($sapdata['Customer_Name'] != '')
                 {
                     if($sapdata['Postal_Code'] == ''){ $sapdata['Postal_Code'] = 0; }
                     //if($sapdata['Net_amount'] != ''){ $sapdata['Net_amount'] = str_replace('-','',$sapdata['Net_amount']); }
                     $now = Carbon::now();
                     DB::connection('mysql3')->table('customer')->insert([
                     'id' => $customerid,
                     'Name' => $sapdata['Customer_Name'],
                     'password' => $sapdata['Pass_Word'],
                     'valid' => $sapdata['Customer_status'],
                     'street1'=> $sapdata['Address_Street_1'],
                     'street2'=> $sapdata['Address_Street_2'],
                     'street3'=> $sapdata['Address_Street_3'],
                     'houseno'=> $sapdata['Street_House_number'],
                     'city'=> $sapdata['City'],
                     'country'=> $sapdata['Country'],
                     'pin'=> $sapdata['Postal_Code'],
                     'region'=> $sapdata['Region'],
                     'tel'=> $sapdata['Telephone'],
                     'mobile'=> $sapdata['Mobile_No'],
                     'fax'=> $sapdata['FAX_NUMBER'],
                     'email'=> $sapdata['E_Mail'],
                     'comp_raised'=> $sapdata['No_Of_Comp_Raised'],
                     'comp_closed'=> $sapdata['No_Of_Comp_Closed'],
                     'comp_pending'=> $sapdata['No_Of_Comp_Pending'],
                     'net_amt'=> $sapdata['Net_amount'],
                     'nou'=> $sapdata['No_Of_Unit'],
                     'customer_executive'=> $sapdata['Customer_Executive'],
                     'customer_manager'=> $sapdata['Customer_Manager'],
                     'updated'=> null,
                     'pwd_updated'=> null,
                     'pwd_count'=> 0,
                     'act_no'=> $sapdata['Acc_No'],
                     'branch_name'=> $sapdata['Branch_Name'],
                     'ifsc_code'=> $sapdata['IFSC_Code'],
                     'bank_name'=> $sapdata['Bank_Name'],
                     'created' => $now,
                     'schedular' => null
                     ]); 
                    
                    $sap_proj = array();
                    if (!array_key_exists('Project_Detail', $sapdata)) {
                      DB::connection('mysql3')->table('customer')->where('id','=',$customerid)->delete();
                        //dd("Project details not available!");
                        return  0;
                    }
                    
                    $sapprojects = $sapdata['Project_Detail'];
                    if (array_key_exists('0', $sapprojects)) {
                        $sap_proj = $sapprojects;
                    }
                    else
                    {
                        $sap_proj[0] = $sapprojects;
                    }
                    
                     $getprojects = DB::connection('mysql3')->table('projects')->where('cust_id', '=', $customerid)->get();
                     
                     if(count($getprojects) == 0)
                     {
                        foreach ($sap_proj as $sapprojkey => $sapprojvalue) {

                                                 
                    $getinspection = $this->get_inspection_snag($customerid, $sapprojvalue['Unit'], $sapprojvalue['Plant']);        

                    
                    $sap_inspect = array();
                    $sapinspectionsnag = $getinspection['Data'];
                    if (array_key_exists('0', $sapinspectionsnag)) {
                        $sap_inspect = $sapinspectionsnag;
                    }
                    else
                    {
                        $sap_inspect[0] = $sapinspectionsnag;
                    }

                    $inspectcount = count($sap_inspect);
                    $expdt_of_comp = null;
                    $dlp_end_date = null;
                    if ($sapprojvalue['Exp_Dateof_Completion'] != '00000000') {
                        $expdt_of_comp = substr($sapprojvalue['Exp_Dateof_Completion'],0,4).'-'.substr($sapprojvalue['Exp_Dateof_Completion'],4,2).'-'.substr($sapprojvalue['Exp_Dateof_Completion'],6,2);
                    }

                    if ($sapprojvalue['DLP_End_Date'] != '00000000') {
                        $dlp_end_date = substr($sapprojvalue['DLP_End_Date'],0,4).'-'.substr($sapprojvalue['DLP_End_Date'],4,2).'-'.substr($sapprojvalue['DLP_End_Date'],6,2);
                    }
                    
                    
                    DB::connection('mysql3')->table('projects')->insert(['cust_id' => $customerid,
                                'pname' => $sapprojvalue['Plant_Name'],
                                'project_id' => $sapprojvalue['Plant'],
                                'unit' => $sapprojvalue['Unit'],
                                'unit_nm' => $sapprojvalue['Unit_Name'],
                                'milestone' => $sapprojvalue['Milestone'],
                                'posession' => $sapprojvalue['Possession'],
                                'snagcreatedbyuser' => null,
                                'projectlink' => $sapprojvalue['Link'],
                                'dlp_end_date' => $dlp_end_date,
                                'exp_date_of_compl' => $expdt_of_comp,
                                'Block_name' => $sapprojvalue['Block_Name']
                                ]);
                    
                     if ($sap_inspect[0]['Unique_No'] != '') {
                         DB::connection('mysql3')->table('projects')->where(['cust_id' => $customerid,'project_id'=>$sap_inspect[0]['Plant_code'],'unit'=>$sap_inspect[0]['Unit_no'] ])->update(['snagcreatedbyuser' => $inspectcount]);
                     }


                    
                    foreach ($sap_inspect as $sapinskey => $sapinsvalue) {
                        
                        if ($sapinsvalue['Unique_No'] != '') {
                            
                            $checkinspectindb = DB::connection('mysql3')->table('inspection_snag')->where(['cust_id' => $customerid,'project_id'=>$sapinsvalue['Plant_code'],'unit_no'=>$sapinsvalue['Unit_no'],'uniqueno'=>$sapinsvalue['Unique_No'] ])->count();        
                            if($sapinsvalue['Indicator'] == 'X'){ $sapinsvalue['Indicator'] = 'CLOSED';}else{$sapinsvalue['Indicator'] = 'OPEN';}
                            if($checkinspectindb != 0){

                                DB::connection('mysql3')->table('inspection_snag')->where(['cust_id' => $customerid,'project_id'=>$sapinsvalue['Plant_code'],'unit_no'=>$sapinsvalue['Unit_no'],'uniqueno'=>$sapinsvalue['Unique_No'] ])->delete();
                                DB::connection('mysql3')->table('inspection_snag')->insert(['cust_id' => $customerid,
                                'project_id'=>$sapinsvalue['Plant_code'],
                                'unit_no'=>$sapinsvalue['Unit_no'],
                                'snag_desc'=>$sapinsvalue['Inspection_Snag'],
                                'uniqueno'=>$sapinsvalue['Unique_No'],
                                'snag_created_date'=> substr($sapinsvalue['Created_Date'],0,4).'-'.substr($sapinsvalue['Created_Date'],4,2).'-'.substr($sapinsvalue['Created_Date'],6,2).' '.substr($sapinsvalue['Time'],0,2).':'.substr($sapinsvalue['Time'],2,2).':'.substr($sapinsvalue['Time'],4,2),
                                'vgn_status' => $sapinsvalue['Indicator'],
                                'Expecteddateofcomp' => substr($sapinsvalue['Expected_Date'],0,4).'-'.substr($sapinsvalue['Expected_Date'],4,2).'-'.substr($sapinsvalue['Expected_Date'],6,2)
                                 ]);
                            }
                            else{
                                DB::connection('mysql3')->table('inspection_snag')->insert(['cust_id' => $customerid,
                                'project_id'=>$sapinsvalue['Plant_code'],
                                'unit_no'=>$sapinsvalue['Unit_no'],
                                'snag_desc'=>$sapinsvalue['Inspection_Snag'],
                                'uniqueno'=>$sapinsvalue['Unique_No'],
                                'snag_created_date'=> substr($sapinsvalue['Created_Date'],0,4).'-'.substr($sapinsvalue['Created_Date'],4,2).'-'.substr($sapinsvalue['Created_Date'],6,2).' '.substr($sapinsvalue['Time'],0,2).':'.substr($sapinsvalue['Time'],2,2).':'.substr($sapinsvalue['Time'],4,2),
                                'vgn_status' => $sapinsvalue['Indicator'],
                                'Expecteddateofcomp' => substr($sapinsvalue['Expected_Date'],0,4).'-'.substr($sapinsvalue['Expected_Date'],4,2).'-'.substr($sapinsvalue['Expected_Date'],6,2)
                                 ]);
                            }
                        }
                    }
                            
                           
                        }
                     }


                    $sap_compl = array();
                    if (array_key_exists('Compliants', $sapdata)) {
                    
                    $sapcomplaints = $sapdata['Compliants'];
                    if (array_key_exists('0', $sapcomplaints)) {
                        $sap_compl = $sapcomplaints;
                    }
                    else
                    {
                        $sap_compl[0] = $sapcomplaints;
                    }
                    
                     $getcomplaints = DB::connection('mysql3')->table('complaints')->where('customer_id', '=', $customerid)->get();
                     
                     
                     if(count($getcomplaints) > 0)
                     {
                        foreach ($sap_compl as $sapcomplkey => $sapcomplvalue) {
                            foreach ($getcomplaints as $complkey => $complvalue) {
                            $projectname =  $complvalue->project;
                            $projectcomplaint =  $complvalue->complaint_no;
                            $projectcomplaintunit =  $complvalue->unit;
                            //dd($projectname);
                            if (($projectname == $sapcomplvalue['Project_Name'])&&($projectcomplaint == $sapcomplvalue['Complaint_Number'])&&($projectcomplaintunit == $sapcomplvalue['Unit_Number'])) {
                                
                                DB::connection('mysql3')->table('complaints')->where('customer_id', '=', $customerid)
                                ->where('project','=',$projectname)
                                ->where('complaint_no','=',$projectcomplaint)
                                ->where('unit','=',$projectcomplaintunit)
                                ->update(['nature' => $sapcomplvalue['Nature_Of_Complaint'],
                                'vgn_status' => $sapcomplvalue['VGN_Status'],
                                'cust_status' => $sapcomplvalue['Customer_Status'],
                                'final_status' => $sapcomplvalue['Final_status'],
                                'vgn_remarks' => $sapcomplvalue['VGN_Remarks'],
                                'date' => substr($sapcomplvalue['Date_of_complaint_raised'],0,4)."-".substr($sapcomplvalue['Date_of_complaint_raised'],4,2)."-".substr($sapcomplvalue['Date_of_complaint_raised'],6,2),
                                'Expecteddateofcomp' => substr($sapcomplvalue['Expected_Date'],0,4)."-".substr($sapcomplvalue['Expected_Date'],4,2)."-".substr($sapcomplvalue['Expected_Date'],6,2),
                                 ]);
                            }
                           

                            }
                            
                        }
                     }
                 }
                    
                     $getpwdforsap = DB::connection('mysql3')->table('sapcustomer')->where('customerid', '=', $customerid)->get();
                     if(count($getpwdforsap) > 0)
                     {
                         DB::connection('mysql3')->table('sapcustomer')->where('customerid', '=', $customerid)->delete();
                         DB::connection('mysql3')->table('sapcustomer')->insert(['customerid' => $customerid, 'password' => $sapdata['Pass_Word']]);
                     }
                     else
                     {
                        DB::connection('mysql3')->table('sapcustomer')->insert(['customerid' => $customerid, 'password' => $sapdata['Pass_Word']]);
                     }

                    $sap_paym = array();
                    if (array_key_exists('Payment_History', $sapdata)) {
                    $sappayments = $sapdata['Payment_History'];
                    if (array_key_exists('0', $sappayments)) {
                        $sap_paym = $sappayments;
                    }
                    else
                    {
                        $sap_paym[0] = $sappayments;
                    }
                    //dd($sap_compl);
                     $getpayments = DB::connection('mysql3')->table('payments')->where('cust_id', '=', $customerid)->get();
                     
                     if(count($getpayments) > 0)
                     {
                         DB::connection('mysql3')->table('payments')->where('cust_id', '=', $customerid)->delete();
                         if (count($sap_paym) > 0) {
                         
                        foreach ($sap_paym as $sappaymkey => $sappaymvalue) {
                              DB::connection('mysql3')->table('payments')->insert(['cust_id' => $customerid,
                                'posteddate' => substr($sappaymvalue['Posting_Date'],0,4)."-".substr($sappaymvalue['Posting_Date'],4,2)."-".substr($sappaymvalue['Posting_Date'],6,2),
                                'doc_no' => $sappaymvalue['Document_Number'],
                                'inv_amt' => str_replace('-','',$sappaymvalue['Invoice_Amount']),
                                'pay_type' => $sappaymvalue['Payment_Amount'],
                                'created' => Carbon::now(),
                                'updated' => Carbon::now()
                                ]);
                            
                        }

                        }
                     }
                     else{
                         if (count($sap_paym) > 0) {
                             foreach ($sap_paym as $sappaymkey => $sappaymvalue) {
                              DB::connection('mysql3')->table('payments')->insert(['cust_id' => $customerid,
                                'posteddate' => substr($sappaymvalue['Posting_Date'],0,4)."-".substr($sappaymvalue['Posting_Date'],4,2)."-".substr($sappaymvalue['Posting_Date'],6,2),
                                'doc_no' => $sappaymvalue['Document_Number'],
                                'inv_amt' => str_replace('-','',$sappaymvalue['Invoice_Amount']),
                                'pay_type' => $sappaymvalue['Payment_Amount'],
                                'created' => Carbon::now(),
                                'updated' => Carbon::now()
                                ]);
                            
                        }
                         }

                     }
                 }

                    
                    return 1;
                 }else{
                     //$check = DB::connection('mysql3')->table('customer')->where(['id' => $request->username , 'password' => $request->password])->get();
                    return 0;
                 }
            }
            else{
            //$check = DB::connection('mysql3')->table('customer')->where(['id' => $request->username , 'password' => $request->password])->get();
                return 0;
            }
        }
        else{
                //dd("Sorry! Enter a valid CustomerId");
            return 0;
        }
                  
         
    }

    public function open_customer_satisfaction_survey($customerid)
    {
            $getcustomerdata = DB::connection('mysql3')->table('customer')->where('id', '=', $customerid)->get();
            if(count($getcustomerdata) == 0){
                $check = $this->open_customercheck_toinsert($customerid);
                if ($check == 1) {
                    $getcustomerdata = DB::connection('mysql3')->table('customer')->where('id', '=', $customerid)->get();
                }
                else{
                    dd('Not a Valid Customer!');
                }
            } 
            $rating = 0;
	     $getcustsatisfactionlist = $this->getcustdisatreasons($customerid);
            $dissatisfationlist = $getcustsatisfactionlist['Reasons'];

             $check_rating = DB::connection('mysql3')->table('satisfaction_rating')->where('customerid', '=', $customerid)->get();
             if(count($check_rating) > 0){
                 foreach ($check_rating as $key => $value) {
                     $rating = $value->rating_id;
                 }
             }
            return view('newcustomerzone.open_customer_satisfaction_ratings')->with(['customerid'=>$customerid,'getcustomerdata'=> $getcustomerdata,'rating' => $rating,'dissatisfationlist'=>$dissatisfationlist]);
            
        
    }

    public function post_open_customer_satisfaction_ratings(Request $request)
    {
        
            $customerid = $request->customerid;
            $getcustomerdata = DB::connection('mysql3')->table('customer')->where('id', '=', $customerid)->get();
            if(count($getcustomerdata) > 0){
        $rating = $request->selectedval;
        $customerid = $request->customerid;
	$reason = $request->reason;

        $des = [1 => 'Extremely Satisfied', 2 => 'Somewhat Satisfied',3=>'Neutral', 4=>'Somewhat Dissatisfied', 5=>'Extremely Dissatisfied'];
        //return $customerid;
        $check_rating = DB::connection('mysql3')->table('satisfaction_rating')->where('customerid', '=', $customerid)->get();

        if(count($check_rating) > 0){
            
                $status = $this->customer_satisfaction($customerid,$rating);
                if($status['Status'] == 'Updated Successfully'){
			
			if (!empty($rating)) {
                        $sendreasontosap = $this->postcustdisatreasons($customerid, $reason, $rating);
                        Log::info('sendreasontosap Data2 '.$sendreasontosap['Status']);
                    if ($sendreasontosap['Status'] == 'Updated Successfully') {
                        # code...
        	            }
	                    }

                    DB::connection('mysql3')->table('satisfaction_rating')->where(['customerid' => $customerid])->update([
                        'rating_id' => $rating,
                        'description' => $des[$rating],
                        'updated_date' => Carbon::now()->toDateTimeString(),
                        ]);
                    return 1;
                }
                else{
                    return 0;
                }
        }
        else{
            

                $status = $this->customer_satisfaction($customerid,$rating);
                if($status['Status'] == 'Updated Successfully'){
			
		if (!empty($rating)) {
                        $sendreasontosap = $this->postcustdisatreasons($customerid, $reason, $rating);
                        Log::info('sendreasontosap Data2 '.$sendreasontosap['Status']);
                    if ($sendreasontosap['Status'] == 'Updated Successfully') {
                        # code...
                    }
                    }
                    DB::connection('mysql3')->table('satisfaction_rating')->insert([
                        'customerid' => $customerid,
                        'rating_id' => $rating,
                        'description' => $des[$rating],
                        'updated_date' => Carbon::now()->toDateTimeString(),
                        ]);
                    return 1;

                }
                else{
                    return 0;
                }
        }
    }
    else{
        return 0;
    }

    }

    public function post_customer_satisfaction_survey(Request $request)
    {
        if ($request->session()->has('customersession')) {
            $encrypt = $request->session()->get('customersession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $customerid = $split[0];
            $getcustomerdata = DB::connection('mysql3')->table('customer')->where('id', '=', $customerid)->get();

        $rating = $request->selectedval;
        $customerid = $request->customerid;
	$reason = $request->reason;
        $des = [1 => 'Extremely Satisfied', 2 => 'Somewhat Satisfied',3=>'Neutral', 4=>'Somewhat Dissatisfied', 5=>'Extremely Dissatisfied'];
        //return $customerid;
        $check_rating = DB::connection('mysql3')->table('satisfaction_rating')->where('customerid', '=', $customerid)->get();

        if(count($check_rating) > 0){
            
                $status = $this->customer_satisfaction($customerid,$rating);
                if($status['Status'] == 'Updated Successfully'){
			if (!empty($rating)) {
                        $sendreasontosap = $this->postcustdisatreasons($customerid, $reason, $rating);
                    if ($sendreasontosap['Status'] == 'Updated Successfully') {
                        # code...
                    }
                    }
                    DB::connection('mysql3')->table('satisfaction_rating')->where(['customerid' => $customerid])->update([
                        'rating_id' => $rating,
                        'description' => $des[$rating],
                        'updated_date' => Carbon::now()->toDateTimeString(),
                        ]);
                    return 1;
                }
                else{
                    return 0;
                }
        }
        else{
            

                $status = $this->customer_satisfaction($customerid,$rating);
                if($status['Status'] == 'Updated Successfully'){
			if (!empty($rating)) {
                        $sendreasontosap = $this->postcustdisatreasons($customerid, $reason, $rating);
                    if ($sendreasontosap['Status'] == 'Updated Successfully') {
                        # code...
                    }
                    }

                    DB::connection('mysql3')->table('satisfaction_rating')->insert([
                        'customerid' => $customerid,
                        'rating_id' => $rating,
                        'description' => $des[$rating],
                        'updated_date' => Carbon::now()->toDateTimeString(),
                        ]);
                    return 1;

                }
                else{
                    return 0;
                }
        }

        return 1;
    }
    else{
        return redirect()->route('newcustomer_home');
    }

    }

     public function triggerdissatisfactionsmsmail(Request $request)
    {
         $customerid = $request->customerid;
            $getcustomerdata = DB::connection('mysql3')->table('customer')->where('id', '=', $customerid)->get();
            if(count($getcustomerdata) > 0){
        $rating = $request->selectedval;
        
        
        $des = [1 => 'Extremely Satisfied', 2 => 'Somewhat Satisfied',3=>'Neutral', 4=>'Somewhat Dissatisfied', 5=>'Extremely Dissatisfied'];
        //return $customerid;
       if (($rating == 4) || ($rating == 5)  ) {

        foreach ($getcustomerdata as $key => $value) {
            $name = $value->name;
            $email = $value->email;
            $mobile = $value->mobile;
        }


                $now = Carbon::now()->toDateTimeString();
                

                //start
                     $link="https://www.vgn.in/customerzone/customerlogin";
                $newmail=array();
                $newmail['toname']=$name;
                $newmail['toemail']=$email;
                $newmail['subject']="VGN Customer Zone - Customer Satisfaction Survey!";
                $newmail['content']='<div style=" margin: 0 auto;  background-color: #eef5ff;padding: 2% 4%;font-size: 14px;"><div style="text-align: center;"><img src="https://www.vgn.in/images/custom/vgn-logo.png" alt="vgn-logo"></div>Dear '.$name.',<br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Greetings from VGN! We are extremely concerned that you are '.$des[$rating].' with our service. We kindly request to raise your complaint or give us your feedback in <a href="'.$link.'">'.$link.'</a>, to help us serve you better.<br><br>Thanks,<br>VGN<br><div style="    text-align: center;    font-size: 88%;    color: rgb(124, 124, 124);">For Any details : <a href="http://www.vgn.in">www.vgn.in</a><br><span style="    color: rgb(23, 79, 163);
                font-weight: bold;">VGN Property Developers Private Limited</span>&nbsp;- No.153, Wallace Garden, 2nd Street, Nungambakkam, Chennai-600006.<br>Call Us: +91 44 4343 9900</div></div>';
                //$newmail['html']="user-detail-contents.html";
                //$newmail['att_url']="images/logo.jpg";
                if(ctype_digit($mobile)){
                    if (strlen($mobile) == 10) {
                $smscontent = 'Dear '.$name.', Greetings from VGN! We are extremely concerned that you are '.$des[$rating].' with our service. We kindly request to raise your complaint or give us your feedback in '.$link.' , to help us serve you better.'; 
                
               $sms_status = $this->smscurl($smscontent, $mobile);               
                DB::connection('mysql3')->table('sms_sent_data')->insert(['customerid' => $customerid,'sentdatetime' => $now]);
                    }
                }

                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    }else{
                    $mailstatus = $this->sendmail($newmail);        
                    }
                //end
       }

       return 1;
    }
    else{
        return 0;
    }
    }

    public function registrationdetails(Request $request)
    {
        if ($request->session()->has('customersession')) {
        
            $encrypt = $request->session()->get('customersession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $customerid = $split[0];

            $pwd_status = $this->is_cust_didnt_passwordchanged($customerid);
            if ($pwd_status == 0) {
                $request->session()->flash("error_msg", 'Please change the default password. Only if you Change the default password , other functionalities on this portal will work. This is done for security purposes. Please do not share your password with anyone');
                return redirect()->route('newcustomer_mydetails_passchange');
            }

            $getcustomerdata = DB::connection('mysql3')->table('customer')->where('id', '=', $customerid)->get();
            $getproject = DB::connection('mysql3')->table('projects')->where('cust_id', '=', $customerid)->get();
             $listfiles = Storage::disk('s3')->files("/newcustomerzoneassets/customersprofileimage/".$customerid);
             $getblockdates = DB::connection('mysql3')->table('projects')->where('cust_id', '=', $customerid)->where('exp_date_of_compl', '!=', '')->get();
             
             if(count($listfiles) > 0){
                $profilepic = config('app.AWS_URL')."/".$listfiles[0];
            }
             else
             {
                $profilepic = config('app.AWS_URL')."/newcustomerzoneassets/img/dummy_male.png";
             }
            
             $bankdetails = $this->getreg_details_availbank();

             $banks = [];
             if (count($bankdetails['List_Of_Banks']) > 0) {
                 foreach ($bankdetails['List_Of_Banks'] as $key1 => $value1) {
                     $banks[] = $value1['Bank_Names'];
                 }
             }
             
             return view('newcustomerzone.regdetails')->with(['getcustomerdata'=>$getcustomerdata,'getproject'=>$getproject,'bankdetails' => $banks, 'profilepic' => $profilepic,'getblockdates' => $getblockdates]);
        }
        else{
            return redirect()->route('newcustomer_home');
        }
    }

    public function checkthepanfile($request, $filename,$message_bag )
    {
        $file = $request->file($filename);
        $filesize = round($file->getClientSize() / 1024);
        $ext = strtolower($file->getClientOriginalExtension());
        $error = [];
        $filearray = ["jpg","jpeg","png","pdf"];
        
        if (($filesize > 5000) || ($filesize < 5)) {
                $message_bag->add('panfile_1', 'Minimum filesize can be 5kb to 5MB.');
                return redirect()->back()->withInput()->withErrors($message_bag);
        }

        if (!in_array($ext, $filearray))
        {
            $error[] ="Allowed file formats are jpg, jpeg, png, pdf";
                $message_bag->add('panfile_1', 'Allowed file formats are jpg, jpeg, png, pdf');
                return redirect()->back()->withInput()->withErrors($message_bag);
        }

        return $error;


    }
    public function postregistrationdetails(Request $request, MessageBag $message_bag)
    {
        if ($request->session()->has('customersession')) {
        
            $encrypt = $request->session()->get('customersession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $customerid = $split[0];

            $getproject = DB::connection('mysql3')->table('projects')->where('cust_id', '=', $customerid)->get();

        $attribute  = [
            'applicant_1_name' => '1st Applicant Name',
            'title_1_name' => 'Care-Of',
            'applicant_1_age' => 'Age',
            'houseflatno' => 'House/Flat No.',
            'street_name_1' => 'Street Name',
            'street_name_2' => 'Area',
            'pincode1' => 'Pincode',
            'first_app_state' => 'State',
            'first_app_city' => 'City',
            'panno_1' => 'Pan Number',
            'religion_1' => 'Religion',
            'Emailid_1' => 'EmailId',
            'contactno_1' => 'Contact Number',
            'panfile_1' => 'Pan File',
            'need_home_loan' => 'Avail Home Loan',
            'bankdetails' => 'Bank Details',

            'applicant_2_name' => '2nd Applicant Name',
            'title_2_name' => 'Care-Of',
            'applicant_2_age' => 'Age',
            'houseflatno2' => 'House/Flat No.',
            'sec_street_name_1' => 'Street Name',
            'sec_street_name_2' => 'Area',
            'sec_pincode2' => 'Pincode',
            'second_app_state' => 'State',
            'second_app_city' => 'City',
            'panno_2' => 'Pan Number',
            'religion_2' => 'Religion',
            'Emailid_2' => 'EmailId',
            'contactno_2' => 'Contact Number',
            'panfile_2' => 'Pan File',

            
            'poaname' => 'POA Name',
            'poafathersname' => 'POA Father\'s Name',
            'poaage' => 'POA Age',
            'houseflatno2' => 'House/Flat No.',
            'poa_street_name' => 'Street Name',
            'poa_area' => 'Area',
            'poa_pincode' => 'Pincode',
            'poastate' => 'State',
            'poacity' => 'City',
            'poa_panno_2' => 'Pan Number',
            'poa_religion_2' => 'Religion',
            'poa_Emailid_2' => 'EmailId',
            'poa_contactno_2' => 'Contact Number',
            'poa_panfile_2' => 'Pan File',
            'poafile' => 'POA File',
            'poaforeign_power' => 'POA foreign power',
            'poa_doc_no' => 'POA Document Number',
            'poa_adj_date' => 'POA Adjudicated Date',
            'poa_adj_no' => 'POA Adjudicated Number',
            'poa_registerd' => 'POA Registered',
            'poaforeign_power' => 'POA Foreign Power'
        ];


        if ((isset($request->secondndapplicantchecked)) && (!isset($request->thirdapplicantchecked))) {
            $validate = $this->validate($request, [
                'project' => 'required',
                'unit' => 'required',
                'applicant_1_name' => 'required|min:2|max:80',
                'name1title' => 'required|in:sof,wof,dof',
                'title_1_name' => 'required',
                'applicant_1_age' => 'required|integer|between: 18,100',
                'houseflatno' => 'required|min:1|max:10',
                'street_name_1' => 'required|min:5|max:150',
                'street_name_2' => 'required|min:1|max:100',
                'pincode1' => 'required|digits:6',
                'first_app_state' => 'required|not_in:Select State',
                'first_app_city' => 'required',
                'panno_1' => array('required','regex:/^([a-zA-Z]){5}([0-9]){4}([a-zA-Z]){1}?$/'),
                'religion_1' => 'required|min:3|max:50',
                'Emailid_1' => 'required|email',
                'contactno_1' => 'required|digits:10',
                'panfile_1' => 'nullable',
                'need_home_loan' => 'required',
                'bankdetails' => 'required_if:need_home_loan,==,yes',

                'applicant_2_name' => 'required',
                'name2title' => 'required',
                'title_2_name' => 'required',
                'applicant_2_age' => 'required|integer|between: 18,100',
                'houseflatno2' => 'required|min:1|max:10',
                'sec_street_name_1' => 'required|min:5|max:150',
                'sec_street_name_2' => 'required|min:1|max:100',
                'sec_pincode2' => 'required|digits:6',
                'second_app_state' => 'required|not_in:Select State',
                'second_app_city' => 'required',
                'panno_2' => array('required','regex:/^([a-zA-Z]){5}([0-9]){4}([a-zA-Z]){1}?$/'),
                'religion_2' => 'required|min:3|max:50',
                'Emailid_2' => 'required|email',
                'contactno_2' => 'required|digits:10',
                'panfile_2' => 'nullable',
            ],[],$attribute);
        }
        elseif((isset($request->secondndapplicantchecked)) && (isset($request->thirdapplicantchecked))){
            $validate = $this->validate($request, [
                'project' => 'required',
                'unit' => 'required',
                'applicant_1_name' => 'required|min:2|max:80',
                'name1title' => 'required|in:sof,wof,dof',
                'title_1_name' => 'required|min:2|max:80',
                'applicant_1_age' => 'required|integer|between: 18,100',
                'houseflatno' => 'required|min:1|max:10',
                'street_name_1' => 'required|min:5|max:150',
                'street_name_2' => 'required|min:1|max:100',
                'pincode1' => 'required|digits:6',
                'first_app_state' => 'required|not_in:Select State',
                'first_app_city' => 'required',
                'panno_1' => array('required','regex:/^([a-zA-Z]){5}([0-9]){4}([a-zA-Z]){1}?$/'),
                'religion_1' => 'required|min:3|max:50',
                'Emailid_1' => 'required|email',
                'contactno_1' => 'required|digits:10',
                'panfile_1' => 'nullable',
                'need_home_loan' => 'required',
                'bankdetails' => 'required_if:need_home_loan,==,yes',

                'applicant_2_name' => 'required|min:2|max:80',
                'name2title' => 'required|in:sof,wof,dof',
                'title_2_name' => 'required',
                'applicant_2_age' => 'required|integer|between: 18,100',
                'houseflatno2' => 'required|min:1|max:10',
                'sec_street_name_1' => 'required|min:5|max:150',
                'sec_street_name_2' => 'required|min:1|max:100',
                'sec_pincode2' => 'required|digits:6',
                'second_app_state' => 'required|not_in:Select State',
                'second_app_city' => 'required',
                'panno_2' => array('required','regex:/^([a-zA-Z]){5}([0-9]){4}([a-zA-Z]){1}?$/'),
                'religion_2' => 'required|min:3|max:50',
                'Emailid_2' => 'required|email',
                'contactno_2' => 'required|digits:10',
                'panfile_2' => 'nullable',

                'poaname' => 'required|min:2|max:80',
                'poafathersname' => 'required|min:2|max:80',
                'poaage' => 'required|integer|between: 18,100',
                'poahouseflatno' => 'required|min:1|max:10',
                'poa_street_name' => 'required|min:5|max:150',
                'poa_area' => 'required|min:1|max:100',
                'poa_pincode' => 'required|digits:6',
                'poastate' => 'required|not_in:Select State',
                'poacity' => 'required',
                'poa_panno_2' => array('required','regex:/^([a-zA-Z]){5}([0-9]){4}([a-zA-Z]){1}?$/'),
                'poa_religion_2' => 'required|min:3|max:50',
                'poa_Emailid_2' => 'required|email',
                'poa_contactno_2' => 'required|digits:10',
                'poa_panfile_2' => 'nullable',
                'poafile' => 'nullable',
                'poaforeign_power' => 'required',
                'poa_registerd' => 'required',
                'poa_doc_no' => 'required_if:poa_registerd,==,yes',
                'poa_adj_date' => 'required_if:poaforeign_power,==,yes',
                'poa_adj_no' => 'required_if:poaforeign_power,==,yes'
            ],[],$attribute);


        }
        elseif((!isset($request->secondndapplicantchecked)) && (isset($request->thirdapplicantchecked))){
            $validate = $this->validate($request, [
                    'project' => 'required',
                    'unit' => 'required',
                    'applicant_1_name' => 'required|min:2|max:80',
                    'name1title' => 'required|in:sof,wof,dof',
                    'title_1_name' => 'required|min:2|max:80',
                    'applicant_1_age' => 'required|integer|between: 18,100',
                    'houseflatno' => 'required|min:1|max:10',
                    'street_name_1' => 'required|min:5|max:150',
                    'street_name_2' => 'required|min:1|max:100',
                    'pincode1' => 'required|digits:6',
                    'first_app_state' => 'required|not_in:Select State',
                    'first_app_city' => 'required',
                    'panno_1' => array('required','regex:/^([a-zA-Z]){5}([0-9]){4}([a-zA-Z]){1}?$/'),
                    'religion_1' => 'required|min:3|max:50',
                    'Emailid_1' => 'required|email',
                    'contactno_1' => 'required|digits:10',
                    'panfile_1' => 'nullable',
                    'need_home_loan' => 'required',
                    'bankdetails' => 'required_if:need_home_loan,==,yes',
    
                    'poaname' => 'required|min:2|max:80',
                    'poafathersname' => 'required|min:2|max:80',
                    'poaage' => 'required|integer|between: 18,100',
                    'poahouseflatno' => 'required|min:1|max:10',
                    'poa_street_name' => 'required|min:5|max:150',
                    'poa_area' => 'required|min:1|max:100',
                    'poa_pincode' => 'required|digits:6',
                    'poastate' => 'required|not_in:Select State',
                    'poacity' => 'required',
                    'poa_panno_2' => array('required','regex:/^([a-zA-Z]){5}([0-9]){4}([a-zA-Z]){1}?$/'),
                    'poa_religion_2' => 'required|min:3|max:50',
                    'poa_Emailid_2' => 'required|email',
                    'poa_contactno_2' => 'required|digits:10',
                    'poa_panfile_2' => 'nullable',
                    'poafile' => 'nullable',
                    'poaforeign_power' => 'required',
                    'poa_registerd' => 'required',
                    'poa_doc_no' => 'required_if:poa_registerd,==,yes',
                    'poa_adj_date' => 'required_if:poaforeign_power,==,yes',
                    'poa_adj_no' => 'required_if:poaforeign_power,==,yes'
                ],[],$attribute);
        }
        else{
        $validate = $this->validate($request, [
            'project' => 'required',
            'unit' => 'required',
            'applicant_1_name' => 'required|min:2|max:80',
            'name1title' => 'required|in:sof,wof,dof',
            'title_1_name' => 'required',
            'applicant_1_age' => 'required|integer|between: 18,100',
            'houseflatno' => 'required|min:1|max:10',
            'street_name_1' => 'required|min:5|max:150',
            'street_name_2' => 'required|min:1|max:100',
            'pincode1' => 'required|digits:6',
            'first_app_state' => 'required|not_in:Select State',
            'first_app_city' => 'required',
            'panno_1' => array('required','regex:/^([a-zA-Z]){5}([0-9]){4}([a-zA-Z]){1}?$/'),
            'religion_1' => 'required|min:3|max:50',
            'Emailid_1' => 'required|email',
            'contactno_1' => 'required|digits:10',
            'panfile_1' => 'nullable',
            'need_home_loan' => 'required',
            'bankdetails' => 'required_if:need_home_loan,==,yes'
        ],[],$attribute);
    }

    $file1 = '';
    $file2 = '';
    $file3 = '';
    $file4 = '';
        
        if ($request->hasFile('panfile_1')) {
            $checkthefile = $this->checkthepanfile($request,'panfile_1', $message_bag);
            $error = [];
                if(!empty($checkthefile)){

                    return $checkthefile;
                }
       }

       if ($request->hasFile('panfile_2')) {
        $checkthefile = $this->checkthepanfile($request,'panfile_2', $message_bag);
        $error = [];
            if(!empty($checkthefile)){

                return $checkthefile;
            }
   }

   if ($request->hasFile('poa_panfile_2')) {
    $checkthefile = $this->checkthepanfile($request,'poa_panfile_2', $message_bag);
    $error = [];
        if(!empty($checkthefile)){

            return $checkthefile;
        }
}

if ($request->hasFile('poafile')) {
    $checkthefile = $this->checkthepanfile($request,'poafile', $message_bag);
    $error = [];
        if(!empty($checkthefile)){

            return $checkthefile;
        }
}

   $npath = $customerid.'/'.$request->project.'/'.$request->unit;

   if($request->hasFile('panfile_1')){

//    $path = public_path()."/newcustomerzoneassets/registrationdetails";

    $ext = strtolower($request->file('panfile_1')->getClientOriginalExtension());
                                    
    $newname = $customerid.'_1stapplicant_pan_file';
    $file1 = $newname.'.'.$ext;
   // $npath = $request->file('panfile_1')->store($newname, 'registrationdetails_uploads');

   //$checkdir = is_dir($npath);
    $checkdir = Storage::disk('s3')->exists('/newcustomerzoneassets/registrationdetails/'.$npath);;
    if($checkdir == true){
    $this->delete_files($npath);
    }

    $uploaded1 = Storage::disk('s3')->putFileAs('/newcustomerzoneassets/registrationdetails/'.$npath, $request->file('panfile_1'), $newname.'.'.$ext);

    }


       if($request->hasFile('panfile_2')){

        $ext = strtolower($request->file('panfile_2')->getClientOriginalExtension());
                                        
        $newname = $customerid.'_2ndapplicant_pan_file';
        $file2 = $newname.'.'.$ext;
        //$npath = $request->file('panfile_2')->store($newname, 'registrationdetails_uploads');
        $uploaded2 = Storage::disk('s3')->putFileAs('/newcustomerzoneassets/registrationdetails/'.$npath, $request->file('panfile_2'), $newname.'.'.$ext);

        }

        if($request->hasFile('poa_panfile_2')){

            $path = public_path()."/newcustomerzoneassets/registrationdetails";
            $ext = strtolower($request->file('poa_panfile_2')->getClientOriginalExtension());
                                            
            $newname = $customerid.'_POA_PAN_File';
            $file3 = $newname.'.'.$ext;
            //$npath = $request->file('poa_panfile_2')->store($newname, 'registrationdetails_uploads');
            $uploaded3 = Storage::disk('s3')->putFileAs('/newcustomerzoneassets/registrationdetails/'.$npath, $request->file('poa_panfile_2'), $newname.'.'.$ext);
        
            }

            if($request->hasFile('poafile')){
               
                $ext = strtolower($request->file('poafile')->getClientOriginalExtension());
                                                
                $newname = $customerid.'_POA_File';
                $file4 = $newname.'.'.$ext;
                
                //$npath = $request->file('poafile')->store($newname, 'registrationdetails_uploads');
                $uploaded4 = Storage::disk('s3')->putFileAs('/newcustomerzoneassets/registrationdetails/'.$npath, $request->file('poafile'), $newname.'.'.$ext);
            }



                //$fileloc = "/newcustomerzoneassets/registrationdetails/";

                $tosap_array = [];

                $tosap_array['Customer_ID'] = $customerid;
                $tosap_array['Plant'] = $request->project;
                $tosap_array['Unit'] = $request->unit;

                $tosap_array['Name1'] = $request->applicant_1_name;
                $tosap_array['SO1_Drop'] = $request->name1title;
                $tosap_array['SO1_Name'] = $request->title_1_name;
                $tosap_array['Age1'] = $request->applicant_1_age;
                $tosap_array['Address1_Line1'] = $request->houseflatno.'|#'.$request->street_name_1;
                $tosap_array['Address1_Line2'] = $request->street_name_2.'|#'.$request->pincode1;
                $tosap_array['Address1_Line3'] = $request->first_app_state.'|#'.$request->first_app_city;
                $tosap_array['PAN1'] = $request->panno_1;
                if ($file1 != '') { $tosap_array['PAN1_File_Loc'] = $npath.'/'.$file1; }else{ $tosap_array['PAN1_File_Loc'] = ''; }
                
                $tosap_array['Religion1'] = $request->religion_1;
                $tosap_array['Email1'] = $request->Emailid_1;
                $tosap_array['Contact1'] = $request->contactno_1;

                $tosap_array['Name2'] = '';
                $tosap_array['SO2_Drop'] = '';
                $tosap_array['SO2_Name'] = '';
                $tosap_array['Age2'] = '';
                $tosap_array['Address2_Line1'] = '';
                $tosap_array['Address2_Line2'] = '';
                $tosap_array['Address2_Line3'] = '';
                $tosap_array['PAN2'] = '';
                $tosap_array['PAN2_File_Loc'] = '';
                $tosap_array['Religion2'] = '';
                $tosap_array['Email2'] = '';
                $tosap_array['Contact2'] = '';

                $tosap_array['Name_POA'] = '';
                $tosap_array['Fname_POA'] = '';
                $tosap_array['Age_POA'] = '';
                $tosap_array['Add_POA_1'] = '';
                $tosap_array['Add_POA_2'] = '';
                $tosap_array['Add_POA_3'] = '';
                $tosap_array['PAN_POA'] = '';
                $tosap_array['PAN3_File_Loc'] = '';
                $tosap_array['Religion_POA'] = '';
                $tosap_array['Email_POA'] = '';
                $tosap_array['Contact_POA'] = '';
                $tosap_array['POA_File_Loc'] = '';
                $tosap_array['POA_Reg'] = '';
                $tosap_array['POA_DocNo'] = '';
                $tosap_array['POA_Adj_Status'] = '';
                $tosap_array['POA_Adj_Date'] = '';
                $tosap_array['POA_Adj_No'] = '';

                if((!isset($request->secondndapplicantchecked)) && (!isset($request->thirdapplicantchecked))){
                   
                }
                elseif((isset($request->secondndapplicantchecked)) && (!isset($request->thirdapplicantchecked))){
                $tosap_array['Name2'] = $request->applicant_2_name;
                $tosap_array['SO2_Drop'] = $request->name2title;
                $tosap_array['SO2_Name'] = $request->title_2_name;
                $tosap_array['Age2'] = $request->applicant_2_age;
                $tosap_array['Address2_Line1'] = $request->houseflatno2.'|#'.$request->sec_street_name_1;
                $tosap_array['Address2_Line2'] = $request->sec_street_name_2.'|#'.$request->sec_pincode2;
                $tosap_array['Address2_Line3'] = $request->second_app_state.'|#'.$request->second_app_city;
                $tosap_array['PAN2'] = $request->panno_2;
                if ($file2 != '') { $tosap_array['PAN2_File_Loc'] = $npath.'/'.$file2; }else{ $tosap_array['PAN2_File_Loc'] = ''; }
                $tosap_array['Religion2'] = $request->religion_2;
                $tosap_array['Email2'] = $request->Emailid_2;
                $tosap_array['Contact2'] = $request->contactno_2;
                }
                elseif((!isset($request->secondndapplicantchecked)) && (isset($request->thirdapplicantchecked))){
                    $tosap_array['Name_POA'] = $request->poaname;
                $tosap_array['Fname_POA'] = $request->poafathersname;
                $tosap_array['Age_POA'] = $request->poaage;
                $tosap_array['Add_POA_1'] = $request->poahouseflatno.'|#'.$request->poa_street_name;
                $tosap_array['Add_POA_2'] = $request->poa_area.'|#'.$request->poa_pincode;
                $tosap_array['Add_POA_3'] = $request->poastate.'|#'.$request->poacity;
                $tosap_array['PAN_POA'] = $request->poa_panno_2;
                if($file3 != '') { $tosap_array['PAN3_File_Loc'] = $npath.'/'.$file3; }else{ $tosap_array['PAN3_File_Loc'] = ''; }
                $tosap_array['Religion_POA'] = $request->poa_religion_2;
                $tosap_array['Email_POA'] = $request->poa_Emailid_2;
                $tosap_array['Contact_POA'] = $request->poa_contactno_2;
                if($file4 != '') { $tosap_array['POA_File_Loc'] = $npath.'/'.$file4; }else{ $tosap_array['POA_File_Loc'] = ''; }
                $tosap_array['POA_Reg'] = $request->poa_registerd;
                $tosap_array['POA_DocNo'] = $request->poa_doc_no;
                $tosap_array['POA_Adj_Status'] = $request->poaforeign_power;
                $tosap_array['POA_Adj_Date'] = $request->poa_adj_date;
                $tosap_array['POA_Adj_No'] = $request->poa_adj_no;
                }
                else{

                $tosap_array['Name2'] = $request->applicant_2_name;
                $tosap_array['SO2_Drop'] = $request->name2title;
                $tosap_array['SO2_Name'] = $request->title_2_name;
                $tosap_array['Age2'] = $request->applicant_2_age;
                $tosap_array['Address2_Line1'] = $request->houseflatno2.'|#'.$request->sec_street_name_1;
                $tosap_array['Address2_Line2'] = $request->sec_street_name_2.'|#'.$request->sec_pincode2;
                $tosap_array['Address2_Line3'] = $request->second_app_state.'|#'.$request->second_app_city;
                $tosap_array['PAN2'] = $request->panno_2;
                if($file2 != '') { $tosap_array['PAN2_File_Loc'] = $npath.'/'.$file2; }else{ $tosap_array['PAN2_File_Loc'] = ''; }
                $tosap_array['Religion2'] = $request->religion_2;
                $tosap_array['Email2'] = $request->Emailid_2;
                $tosap_array['Contact2'] = $request->contactno_2;

                $tosap_array['Name_POA'] = $request->poaname;
                $tosap_array['Fname_POA'] = $request->poafathersname;
                $tosap_array['Age_POA'] = $request->poaage;
                $tosap_array['Add_POA_1'] = $request->poahouseflatno.'|#'.$request->poa_street_name;
                $tosap_array['Add_POA_2'] = $request->poa_area.'|#'.$request->poa_pincode;
                $tosap_array['Add_POA_3'] = $request->poastate.'|#'.$request->poacity;
                $tosap_array['PAN_POA'] = $request->poa_panno_2;
                if($file3 != '') { $tosap_array['PAN3_File_Loc'] = $npath.'/'.$file3; }else{ $tosap_array['PAN3_File_Loc'] = ''; }
                $tosap_array['Religion_POA'] = $request->poa_religion_2;
                $tosap_array['Email_POA'] = $request->poa_Emailid_2;
                $tosap_array['Contact_POA'] = $request->poa_contactno_2;
                if($file4 != '') { $tosap_array['POA_File_Loc'] = $npath.'/'.$file4; }else{ $tosap_array['POA_File_Loc'] = ''; }
                $tosap_array['POA_Reg'] = $request->poa_registerd;
                $tosap_array['POA_DocNo'] = $request->poa_doc_no;
                $tosap_array['POA_Adj_Status'] = $request->poaforeign_power;
                $tosap_array['POA_Adj_Date'] = $request->poa_adj_date;
                $tosap_array['POA_Adj_No'] = $request->poa_adj_no;

                }

                $tosap_array['Bank_Details'] = $request->bankdetails;

                $sendtosap = $this->postreg_details__to_sap($tosap_array);

                if ($sendtosap['Status'] == 'Updated Successfully') {
                    $request->session()->flash("suc_msg", "Successfully Registration Data Updated!");
                    return redirect()->back();
                }
                else{
                    $request->session()->flash("error_msg", "Sorry, Registration data not updated! Try Again!");
                    return redirect()->back();
                }
                    

        //dd($sendtosap);
        
    }
        else{
            return redirect()->route('newcustomer_home');
        }
            
    }

    public function getregistereddata(Request $request)
    {
        if ($request->session()->has('customersession')) {
        
            $encrypt = $request->session()->get('customersession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $customerid = $split[0];

            $getproject = DB::connection('mysql3')->table('projects')->where('cust_id', '=', $customerid)->get();

        $tosap = [];
        $tosap['Customer_id'] = $customerid;
        $tosap['Plant'] = $request->project;
        $tosap['Unit'] = $request->unit;
        $getdata = $this->getpostedreg_details__to_sap($tosap);

        return json_encode($getdata);

    }
    else{
        return redirect()->route('newcustomer_home');
    }

    }

    public function checksale_agreement_taken(Request $request)
    {
        if ($request->session()->has('customersession')) {
        
            $encrypt = $request->session()->get('customersession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $customerid = $split[0];

            $validate = $this->validate($request, [
                'project' => 'required',
                'unit' => 'required'
                ]);

                $tosap = [];
                $tosap['Customer_No'] = $customerid;
                $tosap['Plant'] = $request->project;
                $tosap['Unit'] = $request->unit;

                $getdata = $this->checksale_agreement_takenfromsap($tosap);

                return json_encode($getdata);



        }
        else{
            return redirect()->route('newcustomer_home');
        }
    }

    public function saleregopen($customerid)
    {
        if (ctype_digit($customerid) === true) {
            $getdata = DB::connection('mysql3')->table('customer')->where(['id' => $customerid ])->get();
            if (count($getdata) > 0) {
                foreach ($getdata as $vkey => $vvalue) {
                    $customerdata = [];
                    $customerdata['Customer_ID'] = $vvalue->id;
                    $customerdata['Customer_Name'] = $vvalue->name;
                    $customerdata['Mobile_No'] = $vvalue->mobile;
                    $customerdata['E_Mail'] = $vvalue->email;
                }
            }
            else{
                $customerdata = $this->getCustomer($customerid);
            }
            if ($customerdata['Customer_Name'] != '') {
                //echo substr($customerdata['Mobile_No'],0,2);
                $mobile = substr($customerdata['Mobile_No'], 0, 2) . '*****' . substr($customerdata['Mobile_No'],  -3);
                $email = substr($customerdata['E_Mail'], 0, 3) . '****@' . substr($customerdata['E_Mail'], strpos($customerdata['E_Mail'], "@") + 1);
                $customerid = ltrim($customerdata['Customer_ID'], '0');
                return view('newcustomerzone.salereg')->with(['mobile' => $mobile,'email' => $email,'customerid' => $customerid]);
            }
            else{
                dd('Not Valid');
            }
            
        }
        else{
            dd('not valid');
        }
       
    }

    public function postsaleregopen(Request $request, $customerid)
    {
        
        $attribute = [
            'otp' => 'One Time Password'
        ];
        $validate = $this->validate($request, [
            'otp' => 'required|integer|min:10000'
        ],[],$attribute);

        $getdata = DB::connection('mysql3')->table('sale_agreement_otp')->where(['customerid' => $customerid, 'otp_created_date'=>Carbon::now()->toDateString(),'otp' => $request->otp ])->get();
        if (count($getdata) > 0) {
            foreach ($getdata as $key => $value) {
                $otp_gen_datetime = $value->otp_created_date.' '.$value->otp_created_time;
                $add15min = Carbon::parse($otp_gen_datetime)->addMinutes(15);
                if (Carbon::now()->gt($add15min)) {
                    $request->session()->flash("error_msg", "Sorry! Session Expired. Generate a new OTP.");
                    return redirect()->back()->withInput();    
                }
                else{
                    $getcustomer = DB::connection('mysql3')->table('customer')->where(['id' => $customerid])->get();   
//dd($getcustomer);
                    if (count($getcustomer) > 0) {
                        foreach ($getcustomer as $nkey => $nvalue) {
                            $pass = $nvalue->password;
                        }
                        $notp = rand(100000,999999);
                        DB::connection('mysql3')->table('sale_agreement_otp')->where(['customerid' => $customerid, 'otp_created_date'=>Carbon::now()->toDateString(),'otp' => $request->otp ])
                        ->update(['otp' => $notp ]);
                        $request->session()->put('saleagree', 'yes');
                         
                        echo '
                        <div style="text-align:center">Please Wait, Redirecting to VGN Customer KYC Details Update Page...</div>
                        <form id="loginform" method="POST" action="https://www.vgn.in/customerzone/customerlogin" style="display:none;">
                            <input type="hidden" name="_token" value="'.csrf_token().'">
                                <input type="text" class="form-control" name="username" id="cid"  value="'.$customerid.'" placeholder="Customer-Id/EmailId/Mobile No.">
                                <input type="password" class="form-control" name="password" value="'.$pass.'" id="pwd">
                              <button type="submit" class="btn btn-danger btn-block btn-flat">Sign In</button>
                            </form><script>document.getElementById("loginform").submit();</script>
                        ';
                        
                    }


                    
                    
                }
            }
        }
        else{
                $request->session()->flash("error_msg", "Sorry! Enter a valid OTP.");
                return redirect()->back()->withInput();
        }
        
    }

    public function generate_otp(Request $request)
    {
        $validate = $this->validate($request, [
            'customerid' => 'required'
            ]);

            $customerid = $request->customerid;

            if (ctype_digit($customerid) === true) {
                $getdata1 = DB::connection('mysql3')->table('customer')->where(['id' => $customerid ])->get();
            if (count($getdata1) > 0) {
                foreach ($getdata1 as $vkey => $vvalue) {
                    $customerdata = [];
                    $customerdata['Customer_ID'] = $vvalue->id;
                    $customerdata['Customer_Name'] = $vvalue->name;
                    $customerdata['Mobile_No'] = $vvalue->mobile;
                    $customerdata['E_Mail'] = $vvalue->email;
                }
            }
            else{
                $customerdata = $this->getCustomer($customerid);
            }
                if ($customerdata['Customer_Name'] != '') {
                    //echo substr($customerdata['Mobile_No'],0,2);
                    $mobile = $customerdata['Mobile_No'];
                    $email =  $customerdata['E_Mail'];
                    $customerid = ltrim($customerdata['Customer_ID'], '0');
                    $otp = rand(100000,999999);

                    $newmaildata = [];
                    $newmaildata['name'] = $customerdata['Customer_Name'];
                    $newmaildata['otp'] = $otp;
                    $newmaildata['content'] = 'Your One Time Password for KYC Details Update is';
                    
                    $getprevattempt = DB::connection('mysql3')->table('sale_agreement_otp')->where(['customerid' => $customerid, 'otp_created_date'=>Carbon::now()->toDateString() ])->get();

                    if (count($getprevattempt) > 0) {
                        foreach ($getprevattempt as $key => $value) {
                            $prev_attempt = $value->attempt;
                            $lastrecordeddatetime = $value->otp_created_date.' '.$value->otp_created_time;
                            $tried_set = $value->tried_set;
                            $hourstart = $value->hourstart;
                        }


                        if ($prev_attempt >= 5) {
                            if (Carbon::now()->lt(Carbon::parse($hourstart))) {
                                return 'Maximum Number of attempts tried. Try after '.Carbon::parse($hourstart)->format('d.m.Y h:i A').'.';
                            }
                            else{

                                $smscontent = 'Dear '.$customerdata['Customer_Name'].', Your One Time Password for KYC Details Update is '.$otp; 
                                $sms_status = $this->smscurl($smscontent, $mobile);

                                if (!empty($email)) {
                                    Log::info('Seding Email for sale agreement = '.$email);
                                    Mail::to($email)->send(new saleagreementmail($newmaildata));
                                }
                                


                                $prev_attempt = 0;
                            DB::connection('mysql3')->table('sale_agreement_otp')->where([
                                'customerid' => $customerid,
                                'otp_created_date' => Carbon::now()->toDateString()
                                ])->update([
                                    'tried_set' => $tried_set + 1 ,
                                    'attempt' => $prev_attempt + 1,
                                    'hourstart' => Carbon::now()->addMinutes(30)->toDatetimeString(),
                                    'otp_created_time' => Carbon::now()->toTimeString(),
                                    'otp' => $otp
                                ]);

                                return 'OTP Sent to your registered mailid and mobile no.';

                            }
                        }
                        else{
                            $smscontent = 'Dear '.$customerdata['Customer_Name'].', Your One Time Password for KYC Details Update is '.$otp; 
                            $sms_status = $this->smscurl($smscontent, $mobile);
                            if (!empty($email)) {
                                Log::info('Seding Email for sale agreement = '.$email);
                                Mail::to($email)->send(new saleagreementmail($newmaildata));
                            }

                            DB::connection('mysql3')->table('sale_agreement_otp')->where([
                                'customerid' => $customerid,
                                'otp_created_date' => Carbon::now()->toDateString()
                                ])->update([
                                    'tried_set' => $tried_set,
                                    'attempt' => $prev_attempt + 1,
                                    'hourstart' => $hourstart,
                                    'otp_created_time' => Carbon::now()->toTimeString(),
                                    'otp' => $otp
                                ]);

                                return 'OTP Sent to your registered mailid and mobile no.';

                        }



                    }
                    else{
                        $prev_attempt = 0;
                        $tried_set = 0;

                        $smscontent = 'Dear '.$customerdata['Customer_Name'].', Your One Time Password for KYC Details Update is '.$otp; 
                        $sms_status = $this->smscurl($smscontent, $mobile);
                        if (!empty($email)) {
                            Log::info('Seding Email for sale agreement = '.$email);
                            Mail::to($email)->send(new saleagreementmail($newmaildata));
                        }

                        $storeotp = DB::connection('mysql3')->table('sale_agreement_otp')->insert([
                            'customerid' => $customerid,
                            'mobile' => $mobile,
                            'email' => $email,
                            'hourstart' => Carbon::now()->addMinutes(30)->toDatetimeString(),
                            'otp_created_date' => Carbon::now()->toDateString(),
                            'otp_created_time' => Carbon::now()->toTimeString(),
                            'otp' => $otp,
                            'tried_set' => $tried_set + 1 ,
                            'attempt' => $prev_attempt + 1
                        ]);
                    }


                    return 'OTP Sent to your Registered EmailId and Mobile Number.';
                }
                else{
                    return 'Not a Valid Customer. Contact Customer Support.';
                }
                
            }
    }

    public function open_salesprocess_feedback($uniquekey)
    {
        if (!empty($uniquekey)) {
            if (strpos($uniquekey,'_') !== false) {
                $arr = explode('_',$uniquekey);
                //(186*3)+4321
                if (ctype_digit($arr[1])) {
                    $getcustomerid = ($arr[1] - 4321)/3;
                    $getcustomer = DB::connection('mysql3')->table('customer')->where(['id' => $getcustomerid])->get();   
                    if (count($getcustomer) > 0) {
                        foreach ($getcustomer as $key => $value) {
                            $name = $value->name;
                        }
                    }
                    else{
                        $sapdata = $this->getCustomer($getcustomerid);
                        if ($sapdata['Customer_Name'] != '') {
                            $name = $sapdata['Customer_Name'];
                        }
                        else{
                            return redirect()->route('newcustomer_home');
                        }
                    }

                    
                    $checkexists = DB::connection('mysql3')->table('saleprocess_feedback')->where(['customerid' => $getcustomerid, 'saleorder' => $arr[0]])->get();
                    if (count($checkexists) > 0) {
                        foreach ($checkexists as $nkey => $nvalue) {
                            $status = $nvalue->feedback;
                        }
                    }
                    else{
                        $status = '';
                    }

                    
                }else{
                    return redirect()->route('newcustomer_home');
                }
                
            }
            else{
                return redirect()->route('newcustomer_home');
            }

            return view('newcustomerzone.salesprocess_feedback')->with(['name' => $name,'uniquekey' => $uniquekey, 'status' => $status]);
        }
        else{
            return redirect()->route('newcustomer_home');
        }
    }


    public function post_open_salesprocess_feedback(Request $request)
    {
        $validate = $this->validate($request, [
            'unique_key' => 'required',
            'status' => 'required|in:Y,N'
            ]);

            if (!empty($request->unique_key)) {
                $uniquekey = $request->unique_key;

                if (strpos($uniquekey,'_') !== false) {
                    $arr = explode('_',$uniquekey);
                    //(186*3)+4321
                    if (ctype_digit($arr[1])) {
                        $getcustomerid = ($arr[1] - 4321)/3;
                        $getcustomer = DB::connection('mysql3')->table('customer')->where(['id' => $getcustomerid])->get();   
                        if (count($getcustomer) > 0) {
                            foreach ($getcustomer as $key => $value) {
                                $name = $value->name;
                            }
                        }
                        else{
                            $sapdata = $this->getCustomer($getcustomerid);
                            if ($sapdata['Customer_Name'] != '') {
                                $name = $sapdata['Customer_Name'];
                            }
                            else{
                                return 0;
                            }
                        }


                       $posttosap = $this->postsalesprocessfeedback($getcustomerid, $arr[0], $request->status);
                       
                        if ($posttosap['Status'] == 'Updated Successfully') {
                            $checkexists = DB::connection('mysql3')->table('saleprocess_feedback')->where(['customerid' => $getcustomerid, 'saleorder' => $arr[0]])->get();
                        $now = Carbon::now()->toDateTimeString();
                        if (count($checkexists) > 0) {
                            //update

                            DB::connection('mysql3')->table('saleprocess_feedback')->where(['customerid' => $getcustomerid, 'saleorder' => $arr[0]])
                            ->update([
                                'feedback' => $request->status,
                                'created_datetime' => $now
                                ]);

                            return 1;

                        }
                        else{
                            //insert

                            DB::connection('mysql3')->table('saleprocess_feedback')
                            ->insert([
                                'id' => null,
                                'customerid' => $getcustomerid,
                                'saleorder' => $arr[0],
                                'feedback' => $request->status,
                                'created_datetime' => $now
                                ]);
                            return 1;
                        }

                        }
                        else{
                            return 0;
                        }
                        
    
                        
                    }else{
                        return 0;
                    }
                    
                }
                else{
                    return 0;
                }

            }
            else{
                return 0;
            }
    }


public function sitevisitfeedback($leadid)
    {
        if (ctype_digit($leadid)) {


            return view('newcustomerzone.sitevisitfeedback')->with(['leadno' => $leadid]);
        }
        else{
            return redirect()->route('newcustomer_home');
        }
        
    }

public function postsitevisitfeedback(Request $request, $leadid)
    {
        $dec1 = $leadid - 2019;
            $dec2 = $dec1/2;
            $feedback = [];
            //dd($request);
            $feedback['Lead_No'] = $dec2;
            $feedback['Ans1'] = $request->r2;
            $feedback['Ans2'] = $request->r3;
            $feedback['Ans3'] = $request->r4;
            $feedback['Creation_Date'] = Carbon::now()->toDateString();
            $feedback['Creation_Time'] = Carbon::now()->toTimeString();
            $posttosap_svfb = $this->postsapsalesitefeedback($feedback);
            //dd($posttosap_svfb);
            if (array_key_exists('Status', $posttosap_svfb)) {
                if ($posttosap_svfb['Status'] == 'Updated Successfully') {
                     $request->session()->flash("suc_msg", "Thanks for your valuable feedback!");
                     return redirect()->back();
                }
                else{
                     $request->session()->flash("error_msg", "Sorry! Your feedback not updated. Try Again");
                     return redirect()->back();
                }
            }
            else{
                return redirect()->route('newcustomer_home');
            }
            //dd($posttosap_svfb);
        
    }


public function modifiedforgotpwd(Request $request)
    {
            $validate = $this->validate($request, [
            'forgotusername' => 'required'
            ]);


 if (strpos($request->forgotusername, '@') !== false) {
            $loginmode = 'loginmode_emailid';
        }
        elseif (ctype_digit($request->forgotusername)) {

            if (strlen($request->forgotusername) == 10) {
                $loginmode = 'loginmode_mobileno';
            }
            elseif((strlen($request->forgotusername) >= 3)&&(strlen($request->forgotusername) < 10)){
                $loginmode = 'loginmode_customerid';
            }
            else{
                
                return 0;
            }
                
        }
        else{
                return 0;
        }

        $arr = [];
        if ($loginmode == 'loginmode_customerid') {
            $arr['Cust_ID'] = $request->forgotusername;
            $arr['Mobile_No'] = '';
            $arr['E_Mail'] = '';
        }
        if ($loginmode == 'loginmode_mobileno') {
            $arr['Cust_ID'] = '';
            $arr['Mobile_No'] = $request->forgotusername;
            $arr['E_Mail'] = '';
        }
        if ($loginmode == 'loginmode_emailid') {
            $arr['Cust_ID'] = '';
            $arr['Mobile_No'] = '';
            $arr['E_Mail'] = $request->forgotusername;
        }

        if (!empty($arr)) {
            $res = $this->checkcustomer($arr);
            if ($res['Name'] == '0') {
                return 'Invalid User. Try with valid username';
            }
            if (($res['Mobile_No'] == '0') && ($res['E_Mail'] == '0')) {
                return 'Please contact Customer Care. Your registered mobile number and mail id is blank!';
            }

            if (($res['Cust_ID'] != '0') && ($res['Name'] != '0') ) {
                $todaydateonly = Carbon::now()->toDateString();
                

                $checktodaysdateexist = DB::connection('mysql3')->table('forgotpwdotp_confirmation')->where(['cust_id' => $res['Cust_ID']])->where('created_datetime','LIKE','%'.$todaydateonly.'%')->count();
                $otp = rand(0,189999);
                $now = Carbon::now()->toDateTimeString();
                
                $expirytime = Carbon::now()->addMinutes(5)->toDateTimeString();
                //start
                if ($checktodaysdateexist == 0) {
                    //generate otp and send to customer
                    $smscontent = "Dear ".$res['Name'].", Your Customer Login Forgot Password OTP is ".$otp; 
                if($res['Mobile_No'] != '0'){
               $sms_status = $this->smscurl($smscontent, $res['Mobile_No']);
                    }
                    $newmaildata = [];
                    $newmaildata['name'] = $res['Name'];
                    $newmaildata['otp'] = $otp;
                    $newmaildata['subject'] = "VGN Customer Login Forgot Password OTP";
                    $newmaildata['content'] = "Your One Time Password for Customer Login Forgot Password is $otp";
                    if($res['E_Mail'] != '0'){
               Log::info('Sending forgot pwd otp = '.$res['E_Mail']);
                                    Mail::to($res['E_Mail'])->send(new sendforgotpwdotp($newmaildata));
                                }
               
                    //insert record in db
                    //return otp submit page
                     DB::connection('mysql3')->table('forgotpwdotp_confirmation')->insert(['cust_id' => $res['Cust_ID'],'otp' => $otp,'created_datetime' => $now,'validity_datetime' => $expirytime,'tried_count' => 1]);

                    return 1;
                }
                else{
                    $getdata1 = DB::connection('mysql3')->table('forgotpwdotp_confirmation')->where(['cust_id' => $res['Cust_ID']])->where('created_datetime','LIKE','%'.$todaydateonly.'%')->get();

                    foreach ($getdata1 as $key_getdata1 => $value_getdata1) {
                        $triedcount = $value_getdata1->tried_count;
                        $createdtime = $value_getdata1->created_datetime;
                        $extime = $value_getdata1->validity_datetime;
                    }

                    if ($triedcount <= 5) {

                         $smscontent = "Dear ".$res['Name'].", Your Customer Login Forgot Password OTP is ".$otp; 
                if($res['Mobile_No'] != '0'){
               $sms_status = $this->smscurl($smscontent, $res['Mobile_No']);
                    }
                    $newmaildata = [];
                    $newmaildata['name'] = $res['Name'];
                    $newmaildata['otp'] = $otp;
                    $newmaildata['subject'] = "VGN Customer Login Forgot Password OTP";
                    $newmaildata['content'] = "Your One Time Password for Customer Login Forgot Password is $otp";
                    if($res['E_Mail'] != '0'){
               Log::info('Sending forgot pwd otp = '.$res['E_Mail']);
                                    Mail::to($res['E_Mail'])->send(new sendforgotpwdotp($newmaildata));
                                }

                        //update 
                        $add1hour = Carbon::parse($createdtime)->addhours(1)->toDateTimeString();
                        if (Carbon::now()->gte(Carbon::parse($add1hour))) {
                            DB::connection('mysql3')->table('forgotpwdotp_confirmation')->where(['cust_id' => $res['Cust_ID']])->where('created_datetime','LIKE','%'.$todaydateonly.'%')->update([
                                'otp' => $otp,
                                'created_datetime' => $now,
                                'validity_datetime' => $expirytime, 
                                'tried_count' => 1 ]);

                            return 1;
                        }
                        else{

                             $smscontent = "Dear ".$res['Name'].", Your Customer Login Forgot Password OTP is ".$otp; 
                if($res['Mobile_No'] != '0'){
               $sms_status = $this->smscurl($smscontent, $res['Mobile_No']);
                    }
                    $newmaildata = [];
                    $newmaildata['name'] = $res['Name'];
                    $newmaildata['otp'] = $otp;
                    $newmaildata['subject'] = "VGN Customer Login Forgot Password OTP";
                    $newmaildata['content'] = "Your One Time Password for Customer Login Forgot Password is $otp";
               Log::info('Sending forgot pwd otp = '.$res['E_Mail']);
               if($res['E_Mail'] != '0'){
                                    Mail::to($res['E_Mail'])->send(new sendforgotpwdotp($newmaildata));
                                }

                        DB::connection('mysql3')->table('forgotpwdotp_confirmation')->where(['cust_id' => $res['Cust_ID']])->where('created_datetime','LIKE','%'.$todaydateonly.'%')->update([
                                'otp' => $otp,
                                'validity_datetime' => $expirytime, 
                                'tried_count' => $triedcount+1 ]);

                        return 1;
                        }
                    }
                    else{
                         

                        $add1hour = Carbon::parse($createdtime)->addhours(1)->toDateTimeString();

                        if (Carbon::now()->gte(Carbon::parse($add1hour))) {

                            $smscontent = "Dear ".$res['Name'].", Your Customer Login Forgot Password OTP is ".$otp; 
                if($res['Mobile_No'] != '0'){
               $sms_status = $this->smscurl($smscontent, $res['Mobile_No']);
                    }
                    $newmaildata = [];
                    $newmaildata['name'] = $res['Name'];
                    $newmaildata['otp'] = $otp;
                    $newmaildata['subject'] = "VGN Customer Login Forgot Password OTP";
                    $newmaildata['content'] = "Your One Time Password for Customer Login Forgot Password is $otp";
                    if($res['E_Mail'] != '0'){
               Log::info('Sending forgot pwd otp = '.$res['E_Mail']);
                                    Mail::to($res['E_Mail'])->send(new sendforgotpwdotp($newmaildata));
                                }
                                
                            DB::connection('mysql3')->table('forgotpwdotp_confirmation')->where(['cust_id' => $res['Cust_ID']])->where('created_datetime','LIKE','%'.$todaydateonly.'%')->update([
                                'otp' => $otp,
                                'created_datetime' => $now,
                                'validity_datetime' => $expirytime, 
                                'tried_count' => 1 ]);

                            return 1;
                        }
                        else{
                            
                            return "Try After 1 hour. Maximum number of attempts reached.";
                        }
                        
                        //get last created datetime
                        //reset createdtime and send otp
                    }


                }

                //end

               
                
            }else{
                return 0;
            }







            return json_encode($res);
        }else{ return 0;}

        
    }


    public function otpvalidation(Request $request)
    {
         $validate = $this->validate($request, [
            'forgotusername' => 'required'
            ]);


 if (strpos($request->forgotusername, '@') !== false) {
            $loginmode = 'loginmode_emailid';
        }
        elseif (ctype_digit($request->forgotusername)) {

            if (strlen($request->forgotusername) == 10) {
                $loginmode = 'loginmode_mobileno';
            }
            elseif((strlen($request->forgotusername) >= 3)&&(strlen($request->forgotusername) < 10)){
                $loginmode = 'loginmode_customerid';
            }
            else{
                
                return 0;
            }
                
        }
        else{
                return 0;
        }

        $arr = [];
        if ($loginmode == 'loginmode_customerid') {
            $arr['Cust_ID'] = $request->forgotusername;
            $arr['Mobile_No'] = '';
            $arr['E_Mail'] = '';
        }
        if ($loginmode == 'loginmode_mobileno') {
            $arr['Cust_ID'] = '';
            $arr['Mobile_No'] = $request->forgotusername;
            $arr['E_Mail'] = '';
        }
        if ($loginmode == 'loginmode_emailid') {
            $arr['Cust_ID'] = '';
            $arr['Mobile_No'] = '';
            $arr['E_Mail'] = $request->forgotusername;
        }


        if (!empty($arr)) {
            $res = $this->checkcustomer($arr);

            if (($res['Cust_ID'] != '0') && ($res['Name'] != '0')) {
                $now = Carbon::now()->toDateTimeString();
                $todaystring = Carbon::now()->toDateString();
                $add5min = Carbon::now()->addMinutes(5)->toDateTimeString();
                

                $checkotpmatch = DB::connection('mysql3')->table('forgotpwdotp_confirmation')->where(['cust_id' => $res['Cust_ID'],'otp' => $request->submitotp])->where('validity_datetime','<=',$add5min)->count();
                if ($checkotpmatch == '1') {
                    $todaystring1 = str_replace('-', '', $todaystring);
                    $toencrypt = $res['Cust_ID'].'-#'.$request->submitotp.'-#'.$todaystring1;
                    $encrypt = Crypt::encrypt($toencrypt);

                    $request->session()->put('resetpwd', $encrypt);
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
        else{
            return 0;
        }



    }

    public function resetlink(Request $request)
    {
        if ($request->session()->has('resetpwd')) {
            $encrypt = $request->session()->get('resetpwd');
            $decrypt = Crypt::decrypt($encrypt);
            //dd($decrypt);
            $split = explode("-#",$decrypt);
            
            $customerid = $split[0];
            $otp = $split[1];
            $todaydateonly = Carbon::now()->toDateString();

            $checktodaysdateexist = DB::connection('mysql3')->table('forgotpwdotp_confirmation')->where(['cust_id' => $customerid,'otp' => $otp])->where('created_datetime','LIKE','%'.$todaydateonly.'%')->count();

            if ($checktodaysdateexist == 1) {
                return view('newcustomerzone.resetlink');
            }
            else{
                $request->session()->forget('resetpwd');
                return redirect()->back();
            }

        }
        else{
            return redirect()->route('newcustomer_home');
        }
    }

    public function postresetlink(Request $request)
    {
        if ($request->session()->has('resetpwd')) {
            $encrypt = $request->session()->get('resetpwd');
            $decrypt = Crypt::decrypt($encrypt);
            //dd($decrypt);
            $split = explode("-#",$decrypt);

            $customerid = $split[0];
            $otp = $split[1];
            $todaydateonly = Carbon::now()->toDateString();

            $checktodaysdateexist = DB::connection('mysql3')->table('forgotpwdotp_confirmation')->where(['cust_id' => $customerid,'otp' => $otp])->where('created_datetime','LIKE','%'.$todaydateonly.'%')->count();

            if ($checktodaysdateexist == 1) {
                    
                    if (($request->newpass != '')&&(($request->retypepass != ''))) {

                if (($request->newpass != $request->retypepass)) {
                $request->session()->flash("error_msg", "New Password and Retype Password must be same!");
                return redirect()->back()->withInput();
                }
                else{

                    //do the updation and redirect to customerlogin
                    $checkindb = DB::connection('mysql3')->table('customer')->where(['id' => $customerid])->count();

                    $arr = [];
            $arr['Cust_ID'] = $customerid;
            $arr['Mobile_No'] = '';
            $arr['E_Mail'] = '';
            $res = $this->checkcustomer($arr);

                    if ($checkindb == 1) {
                        DB::connection('mysql3')->table('customer')->where(['id' => $customerid])->update(['password' => Hash::make($request->newpass, ['rounds' => 12]),'name' => $res['Name'],'mobile' => $res['Mobile_No'],'email' => $res['E_Mail'], 'pwd_updated' => Carbon::now()->toDateTimeString(),'pwd_count' => 1]);
                    }
                    else{
                        DB::connection('mysql3')->table('customer')->insert(['id' => $customerid,'password' => Hash::make($request->newpass, ['rounds' => 12]),
                            'valid' => 1,
                            'name' => $res['Name'],
                            'street1' => '',
                            'street2' => '',
                            'street3' => '',
                            'houseno' => '',
                            'city' => '',
                            'pin' => 0,
                            'country' => '',
                            'region' => '',
                            'tel' => '',
                            'mobile' => $res['Mobile_No'],
                            'fax' => '',
                            'email' => $res['E_Mail'],
                            'comp_raised' =>0,
                            'comp_closed' => 0,
                            'comp_pending' => 0,
                            'net_amt' => 0,
                            'nou' => 0,
			    'pwd_updated' => Carbon::now()->toDateTimeString(),
                            'pwd_count' => 1,
                            'created' => Carbon::now()->toDateTimeString()

                    ]);
                    }

                    DB::connection('mysql3')->table('forgotpwdotp_confirmation')->where(['cust_id' => $customerid,'otp' => $otp])->delete();

                    $request->session()->forget('resetpwd');
                $request->session()->flash("suc_msg", "Password Successfully Updated. Please try to login.");
                return redirect()->route('newcustomer_home');

                }

            }
            else{
                $request->session()->flash("error_msg", "Please fill the required fields!");
                return redirect()->back()->withInput();
            }


            }
            else{
                $request->session()->forget('resetpwd');
                $request->session()->flash("error_msg", "Invalid Reset Link. Try with forgot password!");
                return redirect()->route('newcustomer_home');
            }

            
            

            

            

        }
        else{
            return redirect()->back();
        }
    }


 public function customerphotoupload(Request $request)
    {
         if ($request->session()->has('customersession')) {
             $encrypt = $request->session()->get('customersession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $customerid = $split[0];
            $getcustomerdata = DB::connection('mysql3')->table('customer')->where('id', '=', $customerid)->get();
            $getproject = DB::connection('mysql3')->table('projects')->where('cust_id', '=', $customerid)->get();
            $getblockdates = DB::connection('mysql3')->table('projects')->where('cust_id', '=', $customerid)->where('exp_date_of_compl', '!=', '')->get();

            $pwd_status = $this->is_cust_didnt_passwordchanged($customerid);
            if ($pwd_status == 0) {
                $request->session()->flash("error_msg", 'Please change the default password. Only if you Change the default password , other functionalities on this portal will work. This is done for security purposes. Please do not share your password with anyone');
                return redirect()->route('newcustomer_mydetails_passchange');
            }
            
            
             $listfiles = Storage::disk('s3')->files("/newcustomerzoneassets/customersprofileimage/".$customerid);
             
             if(count($listfiles) > 0){
                $profilepic = config('app.AWS_URL')."/".$listfiles[0];
            }
             else
             {
                $profilepic = config('app.AWS_URL')."/newcustomerzoneassets/img/dummy_male.png";
             }
            
            return view('newcustomerzone.customerphotoupload')->with(['getcustomerdata'=> $getcustomerdata, 'getproject' => $getproject, 'profilepic' => $profilepic,'getblockdates' => $getblockdates]);
        }
        return view('newcustomerzone.login');
    }


    public function csphotouploadgetdata(Request $request)
    {
        if ($request->session()->has('customersession')) {
             $encrypt = $request->session()->get('customersession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $customerid = $split[0];
            $getcustomerdata = DB::connection('mysql3')->table('customer')->where('id', '=', $customerid)->get();
            $getproject = DB::connection('mysql3')->table('projects')->where('cust_id', '=', $customerid)->get();

            $arr = [];
            $arr['Customer_ID'] = $customerid;
            $arr['Plant_Code'] = $request->proj;
            $arr['Unit_No'] = $request->unit;

            $getbhkdetails = $this->getbhkdetails($arr);
            $bhkelig = ['1' => 3, '2' => 5, '3' => 7, '4' => 9, '5' => 12];

            $newresarr = [];
            if (!empty($getbhkdetails['Number_of_BHK'])) {
                $newresarr['photocanbeuploaded'] = 'yes';
                $newresarr['noofphotoseligible'] = $bhkelig[$getbhkdetails['Number_of_BHK']];
                $newresarr['description'] = 'Note: You can upload maximum of '.$bhkelig[$getbhkdetails['Number_of_BHK']].' photos.You can update the details until customercare complete the id card process.';
            }
            

            return json_encode($newresarr);

             
            
            return 1;
        }
        return 0;
    }

    public function customerphoto_nameupdate(Request $request)
    {
        if ($request->session()->has('customersession')) {
             $encrypt = $request->session()->get('customersession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $customerid = $split[0];

            $newname = $request->newname;
            $id = $request->id;

            if (!empty($newname) && !empty($id)) {
                $updatename = DB::connection('mysql3')->table('customerphotoupload')->where(['customerid' => $customerid,'id'=> $id])->update(['name' => $newname]);
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




public function postcustomerphotoupload(Request $request)
{
    if ($request->session()->has('customersession')) {
             $encrypt = $request->session()->get('customersession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $customerid = $split[0];
            //dd($customerid);

    if(isset($_REQUEST["image"]))
{
    $data = $_REQUEST["image"];

    $image_array_1 = explode(";", $data);

    $image_array_2 = explode(",", $image_array_1[1]);

    $data = base64_decode($image_array_2[1]);

            $Plant_Code = $request->plantcode;
            $Unit_No = $request->unitno;
            $profilename = $request->profilename;

            $arr = [];
            $arr['Customer_ID'] = $customerid;
            $arr['Plant_Code'] = $Plant_Code;
            $arr['Unit_No'] = $Unit_No;

            $getbhkdetails = $this->getbhkdetails($arr);

            $bhkelig = ['1' => 3, '2' => 5, '3' => 7, '4' => 9, '5' => 12];

            if (!empty($getbhkdetails['Number_of_BHK'])) {
                $imageName = $customerid.time() . '.jpg';

                $getuploadedcount = DB::connection('mysql3')->table('customerphotoupload')->where(['customerid' => $customerid,'plantcode'=> $Plant_Code,'unitcode'=>$Unit_No])->count();
                $newcount = $getuploadedcount + 1;
                if ($newcount <= $bhkelig[$getbhkdetails['Number_of_BHK']]) {
                    
                    DB::connection('mysql3')->table('customerphotoupload')->insert(['customerid' => $customerid,
                        'name'=> $profilename,
                        'executiveid'=>$getbhkdetails['Executive_ID'],
                        'managerid'=>$getbhkdetails['Manager_ID'],
                        'saleorder'=>$getbhkdetails['Sale_Order'],
                        'plantcode'=>$Plant_Code,
                        'plantname' => $getbhkdetails['Plant_Name'],
                        'unitcode'=>$Unit_No,
                        'unitname' => $getbhkdetails['Unit_Name'],
                        'no_of_bhk' => $getbhkdetails['Number_of_BHK'],
                        'no_of_carpark' => $getbhkdetails['Number_of_Carpark'],
                        'reference_text' => $getbhkdetails['Reference_Text'],
                        'filename'=>$imageName,
                        'uploaded_date'=> Carbon::now()->toDateTimeString(),
                        'taken_print_out'=> 'N',
                        'printout_taken_date' => null
                    ]);

                }
                else{
                    return '-1';
                }

               file_put_contents(public_path().'/data_mnt/customeridcards/'.$imageName, $data);
		//Storage::disk('s3')->put('/customeridcards/'.$imageName, $data);

    echo '<img src="//d2qetrl79qxrcm.cloudfront.net/customeridcards/'.$imageName.'" class="img-thumbnail" />';
            }
            else{
                return '-1';
            }


}
}
else{
    echo '<h5>Invalid User!</h5>';
}

}

 public function getcustomeruploadedphotos(Request $request)
 {
     if ($request->session()->has('customersession')) {
             $encrypt = $request->session()->get('customersession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $customerid = $split[0];
            $Plant_Code = $request->proj;
            $Unit_No = $request->unit;

           $checkprojectisapartment = DB::connection('mysql')->table('projectlist')->where(['plantcode' => $Plant_Code,'Type' => 'Apartments'])->count();
           if ($checkprojectisapartment == 0) {
               return -1;
           }

            $getuploadeddata = DB::connection('mysql3')->table('customerphotoupload')->where(['customerid' => $customerid,'plantcode'=> $Plant_Code,'unitcode'=>$Unit_No])->get();

            if (count($getuploadeddata) > 0) {
                return json_encode($getuploadeddata);
            }
            else{
                return 0;
            }

        }
        else{
            return 0;
        }
 }

 public function deleteuploadedphoto(Request $request)
 {
     if ($request->session()->has('customersession')) {
             $encrypt = $request->session()->get('customersession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $customerid = $split[0];
            $Plant_Code = $request->plantcode;
            $Unit_No = $request->unitcode;
            $deleteid = $request->deleteid;

            $getuploadeddata = DB::connection('mysql3')->table('customerphotoupload')->where(['id' => $deleteid,'customerid' => $customerid,'plantcode'=> $Plant_Code,'unitcode'=>$Unit_No,'taken_print_out' => 'N'])->get();

            if (count($getuploadeddata) > 0) {
                foreach ($getuploadeddata as $key => $value) {
                    $filename = $value->filename;
                }
                unlink(public_path().'/data_mnt/customeridcards/'.$filename);
		//Storage::disk('s3')->delete('/customeridcards/'.$filename);
                DB::connection('mysql3')->table('customerphotoupload')->where(['id' => $deleteid,'taken_print_out' => 'N'])->delete();
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



public function interior_design_interested_survey($saleordernumber)
    {
        if (ctype_digit($saleordernumber)) {
            $decrypt1 = $saleordernumber/2;
            $decrypt = $decrypt1 - 2019;

            return view('newcustomerzone.interior_interested_survey')->with(['saleorderno' => $saleordernumber]);
            //dd($decrypt);
        }
        else{
            return redirect()->route('newcustomer_home');
        }
    }

    public function post_interior_design_interested_survey(Request $request,$saleordernumber)
    {
        $requested_saleorderno = $request->saleorderno;
        if (ctype_digit($saleordernumber)) {
            $decrypt1 = $saleordernumber-2019;
            $decrypt = $decrypt1/2;

            $posted_result = $this->postinteriors_interest(trim($decrypt));
            //return $posted_result;

            if ($posted_result['Status'] == 'Success') {
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

public function homebuilding_interested_survey($saleordernumber)
    {
        if (strpos($saleordernumber, '_') !== false) {
    $param = explode('_', $saleordernumber);
    if (ctype_digit($param[1])) {
       $saleordernumber1 = $param[0];
        $res = DB::connection('mysql')->table('projectlist')->select('Project_name')->where('plantcode', '=', $param[1])->get();
        if (!empty($res) ) {
            $plant_text = ' at VGN '.$res[0]->Project_name;
            //dd($plant_text);
        }
        else{
            $plant_text = '';
        }
    }
    else{
        return redirect()->route('newcustomer_home');
    }
    //dd($param1);
}
else{
    return redirect()->route('newcustomer_home');
}
        if (ctype_digit($saleordernumber1)) {
            $decrypt1 = $saleordernumber1/2;
            $decrypt = $decrypt1 - 2019;

            return view('newcustomerzone.homebuilding_interested_survey')->with(['saleorderno' => $saleordernumber1,'plant_text' => $plant_text]);
            //dd($decrypt);
        }
        else{
            return redirect()->route('newcustomer_home');
        }
    }

    public function post_homebuilding_interested_survey(Request $request,$saleordernumber)
    {
        $requested_saleorderno = $request->saleorderno;
        if (ctype_digit($saleordernumber)) {
            $decrypt1 = $saleordernumber-2019;
            $decrypt = $decrypt1/2;

            $posted_result = $this->posthomebuilding_interest(trim($decrypt));
            //return $posted_result;

            if ($posted_result['Status'] == 'Success') {
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

public function occupantdetailsshow(Request $request)
    {
        if ($request->session()->has('customersession')) {
            $encrypt = $request->session()->get('customersession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $customerid = $split[0];
            $getcustomerdata = DB::connection('mysql3')->table('customer')->where('id', '=', $customerid)->get();
            $projects = DB::connection('mysql3')->table('projects')->where('cust_id', '=', $customerid)->where(['posession' => 'X'])->get();

            $pwd_status = $this->is_cust_didnt_passwordchanged($customerid);
            if ($pwd_status == 0) {
                $request->session()->flash("error_msg", 'Please change the default password. Only if you Change the default password , other functionalities on this portal will work. This is done for security purposes. Please do not share your password with anyone');
                return redirect()->route('newcustomer_mydetails_passchange');
            }
            //dd($projects);
            $getblockdates = DB::connection('mysql3')->table('projects')->where('cust_id', '=', $customerid)->where('exp_date_of_compl', '!=', '')->get();

            $occupantdetails = DB::connection('mysql3')->table('securitydetailformdata')->where('customerid', '=', $customerid)->orderBy('last_updated_time', 'desc')->get();

            
            
             $listfiles = Storage::disk('s3')->files("/newcustomerzoneassets/customersprofileimage/".$customerid);
             
             if(count($listfiles) > 0){
                $profilepic = config('app.AWS_URL')."/".$listfiles[0];
            }
             else
             {
                $profilepic = config('app.AWS_URL')."/newcustomerzoneassets/img/dummy_male.png";
             }
           //dd($occupantdetails);
            return view('newcustomerzone.occupantdetailsupdate')->with(['getcustomerdata'=> $getcustomerdata, 'projects' => $projects, 'profilepic' => $profilepic,'getblockdates' => $getblockdates,'occupantdetails' => $occupantdetails]);
        }
        else{
            return redirect()->route('newcustomer_home');
        }
        
    }

    public function getbhkdetails_service(Request $request)
    {
        $arr = [];
            $arr['Customer_ID'] = $request->customerid;
            $arr['Plant_Code'] = $request->Plant_Code;
            $arr['Unit_No'] = $request->Unit_No;
            $nooccupants = $request->no_of_occupants;

            $getbhkdetails = $this->getbhkdetails($arr);
            $bhkelig = ['1' => 3, '2' => 5, '3' => 7, '4' => 9, '5' => 12];
             if (!empty($getbhkdetails['Number_of_BHK'])) {
                //return $nooccupants;
                if ($nooccupants > $bhkelig[$getbhkdetails['Number_of_BHK']]) {
                    return 0;
                }
                //return $bhkelig[$getbhkdetails['Number_of_BHK']];
                return $nooccupants;
             }
             else{
                //return $bhkelig[$getbhkdetails['Number_of_BHK']];
                return $nooccupants;
             }
            
    }


    public function postoccupantdetailsshow(Request $request)
    {
        if ($request->session()->has('customersession')) {
            $encrypt = $request->session()->get('customersession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $customerid = $split[0];
            $getcustomerdata = DB::connection('mysql3')->table('customer')->where('id', '=', $customerid)->get();
            if (count($getcustomerdata) > 0) {
                foreach ($getcustomerdata as $key11 => $value11) {
                    $customername = $value11->name;
                }
            }
            $projects = DB::connection('mysql3')->table('projects')->where('cust_id', '=', $customerid)->where(['posession' => 'X'])->get();
            //dd($projects);
            $getblockdates = DB::connection('mysql3')->table('projects')->where('cust_id', '=', $customerid)->where('exp_date_of_compl', '!=', '')->get();

        $occup = [];
        $k = 0;
        //dd($request);
        foreach ($request->occupants['name'] as $key => $value) {
            //dd($key);
            if (($request->occupants['name'][$key] != null) || ($request->occupants['mobile'][$key] != null) || ($request->occupants['email'][$key] != null)) {

                if (($request->occupants['name'][$key] != null)) {
                    $occup[$k]['name'] = $request->occupants['name'][$key];
                $occup[$k]['mobile'] = $request->occupants['mobile'][$key];
                $occup[$k]['email'] = $request->occupants['email'][$key];
                $k++;
                }
                else{
                    $request->session()->flash("error_msg", "Please fill the occupant details!");
                    return redirect()->back()->withInput();
                }

            }
        }

        $datatodb = [];
        $datatodb['customerid'] = $customerid;
        $datatodb['customername'] = $customername;
        $datatodb['plantid'] = $request->projectid;
        $datatodb['unitno'] = $request->unitno;
        $datatodb['occupanttype'] = $request->occupanttype;
        $datatodb['occupants'] = $occup;

       $check = DB::connection('mysql3')->table('securitydetailformdata')->where(['customerid' => $customerid, 'plantid' => $request->projectid,'unitno'=>$request->unitno ])->get();

       $project_details = DB::connection('mysql3')->table('projects')->where(['cust_id' => $customerid, 'project_id' => $request->projectid,'unit'=>$request->unitno ])->get();
       foreach ($project_details as $key12 => $value12) {
               $pname = $value12->pname;
               $unitname = $value12->unit_nm;
           }


           $arr = [];
       $arr['Plant'] = $request->projectid;
       $arr['Unit_No'] = $request->unitno;
       $arr['Occupant_Type'] = $request->occupanttype;
       $arr['No_Of_Occupants'] = count($occup);
       //dd($occup);
       //$arr['Occupant_Details']['Name'] = 
       foreach ($occup as $key31 => $value31) {
            $arr['Occupant_Details'][$key31]['Name'] = $value31['name'];
            $arr['Occupant_Details'][$key31]['Mobile'] = ($value31['mobile'] != null) ? $value31['mobile'] : '';
            $arr['Occupant_Details'][$key31]['Email'] = ($value31['email'] != null) ? $value31['email'] : '';
       }
       
       $sendtosap = $this->occupantsdetails($arr);
       //dd($sendtosap);
       if ($sendtosap['Status'] == 'Updated Successfully') {
           
       
       if (count($check) > 0) {
           foreach ($check as $key222 => $value222) {
               $id = $value222->id;
               $updatedcount = $value222->updated_count;
           }

                      

            DB::connection('mysql3')->table('securitydetailformdata')->where(['id' => $id,'customerid' => $customerid,'plantid' => $request->projectid,'unitno' => $request->unitno,])->update(
                [   'typename' => $request->occupanttype,
                    'customer_name' => $customername,
                    'plantid' => $request->projectid,
                    'projectname' => $pname,
                    'unitname' => $unitname,
                    'unitno' => $request->unitno,
                    'occupantdata' => json_encode($occup),
                    'occupantcount' => count($occup),
                    'updated_count' => $updatedcount+1,
                    'last_updated_time' => Carbon::now()->toDatetimeString()
                ]);
       }
       else{


            DB::connection('mysql3')->table('securitydetailformdata')->insert(
                [
                    'id' => null,
                    'customerid' => $customerid,
                    'typename' => $request->occupanttype,
                    'customer_name' => $customername,
                    'plantid' => $request->projectid,
                    'projectname' => $pname,
                    'unitname' => $unitname,
                    'unitno' => $request->unitno,
                    'occupantdata' => json_encode($occup),
                    'occupantcount' => count($occup),
                    'created_datetime' => Carbon::now()->toDatetimeString(),
                    'updated_count' => 0,
                    'last_updated_time' => Carbon::now()->toDatetimeString()
                ]);
       }
       }
       else{
                    $request->session()->flash("error_msg", "Not Updated. Try Again!");
                    return redirect()->back()->withInput();
       }


        $request->session()->flash("suc_msg", "Successfully Updated!");
                    return redirect()->back()->withInput();
        

         }
        else{
            return redirect()->route('newcustomer_home');
        }
    }


    public function showuploadedoccupantdetails(Request $request)
    {
        if ($request->session()->has('customersession')) {
            $encrypt = $request->session()->get('customersession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $customerid = $split[0];
            $getcustomerdata = DB::connection('mysql3')->table('customer')->where('id', '=', $customerid)->get();
            $projects = DB::connection('mysql3')->table('projects')->where('cust_id', '=', $customerid)->where(['posession' => 'X'])->get();

            $pwd_status = $this->is_cust_didnt_passwordchanged($customerid);
            if ($pwd_status == 0) {
                $request->session()->flash("error_msg", 'Please change the default password. Only if you Change the default password , other functionalities on this portal will work. This is done for security purposes. Please do not share your password with anyone');
                return redirect()->route('newcustomer_mydetails_passchange');
            }
            //dd($projects);
            $getblockdates = DB::connection('mysql3')->table('projects')->where('cust_id', '=', $customerid)->where('exp_date_of_compl', '!=', '')->get();

            $occupantdetails = DB::connection('mysql3')->table('securitydetailformdata')->where('customerid', '=', $customerid)->orderBy('last_updated_time', 'desc')->get();

            
            
             $listfiles = Storage::disk('s3')->files("/newcustomerzoneassets/customersprofileimage/".$customerid);
             
             if(count($listfiles) > 0){
                $profilepic = config('app.AWS_URL')."/".$listfiles[0];
            }
             else
             {
                $profilepic = config('app.AWS_URL')."/newcustomerzoneassets/img/dummy_male.png";
             }
           //dd($occupantdetails);
             if (count($occupantdetails) == 0) {
                $request->session()->flash("error_msg", "Occupant_Details Not found!");
                 return redirect()->back();
             }
            return view('newcustomerzone.showuploadedoccupantdetails')->with(['getcustomerdata'=> $getcustomerdata, 'projects' => $projects, 'profilepic' => $profilepic,'getblockdates' => $getblockdates,'occupantdetails' => $occupantdetails]);
        }
        else{
            return redirect()->route('newcustomer_home');
        }
    }

     public function openrentsellunit(Request $request, $id)
   {
       
       $id1 = $id - 1000;
       $customerid = $id1/3;
        /*$getcustomerdata = DB::connection('mysql3')->table('customer')->where('id', '=', $customerid)->get();
            if(count($getcustomerdata) == 0){
                $check = $this->open_customercheck_toinsert($customerid);
                if ($check == 1) {
                    $getcustomerdata = DB::connection('mysql3')->table('customer')->where('id', '=', $customerid)->get();
                }
                else{
                    dd('Not a Valid Customer!');
                }
            }*/ 

            $projects = $this->customerbasicinfo($customerid);
            $sellunit = 0;
            $rentunit = 0;
         /*$getcustsatisfactionlist = $this->getcustdisatreasons($customerid);
            $dissatisfationlist = $getcustsatisfactionlist['Reasons'];*/

             /*$check_rating = DB::connection('mysql3')->table('satisfaction_rating')->where('customerid', '=', $customerid)->get();
             if(count($check_rating) > 0){
                 foreach ($check_rating as $key => $value) {
                     $rating = $value->rating_id;
                 }
             }*/
             $proj = [];
             if (array_key_exists('Project_Detail', $projects)) {
                
     
             if (array_key_exists('0', $projects['Project_Detail'])) {
             $proj['Project_Detail'] = $projects['Project_Detail']; 
             }
             else
             {
                $proj['Project_Detail'][0] = $projects['Project_Detail'];
             }
         }
         else{
            $request->session()->flash("error_msg", "Invalid Customer!");
            return redirect()->route('newcustomer_home');
         }

         $getpossesiontakenunit = [];

         foreach ($proj['Project_Detail'] as $key => $value) {
            
            if ($value['Possession'] == 'X') {
                $getpossesiontakenunit[] = $value;
            }
         }
             
             if (empty($getpossesiontakenunit)) {
                $request->session()->flash("error_msg", "Possession taken customers can only apply for Rent/Sell their unit!");
                return redirect()->route('newcustomer_home');
             }
             //dd($projects);
             $customdata[0] =  $projects;
             //dd($customdata);

            return view('newcustomerzone.open_rentsellunitbyvgn')->with(['customerid'=>$customerid,'getcustomerdata'=> $getpossesiontakenunit,'customerdata' => $customdata,'id' =>$id]);
   }

   public function post_openrentsellunit(Request $request)
   {

$rent = '';
$sell = '';
    if ($request->has('rent')) {
        $rent = 'X';
    }

    if ($request->has('sell')) {
        $sell = 'X';
    }

    if (($rent == '') && ($sell == '')) {
        $request->session()->flash("error_msg", "Please fill the required fields!");
    return redirect()->back();
    }

    $plant = $request->projectid;
    $unitno = $request->unitno;
    //dd($request);
    $arr=[];
    $arr['PLANT'] = $plant;
    $arr['CUSTOMER_ID'] = $request->custid;
    $arr['UNIT_NO'] = $unitno;
    $arr['RENT_IND'] = $rent;
    $arr['SELL_IND'] = $sell;
    //dd($arr);
    $res = $this->saverentselloptionfrom_cust_tosap($arr);
    //dd($res);
    if ($res['STATUS'] == 'Updated Successfully') {
if($rent == ''){$rent = null;}
if($sell == ''){$sell = null;}

        $rentsellunit = DB::connection('mysql3')->table('rentsellunit')->where(['custid' => $request->custid,'plantid' => $plant,'unitno' => $unitno])->get();
	//dd($rentsellunit);
        if (count($rentsellunit) == 0) {

           $ins = DB::connection('mysql3')->table('rentsellunit')->insert(['id'=> null,'custid' => $request->custid,'plantid' => $plant,'unitno' => $unitno,'rent'=> $rent, 'sell' => $sell,'created_date'=>Carbon::now()->toDatetimeString(),'lastupdated_date' => Carbon::now()->toDatetimeString()]);
//dd($ins);
        }
        else{
            DB::connection('mysql3')->table('rentsellunit')->where(['custid' => $request->custid,'plantid' => $plant,'unitno' => $unitno])->update(['rent'=> $rent, 'sell' => $sell,'lastupdated_date' => Carbon::now()->toDatetimeString()]);
        }


        $request->session()->flash("suc_msg", "Thanks for your input, we will get back to you shortly!");
    }
    else{
        $request->session()->flash("error_msg", "Sorry, not updated. Try Again!");
    }

    
    return redirect()->back();

   }

   public function rentsellmyunit(Request $request)
   {
       if ($request->session()->has('customersession')) {
            $encrypt = $request->session()->get('customersession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $customerid = $split[0];
            $getcustomerdata = DB::connection('mysql3')->table('customer')->where('id', '=', $customerid)->get();
            $projects = DB::connection('mysql3')->table('projects')->where('cust_id', '=', $customerid)->where(['posession' => 'X'])->get();
            //dd($projects);
            $getblockdates = DB::connection('mysql3')->table('projects')->where('cust_id', '=', $customerid)->where('exp_date_of_compl', '!=', '')->get();

            $pwd_status = $this->is_cust_didnt_passwordchanged($customerid);
            if ($pwd_status == 0) {
                $request->session()->flash("error_msg", 'Please change the default password. Only if you Change the default password , other functionalities on this portal will work. This is done for security purposes. Please do not share your password with anyone');
                return redirect()->route('newcustomer_mydetails_passchange');
            }

            

            
            
             $listfiles = Storage::disk('s3')->files("/newcustomerzoneassets/customersprofileimage/".$customerid);
             
             if(count($listfiles) > 0){
                $profilepic = config('app.AWS_URL')."/".$listfiles[0];
            }
             else
             {
                $profilepic = config('app.AWS_URL')."/newcustomerzoneassets/img/dummy_male.png";
             }
           //dd($occupantdetails);
             if (count($projects) == 0) {
                $request->session()->flash("error_msg", "Possession taken customers can only apply for Rent/Sell their unit!");
                 return redirect()->back();
             }

             //dd($getcustomerdata);
            return view('newcustomerzone.rentsellmyunit')->with(['getcustomerdata'=> $getcustomerdata, 'projects' => $projects, 'profilepic' => $profilepic,'getblockdates' => $getblockdates]);
        }
        else{
            return redirect()->route('newcustomer_home');
        }
   }

   public function postrentsellmyunit(Request $request)
   {
       if ($request->session()->has('customersession')) {
            $encrypt = $request->session()->get('customersession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $customerid = $split[0];
            $getcustomerdata = DB::connection('mysql3')->table('customer')->where('id', '=', $customerid)->get();
            $projects = DB::connection('mysql3')->table('projects')->where('cust_id', '=', $customerid)->where(['posession' => 'X'])->get();

            if (count($projects) == 0) {
                $request->session()->flash("error_msg", "Possession taken customers can only apply for Rent/Sell their unit!");
                 return redirect()->back();
             }
            
            $rent = '';
$sell = '';
    if ($request->has('rent')) {
        $rent = 'X';
    }

    if ($request->has('sell')) {
        $sell = 'X';
    }

    if (($rent == '') && ($sell == '')) {
        $request->session()->flash("error_msg", "Please fill the required fields!");
    return redirect()->back();
    }

    $plant = $request->projectid;
    $unitno = $request->unitno;
    //dd($request);
    $arr=[];
    $arr['PLANT'] = $plant;
    $arr['CUSTOMER_ID'] = $customerid;
    $arr['UNIT_NO'] = $unitno;
    $arr['RENT_IND'] = $rent;
    $arr['SELL_IND'] = $sell;
    //dd($arr);
    $res = $this->saverentselloptionfrom_cust_tosap($arr);
    //dd($res);
    if ($res['STATUS'] == 'Updated Successfully') {
if($rent == ''){$rent = null;}
if($sell == ''){$sell = null;}

        $rentsellunit = DB::connection('mysql3')->table('rentsellunit')->where(['custid' => $customerid,'plantid' => $plant,'unitno' => $unitno])->get();
        if (count($rentsellunit) == 0) {

           $ins = DB::connection('mysql3')->table('rentsellunit')->insert(['id'=> null,'custid' => $customerid,'plantid' => $plant,'unitno' => $unitno,'rent'=> $rent, 'sell' => $sell,'created_date'=>Carbon::now()->toDatetimeString(),'lastupdated_date' => Carbon::now()->toDatetimeString()]);
//dd($ins);
        }
        else{
            DB::connection('mysql3')->table('rentsellunit')->where(['custid' => $customerid,'plantid' => $plant,'unitno' => $unitno])->update(['rent'=> $rent, 'sell' => $sell,'lastupdated_date' => Carbon::now()->toDatetimeString()]);
        }
        $request->session()->flash("suc_msg", "Thanks for your input, we will get back to you shortly!");
    }
    else{
        $request->session()->flash("error_msg", "Sorry, not updated. Try Again!");
    }

    
    return redirect()->back();

            

            
            
        }
        else{
            return redirect()->route('newcustomer_home');
        }
   }


   public function open_occupantdetailsshow(Request $request, $id)
    {
            $dd = $id - 2000;
            $customerid = $dd/2;

            
            //$getcustomerdata = DB::connection('mysql3')->table('customer')->where('id', '=', $customerid)->get();
            $getcustomerdata = $this->customerbasicinfo($customerid);
            //dd($getcustomerdata);
            if ($getcustomerdata['Customer_Name'] == '') {
                return redirect()->route('newcustomer_home');
            }
            //$projects = DB::connection('mysql3')->table('projects')->where('cust_id', '=', $customerid)->where(['posession' => 'X'])->get();
            //dd($projects);
            //$getblockdates = DB::connection('mysql3')->table('projects')->where('cust_id', '=', $customerid)->where('exp_date_of_compl', '!=', '')->get();

             $getpossesiontakenunit1 = [];
             $getpossesiontakenunit = [];
             if(array_key_exists('0', $getcustomerdata['Project_Detail']))
             {
                $getpossesiontakenunit1['Project_Detail'] = $getcustomerdata['Project_Detail'];
             }
             else{
                $getpossesiontakenunit1['Project_Detail'][0] = $getcustomerdata['Project_Detail'];
             }

             //dd($getpossesiontakenunit);

         foreach ($getpossesiontakenunit1['Project_Detail'] as $key => $value) {
            
            if ($value['Possession'] == 'X') {
                $getpossesiontakenunit[] = $value;
            }
         }
             
             if (empty($getpossesiontakenunit)) {
                $request->session()->flash("error_msg", "Possession taken customers can only apply for Rent/Sell their unit!");
                return redirect()->route('newcustomer_home');
             }

            $occupantdetails = DB::connection('mysql3')->table('securitydetailformdata')->where('customerid', '=', $customerid)->orderBy('last_updated_time', 'desc')->get();

            $customdata[0] =  $getcustomerdata;
           //dd($getcustomerdata);
            return view('newcustomerzone.open_occupantdetailsupdate')->with(['getcustomerdata'=> $customdata, 'projects' => $getpossesiontakenunit, 'occupantdetails' => $occupantdetails,'id' =>$id]);
        
        
    }

    public function open_postoccupantdetailsshow(Request $request,$id)
    {
        

            $dd = $id - 2000;
            $customerid = $dd/2;
            //$getcustomerdata = DB::connection('mysql3')->table('customer')->where('id', '=', $customerid)->get();
            $getcustomerdata = $this->customerbasicinfo($customerid);
            //dd($getcustomerdata);
            if ($getcustomerdata['Customer_Name'] == '') {
                return redirect()->route('newcustomer_home');
            }

            //dd($getcustomerdata);
            if ($getcustomerdata['Customer_Name'] != '') {
                /*foreach ($getcustomerdata as $key11 => $value11) {
                    $customername = $value11->name;
                }*/
                $customername = $getcustomerdata['Customer_Name'];
            }
//dd($customername);
            $getpossesiontakenunit1 = [];
$ss = [];
             if(array_key_exists('0', $getcustomerdata['Project_Detail']))
             {
                $ss['Project_Detail'] = $getcustomerdata['Project_Detail'];
             }
             else{
                $ss['Project_Detail'][0] = $getcustomerdata['Project_Detail'];
             }

         foreach ($ss['Project_Detail'] as $key => $value) {
            
            if ($value['Possession'] == 'X') {
                $getpossesiontakenunit1[] = $value;
            }
         }
             
             if (empty($getpossesiontakenunit1)) {
                $request->session()->flash("error_msg", "Possession taken customers can only apply for Rent/Sell their unit!");
                return redirect()->route('newcustomer_home');
             }
            //$projects = DB::connection('mysql3')->table('projects')->where('cust_id', '=', $customerid)->where(['posession' => 'X'])->get();
            //dd($projects);
            //dd($getpossesiontakenunit);
             $getpossesiontakenunit = [];
            if (array_key_exists('0', $getpossesiontakenunit1) === false) {
                $getpossesiontakenunit[0] = $getpossesiontakenunit1;
            }
            else{
                $getpossesiontakenunit = $getpossesiontakenunit1;
            }

            //dd($getpossesiontakenunit);

        $occup = [];
        $k = 0;
        //dd($request);
        foreach ($request->occupants['name'] as $key => $value) {
            //dd($key);
            if (($request->occupants['name'][$key] != null) || ($request->occupants['mobile'][$key] != null) || ($request->occupants['email'][$key] != null)) {

                if (($request->occupants['name'][$key] != null)) {
                    $occup[$k]['name'] = $request->occupants['name'][$key];
                $occup[$k]['mobile'] = $request->occupants['mobile'][$key];
                $occup[$k]['email'] = $request->occupants['email'][$key];
                $k++;
                }
                else{
                    $request->session()->flash("error_msg", "Please fill the occupant details!");
                    return redirect()->back()->withInput();
                }

            }
        }

        $datatodb = [];
        $datatodb['customerid'] = $customerid;
        $datatodb['customername'] = $customername;
        $datatodb['plantid'] = $request->projectid;
        $datatodb['unitno'] = $request->unitno;
        $datatodb['occupanttype'] = $request->occupanttype;
        $datatodb['occupants'] = $occup;

       $check = DB::connection('mysql3')->table('securitydetailformdata')->where(['customerid' => $customerid, 'plantid' => $request->projectid,'unitno'=>$request->unitno ])->get();

       //$project_details = DB::connection('mysql3')->table('projects')->where(['cust_id' => $customerid, 'project_id' => $request->projectid,'unit'=>$request->unitno ])->get();
       foreach ($getpossesiontakenunit as $key12 => $value12) {
        if (($value12['Plant'] == $request->projectid) && ($value12['Unit'] == $request->unitno)) {
            $pname = $value12['Plant_Name'];
               $unitname = $value12['Unit_Name'];
        }
           }


           $arr = [];
       $arr['Plant'] = $request->projectid;
       $arr['Unit_No'] = $request->unitno;
       $arr['Occupant_Type'] = $request->occupanttype;
       $arr['No_Of_Occupants'] = count($occup);
       //dd($occup);
       //$arr['Occupant_Details']['Name'] = 
       foreach ($occup as $key31 => $value31) {
            $arr['Occupant_Details'][$key31]['Name'] = $value31['name'];
            $arr['Occupant_Details'][$key31]['Mobile'] = ($value31['mobile'] != null) ? $value31['mobile'] : '';
            $arr['Occupant_Details'][$key31]['Email'] = ($value31['email'] != null) ? $value31['email'] : '';
       }
       //dd($arr);
       $sendtosap = $this->occupantsdetails($arr);
       //dd($sendtosap);
       if ($sendtosap['Status'] == 'Updated Successfully') {
           
       
       if (count($check) > 0) {
           foreach ($check as $key222 => $value222) {
               $id = $value222->id;
               $updatedcount = $value222->updated_count;
           }

                      

            DB::connection('mysql3')->table('securitydetailformdata')->where(['id' => $id,'customerid' => $customerid,'plantid' => $request->projectid,'unitno' => $request->unitno,])->update(
                [   'typename' => $request->occupanttype,
                    'customer_name' => $customername,
                    'plantid' => $request->projectid,
                    'projectname' => $pname,
                    'unitname' => $unitname,
                    'unitno' => $request->unitno,
                    'occupantdata' => json_encode($occup),
                    'occupantcount' => count($occup),
                    'updated_count' => $updatedcount+1,
                    'last_updated_time' => Carbon::now()->toDatetimeString()
                ]);
       }
       else{


            DB::connection('mysql3')->table('securitydetailformdata')->insert(
                [
                    'id' => null,
                    'customerid' => $customerid,
                    'typename' => $request->occupanttype,
                    'customer_name' => $customername,
                    'plantid' => $request->projectid,
                    'projectname' => $pname,
                    'unitname' => $unitname,
                    'unitno' => $request->unitno,
                    'occupantdata' => json_encode($occup),
                    'occupantcount' => count($occup),
                    'created_datetime' => Carbon::now()->toDatetimeString(),
                    'updated_count' => 0,
                    'last_updated_time' => Carbon::now()->toDatetimeString()
                ]);
       }
       }
       else{
                    $request->session()->flash("error_msg", "Not Updated. Try Again!");
                    return redirect()->back()->withInput();
       }


        $request->session()->flash("suc_msg", "Successfully Updated!");
                    return redirect()->back()->withInput();
        

         
    }


    public function open_showuploadedoccupantdetails(Request $request, $id)
    {
        
            $dd = $id - 2000;
            $customerid = $dd/2;
            //$getcustomerdata = DB::connection('mysql3')->table('customer')->where('id', '=', $customerid)->get();
            $getcustomerdata = $this->customerbasicinfo($customerid);
            //dd($getcustomerdata);
            if ($getcustomerdata['Customer_Name'] == '') {
                return redirect()->route('newcustomer_home');
            }

            //dd($getcustomerdata);
            if ($getcustomerdata['Customer_Name'] != '') {
                /*foreach ($getcustomerdata as $key11 => $value11) {
                    $customername = $value11->name;
                }*/
                $customername = $getcustomerdata['Customer_Name'];
            }
            $projects = DB::connection('mysql3')->table('projects')->where('cust_id', '=', $customerid)->where(['posession' => 'X'])->get();
            //dd($projects);
            

            $occupantdetails = DB::connection('mysql3')->table('securitydetailformdata')->where('customerid', '=', $customerid)->orderBy('last_updated_time', 'desc')->get();

            
            
             
           //dd($occupantdetails);
             if (count($occupantdetails) == 0) {
                $request->session()->flash("error_msg", "Occupant_Details Not found!");
                 return redirect()->route('newcustomer_home');
             }
             $customdata[0] =  $getcustomerdata;
            return view('newcustomerzone.open_showuploadedoccupantdetails')->with(['getcustomerdata'=> $customdata, 'projects' => $projects, 'occupantdetails' => $occupantdetails,'id'=>$id]);
        
    }

    public function open_checkunitrentsell(Request $request,$id)
    {
        $newid = $id - 1000;
        $cid = $newid/3;
        $customerid = $cid;
        $plantid = $request->plantid;
        $unitno = $request->unitid;
        $rentsellunit = DB::connection('mysql3')->table('rentsellunit')->where(['custid' => $customerid,'plantid' => $plantid,'unitno' => $unitno])->get();

        if (count($rentsellunit) == 0) {
            return 0;
        }
        else{
            return json_encode($rentsellunit);
        }
    }


    public function checkunitrentsell(Request $request)
    {
        if ($request->session()->has('customersession')) {
            $encrypt = $request->session()->get('customersession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $customerid = $split[0];
        
        
        $plantid = $request->plantid;
        $unitno = $request->unitid;
        $rentsellunit = DB::connection('mysql3')->table('rentsellunit')->where(['custid' => $customerid,'plantid' => $plantid,'unitno' => $unitno])->get();

        if (count($rentsellunit) == 0) {
            return 0;
        }
        else{
            return json_encode($rentsellunit);
        }
    }
    else{
        return 0;
    }

    }

    
public function plotcare_interested_survey($saleordernumber)
    {
        if (strpos($saleordernumber, '_') !== false) {
    $param = explode('_', $saleordernumber);
    if (ctype_digit($param[1])) {
       $saleordernumber1 = $param[0];
        $res = DB::connection('mysql')->table('projectlist')->select('Project_name')->where('plantcode', '=', $param[1])->get();
        if (!empty($res) ) {
            $plant_text = ' at VGN '.$res[0]->Project_name;
            //dd($plant_text);
        }
        else{
            $plant_text = '';
        }
    }
    else{
        return redirect()->route('newcustomer_home');
    }
    //dd($param1);
}
else{
    return redirect()->route('newcustomer_home');
}
        if (ctype_digit($saleordernumber1)) {
            $decrypt1 = $saleordernumber1/2;
            $decrypt = $decrypt1 - 2019;

            return view('newcustomerzone.plotcare_interested_survey')->with(['saleorderno' => $saleordernumber1,'plant_text' => $plant_text]);
            //dd($decrypt);
        }
        else{
            return redirect()->route('newcustomer_home');
        }
    }

    public function post_plotcare_interested_survey(Request $request,$saleordernumber)
    {
        $requested_saleorderno = $request->saleorderno;
        if (ctype_digit($saleordernumber)) {
            $decrypt1 = $saleordernumber-2019;
            $decrypt = $decrypt1/2;

            $posted_result = $this->postplotcare_interest(trim($decrypt));
            //return $posted_result;

            if ($posted_result['Status'] == 'Success') {
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
    
    
    //whatsapp Integration from SAP  , Next  Funciton are whatsapp triggerd function.
    public function whatsapp_schedular(Request $request)
    {
        //http://localhost:55510/whatsapp/test_202522.php?id=0003212474&temp_id=HOK&polt=11K&plant_dec=VGN%20NOTTING%20HILL
        $idString = $request->query('id'); 
        $temp_id = $request->query('temp_id');
        $polt = $request->query('polt') ?: 'Default Polt';
        $plant_dec = $request->query('plant_dec') ?: 'Default Plant Description';             
        $template_content= $polt. " in " .$plant_dec;

        // Check if required parameters are present
        if (empty($idString) || empty($temp_id)) 
        {
        return response()->json(['error' => 'Missing required parameters: id or temp_id'], 400);
        }

        $idArray = explode(',', $idString);
        $results = [];

        foreach ($idArray as $id) 
        {
            $customerid = (int)$id;
            if ($customerid) 
            {
                try 
                {
                    // Fetch customer data
                    $getcustomerdata = DB::connection('mysql3')
                    ->table('customer')
                    ->where('id', $customerid)
                    ->select('id', 'name', 'mobile')
                    ->first();

                    // If customer data is found
                    if ($getcustomerdata) 
                    {
                        $mobile=$getcustomerdata->mobile;
                        //$mobile = 9043393428;
                        if($temp_id =="1")
                        {
                            $logData= $this->call_whatsapp_now($getcustomerdata->name,$mobile,'1',$template_content);
                        }
                        elseif($temp_id =="2")
                        {
                            $logData= $this->call_whatsapp_now($getcustomerdata->name,$mobile,'2',$template_content);
                        }
                        elseif($temp_id =="3")
                        {
                            $logData= $this->call_whatsapp_now($getcustomerdata->name,$mobile,'3',$template_content);
                        }
                        elseif($temp_id =="4")
                        {
                            $logData= $this->call_whatsapp_now($getcustomerdata->name,$mobile,'4',$template_content);
                        }
                        elseif($temp_id =="5")
                        {
                            $logData= $this->call_whatsapp_now($getcustomerdata->name,$mobile,'5',$template_content);
                        }
                        elseif($temp_id =="6")
                        {
                            $logData= $this->call_whatsapp_now($getcustomerdata->name,$mobile,'6',$template_content);
                        }
                        elseif($temp_id =="7")
                        {
                            $logData= $this->call_whatsapp_now($getcustomerdata->name,$mobile,'7',$template_content);
                        }
                        elseif($temp_id =="8")
                        {
                            $logData= $this->call_whatsapp_now($getcustomerdata->name,$mobile,'8',$template_content);
                        }
                        elseif($temp_id =="9")
                        {
                            $logData= $this->call_whatsapp_now($getcustomerdata->name,$mobile,'9',$template_content);
                        }
                        elseif($temp_id =="10")
                        {
                            $logData= $this->call_whatsapp_now($getcustomerdata->name,$mobile,'10',$template_content);
                        }
                        elseif($temp_id =="11")
                        {
                            $logData= $this->call_whatsapp_now($getcustomerdata->name,$mobile,'11',$template_content);
                        }
                        elseif($temp_id =="12")
                        {
                            $logData= $this->call_whatsapp_now($getcustomerdata->name,$mobile,'12',$template_content);
                        }
                        elseif($temp_id =="WELCOME")
                        {
                            $logData= $this->call_whatsapp_now($getcustomerdata->name,$mobile,'13',$template_content);
                        }	
                        elseif($temp_id =="ALLOT")
                        {
                            $logData= $this->call_whatsapp_now($getcustomerdata->name,$mobile,'14',$template_content);
                        }
                        elseif($temp_id =="REQ")
                        {
                            $logData= $this->call_whatsapp_now($getcustomerdata->name,$mobile,'15',$template_content);
                        }
                        elseif($temp_id =="CLAIM")
                        {
                            $logData= $this->call_whatsapp_now($getcustomerdata->name,$mobile,'16',$template_content);
                        }
                        elseif($temp_id =="POS")
                        {
                            $logData= $this->call_whatsapp_now($getcustomerdata->name,$mobile,'17',$template_content);
                        }
                        elseif($temp_id =="CAR")
                        {
                            $logData= $this->call_whatsapp_now($getcustomerdata->name,$mobile,'18','');
                        }
                        elseif($temp_id =="HOK")
                        {
                            $logData= $this->call_whatsapp_now($getcustomerdata->name,$mobile,'19','');
                        }
                        elseif($temp_id =="20")
                        {
                            $logData= $this->call_whatsapp_now($getcustomerdata->name,$mobile,'20',$polt);
                        }
                       // $logData= $this->call_whatsapp_now($getcustomerdata->name, $mobile, $temp_id ,$template_content); //7200606070,9500016932

                        // Store result with customer data
                        $results[$id] = [
                        'customerid' => $getcustomerdata->id,
                        'name' => $getcustomerdata->name,
                        'mobile' => $getcustomerdata->mobile,
                        'template_id' =>$temp_id,
                        'Status' => $logData['Status'],
                        'Details' => $logData['Details'],
                        'Timestamp' => $logData['Timestamp'],
                        ];
                    } 
                    else 
                    {
                        // No customer data found
                        $results[$id] = [
                        'customerid' => $customerid,
                        'name' => 'N/A',
                        'mobile' => 'N/A',
                        'template_id' =>$temp_id,
                        'Status' => 'No data found',
                        'Details' => 'Customer not found in DB',
                        'Timestamp' => date('Y-m-d H:i:s'),
                        ];
                    }
                } 
                catch (\Exception $e)
                {              
                    $results[$id] = [
                    'customerid' => $customerid,
                    'name' => 'Error',
                    'mobile' => 'Error',
                    'template_id' =>$temp_id,
                    'Status' => 'Error',
                    'Details' => $e->getMessage(),
                    'Timestamp' => date('Y-m-d H:i:s'),
                    ];

                    Log::error("Error fetching customer data for ID $customerid: " . $e->getMessage());
                }
            } 
            else
            {
            // Invalid customer ID
            $results[$id] = [
            'customerid' => $id,
            'name' => 'Invalid ID',
            'mobile' => 'Invalid ID',
            'template_id' =>$temp_id,
            'Status' => 'Invalid customer ID',
            'Details' => 'Customer ID is invalid',
            'Timestamp' => date('Y-m-d H:i:s'),
            ];
            }
        }
        return response()->download($this->generate_wacsv($results), 'whatsapp_report_' . date('Y-m-d_H-i-s') . '.csv');
       
    }   

    //warm-Hot-underfollowup promotional whatsapp trigger from sap via url 
    public function whatsapp_schedular_for_warm_hot_underfollowup_promotionla(Request $request)
    {
            // Example: /url?lead_mobilenumber=9876543210,9123456789&temp_id=1
        $mobileString = $request->query('lead_mobilenumber');
        $temp_id = $request->query('temp_id');

        if (empty($mobileString) || empty($temp_id))
        {
            return response()->json(['error' => 'Missing required parameters: lead_mobilenumber or temp_id'], 400);
        }

        $mobileArray = explode(',', $mobileString);
        $results = [];

        foreach ($mobileArray as $mobile)
        {
            //storing the mobile number into db 
            $today = Carbon::now()->format('Ymd');
            
            whatsapp_scheduler::insert([
                'number'         => $mobile,
                'temp_id'        => $temp_id,
                'status'     => '0',
                'status_log' => '0',
                'date'       => $today,
            ]);    


            

   
        }

        $todayCount = whatsapp_scheduler::where('date', $today)->count();

        echo "Total records stored today: " . $todayCount; 
        echo "<br>";
        echo "Total record  stored now: " . count($mobileArray);
         echo "<br>";
        echo "Whatsapp trigger soon......";




         //return response()->download($this->generate_wacsv($results), 'whatsapp_promo_report_' . date('Y-m-d_H-i-s') . '.csv');
    }


    //whatsapp cron job setup 

    public function whatsapp_cron_initiate()   
    {
        $today = Carbon::now()->format('Ymd');
        $todayRecords = whatsapp_scheduler::where('date', $today)
        ->where('status', 0)
        ->limit(50)
        ->get();

        foreach ($todayRecords as $record)
        {
            $mobile = preg_replace('/[^0-9]/', '', $record->number); // Clean up non-numeric characters

            if (empty($mobile))
            {
                Log::warning("Skipping record ID {$record->id}: Empty or invalid mobile number");
                continue; 
            }

            try
            {
                $name = 'Valued Customer'; // Or fetch from DB if needed              

                $logData = $this->call_whatsapp_now_for_promotional(null, $mobile, $record->temp_id ?? null, null);
                Log::info("Sending WhatsApp for mobile $mobile: " . json_encode($logData));
                if (is_string($logData))
                {
                    $logData = json_decode($logData, true);
                }

                
                $status = $logData['Status'] ?? 'Unknown';      


                //update into table 
                whatsapp_scheduler::where('id', $record->id)
                ->update([
                    'status' => 1, 
                    'status_log' => $status, 
                ]);
                

                
                           

            } 
            catch (\Exception $e)
            {
                Log::error("Error sending WhatsApp for mobile $mobile: " . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
                ]);
            }           

        }

        $this->push_wa_report_sap();

 

    }


    //whatsapp api trigger for CRM
    public function call_whatsapp_now($username, $phoneNumber, $temp_id,$template_content)
    {
        // Gupshup credentials
        $userid = '2000230975';
        $password = 'Vgn@WA@2024';
        $msg = '';
        $encodedUserName = urlencode($username);      
       

        switch ($temp_id)
	    {
            //Agreement not done more than 15 Days
            case "1":
            $msg ="As+per+clause+in+booking+form+sale+agmt+should+be+signed+within+7+days+otherwise+VGN+cancels+the+booking+after+deducting+5%25+of+unit+cost.+Kindly+Sign+immetly.&isTemplate=true&header=Dear+customer%2C&footer=VGN+Projects+Estates";
            break;


            //Ageing 0-90 Days
            case "2":
            $msg ="Kindly+clear+the+overdue+payments+immediately+failing+which+interest+%402%25+per+month+will+be+charged.&isTemplate=true&header=Dear+customer%2C&footer=VGN+Projects+Estates";
            break;
          
            //Ageing 91-180 Days
            case "3":
            $msg ="Kindly+clear+the+overdue+payments+immediately+failing+which+interest+%402%25+per+month+will+be+charged.+Please+refer+email+sent+today.&isTemplate=true&header=Dear+customer%2C&footer=VGN+Projects+Estates";
            break;

            //Ageing > 180 Days
            case "4":
            $msg ="Kindly+clear+the+overdue+payments+immediately+failing+which+interest+%402%25+per+month+will+be+charged.+Please+refer+email+sent+today.&isTemplate=true&header=Dear+customer%2C&footer=VGN+Projects+Estates";
            break;

            //No Overdue Customers
            case "5":
            $msg ="Kindly+clear+the+overdue+payments+immediately+failing+which+interest+%402%25+per+month+will+be+charged.+Please+refer+email+sent+today.&isTemplate=true&header=Dear+customer%2C&footer=VGN+Projects+Estates";
            break;

            //Handing Over Status
            case "6":
            $msg ="Your+flat+is+completed+and+ready+for+handover.+Kindly+contact+your+customer+care+and+fix+up+the+date+for+site+inspection.&isTemplate=true&header=Dear+customer%2C&footer=VGN+Projects+Estates";
            break;

            //Handing Over Snag not Given Customers
            case "7":
            $msg ="Kindly+inspect+your+flat+and+give+snags+during+this+week+failing+which+no+further+snags+will+be+accepted+at+a+later+date.&isTemplate=true&header=Dear+customer%2C&footer=VGN+Projects+Estates";
            break;

            //Handing Over Snag Given not Completed
            case "8":
            $msg ="Kindly+inspect+your+flat+and+give+snags+during+this+week+failing+which+no+further+snags+will+be+accepted+at+a+later+date.&isTemplate=true&header=Dear+customer%2C&footer=VGN+Projects+Estates";
            break;

            //8th content copied for 9 also becaz tempelte need to be change 
            case "9":
            $msg ="Kindly+inspect+your+flat+and+give+snags+during+this+week+failing+which+no+further+snags+will+be+accepted+at+a+later+date.&isTemplate=true&header=Dear+customer%2C&footer=VGN+Projects+Estates";
            break;

            //50% payment completed but UDS not registered
            case "10":
            $msg ="Complete+UDS+registration+immediately.+Kindly+confirm+the+date+for+registration+to+initiate+token+in+TN+Reginet+portal.&isTemplate=true&header=Dear+customer%2C&footer=VGN+Projects+Estates";
            break;

            //All Customers
            case "11":
            $msg ="Payment+Overdue+for+more+than+30days.Bank+sanction+not+obtained.2%25+p.m.+interest+charged+on+overdues.+Kindly+refer+email+sent+today.&isTemplate=true&header=Dear+customer%2C&footer=VGN+Projects+Estates";
            break;

            //Over Due more than 30 Days
            case "12":
            $msg ="Payment+Overdue+for+more+than+30days.+Bank+sanction+not+obtained.2%25+p.m.+interest+charged+on+overdues.+Kindly+refer+email+sent+today.&isTemplate=true&header=Dear+customer%2C&footer=VGN+Projects+Estates";
            break; 

            //WELCOME
            case "13":
            $template_content=$template_content;
            $encoded_content= urlencode($template_content);
            $msg="We+herewith+confirm+your+booking+towards+your+Flat+No.+$encoded_content.+Welcome+Letter+has+been+sent+to+your+mail.+Thank+You.Contact+044-43439999+for+further+information.&isTemplate=true&header=Dear+customer%2C&footer=VGN+Projects+Estates";
            break;
            
            //ALLOT
            case "14";
            $template_content=$template_content;
            $encoded_content= urlencode($template_content);
            $msg="Allotment+Letter+for+your+Flat+no.+$encoded_content+has+been+sent+to+your+mail.+Thank+You.Contact+044-43439977+for+any+queries.&isTemplate=true&header=Dear+customer%2C&footer=VGN+Projects+Estates";
            break;
            
            //REQ
            case "15";
            $template_content=$template_content;
            $encoded_content= urlencode($template_content);
            $msg="Your+Flat+no.+$encoded_content+is+ready.+We+Kindly+request+you+to+inspect+your+Flat+.+Request+to+Inspection+Letter+has+been+sent+to+your+mail.+Thank+You.+Contact+044-43439999+for+any+queries.&isTemplate=true&header=Dear+customer%2C&footer=VGN+Projects+Estates";
            break;
            
            //CLAIM
            case "16";
            $template_content=$template_content;
            $encoded_content= urlencode($template_content);
            $msg="Your+Flat+no.+$encoded_content+is+ready.+No+claim+letter+has+been+sent+to+your+mail.+Thank+You.+Contact+044-43439999+for+any+queries.&isTemplate=true&header=Dear+customer%2C&footer=VGN+Projects+Estates";
            break;
            
            //POS
            case "17";
            $template_content=$template_content;
            $encoded_content= urlencode($template_content);
            $msg="Your+Flat+no.+$encoded_content+is+ready.+A+possession+letter+has+been+sent+to+your+email.+Thank+You.+Contact+044-43439999+for+any+queries.&isTemplate=true&header=Dear+customer%2C&footer=VGN+Projects+Estates";
            break;
            
            //CAR
            case "18";
            $msg="Car+park+letter+has+been+sent+to+your+mail.+Thank+You.+Contact+044-43439999+for+any+queries.&isTemplate=true&header=Dear+customer%2C&footer=VGN+Projects+Estates";
            break;		
            
            //HOK
            case "19";
            $msg="Handing+Over+Kit+has+been+sent+to+your+mail.+Thank+You.+Contact+044-43439999+for+further+information.&isTemplate=true&header=Dear+customer%2C&footer=VGN+Projects+Estates";
            break;

            //ZSD_ODUE
		    case "20";		
			// Regular expressions
			$projectNamePattern = '/in (.*?) is progressing well/';
			$linkPattern = '/http[s]?:\/\/[^\s]+/';
			// Extract project name
			if (preg_match($projectNamePattern, $template_content, $projectMatch))
            {
			    $projectName = $projectMatch[1];
			    //echo "Project Name: " . $projectName . PHP_EOL;
			}
			// Extract URL
			if (preg_match($linkPattern, $template_content, $linkMatch))
            {
			    $link = $linkMatch[0];
			    //echo "Link: " . $link . PHP_EOL;
			}
			$encoded_content= urlencode($projectName);
			$encoded_link= urlencode($link);
            //Dear customer , Your flat in VGN NOTTING HILL is progressing well. Please click the below link to view the latest project photographs. http://bit.ly/2Okl7xd Regards, VGN Customer Care Team	
		    $msg="Your+flat+in+$encoded_content+is+progressing+well.Please+click+the+below+link+to+view+the+latest+project+photographs.+$encoded_link+%0ARegards%2C%0AVGN+Customer+Care+Team&isTemplate=true&header=Dear+customer%2C&footer=VGN+Projects+Estates";
            //echo $msg;
            break;

          
	    }

      

        if (!empty($msg)) 
        {   
            $apiUrl = "https://media.smsgupshup.com/GatewayAPI/rest?userid=$userid&password=$password&send_to=$phoneNumber&v=1.1&format=json&msg_type=TEXT&method=SENDMESSAGE&msg=" . $msg;

           // Initialize cURL
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $apiUrl);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            if (curl_errno($ch)) {
            Log::error("CURL Error: " . curl_error($ch));
            } 
            else 
            {
                $responseData = json_decode($response, true);
                $status = $responseData['response']['status'] ?? 'Failed';
                $details = $responseData['response']['details'] ?? 'No details';
                $timestamp = date('Y-m-d H:i:s');
                $logData = [
                'Phone Number' => $phoneNumber,
                'Status' => $status,
                'Details' => $details,
                'Timestamp' => $timestamp,                
                ];
                Log::info('Whatsapp Success log: ' . json_encode($logData));
            }
            curl_close($ch);
        }
     
        return  $logData;
    }


    //whatsapp api trigger for Promotional msg   
    public function call_whatsapp_now_for_promotional($username, $phoneNumber, $temp_id,$template_content)
    {

        $apiKeys = DB::connection('mysql6')->table('vendor_api_key')->get();

        $first = $apiKeys[0];

       
        // Gupshup credentials
        $userid = '2000232085';
        $password = trim($first->password);
        $msg = '';
        $encodedUserName = urlencode($username);      
       
        switch ($temp_id)
	    {           

            //Warm 4410
            case "21";
            //$msg="Greetings+from+VGN+Projects+Estates%21+We+thank+you+for+your+continued+interest+in+VGN+Richmond+Towers+-+Luxury+2+%26+3+BHK+Homes+In+The+Heart+of+Guindy.+We+kindly+request+you+to+visit+the+site+at+the+earliest+to+choose+your+dream+home.+We+look+forward+to+welcoming+you+at+VGN+Richmond+Towers+-+Guindy.+Click+the+link+for+e-brochure%3A+https%3A%2F%2Fwww.vgn.in%2FRT-brochure.pdf.Website%3A++https%3A%2F%2Fwww.vgn.in%2F%2Fprojects%2Frichmond-towers-guindy-chennai+.+Call+us%3A+04443439999+-+VGN+Projects+Estates.&isTemplate=true&header=Dear+Customer%2C";
             $msg="Dear+Customer%2C+Greetings+from+VGN+Projects+Estates%21+We+thank+you+for+your+continued+interest+in+VGN+Richmond+Towers+-+Luxury+2+%26+3+BHK+Homes+In+The+Heart+of+Guindy.+We+kindly+request+you+to+visit+the+site+at+the+earliest+to+choose+your+dream+home.+We+look+forward+to+welcoming+you+at+VGN+Richmond+Towers+-+Guindy.+Click+the+link+for+e-brochure%3A+https%3A%2F%2Fwww.vgn.in%2FRT-brochure.pdf+Please+check+the+link+below+to+view+the+latest+construction+photographs%3A+https%3A%2F%2Fwww.vgn.in%2Frt-progress%2F+Website%3A+https%3A%2F%2Fwww.vgn.in%2Fvgn-richmond-towers-guindy%2F+Call+us%3A+04443439999+-+VGN+Projects+Estates";
            break;

            //hot 4410
            case "22";
            //$msg="Greetings+from+VGN+Projects+Estates%21+We+thank+you+for+your+interest+in+VGN+Richmond+Towers+-+Luxury+2+%26+3+BHK+Homes+In+The+Heart+of+Guindy.+We+kindly+request+you+to+visit+our+site+and+choose+your+dream+home.+Thank+you+for+considering+VGN+Richmond+Towers.+Click+the+link+for+e-brochure%3A+https%3A%2F%2Fwww.vgn.in%2FRT-brochure.pdf+.Website%3A++https%3A%2F%2Fwww.vgn.in%2F%2Fprojects%2Frichmond-towers-guindy-chennai+.+Call+us%3A+04443439999+-+VGN+Projects+Estates.&isTemplate=true&header=Dear+Customer%2C";
            $msg="Dear+Customer%2C+Greetings+from+VGN+Projects+Estates%21+We+thank+you+for+visiting+VGN+Richmond+Towers+%E2%80%93+Luxury+2+%26+3+BHK+Homes+in+the+Heart+of+Guindy+and+for+taking+the+time+to+explore+our+project+and+apartments.+To+proceed+with+the+next+steps%2C+we+kindly+request+your+booking+confirmation+at+your+earliest+convenience+to+secure+the+apartment.+We+look+forward+to+having+you+as+a+part+of+VGN+Richmond+Towers.+Click+the+link+to+view+our+e-brochure%3A+https%3A%2F%2Fwww.vgn.in%2FRT-brochure.pdf.+Please+check+the+link+below+to+view+the+latest+construction+photographs%3A+https%3A%2F%2Fwww.vgn.in%2Frt-progress%2F+Website%3A+https%3A%2F%2Fwww.vgn.in%2Fvgn-richmond-towers-guindy%2F+.+Call+us%3A+04443439999+-+VGN+Projects+Estates";
            break;

            //Underfollowup 4410
            case "23";
             $msg="Dear+Customer%2C+Greetings+from+VGN+Projects+Estates%21+We+thank+you+for+your+interest+in+VGN+Richmond+Towers+-+Luxury+2+%26+3+BHK+Homes+In+The+Heart+of+Guindy.+We+kindly+request+you+to+visit+our+site+and+choose+your+dream+home.+Thank+you+for+considering+VGN+Richmond+Towers.+Click+the+link+for+e-brochure%3A+https%3A%2F%2Fwww.vgn.in%2FRT-brochure.pdf+.+Please+check+the+link+below+to+view+latest+construction+photographs.+https%3A%2F%2Fwww.vgn.in%2Frt-progress%2F+Website%3A+https%3A%2F%2Fwww.vgn.in%2Fvgn-richmond-towers-guindy%2F+.+Call+us%3A+04443439999+-+VGN+Projects+Estates.";
            //$msg="Greetings+from+VGN+Projects+Estates%21+We+thank+you+for+visiting+VGN+Richmond+Towers+%E2%80%93+Luxury+2+%26+3+BHK+Homes+in+the+Heart+of+Guindy+and+for+taking+the+time+to+explore+our+project+and+apartments.+To+proceed+with+the+next+steps%2C+we+kindly+request+your+booking+confirmation+at+your+earliest+convenience+to+secure+the+apartment.+We+look+forward+to+having+you+as+a+part+of+VGN+Richmond+Towers.+Click+the+link+to+view+our+e-brochure%3A+https%3A%2F%2Fwww.vgn.in%2FRT-brochure.pdf+.Website%3A+https%3A%2F%2Fwww.vgn.in%2F%2Fprojects%2Frichmond-towers-guindy-chennai+.+Call+us%3A+04443439999+-+VGN+Projects+Estates.&isTemplate=true&header=Dear+Customer%2C";
            break;

            //junk 4410
            case "24";
            $msg="Dear+Customer%2C+Greetings+from+VGN+Projects+Estates%21+We+thank+you+for+your+interest+in+VGN+Richmond+Towers+-+Luxury+2+%26+3+BHK+Homes+In+The+Heart++Of+Guindy.+We+kindly+request+you+to+visit+our+site+and+choose+your+dream+home.+Thank+you+for+considering+VGN+Richmond+Towers.%0AClick+the+link+for+e-brochure%3A+https%3A%2F%2Fwww.vgn.in%2FRT-brochure.pdf%0ACall+Now%3A+04443439999&media_url=https%3A%2F%2Fwww.vgn.in%2Fasset%2Fimg%2Frichmond-towers%2Fpopup-rt.png&isTemplate=true&footer=VGN+Projects+Estates&wa_template_json=%7B%22components%22%3A%5B%5D%7D";
            break;

             // Hot 5301
            case "30";
            $msg="Dear+Customer%2C+Greetings+from+VGN+Projects+Estates%21+We+thank+you+for+visiting+VGN+Seattle+-+Luxury+3+BHK+Homes+in+Mogappair.+And+for+taking+the+time+to+explore+our+projects.+To+proceed+with+the+next+steps%2C+we+kindly+request+your+booking+confirmation+at+your+earliest+convenience+to+secure+the+apartment.+We+look+forward+to+having+you+as+a+part+of+VGN+Seattle.+Click+the+link+to+view+our+e-brochure%3A+https%3A%2F%2Fwww.vgn.in%2FST-brochure.pdf+.+Website%3A+https%3A%2F%2Fwww.vgn.in%2Fprojects%2Fseattle-mogappair-chennai+.+Call+us%3A+%2B91+9240255801+-+VGN+Projects+Estates.";
            break;

            //Warm 5301 
            case "31";
            $msg="Dear+Customer%2C+Greetings+from+VGN+Projects+Estates%21+We+thank+you+for+your+continued+interest+in+VGN+Seattle+-+Luxury+3+BHK+Homes+in+Mogappair.+We+kindly+request+you+to+visit+the+site+at+the+earliest+to+choose+your+dream+home.+We+look+forward+to+welcoming+you+at+VGN+Seattle.+Click+the+link+for+e-brochure%3A+https%3A%2F%2Fwww.vgn.in%2FST-brochure.pdf+.+Website%3A+https%3A%2F%2Fwww.vgn.in%2Fprojects%2Fseattle-mogappair-chennai+.+Call+us%3A+%2B91+9240255801+-+VGN+Projects+Estates";
            break;

            //UPF 5301
            case "32";
            $msg="Dear+Customer%2C+Greetings+from+VGN+Projects+Estates%21+We+thank+you+for+your+interest+in+VGN+Seattle+-+Luxury+3+BHK+Homes+in+Mogappair.+We+kindly+request+you+to+visit+our+site+and+choose+your+dream+home.+Thank+you+for+considering+VGN+Seattle.+Click+the+link+for+e-brochure%3A+https%3A%2F%2Fwww.vgn.in%2FST-brochure.pdf+.+Website%3A+https%3A%2F%2Fwww.vgn.in%2Fprojects%2Fseattle-mogappair-chennai+.+Call+us%3A+%2B91+9240255801+-+VGN+Projects+Estates.";
            break;     

	    }

      

        if (!empty($msg)) 
        {   
            //only for lanching promotional link 
          $apiUrl="https://mediaapi.smsgupshup.com/GatewayAPI/rest?userid=$userid&password=$password&send_to=$phoneNumber&v=1.1&format=json&msg_type=TEXT&method=SENDMESSAGE&msg=". $msg;
            // Initialize cURL
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $apiUrl);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            if (curl_errno($ch)) {
            Log::error("CURL Error: " . curl_error($ch));
            } 
            else 
            {
                $responseData = json_decode($response, true);
                $status = $responseData['response']['status'] ?? 'Failed';
                $details = $responseData['response']['details'] ?? 'No details';
                $timestamp = date('Y-m-d H:i:s');
                $logData = [
                'Phone Number' => $phoneNumber,
                'Status' => $status,
                'Details' => $details,
                'Timestamp' => $timestamp,                
                ];
                Log::info('Whatsapp Success log: ' . json_encode($logData));
            }
            curl_close($ch);
        }
     
        return  $logData;
    }
    



    //generate whastapp log csv
    public function generate_wacsv($data)
    {
        $fileName = storage_path('app/whatsapp_report.csv');
        $file = fopen($fileName, 'w');
        // Write CSV header
        fputcsv($file, ['S.No','Customer ID', 'Name', 'Phone Number', 'Template ID', 'Sent Status', 'Details', 'Timestamp']);
        $i=1;
        foreach ($data as $row)
        {
            $maskedMobile = str_repeat('x', strlen($row['mobile']) - 3) . substr($row['mobile'], -3);
            fputcsv($file, [
            $i,
            $row['customerid'] ?? '',
            $row['name'] ?? '',
            $maskedMobile,  
            $row['template_id'] ?? 'N/A',
            $row['Status'],
            $row['Details'],
            $row['Timestamp'],
            ]);
            $i++;
        }
        fclose($file);
        return $fileName;
    }


    //get whatsapp report from sap - like REST API
    public function get_wa_report_sap(Request $request)
    {
            $fromDate = $request->input('fromdate');
            $toDate = $request->input('todate');

            if (empty($fromDate) || empty($toDate)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'fromdate and todate are required.'
                ], 400);
            }

            try {
                // Get all records in date range grouped by temp_id
                $records = whatsapp_scheduler::whereBetween('date', [$fromDate, $toDate])
                    ->get()
                    ->groupBy('temp_id');

                $summary = [];

                foreach ($records as $temp_id => $group) {
                    $summary[] = [
                        'temp_id' => $temp_id,
                        'total' => $group->count(),
                        'success_count' => $group->where('status', 1)->where('status_log', 'success')->count(),
                        'error_count' => $group->where('status', 1)->where('status_log', 'error')->count(),
                        'not_triggered_count' => $group->where('status', 0)->where('status_log', '0')->count(),
                    ];
                }



            //dd($allSapData); // Now you'll see all 5 entries



             
                



                return response()->json([
                    'status' => 'success',
                    'message' => 'Summary fetched successfully',
                    'data' => $summary
                ]);

            } catch (\Exception $e) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Failed to fetch summary: ' . $e->getMessage()
                ], 500);
            }
    }


    //whatsap report send to sap 
    public function push_wa_report_sap()
    {

        $fromDate = date('Y-m-d');
        $toDate = date('Y-m-d');


          try {
            // Get all records in date range grouped by temp_id
            $records = whatsapp_scheduler::whereBetween('date', [$fromDate, $toDate])
                ->get()
                ->groupBy('temp_id');

            $summary = [];

            foreach ($records as $temp_id => $group) {
                $summary[] = [
                    'temp_id' => $temp_id,
                    'total' => $group->count(),
                    'success_count' => $group->where('status', 1)->where('status_log', 'success')->count(),
                    'error_count' => $group->where('status', 1)->where('status_log', 'error')->count(),
                    'not_triggered_count' => $group->where('status', 0)->where('status_log', '0')->count(),
                ];


                Log::info("Successfully summary captured", ['result' => $summary]);
            }


               $allSapData = [];

            $createddate = Carbon::now()->format('Ymd');
            $createdtime = Carbon::now()->format('His');
        foreach ($summary as $item) {
            $uniqid      = Carbon::now()->format('YmdHis') . rand(10, 100);
            $sapdata = [
                'Name'         => $item['temp_id'],
                'Phone'        => $item['total'],
                'Email_ID'     => $item['success_count'],
                'Project_Code' => $item['error_count'],
                'Source'       => "",
                'Unique_ID'    => "$uniqid",
                'Created_Date' => $createddate,
                'Created_Time' => "$createdtime",
                'emp_id' => ""
            ];

            $allSapData[] = $sapdata;
        }

            //dd($allSapData); // Now you'll see all 5 entries



            foreach ($allSapData as $sapdata) {
                
                $response = $this->postleaddetails_new($sapdata);
                // print_r($sapdata);
                Log::info("Successfully lead captured", ['result' => $response]);

            }  

            // return response()->json([
            //     'status' => 'success',
            //     'message' => 'Summary fetched successfully',
            //     'data' => $summary
            // ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch summary: ' . $e->getMessage()
            ], 500);
        }

    }




    //next function are getting details from calling945 forom calling945.vgn.in domain for tele service


    public function collect_customer_mobile_number_using_leadno(Request $request)
    {
        $leadno = $request->input('leadno');

         $response_from_sap = $this->showdetailsby_leadno($leadno);


        if (empty($response_from_sap) || empty($response_from_sap['SAP_Lead_ID']))
        {
            return response()->json([
                'status' => 'error',
                'message' => 'Lead ID not found in the database',
                'data' => null
            ], 404);
        }

        if ($response_from_sap['Mobile_No'] === '0' || empty($response_from_sap['Mobile_No']))
        {
            return response()->json([
                'status' => 'error',
                'message' => 'Lead Mobile Number not found in the database',
                'data' => null
            ], 404);
        }



           // Prepare response data (only include fields if they exist)
           $filteredData = array_filter([
            'Lead_id' => $response_from_sap['SAP_Lead_ID'],
            'Name' => $response_from_sap['Name'] ?? null,
            'mobile_no' => $response_from_sap['Mobile_No'] ?? null,
            'masked_mobile_no' => isset($response_from_sap['Mobile_No']) ? $this->maskMobileNumber($response_from_sap['Mobile_No']) : null,
            'email' => isset($response_from_sap['Email_ID']) ? $this->maskEmail($response_from_sap['Email_ID']) : null,
            'Source' => $response_from_sap['Source'] ?? null,
            'Project_Name' => $response_from_sap['Project_Name'] ?? null,
            'Plant_ID' => $response_from_sap['Plant_ID'] ?? null,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Lead data retrieved successfully',
            'data' => $filteredData
        ], 200);

        //  return response()->json($response_from_sap);

    }

public function collect_customer_mobile_number(Request $request)
    {
       

        $cust_no = $request->input('cust_no');
        $sapdata = $this->getCustomer($cust_no);

        // If customer data is missing or Customer_ID is empty, return an error
        if (!$sapdata || empty($sapdata['Customer_ID']) || $sapdata['Mobile_No'] === '0') {
            return response()->json([
                'status' => 'error',
                'message' => 'Customer ID not found in the database',
                'data' => null
            ], 404);
        }

        // Construct full address
        $full_address = implode(', ', array_filter([
            $sapdata['Street_House_number'] ?? '',
            $sapdata['Address_Street_1'] ?? '',
            $sapdata['Address_Street_2'] ?? '',
            $sapdata['Address_Street_3'] ?? '',
            $sapdata['City'] ?? '',
            ($sapdata['Postal_Code'] ?? '') ? $sapdata['Postal_Code'] : '',
            $sapdata['Country'] ?? ''
        ]));

        // Prepare response data (only include fields if they exist)
        $filteredData = array_filter([
            'customer_id' => $sapdata['Customer_ID'],
            'customer_name' => $sapdata['Customer_Name'] ?? null,
            'mobile_no' => $sapdata['Mobile_No'] ?? null,
            'masked_mobile_no' => isset($sapdata['Mobile_No']) ? $this->maskMobileNumber($sapdata['Mobile_No']) : null,
            'email' => isset($sapdata['E_Mail']) ? $this->maskEmail($sapdata['E_Mail']) : null,
            'full_address' => $full_address ?: null,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Customer data retrieved successfully',
            'data' => $filteredData
        ], 200);
    }

  
    private function maskMobileNumber(?string $mobile): string
    {
        return $mobile ? substr($mobile, 0, 2) . str_repeat('*', 6) . substr($mobile, -2) : '';
    }

   
    private function maskEmail(?string $email): string
    {
        return $email ? preg_replace('/^(.)(.*)(.@.*)$/', '$1*****$3', $email) : '';
    }


    //delete whatsapp data over {} days due 
    public function deleteOldWhatsappRecords()
    {
         $deleteBeforeDate = Carbon::now()->subDays(1)->format('Y-m-d');

        // Step 1: Count matching rows
        $count = whatsapp_scheduler::where('date', '<', $deleteBeforeDate)->count();

        if ($count > 0) {
        // Step 2: Delete if count > 0
        $deleted = whatsapp_scheduler::where('date', '<', $deleteBeforeDate)->delete();
        Log::info("Deleted $deleted records older than $deleteBeforeDate.", [
                'deleted_date_before' => $deleteBeforeDate,
                'deleted_count' => $deleted
            ]);
        } 
        else 
        {
        // Step 3: Log if no records found
        Log::info("No records found before $deleteBeforeDate to delete.", [
            'checked_date_before' => $deleteBeforeDate,
            'deleted_count' => 0
        ]);
        }
    }
}
