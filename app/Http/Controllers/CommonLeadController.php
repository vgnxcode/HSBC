<?php

namespace vgn\Http\Controllers;

use AWS\CRT\HTTP\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use vgn\projectlist;
use vgn\lead_data;
use vgn\crm_leads;
use vgn\verify_form_leads;
use DB;
use vgn\Http\Traits\ameyotrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class CommonLeadController extends Controller
{
    use ameyotrait;
    private $token_url;
    private $lead_url;
    public function __construct()
    {
        // Initialize the properties with their values
        $this->token_url = 'https://www.erprichmond.com/SalesCustomerAPI/api/Lead/GetSecurityToken';
        $this->lead_url = 'https://www.erprichmond.com/SalesCustomerAPI/api/Lead/CreateSalesLead';
    }
    public function leadDataApi(Request $request)
    {
        // Validate the API key
        $apiKey = $request->header('Authorization');

        if ($apiKey !== '4f1e3e5b-ff33-4d62-9c80-3099e9a8a810') {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Retrieve data from the request
        $name = $request->input('name');
        $email = $request->input('email');
        $mobile = $request->input('mobile');
        $project = $request->input('project');
        $enquirySourceId = '92';
        // Call the commonLeadData function
        $result = $this->commonLeadData($name, $email, $mobile, $enquirySourceId, $project);

        // Return a response
        return response()->json(['message' => 'Success', 'result' => $result]);
    }

    // public function commonLead(Request $request)
    // {
    //     $apiKey = $request->header('Authorization');
    //     $apiUser = $request->header('AuthUser');

    //     if ($apiUser=='99acres' && $apiKey == 'vfd4j21al90-gh833-4d62-9c80-30fdh4jas7vb30') {
    //         $enquirySourceId = '60';
    //     } else if ($apiUser=='housing' && $apiKey == 'gl1s9f0xhfn-asnc91-apv5-dsfi5-fmz189q0pwas') {
    //         $enquirySourceId = '61';
    //     } else if ($apiUser=='aglHomeBuilding' && $apiKey == '8c63652a-31c1-4b7e-b0af-86008364fb94') {
    //         $enquirySourceId = '12';
    //     } else if ($apiUser=='aglInteriors' && $apiKey == '4718ddcc-32b7-496b-a7da-27fef11acf72') {
    //         $enquirySourceId = '12';
    //     }

    //     else {
    //         return response()->json(['error' => 'Unauthorized'], 401);
    //     }

    //     $name = $request->input('name');
    //     $email = $request->input('email');
    //     $mobile = $request->input('mobile');
    //     $project_id = $request->input('project_id');
    //     $project_name = $request->input('project_name');

    //     $result = $this->commonLeadData($name, $email, $mobile, $enquirySourceId, $project_name);

    //     return response()->json(['message' => 'Success', 'result' => $result]);
    // }
    public function commonLeadData($name,$email,$mobile,$enquirySourceId,$project,$ccode=null,$interestedIn=null,$redirect_to=null)
    {
        $api_user = 'VGN@In4';
        $api_key = 'E237AF31779C45C1AC0D345C60844450';
        $security_token_response = $this->getSecurityToken($api_user, $api_key);
        $security_token = json_decode($security_token_response)->tokenId;
        if(empty($ccode))
        {
            $ccode = '91';
        }


        $lead_data = array(
            'tokenId' => $security_token,
            // 'title' => 'Mr.',
            'leadFirstName' => $name,
            // 'leadLastName' => $lastname,
            'emailId' => $email,
            'countryCode' => '+'.$ccode,
            'mobileNo' => $mobile,
            'enquirySourceId' => $enquirySourceId,
            'projectName' => $project,
            // 'IntProject' => 12,
            'interestedIn' => $interestedIn,
            // 'leadAddress' => $city,
            // 'dateOfBirth' => $dateOfBirth,
            // 'panNumber' => 'AREFGEDG',
            // 'Probability' => 10,
            // 'websiteURL' => 'vgn.in',
            // 'IntSubProject' => 'Experience Centre',
            // 'FollowUpDate' => 'Mar 02,1983',
            'Category' => 1,
            'Type' => 1
        );
        $lead_creation_response = $this->createSalesLead($security_token, $lead_data);
        // dd($lead_creation_response,$lead_data);
        if(!empty($redirect_to))
        {
            header('location: '.$redirect_to); exit;
        }
        return $lead_creation_response;
    }
    public function getSecurityToken($api_user, $api_key) {
        $token_url = $this->token_url;
        $url = $token_url . '?apiUser=' . urlencode($api_user) . '&apiKey=' . urlencode($api_key);
        $response = $this->executeCurl($url);
        return $response;
    }

    // Function to create a sales lead
    public function createSalesLead($token, $lead_data) {
        $lead_url = $this->lead_url;
        $url = $lead_url;
        $headers = array(
            'Authorization: Bearer ' . $token,
            'Content-Type: application/json',
        );
        $response = $this->executeCurl($url, 'POST', json_encode($lead_data), $headers);
        return $response;
    }

    // Function to execute cURL request
    public function executeCurl($url, $method = 'GET', $data = null, $headers = array()) {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        if ($data !== null) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }
    public function valid_input($input) {
        $input = trim($input);
        $input = stripslashes($input);
        return $input;
    }

    public function brixtonlead(Request $request)
    {

        // $name = $_POST['name'];
        // $phone = $_POST['mobile'];
        // $email = $_POST['email'];

        $name = $request->input('name');
        $email = $request->input('email');
        $mobile = $request->input('mobile');
        $project_code=4101;
        $uniqid = Carbon::now()->format('YmdHis').rand(10,100);
        $source="Website";

        $createddate = Carbon::now()->format('Ymd');
        $createdtime = Carbon::now()->format('His');
        $sapdata = [];
        $sapdata['Name'] = $name;
        $sapdata['Phone'] = $mobile;
        $sapdata['Email_ID'] = $email;
        $sapdata['Project_Code'] = $project_code;
        $sapdata['Source'] = $source;
        $sapdata['Unique_ID'] = $uniqid;
        $sapdata['Created_Date'] = $createddate;
        $sapdata['Created_Time'] = $createdtime;
        $sapdata['emp_id'] ="";

        $response_from_sap = $this->postleaddetails($sapdata);
         if($response_from_sap)
         {

        // Data to be sent
        $data = array(
            'sell_do[form][lead][name]' => $name,
            'sell_do[form][lead][email]' => $email,
            'sell_do[form][lead][phone]' => $mobile,
            'sell_do[form][note][content]' => 'test',
            'api_key' => '336687f208db7dfac702886f436fa0f6',
            'sell_do[campaign][srd]' => '6644b693d4c06616e7b8a991'
        );

        // Headers
        // $headers = array(
        //     'AuthUser: ',
        //     'Authorization: '
        // );

        // API endpoint
        $url = 'https://app.sell.do/api/leads/create';

        // Initialize cURL session
        $curl = curl_init();

        // Set cURL options
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
        // curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        // Execute cURL request
        $response = curl_exec($curl);

        // Check for errors
        if(curl_errno($curl)){
            echo 'cURL error: ' . curl_error($curl);
        }

        // Close cURL session
        curl_close($curl);

        // Output the response
        echo $response;  // you can see this response whether the api working or not.

        // return redirect()->route('home');

        return redirect()->to('https://www.vgn.in/projects/brixton-irungattukottai-chennai-thank-you');

        // header('location: https://www.vgn.in/');

    }
    }


    public function fairmontlead(Request $request)
    {

        $name = $request->input('name');
        $email = $request->input('email');
        $mobile = $request->input('mobile');
        $project_code=4311;
        $uniqid = Carbon::now()->format('YmdHis').rand(10,100);
        $source="Website";

        $createddate = Carbon::now()->format('Ymd');
        $createdtime = Carbon::now()->format('His');
        $sapdata = [];
        $sapdata['Name'] = $name;
        $sapdata['Phone'] = $mobile;
        $sapdata['Email_ID'] = $email;
        $sapdata['Project_Code'] = $project_code;
        $sapdata['Source'] = $source;
        $sapdata['Unique_ID'] = $uniqid;
        $sapdata['Created_Date'] = $createddate;
        $sapdata['Created_Time'] = $createdtime;
        $sapdata['emp_id'] ="";

        $response_from_sap = $this->postleaddetails($sapdata);
         if($response_from_sap)
         {


        $data = array(
            'sell_do[form][lead][name]' => $name,
            'sell_do[form][lead][email]' => $email,
            'sell_do[form][lead][phone]' => $mobile,
            'sell_do[form][note][content]' => 'test',
            'api_key' => '336687f208db7dfac702886f436fa0f6',
            'sell_do[campaign][srd]' => '6641e056e11487e0f19550e7'
        );

        $url = 'https://app.sell.do/api/leads/create';

        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($curl);

        if(curl_errno($curl)){
            echo 'cURL error: ' . curl_error($curl);
        }

        curl_close($curl);

        echo $response;

        return redirect()->to('https://www.vgn.in/projects/fairmont-guindy-chennai-thank-you');
    }
    }

    public function richmondlead(Request $request)
    {
       
        $name = $request->input('name');
        $email = $request->input('email');
        $mobile = $request->input('mobile');
        $project_code=4410;
        $uniqid = Carbon::now()->format('YmdHis').rand(10,100);
        $source="Website";

     

        $createddate = Carbon::now()->format('Ymd');
        $createdtime = Carbon::now()->format('His');

        $sapdata = [];
        $sapdata['Name'] = $name;
        $sapdata['Phone'] = $mobile;
        $sapdata['Email_ID'] = $email;
        $sapdata['Project_Code'] = $project_code;
        $sapdata['Source'] = $source;
        $sapdata['Unique_ID'] = $uniqid;
        $sapdata['Created_Date'] = $createddate;
        $sapdata['Created_Time'] = $createdtime;
        $sapdata['emp_id'] ="";

        $response_from_sap = $this->postleaddetails($sapdata);
         if($response_from_sap)
         {




        $data = array(
            'sell_do[form][lead][name]' => $name,
            'sell_do[form][lead][email]' => $email,
            'sell_do[form][lead][phone]' => $mobile,
            'sell_do[form][note][content]' => 'test',
            'api_key' => '336687f208db7dfac702886f436fa0f6',
            'sell_do[campaign][srd]' => '67481979e11487ad5d9d50f9'
        );

        $url = 'https://app.sell.do/api/leads/create';

        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($curl);

        if(curl_errno($curl)){
            echo 'cURL error: ' . curl_error($curl);
        }

        curl_close($curl);

        // echo $response;

        return redirect()->to('https://www.vgn.in/projects/richmond-towers-guindy-chennai-thank-you');
    }
    }

    public function richmondleadgoogle(Request $request)
    {
        $name = $request->input('name');
        $email = $request->input('email');
        $mobile = $request->input('mobile');
        $project_code=4410;
        $uniqid = Carbon::now()->format('YmdHis').rand(10,100);
        $source="google-BM";

        $createddate = Carbon::now()->format('Ymd');
        $createdtime = Carbon::now()->format('His');

        $sapdata = [];
        $sapdata['Name'] = $name;
        $sapdata['Phone'] = $mobile;
        $sapdata['Email_ID'] = $email;
        $sapdata['Project_Code'] = $project_code;
        $sapdata['Source'] = $source;
        $sapdata['Unique_ID'] = $uniqid;
        $sapdata['Created_Date'] = $createddate;
        $sapdata['Created_Time'] = $createdtime;
        $sapdata['emp_id'] ="";

        $response_from_sap = $this->postleaddetails($sapdata);
         if($response_from_sap)
         {
            Log::info("Spotify ", $sapdata);
            return response()->json([
            'status'  => 'success',
            'message' => 'Form Submited successfully!',
            'data'    => $sapdata
            ]);
            return redirect()->to('https://www.vgn.in/richmond-towers-guindy/thank-you-page.html');
         }
    }


    public function richmondleadgoogleifx(Request $request)
    {
        $name = $request->input('name');
        $email = $request->input('email');
        $mobile = $request->input('mobile');
        $project_code=4410;
        $uniqid = Carbon::now()->format('YmdHis').rand(10,100);
        $source="Google-IFX";

        $createddate = Carbon::now()->format('Ymd');
        $createdtime = Carbon::now()->format('His');

        $sapdata = [];
        $sapdata['Name'] = $name;
        $sapdata['Phone'] = $mobile;
        $sapdata['Email_ID'] = $email;
        $sapdata['Project_Code'] = $project_code;
        $sapdata['Source'] = $source;
        $sapdata['Unique_ID'] = $uniqid;
        $sapdata['Created_Date'] = $createddate;
        $sapdata['Created_Time'] = $createdtime;
        $sapdata['emp_id'] ="";

        $response_from_sap = $this->postleaddetails($sapdata);
         if($response_from_sap)
         {
            Log::info("richmondleadgoogleifx ", $sapdata);
            return redirect()->to('https://www.vgn.in/luxury-apartments-in-guindy/thank-you-page.html');
         }
    }





    public function richmondleadgooglespt(Request $request)
    {
        $name = $request->input('name');
        $email = $request->input('email');
        $mobile = $request->input('mobile');
        $project_code=4410;
        $uniqid = Carbon::now()->format('YmdHis').rand(10,100);
        $source="Google-SPT";

        $createddate = Carbon::now()->format('Ymd');
        $createdtime = Carbon::now()->format('His');

        $sapdata = [];
        $sapdata['Name'] = $name;
        $sapdata['Phone'] = $mobile;
        $sapdata['Email_ID'] = $email;
        $sapdata['Project_Code'] = $project_code;
        $sapdata['Source'] = $source;
        $sapdata['Unique_ID'] = $uniqid;
        $sapdata['Created_Date'] = $createddate;
        $sapdata['Created_Time'] = $createdtime;
        $sapdata['emp_id'] ="";

        $response_from_sap = $this->postleaddetails($sapdata);
         if($response_from_sap)
         {
            Log::info("richmondleadgooglespt ", $sapdata);
            return redirect()->to('https://www.vgn.in/luxury-2bhk-and-3bhk-in-guindy/thank-you-page.html');
         }
    }    


     public function richmondleadgoogledmz(Request $request)
    {
        $name = $request->input('name');
        $email = $request->input('email');
        $mobile = $request->input('mobile');
        $project_code=4410;
        $uniqid = Carbon::now()->format('YmdHis').rand(10,100);
        $source="Google-DMT";

        $createddate = Carbon::now()->format('Ymd');
        $createdtime = Carbon::now()->format('His');

        $sapdata = [];
        $sapdata['Name'] = $name;
        $sapdata['Phone'] = $mobile;
        $sapdata['Email_ID'] = $email;
        $sapdata['Project_Code'] = $project_code;
        $sapdata['Source'] = $source;
        $sapdata['Unique_ID'] = $uniqid;
        $sapdata['Created_Date'] = $createddate;
        $sapdata['Created_Time'] = $createdtime;
        $sapdata['emp_id'] ="";

        $response_from_sap = $this->postleaddetails($sapdata);
         if($response_from_sap)
         {
            Log::info("richmondleadgoogle-dmz ", $sapdata);
            return redirect()->to('https://www.vgn.in/luxury-2-and-3bhk-apartment-in-guindy/thank-you-page.html');
         }
    }

        //seattleleadgoogle landing page
      public function seattlelead(Request $request)
    {
        $name = $request->input('name');
        $email = $request->input('email');
        $mobile = $request->input('mobile');
        $project_code=5301;
        $uniqid = Carbon::now()->format('YmdHis').rand(10,100);
        $source="google";

        $createddate = Carbon::now()->format('Ymd');
        $createdtime = Carbon::now()->format('His');

        $sapdata = [];
        $sapdata['Name'] = $name;
        $sapdata['Phone'] = $mobile;
        $sapdata['Email_ID'] = $email;
        $sapdata['Project_Code'] = $project_code;
        $sapdata['Source'] = $source;
        $sapdata['Unique_ID'] = $uniqid;
        $sapdata['Created_Date'] = $createddate;
        $sapdata['Created_Time'] = $createdtime;
        $sapdata['emp_id'] ="";

        $response_from_sap = $this->postleaddetails($sapdata);
         if($response_from_sap)
         {
            Log::info("seattle lead from website ", $sapdata);
            return redirect()->to('https://www.vgn.in/projects/seattle-mogappair-chennai');
         }
    }


    //seattleleadgoogle landing page
      public function seattleleadgoogle(Request $request)
    {
        $name = $request->input('name');
        $email = $request->input('email');
        $mobile = $request->input('mobile');
        $project_code=5301;
        $uniqid = Carbon::now()->format('YmdHis').rand(10,100);
        $source="google-MB";

        $createddate = Carbon::now()->format('Ymd');
        $createdtime = Carbon::now()->format('His');

        $sapdata = [];
        $sapdata['Name'] = $name;
        $sapdata['Phone'] = $mobile;
        $sapdata['Email_ID'] = $email;
        $sapdata['Project_Code'] = $project_code;
        $sapdata['Source'] = $source;
        $sapdata['Unique_ID'] = $uniqid;
        $sapdata['Created_Date'] = $createddate;
        $sapdata['Created_Time'] = $createdtime;
        $sapdata['emp_id'] ="";

        $response_from_sap = $this->postleaddetails($sapdata);
         if($response_from_sap)
         {
            Log::info("seattle lead from google landing page - MB ", $sapdata);
            return redirect()->to('https://www.vgn.in/vgn-seattle-mogappair/thank-you.html');
         }
    }


       public function seattleleadgoogleifx(Request $request)
    {
        $name = $request->input('name');
        $email = $request->input('email');
        $mobile = $request->input('mobile');
        $project_code=5301;
        $uniqid = Carbon::now()->format('YmdHis').rand(10,100);
        $source="google-IFX";

        $createddate = Carbon::now()->format('Ymd');
        $createdtime = Carbon::now()->format('His');

        $sapdata = [];
        $sapdata['Name'] = $name;
        $sapdata['Phone'] = $mobile;
        $sapdata['Email_ID'] = $email;
        $sapdata['Project_Code'] = $project_code;
        $sapdata['Source'] = $source;
        $sapdata['Unique_ID'] = $uniqid;
        $sapdata['Created_Date'] = $createddate;
        $sapdata['Created_Time'] = $createdtime;
        $sapdata['emp_id'] ="";

        $response_from_sap = $this->postleaddetails($sapdata);
         if($response_from_sap)
         {
            Log::info("seattle lead from google landing page - IFX ", $sapdata);
            return redirect()->to('https://www.vgn.in/luxury-apartments-in-mogappair/thank-you.html');
         }
    }


       public function seattleleadgoogledmz(Request $request)
    {
        $name = $request->input('name');
        $email = $request->input('email');
        $mobile = $request->input('mobile');
        $project_code=5301;
        $uniqid = Carbon::now()->format('YmdHis').rand(10,100);
        $source="google-DMT";

        $createddate = Carbon::now()->format('Ymd');
        $createdtime = Carbon::now()->format('His');

        $sapdata = [];
        $sapdata['Name'] = $name;
        $sapdata['Phone'] = $mobile;
        $sapdata['Email_ID'] = $email;
        $sapdata['Project_Code'] = $project_code;
        $sapdata['Source'] = $source;
        $sapdata['Unique_ID'] = $uniqid;
        $sapdata['Created_Date'] = $createddate;
        $sapdata['Created_Time'] = $createdtime;
        $sapdata['emp_id'] ="";

        $response_from_sap = $this->postleaddetails($sapdata);
         if($response_from_sap)
         {
            Log::info("seattle lead from google landing page - dmz ", $sapdata);
            return redirect()->to('https://www.vgn.in/luxury-3bhk-apartments-in-mogappair/thank-you.html');
         }
    }


    //spotify

    public function richmondleadspotify(Request $request)
    {
        $name = $request->input('name');
        $email = $request->input('email');
        $mobile = $request->input('mobile');
        $project_code=4410;
        $uniqid = Carbon::now()->format('YmdHis').rand(10,100);
        $source="spotify";

        $createddate = Carbon::now()->format('Ymd');
        $createdtime = Carbon::now()->format('His');

        $sapdata = [];
        $sapdata['Name'] = $name;
        $sapdata['Phone'] = $mobile;
        $sapdata['Email_ID'] = $email;
        $sapdata['Project_Code'] = $project_code;
        $sapdata['Source'] = $source;
        $sapdata['Unique_ID'] = $uniqid;
        $sapdata['Created_Date'] = $createddate;
        $sapdata['Created_Time'] = $createdtime;
        $sapdata['emp_id'] ="";

        $response_from_sap = $this->postleaddetails($sapdata);
         if($response_from_sap)
         {
            return redirect()->to('https://www.vgn.in/richmond-towers-guindy-spotify/thank-you-page.html');
         }
    }
    //spotify end


    public function kensingtonlead(Request $request)
    {

        $name = $request->input('name');
        $email = $request->input('email');
        $mobile = $request->input('mobile');
        $project_code=4041;
        $uniqid = Carbon::now()->format('YmdHis').rand(10,100);
        $source="Website";

        $createddate = Carbon::now()->format('Ymd');
        $createdtime = Carbon::now()->format('His');
        $sapdata = [];
        $sapdata['Name'] = $name;
        $sapdata['Phone'] = $mobile;
        $sapdata['Email_ID'] = $email;
        $sapdata['Project_Code'] = $project_code;
        $sapdata['Source'] = $source;
        $sapdata['Unique_ID'] = $uniqid;
        $sapdata['Created_Date'] = $createddate;
        $sapdata['Created_Time'] = $createdtime;
        $sapdata['emp_id'] ="";

        $response_from_sap = $this->postleaddetails($sapdata);
         if($response_from_sap)
         {


        $data = array(
            'sell_do[form][lead][name]' => $name,
            'sell_do[form][lead][email]' => $email,
            'sell_do[form][lead][phone]' => $mobile,
            'sell_do[form][note][content]' => 'test',
            'api_key' => '336687f208db7dfac702886f436fa0f6',
            'sell_do[campaign][srd]' => '661f6d66e11487d2c203629a'
        );

        $url = 'https://app.sell.do/api/leads/create';

        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($curl);

        if(curl_errno($curl)){
            echo 'cURL error: ' . curl_error($curl);
        }

        curl_close($curl);

        echo $response;

        return redirect()->to('https://www.vgn.in/projects/kensington-towers-guindy-chennai-thank-you');
     }
    }


     public function marblelead(Request $request)
    {

        $name = $request->input('name');
        $email = $request->input('email');
        $mobile = $request->input('mobile');
        $project_code=5400;
        $uniqid = Carbon::now()->format('YmdHis').rand(10,100);
        $source="Website";

        $createddate = Carbon::now()->format('Ymd');
        $createdtime = Carbon::now()->format('His');
        $sapdata = [];
        $sapdata['Name'] = $name;
        $sapdata['Phone'] = $mobile;
        $sapdata['Email_ID'] = $email;
        $sapdata['Project_Code'] = $project_code;
        $sapdata['Source'] = $source;
        $sapdata['Unique_ID'] = $uniqid;
        $sapdata['Created_Date'] = $createddate;
        $sapdata['Created_Time'] = $createdtime;
        $sapdata['emp_id'] ="";

        $response_from_sap = $this->postleaddetails($sapdata);
         if($response_from_sap)
         {

        $data = array(
            'sell_do[form][lead][name]' => $name,
            'sell_do[form][lead][email]' => $email,
            'sell_do[form][lead][phone]' => $mobile,
            'sell_do[form][note][content]' => 'test',
            'api_key' => '336687f208db7dfac702886f436fa0f6',
            'sell_do[campaign][srd]' => '65d874e70d1851eb9c517d55'
        );

        $url = 'https://app.sell.do/api/leads/create';

        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($curl);

        if(curl_errno($curl)){
            echo 'cURL error: ' . curl_error($curl);
        }

        curl_close($curl);

        echo $response;

        return redirect()->to('https://www.vgn.in/projects/marble-arch-tambaram-chennai-thank-you');
    }
    }


     public function nottinglead(Request $request)
    {

        $name = $request->input('name');
        $email = $request->input('email');
        $mobile = $request->input('mobile');
        $project_code=4100;
        $uniqid = Carbon::now()->format('YmdHis').rand(10,100);
        $source="Website";

        $createddate = Carbon::now()->format('Ymd');
        $createdtime = Carbon::now()->format('His');
        $sapdata = [];
        $sapdata['Name'] = $name;
        $sapdata['Phone'] = $mobile;
        $sapdata['Email_ID'] = $email;
        $sapdata['Project_Code'] = $project_code;
        $sapdata['Source'] = $source;
        $sapdata['Unique_ID'] = $uniqid;
        $sapdata['Created_Date'] = $createddate;
        $sapdata['Created_Time'] = $createdtime;
        $sapdata['emp_id'] ="";

        $response_from_sap = $this->postleaddetails($sapdata);
         if($response_from_sap)
         {

        $data = array(
            'sell_do[form][lead][name]' => $name,
            'sell_do[form][lead][email]' => $email,
            'sell_do[form][lead][phone]' => $mobile,
            'sell_do[form][note][content]' => 'test',
            'api_key' => '336687f208db7dfac702886f436fa0f6',
            'sell_do[campaign][srd]' => '6644b693d4c06616e7b8a990'
        );

        $url = 'https://app.sell.do/api/leads/create';

        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($curl);

        if(curl_errno($curl)){
            echo 'cURL error: ' . curl_error($curl);
        }

        curl_close($curl);

        echo $response;

        return redirect()->to('https://www.vgn.in/projects/notting-hill-nungambakkam-chennai-thank-you');
    }
    }


    public function projectlead(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'mobile' => 'required|digits:10',
            'email' => 'required|email',
            'sourceId' => 'required|integer',
            'c-code' => 'nullable|integer',
        ]);
        if ($validator->fails()) {
            $errorMessage = implode(',', $validator->errors()->all());
            return redirect()->back()->with('error', $errorMessage)->withInput();
        }
        $name = $request->name;
        $mobile = $request->mobile;
        $email = $request->email;
        $project = $request->project;
        $enquirySourceId = $request->sourceId;
        $redirect=null;
        $interestedIn = null;
        $ccode = null;
        if(!empty($request->interestedIn))
        {
            $interestedIn = $request->interestedIn;
        }
        if(!empty($request->redirect))
        {
            $redirect = $request->redirect;
        }
        if(!empty($request->input('c-code')))
        {
            $ccode = $request->input('c-code');
        }
        $result = $this->commonLeadData($name, $email, $mobile, $enquirySourceId, $project, $ccode, $interestedIn, $redirect);

        // dd($result);
    }
    public function interiorlead(Request $request)
    {
        $name = $request->Name;
        $email = $request->Email;
        $mobile = $request->Mobile;
        $project = 'VGN INTERIORS';
        $enquirySourceId = 12;
        $redirect=null;
        $interestedIn = 'VGN INTERIORS';
        $result = $this->commonLeadData($name, $email, $mobile, $enquirySourceId, $project, null, $interestedIn, $redirect);
    }
    function leadintoSAP($name,$email,$mobile,$enquirySourceId,$project)
    {
        switch ($project) {
            case 'VGN FAIRMONT':
            {
                $tablename = '0000002821_4311';
                $pname = 'Fairmont';
                break;
            }
            case 'VGN KENSINGTON TOWERS':
            {
                $tablename = '0000002822_4041';
                $pname = 'Kensington Towers';
                break;
            }
            case 'VGN BRIXTON':
            {
                $tablename = '0000002823_4101';
                $pname = 'Brixton';
                break;
            }
            case 'VGN NOTTING HILL':
            {
                $tablename = '0000002824_4100';
                $pname = 'Notting Hill';
                break;
            }
            default:
            {
                return 'Not a valid project';
            }
        }
        $leaddttime = date('Y-m-d H:i:s');
        $pidtime = uniqid().mt_rand(1, 1000);
        $newlist =  projectlist::where('Project_name','=',$pname)->get();

        $list =  projectlist::find($newlist[0]['id']);

        if(empty($list)) {
            return redirect()->route('home');
        }else{
            $id = $list['id'];
        }
        $insert = DB::connection('mysql2')->table($tablename)->insert(
            ['PID' => $pidtime, 'Project_name' => $pname,'Name'=> preg_replace("/[^A-Za-z.?! ]/","",$name),
            'Email' => $email, 'Mobile' => $mobile, 'City' => 'Null',
            'msg'=>null, 'lead_datetime' => $leaddttime, 'inserteddate' => date('Y-m-d H:i:s')]
        );

        $lead = new lead_data();
        $lead->Project_id = $id;
        $lead->PID = $pidtime;
        $lead->Project_name = $list->Project_name;
        $lead->Source_type = 'Chatbot';
        $lead->Name = preg_replace("/[^A-Za-z.?! ]/","",$name);
        $lead->Email = $email;
        $lead->Mobile = $mobile;
        $lead->City = 'Null';
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
    }

    // public function interakt(Request $request)
    // {

    //     $apiKey = $request->header('Authorization');
    //     $apiUser = $request->header('AuthUser');

    //     if ($apiUser=='interakt' && $apiKey == 'vfd4j21al90-gh833-5555-9c80-30fdh4jas7vb30')
    //     {
    //         dd($request);
    //     }
    //     else
    //     {
    //         return response()->json(['error' => 'Unauthorized'], 401);
    //     }

    // }

    public function commonLead(Request $request)
    {
        $apiKey = $request->header('Authorization');
        $apiUser = $request->header('AuthUser');

        // dd($request->all(), $request->json()->all());

        // dd($apiKey ,$apiUser );

        // Initialize $enquirySourceId to avoid undefined variable issue
        $enquirySourceId = null;

        if ($apiUser == '99acres' && $apiKey == 'vfd4j21al90-gh833-4d62-9c80-30fdh4jas7vb30') {
            $enquirySourceId = '99acres';
            $project_id = "4410";
        } elseif ($apiUser == 'housing' && $apiKey == 'gl1s9f0xhfn-asnc91-apv5-dsfi5-fmz189q0pwas') {
            $enquirySourceId = 'housing';
            $project_id = "4410";
        }
        elseif ($apiUser == 'magicbricks' && $apiKey == '102bc76b10fff6f32dc6d87d1da13e69e63545a7') {
            $enquirySourceId = 'magicbricks';
            $project_id = "4410";
        }
        elseif ($apiUser == 'kenyt' && $apiKey == '8c63652a-31c1-4b7e-b0af-86008364fb94'){
            $enquirySourceId = 'kenyt';
            $project_id = "4410";
        }
        elseif ($apiUser == 'kenyt-seattle' && $apiKey == '8c63652a-31c1-4b7e-b0af-86008364fb90s'){
            $enquirySourceId = 'kenyt-seattle';
            $project_id = "5301";
         }
        elseif ($apiUser == '99acres_seattle' && $apiKey == 'vfd4j21al90-gh833-4d62-9c80-30fdh4jas7v5301s')
        {
        $enquirySourceId = '99acres_seattle';
        $project_id = "5301";
        }
        else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        if (!empty($enquirySourceId)) {
            $name = $request->input('name');
            $email = $request->input('email');
            $mobile = $request->input('mobile');
            // $project_id = $request->input('project_id');
            $project_name = $request->input('project_name');
            $uniqid = Carbon::now()->format('YmdHis') . rand(10, 100);
            $source = $enquirySourceId;
            

            $createddate = Carbon::now()->format('Ymd');
            $createdtime = Carbon::now()->format('His');
            $emp_id ="";


            $sapdata = [
                'Name' => $name,
                'Phone' => $mobile,
                'Email_ID' => $email,
                'Project_Code' => $project_id,
                'Source' => $source,
                'Unique_ID' => $uniqid,
                'Created_Date' => $createddate,
                'Created_Time' => $createdtime,
                'emp_id' => $emp_id
            ];

            $response_from_sap = $this->postleaddetails($sapdata);

            if ($response_from_sap) {

                Log::info("Successfully lead captured", ['message' => 'Success', 'result' => $sapdata]);
                return response()->json(['message' => 'Success', 'result' => $sapdata]);

            } else {
                Log::error(" lead captured Failed", ['message' => 'Failed to save lead details']);
                return response()->json(['message' => 'Failed to save lead details'], 500);
            }
        }

        return response()->json(['error' => 'Invalid Data'], 400);
    }




    public function fetchInteraktData()
    {
        $url = 'https://api.interakt.ai/v1/public/apis/users/?offset=0&limit=100';



        $headers = [
            'Authorization: Basic bU9ZQm5iM3ltRnZhOXA0YnEtZm9rMU9qS2dFN0FQaVdEZW94aXlzVllUczo=',
            'Content-Type: application/json',
        ];


        $from = Carbon::yesterday('Asia/Kolkata')->startOfDay()->toIso8601ZuluString();
        $to = Carbon::now('Asia/Kolkata')->endOfDay()->toIso8601ZuluString();



        $postData = json_encode([
            'filters' => [
                [
                    'trait' => 'created_at_utc',
                    'op' => 'gt',
                    //'val' => Carbon::now()->format('Y-m-d-H-i-s')
                    'val' => $from

                ],
                [
                    'trait' => 'created_at_utc',
                    'op' => 'lt',
                    'supr_op' => 'and',
                    // 'val' => Carbon::now()->addDay()->format('Y-m-d-H-i-s')
                    'val' => $to
                ]
            ]
        ]);

        // Make API request to Interakt
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);

        $response = curl_exec($ch);
        curl_close($ch);

        $data = json_decode($response, true);

        if (isset($data['data']['customers'])) {
            $customers = $data['data']['customers'];
            $processedCustomers = [];

            foreach ($customers as $customer) {

                $uniqid = $customer['id'];
                $name = $customer['traits']['name'] ?? 'N/A';
                $mobile = $customer['phone_number'];
                $email = $customer['traits']['email'] ?? 'N/A';
                $project_id = "4410"; // Example project ID (modify as needed)
                $source = "Interakt"; // Example source (modify as needed)
                $uniqid = $uniqid; // Generate unique ID
                $createddate = Carbon::now()->format('Ymd');
                $createdtime = Carbon::now()->format('His');
                $emp_id ="";

                // Prepare SAP Data
                $sapdata = [
                    'Name' => $name,
                    'Phone' => $mobile,
                    'Email_ID' => $email,
                    'Project_Code' => $project_id,
                    'Source' => $source,
                    'Unique_ID' => $uniqid,
                    'Created_Date' => $createddate,
                    'Created_Time' => $createdtime,
                    'emp_id' => $emp_id
                ];

                // Send Data to SAP
                $response_from_sap = $this->postleaddetails($sapdata);
                Log::info("Successfully lead captured", $response_from_sap);

                if ($response_from_sap) {
                    Log::info("Successfully lead captured", ['message' => 'Success', 'result' => $sapdata]);
                } else {
                    Log::error("Lead capture failed", ['message' => 'Failed to save lead details']);
                }

                $processedCustomers[] = $sapdata;
            }

            return response()->json(['message' => 'Success', 'result' => $processedCustomers]);
        }

        return response()->json(['message' => 'No customers found'], 404);
    }




