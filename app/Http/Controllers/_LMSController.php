<?php

namespace vgn\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Crypt;
use Carbon\Carbon;
use vgn\Mail\toadminmail;
use vgn\Mail\toemployeemail;
use vgn\Mail\toemployeemailfromhod;
use vgn\Mail\toemployeemailapplicationcopy;


use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use DB;
use vgn\projectlist;
use vgn\Http\Traits\employeetrait;
use vgn\Http\Traits\LMS\checkandprocess_logictrait;


class LMSController extends Controller
{
    use checkandprocess_logictrait;

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

    public function mailtest()
    {
        $tt = Mail::to("it4@vgn.in")->send(new lmsapplicationmail("fff"));
        
    }

    public function createDateRange($startDate, $endDate, $format = "Y-m-d")
    {
        $begin = new \DateTime($startDate);
        $end = new \DateTime($endDate);

        $interval = new \DateInterval('P1D'); // 1 Day
        $dateRange = new \DatePeriod($begin, $interval, $end);

        $range = [];
        foreach ($dateRange as $date) {
            $range[] = $date->format($format);
        }

        return $range;
    }

    public function index(Request $request)
    {
        if ($request->session()->has('employeesession')) {
            $encrypt = $request->session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $employeeid = $split[0];
            $mydetails = [];
            $getlast10applications = DB::connection('mysql6')->table('leave_processed')->where('employeeid', '=', $employeeid)->orderBy('created_date', 'desc')->take(10)->get();
            $geteventdata = DB::connection('mysql6')->table('leave_processed')->where('employeeid', '=', $employeeid)->orderBy('created_date', 'desc')->get();

            $pwd_status = $this->is_emp_didnt_passwordchanged($employeeid);
            if ($pwd_status == 0) {
                $request->session()->flash("error_msg", 'Please change the default password. Only if you Change the default password , other functionalities on this portal will work. This is done for security purposes. Please do not share your password with anyone');
                return redirect()->route('newemployee_mydetails_passchange');
            }

            //return view('newemployeezone.lms.lmsmaintainance');

            $currentmonth = Carbon::now()->month;
            $currentyear = Carbon::now()->year;

            if(($request->session()->get('is_security') != '0') || ($request->session()->get('is_notice_period') != '0')){
                return redirect()->route('newemployee_dashboard');
            }
            $iscontract = $request->session()->get('is_contract');
            
            $listfiles = Storage::disk('s3')->files("/newcustomerzoneassets/employeeprofileimage/".$employeeid);             
             if(count($listfiles) > 0){
                $profilepic = config('app.AWS_URL')."/".$listfiles[0];
            }
             else
             {
                $profilepic = config('app.AWS_URL')."/newcustomerzoneassets/img/dummy_male.png";
             }

            $vendarray = array();
            if(count($geteventdata) > 0){
                
                foreach($geteventdata as $vend){
                    $newvend = (array) $vend;
                    $trimmedstartdate = $newvend['stdate'];
                    $trimmedenddate = $newvend['etdate'];
                    
                        $period = $this->createDateRange($trimmedstartdate, $trimmedenddate);
                        
                       
                       if ($trimmedstartdate == $trimmedenddate) {
                                $newvend['stdate'] = $trimmedenddate;
                                $newvend['etdate'] = $trimmedenddate;
                                $vendarray['list'][] = $newvend;
                       }else{
                           
                          
                                foreach ($period as $key => $value) {
                                $newvend['stdate'] = $value;
                                $newvend['etdate'] = $value;
                                $vendarray['list'][] = $newvend;
                               }

                                // $newvend['stdate'] = $trimmedenddate;
                                // $newvend['etdate'] = $trimmedenddate;
                                // $vendarray['list'][] = $newvend;
                            
                       }
                        
                    
                }
            }

            

            
            $month = date('F');
            $year = date('Y');

            $getholiday = $this->holiday($employeeid, $year);
             
             
            $datearray = array();         
        
        $j = 0;
        
       // dd($getholiday);
       
           if(array_key_exists('0',$getholiday['CALENDAR'])){
               
            foreach($getholiday['CALENDAR'] as $holiday){
                
                    $datearray[$j]['holiday_date'] = $this->formatdate($holiday['Date']);
                    $datearray[$j]['holiday_name'] = $holiday['Holidays'];
                    $datearray[$j]['holiday_count'] = $holiday['No_of_Days'];
                    $j++;
                
            }
           }

            $getleavebalance = DB::connection('mysql6')->table('leave_balance')->where('employeeid', '=', $employeeid)->where(['month' => $currentmonth, 'year' => $currentyear])->get();

            $checkrestricted_holiday = DB::connection('mysql6')->table('restricted_holiday')->where('employee_id', '=', $employeeid)->where(['rh_month' => $currentmonth, 'rh_year' => $currentyear])->count();
                      
            $getemployeedata = DB::connection('mysql6')->table('employee')->where('id', '=', $employeeid)->get();
            foreach ($getemployeedata as $nkey => $nvalue) {
                $gender = $nvalue->gender;
            }
            return view('newemployeezone.lms.index')->with(['getemployeedata'=>$getemployeedata,'checkrestricted_holiday' => $checkrestricted_holiday,'gender' => $gender,'iscontract' => $iscontract,'getattendance'=> $datearray,'eventdata' => $vendarray, 'getlast10applications' => $getlast10applications, 'getleavebalance' => $getleavebalance, 'profilepic'=>$profilepic, 'employeeid' => $employeeid]);
        }
        
            return view('newemployeezone.login');
                
    }

