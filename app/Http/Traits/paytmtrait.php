<?php
namespace vgn\Http\Traits;

use Carbon\Carbon;

trait paytmtrait{

    
    public function showprojectlist()
    {
		$wsdl = config('paytm_constants.showprojectlist_wsdl');
		$endpoint = config('paytm_constants.showprojectlist_endpoint');

        require_once('nusoap.php');
		
		$paramRQ = array('Command'=> 'X');
		
		$client = new \nusoap_client($wsdl,true);
		// Error check
		
		$client->setCredentials(config('paytm_constants.sapusername'), config('paytm_constants.sappassword'), 'basic');
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
		$result = $proxy->SI_PAYTM_PROJECT_LIST_OUT($paramRQ);
		
		return $result;
    }

     public function getunitlist($projectcode)
    {
		$wsdl = config('paytm_constants.getunitlist_wsdl');
		$endpoint = config('paytm_constants.getunitlist_endpoint');

        require_once('nusoap.php');
		
		$paramRQ = array('Project_Code'=> $projectcode);
		
		$client = new \nusoap_client($wsdl,true);
		// Error check
		
		$client->setCredentials(config('paytm_constants.sapusername'), config('paytm_constants.sappassword'), 'basic');
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
		$result = $proxy->SI_PAYTM_PROJECT_DETAILS_OUT($paramRQ);
		
		return $result;
    }

     public function customervalidation($arr)
    {
		$wsdl = config('paytm_constants.customervalidation_wsdl');
		$endpoint = config('paytm_constants.customervalidation_endpoint');

        require_once('nusoap.php');
		
		$paramRQ = $arr;
		
		$client = new \nusoap_client($wsdl,true);
		// Error check
		
		$client->setCredentials(config('paytm_constants.sapusername'), config('paytm_constants.sappassword'), 'basic');
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
		$result = $proxy->SI_PAYTM_CUST_VALIDATION_OUT($paramRQ);
		
		return $result;
    }

    public function billfetchfromsap($plantcode, $customerid)
    {
		$wsdl = config('paytm_constants.billfetch_wsdl');
		$endpoint = config('paytm_constants.billfetch_endpoint');

        require_once('nusoap.php');
		
		$paramRQ = array('Customer_Id' => $customerid, 'Project_Code' => $plantcode,'Unit_No' => '','Utility_Type'=>'');
		
		$client = new \nusoap_client($wsdl,true);
		// Error check
		
		$client->setCredentials(config('paytm_constants.sapusername'), config('paytm_constants.sappassword'), 'basic');
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
		$result = $proxy->SI_PAYTM_PAYABLE_AMOUNT_OUT($paramRQ);
		
		return $result;
    }

    public function paytmpaymentpost($arr)
    {
		$wsdl = config('paytm_constants.paytmpaymentpost_wsdl');
		$endpoint = config('paytm_constants.paytmpaymentpost_endpoint');

        require_once('nusoap.php');
		
		$paramRQ = $arr;
		
		$client = new \nusoap_client($wsdl,true);
		// Error check
		
		$client->setCredentials(config('paytm_constants.sapusername'), config('paytm_constants.sappassword'), 'basic');
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
		$result = $proxy->SI_PAYTM_UPDATE_PAYMENT_DETAILS_OUT($paramRQ);
		
		return $result;
    }

    public function paytmpayment_status_check($arr)
    {
		$wsdl = config('paytm_constants.paytstatuscheck_wsdl');
		$endpoint = config('paytm_constants.paytstatuscheck_endpoint');

        require_once('nusoap.php');
		
		$paramRQ = $arr;
		
		$client = new \nusoap_client($wsdl,true);
		// Error check
		
		$client->setCredentials(config('paytm_constants.sapusername'), config('paytm_constants.sappassword'), 'basic');
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
		$result = $proxy->SI_PAYTM_PAYMENT_DETAILS_OUT($paramRQ);
		
		return $result;
    }
  

	

}