public function fetch_facebook_Static()
{
    // Map form IDs to their corresponding Source names
    $formMap = [
        '1970515327117463' => 'BM Static Lead',
        // '982514913431099'  => 'BM Video Lead',
        '1351934699626150' => 'BM Carousel Lead',
    ];

    //old accesstoken : EAAJEYScgmcgBO7ZB17VEJHnhxtQOrLyY4e2vF6eSjjHWD3dYkjkyZCIF1xePBQWw4uUlhc3gG4ME4QaJWwbkIxdHVEnyz16hjYBPkmg2YZBcJzw0QRzThZBeus7nRs0XUiObVGeWp6qjpK5vfCKXGnmQD3l1WZBOMZBR4A0TWH7J89K9NN1jHvQTzH
    $accessToken = 'EAAJ013mTB8cBPsWpsad8CvyrtRWqUYZCO9G47NMI0PZCP3FzQpZBkBDhuvEy4m6SktvNZC0LG9sX3MdGZAUNWflRPwH4ZBolZCr5050MK1OikJOvegAo1P7Cs2aLO86HOplNZBSXFH5kvZBVHDJcVX1X8y74j5rGS5DfAZCOmLxyF0FHViD2vfNhK0CYDgg9MMtwZDZD';
    $today = date('Y-m-d');

    foreach ($formMap as $formId => $sourceName) {
        $response = $this->callFacebookApi($formId, $accessToken);
        $leads = json_decode($response, true)['data'] ?? [];

        foreach ($leads as $lead) {
            $fbLeadId = $lead['id'] ?? null;
            $createdTime = $lead['created_time'] ?? null;

            if (!$fbLeadId || !$createdTime || date('Y-m-d', strtotime($createdTime)) !== $today) {
                continue;
            }

            if (crm_leads::where('fb_lead_id', $fbLeadId)->exists()) {
                continue;
            }

            // Map field data
            $fieldMap = collect($lead['field_data'] ?? [])
                ->pluck('values', 'name')
                ->map(function ($item) {
                    return $item[0] ?? null;
                });

            $fullName = $fieldMap['full_name'] ?? null;
            $phone = $fieldMap['phone_number'] ?? null;
            $email = $fieldMap['email'] ?? null;

            $createddate = Carbon::now()->format('Ymd');
            $createdtime = Carbon::now()->format('His');
            $emp_id ="";

            // Insert into DB
            crm_leads::insert([
                'Name'         => $fullName,
                'Phone'        => $phone,
                'Email_ID'     => $email,
                'Project_Code' => '4410',
                'Source'       => $sourceName,
                'fb_lead_id'   => $fbLeadId,
                'Unique_ID'    => $fbLeadId,
                'Created_Date' => $createddate,
                'Created_Time' => $createdtime,
            ]);

            // Send to SAP
            $sapData = [
                'Name'         => $fullName,
                'Phone'        => $phone,
                'Email_ID'     => $email,
                'Project_Code' => '4410',
                'Source'       => $sourceName,
                'Unique_ID'    => $fbLeadId,
                'Created_Date' => $createddate,
                'Created_Time' => $createdtime,
                'emp_id' => $emp_id
            ];

            $sapResponse = $this->postleaddetails($sapData);
            Log::info("Sap Response", $sapResponse);

            if ($sapResponse) {
                Log::info("Lead sent to SAP", $sapData);
            } else {
                Log::error("SAP lead sync failed", $sapData);
            }
        }
    }

    return response()->json(['status' => 'Done']);
}



