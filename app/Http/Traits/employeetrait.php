<?php
namespace vgn\Http\Traits;

use Carbon\Carbon;


trait employeetrait{

    //private $sapusername = 'vgnpip';
    //private $sappassword = 'Vgn@321';
    
    public function getemployee($employeeid){
    	ini_set('max_execution_time', 60000);
		$wsdl = config('employee_constants.getemployee_wsdl');
		$endpoint = config('employee_constants.getemployee_endpoint');

        require_once('nusoap.php');
        
        $paramRQ=array("Employee_Number"=>$employeeid);
		
		$client = new \nusoap_client($wsdl,true);
		// Error check
		
		$client->setCredentials(config('employee_constants.sapusername'), config('employee_constants.sappassword'), 'basic');
		$client->setUseCURL(true);
		
		$client->useHTTPPersistentConnection();
		$proxy = $client->getProxy();
		if (empty($proxy)) {
			echo 'Service is down. Please try after 10 minutes.';
			die();
			exit();
		}
		$proxy->forceEndpoint=$endpoint;
		$result = $proxy->SI_EMPLOYEE_MY_DETAILS_OUT($paramRQ);
		
		// setcookie("TestCookie", serialize($result), time() + 30, '/');
		return $result;
        
    }
    
     public function checkLogin($empid, $pwd){
		$wsdl = config('employee_constants.checkLogin_wsdl');
		$endpoint = config('employee_constants.checkLogin_endpoint');

        require_once('nusoap.php');
        
        $paramRQ = array('EMPLOYEE_ID'=>$empid,'PASSWORD'=>$pwd);
		
		$client = new \nusoap_client($wsdl,true);
		// Error check
		
		$client->setCredentials(config('employee_constants.sapusername'), config('employee_constants.sappassword'), 'basic');
		$client->setUseCURL(true);
		
		$client->useHTTPPersistentConnection();
		$proxy = $client->getProxy();
		if (empty($proxy)) {
			echo 'Service is down. Please try after 10 minutes.';
			die();
			exit();
		}
		$proxy->forceEndpoint=$endpoint;
		$result = $proxy->SI_EMPLOYEE_LOGIN_OUT($paramRQ);
		
		// setcookie("TestCookie", serialize($result), time() + 30, '/');
		return $result;
        
    }
    
     public function dashboard($empid){
		$wsdl = config('employee_constants.dashboard_wsdl');
		$endpoint = config('employee_constants.dashboard_endpoint');

        require_once('nusoap.php');
        
        $paramRQ=array("Employee_No"=>$empid);
		
		$client = new \nusoap_client($wsdl,true);
		// Error check
		
		$client->setCredentials(config('employee_constants.sapusername'), config('employee_constants.sappassword'), 'basic');
		$client->setUseCURL(true);
		
		$client->useHTTPPersistentConnection();
		$proxy = $client->getProxy();
		if (empty($proxy)) {
			echo 'Service is down. Please try after 10 minutes.';
			die();
			exit();
		}
		$proxy->forceEndpoint=$endpoint;
		$result = $proxy->SI_EMPLOYEE_MY_DASHBOARD_OUT($paramRQ);
		
		// setcookie("TestCookie", serialize($result), time() + 30, '/');
		return $result;
        
    }
    
     public function updateemployeedetails($empid, $houseno,$addr2,$pincode,$city,$country,$pmobile,$pemail){
		$wsdl = config('employee_constants.updateemployeedetails_wsdl');
		$endpoint = config('employee_constants.updateemployeedetails_endpoint');

        require_once('nusoap.php');
        
        $paramRQ = array('Employee_No'=>$empid,'Street_House_No'=>$houseno,'Street_House_No1'=>$addr2,'Postal_Code'=>$pincode,'City'=>$city,'Country'=>$country,'Personal_Mobile'=>$pmobile,'Personal_Email'=>$pemail);
		
		$client = new \nusoap_client($wsdl,true);
		// Error check
		
		$client->setCredentials(config('employee_constants.sapusername'), config('employee_constants.sappassword'), 'basic');
		$client->setUseCURL(true);
		
		$client->useHTTPPersistentConnection();
		$proxy = $client->getProxy();
		if (empty($proxy)) {
			echo 'Service is down. Please try after 10 minutes.';
			die();
			exit();
		}
		$proxy->forceEndpoint=$endpoint;
		$result = $proxy->SI_EMPLOYEE_MY_DETAILS_EDIT_OUT($paramRQ);
		
		// setcookie("TestCookie", serialize($result), time() + 30, '/');
		return $result;
        
    }
    
    public function changesappassword($empid, $old,$new){
		$wsdl = config('employee_constants.changesappassword_wsdl');
		$endpoint = config('employee_constants.changesappassword_endpoint');

        require_once('nusoap.php');
        
        $paramRQ = array('Employee_No'=>$empid,'Old_Password'=>$old,'New_Password'=>$new);
		
		$client = new \nusoap_client($wsdl,true);
		// Error check
		
		$client->setCredentials(config('employee_constants.sapusername'), config('employee_constants.sappassword'), 'basic');
		$client->setUseCURL(true);
		
		$client->useHTTPPersistentConnection();
		$proxy = $client->getProxy();
		if (empty($proxy)) {
			echo 'Service is down. Please try after 10 minutes.';
			die();
			exit();
		}
		$proxy->forceEndpoint=$endpoint;
		$result = $proxy->SI_EMPLOYEE_PWD_CHANGE_OUT($paramRQ);
		
		// setcookie("TestCookie", serialize($result), time() + 30, '/');
		return $result;
        
    }
    
    public function forgotsappassword($empid, $new,$confirmnew){
		$wsdl = config('employee_constants.forgotsappassword_wsdl');
		$endpoint = config('employee_constants.forgotsappassword_endpoint');

        require_once('nusoap.php');
        
        $paramRQ = array('EMPLOYEE_ID'=>$empid,'NEW_PASSWORD'=>$new,'CONFIRM_NEW_PASSWORD'=>$confirmnew);
		
		$client = new \nusoap_client($wsdl,true);
		// Error check
		
		$client->setCredentials(config('employee_constants.sapusername'), config('employee_constants.sappassword'), 'basic');
		$client->setUseCURL(true);
		
		$client->useHTTPPersistentConnection();
		$proxy = $client->getProxy();
		if (empty($proxy)) {
			echo 'Service is down. Please try after 10 minutes.';
			die();
			exit();
		}
		$proxy->forceEndpoint=$endpoint;
		$result = $proxy->SI_EMPLOYEE_LOGIN_FORGET_OUT($paramRQ);
		
		// setcookie("TestCookie", serialize($result), time() + 30, '/');
		return $result;
        
    }
    
