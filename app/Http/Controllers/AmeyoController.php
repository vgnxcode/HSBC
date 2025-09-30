<?php

namespace vgn\Http\Controllers;

use Illuminate\Http\Request;
use vgn\Http\Traits\ameyotrait;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use DB;
use vgn\tata_inbond_call;
use vgn\tara_crm_call_log;
use vgn\AdminCrm;
use vgn\calling945_report;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;


class AmeyoController extends Controller
{
        use ameyotrait;

    public function api1()
    {

        if ((isset($_REQUEST['key']) != '') && (isset($_REQUEST['phoneno']) != '')) {
                //return $_REQUEST['key'];
                $client_secret = 'ASKDI12PO';
                $current_date = Carbon::now()->format('Ymd');
                $vgntoken = $client_secret.$current_date;
                $token = $_REQUEST['key'];

                $vgnhashed = Hash::make($vgntoken, ['rounds' => 12]);
                //return $vgnhashed;
                $ameyohashed = $token;

                if (Hash::check($ameyohashed, $vgnhashed)) {




                $mobileno = $_REQUEST['phoneno'];
                $sapdata = [];
                $sapdata['name'] = '';
                        $sapdata['email_id'] = '';
                        $sapdata['sap_lead_id'] = '';
                        $sapdata['project_manager'] = '';
                        $sapdata['sales_field_executive'] = '';
                        $sapdata['project_name'] = '';
                        $sapdata['plant_id'] = '';
                        $sapdata['Source'] = '';

                $response_from_sap = $this->showleaddetails($mobileno);
                // return $response_from_sap;
                if (array_key_exists('Name', $response_from_sap) === false) {   $response_from_sap['Name'] = '' ; }
    if (array_key_exists('SAP_Lead_ID', $response_from_sap) === false) {
        $response_from_sap['Site_Visit_Date'] = '';
        $response_from_sap['SAP_Lead_ID'] = ''  ; }
    if (array_key_exists('Project_Name', $response_from_sap) === false) {       $response_from_sap['Project_Name'] = '' ; }
    if (array_key_exists('Plant_ID', $response_from_sap) === false) {   $response_from_sap['Plant_ID'] = ''     ; }
                //dd($response_from_sap);
                if (!empty($response_from_sap)) {
                        $sapdata['name'] = $response_from_sap['Name'];
                        $sapdata['email_id'] = ($response_from_sap['Email_ID'] == '0') ? '' : $response_from_sap['Email_ID'];
                        $sapdata['sap_lead_id'] = $response_from_sap['SAP_Lead_ID'];
                        $sapdata['project_manager'] = ($response_from_sap['Project_Manager'] == '0') ? '' : $response_from_sap['Project_Manager'];
                        $sapdata['sales_field_executive'] = ($response_from_sap['Sales_Field_Executive'] == '0') ? '' : $response_from_sap['Sales_Field_Executive'];
                        $sapdata['project_name'] = $response_from_sap['Project_Name'];
                        $sapdata['plant_id'] = $response_from_sap['Plant_ID'];
                        $sapdata['Source'] = ($response_from_sap['Source'] == '0') ? '' : $response_from_sap['Source'];
                }
                return response()->json($sapdata);
        }
        else{

                return response()->json(['error' => 'Not authorized.'],403);
        }

        }
        else{
                return response()->json(['error' => 'Not authorized.'],403);
        }
    }

    public function api2()
    {
        if ((isset($_REQUEST['key']) != '') && (isset($_REQUEST['name']) != '')&& (isset($_REQUEST['phoneno']) != '')&& (isset($_REQUEST['project_code']) != '')&& (isset($_REQUEST['source']) != '')) {

                $client_secret = 'ASKDI12PO';
                $current_date = Carbon::now()->format('Ymd');
                $vgntoken = $client_secret.$current_date;
                $token = $_REQUEST['key'];

                $vgnhashed = Hash::make($vgntoken, ['rounds' => 12]);
                //return $vgnhashed;
                $ameyohashed = $token;

                if (Hash::check($ameyohashed, $vgnhashed)) {


                $name = $_REQUEST['name'];
                $phoneno = $_REQUEST['phoneno'];
                        if(!empty($_REQUEST['emailid'])){
                $emailid = $_REQUEST['emailid'];
                        } else {
                                $emailid = '';
                        }
                $project_code = $_REQUEST['project_code'];
                $source = $_REQUEST['source'];
                $uniqid = Carbon::now()->format('YmdHis').rand(10,100);
                $createddate = Carbon::now()->format('Ymd');
                $createdtime = Carbon::now()->format('His');

                $sapdata['Name'] = $name;
                        $sapdata['Phone'] = $phoneno;
                        $sapdata['Email_ID'] = $emailid;
                        $sapdata['Project_Code'] = $project_code;
                        $sapdata['Source'] = $source;
                        $sapdata['Unique_ID'] = $uniqid;
                        $sapdata['Created_Date'] = $createddate;
                        $sapdata['Created_Time'] = $createdtime;

                $response_from_sap = $this->postleaddetails($sapdata);
                // dd($response_from_sap);
                if (array_key_exists('SAP_Lead_ID', $response_from_sap ) === true) {
                        if (!empty($response_from_sap['SAP_Lead_ID'])) {
                                return response()->json(['sap_lead_id' => $response_from_sap['SAP_Lead_ID']]);
                        }
                        else{
                                return response()->json(['error' => 'Unable to Create.'],403);
                        }
                }
                else{
                        return response()->json(['error' => 'Unable to Create'],403);
                }

                return response()->json(['error' => 'Unable to Create'],403);
        }
        else{

                return response()->json(['error' => 'Token Mismatch.'],403);
        }

        }
        else{
                return response()->json(['error' => 'Not authorized.'],403);
        }
    }

    public function api3()
    {

        if ((isset($_REQUEST['key']) != '') && (isset($_REQUEST['phoneno']) != '')) {
                $client_secret = 'ASKDI12PO';
                $current_date = Carbon::now()->format('Ymd');
                $vgntoken = $client_secret.$current_date;
                $token = $_REQUEST['key'];

                $vgnhashed = Hash::make($vgntoken, ['rounds' => 12]);
                //return $vgnhashed;
                $ameyohashed = $token;

                if (Hash::check($ameyohashed, $vgnhashed)) {




                $mobileno = $_REQUEST['phoneno'];
                $sapdata = [];

                $sapdata['name'] = '';
                        $sapdata['email_id'] = '';
                        $sapdata['sap_lead_id'] = '';
                        $sapdata['project_manager'] = '';
                        $sapdata['sales_field_executive'] = '';
                        $sapdata['project_name'] = '';
                        $sapdata['plant_id'] = '';
                        $sapdata['Source'] = '';
                        $sapdata['site_visit_date'] = '';

                $response_from_sap = $this->showleaddetails($mobileno);

                //dd($response_from_sap);
                if (!empty($response_from_sap)) {
                        if ($response_from_sap['Site_Visit_Date'] == '0000-00-00') {
                                $response_from_sap['Site_Visit_Date'] = '';
                        }

    if (array_key_exists('Name', $response_from_sap) === false) {       $response_from_sap['Name'] = '' ; }
    if (array_key_exists('SAP_Lead_ID', $response_from_sap) === false) {
        $response_from_sap['Site_Visit_Date'] = '';
        $response_from_sap['SAP_Lead_ID'] = ''  ; }
    if (array_key_exists('Project_Name', $response_from_sap) === false) {       $response_from_sap['Project_Name'] = '' ; }
    if (array_key_exists('Plant_ID', $response_from_sap) === false) {   $response_from_sap['Plant_ID'] = ''     ; }

                        $sapdata['name'] = $response_from_sap['Name'];
                        $sapdata['email_id'] = ($response_from_sap['Email_ID'] == '0') ? '' : $response_from_sap['Email_ID'];
                        $sapdata['sap_lead_id'] = $response_from_sap['SAP_Lead_ID'];
                        $sapdata['project_manager'] = ($response_from_sap['Project_Manager'] == '0') ? '' : $response_from_sap['Project_Manager'];
                        $sapdata['sales_field_executive'] = ($response_from_sap['Sales_Field_Executive'] == '0') ? '' : $response_from_sap['Sales_Field_Executive'];
                        $sapdata['project_name'] = $response_from_sap['Project_Name'];
                        $sapdata['plant_id'] = $response_from_sap['Plant_ID'];
                        $sapdata['Source'] = ($response_from_sap['Source'] == '0') ? '' : $response_from_sap['Source'];
                        $sapdata['site_visit_date'] = ($response_from_sap['Site_Visit_Date'] == '0') ? '' : $response_from_sap['Site_Visit_Date'];
                }
                return response()->json($sapdata);
        }
        else{

                return response()->json(['error' => 'Not authorized.'],403);
        }

        }
        else{
                return response()->json(['error' => 'Not authorized.'],403);
        }
    }