public function infinix_agency_social_media_campaigns()
{
    // Map form IDs to their corresponding Source names and Project Codes
    $formMap = [
        '1599539091021939' => [
            'source_name'  => 'IFX Static Lead',
            'project_code' => '5301'
        ],
        '1303676968207552' => [
            'source_name'  => 'IFX Carousel Lead',
            'project_code' => '5301'
        ],
        '1362264255390518' => [
            'source_name'  => 'IFX RT Static Lead',
            'project_code' => '4410'
        ],
        '1763601061192132' => [
            'source_name'  => 'IFX RT Carousel Lead',
            'project_code' => '4410'
        ],
    ];

    // Facebook API Access Token
    $accessToken = 'EAAPcynywsNEBPXhTww8YJENKZB6VZBM9v0BUDZAm2z9mtCQDnYumWZBuv3Ycj6AyOex74ZBoMrJA0T9WClT5dfsNKWABgGwVOPeE3aGYpauuSSAqxpZCOKPsYsCvemjDjB8U8ZB15AWYMMk3cr4h31iZCeelZAaDJTdNyRUlZCYD2gaxSxqnn0im3g5q2ciuYo';

    // Today's date
    $today = date('Y-m-d');

    foreach ($formMap as $formId => $details) {
        $sourceName = $details['source_name'];
        $projectCode = $details['project_code'];

        // Call Facebook API
        $response = $this->callFacebookApi($formId, $accessToken);

        $leads = json_decode($response, true)['data'] ?? [];

        foreach ($leads as $lead) {
            $fbLeadId = $lead['id'] ?? null;
            $createdTime = $lead['created_time'] ?? null;

            // Skip if lead ID or created time is missing or not from today
            if (!$fbLeadId || !$createdTime || date('Y-m-d', strtotime($createdTime)) !== $today) {
                continue;
            }

            // Skip if lead already exists
            if (crm_leads::where('fb_lead_id', $fbLeadId)->exists()) {
                continue;
            }

            // Map field data
            $fieldMap = collect($lead['field_data'] ?? [])
                ->pluck('values', 'name')
                ->map(function ($item) {
                    return $item[0] ?? null;
                });

            $fullName = $fieldMap['full_name'] ?? null;
            $phone = $fieldMap['phone'] ?? null;
            $email = $fieldMap['email'] ?? null;

            $createddate = Carbon::now()->format('Ymd');
            $createdtime = Carbon::now()->format('His');
            $emp_id = "";

            // Insert into database
            crm_leads::insert([
                'Name'         => $fullName,
                'Phone'        => $phone,
                'Email_ID'     => $email,
                'Project_Code' => $projectCode,
                'Source'       => $sourceName,
                'fb_lead_id'   => $fbLeadId,
                'Unique_ID'    => $fbLeadId,
                'Created_Date' => $createddate,
                'Created_Time' => $createdtime,
            ]);

            // Prepare data to send to SAP
            $sapData = [
                'Name'         => $fullName,
                'Phone'        => $phone,
                'Email_ID'     => $email,
                'Project_Code' => $projectCode,
                'Source'       => $sourceName,
                'Unique_ID'    => $fbLeadId,
                'Created_Date' => $createddate,
                'Created_Time' => $createdtime,
                'emp_id'       => $emp_id
            ];

            // Send lead data to SAP
            $sapResponse = $this->postleaddetails($sapData);
            Log::info("SAP Response", (array)$sapResponse);

            if ($sapResponse) {
                Log::info("Lead sent to SAP", $sapData);
            } else {
                Log::error("SAP lead sync failed", $sapData);
            }
        }
    }

    return response()->json(['status' => 'Done']);
}


