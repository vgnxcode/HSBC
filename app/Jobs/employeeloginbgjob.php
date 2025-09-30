<?php

namespace vgn\Jobs;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use vgn\Http\Traits\employeetrait;

class employeeloginbgjob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels,employeetrait;
    protected $employeeid;
    protected $valid;
    protected $saleorder;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($employeeid,$valid,$saleorder)
    {
        $this->employeeid = $employeeid;
        $this->valid = $valid;
        
        $this->saleorder = $saleorder;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $employeeid = $this->employeeid;
        $sapdata = $this->getemployee($employeeid);
        //dd($sapdata);

       
        
         if(($sapdata['First_Name'] != '')&&($this->valid == "1"))
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
                     'saleorder'=> $this->saleorder,
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
                        //endof active employee
                        
                        
                        
             }
    }
}
