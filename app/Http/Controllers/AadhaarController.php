<?php

namespace vgn\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use DB;

class AadhaarController extends Controller
{

    public function generateotpinaadhaarkyc($aadhaarno)
    {
        $curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://kyc-api.aadhaarkyc.io/api/v1/aadhaar-v2/generate-otp',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'{
    "id_number": "'.$aadhaarno.'"
}',
  CURLOPT_HTTPHEADER => array(
    'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE2MjA2NTA3MTYsIm5iZiI6MTYyMDY1MDcxNiwianRpIjoiMTU2Zjc4MGItZTZmYS00OGZlLWI4ZGYtYzA4ODY4NjRhMWFiIiwiZXhwIjoxOTM2MDEwNzE2LCJpZGVudGl0eSI6ImRldi52Z25AYWFkaGFhcmFwaS5pbyIsImZyZXNoIjpmYWxzZSwidHlwZSI6ImFjY2VzcyIsInVzZXJfY2xhaW1zIjp7InNjb3BlcyI6WyJyZWFkIl19fQ.8sXRQhme05BYvnTYCaWSRKIOJq1fuJR3Qdxm6QkWNLs',
    'Content-Type: application/json'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
$decoded_resp = json_decode($response);
return $decoded_resp;
    }


    public function submitotpinaadhaarkyc($clientid, $OTP)
    {
        $curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://kyc-api.aadhaarkyc.io/api/v1/aadhaar-v2/submit-otp',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'{
    "client_id": "'.$clientid.'",
    "otp": "'.$OTP.'"
}',
  CURLOPT_HTTPHEADER => array(
    'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE2MjA2NTA3MTYsIm5iZiI6MTYyMDY1MDcxNiwianRpIjoiMTU2Zjc4MGItZTZmYS00OGZlLWI4ZGYtYzA4ODY4NjRhMWFiIiwiZXhwIjoxOTM2MDEwNzE2LCJpZGVudGl0eSI6ImRldi52Z25AYWFkaGFhcmFwaS5pbyIsImZyZXNoIjpmYWxzZSwidHlwZSI6ImFjY2VzcyIsInVzZXJfY2xhaW1zIjp7InNjb3BlcyI6WyJyZWFkIl19fQ.8sXRQhme05BYvnTYCaWSRKIOJq1fuJR3Qdxm6QkWNLs',
    'Content-Type: application/json'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
$decoded_resp = json_decode($response);

return $decoded_resp;
    }

    public function gentop(Request $request){
    	$resp = json_encode($request->all());
	Log::info('Rest adapter generate aadhaar otp request '.json_encode($resp));
        $vgndecode = json_decode($resp, true);
        //dd($vgndecode);
        $aadhaarno = $vgndecode['Aadhar_Number'];
        if ($aadhaarno != '') {
          
            $getaadhaarotpdata = $this->generateotpinaadhaarkyc($aadhaarno);
            
            DB::connection('mysql3')->table('aadhaarverified')->insert([
                'id' => null,
                'aadhaar_no' => $aadhaarno,
                'status_code' => $getaadhaarotpdata->status_code,
                'type' => 'Generate',
                'created_time' => Carbon::now()->toDateTimeString()
            ]);

            if ($getaadhaarotpdata->status_code == 200) {
               return json_encode(['Client_ID' => $getaadhaarotpdata->data->client_id,'Status_Code' => $getaadhaarotpdata->status_code, 'OTP_Sent'=> $getaadhaarotpdata->data->otp_sent, 'Valid_Aadhaar'=> $getaadhaarotpdata->data->valid_aadhaar ]); 
            }
            else{
                return json_encode(['Client_ID' => null,'Status_Code' => $getaadhaarotpdata->status_code, 'OTP_Sent'=> false, 'Valid_Aadhaar'=> false ]);
            }
        }
        
    	
        
    	 return json_encode(['Client_ID' => null,'Status_Code' => 422, 'OTP_Sent'=> false, 'Valid_Aadhaar'=> false ]);
    }

