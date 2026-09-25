<?php

namespace vgn\Http\Controllers;
use vgn\hsbc_api_hit;
use vgn\HsbcUser;
use vgn\SliceHit;
use Illuminate\Http\Request;
use vgn\Http\Traits\hsbctrait;
use Response;
use Session;
use Crypt;
use Carbon\Carbon;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class HSBCController extends Controller
{
	use hsbctrait;

    //login moduel 

    // public function hsbclogin(Request $request)
    // {
    //     /*
    //     |--------------------------------------------------------------------------
    //     | Validate Request
    //     |--------------------------------------------------------------------------
    //     */
    //     $validator = Validator::make($request->all(), [
    //         'emp_id'   => 'required|digits:6',
    //         'password' => 'required|min:5',
    //     ], [
    //         'emp_id.required' => 'Employee ID is required',
    //         'emp_id.digits'   => 'Employee ID must be exactly 6 digits',
    //         'password.required' => 'Password is required',
    //     ]);

    //     if ($validator->fails()) {
    //         return back()
    //             ->withErrors($validator)
    //             ->withInput();
    //     }
    // }

    public function hsbclogin(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);



    $user = HsbcUser::where('email', $request->email)->first();

    if (!$user) {
        return back()->with('error', 'Invalid email or password.');
    }

    if (!Hash::check($request->password, $user->password)) {
        return back()->with('error', 'Invalid email or password.');
    }

    // Login successful
    $request->session()->regenerate();

    $request->session()->put('hsbc_logged_in', true);
    $request->session()->put('hsbcuser_id', $user->id);
    $request->session()->put('hsbcuser_emp_id', $user->emp_id);
    $request->session()->put('hsbcuser_email', $user->email);
     $request->session()->put('hsbcuser_name', $user->name);

    return redirect('/api/hsbc/hsbcfinalupdate_table');
}


public function hsbclogout(Request $request)
{
    $request->session()->forget([
        'hsbc_logged_in',
        'hsbcuser_id',
        'hsbcuser_emp_id',
        'hsbcuser_email',
        'hsbcuser_name',
    ]);

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('home');
}

public function hsbcprofile()
{
        $data = HsbcUser::orderBy('id', 'desc')->get();  
        return view('HSBC.profile')->with('data', $data);
}



public function update(Request $request, $id)
{
    $user = HsbcUser::findOrFail($id);

    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'emp_id' => 'required|string|max:100',
        'email' => 'required|email|max:255',
        'password' => 'nullable|string|min:6',
    ]);

    $user->name = $validated['name'];
    $user->emp_id = $validated['emp_id'];
    $user->email = $validated['email'];

    // Update password only if a new password is entered
    if (!empty($validated['password'])) {
        $user->password = Hash::make($validated['password']);
    }

    $user->save();

    return redirect()->back()->with('success', 'Employee details updated successfully.');
}



// public function hsbcpayment_quee()
// {


//         $getsapdata1 = [];
//         $getsapdata2 = [];

//         $getsapdata = $this->step1hsbcprocess();
//     	if (array_key_exists('Beneficiary_Details', $getsapdata)) {
//     		$getsapdata1 = $getsapdata['Beneficiary_Details'];
//               // Skip first 58 payments
//             $getsapdata1 = array_slice($getsapdata1, 58);
//     		if (array_key_exists(0, $getsapdata1) === false) {
//     			$getsapdata2[0] = $getsapdata1;
//     		}
//             else{
//                 $getsapdata2 = $getsapdata1;
//             }

//             dd($getsapdata2);

//               return view('HSBC.hsbcpayment_quee')->with(['toprocess' => $getsapdata2]);
//         }


// }



// public function hsbcpayment_quee()
// {
//     $getsapdata1 = [];
//     $getsapdata2 = [];

//     $getsapdata = $this->step1hsbcprocess();

//  $getsapdat0a = collect($getsapdata)
//     ->flatten(1)
//     ->sortBy(function ($item) {

//         $messageId = $item['Message_Id'] ?? '';

//         // Extract YYYYMMDDHHMMSS from Message_Id
//         preg_match('/(20\d{12})/', $messageId, $matches);

//         return $matches[1] ?? '99999999999999';
//     })
//     ->values()
//     ->toArray();

//    // dd($getsapdat0a);

//     if (array_key_exists('Beneficiary_Details', $getsapdat0a)) {

//         $getsapdata1 = $getsapdat0a['Beneficiary_Details'];

//         // Skip 
//         $skip = SliceHit::value('SliceHit');
//        $getsapdata1 = array_slice($getsapdata1, $skip);
//        // $getsapdata1 = array_slice($getsapdata1, 0, 0);
//         dd($getsapdata1);

//         // Check whether payment data exists
//         if (!empty($getsapdata1)) {

//             if (array_key_exists(0, $getsapdata1)) {
//                 $getsapdata2 = $getsapdata1;
//             } else {
//                 $getsapdata2[] = $getsapdata1;
//             }

//         }
//     }

//     return view('HSBC.hsbcpayment_quee')
//         ->with([
//             'toprocess' => $getsapdata2
//         ]);
// }


public function hsbcpayment_quee()
{
    $getsapdata2 = [];

    $getsapdata = $this->step1hsbcprocess();

    // Flatten and sort all payments by Message_Id date/time
    $getsapdata1 = collect($getsapdata)
        ->flatten(1)
        ->sortBy(function ($item) {

            $messageId = $item['Message_Id'] ?? '';

            // Extract YYYYMMDDHHMMSS
            preg_match('/(20\d{12})/', $messageId, $matches);

            return $matches[1] ?? '99999999999999';
        })
        ->values()
        ->toArray();

    // Get number of already processed payments
    $skip = SliceHit::value('SliceHit') ?? 0;

    // Skip processed payments
    $getsapdata1 = array_slice($getsapdata1, $skip);

    // Remaining payments
    if (!empty($getsapdata1)) {
        $getsapdata2 = $getsapdata1;
    }

    return view('HSBC.hsbcpayment_quee')
        ->with([
            'toprocess' => $getsapdata2
        ]);
}

    public function get_the_datafrom_sap_process(Request $request)
    {
        $payment_index=$request->payment_index; 

         //dd($payment_index);
    	$getsapdata1 = [];
    	$getsapdata2 = [];
    	$getsapdata = $this->step1hsbcprocess();

       // dd($getsapdata);


    	if (array_key_exists('Beneficiary_Details', $getsapdata)) {
    		$getsapdata1 = $getsapdata['Beneficiary_Details'];


            // Flatten and sort all payments by Message_Id date/time
            $getsapdata0 = collect($getsapdata)
            ->flatten(1)
            ->sortBy(function ($item) {

            $messageId = $item['Message_Id'] ?? '';

            // Extract YYYYMMDDHHMMSS //
            preg_match('/(20\d{12})/', $messageId, $matches);

            return $matches[1] ?? '99999999999999';
            })
            ->values()
            ->toArray();

            //dd($getsapdata0);


            // Skip
            $skip = SliceHit::value('SliceHit');
            $payment = array_slice($getsapdata0,$skip); 
           
            $getsapdata1 = $payment[$payment_index];
             //dd($getsapdata1);
            //dd($getsapdata1['Message_Id']);

            // dd($getsapdata1[''])
            //insert the initial time with value = 9 

            $msgExists = hsbc_api_hit::where('msgid', $getsapdata1['Message_Id'])->exists();
            // dd($msgExists);
            if (!$msgExists)			 
            {
                $hit_status = 9;
              
                // Insert data
                $insertSuccess = hsbc_api_hit::create([
                'Beneficiary_Name'=>$getsapdata1['Beneficiary_Name'],
                'Beneficiary_Account_No'=>$getsapdata1['Beneficiary_Account_No'],
                'Beneficiary_Bank_Name'=>$getsapdata1['Beneficiary_Bank_Name'],
                'IFSC_Code'=>$getsapdata1['IFSC_Code'],
                'Amount'=>$getsapdata1['Amount'],
                'Transaction_type'=>$getsapdata1['Transaction_type'],
                'Company_Account_No'=>$getsapdata1['Company_Account_No'],
                'Company_Name'=>$getsapdata1['Company_Name'],
                'msgid' => $getsapdata1['Message_Id'],
                'hit_status' => $hit_status,
                'referenceId' => null,
                'statusCode' =>  null,
                'description' =>  null,
                'encdec_data' => null,                        
                'Reversal_Code'  => null,
                'UTR_NO'  => null,
                'Message_Source' =>  null,
                'created_at' => now(),
                'updated_at' => now(),
                ]);
            }

            // dd();

            // dd($getsapdata1);
    		if (array_key_exists(0, $getsapdata1) === false) {
    			$getsapdata2[0] = $getsapdata1;
    		}
            else{
                $getsapdata2 = $getsapdata1;
            }
	   
	    //    dd($getsapdata2);
            $newarr = [];
            if (!empty($getsapdata2)) {
                foreach ($getsapdata2 as $key => $value) {
			if (empty($value['Message_Id'])) {
                        continue;
                    }
                    $msg_id_year = substr($value['Message_Id'],12,4);
                    $msg_id_code = substr($value['Message_Id'],0,2);
                    $msg_id_docno = substr($value['Message_Id'],2,10);
                    $payrefid = $msg_id_year.$msg_id_docno.$msg_id_code;
                    $instrid = $msg_id_year.$msg_id_code.$msg_id_docno;
                    $newarr[$key] = $value;
                    $newarr[$key]['current_date'] = Carbon::now()->toDateString();
                    $newarr[$key]['current_time'] = Carbon::now()->toTimeString();
                    $newarr[$key]['payrefid'] = $payrefid;
                    $newarr[$key]['instrid'] = $instrid;
                    if ($value['Transaction_type'] == 'NEFT') {
                        $hsbctr_type = 'URNS';
                    }
                    if ($value['Transaction_type'] == 'IFT') {
                        $hsbctr_type = 'IMPO';
                    }
                    if ($value['Transaction_type'] == 'RTGS') {
                        $hsbctr_type = 'URGP';
                    }
                    $newarr[$key]['hsbc_trans_type'] = $hsbctr_type;
                }
		if (empty($newarr)) {
                    dd('No Data to Process!');
                }
            }
            else{
                dd('No Data to Process!');
            }
         // dd($newarr);

        return view('HSBC.get_the_datafrom_sap_process')->with(['toprocess' => $newarr]);
            

    	}
    	else{
    		dd('No Data');
    	}
    	// dd($getsapdata2);
    	
    return view('HSBC.get_the_datafrom_sap_process')->with(['data' => $getsapdata1]);
    }


