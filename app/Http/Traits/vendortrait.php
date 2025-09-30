<?php
namespace vgn\Http\Traits;

use Carbon\Carbon;


trait vendortrait{

    
    public function getvendor($vendorid){
    	ini_set('memory_limit', -1);
		$wsdl = config('vendor_constants.getvendor_wsdl');
		$endpoint = config('vendor_constants.getvendor_endpoint');

        require_once('nusoap.php');
        
        $paramRQ = array('Vendor_ID'=>$vendorid);
		
		$client = new \nusoap_client($wsdl,true,false,false,false,false,0,300);
		// Error check
		$client->setCredentials(config('vendor_constants.sapusername'), config('vendor_constants.sappassword'), 'basic');
		$client->setUseCURL(true);

		
		$client->useHTTPPersistentConnection();
		$proxy = $client->getProxy();
		if (empty($proxy)) {
			echo 'Service is down. Please try after 10 minutes.';
			die();
			exit();
		}
		$proxy->forceEndpoint=$endpoint;
		$result = $proxy->SI_VEND_FULL_DETAI_OUT($paramRQ);
		
		// setcookie("TestCookie", serialize($result), time() + 30, '/');
		return $result;
        
    }
    
    public function getHelp($vendorid)
	{
		$wsdl = config('vendor_constants.getHelp_wsdl');
		$endpoint = config('vendor_constants.getHelp_endpoint');

        require_once('nusoap.php');
		$paramRQ = array('Vendor_ID'=>$vendorid);	
		/* create client for my rpc web service */
		
		$client = new \nusoap_client($wsdl,true);
		// Error check
		$client->setCredentials(config('vendor_constants.sapusername'), config('vendor_constants.sappassword'), 'basic');
		$client->setUseCURL(true);
		$client->useHTTPPersistentConnection();
		$proxy = $client->getProxy();
		$proxy->forceEndpoint=$endpoint;
		/* call queryRcx */
		$result = $proxy->SI_VEND_SEARCH_OUT($paramRQ);
		// setcookie("TestCookie", serialize($result), time() + 30, '/');
		return $result;
	}
    
    public function regHelp() //Vendor Registraion Help URL
	{
		$wsdl = config('vendor_constants.regHelp_wsdl');
		$endpoint = config('vendor_constants.regHelp_endpoint');

        require_once('nusoap.php');
		$reg="REGISTER";
		$paramRQ = array('Register_commend'=>$reg);
		//create client for my rpc web service 
		
		$client = new \nusoap_client($wsdl,true);
		// Error check
        $client->soap_defencoding = 'UTF-8';
		$client->decode_utf8 = false;
		$client->setCredentials(config('vendor_constants.sapusername'), config('vendor_constants.sappassword'), 'basic');
		$client->setUseCURL(true);
		$client->useHTTPPersistentConnection();
		$proxy = $client->getProxy();
		$proxy->forceEndpoint=$endpoint;
		// call queryRcx 
		$result = $proxy->SI_VEND_SERCH_HLP_OUT($paramRQ);
		// setcookie("TestCookie", serialize($result), time() + 30, '/');
		return $result;
	}
    
    public function venRegDetails($attr) // Vendor Registration Service URL
	{
		$wsdl = config('vendor_constants.venRegDetails_wsdl');
		$endpoint = config('vendor_constants.venRegDetails_endpoint');
		

		if ($attr['reg_proof_type'] == 'GST') {
    		$tt = strtoupper(trim($attr['pan']));
    		$attr['pan'] = substr($tt, 2,10);
	    	}
        require_once('nusoap.php');
		$paramRQ = array('Orgonaization_Name'=>$attr['name_org'],'Type_Of_Orgonaization'=>$attr['type_org'],'Material_Service_Cat'=>$attr['mat'],'Type_Of_Business'=>$attr['type_bus'],'Veendor_Acc_Group'=>$attr['ven_acc'],'Contact_Person'=>$attr['cnct'],'Contact_Tel_No'=>$attr['tel'],'Contact_Mob_No'=>$attr['mob'],'E_Mail'=>$attr['email'],'Pan_No'=>$attr['pan'],'Region'=>$attr['region'],'Country'=>$attr['ctry'], 'GST_No' => $attr['gst_no'], 'Reg_Proof_Type' => $attr['reg_proof_type']);
		// create client for my rpc web service 
		
		$client = new \nusoap_client($wsdl,true);
		// Error check
		$client->setCredentials(config('vendor_constants.sapusername'), config('vendor_constants.sappassword'), 'basic');
		$client->setUseCURL(true);
		$client->useHTTPPersistentConnection();
		$proxy = $client->getProxy();
		$proxy->forceEndpoint=$endpoint;
		// call queryRcx 
		$result = $proxy->SI_VEND_REGISTRATION_OUT($paramRQ);
		return $result;
	}
    

