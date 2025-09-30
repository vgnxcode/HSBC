<?php

namespace vgn\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Crypt;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use DB;
use vgn\projectlist;
use vgn\Http\Traits\customertrait;
use Illuminate\Support\Facades\Log;

class BilldeskController extends Controller
{
    use customertrait;
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
    
    public function customerzoneonlinepayment(Request $request)
    {
      if ($request->session()->has('customersession')) {
        $encrypt = $request->session()->get('customersession');
        $decrypt = Crypt::decrypt($encrypt);
        //dd($decrypt);
        $split = explode("-",$decrypt);
        $customerid = $split[0];
       // dd($customerid);
        $pwd_status = $this->is_cust_didnt_passwordchanged($customerid);
            if ($pwd_status == 0) {
                $request->session()->flash("error_msg", 'Please Change the default Password!');
                return redirect()->route('newcustomer_mydetails_passchange');
            }

       $getcustomerdata = DB::connection('mysql3')->table('customer')->where('id', '=', $customerid)->get();
       $getblockdates = DB::connection('mysql3')->table('projects')->where('cust_id', '=', $customerid)->where('exp_date_of_compl', '!=', '')->get();
       $getproject = DB::connection('mysql3')->table('projects')->where('cust_id', '=', $customerid)->get();
         $listfiles = Storage::disk('s3')->files('/newcustomerzoneassets/customersprofileimage/'.$customerid);
	//dd($listfiles);
             if(count($listfiles) > 0){
                $profilepic = config('app.AWS_URL')."/".$listfiles[0];
            }
             else
             {
                $profilepic = config('app.AWS_URL')."/newcustomerzoneassets/img/dummy_male.png";
             }

         $getpaymentdata = [];
         if (isset($_REQUEST['appno'])) {
            $getpaymentdata = DB::connection('mysql3')->table('billdesk_payment')->where(['application_number' => $_REQUEST['appno'], 'customerid' => $customerid ])->get();
         }

         
         //dd($getcustomerdata);
        return view('newcustomerzone.billdeskrequest')->with(['getcustomerdata' => $getcustomerdata,'getproject' => $getproject, 'paymentres' => $getpaymentdata ,'profilepic' => $profilepic,'getblockdates' => $getblockdates]);
    }
        return view('newcustomerzone.login');
    }
    
    public function onlinepayment_response()
    {
        return redirect()->route('paymentpage');
    }

    public function getnetbalance(Request $request)
    {
        $plantcode = $request->plantcode;
        $unitcode = $request->unitcode;
        if ($request->session()->has('customersession')) {
            $encrypt = $request->session()->get('customersession');
            $decrypt = Crypt::decrypt($encrypt);
            //dd($decrypt);
            $split = explode("-",$decrypt);
            $customerid = $split[0];

        $getnetbalancedata = $this->getproject_netbalance($customerid);
        if (count($getnetbalancedata) > 0) {
            //dd($getnetbalancedata['PROJECT_DETAIL']);
            $projectdetails = [];
            if (array_key_exists('0', $getnetbalancedata['PROJECT_DETAIL']) === false) {
                $projectdetails[0] = $getnetbalancedata['PROJECT_DETAIL'];
            }
            else{
                $projectdetails = $getnetbalancedata['PROJECT_DETAIL'];
            }
            
            foreach ($projectdetails as $key => $value) {
                if (($value['PLANT'] == $plantcode) && ($value['UNIT'] == $unitcode)) {
			
			if(strpos($value['NET_BALANCE'],'-') !== false){
  return 0;
}
else{
  return $value['NET_BALANCE'];
}
                    return $value['NET_BALANCE'];
                }
            }

        }
        else{
            return -1;
        }
        

    }
    return -1;
    }