//     public function get_the_datafrom_sap_process(Request $request)
// {
//     $payment_index = $request->payment_index;

//     $getsapdata = $this->step1hsbcprocess();

//     if (array_key_exists('Beneficiary_Details', $getsapdata)) {

//         $getsapdata1 = $getsapdata['Beneficiary_Details'];

//         // Sort payments by Message_Id date/time
//         $getsapdata1 = collect($getsapdata1)
//             ->sortBy(function ($item) {

//                 $messageId = $item['Message_Id'] ?? '';

//                 // Extract YYYYMMDDHHMMSS from Message_Id
//                 preg_match('/(20\d{12})/', $messageId, $matches);

//                 return $matches[1] ?? '99999999999999';
//             })
//             ->values()
//             ->toArray();

//         // Skip already processed payments
//         $skip = SliceHit::value('SliceHit') ?? 0;

//         $payment = array_slice($getsapdata1, $skip);

//         dd($payment);

//         // Check requested payment index exists
//         if (!isset($payment[$payment_index])) {
//             dd('No Data to Process!');
//         }

//         // Get selected payment
//         $getsapdata1 = $payment[$payment_index];

//         // Check Message ID
//         if (empty($getsapdata1['Message_Id'])) {
//             dd('Message ID not found!');
//         }

//         // Check whether already processed
//         $msgExists = hsbc_api_hit::where(
//             'msgid',
//             $getsapdata1['Message_Id']
//         )->exists();

//         if (!$msgExists) {

//             $hit_status = 9;

//             hsbc_api_hit::create([
//                 'Beneficiary_Name'      => $getsapdata1['Beneficiary_Name'],
//                 'Beneficiary_Account_No'=> $getsapdata1['Beneficiary_Account_No'],
//                 'Beneficiary_Bank_Name' => $getsapdata1['Beneficiary_Bank_Name'],
//                 'IFSC_Code'             => $getsapdata1['IFSC_Code'],
//                 'Amount'                => $getsapdata1['Amount'],
//                 'Transaction_type'      => $getsapdata1['Transaction_type'],
//                 'Company_Account_No'    => $getsapdata1['Company_Account_No'],
//                 'Company_Name'          => $getsapdata1['Company_Name'],
//                 'msgid'                 => $getsapdata1['Message_Id'],
//                 'hit_status'            => $hit_status,
//                 'referenceId'           => null,
//                 'statusCode'            => null,
//                 'description'           => null,
//                 'encdec_data'           => null,
//                 'Reversal_Code'         => null,
//                 'UTR_NO'                => null,
//                 'Message_Source'        => null,
//                 'created_at'            => now(),
//                 'updated_at'            => now(),
//             ]);
//         }

//         // Convert selected payment into array for existing processing
//         $getsapdata2 = [
//             $getsapdata1
//         ];

//         $newarr = [];

//         foreach ($getsapdata2 as $key => $value) {

//             if (empty($value['Message_Id'])) {
//                 continue;
//             }

//             $msg_id_year = substr($value['Message_Id'], 12, 4);
//             $msg_id_code = substr($value['Message_Id'], 0, 2);
//             $msg_id_docno = substr($value['Message_Id'], 2, 10);

//             $payrefid = $msg_id_year . $msg_id_docno . $msg_id_code;
//             $instrid  = $msg_id_year . $msg_id_code . $msg_id_docno;

//             $newarr[$key] = $value;

//             $newarr[$key]['current_date'] = Carbon::now()->toDateString();
//             $newarr[$key]['current_time'] = Carbon::now()->toTimeString();
//             $newarr[$key]['payrefid'] = $payrefid;
//             $newarr[$key]['instrid'] = $instrid;

//             if ($value['Transaction_type'] == 'NEFT') {
//                 $hsbctr_type = 'URNS';
//             } elseif ($value['Transaction_type'] == 'IFT') {
//                 $hsbctr_type = 'IMPO';
//             } elseif ($value['Transaction_type'] == 'RTGS') {
//                 $hsbctr_type = 'URGP';
//             } else {
//                 $hsbctr_type = null;
//             }

//             $newarr[$key]['hsbc_trans_type'] = $hsbctr_type;
//         }

//         if (empty($newarr)) {
//             dd('No Data to Process!');
//         }

//         return view('HSBC.get_the_datafrom_sap_process')
//             ->with([
//                 'toprocess' => $newarr
//             ]);
//     }