    public function getnoticeboard($plantno){
		$wsdl = config('employee_constants.getnoticeboard_wsdl');
		$endpoint = config('employee_constants.getnoticeboard_endpoint');

        require_once('nusoap.php');
        
        $paramRQ=array("Plant"=>$plantno);
        
		
		$client = new \nusoap_client($wsdl,true);
		// Error check
		
		$client->setCredentials(config('employee_constants.sapusername'), config('employee_constants.sappassword'), 'basic');
		$client->setUseCURL(true);
		
		$client->useHTTPPersistentConnection();
		$proxy = $client->getProxy();
		if (empty($proxy)) {
			echo 'Service is down. Please try after 10 minutes.';
			die();
			exit();
		}
		$proxy->forceEndpoint=$endpoint;
		$result = $proxy->SI_EMPLOYEE_NOTICE_BOARD_OUT($paramRQ);
		
		// setcookie("TestCookie", serialize($result), time() + 30, '/');
		return $result;
        
    }
    
    
    
    public function attendance($employeeid, $month, $year)
    {
		$wsdl = config('employee_constants.attendance_wsdl');
		$endpoint = config('employee_constants.attendance_endpoint');

        require_once('nusoap.php');
        $paramRQ = array('Employee_No'=>$employeeid,'Month'=>$month,'Year'=>$year);
        	
		/* create client for my rpc web service */
		
		$client = new \nusoap_client($wsdl,true);
		// Error check
		
		$client->setCredentials(config('employee_constants.sapusername'), config('employee_constants.sappassword'), 'basic');
		$client->setUseCURL(true);
		
		$client->useHTTPPersistentConnection();
		
		$proxy = $client->getProxy();
		$proxy->forceEndpoint=$endpoint;
		/* call queryRcx */
		$result = $proxy->SI_EMPLOYEE_ATTEND_OUT($paramRQ);
		return $result;
    }
    
    public function holiday($employeeid, $year)
    {
		$wsdl = config('employee_constants.holiday_wsdl');
		$endpoint = config('employee_constants.holiday_endpoint');

        require_once('nusoap.php');
        $paramRQ = array('Employee_No'=>$employeeid,'Year'=>$year);
        	
		/* create client for my rpc web service */
		
		$client = new \nusoap_client($wsdl,true);
		// Error check
		
		$client->setCredentials(config('employee_constants.sapusername'), config('employee_constants.sappassword'), 'basic');
		$client->setUseCURL(true);
		
		$client->useHTTPPersistentConnection();
		
		$proxy = $client->getProxy();
		$proxy->forceEndpoint=$endpoint;
		/* call queryRcx */
		$result = $proxy->SI_EMPLOYEE_MEMO_CAL_OUT($paramRQ);
		foreach ($result['CALENDAR'] as $key => $value) {

			if ($value['Date'] == '20200811') {
				unset($result['CALENDAR'][$key]);
			}
		}
		return $result;
    }
    
    public function empreferafriend()
    {
		$wsdl = config('employee_constants.empreferafriend_wsdl');
		$endpoint = config('employee_constants.empreferafriend_endpoint');

        require_once('nusoap.php');
        $paramRQ=array("Careers_Commend"=>1);
        	
		/* create client for my rpc web service */
		
		$client = new \nusoap_client($wsdl,true);
		// Error check
		
		$client->setCredentials(config('employee_constants.sapusername'), config('employee_constants.sappassword'), 'basic');
		$client->setUseCURL(true);
		
		$client->useHTTPPersistentConnection();
		
		$proxy = $client->getProxy();
		$proxy->forceEndpoint=$endpoint;
		/* call queryRcx */
		$result = $proxy->ST_VGN_CAREERS_OUT($paramRQ);
		return $result;
    }
    
     public function applyjob($attr)
    {
		$wsdl = config('employee_constants.applyjob_wsdl');
		$endpoint = config('employee_constants.applyjob_endpoint');

        require_once('nusoap.php');
        $paramRQ = array('Employee_No'=>$attr['referral'],'Job_Code'=>$attr['job_code'],'First_Name'=>$attr['f_name'],'Last_Name'=>$attr['l_name'],'Date_of_Birth'=>str_replace('-','',$attr['dob']),'Title'=>$attr['tit'],'Gender'=>$attr['gen'],'Marital_Status'=>$attr['mar'],'Nationality'=>$attr['nat'],'Correspondence_Language'=>$attr['lang'],'House_No_and_Street'=>$attr['hos'],'Address_Line_2'=>$attr['adrs'],'City'=>$attr['city'],'Region'=>$attr['regn'],'District'=>$attr['dist'],'Postal_Code'=>$attr['pst_cod'],'Country'=>$attr['cntry'],'Telephone_Number'=>$attr['tel'],'Mail_Address'=>$attr['mail'],'EDUCATION_ESTABLISHMENT'=>$attr['grad'],'Edu_From_date'=>str_replace('-','',$attr['edu_frm_date']),'Edu_To_date'=>str_replace('-','',$attr['edu_to_date']),'Institute'=>$attr['inst'],'Country_Edu'=>$attr['cntry_edu'],'Certification'=>$attr['cert'],'Mark'=>$attr['mark'],'EMPLOYER'=>$attr['emp_name'],'Emp_From_date'=>str_replace('-','',$attr['expr_from_date']),'Emp_To_date'=>str_replace('-','',$attr['expr_to_date']),'City_Emp'=>$attr['emp_city'],'Country_Emp'=>$attr['emp_cntry'],'Industry'=>$attr['indst'],'Employment_Contract'=>$attr['emp_contract'],'Designation'=>$attr['desg'],'Department'=>$attr['dept'],'Current_Designation'=>$attr['cur_desg'],'Current_CTC'=>$attr['cur_ctc'],'Reason_for_Leaving'=>$attr['reason'],'Total_Years_of_Experience'=>$attr['total_exp']);
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
		$result = $proxy->ST_CAREERS_JOBAPPLY_OUT($paramRQ);
		return $result;
    }
    
