<?php
namespace vgn\Http\Traits;

use Carbon\Carbon;

trait ameyotrait{

    
    public function showleaddetails($mobileno)
    {
		$wsdl = config('ameyo_constants.showleaddetails_wsdl');
		$endpoint = config('ameyo_constants.showleaddetails_endpoint');

        require_once('nusoap.php');
		
		$paramRQ = array('Mobile_Number'=>$mobileno);
		
		$client = new \nusoap_client($wsdl,true);
		// Error check
		
		$client->setCredentials(config('ameyo_constants.sapusername'), config('ameyo_constants.sappassword'), 'basic');
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
		$result = $proxy->SI_AMEYO_SHOW_LEADDETAILS_OUT($paramRQ);
		
		return $result;
    }

public function showdetailsby_leadno($leadno)
    {
		$wsdl = config('ameyo_constants.showleaddetailsbyleadno_wsdl');
		$endpoint = config('ameyo_constants.showleaddetailsbyleadno_endpoint');

        require_once('nusoap.php');
		
		$paramRQ = array('Lead_No'=>$leadno);
		
		$client = new \nusoap_client($wsdl,true);
		// Error check
		
		$client->setCredentials(config('ameyo_constants.sapusername'), config('ameyo_constants.sappassword'), 'basic');
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
		$result = $proxy->SI_AMEYO_DETAILS_BY_LEAD_NO_OUT($paramRQ);
		
		return $result;
    }

	public function showdetailsby_SaleOrderno($saleno)
    {
		$wsdl = config('ameyo_constants.showleaddetailsbyleadno_wsdl');
		$endpoint = config('ameyo_constants.showleaddetailsbyleadno_endpoint');

        require_once('nusoap.php');

		$saleOrderNo = 'S'.$saleno;
		
		$paramRQ = array('Lead_No'=>$saleOrderNo);
		
		$client = new \nusoap_client($wsdl,true);
		// Error check
		
		$client->setCredentials(config('ameyo_constants.sapusername'), config('ameyo_constants.sappassword'), 'basic');
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
		$result = $proxy->SI_AMEYO_DETAILS_BY_LEAD_NO_OUT($paramRQ);
		
		return $result;
    }

	public function show_saleOrderNoDetails($mobileno)
    {
		$wsdl = config('ameyo_constants.showleaddetails_wsdl');
		$endpoint = config('ameyo_constants.showleaddetails_endpoint');

        require_once('nusoap.php');

		
		$saleOrderNo = 'S'.$mobileno;
		
		$paramRQ = array('Mobile_Number'=>$saleOrderNo);
		
		$client = new \nusoap_client($wsdl,true);
		// Error check
		
		$client->setCredentials(config('ameyo_constants.sapusername'), config('ameyo_constants.sappassword'), 'basic');
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
		$result = $proxy->SI_AMEYO_SHOW_LEADDETAILS_OUT($paramRQ);
		
		return $result;
    }

    public function postleaddetails($arr)
    {
    	$wsdl = config('ameyo_constants.postleaddetails_wsdl');
		$endpoint = config('ameyo_constants.postleaddetails_endpoint');

        require_once('nusoap.php');		
		$paramRQ = $arr;
		
		$client = new \nusoap_client($wsdl,true);
		// Error check
		
		$client->setCredentials(config('ameyo_constants.sapusername'), config('ameyo_constants.sappassword'), 'basic');
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
		$result = $proxy->SI_AMEYO_CREATE_FRESH_LEAD_OUT($paramRQ);
		
		return $result;
    }

    public function postleaddetails_new($arr)
    {
    	$wsdl = config('ameyo_constants.postleaddetailsnew_wsdl');
		$endpoint = config('ameyo_constants.postleaddetailsnew_endpoint');

        require_once('nusoap.php');		
		$paramRQ = $arr;
		//dd($paramRQ);
		
		$client = new \nusoap_client($wsdl,true);
		// Error check
		
		$client->setCredentials(config('ameyo_constants.sapusername'), config('ameyo_constants.sappassword'), 'basic');
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
		$result = $proxy->SI_AMEYO_CREATE_FRESH_LEAD_1_OUT($paramRQ);
		
		return $result;
    }