//     dd('No Data');
// }

    //not same date and >15 min payment rejection
    public function send_sap_for_rejection($msgid,$description)
    {
        
        // $msgExists = hsbc_api_hit::where('msgid', $msgid)->exists();
        $msgExists = hsbc_api_hit::where('msgid', $msgid)
        ->where('hit_status', 0)
        ->exists();
        if ($msgExists)			 
        {
          
            $hit_status = 1;
            $statusCode = "RJCT";

            $updateSuccess = hsbc_api_hit::where('msgid', $msgid)
            ->update([
            'hit_status'  => $hit_status,
            'statusCode'  => $statusCode,
            'description' => $description,
            'Message_Source' => $description,
            'updated_at'  => now(),
            ]);

            if ($updateSuccess) 
            {
              
                $arr_one = [];
                $arr_one['Transaction_Details']['Message_ID'] = $msgid;
                $arr_one['Transaction_Details']['Reference_ID'] = '';
                $arr_one['Transaction_Details']['Status_Code'] = $statusCode;
                $arr_one['Transaction_Details']['Portal_Indicator'] = 'X';

                $sendstatustosap = $this->step2hsbcprocess($arr_one);
                // Log::info('HSBC RJCT > 15 min step2hsbcprocess '.$sendstatustosap);


               
                $arr_two = [];       
                $arr_two['Reference_Details']['Message_ID'] = $msgid;
                $arr_two['Reference_Details']['Reversal_Code'] ='';
                $arr_two['Reference_Details']['UTR_NO'] = ''; 
                $arr_two['Reference_Details']['Payment_Date'] = '';
                $arr_two['Reference_Details']['Payment_Time'] = '';
                $arr_two['Reference_Details']['Message_Source'] = $description;       
                $finalupdate = $this->step4hsbcprocess($arr_two);
                // Log::info('HSBC RJCT > 15 min step4hsbcprocess '.$finalupdate); 
            }
        }
    }


    //payment Manual Rejection

    public function hsbc_manual_rjct(Request $request)
    {

        $payment_index=$request->payment_index; 

        // dd($payment_index);
        $getsapdata1 = [];
        $getsapdata2 = [];
        $getsapdata = $this->step1hsbcprocess();
        if (array_key_exists('Beneficiary_Details', $getsapdata))
        {
            $getsapdata1 = $getsapdata['Beneficiary_Details'];


                        // Flatten and sort all payments by Message_Id date/time
            $getsapdata0 = collect($getsapdata)
            ->flatten(1)
            ->sortBy(function ($item) {

            $messageId = $item['Message_Id'] ?? '';

            // Extract YYYYMMDDHHMMSS
            preg_match('/(20\d{12})/', $messageId, $matches);

            return $matches[1] ?? '99999999999999';
            })
            ->values()
            ->toArray();

            // Skip 
             $skip = SliceHit::value('SliceHit');
            $payment = array_slice($getsapdata0,$skip);
            $getsapdata1 = $payment[$payment_index];

            //dd($getsapdata1['Message_Id']);

            //dd($getsapdata1);
               $msgExists = hsbc_api_hit::where('msgid', $getsapdata1['Message_Id'])->exists();
            // dd($msgExists);
            if (!$msgExists)			 
            {
                $hit_status = 1;

                 $statusCode="RJCT";
                 $description="Manual Rejection";
              
                // Insert data
                $insertSuccess = hsbc_api_hit::create([
                'Beneficiary_Name'=>$getsapdata1['Beneficiary_Name'],
                'Beneficiary_Account_No'=>$getsapdata1['Beneficiary_Account_No'],
                'Beneficiary_Bank_Name'=>$getsapdata1['Beneficiary_Bank_Name'],
                'IFSC_Code'=>$getsapdata1['IFSC_Code'],
                'Amount'=>$getsapdata1['Amount'],
                'Transaction_type'=>$getsapdata1['Transaction_type'],
                'Company_Account_No'=>$getsapdata1['Company_Account_No'],
                'Company_Name'=>$getsapdata1['Company_Name'],
                'msgid' => $getsapdata1['Message_Id'],
                'hit_status' => $hit_status,
                'referenceId' => null,
                'statusCode' =>  $statusCode,
                'description' =>  $description,
                'encdec_data' => null,                        
                'Reversal_Code'  => null,
                'UTR_NO'  => null,
                'Message_Source' =>  null,
                'created_at' => now(),
                'updated_at' => now(),
                ]);
          

            
            if ($insertSuccess) 
            {

                $statusCode="RJCT";
                $description="Manual Rejection";
              
                $arr_one = [];
                $arr_one['Transaction_Details']['Message_ID'] = $getsapdata1['Message_Id'];
                $arr_one['Transaction_Details']['Reference_ID'] = '';
                $arr_one['Transaction_Details']['Status_Code'] = $statusCode;
                $arr_one['Transaction_Details']['Portal_Indicator'] = 'X';

                $sendstatustosap = $this->step2hsbcprocess($arr_one);
                // Log::info('HSBC RJCT > 15 min step2hsbcprocess '.$sendstatustosap);


               
                $arr_two = [];       
                $arr_two['Reference_Details']['Message_ID'] = $getsapdata1['Message_Id'];
                $arr_two['Reference_Details']['Reversal_Code'] ='';
                $arr_two['Reference_Details']['UTR_NO'] = ''; 
                $arr_two['Reference_Details']['Payment_Date'] = '';
                $arr_two['Reference_Details']['Payment_Time'] = '';
                $arr_two['Reference_Details']['Message_Source'] = $description;       
                $finalupdate = $this->step4hsbcprocess($arr_two);
                // Log::info('HSBC RJCT > 15 min step4hsbcprocess '.$finalupdate); 
            }

            }



            return redirect('/api/hsbc/hsbcfinalupdate_table');
        }

 

    }

    // public function posttohsbc_instant_receipt(Request $request)
    // {
    //     if (!empty($request->datatopass))
    //     {
    //         $datatopass = $request->datatopass;
            
    //         Log::info('HSBC SEND DATA '.$datatopass);
    //         // dd($datatopass);
    //         $msgid = $request->msgid;		
            
    //         if (!empty($msgid))
    //         {   
    //             //split the data and time from message id
    //             $payment_date=substr($msgid,16,8); //20260402
    //             $payment_time=substr($msgid,24,6); //115926              
    //             // Current IST time
    //             $current = Carbon::now('Asia/Kolkata');
    //             $current_date = $current->format('Ymd');

    //             //check payment date and time if its is current date is equal to payment date processed further
    //             if ($current_date === $payment_date)
    //             {
    //                     // Calculate difference in seconds                       
    //                     $payment_datetime = Carbon::createFromFormat(
    //                     'Ymd His',
    //                     $payment_date . ' ' . $payment_time,
    //                     'Asia/Kolkata'
    //                     );

    //                     //Get difference (absolute to avoid negative issue)
    //                     $diff_seconds = abs($current->diffInSeconds($payment_datetime, false));

    //                     // Convert to minutes + seconds
    //                     $minutes = floor($diff_seconds / 60);
    //                     $seconds = $diff_seconds % 60;

    //                     if ($diff_seconds <= 900) 
    //                     {
    //                       //this is less then 15 min                          
    //                         sleep(2);
    //                         // Check if msgid already exists
    //                         // $msgExists = hsbc_api_hit::where('msgid', $msgid)->exists();
    //                         $msgExists = hsbc_api_hit::where('msgid', $msgid)
    //                         ->where('hit_status', 0)
    //                         ->exists();
    //                         if (!$msgExists)				 
    //                         {
    //                             $hit_status = 0;                   
                              
    //                             $updateSuccess = hsbc_api_hit::where('msgid', $msgid)
    //                             ->update([
    //                             'hit_status'  => $hit_status,
    //                             'updated_at'  => now(),
    //                             ]);


    //                             if ($updateSuccess) 
    //                             {
    //                                 Log::info('HSBC hit status insertSuccess '.$insertSuccess);
                                    
    //                                 $curl = curl_init();
    //                                 curl_setopt_array($curl, array(
    //                                     CURLOPT_URL => "https://corporate-api.hsbc.com/cmb-connect-payments-pa-payment-prod-proxy/v1/payments/instant-receipt",
    //                                     CURLOPT_RETURNTRANSFER => true,
    //                                     CURLOPT_ENCODING => "",
    //                                     CURLOPT_MAXREDIRS => 10,
    //                                     CURLOPT_TIMEOUT => 30,
    //                                     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    //                                     CURLOPT_CUSTOMREQUEST => "POST",
    //                                     CURLOPT_POSTFIELDS => "{  \r\n\"paymentBase64\":\"$datatopass\"\r\n}",
    //                                     CURLOPT_HTTPHEADER => array(
    //                                         "Content-Type: application/json",
    //                                         "Postman-Token: 9a70d690-ca28-4d85-b4f4-bff6e4102b7e",
    //                                         "cache-control: no-cache",
    //                                         "x-hsbc-client-id: ec461fa7b71a48908af15212613f63a6",
    //                                         "x-hsbc-client-secret: 9F89EF165DB242c8A890E7008658543A",
    //                                         "x-hsbc-profile-id: PC000000746",
    //                                         "x-payload-type: pain.001.001.03",
    //                                         "x-hsbc-country-code: IN",
    //                                         "x-trans-type: bulk"
    //                                     ),
    //                                 ));
                                    
    //                                 $response = curl_exec($curl);
    //                                 Log::info('HSBC RESPONCE DATA '.$response);
    //                                 $err = curl_error($curl);
    //                                 curl_close($curl);
                                    
    //                                 if ($err)
    //                                 {
    //                                     echo "cURL Error #:" . $err;
    //                                 } 
    //                                 else
    //                                 {	
    //                                     $response_encode=json_encode($response);
    //                                     $decoded = json_decode($response);

    //                                     // Check if response contains expected fields
    //                                     if (isset($decoded->referenceId, $decoded->statusCode, $decoded->statusDesc))
    //                                     {
    //                                         // Update record
    //                                         $hsbcApiHit = hsbc_api_hit::where('msgid', $msgid)->first();
    //                                         if ($hsbcApiHit) {
    //                                             $hsbcApiHit->hit_status = 1;
    //                                             $hsbcApiHit->referenceId = $decoded->referenceId;
    //                                             $hsbcApiHit->statusCode = $decoded->statusCode;
    //                                             $hsbcApiHit->description = $decoded->statusDesc;
    //                                             // Only store encdec_data if statusCode is 'RJCT'
    //                                             if ($decoded->statusCode === 'RJCT')
    //                                             {
    //                                                 $hsbcApiHit->encdec_data = $response_encode;
    //                                             }                                   
    //                                             $hsbcApiHit->updated_at = now();
    //                                             $hsbcApiHit->save();
    //                                             Log::info('HSBC hsbc_api_hit Update '.$hsbcApiHit);
    //                                         }

    //                                         $arr = [];
    //                                         $arr['Transaction_Details']['Message_ID'] = $msgid;
    //                                         $arr['Transaction_Details']['Reference_ID'] = $decoded->referenceId;
    //                                         $arr['Transaction_Details']['Status_Code'] = $decoded->statusCode;
    //                                         $arr['Transaction_Details']['Portal_Indicator'] = 'X';

    //                                         $sendstatustosap = $this->step2hsbcprocess($arr);
    //                                         Log::info('HSBC step2hsbcprocess '.$sendstatustosap);
    //                                         // $response_encode=json_encode($response);
    //                                         echo $response_encode;
    //                                         // return view('HSBC.decrypt_js')->with(['toprocess' => $response_encode]);                             
                                                
    //                                     }
    //                                     else
    //                                     {
    //                                         Log::error("Missing expected data in Decoded response: " . json_decode($response));
    //                                     }
    //                                 }
    //                             }
    //                         }
    //                     }
    //                     else
    //                     {                  
    //                     $description="Time exceeded {$minutes} min {$seconds} sec";
    //                     $this->send_sap_for_rejection($msgid, $description);
    //                     }
    //             }
    //             else
    //             {   $description="Date Not Matched";
    //                 $this->send_sap_for_rejection($msgid, $description);
    //             }                    
    //         }
    //     }
    // }