    public function api4()
    {

        if ((isset($_REQUEST['key']) != '') && (isset($_REQUEST['phoneno']) != '')) {
                $client_secret = 'ASKDI12PO';
                $current_date = Carbon::now()->format('Ymd');
                $vgntoken = $client_secret.$current_date;
                $token = $_REQUEST['key'];

                $vgnhashed = Hash::make($vgntoken, ['rounds' => 12]);
                //return $vgnhashed;
                $ameyohashed = $token;

                if (Hash::check($ameyohashed, $vgnhashed)) {




                $mobileno = $_REQUEST['phoneno'];
                $sapdata = [];
                $sapdata['customer_id'] = '';
                $sapdata['name'] = '';
                        $sapdata['phone1'] = '';
                        $sapdata['phone2'] = '';
                        $sapdata['phone3'] = '';
                        $sapdata['email_id'] = '';
                        $sapdata['project_details'] = [];

                $response_from_sap = $this->get_customerpaymentdetails($mobileno);

                        if(empty($response_from_sap['Phone1']))
                        {
                                $response_from_sap['Phone1']='';
                        }

                if (!empty($response_from_sap)) {
                        $sapdata['customer_id'] = ($response_from_sap['C_ID'] == '0') ? '' : $response_from_sap['C_ID'];
                        $sapdata['name'] = ($response_from_sap['Name'] == '0') ? '' : $response_from_sap['Name'];
                        $sapdata['phone1'] = ($response_from_sap['Phone1'] == '0') ? '' : $response_from_sap['Phone1'];
                        if (array_key_exists("Phone2",$response_from_sap)){
                                 $sapdata['phone2'] = ($response_from_sap['Phone2'] == '0') ? '' : $response_from_sap['Phone2'];
                                }
                                else{
                        $sapdata['phone2'] = '';
                                }
                        if (array_key_exists("Phone3",$response_from_sap)){
                                 $sapdata['phone3'] = ($response_from_sap['Phone3'] == '0') ? '' : $response_from_sap['Phone3'];
                                }
                                else{
                        $sapdata['phone3'] = '';
                                }
                        if (array_key_exists("Email_ID",$response_from_sap)){
                                    $sapdata['email_id'] = ($response_from_sap['Email_ID'] == '0') ? '' : $response_from_sap['Email_ID'];
                                }
                                else{
                                     $sapdata['email_id'] = '';
                                }
                        if (array_key_exists('0',$response_from_sap['Details']) === false) {
                                $count = 1;
                        }
                        else{
                                $count = count($response_from_sap['Details']);
                        }
                        //dd(count($response_from_sap['Details']));
                        if ($count == 1) {
                                //dd($response_from_sap['Details']['Project_Name']);
                                        $sapdata['project_details']['project_name'] = ($response_from_sap['Details']['Project_Name'] == "0") ? '' : $response_from_sap['Details']['Project_Name'];

                                        $sapdata['project_details']['flat_no'] = ($response_from_sap['Details']['Flat_No'] == '0') ? '' : $response_from_sap['Details']['Flat_No'];

                                        $sapdata['project_details']['date_of_booking'] = ($response_from_sap['Details']['Date_Of_Booking'] == '0') ? '' : $response_from_sap['Details']['Date_Of_Booking'];
                                        $sapdata['project_details']['total_flat_value'] = ($response_from_sap['Details']['Total_Flat_Value'] == '0') ? '' : $response_from_sap['Details']['Total_Flat_Value'];
                                        $sapdata['project_details']['milestone_value'] = ($response_from_sap['Details']['Milestone_Value'] == '0') ? '' : $response_from_sap['Details']['Milestone_Value'];
                                        $sapdata['project_details']['current_due'] = ($response_from_sap['Details']['Current_Due'] == '0') ? '' : $response_from_sap['Details']['Current_Due'];
                                        $sapdata['project_details']['total_paid'] = ($response_from_sap['Details']['Total_Paid_Amount'] == '0') ? '' : $response_from_sap['Details']['Total_Paid_Amount'];

                                        $sapdata['project_details']['ptp_date'] = (($response_from_sap['Details']['PTP_Date'] == '00000000') || ($response_from_sap['Details']['PTP_Date'] == '0')) ? '' : substr($response_from_sap['Details']['PTP_Date'],0,4).'-'.substr($response_from_sap['Details']['PTP_Date'],4,2).'-'.substr($response_from_sap['Details']['PTP_Date'],6,2);

                                        $sapdata['project_details']['Fund_status'] = ($response_from_sap['Details']['Fund_Status'] == '0') ? '' : $response_from_sap['Details']['Fund_Status'];
                        }

                        if ($count > 1) {
                                $ii = 0;
                                foreach ($response_from_sap['Details'] as $key1 => $value1) {
                                        $sapdata['project_details'][$ii]['project_name'] = ($value1['Project_Name'] == '0') ? '' : $value1['Project_Name'];

                                        $sapdata['project_details'][$ii]['flat_no'] = ($value1['Flat_No'] == '0') ? '' : $value1['Flat_No'];

                                        $sapdata['project_details'][$ii]['date_of_booking'] = ($value1['Date_Of_Booking'] == '0') ? '' : $value1['Date_Of_Booking'];
                                        $sapdata['project_details'][$ii]['total_flat_value'] = ($value1['Total_Flat_Value'] == '0') ? '' : $value1['Total_Flat_Value'];
                                        $sapdata['project_details'][$ii]['milestone_value'] = ($value1['Milestone_Value'] == '0') ? '' : $value1['Milestone_Value'];
                                        $sapdata['project_details'][$ii]['current_due'] = ($value1['Current_Due'] == '0') ? '' : $value1['Current_Due'];
                                        $sapdata['project_details'][$ii]['total_paid'] = ($value1['Total_Paid_Amount'] == '0') ? '' : $value1['Total_Paid_Amount'];

                                        $sapdata['project_details'][$ii]['ptp_date'] = (($value1['PTP_Date'] == '00000000') || ($value1['PTP_Date'] == '0')) ? '' : substr($value1['PTP_Date'],0,4).'-'.substr($value1['PTP_Date'],4,2).'-'.substr($value1['PTP_Date'],6,2);

                                        $sapdata['project_details'][$ii]['Fund_status'] = ($value1['Fund_Status'] == '0') ? '' : $value1['Fund_Status'];
                                        $ii++;
                                }
                        }

                }
                return response()->json($sapdata);
        }
        else{

                return response()->json(['error' => 'Not authorized.'],403);
        }

        }
        else{
                return response()->json(['error' => 'Not authorized.'],403);
        }
    }

