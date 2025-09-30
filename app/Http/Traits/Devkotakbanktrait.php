<?php
namespace vgn\Http\Traits;

use Carbon\Carbon;


trait Devkotakbanktrait{

    private $sapusername = 'suthaanand';
    private $sappassword = 'init1234';

    public function GetSapDataProcess1_soap()
    {
        require_once('nusoap.php');
        
		$paramRQ = array('Command'=>'X');
		
		/* create client for my rpc web service */
		$wsdl = "http://vgnsap.vgn.in:50000/dir/wsdl?p=ic/f1c5e4385c7a3560b6f77abd0c36f1ac";
		$client = new \nusoap_client($wsdl,true);
		// Error check
		
		$client->setCredentials($this->sapusername, $this->sappassword, 'basic');
		$client->setUseCURL(true);
		
		$client->useHTTPPersistentConnection();
		
		$proxy = $client->getProxy();
		$proxy->forceEndpoint="http://vgnsap.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BS_WEB&receiverParty=&receiverService=&interface=SI_BANK_DATA_PROCESS_OUT&interfaceNamespace=http%3A%2F%2Fsap_employee_zone.com";
		/* call queryRcx */
		$result = $proxy->SI_BANK_DATA_PROCESS_OUT($paramRQ);
		
		return $result;
    }

    public function SendportalResponse($Company_Code,$Document_No,$Posting_Date,$Beneficiary_Name,$Beneficiary_Account,$Bank_Name,$IFSC_Code,$Payment_Amount,$Trans_Type,$Ref_No,$Fiscal_Year,$company_acct_no)
    {
        require_once('nusoap.php');
        $paramRQ = array();
		$paramRQ['Details'] = array('Company_Code'=>$Company_Code,'Document_No'=>$Document_No,'Posting_Date'=>$Posting_Date,
							'Beneficiary_Name'=>$Beneficiary_Name,
							'Beneficiary_Account'=>$Beneficiary_Account,
							'Bank_Name'=>$Bank_Name,
							'IFSC_Code'=>$IFSC_Code,
							'Payment_Amount'=>$Payment_Amount,
							'Trans_Type'=>$Trans_Type,
							'Ref_No'=>$Ref_No,
							'Portal_Ind'=>'X',
							'Fiscal_Year'=>$Fiscal_Year,
							'Company_Bank_Acc' => $company_acct_no
							);
		
		/* create client for my rpc web service */
		$wsdl = "http://vgnsap.vgn.in:50000/dir/wsdl?p=ic/00f863c2a0db30cb924f8a85db53edb6";
		$client = new \nusoap_client($wsdl,true);
		// Error check
		
		$client->setCredentials($this->sapusername, $this->sappassword, 'basic');
		$client->setUseCURL(true);
		
		$client->useHTTPPersistentConnection();
		
		$proxy = $client->getProxy();
		$proxy->forceEndpoint="http://vgnsap.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BS_WEB&receiverParty=&receiverService=&interface=SI_BANK_DATA_PROCESS_OUT1&interfaceNamespace=http%3A%2F%2Fsap_employee_zone.com";
		/* call queryRcx */
		//dd($paramRQ);
		$result = $proxy->SI_BANK_DATA_PROCESS_OUT1($paramRQ);
		
		return $result;
    }