// public function infinix_agency_richmond_social_media_campaigns()
// {  

//     // Map form IDs to their corresponding Source names
//     $formMap = [
//         '1362264255390518' => 'IFX RT Static Lead',
//         '1763601061192132'  => 'IFX RT Carousel Lead',
//     ];

//     //old accesstoken : EAAJEYScgmcgBO7ZB17VEJHnhxtQOrLyY4e2vF6eSjjHWD3dYkjkyZCIF1xePBQWw4uUlhc3gG4ME4QaJWwbkIxdHVEnyz16hjYBPkmg2YZBcJzw0QRzThZBeus7nRs0XUiObVGeWp6qjpK5vfCKXGnmQD3l1WZBOMZBR4A0TWH7J89K9NN1jHvQTzH
//     $accessToken = 'EAAPcynywsNEBPXhTww8YJENKZB6VZBM9v0BUDZAm2z9mtCQDnYumWZBuv3Ycj6AyOex74ZBoMrJA0T9WClT5dfsNKWABgGwVOPeE3aGYpauuSSAqxpZCOKPsYsCvemjDjB8U8ZB15AWYMMk3cr4h31iZCeelZAaDJTdNyRUlZCYD2gaxSxqnn0im3g5q2ciuYo';
//     $today = date('Y-m-d');