    public function api5()
    {

        if ((isset($_REQUEST['key']) != '') && (isset($_REQUEST['phoneno']) != '')) {
                $client_secret = 'ASKDI12PO';
                $current_date = Carbon::now()->format('Ymd');
                $vgntoken = $client_secret.$current_date;
                $token = $_REQUEST['key'];

                $vgnhashed = Hash::make($vgntoken, ['rounds' => 12]);
                //return $vgnhashed;
                $ameyohashed = $token;

                if (Hash::check($ameyohashed, $vgnhashed)) {




                $mobileno = $_REQUEST['phoneno'];
                $sapdata = [];

                $sapdata['agentid'] = '';
                        $sapdata['agent_name'] = '';

                $response_from_sap = $this->find_exec_details($mobileno);

                //dd($response_from_sap);
                if (!empty($response_from_sap)) {

                        $sapdata['agentid'] = ($response_from_sap['CC_ID'] == '0') ? '' : $response_from_sap['CC_ID'];
                        $sapdata['agent_name'] = ($response_from_sap['CC_Name'] == '0') ? '' : $response_from_sap['CC_Name'];

                }
                return response()->json($sapdata);
        }
        else{

                return response()->json(['error' => 'Not authorized.'],403);
        }

        }
        else{
                return response()->json(['error' => 'Not authorized.'],403);
        }
    }

    public function api6()
    {
        if ((isset($_REQUEST['key']) != '') && (isset($_REQUEST['emailid']) != '')) {
                $client_secret = 'ASKDI12PO';
                $current_date = Carbon::now()->format('Ymd');
                $vgntoken = $client_secret.$current_date;
                $token = $_REQUEST['key'];

                $vgnhashed = Hash::make($vgntoken, ['rounds' => 12]);
                //return $vgnhashed;
                $ameyohashed = $token;

                if (Hash::check($ameyohashed, $vgnhashed)) {




                $emailid = $_REQUEST['emailid'];
                $sapdata = [];
                        $sap_data['agentid'] = '';
                        $sapdata['agent_email'] = '';

                $response_from_sap = $this->get_crm_email($emailid);

                //dd($response_from_sap);
                if (!empty($response_from_sap)) {
                        $sapdata['agentid'] = ($response_from_sap['CC_ID'] == '0') ? '' : $response_from_sap['CC_ID'];
                        $sapdata['agent_email'] = ($response_from_sap['CC_Email'] == '0') ? '' : strtolower($response_from_sap['CC_Email']);
                }
                return response()->json($sapdata);
        }
        else{

                return response()->json(['error' => 'Not authorized.'],403);
        }

        }
        else{
                return response()->json(['error' => 'Not authorized.'],403);
        }
    }

public function api7()
    {
        Log::info('Ameyo requested Data '.json_encode($_REQUEST));
        if ((isset($_REQUEST['key']) != '') && (isset($_REQUEST['name']) != '')&& (isset($_REQUEST['phoneno']) != '')&& (isset($_REQUEST['project_code']) != '')&& (isset($_REQUEST['campaigncode']) != '')&& (isset($_REQUEST['budgetrange_code']) != '')) {

            $client_secret = 'ASKDI12PO';
            $current_date = Carbon::now()->format('Ymd');
            $vgntoken = $client_secret.$current_date;
            $token = $_REQUEST['key'];

            $vgnhashed = Hash::make($vgntoken, ['rounds' => 12]);
            //return $vgnhashed;
            $ameyohashed = $token;

            if (Hash::check($ameyohashed, $vgnhashed)) {




            $name = $_REQUEST['name'];
            $phoneno = $_REQUEST['phoneno'];
            $emailid = $_REQUEST['emailid'];
            $project_code = $_REQUEST['project_code'];
            $campaigncode = $_REQUEST['campaigncode'];
            $budgetrange_code = $_REQUEST['budgetrange_code'];
            $uniqid = Carbon::now()->format('YmdHis').rand(10,100);
            $createddate = Carbon::now()->format('Ymd');
            $createdtime = Carbon::now()->format('His');

            $sapdata['Name'] = $name;
            $sapdata['Phone'] = $phoneno;
            $sapdata['Email_ID'] = $emailid;
            $sapdata['Project_Code'] = $project_code;
            $sapdata['Campaign_Code'] = 'CH/IN/'.$project_code.'/'.$campaigncode;
            $sapdata['Budget_Range'] = $budgetrange_code;
            $sapdata['Unique_ID'] = $uniqid;
            $sapdata['Created_Date'] = $createddate;
            $sapdata['Created_Time'] = $createdtime;

            $response_from_sap = $this->postleaddetails_new($sapdata);
                Log::info('Ameyo vgn response Data '.json_encode($response_from_sap));
            //dd($response_from_sap);
            if (array_key_exists('SAP_Lead_ID', $response_from_sap ) === true) {
                if (!empty($response_from_sap['SAP_Lead_ID'])) {
                    return response()->json(['sap_lead_id' => $response_from_sap['SAP_Lead_ID']]);
                }
                else{
                    return response()->json(['error' => 'Unable to Create.'],403);
                }
            }
            else{
                return response()->json(['error' => 'Unable to Create'],403);
            }

            return response()->json(['error' => 'Unable to Create'],403);
        }
        else{

            return response()->json(['error' => 'Token Mismatch.'],403);
        }

        }
        else{
            return response()->json(['error' => 'Not authorized.'],403);
        }
    }