    public function postcustomerzoneonlinepayment(Request $request)
    {
        if ($request->session()->has('customersession')) {
            $encrypt = $request->session()->get('customersession');
            $decrypt = Crypt::decrypt($encrypt);
            //dd($decrypt);
            $split = explode("-",$decrypt);
            $customerid = $split[0];
           // dd($customerid);
    
           $getcustomerdata = DB::connection('mysql3')->table('customer')->where('id', '=', $customerid)->get();
           $getproject = DB::connection('mysql3')->table('projects')->where('cust_id', '=', $customerid)->get();
        if($request->GetRequestUri() == '/customerzone/payonline'){
            $regex = "/^(?=.+)(?:[1-9]\d*|0)?(?:\.\d+)?$/";
            $validate = $this->validate($request, [
                'project' => 'required',
                'unit' => 'required',
                'amount' => array('required','regex:'.$regex),
                ]);

                $plant_code = $request->project;
                $unitno = $request->unit;
                $amount = $request->amount;
                $payfor = $request->pay_for;

                $getnetbalancedata = $this->getproject_netbalance($customerid);
        if (count($getnetbalancedata) > 0) {
            //dd($getnetbalancedata['PROJECT_DETAIL']);
            $projectdetails = [];
            if (array_key_exists('0', $getnetbalancedata['PROJECT_DETAIL']) === false) {
                $projectdetails[0] = $getnetbalancedata['PROJECT_DETAIL'];
            }
            else{
                $projectdetails = $getnetbalancedata['PROJECT_DETAIL'];
            }
            
            foreach ($projectdetails as $key => $value) {
                if (($value['PLANT'] == $plant_code) && ($value['UNIT'] == $unitno)) {
                    $overall_netbalance = $value['NET_BALANCE'];
                }
            }

        }

        if ($overall_netbalance < 1) {
            $request->session()->flash("error_msg", "Sorry! Net Balance is 0, Please contact customer care!");
                 return redirect()->back();
        }
        if ($amount < 1) {
            $request->session()->flash("error_msg", "Please enter a valid amount to pay!");
                 return redirect()->back();
        }
                
                foreach ($getcustomerdata as $key => $value) {
                    $dbcustomerid = $value->id;
                    $dbcustomername = $value->name;
                    //$overall_netbalance = $value->net_amt;
                }

                foreach ($getproject as $key1 => $value1) {
                    if ($plant_code == $value1->project_id) {
                        $project_code = $value1->project_id;
                        $projectname = $value1->pname;
                        $unitname = $value1->unit_nm;
                        $unitcode = $value1->unit;
                    }
                    
                }
                
                
                $cdatetime = Carbon::now()->format('YmdHis');
                $application_number = $dbcustomerid.$cdatetime;
                $maintenance = $plant_code;
                if ($payfor == 'maintenance') {
                    $maintenance = 1111;
                    $msg_without_Checksum = "VGNPROPDEV|".$application_number."|NA|".$amount."|NA|NA|NA|INR|NA|R|vgnpropdev|NA|NA|F|".$dbcustomerid."|".$unitcode."|".$plant_code."|NA|NA|".$maintenance."|NA|https://www.vgn.in/api/customerzone/onlinepayment_response";
                }
                else{
                    $msg_without_Checksum = "VGNPROPDEV|".$application_number."|NA|".$amount."|NA|NA|NA|INR|NA|R|vgnpropdev|NA|NA|F|".$dbcustomerid."|".$unitcode."|".$maintenance."|NA|NA|".$plant_code."|NA|https://www.vgn.in/api/customerzone/onlinepayment_response";
                }


                //$plant_code = "4106";
                
                //$msg_without_Checksum = "VGNPROPDEV|".$application_number."|NA|".$amount."|NA|NA|NA|INR|NA|R|vgnpropdev|NA|NA|F|".$dbcustomerid."|".$unitcode."|NA|NA|NA|".$plant_code."|NA|https://vgn.in/api/customerzone/onlinepayment_response";
                $common_string="xtL0YYElSRoX";
                

                $checksum_hash = hash_hmac('sha256',$msg_without_Checksum,$common_string, false);
                $checksum = strtoupper($checksum_hash);
                
                $msg_with_Checksum = $msg_without_Checksum."|".$checksum;
                
                $insertacopy = DB::connection('mysql3')->table('billdesk_payment')->insert([
                    'id' => null,
                    'application_number' => $application_number,
                    'customerid' => $dbcustomerid,
                    'customername' => $dbcustomername,
                    'plant_code' => $project_code,
                    'plant_name' => $projectname,
                    'unit_code' => $unitcode,
                    'unit_name' => $unitname,
                    'ismaintenance' => $maintenance,
                    'app_created_datetime' => Carbon::now()->toDateTimeString(),
                    'project_net_balance' => $overall_netbalance,
                    'amount_paid' => $amount,
                    'applicationchecksum' => $checksum,
                    'sent_query' => $msg_with_Checksum,
                    'status' => null,
                    'billdesk_response' => null
                ]);

                $flashdata = [];
                $flashdata['postingurl'] = "https://pgi.billdesk.com/pgidsk/PGIMerchantPayment";
                $flashdata['postingval'] = $msg_with_Checksum;

                $request->session()->flash("posting_data", $flashdata);
                return redirect()->route('paymentredirectpage');
        }
        else{
            dd('not valid');
        }

    }
    return view('newcustomerzone.login');
}

public function getbanknames($code)
{
    $bankarray = ['ADB'=>'Andhra Bank',
    'AEC'=>'Amex Ezeclick',
    'ALB'=>'Allahabad Bank',
    'ALC'=>'Allahabad Bank Corporate',
    'AM2'=>'Amex Credit Card',
    'AM3'=>'Amex Credit Card',
    'AM6'=>'Amex Credit Card',
    'ATL'=>'Airtel Money',
    'AXC'=>'Axis Bank Corporate',
    'AXG'=>'Axis Credit Card',
    'AXIS'=>'Axis Bank',
    'BBC'=>'Bank of Baroda Corporate',
    'BBK'=>'Bank of Bahrain and Kuwait',
    'BBR'=>'Bank of Baroda Retail',
    'BCB'=>'Bassein Catholic Co-operative Bank',
    'BDN'=>'Bandhan Bank',
    'BEM'=>'Beam Cash Card',
    'BEW'=>'Beam Wallet',
    'BFL'=>'Bajaj Finance',
    'BJC'=>'Bill Junction',
    'BMB'=>'Bhartiya Mahila Bank Debit',
    'BMD'=>'Bank of Maharashatra  debit card',
    'BMN'=>'Bhartiya Mahila Bank',
    'BNP'=>'BNP Paribas',
    'BOI'=>'Bank of India',
    'BOM'=>'Bank of Maharashatra',
    'CBI'=>'Central Bank of India',
    'CC1'=>'CitiBank',
    'CC2'=>'Standard Chartered ESIC',
    'CDC'=>'CitiBank',
    'CH2'=>'HDFC Bank Corporate',
    'CIT'=>'CitiBank',
    'CMP'=>'CitiBank',
    'CMT'=>'CitiBank',
    'CNB'=>'CANARA BANK',
    'CND'=>'CANARA DEBIT CARD',
    'CNF'=>'CitiBank',
    'CNR'=>'CANARA BANK (BILLEFP)',
    'COB'=>'Cosmos Bank',
    'CPN'=>'Punjab National Bank Corporate ',
    'CR1'=>'Citrus pay',
    'CRP'=>'Corporation Bank',
    'CSB'=>'Catholic Syrian Bank',
    'CTR'=>'CTR - BOI Debit Card',
    'CUB'=>'City Union Bank',
    'CVM'=>'CITIBANK',
    'D12'=>'Digissential Wallet',
    'DBK'=>'Deutsche Bank',
    'DBS'=>'DIGI BANK',
    'DC2'=>'DCB Corporate Net Banking',
    'DCB'=>'Devlopment Credit Bank',
    'DEN'=>'Dena Bank',
    'DLB'=>'Dhanlaxmi bank',
    'DLC'=>'Dhanlaxmi bank corop',
    'EF1'=>'BOI EFT Payment',
    'EPG'=>'ICI Credit/ Debit Card',
    'FB1'=>'Federal Bank Corp',
    'FBK'=>'Federal Bank',
    'FRW'=>'Freecharge',
    'HCC'=>'HDFC Bank Credit/Debit',
    'HDF'=>'HDFC Bank netbanking',
    'HIT'=>'HERMES',
    'HMM'=>'HDFC Bank Credit/Debit',
    'HMP'=>'HDFC Bank Credit/Debit',
    'HMT'=>'HDFC Bank Credit/Debit',
    'IC2'=>'ICICI Debit card',
    'IC4'=>'ICI Unified Payment Interface System',
    'ICC'=>'I Cash CARD',
    'ICD'=>'ICICI Debit card',
    'ICI'=>'ICICI Netbanking',
    'ICM'=>'ICI Mobile banking',
    'ICO'=>'ICI Corporate Banking',
    'IDB'=>'IDBI Bank',
    'IDC'=>'IDBI Corporate',
    'IDD'=>'IndusdInd Bank Debit Card',
    'IDF'=>'IDFC Bank debit card',
    'IDM'=>'IDEA MONEY',
    'IDN'=>'IDFC Bank Netbanking',
    'IDS'=>'Indusind Bank',
    'INB'=>'Indian bank',
    'INC'=>'ING VYSYA BANK CORPORATE',
    'IND'=>'Indian bank debit card',
    'ING'=>'ING VYSYA BANK',
    'IOB'=>'IOB Debit card',
    'IOD'=>'indian overseas Bank',
    'IS2'=>'imps',
    'ITZ'=>'ITZ Cash Card',
    'JKB'=>'Jammu and Kashmir Bank Limited',
    'JNC'=>'Jana Cash',
    'JSB'=>'JANATA SAHAKARI BANK',
    'KBC'=>'Karnatala Bank Corporate',
    'KBL'=>'Karnatala Bank',
    'KGD'=>'Kerala Gramin Bank Debit Card',
    'KJB'=>'KALYAN JANATA BANK',
    'KTK'=>'Kotak Bank',
    'KVB'=>'Karur Vysya Bank Limited',
    'LVD'=>'Laxmi Vilas Debit Card',
    'LVR'=>'Laxmi Vilas bank',
    'MBK'=>'MobiKwik',
    'MKW'=>'MobiKwik',
    'MOM'=>'Money-on-Mobile',
    'MPC'=>'CITIBANK',
    'MRP'=>'Mrupee',
    'MSB'=>'MEHSANA BANK',
    'NKB'=>'North Kanara Gaud Saraswat Bank (NKGSB)',
    'OBC'=>'Orientel BANK OF commerce',
    'OLA'=>'OLA MONEY Wallet',
    'OXW'=>'Oxigen',
    'OXY'=>'Oxicash',
    'PCH'=>'PayCash',
    'PD2'=>'PNB Credit Card',
    'PDC'=>'Pnb Debit Card',
    'PIN'=>'Pinpoint',
    'PKD'=>'Pragathi krishna Bank Debit Card',
    'PMC'=>'Panjab & Maharastra Co-oprative Bank',
    'PMP'=>'PNB Debit Card',
    'PNB'=>'Punjab National Bank',
    'PNG'=>'PNB Card Gateway',
    'PNW'=>'Punjab National Bank Walllet',
    'PSB'=>'PUNJAB & SIND BANK',
    'PT2'=>'PATYM',
    'PTM'=>'Paytm',
    'PU1'=>'PAYU',
    'PZ1'=>'PayZapp',
    'RJM'=>'Reliance Jio money',
    'RPS'=>'Reliance payment services',
    'RTC'=>'Ratnakar Corporate Banking',
    'RTN'=>'Ratnakar Bank',
    'SBD'=>'Sbi Debit Card',
    'SBH'=>'STATE BANK OF HYDERABAD',
    'SBI'=>'STATE BANK OF INDIA',
    'SBJ'=>'STATE BANK OF BIKANER &JAIPUR',
    'SBM'=>'STATE BANK OF MYSORE',
    'SBP'=>'STATE BANK OF PATIALA',
    'SBT'=>'STATE BANK OF TRAVANCORE',
    'SBW'=>'SBI BUDDY',
    'SCB'=>'Standard Chartered netbanking',
    'SHD'=>'SHIVALIK BANK',
    'SIB'=>'South Indain Bank',
    'SM2'=>'Sbi Debit Card',
    'SM3'=>'Sbi Debit Card',
    'SMP'=>'SBI Card Gateway',
    'SND'=>'Sugal And Dhamani',
    'SPD'=>'SBI Card Gateway',
    'SPG'=>'SBI Card Gateway',
    'SV2'=>'Shamrao Vithal Bank Corporate',
    'SVC'=>'Shamrao Vithal Co-operative Bank Ltd.',
    'SVD'=>'Suvidha',
    'SWB'=>'Saraswat Bank',
    'SYD'=>'Syndicate Bank',
    'TJB'=>'TJSB (TJSB Sahakari Bank Ltd, Thane, India)',
    'TMB'=>'Tamilnad Mercantile Bank',
    'TMW'=>'The Mobile wallet',
    'TNC'=>'TNSC bank',
    'UBI'=>'Union Bank of India',
    'UCO'=>'UCO BANK',
    'UDC'=>'UBI Debit Card',
    'UNI'=>'UNITED BANK OF INDIA',
    'UPG'=>'UBI Credit/Debit card',
    'UR2'=>'Rupay Card',
    'URP'=>'UBI Rupay Gateway',
    'VJB'=>'Vijaya Bank',
    'VM3'=>'Vodafone Mpesa',
    'YBK'=>'YES BANK',
    'ZPG'=>'Zip Payment',
    'VA1'=>'Visa Access',
    'VH1'=>'Bharat QR code',
    'AXM'=>'Axis Credit Card',
    'SP2'=>'SBI Credit Card',
    'BD3'=>'BOB Debit Card',
    'EF9'=>'NEFT payment',
    'BD2'=>'BOB Debit Card',
    'UTI'=>'Axis Bank',
    'BPG'=>'Credit Card',
    'SBE'=>'SBI Emerald',
    'PNY'=>'PNB Yuva Netbanking',
    'AH1'=>'AH1 debit/Credit Card',
    'HC2'=>'HDFC Credit Card',
    'AM4'=>'American Express',
    'CN2'=>'Canara Bank Debit Card',
    'CDM'=>'CDM Credit Card',
    'CB4'=>'Central Bank of India UPI',
    'HD4'=>'HDFC UPI',
    'EF2'=>'EF2 Neft Payment',
    '162'=>'Kotak PG',
    'PNY'=>'PNB Yuva Netbanking',
    'BPR'=>'BOB Gateway',
    'EQB'=>'Equitas Bank',
    'HD3'=>'HDFC Debit Card',
    'MMP'=>'MMP Credit Card',
    'MPU'=>'MPU Credit Card',
    'RBL'=>'Ratnakar Bank',
    'HL1'=>'HDFC CDL Bank Account',
    'DCW'=>'DCB Wallet',
    'EP3'=>'EP3 Credit Card',
    'UP2'=>'UP2 Credit Card',
    'ATP'=>'Airtel Payments Bank',
    'BF1'=>'Bajaj FINSERV No Cost EMI',
    'CH3'=>'HDFC Bank Corporate',
    'HD2'=>'HDFC Debit Card',
    'HST'=>'HSBC Tax payment',
    'KLB'=>'Kalupur Cooperative Bank',
    'BP2'=>'BP2 Credit Card',
    'ADC'=>'Andhra Bank Corporate',
    'DL2'=>'Dhanalaxmi Bank Corporate',
    'YBW'=>'YES Bank Wallet',
    'CPI'=>'Chrome Pay',
    'CT4'=>'Unified Payment Interface',
    'LVC'=>'Lakshmi Vilas Bank Corporate',
    'HL3'=>'HDFC CDL',
    'AM8'=>'American Express',
    'BP3'=>'BP3 Credit Card',
    'AM7'=>'American Express',
    'TBB'=>'Thane Bharat Sahakari Bank',
    'PPL'=>'PayPal',
    'SRB'=>'Suryoday small finance bank',
    'HMX'=>'HMX - credit Card'];

    if (array_key_exists($code, $bankarray) === false) {
        return $code;
    }
    else{
        return $bankarray[$code];
    }
}

public function processonlinepayment(Request $request)
{
    if ($request->session()->has('posting_data')) {
        return view('newcustomerzone.billdeskredirectionpage');
    }
    else{
        return redirect()->route('paymentpage');
    }
}

