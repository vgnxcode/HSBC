<?php

namespace vgn\Http\Controllers;
use vgn\hsbc_api_hit;
use Illuminate\Http\Request;
use vgn\Http\Traits\hsbctrait;
use Response;
use Session;
use Crypt;
use Carbon\Carbon;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class HSBCController extends Controller
{
	use hsbctrait;
    public function get_the_datafrom_sap_process()
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
	   
		//dd($getsapdata2);
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
            //dd($newarr);

            return view('HSBC.get_the_datafrom_sap_process')->with(['toprocess' => $newarr]);
            

    	}
    	else{
    		dd('No Data');
    	}
    	//dd($getsapdata2);
    	
    	return view('HSBC.get_the_datafrom_sap_process')->with(['data' => $getsapdata1]);
    }

    public function posttohsbc_instant_receipt(Request $request)
    {
        if (!empty($request->datatopass))
        {
            $datatopass = $request->datatopass;
            Log::info('HSBC SEND DATA '.$datatopass);
            $msgid = $request->msgid;		
            
            if (!empty($msgid))
            {   
                sleep(2);
                // Check if msgid already exists
                $msgExists = hsbc_api_hit::where('msgid', $msgid)->exists();
                if (!$msgExists)				 
                {
                    $hit_status = 0;
                    // Insert data
                    $insertSuccess = hsbc_api_hit::create([
                        'msgid' => $msgid,
                        'hit_status' => $hit_status,
                        'referenceId' => null,
                        'statusCode' => null,
                        'description' => null,
                        'encdec_data' => null,                        
                        'Reversal_Code'  => null,
                        'UTR_NO'  => null,
                        'Message_Source' => null,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

                    if ($insertSuccess) 
                    {
                        Log::info('HSBC hit status insertSuccess '.$insertSuccess);
                        
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
                        
                        $response = curl_exec($curl);
                        Log::info('HSBC RESPONCE DATA '.$response);
                        $err = curl_error($curl);
                        curl_close($curl);
                        
                        if ($err)
                        {
                            echo "cURL Error #:" . $err;
                        } 
                        else
                        {	
                            $response_encode=json_encode($response);
                            $decoded = json_decode($response);

                            // Check if response contains expected fields
                            if (isset($decoded->referenceId, $decoded->statusCode, $decoded->statusDesc))
                            {
                                // Update record
                                $hsbcApiHit = hsbc_api_hit::where('msgid', $msgid)->first();
                                if ($hsbcApiHit) {
                                    $hsbcApiHit->hit_status = 1;
                                    $hsbcApiHit->referenceId = $decoded->referenceId;
                                    $hsbcApiHit->statusCode = $decoded->statusCode;
                                    $hsbcApiHit->description = $decoded->statusDesc;
                                     // Only store encdec_data if statusCode is 'RJCT'
                                    if ($decoded->statusCode === 'RJCT')
                                    {
                                        $hsbcApiHit->encdec_data = $response_encode;
                                    }                                   
                                    $hsbcApiHit->updated_at = now();
                                    $hsbcApiHit->save();
                                    Log::info('HSBC hsbc_api_hit Update '.$hsbcApiHit);
                                }

                                $arr = [];
                                $arr['Transaction_Details']['Message_ID'] = $msgid;
                                $arr['Transaction_Details']['Reference_ID'] = $decoded->referenceId;
                                $arr['Transaction_Details']['Status_Code'] = $decoded->statusCode;
                                $arr['Transaction_Details']['Portal_Indicator'] = 'X';

                                $sendstatustosap = $this->step2hsbcprocess($arr);
                                Log::info('HSBC step2hsbcprocess '.$sendstatustosap);
                                // $response_encode=json_encode($response);
                                echo $response_encode;
                                // return view('HSBC.decrypt_js')->with(['toprocess' => $response_encode]);                             
                                	
                            }
                            else
                            {
                                Log::error("Missing expected data in Decoded response: " . json_decode($response));
                            }
                        }
                    }
                }
            }
        }
    }

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
