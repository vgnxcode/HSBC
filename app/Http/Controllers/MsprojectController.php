<?php

namespace vgn\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MsprojectController extends Controller
{

    public function generate_access_token()
    {
        $curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://login.microsoftonline.com/1db0506a-6ccd-43a8-b324-092d7167f14e/oauth2/v2.0/token",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "client_id=45342cdb-aa7d-403f-af61-0f990555c8f2&scope=https://graph.microsoft.com/.default&client_secret=1b8K7~nWuIc45cPWms.S5_106R22ufyKM.&grant_type=client_credentials",
  CURLOPT_HTTPHEADER => array(
    "cache-control: no-cache",
    "content-type: application/x-www-form-urlencoded",
    "postman-token: acb66896-d5e2-ae71-60b2-2598886e0e47",
    "sdkversion: postman-graph/v1.0"
  ),
));

//dd($curl);

$response = curl_exec($curl);

return $response;

$err = curl_error($curl);

curl_close($curl);

if ($err) {
  //echo "cURL Error #:" . $err;
    return 0;
} else {
  return json_decode($response, true);
}
    }

    public function update_percentage($token, $itemid, $percentage, $siteid, $listid)
    {
        $curl = curl_init();
        $bearer = "Bearer $token";

        //return "https://graph.microsoft.com/v1.0/sites/".$siteid."/lists/".$listid."/items/".$itemid;

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://graph.microsoft.com/v1.0/sites/".$siteid."/lists/".$listid."/items/".$itemid."/fields",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "PATCH",
  CURLOPT_POSTFIELDS => '{ "PERCENT_COMPLETE": '.$percentage.'  }',
  CURLOPT_HTTPHEADER => array(
    "authorization: $bearer",
    "cache-control: no-cache",
    "content-type: application/json",
    "postman-token: acb66896-d5e2-ae71-60b2-2598886e0e47",
    "sdkversion: postman-graph/v1.0",

  ),
));

//dd($curl);

$response = curl_exec($curl);

return $response;

$err = curl_error($curl);

curl_close($curl);

if ($err) {
  //echo "cURL Error #:" . $err;
    return 0;
} else {
  return json_decode($response, true);
}
    }


    public function fetchstetdatefrom_msp($token, $url)
    {
      
      
        $curl = curl_init();
        $bearer = "Bearer $token";

        //return "https://graph.microsoft.com/v1.0/sites/".$siteid."/lists/".$listid."/items/".$itemid;

curl_setopt_array($curl, array(
  CURLOPT_URL => $url,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => array(
    "authorization: $bearer",
    "cache-control: no-cache",
    "content-type: application/json",
    "postman-token: acb66896-d5e2-ae71-60b2-2598886e0e47",
    "sdkversion: postman-graph/v1.0",

  ),
));

//dd($curl);

$response = curl_exec($curl);

return json_decode($response, true);

$err = curl_error($curl);

curl_close($curl);

if ($err) {
  //echo "cURL Error #:" . $err;
    return 0;
} else {
  return json_decode($response, true);
}
    }


    // FUNCTION TO MUNG THE XML SO WE DO NOT HAVE TO DEAL WITH NAMESPACE
    public function mungXML($xml)
{
    //dd($xml);
    $obj = SimpleXML_Load_String($xml);
    if ($obj === FALSE) return $xml;

    // GET NAMESPACES, IF ANY
    $nss = $obj->getNamespaces(TRUE);
    if (empty($nss)) return $xml;

    // CHANGE ns: INTO ns_
    $nsm = array_keys($nss);
    foreach ($nsm as $key)
    {
        // A REGULAR EXPRESSION TO MUNG THE XML
        $rgx
        = '#'               // REGEX DELIMITER
        . '('               // GROUP PATTERN 1
        . '\<'              // LOCATE A LEFT WICKET
        . '/?'              // MAYBE FOLLOWED BY A SLASH
        . preg_quote($key)  // THE NAMESPACE
        . ')'               // END GROUP PATTERN
        . '('               // GROUP PATTERN 2
        . ':{1}'            // A COLON (EXACTLY ONE)
        . ')'               // END GROUP PATTERN
        . '#'               // REGEX DELIMITER
        ;
        // INSERT THE UNDERSCORE INTO THE TAG NAME
        $rep
        = '$1'          // BACKREFERENCE TO GROUP 1
        . '_'           // LITERAL UNDERSCORE IN PLACE OF GROUP 2
        ;
        // PERFORM THE REPLACEMENT
        $xml =  preg_replace($rgx, $rep, $xml);
    }
    return $xml;
}

    public function msproject_update_percentage()
    {


        $response = file_get_contents("php://input");

        //Log::info($response);

        $response = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $response);
        $xml = new \SimpleXMLElement($response);
