<?php
namespace vgn\Http\Traits\LMS;

use Carbon\Carbon;
use DB;
use vgn\Http\Traits\employeetrait;


trait common_logictrait{

    use employeetrait;
    /**
     * Input needed 
     * start date
     * end date
     * partial days
     * reason
     */
    
     public function getinputparams($employeeid, $start_date, $end_date, $partial_days, $leave_type)
     {
         $error = [];
         $getemployee =  DB::connection('mysql6')->table('employee')->where('id',$employeeid )->get();


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

         return $error;
         
     }

     public function returnmonth($string)
    {
        return substr($string,5,2);
    }

    public function formatforempdat_returnmonth($string)
    {
        return substr($string,3,2);
    }

    public function returnyear($string)
    {
        return substr($string,0,4);
    }
    public function formatforempdat_returnyear($string)
    {
        return substr($string,6,4);
    }

    public function differbtwtwodates($date1, $date2)
    {
        
        // From a date string
        $fdate1 = new Carbon($date1);
        $fdate2 = new Carbon($date2);
        $diff = $fdate2->diffInDays($fdate1);
        return $diff+1;
    }

    public function formatforempdat_differbtwtwodates($date1, $date2)
    {
         // From a date string
         $fdate1 = new Carbon($date1);
         $fdate2 = new Carbon($date2);
         $diff = $fdate2->diffInDays($fdate1);
         return $diff+1;
    }


     
      /**
       * ------------------check------------------------------------------
       * 1. check the applied leave classhes with any other applied leaves - DONE
       * 2. check the applied leave classhed with week off and holiday permitted - DONE
       * 3. check the applied leave count matches or less than available leave balance - DONE
       * 4. past leave dates application can be accepted for previous 5 days from current dates, check the leave start and end date meets between current month - DONE
       */

       public function cldontallow_previousdate($employeeid, $start_date, $end_date,$getemployee)
       {
           $currentdate = Carbon::now()->toDateString();
           $format_currentdate = Carbon::parse($currentdate);
           $startdate = Carbon::parse($start_date);
            
           $checklessthancurrentdate = $startdate->gte($format_currentdate);
           return $checklessthancurrentdate;
       }

       public function checkstartandenddate_nextdates($employeeid, $start_date, $end_date,$getemployee)
       {
        $startdate = Carbon::parse($start_date)->addDay()->toDateString();
        $enddate = Carbon::parse($end_date)->addDay()->toDateString();
        $startdatecheck =  DB::connection('mysql6')->table('lms_applications')->where(['employeeid' => $employeeid, 'start_date' =>$startdate  ])->whereIn('final_status', ['Approved','Pending'])->count();
        $enddatecheck =  DB::connection('mysql6')->table('lms_applications')->where(['employeeid' => $employeeid, 'end_date' =>$enddate  ])->whereIn('final_status', ['Approved','Pending'])->count();

        if(($startdatecheck > 0) || ($enddatecheck > 0)){
            return true;
        }else{
            return false;
        }
                
       }

       public function check_with_applied_leaves($employeeid, $startdate, $enddate )
       {
               
        $startdatecheck =  DB::connection('mysql6')->table('lms_applications')->where(['employeeid' => $employeeid])->whereRaw('"'.$startdate.'" between `start_date` and `end_date`')->whereIn('final_status', ['Approved','Pending'])->get();
        $enddatecheck =  DB::connection('mysql6')->table('lms_applications')->where(['employeeid' => $employeeid])->whereRaw('"'.$enddate.'" between `start_date` and `end_date`')->whereIn('final_status', ['Approved','Pending'])->get();
        $betweencheck =  DB::connection('mysql6')->table('lms_applications')->where(['employeeid' => $employeeid])->whereRaw('`start_date` >= "'.$startdate.'" and `end_date` <= "'.$enddate.'"')->whereIn('final_status', ['Approved','Pending'])->get();
        
        if((count($startdatecheck) == 0) && (count($enddatecheck) == 0) && (count($betweencheck) == 0) ){
            return false;
        }else{
            return true;
        }

       }

