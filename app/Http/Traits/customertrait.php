<?php
namespace vgn\Http\Traits;

use Carbon\Carbon;


trait customertrait{

    
    public function savecomplaint($customerid, $cproject, $cunit, $cnature, $desccomp)
    {
		$wsdl = config('customer_constants.savecomplaint_wsdl');
		$endpoint = config('customer_constants.savecomplaint_endpoint');

        require_once('nusoap.php');
        $description=array();
		foreach(str_split($desccomp,130) as $i=>$value)
		{
			$description['Line_'.($i+1)]=$value;
		}
		$paramRQ = array('Customer_no'=>$customerid,'Project_Name'=>$cproject,'Unit_Number'=>$cunit,'Description_to_Complaint'=>$description,'Nature_Of_Complaint'=>$cnature);
		
		$client = new \nusoap_client($wsdl,true);
		// Error check
		
		$client->setCredentials(config('customer_constants.sapusername'), config('customer_constants.sappassword'), 'basic');
		$client->setUseCURL(true);
		
		$client->useHTTPPersistentConnection();
		
		$proxy = $client->getProxy();
		$proxy->forceEndpoint=$endpoint;
		/* call queryRcx */
		$result = $proxy->SI_CUST_COMP_OUT($paramRQ);
		$result['desc']=$desccomp;
		return $result;
    }

    public function closecomplaint($customerid, $complaintno){
		$wsdl = config('customer_constants.closecomplaint_wsdl');
		$endpoint = config('customer_constants.closecomplaint_endpoint');

        require_once('nusoap.php');
        $paramRQ = array('Customer_No'=>$customerid,'Compainat_No'=>$complaintno);
				
		$client = new \nusoap_client($wsdl,true);
		// Error check
		
		$client->setCredentials(config('customer_constants.sapusername'), config('customer_constants.sappassword'), 'basic');
		$client->setUseCURL(true);
		
		$client->useHTTPPersistentConnection();
		
		$proxy = $client->getProxy();
		$proxy->forceEndpoint=$endpoint;
		/* call queryRcx */
		$result = $proxy->SI_CUST_COMP_CLOSE_OUT($paramRQ);
		$result['code']=200;
		return $result;
    }

