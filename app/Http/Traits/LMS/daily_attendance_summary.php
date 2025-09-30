<?php
namespace vgn\Http\Traits\LMS;

use Carbon\Carbon;
use DB;
use File;





trait daily_attendance_summary{


    public function nn_daily_latesprocess($employeeid, $monthnumber, $monthyear)
    {
        //$employeeid = '100441';
        $active_emp = $this->getallactiveemployees();
        foreach ($active_emp['Details'] as $activekey => $activevalue) {
            if ($activevalue['Emp_ID'] == $employeeid) {
                $cadre = $activevalue['Cadre'];
                $rolecode = $activevalue['Role_Code'];
            }
        }

        $requestedmonthdate = Carbon::parse($monthyear.'-'.$monthnumber.'-01')->toDateString();
        $month = $monthnumber;
        $monthyear = $monthyear;
        $employeeid = $employeeid;

        $daterange_array = $this->createDateRange(Carbon::parse($requestedmonthdate)->startOfMonth()->toDateString(), Carbon::parse($requestedmonthdate)->endOfMonth()->toDateString(), $format = "Y-m-d");

        $getpunches = $this->getpunches($employeeid, Carbon::parse($requestedmonthdate)->startOfMonth()->toDateString(), Carbon::parse($requestedmonthdate)->endOfMonth()->toDateString());
        $newarr = [];
        //dd($getpunches['Sorted_Punches']);
        $getnewpunches = [];
        if (array_key_exists('0', $getpunches['Sorted_Punches'])) {
            $getnewpunches = $getpunches['Sorted_Punches'];
        }
        else{
            $getnewpunches[0] = $getpunches['Sorted_Punches'];
        }
        foreach ($getnewpunches as $key => $value) {
            if ($value['Date'] != '') {
                $newarr[$value['Date']][] = $value['Time'];
            }
            
        }
        //dd($newarr);

        $getshiftdetails = $this->getshiftdetailsst_et_date($employeeid, Carbon::parse($requestedmonthdate)->startOfMonth()->toDateString(), Carbon::parse($requestedmonthdate)->endOfMonth()->toDateString());
        

        $year = Carbon::parse($requestedmonthdate)->format('Y'); 
        $getholiday = $this->holiday($employeeid, $year);
        $step1array = [];
        $special_holiday_dates = ['2018-08-08','2019-04-18',"2020-03-22",'2020-03-23','2020-03-24','2020-03-25','2020-03-26','2020-03-27','2020-03-28'];
        $weekoff_count = 0;
        $wordmonth = Carbon::parse($requestedmonthdate)->startOfMonth()->format('M');
            $bt = new \DateTime("second sat of $wordmonth $year");
            $btcarbon = Carbon::instance($bt);
            $second_saturday = $btcarbon->toDateString();


        foreach ($getshiftdetails['Shift_Details'] as $key11 => $value11) {
            $step1array[$key11]['employeeid'] = $value11['Emp_ID'];
            $step1array[$key11]['shift_code'] = $value11['Shift_Code'];
            $step1array[$key11]['shift_date'] = $value11['Shift_Date'];
            $step1array[$key11]['shift_startdatetime'] = $value11['Shift_Date'].' '.$value11['Start_Time'];
            $step1array[$key11]['shift_enddatetime'] = $value11['Shift_Date'].' '.$value11['End_Time'];
            $step1array[$key11]['weekoff'] = false;
            $step1array[$key11]['cadre'] = $cadre;
            $step1array[$key11]['rolecode'] = $rolecode;
            $step1array[$key11]['holiday'] = false;
            $step1array[$key11]['holiday_count'] = 0;
            $step1array[$key11]['firsth_end_sech_starttime'] = null;
            $step1array[$key11]['second_saturday_half_include'] = false;

            foreach ($getholiday['CALENDAR'] as $holidaykey => $holidayvalue) {
                $sap_holiday_date = substr($holidayvalue['Date'], 0,4).'-'.substr($holidayvalue['Date'], 4,2).'-'.substr($holidayvalue['Date'], 6,2);
                if ($sap_holiday_date == $value11['Shift_Date']) {
                        $step1array[$key11]['holiday'] = true;
                        $step1array[$key11]['holiday_count'] = $holidayvalue['No_of_Days'];
                }
            }

            if (in_array($value11['Shift_Date'], $special_holiday_dates)) {
                $step1array[$key11]['holiday'] = true;
                $step1array[$key11]['holiday_count'] = 1;
            }

            //leaveapp
            $getleaveapp1 = DB::connection('mysql6')->table('datetime_ref')->where(['employeeid' => $employeeid, 'date' => $value11['Shift_Date'],'final_status' => 'Approved'])->get();
            $lmsapplications = [];
           if (count($getleaveapp1) > 0) {
            foreach ($getleaveapp1 as $applkey => $applvalue) {
                $lmsapplications[] = $applvalue;
            }
               
           }
            $step1array[$key11]['lms_applications'] = $lmsapplications;
            $punchlist = $this->getpunchesforlatesprocess($employeeid, $value11['Shift_Date'],$value11['Shift_Code'],$getpunches);
            $step1array[$key11]['punchlist'] = $punchlist;
            //leaveapp

            $carbon_start_date = Carbon::parse($value11['Shift_Date']);
            $start_shiftcode = $value11['Shift_Code'];
            $addonday = Carbon::parse($value11['Shift_Date'].' '.$value11['End_Time'])->addDay()->toDateTimeString();

            $diffinminutes = Carbon::parse($value11['Shift_Date'].' '.$value11['Start_Time'])->diffInSeconds(Carbon::parse($value11['Shift_Date'].' '.$value11['End_Time']));
    		$minutesdivide = $diffinminutes/2;
    		$gmate = gmdate('H:i:s', $minutesdivide);

            if (($start_shiftcode == 'VGN_GEN') || ($start_shiftcode == 'VGN_SAP') || ($start_shiftcode == 'VGN_RCP1') || ($start_shiftcode == 'VGN_RCP2') || ($start_shiftcode == 'VGN_MGR')|| ($start_shiftcode == 'VGN_DVR')) {

            	$splitsub = explode(':', $gmate);
    
    			$firsth_end_sech_starttime = Carbon::parse($value11['Shift_Date'].' '.$value11['Start_Time'])->addHours($splitsub[0])->addMinutes($splitsub[1])->subMinutes(30)->toDateTimeString();

    			$step1array[$key11]['firsth_end_sech_starttime'] = $firsth_end_sech_starttime;
                if ($second_saturday == $value11['Shift_Date']) {
                    $step1array[$key11]['shift_enddatetime'] = $firsth_end_sech_starttime;
                    $step1array[$key11]['second_saturday_half_include'] = true;
                }
            }

                    if(($start_shiftcode == 'VGN_GEN2') || ($start_shiftcode == 'VGN_SIAD')){
                    	if ($start_shiftcode == 'VGN_GEN2') {
                    		$splitsub = explode(':', $gmate);
    
    			$firsth_end_sech_starttime = Carbon::parse($value11['Shift_Date'].' '.$value11['Start_Time'])->addHours($splitsub[0])->addMinutes($splitsub[1])->subMinutes(30)->toDateTimeString();

    			$step1array[$key11]['firsth_end_sech_starttime'] = $firsth_end_sech_starttime;
                    	}
                    	else{
                    		$splitsub = explode(':', $gmate);
    
    			$firsth_end_sech_starttime = Carbon::parse($value11['Shift_Date'].' '.$value11['Start_Time'])->addHours($splitsub[0])->addMinutes($splitsub[1])->toDateTimeString();

    			$step1array[$key11]['firsth_end_sech_starttime'] = $firsth_end_sech_starttime;
                    	}
                    	

                        if($carbon_start_date->isTuesday() == true){
                            $step1array[$key11]['weekoff'] = true;
                        }else{
                            $step1array[$key11]['weekoff'] = false;
                        }   
                   }
                  elseif(($start_shiftcode == 'VGN_FDAY') || ($start_shiftcode == 'VGN_FNIG')){
                    if ($start_shiftcode == 'VGN_FNIG') {
                        $step1array[$key11]['shift_enddatetime'] = $addonday;
                    

                    $diffinminutes1 = Carbon::parse($value11['Shift_Date'].' '.$value11['Start_Time'])->diffInSeconds(Carbon::parse($step1array[$key11]['shift_enddatetime']));
    		$minutesdivide1 = $diffinminutes1/2;
    		$gmate1 = gmdate('H:i:s', $minutesdivide1);
    		$splitsub1 = explode(':', $gmate1);
    		$firsth_end_sech_starttime = Carbon::parse($value11['Shift_Date'].' '.$value11['Start_Time'])->addHours($splitsub1[0])->addMinutes($splitsub1[1])->toDateTimeString();
    			$step1array[$key11]['firsth_end_sech_starttime'] = $firsth_end_sech_starttime;
    		}
    		else{
    			$splitsub = explode(':', $gmate);
    
    			$firsth_end_sech_starttime = Carbon::parse($value11['Shift_Date'].' '.$value11['Start_Time'])->addHours($splitsub[0])->addMinutes($splitsub[1])->toDateTimeString();

    			$step1array[$key11]['firsth_end_sech_starttime'] = $firsth_end_sech_starttime;
    		}
                        $step1array[$key11]['weekoff'] = false;
                        $step1array[$key11]['holiday'] = false;
                        $step1array[$key11]['holiday_count'] = 0;
                  }
                  elseif ($start_shiftcode == 'VGN_SAP') {
                    if($carbon_start_date->isSaturday() == true){
                        $step1array[$key11]['weekoff'] = true;
                    }else{

                        if($carbon_start_date->isSunday() == true){
                        $step1array[$key11]['weekoff'] = true;
                    }else{
                        $step1array[$key11]['weekoff'] = false;
                    } 
                    
                    }
                 }
                 else{

                 	if ($start_shiftcode == 'VGN_NIGT') {
                		$step1array[$key11]['shift_enddatetime'] = $addonday;
                    

                    $diffinminutes1 = Carbon::parse($value11['Shift_Date'].' '.$value11['Start_Time'])->diffInSeconds(Carbon::parse($step1array[$key11]['shift_enddatetime']));
    		$minutesdivide1 = $diffinminutes1/2;
    		$gmate1 = gmdate('H:i:s', $minutesdivide1);
    		$splitsub1 = explode(':', $gmate1);
    		$firsth_end_sech_starttime = Carbon::parse($value11['Shift_Date'].' '.$value11['Start_Time'])->addHours($splitsub1[0])->addMinutes($splitsub1[1])->toDateTimeString();
    			$step1array[$key11]['firsth_end_sech_starttime'] = $firsth_end_sech_starttime;
                 	}
					else{
                        $splitsub = explode(':', $gmate);
    
                        $firsth_end_sech_starttime = Carbon::parse($value11['Shift_Date'].' '.$value11['Start_Time'])->addHours($splitsub[0])->addMinutes($splitsub[1])->toDateTimeString();
        
                        $step1array[$key11]['firsth_end_sech_starttime'] = $firsth_end_sech_starttime;
                     }

                    if($carbon_start_date->isSunday() == true){
                        $step1array[$key11]['weekoff'] = true;
                    }else{
                        $step1array[$key11]['weekoff'] = false;
                    }  
                }

        }

        return $step1array;       
    }