       public function checkweekoff_holiday($employeeid, $start_date, $end_date, $getemployee)
       {
           /**
            * for holiday
            */
           $getyearfromstartdate = substr($start_date, 0, 4);
           $getyearfromenddate = substr($end_date, 0, 4);
           $holiday_count = 0;
           if($getyearfromstartdate == $getyearfromenddate)
           {
                $year = $getyearfromenddate; 
                $getholiday = $this->holiday($employeeid, $year);

                foreach ($getholiday['CALENDAR'] as $key => $value) {
                    $sap_holiday_date = substr($value['Date'], 0,4).'-'.substr($value['Date'], 4,2).'-'.substr($value['Date'], 6,2);
                    if(($sap_holiday_date == $start_date) || ($sap_holiday_date == $end_date)){
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
                }

                foreach ($getholiday_startdate['CALENDAR'] as $key1 => $value1) {
                    $sap_holiday_date1 = substr($value1['Date'], 0,4).'-'.substr($value1['Date'], 4,2).'-'.substr($value1['Date'], 6,2);
                    if(($sap_holiday_date1 == $start_date) || ($sap_holiday_date1 == $end_date)){
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
                   
                   if(strpos($empvalue->role_code, 'SAL_TM') !== false){
                        if(($carbon_start_date->isTuesday() == true) || ($carbon_end_date->isTuesday() == true)){
                            $weekoff_count = 1;
                        }else{
                            $weekoff_count = 0;
                        }   
                   }else{
                    if(($carbon_start_date->isSunday() == true) || ($carbon_end_date->isSunday() == true)){
                        $weekoff_count = 1;
                    }else{
                        $weekoff_count = 0;
                    }  
                   }
               }

              $result = [];
              $result['holiday_count'] = $holiday_count;
              $result['weekoff_count'] = $weekoff_count;

                return $result;

       }

       public function checkleavecount_matches_lessthanapplied($employeeid, $start_date, $end_date, $leave_type, $partial_days)
       {
           $year = $this->returnyear($start_date);
           $month = $this->returnmonth($start_date);
            
            $getleavecount =  DB::connection('mysql6')->table('leave_balance')->where('employeeid', $employeeid)
                                ->where(['year' => $year, 'month' => $month])
                                ->get();
                                
                                $applieddays = $this->differbtwtwodates($start_date, $end_date);
                                if(count($getleavecount) == 0){
                                    return true;
                                }else{
                                $db_balance = $getleavecount[0]->$leave_type;

                                if($partial_days == 'full') {
                                    $minus_bal = $db_balance - $applieddays;
                                }else {
                                    $minus_bal = $db_balance - 0.5;
                                }

                                
                                if($minus_bal < 0){
                                    return false;
                                }
                                else{
                                    return true;
                                }
                            }

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

       
       /**
        * ------------processing----------------------------------------------
        * 1. check the applied count DONE
        * 2. Save the application in DB DONE
        * 2. Detect the applied leave from balance and mark the status as pending DONE
        * 3. Send application to HOD and Admin
        * 4. Trigger mail to HOD and Admin and employee
        */

        public function process($employeeid, $startdate, $enddate, $partial_days, $leave_type, $leave_reason)
        {
            $getemployee =  DB::connection('mysql6')->table('employee')->where('id',$employeeid )->get();
            
           $do_process1 = $this->process1($employeeid, $startdate, $enddate, $partial_days, $leave_type, $getemployee, $leave_reason);
           return $do_process1;

        }

        public function process1($employeeid, $startdate, $enddate, $partial_days, $leave_type, $getemployee, $leave_reason)
        {
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
                                }else {
                                    $minus_bal = $db_balance - 0.5;
                                }
                                
                                
                                $insert_application = DB::connection('mysql6')->table('lms_applications')
                                                        ->insert([
                                                            'employeeid' => $employeeid,
                                                            'type' => $leave_type,
                                                            'start_date' => $startdate,
                                                            'end_date' => $enddate,
                                                            'partial_days' => $partial_days,
                                                            'reason' => $leave_reason,
                                                            'hod_status' => 'Pending',
                                                            'admin_status' => 'Pending',
                                                            'final_status' => 'Pending',
                                                            'created_date' => $currentdatetime,
                                                            'hod_created_date' => null,
                                                            'admin_created_date' => null,
                                                            'application_modified_count' => 0,
                                                            'category' => 'leave'
                                                        ]);

                            $update_balance = DB::connection('mysql6')->table('leave_balance')->where(['employeeid' => $employeeid, 'month' => $month, 'year'=>$year])
                                                        ->update([ "$leave_type" => $minus_bal ]);
                                                            
                                                        return true;

                                
                                
                            }
        }






}