$body = $xml->xpath('//SOAPBody')[0];
$array = json_decode(json_encode((array)$body), TRUE); 
 
$main = $array['ns0MT_MSP_UPLOAD_FAIRMONT_RES']['Details'];

        
        $getaccesstoken = $this->generate_access_token();
        $decode_accesstoken = json_decode($getaccesstoken, true);
        $generated_accesstoken = $decode_accesstoken['access_token'];

        $newmain = [];
        if (array_key_exists('0',$main) === false) {
            $newmain[0] = $main;
        }
        else{
            $newmain = $main;
        }

        foreach ($newmain as $key => $value) {
            
           $updatefn = $this->update_percentage($generated_accesstoken, $value['item_id'], $value['PERCENT_COMPLETE'], $value['site_id'], $value['list_id']);
           //Log::info('ms project updated response '.json_encode($updatefn));
        }

        //$status['Status'] = 'Updated Successfully';
        //return json_encode($status);


    }


    public function adddatastoarray($getaccess_token, $urltocall,$odatalink, $records)
    {
      
        if ($odatalink == 0) {
            $getmsprec = $this->fetchstetdatefrom_msp($getaccess_token, $urltocall);
            //dd($getmsprec['value']);


            
            if (count($getmsprec['value']) > 0) {
              
              $mm = [];

                foreach ($getmsprec['value'] as $key1 => $value1) {
                    
                    array_push($mm, $value1['fields']);
                   
                }

                if(session()->has('finalrecords')){
                  $sessrec = session()->get('finalrecords');
                  session()->forget('finalrecords');
                  $newarray =[];
                  $i=0;
                  foreach ($sessrec as $keyv1 => $valuev1) {
                    unset($valuev1['@odata.etag']);
                    $newarray[$i] = $valuev1;
                    $i++;
                  }
                  foreach ($mm as $keyv2 => $valuev2) {
                    unset($valuev2['@odata.etag']);
                    $newarray[$i]=$valuev2;
                    $i++;
                  }
                  //array_push($newarray,$sessrec);
                  //array_push($newarray,$mm);
                  session()->put('finalrecords',$newarray);
  
                }
                else{
                  session()->put('finalrecords',$mm);
                }
            }
            
            
            if (array_key_exists('@odata.nextLink', $getmsprec)) {
                    $this->adddatastoarray($getaccess_token,$getmsprec['@odata.nextLink'],$getmsprec['@odata.nextLink'], $records);
                }
               
        }
        else{
            $getmsprec1 = $this->fetchstetdatefrom_msp($getaccess_token, $urltocall);
            
            if (count($getmsprec1['value']) > 0) {
              $mm1 = [];
                foreach ($getmsprec1['value'] as $key1 => $value1) {

                    
                   array_push($mm1, $vlue1['fields']);                  
                }
                if(session()->has('finalrecords')){
                  $sessrec = session()->get('finalrecords');
                  session()->forget('finalrecords');
                  $newarray =[];
                  $i=0;
                  foreach ($sessrec as $keyv1 => $valuev1) {
                    unset($valuev1['@odata.etag']);
                    $newarray[$i]=$valuev1;
                    $i++;
                  }
                  foreach ($mm1 as $keyv2 => $valuev2) {
                    unset($valuev2['@odata.etag']);
                    $newarray[$i]=$valuev2;
                    $i++;
                  }
                  //array_push($newarray,$sessrec);
                  //array_push($newarray,$mm1);
                  session()->put('finalrecords',$newarray);
  
                }
                else{
                  session()->put('finalrecords',$mm1);
                }
            }

            if (array_key_exists('@odata.nextLink', $getmsprec1)) {
                    $this->adddatastoarray($getaccess_token, $getmsprec1['@odata.nextLink'],$getmsprec1['@odata.nextLink'], $records);
                }
                
        }

        return '<?xml version="1.0" encoding="UTF-8"?>
        <ns0:MT_MSP_GET_DATA_RES xmlns:ns0="http://sap_microsoft_project_task_list.com">
           <Details>
              <Due_Date/>
              <Start_Date/>
              <EMP_ID/>
              <SUB_LOC/>
              <ACTIVITY_NO/>
              <NETWORK_NO/>
              <id/>
           </Details>
        </ns0:MT_MSP_GET_DATA_RES>';
        
    }


    public function msproject_fetchstetdate(Request $request)
    {
      $response = file_get_contents("php://input");

      //Log::info($response);

      $response = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $response);
      $xml = new \SimpleXMLElement($response);
