<?php

namespace vgn\Providers;

use Illuminate\Support\ServiceProvider;
use Validator;
use vgn\Http\Traits\LMS\checkandprocess_logictrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DB;
use Crypt;

class LMSBeforevalidatonServiceProvider extends ServiceProvider
{
    use checkandprocess_logictrait;
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('lessthancurrentdate', function($attribute, $value, $parameters, $validator) {
          
            
            if (strpos($value, '-') !== false){
                $splitrange = explode('-',$value);
                $start_date = $this->dateformatreturnddmmyytoyymmdd(trim($splitrange[0]));
                $end_date = $this->dateformatreturnddmmyytoyymmdd(trim($splitrange[1]));
            }
            else{
                $start_date = $this->dateformatreturnddmmyytoyymmdd(trim($value));
                $end_date = $this->dateformatreturnddmmyytoyymmdd(trim($value));
            }

            $applicationstartdate = Carbon::parse($start_date);
            $currentdateformatstring = Carbon::now()->toDateString();
            $presentdate = Carbon::parse($currentdateformatstring);
			
			$encrypt = session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $employeeid = $split[0];
			
			
			
            $dd = DB::connection('mysql6')->table('delete_leave_applications_reference')->where(['employeeid' => $employeeid, 'date' => Carbon::parse($applicationstartdate)->toDateString()])->get();
			//dd($dd);
             if (count($dd) > 0) {
                return true;
            } 
			
			$checklessthancurrentdate = $applicationstartdate->gte($presentdate);
    
            return $checklessthancurrentdate;

        });

	Validator::extend('newjoineevalidation', function($attribute, $value, $parameters, $validator) {

            if (strpos($value, '-') !== false){
                $splitrange = explode('-',$value);
                $start_date = $this->dateformatreturnddmmyytoyymmdd(trim($splitrange[0]));
                $end_date = $this->dateformatreturnddmmyytoyymmdd(trim($splitrange[1]));
            }
            else{
                $start_date = $this->dateformatreturnddmmyytoyymmdd(trim($value));
                $end_date = $this->dateformatreturnddmmyytoyymmdd(trim($value));
            }

               $encrypt = session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $employeeid = $split[0];
            
          
          

            $dd = DB::connection('mysql6')->table('employee')->where(['id' => $employeeid])->get();

            if (count($dd) > 0) {
                foreach ($dd as $key1 => $value1) {
                    $doj = $value1->doj;
                }
            }
            else{
                return false;
            }

            $add30days = Carbon::parse($doj)->addDays(30)->toDateString();
            //dd(Carbon::parse($start_date.' 00:00:00')->lte(Carbon::parse($add30days.' 23:59:59')));
            //'2021-03-04 00:00:00' <= '2021-03-03 23:59:59'
            if (Carbon::parse($start_date.' 00:00:00')->gt(Carbon::parse($add30days.' 00:00:00'))) {
                return true;
            }
            else{
                return false;
            }

           

            

        });

        Validator::extend('currentmonth', function($attribute, $value, $parameters, $validator) {

            if (strpos($value, '-') !== false){
                $splitrange = explode('-',$value);
                $start_date = $this->dateformatreturnddmmyytoyymmdd(trim($splitrange[0]));
                $end_date = $this->dateformatreturnddmmyytoyymmdd(trim($splitrange[1]));
            }
            else{
                $start_date = $this->dateformatreturnddmmyytoyymmdd(trim($value));
                $end_date = $this->dateformatreturnddmmyytoyymmdd(trim($value));
            }
            
          
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

        });

	Validator::extend('only3mispunchallowedpermonth', function($attribute, $value, $parameters, $validator) {
          
            
            if (strpos($value, '-') !== false){
                $splitrange = explode('-',$value);
                $start_date = $this->dateformatreturnddmmyytoyymmdd(trim($splitrange[0]));
                $end_date = $this->dateformatreturnddmmyytoyymmdd(trim($splitrange[1]));
            }
            else{
                $start_date = $this->dateformatreturnddmmyytoyymmdd(trim($value));
                $end_date = $this->dateformatreturnddmmyytoyymmdd(trim($value));
            }

            $applicationmonth = Carbon::parse($start_date)->format('m');
            $applicationyear = Carbon::parse($start_date)->format('Y');
            //dd($applicationyear);
            //$currentdateformatstring = Carbon::now()->toDateString();
            //$presentdate = Carbon::parse($currentdateformatstring);
            
            $encrypt = session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $employeeid = $split[0];
            
            
            
            $dd = DB::connection('mysql6')->table('datetime_ref')->where(['employeeid' => $employeeid, 'month' => $applicationmonth, 'year' => $applicationyear,'type' => 'Mispunch'])->whereIn('final_status',['Approved','Pending'])->count();
            //dd($dd);
             if ($dd >= 3) {
                return false;
            } 
            
            //$checklessthancurrentdate = $applicationstartdate->gte($presentdate);
    
            return true;

        });

        /*Validator::extend('isprevnextdateapplicationsmeetup', function($attribute, $value, $parameters, $validator) {

            $encrypt = session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $employeeid = $split[0];

            $splitrange = explode('-',$value);
            $start_date = $this->dateformatreturnddmmyytoyymmdd(trim($splitrange[0]));
            $end_date = $this->dateformatreturnddmmyytoyymmdd(trim($splitrange[1]));
            $req = $validator->getData();
          
            $startdate = Carbon::parse($start_date)->addDay()->toDateTimeString();
            $substartdate = Carbon::parse($start_date)->subDay()->toDateTimeString();
            $enddate = Carbon::parse($end_date)->addDay()->toDateTimeString();
            $subenddate = Carbon::parse($end_date)->subDay()->toDateTimeString();

            $leave_type =   $req['leave_type'];
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
                return false;
            }else{
                if (($substartdatecheck > 0) || ($subenddatecheck > 0)) {
                    return false;
                }
                return true;
            }

        });*/