    public function reportStructure($employeeid)
    {
		$wsdl = config('employee_constants.reportStructure_wsdl');
		$endpoint = config('employee_constants.reportStructure_endpoint');

        require_once('nusoap.php');
        $paramRQ = array('Employee_No'=>$employeeid);
        	
		/* create client for my rpc web service */
		
		$client = new \nusoap_client($wsdl,true);
		// Error check
		
		$client->setCredentials(config('employee_constants.sapusername'), config('employee_constants.sappassword'), 'basic');
		$client->setUseCURL(true);
		
		$client->useHTTPPersistentConnection();
		
		$proxy = $client->getProxy();
		$proxy->forceEndpoint=$endpoint;
		/* call queryRcx */
		$result = $proxy->SI_EMPLOYEE_REPORTING_STRUCT_OUT($paramRQ);
		return $result;
    }
    
    public function getmemos($employeeid, $year=0)
    {
		$wsdl = config('employee_constants.getmemos_wsdl');
		$endpoint = config('employee_constants.getmemos_endpoint');

        require_once('nusoap.php');
        $paramRQ = array('Employee_No'=>(empty($year)?$employeeid:""),'Year'=>(!empty($year)?$year:""));
        	
		/* create client for my rpc web service */
		
		$client = new \nusoap_client($wsdl,true);
		// Error check
		
		$client->setCredentials(config('employee_constants.sapusername'), config('employee_constants.sappassword'), 'basic');
		$client->setUseCURL(true);
		
		$client->useHTTPPersistentConnection();
		
		$proxy = $client->getProxy();
		$proxy->forceEndpoint=$endpoint;
		/* call queryRcx */
		$result = $proxy->SI_EMPLOYEE_MEMO_CAL_OUT($paramRQ);
		return $result;
    }
    
    public function gethrpolicy($plantid)
    {
		$wsdl = config('employee_constants.gethrpolicy_wsdl');
		$endpoint = config('employee_constants.gethrpolicy_endpoint');

        require_once('nusoap.php');
        $paramRQ=array("Plant"=>$plantid);
        	
		/* create client for my rpc web service */
		
		$client = new \nusoap_client($wsdl,true);
		// Error check
		
		$client->setCredentials(config('employee_constants.sapusername'), config('employee_constants.sappassword'), 'basic');
		$client->setUseCURL(true);
		
		$client->useHTTPPersistentConnection();
		
		$proxy = $client->getProxy();
		$proxy->forceEndpoint=$endpoint;
		/* call queryRcx */
		$result = $proxy->SI_EMPLOYEE_HR_POLICY_OUT($paramRQ);
		return $result;
    }
    
    public function eligibilty_update($employeeid,$elib_array)
    {
		$wsdl = config('employee_constants.eligibilty_update_wsdl');
		$endpoint = config('employee_constants.eligibilty_update_endpoint');

        require_once('nusoap.php');
        $paramRQ=array("EMP_ID"=>$employeeid,"MOBILE"=>$elib_array['mobile'],"MAIL"=>$elib_array['mail'],"LAPTOP"=>$elib_array['laptop'],"DESKTOP"=>$elib_array['desktop'],"BUSINESS_CARD"=>$elib_array['bcard'],"ID_CARD"=>$elib_array['idcard'],"SAP_ID"=>$elib_array['sapid'],"INTERCOM"=>$elib_array['intercom'],"TRAINING_KIT"=>$elib_array['kit'],"DIARY"=>$elib_array['diary'],"CUG"=>$elib_array['cug'],"ADDA"=>$elib_array['adda'],"Name_Board" => $elib_array['nameboard'],"EPA" => $elib_array['epa'],"FPA" => $elib_array['fpa'],"DSL" => $elib_array['dsl']);
        	
		/* create client for my rpc web service */
		
		$client = new \nusoap_client($wsdl,true);
		// Error check
		
		$client->setCredentials(config('employee_constants.sapusername'), config('employee_constants.sappassword'), 'basic');
		$client->setUseCURL(true);
		
		$client->useHTTPPersistentConnection();
		
		$proxy = $client->getProxy();
		$proxy->forceEndpoint=$endpoint;
		/* call queryRcx */
		$result = $proxy->SI_EMPLOYEE_MY_ELIGIBILITY_OUT($paramRQ);
		return $result;
    }
    
    public function getstock($employeeid)
    {
		$wsdl = config('employee_constants.getstock_wsdl');
		$endpoint = config('employee_constants.getstock_endpoint');

        require_once('nusoap.php');
       $paramRQ=array("Employee_No"=>$employeeid);
        	
		/* create client for my rpc web service */
		
		$client = new \nusoap_client($wsdl,true);
		// Error check
		
		$client->setCredentials(config('employee_constants.sapusername'), config('employee_constants.sappassword'), 'basic');
		$client->setUseCURL(true);
		
		$client->useHTTPPersistentConnection();
		
		$proxy = $client->getProxy();
		$proxy->forceEndpoint=$endpoint;
		/* call queryRcx */
		$result = $proxy->SI_EMPLOYEE_STOCK_LOAN_DETAILS_OUT($paramRQ);
		return $result;
    }
    
    public function getpayslip($employeeid, $month, $year)
    {
		$wsdl = config('employee_constants.getpayslip_wsdl');
		$endpoint = config('employee_constants.getpayslip_endpoint');

        require_once('nusoap.php');
       $paramRQ = array('Employee_No'=>$employeeid,'Month'=>$month,'Year'=>$year);
        	
		/* create client for my rpc web service */
		
		$client = new \nusoap_client($wsdl,true);
		// Error check
		
		$client->setCredentials(config('employee_constants.sapusername'), config('employee_constants.sappassword'), 'basic');
		$client->setUseCURL(true);
		
		$client->useHTTPPersistentConnection();
		
		$proxy = $client->getProxy();
		$proxy->forceEndpoint=$endpoint;
		/* call queryRcx */
		$result = $proxy->SI_EMPLOYEE_PAYSLIP_OUT($paramRQ);
		return $result;
    }
    
    public function ShowRequest($employeeid)
    {
		$wsdl = config('employee_constants.ShowRequest_wsdl');
		$endpoint = config('employee_constants.ShowRequest_endpoint');

        require_once('nusoap.php');
       $paramRQ = array('EMP_NO'=>$employeeid);
        	
		/* create client for my rpc web service */
		
		$client = new \nusoap_client($wsdl,true);
		// Error check
		
		$client->setCredentials(config('employee_constants.sapusername'), config('employee_constants.sappassword'), 'basic');
		$client->setUseCURL(true);
		
		$client->useHTTPPersistentConnection();
		
		$proxy = $client->getProxy();
		$proxy->forceEndpoint=$endpoint;
		/* call queryRcx */
		$result = $proxy->SI_EMPLOYEE_MY_REQUEST_ALL_OUT($paramRQ);
		return $result;
    }
    