//     foreach ($formMap as $formId => $sourceName) {
//         $response = $this->callFacebookApi($formId, $accessToken);

//         $leads = json_decode($response, true)['data'] ?? [];        

//         foreach ($leads as $lead) {
//             $fbLeadId = $lead['id'] ?? null;
//             $createdTime = $lead['created_time'] ?? null;

//             if (!$fbLeadId || !$createdTime || date('Y-m-d', strtotime($createdTime)) !== $today) {
//                 continue;
//             }

//             if (crm_leads::where('fb_lead_id', $fbLeadId)->exists()) {
//                 continue;
//             }

//             // Map field data
//             $fieldMap = collect($lead['field_data'] ?? [])
//                 ->pluck('values', 'name')
//                 ->map(function ($item) {
//                     return $item[0] ?? null;
//                 });

            

//             $fullName = $fieldMap['full_name'] ?? null;
//             $phone = $fieldMap['phone'] ?? null;
//             $email = $fieldMap['email'] ?? null;

//             $createddate = Carbon::now()->format('Ymd');
//             $createdtime = Carbon::now()->format('His');
//             $emp_id ="";

//             // Insert into DB
//             crm_leads::insert([
//                 'Name'         => $fullName,
//                 'Phone'        => $phone,
//                 'Email_ID'     => $email,
//                 'Project_Code' => '4410',
//                 'Source'       => $sourceName,
//                 'fb_lead_id'   => $fbLeadId,
//                 'Unique_ID'    => $fbLeadId,
//                 'Created_Date' => $createddate,
//                 'Created_Time' => $createdtime,
//             ]);

//             // Send to SAP
//             $sapData = [
//                 'Name'         => $fullName,
//                 'Phone'        => $phone,
//                 'Email_ID'     => $email,
//                 'Project_Code' => '4410',
//                 'Source'       => $sourceName,
//                 'Unique_ID'    => $fbLeadId,
//                 'Created_Date' => $createddate,
//                 'Created_Time' => $createdtime,
//                 'emp_id' => $emp_id
//             ];

//             $sapResponse = $this->postleaddetails($sapData);
//             Log::info("Sap Response", $sapResponse);

//             if ($sapResponse) {
//                 Log::info("Lead sent to SAP", $sapData);
//             } else {
//                 Log::error("SAP lead sync failed", $sapData);
//             }
//         }
//     }

//     return response()->json(['status' => 'Done']);
// }


// public function infinix_agency_Seattle_social_media_campaigns()
// {  

//     // Map form IDs to their corresponding Source names
//     $formMap = [
//         '1599539091021939' => 'IFX Static Lead',
//         '1303676968207552'  => 'IFX Carousel Lead',
//     ];

//     //old accesstoken : EAAJEYScgmcgBO7ZB17VEJHnhxtQOrLyY4e2vF6eSjjHWD3dYkjkyZCIF1xePBQWw4uUlhc3gG4ME4QaJWwbkIxdHVEnyz16hjYBPkmg2YZBcJzw0QRzThZBeus7nRs0XUiObVGeWp6qjpK5vfCKXGnmQD3l1WZBOMZBR4A0TWH7J89K9NN1jHvQTzH
//     $accessToken = 'EAAPcynywsNEBPXhTww8YJENKZB6VZBM9v0BUDZAm2z9mtCQDnYumWZBuv3Ycj6AyOex74ZBoMrJA0T9WClT5dfsNKWABgGwVOPeE3aGYpauuSSAqxpZCOKPsYsCvemjDjB8U8ZB15AWYMMk3cr4h31iZCeelZAaDJTdNyRUlZCYD2gaxSxqnn0im3g5q2ciuYo';
//     $today = date('Y-m-d');

//     foreach ($formMap as $formId => $sourceName) {
//         $response = $this->callFacebookApi($formId, $accessToken);

//         $leads = json_decode($response, true)['data'] ?? [];        

//         foreach ($leads as $lead) {
//             $fbLeadId = $lead['id'] ?? null;
//             $createdTime = $lead['created_time'] ?? null;

//             if (!$fbLeadId || !$createdTime || date('Y-m-d', strtotime($createdTime)) !== $today) {
//                 continue;
//             }

//             if (crm_leads::where('fb_lead_id', $fbLeadId)->exists()) {
//                 continue;
//             }

//             // Map field data
//             $fieldMap = collect($lead['field_data'] ?? [])
//                 ->pluck('values', 'name')
//                 ->map(function ($item) {
//                     return $item[0] ?? null;
//                 });

            

//             $fullName = $fieldMap['full_name'] ?? null;
//             $phone = $fieldMap['phone'] ?? null;
//             $email = $fieldMap['email'] ?? null;

//             $createddate = Carbon::now()->format('Ymd');
//             $createdtime = Carbon::now()->format('His');
//             $emp_id ="";

//             // Insert into DB
//             crm_leads::insert([
//                 'Name'         => $fullName,
//                 'Phone'        => $phone,
//                 'Email_ID'     => $email,
//                 'Project_Code' => '5301',
//                 'Source'       => $sourceName,
//                 'fb_lead_id'   => $fbLeadId,
//                 'Unique_ID'    => $fbLeadId,
//                 'Created_Date' => $createddate,
//                 'Created_Time' => $createdtime,
//             ]);

//             // Send to SAP
//             $sapData = [
//                 'Name'         => $fullName,
//                 'Phone'        => $phone,
//                 'Email_ID'     => $email,
//                 'Project_Code' => '5301',
//                 'Source'       => $sourceName,
//                 'Unique_ID'    => $fbLeadId,
//                 'Created_Date' => $createddate,
//                 'Created_Time' => $createdtime,
//                 'emp_id' => $emp_id
//             ];

//             $sapResponse = $this->postleaddetails($sapData);
//             Log::info("Sap Response", $sapResponse);

//             if ($sapResponse) {
//                 Log::info("Lead sent to SAP", $sapData);
//             } else {
//                 Log::error("SAP lead sync failed", $sapData);
//             }
//         }
//     }

//     return response()->json(['status' => 'Done']);
// }



// public function spt_agency_richmond_social_media_campaigns()
// {  

//     // Map form IDs to their corresponding Source names
//     $formMap = [
//         '776198535009069' => 'SPT Static Leads',
//         '1346656093716785' => 'SPT Carousel Lead',
//         '626304690351873 ' => 'SPT Carousel OTP Lead',
//     ];

//     //old accesstoken : EAAJEYScgmcgBO7ZB17VEJHnhxtQOrLyY4e2vF6eSjjHWD3dYkjkyZCIF1xePBQWw4uUlhc3gG4ME4QaJWwbkIxdHVEnyz16hjYBPkmg2YZBcJzw0QRzThZBeus7nRs0XUiObVGeWp6qjpK5vfCKXGnmQD3l1WZBOMZBR4A0TWH7J89K9NN1jHvQTzH
//     $accessToken = 'EAALFI84FPeABPah8wbxUOXuQ0iZBkeVEjRGR7o3dPtes0jlM7g63kWCSLArcPCEqZB0TgTAByDSl9MrDks5a9nd4WmmZBAXODVoEmqbJCxHEdRZCQLXhfYZAWMTwbeo2kZAba9ZBS1PRCb7lLVONl5KsxXju4UmZAQyEsv4M9TgYfA3uOKZAkRgZBWze0iAmYVTetk';
//     $today = date('Y-m-d');

