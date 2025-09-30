<?php
namespace vgn\Http\Traits;

use Carbon\Carbon;


trait hsbctrait{


    public function step1hsbcprocess()
    {
		$wsdl = config('hsbc_constants.poststep1hsbcprocess_wsdl');
		$endpoint = config('hsbc_constants.poststep1hsbcprocess_endpoint');

        require_once('nusoap.php');
       
        
        $paramRQ = array('Command'=>'X');
        	//dd($paramRQ);
		/* create client for my rpc web service */
		
		$client = new \nusoap_client($wsdl,true);
		// Error check
		
		$client->setCredentials(config('hsbc_constants.sapusername'), config('hsbc_constants.sappassword'), 'basic');
		$client->setUseCURL(true);
		
		$client->useHTTPPersistentConnection();
		
		$proxy = $client->getProxy();
		$proxy->forceEndpoint=$endpoint;
		/* call queryRcx */
		$result = $proxy->SI_HSBC_ACCOUNT_CREATE_OUT($paramRQ);
		if (isset($result['Beneficiary_Details'])) {
			$beneficiary = $result['Beneficiary_Details'];

			$result['Beneficiary_Details'] = $this->validateBeneficiaryDetails($beneficiary);
        }
		
		return $result;
    }

	private function validateBeneficiaryDetails($details) 
	{
		foreach ($details as $key => $value) {
			if (!empty($value)) {
				if (in_array($key, ['Beneficiary_Name', 'Beneficiary_Bank_Name', 'Company_Name', 'Street_Name', 'City', 'State'])) {
					$details[$key] = preg_replace('/[^a-zA-Z0-9\s.,#&()-_]/', '', $value);
				} elseif (in_array($key, ['Beneficiary_Account_No', 'Company_Account_No', 'Pin_code'])) {
					$details[$key] = preg_replace('/\D/', '', $value);
				} elseif ($key === 'Amount') {
					$details[$key] = preg_replace('/[^\d.]/', '', $value);
				} elseif ($key === 'IFSC_Code') {
					$details[$key] = preg_replace('/[^a-zA-Z0-9]/', '', $value);
				}
			}
		}
		return $details;
	}

    public function step2hsbcprocess($arr)
    {
		$wsdl = config('hsbc_constants.poststep2hsbcprocess_wsdl');
		$endpoint = config('hsbc_constants.poststep2hsbcprocess_endpoint');

        require_once('nusoap.php');
       
        
        $paramRQ = $arr;
        	//dd($paramRQ);
		/* create client for my rpc web service */
		
		$client = new \nusoap_client($wsdl,true);
		// Error check
		
		$client->setCredentials(config('hsbc_constants.sapusername'), config('hsbc_constants.sappassword'), 'basic');
		$client->setUseCURL(true);
		
		$client->useHTTPPersistentConnection();
		
		$proxy = $client->getProxy();
		$proxy->forceEndpoint=$endpoint;
		/* call queryRcx */
		$result = $proxy->SI_HSBC_TRANSACTION_DETAILS_OUT($paramRQ);
		
		return $result;
    }

    public function step3hsbcprocess()
    {
		$wsdl = config('hsbc_constants.poststep3hsbcprocess_wsdl');
		$endpoint = config('hsbc_constants.poststep3hsbcprocess_endpoint');

        require_once('nusoap.php');
       
        
        $paramRQ = array('Command'=>'X');
        	//dd($paramRQ);
		/* create client for my rpc web service */
		
		$client = new \nusoap_client($wsdl,true);
		// Error check
		
		$client->setCredentials(config('hsbc_constants.sapusername'), config('hsbc_constants.sappassword'), 'basic');
		$client->setUseCURL(true);
		
		$client->useHTTPPersistentConnection();
		
		$proxy = $client->getProxy();
		$proxy->forceEndpoint=$endpoint;
		/* call queryRcx */
		$result = $proxy->SI_HSBC_PAYMENT2BANK_OUT($paramRQ);
		
		return $result;
    }

    public function step4hsbcprocess($arr)
    {
		$wsdl = config('hsbc_constants.poststep4hsbcprocess_wsdl');
		$endpoint = config('hsbc_constants.poststep4hsbcprocess_endpoint');

        require_once('nusoap.php');
       
        
        $paramRQ = $arr;
        	//dd($paramRQ);
		/* create client for my rpc web service */
		
		$client = new \nusoap_client($wsdl,true);
		// Error check
		
		$client->setCredentials(config('hsbc_constants.sapusername'), config('hsbc_constants.sappassword'), 'basic');
		$client->setUseCURL(true);
		
		$client->useHTTPPersistentConnection();
		
		$proxy = $client->getProxy();
		$proxy->forceEndpoint=$endpoint;
		/* call queryRcx */
		$result = $proxy->SI_HSBC_PAYMENT_REFERENCENUMBER_OUT($paramRQ);
		
		return $result;
    }

		

}