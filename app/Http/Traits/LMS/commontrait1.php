<?php
namespace vgn\Http\Traits\LMS;

use Carbon\Carbon;
use DB;
use File;




trait commontrait1{

    /**
     * Input needed 
     * start date
     * end date
     * partial days
     * reason
     */

     /**
      * this function can be applied for CL
      */
   

    /**
      * this function can be applied for CL, SL
      */
    public function only_for_current_month_check($start_date, $end_date)
    {
        $currentdateformatstring = Carbon::now()->toDateString();
        $presentdate = Carbon::parse($currentdateformatstring);
        $startofcurrentmonth = $presentdate->startOfMonth()->toDateString();
        $endofcurrentmonth = $presentdate->endOfMonth()->toDateString();

        $applicationstartdate = Carbon::parse($start_date);
        $startofapplicationstartmonth = $applicationstartdate->startOfMonth()->toDateString();
        $endofapplicationstartmonth = $applicationstartdate->endOfMonth()->toDateString();
        
        $applicationenddate = Carbon::parse($end_date);
        $startofapplicationendmonth = $applicationenddate->startOfMonth()->toDateString();
        $endofapplicationendmonth = $applicationenddate->endOfMonth()->toDateString();

        if (($startofcurrentmonth == $startofapplicationstartmonth) && ($startofcurrentmonth == $startofapplicationendmonth) && ($endofcurrentmonth == $endofapplicationstartmonth) && ($endofcurrentmonth == $endofapplicationendmonth)) {
            return true;
        }else{
            return false;
        }

    }

     /**
      * this function can be applied for CL
      */
    public function checkprevnextdates_meetwithanotherapplications($employeeid, $start_date, $end_date, $leave_type)
    {
     $startdate = Carbon::parse($start_date)->addDay()->toDateTimeString();
     $substartdate = Carbon::parse($start_date)->subDay()->toDateTimeString();
     $enddate = Carbon::parse($end_date)->addDay()->toDateTimeString();
     $subenddate = Carbon::parse($end_date)->subDay()->toDateTimeString();
     
          
     if($leave_type == 'CL') { $typenotallowed = ['SL', 'PL', 'RH', 'ML']; }
     if($leave_type == 'SL') { $typenotallowed = ['CL', 'PL', 'RH', 'ML']; }
     if($leave_type == 'PL') { $typenotallowed = ['SL', 'CL', 'RH', 'ML']; }
     if($leave_type == 'RH') { $typenotallowed = ['SL', 'PL', 'CL', 'ML']; }
     if($leave_type == 'ML') { $typenotallowed = ['SL', 'PL', 'CL', 'RH']; }
     

     $startdatecheck =  DB::connection('mysql6')->table('lms_applications')->where(['employeeid' => $employeeid, 'start_date' =>$startdate  ])->whereIn('type', $typenotallowed)->whereIn('final_status', ['Approved','Pending'])->count();
     $enddatecheck =  DB::connection('mysql6')->table('lms_applications')->where(['employeeid' => $employeeid, 'end_date' =>$enddate  ])->whereIn('type', $typenotallowed)->whereIn('final_status', ['Approved','Pending'])->count();

     $substartdatecheck =  DB::connection('mysql6')->table('lms_applications')->where(['employeeid' => $employeeid, 'start_date' => $substartdate  ])->whereIn('type', $typenotallowed)->whereIn('final_status', ['Approved','Pending'])->count();
     $subenddatecheck =  DB::connection('mysql6')->table('lms_applications')->where(['employeeid' => $employeeid, 'end_date' =>$subenddate  ])->whereIn('type', $typenotallowed)->whereIn('final_status', ['Approved','Pending'])->count();
     
     if(($startdatecheck > 0) || ($enddatecheck > 0)){
         return true;
     }else{
         if (($substartdatecheck > 0) || ($subenddatecheck > 0)) {
            return true;
         }
         return false;
     }
             
    }

     /**
      * this function can be applied for CL
      */
    public function check_with_applied_leaves_dates($employeeid, $startdate, $enddate )
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

     /**
      * this function can be applied for CL
      */
    public function checkleavecount_matches_or_lessthanapplied($employeeid, $start_date, $end_date, $leave_type, $partial_days)
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