//     foreach ($formMap as $formId => $sourceName) {
//         $response = $this->callFacebookApi($formId, $accessToken);

//         $leads = json_decode($response, true)['data'] ?? [];        

//         foreach ($leads as $lead) {
//             $fbLeadId = $lead['id'] ?? null;
//             $createdTime = $lead['created_time'] ?? null;

//             if (!$fbLeadId || !$createdTime || date('Y-m-d', strtotime($createdTime)) !== $today) {
//                 continue;
//             }

//             if (crm_leads::where('fb_lead_id', $fbLeadId)->exists()) {
//                 continue;
//             }

//             // Map field data
//             $fieldMap = collect($lead['field_data'] ?? [])
//                 ->pluck('values', 'name')
//                 ->map(function ($item) {
//                     return $item[0] ?? null;
//                 });

            

//             $fullName = $fieldMap['full_name'] ?? null;
//             $phone = $fieldMap['phone'] ?? null;
//             $email = $fieldMap['email'] ?? null;

//             $createddate = Carbon::now()->format('Ymd');
//             $createdtime = Carbon::now()->format('His');
//             $emp_id ="";

//             // Insert into DB
//             crm_leads::insert([
//                 'Name'         => $fullName,
//                 'Phone'        => $phone,
//                 'Email_ID'     => $email,
//                 'Project_Code' => '4410',
//                 'Source'       => $sourceName,
//                 'fb_lead_id'   => $fbLeadId,
//                 'Unique_ID'    => $fbLeadId,
//                 'Created_Date' => $createddate,
//                 'Created_Time' => $createdtime,
//             ]);

//             // Send to SAP
//             $sapData = [
//                 'Name'         => $fullName,
//                 'Phone'        => $phone,
//                 'Email_ID'     => $email,
//                 'Project_Code' => '4410',
//                 'Source'       => $sourceName,
//                 'Unique_ID'    => $fbLeadId,
//                 'Created_Date' => $createddate,
//                 'Created_Time' => $createdtime,
//                 'emp_id' => $emp_id
//             ];

//             $sapResponse = $this->postleaddetails($sapData);
//             Log::info("Sap Response", $sapResponse);

//             if ($sapResponse) {
//                 Log::info("Lead sent to SAP", $sapData);
//             } else {
//                 Log::error("SAP lead sync failed", $sapData);
//             }
//         }
//     }

//     return response()->json(['status' => 'Done']);
// }


// public function spt_agency_ma_fm_social_media_campaigns()
// {  

//     // Map form IDs to their corresponding Source names
//     $formMap = [
//         '1449148072870718' => 'SPT MA Static Lead' => '5400',
//         '1112994810322841 ' => 'SPT FM Static Lead'=> '4311',
//     ];

//     //old accesstoken : EAAJEYScgmcgBO7ZB17VEJHnhxtQOrLyY4e2vF6eSjjHWD3dYkjkyZCIF1xePBQWw4uUlhc3gG4ME4QaJWwbkIxdHVEnyz16hjYBPkmg2YZBcJzw0QRzThZBeus7nRs0XUiObVGeWp6qjpK5vfCKXGnmQD3l1WZBOMZBR4A0TWH7J89K9NN1jHvQTzH
//     $accessToken = 'EAALFI84FPeABPah8wbxUOXuQ0iZBkeVEjRGR7o3dPtes0jlM7g63kWCSLArcPCEqZB0TgTAByDSl9MrDks5a9nd4WmmZBAXODVoEmqbJCxHEdRZCQLXhfYZAWMTwbeo2kZAba9ZBS1PRCb7lLVONl5KsxXju4UmZAQyEsv4M9TgYfA3uOKZAkRgZBWze0iAmYVTetk';
//     $today = date('Y-m-d');

//     foreach ($formMap as $formId => $sourceName) {
//         $response = $this->callFacebookApi($formId, $accessToken);

//         $leads = json_decode($response, true)['data'] ?? [];        

//         foreach ($leads as $lead) {
//             $fbLeadId = $lead['id'] ?? null;
//             $createdTime = $lead['created_time'] ?? null;

//             if (!$fbLeadId || !$createdTime || date('Y-m-d', strtotime($createdTime)) !== $today) {
//                 continue;
//             }

//             if (crm_leads::where('fb_lead_id', $fbLeadId)->exists()) {
//                 continue;
//             }

//             // Map field data
//             $fieldMap = collect($lead['field_data'] ?? [])
//                 ->pluck('values', 'name')
//                 ->map(function ($item) {
//                     return $item[0] ?? null;
//                 });

            

//             $fullName = $fieldMap['full_name'] ?? null;
//             $phone = $fieldMap['phone'] ?? null;
//             $email = $fieldMap['email'] ?? null;

//             $createddate = Carbon::now()->format('Ymd');
//             $createdtime = Carbon::now()->format('His');
//             $emp_id ="";

//             // Insert into DB
//             crm_leads::insert([
//                 'Name'         => $fullName,
//                 'Phone'        => $phone,
//                 'Email_ID'     => $email,
//                 'Project_Code' => '4410',
//                 'Source'       => $sourceName,
//                 'fb_lead_id'   => $fbLeadId,
//                 'Unique_ID'    => $fbLeadId,
//                 'Created_Date' => $createddate,
//                 'Created_Time' => $createdtime,
//             ]);

//             // Send to SAP
//             $sapData = [
//                 'Name'         => $fullName,
//                 'Phone'        => $phone,
//                 'Email_ID'     => $email,
//                 'Project_Code' => '4410',
//                 'Source'       => $sourceName,
//                 'Unique_ID'    => $fbLeadId,
//                 'Created_Date' => $createddate,
//                 'Created_Time' => $createdtime,
//                 'emp_id' => $emp_id
//             ];

//             $sapResponse = $this->postleaddetails($sapData);
//             Log::info("Sap Response", $sapResponse);

//             if ($sapResponse) {
//                 Log::info("Lead sent to SAP", $sapData);
//             } else {
//                 Log::error("SAP lead sync failed", $sapData);
//             }
//         }
//     }

//     return response()->json(['status' => 'Done']);
// }



public function spt_agency_social_media_campaigns()
{  
        // Map form IDs to their corresponding Source names and Project Codes
        $formMap = [
        '1449148072870718' => [
            'source_name'  => 'SPT MA Static Lead',
            'project_code' => '5400'
        ],
        '1112994810322841' => [
            'source_name'  => 'SPT FM Static Lead',
            'project_code' => '4311'
        ],
        '776198535009069' => [
            'source_name'  => 'SPT Static Leads',
            'project_code' => '4410'
        ],
        '1346656093716785' => [
            'source_name'  => 'SPT Carousel Lead',
            'project_code' => '4410'
        ],
        '626304690351873' => [
            'source_name'  => 'SPT Carousel OTP Lead',
            'project_code' => '4410'
        ],
    ];


    // Facebook API Access Token
    $accessToken = 'EAALFI84FPeABPah8wbxUOXuQ0iZBkeVEjRGR7o3dPtes0jlM7g63kWCSLArcPCEqZB0TgTAByDSl9MrDks5a9nd4WmmZBAXODVoEmqbJCxHEdRZCQLXhfYZAWMTwbeo2kZAba9ZBS1PRCb7lLVONl5KsxXju4UmZAQyEsv4M9TgYfA3uOKZAkRgZBWze0iAmYVTetk';
    
    // Today's date in 'Y-m-d' format
    $today = date('Y-m-d');

    foreach ($formMap as $formId => $details) {
        $sourceName = $details['source_name'];
        $projectCode = $details['project_code'];

        // Call Facebook API for the form ID
        $response = $this->callFacebookApi($formId, $accessToken);

        $leads = json_decode($response, true)['data'] ?? [];

        

        foreach ($leads as $lead) {
            $fbLeadId = $lead['id'] ?? null;
            $createdTime = $lead['created_time'] ?? null;

            // Skip if lead ID or created time is missing
            if (!$fbLeadId || !$createdTime || date('Y-m-d', strtotime($createdTime)) !== $today) {
                continue;
            }

            // Skip if lead already exists in database
            if (crm_leads::where('fb_lead_id', $fbLeadId)->exists()) {
                continue;
            }

            // Extract field data from the lead
            $fieldMap = collect($lead['field_data'] ?? [])
                ->pluck('values', 'name')
                ->map(function ($item) {
                    return $item[0] ?? null;
                });

            $fullName = $fieldMap['full_name'] ?? null;
            $phone = $fieldMap['phone'] ?? null;
            $email = $fieldMap['email'] ?? null;

            $createddate = Carbon::now()->format('Ymd');
            $createdtime = Carbon::now()->format('His');
            $emp_id = "";

            // Insert lead into the database
            crm_leads::insert([
                'Name'         => $fullName,
                'Phone'        => $phone,
                'Email_ID'     => $email,
                'Project_Code' => $projectCode, 
                'Source'       => $sourceName,
                'fb_lead_id'   => $fbLeadId,
                'Unique_ID'    => $fbLeadId,
                'Created_Date' => $createddate,
                'Created_Time' => $createdtime,
            ]);

            // Prepare data for SAP
            $sapData = [
                'Name'         => $fullName,
                'Phone'        => $phone,
                'Email_ID'     => $email,
                'Project_Code' => $projectCode, 
                'Source'       => $sourceName,
                'Unique_ID'    => $fbLeadId,
                'Created_Date' => $createddate,
                'Created_Time' => $createdtime,
                'emp_id'       => $emp_id
            ];

            // Send lead to SAP
            $sapResponse = $this->postleaddetails($sapData);
            Log::info("SAP Response", (array)$sapResponse);

            if ($sapResponse) {
                Log::info("Lead sent to SAP", $sapData);
            } else {
                Log::error("SAP lead sync failed", $sapData);
            }
        }
    }

    return response()->json(['status' => 'Done']);
}





//Digital Mantraaz Agency 
// public function dmt_agency_richmond_social_media_campaigns()
// {    

//     // Map form IDs to their corresponding Source names
//     $formMap = [
//         '2020264352117933' => 'DMT FM Static Lead',
//         '1481784576402371' => 'DMT MA Static Lead',5400
//         '1440439387217515' => 'DMT Static Three Lead', 4410
//         '807131675158895' => 'DMT Carousel Lead',4410
//         '769988909169348' => 'DMT Static Two Lead',4410
//         '2947524252100844' => 'DMT Static One Lead',4410
//     ];

