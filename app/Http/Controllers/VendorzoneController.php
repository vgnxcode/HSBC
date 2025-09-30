<?php

namespace vgn\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Crypt;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use vgn\Mail\sendvendorotp_reg;
use DB;
use vgn\projectlist;
use vgn\Http\Traits\vendortrait;
use vgn\Jobs\vendor_complaints_sync;
use vgn\Jobs\vendor_paymenthistory_sync;
use vgn\Mail\sendforgotpwdotp;
use vgn\Mail\sendvendorotp_update;
use vgn\Mail\vendorauthenticate;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use File;

use Illuminate\Support\Facades\Hash;

class VendorzoneController extends Controller
{
    use vendortrait;


    public function getip($requestarg)
    {

$ipfetch = $requestarg->server('HTTP_X_FORWARDED_FOR');
$ismobile = $requestarg->server('HTTP_CLOUDFRONT_IS_MOBILE_VIEWER');
$isdesktop = $requestarg->server('HTTP_CLOUDFRONT_IS_DESKTOP_VIEWER');
$requestdetails = ['iprequested' => $ipfetch, 'ismobile' => $ismobile, 'isdesktop' => $isdesktop];
return $requestdetails;

    }
    public function is_didnt_passwordchanged($id)
    {
        $is_didnt_passwordchanged = DB::connection('mysql5')->table('vendor')->where(['id' => $id])->get();
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
        if ($request->session()->has('vendorsession')) {
            $encrypt = $request->session()->get('vendorsession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $vendorid = $split[0];
            
            return $this->newlogout($request);
            $getvendordata = DB::connection('mysql5')->table('vendor')->where('id', '=', $vendorid)->get();
            
             $listfiles = Storage::disk('s3')->files("/newcustomerzoneassets/vendorprofileimage/".$vendorid);

             
             if(count($listfiles) > 0){
                $profilepic = config('app.AWS_URL')."/".$listfiles[0];
            }
             else
             {
                $profilepic = config('app.AWS_URL')."/newcustomerzoneassets/img/dummy_male.png";
             }
            return view('newvendorzone.dashboard')->with(['getvendordata'=>$getvendordata, 'profilepic' => $profilepic]);
        }
        return view('newvendorzone.login');
    }
    
    public function logincheck(Request $request)
    {
        $validate = $this->validate($request, [
            'username' => 'required',
            'password' => 'required'
            ]);
    if (strpos($request->username, '@') !== false) {
            $loginmode = 'loginmode_emailid';
        }
        elseif (ctype_digit($request->username)) {

            if (strlen($request->username) == 10) {
                $loginmode = 'loginmode_mobileno';
            }
            elseif((strlen($request->username) >= 3)&&(strlen($request->username) < 10)){
                $loginmode = 'loginmode_vendorid';
            }
            else{
                $request->session()->flash("error_msg", "Sorry! Enter a valid VendorId or Mobile Number");
                return redirect()->back()->withInput();
            }
                
        }
        else{
            
                $request->session()->flash("error_msg", "Sorry! Enter a valid Username");
                return redirect()->back()->withInput();
        }
        
        //naveen testing
        $arr = [];
        if ($loginmode == 'loginmode_vendorid') {
            $arr['VEND_ID'] = $request->username;
            $arr['MOBILE_NO'] = '';
            $arr['E_MAIL'] = '';
        }
        if ($loginmode == 'loginmode_mobileno') {
            $arr['VEND_ID'] = '';
            $arr['MOBILE_NO'] = $request->username;
            $arr['E_MAIL'] = '';
        }
        if ($loginmode == 'loginmode_emailid') {
            $arr['VEND_ID'] = '';
            $arr['MOBILE_NO'] = '';
            $arr['E_MAIL'] = $request->username;
        }

        if (!empty($arr)) {
             $res = $this->checkvendor($arr);
            if ($res['NAME'] == '0') {
                $request->session()->flash("error_msg", "Invalid User. Try with valid username");
                return redirect()->back()->withInput();
            }
            if (($res['MOBILE_NO'] == '0') && ($res['E_MAIL'] == '0')) {
                $request->session()->flash("error_msg", "Please contact VGN. Your registered mobile number and mail id is Invalid!");
                return redirect()->back()->withInput();
            }

            if (($res['VEND_ID'] != '0') && ($res['NAME'] != '0') ) {

                $checkcstexistindb = DB::connection('mysql5')->table('vendor')->where(['id' => $res['VEND_ID']])->count();
                if ($checkcstexistindb >  0) {
                    $checklogin = DB::connection('mysql5')->table('vendor')->where(['id' => $res['VEND_ID']])->get();

                    foreach ($checklogin as $keycheck => $valuecheck) {
                        $hashedPassword = $valuecheck->password;
                    }
                    if ((count($checklogin) > 0) && (Hash::check($request->password, $hashedPassword))) {
                        
                        $sapdata = $this->vendorbasicinfo($res['VEND_ID']);
                         if($sapdata['Vendor_Name'] != '')
                {

                    if($sapdata['Channel_Partner_Ind'] == ''){ $sapdata['Channel_Partner_Ind'] = null; }
                     if($sapdata['Postal_Code'] == ''){ $sapdata['Postal_Code'] = 0; }
                     if($sapdata['Net_amount'] != ''){ $sapdata['Net_amount'] = str_replace('-','',$sapdata['Net_amount']); }
                     $now = Carbon::now();
                     DB::connection('mysql5')->table('vendor')->where(['id' => $res['VEND_ID']])->update([
                     'Name' => $sapdata['Vendor_Name'],
                     'valid' => $sapdata['Vendor_Active_Status'],
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
                     'pan_no'=> $sapdata['PAN_No'],
                     'type_of_org'=> $sapdata['Type_of_Org'],
                     'type_of_business'=> $sapdata['Type_of_Business'],
                     'contact_person'=> $sapdata['Contact_Person'],
                     'vendor_acc_group'=> $sapdata['Vendor_Account_Group'],
                     'comp_raised'=> $sapdata['No_Of_Comp_Raised'],
                     'comp_closed'=> $sapdata['No_Of_Comp_Closed'],
                     'comp_pending'=> $sapdata['No_Of_Comp_Pending'],
                     'net_amt'=> $sapdata['Net_amount'],
                      'act_no'=> $sapdata['Acc_No'],
                     'branch_name'=> $sapdata['Branch_Name'],
                     'ifsc_code'=> $sapdata['IFSC_Code'],
                     'bank_name'=> $sapdata['Bank_Name'],
             'channel_partner'=> $sapdata['Channel_Partner_Ind'],
                     'bid_count'=> $sapdata['Bid_Count']
                     ]); 
                    
                    
                     $sapencrypt = Crypt::encrypt($sapdata['Pass_Word']);
                    
                     $getpwdforsap = DB::connection('mysql5')->table('sapcustomer')->where('vendorid', '=', $res['VEND_ID'])->get();
                     if(count($getpwdforsap) > 0)
                     {
                         DB::connection('mysql5')->table('sapcustomer')->where('vendorid', '=', $res['VEND_ID'])->delete();
                         DB::connection('mysql5')->table('sapcustomer')->insert(['vendorid' => $res['VEND_ID'], 'password' => $sapencrypt]);
                     }
                     else
                     {
                        DB::connection('mysql5')->table('sapcustomer')->insert(['vendorid' => $res['VEND_ID'], 'password' => $sapencrypt]);
                     }
                   
                     //dd([$res['Cust_ID'],'presentindb']);
                $toencrypt = $res['VEND_ID'].'-#Vgn@M@ain`encRyption89';
                 $encrypt = Crypt::encrypt($toencrypt);
                 $request->session()->put('vendorsession', $encrypt);
                 $paymenthistoryjob = (new vendor_paymenthistory_sync($res['VEND_ID'],'presentindb'))->delay(Carbon::now()->addSeconds(3));
                 
                 $complaintsjob = (new vendor_complaints_sync($res['VEND_ID'],'presentindb'))->delay(Carbon::now()->addSeconds(3));
                 
                 
                 dispatch($complaintsjob);
                 dispatch($paymenthistoryjob);
                 return redirect()->route('newvendor_dashboard',['vendid' => $res['VEND_ID']]);

                }

                $request->session()->flash("error_msg", "Sorry! <b>Vendor does not exist!</b>!");
                 return redirect()->back();
                    }
                    else{
                        $request->session()->flash("error_msg", "Password does not match.Try Again!");
                        return redirect()->back()->withInput();
                    }
                }
                else{
                    $sapdata = $this->vendorbasicinfo($res['VEND_ID']);
                    
                    if($sapdata['Pass_Word'] == $request->password){

                        //dd(Hash::make($sapdata['Pass_Word'], ['rounds' => 12]));

                        if($sapdata['Vendor_Name'] != '')
                 {
                    if($sapdata['Channel_Partner_Ind'] == ''){ $sapdata['Channel_Partner_Ind'] = null; }
                     if($sapdata['Postal_Code'] == ''){ $sapdata['Postal_Code'] = 0; }
                     if($sapdata['Net_amount'] != ''){ $sapdata['Net_amount'] = str_replace('-','',$sapdata['Net_amount']); }
                     $now = Carbon::now();
                     DB::connection('mysql5')->table('vendor')->insert([
                     'id' => $res['VEND_ID'],
                     'Name' => $sapdata['Vendor_Name'],
                     'password' => Hash::make($sapdata['Pass_Word'], ['rounds' => 12]),
                     'valid' => $sapdata['Vendor_Active_Status'],
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
                     'pan_no'=> $sapdata['PAN_No'],
                     'type_of_org'=> $sapdata['Type_of_Org'],
                     'type_of_business'=> $sapdata['Type_of_Business'],
                     'contact_person'=> $sapdata['Contact_Person'],
                     'vendor_acc_group'=> $sapdata['Vendor_Account_Group'],
                     'comp_raised'=> $sapdata['No_Of_Comp_Raised'],
                     'comp_closed'=> $sapdata['No_Of_Comp_Closed'],
                     'comp_pending'=> $sapdata['No_Of_Comp_Pending'],
                     'net_amt'=> $sapdata['Net_amount'],
                      'act_no'=> $sapdata['Acc_No'],
                     'branch_name'=> $sapdata['Branch_Name'],
                     'channel_partner' => $sapdata['Channel_Partner_Ind'],
                     'ifsc_code'=> $sapdata['IFSC_Code'],
                     'bank_name'=> $sapdata['Bank_Name'],
                     'updated'=> null,
                     'pwd_updated'=> null,
                     'pwd_count'=> 0,
                     'bid_count'=> $sapdata['Bid_Count'],
                     'created' => $now
                     ]); 
                    
                    $sapencrypt = Crypt::encrypt($sapdata['Pass_Word']);
                    $getpwdforsap = DB::connection('mysql5')->table('sapcustomer')->where('vendorid', '=', $res['VEND_ID'])->get();
                     if(count($getpwdforsap) > 0)
                     {
                         DB::connection('mysql5')->table('sapcustomer')->where('vendorid', '=', $res['VEND_ID'])->delete();
                         DB::connection('mysql5')->table('sapcustomer')->insert(['vendorid' => $res['VEND_ID'], 'password' => $sapencrypt]);
                     }
                     else
                     {
                        DB::connection('mysql5')->table('sapcustomer')->insert(['vendorid' => $res['VEND_ID'], 'password' => $sapencrypt]);
                     }
                    
                     
                     $toencrypt = $res['VEND_ID'].'-#Vgn@M@ain`encRyption89';
                 $encrypt = Crypt::encrypt($toencrypt);
                 $request->session()->put('vendorsession', $encrypt);

                 $paymenthistoryjob1 = (new vendor_paymenthistory_sync($res['VEND_ID'],'notpresentindb'))->delay(Carbon::now()->addSeconds(3));
                 
                 $complaintsjob1 = (new vendor_complaints_sync($res['VEND_ID'],'notpresentindb'))->delay(Carbon::now()->addSeconds(3));
                 
                 dispatch($complaintsjob1);
                 dispatch($paymenthistoryjob1);
                 return redirect()->route('newvendor_dashboard',['vendid' => $res['VEND_ID']]);

                 }

                        $request->session()->flash("error_msg", "Sorry! <b>Vendor does not exist!</b>!");
                        return redirect()->back();
                    }
                    else{
                        $request->session()->flash("error_msg", "Password does not match.Try Again!");
                        return redirect()->back()->withInput();
                    }
                }//else part added
            }
            else{
                $request->session()->flash("error_msg", "Not a Valid Vendor!");
                        return redirect()->back()->withInput();
            }
        }
        else{
                $request->session()->flash("error_msg", "Not a Valid Vendor!");
                        return redirect()->back()->withInput();
            }
        
    }

    public function gstverifywith_aadharkyc($gstno, $usermob,$useremail)
    {
        
    
    $curl = curl_init();
    
    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://kyc-api.aadhaarkyc.io/api/v1/corporate/gstin',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS =>'{
        "id_number": "'.$gstno.'",
        "filing_status_get": true
    }',
      CURLOPT_HTTPHEADER => array(
        'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE2MjA2NTA3MTYsIm5iZiI6MTYyMDY1MDcxNiwianRpIjoiMTU2Zjc4MGItZTZmYS00OGZlLWI4ZGYtYzA4ODY4NjRhMWFiIiwiZXhwIjoxOTM2MDEwNzE2LCJpZGVudGl0eSI6ImRldi52Z25AYWFkaGFhcmFwaS5pbyIsImZyZXNoIjpmYWxzZSwidHlwZSI6ImFjY2VzcyIsInVzZXJfY2xhaW1zIjp7InNjb3BlcyI6WyJyZWFkIl19fQ.8sXRQhme05BYvnTYCaWSRKIOJq1fuJR3Qdxm6QkWNLs',
        'Content-Type: application/json'
      ),
    ));
    
    $response = curl_exec($curl);
    
    DB::connection('mysql5')->table('aadharkyc_verifyentry')->insert([
    'id' => null,
    'verify_type' => 'GST',
    'verified_type' => 'Vendor',
    'usermob' => $usermob,
    'useremail' => $useremail,
    'created_time' => Carbon::now()->toDateTimeString()
    ]);
    
    curl_close($curl);
    $decoded_resp = json_decode($response);
    
    return $decoded_resp;
    }
    
    public function panverifywith_aadharkyc($panno, $usermob,$useremail)
    {
        $curl = curl_init();
    
    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://kyc-api.aadhaarkyc.io/api/v1/pan/pan',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS =>'{
        "id_number": "'.$panno.'"
    }',
      CURLOPT_HTTPHEADER => array(
        'Content-Type: application/json',
        'Accept: application/json',
        'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE2MjA2NTA3MTYsIm5iZiI6MTYyMDY1MDcxNiwianRpIjoiMTU2Zjc4MGItZTZmYS00OGZlLWI4ZGYtYzA4ODY4NjRhMWFiIiwiZXhwIjoxOTM2MDEwNzE2LCJpZGVudGl0eSI6ImRldi52Z25AYWFkaGFhcmFwaS5pbyIsImZyZXNoIjpmYWxzZSwidHlwZSI6ImFjY2VzcyIsInVzZXJfY2xhaW1zIjp7InNjb3BlcyI6WyJyZWFkIl19fQ.8sXRQhme05BYvnTYCaWSRKIOJq1fuJR3Qdxm6QkWNLs',
      ),
    ));
    
    $response = curl_exec($curl);
    DB::connection('mysql5')->table('aadharkyc_verifyentry')->insert([
    'id' => null,
    'verify_type' => 'PAN',
    'verified_type' => 'Vendor',
    'usermob' => $usermob,
    'useremail' => $useremail,
    'created_time' => Carbon::now()->toDateTimeString()
    ]);
    
    $decoded_resp = json_decode($response);
    
    
    
    curl_close($curl);
    return $decoded_resp;
    }
    
    
    public function verifiedvendorlogout(Request $request)
    {
        if ($request->session()->has('authorizedvendor')) {
                
                $request->session()->forget("authorizedvendor");
                
                return redirect()->route('vendorregistration');
                }
                else{
                    return redirect()->route('vendorregistration');
                }
    }
    
    public function verifiedvendor(Request $request)
    {
        if ($request->session()->has('authorizedvendor')) {
                $verifieddat = $request->session()->get("authorizedvendor");
                $gethelp = $this->regHelp();
                //dd($gethelp);
                return view('newvendorzone.verifiedvendor')->with(['sessdata' => $verifieddat, 'gethelp' => $gethelp]);
                }
                else{
                    return redirect()->route('vendorregistration');
                }
    }
    
    public function postverifiedvendor(Request $request)
    {
        if ($request->session()->has('authorizedvendor')) {
                $verifieddat = $request->session()->get("authorizedvendor");
    
                $now = Carbon::now()->toDateTimeString();
                if (Carbon::parse($now)->gt(Carbon::parse($verifieddat['sess_expiry_time']))) {
                    $request->session()->forget("authorizedvendor");
                    $request->session()->flash("error_msg", "Session Expired. Try again!");
               
                return redirect()->route('vendorregistration'); 
                }
                            
    
                $insert = $this->venRegDetails($verifieddat);
                
    
                
            if($insert['Status_Note'] == 'DATA UPDATED'){
                $request->session()->flash("suc_msg", "Vendor Registration Successful. Note your registration id: <b>".$insert['Vendor_Reg_no']."</b>");
                if (count($verifieddat['filearray']) > 0) {
                    foreach ($verifieddat['filearray'] as $key => $value) {
                        //dd($value);
                        $url = $value['temp_path'];
                        $listfiles = Storage::disk('s3')->files("/vendreg_tempath");
                        
                        if(count($listfiles) > 0){
                        foreach ($listfiles as $keyv => $valuev) {
                            
                            if ($valuev == "vendreg_tempath/".$value['temp_filename']) {
                                $path = pathinfo("https://cdn.vgn.in/vendreg_tempath/".$value['temp_filename']);
                                $fm = Carbon::now()->format('Ymdhis');
                                $randstr = rand(1111,99999).$fm;
                                $finalfilename = $insert['Vendor_Reg_no']."_".$randstr.'.'.$path['extension'];
                                $ss = Storage::disk('s3')->move("/vendreg_tempath/".$value['temp_filename'], "/vendorreg_finalpath/".$finalfilename);
    
                                DB::connection('mysql5')->table('vendorreg_files')->insert(['id' => null, 'appid' => $insert['Vendor_Reg_no'], 'vendsap_filename' => $value['vgnsapname'], 'uploaded_path' => "https://cdn.vgn.in/vendorreg_finalpath/".$finalfilename,'createddate' => Carbon::now()->toDateTimeString() ]);
    
                               
                            }
                            
                        }
                    }
                        
                    }
                }
    
                $request->session()->forget("authorizedvendor"); 
                return redirect()->route('vendorregistration'); 
            }
            else
            {
                 $request->session()->flash("error_msg", "Vendor Registration Failed. Try again!");
               // $request->session()->forget('vendorregistrationotpdata');
                return redirect()->route('vendorregistration'); 
            }
    
                }
                else{
                    return redirect()->route('vendorregistration');
                }
    }
    
     public function registration(Request $request){    
         $gethelp = $this->regHelp();
         $verifieddat = '';
        //  Log::info($gethelp);
         //dd($request->session()->has('authorizedvendor'));
         if ($request->session()->has('authorizedvendor')) {
            $verifieddat = $request->session()->get("authorizedvendor");
            $now = Carbon::now()->toDateTimeString();
            if (Carbon::parse($now)->gt(Carbon::parse($verifieddat['sess_expiry_time']))) {
                $request->session()->forget("authorizedvendor");
                $request->session()->flash("error_msg", "Session Expired. Try again!");
           
            return redirect()->route('vendorregistration'); 
            }
            return redirect()->route('verifiedvendor');
            }
         return view('newvendorzone.registration')->with(['gethelp'=>$gethelp,'test' => "sdsdsdhi"]);   
    }
    
    public function postregistration(Request $request){
        
            $validate = $this->validate($request, [
                
                'type_of_the_organization' => 'required|in:Sole Proprietor,Partnership Firm,Company',
                'registration_proof' => 'required|in:gstno,panno,adharno',
                'registration_proof_number' => 'required',
                'aadharValidName' => 'nullable',
                'Material_or_service_category' => 'required',
                'Type_of_Business' => 'required',
                'Vendor_Account_Group' => 'required',
                'Contact_Person' =>    'required|min:4|max:60',
                'mobile_number' =>    array(
                'required',
                'regex:/[0-9]{10}/'
                ),
                'telephone_number' => array(
                'required',
                'regex:/[0-9]{8,15}/'    
                ),
                'email_id' => 'required|email',
                
                'country' => 'required|in:IN',
                'region' => 'required'
                
                ]);
            $vendaccgroup = $request->Vendor_Account_Group;
            $data = $this->vendorregfiles_list(trim($vendaccgroup));
            $mmfiles = [];
            if ($data != '') {
                if (array_key_exists('0', $data['Details'])) {
                    $main = $data['Details'];
                }
                else{
                    $main[0] = $data['Details'];
                }
    
                if (count($main) > 0) {
                    $kv = 0;
                    
                    foreach ($main as $keym => $valuem) {
                        $mmfiles['Doc_Name'][$kv] = $valuem['Doc_Name'];
                        $mmfiles['Attachment_Ind'][$kv] = $valuem['Attachment_Ind'];
                        $kv++;
                    }
                    
                }
                
                
            }
        $attr = array();
        $attr['name_org'] = '';
        $attr['type_org'] = $request->type_of_the_organization;
        $attr['mat'] = $request->Material_or_service_category;
        $attr['type_bus'] = $request->Type_of_Business;
        $attr['ven_acc'] = $request->Vendor_Account_Group;
        $attr['cnct'] = $request->Contact_Person;
        $attr['mob'] = $request->mobile_number;
        $attr['tel'] = $request->telephone_number;
        $attr['email'] = $request->email_id;
        $attr['register_proof'] = $request->registration_proof;
        $attr['register_proof_number'] = trim($request->registration_proof_number);
        if ($request->registration_proof == 'panno') {
            $attr['pan'] = strtoupper($request->registration_proof_number);
            $attr['gst_no'] = '';
            $attr['reg_proof_type'] = 'PAN';
        
        }
        
        if ($request->registration_proof == 'gstno') {
            $attr['pan'] = strtoupper(trim($request->registration_proof_number));
            $attr['gst_no'] = strtoupper(trim($request->registration_proof_number));
            $attr['reg_proof_type'] = 'GST';
        }
        if ($request->registration_proof == 'adharno') {
            $attr['pan'] = strtoupper(trim($request->registration_proof_number));
            $attr['gst_no'] = '';
            $attr['reg_proof_type'] = 'AADHAR';
        }
        $attr['region'] = $request->region;
        $attr['ctry'] = $request->country;

$verified_email = 0;
$verified_mobile = 0;
$verified_pan = 0;
        if ($request->session()->has('emailverification')) {
            $emailverification = $request->session()->get('emailverification');
            $emailverify_decrypted = Crypt::decrypt($emailverification);
            if($emailverify_decrypted['emailid'] == $attr['email']){
                $verified_email += 1;
            }
            if($emailverify_decrypted['emailverified'] == 1){
                $verified_email += 1;
            }

        }



        if ($request->session()->has('mobileverification')) {
            $mobileverification = $request->session()->get('mobileverification');

            $mobileverify_decrypted = Crypt::decrypt($mobileverification);
            
            if($mobileverify_decrypted['mobilenumber'] == $attr['mob']){
                $verified_mobile += 1;
            }
            if($mobileverify_decrypted['mobileverified'] == 1){
                $verified_mobile += 1;
            }
        }

        $res = $this->vendor_pan_validation(strtoupper($attr['pan']));

         if ($res['STATUS'] == 'Valid') {
             $verified_pan = 1;
         }
         else{
            $verified_pan = 0;
         }



         $arr1 = [];

            $arr1['PAN_No'] =  strtoupper($attr['pan']);
            $arr1['Mobile_No'] = $request->mobile_number;
            $arr1['Mail'] = $request->email_id;
        
        

        if (!empty($arr1)) {
            $res1 = $this->vendor_pre_register_validation($arr1);

            if (($res1['STATUS'] != 'Valid') ) {
               $verified_prereg = 0;
            }
            else{
                $verified_prereg = 1;
            }
        }

        



if (($verified_pan == 1) && ($verified_email == 2) && ($verified_mobile == 2) && ($verified_prereg == 1)) {
    //dd($attr);
    $request->session()->forget('emailverification');
    $request->session()->forget('mobileverification');
    if($attr['register_proof'] == 'gstno'){
        $toverifypan = $attr['pan'];
        $decoded_resp = $this->gstverifywith_aadharkyc($attr['register_proof_number'],$attr['mob'],$attr['email']);
        if ($decoded_resp->status_code != 200) {
        $request->session()->flash("error_msg", "Invalid GST Number. Try with valid GST Number!");
    
               // $request->session()->forget('vendorregistrationotpdata');
                return redirect()->back()->withInput(); 
    }
    
    if ($decoded_resp->status_code == 200) {
         $attr['name_org'] = $decoded_resp->data->business_name;
    }
    
    
    }
    
    if($attr['register_proof'] == 'panno'){
    
        $toverifypan = $attr['pan'];
    
    $decoded_resp = $this->panverifywith_aadharkyc($attr['register_proof_number'],$attr['mob'],$attr['email']);
    
    if ($decoded_resp->status_code != 200) {
        $request->session()->flash("error_msg", "PAN details not valid. Try with correct PAN Number!");
               // $request->session()->forget('vendorregistrationotpdata');
                return redirect()->back()->withInput(); 
    }
    
    if ($decoded_resp->status_code == 200) {
         $attr['name_org'] = $decoded_resp->data->full_name;
    }
    
    }

    if($attr['register_proof'] == 'adharno'){
        if($request->aadharValidName != ''){
            $attr['name_org'] = $request->aadharValidName;
        }else{
            $request->session()->flash("error_msg", "Vendor Registration Failed. Try again!");
            return redirect()->route('vendorregistration');
        } 
    }
    
    if ($request->session()->has('authorizedvendor')) {
        $request->session()->forget("authorizedvendor");
    }
    
    $attr['sess_expiry_time'] = Carbon::now()->addMinutes(10)->toDateTimeString();
    if (count($mmfiles) > 0) {
        $filecount = count($mmfiles['Doc_Name']);
        //dd($filecount);
        $kk = 0;
        foreach ($mmfiles['Doc_Name'] as $keyf => $valuef) {
            $filei = $kk + 1;
            
            if ($request->hasFile("file$filei")) {
                $mmain = $request->file("file$filei");
                $nowval = Carbon::now()->format('YmdHis');
                $newname = $filei.'_'.$nowval.rand(111,9999);
                 $ext = strtolower($request->file("file$filei")->getClientOriginalExtension());
                $file1 = $newname.'.'.$ext;
                //dd($file1);
               // $uploaded1 = Storage::disk('vgnvendorregfiles_uploads')->putFileAs('/', $request->file("file$filei"), $file1);
                $uploaded = Storage::disk('s3')->putFileAs("/vendreg_tempath", $request->file("file$filei"),  $file1);
                $attr['filearray'][$keyf]['temp_path'] = 'https://cdn.vgn.in/vendreg_tempath/'.$file1;
                $attr['filearray'][$keyf]['temp_filename'] = $file1;
                $attr['filearray'][$keyf]['vgnsapname'] = $valuef;
                $attr['filearray'][$keyf]['user_uploadedfname'] = $request->file("file$filei")->getClientOriginalName();
            }
            // else{
            //     $attr['filearray'] = [];
            // }
            $kk++;
        }
        
    }
    $request->session()->put("authorizedvendor", $attr);
    
    return redirect()->route('verifiedvendor'); 
}
else{
    $request->session()->flash("error_msg", "Vendor Registration Failed. Try again!");
           // $request->session()->forget('vendorregistrationotpdata');
            return redirect()->route('vendorregistration'); 
}

        
        
       
        
        
    }

     public function otpregistration(Request $request) {

if($request->session()->has('vendorregistrationotpdata.hashedkey')){
    $sessiondata = $request->session()->get('vendorregistrationotpdata');
    
}
else
{
    return redirect()->route('vendorregistration');
}
       
    return view('newvendorzone.otpverify');
       
    }


     public function postotpregistration(Request $request) {

if($request->session()->has('vendorregistrationotpdata.hashedkey')){
    $sessiondata = $request->session()->get('vendorregistrationotpdata');
    
}
else
{
    return redirect()->route('vendorregistration');
}
       

            

            

            $validate = $this->validate($request, [
            'otp' => 'required|digits:4'
            ]);


            $otptext = $request->otp;
            $tohashtext = "JKL@!)~@!VendorregK23"."$@".$otptext;
            $hashedtext = md5($tohashtext);
            //dd($hashedtext);
            
            if ($sessiondata['hashedkey'] == $hashedtext) {

                $insert = $this->venRegDetails($sessiondata['reg_details']);
        if($insert['Status_Note'] == 'DATA UPDATED'){
            $request->session()->flash("suc_msg", "Vendor Registration Successful. Note your application id: <b>".$insert['Vendor_Reg_no']."</b>");
            $request->session()->forget('vendorregistrationotpdata');
            return redirect()->route('vendorregistration'); 
        }
        else
        {
             $request->session()->flash("error_msg", "Vendor Registration Failed. Try again!");
            $request->session()->forget('vendorregistrationotpdata');
            return redirect()->route('vendorregistration'); 
        }
            
            }else{
                 $count = $sessiondata['triedcount'] + 1;

            if ($sessiondata['triedcount'] > 3) {
            $request->session()->flash("error_msg", "Maximum Number of attempt tried!");
            $request->session()->forget('vendorregistrationotpdata');
            return redirect()->route('vendorregistration'); 
            } 
              $request->session()->put("vendorregistrationotpdata.triedcount", $count);
            $request->session()->flash("error_msg", "OTP Code does not match!");
            
            return redirect()->back();
            }
    }
    
     public function newdashboard(Request $request, $vendid)
    {
       
        if ($request->session()->has('vendorsession')) {
        
            $encrypt = $request->session()->get('vendorsession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $vendorid = $split[0];

            if ($vendid != $vendorid) {
                return $this->newlogout($request);
            }

            $getvendordata = DB::connection('mysql5')->table('vendor')->where('id', '=', $vendorid)->get();

            $pwd_status = $this->is_didnt_passwordchanged($vendorid);
            if ($pwd_status == 0) {
                $request->session()->flash("error_msg", 'Please change the default password. Only if you Change the default password , other functionalities on this portal will work. This is done for security purposes. Please do not share your password with anyone');
                return redirect()->route('newvendor_mydetails_passchange');
            }
            
             $listfiles = Storage::disk('s3')->files("/newcustomerzoneassets/vendorprofileimage/".$vendorid);

             
             if(count($listfiles) > 0){
                $profilepic = config('app.AWS_URL')."/".$listfiles[0];
            }
             else
             {
                $profilepic = config('app.AWS_URL')."/newcustomerzoneassets/img/dummy_male.png";
             }
            
            return view('newvendorzone.dashboard')->with(['getvendordata'=>$getvendordata, 'profilepic' => $profilepic]);
        }
        else{
            return redirect()->route('newvendor_home');
        }
            
        
    }
    
    public function newmydetails(Request $request)
    {
        
        if ($request->session()->has('vendorsession')) {
            $encrypt = $request->session()->get('vendorsession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $vendorid = $split[0];
            $getvendordata = DB::connection('mysql5')->table('vendor')->where('id', '=', $vendorid)->get();

            $pwd_status = $this->is_didnt_passwordchanged($vendorid);
            if ($pwd_status == 0) {
                $request->session()->flash("error_msg", 'Please change the default password. Only if you Change the default password , other functionalities on this portal will work. This is done for security purposes. Please do not share your password with anyone');
                return redirect()->route('newvendor_mydetails_passchange');
            }
            
            $listfiles = Storage::disk('s3')->files("/newcustomerzoneassets/vendorprofileimage/".$vendorid);

             
             if(count($listfiles) > 0){
                $profilepic = config('app.AWS_URL')."/".$listfiles[0];
            }
             else
             {
                $profilepic = config('app.AWS_URL')."/newcustomerzoneassets/img/dummy_male.png";
             }
            
            return view('newvendorzone.mydetails')->with(['getvendordata'=>$getvendordata, 'profilepic' => $profilepic]);
        }
        else{
            return redirect()->route('newvendor_home');
        }
            
        
    }

     public function mybankdetails(Request $request)
    {
        
        if ($request->session()->has('vendorsession')|| $request->session()->has('employeesession')) {
            $encrypt = $request->session()->get('vendorsession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $vendorid = $split[0];
            $getvendordata = DB::connection('mysql5')->table('vendor')->where('id', '=', $vendorid)->get();
            
             $listfiles = Storage::disk('s3')->files("/newcustomerzoneassets/vendorprofileimage/".$vendorid);
             $pwd_status = $this->is_didnt_passwordchanged($vendorid);
            if ($pwd_status == 0) {
                $request->session()->flash("error_msg", 'Please change the default password. Only if you Change the default password , other functionalities on this portal will work. This is done for security purposes. Please do not share your password with anyone');
                return redirect()->route('newvendor_mydetails_passchange');
            }
             
             if(count($listfiles) > 0){
                $profilepic = config('app.AWS_URL')."/".$listfiles[0];
            }
             else
             {
                $profilepic = config('app.AWS_URL')."/newcustomerzoneassets/img/dummy_male.png";
             }
            
            return view('newvendorzone.mybankdetails')->with(['getvendordata'=>$getvendordata, 'profilepic' => $profilepic]);
        }
        else{
            return redirect()->route('newvendor_home');
        }
            
        
    }

    public function editbankdetails(Request $request){

        if ($request->session()->has('vendorsession')) {
            $encrypt = $request->session()->get('vendorsession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $vendorid = $split[0];
            $getvendordata = DB::connection('mysql5')->table('vendor')->where('id', '=', $vendorid)->get();
            
             $listfiles = Storage::disk('s3')->files("/newcustomerzoneassets/vendorprofileimage/".$vendorid);
             $pwd_status = $this->is_didnt_passwordchanged($vendorid);
            if ($pwd_status == 0) {
                $request->session()->flash("error_msg", 'Please change the default password. Only if you Change the default password , other functionalities on this portal will work. This is done for security purposes. Please do not share your password with anyone');
                return redirect()->route('newvendor_mydetails_passchange');
            }
             
             if(count($listfiles) > 0){
                $profilepic = config('app.AWS_URL')."/".$listfiles[0];
            }
             else
             {
                $profilepic = config('app.AWS_URL')."/newcustomerzoneassets/img/dummy_male.png";
             }
             $now = Carbon::now()->toDateTimeString();
             if ($request->session()->has('vendapprovededitbank')) {
                     $getsess = $request->session()->get('vendapprovededitbank');
                     //dd($getsess);
                     if ($getsess['id'] != $vendorid) {
                        $request->session()->forget('vendapprovededitbank');
                        $request->session()->flash("error_msg", "Vendor does not match!");
                        return redirect()->route('vendbankdetails');
                     }
                     $ccheck = DB::connection('mysql5')->table('vendorcomm_updateotp')->where(['vendorid' => $getsess['id'], 'authenticate_type' => $getsess['type']])->get();
                     if (count($ccheck) > 0) {
                        foreach ($ccheck as $key12 => $value12) {
                            $expirytime = $value12->expiry_time;
                            $validated = $value12->validated;
                            $add5mins = Carbon::parse($expirytime)->addMinutes(20)->toDateTimeString();
                        }

                        if (Carbon::parse($now)->gt($add5mins)) {
                            $request->session()->forget('vendapprovededitbank');
                            $request->session()->flash("error_msg", "Token Expired!");
                            return redirect()->route('vendbankdetails');
                        }
                     }
                     else{
                        $request->session()->forget('vendapprovededitbank');
                        $request->session()->flash("error_msg", "Not Authorized!");
                        return redirect()->route('vendbankdetails');
                     }
                     
                 }
            
            return view('newvendorzone.editbankdetails')->with(['getvendordata'=>$getvendordata, 'profilepic' => $profilepic]);
        }
        else{
            return redirect()->route('newvendor_home');
        }
    }

     public function posteditbankdetails(Request $request){

        if ($request->session()->has('vendorsession')) {
            $encrypt = $request->session()->get('vendorsession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $vendorid = $split[0];
            $getvendordata = DB::connection('mysql5')->table('vendor')->where('id', '=', $vendorid)->get();

                        
             $validate = $this->validate($request, [
            'bank_account_no' => 'required|regex:/(^[0-9]+$)+/|min:6|max:26',
            'retype_bank_account_no' => 'required|same:bank_account_no',
            'bank_name' => 'required|regex:/^[\pL\s]+$/u|min:3|max:40',
            'ifsc_code' => 'required|max:11',
            'branch_name' => 'required|regex:/^[\pL\s]+$/u|min:4|max:40'

            ]);

            $now = Carbon::now()->toDateTimeString();
            if ($request->session()->has('vendapprovededitbank')) {
                    $getsess = $request->session()->get('vendapprovededitbank');
                    //dd($getsess);
                    if ($getsess['id'] != $vendorid) {
                       $request->session()->forget('vendapprovededitbank');
                       $request->session()->flash("error_msg", "Vendor does not match!");
                       return redirect()->route('vendbankdetails');
                    }
                    $ccheck = DB::connection('mysql5')->table('vendorcomm_updateotp')->where(['vendorid' => $getsess['id'], 'authenticate_type' => $getsess['type']])->get();
                    if (count($ccheck) > 0) {
                       foreach ($ccheck as $key12 => $value12) {
                           $expirytime = $value12->expiry_time;
                           $validated = $value12->validated;
                           $add5mins = Carbon::parse($expirytime)->addMinutes(20)->toDateTimeString();
                       }

                       if (Carbon::parse($now)->gt($add5mins)) {
                           $request->session()->forget('vendapprovededitbank');
                           $request->session()->flash("error_msg", "Token Expired!");
                           return redirect()->route('vendbankdetails');
                       }
                    }
                    else{
                       $request->session()->forget('vendapprovededitbank');
                       $request->session()->flash("error_msg", "Not Authorized!");
                       return redirect()->route('vendbankdetails');
                    }
                    
                }
              DB::connection('mysql5')->table('vendor')->where(['id' => $vendorid])->update([
                    'act_no'=> $request->bank_account_no,
                     'branch_name'=> $request->branch_name,
                     'ifsc_code'=> $request->ifsc_code,
                     'bank_name'=> $request->bank_name
                     ]); 

             $updatebankinfo = $this->updatebankinfo($vendorid,$request->bank_account_no,$request->branch_name,$request->ifsc_code,$request->bank_name);
             //dd($updatebankinfo);
            
            if (($updatebankinfo['Command'] == 'X')&&($updatebankinfo['code'] == '200')) {
                
                $getcheck = DB::connection('mysql5')->table('vendorcomm_updateotp')->where(['vendorid' => $getsess['id'], 'authenticate_type' => $getsess['type'],'validated' => 1])->get();

                foreach ($getcheck as $keyf => $valuef) {
                    
                DB::connection('mysql5')->table('vendorcomm_updateotp_history')->insert([
                'vendorid' => $valuef->vendorid,
                'mobemaild' => $valuef->mobemaild,
                'otp' => $valuef->otp,
                'authenticate_type' => $valuef->authenticate_type,
                'created_datetime' => $valuef->created_datetime,
                'expiry_time' => $valuef->expiry_time,
                'validated' => $valuef->validated,
                'authenticate_req_attempt' => $valuef->authenticate_req_attempt,
                'newdata' => $valuef->newdata,
                'newdataotp' => $valuef->newdataotp,
                'newdataotpattempt' => $valuef->newdataotpattempt,
                'newdataotpexpiry' => $valuef->newdataotpexpiry
             ]);
                }
                $request->session()->forget('vendapprovededitbank');
                DB::connection('mysql5')->table('vendorcomm_updateotp')->where(['vendorid' => $getsess['id'], 'authenticate_type' => $getsess['type'],'validated' => 1])->delete();

		 $getipdetails = $this->getip($request);
                $arr111 = [];
                $arr111['Vendor_ID'] = $vendorid;
                $arr111['URL'] = $request->url();
                $arr111['IP_Address'] = $getipdetails['iprequested'];
                $arr111['From_Mobile'] = $getipdetails['ismobile'];
                $arr111['From_Desktop'] = $getipdetails['isdesktop'];
                $arr111['Time_Stamp'] = Carbon::now()->toDateTimeString();
               $arr111resp = $this->requestipsend_tosap($arr111);

            $request->session()->flash("suc_msg", "Bank Details Updated Successfully!");
            return redirect()->route('vendbankdetails');
            }else{
                $request->session()->forget('vendapprovededitbank');
                $request->session()->flash("error_msg", "Sorry! Bank Details not Updated Successfully!");
                DB::connection('mysql5')->table('vendorcomm_updateotp')->where(['vendorid' => $getsess['id'], 'authenticate_type' => $getsess['type'],'validated' => 1])->delete();
            return redirect()->back();
            }

        }
        else{
            return redirect()->route('newvendor_home');
        }
    }
    
    public function newmydetails_passchange(Request $request)
    {
        
        if ($request->session()->has('vendorsession')) {
            $encrypt = $request->session()->get('vendorsession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $vendorid = $split[0];
            $getvendordata = DB::connection('mysql5')->table('vendor')->where('id', '=', $vendorid)->get();
            
             $listfiles = Storage::disk('s3')->files("/newcustomerzoneassets/vendorprofileimage/".$vendorid);

             
             if(count($listfiles) > 0){
                $profilepic = config('app.AWS_URL')."/".$listfiles[0];
            }
             else
             {
                $profilepic = config('app.AWS_URL')."/newcustomerzoneassets/img/dummy_male.png";
             }
            
            return view('newvendorzone.mydetails_changepass')->with(['getvendordata'=>$getvendordata, 'profilepic' => $profilepic]);
        }
        else{
            return redirect()->route('newvendor_home');
        }
            
        
    }
    
     public function newpasswordchange(Request $request) {

        if ($request->session()->has('vendorsession')) {
            $encrypt = $request->session()->get('vendorsession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $vendorid = $split[0];
            $getvendordata = DB::connection('mysql5')->table('vendor')->where('id', '=', $vendorid)->get();
            
       
        $validate = $this->validate($request, [
            
			'newpass' => 'required|min:6|max:12',
            'retypepass' => 'required|same:newpass'
			]);

        $checkpassword = DB::connection('mysql5')->table('vendor')->where('id', '=', $vendorid)->get();
            foreach ($checkpassword as $key11 => $value11) {
                $hashedpassword = $value11->password;
            }
            
            
        

            if (Hash::check($request->newpass, $hashedpassword) === true) {
                $request->session()->flash("error_msg", "The New password cannot be same as old password!");
            return redirect()->back();
            }
            
            $now = Carbon::now()->toDateTimeString();
            foreach ($getvendordata as $value) {
                $pwdcount = $value->pwd_count;
            }

            if ($request->session()->has('vendapprovededitpassword')) {
                $getsess = $request->session()->get('vendapprovededitpassword');
                //dd($getsess);
                if ($getsess['id'] != $vendorid) {
                   $request->session()->forget('vendapprovededitpassword');
                   $request->session()->flash("error_msg", "Vendor does not match!");
                   return redirect()->route('newvendor_mydetails_passchange');
                }
                $ccheck = DB::connection('mysql5')->table('vendorcomm_updateotp')->where(['vendorid' => $getsess['id'], 'authenticate_type' => $getsess['type']])->get();
                if (count($ccheck) > 0) {
                   foreach ($ccheck as $key12 => $value12) {
                       $expirytime = $value12->expiry_time;
                       $validated = $value12->validated;
                       $add5mins = Carbon::parse($expirytime)->addMinutes(20)->toDateTimeString();
                   }

                   if (Carbon::parse($now)->gt($add5mins)) {
                       $request->session()->forget('vendapprovededitpassword');
                       $request->session()->flash("error_msg", "Token Expired!");
                       return redirect()->route('newvendor_mydetails_passchange');
                   }
                }
                else{
                   $request->session()->forget('vendapprovededitpassword');
                   $request->session()->flash("error_msg", "Not Authorized!");
                   return redirect()->route('newvendor_mydetails_passchange');
                }
                
            }

            $newpwdcount = $pwdcount + 1;
            $request->session()->forget('vendapprovededitpassword');
            DB::connection('mysql5')->table('vendorcomm_updateotp')->where(['vendorid' => $getsess['id'], 'authenticate_type' => $getsess['type'],'validated' => 1])->delete();
            
            DB::connection('mysql5')->table('vendor')->where('id', '=', $vendorid)->update(['password' => Hash::make($request->newpass, ['rounds' => 12]), 'pwd_updated' => $now, 'pwd_count' => $newpwdcount ]);
		 $getipdetails = $this->getip($request);
                $arr111 = [];
                $arr111['Vendor_ID'] = $vendorid;
                $arr111['URL'] = $request->url();
                $arr111['IP_Address'] = $getipdetails['iprequested'];
                $arr111['From_Mobile'] = $getipdetails['ismobile'];
                $arr111['From_Desktop'] = $getipdetails['isdesktop'];
                $arr111['Time_Stamp'] = Carbon::now()->toDateTimeString();
               $arr111resp = $this->requestipsend_tosap($arr111);

            $request->session()->flash("suc_msg", "successfully New Password has been updated!");
            return redirect()->back();

        

         }
        else{
            return redirect()->route('newvendor_home');
        }
        


    }
    
    
    public function newvendcomplaints(Request $request)
    {
        if ($request->session()->has('vendorsession')) {
            $encrypt = $request->session()->get('vendorsession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $vendorid = $split[0];
            $getvendordata = DB::connection('mysql5')->table('vendor')->where('id', '=', $vendorid)->get();
            $getcomplaints = DB::connection('mysql5')->table('complaints')->where('vendor_id', '=', $vendorid)->orderBy('updated', 'desc')->get();
            $listfiles = Storage::disk('s3')->files("/newcustomerzoneassets/vendorprofileimage/".$vendorid);

             $pwd_status = $this->is_didnt_passwordchanged($vendorid);
            if ($pwd_status == 0) {
                $request->session()->flash("error_msg", 'Please change the default password. Only if you Change the default password , other functionalities on this portal will work. This is done for security purposes. Please do not share your password with anyone');
                return redirect()->route('newvendor_mydetails_passchange');
            }

             if(count($listfiles) > 0){
                $profilepic = config('app.AWS_URL')."/".$listfiles[0];
            }
             else
             {
                $profilepic = config('app.AWS_URL')."/newcustomerzoneassets/img/dummy_male.png";
             }
            
            return view('newvendorzone.complaints')->with(['getvendordata' => $getvendordata, 'getcomplaints'=> $getcomplaints, 'profilepic' => $profilepic]);
        }
        else{
            return redirect()->route('newvendor_home');
        }
    }
    
     public function newraisecomplaints(Request $request)
    {
        if ($request->session()->has('vendorsession')) {
            $encrypt = $request->session()->get('vendorsession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $vendorid = $split[0];
            $getvendordata = DB::connection('mysql5')->table('vendor')->where('id', '=', $vendorid)->get();
            $pwd_status = $this->is_didnt_passwordchanged($vendorid);
            if ($pwd_status == 0) {
                $request->session()->flash("error_msg", 'Please change the default password. Only if you Change the default password , other functionalities on this portal will work. This is done for security purposes. Please do not share your password with anyone');
                return redirect()->route('newvendor_mydetails_passchange');
            }
            $result = $this->getHelp($vendorid);
           
            $getnoc = array();
            $getproject = array();
            
		if(!empty($result['Nature_Of_Complaints']))
		{
            if(array_key_exists('0', $result['Nature_Of_Complaints']))
			{
				$getnoc =$result['Nature_Of_Complaints'];
				
			}
            else
            {
                $getnoc[0] =$result['Nature_Of_Complaints'];
            }
			
		}
		if(!empty($result['Project_Details']))
		{
			if(array_key_exists('0', $result['Project_Details']))
			{
				$getproject =$result['Project_Details'];
				
			}
            else
            {
                $getproject[0] =$result['Project_Details'];
            }
		}
            
            if(empty($getproject) || empty($getnoc)){
                return redirect()->route('newvendcomplaints');
            }
            
           
            foreach ($getvendordata as $value) {
                $valid = $value->valid;
            }

            if($valid == 2){
                return redirect()->route('newvendcomplaints');
            }
            
             $listfiles = Storage::disk('s3')->files("/newcustomerzoneassets/vendorprofileimage/".$vendorid);

             
             if(count($listfiles) > 0){
                $profilepic = config('app.AWS_URL')."/".$listfiles[0];
            }
             else
             {
                $profilepic = config('app.AWS_URL')."/newcustomerzoneassets/img/dummy_male.png";
             }
            
            return view('newvendorzone.raisecomplaints')->with(['getvendordata'=> $getvendordata, 'getproject' => $getproject, 'getnoc'=> $getnoc, 'profilepic' => $profilepic]);
        }
        else{
            return redirect()->route('newvendor_home');
        }
    }
    
    
    public function newpostraisecomplaints(Request $request)
    {        
        if ($request->session()->has('vendorsession')) {
            $encrypt = $request->session()->get('vendorsession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $vendorid = $split[0];
            $getvendordata = DB::connection('mysql5')->table('vendor')->where('id', '=', $vendorid)->get();
            
            /*$getproject = DB::connection('mysql3')->table('projects')->where('cust_id', '=', $customerid)->get();*/

            
                      

             $validate = $this->validate($request, [
            'complaintproject' => 'required',
            'complaintnature' => 'required',
            'desccomp' => 'required|max:900'
			]);
            
            $projectname = $request->complaintproject;
           /* $projectname = '';
            $unitname = ''; 

             if (!empty($getproject)) {
                foreach ($getproject as $pvalue) {
                    
                    if(($pvalue->project_id == $request->complaintproject)&&($pvalue->unit == $request->complaintunit))
                    {
                        $projectname = $pvalue->pname;
                        $unitname = $pvalue->unit_nm; 
                    }
                }
            }*/

            if ($projectname != '') {
                
            
            $now = Carbon::now();
	//dd($request->complaintproject);	
        $SavecustomertoSAP = $this->savecomplaint($vendorid, $request->complaintproject,$request->complaintnature,$request->desccomp );
              
                
            
            DB::connection('mysql5')->table('complaints')->insert(['complaint_no' => $SavecustomertoSAP['Compliant_no'],
            'project' => $projectname,
            'vendor_id' => $vendorid,
            'vendor_care_name' => $request->complaintnature,
            'nature' => $request->complaintnature,
            'description' => $request->desccomp,
            'vgn_status' => 'OPEN',
            'vend_status' => 'OPEN',
            'final_status' => 'OPEN',
             'date' => date('Y-m-d'),
             'created' => $now,
             'updated' => $now, ]);
                
            
                $sapdata = $this->getvendor($vendorid);
                
                 $sap_compl = array();
                    if (array_key_exists('Complaiant_Details', $sapdata)) {
                    
                    $sapcomplaints = $sapdata['Complaiant_Details'];
                    if (array_key_exists('0', $sapcomplaints)) {
                        $sap_compl = $sapcomplaints;
                    }
                    else
                    {
                        $sap_compl[0] = $sapcomplaints;
                    }
                
                 foreach ($sap_compl as $sapcomplkey => $sapcomplvalue) {
                    if ($SavecustomertoSAP['Compliant_no'] == $sapcomplvalue['Complaint_Number']) {
                                
                                DB::connection('mysql5')->table('complaints')->where('vendor_id', '=', $vendorid)
                                ->where('complaint_no','=',$sapcomplvalue['Complaint_Number'])
                                ->update(['vendor_care_name' => $sapcomplvalue['Vendor_Care_Name']
                                 ]);
                            }
                           

                            
                            
                        }
                    }
                
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
            return redirect()->route('newvendor_home');
        }
    }
    
    public function newclosecomplaints(Request $request)
    {
        if ($request->session()->has('vendorsession')) {
            $encrypt = $request->session()->get('vendorsession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $vendorid = $split[0];
            $getvendordata = DB::connection('mysql5')->table('vendor')->where('id', '=', $vendorid)->get();

            $validate = $this->validate($request, [
            'close' => 'required'
			]);

            $now = Carbon::now();
            $checkcomplaint = DB::connection('mysql5')->table('complaints')->where('vendor_id', '=', $vendorid)->where('complaint_no', '=', $request->close)->where('vend_status', '=', 'OPEN')->count();
            
            if ($checkcomplaint == 1) {

               $Closecustomercomplaint = $this->closecomplaint($vendorid, $request->close); 
                
               if ($Closecustomercomplaint['Status_Note']=="CLOSED") {
                   DB::connection('mysql5')->table('complaints')->where('vendor_id','=', $vendorid)->where('complaint_no','=',$request->close)->update(['vend_status' => 'CLOSE', 'updated' => $now]);
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
            return redirect()->route('newvendor_home');
        }
        
    }
    
    public function newpaymenthistory(Request $request)
    {
        if ($request->session()->has('vendorsession')) {
            $encrypt = $request->session()->get('vendorsession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $vendorid = $split[0];
            $getvendordata = DB::connection('mysql5')->table('vendor')->where('id', '=', $vendorid)->get();
            $payment = DB::connection('mysql5')->table('payments')->where('vend_id', '=', $vendorid)->get();
            
            $listfiles = Storage::disk('s3')->files("/newcustomerzoneassets/vendorprofileimage/".$vendorid);
            $pwd_status = $this->is_didnt_passwordchanged($vendorid);
            if ($pwd_status == 0) {
                $request->session()->flash("error_msg", 'Please change the default password. Only if you Change the default password , other functionalities on this portal will work. This is done for security purposes. Please do not share your password with anyone');
                return redirect()->route('newvendor_mydetails_passchange');
            }
             
             if(count($listfiles) > 0){
                $profilepic = config('app.AWS_URL')."/".$listfiles[0];
            }
             else
             {
                $profilepic = config('app.AWS_URL')."/newcustomerzoneassets/img/dummy_male.png";
             }
           
            return view('newvendorzone.paymenthistory')->with(['getvendordata'=> $getvendordata, 'payment' => $payment, 'profilepic' => $profilepic]);
        }
        else{
            return redirect()->route('newvendor_home');
        }
    }
    
    public function newbidcorner(Request $request){
        
         if ($request->session()->has('vendorsession')) {
            $encrypt = $request->session()->get('vendorsession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $vendorid = $split[0];
            $getvendordata = DB::connection('mysql5')->table('vendor')->where('id', '=', $vendorid)->get();
             
              $listfiles = Storage::disk('s3')->files("/newcustomerzoneassets/vendorprofileimage/".$vendorid);
              $pwd_status = $this->is_didnt_passwordchanged($vendorid);
            if ($pwd_status == 0) {
                $request->session()->flash("error_msg", 'Please change the default password. Only if you Change the default password , other functionalities on this portal will work. This is done for security purposes. Please do not share your password with anyone');
                return redirect()->route('newvendor_mydetails_passchange');
            }
             
             if(count($listfiles) > 0){
                $profilepic = config('app.AWS_URL')."/".$listfiles[0];
            }
             else
             {
                $profilepic = config('app.AWS_URL')."/newcustomerzoneassets/img/dummy_male.png";
             }
             
             $getbids = $this->fetchbids($vendorid);
             
          	$detailedspec_attachments = [];

             if (array_key_exists('Bid_Details', $getbids)) {

                if(array_key_exists('0',$getbids['Bid_Details'])){
                $main = $getbids['Bid_Details'];
            }
            else
            {
                $main[0] = $getbids['Bid_Details'];
            }
//dd($main);
            foreach ($main as $keymain => $valuemain) {
                
            $detailedspec_attachments[$valuemain['Bid_Number']] = [];

                 
           $filelist = Storage::disk('s3')->files("/vendor_designdoc/");
                

        

if(count($filelist) > 0 ){
                  foreach ($filelist as  $value12) {
                    $value12 = str_replace('vendor_designdoc/', '', $value12);
        $filearray12 = pathinfo($value12);
        
        $ext12 = $filearray12['extension'];
        
        $file12 = $filearray12['filename'];


           if (array_key_exists('Bid_Number', $valuemain)) {
	if($valuemain['Bid_Number'] != ''){ 
            if (strpos(strtoupper($file12), $valuemain['Bid_Number']) !== false) {
                $detailedspec_attachments[$valuemain['Bid_Number']][] = 'https://cdn.vgn.in/vendor_designdoc'.'/'.$file12.'.'.$ext12;
               }
		}
		}
            

    }
}
}
                 
             } 

             //dd($detailedspec_attachments);
           
            return view('newvendorzone.newbidcorner')->with(['getvendordata'=> $getvendordata, 'getbids' => $getbids,'profilepic' => $profilepic, 'detailedspec_attachments' => $detailedspec_attachments]);
        }
        else{
            return redirect()->route('newvendor_home');
        }
        
    }
    
    public function postnewbidcorner(Request $request){
       
        
         if ($request->session()->has('vendorsession')) {
            $encrypt = $request->session()->get('vendorsession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $vendorid = $split[0];
             
              $validate = $this->validate($request, [
            'vendorremarks' => 'required',
            'bidno' => 'required'
			]);
             
            $getbids = $this->fetchbids($vendorid);
             //dd($getbids);
    $saveremarks = $this->savevendorremarks($vendorid, $request->bidno, $request->vendorremarks);
            
           if($saveremarks['Status_Code'] == 'SUCCESS'){
               $request->session()->flash("suc_msg", "Vendor Remarks Updated Successfully!");
                return redirect()->back();
           }
             else
             {
                  $request->session()->flash("error_msg", "Vendor Remarks not updated. Try Again!");
                return redirect()->back();
             }
             
           
            
        }
        else{
            return redirect()->route('newvendor_home');
        }
    }
    
    
     public function rateupdate(Request $request, $refno){
         
         if($refno == null){
             return redirect()->route('newvendor_home');
         }
        
         if ($request->session()->has('vendorsession')) {
            $encrypt = $request->session()->get('vendorsession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $vendorid = $split[0];
            $getvendordata = DB::connection('mysql5')->table('vendor')->where('id', '=', $vendorid)->get();
             
              $listfiles = Storage::disk('s3')->files("/newcustomerzoneassets/vendorprofileimage/".$vendorid);
              $pwd_status = $this->is_didnt_passwordchanged($vendorid);
            if ($pwd_status == 0) {
                $request->session()->flash("error_msg", 'Please change the default password. Only if you Change the default password , other functionalities on this portal will work. This is done for security purposes. Please do not share your password with anyone');
                return redirect()->route('newvendor_mydetails_passchange');
            }

             
             if(count($listfiles) > 0){
                $profilepic = config('app.AWS_URL')."/".$listfiles[0];
            }
             else
             {
                $profilepic = config('app.AWS_URL')."/newcustomerzoneassets/img/dummy_male.png";
             }
             
             $getbids = $this->fetchbids($vendorid);
                        //dd($getbids);

                        $detailedspec_attachments = [];

                        if (array_key_exists('Bid_Details', $getbids)) {
           
                           if(array_key_exists('0',$getbids['Bid_Details'])){
                           $main = $getbids['Bid_Details'];
                       }
                       else
                       {
                           $main[0] = $getbids['Bid_Details'];
                       }
           //dd($main);
                       foreach ($main as $keymain => $valuemain) {
                           
                       $detailedspec_attachments[$valuemain['Bid_Number']] = [];
           
                            
                      $filelist = Storage::disk('s3')->files("/vendor_designdoc/");
                           
           
                   
           
           if(count($filelist) > 0 ){
            $jjo = 0;
                             foreach ($filelist as  $value12) {
                               $value12 = str_replace('vendor_designdoc/', '', $value12);
                   $filearray12 = pathinfo($value12);
                   
                   $ext12 = $filearray12['extension'];
                   
                   $file12 = $filearray12['filename'];
           
           
                      if (array_key_exists('Bid_Number', $valuemain)) {
               if($valuemain['Bid_Number'] != ''){ 
                       if (strpos(strtoupper($file12), $valuemain['Bid_Number']) !== false) {
                           $brandfilename = substr($file12, 19);
                           //dd($brandfilename);
                           $detailedspec_attachments[$valuemain['Bid_Number']][$jjo]['br_link'] = 'https://cdn.vgn.in/vendor_designdoc'.'/'.$file12.'.'.$ext12;
                           $detailedspec_attachments[$valuemain['Bid_Number']][$jjo]['br_name'] = $brandfilename;
                          }
                   }
                   }
                       
                   $jjo++;
               }
           }
           }
                            
                        }
                        
           
            return view('newvendorzone.rateupdate')->with(['getvendordata'=> $getvendordata, 'getbids' => $getbids,'refno' => $refno,'profilepic' => $profilepic, 'detailedspec_attachments' => $detailedspec_attachments]);
        }
        else{
            return redirect()->route('newvendor_home');
        }
        
    }
    
      public function postrateupdate(Request $request){
       
        
         if ($request->session()->has('vendorsession')) {
            $encrypt =$request-> session()->get('vendorsession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $vendorid = $split[0];
             
             $bidupdate = $this->bidUpdate($vendorid, $request->bidataArray);
                //dd($bidupdate);
             $ref = $bidupdate['Bid_Ref_No'];
            if($bidupdate['Status_Note'] == "Reference Number with Rate Updated"){
                $status = "Bid $ref Rate Updated successfully!";
                  return response()->json([$status]);
           }
             else
             {
				 
                 $status = "Bid not updated. Try Again!";
				 //$status = $bidupdate['Status_Note'];
                //$status = $bidupdate;
                   return response()->json([
    $status
]);
             }
             
           
            
        }
        else{
            return redirect()->route('newvendor_home');
        }
    
}




public function recentbids(Request $request){
        
        if ($request->session()->has('vendorsession')) {
            $encrypt = $request->session()->get('vendorsession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $vendorid = $split[0];
            $getvendordata = DB::connection('mysql5')->table('vendor')->where('id', '=', $vendorid)->get();
             
              $listfiles = Storage::disk('s3')->files("/newcustomerzoneassets/vendorprofileimage/".$vendorid);
              $pwd_status = $this->is_didnt_passwordchanged($vendorid);
            if ($pwd_status == 0) {
                $request->session()->flash("error_msg", 'Please change the default password. Only if you Change the default password , other functionalities on this portal will work. This is done for security purposes. Please do not share your password with anyone');
                return redirect()->route('newvendor_mydetails_passchange');
            }

             
             if(count($listfiles) > 0){
                $profilepic = config('app.AWS_URL')."/".$listfiles[0];
            }
             else
             {
                $profilepic = config('app.AWS_URL')."/newcustomerzoneassets/img/dummy_male.png";
             }
             
             $getrecentbids = $this->myrecentbids($vendorid);
            //$recentbids = $getrecentbids['BID_DETAILS'];


             $newremarks = array();
            if(array_key_exists("0", $getrecentbids['VENDOR_REMARKS']) === true)
                {
                    $newremarks = $getrecentbids['VENDOR_REMARKS'];
                }
            else
                {
                    $newremarks[0] = $getrecentbids['VENDOR_REMARKS'];
                }


                if(array_key_exists("0", $getrecentbids['BID_DETAILS']) === true)
                {
                    $recentbids = $getrecentbids['BID_DETAILS'];
                }
            else
                {
                    $recentbids[0] = $getrecentbids['BID_DETAILS'];
                }

                
           
            return view('newvendorzone.recentbids')->with(['getvendordata'=> $getvendordata, 'recentbids' => $recentbids,'newremarks' => $newremarks,'profilepic' => $profilepic]);
        }
        else{
            return redirect()->route('newvendor_home');
        }
    }


    

	public function recentbidsonclick(Request $request, $refno){
        
         if($refno == null){
             return redirect()->route('newvendor_home');
         }
        
         if ($request->session()->has('vendorsession')) {
            $encrypt = $request->session()->get('vendorsession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $vendorid = $split[0];
            $getvendordata = DB::connection('mysql5')->table('vendor')->where('id', '=', $vendorid)->get();
             
              $listfiles = Storage::disk('s3')->files("/newcustomerzoneassets/vendorprofileimage/".$vendorid);
              $pwd_status = $this->is_didnt_passwordchanged($vendorid);
            if ($pwd_status == 0) {
                $request->session()->flash("error_msg", 'Please change the default password. Only if you Change the default password , other functionalities on this portal will work. This is done for security purposes. Please do not share your password with anyone');
                return redirect()->route('newvendor_mydetails_passchange');
            }

             
             if(count($listfiles) > 0){
                $profilepic = config('app.AWS_URL')."/".$listfiles[0];
            }
             else
             {
                $profilepic = config('app.AWS_URL')."/newcustomerzoneassets/img/dummy_male.png";
             }
             
              $getrecentbids = $this->myrecentbids($vendorid);
              //dd($getrecentbids);

              if(array_key_exists("0", $getrecentbids['BID_DETAILS']) === true)
                {
                    $recentbids = $getrecentbids['BID_DETAILS'];
                }
            else
                {
                    $recentbids[0] = $getrecentbids['BID_DETAILS'];
                }

                //dd($recentbids);
                $disc_recentbids = [];
                foreach ($recentbids as $key12 => $value12) {
                    if ($value12['Bid_Number'] == $refno) {
                        
                    
                    //dd($value12);
                    $negotiated_price_details = $this->negotiated_price_details($vendorid, $value12["Bid_Number"]);
                    //dd($negotiated_price_details);
                    $disc_recentbids[$key12]["Discount_bid_no"] = $value12["Bid_Number"];

                    if (array_key_exists('Disc_Table', $negotiated_price_details)) {
                        
                

                    $disc_recentbids[$key12]["Discount_rate_arr"] = $negotiated_price_details["Disc_Table"];
                    

                    }
                    else{
                        $disc_recentbids[$key12]["Discount_rate_arr"] = [];
                    }

                    if ($negotiated_price_details['Disc_Upd_Flag'] == 'OPEN') {
                        $disc_recentbids[$key12]["Discount_edit_status"] = trim($negotiated_price_details["Disc_Upd_Flag"]);
                    }
                    else{
                        $disc_recentbids[$key12]["Discount_edit_status"] = trim($negotiated_price_details["Disc_Upd_Flag"]);
                    }



                }
                    
                }
                //dd($disc_recentbids);
                $fdisc_bids = [];

                foreach ($disc_recentbids as $key111 => $value111) {

                    if (!empty($value111['Discount_rate_arr'])) {
                        
                    $nn = [];
                                if(array_key_exists("0", $value111['Discount_rate_arr']) === true)
                            {
                                $nn['Discount_rate_arr'] = $value111['Discount_rate_arr'];
                            }
                        else
                            {
                                $nn['Discount_rate_arr'][0] = $value111['Discount_rate_arr'];
                            }


                    foreach ($nn['Discount_rate_arr'] as $key222 => $value222) {
                        if (!empty(trim($value222['Mat_No']))) {
                            
                        if(array_key_exists('Brand_Name', $value222) === false){ $value222['Brand_Name'] = '';}
                        $fdisc_bids[$key222]['Discount_bid_no'] = trim($value111['Discount_bid_no']);
                        $fdisc_bids[$key222]['Discount_edit_status'] = trim($value111['Discount_edit_status']);
                        $fdisc_bids[$key222]['Material_no'] = trim($value222['Mat_No']);
                        $fdisc_bids[$key222]['Brand_Name'] = trim($value222['Brand_Name']);
                        $fdisc_bids[$key222]['Disc_Perc'] = trim($value222['Disc_Perc']);

                        }
                    }

                    }
                    else{
                        $fdisc_bids[0]['Discount_bid_no'] = trim($value111['Discount_bid_no']);
                        $fdisc_bids[0]['Discount_edit_status'] = trim($value111['Discount_edit_status']);
                        $fdisc_bids[0]['Material_no'] = '';
                        $fdisc_bids[0]['Brand_Name'] = '';
                        $fdisc_bids[0]['Disc_Perc'] = '';
                    }
                }

                $opentoeditnew = 'CLOSED';
                foreach ($fdisc_bids as $key333 => $value333) {
                    if ($value333['Discount_edit_status'] == 'OPEN') {
                        $opentoeditnew = 'OPEN';
                    }
                }
            //dd($opentoeditnew);
                   
            return view('newvendorzone.recentbidonclick')->with(['getvendordata'=> $getvendordata, 'getbids' => $getrecentbids,'disc_recentbids' => $fdisc_bids,'refno' => $refno,'profilepic' => $profilepic,'opentoeditnew' => $opentoeditnew]);
        }
        else{
            return redirect()->route('newvendor_home');
        }
        
    }
        
     public function newvendreferfriend(Request $request)
    {
         if ($request->session()->has('vendorsession')) {
            $encrypt = $request->session()->get('vendorsession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $vendorid = $split[0];
            $getvendordata = DB::connection('mysql5')->table('vendor')->where('id', '=', $vendorid)->get();
            $pwd_status = $this->is_didnt_passwordchanged($vendorid);
            if ($pwd_status == 0) {
                $request->session()->flash("error_msg", 'Please change the default password. Only if you Change the default password , other functionalities on this portal will work. This is done for security purposes. Please do not share your password with anyone');
                return redirect()->route('newvendor_mydetails_passchange');
            }
           
            
           $getunsold = $this->getUnsold($vendorid);
           $ongoingprojects = $getunsold['UNSOLD_PROJECTS'];
           
              $listfiles = Storage::disk('s3')->files("/newcustomerzoneassets/vendorprofileimage/".$vendorid);

             
             if(count($listfiles) > 0){
                $profilepic = config('app.AWS_URL')."/".$listfiles[0];
            }
             else
             {
                $profilepic = config('app.AWS_URL')."/newcustomerzoneassets/img/dummy_male.png";
             }
             
            return view('newvendorzone.referfriend')->with(['getvendordata'=> $getvendordata, 'ongoingprojects' => $ongoingprojects, 'profilepic' => $profilepic]);
        }
        else{
            return redirect()->route('newvendor_home');
        }
    }
    
    public function newpostvendreferfriend(Request $request)
    {
        if ($request->session()->has('vendorsession')) {
            $encrypt = $request->session()->get('vendorsession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $vendorid = $split[0];
            $getvendordata = DB::connection('mysql5')->table('vendor')->where('id', '=', $vendorid)->get();
            
            $getunsold = $this->getUnsold($vendorid);
            $ongoingprojects = $getunsold['UNSOLD_PROJECTS'];

             $validate = $this->validate($request, [
            'name' => 'required',
			'mobile' => 'required|regex:/[0-9]{10}/',
            'email' => 'required|email',
            'intr' => 'required'
			]);
            
            $insertreferfriend = $this->sappostreferFriend($vendorid,$request->name, $request->email, $request->mobile, $request->intr);
            //dd($insertreferfriend);
           
            if ($insertreferfriend['Save_Note'] == 'Referal Accepted Successfully') {
             $request->session()->flash("suc_msg", "Referal Accepted Successfully");
               return redirect()->route('newvendreferfriend');   
            }
            else{
                $request->session()->flash("error_msg", "Referal Not accepted try again!");
               return redirect()->route('newvendreferfriend');   
            }
             
                   
            
            return view('newvendorzone.referfriend')->with(['getvendordata'=> $getvendordata, 'ongoingprojects' => $ongoingprojects]);
        }
        else{
            return redirect()->route('newvendor_home');
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

 public function smscurlalt($message, $mobileno)
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
    'sender' => 'VGNALT'
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
$mail->Username = "vendorzone3";

//Password to use for SMTP authentication
$mail->Password = "Vgn@321";

//Set who the message is to be sent from
$mail->setFrom('vendorzone3@vgn.in', 'VGN Vendor Zone');

//Set an alternative reply-to address
$mail->addReplyTo('no-reply@vgn.in', 'VGN Vendor Zone');

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
    

    public function newcommunication(Request $request, $size = null, $page = null) {
      
                        if ($request->session()->has('vendorsession')) {
            $encrypt = $request->session()->get('vendorsession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $vendorid = $split[0];

            $pwd_status = $this->is_didnt_passwordchanged($vendorid);
            if ($pwd_status == 0) {
                $request->session()->flash("error_msg", 'Please change the default password. Only if you Change the default password , other functionalities on this portal will work. This is done for security purposes. Please do not share your password with anyone');
                return redirect()->route('newvendor_mydetails_passchange');
            }
            
              $getvendordata = DB::connection('mysql5')->table('vendor')->where('id', '=', $vendorid)->get();       
             
             foreach ($getvendordata as $value) {
                 $response = [
                'vendorno' => $value->id,
                'name' => $value->Name,
                
                             
            ];
             }


                //$projects = DB::connection('mysql3')->table('projects')->where('vend_id', '=', $customerid)->get();

              $getpwdforsap = DB::connection('mysql5')->table('sapcustomer')->where('vendorid', '=', $vendorid)->get();
                     foreach ($getpwdforsap as $sapkey => $sapvalue) {
                         $sapvendorid = $sapvalue->vendorid;
                         $sapvendorpassword = Crypt::decrypt($sapvalue->password);
                     }

                     
         if ($sapvendorpassword != '') {
             
           
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
		$server = '{vendor.vgn.in:143/notls}INBOX';
		$login = $vendorid.'@vendor.vgn.in';
		$password = $sapvendorpassword;
        $pagehtml = '';

		if($connection = @imap_open($server, $login, $password))
		{
		//var_dump($connection);
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
        $pagehtml.="'><a href='/newvendorzone/communication/".$pg_s."/".$i."'>".$i."</a></li>";
        $mailarray['pages'][] =['pageno'=>$i,'link'=>"http://vgn.in/newvendorzone/communication/".$pg_s."/".$i];
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
						$name = 'vendorattachments/'.$cid.'-'.$messageNumber.'-'.$partNumber.'-'.$filename;
						file_put_contents($name, $attachment);
						// echo '<div class="float-left padding10"><h6>Attachment '.$att.'</h6><a href="'.$name . '" target="_blank" >'.$filename.'</a></div>';
                        $newname = "http://www.vgn.in/vendorattachments/".$cid.'-'.$messageNumber.'-'.$partNumber.'-'.$filename;
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
            
        $listfiles = Storage::disk('s3')->files("/newcustomerzoneassets/vendorprofileimage/".$vendorid);

             
             if(count($listfiles) > 0){
                $profilepic = config('app.AWS_URL')."/".$listfiles[0];
            }
             else
             {
                $profilepic = config('app.AWS_URL')."/newcustomerzoneassets/img/dummy_male.png";
             }
            
        return view('newvendorzone.communication')->with(['getvendordata'=> $getvendordata, 'mailarray' => $mailarray, 'profilepic' => $profilepic]);
            

	}
	}
                        
           

    }
    else{
                            return redirect()->route('newvendor_home');
                        }
    
}
    
    
    
    
    public function newlogout(Request $request)
    {
        if ($request->session()->has('vendorsession')) {
            //$encrypt = session()->get('vendorsession');
            $request->session()->forget('vendorsession');
            $request->session()->flush();
            $request->session()->invalidate();
            return redirect()->route('newvendor_home');
        }
        else{
            return redirect()->route('newvendor_home');
        }
    }
    
    
    public function newvendeditphoto(Request $request){
        
         if ($request->session()->has('vendorsession')) {
            $encrypt = $request->session()->get('vendorsession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $vendorid = $split[0];
            $getvendordata = DB::connection('mysql5')->table('vendor')->where('id', '=', $vendorid)->get();


            $pwd_status = $this->is_didnt_passwordchanged($vendorid);
            if ($pwd_status == 0) {
                $request->session()->flash("error_msg", 'Please change the default password. Only if you Change the default password , other functionalities on this portal will work. This is done for security purposes. Please do not share your password with anyone');
                return redirect()->route('newvendor_mydetails_passchange');
            }
            
             
            $listfiles = Storage::disk('s3')->files("/newcustomerzoneassets/vendorprofileimage/".$vendorid);

             
             if(count($listfiles) > 0){
                $profilepic = config('app.AWS_URL')."/".$listfiles[0];
            }
             else
             {
                $profilepic = config('app.AWS_URL')."/newcustomerzoneassets/img/dummy_male.png";
             }
            //$exists = Storage::disk('local')->has("customersprofileimage/$customerid.jpg");
            
            return view('newvendorzone.editphoto')->with(['getvendordata'=> $getvendordata, 'profilepic' => $profilepic]);
             
         }else
         {
             return redirect()->route('newvendor_home');
         }
        
    }
    
    public function newvendposteditphoto(Request $request){
        
         if ($request->session()->has('vendorsession')) {
            $encrypt = $request->session()->get('vendorsession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $vendorid = $split[0];
            $getvendordata = DB::connection('mysql5')->table('vendor')->where('id', '=', $vendorid)->get();
             
            $validate = $this->validate($request, [
            'photo' => 'required|image|min:20|max:5000',
			]);
             
             $file = $request->file('photo');
             $filename = $file->getClientOriginalName();
             $destinationpath = $vendorid;
             $ext = pathinfo($filename, PATHINFO_EXTENSION);
             
             
            $listfiles = Storage::disk('s3')->files('/newcustomerzoneassets/vendorprofileimage/'.$vendorid);
            if(count($listfiles) > 0){
                Storage::disk('s3')->deleteDirectory('/newcustomerzoneassets/vendorprofileimage/'.$vendorid);
            }
             $uploadeddatetime = date('Ymd');
             $randomno = rand(1, 1000000);
             $newname = bcrypt($uploadeddatetime.$randomno.'VGNvendor');
             $uploaded = Storage::disk('s3')->putFileAs('/newcustomerzoneassets/vendorprofileimage/'.$destinationpath, $request->file('photo'), $newname.'.'.$ext);
             
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
             return redirect()->route('newvendor_home');
         }
        
    }
    
    public function newforgotpwd()
{
    return view('newvendorzone.forgotpwd');
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
                $request->session()->flash("error_msg", "Sorry! Enter a valid VendorId or Mobile Number");
                return redirect()->back()->withInput();
            }
                
        }
        else{
            
                $request->session()->flash("error_msg", "Sorry! Enter a valid Username");
                return redirect()->back()->withInput();
        }

        
        if ($loginmode == 'loginmode_customerid') {
            if (!ctype_digit($request->forgotusername)) {
                
                $request->session()->flash("error_msg", "Sorry! Enter a valid Vendor Id");
                return redirect()->back()->withInput();
            }
            $check = DB::connection('mysql5')->table('vendor')->where(['id' => $request->forgotusername])->get();
        }

        elseif ($loginmode == 'loginmode_emailid') {

            if (!filter_var($request->forgotusername, FILTER_VALIDATE_EMAIL)) {
            $request->session()->flash("error_msg", "Sorry! Enter a valid Email Id");
                return redirect()->back()->withInput();
                }
            $check = DB::connection('mysql5')->table('vendor')->where(['email' => $request->forgotusername ])->get();
            
        }
        
        elseif ($loginmode == 'loginmode_mobileno') {

            if (!preg_match('/^[0-9]{10}+$/', $request->forgotusername)) {
                $request->session()->flash("error_msg", "Sorry! Enter a valid Mobile Number");
                return redirect()->back()->withInput();
                }
            $check = DB::connection('mysql5')->table('vendor')->where(['mobile' => $request->forgotusername ])->get();
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


    $getvendordatacount = DB::connection('mysql5')->table('vendor')->where('id', '=', $request->forgotusername)->count();

        if ($getvendordatacount != 0) {
            $getvendordata = DB::connection('mysql5')->table('vendor')->where('id', '=', $request->forgotusername)->get();
            $getresetdata = DB::connection('mysql5')->table('resetpwd')->where('vendorid', '=', $request->forgotusername)->get();

            if (count($getresetdata) != 0) {
                
            
            foreach ($getresetdata as $key => $value) {
                $vendorid = $value->vendorid;
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
            foreach ($getvendordata as $keyvendor => $vendorvalue) {
                    $name = $vendorvalue->Name;
                    $email = $vendorvalue->email;
                    $mobile = $vendorvalue->mobile;
                }
            
            if ($now > $expiredate) {
//dd($addedexpiredate);
                $updateresetpwd = DB::connection('mysql5')->table('resetpwd')->where('vendorid','=',$vendorid)->update(['token'=>$token,'expiredate'=>$addedexpiredate]);
                
                $link="http://vgn.in/vendorzone/resetpassword/".$vendorid."/".$token;
				$newmail=array();
				$newmail['toname']=$name;
				$newmail['toemail']=$email;
				$newmail['subject']="VGN Vendor Zone - Reset Password Link!";
				$newmail['content']='<div style=" margin: 0 auto;  background-color: #eef5ff;padding: 2% 4%;font-size: 14px;"><div style="text-align: center;"><img src="http://www.vgn.in/images/custom/vgn-logo.png" alt="vgn-logo.jpg"></div>Dear '.$name.',<br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Please <a href="'.$link.'">Click Here</a> to reset your password.<br><br>Thanks,<br>VGN<br><div style="    text-align: center;    font-size: 88%;    color: rgb(124, 124, 124);">For Any details : <a href="http://www.vgn.in">www.vgn.in</a><br><span style="    color: rgb(23, 79, 163);
				font-weight: bold;">VGN Property Developers Private Limited</span>&nbsp;- No.153, Wallace Garden, 2nd Street, Nungambakkam, Chennai-600006.<br>Call Us: +91 44 4343 9900</div></div>';
				$newmail['html']="user-detail-contents.html";
				//$newmail['att_url']="images/logo.jpg";
                if(ctype_digit($mobile)){
                    if (strlen($mobile) == 10) {
                        
                //$smscontent='Dear '.$name.',<br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Please <a href="'.$link.'">Click Here</a> to reset your password.<br><br>Thanks,<br>VGN<br><div style="    text-align: center;    font-size: 88%;    color: rgb(124, 124, 124);">For Any details : <a href="http://www.vgn.in">www.vgn.in</a><br><span style="    color: rgb(23, 79, 163);				font-weight: bold;">VGN Property Developers Private Limited</span>&nbsp;- No.153, Wallace Garden, 2nd Street, Nungambakkam, Chennai-600006.<br>Call Us: +91 44 4343 9900</div>';
				
                //$smsurl = "http://www.adithya.me/adithya/Api/?username=vgn&password=vgn@123&senderid=VGNALT&message=$smscontent&msgtype=normal&mobileno=8754404619";
                $smscontent = 'Dear Vendor, Click the below link to reset your password '.$link; 
                
               $sms_status = $this->smscurl($smscontent, $mobile);               
                DB::connection('mysql5')->table('sms_sent_data')->insert(['vendorid' => $vendorid,'sentdatetime' => $now]);
                    }
                }

				$mailstatus = $this->sendmail($newmail);
                $request->session()->flash("suc_msg", "Dear Vendor your password has been reset and sent successfully to your registered email and phone!");
				//$return="<suc>Password reset link was sent to your registered email address successfully! <debug>" . $customerid."</debug></suc><br/>".$mailstatus['msg'];
				return redirect()->route('newvendor_home');
                
            }
            else{
                $link="http://vgn.in/vendorzone/resetpassword/".$vendorid."/".$pwd_token;
				$newmail=array();
				$newmail['toname']=$name;
				$newmail['toemail']=$email;
				$newmail['subject']="VGN Vendor Zone - Reset Password Link!";
				$newmail['content']='<div style=" margin: 0 auto;  background-color: #eef5ff;padding: 2% 4%;font-size: 14px;"><div style="text-align: center;"><img src="http://www.vgn.in/images/custom/vgn-logo.png" alt="vgn-logo.jpg"></div>Dear '.$name.',<br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Please <a href="'.$link.'">Click Here</a> to reset your password.<br><br>Thanks,<br>VGN<br><div style="    text-align: center;    font-size: 88%;    color: rgb(124, 124, 124);">For Any details : <a href="http://www.vgn.in">www.vgn.in</a><br><span style="    color: rgb(23, 79, 163);
				font-weight: bold;">VGN Property Developers Private Limited</span>&nbsp;- No.153, Wallace Garden, 2nd Street, Nungambakkam, Chennai-600006.<br>Call Us: +91 44 4343 9900</div></div>';
				$newmail['html']="user-detail-contents.html";
				//$newmail['att_url']="images/logo.jpg";

                  if(ctype_digit($mobile)){
                    if (strlen($mobile) == 10) {
                        
                //$smscontent='Dear '.$name.',<br>Please <a href="'.$link.'">Click Here</a> to reset your password.<br><br>Thanks,<br>VGN<br><div style="    text-align: center;    font-size: 88%;    color: rgb(124, 124, 124);">For Any details : <a href="http://www.vgn.in">www.vgn.in</a><br><span style="    color: rgb(23, 79, 163);				font-weight: bold;">VGN Property Developers Private Limited</span>&nbsp;- No.153, Wallace Garden, 2nd Street, Nungambakkam, Chennai-600006.<br>Call Us: +91 44 4343 9900</div>';

                $smscontent = 'Dear Vendor, Click the below link to reset your password '.$link;  
				
                
                $sms_status = $this->smscurl($smscontent, $mobile);
                DB::connection('mysql5')->table('sms_sent_data')->insert(['vendorid' => $vendorid,'sentdatetime' => $now]);
                    }
                }
				$mailstatus = $this->sendmail($newmail);
                $request->session()->flash("suc_msg", "Dear Vendor your password has been reset and sent successfully to your registered email and phone!");
				//$return="<suc>Password reset link was sent to your registered email address successfully! <debug>" . $customerid."</debug></suc><br/>".$mailstatus['msg'];
				return redirect()->route('newvendor_home');
            }

            
            $request->session()->flash("suc_msg", "Dear Vendor your password has been reset and sent successfully to your registered email and phone!");
				//$return="<suc>Password reset link was sent to your registered email address successfully! <debug>" . $customerid."</debug></suc><br/>".$mailstatus['msg'];
				return redirect()->route('newvendor_home');

            }
            else{
                
                
                $str = date('YmdHis').'-19'.rand(0,189999);
                $shuffled = str_shuffle($str);
                $token = $shuffled;
                $vendorid = $request->forgotusername;
                $now = Carbon::now();
                $date=date_create($now);
				date_add($date,date_interval_create_from_date_string("1 days"));
				$expiredate = date_format($date,"Y-m-d H:i:s");
                
                $insertresetpwd = DB::connection('mysql5')->table('resetpwd')->insert(['vendorid' => $vendorid, 'token'=>$token,'expiredate'=>$expiredate]);
                //$last_id = mysqli_insert_id($conn);
                foreach ($getvendordata as $keyvendor => $vendorvalue) {
                    $name = $vendorvalue->Name;
                    $email = $vendorvalue->email;
                    $mobile = $vendorvalue->mobile;
                }
                $link="http://vgn.in/vendorzone/resetpassword/".$vendorid."/".$token;
				$newmail=array();
				$newmail['toname']=$name;
				$newmail['toemail']=$email;
				$newmail['subject']="VGN Vendor Zone - Reset Password Link!";
				$newmail['content']='<div style=" margin: 0 auto;  background-color: #eef5ff;padding: 2% 4%;font-size: 14px;"><div style="text-align: center;"><img src="http://www.vgn.in/images/custom/vgn-logo.png" alt="vgn-logo.jpg"></div>Dear '.$name.',<br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Please <a href="'.$link.'">Click Here</a> to reset your password.<br><br>Thanks,<br>VGN<br><div style="    text-align: center;    font-size: 88%;    color: rgb(124, 124, 124);">For Any details : <a href="http://www.vgn.in">www.vgn.in</a><br><span style="    color: rgb(23, 79, 163);
				font-weight: bold;">VGN Property Developers Private Limited</span>&nbsp;- No.153, Wallace Garden, 2nd Street, Nungambakkam, Chennai-600006.<br>Call Us: +91 44 4343 9900</div></div>';
				$newmail['html']="user-detail-contents.html";
				//$newmail['att_url']="images/logo.jpg";
                 if(ctype_digit($mobile)){
                    if (strlen($mobile) == 10) {
                        
                //$smscontent='Dear '.$name.',<br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Please <a href="'.$link.'">Click Here</a> to reset your password.<br><br>Thanks,<br>VGN<br><div style="    text-align: center;    font-size: 88%;    color: rgb(124, 124, 124);">For Any details : <a href="http://www.vgn.in">www.vgn.in</a><br><span style="    color: rgb(23, 79, 163);				font-weight: bold;">VGN Property Developers Private Limited</span>&nbsp;- No.153, Wallace Garden, 2nd Street, Nungambakkam, Chennai-600006.<br>Call Us: +91 44 4343 9900</div>';
				$smscontent = 'Dear Vendor, Click the below link to reset your password '.$link; 
                $sms_status = $this->smscurl($smscontent, $mobile);
                DB::connection('mysql5')->table('sms_sent_data')->insert(['vendorid' => $vendorid,'sentdatetime' => $now]);
                    }
                }
				$mailstatus = $this->sendmail($newmail);
                $request->session()->flash("suc_msg", "Dear Vendor your password has been reset and sent successfully to your registered email and phone!");
				//$return="<suc>Password reset link was sent to your registered email address successfully! <debug>" . $customerid."</debug></suc><br/>".$mailstatus['msg'];
				return redirect()->route('newvendor_home');
            }
        }
        else{
            $request->session()->flash("error_msg", "Invalid or Blocked Username!");
            return redirect()->route('newvendforgotpassword');
        }
    //dd($getcustomerdata);

}
    
    public function resetpassword(Request $request, $id, $key)
{
    $vendorid = $id;
    $token = $key;

    if(($vendorid != null)&&($token != null))
    {
        $checkrestdata = DB::connection('mysql5')->table('resetpwd')->where('vendorid', '=', $vendorid)->where('token', '=', $token)->count();
    
        if($checkrestdata == 1){

            $getrestdata = DB::connection('mysql5')->table('resetpwd')->where('vendorid', '=', $vendorid)->where('token', '=', $token)->get();
            foreach ($getrestdata as $key => $value) {
                $expiredate = $value->expiredate;
            }
            
            $now = Carbon::now();
            if ($now > $expiredate) {
                $request->session()->flash("error_msg", "Password reset time limit expired!");
                return redirect()->route('newvendor_home');
            }
            else{
                return view('newvendorzone.resetpassword')->with(['vendorid' => $vendorid, 'token'=> $token]);
            }
        }
        else{
            return redirect()->route('newvendor_home');
        }
    }
    else{
            return redirect()->route('newvendor_home');
    }
}
    
    public function postresetpassword(Request $request, $id, $key)
{
     $validate = $this->validate($request, [
			'newpass' => 'required|min:6|max:12',
            'retypepass' => 'required|same:newpass'
			]);

    $vendorid = $id;
    $token = $key;
    

    if(($vendorid != null)&&($token != null))
    {
        $checkrestdata = DB::connection('mysql5')->table('resetpwd')->where('vendorid', '=', $vendorid)->where('token', '=', $token)->count();

        if($checkrestdata == 1){

            $getrestdata = DB::connection('mysql5')->table('resetpwd')->where('vendorid', '=', $vendorid)->where('token', '=', $token)->get();
            foreach ($getrestdata as $key => $value) {
                $expiredate = $value->expiredate;
            }
            $now = Carbon::now();
            if ($now > $expiredate) {
                $request->session()->flash("error_msg", "Password reset time limit expired!");
                return redirect()->route('newvendor_home');
            }
            else{

                $checkinvendortable = DB::connection('mysql5')->table('vendor')->where('id', '=', $vendorid)->count();
                
                if ($checkinvendortable == 1) {

                    DB::connection('mysql5')->table('vendor')->where('id', '=', $vendorid)->update(['password' => $request->newpass]);
                    DB::connection('mysql5')->table('resetpwd')->where('vendorid', '=', $vendorid)->delete();
                    $request->session()->flash("suc_msg", "Password reset done Successfully!");
                return redirect()->route('newvendor_home');

                }
                //return redirect()->route('customer_home');
            }
        }
        else{
            return redirect()->route('newvendor_home');
        }
    }
    else{
            return redirect()->route('newvendor_home');
    }


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
                $loginmode = 'loginmode_vendorid';
            }
            else{
                
                return 0;
            }
                
        }
        else{
                return 0;
        }

        $arr = [];
        if ($loginmode == 'loginmode_vendorid') {
            $arr['VEND_ID'] = $request->forgotusername;
            $arr['MOBILE_NO'] = '';
            $arr['E_MAIL'] = '';
        }
        if ($loginmode == 'loginmode_mobileno') {
            $arr['VEND_ID'] = '';
            $arr['MOBILE_NO'] = $request->forgotusername;
            $arr['E_MAIL'] = '';
        }
        if ($loginmode == 'loginmode_emailid') {
            $arr['VEND_ID'] = '';
            $arr['MOBILE_NO'] = '';
            $arr['E_MAIL'] = $request->forgotusername;
        }

        if (!empty($arr)) {
            $res = $this->checkvendor($arr);
            if ($res['NAME'] == '0') {
                return 'Invalid User. Try with valid username';
            }
            if (($res['MOBILE_NO'] == '0') && ($res['E_MAIL'] == '0')) {
                return 'Please contact VGN Team. Your registered mobile number and mail id is blank!';
            }

            if (($res['VEND_ID'] != '0') && ($res['NAME'] != '0') ) {
                $todaydateonly = Carbon::now()->toDateString();
                

                $checktodaysdateexist = DB::connection('mysql5')->table('vendforgotpwdotp_confirmation')->where(['vend_id' => $res['VEND_ID']])->where('created_datetime','LIKE','%'.$todaydateonly.'%')->count();
                $otp = rand(0,189999);
                $now = Carbon::now()->toDateTimeString();
                
                $expirytime = Carbon::now()->addMinutes(5)->toDateTimeString();
                //start
                if ($checktodaysdateexist == 0) {
                    //generate otp and send to customer
                    $smscontent = "Dear ".$res['NAME'].", Your Vendor Login Forgot Password OTP is ".$otp; 
               
		if(($res['MOBILE_NO'] != '0') && (preg_match("/^[+]?[0-9]+$/", $res['MOBILE_NO']))){
		$sms_status = $this->smscurl($smscontent, $res['MOBILE_NO']);
                    }
                    $newmaildata = [];
                    $newmaildata['name'] = $res['NAME'];
                    $newmaildata['otp'] = $otp;
                    $newmaildata['subject'] = "VGN Vendor Login Forgot Password OTP";
                    $newmaildata['content'] = "Your One Time Password for Vendor Login Forgot Password is $otp";
                    if(($res['E_MAIL'] != '0') && (filter_var($res['E_MAIL'], FILTER_VALIDATE_EMAIL))){
               Log::info('Sending forgot pwd otp = '.$res['E_MAIL']);
                                    Mail::to($res['E_MAIL'])->send(new sendforgotpwdotp($newmaildata));
                                }
               
                    //insert record in db
                    //return otp submit page
                     DB::connection('mysql5')->table('vendforgotpwdotp_confirmation')->insert(['vend_id' => $res['VEND_ID'],'otp' => $otp,'created_datetime' => $now,'validity_datetime' => $expirytime,'tried_count' => 1]);

                    return 1;
                }
                else{
                    $getdata1 = DB::connection('mysql5')->table('vendforgotpwdotp_confirmation')->where(['vend_id' => $res['VEND_ID']])->where('created_datetime','LIKE','%'.$todaydateonly.'%')->get();

                    foreach ($getdata1 as $key_getdata1 => $value_getdata1) {
                        $triedcount = $value_getdata1->tried_count;
                        $createdtime = $value_getdata1->created_datetime;
                        $extime = $value_getdata1->validity_datetime;
                    }

                    if ($triedcount <= 5) {

                         $smscontent = "Dear ".$res['NAME'].", Your Vendor Login Forgot Password OTP is ".$otp; 
                if($res['MOBILE_NO'] != '0'){
               $sms_status = $this->smscurl($smscontent, $res['MOBILE_NO']);
                    }
                    $newmaildata = [];
                    $newmaildata['name'] = $res['NAME'];
                    $newmaildata['otp'] = $otp;
                    $newmaildata['subject'] = "VGN Vendor Login Forgot Password OTP";
                    $newmaildata['content'] = "Your One Time Password for Vendor Login Forgot Password is $otp";
                    if($res['E_MAIL'] != '0'){
               Log::info('Sending forgot pwd otp = '.$res['E_MAIL']);
                                    Mail::to($res['E_MAIL'])->send(new sendforgotpwdotp($newmaildata));
                                }

                        //update 
                        $add1hour = Carbon::parse($createdtime)->addhours(1)->toDateTimeString();
                        if (Carbon::now()->gte(Carbon::parse($add1hour))) {
                            DB::connection('mysql5')->table('vendforgotpwdotp_confirmation')->where(['vend_id' => $res['VEND_ID']])->where('created_datetime','LIKE','%'.$todaydateonly.'%')->update([
                                'otp' => $otp,
                                'created_datetime' => $now,
                                'validity_datetime' => $expirytime, 
                                'tried_count' => 1 ]);

                            return 1;
                        }
                        else{

                             $smscontent = "Dear ".$res['NAME'].", Your Vendor Login Forgot Password OTP is ".$otp; 
                if($res['MOBILE_NO'] != '0'){
               $sms_status = $this->smscurl($smscontent, $res['MOBILE_NO']);
                    }
                    $newmaildata = [];
                    $newmaildata['name'] = $res['NAME'];
                    $newmaildata['otp'] = $otp;
                    $newmaildata['subject'] = "VGN Vendor Login Forgot Password OTP";
                    $newmaildata['content'] = "Your One Time Password for Vendor Login Forgot Password is $otp";
               Log::info('Sending forgot pwd otp = '.$res['E_MAIL']);
               if($res['E_MAIL'] != '0'){
                                    Mail::to($res['E_MAIL'])->send(new sendforgotpwdotp($newmaildata));
                                }

                        DB::connection('mysql5')->table('vendforgotpwdotp_confirmation')->where(['vend_id' => $res['VEND_ID']])->where('created_datetime','LIKE','%'.$todaydateonly.'%')->update([
                                'otp' => $otp,
                                'validity_datetime' => $expirytime, 
                                'tried_count' => $triedcount+1 ]);

                        return 1;
                        }
                    }
                    else{
                         

                        $add1hour = Carbon::parse($createdtime)->addhours(1)->toDateTimeString();

                        if (Carbon::now()->gte(Carbon::parse($add1hour))) {

                            $smscontent = "Dear ".$res['NAME'].", Your Vendor Login Forgot Password OTP is ".$otp; 
                if($res['MOBILE_NO'] != '0'){
               $sms_status = $this->smscurl($smscontent, $res['MOBILE_NO']);
                    }
                    $newmaildata = [];
                    $newmaildata['name'] = $res['NAME'];
                    $newmaildata['otp'] = $otp;
                    $newmaildata['subject'] = "VGN Vendor Login Forgot Password OTP";
                    $newmaildata['content'] = "Your One Time Password for Vendor Login Forgot Password is $otp";
                    if($res['E_MAIL'] != '0'){
               Log::info('Sending forgot pwd otp = '.$res['E_MAIL']);
                                    Mail::to($res['E_MAIL'])->send(new sendforgotpwdotp($newmaildata));
                                }
                                
                            DB::connection('mysql5')->table('vendforgotpwdotp_confirmation')->where(['vend_id' => $res['VEND_ID']])->where('created_datetime','LIKE','%'.$todaydateonly.'%')->update([
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
                $loginmode = 'loginmode_vendorid';
            }
            else{
                
                return 0;
            }
                
        }
        else{
                return 0;
        }

        $arr = [];
        if ($loginmode == 'loginmode_vendorid') {
            $arr['VEND_ID'] = $request->forgotusername;
            $arr['MOBILE_NO'] = '';
            $arr['E_MAIL'] = '';
        }
        if ($loginmode == 'loginmode_mobileno') {
            $arr['VEND_ID'] = '';
            $arr['MOBILE_NO'] = $request->forgotusername;
            $arr['E_MAIL'] = '';
        }
        if ($loginmode == 'loginmode_emailid') {
            $arr['VEND_ID'] = '';
            $arr['MOBILE_NO'] = '';
            $arr['E_MAIL'] = $request->forgotusername;
        }


        if (!empty($arr)) {
            $res = $this->checkvendor($arr);

            if (($res['VEND_ID'] != '0') && ($res['NAME'] != '0')) {
                $now = Carbon::now()->toDateTimeString();
                $todaystring = Carbon::now()->toDateString();
                $add5min = Carbon::now()->addMinutes(5)->toDateTimeString();
                

                $checkotpmatch = DB::connection('mysql5')->table('vendforgotpwdotp_confirmation')->where(['vend_id' => $res['VEND_ID'],'otp' => $request->submitotp])->where('validity_datetime','<=',$add5min)->count();
                if ($checkotpmatch == '1') {
                    $todaystring1 = str_replace('-', '', $todaystring);
                    $toencrypt = $res['VEND_ID'].'-#'.$request->submitotp.'-#'.$todaystring1;
                    $encrypt = Crypt::encrypt($toencrypt);

                    $request->session()->put('vendresetpwd', $encrypt);
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
        if ($request->session()->has('vendresetpwd')) {
            $encrypt = $request->session()->get('vendresetpwd');
            $decrypt = Crypt::decrypt($encrypt);
            //dd($decrypt);
            $split = explode("-#",$decrypt);
            
            $vendorid = $split[0];
            $otp = $split[1];
            $todaydateonly = Carbon::now()->toDateString();

            $checktodaysdateexist = DB::connection('mysql5')->table('vendforgotpwdotp_confirmation')->where(['vend_id' => $vendorid,'otp' => $otp])->where('created_datetime','LIKE','%'.$todaydateonly.'%')->count();

            if ($checktodaysdateexist == 1) {
                return view('newvendorzone.resetlink');
            }
            else{
                $request->session()->forget('vendresetpwd');
                return redirect()->back();
            }

        }
        else{
            return redirect()->route('newvendor_home');
        }
    }

    public function postresetlink(Request $request)
    {
        if ($request->session()->has('vendresetpwd')) {
            $encrypt = $request->session()->get('vendresetpwd');
            $decrypt = Crypt::decrypt($encrypt);
            //dd($decrypt);
            $split = explode("-#",$decrypt);

            $vendorid = $split[0];
            $otp = $split[1];
            $todaydateonly = Carbon::now()->toDateString();

            $checktodaysdateexist = DB::connection('mysql5')->table('vendforgotpwdotp_confirmation')->where(['vend_id' => $vendorid,'otp' => $otp])->where('created_datetime','LIKE','%'.$todaydateonly.'%')->count();

            if ($checktodaysdateexist == 1) {
                    
                    if (($request->newpass != '')&&(($request->retypepass != ''))) {

                if (($request->newpass != $request->retypepass)) {
                $request->session()->flash("error_msg", "New Password and Retype Password must be same!");
                return redirect()->back()->withInput();
                }
                else{

                    //do the updation and redirect to customerlogin
                    $checkindb = DB::connection('mysql5')->table('vendor')->where(['id' => $vendorid])->count();

                    $arr = [];
            $arr['VEND_ID'] = $vendorid;
            $arr['MOBILE_NO'] = '';
            $arr['E_MAIL'] = '';
            $res = $this->checkvendor($arr);

                    if ($checkindb == 1) {
                        DB::connection('mysql5')->table('vendor')->where(['id' => $vendorid])->update(['password' => Hash::make($request->newpass, ['rounds' => 12]),'Name' => $res['NAME'],'mobile' => $res['MOBILE_NO'],'email' => $res['E_MAIL'],'pwd_updated' => Carbon::now()->toDateTimeString(),'pwd_count' => 1]);
                    }
                    else{
                        DB::connection('mysql5')->table('vendor')->insert(['id' => $vendorid,'Name' => $res['NAME'],'password' => Hash::make($request->newpass, ['rounds' => 12]),
                            'valid' => 1,
                            'street1' => '',
                            'street2' => '',
                            'street3' => '',
                            'houseno' => '',
                            'city' => '',
                            'pin' => 0,
                            'country' => '',
                            'region' => '',
                            'tel' => '',
                            'mobile' => $res['MOBILE_NO'],
                            'fax' => '',
                            'email' => $res['E_MAIL'],
                            'pan_no'=> null,
                             'type_of_org'=> null,
                             'type_of_business'=> null,
                             'contact_person'=> null,
                             'vendor_acc_group'=> null,
                            'comp_raised' =>0,
                            'comp_closed' => 0,
                            'comp_pending' => 0,
                            'net_amt' => 0,
                            'act_no' => '',
                            'bank_name' => '',
                            'channel_partner' => '',
                            'ifsc_code' => '',
                            'branch_name' => '',
                            'updated' => '',
                            'pwd_updated' => Carbon::now()->toDateTimeString(),
                            'pwd_count' => 1,
                            'bid_count' => 0,
                            'created' => Carbon::now()->toDateTimeString()

                    ]);
                    }

                    DB::connection('mysql5')->table('vendforgotpwdotp_confirmation')->where(['vend_id' => $vendorid,'otp' => $otp])->delete();

                    $request->session()->forget('vendresetpwd');
                $request->session()->flash("suc_msg", "Password Successfully Updated. Please try to login.");
                return redirect()->route('newvendor_home');

                }

            }
            else{
                $request->session()->flash("error_msg", "Please fill the required fields!");
                return redirect()->back()->withInput();
            }


            }
            else{
                $request->session()->forget('vendresetpwd');
                $request->session()->flash("error_msg", "Invalid Reset Link. Try with forgot password!");
                return redirect()->route('newvendor_home');
            }

            
            

            

            

        }
        else{
            return redirect()->back();
        }
    }


public function channel_partner_leadcreation(Request $request)
{
    if ($request->session()->has('vendorsession')) {
            $encrypt = $request->session()->get('vendorsession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $vendorid = $split[0];

            $pwd_status = $this->is_didnt_passwordchanged($vendorid);
            if ($pwd_status == 0) {
                $request->session()->flash("error_msg", 'Please change the default password. Only if you Change the default password , other functionalities on this portal will work. This is done for security purposes. Please do not share your password with anyone');
                return redirect()->route('newvendor_mydetails_passchange');
            }
            
            $getvendordata = DB::connection('mysql5')->table('vendor')->where('id', '=', $vendorid)->get();
            
            foreach ($getvendordata as $key => $value) {
                $channel_partner = $value->channel_partner;
            }

            if ($channel_partner != 'X') {
                 $request->session()->flash("error_msg", "You are not authorized to Create Leads!");
                return redirect()->back();
            }
            else{
                $campaign_details = $this->get_channelpartner_campaigns($vendorid);
            }

            $campaignlist = [];
            if (array_key_exists('0', $campaign_details['Details'])) {
                $campaignlist = $campaign_details['Details'];
            }
            else{
                $campaignlist[0] = $campaign_details['Details'];
            }
            //dd($campaignlist);

            if(empty($campaignlist[0]["Plant_ID"])){
                $request->session()->flash("error_msg", "Campaigns not Active!");
                
            }
             $listfiles = Storage::disk('s3')->files("/newcustomerzoneassets/vendorprofileimage/".$vendorid);

             
             if(count($listfiles) > 0){
                $profilepic = config('app.AWS_URL')."/".$listfiles[0];
            }
             else
             {
                $profilepic = config('app.AWS_URL')."/newcustomerzoneassets/img/dummy_male.png";
             }
            return view('newvendorzone.channel_partner')->with(['getvendordata'=>$getvendordata, 'profilepic' => $profilepic,'campaign_details' => $campaignlist]);
        }
        return view('newvendorzone.login');
}

public function postchannel_partner_leadcreation(Request $request)
{
    if ($request->session()->has('vendorsession')) {
            $encrypt = $request->session()->get('vendorsession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $vendorid = $split[0];
            
            $getvendordata = DB::connection('mysql5')->table('vendor')->where('id', '=', $vendorid)->get();
            
            foreach ($getvendordata as $key => $value) {
                $channel_partner = $value->channel_partner;
            }

            if ($channel_partner != 'X') {
                 $request->session()->flash("error_msg", "You are not authorized to Create Leads!");
                return redirect()->back();
            }
            else{
                $campaign_details = $this->get_channelpartner_campaigns($vendorid);
            }

            $campaignlist = [];
            if (array_key_exists('0', $campaign_details['Details'])) {
                $campaignlist = $campaign_details['Details'];
            }
            else{
                $campaignlist[0] = $campaign_details['Details'];
            }

            //dd($request);
            $selected = [];
            foreach ($campaignlist as $key11 => $value11) {
                if ($value11['Plant_ID'] == $request->project) {
                    $selected = $value11;
                }
            }
            //dd($selected);
            $campaign_code_arr = explode('/', $selected['Campaign_Code']);

            $campaign_code = $campaign_code_arr[3];
            $table_name = $campaign_code.'_'.$selected['Plant_ID'];
            //dd($table_name);
            if ($request->message == null) {
                $msg = 'None';
            }
            else{
                $msg = $request->message;
            }

            $rand = rand(10,100);
            $appid = Carbon::now()->format('Ymdhis');
            $pid = $appid.$rand;

            $searchLead = $this ->searchchannelpartnerlead($selected['Plant_ID'],$request->mobile_no);

            //dd("+".$request->mobile_no_phoneCode.$request->mobile_no);
            if($searchLead['DATA']['Plant'] == 'Valid'){
                DB::connection('mysql2')->table($table_name)->insert([
                    'Id' => null,
                    'PID' => $pid,
                    'Project_name' => "VGND ".$selected['Plant_Name'],
                    'Name' => $request->lead_name,
                    'Email' => $request->emailid,
                    'Mobile' => "+".$request->mobile_no_phoneCode.$request->mobile_no,
                    'City' => $request->city,
                    'msg' => $msg,
                    'lead_datetime' => Carbon::now()->toDateTimeString(),
                    'inserteddate' => Carbon::now()->toDateTimeString(),
                ]);
    
                $request->session()->flash("suc_msg", "New Lead Created Successfully!");
            }else{

                $request->session()->flash("error_msg", "Leads already exist, so please try another!");
                
            }
            
            return redirect()->back();
             
            return view('newvendorzone.channel_partner')->with(['getvendordata'=>$getvendordata, 'profilepic' => $profilepic]);
        }
        return view('newvendorzone.login');
}


public function postnegotiated_discountprice(Request $request)
{
    if ($request->session()->has('vendorsession')) {
            $encrypt = $request->session()->get('vendorsession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $vendorid = $split[0];
            
            $getvendordata = DB::connection('mysql5')->table('vendor')->where('id', '=', $vendorid)->get();
            
            $array_data = $request->array_data;
            $bidno = $request->bidno;

            $newarray = [];
            $newarray['vendor_ID'] = $vendorid;
            $newarray['BID_Ref_NO'] = trim($bidno);
            $newarray['Disc_Table'] = $array_data;

            //return json_encode($newarray);

            $crosscheck = $this->negotiated_price_details($vendorid, $bidno);

            if ($crosscheck['Disc_Upd_Flag'] == 'OPEN') {
                
            

            
                $status = $this->post_final_negotiated_discountprice($newarray); 
                if ($status['Status'] == 'Updated Successfully') {
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
            return 'Unauthourized Access';
        }
        
} 


public function sendandsavevendor_registerotp(Request $request)
{
    if ($request->has('mobileotp')) {
     $mobileno = $request->mobileotp;


     $checkmobileexist = $this->mobilenoregisterd_validation($mobileno);
     if ($checkmobileexist == 1) {
                $resp = ['status' => 4];

                return json_encode($resp);
     }

     $check_pre_register_mobileexist = $this->pre_mobilenoregisterd_validation($mobileno);
     if ($check_pre_register_mobileexist == 1) {
                $resp = ['status' => 5];

                return json_encode($resp);
     }

     

     

     //return 'naveen';

     $request->session()->forget('vendorreg_mobileotp');
     $request->session()->forget('mobileverification');

     if ($request->session()->has('vendormobileotp_attempt')) {
         $vendormobileotp_attempt = $request->session()->get('vendormobileotp_attempt');


         if ($vendormobileotp_attempt['mobileotpattempt'] <= 5) {
             $tried = $vendormobileotp_attempt['mobileotpattempt'] + 1;
             $vendormobileotp_attempt['currenttime'] =  Carbon::now()->toDateTimeString();

             $request->session()->put('vendormobileotp_attempt.mobileotpattempt', $tried);
             $request->session()->put('vendormobileotp_attempt.currenttime', Carbon::now()->toDateTimeString());
         }
         else{
            $vendormobileotp_attempt['currenttime'] =  Carbon::parse($vendormobileotp_attempt['currenttime'])->addMinutes(30)->toDateTimeString();
            if (Carbon::now()->gt(Carbon::parse($vendormobileotp_attempt['currenttime']))) {
                $request->session()->forget('vendormobileotp_attempt');

                $arr1 = [];
                $arr1['currenttime'] = Carbon::now()->toDateTimeString();
                $arr1['mobileotpattempt'] = 1;
                $request->session()->put('vendormobileotp_attempt', $arr1);
                
            }
            else{
                 $resp = ['status' => 2];

                return json_encode($resp);
            }
         }
         
     }
     else{
        $arr1 = [];
        $arr1['currenttime'] = Carbon::now()->toDateTimeString();
        $arr1['mobileotpattempt'] = 1;
        $request->session()->put('vendormobileotp_attempt', $arr1);
       // return 'naveen';
     }

     //$otptriggered_count = 1;
//return json_encode($request->session()->get('vendormobileotp_attempt'));

     $otptext = mt_rand(1090,9997);     
     $now = Carbon::now()->toDateTimeString();


     $smscontent = 'Dear Vendor'.', Your One Time Password for vendor registration is '.$otptext;
        Log::info($smscontent); 
        $otphash = ['mobilenumber' => $mobileno, 'mobileotpsent' => $otptext];

                
               $sms_status = $this->smscurl($smscontent, $mobileno);               
                DB::table('sms_sent_data')->insert(['Mobile' => $mobileno,'sentdatetime' => "$now"]);

                $hashmobkey = Crypt::encrypt($otphash);

                $request->session()->put('vendorreg_mobileotp', $hashmobkey);
                
        $resp = ['status' => 1];
        return json_encode($resp);



    }
    //$request->mobileotp;
}

public function validatemobileotp(Request $request)
{
    if ($request->session()->has('vendorreg_mobileotp')) {
        $preval = $request->session()->get('vendorreg_mobileotp');
        $request->session()->forget('mobileverification');
        $decrypt = Crypt::decrypt($preval);
        $otpverified = 0;
        if (($decrypt['mobileotpsent'] == $request->mobileotpbyuser) && ($decrypt['mobilenumber'] == $request->mobileno1)) {
            $decrypt['mobileverified'] = 1;
            $otpverified = 1;
            $request->session()->put('mobileverification', Crypt::encrypt($decrypt));
        }

        return json_encode(['otpbyuser' => $request->mobileotpbyuser, 'otpverified' => $otpverified]);
    }
    else{
        return json_encode(['otpbyuser' => $request->mobileotpbyuser]);
    }
}

public function sendandsavevendor_registerotpemail(Request $request)
{
    if ($request->has('emailotp')) {
        //$request->session()->forget('vendoremailotp_attempt');

$emailid = $request->emailotp;
$materialorservice = $request->materialorservice;
//return $materialorservice;
//$allowed_materialor_servicelist = [1002,1060,2002,2013,1027,2001,2003,1049,2048,2049,2007,2016,2031,1030,1031,1050,2024,1011,1013,1047,1034,1051,2022,1071,2000,1036,2004,2015,2029,2017,1041,1038,2018,1065,1001,2026,2027,2047,2050,2019,2020,1020,2023];
//$notallowed_address = ['gmail.com','yahoo.com','hotmail.com','aol.com','hotmail.co.uk','msn.com','yahoo.co.uk','yahoo.co.in','live.com','rediffmail.com','ymail.com','outlook.com','hotmail.it','yahoo.in'];

if (!filter_var($emailid, FILTER_VALIDATE_EMAIL)) {
            $resp = ['status1' => 3];

                return json_encode($resp);
        }
        $checkemailexist = $this->emailregisterd_validation($emailid);
     if ($checkemailexist == 1) {
                $resp = ['status1' => 4];

                return json_encode($resp);
     }

        $check_pre_register_emailexist = $this->pre_emailregisterd_validation($emailid);
     if ($check_pre_register_emailexist == 1) {
                $resp = ['status1' => 5];

                return json_encode($resp);
     }

 

        

     
     $request->session()->forget('vendorreg_emailotp');
     $request->session()->forget('emailverification');


     if ($request->session()->has('vendoremailotp_attempt')) {
         $vendoremailotp_attempt = $request->session()->get('vendoremailotp_attempt');


         if ($vendoremailotp_attempt['emailotpattempt'] <= 5) {
             $tried = $vendoremailotp_attempt['emailotpattempt'] + 1;
             $vendoremailotp_attempt['currenttime'] =  Carbon::now()->toDateTimeString();

             $request->session()->put('vendoremailotp_attempt.emailotpattempt', $tried);
             $request->session()->put('vendoremailotp_attempt.currenttime', Carbon::now()->toDateTimeString());
         }
         else{
            $vendoremailotp_attempt['currenttime'] =  Carbon::parse($vendoremailotp_attempt['currenttime'])->addMinutes(30)->toDateTimeString();
            if (Carbon::now()->gt(Carbon::parse($vendoremailotp_attempt['currenttime']))) {
                $request->session()->forget('vendoremailotp_attempt');

                $arr1 = [];
                $arr1['currenttime'] = Carbon::now()->toDateTimeString();
                $arr1['emailotpattempt'] = 1;
                $request->session()->put('vendoremailotp_attempt', $arr1);
                
            }
            else{
                 $resp = ['status1' => 2];

                return json_encode($resp);
            }
         }
         
     }
     else{
        $arr1 = [];
        $arr1['currenttime'] = Carbon::now()->toDateTimeString();
        $arr1['emailotpattempt'] = 1;
        $request->session()->put('vendoremailotp_attempt', $arr1);
       // return 'naveen';
     }

     //$otptriggered_count = 1;

     //return json_encode($request->session()->get('vendoremailotp_attempt'));

     $otptext1 = mt_rand(1090,9997);     
     $now = Carbon::now()->toDateTimeString();


     //$smscontent = 'Dear Vendor'.', Your One Time Password for vendor registration is '.$otptext;
     $newmaildata=[];
     $newmaildata['email_otp'] = $otptext1;

     Mail::to($emailid)->send(new sendvendorotp_reg($newmaildata));
        Log::info('vendor registration email : '.$emailid.' '.$otptext1);
        $otphash = ['emailid' => $emailid, 'emailotpsent' => $otptext1];

                $hashmobkey1 = Crypt::encrypt($otphash);

                $request->session()->put('vendorreg_emailotp', $hashmobkey1);
        $resp = ['status1' => 1];
        return json_encode($resp);



    }
    //$request->mobileotp;
}

public function validateemailotp(Request $request)
{
    if ($request->session()->has('vendorreg_emailotp')) {
        $request->session()->forget('emailverification');
        $preval = $request->session()->get('vendorreg_emailotp');
        $decrypt = Crypt::decrypt($preval);
        $otpverified = 0;
        if (($decrypt['emailotpsent'] == $request->emailotpbyuser) && ($decrypt['emailid'] == $request->email1)) {
            $otpverified = 1;
            $decrypt['emailverified'] = 1;
            $request->session()->put('emailverification', Crypt::encrypt($decrypt));
        }

        return json_encode(['emailotpbyuser' => $request->mobileotpbyuser, 'emailotpverified' => $otpverified]);
    }
    else{
        return json_encode(['emailotpbyuser' => $request->mobileotpbyuser]);
    }
}

public function panno_validation(Request $request)
{
    /*if ($request->has('panno')) {

        $check_pre_register_panexist = $this->pre_panno_validation($request->panno);
        
     if ($check_pre_register_panexist != 1) {
                return $request->panno;
     }else{

         $res = $this->vendor_pan_validation($request->panno);

         if ($res['STATUS'] == 'Valid') {
             return 1;
         }
         else{
            return $request->panno;
         }

     }

    }
    else{
        return 0;
    }*/


if ($request->has('panno')) {

    $res = $this->vendor_pan_validation($request->panno);

         if ($res['STATUS'] == 'Valid') {

            $check_pre_register_panexist = $this->pre_panno_validation($request->panno);
            if ($check_pre_register_panexist != 1) {
                $resp = ['status' => 5, 'pan' => $request->panno];
                return json_encode($resp);
            }else{
                $resp = ['status' => 1];
                return json_encode($resp);
            }
         }
         else{
            $resp = ['status' => 4, 'pan' => $request->panno];
                return json_encode($resp);
         }
}
else{
     $resp = ['status' => 0, 'pan' => 'invalid'];
                return json_encode($resp);
}


}

public function mobilenoregisterd_validation($mobno)
{

    $arr = [];

            $arr['VEND_ID'] = '';
            $arr['MOBILE_NO'] = $mobno;
            $arr['E_MAIL'] = '';
        
        /*if ($loginmode == 'loginmode_emailid') {
            $arr['VEND_ID'] = '';
            $arr['MOBILE_NO'] = '';
            $arr['E_MAIL'] = $request->forgotusername;
        }*/

        if (!empty($arr)) {
            $res = $this->checkvendor($arr);

            if (($res['VEND_ID'] != '0') ) {
                return 1;
            }
            else{
                return 0;
            }
        }

        return 0;
}


public function emailregisterd_validation($emailid)
{

    $arr = [];

            $arr['VEND_ID'] = '';
            $arr['MOBILE_NO'] = '';
            $arr['E_MAIL'] = $emailid;
        
        /*if ($loginmode == 'loginmode_emailid') {
            $arr['VEND_ID'] = '';
            $arr['MOBILE_NO'] = '';
            $arr['E_MAIL'] = $request->forgotusername;
        }*/

        if (!empty($arr)) {
            $res = $this->checkvendor($arr);

            if (($res['VEND_ID'] != '0') ) {
                return 1;
            }
            else{
                return 0;
            }
        }

        return 0;
}


public function pre_mobilenoregisterd_validation($mobno)
{

    $arr = [];

            $arr['PAN_No'] = '';
            $arr['Mobile_No'] = $mobno;
            $arr['Mail'] = '';
        
        /*if ($loginmode == 'loginmode_emailid') {
            $arr['VEND_ID'] = '';
            $arr['MOBILE_NO'] = '';
            $arr['E_MAIL'] = $request->forgotusername;
        }*/

        if (!empty($arr)) {
            $res = $this->vendor_pre_register_validation($arr);

            if (($res['STATUS'] != 'Valid') ) {
                return 1;
            }
            else{
                return 0;
            }
        }

        return 0;
}

public function pre_emailregisterd_validation($emailid)
{

    $arr = [];

            $arr['PAN_No'] = '';
            $arr['Mobile_No'] = '';
            $arr['Mail'] = $emailid;
        
        /*if ($loginmode == 'loginmode_emailid') {
            $arr['VEND_ID'] = '';
            $arr['MOBILE_NO'] = '';
            $arr['E_MAIL'] = $request->forgotusername;
        }*/

        if (!empty($arr)) {
            $res = $this->vendor_pre_register_validation($arr);

            if (($res['STATUS'] != 'Valid') ) {
                return 1;
            }
            else{
                return 0;
            }
        }

        return 0;
}

public function pre_panno_validation($pano)
{

    $arr = [];

            $arr['PAN_No'] = $pano;
            $arr['Mobile_No'] = '';
            $arr['Mail'] = '';
        
        /*if ($loginmode == 'loginmode_emailid') {
            $arr['VEND_ID'] = '';
            $arr['MOBILE_NO'] = '';
            $arr['E_MAIL'] = $request->forgotusername;
        }*/
        //return $arr;
        if (!empty($arr)) {
            $res = $this->vendor_pre_register_validation($arr);
            //return $res['STATUS'];

            if ($res['STATUS'] == 'Valid' ) {
                return 1;
            }
            else{
                return $pano;
            }
        }

        return $pano;
}

public function send_sms_using_dinstar1($message, $mobileno, $customcode_reply, $portno)
    {
        

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'http://14.98.236.9/send_sms_using_dinstar',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => json_encode(['message' => "$message",'mobileno' => "$mobileno", 'customcode_reply' => "$customcode_reply", 'portno' => $portno]),
  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/json'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
return json_encode($response);

    }
    public function vendauthupd($code)
{
    if (($code != '') && (ctype_digit($code))) {

        $check = DB::connection('mysql5')->table('vendorcomm_updateotp')->where([
            'otp' => $code, 'validated' => 0
        ])->get();
        if (count($check) != 0) {
            $now = Carbon::now()->toDateTimeString();
            foreach ($check as $key11 => $value11) {
                $expirytime = $value11->expiry_time;
            }

            if (Carbon::parse($now)->lte(Carbon::parse($expirytime))) {
                DB::connection('mysql5')->table('vendorcomm_updateotp')->where([
            'otp' => $code, 'validated' => 0
        ])->update(['validated' => 1]);

                //abort(403, 'Successfully Authenticated!');
                return view('newvendorzone.success')->with(['message' => "You have been authorized successfully to update details in VGN Vendor Portal.", "title" => 'Mobile Authentication Successful']);

                //return json_encode(['status' => 1, 'message' => "Successfully Authenticated"]);
            }
            else{
                //abort(403, 'Link Expired. Please try again to initiate the change request, in vendor portal.');
                return view('newvendorzone.unauthorize')->with(['message' => "Link Expired. Please try again to initiate the change request, in vgn vendor portal.", "title" => 'Link Expired']);
               // return json_encode(['status' => 3, 'message' => "Link Expired. Please try again to initiate the change request, in vendor portal."]);
            }
            

        //dd("Successfully Authenticated");
        }
        else{
            //abort(401, 'Invalid request or request already authenticated');
             //return view('newvendorzone.unauthorize');
            return view('newvendorzone.unauthorize')->with(['message' => "Invalid request or request already authenticated", "title" => 'Link Expired']);
            
        }

        
    }
    else{
        //abort(401, 'Unauthourized Access');
        return view('newvendorzone.unauthorize');
    }
}

public function vendauthupdemail($code)
{
    if (($code != '') && (ctype_digit($code))) {

        $newcode1 = $code / 2;
        $newcode = $newcode1 - 250;

        $check = DB::connection('mysql5')->table('vendorcomm_updateotp')->where([
            'otp' => $newcode, 'validated_email' => 0
        ])->get();
        if (count($check) != 0) {
            $now = Carbon::now()->toDateTimeString();
            foreach ($check as $key11 => $value11) {
                $expirytime = $value11->expiry_time;
            }

            if (Carbon::parse($now)->lte(Carbon::parse($expirytime))) {
                DB::connection('mysql5')->table('vendorcomm_updateotp')->where([
            'otp' => $newcode, 'validated_email' => 0
        ])->update(['validated_email' => 1]);

                return view('newvendorzone.success')->with(['message' => "You have been authorized successfully to update details in VGN Vendor Portal.", "title" => 'Email Authentication Successful']);

                //return json_encode(['status' => 1, 'message' => "Successfully Authenticated"]);
            }
            else{
                return view('newvendorzone.unauthorize')->with(['message' => "Link Expired. Please try again to initiate the change request, in vgn vendor portal.", "title" => 'Link Expired']);
               // return json_encode(['status' => 3, 'message' => "Link Expired. Please try again to initiate the change request, in vendor portal."]);
            }
            

        //dd("Successfully Authenticated");
        }
        else{
            return view('newvendorzone.unauthorize')->with(['message' => "Invalid request or request already authenticated", "title" => 'Link Expired']);
            
        }

        
    }
    else{
        return view('newvendorzone.unauthorize')->with(['message' => "Invalid request or request already authenticated", "title" => 'Link Expired']);
    }
}
public function editdetailsstep1(Request $request)
{
    if ($request->session()->has('vendorsession')) {
            $encrypt = $request->session()->get('vendorsession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $vendorid = $split[0];
            
            $getvendordata = DB::connection('mysql5')->table('vendor')->where('id', '=', $vendorid)->get();
            if (count($getvendordata) > 0) {
                foreach ($getvendordata as $key1 => $value1) {
                    $mobile = $value1->mobile;
                    $name = $value1->Name;
                    $email = $value1->email;
                }
            }
            

             $now = Carbon::now()->toDateTimeString();
             $expiryvalidate = DB::connection('mysql5')->table('vendorcomm_updateotp')->where(['vendorid' => $vendorid, 'authenticate_type' => 'Mobile','mobemaild' => $mobile])->where('authenticate_req_attempt','>=', 5)->get();

             if (count($expiryvalidate) > 0) {
                 
                 foreach ($expiryvalidate as $key11 => $value11) {
                     $extime = $value11->expiry_time;
                     $waitime = Carbon::parse($extime)->addMinutes(30)->toDateTimeString();
                     if (Carbon::parse($now)->lte(Carbon::parse($waitime))) {
                         $fmtime = Carbon::parse($waitime)->format('d, M Y h:i:s A');
                         return json_encode(['status' => 5, 'message' => "Too Many attempts. Please try after $fmtime"]);
                     }
                     else{
                        DB::connection('mysql5')->table('vendorcomm_updateotp')->where(['vendorid' => $vendorid, 'authenticate_type' => 'Mobile','mobemaild' => $mobile])->delete();
                        $request->session()->forget('vend_auth_mobile');
                     }
                 }
             }
             


             $uploadeddatetime = date('Ymd');
             $randomno = rand(999, 999999);
             $reqcode = str_shuffle($uploadeddatetime.$randomno);
             $getcheck = DB::connection('mysql5')->table('vendorcomm_updateotp')->where(['vendorid' => $vendorid, 'authenticate_type' => 'Mobile','mobemaild' => $mobile])->get();
             if (count($getcheck) == 0) {
                 $newattempt = 1;
             
             DB::connection('mysql5')->table('vendorcomm_updateotp')->insert([
                'vendorid' => $vendorid,
                'mobemaild' => $mobile,
                'otp' => $reqcode,
                'authenticate_type' => 'Mobile',
                'created_datetime' => Carbon::now()->toDateTimeString(),
                'expiry_time' => Carbon::now()->addMinutes(5)->toDateTimeString(),
                'validated' => 0,
                'validated_email' => 0,
                'authenticate_req_attempt' => $newattempt,
                'newdata' => null,
                'newdataotp' => null,
                'newdataotpattempt' => null,
                'newdataotpexpiry' => null
             ]);

             $request->session()->put('vend_auth_mobile.id', $vendorid);
             $request->session()->put('vend_auth_mobile.type', 'Mobile');
             $request->session()->put('vend_auth_mobile.attempt', 1);
             $request->session()->put('vend_auth_mobile.createdtime', $now);
            
         }
         else{
            foreach ($getcheck as $key => $value) {
                $authenticate_req_attempt = $value->authenticate_req_attempt;
            }
            $newattempt = $authenticate_req_attempt + 1;

            DB::connection('mysql5')->table('vendorcomm_updateotp')->where(['vendorid' => $vendorid, 'authenticate_type' => 'Mobile','mobemaild' => $mobile])->update([
                'otp' => $reqcode,
                'created_datetime' => Carbon::now()->toDateTimeString(),
                'validated' => 0,
                'validated_email' => 0,
                'expiry_time' => Carbon::now()->addMinutes(5)->toDateTimeString(),
                'authenticate_req_attempt' => $newattempt,
             ]);

            $request->session()->put('vend_auth_mobile.id', $vendorid);
             $request->session()->put('vend_auth_mobile.type', 'Mobile');
             $request->session()->put('vend_auth_mobile.attempt', $newattempt);
             $request->session()->put('vend_auth_mobile.createdtime', $now);
            
         }


         //$content = "Dear $name,\nYou have requested for Mobile number change. Please approve by clicking the below link. Ignore the message, if its not requested by you. https://www.vgn.in/vendauthupd/$reqcode";

         //$content = "Dear $name,\nYou have requested for Change of registered Mobile Number. Please approve the same  by clicking the below link. If you have not requested for change in your registered mobile number, kindly ignore the message. https://www.vgn.in/vendauthupd/$reqcode";

         $content = "Dear Vendor, You have requested for change of registered Mobile Number. Please approve the same by clicking the below link. If you have not requested for change in your registered mobile number, kindly ignore the message. https://vgn.in/vthup/$reqcode";



         //$this->smscurlalt($content, $mobile);
         $this->smscurlalt($content, $mobile);
         //$mm =  $this->send_sms_using_dinstar1($content, $mobile, rand(111,9999), 16);

         

          $newmaildata=[];
          $emailreqcode = ($reqcode + 250) *2;
     $newmaildata['email_link'] = "https://www.vgn.in/vendauthupdemail/".$emailreqcode;
     $newmaildata['email_type'] = "Mobile Number";

     Mail::to($email)->send(new vendorauthenticate($newmaildata));
     
            
             return json_encode(['status' => 1, 'message' => "Please authorize by clicking the link sent to your Registered Mobile Number and Registerd Email ID to update the New Mobile Number.",'attempt' => $newattempt]);

             //dd($getvendordata);
            
        }
        return json_encode(['status' => 6, 'message' => "Invalid request. Try again later."]);
}

public function editdetailsstep2(Request $request)
{
    if ($request->session()->has('vendorsession')) {
            $encrypt = $request->session()->get('vendorsession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $vendorid = $split[0];
            
            $getvendordata = DB::connection('mysql5')->table('vendor')->where('id', '=', $vendorid)->get();
            if (count($getvendordata) > 0) {
                foreach ($getvendordata as $key1 => $value1) {
                    $mobile = $value1->mobile;
                    $name = $value1->Name;
                }
            }
            //return $mobile;
             $vendetails = $request->vendetails;


             if ($request->session()->has('vend_auth_mobile')) {
                     $getsess = $request->session()->get('vend_auth_mobile');
                 }
                 else{
                    $request->session()->forget('vend_auth_mobile');
                    return 12;
                 }

            
             //return $vendetails['id'];
             if ($vendorid != $vendetails['id']) {
                 return json_encode(['status' => 3, 'message' => "Vendor does not match!"]);
             }


             if ($getsess['id'] == $vendetails['id']) {
                $now = Carbon::now()->toDateTimeString();
             $expiryvalidate = DB::connection('mysql5')->table('vendorcomm_updateotp')->where(['vendorid' => $vendetails['id'], 'authenticate_type' => $vendetails['type']])->get();

             if (count($expiryvalidate) > 0) {
                 foreach ($expiryvalidate as $key12 => $value12) {
                     $expirytime = $value12->expiry_time;
                     $newattempt = $value12->authenticate_req_attempt;
                     $createdtime = $value12->created_datetime;
                     $add30min = Carbon::parse($expirytime)->addMinutes(30)->toDateTimeString();

                     if (Carbon::parse($now)->lte(Carbon::parse($add30min))) {
                         
                         if (($value12->validated == 1) && ($value12->validated_email == 1)) {
                            $request->session()->forget('vend_auth_mobile');
                            //$request->session()->flash("validatedmsg", "validated");
                            $request->session()->put('vendapproved.id', $vendorid);
             $request->session()->put('vendapproved.type', 'Mobile');
             $request->session()->put('vendapproved.attempt', $newattempt);
             $request->session()->put('vendapproved.createdtime', $createdtime);
             $request->session()->put('vendapproved.authenticated', 'valid');
                
                            
                            return 1;
                         //$request->session()->put('vend_auth_mobile.authenticated', 'valid');
                         //return session()->all();
                            }
                            else{
                                return 2;
                            }
                     }
                     else{
                        DB::connection('mysql5')->table('vendorcomm_updateotp')->where(['vendorid' => $vendetails['id'], 'authenticate_type' => $vendetails['type']])->delete();
                        $request->session()->forget('vend_auth_mobile');

                        return 4;
                     }
                 }
                 
             }
             else{
                $request->session()->forget('vend_auth_mobile');
                return 0;
             }
            }

             
             


            
        }
        return json_encode(['status' => 6, 'message' => "Invalid request. Try again later."]);
}


public function editdetailsstep3(Request $request)
{
    if ($request->session()->has('vendorsession')) {
            $encrypt = $request->session()->get('vendorsession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $vendorid = $split[0];
            
            $getvendordata = DB::connection('mysql5')->table('vendor')->where('id', '=', $vendorid)->get();
            if (count($getvendordata) > 0) {
                foreach ($getvendordata as $key1 => $value1) {
                    $mobile = $value1->mobile;
                    $name = $value1->Name;
                    $email = $value1->email;
                }
            }

             $vendetails = $request->apprv;
             $newnumber = $request->newnumber;


             if ($request->session()->has('vendapproved')) {
                     $getsess = $request->session()->get('vendapproved');
                    // return json_encode($getsess);
                 }
                 else{
                    $request->session()->forget('vendapproved');
                    return 12;
                 }

            
             //return $vendetails['id'];
             if ($vendorid != $vendetails['id']) {
                 return json_encode(['status' => 3, 'message' => "Vendor does not match!"]);
             }

            if (ctype_digit($request->newnumber)) {

            if (strlen($request->newnumber) == 10) {
                $loginmode = 'loginmode_mobileno';
            }else{
                return 4;
            }
            }
            else{
                return 44;
            }


            $now = Carbon::now()->toDateTimeString();

            $randomno = rand(999, 999999);
           $getcheck = DB::connection('mysql5')->table('vendorcomm_updateotp')->where(['vendorid' => $vendorid, 'authenticate_type' => $getsess['type'],'validated' => 1])->get();

           if (count($getcheck) > 0) {
               foreach ($getcheck as $key11 => $value11) {
                   $newdataotpattempt = $value11->newdataotpattempt;
                   $newdataotpexpiry = $value11->newdataotpexpiry;
                   $newadded15min = Carbon::parse($value11->expiry_time)->addMinutes(15)->toDateTimeString();
               }

               if (strpos($value11->mobemaild, $newnumber) !== false) {
                   return 77;
               }

               if ($newdataotpattempt >= 5) {
                    $request->session()->forget('vendapproved');
                    return 0;
               }

               if (Carbon::parse($now)->gt(Carbon::parse($newadded15min))) {
                   $request->session()->forget('vendapproved');
                   DB::connection('mysql5')->table('vendorcomm_updateotp')->where(['vendorid' => $vendorid, 'authenticate_type' => $getsess['type'], 'validated' => 1])->delete();
                return 0;
               }
               

                $nnewdataotpattempt = $newdataotpattempt + 1;
                DB::connection('mysql5')->table('vendorcomm_updateotp')->where(['vendorid' => $vendorid, 'authenticate_type' => $getsess['type'], 'validated' => 1])->update([
                'newdata' => $request->newnumber,
                'newdataotp' => $randomno,
                'newdataotpattempt' => $nnewdataotpattempt,
                'newdataotpexpiry' => Carbon::now()->addMinutes(5)->toDateTimeString(),
             ]);

               




               
           }
           else{
                $request->session()->forget('vendapproved');
                return 0;
           }

            


       $newmaildata1=[];
     $newmaildata1['email_otp'] = $randomno;
     $newmaildata1['email_otptype'] = 'Mobile Number';

     Mail::to($email)->send(new sendvendorotp_update($newmaildata1));

                
            // $content = "Dear $name,\nYour one time password for Mobile change is ".$randomno;
           $content = "Dear Vendor, Your one time password for Mobile Number updation is $randomno";

         $this->smscurlalt($content, $request->newnumber);
         //$mm =  $this->send_sms_using_dinstar1($content, $request->newnumber, rand(111,9999), 16);

         return 1;


        }
        else{
            return 6;
        }
}


public function editdetailsstep4(Request $request)
{
    if ($request->session()->has('vendorsession')) {
            $encrypt = $request->session()->get('vendorsession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $vendorid = $split[0];
            
            $getvendordata = DB::connection('mysql5')->table('vendor')->where('id', '=', $vendorid)->get();
            if (count($getvendordata) > 0) {
                foreach ($getvendordata as $key1 => $value1) {
                    $mobile = $value1->mobile;
                    $name = $value1->Name;
                }
            }

             $vendetails = $request->fapprv;
             $typetochangeval = $request->typetochangeval;
             $submitotp = $request->submitotp;


             if ($request->session()->has('vendapproved')) {
                     $getsess = $request->session()->get('vendapproved');
                    // return json_encode($getsess);
                 }
                 else{
                    $request->session()->forget('vendapproved');
                    return 12;
                 }

            
             //return $vendetails['id'];
             if ($vendorid != $vendetails['id']) {
                 return json_encode(['status' => 3, 'message' => "Vendor does not match!"]);
             }

             if ($vendetails['type'] == 'Mobile') {
                 if (ctype_digit($typetochangeval)) {

            if (strlen($typetochangeval) == 10) {
                $loginmode = 'loginmode_mobileno';
            }else{
                return 0;
            }
            }
            else{
                return 0;
            }
             }

            


            $now = Carbon::now()->toDateTimeString();

            //$randomno = rand(999, 999999);
           $getcheck = DB::connection('mysql5')->table('vendorcomm_updateotp')->where(['vendorid' => $vendorid, 'authenticate_type' => $getsess['type'],'validated' => 1,'validated_email' => 1, 'newdataotp' => $submitotp])->get();

           if (count($getcheck) > 0) {
               foreach ($getcheck as $key11 => $value11) {
                   $newdataotpattempt = $value11->newdataotpattempt;
                   $newdataotpexpiry = $value11->newdataotpexpiry;
                   $mobemotp = $value11->newdata;
               }

               if (strpos($value11->mobemaild, $typetochangeval) !== false) {
                   return 77;
               }

               if ($mobemotp != $typetochangeval) {
                   $request->session()->forget('vendapproved');
                    return 11;
               }

               if (Carbon::parse($now)->gt(Carbon::parse($newdataotpexpiry))) {
                    $request->session()->forget('vendapproved');
                    return 10;
               }
               

                if ($vendetails['type'] == 'Mobile') {

                    $arrtochange = [];
                    $arrtochange['Vendor_ID'] = $vendorid;
                    $arrtochange['Field_Name'] = "MOBILE";
                    $arrtochange['Field_Value'] = $typetochangeval;



                    $changeval = $this->vendor_detailsupdate($arrtochange);

                    if ($changeval['Status'] == 'Success') {
			
			 $getipdetails = $this->getip($request);
                $arr111 = [];
                $arr111['Vendor_ID'] = $vendorid;
                $arr111['URL'] = $request->url();
                $arr111['IP_Address'] = $getipdetails['iprequested'];
                $arr111['From_Mobile'] = $getipdetails['ismobile'];
                $arr111['From_Desktop'] = $getipdetails['isdesktop'];
                $arr111['Time_Stamp'] = Carbon::now()->toDateTimeString();
               $arr111resp = $this->requestipsend_tosap($arr111);                    
                    
                DB::connection('mysql5')->table('vendor')->where(['id' => $vendorid])->update(['mobile' => $typetochangeval]);

                foreach ($getcheck as $keyf => $valuef) {
                    
                DB::connection('mysql5')->table('vendorcomm_updateotp_history')->insert([
                'vendorid' => $valuef->vendorid,
                'mobemaild' => $valuef->mobemaild,
                'otp' => $valuef->otp,
                'authenticate_type' => $valuef->authenticate_type,
                'created_datetime' => $valuef->created_datetime,
                'expiry_time' => $valuef->expiry_time,
                'validated' => $valuef->validated,
                'authenticate_req_attempt' => $valuef->authenticate_req_attempt,
                'newdata' => $valuef->newdata,
                'newdataotp' => $valuef->newdataotp,
                'newdataotpattempt' => $valuef->newdataotpattempt,
                'newdataotpexpiry' => $valuef->newdataotpexpiry
             ]);
                }
            
                DB::connection('mysql5')->table('vendorcomm_updateotp')->where(['vendorid' => $vendorid, 'authenticate_type' => $getsess['type'], 'validated' => 1, 'newdataotp' => $submitotp])->delete();

               

                $request->session()->forget('vendapproved');
                }
                else{
                    $request->session()->forget('vendapproved');
                return 0;
                }
            }
            else{
                 //$request->session()->forget('vendapproved');
                return 0;
            }


               
           }
           else{
                //$request->session()->forget('vendapproved');
                return 0;
           }

            



                
             //$content = "Dear $name,\nYour one time password for Mobile change is ".$randomno;

         //$this->smscurlalt($content, $mobile);
        // $mm =  $this->send_sms_using_dinstar1($content, $mobile, rand(111,9999), 16);

         return 1;


        }
        else{
            return 6;
        }
}


public function editemaildetailsstep1(Request $request)
{
    if ($request->session()->has('vendorsession')) {
            $encrypt = $request->session()->get('vendorsession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $vendorid = $split[0];
            
            $getvendordata = DB::connection('mysql5')->table('vendor')->where('id', '=', $vendorid)->get();
            if (count($getvendordata) > 0) {
                foreach ($getvendordata as $key1 => $value1) {
                    $mobile = $value1->mobile;
                    $name = $value1->Name;
                    $email = $value1->email;
                }
            }
            

             $now = Carbon::now()->toDateTimeString();
             $expiryvalidate = DB::connection('mysql5')->table('vendorcomm_updateotp')->where(['vendorid' => $vendorid, 'authenticate_type' => 'Email','mobemaild' => $email])->where('authenticate_req_attempt','>=', 5)->get();

             if (count($expiryvalidate) > 0) {
                 
                 foreach ($expiryvalidate as $key11 => $value11) {
                     $extime = $value11->expiry_time;
                     $waitime = Carbon::parse($extime)->addMinutes(30)->toDateTimeString();
                     if (Carbon::parse($now)->lte(Carbon::parse($waitime))) {
                         $fmtime = Carbon::parse($waitime)->format('d, M Y h:i:s A');
                         return json_encode(['status' => 5, 'message' => "Too Many attempts. Please try after $fmtime"]);
                     }
                     else{
                        DB::connection('mysql5')->table('vendorcomm_updateotp')->where(['vendorid' => $vendorid, 'authenticate_type' => 'Email','mobemaild' => $email])->delete();
                       $request->session()->forget('vend_auth_email');
                     }
                 }
             }
             


             $uploadeddatetime = date('Ymd');
             $randomno = rand(999, 999999);
             $reqcode = str_shuffle($uploadeddatetime.$randomno);
             $getcheck = DB::connection('mysql5')->table('vendorcomm_updateotp')->where(['vendorid' => $vendorid, 'authenticate_type' => 'Email','mobemaild' => $email])->get();
             if (count($getcheck) == 0) {
                 $newattempt = 1;
             
             DB::connection('mysql5')->table('vendorcomm_updateotp')->insert([
                'vendorid' => $vendorid,
                'mobemaild' => $email,
                'otp' => $reqcode,
                'authenticate_type' => 'Email',
                'created_datetime' => Carbon::now()->toDateTimeString(),
                'expiry_time' => Carbon::now()->addMinutes(5)->toDateTimeString(),
                'validated' => 0,
                'validated_email' => 0,
                'authenticate_req_attempt' => $newattempt,
                'newdata' => null,
                'newdataotp' => null,
                'newdataotpattempt' => null,
                'newdataotpexpiry' => null
             ]);

             $request->session()->put('vend_auth_email.id', $vendorid);
             $request->session()->put('vend_auth_email.type', 'Email');
             $request->session()->put('vend_auth_email.attempt', 1);
             $request->session()->put('vend_auth_email.createdtime', $now);
            
         }
         else{
            foreach ($getcheck as $key => $value) {
                $authenticate_req_attempt = $value->authenticate_req_attempt;
            }
            $newattempt = $authenticate_req_attempt + 1;

            DB::connection('mysql5')->table('vendorcomm_updateotp')->where(['vendorid' => $vendorid, 'authenticate_type' => 'Email','mobemaild' => $email])->update([
                'otp' => $reqcode,
                'created_datetime' => Carbon::now()->toDateTimeString(),
                'validated' => 0,
                'validated_email' => 0,
                'expiry_time' => Carbon::now()->addMinutes(5)->toDateTimeString(),
                'authenticate_req_attempt' => $newattempt,
             ]);

            $request->session()->put('vend_auth_email.id', $vendorid);
             $request->session()->put('vend_auth_email.type', 'Email');
             $request->session()->put('vend_auth_email.attempt', $newattempt);
             $request->session()->put('vend_auth_email.createdtime', $now);
            
         }


         //$content = "Dear $name,\nYou have requested for Mobile number change. Please approve by clicking the below link. Ignore the message, if its not requested by you. https://www.vgn.in/vendauthupd/$reqcode";

         //$content = "Dear $name,\nYou have requested for Change of registered Email Address. Please approve the same  by clicking the below link. If you have not requested for change in your registered email id, kindly ignore the message. https://www.vgn.in/vendauthupd/$reqcode";

         $content = "Dear Vendor, You have requested for change of registered Email Address. Please approve the same by clicking the below link. If you have not requested for change in your registered Email Address, kindly ignore the message. https://vgn.in/vthup/$reqcode";

         $this->smscurlalt($content, $mobile);
        // $mm =  $this->send_sms_using_dinstar1($content, $mobile, rand(111,9999), 16);

         /*if ($mm['error_code']) {
             # code...
         }*/

         $newmaildata=[];
          $emailreqcode = ($reqcode + 250) *2;
     $newmaildata['email_link'] = "https://www.vgn.in/vendauthupdemail/".$emailreqcode;
     $newmaildata['email_type'] = "Email Address";

     Mail::to($email)->send(new vendorauthenticate($newmaildata));
     
            
             return json_encode(['status' => 1, 'message' => "Please authorize by clicking the link sent to your registered Mobile Number and Registerd Email ID to update the New Email Address.",'attempt' => $newattempt]);

             //dd($getvendordata);
            
        }
        return json_encode(['status' => 6, 'message' => "Invalid request. Try again later."]);
}

public function editemaildetailsstep2(Request $request)
{
    if ($request->session()->has('vendorsession')) {
            $encrypt = $request->session()->get('vendorsession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $vendorid = $split[0];
            
            $getvendordata = DB::connection('mysql5')->table('vendor')->where('id', '=', $vendorid)->get();
            if (count($getvendordata) > 0) {
                foreach ($getvendordata as $key1 => $value1) {
                    $mobile = $value1->mobile;
                    $name = $value1->Name;
                    $email = $value1->email;
                }
            }
            //return $mobile;
             $vendetails = $request->vendetails;


             if ($request->session()->has('vend_auth_email')) {
                     $getsess = $request->session()->get('vend_auth_email');
                 }
                 else{
                    $request->session()->forget('vend_auth_email');
                    return 12;
                 }

            
             //return $vendetails['id'];
             if ($vendorid != $vendetails['id']) {
                 return json_encode(['status' => 3, 'message' => "Vendor does not match!"]);
             }


             if ($getsess['id'] == $vendetails['id']) {
                $now = Carbon::now()->toDateTimeString();
             $expiryvalidate = DB::connection('mysql5')->table('vendorcomm_updateotp')->where(['vendorid' => $vendetails['id'], 'authenticate_type' => $vendetails['type']])->get();

             if (count($expiryvalidate) > 0) {
                 foreach ($expiryvalidate as $key12 => $value12) {
                     $expirytime = $value12->expiry_time;
                     $newattempt = $value12->authenticate_req_attempt;
                     $createdtime = $value12->created_datetime;
                     $add30min = Carbon::parse($expirytime)->addMinutes(30)->toDateTimeString();

                     if (Carbon::parse($now)->lte(Carbon::parse($add30min))) {
                         
                         if (($value12->validated == 1) && ($value12->validated_email == 1)) {
                            $request->session()->forget('vend_auth_email');
                            //$request->session()->flash("validatedmsg", "validated");
                            $request->session()->put('vendapprovedemail.id', $vendorid);
             $request->session()->put('vendapprovedemail.type', 'Email');
             $request->session()->put('vendapprovedemail.attempt', $newattempt);
             $request->session()->put('vendapprovedemail.createdtime', $createdtime);
             $request->session()->put('vendapprovedemail.authenticated', 'valid');
                
                            
                            return 1;
                         //$request->session()->put('vend_auth_mobile.authenticated', 'valid');
                         //return session()->all();
                            }
                            else{
                                return 2;
                            }
                     }
                     else{
                        DB::connection('mysql5')->table('vendorcomm_updateotp')->where(['vendorid' => $vendetails['id'], 'authenticate_type' => $vendetails['type']])->delete();
                        $request->session()->forget('vend_auth_email');

                        return 4;
                     }
                 }
                 
             }
             else{
                $request->session()->forget('vend_auth_email');
                return 0;
             }
            }

             
             


            
        }
        return json_encode(['status' => 6, 'message' => "Invalid request. Try again later."]);
}


public function editemaildetailsstep3(Request $request)
{
    if ($request->session()->has('vendorsession')) {
            $encrypt = $request->session()->get('vendorsession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $vendorid = $split[0];
            
            $getvendordata = DB::connection('mysql5')->table('vendor')->where('id', '=', $vendorid)->get();
            if (count($getvendordata) > 0) {
                foreach ($getvendordata as $key1 => $value1) {
                    $mobile = $value1->mobile;
                    $name = $value1->Name;
                    $email = $value1->email;
                }
            }

             $vendetails = $request->apprv;
             $newemail = $request->newemail;


             if ($request->session()->has('vendapprovedemail')) {
                     $getsess = $request->session()->get('vendapprovedemail');
                    // return json_encode($getsess);
                 }
                 else{
                    $request->session()->forget('vendapprovedemail');
                    return 12;
                 }

            
             //return $vendetails['id'];
             if ($vendorid != $vendetails['id']) {
                 return json_encode(['status' => 3, 'message' => "Vendor does not match!"]);
             }

            if (!filter_var($request->newemail, FILTER_VALIDATE_EMAIL)) {

                return 44;
            }


            $now = Carbon::now()->toDateTimeString();

            $randomno = rand(999, 999999);
           $getcheck = DB::connection('mysql5')->table('vendorcomm_updateotp')->where(['vendorid' => $vendorid, 'authenticate_type' => $getsess['type'],'validated' => 1])->get();

           if (count($getcheck) > 0) {
               foreach ($getcheck as $key11 => $value11) {
                   $newdataotpattempt = $value11->newdataotpattempt;
                   $newdataotpexpiry = $value11->newdataotpexpiry;
                   $newadded15min = Carbon::parse($value11->expiry_time)->addMinutes(15)->toDateTimeString();
               }

               if (strpos($value11->mobemaild, $newemail) !== false) {
                   return 77;
               }

               if ($newdataotpattempt >= 5) {
                    $request->session()->forget('vendapprovedemail');
                    return 0;
               }

               if (Carbon::parse($now)->gt(Carbon::parse($newadded15min))) {
                   $request->session()->forget('vendapprovedemail');
                   DB::connection('mysql5')->table('vendorcomm_updateotp')->where(['vendorid' => $vendorid, 'authenticate_type' => $getsess['type'], 'validated' => 1])->delete();
                return 0;
               }
               

                $nnewdataotpattempt = $newdataotpattempt + 1;
                DB::connection('mysql5')->table('vendorcomm_updateotp')->where(['vendorid' => $vendorid, 'authenticate_type' => $getsess['type'], 'validated' => 1])->update([
                'newdata' => $request->newemail,
                'newdataotp' => $randomno,
                'newdataotpattempt' => $nnewdataotpattempt,
                'newdataotpexpiry' => Carbon::now()->addMinutes(5)->toDateTimeString(),
             ]);

               




               
           }
           else{
                $request->session()->forget('vendapprovedemail');
                return 0;
           }

            
 $content = "Dear Vendor, Your one time password for Email Address updation is $randomno";

         $this->smscurlalt($content, $mobile);


                
            $newmaildata=[];
     $newmaildata['email_otp'] = $randomno;
     $newmaildata['email_otptype'] = 'Email Address';

     Mail::to($request->newemail)->send(new sendvendorotp_update($newmaildata));

         return 1;


        }
        else{
            return 6;
        }
}


public function editemaildetailsstep4(Request $request)
{
    if ($request->session()->has('vendorsession')) {
            $encrypt = $request->session()->get('vendorsession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $vendorid = $split[0];
            
            $getvendordata = DB::connection('mysql5')->table('vendor')->where('id', '=', $vendorid)->get();
            if (count($getvendordata) > 0) {
                foreach ($getvendordata as $key1 => $value1) {
                    $mobile = $value1->mobile;
                    $name = $value1->Name;
                    $email = $value1->email;
                }
            }

             $vendetails = $request->fapprv;
             $typetochangeval = $request->typetochangeval;
             $submitotp = $request->submitotp;


             if ($request->session()->has('vendapprovedemail')) {
                     $getsess = $request->session()->get('vendapprovedemail');
                     //return json_encode($getsess);
                 }
                 else{
                    $request->session()->forget('vendapprovedemail');
                    return 12;
                 }

            
             //return $vendetails['id'];
             if ($vendorid != $vendetails['id']) {
                 return json_encode(['status' => 3, 'message' => "Vendor does not match!"]);
             }

             if ($vendetails['type'] == 'Email') {
                if (!filter_var($typetochangeval, FILTER_VALIDATE_EMAIL)) {

                return 0;
            }
             }

            


            $now = Carbon::now()->toDateTimeString();

            $randomno = rand(999, 999999);
           $getcheck = DB::connection('mysql5')->table('vendorcomm_updateotp')->where(['vendorid' => $vendorid, 'authenticate_type' => $getsess['type'],'validated' => 1, 'newdataotp' => $submitotp])->get();

           if (count($getcheck) > 0) {
               foreach ($getcheck as $key11 => $value11) {
                   $newdataotpattempt = $value11->newdataotpattempt;
                   $newdataotpexpiry = $value11->newdataotpexpiry;
                   $mobemotp = $value11->newdata;
               }

               if (strpos($value11->mobemaild, $typetochangeval) !== false) {
                   return 77;
               }

               if ($mobemotp != $typetochangeval) {
                   $request->session()->forget('vendapprovedemail');
                    return 11;
               }

               if (Carbon::parse($now)->gt(Carbon::parse($newdataotpexpiry))) {
                    $request->session()->forget('vendapprovedemail');
                    return 10;
               }
               

                if ($vendetails['type'] == 'Email') {

                    $arrtochange = [];
                    $arrtochange['Vendor_ID'] = $vendorid;
                    $arrtochange['Field_Name'] = "MAIL";
                    $arrtochange['Field_Value'] = $typetochangeval;



                    $changeval = $this->vendor_detailsupdate($arrtochange);

                    if ($changeval['Status'] == 'Success') {
			

			 $getipdetails = $this->getip($request);
                $arr111 = [];
                $arr111['Vendor_ID'] = $vendorid;
                $arr111['URL'] = $request->url();
                $arr111['IP_Address'] = $getipdetails['iprequested'];
                $arr111['From_Mobile'] = $getipdetails['ismobile'];
                $arr111['From_Desktop'] = $getipdetails['isdesktop'];
                $arr111['Time_Stamp'] = Carbon::now()->toDateTimeString();
               $arr111resp = $this->requestipsend_tosap($arr111);

                DB::connection('mysql5')->table('vendor')->where(['id' => $vendorid])->update(['email' => $typetochangeval]);

                foreach ($getcheck as $keyf => $valuef) {
                    
                DB::connection('mysql5')->table('vendorcomm_updateotp_history')->insert([
                'vendorid' => $valuef->vendorid,
                'mobemaild' => $valuef->mobemaild,
                'otp' => $valuef->otp,
                'authenticate_type' => $valuef->authenticate_type,
                'created_datetime' => $valuef->created_datetime,
                'expiry_time' => $valuef->expiry_time,
                'validated' => $valuef->validated,
                'authenticate_req_attempt' => $valuef->authenticate_req_attempt,
                'newdata' => $valuef->newdata,
                'newdataotp' => $valuef->newdataotp,
                'newdataotpattempt' => $valuef->newdataotpattempt,
                'newdataotpexpiry' => $valuef->newdataotpexpiry
             ]);
                }
            
                DB::connection('mysql5')->table('vendorcomm_updateotp')->where(['vendorid' => $vendorid, 'authenticate_type' => $getsess['type'], 'validated' => 1, 'newdataotp' => $submitotp])->delete();

               

                $request->session()->forget('vendapprovedemail');
            }
            else{
                $request->session()->forget('vendapprovedemail');
                return 0;
            }

            }
            else{
                $request->session()->forget('vendapprovedemail');
                return 0;
            }
               
           }
           else{
                //$request->session()->forget('vendapprovedemail');
                return 0;
           }

            



                
             //$content = "Dear $name,\nYour one time password for Email Address is ".$randomno;

         //$this->smscurlalt($content, $mobile);
        // $mm =  $this->send_sms_using_dinstar1($content, $mobile, rand(111,9999), 16);

         return 1;


        }
        else{
            return 6;
        }
}

public function editbankdetailsstep1(Request $request)
{
    if ($request->session()->has('vendorsession')) {
            $encrypt = $request->session()->get('vendorsession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $vendorid = $split[0];
            
            $getvendordata = DB::connection('mysql5')->table('vendor')->where('id', '=', $vendorid)->get();
            if (count($getvendordata) > 0) {
                foreach ($getvendordata as $key1 => $value1) {
                    $mobile = $value1->mobile;
                    $name = $value1->Name;
                    $email = $value1->email;
                }
            }
            

             $now = Carbon::now()->toDateTimeString();
             $expiryvalidate = DB::connection('mysql5')->table('vendorcomm_updateotp')->where(['vendorid' => $vendorid, 'authenticate_type' => 'editbankdetails','mobemaild' => $mobile])->where('authenticate_req_attempt','>=', 5)->get();
             if (count($expiryvalidate) > 0) {
                 
                 foreach ($expiryvalidate as $key11 => $value11) {
                     $extime = $value11->expiry_time;
                     $waitime = Carbon::parse($extime)->addMinutes(60)->toDateTimeString();
                     if (Carbon::parse($now)->lte(Carbon::parse($waitime))) {
                         $fmtime = Carbon::parse($waitime)->format('d, M Y h:i:s A');
                         return json_encode(['status' => 5, 'message' => "Too Many attempts. Please try after $fmtime"]);
                     }
                     else{
                        DB::connection('mysql5')->table('vendorcomm_updateotp')->where(['vendorid' => $vendorid, 'authenticate_type' => 'editbankdetails','mobemaild' => $mobile])->delete();
                        $request->session()->forget('vend_auth_editbank');
                     }
                 }
             }
             


             $uploadeddatetime = date('Ymd');
             $randomno = rand(999, 999999);
             $reqcode = str_shuffle($uploadeddatetime.$randomno);
             $getcheck = DB::connection('mysql5')->table('vendorcomm_updateotp')->where(['vendorid' => $vendorid, 'authenticate_type' => 'editbankdetails','mobemaild' => $mobile])->get();
            //  dd($getcheck);
             if (count($getcheck) == 0) {
                 $newattempt = 1;
             
             DB::connection('mysql5')->table('vendorcomm_updateotp')->insert([
                'vendorid' => $vendorid,
                'mobemaild' => $mobile,
                'otp' => $reqcode,
                'authenticate_type' => 'editbankdetails',
                'created_datetime' => Carbon::now()->toDateTimeString(),
                'expiry_time' => Carbon::now()->addMinutes(60)->toDateTimeString(),
                'validated' => 0,
                'validated_email' => 0,
                'authenticate_req_attempt' => $newattempt,
                'newdata' => null,
                'newdataotp' => null,
                'newdataotpattempt' => null,
                'newdataotpexpiry' => null
             ]);

             $request->session()->put('vend_auth_editbank.id', $vendorid);
             $request->session()->put('vend_auth_editbank.type', 'editbankdetails');
             $request->session()->put('vend_auth_editbank.attempt', 1);
             $request->session()->put('vend_auth_editbank.createdtime', $now);
            
         }
         else{
            foreach ($getcheck as $key => $value) {
                $authenticate_req_attempt = $value->authenticate_req_attempt;
            }
            $newattempt = $authenticate_req_attempt + 1;

            DB::connection('mysql5')->table('vendorcomm_updateotp')->where(['vendorid' => $vendorid, 'authenticate_type' => 'editbankdetails','mobemaild' => $mobile])->update([
                'otp' => $reqcode,
                'created_datetime' => Carbon::now()->toDateTimeString(),
                'validated' => 0,
                'validated_email' => 0,
                'expiry_time' => Carbon::now()->addMinutes(60)->toDateTimeString(),
                'authenticate_req_attempt' => $newattempt,
             ]);

            $request->session()->put('vend_auth_editbank.id', $vendorid);
             $request->session()->put('vend_auth_editbank.type', 'editbankdetails');
             $request->session()->put('vend_auth_editbank.attempt', $newattempt);
             $request->session()->put('vend_auth_editbank.createdtime', $now);
            
         }


         //$content = "Dear $name,\nYou have requested for Mobile number change. Please approve by clicking the below link. Ignore the message, if its not requested by you. https://www.vgn.in/vendauthupd/$reqcode";

         //$content = "Dear $name,\nYou have requested for change of bank details. Please approve the same by clicking the below link. If you have not requested for change in your bank details, kindly ignore the message. https://www.vgn.in/vendauthupd/$reqcode";

         $content = "Dear Vendor, You have requested for change of bank details. Please approve the same by clicking the below link. If you have not requested for change in your bank details, kindly ignore the message. https://vgn.in/vthup/$reqcode";

         $this->smscurlalt($content, $mobile);
        // $mm =  $this->send_sms_using_dinstar1($content, $mobile, rand(111,9999), 16);

         /*if ($mm['error_code']) {
             # code...
         }*/

         $newmaildata=[];
          $emailreqcode = ($reqcode + 250) *2;
     $newmaildata['email_link'] = "https://www.vgn.in/vendauthupdemail/".$emailreqcode;
     $newmaildata['email_type'] = "Bank Details";

     Mail::to($email)->send(new vendorauthenticate($newmaildata));
            
             return json_encode(['status' => 1, 'message' => "Please authorize by clicking the link sent to your registered Mobile Number and Registerd Email ID to update the New Bank Details.",'attempt' => $newattempt]);

             //dd($getvendordata);
            
        }
        return json_encode(['status' => 6, 'message' => "Invalid request. Try again later."]);
}


public function editbankdetailsstep2(Request $request)
{
    if ($request->session()->has('vendorsession')) {
            $encrypt = $request->session()->get('vendorsession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $vendorid = $split[0];
            
            $getvendordata = DB::connection('mysql5')->table('vendor')->where('id', '=', $vendorid)->get();
            if (count($getvendordata) > 0) {
                foreach ($getvendordata as $key1 => $value1) {
                    $mobile = $value1->mobile;
                    $name = $value1->Name;
                }
            }
            //return $mobile;
             $vendetails = $request->vendetails;


             if ($request->session()->has('vend_auth_editbank')) {
                     $getsess = $request->session()->get('vend_auth_editbank');
                 }
                 else{
                    $request->session()->forget('vend_auth_editbank');
                    return 12;
                 }

            
             //return $vendetails['id'];
             if ($vendorid != $vendetails['id']) {
                 return json_encode(['status' => 3, 'message' => "Vendor does not match!"]);
             }


             if ($getsess['id'] == $vendetails['id']) {
                $now = Carbon::now()->toDateTimeString();
             $expiryvalidate = DB::connection('mysql5')->table('vendorcomm_updateotp')->where(['vendorid' => $vendetails['id'], 'authenticate_type' => $vendetails['type']])->get();

             if (count($expiryvalidate) > 0) {
                 foreach ($expiryvalidate as $key12 => $value12) {
                     $expirytime = $value12->expiry_time;
                     $newattempt = $value12->authenticate_req_attempt;
                     $createdtime = $value12->created_datetime;
                     $add30min = Carbon::parse($expirytime)->addMinutes(30)->toDateTimeString();

                     if (Carbon::parse($now)->lte(Carbon::parse($add30min))) {
                         
                         if (($value12->validated == 1) && ($value12->validated_email == 1)) {
                            $request->session()->forget('vend_auth_editbank');
                            //$request->session()->flash("validatedmsg", "validated");
                            $request->session()->put('vendapprovededitbank.id', $vendorid);
             $request->session()->put('vendapprovededitbank.type', 'editbankdetails');
             $request->session()->put('vendapprovededitbank.attempt', $newattempt);
             $request->session()->put('vendapprovededitbank.createdtime', $createdtime);
             $request->session()->put('vendapprovededitbank.authenticated', 'valid');
                
                            
                            return 1;
                         //$request->session()->put('vend_auth_mobile.authenticated', 'valid');
                         //return session()->all();
                            }
                            else{
                                return 2;
                            }
                     }
                     else{
                        DB::connection('mysql5')->table('vendorcomm_updateotp')->where(['vendorid' => $vendetails['id'], 'authenticate_type' => $vendetails['type']])->delete();
                        $request->session()->forget('vend_auth_editbank');

                        return 4;
                     }
                 }
                 
             }
             else{
                $request->session()->forget('vend_auth_editbank');
                return 0;
             }
            }

             
             


            
        }
        return json_encode(['status' => 6, 'message' => "Invalid request. Try again later."]);
}


public function editpasswordstep1(Request $request)
{
    if ($request->session()->has('vendorsession')) {
            $encrypt = $request->session()->get('vendorsession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $vendorid = $split[0];
            
            $getvendordata = DB::connection('mysql5')->table('vendor')->where('id', '=', $vendorid)->get();
            if (count($getvendordata) > 0) {
                foreach ($getvendordata as $key1 => $value1) {
                    $mobile = $value1->mobile;
                    $name = $value1->Name;
                    $email = $value1->email;
                }
            }
            

             $now = Carbon::now()->toDateTimeString();
             $expiryvalidate = DB::connection('mysql5')->table('vendorcomm_updateotp')->where(['vendorid' => $vendorid, 'authenticate_type' => 'editpassworddetails','mobemaild' => $mobile])->where('authenticate_req_attempt','>=', 5)->get();

             if (count($expiryvalidate) > 0) {
                 
                 foreach ($expiryvalidate as $key11 => $value11) {
                     $extime = $value11->expiry_time;
                     $waitime = Carbon::parse($extime)->addMinutes(60)->toDateTimeString();
                     if (Carbon::parse($now)->lte(Carbon::parse($waitime))) {
                         $fmtime = Carbon::parse($waitime)->format('d, M Y h:i:s A');
                         return json_encode(['status' => 5, 'message' => "Too Many attempts. Please try after $fmtime"]);
                     }
                     else{
                        DB::connection('mysql5')->table('vendorcomm_updateotp')->where(['vendorid' => $vendorid, 'authenticate_type' => 'editpassworddetails','mobemaild' => $mobile])->delete();
                        $request->session()->forget('vend_auth_editpassword');
                     }
                 }
             }
             


             $uploadeddatetime = date('Ymd');
             $randomno = rand(999, 999999);
             $reqcode = str_shuffle($uploadeddatetime.$randomno);
             $getcheck = DB::connection('mysql5')->table('vendorcomm_updateotp')->where(['vendorid' => $vendorid, 'authenticate_type' => 'editpassworddetails','mobemaild' => $mobile])->get();
             if (count($getcheck) == 0) {
                 $newattempt = 1;
             
             DB::connection('mysql5')->table('vendorcomm_updateotp')->insert([
                'vendorid' => $vendorid,
                'mobemaild' => $mobile,
                'otp' => $reqcode,
                'authenticate_type' => 'editpassworddetails',
                'created_datetime' => Carbon::now()->toDateTimeString(),
                'expiry_time' => Carbon::now()->addMinutes(60)->toDateTimeString(),
                'validated' => 0,
                'validated_email' => 0,
                'authenticate_req_attempt' => $newattempt,
                'newdata' => null,
                'newdataotp' => null,
                'newdataotpattempt' => null,
                'newdataotpexpiry' => null
             ]);

             $request->session()->put('vend_auth_editpassword.id', $vendorid);
             $request->session()->put('vend_auth_editpassword.type', 'editpassworddetails');
             $request->session()->put('vend_auth_editpassword.attempt', 1);
             $request->session()->put('vend_auth_editpassword.createdtime', $now);
            
         }
         else{
            foreach ($getcheck as $key => $value) {
                $authenticate_req_attempt = $value->authenticate_req_attempt;
            }
            $newattempt = $authenticate_req_attempt + 1;

            DB::connection('mysql5')->table('vendorcomm_updateotp')->where(['vendorid' => $vendorid, 'authenticate_type' => 'editpassworddetails','mobemaild' => $mobile])->update([
                'otp' => $reqcode,
                'created_datetime' => Carbon::now()->toDateTimeString(),
                'validated' => 0,
                'validated_email' => 0,
                'expiry_time' => Carbon::now()->addMinutes(60)->toDateTimeString(),
                'authenticate_req_attempt' => $newattempt,
             ]);

            $request->session()->put('vend_auth_editpassword.id', $vendorid);
             $request->session()->put('vend_auth_editpassword.type', 'editpassworddetails');
             $request->session()->put('vend_auth_editpassword.attempt', $newattempt);
             $request->session()->put('vend_auth_editpassword.createdtime', $now);
            
         }


         //$content = "Dear $name,\nYou have requested for Mobile number change. Please approve by clicking the below link. Ignore the message, if its not requested by you. https://www.vgn.in/vendauthupd/$reqcode";

         //$content = "Dear $name,\nYou have requested for change of Password. Please approve the same by clicking the below link. If you have not requested for change in your Password, kindly ignore the message. https://www.vgn.in/vendauthupd/$reqcode";

 $content = "Dear $name, You have requested for change of password. Please approve the same by clicking the below link. If you have not requested for change in your password, kindly ignore the message. https://vgn.in/vthup/$reqcode";
         $this->smscurlalt($content, $mobile);
        //$mm =  $this->send_sms_using_dinstar1($content, $mobile, rand(111,9999), 16);

         /*if ($mm['error_code']) {
             # code...
         }*/

         $newmaildata=[];
          $emailreqcode = ($reqcode + 250) *2;
     $newmaildata['email_link'] = "https://www.vgn.in/vendauthupdemail/".$emailreqcode;
     $newmaildata['email_type'] = "Password";

     Mail::to($email)->send(new vendorauthenticate($newmaildata));
            
             return json_encode(['status' => 1, 'message' => "Please authorize by clicking the link sent to your registered Mobile Number and Registerd Email ID to update the New Password.",'attempt' => $newattempt]);

             //dd($getvendordata);
            
        }
        return json_encode(['status' => 6, 'message' => "Invalid request. Try again later."]);
}


public function editpasswordstep2(Request $request)
{
    if ($request->session()->has('vendorsession')) {
            $encrypt = $request->session()->get('vendorsession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $vendorid = $split[0];
            
            $getvendordata = DB::connection('mysql5')->table('vendor')->where('id', '=', $vendorid)->get();
            if (count($getvendordata) > 0) {
                foreach ($getvendordata as $key1 => $value1) {
                    $mobile = $value1->mobile;
                    $name = $value1->Name;
                }
            }
            //return $mobile;
             $vendetails = $request->vendetails;


             if ($request->session()->has('vend_auth_editpassword')) {
                     $getsess = $request->session()->get('vend_auth_editpassword');
                 }
                 else{
                    $request->session()->forget('vend_auth_editpassword');
                    return 12;
                 }

            
             //return $vendetails['id'];
             if ($vendorid != $vendetails['id']) {
                 return json_encode(['status' => 3, 'message' => "Vendor does not match!"]);
             }


             if ($getsess['id'] == $vendetails['id']) {
                $now = Carbon::now()->toDateTimeString();
             $expiryvalidate = DB::connection('mysql5')->table('vendorcomm_updateotp')->where(['vendorid' => $vendetails['id'], 'authenticate_type' => $vendetails['type']])->get();

             if (count($expiryvalidate) > 0) {
                 foreach ($expiryvalidate as $key12 => $value12) {
                     $expirytime = $value12->expiry_time;
                     $newattempt = $value12->authenticate_req_attempt;
                     $createdtime = $value12->created_datetime;
                     $add30min = Carbon::parse($expirytime)->addMinutes(30)->toDateTimeString();

                     if (Carbon::parse($now)->lte(Carbon::parse($add30min))) {
                         
                         if (($value12->validated == 1) && ($value12->validated_email == 1)) {
                            $request->session()->forget('vend_auth_editpassword');
                            //$request->session()->flash("validatedmsg", "validated");
                            $request->session()->put('vendapprovededitpassword.id', $vendorid);
             $request->session()->put('vendapprovededitpassword.type', 'editpassworddetails');
             $request->session()->put('vendapprovededitpassword.attempt', $newattempt);
             $request->session()->put('vendapprovededitpassword.createdtime', $createdtime);
             $request->session()->put('vendapprovededitpassword.authenticated', 'valid');
                
                            
                            return 1;
                         //$request->session()->put('vend_auth_mobile.authenticated', 'valid');
                         //return session()->all();
                            }
                            else{
                                return 2;
                            }
                     }
                     else{
                        DB::connection('mysql5')->table('vendorcomm_updateotp')->where(['vendorid' => $vendetails['id'], 'authenticate_type' => $vendetails['type']])->delete();
                        $request->session()->forget('vend_auth_editpassword');

                        return 4;
                     }
                 }
                 
             }
             else{
                $request->session()->forget('vend_auth_editpassword');
                return 0;
             }
            }

             
             


            
        }
        return json_encode(['status' => 6, 'message' => "Invalid request. Try again later."]);
}
public function vendorreg_filesrequired(Request $request)
{
    $vendorgroupid = $request->vendaccountid;
    if (!empty($vendorgroupid)) {
        $data = $this->vendorregfiles_list(trim($vendorgroupid));
        if ($data != '') {
            if (array_key_exists('0', $data['Details'])) {
                $main = $data['Details'];
            }
            else{
                $main[0] = $data['Details'];
            }

            if (count($main) > 0) {
                $mm = [];
                $kk = 0;
                foreach ($main as $keym => $valuem) {
                    $mm['Doc_Name'][$kk] = ucwords(strtolower($valuem['Doc_Name']));
                    $mm['Attachment_Ind'][$kk] = $valuem['Attachment_Ind'];
                    $kk++;
                }
                return json_encode($mm);
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

 public function checkvendorregfile(Request $request)
    {
        $resp = json_encode($request->all());

        $vgndecode = json_decode($resp, true);
        //dd($vgndecode);
        $vend_app_no = $vgndecode['Vendor_Registration_Number'];
        $doc_name = $vgndecode['Doc_Name'];
        if (($vend_app_no != '') && ($doc_name != '')) {
            //$getaadhaarotpdata = $this->generateotpinaadhaarkyc($aadhaarno);

            $checkdata = DB::connection('mysql5')->table('vendorreg_files')->where([
                'appid' => $vend_app_no,
                'vendsap_filename' => $doc_name
            ])->get();

            if (count($checkdata) > 0) {
                foreach ($checkdata as $key => $value) {
                    $cdnurl = $value->uploaded_path;
                }

                return json_encode(['URL' => $cdnurl ]); 
            }
            else{
                return json_encode(['URL' => '' ]); 
            }

            
        }
        
        
        
         return json_encode(['URL' => '' ]); 
    }
    public function getverifysendandsavevendor_registerotp(Request $request)
{
    if ($request->has('mobileotp')) {
     $mobileno = $request->mobileotp;


     $checkmobileexist = $this->mobilenoregisterd_validation($mobileno);
     if ($checkmobileexist == 1) {
                $resp = ['status' => 4];

                return json_encode($resp);
     }

     $check_pre_register_mobileexist = $this->pre_mobilenoregisterd_validation($mobileno);
     if ($check_pre_register_mobileexist == 1) {
                $resp = ['status' => 5];

                return json_encode($resp);
     }

     

     

     //return 'naveen';

     $request->session()->forget('getverifyvendorreg_mobileotp');
     $request->session()->forget('getverifymobileverification');

     if ($request->session()->has('getverifyvendormobileotp_attempt')) {
         $vendormobileotp_attempt = $request->session()->get('getverifyvendormobileotp_attempt');


         if ($vendormobileotp_attempt['mobileotpattempt'] <= 5) {
             $tried = $vendormobileotp_attempt['mobileotpattempt'] + 1;
             $vendormobileotp_attempt['currenttime'] =  Carbon::now()->toDateTimeString();

             $request->session()->put('getverifyvendormobileotp_attempt.mobileotpattempt', $tried);
             $request->session()->put('getverifyvendormobileotp_attempt.currenttime', Carbon::now()->toDateTimeString());
         }
         else{
            $vendormobileotp_attempt['currenttime'] =  Carbon::parse($vendormobileotp_attempt['currenttime'])->addMinutes(30)->toDateTimeString();
            if (Carbon::now()->gt(Carbon::parse($vendormobileotp_attempt['currenttime']))) {
                $request->session()->forget('getverifyvendormobileotp_attempt');

                $arr1 = [];
                $arr1['currenttime'] = Carbon::now()->toDateTimeString();
                $arr1['mobileotpattempt'] = 1;
                $request->session()->put('getverifyvendormobileotp_attempt', $arr1);
                
            }
            else{
                 $resp = ['status' => 2];

                return json_encode($resp);
            }
         }
         
     }
     else{
        $arr1 = [];
        $arr1['currenttime'] = Carbon::now()->toDateTimeString();
        $arr1['mobileotpattempt'] = 1;
        $request->session()->put('getverifyvendormobileotp_attempt', $arr1);
       // return 'naveen';
     }

     //$otptriggered_count = 1;
//return json_encode($request->session()->get('vendormobileotp_attempt'));

     $otptext = mt_rand(1090,9997);     
     $now = Carbon::now()->toDateTimeString();


     $smscontent = 'Dear Vendor'.', Your One Time Password for vendor registration is '.$otptext;
        Log::info($smscontent); 
        $otphash = ['mobilenumber' => $mobileno, 'mobileotpsent' => $otptext];

                
               $sms_status = $this->smscurl($smscontent, $mobileno);               
                DB::table('sms_sent_data')->insert(['Mobile' => $mobileno,'sentdatetime' => "$now"]);

                $hashmobkey = Crypt::encrypt($otphash);

                $request->session()->put('getverifyvendorreg_mobileotp', $hashmobkey);
                
        $resp = ['status' => 1];
        return json_encode($resp);



    }
    //$request->mobileotp;
}

public function getverifyvalidatemobileotp(Request $request)
{
    if ($request->session()->has('getverifyvendorreg_mobileotp')) {
        $preval = $request->session()->get('getverifyvendorreg_mobileotp');
        $request->session()->forget('getverifymobileverification');
        $decrypt = Crypt::decrypt($preval);
        $otpverified = 0;
        if (($decrypt['mobileotpsent'] == $request->mobileotpbyuser) && ($decrypt['mobilenumber'] == $request->mobileno1)) {
            $decrypt['mobileverified'] = 1;
            $otpverified = 1;
            $request->session()->put('getverifymobileverification', Crypt::encrypt($decrypt));
        }

        return json_encode(['otpbyuser' => $request->mobileotpbyuser, 'otpverified' => $otpverified]);
    }
    else{
        return json_encode(['otpbyuser' => $request->mobileotpbyuser]);
    }
}

public function getverifysendandsavevendor_registerotpemail(Request $request)
{
    if ($request->has('emailotp')) {
        //$request->session()->forget('vendoremailotp_attempt');

$emailid = $request->emailotp;


if (!filter_var($emailid, FILTER_VALIDATE_EMAIL)) {
            $resp = ['status1' => 3];

                return json_encode($resp);
        }
        $checkemailexist = $this->emailregisterd_validation($emailid);
     if ($checkemailexist == 1) {
                $resp = ['status1' => 4];

                return json_encode($resp);
     }

        $check_pre_register_emailexist = $this->pre_emailregisterd_validation($emailid);
     if ($check_pre_register_emailexist == 1) {
                $resp = ['status1' => 5];

                return json_encode($resp);
     }

 

        

     
     $request->session()->forget('getverifyvendorreg_emailotp');
     $request->session()->forget('getverifyemailverification');


     if ($request->session()->has('getverifyvendoremailotp_attempt')) {
         $vendoremailotp_attempt = $request->session()->get('getverifyvendoremailotp_attempt');


         if ($vendoremailotp_attempt['emailotpattempt'] <= 5) {
             $tried = $vendoremailotp_attempt['emailotpattempt'] + 1;
             $vendoremailotp_attempt['currenttime'] =  Carbon::now()->toDateTimeString();

             $request->session()->put('getverifyvendoremailotp_attempt.emailotpattempt', $tried);
             $request->session()->put('getverifyvendoremailotp_attempt.currenttime', Carbon::now()->toDateTimeString());
         }
         else{
            $vendoremailotp_attempt['currenttime'] =  Carbon::parse($vendoremailotp_attempt['currenttime'])->addMinutes(30)->toDateTimeString();
            if (Carbon::now()->gt(Carbon::parse($vendoremailotp_attempt['currenttime']))) {
                $request->session()->forget('getverifyvendoremailotp_attempt');

                $arr1 = [];
                $arr1['currenttime'] = Carbon::now()->toDateTimeString();
                $arr1['emailotpattempt'] = 1;
                $request->session()->put('getverifyvendoremailotp_attempt', $arr1);
                
            }
            else{
                 $resp = ['status1' => 2];

                return json_encode($resp);
            }
         }
         
     }
     else{
        $arr1 = [];
        $arr1['currenttime'] = Carbon::now()->toDateTimeString();
        $arr1['emailotpattempt'] = 1;
        $request->session()->put('getverifyvendoremailotp_attempt', $arr1);
       // return 'naveen';
     }

     //$otptriggered_count = 1;

     //return json_encode($request->session()->get('vendoremailotp_attempt'));

     $otptext1 = mt_rand(1090,9997);     
     $now = Carbon::now()->toDateTimeString();


     //$smscontent = 'Dear Vendor'.', Your One Time Password for vendor registration is '.$otptext;
     $newmaildata=[];
     $newmaildata['email_otp'] = $otptext1;

     Mail::to($emailid)->send(new sendvendorotp_reg($newmaildata));
        Log::info('vendor registration email : '.$emailid.' '.$otptext1);
        $otphash = ['emailid' => $emailid, 'emailotpsent' => $otptext1];

                $hashmobkey1 = Crypt::encrypt($otphash);

                $request->session()->put('getverifyvendorreg_emailotp', $hashmobkey1);
        $resp = ['status1' => 1];
        return json_encode($resp);



    }
    //$request->mobileotp;
}

public function getverifyvalidateemailotp(Request $request)
{
    if ($request->session()->has('getverifyvendorreg_emailotp')) {
        $request->session()->forget('getverifyemailverification');
        $preval = $request->session()->get('getverifyvendorreg_emailotp');
        $decrypt = Crypt::decrypt($preval);
        $otpverified = 0;
        if (($decrypt['emailotpsent'] == $request->emailotpbyuser) && ($decrypt['emailid'] == $request->email1)) {
            $otpverified = 1;
            $decrypt['emailverified'] = 1;
            $request->session()->put('getverifyemailverification', Crypt::encrypt($decrypt));
        }

        return json_encode(['emailotpbyuser' => $request->mobileotpbyuser, 'emailotpverified' => $otpverified]);
    }
    else{
        return json_encode(['emailotpbyuser' => $request->mobileotpbyuser]);
    }
}

public function getverifypanno_validation(Request $request)
{
    

if ($request->has('panno')) {

    $res = $this->vendor_pan_validation($request->panno);

         if ($res['STATUS'] == 'Valid') {

            $check_pre_register_panexist = $this->pre_panno_validation($request->panno);
            if ($check_pre_register_panexist != 1) {
                $resp = ['status' => 5, 'pan' => $request->panno];
                return json_encode($resp);
            }else{
                $resp = ['status' => 1];
                return json_encode($resp);
            }
         }
         else{
            $resp = ['status' => 4, 'pan' => $request->panno];
                return json_encode($resp);
         }
}
else{
     $resp = ['status' => 0, 'pan' => 'invalid'];
                return json_encode($resp);
}


}

     public function getverifypangst(Request $request, $vcode)
    {
        $dec1 = ($vcode - 1942) / 4 ;

        //dd($dec1);
        $arr = [];
        $arr['VEND_ID'] = $dec1;
        $arr['MOBILE_NO'] = '';
        $arr['E_MAIL'] = '';
        $res = $this->checkvendor($arr);
        //dd($res);
        $mm = [];
        if($res['NAME'] != "0"){
            $mm['vendorid'] = $res['VEND_ID'];
            $mm['vendorname'] = $res['NAME'];
            $mm['mobilenumber'] = ($res['MOBILE_NO'] == '0') ? '' : $res['MOBILE_NO'];
            $mm['emailid'] = ($res['E_MAIL'] == '0') ? '' : $res['E_MAIL'];


             if ($request->session()->has('getverifyauthorizedvendor')) {
        return redirect()->route('getverifyverifiedvendor');
    }
            

            $proofoption = '';
                   $proofoptionvalue = '';
                   $updatedtime = '';
                   $updatedmobilenumber = '';
                   $updatedemailid = '';

            $checkdata = DB::connection('mysql5')->table('vendorgstpanverify')->where([
                'vendorid' => $mm['vendorid'] ])->get();

            if (count($checkdata) > 0) {
               foreach ($checkdata as $key => $value) {
                   $proofoption = $value->opted_option;
                   $proofoptionvalue = $value->opted_value;
                   $updatedtime = $value->updatedtime;
                   $updatedmobilenumber = $value->mobno;
                   $updatedemailid = $value->emailid;
               }
            }
            
        }
        else{
            return redirect('newvendor_home');
            //dd($res);
        }
        //dd($mm);
        return view('newvendorzone.getverifypangst')->with(['mmvend' => $mm, 'proofoption' => $proofoption, 'proofoptionvalue' => $proofoptionvalue, 'updatedtime' => $updatedtime, 'updatedmobilenumber' => $updatedmobilenumber,'updatedemailid' => $updatedemailid,'vcode' => $vcode]);
    }


     public function postgetverifypangst(Request $request, $vcode){
        
        $validate = $this->validate($request, [
            'registration_proof' => 'required|in:gstno,panno',
            'registration_proof_number' => 'required',
            
            ]);

        $verified_email = 0;
$verified_mobile = 0;
$verified_pan = 0;
            
            $mmfiles = [];

             $dec1 = ($vcode - 1942) / 4 ;

        //dd($dec1);
        $arr = [];
        $arr['VEND_ID'] = $dec1;
        $arr['MOBILE_NO'] = '';
        $arr['E_MAIL'] = '';
        $res = $this->checkvendor($arr);
        //dd($res);


        $mm = [];
        if($res['NAME'] != "0"){
            $mm['vendorid'] = $res['VEND_ID'];
            $mm['vendorname'] = $res['NAME'];
            $mm['mobilenumber'] = ($res['MOBILE_NO'] == '0') ? '' : $res['MOBILE_NO'];
            $mm['emailid'] = ($res['E_MAIL'] == '0') ? '' : $res['E_MAIL'];
            

            $proofoption = '';
                   $proofoptionvalue = '';
                   $updatedtime = '';
                   $updatedmobilenumber = '';
                   $updatedemailid = '';

            $checkdata = DB::connection('mysql5')->table('vendorgstpanverify')->where([
                'vendorid' => $mm['vendorid'] ])->get();

            
            
        }
        else{
            return redirect('newvendor_home');
            //dd($res);
        }
           
        $attr = array();
        $attr['name_org'] = '';
        $attr['nameaspersap'] = $mm['vendorname'];

        if ($mm['mobilenumber'] == '') {
            if ($request->has('update_mobile_number')) {
                $attr['mob'] = $request->update_mobile_number;
            }
        }
        else{
            $verified_mobile = 2;
            $attr['mob'] = $mm['mobilenumber'];
        }

        if ($mm['emailid'] == '') {
            if ($request->has('update_email_address')) {
                $attr['email'] = $request->update_email_address;
            }
        }
        else{
            $verified_email = 2;
            $attr['email'] = $mm['emailid'];
        }
        
        
        
        $attr['register_proof'] = $request->registration_proof;
        $attr['register_proof_number'] = trim($request->registration_proof_number);
        if ($request->registration_proof == 'panno') {
            $attr['pan'] = strtoupper($request->registration_proof_number);
            $attr['gst_no'] = '';
            $attr['reg_proof_type'] = 'PAN';
        
        }
        
        if ($request->registration_proof == 'gstno') {
            $attr['pan'] = strtoupper(trim($request->registration_proof_number));
            $attr['gst_no'] = strtoupper(trim($request->registration_proof_number));
            $attr['reg_proof_type'] = 'GST';
        }
       


        if ($request->session()->has('getverifyemailverification')) {
            $emailverification = $request->session()->get('getverifyemailverification');
            $emailverify_decrypted = Crypt::decrypt($emailverification);
            if($emailverify_decrypted['emailid'] == $attr['email']){
                $verified_email += 1;
            }
            if($emailverify_decrypted['emailverified'] == 1){
                $verified_email += 1;
            }

        }



        if ($request->session()->has('getverifymobileverification')) {
            $mobileverification = $request->session()->get('getverifymobileverification');

            $mobileverify_decrypted = Crypt::decrypt($mobileverification);
            
            if($mobileverify_decrypted['mobilenumber'] == $attr['mob']){
                $verified_mobile += 1;
            }
            if($mobileverify_decrypted['mobileverified'] == 1){
                $verified_mobile += 1;
            }
        }

        



         

//dd($verified_email.'|'.$verified_mobile);
//dd($attr);


if (($verified_email == 2) && ($verified_mobile == 2) ) {
    //dd($attr);
    $request->session()->forget('getverifyemailverification');
    $request->session()->forget('getverifymobileverification');
    if($attr['register_proof'] == 'gstno'){
        $toverifypan = $attr['pan'];
        $decoded_resp = $this->gstverifywith_aadharkyc($attr['register_proof_number'],$attr['mob'],$attr['email']);
        if ($decoded_resp->status_code != 200) {
        $request->session()->flash("error_msg", "Invalid GST Number. Try with valid GST Number!");
    
               // $request->session()->forget('vendorregistrationotpdata');
                return redirect()->back()->withInput(); 
    }
    
    if ($decoded_resp->status_code == 200) {
         $attr['name_org'] = $decoded_resp->data->business_name;
         $attr['vcode'] = $vcode;
          $attr['vcodesess'] = $mm;
    }
    
    
    }
    
    if($attr['register_proof'] == 'panno'){
    
        $toverifypan = $attr['pan'];
    
    $decoded_resp = $this->panverifywith_aadharkyc($attr['register_proof_number'],$attr['mob'],$attr['email']);
    
    if ($decoded_resp->status_code != 200) {
        $request->session()->flash("error_msg", "PAN details not valid. Try with correct PAN Number!");
               // $request->session()->forget('vendorregistrationotpdata');
                return redirect()->back()->withInput(); 
    }
    
    if ($decoded_resp->status_code == 200) {
         $attr['name_org'] = $decoded_resp->data->full_name;
         $attr['vcode'] = $vcode;
          $attr['vcodesess'] = $mm;
    }
    
    }
    
    //dd($attr);
    if ($request->session()->has('getverifyauthorizedvendor')) {
        $request->session()->forget("getverifyauthorizedvendor");
    }
    
    //$attr['sess_expiry_time'] = Carbon::now()->addMinutes(10)->toDateTimeString();
    
   // $request->session()->put("getverifyauthorizedvendor", $attr);

    if ($attr['vcodesess']['mobilenumber'] == '') { $attr['mob'] = $attr['mob'];  }else{ $attr['mob'] = ''; }
    if ($attr['vcodesess']['emailid'] == '') { $attr['email'] = $attr['email'];    }else{ $attr['email'] = '';}
    
    DB::connection('mysql5')->table('vendorgstpanverify')->insert([
                'id' => null, 
                'vendorid' => $attr['vcodesess']['vendorid'],
                'current_vendorname_in_sap' => $attr['nameaspersap'],
                'opted_option' => $attr['register_proof'],
                'opted_value' => strtoupper($attr['register_proof_number']),
                'namefrom_govern' => $attr['name_org'],
                'mobno' => $attr['mob'],
                'emailid' => $attr['email'],
                'updatedtime' => Carbon::now()->toDateTimeString()
            ]);
    $request->session()->flash("suc_msg", "Vendor KYC updated Successfully.");
    return redirect()->route('getverifypangst', ['vcode' => $vcode]); 
}
else{
    $request->session()->flash("error_msg", "Vendor KYC update Failed. Try again!");
           // $request->session()->forget('vendorregistrationotpdata');
            return redirect()->back()->withInput();
}

        
        
       
        
        
    }


    public function getverifyverifiedvendorlogout(Request $request)
    {
        if ($request->session()->has('getverifyauthorizedvendor')) {

            $verifieddat = $request->session()->get("getverifyauthorizedvendor");
                
                $request->session()->forget("getverifyauthorizedvendor");

            return redirect()->route('getverifypangst',['vcode' => $verifieddat['vcode']]);
                
                //return redirect()->route('newvendor_home');
                }
                else{
                    return redirect()->route('newvendor_home');
                }
    }
    
    public function getverifyverifiedvendor(Request $request)
    {
        //dd($vcode);
        if ($request->session()->has('getverifyauthorizedvendor')) {


                $verifieddat = $request->session()->get("getverifyauthorizedvendor");
                //dd($verifieddat);

               
                
                return view('newvendorzone.getverifyverifiedvendor')->with(['sessdata' => $verifieddat]);
                }
                else{
                    return redirect()->route('newvendor_home');
                }
    }
    
    public function postgetverifyverifiedvendor(Request $request)
    {
        if ($request->session()->has('getverifyauthorizedvendor')) {
                $verifieddat = $request->session()->get("getverifyauthorizedvendor");
    
                $now = Carbon::now()->toDateTimeString();
                if (Carbon::parse($now)->gt(Carbon::parse($verifieddat['sess_expiry_time']))) {
                    $request->session()->forget("getverifyauthorizedvendor");
                    $request->session()->flash("error_msg", "Session Expired. Try again!");
               
                return redirect()->route('newvendor_home'); 
                }


                if ($verifieddat['vcodesess']['mobilenumber'] == '') {
                    
                    //$verifieddat['vcodesess']['vendorid']
                    $arrtochange = [];
                    $arrtochange['Vendor_ID'] = $verifieddat['vcodesess']['vendorid'];
                    $arrtochange['Field_Name'] = "MOBILE";
                    $arrtochange['Field_Value'] = $verifieddat['mob'];



                    $changeval = $this->vendor_detailsupdate($arrtochange);

                    if ($changeval['Status'] == 'Success') {
            
             $getipdetails = $this->getip($request);
                $arr111 = [];
                $arr111['Vendor_ID'] = $verifieddat['vcodesess']['vendorid'];
                $arr111['URL'] = $request->url();
                $arr111['IP_Address'] = $getipdetails['iprequested'];
                $arr111['From_Mobile'] = $getipdetails['ismobile'];
                $arr111['From_Desktop'] = $getipdetails['isdesktop'];
                $arr111['Time_Stamp'] = Carbon::now()->toDateTimeString();
               $arr111resp = $this->requestipsend_tosap($arr111);                    
                    
                DB::connection('mysql5')->table('vendor')->where(['id' => $verifieddat['vcodesess']['vendorid']])->update(['mobile' => $verifieddat['mob']]);
            }


                    //end

                }


                if ($verifieddat['vcodesess']['emailid'] == '') {
                    
                    //$verifieddat['vcodesess']['vendorid']
                    $arrtochange = [];
                    $arrtochange['Vendor_ID'] = $verifieddat['vcodesess']['vendorid'];
                    $arrtochange['Field_Name'] = "MAIL";
                    $arrtochange['Field_Value'] = $verifieddat['email'];



                    $changeval = $this->vendor_detailsupdate($arrtochange);

                    if ($changeval['Status'] == 'Success') {
            
             $getipdetails = $this->getip($request);
                $arr111 = [];
                $arr111['Vendor_ID'] = $verifieddat['vcodesess']['vendorid'];
                $arr111['URL'] = $request->url();
                $arr111['IP_Address'] = $getipdetails['iprequested'];
                $arr111['From_Mobile'] = $getipdetails['ismobile'];
                $arr111['From_Desktop'] = $getipdetails['isdesktop'];
                $arr111['Time_Stamp'] = Carbon::now()->toDateTimeString();
               $arr111resp = $this->requestipsend_tosap($arr111);                    
                    
                DB::connection('mysql5')->table('vendor')->where(['id' => $verifieddat['vcodesess']['vendorid']])->update(['email' => $verifieddat['email']]);
            }


                    //end

                }
                            

            DB::connection('mysql5')->table('vendorgstpanverify')->insert([
                'id' => null, 
                'vendorid' => $verifieddat['vcodesess']['vendorid'],
                'opted_option' => $verifieddat['register_proof'],
                'opted_value' => strtoupper($verifieddat['register_proof_number']),
                'namefrom_govern' => $verifieddat['name_org'],
                'mobno' => $verifieddat['mob'],
                'emailid' => $verifieddat['email'],
                'updatedtime' => Carbon::now()->toDateTimeString()
            ]);
    
                //$insert = $this->venRegDetails($verifieddat);
                
    //dd($verifieddat);
                
            
                $request->session()->flash("suc_msg", "Vendor KYC Successful.");
                
    
                $request->session()->forget("getverifyauthorizedvendor"); 
                return redirect()->route('getverifypangst',['vcode' => $verifieddat['vcode']]); 
            
           
    
                }
                else{
                    return redirect()->route('newvendor_home');
                }
    }

    public function postgetverifypangst1(Request $request, $vcode)
    {
        $dec1 = ($vcode - 1942) / 4 ;

        $regproof = $request->registration_proof;
        $regproofnumber = $request->registration_proof_number;
        $now = Carbon::now()->toDateTimeString();

        $arr = [];
        $arr['VEND_ID'] = $dec1;
        $arr['MOBILE_NO'] = '';
        $arr['E_MAIL'] = '';
        $res = $this->checkvendor($arr);

        $mm = [];
        if($res['NAME'] != "0"){
            $mm['vendorid'] = $res['VEND_ID'];
            $mm['vendorname'] = $res['NAME'];

            $checkdata = DB::connection('mysql5')->table('vendorgstpanverify')->where([
                'vendorid' => $mm['vendorid'] ])->get();

            if (count($checkdata) == 0) {
                DB::connection('mysql5')->table('vendorgstpanverify')->insert([
                'vendorid' => $mm['vendorid'], 'opted_option' => $regproof, 'opted_value' => $regproofnumber, 'updatedtime' => $now ]);
                session()->flash("suc_msg", "Successfully Submitted.");
                return redirect()->back();
            }
            else{
                session()->flash("error_msg", "Already data recorded. Thanks for your inputs.");
                return redirect()->back();
            }
        }
        else{
            return redirect('vendorregistration');
            
        }

        return redirect()->back();
    }


    public function invoiceattachment(Request $request){
        
        if ($request->session()->has('vendorsession')) {
           $encrypt = $request->session()->get('vendorsession');
           $decrypt = Crypt::decrypt($encrypt);
           $split = explode("-",$decrypt);
           $vendorid = $split[0];
           $getvendordata = DB::connection('mysql5')->table('vendor')->where('id', '=', $vendorid)->get();
            
             $listfiles = Storage::disk('s3')->files("/newcustomerzoneassets/vendorprofileimage/".$vendorid);
             $pwd_status = $this->is_didnt_passwordchanged($vendorid);

           if ($pwd_status == 0) {
               $request->session()->flash("error_msg", 'Please change the default password. Only if you Change the default password , other functionalities on this portal will work. This is done for security purposes. Please do not share your password with anyone');
               return redirect()->route('newvendor_mydetails_passchange');
           }
            
            if(count($listfiles) > 0){
               $profilepic = config('app.AWS_URL')."/".$listfiles[0];
           }
            else
            {
               $profilepic = config('app.AWS_URL')."/newcustomerzoneassets/img/dummy_male.png";
            }
            
            $res = $this->invoiceStatusTrait(trim($vendorid));
            // if(array_key_exists("0", $getrecentbids['BID_DETAILS']) === true)
            
            //if ($res != '') {
                if (array_key_exists('0', $res['Invoice_Status']) === true) {
                    $invoiceData = $res['Invoice_Status'];
                }
                else{
                    $invoiceData[0] = $res['Invoice_Status'];
                }
            //}
             //dd($invoiceData);
            // $plant_Name = DB::connection('mysql')->table('projectlist')->select('plantcode','Project_name')->get();
            $resp = $this->projectListTrait();
            // if ($resp != '') {
                if (array_key_exists('0', $resp['Project_List']) === true) {
                    $plant_Name = $resp['Project_List'];
                }
                else{
                    $plant_Name[0] = $resp['Project_List'];
                }
            // }
            //dd($plant_Name);
          
           return view('newvendorzone.invoiceattachment')->with(['getvendordata'=> $getvendordata,'profilepic' => $profilepic, 'invoicedata' => $invoiceData, 'projectlist'=>$plant_Name]);
       }
       else{
           return redirect()->route('newvendor_home');
       }
       
   }


   public function postinvoiceattachment(Request $request){
    if ($request->session()->has('vendorsession')) {
        $encrypt = $request->session()->get('vendorsession');
        $decrypt = Crypt::decrypt($encrypt);
        $split = explode("-",$decrypt);
        $vendorid = $split[0];
        $getvendordata = DB::connection('mysql5')->table('vendor')->where('id', '=', $vendorid)->get();

        $validate = $this->validate($request, [
            'plantname' => 'required',
            'ponumber' => 'required',
            'invoicenumber' => 'required',
            'attachment' => 'required',
        ]);
  
        $file = $request->file('attachment');
        $filename = $file->getClientOriginalName();
        $remove_space = str_replace(' ', '_', $filename);
        $filename_low = strtolower($remove_space);
        // $ext = pathinfo($filename, PATHINFO_EXTENSION);
        // dd($filename_low);
        $uploadeddatetime = date('Ymd');
        $randomno = rand(1, 1000000);
        $newname = bcrypt($uploadeddatetime.$randomno.'vendorinvoiceattachement');
        
        $uploaded = Storage::disk('s3')->putFileAs('/vendorinvoiceattachement/'.$vendorid, $request->file('attachment'), $filename_low);//$newname.'.'.$ext);
        if($uploaded){
            $invoiceData = $this->invoiceAttachmentTrait($request->plantname,$vendorid,$getvendordata[0]->Name,$request->ponumber,$request->invoicenumber,'https://cdn.vgn.in/vendorinvoiceattachement/'.$vendorid.'/'.$filename_low);
            //dd($invoiceData);
            if($invoiceData['Status'] == "SUCCESS"){
                $request->session()->flash("suc_msg", "successfully Updated the Attachment!!!");
                return redirect()->back(); 
            }else {
                $request->session()->flash("error_msg", "Attachment Failed. Try Again!");
                return redirect()->back(); 
            }   
        }
        else
        {
            $request->session()->flash("error_msg", "Attachment Failed. Try Again!");
            return redirect()->back();     
        }
         
     }else
     {
         return redirect()->route('newvendor_home');
     }

   }
}