        public function postcustomerzoneonlinepaymentresponse(Request $request)
        {

            if($_REQUEST['msg']){
                $msgdata = explode("|",$_REQUEST['msg']);

                $applicationnumber = $msgdata[1];
                $paymentrefid = $msgdata[2];
                $paymentdate =  $msgdata[13];
                $paymentamount =  ltrim($msgdata[4], '0');
                $ismaintenance =  $msgdata[18];
                $bankrefno = $msgdata[3];
                $bankidname = $msgdata[5];
                $bankmerchantid = $msgdata[6];
                $applicationpdate = Carbon::now()->toDateTimeString();
                $applicationpaymentreturncode =  $msgdata[14];
                $customerid = $msgdata[16];
                $paymenttype = $msgdata[22];
                $applicationpaymentremarks = $msgdata[24];
                $responsechecksum = $msgdata[25];
                $common_string="xtL0YYElSRoX";
                $mm = '';
                foreach ($msgdata as $key3 => $value3) {
                    if ($key3 != 25) {
                        $mm .= $value3.'|';
                    }
                }
                $msg_without_Checksum = substr($mm,0,-1);

                $bankidname = $this->getbanknames($bankidname);
                                

                $checksum_hash = hash_hmac('sha256',$msg_without_Checksum,$common_string, false);
                $checksum = strtoupper($checksum_hash);

                if ($applicationpaymentreturncode == '0300') {
                    $paymentstatus = 1;
                }
                else{
                    $paymentstatus = -1;
                }
                
                if($responsechecksum == $checksum){
                    
                    $updatequery = DB::connection('mysql3')->table('billdesk_payment')->where([
                        'application_number' => $applicationnumber
                    ])->update([
                        'status' => $paymentstatus,
                        'billdesk_response' => $_REQUEST['msg'],
                        'payment_referenceid' => $paymentrefid,
                        'paymentdatetime' => $paymentdate,
                        'paymentamount' => $paymentamount,
                        'payment_code' => $applicationpaymentreturncode,
                        'payment_description' => $applicationpaymentremarks,
                        'responsechecksum' => $responsechecksum
                    ]);

                $flashdata = [];
                
                $flashdata['appno'] = $applicationnumber;
                $flashdata['refno'] = $paymentrefid;
                $flashdata['description'] = $applicationpaymentremarks;
                
                        

                        if ($applicationpaymentreturncode == '0300') {
                            $flashdata['status'] = 'success';
                        }
                        else{
                            $flashdata['status'] = 'failure';
                        }

                        $tosapdetails = [];
                        $tosapdetails['Transaction_Date'] = $paymentdate;
                        $tosapdetails['Customer_ID'] = $customerid;
                        $tosapdetails['VGN_Application_No'] = $applicationnumber;
                        $tosapdetails['Bank_Merchant_ID'] = $bankmerchantid;
                        $tosapdetails['Bank_Name'] = $bankidname;
                        $tosapdetails['Bank_Reference_No'] = $bankrefno;
                                                
                        $getdata = DB::connection('mysql3')->table('billdesk_payment')->where(['application_number' => $applicationnumber])->get();
                        foreach ($getdata as $key3 => $value3) {
                            $tosapdetails['Customer_Name'] = $value3->customername;
                            $tosapdetails['Plant'] = $value3->plant_code;
                            if ($value3->ismaintenance == '1111') {
                    
                                $tosapdetails['Maintenance'] = 'X';
                            }
                            else{
                                
                                $tosapdetails['Maintenance'] = '';
                            }
                            $tosapdetails['Plant_Description'] = $value3->plant_name;
                            $tosapdetails['Amount'] = $paymentamount;
                            $tosapdetails['Payment_Status'] = $applicationpaymentreturncode;
                            $tosapdetails['Unit_No'] = $value3->unit_name;
                            $tosapdetails['Reference_ID'] = $paymentrefid;
                            $tosapdetails['Summary'] = $applicationpaymentremarks;
                            
                        }
                        

                        
						Log::info('Response From Billdesk = '.serialize($tosapdetails));
						
						$sendtosap = $this->send_billdesk_transactiontosap($tosapdetails);
                        Log::info('Response From SAP Billdesk Posting = '.serialize($sendtosap));
						
                        //$request->session()->flash("response_data", $flashdata);

                    echo "<center><strong>Just a moment...! You are being redirected to application site.</strong></center>";
                    echo "<center>[Please do not close/refresh this window]</center>";
                    echo "<center><img src='/images/formloader.gif' alt='loading' width='75'></center>";
                    echo '<script>window.history.forward(0);setTimeout(function(){ window.location.href="https://vgn.in/customerzone/payonline?appno='.$applicationnumber.'"; }, 2000);</script>';

                        die();
                        exit();
                        

                        //return redirect()->route('paymentpage');
                    

                }
                else{
                    return redirect()->route('paymentpage');
                }

            }
            else{
                return redirect()->route('paymentpage');
            }
           
        }