        Validator::extend('checkappliedleaves', function($attribute, $value, $parameters, $validator) {
            
            $encrypt = session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $employeeid = $split[0];

            if (strpos($value, '-') !== false){
                $splitrange = explode('-',$value);
                $start_date = $this->dateformatreturnddmmyytoyymmdd(trim($splitrange[0]));
                $end_date = $this->dateformatreturnddmmyytoyymmdd(trim($splitrange[1]));
            }
            else{
                $start_date = $this->dateformatreturnddmmyytoyymmdd(trim($value));
                $end_date = $this->dateformatreturnddmmyytoyymmdd(trim($value));
            }
            
            $startdatecheck =  DB::connection('mysql6')->table('lms_applications')->where(['employeeid' => $employeeid])->whereRaw('"'.$start_date.'" between `start_date` and `end_date`')->whereIn('final_status', ['Approved','Pending'])->get();
            $enddatecheck =  DB::connection('mysql6')->table('lms_applications')->where(['employeeid' => $employeeid])->whereRaw('"'.$end_date.'" between `start_date` and `end_date`')->whereIn('final_status', ['Approved','Pending'])->get();
            $betweencheck =  DB::connection('mysql6')->table('lms_applications')->where(['employeeid' => $employeeid])->whereRaw('`start_date` >= "'.$start_date.'" and `end_date` <= "'.$end_date.'"')->whereIn('final_status', ['Approved','Pending'])->get();
            
            if((count($startdatecheck) == 0) && (count($enddatecheck) == 0) && (count($betweencheck) == 0) ){
                return true;
            }else{
                return false;
            }

        });