//     //old accesstoken : EAAJEYScgmcgBO7ZB17VEJHnhxtQOrLyY4e2vF6eSjjHWD3dYkjkyZCIF1xePBQWw4uUlhc3gG4ME4QaJWwbkIxdHVEnyz16hjYBPkmg2YZBcJzw0QRzThZBeus7nRs0XUiObVGeWp6qjpK5vfCKXGnmQD3l1WZBOMZBR4A0TWH7J89K9NN1jHvQTzH
//     $accessToken = 'EAAP6u9b9djYBPYSDHa5OogUhfDeZANbXeUai30xTTUk063EE2ZCWlZBRSRPjjxsd7OHIpt5y980qrNGJj4Hk0ZB8eXVuTwRWX3co4l31teEbh8EeNd8q7poumkea3ZCGqTMTBp2WZAVuvZAU7qcEU3ib9ipZBmogztGxZBEeQrmNobHax3ZAd2x7VRO91fUbjHxpan';
//     $today = date('Y-m-d');   

//     foreach ($formMap as $formId => $sourceName) {
//         $response = $this->callFacebookApi($formId, $accessToken);

//         $leads = json_decode($response, true)['data'] ?? [];        

//         foreach ($leads as $lead) {
//             $fbLeadId = $lead['id'] ?? null;
//             $createdTime = $lead['created_time'] ?? null;            

//             if (!$fbLeadId || !$createdTime || date('Y-m-d', strtotime($createdTime)) !== $today) {
//                 continue;
//             }

//             if (crm_leads::where('fb_lead_id', $fbLeadId)->exists()) {
//                 continue;
//             }

//             // Map field data
//             $fieldMap = collect($lead['field_data'] ?? [])
//                 ->pluck('values', 'name')
//                 ->map(function ($item) {
//                     return $item[0] ?? null;
//                 });

            

//             $fullName = $fieldMap['full_name'] ?? null;
//             $phone = $fieldMap['phone'] ?? null;
//             $email = $fieldMap['email'] ?? null;

//             $createddate = Carbon::now()->format('Ymd');
//             $createdtime = Carbon::now()->format('His');
//             $emp_id ="";

            

//             // Insert into DB
//             crm_leads::insert([
//                 'Name'         => $fullName,
//                 'Phone'        => $phone,
//                 'Email_ID'     => $email,
//                 'Project_Code' => '4410',
//                 'Source'       => $sourceName,
//                 'fb_lead_id'   => $fbLeadId,
//                 'Unique_ID'    => $fbLeadId,
//                 'Created_Date' => $createddate,
//                 'Created_Time' => $createdtime,
//             ]);

//             // Send to SAP
//             $sapData = [
//                 'Name'         => $fullName,
//                 'Phone'        => $phone,
//                 'Email_ID'     => $email,
//                 'Project_Code' => '4410',
//                 'Source'       => $sourceName,
//                 'Unique_ID'    => $fbLeadId,
//                 'Created_Date' => $createddate,
//                 'Created_Time' => $createdtime,
//                 'emp_id' => $emp_id
//             ];

//             $sapResponse = $this->postleaddetails($sapData);
//             Log::info("Sap Response", $sapResponse);

//             if ($sapResponse) {
//                 Log::info("Lead sent to SAP", $sapData);
//             } else {
//                 Log::error("SAP lead sync failed", $sapData);
//             }
//         }
//     }

//     return response()->json(['status' => 'Done']);
// }


public function dmt_agency_social_media_campaigns()
{    
    // Map form IDs to their corresponding Source names and Project Codes
    $formMap = [
        '2020264352117933' => [
            'source_name'  => 'DMT FM Static Lead',
            'project_code' => '4311'
        ],
        '1481784576402371' => [
            'source_name'  => 'DMT MA Static Lead',
            'project_code' => '5400'
        ],
        '1440439387217515' => [
            'source_name'  => 'DMT Static Three Lead',
            'project_code' => '4410'
        ],
        '807131675158895' => [
            'source_name'  => 'DMT Carousel Lead',
            'project_code' => '4410'
        ],
        '769988909169348' => [
            'source_name'  => 'DMT Static Two Lead',
            'project_code' => '4410'
        ],
        '2947524252100844' => [
            'source_name'  => 'DMT Static One Lead',
            'project_code' => '4410'
        ],
         '1871666547117007' => [
            'source_name'  => 'DMT Carousel-2 Lead',
            'project_code' => '4410'
        ],
    ];

    // Facebook API Access Token
    $accessToken = 'EAAP6u9b9djYBPYSDHa5OogUhfDeZANbXeUai30xTTUk063EE2ZCWlZBRSRPjjxsd7OHIpt5y980qrNGJj4Hk0ZB8eXVuTwRWX3co4l31teEbh8EeNd8q7poumkea3ZCGqTMTBp2WZAVuvZAU7qcEU3ib9ipZBmogztGxZBEeQrmNobHax3ZAd2x7VRO91fUbjHxpan';
    $today = date('Y-m-d');   

    foreach ($formMap as $formId => $details) {
        $sourceName = $details['source_name'];
        $projectCode = $details['project_code'];

        // Call Facebook API
        $response = $this->callFacebookApi($formId, $accessToken);

        $leads = json_decode($response, true)['data'] ?? [];        

        foreach ($leads as $lead) {
            $fbLeadId = $lead['id'] ?? null;
            $createdTime = $lead['created_time'] ?? null;            

            if (!$fbLeadId || !$createdTime || date('Y-m-d', strtotime($createdTime)) !== $today) {
                continue;
            }

            if (crm_leads::where('fb_lead_id', $fbLeadId)->exists()) {
                continue;
            }

            // Map field data
            $fieldMap = collect($lead['field_data'] ?? [])
                ->pluck('values', 'name')
                ->map(function ($item) {
                    return $item[0] ?? null;
                });

            $fullName = $fieldMap['full_name'] ?? null;
            $phone = $fieldMap['phone'] ?? null;
            $email = $fieldMap['email'] ?? null;

            $createddate = Carbon::now()->format('Ymd');
            $createdtime = Carbon::now()->format('His');
            $emp_id = "";

            // Insert into DB
            crm_leads::insert([
                'Name'         => $fullName,
                'Phone'        => $phone,
                'Email_ID'     => $email,
                'Project_Code' => $projectCode,
                'Source'       => $sourceName,
                'fb_lead_id'   => $fbLeadId,
                'Unique_ID'    => $fbLeadId,
                'Created_Date' => $createddate,
                'Created_Time' => $createdtime,
            ]);

            // Send to SAP
            $sapData = [
                'Name'         => $fullName,
                'Phone'        => $phone,
                'Email_ID'     => $email,
                'Project_Code' => $projectCode,
                'Source'       => $sourceName,
                'Unique_ID'    => $fbLeadId,
                'Created_Date' => $createddate,
                'Created_Time' => $createdtime,
                'emp_id'       => $emp_id
            ];

            $sapResponse = $this->postleaddetails($sapData);
            Log::info("SAP Response", (array)$sapResponse);

            if ($sapResponse) {
                Log::info("Lead sent to SAP", $sapData);
            } else {
                Log::error("SAP lead sync failed", $sapData);
            }
        }
    }

    return response()->json(['status' => 'Done']);
}


public function fetch_facebook_Static_Coasta_marblearch()
{   //blackmount
    // Map form IDs to their corresponding Source names and Project Codes
    $formMap = [
        '1091345499470635' => ['source' => 'Facebook VGN Marble Arch ', 'project_code' => '5400'],
        '1092155319448375' => ['source' => 'Facebook VGN Coasta', 'project_code' => '4107'],
        '9593680590727069' => ['source' => 'Facebook VGN Duplex', 'project_code' => '4311'],
        '2329385797461671' => ['source' => 'Facebook VGN Notting Hill', 'project_code' => '4100'],
        '735130005881880' =>  ['source' => 'Facebook VGN Seattle', 'project_code' => '5301'],            
    ];

    //$accessToken = 'EAAJEYScgmcgBO8ZCIH5hZAkvmbZCMWga8dLy3ZBRVNTcBQmW3V9BYMuVtFVO3kCWiMrB6M2rif4IkiZALeWzUQhwm44Tatp7h1BIeNDfzqc9t9ZBmRH3f7Ei9ZB6wlsUvZAXZBmuqV1RHleETiS7mhtYsEdLFPUt9MZCOftEX51c2t6KZCacDiOZC423R8jO6wDHrtro';
    $accessToken ='EAAJ013mTB8cBPsWpsad8CvyrtRWqUYZCO9G47NMI0PZCP3FzQpZBkBDhuvEy4m6SktvNZC0LG9sX3MdGZAUNWflRPwH4ZBolZCr5050MK1OikJOvegAo1P7Cs2aLO86HOplNZBSXFH5kvZBVHDJcVX1X8y74j5rGS5DfAZCOmLxyF0FHViD2vfNhK0CYDgg9MMtwZDZD';
    $today = date('Y-m-d');

    foreach ($formMap as $formId => $config) {
        $sourceName = $config['source'];
        $projectCode = $config['project_code'];

        $response = $this->callFacebookApi($formId, $accessToken);
        $leads = json_decode($response, true)['data'] ?? [];

        foreach ($leads as $lead) {
            $fbLeadId = $lead['id'] ?? null;
            $createdTime = $lead['created_time'] ?? null;

            if (!$fbLeadId || !$createdTime || date('Y-m-d', strtotime($createdTime)) !== $today) {
                continue;
            }

            if (crm_leads::where('fb_lead_id', $fbLeadId)->exists()) {
                continue;
            }

            // Map field data
            $fieldMap = collect($lead['field_data'] ?? [])
                ->pluck('values', 'name')
                ->map(function ($item) {
                    return $item[0] ?? null;
                });

            $fullName = $fieldMap['full_name'] ?? null;
            $phone = $fieldMap['phone'] ?? null;
            $email = $fieldMap['email'] ?? null;

            $createddate = Carbon::now()->format('Ymd');
            $createdtime = Carbon::now()->format('His');
            $emp_id ="";

            // Insert into DB
            crm_leads::insert([
                'Name'         => $fullName,
                'Phone'        => $phone,
                'Email_ID'     => $email,
                'Project_Code' => $projectCode,
                'Source'       => $sourceName,
                'fb_lead_id'   => $fbLeadId,
                'Unique_ID'    => $fbLeadId,
                'Created_Date' => $createddate,
                'Created_Time' => $createdtime,
            ]);

            // Send to SAP
            $sapData = [
                'Name'         => $fullName,
                'Phone'        => $phone,
                'Email_ID'     => $email,
                'Project_Code' => $projectCode,
                'Source'       => $sourceName,
                'Unique_ID'    => $fbLeadId,
                'Created_Date' => $createddate,
                'Created_Time' => $createdtime,
                'emp_id' => $emp_id
            ];

            $sapResponse = $this->postleaddetails($sapData);
            Log::info("Sap Response", $sapResponse);

            if ($sapResponse) {
                Log::info("Lead sent to SAP", $sapData);
            } else {
                Log::error("SAP lead sync failed", $sapData);
            }
        }
    }

    return response()->json(['status' => 'Done']);
}