        public function responseonlineredirectpage(Request $request)
        {
            if ($request->session()->has('response_data')) {
                return redirect()->route('responseonlineredirectpage');
            }
            else{
                return redirect()->route('paymentpage');
            }
        }


        public function showonlinepaymentresult(Request $request)
        {
            if(!empty($request->appno)){

                dd($request->appno);
            }
            else{
                dd('no data');
            }
        }
	
	 public function billdesserverkquery()
        {
               
    
        $getemptyresponsefrom_billdesk = DB::connection('mysql3')->table('billdesk_payment')->where('billdesk_response','=',null)->get();
        //dd($getemptyresponsefrom_billdesk);
        if(count($getemptyresponsefrom_billdesk) > 0){
            $new = [];
            foreach($getemptyresponsefrom_billdesk as $key=>$value){
                $common_string="xtL0YYElSRoX";
                $remove_special_str1 = str_replace('-','',$value->app_created_datetime);
                $remove_special_str2 = str_replace(':','',$remove_special_str1);
                $remove_special_str3 = str_replace(' ','',$remove_special_str2);
                
                $msg_without_Checksum = '0122|VGNPROPDEV|'.$value->application_number.'|'.$remove_special_str3;
                $checksum_hash = hash_hmac('sha256',$msg_without_Checksum,$common_string, false);
                $checksum = strtoupper($checksum_hash);
                
                $msg_with_checksum = $msg_without_Checksum.'|'.$checksum;
                $msg_string = "msg=".$msg_with_checksum;
                //dd($msg_with_checksum);
                $postingurl = "https://www.billdesk.com/pgidsk/PGIQueryController";
                
                
  $post_do = curl_init();
  curl_setopt($post_do, CURLOPT_URL, "$postingurl" );
  curl_setopt($post_do, CURLOPT_RETURNTRANSFER, true );  
  curl_setopt($post_do, CURLOPT_POST,           true );
  curl_setopt($post_do, CURLOPT_POSTFIELDS,     $msg_string);
 $exec = curl_exec($post_do);

 //dd($exec);
   if($exec === false) {
    $err = 'Curl error: ' . curl_error($post_do);
    curl_close($post_do);
    print $err;
    //dd(false);
  } else {
    curl_close($post_do);


        $msgdata = explode("|",$exec);
        
        
                $applicationnumber = $msgdata[2];
                $paymentrefid = $msgdata[3];
                $paymentdate =  $msgdata[14];
                $paymentamount =  ltrim($msgdata[5], '0');
                $ismaintenance =  $msgdata[22];

                $bankrefno = $msgdata[3];
                $bankidname = $msgdata[6];
                $bankmerchantid = $msgdata[7];
                $applicationpdate = Carbon::now()->toDateTimeString();
                $applicationpaymentreturncode =  $msgdata[15];
                $customerid = $msgdata[17];
                $paymenttype = $msgdata[23];
                $applicationpaymentremarks = $msgdata[25];
                $responsechecksum = $msgdata[32];

                //start

                $common_string="xtL0YYElSRoX";
                $mm = '';
                foreach ($msgdata as $key3 => $value3) {
                    if ($key3 != 32) {
                        $mm .= $value3.'|';
                    }
                }
                $msg_without_Checksum = substr($mm,0,-1);

                $bankidname = $this->getbanknames($bankidname);
                                

                $checksum_hash = hash_hmac('sha256',$msg_without_Checksum,$common_string, false);
                $checksum = strtoupper($checksum_hash);

                if ($applicationpaymentreturncode == '0300') {
                    $paymentstatus = 1;
                }
                else{
                    $paymentstatus = -1;
                }

                //echo $responsechecksum.'<br>';
                //dd($checksum);
                
                if($responsechecksum == $checksum){
                    
                    $updatequery = DB::connection('mysql3')->table('billdesk_payment')->where([
                        'application_number' => $applicationnumber
                    ])->update([
                        'status' => $paymentstatus,
                        'billdesk_response' => $exec,
                        'payment_referenceid' => $paymentrefid,
                        'paymentdatetime' => $paymentdate,
                        'paymentamount' => $paymentamount,
                        'payment_code' => $applicationpaymentreturncode,
                        'payment_description' => $applicationpaymentremarks,
                        'responsechecksum' => $responsechecksum
                    ]);

                $flashdata = [];
                
                $flashdata['appno'] = $applicationnumber;
                $flashdata['refno'] = $paymentrefid;
                $flashdata['description'] = $applicationpaymentremarks;
                
                        

                        if ($applicationpaymentreturncode == '0300') {
                            $flashdata['status'] = 'success';
                        }
                        else{
                            $flashdata['status'] = 'failure';
                        }

                        $tosapdetails = [];
                        //$tosapdetails['Transaction_Date'] = $paymentdate;
                        $tosapdetails['Transaction_Date'] = Carbon::now()->format('d-m-Y');

                        $tosapdetails['Customer_ID'] = $customerid;
                        $tosapdetails['VGN_Application_No'] = $applicationnumber;
                        $tosapdetails['Bank_Merchant_ID'] = $bankmerchantid;
                        $tosapdetails['Bank_Name'] = $bankidname;
                        $tosapdetails['Bank_Reference_No'] = $bankrefno;
                                                
                        $getdata = DB::connection('mysql3')->table('billdesk_payment')->where(['application_number' => $applicationnumber])->get();
                        foreach ($getdata as $key3 => $value3) {
                            $tosapdetails['Customer_Name'] = $value3->customername;
                            $tosapdetails['Plant'] = $value3->plant_code;
                            if ($value3->ismaintenance == '1111') {
                    
                                $tosapdetails['Maintenance'] = 'X';
                            }
                            else{
                                
                                $tosapdetails['Maintenance'] = '';
                            }
                            $tosapdetails['Plant_Description'] = $value3->plant_name;
                            $tosapdetails['Amount'] = $paymentamount;
                            $tosapdetails['Payment_Status'] = $applicationpaymentreturncode;
                            $tosapdetails['Unit_No'] = $value3->unit_name;
                            $tosapdetails['Reference_ID'] = $paymentrefid;
                            $tosapdetails['Summary'] = $applicationpaymentremarks;
                            
                        }

                        if ($applicationpaymentreturncode == '0300') {

                        Log::info('Response From Billdesk = '.serialize($tosapdetails));
                        
                        $sendtosap = $this->send_billdesk_transactiontosap($tosapdetails);
                        Log::info('Response From SAP Billdesk Posting = '.serialize($sendtosap));
                        }
                    }

                //end

       
       //echo $exec.'<br>';
   }
                
                
                
            }
        
        }
        else{
            dd('No Data to process!');
        }

        }