public function posttohsbc_instant_receipt(Request $request)
{
    Log::info('========== HSBC INSTANT RECEIPT START ==========');

    try
    {
        /*
        |--------------------------------------------------------------------------
        | STEP 1: CHECK DATATOPASS
        |--------------------------------------------------------------------------
        */

        if (empty($request->datatopass))
        {
            Log::error('HSBC STOPPED: datatopass is empty');

            return response()->json([
                'status' => false,
                'message' => 'datatopass is empty'
            ], 400);
        }

        $datatopass = $request->datatopass;

        Log::info('HSBC SEND DATA', [
            'datatopass_length' => strlen($datatopass),
            'datatopass' => $datatopass
        ]);


        /*
        |--------------------------------------------------------------------------
        | STEP 2: GET MSGID
        |--------------------------------------------------------------------------
        */

        $msgid = $request->msgid;

        Log::info('HSBC MSGID RECEIVED', [
            'msgid' => $msgid,
            'msgid_length' => strlen($msgid ?? '')
        ]);

        if (empty($msgid))
        {
            Log::error('HSBC STOPPED: MSGID IS EMPTY');

            return response()->json([
                'status' => false,
                'message' => 'msgid is empty'
            ], 400);
        }


        /*
        |--------------------------------------------------------------------------
        | STEP 3: GET PAYMENT DATE AND TIME FROM MSGID
        |--------------------------------------------------------------------------
        */

        $payment_date = substr($msgid, 16, 8);
        $payment_time = substr($msgid, 24, 6);

        Log::info('HSBC PAYMENT DATE/TIME', [
            'msgid' => $msgid,
            'payment_date' => $payment_date,
            'payment_time' => $payment_time
        ]);


        /*
        |--------------------------------------------------------------------------
        | STEP 4: CURRENT IST DATE/TIME
        |--------------------------------------------------------------------------
        */

        $current = Carbon::now('Asia/Kolkata');

        $current_date = $current->format('Ymd');

        Log::info('HSBC CURRENT DATE/TIME', [
            'current_date' => $current_date,
            'current_datetime' => $current->format('Y-m-d H:i:s')
        ]);


        /*
        |--------------------------------------------------------------------------
        | STEP 5: GET DB RECORD
        |--------------------------------------------------------------------------
        */

        $hsbcApiHit = hsbc_api_hit::where('msgid', $msgid)->first();

        if (!$hsbcApiHit)
        {
            Log::error('HSBC STOPPED: MSGID NOT FOUND IN DATABASE', [
                'msgid' => $msgid
            ]);

            return response()->json([
                'status' => false,
                'message' => 'MSGID not found in hsbc_api_hit'
            ], 404);
        }

        Log::info('HSBC DB RECORD FOUND', [
            'id' => $hsbcApiHit->id,
            'msgid' => $msgid,
            'hit_status' => $hsbcApiHit->hit_status,
            'referenceId' => $hsbcApiHit->referenceId,
            'statusCode' => $hsbcApiHit->statusCode
        ]);


        /*
        |--------------------------------------------------------------------------
        | STEP 6: ONLY STATUS 9 CAN START PROCESSING
        |
        | 9 = Initial
        | 0 = Processing
        | 1 = API processing completed
        |--------------------------------------------------------------------------
        */

        if ((int) $hsbcApiHit->hit_status !== 9)
        {
            Log::warning('HSBC STOPPED: STATUS IS NOT 9', [
                'id' => $hsbcApiHit->id,
                'msgid' => $msgid,
                'hit_status' => $hsbcApiHit->hit_status
            ]);

            return response()->json([
                'status' => false,
                'message' => 'Payment already processed or currently processing',
                'hit_status' => $hsbcApiHit->hit_status
            ]);
        }


        /*
        |--------------------------------------------------------------------------
        | STEP 7: DATE CHECK
        |--------------------------------------------------------------------------
        */

        if ($current_date !== $payment_date)
        {
            $description = 'Date Not Matched';

            Log::warning('HSBC REJECTED: DATE NOT MATCHED', [
                'msgid' => $msgid,
                'payment_date' => $payment_date,
                'current_date' => $current_date
            ]);


            /*
            |--------------------------------------------------------------------------
            | UPDATE DB
            |--------------------------------------------------------------------------
            */

            $hsbcApiHit->statusCode = 'RJCT';
            $hsbcApiHit->description = $description;
            $hsbcApiHit->updated_at = now();
            $hsbcApiHit->save();


            Log::info('HSBC DATE REJECTION DB UPDATED', [
                'id' => $hsbcApiHit->id,
                'msgid' => $msgid,
                'hit_status' => $hsbcApiHit->hit_status,
                'statusCode' => $hsbcApiHit->statusCode,
                'description' => $hsbcApiHit->description
            ]);


            /*
            |--------------------------------------------------------------------------
            | SEND REJECTION TO SAP
            |--------------------------------------------------------------------------
            */

            $arr = [];

            $arr['Transaction_Details']['Message_ID'] = $msgid;
            $arr['Transaction_Details']['Reference_ID'] = '';
            $arr['Transaction_Details']['Status_Code'] = 'RJCT';
            $arr['Transaction_Details']['Portal_Indicator'] = 'X';


            Log::info('HSBC CALLING STEP2HSBCPROCESS - DATE REJECTION', [
                'msgid' => $msgid,
                'statusCode' => 'RJCT'
            ]);

            $sendstatustosap = $this->step2hsbcprocess($arr);

            Log::info('HSBC STEP2HSBCPROCESS RESPONSE - DATE REJECTION', [
                'msgid' => $msgid,
                'response' => $sendstatustosap
            ]);


            Log::info('========== HSBC END - DATE REJECTED ==========');

            return response()->json([
                'status' => false,
                'message' => $description
            ]);
        }


        /*
        |--------------------------------------------------------------------------
        | STEP 8: CREATE PAYMENT DATETIME
        |--------------------------------------------------------------------------
        */

        try
        {
            $payment_datetime = Carbon::createFromFormat(
                'Ymd His',
                $payment_date . ' ' . $payment_time,
                'Asia/Kolkata'
            );
        }
        catch (\Throwable $e)
        {
            Log::error('HSBC INVALID PAYMENT DATETIME', [
                'msgid' => $msgid,
                'payment_date' => $payment_date,
                'payment_time' => $payment_time,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'status' => false,
                'message' => 'Invalid payment date/time'
            ], 400);
        }


        /*
        |--------------------------------------------------------------------------
        | STEP 9: CHECK TIME DIFFERENCE
        |--------------------------------------------------------------------------
        */

        $diff_seconds = abs(
            $current->diffInSeconds(
                $payment_datetime,
                false
            )
        );

        $minutes = floor($diff_seconds / 60);
        $seconds = $diff_seconds % 60;

        Log::info('HSBC TIME CHECK', [
            'msgid' => $msgid,
            'payment_datetime' => $payment_datetime->format('Y-m-d H:i:s'),
            'current_datetime' => $current->format('Y-m-d H:i:s'),
            'diff_seconds' => $diff_seconds,
            'minutes' => $minutes,
            'seconds' => $seconds
        ]);


        /*
        |--------------------------------------------------------------------------
        | STEP 10: TIME EXCEEDED 24 HR
        |--------------------------------------------------------------------------
        */

        if ($diff_seconds > 86400)
        {
            $description = "Time exceeded {$minutes} min {$seconds} sec";

            Log::warning('HSBC REJECTED: TIME EXCEEDED', [
                'msgid' => $msgid,
                'description' => $description,
                'diff_seconds' => $diff_seconds
            ]);


            /*
            |--------------------------------------------------------------------------
            | UPDATE DB
            |--------------------------------------------------------------------------
            */

            $hsbcApiHit->statusCode = 'RJCT';
            $hsbcApiHit->description = $description;
            $hsbcApiHit->updated_at = now();
            $hsbcApiHit->save();


            Log::info('HSBC TIME REJECTION DB UPDATED', [
                'id' => $hsbcApiHit->id,
                'msgid' => $msgid,
                'hit_status' => $hsbcApiHit->hit_status,
                'statusCode' => $hsbcApiHit->statusCode,
                'description' => $hsbcApiHit->description
            ]);


            /*
            |--------------------------------------------------------------------------
            | SEND REJECTION TO SAP
            |--------------------------------------------------------------------------
            */

            $arr = [];

            $arr['Transaction_Details']['Message_ID'] = $msgid;
            $arr['Transaction_Details']['Reference_ID'] = '';
            $arr['Transaction_Details']['Status_Code'] = 'RJCT';
            $arr['Transaction_Details']['Portal_Indicator'] = 'X';


            Log::info('HSBC CALLING STEP2HSBCPROCESS - TIME REJECTION', [
                'msgid' => $msgid,
                'statusCode' => 'RJCT'
            ]);

            $sendstatustosap = $this->step2hsbcprocess($arr);

            Log::info('HSBC STEP2HSBCPROCESS RESPONSE - TIME REJECTION', [
                'msgid' => $msgid,
                'response' => $sendstatustosap
            ]);


            Log::info('========== HSBC END - TIME REJECTED ==========');

            return response()->json([
                'status' => false,
                'message' => $description
            ]);
        }


        /*
        |--------------------------------------------------------------------------
        | STEP 11:
        |
        | VALID PAYMENT
        |
        | CHANGE STATUS 9 -> 0
        |--------------------------------------------------------------------------
        */

        Log::info('HSBC STATUS CHANGE 9 -> 0 START', [
            'id' => $hsbcApiHit->id,
            'msgid' => $msgid
        ]);

        $hsbcApiHit->hit_status = 0;
        $hsbcApiHit->updated_at = now();

        $statusUpdate = $hsbcApiHit->save();


        Log::info('HSBC STATUS CHANGE 9 -> 0 COMPLETE', [
            'id' => $hsbcApiHit->id,
            'msgid' => $msgid,
            'save_result' => $statusUpdate,
            'hit_status' => $hsbcApiHit->hit_status
        ]);


        /*
        |--------------------------------------------------------------------------
        | STEP 12: WAIT 2 SECONDS
        |--------------------------------------------------------------------------
        */

        sleep(2);


        /*
        |--------------------------------------------------------------------------
        | STEP 13: HSBC API CALL
        |
        | YOUR ORIGINAL API SETTINGS ARE KEPT EXACTLY
        |--------------------------------------------------------------------------
        */

        Log::info('HSBC CALLING INSTANT RECEIPT API', [
            'id' => $hsbcApiHit->id,
            'msgid' => $msgid,
            'hit_status' => $hsbcApiHit->hit_status
        ]);


        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://corporate-api.hsbc.com/cmb-connect-payments-pa-payment-prod-proxy/v1/payments/instant-receipt",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "{  \r\n\"paymentBase64\":\"$datatopass\"\r\n}",
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json",
                "Postman-Token: 9a70d690-ca28-4d85-b4f4-bff6e4102b7e",
                "cache-control: no-cache",
                "x-hsbc-client-id: ec461fa7b71a48908af15212613f63a6",
                "x-hsbc-client-secret: 9F89EF165DB242c8A890E7008658543A",
                "x-hsbc-profile-id: PC000000746",
                "x-payload-type: pain.001.001.03",
                "x-hsbc-country-code: IN",
                "x-trans-type: bulk"
            ),
        ));


        /*
        |--------------------------------------------------------------------------
        | STEP 14: EXECUTE HSBC API
        |--------------------------------------------------------------------------
        */

        $response = curl_exec($curl);

        $err = curl_error($curl);

        $http_code = curl_getinfo(
            $curl,
            CURLINFO_HTTP_CODE
        );

        curl_close($curl);


        /*
        |--------------------------------------------------------------------------
        | STEP 15: LOG RESPONSE
        |--------------------------------------------------------------------------
        */

        Log::info('HSBC API RESPONSE RECEIVED', [
            'msgid' => $msgid,
            'http_code' => $http_code,
            'curl_error' => $err,
            'response' => $response
        ]);


        /*
        |--------------------------------------------------------------------------
        | STEP 16: CURL ERROR
        |--------------------------------------------------------------------------
        */

        if ($err)
        {
            Log::error('HSBC CURL ERROR', [
                'msgid' => $msgid,
                'error' => $err,
                'http_code' => $http_code
            ]);


            /*
            | API was not successfully completed.
            | Reset 0 -> 9 so it can be retried.
            */

            $hsbcApiHit->hit_status = 9;
            $hsbcApiHit->description = 'cURL Error: ' . $err;
            $hsbcApiHit->updated_at = now();
            $hsbcApiHit->save();


            Log::warning('HSBC STATUS RESET 0 -> 9', [
                'id' => $hsbcApiHit->id,
                'msgid' => $msgid
            ]);


            return response()->json([
                'status' => false,
                'message' => $err
            ], 500);
        }


        /*
        |--------------------------------------------------------------------------
        | STEP 17: DECODE HSBC RESPONSE
        |--------------------------------------------------------------------------
        */

        $response_encode = json_encode($response);

        $decoded = json_decode($response);


        Log::info('HSBC DECODED RESPONSE', [
            'msgid' => $msgid,
            'decoded' => $decoded
        ]);


        /*
        |--------------------------------------------------------------------------
        | STEP 18: CHECK RESPONSE
        |--------------------------------------------------------------------------
        */

        if (
            isset(
                $decoded->referenceId,
                $decoded->statusCode,
                $decoded->statusDesc
            )
        )
        {

            /*
            |--------------------------------------------------------------------------
            | API COMPLETED
            |
            | CHANGE 0 -> 1
            |--------------------------------------------------------------------------
            */

            $hsbcApiHit->hit_status = 1;

            $hsbcApiHit->referenceId =
                $decoded->referenceId;

            $hsbcApiHit->statusCode =
                $decoded->statusCode;

            $hsbcApiHit->description =
                $decoded->statusDesc;


            /*
            |--------------------------------------------------------------------------
            | STORE RESPONSE IF REJECTED
            |--------------------------------------------------------------------------
            */

            if ($decoded->statusCode === 'RJCT')
            {
                $hsbcApiHit->encdec_data =
                    $response_encode;

                Log::warning('HSBC API RETURNED RJCT', [
                    'msgid' => $msgid,
                    'referenceId' => $decoded->referenceId,
                    'statusCode' => $decoded->statusCode,
                    'statusDesc' => $decoded->statusDesc
                ]);
            }
            else
            {
                Log::info('HSBC API RETURNED STATUS', [
                    'msgid' => $msgid,
                    'referenceId' => $decoded->referenceId,
                    'statusCode' => $decoded->statusCode,
                    'statusDesc' => $decoded->statusDesc
                ]);
            }


            /*
            |--------------------------------------------------------------------------
            | STEP 19: SAVE 0 -> 1
            |--------------------------------------------------------------------------
            */

            $saveSuccess = $hsbcApiHit->save();


            Log::info('HSBC DB UPDATED 0 -> 1', [
                'saveSuccess' => $saveSuccess,
                'id' => $hsbcApiHit->id,
                'msgid' => $msgid,
                'hit_status' => $hsbcApiHit->hit_status,
                'referenceId' => $hsbcApiHit->referenceId,
                'statusCode' => $hsbcApiHit->statusCode,
                'description' => $hsbcApiHit->description
            ]);


            /*
            |--------------------------------------------------------------------------
            | STEP 20: SEND RESPONSE TO SAP
            |--------------------------------------------------------------------------
            */

            $arr = [];

            $arr['Transaction_Details']['Message_ID'] =
                $msgid;

            $arr['Transaction_Details']['Reference_ID'] =
                $decoded->referenceId;

            $arr['Transaction_Details']['Status_Code'] =
                $decoded->statusCode;

            $arr['Transaction_Details']['Portal_Indicator'] =
                'X';


            Log::info('HSBC CALLING STEP2HSBCPROCESS', [
                'msgid' => $msgid,
                'referenceId' => $decoded->referenceId,
                'statusCode' => $decoded->statusCode
            ]);


            $sendstatustosap =
                $this->step2hsbcprocess($arr);


            Log::info('HSBC STEP2HSBCPROCESS RESPONSE', [
                'msgid' => $msgid,
                'response' => $sendstatustosap
            ]);


            Log::info('========== HSBC INSTANT RECEIPT END SUCCESS ==========');


            return response()->json([
                'status' => true,
                'msgid' => $msgid,
                'referenceId' => $decoded->referenceId,
                'statusCode' => $decoded->statusCode,
                'description' => $decoded->statusDesc
            ]);
        }


        /*
        |--------------------------------------------------------------------------
        | STEP 21: HSBC RESPONSE MISSING EXPECTED FIELDS
        |--------------------------------------------------------------------------
        */

        Log::error('HSBC RESPONSE MISSING EXPECTED FIELDS', [
            'msgid' => $msgid,
            'response' => $response,
            'decoded' => $decoded
        ]);


        $hsbcApiHit->description =
            'HSBC response missing expected fields';

        $hsbcApiHit->updated_at = now();
        $hsbcApiHit->save();


        return response()->json([
            'status' => false,
            'message' => 'HSBC response missing expected fields',
            'response' => $decoded
        ], 500);
    }
    catch (\Throwable $e)
    {
        Log::error('========== HSBC INSTANT RECEIPT EXCEPTION ==========', [
            'message' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'trace' => $e->getTraceAsString()
        ]);

        return response()->json([
            'status' => false,
            'message' => $e->getMessage()
        ], 500);
    }
}






