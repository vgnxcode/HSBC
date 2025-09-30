<?php
namespace vgn\Http\Traits\LMS;
use Crypt;
use Carbon\Carbon;
use vgn\Mail\tohodmail;
use vgn\Mail\toemployeemailapplicationcopy;
use Illuminate\Support\Facades\Mail;
use DB;
use vgn\Http\Traits\employeetrait;
use vgn\Http\Traits\LMS\commontrait1;
use Illuminate\Support\Facades\Storage;


trait checkandprocess_logictrait{

    use employeetrait, commontrait1;
    /**
     * Input needed 
     * start date
     * end date
     * partial days
     * reason
     */

    public function checkweekoff_holidays_new($employeeid, $start_date, $end_date, $getemployee) 
    {
           /**
            * for holiday
            */
           $getyearfromstartdate = substr($start_date, 0, 4);
           $getyearfromenddate = substr($end_date, 0, 4);
           $holiday_count = 0;
           $special_holiday_dates = ['2018-08-08'];
           
           if($getyearfromstartdate == $getyearfromenddate)
           {
                $year = $getyearfromenddate; 
                $getholiday = $this->holiday($employeeid, $year);
                
                foreach ($getholiday['CALENDAR'] as $key => $value) {
                    $sap_holiday_date = substr($value['Date'], 0,4).'-'.substr($value['Date'], 4,2).'-'.substr($value['Date'], 6,2);
                    if(($sap_holiday_date == $start_date) || ($sap_holiday_date == $end_date)){
                        $holiday_count += 1;
                    }
                    if (in_array($sap_holiday_date, $special_holiday_dates)) {
                        $holiday_count += 1;
                    }
                }

            }else{

                $getholiday_startdate = $this->holiday($employeeid, $getyearfromstartdate);
                $getholiday_enddate = $this->holiday($employeeid, $getyearfromenddate);
                

                foreach ($getholiday_enddate['CALENDAR'] as $key => $value) {
                    $sap_holiday_date = substr($value['Date'], 0,4).'-'.substr($value['Date'], 4,2).'-'.substr($value['Date'], 6,2);
                    if(($sap_holiday_date == $start_date) || ($sap_holiday_date == $end_date)){
                        $holiday_count += 1;
                    }
                    if (in_array($sap_holiday_date, $special_holiday_dates)) {
                        $holiday_count += 1;
                    }
                }

                foreach ($getholiday_startdate['CALENDAR'] as $key1 => $value1) {
                    $sap_holiday_date1 = substr($value1['Date'], 0,4).'-'.substr($value1['Date'], 4,2).'-'.substr($value1['Date'], 6,2);
                    if(($sap_holiday_date1 == $start_date) || ($sap_holiday_date1 == $end_date)){
                        $holiday_count += 1;
                    }
                    if (in_array($sap_holiday_date1, $special_holiday_dates)) {
                        $holiday_count += 1;
                    }
                }

              }

              /**
               * for week off
               */

               foreach ($getemployee as $empkey => $empvalue) {
                   //dd(($empvalue['role_code'] == '4000') && ($empvalue['department']))
                   $carbon_start_date = Carbon::parse($start_date);
                   $carbon_end_date = Carbon::parse($end_date);

                   $getshiftdetails = $this->getshiftdetailsst_et_date($employeeid, $carbon_start_date, $carbon_end_date);
                   $arr = array();
                   if (array_key_exists('0', $getshiftdetails['Shift_Details']) == false) {
                       $arr['Shift_Details'][0] = $getshiftdetails['Shift_Details'];
                   }
                   else{
                       $arr['Shift_Details'] = $getshiftdetails['Shift_Details'];
                   }
                   
                   $start_shiftcode = $arr['Shift_Details'][0]['Shift_Code'];
                   $end_shiftcode = $arr['Shift_Details'][count($arr['Shift_Details']) - 1]['Shift_Code'];

                    //new
                    if(($start_shiftcode == 'VGN_GEN2') || ($end_shiftcode == 'VGN_GEN2')){
                        if(($carbon_start_date->isTuesday() == true) || ($carbon_end_date->isTuesday() == true)){
                            $weekoff_count = 1;
                        }else{
                            $weekoff_count = 0;
                        }   
                   }
                   elseif(($start_shiftcode == 'VGN_SIAD') || ($end_shiftcode == 'VGN_SIAD')){
                    if(($carbon_start_date->isTuesday() == true) || ($carbon_end_date->isTuesday() == true)){
                        $weekoff_count = 1;
                    }else{
                        $weekoff_count = 0;
                    }   
                  }
                  elseif(($start_shiftcode == 'VGN_FDAY') || ($end_shiftcode == 'VGN_FDAY')){
                        $weekoff_count = 0;
                  }
                  elseif(($start_shiftcode == 'VGN_FNIG') || ($end_shiftcode == 'VGN_FNIG')){
                    $weekoff_count = 0;
                    }
                   elseif (($start_shiftcode == 'VGN_SAP') || ($end_shiftcode == 'VGN_SAP')) {
                    if(($carbon_start_date->isSaturday() == true) || ($carbon_end_date->isSaturday() == true)){
                        $weekoff_count = 1;
                    }else{

                        if(($carbon_start_date->isSunday() == true) || ($carbon_end_date->isSunday() == true)){
                        $weekoff_count = 1;
                    }else{
                        $weekoff_count = 0;
                    } 
                    
                    }
                   }
                   else{
                    if(($carbon_start_date->isSunday() == true) || ($carbon_end_date->isSunday() == true)){
                        $weekoff_count = 1;
                    }else{
                        $weekoff_count = 0;
                    }  
                   }
                    //new
                   /*                   
                   if((strpos($empvalue->role_code, 'SAL_TM') !== false) || strpos($empvalue->role_code, 'SAL_INC') !== false){
                        if(($carbon_start_date->isTuesday() == true) || ($carbon_end_date->isTuesday() == true)){
                            $weekoff_count = 1;
                        }else{
                            $weekoff_count = 0;
                        }   
                   }
                   elseif ((strpos($empvalue->role_code, 'SAP_INC') !== false) || (strpos($empvalue->role_code, 'SAP_TM') !== false)) {
                    if(($carbon_start_date->isSaturday() == true) || ($carbon_end_date->isSaturday() == true)){
                        $weekoff_count = 1;
                    }else{

                        if(($carbon_start_date->isSunday() == true) || ($carbon_end_date->isSunday() == true)){
                        $weekoff_count = 1;
                    }else{
                        $weekoff_count = 0;
                    } 
                    
                    }
                   }
                   else{
                    if(($carbon_start_date->isSunday() == true) || ($carbon_end_date->isSunday() == true)){
                        $weekoff_count = 1;
                    }else{
                        $weekoff_count = 0;
                    }  
                   }*/
               }

              $result = [];
              $result['holiday_count'] = $holiday_count;
              $result['weekoff_count'] = $weekoff_count;
               
                return $result;

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
    public function dateformatreturnddmmyytoyymmdd($string)
    {
        
        $daycheck = substr($string,0,2);
        if (strlen($string) == 8) {
            $daycheck = substr($string,0,1);
            $daycheck = '0'.$daycheck;
        }
        $monthcheck = substr($string,3,2);
        if (strlen($string) == 8) {
            $monthcheck = substr($string,2,1);
            $monthcheck = '0'.$monthcheck;
        }
        $yearcheck = substr($string,6,4);
        if (strlen($string) == 8) {
            $yearcheck = substr($string,4,4);
            
        }

        return $yearcheck.'-'.$monthcheck.'-'.$daycheck;
    }
    public function only_present_future_date_check($start_date)
    {
        $applicationstartdate = Carbon::parse($start_date);
        $currentdateformatstring = Carbon::now()->toDateString();
        $presentdate = Carbon::parse($currentdateformatstring);

        $checklessthancurrentdate = $applicationstartdate->gte($presentdate);

        return $checklessthancurrentdate;
    }
    
     public function doclcheckfunction($employeeid, $start_date, $end_date, $partial_days, $leave_type)
     {
         $error = [];
         $getemployee =  DB::connection('mysql6')->table('employee')->where('id',$employeeid )->get();

        //$onlypresentfuturedatecheck =  $this->only_present_future_date_check($start_date);
           // if($onlypresentfuturedatecheck == false){ $error[] = "Applied Date Cannot be less than current date.";  }
        //$onlyforcurrentmonthcheck = $this->only_for_current_month_check($start_date, $end_date);
            //if($onlyforcurrentmonthcheck == false){ $error[] = "Application can be accepted only for current month.";  }
       // $checkprevnextdatesmeetwithanotherapplications =  $this->checkprevnextdates_meetwithanotherapplications($employeeid, $start_date, $end_date, $leave_type);
           // if($checkprevnextdatesmeetwithanotherapplications == true){ $error[] = "Please check the prev/next start and end date. Consecutive leave applications are not allowed.";  }
       // $checkwithappliedleavesdates = $this->check_with_applied_leaves_dates($employeeid, $start_date, $end_date);
          //  if($checkwithappliedleavesdates == true){ $error[] = "Applied Leave Dates found with previous Approved/Pending application dates.";  }
        //$checkleavecountmatchesorlessthanapplied = $this->checkleavecount_matches_or_lessthanapplied($employeeid, $start_date, $end_date, $leave_type, $partial_days);
          //  if($checkleavecountmatchesorlessthanapplied == false){ $error[] = "Applied Leave Counts exceeds the leave balance."; }
        $checkweekoffholidays = $this->checkweekoff_holidays($employeeid, $start_date, $end_date,$getemployee);
            if($checkweekoffholidays['holiday_count'] == '1'){ $error[] = "Applied Leave Dates found with Holiday date."; }
            if($checkweekoffholidays['weekoff_count'] == '1'){ $error[] = "Applied Leave Dates found with Week-off date."; }
       

          

        /*
         $cldontallowpreviousdate =  $this->cldontallow_previousdate($employeeid, $start_date, $end_date,$getemployee);

         if($cldontallowpreviousdate == false){ $error[] = "Applied Date Cannot be less than current date for casual leave.";  }

         $checkstartandenddatenextdates =  $this->checkstartandenddate_nextdates($employeeid, $start_date, $end_date,$getemployee);
         if($checkstartandenddatenextdates == true){ $error[] = "Applied next Date falls with another leavetype.";  }


         $checkwithappliedleaves = $this->check_with_applied_leaves($employeeid, $start_date, $end_date);
        
         if($checkwithappliedleaves == true){ $error[] = "Applied Leave Dates found with previous Approved/Pending application dates.";  }

         $checkweekoffholiday = $this->checkweekoff_holiday($employeeid, $start_date, $end_date,$getemployee);
        
          if($checkweekoffholiday['holiday_count'] == '1'){ $error[] = "Applied Leave Dates found with Holiday date."; }
          if($checkweekoffholiday['weekoff_count'] == '1'){ $error[] = "Applied Leave Dates found with Week-off date."; }

          $checkleavecountmatcheslessthanapplied = $this->checkleavecount_matches_lessthanapplied($employeeid, $start_date, $end_date, $leave_type, $partial_days);
          if($checkleavecountmatcheslessthanapplied == false){ $error[] = "Applied Leave Counts exceeds the leave balance."; }

          $checkforpast7daysapplication = $this->checkforpast7daysapplication($employeeid, $start_date, $end_date, $leave_type, $partial_days);
          
         if($checkforpast7daysapplication != false){ $error[] = $checkforpast7daysapplication; }
          */

         return $error;
         
     }

    public function checkforpast7daysapplication($employeeid, $start_date, $end_date, $leave_type, $partial_days)
    {
           $current_date = Carbon::now();
            $year = $current_date->year;
            $month = $current_date->month;
            $day = $current_date->day;
            $subfivedays = Carbon::now()->subDays(5); 
            $endofmonth= Carbon::now()->endOfMonth();
            
            $carbonparsestartdate = Carbon::parse($start_date);
            $carbonparseenddate = Carbon::parse($end_date);
            
            $subfivedayscarbon = $carbonparsestartdate->lt($subfivedays);
            $endofmonthcarbon = $carbonparseenddate->gt($endofmonth);

            if(($subfivedayscarbon == true) || (($endofmonthcarbon == true))){
                return $error = 'Application can be taken 5 days from current date to end of current month.';
            }
            else{
                return false;
            }
            
    }
     
    public function oldclprocess($employeeid, $startdate, $enddate, $partial_days, $leave_type,$leave_reason,$hod_mailarray)
    {
        $hod_mailarray['leave_type'] = 'Casual Leave';
            $getemployee =  DB::connection('mysql6')->table('employee')->where('id',$employeeid )->get();
            $currentdatetime = Carbon::now()->toDateTimeString();
           $year = $this->returnyear($startdate);
           $month = $this->returnmonth($startdate);
            
            $getleavecount =  DB::connection('mysql6')->table('leave_balance')->where('employeeid', $employeeid)
                                ->where(['year' => $year, 'month' => $month])
                                ->get();
                                
                                $applieddays = $this->differbtwtwodates($startdate, $enddate);
                                if(count($getleavecount) == 0){
                                    return true;
                                }else{

                                $db_balance = $getleavecount[0]->$leave_type;


                                if($partial_days == 'full') {

                                    $minus_bal = $db_balance - $applieddays;
                                    $noofdays = $applieddays;
                                }else {
                                    $minus_bal = $db_balance - 0.5;
                                    $noofdays = 0.5;
                                }

                                if ($partial_days == 'first_half') {
                                    $breif_partial_days = 'First Half';
                                }
                               elseif ($partial_days == 'second_half') {
                                    $breif_partial_days = 'Second Half';
                                }
                                else {
                                    $breif_partial_days = 'Full Day';
                                }

                                if ($noofdays == '1') {
                                    $hod_mailarray['subject'] = 'LMS Application of '.$hod_mailarray['employee_name'].' - '.$employeeid.' on '.Carbon::parse($startdate)->format('d M, Y');
                                }
                                else{
                                    $hod_mailarray['subject'] = 'LMS Application of '.$hod_mailarray['employee_name'].' - '.$employeeid.' on ('.Carbon::parse($startdate)->format('d M, Y').' to '.Carbon::parse($enddate)->format('d M, Y').')';
                                }
                                
                                $hod_mailarray['start_date'] = Carbon::parse($startdate)->format('d M, Y');
                                $hod_mailarray['end_date'] = Carbon::parse($enddate)->format('d M, Y');
                                $hod_mailarray['no_of_days'] = $noofdays;
                                $hod_mailarray['partial_days'] = $breif_partial_days;
                                $hod_mailarray['application_reason'] = $leave_reason;
                                $hod_mailarray['request_created_datetime'] = $currentdatetime;
                                $hod_mailarray['attachment'] = null;
                                $hod_mailarray['compoff_worked_shift'] = null;
                                $hod_mailarray['compoff_worked_stdate'] = null;
                                $hod_mailarray['compoff_worked_etdate'] = null;
                                $hod_mailarray['compoff_worked_hours'] = null;
                                $month = Carbon::now()->format('m');
                                $year = Carbon::now()->format('Y');
                                

                                 $insert_application = DB::connection('mysql6')->table('lms_applications')
                                                         ->insertGetId([
                                                             'employeeid' => $employeeid,
                                                             'month' => $month,
                                                             'year' => $year,
                                                             'type' => $leave_type,
                                                             'start_date' => $startdate,
                                                             'end_date' => $enddate,
                                                             'partial_days' => $partial_days,
                                                             'no_of_days' => $noofdays,
                                                             'reason' => $leave_reason,
                                                             'hod_status' => 'Pending',
                                                             'hod_reason' => null,
                                                             'admin_status' => 'Pending',
                                                             'admin_reason' => null,
                                                             'final_status' => 'Pending',
                                                             'created_date' => $currentdatetime,
                                                             'hod_created_date' => null,
                                                             'admin_created_date' => null,
                                                             'application_modified_count' => 0,
                                                             'category' => 'leave',
                                                             'saved_file' => null,
                                                             'compoff_worked_shift' => null,
                                                             'compoff_worked_stdate' => null,
                                                             'compoff_worked_etdate' => null,
                                                             'compoff_worked_hours' => null,
                                                             'hod_session_key' => null,
                                                             'admin_session_key' => null
                                                         ]);

                        $randomno1 = rand(1, 5000);
                        $toencrypt1 = $employeeid.'-#hod#-'.$insert_application.'-'.$randomno1.$leave_type.$currentdatetime;
                        $hodencrypt = Crypt::encrypt($toencrypt1);

                        $hod_mailarray['hod_encrypt'] = $hodencrypt;

                        $update_hodsession = DB::connection('mysql6')->table('lms_applications')->where(['employeeid' => $employeeid, 'id' => $insert_application])
                        ->update([ "hod_session_key" => $hodencrypt ]);

                             $update_balance = DB::connection('mysql6')->table('leave_balance')->where(['employeeid' => $employeeid, 'month' => $month, 'year'=>$year])
                                                         ->update([ "$leave_type" => $minus_bal ]);

                            Mail::to($hod_mailarray['hod_mailid'])->send(new tohodmail($hod_mailarray));
                            Mail::to($hod_mailarray['employee_mailid'])->send(new toemployeemailapplicationcopy($hod_mailarray));
                                                            
                                                        return true;

                                
                                
                            }
    }



    public function doslcheckfunction($employeeid, $start_date, $end_date, $partial_days, $leave_type, $request)
    {
        $error = [];
        $getemployee =  DB::connection('mysql6')->table('employee')->where('id',$employeeid )->get();

       
       //$onlyforcurrentmonthcheck = $this->only_for_current_month_check($start_date, $end_date);
           //if($onlyforcurrentmonthcheck == false){ $error[] = "Application can be accepted only for current month.";  }
      // $checkprevnextdatesmeetwithanotherapplications =  $this->checkprevnextdates_meetwithanotherapplications($employeeid, $start_date, $end_date, $leave_type);
          // if($checkprevnextdatesmeetwithanotherapplications == true){ $error[] = "Please check the prev/next start and end date. Consecutive leave applications are not allowed.";  }
       //$checkwithappliedleavesdates = $this->check_with_applied_leaves_dates($employeeid, $start_date, $end_date);
           //if($checkwithappliedleavesdates == true){ $error[] = "Applied Leave Dates found with previous Approved/Pending application dates.";  }
       //$checkleavecountmatchesorlessthanapplied = $this->checkleavecount_matches_or_lessthanapplied($employeeid, $start_date, $end_date, $leave_type, $partial_days);
           //if($checkleavecountmatchesorlessthanapplied == false){ $error[] = "Applied Leave Counts exceeds the leave balance."; }
       $checkweekoffholidays = $this->checkweekoff_holidays($employeeid, $start_date, $end_date,$getemployee);
           if($checkweekoffholidays['holiday_count'] == '1'){ $error[] = "Applied Leave Dates found with Holiday date."; }
           if($checkweekoffholidays['weekoff_count'] == '1'){ $error[] = "Applied Leave Dates found with Week-off date."; }
        
           
           if ($request->hasFile('sickleavefile')) {
                $checkthefile = $this->checkthefile($employeeid, $start_date, $end_date,$request, 'sickleavefile');
                if(!empty($error)){
                    foreach ($checkthefile as $key => $value) {
                        $error[] = $value;
                    }
                }
           }


           return $error;
    }


    public function oldslprocess($employeeid, $startdate, $enddate, $partial_days, $leave_type,$leave_reason, $request, $hod_mailarray)
    {
        
        $getemployee =  DB::connection('mysql6')->table('employee')->where('id',$employeeid )->get();
        $currentdatetime = Carbon::now()->toDateTimeString();
       $year = $this->returnyear($startdate);
       $month = $this->returnmonth($startdate);
        
        $getleavecount =  DB::connection('mysql6')->table('leave_balance')->where('employeeid', $employeeid)
                            ->where(['year' => $year, 'month' => $month])
                            ->get();
                            
                            $applieddays = $this->differbtwtwodates($startdate, $enddate);
                            if(count($getleavecount) == 0){
                                return true;
                            }else{

                            $db_balance = $getleavecount[0]->$leave_type;

                            if($partial_days == 'full') {
                                $minus_bal = $db_balance - $applieddays;
                                $noofdays = $applieddays;
                            }else {
                                $minus_bal = $db_balance - 0.5;
                                $noofdays = 0.5;
                            }

                            if ($partial_days == 'first_half') {
                                $breif_partial_days = 'First Half';
                            }
                           elseif ($partial_days == 'second_half') {
                                $breif_partial_days = 'Second Half';
                            }
                            else {
                                $breif_partial_days = 'Full Day';
                            }
                            
                            if ($noofdays == '1') {
                                $hod_mailarray['subject'] = 'LMS Application of '.$hod_mailarray['employee_name'].' - '.$employeeid.' on '.Carbon::parse($startdate)->format('d M, Y');
                            }
                            else{
                                $hod_mailarray['subject'] = 'LMS Application of '.$hod_mailarray['employee_name'].' - '.$employeeid.' on ('.Carbon::parse($startdate)->format('d M, Y').' to '.Carbon::parse($enddate)->format('d M, Y').')';
                            }
                            $hod_mailarray['leave_type'] = 'Sick Leave';
                            $hod_mailarray['start_date'] = Carbon::parse($startdate)->format('d M, Y');
                            $hod_mailarray['end_date'] = Carbon::parse($enddate)->format('d M, Y');
                            $hod_mailarray['no_of_days'] = $noofdays;
                            $hod_mailarray['partial_days'] = $breif_partial_days;
                            $hod_mailarray['application_reason'] = $leave_reason;
                            $hod_mailarray['request_created_datetime'] = $currentdatetime;
                            
                            $hod_mailarray['compoff_worked_shift'] = null;
                            $hod_mailarray['compoff_worked_stdate'] = null;
                            $hod_mailarray['compoff_worked_etdate'] = null;
                            $hod_mailarray['compoff_worked_hours'] = null;

                            $month = Carbon::now()->format('m');
                            $year = Carbon::now()->format('Y');
                            
                        $getid = DB::connection('mysql6')->table('lms_applications')
                                                    ->insertGetId([
                                                        'employeeid' => $employeeid,
                                                        'month' => $month,
                                                        'year' => $year,
                                                        'type' => $leave_type,
                                                        'start_date' => $startdate,
                                                        'end_date' => $enddate,
                                                        'partial_days' => $partial_days,
                                                        'no_of_days' => $noofdays,
                                                        'reason' => $leave_reason,
                                                        'hod_status' => 'Pending',
                                                        'hod_reason' => null,
                                                        'admin_status' => 'Pending',
                                                        'admin_reason' => null,
                                                        'final_status' => 'Pending',
                                                        'created_date' => $currentdatetime,
                                                        'hod_created_date' => null,
                                                        'admin_created_date' => null,
                                                        'application_modified_count' => 0,
                                                        'category' => 'leave',
                                                        'saved_file' => null,
                                                        'permission_verified' => null,
                                                        'compoff_worked_shift' => null,
                                                        'compoff_worked_stdate' => null,
                                                        'compoff_worked_etdate' => null,
                                                        'compoff_worked_hours' => null,
                                                        'hod_session_key' => null,
                                                        'admin_session_key' => null
                                                    ]);

                        $randomno1 = rand(1, 5000);
                        $toencrypt1 = $employeeid.'-#hod#-'.$getid.'-'.$randomno1.$leave_type.$currentdatetime;
                        $hodencrypt = Crypt::encrypt($toencrypt1);
                        $hod_mailarray['hod_encrypt'] = $hodencrypt;
                        $update_hodsession = DB::connection('mysql6')->table('lms_applications')->where(['employeeid' => $employeeid, 'id' => $getid])
                                                    ->update([ "hod_session_key" => $hodencrypt ]);

                        $update_balance = DB::connection('mysql6')->table('leave_balance')->where(['employeeid' => $employeeid, 'month' => $month, 'year'=>$year])
                                                    ->update([ "$leave_type" => $minus_bal ]);

                        if($request->hasFile('sickleavefile')){

                                $path = public_path()."/newcustomerzoneassets/sickfileupload";
                                $ext = strtolower($request->file('sickleavefile')->getClientOriginalExtension());
                                                                
                                $newname = $getid.'_sickfile';
                                //Storage::disk('employeeprofilepic_uploads')->makeDirectory($destinationpath, 0777);
                                //$uploaded = Storage::disk('sickfile_uploads')->put( $newname.'.'.$ext, $request->file('sickleavefile'));

                                $npath = $request->file('sickleavefile')->store(
                                    $newname, 'sickfile_uploads'
                                );

                                DB::connection('mysql6')->table('lms_applications')->where('id', $getid)
                                                    ->update([
                                                        'saved_file' => $npath]);

                                                        $hod_mailarray['attachment'] = $npath;

                                                        Mail::to($hod_mailarray['hod_mailid'])->send(new tohodmail($hod_mailarray));
                                                        Mail::to($hod_mailarray['employee_mailid'])->send(new toemployeemailapplicationcopy($hod_mailarray));

                                                        return true;
                        }else{
                            $hod_mailarray['attachment'] = null;
                            Mail::to($hod_mailarray['hod_mailid'])->send(new tohodmail($hod_mailarray));
                            Mail::to($hod_mailarray['employee_mailid'])->send(new toemployeemailapplicationcopy($hod_mailarray));
                            return true;
                        }
                        
                        
                                                        
        
                            
                            
                        }

    }


    public function doplcheckfunction($employeeid, $start_date, $end_date, $partial_days, $leave_type, $request)
    {
        $error = [];
        $getemployee =  DB::connection('mysql6')->table('employee')->where('id',$employeeid )->get();

       //$onlypresentfuturedatecheck =  $this->only_present_future_date_check($start_date);
        //if($onlypresentfuturedatecheck == false){ $error[] = "Applied Date Cannot be less than current date.";  }
       //$onlyforcurrentmonthcheck = $this->only_for_current_month_check($start_date, $end_date);
           //if($onlyforcurrentmonthcheck == false){ $error[] = "Application can be accepted only for current month.";  }
       //$checkprevnextdatesmeetwithanotherapplications =  $this->checkprevnextdates_meetwithanotherapplications($employeeid, $start_date, $end_date, $leave_type);
           //if($checkprevnextdatesmeetwithanotherapplications == true){ $error[] = "Please check the prev/next start and end date. Consecutive leave applications are not allowed.";  }
       //$checkwithappliedleavesdates = $this->check_with_applied_leaves_dates($employeeid, $start_date, $end_date);
           //if($checkwithappliedleavesdates == true){ $error[] = "Applied Leave Dates found with previous Approved/Pending application dates.";  }
       //$checkleavecountmatchesorlessthanapplied = $this->checkleavecount_matches_or_lessthanapplied($employeeid, $start_date, $end_date, $leave_type, $partial_days);
           //if($checkleavecountmatchesorlessthanapplied == false){ $error[] = "Applied Leave Counts exceeds the leave balance."; }
       $checkweekoffholidays = $this->checkweekoff_holidays($employeeid, $start_date, $end_date,$getemployee);
           if($checkweekoffholidays['holiday_count'] == '1'){ $error[] = "Applied Leave Dates found with Holiday date."; }
           if($checkweekoffholidays['weekoff_count'] == '1'){ $error[] = "Applied Leave Dates found with Week-off date."; }
        

           return $error;
    }

    public function oldplprocess($employeeid, $startdate, $enddate, $partial_days, $leave_type,$leave_reason, $request, $hod_mailarray)
    {
        $getemployee =  DB::connection('mysql6')->table('employee')->where('id',$employeeid )->get();
            $currentdatetime = Carbon::now()->toDateTimeString();
           $year = $this->returnyear($startdate);
           $month = $this->returnmonth($startdate);
            
            $getleavecount =  DB::connection('mysql6')->table('leave_balance')->where('employeeid', $employeeid)
                                ->where(['year' => $year, 'month' => $month])
                                ->get();
                                
                                $applieddays = $this->differbtwtwodates($startdate, $enddate);
                                if(count($getleavecount) == 0){
                                    return true;
                                }else{

                                $db_balance = $getleavecount[0]->$leave_type;


                                if($partial_days == 'full') {

                                    $minus_bal = $db_balance - $applieddays;
                                    $noofdays = $applieddays;
                                }else {
                                    $minus_bal = $db_balance - 0.5;
                                    $noofdays = 0.5;
                                }
                                
                                if ($partial_days == 'first_half') {
                                    $breif_partial_days = 'First Half';
                                }
                               elseif ($partial_days == 'second_half') {
                                    $breif_partial_days = 'Second Half';
                                }
                                else {
                                    $breif_partial_days = 'Full Day';
                                }
                                
                                if ($noofdays == '1') {
                                    $hod_mailarray['subject'] = 'LMS Application of '.$hod_mailarray['employee_name'].' - '.$employeeid.' on '.Carbon::parse($startdate)->format('d M, Y');
                                }
                                else{
                                    $hod_mailarray['subject'] = 'LMS Application of '.$hod_mailarray['employee_name'].' - '.$employeeid.' on ('.Carbon::parse($startdate)->format('d M, Y').' to '.Carbon::parse($enddate)->format('d M, Y').')';
                                }
                                $hod_mailarray['leave_type'] = 'Privilege Leave';
                                $hod_mailarray['start_date'] = Carbon::parse($startdate)->format('d M, Y');
                                $hod_mailarray['end_date'] = Carbon::parse($enddate)->format('d M, Y');
                                $hod_mailarray['no_of_days'] = $noofdays;
                                $hod_mailarray['partial_days'] = $breif_partial_days;
                                $hod_mailarray['application_reason'] = $leave_reason;
                                $hod_mailarray['request_created_datetime'] = $currentdatetime;
                                
                                $hod_mailarray['compoff_worked_shift'] = null;
                                $hod_mailarray['compoff_worked_stdate'] = null;
                                $hod_mailarray['compoff_worked_etdate'] = null;
                                $hod_mailarray['compoff_worked_hours'] = null;

                                $month = Carbon::now()->format('m');
                                $year = Carbon::now()->format('Y');
                                
                                $insert_application = DB::connection('mysql6')->table('lms_applications')
                                                        ->insertGetId([
                                                            'employeeid' => $employeeid,
                                                            'month' => $month,
                                                            'year' => $year,
                                                            'type' => $leave_type,
                                                            'start_date' => $startdate,
                                                            'end_date' => $enddate,
                                                            'partial_days' => $partial_days,
                                                            'no_of_days' => $noofdays,
                                                            'reason' => $leave_reason,
                                                            'hod_status' => 'Pending',
                                                            'hod_reason' => null,
                                                            'admin_status' => 'Pending',
                                                            'admin_reason' => null,
                                                            'final_status' => 'Pending',
                                                            'created_date' => $currentdatetime,
                                                            'hod_created_date' => null,
                                                            'admin_created_date' => null,
                                                            'application_modified_count' => 0,
                                                            'category' => 'leave',
                                                            'saved_file' => null,
                                                            'permission_verified' => null,
                                                            'compoff_worked_shift' => null,
                                                            'compoff_worked_stdate' => null,
                                                            'compoff_worked_etdate' => null,
                                                            'compoff_worked_hours' => null,
                                                            'hod_session_key' => null,
                                                            'admin_session_key' => null
                                                        ]);
                            $randomno1 = rand(1, 5000);
                            $toencrypt1 = $employeeid.'-#hod#-'.$insert_application.'-'.$randomno1.$leave_type.$currentdatetime;
                            $hodencrypt = Crypt::encrypt($toencrypt1);
                            $hod_mailarray['hod_encrypt'] = $hodencrypt;                               
                            $update_hodsession = DB::connection('mysql6')->table('lms_applications')->where(['employeeid' => $employeeid, 'id' => $insert_application])
                                                                                    ->update([ "hod_session_key" => $hodencrypt ]);

                            $update_balance = DB::connection('mysql6')->table('leave_balance')->where(['employeeid' => $employeeid, 'month' => $month, 'year'=>$year])
                                                        ->update([ "$leave_type" => $minus_bal ]);

                                                        $hod_mailarray['attachment'] = null;

                                                        Mail::to($hod_mailarray['hod_mailid'])->send(new tohodmail($hod_mailarray));
                                                        Mail::to($hod_mailarray['employee_mailid'])->send(new toemployeemailapplicationcopy($hod_mailarray));
                                                            
                                                        return true;

                                
                                
                            }
    }

    public function dorhcheckfunction($employeeid, $startdate, $enddate, $partial_days, $leave_type, $request)
    {
        $error = [];
        $getemployee =  DB::connection('mysql6')->table('employee')->where('id',$employeeid )->get();

      // $onlypresentfuturedatecheck =  $this->only_present_future_date_check($start_date);
        //if($onlypresentfuturedatecheck == false){ $error[] = "Applied Date Cannot be less than current date.";  }
       //$onlyforcurrentmonthcheck = $this->only_for_current_month_check($start_date, $end_date);
           //if($onlyforcurrentmonthcheck == false){ $error[] = "Application can be accepted only for current month.";  }
       //$checkprevnextdatesmeetwithanotherapplications =  $this->checkprevnextdates_meetwithanotherapplications($employeeid, $start_date, $end_date, $leave_type);
           //if($checkprevnextdatesmeetwithanotherapplications == true){ $error[] = "Please check the prev/next start and end date. Consecutive leave applications are not allowed.";  }
       //$checkwithappliedleavesdates = $this->check_with_applied_leaves_dates($employeeid, $start_date, $end_date);
           //if($checkwithappliedleavesdates == true){ $error[] = "Applied Leave Dates found with previous Approved/Pending application dates.";  }
       //$checkleavecountmatchesorlessthanapplied = $this->checkleavecount_matches_or_lessthanapplied($employeeid, $start_date, $end_date, $leave_type, $partial_days);
          // if($checkleavecountmatchesorlessthanapplied == false){ $error[] = "Applied Leave Counts exceeds the leave balance."; }
       $checkweekoffholidays = $this->checkweekoff_holidays($employeeid, $start_date, $end_date,$getemployee);
           if($checkweekoffholidays['holiday_count'] == '1'){ $error[] = "Applied Leave Dates found with Holiday date."; }
           if($checkweekoffholidays['weekoff_count'] == '1'){ $error[] = "Applied Leave Dates found with Week-off date."; }
        

           return $error;
        
    }

    public function oldrhprocess($employeeid, $startdate, $enddate, $partial_days, $leave_type,$leave_reason, $request, $hod_mailarray)
    {
        $getemployee =  DB::connection('mysql6')->table('employee')->where('id',$employeeid )->get();
            $currentdatetime = Carbon::now()->toDateTimeString();
           $year = $this->returnyear($startdate);
           $month = $this->returnmonth($startdate);
            
            $getleavecount =  DB::connection('mysql6')->table('leave_balance')->where('employeeid', $employeeid)
                                ->where(['year' => $year, 'month' => $month])
                                ->get();
                                
                                $applieddays = $this->differbtwtwodates($startdate, $enddate);
                                if(count($getleavecount) == 0){
                                    return true;
                                }else{

                                $db_balance = $getleavecount[0]->$leave_type;


                                if($partial_days == 'full') {

                                    $minus_bal = $db_balance - $applieddays;
                                    $noofdays = $applieddays;
                                }else {
                                    $minus_bal = $db_balance - 0.5;
                                    $noofdays = 0.5;
                                }

                                if ($partial_days == 'first_half') {
                                    $breif_partial_days = 'First Half';
                                }
                               elseif ($partial_days == 'second_half') {
                                    $breif_partial_days = 'Second Half';
                                }
                                else {
                                    $breif_partial_days = 'Full Day';
                                }
                                
                                if ($noofdays == '1') {
                                    $hod_mailarray['subject'] = 'LMS Application of '.$hod_mailarray['employee_name'].' - '.$employeeid.' on '.Carbon::parse($startdate)->format('d M, Y');
                                }
                                else{
                                    $hod_mailarray['subject'] = 'LMS Application of '.$hod_mailarray['employee_name'].' - '.$employeeid.' on ('.Carbon::parse($startdate)->format('d M, Y').' to '.Carbon::parse($enddate)->format('d M, Y').')';
                                }
                                $hod_mailarray['leave_type'] = 'Restricted Holiday';
                                $hod_mailarray['start_date'] = Carbon::parse($startdate)->format('d M, Y');
                                $hod_mailarray['end_date'] = Carbon::parse($enddate)->format('d M, Y');
                                $hod_mailarray['no_of_days'] = $noofdays;
                                $hod_mailarray['partial_days'] = $breif_partial_days;
                                $hod_mailarray['application_reason'] = $leave_reason;
                                $hod_mailarray['request_created_datetime'] = $currentdatetime;
                                
                                $hod_mailarray['compoff_worked_shift'] = null;
                                $hod_mailarray['compoff_worked_stdate'] = null;
                                $hod_mailarray['compoff_worked_etdate'] = null;
                                $hod_mailarray['compoff_worked_hours'] = null;

                                $month = Carbon::now()->format('m');
                                $year = Carbon::now()->format('Y');
                                
                                
                                $insert_application = DB::connection('mysql6')->table('lms_applications')
                                                        ->insertGetId([
                                                            'employeeid' => $employeeid,
                                                            'month' => $month,
                                                            'year' => $year,
                                                            'type' => $leave_type,
                                                            'start_date' => $startdate,
                                                            'end_date' => $enddate,
                                                            'partial_days' => $partial_days,
                                                            'no_of_days' => $noofdays,
                                                            'reason' => $leave_reason,
                                                            'hod_status' => 'Pending',
                                                            'hod_reason' => null,
                                                            'admin_status' => 'Pending',
                                                            'admin_reason' => null,
                                                            'final_status' => 'Pending',
                                                            'created_date' => $currentdatetime,
                                                            'hod_created_date' => null,
                                                            'admin_created_date' => null,
                                                            'application_modified_count' => 0,
                                                            'category' => 'leave',
                                                            'saved_file' => null,
                                                            'permission_verified' => null,
                                                            'compoff_worked_shift' => null,
                                                            'compoff_worked_stdate' => null,
                                                            'compoff_worked_etdate' => null,
                                                            'compoff_worked_hours' => null,
                                                            'hod_session_key' => null,
                                                            'admin_session_key' => null
                                                        ]);


                            $randomno1 = rand(1, 5000);
                            $toencrypt1 = $employeeid.'-#hod#-'.$insert_application.'-'.$randomno1.$leave_type.$currentdatetime;
                            $hodencrypt = Crypt::encrypt($toencrypt1);
                            $hod_mailarray['hod_encrypt'] = $hodencrypt;                                                           
                            $update_hodsession = DB::connection('mysql6')->table('lms_applications')->where(['employeeid' => $employeeid, 'id' => $insert_application])
                                                                                                                ->update([ "hod_session_key" => $hodencrypt ]);
                            

                            $update_balance = DB::connection('mysql6')->table('leave_balance')->where(['employeeid' => $employeeid, 'month' => $month, 'year'=>$year])
                                                        ->update([ "$leave_type" => $minus_bal ]);
                            $hod_mailarray['attachment'] = null;

                            Mail::to($hod_mailarray['hod_mailid'])->send(new tohodmail($hod_mailarray));  
                            Mail::to($hod_mailarray['employee_mailid'])->send(new toemployeemailapplicationcopy($hod_mailarray)); 
                                                        return true;

                                
                                
                            }
    }


    public function domlcheckfunction($employeeid, $start_date, $end_date, $partial_days, $leave_type, $request)
    {
        $error = [];
        $getemployee =  DB::connection('mysql6')->table('employee')->where('id',$employeeid )->get();

       //$onlypresentfuturedatecheck =  $this->only_present_future_date_check($start_date);
       // if($onlypresentfuturedatecheck == false){ $error[] = "Applied Date Cannot be less than current date.";  }
      // $onlyforcurrentandaddweeks = $this->only_for_current_and_addweeks($start_date, $end_date);
          // if($onlyforcurrentandaddweeks == true){ $error[] = "Application can be accepted only from 1 week to 26 weeks.";  }

      // $checkprevnextdatesmeetwithanotherapplications =  $this->checkprevnextdates_meetwithanotherapplications($employeeid, $start_date, $end_date, $leave_type);
          // if($checkprevnextdatesmeetwithanotherapplications == true){ $error[] = "Please check the prev/next start and end date. Consecutive leave applications are not allowed.";  }
       //$checkwithappliedleavesdates = $this->check_with_applied_leaves_dates($employeeid, $start_date, $end_date);
          // if($checkwithappliedleavesdates == true){ $error[] = "Applied Leave Dates found with previous Approved/Pending application dates.";  }
      // $checkleavecountmatchesorlessthanapplied = $this->checkleavecount_matches_or_lessthanapplied($employeeid, $start_date, $end_date, $leave_type, $partial_days);
          // if($checkleavecountmatchesorlessthanapplied == false){ $error[] = "Applied Leave Counts exceeds the leave balance."; }
       $checkweekoffholidays = $this->checkweekoff_holidays($employeeid, $start_date, $end_date,$getemployee);
           if($checkweekoffholidays['holiday_count'] == '1'){ $error[] = "Applied Leave Dates found with Holiday date."; }
           if($checkweekoffholidays['weekoff_count'] == '1'){ $error[] = "Applied Leave Dates found with Week-off date."; }

           if ($request->hasFile('maternityfile')) {
            $checkthefile = $this->checkthefile($employeeid, $start_date, $end_date,$request,'maternityfile');
            if(!empty($error)){
                foreach ($checkthefile as $key => $value) {
                    $error[] = $value;
                }
            }
       }
        

           return $error;
    }


    public function oldmlprocess($employeeid, $startdate, $enddate, $partial_days, $leave_type,$leave_reason, $request, $hod_mailarray)
    {
        $getemployee =  DB::connection('mysql6')->table('employee')->where('id',$employeeid )->get();
        $currentdatetime = Carbon::now()->toDateTimeString();
       $year = $this->returnyear($startdate);
       $month = $this->returnmonth($startdate);
        
        $getleavecount =  DB::connection('mysql6')->table('leave_balance')->where('employeeid', $employeeid)
                            ->where(['year' => $year, 'month' => $month])
                            ->get();
                            
                            $applieddays = $this->differbtwtwodates($startdate, $enddate);
                            if(count($getleavecount) == 0){
                                return true;
                            }else{

                            $db_balance = $getleavecount[0]->$leave_type;

                            if($partial_days == 'full') {
                                $minus_bal = $db_balance - $applieddays;
                                $noofdays = $applieddays;
                            }else {
                                $minus_bal = $db_balance - 0.5;
                                $noofdays = 0.5;
                            }


                            if ($partial_days == 'first_half') {
                                $breif_partial_days = 'First Half';
                            }
                           elseif ($partial_days == 'second_half') {
                                $breif_partial_days = 'Second Half';
                            }
                            else {
                                $breif_partial_days = 'Full Day';
                            }
                            
                            if ($noofdays == '1') {
                                $hod_mailarray['subject'] = 'LMS Application of '.$hod_mailarray['employee_name'].' - '.$employeeid.' on '.Carbon::parse($startdate)->format('d M, Y');
                            }
                            else{
                                $hod_mailarray['subject'] = 'LMS Application of '.$hod_mailarray['employee_name'].' - '.$employeeid.' on ('.Carbon::parse($startdate)->format('d M, Y').' to '.Carbon::parse($enddate)->format('d M, Y').')';
                            }
                            $hod_mailarray['leave_type'] = 'Maternity Leave';
                            $hod_mailarray['start_date'] = Carbon::parse($startdate)->format('d M, Y');
                            $hod_mailarray['end_date'] = Carbon::parse($enddate)->format('d M, Y');
                            $hod_mailarray['no_of_days'] = $noofdays;
                            $hod_mailarray['partial_days'] = $breif_partial_days;
                            $hod_mailarray['application_reason'] = $leave_reason;
                            $hod_mailarray['request_created_datetime'] = $currentdatetime;
                            
                            $hod_mailarray['compoff_worked_shift'] = null;
                            $hod_mailarray['compoff_worked_stdate'] = null;
                            $hod_mailarray['compoff_worked_etdate'] = null;
                            $hod_mailarray['compoff_worked_hours'] = null;

                            $month = Carbon::now()->format('m');
                            $year = Carbon::now()->format('Y');
                            
                            
                        $getid = DB::connection('mysql6')->table('lms_applications')
                                                    ->insertGetId([
                                                        'employeeid' => $employeeid,
                                                        'month' => $month,
                                                        'year' => $year,
                                                        'type' => $leave_type,
                                                        'start_date' => $startdate,
                                                        'end_date' => $enddate,
                                                        'partial_days' => $partial_days,
                                                        'no_of_days' => $noofdays,
                                                        'reason' => $leave_reason,
                                                        'hod_status' => 'Pending',
                                                        'hod_reason' => null,
                                                        'admin_status' => 'Pending',
                                                        'admin_reason' => null,
                                                        'final_status' => 'Pending',
                                                        'created_date' => $currentdatetime,
                                                        'hod_created_date' => null,
                                                        'admin_created_date' => null,
                                                        'application_modified_count' => 0,
                                                        'category' => 'leave',
                                                        'saved_file' => null,
                                                        'permission_verified' => null,
                                                        'compoff_worked_shift' => null,
                                                        'compoff_worked_stdate' => null,
                                                        'compoff_worked_etdate' => null,
                                                        'compoff_worked_hours' => null,
                                                        'hod_session_key' => null,
                                                        'admin_session_key' => null
                                                    ]);

                        $randomno1 = rand(1, 5000);
                        $toencrypt1 = $employeeid.'-#hod#-'.$getid.'-'.$randomno1.$leave_type.$currentdatetime;
                        $hodencrypt = Crypt::encrypt($toencrypt1);
                        $hod_mailarray['hod_encrypt'] = $hodencrypt;                                                                                        
                        $update_hodsession = DB::connection('mysql6')->table('lms_applications')->where(['employeeid' => $employeeid, 'id' => $getid])
                                                                                                                                        ->update([ "hod_session_key" => $hodencrypt ]);
                                                    

                        $update_balance = DB::connection('mysql6')->table('leave_balance')->where(['employeeid' => $employeeid, 'month' => $month, 'year'=>$year])
                                                    ->update([ "$leave_type" => $minus_bal ]);

                        if($request->hasFile('maternityfile')){

                                $path = public_path()."/newcustomerzoneassets/maternityfile";
                                $ext = strtolower($request->file('maternityfile')->getClientOriginalExtension());
                                                                
                                $newname = $getid.'_maternityfile';
                                
                                $npath = $request->file('maternityfile')->store(
                                    $newname, 'maternityfile_uploads'
                                );

                                DB::connection('mysql6')->table('lms_applications')->where('id', $getid)
                                                    ->update([
                                                        'saved_file' => $npath]);
                            $hod_mailarray['attachment'] = $npath;

                            Mail::to($hod_mailarray['hod_mailid'])->send(new tohodmail($hod_mailarray)); 
                            Mail::to($hod_mailarray['employee_mailid'])->send(new toemployeemailapplicationcopy($hod_mailarray));
                                                        return true;
                        }else{
                            $hod_mailarray['attachment'] = null;

                            Mail::to($hod_mailarray['hod_mailid'])->send(new tohodmail($hod_mailarray));
                            Mail::to($hod_mailarray['employee_mailid'])->send(new toemployeemailapplicationcopy($hod_mailarray));
                            return true;
                        }
                        
                        
                                                        
        
                            
                            
                        }
    }

    public function dopermissioncheckfunction($employeeid, $partial_days, $request)
    {
        $error = [];
        $getemployee =  DB::connection('mysql6')->table('employee')->where('id',$employeeid )->get();
        
        $getdatetimedbformat = $this->getdatetimedbformat($request->leave_date_range);
        //$gettimedifferenceinminutes = $this->gettimedifferenceinminutes($getdatetimedbformat['starttime'], $getdatetimedbformat['endtime']);
        
        //if ($gettimedifferenceinminutes > 90) {
           // $error[] = "Applied Permission hours cannot be more than 1:30 hours.";
        //}

        //$this->mycommonattendance($employeeid, $getdatetimedbformat['starttime'], $getdatetimedbformat['endtime']);

       // $checkwithshifttimings = $this->checkwithshifttimings($getdatetimedbformat['starttime'], $getdatetimedbformat['endtime'], $employeeid, $partial_days);
        //if($checkwithshifttimings == false){ $error[] = "Application can be accepted only for corresponding shift start and endtime."; }
        
        $start_date = substr($getdatetimedbformat['starttime'], 0,10);
        $end_date = substr($getdatetimedbformat['endtime'], 0,10);

        //$onlypresentfuturedatecheck =  $this->only_present_future_date_check($start_date);
        //if($onlypresentfuturedatecheck == false){ $error[] = "Applied Date Cannot be less than current date.";  }
      // $onlyforcurrentmonthcheck = $this->only_for_current_month_check($start_date, $end_date);
          // if($onlyforcurrentmonthcheck == false){ $error[] = "Application can be accepted only for current month.";  }
       
      // $checkwithappliedleavesdates = $this->check_with_applied_leaves_dates($employeeid, $start_date, $end_date);
          // if($checkwithappliedleavesdates == true){ $error[] = "Applied Permission Dates found with previous Approved/Pending application dates.";  }
       //$checkpermission_matches_or_lessthanapplied = $this->checkpermission_matches_or_lessthanapplied($employeeid, $start_date, $end_date, $request->leave_type, $partial_days);
          // if($checkpermission_matches_or_lessthanapplied == false){ $error[] = "Applied permission exceeds the Permission balance."; }
       $checkweekoffholidays = $this->checkweekoff_holidays($employeeid, $start_date, $end_date,$getemployee);
           if($checkweekoffholidays['holiday_count'] == '1'){ $error[] = "Applied Permission Dates found with Holiday date."; }
           if($checkweekoffholidays['weekoff_count'] == '1'){ $error[] = "Applied Permission Dates found with Week-off date."; }

        return $error;
    }

    public function oldpermissionprocess($employeeid, $partial_days, $leave_reason, $request, $hod_mailarray)
    {
        $getemployee =  DB::connection('mysql6')->table('employee')->where('id',$employeeid )->get();
        $getdatetimedbformat = $this->getdatetimedbformat($request->leave_date_range);
            $currentdatetime = Carbon::now()->toDateTimeString();

            $startdate = substr($getdatetimedbformat['starttime'], 0,10);
        $enddate = substr($getdatetimedbformat['endtime'], 0,10);

           $year = $this->returnyear($startdate);
           $month = $this->returnmonth($startdate);
           $leave_type = "Permission";
            
            $getleavecount =  DB::connection('mysql6')->table('leave_balance')->where('employeeid', $employeeid)
                                ->where(['year' => $year, 'month' => $month])
                                ->get();
                                
                                $applieddays = $this->differbtwtwodates($startdate, $enddate);
                                if(count($getleavecount) == 0){
                                    return true;
                                }else{

                                $db_balance = $getleavecount[0]->$leave_type;


                                $db_balance = $getleavecount[0]->$leave_type;

                                $minus_bal = $db_balance - 1;


                                if ($partial_days == 'first_half') {
                                    $breif_partial_days = 'First Half';
                                }
                               elseif ($partial_days == 'second_half') {
                                    $breif_partial_days = 'Second Half';
                                }
                                else {
                                    $breif_partial_days = 'Full Day';
                                }
                                
                                $noofdays = 0.5;
                                $hod_mailarray['subject'] = 'LMS Application of '.$hod_mailarray['employee_name'].' - '.$employeeid.' on ('.Carbon::parse($startdate)->format('d M, Y H:i:s').' to '.Carbon::parse($enddate)->format('d M, Y H:i:s').')';
                                
                                $hod_mailarray['leave_type'] = 'Permission';
                                $hod_mailarray['start_date'] = Carbon::parse($startdate)->format('d M, Y H:i:s');
                                $hod_mailarray['end_date'] = Carbon::parse($enddate)->format('d M, Y H:i:s');
                                $hod_mailarray['no_of_days'] = $noofdays;
                                $hod_mailarray['partial_days'] = $breif_partial_days;
                                $hod_mailarray['application_reason'] = $leave_reason;
                                $hod_mailarray['request_created_datetime'] = $currentdatetime;
                                
                                $hod_mailarray['compoff_worked_shift'] = null;
                                $hod_mailarray['compoff_worked_stdate'] = null;
                                $hod_mailarray['compoff_worked_etdate'] = null;
                                $hod_mailarray['compoff_worked_hours'] = null;
                                
                                $month = Carbon::now()->format('m');
                                $year = Carbon::now()->format('Y');
                                
                                $insert_application = DB::connection('mysql6')->table('lms_applications')
                                                        ->insertGetId([
                                                            'employeeid' => $employeeid,
                                                            'month' => $month,
                                                            'year' => $year,
                                                            'type' => $leave_type,
                                                            'start_date' => $getdatetimedbformat['starttime'],
                                                            'end_date' => $getdatetimedbformat['endtime'],
                                                            'partial_days' => $partial_days,
                                                            'no_of_days' => null,
                                                            'reason' => $leave_reason,
                                                            'hod_status' => 'Pending',
                                                            'hod_reason' => null,
                                                            'admin_status' => 'Pending',
                                                            'admin_reason' => null,
                                                            'final_status' => 'Pending',
                                                            'created_date' => $currentdatetime,
                                                            'hod_created_date' => null,
                                                            'admin_created_date' => null,
                                                            'application_modified_count' => 0,
                                                            'category' => 'permission',
                                                            'saved_file' => null,
                                                            'permission_verified' => 'N',
                                                            'compoff_worked_shift' => null,
                                                            'compoff_worked_stdate' => null,
                                                            'compoff_worked_etdate' => null,
                                                            'compoff_worked_hours' => null,
                                                            'hod_session_key' => null,
                                                            'admin_session_key' => null
                                                        ]);

                                                        $randomno1 = rand(1, 5000);
                                                        $toencrypt1 = $employeeid.'-#hod#-'.$insert_application.'-'.$randomno1.$leave_type.$currentdatetime;
                                                        $hodencrypt = Crypt::encrypt($toencrypt1);
                                                        $hod_mailarray['hod_encrypt'] = $hodencrypt;                                                                                     
                                                        $update_hodsession = DB::connection('mysql6')->table('lms_applications')->where(['employeeid' => $employeeid, 'id' => $insert_application])
                                                                                                                                                                        ->update([ "hod_session_key" => $hodencrypt ]);
                                                                      

                            $update_balance = DB::connection('mysql6')->table('leave_balance')->where(['employeeid' => $employeeid, 'month' => $month, 'year'=>$year])
                                                        ->update([ "$leave_type" => $minus_bal ]);

                                                        $hod_mailarray['attachment'] = null;

                            Mail::to($hod_mailarray['hod_mailid'])->send(new tohodmail($hod_mailarray));
                            Mail::to($hod_mailarray['employee_mailid'])->send(new toemployeemailapplicationcopy($hod_mailarray));
                                                            
                                                        return true;

                                
                                
                            }
    }


    public function doondutycheckfunction($employeeid, $partial_days, $request)
    {
        $error = [];
        $getemployee =  DB::connection('mysql6')->table('employee')->where('id',$employeeid )->get();
        
        $getdatedbformat = $this->dateformatreturnddmmyytoyymmdd($request->leave_date_range);
        
        $start_date = $getdatedbformat;
        $end_date = $getdatedbformat;

        //$onlypresentpast3_date_check =  $this->only_present_past3_date_check($start_date);
        
        //if($onlypresentpast3_date_check == true){ $error[] = "Application should be current date or lesser than 3 days from current date.";  }
      // $onlyforcurrentmonthcheck = $this->only_for_current_month_check($start_date, $end_date);
           //if($onlyforcurrentmonthcheck == false){ $error[] = "Application can be accepted only for current month.";  }
       
       //$checkwithappliedleavesdates = $this->check_with_applied_leaves_dates($employeeid, $start_date, $end_date);
          // if($checkwithappliedleavesdates == true){ $error[] = "Applied Onduty Date found with previous Approved/Pending application dates.";  }
       
       $checkweekoffholidays = $this->checkweekoff_holidays($employeeid, $start_date, $end_date,$getemployee);
           if($checkweekoffholidays['holiday_count'] == '1'){ $error[] = "Applied Onduty Date found with Holiday date."; }
           if($checkweekoffholidays['weekoff_count'] == '1'){ $error[] = "Applied Onduty Date found with Week-off date."; }

        return $error;
    }

    public function oldondutyprocess($employeeid, $partial_days, $leave_reason, $request, $hod_mailarray)
    {
        $getemployee =  DB::connection('mysql6')->table('employee')->where('id',$employeeid )->get();
        
            $currentdatetime = Carbon::now()->toDateTimeString();
            $getdatedbformat = $this->dateformatreturnddmmyytoyymmdd($request->leave_date_range);
        
            $startdate = $getdatedbformat;
            $enddate = $getdatedbformat;

        
           $year = $this->returnyear($startdate);
           $month = $this->returnmonth($startdate);
           $leave_type = "Onduty";
            
            $getleavecount =  DB::connection('mysql6')->table('leave_balance')->where('employeeid', $employeeid)
                                ->where(['year' => $year, 'month' => $month])
                                ->get();
                                
                                $applieddays = $this->differbtwtwodates($startdate, $enddate);
                                if(count($getleavecount) == 0){
                                    return true;
                                }else{

                                $db_balance = $getleavecount[0]->$leave_type;


                                $db_balance = $getleavecount[0]->$leave_type;

                                $minus_bal = $db_balance + 1;


                                if ($partial_days == 'first_half') {
                                    $breif_partial_days = 'First Half';
                                }
                               elseif ($partial_days == 'second_half') {
                                    $breif_partial_days = 'Second Half';
                                }
                                else {
                                    $breif_partial_days = 'Full Day';
                                }
                                
                                
                                $hod_mailarray['subject'] = 'LMS Application of '.$hod_mailarray['employee_name'].' - '.$employeeid.' on '.Carbon::parse($startdate)->format('d M, Y');
                                
                                $hod_mailarray['leave_type'] = 'Onduty';
                                $hod_mailarray['start_date'] = Carbon::parse($startdate)->format('d M, Y');
                                $hod_mailarray['end_date'] = Carbon::parse($enddate)->format('d M, Y');
                                $hod_mailarray['no_of_days'] = $noofdays;
                                $hod_mailarray['partial_days'] = $breif_partial_days;
                                $hod_mailarray['application_reason'] = $leave_reason;
                                $hod_mailarray['request_created_datetime'] = $currentdatetime;
                                
                                $hod_mailarray['compoff_worked_shift'] = null;
                                $hod_mailarray['compoff_worked_stdate'] = null;
                                $hod_mailarray['compoff_worked_etdate'] = null;
                                $hod_mailarray['compoff_worked_hours'] = null;

                                $month = Carbon::now()->format('m');
                                $year = Carbon::now()->format('Y');
                                
                                $getdatetimedbformat = Carbon::parse($startdate)->toDateTimeString();
                                $insert_application = DB::connection('mysql6')->table('lms_applications')
                                                        ->insertGetId([
                                                            'employeeid' => $employeeid,
                                                            'month' => $month,
                                                            'year' => $year,
                                                            'type' => $leave_type,
                                                            'start_date' => $getdatetimedbformat,
                                                            'end_date' => $getdatetimedbformat,
                                                            'partial_days' => $partial_days,
                                                            'no_of_days' => null,
                                                            'reason' => $leave_reason,
                                                            'hod_status' => 'Pending',
                                                            'hod_reason' => null,
                                                            'admin_status' => 'Pending',
                                                            'admin_reason' => null,
                                                            'final_status' => 'Pending',
                                                            'created_date' => $currentdatetime,
                                                            'hod_created_date' => null,
                                                            'admin_created_date' => null,
                                                            'application_modified_count' => 0,
                                                            'category' => 'onduty',
                                                            'saved_file' => null,
                                                            'permission_verified' => null,
                                                            'compoff_worked_shift' => null,
                                                            'compoff_worked_stdate' => null,
                                                            'compoff_worked_etdate' => null,
                                                            'compoff_worked_hours' => null,
                                                            'hod_session_key' => null,
                                                            'admin_session_key' => null
                                                        ]);

                                                        $randomno1 = rand(1, 5000);
                                                        $toencrypt1 = $employeeid.'-#hod#-'.$insert_application.'-'.$randomno1.$leave_type.$currentdatetime;
                                                        $hodencrypt = Crypt::encrypt($toencrypt1);
                                                        $hod_mailarray['hod_encrypt'] = $hodencrypt;                                                                                        
                                                        $update_hodsession = DB::connection('mysql6')->table('lms_applications')->where(['employeeid' => $employeeid, 'id' => $insert_application])
                                                                                                                                                                        ->update([ "hod_session_key" => $hodencrypt ]);
                                                          

                            $update_balance = DB::connection('mysql6')->table('leave_balance')->where(['employeeid' => $employeeid, 'month' => $month, 'year'=>$year])
                                                        ->update([ "$leave_type" => $minus_bal ]);

                                                        $hod_mailarray['attachment'] = null;

                                                        Mail::to($hod_mailarray['hod_mailid'])->send(new tohodmail($hod_mailarray));
                                                        Mail::to($hod_mailarray['employee_mailid'])->send(new toemployeemailapplicationcopy($hod_mailarray));
                                                            
                                                        return true;

                                
                                
                            }
    }


    public function dotourcheckfunction($employeeid,$start_date, $end_date,$diff, $partial_days, $request)
    {
        $leave_type = 'Tour';
        
        $error = [];
        $getemployee =  DB::connection('mysql6')->table('employee')->where('id',$employeeid )->get();

       //$onlypresentfuturedatecheck =  $this->only_past_future_days_check($start_date, $end_date);
        //if($onlypresentfuturedatecheck == true){ $error[] = "Applied Date can be greater than 30 days and past 3 days from current date.";  }
       
       
       //$checkwithappliedleavesdates = $this->check_with_applied_leaves_dates($employeeid, $start_date, $end_date);
           //if($checkwithappliedleavesdates == true){ $error[] = "Applied Leave Dates found with previous Approved/Pending application dates.";  }
       
       $checkweekoffholidays = $this->checkweekoff_holidays($employeeid, $start_date, $end_date,$getemployee);
           if($checkweekoffholidays['holiday_count'] == '1'){ $error[] = "Applied Tour Dates should not start/end with Holiday date."; }
           if($checkweekoffholidays['weekoff_count'] == '1'){ $error[] = "Applied Tour Dates should not start/end with Week-off date."; }       

           return $error;
    }

    public function oldtourprocess($employeeid,$startdate, $enddate,$diff, $partial_days, $leave_reason, $request, $hod_mailarray)
    {
        $getemployee =  DB::connection('mysql6')->table('employee')->where('id',$employeeid )->get();
        
            $currentdatetime = Carbon::now()->toDateTimeString();
            
            $carbonnow = Carbon::now()->format('M');
            $currentdate = Carbon::now()->toDateString();
           $year = $this->returnyear($currentdate);
           $month = $this->returnmonth($currentdate);
           $leave_type = "Tour";
            
            $getleavecount =  DB::connection('mysql6')->table('leave_balance')->where('employeeid', $employeeid)
                                ->where(['year' => $year, 'month' => $month])
                                ->get();
                                
                                $applieddays = $this->differbtwtwodates($startdate, $enddate);
                                if(count($getleavecount) == 0){
                                    return true;
                                }else{

                                $db_balance = $getleavecount[0]->$leave_type;
                                $applieddays = $this->differbtwtwodates($startdate, $enddate);

                                $db_balance = $getleavecount[0]->$leave_type;

                                $minus_bal = $db_balance + $applieddays;


                                if ($partial_days == 'first_half') {
                                    $breif_partial_days = 'First Half';
                                }
                               elseif ($partial_days == 'second_half') {
                                    $breif_partial_days = 'Second Half';
                                }
                                else {
                                    $breif_partial_days = 'Full Day';
                                }
                                
                                if ($noofdays == '1') {
                                    $hod_mailarray['subject'] = 'LMS Application of '.$hod_mailarray['employee_name'].' - '.$employeeid.' on '.Carbon::parse($startdate)->format('d M, Y');
                                }
                                else{
                                    $hod_mailarray['subject'] = 'LMS Application of '.$hod_mailarray['employee_name'].' - '.$employeeid.' on ('.Carbon::parse($startdate)->format('d M, Y').' to '.Carbon::parse($enddate)->format('d M, Y').')';
                                }
                                $hod_mailarray['leave_type'] = 'Maternity Leave';
                                $hod_mailarray['start_date'] = Carbon::parse($startdate)->format('d M, Y');
                                $hod_mailarray['end_date'] = Carbon::parse($enddate)->format('d M, Y');
                                $hod_mailarray['no_of_days'] = $noofdays;
                                $hod_mailarray['partial_days'] = $breif_partial_days;
                                $hod_mailarray['application_reason'] = $leave_reason;
                                $hod_mailarray['request_created_datetime'] = $currentdatetime;
                                
                                $hod_mailarray['compoff_worked_shift'] = null;
                                $hod_mailarray['compoff_worked_stdate'] = null;
                                $hod_mailarray['compoff_worked_etdate'] = null;
                                $hod_mailarray['compoff_worked_hours'] = null;

                                $month = Carbon::now()->format('m');
                                $year = Carbon::now()->format('Y');
                                
                                $getdatetimedbformatst = Carbon::parse($startdate)->toDateTimeString();
                                $getdatetimedbformatet = Carbon::parse($enddate)->toDateTimeString();
                                $insert_application = DB::connection('mysql6')->table('lms_applications')
                                                        ->insertGetId([
                                                            'employeeid' => $employeeid,
                                                            'month' => $month,
                                                            'year' => $year,
                                                            'type' => $leave_type,
                                                            'start_date' => $getdatetimedbformatst,
                                                            'end_date' => $getdatetimedbformatet,
                                                            'partial_days' => $partial_days,
                                                            'no_of_days' => $applieddays,
                                                            'reason' => $leave_reason,
                                                            'hod_status' => 'Pending',
                                                            'hod_reason' => null,
                                                            'admin_status' => 'Pending',
                                                            'admin_reason' => null,
                                                            'final_status' => 'Pending',
                                                            'created_date' => $currentdatetime,
                                                            'hod_created_date' => null,
                                                            'admin_created_date' => null,
                                                            'application_modified_count' => 0,
                                                            'category' => 'tour',
                                                            'saved_file' => null,
                                                            'permission_verified' => null,
                                                            'compoff_worked_shift' => null,
                                                            'compoff_worked_stdate' => null,
                                                            'compoff_worked_etdate' => null,
                                                            'compoff_worked_hours' => null,
                                                            'hod_session_key' => null,
                                                            'admin_session_key' => null
                                                        ]);

                                                        $randomno1 = rand(1, 5000);
                                                        $toencrypt1 = $employeeid.'-#hod#-'.$insert_application.'-'.$randomno1.$leave_type.$currentdatetime;
                                                        $hodencrypt = Crypt::encrypt($toencrypt1);
                                                                                                                                                
                                                        $update_hodsession = DB::connection('mysql6')->table('lms_applications')->where(['employeeid' => $employeeid, 'id' => $insert_application])
                                                                                                                                                                        ->update([ "hod_session_key" => $hodencrypt ]);
                                                        

                            $update_balance = DB::connection('mysql6')->table('leave_balance')->where(['employeeid' => $employeeid, 'month' => $month, 'year'=>$year])
                                                        ->update([ "$leave_type" => $minus_bal ]);
                                                        $hod_mailarray['hod_encrypt'] = $hodencrypt;
                                                        $hod_mailarray['attachment'] = null;

                                                        Mail::to($hod_mailarray['hod_mailid'])->send(new tohodmail($hod_mailarray));
                                                        Mail::to($hod_mailarray['employee_mailid'])->send(new toemployeemailapplicationcopy($hod_mailarray));
                                                            
                                                        return true;

                                
                                
                            }
    }

    public function docompoffcheckfunction($employeeid, $partial_days, $request)
    {
        $error = [];
        $getemployee =  DB::connection('mysql6')->table('employee')->where('id',$employeeid )->get();
        
        $getdatedbformat = $this->dateformatreturnddmmyytoyymmdd($request->leave_requireddate);
        $getcompoffdbformat = $this->dateformatreturnddmmyytoyymmdd($request->leave_date_range);
        
        $start_date = $getdatedbformat;
        $end_date = $getdatedbformat;

        $checkwithappliedcompoffdates = $this->check_with_applied_compoff_dates($employeeid, $getcompoffdbformat);
           if($checkwithappliedcompoffdates == true){ $error[] = "Applied Compoff date already used.";  }

        //$onlypresentpast3_date_check =  $this->only_present_past3_date_check($start_date);
        
        //if($onlypresentpast3_date_check == true){ $error[] = "Application should be current date or lesser than 3 days from current date.";  }
       $onlyforcurrentmonthcheck = $this->only_for_current_month_check($start_date, $end_date);
           if($onlyforcurrentmonthcheck == false){ $error[] = "Application can be accepted only for current month.";  }
       
       $checkwithappliedleavesdates = $this->check_with_applied_leaves_dates($employeeid, $start_date, $end_date);
           if($checkwithappliedleavesdates == true){ $error[] = "Applied Leave Date found with previous Approved/Pending application dates.";  }
       
       $checkweekoffholidays = $this->checkweekoff_holidays($employeeid, $start_date, $end_date,$getemployee);
           if($checkweekoffholidays['holiday_count'] == '1'){ $error[] = "Applied Compoff Date found with Holiday date."; }
           if($checkweekoffholidays['weekoff_count'] == '1'){ $error[] = "Applied Compoff Date found with Week-off date."; }

        return $error;
    }

    public function oldcompoffprocess($employeeid, $partial_days, $leave_reason, $request, $hod_mailarray)
    {
        $getemployee =  DB::connection('mysql6')->table('employee')->where('id',$employeeid )->get();
        
            $currentdatetime = Carbon::now()->toDateTimeString();
            
            $carbonnow = Carbon::now()->format('M');
            $currentdate = Carbon::now()->toDateString();
           $year = $this->returnyear($currentdate);
           $month = $this->returnmonth($currentdate);
           $leave_type = "Compoff";

           $getdatedbformat = $this->dateformatreturnddmmyytoyymmdd($request->leave_requireddate);
        
        $startdate = $getdatedbformat;
        $enddate = $getdatedbformat;

        if ($partial_days == 'full') {
            $applieddays = '1';
        }else{
            $applieddays = '0.5';
        }
               
        $getleavecount =  DB::connection('mysql6')->table('leave_balance')->where('employeeid', $employeeid)
                                ->where(['year' => $year, 'month' => $month])
                                ->get();
                                $db_balance = $getleavecount[0]->$leave_type;

                                $minus_bal = $db_balance + $applieddays;
            $compoffworkedhours = Carbon::parse($request->startpunch)->diff(Carbon::parse($request->endpunch))->format('%H:%i:%s');
        $noofdays = 1;

            if ($partial_days == 'first_half') {
                $breif_partial_days = 'First Half';
            }
           elseif ($partial_days == 'second_half') {
                $breif_partial_days = 'Second Half';
            }
            else {
                $breif_partial_days = 'Full Day';
            }
            
            if ($noofdays == '1') {
                $hod_mailarray['subject'] = 'LMS Application of '.$hod_mailarray['employee_name'].' - '.$employeeid.' on '.Carbon::parse($startdate)->format('d M, Y');
            }
            else{
                $hod_mailarray['subject'] = 'LMS Application of '.$hod_mailarray['employee_name'].' - '.$employeeid.' on ('.Carbon::parse($startdate)->format('d M, Y').' to '.Carbon::parse($enddate)->format('d M, Y').')';
            }
            $hod_mailarray['leave_type'] = 'Compensatory Off';
            $hod_mailarray['start_date'] = Carbon::parse($startdate)->format('d M, Y');
            $hod_mailarray['end_date'] = Carbon::parse($enddate)->format('d M, Y');
            $hod_mailarray['no_of_days'] = $noofdays;
            $hod_mailarray['partial_days'] = $breif_partial_days;
            $hod_mailarray['application_reason'] = $leave_reason;
            $hod_mailarray['request_created_datetime'] = $currentdatetime;
            
            $hod_mailarray['compoff_worked_shift'] = $request->shiftworked;
            $hod_mailarray['compoff_worked_stdate'] = $request->startpunch;
            $hod_mailarray['compoff_worked_etdate'] = $request->endpunch;
            $hod_mailarray['compoff_worked_hours'] = $compoffworkedhours;

            $month = Carbon::now()->format('m');
            $year = Carbon::now()->format('Y');
            
                                
                                $getdatetimedbformatst = Carbon::parse($startdate)->toDateTimeString();
                                $getdatetimedbformatet = Carbon::parse($enddate)->toDateTimeString();
                                $insert_application = DB::connection('mysql6')->table('lms_applications')
                                                        ->insert([
                                                            'employeeid' => $employeeid,
                                                            'month' => $month,
                                                            'year' => $year,
                                                            'type' => $leave_type,
                                                            'start_date' => $getdatetimedbformatst,
                                                            'end_date' => $getdatetimedbformatet,
                                                            'partial_days' => $partial_days,
                                                            'no_of_days' => $applieddays,
                                                            'reason' => $leave_reason,
                                                            'hod_status' => 'Pending',
                                                            'hod_reason' => null,
                                                            'admin_status' => 'Pending',
                                                            'admin_reason' => null,
                                                            'final_status' => 'Pending',
                                                            'created_date' => $currentdatetime,
                                                            'hod_created_date' => null,
                                                            'admin_created_date' => null,
                                                            'application_modified_count' => 0,
                                                            'category' => 'compoff',
                                                            'saved_file' => null,
                                                            'permission_verified' => null,
                                                            'compoff_worked_shift' => $request->shiftworked,
                                                            'compoff_worked_stdate' => $request->startpunch,
                                                            'compoff_worked_etdate' => $request->endpunch,
                                                            'compoff_worked_hours' => $compoffworkedhours,
                                                            'hod_session_key' => null,
                                                            'admin_session_key' => null
                                                        ]);

                                                        $randomno1 = rand(1, 5000);
                                                        $toencrypt1 = $employeeid.'-#hod#-'.$insert_application.'-'.$randomno1.$leave_type.$currentdatetime;
                                                        $hodencrypt = Crypt::encrypt($toencrypt1);
                                                        $hod_mailarray['hod_encrypt'] = $hodencrypt;                                                                                     
                                                        $update_hodsession = DB::connection('mysql6')->table('lms_applications')->where(['employeeid' => $employeeid, 'id' => $insert_application])->update([ "hod_session_key" => $hodencrypt ]);
                                                                            

                            $update_balance = DB::connection('mysql6')->table('leave_balance')->where(['employeeid' => $employeeid, 'month' => $month, 'year'=>$year])
                                                        ->update([ "$leave_type" => $minus_bal ]);
                                                            
                                                        $hod_mailarray['attachment'] = null;

                                                        Mail::to($hod_mailarray['hod_mailid'])->send(new tohodmail($hod_mailarray));
                                                        Mail::to($hod_mailarray['employee_mailid'])->send(new toemployeemailapplicationcopy($hod_mailarray));
                                                        return true;

                                
                                
                            
    }


    public function domispunchcheckfunction($employeeid, $partial_days, $request)
    {
        $error = [];
        $getemployee =  DB::connection('mysql6')->table('employee')->where('id',$employeeid )->get();
        
        $getdatedbformat = $this->dateformatreturnddmmyytoyymmdd($request->mispunch_date);
        
        
        $start_date = $getdatedbformat;
        $end_date = $getdatedbformat;

        $checkwithappliedmispunchdates = $this->check_with_applied_mispunch_dates($employeeid, $getdatedbformat);
           if($checkwithappliedmispunchdates == true){ $error[] = "Applied Mispunch date already used.";  }

        //$onlypresentpast3_date_check =  $this->only_present_past3_date_check($start_date);
        
        //if($onlypresentpast3_date_check == true){ $error[] = "Application should be current date or lesser than 3 days from current date.";  }
       $onlyforcurrentmonthcheck = $this->only_for_current_month_check($start_date, $end_date);
           if($onlyforcurrentmonthcheck == false){ $error[] = "Application can be accepted only for current month.";  }
       
      // $checkwithappliedleavesdates = $this->check_with_applied_leaves_dates($employeeid, $start_date, $end_date);
        //   if($checkwithappliedleavesdates == true){ $error[] = "Applied Leave Date found with previous Approved/Pending application dates.";  }
       
       $checkweekoffholidays = $this->checkweekoff_holidays($employeeid, $start_date, $end_date,$getemployee);
           if($checkweekoffholidays['holiday_count'] == '1'){ $error[] = "Applied Mispunch Date found with Holiday date."; }
           if($checkweekoffholidays['weekoff_count'] == '1'){ $error[] = "Applied Mispunch Date found with Week-off date."; }


           if ($request->hasFile('fileupload')) {
            $checkthefile = $this->checkthefile($employeeid, $start_date, $end_date,$request,'fileupload');
            if(!empty($error)){
                foreach ($checkthefile as $key => $value) {
                    $error[] = $value;
                }
            }
       }

        return $error;
    }

    public function dolopcheckfunction($employeeid, $partial_days, $request)
    {
        $error = [];
        $getemployee =  DB::connection('mysql6')->table('employee')->where('id',$employeeid )->get();

        $splitrange = explode('-',$request->leave_date_range);

        $start_date = $this->dateformatreturnddmmyytoyymmdd(trim($splitrange[0]));
        $end_date = $this->dateformatreturnddmmyytoyymmdd(trim($splitrange[1]));
        
        //$getdatedbformat = $this->dateformatreturnddmmyytoyymmdd($request->mispunch_date);
        
        
        //$start_date = $getdatedbformat;
        //$end_date = $getdatedbformat;

        //$checkwithappliedmispunchdates = $this->check_with_applied_mispunch_dates($employeeid, $getdatedbformat);
          // if($checkwithappliedmispunchdates == true){ $error[] = "Applied Mispunch date already used.";  }

        //$onlypresentpast3_date_check =  $this->only_present_past3_date_check($start_date);
        
        //if($onlypresentpast3_date_check == true){ $error[] = "Application should be current date or lesser than 3 days from current date.";  }
       //$onlyforcurrentmonthcheck = $this->only_for_current_month_check($start_date, $end_date);
          // if($onlyforcurrentmonthcheck == false){ $error[] = "Application can be accepted only for current month.";  }
       
      // $checkwithappliedleavesdates = $this->check_with_applied_leaves_dates($employeeid, $start_date, $end_date);
        //   if($checkwithappliedleavesdates == true){ $error[] = "Applied Leave Date found with previous Approved/Pending application dates.";  }
       
         $checkweekoffholidays = $this->checkweekoff_holidays($employeeid, $start_date, $end_date,$getemployee);
           if($checkweekoffholidays['holiday_count'] == '1'){ $error[] = "Applied LOP Date found with Holiday date."; }
           if($checkweekoffholidays['weekoff_count'] == '1'){ $error[] = "Applied LOP Date found with Week-off date."; }

        return $error;
    }

    public function oldlopprocess($employeeid, $partial_days, $leave_reason, $request, $hod_mailarray)
    {
        $getemployee =  DB::connection('mysql6')->table('employee')->where('id',$employeeid )->get();
        
            $currentdatetime = Carbon::now()->toDateTimeString();
            
            $carbonnow = Carbon::now()->format('M');
            $currentdate = Carbon::now()->toDateString();
           $year = $this->returnyear($currentdate);
           $month = $this->returnmonth($currentdate);
           $leave_type = "LOP";

           $splitrange = explode('-',$request->leave_date_range);

           $startdate = $this->dateformatreturnddmmyytoyymmdd(trim($splitrange[0]));
           $enddate = $this->dateformatreturnddmmyytoyymmdd(trim($splitrange[1]));
        
            $applieddays = '1';



        
               
        $getleavecount =  DB::connection('mysql6')->table('leave_balance')->where('employeeid', $employeeid)
                                ->where(['year' => $year, 'month' => $month])
                                ->get();
                                $db_balance = $getleavecount[0]->$leave_type;

                                $minus_bal = $db_balance + $applieddays;
                                $getdatetimedbformatst = Carbon::parse($startdate)->toDateTimeString();
                                $getdatetimedbformatet = Carbon::parse($enddate)->toDateTimeString();


                                $noofdays = 1;

                                if ($partial_days == 'first_half') {
                                    $breif_partial_days = 'First Half';
                                    $noofdays = 0.5;
                                }
                               elseif ($partial_days == 'second_half') {
                                    $breif_partial_days = 'Second Half';
                                    $noofdays = 0.5;
                                }
                                else {
                                    $breif_partial_days = 'Full Day';
                                }
                                
                                if ($noofdays == '1') {
                                    $hod_mailarray['subject'] = 'LMS Application of '.$hod_mailarray['employee_name'].' - '.$employeeid.' on '.Carbon::parse($startdate)->format('d M, Y');
                                }
                                else{
                                    $hod_mailarray['subject'] = 'LMS Application of '.$hod_mailarray['employee_name'].' - '.$employeeid.' on ('.Carbon::parse($startdate)->format('d M, Y').' to '.Carbon::parse($enddate)->format('d M, Y').')';
                                }
                                $hod_mailarray['leave_type'] = 'LOP';
                                $hod_mailarray['start_date'] = Carbon::parse($startdate)->format('d M, Y');
                                $hod_mailarray['end_date'] = Carbon::parse($enddate)->format('d M, Y');
                                $hod_mailarray['no_of_days'] = $noofdays;
                                $hod_mailarray['partial_days'] = $breif_partial_days;
                                $hod_mailarray['application_reason'] = $leave_reason;
                                $hod_mailarray['request_created_datetime'] = $currentdatetime;
                                
                                $hod_mailarray['compoff_worked_shift'] = null;
                                $hod_mailarray['compoff_worked_stdate'] = null;
                                $hod_mailarray['compoff_worked_etdate'] = null;
                                $hod_mailarray['compoff_worked_hours'] = null;
                                
                                $month = Carbon::now()->format('m');
                                $year = Carbon::now()->format('Y');
           
                                
                                $getid = DB::connection('mysql6')->table('lms_applications')
                                                        ->insertGetId([
                                                            'employeeid' => $employeeid,
                                                            'month' => $month,
                                                            'year' => $year,
                                                            'type' => $leave_type,
                                                            'start_date' => Carbon::parse($startdate)->toDateTimeString(),
                                                            'end_date' => Carbon::parse($enddate)->toDateTimeString(),
                                                            'partial_days' => $partial_days,
                                                            'no_of_days' => null,
                                                            'reason' => $leave_reason,
                                                            'hod_status' => 'Pending',
                                                            'hod_reason' => null,
                                                            'admin_status' => 'Pending',
                                                            'admin_reason' => null,
                                                            'final_status' => 'Pending',
                                                            'created_date' => $currentdatetime,
                                                            'hod_created_date' => null,
                                                            'admin_created_date' => null,
                                                            'application_modified_count' => 0,
                                                            'category' => 'mispunch',
                                                            'saved_file' => null,
                                                            'permission_verified' => null,
                                                            'compoff_worked_shift' => null,
                                                            'compoff_worked_stdate' => null,
                                                            'compoff_worked_etdate' => null,
                                                            'compoff_worked_hours' => null,
                                                            'hod_session_key' => null,
                                                            'admin_session_key' => null
                                                        ]);

                                                        $randomno1 = rand(1, 5000);
                                                        $toencrypt1 = $employeeid.'-#hod#-'.$getid.'-'.$randomno1.$leave_type.$currentdatetime;
                                                        $hodencrypt = Crypt::encrypt($toencrypt1);
                                                        $hod_mailarray['hod_encrypt'] = $hodencrypt;                                                                                       
                                                        $update_hodsession = DB::connection('mysql6')->table('lms_applications')->where(['employeeid' => $employeeid, 'id' => $getid])->update([ "hod_session_key" => $hodencrypt ]);
                                                                      

                            $update_balance = DB::connection('mysql6')->table('leave_balance')->where(['employeeid' => $employeeid, 'month' => $month, 'year'=>$year])
                                                        ->update([ "$leave_type" => $minus_bal ]);
                                                            
                                                        $hod_mailarray['attachment'] = null;

                                                        Mail::to($hod_mailarray['hod_mailid'])->send(new tohodmail($hod_mailarray));
                                                        Mail::to($hod_mailarray['employee_mailid'])->send(new toemployeemailapplicationcopy($hod_mailarray));
                                                        
                                                        return true;
                                                    
    }

    public function oldmispunchprocess($employeeid, $partial_days, $leave_reason, $request, $hod_mailarray)
    {
        $getemployee =  DB::connection('mysql6')->table('employee')->where('id',$employeeid )->get();
        
            $currentdatetime = Carbon::now()->toDateTimeString();
            
            $carbonnow = Carbon::now()->format('M');
            $currentdate = Carbon::now()->toDateString();
           $year = $this->returnyear($currentdate);
           $month = $this->returnmonth($currentdate);
           $leave_type = "Mispunch";

           $getdatedbformat = $this->dateformatreturnddmmyytoyymmdd($request->mispunch_date);
        
        $startdate = $getdatedbformat;
        $enddate = $getdatedbformat;

        
            $applieddays = '1';
        
               
        $getleavecount =  DB::connection('mysql6')->table('leave_balance')->where('employeeid', $employeeid)
                                ->where(['year' => $year, 'month' => $month])
                                ->get();
                                $db_balance = $getleavecount[0]->$leave_type;

                                $minus_bal = $db_balance + $applieddays;
                                $getdatetimedbformatst = Carbon::parse($startdate)->toDateTimeString();
                                $getdatetimedbformatet = Carbon::parse($enddate)->toDateTimeString();


                                $noofdays = 1;

                                if ($partial_days == 'first_half') {
                                    $breif_partial_days = 'First Half';
                                }
                               elseif ($partial_days == 'second_half') {
                                    $breif_partial_days = 'Second Half';
                                }
                                else {
                                    $breif_partial_days = 'Full Day';
                                }
                                
                                if ($noofdays == '1') {
                                    $hod_mailarray['subject'] = 'LMS Application of '.$hod_mailarray['employee_name'].' - '.$employeeid.' on '.Carbon::parse($startdate)->format('d M, Y');
                                }
                                else{
                                    $hod_mailarray['subject'] = 'LMS Application of '.$hod_mailarray['employee_name'].' - '.$employeeid.' on ('.Carbon::parse($startdate)->format('d M, Y').' to '.Carbon::parse($enddate)->format('d M, Y').')';
                                }
                                $hod_mailarray['leave_type'] = 'Mispunch';
                                $hod_mailarray['start_date'] = Carbon::parse($getdatetimedbformatst)->format('d M, Y');
                                $hod_mailarray['end_date'] = Carbon::parse($getdatetimedbformatet)->format('d M, Y');
                                $hod_mailarray['no_of_days'] = null;
                                $hod_mailarray['partial_days'] = $breif_partial_days;
                                $hod_mailarray['application_reason'] = $leave_reason;
                                $hod_mailarray['request_created_datetime'] = $currentdatetime;
                                
                                $hod_mailarray['compoff_worked_shift'] = null;
                                $hod_mailarray['compoff_worked_stdate'] = null;
                                $hod_mailarray['compoff_worked_etdate'] = null;
                                $hod_mailarray['compoff_worked_hours'] = null;
                                
                                $month = Carbon::now()->format('m');
                                $year = Carbon::now()->format('Y');
           
                                
                                $getid = DB::connection('mysql6')->table('lms_applications')
                                                        ->insertGetId([
                                                            'employeeid' => $employeeid,
                                                            'month' => $month,
                                                            'year' => $year,
                                                            'type' => $leave_type,
                                                            'start_date' => $getdatetimedbformatst,
                                                            'end_date' => $getdatetimedbformatet,
                                                            'partial_days' => $partial_days,
                                                            'no_of_days' => null,
                                                            'reason' => $leave_reason,
                                                            'hod_status' => 'Pending',
                                                            'hod_reason' => null,
                                                            'admin_status' => 'Pending',
                                                            'admin_reason' => null,
                                                            'final_status' => 'Pending',
                                                            'created_date' => $currentdatetime,
                                                            'hod_created_date' => null,
                                                            'admin_created_date' => null,
                                                            'application_modified_count' => 0,
                                                            'category' => 'mispunch',
                                                            'saved_file' => null,
                                                            'permission_verified' => null,
                                                            'compoff_worked_shift' => null,
                                                            'compoff_worked_stdate' => null,
                                                            'compoff_worked_etdate' => null,
                                                            'compoff_worked_hours' => null,
                                                            'hod_session_key' => null,
                                                            'admin_session_key' => null
                                                        ]);

                                                        $randomno1 = rand(1, 5000);
                                                        $toencrypt1 = $employeeid.'-#hod#-'.$getid.'-'.$randomno1.$leave_type.$currentdatetime;
                                                        $hodencrypt = Crypt::encrypt($toencrypt1);
                                                        $hod_mailarray['hod_encrypt'] = $hodencrypt;                                                                                       
                                                        $update_hodsession = DB::connection('mysql6')->table('lms_applications')->where(['employeeid' => $employeeid, 'id' => $getid])->update([ "hod_session_key" => $hodencrypt ]);
                                                                      

                            $update_balance = DB::connection('mysql6')->table('leave_balance')->where(['employeeid' => $employeeid, 'month' => $month, 'year'=>$year])
                                                        ->update([ "$leave_type" => $minus_bal ]);
                                                            
                                                        if($request->hasFile('fileupload')){

                                                            $path = public_path()."/newcustomerzoneassets/mispunchuploads";
                                                            $ext = strtolower($request->file('fileupload')->getClientOriginalExtension());
                                                                                            
                                                            $newname = $getid.'_fileupload';
                                                            
                                                            $npath = $request->file('fileupload')->store(
                                                                $newname, 'mispunch_uploads'
                                                            );
                            
                                                            DB::connection('mysql6')->table('lms_applications')->where('id', $getid)
                                                                                ->update([
                                                                                    'saved_file' => $npath]);

                                                                                    $hod_mailarray['attachment'] = $npath;

                                                        Mail::to($hod_mailarray['hod_mailid'])->send(new tohodmail($hod_mailarray));
                                                        Mail::to($hod_mailarray['employee_mailid'])->send(new toemployeemailapplicationcopy($hod_mailarray));

                            
                                                                                    return true;
                                                    }else{
                                                        $hod_mailarray['attachment'] = null;

                                                        Mail::to($hod_mailarray['hod_mailid'])->send(new tohodmail($hod_mailarray));
                                                        Mail::to($hod_mailarray['employee_mailid'])->send(new toemployeemailapplicationcopy($hod_mailarray));
                                                        
                                                        return true;
                                                    }
    }
        
}