	public function insert_inspection_snag($snag, $indicator, $date, $time, $customerid, $unitno, $plantcode,$uniqueno)
{
	$wsdl = config('customer_constants.insert_inspection_snag_wsdl');
	$endpoint = config('customer_constants.insert_inspection_snag_endpoint');

	require_once('nusoap.php');
	if ($uniqueno == 0) {
		$uniqueno = '';
	}
	
$paramRQ = array('Inspection_Snag' => $snag,'Indicator' => $indicator,'Unique_No'=>$uniqueno, 'Date' => $date, 'Time' => $time,'Customer_No'=>$customerid,'Unit_No'=>$unitno, 'Plant'=>$plantcode);

$client = new \nusoap_client($wsdl,true);
// Error check

$client->setCredentials(config('customer_constants.sapusername'), config('customer_constants.sappassword'), 'basic');
$client->setUseCURL(true);

$client->useHTTPPersistentConnection();

$proxy = $client->getProxy();
$proxy->forceEndpoint=$endpoint;
//call queryRcx
$result = $proxy->SI_CUST_INSPECTIONSNAG_OUT($paramRQ);
$result['code']=200;
return $result;

}



public function get_inspection_snag($customerid, $unitno, $plantcode)
{
	$wsdl = config('customer_constants.get_inspection_snag_wsdl');
	$endpoint = config('customer_constants.get_inspection_snag_endpoint');

require_once('nusoap.php');
$paramRQ = array('Customer_No'=> $customerid,'Unit_No'=>$unitno, 'Plant'=>$plantcode);

$client = new \nusoap_client($wsdl,true);
// Error check

$client->setCredentials(config('customer_constants.sapusername'), config('customer_constants.sappassword'), 'basic');
$client->setUseCURL(true);

$client->useHTTPPersistentConnection();

$proxy = $client->getProxy();
$proxy->forceEndpoint=$endpoint;
//call queryRcx
$result = $proxy->SI_CUST_INSPECTIONSNAG_DISPLAY_OUT($paramRQ);
$result['code']=200;
return $result;

}



public function getUnsold($customerid)
{
	$wsdl = config('customer_constants.getUnsold_wsdl');
	$endpoint = config('customer_constants.getUnsold_endpoint');

	require_once('nusoap.php');
$paramRQ = array('Customer_ID'=>$customerid);

$client = new \nusoap_client($wsdl,true);
// Error check

$client->setCredentials(config('customer_constants.sapusername'), config('customer_constants.sappassword'), 'basic');
$client->setUseCURL(true);

$client->useHTTPPersistentConnection();

$proxy = $client->getProxy();
$proxy->forceEndpoint=$endpoint;
//call queryRcx
$result = $proxy->SI_Unsold_Out($paramRQ);
$result['code']=200;
return $result;

}



public function sappostreferFriend($customerid,$name, $mail, $mobile, $intrested)
	{
		$wsdl = config('customer_constants.sappostreferFriend_wsdl');
		$endpoint = config('customer_constants.sappostreferFriend_endpoint');

		require_once('nusoap.php');
		$paramRQ = array('Customer_No'=>$customerid,'Friend_Name'=>$name,'Interesed_Project'=>$intrested,'Mob_No'=>$mobile,'Email_ID'=>$mail,'Indicator'=>'C');
		
		$client = new \nusoap_client($wsdl,true);
		// Error check
		
		$client->setCredentials(config('customer_constants.sapusername'), config('customer_constants.sappassword'), 'basic');
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

	public function getCustomer($customerid)
	{
		ini_set('memory_limit', -1);
		$wsdl = config('customer_constants.getcustomer_wsdl');
		$endpoint = config('customer_constants.getcustomer_endpoint');
        
		
		require_once('nusoap.php');
		$paramRQ = array('Customer_ID'=>$customerid);
		$client = new \nusoap_client($wsdl,true,false,false,false,false,0,300);
		// Error check
		
		$client->setCredentials(config('customer_constants.sapusername'), config('customer_constants.sappassword'), 'basic');
		$client->setUseCURL(true);
		
		$client->useHTTPPersistentConnection();
		$proxy = $client->getProxy();
		if (empty($proxy)) {
			echo 'Service is down. Please try after 10 minutes.';
			die();
			exit();
		}
		$proxy->forceEndpoint=$endpoint;
		$result = $proxy->SI_Customer_Out($paramRQ);
		
		// setcookie("TestCookie", serialize($result), time() + 30, '/');
		return $result;
	}

	public function saveUserDetails($customerid, $street1, $street2, $street3, $houseno,$city,$pincode,$ctry,$reg,$tel,$mobile,$fax,$email)
	{
		$wsdl = config('customer_constants.saveUserDetails_wsdl');
		$endpoint = config('customer_constants.saveUserDetails_endpoint');

		require_once('nusoap.php');
		$paramRQ = array('Customer_ID'=>$customerid,'Address_Street_1'=>$street1,'Address_Street_2'=>$street2,'Address_Street_3'=>$street3,'Street_House_number'=>$houseno,'City'=>$city,'Postal_Code'=>$pincode,'Country'=>$ctry,'Region'=>$reg,'Telephone'=>$tel,'Mobile_No'=>$mobile,'FAX_NUMBER'=>$fax,'E_Mail'=>$email);
		
		$client = new \nusoap_client($wsdl,true);
		// Error check
		
		$client->setCredentials(config('customer_constants.sapusername'), config('customer_constants.sappassword'), 'basic');
		$client->setUseCURL(true);
		
		$client->useHTTPPersistentConnection();
		
		$proxy = $client->getProxy();
		$proxy->forceEndpoint=$endpoint;
		/* call queryRcx */
		$result = $proxy->SI_CUST_INFO_EDIT_OUT($paramRQ);
		return $result;
	}

	public function updatebankinfo($customerid,$bank_account_no,$branch_name,$ifsc_code,$bank_name){
		$wsdl = config('customer_constants.updatebankinfo_wsdl');
		$endpoint = config('customer_constants.updatebankinfo_endpoint');
		
        require_once('nusoap.php');
        $paramRQ = array('Customer_ID'=>$customerid,'Acc_No'=>$bank_account_no,'Branch_Name'=>$branch_name,'IFSC_Code'=>$ifsc_code,'Bank_Name'=>$bank_name);
		//dd($paramRQ);
		/* create client for my rpc web service */
		
		$client = new \nusoap_client($wsdl,true);
		// Error check
		
		$client->setCredentials(config('customer_constants.sapusername'), config('customer_constants.sappassword'), 'basic');
		$client->setUseCURL(true);
		
		$client->useHTTPPersistentConnection();
		
		$proxy = $client->getProxy();
		$proxy->forceEndpoint=$endpoint;
		/* call queryRcx */
		$result = $proxy->SI_CUST_BANK_DETAILS_UPDATE_OUT($paramRQ);
		$result['code']=200;
		return $result;
    }

    public function customer_satisfaction($customerid,$rating){
		$wsdl = config('customer_constants.customer_satisfaction_wsdl');
		$endpoint = config('customer_constants.customer_satisfaction_endpoint');
		
        require_once('nusoap.php');
        $paramRQ = array('Cust_ID'=>$customerid,'Satisfaction_Rate'=>$rating);
		//dd($paramRQ);
		/* create client for my rpc web service */
		
		$client = new \nusoap_client($wsdl,true);
		// Error check
		
		$client->setCredentials(config('customer_constants.sapusername'), config('customer_constants.sappassword'), 'basic');
		$client->setUseCURL(true);
		
		$client->useHTTPPersistentConnection();
		
		$proxy = $client->getProxy();
		$proxy->forceEndpoint=$endpoint;
		/* call queryRcx */
		$result = $proxy->SI_CUST_SATISFACTION_SURVEY_OUT($paramRQ);
		$result['code']=200;
		return $result;
    }

    public function getbulksmstosend_sap()
{
	ini_set('memory_limit', -1);
	$wsdl = config('customer_constants.getbulksmstosendsap_wsdl');
	$endpoint = config('customer_constants.getbulksmstosendsap_endpoint');

	require_once('nusoap.php');
	$paramRQ = ["Command"=> 'X'];
	//dd($paramRQ);
	/* create client for my rpc web service */
	
	$client = new \nusoap_client($wsdl,true,false,false,false,false,0,300);
	// Error check
	//$client->setUseCurl(true);
	//$client->loadWSDL();
	$client->setCredentials(config('customer_constants.sapusername'), config('customer_constants.sappassword'), 'basic');
	$client->setUseCURL(true);
	
	$client->useHTTPPersistentConnection();
	
	$proxy = $client->getProxy();
	$proxy->forceEndpoint=$endpoint;
	//dd($proxy);
	/* call queryRcx */
	$result = $proxy->SI_LEADS_BULK_SMS_EMAIL_DETAILS_IN($paramRQ);
	//dd($result);
	return $result;
}

public function getbulksmsstatus_out($contenuniqid)
{
	
	ini_set('memory_limit', -1);
	$wsdl = config('customer_constants.getbulksmsstatus_wsdl');
	$endpoint = config('customer_constants.getbulksmsstatus_endpoint');

	require_once('nusoap.php');
	$paramRQ['Details'] = ["Content_Unique_ID"=> $contenuniqid,'Init_Ind' => ''];
	//dd($paramRQ);
	/* create client for my rpc web service */
	
	$client = new \nusoap_client($wsdl,true,false,false,false,false,0,300);
	// Error check
	
	$client->setCredentials(config('customer_constants.sapusername'), config('customer_constants.sappassword'), 'basic');
	$client->setUseCURL(true);
	
	$client->useHTTPPersistentConnection();
	
	$proxy = $client->getProxy();
	$proxy->forceEndpoint=$endpoint;
	//dd($proxy);
	/* call queryRcx */
	$result = $proxy->SI_LEADS_BULK_SMS_EMAIL_STATUS_OUT($paramRQ);
	
	return $result;
}

public function getproject_netbalance($customerid)
	{
		$wsdl = config('customer_constants.getcustomerprojectnetbalance_wsdl');
		$endpoint = config('customer_constants.getcustomerprojectnetbalance_endpoint');
        
		
		require_once('nusoap.php');
		$paramRQ = array('CUSTOMER_ID'=>$customerid);
		$client = new \nusoap_client($wsdl,true,false,false,false,false,0,300);
		// Error check
		
		$client->setCredentials(config('customer_constants.sapusername'), config('customer_constants.sappassword'), 'basic');
		$client->setUseCURL(true);
		
		$client->useHTTPPersistentConnection();
		$proxy = $client->getProxy();
		if (empty($proxy)) {
			echo 'Service is down. Please try after 10 minutes.';
			die();
			exit();
		}
		$proxy->forceEndpoint=$endpoint;
		
		$result = $proxy->SI_CUST_PAYMENT_BILLDESK_OUT($paramRQ);
		
		// setcookie("TestCookie", serialize($result), time() + 30, '/');
		return $result;
	}

	public function send_billdesk_transactiontosap($tosapdetails)
	{
		$wsdl = config('customer_constants.send_billdesktosap_wsdl');
		$endpoint = config('customer_constants.send_billdesktosap_endpoint');
        
		
		require_once('nusoap.php');
		$paramRQ = $tosapdetails;
		//dd($paramRQ);

		$client = new \nusoap_client($wsdl,true);
		// Error check
		
		$client->setCredentials(config('customer_constants.sapusername'), config('customer_constants.sappassword'), 'basic');
		$client->setUseCURL(true);
		
		$client->useHTTPPersistentConnection();
		$proxy = $client->getProxy();
		
		if (empty($proxy)) {
			echo 'Service is down. Please try after 10 minutes.';
			die();
			exit();
		}
		$proxy->forceEndpoint=$endpoint;
		
		$result = $proxy->SI_CUST_PAYMENT_TRANSACTION_BILLDESK_IN($paramRQ);
				// setcookie("TestCookie", serialize($result), time() + 30, '/');
		return $result;
	}

	public function getreg_details_availbank()
	{
		$wsdl = config('customer_constants.getregbank_details_wsdl');
		$endpoint = config('customer_constants.getregbank_details_endpoint');
        
		
		require_once('nusoap.php');
		$paramRQ = array('Command'=>'X');
		$client = new \nusoap_client($wsdl,true,false,false,false,false,0,300);
		// Error check
		
		$client->setCredentials(config('customer_constants.sapusername'), config('customer_constants.sappassword'), 'basic');
		$client->setUseCURL(true);
		
		$client->useHTTPPersistentConnection();
		$proxy = $client->getProxy();
		if (empty($proxy)) {
			echo 'Service is down. Please try after 10 minutes.';
			die();
			exit();
		}
		$proxy->forceEndpoint=$endpoint;
		
		$result = $proxy->SI_SA_LISTOF_BANK_DETAILS_IN($paramRQ);
		
		// setcookie("TestCookie", serialize($result), time() + 30, '/');
		return $result;
	}

	public function postreg_details__to_sap($arr)
	{
		$wsdl = config('customer_constants.postregbank_detailsto_sap_wsdl');
		$endpoint = config('customer_constants.postregbank_detailsto_sap_endpoint');
        
		
		require_once('nusoap.php');
		$paramRQ = $arr;
		$client = new \nusoap_client($wsdl,true,false,false,false,false,0,300);
		// Error check
		
		$client->setCredentials(config('customer_constants.sapusername'), config('customer_constants.sappassword'), 'basic');
		$client->setUseCURL(true);
		
		$client->useHTTPPersistentConnection();
		$proxy = $client->getProxy();
		if (empty($proxy)) {
			echo 'Service is down. Please try after 10 minutes.';
			die();
			exit();
		}
		$proxy->forceEndpoint=$endpoint;
		
		$result = $proxy->SI_CUST_SA_REGISTRATION_DETAILS_OUT($paramRQ);
		
		// setcookie("TestCookie", serialize($result), time() + 30, '/');
		return $result;
	}

	public function getpostedreg_details__to_sap($arr)
	{
		$wsdl = config('customer_constants.get_posted_regbank_detailsfrom_sap_wsdl');
		$endpoint = config('customer_constants.get_posted_regbank_detailsfrom_sap_endpoint');
        
		
		require_once('nusoap.php');
		$paramRQ = $arr;
		$client = new \nusoap_client($wsdl,true,false,false,false,false,0,300);
		// Error check
		
		$client->setCredentials(config('customer_constants.sapusername'), config('customer_constants.sappassword'), 'basic');
		$client->setUseCURL(true);
		
		$client->useHTTPPersistentConnection();
		$proxy = $client->getProxy();
		if (empty($proxy)) {
			echo 'Service is down. Please try after 10 minutes.';
			die();
			exit();
		}
		$proxy->forceEndpoint=$endpoint;
		
		$result = $proxy->SI_CUST_SHOW_REGISTERED_SALEAGREEMENT_OUT($paramRQ);
		
		// setcookie("TestCookie", serialize($result), time() + 30, '/');
		return $result;
	}

	public function checksale_agreement_takenfromsap($arr)
	{
		$wsdl = config('customer_constants.check_saleagreement_taken_sap_wsdl');
		$endpoint = config('customer_constants.check_saleagreement_taken_sap_endpoint');
        
		
		require_once('nusoap.php');
		$paramRQ = $arr;
		$client = new \nusoap_client($wsdl,true,false,false,false,false,0,300);
		// Error check
		
		$client->setCredentials(config('customer_constants.sapusername'), config('customer_constants.sappassword'), 'basic');
		$client->setUseCURL(true);
		
		$client->useHTTPPersistentConnection();
		$proxy = $client->getProxy();
		if (empty($proxy)) {
			echo 'Service is down. Please try after 10 minutes.';
			die();
			exit();
		}
		$proxy->forceEndpoint=$endpoint;
		
		$result = $proxy->SI_CUST_SALEAGREEMENT_STATUS_OUT($paramRQ);
		
		// setcookie("TestCookie", serialize($result), time() + 30, '/');
		return $result;
	}

	public function postsalesprocessfeedback($customerid, $saleorderid, $feedback)
	{
		$wsdl = config('customer_constants.postsalesprocess_feedback_wsdl');
		$endpoint = config('customer_constants.postsalesprocess_feedback_endpoint');
        
		
		require_once('nusoap.php');
		$paramRQ = ['Cust_ID' => $customerid, 'Sale_ID' => $saleorderid, 'Feedback' => $feedback];
		$client = new \nusoap_client($wsdl,true,false,false,false,false,0,300);
		// Error check
		
		$client->setCredentials(config('customer_constants.sapusername'), config('customer_constants.sappassword'), 'basic');
		$client->setUseCURL(true);
		
		$client->useHTTPPersistentConnection();
		$proxy = $client->getProxy();
		if (empty($proxy)) {
			echo 'Service is down. Please try after 10 minutes.';
			die();
			exit();
		}
		$proxy->forceEndpoint=$endpoint;
		
		$result = $proxy->SI_CUST_SALEPROCESS_FEEDBACK_IN($paramRQ);
		
		// setcookie("TestCookie", serialize($result), time() + 30, '/');
		return $result;
	}
	
	public function postsapsalesitefeedback($arr){
    	ini_set('max_execution_time', 60000);
		$wsdl = config('customer_constants.salesitefeedback_wsdl');
		$endpoint = config('customer_constants.postsalesitefeedback_endpoint');

        require_once('nusoap.php');
        
        $paramRQ=$arr;
		
		$client = new \nusoap_client($wsdl,true);
		// Error check
		
		$client->setCredentials(config('customer_constants.sapusername'), config('customer_constants.sappassword'), 'basic');
		$client->setUseCURL(true);
		
		$client->useHTTPPersistentConnection();
		$proxy = $client->getProxy();
		if (empty($proxy)) {
			echo 'Service is down. Please try after 10 minutes.';
			die();
			exit();
		}
		$proxy->forceEndpoint=$endpoint;
		
		$result = $proxy->SI_CUST_SITEVISIT_FEEDBACK_OUT($paramRQ);
		
		// setcookie("TestCookie", serialize($result), time() + 30, '/');
		return $result;
        
    }

public function checkcustomer($arr){
    	ini_set('max_execution_time', 60000);
		$wsdl = config('customer_constants.checkcustomerlogin_wsdl');
		$endpoint = config('customer_constants.checkcustomerlogin_endpoint');

        require_once('nusoap.php');
        
        $paramRQ=$arr;
		
		$client = new \nusoap_client($wsdl,true);
		// Error check
		
		$client->setCredentials(config('customer_constants.sapusername'), config('customer_constants.sappassword'), 'basic');
		$client->setUseCURL(true);
		
		$client->useHTTPPersistentConnection();
		$proxy = $client->getProxy();
		if (empty($proxy)) {
			echo 'Service is down. Please try after 10 minutes.';
			die();
			exit();
		}
		$proxy->forceEndpoint=$endpoint;
		
		$result = $proxy->SI_CUST_LOGIN_VALIDATION_OUT($paramRQ);
		
		// setcookie("TestCookie", serialize($result), time() + 30, '/');
		return $result;
        
    }

public function getbhkdetails($arr)
    {
    	ini_set('max_execution_time', 60000);
		$wsdl = config('customer_constants.getbhkwsdl_wsdl');
		$endpoint = config('customer_constants.getbhkwsdl_endpoint');

        require_once('nusoap.php');
        
        $paramRQ=$arr;
		
		$client = new \nusoap_client($wsdl,true);
		// Error check
		
		$client->setCredentials(config('customer_constants.sapusername'), config('customer_constants.sappassword'), 'basic');
		$client->setUseCURL(true);
		
		$client->useHTTPPersistentConnection();
		$proxy = $client->getProxy();
		if (empty($proxy)) {
			echo 'Service is down. Please try after 10 minutes.';
			die();
			exit();
		}
		$proxy->forceEndpoint=$endpoint;
		
		$result = $proxy->SI_CUST_HOUSEHOLD_DETAILS_OUT($paramRQ);
		
		// setcookie("TestCookie", serialize($result), time() + 30, '/');
		return $result;
    }

public function postinteriors_interest($saleorderno)
    {
    	ini_set('max_execution_time', 60000);
		$wsdl = config('customer_constants.postinteriors_interest_wsdl');
		$endpoint = config('customer_constants.postinteriors_interest_endpoint');

        require_once('nusoap.php');
        
        $paramRQ = ['Sale_Order' => $saleorderno, 'Interest' => 'X'];
		
		$client = new \nusoap_client($wsdl,true);
		// Error check
		
		$client->setCredentials(config('customer_constants.sapusername'), config('customer_constants.sappassword'), 'basic');
		$client->setUseCURL(true);
		
		$client->useHTTPPersistentConnection();
		$proxy = $client->getProxy();
		if (empty($proxy)) {
			echo 'Service is down. Please try after 10 minutes.';
			die();
			exit();
		}
		$proxy->forceEndpoint=$endpoint;
		
		$result = $proxy->SI_CUST_INTERIOR_INTEREST_OUT($paramRQ);
		
		// setcookie("TestCookie", serialize($result), time() + 30, '/');
		return $result;
    }


public function posthomebuilding_interest($saleorderno)
    {
    	ini_set('max_execution_time', 60000);
		$wsdl = config('customer_constants.posthomebuilding_interest_wsdl');
		$endpoint = config('customer_constants.posthomebuilding_interest_endpoint');

        require_once('nusoap.php');
        
        $paramRQ = ['Sale_Order' => $saleorderno, 'Interest' => 'X'];
		
		$client = new \nusoap_client($wsdl,true);
		// Error check
		
		$client->setCredentials(config('customer_constants.sapusername'), config('customer_constants.sappassword'), 'basic');
		$client->setUseCURL(true);
		
		$client->useHTTPPersistentConnection();
		$proxy = $client->getProxy();
		if (empty($proxy)) {
			echo 'Service is down. Please try after 10 minutes.';
			die();
			exit();
		}
		$proxy->forceEndpoint=$endpoint;
		
		$result = $proxy->SI_CUST_HOMEBUILDING_INTEREST_OUT($paramRQ);
		
		// setcookie("TestCookie", serialize($result), time() + 30, '/');
		return $result;
    }

 public function getcustdisatreasons($customerid)
    {
    	ini_set('max_execution_time', 60000);
		$wsdl = config('customer_constants.getcustdisatreason_wsdl');
		$endpoint = config('customer_constants.getcustdisatreason_endpoint');

        require_once('nusoap.php');
        
        $paramRQ = ['Customer_ID' => $customerid];
		
		$client = new \nusoap_client($wsdl,true);
		// Error check
		
		$client->setCredentials(config('customer_constants.sapusername'), config('customer_constants.sappassword'), 'basic');
		$client->setUseCURL(true);
		
		$client->useHTTPPersistentConnection();
		$proxy = $client->getProxy();
		if (empty($proxy)) {
			echo 'Service is down. Please try after 10 minutes.';
			die();
			exit();
		}
		$proxy->forceEndpoint=$endpoint;
		
		$result = $proxy->SI_CUST_DISSATISFIED_REASONLIST_OUT($paramRQ);
		
		// setcookie("TestCookie", serialize($result), time() + 30, '/');
		return $result;
    }

    public function postcustdisatreasons($customerid, $reason, $rating)
    {
    	ini_set('max_execution_time', 60000);
		$wsdl = config('customer_constants.postdissat_reason_wsdl');
		$endpoint = config('customer_constants.postdissat_reason_endpoint');

        require_once('nusoap.php');
        
        $paramRQ = ['Customer_ID' => $customerid, 'Reason'=>$reason, 'Level_Of_Satisfaction'=>$rating];
		
		$client = new \nusoap_client($wsdl,true);
		// Error check
		
		$client->setCredentials(config('customer_constants.sapusername'), config('customer_constants.sappassword'), 'basic');
		$client->setUseCURL(true);
		
		$client->useHTTPPersistentConnection();
		$proxy = $client->getProxy();
		if (empty($proxy)) {
			echo 'Service is down. Please try after 10 minutes.';
			die();
			exit();
		}
		$proxy->forceEndpoint=$endpoint;
		
		$result = $proxy->SI_CUST_DISSATISFIED_REASONDETAILS_OUT($paramRQ);
		
		// setcookie("TestCookie", serialize($result), time() + 30, '/');
		return $result;
    }

public function occupantsdetails($arr)
    {
    	ini_set('max_execution_time', 60000);
		$wsdl = config('customer_constants.occupantdetails_wsdl');
		$endpoint = config('customer_constants.occupantdetails_endpoint');

        require_once('nusoap.php');
        
        $paramRQ = $arr;
		
		$client = new \nusoap_client($wsdl,true);
		// Error check
		
		$client->setCredentials(config('customer_constants.sapusername'), config('customer_constants.sappassword'), 'basic');
		$client->setUseCURL(true);
		
		$client->useHTTPPersistentConnection();
		$proxy = $client->getProxy();
		if (empty($proxy)) {
			echo 'Service is down. Please try after 10 minutes.';
			die();
			exit();
		}
		$proxy->forceEndpoint=$endpoint;
		
		$result = $proxy->SI_CUST_SECONDOWNER_DETAILS_UPDATE_OUT($paramRQ);
		
		// setcookie("TestCookie", serialize($result), time() + 30, '/');
		return $result;
    }

public function customerbasicinfo($custid)
	{
		$wsdl = config('customer_constants.customerbasicinfo_wsdl');
		$endpoint = config('customer_constants.customerbasicinfo_endpoint');
        
		
		require_once('nusoap.php');
		$paramRQ = array('Customer_ID'=> $custid);
		$client = new \nusoap_client($wsdl,true,false,false,false,false,0,300);
		// Error check
		
		$client->setCredentials(config('customer_constants.sapusername'), config('customer_constants.sappassword'), 'basic');
		$client->setUseCURL(true);
		
		$client->useHTTPPersistentConnection();
		$proxy = $client->getProxy();
		if (empty($proxy)) {
			echo 'Service is down. Please try after 10 minutes.';
			die();
			exit();
		}
		$proxy->forceEndpoint=$endpoint;
		
		$result = $proxy->SI_CUSTOMER_PROJECT_DETAILS_OUT($paramRQ);
		
		// setcookie("TestCookie", serialize($result), time() + 30, '/');
		return $result;
	}

public function customer_paymenthistory_job($custid)
	{
		$wsdl = config('customer_constants.customer_paymenthistory_job_wsdl');
		$endpoint = config('customer_constants.customer_paymenthistory_job_endpoint');
        
		
		require_once('nusoap.php');
		$paramRQ = array('Customer_ID'=> $custid);
		$client = new \nusoap_client($wsdl,true,false,false,false,false,0,300);
		// Error check
		
		$client->setCredentials(config('customer_constants.sapusername'), config('customer_constants.sappassword'), 'basic');
		$client->setUseCURL(true);
		
		$client->useHTTPPersistentConnection();
		$proxy = $client->getProxy();
		if (empty($proxy)) {
			echo 'Service is down. Please try after 10 minutes.';
			die();
			exit();
		}
		$proxy->forceEndpoint=$endpoint;
		
		$result = $proxy->SI_CUSTOMER_PAYMENT_HISTORY_OUT($paramRQ);
		
		// setcookie("TestCookie", serialize($result), time() + 30, '/');
		return $result;
	}

	public function customer_complaints_job($custid)
	{
		$wsdl = config('customer_constants.customer_complaints_job_wsdl');
		$endpoint = config('customer_constants.customer_complaints_job_endpoint');
        
		
		require_once('nusoap.php');
		$paramRQ = array('Customer_ID'=> $custid);
		$client = new \nusoap_client($wsdl,true,false,false,false,false,0,300);
		// Error check
		
		$client->setCredentials(config('customer_constants.sapusername'), config('customer_constants.sappassword'), 'basic');
		$client->setUseCURL(true);
		
		$client->useHTTPPersistentConnection();
		$proxy = $client->getProxy();
		if (empty($proxy)) {
			echo 'Service is down. Please try after 10 minutes.';
			die();
			exit();
		}
		$proxy->forceEndpoint=$endpoint;
		
		$result = $proxy->SI_CUSTOMER_COMPLAINT_DETAILSS_OUT($paramRQ);
		
		// setcookie("TestCookie", serialize($result), time() + 30, '/');
		return $result;
	}

	public function natureofcomplaints($custid)
	{
		$wsdl = config('customer_constants.Natureofcomplaints_wsdl');
		$endpoint = config('customer_constants.Natureofcomplaints_endpoint');
        
		
		require_once('nusoap.php');
		$paramRQ = array('Customer_ID'=> $custid);
		$client = new \nusoap_client($wsdl,true,false,false,false,false,0,300);
		// Error check
		
		$client->setCredentials(config('customer_constants.sapusername'), config('customer_constants.sappassword'), 'basic');
		$client->setUseCURL(true);
		
		$client->useHTTPPersistentConnection();
		$proxy = $client->getProxy();
		if (empty($proxy)) {
			echo 'Service is down. Please try after 10 minutes.';
			die();
			exit();
		}
		$proxy->forceEndpoint=$endpoint;
		
		$result = $proxy->SI_CUSTOMER_NATURE_OF_COMP_OUT($paramRQ);
		
		// setcookie("TestCookie", serialize($result), time() + 30, '/');
		return $result;
	}

	public function cust_communication_details($custid)
	{
		$wsdl = config('customer_constants.cust_communication_wsdl');
		$endpoint = config('customer_constants.cust_communication_endpoint');
        
		
		require_once('nusoap.php');
		$paramRQ = array('Customer_ID'=> $custid);
		$client = new \nusoap_client($wsdl,true,false,false,false,false,0,300);
		// Error check
		
		$client->setCredentials(config('customer_constants.sapusername'), config('customer_constants.sappassword'), 'basic');
		$client->setUseCURL(true);
		
		$client->useHTTPPersistentConnection();
		$proxy = $client->getProxy();
		if (empty($proxy)) {
			echo 'Service is down. Please try after 10 minutes.';
			die();
			exit();
		}
		$proxy->forceEndpoint=$endpoint;
		
		$result = $proxy->SI_CUSTOMER_COMMUNICATION_DETAILS_OUT($paramRQ);
		
		// setcookie("TestCookie", serialize($result), time() + 30, '/');
		return $result;
	}

	public function saverentselloptionfrom_cust_tosap($arr)
	{
		ini_set('max_execution_time', 60000);
		$wsdl = config('customer_constants.cust_rentsellpost_wsdl');
		$endpoint = config('customer_constants.cust_rentsellpost_endpoint');
        
		
		require_once('nusoap.php');
		$paramRQ = $arr;
		$client = new \nusoap_client($wsdl,true);
		// Error check
		
		$client->setCredentials(config('customer_constants.sapusername'), config('customer_constants.sappassword'), 'basic');
		$client->setUseCURL(true);
		
		$client->useHTTPPersistentConnection();
		$proxy = $client->getProxy();
		if (empty($proxy)) {
			echo 'Service is down. Please try after 10 minutes.';
			die();
			exit();
		}
		$proxy->forceEndpoint=$endpoint;
		
		$result = $proxy->SI_CUST_GET_RENT_SELL_OUT($paramRQ);
		
		// setcookie("TestCookie", serialize($result), time() + 30, '/');
		return $result;
	}

public function postplotcare_interest($saleorderno)
    {
        ini_set('max_execution_time', 60000);
        $wsdl = config('customer_constants.postplotcare_interest_wsdl');
        $endpoint = config('customer_constants.postplotcare_interest_endpoint');

        require_once 'nusoap.php';

        $paramRQ = ['Sale_Order' => $saleorderno, 'Interest' => 'X'];

        $client = new \nusoap_client($wsdl, true);
        // Error check

        $client->setCredentials(config('customer_constants.sapusername'), config('customer_constants.sappassword'), 'basic');
        $client->setUseCURL(true);

        $client->useHTTPPersistentConnection();
        $proxy = $client->getProxy();
        if (empty($proxy)) {
            echo 'Service is down. Please try after 10 minutes.';
            die();
            exit();
        }
        $proxy->forceEndpoint = $endpoint;

        $result = $proxy->SI_CUST_PLOT_CARE_INTEREST_OUT($paramRQ);

        // setcookie("TestCookie", serialize($result), time() + 30, '/');
        return $result;
    }

public function check_gen_paymentlink()
    {
        ini_set('max_execution_time', 60000);
        $wsdl = config('customer_constants.checkgenpayment_wsdl');
        $endpoint = config('customer_constants.checkgenpayment_endpoint');

        require_once 'nusoap.php';

        $paramRQ = ['Command' => 'X'];

        $client = new \nusoap_client($wsdl, true);
        // Error check

        $client->setCredentials(config('customer_constants.sapusername'), config('customer_constants.sappassword'), 'basic');
        $client->setUseCURL(true);

        $client->useHTTPPersistentConnection();
        $proxy = $client->getProxy();
        if (empty($proxy)) {
            echo 'Service is down. Please try after 10 minutes.';
            die();
            exit();
        }
        $proxy->forceEndpoint = $endpoint;

        $result = $proxy->SI_CUST_BILLDESK_CREATE_SHORTLINK_OUT($paramRQ);

        // setcookie("TestCookie", serialize($result), time() + 30, '/');
        return $result;
    }

    public function postcheck_gen_paymentlinkdata($arr)
    {
        ini_set('max_execution_time', 60000);
        $wsdl = config('customer_constants.postcheck_gen_paymentlinkdata_wsdl');
        $endpoint = config('customer_constants.postcheck_gen_paymentlinkdata_endpoint');

        require_once 'nusoap.php';

        $paramRQ = $arr;

        $client = new \nusoap_client($wsdl, true);
        // Error check

        $client->setCredentials(config('customer_constants.sapusername'), config('customer_constants.sappassword'), 'basic');
        $client->setUseCURL(true);

        $client->useHTTPPersistentConnection();
        $proxy = $client->getProxy();
        if (empty($proxy)) {
            echo 'Service is down. Please try after 10 minutes.';
            die();
            exit();
        }
        $proxy->forceEndpoint = $endpoint;

        $result = $proxy->SI_CUST_BILLDESK_SENDING_SHORTLINK_OUT($paramRQ);

        // setcookie("TestCookie", serialize($result), time() + 30, '/');
        return $result;
    }

}