  public function api8()
    {
        if ((isset($_REQUEST['key']) != '') && (isset($_REQUEST['leadno']) != '')) {
        //return $_REQUEST['key'];
            $client_secret = 'ASKDI12PO';
            $current_date = Carbon::now()->format('Ymd');
            $vgntoken = $client_secret.$current_date;
            $token = $_REQUEST['key'];

            $vgnhashed = Hash::make($vgntoken, ['rounds' => 12]);
            //return $vgnhashed;
            $ameyohashed = $token;

            if (Hash::check($ameyohashed, $vgnhashed)) {

            $leadno = $_REQUEST['leadno'];
            $sapdata = [];
            $sapdata['name'] = '';
            $sapdata['email_id'] = '';
            $sapdata['sap_lead_id'] = '';
            $sapdata['project_manager'] = '';
            $sapdata['sales_field_executive'] = '';
            $sapdata['project_name'] = '';
            $sapdata['plant_id'] = '';
            $sapdata['Source'] = '';
                $sapdata['Site_Visit_Date'] = '';
            $sapdata['Mobile_No'] = '';

            $response_from_sap = $this->showdetailsby_leadno($leadno);
        //return $response_from_sap;
            if (array_key_exists('Name', $response_from_sap) === false) {   $response_from_sap['Name'] = '' ; }
    if (array_key_exists('SAP_Lead_ID', $response_from_sap) === false) {
        $response_from_sap['Site_Visit_Date'] = '';
        $response_from_sap['SAP_Lead_ID'] = ''  ; }
    if (array_key_exists('Project_Name', $response_from_sap) === false) {   $response_from_sap['Project_Name'] = '' ; }
    if (array_key_exists('Plant_ID', $response_from_sap) === false) {   $response_from_sap['Plant_ID'] = '' ; }

if (array_key_exists('Site_Visit_Date', $response_from_sap) === false) {   $response_from_sap['Site_Visit_Date'] = '' ; }
    if (array_key_exists('Mobile_No', $response_from_sap) === false) {   $response_from_sap['Mobile_No'] = '' ; }

            //dd($response_from_sap);
            if (!empty($response_from_sap)) {
                $sapdata['name'] = $response_from_sap['Name'];
            $sapdata['email_id'] = ($response_from_sap['Email_ID'] == '0') ? '' : $response_from_sap['Email_ID'];
            $sapdata['sap_lead_id'] = $response_from_sap['SAP_Lead_ID'];
            $sapdata['project_manager'] = ($response_from_sap['Project_Manager'] == '0') ? '' : $response_from_sap['Project_Manager'];
            $sapdata['sales_field_executive'] = ($response_from_sap['Sales_Field_Executive'] == '0') ? '' : $response_from_sap['Sales_Field_Executive'];
            $sapdata['project_name'] = $response_from_sap['Project_Name'];
            $sapdata['plant_id'] = $response_from_sap['Plant_ID'];
            $sapdata['Source'] = ($response_from_sap['Source'] == '0') ? '' : $response_from_sap['Source'];
            $sapdata['Site_Visit_Date'] = ($response_from_sap['Site_Visit_Date'] == '0000-00-00') ? '' : $response_from_sap['Site_Visit_Date'];
            $sapdata['Mobile_No'] = ($response_from_sap['Mobile_No'] == '0') ? '' : trim($response_from_sap['Mobile_No']);
                //dd($sapdata);
            }
            return response()->json($sapdata);
        }
        else{

            return response()->json(['error' => 'Not authorized.'],403);
        }

        }
        else{
            return response()->json(['error' => 'Not authorized.'],403);
        }
    }

public function api9()
    {

        if ((isset($_REQUEST['key']) != '') && (isset($_REQUEST['customerid']) != '')) {
            $client_secret = 'ASKDI12PO';
            $current_date = Carbon::now()->format('Ymd');
            $vgntoken = $client_secret.$current_date;
            $token = $_REQUEST['key'];

            $vgnhashed = Hash::make($vgntoken, ['rounds' => 12]);
            //return $vgnhashed;
            $ameyohashed = $token;

            if (Hash::check($ameyohashed, $vgnhashed)) {


            $customerid = $_REQUEST['customerid'];
            $sapdata = [];
                $sapdata['customer_id'] = '';
            $sapdata['name'] = '';
            $sapdata['phone1'] = '';
            $sapdata['phone2'] = '';
            $sapdata['phone3'] = '';
            $sapdata['email_id'] = '';
            $sapdata['project_details'] = [];

                        if (preg_match("~^7\d+$~", $_REQUEST["customerid"])) {
                                // Yes
                                //return response()->json("YES");
                                //return $this->api8($_REQUEST);
                                $response_from_sap = $this->showdetailsby_leadno($customerid);
                                //dd($response_from_sap);
                                $customs_from_own['customer_id'] = $response_from_sap['SAP_Lead_ID'];
                                $customs_from_own['name'] = $response_from_sap['Name'];
                                $customs_from_own['phone1'] = ($response_from_sap['Mobile_No'] == 0)?"": $response_from_sap['Mobile_No'];
                                $customs_from_own['phone2'] = '';
                                $customs_from_own['phone3'] = '';
                                $customs_from_own['email_id'] = ($response_from_sap['Email_ID'] == 0)?"": $response_from_sap['Email_ID'];
                                $customs_from_own['project_details'] = [
                                        'project_name' => $response_from_sap['Project_Name'],
                                        'flat_no' => '',
                                        'date_of_booking' => '',
                                        'total_flat_value' => '',
                                        'milestone_value' => '',
                                        'current_due' => '',
                                        'total_paid' => '',
                                        'ptp_date' => '',
                                        'Fund_status' => '',
                                ];
                                //dd($customs_from_own);
                                return response()->json($customs_from_own);
                        } else {
                                // no
                                $response_from_sap = $this->get_customerpaymentdetailsby_leadno($customerid);
                                //return response()->json("NO");
                        }
            //$response_from_sap = $this->get_customerpaymentdetailsby_leadno($customerid);



            //dd($response_from_sap);
            if (!empty($response_from_sap)) {
            $sapdata['customer_id'] = ($response_from_sap['C_ID'] == '0') ? '' : $response_from_sap['C_ID'];
                $sapdata['name'] = ($response_from_sap['Name'] == '0') ? '' : $response_from_sap['Name'];
                $sapdata['phone1'] = ($response_from_sap['Phone1'] == '0') ? '' : $response_from_sap['Phone1'];
            if (array_key_exists("Phone2",$response_from_sap)){
                                 $sapdata['phone2'] = ($response_from_sap['Phone2'] == '0') ? '' : $response_from_sap['Phone2'];
                                }
                                else{
                        $sapdata['phone2'] = '';
                                }
            if (array_key_exists("Phone3",$response_from_sap)){
                                 $sapdata['phone3'] = ($response_from_sap['Phone3'] == '0') ? '' : $response_from_sap['Phone3'];
                                }
                                else{
                        $sapdata['phone3'] = '';
                                }
            $sapdata['email_id'] = ($response_from_sap['Email_ID'] == '0') ? '' : $response_from_sap['Email_ID'];

            if (array_key_exists('0',$response_from_sap['Details']) === false) {
                $count = 1;
            }
            else{
                $count = count($response_from_sap['Details']);
            }
            //dd(count($response_from_sap['Details']));
            if ($count == 1) {
                //dd($response_from_sap['Details']['Project_Name']);
                    $sapdata['project_details']['project_name'] = ($response_from_sap['Details']['Project_Name'] == "0") ? '' : $response_from_sap['Details']['Project_Name'];

                    $sapdata['project_details']['flat_no'] = ($response_from_sap['Details']['Flat_No'] == '0') ? '' : $response_from_sap['Details']['Flat_No'];

                    $sapdata['project_details']['date_of_booking'] = ($response_from_sap['Details']['Date_Of_Booking'] == '0') ? '' : $response_from_sap['Details']['Date_Of_Booking'];
                    $sapdata['project_details']['total_flat_value'] = ($response_from_sap['Details']['Total_Flat_Value'] == '0') ? '' : $response_from_sap['Details']['Total_Flat_Value'];
                    $sapdata['project_details']['milestone_value'] = ($response_from_sap['Details']['Milestone_Value'] == '0') ? '' : $response_from_sap['Details']['Milestone_Value'];
                    $sapdata['project_details']['current_due'] = ($response_from_sap['Details']['Current_Due'] == '0') ? '' : $response_from_sap['Details']['Current_Due'];
                    $sapdata['project_details']['total_paid'] = ($response_from_sap['Details']['Total_Paid_Amount'] == '0') ? '' : $response_from_sap['Details']['Total_Paid_Amount'];

                    $sapdata['project_details']['ptp_date'] = (($response_from_sap['Details']['PTP_Date'] == '00000000') || ($response_from_sap['Details']['PTP_Date'] == '0')) ? '' : substr($response_from_sap['Details']['PTP_Date'],0,4).'-'.substr($response_from_sap['Details']['PTP_Date'],4,2).'-'.substr($response_from_sap['Details']['PTP_Date'],6,2);

                    $sapdata['project_details']['Fund_status'] = ($response_from_sap['Details']['Fund_Status'] == '0') ? '' : $response_from_sap['Details']['Fund_Status'];
            }

            if ($count > 1) {
                $ii = 0;
                foreach ($response_from_sap['Details'] as $key1 => $value1) {
                    $sapdata['project_details'][$ii]['project_name'] = ($value1['Project_Name'] == '0') ? '' : $value1['Project_Name'];

                    $sapdata['project_details'][$ii]['flat_no'] = ($value1['Flat_No'] == '0') ? '' : $value1['Flat_No'];

                    $sapdata['project_details'][$ii]['date_of_booking'] = ($value1['Date_Of_Booking'] == '0') ? '' : $value1['Date_Of_Booking'];
                    $sapdata['project_details'][$ii]['total_flat_value'] = ($value1['Total_Flat_Value'] == '0') ? '' : $value1['Total_Flat_Value'];
                    $sapdata['project_details'][$ii]['milestone_value'] = ($value1['Milestone_Value'] == '0') ? '' : $value1['Milestone_Value'];
                    $sapdata['project_details'][$ii]['current_due'] = ($value1['Current_Due'] == '0') ? '' : $value1['Current_Due'];
                    $sapdata['project_details'][$ii]['total_paid'] = ($value1['Total_Paid_Amount'] == '0') ? '' : $value1['Total_Paid_Amount'];

                    $sapdata['project_details'][$ii]['ptp_date'] = (($value1['PTP_Date'] == '00000000') || ($value1['PTP_Date'] == '0')) ? '' : substr($value1['PTP_Date'],0,4).'-'.substr($value1['PTP_Date'],4,2).'-'.substr($value1['PTP_Date'],6,2);

                    $sapdata['project_details'][$ii]['Fund_status'] = ($value1['Fund_Status'] == '0') ? '' : $value1['Fund_Status'];
                    $ii++;
                }
            }

            }
            return response()->json($sapdata);
        }
        else{

            return response()->json(['error' => 'Not authorized.'],403);
        }

        }
        else{
            return response()->json(['error' => 'Not authorized.'],403);
        }
    }