    public function requestapplication(Request $request, $id)
    {
        if ($request->session()->has('employeesession')) {
            $encrypt = $request->session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $employeeid = $split[0];
            


            $getemployeedata = DB::connection('mysql6')->table('employee')->where('id', '=', $employeeid)->get();

            foreach ($getemployeedata as $key => $value) {
                $gender = $value->gender;
                $marital_status = $value->maritalstatus;
            }
            
            $listfiles = Storage::disk('s3')->files("/newcustomerzoneassets/employeeprofileimage/".$employeeid);             
             if(count($listfiles) > 0){
                $profilepic = config('app.AWS_URL')."/".$listfiles[0];
            }
             else
             {
                $profilepic = config('app.AWS_URL')."/newcustomerzoneassets/img/dummy_male.png";
             }
            
                
            
            $partial_days_array = [
            "full" => "Full Day",
            "first_half" => "First Half",
            "second_half" => "Second Half",
            ];

            //return view('newemployeezone.lms.lmsmaintainance');
                             if($id == 1)
                             {
                                $get_restricted_holiday =  DB::connection('mysql6')->table('restricted_holiday')->where('employee_id','=',$employeeid )->where(['rh_month' => Carbon::now()->format('m'), 'rh_year' => Carbon::now()->format('Y')])->count();
                                $get_maternity_leave =  DB::connection('mysql6')->table('maternity_leave')->where('employee_id','=',$employeeid )->where(['ml_month' => Carbon::now()->format('m'), 'ml_year' => Carbon::now()->format('Y')])->count();
                                $leaves_array = [];

                                $leaves_array['CL'] = 'Casual Leave';
                                $leaves_array['SL'] = 'Sick Leave';
                                $leaves_array['PL'] = 'Earned Leave';
                                
                                if ($gender == 'Female') {
                                    if ($marital_status == 'Marr.') {
                                        if ($get_maternity_leave == 1) {
                                            $leaves_array['ML'] = 'Maternity Leave';
                                        }
                                    }
                                }
                                if($get_restricted_holiday == 1){
                                    $leaves_array['RH'] = 'Restricted Holiday';
                                }

                                
                                
                                 $routename = 'applyleaves';
                                 return view('newemployeezone.lms.'.$routename)->with(['getemployeedata'=>$getemployeedata, 'leaves_array' => $leaves_array, 'partial_days_array' => $partial_days_array, 'id'=>$id,'profilepic'=>$profilepic]);
                             }
                             elseif ($id == 2) {
                                $routename = 'permissionfinal';
                                unset($partial_days_array['full']);
                                return view('newemployeezone.lms.'.$routename)->with(['getemployeedata'=>$getemployeedata, 'id'=>$id,'partial_days_array' => $partial_days_array, 'profilepic'=>$profilepic]);
                             }
                             elseif ($id == 3) {
                                $routename = 'odfinal';
                                //unset($partial_days_array['full']);
                                return view('newemployeezone.lms.'.$routename)->with(['getemployeedata'=>$getemployeedata, 'id'=>$id,'partial_days_array' => $partial_days_array, 'profilepic'=>$profilepic]);
                             }
                             elseif ($id == 4) {
                                $routename = 'tour';
                                unset($partial_days_array['first_half']);
                                unset($partial_days_array['second_half']);
                                return view('newemployeezone.lms.'.$routename)->with(['getemployeedata'=>$getemployeedata, 'id'=>$id,'partial_days_array' => $partial_days_array, 'profilepic'=>$profilepic]);
                             }
                             else{
                                 return redirect()->route('lmshome');
                             }

            
            
            
        }
        
            return view('newemployeezone.login');
    }


       
   