    public function CloseRequest($employeeid, $closereq)
    {
		$wsdl = config('employee_constants.CloseRequest_wsdl');
		$endpoint = config('employee_constants.CloseRequest_endpoint');

        require_once('nusoap.php');
       $paramRQ = array('EMP_NO'=>$employeeid,'REQUEST_NO'=>$closereq);
        	
		/* create client for my rpc web service */
		
		$client = new \nusoap_client($wsdl,true);
		// Error check
		
		$client->setCredentials(config('employee_constants.sapusername'), config('employee_constants.sappassword'), 'basic');
		$client->setUseCURL(true);
		
		$client->useHTTPPersistentConnection();
		
		$proxy = $client->getProxy();
		$proxy->forceEndpoint=$endpoint;
		/* call queryRcx */
		$result = $proxy->SI_EMPLOYEE_MY_REQUEST_CLOSE_OUT($paramRQ);
		return $result;
    }
    
    public function raiseequest($employeeid, $attr)
    {
		$wsdl = config('employee_constants.raiserequest_wsdl');
		$endpoint = config('employee_constants.raiserequest_endpoint');

        require_once('nusoap.php');
       
        
        $description=array();
		$desc=str_split($attr['desccomp'],130);
    $description['Line1']=$employeeid.'-';
		for($i=1;$i<=100;$i++)
		{
			$description['Line'.($i+1)]=isset($desc[$i-1])?$desc[$i-1]:"";
		}
    
    
    
   
		$paramRQ = array('Employee_No'=>$employeeid,'Subject'=>$attr['subject'],'Description'=>$description);
        	
		/* create client for my rpc web service */
		
		$client = new \nusoap_client($wsdl,true);
		// Error check
		
		$client->setCredentials(config('employee_constants.sapusername'), config('employee_constants.sappassword'), 'basic');
		$client->setUseCURL(true);
		
		$client->useHTTPPersistentConnection();
		
		$proxy = $client->getProxy();
		$proxy->forceEndpoint=$endpoint;
		/* call queryRcx */
		$result = $proxy->SI_EMPLOYEE_MY_REQUEST_OUT($paramRQ);
		return $result;
    }
    
    public function mynewtraining($employeeid,$department,$plantid)
    {
		$wsdl = config('employee_constants.mynewtraining_wsdl');
		$endpoint = config('employee_constants.mynewtraining_endpoint');

        require_once('nusoap.php');
       
        
    $paramRQ=array("DEPT"=>$department,"EMP_NO"=>$employeeid,"PLANT"=>$plantid);
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
		$result = $proxy->SI_EMPLOYEE_TRAINING_SCH_OUT($paramRQ);
		return $result;
    }
    