    public function Sendkotakpaymentrequest($Company_Code,$Document_No,$Posting_Date,$Beneficiary_Name,$Beneficiary_Account,$Bank_Name,$IFSC_Code,$Payment_Amount,$Trans_Type,$Ref_No,$Fiscal_Year,$company_acct_no,$statuscode,$statusreason,$message_id,$message_source,$client_code,$newposting_date)
    {
    	$newposting_date = str_replace('-','',$newposting_date);

    	require_once('nusoap.php');
        $paramRQ = array();
		$paramRQ = array('Company_Code'=>$Company_Code,'Document_No'=>$Document_No,'Posting_Date'=>$Posting_Date,
							'Beneficiary_Name'=>$Beneficiary_Name,
							'Beneficiary_Account'=>$Beneficiary_Account,
							'Bank_Name'=>$Bank_Name,
							'IFSC_Code'=>$IFSC_Code,
							'Payment_Amount'=>$Payment_Amount,
							'Trans_Type'=>$Trans_Type,
							'Ref_No'=>$Ref_No,
							'Fiscal_Year'=>$Fiscal_Year,
							'Company_Bank_Acc' => $company_acct_no,
							'Status_Code' => $statuscode,
         					'Status_Reason' =>$statusreason,
         					'UTR_No' => '',
         					'Reversal_Code' => '',
         					'Reversal_Reason' => '',
         					'Date' => $newposting_date,
         					'Time' => '',
         					'Msg_ID' => $message_id,
         					'Msg_Source' => $message_source,
         					'Client_code' => $client_code

							);

		//dd($paramRQ);
		/* create client for my rpc web service */
		$wsdl = "http://vgnsap.vgn.in:50000/dir/wsdl?p=ic/eccaa5d6b1d5347a8255f6b6f88f4ffa";
		$client = new \nusoap_client($wsdl,true);
		// Error check
		
		$client->setCredentials($this->sapusername, $this->sappassword, 'basic');
		$client->setUseCURL(true);
		
		$client->useHTTPPersistentConnection();
		
		$proxy = $client->getProxy();
		$proxy->forceEndpoint="http://vgnsap.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BS_WEB&receiverParty=&receiverService=&interface=SI_BANK_DATA_PROCESS_OUT2&interfaceNamespace=http%3A%2F%2Fsap_employee_zone.com";
		/* call queryRcx */
		//dd($paramRQ);
		$result = $proxy->SI_BANK_DATA_PROCESS_OUT2($paramRQ);
		
		return $result;
    } 

    public function InitiatereversalrequestFromSAP()
    {
    	require_once('nusoap.php');
        
		$paramRQ = array('Command'=>'X');
		
		/* create client for my rpc web service */
		$wsdl = "http://vgnsap.vgn.in:50000/dir/wsdl?p=ic/2f40d93c556130968cc70a8db7c038dd";
		$client = new \nusoap_client($wsdl,true);
		// Error check
		
		$client->setCredentials($this->sapusername, $this->sappassword, 'basic');
		$client->setUseCURL(true);
		
		$client->useHTTPPersistentConnection();
		
		$proxy = $client->getProxy();
		$proxy->forceEndpoint="http://vgnsap.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BS_WEB&receiverParty=&receiverService=&interface=SI_BANK_DATA_PROCESS_OUT3&interfaceNamespace=http%3A%2F%2Fsap_employee_zone.com";
		/* call queryRcx */
		$result = $proxy->SI_BANK_DATA_PROCESS_OUT3($paramRQ);
		
		return $result;
    }

    public function sendfinalreverslaconfirmationtosap($rmsgid,$rmsgsource,$rclientcode, $rstatuscode, $rstatusreason,$rutrno){

    	require_once('nusoap.php');
        $paramRQ = array();
		$paramRQ = array('Company_Code'=>'','Document_No'=>'','Posting_Date'=>'',
							'Beneficiary_Name'=>'',
							'Beneficiary_Account'=>'',
							'Bank_Name'=>'',
							'IFSC_Code'=>'',
							'Payment_Amount'=>'',
							'Trans_Type'=>'',
							'Ref_No'=>'',
							'Fiscal_Year'=>'',
							'Company_Bank_Acc' => '',
							'Status_Code' => '',
         					'Status_Reason' =>'',
         					'UTR_No' => $rutrno,
         					'Reversal_Code' => $rstatuscode,
         					'Reversal_Reason' => $rstatusreason,
         					'Date' => '',
         					'Time' => '',
         					'Msg_ID' => $rmsgid,
         					'Msg_Source' => $rmsgsource,
         					'Client_code' => $rclientcode

							);

		//dd($paramRQ);
		/* create client for my rpc web service */
		$wsdl = "http://vgnsap.vgn.in:50000/dir/wsdl?p=ic/eccaa5d6b1d5347a8255f6b6f88f4ffa";
		$client = new \nusoap_client($wsdl,true);
		// Error check
		
		$client->setCredentials($this->sapusername, $this->sappassword, 'basic');
		$client->setUseCURL(true);
		
		$client->useHTTPPersistentConnection();
		
		$proxy = $client->getProxy();
		$proxy->forceEndpoint="http://vgnsap.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BS_WEB&receiverParty=&receiverService=&interface=SI_BANK_DATA_PROCESS_OUT2&interfaceNamespace=http%3A%2F%2Fsap_employee_zone.com";
		/* call queryRcx */
		//dd($paramRQ);
		$result = $proxy->SI_BANK_DATA_PROCESS_OUT2($paramRQ);
		
		return $result;
    }

}