    public function getleave_balance_api(Request $request, $id)
    {
        if ($request->session()->has('employeesession')) {
            $encrypt = $request->session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $employeeid = $split[0];

            $getemployeedata =  DB::connection('mysql6')->table('employee')->where('id','=',$employeeid )->get();

            foreach ($getemployeedata as $key => $value) {
                $empofficialmailid = $value->officialmail;
                $empname = $value->name;
                $empdepartment = $value->department;
                $empposition = $value->position;
            }

            $getactiveemployees = $this->getallactiveemployees();
            
            $reportingincharge = [];

            if (count($getactiveemployees) > 0) {
                $i=0;
                foreach ($getactiveemployees['Details'] as $key => $value) {
                    
                    
                    if($value['Emp_ID'] == $employeeid){
                    
                       $reportingincharge = $value;
                        
                        }
                        
                       
                    }
                }    
            $reportingchargeid = $reportingincharge['RM_ID'];
            $getreportinchargedata =  DB::connection('mysql6')->table('employee')->where('id',$reportingchargeid )->get();
            foreach ($getreportinchargedata as $key1 => $value1) {
                $reportofficialmailid = $value1->officialmail;
                $reportname = $value1->name;
                $reportdepartment = $value1->department;
                $reportposition = $value1->position;
            }

            $hod_mailarray = [];
            $hod_mailarray['hod_mailid'] = $reportofficialmailid;
            $hod_mailarray['hod_name'] = $reportname;
            $hod_mailarray['employee_id'] = $employeeid;
            $hod_mailarray['employee_name'] = $empname;
            $hod_mailarray['employee_mailid'] = $empofficialmailid;
            $hod_mailarray['employee_department'] = $empdepartment;
            $hod_mailarray['employee_designation'] = $empposition;
            
            
            $leave_type = $request->leave_type;
        $leave_date_range = $request->leave_date_range;
        $partial_days = $request->partial_days;
        $leave_reason = $request->leave_reason;

        
        if ($leave_type != 'Onduty') {
            $splitrange = explode('-',$leave_date_range);

        $startdate = $this->dateformatreturnddmmyytoyymmdd(trim($splitrange[0]));
        $enddate = $this->dateformatreturnddmmyytoyymmdd(trim($splitrange[1]));
        $diff = $this->formatforempdat_differbtwtwodates($startdate, $enddate);
        }else{
            $startdate = $this->dateformatreturnddmmyytoyymmdd(trim($leave_date_range));
            $diff = '1';
        }
        
        $currentdate = Carbon::now()->format('Y-m-d');


        

            if(($request->leave_type == 'SL') && ($diff > 2)){

                $validate = $this->validate($request, [
                    'leave_type' => 'required',
                    'leave_date_range' => 'required|currentmonth|isprevnextdateapplicationsmeetup|checkappliedleaves',
                    'partial_days' => 'required|leavecountcheck',
                    'leave_reason' => 'required',
                    'sickleavefile' => 'required_if:leave_type,SL'
                    ]);
                
            }
            elseif ($request->leave_type == 'CL') {
                $validate = $this->validate($request, [
                    'leave_type' => 'required',
                    'leave_date_range' => 'required|lessthancurrentdate|currentmonth|isprevnextdateapplicationsmeetup|checkappliedleaves',
                    'partial_days' => 'required|leavecountcheck',
                    'leave_reason' => 'required'
                    ]);
            }
            elseif ($request->leave_type == 'Permission') {
                $validate = $this->validate($request, [
                    'leave_type' => 'required',
                    'leave_date_range' => 'required|permissionhours|lessthancurrentdate|currentmonth|checkappliedleaves',
                    'partial_days' => 'required|leavecountcheck|ismatch_with_shifttimings|permissioncount',
                    'leave_reason' => 'required'
                    ]);
            }
            elseif ($request->leave_type == 'Onduty') {
                $validate = $this->validate($request, [
                    'leave_type' => 'required',
                    'leave_date_range' => 'required|onlypast3days|currentmonth|checkappliedleaves',
                    'partial_days' => 'required',
                    'leave_reason' => 'required'
                    ]);
            }
            elseif ($request->leave_type == 'Tour') {
                $validate = $this->validate($request, [
                    'leave_type' => 'required',
                    'leave_date_range' => 'required|onlypast3_futuredays|checkappliedleaves',
                    'partial_days' => 'required',
                    'leave_reason' => 'required'
                    ]);
            }
            else{

                if($request->leave_type == 'ML'){

                    $validate = $this->validate($request, [
                        'leave_type' => 'required',
                        'leave_date_range' => 'required|lessthancurrentdate|maternity_weeks|isprevnextdateapplicationsmeetup|checkappliedleaves',
                        'partial_days' => 'required|leavecountcheck',
                        'leave_reason' => 'required',
                        'maternityfile' => 'required_if:leave_type,ML'
                        ]);

                }else{
                    
                   
                        $validate = $this->validate($request, [
                            'leave_type' => 'required',
                            'leave_date_range' => 'required|currentmonth|isprevnextdateapplicationsmeetup|checkappliedleaves',
                            'partial_days' => 'required|leavecountcheck',
                            'leave_reason' => 'required'
                            ]);
                    
               
                }

            }

           
            
        

        /**
         * start of casual leave
         */
        
        if($leave_type == 'CL'){

        $check_error_process = $this->doclcheckfunction($employeeid, $startdate, $enddate, $partial_days, $leave_type);
        
        if(!empty($check_error_process)){
            $request->session()->flash("error_msg", $check_error_process);
           return redirect()->back()->withInput();
        }

        
        $run_apply_process = $this->clprocess($employeeid, $startdate, $enddate, $partial_days, $leave_type,$leave_reason, $hod_mailarray);

        if($run_apply_process == true){
            
            $request->session()->flash("suc_msg", "Successfully leave application Submitted!.");
           return redirect()->back();
        }

        }

        /**
         * End of casual leave
         */
              
        /**
         * Start of Sick leave check
         */

         if ($leave_type == 'SL') {

            $check_error_process = $this->doslcheckfunction($employeeid, $startdate, $enddate, $partial_days, $leave_type, $request);
        
            if(!empty($check_error_process)){
                $request->session()->flash("error_msg", $check_error_process);
               return redirect()->back()->withInput();
            }

            $run_apply_process = $this->slprocess($employeeid, $startdate, $enddate, $partial_days, $leave_type,$leave_reason, $request,$hod_mailarray);

            if($run_apply_process == true){

                //Mail::to("it4@vgn.in")->send(new lmsapplicationmail($leave_type));
               
                $request->session()->flash("suc_msg", "Successfully leave application Submitted!.");
               return redirect()->back();
            }
             
         }

         /**
         * End of Sick leave check
         */

         /**
         * Start of Privilege leave check
         */

        if ($leave_type == 'PL') {

            $check_error_process = $this->doplcheckfunction($employeeid, $startdate, $enddate, $partial_days, $leave_type, $request);
        
            if(!empty($check_error_process)){
                $request->session()->flash("error_msg", $check_error_process);
               return redirect()->back()->withInput();
            }

            $run_apply_process = $this->plprocess($employeeid, $startdate, $enddate, $partial_days, $leave_type,$leave_reason, $request, $hod_mailarray);

            if($run_apply_process == true){
                $request->session()->flash("suc_msg", "Successfully leave application Submitted!.");
               return redirect()->back();
            }
             
         }

         /**
         * End of Privilege leave check
         */

         /**
         * Start of Restricted leave check
         */

        if ($leave_type == 'RH') {

            $check_error_process = $this->dorhcheckfunction($employeeid, $startdate, $enddate, $partial_days, $leave_type, $request);
        
            if(!empty($check_error_process)){
                $request->session()->flash("error_msg", $check_error_process);
               return redirect()->back()->withInput();
            }

            $run_apply_process = $this->rhprocess($employeeid, $startdate, $enddate, $partial_days, $leave_type,$leave_reason, $request, $hod_mailarray);

            if($run_apply_process == true){
                $request->session()->flash("suc_msg", "Successfully leave application Submitted!.");
               return redirect()->back();
            }
             
         }

         /**
         * End of Restricted leave check
         */

         /**
         * Start of Restricted leave check
         */

        if ($leave_type == 'ML') {

            $check_error_process = $this->domlcheckfunction($employeeid, $startdate, $enddate, $partial_days, $leave_type, $request);
        
            if(!empty($check_error_process)){
                $request->session()->flash("error_msg", $check_error_process);
               return redirect()->back()->withInput();
            }

            $run_apply_process = $this->mlprocess($employeeid, $startdate, $enddate, $partial_days, $leave_type,$leave_reason, $request, $hod_mailarray);

            if($run_apply_process == true){
                $request->session()->flash("suc_msg", "Successfully leave application Submitted!.");
               return redirect()->back();
            }
             
         }

         /**
         * End of Restricted leave check
         */


          /**
         * Start of Permission check
         */

        if ($leave_type == 'Permission') {

           
            $check_error_process = $this->dopermissioncheckfunction($employeeid, $partial_days, $request);
        
            if(!empty($check_error_process)){
                $request->session()->flash("error_msg", $check_error_process);
               return redirect()->back()->withInput();
            }

            $run_apply_process = $this->permissionprocess($employeeid, $partial_days, $leave_reason, $request, $hod_mailarray);

            if($run_apply_process == true){
                $request->session()->flash("suc_msg", "Successfully permission application Submitted!.");
               return redirect()->back();
            }
             
         }

         /**
         * End of Permission leave check
         */

          /**
         * Start of Onduty check
         */

        if ($leave_type == 'Onduty') {

            

            $check_error_process = $this->doondutycheckfunction($employeeid, $partial_days, $request);
        
            if(!empty($check_error_process)){
                $request->session()->flash("error_msg", $check_error_process);
               return redirect()->back()->withInput();
            }

            $run_apply_process = $this->ondutyprocess($employeeid, $partial_days, $leave_reason, $request, $hod_mailarray);

            if($run_apply_process == true){
                $request->session()->flash("suc_msg", "Successfully On-duty application Submitted!.");
               return redirect()->back();
            }
             
         }

         /**
         * End of Onduty check
         */

          /**
         * Start of Tour check
         */

        if ($leave_type == 'Tour') {

            

            $check_error_process = $this->dotourcheckfunction($employeeid,$startdate, $enddate,$diff, $partial_days, $request);
        
            if(!empty($check_error_process)){
                $request->session()->flash("error_msg", $check_error_process);
               return redirect()->back()->withInput();
            }

            $run_apply_process = $this->tourprocess($employeeid,$startdate, $enddate,$diff, $partial_days, $leave_reason, $request, $hod_mailarray);

            if($run_apply_process == true){
                $request->session()->flash("suc_msg", "Successfully Tour application Submitted!.");
               return redirect()->back();
            }
             
         }

         /**
         * End of Tour check
         */

        }
        
        return redirect()->back()->withInput();
    }


   