     public function submitotp(Request $request)
    {
    	$resp = json_encode($request->all());
    	//Log::info('Rest adapter submit aadhaar response '.json_encode($resp));
        $vgndecode = json_decode($resp, true);
        //dd($vgndecode);
        $clientid = $vgndecode['Client_ID'];
        $OTP = $vgndecode['OTP'];

        if (($clientid != '') && ($OTP != '')) {
            $submitaadhaarotpdata = $this->submitotpinaadhaarkyc($clientid, $OTP);                       

            if ($submitaadhaarotpdata->status_code == 200) {
                DB::connection('mysql3')->table('aadhaarverified')->insert([
                'id' => null,
                'aadhaar_no' => $submitaadhaarotpdata->data->aadhaar_number,
                'type' => 'Submit',
                'status_code' => $submitaadhaarotpdata->status_code,
                'created_time' => Carbon::now()->toDateTimeString()
            ]);

               return json_encode([
                'Name' => $submitaadhaarotpdata->data->full_name,
                'Aadhaar_No' => $submitaadhaarotpdata->data->aadhaar_number,
                'DOB'=> $submitaadhaarotpdata->data->dob,
                'Gender'=> $submitaadhaarotpdata->data->gender,
                'Country'=> $submitaadhaarotpdata->data->address->country,
                'District'=> $submitaadhaarotpdata->data->address->dist,
                'State'=> $submitaadhaarotpdata->data->address->state,
                'PO'=> $submitaadhaarotpdata->data->address->po,
                'LOC'=> $submitaadhaarotpdata->data->address->loc,
                'VTC'=> $submitaadhaarotpdata->data->address->vtc,
                'Subdist'=> $submitaadhaarotpdata->data->address->subdist,
                'Street'=> $submitaadhaarotpdata->data->address->street,
                'House'=> $submitaadhaarotpdata->data->address->house,
                'Landmark'=> $submitaadhaarotpdata->data->address->landmark,
                'PIN_Code'=> $submitaadhaarotpdata->data->zip,
                'Status_Code'=> $submitaadhaarotpdata->status_code,
                'Message'=> $submitaadhaarotpdata->message,
                'Message_Code'=> $submitaadhaarotpdata->message_code
                 ]); 
            }
            else{
                DB::connection('mysql3')->table('aadhaarverified')->insert([
                'id' => null,
                'aadhaar_no' => null,
                'type' => 'Submit',
                'status_code' => $submitaadhaarotpdata->status_code,
                'created_time' => Carbon::now()->toDateTimeString()
            ]);

                return json_encode([
                'Name' => '',
                'Aadhaar_No' => '',
                'DOB'=> '',
                'Gender'=> '',
                'Country'=> '',
                'District'=> '',
                'State'=> '',
                'PO'=> '',
                'LOC'=> '',
                'VTC'=> '',
                'Subdist'=> '',
                'Street'=> '',
                'House'=> '',
                'Landmark'=> '',
                'PIN_Code'=> '',
                'Status_Code'=> $submitaadhaarotpdata->status_code,
                'Message'=> $submitaadhaarotpdata->message,
                'Message_Code'=> $submitaadhaarotpdata->message_code
                 ]);
            }
        }

    	


        return json_encode([
                'Name' => '',
                'Aadhaar_No' => '',
                'DOB'=> '',
                'Gender'=> '',
                'Country'=> '',
                'District'=> '',
                'State'=> '',
                'PO'=> '',
                'LOC'=> '',
                'VTC'=> '',
                'Subdist'=> '',
                'Street'=> '',
                'House'=> '',
                'Landmark'=> '',
                'PIN_Code'=> '',
                'Status_Code'=> 422,
                'Message'=> '',
                'Message_Code'=> ''
                 ]);

    }

public function getip(Request $request){

$ipfetch = $request->server('HTTP_X_FORWARDED_FOR');
$ismobile = $request->server('HTTP_CLOUDFRONT_IS_MOBILE_VIEWER');
$isdesktop = $request->server('HTTP_CLOUDFRONT_IS_DESKTOP_VIEWER');
$requestdetails = ['iprequested' => $ipfetch, 'ismobile' => $ismobile, 'isdesktop' => $isdesktop];
dd($requestdetails);


}
}