public function fetch_facebook_Seattle()
{
    // Map form IDs to their corresponding Source names and Project Codes
    $formMap = [       
        '778825017906477' =>  ['source' => 'Facebook VGN Seattle Static', 'project_code' => '5301'],   
        '1271857887708285' =>  ['source' => 'Facebook VGN Seattle Carousel ', 'project_code' => '5301'],          
    ];

    //$accessToken = 'EAAJEYScgmcgBO8ZCIH5hZAkvmbZCMWga8dLy3ZBRVNTcBQmW3V9BYMuVtFVO3kCWiMrB6M2rif4IkiZALeWzUQhwm44Tatp7h1BIeNDfzqc9t9ZBmRH3f7Ei9ZB6wlsUvZAXZBmuqV1RHleETiS7mhtYsEdLFPUt9MZCOftEX51c2t6KZCacDiOZC423R8jO6wDHrtro';
    $accessToken ='EAAKqajhFLhEBPtyu7jsZBWDScUCxHlCJiIHBe11YWFyI0zuvUPKrt0s5nEmaMbw9FZB7esGng2LWBhbo3tA2DwGigPd6gD86eTV9zvt1wlZCEYVm23moBaGpHGJ667IVD0a8SVBP0wMrGqMLTRzBSAAzCLc6GC6YUXmommMimFIKSi6zAvhgTrBiV28BwZDZD';
    $today = date('Y-m-d');
    

    foreach ($formMap as $formId => $config) {
        $sourceName = $config['source'];
        $projectCode = $config['project_code'];

        $response = $this->callFacebookApi($formId, $accessToken);
        $leads = json_decode($response, true)['data'] ?? [];

        foreach ($leads as $lead) {
            $fbLeadId = $lead['id'] ?? null;
            $createdTime = $lead['created_time'] ?? null;

            if (!$fbLeadId || !$createdTime || date('Y-m-d', strtotime($createdTime)) !== $today) {
                continue;
            }

            if (crm_leads::where('fb_lead_id', $fbLeadId)->exists()) {
                continue;
            }

            // Map field data
            $fieldMap = collect($lead['field_data'] ?? [])
                ->pluck('values', 'name')
                ->map(function ($item) {
                    return $item[0] ?? null;
                });

            $fullName = $fieldMap['full_name'] ?? null;
            $phone = $fieldMap['phone'] ?? null;
            $email = $fieldMap['email'] ?? null;

            $createddate = Carbon::now()->format('Ymd');
            $createdtime = Carbon::now()->format('His');
            $emp_id ="";

            // Insert into DB
            crm_leads::insert([
                'Name'         => $fullName,
                'Phone'        => $phone,
                'Email_ID'     => $email,
                'Project_Code' => $projectCode,
                'Source'       => $sourceName,
                'fb_lead_id'   => $fbLeadId,
                'Unique_ID'    => $fbLeadId,
                'Created_Date' => $createddate,
                'Created_Time' => $createdtime,
            ]);

            // Send to SAP
            $sapData = [
                'Name'         => $fullName,
                'Phone'        => $phone,
                'Email_ID'     => $email,
                'Project_Code' => $projectCode,
                'Source'       => $sourceName,
                'Unique_ID'    => $fbLeadId,
                'Created_Date' => $createddate,
                'Created_Time' => $createdtime,
                'emp_id' => $emp_id
            ];

            $sapResponse = $this->postleaddetails($sapData);
            Log::info("Sap Response", $sapResponse);

            if ($sapResponse) {
                Log::info("Lead sent to SAP", $sapData);
            } else {
                Log::error("SAP lead sync failed", $sapData);
            }
        }
    }

    return response()->json(['status' => 'Done']);
}



private function callFacebookApi($form_id, $access_token)
{
    $url = "https://graph.facebook.com/v19.0/{$form_id}/leads?access_token={$access_token}";

    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 10,
    ]);

    $response = curl_exec($curl);
    curl_close($curl);

    return $response;
}

//calling945 new incoming call details save into sap
public function calling945_newincoming_call_data(Request $request)
{
    if (!$request->filled('leadid_incoming')) {
        return response()->json([
            'status' => 'error',
            'message' => 'Missing leadid_incoming'
        ], 400);
    }

    $id = $request->input('leadid_incoming');

    // Get the lead data by ID
    $getleaddata = DB::table('tata_inbond_call')
        ->where('id', $id)
        ->select('caller')
        ->first();

    // If no lead data found, return early
    if (!$getleaddata) {
        return response()->json([
            'status' => 'error',
            'message' => 'Lead not found'
        ], 404);
    }

    // Extract data from request
    $emp_id       = $request->input('emp_id');
    $name       = $request->input('leadName');
    $email      = $request->input('leademail');
    $mobile     = $getleaddata->caller;
    $input = $request->input('leadproject');
    if (strpos($input, '-') !== false) {
    list($plant, $project_id) = explode('-', $input, 2);
    $plant = trim($plant);
    $project_id = trim($project_id);
} else {
    // fallback if input doesn't contain a dash
    $plant = null;
    $project_id = null;
}
    $source     = $request->input('leadsource');

    // Generate unique values
    $uniqid      = Carbon::now()->format('YmdHis') . rand(10, 100);
    $createddate = Carbon::now()->format('Ymd');
    $createdtime = Carbon::now()->format('His');

    // Update the existing row
    $updateStatus = DB::table('tata_inbond_call')
        ->where('id', $id)
        ->update([
            'lead_Name'    => $name,
            'Lead_Number'  => $uniqid,
            'Lead_source'  => $source,
             'plan' => $plant,
            'project' => $project_id,

        ]);

    if (!$updateStatus) {
        return response()->json([
            'status' => 'error',
            'message' => 'Update failed'
        ], 500);
    }

    // Prepare SAP data
    $sapdata = [

        'Name'         => $name,
        'Phone'        => $mobile,
        'Email_ID'     => $email,
        'Project_Code' => $plant,
        'Source'       => $source,
        'Unique_ID'    => $uniqid,
        'Created_Date' => $createddate,
        'Created_Time' => $createdtime,
        'emp_id' => $emp_id
    ];

    // Send data to SAP
    $response_from_sap = $this->postleaddetails($sapdata);

    if ($response_from_sap) {
   $sapLeadId = $response_from_sap['SAP_Lead_ID'] ?? null;

         //update the lead id

            $updateStatus = DB::table('tata_inbond_call')
        ->where('id', $id)
        ->update([
            'Lead_Number'    => $sapLeadId,
        ]);

        Log::info("Successfully lead captured", ['result' => $sapdata]);
log::info("getting lead no" , ['result' => $response_from_sap]);
        return response()->json([
            'status' => 'success',
            'message' => 'Lead data stored successfully',
            'data' => $sapdata
        ]);
    } else {
        Log::error("Lead capture failed", ['message' => 'Failed to save lead details']);

        return response()->json([
            'status' => 'error',
            'message' => 'Failed to save lead details'
        ], 500);
    }
}


public function verify_enquiry(Request $request)
{
    // Get request values
    $name          = $request->input('name');
    $email         = $request->input('email');
  $interested_in = $request->input('interested_in') ?? "No-Data";

    $mobile        = $request->input('mobile');
    $otp = rand(100000, 999999);

    // Save to DB
    verify_form_leads::insert([
        'name'          => $name,
        'email'         => $email,
        'interestedIn'  => $interested_in,
        'mobile'        => $mobile,
        'otp'           => $otp,
        'verify-status' => 0,  
        'log'           => now(),
    ]);


    // Send OTP via your SMS function
    //$smscontent = "Dear $name, Your Vendor Login Forgot Password OTP is $otp - VGN Projects Estates.";
    $smscontent = "Dear $name, Your OTP for VGN Lead form submission is $otp. Do not share this code with anyone.";
    $this->sendSms($smscontent, $mobile);

    // Return JSON response
    return response()->json([
        'status'  => 'success',
        'message' => 'Form submitted successfully!',
        'data'    => $request->all()
    ]);
}




   private function sendSms($message, $mobileno)
{
        $fullurl = "https://api-alerts.kaleyra.com/v4/";
        $fields = [
            'api_key' => 'A8ef4022b54eff4bb372e8b140507f763',
            'method'  => 'sms',
            'message' => $message,
            'to'      => $mobileno,
            'sender'  => 'VGNOTP'
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $fullurl);
        curl_setopt($ch, CURLOPT_POST, count($fields));
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($fields));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }


    public function verify_otp(Request $request)
    {

    $otp    = $request->input('otp');
    $mobile = $request->input('mno'); // must be sent from AJAX

    // Find the latest OTP for this mobile number
    $record = verify_form_leads::where('mobile', $mobile)
                ->orderBy('log', 'desc')
                ->first();

    if (!$record) {
        return response()->json([
            'status'  => 'error',
            'message' => 'Mobile number not found.',
        ]);
    }

    if ($record->otp != $otp) {
        return response()->json([
            'status'  => 'error',
            'message' => 'Invalid OTP. Please try again.',
        ]);
    }

    // Mark as verified
    $record->update([
        'verify-status' => 1
    ]);

    return response()->json([
        'status'  => 'success',
        'message' => 'OTP verified successfully!',
        'data'    => $record
    ]);
        
    }





}