    public function savecomplaint($vendorid, $cproject, $cnature, $desccomp)
    {
		$wsdl = config('vendor_constants.savecomplaint_wsdl');
		$endpoint = config('vendor_constants.savecomplaint_endpoint');

        require_once('nusoap.php');
        $description=array();
		foreach(str_split($desccomp,130) as $i=>$value)
		{
			$description['Line_'.($i+1)]=$value;
		}
		$paramRQ = array('Vendor_no'=>$vendorid,'Project_Name'=>$cproject,'Description_to_Complaint'=>$description,'Nature_Of_Complaint'=>$cnature);
		
		/* create client for my rpc web service */
		
		$client = new \nusoap_client($wsdl,true);
		// Error check
		
		$client->setCredentials(config('vendor_constants.sapusername'), config('vendor_constants.sappassword'), 'basic');
		$client->setUseCURL(true);
		
		$client->useHTTPPersistentConnection();
		
		$proxy = $client->getProxy();
		$proxy->forceEndpoint=$endpoint;
		/* call queryRcx */
		$result = $proxy->SI_VEND_RAIS_COMP_OUT($paramRQ);
		$result['desc']=$desccomp;
		return $result;
    }

    public function closecomplaint($vendorid, $complaintno){
		$wsdl = config('vendor_constants.closecomplaint_wsdl');
		$endpoint = config('vendor_constants.closecomplaint_endpoint');

        require_once('nusoap.php');
        $paramRQ = array('Vendor_No'=>$vendorid,'Compainat_No'=>$complaintno);
		
		/* create client for my rpc web service */
		
		$client = new \nusoap_client($wsdl,true);
		// Error check
		
		$client->setCredentials(config('vendor_constants.sapusername'), config('vendor_constants.sappassword'), 'basic');
		$client->setUseCURL(true);
		
		$client->useHTTPPersistentConnection();
		
		$proxy = $client->getProxy();
		$proxy->forceEndpoint=$endpoint;
		/* call queryRcx */
		$result = $proxy->SI_VEND_CLOSE_COMP_OU($paramRQ);
		$result['code']=200;
		return $result;
    }
    
     public function fetchbids($vendorid){
		$wsdl = config('vendor_constants.fetchbids_wsdl');
		$endpoint = config('vendor_constants.fetchbids_endpoint');

        require_once('nusoap.php');
        $paramRQ = array('Vendor_No'=>$vendorid);
		
		/* create client for my rpc web service */
		
		$client = new \nusoap_client($wsdl,true);
		// Error check
		$client->soap_defencoding = 'UTF-8';
		$client->decode_utf8 = false;
		$client->setCredentials(config('vendor_constants.sapusername'), config('vendor_constants.sappassword'), 'basic');
		$client->setUseCURL(true);
		
		$client->useHTTPPersistentConnection();
		
		$proxy = $client->getProxy();
		$proxy->forceEndpoint=$endpoint;
		/* call queryRcx */
		$result = $proxy->SI_VEND_COMPLETE_BID_OUT($paramRQ);
		$result['code']=200;
		return $result;
    }
    
     public function savevendorremarks($vendorid, $bidno, $Remarks){
		$wsdl = config('vendor_constants.savevendorremarks_wsdl');
		$endpoint = config('vendor_constants.savevendorremarks_endpoint');

        require_once('nusoap.php');
        
         $description['BID_Number']=$bidno;
		for($j=0;$j<20;$j++)
		{
			$description['Line'.($j+1)]="";
		}
		foreach(str_split($Remarks,130) as $i=>$value)
		{
			$description['Line'.($i+1)]=$value;
		}
		$paramRQ = array('Vendor_No'=>$vendorid,'UPDATE'=>$description);
		
		/* create client for my rpc web service */
		
		$client = new \nusoap_client($wsdl,true);
		// Error check
		
		$client->setCredentials(config('vendor_constants.sapusername'), config('vendor_constants.sappassword'), 'basic');
		$client->setUseCURL(true);
		
		$client->useHTTPPersistentConnection();
		
		$proxy = $client->getProxy();
		$proxy->forceEndpoint=$endpoint;
		/* call queryRcx */
		$result = $proxy->SI_VEND_BID_VENDOR_REMARKS_OUT($paramRQ);
		$result['code']=200;
		return $result;
    }
    