 public function paymentlink1home(Request $request, $shortcode)
    {
        //dd($shortcode);
        $getcode = DB::connection('mysql3')->table('paymentlinks')->where(['shortcode' => $shortcode])->get();
        if (count($getcode) == 0) {
         
            return redirect()->route('newcustomer_home');
        }

        //dd($getcode);

        foreach ($getcode as $key1 => $value1) {
            $amt = $value1->amount;
            $ptype = $value1->payment_type;
            $outstandingbal = $value1->Outstanding_Balance;
            if ($ptype == 'Others') {
                $ptype = 'Flat/Plot Payment';
            }
            if ($ptype == 'Maintenance') {
                $ptype = 'Maintenance Payment';
            }
        }

        if(strpos($amt,'-') !== false){
            $amt = 0;
            return redirect()->route('newcustomer_home');
        }

        if(strpos($outstandingbal,'-') !== false){
            $outstandingbal = 0;
        }

        if ($amt == 0) {
            return redirect()->route('newcustomer_home');
        }

        return view('newcustomerzone.paymentlink1home')->with(['shortcode' => $shortcode, 'getcodedata' => $getcode, 'ptype' => $ptype, 'outstandingbal' => $outstandingbal]);
    }


    public function paymentlink1(Request $request, $shortcode)
    {
        if (!empty($shortcode) && !empty($request->enteramount)) {

            $enteramount = trim($request->enteramount);


            $getcode = DB::connection('mysql3')->table('paymentlinks')->where(['shortcode' => $shortcode])->get();

            if (count($getcode) == 1) {
                foreach ($getcode as $key => $value) {

                    $pamount = $value->amount;

                    if(strpos($pamount,'-') !== false){
                        $pamount = 0;
                        return redirect()->route('newcustomer_home');
                        }

                    if ($pamount == 0) {
                        return redirect()->route('newcustomer_home');
                    }

                    if ($enteramount < $pamount) {
                        $request->session()->flash("error_msg", "Amount should not be less than Invoice amount!");
                        return redirect()->back()->withInput();   
                    }

                    $enteramount = (float) $enteramount;

                    $cdatetime = Carbon::now()->format('YmdHis');
                    $randval = rand(111,999);
                $application_number = $value->customerid.$cdatetime.$randval;
                $maintenance = $value->plantcode;
                if ($value->payment_type == 'Maintenance') {
                    $maintenance = 1111;
                    $msg_without_Checksum = "VGNPROJEST|".$application_number."|NA|".$enteramount."|NA|NA|NA|INR|NA|R|vgnprojest|NA|NA|F|".$value->customerid."|".$value->unit_no."|".$value->plantcode."|NA|NA|".$maintenance."|NA|https://www.vgn.in/bps_response?appno=$application_number";
                }
                else{
                    $msg_without_Checksum = "VGNPROJEST|".$application_number."|NA|".$enteramount."|NA|NA|NA|INR|NA|R|vgnprojest|NA|NA|F|".$value->customerid."|".$value->unit_no."|".$maintenance."|NA|NA|".$value->plantcode."|NA|https://www.vgn.in/bps_response?appno=$application_number";
                }

                $common_string="u2cXEYh9hWS6BNscexutXiMYUCH7vbW2";

                $checksum_hash = hash_hmac('sha256',$msg_without_Checksum,$common_string, false);
                $checksum = strtoupper($checksum_hash);
                
                $msg_with_Checksum = $msg_without_Checksum."|".$checksum;
                
                $insertacopy = DB::connection('mysql3')->table('paymentlink_billdesk_payment')->insert([
                    'id' => null,
                    'application_number' => $application_number,
                    'customerid' => $value->customerid,
                    'shortlink' => $shortcode,
                    'customername' => $value->name,
                    'plant_code' => $value->plantcode,
                    'plant_name' => $value->plantname,
                    'unit_code' => $value->unit_no,
                    'unit_name' => $value->unit_desc,
                    'ismaintenance' => $maintenance,
                    'app_created_datetime' => Carbon::now()->toDateTimeString(),
                    'amount_paid' => $value->amount,
                    'applicationchecksum' => $checksum,
                    'sent_query' => $msg_with_Checksum,
                    'status' => null,
                    'billdesk_response' => null
                ]);

                    

                $flashdata = [];
                $flashdata['postingurl'] = "https://pgi.billdesk.com/pgidsk/PGIMerchantPayment";
                $flashdata['postingval'] = $msg_with_Checksum;
                //dd($flashdata);
                $request->session()->flash("paymentlinkbilldesk_posting_data", $flashdata);
                return view('newcustomerzone.paymentlink1')->with(['shortcode' => $shortcode]);
                    
                    //dd($appid);
                }
            }
        }
        else{
            return redirect()->route('newcustomer_home');
        }
    }

    