    public function getodpunches(Request $request)
    {
        if ($request->session()->has('employeesession')) {
            $encrypt = $request->session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $employeeid = $split[0];

        $start_date = $request->startdate;
        $end_date = $request->enddate;

        
        
        $startdate = $this->dateformatreturnddmmyytoyymmdd(trim($start_date));
        $enddate = $this->dateformatreturnddmmyytoyymmdd(trim($end_date));
        
        $getpunches = $this->getpunches($employeeid, $startdate, $enddate);

       

        if(!empty($getpunches)){
            if (!empty($getpunches['Sorted_Punches'])) {
                return response()
            ->json(['punches' => $getpunches['Sorted_Punches'] ,'message' => 'Authorized'], 200);
            }else{
                return response()
            ->json(['punches'=> [], 'message' => 'Authorized'], 200);
            }
            
        }else{
            return response()
            ->json(['punches'=> [], 'message' => 'Authorized'], 200);
        }
        

        }
        
        return response()
            ->json(['message' => "Unauthorized"], 401);
    }


    public function shiftchange(Request $request)
    {
        if ($request->session()->has('employeesession')) {
            $encrypt = $request->session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $employeeid = $split[0];

           $listfiles = Storage::disk('s3')->files("/newcustomerzoneassets/employeeprofileimage/".$employeeid);             
             if(count($listfiles) > 0){
                $profilepic = config('app.AWS_URL')."/".$listfiles[0];
            }
             else
             {
                $profilepic = config('app.AWS_URL')."/newcustomerzoneassets/img/dummy_male.png";
             }

            $getemployeedata = DB::connection('mysql6')->table('employee')->where('id', '=', $employeeid)->get();

            foreach ($getemployeedata as $key => $value) {
                $rolecode = $value->role_code;
            }
            if ($rolecode != 'ADM_TM(PLANT)') {
                return redirect()->route('lmshome');
            }

            $getactiveemployees = $this->getallactiveemployees();
            
            $getsubordinates = [];

            if (count($getactiveemployees) > 0) {
                $i=0;
                foreach ($getactiveemployees['Details'] as $key => $value) {
                    
                    
                    if($value['Emp_ID'] == $employeeid){
                    
                        if ($value['Role_Code'] == 'ADM_TM(PLANT)') {

                            foreach ($getactiveemployees['Details'] as $key1 => $value1) {
                                if ($value1['Plant_Code'] == $value['Plant_Code']) {
                                    
                                    if (($value1['Emp_ID'] != $employeeid) && ($value1['Emp_ID'] != $value1['RM_ID'])) {
                                        
                                    $getsubordinates[$i]['empid'] = $value1['Emp_ID'];
                                    $getsubordinates[$i]['empname'] = $value1['Emp_Name'].' - '.$value1['Plant_Code'];
                                    $i += 1;
                                    }
                                   
                                }
                            }
                        
                        }
                        
                       
                    }
                }    
            }
            
            
            
            $shiftdetails = $this->shiftdetails();
            

            
        return view('newemployeezone.lms.shiftchange')->with(['getemployeedata'=>$getemployeedata,'getsubordinates' => $getsubordinates,'shiftdetails' => $shiftdetails ,'profilepic'=>$profilepic]);
        }
        return view('newemployeezone.login');
    }