     public function bidUpdate($vendorid, $bid){
		$wsdl = config('vendor_constants.bidUpdate_wsdl');
		$endpoint = config('vendor_constants.bidUpdate_endpoint');

        require_once('nusoap.php');
        
         $paramRQ = array('Vendor_No'=>$vendorid,'Bid_Rate'=>$bid);
		
		/* create client for my rpc web service */
		
		$client = new \nusoap_client($wsdl,true);
		// Error check
		$client->soap_defencoding = 'UTF-8';
		$client->decode_utf8 = false;
		$client->setCredentials(config('vendor_constants.sapusername'), config('vendor_constants.sappassword'), 'basic');
		$client->setUseCURL(true);
		
		$client->useHTTPPersistentConnection();
		
		$proxy = $client->getProxy();
		$proxy->forceEndpoint=$endpoint;
		/* call queryRcx */
		$result = $proxy->SI_VEND_BID_RATE_OUT($paramRQ);
		$result['code']=200;
		return $result;
    }
    
     public function myrecentbids($vendorid){
		$wsdl = config('vendor_constants.myrecentbids_wsdl');
		$endpoint = config('vendor_constants.myrecentbids_endpoint');

        require_once('nusoap.php');
        
         $paramRQ = array('VENDOR_ID'=>$vendorid);
		
		/* create client for my rpc web service */
		
		$client = new \nusoap_client($wsdl,true);
		// Error check
		
		$client->setCredentials(config('vendor_constants.sapusername'), config('vendor_constants.sappassword'), 'basic');
		$client->setUseCURL(true);
		
		$client->useHTTPPersistentConnection();
		
		$proxy = $client->getProxy();
		$proxy->forceEndpoint=$endpoint;
		/* call queryRcx */
		$result = $proxy->SI_VEND_BID_RECENT_OUT($paramRQ);
		$result['code']=200;
		return $result;
    }
    
    
    public function getUnsold($vendorid)
{
	$wsdl = config('vendor_constants.getUnsold_wsdl');
	$endpoint = config('vendor_constants.getUnsold_endpoint');

	require_once('nusoap.php');
$paramRQ = array('Customer_ID'=>$vendorid);

// create client for my rpc web service

$client = new \nusoap_client($wsdl,true);
// Error check

$client->setCredentials(config('vendor_constants.sapusername'), config('vendor_constants.sappassword'), 'basic');
$client->setUseCURL(true);

$client->useHTTPPersistentConnection();

$proxy = $client->getProxy();
$proxy->forceEndpoint=$endpoint;
//call queryRcx
$result = $proxy->SI_Unsold_Out($paramRQ);
$result['code']=200;
return $result;

}

	



public function sappostreferFriend($vendorid,$name, $mail, $mobile, $intrested)
	{
		$wsdl = config('vendor_constants.sappostreferFriend_wsdl');
		$endpoint = config('vendor_constants.sappostreferFriend_endpoint');

		require_once('nusoap.php');
		$paramRQ = array('Customer_No'=>$vendorid,'Friend_Name'=>$name,'Interesed_Project'=>$intrested,'Mob_No'=>$mobile,'Email_ID'=>$mail,'Indicator'=>'C');
		
		/* create client for my rpc web service */
		
		$client = new \nusoap_client($wsdl,true);
		// Error check
		
		$client->setCredentials(config('vendor_constants.sapusername'), config('vendor_constants.sappassword'), 'basic');
		$client->setUseCURL(true);
		
		$client->useHTTPPersistentConnection();
		
		$proxy = $client->getProxy();
		if (empty($proxy)) {
			echo 'Service is down. Please try after 10 minutes.';
			die();
			exit();
		}
		$proxy->forceEndpoint=$endpoint;
		/* call queryRcx */
		$result = $proxy->SI_CUST_REFER_FRND_OUT($paramRQ);
		return $result;
	}