    public function find_exec_details($mobileno)
    {
		$wsdl = config('ameyo_constants.crm_execshow_wsdl');
		$endpoint = config('ameyo_constants.crm_execshow_endpoint');

        require_once('nusoap.php');		
		$paramRQ = array('Mobile_Number'=>$mobileno);
		
		$client = new \nusoap_client($wsdl,true);
		// Error check
		
		$client->setCredentials(config('ameyo_constants.sapusername'), config('ameyo_constants.sappassword'), 'basic');
		$client->setUseCURL(true);
		
		$client->useHTTPPersistentConnection();
		
		$proxy = $client->getProxy();
		if (empty($proxy)) {
			return ["CC_ID" => "","CC_Name" => ""];
			//echo 'Service is down. Please try after 10 minutes.';
			//die();
			//exit();
		}
		$proxy->forceEndpoint=$endpoint;
		/* call queryRcx */
		$result = $proxy->SI_AMEYO_FIND_EXECUTIVE_DETAILS_OUT($paramRQ);
	        if($result["CC_ID"] == 'NULL'){ return ["CC_ID" => "","CC_Name" => ""]; }
		
		return $result;
    }

    public function get_crm_email($emailid)
    {
    	$wsdl = config('ameyo_constants.get_crm_email_wsdl');
		$endpoint = config('ameyo_constants.get_crm_email_endpoint');

        require_once('nusoap.php');
		
		$paramRQ = array('Email_ID'=>$emailid);
		
		$client = new \nusoap_client($wsdl,true);
		// Error check
		
		$client->setCredentials(config('ameyo_constants.sapusername'), config('ameyo_constants.sappassword'), 'basic');
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
		$result = $proxy->SI_AMEYO_FIND_EXECUTIVE_EMAIL_OUT($paramRQ);
		
		return $result;
    }

    public function get_customerpaymentdetails($mobileno)
    {
    	ini_set('max_execution_time', 60000);
    	$wsdl = config('ameyo_constants.customer_paymentdetails_wsdl');
		$endpoint = config('ameyo_constants.customer_paymentdetails_endpoint');

        require_once('nusoap.php');
		
		$paramRQ = array('Mobile_Number'=>$mobileno);
		
		$client = new \nusoap_client($wsdl,true);
		// Error check
		
		$client->setCredentials(config('ameyo_constants.sapusername'), config('ameyo_constants.sappassword'), 'basic');
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
		$result = $proxy->SI_AMEYO_CUST_PAYMENT_DETAILS_IN($paramRQ);
		
		return $result;
    }


public function get_customerpaymentdetailsby_leadno($custid)
    {
    	ini_set('max_execution_time', 60000);
    	$wsdl = config('ameyo_constants.customer_detailsbycustid_wsdl');
		$endpoint = config('ameyo_constants.customer_detailsbycustid_endpoint');

        require_once('nusoap.php');
		
		$paramRQ = array('CUST_ID'=>$custid);
		
		$client = new \nusoap_client($wsdl,true);
		// Error check
		
		$client->setCredentials(config('ameyo_constants.sapusername'), config('ameyo_constants.sappassword'), 'basic');
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
		$result = $proxy->SI_AMEYO_DETAILS_By_CUST_ID_OUT($paramRQ);
		
		return $result;
    }

public function getactive_campaignlist()
    {
    	$wsdl = config('ameyo_constants.getactivecampaign_wsdl');
		$endpoint = config('ameyo_constants.getactivecampaign_endpoint');

        require_once('nusoap.php');		
		$paramRQ = array('Command' => 'X');
		
		$client = new \nusoap_client($wsdl,true);
		// Error check
		
		$client->setCredentials(config('ameyo_constants.sapusername'), config('ameyo_constants.sappassword'), 'basic');
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
		$result = $proxy->SI_AMEYO_CAMPAIGN_CODE_LIST_OUT($paramRQ);
		
		return $result;
    }	

}
