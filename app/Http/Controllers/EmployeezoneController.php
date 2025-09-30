<?php

namespace vgn\Http\Controllers;

use AWS\CRT\HTTP\Response as HTTPResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Session;
use Crypt;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use vgn\vendor_api_key;
use DB;
use vgn\projectlist;
use vgn\Http\Traits\employeetrait;
use vgn\Jobs\employeeloginbgjob;
use vgn\Mail\sendforgotpwdotp;
use vgn\Http\Traits\LMS\attendance_summary;
use Response;
use File;
use Importer;
use ZipArchive;
use vgn\Http\Controllers\CommonLeadController;


class EmployeezoneController extends Controller
{
    use employeetrait, attendance_summary;
    private $commonLeadController;
    public function __construct(CommonLeadController $commonLeadController)
    {
        $this->commonLeadController = $commonLeadController;
    }

    public function is_emp_didnt_passwordchanged($id)
    {
        $is_didnt_passwordchanged = DB::connection('mysql6')->table('dashboard')->where(['employee_id' => $id])->get();
        $changed_pwd = 1;
        foreach ($is_didnt_passwordchanged as $key => $value) {
            if (($value->last_password_changed == null) || ($value->last_password_changed == '') || ($value->last_password_changed == '0000-00-00 00:00:00')) {
                $changed_pwd = 0;
            }
        }
                        return $changed_pwd;
    }
    
     public function newindex(Request $request)
    {
         
        if ($request->session()->has('employeesession')) {
            $encrypt = $request->session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $employeeid = $split[0];
		
            return $this->newlogout($request);
             
             $getdashboard = DB::connection('mysql6')->table('dashboard')->where('employee_id', '=', $employeeid)->get();
		
	     $current_day_month = Carbon::now()->format('m-d');
//$getactiveemployees = $this->getallactiveemployees();
$getactiveemployees = DB::connection('mysql6')->table('active_emp')->get();


$birthday_employees = [];
$doj_employees = [];
foreach ($getactiveemployees as $key11 => $value11) {

        if(!empty($value11->Birth_Date)){
    if (substr($value11->Birth_Date, 5,5) == $current_day_month) {
        $birthday_employees[] = $value11;
    }
    }

        if(!empty($value11->DOJ)){
    if (substr($value11->DOJ, 5,5) == $current_day_month) {
        $doj_employees[$key11] = $value11;

        $doj_employees[$key11]->differeinyears = Carbon::now()->diffInYears(Carbon::parse($value11->DOJ));
    }
   }
}
             $listfiles = Storage::disk('s3')->files("/newcustomerzoneassets/employeeprofileimage/".$employeeid);             
             if(count($listfiles) > 0){
                $profilepic = config('app.AWS_URL')."/".$listfiles[0];
            }
             else
             {
                $profilepic = config('app.AWS_URL')."/newcustomerzoneassets/img/dummy_male.png";
             }
             
            $getemployeedata = DB::connection('mysql6')->table('employee')->where('id', '=', $employeeid)->get();
            return view('newemployeezone.dashboard')->with(['getdashboard'=>$getdashboard,'experience' => $doj_employees,'getbirthday_employees'=>$birthday_employees ,'getemployeedata'=>$getemployeedata, 'profilepic' => $profilepic]);
        }
        return view('newemployeezone.login');
    }
    
    public function runemployeeprocessold($employeeid,$valid, $request,$saleorder){
        
        $sapdata = $this->getemployee($employeeid);
	

       
        
         if(($sapdata['First_Name'] != '')&&($valid == "1"))
                 {
                     if($sapdata['Date_of_Joining'] != ''){
                         if(substr($sapdata['Date_of_Joining'],0,4) != '0000'){
                         $sapdata['Date_of_Joining'] = substr($sapdata['Date_of_Joining'],0,4).'-'.substr($sapdata['Date_of_Joining'],4,2).'-'.substr($sapdata['Date_of_Joining'],6,2); 
                         }else
                         {
                             $sapdata['Date_of_Joining'] = null;
                         }
                     }
                     
                      if($sapdata['Birth_Date'] != ''){
                         if(substr($sapdata['Birth_Date'],0,4) != '0000'){
                         $sapdata['Birth_Date'] = substr($sapdata['Birth_Date'],0,4).'-'.substr($sapdata['Birth_Date'],4,2).'-'.substr($sapdata['Birth_Date'],6,2); 
                         }else
                         {
                             $sapdata['Birth_Date'] = null;
                         }
                     }
                     
                     
                     $now = Carbon::now();
             DB::connection('mysql6')->table('employee')->where('id','=',$employeeid)->delete();
             
                     DB::connection('mysql6')->table('employee')->insert([
                     'id' => $employeeid,
                     'name' => $sapdata['First_Name']." ".$sapdata['Last_Name'],
                     'title' => $sapdata['Title'],
                     'sap_id' => $sapdata['SAP_ID'],
                     'gender' => $sapdata['Gender'],
                     'birthdate'=> $sapdata['Birth_Date'],
                     'maritalstatus'=> $sapdata['Marital_Status'],
                     'noofchildren'=> $sapdata['No_of_Childrens'],
                     'nationality'=> $sapdata['Nationality'],
                     'bloodgroup'=> $sapdata['Blood_Group'],
                     'personalmail'=> $sapdata['Personal_Email'],
                     'officialmail'=> $sapdata['Office_Email'],
                     'personal_mobile'=> $sapdata['Personal_Mobile'],
                     'panno'=> $sapdata['PAN_No'],
                     'bank_name'=> $sapdata['Bank_Name'],
                     'bank_acnt_no'=> $sapdata['Bank_Account_No'],
                     'pf_no'=> $sapdata['PF_No'],
                     'esi_no'=> $sapdata['ESI_No'],
                     'doj'=> $sapdata['Date_of_Joining'],
                     'company_name'=> $sapdata['Company_Name'],
                     'plantid'=> $sapdata['Plant_ID'],
                     'plant_name'=> $sapdata['Plant_Name'],
                     'department'=> $sapdata['Department'],
		     'department_code'=> $sapdata['Dept_Code'],
                     'position'=> $sapdata['Position'],
                     'reporting_manager'=> $sapdata['Reporting_Manager'],
                     'shift_name'=> $sapdata['Shift_Name'],
                     'shift_timings_in'=> $sapdata['Shift_Timings_IN'],
                     'shift_timings_out'=> $sapdata['Shift_Timings_OUT'],
                     'role_code'=> $sapdata['Role_Code'],
                     'role_name'=> $sapdata['Role_Name'],
                     'cadre' => $sapdata['Cadre'],
                     'saleorder'=> $saleorder,
                     'created_date' => $now
                     ]); 
                    
                    //start of address function
                    $sap_address = array();
                    if (array_key_exists('Address', $sapdata)) {
                    
                    $sapaddress = $sapdata['Address'];
                    if (array_key_exists('0', $sapaddress)) {
                        $sap_address = $sapaddress;
                    }
                    else
                    {
                        $sap_address[0] = $sapaddress;
                    }
                    
                     $getaddress = DB::connection('mysql6')->table('address')->where('employee_id', '=', $employeeid)->get();
                     
                     
                     if(count($getaddress) > 0)
                     {
                         $getaddress = DB::connection('mysql6')->table('address')->where('employee_id', '=', $employeeid)->delete();
                     }
                    
                        foreach ($sap_address as $sapaddrkey => $sapaddrvalue) {    
                         if($sapaddrvalue['Postal_Code'] == ''){
                        $sapaddrvalue['Postal_Code'] = 0;
                     }                                                    
                                DB::connection('mysql6')->table('address')
                                ->insert(['employee_id' => $employeeid,
                                'street_house_no' => $sapaddrvalue['Street_House_No'],
                                'street_house_no1' => $sapaddrvalue['Street_House_No1'],
                                'postal_code' => $sapaddrvalue['Postal_Code'],
                                'city' => $sapaddrvalue['City'],
                                'country' => $sapaddrvalue['Country'],
                                'address_type' => $sapaddrvalue['Address_Type']
                                 ]);
                        }
                     
                 }
                     
                     //end of address function
             
             //start of experience function
                    $sap_experience = array();
                    if (array_key_exists('Previous_Exp', $sapdata)) {
                    
                    $sapexperience = $sapdata['Previous_Exp'];
                    if (array_key_exists('0', $sapexperience)) {
                        $sap_experience = $sapexperience;
                    }
                    else
                    {
                        $sap_experience[0] = $sapexperience;
                    }
                    
                     $getexperience = DB::connection('mysql6')->table('experience')->where('employee_id', '=', $employeeid)->get();
                     
                     
                     if(count($getexperience) > 0)
                     {
                         $getexperience = DB::connection('mysql6')->table('experience')->where('employee_id', '=', $employeeid)->delete();
                     }
                        foreach ($sap_experience as $sapexpkey => $sapexpvalue) {  
                            
                             if($sapexpvalue['From_Date'] != ''){
                         if(substr($sapexpvalue['From_Date'],0,4) != '0000'){
                         $sapexpvalue['From_Date'] = substr($sapexpvalue['From_Date'],0,4).'-'.substr($sapexpvalue['From_Date'],4,2).'-'.substr($sapexpvalue['From_Date'],6,2); 
                         }else
                         {
                             $sapexpvalue['From_Date'] = null;
                         }
                     }
                            
                             if($sapexpvalue['To_Date'] != ''){
                         if(substr($sapexpvalue['To_Date'],0,4) != '0000'){
                         $sapexpvalue['To_Date'] = substr($sapexpvalue['To_Date'],0,4).'-'.substr($sapexpvalue['To_Date'],4,2).'-'.substr($sapexpvalue['To_Date'],6,2); 
                         }else
                         {
                             $sapexpvalue['To_Date'] = null;
                         }
                     }
                                DB::connection('mysql6')->table('experience')
                                ->insert(['employee_id' => $employeeid,
                                'employer' => $sapexpvalue['Name_of_Employer'],
                                'from_date' => $sapexpvalue['From_Date'],
                                'to_date' => $sapexpvalue['To_Date']
                                 ]);
                        }
                     
                 }
                     
                     //end of experience function
                     
                     //start of education function
                    $sap_education = array();
                    if (array_key_exists('Education', $sapdata)) {
                    
                    $sapeducation = $sapdata['Education'];
                    if (array_key_exists('0', $sapeducation)) {
                        $sap_education = $sapeducation;
                    }
                    else
                    {
                        $sap_education[0] = $sapeducation;
                    }
                    
                     $geteducation = DB::connection('mysql6')->table('education')->where('employee_id', '=', $employeeid)->get();
                     
                     
                     if(count($geteducation) > 0)
                     {
                         $getaddress = DB::connection('mysql6')->table('education')->where('employee_id', '=', $employeeid)->delete();
                     }
                        foreach ($sap_education as $sapedukey => $sapeduvalue) {  
                            
                            if($sapeduvalue['From_Date'] != ''){
                         if(substr($sapeduvalue['From_Date'],0,4) != '0000'){
                         $sapeduvalue['From_Date'] = substr($sapeduvalue['From_Date'],0,4).'-'.substr($sapeduvalue['From_Date'],4,2).'-'.substr($sapeduvalue['From_Date'],6,2); 
                         }else
                         {
                             $sapeduvalue['From_Date'] = null;
                         }
                     }
                            
                             if($sapeduvalue['To_Date'] != ''){
                         if(substr($sapeduvalue['To_Date'],0,4) != '0000'){
                         $sapeduvalue['To_Date'] = substr($sapeduvalue['To_Date'],0,4).'-'.substr($sapeduvalue['To_Date'],4,2).'-'.substr($sapeduvalue['To_Date'],6,2); 
                         }else
                         {
                             $sapeduvalue['To_Date'] = null;
                         }
                     }
                                DB::connection('mysql6')->table('education')
                                ->insert(['employee_id' => $employeeid,
                                'type_of_education' => $sapeduvalue['Type_of_Graduation'],
                                'certificate' => $sapeduvalue['Certificate'],
                                'school_and_univercity' => $sapeduvalue['School_and_Univercity'],
                                'from_date' => $sapeduvalue['From_Date'],
                                'to_date' => $sapeduvalue['To_Date']
                                 ]);
                        }
                     
                 }
                     
                     //end of education function
                     
                     //start of eligibilities function
                    $sap_eligibilities = array();
                    if (array_key_exists('Eligibilities', $sapdata)) {
                    
                    $sapeligibilities = $sapdata['Eligibilities'];
                    if (array_key_exists('0', $sapeligibilities)) {
                        $sap_eligibilities = $sapeligibilities;
                    }
                    else
                    {
                        $sap_eligibilities[0] = $sapeligibilities;
                    }
                    
                        $sap_eligibilities_employee = array();
                    if (array_key_exists('Eligibilities_1', $sapdata)) {
                    
                    $sapeligibilitiesemp = $sapdata['Eligibilities_1'];
                    if (array_key_exists('0', $sapeligibilitiesemp)) {
                        $sap_eligibilities_employee = $sapeligibilitiesemp;
                    }
                    else
                    {
                        $sap_eligibilities_employee[0] = $sapeligibilitiesemp;
                    }
                    
                     $geteligibilities = DB::connection('mysql6')->table('eligibilities')->where('employee_id', '=', $employeeid)->get();
                     
                     
                     if(count($geteligibilities) > 0)
                     {
                         $getaddress = DB::connection('mysql6')->table('eligibilities')->where('employee_id', '=', $employeeid)->delete();
                     }
                        foreach ($sap_eligibilities as $sapeligibkey => $sapeligibvalue) {  
                           
                           foreach($sapeligibvalue as $keligb => $veligib){
                               if($keligb == 'BUSINESSCARD'){ $keligb = 'BUSINESS_CARD';}
                               if($keligb == 'SAPID'){ $keligb = 'SAP_ID';}
                               if($keligb == 'IDCARD'){ $keligb = 'ID_CARD';}
                                DB::connection('mysql6')->table('eligibilities')
                                ->insert(['employee_id' => $employeeid,
                                'products_issued' => $keligb,
                                'confirmation_by_org' => $veligib,
                                'confirmation_by_employee' => $sap_eligibilities_employee[$sapeligibkey][$keligb]
                                 ]);
                           }
                        }
                     
                 }
                    }
                     
                     //end of eligibilities function
                        
                        //start of duties and resp function
                    $sap_duty = array();
                    if (array_key_exists('Duties_Responsibilities', $sapdata)) {
                    
                    $sapduty = $sapdata['Duties_Responsibilities'];
                    if (array_key_exists('0', $sapduty)) {
                        $sap_duty = $sapduty;
                    }
                    else
                    {
                        $sap_duty[0] = $sapduty;
                    }
                    
                     $getduty = DB::connection('mysql6')->table('duties_and_resp')->where('employee_id', '=', $employeeid)->get();
                     
                     
                     if(count($getduty) > 0)
                     {
                         $getduty = DB::connection('mysql6')->table('duties_and_resp')->where('employee_id', '=', $employeeid)->delete();
                     }
                        $resp = '';
                        foreach ($sap_duty[0] as $sapdutykey => $sapdutyvalue) {  
                            
                            $resp .= $sap_duty[0][$sapdutykey].' ';
                                
                        }
                        DB::connection('mysql6')->table('duties_and_resp')
                                ->insert(['employee_id' => $employeeid,
                                'duties_and_resp_desc' => $resp,
                                'created_date' => $now
                                 ]);
                     
                 }
                     
                     //end of duties and resp function
                        //dd($sapdata);
                         //start of complaint function
                    $sap_complaint = array();
                    if (array_key_exists('My_Complaints', $sapdata)) {
                    
                    $sapcomplaint = $sapdata['My_Complaints'];

                    if (array_key_exists('0', $sapcomplaint)) {
                        $sap_complaint = $sapcomplaint;
                    }
                    else
                    {
                        $sap_complaint[0] = $sapcomplaint;
                    }
                    //dd($sap_complaint);
                     $getcomplaint = DB::connection('mysql6')->table('complaints')->where('employee_id', '=', $employeeid)->get();
                     
                     
                     if(count($getcomplaint) > 0)
                     {
                         $getaddress = DB::connection('mysql6')->table('complaints')->where('employee_id', '=', $employeeid)->delete();
                     }
                        foreach ($sap_complaint as $sapcomplaintkey => $sapcomplaintvalue) {           $complaintdesc = '';
                            $complinc = 1;
                            foreach($sap_complaint[$sapcomplaintkey] as $desc){
                                if($complinc <= 20){
                                $complaintdesc .= $sap_complaint[$sapcomplaintkey]["Line$complinc"];
                                }
                                $complinc++;
                            }
                                                                                            
                             if($sapcomplaintvalue['Complaint_Date'] != ''){
                         if(substr($sapcomplaintvalue['Complaint_Date'],0,4) != '0000'){
                         $sapcomplaintvalue['Complaint_Date'] = substr($sapcomplaintvalue['Complaint_Date'],0,4).'-'.substr($sapcomplaintvalue['Complaint_Date'],4,2).'-'.substr($sapcomplaintvalue['Complaint_Date'],6,2); 
                         }else
                         {
                             $sapcomplaintvalue['Complaint_Date'] = null;
                         }
                     }
                                        
                            
                                DB::connection('mysql6')->table('complaints')
                                ->insert(['employee_id' => $employeeid,
                                'complaint_no' => $sapcomplaintvalue['Complaint_No'],
                                'complaint_date' => $sapcomplaintvalue['Complaint_Date'],
                                'nature_of_complaint' => $sapcomplaintvalue['Nature_of_Comp'],
                                'description' => $complaintdesc,
                                'hrcare_name' => $sapcomplaintvalue['HR_Name'],
                                'hr_status' => $sapcomplaintvalue['HR_Status'],
                                'emp_status' => $sapcomplaintvalue['Employee_Status']
                                 ]);
                        }
                     
                 }
                     
                     //end of complaint function
                        
                        $getdashboard_data = $this->dashboard($employeeid);
                        //dd($getdashboard_data);
                        
                          //start of dashboard function
                    $sap_dashboard = array();
                    if (!empty($getdashboard_data)) {
                    
                    $sapdashboard = $getdashboard_data;
                    if (array_key_exists('0', $sapdashboard)) {
                        $sap_dashboard = $sapdashboard;
                    }
                    else
                    {
                        $sap_dashboard[0] = $sapdashboard;
                    }
                    
                     $getdashboard = DB::connection('mysql6')->table('dashboard')->where('employee_id', '=', $employeeid)->get();
                     
                     
                     if(count($getdashboard) > 0)
                     {
                         $getaddress = DB::connection('mysql6')->table('dashboard')->where('employee_id', '=', $employeeid)->delete();
                     }
                        foreach ($sap_dashboard as $sapdashkey => $sapdashvalue) {           $complaintdesc = '';
                            
                                                                                            
                             if($sapdashvalue['Changed_Your_Details_On'] != ''){
                         if(substr($sapdashvalue['Changed_Your_Details_On'],0,4) != '0000'){
                         $sapdashvalue['Changed_Your_Details_On'] = substr($sapdashvalue['Changed_Your_Details_On'],0,4).'-'.substr($sapdashvalue['Changed_Your_Details_On'],4,2).'-'.substr($sapdashvalue['Changed_Your_Details_On'],6,2); 
                         }else
                         {
                             $sapdashvalue['Changed_Your_Details_On'] = null;
                         }
                     }
                        if($sapdashvalue['Last_Changed_Pwd_On'] != ''){
                         if(substr($sapdashvalue['Last_Changed_Pwd_On'],0,4) != '0000'){
                         $sapdashvalue['Last_Changed_Pwd_On'] = substr($sapdashvalue['Last_Changed_Pwd_On'],0,4).'-'.substr($sapdashvalue['Last_Changed_Pwd_On'],4,2).'-'.substr($sapdashvalue['Last_Changed_Pwd_On'],6,2); 
                         }else
                         {
                             $sapdashvalue['Last_Changed_Pwd_On'] = null;
                         }
                     }
                                                                                  
                        if($sapdashvalue['Next_Training_Date'] != ''){
                         if(substr($sapdashvalue['Next_Training_Date'],0,4) != '0000'){
                         $sapdashvalue['Next_Training_Date'] = substr($sapdashvalue['Next_Training_Date'],0,4).'-'.substr($sapdashvalue['Next_Training_Date'],4,2).'-'.substr($sapdashvalue['Next_Training_Date'],6,2); 
                         }else
                         {
                             $sapdashvalue['Next_Training_Date'] = null;
                         }
                     }
                                        
                            
                                DB::connection('mysql6')->table('dashboard')
                                ->insert(['employee_id' => $employeeid,
                                'last_details_changed' => $sapdashvalue['Changed_Your_Details_On'],
                                'last_password_changed' => $sapdashvalue['Last_Changed_Pwd_On'],
                                'next_training_date' => $sapdashvalue['Next_Training_Date'],
                                'loans_and_advances' => $sapdashvalue['Loans_Advance_Due'],
                                't_comp_raised' => $sapdashvalue['Total_Complaints_Raised'],
                                't_comp_closed' => $sapdashvalue['Total_Complaints_Closed'],
                                't_comp_pending' => $sapdashvalue['Total_Complaints_Pending'],
                                't_pending_req' => $sapdashvalue['Total_Requests_Pending'],
                                't_memos_issued' => $sapdashvalue['Total_Memos_Issued'],
                                 ]);
                        }
                     
                 }
                     
                     //end of dashboard function
                    
                    
return 'ok';
                   
                   
                 }
        else
        {
            return 'not ok';
        }

                    
                    
                 
        
        
    }

    public function runemployeeprocess($employeeid,$valid, $request,$saleorder){
        
        $sapdata = $this->employeebasicinfo($employeeid);
            //dd($sapdata);
         if(($sapdata['First_Name'] != '')&&($valid == "1"))
                 {
        $employeeloginbgjob = new employeeloginbgjob($employeeid,$valid,$saleorder);
        dispatch($employeeloginbgjob);


$getdashboard_data = $this->dashboard($employeeid);
                        //dd($getdashboard_data);
                        
                          //start of dashboard function
                    $sap_dashboard = array();
                    if (!empty($getdashboard_data)) {
                    
                    $sapdashboard = $getdashboard_data;
                    if (array_key_exists('0', $sapdashboard)) {
                        $sap_dashboard = $sapdashboard;
                    }
                    else
                    {
                        $sap_dashboard[0] = $sapdashboard;
                    }
                    
                     $getdashboard = DB::connection('mysql6')->table('dashboard')->where('employee_id', '=', $employeeid)->get();
                     
                     
                     if(count($getdashboard) > 0)
                     {
                         $getaddress = DB::connection('mysql6')->table('dashboard')->where('employee_id', '=', $employeeid)->delete();
                     }
                        foreach ($sap_dashboard as $sapdashkey => $sapdashvalue) {           $complaintdesc = '';
                            
                                                                                            
                             if($sapdashvalue['Changed_Your_Details_On'] != ''){
                         if(substr($sapdashvalue['Changed_Your_Details_On'],0,4) != '0000'){
                         $sapdashvalue['Changed_Your_Details_On'] = substr($sapdashvalue['Changed_Your_Details_On'],0,4).'-'.substr($sapdashvalue['Changed_Your_Details_On'],4,2).'-'.substr($sapdashvalue['Changed_Your_Details_On'],6,2); 
                         }else
                         {
                             $sapdashvalue['Changed_Your_Details_On'] = null;
                         }
                     }
                        if($sapdashvalue['Last_Changed_Pwd_On'] != ''){
                         if(substr($sapdashvalue['Last_Changed_Pwd_On'],0,4) != '0000'){
                         $sapdashvalue['Last_Changed_Pwd_On'] = substr($sapdashvalue['Last_Changed_Pwd_On'],0,4).'-'.substr($sapdashvalue['Last_Changed_Pwd_On'],4,2).'-'.substr($sapdashvalue['Last_Changed_Pwd_On'],6,2); 
                         }else
                         {
                             $sapdashvalue['Last_Changed_Pwd_On'] = null;
                         }
                     }
                                                                                  
                        if($sapdashvalue['Next_Training_Date'] != ''){
                         if(substr($sapdashvalue['Next_Training_Date'],0,4) != '0000'){
                         $sapdashvalue['Next_Training_Date'] = substr($sapdashvalue['Next_Training_Date'],0,4).'-'.substr($sapdashvalue['Next_Training_Date'],4,2).'-'.substr($sapdashvalue['Next_Training_Date'],6,2); 
                         }else
                         {
                             $sapdashvalue['Next_Training_Date'] = null;
                         }
                     }
                                        
                            
                                DB::connection('mysql6')->table('dashboard')
                                ->insert(['employee_id' => $employeeid,
                                'last_details_changed' => $sapdashvalue['Changed_Your_Details_On'],
                                'last_password_changed' => $sapdashvalue['Last_Changed_Pwd_On'],
                                'next_training_date' => $sapdashvalue['Next_Training_Date'],
                                'loans_and_advances' => $sapdashvalue['Loans_Advance_Due'],
                                't_comp_raised' => $sapdashvalue['Total_Complaints_Raised'],
                                't_comp_closed' => $sapdashvalue['Total_Complaints_Closed'],
                                't_comp_pending' => $sapdashvalue['Total_Complaints_Pending'],
                                't_pending_req' => $sapdashvalue['Total_Requests_Pending'],
                                't_memos_issued' => $sapdashvalue['Total_Memos_Issued'],
                                 ]);
                        }
                     
                 }
                     
                     //end of dashboard function

                    return 'ok';                   
                 }
        else
        {
            return 'not ok';
        }

                    
                    
                 
        
        
    }
    
    public function newlogin(Request $request){
        
         if (strpos($request->username, '@') !== false) {
            $loginmode = 'loginmode_emailid';
		 $blocked = array('kamalraj.d@vgn.in','sureshsubramanian.bv@vgn.in');
                 if (in_array(strtolower($request->username), $blocked, true)) {
                        $request->session()->flash("error_msg", "Your Login is Blocked!");
                return redirect()->back()->withInput();
                }
        }
        elseif (ctype_digit($request->username)) {

            if (strlen($request->username) == 10) {
                $loginmode = 'loginmode_mobileno';
                $blocked = array('9841475950','9789059651','9884027997','9790040190','8012132113','7904310639','9962092314','9790941210','8754489309');
                 if (in_array($request->username, $blocked, true)) {
                	$request->session()->flash("error_msg", "Your Login is Blocked!");
                return redirect()->back()->withInput();
                }
            }
            elseif((strlen($request->username) >= 3)&&(strlen($request->username) < 10)){
                $loginmode = 'loginmode_employeeid';
                $blocked = array('200177','200190','200577','201170','100308','200197','100466','100019','201162');
                if (in_array($request->username, $blocked, true)) {
                	$request->session()->flash("error_msg", "Your Login is Blocked!");
                return redirect()->back()->withInput();
                }
            }
            else{
                $request->session()->flash("error_msg", "Sorry! Enter a valid EmployeeId or Mobile Number");
                return redirect()->back()->withInput();
            }
                
        }
        else{
            
                $request->session()->flash("error_msg", "Sorry! Enter a valid Username");
                return redirect()->back()->withInput();
        }
        
        
        if ($loginmode == 'loginmode_employeeid') {
            if (!ctype_digit($request->username)) {
                
                $request->session()->flash("error_msg", "Sorry! Enter a valid Employee Id");
                return redirect()->back()->withInput();
            }
            
            
                $employeeid = ltrim($request->username, '0');
                
                $checklogin = $this->checkLogin(ltrim($employeeid,'0'), $request->password);
               //dd($checklogin);
                if($checklogin['STATUS'] == 'Login Failed'){
                    $this->runemployeeprocess(ltrim($employeeid,'0') , '1', $request,'0');
                    $valid = "0";
                }
                elseif($checklogin['STATUS'] == 'Login Success'){

                	


                   
                   $check_cred = DB::connection('mysql6')->table('employee_credentials')->where('id','=',$employeeid)->count();
                   if ($check_cred > 0) {
                   	DB::connection('mysql6')->table('employee_credentials')->where('id','=',$employeeid)->update([
                   		'password' => Hash::make($request->password, ['rounds' => 12]),
                   		'lastloginned_datetime' => Carbon::now()->toDateTimeString(),
                   		'is_loggined' => 1
                   	]);
                   }
                   else{
                   	DB::connection('mysql6')->table('employee_credentials')->insert([
                   		'id' => $employeeid,
                   		'password' => Hash::make($request->password, ['rounds' => 12]),
                   		'lastloginned_datetime' => Carbon::now()->toDateTimeString(),
                   		'is_loggined' => 1
                   	]);
                   }

                    if($checklogin["STATUS_1"] == ''){
									$saleorder = '0';
							}
                    if($checklogin["STATUS_1"] == 'X')
					{
						$saleorder = '1';
					}
                    $valid = "1";
                }
                else{
                    $request->session()->flash("error_msg", $checklogin['STATUS']);
                 return redirect()->back();
                }
                
                if($valid == "0"){
                    $request->session()->flash("error_msg", "Sorry! <b>Username and Password Does not Match</b>!");
                 return redirect()->back();
                }
                    
                 
                
                
                if($this->runemployeeprocess($employeeid , $valid, $request,$saleorder) == 'ok'){
                    
                     $check = DB::connection('mysql6')->table('employee')->where(['id' => $request->username ])->get();
                   
                        
                        $toencrypt = $employeeid.'-#Vgn@M@ain`encRyption89';
                        $encrypt = Crypt::encrypt($toencrypt);

                        $getactiveemployees = $this->getallactiveemployees();
                        $valid_rm = 0;
                        $innotice_period = 0;
                        $in_contract = 0;
                        $issecurity = 0;
                        if (count($getactiveemployees) > 0) {
                            $i=0;
                            foreach ($getactiveemployees['Details'] as $key => $value) {
                                
                                if($value['RM_ID'] == $employeeid){
                                    $valid_rm = 1;
                                }
                                if ($value['Emp_ID'] == $employeeid) {
                                    if($value['OnNotice'] == 'N'){
                                        $innotice_period = 1;
                                    }
                                    if($value['OnContract'] == 'C'){
                                        $in_contract = 1;
                                    }
                                    if(($value['Role_Code'] == 'SCT_TM(PLANT)') || ($value['Role_Code'] == 'SCT_TM(REG)')){
                                        $issecurity = 1;
                                    }
                                }
                                
                            }    
                        }



                $this->checkandinsertrecordsin_ticketdb($employeeid,$request->password);
 
                  $request->session()->put('employeesession', $encrypt);
                 $request->session()->put('is_report_manager', $valid_rm);
                 $request->session()->put('is_notice_period', $innotice_period);
                 $request->session()->put('is_contract', $in_contract);
                 $request->session()->put('is_security', $issecurity);
                 return redirect()->route('newemployee_dashboard',['empid' => $employeeid]);
                        
                    
                    
                }
                else{
                   
                     $request->session()->flash("error_msg", "Sorry! <b>Username and Password Does not Match</b>!");
                 return redirect()->back();
                }
           
        }

        elseif ($loginmode == 'loginmode_emailid') {

            if (!filter_var($request->username, FILTER_VALIDATE_EMAIL)) {
            $request->session()->flash("error_msg", "Sorry! Enter a valid Email Id");
                return redirect()->back()->withInput();
                }
            $check = DB::connection('mysql6')->table('employee')->where(['officialmail' => $request->username ])->get();
            
            if(count($check) > 0){
                foreach($check as $getcheck){
                    $employeeid = $getcheck->id;
                }
            }
            else
            {
                $request->session()->flash("error_msg", "Sorry! <b>Username and Password Does not Match. </b>!");
                return redirect()->back();
            }
            
            $checklogin = $this->checkLogin($employeeid, $request->password);
               $valid = "0"; 
                if($checklogin['STATUS'] == 'Login Failed'){
                    $valid = "0";
                }
                if($checklogin['STATUS'] == 'Login Success'){

                	$check_cred = DB::connection('mysql6')->table('employee_credentials')->where('id','=',$employeeid)->count();
                   if ($check_cred > 0) {
                   	DB::connection('mysql6')->table('employee_credentials')->where('id','=',$employeeid)->update([
                   		'password' => Hash::make($request->password, ['rounds' => 12]),
                   		'lastloginned_datetime' => Carbon::now()->toDateTimeString(),
                   		'is_loggined' => 1
                   	]);
                   }
                   else{
                   	DB::connection('mysql6')->table('employee_credentials')->insert([
                   		'id' => $employeeid,
                   		'password' => Hash::make($request->password, ['rounds' => 12]),
                   		'lastloginned_datetime' => Carbon::now()->toDateTimeString(),
                   		'is_loggined' => 1
                   	]);
                   }

                    if($checklogin["STATUS_1"] == ''){
									$saleorder = '0';
							}
                    if($checklogin["STATUS_1"] == 'X')
					{
						$saleorder = '1';
					}
                    $valid = "1";
                }
                
                if($valid == "0"){
                    $request->session()->flash("error_msg", "Sorry! <b>Username and Password Does not Match</b>!");
                 return redirect()->back();
                }
            
            if($this->runemployeeprocess($employeeid , $valid, $request,$saleorder) == 'ok'){
                    
                     $check = DB::connection('mysql6')->table('employee')->where(['id' => $request->username ])->get();
                   
                        
                        $toencrypt = $employeeid.'-#Vgn@M@ain`encRyption89';
                        $encrypt = Crypt::encrypt($toencrypt);
                 
                 $getactiveemployees = $this->getallactiveemployees();
                        $valid_rm = 0;
                        $innotice_period = 0;
                        $in_contract = 0;
                        $issecurity = 0;
                        if (count($getactiveemployees) > 0) {
                            $i=0;
                            foreach ($getactiveemployees['Details'] as $key => $value) {
                                
                                if($value['RM_ID'] == $employeeid){
                                    $valid_rm = 1;
                                }
                                if ($value['Emp_ID'] == $employeeid) {
                                    if($value['OnNotice'] == 'N'){
                                        $innotice_period = 1;
                                    }
                                    if($value['OnContract'] == 'C'){
                                        $in_contract = 1;
                                    }
                                    if(($value['Role_Code'] == 'SCT_TM(PLANT)') || ($value['Role_Code'] == 'SCT_TM(REG)')){
                                        $issecurity = 1;
                                    }
                                }
                                
                            }    
                        }



                      
                $this->checkandinsertrecordsin_ticketdb($employeeid,$request->password);
 
                  $request->session()->put('employeesession', $encrypt);
                 $request->session()->put('is_report_manager', $valid_rm);
                 $request->session()->put('is_notice_period', $innotice_period);
                 $request->session()->put('is_contract', $in_contract);
                 $request->session()->put('is_security', $issecurity);
                 return redirect()->route('newemployee_dashboard',['empid' => $employeeid]);
                        
                    
                    
                }
                else{
                   
                     $request->session()->flash("error_msg", "Sorry! <b>Username and Password Does not Match</b>!");
                 return redirect()->back();
                }
            
            
        }
        
        elseif ($loginmode == 'loginmode_mobileno') {

            if (!preg_match('/^[0-9]{10}+$/', $request->username)) {
                $request->session()->flash("error_msg", "Sorry! Enter a valid Mobile Number");
                return redirect()->back()->withInput();
                }
            
            $check = DB::connection('mysql6')->table('employee')->where(['personal_mobile' => $request->username ])->get();
            
            if(count($check) > 0){
                foreach($check as $getcheck){
                    $employeeid = $getcheck->id;
                }
            }
            else
            {
                $request->session()->flash("error_msg", "Sorry! <b>Username and Password Does not Match. </b>!");
                return redirect()->back();
            }
            
            $checklogin = $this->checkLogin($employeeid, $request->password);
                
                if($checklogin['STATUS'] == 'Login Failed'){
                    $valid = "0";
                }

                if($checklogin['STATUS'] == 'Login Success'){

                	$check_cred = DB::connection('mysql6')->table('employee_credentials')->where('id','=',$employeeid)->count();
                   if ($check_cred > 0) {
                   	DB::connection('mysql6')->table('employee_credentials')->where('id','=',$employeeid)->update([
                   		'password' => Hash::make($request->password, ['rounds' => 12]),
                   		'lastloginned_datetime' => Carbon::now()->toDateTimeString(),
                   		'is_loggined' => 1
                   	]);
                   }
                   else{
                   	DB::connection('mysql6')->table('employee_credentials')->insert([
                   		'id' => $employeeid,
                   		'password' => Hash::make($request->password, ['rounds' => 12]),
                   		'lastloginned_datetime' => Carbon::now()->toDateTimeString(),
                   		'is_loggined' => 1
                   	]);
                   }

                    if($checklogin["STATUS_1"] == ''){
									$saleorder = '0';
							}
                    if($checklogin["STATUS_1"] == 'X')
					{
						$saleorder = '1';
					}
                    $valid = "1";
                }
                
                if($valid == "0"){
                    $request->session()->flash("error_msg", "Sorry! <b>Username and Password Does not Match</b>!");
                 return redirect()->back();
                }
                
            if($this->runemployeeprocess($employeeid , $valid, $request,$saleorder) == 'ok'){
                    
                     $check = DB::connection('mysql6')->table('employee')->where(['id' => $request->username ])->get();
                   
                        
                        $toencrypt = $employeeid.'-#Vgn@M@ain`encRyption89';
                        $encrypt = Crypt::encrypt($toencrypt);
                 
                 $getactiveemployees = $this->getallactiveemployees();
                        $valid_rm = 0;
                        $innotice_period = 0;
                        $in_contract = 0;
                        $issecurity = 0;
                        if (count($getactiveemployees) > 0) {
                            $i=0;
                            foreach ($getactiveemployees['Details'] as $key => $value) {
                                
                                if($value['RM_ID'] == $employeeid){
                                    $valid_rm = 1;
                                }
                                if ($value['Emp_ID'] == $employeeid) {
                                    if($value['OnNotice'] == 'N'){
                                        $innotice_period = 1;
                                    }
                                    if($value['OnContract'] == 'C'){
                                        $in_contract = 1;
                                    }
                                    if(($value['Role_Code'] == 'SCT_TM(PLANT)') || ($value['Role_Code'] == 'SCT_TM(REG)')){
                                        $issecurity = 1;
                                    }
                                }
                                
                            }    
                        }

                $this->checkandinsertrecordsin_ticketdb($employeeid,$request->password); 
                  $request->session()->put('employeesession', $encrypt);
                 $request->session()->put('is_report_manager', $valid_rm);
                 $request->session()->put('is_notice_period', $innotice_period);
                 $request->session()->put('is_contract', $in_contract);
                 $request->session()->put('is_security', $issecurity);
                 return redirect()->route('newemployee_dashboard',['empid' => $employeeid]);
                        
                    
                    
                }
                else{
                   
                     $request->session()->flash("error_msg", "Sorry! <b>Username and Password Does not Match</b>!");
                 return redirect()->back();
                }
            
        }
        else{
                $request->session()->flash("error_msg", "Sorry! Enter a valid Username and Password!");
                return redirect()->back()->withInput();
        }
        
    }

  public function checkandinsertrecordsin_ticketdb($employeeid,$password)
    {
        $hashedpassword = Hash::make($password, ['rounds' => 12]);
	//dd($hashedpassword);
        $getemployee = DB::connection('mysql6')->table('employee')->where(['id' => $employeeid])->get();
	$officialmail = '';
        if (!empty($getemployee)) {
            foreach ($getemployee as $key => $value) {
                $officialmail = $value->officialmail;
                $ticket_username = $value->name;
            }
		Log::info('Official mail :'.$officialmail);
            if ($officialmail != '') {
                if (filter_var($officialmail, FILTER_VALIDATE_EMAIL)) {
                    $checkstaffemailexist = DB::connection('mysql7')->table('ost_staff')->where(['email' => $officialmail])->count();
                    if ($checkstaffemailexist == 0) {
                       $checkuseremailexist = DB::connection('mysql7')->table('ost_user_email')->where(['address' => $officialmail])->count();
                        if ($checkuseremailexist == 0) {
                            $inserteduserid = DB::connection('mysql7')->table('ost_user')->insertGetId([
                                'id' => null,
                                'org_id' => 0,
                                'default_email_id' => 0,
                                'status' => 0,
                                'name' => $ticket_username,
                                'created' => Carbon::now()->toDateTimeString(),
                                'updated' => Carbon::now()->toDateTimeString()
                        ]);
                            DB::connection('mysql7')->table('ost_user')->where(['id' => $inserteduserid])->update(['default_email_id' => $inserteduserid ]);
                            DB::connection('mysql7')->table('ost_user__cdata')->insert([
                                'user_id' => $inserteduserid,
                                'email' => null,
                                'name' => null,
                                'phone' => null,
                                'notes' => null
                            ]);
                            DB::connection('mysql7')->table('ost_user_account')->insert([
                                'id' => null,
                                'user_id' => $inserteduserid,
                                'status' => 9,
                                'timezone' => 'Asia/Kolkata',
                                'lang' => null,
                                'username' => null,
                                'passwd' => $hashedpassword,
                                'backend' => 'client',
                                'extra' => '{"browser_lang":"en_US"}',
                                'registered' => Carbon::now()->toDateTimeString()
                            ]);
                            DB::connection('mysql7')->table('ost_user_email')->insert([
                                'id' => null,
                                'user_id' => $inserteduserid,
                                'flags' => 0,
                                'address' => $officialmail
                            ]);
                            return 1;

                        }

                        if ($checkuseremailexist == 1) {
                           $getuserid =  DB::connection('mysql7')->table('ost_user_email')->where(['address' => $officialmail])->get();
                           foreach ($getuserid as $keyv2 => $valuev2) {
                               $userid = $valuev2->user_id;
                           }
                           DB::connection('mysql7')->table('ost_user_account')->where(['user_id' => $userid])->update(['passwd' => $hashedpassword]);
                            return 1;
                        }
                    }
                    if ($checkstaffemailexist == 1) {
                        DB::connection('mysql7')->table('ost_staff')->where(['email' => $officialmail])->update(['passwd' => $hashedpassword]);
                        return 1;
                    }
                }
                else{
                    return 1;
                }
            }
            else{
                return 1;
            }

            
        }
    } 
    
    
    
     public function newdashboard(Request $request, $empid)
    {
       
        if ($request->session()->has('employeesession')) {
        
            $encrypt = $request->session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $employeeid = $split[0];
            if ($empid != $employeeid) {
                return $this->newlogout($request);
            }

            $pwd_status = $this->is_emp_didnt_passwordchanged($employeeid);
            if ($pwd_status == 0) {
                $request->session()->flash("error_msg", 'Please change the default password. Only if you Change the default password , other functionalities on this portal will work. This is done for security purposes. Please do not share your password with anyone');
                return redirect()->route('newemployee_mydetails_passchange');
            }

              $technicalnmr = ['100312','100313','100515','100517',
'100518',
'100519',
'100520',
'100546',
'100547',
'100549',
'100550',
'100566',
'100567',
'100580',
'100581',
'100596',
'100597',
'100599',
'100615',
'100616',
'100629',
'100647',
'100648',
'100652',
'100657',
'100670',
'100675',
'100676',
'100687',
'100692',
'100693',
'100695',
'100696',
'100697',
'100698',
'100702',
'100703',
'100720',
'100721',
'100723',
'100725',
'100726',
'100728',
'100734',
'100735',
'100736',
'100737',
'100743',
'100745',
'100746',
'100748',
'100749',
'100750',
'100751',
'100752',
'100753',
'200639',
'200663',
'200669',
'200696',
'200720',
'200736',
'200750',
'200807',
'200812',
'200895',
'200899',
'200921',
'200922',
'200924',
'200947',
'200949',
'200999',
'201017',
'201020',
'201021',
'201049',
'201050',
'201064',
'201066',
'201067',
'201080',
'201081',
'201099',
'201117',
'201119',
'201122',
'201132',
'201134',
'201142',
'201144',
'201147',
'201149',
'201159',
'201166',
'201178',
'201179',
'201180',
'201185',
'201186',
'201187'
];
                        if (in_array($employeeid, $technicalnmr)) {
							return $this->newlogout();
						}


                        $current_day_month = Carbon::now()->format('m-d');
//$getactiveemployees = $this->getallactiveemployees();
$getactiveemployees = DB::connection('mysql6')->table('active_emp')->get();
			

$birthday_employees = [];
$doj_employees = [];
foreach ($getactiveemployees as $key11 => $value11) {
	
	if(!empty($value11->Birth_Date)){
    if (substr($value11->Birth_Date, 5,5) == $current_day_month) {
	if($value11->Emp_Id != '200040'){
        $birthday_employees[] = $value11;
	}
    }
    }

	if(!empty($value11->DOJ)){
    if (substr($value11->DOJ, 5,5) == $current_day_month) {
        $doj_employees[$key11] = $value11;
        
        $doj_employees[$key11]->differeinyears = Carbon::now()->diffInYears(Carbon::parse($value11->DOJ));
    }
   }
}
			
			

            $getemployeedata = DB::connection('mysql6')->table('employee')->where('id', '=', $employeeid)->get();
            
            $getdashboard = DB::connection('mysql6')->table('dashboard')->where('employee_id', '=', $employeeid)->get();
            
             $listfiles = Storage::disk('s3')->files("/newcustomerzoneassets/employeeprofileimage/".$employeeid);             
             if(count($listfiles) > 0){
                $profilepic = config('app.AWS_URL')."/".$listfiles[0];
            }
             else
             {
                $profilepic = config('app.AWS_URL')."/newcustomerzoneassets/img/dummy_male.png";
             }
            
            return view('newemployeezone.dashboard')->with(['getdashboard'=>$getdashboard,'experience' => $doj_employees,'getbirthday_employees'=>$birthday_employees ,'getemployeedata'=>$getemployeedata, 'profilepic' => $profilepic]);
        }
        else{
            return redirect()->route('newemployee_home');
        }
            
        
    }
    
    public function newmydetails(Request $request)
    {
        
        if ($request->session()->has('employeesession')) {
            $encrypt = $request->session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $employeeid = $split[0];
            $getemployeedata = DB::connection('mysql6')->table('employee')->where('id', '=', $employeeid)->get();
            $getemployeeaddress = DB::connection('mysql6')->table('address')->where('employee_id', '=', $employeeid)->get();
             $getemployeeeducation = DB::connection('mysql6')->table('education')->where('employee_id', '=', $employeeid)->get();

             $pwd_status = $this->is_emp_didnt_passwordchanged($employeeid);
            if ($pwd_status == 0) {
                $request->session()->flash("error_msg", 'Please change the default password. Only if you Change the default password , other functionalities on this portal will work. This is done for security purposes. Please do not share your password with anyone');
                return redirect()->route('newemployee_mydetails_passchange');
            }
            
            //$sapdata = $this->getemployee($employeeid);
            //dd($sapdata);
            $getemployeeexperience = DB::connection('mysql6')->table('experience')->where('employee_id', '=', $employeeid)->get();
            
            
             $listfiles = Storage::disk('s3')->files("/newcustomerzoneassets/employeeprofileimage/".$employeeid);             
             if(count($listfiles) > 0){
                $profilepic = config('app.AWS_URL')."/".$listfiles[0];
            }
             else
             {
                $profilepic = config('app.AWS_URL')."/newcustomerzoneassets/img/dummy_male.png";
             }
            
            return view('newemployeezone.mydetails')
                ->with(['getemployeedata'=>$getemployeedata,
                                        'getemployeeaddress'=>$getemployeeaddress,
                                        'getemployeeeducation'=>$getemployeeeducation,
                                        'getemployeeexperience'=>$getemployeeexperience,
                                        'profilepic' => $profilepic]);
        }
        else{
            return redirect()->route('newemployee_home');
        }
            
        
    }
    
    public function newchangemydetails(Request $request)
    {
        if ($request->session()->has('employeesession')) {
            $encrypt = $request->session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $employeeid = $split[0];
            $getemployeedata = DB::connection('mysql6')->table('employee')->where('id', '=', $employeeid)->get();
            $getemployeeaddress = DB::connection('mysql6')->table('address')->where(['employee_id' => $employeeid, 'address_type' => 'T'])->get();

            $pwd_status = $this->is_emp_didnt_passwordchanged($employeeid);
            if ($pwd_status == 0) {
                $request->session()->flash("error_msg", 'Please change the default password. Only if you Change the default password , other functionalities on this portal will work. This is done for security purposes. Please do not share your password with anyone');
                return redirect()->route('newemployee_mydetails_passchange');
            }
            
             $listfiles = Storage::disk('s3')->files("/newcustomerzoneassets/employeeprofileimage/".$employeeid);             
             if(count($listfiles) > 0){
                $profilepic = config('app.AWS_URL')."/".$listfiles[0];
            }
             else
             {
                $profilepic = config('app.AWS_URL')."/newcustomerzoneassets/img/dummy_male.png";
             }
            
            return view('newemployeezone.changemydetails')->with(['getemployeedata'=>$getemployeedata,
                    'getemployeeaddress'=>$getemployeeaddress,
                    'profilepic' => $profilepic]);
        }
        else{
            return redirect()->route('newemployee_home');
        }
        
    }
    
    public function newpostchangemydetails(Request $request)
    {
        if ($request->session()->has('employeesession')) {
            $encrypt = $request->session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $employeeid = $split[0];
            $getemployeedata = DB::connection('mysql6')->table('employee')->where('id', '=', $employeeid)->get();
            
             $validate = $this->validate($request, [
			'addr2' => 'required|max:60',
            'houseno' => 'required|max:60',
            'city' => 'required',
            'country' => 'required',
            'pincode' => 'required',
            'mobile' => 'required|digits:10',
            'personalmail' => 'required|email',
			]);
            
            
            
            $updateinsap = $this->updateemployeedetails($employeeid, $request->houseno,$request->addr2,$request->pincode,$request->city,$request->country,$request->mobile,$request->personalmail);
            
            if($updateinsap['STATUS_COMMAND'] == 'Data Updated'){
            DB::connection('mysql6')->table('address')
                ->where('employee_id', '=', $employeeid)
                ->where('address_type', '=', 'T')
                ->update(['street_house_no' => $request->houseno,
            'street_house_no1' => $request->addr2,
            'postal_code' => $request->pincode,
            'city' => $request->city,
            'country' => $request->country ]);
            
             DB::connection('mysql6')->table('employee')
                ->where('id', '=', $employeeid)
                ->update(['personalmail' => $request->personalmail,
            'personal_mobile' => $request->mobile ]);
            
            DB::connection('mysql6')->table('dashboard')
                ->where('employee_id', '=', $employeeid)
                ->update(['last_details_changed' => date('Y-m-d') ]);
            
            
            
            $request->session()->flash("suc_msg", "successfully Profile has been updated!");
            return redirect()->back();
            }
            else
            {
                $request->session()->flash("error_msg", "Profile updation failed. Try again!");
            return redirect()->back();
            }


        }
        else{
            return redirect()->route('newemployee_home');
        }
        
    }
    
    public function newmydetails_passchange(Request $request)
    {
        
        if ($request->session()->has('employeesession')) {
            $encrypt = $request->session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $employeeid = $split[0];
            $getemployeedata = DB::connection('mysql6')->table('employee')->where('id', '=', $employeeid)->get();


            
             $listfiles = Storage::disk('s3')->files("/newcustomerzoneassets/employeeprofileimage/".$employeeid);             
             if(count($listfiles) > 0){
                $profilepic = config('app.AWS_URL')."/".$listfiles[0];
            }
             else
             {
                $profilepic = config('app.AWS_URL')."/newcustomerzoneassets/img/dummy_male.png";
             }
            
            return view('newemployeezone.mydetails_changepass')->with(['getemployeedata'=>$getemployeedata, 'profilepic' => $profilepic]);
        }
        else{
            return redirect()->route('newemployee_home');
        }
            
        
    }
    
     public function newpasswordchange(Request $request) {

        if ($request->session()->has('employeesession')) {
            $encrypt = $request->session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $employeeid = $split[0];
            $getemployeedata = DB::connection('mysql6')->table('employee')->where('id', '=', $employeeid)->get();
            
       
        $validate = $this->validate($request, [
            'oldpasword' => 'required',
			'newpass' => 'required|min:6|max:12',
            'retypepass' => 'required|same:newpass'
			]);


   $getoldpwdcheck = DB::connection('mysql6')->table('employee_credentials')->where('id','=',$employeeid)->get();
   foreach ($getoldpwdcheck as $key12 => $value12) {
       $hashedoldpwd = $value12->password;
   }


        if (Hash::check($request->newpass, $hashedoldpwd) === true) {
                $request->session()->flash("error_msg", "The New password cannot be same as old password!");
            return redirect()->back();
            }
            
            $updatepassword = $this->changesappassword($employeeid,$request->oldpasword,$request->newpass);
            
            
        if ($updatepassword['Status_Command'] == 'Password Changed') {
            
            DB::connection('mysql6')->table('dashboard')->where('employee_id', '=', $employeeid)->update(['last_password_changed' => date('Y-m-d')]);
            $request->session()->flash("suc_msg", "Successfully New Password has been updated!");
            return redirect()->back();
            
        }
        else
        {
          $request->session()->flash("error_msg", $updatepassword['Status_Command']);
            return redirect()->back();
        }

         }
        else{
            return redirect()->route('newemployee_home');
        }
        


    }
    
    public function noticeboard(Request $request){
        
        if ($request->session()->has('employeesession')) {
            $encrypt = $request->session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $employeeid = $split[0];
            $getemployeedata = DB::connection('mysql6')->table('employee')->where('id', '=', $employeeid)->get();

            $pwd_status = $this->is_emp_didnt_passwordchanged($employeeid);
            if ($pwd_status == 0) {
                $request->session()->flash("error_msg", 'Please change the default password. Only if you Change the default password , other functionalities on this portal will work. This is done for security purposes. Please do not share your password with anyone');
                return redirect()->route('newemployee_mydetails_passchange');
            }
            
             $listfiles = Storage::disk('s3')->files("/newcustomerzoneassets/employeeprofileimage/".$employeeid);             
             if(count($listfiles) > 0){
                $profilepic = config('app.AWS_URL')."/".$listfiles[0];
            }
             else
             {
                $profilepic = config('app.AWS_URL')."/newcustomerzoneassets/img/dummy_male.png";
             }
            foreach($getemployeedata as $notice){
                $plantcode = $notice->plantid;
            }
            //dd($plantcode);
            $getnoticeboard = $this->getnoticeboard($plantcode);
            
            if(!empty($getnoticeboard))
            {
                
                if(array_key_exists('0',$getnoticeboard['NOTICE_BOARD'])){
                    $notice_data = $getnoticeboard['NOTICE_BOARD'];
                }
                else
                {
                    $notice_data[0] = $getnoticeboard['NOTICE_BOARD'];
                }
            }
            else
            {
                $notice_data = [];
            }
            
            //dd($notice_data);
            
            return view('newemployeezone.noticeboard')->with(['getemployeedata'=>$getemployeedata,'notice_data'=>$notice_data, 'profilepic' => $profilepic]);
        }
        else{
            return redirect()->route('newemployee_home');
        }
        
        
    }
    
    
    public function newempcomplaints(Request $request)
    {
        if ($request->session()->has('employeesession')) {
            $encrypt = $request->session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $employeeid = $split[0];
            $getemployeedata = DB::connection('mysql6')->table('employee')->where('id', '=', $employeeid)->get();
            $getcomplaints = DB::connection('mysql6')->table('complaints')->where('employee_id', '=', $employeeid)->orderBy('complaint_date', 'desc')->get();

            $pwd_status = $this->is_emp_didnt_passwordchanged($employeeid);
            if ($pwd_status == 0) {
                $request->session()->flash("error_msg", 'Please change the default password. Only if you Change the default password , other functionalities on this portal will work. This is done for security purposes. Please do not share your password with anyone');
                return redirect()->route('newemployee_mydetails_passchange');
            }

             $listfiles = Storage::disk('s3')->files("/newcustomerzoneassets/employeeprofileimage/".$employeeid);             
             if(count($listfiles) > 0){
                $profilepic = config('app.AWS_URL')."/".$listfiles[0];
            }
             else
             {
                $profilepic = config('app.AWS_URL')."/newcustomerzoneassets/img/dummy_male.png";
             }
            
            return view('newemployeezone.complaints')->with(['getemployeedata' => $getemployeedata, 'getcomplaints'=> $getcomplaints, 'profilepic' => $profilepic]);
        }
        else{
            return redirect()->route('newemployee_home');
        }
    }
    
     public function newraisecomplaints(Request $request)
    {
        if ($request->session()->has('employeesession')) {
            $encrypt = $request->session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $employeeid = $split[0];
            $getemployeedata = DB::connection('mysql6')->table('employee')->where('id', '=', $employeeid)->get();

            $pwd_status = $this->is_emp_didnt_passwordchanged($employeeid);
            if ($pwd_status == 0) {
                $request->session()->flash("error_msg", 'Please change the default password. Only if you Change the default password , other functionalities on this portal will work. This is done for security purposes. Please do not share your password with anyone');
                return redirect()->route('newemployee_mydetails_passchange');
            }
            
            $result = $this->getemployee($employeeid);
                    
            $newarray = array();           
            $getnoc = $result['Nature_Of_Comp'];
				
			
          foreach($getnoc as $noc){
            
              $newarray[] = $noc;
          }
		
            
            if(empty($getnoc)){
                return redirect()->route('newempcomplaints');
            }
            
           
            
            
             $listfiles = Storage::disk('s3')->files("/newcustomerzoneassets/employeeprofileimage/".$employeeid);             
             if(count($listfiles) > 0){
                $profilepic = config('app.AWS_URL')."/".$listfiles[0];
            }
             else
             {
                $profilepic = config('app.AWS_URL')."/newcustomerzoneassets/img/dummy_male.png";
             }
            
            return view('newemployeezone.raisecomplaints')->with(['getemployeedata'=> $getemployeedata, 'getnoc'=> $newarray, 'profilepic' => $profilepic]);
        }
        else{
            return redirect()->route('newemployee_home');
        }
    }
    
    
    public function newpostraisecomplaints(Request $request)
    {        
        if ($request->session()->has('employeesession')) {
            $encrypt = $request->session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $employeeid = $split[0];
            $getemployeedata = DB::connection('mysql6')->table('employee')->where('id', '=', $employeeid)->get();
            
            /*$getproject = DB::connection('mysql3')->table('projects')->where('cust_id', '=', $customerid)->get();*/

            foreach($getemployeedata as $empdata){
                $plantcode = $empdata->plantid;
            }
                

             $validate = $this->validate($request, [
            'complaintnature' => 'required',
            'desccomp' => 'required|max:900'
			]);
            
            if ($request->desccomp != '') {
                
            
            $now = Carbon::now();
        $SavecustomertoSAP = $this->savecomplaint($employeeid,$plantcode, $request->complaintnature,$request->desccomp );
              
                
            
            DB::connection('mysql6')->table('complaints')->insert([
            'employee_id' => $employeeid,
            'complaint_no' => $SavecustomertoSAP['Complaint_No'],
            'complaint_date' => date('Y-m-d'),
            'nature_of_complaint' => $request->complaintnature,
            'description' => $request->desccomp,
            'hrcare_name' => '',
            'hr_status' => 'OPEN',
            'emp_status' => 'OPEN' ]);
                
            
                $sapdata = $this->getemployee($employeeid);
                
                 $sap_compl = array();
                    if (array_key_exists('My_Complaints', $sapdata)) {
                    
                    $sapcomplaints = $sapdata['My_Complaints'];
                    if (array_key_exists('0', $sapcomplaints)) {
                        $sap_compl = $sapcomplaints;
                    }
                    else
                    {
                        $sap_compl[0] = $sapcomplaints;
                    }
                
                 foreach ($sap_compl as $sapcomplkey => $sapcomplvalue) {
                    if ($SavecustomertoSAP['Complaint_No'] == $sapcomplvalue['Complaint_No']) {
                                
                                DB::connection('mysql6')->table('complaints')->where('employee_id', '=', $employeeid)
                                ->where('complaint_no','=',$sapcomplvalue['Complaint_No'])
                                ->update(['hrcare_name' => $sapcomplvalue['HR_Name']
                                 ]);
                            }
                           

                            
                            
                        }
                    }
                
            $request->session()->flash("suc_msg", "Complaint Registered Successfully! Your Complaint ID is: ".$SavecustomertoSAP['Complaint_No']);


            return redirect()->back();

            }
            else
            {
                $request->session()->flash("error_msg", "Sorry,Complaint not raised try again!");
                return redirect()->back();
            }
        }
        else{
            return redirect()->route('newemployee_home');
        }
    }
    
    public function newclosecomplaints(Request $request)
    {
        if ($request->session()->has('employeesession')) {
            $encrypt = $request->session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $employeeid = $split[0];
            $getemployeedata = DB::connection('mysql6')->table('employee')->where('id', '=', $employeeid)->get();

            $validate = $this->validate($request, [
            'close' => 'required'
			]);

            $now = Carbon::now();
            $checkcomplaint = DB::connection('mysql6')->table('complaints')->where('employee_id', '=', $employeeid)->where('complaint_no', '=', $request->close)->where('emp_status', '=', 'OPEN')->count();
            
            if ($checkcomplaint == 1) {

               $Closecustomercomplaint = $this->closecomplaint($employeeid, $request->close); 
                
               if ($Closecustomercomplaint['Status_Note']=="CLOSED") {
                   DB::connection('mysql6')->table('complaints')->where('employee_id','=', $employeeid)->where('complaint_no','=',$request->close)->update(['emp_status' => 'CLOSE']);
                   $request->session()->flash("suc_msg", "Complaint no ".$request->close." Closed Successfully!");
                   return redirect()->back();
               }
                
            }
            else{
                 $request->session()->flash("suc_msg", "Complaint no ".$request->close." Closed Already!");
                return redirect()->back();
            }

            
            
        }
        else{
            return redirect()->route('newemployee_home');
        }
        
    }
    
    public function formatdate($string){
        if(!empty($string)){
        return substr($string,0,4).'-'.substr($string,4,2).'-'.substr($string,6,2);
        }
        else
        {
            return null;
        }
    }
    public function formattime($string){
        if(!empty($string)){
        return substr($string,0,2).':'.substr($string,2,2).':'.substr($string,4,2);
        }else
        {
            return null;
        }
    }
    
    public function newmyattendance(Request $request){
        
         if ($request->session()->has('employeesession')) {
            $encrypt = $request->session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $employeeid = $split[0];
            $getemployeedata = DB::connection('mysql6')->table('employee')->where('id', '=', $employeeid)->get();

            $pwd_status = $this->is_emp_didnt_passwordchanged($employeeid);
            if ($pwd_status == 0) {
                $request->session()->flash("error_msg", 'Please change the default password. Only if you Change the default password , other functionalities on this portal will work. This is done for security purposes. Please do not share your password with anyone');
                return redirect()->route('newemployee_mydetails_passchange');
            }
             
             $month = date('F');
             $year = date('Y');
             //dd($month.' '.$year);
              foreach ($getemployeedata as $ckey => $cvalue) {
                 $cadre = $cvalue->cadre;
                 $shift_name = $cvalue->shift_name;
             }
             
             $dt = new \DateTime("last day of $month $year"); // <== instance from another API
             $bt = new \DateTime("second sat of $month $year");
$carbon = Carbon::instance($dt);                          // 'Carbon\Carbon'
$btcarbon = Carbon::instance($bt);                          // 'Carbon\Carbon'
$test = $carbon->toDateTimeString(); 
$secondtest = $btcarbon->toDateString(); 
             
             $datearray = array();
             $newarray = array();
             $getattendance = $this->attendance($employeeid, $month, $year);
             //dd($getattendance);
             $getholiday = $this->holiday($employeeid, $year);
            // dd($getholiday);
             
             if(!empty($getattendance)){
                 $newarray = $getattendance['Attend_Details'];
             }
             
             $date = Carbon::parse($test);
             
             for($i = 1; $i <= $date->day; $i++){
                 $year = $date->year;
                 $month = $date->month;
                 
                 $createddate = Carbon::createFromDate($year, $month, $i, 'Asia/Kolkata');
                 $j = $i-1;
                 
                 $datearray[$j]['created_date'] = $createddate->format('d, F Y');
                 $datearray[$j]['dayname'] = $createddate->format('l');
                 $datearray[$j]['attendancedate'] = $createddate->format('Y-m-d');
                 
                 
                $datearray[$j]['shift_name'] = '';
                $datearray[$j]['shift_start'] = '';
                $datearray[$j]['shift_end'] = '';
                $datearray[$j]['punch_in'] = '';
                $datearray[$j]['punch_out'] = '';
                $datearray[$j]['second_saturday'] = false;
                $datearray[$j]['is_punchin_deviate'] = false;
                $datearray[$j]['is_punchout_deviate'] = false;
                    if($createddate->format('l') == 'Sunday'){
                 $datearray[$j]['is_sunday'] = true;
                 }else
                 {
                    $datearray[$j]['is_sunday'] = false;
                 }
                 
                 $datearray[$j]['holiday_name'] = '';
                 $datearray[$j]['holiday_count'] = '';
                 
                 
                 
                 if($secondtest == $createddate->toDateString()){
                                 $datearray[$j]['second_saturday'] = true;
                             }
                 
                 
                 if(!empty($newarray)){
                 	//dd($newarray);
                 	$checknewarray =array();
                 	if (array_key_exists('0', $newarray)) {
                 		$checknewarray = $newarray;
                 	}else{
                 		$checknewarray[0] = $newarray;
                 	}
                     foreach($checknewarray as $saparray){
                         $sapformattedarrayval = $this->formatdate($saparray['Date']);

                         if($createddate->toDateString() == $sapformattedarrayval){
                             $datearray[$j]['shift_name'] = $saparray['Shift_Name'];
                             $datearray[$j]['shift_start'] = $this->formattime($saparray['Shift_Start']);

                             $formatedsttime = Carbon::parse($this->formattime($saparray['Shift_Start']));
                            if (($shift_name == 'VGN HO GENERAL SHIFT')&&($secondtest == $createddate->toDateString())) {
                                $saparray['Shift_End'] = '133000';
                            }
                             $formatedettime = Carbon::parse($this->formattime($saparray['Shift_End']));
                            
                            $formatedpunch = Carbon::parse($this->formattime($saparray['Punch_IN']));

                            $formatedpunchout = Carbon::parse($this->formattime($saparray['Punch_OUT']));
                    $graceadded = Carbon::create($formatedpunch->year, $formatedpunch->month, $formatedpunch->day,$formatedsttime->hour, $formatedsttime->minute, $formatedsttime->second);
                    $endformatedtime = Carbon::create($formatedpunch->year, $formatedpunch->month, $formatedpunch->day,$formatedettime->hour, $formatedettime->minute, $formatedettime->second);
                    if ($cadre == 'M') {
                        $finalgraceadded = $graceadded->addMinutes(31);
                    }
                    elseif ($cadre == 'O') {
                        $finalgraceadded = $graceadded->addMinutes(16);
                    }
                    else{
                    $finalgraceadded = $graceadded->addMinutes(16);    
                    }
                    

                    $punchin_greater = $formatedpunch->gt($finalgraceadded);
                    $punchin_lesser = $formatedpunchout->lt($endformatedtime);

                             $datearray[$j]['shift_end'] = $this->formattime($saparray['Shift_End']);
                             $datearray[$j]['punch_in'] = $this->formattime($saparray['Punch_IN']);
                             $datearray[$j]['punch_out'] = $this->formattime($saparray['Punch_OUT']);
                             $datearray[$j]['is_punchin_deviate'] = $punchin_greater;
                             $datearray[$j]['is_punchout_deviate'] = $punchin_lesser;
                             
                         }
                     }
                 }
                 
                 foreach($getholiday['CALENDAR'] as $holiday){
                     
                     if($createddate->toDateString() == $this->formatdate($holiday['Date'])){
                         
                         $datearray[$j]['holiday_name'] = $holiday['Holidays'];
                         $datearray[$j]['holiday_count'] = $holiday['No_of_Days'];
                     }
                 }
                 
                 
             }

                    
             
             
             $listfiles = Storage::disk('s3')->files("/newcustomerzoneassets/employeeprofileimage/".$employeeid);             
             if(count($listfiles) > 0){
                $profilepic = config('app.AWS_URL')."/".$listfiles[0];
            }
             else
             {
                $profilepic = config('app.AWS_URL')."/newcustomerzoneassets/img/dummy_male.png";
             }
             
             $yeararray = array();
             $montharray = array();
             $yearcons = Carbon::now();
             $currentyear = $yearcons->year;
             $currentmonth = $yearcons->format('F');
             $currentdate = $yearcons->format('Y-m-d');
             
             
             for($k=2016; $k<=$currentyear; $k++){
                 $yeararray[] = $k;
             }
             
             for($k=1; $k<=12; $k++){
                 $month = Carbon::createFromDate(2016, $k, 1, 'Asia/Kolkata');
                 $montharray[] = $month->format('F');
             }
             
             
                          
             return view('newemployeezone.myattendance')->with(['getemployeedata'=> $getemployeedata, 'getattendance'=> $datearray,'montharray' => $montharray, 'yeararray'=>$yeararray,'currentyear' => $currentyear,'currentmonth'=>$currentmonth,'currentdate'=>$currentdate,'profilepic' => $profilepic]);
             
              }
        else{
            return redirect()->route('newemployee_home');
        }
    }
    
    public function newpostmyattendance(Request $request){
        if ($request->session()->has('employeesession')) {
            $encrypt = $request->session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $employeeid = $split[0];
            $getemployeedata = DB::connection('mysql6')->table('employee')->where('id', '=', $employeeid)->get();
            
            
             $validate = $this->validate($request, [
            'monthname' => 'required',
            'yearname' => 'required'
			]);
            
            foreach ($getemployeedata as $ckey => $cvalue) {
                 $cadre = $cvalue->cadre;
                 $shift_name = $cvalue->shift_name;
                 //dd($shift_name);
             }
            
            
            $month = $request->monthname;
            $year = $request->yearname;

            $listfiles = Storage::disk('s3')->files("/newcustomerzoneassets/employeeprofileimage/".$employeeid);             
             if(count($listfiles) > 0){
                $profilepic = config('app.AWS_URL')."/".$listfiles[0];
            }
             else
             {
                $profilepic = config('app.AWS_URL')."/newcustomerzoneassets/img/dummy_male.png";
             }
            
            
              $dt = new \DateTime("last day of $month $year"); // <== instance from another API
             $bt = new \DateTime("second sat of $month $year");

        
$carbon = Carbon::instance($dt);                          // 'Carbon\Carbon'
$btcarbon = Carbon::instance($bt);                          // 'Carbon\Carbon'
$test = $carbon->toDateTimeString(); 
$secondtest = $btcarbon->toDateString();

            
             
             $datearray = array();
             $newarray = array();
             $getattendance = $this->attendance($employeeid, $month, $year);
            $getholiday = $this->holiday($employeeid, $year);
             if(!empty($getattendance)){
                 $newarray = $getattendance['Attend_Details'];
             }
             
             $date = Carbon::parse($test);
             
             for($i = 1; $i <= $date->day; $i++){
                 $year = $date->year;
                 $month = $date->month;
                 
                 $createddate = Carbon::createFromDate($year, $month, $i, 'Asia/Kolkata');
                 $j = $i-1;
                 
                 $datearray[$j]['created_date'] = $createddate->format('d, F Y');
                 $datearray[$j]['dayname'] = $createddate->format('l');
                 $datearray[$j]['attendancedate'] = $createddate->format('Y-m-d');
                 
                $datearray[$j]['shift_name'] = '';
                $datearray[$j]['shift_start'] = '';
                $datearray[$j]['shift_end'] = '';
                $datearray[$j]['punch_in'] = '';
                $datearray[$j]['punch_out'] = '';
                $datearray[$j]['second_saturday'] = false;
                $datearray[$j]['is_punchin_deviate'] = false;
                $datearray[$j]['is_punchout_deviate'] = false;
                    if($createddate->format('l') == 'Sunday'){
                 $datearray[$j]['is_sunday'] = true;
                 }else
                 {
                    $datearray[$j]['is_sunday'] = false;
                 }
                 
                 
                 $datearray[$j]['holiday_name'] = '';
                 $datearray[$j]['holiday_count'] = '';
                 
                 foreach($getholiday['CALENDAR'] as $holiday){
                     
                     if($createddate->toDateString() == $this->formatdate($holiday['Date'])){
                         
                         $datearray[$j]['holiday_name'] = $holiday['Holidays'];
                         $datearray[$j]['holiday_count'] = $holiday['No_of_Days'];
                     }
                 }
                 
                 if($secondtest == $createddate->toDateString()){
                                 $datearray[$j]['second_saturday'] = true;
                             }
                 
                 
                 if(!empty($newarray)){
                     foreach($newarray as $saparray){
                         $sapformattedarrayval = $this->formatdate($saparray['Date']);
                         if($createddate->toDateString() == $sapformattedarrayval){
                             $datearray[$j]['shift_name'] = $saparray['Shift_Name'];
                             $datearray[$j]['shift_start'] = $this->formattime($saparray['Shift_Start']);

                             if (($shift_name == 'VGN HO GENERAL SHIFT')&&($secondtest == $createddate->toDateString())) {
                                $saparray['Shift_End'] = '133000';
                                
                            }

                             $datearray[$j]['shift_end'] = $this->formattime($saparray['Shift_End']);


                               $formatedsttime = Carbon::parse($this->formattime($saparray['Shift_Start']));
                             $formatedettime = Carbon::parse($this->formattime($saparray['Shift_End']));
                            
                            $formatedpunch = Carbon::parse($this->formattime($saparray['Punch_IN']));

                            $formatedpunchout = Carbon::parse($this->formattime($saparray['Punch_OUT']));
                    $graceadded = Carbon::create($formatedpunch->year, $formatedpunch->month, $formatedpunch->day,$formatedsttime->hour, $formatedsttime->minute, $formatedsttime->second);
                    $endformatedtime = Carbon::create($formatedpunch->year, $formatedpunch->month, $formatedpunch->day,$formatedettime->hour, $formatedettime->minute, $formatedettime->second);
                     if ($cadre == 'M') {
                        $finalgraceadded = $graceadded->addMinutes(31);
                    }
                    elseif ($cadre == 'O') {
                        $finalgraceadded = $graceadded->addMinutes(16);
                    }
                    else{
                    $finalgraceadded = $graceadded->addMinutes(16);    
                    }

                    $punchin_greater = $formatedpunch->gt($finalgraceadded);
                    $punchin_lesser = $formatedpunchout->lt($endformatedtime);

                             $datearray[$j]['shift_end'] = $this->formattime($saparray['Shift_End']);
                             $datearray[$j]['punch_in'] = $this->formattime($saparray['Punch_IN']);
                             $datearray[$j]['punch_out'] = $this->formattime($saparray['Punch_OUT']);
                             $datearray[$j]['is_punchin_deviate'] = $punchin_greater;
                             $datearray[$j]['is_punchout_deviate'] = $punchin_lesser;
                             
                         }
                     }
                 }
             }

                    
             
             
             
             
             $yeararray = array();
             $montharray = array();
             $yearcons = Carbon::now();
             $currentyear = $yearcons->year;
             $currentmonth = $yearcons->format('F');
             $currentdate = $yearcons->format('Y-m-d');
             
             
             for($k=2016; $k<=$currentyear; $k++){
                 $yeararray[] = $k;
             }
             
             for($k=1; $k<=6; $k++){
                 $month = Carbon::createFromDate(2016, $k, 1, 'Asia/Kolkata');
                 $montharray[] = $month->format('F');
             }
            
            $postedmonth = $request->monthname;
            $postedyear = $request->yearname;
            
             
             
               
             return view('newemployeezone.myattendance')->with(['getemployeedata'=> $getemployeedata, 'getattendance'=> $datearray,'montharray' => $montharray, 'yeararray'=>$yeararray,'currentyear' => $postedyear,'currentmonth'=>$postedmonth,'currentdate'=>$currentdate,'profilepic' => $profilepic]);
            
                 }
        else{
            return redirect()->route('newemployee_home');
        }
    }
    
    public function newholidaycalendar(Request $request){
        
        if ($request->session()->has('employeesession')) {
            $encrypt = $request->session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $employeeid = $split[0];
            $getemployeedata = DB::connection('mysql6')->table('employee')->where('id', '=', $employeeid)->get();

            $pwd_status = $this->is_emp_didnt_passwordchanged($employeeid);
            if ($pwd_status == 0) {
                $request->session()->flash("error_msg", 'Please change the default password. Only if you Change the default password , other functionalities on this portal will work. This is done for security purposes. Please do not share your password with anyone');
                return redirect()->route('newemployee_mydetails_passchange');
            }
            
            $geteventdata = DB::connection('mysql6')->table('employee_event_data')->where('employee_id', '=', $employeeid)->get();
            
             $month = date('F');
             $year = date('Y');
            
            $vendarray = array();
            if(count($geteventdata) > 0){
                foreach($geteventdata as $vend){
                    $vendarray['list'][$vend->date_created][] = $vend->description;
                }
            }
                
            //dd($vendarray);
            
            
            
             
             $getholiday = $this->holiday($employeeid, $year);
             
             
                 $datearray = array();         
             
             $j = 0;
             
            
                if(array_key_exists('0',$getholiday['CALENDAR'])){
                    
                 foreach($getholiday['CALENDAR'] as $holiday){
                     
                         $datearray[$j]['holiday_date'] = $this->formatdate($holiday['Date']);
                         $datearray[$j]['holiday_name'] = $holiday['Holidays'];
                         $datearray[$j]['holiday_count'] = $holiday['No_of_Days'];
                         $j++;
                     
                 }
                }
                                     
                          
             $listfiles = Storage::disk('s3')->files("/newcustomerzoneassets/employeeprofileimage/".$employeeid);             
             if(count($listfiles) > 0){
                $profilepic = config('app.AWS_URL')."/".$listfiles[0];
            }
             else
             {
                $profilepic = config('app.AWS_URL')."/newcustomerzoneassets/img/dummy_male.png";
             }
             
            
            
            return view('newemployeezone.holidaycalendar')->with(['getemployeedata'=> $getemployeedata, 'getattendance'=> $datearray,'eventdata' => $vendarray,'employeeid' => $employeeid ,'profilepic' => $profilepic]);
            
            }
        else{
            return redirect()->route('newemployee_home');
        }
        
    }
    
    
    public function newpostholidaycalendar(Request $request){
        
         if ($request->session()->has('employeesession')) {
            $encrypt = $request->session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $employeeid = $split[0];
            $getemployeedata = DB::connection('mysql6')->table('employee')->where('id', '=', $employeeid)->get();
             
             $geteventdata = DB::connection('mysql6')->table('employee_event_data')->where('employee_id', '=', $employeeid)->where('date_created', '=', $request->selecteddate)->get();
             
             $newarray = array();
             
             if(count($geteventdata) > 50){
                 return 244;
             }
             else{
             
             $geteventdata = DB::connection('mysql6')->table('employee_event_data')->insert(['employee_id' => $employeeid,'description'=>$request->selectedtitle,'date_created'=>$request->selecteddate,
            'classid'=>$request->selectedclassid,
            'bgcolor'=>$request->selectedbackgroundcolor,
            'bordercolor'=>$request->selectedclassbordercolor,
             ]);                         
             
             return 200;
             
             }
             
             
             
              }
        else{
            return redirect()->route('newemployee_home');
        }
        
    }
    
    public function getevents(Request $request){
        
        if ($request->session()->has('employeesession')) {
            $encrypt = $request->session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $employeeid = $split[0];
            $getemployeedata = DB::connection('mysql6')->table('employee')->where('id', '=', $employeeid)->get();
             
             $geteventdata = DB::connection('mysql6')->table('employee_event_data')->where('employee_id', '=', $employeeid)->where('date_created', '=', $request->selecteddate)->get();
            
            $geteventdata = DB::connection('mysql6')->table('employee_event_data')->where('employee_id', '=', $employeeid)->where('date_created', '=', $request->selecteddate)->get();
            
            return json_encode($geteventdata);
            
            
            
              }
        else{
            return redirect()->route('newemployee_home');
        }
        
    }
    
    public function deleteevents(Request $request){
        
        if ($request->session()->has('employeesession')) {
            $encrypt = $request->session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $employeeid = $split[0];
            $getemployeedata = DB::connection('mysql6')->table('employee')->where('id', '=', $employeeid)->get();
             
             $geteventdata = DB::connection('mysql6')->table('employee_event_data')->where('employee_id', '=', $employeeid)->where('date_created', '=', $request->selecteddate)->where('classid', '=', $request->selectedclassid)->get();
            
            if(count($geteventdata) == 1){
            $geteventdata = DB::connection('mysql6')->table('employee_event_data')->where('date_created', '=', $request->selecteddate)->where('classid', '=', $request->selectedclassid)->delete();
                return 1;
            }
            else
            {
                return 0;
            }
            
            
            
            
            
              }
        else{
            return redirect()->route('newemployee_home');
        }
        
    }
    
    
    public function emprefer_a_friend(Request $request){
        
        if ($request->session()->has('employeesession')) {
            $encrypt = $request->session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $employeeid = $split[0];
            $getemployeedata = DB::connection('mysql6')->table('employee')->where('id', '=', $employeeid)->get();
              
            $pwd_status = $this->is_emp_didnt_passwordchanged($employeeid);
            if ($pwd_status == 0) {
                $request->session()->flash("error_msg", 'Please change the default password. Only if you Change the default password , other functionalities on this portal will work. This is done for security purposes. Please do not share your password with anyone');
                return redirect()->route('newemployee_mydetails_passchange');
            }
            
            $listfiles = Storage::disk('s3')->files("/newcustomerzoneassets/employeeprofileimage/".$employeeid);             
             if(count($listfiles) > 0){
                $profilepic = config('app.AWS_URL')."/".$listfiles[0];
            }
             else
             {
                $profilepic = config('app.AWS_URL')."/newcustomerzoneassets/img/dummy_male.png";
             }
            
            $getcareer = $this->empreferafriend();
            //dd($getcareer);
            $mainarray = array();
             if(array_key_exists('VGN_CAREERS', $getcareer)){
                if (array_key_exists('0', $getcareer['VGN_CAREERS'])) {
                	$mainarray['VGN_CAREERS'] = $getcareer['VGN_CAREERS'];
                }else{
                	$mainarray['VGN_CAREERS'][0] = $getcareer['VGN_CAREERS'];
                }
             }
             
            //dd($mainarray);
            
            return view('newemployeezone.empreferfriend')->with(['getemployeedata'=> $getemployeedata,'getcareer' =>$mainarray,'profilepic' => $profilepic]);
            
             }
        else{
            return redirect()->route('newemployee_home');
        }
        
    }
    
    public function emprefer_a_friend_applyjob(Request $request, $plant,$ref1,$ref2){
        
        if ($request->session()->has('employeesession')) {
            $encrypt = $request->session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $employeeid = $split[0];
            $getemployeedata = DB::connection('mysql6')->table('employee')->where('id', '=', $employeeid)->get();
            
            $pwd_status = $this->is_emp_didnt_passwordchanged($employeeid);
            if ($pwd_status == 0) {
                $request->session()->flash("error_msg", 'Please change the default password. Only if you Change the default password , other functionalities on this portal will work. This is done for security purposes. Please do not share your password with anyone');
                return redirect()->route('newemployee_mydetails_passchange');
            }
            
            $listfiles = Storage::disk('s3')->files("/newcustomerzoneassets/employeeprofileimage/".$employeeid);             
             if(count($listfiles) > 0){
                $profilepic = config('app.AWS_URL')."/".$listfiles[0];
            }
             else
             {
                $profilepic = config('app.AWS_URL')."/newcustomerzoneassets/img/dummy_male.png";
             }
            
            $getcareer = $this->empreferafriend();
            //dd($getcareer);
            $jointjobcode = $plant.'/'.$ref1.'/'.$ref2;
            $newarray = array();
            foreach($getcareer['VGN_CAREERS'] as $career){
                if($career['JOB_CODE'] == $jointjobcode){
                    $newarray[0] = $career;
                }
            }
             
            if(empty($newarray)){
                  $request->session()->flash("error_msg", "No description available");
                return redirect()->route('newempreferfriend');
            }
            
            //dd($newarray);
            return view('newemployeezone.empapplyjob')->with(['getemployeedata'=> $getemployeedata,'getcareer' =>$newarray,'profilepic' => $profilepic]);
            
             }
        else{
            return redirect()->route('newemployee_home');
        }
        
    }
    public function postemprefer_a_friend_applyjob(Request $request,$plant,$ref1,$ref2){
        
        if ($request->session()->has('employeesession')) {
            $encrypt = $request->session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $employeeid = $split[0];
            $getemployeedata = DB::connection('mysql6')->table('employee')->where('id', '=', $employeeid)->get();
            foreach ($getemployeedata as $key2 => $value2) {
                $empname = $value2->name;
            } 
            
            $validate = $this->validate($request, [
            'title' => 'required',
            'firstname' => 'required',
            'lastname' => 'required',
            'date_of_birth' => 'required|date',
            'gender' => 'required',
            'marital_status' => 'required',
            'nationality' => 'required',
            'language' => 'required',
            'house_and_street_no' => 'required',
            'second_address_line' => 'nullable|max:60',
            'city' => 'required',
            'district' => 'required',
            'country' => 'required',
            'region' => 'required',
            'postalcode' => 'required',
            'mobile' => 'required',
            'email_id' => 'required',
            'education_from_date' => 'required|date',
            'education_to_date' => 'required|date|after:education_from_date',
            'graduation' => 'required',
            'certificate' => 'required',
            'institute' => 'required',
            'education_country' => 'required',
            'mark' => 'required',
            'previous_experience_from_date' => 'nullable|date',
            'previous_experience_to_date' => 'nullable|date|after:previous_experience_from_date',
            'employer_name' => 'nullable|max:60',
            'industry' => 'nullable|max:60',
            'employer_city' => 'nullable|max:60',
            'employer_country' => 'nullable|max:60',
            'employer_contract' => 'nullable|max:60',
            'current_designation' => 'nullable|max:60',
            'current_ctc' => 'nullable|max:60',
            'reason_for_leaving' => 'nullable|max:60',
            'total_experience' => 'nullable|max:60',
            'resume' => 'required|mimes:pdf,doc,docx|min:10|max:5000',
			]);
            
            
            
            //dd($request);
            
            $attr = array();
            
            $attr['referral'] = $employeeid;
            $attr['job_code'] = $plant.'/'.$ref1.'/'.$ref2;
            $attr['dob'] = isset($request->date_of_birth)?$request->date_of_birth:'';
            $attr['f_name'] = isset($request->firstname)?$request->firstname:'';
            $attr['l_name'] = isset($request->lastname)?$request->lastname:'';
            $attr['tit'] = isset($request->title)?$request->title:'';
            $attr['gen'] = isset($request->gender)?$request->gender:'';
            $attr['mar'] = isset($request->marital_status)?$request->marital_status:'';
            $attr['nat'] = isset($request->nationality)?$request->nationality:'';
            $attr['lang'] = isset($request->language)?$request->language:'';
            $attr['hos'] = isset($request->house_and_street_no)?$request->house_and_street_no:'';
            $attr['adrs'] = isset($request->second_address_line)?$request->second_address_line:'';
            $attr['city'] = isset($request->city)?$request->city:'';
            $attr['regn'] = isset($request->region)?$request->region:'';
            $attr['dist'] = isset($request->district)?$request->district:'';
            $attr['pst_cod'] = isset($request->postalcode)?$request->postalcode:'';
            $attr['cntry'] = isset($request->country)?$request->country:'';
            $attr['tel'] = isset($request->mobile)?$request->mobile:'';
            $attr['mail'] = isset($request->email_id)?$request->email_id:'';
            $attr['grad'] = isset($request->graduation)?$request->graduation:'';
            $attr['edu_frm_date'] = $request->education_from_date;
            $attr['edu_to_date'] = isset($request->education_to_date)?$request->education_to_date:'';
            $attr['inst'] = isset($request->institute)?$request->institute:'';
            $attr['cntry_edu'] = isset($request->education_country)?$request->education_country:'';
            $attr['cert'] = isset($request->certificate)?$request->certificate:'';
            $attr['mark'] = isset($request->mark)?$request->mark:'';
            $attr['emp_name'] = isset($request->employer_name)? $request->employer_name :'';
            $attr['expr_from_date'] = isset($request->previous_experience_from_date)? $request->previous_experience_from_date: '';
            $attr['expr_to_date'] = isset($request->previous_experience_to_date) ? $request->previous_experience_to_date : '';
            $attr['emp_city'] = isset($request->employer_city)?$request->employer_city:'';
            $attr['emp_cntry'] = isset($request->employer_country)?$request->employer_country:'';
            $attr['indst'] = isset($request->industry)?$request->industry:'';
            $attr['emp_contract'] = isset($request->employer_contract)?$request->employer_contract:'';
            $attr['desg'] = isset($request->designation)?$request->designation:'';
            $attr['dept'] = isset($request->department)?$request->department:'';
            $attr['cur_desg'] = isset($request->current_designation)?$request->current_designation:'';
            $attr['cur_ctc'] = isset($request->current_ctc)?$request->current_ctc:'';
            $attr['reason'] = isset($request->reason_for_leaving)?$request->reason_for_leaving:'';
            $attr['total_exp'] = isset($request->total_experience)?$request->total_experience:'';
            
            
            $file = $request->file('resume');
             $filename = $file->getClientOriginalName();
             $destinationpath = "files";
             $ext = pathinfo($filename, PATHINFO_EXTENSION);
             
            $res = $this->applyjob($attr);
            
            if(!empty($res['Status_Note']) && !empty($res['Applicant_No']))
            {
            //$listfiles = Storage::disk('resume_uploads')->files($vendorid);
            
             $uploadeddatetime = date('Ymd');
             $randomno = rand(1, 1000000);
             $newname = $res['Applicant_No'];
             //$uploaded = Storage::disk('s3')->putFileAs('resumes/'.$destinationpath, $request->file('resume'), $newname.'.'.$ext);
  		$uploaded = Storage::disk('public_local')->putFileAs('/resumes',$request->file('resume'), $newname.'.'.$ext);
             $ffname = "resumes/".$newname.'.'.$ext;
             
             if($uploaded){

		$paramRQ = array('id' => null,'Employee_No'=>$attr['referral'].', '.$empname,'Job_Code'=>$attr['job_code'],'First_Name'=>$attr['f_name'],'Last_Name'=>$attr['l_name'],'Date_of_Birth'=>str_replace('-','',$attr['dob']),'Title'=>$attr['tit'],'Gender'=>$attr['gen'],'Marital_Status'=>$attr['mar'],'Nationality'=>$attr['nat'],'Correspondence_Language'=>$attr['lang'],'House_No_and_Street'=>$attr['hos'],'Address_Line_2'=>$attr['adrs'],'City'=>$attr['city'],'Region'=>$attr['regn'],'District'=>$attr['dist'],'Postal_Code'=>$attr['pst_cod'],'Country'=>$attr['cntry'],'Telephone_Number'=>$attr['tel'],'Mail_Address'=>$attr['mail'],'EDUCATION_ESTABLISHMENT'=>$attr['grad'],'Edu_From_date'=>str_replace('-','',$attr['edu_frm_date']),'Edu_To_date'=>str_replace('-','',$attr['edu_to_date']),'Institute'=>$attr['inst'],'Country_Edu'=>$attr['cntry_edu'],'Certification'=>$attr['cert'],'Mark'=>$attr['mark'],'EMPLOYER'=>$attr['emp_name'],'Emp_From_date'=>str_replace('-','',$attr['expr_from_date']),'Emp_To_date'=>str_replace('-','',$attr['expr_to_date']),'City_Emp'=>$attr['emp_city'],'Country_Emp'=>$attr['emp_cntry'],'Industry'=>$attr['indst'],'Employment_Contract'=>$attr['emp_contract'],'Designation'=>$attr['desg'],'Department'=>$attr['dept'],'Current_Designation'=>$attr['cur_desg'],'Current_CTC'=>$attr['cur_ctc'],'Reason_for_Leaving'=>$attr['reason'],'Total_Years_of_Experience'=>$attr['total_exp'],'uploaded_url' => "$ffname", 'app_id' => "$newname",'created_datetime' => Carbon::now()->toDateTimeString());

                DB::connection('mysql8')->table('application_details')->insert($paramRQ);

                 $request->session()->flash("suc_msg", "Job Application submitted successfully. Your application id is $newname and Resume Uploaded Successfully!");
                return redirect()->back();     
             }
             else
             {
                 $request->session()->flash("error_msg", "Job Application submitted successfully. Your application id is $newname and Resume not uploaded. Try Again!");
                return redirect()->back();     
             }
            
            }
        else
        {
            $request->session()->flash("error_msg", "Job Application failed to submit!");
                return redirect()->back();  
            
        }
            
            
          
            
             }
        else{
            return redirect()->route('newemployee_home');
        }
        
    }
    
    
    
    
    
    public function createTree(&$list, $parent){
    $tree = array();
    foreach ($parent as $k=>$l){
        if(isset($list[$l['ID']])){
            $l['children'] = $this->createTree($list, $list[$l['ID']]);
        }
        $tree[] = $l;
    } 
    return $tree;
}
    
    
    
    public function reportingstructure(Request $request){
        
        if ($request->session()->has('employeesession')) {
            $encrypt = $request->session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $employeeid = $split[0];
            $getemployeedata = DB::connection('mysql6')->table('employee')->where('id', '=', $employeeid)->get();
            
            $pwd_status = $this->is_emp_didnt_passwordchanged($employeeid);
            if ($pwd_status == 0) {
                $request->session()->flash("error_msg", 'Please change the default password. Only if you Change the default password , other functionalities on this portal will work. This is done for security purposes. Please do not share your password with anyone');
                return redirect()->route('newemployee_mydetails_passchange');
            }

            if ($request->session()->has('empreport')) {
            $request->session()->forget('empreport');
            }
            
            $structure = $this->reportStructure($employeeid);
           
            
            $request->session()->put('empreport', $structure['Reporting_Structure']);
            
            //dd($mainlogin);
            
            $kk = 0;
            $list = array();
            //dd(count($structure['Reporting_Structure']));
            if ($request->session()->has('empreport')) {
            $getreport = $request->session()->get('empreport');
               // dd($getreport);
            $convertarraylist = array();
                $kk = 0;
                foreach($getreport as $check){
                    $convertarraylist[$kk]['name'] = $check['Employee_Name'];
                    $convertarraylist[$kk]['title'] = $check['Designation'];
                    $convertarraylist[$kk]['Parent'] = $check['Parent'];
                    $convertarraylist[$kk]['ID'] = $check['ID'];
                    $convertarraylist[$kk]['Type'] = $check['Type'];
                    $convertarraylist[$kk]['Plant'] = $check['Plant'];
                    $convertarraylist[$kk]['Department'] = $check['Department'];
                    $convertarraylist[$kk]['empno'] = $check['Employee_No'];
                    $kk++;
                }
            
                
                
                
                
                $new = array();
foreach ($convertarraylist as $a){
    $new[$a['Parent']][] = $a;
}
$final = $this->createTree($new, array($convertarraylist[0]));

                
      $test = array();
                foreach($final as $newfinal){
                  $test =   $newfinal;
                }
                
                //dd($test);
                
        }
            
            
                        
             $listfiles = Storage::disk('s3')->files("/newcustomerzoneassets/employeeprofileimage/".$employeeid);             
             if(count($listfiles) > 0){
                $profilepic = config('app.AWS_URL')."/".$listfiles[0];
            }
             else
             {
                $profilepic = config('app.AWS_URL')."/newcustomerzoneassets/img/dummy_male.png";
             }
            //dd($child_array);
            
            
            
            
            
            
            return view('newemployeezone.reportingstructure')->with(['getemployeedata'=> $getemployeedata,'structure'=>$structure,'test'=>$test,'employeeid' => $employeeid,'profilepic' => $profilepic]);
            
               }
        else{
            return redirect()->route('newemployee_home');
        }
    }


    public function newreportingstructure(Request $request){
        
        if ($request->session()->has('employeesession')) {
            $encrypt = $request->session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $employeeid = $split[0];
            $getemployeedata = DB::connection('mysql6')->table('employee')->where('id', '=', $employeeid)->get();
            
            if ($request->session()->has('empreport')) {
            $request->session()->forget('empreport');
            }
            
            $structure = $this->reportStructure($employeeid);
            
            $request->session()->put('empreport', $structure['Reporting_Structure']);
            
            //dd($mainlogin);
            
            $kk = 0;
            $list = array();
            //dd(count($structure['Reporting_Structure']));
            if ($request->session()->has('empreport')) {
            $getreport = $request->session()->get('empreport');
               // dd($getreport);
            $convertarraylist = array();
                $kk = 0;
                foreach($getreport as $check){
                    $convertarraylist[$kk]['name'] = $check['Employee_Name'];
                    $convertarraylist[$kk]['title'] = $check['Designation'];
                    $convertarraylist[$kk]['Parent'] = $check['Parent'];
                    $convertarraylist[$kk]['ID'] = $check['ID'];
                    $convertarraylist[$kk]['Type'] = $check['Type'];
                    $convertarraylist[$kk]['Plant'] = $check['Plant'];
                    $convertarraylist[$kk]['Department'] = $check['Department'];
                    $convertarraylist[$kk]['empno'] = $check['Employee_No'];
                    $kk++;
                }
            
                
                
                
                
                $new = array();
foreach ($convertarraylist as $a){
    $new[$a['Parent']][] = $a;
}
$final = $this->createTree($new, array($convertarraylist[0]));

                
      $test = array();
                foreach($final as $newfinal){
                  $test =   $newfinal;
                }
                
                //dd($test);
                
        }
            
            
                        
             $listfiles = Storage::disk('s3')->files("/newcustomerzoneassets/employeeprofileimage/".$employeeid);             
             if(count($listfiles) > 0){
                $profilepic = config('app.AWS_URL')."/".$listfiles[0];
            }
             else
             {
                $profilepic = config('app.AWS_URL')."/newcustomerzoneassets/img/dummy_male.png";
             }
            //dd($child_array);
            
            
            
            
            
            
            return view('newemployeezone.newreport')->with(['getemployeedata'=> $getemployeedata,'structure'=>$structure,'test'=>$test,'employeeid' => $employeeid,'profilepic' => $profilepic]);
            
               }
        else{
            return redirect()->route('newemployee_home');
        }
    }
    
    
    public function empmemos(Request $request){
        
        if ($request->session()->has('employeesession')) {
            $encrypt = $request->session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $employeeid = $split[0];
            $getemployeedata = DB::connection('mysql6')->table('employee')->where('id', '=', $employeeid)->get();
            
            $pwd_status = $this->is_emp_didnt_passwordchanged($employeeid);
            if ($pwd_status == 0) {
                $request->session()->flash("error_msg", 'Please change the default password. Only if you Change the default password , other functionalities on this portal will work. This is done for security purposes. Please do not share your password with anyone');
                return redirect()->route('newemployee_mydetails_passchange');
            }
            
                        
             $listfiles = Storage::disk('s3')->files("/newcustomerzoneassets/employeeprofileimage/".$employeeid);             
             if(count($listfiles) > 0){
                $profilepic = config('app.AWS_URL')."/".$listfiles[0];
            }
             else
             {
                $profilepic = config('app.AWS_URL')."/newcustomerzoneassets/img/dummy_male.png";
             }
            //dd($child_array);
            
            $year=date('Y');
            $memos = $this->getmemos($employeeid);
            //dd($memos);
            $memoresult = $memos['MEMOS'];
							$fineresult = $memos['FINE_DEDUCTION'];
                            
                            $memo_key_exists = array_key_exists("0",$memoresult);
                            $fine_key_exists = array_key_exists("0",$fineresult);
                                                
                                    if($memo_key_exists === true)
                                                {
                                                    $memo_array =$memos['MEMOS'];
                                                }
                                                else
                                                {
                                                    $memo_array[0] = $memos['MEMOS'];
                                                }         
                            
                            if($fine_key_exists === true)
                                                {
                                                    $fine_array =$memos['FINE_DEDUCTION'];
                                                }
                                                else
                                                {
                                                    $fine_array[0] = $memos['FINE_DEDUCTION'];
                                                }
            
            
            //dd($getmemos);
            
            return view('newemployeezone.memos')->with(['getemployeedata'=> $getemployeedata,'memo_array'=>$memo_array,'fine_array'=>$fine_array,'profilepic' => $profilepic]);
            
            
               }
        else{
            return redirect()->route('newemployee_home');
        }
    }
    
    public function hrpolicy(Request $request){
        
        if ($request->session()->has('employeesession')) {
            $encrypt = $request->session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $employeeid = $split[0];
            $getemployeedata = DB::connection('mysql6')->table('employee')->where('id', '=', $employeeid)->get();
            
            
            $pwd_status = $this->is_emp_didnt_passwordchanged($employeeid);
            if ($pwd_status == 0) {
                $request->session()->flash("error_msg", 'Please change the default password. Only if you Change the default password , other functionalities on this portal will work. This is done for security purposes. Please do not share your password with anyone');
                return redirect()->route('newemployee_mydetails_passchange');
            }
                        
             $listfiles = Storage::disk('s3')->files("/newcustomerzoneassets/employeeprofileimage/".$employeeid);             
             if(count($listfiles) > 0){
                $profilepic = config('app.AWS_URL')."/".$listfiles[0];
            }
             else
             {
                $profilepic = config('app.AWS_URL')."/newcustomerzoneassets/img/dummy_male.png";
             }
            //dd($child_array);
            
            foreach($getemployeedata as $emp){
                $plantid = $emp->plantid;
            }
            
            $gethrpolicy = $this->gethrpolicy($plantid);
            
            //dd($gethrpolicy);
            if(!empty($gethrpolicy)){
            
            $policy_key_exists = array_key_exists("0",$gethrpolicy['HR_POLICY']);
                            
                                                
                                    if($policy_key_exists === true)
                                                {
                                                    $policy_array =$gethrpolicy['HR_POLICY'];
                                                }
                                                else
                                                {
                                                    $policy_array[0] = $gethrpolicy['HR_POLICY'];
                                                }
            }else{
                $policy_array = [];
            }
            
            //dd($policy_array);
            
            //dd($getmemos);
            
            return view('newemployeezone.hrpolicy')->with(['getemployeedata'=> $getemployeedata,'policy_array'=>$policy_array,'profilepic' => $profilepic]);
            
            
               }
        else{
            return redirect()->route('newemployee_home');
        }
    }
    
    public function mydutiesandresponsibilities(Request $request){
        
         if ($request->session()->has('employeesession')) {
            $encrypt = $request->session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $employeeid = $split[0];
            $getemployeedata = DB::connection('mysql6')->table('employee')->where('id', '=', $employeeid)->get();
            
            $pwd_status = $this->is_emp_didnt_passwordchanged($employeeid);
            if ($pwd_status == 0) {
                $request->session()->flash("error_msg", 'Please change the default password. Only if you Change the default password , other functionalities on this portal will work. This is done for security purposes. Please do not share your password with anyone');
                return redirect()->route('newemployee_mydetails_passchange');
            }
            
                        
             $listfiles = Storage::disk('s3')->files("/newcustomerzoneassets/employeeprofileimage/".$employeeid);             
             if(count($listfiles) > 0){
                $profilepic = config('app.AWS_URL')."/".$listfiles[0];
            }
             else
             {
                $profilepic = config('app.AWS_URL')."/newcustomerzoneassets/img/dummy_male.png";
             }
             
             $getemp = $this->getemployee($employeeid);
             
             
             $resp = $getemp['Duties_Responsibilities'];
            // dd($resp);
             
             return view('newemployeezone.mydutiesandresp')->with(['getemployeedata'=> $getemployeedata,'resp'=>$resp,'profilepic' => $profilepic]);
            
            
               }
        else{
            return redirect()->route('newemployee_home');
        }
    }
    
     public function empeligibility(Request $request){
        
         if ($request->session()->has('employeesession')) {
            $encrypt = $request->session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $employeeid = $split[0];
           
            $getemployeedata = DB::connection('mysql6')->table('employee')->where('id', '=', $employeeid)->get();
            
            
            $pwd_status = $this->is_emp_didnt_passwordchanged($employeeid);
            if ($pwd_status == 0) {
                $request->session()->flash("error_msg", 'Please change the default password. Only if you Change the default password , other functionalities on this portal will work. This is done for security purposes. Please do not share your password with anyone');
                return redirect()->route('newemployee_mydetails_passchange');
            }
                        
             $listfiles = Storage::disk('s3')->files("/newcustomerzoneassets/employeeprofileimage/".$employeeid);             
             if(count($listfiles) > 0){
                $profilepic = config('app.AWS_URL')."/".$listfiles[0];
            }
             else
             {
                $profilepic = config('app.AWS_URL')."/newcustomerzoneassets/img/dummy_male.png";
             }
             
             $getemp = $this->getemployee($employeeid);
              
             //dd($getemp);
             $orgeligarray = array();
             $myeligarray = array();

             if (array_key_exists('Eligibilities', $getemp)) {
             	$orgeligarray = $getemp['Eligibilities'];
             }else{
             	$orgeligarray['MOBILE'] = '';
             	$orgeligarray['MAIL'] = '';
             	$orgeligarray['LAPTOP'] = '';
             	$orgeligarray['DESKTOP'] = '';
             	$orgeligarray['BUSINESSCARD'] = '';
             	$orgeligarray['IDCARD'] = '';
             	$orgeligarray['SAPID'] = '';
             	$orgeligarray['INTERCOM'] = '';
             	$orgeligarray['TRAINING_KIT'] = '';
             	$orgeligarray['DIARY'] = '';
             }

              if (array_key_exists('Eligibilities_1', $getemp)) {
             	$myeligarray = $getemp['Eligibilities_1'];
             }else{
             	$myeligarray['MOBILE'] = '';
             	$myeligarray['MAIL'] = '';
             	$myeligarray['LAPTOP'] = '';
             	$myeligarray['DESKTOP'] = '';
             	$myeligarray['BUSINESS_CARD'] = '';
             	$myeligarray['ID_CARD'] = '';
             	$myeligarray['SAP_ID'] = '';
             	$myeligarray['INTERCOM'] = '';
             	$myeligarray['TRAINING_KIT'] = '';
             	$myeligarray['DIARY'] = '';
             }

             //$orgelig = $getemp['Eligibilities'];
            // $myelig = $getemp['Eligibilities_1'];
            
             
             return view('newemployeezone.empeligib')->with(['getemployeedata'=> $getemployeedata,'orgelig'=>$orgeligarray,'myelig'=>$myeligarray,'profilepic' => $profilepic]);
            
            
               }
        else{
            return redirect()->route('newemployee_home');
        }
    }
    
    public function postempeligibility(Request $request){
        
         if ($request->session()->has('employeesession')) {
            $encrypt = $request->session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $employeeid = $split[0];
            $getemployeedata = DB::connection('mysql6')->table('employee')->where('id', '=', $employeeid)->get();
            
            
           
             
             
             $elib_array =array();
        if($request->get('emp-mobile') == "on"){ $elib_array['mobile'] = 'X'; }else{ $elib_array['mobile'] = '';}
        if($request->get('emp-mail') == "on"){ $elib_array['mail'] = 'X'; }else{ $elib_array['mail'] = '';}
        if($request->get('emp-laptop') == 'on'){ $elib_array['laptop'] = 'X'; }else{ $elib_array['laptop'] = '';}
        if($request->get('emp-desktop') == 'on'){ $elib_array['desktop'] = 'X'; }else{ $elib_array['desktop'] = '';}
        if($request->get('emp-buisnesscard') == 'on'){ $elib_array['bcard'] = 'X'; }else{ $elib_array['bcard'] = '';}
        if($request->get('emp-idcard') == 'on'){ $elib_array['idcard'] = 'X'; }else{ $elib_array['idcard'] = '';}
        if($request->get('emp-sapid') == 'on'){ $elib_array['sapid'] = 'X'; }else{ $elib_array['sapid'] = '';}
        if($request->get('emp-intercom') == 'on'){ $elib_array['intercom'] = 'X'; }else{ $elib_array['intercom'] = '';}
        if($request->get('emp-trainingkit') == 'on'){ $elib_array['kit'] = 'X'; }else{ $elib_array['kit'] = '';}
        if($request->get('emp-diary') == 'on'){ $elib_array['diary'] = 'X'; }else{ $elib_array['diary'] = '';}
        if($request->get('emp-cug') == 'on'){ $elib_array['cug'] = 'X'; }else{ $elib_array['cug'] = '';}
	if($request->get('emp-adda') == 'on'){ $elib_array['adda'] = 'X'; }else{ $elib_array['adda'] = '';}
        if($request->get('emp-nameboard') == 'on'){ $elib_array['nameboard'] = 'X'; }else{ $elib_array['nameboard'] = '';}
	if($request->get('emp-epa') == 'on'){ $elib_array['epa'] = 'X'; }else{ $elib_array['epa'] = '';}
        if($request->get('emp-fpa') == 'on'){ $elib_array['fpa'] = 'X'; }else{ $elib_array['fpa'] = '';}
        if($request->get('emp-dsl') == 'on'){ $elib_array['dsl'] = 'X'; }else{ $elib_array['dsl'] = '';}
        
             
             $res = $this->eligibilty_update($employeeid,$elib_array);
             if($res['STATUS'] == 'Updated Succesfully'){
                 $request->session()->flash("suc_msg", "Successfully Eligibility Data recorded!");
                return redirect()->back();     
             }
             else
             {
                 $request->session()->flash("error_msg", "Eligibility Data not updated. Try Again!");
                return redirect()->back();     
             }
             
             
             
             
               }
        else{
            return redirect()->route('newemployee_home');
        }
        
    }
    
    public function leadselection(Request $request){
        
        if ($request->session()->has('employeesession')) {
            $encrypt = $request->session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $employeeid = $split[0];
            $getemployeedata = DB::connection('mysql6')->table('employee')->where('id', '=', $employeeid)->get();

            $pwd_status = $this->is_emp_didnt_passwordchanged($employeeid);
            if ($pwd_status == 0) {
                $request->session()->flash("error_msg", 'Please change the default password. Only if you Change the default password , other functionalities on this portal will work. This is done for security purposes. Please do not share your password with anyone');
                return redirect()->route('newemployee_mydetails_passchange');
            }
            
            foreach($getemployeedata as $emp){
                $valid = $emp->saleorder;
                
            }
            
            if($valid != "1"){
                return redirect()->route('newemployee_dashboard', ['empid' => $employeeid]);
            }
            
            if ($request->session()->has('filtered_lead')) {
                $request->session()->forget('filtered_lead');
                
            }
            
            
            $getprojectnames = $this->getUnsold('123');
                        
             $listfiles = Storage::disk('s3')->files("/newcustomerzoneassets/employeeprofileimage/".$employeeid);             
             if(count($listfiles) > 0){
                $profilepic = config('app.AWS_URL')."/".$listfiles[0];
            }
             else
             {
                $profilepic = config('app.AWS_URL')."/newcustomerzoneassets/img/dummy_male.png";
             }
            
            
            return view('newemployeezone.leadselection')->with(['getemployeedata'=> $getemployeedata,'getprojectnames'=>$getprojectnames,'profilepic' => $profilepic]);
            
               }
        else{
            return redirect()->route('newemployee_home');
        }
    }
    
    public function postleadselection(Request $request){
        
        if ($request->session()->has('employeesession')) {
            $encrypt = $request->session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $employeeid = $split[0];
            $getemployeedata = DB::connection('mysql6')->table('employee')->where('id', '=', $employeeid)->get();
            
            foreach($getemployeedata as $emp){
                $valid = $emp->saleorder;
                
            }
            
            if($valid != "1"){
                return redirect()->route('newemployee_dashboard', ['empid' => $employeeid]);
            }
            
            
            /*$validate = $this->validate($request, [
            'plantcode' => 'required',
            'leadno' => 'required',
            'leadname' => 'required',
            'createddate' => 'required'
                 ]);*/
            
            
            $plantcode = $request->plantcode;
            $leadno = $request->leadno;
			$leadname = $request->leadname;
			$phoneno = '';
			$createddate = $request->createddate;

											$check = 0;
											if($plantcode == ''){ $check += 1; $plantcode = '?';}
											if($leadno == ''){ $check += 1; $leadno = '?';}
											if($leadname == ''){ $check += 1; $leadname = '?';}
											if($phoneno == ''){ $check += 1; $phoneno = '?';}
											if($createddate == ''){ $createddate += 1; $createddate = '?';}
											$check += 1;

											if ($check == 5) {
												
                $request->session()->flash("error_msg", "Please fill any one field!");
                return redirect()->back();  
											}
											elseif($plantcode == ''){
												
                $request->session()->flash("error_msg", "Plant Code is mandatory!");
                return redirect()->back();  
											}
											else
											{
												if (($createddate != '?')) {
													$createddate = str_replace('-', '', $createddate);
												}

												$searchquery = $plantcode.'/'.$leadno.'/'.$leadname.'/'.$phoneno.'/'.$createddate;
												
												$searchlead = $this->searchlead($searchquery);
												
												$fresult = array();
												if (array_key_exists('0', $searchlead['DATA'])) {
													
													$fresult = $searchlead['DATA'];
												}
												else
												{
													$fresult[0] = $searchlead['DATA'];
												}

												if ($fresult[0]['Plant'] == 'No Data') {
													
                $request->session()->flash("error_msg", "No results found!");
                return redirect()->back(); 
                                                    
												}
												else
												{
													
													
                                            $request->session()->put('filtered_lead', $fresult);
                                                return redirect()->route('filterleadselection');
												}
            
                                            }
            
               }
        else{
            return redirect()->route('newemployee_home');
        }
    }
    
    public function filterleadselection(Request $request){
        
        if ($request->session()->has('employeesession')) {
            $encrypt = $request->session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $employeeid = $split[0];
            $getemployeedata = DB::connection('mysql6')->table('employee')->where('id', '=', $employeeid)->get();

            $pwd_status = $this->is_emp_didnt_passwordchanged($employeeid);
            if ($pwd_status == 0) {
                $request->session()->flash("error_msg", 'Please change the default password. Only if you Change the default password , other functionalities on this portal will work. This is done for security purposes. Please do not share your password with anyone');
                return redirect()->route('newemployee_mydetails_passchange');
            }
            
            foreach($getemployeedata as $emp){
                $valid = $emp->saleorder;
                $salesexec = $emp->name;
                
            }
            
            if($valid != "1"){
                return redirect()->route('newemployee_dashboard', ['empid' => $employeeid]);
            }
            
            $mainarray = array();
            if ($request->session()->has('selected_lead')) {
                $request->session()->forget('selected_lead');
            }
            if ($request->session()->has('filtered_lead')) {
                
                if($request->session()->has('customerdata')){
                    $request->session()->forget('customerdata');
                }
                    
                
                $getfiltered_leads = $request->session()->get('filtered_lead');
                
                if(!empty($getfiltered_leads)){
                    foreach($getfiltered_leads as $filtersalesexc){
                        
                        if($filtersalesexc['Sales_Exe'] == $salesexec){
                            $mainarray[] = $filtersalesexc;
                        }
                    }
                }
                else
                {
                     $request->session()->flash("error_msg", "No results found!");
                     return redirect()->route('leadselection'); 
                }
            }
            else
            {
                return redirect()->route('leadselection');
            }
            
            
            if(count($mainarray) == 0){
                 $request->session()->flash("error_msg", "No results Matching with $salesexec user !");
                     return redirect()->route('leadselection'); 
            }
            
            //$getprojectnames = $this->getUnsold('123');
                        
             $listfiles = Storage::disk('s3')->files("/newcustomerzoneassets/employeeprofileimage/".$employeeid);             
             if(count($listfiles) > 0){
                $profilepic = config('app.AWS_URL')."/".$listfiles[0];
            }
             else
             {
                $profilepic = config('app.AWS_URL')."/newcustomerzoneassets/img/dummy_male.png";
             }
            
             if ($request->session()->has('selected_lead')) {
              $request->session()->put('forget', $mainarray);  
              $request->session()->put('selected_lead', $mainarray);
            }else{
                $request->session()->put('selected_lead', $mainarray);
            }
            return view('newemployeezone.filtered_lead_select')->with(['getemployeedata'=> $getemployeedata,'mainarray'=>$mainarray,'profilepic' => $profilepic]);
            
               }
        else{
            return redirect()->route('newemployee_home');
        }
    }
    
    public function customercreationstep1(Request $request, $leadno){
        
        if ($request->session()->has('employeesession')) {
            $encrypt = $request->session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $employeeid = $split[0];
            $getemployeedata = DB::connection('mysql6')->table('employee')->where('id', '=', $employeeid)->get();

            $pwd_status = $this->is_emp_didnt_passwordchanged($employeeid);
            if ($pwd_status == 0) {
                $request->session()->flash("error_msg", 'Please change the default password. Only if you Change the default password , other functionalities on this portal will work. This is done for security purposes. Please do not share your password with anyone');
                return redirect()->route('newemployee_mydetails_passchange');
            }
            
            foreach($getemployeedata as $emp){
                $valid = $emp->saleorder;
                $salesexec = $emp->name;
                
            }
            
            if($valid != "1"){
                return redirect()->route('newemployee_dashboard', ['empid' => $employeeid]);
            }
            
            //dd($leadno);
            $mainarray = array();
            if ($request->session()->has('selected_lead')) {
                $getfiltered_leads = $request->session()->get('selected_lead');
                
                if(!empty($getfiltered_leads)){
                    foreach($getfiltered_leads as $filtersalesexc){
                        
                        if($filtersalesexc['Sales_Exe'] == $salesexec){
                            $mainarray[] = $filtersalesexc;
                        }
                    }
                }
                else
                {
                     $request->session()->flash("error_msg", "No results found!");
                     return redirect()->route('leadselection'); 
                }
            }
            else
            {
                return redirect()->route('leadselection');
            }
            
            
            if(count($mainarray) == 0){
                 $request->session()->flash("error_msg", "No results Matching with $salesexec user !");
                     return redirect()->route('leadselection'); 
            }
            else
            {
                $countcheck = 0;
                
                foreach($mainarray as $main){
                    if($main['Lead_No'] == $leadno){
                        $countcheck = '1';
                        $request->session()->forget('selected_onelead');
                        $request->session()->put('selected_onelead', $main);
                    }
                }
                
                if($countcheck != '1'){
                    return redirect()->route('filterleadselection');
                }
            }
            
            if ($request->session()->has('selected_onelead')) {
                //$request->session()->forget('selected_lead');
            }else{
                return redirect()->route('filterleadselection');
            }
            
            //$getprojectnames = $this->getUnsold('123');
                        
             $listfiles = Storage::disk('s3')->files("/newcustomerzoneassets/employeeprofileimage/".$employeeid);             
             if(count($listfiles) > 0){
                $profilepic = config('app.AWS_URL')."/".$listfiles[0];
            }
             else
             {
                $profilepic = config('app.AWS_URL')."/newcustomerzoneassets/img/dummy_male.png";
             }
            
            //dd($mainarray);
            return view('newemployeezone.customercreation_step1')->with(['getemployeedata'=> $getemployeedata,'newleadno'=>$leadno,'profilepic' => $profilepic]);
            
               }
        else{
            return redirect()->route('newemployee_home');
        }
    }
    
    public function postcustomercreationstep1(Request $request, $leadno){
        
        if ($request->session()->has('employeesession')) {
            $encrypt = $request->session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $employeeid = $split[0];
            $getemployeedata = DB::connection('mysql6')->table('employee')->where('id', '=', $employeeid)->get();
            
            foreach($getemployeedata as $emp){
                $valid = $emp->saleorder;
                $salesexec = $emp->name;
                
            }
            
            if($valid != "1"){
                return redirect()->route('newemployee_dashboard', ['empid' => $employeeid]);
            }
            
            
            
            //dd($mainarray);
            if ($request->session()->has('selected_onelead')) {
                
                $getoneselectedlead = $request->session()->get('selected_onelead');
               // dd($getoneselectedlead);
            }else{
                return redirect()->route('filterleadselection');
            }
            
            
            
            
            
            $postedleadno = $request->leadno;
            $panno = $request->panno;
			$passportno = $request->passportno;

											if (ctype_digit($postedleadno)) {

												
				$res = $this->customerleadmove($postedleadno,$panno,$passportno);
												

												$check = $res['Status1'];
												if ($check == '') {
													
													
														if ($res['E_Mail'] != '') {
															$res['leadno'] = $postedleadno;
															$res['PAN_No'] = $panno;
															$res['Passport'] = $passportno;
															//$request->session()->forget('selected_onelead');
                                                            $request->session()->forget('customerdata');
                                                            $request->session()->put('customerdata', $res);
															
                                            return redirect()->route('customercreationstep2');
														}
														else
														{
								return redirect()->route('customercreationstep1');
														}
													

							
												}
												else
												{
													
                     $request->session()->flash("error_msg", $res['Status1']);
                     return redirect()->back(); 
												
												
												
											}
                                            }
            else
            {   
                $request->session()->flash("error_msg", "Error Occured!");
                return redirect()->back(); 
            }
            
            
            
            
            
            
            
            
            
               }
        else{
            return redirect()->route('newemployee_home');
        }
    }
    
    
    
    public function customercreationstep2(Request $request){
        
        if ($request->session()->has('employeesession')) {
            $encrypt = $request->session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $employeeid = $split[0];
            $getemployeedata = DB::connection('mysql6')->table('employee')->where('id', '=', $employeeid)->get();

            $pwd_status = $this->is_emp_didnt_passwordchanged($employeeid);
            if ($pwd_status == 0) {
                $request->session()->flash("error_msg", 'Please change the default password. Only if you Change the default password , other functionalities on this portal will work. This is done for security purposes. Please do not share your password with anyone');
                return redirect()->route('newemployee_mydetails_passchange');
            }
            
            foreach($getemployeedata as $emp){
                $valid = $emp->saleorder;
                $salesexec = $emp->name;
                
            }
            
            if($valid != "1"){
                return redirect()->route('newemployee_dashboard', ['empid' => $employeeid]);
            }
            
           
            
              //dd($mainarray);
            if ($request->session()->has('selected_onelead')) {
                
                $getoneselectedlead = $request->session()->get('selected_onelead');
                
                  //dd($mainarray);
            if ($request->session()->has('customerdata')) {
                
                if($request->session()->has('viewquote')){
                    $request->session()->forget('viewquote');
                }
                
                $getcustomeragain = $request->session()->get('customerdata');
                //dd($getcustomeragain);
                if($getcustomeragain['PAN_No'] == null ){
                    $getcustomeragain['PAN_No'] = '';
                }
                
                if($getcustomeragain['Passport'] == null ){
                    $getcustomeragain['Passport'] = '';
                }
                $res = $this->customerleadmove($getcustomeragain['leadno'],$getcustomeragain['PAN_No'],$getcustomeragain['Passport']);
                //dd($res);
                $res['leadno'] = $getcustomeragain['leadno'];
                $res['PAN_No'] = $getcustomeragain['PAN_No'];
                $res['Passport'] = $getcustomeragain['Passport'];
                
                $request->session()->forget('customerdata');
                $request->session()->put('customerdata',$res);
                $customerdata[0]['result'] = $request->session()->get('customerdata');
                //$customerdata[0]['result']['leadno'] = $getcustomeragain['leadno'];
                //dd($customerdata);
                
                
            }else{
                return redirect()->route('filterleadselection');
            }
                
            }else{
                return redirect()->route('filterleadselection');
            }
                        
             $listfiles = Storage::disk('s3')->files("/newcustomerzoneassets/employeeprofileimage/".$employeeid);             
             if(count($listfiles) > 0){
                $profilepic = config('app.AWS_URL')."/".$listfiles[0];
            }
             else
             {
                $profilepic = config('app.AWS_URL')."/newcustomerzoneassets/img/dummy_male.png";
             }
            
            //dd($mainarray);
            return view('newemployeezone.customercreation_step2')->with(['getemployeedata'=> $getemployeedata,'customer'=>$customerdata,'profilepic' => $profilepic]);
            
               }
        else{
            return redirect()->route('newemployee_home');
        }
    }
    
    public function postcustomercreationstep2(Request $request){
        
        if ($request->session()->has('employeesession')) {
            $encrypt = $request->session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $employeeid = $split[0];
            $getemployeedata = DB::connection('mysql6')->table('employee')->where('id', '=', $employeeid)->get();


            
            foreach($getemployeedata as $emp){
                $valid = $emp->saleorder;
                $salesexec = $emp->name;
                
            }
            
            if($valid != "1"){
                return redirect()->route('newemployee_dashboard', ['empid' => $employeeid]);
            }
            
           
            
              //dd($mainarray);
            if ($request->session()->has('selected_onelead')) {
                
                $getoneselectedlead = $request->session()->get('selected_onelead');
                
                  //dd($mainarray);
            if ($request->session()->has('customerdata')) {
                
                $customerdata[]['result'] = $request->session()->get('customerdata');
               // dd($customerdata);
                
            }else{
                return redirect()->route('customercreationstep1');
            }
                
            }else{
                return redirect()->route('filterleadselection');
            }
            
           // dd($request);
            
            if($request->has('reg')){
                

	$reg = array();
	$reg = $request->get('reg');
	//dd($reg);
	$marital_status = $_POST['marital_status'];
	
	
	if($request->get('gender') == 'male'){ $gender = 'X'; }else{ $gender = '';}
	if($request->get('gender') == 'female'){ $genderfem = 'X'; }else{ $genderfem = '';}
	
	if($request->get('resstatus') == 'residentindian'){ $residentindian = 'X'; }else{ $residentindian = '';}
	if($request->get('resstatus') == 'nonresidentindian'){ $nonresidentindian = 'X'; }else{ $nonresidentindian = '';}
	if($request->get('resstatus') == 'nonpersonofindian'){ $nonpersonofindian = 'X'; }else{ $nonpersonofindian = '';}

	if($request->get('empstatus') == 'salaried'){ $salaried = 'X'; }else{ $salaried = '';}
	if($request->get('empstatus') == 'selfemployed'){ $selfemployed = 'X'; }else{ $selfemployed = '';}
	if($request->get('empstatus') == 'retired'){ $retired = 'X'; }else{ $retired = '';}
	

	if($request->get('industrystatus') == 'indus1'){ $indus1 = 'X'; }else{ $indus1 = '';}
	if($request->get('industrystatus') == 'indus2'){ $indus2 = 'X'; }else{ $indus2 = '';}
	if($request->get('industrystatus') == 'indus3'){ $indus3 = 'X'; }else{ $indus3 = '';}
	if($request->get('industrystatus') == 'indus4'){ $indus4 = 'X'; }else{ $indus4 = '';}
	if($request->get('industrystatus') == 'indus5'){ $indus5 = 'X'; }else{ $indus5 = '';}
	if($request->get('industrystatus') == 'indus6'){ $indus6 = 'X'; }else{ $indus6 = '';}
	if($request->get('industrystatus') == 'indus7'){ $indus7 = 'X'; }else{ $indus7 = '';}
	if($request->get('industrystatus') == 'indus8'){ $indus8 = 'X'; }else{ $indus8 = '';}
	if($request->get('industrystatus') == 'indus9'){ $indus9 = 'X'; }else{ $indus9 = '';}
	if($request->get('industrystatus') == 'indus10'){ $indus10 = 'X'; }else{ $indus10 = '';}
	if($request->get('industrystatus') == 'indus11'){ $indus11 = 'X'; }else{ $indus11 = '';}
	if($request->get('industrystatus') == 'indus12'){ $indus12 = 'X'; }else{ $indus12 = '';}
	if($request->get('industrystatus') == 'indus13'){ $indus13 = 'X'; }else{ $indus13 = '';}
	if($request->get('industrystatus') == 'indus14'){ $indus14 = 'X'; }else{ $indus14 = '';}
	if($request->get('industrystatus') == 'indus15'){ $indus15 = 'X'; }else{ $indus15 = '';}


	if($request->get('industrystatus') != ''){
	 $industrystatus = $request->get('industrystatus');
	 $indus1 = '';
	 $indus2 = '';
	 $indus3 = '';
	 $indus4 = '';
	 $indus5 = '';
	 $indus6 = '';
	 $indus7 = '';
	 $indus8 = '';
	 $indus9 = '';
	 $indus10 = '';
	 $indus11 = '';
	 $indus12 = '';
	 $indus13 = '';
	 $indus14 = '';
	 $indus15 = '';
	 
	 if ($industrystatus == 'indus1') { $indus1 = 'X'; }
	 if ($industrystatus == 'indus2') { $indus2 = 'X'; }
	 if ($industrystatus == 'indus3') { $indus3 = 'X'; }
	 if ($industrystatus == 'indus4') { $indus4 = 'X'; }
	 if ($industrystatus == 'indus5') { $indus5 = 'X'; }
	 if ($industrystatus == 'indus6') { $indus6 = 'X'; }
	 if ($industrystatus == 'indus7') { $indus7 = 'X'; }
	 if ($industrystatus == 'indus8') { $indus8 = 'X'; }
	 if ($industrystatus == 'indus9') { $indus9 = 'X'; }
	 if ($industrystatus == 'indus10') { $indus10 = 'X'; }
	 if ($industrystatus == 'indus11') { $indus11 = 'X'; }
	 if ($industrystatus == 'indus12') { $indus12 = 'X'; }
	 if ($industrystatus == 'indus13') { $indus13 = 'X'; }
	 if ($industrystatus == 'indus14') { $indus14 = 'X'; }
	 if ($industrystatus == 'indus15') { $indus15 = 'X'; }
	 
	}else{ 
		 $indus1 = '';
	 $indus2 = '';
	 $indus3 = '';
	 $indus4 = '';
	 $indus5 = '';
	 $indus6 = '';
	 $indus7 = '';
	 $indus8 = '';
	 $indus9 = '';
	 $indus10 = '';
	 $indus11 = '';
	 $indus12 = '';
	 $indus13 = '';
	 $indus14 = '';
	 $indus15 = '';
	}


	if($request->get('grossincome') != ''){
	 $grossincome = $request->get('grossincome');
	 $gross1 = '';
	 $gross2 = '';
	 $gross3 = '';
	 $gross4 = '';
	 $gross5 = '';
	 $gross6 = '';
	 $gross7 = '';
	 if ($grossincome == 'gross1') { $gross1 = 'X'; }
	 if ($grossincome == 'gross2') { $gross2 = 'X'; }
	 if ($grossincome == 'gross3') { $gross3 = 'X'; }
	 if ($grossincome == 'gross4') { $gross4 = 'X'; }
	 if ($grossincome == 'gross5') { $gross5 = 'X'; }
     if ($grossincome == 'gross6') { $gross6 = 'X'; }
     if ($grossincome == 'gross7') { $gross7 = 'X'; }

	}else{ 
		$gross1 = '';
	 $gross2 = '';
	 $gross3 = '';
	 $gross4 = '';
	 $gross5 = '';
	 $gross6 = '';
	 $gross7 = '';
	}
	

	if($request->get('vehicledetails1') == 'two'){ $vehicle1 = 'X'; }else{ $vehicle1 = '';}
	if($request->get('vehicledetails2') == 'four'){ $vehicle2 = 'X'; }else{ $vehicle2 = '';}

	if($request->get('poboxaddresswono') == 'tick'){ $pobox2 = 'X'; }else{ $pobox2 = '';}
	
	

$final = array();
$final['Title'] = $reg['title'];
$final['Name1'] = $reg['cname1'];
$final['Name2'] = $reg['cname2'];
$final['Name3'] = $reg['cname3'];
$final['Name4'] = $reg['cname4'];
$final['Search1'] = $reg['search1'];
$final['Search2'] = $reg['search2'];
$final['Building_Code'] = $reg['buildcode'];
$final['Room'] = $reg['room'];
$final['Floor'] = $reg['floor'];
$final['C_O'] = $reg['co'];
$final['House_Number'] = $reg['houseno'];
$final['Street1'] = $reg['street1'];
$final['Street2'] = $reg['street2'];
$final['Street3'] = $reg['street3'];
$final['Street4'] = $reg['street4'];
$final['Street5'] = $reg['street5'];
$final['Street6'] = $reg['street6'];
$final['Street7'] = '';
$final['District'] = $reg['district'];
$final['Different_City'] = $reg['diffcity'];
$final['Postal_code'] = $reg['postalcode'];
$final['City'] = $reg['city'];
$final['Country'] = $request->get('country');
$final['Region'] = $request->get('region');
$final['Time_Zone'] = $reg['timezone'];
$final['Tax_Jurisdictn'] = $reg['jurisdiction'];
$final['Transportation_Zone'] = $reg['transpzone'];
$final['Reg_Struct_Grp'] = $reg['regstructgrp'];
$final['Undeliverable'] = $request->get('undeliverable1');

$final['PO_Box1'] = $reg['poboxaddress'];
$final['PO_Box2'] = $pobox2;
$final['PO_Box3'] = $_POST['postbox1'];
$final['PO_Box4'] = $reg['postbox2'];
$final['PO_Box_Lobby'] = $reg['postboxlobby'];
$final['Postal_Code'] = $reg['popostalcode'];
$final['PO_Box_City'] = $reg['poboxcity'];
$final['Other_Country'] = $reg['othercountry'];
$final['PO_Region'] = $reg['poboxregion'];
$final['Company_Postal_Code'] = $reg['companypostalcode'];
$final['Post1'] = $reg['companypostalcode2'];
$final['Post2'] = $reg['companypostalcode3'];
$final['Undeliverable1'] = $request->get('undeliverable2');
$final['Language'] = 'EN';
$final['Telephone'] = $reg['telephone'];
$final['Extension'] = $reg['telephone_ext'];
$final['Mobile_Phone'] = $reg['mobile'];
$final['Fax'] = $reg['fax'];
$final['Extension1'] = $reg['faxext'];
$final['E_Mail'] = $reg['email'];
$final['Comm_Method1'] = $request->get('comm_method');
$final['Comm_Method2'] = $reg['comm_metho2'];
$final['Comm_Method3'] = $reg['comm_metho3'];
$final['Comments'] = $reg['comments'];
$final['DOB'] = str_replace('-', '', $reg['dob']);
$final['Wedding_Anniversary_Day'] = str_replace('-', '', $reg['wedding_anniversary_day']);
$final['Gender1'] = $gender;
$final['Gender2'] = $genderfem;

if ($marital_status == 'single') {
	
$final['Marital_Status1'] = 'X';
$final['Marital_Status2'] = '';
$final['Marital_Status3'] = '';
$final['Marital_Status4'] = '';
$final['Marital_Status5'] = '';
$final['Marital_Status6'] = 'X';
}
if ($marital_status == 'married') {
	
$final['Marital_Status1'] = '';
$final['Marital_Status2'] = 'X';
if ($request->get('noofchildren') == '1') {
	$final['Marital_Status3'] = 'X';
$final['Marital_Status4'] = '';
$final['Marital_Status5'] = '';
$final['Marital_Status6'] = '';
}
if ($request->get('noofchildren') == '2') {
	$final['Marital_Status3'] = '';
$final['Marital_Status4'] = 'X';
$final['Marital_Status5'] = '';
$final['Marital_Status6'] = '';
}
if ($request->get('noofchildren') == '3andabove') {
	$final['Marital_Status3'] = '';
$final['Marital_Status4'] = '';
$final['Marital_Status5'] = 'X';
$final['Marital_Status6'] = '';
}
if ($request->get('noofchildren') == 'none') {
	$final['Marital_Status3'] = '';
$final['Marital_Status4'] = '';
$final['Marital_Status5'] = '';
$final['Marital_Status6'] = 'X';
}

}

$final['Resident_Indian1'] = $residentindian;
$final['Resident_Indian2'] = $nonresidentindian;
$final['Resident_Indian3'] = $nonpersonofindian;
$final['Employment1'] = $salaried;
$final['Employment2'] = $selfemployed;
$final['Employment3'] = $retired;
$final['Industry1'] = $indus1;
$final['Industry2'] = $indus2;
$final['Industry3'] = $indus3;
$final['Industry4'] = $indus4;
$final['Industry5'] = $indus5;
$final['Industry6'] = $indus6;
$final['Industry7'] = $indus7;
$final['Industry8'] = $indus8;
$final['Industry9'] = $indus9;
$final['Industry10'] = $indus10;
$final['Industry11'] = $indus11;
$final['Industry12'] = $indus12;
$final['Industry13'] = $indus13;
$final['Industry14'] = $indus14;
$final['Industry15'] = $indus15;
$final['Gross1'] = $gross1;
$final['Gross2'] = $gross2;
$final['Gross3'] = $gross3;
$final['Gross4'] = $gross4;
$final['Gross5'] = $gross5;
$final['Gross6'] = $gross6;
$final['Gross7'] = $gross7;
$final['Vehicle1'] = $vehicle1;
$final['Vehicle2'] = $vehicle2;
$final['Status1'] = '';
$final['Status2'] = '';
$final['Co_Applicant1'] = $reg['coapp1'];
$final['Co_Applicant2'] = $reg['coapp2'];
$final['Co_Applicant3'] = $reg['coapp3'];
$final['Co_Applicant4'] = $reg['coapp4'];
$final['PAN_No'] = $customerdata[0]['result']['PAN_No'];
$final['Passport'] = $customerdata[0]['result']['Passport'];
$final['Lead_No'] = $customerdata[0]['result']['leadno'];

                foreach($final as $kk => $fin){
                    if($fin == null){
                        $final[$kk] = '';
                    }
                    else
                    {
                        $final[$kk] = $fin;
                    }
                }
                
                //dd($final);
                //dd($customerdata);
$createcustomer = $this->customerleadcreate($final);
//var_dump($createcustomer);
if (strpos($createcustomer['Status'], 'Created') !== false) {
	$getcustomerlead = $this->customerleadmove($customerdata[0]['result']['leadno'],$customerdata[0]['result']['PAN_No'],$customerdata[0]['result']['Passport']);
	//$leadnoget = $customerdata[0]['result']['leadno'];
	//unset($_SESSION['customerdata']);
    //$getnewcustomerlead[0]['result'] = $getcustomerlead;
    $getcustomerlead['leadno'] = $customerdata[0]['result']['leadno'];
    $getcustomerlead['PAN_No'] = $customerdata[0]['result']['PAN_No'];
    $getcustomerlead['Passport'] = $customerdata[0]['result']['Passport'];
    $request->session()->forget('customerdata');
    $request->session()->put('customerdata',$getcustomerlead);
    $customerdata[0]['result'] = $request->session()->get('customerdata');
    
    
	//$getcustomerlead['result']['leadno'] = $leadnoget;
	//$_SESSION['customerdata'] = $getcustomerlead;

    //echo '<div align="center"><suc>'.$createcustomer['result']['Status'].'</suc></div>';
    
                $request->session()->flash("suc_msg", $createcustomer['Status']);
                return redirect()->back(); 

//echo '<script> setTimeout(function(){ window.location.href="customer_creation.php" }, 3000);</script>';
}
else
{
	  $request->session()->flash("error_msg", $createcustomer['Status']);
                return redirect()->back(); 
}



}
            
            
            
                        
             
            
            
            
            
            
            }
        else{
            return redirect()->route('newemployee_home');
        }
        
    }
    
    
    public function saleorderconversion(Request $request){
        
        if ($request->session()->has('employeesession')) {
            $encrypt = $request->session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $employeeid = $split[0];
            $getemployeedata = DB::connection('mysql6')->table('employee')->where('id', '=', $employeeid)->get();

            $pwd_status = $this->is_emp_didnt_passwordchanged($employeeid);
            if ($pwd_status == 0) {
                $request->session()->flash("error_msg", 'Please change the default password. Only if you Change the default password , other functionalities on this portal will work. This is done for security purposes. Please do not share your password with anyone');
                return redirect()->route('newemployee_mydetails_passchange');
            }
            
            foreach($getemployeedata as $emp){
                $valid = $emp->saleorder;
                $salesexec = $emp->name;
                
            }
            
            if($valid != "1"){
                return redirect()->route('newemployee_dashboard', ['empid' => $employeeid]);
            }
            
           
            
              //dd($mainarray);
            if ($request->session()->has('selected_onelead')) {
                $paymentlistarray = array();
                    $unitlistarray = array();
                
                $getoneselectedlead = $request->session()->get('selected_onelead');
                
                  //dd($mainarray);
            if ($request->session()->has('customerdata')) {
                $getprojectnames = $this->getUnsold('123');
                
                $getcustomeragain = $request->session()->get('customerdata');
                //dd($getcustomeragain);
                if($getcustomeragain['PAN_No'] == null ){
                    $getcustomeragain['PAN_No'] = '';
                }
                
                if($getcustomeragain['Passport'] == null ){
                    $getcustomeragain['Passport'] = '';
                }
                $res = $this->customerleadmove($getcustomeragain['leadno'],$getcustomeragain['PAN_No'],$getcustomeragain['Passport']);
                //dd($res);
                $res['leadno'] = $getcustomeragain['leadno'];
                $res['PAN_No'] = $getcustomeragain['PAN_No'];
                $res['Passport'] = $getcustomeragain['Passport'];
                
                $request->session()->forget('customerdata');
                $request->session()->put('customerdata',$res);
                $customerdata[0]['result'] = $request->session()->get('customerdata');
                //$customerdata[0]['result']['leadno'] = $getcustomeragain['leadno'];
                //dd($customerdata);
                
                if($request->session()->has('quotefile')) {
                    $uploaded = 'Valid';
                }
                else
                {
                    $uploaded = 'Not Valid';
                }
                
                if($request->session()->has('viewquote')) {
                    $selectedviewquote = $request->session()->get('viewquote');
                    //dd($selectedviewquote);
                    $getunitlist = $this->getsaleorderunits($selectedviewquote['selectedplant']);
                    $getunitlist = $getunitlist['DATA'];

$getpaymenttermslist = $this->getsaleorderpaymentterms($selectedviewquote['selectedplant']);
                                            

			//$getpaymenttermslist = $getpaymenttermslist['result']['DATA'];
                    $paymentlistarray = array();
                    $unitlistarray = array();
            
												if (array_key_exists('0', $getpaymenttermslist['DATA'])) {
													
													$paymentlistarray =  $getpaymenttermslist['DATA'];
												}
												else
												{
													$paymentlistarray[0] =  $getpaymenttermslist['DATA'];
												}
                    
                    if (array_key_exists('0', $getunitlist)) {
													
													$unitlistarray =  $getunitlist;
												}
												else
												{
													$unitlistarray[0] =  $getunitlist;
												}
                    
                }
                else
                {
                    $selectedviewquote = array();
                }
                
                
            }else{
                return redirect()->route('filterleadselection');
            }
                
            }else{
                return redirect()->route('filterleadselection');
            }
                        
             $listfiles = Storage::disk('s3')->files("/newcustomerzoneassets/employeeprofileimage/".$employeeid);             
             if(count($listfiles) > 0){
                $profilepic = config('app.AWS_URL')."/".$listfiles[0];
            }
             else
             {
                $profilepic = config('app.AWS_URL')."/newcustomerzoneassets/img/dummy_male.png";
             }
            
            //dd($getunitlist);
            return view('newemployeezone.saleorderconversion')->with(['getemployeedata'=> $getemployeedata,'customer'=>$customerdata,'getprojectnames' =>$getprojectnames,'uploaded' => $uploaded,'getunitlist' =>$unitlistarray,'paymentlistarray'=>$paymentlistarray,'selectedviewquote'=>$selectedviewquote,'profilepic' => $profilepic]);
            
               }
        else{
            return redirect()->route('newemployee_home');
        }
    }
    
    
    
    public function uploadsaleorderfile(Request $request){
        
        if ($request->session()->has('employeesession')) {
            $encrypt = $request->session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $employeeid = $split[0];
            $getemployeedata = DB::connection('mysql6')->table('employee')->where('id', '=', $employeeid)->get();
            
            $pwd_status = $this->is_emp_didnt_passwordchanged($employeeid);
            if ($pwd_status == 0) {
                $request->session()->flash("error_msg", 'Please change the default password. Only if you Change the default password , other functionalities on this portal will work. This is done for security purposes. Please do not share your password with anyone');
                return redirect()->route('newemployee_mydetails_passchange');
            }

            foreach($getemployeedata as $emp){
                $valid = $emp->saleorder;
                $salesexec = $emp->name;
                
            }
            
            if($valid != "1"){
                return redirect()->route('newemployee_dashboard', ['empid' => $employeeid]);
            }
            
           
            
              //dd($mainarray);
            if ($request->session()->has('selected_onelead')) {
                
                $getoneselectedlead = $request->session()->get('selected_onelead');
                
                  //dd($mainarray);
            if ($request->session()->has('customerdata')) {
                
                if($request->session()->has('viewquote')) {
                    $selectedviewquote = $request->session()->get('viewquote');
                }else
                {
                    return redirect()->route('filterleadselection');
                }
                $customerdata = $request->session()->get('customerdata');
                
                //dd($request);
                
                
                $customercode = $customerdata['Status2'];
      $errors= array();
      $success= array();

      $dir = "customersignedpdf/".$customercode;

     
     

      $file_namecheck = $_FILES['customersignedpdf']['name'];
      if (count($file_namecheck) > 0) {
      	
      	for($i=0; $i<count($file_namecheck); $i++) {

      		$file_name = $_FILES['customersignedpdf']['name'][$i];
      		$file_size =$_FILES['customersignedpdf']['size'][$i];
      $file_tmp =$_FILES['customersignedpdf']['tmp_name'][$i];
      $file_type=$_FILES['customersignedpdf']['type'][$i];
            
           
            
      
      $file_ext=strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
      
      $expensions= array("pdf", "doc", "docx", "jpg","jpeg", "png");
      
      if(in_array($file_ext,$expensions)=== false){
         $errors[]="Please choose a file with extension of pdf,doc,docx,jpg,jpeg,png.";
      }
      
      if($file_size > 8097152){
         $errors[]=$file_name.' size must be less than 8 MB';
      }

       if (!is_dir($dir)) {
      	mkdir($dir);
      }
      
      if(empty($errors)==true){

      	$totlafilesindir = glob($dir . '/*.*');

      	if ( $totlafilesindir !== false )
		{
		    $filecount = count( $totlafilesindir );
		}
		else
		{
		    $filecount = 1;
		}
          
          $sappath = $file_tmp."/".$file_name;
          //fopen($file_tmp, 'r');
           //$uploadtosap = uploadsaleorderfile($sappath);
            
          //var_dump($sappath);
            //var_dump($uploadtosap);
		
		$newfilename = $customercode.'_'.$filecount.'.'.$file_ext;
         move_uploaded_file($file_tmp,"$dir/".$newfilename);
         $success[] = 'Success';
         $filecount++;
      }

      	}

      }
      else
      {

      $file_size =$_FILES['customersignedpdf']['size'];
      $file_tmp =$_FILES['customersignedpdf']['tmp_name'];
      $file_type=$_FILES['customersignedpdf']['type'];
      
      $file_ext=strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
      
      $expensions= array("pdf", "doc", "docx", "jpg","jpeg", "png");
      
      if(in_array($file_ext,$expensions)=== false){
         $errors[]="Please choose a file with extension of pdf,doc,docx,jpg,jpeg,png.";
      }
      
      if($file_size > 8097152){
         $errors[]='File size must be less than 8 MB';
      }

       if (!is_dir($dir)) {
      	mkdir($dir);
      }
      
      if(empty($errors)==true){
         
      	$totlafilesindir = glob($dir . '/*.*');

      	if ( $totlafilesindir !== false )
		{
		    $filecount = count( $totlafilesindir );
		}
		else
		{
		    $filecount = 1;
		}
          
           //$uploadtosap = uploadsaleorderfile($file_tmp.'/'.$customercode.'.'.$file_ext);
          //$uploadtosap = uploadsaleorderfile("C:\Users\Public\Pictures\Sample Pictures\Hydrangeas.jpg");
          
            
            //var_dump($uploadtosap);
		
		$newfilename = $customercode.'_'.$filecount.'.'.$file_ext;
         move_uploaded_file($file_tmp,"$dir/".$newfilename);
         $success[] = 'Success';
         $filecount++;


      }

      }

      if (count($success) > 0) {
      	
          $request->session()->flash("suc_msg", "Successfully Uploaded");
                return redirect()->back(); 
      }

      if (count($errors) > 0) {
          $main = '';
      	//echo '<div class="row"><div class="col-sm-8 col-sm-offset-2"><err>';
      	foreach ($errors as $key => $value) {
      		$main .= $value.'<br>';
      	}
      	//echo '</err></div></div>';
          
          $request->session()->flash("error_msg", $main);
                return redirect()->back(); 
      }
		  

			

			
	
                
                
            }else{
                return redirect()->route('filterleadselection');
            }
                
            }else{
                return redirect()->route('filterleadselection');
            }
                        
             $listfiles = Storage::disk('s3')->files("/newcustomerzoneassets/employeeprofileimage/".$employeeid);             
             if(count($listfiles) > 0){
                $profilepic = config('app.AWS_URL')."/".$listfiles[0];
            }
             else
             {
                $profilepic = config('app.AWS_URL')."/newcustomerzoneassets/img/dummy_male.png";
             }
            
            //dd($mainarray);
            return view('newemployeezone.saleorderconversion')->with(['getemployeedata'=> $getemployeedata,'customer'=>$customerdata,'getprojectnames' =>$getprojectnames,'uploaded' => $uploaded,'profilepic' => $profilepic]);
            
               }
        else{
            return redirect()->route('newemployee_home');
        }
    }
    
    public function createsaleorder(Request $request){
        
        if ($request->session()->has('employeesession')) {
            $encrypt = $request->session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $employeeid = $split[0];
            $getemployeedata = DB::connection('mysql6')->table('employee')->where('id', '=', $employeeid)->get();
            
            foreach($getemployeedata as $emp){
                $valid = $emp->saleorder;
                $salesexec = $emp->name;
                
            }
            
            if($valid != "1"){
                return redirect()->route('newemployee_dashboard', ['empid' => $employeeid]);
            }
            
           
            
              //dd($mainarray);
            if ($request->session()->has('selected_onelead')) {
                
                $getoneselectedlead = $request->session()->get('selected_onelead');
                
                  //dd($mainarray);
            if ($request->session()->has('customerdata')) {
                
                if($request->session()->has('viewquote')) {
                    $selectedviewquote = $request->session()->get('viewquote');
                }else
                {
                    return redirect()->route('filterleadselection');
                }
                $customerdata = $request->session()->get('customerdata');
                //dd($customerdata);
                $createsale = $this->convertsaleorder($selectedviewquote['selectedplant'],$selectedviewquote['selectedunit'],$customerdata['Status2'],$customerdata['leadno'],$selectedviewquote['selectedpaymentterms'] );

				

				if (strpos($createsale['Status1'], '/E') !== false) {
  						$stringreplace = str_replace('/E', '', $createsale['Status1']);
  						
                    
                    $request->session()->flash("error_msg", $stringreplace);
                return redirect()->back();
				}
				else
				{
					                    
                    $request->session()->flash("suc_msg", $createsale['Status1']);
                return redirect()->back();
				}
                
                
       
		  

			

			
	
                
                
            }else{
                return redirect()->route('filterleadselection');
            }
                
            }else{
                return redirect()->route('filterleadselection');
            }
                        
            
            
            
            
               }
        else{
            return redirect()->route('newemployee_home');
        }
    }
    
    
    public function viewuploadedsaleorderfiles(Request $request){
        
        if ($request->session()->has('employeesession')) {
            $encrypt = $request->session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $employeeid = $split[0];
            $getemployeedata = DB::connection('mysql6')->table('employee')->where('id', '=', $employeeid)->get();

            $pwd_status = $this->is_emp_didnt_passwordchanged($employeeid);
            if ($pwd_status == 0) {
                $request->session()->flash("error_msg", 'Please change the default password. Only if you Change the default password , other functionalities on this portal will work. This is done for security purposes. Please do not share your password with anyone');
                return redirect()->route('newemployee_mydetails_passchange');
            }
            
            foreach($getemployeedata as $emp){
                $valid = $emp->saleorder;
                $salesexec = $emp->name;
                
            }
            
            if($valid != "1"){
                return redirect()->route('newemployee_dashboard', ['empid' => $employeeid]);
            }
            
           
            
              //dd($mainarray);
            if ($request->session()->has('selected_onelead')) {
                
                $getoneselectedlead = $request->session()->get('selected_onelead');
                
                  //dd($mainarray);
            if ($request->session()->has('customerdata')) {
                
                $customerdata = $request->session()->get('customerdata');
                
		  //$projectcode = $request->projectcode;

			//$getunitlist = $this->getsaleorderunits($projectcode);

			//return json_encode($getunitlist['DATA']);
	
                
                
            }else{
                return redirect()->route('filterleadselection');
            }
                
            }else{
                return redirect()->route('filterleadselection');
            }
                        
             $listfiles = Storage::disk('s3')->files("/newcustomerzoneassets/employeeprofileimage/".$employeeid);             
             if(count($listfiles) > 0){
                $profilepic = config('app.AWS_URL')."/".$listfiles[0];
            }
             else
             {
                $profilepic = config('app.AWS_URL')."/newcustomerzoneassets/img/dummy_male.png";
             }
            
            //dd($mainarray);
            return view('newemployeezone.viewuploadedsaleorderfiles')->with(['getemployeedata'=> $getemployeedata,'customerdata'=>$customerdata,'profilepic' => $profilepic]);
            
               }
        else{
            return redirect()->route('newemployee_home');
        }
    }
    
    public function getunits(Request $request){
        
        if ($request->session()->has('employeesession')) {
            $encrypt = $request->session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $employeeid = $split[0];
            $getemployeedata = DB::connection('mysql6')->table('employee')->where('id', '=', $employeeid)->get();

            $pwd_status = $this->is_emp_didnt_passwordchanged($employeeid);
            if ($pwd_status == 0) {
                $request->session()->flash("error_msg", 'Please change the default password. Only if you Change the default password , other functionalities on this portal will work. This is done for security purposes. Please do not share your password with anyone');
                return redirect()->route('newemployee_mydetails_passchange');
            }
            
            foreach($getemployeedata as $emp){
                $valid = $emp->saleorder;
                $salesexec = $emp->name;
                
            }
            
            if($valid != "1"){
                return redirect()->route('newemployee_dashboard', ['empid' => $employeeid]);
            }
            
           
            
              //dd($mainarray);
            if ($request->session()->has('selected_onelead')) {
                
                $getoneselectedlead = $request->session()->get('selected_onelead');
                
                  //dd($mainarray);
            if ($request->session()->has('customerdata')) {
                
                
                
		  $projectcode = $request->projectcode;

			$getunitlist = $this->getsaleorderunits($projectcode);

			return json_encode($getunitlist['DATA']);
	
                
                
            }else{
                return redirect()->route('filterleadselection');
            }
                
            }else{
                return redirect()->route('filterleadselection');
            }
                        
             $listfiles = Storage::disk('s3')->files("/newcustomerzoneassets/employeeprofileimage/".$employeeid);             
             if(count($listfiles) > 0){
                $profilepic = config('app.AWS_URL')."/".$listfiles[0];
            }
             else
             {
                $profilepic = config('app.AWS_URL')."/newcustomerzoneassets/img/dummy_male.png";
             }
            
            //dd($mainarray);
            return view('newemployeezone.saleorderconversion')->with(['getemployeedata'=> $getemployeedata,'customer'=>$customerdata,'getprojectnames' =>$getprojectnames,'uploaded' => $uploaded,'profilepic' => $profilepic]);
            
               }
        else{
            return redirect()->route('newemployee_home');
        }
    }
    
    public function getpaymentterms(Request $request){
        
        if ($request->session()->has('employeesession')) {
            $encrypt = $request->session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $employeeid = $split[0];
            $getemployeedata = DB::connection('mysql6')->table('employee')->where('id', '=', $employeeid)->get();

            $pwd_status = $this->is_emp_didnt_passwordchanged($employeeid);
            if ($pwd_status == 0) {
                $request->session()->flash("error_msg", 'Please change the default password. Only if you Change the default password , other functionalities on this portal will work. This is done for security purposes. Please do not share your password with anyone');
                return redirect()->route('newemployee_mydetails_passchange');
            }
            
            foreach($getemployeedata as $emp){
                $valid = $emp->saleorder;
                $salesexec = $emp->name;
                
            }
            
            if($valid != "1"){
                return redirect()->route('newemployee_dashboard', ['empid' => $employeeid]);
            }
            
           
            
              //dd($mainarray);
            if ($request->session()->has('selected_onelead')) {
                
                $getoneselectedlead = $request->session()->get('selected_onelead');
                
                  //dd($mainarray);
            if ($request->session()->has('customerdata')) {
                
                
                
		  $projectcode = $request->projectcode;
                
                
			$getpaymenttermslist = $this->getsaleorderpaymentterms($projectcode);

			return json_encode($getpaymenttermslist['DATA']);
	
                
                
            }else{
                return redirect()->route('filterleadselection');
            }
                
            }else{
                return redirect()->route('filterleadselection');
            }
                        
             $listfiles = Storage::disk('s3')->files("/newcustomerzoneassets/employeeprofileimage/".$employeeid);             
             if(count($listfiles) > 0){
                $profilepic = config('app.AWS_URL')."/".$listfiles[0];
            }
             else
             {
                $profilepic = config('app.AWS_URL')."/newcustomerzoneassets/img/dummy_male.png";
             }
            
            //dd($mainarray);
            return view('newemployeezone.saleorderconversion')->with(['getemployeedata'=> $getemployeedata,'customer'=>$customerdata,'getprojectnames' =>$getprojectnames,'uploaded' => $uploaded,'profilepic' => $profilepic]);
            
               }
        else{
            return redirect()->route('newemployee_home');
        }
    }
    
    public function getIndianCurrency($number)
{
	$number = (float) $number;
    $decimal = round($number - ($no = floor($number)), 2) * 100;
    $hundred = null;
    $digits_length = strlen($no);
    $i = 0;
    $str = array();
    $words = array(0 => '', 1 => 'one', 2 => 'two',
        3 => 'three', 4 => 'four', 5 => 'five', 6 => 'six',
        7 => 'seven', 8 => 'eight', 9 => 'nine',
        10 => 'ten', 11 => 'eleven', 12 => 'twelve',
        13 => 'thirteen', 14 => 'fourteen', 15 => 'fifteen',
        16 => 'sixteen', 17 => 'seventeen', 18 => 'eighteen',
        19 => 'nineteen', 20 => 'twenty', 30 => 'thirty',
        40 => 'forty', 50 => 'fifty', 60 => 'sixty',
        70 => 'seventy', 80 => 'eighty', 90 => 'ninety');
    $digits = array('', 'hundred','thousand','lakh', 'crore');
    while( $i < $digits_length ) {
        $divider = ($i == 2) ? 10 : 100;
        $number = floor($no % $divider);
        $no = floor($no / $divider);
        $i += $divider == 10 ? 1 : 2;
        if ($number) {
            $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
            $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
            $str [] = ($number < 21) ? $words[$number].' '. $digits[$counter]. $plural.' '.$hundred:$words[floor($number / 10) * 10].' '.$words[$number % 10]. ' '.$digits[$counter].$plural.' '.$hundred;
        } else $str[] = null;
    }
    $Rupees = implode('', array_reverse($str));
    $paise = ($decimal) ? "." . ($words[$decimal / 10] . " " . $words[$decimal % 10]) . ' Paise' : '';
    return ($Rupees ? $Rupees . 'Rupees ' : '') . $paise;
}
    
    public function viewquote(Request $request){
        
        if ($request->session()->has('employeesession')) {
            $encrypt = $request->session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $employeeid = $split[0];
            $getemployeedata = DB::connection('mysql6')->table('employee')->where('id', '=', $employeeid)->get();

            $pwd_status = $this->is_emp_didnt_passwordchanged($employeeid);
            if ($pwd_status == 0) {
                $request->session()->flash("error_msg", 'Please change the default password. Only if you Change the default password , other functionalities on this portal will work. This is done for security purposes. Please do not share your password with anyone');
                return redirect()->route('newemployee_mydetails_passchange');
            }
            
            foreach($getemployeedata as $emp){
                $valid = $emp->saleorder;
                $salesexec = $emp->name;
                
            }
            
            if($valid != "1"){
                return redirect()->route('newemployee_dashboard', ['empid' => $employeeid]);
            }
            
           
            
              //dd($mainarray);
            if ($request->session()->has('selected_onelead')) {
                
                $getoneselectedlead = $request->session()->get('selected_onelead');
                
                  //dd($mainarray);
            if ($request->session()->has('customerdata')) {
                
                $getcustomeragain = $request->session()->get('customerdata');
                //dd($getcustomeragain);
                if($getcustomeragain['PAN_No'] == null ){
                    $getcustomeragain['PAN_No'] = '';
                }
                
                if($getcustomeragain['Passport'] == null ){
                    $getcustomeragain['Passport'] = '';
                }
                $res = $this->customerleadmove($getcustomeragain['leadno'],$getcustomeragain['PAN_No'],$getcustomeragain['Passport']);
                //dd($res);
                $res['leadno'] = $getcustomeragain['leadno'];
                $res['PAN_No'] = $getcustomeragain['PAN_No'];
                $res['Passport'] = $getcustomeragain['Passport'];
                
                $request->session()->forget('customerdata');
                $request->session()->put('customerdata',$res);
                $customerdata[0]['result'] = $request->session()->get('customerdata');
                //$customerdata[0]['result']['leadno'] = $getcustomeragain['leadno'];
                //dd($customerdata);
                
                if ($customerdata[0]['result']['Status2'] == '') {
		return redirect()->route('customercreationstep2');
	}
                
                $projectno = $request->get('plantcode');
				$unitno = str_pad($request->get('unitno'), 8,'0',STR_PAD_LEFT);
				$paymentterms = $request->get('paymentterms');
				
				//$newone = $projectno.'/'.$unitno.'/'.$paymentterms.'/'.$customerdata[0]['result']['Status2'].'/'.$customerdata[0]['result']['leadno'];
                
                //dd($newone);
				
				$result = $this->viewquotetrait($projectno,$unitno,$paymentterms,$customerdata[0]['result']['Status2'],$customerdata[0]['result']['leadno']);
				if ($result['Comp_Name'] == '') {
					
                    $request->session()->flash("error_msg", $result['Status']);
					return redirect()->back();

				}
				//var_dump($result['result']);

				$qgenerationdate = $result['Quotation_Generation_Date'];
				//exit();

				if ($result['Comp_Name'] != '') {
                    $request->session()->forget('viewquote');
                    
				$main['upload'] = 'Valid';
				

				$main['selectedplant'] = $request->get('plantcode');
				$main['selectedunit'] = $request->get('unitno');
				$main['selectedpaymentterms'] = $request->get('paymentterms');
                    $request->session()->put('viewquote',$main);
				}
                
                
                
                
                
            }else{
                return redirect()->route('customercreationstep1');
            }
                
            }else{
                return redirect()->route('filterleadselection');
            }
                        
             $listfiles = Storage::disk('s3')->files("/newcustomerzoneassets/employeeprofileimage/".$employeeid);             
             if(count($listfiles) > 0){
                $profilepic = config('app.AWS_URL')."/".$listfiles[0];
            }
             else
             {
                $profilepic = config('app.AWS_URL')."/newcustomerzoneassets/img/dummy_male.png";
             }
            
           
            //dd($mainarray);
            $mainres['result'] = $result;
             $amount = strtoupper($this->getIndianCurrency($mainres['result']['PRICE'][count($mainres['result']['PRICE']) -1]['AMOUNT']));
            //dd($amount);
            
            return view('newemployeezone.viewquote')->with(['getemployeedata'=> $getemployeedata,'result'=>$mainres,'qgenerationdate' =>$qgenerationdate,'amount' => $amount,'profilepic' => $profilepic]);
            
               }
        else{
            return redirect()->route('newemployee_home');
        }
    }

    public function viewschedulesitevisitmap($leadno, $mobile){
        
        $name = "Naveen";
        $emailid = "naveenven23@gmail.com";

         $getleadnolead = DB::connection('mysql6')->table('customer_sitevisit')->where(['leadno'=>$leadno])->get();

         if (count($getleadnolead) != 0) {

            foreach ($getleadnolead as $key => $value) {
                $attempt = $value->attempt;
                
            }

            if ($attempt != 0) {
                //return redirect()->route('postedsitevisit',['leadno'=>$leadno,'mobile'=>$mobile]);
                return ['valid'=>0];
            }
             
         }
         $res = ['leadno'=>$leadno,'mobile'=>$mobile, 'name'=>$name, 'emailid'=>$emailid,'valid'=>1];
         return $res;
        //return view('newemployeezone.schedulesitevisit')->with(['leadno'=>$leadno,'mobile'=>$mobile, 'name'=>$name, 'emailid'=>$emailid]);
    }
    
    public function getviewquote(){
        return redirect()->route('saleorderconversion');
    }
    
    public function getleadstypedata(Request $request, $type){
        
        if ($request->session()->has('employeesession')) {
            $encrypt = $request->session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $employeeid = $split[0];
            $getemployeedata = DB::connection('mysql6')->table('employee')->where('id', '=', $employeeid)->get();
            $pwd_status = $this->is_emp_didnt_passwordchanged($employeeid);
            if ($pwd_status == 0) {
                $request->session()->flash("error_msg", 'Please change the default password. Only if you Change the default password , other functionalities on this portal will work. This is done for security purposes. Please do not share your password with anyone');
                return redirect()->route('newemployee_mydetails_passchange');
            }
            
            foreach($getemployeedata as $emp){
                $valid = $emp->saleorder;
                $empname = $emp->name;
                
            }
            
            if($valid != "1"){
                return redirect()->route('newemployee_dashboard', ['empid' => $employeeid]);
            }

            if($request->session()->has('leadsfollowupviewquote')){
                
            $request->session()->forget('leadsfollowupviewquote');
            
           }

	    if ($request->session()->has('leadsfollowup_plantselection'))  {
                    $selectedplant = $request->session()->get('leadsfollowup_plantselection');
                }
                else{
                    return redirect()->route('leadsfollowup');
                }
            
            
            if(($type == 'hot')||($type == 'warm')||($type == 'underfollowup')){
                
            }
            else
            {
                return redirect()->route('leadsfollowup');
            }
            
            if($type == 'underfollowup'){
                $type = '';
            }
            
            $getdata = $this->getleadsfollowup($type,$empname);
            $mainarray = array();
            //dd($getdata);
            if(!empty($getdata)){
                
                if(array_key_exists('0',$getdata['LEADS_FOLLOWUP_DETAILS'] )){
                    $mainarray = $getdata['LEADS_FOLLOWUP_DETAILS'];
                }
                else
                {
                    $mainarray[0] = $getdata['LEADS_FOLLOWUP_DETAILS'];
                }
            }
                        
             $listfiles = Storage::disk('s3')->files("/newcustomerzoneassets/employeeprofileimage/".$employeeid);             
             if(count($listfiles) > 0){
                $profilepic = config('app.AWS_URL')."/".$listfiles[0];
            }
             else
             {
                $profilepic = config('app.AWS_URL')."/newcustomerzoneassets/img/dummy_male.png";
             }

             $getprojectnames = $this->getUnsold('123');
            if($type == ''){
                $type = 'Under Followup';
            }
            
            return view('newemployeezone.getleadstypeddata')->with(['getemployeedata'=> $getemployeedata,'mainarray'=>$mainarray,'type'=>$type,'getprojectnames' => $getprojectnames,'profilepic' => $profilepic,'selectedplant' => $selectedplant]);
            
               }
        else{
            return redirect()->route('newemployee_home');
        }
    }

    public function postexpecteddob(Request $request)
    {
        if ($request->session()->has('employeesession')) {
            $encrypt = $request->session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $employeeid = $split[0];
            $getemployeedata = DB::connection('mysql6')->table('employee')->where('id', '=', $employeeid)->get();
            
            foreach($getemployeedata as $emp){
                $valid = $emp->saleorder;
                $empname = $emp->name;
                
            }
            
            if($valid != "1"){
                return 0;
            }

        //$leadno = $request->leadno;
        $exp_dateob = $request->exp_dateob;
        $newarr = [];
        foreach ($exp_dateob as $key => $value) {
            $newarr['Details'][$key]['Emp_ID'] = $empname;
            $newarr['Details'][$key]['Lead_No'] = $value['Lead_No'];
            $newarr['Details'][$key]['Expected_Booking_Date'] = $value['Expected_Booking_Date'];

        }
        
        $status = $this->update_expected_dateofbooking($newarr);


        
        if ($status['Status'] == 'Updated Successfully') {
            return 1;
        }

        return 0;

    }
    else{
        return redirect()->route('newemployee_home');
    }

    }

    public function postforapproval_mngr(Request $request)
    {
        if ($request->session()->has('employeesession')) {
            $encrypt = $request->session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $employeeid = $split[0];
            $getemployeedata = DB::connection('mysql6')->table('employee')->where('id', '=', $employeeid)->get();


            
            foreach($getemployeedata as $emp){
                $valid = $emp->saleorder;
                $empname = $emp->name;
                
            }
            
            if($valid != "1"){
                return 0;
            }

        $leadno = $request->leadno;
        $forapproval = $request->forapproval;
        $date = Carbon::now()->toDateString();
        $time = Carbon::now()->toTimeString();
        $status = $this->forupdatemngr_coldapproval($leadno, $forapproval, $date, $time);
        
        if ($status['Status'] == 'Updated Successfully') {
            return 1;
        }

        return 0;

    }
    else{
        return redirect()->route('newemployee_home');
    }

    }

    public function requestforcoldapproval(Request $request)
    {
        if ($request->session()->has('employeesession')) {
            $encrypt = $request->session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $employeeid = $split[0];
            $getemployeedata = DB::connection('mysql6')->table('employee')->where('id', '=', $employeeid)->get();

            $pwd_status = $this->is_emp_didnt_passwordchanged($employeeid);
            if ($pwd_status == 0) {
                $request->session()->flash("error_msg", 'Please change the default password. Only if you Change the default password , other functionalities on this portal will work. This is done for security purposes. Please do not share your password with anyone');
                return redirect()->route('newemployee_mydetails_passchange');
            }
            
            foreach($getemployeedata as $emp){
                $valid = $emp->saleorder;
                $empname = $emp->name;
            }

	    if ($request->session()->has('leadsfollowup_plantselection'))  {
                    $selectedplant = $request->session()->get('leadsfollowup_plantselection');
                }
                else{
                    return redirect()->route('leadsfollowup');
                }

              $listfiles = Storage::disk('s3')->files("/newcustomerzoneassets/employeeprofileimage/".$employeeid);             
             if(count($listfiles) > 0){
                $profilepic = config('app.AWS_URL')."/".$listfiles[0];
            }
             else
             {
                $profilepic = config('app.AWS_URL')."/newcustomerzoneassets/img/dummy_male.png";
             }
            
            $dbquery = $this->requestforcoldapproval_data($employeeid);
           
            

            if($valid != "1"){
                return redirect()->route('newemployee_dashboard', ['empid' => $employeeid]);
            }
        //ZSD_MNGR_Table
          //  $apprv_list = 
            
        if (!empty($dbquery)) {
            $mngr_data = [];
            if (array_key_exists('0', $dbquery['ZSD_MNGR_Table']) === true) {
                $mngr_data = $dbquery['ZSD_MNGR_Table'];
            }
            else{
                $mngr_data[0] = $dbquery['ZSD_MNGR_Table'];   
            }
            
            //dd($mngr_data);
            return view('newemployeezone.requestforcoldapproval')->with(['getemployeedata'=> $getemployeedata,'mngrdata'=>$mngr_data,'profilepic' => $profilepic,'selectedplant' => $selectedplant]);
            
        }else{
            return redirect()->route('newemployee_dashboard', ['empid' => $employeeid]);
        }
        
       

    }
    else{
        return redirect()->route('newemployee_home');
    }

    }


     public function getsingleunits(Request $request){
        
        if ($request->session()->has('employeesession')) {
            $encrypt = $request->session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $employeeid = $split[0];
            $getemployeedata = DB::connection('mysql6')->table('employee')->where('id', '=', $employeeid)->get();
            
            foreach($getemployeedata as $emp){
                $valid = $emp->saleorder;
                $salesexec = $emp->name;
                
            }
            
            if($valid != "1"){
                return '';
            }
            
           
            
                
                
                
          $projectcode = $request->projectcode;

            $getunitlist = $this->getsaleorderunits($projectcode);

            return json_encode($getunitlist['DATA']);
    
            
                        
             
            
            
            
               }
        else{
            return redirect()->route('newemployee_home');
        }
    }

    public function leadsfollowup(Request $request, $plantcode = null){
         if ($request->session()->has('employeesession')) {
            $encrypt = $request->session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $employeeid = $split[0];
            $getemployeedata = DB::connection('mysql6')->table('employee')->where('id', '=', $employeeid)->get();

            $pwd_status = $this->is_emp_didnt_passwordchanged($employeeid);
            if ($pwd_status == 0) {
                $request->session()->flash("error_msg", 'Please change the default password. Only if you Change the default password , other functionalities on this portal will work. This is done for security purposes. Please do not share your password with anyone');
                return redirect()->route('newemployee_mydetails_passchange');
            }
            
            foreach($getemployeedata as $emp){
                $valid = $emp->saleorder;
                $empname = $emp->name;
                
            }
            
            if($valid != "1"){
                return redirect()->route('newemployee_dashboard', ['empid' => $employeeid]);
            }

             $listfiles = Storage::disk('s3')->files("/newcustomerzoneassets/employeeprofileimage/".$employeeid);             
             if(count($listfiles) > 0){
                $profilepic = config('app.AWS_URL')."/".$listfiles[0];
            }
             else
             {
                $profilepic = config('app.AWS_URL')."/newcustomerzoneassets/img/dummy_male.png";
             }
            
            if ($plantcode == null) {
                if ($request->session()->has('leadsfollowup_plantselection'))  {
                    $request->session()->forget('leadsfollowup_plantselection');
                }
                $empplantlist = $this->emp_bulkplant_list($employeeid);
                
                $listplant = [];
                if (array_key_exists('Output', $empplantlist)) {
			
			if(array_key_exists('0', $empplantlist['Output']) === false ){
				$ll[0] = $empplantlist['Output'];
			}
			else{
				$ll = $empplantlist['Output'];
			}
                    foreach ($ll as $keyb => $valueb) {
                        
                        $listplant[] = $valueb['Plant'];
                    }
                }
                if (empty($listplant)) {
                    return redirect()->route('newemployee_dashboard', ['empid' => $employeeid]);
                }

                return view('newemployeezone.plantselect')->with(['getemployeedata'=> $getemployeedata,'listplant' => $listplant,'profilepic' => $profilepic]);
            }
            else{
                if ($request->session()->has('leadsfollowup_plantselection'))  {
                    $selectedplant = $request->session()->get('leadsfollowup_plantselection');
                }
                if (trim($plantcode) != $selectedplant) {
                    return redirect()->route('leadsfollowup');
                }
                
            }


              $dbquery = $this->requestforcoldapproval_data($employeeid);

           
        if (!empty($dbquery)) {
            $show_mngr_link = 1;
            
        }else{
            $show_mngr_link = 0;
        }
            
           
           if($request->session()->has('leadsfollowupviewquote')){
            $request->session()->forget('leadsfollowupviewquote');
           }

            return view('newemployeezone.leadlogin')->with(['getemployeedata'=> $getemployeedata,'show_mngr_link' => $show_mngr_link,'profilepic' => $profilepic,'selectedplant' => $selectedplant]);

              }
        else{
            return redirect()->route('newemployee_home');
        }
    }

    public function postleadsfollowup(Request $request)
    {
        if (!empty($request->plantcode)) {
            $request->session()->put('leadsfollowup_plantselection',$request->plantcode);
            $trimmedplantcode = trim($request->plantcode);
            return redirect()->route('leadsfollowup',['plantcode' => $trimmedplantcode]);
        }
        else{
            redirect()->back();
        }
        
    }


    public function leadsfollowreference(Request $request, $type,$leadno){
         if ($request->session()->has('employeesession')) {
            $encrypt = $request->session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $employeeid = $split[0];
            $getemployeedata = DB::connection('mysql6')->table('employee')->where('id', '=', $employeeid)->get();

            $pwd_status = $this->is_emp_didnt_passwordchanged($employeeid);
            if ($pwd_status == 0) {
                $request->session()->flash("error_msg", 'Please change the default password. Only if you Change the default password , other functionalities on this portal will work. This is done for security purposes. Please do not share your password with anyone');
                return redirect()->route('newemployee_mydetails_passchange');
            }
            
            foreach($getemployeedata as $emp){
                $valid = $emp->saleorder;
                $empname = $emp->name;
                
            }
            
            if($valid != "1"){
                return redirect()->route('newemployee_dashboard', ['empid' => $employeeid]);
            }
            
            
          $getleadsdata = $this->getleadsfollowupdata($leadno,$empname); 
            //dd($getleadsdata);
          $mainleads = array();
          if (array_key_exists('0', $getleadsdata['Description'])) {
              $mainleads = $getleadsdata['Description'];
          }
          else{
            $mainleads[0] = $getleadsdata['Description']; 
          }
           
           $coldind = $getleadsdata['Cold_Ind'];
           $coldreason = $getleadsdata['Cold_Reason'];
           if (!empty($getleadsdata['Ch_Date'])) {
               $cdate = substr($getleadsdata['Ch_Date'], 6,2).'-'.substr($getleadsdata['Ch_Date'], 4,2).'-'.substr($getleadsdata['Ch_Date'], 0,4);
           }
           else
           {
            $cdate = ""; 
           }

           
           $cold_status = $getleadsdata['Cold_Status'];
           if ($cold_status == 'APPROVED') {
               return redirect()->route('getleadstypedata',['type' => $type]);
           }
           $assigneddate = $getleadsdata['Assigned_On'];
           if (!empty($getleadsdata['Assigned_On'])) {
               $asigndate = substr($getleadsdata['Assigned_On'], 6,2).'-'.substr($getleadsdata['Assigned_On'], 4,2).'-'.substr($getleadsdata['Assigned_On'], 0,4);
           }
           else
           {
            $asigndate = ""; 
           }
           
            $getcoldreasondata = $this->getcoldreason();

            
             $coldarray = array();
          if (array_key_exists('0', $getcoldreasondata['Cold_Table'])) {
              $coldarray = $getcoldreasondata['Cold_Table'];
          }
          else{
            $coldarray[0] = $getcoldreasondata['Cold_Table']; 
          }
          //dd($coldarray);

             $listfiles = Storage::disk('s3')->files("/newcustomerzoneassets/employeeprofileimage/".$employeeid);             
             if(count($listfiles) > 0){
                $profilepic = config('app.AWS_URL')."/".$listfiles[0];
            }
             else
             {
                $profilepic = config('app.AWS_URL')."/newcustomerzoneassets/img/dummy_male.png";
             }


            return view('newemployeezone.leadsfollowreference')->with(['getemployeedata'=> $getemployeedata,'type'=>$type,'leadstable'=>$mainleads,'leadno'=>$leadno,'coldind'=>$coldind,'cold_status' => $cold_status,'coldreason'=>$coldreason,'asigndate'=>$asigndate,'cdate'=>$cdate,'coldarray'=>$coldarray,'profilepic' => $profilepic]);

              }
        else{
            return redirect()->route('newemployee_home');
        }
    }


     public function insertleadsfollowup(Request $request){
         if ($request->session()->has('employeesession')) {
            $encrypt = $request->session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $employeeid = $split[0];
            $getemployeedata = DB::connection('mysql6')->table('employee')->where('id', '=', $employeeid)->get();
            
            foreach($getemployeedata as $emp){
                $valid = $emp->saleorder;
                $empname = $emp->name;
                
            }
            
            if($valid != "1"){
                return redirect()->route('newemployee_dashboard', ['empid' => $employeeid]);
            }
            

            $data = $request->data;
            $cold_status = $request->cold_status;
            if($cold_status == null){
                $cold_status = '';
            }
            $colind = $request->coldind;
            if($colind == null){
                $colind = '';
            }
            $coldindtext = $request->coldindtext;
            if ($coldindtext == null) {
                $coldindtext = '';
            }
            $leadplant = $request->leadplant;
            $teleno = $request->teleno;
            $mailid = $request->mailid;
            $budgetrange = $request->budgetrange;
            if ($budgetrange == null) {
                $budgetrange = '';
            }
            $changeddate = $request->changeddate;
            
            if ($changeddate == null) {
                $changeddate = '';
            }
            elseif($changeddate == '00000000'){
                $changeddate = carbon::now()->format('Ymd');
            }
            else{
            //$changeddate = str_replace('-', '', $request->changeddate);
                $changeddate = carbon::now()->format('Ymd');
            }

            $leadclassify = $request->leadclassify;
            if ($leadclassify == '') {
                $leadclassify = '';
            }else{
                $leadclassify = strtoupper($leadclassify);
            }

            if($leadclassify == 'COLD'){
                if (($coldindtext == '') && ($coldindtext == '')) {
                    $leadclassify = '';
                }
            }

            $leadname = $request->leadname;
            if ( $leadname == null) {
                 $leadname = '';
            }
            $leadno = $request->leadno;

            $finalarray = array();
            foreach ($data as $key => $value) {
                $finalarray['FollowUp_Details'][$key]['S_No'] = $value['S.No'];
                $finalarray['FollowUp_Details'][$key]['Lead_No'] = $leadno;
                $finalarray['FollowUp_Details'][$key]['Emp_No'] = $employeeid;
                $finalarray['FollowUp_Details'][$key]['Emp_Name'] = $empname;
                $finalarray['FollowUp_Details'][$key]['P_Name'] = $leadname;
                $finalarray['FollowUp_Details'][$key]['Tel_No'] = $teleno;
                $finalarray['FollowUp_Details'][$key]['Email_ID'] = $mailid;
                $finalarray['FollowUp_Details'][$key]['WERKS'] = $leadplant;
                $finalarray['FollowUp_Details'][$key]['Budget'] = $budgetrange;
                $finalarray['FollowUp_Details'][$key]['Act_No'] = $value['Action to be Taken'];
                if ($value['Deadline Date'] != '') {
                    $value['Deadline Date'] = str_replace('-', '', $value['Deadline Date']);
                }else{ $value['Deadline Date'] = ''; }
                $finalarray['FollowUp_Details'][$key]['Dead_Date'] = $value['Deadline Date'];
                if ($value['Created Date'] == null) {
                        $value['Created Date'] = Carbon::now()->format('Ymd');
                    
                }else{ $value['Created Date'] = str_replace('-', '', $value['Created Date']);  }
                $finalarray['FollowUp_Details'][$key]['ERDAT'] = $value['Created Date'];
                if ($value['Completion Indicator'] == null) {
                    $value['Completion Indicator'] = '';
                }
                $finalarray['FollowUp_Details'][$key]['Comp_Ind'] = $value['Completion Indicator'];
                $finalarray['FollowUp_Details'][$key]['Ch_Date'] = $changeddate;
                $finalarray['FollowUp_Details'][$key]['K_Cold'] = $coldindtext;
                $finalarray['FollowUp_Details'][$key]['K_Chk'] = $colind;
                $finalarray['FollowUp_Details'][$key]['Assignedon'] = '';
                $finalarray['FollowUp_Details'][$key]['Cold_Status'] = $cold_status;
                $finalarray['FollowUp_Details'][$key]['Req_Appr_Date'] = Carbon::now()->toDateString();
                $finalarray['FollowUp_Details'][$key]['Req_Appr_Time'] = Carbon::now()->toTimeString();
                $finalarray['FollowUp_Details'][$key]['Approved_Date'] = '';
                $finalarray['FollowUp_Details'][$key]['Approved_Time'] = '';
                
                $finalarray['FollowUp_Details'][$key]['Lead_Classification'] = $leadclassify;
            }
             // return $finalarray;
            $insertleadreference = $this->leadsfollowupinsert($finalarray);      
            return $insertleadreference;
            
            
          //return 1;
        //dd($getleadsdata);
          $mainleads = array();
          if (array_key_exists('0', $getleadsdata['Description'])) {
              $mainleads = $getleadsdata['Description'];
          }
          else{
            $mainleads[0] = $getleadsdata['Description']; 
          }
           
           $coldind = $getleadsdata['Cold_Ind'];
           $coldreason = $getleadsdata['Cold_Reason'];
           if (!empty($getleadsdata['Ch_Date'])) {
               $cdate = substr($getleadsdata['Ch_Date'], 0,4).'-'.substr($getleadsdata['Ch_Date'], 4,2).'-'.substr($getleadsdata['Ch_Date'], 6,2);
           }
           else
           {
            $cdate = ""; 
           }
           



             $listfiles = Storage::disk('s3')->files("/newcustomerzoneassets/employeeprofileimage/".$employeeid);             
             if(count($listfiles) > 0){
                $profilepic = config('app.AWS_URL')."/".$listfiles[0];
            }
             else
             {
                $profilepic = config('app.AWS_URL')."/newcustomerzoneassets/img/dummy_male.png";
             }


            return view('newemployeezone.leadsfollowreference')->with(['getemployeedata'=> $getemployeedata,'type'=>$type,'leadstable'=>$mainleads,'leadno'=>$leadno,'coldind'=>$coldind,'coldreason'=>$coldreason,'cdate'=>$cdate,'profilepic' => $profilepic]);

              }
        else{
            return redirect()->route('newemployee_home');
        }
    }


     public function esalesdiary(Request $request, $type){
         if ($request->session()->has('employeesession')) {
            $encrypt = $request->session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $employeeid = $split[0];
            $getemployeedata = DB::connection('mysql6')->table('employee')->where('id', '=', $employeeid)->get();

            $pwd_status = $this->is_emp_didnt_passwordchanged($employeeid);
            if ($pwd_status == 0) {
                $request->session()->flash("error_msg", 'Please change the default password. Only if you Change the default password , other functionalities on this portal will work. This is done for security purposes. Please do not share your password with anyone');
                return redirect()->route('newemployee_mydetails_passchange');
            }
            
            foreach($getemployeedata as $emp){
                $valid = $emp->saleorder;
                $empname = $emp->name;
                
            }
            
            if($valid != "1"){
                return redirect()->route('newemployee_dashboard', ['empid' => $employeeid]);
            }
            
            $newtype = strtoupper($type);
            if($type == 'underfollowup'){
                $newtype = '';
            }
            $res = $this->getediary($newtype,$empname);
            $kk = [];
            if (!array_key_exists('0', $res['Sales_Dairy_Details'])) {
                if(empty($res['Sales_Dairy_Details']['Lead_No'])){
                    return redirect()->route('getleadstypedata',['type' => $type]);
                }
                else{
                    
                    $kk[0] = $res['Sales_Dairy_Details'];
                }
                
            }
            else
            {
                $kk = $res['Sales_Dairy_Details'];
            }
           
            //dd($kk);
            
            $duparray = array();
            foreach ($kk as $key => $value) {
                
                array_push($duparray, substr($value['Dead_Date'], 6,2).'-'.substr($value['Dead_Date'], 4,2).'-'.substr($value['Dead_Date'], 0,4));
            }

            foreach ($duparray as $key => $row) {
                $orderByDate[$key]  = strtotime($row);
            }

array_multisort($orderByDate, SORT_ASC, $duparray);

$nn = array();
foreach ($orderByDate as $nkey => $nvalue) {
    if ($nvalue != false) {  

   $nn[] =  date('d-m-Y',$nvalue);
}
}

           
          $mainarray = array_unique($nn);


          
             $listfiles = Storage::disk('s3')->files("/newcustomerzoneassets/employeeprofileimage/".$employeeid);             
             if(count($listfiles) > 0){
                $profilepic = config('app.AWS_URL')."/".$listfiles[0];
            }
             else
             {
                $profilepic = config('app.AWS_URL')."/newcustomerzoneassets/img/dummy_male.png";
             }


            return view('newemployeezone.esalesdiary')->with(['getemployeedata'=> $getemployeedata,'result'=>$kk,'datearray'=>$mainarray,'profilepic' => $profilepic]);

              }
        else{
            return redirect()->route('newemployee_home');
        }
    }






     public function availstatus(Request $request, $plantcode){
         if ($request->session()->has('employeesession')) {
            $encrypt = $request->session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $employeeid = $split[0];
            $getemployeedata = DB::connection('mysql6')->table('employee')->where('id', '=', $employeeid)->get();

            $pwd_status = $this->is_emp_didnt_passwordchanged($employeeid);
            if ($pwd_status == 0) {
                $request->session()->flash("error_msg", 'Please change the default password. Only if you Change the default password , other functionalities on this portal will work. This is done for security purposes. Please do not share your password with anyone');
                return redirect()->route('newemployee_mydetails_passchange');
            }
            
            foreach($getemployeedata as $emp){
                $valid = $emp->saleorder;
                $empname = $emp->name;
                
            }
            
            if($valid != "1"){
                return redirect()->route('newemployee_dashboard', ['empid' => $employeeid]);
            }

                        
            $unitdetails = $this->getsaleorderunits($plantcode);
            //dd($unitdetails);
            $newmain = array();
            if (array_key_exists('0', $unitdetails['DATA'])) {
                $main = $unitdetails['DATA'];
            }
            else{
                if ($unitdetails['DATA']['Company_Code'] != '') {
                $main[0] = $unitdetails['DATA'];    
                }else{
                    return redirect()->route('leadsfollowup');
                }
                   
            }

           // dd($main);
          
             $listfiles = Storage::disk('s3')->files("/newcustomerzoneassets/employeeprofileimage/".$employeeid);             
             if(count($listfiles) > 0){
                $profilepic = config('app.AWS_URL')."/".$listfiles[0];
            }
             else
             {
                $profilepic = config('app.AWS_URL')."/newcustomerzoneassets/img/dummy_male.png";
             }


            return view('newemployeezone.availstatus')->with(['getemployeedata'=> $getemployeedata,'result'=>$main,'profilepic' => $profilepic]);

              }
        else{
            return redirect()->route('newemployee_home');
        }
    }


     public function leadscript(Request $request, $type){
         if ($request->session()->has('employeesession')) {
            $encrypt = $request->session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $employeeid = $split[0];
            $getemployeedata = DB::connection('mysql6')->table('employee')->where('id', '=', $employeeid)->get();

            $pwd_status = $this->is_emp_didnt_passwordchanged($employeeid);
            if ($pwd_status == 0) {
                $request->session()->flash("error_msg", 'Please change the default password. Only if you Change the default password , other functionalities on this portal will work. This is done for security purposes. Please do not share your password with anyone');
                return redirect()->route('newemployee_mydetails_passchange');
            }
            
            foreach($getemployeedata as $emp){
                $valid = $emp->saleorder;
                $empname = $emp->name;
                
            }
            
            if($valid != "1"){
                return redirect()->route('newemployee_dashboard', ['empid' => $employeeid]);
            }

            if (!empty($type)) {
                $type = strtolower(str_replace(' ', '', $type));
            }

            if(($type == 'hot')||($type == 'warm')||($type == 'underfollowup')){
                
            }
            else
            {
                return redirect()->route('leadsfollowup');
            }
            
            if($type == 'underfollowup'){
                $type1 = '';
            }
            else{
                $type1 = $type;
            }


             $getdata = $this->getleadsfollowup($type1,$empname);
            $mainarray = array();
            
            if(!empty($getdata)){
                
                if(array_key_exists('0',$getdata['LEADS_FOLLOWUP_DETAILS'] )){
                    $mainarray = $getdata['LEADS_FOLLOWUP_DETAILS'];
                }
                else
                {
                    $mainarray[0] = $getdata['LEADS_FOLLOWUP_DETAILS'];
                }
            }
                       //dd($mainarray); 
           

           $newmain = array();

           foreach ($mainarray as $key => $value) {
            
               $newmain [$value['Project']] = $value['Project_Desc'];
           }

           
          
             $listfiles = Storage::disk('s3')->files("/newcustomerzoneassets/employeeprofileimage/".$employeeid);             
             if(count($listfiles) > 0){
                $profilepic = config('app.AWS_URL')."/".$listfiles[0];
            }
             else
             {
                $profilepic = config('app.AWS_URL')."/newcustomerzoneassets/img/dummy_male.png";
             }


            return view('newemployeezone.leadscript')->with(['getemployeedata'=> $getemployeedata,'type'=>$type,'result'=>$newmain,'profilepic' => $profilepic]);

              }
        else{
            return redirect()->route('newemployee_home');
        }
    }

    public function viewleadscript(Request $request, $type,$plant){
         if ($request->session()->has('employeesession')) {
            $encrypt = $request->session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $employeeid = $split[0];
            $getemployeedata = DB::connection('mysql6')->table('employee')->where('id', '=', $employeeid)->get();

            $pwd_status = $this->is_emp_didnt_passwordchanged($employeeid);
            if ($pwd_status == 0) {
                $request->session()->flash("error_msg", 'Please change the default password. Only if you Change the default password , other functionalities on this portal will work. This is done for security purposes. Please do not share your password with anyone');
                return redirect()->route('newemployee_mydetails_passchange');
            }
            
            foreach($getemployeedata as $emp){
                $valid = $emp->saleorder;
                $empname = $emp->name;
                
            }
            
            if($valid != "1"){
                return redirect()->route('newemployee_dashboard', ['empid' => $employeeid]);
            }

            if(($type == 'hot')||($type == 'warm')||($type == 'underfollowup')){
                //$type = strtoupper($type);
                $type1 = strtoupper($type);
            }
            else
            {
                return redirect()->route('leadsfollowup');
            }
            
            if($type == 'underfollowup'){
                $type1 = 'UD';
            }


            $check = $this->getleadscript($type1, $plant);
            //dd($check);
            $newmain = array();
            $finalmain = array();

            if (array_key_exists('0', $check)) {
                $newmain = $check['Table_Content'];
            }
            else
            {
                if (array_key_exists('0', $check['Table_Content'])) {
                    $finalmain = $check['Table_Content'];
                }
                else{
                    $finalmain[0] = $check['Table_Content'];
                }
                /*if ($check['Table_Content']['Script_Content'] == '') {
                    return redirect()->route('leadscript',['type' => $type]);
                }
                $newmain[0] = $check['Table_Content'];*/
            }

            if ($finalmain[0]['Script_Content'] == '') {
                return redirect()->route('leadscript',['type' => $type]);
            }

            //dd($finalmain);

           
          
             $listfiles = Storage::disk('s3')->files("/newcustomerzoneassets/employeeprofileimage/".$employeeid);             
             if(count($listfiles) > 0){
                $profilepic = config('app.AWS_URL')."/".$listfiles[0];
            }
             else
             {
                $profilepic = config('app.AWS_URL')."/newcustomerzoneassets/img/dummy_male.png";
             }


            return view('newemployeezone.viewleadscript')->with(['getemployeedata'=> $getemployeedata,'plant'=>$plant,'type'=>$type,'result'=>$finalmain,'profilepic' => $profilepic]);

              }
        else{
            return redirect()->route('newemployee_home');
        }
    }

    public function printviewleadscript(Request $request, $type,$plant){
         if ($request->session()->has('employeesession')) {
            $encrypt = $request->session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $employeeid = $split[0];
            $getemployeedata = DB::connection('mysql6')->table('employee')->where('id', '=', $employeeid)->get();

            $pwd_status = $this->is_emp_didnt_passwordchanged($employeeid);
            if ($pwd_status == 0) {
                $request->session()->flash("error_msg", 'Please change the default password. Only if you Change the default password , other functionalities on this portal will work. This is done for security purposes. Please do not share your password with anyone');
                return redirect()->route('newemployee_mydetails_passchange');
            }
            
            foreach($getemployeedata as $emp){
                $valid = $emp->saleorder;
                $empname = $emp->name;
                
            }
            
            if($valid != "1"){
                return redirect()->route('newemployee_dashboard', ['empid' => $employeeid]);
            }

            if(($type == 'hot')||($type == 'warm')||($type == 'underfollowup')){
                //$type = strtoupper($type);
                $type1 = strtoupper($type);
            }
            else
            {
                return redirect()->route('leadsfollowup');
            }
            
            if($type == 'underfollowup'){
                $type1 = 'UD';
            }


            $check = $this->getleadscript($type1, $plant);
            //dd($check);
            $newmain = array();
            $finalmain = array();

            if (array_key_exists('0', $check)) {
                $newmain = $check['Table_Content'];
            }
            else
            {
                if (array_key_exists('0', $check['Table_Content'])) {
                    $finalmain = $check['Table_Content'];
                }
                else{
                    $finalmain[0] = $check['Table_Content'];
                }
                /*if ($check['Table_Content']['Script_Content'] == '') {
                    return redirect()->route('leadscript',['type' => $type]);
                }
                $newmain[0] = $check['Table_Content'];*/
            }

            if ($finalmain[0]['Script_Content'] == '') {
                return redirect()->route('leadscript',['type' => $type]);
            }

            //dd($finalmain);

           
          
             $listfiles = Storage::disk('s3')->files("/newcustomerzoneassets/employeeprofileimage/".$employeeid);             
             if(count($listfiles) > 0){
                $profilepic = config('app.AWS_URL')."/".$listfiles[0];
            }
             else
             {
                $profilepic = config('app.AWS_URL')."/newcustomerzoneassets/img/dummy_male.png";
             }
             

            return view('newemployeezone.printviewleadscript')->with(['getemployeedata'=> $getemployeedata,'type'=>$type,'result'=>$finalmain,'empname'=>$empname,'plant'=>$plant,'profilepic' => $profilepic]);

              }
        else{
            return redirect()->route('newemployee_home');
        }
    }

     public function typeview(Request $request, $type,$typeview){
         if ($request->session()->has('employeesession')) {
            $encrypt = $request->session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $employeeid = $split[0];
            $getemployeedata = DB::connection('mysql6')->table('employee')->where('id', '=', $employeeid)->get();

            $pwd_status = $this->is_emp_didnt_passwordchanged($employeeid);
            if ($pwd_status == 0) {
                $request->session()->flash("error_msg", 'Please change the default password. Only if you Change the default password , other functionalities on this portal will work. This is done for security purposes. Please do not share your password with anyone');
                return redirect()->route('newemployee_mydetails_passchange');
            }
            
            foreach($getemployeedata as $emp){
                $valid = $emp->saleorder;
                $empname = $emp->name;
                
            }
            
            if($valid != "1"){
                return redirect()->route('newemployee_dashboard', ['empid' => $employeeid]);
            }

            if(($type == 'hot')||($type == 'warm')||($type == 'underfollowup')){
                //$type = strtoupper($type);
                $type1 = strtoupper($type);
            }
            else
            {
                return redirect()->route('leadsfollowup');
            }
            
            if($type == 'underfollowup'){
                return redirect()->route('leadsfollowup');
            }




            $check = $this->getleadtypeview($type1, $typeview,$empname);
            //dd($check);
            $newmain = array();
            $finalmain = array();

            if (array_key_exists('0', $check['Site_Visit_Details'])) {
                $newmain = $check['Site_Visit_Details'];
            }
            else
            {
               $newmain[0] = $check['Site_Visit_Details'];
            }

            if ($newmain[0]['Lead_No'] == '') {
                $request->session()->flash('error_msg', 'No Data found!');
                return redirect()->route('getleadstypedata', ['type'=>$type]);
            }

           
           
          
             $listfiles = Storage::disk('s3')->files("/newcustomerzoneassets/employeeprofileimage/".$employeeid);             
             if(count($listfiles) > 0){
                $profilepic = config('app.AWS_URL')."/".$listfiles[0];
            }
             else
             {
                $profilepic = config('app.AWS_URL')."/newcustomerzoneassets/img/dummy_male.png";
             }

             if ($typeview == 'HOT_OD') {
                 $title = 'Last 60 Days Site Visit Completed';
                 $column1 = 'Site Visit Completed on';
             }
             if ($typeview == 'WARM_SV') {
                 $title = 'Overdue Site Visit last 180 Days';
                 $column1 = 'Scheduled Site Visit';
             }
              if ($typeview == 'WARM1') {
                 $title = 'Next 30 days scheduled site visit';
                 $column1 = 'Scheduled Site Visit';
             }


            return view('newemployeezone.leaddetails')->with(['getemployeedata'=> $getemployeedata,'type'=>$type,'result'=>$newmain,'title'=>$title,'column1'=>$column1,'profilepic' => $profilepic]);

              }
        else{
            return redirect()->route('newemployee_home');
        }
    }
    
   public function sendsmsforleads(Request $request){
        
        if ($request->session()->has('employeesession')) {
            $encrypt = $request->session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $employeeid = $split[0];
            $getemployeedata = DB::connection('mysql6')->table('employee')->where('id', '=', $employeeid)->get();
            
            foreach($getemployeedata as $emp){
                $valid = $emp->saleorder;
                $empname = $emp->name;
                
            }
            
            if($valid != "1"){
                return 0;
            }
            
            
           
            
           if($request->has('type')){
               $gettype = $request->get('type');

               $leadno = $request->get('leadno');
               



                 if($gettype == 'smsgreet_mass'){

                    $newtype = $request->cadr;
                    
                     if(($newtype == 'hot')||($newtype == 'warm')||($newtype == 'Under Followup')){
                
            }
            else
            {
                return 0;
            }
            
            if($newtype == 'Under Followup'){
                $newtype = '';
            }
            
            $getdata = $this->getleadsfollowup($newtype,$empname);
            $mainarray = array();
           // dd($getdata);
                if(!empty($getdata)){
                    
                    if(array_key_exists('0',$getdata['LEADS_FOLLOWUP_DETAILS'] )){
                        $mainarray = $getdata['LEADS_FOLLOWUP_DETAILS'];
                    }
                    else
                    {
                        $mainarray[0] = $getdata['LEADS_FOLLOWUP_DETAILS'];
                    }
                }

                //return $mainarray;
                $processing['Status'] = '';
                $processing['Status_1'] = '';
                
                foreach ($mainarray as $key => $value) {
                    
                if($value['SMS_Greet_Eb'] == ''){
                   $newtypename = 'GREET';
                   $leadno = $value['Lead_No'];
                   $sch_date = '?';
                   $sch_time = '?';
                   $sch_cdate = '?';
                   $sch_ctime = '?';
                   $sch_addr = '?';
                   $sch_project = '?';
                   $sch_unit = '?';
                   $ownind = '';
                   
                $processing = $this->sendsmsleads($newtypename,$leadno,$sch_date,$sch_time,$sch_addr,$sch_project,$sch_unit,$sch_cdate,$sch_ctime,$ownind);
                }
            }
                   //return json_encode($processing);
                   if(($processing['Status'] == 'X')&&($processing['Status_1'] == '')){
                       return 1;
                   }else
                   {
                       return 0;
                   }
               }


                if($gettype == 'smsinvite_mass'){

                    $newtype = $request->cadr;
                    
                     if(($newtype == 'hot')||($newtype == 'warm')||($newtype == 'Under Followup')){
                
            }
            else
            {
                return 0;
            }
            
            if($newtype == 'Under Followup'){
                $newtype = '';
            }
            
            $getdata = $this->getleadsfollowup($newtype,$empname);
            $mainarray = array();
           // dd($getdata);
                if(!empty($getdata)){
                    
                    if(array_key_exists('0',$getdata['LEADS_FOLLOWUP_DETAILS'] )){
                        $mainarray = $getdata['LEADS_FOLLOWUP_DETAILS'];
                    }
                    else
                    {
                        $mainarray[0] = $getdata['LEADS_FOLLOWUP_DETAILS'];
                    }
                }

                //return $mainarray;
                $processing['Status'] = '';
                $processing['Status_1'] = '';
                foreach ($mainarray as $key => $value) {
                    if($value['Inv_SV'] == ''){
                
                   $newtypename = 'INV';
                   $leadno = $value['Lead_No'];
                   $sch_date = '?';
                   $sch_time = '?';
                   $sch_cdate = '?';
                   $sch_ctime = '?';
                   $sch_addr = '?';
                   $sch_project = '?';
                   $sch_unit = '?';
                   $ownind = '';
                   
                $processing = $this->sendsmsleads($newtypename,$leadno,$sch_date,$sch_time,$sch_addr,$sch_project,$sch_unit,$sch_cdate,$sch_ctime,$ownind);
                }
            }
                   //return json_encode($processing);
                   if(($processing['Status'] == 'X')&&($processing['Status_1'] == '')){
                       return 1;
                   }else
                   {
                       return 0;
                   }
               }


               
               if(!empty($leadno)){

               if($gettype == 'smsgreet_single'){

                   $newtypename = 'GREET';
                   $leadno = $leadno;
                   $sch_date = '?';
                   $sch_time = '?';
                   $sch_cdate = '?';
                   $sch_ctime = '?';
                   $sch_addr = '?';
                   $sch_project = '?';
                   $sch_unit = '?';
                   $ownind = '';
                   
                $processing = $this->sendsmsleads($newtypename,$leadno,$sch_date,$sch_time,$sch_addr,$sch_project,$sch_unit,$sch_cdate,$sch_ctime,$ownind);
                   //return json_encode($processing);
                   if(($processing['Status'] == 'X')&&($processing['Status_1'] == '')){
                       return 1;
                   }else
                   {
                       return 0;
                   }
               }



               
               
               
               //invite greet sms
               if($gettype == 'smsinvite_single'){
                   $newtypename = 'INV';
                   $leadno = $leadno;
                   $sch_date = '?';
                   $sch_time = '?';
                   $sch_cdate = '?';
                   $sch_ctime = '?';
                   $sch_addr = '?';
                   $sch_project = '?';
                   $sch_unit = '?';
                   $ownind = '';
                $processing = $this->sendsmsleads($newtypename,$leadno,$sch_date,$sch_time,$sch_addr,$sch_project,$sch_unit,$sch_cdate,$sch_ctime,$ownind);
                   //return json_encode($processing);
                   if(($processing['Status'] == 'X')&&($processing['Status_1'] == '')){
                       return 1;
                   }else
                   {
                       return 0;
                   }
               }
               


                //schedule send sms single
               if($gettype == 'smsschedule_single'){
                $pickuploc = $request->pickuplocation;

                   $newtypename = 'SCV';
                   $leadno = $leadno;
                   $sch_date = $request->get('sdate');
                   $sch_time = $request->get('stime');
                   $sch_cdate = '?';
                   $sch_ctime = '?';
                   $sch_addr = $pickuploc;
                   $sch_project = '?';
                   $sch_unit = '?';
                   $ownind = $request->get('ownind');


                   if (($sch_date == '')||($sch_time == '')) {
                        
                        return 0;
                    }

                   $sch_date = str_replace('-', '', $sch_date);
                   $sch_time = str_replace(':', '', $sch_time).'00';
                   
                $processing = $this->sendsmsleads($newtypename,$leadno,$sch_date,$sch_time,$sch_addr,$sch_project,$sch_unit,$sch_cdate,$sch_ctime,$ownind);
                   //return json_encode($processing);
                   if(($processing['Status'] == 'X')&&($processing['Status_1'] == '')){
                       return 1;
                   }else
                   {
                       return 0;
                   }
               }

               //schedule callback date single
               if($gettype == 'smsschedulecallback_single'){
                

                   $newtypename = 'SCB';
                   $leadno = $leadno;
                   $sch_date = '?';
                   $sch_time = '?';
                   $sch_cdate = $request->get('cdate');
                   $sch_ctime = $request->get('ctime');
                   $sch_addr = '?';
                   $sch_project = '?';
                   $sch_unit = '?';
                   $ownind = '';

                   if (($sch_cdate == '')||($sch_ctime == '')) {
                        return 0;
                    }

                   $sch_cdate = str_replace('-', '', $sch_cdate);
                   $sch_ctime = str_replace(':', '', $sch_ctime).'00';
                   //$cc = [$newtypename,$leadno,$sch_date,$sch_time,$sch_addr,$sch_project,$sch_unit,$sch_cdate,$sch_ctime];

                   //return $cc;

                $processing = $this->sendsmsleads($newtypename,$leadno,$sch_date,$sch_time,$sch_addr,$sch_project,$sch_unit,$sch_cdate,$sch_ctime,$ownind);
                   //return json_encode($processing);
                   if(($processing['Status'] == 'X')&&($processing['Status_1'] == '')){
                       return 1;
                   }else
                   {
                       return 0;
                   }
               }


                 //completion for site visit send sms single
               if($gettype == 'smscompletion_single'){
                    //return $gettype;
                   $newtypename = 'CSV';
                   $leadno = $leadno;
                   $sch_date ='?';
                   $sch_time = '?';
                   $sch_cdate = '?';
                   $sch_ctime = '?';
                   $sch_addr = '?';
                   $sch_project = '?';
                   $sch_unit = '?';
                   $ownind = '';

                   
                $processing = $this->sendsmsleads($newtypename,$leadno,$sch_date,$sch_time,$sch_addr,$sch_project,$sch_unit,$sch_cdate,$sch_ctime,$ownind);
                   //return json_encode($processing);
                   if(($processing['Status'] == 'X')&&($processing['Status_1'] == '')){
                       return 1;
                   }else
                   {
                       return 0;
                   }
               }

               //Emial/sms quotation for site visit send sms single
               if($gettype == 'emailsmssingle'){
                    //return $gettype;
                   $newtypename = 'ESQ';
                   $leadno = $leadno;
                   $sch_date ='?';
                   $sch_time = '?';
                   $sch_cdate = '?';
                   $sch_ctime = '?';
                   $sch_addr = '?';
                   $sch_project = $request->get('sprojno');
                   $sch_unit = $request->get('sunit');
                   $ownind = '';

                   
                $processing = $this->sendsmsleads($newtypename,$leadno,$sch_date,$sch_time,$sch_addr,$sch_project,$sch_unit,$sch_cdate,$sch_ctime,$ownind);
                   //return json_encode($processing);
                   if(($processing['Status'] == 'X')&&($processing['Status_1'] == '')){
                       return 1;
                   }else
                   {
                       return 0;
                   }
               }

                 //Booked Indicator sms single
               if($gettype == 'smsbooked_single'){
                    //return $gettype;
                   $newtypename = 'BOOKED';
                   $leadno = $leadno;
                   $sch_date ='?';
                   $sch_time = '?';
                   $sch_cdate = '?';
                   $sch_ctime = '?';
                   $sch_addr = '?';
                   $sch_project = '?';
                   $sch_unit = '?';
                   $ownind = '';

                   
                $processing = $this->sendsmsleads($newtypename,$leadno,$sch_date,$sch_time,$sch_addr,$sch_project,$sch_unit,$sch_cdate,$sch_ctime,$ownind);
                   //return json_encode($processing);
                   if(($processing['Status'] == 'X')&&($processing['Status_1'] == '')){
                       return 1;
                   }else
                   {
                       return 0;
                   }
               }
               


               }else
               {
                   return 0;
               }
               
               
           }
            else
            {
                return 0;
            }
                        
             
            
            
               }
        else{
            return redirect()->route('newemployee_home');
        }
    }

public function leadfollowupviewquote(Request $request){


if ($request->session()->has('employeesession')) {
            $encrypt = $request->session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $employeeid = $split[0];
            $getemployeedata = DB::connection('mysql6')->table('employee')->where('id', '=', $employeeid)->get();

            $pwd_status = $this->is_emp_didnt_passwordchanged($employeeid);
            if ($pwd_status == 0) {
                $request->session()->flash("error_msg", 'Please change the default password. Only if you Change the default password , other functionalities on this portal will work. This is done for security purposes. Please do not share your password with anyone');
                return redirect()->route('newemployee_mydetails_passchange');
            }
            
            foreach($getemployeedata as $emp){
                $valid = $emp->saleorder;
                $salesexec = $emp->name;
                
            }
            
            if($valid != "1"){
                return redirect()->route('newemployee_dashboard', ['empid' => $employeeid]);
            }
    if($request->session()->has('leadsfollowupviewquote')){
        $result = $request->session()->get('leadsfollowupviewquote');
         $listfiles = Storage::disk('s3')->files("/newcustomerzoneassets/employeeprofileimage/".$employeeid);             
             if(count($listfiles) > 0){
                $profilepic = config('app.AWS_URL')."/".$listfiles[0];
            }
             else
             {
                $profilepic = config('app.AWS_URL')."/newcustomerzoneassets/img/dummy_male.png";
             }
            
           //dd($result);
            $qgenerationdate = $result['Quotation_Generation_Date'];
            $mainres['result'] = $result;
             $amount = strtoupper($this->getIndianCurrency($mainres['result']['PRICE'][count($mainres['result']['PRICE']) -1]['AMOUNT']));
            
            
            return view('newemployeezone.leadsfollowupviewquote')->with(['getemployeedata'=> $getemployeedata,'result'=>$mainres,'qgenerationdate' =>$qgenerationdate,'amount' => $amount,'profilepic' => $profilepic]);

    }
    else{
    return redirect()->route('leadsfollowup');
}

      }
        else{
            return redirect()->route('newemployee_home');
        }
}

    public function postleadfollowupviewquote(Request $request){
        
        if ($request->session()->has('employeesession')) {
            $encrypt = $request->session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $employeeid = $split[0];
            $getemployeedata = DB::connection('mysql6')->table('employee')->where('id', '=', $employeeid)->get();
            
            foreach($getemployeedata as $emp){
                $valid = $emp->saleorder;
                $salesexec = $emp->name;
                
            }
            
            if($valid != "1"){
                return redirect()->route('newemployee_dashboard', ['empid' => $employeeid]);
            }
            
           
                if ($request->has('qplantcode')) {
                    $projectno = $request->get('qplantcode');
                }

                 if ($request->has('qunitno')) {
                    $unitno = $request->get('qunitno');
                }

                 if ($request->has('leadno')) {
                    $leadno = $request->get('leadno');
                }

                if ($request->has('leadname')) {
                    $leadname = $request->get('leadname');
                }

                if (empty($projectno) || empty($unitno) || empty($leadno)|| empty($leadname)) {
                    return redirect()->route('leadsfollowup');
                }

                
                $unitno = str_pad($unitno, 8,'0',STR_PAD_LEFT);
                
                
                $paymentterms = '';
                $customerno = '3023042';
                
                
                
                $result = $this->viewquotetrait($projectno,$unitno,$paymentterms,$customerno,$leadno);
                //dd($result);
                
                if ($result['Comp_Name'] == '') {
                    
                    $request->session()->flash("error_msg", $result['Status']);
                    return redirect()->back();

                }
                $result['Lead_Name'] = $leadname;
                

                $qgenerationdate = $result['Quotation_Generation_Date'];
                

                               
            
            
                        
             $listfiles = Storage::disk('s3')->files("/newcustomerzoneassets/employeeprofileimage/".$employeeid);             
             if(count($listfiles) > 0){
                $profilepic = config('app.AWS_URL')."/".$listfiles[0];
            }
             else
             {
                $profilepic = config('app.AWS_URL')."/newcustomerzoneassets/img/dummy_male.png";
             }
            
           $request->session()->put('leadsfollowupviewquote',$result);
            
            $namount = array();
            $mainres['result'] = $result;
            if (array_key_exists('0', $mainres['result']['PRICE'])) {
                $namount = $mainres['result']['PRICE'];
            }
            else{
                $namount[0] = $mainres['result']['PRICE'];
            }

           // dd($mainres['result']);
            //dd($mainres['result']['PRICE'][count($mainres['result']['PRICE']) -1]['AMOUNT']);
            if (!empty($namount[0]['AMOUNT'])) {
             $amount = strtoupper($this->getIndianCurrency($mainres['result']['PRICE'][count($mainres['result']['PRICE']) -1]['AMOUNT']));   
            }else{
                $amount = '';
            }
             
            
            
            return view('newemployeezone.leadsfollowupviewquote')->with(['getemployeedata'=> $getemployeedata,'result'=>$mainres,'qgenerationdate' =>$qgenerationdate,'amount' => $amount,'profilepic' => $profilepic]);
            
               }
        else{
            return redirect()->route('newemployee_home');
        }
    }
    
        
    
    public function empstock(Request $request){
        
        if ($request->session()->has('employeesession')) {
            $encrypt = $request->session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $employeeid = $split[0];
            $getemployeedata = DB::connection('mysql6')->table('employee')->where('id', '=', $employeeid)->get();
            $pwd_status = $this->is_emp_didnt_passwordchanged($employeeid);
            if ($pwd_status == 0) {
                $request->session()->flash("error_msg", 'Please change the default password. Only if you Change the default password , other functionalities on this portal will work. This is done for security purposes. Please do not share your password with anyone');
                return redirect()->route('newemployee_mydetails_passchange');
            }
                        
            
            $getstocks = $this->getstock($employeeid);
                        
             $listfiles = Storage::disk('s3')->files("/newcustomerzoneassets/employeeprofileimage/".$employeeid);             
             if(count($listfiles) > 0){
                $profilepic = config('app.AWS_URL')."/".$listfiles[0];
            }
             else
             {
                $profilepic = config('app.AWS_URL')."/newcustomerzoneassets/img/dummy_male.png";
             }
            
            //dd($getstocks);
            return view('newemployeezone.empstock')->with(['getemployeedata'=> $getemployeedata,'vgn_stock'=>$getstocks,'profilepic' => $profilepic]);
            
               }
        else{
            return redirect()->route('newemployee_home');
        }
    }
    
    public function payslip(Request $request){
        
        if ($request->session()->has('employeesession')) {
            $encrypt = $request->session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $employeeid = $split[0];
            $getemployeedata = DB::connection('mysql6')->table('employee')->where('id', '=', $employeeid)->get();

            $pwd_status = $this->is_emp_didnt_passwordchanged($employeeid);
            if ($pwd_status == 0) {
                $request->session()->flash("error_msg", 'Please change the default password. Only if you Change the default password , other functionalities on this portal will work. This is done for security purposes. Please do not share your password with anyone');
                return redirect()->route('newemployee_mydetails_passchange');
            }
            
            $date = Carbon::now();
$curmonth = $date->format('F'); // July
$curyear = $date->format('Y'); // July
$premonth = $date->subMonth()->format('F'); // June
$preyear = $date->subMonth()->format('Y'); // June
            //dd($preyear);
           
            $getpayslip = $this->getpayslip($employeeid, $premonth, $preyear);
            
            if($request->session()->has('payslipsess')){
            $request->session()->forget('payslipsess');
        }
                        
             $listfiles = Storage::disk('s3')->files("/newcustomerzoneassets/employeeprofileimage/".$employeeid);             
             if(count($listfiles) > 0){
                $profilepic = config('app.AWS_URL')."/".$listfiles[0];
            }
             else
             {
                $profilepic = config('app.AWS_URL')."/newcustomerzoneassets/img/dummy_male.png";
             }
            
            
                //dd($getpayslip);    
            
            $current_year = date('Y');
            //dd($current_year);
            
            return view('newemployeezone.payslip')->with(['getemployeedata'=> $getemployeedata,'getpayslip'=>$getpayslip,'premonth' => $premonth,'preyear'=>$preyear,'profilepic' => $profilepic,'current_year'=>$current_year]);
            
               }
        else{
            return redirect()->route('newemployee_home');
        }
    }
    
    public function postpayslip(Request $request){
        
        if ($request->session()->has('employeesession')) {
            $encrypt = $request->session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $employeeid = $split[0];
            $getemployeedata = DB::connection('mysql6')->table('employee')->where('id', '=', $employeeid)->get();
            
                        
             $validate = $this->validate($request, [
            'paymonth' => 'required',
            'payyear' => 'required',
                 ]);
            
            $premonth = $request->paymonth;
            $preyear = $request->payyear;
            //dd($premonth);
         
            $getpayslip = $this->getpayslip($employeeid, $request->paymonth, $request->payyear);
            
            //dd($getpayslip);
                        
             $listfiles = Storage::disk('s3')->files("/newcustomerzoneassets/employeeprofileimage/".$employeeid);             
             if(count($listfiles) > 0){
                $profilepic = config('app.AWS_URL')."/".$listfiles[0];
            }
             else
             {
                $profilepic = config('app.AWS_URL')."/newcustomerzoneassets/img/dummy_male.png";
             }
            
            
                //dd($getpayslip); 
            $mainarray = array();
            if(!empty($getpayslip)){
                $mainarray['result'] = $getpayslip['Payslip_Details'];
                $request->session()->put('payslipsess',$mainarray);
            }
            
            if(count($mainarray) == 0){
                $request->session()->flash("error_msg", "Payslip view not applicable for this selection!");
                return redirect()->back();
            }
            
            //dd($mainarray);
            
            return view('newemployeezone.newpayslip')->with(['getemployeedata'=> $getemployeedata,'getpayslip'=>$mainarray,'premonth' => $premonth,'preyear'=>$preyear,'profilepic' => $profilepic]);
            
               }
        else{
            return redirect()->route('newemployee_home');
        }
    }

     public function getviewpayslip(Request $request){
        
        if ($request->session()->has('employeesession')) {
            $encrypt = $request->session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $employeeid = $split[0];
            $getemployeedata = DB::connection('mysql6')->table('employee')->where('id', '=', $employeeid)->get();

            $pwd_status = $this->is_emp_didnt_passwordchanged($employeeid);
            if ($pwd_status == 0) {
                $request->session()->flash("error_msg", 'Please change the default password. Only if you Change the default password , other functionalities on this portal will work. This is done for security purposes. Please do not share your password with anyone');
                return redirect()->route('newemployee_mydetails_passchange');
            }
            
                        
              if($request->session()->has('payslipsess')){
            $mainarray = $request->session()->get('payslipsess');
        }else
        {
            return redirect()->route('payslip');
        }
            
          
                        
            
           
            
            //dd($mainarray);
            
            return view('newemployeezone.newpayslip')->with(['getemployeedata'=> $getemployeedata,'getpayslip'=>$mainarray]);
            
               }
        else{
            return redirect()->route('newemployee_home');
        }
    }
    
    public function emprequest(Request $request){
        
        if ($request->session()->has('employeesession')) {
            $encrypt = $request->session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $employeeid = $split[0];
            $getemployeedata = DB::connection('mysql6')->table('employee')->where('id', '=', $employeeid)->get();

            $pwd_status = $this->is_emp_didnt_passwordchanged($employeeid);
            if ($pwd_status == 0) {
                $request->session()->flash("error_msg", 'Please change the default password. Only if you Change the default password , other functionalities on this portal will work. This is done for security purposes. Please do not share your password with anyone');
                return redirect()->route('newemployee_mydetails_passchange');
            }
            
                       
            $getrequest = $this->ShowRequest($employeeid);
            
            //dd($getrequest);
                        
             $listfiles = Storage::disk('s3')->files("/newcustomerzoneassets/employeeprofileimage/".$employeeid);             
             if(count($listfiles) > 0){
                $profilepic = config('app.AWS_URL')."/".$listfiles[0];
            }
             else
             {
                $profilepic = config('app.AWS_URL')."/newcustomerzoneassets/img/dummy_male.png";
             }
            
            
                //dd($getpayslip);    
            
            
            return view('newemployeezone.emprequest')->with(['getemployeedata'=> $getemployeedata,'getrequest'=>$getrequest,'profilepic' => $profilepic]);
            
               }
        else{
            return redirect()->route('newemployee_home');
        }
    }
    public function postemprequest(Request $request){
        
        if ($request->session()->has('employeesession')) {
            $encrypt = $request->session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $employeeid = $split[0];
            $getemployeedata = DB::connection('mysql6')->table('employee')->where('id', '=', $employeeid)->get();
            
                       
            
            
            $validate = $this->validate($request, [
            'close' => 'required'
                 ]);
            //dd($request->close);
            
            $closerequest = $this->CloseRequest($employeeid, $request->close);
                        
           if($closerequest['STATUS'] != ''){
               $request->session()->flash("suc_msg", $closerequest['STATUS']);
                return redirect()->back(); 
           }
            
               }
        else{
            return redirect()->route('newemployee_home');
        }
    }
    
    public function empraiserequest(Request $request){
        
        if ($request->session()->has('employeesession')) {
            $encrypt = $request->session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $employeeid = $split[0];
            $getemployeedata = DB::connection('mysql6')->table('employee')->where('id', '=', $employeeid)->get();
            
            $pwd_status = $this->is_emp_didnt_passwordchanged($employeeid);
            if ($pwd_status == 0) {
                $request->session()->flash("error_msg", 'Please change the default password. Only if you Change the default password , other functionalities on this portal will work. This is done for security purposes. Please do not share your password with anyone');
                return redirect()->route('newemployee_mydetails_passchange');
            }
            
                        
             $listfiles = Storage::disk('s3')->files("/newcustomerzoneassets/employeeprofileimage/".$employeeid);             
             if(count($listfiles) > 0){
                $profilepic = config('app.AWS_URL')."/".$listfiles[0];
            }
             else
             {
                $profilepic = config('app.AWS_URL')."/newcustomerzoneassets/img/dummy_male.png";
             }
            
            
                //dd($getpayslip);    
            
            
            return view('newemployeezone.raiseemprequest')->with(['getemployeedata'=> $getemployeedata,'profilepic' => $profilepic]);
            
               }
        else{
            return redirect()->route('newemployee_home');
        }
    }
    public function postempraiserequest(Request $request){
        
        if ($request->session()->has('employeesession')) {
            $encrypt = $request->session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $employeeid = $split[0];
            $getemployeedata = DB::connection('mysql6')->table('employee')->where('id', '=', $employeeid)->get();
            
             $validate = $this->validate($request, [
            'desccomp' => 'required',
            'subject' => 'required',
                 ]);
            //dd($request->desccomp);
            $attr = array();
            $attr['desccomp'] = $request->desccomp;
            $attr['subject'] = $request->subject;
            $raisereq = $this->raiseequest($employeeid,$attr);
            if($raisereq['Request_ID'] != ''){
               $request->session()->flash("suc_msg", "Your Request submitted successfully! &nbsp; Your request no is ".$raisereq['Request_ID']);
                return redirect()->back(); 
           }
            
            
               }
        else{
            return redirect()->route('newemployee_home');
        }
    }
    
    public function mytraining(Request $request){
        
        if ($request->session()->has('employeesession')) {
            $encrypt = $request->session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $employeeid = $split[0];
            $getemployeedata = DB::connection('mysql6')->table('employee')->where('id', '=', $employeeid)->get();

            $pwd_status = $this->is_emp_didnt_passwordchanged($employeeid);
            if ($pwd_status == 0) {
                $request->session()->flash("error_msg", 'Please change the default password. Only if you Change the default password , other functionalities on this portal will work. This is done for security purposes. Please do not share your password with anyone');
                return redirect()->route('newemployee_mydetails_passchange');
            }
            
            foreach($getemployeedata as $emp){
                $department = $emp->department;
                $plantid = $emp->plantid;
                
            }
            //dd($employeeid);
            
            $getmytraining = $this->mynewtraining($employeeid,$department,$plantid);
               // dd($getmytraining);        
             $listfiles = Storage::disk('s3')->files("/newcustomerzoneassets/employeeprofileimage/".$employeeid);             
             if(count($listfiles) > 0){
                $profilepic = config('app.AWS_URL')."/".$listfiles[0];
            }
             else
             {
                $profilepic = config('app.AWS_URL')."/newcustomerzoneassets/img/dummy_male.png";
             }
            
            
                //dd($getpayslip);    
            
            
            return view('newemployeezone.mytraining')->with(['getemployeedata'=> $getemployeedata,'getmytraining'=>$getmytraining,'profilepic' => $profilepic]);
            
               }
        else{
            return redirect()->route('newemployee_home');
        }
    }


    public function feedback(Request $request){
        
        if ($request->session()->has('employeesession')) {
            $encrypt = $request->session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $employeeid = $split[0];
            $getemployeedata = DB::connection('mysql6')->table('employee')->where('id', '=', $employeeid)->get();

            $pwd_status = $this->is_emp_didnt_passwordchanged($employeeid);
            if ($pwd_status == 0) {
                $request->session()->flash("error_msg", 'Please change the default password. Only if you Change the default password , other functionalities on this portal will work. This is done for security purposes. Please do not share your password with anyone');
                return redirect()->route('newemployee_mydetails_passchange');
            }
            
            foreach($getemployeedata as $emp){
                $department = $emp->department;
                $plantid = $emp->plantid;
                
            }
            //dd($employeeid);
            
            // $getmytraining = $this->mynewtraining($employeeid,$department,$plantid);
            //    // dd($getmytraining);        
             $listfiles = Storage::disk('s3')->files("/newcustomerzoneassets/employeeprofileimage/".$employeeid);             
             if(count($listfiles) > 0){
                $profilepic = config('app.AWS_URL')."/".$listfiles[0];
            }
             else
             {
                $profilepic = config('app.AWS_URL')."/newcustomerzoneassets/img/dummy_male.png";
             }
            
            
            // //dd($getpayslip);    
            
            
            return view('newemployeezone.feedback')->with(['getemployeedata'=> $getemployeedata,'profilepic' => $profilepic]);
            
        }else{
            return redirect()->route('newemployee_home');
        }
    }

    public function postfeedback(){
        
    }
            
    public function flattenParts($messageParts, $flattenedParts = array(), $prefix = '', $index = 1, $fullPrefix = true) 
	{
		if (is_array($messageParts) || is_object($messageParts))
		{
			foreach($messageParts as $part) {
				$flattenedParts[$prefix.$index] = $part;
				if(isset($part->parts)) {
				
					if($part->type == 2) {
						$flattenedParts = $this->flattenParts($part->parts, $flattenedParts, $prefix.$index.'.', 0, false);
					}
					elseif($fullPrefix) {
						$flattenedParts = $this->flattenParts($part->parts, $flattenedParts, $prefix.$index.'.');
					}
					else {
						$flattenedParts = $this->flattenParts($part->parts, $flattenedParts, $prefix);
					}
					unset($flattenedParts[$prefix.$index]->parts);
				}
				$index++;
			}
		}
		return $flattenedParts;		
	}
		
	public function getPart($connection, $messageNumber, $partNumber, $encoding) {
		
		$data = imap_fetchbody($connection, $messageNumber, $partNumber);
		
		switch($encoding) {
			case 0: return $data; // 7BIT
			case 1: return imap_8bit($data); // 8BIT
			case 2: return imap_base64(imap_binary($data)); // BINARY
			case 3: return base64_decode($data)/* imap_base64($text) */; // BASE64
			case 4: return quoted_printable_decode($data); // QUOTED_PRINTABLE
			case 5: return $data; // OTHER
		}
	}
	
	public function getFilenameFromPart($part) {
		
		$filename = '';
		
		if($part->ifdparameters) {
			foreach($part->dparameters as $object) {
				if(strtolower($object->attribute) == 'filename') {
					$filename = $object->value;
				}
			}
		}
		
		if(!$filename && $part->ifparameters) {
			foreach($part->parameters as $object) {
				if(strtolower($object->attribute) == 'name') {
					$filename = $object->value;
				}
			}
		}
		
		return $filename;
		
	}
    
    public function smscurl($message, $mobileno)
{
/*$fullurl = "http://www.adithya.me/adithya/Api/";
$fields = array(
    'username'      => 'vgn',
    'password'      => 'vgn@123',
    'senderid'    => 'VGNALT',
    'message'      => $message,
    'msgtype'      => 'normal',
    'mobileno'      => $mobileno
);*/

/*$fullurl = "http://sms6.rmlconnect.net:8080/bulksms/bulksms";
$fields = array(
    'username'      => 'vgnotp',
    'password'      => 'Vgn@!($@',
    'type'    => 0,
    'dlr'      => 1,
    'destination'      => $mobileno,
    'source'      => 'VGNOTP',
    'message'      => $message
);*/

$fullurl = "https://api-alerts.kaleyra.com/v4/";
$fields = array(
    'api_key'      => 'A8ef4022b54eff4bb372e8b140507f763',
    'method'      => 'sms',
    'message'      => $message.' - VGN Projects Estates.',
    'to'      => $mobileno,
    'sender' => 'VGNOTP'
);

//open connection
$ch = curl_init();

//set the url, number of POST vars, POST data
curl_setopt($ch, CURLOPT_URL, $fullurl);
curl_setopt($ch, CURLOPT_POST, count($fields));
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($fields));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

//execute post
$result = curl_exec($ch);

//close connection
curl_close($ch);

return $result;
}
public function sendmail($contents)
{
    require_once('phpmailer/PHPMailerAutoload.php');
// $contents['toname']=>
// $contents['toemail']=>
// $contents['subject']=>
// $contents['content']=>
// $contents['html']=>
// $contents['att_url']=>
//Create a new PHPMailer instance
$mail = new \PHPMailer();
$return=array();
//Tell PHPMailer to use SMTP
$mail->isSMTP();

//Enable SMTP debugging
// 0 = off (for production use)
// 1 = client messages
// 2 = client and server messages
$mail->SMTPDebug = 0;

//Ask for HTML-friendly debug output
$mail->Debugoutput = 'html';

//Set the hostname of the mail server
// $mail->Host = 'smtp.gmail.com';
$mail->Host = 'mail.vgn.in';
// use
// $mail->Host = gethostbyname('smtp.gmail.com');
// if your network does not support SMTP over IPv6

//Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
$mail->Port = 587;
// $mail->Port = 25;

//Set the encryption system to use - ssl (deprecated) or tls
//$mail->SMTPSecure = 'tls';

//Whether to use SMTP authentication
$mail->SMTPAuth = true;

//Username to use for SMTP authentication - use full email address for gmail
$mail->Username = "vendorzone3";

//Password to use for SMTP authentication
$mail->Password = "Vgn@321";

//Set who the message is to be sent from
$mail->setFrom('vendorzone3@vgn.in', 'VGN Employee Zone');

//Set an alternative reply-to address
$mail->addReplyTo('no-reply@vgn.in', 'VGN Employee Zone');

//Set who the message is to be sent to
$mail->addAddress($contents['toemail'], $contents['toname']);

//Set the subject line
$mail->Subject = $contents['subject'];

//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
// $mail->msgHTML(file_get_contents($contents['html']), dirname(__FILE__));
$mail->Body=$contents['content'];

//Replace the plain text body with one created manually
$mail->AltBody = $contents['content'];

//Attach an image file
if(!empty($contents['att_url']))
$mail->addAttachment($contents['att_url']);

//send the message, check for errors
if (!$mail->send()) {
// if (0) {
    $return['code']= 500;
    $return['msg']= "Mailer Error: " . $mail->ErrorInfo."";
} else {
    $return['code']= 200;
    $return['msg']= "Mail Sent to your Registered EMail!";
}
return $return;
}
    

        
    
    public function newlogout(Request $request)
    {
        if ($request->session()->has('employeesession')) {
        	$encrypt = $request->session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $employeeid = $split[0];            
            $request->session()->forget('employeesession');
			  if ($request->session()->has('is_report_manager')) {
                     $request->session()->forget('is_report_manager');
                 }
                 if ($request->session()->has('is_notice_period')) {
                     $request->session()->forget('is_notice_period');
                 }
                  if ($request->session()->has('is_contract')) {
                     $request->session()->forget('is_contract');
                 }
                  if ($request->session()->has('is_security')) {
                     $request->session()->forget('is_security');
                 }

                 $request->session()->flush();
                 $check_cred = DB::connection('mysql6')->table('employee_credentials')->where('id','=',$employeeid)->count();
                   if ($check_cred > 0) {
                   	DB::connection('mysql6')->table('employee_credentials')->where('id','=',$employeeid)->update([
                   		'is_loggined' => 0
                   	]);
                   }

                   $request->session()->invalidate();
            return redirect()->route('newemployee_home');
        }
        else{
            return redirect()->route('newemployee_home');
        }
    }
    
    
    public function newempeditphoto(Request $request){
        
         if ($request->session()->has('employeesession')) {
            $encrypt = $request->session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $employeeid = $split[0];
            $getemployeedata = DB::connection('mysql6')->table('employee')->where('id', '=', $employeeid)->get();

            $pwd_status = $this->is_emp_didnt_passwordchanged($employeeid);
            if ($pwd_status == 0) {
                $request->session()->flash("error_msg", 'Please change the default password. Only if you Change the default password , other functionalities on this portal will work. This is done for security purposes. Please do not share your password with anyone');
                return redirect()->route('newemployee_mydetails_passchange');
            }
            
             
            $listfiles = Storage::disk('s3')->files("/newcustomerzoneassets/employeeprofileimage/".$employeeid);             
             if(count($listfiles) > 0){
                $profilepic = config('app.AWS_URL')."/".$listfiles[0];
            }
             else
             {
                $profilepic = config('app.AWS_URL')."/newcustomerzoneassets/img/dummy_male.png";
             }
            //$exists = Storage::disk('local')->has("customersprofileimage/$customerid.jpg");
            
            return view('newemployeezone.editphoto')->with(['getemployeedata'=> $getemployeedata, 'profilepic' => $profilepic]);
             
         }else
         {
             return redirect()->route('newemployee_home');
         }
        
    }
    
    public function delete_files($target){
         if(Storage::disk('s3')->exists($target)){
	dd($target);
        $files = glob( $target . '*', GLOB_MARK ); //GLOB_MARK adds a slash to directories returned
        
        foreach( $files as $file )
        {
            $this->delete_files( $file );      
        }
             if(Storage::disk('s3')->exists($target)){
      
        Storage::disk('s3')->deleteDirectory( $target );
             }
    } elseif(is_file($target)) {
        unlink( $target );  
    }
        
    }
    
    public function newempposteditphoto(Request $request){
        
         if ($request->session()->has('employeesession')) {
            $encrypt = $request->session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $employeeid = $split[0];
            $getemployeedata = DB::connection('mysql6')->table('employee')->where('id', '=', $employeeid)->get();
             
            $validate = $this->validate($request, [
            'photo' => 'required|image|min:20|max:5000',
			]);
             
             $file = $request->file('photo');
             $filename = $file->getClientOriginalName();
             $destinationpath = $employeeid;
             $ext = pathinfo($filename, PATHINFO_EXTENSION);
             //dd($request);
             
             $path = config('app.AWS_URL')."/newcustomerzoneassets/employeeprofileimage/".$destinationpath;
             
             $checkdir = Storage::disk('s3')->exists($path);
		//dd($checkdir);
		//dd($path);
             if($checkdir == true){
             $this->delete_files($path);
                 //system('/bin/rm -rf ' . escapeshellarg($path));
             //rmdir( $path );
             }
             
             //unlink($path.$destinationpath);
             
             //dd('ok');
             
            //$listfiles = Storage::disk('employeeprofilepic_uploads')->files($employeeid);
            //if(count($listfiles) > 0){
                //Storage::deleteDirectory($employeeid);
                //Storage::disk('employeeprofilepic_uploads')->delete($employeeid);
                
            //}
             //dd($listfiles);
             
             
             $uploadeddatetime = date('Ymd');
             $randomno = rand(1, 1000000);
             $newname = $uploadeddatetime.$randomno.'VGNemployee';
             //Storage::disk('employeeprofilepic_uploads')->makeDirectory($destinationpath, 0777);
             $uploaded = Storage::disk('s3')->putFileAs('/newcustomerzoneassets/employeeprofileimage/'.$destinationpath, $request->file('photo'), $newname.'.'.$ext);
             
            // $uploaded = move_uploaded_file($request->file('photo'), $path."/". $newname.'.'.$ext);
             
             
             
             if($uploaded){
                 $request->session()->flash("suc_msg", "successfully Profile picture Uploaded!");
                return redirect()->back();     
             }
             else
             {
                 $request->session()->flash("error_msg", "Profile picture not uploaded. Try Again!");
                return redirect()->back();     
             }
             
             
             
         }else
         {
             return redirect()->route('newemployee_home');
         }
        
    }
    
    public function newforgotpwd()
{
    return view('newemployeezone.forgotpwd');
}

public function modifiedforgotpwd(Request $request)
    {
            $validate = $this->validate($request, [
            'forgotusername' => 'required'
            ]);


 if (strpos($request->forgotusername, '@') !== false) {
            $loginmode = 'loginmode_emailid';
        }
        elseif (ctype_digit($request->forgotusername)) {

            if (strlen($request->forgotusername) == 10) {
                $loginmode = 'loginmode_mobileno';
            }
            elseif((strlen($request->forgotusername) >= 3)&&(strlen($request->forgotusername) < 10)){
                $loginmode = 'loginmode_employeeid';
            }
            else{
                
                return 0;
            }
                
        }
        else{
                return 0;
        }

        $arr = [];
        if ($loginmode == 'loginmode_employeeid') {
            $arr['EMP_ID'] = $request->forgotusername;
            $arr['MOBILE_NO'] = '';
            $arr['E_MAIL'] = '';
        }
        if ($loginmode == 'loginmode_mobileno') {
            $arr['EMP_ID'] = '';
            $arr['MOBILE_NO'] = $request->forgotusername;
            $arr['E_MAIL'] = '';
        }
        if ($loginmode == 'loginmode_emailid') {
            $arr['EMP_ID'] = '';
            $arr['MOBILE_NO'] = '';
            $arr['E_MAIL'] = $request->forgotusername;
        }

        if (!empty($arr)) {
            $res = $this->checkemployee($arr);
            if ($res['NAME'] == '0') {
                return 'Invalid User. Try with valid username';
            }
            if (($res['MOBILE_NO'] == '0') && ($res['E_MAIL'] == '0')) {
                return 'Please contact HR. Your registered mobile number and mail id is blank!';
            }

            if (($res['EMP_ID'] != '0') && ($res['NAME'] != '0') ) {
                $todaydateonly = Carbon::now()->toDateString();
                

                $checktodaysdateexist = DB::connection('mysql6')->table('empforgotpwdotp_confirmation')->where(['emp_id' => $res['EMP_ID']])->where('created_datetime','LIKE','%'.$todaydateonly.'%')->count();
                $otp = rand(0,189999);
                $now = Carbon::now()->toDateTimeString();
                
                $expirytime = Carbon::now()->addMinutes(5)->toDateTimeString();
                //start
                if ($checktodaysdateexist == 0) {
                    //generate otp and send to customer
                    $smscontent = "Dear ".$res['NAME'].", Your Employee Login Forgot Password OTP is ".$otp; 
                if($res['MOBILE_NO'] != '0'){
               $sms_status = $this->smscurl($smscontent, $res['MOBILE_NO']);
                    }
                    $newmaildata = [];
                    $newmaildata['name'] = $res['NAME'];
                    $newmaildata['otp'] = $otp;
                    $newmaildata['subject'] = "VGN Employee Login Forgot Password OTP";
                    $newmaildata['content'] = "Your One Time Password for Employee Login Forgot Password is $otp";
                    if($res['E_MAIL'] != '0'){
               Log::info('Sending forgot pwd otp = '.$res['E_MAIL']);
                                    Mail::to($res['E_MAIL'])->send(new sendforgotpwdotp($newmaildata));
                                }
               
                    //insert record in db
                    //return otp submit page
                     DB::connection('mysql6')->table('empforgotpwdotp_confirmation')->insert(['emp_id' => $res['EMP_ID'],'otp' => $otp,'created_datetime' => $now,'validity_datetime' => $expirytime,'tried_count' => 1]);

                    return 1;
                }
                else{
                    $getdata1 = DB::connection('mysql6')->table('empforgotpwdotp_confirmation')->where(['emp_id' => $res['EMP_ID']])->where('created_datetime','LIKE','%'.$todaydateonly.'%')->get();

                    foreach ($getdata1 as $key_getdata1 => $value_getdata1) {
                        $triedcount = $value_getdata1->tried_count;
                        $createdtime = $value_getdata1->created_datetime;
                        $extime = $value_getdata1->validity_datetime;
                    }

                    if ($triedcount <= 5) {

                         $smscontent = "Dear ".$res['NAME'].", Your Employee Login Forgot Password OTP is ".$otp; 
                if($res['MOBILE_NO'] != '0'){
               $sms_status = $this->smscurl($smscontent, $res['MOBILE_NO']);
                    }
                    $newmaildata = [];
                    $newmaildata['name'] = $res['NAME'];
                    $newmaildata['otp'] = $otp;
                    $newmaildata['subject'] = "VGN Employee Login Forgot Password OTP";
                    $newmaildata['content'] = "Your One Time Password for Employee Login Forgot Password is $otp";
                    if($res['E_MAIL'] != '0'){
               Log::info('Sending forgot pwd otp = '.$res['E_MAIL']);
                                    Mail::to($res['E_MAIL'])->send(new sendforgotpwdotp($newmaildata));
                                }

                        //update 
                        $add1hour = Carbon::parse($createdtime)->addhours(1)->toDateTimeString();
                        if (Carbon::now()->gte(Carbon::parse($add1hour))) {
                            DB::connection('mysql6')->table('empforgotpwdotp_confirmation')->where(['emp_id' => $res['EMP_ID']])->where('created_datetime','LIKE','%'.$todaydateonly.'%')->update([
                                'otp' => $otp,
                                'created_datetime' => $now,
                                'validity_datetime' => $expirytime, 
                                'tried_count' => 1 ]);

                            return 1;
                        }
                        else{

                             $smscontent = "Dear ".$res['NAME'].", Your Employee Login Forgot Password OTP is ".$otp; 
                if($res['MOBILE_NO'] != '0'){
               $sms_status = $this->smscurl($smscontent, $res['MOBILE_NO']);
                    }
                    $newmaildata = [];
                    $newmaildata['name'] = $res['NAME'];
                    $newmaildata['otp'] = $otp;
                    $newmaildata['subject'] = "VGN Employee Login Forgot Password OTP";
                    $newmaildata['content'] = "Your One Time Password for Employee Login Forgot Password is $otp";
               Log::info('Sending forgot pwd otp = '.$res['E_MAIL']);
               if($res['E_MAIL'] != '0'){
                                    Mail::to($res['E_MAIL'])->send(new sendforgotpwdotp($newmaildata));
                                }

                        DB::connection('mysql6')->table('empforgotpwdotp_confirmation')->where(['emp_id' => $res['EMP_ID']])->where('created_datetime','LIKE','%'.$todaydateonly.'%')->update([
                                'otp' => $otp,
                                'validity_datetime' => $expirytime, 
                                'tried_count' => $triedcount+1 ]);

                        return 1;
                        }
                    }
                    else{
                         

                        $add1hour = Carbon::parse($createdtime)->addhours(1)->toDateTimeString();

                        if (Carbon::now()->gte(Carbon::parse($add1hour))) {

                            $smscontent = "Dear ".$res['NAME'].", Your Employee Login Forgot Password OTP is ".$otp; 
                if($res['MOBILE_NO'] != '0'){
               $sms_status = $this->smscurl($smscontent, $res['MOBILE_NO']);
                    }
                    $newmaildata = [];
                    $newmaildata['name'] = $res['NAME'];
                    $newmaildata['otp'] = $otp;
                    $newmaildata['subject'] = "VGN Employee Login Forgot Password OTP";
                    $newmaildata['content'] = "Your One Time Password for Employee Login Forgot Password is $otp";
                    if($res['E_MAIL'] != '0'){
               Log::info('Sending forgot pwd otp = '.$res['E_MAIL']);
                                    Mail::to($res['E_MAIL'])->send(new sendforgotpwdotp($newmaildata));
                                }
                                
                            DB::connection('mysql6')->table('empforgotpwdotp_confirmation')->where(['emp_id' => $res['EMP_ID']])->where('created_datetime','LIKE','%'.$todaydateonly.'%')->update([
                                'otp' => $otp,
                                'created_datetime' => $now,
                                'validity_datetime' => $expirytime, 
                                'tried_count' => 1 ]);

                            return 1;
                        }
                        else{
                            
                            return "Try After 1 hour. Maximum number of attempts reached.";
                        }
                        
                        //get last created datetime
                        //reset createdtime and send otp
                    }


                }

                //end

               
                
            }else{
                return 0;
            }







            return json_encode($res);
        }else{ return 0;}

        
    }


    public function otpvalidation(Request $request)
    {
         $validate = $this->validate($request, [
            'forgotusername' => 'required'
            ]);


 if (strpos($request->forgotusername, '@') !== false) {
            $loginmode = 'loginmode_emailid';
        }
        elseif (ctype_digit($request->forgotusername)) {

            if (strlen($request->forgotusername) == 10) {
                $loginmode = 'loginmode_mobileno';
            }
            elseif((strlen($request->forgotusername) >= 3)&&(strlen($request->forgotusername) < 10)){
                $loginmode = 'loginmode_employeeid';
            }
            else{
                
                return 0;
            }
                
        }
        else{
                return 0;
        }

        $arr = [];
        if ($loginmode == 'loginmode_employeeid') {
            $arr['EMP_ID'] = $request->forgotusername;
            $arr['MOBILE_NO'] = '';
            $arr['E_MAIL'] = '';
        }
        if ($loginmode == 'loginmode_mobileno') {
            $arr['EMP_ID'] = '';
            $arr['MOBILE_NO'] = $request->forgotusername;
            $arr['E_MAIL'] = '';
        }
        if ($loginmode == 'loginmode_emailid') {
            $arr['EMP_ID'] = '';
            $arr['MOBILE_NO'] = '';
            $arr['E_MAIL'] = $request->forgotusername;
        }


        if (!empty($arr)) {
            $res = $this->checkemployee($arr);

            if (($res['EMP_ID'] != '0') && ($res['NAME'] != '0')) {
                $now = Carbon::now()->toDateTimeString();
                $todaystring = Carbon::now()->toDateString();
                $add5min = Carbon::now()->addMinutes(5)->toDateTimeString();
                

                $checkotpmatch = DB::connection('mysql6')->table('empforgotpwdotp_confirmation')->where(['emp_id' => $res['EMP_ID'],'otp' => $request->submitotp])->where('validity_datetime','<=',$add5min)->count();
                if ($checkotpmatch == '1') {
                    $todaystring1 = str_replace('-', '', $todaystring);
                    $toencrypt = $res['EMP_ID'].'-#'.$request->submitotp.'-#'.$todaystring1;
                    $encrypt = Crypt::encrypt($toencrypt);

                    $request->session()->put('empresetpwd', $encrypt);
                    return 1;

                }
                else{
                    return 0;    
                }
                
                
                

            }
            else{
                return 0;
            }
        }
        else{
            return 0;
        }



    }

    public function resetlink(Request $request)
    {
        if ($request->session()->has('empresetpwd')) {
            $encrypt = $request->session()->get('empresetpwd');
            $decrypt = Crypt::decrypt($encrypt);
            //dd($decrypt);
            $split = explode("-#",$decrypt);
            
            $employeeid = $split[0];
            $otp = $split[1];
            $todaydateonly = Carbon::now()->toDateString();

            $checktodaysdateexist = DB::connection('mysql6')->table('empforgotpwdotp_confirmation')->where(['emp_id' => $employeeid,'otp' => $otp])->where('created_datetime','LIKE','%'.$todaydateonly.'%')->count();

            if ($checktodaysdateexist == 1) {
                return view('newemployeezone.resetlink');
            }
            else{
                $request->session()->forget('empresetpwd');
                return redirect()->back();
            }

        }
        else{
            return redirect()->route('newemployee_home');
        }
    }

    public function postresetlink(Request $request)
    {
        if ($request->session()->has('empresetpwd')) {
            $encrypt = $request->session()->get('empresetpwd');
            $decrypt = Crypt::decrypt($encrypt);
            //dd($decrypt);
            $split = explode("-#",$decrypt);

            $employeeid = $split[0];
            $otp = $split[1];
            $todaydateonly = Carbon::now()->toDateString();

            $checktodaysdateexist = DB::connection('mysql6')->table('empforgotpwdotp_confirmation')->where(['emp_id' => $employeeid,'otp' => $otp])->where('created_datetime','LIKE','%'.$todaydateonly.'%')->count();

            if ($checktodaysdateexist == 1) {
                    
                    if (($request->newpass != '')&&(($request->retypepass != ''))) {

                if (($request->newpass != $request->retypepass)) {
                $request->session()->flash("error_msg", "New Password and Retype Password must be same!");
                return redirect()->back()->withInput();
                }
                else{

                    //do the updation and redirect to customerlogin
                    $checkindb = DB::connection('mysql6')->table('employee')->where(['id' => $employeeid])->count();

                    $arr = [];
            $arr['EMP_ID'] = $employeeid;
            $arr['MOBILE_NO'] = '';
            $arr['E_MAIL'] = '';
            $res = $this->checkemployee($arr);



                    if ($checkindb == 1) {
                        

                         $updatepassword = $this->forgotsappassword($employeeid, $request->newpass,$request->retypepass);
            
            
        if ($updatepassword['STATUS'] == 'Password Updated') {
            
            DB::connection('mysql6')->table('employee')->where(['id' => $employeeid])->update(['name' => $res['NAME'],'personal_mobile' => $res['MOBILE_NO'],'officialmail' => $res['E_MAIL']]);

                        DB::connection('mysql6')->table('dashboard')->where('employee_id', '=', $employeeid)->update(['last_password_changed' => date('Y-m-d')]);
            
                $request->session()->flash("suc_msg", "Password Successfully Updated. Please try to login.");
            
        }
        else
        {
          $request->session()->flash("error_msg", $updatepassword['STATUS']);
            
        }
                    }
                    else{

                        $updatepassword = $this->forgotsappassword($employeeid, $request->newpass,$request->retypepass);
            
            
        if ($updatepassword['STATUS'] == 'Password Updated') {
            
                $request->session()->flash("suc_msg", "Password Successfully Updated. Please try to login.");
            
        }
        else
        {
          $request->session()->flash("error_msg", $updatepassword['STATUS']);
            
        }

                    }

                    DB::connection('mysql6')->table('empforgotpwdotp_confirmation')->where(['emp_id' => $employeeid,'otp' => $otp])->delete();

                    $request->session()->forget('empresetpwd');
                
                return redirect()->route('newemployee_home');

                }

            }
            else{
                $request->session()->flash("error_msg", "Please fill the required fields!");
                return redirect()->back()->withInput();
            }


            }
            else{
                $request->session()->forget('empresetpwd');
                $request->session()->flash("error_msg", "Invalid Reset Link. Try with forgot password!");
                return redirect()->route('newemployee_home');
            }

            
            

            

            

        }
        else{
            return redirect()->back();
        }
    }

    
        public function newpostforgotpwd(Request $request)
{
    $validate = $this->validate($request, [
            'forgotusername' => 'required'
			]);


 if (strpos($request->forgotusername, '@') !== false) {
            $loginmode = 'loginmode_emailid';
        }
        elseif (ctype_digit($request->forgotusername)) {

            if (strlen($request->forgotusername) == 10) {
                $loginmode = 'loginmode_mobileno';
            }
            elseif((strlen($request->forgotusername) >= 3)&&(strlen($request->forgotusername) < 10)){
                $loginmode = 'loginmode_employeeid';
            }
            else{
                $request->session()->flash("error_msg", "Sorry! Enter a valid EmployeeId or Mobile Number");
                return redirect()->back()->withInput();
            }
                
        }
        else{
            
                $request->session()->flash("error_msg", "Sorry! Enter a valid Username");
                return redirect()->back()->withInput();
        }

        
        if ($loginmode == 'loginmode_employeeid') {
            if (!ctype_digit($request->forgotusername)) {
                
                $request->session()->flash("error_msg", "Sorry! Enter a valid Employee Id");
                return redirect()->back()->withInput();
            }
            $check = DB::connection('mysql6')->table('employee')->where(['id' => $request->forgotusername])->get();
        }

        elseif ($loginmode == 'loginmode_emailid') {

            if (!filter_var($request->forgotusername, FILTER_VALIDATE_EMAIL)) {
            $request->session()->flash("error_msg", "Sorry! Enter a valid Email Id");
                return redirect()->back()->withInput();
                }
            $check = DB::connection('mysql6')->table('employee')->where(['officialmail' => $request->forgotusername ])->get();
            
        }
        
        elseif ($loginmode == 'loginmode_mobileno') {

            if (!preg_match('/^[0-9]{10}+$/', $request->forgotusername)) {
                $request->session()->flash("error_msg", "Sorry! Enter a valid Mobile Number");
                return redirect()->back()->withInput();
                }
            $check = DB::connection('mysql6')->table('employee')->where(['personal_mobile' => $request->forgotusername ])->get();
        }
        else{
                $request->session()->flash("error_msg", "Sorry! Enter a valid Username!");
                return redirect()->back()->withInput();
        }


if(count($check) == 1){
    foreach ($check as $newkey => $newvalue) {
        
        $request->forgotusername = $newvalue->id;
    }
}
else{
                $request->session()->flash("error_msg", "Sorry! <b>Username Does not exist!</b>!");
                return redirect()->back()->withInput();
}


    $getemployeedatacount = DB::connection('mysql6')->table('employee')->where('id', '=', $request->forgotusername)->count();

        if ($getemployeedatacount != 0) {
            $getemployeedata = DB::connection('mysql6')->table('employee')->where('id', '=', $request->forgotusername)->get();
            $getresetdata = DB::connection('mysql6')->table('resetpwd')->where('employeeid', '=', $request->forgotusername)->get();

            if (count($getresetdata) != 0) {
                
            
            foreach ($getresetdata as $key => $value) {
                $employeeid = $value->employeeid;
                $pwd_token = $value->token;
                $expiredate = $value->expiredate;
            }

            $now = Carbon::now();
           
            $date1=date_create($now);
			date_add($date1,date_interval_create_from_date_string("1 days"));
			$addedexpiredate = date_format($date1,"Y-m-d H:i:s");
            //dd($addedexpiredate);

            $str = date('YmdHis').'-42'.rand(0,189999);
            $shuffled = str_shuffle($str);
            $token = $shuffled;
            foreach ($getemployeedata as $keyemployee => $employeevalue) {
                    $name = $employeevalue->name;
                    $email = $employeevalue->officialmail;
                    $mobile = $employeevalue->personal_mobile;
                }
            
            if ($now > $expiredate) {
//dd($addedexpiredate);
                $updateresetpwd = DB::connection('mysql6')->table('resetpwd')->where('employeeid','=',$employeeid)->update(['token'=>$token,'expiredate'=>$addedexpiredate]);
                
                $link="https://vgn.in/employeezone/resetpassword/".$employeeid."/".$token;
				$newmail=array();
				$newmail['toname']=$name;
				$newmail['toemail']=$email;
				$newmail['subject']="VGN Employee Zone - Reset Password Link!";
				$newmail['content']='<div style=" margin: 0 auto;  background-color: #eef5ff;padding: 2% 4%;font-size: 14px;"><div style="text-align: center;"><img src="//d2qetrl79qxrcm.cloudfront.net/images/custom/vgn-logo.png" alt="vgn-logo.jpg"></div>Dear '.$name.',<br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Please <a href="'.$link.'">Click Here</a> to reset your password.<br><br>Thanks,<br>VGN<br><div style="    text-align: center;    font-size: 88%;    color: rgb(124, 124, 124);">For Any details : <a href="https://www.vgn.in">www.vgn.in</a><br><span style="    color: rgb(23, 79, 163);
				font-weight: bold;">VGN Property Developers Private Limited</span>&nbsp;- No.153, Wallace Garden, 2nd Street, Nungambakkam, Chennai-600006.<br>Call Us: +91 44 4343 9900</div></div>';
				$newmail['html']="user-detail-contents.html";
				//$newmail['att_url']="images/logo.jpg";
                if(ctype_digit($mobile)){
                    if (strlen($mobile) == 10) {
                        
                //$smscontent='Dear '.$name.',<br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Please <a href="'.$link.'">Click Here</a> to reset your password.<br><br>Thanks,<br>VGN<br><div style="    text-align: center;    font-size: 88%;    color: rgb(124, 124, 124);">For Any details : <a href="https://www.vgn.in">www.vgn.in</a><br><span style="    color: rgb(23, 79, 163);				font-weight: bold;">VGN Property Developers Private Limited</span>&nbsp;- No.153, Wallace Garden, 2nd Street, Nungambakkam, Chennai-600006.<br>Call Us: +91 44 4343 9900</div>';
				
                //$smsurl = "http://www.adithya.me/adithya/Api/?username=vgn&password=vgn@123&senderid=VGNALT&message=$smscontent&msgtype=normal&mobileno=8754404619";
                $smscontent = 'Dear '.$name.', Click the below link to reset your password '.$link; 
                
               $sms_status = $this->smscurl($smscontent, $mobile);               
                DB::connection('mysql5')->table('sms_sent_data')->insert(['employeeid' => $employeeid,'sentdatetime' => $now]);
                    }
                }

				$mailstatus = $this->sendmail($newmail);
                $request->session()->flash("suc_msg", "Dear $name your password has been reset and sent successfully to your registered email and phone!");
				//$return="<suc>Password reset link was sent to your registered email address successfully! <debug>" . $customerid."</debug></suc><br/>".$mailstatus['msg'];
				return redirect()->route('newemployee_home');
                
            }
            else{
                $link="https://vgn.in/employeezone/resetpassword/".$employeeid."/".$pwd_token;
				$newmail=array();
				$newmail['toname']=$name;
				$newmail['toemail']=$email;
				$newmail['subject']="VGN Employee Zone - Reset Password Link!";
				$newmail['content']='<div style=" margin: 0 auto;  background-color: #eef5ff;padding: 2% 4%;font-size: 14px;"><div style="text-align: center;"><img src="//d2qetrl79qxrcm.cloudfront.net/images/custom/vgn-logo.png" alt="vgn-logo.jpg"></div>Dear '.$name.',<br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Please <a href="'.$link.'">Click Here</a> to reset your password.<br><br>Thanks,<br>VGN<br><div style="    text-align: center;    font-size: 88%;    color: rgb(124, 124, 124);">For Any details : <a href="https://www.vgn.in">www.vgn.in</a><br><span style="    color: rgb(23, 79, 163);
				font-weight: bold;">VGN Property Developers Private Limited</span>&nbsp;- No.153, Wallace Garden, 2nd Street, Nungambakkam, Chennai-600006.<br>Call Us: +91 44 4343 9900</div></div>';
				$newmail['html']="user-detail-contents.html";
				//$newmail['att_url']="images/logo.jpg";

                  if(ctype_digit($mobile)){
                    if (strlen($mobile) == 10) {
                        
                //$smscontent='Dear '.$name.',<br>Please <a href="'.$link.'">Click Here</a> to reset your password.<br><br>Thanks,<br>VGN<br><div style="    text-align: center;    font-size: 88%;    color: rgb(124, 124, 124);">For Any details : <a href="https://www.vgn.in">www.vgn.in</a><br><span style="    color: rgb(23, 79, 163);				font-weight: bold;">VGN Property Developers Private Limited</span>&nbsp;- No.153, Wallace Garden, 2nd Street, Nungambakkam, Chennai-600006.<br>Call Us: +91 44 4343 9900</div>';

                $smscontent = 'Dear '.$name.', Click the below link to reset your password '.$link;  
				
                
                $sms_status = $this->smscurl($smscontent, $mobile);
                DB::connection('mysql6')->table('sms_sent_data')->insert(['employeeid' => $employeeid,'sentdatetime' => $now]);
                    }
                }
				$mailstatus = $this->sendmail($newmail);
                $request->session()->flash("suc_msg", "Dear $name your password has been reset and sent successfully to your registered email and phone!");
				//$return="<suc>Password reset link was sent to your registered email address successfully! <debug>" . $customerid."</debug></suc><br/>".$mailstatus['msg'];
				return redirect()->route('newemployee_home');
            }

            
            $request->session()->flash("suc_msg", "Dear $name your password has been reset and sent successfully to your registered email and phone!");
				//$return="<suc>Password reset link was sent to your registered email address successfully! <debug>" . $customerid."</debug></suc><br/>".$mailstatus['msg'];
				return redirect()->route('newemployee_home');

            }
            else{
                
                
                $str = date('YmdHis').'-19'.rand(0,189999);
                $shuffled = str_shuffle($str);
                $token = $shuffled;
                $employeeid = $request->forgotusername;
                $now = Carbon::now();
                $date=date_create($now);
				date_add($date,date_interval_create_from_date_string("1 days"));
				$expiredate = date_format($date,"Y-m-d H:i:s");
                
                $insertresetpwd = DB::connection('mysql6')->table('resetpwd')->insert(['employeeid' => $employeeid, 'token'=>$token,'expiredate'=>$expiredate]);
                //$last_id = mysqli_insert_id($conn);
                foreach ($getemployeedata as $keyemployee => $employeevalue) {
                    $name = $employeevalue->name;
                    $email = $employeevalue->officialmail;
                    $mobile = $employeevalue->personal_mobile;
                }
                $link="https://vgn.in/employeezone/resetpassword/".$employeeid."/".$token;
				$newmail=array();
				$newmail['toname']=$name;
				$newmail['toemail']=$email;
				$newmail['subject']="VGN Employee Zone - Reset Password Link!";
				$newmail['content']='<div style=" margin: 0 auto;  background-color: #eef5ff;padding: 2% 4%;font-size: 14px;"><div style="text-align: center;"><img src="//d2qetrl79qxrcm.cloudfront.net/images/custom/vgn-logo.png" alt="vgn-logo.jpg"></div>Dear '.$name.',<br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Please <a href="'.$link.'">Click Here</a> to reset your password.<br><br>Thanks,<br>VGN<br><div style="    text-align: center;    font-size: 88%;    color: rgb(124, 124, 124);">For Any details : <a href="https://www.vgn.in">www.vgn.in</a><br><span style="    color: rgb(23, 79, 163);
				font-weight: bold;">VGN Property Developers Private Limited</span>&nbsp;- No.153, Wallace Garden, 2nd Street, Nungambakkam, Chennai-600006.<br>Call Us: +91 44 4343 9900</div></div>';
				$newmail['html']="user-detail-contents.html";
				//$newmail['att_url']="images/logo.jpg";
                 if(ctype_digit($mobile)){
                    if (strlen($mobile) == 10) {
                        
                //$smscontent='Dear '.$name.',<br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Please <a href="'.$link.'">Click Here</a> to reset your password.<br><br>Thanks,<br>VGN<br><div style="    text-align: center;    font-size: 88%;    color: rgb(124, 124, 124);">For Any details : <a href="https://www.vgn.in">www.vgn.in</a><br><span style="    color: rgb(23, 79, 163);				font-weight: bold;">VGN Property Developers Private Limited</span>&nbsp;- No.153, Wallace Garden, 2nd Street, Nungambakkam, Chennai-600006.<br>Call Us: +91 44 4343 9900</div>';
				$smscontent = 'Dear '.$name.', Click the below link to reset your password '.$link; 
                $sms_status = $this->smscurl($smscontent, $mobile);
                DB::connection('mysql6')->table('sms_sent_data')->insert(['employeeid' => $employeeid,'sentdatetime' => $now]);
                    }
                }
				$mailstatus = $this->sendmail($newmail);
                $request->session()->flash("suc_msg", "Dear $name your password has been reset and sent successfully to your registered email and phone!");
				//$return="<suc>Password reset link was sent to your registered email address successfully! <debug>" . $customerid."</debug></suc><br/>".$mailstatus['msg'];
				return redirect()->route('newemployee_home');
            }
        }
        else{
            $request->session()->flash("error_msg", "Invalid or Blocked Username!");
            return redirect()->route('newemployeeforgotpassword');
        }
    //dd($getcustomerdata);

}
    
    public function resetpassword(Request $request, $id, $key)
{
    $employeeid = $id;
    $token = $key;

    if(($employeeid != null)&&($token != null))
    {
        $checkrestdata = DB::connection('mysql6')->table('resetpwd')->where('employeeid', '=', $employeeid)->where('token', '=', $token)->count();
    
        if($checkrestdata == 1){

            $getrestdata = DB::connection('mysql6')->table('resetpwd')->where('employeeid', '=', $employeeid)->where('token', '=', $token)->get();
            foreach ($getrestdata as $key => $value) {
                $expiredate = $value->expiredate;
            }
            
            $now = Carbon::now();
            if ($now > $expiredate) {
                $request->session()->flash("error_msg", "Password reset time limit expired!");
                return redirect()->route('newemployee_home');
            }
            else{
                return view('newemployeezone.resetpassword')->with(['employeeid' => $employeeid, 'token'=> $token]);
            }
        }
        else{
            return redirect()->route('newemployee_home');
        }
    }
    else{
            return redirect()->route('newemployee_home');
    }
}
    
    public function postresetpassword(Request $request, $id, $key)
{
     $validate = $this->validate($request, [
			'newpass' => 'required|min:6|max:12',
            'retypepass' => 'required|same:newpass'
			]);

    $employeeid = $id;
    $token = $key;
    

    if(($employeeid != null)&&($token != null))
    {
        $checkrestdata = DB::connection('mysql6')->table('resetpwd')->where('employeeid', '=', $employeeid)->where('token', '=', $token)->count();

        if($checkrestdata == 1){

            $getrestdata = DB::connection('mysql6')->table('resetpwd')->where('employeeid', '=', $employeeid)->where('token', '=', $token)->get();
            foreach ($getrestdata as $key => $value) {
                $expiredate = $value->expiredate;
            }
            $now = Carbon::now();
            if ($now > $expiredate) {
                $request->session()->flash("error_msg", "Password reset time limit expired!");
                return redirect()->route('newemployee_home');
            }
            else{

                $checkinvendortable = DB::connection('mysql6')->table('employee')->where('id', '=', $employeeid)->count();
                
                if ($checkinvendortable == 1) {
                    //sapupdation query
                    
                    
                     $updatepassword = $this->forgotsappassword($employeeid, $request->newpass,$request->retypepass);
            
            
        if ($updatepassword['STATUS'] == 'Password Updated') {
            
            DB::connection('mysql6')->table('dashboard')->where('employee_id', '=', $employeeid)->update(['last_password_changed' => date('Y-m-d')]);
            
            DB::connection('mysql6')->table('resetpwd')->where('employeeid', '=', $employeeid)->delete();
                    $request->session()->flash("suc_msg", "Password reset done Successfully!");
                return redirect()->route('newemployee_home');
            
        }
        else
        {
          $request->session()->flash("error_msg", $updatepassword['STATUS']);
            return redirect()->back();
        }
                    
                    
                    
                    

                }
                //return redirect()->route('customer_home');
            }
        }
        else{
            return redirect()->route('newemployee_home');
        }
    }
    else{
            return redirect()->route('newemployee_home');
    }


}
	
public function form16(Request $request)
{
    if ($request->session()->has('employeesession')) {
        
            $encrypt = $request->session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $employeeid = $split[0];

             
             $pwd_status = $this->is_emp_didnt_passwordchanged($employeeid);
            if ($pwd_status == 0) {
                $request->session()->flash("error_msg", 'Please change the default password. Only if you Change the default password , other functionalities on this portal will work. This is done for security purposes. Please do not share your password with anyone');
                return redirect()->route('newemployee_mydetails_passchange');
            }
                       
            $current_year  = Carbon::now()->format('Y');
                               

            $getemployeedata = DB::connection('mysql6')->table('employee')->where('id', '=', $employeeid)->get();
            
            $year = Carbon::now()->format('Y');
            $optionkey = [];
            for ($i=2019; $i <= $year ; $i++) { 
                $optionkey[$i] = ($i - 1).'-'.substr($i, -2);
            }

            
            
             $listfiles = Storage::disk('s3')->files("/newcustomerzoneassets/employeeprofileimage/".$employeeid);             
             if(count($listfiles) > 0){
                $profilepic = config('app.AWS_URL')."/".$listfiles[0];
            }
             else
             {
                $profilepic = config('app.AWS_URL')."/newcustomerzoneassets/img/dummy_male.png";
             }
            
            return view('newemployeezone.form16')->with(['getemployeedata' => $getemployeedata,'optionkey' => $optionkey ,'current_year' => $current_year,'profilepic' => $profilepic]);
        }
        else{
            return redirect()->route('newemployee_home');
        }
}

public function postform16(Request $request)
{
    if ($request->session()->has('employeesession')) {
        
            $encrypt = $request->session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $employeeid = $split[0];

             
                       
            $current_year  = Carbon::now()->format('Y');
                               

            $getemployeedata = DB::connection('mysql6')->table('employee')->where('id', '=', $employeeid)->get();
            $panno = '';

            if(count($getemployeedata) > 0){
                foreach ($getemployeedata as $key => $value) {
                    $panno = $value->panno;
                }
            }

            $req_year = $request->req_year;

            if (!empty($req_year)) {
                //$path = "C:/xampp/htdocs/vgnportal_052019new/app/Http/Controllers/form16/".$req_year;
				$path = app_path()."/Http/form16/".$req_year;
				
                 

    $headers = array(
              'Content-Type: application/pdf',
            );

$issir = File::isDirectory($path);

if ($issir == false) {
     $request->session()->flash("error_msg", "Form16 not generated. Please try after some time!");
                return redirect()->back();
}



    $filelist = File::allFiles("$path");

$newfile = '';
$newfile12 = '';
$newfilename = '';
$listmatched = [];
$ff = 0;
$zip = new ZipArchive;
$zipfilename = $panno.'_'.time().'.zip';
if(!empty($filelist) ){

    foreach ($filelist as  $value12) {
        $filearray12 = pathinfo($value12);
        $ext12 = $filearray12['extension'];
        
        $file12 = $filearray12['filename'];


            
            if (strpos($file12, "$panno") !== false) {
                $newfile12 = $path.'/'.$file12.'.'.$ext12;
               }
            

    }

    if(empty($newfile12)){
                $request->session()->flash("error_msg", "No file found in the directory. Please check with HR!");
                return redirect()->back(); 
            }

    if ($zip->open(public_path().'/zipfolder/'.$zipfilename, ZipArchive::CREATE) === TRUE) {
        
    
    foreach ($filelist as  $value1) {
        $filearray = pathinfo($value1);
        $ext = $filearray['extension'];
        
        $file = $filearray['filename'];


            
            if (strpos($file, "$panno") !== false) {
                $newfile = $path.'/'.$file.'.'.$ext;
                $newfilename = $filearray['filename'];
               
                $zip->addFile($newfile,$newfilename.'.'.$ext);
                //break;
                $ff++;
            }
            

    }

    $zip->close();

    return response()->download(public_path().'/zipfolder/'.$zipfilename)->deleteFileAfterSend(true);  
}






}
else{
    $request->session()->flash("error_msg", "Form16 not generated. Please try after some time!");
                return redirect()->back();
}


                
            }
            else{
                $request->session()->flash("error_msg", "Please provide year!");
                return redirect()->back();
            }
            
            
            
             
        }
        else{
            return redirect()->route('newemployee_home');
        }
}
public function bulkleadupload(Request $request)
{
    if ($request->session()->has('employeesession')) {
        
            $encrypt = $request->session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $employeeid = $split[0];

            $pwd_status = $this->is_emp_didnt_passwordchanged($employeeid);
            if ($pwd_status == 0) {
                $request->session()->flash("error_msg", 'Please change the default password. Only if you Change the default password , other functionalities on this portal will work. This is done for security purposes. Please do not share your password with anyone');
                return redirect()->route('newemployee_mydetails_passchange');
            }

    $getemployeedata = DB::connection('mysql6')->table('employee')->where('id', '=', $employeeid)->get();
    //dd($getemployeedata);

    $listfiles = Storage::disk('s3')->files("/newcustomerzoneassets/employeeprofileimage/".$employeeid);             
             if(count($listfiles) > 0){
                $profilepic = config('app.AWS_URL')."/".$listfiles[0];
            }
             else
             {
                $profilepic = config('app.AWS_URL')."/newcustomerzoneassets/img/dummy_male.png";
             }


             $getactivecampaigns_list = $this->getactivecampaigns();
            

    return view('newemployeezone.bulkleadupload')->with(['getemployeedata' => $getemployeedata,'getactivecampaigns_list' => $getactivecampaigns_list,'profilepic' => $profilepic]);
    }
        else{
            return redirect()->route('newemployee_home');
        }
}

public function postbulkleadupload(Request $request)
{
    if ($request->session()->has('employeesession')) {
        
            $encrypt = $request->session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $employeeid = $split[0];

    $getemployeedata = DB::connection('mysql6')->table('employee')->where('id', '=', $employeeid)->get();
    //dd($getemployeedata);

    $listfiles = Storage::disk('s3')->files("/newcustomerzoneassets/employeeprofileimage/".$employeeid);             
             if(count($listfiles) > 0){
                $profilepic = config('app.AWS_URL')."/".$listfiles[0];
            }
             else
             {
                $profilepic = config('app.AWS_URL')."/newcustomerzoneassets/img/dummy_male.png";
             }


             $validate = $this->validate($request, [
            'file_upload' => 'required|file|mimes:xlsx',      
            ]);

$filepath = $request->file_upload;
             $getactivecampaigns_list = $this->getactivecampaigns();
             
             //dd($getemp_matchedplants);
             
//$filepath = "C:/Users/Navin/Downloads/Naveentest_employeeexcel.xlsx";
             $excel = Importer::make('Excel');
$excel->load($filepath);
$collection = $excel->getCollection();



$campaignarray = [];
if (count($getactivecampaigns_list['Details']) > 0) {
    foreach ($getactivecampaigns_list['Details'] as $key1 => $value1) {
        //array_push($campaignarray, $value1['MARKETING_CAMPAIGN_CODE']);
        $campaignarray[$value1['PLANT']][] = $value1['MARKETING_CAMPAIGN_CODE'];
    }
    
}


if (count($collection) > 1) {
//dd($collection);
$newcollection[] = [];
$j = 0;
$ii = 0;

$emparray = [];
foreach ($collection as $key1 => $value1) {
    if ($key1 != 0) {
    $emparray[$ii][] = $value1[5];
    $ii++;
    }
}
$empunique = array_unique($emparray,SORT_REGULAR);
$empvalidarray = [];
$errors = [];
$kk = 1;
$newot = [];
foreach ($empunique as $cckey => $ccvalue) {
    
    $getemp_matchedplants = $this->emp_bulkplant_list($ccvalue[0]);

    if (!array_key_exists('0', $getemp_matchedplants['Output'])) {
        $newot['Output'][0] = $getemp_matchedplants['Output'];
    }
    else{
        $newot['Output'] = $getemp_matchedplants['Output'];
    }
    
    if (!empty($newot)) {

        foreach ($newot['Output'] as $pkey => $pvalue) {
        $empvalidarray[$ccvalue[0]][] = $pvalue['Plant'];
        }
    }
    else{
        $v = 0;
        $v = $kk + 3;
        //$errors[] = "Invalid Employee Id $ccvalue[0]";
    }
    
    $kk++;
}

if (!empty($errors)) {
    $request->session()->flash("invalidids", $errors);
        return redirect()->back();
}
//dd($empvalidarray);
$errorslist = [];
foreach ($collection as $nkey => $nvalue) {
    if ($nkey != 0) {
        $newcollection[$j][] = $nvalue[0];
        $newcollection[$j][] = $nvalue[1];
        $newcollection[$j][] = $nvalue[2];
        $newcollection[$j][] = $nvalue[3];
        $newcollection[$j][] = $nvalue[4];
        $newcollection[$j][] = $nvalue[5];
        $j++;
    }
}
//dd($newcollection);
    $unique = array_unique($newcollection,SORT_REGULAR);
    
    
    $list['Lead_Details'] = [];
        $i = 0;
        foreach ($unique as $key => $value) {
            if(!empty($value[1]) && !empty($value[1]) && !empty($value[3])  && !empty($value[4])  && !empty($value[5]))
            {
                
                if (!preg_match("/^[a-zA-Z ]*$/",$value[0])) {
                    $line6 = 0;
                    $lineno6 = $i+2;
                    $errorslist[] = "Employee name not valid at row no: $lineno6";
                }
                
                if (in_array("$value[3]", $empvalidarray[$value[5]]) === false) {
                    $line1 = 0;
                    $lineno1 = $i+2;
                    $errorslist[] = "Employee does not belongs to the given plant at row no: $lineno1";
                }

                if (array_key_exists($value[3], $campaignarray) === false) {
                    $line2 = 0;
                    $lineno2 = $i+2;
                    $errorslist[] = "Plant Code does not match at row no: $lineno2";
                }
                else{
                    if (in_array($value[4], $campaignarray[$value[3]]) === false) {
                        $line3 = 0;
                    $lineno3 = $i+2;
                    $errorslist[] = "Campaign Code does not match with given Plant Code at row no: $lineno3";
                }
                }

                
                if (!empty($value[2])) {
                    if (!filter_var($value[2], FILTER_VALIDATE_EMAIL)) {
                        $lineno = $i+2;
            $errorslist[] = "Sorry! Enter a valid Email Id at row no: $lineno";
                }
                }

                if (ctype_digit($value[3]) === false) {
                    $lineno = $i+2;
                    $errorslist[] = "Sorry! Enter a valid Plant code at row no: $lineno";
                }else{
                    if (strlen($value[3]) != 4) {
                        $lineno = $i+2;
                    $errorslist[] = "Plant code must be 4 digit. check at row no: $lineno";
                    }
                }

                if (preg_match('/^[0-9+]+$/', $value[1]) != '1') {
                    $lineno = $i+2;
                    $errorslist[] = "Invalid mobile number at row no: $lineno";
                }

                
                $randomnumber = rand(10,9999).'1';
            $list['Lead_Details'][$i]['Name'] = $value[0];
            $list['Lead_Details'][$i]['EMail'] = $value[2];
            $list['Lead_Details'][$i]['Mobile'] = $value[1];
            $list['Lead_Details'][$i]['CAMP_Code'] = $value[4]; 
            $list['Lead_Details'][$i]['PLANT_Code'] = $value[3]; 
            $list['Lead_Details'][$i]['Lead_Date'] = Carbon::now()->format('Ymd'); 
            $list['Lead_Details'][$i]['Lead_Time'] = Carbon::now()->format('His'); 
            $list['Lead_Details'][$i]['Unique_ID'] = Carbon::now()->format('YmdHis').$randomnumber; 
            $list['Lead_Details'][$i]['Emp_ID'] = trim($value[5]); 
            $list['Lead_Details'][$i]['Created_By'] = $employeeid; 

            $i++;
        }
        
    }

    if (empty($list['Lead_Details'])) {
        $errorslist[] = 'Rows cannot be blank!';
    }

    if (!empty($errorslist)) {
    $request->session()->flash("invalidids", $errorslist);
        return redirect()->back();
}
    
    $sendtosapupload_bulklead = $this->postbulkfileuploadleads($list);
    if ($sendtosapupload_bulklead['Status'] == 'Leads Uploaded') {
        $request->session()->flash("suc_msg", "Leads Uploaded Succesfully!");
                    return redirect()->back();
    }
    else{
        $request->session()->flash("error_msg", $sendtosapupload_bulklead['Status']);
                    return redirect()->back();
    }
    
}
else{
    $request->session()->flash("error_msg", "Do not upload empty file!");
    return redirect()->back();
}

    return view('newemployeezone.bulkleadupload')->with(['getemployeedata' => $getemployeedata,'getactivecampaigns_list' => $getactivecampaigns_list,'profilepic' => $profilepic]);
    }
        else{
            return redirect()->route('newemployee_home');
        }
}


public function saveactive_emplisttodb(Request $request){
	$getactiveemployees = $this->getallactiveemployees();
	if(count($getactiveemployees['Details']) > 0){

		DB::connection('mysql6')->table('active_emp')->truncate();
		$data = $getactiveemployees['Details'];
		
		foreach($data as $k){
		
		DB::connection('mysql6')->table('active_emp')->insert([
                     'id' => null,
		     'Emp_Id' => $k['Emp_ID'],
		     'Emp_Name' => $k['Emp_Name'],
		     'RM_ID' => $k['RM_ID'],
		     'Role_Code' => $k['Role_Code'],
		     'Plant_Code' => $k['Plant_Code'],
		     'OnContract' => $k['OnContract'],
		     'OnNotice' => $k['OnNotice'],
                     'Cadre' => $k['Cadre'],
                     'Position' => $k['Position'],
                     'Department' => $k['Department'],
		     'Personal_Mobile' => $k['Personal_Mobile'],
		     'Official_Mail' => $k['Official_Mail'],
		     'DOJ' => $k['DOJ'],
		     'Gender' => $k['Gender'],
		     'Birth_Date' => $k['Birth_Date'],
		     'Marital_Status' => $k['Marital_Status'],
		     'NumberOfChildren' => $k['NumberOfChildren']
		     ]);
		}
		return 1;
	}

}

	public function todayfollowup(Request $request)
{
    if ($request->session()->has('employeesession')) {
            $encrypt = $request->session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $employeeid = $split[0];
            $getemployeedata = DB::connection('mysql6')->table('employee')->where('id', '=', $employeeid)->get();

            $pwd_status = $this->is_emp_didnt_passwordchanged($employeeid);
            if ($pwd_status == 0) {
                $request->session()->flash("error_msg", 'Please change the default password. Only if you Change the default password , other functionalities on this portal will work. This is done for security purposes. Please do not share your password with anyone');
                return redirect()->route('newemployee_mydetails_passchange');
            }
            
            foreach($getemployeedata as $emp){
                $valid = $emp->saleorder;
                $empname = $emp->name;
                
            }
            
            if($valid != "1"){
                return redirect()->route('newemployee_dashboard', ['empid' => $employeeid]);
            }

	    if ($request->session()->has('leadsfollowup_plantselection'))  {
                    $selectedplant = $request->session()->get('leadsfollowup_plantselection');
                }
                else{
                    return redirect()->route('leadsfollowup');
                }

            $getdata = $this->todayfollowleadreport($employeeid);
		
            $maindata = [];
            if (!empty($getdata)) {
                if (array_key_exists('Details', $getdata)) {
                    if (array_key_exists('0', $getdata['Details'])) {
                            $maindata['Details'] = $getdata['Details'];
                        }
                        else{
                         $maindata['Details'][0] = $getdata['Details'];   
                        }    
                }

            }
            //dd($getdata);

            $listfiles = Storage::disk('s3')->files("/newcustomerzoneassets/employeeprofileimage/".$employeeid);             
             if(count($listfiles) > 0){
                $profilepic = config('app.AWS_URL')."/".$listfiles[0];
            }
             else
             {
                $profilepic = config('app.AWS_URL')."/newcustomerzoneassets/img/dummy_male.png";
             }

             return view('newemployeezone.todayleadsfollowup')->with(['getemployeedata'=> $getemployeedata,'result'=>$maindata,'profilepic' => $profilepic,'selectedplant' => $selectedplant]);

        }
        else{
            return redirect()->route('newemployee_home');
        }
}
   


public function downloadcustomerphoto(Request $request)
{
    if ($request->session()->has('employeesession')) {
        
            $encrypt = $request->session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $employeeid = $split[0];

            $pwd_status = $this->is_emp_didnt_passwordchanged($employeeid);
            if ($pwd_status == 0) {
                $request->session()->flash("error_msg", 'Please change the default password. Only if you Change the default password , other functionalities on this portal will work. This is done for security purposes. Please do not share your password with anyone');
                return redirect()->route('newemployee_mydetails_passchange');
            }

            $getemployeedata = DB::connection('mysql6')->table('employee')->where('id', '=', $employeeid)->get();

		foreach ($getemployeedata as $key11 => $value11) {
                $departmentcode = $value11->department_code;
            }

            if ($departmentcode != '50000060') {
                return redirect()->route('newemployee_dashboard', ['empid' => $employeeid]);
            }

            $getprojectcodeorunitdetails = DB::connection('mysql3')->table('customerphotoupload')->select('plantname','unitname')->groupBy('customerid','plantname', 'unitname')->get();
            $projects_units_arr = [];
            $unitsarray = [];
            $kk = 0;
            $id = 1;
            if (!empty($getprojectcodeorunitdetails)) {
                foreach ($getprojectcodeorunitdetails as $key => $value) {
                    $projects_units_arr["$value->plantname"][] = $value->unitname;
                    $unitsarray["$value->plantname"][$kk]['id'] = $id;
                    $unitsarray["$value->plantname"][$kk]['unitname'] = $value->unitname;
                    $kk++;
                    $id++;
                }
            }
            //dd($unitsarray);


            $listfiles = Storage::disk('s3')->files("/newcustomerzoneassets/employeeprofileimage/".$employeeid);             
             if(count($listfiles) > 0){
                $profilepic = config('app.AWS_URL')."/".$listfiles[0];
            }
             else
             {
                $profilepic = config('app.AWS_URL')."/newcustomerzoneassets/img/dummy_male.png";
             }

             $tabledata = [];
            return view('newemployeezone.downloadcustomerphoto')->with(['getemployeedata'=> $getemployeedata,'tabledata' => $tabledata,'profilepic' => $profilepic,'projects_units_arr' => $projects_units_arr,'unitsarray' => $unitsarray]);
        }
        else{
            return redirect()->route('newemployee_home');
        }
}

public function postdownloadcustomerphoto(Request $request)
{
    if ($request->session()->has('employeesession')) {
        
            $encrypt = $request->session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $employeeid = $split[0];
            
             $getprojectcodeorunitdetails = DB::connection('mysql3')->table('customerphotoupload')->select('plantname','unitname')->groupBy('customerid','plantname', 'unitname')->get();
            $projects_units_arr = [];
            $unitsarray = [];
            $kk = 0;
            $id = 1;
            if (!empty($getprojectcodeorunitdetails)) {
                foreach ($getprojectcodeorunitdetails as $key => $value) {
                    $projects_units_arr["$value->plantname"][] = $value->unitname;
                    $unitsarray["$value->plantname"][$kk]['id'] = $id;
                    $unitsarray["$value->plantname"][$kk]['unitname'] = $value->unitname;
                    $kk++;
                    $id++;
                }
            }

            $getemployeedata = DB::connection('mysql6')->table('employee')->where('id', '=', $employeeid)->get();
	    foreach ($getemployeedata as $key11 => $value11) {
                $departmentcode = $value11->department_code;
            }

            if ($departmentcode != '50000060') {
                return redirect()->back();
            }

             $listfiles = Storage::disk('s3')->files("/newcustomerzoneassets/employeeprofileimage/".$employeeid);             
             if(count($listfiles) > 0){
                $profilepic = config('app.AWS_URL')."/".$listfiles[0];
            }
             else
             {
                $profilepic = config('app.AWS_URL')."/newcustomerzoneassets/img/dummy_male.png";
             }
             //dd($request);
            if (!empty($request->projectname) && !empty($request->unitname)) {
                /*$saleorderno = $request->inputfield;
                $splitdetails = explode('--', $saleorderno);
                if (count($splitdetails) != 3) {
                    $request->session()->flash("error_msg", "Please enter a valid details!");
                    return redirect()->back();
                }*/

                /*$postedcustomerid = trim($splitdetails[0]);
                $postedprojectname = trim($splitdetails[1]);
                $postedunitname = trim($splitdetails[2]);*/

                //$postedcustomerid = trim($splitdetails[0]);
                $postedprojectname = trim($request->projectname);
                $postedunitname = trim($request->unitname);
                $saleorderno = '';
                //dd($postedprojectname);
                $checksaleorderpresent = DB::connection('mysql3')->table('customerphotoupload')->where(['plantname' => $postedprojectname,'unitname' => $postedunitname ])->limit(1)->get();
                if (count($checksaleorderpresent) > 0) {
                    foreach ($checksaleorderpresent as $key => $value) {
                        $customerid = $value->customerid;
                        $customercare_exec_id = $value->executiveid;
                        $customercare_manager_id = $value->managerid;
                        $plantcode = $value->plantcode;
                        $unitcode = $value->unitcode;
                        $saleorderno = $value->saleorder;
                    }


                    $arr = [];
                        $arr['Customer_ID'] = $customerid;
                        $arr['Plant_Code'] = $plantcode;
                        $arr['Unit_No'] = $unitcode;

                        $getbhkdetails = $this->getbhkdetails($arr);
                        if (!empty($getbhkdetails['Number_of_BHK'])) {
                            $sapresp_executiveid = $getbhkdetails['Executive_ID'];
                            $sapresp_managerid = $getbhkdetails['Manager_ID'];
                        }
                        else{
                            $request->session()->flash("error_msg", "BHK Details found empty!");
                            return redirect()->back();
                        }

                    $tabledata = [];
		   $tabledata = DB::connection('mysql3')->table('customerphotoupload')->where('saleorder', '=', $saleorderno)->get();
                    //dd($customercare_exec_id.'-----'.$employeeid);
                   /* if (($customercare_exec_id == $employeeid) && ($customercare_exec_id == $sapresp_executiveid)) {

                        $tabledata = DB::connection('mysql3')->table('customerphotoupload')->where('saleorder', '=', $saleorderno)->get();
                        
                    }
                    else {

                        

                        if ($sapresp_executiveid == $employeeid) {
                            DB::connection('mysql3')->table('customerphotoupload')->where('saleorder', '=', $saleorderno)->update(['executiveid' => $sapresp_executiveid,'managerid' => $sapresp_managerid]);

                             $tabledata = DB::connection('mysql3')->table('customerphotoupload')->where('saleorder', '=', $saleorderno)->get();
                        }
                        else{

                            DB::connection('mysql3')->table('customerphotoupload')->where('saleorder', '=', $saleorderno)->update(['executiveid' => $sapresp_executiveid,'managerid' => $sapresp_managerid]);
                            $request->session()->flash("error_msg", "Not Authorized to view data!");
                            return redirect()->back();
                        }

                        //dd($getbhkdetails);
                        
                    }*/



                    return view('newemployeezone.downloadcustomerphoto')->with(['getemployeedata'=> $getemployeedata,'tabledata' => $tabledata,'profilepic' => $profilepic,'projects_units_arr' => $projects_units_arr,'unitsarray' => $unitsarray]);

                }
                else{
                    $request->session()->flash("error_msg", "Details Not Found!");
                return redirect()->back();
                }

            }
            else{
                $request->session()->flash("error_msg", "Please enter saleorder number to process.");
                return redirect()->back();
            }

        }
        else{
            return redirect()->route('newemployee_home');
        }
}

public function postprint_taken(Request $request)
{
     if ($request->session()->has('employeesession')) {
        
            $encrypt = $request->session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $employeeid = $split[0];
            $id = $request->takenid;
            $checked = $request->taken;
            $checksaleorderpresent = DB::connection('mysql3')->table('customerphotoupload')->where(['id' => $id])->get();
                if (count($checksaleorderpresent) > 0) {
                    
                    $currentdatetime = Carbon::now()->toDateTimeString();
                    if ($checked == 'yes') {

                        DB::connection('mysql3')->table('customerphotoupload')->where(['id' => $id])->update(['taken_print_out' => 'Y','printout_taken_date'=> $currentdatetime]);
                        return 1;
                    }
                    if ($checked == 'no') {

                        DB::connection('mysql3')->table('customerphotoupload')->where(['id' => $id])->update(['taken_print_out' => 'N']);
                        return 1;
                    }

                    return 0;
                }
                else{
                    return 0;
                }


    }
        else{
            return redirect()->route('newemployee_home');
        }
}


public function vgnticket_redirection(Request $request)
{
    if ($request->session()->has('employeesession')) {
        
            $encrypt = $request->session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $employeeid = $split[0];

            $getemployee = DB::connection('mysql6')->table('employee')->where('id','=',$employeeid)->get();
            foreach ($getemployee as $key2 => $value2) {
                $officalmail = $value2->officialmail;
            }

            if (empty($officalmail)) {
                return redirect()->back();
            }

            $check_cred = DB::connection('mysql6')->table('employee_credentials')->where('id','=',$employeeid)->get();
            if (count($check_cred) > 0) {

                    foreach ($check_cred as $key1 => $value1) {
                        $password = $value1->password;
                    }
		
		 $secret_key = 'my_simple_secret_key'.Carbon::now()->format('H:i');
    		 $secret_iv = 'my_simple_secret_iv';		

		$string1 = $officalmail;
		$string2 = $password;
                $encrypt_method = "AES-256-CBC";
                $key = hash( 'sha256', $secret_key );
                $iv = substr( hash( 'sha256', $secret_iv ), 0, 16 );
                $output1 = base64_encode( openssl_encrypt( $string1, $encrypt_method, $key, 0, $iv ) );
		$output2 = base64_encode( openssl_encrypt( $string2, $encrypt_method, $key, 0, $iv ) );

                //dd($output);

		return redirect()->away('http://support.vgn.in/login.php?token='.$output1.'&key='.$output2);
            //return view('newemployeezone.vgnticket_redirection')->with(['username'=> $officalmail,'password' => $password]);

        }
        else{
            return redirect()->back();
        }
        }
        else{
        return redirect()->back();
        }

        }


public function checkandinactive_ticketsystem()
    {
	$getactiveemployees = $this->getallactiveemployees();
        //dd($getactiveemployees);
        //$getactiveemp = DB::connection('mysql6')->table('active_emp')->select('Official_Mail')->where('Emp_Id', '!=', '')->whereNotIn('Official_Mail',['NOEMAIL@VGN.IN','','ADMINCOORDINATOR@VGN.IN','HR4@VGN.IN','FACILITYINCHARGE@VGN.IN','HR1@VGN.IN','HR6@VGN.IN','NOMAIL@VGN.IN','HR4@VGN'])->get();
	$exceptionnlist = ['NOEMAIL@VGN.IN','','ADMINCOORDINATOR@VGN.IN','HR4@VGN.IN','FACILITYINCHARGE@VGN.IN','HR1@VGN.IN','HR6@VGN.IN','NOMAIL@VGN.IN','HR4@VGN'];
        if (count($getactiveemployees['Details']) > 0) {
            $activemails = [];
            foreach ($getactiveemployees['Details'] as $key => $value) {
		if (!in_array($value['Official_Mail'], $exceptionnlist)) {
                array_push($activemails,trim($value['Official_Mail']));
		}
            }
	  array_push($activemails,'veluridivya@gmail.com');
	  $activemails = array_unique($activemails);
	  $tomakeinactive = DB::connection('mysql7')->table('ost_user_email')->whereNotIn('address',$activemails)->get();
          $tomakeactive = DB::connection('mysql7')->table('ost_user_email')->whereIn('address',$activemails)->get();
		
		if (count($tomakeinactive) > 0) {
                foreach ($tomakeinactive as $key11 => $value11) {
                    DB::connection('mysql7')->table('ost_user_account')->where(['user_id' => $value11->user_id])->update(['status' => 3]);
                }
            }
            if (count($tomakeactive) > 0) {
                foreach ($tomakeactive as $key22 => $value22) {
                    DB::connection('mysql7')->table('ost_user_account')->where(['user_id' => $value22->user_id])->update(['status' => 9]);
                }
            }
            //dd($tomakeactive);
        }
        dd('Process Completed');
    }

public function jobapplications(Request $request)
    {
        
        if ($request->session()->has('employeesession')) {
            $encrypt = $request->session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $employeeid = $split[0];
            $getemployeedata = DB::connection('mysql6')->table('employee')->where('id', '=', $employeeid)->get();

            $pwd_status = $this->is_emp_didnt_passwordchanged($employeeid);
            if ($pwd_status == 0) {
                $request->session()->flash("error_msg", 'Please change the default password. Only if you Change the default password , other functionalities on this portal will work. This is done for security purposes. Please do not share your password with anyone');
                return redirect()->route('newemployee_mydetails_passchange');
            }

            foreach ($getemployeedata as $key11 => $value11) {
                $emp_desig_code = $value11->department_code;
            }

            if ($emp_desig_code != '50000062') {
                return redirect()->route('newemployee_dashboard', ['empid' => $employeeid]);
            }

            $getapplications1 = DB::connection('mysql8')->table('application_details')->orderBy('created_datetime','desc')->get();
            //dd($getapplications);

            if (count($getapplications1) > 0) {
                foreach ($getapplications1 as $key11 => $value11) {
                    $appid_tocheck = $value11->app_id;
                    $res = '';
                    if ($appid_tocheck != '') {

                        $res = $this->hr_application_crosscheck($appid_tocheck);
                        if (array_key_exists('Status', $res) === true) {
                            //ltrim($res['Applicant_Number'],0);
                            DB::connection('mysql8')->table('application_details')->where(['app_id' => ltrim($res['Applicant_Number'],0)])->delete();
                        }
                        
                    }

                }
            }
            $getapplications = DB::connection('mysql8')->table('application_details')->orderBy('created_datetime','desc')->get();
            
            
            
             $listfiles = Storage::disk('s3')->files("/newcustomerzoneassets/employeeprofileimage/".$employeeid);             
             if(count($listfiles) > 0){
                $profilepic = config('app.AWS_URL')."/".$listfiles[0];
            }
             else
             {
                $profilepic = config('app.AWS_URL')."/newcustomerzoneassets/img/dummy_male.png";
             }
            
            return view('newemployeezone.jobapplications')
                ->with(['getemployeedata'=>$getemployeedata,'profilepic' => $profilepic,'getapplications' => $getapplications]);
        }
        else{
            return redirect()->route('newemployee_home');
        }
        
    }

    // public function landownersData(){

    //     $datalist = DB::connection('mysql')->table('landowners')->get();
    //     $getjson = json_decode($datalist, true);
            
    //         // $j = 0;
    //     // if (count($datalist) == 0) {
    //         for($i= 258; $i < count($datalist); $i++) {
    //             // $j++;     
    //             $final = array();
    //             $final['Title'] = '#';
    //             $final['Name1'] = $datalist[$i]->lname;;
    //             $final['Name2'] = $datalist[$i]->lmobile;
    //             $final['Name3'] = $datalist[$i]->lemail;
    //             $final['Name4'] = $datalist[$i]->location;
    //             $final['Search1'] = $datalist[$i]->extent;
    //             $final['Search2'] = $datalist[$i]->extent_type;
    //             $final['Building_Code'] = '';
    //             $final['Room'] = '';
    //             $final['Floor'] = '';
    //             $final['C_O'] = '';
    //             $final['House_Number'] = '';
    //             $final['Street1'] = '';
    //             $final['Street2'] = '';
    //             $final['Street3'] = '';
    //             $final['Street4'] = '';
    //             $final['Street5'] = '';
    //             $final['Street6'] = '';
    //             $final['Street7'] = '';
    //             $final['District'] = '';
    //             $final['Different_City'] = '';
    //             $final['Postal_code'] = '';
    //             $final['City'] = '';
    //             $final['Country'] = '';
    //             $final['Region'] = '';
    //             $final['Time_Zone'] = '';
    //             $final['Tax_Jurisdictn'] = '';
    //             $final['Transportation_Zone'] = '';
    //             $final['Reg_Struct_Grp'] = '';
    //             $final['Undeliverable'] = '';
        
    //             $final['PO_Box1'] = '';
    //             $final['PO_Box2'] = '';
    //             $final['PO_Box3'] = '';
    //             $final['PO_Box4'] = '';
    //             $final['PO_Box_Lobby'] = '';
    //             $final['Postal_Code'] = '';
    //             $final['PO_Box_City'] = '';
    //             $final['Other_Country'] = '';
    //             $final['PO_Region'] = '';
    //             $final['Company_Postal_Code'] = '';
    //             $final['Post1'] = '';
    //             $final['Post2'] = '';
    //             $final['Undeliverable1'] = '';
    //             $final['Language'] = '';
    //             $final['Telephone'] = '';
    //             $final['Extension'] = '';
    //             $final['Mobile_Phone'] = '';
    //             $final['Fax'] = '';
    //             $final['Extension1'] = '';
    //             $final['E_Mail'] = '';
    //             $final['Comm_Method1'] = '';
    //             $final['Comm_Method2'] = '';
    //             $final['Comm_Method3'] = '';
    //             $final['Comments'] = '';
    //             $final['DOB'] = '';
    //             $final['Wedding_Anniversary_Day'] = '';
    //             $final['Gender1'] = '';
    //             $final['Gender2'] = '';
         
    //             $final['Marital_Status1'] = '';
    //             $final['Marital_Status2'] = '';
    //             $final['Marital_Status3'] = '';
    //             $final['Marital_Status4'] = '';
    //             $final['Marital_Status5'] = '';
    //             $final['Marital_Status6'] = '';
                
    //             $final['Resident_Indian1'] = '';
    //             $final['Resident_Indian2'] = '';
    //             $final['Resident_Indian3'] = '';
    //             $final['Employment1'] = '';
    //             $final['Employment2'] = '';
    //             $final['Employment3'] = '';
    //             $final['Industry1'] = '';
    //             $final['Industry2'] = '';
    //             $final['Industry3'] = '';
    //             $final['Industry4'] = '';
    //             $final['Industry5'] = '';
    //             $final['Industry6'] = '';
    //             $final['Industry7'] = '';
    //             $final['Industry8'] = '';
    //             $final['Industry9'] = '';
    //             $final['Industry10'] = '';
    //             $final['Industry11'] = '';
    //             $final['Industry12'] = '';
    //             $final['Industry13'] = '';
    //             $final['Industry14'] = '';
    //             $final['Industry15'] = '';
    //             $final['Gross1'] = '';
    //             $final['Gross2'] = '';
    //             $final['Gross3'] = '';
    //             $final['Gross4'] = '';
    //             $final['Gross5'] = '';
    //             $final['Gross6'] = '';
    //             $final['Gross7'] = '';
    //             $final['Vehicle1'] = '';
    //             $final['Vehicle2'] = '';
    //             $final['Status1'] = '';
    //             $final['Status2'] = '';
    //             $final['Co_Applicant1'] = '';
    //             $final['Co_Applicant2'] = '';
    //             $final['Co_Applicant3'] = '';
    //             $final['Co_Applicant4'] = '';
    //             $final['PAN_No'] = '';
    //             $final['Passport'] = '';
    //             $final['Lead_No'] = '';
    //             $landownerdatasendtosap = $this->landownerscreate($final);
    //         // }
    //     }
    //     return json_encode(['Status' => $landownerdatasendtosap]);
    // }

public function landowners(Request $request)
{
     $validate = $this->validate($request, [
            'Name' => 'required|min:3|max:80',
            'Email' => 'nullable|email',
            'Location' => 'required|min:3|max:200',
            'Mobile' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'Extent' => 'required',
            'extent_type' => 'required'
            ]);
     $name = trim($request->Name);
     if (empty($request->Email)) {
         $email = null;
     }
     else{
        $email = trim($request->Email);
     }
     
     $location = trim($request->Location);
     $mobile = trim($request->Mobile);
     $extent = trim($request->Extent);
     $extent_type = trim($request->extent_type);

    // $in4status = $this->commonLeadController->commonLeadData($name,$email,$mobile,12,'VGN LAND ENQUIRY');
     // dd($in4status);

     $insertcheck = DB::connection('mysql')->table('landowners')->where([
        'lname' => $name,
        'lmobile' => $mobile,
        'lemail' => $email,
        'location' => $location,
        'extent' => $extent,
        'extent_type' => $extent_type
    ])->get();


     if ((count($insertcheck) == 0)) {

        $final = array();
        $final['Title'] = '#';
        $final['Name1'] = $name;
        $final['Name2'] = $mobile;
        $final['Name3'] = $email;
        $final['Name4'] = $location;
        $final['Search1'] = $extent;
        $final['Search2'] = $extent_type;
        $final['Building_Code'] = '';
        $final['Room'] = '';
        $final['Floor'] = '';
        $final['C_O'] = '';
        $final['House_Number'] = '';
        $final['Street1'] = '';
        $final['Street2'] = '';
        $final['Street3'] = '';
        $final['Street4'] = '';
        $final['Street5'] = '';
        $final['Street6'] = '';
        $final['Street7'] = '';
        $final['District'] = '';
        $final['Different_City'] = '';
        $final['Postal_code'] = '';
        $final['City'] = '';
        $final['Country'] = '';
        $final['Region'] = '';
        $final['Time_Zone'] = '';
        $final['Tax_Jurisdictn'] = '';
        $final['Transportation_Zone'] = '';
        $final['Reg_Struct_Grp'] = '';
        $final['Undeliverable'] = '';

        $final['PO_Box1'] = '';
        $final['PO_Box2'] = '';
        $final['PO_Box3'] = '';
        $final['PO_Box4'] = '';
        $final['PO_Box_Lobby'] = '';
        $final['Postal_Code'] = '';
        $final['PO_Box_City'] = '';
        $final['Other_Country'] = '';
        $final['PO_Region'] = '';
        $final['Company_Postal_Code'] = '';
        $final['Post1'] = '';
        $final['Post2'] = '';
        $final['Undeliverable1'] = '';
        $final['Language'] = '';
        $final['Telephone'] = '';
        $final['Extension'] = '';
        $final['Mobile_Phone'] = '';
        $final['Fax'] = '';
        $final['Extension1'] = '';
        $final['E_Mail'] = '';
        $final['Comm_Method1'] = '';
        $final['Comm_Method2'] = '';
        $final['Comm_Method3'] = '';
        $final['Comments'] = '';
        $final['DOB'] = '';
        $final['Wedding_Anniversary_Day'] = '';
        $final['Gender1'] = '';
        $final['Gender2'] = '';
 
        $final['Marital_Status1'] = '';
        $final['Marital_Status2'] = '';
        $final['Marital_Status3'] = '';
        $final['Marital_Status4'] = '';
        $final['Marital_Status5'] = '';
        $final['Marital_Status6'] = '';
        
        $final['Resident_Indian1'] = '';
        $final['Resident_Indian2'] = '';
        $final['Resident_Indian3'] = '';
        $final['Employment1'] = '';
        $final['Employment2'] = '';
        $final['Employment3'] = '';
        $final['Industry1'] = '';
        $final['Industry2'] = '';
        $final['Industry3'] = '';
        $final['Industry4'] = '';
        $final['Industry5'] = '';
        $final['Industry6'] = '';
        $final['Industry7'] = '';
        $final['Industry8'] = '';
        $final['Industry9'] = '';
        $final['Industry10'] = '';
        $final['Industry11'] = '';
        $final['Industry12'] = '';
        $final['Industry13'] = '';
        $final['Industry14'] = '';
        $final['Industry15'] = '';
        $final['Gross1'] = '';
        $final['Gross2'] = '';
        $final['Gross3'] = '';
        $final['Gross4'] = '';
        $final['Gross5'] = '';
        $final['Gross6'] = '';
        $final['Gross7'] = '';
        $final['Vehicle1'] = '';
        $final['Vehicle2'] = '';
        $final['Status1'] = '';
        $final['Status2'] = '';
        $final['Co_Applicant1'] = '';
        $final['Co_Applicant2'] = '';
        $final['Co_Applicant3'] = '';
        $final['Co_Applicant4'] = '';
        $final['PAN_No'] = '';
        $final['Passport'] = '';
        $final['Lead_No'] = '';

        $createlandowner = $this->landownerscreate($final);
        Log::info('Landowner creation response:', ['response' => $createlandowner]);
        //dd($createlandowner);
        if ($createlandowner['Status'] == "SUCCESS"){
            DB::connection('mysql')->table('landowners')->insert([
                'id' => null,
                'lname' => $name,
                'lmobile' => $mobile,
                'lemail' => $email,
                'location' => $location,
                'extent' => $extent,
                'extent_type' => $extent_type,
                'created_datetime' => Carbon::now()->toDateTimeString()
            ]);
        }
    

         $fm = Carbon::now()->format('d, M Y h:i:s A');
         if (empty($email)) {
             $email = 'Nil';
         }

         $smscontent = "Land Owner Details from VGN Website:\n\nName: $name\nMobile: $mobile\nEmail: $email\nLocation: $location\nExtent: $extent $extent_type\nCreated: $fm";
        //  $this->smscurl($smscontent, '9840199952');
        //  $this->smscurl($smscontent, '9600010044');
         //$this->smscurl($smscontent, '9840656089');
         $this->smscurl($smscontent, '9840199952');
          $this->smscurl($smscontent, '9600102255');

         $request->session()->flash("suc_msg", "Successfully submitted!");

     } else {
        $request->session()->flash("error_msg", "The mobile number is not verified. Try again!");
        // return redirect()->back();
     }


    
     return redirect()->back();

}

public function selldo_5thapi(Request $request)
{
         $resp = json_encode($request->all());
        Log::info('sell do 5 response '.$resp);
        //return json_encode(['status' => 'Success']);
        $main = json_decode($resp);
        $erpid = $main->project_unit->erp_id;
        $status_message = $main->project_unit->status;
        Log::info('selldo post url '.$erpid);

        if (!empty($erpid)) {

$getfirst_part = substr($erpid, 0,4);

Log::info('selldo 5th plantcode '.$getfirst_part);

$selldourl = '';
if ($getfirst_part == 4100) {   $selldourl = 'https://nottinghill-onlinebooking.vgn.in/api/v1/project_units/update_status'; }
if ($getfirst_part == 4106) {   $selldourl = 'https://stafford-onlinebooking.vgn.in/api/v1/project_units/update_status'; }
if ($getfirst_part == 4311) {   $selldourl = 'https://fairmont-onlinebooking.vgn.in/api/v1/project_units/update_status'; }
if ($getfirst_part == 4107) {   $selldourl = 'https://coasta-onlinebooking.vgn.in/api/v1/project_units/update_status'; }
if ($getfirst_part == 4109) {   $selldourl = 'https://templetown-onlinebooking.vgn.in/api/v1/project_units/update_status'; }
if ($getfirst_part == 4119) {   $selldourl = 'https://ovalgardens-onlinebooking.vgn.in/api/v1/project_units/update_status'; }
if ($getfirst_part == 4120) {   $selldourl = 'https://croftongarden-onlinebooking.vgn.in/api/v1/project_units/update_status'; }
if ($getfirst_part == 4124) {   $selldourl = 'https://mayfieldpark-onlinebooking.vgn.in/api/v1/project_units/update_status'; }


$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "$selldourl",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'{ "project_unit": { "erp_id": "'.$erpid.'" , "status": "'.$status_message.'" } }',
  CURLOPT_HTTPHEADER => array(
    'Api-key: dfcad105c96f2e2ced1ba1042c2bb62a',
    'Api-domain: http://vgn.iris.selldoapp.com',
    'Content-Type: application/json'
  ),
));

$response = curl_exec($curl);

$getjson = json_decode($response, true);

curl_close($curl);
Log::info('selldo response '.$response);
return json_encode(['Status' => $getjson['status'], 'Message' => $getjson['message']]);

        }



         return json_encode(['Status' => 'success', 'Message' => 'working']);
}

public function landownersform()
{
    return view('landowners.index');
}

public function selldo_4thapi(Request $request)
{
         $resp = json_encode($request->all());
        Log::info('sell do response '.$resp);
        //return json_encode(['status' => 'Success']);
        $main = json_decode($resp);
        $getcurl = $main->bulk_upload->file_url;
        Log::info('selldo post url '.$getcurl);

        if (!empty($getcurl)) {
        
$str_replace = str_replace('http://cdn.vgn.in/vgnirisbulkinventoryfiles/bulkinv_iris/','', $getcurl);        
$getfirst_part = substr($str_replace, 0,4);

Log::info('selldo plantcode '.$getfirst_part);

$selldourl = '';
if ($getfirst_part == 4100) {   $selldourl = 'https://nottinghill-onlinebooking.vgn.in/api/v1/project_units/bulk_upload'; }
if ($getfirst_part == 4106) {   $selldourl = 'https://stafford-onlinebooking.vgn.in/api/v1/project_units/bulk_upload'; }
if ($getfirst_part == 4311) {   $selldourl = 'https://fairmont-onlinebooking.vgn.in/api/v1/project_units/bulk_upload'; }
if ($getfirst_part == 4107) {   $selldourl = 'https://coasta-onlinebooking.vgn.in/api/v1/project_units/bulk_upload'; }
if ($getfirst_part == 4109) {   $selldourl = 'https://templetown-onlinebooking.vgn.in/api/v1/project_units/bulk_upload'; }
if ($getfirst_part == 4119) {   $selldourl = 'https://ovalgardens-onlinebooking.vgn.in/api/v1/project_units/bulk_upload'; }
if ($getfirst_part == 4120) {   $selldourl = 'https://croftongarden-onlinebooking.vgn.in/api/v1/project_units/bulk_upload'; }
if ($getfirst_part == 4124) {   $selldourl = 'https://mayfieldpark-onlinebooking.vgn.in/api/v1/project_units/bulk_upload'; }

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "$selldourl",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'{"bulk_upload":{"file_url":"'.$getcurl.'"}}',
  CURLOPT_HTTPHEADER => array(
    'Api-key: dfcad105c96f2e2ced1ba1042c2bb62a',
    'Api-domain: http://vgn.iris.selldoapp.com',
    'Content-Type: application/json'
  ),
));

$response = curl_exec($curl);

$getjson = json_decode($response, true);

curl_close($curl);
Log::info('selldo response '.$getjson['message']);
return json_encode(['Status' => $getjson['status'], 'Message' => $getjson['message']]);

        }



         return json_encode(['Status' => 'success', 'Message' => 'working']);
}

public function getlistofvendorskycupdated(Request $request)
{
   if ($request->session()->has('employeesession')) {
            $encrypt = $request->session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $employeeid = $split[0];

            if ($employeeid == '100498') {

                $getemployeedata = DB::connection('mysql6')->table('employee')->where('id', '=', $employeeid)->get();
            

             $pwd_status = $this->is_emp_didnt_passwordchanged($employeeid);
            if ($pwd_status == 0) {
                $request->session()->flash("error_msg", 'Please change the default password. Only if you Change the default password , other functionalities on this portal will work. This is done for security purposes. Please do not share your password with anyone');
                return redirect()->route('newemployee_mydetails_passchange');
            }
            
            //$sapdata = $this->getemployee($employeeid);
            //dd($sapdata);
            $getvendorkycdata = DB::connection('mysql5')->table('vendorgstpanverify')->orderBy('updatedtime', 'desc')->get();
            //dd($getvendorkycdata);
            
             $listfiles = Storage::disk('s3')->files("/newcustomerzoneassets/employeeprofileimage/".$employeeid);             
             if(count($listfiles) > 0){
                $profilepic = config('app.AWS_URL')."/".$listfiles[0];
            }
             else
             {
                $profilepic = config('app.AWS_URL')."/newcustomerzoneassets/img/dummy_male.png";
             }
            
            return view('newemployeezone.getvendorkycdata')
                ->with(['getemployeedata'=>$getemployeedata,
                                        'getvendorkycdata'=>$getvendorkycdata,
                                        'profilepic' => $profilepic]);

                
            }
            else{
                 return redirect()->route('newemployee_home');
            }
            
        }
        else{
            return redirect()->route('newemployee_home');
        } 
}

public function changeprojectstatus(Request $request,$status, $id)
    {
        if ($request->session()->has('employeesession')) {

            $encrypt = $request->session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $employeeid = $split[0];

            if (in_array($employeeid, config('newlmsconfig'))) {
        if(($status == 'Ongoing') || ($status == 'Completed')){
        DB::table('projectlist')->where(['id' => $id])->update(['Status' => $status]);
        }
        return 'Updated Successfully';
        }
        else{
            return 'Unauthorized';
        }
    }else{
        return redirect()->route('newemployee_home');
    }
    }


    public function leavequota_manualentry(Request $request)
    {
        $hashkey = $request->hashkey;
        $employeeid = $request->employeeid;
        $month = $request->month;
        $year = $request->year;
        $typeofaction = $request->typeofaction;

        if($hashkey == 'Vgn@$1942'){


        
        //DB::table('projectlist')->where(['id' => $id])->update(['Status' => $status]);
        if($typeofaction == 'Insert_leave_record'){    
        $checkins = DB::connection('mysql6')->table('leave_balance')->where(['employeeid' => $employeeid, 'month' => $month, 'year' => $year])->get();
        
        if(count($checkins) == 0){

            $CL = $request->CL;
            $SL = $request->SL;
            $PL = $request->PL;
            $ML = $request->ML;
            $RH = $request->RH;
            $Permission = $request->Permission;
            $Onduty = $request->Onduty;
            $Tour = $request->Tour; 
            $Compoff = $request->Compoff; 
            $Mispunch = $request->Mispunch;
            $Present = $request->Present;
            $LOP = $request->LOP; 
            $Absent = $request->Absent;
            $late_count = $request->late_count;
            $total_late_hours = $request->total_late_hours;
            $early_out_count = $request->early_out_count;
            $total_early_out_hours = $request->total_early_out_hours;
            $completed = $request->completed;

            DB::connection('mysql6')->table('leave_balance')->insert([
                'id' => null,
               'employeeid' => $employeeid,
               'month' => $month,
               'year' => $year,
               'CL' => $CL,
               'SL' => $SL,
               'PL' => $PL,
               'ML' => $ML,
               'RH' => $RH,
               'Permission' => $Permission, 
               'Onduty' => $Onduty, 
                'Tour' => $Tour, 
                'Compoff' => $Compoff, 
                'Mispunch' => $Mispunch, 
                'Present' => $Present, 
                'LOP' => $LOP, 
                'Absent' => $Absent, 
                'late_count' => $late_count, 
                'total_late_hours' => $total_late_hours, 
                'early_out_count' => $early_out_count, 
                'total_early_out_hours' => $total_early_out_hours, 
                'completed' => $completed
            ]);
            return 'Inserted Successfully';
        }
        else{
            return 'Record Already exist!';
        }
        
        }

        if($typeofaction == 'update_leave_record'){  
            $CL = $request->CL;
            $SL = $request->SL;
            $PL = $request->PL;
            $ML = $request->ML;
            $RH = $request->RH;
            $Permission = $request->Permission;
            $Onduty = $request->Onduty;
            $Tour = $request->Tour; 
            $Compoff = $request->Compoff; 
            $Mispunch = $request->Mispunch;
            $Present = $request->Present;
            $LOP = $request->LOP; 
            $Absent = $request->Absent;
            $late_count = $request->late_count;
            $total_late_hours = $request->total_late_hours;
            $early_out_count = $request->early_out_count;
            $total_early_out_hours = $request->total_early_out_hours;
            $completed = $request->completed;  
            $checkins = DB::connection('mysql6')->table('leave_balance')->where(['employeeid' => $employeeid, 'month' => $month, 'year' => $year])->get();
            
            if(count($checkins) == 1){
                DB::connection('mysql6')->table('leave_balance')->where(['employeeid' => $employeeid, 'month' => $month, 'year' => $year])->update([
                   'CL' => $CL,
                   'SL' => $SL,
                   'PL' => $PL,
                   'ML' => $ML,
                   'RH' => $RH,
                   'Permission' => $Permission, 
                   'Onduty' => $Onduty, 
                    'Tour' => $Tour, 
                    'Compoff' => $Compoff, 
                    'Mispunch' => $Mispunch, 
                    'Present' => $Present, 
                    'LOP' => $LOP, 
                    'Absent' => $Absent, 
                    'late_count' => $late_count, 
                    'total_late_hours' => $total_late_hours, 
                    'early_out_count' => $early_out_count, 
                    'total_early_out_hours' => $total_early_out_hours, 
                    'completed' => $completed
                ]);
                return 'Updated Successfully';
            }
            else{
                return 'Record Already updated!';
            }
            
            }

            if($typeofaction == 'delete_leave_record'){    
                $checkins = DB::connection('mysql6')->table('leave_balance')->where(['employeeid' => $employeeid, 'month' => $month, 'year' => $year])->get();
                
                if(count($checkins) == 1){
                    DB::connection('mysql6')->table('leave_balance')->where(['employeeid' => $employeeid, 'month' => $month, 'year' => $year])->delete();
                    return 'Deleted Successfully';
                }
                else{
                    return 'Record Already deleted!';
                }
                
                }

        return 'Please Check again!';
        }
        else{
            return 'Unauthorized';
        }
    
    }

    public function empbankdetails(Request $request)
    {
        
        if ($request->session()->has('employeesession')) {
            $encrypt = $request->session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $employeeid = $split[0];
            $getemployeedata = DB::connection('mysql6')->table('employee')->where('id', '=', $employeeid)->get();
            //dd($getEMPBankDetails);
            //  $listfiles = Storage::disk('s3')->files("/newcustomerzoneassets/vendorprofileimage/".$employeeid);
            //  $pwd_status = $this->is_didnt_passwordchanged($employeeid);
            // if ($pwd_status == 0) {
            //     $request->session()->flash("error_msg", 'Please change the default password. Only if you Change the default password , other functionalities on this portal will work. This is done for security purposes. Please do not share your password with anyone');
            //     return redirect()->route('newvendor_mydetails_passchange');
            // }
             
            //  if(count($listfiles) > 0){
            //     $profilepic = config('app.AWS_URL')."/".$listfiles[0];
            // }
            //  else
            //  {
            //     $profilepic = config('app.AWS_URL')."/newcustomerzoneassets/img/dummy_male.png";
            //  }

            $listfiles = Storage::disk('s3')->files("/newcustomerzoneassets/employeeprofileimage/".$employeeid);  
                       
             if(count($listfiles) > 0){
                $profilepic = config('app.AWS_URL')."/".$listfiles[0];
            }
             else
             {
                $profilepic = config('app.AWS_URL')."/newcustomerzoneassets/img/dummy_male.png";
             }
             //dd($profilepic);
            return view('newemployeezone.empbankdetails')->with(['getemployeedata'=>$getemployeedata, 'profilepic' => $profilepic]);
        }
        else{
            return redirect()->route('newemployee_home');
        }
    }


    public function editempbankdetails(Request $request){

        if ($request->session()->has('employeesession')) {
            $encrypt = $request->session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $employeeid = $split[0];
            $getemployeedata = DB::connection('mysql6')->table('employee')->where('id', '=', $employeeid)->get();
            
            //  $pwd_status = $this->is_didnt_passwordchanged($employeeid);
            // if ($pwd_status == 0) {
            //     $request->session()->flash("error_msg", 'Please change the default password. Only if you Change the default password , other functionalities on this portal will work. This is done for security purposes. Please do not share your password with anyone');
            //     return redirect()->route('newvendor_mydetails_passchange');
            // }
            $listfiles = Storage::disk('s3')->files("/newcustomerzoneassets/employeeprofileimage/".$employeeid);
             if(count($listfiles) > 0){
                $profilepic = config('app.AWS_URL')."/".$listfiles[0];
            }
             else
             {
                $profilepic = config('app.AWS_URL')."/newcustomerzoneassets/img/dummy_male.png";
             }
            
            return view('newemployeezone.editempbankdetails')->with(['getemployeedata'=>$getemployeedata, 'profilepic' => $profilepic]);
        }
        else{
            return redirect()->route('newemployee_home');
        }
    }


        


    public function posteditempbankdetails(Request $request){

        if ($request->session()->has('employeesession')) {
            $encrypt = $request->session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $employeeid = $split[0];
            $getemployeedata = DB::connection('mysql6')->table('employee')->where('id', '=', $employeeid)->get();

                        
                $validate = $this->validate($request, [
            'bank_account_no' => 'required|regex:/(^[0-9]+$)+/|min:6|max:26',
            'retype_bank_account_no' => 'required|same:bank_account_no',
            'bank_name' => 'required|regex:/^[\pL\s]+$/u|min:3|max:40',
            'ifsc_code' => 'required|max:11',
            'branch_name' => 'required|regex:/^[\pL\s]+$/u|min:4|max:40'

            ]); 

            $updatebankinfo = $this->updatebankinfo($employeeid,$request->bank_account_no,$request->branch_name,$request->ifsc_code,$request->bank_name);
                // dd($updatebankinfo);
            
            if (($updatebankinfo['Command'] == 'X')&&($updatebankinfo['code'] == '200')) {

                DB::connection('mysql6')->table('employee')->where(['id' => $employeeid])->update([
                    'bank_acnt_no'=> $request->bank_account_no,
                     'bank_name'=> $request->bank_name
                     ]); 
                
               $getipdetails = $this->getip($request);
                $arr111 = [];
                $arr111['Vendor_ID'] = $employeeid;
                $arr111['URL'] = $request->url();
                $arr111['IP_Address'] = $getipdetails['iprequested'];
                $arr111['From_Mobile'] = $getipdetails['ismobile'];
                $arr111['From_Desktop'] = $getipdetails['isdesktop'];
                $arr111['Time_Stamp'] = Carbon::now()->toDateTimeString();
                $arr111resp = $this->requestipsend_tosap($arr111);
                // dd($arr111);

                DB::connection('mysql6')->table('empvendor_bank_details_update_history')->insert([
                'empid' => $employeeid,
                'bank_acnt_no'=> $request->bank_account_no,
                'branch_name'=> $request->branch_name,
                'ifsc_code'=> $request->ifsc_code,
                'bank_name'=> $request->bank_name,
                'URL' => $request->url(),
                'IP_Address' => $getipdetails['iprequested'],
                'From_Mobile' => $getipdetails['ismobile'],
                'From_Desktop' => $getipdetails['isdesktop'],
                'created_datetime' => Carbon::now()->toDateTimeString()
                ]);
            $request->session()->flash("suc_msg", "Bank Details Updated Successfully!");
            return redirect()->route('empbankdetails');
            }else{
                $request->session()->flash("error_msg", "Sorry! Bank Details not Updated Successfully!");
                return redirect()->back();
            }

        }
        else{
            return redirect()->route('newemployee_home');
        }
    }



    public function getip($requestarg){

        $ipfetch = $requestarg->server('HTTP_X_FORWARDED_FOR');
        $ismobile = $requestarg->server('HTTP_CLOUDFRONT_IS_MOBILE_VIEWER');
        $isdesktop = $requestarg->server('HTTP_CLOUDFRONT_IS_DESKTOP_VIEWER');
        $requestdetails = ['iprequested' => $ipfetch, 'ismobile' => $ismobile, 'isdesktop' => $isdesktop];
        return $requestdetails;
    }



    public function vendro_auth_key_insert(Request $request)
    {
        
      

         if ($request->session()->has('employeesession')) {
        
            $encrypt = $request->session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $employeeid = $split[0];

             
             $pwd_status = $this->is_emp_didnt_passwordchanged($employeeid);
            if ($pwd_status == 0) {
                $request->session()->flash("error_msg", 'Please change the default password. Only if you Change the default password , other functionalities on this portal will work. This is done for security purposes. Please do not share your password with anyone');
                return redirect()->route('newemployee_mydetails_passchange');
            }
                       
            $current_year  = Carbon::now()->format('Y');
                               

            $getemployeedata = DB::connection('mysql6')->table('employee')->where('id', '=', $employeeid)->get();
            
            $year = Carbon::now()->format('Y');
            $optionkey = [];
            for ($i=2019; $i <= $year ; $i++) { 
                $optionkey[$i] = ($i - 1).'-'.substr($i, -2);
            }

            
            
             $listfiles = Storage::disk('s3')->files("/newcustomerzoneassets/employeeprofileimage/".$employeeid);             
             if(count($listfiles) > 0){
                $profilepic = config('app.AWS_URL')."/".$listfiles[0];
            }
             else
             {
                $profilepic = config('app.AWS_URL')."/newcustomerzoneassets/img/dummy_male.png";
             }
            
            return view('newemployeezone.vendor_api_insert')->with(['getemployeedata' => $getemployeedata,'optionkey' => $optionkey ,'current_year' => $current_year,'profilepic' => $profilepic]);
        }
        else{
            return redirect()->route('newemployee_home');
        }


    }



    public function list_api_key(Request $request)
    {


           if ($request->session()->has('employeesession')) {
        
            $encrypt = $request->session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $employeeid = $split[0];

             
             $pwd_status = $this->is_emp_didnt_passwordchanged($employeeid);
            if ($pwd_status == 0) {
                $request->session()->flash("error_msg", 'Please change the default password. Only if you Change the default password , other functionalities on this portal will work. This is done for security purposes. Please do not share your password with anyone');
                return redirect()->route('newemployee_mydetails_passchange');
            }
                       
            $current_year  = Carbon::now()->format('Y');
                               

            $getemployeedata = DB::connection('mysql6')->table('employee')->where('id', '=', $employeeid)->get();
            
            $year = Carbon::now()->format('Y');
            $optionkey = [];
            for ($i=2019; $i <= $year ; $i++) { 
                $optionkey[$i] = ($i - 1).'-'.substr($i, -2);
            }

            
            
             $listfiles = Storage::disk('s3')->files("/newcustomerzoneassets/employeeprofileimage/".$employeeid);             
             if(count($listfiles) > 0){
                $profilepic = config('app.AWS_URL')."/".$listfiles[0];
            }
             else
             {
                $profilepic = config('app.AWS_URL')."/newcustomerzoneassets/img/dummy_male.png";
             }

              $apiKeys = DB::connection('mysql6')->table('vendor_api_key')->get();
            return view('newemployeezone.list_api_key', [
    'getemployeedata' => $getemployeedata,
    'optionkey'       => $optionkey,
    'current_year'    => $current_year,
    'profilepic'      => $profilepic,
    'apiKeys'         => $apiKeys // include this from your DB query
]);

}
        else{
            return redirect()->route('newemployee_home');
        }



    }


    public function add_api_key(Request $request)
    {


         $request->validate([
        'vendor_name'    => 'required|string|max:255',
        'vendor_uname'   => 'required|string|max:255',
        'vendor_apikey'  => 'required|string|max:255',
        'vendor_password'  => 'required|string|max:255',
        
    ]);







              DB::connection('mysql6')->table('vendor_api_key')->insert([
        'v_name'     => $request->vendor_name,
        'v_username' => $request->vendor_uname,
         'password' => $request->vendor_password,
        'v_apikey'   => $request->vendor_apikey,
    ]);

return redirect()->back()->with('success', 'Vendor API Key saved successfully!');

    }
    

    public function edit_api_form(Request $request , $id)
    {


         if ($request->session()->has('employeesession')) {
        
            $encrypt = $request->session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $employeeid = $split[0];

             
             $pwd_status = $this->is_emp_didnt_passwordchanged($employeeid);
            if ($pwd_status == 0) {
                $request->session()->flash("error_msg", 'Please change the default password. Only if you Change the default password , other functionalities on this portal will work. This is done for security purposes. Please do not share your password with anyone');
                return redirect()->route('newemployee_mydetails_passchange');
            }
                       
            $current_year  = Carbon::now()->format('Y');
                               

            $getemployeedata = DB::connection('mysql6')->table('employee')->where('id', '=', $employeeid)->get();
            
            $year = Carbon::now()->format('Y');
            $optionkey = [];
            for ($i=2019; $i <= $year ; $i++) { 
                $optionkey[$i] = ($i - 1).'-'.substr($i, -2);
            }

            
            
             $listfiles = Storage::disk('s3')->files("/newcustomerzoneassets/employeeprofileimage/".$employeeid);             
             if(count($listfiles) > 0){
                $profilepic = config('app.AWS_URL')."/".$listfiles[0];
            }
             else
             {
                $profilepic = config('app.AWS_URL')."/newcustomerzoneassets/img/dummy_male.png";
             }
            


            $id=$request->id;

          $api_data = DB::connection('mysql6')->table('vendor_api_key')->where('id', $id)->first();




            return view('newemployeezone.edit_api_form')->with(['getemployeedata' => $getemployeedata,'optionkey' => $optionkey ,'current_year' => $current_year,'profilepic' => $profilepic, 'api_data'=> $api_data]);
        }
        else{
            return redirect()->route('newemployee_home');
        }    
       

    }



   public function update_api_form(Request $request, $id)
{
    // Validate form inputs
    $request->validate([
        'vendor_name'     => 'required|string|max:255',
        'vendor_uname'    => 'required|string|max:255',
        'vendor_password' => 'required|string|max:255',
        'vendor_apikey'   => 'required|string|max:255',
    ]);

    // Update the record in the database
    DB::connection('mysql6')->table('vendor_api_key')
        ->where('id', $id)
        ->update([
            'v_name'    => $request->vendor_name,
            'v_username'=> $request->vendor_uname,
            'password'  => $request->vendor_password,
            'v_apikey'  => $request->vendor_apikey,
            
        ]);

    // Redirect back with a success message
 return redirect()->back()->with('success', 'Vendor API Key saved successfully!');
}


}
    