$body = $xml->xpath('//SOAPBody')[0];
$array = json_decode(json_encode((array)$body), TRUE); 

$siteid = $array['ns0MT_MSP_GET_DATA_REQ']['site_id'];
$listid = $array['ns0MT_MSP_GET_DATA_REQ']['list_id'];

$getaccesstoken = $this->generate_access_token();
$decode_accesstoken = json_decode($getaccesstoken, true);
$generated_accesstoken = $decode_accesstoken['access_token'];

$odatalink = 0;
$records = [];
$urltocall = $url = "https://graph.microsoft.com/v1.0/sites/".$siteid."/lists/".$listid.'/items?expand=fields(select%3did%2cACTIVITY_NO%2cNETWORK_NO%2cSUB_LOC%2cEMP_ID%2cStartDate%2cDueDate)';
if($request->session()->has('finalrecords')){
  $request->session()->forget('finalrecords');
}
$resp = $this->adddatastoarray($generated_accesstoken, $urltocall,$odatalink, $records);
//@odata.nextLink

if($request->session()->has('finalrecords')){
  $sessrec = $request->session()->get('finalrecords');
  

$newarr = '<SOAP:Envelope xmlns:SOAP="http://schemas.xmlsoap.org/soap/envelope/">
<SOAP:Header/>
<SOAP:Body xmlns:sap="http://sap_microsoft_project_task_list.com">
   <ns0:MT_MSP_GET_DATA_RES xmlns:ns0="http://sap_microsoft_project_task_list.com">';
      
   





  $kk=0;
  foreach ($sessrec as $key => $value) {

    $newarr .= '<Details>';
    

if (array_key_exists('DueDate', $value)) { 
  $newarr .= '<Due_Date>'.$value['DueDate'].'</Due_Date>';
  }else{ $newarr .= '<Due_Date/>'; }
if (array_key_exists('StartDate', $value)) {
  $newarr .= '<Start_Date>'.$value['StartDate'].'</Start_Date>';
   }else{ $newarr .= '<Start_Date/>'; }
if (array_key_exists('EMP_ID', $value)) { $newarr .= '<EMP_ID>'.$value['EMP_ID'].'</EMP_ID>';  }else{ $newarr .= '<EMP_ID/>';}
if (array_key_exists('SUB_LOC', $value)) { $newarr .= '<SUB_LOC>'.$value['SUB_LOC'].'</SUB_LOC>';  }else{ $newarr .= '<SUB_LOC/>';}
if (array_key_exists('ACTIVITY_NO', $value)) { $newarr .= '<ACTIVITY_NO>'.$value['ACTIVITY_NO'].'</ACTIVITY_NO>';  }else{ $newarr .= '<ACTIVITY_NO/>';}
if (array_key_exists('NETWORK_NO', $value)) { $newarr .= '<NETWORK_NO>'.$value['NETWORK_NO'].'</NETWORK_NO>';  }else{ $newarr .= '<NETWORK_NO/>';}
if (array_key_exists('id', $value)) { $newarr .= '<id>'.$value['id'].'</id>';  }else{ $newarr .= '<id/>';}

$newarr .= '</Details>';
    
  }
  $newarr .= '</ns0:MT_MSP_GET_DATA_RES>
  </SOAP:Body>
  </SOAP:Envelope>';
  Log::info($newarr);
  return $newarr;
}