	 public function updatebankinfo($vendorid,$bank_account_no,$branch_name,$ifsc_code,$bank_name){
		$wsdl = config('vendor_constants.updatebankinfo_wsdl');
		$endpoint = config('vendor_constants.updatebankinfo_endpoint');

        require_once('nusoap.php');
        $paramRQ = array('Vendor_ID'=>$vendorid,'Acc_No'=>$bank_account_no,'Branch_Name'=>$branch_name,'IFSC_Code'=>$ifsc_code,'Bank_Name'=>$bank_name);
		
		/* create client for my rpc web service */
		
		$client = new \nusoap_client($wsdl,true);
		// Error check
		
		$client->setCredentials(config('vendor_constants.sapusername'), config('vendor_constants.sappassword'), 'basic');
		$client->setUseCURL(true);
		
		$client->useHTTPPersistentConnection();
		
		$proxy = $client->getProxy();
		$proxy->forceEndpoint=$endpoint;
		/* call queryRcx */
		$result = $proxy->SI_VEND_BANK_DETAILS_UPDATE_OUT($paramRQ);
		$result['code']=200;
		return $result;
    }


 public function get_channelpartner_campaigns($vendorid){
		$wsdl = config('vendor_constants.channelpartner_get_campaign_wsdl');
		$endpoint = config('vendor_constants.channelpartner_get_campaign_endpoint');

        require_once('nusoap.php');
        $paramRQ = array('Vendor_Id'=>$vendorid);
		
		/* create client for my rpc web service */
		
		$client = new \nusoap_client($wsdl,true);
		// Error check
		
		$client->setCredentials(config('vendor_constants.sapusername'), config('vendor_constants.sappassword'), 'basic');
		$client->setUseCURL(true);
		
		$client->useHTTPPersistentConnection();
		
		$proxy = $client->getProxy();
		$proxy->forceEndpoint=$endpoint;
		/* call queryRcx */
		$result = $proxy->SI_VEND_PLANTWISE_CAMPAIGN_CODE_OUT($paramRQ);
		$result['code']=200;
		return $result;
    }


public function post_final_negotiated_discountprice($newarray)
    {
    	$wsdl = config('vendor_constants.negotiated_discount_rate_wsdl');
		$endpoint = config('vendor_constants.negotiated_discount_rate_endpoint');

        require_once('nusoap.php');
        $paramRQ = $newarray;
		
		/* create client for my rpc web service */
		
		$client = new \nusoap_client($wsdl,true);
		// Error check
		
		$client->setCredentials(config('vendor_constants.sapusername'), config('vendor_constants.sappassword'), 'basic');
		$client->setUseCURL(true);
		
		$client->useHTTPPersistentConnection();
		
		$proxy = $client->getProxy();
		$proxy->forceEndpoint=$endpoint;
		/* call queryRcx */
		$result = $proxy->SI_VEND_BID_DATA_WEB_T0_ECC_OUT($paramRQ);
		$result['code']=200;
		return $result;
    }

public function negotiated_price_details($vendorid,$bidrefno)
    {
    	$wsdl = config('vendor_constants.show_negotiated_price_wsdl');
		$endpoint = config('vendor_constants.show_negotiated_price_endpoint');

        require_once('nusoap.php');
        $paramRQ = array('Vendor_ID'=>$vendorid,'BID_Ref_NO' => $bidrefno);
		
		/* create client for my rpc web service */
		
		$client = new \nusoap_client($wsdl,true);
		// Error check
		
		$client->setCredentials(config('vendor_constants.sapusername'), config('vendor_constants.sappassword'), 'basic');
		$client->setUseCURL(true);
		
		$client->useHTTPPersistentConnection();
		
		$proxy = $client->getProxy();
		$proxy->forceEndpoint=$endpoint;
		/* call queryRcx */
		$result = $proxy->SI_VEND_BID_DATA_ECC_T0_WEB_OUT($paramRQ);
		$result['code']=200;
		return $result;
    }


public function checkvendor($arr){
    	ini_set('max_execution_time', 60000);
		$wsdl = config('vendor_constants.checkvendorlogin_wsdl');
		$endpoint = config('vendor_constants.checkvendorlogin_endpoint');

        require_once('nusoap.php');
        
        $paramRQ=$arr;
		
		$client = new \nusoap_client($wsdl,true);
		// Error check
		
		$client->setCredentials(config('vendor_constants.sapusername'), config('vendor_constants.sappassword'), 'basic');
		$client->setUseCURL(true);
		
		$client->useHTTPPersistentConnection();
		$proxy = $client->getProxy();
		if (empty($proxy)) {
			echo 'Service is down. Please try after 10 minutes.';
			die();
			exit();
		}
		$proxy->forceEndpoint=$endpoint;
		
		$result = $proxy->SI_VEND_LOGIN_VALIDATION_IN($paramRQ);
		
		// setcookie("TestCookie", serialize($result), time() + 30, '/');
		return $result;
        
    }