        public function api10(){

        if ((isset($_REQUEST['key']) != '') && (isset($_REQUEST['saleorderno']) != '')) {
        //return $_REQUEST['key'];
            $client_secret = 'ASKDI12PO';
            $current_date = Carbon::now()->format('Ymd');
            $vgntoken = $client_secret.$current_date;
            $token = $_REQUEST['key'];

            $vgnhashed = Hash::make($vgntoken, ['rounds' => 12]);
            //return $vgnhashed;
            $ameyohashed = $token;

            if (Hash::check($ameyohashed, $vgnhashed)) {

            $saleno = $_REQUEST['saleorderno'];
            $sapdata = [];
            $sapdata['name'] = '';
            $sapdata['email_id'] = '';
            $sapdata['sap_lead_id'] = '';
            $sapdata['project_manager'] = '';
            $sapdata['sales_field_executive'] = '';
            $sapdata['project_name'] = '';
            $sapdata['plant_id'] = '';
            $sapdata['Source'] = '';
                $sapdata['Site_Visit_Date'] = '';
            $sapdata['Mobile_No'] = '';

            $response_from_sap = $this->showdetailsby_SaleOrderno($saleno);
        //return $response_from_sap;
            if (array_key_exists('Name', $response_from_sap) === false) {   $response_from_sap['Name'] = '' ; }
    if (array_key_exists('SAP_Lead_ID', $response_from_sap) === false) {
        $response_from_sap['Site_Visit_Date'] = '';
        $response_from_sap['SAP_Lead_ID'] = ''  ; }
    if (array_key_exists('Project_Name', $response_from_sap) === false) {   $response_from_sap['Project_Name'] = '' ; }
    if (array_key_exists('Plant_ID', $response_from_sap) === false) {   $response_from_sap['Plant_ID'] = '' ; }

if (array_key_exists('Site_Visit_Date', $response_from_sap) === false) {   $response_from_sap['Site_Visit_Date'] = '' ; }
    if (array_key_exists('Mobile_No', $response_from_sap) === false) {   $response_from_sap['Mobile_No'] = '' ; }

            //dd($response_from_sap);
            if (!empty($response_from_sap)) {
                $sapdata['name'] = $response_from_sap['Name'];
            $sapdata['email_id'] = ($response_from_sap['Email_ID'] == '0') ? '' : $response_from_sap['Email_ID'];
            $sapdata['sap_lead_id'] = $response_from_sap['SAP_Lead_ID'];
            $sapdata['project_manager'] = ($response_from_sap['Project_Manager'] == '0') ? '' : $response_from_sap['Project_Manager'];
            $sapdata['sales_field_executive'] = ($response_from_sap['Sales_Field_Executive'] == '0') ? '' : $response_from_sap['Sales_Field_Executive'];
            $sapdata['project_name'] = $response_from_sap['Project_Name'];
            $sapdata['plant_id'] = $response_from_sap['Plant_ID'];
            $sapdata['Source'] = ($response_from_sap['Source'] == '0') ? '' : $response_from_sap['Source'];
            $sapdata['Site_Visit_Date'] = ($response_from_sap['Site_Visit_Date'] == '0000-00-00') ? '' : $response_from_sap['Site_Visit_Date'];
            $sapdata['Mobile_No'] = ($response_from_sap['Mobile_No'] == '0') ? '' : trim($response_from_sap['Mobile_No']);
                //dd($sapdata);
            }
            return response()->json($sapdata);
        }
        else{

            return response()->json(['error' => 'Not authorized.'],403);
        }

        }
        else{
            return response()->json(['error' => 'Not authorized.'],403);
        }
    }