//     public function posttohsbc_instant_receipt(Request $request)
// {
//     Log::info('========== HSBC INSTANT RECEIPT START ==========');

//     Log::info('HSBC Request Data', [
//         'all_request' => $request->all(),
//     ]);

//     if (!empty($request->datatopass))
//     {
//         $datatopass = $request->datatopass;

//         Log::info('HSBC SEND DATA', [
//             'datatopass_length' => strlen($datatopass),
//             'datatopass' => $datatopass,
//         ]);

//         $msgid = $request->msgid;

//         Log::info('HSBC MSGID RECEIVED', [
//             'msgid' => $msgid,
//             'msgid_empty' => empty($msgid),
//         ]);

//         if (!empty($msgid))
//         {
//             Log::info('HSBC STEP 1: MSGID IS NOT EMPTY');

//             $payment_date = substr($msgid, 16, 8);
//             $payment_time = substr($msgid, 24, 6);

//             Log::info('HSBC MESSAGE DATE/TIME', [
//                 'msgid' => $msgid,
//                 'payment_date' => $payment_date,
//                 'payment_time' => $payment_time,
//             ]);

//             $current = Carbon::now('Asia/Kolkata');
//             $current_date = $current->format('Ymd');

//             Log::info('HSBC CURRENT DATE', [
//                 'current_date' => $current_date,
//                 'payment_date' => $payment_date,
//                 'date_match' => ($current_date === $payment_date),
//             ]);