    public function postshiftchange(Request $request)
    {
        if ($request->session()->has('employeesession')) {
            $encrypt = $request->session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $employeeid = $split[0];

           
            $shiftdetails = $this->shiftdetails();
            $validate = $this->validate($request, [
                'subordinate' => 'required',
                'leave_date_range' => 'required|onlynext15days',
                'allocatedshift' => 'required'
                ]);


                                $splitrange = explode('-',$request->leave_date_range);
                                $start_date = $this->dateformatreturnddmmyytoyymmdd(trim($splitrange[0]));
                                $end_date = $this->dateformatreturnddmmyytoyymmdd(trim($splitrange[1]));


                                $period = $this->createDateRange($start_date, $end_date);
                                

                                $datetoinsertarray = [];
                                
                                if ($start_date == $end_date) {
                                    $datetoinsertarray[] = $start_date;
                                
                           }else{
                               
                               if (count($period) == 1) {
    
                                    $datetoinsertarray[] = $start_date;
                                    $datetoinsertarray[] = $end_date;
                                    
                                }else{
                                    $i = 0;
                                    foreach ($period as $key => $value) {

                                    $datetoinsertarray[$i] = $value;
                                    $i += 1;
                                   }
    
                                    $datetoinsertarray[$i] = $end_date;
                                }
                           }

                           $error = [];
                           foreach ($datetoinsertarray as $keydate => $valuedate) {
                            $betweencheck =  DB::connection('mysql6')->table('shift_changes')->where(['employeeid' => $request->subordinate,'shift_assigned_date' => $valuedate])->count();              
                            if ($betweencheck > 0) {
                                $error[] = 'Shift Change application date already exists.' ;
                                $request->session()->flash("error_msg", $error);
                                   return redirect()->back()->withInput();
        
                            }

                          }

                          $shiftname = '';
                          foreach ($shiftdetails['Shift_Details'] as $skey => $svalue) {
                              if ($svalue['Shift_Code'] == $request->allocatedshift) {
                                  $shiftname = $svalue['Shift_Description'];
                              }
                          }
                          


                          $sapupdate = $this->shiftchangerequest($request->subordinate, $start_date, $end_date, $request->allocatedshift);
                        if($sapupdate['Status'] == 'Shift changed Successfully'){

                            foreach ($datetoinsertarray as $keydate => $valuedate) {
                                $insert =  DB::connection('mysql6')->table('shift_changes')
                                ->insert([
                                    'employeeid' => $request->subordinate,
                                    'assigned_reportincharge' => $employeeid,
                                    'shift_assigned_date' => $valuedate,
                                    'shift_code' => $request->allocatedshift,
                                    'shift_name' => $shiftname,
                                    'shift_created_date' => Carbon::now()->toDateTimeString()
                                    ]);              
                               
                              }

                            $request->session()->flash("suc_msg", $shiftname.' Shift Successfully assigned to '.$request->subordinate.' from '.$start_date.' to '. $end_date);
                                   return redirect()->back()->withInput();
                        }

                                  
        }
        return view('newemployeezone.login');
    }