    public function postbps_response()
    {
        if($_REQUEST['msg']){
                $msgdata = explode("|",$_REQUEST['msg']);

                $applicationnumber = $msgdata[1];
                $paymentrefid = $msgdata[2];
                $paymentdate =  $msgdata[13];
                $paymentamount =  ltrim($msgdata[4], '0');
                $ismaintenance =  $msgdata[18];
                $bankrefno = $msgdata[3];
                $bankidname = $msgdata[5];
                $bankmerchantid = $msgdata[6];
                $applicationpdate = Carbon::now()->toDateTimeString();
                $applicationpaymentreturncode =  $msgdata[14];
                $customerid = $msgdata[16];
                $paymenttype = $msgdata[22];
                $applicationpaymentremarks = $msgdata[24];
                $responsechecksum = $msgdata[25];
                $common_string="u2cXEYh9hWS6BNscexutXiMYUCH7vbW2";
                $mm = '';
                foreach ($msgdata as $key3 => $value3) {
                    if ($key3 != 25) {
                        $mm .= $value3.'|';
                    }
                }
                $msg_without_Checksum = substr($mm,0,-1);

                $bankidname = $this->getbanknames($bankidname);
                                

                $checksum_hash = hash_hmac('sha256',$msg_without_Checksum,$common_string, false);
                $checksum = strtoupper($checksum_hash);

                if ($applicationpaymentreturncode == '0300') {
                    $paymentstatus = 1;
                }
                else{
                    $paymentstatus = -1;
                }
                
                if($responsechecksum == $checksum){
                    
                    $updatequery = DB::connection('mysql3')->table('paymentlink_billdesk_payment')->where([
                        'application_number' => $applicationnumber
                    ])->update([
                        'status' => $paymentstatus,
                        'billdesk_response' => $_REQUEST['msg'],
                        'payment_referenceid' => $paymentrefid,
                        'paymentdatetime' => $paymentdate,
                        'paymentamount' => $paymentamount,
                        'payment_code' => $applicationpaymentreturncode,
                        'payment_description' => $applicationpaymentremarks,
                        'responsechecksum' => $responsechecksum
                    ]);

                $flashdata = [];
                
                $flashdata['appno'] = $applicationnumber;
                $flashdata['refno'] = $paymentrefid;
                $flashdata['description'] = $applicationpaymentremarks;
                
                        

                        if ($applicationpaymentreturncode == '0300') {
                            $flashdata['status'] = 'success';
                        }
                        else{
                            $flashdata['status'] = 'failure';
                        }

                        $tosapdetails = [];
                        $tosapdetails['Transaction_Date'] = $paymentdate;
                        $tosapdetails['Customer_ID'] = $customerid;
                        $tosapdetails['VGN_Application_No'] = $applicationnumber;
                        $tosapdetails['Bank_Merchant_ID'] = $bankmerchantid;
                        $tosapdetails['Bank_Name'] = $bankidname;
                        $tosapdetails['Bank_Reference_No'] = $bankrefno;
                                                
                        $getdata = DB::connection('mysql3')->table('paymentlink_billdesk_payment')->where(['application_number' => $applicationnumber])->get();
                        foreach ($getdata as $key3 => $value3) {
                            $tosapdetails['Customer_Name'] = $value3->customername;
                            $tosapdetails['Plant'] = $value3->plant_code;
                            if ($value3->ismaintenance == '1111') {
                    
                                $tosapdetails['Maintenance'] = 'X';
                            }
                            else{
                                
                                $tosapdetails['Maintenance'] = '';
                            }
                            $tosapdetails['Plant_Description'] = $value3->plant_name;
                            $tosapdetails['Amount'] = $paymentamount;
                            $tosapdetails['Payment_Status'] = $applicationpaymentreturncode;
                            $tosapdetails['Unit_No'] = $value3->unit_name;
                            $tosapdetails['Reference_ID'] = $paymentrefid;
                            $tosapdetails['Summary'] = $applicationpaymentremarks;
                            
                        }
                        

                        
                        Log::info('Response From Payment link Billdesk = '.serialize($tosapdetails));
                        
                        $sendtosap = $this->send_billdesk_transactiontosap($tosapdetails);
                        Log::info('Response From SAP Billdesk Posting = '.serialize($sendtosap));
                        
                        //$request->session()->flash("response_data", $flashdata);
                        
                    echo "<center><strong>Just a moment...! You are being redirected to application site.</strong></center>";
                    echo "<center>[Please do not close/refresh this window]</center>";
                    echo "<center><img src='/images/formloader.gif' alt='loading' width='75'></center>";
                    echo '<script>window.history.forward(0);setTimeout(function(){ window.location.href="https://www.vgn.in/bps_response?appno='.$applicationnumber.'"; }, 2000);</script>';

                        die();
                        exit();
                        

                        //return redirect()->route('paymentpage');
                    

                }
                else{
                    return redirect()->route('newcustomer_home');
                }

            }
            else{
                return redirect()->route('newcustomer_home');
            }
    }