    public function api11()
    {

        if ((isset($_REQUEST['key']) != '') && (isset($_REQUEST['phoneno']) != '')) {
                $client_secret = 'ASKDI12PO';
                $current_date = Carbon::now()->format('Ymd');
                $vgntoken = $client_secret.$current_date;
                $token = $_REQUEST['key'];

                $vgnhashed = Hash::make($vgntoken, ['rounds' => 12]);
                //return $vgnhashed;
                $ameyohashed = $token;

                if (Hash::check($ameyohashed, $vgnhashed)) {




                $mobileno = $_REQUEST['phoneno'];
                $sapdata = [];

                $sapdata['name'] = '';
                        $sapdata['email_id'] = '';
                        $sapdata['sap_lead_id'] = '';
                        $sapdata['project_manager'] = '';
                        $sapdata['sales_field_executive'] = '';
                        $sapdata['project_name'] = '';
                        $sapdata['plant_id'] = '';
                        $sapdata['Source'] = '';
                        $sapdata['site_visit_date'] = '';

                $response_from_sap = $this->show_saleOrderNoDetails($mobileno);

                //dd($response_from_sap);
                if (!empty($response_from_sap)) {
                        if ($response_from_sap['Site_Visit_Date'] == '0000-00-00') {
                                $response_from_sap['Site_Visit_Date'] = '';
                        }

    if (array_key_exists('Name', $response_from_sap) === false) {       $response_from_sap['Name'] = '' ; }
    if (array_key_exists('SAP_Lead_ID', $response_from_sap) === false) {
        $response_from_sap['Site_Visit_Date'] = '';
        $response_from_sap['SAP_Lead_ID'] = ''  ; }
    if (array_key_exists('Project_Name', $response_from_sap) === false) {       $response_from_sap['Project_Name'] = '' ; }
    if (array_key_exists('Plant_ID', $response_from_sap) === false) {   $response_from_sap['Plant_ID'] = ''     ; }

                        $sapdata['name'] = $response_from_sap['Name'];
                        $sapdata['email_id'] = ($response_from_sap['Email_ID'] == '0') ? '' : $response_from_sap['Email_ID'];
                        $sapdata['sap_lead_id'] = $response_from_sap['SAP_Lead_ID'];
                        $sapdata['project_manager'] = ($response_from_sap['Project_Manager'] == '0') ? '' : $response_from_sap['Project_Manager'];
                        $sapdata['sales_field_executive'] = ($response_from_sap['Sales_Field_Executive'] == '0') ? '' : $response_from_sap['Sales_Field_Executive'];
                        $sapdata['project_name'] = $response_from_sap['Project_Name'];
                        $sapdata['plant_id'] = $response_from_sap['Plant_ID'];
                        $sapdata['Source'] = ($response_from_sap['Source'] == '0') ? '' : $response_from_sap['Source'];
                        $sapdata['site_visit_date'] = ($response_from_sap['Site_Visit_Date'] == '0') ? '' : $response_from_sap['Site_Visit_Date'];
                }
                return response()->json($sapdata);
        }
        else{

                return response()->json(['error' => 'Not authorized.'],403);
        }

        }
        else{
                return response()->json(['error' => 'Not authorized.'],403);
        }
    }



    public function showactivecampaigns()
    {
        $getactivelist = $this->getactive_campaignlist();
        //dd($getactivelist);
        //$getactivelist = DB::connection('mysql2')->table('campaignprocess')->where('Status', '=', 'Open')->get();
        $campaignlist = [];
        if (count($getactivelist['Details'])) {
            foreach ($getactivelist['Details'] as $key => $value) {
                $camplist = explode('/',$value['Campaign_Code']);
                $campaignlist[$value['Plant']][$camplist[3]] = $value['Campaign_Code_Name'];
            }
        }
        echo json_encode($campaignlist);
    }

    public function showactiveplants()
    {
        $getactivelist = $this->getactive_campaignlist();

        $plantlist = [];
        if (count($getactivelist['Details'])) {
            foreach ($getactivelist['Details'] as $key => $value) {
                 $Plant_name = str_replace('VGND ', '', $value['Plant_Description']);
                $Plant_name = str_replace('VGN ', '', $Plant_name);
                $Plant_name = str_replace('VGNPE ', '', $Plant_name);

                $plantlist[$value['Plant']] = 'VGND '.$Plant_name;

            }
        }

        echo json_encode($plantlist);
    }

    public function showbudgetrange()
    {
        $getactivelist = $this->getactive_campaignlist();

        $budgetlist = [];
        if (count($getactivelist['Details_1'])) {
            foreach ($getactivelist['Details_1'] as $key => $value) {

                $budgetlist[$value['Budget']] = $value['Budget_Description'];
            }
        }

        echo json_encode($budgetlist);
    }





    public function inbondcall_from_tatasmartflo(Request $request)
    {
        $caller = $request->input('caller');
        $called = $request->input('called');
        $start_stamp = $request->input('start_stamp');

        // Validate input
        if (!$caller || !$called || !$start_stamp) {
            return response()->json([
                'status' => 'error',
                'message' => 'Missing required input parameters.',
            ], 422);
        }

        // CRM team DID numbers
        $if_crm_team = [
            '919240255810',
            '919240255811',
            '919240255809',
            '919240255812',
            '919240255813',
            '919240255820',
        ];

        $leadName = null;
        $leadNumber = null;
        $leadSource = null;
        $responseData = [];




            if (in_array($called, $if_crm_team)) {
                    $response_from_sap_for_crm = $this->get_customerpaymentdetails($caller);

                    Log::info("Inbound call from Tata SmartFlo response_from_sap_for_crm", $response_from_sap_for_crm);

                    if (
                            isset($response_from_sap_for_crm['C_ID'], $response_from_sap_for_crm['Name']) &&
                            $response_from_sap_for_crm['C_ID'] === '0' &&
                            $response_from_sap_for_crm['Name'] === '0'
                    ) {
                            $leadName   = 'New Customer';
                            $leadNumber = 'New Customer';
                    } else {
                            $leadName   = $response_from_sap_for_crm['Name'] ?? 'New Customer';
                            $leadNumber = $response_from_sap_for_crm['C_ID'] ?? 'New Customer';
                    }

                    $leadSource   = 'CRM';
                    $responseData = $response_from_sap_for_crm;

            } else {
                    $response_from_sap = $this->showleaddetails($caller);

                    if (
                            isset($response_from_sap['SAP_Lead_ID'], $response_from_sap['Name']) &&
                            $response_from_sap['SAP_Lead_ID'] === '0' &&
                            $response_from_sap['Name'] === '0'
                    ) {
                            $leadName   = 'New Lead';
                            $leadNumber = 'New Lead';
                    } else {
                            $leadName   = $response_from_sap['Name'] ?? 'New Lead';
                            $leadNumber = $response_from_sap['SAP_Lead_ID'] ?? 'New Lead';
                    }

                    $leadSource   = $response_from_sap['Source'] ?? 'New Lead';
                    $responseData = $response_from_sap;
            }


        // Log incoming request
        Log::info("Inbound call from Tata SmartFlo", $request->all());

        // Insert into DB
        tata_inbond_call::insert([
            'caller'            => $caller,
            'called'            => $called,
            'receive_timestamp' => $start_stamp,
            'lead_Name'         => $leadName,
            'Lead_Number'       => $leadNumber,
            'Lead_source'       => $leadSource,
            'log'               => now(),
        ]);

        // Log response from SAP
        Log::info("Tata SmartFlo SAP Response", $responseData);

        // Return response
        return response()->json([
            'status'  => 'success',
            'message' => 'Customer data retrieved successfully',
            'data'    => $responseData
        ], 200);
    }





