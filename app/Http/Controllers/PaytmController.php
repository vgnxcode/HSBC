<?php

namespace vgn\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Facades\Log;
use vgn\Http\Traits\paytmtrait;

class PaytmController extends Controller
{
	use paytmtrait;

	public function showlistofprojects()
	{
		if ($_REQUEST['token']='ESWIWIENEM213SKDS1122344') {
			$projectlist = $this->showprojectlist();
			return response()->json($projectlist['Details'],200);
			//dd($projectlist);
		}
		else{
			return response()->json(['error' => 'Not authorized.'],403);
		}
	}
    
    public function getunitlist_of_project($plantcode,$unit_desc_searched)
    {
    	
    		$userunitfilter1 = str_replace(' ', '', $unit_desc_searched); // Replaces all spaces with hyphens.
    		$userunitfilter2 =  preg_replace('/[^A-Za-z0-9\-]/', '', $userunitfilter1);
    		$userunitfilter3 =  str_replace('-', '', $userunitfilter2);

    	$projectlist = $this->getunitlist($plantcode);

        if (array_key_exists('0', $projectlist['Details']) === false) {
            $newproject['Details'][0] = $projectlist['Details'];
        }
        else{
            $newproject = $projectlist;
        }


    	foreach ($newproject['Details'] as $key => $value) {
            if ($value['Unit_Description'] == '') {
                return 0;
            }
    		$filter1 = str_replace(' ', '', $value['Unit_Description']); // Replaces all spaces with hyphens.
    		$filter2 =  preg_replace('/[^A-Za-z0-9\-]/', '', $filter1);
    		$filter3 =  str_replace('-', '', $filter2);
    		if (strtolower($filter3) == strtolower($userunitfilter3)) {
    			return $value;
    		}
    	}

    	return 0;
    }


    public function customerdetails()
    {
    	if ($_REQUEST['token']='ESWIWIENEM213SKDS1122344') {

    	if (!empty($_REQUEST['plantcode']) && !empty($_REQUEST['unitdescription'])) {
    		$result = $this->getunitlist_of_project($_REQUEST['plantcode'], $_REQUEST['unitdescription']);

    		if ($result != 0) {
    			$arr = [];
    			$arr['Plant_Code'] = $_REQUEST['plantcode'];
    			$arr['Unit_Description'] = $result['Unit_No'];
    			$customer = $this->customervalidation($arr);
    			
    			$sendcustomerdetails['Customer_id'] = '';
    			$sendcustomerdetails['Customer_name'] = '';
    			$sendcustomerdetails['Project_code'] = '';
    			$sendcustomerdetails['Unit_no'] = '';
    			$sendcustomerdetails['Unit_desc'] = '';

    			if ($customer['Cust_ID'] != '') {
    				$sendcustomerdetails['Customer_id'] = $customer['Cust_ID'];
	    			$sendcustomerdetails['Customer_name'] = $customer['Cust_Name'];
	    			$sendcustomerdetails['Project_code'] = $customer['Plant_Code'];
	    			$sendcustomerdetails['Unit_no'] = $customer['Unit_No'];
	    			$sendcustomerdetails['Unit_desc'] = $customer['Unit_Description'];
    			}
    			return response()->json($sendcustomerdetails,200);
    		}
    		else{
    			return response()->json(['error' => 'No result found'],404);	
    		}
    	}
    	else{
    		return response()->json(['error' => 'Data should not be empty.'],404);
    	}

    	}
		else{
			return response()->json(['error' => 'Not authorized.'],403);
		}
    }

    public function billfetch_details()
    {
    	if ($_REQUEST['token']='ESWIWIENEM213SKDS1122344') {

    	if (!empty($_REQUEST['plantcode']) && !empty($_REQUEST['customerid']) && !empty($_REQUEST['utility_type'])) {
    		$result = $this->billfetchfromsap($_REQUEST['plantcode'], $_REQUEST['customerid']);
    		$utitlity_type = $_REQUEST['utility_type'];
    		
    		if (!empty($result)) {
    			
    			return response()->json($result,200);
    		}
    		else{
    			return response()->json(['error' => 'No result found'],404);	
    		}
    	}
    	else{
    		return response()->json(['error' => 'Data should not be empty.'],404);
    	}

    	}
		else{
			return response()->json(['error' => 'Not authorized.'],403);
		}
    }

    public function customervalidateapi()
    {
        if (isset($_REQUEST['token']) == 'ESWIWIENEM213SKDS1122344') {
            if ($_REQUEST['token'] != 'ESWIWIENEM213SKDS1122344') {
                 return response()->json(['result' => [],'error_message' =>  'Not authorized.','status_code' => 403]);
            }

        if (!empty($_REQUEST['plantcode']) && !empty($_REQUEST['unitdescription']) ) {
            $result = $this->getunitlist_of_project($_REQUEST['plantcode'], $_REQUEST['unitdescription']);
            //$utlity_type = $_REQUEST['utility_type'];
            //return $result;
            //dd($result);
            if ($result != 0) {
                $arr = [];
                $arr['Plant_Code'] = $_REQUEST['plantcode'];
                $arr['Unit_Description'] = $result['Unit_No'];
                $customer = $this->customervalidation($arr);
                //return $customer;

                $sendcustomerdetails['Customer_id'] = '';
                $sendcustomerdetails['Customer_name'] = '';
                $sendcustomerdetails['Project_code'] = '';
                $sendcustomerdetails['Unit_no'] = '';
                $sendcustomerdetails['Unit_desc'] = '';

                if ($customer['Cust_ID'] != '') {
                    $sendcustomerdetails['Customer_id'] = $customer['Cust_ID'];
                    $sendcustomerdetails['Customer_name'] = $customer['Cust_Name'];
                    $sendcustomerdetails['Project_code'] = $customer['Plant_Code'];
                    $sendcustomerdetails['Unit_no'] = $customer['Unit_No'];
                    $sendcustomerdetails['Unit_desc'] = $customer['Unit_Description'];
                    $sapamount = $this->billfetchfromsap($customer['Plant_Code'], $customer['Cust_ID']);
                    $sendcustomerdetails['Amount'] = $sapamount['Amount'];
                }
                else{
                    return response()->json(['result' => [],'error_message' => 'Customer Details Not Found','status_code' => 404]);
                }
                return response()->json(['result' => $sendcustomerdetails,'error_message' => '','status_code' => 200]);
            }
            else{
                return response()->json(['result' => [],'error_message' =>  'No result found','status_code' => 404]);    
            }
        }
        else{
            return response()->json(['result' => [],'error_message' =>  'Data should not be empty.','status_code' => 404]);
        }

        }
        else{
            return response()->json(['result' => [],'error_message' =>  'Not authorized.','status_code' => 403]);
        }
    }