    public function viewallapplication(Request $request)
    {
        if ($request->session()->has('employeesession')) {
            $encrypt = $request->session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $employeeid = $split[0];
            $mydetails = [];
            $getemployeedata = DB::connection('mysql6')->table('employee')->where('id', '=', $employeeid)->get();
            $getallapplications = DB::connection('mysql6')->table('leave_processed')->where('employeeid', '=', $employeeid)->orderBy('created_date', 'desc')->get();
            $appdeleterequesttohod = DB::connection('mysql6')->table('appl_delete_request')->where('requested_empid', '=', $employeeid)->get();

            $currentmonth = Carbon::now()->month;
            $currentyear = Carbon::now()->year;

            $listfiles = Storage::disk('s3')->files("/newcustomerzoneassets/employeeprofileimage/".$employeeid);             
             if(count($listfiles) > 0){
                $profilepic = config('app.AWS_URL')."/".$listfiles[0];
            }
             else
             {
                $profilepic = config('app.AWS_URL')."/newcustomerzoneassets/img/dummy_male.png";
             }

            if(count($getallapplications) > 0)
            {
                
                    foreach ($getallapplications as $key => $value) {
                        $getallapplications[$key]->raised_delete_req = 0;
                        if (count($appdeleterequesttohod) > 0) {
                            foreach ($appdeleterequesttohod as $key1 => $value1) {
                                if ($value->id == $value1->primary_id) {
                                    $getallapplications[$key]->raised_delete_req = $value1->mail_triggered_count;
                                }
                            }
                        }
                    }
                
            }

            //dd($getallapplications);

            return view('newemployeezone.lms.viewallapplication')->with(['getemployeedata'=>$getemployeedata,'getallapplications' => $getallapplications, 'profilepic'=>$profilepic, 'employeeid' => $employeeid]);

        }

        return view('newemployeezone.login');
    }