    public function checkpermission_matches_or_lessthanapplied($employeeid, $start_date, $end_date, $leave_type, $partial_days)
    {
        $year = $this->returnyear($start_date);
        $month = $this->returnmonth($start_date);
         
         $getleavecount =  DB::connection('mysql6')->table('leave_balance')->where(['employeeid'=> $employeeid])
                             ->where(['year' => $year, 'month' => $month])
                             ->get();
                             
                             $applieddays = $this->differbtwtwodates($start_date, $end_date);
                             if(count($getleavecount) == 0){
                                 return true;
                             }else{
                             $db_balance = $getleavecount[0]->$leave_type;

                             $minus_bal = $db_balance - $applieddays;

                             
                             if($minus_bal < 0){
                                 return false;
                             }
                             else{
                                 return true;
                             }
                         }

    }

     /**
      * this function can be applied for CL
      */
    public function checkweekoff_holidays($employeeid, $start_date, $end_date, $getemployee) 
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


    public function checkthefile($employeeid, $start_date, $end_date,$request, $filename)
    {
        $file = $request->file($filename);
        $filesize = round($file->getClientSize() / 1024);
        $ext = strtolower($file->getClientOriginalExtension());
        $error = [];
        $filearray = ["jpg","jpeg","png","pdf","doc","docx"];
        
        if (($filesize > 5000) || ($filesize < 50)) {
            $error[] = 'Minimum filesize can be 50kb to 5MB.';
        }

        if (!in_array($ext, $filearray))
        {
            $error[] ="Allowed file formats are jpg, jpeg, png, pdf, doc, docx";
        }

        return $error;


    }


    public function only_for_current_and_addweeks($start_date, $end_date)
    {       
        $applicationstartdate = Carbon::parse($start_date);
        $applicationenddate = Carbon::parse($end_date);
        
        $diffindays = $applicationstartdate->diffInDays($applicationenddate);
        
        if (($diffindays > 182) || ($diffindays < 7)) {
            return true;
        }
        
        return false;
        
        
    }

    public function getdatetimedbformat($request)
    {
        $date = array();
        $getpermissionrange = explode('-', $request);
        
        $meridiangetstart1 = substr(trim($getpermissionrange[0]), 17,2);
        $meridiangetstart2 = substr(trim($getpermissionrange[1]), 17,2);

        if ($meridiangetstart1 == 'PM') {
            $starthour1 = substr(trim($getpermissionrange[0]),11,2) + 12;
            $startminute1 = substr(trim($getpermissionrange[0]),14,2);
            $dateformat1 = substr(trim($getpermissionrange[0]),6,4).'-'.substr(trim($getpermissionrange[0]),3,2).'-'.substr(trim($getpermissionrange[0]),0,2).' '.$starthour1.':'.$startminute1.':00';
        }else{
            $starthour1 = substr(trim($getpermissionrange[0]),11,2);
            $startminute1 = substr(trim($getpermissionrange[0]),14,2);
            $dateformat1 = substr(trim($getpermissionrange[0]),6,4).'-'.substr(trim($getpermissionrange[0]),3,2).'-'.substr(trim($getpermissionrange[0]),0,2).' '.$starthour1.':'.$startminute1.':00';
        }
        
        if ($meridiangetstart2 == 'PM') {
            $starthour2 = substr(trim($getpermissionrange[1]),11,2) + 12;
            $startminute2 = substr(trim($getpermissionrange[1]),14,2);
            $dateformat2 = substr(trim($getpermissionrange[1]),6,4).'-'.substr(trim($getpermissionrange[1]),3,2).'-'.substr(trim($getpermissionrange[1]),0,2).' '.$starthour2.':'.$startminute2.':00';
        }else{
            $starthour2 = substr(trim($getpermissionrange[1]),11,2);
            $startminute2 = substr(trim($getpermissionrange[1]),14,2);
            $dateformat2 = substr(trim($getpermissionrange[1]),6,4).'-'.substr(trim($getpermissionrange[1]),3,2).'-'.substr(trim($getpermissionrange[1]),0,2).' '.$starthour2.':'.$startminute2.':00';
        }

        $date['starttime'] = $dateformat1;
        $date['endtime'] = $dateformat2;
        
        return $date;
    }

    public function gettimedifferenceinminutes($starttime, $endtime)
    {
        $carbonstarttime = Carbon::parse($starttime, 'Asia/Kolkata');
        $carbonendtime = Carbon::parse($endtime, 'Asia/Kolkata');

        return $carbonendtime->diffInMinutes($carbonstarttime);

    }


