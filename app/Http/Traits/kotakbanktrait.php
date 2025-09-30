<?php
namespace vgn\Http\Traits;

use Carbon\Carbon;


trait kotakbanktrait{

    private $sapusername = 'vgnpip';
    //private $sappassword = 'Vgn@321';
	private $sappassword = "piprd@1234";

    public function GetSapDataProcess1_soap()
    {
        require_once('nusoap.php');
        
		$paramRQ = array('Command'=>'X');
		
		/* create client for my rpc web service */
		$wsdl = "http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/79d3666f43893dc6b06e9e79aecbd6bd";
		$client = new \nusoap_client($wsdl,true);
		// Error check
		
		$client->setCredentials($this->sapusername, $this->sappassword, 'basic');
		$client->setUseCURL(true);
		
		$client->useHTTPPersistentConnection();
		
		$proxy = $client->getProxy();
		$proxy->forceEndpoint="http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_BANK_DATA_PROCESS_OUT&interfaceNamespace=http%3A%2F%2Fsap_employee_zone.com";
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
		$wsdl = "http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/a1f67e00c3db35ff803ff0dc50f7fff0";
		$client = new \nusoap_client($wsdl,true);
		// Error check
		
		$client->setCredentials($this->sapusername, $this->sappassword, 'basic');
		$client->setUseCURL(true);
		
		$client->useHTTPPersistentConnection();
		
		$proxy = $client->getProxy();
		$proxy->forceEndpoint="http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_BANK_DATA_PROCESS_OUT1&interfaceNamespace=http%3A%2F%2Fsap_employee_zone.com";
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
		$wsdl = "http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/507149f8c11c31f68d0927170b66698f";
		$client = new \nusoap_client($wsdl,true);
		// Error check
		
		$client->setCredentials($this->sapusername, $this->sappassword, 'basic');
		$client->setUseCURL(true);
		
		$client->useHTTPPersistentConnection();
		
		$proxy = $client->getProxy();
		$proxy->forceEndpoint="http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_BANK_DATA_PROCESS_OUT2&interfaceNamespace=http%3A%2F%2Fsap_employee_zone.com";
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
		$wsdl = "http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/5d8e28c27e6c3e9ca39bb7b78338be68";
		$client = new \nusoap_client($wsdl,true);
		// Error check
		
		$client->setCredentials($this->sapusername, $this->sappassword, 'basic');
		$client->setUseCURL(true);
		
		$client->useHTTPPersistentConnection();
		
		$proxy = $client->getProxy();
		$proxy->forceEndpoint="http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_BANK_DATA_PROCESS_OUT3&interfaceNamespace=http%3A%2F%2Fsap_employee_zone.com";
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
		$wsdl = "http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/507149f8c11c31f68d0927170b66698f";
		$client = new \nusoap_client($wsdl,true);
		// Error check
		
		$client->setCredentials($this->sapusername, $this->sappassword, 'basic');
		$client->setUseCURL(true);
		
		$client->useHTTPPersistentConnection();
		
		$proxy = $client->getProxy();
		$proxy->forceEndpoint="http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_BANK_DATA_PROCESS_OUT2&interfaceNamespace=http%3A%2F%2Fsap_employee_zone.com";
		/* call queryRcx */
		//dd($paramRQ);
		$result = $proxy->SI_BANK_DATA_PROCESS_OUT2($paramRQ);
		
		return $result;
    }

}