    public function vendorbasicinfo($vendid)
	{
		ini_set('max_execution_time', 60000);
		$wsdl = config('vendor_constants.vendorbasicinfo_wsdl');
		$endpoint = config('vendor_constants.vendorbasicinfo_endpoint');
        
		
		require_once('nusoap.php');
		$paramRQ = array('Vendor_ID'=> $vendid);
		$client = new \nusoap_client($wsdl,true);
		// Error check
		
		$client->setCredentials(config('vendor_constants.sapusername'), config('vendor_constants.sappassword'), 'basic');
		$client->setUseCURL(true);
		
		$client->useHTTPPersistentConnection();
		$proxy = $client->getProxy();
		if (empty($proxy)) {
			echo 'Service is down. Please try after 10 minutes.';
			die();
			exit();
		}
		$proxy->forceEndpoint=$endpoint;
		
		$result = $proxy->SI_VENDOR_LOGIN_SPEEDUP_OUT($paramRQ);
		
		// setcookie("TestCookie", serialize($result), time() + 30, '/');
		return $result;
	}

	public function vendor_paymenthistory_job($vendid)
	{
		ini_set('max_execution_time', 60000);
		$wsdl = config('vendor_constants.vendor_paymenthistory_job_wsdl');
		$endpoint = config('vendor_constants.vendor_paymenthistory_job_endpoint');
        
		
		require_once('nusoap.php');
		$paramRQ = array('Vendor_ID'=> $vendid);
		$client = new \nusoap_client($wsdl,true);
		// Error check
		
		$client->setCredentials(config('vendor_constants.sapusername'), config('vendor_constants.sappassword'), 'basic');
		$client->setUseCURL(true);
		
		$client->useHTTPPersistentConnection();
		$proxy = $client->getProxy();
		if (empty($proxy)) {
			echo 'Service is down. Please try after 10 minutes.';
			die();
			exit();
		}
		$proxy->forceEndpoint=$endpoint;
		
		$result = $proxy->SI_VEND_PAYMENT_HISTORY_OUT($paramRQ);
		
		// setcookie("TestCookie", serialize($result), time() + 30, '/');
		return $result;
	}

	public function vendor_complaints_job($vendid)
	{
		ini_set('max_execution_time', 60000);
		$wsdl = config('vendor_constants.vendor_complaints_job_wsdl');
		$endpoint = config('vendor_constants.vendor_complaints_job_endpoint');
        
		
		require_once('nusoap.php');
		$paramRQ = array('Vendor_ID'=> $vendid);
		$client = new \nusoap_client($wsdl,true);
		// Error check
		
		$client->setCredentials(config('vendor_constants.sapusername'), config('vendor_constants.sappassword'), 'basic');
		$client->setUseCURL(true);
		
		$client->useHTTPPersistentConnection();
		$proxy = $client->getProxy();
		if (empty($proxy)) {
			echo 'Service is down. Please try after 10 minutes.';
			die();
			exit();
		}
		$proxy->forceEndpoint=$endpoint;
		
		$result = $proxy->SI_VEND_COMPLAIANT_DETAILS_OUT($paramRQ);
		
		// setcookie("TestCookie", serialize($result), time() + 30, '/');
		return $result;
	}		

	public function vendor_pan_validation($pano)
	{
		ini_set('max_execution_time', 60000);
		$wsdl = config('vendor_constants.vendor_pan_valid_wsdl');
		$endpoint = config('vendor_constants.vendor_pan_valid_endpoint');
        
		
		require_once('nusoap.php');
		$paramRQ = array('PAN_NO'=> $pano);
		$client = new \nusoap_client($wsdl,true);
		// Error check
		
		$client->setCredentials(config('vendor_constants.sapusername'), config('vendor_constants.sappassword'), 'basic');
		$client->setUseCURL(true);
		
		$client->useHTTPPersistentConnection();
		$proxy = $client->getProxy();
		if (empty($proxy)) {
			echo 'Service is down. Please try after 10 minutes.';
			die();
			exit();
		}
		$proxy->forceEndpoint=$endpoint;
		
		$result = $proxy->SI_VEND_PAN_VALIDATION_OUT($paramRQ);
		
		// setcookie("TestCookie", serialize($result), time() + 30, '/');
		return $result;
	}