    public function bps_response()
    {

        $appid = trim($_REQUEST['appno']);

        if (ctype_digit($appid)) {
        
      //dd($appid);

         $getpaymentdata = [];
         if ($appid != '') {
            $getpaymentdata = DB::connection('mysql3')->table('paymentlink_billdesk_payment')->where(['application_number' => $appid ])->get();
         }
         else{
            return redirect()->route('newcustomer_home');
         }

         if (count($getpaymentdata) == 0) {
             return redirect()->route('newcustomer_home');
         }
         
         //dd($getpaymentdata);
        return view('newcustomerzone.paymentlink2')->with([ 'paymentres' => $getpaymentdata ]);
    }
    else{
        return redirect()->route('newcustomer_home');
    }
    
    }

    public function newgeneratepaymentlink()
    {



        $check_gen_paymentlink = $this->check_gen_paymentlink();
        //dd($check_gen_paymentlink);

        //$resp = json_encode($request->all());
       // Log::info('Billdesk payment link request '.json_encode($resp));
        //$mainres1 = json_decode($resp,true);

        $mainresv = $check_gen_paymentlink['Details'];

        $mmv = [];
        if (array_key_exists('0', $mainresv)) {
            $mmv = $mainresv;
        }
        else{
            $mmv[0] = $mainresv;
        }
        //dd($mmv);

        if (count($mmv) > 0) {
            
        foreach ($mmv as $keyv => $mainres) {
            
            //dd($mainres);


                $customerid = $mainres['Customer_ID'];
                $customername = $mainres['Customer_Name'];
                $amount = $mainres['Amount'];
                $plantcode = $mainres['Plant_Code'];
                
                $paymenttype = $mainres['Payment_Type'];
                $plant_name = $mainres['Plant_Name'];
                //$unitname = $mainres['Unit_Description'];
                $outstandingbal = $mainres['Outstanding_Balance'];

		if (array_key_exists('Timestamp', $mainres)) {
                    $ttkey = explode('_', $mainres['Timestamp']);
                }
                else{
                    $ttkey = 0;
                }


		if (array_key_exists('Unit_No', $mainres)) {
                    $unitttkey = $mainres['Unit_No'];
                }
                else{
                    $unitttkey = 0;
                }

		 if (array_key_exists('Unit_Description', $mainres)) {
                    $unitttdesc = $mainres['Unit_Description'];
                }
                else{
                    $unitttdesc = 0;
                }

                //dd($ttkey[0]);
                
                //dd($customerid);

                if(strpos($outstandingbal,'-') !== false){
                    $outstandingbal = 0;
                }

                if ($customerid != 0) {
                    
                

                $seed = str_split('abcdefghijklmnopqrstuvwxyz'
                     .'ABCDEFGHIJKLMNOPQRSTUVWXYZ'
                     .'0123456789'); // and any other characters
    shuffle($seed); // probably optional since array_is randomized; this may be redundant
    $rand = '';
    foreach (array_rand($seed, 5) as $k) $rand .= $seed[$k];
 
    $shortlink = $rand.rand(111,999999);


                $getcheck = DB::connection('mysql3')->table('paymentlinks')->where([
        'customerid' => $customerid,
        'name' => $customername,
        'plantcode' => $plantcode,
        'plantname' => $plant_name,
        'unit_no' => $unitttkey,
        'unit_desc' => $unitttdesc,
        'amount' => $amount,
        'payment_type' => $paymenttype,
        'key_data' => $ttkey[0]
    ])->get();


                if (count($getcheck) == 0) {
                    $arr = [];
                    $arr['Customer_ID'] = $customerid;
                    $arr['Plant_Code'] = $plantcode;
                    $arr['Unit_No'] = $unitttkey;
                    $arr['Amount'] = $amount;
                    $arr['Payment_Type'] = $paymenttype;
                    $arr['Timestamp'] = $mainres['Timestamp'];
                    $arr['Link'] = "https://www.vgn.in/bps/$shortlink";
                    $arr['Status_Code'] = 200;
                    $arr['Message'] = "Link generated";

                   $sendtosap = $this->postcheck_gen_paymentlinkdata($arr);
                   //dd($sendtosap);

                   if ($sendtosap['Status'] == 'Success') {
                    
                   
                
                $insertacopy = DB::connection('mysql3')->table('paymentlinks')->insert([
                    'id' => null,
                    'shortcode' => $shortlink,
                    'customerid' => $customerid,
                    'name' => $customername,
                    'plantcode' => $plantcode,
                    'plantname' => $plant_name,
                    'unit_no' => $unitttkey,
                    'unit_desc' => $unitttdesc,
                    'amount' => trim($amount),
                    'payment_type' => $paymenttype,
                    'Outstanding_Balance' => $outstandingbal,
                    'key_data' => $ttkey[0],
                    'created_time' => Carbon::now()->toDateTimeString(),
                    'clicked_count' => 0
                ]);

            }
               
                
                //return json_encode(['LINK' => "https://www.vgn.in/bps/$shortlink",'STATUS_CODE' => 200, 'MESSAGE' => 'Link generated']);
            }
            else{


                foreach ($getcheck as $key1 => $value1) {
                    $shlink = $value1->shortcode;


                    $arr = [];
                    $arr['Customer_ID'] = $customerid;
                    $arr['Plant_Code'] = $plantcode;
                    $arr['Unit_No'] = $unitttkey;
                    $arr['Amount'] = $amount;
                    $arr['Payment_Type'] = $paymenttype;
                    $arr['Timestamp'] = $mainres['Timestamp'];
                    $arr['Link'] = "https://www.vgn.in/bps/$shlink";
                    $arr['Status_Code'] = 200;
                    $arr['Message'] = "Link generated";
                    
                   $sendtosap = $this->postcheck_gen_paymentlinkdata($arr);


                }
                //return json_encode(['LINK' => "https://www.vgn.in/bps/$shlink",'STATUS_CODE' => 404, 'MESSAGE' => 'Already Link generated']);
            }

            }
            }
        }
        else{
            return json_encode(['LINK' => "",'STATUS_CODE' => 400, 'MESSAGE' => 'No Data']);
        }

        dd('Completed');
    }
        
}