     public function getdateleavetypeforbackdated_nn($employeeid, $shiftdate)
    {
        $getemp = [];
        $getemp[0] = 1;
        $subday = Carbon::parse($shiftdate)->subDays(1)->toDateString();
        $weekoffholiday = $this->checkweekoff_holidays_new($employeeid, $subday, $subday, $getemp);
        if(($weekoffholiday['holiday_count'] == 1) || ($weekoffholiday['weekoff_count'] == 1)){
            return $this->getdateleavetypeforbackdated_nn($employeeid, $subday);
        }
        else{
            return $subday;
        }
    }

    public function getdateleavetypefornextdated_nn($employeeid, $shiftdate)
    {
        $getemp = [];
        $getemp[0] = 1;
        $addday = Carbon::parse($shiftdate)->addDays(1)->toDateString();
        $weekoffholiday = $this->checkweekoff_holidays_new($employeeid, $addday, $addday, $getemp);
        if(($weekoffholiday['holiday_count'] == 1) || ($weekoffholiday['weekoff_count'] == 1)){
            return $this->getdateleavetypefornextdated_nn($employeeid, $addday);
        }
        else{
            return $addday;
        }
    }


    public function nn_daily_newattendancesummary($employeeid, $monthnumber, $monthyear)
    {
        
        $attendance = $this->nn_daily_latesprocess($employeeid, $monthnumber, $monthyear);
        //dd($attendance);
        $laterange1 = 0;
        $laterange2 = 0;
        $laterange3 = 0;
        
        //dd($attendance);
        foreach ($attendance as $key => $value) {
            $currentdate = Carbon::now()->toDateString();
            $latecount = 0;
            $attendance[$key] = $value;
            $attendance[$key]['first_half_lop'] = 0;
            $attendance[$key]['second_half_lop'] = 0;
            $attendance[$key]['latecount'] = $latecount;
            $attendance[$key]['latein_hours'] = null; 
            $attendance[$key]['laterange1'] = $laterange1;
            $attendance[$key]['laterange2'] = $laterange2;
            $attendance[$key]['laterange3'] = $laterange3;
            $attendance[$key]['earlyoutcount'] = 0;
            $attendance[$key]['earlyout_hours'] = null;  
            $attendance[$key]['absent'] = 0;
            $attendance[$key]['present'] = 0;
            $attendance[$key]['first_half_considered_punches'] = []; 

            if (Carbon::parse($value['shift_date'])->lte(Carbon::parse($currentdate))) {

            

            if (($value['weekoff'] == true) || ($value['holiday'] == true)) {
                $attendance[$key]['present'] = 1;   

                //dd($value['shift_date']);
                    //prevdaystart

                                        $prev = 0;
                                        $getstartofmonth = Carbon::parse($value['shift_date'])->startOfMonth()->toDateString();
                                        //   dd($value['shift_date']);
                                        if ($getstartofmonth == $value['shift_date']) {
                                            $subonedayforcheckovertime = Carbon::parse($value['shift_date'])->subDay()->toDateString();

                                            $getoverpunches = $this->getpunches($employeeid, $subonedayforcheckovertime, $subonedayforcheckovertime);
                                                $overarr = [];
                                                //dd($getpunches['Sorted_Punches']);
                                                $getovernewpunches = [];
                                                if (array_key_exists('0', $getoverpunches['Sorted_Punches'])) {
                                                    $getovernewpunches = $getoverpunches['Sorted_Punches'];
                                                }
                                                else{
                                                    $getovernewpunches[0] = $getoverpunches['Sorted_Punches'];
                                                }
                                                foreach ($getovernewpunches as $overkey => $overvalue) {
                                                    if ($overvalue['Date'] != '') {
                                                        $overarr['punchlist'][] = $overvalue['Date'].' '.$overvalue['Time'];
                                                    }
                                                    
                                                }

                                                if (!empty($overarr)) {
                                                    
                                                    $prev = 1;
                                                }
                                                else{
                                                    $getemp =[];
                                                    $getemp[0] = 1;

                                                    $checkweekoff_holidayn = $this->checkweekoff_holidays_new($employeeid, $subonedayforcheckovertime, $subonedayforcheckovertime, $getemp);
                                                    if(($checkweekoff_holidayn['holiday_count'] == 1) || ($checkweekoff_holidayn['weekoff_count'] == 1)){
                                                        $subtwodayforcheckovertime = Carbon::parse($value['shift_date'])->subDays(2)->toDateString();
                        
                                                        $getoverpunches = $this->getpunches($employeeid, $subtwodayforcheckovertime, $subtwodayforcheckovertime);
                                                        
                                                        $overarrn = [];
                                                        //dd($getpunches['Sorted_Punches']);
                                                        $getovernewpunchesn = [];
                                                        if (array_key_exists('0', $getoverpunches['Sorted_Punches'])) {
                                                            $getovernewpunchesn = $getoverpunches['Sorted_Punches'];
                                                        }
                                                        else{
                                                            $getovernewpunchesn[0] = $getoverpunches['Sorted_Punches'];
                                                        }
                                                        foreach ($getovernewpunchesn as $overkey1 => $overvalue1) {
                                                            if ($overvalue1['Date'] != '') {
                                                                $overarrn['punchlist'][] = $overvalue1['Date'].' '.$overvalue1['Time'];
                                                            }
                                                            
                                                        }
        
                                                        if (!empty($overarrn)) {
                                                            
                                                            $prev = 1;
                                                        }

                        
                        
                                                    }
                                                }

                                        }
                                        else{
                                            
                                            $subonedayforcheckovertime = $key - 1;
                                            
                                            $newpunchlist['punchlist'] = $attendance[$subonedayforcheckovertime]['punchlist'];
                                            if (!empty($newpunchlist['punchlist'])) {
                                                $prev = 1;
                                            }
                                            else{
                                                if(($attendance[$subonedayforcheckovertime]['weekoff'] == true) || ($attendance[$subonedayforcheckovertime]['holiday'] == true)){
                                                    $subtwodayforcheckovertime = $subonedayforcheckovertime - 1;
                                                    if($subtwodayforcheckovertime != '-1'){
                                                    $nnewpunchlist['punchlist'] = $attendance[$subtwodayforcheckovertime]['punchlist'];
                                                    if (!empty($nnewpunchlist['punchlist'])) {
                                                        $prev = 1;
                                                    }
                                                }
                                                else{

                                                    $subthreedayforcheckovertime = Carbon::parse($attendance[$subonedayforcheckovertime]['shift_date'])->subDay()->toDateString();
                                                        
                                                        $getvoverpunches = $this->getpunches($employeeid, $subthreedayforcheckovertime, $subthreedayforcheckovertime);
                                                        
                                                            $overarre = [];
                                                            //dd($getpunches['Sorted_Punches']);
                                                            $getvovernewpunches = [];
                                                            if (array_key_exists('0', $getvoverpunches['Sorted_Punches'])) {
                                                                $getvovernewpunches = $getvoverpunches['Sorted_Punches'];
                                                            }
                                                            else{
                                                                $getvovernewpunches[0] = $getvoverpunches['Sorted_Punches'];
                                                            }
                                                            foreach ($getvovernewpunches as $eoverkey => $eoverval) {
                                                                if ($eoverval['Date'] != '') {
                                                                    
                                                                    $overarre['punchlist'][] = $eoverval['Date'].' '.$eoverval['Time'];
                                                                }
                                                                
                                                            }

                                                            
            
                                                            if (!empty($overarre)) {
                                                                
                                                                $prev = 1;
                                                            }

                                                }
                    
                                                }
                                            }
                                            //dd($prev);
                                        }
                    //prevdayend

                    //nextdaystart

                    $next = 0;
                    $getendofofmonth = Carbon::parse($value['shift_date'])->endOfMonth()->toDateString();
                    //   dd($value['shift_date']);
                    if ($getendofofmonth == $value['shift_date']) {
                        $addonedayforcheckovertime = Carbon::parse($value['shift_date'])->addDay()->toDateString();

                        $getoverpunches = $this->getpunches($employeeid, $addonedayforcheckovertime, $addonedayforcheckovertime);
                            $overarr = [];
                            //dd($getpunches['Sorted_Punches']);
                            $getovernewpunches = [];
                            if (array_key_exists('0', $getoverpunches['Sorted_Punches'])) {
                                $getovernewpunches = $getoverpunches['Sorted_Punches'];
                            }
                            else{
                                $getovernewpunches[0] = $getoverpunches['Sorted_Punches'];
                            }
                            foreach ($getovernewpunches as $overkey => $overvalue) {
                                if ($overvalue['Date'] != '') {
                                    $overarr['punchlist'][] = $overvalue['Date'].' '.$overvalue['Time'];
                                }
                                
                            }

                            if (!empty($overarr)) {
                                
                                $next = 1;
                            }
                            else{
                                $getemp =[];
                                $getemp[0] = 1;
                                $checkweekoff_holidayn = $this->checkweekoff_holidays_new($employeeid, $addonedayforcheckovertime, $addonedayforcheckovertime, $getemp);
                                if(($checkweekoff_holidayn['holiday_count'] == 1) || ($checkweekoff_holidayn['weekoff_count'] == 1)){
                                    $addtwodayforcheckovertime = Carbon::parse($value['shift_date'])->addDays(2)->toDateString();
    
                                    $getoverpunches = $this->getpunches($employeeid, $addtwodayforcheckovertime, $addtwodayforcheckovertime);
                                    
                                    $overarrn = [];
                                    //dd($getpunches['Sorted_Punches']);
                                    $getovernewpunchesn = [];
                                    if (array_key_exists('0', $getoverpunches['Sorted_Punches'])) {
                                        $getovernewpunchesn = $getoverpunches['Sorted_Punches'];
                                    }
                                    else{
                                        $getovernewpunchesn[0] = $getoverpunches['Sorted_Punches'];
                                    }
                                    foreach ($getovernewpunchesn as $overkey1 => $overvalue1) {
                                        if ($overvalue1['Date'] != '') {
                                            $overarrn['punchlist'][] = $overvalue1['Date'].' '.$overvalue1['Time'];
                                        }
                                        
                                    }

                                    if (!empty($overarrn)) {
                                        
                                        $next = 1;
                                    }

    
    
                                }

                            }

                    }
                    else{
                        
                        $addonedayforcheckovertime = $key + 1;
                        
                        $newpunchlist['punchlist'] = $attendance[$addonedayforcheckovertime]['punchlist'];
                        if (!empty($newpunchlist['punchlist'])) {
                            $next = 1;
                        }
                        else{
                            if(($attendance[$addonedayforcheckovertime]['weekoff'] == true) || ($attendance[$addonedayforcheckovertime]['holiday'] == true)){
                                $addtwodayforcheckovertime = $addonedayforcheckovertime + 1;
                                if (array_key_exists($addtwodayforcheckovertime, $attendance) === true) {
                                $nnewpunchlist['punchlist'] = $attendance[$addtwodayforcheckovertime]['punchlist'];
                                if (!empty($nnewpunchlist['punchlist'])) {
                                    $next = 1;
                                }
                                }

                            }
                        }
                    }
//nextdayend
//dd($prev.''.$next);

if(($prev == 0) && ($next == 0)){
    
    $checkleave = DB::connection('mysql6')->table('datetime_ref')->where(['employeeid' => $employeeid,'partial_days' => 'full', 'date' => $value['shift_date'],'final_status' => 'Approved'])->whereIn('type',['CL','SL','PL','ML','Tour','Compoff'])->get();
    $getlop = DB::connection('mysql6')->table('datetime_ref')->where(['employeeid' => $employeeid, 'date' => $value['shift_date'],'type' => 'LOP','final_status' => 'Approved'])->get();
    //dd($value['shift_date']);
    if (count($getlop) > 0) {
        foreach ($getlop as $llkey => $llvalue) {
            $partiallop = $llvalue->partial_days;

            if($partiallop == 'full'){
                $attendance[$key]['present'] = 0; 
                $attendance[$key]['absent'] = 1;
            }
            else{
                $attendance[$key]['present'] = 0; 
                $attendance[$key]['absent'] += 0.5;
            }
        }
    }else{
    
        if(count($checkleave) == 0){

        $prev_consider_date = $this->getdateleavetypeforbackdated_nn($employeeid, $value['shift_date'], $value['shift_date']);
        $next_consider_date = $this->getdateleavetypefornextdated_nn($employeeid, $value['shift_date'], $value['shift_date']);       
        
            $wordmonth = Carbon::parse($value['shift_date'])->startOfMonth()->format('M');
            $cyear = Carbon::parse($value['shift_date'])->format('Y');
            $bt = new \DateTime("second sat of $wordmonth $cyear");
            $btcarbon = Carbon::instance($bt);
            $second_saturday = $btcarbon->toDateString();
            $addsecsaturday = Carbon::parse($second_saturday)->addDays(1)->toDateString();
    
            //$prev_consider_date = Carbon::parse($value['shift_date'])->subDay()->toDateString();
            //$next_consider_date = Carbon::parse($value['shift_date'])->addDay()->toDateString();

        if(($value['shift_code'] == 'VGN_GEN') || ($value['shift_code'] == 'VGN_RCP1') || ($value['shift_code'] == 'VGN_RCP2') || ($value['shift_code'] == 'VGN_MGR')|| ($value['shift_code'] == 'VGN_DVR')){

        if ($value['shift_date'] == $addsecsaturday) {
            $prev_days_consider = DB::connection('mysql6')->table('datetime_ref')->where(['employeeid' => $employeeid, 'date' => $prev_consider_date,'final_status' => 'Approved'])->whereIn('type',['CL','SL','PL','ML'])->get();
            $next_days_consider = DB::connection('mysql6')->table('datetime_ref')->where(['employeeid' => $employeeid, 'date' => $next_consider_date,'final_status' => 'Approved'])->whereIn('type',['CL','SL','PL','ML'])->get();
        }
        else{
            $prev_days_consider = DB::connection('mysql6')->table('datetime_ref')->where(['employeeid' => $employeeid, 'date' => $prev_consider_date,'final_status' => 'Approved', 'partial_days' => 'full'])->whereIn('type',['CL','SL','PL','ML'])->get();
            $next_days_consider = DB::connection('mysql6')->table('datetime_ref')->where(['employeeid' => $employeeid, 'date' => $next_consider_date,'final_status' => 'Approved', 'partial_days' => 'full'])->whereIn('type',['CL','SL','PL','ML'])->get();
        }
        
        }
        else{
            $prev_days_consider = DB::connection('mysql6')->table('datetime_ref')->where(['employeeid' => $employeeid, 'date' => $prev_consider_date,'final_status' => 'Approved', 'partial_days' => 'full'])->whereIn('type',['CL','SL','PL','ML'])->get();
            $next_days_consider = DB::connection('mysql6')->table('datetime_ref')->where(['employeeid' => $employeeid, 'date' => $next_consider_date,'final_status' => 'Approved', 'partial_days' => 'full'])->whereIn('type',['CL','SL','PL','ML'])->get();
        }
    
        $prev_days_application = DB::connection('mysql6')->table('datetime_ref')->where(['employeeid' => $employeeid, 'date' => $prev_consider_date,'final_status' => 'Approved'])->get();
        $next_days_application = DB::connection('mysql6')->table('datetime_ref')->where(['employeeid' => $employeeid, 'date' => $next_consider_date,'final_status' => 'Approved'])->get();
        if((count($prev_days_consider) > 0) && (count($next_days_consider) > 0)){
            $attendance[$key]['present'] = 0; 
            $attendance[$key]['absent'] = 1;       
        }
        elseif(empty($prev_days_application) && empty($next_days_application)){
            $attendance[$key]['present'] = 0; 
            $attendance[$key]['absent'] = 1;  
        }
        else{
            $prev_days_consider1 = DB::connection('mysql6')->table('datetime_ref')->where(['employeeid' => $employeeid, 'date' => $prev_consider_date,'final_status' => 'Approved'])->whereIn('type',['Tour','Compoff','CL','SL','PL','ML'])->get();
    $next_days_consider1 = DB::connection('mysql6')->table('datetime_ref')->where(['employeeid' => $employeeid, 'date' => $next_consider_date,'final_status' => 'Approved'])->whereIn('type',['Tour','Compoff','CL','SL','PL','ML'])->get();
            if((count($prev_days_consider1) > 0) && (count($next_days_consider1) > 0)){
                    $attendance[$key]['present'] = 1; 
                    $attendance[$key]['absent'] = 0;       
            }
            else{
                $attendance[$key]['present'] = 0; 
                $attendance[$key]['absent'] = 1;           
            } 
        }
        
        }

    }

    //dd($attendance);
    
}

$getlop1 = DB::connection('mysql6')->table('datetime_ref')->where(['employeeid' => $employeeid, 'date' => $value['shift_date'],'type' => 'LOP','final_status' => 'Approved'])->get();
    
    //dd($value['shift_date']);
    if (count($getlop1) > 0) {
        foreach ($getlop1 as $llkey1 => $llvalue1) {
            $partiallop1 = $llvalue1->partial_days;

            if($partiallop1 == 'full'){
                $attendance[$key]['present'] = 0; 
                $attendance[$key]['absent'] = 1;
            }
            else{
                $attendance[$key]['present'] = 0; 
                $attendance[$key]['absent'] += 0.5;
            }
        }
    }
                                 
            }
            else{
               if (!empty($value['lms_applications'])) {
                    
                   if (!empty($value['punchlist'])) {

                       
                               $sub2hours_from_shift_starttime = Carbon::parse($value['shift_startdatetime'])->subHours(4);
                               $getshiftstartpunches = [];
                               $add5minutesgrace = Carbon::parse($value['firsth_end_sech_starttime'])->addMinutes(5);
                               foreach ($value['punchlist'] as $pkey => $pvalue) {
                                   if (Carbon::parse($pvalue)->gte($sub2hours_from_shift_starttime) && Carbon::parse($pvalue)->lte($add5minutesgrace)) {
                                        $getshiftstartpunches[] = $pvalue;
                                   }
                                   
                               }
                               $attendance[$key]['first_half_considered_punches'] = $getshiftstartpunches;

                               if (count($value['lms_applications']) == 1) {

                                   if($value['lms_applications'][0]->partial_days =='full'){
                                       if ($value['lms_applications'][0]->type =='LOP') {
                                          // $attendance[$key]['first_half_lop'] = 0.5;
                                           //$attendance[$key]['second_half_lop'] = 0.5;
                                           $attendance[$key]['absent'] = 1;
                                       }
                                       else{
                                           $attendance[$key]['present'] = 1;
                                       }
                                   }
       
                                   if($value['lms_applications'][0]->partial_days =='first_half'){
                                       
                                       if (($value['lms_applications'][0]->type =='Permission')) {
                                           
                                           $explode_to_get_starttime = explode('-', $value['lms_applications'][0]->start_end_time);
                                           $add1minuteexception = Carbon::parse($value['shift_date'].' '.$explode_to_get_starttime[1])->addMinutes(16);                                                
                                       }
                                       else{
                                           if (($value['lms_applications'][0]->type =='LOP')) {
                                               //$attendance[$key]['first_half_lop'] = 0.5;
                                               $attendance[$key]['absent'] = 0.5;
                                           }
                                           $add1minuteexception = Carbon::parse($value['firsth_end_sech_starttime'])->addMinutes(1);
       
                                       }


                                           $checkforleaveapp_late= [];
                                           foreach ($attendance[$key]['first_half_considered_punches'] as $pkey => $pvalue) {
                                               if (Carbon::parse($pvalue)->lt($add1minuteexception)) {
                                                   $checkforleaveapp_late[] = $pvalue;
                                               }    
                                           }

                                           $wordmonth1 = Carbon::parse($value['shift_date'])->startOfMonth()->format('M');
                                           $cyear1 = Carbon::parse($value['shift_date'])->format('Y');
                                           $bt1 = new \DateTime("second sat of $wordmonth1 $cyear1");
                                           $btcarbon1 = Carbon::instance($bt1);
                                           $second_saturday1 = $btcarbon1->toDateString();

                                           if (empty($checkforleaveapp_late) && ($value['lms_applications'][0]->type !='Mispunch')) {
                                               $laterange3 += 1;
                                               $attendance[$key]['laterange3'] = $laterange3;
                                               //$attendance[$key]['first_half_lop'] = 0.5;
                                               $attendance[$key]['second_half_lop'] = 0.5;
                                           }


                        //earlyoutcount
                                   if (($value['shift_code'] == 'VGN_FNIG') || ($value['shift_code'] == 'VGN_NIGT')) {
                                       $minus_1minutesfrom_shiftendtime = Carbon::parse($value['shift_enddatetime'])->subMinutes(1);
                                       $add1hourfrom_shiftendtime = Carbon::parse($value['shift_enddatetime'])->addHours(2);
                                       $checkforleaveapp_earlyout= [];
                                           foreach ($value['punchlist'] as $pkey => $pvalue) {
                                               if ((Carbon::parse($pvalue)->gte($minus_1minutesfrom_shiftendtime)) && (Carbon::parse($pvalue)->lt($add1hourfrom_shiftendtime))) {
                                                   $checkforleaveapp_earlyout[] = $pvalue;
                                               }    
                                           }
                                           if (empty($checkforleaveapp_earlyout)) {
                                               $attendance[$key]['earlyoutcount'] = 1;
                                               $attendance[$key]['second_half_lop'] = 0.5;
                                           }

                                   }
                                   else{
                                       $minus_1minutesfrom_shiftendtime = Carbon::parse($value['shift_enddatetime'])->subMinutes(1);
                                       if ($value['shift_date'] != $second_saturday1) {
                       if (Carbon::parse($value['punchlist'][count($value['punchlist']) - 1])->lt($minus_1minutesfrom_shiftendtime)) {
                               
                           $attendance[$key]['earlyoutcount'] = 1;
                           $attendance[$key]['second_half_lop'] = 0.5;         
                       }
                    }
                                   }

                       //earlyoutcount
       
                                   }
       
                                   if($value['lms_applications'][0]->partial_days =='second_half'){
                                      
                                       if (($value['lms_applications'][0]->type =='Permission')) {
                                           
                                           $explode_to_get_starttime = explode('-', $value['lms_applications'][0]->start_end_time);
                                           $sub1minuteexception = Carbon::parse($value['shift_date'].' '.$explode_to_get_starttime[0])->subMinutes(1); 
                                           $add1minuteexception = Carbon::parse($value['firsth_end_sech_starttime'])->addMinutes(16);                                               
                                       }
                                       else{
                                           if (($value['lms_applications'][0]->type =='LOP')) {
                                               //$attendance[$key]['second_half_lop'] = 0.5;
                                               $attendance[$key]['absent'] = 0.5;
                                           }
                                           $add1minuteexception = Carbon::parse($value['firsth_end_sech_starttime'])->addMinutes(1);
                                           $sub1minuteexception = Carbon::parse($value['firsth_end_sech_starttime'])->subMinutes(1); 
       
                                       }


                                           $checkforearlyout_permission= [];
                                           foreach ($attendance[$key]['punchlist'] as $ekey => $evalue) {
                                               if (Carbon::parse($evalue)->gte($sub1minuteexception)) {
                                                   $checkforearlyout_permission[] = $evalue;
                                               }    
                                           }
                                           if (empty($checkforearlyout_permission)) {
                                               if ($value['lms_applications'][0]->type =='Permission') {
                                               $attendance[$key]['earlyoutcount'] = 1;
                                               $attendance[$key]['second_half_lop'] = 0.5;
                                               }
                                               
                                           }

                                           $checkforleaveapp_late= [];
                                           foreach ($attendance[$key]['first_half_considered_punches'] as $pkey => $pvalue) {
                                               if (Carbon::parse($pvalue)->lte($add1minuteexception)) {
                                                   $checkforleaveapp_late[] = $pvalue;
                                               }    
                                           }
                                           if (empty($checkforleaveapp_late) && ($value['lms_applications'][0]->type !='Mispunch')) {
                                               $laterange3 += 1;
                                               $attendance[$key]['laterange3'] = $laterange3;
                                               $attendance[$key]['first_half_lop'] = 0.5;
                                           }


                                           if (!empty($attendance[$key]['first_half_considered_punches'])) {

                                            $newpunchlist = [];
                                            $overtimenight = 0;
                                               if (($value['cadre'] == 'M') || ($value['shift_code'] == 'VGN_MGR')) 
                                               {
                                                    $gracetime = Carbon::parse($value['shift_startdatetime'])->addMinutes(31); 

                                                    $lastpunchoftheday = '';
                                                    $addoneandhalfhourtoshiftendtime = '';
                                                    $getstartofmonth = Carbon::parse($value['shift_date'])->startOfMonth()->toDateString();
                                                    if ($getstartofmonth == $value['shift_date']) {
                                                        $subonedayforcheckovertime = Carbon::parse($value['shift_date'])->subDay()->toDateString();
        
                                                        $getoverpunches = $this->getpunches($employeeid, $subonedayforcheckovertime, $subonedayforcheckovertime);
                                                            $overarr = [];
                                                            //dd($getpunches['Sorted_Punches']);
                                                            $getovernewpunches = [];
                                                            if (array_key_exists('0', $getoverpunches['Sorted_Punches'])) {
                                                                $getovernewpunches = $getoverpunches['Sorted_Punches'];
                                                            }
                                                            else{
                                                                $getovernewpunches[0] = $getoverpunches['Sorted_Punches'];
                                                            }
                                                            foreach ($getovernewpunches as $overkey => $overvalue) {
                                                                if ($overvalue['Date'] != '') {
                                                                    $overarr['punchlist'][] = $overvalue['Date'].' '.$overvalue['Time'];
                                                                }
                                                                
                                                            }
        
                                                            if (!empty($overarr)) {
                                                                
                                                                $newpunchlist['punchlist'] = $overarr['punchlist'];
                                                                $lastpunchoftheday = $newpunchlist['punchlist'][count($newpunchlist['punchlist']) - 1];
                                                                $getshiftdetailsnew = $this->getshiftdetailsst_et_date($employeeid, $subonedayforcheckovertime, $subonedayforcheckovertime);
                                                                $onegetshiftdetailsnew = [];
                                                                if (array_key_exists('0', $getshiftdetailsnew['Shift_Details'])) {
                                                                    $onegetshiftdetailsnew = $getshiftdetailsnew['Shift_Details'];
                                                                }
                                                                else{
                                                                    $onegetshiftdetailsnew[0] = $getshiftdetailsnew['Shift_Details'];
                                                                }
                                                                foreach ($onegetshiftdetailsnew as $keyovershiftcode => $valueovershiftcode) {
                                                                    $shiftendtimeforfirstendtime = $valueovershiftcode['Shift_Date'].' '.$valueovershiftcode['End_Time'];
                                                                }
        
                                                                $addoneandhalfhourtoshiftendtime = Carbon::parse($shiftendtimeforfirstendtime)->addMinutes(90)->toDateTimeString();
                                                            }
        
                                                    }
                                                    else{
                                                        $subonedayforcheckovertime = $key - 1;
                                                        $newpunchlist['punchlist'] = $attendance[$subonedayforcheckovertime]['punchlist'];
                                                        if (!empty($newpunchlist['punchlist'])) {
                                                            $lastpunchoftheday = $newpunchlist['punchlist'][count($newpunchlist['punchlist']) - 1];
                                                            $addoneandhalfhourtoshiftendtime = Carbon::parse($attendance[$subonedayforcheckovertime]['shift_enddatetime'])->addMinutes(90)->toDateTimeString();
                                                        }
                                                    }
                                                
                                                
                                                if (($lastpunchoftheday != '') && ($addoneandhalfhourtoshiftendtime != '')) {
                                                    if (Carbon::parse($lastpunchoftheday)->gte(Carbon::parse($addoneandhalfhourtoshiftendtime))) {
                                                        $diffforgracetime_newlogic = Carbon::parse($addoneandhalfhourtoshiftendtime)->diffInSeconds(Carbon::parse($lastpunchoftheday));
                                                        if (($diffforgracetime_newlogic >= 0) && ($diffforgracetime_newlogic <= 3660)) {
                                                            $addgractime = 30 + 15;
                                                            $gracetime = Carbon::parse($value['shift_startdatetime'])->addMinutes($addgractime);
                                                            $overtimenight = 1;
                                                        }
                                                        elseif (($diffforgracetime_newlogic > 3660) && ($diffforgracetime_newlogic <= 7200)) {
                                                            $addgractime = 30 + 30;
                                                            $gracetime = Carbon::parse($value['shift_startdatetime'])->addMinutes($addgractime);
                                                            $overtimenight = 1;
                                                        }
                                                        elseif (($diffforgracetime_newlogic > 3660) && ($diffforgracetime_newlogic <= 7200)) {
                                                            $addgractime = 30 + 30;
                                                            $gracetime = Carbon::parse($value['shift_startdatetime'])->addMinutes($addgractime);
                                                            $overtimenight = 1;
                                                        }
                                                        elseif (($diffforgracetime_newlogic > 7200) && ($diffforgracetime_newlogic <= 10800)) {
                                                            $addgractime = 30 + 45;
                                                            $gracetime = Carbon::parse($value['shift_startdatetime'])->addMinutes($addgractime);
                                                            $overtimenight = 1;
                                                        }
                                                        else{
                                                            if($diffforgracetime_newlogic > 10800){
                                                                $addgractime = 30 + 60;
                                                                $gracetime = Carbon::parse($value['shift_startdatetime'])->addMinutes($addgractime);
                                                                $overtimenight = 1;
                                                            }
                                                        }
                                                    }
                                                }

                                               }
                                               else
                                               {
                                                    $gracetime = Carbon::parse($value['shift_startdatetime'])->addMinutes(16); 

                                                    $lastpunchoftheday = '';
                                                    $addoneandhalfhourtoshiftendtime = '';
                                                    $getstartofmonth = Carbon::parse($value['shift_date'])->startOfMonth()->toDateString();
                                                    //   dd($value['shift_date']);
                                                    if ($getstartofmonth == $value['shift_date']) {
                                                        $subonedayforcheckovertime = Carbon::parse($value['shift_date'])->subDay()->toDateString();
            
                                                        $getoverpunches = $this->getpunches($employeeid, $subonedayforcheckovertime, $subonedayforcheckovertime);
                                                            $overarr = [];
                                                            //dd($getpunches['Sorted_Punches']);
                                                            $getovernewpunches = [];
                                                            if (array_key_exists('0', $getoverpunches['Sorted_Punches'])) {
                                                                $getovernewpunches = $getoverpunches['Sorted_Punches'];
                                                            }
                                                            else{
                                                                $getovernewpunches[0] = $getoverpunches['Sorted_Punches'];
                                                            }
                                                            foreach ($getovernewpunches as $overkey => $overvalue) {
                                                                if ($overvalue['Date'] != '') {
                                                                    $overarr['punchlist'][] = $overvalue['Date'].' '.$overvalue['Time'];
                                                                }
                                                                
                                                            }
            
                                                            if (!empty($overarr)) {
                                                                
                                                                $newpunchlist['punchlist'] = $overarr['punchlist'];
                                                                $lastpunchoftheday = $newpunchlist['punchlist'][count($newpunchlist['punchlist']) - 1];
                                                                $getshiftdetailsnew = $this->getshiftdetailsst_et_date($employeeid, $subonedayforcheckovertime, $subonedayforcheckovertime);
                                                                $onegetshiftdetailsnew = [];
                                                                if (array_key_exists('0', $getshiftdetailsnew['Shift_Details'])) {
                                                                    $onegetshiftdetailsnew = $getshiftdetailsnew['Shift_Details'];
                                                                }
                                                                else{
                                                                    $onegetshiftdetailsnew[0] = $getshiftdetailsnew['Shift_Details'];
                                                                }
                                                                foreach ($onegetshiftdetailsnew as $keyovershiftcode => $valueovershiftcode) {
                                                                    $shiftendtimeforfirstendtime = $valueovershiftcode['Shift_Date'].' '.$valueovershiftcode['End_Time'];
                                                                }
            
                                                                $addoneandhalfhourtoshiftendtime = Carbon::parse($shiftendtimeforfirstendtime)->addMinutes(90)->toDateTimeString();
                                                            }
            
                                                    }
                                                    else{
                                                        
                                                        $subonedayforcheckovertime = $key - 1;
                                                        
                                                        $newpunchlist['punchlist'] = $attendance[$subonedayforcheckovertime]['punchlist'];
                                                        if (!empty($newpunchlist['punchlist'])) {
                                                            $lastpunchoftheday = $newpunchlist['punchlist'][count($newpunchlist['punchlist']) - 1];
                                                            $addoneandhalfhourtoshiftendtime = Carbon::parse($attendance[$subonedayforcheckovertime]['shift_enddatetime'])->addMinutes(90)->toDateTimeString();
                                                        }
                                                    }
                                                
                                                
                                                if (($lastpunchoftheday != '') && ($addoneandhalfhourtoshiftendtime != '')) {
                                                    if (Carbon::parse($lastpunchoftheday)->gte(Carbon::parse($addoneandhalfhourtoshiftendtime))) {
                                                        $diffforgracetime_newlogic = Carbon::parse($addoneandhalfhourtoshiftendtime)->diffInSeconds(Carbon::parse($lastpunchoftheday));
                                                        if (($diffforgracetime_newlogic >= 0) && ($diffforgracetime_newlogic <= 3660)) {
                                                            $addgractime = 15 + 15;
                                                            $gracetime = Carbon::parse($value['shift_startdatetime'])->addMinutes($addgractime);
                                                            $overtimenight = 1;
                                                        }
                                                        elseif (($diffforgracetime_newlogic > 3660) && ($diffforgracetime_newlogic <= 7200)) {
                                                            $addgractime = 15 + 30;
                                                            $gracetime = Carbon::parse($value['shift_startdatetime'])->addMinutes($addgractime);
                                                            $overtimenight = 1;
                                                        }
                                                        elseif (($diffforgracetime_newlogic > 3660) && ($diffforgracetime_newlogic <= 7200)) {
                                                            $addgractime = 15 + 30;
                                                            $gracetime = Carbon::parse($value['shift_startdatetime'])->addMinutes($addgractime);
                                                            $overtimenight = 1;
                                                        }
                                                        elseif (($diffforgracetime_newlogic > 7200) && ($diffforgracetime_newlogic <= 10800)) {
                                                            $addgractime = 15 + 45;
                                                            $gracetime = Carbon::parse($value['shift_startdatetime'])->addMinutes($addgractime);
                                                            $overtimenight = 1;
                                                        }
                                                        else{
                                                            if($diffforgracetime_newlogic > 10800){
                                                                $addgractime = 15 + 60;
                                                                $gracetime = Carbon::parse($value['shift_startdatetime'])->addMinutes($addgractime);
                                                                $overtimenight = 1;
                                                            }
                                                        }
                                                    }
                                                }

                                               }
                                               if (Carbon::parse($attendance[$key]['first_half_considered_punches'][0])->gt($gracetime)) {
                                           $latecount = $latecount + 1;
                                           $attendance[$key]['latecount'] = 1;
                                           $diffinminutes = Carbon::parse($value['shift_startdatetime'])->diffInSeconds(Carbon::parse($attendance[$key]['first_half_considered_punches'][0]));
                                           $gmate = gmdate('H:i:s', $diffinminutes);
                                           if (($value['cadre'] == 'M') || ($value['shift_code'] == 'VGN_MGR')) {
                                               if (($diffinminutes > 1860) && ($diffinminutes <= 2700)) {
                                                   $laterange1 += 1;
                                                   $attendance[$key]['laterange1'] = $laterange1;
                                                    if ($attendance[$key]['latecount'] != 0) {
                                                       if (($attendance[$key]['laterange1'] % 4) == 0) {
                                                           $attendance[$key]['first_half_lop'] = 0.5;
                                                       }
                                                   }
                                               }
                                               if (($diffinminutes > 2700) && ($diffinminutes <= 3600)) {
                                                   $laterange2 += 1;
                                                   $attendance[$key]['laterange2'] = $laterange2;
                                                    if ($attendance[$key]['latecount'] != 0) {
                                                       if (($attendance[$key]['laterange2'] % 2) != 0) {
                                                           $attendance[$key]['first_half_lop'] = 0.5;
                                                       }
                                                   }
                                               }
                                               if ($diffinminutes > 3600) {
                                                   $laterange3 += 1;
                                                   $attendance[$key]['laterange3'] = $laterange3;
                                                    if ($attendance[$key]['latecount'] != 0) {
                                                       if ($attendance[$key]['laterange3'] != 0) {
                                                           $attendance[$key]['first_half_lop'] = 0.5;
                                                       }
       
                                                   }
                                               }
                                           }
                                           else{
                                               if (($diffinminutes > 960) && ($diffinminutes <= 1860)) {
                                                   $laterange1 += 1;
                                                   $attendance[$key]['laterange1'] = $laterange1;
                                                   if ($attendance[$key]['latecount'] != 0) {
                                                       if (($attendance[$key]['laterange1'] % 4) == 0) {
                                                           $attendance[$key]['first_half_lop'] = 0.5;
                                                       }
                                                   }
                                               }
                                               if (($diffinminutes > 1860) && ($diffinminutes <= 2700)) {
                                                   $laterange2 += 1;
                                                   $attendance[$key]['laterange2'] = $laterange2;
                                                   if ($attendance[$key]['latecount'] != 0) {
                                                       if (($attendance[$key]['laterange2'] % 2) != 0) {
                                                           $attendance[$key]['first_half_lop'] = 0.5;
                                                       }
                                                   }
                                               }
                                               if ($diffinminutes > 2700) {
                                                   $laterange3 += 1;
                                                   $attendance[$key]['laterange3'] = $laterange3;
                                                   if ($attendance[$key]['latecount'] != 0) {
                                                       if ($attendance[$key]['laterange3'] != 0) {
                                                           $attendance[$key]['first_half_lop'] = 0.5;
                                                       }
       
                                                   }
                                               }
                                           }
                                           $attendance[$key]['latein_hours'] = $gmate;         
       
                                       }
       
                                           }
                                           else{
                                               $attendance[$key]['first_half_lop'] = 0.5;
                                           }


                        
                                       
                                   }
                                   
                               }
                               if (count($value['lms_applications']) == 2) {

                                   if (($value['lms_applications'][0]->partial_days =='first_half') && ($value['lms_applications'][1]->partial_days =='second_half')) {
                                       $firsthalf = $value['lms_applications'][0];
                                       $secondhalf = $value['lms_applications'][1];
                                   }
                                   if (($value['lms_applications'][1]->partial_days =='first_half') && ($value['lms_applications'][0]->partial_days =='second_half')) {
                                       $firsthalf = $value['lms_applications'][1];
                                       $secondhalf = $value['lms_applications'][0];
                                   }


                                   if(($firsthalf->type =='Permission') && ($secondhalf->type !='Permission')){

                                       $explode_to_get_starttime = explode('-', $firsthalf->start_end_time);
                                       $add1minuteexception_topermission = Carbon::parse($value['shift_date'].' '.$explode_to_get_starttime[1])->addMinutes(16);

                                           if (($secondhalf->type =='LOP')) {
                                               //$attendance[$key]['second_half_lop'] = 0.5;
                                               $attendance[$key]['absent'] = 0.5;
                                           }
                                           $add1minuteexception = Carbon::parse($value['firsth_end_sech_starttime'])->subMinutes(30)->addMinutes(1);
                                           $sub1minuteexception = Carbon::parse($value['firsth_end_sech_starttime'])->subMinutes(30)->subMinutes(1);
       
                                       
                                           $checkforearlyout_permission= [];
                                           foreach ($attendance[$key]['punchlist'] as $ekey => $evalue) {
                                               if (Carbon::parse($evalue)->gte($sub1minuteexception)) {
                                                   $checkforearlyout_permission[] = $evalue;
                                               }    
                                           }
                                           if (empty($checkforearlyout_permission)) {
                                               if ($firsthalf->type =='Permission') {
                                               $attendance[$key]['earlyoutcount'] = 1;
                                               $attendance[$key]['first_half_lop'] = 0.5;
                                               }
                                               
                                           }


                                           $checkforleaveapp_late= [];
                                           foreach ($attendance[$key]['first_half_considered_punches'] as $pkey => $pvalue) {
                                               if (Carbon::parse($pvalue)->lte($add1minuteexception_topermission)) {
                                                   $checkforleaveapp_late[] = $pvalue;
                                               }    
                                           }
                                           if (empty($checkforleaveapp_late)) {
                                               $laterange3 += 1;
                                               $attendance[$key]['laterange3'] = $laterange3;
                                               $attendance[$key]['first_half_lop'] = 0.5;
                                           }


                                   }
                                   if(($firsthalf->type !='Permission') && ($secondhalf->type =='Permission')){

                                                   
                                       $explode_to_get_starttime = explode('-', $firsthalf->start_end_time);
                                       $sub1minuteexception_topermission = Carbon::parse($value['shift_date'].' '.$explode_to_get_starttime[0])->subMinutes(1);

                                           if (($firsthalf->type =='LOP')) {
                                               //$attendance[$key]['first_half_lop'] = 0.5;
                                               $attendance[$key]['absent'] = 0.5;
                                           }
                                           $add5minuteexception = Carbon::parse($value['firsth_end_sech_starttime'])->addMinutes(5);
                                           $sub1minuteexception = Carbon::parse($value['firsth_end_sech_starttime'])->subMinutes(1);
       
                                       
                                           $checkforearlyout_permission= [];
                                           foreach ($value['punchlist'] as $ekey => $evalue) {
                                               if (Carbon::parse($evalue)->gte($sub1minuteexception)) {
                                                   $checkforearlyout_permission[] = $evalue;
                                               }    
                                           }
                                           if (empty($checkforearlyout_permission)) {
                                               if ($secondhalf->type =='Permission') {
                                               $attendance[$key]['earlyoutcount'] = 1;
                                               $attendance[$key]['second_half_lop'] = 0.5;
                                               }
                                               
                                           }


                                           $checkforleaveapp_late= [];
                                           foreach ($attendance[$key]['first_half_considered_punches'] as $pkey => $pvalue) {
                                               if (Carbon::parse($pvalue)->lte($add5minuteexception)) {
                                                   $checkforleaveapp_late[] = $pvalue;
                                               }    
                                           }
                                           if (empty($checkforleaveapp_late)) {
                                               $laterange3 += 1;
                                               $attendance[$key]['laterange3'] = $laterange3;
                                               $attendance[$key]['second_half_lop'] = 0.5;
                                           }


                                       

                                   }
                                   
                               }


                   }
                   else{

                    if (count($value['lms_applications']) == 1) {

                        if($value['lms_applications'][0]->type == 'LOP'){
                            //$attendance[$key]['first_half_lop'] = 0.5;
                            //$attendance[$key]['second_half_lop'] = 0.5;
                            $attendance[$key]['absent'] = 1;
                        }
                        if($value['lms_applications'][0]->partial_days == 'first_half'){
                            if($value['lms_applications'][0]->type == 'LOP'){
                                //$attendance[$key]['first_half_lop'] = 0.5;
                                $attendance[$key]['absent'] = 0.5;
                            }
                            $attendance[$key]['second_half_lop'] = 0.5;
                        }
                        if($value['lms_applications'][0]->partial_days == 'second_half'){
                            if($value['lms_applications'][0]->type == 'LOP'){
                                //$attendance[$key]['second_half_lop'] = 0.5;
                                $attendance[$key]['absent'] = 0.5;
                            }
                            $attendance[$key]['first_half_lop'] = 0.5;
                        }
                    }
                    if (count($value['lms_applications']) == 2) {

                        if (($value['lms_applications'][0]->partial_days =='first_half') && ($value['lms_applications'][1]->partial_days =='second_half')) {
                            $firsthalf = $value['lms_applications'][0];
                            $secondhalf = $value['lms_applications'][1];
                        }
                        if (($value['lms_applications'][1]->partial_days =='first_half') && ($value['lms_applications'][0]->partial_days =='second_half')) {
                            $firsthalf = $value['lms_applications'][1];
                            $secondhalf = $value['lms_applications'][0];
                        }

                        if(($firsthalf->type =='Permission') && ($secondhalf->type !='Permission')){
                            if($secondhalf->type =='LOP'){
                               // $attendance[$key]['second_half_lop'] = 0.5;
                               $attendance[$key]['absent'] = 0.5;
                            }
                            $attendance[$key]['first_half_lop'] = 0.5;
                        }

                        if(($firsthalf->type !='Permission') && ($secondhalf->type =='Permission')){
                            if($firsthalf->type =='LOP'){
                                //$attendance[$key]['first_half_lop'] = 0.5;
                                $attendance[$key]['absent'] = 0.5;
                            }
                            $attendance[$key]['second_half_lop'] = 0.5;
                        }
                                          

                    }
                    

                   }
                   

                   
                   
               }else{
                   if (!empty($value['punchlist'])) {
                       //latecheck
                           if (($value['shift_code'] == 'VGN_FNIG') || ($value['shift_code'] == 'VGN_NIGT') || ($value['shift_code'] == 'VGN_FDAY')) {
                               $sub2hours_from_shift_starttime = Carbon::parse($value['shift_startdatetime'])->subHours(4);
                               $getshiftstartpunches = [];
                               $add5minutesgrace = Carbon::parse($value['firsth_end_sech_starttime'])->addMinutes(5);
                               foreach ($value['punchlist'] as $pkey => $pvalue) {
                                    if (Carbon::parse($pvalue)->gte($sub2hours_from_shift_starttime) && Carbon::parse($pvalue)->lte($add5minutesgrace)) {
                                         $getshiftstartpunches[] = $pvalue;
                                    }
                                   
                               }
                               $attendance[$key]['first_half_considered_punches'] = $getshiftstartpunches;
                               if($value['shift_code'] == 'VGN_NIGT'){

                                //start
                                if (!empty($attendance[$key]['first_half_considered_punches'])) {
                                    $newpunchlist = [];
                                    $overtimenight = 0;
                                    if (($value['cadre'] == 'M') || ($value['shift_code'] == 'VGN_MGR')) {
                                         $gracetime = Carbon::parse($value['shift_startdatetime'])->addMinutes(31);
 
                                     }
                                     else
                                     {
                                         $gracetime = Carbon::parse($value['shift_startdatetime'])->addMinutes(16); 
                                    
                                        
                                     }
                                     

                                     

                                    if (Carbon::parse($attendance[$key]['first_half_considered_punches'][0])->gt($gracetime)) {
                                $latecount = $latecount + 1;
                                $attendance[$key]['latecount'] = 1;
                                $diffinminutes = Carbon::parse($value['shift_startdatetime'])->diffInSeconds(Carbon::parse($attendance[$key]['first_half_considered_punches'][0]));
                                
                                $gmate = gmdate('H:i:s', $diffinminutes);
                                if (($value['cadre'] == 'M') || ($value['shift_code'] == 'VGN_MGR')) {
                                    if (($diffinminutes > 1860) && ($diffinminutes <= 2700)) {
                                        $laterange1 += 1;
                                        $attendance[$key]['laterange1'] = $laterange1;
                                         if ($attendance[$key]['latecount'] != 0) {
                                            if (($attendance[$key]['laterange1'] % 4) == 0) {
                                                $attendance[$key]['first_half_lop'] = 0.5;
                                            }
                                        }
                                    }
                                    if (($diffinminutes > 2700) && ($diffinminutes <= 3600)) {
                                        $laterange2 += 1;
                                        $attendance[$key]['laterange2'] = $laterange2;
                                         if ($attendance[$key]['latecount'] != 0) {
                                            if (($attendance[$key]['laterange2'] % 2) != 0) {
                                                $attendance[$key]['first_half_lop'] = 0.5;
                                            }
                                        }
                                    }
                                    if ($diffinminutes > 3600) {
                                        $laterange3 += 1;
                                        $attendance[$key]['laterange3'] = $laterange3;
                                         if ($attendance[$key]['latecount'] != 0) {
                                            if ($attendance[$key]['laterange3'] != 0) {
                                                $attendance[$key]['first_half_lop'] = 0.5;
                                            }
 
                                        }
                                    }
                                }
                                else{
                                    
                                    if (($diffinminutes > 960) && ($diffinminutes <= 1860)) {
                                        $laterange1 += 1;
                                        $attendance[$key]['laterange1'] = $laterange1;
                                        if ($attendance[$key]['latecount'] != 0) {
                                            if (($attendance[$key]['laterange1'] % 4) == 0) {
                                                $attendance[$key]['first_half_lop'] = 0.5;
                                            }
                                        }
                                    }
                                    if (($diffinminutes > 1860) && ($diffinminutes <= 2700)) {
                                        $laterange2 += 1;
                                        $attendance[$key]['laterange2'] = $laterange2;
                                        if ($attendance[$key]['latecount'] != 0) {
                                            if (($attendance[$key]['laterange2'] % 2) != 0) {
                                                $attendance[$key]['first_half_lop'] = 0.5;
                                            }
                                        }
                                    }
                                    if ($diffinminutes > 2700) {
                                        $laterange3 += 1;
                                        $attendance[$key]['laterange3'] = $laterange3;
                                        if ($attendance[$key]['latecount'] != 0) {
                                            if ($attendance[$key]['laterange3'] != 0) {
                                                $attendance[$key]['first_half_lop'] = 0.5;
                                            }
 
                                        }
                                    }
                                }
                                $attendance[$key]['latein_hours'] = $gmate;         
 
                            }
 
                                }
                                else{
                                    $attendance[$key]['first_half_lop'] = 0.5;
                                }
                                //end

                               }
                               else{
                                if (!empty($attendance[$key]['first_half_considered_punches'])) {
                                    $gracetime = Carbon::parse($value['shift_startdatetime'])->addMinutes(16);
                                    if (Carbon::parse($attendance[$key]['first_half_considered_punches'][0])->gt($gracetime)) {
                                        $latecount = $latecount + 1;
                                        $attendance[$key]['latecount'] = 1;
                                        $diffinminutes = Carbon::parse($value['shift_startdatetime'])->diffInSeconds(Carbon::parse($attendance[$key]['first_half_considered_punches'][0]));
                                        $gmate = gmdate('H:i:s', $diffinminutes);
                                        if (($value['cadre'] == 'M') || ($value['shift_code'] == 'VGN_MGR')) {
                                            if (($diffinminutes > 1860) && ($diffinminutes <= 2700)) {
                                                $laterange1 += 1;
                                                $attendance[$key]['laterange1'] = $laterange1;
                                                 if ($attendance[$key]['latecount'] != 0) {
                                                    if (($attendance[$key]['laterange1'] % 4) == 0) {
                                                        $attendance[$key]['first_half_lop'] = 0.5;
                                                    }
                                                }
                                            }
                                            if (($diffinminutes > 2700) && ($diffinminutes <= 3600)) {
                                                $laterange2 += 1;
                                                $attendance[$key]['laterange2'] = $laterange2;
                                                 if ($attendance[$key]['latecount'] != 0) {
                                                    if (($attendance[$key]['laterange2'] % 2) != 0) {
                                                        $attendance[$key]['first_half_lop'] = 0.5;
                                                    }
                                                }
                                            }
                                            if ($diffinminutes > 3600) {
                                                $laterange3 += 1;
                                                $attendance[$key]['laterange3'] = $laterange3;
                                                 if ($attendance[$key]['latecount'] != 0) {
                                                    if ($attendance[$key]['laterange3'] != 0) {
                                                        $attendance[$key]['first_half_lop'] = 0.5;
                                                    }
    
                                                }
                                            }
                                        }
                                        else{
                                            if (($diffinminutes > 960)) {
                                                $laterange1 += 1;
                                                $attendance[$key]['laterange1'] = $laterange1;
                                                if ($attendance[$key]['latecount'] != 0) {
                                                        $attendance[$key]['first_half_lop'] = 0.5;                                                        
                                                }
                                            }
                                            
                                        }
                                        $attendance[$key]['latein_hours'] = $gmate;         
    
                                    }
                                }
                                else{
                                    $attendance[$key]['first_half_lop'] = 0.5;
                                }

                               }

                               //earlyoutcount
                       if (($value['shift_code'] == 'VGN_FNIG') || ($value['shift_code'] == 'VGN_NIGT')) {
                           $minus_1minutesfrom_shiftendtime = Carbon::parse($value['shift_enddatetime'])->subMinutes(1);
                           $add1hourfrom_shiftendtime = Carbon::parse($value['shift_enddatetime'])->addHours(2);
                           $checkforleaveapp_earlyout= [];
                               foreach ($value['punchlist'] as $pkey => $pvalue) {
                                   if ((Carbon::parse($pvalue)->gte($minus_1minutesfrom_shiftendtime)) && (Carbon::parse($pvalue)->lt($add1hourfrom_shiftendtime))) {
                                       $checkforleaveapp_earlyout[] = $pvalue;
                                   }    
                               }

                               if ($value['shift_date'] == Carbon::parse($value['shift_date'])->endOfMonth()->toDateString()) {

                               	
                                $nextday = Carbon::parse($value['shift_date'])->addDays(1)->toDateString();
                                $getoverpunches = $this->getpunches($employeeid, $nextday, $nextday);
                                             $overarr = [];
                                             //dd($getpunches['Sorted_Punches']);
                                             $getovernewpunches = [];
                                             if (array_key_exists('0', $getoverpunches['Sorted_Punches'])) {
                                                 $getovernewpunches = $getoverpunches['Sorted_Punches'];
                                             }
                                             else{
                                                 $getovernewpunches[0] = $getoverpunches['Sorted_Punches'];
                                             }	

                                             if (!empty($getovernewpunches)) {
                                                  foreach ($getovernewpunches as $pkey1 => $pvalue1) {
                                                      $ndate = $pvalue1['Date'].' '.$pvalue1['Time'];
                                                      
                                                    if ((Carbon::parse($ndate)->gte($minus_1minutesfrom_shiftendtime)) && (Carbon::parse($ndate)->lt($add1hourfrom_shiftendtime))) {
                                                        $checkforleaveapp_earlyout[] = $ndate;
                                                    }    
                                                }
                                             }
                                    
                            

                        }
                        
                               if (empty($checkforleaveapp_earlyout)) {
                                   $attendance[$key]['earlyoutcount'] = 1;
                                   $attendance[$key]['second_half_lop'] = 0.5;
                                   //$diffinminutes_earlyout = Carbon::parse($value['punchlist'][count($value['punchlist']) - 1])->diffInSeconds(Carbon::parse($value['shift_enddatetime']));
                           //$gmate_earlyout = gmdate('H:i:s', $diffinminutes_earlyout);
                           //$attendance[$key]['earlyout_hours'] = $gmate_earlyout;
                               }

                       }
                       else{
                           $minus_1minutesfrom_shiftendtime = Carbon::parse($value['shift_enddatetime'])->subMinutes(1);
           if (Carbon::parse($value['punchlist'][count($value['punchlist']) - 1])->lt($minus_1minutesfrom_shiftendtime)) {
                   
               $attendance[$key]['earlyoutcount'] = 1;
               //$diffinminutes_earlyout = Carbon::parse($value['punchlist'][count($value['punchlist']) - 1])->diffInSeconds(Carbon::parse($value['shift_enddatetime']));
               //$gmate_earlyout = gmdate('H:i:s', $diffinminutes_earlyout);
               //$attendance[$key]['earlyout_hours'] = $gmate_earlyout;
               $attendance[$key]['second_half_lop'] = 0.5;         
           }
                       }

                       //earlyoutcount
                           }
                           else
                           {
                               $sub2hours_from_shift_starttime = Carbon::parse($value['shift_startdatetime'])->subHours(4);
                               $getshiftstartpunches = [];
                               $add5minutesgrace = Carbon::parse($value['firsth_end_sech_starttime'])->addMinutes(5);
                               foreach ($value['punchlist'] as $pkey => $pvalue) {
                                    if (Carbon::parse($pvalue)->gte($sub2hours_from_shift_starttime) && Carbon::parse($pvalue)->lte($add5minutesgrace)) {
                                         $getshiftstartpunches[] = $pvalue;
                                    }
                                   
                               }
                               $attendance[$key]['first_half_considered_punches'] = $getshiftstartpunches;
                               if (!empty($attendance[$key]['first_half_considered_punches'])) {
                                   $newpunchlist = [];
                                   $overtimenight = 0;
                                   if (($value['cadre'] == 'M') || ($value['shift_code'] == 'VGN_MGR')) {
                                        $gracetime = Carbon::parse($value['shift_startdatetime'])->addMinutes(31);

                                            $lastpunchoftheday = '';
                                            $addoneandhalfhourtoshiftendtime = '';
                                            $getstartofmonth = Carbon::parse($value['shift_date'])->startOfMonth()->toDateString();
                                            if ($getstartofmonth == $value['shift_date']) {
                                                $subonedayforcheckovertime = Carbon::parse($value['shift_date'])->subDay()->toDateString();

                                                $getoverpunches = $this->getpunches($employeeid, $subonedayforcheckovertime, $subonedayforcheckovertime);
                                                    $overarr = [];
                                                    //dd($getpunches['Sorted_Punches']);
                                                    $getovernewpunches = [];
                                                    if (array_key_exists('0', $getoverpunches['Sorted_Punches'])) {
                                                        $getovernewpunches = $getoverpunches['Sorted_Punches'];
                                                    }
                                                    else{
                                                        $getovernewpunches[0] = $getoverpunches['Sorted_Punches'];
                                                    }
                                                    foreach ($getovernewpunches as $overkey => $overvalue) {
                                                        if ($overvalue['Date'] != '') {
                                                            $overarr['punchlist'][] = $overvalue['Date'].' '.$overvalue['Time'];
                                                        }
                                                        
                                                    }

                                                    if (!empty($overarr)) {
                                                        
                                                        $newpunchlist['punchlist'] = $overarr['punchlist'];
                                                        $lastpunchoftheday = $newpunchlist['punchlist'][count($newpunchlist['punchlist']) - 1];

                                                        $getshiftdetailsnew = $this->getshiftdetailsst_et_date($employeeid, $subonedayforcheckovertime, $subonedayforcheckovertime);
                                                        $onegetshiftdetailsnew = [];
                                                        if (array_key_exists('0', $getshiftdetailsnew['Shift_Details'])) {
                                                            $onegetshiftdetailsnew = $getshiftdetailsnew['Shift_Details'];
                                                        }
                                                        else{
                                                            $onegetshiftdetailsnew[0] = $getshiftdetailsnew['Shift_Details'];
                                                        }
                                                        
                                                        foreach ($onegetshiftdetailsnew as $keyovershiftcode => $valueovershiftcode) {
                                                            $shiftendtimeforfirstendtime = $valueovershiftcode['Shift_Date'].' '.$valueovershiftcode['End_Time'];
                                                        }

                                                        $addoneandhalfhourtoshiftendtime = Carbon::parse($shiftendtimeforfirstendtime)->addMinutes(90)->toDateTimeString();
                                                        
                                                    }

                                            }
                                            else{
                                                $subonedayforcheckovertime = $key - 1;
                                                $newpunchlist['punchlist'] = $attendance[$subonedayforcheckovertime]['punchlist'];
                                                if (!empty($newpunchlist['punchlist'])) {
                                                    $lastpunchoftheday = $newpunchlist['punchlist'][count($newpunchlist['punchlist']) - 1];
                                                    $addoneandhalfhourtoshiftendtime = Carbon::parse($attendance[$subonedayforcheckovertime]['shift_enddatetime'])->addMinutes(90)->toDateTimeString();
                                                }
                                            }
                                        
                                        
                                        if (($lastpunchoftheday != '') && ($addoneandhalfhourtoshiftendtime != '')) {
                                            
                                            if (Carbon::parse($lastpunchoftheday)->gte(Carbon::parse($addoneandhalfhourtoshiftendtime))) {
                                                $diffforgracetime_newlogic = Carbon::parse($addoneandhalfhourtoshiftendtime)->diffInSeconds(Carbon::parse($lastpunchoftheday));
                                                if (($diffforgracetime_newlogic >= 0) && ($diffforgracetime_newlogic <= 3660)) {
                                                    $addgractime = 30 + 15;
                                                    $gracetime = Carbon::parse($value['shift_startdatetime'])->addMinutes($addgractime);
                                                    $overtimenight = 1;
                                                }
                                                elseif (($diffforgracetime_newlogic > 3660) && ($diffforgracetime_newlogic <= 7200)) {
                                                    $addgractime = 30 + 30;
                                                    $gracetime = Carbon::parse($value['shift_startdatetime'])->addMinutes($addgractime);
                                                    $overtimenight = 1;
                                                }
                                                elseif (($diffforgracetime_newlogic > 3660) && ($diffforgracetime_newlogic <= 7200)) {
                                                    $addgractime = 30 + 30;
                                                    $gracetime = Carbon::parse($value['shift_startdatetime'])->addMinutes($addgractime);
                                                    $overtimenight = 1;
                                                }
                                                elseif (($diffforgracetime_newlogic > 7200) && ($diffforgracetime_newlogic <= 10800)) {
                                                    $addgractime = 30 + 45;
                                                    $gracetime = Carbon::parse($value['shift_startdatetime'])->addMinutes($addgractime);
                                                    $overtimenight = 1;
                                                }
                                                else{
                                                    if($diffforgracetime_newlogic > 10800){
                                                        $addgractime = 30 + 60;
                                                        $gracetime = Carbon::parse($value['shift_startdatetime'])->addMinutes($addgractime);
                                                        $overtimenight = 1;
                                                    }
                                                }
                                            }
                                        }
                                        
                                        

                                    }
                                    else
                                    {
                                        $gracetime = Carbon::parse($value['shift_startdatetime'])->addMinutes(16); 
                                        
                                        $lastpunchoftheday = '';
                                        $addoneandhalfhourtoshiftendtime = '';
                                        $getstartofmonth = Carbon::parse($value['shift_date'])->startOfMonth()->toDateString();
                                        //   dd($value['shift_date']);
                                        if ($getstartofmonth == $value['shift_date']) {
                                            $subonedayforcheckovertime = Carbon::parse($value['shift_date'])->subDay()->toDateString();

                                            $getoverpunches = $this->getpunches($employeeid, $subonedayforcheckovertime, $subonedayforcheckovertime);
                                                $overarr = [];
                                                //dd($getpunches['Sorted_Punches']);
                                                $getovernewpunches = [];
                                                if (array_key_exists('0', $getoverpunches['Sorted_Punches'])) {
                                                    $getovernewpunches = $getoverpunches['Sorted_Punches'];
                                                }
                                                else{
                                                    $getovernewpunches[0] = $getoverpunches['Sorted_Punches'];
                                                }
                                                foreach ($getovernewpunches as $overkey => $overvalue) {
                                                    if ($overvalue['Date'] != '') {
                                                        $overarr['punchlist'][] = $overvalue['Date'].' '.$overvalue['Time'];
                                                    }
                                                    
                                                }

                                                if (!empty($overarr)) {
                                                    
                                                    $newpunchlist['punchlist'] = $overarr['punchlist'];
                                                    $lastpunchoftheday = $newpunchlist['punchlist'][count($newpunchlist['punchlist']) - 1];
                                                    $getshiftdetailsnew = $this->getshiftdetailsst_et_date($employeeid, $subonedayforcheckovertime, $subonedayforcheckovertime);
                                                    if (array_key_exists('0', $getshiftdetailsnew['Shift_Details'])) {
                                                        $onegetshiftdetailsnew = $getshiftdetailsnew['Shift_Details'];
                                                    }
                                                    else{
                                                        $onegetshiftdetailsnew[0] = $getshiftdetailsnew['Shift_Details'];
                                                    }
                                                    foreach ($onegetshiftdetailsnew as $keyovershiftcode => $valueovershiftcode) {
                                                        $shiftendtimeforfirstendtime = $valueovershiftcode['Shift_Date'].' '.$valueovershiftcode['End_Time'];
                                                    }

                                                    $addoneandhalfhourtoshiftendtime = Carbon::parse($shiftendtimeforfirstendtime)->addMinutes(90)->toDateTimeString();
                                                }

                                        }
                                        else{
                                            
                                            $subonedayforcheckovertime = $key - 1;
                                            
                                            $newpunchlist['punchlist'] = $attendance[$subonedayforcheckovertime]['punchlist'];
                                            if (!empty($newpunchlist['punchlist'])) {
                                                $lastpunchoftheday = $newpunchlist['punchlist'][count($newpunchlist['punchlist']) - 1];
                                                $addoneandhalfhourtoshiftendtime = Carbon::parse($attendance[$subonedayforcheckovertime]['shift_enddatetime'])->addMinutes(90)->toDateTimeString();
                                            }
                                        }
                                    
                                    
                                    if (($lastpunchoftheday != '') && ($addoneandhalfhourtoshiftendtime != '')) {
                                        if (Carbon::parse($lastpunchoftheday)->gte(Carbon::parse($addoneandhalfhourtoshiftendtime))) {
                                            $diffforgracetime_newlogic = Carbon::parse($addoneandhalfhourtoshiftendtime)->diffInSeconds(Carbon::parse($lastpunchoftheday));
                                            if (($diffforgracetime_newlogic >= 0) && ($diffforgracetime_newlogic <= 3660)) {
                                                $addgractime = 15 + 15;
                                                $gracetime = Carbon::parse($value['shift_startdatetime'])->addMinutes($addgractime);
                                                $overtimenight = 1;
                                            }
                                            elseif (($diffforgracetime_newlogic > 3660) && ($diffforgracetime_newlogic <= 7200)) {
                                                $addgractime = 15 + 30;
                                                $gracetime = Carbon::parse($value['shift_startdatetime'])->addMinutes($addgractime);
                                                $overtimenight = 1;
                                            }
                                            elseif (($diffforgracetime_newlogic > 3660) && ($diffforgracetime_newlogic <= 7200)) {
                                                $addgractime = 15 + 30;
                                                $gracetime = Carbon::parse($value['shift_startdatetime'])->addMinutes($addgractime);
                                                $overtimenight = 1;
                                            }
                                            elseif (($diffforgracetime_newlogic > 7200) && ($diffforgracetime_newlogic <= 10800)) {
                                                $addgractime = 15 + 45;
                                                $gracetime = Carbon::parse($value['shift_startdatetime'])->addMinutes($addgractime);
                                                $overtimenight = 1;
                                            }
                                            else{
                                                if($diffforgracetime_newlogic > 10800){
                                                    $addgractime = 15 + 60;
                                                    $gracetime = Carbon::parse($value['shift_startdatetime'])->addMinutes($addgractime);
                                                    $overtimenight = 1;
                                                }
                                            }
                                        }
                                    }
                                       
                                    }
                                   if (Carbon::parse($attendance[$key]['first_half_considered_punches'][0])->gt($gracetime)) {
                               $latecount = $latecount + 1;
                               $attendance[$key]['latecount'] = 1;
                               $diffinminutes = Carbon::parse($value['shift_startdatetime'])->diffInSeconds(Carbon::parse($attendance[$key]['first_half_considered_punches'][0]));
                               $gmate = gmdate('H:i:s', $diffinminutes);
                               if (($value['cadre'] == 'M') || ($value['shift_code'] == 'VGN_MGR')) {
                                   if (($diffinminutes > 1860) && ($diffinminutes <= 2700)) {
                                       $laterange1 += 1;
                                       $attendance[$key]['laterange1'] = $laterange1;
                                        if ($attendance[$key]['latecount'] != 0) {
                                           if (($attendance[$key]['laterange1'] % 4) == 0) {
                                               $attendance[$key]['first_half_lop'] = 0.5;
                                           }
                                       }
                                   }
                                   if (($diffinminutes > 2700) && ($diffinminutes <= 3600)) {
                                       $laterange2 += 1;
                                       $attendance[$key]['laterange2'] = $laterange2;
                                        if ($attendance[$key]['latecount'] != 0) {
                                           if (($attendance[$key]['laterange2'] % 2) != 0) {
                                               $attendance[$key]['first_half_lop'] = 0.5;
                                           }
                                       }
                                   }
                                   if ($diffinminutes > 3600) {
                                       $laterange3 += 1;
                                       $attendance[$key]['laterange3'] = $laterange3;
                                        if ($attendance[$key]['latecount'] != 0) {
                                           if ($attendance[$key]['laterange3'] != 0) {
                                               $attendance[$key]['first_half_lop'] = 0.5;
                                           }

                                       }
                                   }
                               }
                               else{
                                   if (($diffinminutes > 960) && ($diffinminutes <= 1860)) {
                                       $laterange1 += 1;
                                       $attendance[$key]['laterange1'] = $laterange1;
                                       if ($attendance[$key]['latecount'] != 0) {
                                           if (($attendance[$key]['laterange1'] % 4) == 0) {
                                               $attendance[$key]['first_half_lop'] = 0.5;
                                           }
                                       }
                                   }
                                   if (($diffinminutes > 1860) && ($diffinminutes <= 2700)) {
                                       $laterange2 += 1;
                                       $attendance[$key]['laterange2'] = $laterange2;
                                       if ($attendance[$key]['latecount'] != 0) {
                                           if (($attendance[$key]['laterange2'] % 2) != 0) {
                                               $attendance[$key]['first_half_lop'] = 0.5;
                                           }
                                       }
                                   }
                                   if ($diffinminutes > 2700) {
                                       $laterange3 += 1;
                                       $attendance[$key]['laterange3'] = $laterange3;
                                       if ($attendance[$key]['latecount'] != 0) {
                                           if ($attendance[$key]['laterange3'] != 0) {
                                               $attendance[$key]['first_half_lop'] = 0.5;
                                           }

                                       }
                                   }
                               }
                               $attendance[$key]['latein_hours'] = $gmate;         

                           }

                               }
                               else{
                                   $attendance[$key]['first_half_lop'] = 0.5;
                               }

                       //earlyoutcount
                       if (($value['shift_code'] == 'VGN_FNIG') || ($value['shift_code'] == 'VGN_NIGT')) {
                           $minus_1minutesfrom_shiftendtime = Carbon::parse($value['shift_enddatetime'])->subMinutes(1);
                           $add1hourfrom_shiftendtime = Carbon::parse($value['shift_enddatetime'])->addHours(2);
                           $checkforleaveapp_earlyout= [];
                               foreach ($value['punchlist'] as $pkey => $pvalue) {
                                   if ((Carbon::parse($pvalue)->gte($minus_1minutesfrom_shiftendtime)) && (Carbon::parse($pvalue)->lt($add1hourfrom_shiftendtime))) {
                                       $checkforleaveapp_earlyout[] = $pvalue;
                                   }    
                               }


                               if (empty($checkforleaveapp_earlyout)) {
                                   $attendance[$key]['earlyoutcount'] = 1;
                                   $attendance[$key]['second_half_lop'] = 0.5;
                                   //$diffinminutes_earlyout = Carbon::parse($value['punchlist'][count($value['punchlist']) - 1])->diffInSeconds(Carbon::parse($value['shift_enddatetime']));
                           //$gmate_earlyout = gmdate('H:i:s', $diffinminutes_earlyout);
                           //$attendance[$key]['earlyout_hours'] = $gmate_earlyout;
                               }

                       }
                       else{
                           $minus_1minutesfrom_shiftendtime = Carbon::parse($value['shift_enddatetime'])->subMinutes(1);
           if (Carbon::parse($value['punchlist'][count($value['punchlist']) - 1])->lt($minus_1minutesfrom_shiftendtime)) {
                   
               $attendance[$key]['earlyoutcount'] = 1;
               //$diffinminutes_earlyout = Carbon::parse($value['punchlist'][count($value['punchlist']) - 1])->diffInSeconds(Carbon::parse($value['shift_enddatetime']));
               //$gmate_earlyout = gmdate('H:i:s', $diffinminutes_earlyout);
               //$attendance[$key]['earlyout_hours'] = $gmate_earlyout;
               $attendance[$key]['second_half_lop'] = 0.5;         
           }
                       }

                       //earlyoutcount
                           }
                       //latecheck

                   }else{
                      
                       $attendance[$key]['absent'] = 1;
                       
                   }
               }
            }

            if (($attendance[$key]['first_half_lop'] == 0) && ($attendance[$key]['second_half_lop'] == 0) && ($attendance[$key]['absent'] == 0)) {
               $attendance[$key]['present'] = 1;
            }
            else{
                if($attendance[$key]['absent'] == 0){
                   $attendance[$key]['present'] = 1 - ($attendance[$key]['first_half_lop'] + $attendance[$key]['second_half_lop']);
                }
                else{
                   $attendance[$key]['present'] = 1 - ($attendance[$key]['absent']);
                }
            }
        }
       }

       return $attendance;

    }
}

?>