//             if ($current_date === $payment_date)
//             {
//                 Log::info('HSBC STEP 2: PAYMENT DATE MATCHED');

//                 try {

//                     $payment_datetime = Carbon::createFromFormat(
//                         'Ymd His',
//                         $payment_date . ' ' . $payment_time,
//                         'Asia/Kolkata'
//                     );

//                     Log::info('HSBC PAYMENT DATETIME CREATED', [
//                         'payment_datetime' => $payment_datetime->format('Y-m-d H:i:s'),
//                         'current_datetime' => $current->format('Y-m-d H:i:s'),
//                     ]);

//                     $diff_seconds = abs(
//                         $current->diffInSeconds($payment_datetime, false)
//                     );

//                     $minutes = floor($diff_seconds / 60);
//                     $seconds = $diff_seconds % 60;

//                     Log::info('HSBC TIME DIFFERENCE', [
//                         'diff_seconds' => $diff_seconds,
//                         'minutes' => $minutes,
//                         'seconds' => $seconds,
//                     ]);

//                     if ($diff_seconds <= 900)
//                     {
//                         Log::info('HSBC STEP 3: WITHIN 15 MINUTES');

//                         sleep(2);

//                         Log::info('HSBC CHECKING EXISTING MSGID', [
//                             'msgid' => $msgid,
//                         ]);

//                         $msgExists = hsbc_api_hit::where('msgid', $msgid)
//                             ->where('hit_status', 0)
//                             ->exists();

//                         Log::info('HSBC EXISTING MSGID RESULT', [
//                             'msgid' => $msgid,
//                             'msgExists' => $msgExists,
//                         ]);

//                         if (!$msgExists)
//                         {
//                             Log::info('HSBC STEP 4: MSGID NOT FOUND WITH hit_status=0');

//                             $hit_status = 0;

//                             $updateSuccess = hsbc_api_hit::where('msgid', $msgid)
//                                 ->update([
//                                     'hit_status' => $hit_status,
//                                     'updated_at' => now(),
//                                 ]);

//                             Log::info('HSBC DB UPDATE RESULT', [
//                                 'msgid' => $msgid,
//                                 'updateSuccess' => $updateSuccess,
//                             ]);

//                             if ($updateSuccess)
//                             {
//                                 Log::info('HSBC STEP 5: DB UPDATE SUCCESS');

//                                 // API call starts here

//                                 Log::info('HSBC ABOUT TO CALL INSTANT RECEIPT API');

//                                 // your curl code...
//                             }
//                             else
//                             {
//                                 Log::error('HSBC DB UPDATE FAILED', [
//                                     'msgid' => $msgid,
//                                 ]);
//                             }
//                         }
//                         else
//                         {
//                             Log::warning('HSBC API SKIPPED: MSGID ALREADY EXISTS WITH hit_status=0', [
//                                 'msgid' => $msgid,
//                             ]);
//                         }
//                     }
//                     else
//                     {
//                         $description = "Time exceeded {$minutes} min {$seconds} sec";

//                         Log::warning('HSBC API SKIPPED: TIME EXCEEDED', [
//                             'msgid' => $msgid,
//                             'description' => $description,
//                         ]);

//                         $this->send_sap_for_rejection($msgid, $description);
//                     }
//                 }
//                 catch (\Throwable $e)
//                 {
//                     Log::error('HSBC INSTANT RECEIPT EXCEPTION', [
//                         'message' => $e->getMessage(),
//                         'file' => $e->getFile(),
//                         'line' => $e->getLine(),
//                         'trace' => $e->getTraceAsString(),
//                     ]);
//                 }
//             }
//             else
//             {
//                 $description = "Date Not Matched";

//                 Log::warning('HSBC API SKIPPED: DATE NOT MATCHED', [
//                     'msgid' => $msgid,
//                     'current_date' => $current_date,
//                     'payment_date' => $payment_date,
//                 ]);

//                 $this->send_sap_for_rejection($msgid, $description);
//             }
//         }
//         else
//         {
//             Log::error('HSBC API STOPPED: MSGID IS EMPTY');
//         }
//     }
//     else
//     {
//         Log::error('HSBC API STOPPED: DATATOPASS IS EMPTY');
//     }