return $resp;
    }


    public function msproject_fetchstetdate_rest(Request $request)
    {
      $datajson = json_encode($request->all());
      Log::info($datajson);
      $decodedjson = json_decode($datajson, true);


      $getaccesstoken = $this->generate_access_token();
      $decode_accesstoken = json_decode($getaccesstoken, true);
      $generated_accesstoken = $decode_accesstoken['access_token'];

      $siteid = $request->site_id;
      $listid = $request->list_id;
      $odatalink = 0;
      $records = [];
      $urltocall = $url = "https://graph.microsoft.com/v1.0/sites/".$siteid."/lists/".$listid.'/items?expand=fields(select%3did%2cACTIVITY_NO%2cNETWORK_NO%2cSUB_LOC%2cEMP_ID%2cStartDate%2cDueDate)';
      if($request->session()->has('finalrecords')){
        $request->session()->forget('finalrecords');
      }
      $resp = $this->adddatastoarray($generated_accesstoken, $urltocall,$odatalink, $records);
      //@odata.nextLink

      if($request->session()->has('finalrecords')){
        $sessrec = $request->session()->get('finalrecords');
        $newarr = [];
        $kk=0;
        foreach ($sessrec as $key => $value) {
          $newarr['Details'][$kk]['Due_Date'] = 0;
          $newarr['Details'][$kk]['Start_Date'] = 0;
          $newarr['Details'][$kk]['EMP_ID'] = 0;
          $newarr['Details'][$kk]['SUB_LOC'] = 0;
          $newarr['Details'][$kk]['ACTIVITY_NO'] = 0;
          $newarr['Details'][$kk]['NETWORK_NO'] = 0;
          $newarr['Details'][$kk]['id'] = 0;


      if (array_key_exists('DueDate', $value)) { 
        $a = explode('T',$value['DueDate']);
        $newarr['Details'][$kk]['Due_Date'] = $a[0];
        }
      if (array_key_exists('StartDate', $value)) {
        $b = explode('T',$value['StartDate']);
         $newarr['Details'][$kk]['Start_Date'] = $b[0]; 
         }
      if (array_key_exists('EMP_ID', $value)) { $newarr['Details'][$kk]['EMP_ID'] = $value['EMP_ID'];  }
      if (array_key_exists('SUB_LOC', $value)) { $newarr['Details'][$kk]['SUB_LOC'] = $value['SUB_LOC'];  }
      if (array_key_exists('ACTIVITY_NO', $value)) { $newarr['Details'][$kk]['ACTIVITY_NO'] = $value['ACTIVITY_NO'];  }
      if (array_key_exists('NETWORK_NO', $value)) { $newarr['Details'][$kk]['NETWORK_NO'] = $value['NETWORK_NO'];  }
      if (array_key_exists('id', $value)) { $newarr['Details'][$kk]['id'] = (int)$value['id'];  }

      $kk++;
          
        }
        return json_encode($newarr);
      }
      



            
      return json_encode($resp);
    }
}