    public function paymentpostingapi()
    {
        if (isset($_REQUEST['token']) == 'ESWIWIENEM213SKDS1122344') {
            if ($_REQUEST['token'] != 'ESWIWIENEM213SKDS1122344') {
                 return response()->json(['result' => [],'error_message' =>  'Not authorized.','status_code' => 403]);
            }

        if (!empty($_REQUEST['customerid']) && !empty($_REQUEST['plant_code']) && !empty($_REQUEST['unit_no']) && !empty($_REQUEST['utility_type']) && !empty($_REQUEST['amount']) && !empty($_REQUEST['transaction_date']) && !empty($_REQUEST['payment_status']) && !empty($_REQUEST['reference_id'])) {
            //$result = $this->getunitlist_of_project($_REQUEST['plantcode'], $_REQUEST['unitdescription']);
            $utitlity_type = $_REQUEST['utility_type'];
            if (strtolower(trim($utitlity_type)) == 'maintenance') {
                $maintenance = 'X';
                $text_note = 'PAYTM Maintenance Charges';
            }else{
                $maintenance = '';
                $text_note = 'PAYTM Flat/Plot Payments';
            }
            //return $result;
            //dd($result);
                $arr = [];
                $arr['Customer_ID'] = $_REQUEST['customerid'];
                $arr['Plant_ID'] = $_REQUEST['plant_code'];
                $arr['Unit_No'] = $_REQUEST['unit_no'];
                $arr['Maintenance'] = $maintenance;
                $arr['Amount'] = $_REQUEST['amount'];
                $arr['Transaction_Date'] = $_REQUEST['transaction_date'];
                $arr['Payment_Status'] = $_REQUEST['payment_status'];
                $arr['Payment_Text'] = $text_note;
                $arr['Reference_ID'] = $_REQUEST['reference_id'];

		Log::info('paytm posted data'.json_encode($arr));

                $paytmpaymentpost = $this->paytmpaymentpost($arr);
		Log::info('paytm posting status '.json_encode($paytmpaymentpost));
                //return $paytmpaymentpost;

                if ($paytmpaymentpost['Status'] == 'Updated Successfully') {
                    return response()->json(['result' => ['Status' => 'Success'],'error_message' => '','status_code' => 200]);
                }
                else{
                    return response()->json(['result' => ['Status' => 'Failed'],'error_message' => '','status_code' => 202]);
                }
                return response()->json(['result' => [],'error_message' => 'Not Updated','status_code' => 404]);
            
            
        }
        else{
            return response()->json(['result' => [],'error_message' =>  'Data should not be empty.','status_code' => 404]);
        }

        }
        else{
            return response()->json(['result' => [],'error_message' =>  'Not authorized.','status_code' => 403]);
        }
    }

    public function statuscheckapi()
    {
        if (isset($_REQUEST['token']) == 'ESWIWIENEM213SKDS1122344') {
            if ($_REQUEST['token'] != 'ESWIWIENEM213SKDS1122344') {
                 return response()->json(['result' => [],'error_message' =>  'Not authorized.','status_code' => 403]);
            }

        if (!empty($_REQUEST['reference_id'])) {
		Log::info('paytm posted data '.json_encode($_REQUEST));
            
                $arr = [];
                $arr['Reference_ID'] = $_REQUEST['reference_id'];

                $paytmpayment_status_check = $this->paytmpayment_status_check($arr);
		Log::info('paytm posting status '.json_encode($paytmpayment_status_check));

                if ($paytmpayment_status_check['Status'] == 'success') {
                    return response()->json(['result' => [
                        'customerid' => $paytmpayment_status_check['Customer_ID'],
                        'payment_date' => $paytmpayment_status_check['Payment_Date'],
                        'amount' => trim($paytmpayment_status_check['Amount']),
                        'Status' => 'Success'],'error_message' => '','status_code' => 200]);
                }
                else{
                    if ($paytmpayment_status_check['Customer_ID'] != '') {
                        return response()->json(['result' => [
                        'customerid' => $paytmpayment_status_check['Customer_ID'],
                        'payment_date' => $paytmpayment_status_check['Payment_Date'],
                        'amount' => trim($paytmpayment_status_check['Amount']),
                        'Status' => 'Failed'],'error_message' => '','status_code' => 202]);
                    }
                    
                }
                return response()->json(['result' => [],'error_message' => 'Data Not Found','status_code' => 404]);
            
            
        }
        else{
            return response()->json(['result' => [],'error_message' =>  'Data should not be empty.','status_code' => 404]);
        }

        }
        else{
            return response()->json(['result' => [],'error_message' =>  'Not authorized.','status_code' => 403]);
        }
    }



}