    public function checkwithshifttimings($starttime, $endtime, $employeeid, $partial_days)
    {
        
        $year = Carbon::parse($starttime, 'Asia/Kolkata')->year;
        $month = Carbon::parse($starttime, 'Asia/Kolkata')->format('m');
        

        $sapattendance = $this->mycommonattendance($employeeid, $starttime, $endtime);

        //$sapattendance = $this->attendance($employeeid, $month, $year);

        foreach ($sapattendance as $key => $value) {
            if (($value['shift_name'] == 'VGN HO G') || ($value['shift_name'] == 'VGN HO GENERAL SHIFT')) {
                $sapstartdate = $value['attendancedate'].' '.$value['shift_start'];
                $sapenddate = $value['attendancedate'].' '.$value['shift_end'];
                
                if ($partial_days == 'first_half') {
                    if ($sapstartdate == $starttime) {
                        return true;
                    }
                }

                if ($partial_days == 'second_half') {
                    if ($sapenddate == $endtime) {
                        return true;
                    }
                }
            }
            

        }

        return false;
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



    public function mycommonattendance($employeeid, $startdate, $enddate)
    {
        
          
            $getemployeedata = DB::connection('mysql6')->table('employee')->where('id', '=', $employeeid)->get();
            
                        
            foreach ($getemployeedata as $ckey => $cvalue) {
                 $cadre = $cvalue->cadre;
                 $shift_name = $cvalue->shift_name;
                 $shift_timings_in = $cvalue->shift_timings_in;
                 $shift_timings_out = $cvalue->shift_timings_out;
                 //dd($shift_name);
             }
            
            
            $month = Carbon::parse($startdate)->format('F');
            $year = Carbon::parse($startdate)->year;
            
            
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
                 
                $datearray[$j]['shift_name'] = $shift_name;
                $datearray[$j]['shift_start'] = $this->formattime($shift_timings_in);
                $datearray[$j]['shift_end'] = $this->formattime($shift_timings_out);
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

                         
                                       
             return $datearray;
            
                 
    }


    public function only_present_past3_date_check($start_date)
    {
        $applicationstartdate = Carbon::parse($start_date);
        $currentdateformatstring = Carbon::now()->toDateString();
        $presentdate = Carbon::parse($currentdateformatstring);

        $checkgreaterthancurrentdate = $applicationstartdate->gt($presentdate);
        $getlast3daysfromnow = Carbon::now()->subDays(3)->toDateString();

        $checklessthan3days = Carbon::parse($applicationstartdate)->lt(Carbon::parse($getlast3daysfromnow));
        
            if(($checklessthan3days == true) || ($checkgreaterthancurrentdate) == true ){
            return true;
            }

            return false;
    }

    public function only_past_future_days_check($start_date, $end_date)
    {
        $applicationstartdate = Carbon::parse($start_date);
        $applicationenddate = Carbon::parse($end_date);
        $currentdateadd30daysstring = Carbon::now()->addDays(30);
        

        $checkgreaterthan30endate = $applicationenddate->gt($currentdateadd30daysstring);
        $getlast3daysfromnow = Carbon::now()->subDays(3)->toDateString();

        $checklessthan3days = Carbon::parse($applicationstartdate)->lt(Carbon::parse($getlast3daysfromnow));
        
            if(($checklessthan3days == true) || ($checkgreaterthan30endate) == true ){
            return true;
            }

            return false;
    }


    public function check_with_applied_compoff_dates($employeeid, $getcompoffdbformat)
    {
        $compoffcount = DB::connection('mysql6')->table('lms_applications')->where('employeeid', '=', $employeeid)->where('compoff_worked_stdate','LIKE','%'.$getcompoffdbformat.'%')->count();

        if ($compoffcount > 0) {
            return true;
        }
        else{
            return false;
        }


    }

    public function check_with_applied_mispunch_dates($employeeid, $getmidpunchdbformat)
    {
        $mispunchcount = DB::connection('mysql6')->table('lms_applications')->where(['employeeid' => $employeeid, 'type' => 'Mispunch'])->where('start_date','LIKE','%'.$getmidpunchdbformat.'%')->count();

        if ($mispunchcount > 0) {
            return true;
        }
        else{
            return false;
        }


    }


     
  
  
  
  
    }