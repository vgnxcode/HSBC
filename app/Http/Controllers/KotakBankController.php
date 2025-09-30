<?php

namespace vgn\Http\Controllers;

use Illuminate\Http\Request;
use vgn\Http\Traits\kotakbanktrait;
use Illuminate\Support\Facades\Log;

class KotakBankController extends Controller
{
	use kotakbanktrait;
	public function clean($string) {
   //$string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

   return preg_replace('/[^A-Za-z0-9\s]/', '', $string); // Removes special chars.
}
    public function GetSapDataProcess1()
    {


    	$data = $this->GetSapDataProcess1_soap();
		
    	if (!empty($data)) {
    	   
            $res = array();
            if (array_key_exists('0',$data['Bank_Details'])) {
                $res = $data['Bank_Details'];
            }else{
                $res[0] = $data['Bank_Details'];
            }
            //dd($res);
    		foreach ($res as $key => $value) {
                if ($key <= '10') {
                 
                   
                   
                   $value['Beneficiary_Account'] = utf8_encode($value['Beneficiary_Account']);
                   $value['Company_Bank_Acc'] = utf8_encode($value['Company_Bank_Acc']);
					
					$nn_msgid = $value['Company_Code'].'_'.$value['Document_No'].'_'.$value['Fiscal_Year'];
					
					$exception_msg_ids = ['5000_0016001184_2018','4000_0018003924_2018','4000_ESAL000115_2018','4000_0018004281_2018','5000_ESAL001404_2018','4000_0010003685_2018','4000_0016001776_2018','4000_0016000994_2019','4000_0016000995_2019','4000_0016001953_2019','4000_ESAL000176_2020','5000_0016004309_2020','6300_ESAL000459_2021'];
                
    			if (!empty($value['Company_Bank_Acc']) && !empty($value['Document_No']) && !empty($value['Company_Code']) && (in_array($nn_msgid, $exception_msg_ids) === false)) {
    				//dd($value);
                   

					//dd($value['Beneficiary_Name']);
    				$process2 = $this->SendportalResponse(
                        $value['Company_Code'],
                        $value['Document_No'],
                        $value['Posting_Date'],
                        $value['Beneficiary_Name'],
                        $value['Beneficiary_Account'],
                        $value['Bank_Name'],
                        $value['IFSC_Code'],
                        $value['Payment_Amount'],
                        $value['Trans_Type'],
                        $value['Ref_No'],
                        $value['Fiscal_Year'],
                        $value['Company_Bank_Acc']);

                    //dd('process completed');

                   // $file = file_get_contents("https://apigwuat.kotak.com:8443/cms_generic_service?wsdl", true);
                   //$this->reversalrequest();
                   $process = $this->kotakprocess(
                        $value['Company_Code'],
                        $value['Document_No'],
                        $value['Posting_Date'],
                        $value['Beneficiary_Name'],
                        $value['Beneficiary_Account'],
                        $value['Bank_Name'],
                        $value['IFSC_Code'],
                        $value['Payment_Amount'],
                        $value['Trans_Type'],
                        $value['Ref_No'],
                        $value['Fiscal_Year'],
                        $value['Company_Bank_Acc']);                
                   //dd($process);

    			}
        }

    		}
            dd('Payment Request Completed!');
    	}
    	else{
    		echo 'No payments to process';
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


public function kotakprocess(
                        $Company_Code,
                        $Document_No,
                        $Posting_Date,
                        $Beneficiary_Name,
                        $Beneficiary_Account,
                        $Bank_Name,
                        $IFSC_Code,
                        $Payment_Amount,
                        $Trans_Type,
                        $Ref_No,
                        $Fiscal_Year,$companybankno)
    {
        //$companybankno = '6711881051';
    	//$Payment_Amount = '0.0';
        //$IFSC_Code = 'BOFA0BG3978';
        //$Trans_Type = 'NFT';
        $IFSC_Code = strtoupper($IFSC_Code);
        $message_id = $Company_Code.'_'.$Document_No.'_'.$Fiscal_Year;
        //$message_id = 'VGN_123065'.'_'.$Fiscal_Year;
        if($Company_Code == '4000'){

            $client_code = 'VGNVENP';
            $message_source_code = 'VGN DEVELOPERS';   
            $company_code = 'VGNPD';
            $apikey = 'l7xx22d4c22391314c4ebdde12e9357a1eeb';
        }
        else if($Company_Code == '5000'){
            
            $client_code = 'VGNVEN1';
            $message_source_code = 'VGN INFRA'; 
            $company_code = 'VGNINF' ;
            $apikey = 'l7xxa37a7ac5ddb34abb9c7415cf3c062efd';
        }
        else if($Company_Code == '7000'){
            
            //$client_code = 'VGNVEN1';
            $client_code = 'TEMPTEST1';
            $message_source_code = 'Bristol'; 
            $company_code = 'VGNBR';
            $apikey = '';
        }else if($Company_Code == '9000'){
            
            //$client_code = 'VGNVEN1';
            $client_code = 'TEMPTEST1';
            $message_source_code = 'Facility';
            $company_code = 'VGNFAC';
            $apikey = '';

        }
	else if($Company_Code == '6300'){

            $client_code = 'VGNVEN3';
            $message_source_code = 'VGN INTERIORS';
            $company_code = 'VGNDVP';
            $apikey = 'l7xx22d4c22391314c4ebdde12e9357a1eeb';

        }
        else if($Company_Code == '7200'){

            $client_code = 'VGNVEN2';
            $message_source_code = 'VGN HOME BUILDING';
            $company_code = 'VGNDVP';
            $apikey = 'l7xx22d4c22391314c4ebdde12e9357a1eeb';

        }
	else{
            return false;
        }

        $ins_ref_no = $Document_No.'_'.$Fiscal_Year;
        $my_product_code = 'VENPAY';
        

        $Payment_Amount = trim($Payment_Amount);

        if (!empty($Posting_Date)) {
            //$newposting_date = substr($Posting_Date,0,4).'-'.substr($Posting_Date,4,2).'-'.substr($Posting_Date,6,2);
            $newposting_date = date('Y-m-d');

        }


$tocheck = '18001566_2020';
$message = "Test~Salary~for~Month~of~Dec~2020";


        $bennametriped = $this->clean($Beneficiary_Name);

        $soapUrl = "https://apigw.kotak.com:8443/cms_generic_service?apikey=$apikey"; // asmx URL of WSDL
            

$request = '<soap:Envelope xmlns:pay="http://www.kotak.com/schemas/CMS_Generic/Payment_Request.xsd" xmlns:soap="http://www.w3.org/2003/05/soap-envelope">';
    $request .= '<soap:Header/>';
    $request .= '<soap:Body>';
        $request .= '<pay:Payment>';
            $request .= '<pay:RequestHeader>';
                $request .= '<pay:MessageId>'.$message_id.'</pay:MessageId>';
                $request .= '<pay:MsgSource>'.$message_source_code.'</pay:MsgSource>';
                $request .= '<pay:ClientCode>'.$client_code.'</pay:ClientCode>';
                $request .= '<pay:BatchRefNmbr/>';
                $request .= '<pay:HeaderChecksum/>';
                $request .= '<pay:ReqRF1/>';
                $request .= '<pay:ReqRF2/>';
                $request .= '<pay:ReqRF3/>';
                $request .= '<pay:ReqRF4/>';
                $request .= '<pay:ReqRF5/>';
            $request .= '</pay:RequestHeader>';
            $request .= '<pay:InstrumentList>';
                $request .= '<pay:instrument>';
                    $request .= '<pay:InstRefNo>'.$ins_ref_no.'</pay:InstRefNo>';
                    $request .= '<pay:CompanyId/>';
                    $request .= '<pay:CompBatchId/>';
                    $request .= '<pay:ConfidentialInd/>';
                    $request .= '<pay:MyProdCode>'.$my_product_code.'</pay:MyProdCode>';
                    $request .= '<pay:CompTransNo/>';
                    $request .= '<pay:PayMode>'.$Trans_Type.'</pay:PayMode>';
                    $request .= '<pay:TxnAmnt>'.$Payment_Amount.'</pay:TxnAmnt>';
                    $request .= '<pay:AccountNo>'.$companybankno.'</pay:AccountNo>';
                    $request .= '<pay:DrRefNmbr/>';
                    $request .= '<pay:DrDesc/>';
                    $request .= '<pay:PaymentDt>'.$newposting_date.'</pay:PaymentDt>';
                    $request .= '<pay:BankCdInd/>';
                    $request .= '<pay:BeneBnkCd/>';
                    $request .= '<pay:RecBrCd>'.$IFSC_Code.'</pay:RecBrCd>';
                    $request .= '<pay:BeneAcctNo>'.$Beneficiary_Account.'</pay:BeneAcctNo>';
                    $request .= '<pay:BeneName>'.$bennametriped.'</pay:BeneName>';
                    $request .= '<pay:BeneCode/>';
                    $request .= '<pay:BeneEmail/>';
                    $request .= '<pay:BeneFax/>';
                    $request .= '<pay:BeneMb/>';
                    $request .= '<pay:BeneAddr1/>';
                    $request .= '<pay:BeneAddr2/>';
                    $request .= '<pay:BeneAddr3/>';
                    $request .= '<pay:BeneAddr4/>';
                    $request .= '<pay:BeneAddr5/>';
                    $request .= '<pay:city/>';
                    $request .= '<pay:zip/>';
                    $request .= '<pay:Country/>';
                    $request .= '<pay:State/>';
                    $request .= '<pay:TelephoneNo/>';
                    $request .= '<pay:BeneId/>';
                    $request .= '<pay:BeneTaxId/>';
                    $request .= '<pay:AuthPerson/>';
                    $request .= '<pay:AuthPersonId/>';
                    $request .= '<pay:DeliveryMode/>';
                    $request .= '<pay:PayoutLoc/>';
                    $request .= '<pay:PickupBr/>';
                    $request .= '<pay:PaymentRef/>';
                    $request .= '<pay:ChgBorneBy/>';
                    $request .= '<pay:InstDt>'.$newposting_date.'</pay:InstDt>';
                    $request .= '<pay:MICRNo/>';
                    $request .= '<pay:CreditRefNo/>';
                    $request .= '<pay:PaymentDtl/>';
                    $request .= '<pay:PaymentDtl1/>';
                    $request .= '<pay:PaymentDtl2/>';
                    $request .= '<pay:PaymentDtl3/>';
                    $request .= '<pay:MailToAddr1/>';
                    $request .= '<pay:MailToAddr2/>';
                    $request .= '<pay:MailToAddr3/>';
                    $request .= '<pay:MailToAddr4/>';
                    $request .= '<pay:MailTo/>';
                    $request .= '<pay:ExchDoc/>';
                    $request .= '<pay:InstChecksum/>';
                    $request .= '<pay:InstRF1/>';
                    $request .= '<pay:InstRF2/>';
                    $request .= '<pay:InstRF3/>';
                    $request .= '<pay:InstRF4/>';
                    $request .= '<pay:InstRF5/>';
                    $request .= '<pay:InstRF6/>';
                    $request .= '<pay:InstRF7/>';
                    $request .= '<pay:InstRF8/>';
                    $request .= '<pay:InstRF9/>';
                    $request .= '<pay:InstRF10/>';
                    $request .= '<pay:InstRF11/>';
                    $request .= '<pay:InstRF12/>';
                    $request .= '<pay:InstRF13/>';
                    $request .= '<pay:InstRF14/>';
                    $request .= '<pay:InstRF15/>';
                    $request .= '<pay:EnrichmentSet>';
			if(($ins_ref_no == $tocheck) && ($Company_Code == '4000')){
                     $request .= '<pay:Enrichment>'.$message.'</pay:Enrichment>';
                    }
                        $request .= '<pay:Enrichment/>';
                    $request .= '</pay:EnrichmentSet>';
            $request .= '</pay:instrument>';
        $request .= '</pay:InstrumentList>';
    $request .= '</pay:Payment>';
    $request .= '</soap:Body>';
$request .= '</soap:Envelope>'; 

            $xml_post_string = $request;    
// print_r($xml_post_string);
Log::info('Bank release :'.$xml_post_string);
  $header = array(
    "Content-Type: application/soap+xml;charset=UTF-8;action=\"/BusinessServices/StarterProcesses/CMS_Generic_Service.serviceagent/Payment\""
  );
 
 //dd($soapUrl);
  $soap_do = curl_init();
  curl_setopt($soap_do, CURLOPT_URL, "$soapUrl" );
  curl_setopt($soap_do, CURLOPT_RETURNTRANSFER, true );  
  curl_setopt($soap_do, CURLOPT_POST,           true );
  curl_setopt($soap_do, CURLOPT_POSTFIELDS,     $xml_post_string);
  curl_setopt($soap_do, CURLOPT_HTTPHEADER,     $header);
 $exec = curl_exec($soap_do);
//dd($soap_do);
 //dd($exec);
   if($exec === false) {
    $err = 'Curl error: ' . curl_error($soap_do);
    curl_close($soap_do);
    print $err;
    //dd(false);
  } else {
    curl_close($soap_do);
    
//dd($exec);
/**
 * start to send response from payment request to SAP
 */



        $txt = $this->mungXML($exec);
        $obj = SimpleXML_Load_String($txt, 'SimpleXMLElement', LIBXML_NOCDATA);

//dd($obj);

$result = [];
//$element = new SimpleXMLElement($obj);
foreach ($obj as $key=>$value) {
  //$result[(string)$input['name']] = (string)$input['value'];
  foreach ($value->ns0_Payment->ns0_AckHeader as $key1 => $value1) {
  //dd($value1->ns0_StatusCd);  
  $statuscode = (string)$value1->ns0_StatusCd;
  $statusreason = (string)$value1->ns0_StatusRem;
  
  $payment_res_to_soap = $this->Sendkotakpaymentrequest($Company_Code,
                        $Document_No,
                        $Posting_Date,
                        $Beneficiary_Name,
                        $Beneficiary_Account,
                        $Bank_Name,
                        $IFSC_Code,
                        $Payment_Amount,
                        $Trans_Type,
                        $Ref_No,
                        $Fiscal_Year,$companybankno,$statuscode,$statusreason,$message_id,$message_source_code,$client_code,$newposting_date);

  //dd($payment_res_to_soap);
  
  }
  //dd($value);
}

//dd($result);

//var_dump($result);

/**
 * End
 */







    
  }

    
    }
    



     public function reversalrequest()
    {
    	
        $getreversaltoprocess = $this->InitiatereversalrequestFromSAP();
    	
        //dd($getreversaltoprocess);

        if (!empty($getreversaltoprocess['Details'])) {

              $res = array();
            if (array_key_exists('0',$getreversaltoprocess['Details'])) {
                $res = $getreversaltoprocess['Details'];
            }else{
                $res[0] = $getreversaltoprocess['Details'];
            }
	   //dd($res);
            
            foreach ($res as $saprkey => $saprvalue) {
            	
		if ($saprkey <= '300') {
               //dd($saprkey); 
                //dd($saprvalue);
              
                $rmsgid = $saprvalue['Msg_ID'];
                $rmsgsource = $saprvalue['Msg_Source'];
                $rclientcode = $saprvalue['Client_Code'];
                $rdate = $saprvalue['Date'];
                $rrequestid = substr($rmsgid, 0,-5);
                $company_code = substr($rmsgid, 0,4);
                
                if ($company_code == '4000') {
                	$apikey = 'l7xx22d4c22391314c4ebdde12e9357a1eeb';
                }
                elseif ($company_code == '5000') {
                	$apikey = 'l7xxa37a7ac5ddb34abb9c7415cf3c062efd';
                }
		elseif($company_code == '6300'){

            		$apikey = 'l7xx22d4c22391314c4ebdde12e9357a1eeb';

        	}
	        elseif($company_code == '7200'){
        	    	$apikey = 'l7xx22d4c22391314c4ebdde12e9357a1eeb';

	        }
                else{
                	$apikey = '';
                }

                if (!empty($rdate)) {
                    $rdate = substr($rdate, 0,4).'-'.substr($rdate, 4,2).'-'.substr($rdate, 6,2);
                }


                 $request = '<soap:Envelope xmlns:soap="http://www.w3.org/2003/05/soap-envelope" xmlns:rev="http://www.kotak.com/schemas/CMS_Generic/Reversal_Request.xsd">';
   $request .= '<soap:Header/>';
   $request .= '<soap:Body>';
   $request .= '<rev:Reversal>';
   $request .= '<rev:Header>';
   $request .= '<rev:Req_Id>'.$rrequestid.'</rev:Req_Id>';
   $request .= '<rev:Msg_Src>'.$rmsgsource.'</rev:Msg_Src>';
   $request .= '<rev:Client_Code>'.$rclientcode.'</rev:Client_Code>';
   $request .= '<rev:Date_Post>'.$rdate.'</rev:Date_Post>';
   $request .= '</rev:Header>';
   $request .= '<rev:Details>';
   $request .= '<rev:Msg_Id>'.$rmsgid.'</rev:Msg_Id>';
   $request .= '</rev:Details>';
   $request .= '</rev:Reversal>';
   $request .= '</soap:Body>';
   $request .= '</soap:Envelope>';

    //dd($request);
  $headers = array(
    "Content-Type: application/soap+xml;charset=UTF-8;action=\"/BusinessServices/StarterProcesses/CMS_Generic_Service.serviceagent/Reversal\"",
    "Accept: text/xml",
    "Cache-Control: no-cache",
    "Pragma: no-cache"
  );
 
  $soap_curl = curl_init();
  curl_setopt($soap_curl, CURLOPT_FRESH_CONNECT, true);
  curl_setopt($soap_curl, CURLOPT_URL, "https://apigw.kotak.com:8443/cms_generic_service?apikey=$apikey" );
  curl_setopt($soap_curl, CURLOPT_RETURNTRANSFER, true );
  curl_setopt($soap_curl, CURLOPT_TIMEOUT, 10);
  curl_setopt($soap_curl, CURLOPT_POST,           true );
  curl_setopt($soap_curl, CURLOPT_POSTFIELDS,     $request);
  curl_setopt($soap_curl, CURLOPT_HTTPHEADER,     $headers);
  curl_setopt($soap_curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
  


 $execs = curl_exec($soap_curl);

 //$information = curl_getinfo($soap_curl);
	print_r($execs).'<br/><br/>';
   if($execs === false) {
    $err = 'Curl error: ' . curl_error($soap_curl);
    curl_close($soap_curl);
    print $err;
    
  } else {
    curl_close($soap_curl);
    //print_r($execs);
    
    /**
 * start to send response from payment request to SAP
 */



        $txt = $this->mungXML($execs);
        $obj = SimpleXML_Load_String($txt, 'SimpleXMLElement', LIBXML_NOCDATA);

//dd($obj);

$result = [];
//$element = new SimpleXMLElement($obj);
foreach ($obj as $key=>$value) {
  //$result[(string)$input['name']] = (string)$input['value'];
  foreach ($value->ns0_Reversal->ns0_Details->ns0_Rev_Detail as $key1 => $value1) {
  //dd($value1->ns0_StatusCd);  
  $rstatuscode = (string)$value1->ns0_Status_Code;
  $rstatusreason = (string)$value1->ns0_Status_Desc;
  $rutrno = (string)$value1->ns0_UTR;

  if ($rstatuscode == 'Error-99') {
      $rutrno = '';
  }
//Log::info('Kotak reversal request: '.$execs);
//dd($execs);
	  
  
  $reversal_res_to_sap = $this->sendfinalreverslaconfirmationtosap($rmsgid,$rmsgsource,$rclientcode, $rstatuscode, $rstatusreason,$rutrno );

//dd($execs);
  //dd($reversal_res_to_sap);
  
  }
  //dd($value);
}

//dd($result);

//var_dump($result);

/**
 * End
 */


    
  }
                
            }
          }
          dd('Reversal request completed!');

        }else{
            dd('No Reversal request to process');
        }
       
   



    
    }

   
   


   
}