    public function searchlead($searchquery)
    {
		$wsdl = config('employee_constants.searchlead_wsdl');
		$endpoint = config('employee_constants.searchlead_endpoint');

        require_once('nusoap.php');
       
        
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
    
      public function customerleadmove($postedleadno,$panno,$passportno)
    {
		$wsdl = config('employee_constants.customerleadmove_wsdl');
		$endpoint = config('employee_constants.customerleadmove_endpoint');

        require_once('nusoap.php');
       
        
    $paramRQ = array('LEAD_NO'=>$postedleadno,'PAN_NO'=>$panno,'LEAD_NO'=>$postedleadno,'PASSPORT'=>$passportno);
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
		$result = $proxy->SI_CUSTOMER_DETAILS_SALES_OUT($paramRQ);
		return $result;
    }
    
      public function customerleadcreate($regarray)
    {
		$wsdl = config('employee_constants.customerleadcreate_wsdl');
		$endpoint = config('employee_constants.customerleadcreate_endpoint');

        require_once('nusoap.php');
       
        
        $paramRQ = $regarray;
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
		$result = $proxy->SI_CUSTOMER_CREATION_SALES_OUT($paramRQ);
		return $result;
    }

	public function landownerscreate($regarray)
    {
		$wsdl = config('employee_constants.customerleadcreate_wsdl');
		$endpoint = config('employee_constants.customerleadcreate_endpoint');

        require_once('nusoap.php');
       
        
        $paramRQ = $regarray;
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
		$result = $proxy->SI_CUSTOMER_CREATION_SALES_OUT($paramRQ);
		return $result;
    }
    
      public function getsaleorderunits($projectcode)
    {
		$wsdl = config('employee_constants.getsaleorderunits_wsdl');
		$endpoint = config('employee_constants.getsaleorderunits_endpoint');

        require_once('nusoap.php');
       
        
        $paramRQ = array('Command'=>$projectcode);
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
		$result = $proxy->SI_CUSTOMER_PROJECT_SEARCH_HELP_OUT($paramRQ);
		return $result;
    }
    
    public function getsaleorderpaymentterms($projectcode)
    {
		$wsdl = config('employee_constants.getsaleorderpaymentterms_wsdl');
		$endpoint = config('employee_constants.getsaleorderpaymentterms_endpoint');

        require_once('nusoap.php');
       
        
        $paramRQ = array('Command'=>$projectcode);
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
		$result = $proxy->SI_CUSTOMER_PAYMENTTERMS_SEARCH_HELP_OUT($paramRQ);
		return $result;
    }
    
    public function viewquotetrait($projectno,$unitno,$paymentterms,$customerno,$leadno)
    {
		$wsdl = config('employee_constants.viewquotetrait_wsdl');
		$endpoint = config('employee_constants.viewquotetrait_endpoint');

        require_once('nusoap.php');
       
        
        $paramRQ = array('Command'=>$projectno,'Unit'=>$unitno,'PMT'=>$paymentterms,'Customer'=>$customerno,'Lead_No'=>$leadno);
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
		$result = $proxy->SI_CUSTOMER_VIEWQUOTES_OUT($paramRQ);
		return $result;
    }
    
    public function convertsaleorder($projectno,$unitno,$customer,$leadno,$paymentterms )
    {
		$wsdl = config('employee_constants.convertsaleorder_wsdl');
		$endpoint = config('employee_constants.convertsaleorder_endpoint');

        require_once('nusoap.php');
       
        
        $paramRQ = array('Project'=>$projectno, 'Unit'=>$unitno, 'Customer'=>$customer, 'Lead_No'=>$leadno, 'Payment_Terms'=>$paymentterms );
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
		$result = $proxy->SI_CUSTOMER_SALES_ORDERCREATION_OUT($paramRQ);
		return $result;
    }
    

    public function getleadsfollowup($type,$empname )
    {
		$wsdl = config('employee_constants.getleadsfollowup_wsdl');
		$endpoint = config('employee_constants.getleadsfollowup_endpoint');

        require_once('nusoap.php');
       
        
        $paramRQ = array('Command'=>strtoupper($type), 'Sales_Exe'=>$empname );
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
		$result = $proxy->SI_LEADS_FOLLOWUP_OUT($paramRQ);
		return $result;
    }

    public function leadsfollowupinsert($arr)
    {
		$wsdl = config('employee_constants.leadsfollowupinsert_wsdl');
		$endpoint = config('employee_constants.leadsfollowupinsert_endpoint');

        require_once('nusoap.php');
       
        $paramRQ = $arr;

		/* create client for my rpc web service */
		
		$client = new \nusoap_client($wsdl,true);
		// Error check
		
		$client->setCredentials(config('employee_constants.sapusername'), config('employee_constants.sappassword'), 'basic');
		$client->setUseCURL(true);
		
		$client->useHTTPPersistentConnection();
		
		$proxy = $client->getProxy();
		$proxy->forceEndpoint=$endpoint;
		/* call queryRcx */
		$result = $proxy->SI_LEADS_FOLLOWUP_OVERALL_DETAILS_OUT($paramRQ);
		return $result;
    }

    public function update_expected_dateofbooking($newarr)
    {
		$wsdl = config('employee_constants.expected_booking_date_wsdl');
		$endpoint = config('employee_constants.expected_booking_date_endpoint');

        require_once('nusoap.php');
       
        $paramRQ = $newarr;

		/* create client for my rpc web service */
		
		$client = new \nusoap_client($wsdl,true);
		// Error check
		
		$client->setCredentials(config('employee_constants.sapusername'), config('employee_constants.sappassword'), 'basic');
		$client->setUseCURL(true);
		
		$client->useHTTPPersistentConnection();
		
		$proxy = $client->getProxy();
		$proxy->forceEndpoint=$endpoint;
		/* call queryRcx */
		$result = $proxy->SI_LEADS_EXPECTED_DATE_BOOK_OUT($paramRQ);
		return $result;
	}
	
	public function requestforcoldapproval_data($empid)
	{
		$wsdl = config('employee_constants.requestforcoldapproval_data_wsdl');
		$endpoint = config('employee_constants.requestforcoldapproval_data_endpoint');

        require_once('nusoap.php');
       
        $paramRQ = array('Emp_ID'=>$empid);

		/* create client for my rpc web service */
		
		$client = new \nusoap_client($wsdl,true);
		// Error check
		
		$client->setCredentials(config('employee_constants.sapusername'), config('employee_constants.sappassword'), 'basic');
		$client->setUseCURL(true);
		
		$client->useHTTPPersistentConnection();
		
		$proxy = $client->getProxy();
		$proxy->forceEndpoint=$endpoint;
		/* call queryRcx */
		$result = $proxy->SI_LEADS_ZSD_MANAGER_OUT($paramRQ);
		return $result;
	}

	public function forupdatemngr_coldapproval($leadno, $forapproval, $date, $time)
    {
		$wsdl = config('employee_constants.forupdatemngr_coldapproval_wsdl');
		$endpoint = config('employee_constants.forupdatemngr_coldapproval_endpoint');

        require_once('nusoap.php');
       
        $paramRQ = ['Status' => ['Lead_No'=>$leadno, 'Cold_Status' => $forapproval, 'Approved_Date' => $date, 'Approved_Time' => $time ] ];

		/* create client for my rpc web service */
		
		$client = new \nusoap_client($wsdl,true);
		// Error check
		
		$client->setCredentials(config('employee_constants.sapusername'), config('employee_constants.sappassword'), 'basic');
		$client->setUseCURL(true);
		
		$client->useHTTPPersistentConnection();
		
		$proxy = $client->getProxy();
		$proxy->forceEndpoint=$endpoint;
		/* call queryRcx */
		$result = $proxy->SI_LEADS_MANAGER_APPROVAL_STATUS_OUT($paramRQ);
		return $result;
	}

     public function getcoldreason()
    {
		$wsdl = config('employee_constants.getcoldreason_wsdl');
		$endpoint = config('employee_constants.getcoldreason_endpoint');

        require_once('nusoap.php');
       
        $paramRQ = array('Command'=>'COLD');

		/* create client for my rpc web service */
		
		$client = new \nusoap_client($wsdl,true);
		// Error check
		
		$client->setCredentials(config('employee_constants.sapusername'), config('employee_constants.sappassword'), 'basic');
		$client->setUseCURL(true);
		
		$client->useHTTPPersistentConnection();
		
		$proxy = $client->getProxy();
		$proxy->forceEndpoint=$endpoint;
		/* call queryRcx */
		$result = $proxy->SI_LEADS_FOLLOWUP_COLD_HELP_OUT($paramRQ);
		return $result;
    }
    
    
    public function sendsmsleads($newtypename,$leadno,$sch_date,$sch_time,$sch_addr,$sch_project,$sch_unit,$sch_cdate,$sch_ctime,$ownind )
    {
		$wsdl = config('employee_constants.sendsmsleads_wsdl');
		$endpoint = config('employee_constants.sendsmsleads_endpoint');

        require_once('nusoap.php');
       
        
        $paramRQ = array('Command'=>$newtypename, 'Lead_No'=>$leadno,'Sch_Date'=>$sch_date,'Sch_Time'=>$sch_time,'Sch_Address' => $sch_addr,'Own_Indicator' => $ownind,'Project'=>$sch_project,'Unit'=>$sch_unit,'Call_Back_Date' =>$sch_cdate,'Call_Back_Time'=>$sch_ctime );
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
		$result = $proxy->SI_LEADS_FOLLOWUP_SMS_OUT($paramRQ);
		return $result;
    }

     public function getediary($type,$salesexec)
    {
		$wsdl = config('employee_constants.getediary_wsdl');
		$endpoint = config('employee_constants.getediary_endpoint');

        require_once('nusoap.php');
       
        
        $paramRQ = array('Command'=>$type, 'Sales_Exe'=>$salesexec);
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
		$result = $proxy->SI_LEADS_FOLLOWUP_SALES_EDAIRY_OUT($paramRQ);
		return $result;
    }

     public function getleadsfollowupdata($leadno,$salesexec)
    {
		$wsdl = config('employee_constants.getleadsfollowupdata_wsdl');
		$endpoint = config('employee_constants.getleadsfollowupdata_endpoint');

        require_once('nusoap.php');
       
        
        $paramRQ = array('Lead_No'=>$leadno, 'Emp_Name'=>$salesexec);
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
		$result = $proxy->SI_LEADS_FOLLOWUP_STATUS_OUT($paramRQ);
		return $result;
    }

    public function getleadscript($type, $plant)
    {
		$wsdl = config('employee_constants.getleadscript_wsdl');
		$endpoint = config('employee_constants.getleadscript_endpoint');

        require_once('nusoap.php');
       
        
        $paramRQ = array('Plant'=>$plant, 'Commands'=>$type);
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
		$result = $proxy->SI_LEADS_FOLLOWUP_SCRIPT_OUT($paramRQ);
		return $result;
    }

     public function getleadtypeview($type, $typeview,$empname)
    {
		$wsdl = config('employee_constants.getleadtypeview_wsdl');
		$endpoint = config('employee_constants.getleadtypeview_endpoint');

        require_once('nusoap.php');
       
        
        $paramRQ = array('Command'=>$type,'Sales_Exe'=>$empname, 'Type'=>$typeview);
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
		$result = $proxy->SI_LEADS_FOLLOWUP_SITE_VISIT_OUT($paramRQ);
		return $result;
    }
   

    public function savecomplaint($employeeid, $plantcode, $cnature, $desccomp)
    {
		$wsdl = config('employee_constants.savecomplaint_wsdl');
		$endpoint = config('employee_constants.savecomplaint_endpoint');

        require_once('nusoap.php');
        $description=array();
        $desc=str_split($desccomp,130);
		for($i=0;$i<10;$i++)
		{
			$description['Line'.($i+1)]=isset($desc[$i])?$desc[$i]:"";
		}
		$paramRQ = array('Employee_No'=>$employeeid,'Project_No'=>$plantcode,'Description'=>$description,'Nature_of_Complaint'=>$cnature);
        	
		/* create client for my rpc web service */
		
		$client = new \nusoap_client($wsdl,true);
		// Error check
		
		$client->setCredentials(config('employee_constants.sapusername'), config('employee_constants.sappassword'), 'basic');
		$client->setUseCURL(true);
		
		$client->useHTTPPersistentConnection();
		
		$proxy = $client->getProxy();
		$proxy->forceEndpoint=$endpoint;
		/* call queryRcx */
		$result = $proxy->SI_EMPLOYEE_COMP_RAISE_OUT($paramRQ);
		$result['desc']=$desccomp;
		return $result;
    }

    public function closecomplaint($employeeid, $complaintno){
		$wsdl = config('employee_constants.closecomplaint_wsdl');
		$endpoint = config('employee_constants.closecomplaint_endpoint');

        require_once('nusoap.php');
        $paramRQ = array('Employee_No'=>$employeeid,'Complaint_No'=>$complaintno);
		
		/* create client for my rpc web service */
		
		$client = new \nusoap_client($wsdl,true);
		// Error check
		
		$client->setCredentials(config('employee_constants.sapusername'), config('employee_constants.sappassword'), 'basic');
		$client->setUseCURL(true);
		
		$client->useHTTPPersistentConnection();
		
		$proxy = $client->getProxy();
		$proxy->forceEndpoint=$endpoint;
		/* call queryRcx */
		$result = $proxy->SI_EMPLOYEE_COMP_CLOSE_OUT($paramRQ);
		$result['code']=200;
		return $result;
    }
    
    
    
    public function getUnsold($vendorid)
{
	$wsdl = config('employee_constants.getUnsold_wsdl');
	$endpoint = config('employee_constants.getUnsold_endpoint');

	require_once('nusoap.php');
$paramRQ = array('Customer_ID'=>$vendorid);

// create client for my rpc web service

$client = new \nusoap_client($wsdl,true);
// Error check

$client->setCredentials(config('employee_constants.sapusername'), config('employee_constants.sappassword'), 'basic');
$client->setUseCURL(true);

$client->useHTTPPersistentConnection();

$proxy = $client->getProxy();
$proxy->forceEndpoint=$endpoint;
//call queryRcx
$result = $proxy->SI_Unsold_Out($paramRQ);
$result['code']=200;
return $result;

}

public function getpunches($empid, $startdate, $enddate)
{
	$wsdl = config('employee_constants.empgetpunches_wsdl');
	$endpoint = config('employee_constants.empgetpunches_endpoint');

	require_once('nusoap.php');
	$paramRQ = ["Emp_ID"=>$empid, "Start_Date"=>$startdate, "End_Date"=>$enddate];
		
	/* create client for my rpc web service */
	
	$client = new \nusoap_client($wsdl,true);
	// Error check
	
	$client->setCredentials(config('employee_constants.sapusername'), config('employee_constants.sappassword'), 'basic');
	$client->setUseCURL(true);
	
	$client->useHTTPPersistentConnection();
	
	$proxy = $client->getProxy();
	$proxy->forceEndpoint=$endpoint;
	/* call queryRcx */
	$result = $proxy->SI_LMS_SORTED_PUNCHES_OUT($paramRQ);
	return $result;
}


public function shiftdetails()
{
	$wsdl = config('employee_constants.shiftdetails_wsdl');
	$endpoint = config('employee_constants.shiftdetails_endpoint');

	require_once('nusoap.php');
	$paramRQ = ["Command"=>'X'];
		
	/* create client for my rpc web service */
	
	$client = new \nusoap_client($wsdl,true);
	// Error check
	
	$client->setCredentials(config('employee_constants.sapusername'), config('employee_constants.sappassword'), 'basic');
	$client->setUseCURL(true);
	
	$client->useHTTPPersistentConnection();
	
	$proxy = $client->getProxy();
	//dd($proxy);
	$proxy->forceEndpoint=$endpoint;
	/* call queryRcx */
	$result = $proxy->SI_LMS_EXISTING_SHIFT_DETAILS_OUT($paramRQ);
	return $result;
}

public function shiftchangerequest($subordinateid, $start_date, $end_date, $shiftcode)
{
	$wsdl = config('employee_constants.shiftdetailschangesreq_wsdl');
	$endpoint = config('employee_constants.shiftdetailschangesreq_endpoint');

	require_once('nusoap.php');
	$paramRQ = ["EMP_ID"=>$subordinateid, "Start_Date"  =>$start_date, "End_Date" => $end_date,"Shift_Code" => $shiftcode ];
		
	/* create client for my rpc web service */
	
	$client = new \nusoap_client($wsdl,true);
	// Error check
	
	$client->setCredentials(config('employee_constants.sapusername'), config('employee_constants.sappassword'), 'basic');
	$client->setUseCURL(true);
	
	$client->useHTTPPersistentConnection();
	
	$proxy = $client->getProxy();
	$proxy->forceEndpoint=$endpoint;
	/* call queryRcx */
	$result = $proxy->SI_LMS_SHIFT_CHANGES_OUT($paramRQ);
	
	return $result;
}

public function getshiftdetailsst_et_date($empid, $start_date, $end_date)
{
	$wsdl = config('employee_constants.getshift_details_wsdl');
	$endpoint = config('employee_constants.getshift_details_endpoint');

	require_once('nusoap.php');
	$paramRQ = ["Emp_ID"=>$empid, "Start_Date"  =>$start_date, "End_Date" => $end_date ];
		
	/* create client for my rpc web service */
	
	$client = new \nusoap_client($wsdl,true);
	// Error check
	
	$client->setCredentials(config('employee_constants.sapusername'), config('employee_constants.sappassword'), 'basic');
	$client->setUseCURL(true);
	
	$client->useHTTPPersistentConnection();
	
	$proxy = $client->getProxy();
	$proxy->forceEndpoint=$endpoint;
	
	/* call queryRcx */
	$result = $proxy->SI_LMS_EMP_SHIFT_DETAILS_OUT($paramRQ);
	
	return $result;
}


public function getallactiveemployees()
{
	$wsdl = config('employee_constants.activeemployees_wsdl');
	$endpoint = config('employee_constants.activeemployees_endpoint');

	require_once('nusoap.php');
	$paramRQ = ["Command"=> 'X'];
		
	/* create client for my rpc web service */
	
	$client = new \nusoap_client($wsdl,true);
	// Error check
	
	$client->setCredentials(config('employee_constants.sapusername'), config('employee_constants.sappassword'), 'basic');
	$client->setUseCURL(true);
	
	$client->useHTTPPersistentConnection();
	
	$proxy = $client->getProxy();
	$proxy->forceEndpoint=$endpoint;
	/* call queryRcx */
	$result = $proxy->SI_LMS_ACTIVE_EMP_LIST_OUT($paramRQ);
	
	return $result;
}

public function updateleave_balance($arr)
{
	$wsdl = config('employee_constants.update_apprv_rej_wsdl');
	$endpoint = config('employee_constants.update_apprv_rej_endpoint');

	require_once('nusoap.php');
	$paramRQ['Leave_Details'] = [
		"Employee_ID"=> $arr['employeeid'],
		"Month"=> $arr['month'],
		"Year"=> $arr['year'],
		"CL"=> $arr['CL'],
		"SL"=> $arr['SL'],
		"PL"=> $arr['PL'],
		"ML"=> $arr['ML'],
		"RH"=> $arr['RH'],
		"Permission"=> $arr['Permission'],
		"OnDuty"=> $arr['Onduty'],
		"Tour"=> $arr['Tour'],
		"Comp_Off"=> $arr['Compoff'],
		"Miss_Punch"=> $arr['Mispunch'],
		"Present"=> $arr['Present'],
		"LOP"=> $arr['LOP'],
		"Absent"=> $arr['Absent'],
		"Late_Count"=> $arr['late_count'],
		"Total_Late_Hours"=> $arr['total_late_hours'],
		"Early_Out_Count"=> $arr['early_out_count'],
		"Total_Early_Out_Hours"=> $arr['total_early_out_hours'],
		"Completed"=> $arr['completed']
	 ];
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
	$result = $proxy->SI_LMS_UPDATE_LEAVE_BALANCE_OUT($paramRQ);
	
	return $result;
}

public function insert_applicationtosapfinal($arr)
{
	$wsdl = config('employee_constants.update_leave_wsdl');
	$endpoint = config('employee_constants.update_leave_endpoint');

	require_once('nusoap.php');
	$paramRQ = [
		"Employee_ID"=> $arr->employeeid,
		"From_Date"=> $arr->from_date,
		"To_Date"=> $arr->to_date,
		"Leave_Type"=> $arr->leave_type,
		"Start_Time"=> $arr->starttime,
		"End_Time"=> $arr->endtime
	 ];
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
	$result = $proxy->SI_LMS_DEDUCT_LEAVE_BALANCE_OUT($paramRQ);
	
	return $result;
}

public function deduct_leave_forlate($arr)
{
	$wsdl = config('employee_constants.update_leave_wsdl');
	$endpoint = config('employee_constants.update_leave_endpoint');

	require_once('nusoap.php');
	$paramRQ = [
		"Employee_ID"=> $arr['employeeid'],
		"From_Date"=> $arr['from_date'],
		"To_Date"=> $arr['to_date'],
		"Leave_Type"=> $arr['leave_type'],
		"Start_Time"=> $arr['starttime'],
		"End_Time"=> $arr['endtime']
	 ];
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
	$result = $proxy->SI_LMS_DEDUCT_LEAVE_BALANCE_OUT($paramRQ);
	
	return $result;
}

public function bulkinsertleave_balance($arr)
{
	$wsdl = config('employee_constants.update_apprv_rej_wsdl');
	$endpoint = config('employee_constants.update_apprv_rej_endpoint');

	require_once('nusoap.php');
	$paramRQ = $arr;
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
	$result = $proxy->SI_LMS_UPDATE_LEAVE_BALANCE_OUT($paramRQ);
	
	return $result;
}

public function delete_leave_applied($arr)
{
	$wsdl = config('employee_constants.delete_leave_applied_wsdl');
	$endpoint = config('employee_constants.delete_leave_applied_endpoint');

	require_once('nusoap.php');
	$paramRQ = [
		"Employee_ID"=> $arr['employeeid'],
		"From_Date"=> $arr['from_date'],
		"To_Date"=> $arr['to_date'],
		"Leave_Type"=> $arr['leave_type'],
		"Start_Time"=> $arr['starttime'],
		"End_Time"=> $arr['endtime']
	 ];
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
	$result = $proxy->SI_LMS_CANCEL_APPLIED_LEAVE_IN($paramRQ);
	
	return $result;
}


public function getactivecampaigns()
    {
		$wsdl = config('employee_constants.getactivecampaigns_wsdl');
		$endpoint = config('employee_constants.getactivecampaigns_endpoint');

        require_once('nusoap.php');
       
        
        $paramRQ = ['Command'=>'X'];
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
		$result = $proxy->SI_VGN_LEADS_CAMPAIGN_OUT($paramRQ);

		return $result;
    }



    public function postbulkfileuploadleads($data)
    {
		$wsdl = config('employee_constants.postbulkleads_wsdl');
		$endpoint = config('employee_constants.postbulkleads_endpoint');

        require_once('nusoap.php');
       
        
        $paramRQ = $data;
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
		$result = $proxy->SI_VGN_LEAD_EXHIBITION_OUT($paramRQ);
		
		return $result;
    }

    public function step1hsbcprocess()
    {
		$wsdl = config('employee_constants.poststep1hsbcprocess_wsdl');
		$endpoint = config('employee_constants.poststep1hsbcprocess_endpoint');

        require_once('nusoap.php');
       
        
        $paramRQ = array('Command'=>'X');
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
		$result = $proxy->SI_HSBC_ACCOUNT_CREATE_OUT($paramRQ);
		
		return $result;
    }

public function todayfollowleadreport($empid)
    {
		$wsdl = config('employee_constants.today_followup_wsdl');
		$endpoint = config('employee_constants.today_followup_endpoint');

        require_once('nusoap.php');
       
        
        $paramRQ = array('Employee_ID'=> $empid);
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
		$result = $proxy->SI_LEADS_TODAY_FOLLOWUP_LIST_OUT($paramRQ);
		
		return $result;
    }
		
public function emp_bulkplant_list($empid)
    {
		$wsdl = config('employee_constants.emp_bulklead_plantout_wsdl');
		$endpoint = config('employee_constants.emp_bulklead_plantout_endpoint');

        require_once('nusoap.php');
       
        
        $paramRQ = array('Emp_ID'=> $empid);
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
		$result = $proxy->SI_VGN_EMPLOYEE_PLANTLIST_OUT($paramRQ);
		
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

public function checkemployee($arr){
    	ini_set('max_execution_time', 60000);
		$wsdl = config('employee_constants.checkemployeelogin_wsdl');
		$endpoint = config('employee_constants.checkemployeelogin_endpoint');

        require_once('nusoap.php');
        
        $paramRQ=$arr;
		
		$client = new \nusoap_client($wsdl,true);
		// Error check
		
		$client->setCredentials(config('employee_constants.sapusername'), config('employee_constants.sappassword'), 'basic');
		$client->setUseCURL(true);
		
		$client->useHTTPPersistentConnection();
		$proxy = $client->getProxy();
		if (empty($proxy)) {
			echo 'Service is down. Please try after 10 minutes.';
			die();
			exit();
		}
		$proxy->forceEndpoint=$endpoint;
		
		$result = $proxy->SI_EMPLOYEE_LOGIN_VALIDATION_OUT($paramRQ);
		
		// setcookie("TestCookie", serialize($result), time() + 30, '/');
		return $result;
        
    }

    public function employeebasicinfo($empid)
	{
		ini_set('max_execution_time', 60000);
		$wsdl = config('employee_constants.employeebasicinfo_wsdl');
		$endpoint = config('employee_constants.employeebasicinfo_endpoint');
        
		
		require_once('nusoap.php');
		$paramRQ = array('Employee_Number'=> $empid);
		$client = new \nusoap_client($wsdl,true);
		// Error check
		
		$client->setCredentials(config('employee_constants.sapusername'), config('employee_constants.sappassword'), 'basic');
		$client->setUseCURL(true);
		
		$client->useHTTPPersistentConnection();
		$proxy = $client->getProxy();
		if (empty($proxy)) {
			echo 'Service is down. Please try after 10 minutes.';
			die();
			exit();
		}
		$proxy->forceEndpoint=$endpoint;
		
		$result = $proxy->SI_EMPLOYEE_BASIC_DETAILS_OUT($paramRQ);
		
		// setcookie("TestCookie", serialize($result), time() + 30, '/');
		return $result;
	}

public function hr_application_crosscheck($app_id)
	{
		ini_set('max_execution_time', 60000);
		$wsdl = config('employee_constants.hrapplication_crosscheck_wsdl');
		$endpoint = config('employee_constants.hrapplication_crosscheck_endpoint');
        
		
		require_once('nusoap.php');
		$paramRQ = array('Applicant_Number'=> $app_id);
		$client = new \nusoap_client($wsdl,true);
		// Error check
		
		$client->setCredentials(config('employee_constants.sapusername'), config('employee_constants.sappassword'), 'basic');
		$client->setUseCURL(true);
		
		$client->useHTTPPersistentConnection();
		$proxy = $client->getProxy();
		if (empty($proxy)) {
			echo 'Service is down. Please try after 10 minutes.';
			die();
			exit();
		}
		$proxy->forceEndpoint=$endpoint;
		
		$result = $proxy->ST_APPLICANT_STATUS_OUT($paramRQ);
		
		// setcookie("TestCookie", serialize($result), time() + 30, '/');
		return $result;
	}

	public function updatebankinfo($employeeid,$bank_account_no,$branch_name,$ifsc_code,$bank_name){
		$wsdl = config('employee_constants.updatebankinfo_wsdl');
		$endpoint = config('employee_constants.updatebankinfo_endpoint');

        require_once('nusoap.php');
        $paramRQ = array('Vendor_ID'=>'E'.$employeeid,'Acc_No'=>$bank_account_no,'Branch_Name'=>$branch_name,'IFSC_Code'=>$ifsc_code,'Bank_Name'=>$bank_name);
		
		/* create client for my rpc web service */
		
		$client = new \nusoap_client($wsdl,true);
		// Error check
		
		$client->setCredentials(config('employee_constants.sapusername'), config('employee_constants.sappassword'), 'basic');
		$client->setUseCURL(true);
		
		$client->useHTTPPersistentConnection();
		
		$proxy = $client->getProxy();
		$proxy->forceEndpoint=$endpoint;
		/* call queryRcx */
		$result = $proxy->SI_VEND_BANK_DETAILS_UPDATE_OUT($paramRQ);
		$result['code']=200;
		return $result;
    }

	public function requestipsend_tosap($arr)
	{
		ini_set('max_execution_time', 60000);
		$wsdl = config('employee_constants.requestedip_wsdl');
		$endpoint = config('employee_constants.requestedip_endpoint');
        
		
		require_once('nusoap.php');
		$paramRQ = $arr;
		$client = new \nusoap_client($wsdl,true);
		// Error check
		
		$client->setCredentials(config('employee_constants.sapusername'), config('employee_constants.sappassword'), 'basic');
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

}