	public function vendor_pre_register_validation($arr)
	{
		ini_set('max_execution_time', 60000);
		$wsdl = config('vendor_constants.vendor_register_validation_wsdl');
		$endpoint = config('vendor_constants.vendor_register_validation_endpoint');
        
		
		require_once('nusoap.php');
		$paramRQ = $arr;
		$client = new \nusoap_client($wsdl,true);
		// Error check
		
		$client->setCredentials(config('vendor_constants.sapusername'), config('vendor_constants.sappassword'), 'basic');
		$client->setUseCURL(true);
		
		$client->useHTTPPersistentConnection();
		$proxy = $client->getProxy();
		if (empty($proxy)) {
			echo 'Service is down. Please try after 10 minutes.';
			die();
			exit();
		}
		$proxy->forceEndpoint=$endpoint;
		
		$result = $proxy->SI_VEND_REGISTRATION_VALIDATION_OUT($paramRQ);
		
		// setcookie("TestCookie", serialize($result), time() + 30, '/');
		return $result;
	}
	public function vendor_detailsupdate($arr)
	{
		ini_set('max_execution_time', 60000);
		$wsdl = config('vendor_constants.detailsupdate_wsdl');
		$endpoint = config('vendor_constants.detailsupdate_validation_endpoint');
        
		
		require_once('nusoap.php');
		$paramRQ = $arr;
		$client = new \nusoap_client($wsdl,true);
		// Error check
		
		$client->setCredentials(config('vendor_constants.sapusername'), config('vendor_constants.sappassword'), 'basic');
		$client->setUseCURL(true);
		
		$client->useHTTPPersistentConnection();
		$proxy = $client->getProxy();
		if (empty($proxy)) {
			echo 'Service is down. Please try after 10 minutes.';
			die();
			exit();
		}
		$proxy->forceEndpoint=$endpoint;
		
		$result = $proxy->SI_VEND_CHANGE_MOBILE_AND_MAIL_OUT($paramRQ);
		
		// setcookie("TestCookie", serialize($result), time() + 30, '/');
		return $result;
	}

public function requestipsend_tosap($arr)
	{
		ini_set('max_execution_time', 60000);
		$wsdl = config('vendor_constants.requestedip_wsdl');
		$endpoint = config('vendor_constants.requestedip_endpoint');
        
		
		require_once('nusoap.php');
		$paramRQ = $arr;
		$client = new \nusoap_client($wsdl,true);
		// Error check
		
		$client->setCredentials(config('vendor_constants.sapusername'), config('vendor_constants.sappassword'), 'basic');
		$client->setUseCURL(true);
		
		$client->useHTTPPersistentConnection();
		$proxy = $client->getProxy();
		if (empty($proxy)) {
			echo 'Service is down. Please try after 10 minutes.';
			die();
			exit();
		}
		$proxy->forceEndpoint=$endpoint;
		
		$result = $proxy->SI_VENDOR_GET_IP_ADDRESS_OUT($paramRQ);
		
		// setcookie("TestCookie", serialize($result), time() + 30, '/');
		return $result;
	}

public function vendorregfiles_list($vendorgroupid)
	{
		ini_set('max_execution_time', 60000);
		$wsdl = config('vendor_constants.vendorregfiles_wsdl');
		$endpoint = config('vendor_constants.vendorregfiles_endpoint');
        
		
		require_once('nusoap.php');
		$paramRQ = array('Vendor_Account_Group' => $vendorgroupid);
		$client = new \nusoap_client($wsdl,true);
		// Error check
		
		$client->setCredentials(config('vendor_constants.sapusername'), config('vendor_constants.sappassword'), 'basic');
		$client->setUseCURL(true);
		
		$client->useHTTPPersistentConnection();
		$proxy = $client->getProxy();
		if (empty($proxy)) {
			echo 'Service is down. Please try after 10 minutes.';
			die();
			exit();
		}
		$proxy->forceEndpoint=$endpoint;
		
		$result = $proxy->SI_VENDOR_LIST_OF_ATTACHMENTS_OUT($paramRQ);
		
		// setcookie("TestCookie", serialize($result), time() + 30, '/');
		return $result;
	}	