    //getting the smartflow number from round robbin method
    public function agent_inbondcall_from_tatasmartflo(Request $request)
    {
        $number         = $request->input('caller');
        $caller = preg_replace('/^\+91/', '', $number);
        $calledAgentNum = $request->input('called');
        $start_stamp    = $request->input('start_stamp');

        // Check if agent_number exists in DB
        $getagentnumber = DB::table('admin_crm')
            ->where('agent_number', $calledAgentNum)
            ->orderBy('id', 'desc')
            ->select('caller_id')
            ->first();

        if (!$getagentnumber) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Agent number not found in admin_crm table.',
            ], 404);
        }

        $called = $getagentnumber->caller_id;

        // Validate input
        if (!$caller || !$called || !$start_stamp) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Missing required input parameters.',
            ], 422);
        }

        // CRM team DID numbers
        $crmTeamDIDs = [
            '919240255810',
            '919240255811',
            '919240255809',
            '919240255812',
            '919240255813',
            '919240255820',
        ];

        $leadName     = null;
        $leadNumber   = null;
        $leadSource   = null;
        $responseData = [];

        // Determine source and fetch data
        if (in_array($called, $crmTeamDIDs)) {
            $response_from_sap_for_crm = $this->get_customerpaymentdetails($caller);

            Log::info("Inbound call from Tata SmartFlo [CRM]", $response_from_sap_for_crm);

            if (
                isset($response_from_sap_for_crm['C_ID'], $response_from_sap_for_crm['Name']) &&
                $response_from_sap_for_crm['C_ID'] === '0' &&
                $response_from_sap_for_crm['Name'] === '0'
            ) {
                $leadName   = 'New Customer';
                $leadNumber = 'New Customer';
            } 
            else 
            {
                $leadName   = $response_from_sap_for_crm['Name'] ?? 'New Customer';
                $leadNumber = $response_from_sap_for_crm['C_ID'] ?? 'New Customer';
                $plant = $response_from_sap_for_crm['Details']['Project_Code'] ?? 'New Customer';
                $Project_Name = $response_from_sap_for_crm['Details']['Project_Name'] ?? 'New Customer';
            }

            $leadSource   = 'CRM';
            $responseData = $response_from_sap_for_crm;
        } 
        else
        {
            $response_from_sap = $this->showleaddetails($caller);

            if (
                isset($response_from_sap['SAP_Lead_ID'], $response_from_sap['Name']) &&
                $response_from_sap['SAP_Lead_ID'] === '0' &&
                $response_from_sap['Name'] === '0'
            ) 
            {
                $leadName   = 'New Lead';
                $leadNumber = 'New Lead';
            } 
            else
            {
                $leadName   = $response_from_sap['Name'] ?? 'New Lead';
                $leadNumber = $response_from_sap['SAP_Lead_ID'] ?? 'New Lead';
                $plant = $response_from_sap['Plant_ID'] ?? 'New Lead';
                $Project_Name = $response_from_sap['Project_Name'] ?? 'New Lead';

            }

            $leadSource   = $response_from_sap['Source'] ?? 'New Lead';
            $responseData = $response_from_sap;
        }

        // Log incoming request
        Log::info("Inbound call from Tata SmartFlo [Raw Payload]", $request->all());

        // Insert into DB
        try {
            tata_inbond_call::insert([
                'caller'            => $caller,
                'called'            => $called,
                'receive_timestamp' => $start_stamp,
                'lead_Name'         => $leadName,
                'Lead_Number'       => $leadNumber,
                'Lead_source'       => $leadSource,
                'plan'              => $plant,
                'project'           => $Project_Name,
                'log'               => Carbon::now(),
            ]);
        } catch (\Exception $e) {
            Log::error("Tata Inbound Call - DB Insert Error", ['error' => $e->getMessage()]);
        }

        // Log final response
        Log::info("Tata SmartFlo SAP Response", $responseData);

        return response()->json([
            'status'  => 'success',
            'message' => 'Customer data retrieved successfully',
            'data'    => $responseData
        ], 200);
    }


    public function tata_inbond_call_datafetch(Request $request)
    {
        $called = trim($request->input('called'));

        $getleaddata = DB::table('tata_inbond_call')
            ->where('called', $called)
                    ->orderBy('id', 'desc')
            ->select('id','lead_Name', 'Lead_Number', 'Lead_source','plan','project','receive_timestamp','log')
            ->first();

        if ($getleaddata) {

                    $showCurrent = false;
            $callStatusText = 'previous'; // Default to previous

            $receiveTime = Carbon::parse($getleaddata->receive_timestamp);
            // $logTime = Carbon::parse($getleaddata->log);
                    $currentTime = Carbon::now();

            // Compare timestamps: if <= 1 minute, it's a current call
            if ($receiveTime->diffInMinutes($currentTime) <= 1) {
                $showCurrent = true;
                $callStatusText = 'current';
            }


            return response()->json([
                'status' => 'success',
                'message' => $showCurrent ? 'Current call' : 'Already taken (previous) call',
                'call_status' => $callStatusText,
                'data' => $getleaddata
            ], 200);

        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'Lead data not retrieved',
                'data' => $called
            ], 404);
        }
    }



    public function fetch_tatacrm_call_log()
    {
        $currentDate = Carbon::now();

        // Fetch records from the last 5 minutes
        $fromDate = Cache::get('last_fetched_timestamp', $currentDate->copy()->subMinutes(5));
        $toDate = $currentDate->copy();

        $formattedFromDate = $fromDate->format('Y-m-d\TH:i:s\Z'); // ISO 8601
        $formattedToDate = $toDate->format('Y-m-d\TH:i:s\Z');

        $url = "https://api-smartflo.tatateleservices.com/v1/call/records?from_date=" 
            . urlencode($formattedFromDate) . "&to_date=" . urlencode($formattedToDate);

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => [
                'Authorization: eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...',
                'accept: application/json'
            ],
        ]);

        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        if ($response === false) {
            $error = curl_error($curl);
            curl_close($curl);
            Log::error("cURL Error: " . $error);
            return "cURL Error: " . $error;
        }

        curl_close($curl);

        $data = json_decode($response, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            Log::error("JSON Decode Error: " . json_last_error_msg());
            return "JSON Decode Error: " . json_last_error_msg();
        }

        $results = $data['results'] ?? [];

        if (empty($results)) {
            Log::info("No results found for time range: $formattedFromDate to $formattedToDate");
            Cache::put('last_fetched_timestamp', $toDate);
            return "No results found in API response";
        }

        // Fetch existing call_ids to avoid duplicates
        $existingCallIds = tara_crm_call_log::whereBetween('created_at', [$fromDate, $toDate])
            ->pluck('call_id')
            ->toArray();

        foreach ($results as $call) {
            $callId = $call['call_id'] ?? null;

            if (!$callId || in_array($callId, $existingCallIds)) {
                continue; // skip duplicates
            }

            try {
                // Insert raw call log
                tara_crm_call_log::insert([
                    'call_id' => $callId,
                    'direction' => $call['direction'] ?? null,
                    'description' => $call['description'] ?? null,
                    'status' => $call['status'] ?? null,
                    'agent_name' => $call['agent_name'] ?? 'UNKNOWN',
                    'agent_number' => $call['agent_number'] ?? 'UNKNOWN',
                    'client_number' => $call['client_number'] ?? null,
                    'did_number' => $call['did_number'] ?? null,
                    'call_duration' => $call['call_duration'] ?? null,
                    'answered_seconds' => $call['answered_seconds'] ?? null,
                    'recording_url' => $call['recording_url'] ?? null,
                    'date' => $call['date'] ?? null,
                    'time' => $call['time'] ?? null,
                    'end_stamp' => $call['end_stamp'] ?? null,
                    'agent_cid' => $call['extension_c2c'] ?? null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                Log::info("Inserted call log record with call_id: $callId");

            

            } catch (\Illuminate\Database\QueryException $e) {
                Log::error("Error inserting call_id $callId: " . $e->getMessage(), ['call' => $call]);
                continue;
            }
        }

        // Update last fetched timestamp
        Cache::put('last_fetched_timestamp', $toDate);

        Log::info("Processed " . count($results) . " API records, inserted new records.");
        return "Processed " . count($results) . " API records.";
    }


    public function calling945_report_job()
    {
        //  Get last processed call_id from cache (or set null if first run)
        $lastProcessedCallId = Cache::get('calling945_last_call_id', 814563);

        // Fetch only new records from tara_crm_call_log
        $newRecordsQuery = DB::table('tara_crm_call_log')
        ->where('direction', 'outbound')
        ->orderBy('id', 'asc')
        ->limit(50);

        if ($lastProcessedCallId)
        {
        $newRecordsQuery->where('id', '>', $lastProcessedCallId);
        }

        $newRecords = $newRecordsQuery->get();

        foreach ($newRecords as $record) 
        {
            try
            {

            $leadId = null;
            $leadName = null;
            $plant = null;

            // Fetch agent details
            $agent_number_fetch = $record->agent_cid;
            $get_agent_details = AdminCrm::where('agent_number', $agent_number_fetch)->first();

            $clientNumber = $record->client_number ?? null;

                if($get_agent_details && $get_agent_details->department === 'SALES')
                {
           

                    $response_getinglead_details = $this->showleaddetails($clientNumber);

                    $emailIdIsZero = !isset($response_getinglead_details['Email_ID']) || $response_getinglead_details['Email_ID'] === '0';
                    if ($emailIdIsZero && preg_match('/^\+91\d{10}$/', $clientNumber))
                    {
                        $trimmedNumber = substr($clientNumber, 3);
                        $response_getinglead_details = $this->showleaddetails($trimmedNumber);
                    }

                    $leadId = $response_getinglead_details['SAP_Lead_ID'] ?? null;
                    $leadName = $response_getinglead_details['Name'] ?? null;
                    $plant = $response_getinglead_details['Plant_ID'] ?? null;


                    // Insert enriched call data
                    calling945_report::insert([
                    'client_number'      => $clientNumber,
                    'Agent_number'       => $agent_number_fetch,
                    'Agent_DID'         => $record->did_number ?? null,
                    'status'            => $record->status ?? null,
                    'total_call_duration' => $record->call_duration ?? 'UNKNOWN',
                    'Agent_name'        => $get_agent_details->name ?? 'UNKNOWN',
                    'Agent_dept'        => $get_agent_details->department ?? null,
                    'lead_name'         => $leadName,
                    'lead_id'           => $leadId,
                    'plant'             => $plant,
                    'recording'         => $record->recording_url ?? null,
                    'call_log'          => $record->end_stamp ?? null,
                    'call_date_log'     => $record->date ?? null,
                    'call_time_log'     => $record->time ?? null,
                    'db_stored_log'     => now(),
                    ]);

                    // Update cache with the latest processed call_id
                    Cache::put('calling945_last_call_id', $record->id);

                 }

            }
            catch (\Illuminate\Database\QueryException $e)
            {
            Log::error("calling945_report error" .$e->getMessage());
            continue;
            }
        }

        if ($newRecords->isEmpty())
        {
        Log::info("No new records found to insert into calling945_report.");
        return;
        }

       




    }


        //calling945 - get call log using each DID
        public function fetch_tatacrm_call_log_did(Request $request)
        {
                $currentDate = Carbon::now();

                // Check if fdate and todate are provided, else use the current date
                if ($request->filled('fdate') && $request->filled('todate')) {
                        $did = trim($request->input('did'));
                        $fdate = trim($request->input('fdate'));
                        $todate = trim($request->input('todate'));
                } else {
                        $did = trim($request->input('did'));
                        $fdate = $currentDate->format('Y-m-d');
                        $todate = $currentDate->format('Y-m-d');
                }

                // Fetch the logs from the database
                $getlog = DB::table('tara_crm_call_log')
                        ->where('did_number', $did)
                        ->whereBetween('date', [$fdate, $todate])
                        ->orderBy('time', 'asc')
                        ->orderBy('id', 'desc')
                        ->get();

                // Check if any records are returned
                if ($getlog->isNotEmpty()) {
                        return response()->json([
                                'status' => 'success',
                                'message' => 'Log data retrieved successfully',
                                'did' => $did,
                                'fdate' => $fdate,
                                'todate' => $todate,
                                'total' => $getlog->count(),
                                'result' => $getlog,
                        ], 200);
                } else {
                        return response()->json([
                                'status' => 'failed',
                                'message' => 'No log data found for the provided DID and date range',
                                'did' => $did,
                                'fdate' => $fdate,
                                'todate' => $todate,
                                'total' => 0,
                                'result' => [],
                        ], 404);
                }
        }


        //calling945 - get current calls & missed call with lead / Customer id 
        public function fetch_tatacrm_currentdate_call_log(Request $request)
        {
              
                $did = trim($request->input('did'));
                $records = DB::table('tata_inbond_call')
                ->where('called', $did)
                ->whereRaw("DATE(CONVERT_TZ(receive_timestamp, '+00:00', '+05:30')) = CURDATE()")
                ->orderBy('id', 'desc')
                ->get();

                   // Check if any records are returned
                if ($records->isNotEmpty()) {
                        return response()->json([
                                'status' => 'success',
                                'message' => 'Log data retrieved successfully',
                                'did' => $did,
                                'total' => $records->count(),
                                'result' => $records,
                        ], 200);
                } else {
                        return response()->json([
                                'status' => 'failed',
                                'message' => 'No log data found for the provided DID ',
                                'did' => $did,
                                'total' => 0,
                                'result' => [],
                        ], 404);
                }                

             
        }




        public function getFilteredDailyReport(Request $request)
        {
            // Mandatory date range
            $fromDate = $request->input('from_date'); 
            $toDate   = $request->input('to_date');   

            if (!$fromDate || !$toDate) {
                return response()->json([
                    'error' => 'Please provide both from_date and to_date'
                ], 400);
            }

            // Optional filters
            $plant    = $request->input('plant');     
            $agent    = $request->input('Agent'); 
            $fromduro = $request->input('fromduro'); 
            $toduro   = $request->input('toduro');
            $Team     = $request->input('Team');  // optional Agent_dept filter

            // Start query
            $query = DB::table('calling945_report')
                ->selectRaw("
                    client_number,
                    Agent_number,
                    COUNT(*) AS total_attempts,
                    SUM(CASE WHEN status = 'missed' THEN 1 ELSE 0 END) AS missed_count,
                    SUM(CASE WHEN status != 'missed' THEN total_call_duration ELSE 0 END) AS total_call_duration,
                    MAX(Agent_name) AS Agent_name,
                    MAX(Agent_dept) AS Agent_dept,
                    MAX(lead_name) AS lead_name,
                    MAX(lead_id) AS lead_id,
                    MAX(plant) AS plant,
                    GROUP_CONCAT(DISTINCT call_date_log ORDER BY call_date_log, call_time_log SEPARATOR ', ') AS call_dates,
                    GROUP_CONCAT(DISTINCT call_time_log ORDER BY call_date_log, call_time_log SEPARATOR ', ') AS call_times,
                    GROUP_CONCAT(DISTINCT recording ORDER BY call_date_log, call_time_log SEPARATOR ', ') AS recordings
                ")
                ->whereBetween('call_date_log', [$fromDate, $toDate]); 

            // Optional filters
            if ($plant) {
                $query->where('plant', $plant);
            }

            if ($agent) {
                $query->where('Agent_number', $agent);
            }

            if ($Team) {
                $query->where('Agent_dept', $Team); // Optional Agent_dept filter
            }

            // Optional call duration filter
            if ($fromduro !== null && $toduro !== null) {
                $query->havingRaw('SUM(CASE WHEN status != "missed" THEN total_call_duration ELSE 0 END) BETWEEN ? AND ?', [$fromduro, $toduro]);
            }

            // Group and order
            $dailyReport = $query
                ->groupBy('client_number', 'Agent_number')
                ->orderBy('client_number')
                ->orderBy('Agent_number')
                ->get();

            return response()->json($dailyReport);
        }
      




}