//     Log::info('========== HSBC INSTANT RECEIPT END ==========');
// }


    public function hsbcfinalencdec(Request $request)
    {    
        $id=$request->id; 
        $msg_id=$request->msgid; 
        // echo $msg_id,$id;

        $hsbcApiHit_final = hsbc_api_hit::where('msgid', $msg_id)->first();
        if ($hsbcApiHit_final) {
            $response_encode = $hsbcApiHit_final->encdec_data;
            echo  $response_encode;              
        } 
        else 
        {
            echo "No record found for msgid: " . $msg_id;
        }
        
        
    }

     //final decrypt msg store into db and send sap - > vijay
     public function hsbcfinalupdate_decrypt(Request $request)
     {        
         $statuscode = $request->statuscode;
         $GrpSts= $request->GrpSts;
         $rmsgid = $request->rmsgid;
         $rpaymentdate = $request->rpaymentdate;
         $error_code= $request->error_code;
         $AddtlInf= $request->AddtlInf;
         Log::info(
            'HSBC hsbc_api_hit before step4hsbcprocess Update - ' .
            'Message_ID: ' . $rmsgid . ', ' .
            'Reversal_Code: ' . $error_code . ', ' .
            'UTR_NO: ' . ($statuscode ?: $GrpSts) . ', ' .
            'Payment_Date: ' . $rpaymentdate . ', ' .
            'Payment_Time: ' . '' . ', ' .
            'Message_Source: ' . $AddtlInf
        );          
 
         $hsbcApiHit_final = hsbc_api_hit::where('msgid', $rmsgid)->first();
         if ($hsbcApiHit_final) {            
            $hsbcApiHit_final->encdec_data = null; 
             $hsbcApiHit_final->Reversal_Code = $error_code;            
             $hsbcApiHit_final->UTR_NO = $statuscode ?: $GrpSts; 
             $hsbcApiHit_final->Message_Source = $AddtlInf;
             $hsbcApiHit_final->updated_at = now();
             $hsbcApiHit_final->save();
             Log::info(
                 'HSBC hsbc_api_hit after step4hsbcprocess Update - ' .
                 'Message_ID: ' . $rmsgid . ', ' .
                 'Reversal_Code: ' . $error_code . ', ' .
                 'UTR_NO: ' . ($statuscode ?: $GrpSts) . ', ' .
                 'Payment_Date: ' . $rpaymentdate . ', ' .
                 'Payment_Time: ' . '' . ', ' .
                 'Message_Source: ' . $AddtlInf
             );
            
         }
         
         $arr = [];       
         $arr['Reference_Details']['Message_ID'] = $rmsgid;
         $arr['Reference_Details']['Reversal_Code'] =   $error_code;
         $arr['Reference_Details']['UTR_NO'] = $statuscode ?: $GrpSts; 
         $arr['Reference_Details']['Payment_Date'] = $rpaymentdate;
         $arr['Reference_Details']['Payment_Time'] = '';
         $arr['Reference_Details']['Message_Source'] = $AddtlInf;       
        $finalupdate = $this->step4hsbcprocess($arr);
        Log::info('HSBC step4hsbcprocess '.$finalupdate);         
        return response()->json($arr);
     }

     public function hsbcfinalupdate_table()
     { 
         $data = hsbc_api_hit::orderBy('id', 'desc')->get();  
         return view('HSBC.hsbcfinalupdate_table')->with('data', $data);
         
     }


    public function testjson()
    {
        $response = "{\"referenceId\":\"d0280c9c-217a-48a4-91c5-2b434c7cd77c\",\"profileId\":\"PC000000746\",\"statusCode\":\"ACCP\",\"statusDesc\":\"Accepted Instruction Validation (L2)\",\"responseBase64\":\"LS0tLS1CRUdJTiBQR1AgTUVTU0FHRS0tLS0tClZlcnNpb246IEJDUEcgdjEuNjAKCmhRRU1BeHUweERQOGZHbjFBUWYvUzRQN0dNcklYZWpzZ2tvYUc5ZkFoSTNQN0FOWWFBaEhrTGpCNVJ2VlRJMFYKNCswaVd0SFlPNEtLM1ZyZDNuSGxoTHpqN1Z5amN4WFVVQjE4Y3ZIUG5ZQjkxRXVEeEx3L0h0TUZLZzNoL2RrTAp5c21GSjlBZHBWRFZvTXhJR1k1cC9WQ3Q4bkkrQUlLam1WbnVsWmlGR1lDTWVzb0svL0pVZm9ZNldQczZSc0VBCkRRa2p6Y1g4ZFF0Vk5ZSzRiS3dJbTFDeWtucHFoR3F2VThmVjVBVm9qTm5EclF5ejJPY2VjMGtlcERmMkswcGwKQjJ0aVlXV0hwclEyZlZobE55a2Y3UXFKVXEvWFBQYnRUWWF6akY0VzFuVHdxalVHb05ZTzByOXhreU5hZFIrVwpFU3ZaNVZkOUlnTzVqQlJxNFB5aldiTHpNZGJtVFYwYVBSQmhiMlVxc05MRkRBSGVxN3lOUHZMR2VnMk5ybXFsCmg3ajlYT2V3K25hK05XOHJ5WjBpaXd2N292aGFwMkpuTFlBWGIzZk9JRy9YdzRmYzE0ay8yRE4vQWFGV2t3bmIKVHIvZUJpN3F6S1RRK1RjV2x3dldMaHd2eUwrVjZ1YStyRVhqVDU2NFZLTmdsb2dmYUNnWFNJNHhGMzJEVkF2QQpxN3Q5VWF0NjV1SWZ0YzJwV24rRUkzVVMrMHRmdGNhc3lTaUJQQ0FKSnFBT3BpYXNpNTA2SXozNEtzVXZ4Qmg0CjlGRll0dlo4VzNSby80bll5WmNjMzNkdG9nTUppTW11VDBlYVoxdzFZd1Izek8wNlJadjAvMzYrTU04d2ovWk0KZStHL3NWVDUreE5xS013cmd2L1VmVWw0azVkSTR2cnRrYXc3L0xLVncyTW50K3JCbG9odi9pemtuMi9QYzA2Zgp5cHkrNzNJNE9iNkxweE9rcndOcyt3NENsV2trYUJUQWs2SGZnUnd3Rzg0K2NQcU15aytMU0VKWmFqdG91RWdGCkFnU0NVenc1U2ZGUDMxQjJYNjNWTzhKUnUwbWVaaUxTNk9YUGh3UFZPMksrM1pOTGRadWdPQTdRcWdOQzdsd2sKZEhkbERteGR6L0FDTWNkMkl2d0VJVVAzV29kZ2EvdXRIZnRwUGcvdmY3Sy9sVk5adWVvcVZJWWozN25zVXVmYwp2YW5rUVczZjFxVVo2N05QeTNSL0l5QzNvUGVvdzlhMFZheExpbERQYURDYXFDbW0vdVAzVkNlV2xsbUNlRU1PCk9xWTI4R2RuWnJ2VnFNckxWUzVTRHVWRkJxV09oZHNjWDlDa1lBa3hIRXZETHVkU3grUFJDVW5JWnJUSFhvcjYKZ3NPOWdyRVJteE1KUVk2NEdUdWVnTkxLdW9hUlpLMmo4NEVUaExVWTVxcWFBYWR5a0tTajVDQVZkTTdQeTdINwpFbUo3RFA1eVBDeU1IYTc2dnRUN003d1NIZUZHSURMSldMOTdyOW5qV3NvQm5OTGZ3NC9kRU9OZ0p3dExWcFFpCnlTc3JlUUhrWjNpczc3U0NFRWNWc21HRnRQcnJsU0FEdmRjTDUxSUNMNW8vTXNJK2RBczJNUC9nd0hkM0VmenIKYzl5cy9OTlQvZVFzeFU3bi9JekNVc2wxK2hZVzlmZWlNeERKTEloMUtwOUlkUGdlbWQra1hWMHBFRFBCTDhtbgpRZG1zNFdLWmJkbkxQU1hXMTRFcUt0VCttSzF6c05iQW5STWhzc2NaOXpVUm9xU2d3ZFZMcUtIemVPSDMzUEkzCm9YcFhyakE1YUZzMGFuQWlGdUhvb3o3Um5COVpPUHVTMzhyRUN6NEJlT3dmQ1pYbjE3V3l5M3lqKzB3U05sYjYKdU12RFJyWUpBdlhpdXN0UjFqNlVGY2ZyV2trV01GdTRvUTRFWlQ3aDZmVndYOFF4QjNwdzdDckwzVktNcm5MVgplS0FZWlVuOWdWZmZVcVhiNnNOR3E1T2RzbnRRbFZ0bHVwdlZHbDlFa0JObThqdkJjMjcraklCL1dzV2w3SkI2CmJoQnluWkQzcFQvQ0tiTXVlbHoyajU2bUh0elVTR0lyVU54K1lSeGEvdnlDYlRjYlJBL0xoalM0RERzcHY0MnoKQlY1bHJmS244ZVJwcytlbkNxbXpUMjZvVElKc2x6Y1dpQzFQbjBjdEFLSUlLVzJKcHlNNU5VUlB0Rjgwd1lPWAoyd2w0bzBReS9wQ0h4YXJjQVpHUEVwNmY3YjFEbzFvb05JUVI3S2I3dGpvcVZIbDNYeEhrR3VlK0VTYzRaVSs0Cnk1Q2wvZ2ZXc1NGQk9UdnlCWm9lN0RTOFYrakFaMnYrU1VscEpRWFZydDN0cVMzU29JdW51WGp1V0hOeW5aTDgKaGxBOXFnYTE2aUNQNEt4Y3NmRjVtL3FDdk01dTRVM09ObjAzQ1dqL2dDNis2T1RTZDdMU0FMTEFUdWcwaFhQSgpBTHI1bk9ROFoxS3lIWmd0NEZpQ3AxcmxYWk94S2JNQzRjWktNMVU1aFhaVUZFeHJZdFdTTGhlK0F6NWQ5VmxtClVZMHpGc1VEYWVqd3d3QTQzWG1heFh4UTZpV1oyVU5DRjhrWlBwQUk4eHBDWGFpQVBZbWJZVHRHSFdYRFR1aEMKSjVXREx0MHNZOWlFWVMwOGNxb0t4emdxclJ0bzlobzR2TGlSUDZJYVJJS0NuZWVIZURlaWdLOHRsUWsxVGd6WApLZUtRS04rNGtvUHZXQktlYWJWdFo4NE40NUN4NkdwNTNVTnNadStSN3ZNNlR4eGpzWTl1aWNpVW1YeDhtNFR1ClN2Q3ZLTGtkcFliU2lqMURXOVdBNzBzcmpnQnhQU2F6akZSZXVPVGxiQmp2ZkJJSFJrWjc2eEEvbEExZXorZ2UKOStJa1BTRy9oYnlkYmpmRGw1dElhZWhXNkFQRStjUysrNmtaRC8zMFhlekF2Sk9hOWo4Z3dWSWF1eEd2dlFhYwpNcitjTUMwTWpMOFhFcWQ2bVhjZnVnc09rM1FGV2V6QVJTODRKTlJOcmdmeFVOMittSTJmbkQzNUZMWHE5Sm1vCjh1YlpxdWhZZ0dyem9tb0RJKys0eFgrYVNncGlEUmI1V3U1d2FpYkEKPVo5SHoKLS0tLS1FTkQgUEdQIE1FU1NBR0UtLS0tLQo=\"}";

        $decoded = json_decode($response);
        //dd($decoded);
        $arr = [];
    $arr['Transaction_Details']['Message_ID'] = 'VD18000000012019';
    $arr['Transaction_Details']['Reference_ID'] = $decoded->referenceId;
    $arr['Transaction_Details']['Status_Code'] = $decoded->statusCode;
    $arr['Transaction_Details']['Portal_Indicator'] = 'X';
        //dd($arr);
        $sendstatustosap = $this->step2hsbcprocess($arr);
        dd($sendstatustosap);
    }

    public function newtestjson2()
    {
        return view('HSBC.testingfordecryption');
    }

    public function hsbccheckstatusforsentdata()
    {
        $getsapdata1 = [];
        $getsapdata2 = [];
        $getsapdata = $this->step3hsbcprocess();
        //dd($getsapdata);
        if (array_key_exists('Details', $getsapdata)) {
            $getsapdata1 = $getsapdata['Details'];
            if (array_key_exists(0, $getsapdata1) === false) {
		if ($getsapdata['Details']['Reference_ID'] == '') {
                    dd('No Data to Process!');
                }
                $getsapdata2[0] = $getsapdata1;
            }
            else{
                $getsapdata2 = $getsapdata1;
            }

            //dd($getsapdata2);

            $newarr = [];
            if (empty($getsapdata2)) {
                dd('No Data to Process!');
            }
            //dd($newarr);

            return view('HSBC.hsbccheckstatusforsentdata')->with(['toprocess' => $getsapdata2]);
            

        }
        else{
            dd('No Data');
        }
        dd($getsapdata2);
        
        return view('HSBC.hsbccheckstatusforsentdata')->with(['data' => $getsapdata1]);
    }

    public function posthsbccheckstatusforsentdata(Request $request)
    {
        if (!empty($request->datatopass)) {
            
            $datatopass = $request->datatopass;
            $msgid = $request->msgid;

            

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://corporate-api.hsbc.com/cmb-connect-payments-pa-payment-prod-proxy/v1/payments/status",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "{  \r\n\"paymentEnquiryBase64\":\"$datatopass\"\r\n}",
  CURLOPT_HTTPHEADER => array(
    "Content-Type: application/json",
    "Postman-Token: 9a70d690-ca28-4d85-b4f4-bff6e4102b7e",
    "cache-control: no-cache",
    "x-hsbc-client-id: ec461fa7b71a48908af15212613f63a6",
    "x-hsbc-client-secret: 9F89EF165DB242c8A890E7008658543A",
    "x-hsbc-profile-id: PC000000746",
    "x-payload-type: pain.001.001.03"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
        echo json_encode($response);
}


        }
    }

    public function hsbcfinalupdate(Request $request)
    {
        $utrno = $request->utrno;
        $statuscode = $request->statuscode;
        $rmsgid = $request->rmsgid;
        $rpaymentdate = $request->rpaymentdate;
	
	//if ($statuscode != 'ACSC') {
          //  $utrno = '';
       // }if ($statuscode != 'ACSC') {
         //   $utrno = '';
        //}

        $arr = [];
        $arr['Reference_Details']['Message_ID'] = $rmsgid;
        $arr['Reference_Details']['Reversal_Code'] = $statuscode;
        $arr['Reference_Details']['UTR_NO'] = $utrno;
        $arr['Reference_Details']['Payment_Date'] = $rpaymentdate;
        $arr['Reference_Details']['Payment_Time'] = '';
        $arr['Reference_Details']['Message_Source'] = '';

        $finalupdate = $this->step4hsbcprocess($arr);
        Log::info('Final Status = '.$finalupdate['Status']);
        return json_encode($finalupdate);
    }

    public function gethsbcbankpaymentstatus(Request $request)
    {
	
	$getsapdata1 = [];
        $getsapdata2 = [];
        $getsapdata = $this->step3hsbcprocess();
	//return json_encode($getsapdata);
        //dd($getsapdata);
        if (array_key_exists('Details', $getsapdata)) {
            $getsapdata1 = $getsapdata['Details'];
            if (array_key_exists(0, $getsapdata1) === false) {
                if ($getsapdata['Details']['Reference_ID'] == '') {
			return response()->json([]);
                }
                $getsapdata2[0] = $getsapdata1;
            }
            else{
                $getsapdata2 = $getsapdata1;
            }

            
            if (empty($getsapdata2)) {
                return response()->json([]);
            }
	//	return response()->json([]);
	    return response()->json($getsapdata2);
            	

    }else{
	return response()->json([]);
	}

	}

	public function gethsbcbankpaymenttoprocess()
    {
        $getsapdata1 = [];
        $getsapdata2 = [];
        $getsapdata = $this->step1hsbcprocess();
        if (array_key_exists('Beneficiary_Details', $getsapdata)) {
            $getsapdata1 = $getsapdata['Beneficiary_Details'];
            if (array_key_exists(0, $getsapdata1) === false) {
                $getsapdata2[0] = $getsapdata1;
            }
            else{
                $getsapdata2 = $getsapdata1;
            }
       
        
            $newarr = [];
            if (!empty($getsapdata2)) {
                foreach ($getsapdata2 as $key => $value) {
            if (empty($value['Message_Id'])) {
                        continue;
                    }
                    $msg_id_year = substr($value['Message_Id'],12,4);
                    $msg_id_code = substr($value['Message_Id'],0,2);
                    $msg_id_docno = substr($value['Message_Id'],2,10);
                    $payrefid = $msg_id_year.$msg_id_docno.$msg_id_code;
                    $instrid = $msg_id_year.$msg_id_code.$msg_id_docno;
                    $newarr[$key] = $value;
                    $newarr[$key]['current_date'] = Carbon::now()->toDateString();
                    $newarr[$key]['current_time'] = Carbon::now()->toTimeString();
                    $newarr[$key]['payrefid'] = $payrefid;
                    $newarr[$key]['instrid'] = $instrid;
                    if ($value['Transaction_type'] == 'NEFT') {
                        $hsbctr_type = 'URNS';
                    }
                    if ($value['Transaction_type'] == 'IFT') {
                        $hsbctr_type = 'IMPO';
                    }
                    if ($value['Transaction_type'] == 'RTGS') {
                        $hsbctr_type = 'URGP';
                    }
                    $newarr[$key]['hsbc_trans_type'] = $hsbctr_type;
                    // if(12 >= $key ){
                    //     $val[$key] =  $newarr[$key];
                    //  } 
                }
                Log::info($newarr);
        if (empty($newarr)) {
                    return response()->json([]);
                }
            }
            else{
                return response()->json([]);
            }
            
            //Log::info($val);
            return response()->json($newarr);

            
            

        }
        else{
            return response()->json([]);
        }
        
    }
}