	public function searchchannelpartnerlead($plant,$mobileno){
		$wsdl = config('employee_constants.searchlead_wsdl');
		$endpoint = config('employee_constants.searchlead_endpoint');
        require_once('nusoap.php');
       
		$searchquery = '#'.$plant.'#'.$mobileno;
        
    	$paramRQ = array('Command'=>$searchquery);
        	//dd($paramRQ);
		/* create client for my rpc web service */
		
		$client = new \nusoap_client($wsdl,true);
		// Error check
		
		$client->setCredentials(config('employee_constants.sapusername'), config('employee_constants.sappassword'), 'basic');
		$client->setUseCURL(true);
		
		$client->useHTTPPersistentConnection();
		
		$proxy = $client->getProxy();
		$proxy->forceEndpoint=$endpoint;
		/* call queryRcx */
		$result = $proxy->SI_CUST_LEADSEARCH_HELP_OUT($paramRQ);
		return $result;
    }

	public function invoiceStatusTrait($vendorid){
		$wsdl = config('vendor_constants.invoicestatus_wsdl');
		$endpoint = config('vendor_constants.invoicestatus_endpoint');

        require_once('nusoap.php');
		//dd($vendorid);
        $paramRQ = array('Vendor_No' => $vendorid);//'1000000');
		// dd($paramRQ);
		/* create client for my rpc web service */
		
		$client = new \nusoap_client($wsdl,true);
		// Error check
		$client->soap_defencoding = 'UTF-8';
		$client->decode_utf8 = false;
		$client->setCredentials(config('vendor_constants.sapusername'), config('vendor_constants.sappassword'), 'basic');
		$client->setUseCURL(true);
		
		$client->useHTTPPersistentConnection();
		
		$proxy = $client->getProxy();
		$proxy->forceEndpoint=$endpoint;
		/* call queryRcx */
		$result = $proxy->SI_VEND_INVOICE_STATUS_OUT($paramRQ);
		// $result['code']=200;
		return $result;
    }

	public function invoiceAttachmentTrait($plantid,$vendorid,$vendorname,$ponumber,$invoicenumber,$url){
		$wsdl = config('vendor_constants.invoiceattachment_wsdl');
		$endpoint = config('vendor_constants.invoiceattachment_endpoint');

        require_once('nusoap.php');
		//dd($vendorid);
        $paramRQ = array('Plant_No'=>$plantid,'Vendor_No'=>$vendorid,'Vendor_Name'=>$vendorname,'PO_No'=>$ponumber,'Vendor_Invoice_No'=>$invoicenumber,'Attachemant'=>$url);//$vendorid);
		// dd($paramRQ);		
		$client = new \nusoap_client($wsdl,true);
		$client->soap_defencoding = 'UTF-8';
		$client->decode_utf8 = false;
		$client->setCredentials(config('vendor_constants.sapusername'), config('vendor_constants.sappassword'), 'basic');
		$client->setUseCURL(true);
		
		$client->useHTTPPersistentConnection();
		
		$proxy = $client->getProxy();
		$proxy->forceEndpoint=$endpoint;
		/* call queryRcx */
		$result = $proxy->SI_VEND_INVOICE_ATTACHMENT_OUT($paramRQ);
		return $result;
    }

	public function projectListTrait()
{
	$wsdl = config('vendor_constants.projectlist_wsdl');
	$endpoint = config('vendor_constants.projectlist_endpoint');

	require_once('nusoap.php');
	$paramRQ = ["Command"=>'X'];
		
	/* create client for my rpc web service */
	
	$client = new \nusoap_client($wsdl,true);
	// Error check
	
	$client->setCredentials(config('vendor_constants.sapusername'), config('vendor_constants.sappassword'), 'basic');
	$client->setUseCURL(true);
	
	$client->useHTTPPersistentConnection();
	
	$proxy = $client->getProxy();
	//dd($proxy);
	$proxy->forceEndpoint=$endpoint;
	/* call queryRcx */
	$result = $proxy->SI_VGN_PROJECT_LIST_OUT($paramRQ);
	return $result;
}
}