    public function compoff(Request $request)
    {
        if ($request->session()->has('employeesession')) {
            $encrypt = $request->session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $employeeid = $split[0];
            $mydetails = [];
            $getemployeedata = DB::connection('mysql6')->table('employee')->where('id', '=', $employeeid)->get();
            $getallapplications = DB::connection('mysql6')->table('lms_applications')->where('employeeid', '=', $employeeid)->orderBy('created_date', 'desc')->get();

            $currentmonth = Carbon::now()->month;
            $currentyear = Carbon::now()->year;

            $listfiles = Storage::disk('s3')->files("/newcustomerzoneassets/employeeprofileimage/".$employeeid);             
             if(count($listfiles) > 0){
                $profilepic = config('app.AWS_URL')."/".$listfiles[0];
            }
             else
             {
                $profilepic = config('app.AWS_URL')."/newcustomerzoneassets/img/dummy_male.png";
             }
            $partial_days_array = [
                "first_half" => "First Half",
                "second_half" => "Second Half",
                ];

            return view('newemployeezone.lms.compoff')->with(['getemployeedata'=>$getemployeedata,'partial_days_array' => $partial_days_array, 'profilepic'=>$profilepic, 'employeeid' => $employeeid]);

        }

        return view('newemployeezone.login');
    }


    public function postcompoff(Request $request)
    {
        if ($request->session()->has('employeesession')) {
            $encrypt = $request->session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $employeeid = $split[0];
            $mydetails = [];
            $getemployeedata = DB::connection('mysql6')->table('employee')->where('id', '=', $employeeid)->get();
            $getallapplications = DB::connection('mysql6')->table('lms_applications')->where('employeeid', '=', $employeeid)->orderBy('created_date', 'desc')->get();

            $validate = $this->validate($request, [
                'leave_date_range' => 'required',
                'shiftworked' => 'required|in:general,night',
                'startpunch' => 'required',
                'endpunch' => 'required|different:startpunch',
                'leave_requireddate' => 'required',
                'partial_days' => 'required',
                'leave_reason' => 'required'
                ]);



                foreach ($getemployeedata as $key => $value) {
                    $empofficialmailid = $value->officialmail;
                    $empname = $value->name;
                    $empdepartment = $value->department;
                    $empposition = $value->position;
                }
    
                $getactiveemployees = $this->getallactiveemployees();
                
                $reportingincharge = [];
    
                if (count($getactiveemployees) > 0) {
                    $i=0;
                    foreach ($getactiveemployees['Details'] as $key => $value) {
                        
                        
                        if($value['Emp_ID'] == $employeeid){
                        
                           $reportingincharge = $value;
                            
                            }
                            
                           
                        }
                    }    
                $reportingchargeid = $reportingincharge['RM_ID'];
                $getreportinchargedata =  DB::connection('mysql6')->table('employee')->where('id',$reportingchargeid )->get();
                foreach ($getreportinchargedata as $key1 => $value1) {
                    $reportofficialmailid = $value1->officialmail;
                    $reportname = $value1->name;
                    $reportdepartment = $value1->department;
                    $reportposition = $value1->position;
                }
    
                $hod_mailarray = [];
                $hod_mailarray['hod_mailid'] = $reportofficialmailid;
                $hod_mailarray['hod_name'] = $reportname;
                $hod_mailarray['employee_id'] = $employeeid;
                $hod_mailarray['employee_name'] = $empname;
                $hod_mailarray['employee_mailid'] = $empofficialmailid;
                $hod_mailarray['employee_department'] = $empdepartment;
                $hod_mailarray['employee_designation'] = $empposition;



                    $check_error_process = $this->docompoffcheckfunction($employeeid, $request->partial_days, $request);
                
                    if(!empty($check_error_process)){
                        $request->session()->flash("error_msg", $check_error_process);
                       return redirect()->back()->withInput();
                    }
        
                    $run_apply_process = $this->compoffprocess($employeeid, $request->partial_days, $request->leave_reason, $request, $hod_mailarray);
        
                    if($run_apply_process == true){
                        $request->session()->flash("suc_msg", "Successfully Compoff application Submitted!.");
                       return redirect()->back();
                    }
                     
                 

        }

        return view('newemployeezone.login');
    }

   