        Validator::extend('leavecountcheck', function($attribute, $value, $parameters, $validator) {
            
            $encrypt = session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $employeeid = $split[0];

            $req = $validator->getData();

            $splitrange = explode('-',$req['leave_date_range']);
            $start_date = $this->dateformatreturnddmmyytoyymmdd(trim($splitrange[0]));
            $end_date = $this->dateformatreturnddmmyytoyymmdd(trim($splitrange[1]));
            $diff = $this->formatforempdat_differbtwtwodates($start_date, $end_date);
            $getyearenddate = Carbon::now()->endOfYear();
            
            $enddate_parse = Carbon::parse($end_date);

            $leave_type =   $req['leave_type'];
            $partial_days =   $value;

            $checkendofyear = $enddate_parse->gt($getyearenddate);
            if ($checkendofyear == true) {
                return false;
            }

          $current_date = Carbon::now()->toDateString();

            $year = $this->returnyear($current_date);
            $month = $this->returnmonth($current_date);
            
         
            $getleavecount =  DB::connection('mysql6')->table('leave_balance')->where('employeeid', $employeeid)
                             ->where(['year' => $year, 'month' => $month])
                             ->get();
                             
                             $applieddays = $this->differbtwtwodates($start_date, $end_date);
                             if(count($getleavecount) == 0){
                                 return false;
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

        });

        Validator::extend('maternity_weeks', function($attribute, $value, $parameters, $validator) {

            $splitrange = explode('-',$value);
            $start_date = $this->dateformatreturnddmmyytoyymmdd(trim($splitrange[0]));
            $end_date = $this->dateformatreturnddmmyytoyymmdd(trim($splitrange[1]));
            
        $applicationstartdate = Carbon::parse($start_date);
        $applicationenddate = Carbon::parse($end_date);
        
        $diffindays = $applicationstartdate->diffInDays($applicationenddate);
        
        if (($diffindays > 182) || ($diffindays < 7)) {
            return false;
        }
        
        return true;

        });

        Validator::extend('onlyyesterdayandtoday', function($attribute, $value, $parameters, $validator) {

            if (strpos($value, '-') !== false){
                $splitrange = explode('-',$value);
                $start_date = $this->dateformatreturnddmmyytoyymmdd(trim($splitrange[0]));
                $end_date = $this->dateformatreturnddmmyytoyymmdd(trim($splitrange[1]));
            }
            else{
                $start_date = $this->dateformatreturnddmmyytoyymmdd(trim($value));
                $end_date = $this->dateformatreturnddmmyytoyymmdd(trim($value));
            }
            
        $applicationstartdate = Carbon::parse($start_date);
        $subdayfrompresentday = Carbon::now()->subDay()->toDateString();
        $subdayfrompresentnewday = Carbon::parse($subdayfrompresentday);
        $check = $applicationstartdate->gte($subdayfrompresentnewday);
        $currentdate = Carbon::now()->toDateString();
        $check1 = $applicationstartdate->gte(Carbon::parse($currentdate));
        if (($check == false) && ($check1 == false)) {
            return false;
        }
                             
        return true;

        });

        Validator::extend('onlypast2days', function($attribute, $value, $parameters, $validator) {

            if (strpos($value, '-') !== false){
                $splitrange = explode('-',$value);
                $start_date = $this->dateformatreturnddmmyytoyymmdd(trim($splitrange[0]));
                $end_date = $this->dateformatreturnddmmyytoyymmdd(trim($splitrange[1]));
            }
            else{
                $start_date = $this->dateformatreturnddmmyytoyymmdd(trim($value));
                $end_date = $this->dateformatreturnddmmyytoyymmdd(trim($value));
            }
            
        $applicationstartdate = Carbon::parse($start_date);
        $subdayfrompresentday = Carbon::now()->subDays(2)->toDateString();
        $subdayfrompresentnewday = Carbon::parse($subdayfrompresentday);
        $check = $applicationstartdate->gte($subdayfrompresentnewday);
                             
        return $check;

        });

        Validator::extend('permissionhours', function($attribute, $value, $parameters, $validator) {

            
            
            //$start_date = $this->dateformatreturnddmmyytoyymmdd(trim($splitrange[0]));
            //$end_date = $this->dateformatreturnddmmyytoyymmdd(trim($splitrange[1]));
            $req = $validator->getData();
            $getdatetimedbformat = $this->getdatetimedbformat($req['leave_date_range']);
            
                        
            $carbonstarttime = Carbon::parse($getdatetimedbformat['starttime'], 'Asia/Kolkata');
            $carbonendtime = Carbon::parse($getdatetimedbformat['endtime'], 'Asia/Kolkata');
            
            if($carbonendtime->diffInMinutes($carbonstarttime) == '90'){
                return true;
            }
            else{
                return false;
            }
    
            });

            Validator::extend('ismatch_with_shifttimings', function($attribute, $value, $parameters, $validator) {

                $encrypt = session()->get('employeesession');
                $decrypt = Crypt::decrypt($encrypt);
                $split = explode("-",$decrypt);
                $employeeid = $split[0];

                $req = $validator->getData();
                $partial_days = $value;

                $splitrange = explode('-',$req['leave_date_range']);
                
                //$start_date = $this->dateformatreturnddmmyytoyymmdd(trim($splitrange[0]));
                //$end_date = $this->dateformatreturnddmmyytoyymmdd(trim($splitrange[1]));
                $getdatetimedbformat = $this->getdatetimedbformat($req['leave_date_range']);
                
                $starttime = $getdatetimedbformat['starttime'];
                $endtime = $getdatetimedbformat['endtime'];
                $year = Carbon::parse($starttime, 'Asia/Kolkata')->year;
                $month = Carbon::parse($starttime, 'Asia/Kolkata')->format('m');
                
                $start_date = substr($starttime, 0,10);
                
                
                $getshiftadatetime = $this->getshiftdetailsst_et_date($employeeid, $start_date, $start_date);
                //dd($partial_days);

                $sapoverallshiftdetails = $this->shiftdetails();
                //dd($sapoverallshiftdetails);

                //newcode
                    foreach ($sapoverallshiftdetails['Shift_Details'] as $key => $value) {
                        if($value['Shift_Code'] == $getshiftadatetime['Shift_Details']['Shift_Code']){
                            $manipstartdatetime = $start_date.' '.$value['Start_Time'];
                            $manipenddatetime = $start_date.' '.$value['End_Time'];

                            if ($partial_days == 'first_half') {
                                if ($manipstartdatetime == $starttime) {
                                    return true;
                                }
                            }

                            if ($partial_days == 'second_half') {
                                if ($manipenddatetime == $endtime) {
                                    return true;
                                }
                            }
                        }
                    }

                    return false;
                //newcode
        

                // $sapattendance = $this->mycommonattendance($employeeid, $starttime, $endtime);


                // foreach ($sapattendance as $key => $value1) {
                //     if (($value1['shift_name'] == 'VGN HO G') || ($value1['shift_name'] == 'VGN HO GENERAL SHIFT')) {
                //         $sapstartdate = $value1['attendancedate'].' '.$value1['shift_start'];
                //         $sapenddate = $value1['attendancedate'].' '.$value1['shift_end'];
                        
                //         if ($partial_days == 'first_half') {
                //             if ($sapstartdate == $starttime) {
                //                 return true;
                //             }
                //         }

                //         if ($partial_days == 'second_half') {
                //             if ($sapenddate == $endtime) {
                //                 return true;
                //             }
                //         }
                //     }
                    

                // }

                // return false;
                
        
                });

                Validator::extend('permissioncount', function($attribute, $value, $parameters, $validator) {

                    $encrypt = session()->get('employeesession');
                    $decrypt = Crypt::decrypt($encrypt);
                    $split = explode("-",$decrypt);
                    $employeeid = $split[0];
    
                    $req = $validator->getData();
                    $partial_days = $value;
                    $leave_type = $req['leave_type'];
    
                   // $splitrange = explode('-',$req['leave_date_range']);
                    
                    $start_date = $this->dateformatreturnddmmyytoyymmdd(trim($req['leave_date_range']));
                    //$end_date = $this->dateformatreturnddmmyytoyymmdd(trim($splitrange[1]));
                    //$getdatetimedbformat = $this->getdatetimedbformat($req['leave_date_range']);
                    
                   // $start_date = Carbon::parse($getdatetimedbformat['starttime'])->toDateString();
                   // $end_date = Carbon::parse($getdatetimedbformat['endtime'])->toDateString();
                    
                    $year = $this->returnyear($start_date);
                    $month = $this->returnmonth($start_date);
                     
                     $getleavecount =  DB::connection('mysql6')->table('leave_balance')->where(['employeeid'=> $employeeid])
                                         ->where(['year' => $year, 'month' => $month])
                                         ->get();
                                         
                                         
                                         $applieddays = $this->differbtwtwodates($start_date, $start_date);
                                         
                                         if(count($getleavecount) == 0){
                                             return false;
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
    
                    
                    
            
                    });

			Validator::extend('secondsatperm_hodisable', function($attribute, $value, $parameters, $validator) {

                $encrypt = session()->get('employeesession');
                $decrypt = Crypt::decrypt($encrypt);
                $split = explode("-",$decrypt);
                $employeeid = $split[0];



                $req = $validator->getData();
                $partial_days = $value;

                $splitrange = explode('-',$req['leave_date_range']);
                
                                
                $start_date = $this->dateformatreturnddmmyytoyymmdd(trim($req['leave_date_range']));
                $year = $this->returnyear($start_date);
                $month = $this->returnmonth($start_date);
                //dd($month);
                
                
                $getshiftadatetime = $this->getshiftdetailsst_et_date($employeeid, $start_date, $start_date);
                
                //dd($getshiftadatetime);

                if (($getshiftadatetime['Shift_Details']['Shift_Code'] == 'VGN_GEN') || ($getshiftadatetime['Shift_Details']['Shift_Code'] == 'VGN_DRV')  || ($getshiftadatetime['Shift_Details']['Shift_Code'] == 'VGN_RCP1')  || ($getshiftadatetime['Shift_Details']['Shift_Code'] == 'VGN_RCP2')) {
                    $fmonth = Carbon::parse($start_date)->format('F');
                                            $bt = new \DateTime("second sat of $fmonth $year");
                                            
                                            $btcarbon = Carbon::instance($bt)->toDateString(); 
                                            if ($btcarbon == $start_date) {
                                                    return false;
                                            }
                }



                    return true;
                
                
        
                });

                    Validator::extend('onlypast3days', function($attribute, $value, $parameters, $validator) {
                        $start_date = $this->dateformatreturnddmmyytoyymmdd(trim($value));
                        $applicationstartdate = Carbon::parse($start_date);
                        $currentdateformatstring = Carbon::now()->toDateString();
                        $presentdate = Carbon::parse($currentdateformatstring);
						
						$encrypt = session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $employeeid = $split[0];

                        $checkgreaterthancurrentdate = $applicationstartdate->gt($presentdate);
                        $getlast3daysfromnow = Carbon::now()->subDays(3)->toDateString();

                        $checklessthan3days = Carbon::parse($applicationstartdate)->lt(Carbon::parse($getlast3daysfromnow));
                        
                            if(($checklessthan3days == true) || ($checkgreaterthancurrentdate) == true ){
								$dd = DB::connection('mysql6')->table('delete_leave_applications_reference')->where(['employeeid' => $employeeid, 'date' => Carbon::parse($applicationstartdate)->toDateString()])->get();
                                                if (count($dd) > 0) {
                                                    return true;
                                                }
                            return false;
                            }

                            return true;
        
                        
                        
                
                        });

                        Validator::extend('onlypast3_futuredays', function($attribute, $value, $parameters, $validator) {
                            $splitrange = explode('-',$value);
                            $start_date = $this->dateformatreturnddmmyytoyymmdd(trim($splitrange[0]));
                            $end_date = $this->dateformatreturnddmmyytoyymmdd(trim($splitrange[1]));
                            
                            $applicationstartdate = Carbon::parse($start_date);
                            $applicationenddate = Carbon::parse($end_date);
                            $currentdateadd30daysstring = Carbon::now()->addDays(30);
                            
                    
                            $checkgreaterthan30endate = $applicationenddate->gt($currentdateadd30daysstring);
                            $getlast3daysfromnow = Carbon::now()->subDays(3)->toDateString();
                    
                            $checklessthan3days = Carbon::parse($applicationstartdate)->lt(Carbon::parse($getlast3daysfromnow));
                            
                                if(($checklessthan3days == true) || ($checkgreaterthan30endate) == true ){
                                return false;
                                }
                    
                                return true;
                            
                            
                    
                            });

                            Validator::extend('onlynext15days', function($attribute, $value, $parameters, $validator) {
                                $splitrange = explode('-',$value);
                                $start_date = $this->dateformatreturnddmmyytoyymmdd(trim($splitrange[0]));
                                $end_date = $this->dateformatreturnddmmyytoyymmdd(trim($splitrange[1]));
                                
                                $applicationstartdate = Carbon::parse($start_date);
                                $applicationenddate = Carbon::parse($end_date);
                                $currentdateadd15daysstring = Carbon::now()->addDays(15);
                                
                        
                                $checkgreaterthan30endate = $applicationenddate->gt($currentdateadd15daysstring);
                                
                        
                                $checklessthantoday = Carbon::parse($applicationstartdate)->lt(Carbon::now());
                                
                                
                                    if(($checklessthantoday == true) || ($checkgreaterthan30endate) == true ){
                                    return false;
                                    }
                        
                                    return true;
                                
                                
                                    
                                });




/**
 * new
 */

                                Validator::extend('isprevnextdateapplicationsmeetup_new', function($attribute, $value, $parameters, $validator) {

                                    $encrypt = session()->get('employeesession');
                                    $decrypt = Crypt::decrypt($encrypt);
                                    $split = explode("-",$decrypt);
                                    $employeeid = $split[0];
                                    
                                    $req = $validator->getData();
                                    $splitrange = explode('-',$req['leave_date_range']);
                                    $start_date = $this->dateformatreturnddmmyytoyymmdd(trim($splitrange[0]));
                                    $end_date = $this->dateformatreturnddmmyytoyymmdd(trim($splitrange[1]));
                                    $partial_days = $value;                                   

                                    $daterange_array = $this->createDateRange($start_date, $end_date, $format = "Y-m-d");
                                    array_push($daterange_array, $end_date);

                                    $leave_type =   $req['leave_type'];
                                    if($leave_type == 'CL') { $typenotallowed = ['SL', 'PL', 'RH', 'ML']; }
                                    if($leave_type == 'SL') { $typenotallowed = ['CL', 'PL', 'RH', 'ML']; }
                                    if($leave_type == 'PL') { $typenotallowed = ['SL', 'CL', 'RH', 'ML']; }
                                    if($leave_type == 'RH') { $typenotallowed = ['SL', 'PL', 'CL', 'ML']; }
                                    if($leave_type == 'ML') { $typenotallowed = ['SL', 'PL', 'CL', 'RH']; }

                                    $addstartdatenew = Carbon::parse($start_date)->addDay()->toDateString();
                                    $substartdatenew = Carbon::parse($start_date)->subDay()->toDateString();

                                    $getprev_stdate = DB::connection('mysql6')->table('datetime_ref')->where(['employeeid' => $employeeid, 'date' =>$addstartdatenew  ])->whereIn('type', $typenotallowed)->whereIn('final_status', ['Approved','Pending'])->get()->toArray();
                                    $getprev_etdate = DB::connection('mysql6')->table('datetime_ref')->where(['employeeid' => $employeeid, 'date' =>$substartdatenew  ])->whereIn('type', $typenotallowed)->whereIn('final_status', ['Approved','Pending'])->get()->toArray();
                                    
                                    if (!empty($getprev_stdate) || !empty($getprev_etdate)) {
                                        $getshiftadatetime = $this->getshiftdetailsst_et_date($employeeid, $getprev_etdate[0]->date, $getprev_etdate[0]->date);
                                        dd($getshiftadatetime);
                                        //check the start and end time on that date 9 - 18:30
                                        //actual punches list on that date 14:30
                                        //sl applied 9 - 13:30
                                        
                                    }

                                    $addedstartdatecount = 0;
                                    $substartdatecount = 0;
                                    foreach ($daterange_array as $key => $value) {
                                    $startdate = Carbon::parse($value)->addDay()->toDateString();
                                    $substartdate = Carbon::parse($value)->subDay()->toDateString();
                                   
                        
                                   

                                    $addedstartdatecount += DB::connection('mysql6')->table('datetime_ref')->where(['employeeid' => $employeeid, 'date' =>$startdate  ])->whereIn('type', $typenotallowed)->whereIn('final_status', ['Approved','Pending'])->count();
                                    $substartdatecount += DB::connection('mysql6')->table('datetime_ref')->where(['employeeid' => $employeeid, 'date' =>$substartdate  ])->whereIn('type', $typenotallowed)->whereIn('final_status', ['Approved','Pending'])->count();
                                                                                                            
                                    }
                                    
                                    
                                    if(($addedstartdatecount > 0) || ($substartdatecount > 0)){
                                        return false;
                                    }else{
                                        return true;
                                    }
                        
                                });

                                Validator::extend('isprevnextdateapplicationsmeetup_new1', function($attribute, $value, $parameters, $validator) {

                                    $encrypt = session()->get('employeesession');
                                    $decrypt = Crypt::decrypt($encrypt);
                                    $split = explode("-",$decrypt);
                                    $employeeid = $split[0];
                                    
                                    $req = $validator->getData();
                                    $splitrange = explode('-',$req['leave_date_range']);
                                    $startdate = $this->dateformatreturnddmmyytoyymmdd(trim($splitrange[0]));
                                    $enddate = $this->dateformatreturnddmmyytoyymmdd(trim($splitrange[1]));
                                    $partial_days = $value;   
                                    
                                    
                                    $leave_type =   $req['leave_type'];
                                    if($leave_type == 'CL') { $typenotallowed = ['SL', 'PL', 'RH', 'ML']; }
                                    if($leave_type == 'SL') { $typenotallowed = ['CL', 'PL', 'RH', 'ML']; }
                                    if($leave_type == 'PL') { $typenotallowed = ['SL', 'CL', 'RH', 'ML']; }
                                    if($leave_type == 'RH') { $typenotallowed = ['SL', 'PL', 'CL', 'ML']; }
                                    if($leave_type == 'ML') { $typenotallowed = ['SL', 'PL', 'CL', 'RH']; }

                                    $daterange_array = $this->createDateRange($startdate, $enddate, $format = "Y-m-d");
                                    array_push($daterange_array, $enddate);
                                    
                                    foreach ($daterange_array as $key => $value) {
                                                                                
                                        $newchecksubday = Carbon::parse($value)->subDay()->toDateString();
                                        $newcheckaddday = Carbon::parse($value)->addDay()->toDateString();
                                     
                                        
                                        if ($partial_days == 'first_half') {
                                        $check1 = DB::connection('mysql6')->table('datetime_ref')->where(['employeeid' => $employeeid, 'date' =>$newchecksubday  ])->whereIn('type', $typenotallowed)->whereIn('final_status', ['Approved','Pending'])->get()->toArray();
                                        $check2 = DB::connection('mysql6')->table('datetime_ref')->where(['employeeid' => $employeeid, 'date' =>$value  ])->whereIn('type', $typenotallowed)->whereIn('final_status', ['Approved','Pending'])->get()->toArray();

                                        if (!empty($check1)) {
                                            foreach ($check1 as $key4 => $value4) {
                                                
                                                    if ($value4->partial_days == 'second_half') {
                                                        return false;
                                                    }
                                                    
                                                
                                            }
                                        }
                                        if (!empty($check2)) {
                                            foreach ($check2 as $key24 => $value24) {
                                                
                                                    if ($value24->partial_days == 'second_half') {
                                                        return false;
                                                    }
                                                    
                                                
                                            }
                                        }
                                    }

                                    if ($partial_days == 'second_half') {
                                        $check1 = DB::connection('mysql6')->table('datetime_ref')->where(['employeeid' => $employeeid, 'date' =>$value  ])->whereIn('type', $typenotallowed)->whereIn('final_status', ['Approved','Pending'])->get()->toArray();
                                        $check2 = DB::connection('mysql6')->table('datetime_ref')->where(['employeeid' => $employeeid, 'date' =>$newcheckaddday  ])->whereIn('type', $typenotallowed)->whereIn('final_status', ['Approved','Pending'])->get()->toArray();

                                        if (!empty($check1)) {
                                            foreach ($check1 as $key4 => $value4) {
                                                
                                                    if ($value4->partial_days == 'first_half') {
                                                        return false;
                                                    }
                                                    
                                                
                                            }
                                        }
                                        if (!empty($check2)) {
                                            foreach ($check2 as $key5 => $value5) {
                                                
                                                    if ($value5->partial_days == 'first_half') {
                                                        return false;
                                                    }
                                                    if ($value5->partial_days == 'full') {
                                                        return false;
                                                    }
                                                    
                                                
                                            }
                                        }
                                    }
                                    if ($partial_days == 'full') {
                                        $check1 = DB::connection('mysql6')->table('datetime_ref')->where(['employeeid' => $employeeid, 'date' =>$newchecksubday  ])->whereIn('type', $typenotallowed)->whereIn('final_status', ['Approved','Pending'])->get()->toArray();
                                        $check2 = DB::connection('mysql6')->table('datetime_ref')->where(['employeeid' => $employeeid, 'date' =>$newcheckaddday  ])->whereIn('type', $typenotallowed)->whereIn('final_status', ['Approved','Pending'])->get()->toArray();

                                        if (!empty($check1)) {
                                            foreach ($check1 as $key4 => $value4) {
                                                
                                                    if ($value4->partial_days == 'second_half') {
                                                        return false;
                                                    }
                                                    if ($value4->partial_days == 'full') {
                                                        return false;
                                                    }
                                                    
                                                
                                            }
                                        }
                                        if (!empty($check2)) {
                                            foreach ($check2 as $key5 => $value5) {
                                                
                                                    if ($value5->partial_days == 'first_half') {
                                                        return false;
                                                    }
                                                    if ($value5->partial_days == 'full') {
                                                        return false;
                                                    }
                                                    
                                                
                                            }
                                        }
                                    }
                            
                                    }

                                    return true;
                                    
                        
                                });

                                Validator::extend('checkwithappliedleaves_new', function($attribute, $value, $parameters, $validator) {

                                    $encrypt = session()->get('employeesession');
                                    $decrypt = Crypt::decrypt($encrypt);
                                    $split = explode("-",$decrypt);
                                    $employeeid = $split[0];
                                    
                                    $req = $validator->getData();

                                    if (strpos($req['leave_date_range'], '-') !== false){
                                        $splitrange = explode('-',$req['leave_date_range']);
                                        $start_date = $this->dateformatreturnddmmyytoyymmdd(trim($splitrange[0]));
                                        $end_date = $this->dateformatreturnddmmyytoyymmdd(trim($splitrange[1]));
                                    }
                                    else{
                                        $start_date = $this->dateformatreturnddmmyytoyymmdd(trim($req['leave_date_range']));
                                        $end_date = $this->dateformatreturnddmmyytoyymmdd(trim($req['leave_date_range']));
                                    }
                                                                       

                                    $daterange_array = $this->createDateRange($start_date, $end_date, $format = "Y-m-d");
                                    array_push($daterange_array, $end_date);

                                    $matcheddatecount = 0;
                                    foreach ($daterange_array as $key1 => $value1) {            
                        
                                    $leave_type =   $req['leave_type'];
                                    
                                    if($leave_type == 'CL') { $typenotallowed = ['SL', 'PL', 'RH', 'ML']; }
                                    if($leave_type == 'SL') { $typenotallowed = ['CL', 'PL', 'RH', 'ML']; }
                                    if($leave_type == 'PL') { $typenotallowed = ['SL', 'CL', 'RH', 'ML']; }
                                    if($leave_type == 'RH') { $typenotallowed = ['SL', 'PL', 'CL', 'ML']; }
                                    if($leave_type == 'ML') { $typenotallowed = ['SL', 'PL', 'CL', 'RH']; }
                                    //if($leave_type == 'Onduty') { $typenotallowed = ['LOP','Mispunch','Permission','Onduty','Compoff','RH','ML','SL', 'PL', 'CL', 'RH']; }
                                    if($leave_type == 'Onduty') { $typenotallowed = []; }
                                    if($leave_type == 'Compoff') { $typenotallowed = []; }
                                    if($leave_type == 'Permission') { $typenotallowed = ['Permission']; }
                                    if($leave_type == 'LOP') { $typenotallowed = []; }
                                    if($leave_type == 'Mispunch') { $typenotallowed = []; }
                                    if($leave_type == 'Tour') { $typenotallowed = []; }
            
                                        $matcheddatecount = DB::connection('mysql6')->table('datetime_ref')->where(['employeeid' => $employeeid, 'date' =>$value1  ])->whereIn('final_status', ['Approved','Pending'])->get()->toArray();
                                        
                                        
                                        if (!empty($matcheddatecount)) {
                                            foreach ($matcheddatecount as $key3 => $value3) {
                                                if ($value == 'full') {
                                                    return false;
                                                }
                                                if ($value == 'first_half') {
                                                    if (($value3->partial_days == 'first_half') || ($value3->partial_days == 'full')) {
                                                        return false;
                                                    }
                                                    $check1 = DB::connection('mysql6')->table('datetime_ref')->where(['employeeid' => $employeeid, 'date' =>$value1,'partial_days' => 'second_half'  ])->whereIn('type', $typenotallowed)->whereIn('final_status', ['Approved','Pending'])->count();    
                                                    if ($check1 > 0) {
                                                        return false;
                                                    }

                                                }
                                                if ($value == 'second_half') {
                                                    if (($value3->partial_days == 'second_half') || ($value3->partial_days == 'full')) {
                                                        return false;
                                                    }
                                                    $check1 = DB::connection('mysql6')->table('datetime_ref')->where(['employeeid' => $employeeid, 'date' =>$value1,'partial_days' => 'first_half'  ])->whereIn('type', $typenotallowed)->whereIn('final_status', ['Approved','Pending'])->count();    
                                                    if ($check1 > 0) {
                                                        return false;
                                                    }    
                                                }
                                                
                                            }
                                        }
                                    
                                                              
                                    }
                                    
                                   return true;
                        
                                });



                                Validator::extend('allowonly2daysbeforefromcurrentonly', function($attribute, $value, $parameters, $validator) {
                                    $start_date = $this->dateformatreturnddmmyytoyymmdd(trim($value));
                                    $applicationstartdate = Carbon::parse($start_date);
                                    $presentdate = Carbon::parse(Carbon::now())->toDateString();
                                    $add2days = Carbon::parse($presentdate)->addDays(2);
                                    $checkgreaterthancurrentand2daysdate = $applicationstartdate->gte($add2days);
									
									$encrypt = session()->get('employeesession');
                                        $decrypt = Crypt::decrypt($encrypt);
                                        $split = explode("-",$decrypt);
                                        $employeeid = $split[0];
                                        $dd = DB::connection('mysql6')->table('delete_leave_applications_reference')->where(['employeeid' => $employeeid, 'date' => Carbon::parse($applicationstartdate)->toDateString()])->get();
                                         if (count($dd) > 0) {
                                            return true;
                                        }
                                    
                                    return $checkgreaterthancurrentand2daysdate;
                            
                                    });

                                    Validator::extend('checkinbetweenweekoforholiday', function($attribute, $value, $parameters, $validator) {
                                        $encrypt = session()->get('employeesession');
                                        $decrypt = Crypt::decrypt($encrypt);
                                        $split = explode("-",$decrypt);
                                        $employeeid = $split[0];
                                        $getemployee =  DB::connection('mysql6')->table('employee')->where('id',$employeeid )->get(); 
                                        $req = $validator->getData();

                                        $splitrange = explode('-',$req['leave_date_range']);
                                        
                                        $start_date = $this->dateformatreturnddmmyytoyymmdd(trim($splitrange[0]));
                                        $end_date = $this->dateformatreturnddmmyytoyymmdd(trim($splitrange[1]));
                                                                                
                                        $add2days = Carbon::parse($end_date)->addDays(2)->toDateString();
                                        $add1day = Carbon::parse($end_date)->addDay()->toDateString();

                                        $sub2days = Carbon::parse($start_date)->subDays(2)->toDateString();
                                        $sub1day = Carbon::parse($start_date)->subDay()->toDateString();


                                        $check1 = $this->checkweekoff_holidays_new($employeeid, $sub1day, $sub1day, $getemployee);
                                        if (($check1['holiday_count'] != 0) || ($check1['weekoff_count'] != 0)) {
                                            //dd($check1);
                                            
											$cmonth1 = Carbon::parse($sub2days)->format('m');
											$cmonth2 = Carbon::parse($sub1day)->format('m');
											if($cmonth1 == $cmonth2){
												
												 $checkprev_present = DB::connection('mysql6')->table('datetime_ref')->where(['employeeid' => $employeeid, 'date' => $sub2days ])->whereIn('final_status', ['Approved', 'Pending'])->get()->toArray();
                                        if (!empty($checkprev_present)) {
                                            if($checkprev_present[0]->partial_days == 'full'){
                                                //if ($value == 'first_half') { return false; }
                                                if (($checkprev_present[0]->type == 'Onduty') || ($checkprev_present[0]->type == 'Tour') || ($checkprev_present[0]->type == 'Compoff')) {
                                                    if ($value == 'full') { return true; }
                                                }
                                                else{
                                                    if ($value == 'full') { return false; }    
                                                }
                                                
                                            }
                                            if($checkprev_present[0]->partial_days == 'second_half'){
                                                //if ($value == 'first_half') { return false; }
                                                //if ($value == 'full') { return false; }
                                            }
                                        }
											
											}
											
											return true;
                                       
                                        }

                                        $check2 = $this->checkweekoff_holidays_new($employeeid, $add1day, $add1day, $getemployee);
                                        if (($check2['holiday_count'] != 0) || ($check2['weekoff_count'] != 0)) {
                                        $checkprev_present = DB::connection('mysql6')->table('datetime_ref')->where(['employeeid' => $employeeid, 'date' => $add2days ])->whereIn('final_status', ['Approved', 'Pending'])->get()->toArray();
                                        if (!empty($checkprev_present)) {
                                            if($checkprev_present[0]->partial_days == 'full'){
                                                //if ($value == 'first_half') { return false; }
                                                if (($checkprev_present[0]->type == 'Onduty') || ($checkprev_present[0]->type == 'Tour') || ($checkprev_present[0]->type == 'Compoff')) {
                                                    if ($value == 'full') { return true; }
                                                }
                                                else{
                                                    if ($value == 'full') { return false; }    
                                                }
                                            }
                                            if($checkprev_present[0]->partial_days == 'second_half'){
                                                //if ($value == 'first_half') { return false; }
                                                //if ($value == 'full') { return false; }
                                            }
                                        }
                                    }
                                        
                                        
                                        return true;
                                
                                        });


                                    Validator::extend('alllowifpast3daysandfuture', function($attribute, $value, $parameters, $validator) {
                                        $start_date = $this->dateformatreturnddmmyytoyymmdd(trim($value));
                                        $applicationstartdate = Carbon::parse($start_date);
                                        $currentdateformatstring = Carbon::now()->toDateString();
                                        $presentdate = Carbon::parse($currentdateformatstring);
										
										$encrypt = session()->get('employeesession');
                                        $decrypt = Crypt::decrypt($encrypt);
                                        $split = explode("-",$decrypt);
                                        $employeeid = $split[0];
										
										
                
                                        $checkgreaterthancurrentdate = $applicationstartdate->gt($presentdate);
                                        $getlast3daysfromnow = Carbon::now()->subDays(3)->toDateString();
                
                                        $checklessthan3days = Carbon::parse($applicationstartdate)->lt(Carbon::parse($getlast3daysfromnow));
                                        
                                            if($checklessthan3days == true){
								$dd = DB::connection('mysql6')->table('delete_leave_applications_reference')->where(['employeeid' => $employeeid, 'date' => Carbon::parse($applicationstartdate)->toDateString()])->get();
                                                if (count($dd) > 0) {
                                                    return true;
                                                }
                                            return false;
                                            }
                
                                            return true;
                        
                                        
                                        
                                
                                        });


				 Validator::extend('alllowifpast1daysandfuture', function($attribute, $value, $parameters, $validator) {
                                        $start_date = $this->dateformatreturnddmmyytoyymmdd(trim($value));
                                        $applicationstartdate = Carbon::parse($start_date);
                                        $currentdateformatstring = Carbon::now()->toDateString();
                                        $presentdate = Carbon::parse($currentdateformatstring);
					 					
					 					 $encrypt = session()->get('employeesession');
                                        $decrypt = Crypt::decrypt($encrypt);
                                        $split = explode("-",$decrypt);
                                        $employeeid = $split[0];
                
                                        $checkgreaterthancurrentdate = $applicationstartdate->gt($presentdate);
                                        $getlast1daysfromnow = Carbon::now()->subDays(1)->toDateString();
                
                                        $checklessthan1days = Carbon::parse($applicationstartdate)->lt(Carbon::parse($getlast1daysfromnow));
                                        
                                            if($checklessthan1days == true){
												$dd = DB::connection('mysql6')->table('delete_leave_applications_reference')->where(['employeeid' => $employeeid, 'date' => Carbon::parse($applicationstartdate)->toDateString()])->get();
                                                if (count($dd) > 0) {
                                                    return true;
                                                }
                                            return false;
                                            }
                
                                            return true;
                        
                                        
                                        
                                
                                        });

                                    Validator::extend('checkseconsaturday', function($attribute, $value, $parameters, $validator) {
                                        $encrypt = session()->get('employeesession');
                                        $decrypt = Crypt::decrypt($encrypt);
                                        $split = explode("-",$decrypt);
                                        $employeeid = $split[0];
                                                                                

                                        $req = $validator->getData();
                                        $start_date = $this->dateformatreturnddmmyytoyymmdd(trim($req['leave_date_range']));
                                        $month = Carbon::parse($start_date)->format('F');
                                        $year = Carbon::parse($start_date)->format('Y');
                                        $applicationstartdate = Carbon::parse($start_date)->toDateString();
                                        $getshiftadatetime = $this->getshiftdetailsst_et_date($employeeid, $applicationstartdate, $applicationstartdate);
                                        if ($getshiftadatetime['Shift_Details']['Shift_Code'] == 'VGN_GEN') {
                                            $bt = new \DateTime("second sat of $month $year");
                                            $btcarbon = Carbon::instance($bt)->toDateString(); 
                                            if ($btcarbon == $applicationstartdate) {
                                                if ($value == 'second_half') {
                                                    return false;
                                                }
                                            }
                                        }
                                        return true;
                                
                                        });

                        Validator::extend('checkweekofforholidays', function($attribute, $value, $parameters, $validator) {
                            
                            
                            $encrypt = session()->get('employeesession');
                            $decrypt = Crypt::decrypt($encrypt);
                            $split = explode("-",$decrypt);
                            $employeeid = $split[0];
                            $getemployee =  DB::connection('mysql6')->table('employee')->where('id',$employeeid )->get(); 
                            

                            if (strpos($value, '-') !== false){
                                $splitrange = explode('-',$value);
                                $start_date = $this->dateformatreturnddmmyytoyymmdd(trim($splitrange[0]));
                                $end_date = $this->dateformatreturnddmmyytoyymmdd(trim($splitrange[1]));
                            }
                            else{
                                $start_date = $this->dateformatreturnddmmyytoyymmdd(trim($value));
                                $end_date = $this->dateformatreturnddmmyytoyymmdd(trim($value));
                            }

                            $req = $validator->getData();
                                    
                            $getdata = $this->checkweekoff_holidays_new($employeeid, $start_date, $end_date, $getemployee);
                            if (($getdata['holiday_count'] != 0) || ($getdata['weekoff_count'] != 0)) {
                                return false;
                            }
                            else{
                                return true;
                            }
                                
                                        });


                                        Validator::extend('checkmax2leavesonly', function($attribute, $value, $parameters, $validator) {
                            
                            
                                            $encrypt = session()->get('employeesession');
                                            $decrypt = Crypt::decrypt($encrypt);
                                            $split = explode("-",$decrypt);
                                            $employeeid = $split[0];
                                            $getemployee =  DB::connection('mysql6')->table('employee')->where('id',$employeeid )->get(); 
                                            
                
                                            if (strpos($value, '-') !== false){
                                                $splitrange = explode('-',$value);
                                                $start_date = $this->dateformatreturnddmmyytoyymmdd(trim($splitrange[0]));
                                                $end_date = $this->dateformatreturnddmmyytoyymmdd(trim($splitrange[1]));
                                            }
                                            else{
                                                $start_date = $this->dateformatreturnddmmyytoyymmdd(trim($value));
                                                $end_date = $this->dateformatreturnddmmyytoyymmdd(trim($value));
                                            }
                
                                            $req = $validator->getData();
                                            $leave_type = $req['leave_type'];
                                            $partial_days = $req['partial_days'];

                                            $daterange_array = $this->createDateRange($start_date, $end_date, $format = "Y-m-d");
                                            array_push($daterange_array, $end_date);
                                            
                                            $count = 0;
                                            $maincount = 0;

                                             $newarr = [];
                                             $currentmonth = Carbon::parse($start_date)->format('m');
                                             $currentyear = Carbon::parse($start_date)->format('Y');
                                             $nextmonth = Carbon::now()->addMonth()->format('m');
                                             $nextyear = Carbon::now()->addMonth()->format('Y');
                                             
                                             $currentdate_scenario = DB::connection('mysql6')->table('leave_processed')->where([
                                                'employeeid' => $employeeid,
                                                'month' => $currentmonth,
                                                'year' => $currentyear,
                                                'type' => $leave_type,
                                                  ] )->whereIn('final_status', ['Pending', 'Approved'])->get();
                                            $nextdate_scenario = DB::connection('mysql6')->table('leave_processed')->where([
                                                    'employeeid' => $employeeid,
                                                    'month' => $nextmonth,
                                                    'year' => $nextyear,
                                                    'type' => $leave_type,
                                                      ] )->whereIn('final_status', ['Pending', 'Approved'])->get();
                                                      
                                                $curr_month_count = 0;
                                                $next_month_count = 0;
                                                if(count($currentdate_scenario) > 0){
                                                foreach ($currentdate_scenario as $key1 => $value1) {
                                                    $curr_month_count = $curr_month_count + $value1->no_of_days;
                                                }
                                                }

                                                if(count($nextdate_scenario) > 0){
                                                    foreach ($nextdate_scenario as $key2 => $value2) {
                                                        $next_month_count = $next_month_count + $value2->no_of_days;
                                                    }
                                                }

                                                $startdatemonth = Carbon::parse($start_date)->format('m');
                                                $startdateyear = Carbon::parse($start_date)->format('Y');

                                                $enddatemonth = Carbon::parse($end_date)->format('m');
                                                $enddateyear = Carbon::parse($end_date)->format('Y');

                                                if (($startdatemonth == $enddatemonth) && ($startdateyear == $enddateyear)) {
                                                    
                                                    if ($partial_days == 'full') {
                                                        $diff = $this->formatforempdat_differbtwtwodates($start_date, $end_date);
                                                        $maincount = $curr_month_count + $diff;
                                                    }
                                                    if ($partial_days == 'first_half') {
                                                      $maincount = $curr_month_count + 0.5;
                                                    }
                                                    if ($partial_days == 'second_half') {
                                                      $maincount = $curr_month_count + 0.5;
                                                    }
                                                }

                                               
                                                   
                                                if($maincount <= 2){
                                                    return true;
                                                }
                                                else{
                                                    return false;
                                                }
                                                
                                                  


                                                
                                                        });


                                                        Validator::extend('twomonthscantclub', function($attribute, $value, $parameters, $validator) {
                            
                            
                                                            $encrypt = session()->get('employeesession');
                                                            $decrypt = Crypt::decrypt($encrypt);
                                                            $split = explode("-",$decrypt);
                                                            $employeeid = $split[0];
                                                            $getemployee =  DB::connection('mysql6')->table('employee')->where('id',$employeeid )->get(); 
                                                            
                                
                                                            if (strpos($value, '-') !== false){
                                                                $splitrange = explode('-',$value);
                                                                $start_date = $this->dateformatreturnddmmyytoyymmdd(trim($splitrange[0]));
                                                                $end_date = $this->dateformatreturnddmmyytoyymmdd(trim($splitrange[1]));
                                                            }
                                                            else{
                                                                $start_date = $this->dateformatreturnddmmyytoyymmdd(trim($value));
                                                                $end_date = $this->dateformatreturnddmmyytoyymmdd(trim($value));
                                                            }
                                
                                                            $firstmonth = Carbon::parse($start_date)->format('m');
                                                            $secondmonth = Carbon::parse($end_date)->format('m');
                
                                                               if (($firstmonth == $secondmonth)) {
                                                                   return true;
                                                               }
                                                               else{
                                                                   return false;
                                                               }
                                                                   
                                                                
                                                                        });


                                                                     Validator::extend('prevmonth_app_notallowed', function($attribute, $value, $parameters, $validator) { 
                                                                            
                                                
                                                                            if (strpos($value, '-') !== false){
                                                                                $splitrange = explode('-',$value);
                                                                                $start_date = $this->dateformatreturnddmmyytoyymmdd(trim($splitrange[0]));
                                                                                $end_date = $this->dateformatreturnddmmyytoyymmdd(trim($splitrange[1]));
                                                                            }
                                                                            else{
                                                                                $start_date = $this->dateformatreturnddmmyytoyymmdd(trim($value));
                                                                                $end_date = $this->dateformatreturnddmmyytoyymmdd(trim($value));
                                                                            }
                                                
                                                                            $firstmonth = Carbon::parse($start_date)->format('m');
                                                                            $currentmonth = Carbon::now()->format('m');

                                                                               if (($currentmonth == '01')&&($firstmonth == '12')) {
                                                                                return false;
                                                                               }
                                                                               if (($firstmonth < $currentmonth)) {
                                                                                   return false;
                                                                               }
                                                                               else{
                                                                                   return true;
                                                                               }
                                                                                   
                                                                                
                                                                                        });
                              

       
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}