    public function postlop(Request $request)
    {
        if ($request->session()->has('employeesession')) {
            $encrypt = $request->session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $employeeid = $split[0];
            $mydetails = [];
            $getemployeedata = DB::connection('mysql6')->table('employee')->where('id', '=', $employeeid)->get();


            $validate = $this->validate($request, [
                'leave_date_range' => 'required|lessthancurrentdate|currentmonth|checkappliedleaves',
                'partial_days' => 'required',
                'leave_reason' => 'required'
                ]);

                foreach ($getemployeedata as $key => $value) {
                    $empofficialmailid = $value->officialmail;
                    $empname = $value->name;
                    $empdepartment = $value->department;
                    $empposition = $value->position;
                }
    
                $getactiveemployees = $this->getallactiveemployees();
                
                $reportingincharge = [];
    
                if (count($getactiveemployees) > 0) {
                    $i=0;
                    foreach ($getactiveemployees['Details'] as $key => $value) {
                        
                        
                        if($value['Emp_ID'] == $employeeid){
                        
                           $reportingincharge = $value;
                            
                            }
                            
                           
                        }
                    }    
                $reportingchargeid = $reportingincharge['RM_ID'];
                $getreportinchargedata =  DB::connection('mysql6')->table('employee')->where('id',$reportingchargeid )->get();
                foreach ($getreportinchargedata as $key1 => $value1) {
                    $reportofficialmailid = $value1->officialmail;
                    $reportname = $value1->name;
                    $reportdepartment = $value1->department;
                    $reportposition = $value1->position;
                }
    
                $hod_mailarray = [];
                $hod_mailarray['hod_mailid'] = $reportofficialmailid;
                $hod_mailarray['hod_name'] = $reportname;
                $hod_mailarray['employee_id'] = $employeeid;
                $hod_mailarray['employee_name'] = $empname;
                $hod_mailarray['employee_mailid'] = $empofficialmailid;
                $hod_mailarray['employee_department'] = $empdepartment;
                $hod_mailarray['employee_designation'] = $empposition;

                    $check_error_process = $this->dolopcheckfunction($employeeid, $request->partial_days, $request);
                
                    if(!empty($check_error_process)){
                        $request->session()->flash("error_msg", $check_error_process);
                       return redirect()->back()->withInput();
                    }
        
                    $run_apply_process = $this->lopprocess($employeeid, $request->partial_days, $request->leave_reason, $request, $hod_mailarray);
        
                    if($run_apply_process == true){
                        $request->session()->flash("suc_msg", "Successfully Lop application Submitted!.");
                       return redirect()->back();
                    }
                     
                 

        }

        return view('newemployeezone.login');
    }



    public function hodreport(Request $request)
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


             $getactiveemployees = $this->getallactiveemployees();
            
             $getsubordinates = [];
 
             if (count($getactiveemployees) > 0) {
                 $i=0;
                 foreach ($getactiveemployees['Details'] as $key => $value) {
                     
                     
                     if(($value['RM_ID'] == $employeeid) || ($value['Emp_ID'] == $employeeid) ){ 
                        $getsubordinates[$i]['empid'] = $value['Emp_ID'];
                        $getsubordinates[$i]['empname'] = $value['Emp_Name'].' - '.$value['Emp_ID'];
                        $i += 1;            
                     }
                 }    
             }
            
            return view('newemployeezone.lms.hod_reportlms')->with(['getemployeedata'=> $getemployeedata,'getsubordinates'=>$getsubordinates,'profilepic' => $profilepic]);
            
               }
        else{
            return redirect()->route('newemployee_home');
        }
    }

    public function posthodreport(Request $request)
    {
        if ($request->session()->has('employeesession')) {
            $encrypt = $request->session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $employeeid = $split[0];
            $getemployeedata = DB::connection('mysql6')->table('employee')->where('id', '=', $employeeid)->get();
            

            $validate = $this->validate($request, [
                'leave_date_range' => 'required',
                'employee' => 'required'
                ]);



        $splitrange = explode('-',$request->leave_date_range);

        $startdate = $this->dateformatreturnddmmyytoyymmdd(trim($splitrange[0]));
        $enddate = $this->dateformatreturnddmmyytoyymmdd(trim($splitrange[1]));
        $diff = $this->formatforempdat_differbtwtwodates($startdate, $enddate);
            
        if ($request->employee == 'all') {
        
        }
        else{
            


        }


    $startdatecheck =  DB::connection('mysql6')->table('lms_applications')->where(['employeeid' => $request->employee])->whereRaw('"'.$startdate.'" between `start_date` and `end_date`')->get();
    $enddatecheck =  DB::connection('mysql6')->table('lms_applications')->where(['employeeid' => $request->employee])->whereRaw('"'.$enddate.'" between `start_date` and `end_date`')->get();
    $betweencheck =  DB::connection('mysql6')->table('lms_applications')->where(['employeeid' => $request->employee])->whereRaw('`start_date` >= "'.$startdate.'" and `end_date` <= "'.$enddate.'"')->get();
     
     if((count($startdatecheck) == 0) && (count($enddatecheck) == 0) && (count($betweencheck) == 0) ){
         dd(false);
     }else{
         if ($diff == '1') {
            dd($startdatecheck);    
         }
         else{
             dd($betweencheck);
         }
         
     }


             $getactiveemployees = $this->getallactiveemployees();
            
             $getsubordinates = [];
 
             if (count($getactiveemployees) > 0) {
                 $i=0;
                 foreach ($getactiveemployees['Details'] as $key => $value) {
                     
                     
                     if(($value['RM_ID'] == $employeeid) || ($value['Emp_ID'] == $employeeid) ){
                                      
                        $getsubordinates[$i]['empid'] = $value['Emp_ID'];
                        $getsubordinates[$i]['empname'] = $value['Emp_Name'].' - '.$value['Emp_ID'];
                        $i += 1;            
                     }
                 }    
             }
            
            
               }
        else{
            return redirect()->route('newemployee_home');
        }
    }

}
