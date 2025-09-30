<?php

namespace vgn\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Crypt;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use DB;
use vgn\Mail\finalcommonlmsmail;
use vgn\Mail\finalempcommonlmsmail;
use vgn\Mail\lmsappremainderemailtohod;
use vgn\Mail\lmsappremainderemailtoemp;
use vgn\Mail\deleterequestmailtohod;
use vgn\Mail\deleteconfirmationtoemployee;

use Illuminate\Support\Facades\Mail;
use vgn\Http\Traits\employeetrait;
use vgn\Http\Traits\LMS\checkandprocess_logictrait;
use vgn\Http\Traits\LMS\attendance_summary;
use vgn\Http\Traits\LMS\daily_attendance_summary;




class NewLMSController extends Controller
{
    use checkandprocess_logictrait, attendance_summary, daily_attendance_summary;

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


    public function postleaveapplication(Request $request)
    {
        if ($request->session()->has('employeesession')) {
            $encrypt = $request->session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $employeeid = $split[0];

            $getemployeedata =  DB::connection('mysql6')->table('employee')->where('id',$employeeid )->get(); 
            
            

            $leave_date_range = $request->leave_date_range;
            $leave_type = $request->leave_type;

            if (!empty($leave_date_range) && !empty($leave_type)) {
                if ($leave_type != 'Onduty') {
                
                
                 if (strpos($leave_date_range, '-') !== false){

                $nsplitrange = explode('-',$leave_date_range);

                $startdate = $this->dateformatreturnddmmyytoyymmdd(trim($nsplitrange[0]));
                $nenddate = $this->dateformatreturnddmmyytoyymmdd(trim($nsplitrange[1]));
            }
            else{
                $startdate = $this->dateformatreturnddmmyytoyymmdd(trim($leave_date_range));
                $nenddate = $this->dateformatreturnddmmyytoyymmdd(trim($leave_date_range));
            }

            
            $diff = $this->formatforempdat_differbtwtwodates($startdate, $nenddate);
           
            if($request->partial_days == 'full'){ $diff = $diff;}else{$diff = 0.5;}
                
            }else{
                $startdate = $this->dateformatreturnddmmyytoyymmdd(trim($leave_date_range));
                $diff = '1';
            }    
            }
            else{
                     $error['0'] ="Please fill the mandatory fields!";
                $request->session()->flash("error_msg", $error);
                return redirect()->back()->withInput();                
            }
            
            
            /**
             * validation needs to be done
             */
            if(($request->leave_type == 'SL') && ($diff > 2)){
            						
            		$validate = $this->validate($request, [
                    'leave_type' => 'required',
                    'leave_date_range' => 'required|alllowifpast3daysandfuture|prevmonth_app_notallowed|twomonthscantclub|newjoineevalidation',
                    'partial_days' => 'required|checkwithappliedleaves_new|isprevnextdateapplicationsmeetup_new1|leavecountcheck|checkinbetweenweekoforholiday',
                    'leave_reason' => 'required',
                    'sickleavefile' => 'required_if:leave_type,SL'
                    ]);
					
				
            }
            elseif(($request->leave_type == 'SL') && ($diff <= 2)){
				
					$validate = $this->validate($request, [
                        'leave_type' => 'required',
                        'leave_date_range' => 'required|alllowifpast3daysandfuture|prevmonth_app_notallowed|twomonthscantclub|newjoineevalidation',
                        'partial_days' => 'required|checkwithappliedleaves_new|isprevnextdateapplicationsmeetup_new1|leavecountcheck|checkinbetweenweekoforholiday',
                        'leave_reason' => 'required'
                        ]);
				
				
            }
            elseif ($request->leave_type == 'CL') {
                
					$validate = $this->validate($request, [
                        'leave_type' => 'required',
                        'leave_date_range' => 'required|lessthancurrentdate|checkmax2leavesonly|prevmonth_app_notallowed|twomonthscantclub|newjoineevalidation',
                        'partial_days' => 'required|isprevnextdateapplicationsmeetup_new1|checkwithappliedleaves_new|leavecountcheck|checkinbetweenweekoforholiday',
                        'leave_reason' => 'required'
                        ]);
                     
            }
            elseif ($request->leave_type == 'PL') {
              
                    $validate = $this->validate($request, [
                        'leave_type' => 'required',
                        'leave_date_range' => 'required|allowonly2daysbeforefromcurrentonly|prevmonth_app_notallowed|twomonthscantclub|newjoineevalidation',
                        'partial_days' => 'required|in:full|checkwithappliedleaves_new|isprevnextdateapplicationsmeetup_new1|leavecountcheck|checkinbetweenweekoforholiday',
                        'leave_reason' => 'required'
                        ]);
				
				
            }
            elseif ($request->leave_type == 'ML') {
                
                $validate = $this->validate($request, [
                    'leave_type' => 'required',
                    'leave_date_range' => 'required|lessthancurrentdate|prevmonth_app_notallowed|maternity_weeks|newjoineevalidation',
                    'partial_days' => 'required|in:full|checkwithappliedleaves_new|isprevnextdateapplicationsmeetup_new1|leavecountcheck|checkinbetweenweekoforholiday',
                    'leave_reason' => 'required',
                    'maternityfile' => 'required_if:leave_type,ML'
                    ]);
            }
            elseif ($request->leave_type == 'RH') {
                    $validate = $this->validate($request, [
                        'leave_type' => 'required',
                        'leave_date_range' => 'required|currentmonth|prevmonth_app_notallowed|newjoineevalidation',
                        'partial_days' => 'required|in:full|checkwithappliedleaves_new||leavecountcheck',
                        'leave_reason' => 'required'
                        ]);
            }
            elseif ($request->leave_type == 'Permission') {
                //alllowifpast1daysandfuture
                	
            	
                    $validate = $this->validate($request, [
                        'leave_type' => 'required',
                        'leave_date_range' => 'required|alllowifpast3daysandfuture|currentmonth|prevmonth_app_notallowed',
                        'partial_days' => 'required|checkwithappliedleaves_new|permissioncount',
                        'leave_reason' => 'required'
                        ]);
                     
            }
            elseif ($request->leave_type == 'Onduty') {
              		
				$validate = $this->validate($request, [
                        'leave_type' => 'required',
                        'leave_date_range' => 'required|alllowifpast3daysandfuture|twomonthscantclub|prevmonth_app_notallowed',
                        'od_period' => 'required',
                        'partial_days' => 'required|checkwithappliedleaves_new',
                        'leave_reason' => 'required'
                        ]);      
			
            }
            elseif ($request->leave_type == 'Tour') {
              
                    $validate = $this->validate($request, [
                        'leave_type' => 'required',
                        'leave_date_range' => 'required|onlypast3_futuredays|twomonthscantclub|prevmonth_app_notallowed',
                        'partial_days' => 'required|checkwithappliedleaves_new',
                        'leave_reason' => 'required'
                        ]);
					 
            		
            }
            else{                      
                        $validate = $this->validate($request, [
                            'leave_type' => 'required',
                            'leave_date_range' => 'required|currentmonth|isprevnextdateapplicationsmeetup_new1|twomonthscantclub|prevmonth_app_notallowed',
                            'partial_days' => 'required|leavecountcheck|checkwithappliedleaves_new',
                            'leave_reason' => 'required'
                            ]);
            }
            
            //dd($request);
             //validation passes

             
             $leave_type = $request->leave_type;
            
             $getactivedetails = $this->getactivedetails($employeeid);
            
            
             if(($getactivedetails['contract'] == true) || ($getactivedetails['notice_period'] == true)){
                 $error['0'] ="(Contract, Retainer, Notice Period Serving) Employees are not allowed to apply for the Leave Applications!";
                $request->session()->flash("error_msg", $error);
                return redirect()->back()->withInput();
             }
        
             
             if ($leave_type == 'CL') {
                 

                $leave_date_range = $request->leave_date_range;

                $splitrange = explode('-',$leave_date_range);

                $startdate = $this->dateformatreturnddmmyytoyymmdd(trim($splitrange[0]));
                $enddate = $this->dateformatreturnddmmyytoyymmdd(trim($splitrange[1]));
                $diff = $this->formatforempdat_differbtwtwodates($startdate, $enddate);

                
                $run_apply_process = $this->clprocess($employeeid, $startdate, $enddate, $request->partial_days, $leave_type,$request->leave_reason, $diff, $getactivedetails);

                if($run_apply_process == true){
                    
                    $request->session()->flash("suc_msg", "Successfully leave application Submitted!.");
                   return redirect()->back();
                }
             }

             if ($leave_type == 'RH') {
                 

                $leave_date_range = $request->leave_date_range;

                $splitrange = explode('-',$leave_date_range);

                $startdate = $this->dateformatreturnddmmyytoyymmdd(trim($splitrange[0]));
                $enddate = $this->dateformatreturnddmmyytoyymmdd(trim($splitrange[1]));
                $diff = $this->formatforempdat_differbtwtwodates($startdate, $enddate);

                
                $run_apply_process = $this->clprocess($employeeid, $startdate, $enddate, $request->partial_days, $leave_type,$request->leave_reason, $diff, $getactivedetails);

                if($run_apply_process == true){
                    
                    $request->session()->flash("suc_msg", "Successfully leave application Submitted!.");
                   return redirect()->back();
                }
             }

             if ($leave_type == 'Onduty') {
                 

                $od_period1 = $request->od_period;
                

                $splitrange = explode(' to ',$od_period1);
                $splitrange1 = explode(' ',$splitrange[0]);
                $splitrange2 = explode(' ',$splitrange[1]);

                if ($request->has('punch_ref')) {
                    
                }else{
                    $error[] = 'Select the Onduty Punch time!';
                    $request->session()->flash("error_msg", $error);
                   return redirect()->back()->withInput();
                }

                
                //dd($splitrange1);
                $startdate = $splitrange1[0];
                //$enddate = $this->dateformatreturnddmmyytoyymmdd(trim($splitrange2[0]));
               
                

                
                $run_apply_process = $this->odprocess($employeeid, $startdate, $request->partial_days, $leave_type,$request->leave_reason, $request);

                if($run_apply_process == true){
                    
                    $request->session()->flash("suc_msg", "Successfully Onduty application Submitted!.");
                   return redirect()->back();
                }
             }

             if ($leave_type == 'SL') {
                 

                $leave_date_range = $request->leave_date_range;

                $splitrange = explode('-',$leave_date_range);

                $startdate = $this->dateformatreturnddmmyytoyymmdd(trim($splitrange[0]));
                $enddate = $this->dateformatreturnddmmyytoyymmdd(trim($splitrange[1]));
                $diff = $this->formatforempdat_differbtwtwodates($startdate, $enddate);
                
                if ($request->hasFile('sickleavefile')) {
                    $checkthefile = $this->checkthefile($employeeid, $startdate, $enddate,$request, 'sickleavefile');
                    $error = [];
                    if(!empty($checkthefile)){

                        foreach ($checkthefile as $key => $value) {
                            $error[] = $value;
                        }
                        $request->session()->flash("error_msg", $error);
                   return redirect()->back()->withInput();
                    }
               }

               
               
                
                $run_apply_process = $this->slprocess($employeeid, $startdate, $enddate, $request->partial_days, $leave_type,$request->leave_reason, $diff, $getactivedetails, $request);

                if($run_apply_process == true){
                    
                    $request->session()->flash("suc_msg", "Successfully leave application Submitted!.");
                   return redirect()->back();
                }
             }

              if ($leave_type == 'SL') {
                 

                $leave_date_range = $request->leave_date_range;

                $splitrange = explode('-',$leave_date_range);

                $startdate = $this->dateformatreturnddmmyytoyymmdd(trim($splitrange[0]));
                $enddate = $this->dateformatreturnddmmyytoyymmdd(trim($splitrange[1]));
                $diff = $this->formatforempdat_differbtwtwodates($startdate, $enddate);
                
                if ($request->hasFile('sickleavefile')) {
                    $checkthefile = $this->checkthefile($employeeid, $startdate, $enddate,$request, 'sickleavefile');
                    $error = [];
                    if(!empty($checkthefile)){

                        foreach ($checkthefile as $key => $value) {
                            $error[] = $value;
                        }
                        $request->session()->flash("error_msg", $error);
                   return redirect()->back()->withInput();
                    }
               }

               
               
                
                $run_apply_process = $this->slprocess($employeeid, $startdate, $enddate, $request->partial_days, $leave_type,$request->leave_reason, $diff, $getactivedetails, $request);

                if($run_apply_process == true){
                    
                    $request->session()->flash("suc_msg", "Successfully leave application Submitted!.");
                   return redirect()->back();
                }
             }

             if ($leave_type == 'PL') {
                 

                $leave_date_range = $request->leave_date_range;

                $splitrange = explode('-',$leave_date_range);

                $startdate = $this->dateformatreturnddmmyytoyymmdd(trim($splitrange[0]));
                $enddate = $this->dateformatreturnddmmyytoyymmdd(trim($splitrange[1]));
                $diff = $this->formatforempdat_differbtwtwodates($startdate, $enddate);
                
                
                $run_apply_process = $this->clprocess($employeeid, $startdate, $enddate, $request->partial_days, $leave_type,$request->leave_reason, $diff, $getactivedetails, $request);

                if($run_apply_process == true){
                    
                    $request->session()->flash("suc_msg", "Successfully leave application Submitted!.");
                   return redirect()->back();
                }
             }

             if ($leave_type == 'ML') {
                 

                $leave_date_range = $request->leave_date_range;

                $splitrange = explode('-',$leave_date_range);

                $startdate = $this->dateformatreturnddmmyytoyymmdd(trim($splitrange[0]));
                $enddate = $this->dateformatreturnddmmyytoyymmdd(trim($splitrange[1]));
                $diff = $this->formatforempdat_differbtwtwodates($startdate, $enddate);
                
                if ($request->hasFile('sickleavefile')) {
                    $checkthefile = $this->checkthefile($employeeid, $startdate, $enddate,$request, 'sickleavefile');
                    $error = [];
                    if(!empty($checkthefile)){

                        foreach ($checkthefile as $key => $value) {
                            $error[] = $value;
                        }
                        $request->session()->flash("error_msg", $error);
                   return redirect()->back()->withInput();
                    }
               }

               if ($request->hasFile('maternityfile')) {
                $checkthefile = $this->checkthefile($employeeid, $startdate, $enddate,$request,'maternityfile');
                $error = [];
                    if(!empty($checkthefile)){

                        foreach ($checkthefile as $key => $value) {
                            $error[] = $value;
                        }
                        $request->session()->flash("error_msg", $error);
                   return redirect()->back()->withInput();
                    }
           }
               
                
                $run_apply_process = $this->mlprocess($employeeid, $startdate, $enddate, $request->partial_days, $leave_type,$request->leave_reason, $diff, $getactivedetails, $request);

                if($run_apply_process == true){
                    
                    $request->session()->flash("suc_msg", "Successfully leave application Submitted!.");
                   return redirect()->back();
                }
             }

             if ($leave_type == 'Permission') {
                 

                $leave_date_range = $request->leave_date_range;

                

                $startdate = $this->dateformatreturnddmmyytoyymmdd(trim($leave_date_range));
                                
                               
                $run_apply_process = $this->permissionprocess($employeeid, $startdate, $request->partial_days, $leave_type,$request->leave_reason, $request);

                if($run_apply_process == true){
                    
                    $request->session()->flash("suc_msg", "Successfully Permission application Submitted!.");
                   return redirect()->back();
                }
             }

             if ($leave_type == 'Tour') {
                 
                $leave_date_range = $request->leave_date_range;

                $splitrange = explode('-',$leave_date_range);

                $startdate = $this->dateformatreturnddmmyytoyymmdd(trim($splitrange[0]));
                $enddate = $this->dateformatreturnddmmyytoyymmdd(trim($splitrange[1]));
                $diff = $this->formatforempdat_differbtwtwodates($startdate, $enddate);
                
                
                $run_apply_process = $this->clprocess($employeeid, $startdate, $enddate, $request->partial_days, $leave_type,$request->leave_reason, $diff, $getactivedetails, $request);

                if($run_apply_process == true){
                    
                    $request->session()->flash("suc_msg", "Successfully Tour application Submitted!.");
                   return redirect()->back();
                }
             }
        



        
        }else{
            return view('newemployeezone.login');
        }

    }


    public function getactivedetails($employeeid)
    {
        $active_emp = $this->getallactiveemployees();
        $result = ['contract' => false, 'notice_period' => false, 'role_code' => '', 'report_incharge_id' => '', 'emp_name' => '', 'emp_id' => ''];
        foreach ($active_emp['Details'] as $key => $value) {
            if ($value['Emp_ID'] == $employeeid) {
                     $result['role_code'] = $value['Role_Code'];
                    $result['report_incharge_id'] = $value['RM_ID'];
                    $result['emp_mailid'] = $value['Official_Mail'];
                    $result['personal_mobile_no'] = $value['Personal_Mobile'];
                    $result['emp_name'] = $value['Emp_Name'];
                    $result['emp_id'] = $value['Emp_ID'];
                    
                if ($value['OnContract'] == 'C') {
                    $result['contract'] = true;
                }
                if ($value['OnNotice'] == 'N') {
                    $result['notice_period'] = true;
                }
            }
        }

        return $result;
    }

    public function clprocess($employeeid, $startdate, $enddate, $partial_days, $leave_type,$leave_reason, $diff, $getactivedetails)
    {
        $suboneday = Carbon::parse($startdate)->subDay()->toDateString();
        $subtwoday = Carbon::parse($startdate)->subDays(2)->toDateString();
        if ($diff == 1) {
            $getshiftdetails = $this->getshiftdetailsst_et_date($employeeid, $startdate, $startdate);
            
            if (($getshiftdetails['Shift_Details']['Shift_Code'] == 'VGN_NIGT') || ($getshiftdetails['Shift_Details']['Shift_Code'] == 'VGN_FNIG')) {
                $std = Carbon::parse($startdate)->addDay()->toDateString();
            }
            else{
                $std = $startdate;
            }

            $fhourtoadd = substr(Carbon::parse($startdate.' '.$getshiftdetails['Shift_Details']['Start_Time'])->diff(Carbon::parse($std.' '.$getshiftdetails['Shift_Details']['End_Time']))->format('%H:%i:%s'), 0,2);
            
            if ($partial_days == 'first_half') { 
               $hourtoadd = $fhourtoadd/2;
               $startdatetime = $startdate.' '.$getshiftdetails['Shift_Details']['Start_Time'];
               $enddatetime = $std.' '.$getshiftdetails['Shift_Details']['End_Time'];
               //$startdatetime = Carbon::parse($startdate.' '.$getshiftdetails['Shift_Details']['Start_Time'])->toDateTimeString();
               //$enddatetime = Carbon::parse($std.' '.$getshiftdetails['Shift_Details']['End_Time'])->subHours($hourtoadd)->subHour()->toDateTimeString();
               $no_of_days = 0.5;
               //$no_of_hours = $hourtoadd;

    $diffinminutes = Carbon::parse($startdatetime)->diffInSeconds(Carbon::parse($enddatetime));
    $minutesdivide = $diffinminutes/2;
    $gmate = gmdate('H:i:s', $minutesdivide);
    
    $splitsub = explode(':', $gmate);
    if (($getshiftdetails['Shift_Details']['Shift_Code'] == 'VGN_GEN') || ($getshiftdetails['Shift_Details']['Shift_Code'] == 'VGN_GEN2') || ($getshiftdetails['Shift_Details']['Shift_Code'] == 'VGN_RCP1') || ($getshiftdetails['Shift_Details']['Shift_Code'] == 'VGN_RCP2') || ($getshiftdetails['Shift_Details']['Shift_Code'] == 'VGN_SAP') || ($getshiftdetails['Shift_Details']['Shift_Code'] == 'VGN_MGR') ) {
    $enddatetime = Carbon::parse($startdatetime)->addHours($splitsub[0])->addMinutes($splitsub[1])->subMinutes(30)->toDateTimeString();
    $diffintimehours = Carbon::parse($startdatetime)->diffInSeconds(Carbon::parse($enddatetime));
    $no_of_hours = gmdate('H:i:s', $diffintimehours);    
    }
    else{
        $enddatetime = Carbon::parse($startdatetime)->addHours($splitsub[0])->addMinutes($splitsub[1])->toDateTimeString();
        $no_of_hours = $gmate;
    }
               
            }
            elseif ($partial_days == 'second_half') {
                $hourtoadd = $fhourtoadd/2;
                
                $startdatetime = $startdate.' '.$getshiftdetails['Shift_Details']['Start_Time'];
               $enddatetime = $startdate.' '.$getshiftdetails['Shift_Details']['End_Time'];
                //$startdatetime = Carbon::parse($startdate.' '.$getshiftdetails['Shift_Details']['End_Time'])->subHours($hourtoadd)->subHour()->toDateTimeString();
                //$enddatetime = Carbon::parse($startdate.' '.$getshiftdetails['Shift_Details']['End_Time'])->toDateTimeString();
                //$no_of_hours = $hourtoadd;
                $no_of_days = 0.5;

                 $diffinminutes = Carbon::parse($startdatetime)->diffInSeconds(Carbon::parse($enddatetime));
    $minutesdivide = $diffinminutes/2;
    $gmate = gmdate('H:i:s', $minutesdivide);
    
    $splitsub = explode(':', $gmate);
    if (($getshiftdetails['Shift_Details']['Shift_Code'] == 'VGN_GEN') || ($getshiftdetails['Shift_Details']['Shift_Code'] == 'VGN_GEN2') || ($getshiftdetails['Shift_Details']['Shift_Code'] == 'VGN_RCP1') || ($getshiftdetails['Shift_Details']['Shift_Code'] == 'VGN_RCP2') || ($getshiftdetails['Shift_Details']['Shift_Code'] == 'VGN_SAP') || ($getshiftdetails['Shift_Details']['Shift_Code'] == 'VGN_MGR') ) {
    $startdatetime = Carbon::parse($startdatetime)->addHours($splitsub[0])->addMinutes($splitsub[1])->subMinutes(30)->toDateTimeString();
    $diffintimehours = Carbon::parse($startdatetime)->diffInSeconds(Carbon::parse($enddatetime));
    $no_of_hours = gmdate('H:i:s', $diffintimehours); 
    }
    else{
        $startdatetime = Carbon::parse($startdatetime)->addHours($splitsub[0])->addMinutes($splitsub[1])->toDateTimeString();
        $no_of_hours = $gmate;
    }
            }
            else{
                $startdatetime = Carbon::parse($startdate.' '.$getshiftdetails['Shift_Details']['Start_Time'])->toDateTimeString();
                $enddatetime = Carbon::parse($std.' '.$getshiftdetails['Shift_Details']['End_Time'])->toDateTimeString();
                $diffinminutes = Carbon::parse($startdatetime)->diffInSeconds(Carbon::parse($enddatetime));
                $gmate = gmdate('H:i:s', $diffinminutes);
                $no_of_hours = $gmate;
                //$no_of_hours = $fhourtoadd;
                $no_of_days = 1;
            }

           
            
            $month = Carbon::parse($startdate)->format('m');
            $currentmonth = Carbon::now()->format('m');
            $year = Carbon::parse($startdate)->format('Y');
            $currentyear = Carbon::now()->format('Y');
           $getid = DB::connection('mysql6')->table('leave_processed')->insertGetId([
                'employeeid' => $employeeid,
                'month' => $month,
                'year' => $year,
                'type' => $leave_type,
                'stdate' => $startdatetime,
                'etdate' => $enddatetime,
                'no_of_hours' => $no_of_hours,
                'no_of_days' => $no_of_days,
                'partial_days' => $partial_days,
                'emp_reason' => $leave_reason,
                'created_date' => Carbon::now()->toDateTimeString(),
                'hod_status' => 'Pending',
                'hod_reason' => null,
                'hod_created_date' => null,
                'admin_status' => 'Pending',
                'admin_reason' => null,
                'admin_created_date' => null,
                'final_status' => 'Pending',
                'saved_file_path' => null,
                'valid_till' => Carbon::now()->addDays(5)->toDateTimeString()
            ]);

            $newstarttime = explode(' ', $startdatetime);
            $newendtime = explode(' ', $enddatetime);
            
            DB::connection('mysql6')->table('datetime_ref')->insert([
                'employeeid' => $employeeid,
                'month' => Carbon::parse($startdate)->format('m'),
                'year' => Carbon::parse($startdate)->format('Y'),
                'applied_month' => $currentmonth,
                'applied_year' => $currentyear,
                'type' => $leave_type,
                'shift_code' => $getshiftdetails['Shift_Details']['Shift_Code'],
                'final_status' => 'Pending',
                'date' => $startdate,
                'start_end_time' => $newstarttime[1].'-'.$newendtime[1],
                'partial_days' => $partial_days,
                'reference_id' => $getid
            ]);

            $randomno1 = rand(1, 5000);
            $toencrypt1 = $employeeid.'-#hod#-'.$getid.'-'.$randomno1.$leave_type;
            $hodencrypt = Crypt::encrypt($toencrypt1);

            DB::connection('mysql6')->table('lms_mail_queue')->insert([
                'reference_id' => $getid,
                'hod_session_key' => $hodencrypt,
                'sent_to_hod' => null,
                'admin_session_key' => null,
                'sent_to_admin' => null,
                'processed' => 0
            ]);

            $getbalance = DB::connection('mysql6')->table('leave_balance')->where(['employeeid' => $employeeid, 'month' => $currentmonth,'year' => $currentyear])->get();
            foreach ($getbalance as $key6 => $value6) {
                $bal = $value6->$leave_type;
            }
            if ($leave_type == 'Tour') {
                $minus_bal = $bal + $no_of_days;
            }
            elseif ($leave_type == 'Onduty') {
                $minus_bal = $bal + $no_of_days;
            }
            elseif ($leave_type == 'LOP') {
                $minus_bal = $bal + $no_of_days;
            }
            elseif ($leave_type == 'Mispunch') {
                $minus_bal = $bal + $no_of_days;
            }
            else{
            $minus_bal = $bal - $no_of_days;
            }

            DB::connection('mysql6')->table('leave_balance')->where(['employeeid' => $employeeid, 'month' => $currentmonth,'year' => $currentyear])
            ->update([
                $leave_type => $minus_bal
            ]);


        }
        else{

            $getshiftdetails = $this->getshiftdetailsst_et_date($employeeid, $startdate, $enddate);
            $hourtoadd = 0;
            $time = 0;
            $time_arr =  [];
             
            
                foreach ($getshiftdetails['Shift_Details'] as $key2 => $value2) {

                        if (($value2['Shift_Code'] == 'VGN_NIGT') || ($value2['Shift_Code'] == 'VGN_FNIG')) {
                            $std = Carbon::parse($value2['Shift_Date'])->addDay()->toDateString();
                        }
                        else{
                            $std = $value2['Shift_Date'];
                        }

                        //$fhourtoadd = substr(Carbon::parse($value2['Shift_Date'].' '.$value2['Start_Time'])->diff(Carbon::parse($std.' '.$value2['End_Time']))->format('%H:%i:%s'), 0,2);
                        
                       // $hourtoadd = $fhourtoadd + $hourtoadd;

                        $diffintimehours = Carbon::parse($value2['Shift_Date'].' '.$value2['Start_Time'])->diffInSeconds(Carbon::parse($std.' '.$value2['End_Time']));
                        $newhours = gmdate('H:i', $diffintimehours); 
                        array_push($time_arr, $newhours);
                    
                }
                
                foreach ($time_arr as $k => $time_val) {

                    $time += $this->explode_time($time_val); 
                }

                $hourtoadd = $this->second_to_hhmm($time);
                   
                

            if (($getshiftdetails['Shift_Details'][0]['Shift_Code'] == 'VGN_NIGT') || ($getshiftdetails['Shift_Details'][0]['Shift_Code'] == 'VGN_FNIG')) {
                
                $std_string = Carbon::parse($getshiftdetails['Shift_Details'][0]['Shift_Date'])->addDay()->toDateString();
                $startdatetime = $getshiftdetails['Shift_Details'][0]['Shift_Date'].' '.$getshiftdetails['Shift_Details'][0]['Start_Time'];

            }
            else{
                $startdatetime = $getshiftdetails['Shift_Details'][0]['Shift_Date'].' '.$getshiftdetails['Shift_Details'][0]['Start_Time'];
            }

            if (($getshiftdetails['Shift_Details'][count($getshiftdetails['Shift_Details']) - 1]['Shift_Code'] == 'VGN_NIGT') || ($getshiftdetails['Shift_Details'][count($getshiftdetails['Shift_Details']) - 1]['Shift_Code'] == 'VGN_FNIG')) {

                $std_string = Carbon::parse($getshiftdetails['Shift_Details'][count($getshiftdetails['Shift_Details']) - 1]['Shift_Date'])->addDay()->toDateString();
                $enddatetime = $std_string.' '.$getshiftdetails['Shift_Details'][count($getshiftdetails['Shift_Details']) - 1]['End_Time'];

            }
            else{
                $enddatetime = $getshiftdetails['Shift_Details'][count($getshiftdetails['Shift_Details']) - 1]['Shift_Date'].' '.$getshiftdetails['Shift_Details'][count($getshiftdetails['Shift_Details']) - 1]['End_Time'];
            }
            
            $no_of_hours = $hourtoadd;
            
            $month = Carbon::parse($startdate)->format('m');
            $currentmonth = Carbon::now()->format('m');
            $year = Carbon::parse($startdate)->format('Y');
            $currentyear = Carbon::now()->format('Y');
           $getid = DB::connection('mysql6')->table('leave_processed')->insertGetId([
                'employeeid' => $employeeid,
                'month' => $month,
                'year' => $year,
                'type' => $leave_type,
                'stdate' => $startdatetime,
                'etdate' => $enddatetime,
                'no_of_hours' => $no_of_hours,
                'no_of_days' => $diff,
                'partial_days' => $partial_days,
                'emp_reason' => $leave_reason,
                'created_date' => Carbon::now()->toDateTimeString(),
                'hod_status' => 'Pending',
                'hod_reason' => null,
                'hod_created_date' => null,
                'admin_status' => 'Pending',
                'admin_reason' => null,
                'admin_created_date' => null,
                'final_status' => 'Pending',
                'saved_file_path' => null,
                'valid_till' => Carbon::now()->addDays(5)->toDateTimeString()
            ]);
        $daterange_array = $this->createDateRange($startdate, $enddate, $format = "Y-m-d");
        array_push($daterange_array, $enddate);
            
        foreach ($daterange_array as $key => $value) {
            foreach ($getshiftdetails['Shift_Details'] as $key3 => $value3) {
                if ($value == $value3['Shift_Date']) {
                    DB::connection('mysql6')->table('datetime_ref')->insert([
                        'employeeid' => $employeeid,
                        'month' => Carbon::parse($value)->format('m'),
                        'year' => Carbon::parse($value)->format('Y'),
                        'applied_month' => $currentmonth,
                        'applied_year' => $currentyear,
                        'type' => $leave_type,
                        'shift_code' => $value3['Shift_Code'],
                        'final_status' => 'Pending',
                        'date' => $value,
                        'start_end_time' => $value3['Start_Time'].'-'.$value3['End_Time'],
                        'partial_days' => $partial_days,
                        'reference_id' => $getid
                    ]);
                }
            }
          
        }

        $randomno1 = rand(1, 5000);
        $toencrypt1 = $employeeid.'-#hod#-'.$getid.'-'.$randomno1.$leave_type;
        $hodencrypt = Crypt::encrypt($toencrypt1);

        DB::connection('mysql6')->table('lms_mail_queue')->insert([
            'reference_id' => $getid,
            'hod_session_key' => $hodencrypt,
            'sent_to_hod' => null,
            'admin_session_key' => null,
            'sent_to_admin' => null,
            'processed' => 0
        ]);
        $getbalance = DB::connection('mysql6')->table('leave_balance')->where(['employeeid' => $employeeid, 'month' => $currentmonth,'year' => $currentyear])->get();
        foreach ($getbalance as $key6 => $value6) {
            $bal = $value6->$leave_type;
        }
        if ($leave_type == 'Tour') {
            $minus_bal = $bal + $diff;
        }
        elseif ($leave_type == 'Onduty') {
            $minus_bal = $bal + $diff;
        }
        elseif ($leave_type == 'LOP') {
            $minus_bal = $bal + $diff;
        }
        elseif ($leave_type == 'Mispunch') {
            $minus_bal = $bal + $diff;
        }
        else{
        $minus_bal = $bal - $diff;
        }
        
        DB::connection('mysql6')->table('leave_balance')->where(['employeeid' => $employeeid, 'month' => $currentmonth,'year' => $currentyear])
            ->update([
                $leave_type => $minus_bal
            ]);
        }
        
        return true;
    }


    public function slprocess($employeeid, $startdate, $enddate, $partial_days, $leave_type,$leave_reason, $diff, $getactivedetails, $request)
    {
        if ($diff == 1) {
            $getshiftdetails = $this->getshiftdetailsst_et_date($employeeid, $startdate, $startdate);
            
            if (($getshiftdetails['Shift_Details']['Shift_Code'] == 'VGN_NIGT') || ($getshiftdetails['Shift_Details']['Shift_Code'] == 'VGN_FNIG')) {
                $std = Carbon::parse($startdate)->addDay()->toDateString();
            }
            else{
                $std = $startdate;
            }

            $fhourtoadd = substr(Carbon::parse($startdate.' '.$getshiftdetails['Shift_Details']['Start_Time'])->diff(Carbon::parse($std.' '.$getshiftdetails['Shift_Details']['End_Time']))->format('%H:%i:%s'), 0,2);
            
            if ($partial_days == 'first_half') { 
               $hourtoadd = $fhourtoadd/2;
               $startdatetime = $startdate.' '.$getshiftdetails['Shift_Details']['Start_Time'];
               $enddatetime = $std.' '.$getshiftdetails['Shift_Details']['End_Time'];
               //$startdatetime = Carbon::parse($startdate.' '.$getshiftdetails['Shift_Details']['Start_Time'])->toDateTimeString();
               //$enddatetime = Carbon::parse($std.' '.$getshiftdetails['Shift_Details']['End_Time'])->subHours($hourtoadd)->subHour()->toDateTimeString();
               $no_of_days = 0.5;
              // $no_of_hours = $hourtoadd;

               $diffinminutes = Carbon::parse($startdatetime)->diffInSeconds(Carbon::parse($enddatetime));
               $minutesdivide = $diffinminutes/2;
               $gmate = gmdate('H:i:s', $minutesdivide);
               
               $splitsub = explode(':', $gmate);
               
               if (($getshiftdetails['Shift_Details']['Shift_Code'] == 'VGN_GEN') || ($getshiftdetails['Shift_Details']['Shift_Code'] == 'VGN_GEN2') || ($getshiftdetails['Shift_Details']['Shift_Code'] == 'VGN_RCP1') || ($getshiftdetails['Shift_Details']['Shift_Code'] == 'VGN_RCP2') || ($getshiftdetails['Shift_Details']['Shift_Code'] == 'VGN_SAP') || ($getshiftdetails['Shift_Details']['Shift_Code'] == 'VGN_MGR') ) {
               $enddatetime = Carbon::parse($startdatetime)->addHours($splitsub[0])->addMinutes($splitsub[1])->subMinutes(30)->toDateTimeString();
               $diffintimehours = Carbon::parse($startdatetime)->diffInSeconds(Carbon::parse($enddatetime));
               $no_of_hours = gmdate('H:i:s', $diffintimehours);    
               }
               else{
                   $enddatetime = Carbon::parse($startdatetime)->addHours($splitsub[0])->addMinutes($splitsub[1])->toDateTimeString();
                   $no_of_hours = $gmate;
               }
               
               
            }
            elseif ($partial_days == 'second_half') {
                $hourtoadd = $fhourtoadd/2;
                $startdatetime = $startdate.' '.$getshiftdetails['Shift_Details']['Start_Time'];
               $enddatetime = $startdate.' '.$getshiftdetails['Shift_Details']['End_Time'];
                //$startdatetime = Carbon::parse($startdate.' '.$getshiftdetails['Shift_Details']['End_Time'])->subHours($hourtoadd)->subHour()->toDateTimeString();
                //$enddatetime = Carbon::parse($startdate.' '.$getshiftdetails['Shift_Details']['End_Time'])->toDateTimeString();
                //$no_of_hours = $hourtoadd;
                $no_of_days = 0.5;

                $diffinminutes = Carbon::parse($startdatetime)->diffInSeconds(Carbon::parse($enddatetime));
                $minutesdivide = $diffinminutes/2;
                $gmate = gmdate('H:i:s', $minutesdivide);
                
                $splitsub = explode(':', $gmate);
                if (($getshiftdetails['Shift_Details']['Shift_Code'] == 'VGN_GEN') || ($getshiftdetails['Shift_Details']['Shift_Code'] == 'VGN_GEN2') || ($getshiftdetails['Shift_Details']['Shift_Code'] == 'VGN_RCP1') || ($getshiftdetails['Shift_Details']['Shift_Code'] == 'VGN_RCP2') || ($getshiftdetails['Shift_Details']['Shift_Code'] == 'VGN_SAP') || ($getshiftdetails['Shift_Details']['Shift_Code'] == 'VGN_MGR') ) {
                $startdatetime = Carbon::parse($startdatetime)->addHours($splitsub[0])->addMinutes($splitsub[1])->subMinutes(30)->toDateTimeString();
                $diffintimehours = Carbon::parse($startdatetime)->diffInSeconds(Carbon::parse($enddatetime));
                $no_of_hours = gmdate('H:i:s', $diffintimehours); 
                }
                else{
                    $startdatetime = Carbon::parse($startdatetime)->addHours($splitsub[0])->addMinutes($splitsub[1])->toDateTimeString();
                    $no_of_hours = $gmate;
                }
            }
            else{
                $startdatetime = Carbon::parse($startdate.' '.$getshiftdetails['Shift_Details']['Start_Time'])->toDateTimeString();
                $enddatetime = Carbon::parse($std.' '.$getshiftdetails['Shift_Details']['End_Time'])->toDateTimeString();
                $diffinminutes = Carbon::parse($startdatetime)->diffInSeconds(Carbon::parse($enddatetime));
                $gmate = gmdate('H:i:s', $diffinminutes);
                $no_of_hours = $gmate;
                //$no_of_hours = $fhourtoadd;
                $no_of_days = 1;
            }
            

            $month = Carbon::parse($startdate)->format('m');
            $currentmonth = Carbon::now()->format('m');
            $year = Carbon::parse($startdate)->format('Y');
            $currentyear = Carbon::now()->format('Y');
           $getid = DB::connection('mysql6')->table('leave_processed')->insertGetId([
                'employeeid' => $employeeid,
                'month' => $month,
                'year' => $year,
                'type' => $leave_type,
                'stdate' => $startdatetime,
                'etdate' => $enddatetime,
                'no_of_hours' => $no_of_hours,
                'no_of_days' => $no_of_days,
                'partial_days' => $partial_days,
                'emp_reason' => $leave_reason,
                'created_date' => Carbon::now()->toDateTimeString(),
                'hod_status' => 'Pending',
                'hod_reason' => null,
                'hod_created_date' => null,
                'admin_status' => 'Pending',
                'admin_reason' => null,
                'admin_created_date' => null,
                'final_status' => 'Pending',
                'saved_file_path' => null,
                'valid_till' => Carbon::now()->addDays(5)->toDateTimeString()
            ]);

            $newstarttime = explode(' ', $startdatetime);
            $newendtime = explode(' ', $enddatetime);
            
            DB::connection('mysql6')->table('datetime_ref')->insert([
                'employeeid' => $employeeid,
                'month' => Carbon::parse($startdate)->format('m'),
                'year' => Carbon::parse($startdate)->format('Y'),
                'applied_month' => $currentmonth,
                'applied_year' => $currentyear,
                'type' => $leave_type,
                'shift_code' => $getshiftdetails['Shift_Details']['Shift_Code'],
                'final_status' => 'Pending',
                'date' => $startdate,
                'start_end_time' => $newstarttime[1].'-'.$newendtime[1],
                'partial_days' => $partial_days,
                'reference_id' => $getid
            ]);

            $randomno1 = rand(1, 5000);
            $toencrypt1 = $employeeid.'-#hod#-'.$getid.'-'.$randomno1.$leave_type;
            $hodencrypt = Crypt::encrypt($toencrypt1);

            DB::connection('mysql6')->table('lms_mail_queue')->insert([
                'reference_id' => $getid,
                'hod_session_key' => $hodencrypt,
                'sent_to_hod' => null,
                'admin_session_key' => null,
                'sent_to_admin' => null,
                'processed' => 0
            ]);

            $getbalance = DB::connection('mysql6')->table('leave_balance')->where(['employeeid' => $employeeid, 'month' => $currentmonth,'year' => $currentyear])->get();
            foreach ($getbalance as $key6 => $value6) {
                $bal = $value6->$leave_type;
            }
            $minus_bal = $bal - $no_of_days;

            DB::connection('mysql6')->table('leave_balance')->where(['employeeid' => $employeeid, 'month' => $currentmonth,'year' => $currentyear])
            ->update([
                $leave_type => $minus_bal
            ]);


        }
        else{

            $getshiftdetails = $this->getshiftdetailsst_et_date($employeeid, $startdate, $enddate);
            $hourtoadd = 0;
            $time = 0;
            $time_arr = [];
            
                foreach ($getshiftdetails['Shift_Details'] as $key2 => $value2) {

                        if (($value2['Shift_Code'] == 'VGN_NIGT') || ($value2['Shift_Code'] == 'VGN_FNIG')) {
                            $std = Carbon::parse($value2['Shift_Date'])->addDay()->toDateString();
                        }
                        else{
                            $std = $value2['Shift_Date'];
                        }

                        //$fhourtoadd = substr(Carbon::parse($value2['Shift_Date'].' '.$value2['Start_Time'])->diff(Carbon::parse($std.' '.$value2['End_Time']))->format('%H:%i:%s'), 0,2);
                        
                        //$hourtoadd = $fhourtoadd + $hourtoadd;
                        $diffintimehours = Carbon::parse($value2['Shift_Date'].' '.$value2['Start_Time'])->diffInSeconds(Carbon::parse($std.' '.$value2['End_Time']));
                        $newhours = gmdate('H:i', $diffintimehours); 
                        array_push($time_arr, $newhours);
                    
                }
                
                foreach ($time_arr as $k => $time_val) {

                    $time += $this->explode_time($time_val); 
                }

                $hourtoadd = $this->second_to_hhmm($time);
                   

            if (($getshiftdetails['Shift_Details'][0]['Shift_Code'] == 'VGN_NIGT') || ($getshiftdetails['Shift_Details'][0]['Shift_Code'] == 'VGN_FNIG')) {
                
                $std_string = Carbon::parse($getshiftdetails['Shift_Details'][0]['Shift_Date'])->addDay()->toDateString();
                $startdatetime = $getshiftdetails['Shift_Details'][0]['Shift_Date'].' '.$getshiftdetails['Shift_Details'][0]['Start_Time'];

            }
            else{
                $startdatetime = $getshiftdetails['Shift_Details'][0]['Shift_Date'].' '.$getshiftdetails['Shift_Details'][0]['Start_Time'];
            }

            if (($getshiftdetails['Shift_Details'][count($getshiftdetails['Shift_Details']) - 1]['Shift_Code'] == 'VGN_NIGT') || ($getshiftdetails['Shift_Details'][count($getshiftdetails['Shift_Details']) - 1]['Shift_Code'] == 'VGN_FNIG')) {

                $std_string = Carbon::parse($getshiftdetails['Shift_Details'][count($getshiftdetails['Shift_Details']) - 1]['Shift_Date'])->addDay()->toDateString();
                $enddatetime = $std_string.' '.$getshiftdetails['Shift_Details'][count($getshiftdetails['Shift_Details']) - 1]['End_Time'];

            }
            else{
                $enddatetime = $getshiftdetails['Shift_Details'][count($getshiftdetails['Shift_Details']) - 1]['Shift_Date'].' '.$getshiftdetails['Shift_Details'][count($getshiftdetails['Shift_Details']) - 1]['End_Time'];
            }
            
            $no_of_hours = $hourtoadd;
            
            
            $month = Carbon::parse($startdate)->format('m');
            $currentmonth = Carbon::now()->format('m');
            $year = Carbon::parse($startdate)->format('Y');
            $currentyear = Carbon::now()->format('Y');
           $getid = DB::connection('mysql6')->table('leave_processed')->insertGetId([
                'employeeid' => $employeeid,
                'month' => $month,
                'year' => $year,
                'type' => $leave_type,
                'stdate' => $startdatetime,
                'etdate' => $enddatetime,
                'no_of_hours' => $no_of_hours,
                'no_of_days' => $diff,
                'partial_days' => $partial_days,
                'emp_reason' => $leave_reason,
                'created_date' => Carbon::now()->toDateTimeString(),
                'hod_status' => 'Pending',
                'hod_reason' => null,
                'hod_created_date' => null,
                'admin_status' => 'Pending',
                'admin_reason' => null,
                'admin_created_date' => null,
                'final_status' => 'Pending',
                'saved_file_path' => null,
                'valid_till' => Carbon::now()->addDays(5)->toDateTimeString()
            ]);


            if($request->hasFile('sickleavefile')){

                $path = public_path()."/newcustomerzoneassets/sickfileupload";
                $ext = strtolower($request->file('sickleavefile')->getClientOriginalExtension());
                                                
                $newname = $getid.'_sickfile';
                //Storage::disk('employeeprofilepic_uploads')->makeDirectory($destinationpath, 0777);
                //$uploaded = Storage::disk('sickfile_uploads')->put( $newname.'.'.$ext, $request->file('sickleavefile'));

                $npath = Storage::disk('s3')->putFileAs("/newcustomerzoneassets/sickfileupload", $request->file('sickleavefile'), $newname.'.'.$ext);

                //$npath = $request->file('sickleavefile')->store($newname, 'sickfile_uploads' );
                $savedpath = Storage::disk('s3')->url("/newcustomerzoneassets/sickfileupload/".$newname.'.'.$ext);

                DB::connection('mysql6')->table('leave_processed')->where('id', $getid)
                                    ->update([
                                        'saved_file_path' => $savedpath]);
            }

        $daterange_array = $this->createDateRange($startdate, $enddate, $format = "Y-m-d");
        array_push($daterange_array, $enddate);
            
        foreach ($daterange_array as $key => $value) {
            foreach ($getshiftdetails['Shift_Details'] as $key3 => $value3) {
                if ($value == $value3['Shift_Date']) {
                    DB::connection('mysql6')->table('datetime_ref')->insert([
                        'employeeid' => $employeeid,
                        'month' => Carbon::parse($value)->format('m'),
                        'year' => Carbon::parse($value)->format('Y'),
                        'applied_month' => $currentmonth,
                        'applied_year' => $currentyear,
                        'type' => $leave_type,
                        'shift_code' => $value3['Shift_Code'],
                        'final_status' => 'Pending',
                        'date' => $value,
                        'start_end_time' => $value3['Start_Time'].'-'.$value3['End_Time'],
                        'partial_days' => $partial_days,
                        'reference_id' => $getid
                    ]);
                }
            }
          
        }

        $randomno1 = rand(1, 5000);
        $toencrypt1 = $employeeid.'-#hod#-'.$getid.'-'.$randomno1.$leave_type;
        $hodencrypt = Crypt::encrypt($toencrypt1);

        DB::connection('mysql6')->table('lms_mail_queue')->insert([
            'reference_id' => $getid,
            'hod_session_key' => $hodencrypt,
            'sent_to_hod' => null,
            'admin_session_key' => null,
            'sent_to_admin' => null,
            'processed' => 0
        ]);
        $getbalance = DB::connection('mysql6')->table('leave_balance')->where(['employeeid' => $employeeid, 'month' => $currentmonth,'year' => $currentyear])->get();
        foreach ($getbalance as $key6 => $value6) {
            $bal = $value6->$leave_type;
        }
        $minus_bal = $bal - $diff;
        
        DB::connection('mysql6')->table('leave_balance')->where(['employeeid' => $employeeid, 'month' => $currentmonth,'year' => $currentyear])
            ->update([
                $leave_type => $minus_bal
            ]);
        }
        
        return true;
    }

    public function odprocess($employeeid, $startdate, $partial_days, $leave_type,$leave_reason, $request)
    {
        if ($request->session()->has('employeesession')) {
            $encrypt = $request->session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $employeeid = $split[0];

            
            $od_period1 = $request->od_period;
            

            $splitrange = explode(' to ',$od_period1);
            $partial_days = $request->partial_days;
            
            $subday = Carbon::parse($startdate)->subDay()->toDateString();
            $addday = Carbon::parse($startdate)->addDay()->toDateString();
            $prev_day_shiftdetails = $this->getshiftdetailsst_et_date($employeeid, $subday, $subday);

            $current_day_shiftdetails = $this->getshiftdetailsst_et_date($employeeid, $startdate, $startdate);

            if (($current_day_shiftdetails['Shift_Details']['Shift_Code'] == 'VGN_NIGT') || ($current_day_shiftdetails['Shift_Details']['Shift_Code'] == 'VGN_FNIG')) {
                $std = Carbon::parse($startdate)->addDay()->toDateString();
            }
            else{
                $std = $startdate;
            }

            $fhourtoadd = substr(Carbon::parse($startdate.' '.$current_day_shiftdetails['Shift_Details']['Start_Time'])->diff(Carbon::parse($std.' '.$current_day_shiftdetails['Shift_Details']['End_Time']))->format('%H:%i:%s'), 0,2);
            
            if ($partial_days == 'first_half') { 
               $hourtoadd = $fhourtoadd/2;
               $startdatetime = $startdate.' '.$current_day_shiftdetails['Shift_Details']['Start_Time'];
               $enddatetime = $std.' '.$current_day_shiftdetails['Shift_Details']['End_Time'];
               //$startdatetime = Carbon::parse($startdate.' '.$current_day_shiftdetails['Shift_Details']['Start_Time'])->toDateTimeString();
               //$enddatetime = Carbon::parse($std.' '.$current_day_shiftdetails['Shift_Details']['End_Time'])->subHours($hourtoadd)->subHour()->toDateTimeString();
               //$no_of_hours = $hourtoadd;

               $diffinminutes = Carbon::parse($startdatetime)->diffInSeconds(Carbon::parse($enddatetime));
               $minutesdivide = $diffinminutes/2;
               $gmate = gmdate('H:i:s', $minutesdivide);
               
               $splitsub = explode(':', $gmate);
                if (($current_day_shiftdetails['Shift_Details']['Shift_Code'] == 'VGN_GEN') || ($current_day_shiftdetails['Shift_Details']['Shift_Code'] == 'VGN_GEN2') || ($current_day_shiftdetails['Shift_Details']['Shift_Code'] == 'VGN_RCP1') || ($current_day_shiftdetails['Shift_Details']['Shift_Code'] == 'VGN_RCP2') || ($current_day_shiftdetails['Shift_Details']['Shift_Code'] == 'VGN_SAP') || ($current_day_shiftdetails['Shift_Details']['Shift_Code'] == 'VGN_MGR') ) {
               $enddatetime = Carbon::parse($startdatetime)->addHours($splitsub[0])->addMinutes($splitsub[1])->subMinutes(30)->toDateTimeString();
               $diffintimehours = Carbon::parse($startdatetime)->diffInSeconds(Carbon::parse($enddatetime));
               $no_of_hours = gmdate('H:i:s', $diffintimehours);    
               }
               else{
                   $enddatetime = Carbon::parse($startdatetime)->addHours($splitsub[0])->addMinutes($splitsub[1])->toDateTimeString();
                   $no_of_hours = $gmate;
               }
               
            }
            elseif ($partial_days == 'second_half') {
                $hourtoadd = $fhourtoadd/2;
                $startdatetime = $startdate.' '.$current_day_shiftdetails['Shift_Details']['Start_Time'];
                $enddatetime = $startdate.' '.$current_day_shiftdetails['Shift_Details']['End_Time'];
                //$startdatetime = Carbon::parse($startdate.' '.$current_day_shiftdetails['Shift_Details']['End_Time'])->subHours($hourtoadd)->subHour()->toDateTimeString();
                //$enddatetime = Carbon::parse($startdate.' '.$current_day_shiftdetails['Shift_Details']['End_Time'])->toDateTimeString();
                //$no_of_hours = $hourtoadd;
                $diffinminutes = Carbon::parse($startdatetime)->diffInSeconds(Carbon::parse($enddatetime));
                $minutesdivide = $diffinminutes/2;
                $gmate = gmdate('H:i:s', $minutesdivide);
                
                $splitsub = explode(':', $gmate);
                if (($current_day_shiftdetails['Shift_Details']['Shift_Code'] == 'VGN_GEN') || ($current_day_shiftdetails['Shift_Details']['Shift_Code'] == 'VGN_GEN2') || ($current_day_shiftdetails['Shift_Details']['Shift_Code'] == 'VGN_RCP1') || ($current_day_shiftdetails['Shift_Details']['Shift_Code'] == 'VGN_RCP2') || ($current_day_shiftdetails['Shift_Details']['Shift_Code'] == 'VGN_SAP') || ($current_day_shiftdetails['Shift_Details']['Shift_Code'] == 'VGN_MGR') ) {
                $startdatetime = Carbon::parse($startdatetime)->addHours($splitsub[0])->addMinutes($splitsub[1])->subMinutes(30)->toDateTimeString();
                $diffintimehours = Carbon::parse($startdatetime)->diffInSeconds(Carbon::parse($enddatetime));
                $no_of_hours = gmdate('H:i:s', $diffintimehours); 
                }
                else{
                    $startdatetime = Carbon::parse($startdatetime)->addHours($splitsub[0])->addMinutes($splitsub[1])->toDateTimeString();
                    $no_of_hours = $gmate;
                }
                
            }
            else{
                $startdatetime = $startdate.' '.$current_day_shiftdetails['Shift_Details']['Start_Time'];
                $enddatetime = $startdate.' '.$current_day_shiftdetails['Shift_Details']['End_Time'];
                //$startdatetime = Carbon::parse($startdate.' '.$current_day_shiftdetails['Shift_Details']['Start_Time'])->toDateTimeString();
                //$enddatetime = Carbon::parse($std.' '.$current_day_shiftdetails['Shift_Details']['End_Time'])->toDateTimeString();
               // $no_of_hours = $fhourtoadd;
               $diffinminutes = Carbon::parse($startdatetime)->diffInSeconds(Carbon::parse($enddatetime));
                $gmate = gmdate('H:i:s', $diffinminutes);
                $no_of_hours = $gmate;
            }


            $current_day_shift_code = $current_day_shiftdetails['Shift_Details']['Shift_Code'];
            $previous_day_shift_code = $prev_day_shiftdetails['Shift_Details']['Shift_Code'];
            $subonehourfrom_shift_starttime = Carbon::parse($startdatetime)->subHour()->toDateTimeString();
            $addonehourfrom_shift_endtime = Carbon::parse($enddatetime)->addHour()->toDateTimeString();
            $getpunches = $this->getpunches($employeeid, Carbon::parse($startdatetime)->toDateString(), Carbon::parse($enddatetime)->toDateString());
            
            
            $calpunches = [];
            

            $res = [];                    
                $res['punchlist'] = [];

                if(!empty($getpunches)){
                    if(array_key_exists('0', $getpunches['Sorted_Punches'])){
                        $punches = $getpunches['Sorted_Punches'];
                    }
                    else{
                        if ($getpunches['Sorted_Punches']['Emp_ID'] != '') {
                            $punches[] = $getpunches['Sorted_Punches'];    
                        }else{
                            $punches = $getpunches['Sorted_Punches'];
                        }
                    }
                    if(array_key_exists('0', $punches)){                                           
                        $newarr = [];
                        $i = 0;
                        foreach ($punches as $key => $value) {
                            if ($partial_days == 'first_half') {

                                if ((Carbon::parse($value['Date'].' '.$value['Time'])->gte(Carbon::parse($subonehourfrom_shift_starttime))) && (Carbon::parse($value['Date'].' '.$value['Time'])->lte(Carbon::parse($enddatetime)))) {
                                    $newarr[$i]['key'] = $value['Date'].' '.$value['Time'];
                                $newarr[$i]['val_name'] = Carbon::parse($value['Date'].' '.$value['Time'])->format('h:i:s A');
                                $newarr[$i]['terminal_id'] = $value['Terminal_ID'];
                                $terminal = DB::connection('mysql6')->table('terminal_details')->where('terminal_id',$value['Terminal_ID'] )->get(); 
                                foreach ($terminal as $key => $value) {
                                    $terminal_name = $value->terminal_name;
                                }
                                $newarr[$i]['terminal_name'] = $terminal_name;
                                $i = $i+1;
                                }
                                
                            }
                            elseif($partial_days == 'second_half'){

                                if ((Carbon::parse($value['Date'].' '.$value['Time'])->gte(Carbon::parse($startdatetime))) && (Carbon::parse($value['Date'].' '.$value['Time'])->lte(Carbon::parse($addonehourfrom_shift_endtime)))) {
                                    $newarr[$i]['key'] = $value['Date'].' '.$value['Time'];
                                $newarr[$i]['val_name'] = Carbon::parse($value['Date'].' '.$value['Time'])->format('h:i:s A');
                                $newarr[$i]['terminal_id'] = $value['Terminal_ID'];
                                $terminal = DB::connection('mysql6')->table('terminal_details')->where('terminal_id',$value['Terminal_ID'] )->get(); 
                                foreach ($terminal as $key => $value) {
                                    $terminal_name = $value->terminal_name;
                                }
                                $newarr[$i]['terminal_name'] = $terminal_name;
                                $i = $i+1;
                                }

                            }
                            else{

                                if ((Carbon::parse($value['Date'].' '.$value['Time'])->gte(Carbon::parse($subonehourfrom_shift_starttime))) && (Carbon::parse($value['Date'].' '.$value['Time'])->lte(Carbon::parse($addonehourfrom_shift_endtime)))) {
                                    $newarr[$i]['key'] = $value['Date'].' '.$value['Time'];
                                $newarr[$i]['val_name'] = Carbon::parse($value['Date'].' '.$value['Time'])->format('h:i:s A');
                                $newarr[$i]['terminal_id'] = $value['Terminal_ID'];
                                $terminal = DB::connection('mysql6')->table('terminal_details')->where('terminal_id',$value['Terminal_ID'] )->get(); 
                                foreach ($terminal as $key => $value) {
                                    $terminal_name = $value->terminal_name;
                                }
                                $newarr[$i]['terminal_name'] = $terminal_name;
                                $i = $i+1;
                                }

                            }
                           
                            
                        }

                        
                        if (($splitrange[0] == $startdatetime) && (($splitrange[1] == $enddatetime))) {
                            
                           //start
                           if ($partial_days == 'full') {
                               $no_of_days = 1;
                           }
                           else{
                            $no_of_days = 0.5;
                           }
                            
            $fhourtoadd = substr(Carbon::parse($startdatetime)->diff(Carbon::parse($enddatetime))->format('%H:%i:%s'), 0,2);            
            $month = Carbon::parse($startdate)->format('m');
            $currentmonth = Carbon::now()->format('m');
            $year = Carbon::parse($startdate)->format('Y');
            $currentyear = Carbon::now()->format('Y');
           
           $getid = DB::connection('mysql6')->table('leave_processed')->insertGetId([
                'employeeid' => $employeeid,
                'month' => $month,
                'year' => $year,
                'type' => $leave_type,
                'stdate' => $startdatetime,
                'etdate' => $enddatetime,
                'no_of_hours' => $no_of_hours,
                'no_of_days' => $no_of_days,
                'partial_days' => $partial_days,
                'emp_reason' => $leave_reason,
                'created_date' => Carbon::now()->toDateTimeString(),
                'hod_status' => 'Pending',
                'hod_reason' => null,
                'hod_created_date' => null,
                'admin_status' => 'Pending',
                'admin_reason' => null,
                'admin_created_date' => null,
                'final_status' => 'Pending',
                'saved_file_path' => null,
                'valid_till' => Carbon::now()->addDays(5)->toDateTimeString()
            ]);

            DB::connection('mysql6')->table('od_reference')->insert([
                'employee_id' => $employeeid,
                'app_ref_id' => $getid,
                'od_datetime' => $request->punch_ref,
                'puncheslist' => json_encode($newarr),
                'created_datetime' => Carbon::now()->toDateTimeString()
            ]);


            $newstarttime = explode(' ', $startdatetime);
            $newendtime = explode(' ', $enddatetime);
            
            DB::connection('mysql6')->table('datetime_ref')->insert([
                'employeeid' => $employeeid,
                'month' => Carbon::parse($startdatetime)->format('m'),
                'year' => Carbon::parse($startdatetime)->format('Y'),
                'applied_month' => $currentmonth,
                'applied_year' => $currentyear,
                'type' => $leave_type,
                'shift_code' => $current_day_shiftdetails['Shift_Details']['Shift_Code'],
                'final_status' => 'Pending',
                'date' => $startdate,
                'start_end_time' => $newstarttime[1].'-'.$newendtime[1],
                'partial_days' => $partial_days,
                'reference_id' => $getid
            ]);

            $randomno1 = rand(1, 5000);
            $toencrypt1 = $employeeid.'-#hod#-'.$getid.'-'.$randomno1.$leave_type;
            $hodencrypt = Crypt::encrypt($toencrypt1);

            DB::connection('mysql6')->table('lms_mail_queue')->insert([
                'reference_id' => $getid,
                'hod_session_key' => $hodencrypt,
                'sent_to_hod' => null,
                'admin_session_key' => null,
                'sent_to_admin' => null,
                'processed' => 0
            ]);

            $getbalance = DB::connection('mysql6')->table('leave_balance')->where(['employeeid' => $employeeid, 'month' => $currentmonth,'year' => $currentyear])->get();
            foreach ($getbalance as $key6 => $value6) {
                $bal = $value6->$leave_type;
            }
            $minus_bal = $bal + $no_of_days;

            DB::connection('mysql6')->table('leave_balance')->where(['employeeid' => $employeeid, 'month' => $currentmonth,'year' => $currentyear])
            ->update([
                $leave_type => $minus_bal
            ]);
                return true;
                           //end


                        }
                        else{
                            return false;
                        }
                        
                        return true;


                    }else{
                        return false;
                    }
                    
                }else{
                    return false;
                }
            

        
            return true;
        }
        return false;
    }


    public function mlprocess($employeeid, $startdate, $enddate, $partial_days, $leave_type,$leave_reason, $diff, $getactivedetails, $request)
    {
    
        

            $getshiftdetails = $this->getshiftdetailsst_et_date($employeeid, $startdate, $enddate);
            $hourtoadd = 0;
            $time = 0;
            $time_arr = [];
            
                foreach ($getshiftdetails['Shift_Details'] as $key2 => $value2) {

                        if (($value2['Shift_Code'] == 'VGN_NIGT') || ($value2['Shift_Code'] == 'VGN_FNIG')) {
                            $std = Carbon::parse($value2['Shift_Date'])->addDay()->toDateString();
                        }
                        else{
                            $std = $value2['Shift_Date'];
                        }

                        //$fhourtoadd = substr(Carbon::parse($value2['Shift_Date'].' '.$value2['Start_Time'])->diff(Carbon::parse($std.' '.$value2['End_Time']))->format('%H:%i:%s'), 0,2);
                        
                        //$hourtoadd = $fhourtoadd + $hourtoadd;
                        $diffintimehours = Carbon::parse($value2['Shift_Date'].' '.$value2['Start_Time'])->diffInSeconds(Carbon::parse($std.' '.$value2['End_Time']));
                        $newhours = gmdate('H:i', $diffintimehours); 
                        array_push($time_arr, $newhours);
                    
                }
                
                foreach ($time_arr as $k => $time_val) {

                    $time += $this->explode_time($time_val); 
                }

                $hourtoadd = $this->second_to_hhmm($time);
                   
                

            if (($getshiftdetails['Shift_Details'][0]['Shift_Code'] == 'VGN_NIGT') || ($getshiftdetails['Shift_Details'][0]['Shift_Code'] == 'VGN_FNIG')) {
                
                $std_string = Carbon::parse($getshiftdetails['Shift_Details'][0]['Shift_Date'])->addDay()->toDateString();
                $startdatetime = $getshiftdetails['Shift_Details'][0]['Shift_Date'].' '.$getshiftdetails['Shift_Details'][0]['Start_Time'];

            }
            else{
                $startdatetime = $getshiftdetails['Shift_Details'][0]['Shift_Date'].' '.$getshiftdetails['Shift_Details'][0]['Start_Time'];
            }

            if (($getshiftdetails['Shift_Details'][count($getshiftdetails['Shift_Details']) - 1]['Shift_Code'] == 'VGN_NIGT') || ($getshiftdetails['Shift_Details'][count($getshiftdetails['Shift_Details']) - 1]['Shift_Code'] == 'VGN_FNIG')) {

                $std_string = Carbon::parse($getshiftdetails['Shift_Details'][count($getshiftdetails['Shift_Details']) - 1]['Shift_Date'])->addDay()->toDateString();
                $enddatetime = $std_string.' '.$getshiftdetails['Shift_Details'][count($getshiftdetails['Shift_Details']) - 1]['End_Time'];

            }
            else{
                $enddatetime = $getshiftdetails['Shift_Details'][count($getshiftdetails['Shift_Details']) - 1]['Shift_Date'].' '.$getshiftdetails['Shift_Details'][count($getshiftdetails['Shift_Details']) - 1]['End_Time'];
            }
            
            $no_of_hours = $hourtoadd;
            
            
            $month = Carbon::parse($startdate)->format('m');
            $currentmonth = Carbon::now()->format('m');
            $year = Carbon::parse($startdate)->format('Y');
            $currentyear = Carbon::now()->format('Y');
           $getid = DB::connection('mysql6')->table('leave_processed')->insertGetId([
                'employeeid' => $employeeid,
                'month' => $month,
                'year' => $year,
                'type' => $leave_type,
                'stdate' => $startdatetime,
                'etdate' => $enddatetime,
                'no_of_hours' => $no_of_hours,
                'no_of_days' => $diff,
                'partial_days' => $partial_days,
                'emp_reason' => $leave_reason,
                'created_date' => Carbon::now()->toDateTimeString(),
                'hod_status' => 'Pending',
                'hod_reason' => null,
                'hod_created_date' => null,
                'admin_status' => 'Pending',
                'admin_reason' => null,
                'admin_created_date' => null,
                'final_status' => 'Pending',
                'saved_file_path' => null,
                'valid_till' => Carbon::now()->addDays(5)->toDateTimeString()
            ]);


            if($request->hasFile('maternityfile')){

                $path = public_path()."/newcustomerzoneassets/maternityfile";
                $ext = strtolower($request->file('maternityfile')->getClientOriginalExtension());
                                                
                $newname = $getid.'_maternityfile';
                
                $npath = $request->file('maternityfile')->store(
                    $newname, 'maternityfile_uploads'
                );

                DB::connection('mysql6')->table('leave_processed')->where('id', $getid)
                                    ->update([
                                        'saved_file_path' => $npath]);
        }

        $daterange_array = $this->createDateRange($startdate, $enddate, $format = "Y-m-d");
        array_push($daterange_array, $enddate);
            
        foreach ($daterange_array as $key => $value) {
            foreach ($getshiftdetails['Shift_Details'] as $key3 => $value3) {
                if ($value == $value3['Shift_Date']) {
                    DB::connection('mysql6')->table('datetime_ref')->insert([
                        'employeeid' => $employeeid,
                        'month' => Carbon::parse($value)->format('m'),
                        'year' => Carbon::parse($value)->format('Y'),
                        'applied_month' => $currentmonth,
                        'applied_year' => $currentyear,
                        'type' => $leave_type,
                        'shift_code' => $value3['Shift_Code'],
                        'final_status' => 'Pending',
                        'date' => $value,
                        'start_end_time' => $value3['Start_Time'].'-'.$value3['End_Time'],
                        'partial_days' => $partial_days,
                        'reference_id' => $getid
                    ]);
                }
            }
          
        }

        $randomno1 = rand(1, 5000);
        $toencrypt1 = $employeeid.'-#hod#-'.$getid.'-'.$randomno1.$leave_type;
        $hodencrypt = Crypt::encrypt($toencrypt1);

        DB::connection('mysql6')->table('lms_mail_queue')->insert([
            'reference_id' => $getid,
            'hod_session_key' => $hodencrypt,
            'sent_to_hod' => null,
            'admin_session_key' => null,
            'sent_to_admin' => null,
            'processed' => 0
        ]);
        $getbalance = DB::connection('mysql6')->table('leave_balance')->where(['employeeid' => $employeeid, 'month' => $currentmonth,'year' => $currentyear])->get();
        foreach ($getbalance as $key6 => $value6) {
            $bal = $value6->$leave_type;
        }
        $minus_bal = $bal - $diff;
        
        DB::connection('mysql6')->table('leave_balance')->where(['employeeid' => $employeeid, 'month' => $currentmonth,'year' => $currentyear])
            ->update([
                $leave_type => $minus_bal
            ]);
        
        
        return true;
    }

    public function newmyattendance(Request $request)
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
            
$startofmonth = Carbon::now()->startOfMonth()->toDateString();
$endofmonth = Carbon::now()->endOfMonth()->toDateString();

$active_emp = $this->getallactiveemployees();
//dd($active_emp);            
$employee_punches = $this->getpunches($employeeid, $startofmonth, $endofmonth); 
$getshiftdetails = $this->getshiftdetailsst_et_date($employeeid, $startofmonth, $endofmonth);     
$sorted_punches = [];

$daterange = $this->createDateRange($startofmonth, $endofmonth, $format = "Y-m-d");


foreach ($daterange as $key1 => $value1) {
    $k = 0;
    $sorted_punches[$value1]['punchlist'] = [];
    $sorted_punches[$value1]['terminal_id'] = [];
    $sorted_punches[$value1]['shift_code'] = [];
    $sorted_punches[$value1]['start_time'] = [];
    $sorted_punches[$value1]['end_time'] = [];
   
    foreach ($employee_punches['Sorted_Punches'] as $key2 => $value2) {
        if ($value1 == $value2['Date']) {
            $sorted_punches[$value1]['punchlist'][$k] = $value2['Time'];
            $sorted_punches[$value1]['terminal_id'][$k] = $value2['Terminal_ID'];            
            $k = $k + 1;
        }
    }

    foreach ($getshiftdetails['Shift_Details'] as $key3 => $value3) {
        if ($value1 == $value3['Shift_Date']) {
            $sorted_punches[$value1]['shift_code'] = $value3['Shift_Code'];
            $sorted_punches[$value1]['start_time'] = $value3['Start_Time'];
            $sorted_punches[$value1]['end_time'] = $value3['End_Time'];
            $sorted_punches[$value1]['cadre'] = $cadre;
        }
    }
}



//dd($sorted_punches);

            
           $listfiles = Storage::disk('s3')->files("/newcustomerzoneassets/employeeprofileimage/".$employeeid);             
             if(count($listfiles) > 0){
                $profilepic = config('app.AWS_URL')."/".$listfiles[0];
            }
             else
             {
                $profilepic = config('app.AWS_URL')."/newcustomerzoneassets/img/dummy_male.png";
             }
            
           
            
                         
            return view('newemployeezone.lms.newlateinfo_for_admin')->with(['getemployeedata'=> $getemployeedata, 'getattendance'=> $datearray,'montharray' => $montharray, 'yeararray'=>$yeararray,'currentyear' => $currentyear,'currentmonth'=>$currentmonth,'currentdate'=>$currentdate,'profilepic' => $profilepic]);
            
             }
       else{
           return redirect()->route('newemployee_home');
       }
    }


    public function getnewodpunches(Request $request)
    {
        if ($request->session()->has('employeesession')) {
            $encrypt = $request->session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $employeeid = $split[0];

        $start_date = $request->startdate;
        $split_twodate = explode('-',$start_date);

        $split_startdate_explode = explode(' ', $split_twodate[0]);
        $formatstdate1 = $this->dateformatreturnddmmyytoyymmdd(trim($split_startdate_explode[0]));
        $formatstdatetime1 = explode(':', $split_startdate_explode[1]);

        if ($split_startdate_explode[2] == 'PM') {
            $time1 = ($formatstdatetime1[0] + 12).':'.$formatstdatetime1[1].':00';
        }
        else{
            $time1 = $formatstdatetime1[0].':'.$formatstdatetime1[1].':00';
        }
        $formatteddatetime1 = Carbon::parse($formatstdate1.' '.$time1)->toDateTimeString();
        $start_dateod = Carbon::parse($formatteddatetime1)->toDateString();


        $split_startdate_explode1 = explode(' ', trim($split_twodate[1]));
        $formatstdate2 = $this->dateformatreturnddmmyytoyymmdd(trim($split_startdate_explode1[0]));
        $formatstdatetime2 = explode(':', $split_startdate_explode1[1]);

        if ($split_startdate_explode1[2] == 'PM') {
            $time1 = ($formatstdatetime2[0] + 12).':'.$formatstdatetime2[1].':00';
        }
        else{
            $time1 = $formatstdatetime2[0].':'.$formatstdatetime2[1].':00';
        }
        $formatteddatetime2 = Carbon::parse($formatstdate2.' '.$time1)->toDateTimeString();
        $end_dateod = Carbon::parse($formatteddatetime2)->toDateString();

        $getshiftdetails = $this->getshiftdetailsst_et_date($employeeid, $start_dateod, $end_dateod);
        
        if (($getshiftdetails['Shift_Details']['Shift_Code'] == 'VGN_NIGT') || ($getshiftdetails['Shift_Details']['Shift_Code'] == 'VGN_FNIG')) {
            
            $end_dateod = Carbon::parse($start_dateod)->addDay()->toDateString();
        }
        else{
            $end_dateod = $start_dateod;
        }

        $return_array = [];
        $return_array['Shift_start_time'] = $start_dateod.' '.$getshiftdetails['Shift_Details']['Start_Time'];
        $return_array['Shift_end_time'] = $end_dateod.' '.$getshiftdetails['Shift_Details']['End_Time'];
        $return_array['punches'] = [];
        
        
        $getpunches = $this->getpunches($employeeid, $start_dateod, $end_dateod);


        
        $shiftsttime = $start_dateod.' '.$getshiftdetails['Shift_Details']['Start_Time'];
        $shiftettime = $end_dateod.' '.$getshiftdetails['Shift_Details']['End_Time'];

        

        if(!empty($getpunches)){
            if(array_key_exists('0', $getpunches['Sorted_Punches'])){
                $punches = $getpunches['Sorted_Punches'];
            }
            else{
                if ($getpunches['Sorted_Punches']['Emp_ID'] != '') {
                    $punches[] = $getpunches['Sorted_Punches'];    
                }else{
                    $punches = $getpunches['Sorted_Punches'];
                }
            }
            if(array_key_exists('0', $punches)){
                

                foreach ($punches as $key => $value) {
                    $sttime = Carbon::parse($value['Date'].' '.$value['Time'])->toDateTimeString();

                    if ((Carbon::parse($sttime)->gte(Carbon::parse($formatteddatetime1))) && (Carbon::parse($sttime)->lte(Carbon::parse($formatteddatetime2)))) {
                        $return_array['punches'][] = Carbon::parse($value['Date'].' '.$value['Time'])->format('d, M Y h:i:s A');
                    }

                   
                }
                
                return response()
            ->json([$return_array], 200);
            }else{
                return response()
            ->json([$return_array], 200);
            }
            
        }else{
            return response()
            ->json([$return_array], 200);
        }
        

        }
        
        return response()
            ->json(['message' => "Unauthorized"], 401);
    }


    public function getodmissing_punch(Request $request)
    {
        if ($request->session()->has('employeesession')) {
            $encrypt = $request->session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $employeeid = $split[0];
        $start_date =  $request->startdate;
        $od_required = $request->od_punch;
        $partial_days = $request->partial_days;

        if (($partial_days == 'full') && ($od_required == 'eod')) {

            $subday = Carbon::parse($start_date)->subDay()->toDateString();
            $addday = Carbon::parse($start_date)->addDay()->toDateString();
            $prev_day_shiftdetails = $this->getshiftdetailsst_et_date($employeeid, $subday, $subday);

            $current_day_shiftdetails = $this->getshiftdetailsst_et_date($employeeid, $start_date, $start_date);
            
            if (($prev_day_shiftdetails['Shift_Details']['Shift_Code'] == 'VGN_NIGT') || ($prev_day_shiftdetails['Shift_Details']['Shift_Code'] == 'VGN_FNIG')) {
                $getpunches_start_after = $start_date.' '.$prev_day_shiftdetails['Shift_Details']['End_Time'];
            }
            else{
                $getpunches_start_after = '';
               // $getpunches_start_after = $start_date.' 08:30:00';
            }

            if (($current_day_shiftdetails['Shift_Details']['Shift_Code'] == 'VGN_NIGT') || ($current_day_shiftdetails['Shift_Details']['Shift_Code'] == 'VGN_FNIG')) {
                //$getpunches_start_after = $start_date.' '.$current_day_shiftdetails['Shift_Details']['End_Time'];

              

                $getpunches = $this->getpunches($employeeid, $start_date, $addday);

                $onehourlessthanshiftstart = Carbon::parse($start_date.' '.$current_day_shiftdetails['Shift_Details']['Start_Time'])->subHour()->toDateTimeString();

                $newpunchlist = [];
                if(!empty($getpunches)){
                    if(array_key_exists('0', $getpunches['Sorted_Punches'])){
                        $punches = $getpunches['Sorted_Punches'];
                    }
                    else{
                        if ($getpunches['Sorted_Punches']['Emp_ID'] != '') {
                            $punches[] = $getpunches['Sorted_Punches'];    
                        }else{
                            $punches = $getpunches['Sorted_Punches'];
                        }
                    }
                    if(array_key_exists('0', $punches)){
                        
                        foreach ($punches as $key => $value) {
                            
                            $formatted_time = Carbon::parse($value['Date'].' '.$value['Time'])->toDateTimeString();
                            
                                if (Carbon::parse($formatted_time)->gte(Carbon::parse($onehourlessthanshiftstart))) {
                                    $newpunchlist[] = $formatted_time;
                                }
                            

                           //$newpunchlist[]['Date'] = ;
                        }

                        if (Carbon::parse($newpunchlist[count($newpunchlist) - 1])->gte(Carbon::parse($start_date.' '.$current_day_shiftdetails['Shift_Details']['End_Time']))) {
                            $odtime = 'Your Onduty Application does not meet up the requirement!';
                            return response()
                            ->json(['punches' => [], 'odtime' => $odtime], 200);
                        }
                        
                        $odtime = 'Onduty will be applied from '.Carbon::parse($newpunchlist[count($newpunchlist) - 1])->format('d, M, Y h:i:s A').' to '.Carbon::parse($start_date.' '.$current_day_shiftdetails['Shift_Details']['End_Time'])->format('d, M, Y h:i:s A');
                        
                        return response()
                    ->json(['punches' => $newpunchlist[count($newpunchlist) - 1], 'odtime' => $odtime], 200);
                    }else{
                        return response()
                    ->json(['punches'=> [],'odtime' => '' ], 200);
                    }
                    
                }else{
                    return response()
                    ->json(['punches'=> [],'odtime' => ''], 200);
                }
            
            }
            else{

                $getpunches = $this->getpunches($employeeid, $start_date, $start_date);
                $newpunchlist = [];
                if(!empty($getpunches)){
                    if(array_key_exists('0', $getpunches['Sorted_Punches'])){
                        $punches = $getpunches['Sorted_Punches'];
                    }
                    else{
                        if ($getpunches['Sorted_Punches']['Emp_ID'] != '') {
                            $punches[] = $getpunches['Sorted_Punches'];    
                        }else{
                            $punches = $getpunches['Sorted_Punches'];
                        }
                    }
                    if(array_key_exists('0', $punches)){
                        
        
                        foreach ($punches as $key => $value) {
                            
                            $formatted_time = Carbon::parse($value['Date'].' '.$value['Time'])->toDateTimeString();
                            if ($getpunches_start_after != '') {
                                if (Carbon::parse($formatted_time)->gte(Carbon::parse($getpunches_start_after))) {
                                    $newpunchlist[] = $formatted_time;
                                }
                            }else{
                                $newpunchlist[] = $formatted_time;
                            }

                           //$newpunchlist[]['Date'] = ;
                        }

                        if (Carbon::parse($newpunchlist[count($newpunchlist) - 1])->gte(Carbon::parse($start_date.' '.$current_day_shiftdetails['Shift_Details']['End_Time']))) {
                            $odtime = 'Your Onduty Application does not meet up the requirement!';
                            return response()
                            ->json(['punches' => [], 'odtime' => $odtime], 200);
                        }
                        
                        $odtime = 'Onduty will be applied from '.Carbon::parse($newpunchlist[count($newpunchlist) - 1])->format('d, M, Y h:i:s A').' to '.Carbon::parse($start_date.' '.$current_day_shiftdetails['Shift_Details']['End_Time'])->format('d, M, Y h:i:s A');
                        
                        return response()
                    ->json(['punches' => $newpunchlist[count($newpunchlist) - 1], 'odtime' => $odtime], 200);
                    }else{
                        return response()
                    ->json(['punches'=> [],'odtime' => '' ], 200);
                    }
                    
                }else{
                    return response()
                    ->json(['punches'=> [],'odtime' => ''], 200);
                }

            }

           
            return $current_day_shiftdetails;
            
            
        }

        if (($partial_days == 'full') && ($od_required == 'sod')) {

            $addday = Carbon::parse($start_date)->addDay()->toDateString();
            $prev_day_shiftdetails = $this->getshiftdetailsst_et_date($employeeid, $subday, $subday);
            
            if (($prev_day_shiftdetails['Shift_Details']['Shift_Code'] == 'VGN_NIGT') || ($prev_day_shiftdetails['Shift_Details']['Shift_Code'] == 'VGN_FNIG')) {
                $getpunches_start_after = $start_date.' '.$prev_day_shiftdetails['Shift_Details']['End_Time'];
            }
            else{
                $getpunches_start_after = '';
            }
            return $getpunches_start_after;
            
        }

        

        return $getshiftdetails;

        }
        return response()
            ->json(['message' => "Unauthorized"], 401);
    }

    public function getfinaloneodpunch(Request $request)
    {
        if ($request->session()->has('employeesession')) {
            $encrypt = $request->session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $employeeid = $split[0];
            $startdate =  $request->startdate;
            $partial_days = $request->partial_days;
            
            
            $subday = Carbon::parse($startdate)->subDay()->toDateString();
            $addday = Carbon::parse($startdate)->addDay()->toDateString();
            $prev_day_shiftdetails = $this->getshiftdetailsst_et_date($employeeid, $subday, $subday);

            $current_day_shiftdetails = $this->getshiftdetailsst_et_date($employeeid, $startdate, $startdate);

            if (($current_day_shiftdetails['Shift_Details']['Shift_Code'] == 'VGN_NIGT') || ($current_day_shiftdetails['Shift_Details']['Shift_Code'] == 'VGN_FNIG')) {
                $std = Carbon::parse($startdate)->addDay()->toDateString();
            }
            else{
                $std = $startdate;
            }

            $fhourtoadd = substr(Carbon::parse($startdate.' '.$current_day_shiftdetails['Shift_Details']['Start_Time'])->diff(Carbon::parse($std.' '.$current_day_shiftdetails['Shift_Details']['End_Time']))->format('%H:%i:%s'), 0,2);
            
            if ($partial_days == 'first_half') { 
               $hourtoadd = $fhourtoadd/2;
               $startdatetime = $startdate.' '.$current_day_shiftdetails['Shift_Details']['Start_Time'];
               $enddatetime = $std.' '.$current_day_shiftdetails['Shift_Details']['End_Time'];
               //$startdatetime = Carbon::parse($startdate.' '.$current_day_shiftdetails['Shift_Details']['Start_Time'])->toDateTimeString();
               //$enddatetime = Carbon::parse($std.' '.$current_day_shiftdetails['Shift_Details']['End_Time'])->subHours($hourtoadd)->subHour()->toDateTimeString();
               //$no_of_hours = $hourtoadd;
               $diffinminutes = Carbon::parse($startdatetime)->diffInSeconds(Carbon::parse($enddatetime));
               $minutesdivide = $diffinminutes/2;
               $gmate = gmdate('H:i:s', $minutesdivide);
               
               $splitsub = explode(':', $gmate);
               if (($current_day_shiftdetails['Shift_Details']['Shift_Code'] == 'VGN_GEN') || ($current_day_shiftdetails['Shift_Details']['Shift_Code'] == 'VGN_GEN2') || ($current_day_shiftdetails['Shift_Details']['Shift_Code'] == 'VGN_RCP1') || ($current_day_shiftdetails['Shift_Details']['Shift_Code'] == 'VGN_RCP2') || ($current_day_shiftdetails['Shift_Details']['Shift_Code'] == 'VGN_SAP') || ($current_day_shiftdetails['Shift_Details']['Shift_Code'] == 'VGN_MGR') ) {
               $enddatetime = Carbon::parse($startdatetime)->addHours($splitsub[0])->addMinutes($splitsub[1])->subMinutes(30)->toDateTimeString();
               $diffintimehours = Carbon::parse($startdatetime)->diffInSeconds(Carbon::parse($enddatetime));
               $no_of_hours = gmdate('H:i:s', $diffintimehours);    
               }
               else{
                   $enddatetime = Carbon::parse($startdatetime)->addHours($splitsub[0])->addMinutes($splitsub[1])->toDateTimeString();
                   $no_of_hours = $gmate;
               }
               
            }
            elseif ($partial_days == 'second_half') {
                $hourtoadd = $fhourtoadd/2;
                $startdatetime = $startdate.' '.$current_day_shiftdetails['Shift_Details']['Start_Time'];
               $enddatetime = $startdate.' '.$current_day_shiftdetails['Shift_Details']['End_Time'];
                //$startdatetime = Carbon::parse($startdate.' '.$current_day_shiftdetails['Shift_Details']['End_Time'])->subHours($hourtoadd)->subHour()->toDateTimeString();
                //$enddatetime = Carbon::parse($startdate.' '.$current_day_shiftdetails['Shift_Details']['End_Time'])->toDateTimeString();
                //$no_of_hours = $hourtoadd;
                $diffinminutes = Carbon::parse($startdatetime)->diffInSeconds(Carbon::parse($enddatetime));
                $minutesdivide = $diffinminutes/2;
                $gmate = gmdate('H:i:s', $minutesdivide);
                
                $splitsub = explode(':', $gmate);
                if (($current_day_shiftdetails['Shift_Details']['Shift_Code'] == 'VGN_GEN') || ($current_day_shiftdetails['Shift_Details']['Shift_Code'] == 'VGN_GEN2') || ($current_day_shiftdetails['Shift_Details']['Shift_Code'] == 'VGN_RCP1') || ($current_day_shiftdetails['Shift_Details']['Shift_Code'] == 'VGN_RCP2') || ($current_day_shiftdetails['Shift_Details']['Shift_Code'] == 'VGN_SAP') || ($current_day_shiftdetails['Shift_Details']['Shift_Code'] == 'VGN_MGR') ) {
                $startdatetime = Carbon::parse($startdatetime)->addHours($splitsub[0])->addMinutes($splitsub[1])->subMinutes(30)->toDateTimeString();
                $diffintimehours = Carbon::parse($startdatetime)->diffInSeconds(Carbon::parse($enddatetime));
                $no_of_hours = gmdate('H:i:s', $diffintimehours); 
                }
                else{
                    $startdatetime = Carbon::parse($startdatetime)->addHours($splitsub[0])->addMinutes($splitsub[1])->toDateTimeString();
                    $no_of_hours = $gmate;
                }
            }
            else{
                $startdatetime = Carbon::parse($startdate.' '.$current_day_shiftdetails['Shift_Details']['Start_Time'])->toDateTimeString();
                $enddatetime = Carbon::parse($std.' '.$current_day_shiftdetails['Shift_Details']['End_Time'])->toDateTimeString();
                $diffinminutes = Carbon::parse($startdatetime)->diffInSeconds(Carbon::parse($enddatetime));
                $gmate = gmdate('H:i:s', $diffinminutes);
                $no_of_hours = $gmate;
                //$no_of_hours = $fhourtoadd;
            }


            $current_day_shift_code = $current_day_shiftdetails['Shift_Details']['Shift_Code'];
            $previous_day_shift_code = $prev_day_shiftdetails['Shift_Details']['Shift_Code'];
            $subonehourfrom_shift_starttime = Carbon::parse($startdatetime)->subHour()->toDateTimeString();
            $addonehourfrom_shift_endtime = Carbon::parse($enddatetime)->addHour()->toDateTimeString();
            $getpunches = $this->getpunches($employeeid, Carbon::parse($startdatetime)->toDateString(), Carbon::parse($enddatetime)->toDateString());
            
            
            $calpunches = [];
            

            $res = [];                    
                $res['punchlist'] = [];
                $punches = [];
                if(!empty($getpunches)){
                    if(array_key_exists('0', $getpunches['Sorted_Punches'])){
                        $punches = $getpunches['Sorted_Punches'];
                    }
                    else{
                        if ($getpunches['Sorted_Punches']['Emp_ID'] != '') {
                            $punches[] = $getpunches['Sorted_Punches'];    
                        }else{
                            $punches = $getpunches['Sorted_Punches'];
                        }
                    }
                    
                    if(array_key_exists('0', $punches)){                                           
                        
                        $newarr = [];
                        $i = 0;
                        foreach ($punches as $key => $value) {
                            if ($partial_days == 'first_half') {

                                if ((Carbon::parse($value['Date'].' '.$value['Time'])->gte(Carbon::parse($subonehourfrom_shift_starttime))) && (Carbon::parse($value['Date'].' '.$value['Time'])->lte(Carbon::parse($enddatetime)))) {
                                    $newarr[$i]['key'] = $value['Date'].' '.$value['Time'];
                                $newarr[$i]['val_name'] = Carbon::parse($value['Date'].' '.$value['Time'])->format('h:i:s A');
                                $newarr[$i]['terminal_id'] = $value['Terminal_ID'];
                                $terminal = DB::connection('mysql6')->table('terminal_details')->where('terminal_id',$value['Terminal_ID'] )->get(); 
                                foreach ($terminal as $key => $value) {
                                    $terminal_name = $value->terminal_name;
                                }
                                $newarr[$i]['terminal_name'] = $terminal_name;
                                $i = $i+1;
                                }
                                
                            }
                            elseif($partial_days == 'second_half'){

                                if ((Carbon::parse($value['Date'].' '.$value['Time'])->gte(Carbon::parse($startdatetime))) && (Carbon::parse($value['Date'].' '.$value['Time'])->lte(Carbon::parse($addonehourfrom_shift_endtime)))) {
                                    $newarr[$i]['key'] = $value['Date'].' '.$value['Time'];
                                $newarr[$i]['val_name'] = Carbon::parse($value['Date'].' '.$value['Time'])->format('h:i:s A');
                                $newarr[$i]['terminal_id'] = $value['Terminal_ID'];
                                $terminal = DB::connection('mysql6')->table('terminal_details')->where('terminal_id',$value['Terminal_ID'] )->get(); 
                                foreach ($terminal as $key => $value) {
                                    $terminal_name = $value->terminal_name;
                                }
                                $newarr[$i]['terminal_name'] = $terminal_name;
                                $i = $i+1;
                                }

                            }
                            else{

                                if ((Carbon::parse($value['Date'].' '.$value['Time'])->gte(Carbon::parse($subonehourfrom_shift_starttime))) && (Carbon::parse($value['Date'].' '.$value['Time'])->lte(Carbon::parse($addonehourfrom_shift_endtime)))) {
                                    $newarr[$i]['key'] = $value['Date'].' '.$value['Time'];
                                $newarr[$i]['val_name'] = Carbon::parse($value['Date'].' '.$value['Time'])->format('h:i:s A');
                                $newarr[$i]['terminal_id'] = $value['Terminal_ID'];
                                $terminal = DB::connection('mysql6')->table('terminal_details')->where('terminal_id',$value['Terminal_ID'] )->get(); 
                                foreach ($terminal as $key => $value) {
                                    $terminal_name = $value->terminal_name;
                                }
                                $newarr[$i]['terminal_name'] = $terminal_name;
                                $i = $i+1;
                                }

                            }
                           
                            
                        }
                        
                        return response()
                    ->json(['punches' => $newarr,'startpunch' => $startdatetime, 'endpunch' => $enddatetime], 200);
                    }else{
                        return response()
                    ->json(['punches'=> [],'startpunch' => $startdatetime, 'endpunch' => $enddatetime ], 200);
                    }
                    
                }else{
                    return response()
                    ->json(['punches'=> [],'startpunch' => $startdatetime, 'endpunch' => $enddatetime], 200);
                }
            

        //return $startdatetime.' -- '.$enddatetime;
            return $res;
        }
        return response()
            ->json(['message' => "Unauthorized"], 401);
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
            //$getallapplications = DB::connection('mysql6')->table('lms_applications')->where('employeeid', '=', $employeeid)->orderBy('created_date', 'desc')->get();

            /*

            $getactiveemployees = $this->getallactiveemployees();
            //dd($getactiveemployees);

            foreach ($getactiveemployees['Details'] as $key => $value) {
                if ($value['Emp_ID'] == $employeeid) {
                    $active_deatils = $value;
                }
                
            }

            if (($active_deatils['Role_Code'] == 'SCT_TM(PLANT)') || ($active_deatils['Role_Code'] == 'SCT_TM(REG)')) {
                return redirect()->route('newemployee_dashboard');
            }

            if (($active_deatils['OnContract'] == 'C') || ($active_deatils['OnContract'] == 'N')) {
                return redirect()->route('newemployee_dashboard');
            }

            $currentdate = Carbon::now()->toDateString();
            $sub30days = Carbon::parse($currentdate)->subDays(30)->toDateString();

            $daterange_array = $this->createDateRange($sub30days, $currentdate, $format = "Y-m-d");
            array_push($daterange_array, $currentdate);
            $getshiftdetails = $this->getshiftdetailsst_et_date($employeeid, $sub30days, $currentdate);
            $compoff = [];
            foreach ($daterange_array as $key1 => $value1) {
                
                // $checkweekoff_holiday = $this->checkweekoff_holidays_new($employeeid, $value1, $value1, $getemployee);
                // if (($checkweekoff_holiday['holiday_count'] == 1) || ($checkweekoff_holiday['weekoff_count'] == 1)) {
                    
                // }
                // else{
                //     foreach ($getshiftdetails['Shift_Details'] as $key2 => $value2) {
                        
                //     }
                // }

                foreach ($getshiftdetails['Shift_Details'] as $key2 => $value2) {
                    
                    if (($value2['Shift_Code'] == 'VGN_NIGT') || ($value2['Shift_Code'] == 'VGN_FNIG')) {
                    
                    }
                    else{
                        //28th June 2018 is a vgn_general shift 9:30 - 18:30
                        $starttime = Carbon::parse($value2['Shift_Date'].' '.$value2['Start_Time'])->toDateTimeString();
                        $endtime = Carbon::parse($value2['Shift_Date'].' '.$value2['End_Time'])->toDateTimeString();
                         $checkweekoff_holiday = $this->checkweekoff_holidays_new($employeeid, $value1, $value1, $getemployee);
                            if (($checkweekoff_holiday['holiday_count'] == 1) || ($checkweekoff_holiday['weekoff_count'] == 1)) {
                                $fhourtoadd = substr(Carbon::parse($starttime)->diff(Carbon::parse($endtime))->format('%H:%i:%s'), 0,2);
                                dd($value1);
                            }
                            else{
                                $fhourtoadd = substr(Carbon::parse($starttime)->diff(Carbon::parse($endtime))->format('%H:%i:%s'), 0,2);
                            }


                    }

                }
                
            }
            
            dd($daterange_array);*/



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
                "full" => "Full Day",
                "first_half" => "First Half",
                "second_half" => "Second Half",
                ];

            return view('newemployeezone.lms.finalcompoff')->with(['getemployeedata'=>$getemployeedata,'partial_days_array' => $partial_days_array, 'profilepic'=>$profilepic, 'employeeid' => $employeeid]);

        }

        return view('newemployeezone.login');
    }


    public function getcompoffpunches(Request $request)
    {
        if ($request->session()->has('employeesession')) {
            $encrypt = $request->session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $employeeid = $split[0];
            
            //$startdate =  $request->startdate;
            $getemployee = DB::connection('mysql6')->table('employee')->where('id', '=', $employeeid)->get();
            $reformat_startdate = explode('/',$request->startdate);
            $startdate = $reformat_startdate[2].'-'.$reformat_startdate[1].'-'.$reformat_startdate[0];


            $compofmonth = Carbon::parse($startdate)->format('m');
            $current_month = Carbon::now()->format('m');
            if ($compofmonth < $current_month) {
                $leavemindate = Carbon::now()->startOfMonth()->format('m/d/Y');
               
            }
            else {
               $leavemindate = Carbon::parse($startdate)->addDays(1)->format('m/d/Y');
            }
            
            
            $subday = Carbon::parse($startdate)->subDay()->toDateString();
            $addday = Carbon::parse($startdate)->addDay()->toDateString();
            $prev_day_shiftdetails = $this->getshiftdetailsst_et_date($employeeid, $subday, $subday);

            $current_day_shiftdetails = $this->getshiftdetailsst_et_date($employeeid, $startdate, $startdate);

            if (($current_day_shiftdetails['Shift_Details']['Shift_Code'] == 'VGN_NIGT') || ($current_day_shiftdetails['Shift_Details']['Shift_Code'] == 'VGN_FNIG')) {
                $std = Carbon::parse($startdate)->addDay()->toDateString();
            }
            else{
                $std = $startdate;
            }

            $fhourtoadd = substr(Carbon::parse($startdate.' '.$current_day_shiftdetails['Shift_Details']['Start_Time'])->diff(Carbon::parse($std.' '.$current_day_shiftdetails['Shift_Details']['End_Time']))->format('%H:%i:%s'), 0,2);

            $current_day_shift_code = $current_day_shiftdetails['Shift_Details']['Shift_Code'];
            $previous_day_shift_code = $prev_day_shiftdetails['Shift_Details']['Shift_Code'];
            
            
            $checkweekoff_holiday = $this->checkweekoff_holidays_new($employeeid, $startdate, $startdate, $getemployee);

            $special_holiday_dates = ['2018-08-08','2019-04-18','2021-04-06'];

            if (in_array($startdate, $special_holiday_dates)) {
                
                $checkweekoff_holiday['holiday'] = true;
                $checkweekoff_holiday['holiday_count'] = 1;
            }
            
            if (($checkweekoff_holiday['holiday_count'] == 1) || ($checkweekoff_holiday['weekoff_count'] == 1)) {
                if (($previous_day_shift_code == 'VGN_NIGT') || ($previous_day_shift_code == 'VGN_FNIG')) {
                    if (($current_day_shift_code != 'VGN_NIGT') && ($current_day_shift_code != 'VGN_FNIG')) {
                        
                        // woff/holiday = prev-nightshift,curr-dayshift
                        $arr1 = [];
                        $arr2 = [];
                        $arr3 = [];
                        $addonehoursendtime = Carbon::parse($startdate.' '.$prev_day_shiftdetails['Shift_Details']['End_Time'])->addMinutes(90)->toDateTimeString();
                        $addonehoursshiftendtime = Carbon::parse($startdate.' '.$current_day_shiftdetails['Shift_Details']['End_Time'])->addMinutes(90)->toDateTimeString();
                        $add8hours = Carbon::parse($addonehoursendtime)->addHours(10)->toDateTimeString();
                        $addoneday = Carbon::parse($startdate)->addDay()->toDateString();
                        $getpunches = $this->getpunches($employeeid, $startdate, $startdate);
                        
                        $punches = $this->getsortedpunches($getpunches);
                        if (!empty($punches)) {
                            foreach ($punches as $key => $value) {
                                if ((Carbon::parse($value['key'])->gte(Carbon::parse($addonehoursendtime))) && (Carbon::parse($value['key'])->lte(Carbon::parse($addonehoursshiftendtime))) ) {
                                    $arr1[] = $value;
                                }
                            }
                        }
                        
                        if (empty($arr1)) {
                            return ['fullcompoff_hours' => 0,'punchesarr' => [],'compoffdate'=>$startdate,'compoffhours' => '','eligible' => '0','leavemindate'=> $leavemindate, 'message' => 'Compoff not eligible for this date!'];
                        }
                       
                        $compoffhours = 0;
                        $fullcompoffhours = 0;

                        if (!empty($arr1)) {
                            $compoffhours = substr(Carbon::parse($arr1[0]['key'])->diff(Carbon::parse($arr1[count($arr1) -1]['key']))->format('%H:%i:%s'), 0,2);
                            $fullcompoffhours = Carbon::parse($arr1[0]['key'])->diff(Carbon::parse($arr1[count($arr1) -1]['key']))->format('%H:%i:%s');
                        }
                        
                        if (($compoffhours >= '4') && ($compoffhours < '8')) {
                            $eligible = '0.5';
                        }
                        elseif($compoffhours >= '8'){
                            $eligible = '1';
                        }
                        else {
                            $eligible = '0';
                        }

                        
                        return ['fullcompoff_hours' => $fullcompoffhours,'punchesarr' => $arr1,'compoffdate'=>$startdate,'compoffhours' => $compoffhours,'eligible' => $eligible,'leavemindate'=> $leavemindate, 'message' => 'You are eligible for comp-off!'];


                    }
                    else{
                        // woff/holiday = prev-nightshift,nightshift
                        $arr1 = [];
                        $arr2 = [];
                        $arr3 = [];
                        $addonehoursendtime = Carbon::parse($startdate.' '.$prev_day_shiftdetails['Shift_Details']['End_Time'])->addMinutes(90)->toDateTimeString();
                        $subonehoursshiftendtime = Carbon::parse($startdate.' '.$current_day_shiftdetails['Shift_Details']['Start_Time'])->subMinutes(90)->toDateTimeString();
                        $add8hours = Carbon::parse($addonehoursendtime)->addHours(8)->toDateTimeString();
                        $addoneday = Carbon::parse($startdate)->addDay()->toDateString();
                        $getpunches = $this->getpunches($employeeid, $startdate, $startdate);
                                                
                        $punches = $this->getsortedpunches($getpunches);
                        if (!empty($punches)) {
                            foreach ($punches as $key => $value) {
                                if ((Carbon::parse($value['key'])->gte(Carbon::parse($addonehoursendtime))) && (Carbon::parse($value['key'])->lte(Carbon::parse($subonehoursshiftendtime))) ) {
                                    $arr1[] = $value;
                                }
                            }
                        }
                        
                        if (empty($arr1)) {
                            return ['fullcompoff_hours' => 0,'punchesarr' => [],'compoffdate'=>$startdate,'compoffhours' => '','eligible' => '0','leavemindate'=> $leavemindate, 'message' => 'Compoff not eligible for this date!'];
                        }
                       
                        $compoffhours = 0;
                        if (!empty($arr1)) {
                            $compoffhours = substr(Carbon::parse($arr1[0]['key'])->diff(Carbon::parse($arr1[count($arr1) -1]['key']))->format('%H:%i:%s'), 0,2);
                            $fullcompoffhours = Carbon::parse($arr1[0]['key'])->diff(Carbon::parse($arr1[count($arr1) -1]['key']))->format('%H:%i:%s');
                        }

                        if (($compoffhours >= '4') && ($compoffhours < '8')) {
                            $eligible = '0.5';
                        }
                        elseif($compoffhours >= '8'){
                            $eligible = '1';
                        }
                        else {
                            $eligible = '0';
                        }

                        
                        return ['fullcompoff_hours' => $fullcompoffhours,'punchesarr' => $arr1,'compoffdate'=>$startdate,'compoffhours' => $compoffhours,'eligible' => $eligible,'leavemindate'=> $leavemindate, 'message' => 'You are eligible for comp-off!'];
                    }
                }
                else{

                    if (($current_day_shift_code != 'VGN_NIGT') && ($current_day_shift_code != 'VGN_FNIG')) {
                        
                        // woff/holiday = prev-dayshift,dayshift
                        $arr1 = [];
                        $arr2 = [];
                        $arr3 = [];
                        $addonehourstarttime = Carbon::parse($startdate.' '.$current_day_shiftdetails['Shift_Details']['Start_Time'])->subHours(8)->toDateTimeString();
                        $addonehoursshiftendtime = Carbon::parse($startdate.' '.$current_day_shiftdetails['Shift_Details']['End_Time'])->addHours(4)->toDateTimeString();
                        $add8hours = Carbon::parse($addonehourstarttime)->addHours(8)->toDateTimeString();
                        $addoneday = Carbon::parse($startdate)->addDay()->toDateString();
                        $getpunches = $this->getpunches($employeeid, $startdate, $startdate);
                            
                        $punches = $this->getsortedpunches($getpunches);
                        
                        $startdatetime = Carbon::parse($startdate.' '.$current_day_shiftdetails['Shift_Details']['Start_Time'])->toDateTimeString();
                        $enddatetime = Carbon::parse($std.' '.$current_day_shiftdetails['Shift_Details']['End_Time'])->toDateTimeString();
                        $diffinminutes = Carbon::parse($startdatetime)->diffInSeconds(Carbon::parse($enddatetime));
                        $minutesdivide = $diffinminutes/2;
                        $gmate = gmdate('H:i:s', $minutesdivide);
                        $fullgmate = gmdate('H:i:s', $diffinminutes);
                        $halfnewextenhour = substr($gmate,0, 2);
                        $fullnewextenhour = substr($fullgmate,0, 2);
                        //return $fullnewextenhour;
                        
                        
                        if (!empty($punches)) {
                            foreach ($punches as $key => $value) {
                                if ((Carbon::parse($value['key'])->gte(Carbon::parse($addonehourstarttime))) && (Carbon::parse($value['key'])->lte(Carbon::parse($addonehoursshiftendtime))) ) {
                                    $arr1[] = $value;
                                }
                            }
                        }
                        
                        if (empty($arr1)) {
                            return ['fullcompoff_hours' => 0,'punchesarr' => [],'compoffdate'=>$startdate,'compoffhours' => '','eligible' => '0','leavemindate'=> $leavemindate, 'message' => 'Compoff not eligible for this date!'];
                        }
                       
                        $compoffhours = 0;
                        if (!empty($arr1)) {
                            $compoffhours = substr(Carbon::parse($arr1[0]['key'])->diff(Carbon::parse($arr1[count($arr1) -1]['key']))->format('%H:%i:%s'), 0,2);
                            $fullcompoffhours = Carbon::parse($arr1[0]['key'])->diff(Carbon::parse($arr1[count($arr1) -1]['key']))->format('%H:%i:%s');
                        }

                        if (($compoffhours >= '4') && ($compoffhours < '8')) {
                            $eligible = '0.5';
                        }
                        elseif($compoffhours >= '8'){
                            $eligible = '1';
                        }
                        else {
                            $eligible = '0';
                        }

                        
                        return ['fullcompoff_hours' => $fullcompoffhours,'punchesarr' => $arr1,'compoffdate'=>$startdate,'compoffhours' => $compoffhours,'eligible' => $eligible,'leavemindate'=> $leavemindate, 'message' => 'You are eligible for comp-off!'];

                    }else{
                        // woff/holiday = prev-dayshift,nightshift
                        $arr1 = [];
                        $arr2 = [];
                        $arr3 = [];
                        $addonehourstarttime = Carbon::parse($startdate.' '.$prev_day_shiftdetails['Shift_Details']['End_Time'])->addMinutes(90)->toDateTimeString();
                        $addonehoursshiftendtime = Carbon::parse($startdate.' '.$current_day_shiftdetails['Shift_Details']['End_Time'])->addMinutes(90)->toDateTimeString();
                        $add8hours = Carbon::parse($addonehourstarttime)->addHours(8)->toDateTimeString();
                        $addoneday = Carbon::parse($startdate)->addDay()->toDateString();
                        $getpunches = $this->getpunches($employeeid, $startdate, $startdate);
                                                
                        $punches = $this->getsortedpunches($getpunches);
                        if (!empty($punches)) {
                            foreach ($punches as $key => $value) {
                                if ((Carbon::parse($value['key'])->gte(Carbon::parse($addonehourstarttime))) && (Carbon::parse($value['key'])->lte(Carbon::parse($addonehoursshiftendtime))) ) {
                                    $arr1[] = $value;
                                }
                            }
                        }
                        
                        if (empty($arr1)) {
                            return ['fullcompoff_hours' => 0,'punchesarr' => [],'compoffdate'=>$startdate,'compoffhours' => '','eligible' => '0','leavemindate'=> $leavemindate, 'message' => 'Compoff not eligible for this date!'];
                        }
                       
                        $compoffhours = 0;
                        if (!empty($arr1)) {
                            $compoffhours = substr(Carbon::parse($arr1[0]['key'])->diff(Carbon::parse($arr1[count($arr1) -1]['key']))->format('%H:%i:%s'), 0,2);
                            $fullcompoffhours = Carbon::parse($arr1[0]['key'])->diff(Carbon::parse($arr1[count($arr1) -1]['key']))->format('%H:%i:%s');
                        }

                        if (($compoffhours >= '4') && ($compoffhours < '8')) {
                            $eligible = '0.5';
                        }
                        elseif($compoffhours >= '8'){
                            $eligible = '1';
                        }
                        else {
                            $eligible = '0';
                        }

                        
                        return ['fullcompoff_hours' => $fullcompoffhours,'punchesarr' => $arr1,'compoffdate'=>$startdate,'compoffhours' => $compoffhours,'eligible' => $eligible,'leavemindate'=> $leavemindate, 'message' => 'You are eligible for comp-off!'];
                    }

                }
            }
            else{

                if (($previous_day_shift_code == 'VGN_NIGT') || ($previous_day_shift_code == 'VGN_FNIG')) {
                    if (($current_day_shift_code != 'VGN_NIGT') && ($current_day_shift_code != 'VGN_FNIG')) {
                        
                        // normal day = prev-nightshift,curr-dayshift
                        $arr1 = [];
                        $arr2 = [];
                        $arr3 = [];
                        $addonehoursendtime = Carbon::parse($startdate.' '.$current_day_shiftdetails['Shift_Details']['End_Time'])->addMinutes(90)->toDateTimeString();
                        $add8hours = Carbon::parse($addonehoursendtime)->addHours(8)->toDateTimeString();
                        $addoneday = Carbon::parse($startdate)->addDay()->toDateString();
                        $getpunches = $this->getpunches($employeeid, $startdate, $addoneday);
                                                
                        $punches = $this->getsortedpunches($getpunches);
                        if (!empty($punches)) {
                            foreach ($punches as $key => $value) {
                                if ((Carbon::parse($value['key'])->gte(Carbon::parse($addonehoursendtime))) && (Carbon::parse($value['key'])->lte(Carbon::parse($startdate.' 23:59:59'))) ) {
                                    $arr1[] = $value;
                                }
                            }
                        }
                        if (!empty($arr1)) {
                            $endatetime = Carbon::parse($arr1[0]['key'])->addHours(9)->toDateTimeString();
                            foreach ($punches as $key => $value) {
                                if ((Carbon::parse($value['key'])->gte(Carbon::parse($arr1[0]['key']))) && (Carbon::parse($value['key'])->lte(Carbon::parse($endatetime))) ) {
                                    $arr2[] = $value;
                                }
                            }
                        }
                        if (empty($arr2)) {
                            return ['fullcompoff_hours' => 0,'punchesarr' => [],'compoffdate'=>$startdate,'compoffhours' => '','eligible' => '0','leavemindate'=> $leavemindate, 'message' => 'Compoff not eligible for this date!'];
                        }
                        if (!empty($arr2)) {
                            $endatetime = Carbon::parse($arr2[0]['key'])->addHours(9)->toDateTimeString();
                             foreach ($arr2 as $key => $value) {
                                 if ((Carbon::parse($value['key'])->gte(Carbon::parse($addoneday.' 00:00:00'))) && (Carbon::parse($value['key'])->lte(Carbon::parse($addday.' 01:00:00'))) ) {
                                     $arr3[] = $value;
                                 }
                             }
                        }

                        if (empty($arr3)) {
                            return ['fullcompoff_hours' => 0,'punchesarr' => [],'compoffdate'=>$startdate,'compoffhours' => '','eligible' => '0','leavemindate'=> $leavemindate, 'message' => 'There is no punch between 12am - 1 am. Compoff not eligible!'];
                        }
                        $compoffhours = 0;
                        if (!empty($arr1) && !empty($arr2) && !empty($arr3)) {
                            $compoffhours = substr(Carbon::parse($arr1[0]['key'])->diff(Carbon::parse($arr2[count($arr2) -1]['key']))->format('%H:%i:%s'), 0,2);
                            $fullcompoffhours = Carbon::parse($arr1[0]['key'])->diff(Carbon::parse($arr2[count($arr2) -1]['key']))->format('%H:%i:%s');
                            //$punchesarr[] = $arr1;
                            $punchesarr = $arr2;
                        }

                        if (($compoffhours >= '4') && ($compoffhours < '8')) {
                            $eligible = '0.5';
                        }
                        elseif($compoffhours >= '8'){
                            $eligible = '1';
                        }
                        else {
                            $eligible = '0';
                        }

                        
                        return ['fullcompoff_hours' => $fullcompoffhours,'punchesarr' => $punchesarr,'compoffdate'=>$startdate,'compoffhours' => $compoffhours,'eligible' => $eligible,'leavemindate'=> $leavemindate, 'message' => 'You are eligible for comp-off!'];
                        
                    }
                    else{
                        // normal day = prev-nightshift,nightshift
                        $arr1 = [];
                        $arr2 = [];
                        $arr3 = [];
                        $subonehoursendtime = Carbon::parse($startdate.' '.$prev_day_shiftdetails['Shift_Details']['Start_Time'])->subMinutes(90)->toDateTimeString();
                        $add9hours = Carbon::parse($subonehoursendtime)->addHours(9)->toDateTimeString();
                        $add5hours = Carbon::parse($subonehoursendtime)->addHours(5)->toDateTimeString();
                        $addoneday = Carbon::parse($startdate)->addDay()->toDateString();
                        $getpunches = $this->getpunches($employeeid, $startdate, $startdate);
                                                
                        $punches = $this->getsortedpunches($getpunches);
                        if (!empty($punches)) {
                            foreach ($punches as $key => $value) {
                                if ((Carbon::parse($value['key'])->gte(Carbon::parse($subonehoursendtime))) && (Carbon::parse($value['key'])->lte(Carbon::parse($add5hours))) ) {
                                    $arr1[] = $value;
                                }
                            }
                        }
                        
                        if (!empty($arr1)) {
                            $endatetime = Carbon::parse($arr1[0]['key'])->addHours(9)->toDateTimeString();
                            foreach ($punches as $key => $value) {
                                if ((Carbon::parse($value['key'])->gte(Carbon::parse($arr1[0]['key']))) && (Carbon::parse($value['key'])->lte(Carbon::parse($endatetime))) ) {
                                    $arr2[] = $value;
                                }
                            }
                        }
                        
                        if (empty($arr2)) {
                            return ['fullcompoff_hours' => 0,'punchesarr' => [],'compoffdate'=>$startdate,'compoffhours' => '','eligible' => '0','leavemindate'=> $leavemindate, 'message' => 'Compoff not eligible for this date!'];
                        }
                        
                        $compoffhours = 0;
                        if (!empty($arr1) && !empty($arr2)) {
                            $compoffhours = substr(Carbon::parse($arr1[0]['key'])->diff(Carbon::parse($arr2[count($arr2) -1]['key']))->format('%H:%i:%s'), 0,2);
                            $fullcompoffhours = Carbon::parse($arr1[0]['key'])->diff(Carbon::parse($arr2[count($arr2) -1]['key']))->format('%H:%i:%s');
                           // $punchesarr[] = $arr1;
                            $punchesarr = $arr2;
                        }

                        if (($compoffhours >= '4') && ($compoffhours < '8')) {
                            $eligible = '0.5';
                        }
                        elseif($compoffhours >= '8'){
                            $eligible = '1';
                        }
                        else {
                            $eligible = '0';
                        }

                        
                        return ['fullcompoff_hours' => $fullcompoffhours,'punchesarr' => $punchesarr,'compoffdate'=>$startdate,'compoffhours' => $compoffhours,'eligible' => $eligible,'leavemindate'=> $leavemindate, 'message' => 'You are eligible for comp-off!'];
                    }
                }
                else{

                    if (($current_day_shift_code != 'VGN_NIGT') && ($current_day_shift_code != 'VGN_FNIG')) {
                        // normal day = prev-dayshift,dayshift
                        $arr1 = [];
                        $arr2 = [];
                        $arr3 = [];

                        $startdatetime = Carbon::parse($startdate.' '.$current_day_shiftdetails['Shift_Details']['Start_Time'])->toDateTimeString();
                        $enddatetime = Carbon::parse($std.' '.$current_day_shiftdetails['Shift_Details']['End_Time'])->toDateTimeString();
                        $diffinminutes = Carbon::parse($startdatetime)->diffInSeconds(Carbon::parse($enddatetime));
                        $minutesdivide = $diffinminutes/2;
                        $gmate = gmdate('H:i:s', $minutesdivide);
                        $fullgmate = gmdate('H:i:s', $diffinminutes);
                        $halfnewextenhour = substr($gmate,0, 2);
                        $fullnewextenhour = substr($fullgmate,0, 2);
                        //return $fullnewextenhour;
                        $enable_sec_saturday = 0;
                        $newsshiftcode = $current_day_shiftdetails['Shift_Details']['Shift_Code'];
                        $wordmonth = Carbon::parse($current_day_shiftdetails['Shift_Details']['Shift_Date'])->format('M');
                        $newyear = Carbon::parse($current_day_shiftdetails['Shift_Details']['Shift_Date'])->format('Y');
                        $bt = new \DateTime("second sat of $wordmonth $newyear");
            			$btcarbon = Carbon::instance($bt);
            			$second_saturday = $btcarbon->toDateString();

            			if (($newsshiftcode == 'VGN_GEN') || ($newsshiftcode == 'VGN_SAP') || ($newsshiftcode == 'VGN_RCP1') || ($newsshiftcode == 'VGN_RCP2')) {
            				if ($second_saturday == $current_day_shiftdetails['Shift_Details']['Shift_Date']) {
        									$enable_sec_saturday = 1;    					
     	       				}
            			}

            			if ($enable_sec_saturday == 1) {
            				$addonehoursendtime = Carbon::parse($startdate.' 13:30:00')->addMinutes(30)->toDateTimeString();
            			}
            			else{
            				$addonehoursendtime = Carbon::parse($startdate.' '.$current_day_shiftdetails['Shift_Details']['End_Time'])->addMinutes(90)->toDateTimeString();	
            			}

                        
                        $add8hours = Carbon::parse($addonehoursendtime)->addHours(10)->toDateTimeString();
                        $addoneday = Carbon::parse($startdate)->addDay()->toDateString();
                        $getpunches = $this->getpunches($employeeid, $startdate, $addoneday);
                                                
                        $punches = $this->getsortedpunches($getpunches);
                        
                        if (!empty($punches)) {
                            foreach ($punches as $key => $value) {
                                if ((Carbon::parse($value['key'])->gte(Carbon::parse($addonehoursendtime))) && (Carbon::parse($value['key'])->lte(Carbon::parse($startdate.' 23:59:59'))) ) {
                                    $arr1[] = $value;
                                }
                            }
                        }

                        if (empty($arr1)) {
                        	return ['fullcompoff_hours' => 0,'punchesarr' => [],'compoffdate'=>$startdate,'compoffhours' => '','eligible' => '0','leavemindate'=> $leavemindate, 'message' => 'Compoff not eligible for this date!'];
                        }
                        
                        if (!empty($arr1)) {
                            $endatetime = Carbon::parse($arr1[0]['key'])->addHours(15)->toDateTimeString();
                            //return $enddatetime;
                            foreach ($punches as $key => $value) {
                                if ((Carbon::parse($value['key'])->gte(Carbon::parse($arr1[0]['key']))) && (Carbon::parse($value['key'])->lte(Carbon::parse($endatetime))) ) {
                                    $arr2[] = $value;
                                }
                            }
                        }
                        
                        
                        if (empty($arr2)) {
                            return ['fullcompoff_hours' => 0,'punchesarr' => [],'compoffdate'=>$startdate,'compoffhours' => '','eligible' => '0','leavemindate'=> $leavemindate, 'message' => 'Compoff not eligible for this date!'];
                        }
                        if (!empty($arr2)) {
                            $endatetime = Carbon::parse($arr2[0]['key'])->addHours($fullnewextenhour)->toDateTimeString();
                             foreach ($arr2 as $key => $value) {
                                 if ((Carbon::parse($value['key'])->gte(Carbon::parse($addoneday.' 00:00:00'))) && (Carbon::parse($value['key'])->lte(Carbon::parse($addday.' 01:00:00'))) ) {
                                     $arr3[] = $value;
                                 }
                             }
                        }
                        
                        if ($enable_sec_saturday == 1) {
                        	$arr3 = ['valid`'];
                        }
                        else{
                        if (empty($arr3)) {
                            return ['fullcompoff_hours' => 0,'punchesarr' => [],'compoffdate'=>$startdate,'compoffhours' => '','eligible' => '0','leavemindate'=> $leavemindate, 'message' => 'There is no punch between 12am - 1 am. Compoff not eligible!'];
                        }
                    	}
                        $compoffhours = 0;
                        if (!empty($arr1) && !empty($arr2) && !empty($arr3)) {
                            $compoffhours = substr(Carbon::parse($arr1[0]['key'])->diff(Carbon::parse($arr2[count($arr2) -1]['key']))->format('%H:%i:%s'), 0,2);
                            $fullcompoffhours = Carbon::parse($arr1[0]['key'])->diff(Carbon::parse($arr2[count($arr2) -1]['key']))->format('%H:%i:%s');
                            //$punchesarr[] = $arr1;
                            $punchesarr = $arr2;
                        }

                        
                        if (($compoffhours >= '4') && ($compoffhours < '8')) {
                            $eligible = '0.5';
                        }
                        elseif($compoffhours >= '8'){
                            $eligible = '1';
                        }
                        else {
                            $eligible = '0';
                        }

                        
                        return ['fullcompoff_hours' => $fullcompoffhours,'punchesarr' => $punchesarr,'compoffdate'=>$startdate,'compoffhours' => $compoffhours,'eligible' => $eligible,'leavemindate'=> $leavemindate, 'message' => 'You are eligible for comp-off!'];
                    }else{
                        // normal day = prev-dayshift,nightshift
                        $arr1 = [];
                        $arr2 = [];
                        $arr3 = [];
                        $subonehoursendtime = Carbon::parse($startdate.' '.$prev_day_shiftdetails['Shift_Details']['Start_Time'])->subMinutes(90)->toDateTimeString();
                        $add9hours = Carbon::parse($subonehoursendtime)->addHours(9)->toDateTimeString();
                        $add5hours = Carbon::parse($subonehoursendtime)->addHours(5)->toDateTimeString();
                        $addoneday = Carbon::parse($startdate)->addDay()->toDateString();
                        $getpunches = $this->getpunches($employeeid, $startdate, $startdate);
                        
                                                
                        $punches = $this->getsortedpunches($getpunches);
                        if (!empty($punches)) {
                            foreach ($punches as $key => $value) {
                                if ((Carbon::parse($value['key'])->gte(Carbon::parse($subonehoursendtime))) && (Carbon::parse($value['key'])->lte(Carbon::parse($add5hours))) ) {
                                    $arr1[] = $value;
                                }
                            }
                        }
                        
                        if (!empty($arr1)) {
                            $endatetime = Carbon::parse($arr1[0]['key'])->addHours(9)->toDateTimeString();
                            foreach ($punches as $key => $value) {
                                if ((Carbon::parse($value['key'])->gte(Carbon::parse($arr1[0]['key']))) && (Carbon::parse($value['key'])->lte(Carbon::parse($endatetime))) ) {
                                    $arr2[] = $value;
                                }
                            }
                        }
                        
                        if (empty($arr2)) {
                            return ['fullcompoff_hours' => 0,'punchesarr' => [],'compoffdate'=>$startdate,'compoffhours' => '','eligible' => '0','leavemindate'=> $leavemindate, 'message' => 'Compoff not eligible for this date!'];
                        }
                        
                        $compoffhours = 0;
                        if (!empty($arr1) && !empty($arr2)) {
                            $compoffhours = substr(Carbon::parse($arr1[0]['key'])->diff(Carbon::parse($arr2[count($arr2) -1]['key']))->format('%H:%i:%s'), 0,2);
                            $fullcompoffhours = Carbon::parse($arr1[0]['key'])->diff(Carbon::parse($arr2[count($arr2) -1]['key']))->format('%H:%i:%s');
                           // $punchesarr[] = $arr1;
                            $punchesarr = $arr2;
                        }

                        if (($compoffhours >= '4') && ($compoffhours < '8')) {
                            $eligible = '0.5';
                        }
                        elseif($compoffhours >= '8'){
                            $eligible = '1';
                        }
                        else {
                            $eligible = '0';
                        }

                        
                        return ['fullcompoff_hours' => $fullcompoffhours,'punchesarr' => $punchesarr,'compoffdate'=>$startdate,'compoffhours' => $compoffhours,'eligible' => $eligible,'leavemindate'=> $leavemindate, 'message' => 'You are eligible for comp-off!'];
                    }

                }

            }
            
                       
            
            
            
        }
        return response()
            ->json(['message' => "Unauthorized"], 401);
    }


    public function getsortedpunches($getpunches)
    {
        $newarr = [];
        if(!empty($getpunches)){
            if(array_key_exists('0', $getpunches['Sorted_Punches'])){
                $punches = $getpunches['Sorted_Punches'];
            }
            else{
                if ($getpunches['Sorted_Punches']['Emp_ID'] != '') {
                    $punches[] = $getpunches['Sorted_Punches'];    
                }else{
                    $punches = $getpunches['Sorted_Punches'];
                }
            }
            if(array_key_exists('0', $punches)){                                           
                
                $i = 0;
                foreach ($punches as $key => $value) {

                            $newarr[$i]['key'] = $value['Date'].' '.$value['Time'];
                        $newarr[$i]['val_name'] = Carbon::parse($value['Date'].' '.$value['Time'])->format('h:i:s A');
                        $newarr[$i]['terminal_id'] = $value['Terminal_ID'];
                        $terminal = DB::connection('mysql6')->table('terminal_details')->where('terminal_id',$value['Terminal_ID'] )->get(); 
                        foreach ($terminal as $key => $value) {
                            $terminal_name = $value->terminal_name;
                        }
                        $newarr[$i]['terminal_name'] = $terminal_name;
                        $i = $i+1;
                                           
                    
                }
                
                return $newarr;
            }else{
                return $newarr;
            }
            
        }else{
            return $newarr;
        }
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

             if (empty($request->leave_date_range) || empty($request->leave_type)) {
               $error['0'] ="Please fill the mandatory fields!";
                $request->session()->flash("error_msg", $error);
                return redirect()->back()->withInput();    
            }
            
            
            $validate = $this->validate($request, [
                'leave_type' => 'required',
                'compoff_date_range' => 'required',
                'leave_date_range' => 'required|checkweekofforholidays',
                'partial_days' => 'required|checkwithappliedleaves_new',
                'leave_reason' => 'required'
                ]);


                $request['startdate'] = $request->compoff_date_range;
            
                $getcompoff_details = $this->getcompoffpunches($request);
                
                $compoff_ref = DB::connection('mysql6')->table('compoff_reference')->where('employee_id', '=', $employeeid)
                ->where(['compoff_worked_date' => $getcompoff_details['compoffdate'], 'partial_days_taken' => $request->partial_days])
                ->get();
                $compoffused = 0;
                
                    $newcompoff_ref = DB::connection('mysql6')->table('compoff_reference')->where('employee_id', '=', $employeeid)
                    ->where(['compoff_worked_date' => $getcompoff_details['compoffdate']])
                    ->get();
                    $eligible_compoff = $getcompoff_details['eligible'];

                    if (count($newcompoff_ref) > 0) {

                        foreach ($newcompoff_ref as $key => $value) {
                            $ref_id = $value->app_ref_id;
                        
                        
    
                        $get_apprvd_pending = DB::connection('mysql6')->table('leave_processed')->where('employeeid', '=', $employeeid)
                    ->where(['id' => $ref_id])->whereIn('final_status',['Approved','Pending'])
                    ->get();
                    if (count($get_apprvd_pending) > 0) {
                        foreach ($get_apprvd_pending as $key11 => $value11) {
                            if ($value11->partial_days == 'full') {
                                $compoffused += 1;
                            }
                            else{
                                $compoffused += 0.5;
                            }
                        }
                    }
    
                        
                    }
                    
                }

                $checkcompoff = $eligible_compoff - $compoffused;
                //dd($checkcompoff);
                if ($checkcompoff <= 0) {
                    $error['0'] ="The Compoff date already Used!";
                    $request->session()->flash("error_msg", $error);
                    return redirect()->back()->withInput();
                }
                    
                
                
                /*if (count($compoff_ref) > 0) {

                    foreach ($compoff_ref as $key => $value) {
                        $ref_id = $value->app_ref_id;
                    }


                    $get_apprvd_pending = DB::connection('mysql6')->table('leave_processed')->where('employeeid', '=', $employeeid)
                ->where(['id' => $ref_id])->whereIn('final_status',['Approved','Pending'])
                ->count();
                if ($get_apprvd_pending > 0) {
                    $error['0'] ="The Compoff date and partial days already Used!";
                    $request->session()->flash("error_msg", $error);
                    return redirect()->back()->withInput();
                }

                    
                }*/


                 $run_apply_process = $this->compoffprocess($employeeid, $request->partial_days,$request->leave_type ,$request->leave_reason, $request, $getcompoff_details);
        
                    if($run_apply_process == true){
                        $request->session()->flash("suc_msg", "Successfully Compoff application Submitted!.");
                       return redirect()->back();
                    }
                     
                 

        }

        return view('newemployeezone.login');
    }


    public function compoffprocess($employeeid, $partial_days, $leave_type,$leave_reason, $request, $getcompoff_details)
    {
        if ($request->session()->has('employeesession')) {
            $encrypt = $request->session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $employeeid = $split[0];
            
            
            $startdate = $this->dateformatreturnddmmyytoyymmdd(trim($request->leave_date_range));
            $partial_days = $request->partial_days;
            
            $subday = Carbon::parse($startdate)->subDay()->toDateString();
            $addday = Carbon::parse($startdate)->addDay()->toDateString();
            $prev_day_shiftdetails = $this->getshiftdetailsst_et_date($employeeid, $subday, $subday);

            $current_day_shiftdetails = $this->getshiftdetailsst_et_date($employeeid, $startdate, $startdate);

            if (($current_day_shiftdetails['Shift_Details']['Shift_Code'] == 'VGN_NIGT') || ($current_day_shiftdetails['Shift_Details']['Shift_Code'] == 'VGN_FNIG')) {
                $std = Carbon::parse($startdate)->addDay()->toDateString();
            }
            else{
                $std = $startdate;
            }

            $fhourtoadd = substr(Carbon::parse($startdate.' '.$current_day_shiftdetails['Shift_Details']['Start_Time'])->diff(Carbon::parse($std.' '.$current_day_shiftdetails['Shift_Details']['End_Time']))->format('%H:%i:%s'), 0,2);
            
            if ($partial_days == 'first_half') { 
               $hourtoadd = $fhourtoadd/2;
               $startdatetime = $startdate.' '.$current_day_shiftdetails['Shift_Details']['Start_Time'];
               $enddatetime = $std.' '.$current_day_shiftdetails['Shift_Details']['End_Time'];
               //$startdatetime = Carbon::parse($startdate.' '.$current_day_shiftdetails['Shift_Details']['Start_Time'])->toDateTimeString();
               //$enddatetime = Carbon::parse($std.' '.$current_day_shiftdetails['Shift_Details']['End_Time'])->subHours($hourtoadd)->subHour()->toDateTimeString();
               //$no_of_hours = $hourtoadd;

               $diffinminutes = Carbon::parse($startdatetime)->diffInSeconds(Carbon::parse($enddatetime));
               $minutesdivide = $diffinminutes/2;
               $gmate = gmdate('H:i:s', $minutesdivide);
               
               $splitsub = explode(':', $gmate);
               if (($current_day_shiftdetails['Shift_Details']['Shift_Code'] == 'VGN_GEN') || ($current_day_shiftdetails['Shift_Details']['Shift_Code'] == 'VGN_GEN2') || ($current_day_shiftdetails['Shift_Details']['Shift_Code'] == 'VGN_RCP1') || ($current_day_shiftdetails['Shift_Details']['Shift_Code'] == 'VGN_RCP2') || ($current_day_shiftdetails['Shift_Details']['Shift_Code'] == 'VGN_SAP') || ($current_day_shiftdetails['Shift_Details']['Shift_Code'] == 'VGN_MGR') ) {
               $enddatetime = Carbon::parse($startdatetime)->addHours($splitsub[0])->addMinutes($splitsub[1])->subMinutes(30)->toDateTimeString();
               $diffintimehours = Carbon::parse($startdatetime)->diffInSeconds(Carbon::parse($enddatetime));
               $no_of_hours = gmdate('H:i:s', $diffintimehours);    
               }
               else{
                   $enddatetime = Carbon::parse($startdatetime)->addHours($splitsub[0])->addMinutes($splitsub[1])->toDateTimeString();
                   $no_of_hours = $gmate;
               }
               
            }
            elseif ($partial_days == 'second_half') {
                $hourtoadd = $fhourtoadd/2;
                $startdatetime = $startdate.' '.$current_day_shiftdetails['Shift_Details']['Start_Time'];
                $enddatetime = $startdate.' '.$current_day_shiftdetails['Shift_Details']['End_Time'];
                //$startdatetime = Carbon::parse($startdate.' '.$current_day_shiftdetails['Shift_Details']['End_Time'])->subHours($hourtoadd)->subHour()->toDateTimeString();
                //$enddatetime = Carbon::parse($startdate.' '.$current_day_shiftdetails['Shift_Details']['End_Time'])->toDateTimeString();
                //$no_of_hours = $hourtoadd;
                
                $diffinminutes = Carbon::parse($startdatetime)->diffInSeconds(Carbon::parse($enddatetime));
                $minutesdivide = $diffinminutes/2;
                $gmate = gmdate('H:i:s', $minutesdivide);
                
                $splitsub = explode(':', $gmate);
                if (($current_day_shiftdetails['Shift_Details']['Shift_Code'] == 'VGN_GEN') || ($current_day_shiftdetails['Shift_Details']['Shift_Code'] == 'VGN_GEN2') || ($current_day_shiftdetails['Shift_Details']['Shift_Code'] == 'VGN_RCP1') || ($current_day_shiftdetails['Shift_Details']['Shift_Code'] == 'VGN_RCP2') || ($current_day_shiftdetails['Shift_Details']['Shift_Code'] == 'VGN_SAP') || ($current_day_shiftdetails['Shift_Details']['Shift_Code'] == 'VGN_MGR') ) {
                $startdatetime = Carbon::parse($startdatetime)->addHours($splitsub[0])->addMinutes($splitsub[1])->subMinutes(30)->toDateTimeString();
                $diffintimehours = Carbon::parse($startdatetime)->diffInSeconds(Carbon::parse($enddatetime));
                $no_of_hours = gmdate('H:i:s', $diffintimehours); 
                }
                else{
                    $startdatetime = Carbon::parse($startdatetime)->addHours($splitsub[0])->addMinutes($splitsub[1])->toDateTimeString();
                    $no_of_hours = $gmate;
                }
            }
            else{
                $startdatetime = Carbon::parse($startdate.' '.$current_day_shiftdetails['Shift_Details']['Start_Time'])->toDateTimeString();
                $enddatetime = Carbon::parse($std.' '.$current_day_shiftdetails['Shift_Details']['End_Time'])->toDateTimeString();
                $diffinminutes = Carbon::parse($startdatetime)->diffInSeconds(Carbon::parse($enddatetime));
                $gmate = gmdate('H:i:s', $diffinminutes);
                $no_of_hours = $gmate;
                //$no_of_hours = $fhourtoadd;
            }


            $current_day_shift_code = $current_day_shiftdetails['Shift_Details']['Shift_Code'];
            $previous_day_shift_code = $prev_day_shiftdetails['Shift_Details']['Shift_Code'];
            $subonehourfrom_shift_starttime = Carbon::parse($startdatetime)->subHour()->toDateTimeString();
            $addonehourfrom_shift_endtime = Carbon::parse($enddatetime)->addHour()->toDateTimeString();
              
           
            
                        $i = 0;
                            
                           //start
                           if ($partial_days == 'full') {
                               $no_of_days = 1;
                           }
                           else{
                            $no_of_days = 0.5;
                           }
                            
            $fhourtoadd = substr(Carbon::parse($startdatetime)->diff(Carbon::parse($enddatetime))->format('%H:%i:%s'), 0,2);            
            $month = Carbon::parse($startdate)->format('m');
            $currentmonth = Carbon::now()->format('m');
            $year = Carbon::parse($startdate)->format('Y');
            $currentyear = Carbon::now()->format('Y');
           $getid = DB::connection('mysql6')->table('leave_processed')->insertGetId([
                'employeeid' => $employeeid,
                'month' => $month,
                'year' => $year,
                'type' => $leave_type,
                'stdate' => $startdatetime,
                'etdate' => $enddatetime,
                'no_of_hours' => $no_of_hours,
                'no_of_days' => $no_of_days,
                'partial_days' => $partial_days,
                'emp_reason' => $leave_reason,
                'created_date' => Carbon::now()->toDateTimeString(),
                'hod_status' => 'Pending',
                'hod_reason' => null,
                'hod_created_date' => null,
                'admin_status' => 'Pending',
                'admin_reason' => null,
                'admin_created_date' => null,
                'final_status' => 'Pending',
                'saved_file_path' => null,
                'valid_till' => Carbon::now()->addDays(5)->toDateTimeString()
            ]);

            DB::connection('mysql6')->table('compoff_reference')->insert([
                'employee_id' => $employeeid,
                'app_ref_id' => $getid,
                'compoff_worked_date' => $getcompoff_details['compoffdate'],
                'punches_taken' => json_encode($getcompoff_details['punchesarr']),
                'compoff_worked_hours' => $getcompoff_details['fullcompoff_hours'],
                'eligible' => $getcompoff_details['eligible'],
                'partial_days_taken' => $partial_days,
                'created_datetime' => Carbon::now()->toDateTimeString()
            ]);


            $newstarttime = explode(' ', $startdatetime);
            $newendtime = explode(' ', $enddatetime);
            
            DB::connection('mysql6')->table('datetime_ref')->insert([
                'employeeid' => $employeeid,
                'month' => Carbon::parse($startdatetime)->format('m'),
                'year' => Carbon::parse($startdatetime)->format('Y'),
                'applied_month' => $currentmonth,
                'applied_year' => $currentyear,
                'type' => $leave_type,
                'shift_code' => $current_day_shiftdetails['Shift_Details']['Shift_Code'],
                'final_status' => 'Pending',
                'date' => $startdate,
                'start_end_time' => $newstarttime[1].'-'.$newendtime[1],
                'partial_days' => $partial_days,
                'reference_id' => $getid
            ]);

            $randomno1 = rand(1, 5000);
            $toencrypt1 = $employeeid.'-#hod#-'.$getid.'-'.$randomno1.$leave_type;
            $hodencrypt = Crypt::encrypt($toencrypt1);

            DB::connection('mysql6')->table('lms_mail_queue')->insert([
                'reference_id' => $getid,
                'hod_session_key' => $hodencrypt,
                'sent_to_hod' => null,
                'admin_session_key' => null,
                'sent_to_admin' => null,
                'processed' => 0
            ]);

            $getbalance = DB::connection('mysql6')->table('leave_balance')->where(['employeeid' => $employeeid, 'month' => $currentmonth,'year' => $currentyear])->get();
            foreach ($getbalance as $key6 => $value6) {
                $bal = $value6->$leave_type;
            }
            $minus_bal = $bal + $no_of_days;

            DB::connection('mysql6')->table('leave_balance')->where(['employeeid' => $employeeid, 'month' => $currentmonth,'year' => $currentyear])
            ->update([
                $leave_type => $minus_bal
            ]);
                return true;
                           //end
        }
        return false;
    }

    public function permissionprocess($employeeid, $startdate, $partial_days, $leave_type,$leave_reason, $request)
    {
        $getshiftdetails = $this->getshiftdetailsst_et_date($employeeid, $startdate, $startdate);

        if (($getshiftdetails['Shift_Details']['Shift_Code'] == 'VGN_NIGT') || ($getshiftdetails['Shift_Details']['Shift_Code'] == 'VGN_FNIG')) {
            $std = Carbon::parse($startdate)->addDay()->toDateString();
        }
        else{
            $std = $startdate;
        }

        $minutestoadd = '90';
        
        if ($partial_days == 'first_half') { 
           
           
           $startdatetime = Carbon::parse($startdate.' '.$getshiftdetails['Shift_Details']['Start_Time'])->toDateTimeString();
           $enddatetime = Carbon::parse($std.' '.$getshiftdetails['Shift_Details']['Start_Time'])->addMinutes($minutestoadd)->toDateTimeString();
           $no_of_days = 1;
           $no_of_hours = '01:30:00';
           
        }
        elseif ($partial_days == 'second_half') {
            
            $startdatetime = Carbon::parse($startdate.' '.$getshiftdetails['Shift_Details']['End_Time'])->subMinutes($minutestoadd)->toDateTimeString();
            $enddatetime = Carbon::parse($startdate.' '.$getshiftdetails['Shift_Details']['End_Time'])->toDateTimeString();
            $no_of_days = 1;
            $no_of_hours = '01:30:00';
        }
        else{
            return redirect()->route('lmshome');
        }

       
        
        $month = Carbon::parse($startdate)->format('m');
        $currentmonth = Carbon::now()->format('m');
        $year = Carbon::parse($startdate)->format('Y');
        $currentyear = Carbon::now()->format('Y');
       $getid = DB::connection('mysql6')->table('leave_processed')->insertGetId([
            'employeeid' => $employeeid,
            'month' => $month,
            'year' => $year,
            'type' => $leave_type,
            'stdate' => $startdatetime,
            'etdate' => $enddatetime,
            'no_of_hours' => $no_of_hours,
            'no_of_days' => null,
            'partial_days' => $partial_days,
            'emp_reason' => $leave_reason,
            'created_date' => Carbon::now()->toDateTimeString(),
            'hod_status' => 'Pending',
            'hod_reason' => null,
            'hod_created_date' => null,
            'admin_status' => 'Pending',
            'admin_reason' => null,
            'admin_created_date' => null,
            'final_status' => 'Pending',
            'saved_file_path' => null,
            'valid_till' => Carbon::now()->addDays(5)->toDateTimeString()
        ]);

        $newstarttime = explode(' ', $startdatetime);
        $newendtime = explode(' ', $enddatetime);
        
        DB::connection('mysql6')->table('datetime_ref')->insert([
            'employeeid' => $employeeid,
            'month' => Carbon::parse($startdate)->format('m'),
            'year' => Carbon::parse($startdate)->format('Y'),
            'applied_month' => $currentmonth,
            'applied_year' => $currentyear,
            'type' => $leave_type,
            'shift_code' => $getshiftdetails['Shift_Details']['Shift_Code'],
            'final_status' => 'Pending',
            'date' => $startdate,
            'start_end_time' => $newstarttime[1].'-'.$newendtime[1],
            'partial_days' => $partial_days,
            'reference_id' => $getid
        ]);

        $randomno1 = rand(1, 5000);
        $toencrypt1 = $employeeid.'-#hod#-'.$getid.'-'.$randomno1.$leave_type;
        $hodencrypt = Crypt::encrypt($toencrypt1);

        DB::connection('mysql6')->table('lms_mail_queue')->insert([
            'reference_id' => $getid,
            'hod_session_key' => $hodencrypt,
            'sent_to_hod' => null,
            'admin_session_key' => null,
            'sent_to_admin' => null,
            'processed' => 0
        ]);

        $getbalance = DB::connection('mysql6')->table('leave_balance')->where(['employeeid' => $employeeid, 'month' => $currentmonth,'year' => $currentyear])->get();
        foreach ($getbalance as $key6 => $value6) {
            $bal = $value6->$leave_type;
        }
        $minus_bal = $bal - $no_of_days;

        DB::connection('mysql6')->table('leave_balance')->where(['employeeid' => $employeeid, 'month' => $currentmonth,'year' => $currentyear])
        ->update([
            $leave_type => $minus_bal
        ]);

        return true;
    }

    public function lop(Request $request)
    {
        if ($request->session()->has('employeesession')) {
            $encrypt = $request->session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $employeeid = $split[0];
            $mydetails = [];
            $getemployeedata = DB::connection('mysql6')->table('employee')->where('id', '=', $employeeid)->get();

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
                "full" => "Full Day",
                "first_half" => "First Half",
                "second_half" => "Second Half",
                ];

            return view('newemployeezone.lms.lop')->with(['getemployeedata'=>$getemployeedata,'partial_days_array' => $partial_days_array, 'profilepic'=>$profilepic, 'employeeid' => $employeeid]);

        }

        return view('newemployeezone.login');
    }

    public function newpostlop(Request $request)
    {
        if ($request->session()->has('employeesession')) {
            $encrypt = $request->session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $employeeid = $split[0];
            $mydetails = [];
            $getemployeedata = DB::connection('mysql6')->table('employee')->where('id', '=', $employeeid)->get();
            
            $validate = $this->validate($request, [
                'leave_type' => 'required',
                'leave_date_range' => 'required|checkweekofforholidays',
                'partial_days' => 'required|checkwithappliedleaves_new',
                'leave_reason' => 'required'
                ]);
                
                $getactivedetails = $this->getactivedetails($employeeid);

                $leave_date_range = $request->leave_date_range;
                $leave_type = $request->leave_type;
                $splitrange = explode('-',$leave_date_range);

                $startdate = $this->dateformatreturnddmmyytoyymmdd(trim($splitrange[0]));
                $enddate = $this->dateformatreturnddmmyytoyymmdd(trim($splitrange[1]));
                $diff = $this->formatforempdat_differbtwtwodates($startdate, $enddate);


                $run_apply_process = $this->clprocess($employeeid, $startdate, $enddate, $request->partial_days, $leave_type,$request->leave_reason, $diff, $getactivedetails);
        
                    if($run_apply_process == true){
                        $request->session()->flash("suc_msg", "Successfully Loss of Pay application Submitted!.");
                       return redirect()->back();
                    }
                     
                 

        }

        return view('newemployeezone.login');
    }


    public function mispunch(Request $request)
    {
        if ($request->session()->has('employeesession')) {
            $encrypt = $request->session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $employeeid = $split[0];
            $mydetails = [];
            $getemployeedata = DB::connection('mysql6')->table('employee')->where('id', '=', $employeeid)->get();
            
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
                
                "first_half" => "In Punch",
                "second_half" => "Out Punch",
                ];

            return view('newemployeezone.lms.mispunch')->with(['getemployeedata'=>$getemployeedata,'partial_days_array' => $partial_days_array, 'profilepic'=>$profilepic, 'employeeid' => $employeeid]);

        }

        return view('newemployeezone.login');
    }

    public function postmispunch(Request $request)
    {
        if ($request->session()->has('employeesession')) {
            $encrypt = $request->session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $employeeid = $split[0];
            $mydetails = [];
            $getemployeedata = DB::connection('mysql6')->table('employee')->where('id', '=', $employeeid)->get();
            
            $validate = $this->validate($request, [
                'leave_type' => 'required',
                'leave_date_range' => 'required|currentmonth|only3mispunchallowedpermonth|checkweekofforholidays',
                'fileupload' => 'nullable',
                'partial_days' => 'required|checkwithappliedleaves_new',
                'leave_reason' => 'required'
                ]);

                $leave_type = $request->leave_type;
                $startdate = $this->dateformatreturnddmmyytoyymmdd(trim($request->leave_date_range));
            $partial_days = $request->partial_days;
            $leave_reason = $request->leave_reason;
            $diff = $this->formatforempdat_differbtwtwodates($startdate, $startdate);


            if ($request->hasFile('fileupload')) {
                $checkthefile = $this->checkthefile($employeeid, $startdate, $startdate,$request, 'fileupload');
                $error = [];
                if(!empty($checkthefile)){

                    foreach ($checkthefile as $key => $value) {
                        $error[] = $value;
                    }
                    $request->session()->flash("error_msg", $error);
               return redirect()->back()->withInput();
                }
           }

                $getshiftdetails = $this->getshiftdetailsst_et_date($employeeid, $startdate, $startdate);
            
            if (($getshiftdetails['Shift_Details']['Shift_Code'] == 'VGN_NIGT') || ($getshiftdetails['Shift_Details']['Shift_Code'] == 'VGN_FNIG')) {
                $std = Carbon::parse($startdate)->addDay()->toDateString();
            }
            else{
                $std = $startdate;
            }

            $fhourtoadd = substr(Carbon::parse($startdate.' '.$getshiftdetails['Shift_Details']['Start_Time'])->diff(Carbon::parse($std.' '.$getshiftdetails['Shift_Details']['End_Time']))->format('%H:%i:%s'), 0,2);
            
            if ($partial_days == 'first_half') { 
               $hourtoadd = $fhourtoadd/2;
               $startdatetime = $startdate.' '.$getshiftdetails['Shift_Details']['Start_Time'];
               $enddatetime = $std.' '.$getshiftdetails['Shift_Details']['End_Time'];
               //$startdatetime = Carbon::parse($startdate.' '.$getshiftdetails['Shift_Details']['Start_Time'])->toDateTimeString();
               //$enddatetime = Carbon::parse($std.' '.$getshiftdetails['Shift_Details']['End_Time'])->subHours($hourtoadd)->subHour()->toDateTimeString();
               $no_of_days = 0.5;
               //$no_of_hours = $hourtoadd;
               $diffinminutes = Carbon::parse($startdatetime)->diffInSeconds(Carbon::parse($enddatetime));
               $minutesdivide = $diffinminutes/2;
               $gmate = gmdate('H:i:s', $minutesdivide);
               
               $splitsub = explode(':', $gmate);
               if (($getshiftdetails['Shift_Details']['Shift_Code'] == 'VGN_GEN') || ($getshiftdetails['Shift_Details']['Shift_Code'] == 'VGN_GEN2') || ($getshiftdetails['Shift_Details']['Shift_Code'] == 'VGN_RCP1') || ($getshiftdetails['Shift_Details']['Shift_Code'] == 'VGN_RCP2') || ($getshiftdetails['Shift_Details']['Shift_Code'] == 'VGN_SAP') || ($getshiftdetails['Shift_Details']['Shift_Code'] == 'VGN_MGR') ) {
               $enddatetime = Carbon::parse($startdatetime)->addHours($splitsub[0])->addMinutes($splitsub[1])->subMinutes(30)->toDateTimeString();
               $diffintimehours = Carbon::parse($startdatetime)->diffInSeconds(Carbon::parse($enddatetime));
               $no_of_hours = gmdate('H:i:s', $diffintimehours);    
               }
               else{
                   $enddatetime = Carbon::parse($startdatetime)->addHours($splitsub[0])->addMinutes($splitsub[1])->toDateTimeString();
                   $no_of_hours = $gmate;
               }
               
               
            }
            elseif ($partial_days == 'second_half') {
                $hourtoadd = $fhourtoadd/2;
                $startdatetime = $startdate.' '.$getshiftdetails['Shift_Details']['Start_Time'];
                $enddatetime = $std.' '.$getshiftdetails['Shift_Details']['End_Time'];
                //$startdatetime = Carbon::parse($startdate.' '.$getshiftdetails['Shift_Details']['End_Time'])->subHours($hourtoadd)->subHour()->toDateTimeString();
                //$enddatetime = Carbon::parse($startdate.' '.$getshiftdetails['Shift_Details']['End_Time'])->toDateTimeString();
                //$no_of_hours = $hourtoadd;
                $no_of_days = 0.5;

                $diffinminutes = Carbon::parse($startdatetime)->diffInSeconds(Carbon::parse($enddatetime));
                $minutesdivide = $diffinminutes/2;
                $gmate = gmdate('H:i:s', $minutesdivide);
                
                $splitsub = explode(':', $gmate);
                if (($getshiftdetails['Shift_Details']['Shift_Code'] == 'VGN_GEN') || ($getshiftdetails['Shift_Details']['Shift_Code'] == 'VGN_GEN2') || ($getshiftdetails['Shift_Details']['Shift_Code'] == 'VGN_RCP1') || ($getshiftdetails['Shift_Details']['Shift_Code'] == 'VGN_RCP2') || ($getshiftdetails['Shift_Details']['Shift_Code'] == 'VGN_SAP') || ($getshiftdetails['Shift_Details']['Shift_Code'] == 'VGN_MGR') ) {
                $startdatetime = Carbon::parse($startdatetime)->addHours($splitsub[0])->addMinutes($splitsub[1])->subMinutes(30)->toDateTimeString();
                $diffintimehours = Carbon::parse($startdatetime)->diffInSeconds(Carbon::parse($enddatetime));
                $no_of_hours = gmdate('H:i:s', $diffintimehours); 
                }
                else{
                    $startdatetime = Carbon::parse($startdatetime)->addHours($splitsub[0])->addMinutes($splitsub[1])->toDateTimeString();
                    $no_of_hours = $gmate;
                }
            }
            else{
                $startdatetime = Carbon::parse($startdate.' '.$getshiftdetails['Shift_Details']['Start_Time'])->toDateTimeString();
                $enddatetime = Carbon::parse($std.' '.$getshiftdetails['Shift_Details']['End_Time'])->toDateTimeString();
                $diffinminutes = Carbon::parse($startdatetime)->diffInSeconds(Carbon::parse($enddatetime));
                $gmate = gmdate('H:i:s', $diffinminutes);
                $no_of_hours = $gmate;
                //$no_of_hours = $fhourtoadd;
                $no_of_days = 1;
            }
            
            $no_of_hours = $hourtoadd;
            
            $month = Carbon::parse($startdate)->format('m');
            $currentmonth = Carbon::now()->format('m');
            $year = Carbon::parse($startdate)->format('Y');
            $currentyear = Carbon::now()->format('Y');
           $getid = DB::connection('mysql6')->table('leave_processed')->insertGetId([
                'employeeid' => $employeeid,
                'month' => $month,
                'year' => $year,
                'type' => $leave_type,
                'stdate' => $startdatetime,
                'etdate' => $enddatetime,
                'no_of_hours' => $no_of_hours,
                'no_of_days' => $diff,
                'partial_days' => $partial_days,
                'emp_reason' => $leave_reason,
                'created_date' => Carbon::now()->toDateTimeString(),
                'hod_status' => 'Pending',
                'hod_reason' => null,
                'hod_created_date' => null,
                'admin_status' => 'Pending',
                'admin_reason' => null,
                'admin_created_date' => null,
                'final_status' => 'Pending',
                'saved_file_path' => null,
                'valid_till' => Carbon::now()->addDays(5)->toDateTimeString()
            ]);

            


            if($request->hasFile('fileupload')){

                $path = public_path()."/newcustomerzoneassets/mispunchuploads";
                $ext = strtolower($request->file('fileupload')->getClientOriginalExtension());
                                                
                $newname = $getid.'_fileupload';
                //Storage::disk('employeeprofilepic_uploads')->makeDirectory($destinationpath, 0777);
                //$uploaded = Storage::disk('sickfile_uploads')->put( $newname.'.'.$ext, $request->file('sickleavefile'));
$npath = Storage::disk('s3')->putFileAs("/newcustomerzoneassets/mispunch_uploads", $request->file('fileupload'), $newname.'.'.$ext);

                //$npath = $request->file('sickleavefile')->store($newname, 'sickfile_uploads' );
                $savedpath = Storage::disk('s3')->url("/newcustomerzoneassets/mispunch_uploads/".$newname.'.'.$ext);


                //$npath = $request->file('fileupload')->store($newname, 'mispunch_uploads');

                DB::connection('mysql6')->table('leave_processed')->where('id', $getid)
                                    ->update([
                                        'saved_file_path' => $savedpath]);
            }

            $newstarttime = explode(' ', $startdatetime);
            $newendtime = explode(' ', $enddatetime);
            
            DB::connection('mysql6')->table('datetime_ref')->insert([
                'employeeid' => $employeeid,
                'month' => Carbon::parse($startdate)->format('m'),
                'year' => Carbon::parse($startdate)->format('Y'),
                'applied_month' => $currentmonth,
                'applied_year' => $currentyear,
                'type' => $leave_type,
                'shift_code' => $getshiftdetails['Shift_Details']['Shift_Code'],
                'final_status' => 'Pending',
                'date' => $startdate,
                'start_end_time' => $newstarttime[1].'-'.$newendtime[1],
                'partial_days' => $partial_days,
                'reference_id' => $getid
            ]);

            $randomno1 = rand(1, 5000);
            $toencrypt1 = $employeeid.'-#hod#-'.$getid.'-'.$randomno1.$leave_type;
            $hodencrypt = Crypt::encrypt($toencrypt1);

            DB::connection('mysql6')->table('lms_mail_queue')->insert([
                'reference_id' => $getid,
                'hod_session_key' => $hodencrypt,
                'sent_to_hod' => null,
                'admin_session_key' => null,
                'sent_to_admin' => null,
                'processed' => 0
            ]);

            $getbalance = DB::connection('mysql6')->table('leave_balance')->where(['employeeid' => $employeeid, 'month' => $currentmonth,'year' => $currentyear])->get();
            foreach ($getbalance as $key6 => $value6) {
                $bal = $value6->$leave_type;
            }
            
            $minus_bal = $bal + $no_of_days;
            

            DB::connection('mysql6')->table('leave_balance')->where(['employeeid' => $employeeid, 'month' => $currentmonth,'year' => $currentyear])
            ->update([
                $leave_type => $minus_bal
            ]);

               
            $request->session()->flash("suc_msg", "Successfully Mispunch application Submitted!.");
            return redirect()->back();
                 

        }

        return view('newemployeezone.login');
    }


    public function subordinate_application(Request $request)
    {
        if ($request->session()->has('employeesession')) {
            $encrypt = $request->session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $employeeid = $split[0];
            $mydetails = [];
            $getemployeedata = DB::connection('mysql6')->table('employee')->where('id', '=', $employeeid)->get();

            

            $currentmonth = Carbon::now()->month;
            $currentyear = Carbon::now()->year;
	    $previous2yearmonth = Carbon::now()->subMonths(2)->startOfMonth()->toDateTimeString();

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
            $forpunchlist = [];

            if (count($getactiveemployees) > 0) {
                $i=0;
                $j = 0;
                foreach ($getactiveemployees['Details'] as $key => $value) {
                    
                    if($value['RM_ID'] == $employeeid){
                        $getsubordinates[$i]['empid'] = $value['Emp_ID'];
                        $getsubordinates[$i]['empname'] = $value['Emp_Name'];

                        $forpunchlist[$j]['empid'] = $value['Emp_ID'];
                        $forpunchlist[$j]['empname'] = $value['Emp_Name'];
                        $i += 1;
                        $j += 1;
                    }

                    if($value['Emp_ID'] == $employeeid){
                        $forpunchlist[$j]['empid'] = $value['Emp_ID'];
                        $forpunchlist[$j]['empname'] = $value['Emp_Name'];
                        $j += 1;
                    }
                }    
            }

            

            $applications = [];
            if (!empty($getsubordinates)) {
                $i = 0;
                foreach ($getsubordinates as $key1 => $value1) {
                    $getallapplications = DB::connection('mysql6')->table('leave_processed')->where('employeeid', '=', $value1['empid'])->where('created_date','>=',$previous2yearmonth)->orderBy('created_date', 'desc')->get()->toArray();   
                    if (count($getallapplications) > 0) {
                        foreach ($getallapplications as $key => $value) {
                            $applications[$i] = (array)$value; 
                            $id = $value->id;
                            $getcompoff = DB::connection('mysql6')->table('compoff_reference')->where(['employee_id' => $value1['empid'], 'app_ref_id' => $id])->get()->toArray();
                            if (count($getcompoff) > 0) {
                                foreach ($getcompoff as $key2 => $value2) {
                                    $value2->punches_taken = json_decode($value2->punches_taken);
                                    $applications[$i]['compoff'][] = (array)$value2; 
                                }
                                
                            }
                            else{
                                $applications[$i]['compoff'] = ''; 
                            }
                            $getod = DB::connection('mysql6')->table('od_reference')->where(['employee_id' => $value1['empid'], 'app_ref_id' => $id])->get()->toArray();
                            if (count($getod) > 0) {
                                foreach ($getod as $key3 => $value3) {
                                    $value3->puncheslist = json_decode($value3->puncheslist);
                                    $applications[$i]['od'][] = (array)$value3;
                                }
                                 
                            }
                            else{
                                $applications[$i]['od'] = '';
                            }
                            $applications[$i]['employeename'] = $value1['empname'];
                            $i = $i + 1;
                        }
                        
                    }
                }
            }
           
            $show_selectall_btn = 0;
            if (!empty($applications)) {
                foreach ($applications as $key => $value) {
                    if ($value['hod_status'] == 'Pending') {
                        $show_selectall_btn = $show_selectall_btn + 1;
                    }
                }
            }

            return view('newemployeezone.lms.subordinate_application')->with(['getemployeedata'=>$getemployeedata,'forpunchlist' => $forpunchlist,'getallapplications' => $applications,'show_selectall_btn' => $show_selectall_btn ,'profilepic'=>$profilepic, 'employeeid' => $employeeid]);

        }

        return view('newemployeezone.login');
    }

    public function postsubordinate_application(Request $request)
    {
        if ($request->session()->has('employeesession')) {
            $encrypt = $request->session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $remployeeid = $split[0];

        $id = $request->id;
        $reason = $request->reason;
        $status = $request->status;
        $subordinateid = $request->subordinateid;

        if ($status == 1) {
            $mainstatus = 'Approved';
        }else{
            $mainstatus = 'Rejected';
        }
    
        if ($mainstatus == 'Approved') {
                $getlms_application = DB::connection('mysql6')->table('leave_processed')->where(['id'=>$id, 'hod_status' => 'Pending'])->get();
            /* old for admin approval    
            if (count($getlms_application) > 0) {
                
                DB::connection('mysql6')->table('leave_processed')
                ->where(['id'=>$id,'employeeid' => $subordinateid, 'hod_status' => 'Pending'])
                ->update([
                    'hod_status' => 'Approved',
                    'hod_reason' => null,
                    'hod_created_date' => Carbon::now()->toDateTimeString()
                ]);
            }

            $randomno1 = rand(1, 5000);
            $toencrypt1 = $subordinateid.'-#admin#-'.$randomno1;
            $adminencrypt = Crypt::encrypt($toencrypt1);

            $get_lms_mailqueue_table = DB::connection('mysql6')->table('lms_mail_queue')->where(['reference_id'=>$id, 'processed' => '0'])->get();

            if (count($get_lms_mailqueue_table) > 0) {
                DB::connection('mysql6')->table('lms_mail_queue')
                ->where(['reference_id'=>$id])
                ->update([
                    'admin_session_key' => $adminencrypt,
                    'hod_session_key' => null
                ]);
            }
            old for admin approval*/

            /** start of new hod only approval */
            if (count($getlms_application) > 0) {

                $newar = [];
                $newar['employeeid'] = $subordinateid;
                
                foreach ($getlms_application as $key => $value) {
                    $sap_fromdate = $value->stdate;
                    $sap_todate = $value->etdate;
                    $sap_no_of_days = $value->no_of_days;
                    $sap_partial_days = $value->partial_days;
                    $sap_leave_type = $value->type;
                }
                

                if ($sap_partial_days == 'full') {
                
                    $newar['from_date'] = substr($sap_fromdate,0,10);
                    $newar['to_date'] = substr($sap_todate,0,10);
                    $newar['starttime'] = '';
                    $newar['endtime'] = '';

                }
                elseif($sap_partial_days == 'first_half'){
                    $newar['from_date'] = substr($sap_fromdate,0,10);
                    $newar['to_date'] = substr($sap_todate,0,10);
                    $newar['starttime'] = substr($sap_fromdate,11,5);
                    $newar['endtime'] = substr($sap_todate,11,5);

                }
                elseif($sap_partial_days == 'second_half'){
                    $newar['from_date'] = substr($sap_fromdate,0,10);
                    $newar['to_date'] = substr($sap_todate,0,10);
                    $newar['starttime'] = substr($sap_fromdate,11,5);
                    $newar['endtime'] = substr($sap_todate,11,5);

                }else{
                    //sd
                }
                $newar['leave_type'] = $sap_leave_type;
                /*if ($sap_leave_type == 'Permission') {
                    $newar['leave_type'] = 'Onduty';    
                }
                else{
                    $newar['leave_type'] = $sap_leave_type;
                }*/
                
                
               //$this->insert_applicationtosapfinal($newar);
                DB::connection('mysql6')->table('send_sap_leave_details')->insert(['details' => json_encode($newar), 'created_datetime' => Carbon::now()->toDateTimeString()]);
                
                DB::connection('mysql6')->table('leave_processed')
                ->where(['id'=>$id,'employeeid' => $subordinateid, 'hod_status' => 'Pending'])
                ->update([
                    'hod_status' => 'Approved',
                    'hod_reason' => null,
                    'admin_status' => 'Approved',
                    'admin_created_date' => Carbon::now()->toDateTimeString(),
                    'final_status' => 'Approved',
                    'hod_created_date' => Carbon::now()->toDateTimeString()
                ]);
            }

            $get_lms_mailqueue_table = DB::connection('mysql6')->table('lms_mail_queue')->where(['reference_id'=>$id, 'processed' => '0'])->get();

            if (count($get_lms_mailqueue_table) > 0) {
                DB::connection('mysql6')->table('lms_mail_queue')
                ->where(['reference_id'=>$id])
                ->update([
                    'sent_to_hod' => Carbon::now()->toDateTimeString(),
                    'admin_session_key' => null,
                    'hod_session_key' => null,
                    'sent_to_admin' => Carbon::now()->toDateTimeString()
                ]);
            }

            $get_date_diff = DB::connection('mysql6')->table('datetime_ref')->where(['reference_id'=>$id,'final_status' => 'Pending'])->get();
            if (count($get_date_diff) > 0) {

                DB::connection('mysql6')->table('datetime_ref')
                ->where(['reference_id'=>$id,'employeeid' => $subordinateid, 'final_status' => 'Pending'])
                ->update([
                    'final_status' => 'Approved'
                ]);
            }
            /** end of new hod only approval */

        }
        if ($mainstatus == 'Rejected') {
            $getlms_application = DB::connection('mysql6')->table('leave_processed')->where(['id'=>$id, 'hod_status' => 'Pending'])->get();
            if (count($getlms_application) > 0) {

                DB::connection('mysql6')->table('leave_processed')
                ->where(['id'=>$id,'employeeid' => $subordinateid, 'hod_status' => 'Pending'])
                ->update([
                    'hod_status' => 'Rejected',
                    'hod_reason' => $reason,
                    'admin_status' => 'Rejected',
                    'final_status' => 'Rejected',
                    'admin_reason' => null,
                    'hod_created_date' => Carbon::now()->toDateTimeString(),
                    'admin_created_date' => Carbon::now()->toDateTimeString()
                ]);
            }

            $get_date_diff = DB::connection('mysql6')->table('datetime_ref')->where(['reference_id'=>$id,'final_status' => 'Pending'])->get();
            if (count($get_date_diff) > 0) {

                DB::connection('mysql6')->table('datetime_ref')
                ->where(['reference_id'=>$id,'employeeid' => $subordinateid, 'final_status' => 'Pending'])
                ->update([
                    'final_status' => 'Rejected'
                ]);

                $count = 0;
                $current_month = Carbon::now()->format('m');
                $current_year = Carbon::now()->format('Y');

                foreach ($get_date_diff as $key22 => $value22) {
                    $applied_month = $value22->applied_month;
                    $applied_year = $value22->applied_year;
                    $type = $value22->type;
                    $application_month = $value22->month;
                    $application_year = $value22->year;
                    $application_partial_days = $value22->partial_days;
                    
                    if (($type == 'Permission') || ($type == 'Mispunch')) {
                        $count = $count + 1;
                    }
                    else{
                    if ($application_partial_days == 'full') {
                        $count = $count + 1;
                    }
                    else {
                        $count = $count + 0.5;
                    }

                    }
                }

                if (($current_month == $applied_month) || ($current_month > $applied_month)) {
                    $getbalance = DB::connection('mysql6')->table('leave_balance')->where(['employeeid'=>$subordinateid,'month' => $applied_month,'year' => $applied_year])
                    ->get();
                    foreach ($getbalance as $key33 => $value33) {
                        $balance = $value33->$type;
                    }
                    if (($type == 'CL') || ($type == 'SL') || ($type == 'PL') || ($type == 'ML') || ($type == 'RH') || ($type == 'Permission')) {
                        $toupdate = $balance + $count;
                    }
                    else{
                        $toupdate = $balance - $count;
                    }
                    
                    DB::connection('mysql6')->table('leave_balance')->where(['employeeid'=>$subordinateid,'month' => $applied_month,'year' => $applied_year])
                    ->update([
                        $type => $toupdate
                    ]);

                    $formarr = DB::connection('mysql6')->table('leave_balance')->where(['employeeid'=>$subordinateid,'month' => $applied_month,'year' => $applied_year])->get();

                    if (count($formarr) > 0) {
                        foreach ($formarr as $key => $value) {
                            $arr = (array) $value;    
                        }
                        if ($arr['Onduty'] == null) { $arr['Onduty'] = ''; }
                        if ($arr['Tour'] == null) { $arr['Tour'] = ''; }
                        if ($arr['Compoff'] == null) { $arr['Compoff'] = ''; }
                        if ($arr['Mispunch'] == null) { $arr['Mispunch'] = ''; }
                        if ($arr['Onduty'] == null) { $arr['Onduty'] = ''; }
                        $this->updateleave_balance($arr);
                        // DB::connection('mysql6')->table('send_sap_leave_details')->insert(
                        //     ['details' => json_encode($arr), 'created_datetime' => Carbon::now()->toDateTimeString()]
                        // );
                    }
                }
                
                if (($current_month < $applied_month)) {
                    $getbalance = DB::connection('mysql6')->table('leave_balance')->where(['employeeid'=>$subordinateid,'month' => $applied_month,'year' => $applied_year])
                    ->get();
                    
                    foreach ($getbalance as $key33 => $value33) {
                        $balance = $value33->$type;
                    }
                    if (($type == 'CL') || ($type == 'SL') || ($type == 'PL') || ($type == 'ML') || ($type == 'RH') || ($type == 'Permission')) {
                        $toupdate = $balance + $count;
                    }
                    else{
                        $toupdate = $balance - $count;
                    }
                    DB::connection('mysql6')->table('leave_balance')->where(['employeeid'=>$subordinateid,'month' => $current_month,'year' => $current_year])
                    ->update([
                        $type => $toupdate
                    ]);

                    $formarr = DB::connection('mysql6')->table('leave_balance')->where(['employeeid'=>$subordinateid,'month' => $current_month,'year' => $current_year])->get();

                    if (count($formarr) > 0) {
                        foreach ($formarr as $key => $value) {
                            $arr = (array) $value;    
                        }
                        if ($arr['Onduty'] == null) { $arr['Onduty'] = ''; }
                        if ($arr['Tour'] == null) { $arr['Tour'] = ''; }
                        if ($arr['Compoff'] == null) { $arr['Compoff'] = ''; }
                        if ($arr['Mispunch'] == null) { $arr['Mispunch'] = ''; }
                        if ($arr['Onduty'] == null) { $arr['Onduty'] = ''; }
                        $this->updateleave_balance($arr);
                        // DB::connection('mysql6')->table('send_sap_leave_details')->insert(
                        //     ['details' => json_encode($arr), 'created_datetime' => Carbon::now()->toDateTimeString()]
                        // );
                    }
                }

            }

            /* old for admin approval 

            $randomno1 = rand(1, 5000);
            $toencrypt1 = $subordinateid.'-#admin#-'.$randomno1;
            $adminencrypt = Crypt::encrypt($toencrypt1);

            $get_lms_mailqueue_table = DB::connection('mysql6')->table('lms_mail_queue')->where(['reference_id'=>$id, 'processed' => '0'])->get();

            if (count($get_lms_mailqueue_table) > 0) {
                DB::connection('mysql6')->table('lms_mail_queue')
                ->where(['reference_id'=>$id])
                ->update([
                    'admin_session_key' => $adminencrypt,
                    'hod_session_key' => null
                ]);
            }
             old for admin approval */

            /** new only hod approval */
            $get_lms_mailqueue_table = DB::connection('mysql6')->table('lms_mail_queue')->where(['reference_id'=>$id, 'processed' => '0'])->get();

            if (count($get_lms_mailqueue_table) > 0) {
                DB::connection('mysql6')->table('lms_mail_queue')
                ->where(['reference_id'=>$id])
                ->update([
                    'sent_to_hod' => Carbon::now()->toDateTimeString(),
                    'admin_session_key' => null,
                    'hod_session_key' => null,
                    'sent_to_admin' => Carbon::now()->toDateTimeString()
                ]);
            }
            /** new only hod approval */

        }
       
            
            
                return response()
            ->json(['status' => 1 ,'message' => 'Authorized'], 200);
            
        
        
        

        }
        
        return response()
            ->json(['message' => "Unauthorized"], 401);
    }


    public function admin_application(Request $request)
    {
        if ($request->session()->has('employeesession')) {
            $encrypt = $request->session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $employeeid = $split[0];
            $mydetails = [];
            $getemployeedata = DB::connection('mysql6')->table('employee')->where('id', '=', $employeeid)->get();

            

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


            $getactiveemployees = $this->getallactiveemployees();
            
            $getsubordinates = [];

            if (count($getactiveemployees) > 0) {
                $i=0;
                foreach ($getactiveemployees['Details'] as $key => $value) {
                    
                    
                        $getsubordinates[$i]['empid'] = $value['Emp_ID'];
                        $getsubordinates[$i]['empname'] = $value['Emp_Name'];
                        $i += 1;
                    
                }    
            }


                        $currentmonth = Carbon::now()->format('m');
                        $currentyear = Carbon::now()->format('Y');

            $applications = [];
            if (!empty($getsubordinates)) {
                $i = 0;
                foreach ($getsubordinates as $key1 => $value1) {
                    $getallapplications = DB::connection('mysql6')->table('leave_processed')->where(['employeeid' => $value1['empid'], 'month'=>$currentmonth, 'year' => $currentyear])->orderBy('created_date', 'desc')->get()->toArray();   
                    if (count($getallapplications) > 0) {
                        foreach ($getallapplications as $key => $value) {
                            $applications[$i] = (array)$value; 
                            $id = $value->id;

                            $getcompoff = DB::connection('mysql6')->table('compoff_reference')->where(['employee_id' => $value1['empid'], 'app_ref_id' => $id])->get()->toArray();
                            if (count($getcompoff) > 0) {
                                foreach ($getcompoff as $key2 => $value2) {
                                    $value2->punches_taken = json_decode($value2->punches_taken);
                                    $applications[$i]['compoff'][] = (array)$value2; 
                                }
                                
                            }
                            else{
                                $applications[$i]['compoff'] = ''; 
                            }
                            $getod = DB::connection('mysql6')->table('od_reference')->where(['employee_id' => $value1['empid'], 'app_ref_id' => $id])->get()->toArray();
                            if (count($getod) > 0) {
                                foreach ($getod as $key3 => $value3) {
                                    $value3->puncheslist = json_decode($value3->puncheslist);
                                    $applications[$i]['od'][] = (array)$value3;
                                }
                                 
                            }
                            else{
                                $applications[$i]['od'] = '';
                            }
                            $applications[$i]['employeename'] = $value1['empname'];
                            $i = $i + 1;
                        }
                    }
                }
            }

            //dd($applications);
            
            $show_selectall_btn = 0;
            /* for hod only approval 
            if (!empty($applications)) {
                foreach ($applications as $key => $value) {
                    if ($value['admin_status'] == 'Pending') {
                        $show_selectall_btn = $show_selectall_btn + 1;
                    }
                }
            }
            */
            

            return view('newemployeezone.lms.admin_application')->with(['getemployeedata'=>$getemployeedata,'show_selectall_btn' => $show_selectall_btn,'getallapplications' => $applications, 'profilepic'=>$profilepic, 'employeeid' => $employeeid]);

        }

        return view('newemployeezone.login');
    }

   


    public function postadmin_application(Request $request)
    {
        if ($request->session()->has('employeesession')) {
            $encrypt = $request->session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $remployeeid = $split[0];

        $id = $request->id;
        $reason = $request->reason;
        $status = $request->status;
        $subordinateid = $request->subordinateid;
        
        if ($status == 1) {
            $mainstatus = 'Approved';
        }else{
            $mainstatus = 'Rejected';
        }
        $hod_created_date = Carbon::now()->toDateTimeString();
        

        $getactiveemployees = $this->getallactiveemployees();
            
            $getsubordinates = [];


            if (in_array($remployeeid, config('newlmsconfig'))) {
                $valid = 1;
            }else{
                $valid = 0;
            }            


            if ($mainstatus == 'Approved') {
                $getlms_application = DB::connection('mysql6')->table('leave_processed')->where(['id'=>$id, 'admin_status' => 'Pending'])->get();
                
            if (count($getlms_application) > 0) {

                $newar = [];
                $newar['employeeid'] = $subordinateid;
                
                foreach ($getlms_application as $key => $value) {
                    $sap_fromdate = $value->stdate;
                    $sap_todate = $value->etdate;
                    $sap_no_of_days = $value->no_of_days;
                    $sap_partial_days = $value->partial_days;
                    $sap_leave_type = $value->type;
                }
                

                if ($sap_partial_days == 'full') {
                
                    $newar['from_date'] = substr($sap_fromdate,0,10);
                    $newar['to_date'] = substr($sap_todate,0,10);
                    $newar['starttime'] = '';
                    $newar['endtime'] = '';

                }
                elseif($sap_partial_days == 'first_half'){
                    $newar['from_date'] = substr($sap_fromdate,0,10);
                    $newar['to_date'] = substr($sap_todate,0,10);
                    $newar['starttime'] = substr($sap_fromdate,11,5);
                    $newar['endtime'] = substr($sap_todate,11,5);

                }
                elseif($sap_partial_days == 'second_half'){
                    $newar['from_date'] = substr($sap_fromdate,0,10);
                    $newar['to_date'] = substr($sap_todate,0,10);
                    $newar['starttime'] = substr($sap_fromdate,11,5);
                    $newar['endtime'] = substr($sap_todate,11,5);

                }else{
                    //sd
                }
                $newar['leave_type'] = $sap_leave_type;
                /*if ($sap_leave_type == 'Permission') {
                    $newar['leave_type'] = 'Onduty';    
                }
                else{
                    $newar['leave_type'] = $sap_leave_type;
                }*/
                
                
               //$this->insert_applicationtosapfinal($newar);
                DB::connection('mysql6')->table('send_sap_leave_details')->insert(['details' => json_encode($newar), 'created_datetime' => Carbon::now()->toDateTimeString()]);
                
                DB::connection('mysql6')->table('leave_processed')
                ->where(['id'=>$id,'employeeid' => $subordinateid, 'admin_status' => 'Pending'])
                ->update([
                    'admin_status' => 'Approved',
                    'admin_reason' => null,
                    'final_status' => 'Approved',
                    'admin_created_date' => Carbon::now()->toDateTimeString()
                ]);
            }


            $get_date_diff = DB::connection('mysql6')->table('datetime_ref')->where(['reference_id'=>$id,'final_status' => 'Pending'])->get();
            if (count($get_date_diff) > 0) {
                DB::connection('mysql6')->table('datetime_ref')
                ->where(['reference_id'=>$id,'employeeid' => $subordinateid, 'final_status' => 'Pending'])
                ->update([
                    'final_status' => 'Approved'
                ]);

                $count = 0;
                $current_month = Carbon::now()->format('m');
                $current_year = Carbon::now()->format('Y');

                foreach ($get_date_diff as $key22 => $value22) {
                    $applied_month = $value22->applied_month;
                    $applied_year = $value22->applied_year;
                    $type = $value22->type;
                    $application_month = $value22->month;
                    $application_year = $value22->year;
                }

                if (($current_month == $applied_month) || ($current_month > $applied_month)) {
                    $getbalance = DB::connection('mysql6')->table('leave_balance')->where(['employeeid'=>$subordinateid,'month' => $applied_month,'year' => $applied_year])
                    ->get();
                    
                    $formarr = DB::connection('mysql6')->table('leave_balance')->where(['employeeid'=>$subordinateid,'month' => $applied_month,'year' => $applied_year])->get();
                    if (count($formarr) > 0) {
                        foreach ($formarr as $key => $value) {
                            $arr = (array) $value;    
                        }
                        if ($arr['Onduty'] == null) { $arr['Onduty'] = ''; }
                        if ($arr['Tour'] == null) { $arr['Tour'] = ''; }
                        if ($arr['Compoff'] == null) { $arr['Compoff'] = ''; }
                        if ($arr['Mispunch'] == null) { $arr['Mispunch'] = ''; }
                        if ($arr['Onduty'] == null) { $arr['Onduty'] = ''; }

                        // DB::connection('mysql6')->table('send_sap_leave_details')->insert(
                        //     ['details' => json_encode($arr), 'created_datetime' => Carbon::now()->toDateTimeString()]
                        // );
                        $this->updateleave_balance($arr);
                    }

                }
                
                if (($current_month < $applied_month)) {
                                        
                    $formarr = DB::connection('mysql6')->table('leave_balance')->where(['employeeid'=>$subordinateid,'month' => $current_month,'year' => $current_year])
                    ->get();

                    if (count($formarr) > 0) {
                        foreach ($formarr as $key => $value) {
                            $arr = (array) $value;    
                        }
                        if ($arr['Onduty'] == null) { $arr['Onduty'] = ''; }
                        if ($arr['Tour'] == null) { $arr['Tour'] = ''; }
                        if ($arr['Compoff'] == null) { $arr['Compoff'] = ''; }
                        if ($arr['Mispunch'] == null) { $arr['Mispunch'] = ''; }
                        if ($arr['Onduty'] == null) { $arr['Onduty'] = ''; }
                        $this->updateleave_balance($arr);
                        // DB::connection('mysql6')->table('send_sap_leave_details')->insert(
                        //     ['details' => json_encode($arr), 'created_datetime' => Carbon::now()->toDateTimeString()]
                        // );
                    }
                }
            }

            $get_lms_mailqueue_table = DB::connection('mysql6')->table('lms_mail_queue')->where(['reference_id'=>$id, 'processed' => '0'])->get();

            if (count($get_lms_mailqueue_table) > 0) {
                DB::connection('mysql6')->table('lms_mail_queue')
                ->where(['reference_id'=>$id])
                ->update([
                    'admin_session_key' => null,
                    'hod_session_key' => null
                ]);
            }

        }
        if ($mainstatus == 'Rejected') {
            $getlms_application = DB::connection('mysql6')->table('leave_processed')->where(['id'=>$id, 'admin_status' => 'Pending'])->get();
            if (count($getlms_application) > 0) {
                DB::connection('mysql6')->table('leave_processed')
                ->where(['id'=>$id,'employeeid' => $subordinateid, 'admin_status' => 'Pending'])
                ->update([
                    'admin_status' => 'Rejected',
                    'admin_reason' => $reason,
                    'final_status' => 'Rejected',
                    'admin_created_date' => Carbon::now()->toDateTimeString()
                ]);
            }

            $get_date_diff = DB::connection('mysql6')->table('datetime_ref')->where(['reference_id'=>$id,'final_status' => 'Pending'])->get();
            if (count($get_date_diff) > 0) {

                DB::connection('mysql6')->table('datetime_ref')
                ->where(['reference_id'=>$id,'employeeid' => $subordinateid, 'final_status' => 'Pending'])
                ->update([
                    'final_status' => 'Rejected'
                ]);

                $count = 0;
                $current_month = Carbon::now()->format('m');
                $current_year = Carbon::now()->format('Y');

                foreach ($get_date_diff as $key22 => $value22) {
                    $applied_month = $value22->applied_month;
                    $applied_year = $value22->applied_year;
                    $type = $value22->type;
                    $application_month = $value22->month;
                    $application_year = $value22->year;
                    $application_partial_days = $value22->partial_days;
                    
                    if (($type == 'Permission') || ($type == 'Mispunch')) {
                        $count = $count + 1;
                    }
                    else{
                    if ($application_partial_days == 'full') {
                        $count = $count + 1;
                    }
                    else {
                        $count = $count + 0.5;
                    }

                    }
                }

                if (($current_month == $applied_month) || ($current_month > $applied_month)) {
                    $getbalance = DB::connection('mysql6')->table('leave_balance')->where(['employeeid'=>$subordinateid,'month' => $applied_month,'year' => $applied_year])
                    ->get();
                    foreach ($getbalance as $key33 => $value33) {
                        $balance = $value33->$type;
                    }
                    if (($type == 'CL') || ($type == 'SL') || ($type == 'PL') || ($type == 'ML') || ($type == 'RH') || ($type == 'Permission')) {
                        $toupdate = $balance + $count;
                    }
                    else{
                        $toupdate = $balance - $count;
                    }
                    DB::connection('mysql6')->table('leave_balance')->where(['employeeid'=>$subordinateid,'month' => $applied_month,'year' => $applied_year])
                    ->update([
                        $type => $toupdate
                    ]);
                    $formarr = DB::connection('mysql6')->table('leave_balance')->where(['employeeid'=>$subordinateid,'month' => $applied_month,'year' => $applied_year])->get();
                    if (count($formarr) > 0) {
                        foreach ($formarr as $key => $value) {
                            $arr = (array) $value;    
                        }
                        if ($arr['Onduty'] == null) { $arr['Onduty'] = ''; }
                        if ($arr['Tour'] == null) { $arr['Tour'] = ''; }
                        if ($arr['Compoff'] == null) { $arr['Compoff'] = ''; }
                        if ($arr['Mispunch'] == null) { $arr['Mispunch'] = ''; }
                        if ($arr['Onduty'] == null) { $arr['Onduty'] = ''; }
                        $this->updateleave_balance($arr);
                        // DB::connection('mysql6')->table('send_sap_leave_details')->insert(
                        //     ['details' => json_encode($arr), 'created_datetime' => Carbon::now()->toDateTimeString()]
                        // );
                    }
                }
                
                if (($current_month < $applied_month)) {
                    $getbalance = DB::connection('mysql6')->table('leave_balance')->where(['employeeid'=>$subordinateid,'month' => $applied_month,'year' => $applied_year])
                    ->get();
                    
                    foreach ($getbalance as $key33 => $value33) {
                        $balance = $value33->$type;
                    }
                    if (($type == 'CL') || ($type == 'SL') || ($type == 'PL') || ($type == 'ML') || ($type == 'RH') || ($type == 'Permission')) {
                        $toupdate = $balance + $count;
                    }
                    else{
                        $toupdate = $balance - $count;
                    }
                    DB::connection('mysql6')->table('leave_balance')->where(['employeeid'=>$subordinateid,'month' => $current_month,'year' => $current_year])
                    ->update([
                        $type => $toupdate
                    ]);

                    $formarr = DB::connection('mysql6')->table('leave_balance')->where(['employeeid'=>$subordinateid,'month' => $current_month,'year' => $current_year])->get();

                    if (count($formarr) > 0) {
                        foreach ($formarr as $key => $value) {
                            $arr = (array) $value;    
                        }
                        if ($arr['Onduty'] == null) { $arr['Onduty'] = ''; }
                        if ($arr['Tour'] == null) { $arr['Tour'] = ''; }
                        if ($arr['Compoff'] == null) { $arr['Compoff'] = ''; }
                        if ($arr['Mispunch'] == null) { $arr['Mispunch'] = ''; }
                        if ($arr['Onduty'] == null) { $arr['Onduty'] = ''; }
                        $this->updateleave_balance($arr);
                        // DB::connection('mysql6')->table('send_sap_leave_details')->insert(
                        //     ['details' => json_encode($arr), 'created_datetime' => Carbon::now()->toDateTimeString()]
                        // );
                    }
                }

                $get_lms_mailqueue_table = DB::connection('mysql6')->table('lms_mail_queue')->where(['reference_id'=>$id, 'processed' => '0'])->get();

                if (count($get_lms_mailqueue_table) > 0) {
                    DB::connection('mysql6')->table('lms_mail_queue')
                    ->where(['reference_id'=>$id])
                    ->update([
                        'admin_session_key' => null,
                        'hod_session_key' => null
                    ]);
                }

            }

        }
        
             return response()
            ->json(['status' => 1 ,'message' => 'Authorized'], 200);

       
    
    }
    }

    public function lmsmailsendqueue()
    {
        $lms_mail_queue = DB::connection('mysql6')->table('lms_mail_queue')->where(['processed'=>'0'])->get();
        Log::info('LMS1 Mail and SMS process started... ');
        $data_tom_send_mail = [];
	$exception_emails = ['noemail@vgn.in'];
        
        if (count($lms_mail_queue) > 0) {
            Log::info('Process1 data count = '.count($lms_mail_queue));
            if (count($lms_mail_queue) != 0) {
                $i = 0;
                foreach ($lms_mail_queue as $key => $value) {
                    $arr = (array) $value;
                    if (($arr['sent_to_hod'] == null) && ($arr['sent_to_admin'] == null)&& ($arr['processed'] == '0')) {
                    //get reporting incharge mailid
                    //$get employeemailid
                    //application data
                    //subject       

                    $getlms_application = DB::connection('mysql6')->table('leave_processed')->where(['id'=>$arr['reference_id']])->get();
                    
                    foreach ($getlms_application as $key1 => $value1) {
                        
                        $data_tom_send_mail = [];

                        $app = (array) $value1;
                        //$getemployeedata = DB::connection('mysql6')->table('employee')->where(['id'=>$app['employeeid']])->get();
                        $getactivedetails = $this->getactivedetails($app['employeeid']);
                        $report_incharge_details = $this->getemployee($getactivedetails['report_incharge_id']);
                        $employee_details = $this->getemployee($app['employeeid']);
                        
                        $data_tom_send_mail[$i]['hod_name'] = $report_incharge_details['First_Name'].' '.$report_incharge_details['Last_Name'];
                        $data_tom_send_mail[$i]['employee_name'] = $employee_details['First_Name'].' '.$employee_details['Last_Name'];
                        $data_tom_send_mail[$i]['employee_details'] = $employee_details;
                        $data_tom_send_mail[$i]['hod_off_mail'] = $report_incharge_details['Office_Email'];
                        $data_tom_send_mail[$i]['employee_off_mail'] = $employee_details['Office_Email'];
                        $employee_mobileno = $employee_details['Personal_Mobile'];
                        $hod_mobileno = $report_incharge_details['Personal_Mobile'];
                        $data_tom_send_mail[$i]['hash_key'] = $arr['hod_session_key'];
                        $data_tom_send_mail[$i]['leave_processed'] = $app;

                        $compoff_reference = DB::connection('mysql6')->table('compoff_reference')->where(['app_ref_id'=>$arr['reference_id']])->get();
                        if (count($compoff_reference) > 0) {
                            foreach ($compoff_reference as $key2 => $value2) {
                                $value2->punches_taken = json_decode($value2->punches_taken);
                                $data_tom_send_mail[$i]['compoff_processed'][] = (array) $value2;
                            }
                        }
                        else{
                            $data_tom_send_mail[$i]['compoff_processed'] = [];
                        }
                        $od_reference = DB::connection('mysql6')->table('od_reference')->where(['app_ref_id'=>$arr['reference_id']])->get();
                        if (count($od_reference) > 0) {
                            foreach ($od_reference as $key3 => $value3) {
                                $value3->puncheslist = json_decode($value3->puncheslist);
                                $data_tom_send_mail[$i]['od_reference'][] = (array) $value3;
                            }
                        }
                        else{
                            $data_tom_send_mail[$i]['od_reference'] = [];
                        }

                        $data_tom_send_mail[$i]['member'] = 'HOD';                      
                        

                         foreach ($data_tom_send_mail as $key222 => $value222) {
                            $newmaildata = $value222;
                        }
                        
                      if (!empty($data_tom_send_mail[$i]['hod_off_mail'])) {
                        $ss = strtolower($data_tom_send_mail[$i]['hod_off_mail']);
                        if (!filter_var($ss, FILTER_VALIDATE_EMAIL)) { Log::info('Not a valid address = '.$ss); }else{
			if (in_array($ss, $exception_emails) === false) {
                        Log::info('Sending Email for approval copy to hod = '.$ss);
                            $md_sec = "mdsecretary@vgn.in";
                            if ($ss == 'md@vgn.in') { Mail::to($md_sec)->send(new finalcommonlmsmail($newmaildata)); }
                            Mail::to($ss)->send(new finalcommonlmsmail($newmaildata));
                            }
			  }
                        }  
                    if (!empty($data_tom_send_mail[$i]['employee_off_mail'])) {
                        $jj = strtolower($data_tom_send_mail[$i]['employee_off_mail']);
                        if (!filter_var($jj, FILTER_VALIDATE_EMAIL)) { Log::info('Not a valid address = '.$jj); }else{
			if (in_array($jj, $exception_emails) === false) {
                        Log::info('Sending Email for applied copy to employee = '.$jj);
                        Mail::to($jj)->send(new finalempcommonlmsmail($newmaildata));
                        }
	               }
                    }


                        if(ctype_digit($employee_mobileno)){
                            if (strlen($employee_mobileno) == 10) {                                
                        $emp_smscontent = 'Dear '.$data_tom_send_mail[$i]['employee_name'].', Your '.$data_tom_send_mail[$i]['leave_processed']['type'].' Application on '.Carbon::parse($data_tom_send_mail[$i]['leave_processed']['stdate'])->format('d, M Y h:i:s A').' to '.Carbon::parse($data_tom_send_mail[$i]['leave_processed']['etdate'])->format('d, M Y h:i:s A').' submitted for HOD Approval.'; 
                        $employee_status = $this->smscurl($emp_smscontent, $employee_mobileno); 
                        DB::connection('mysql6')->table('sms_sent_data')->insert(['employeeid' => $data_tom_send_mail[$i]['leave_processed']['employeeid'],'sentdatetime' => Carbon::now()->toDateTimeString()]);
                        Log::info('Seding SMS for applied copy to employee = '.$employee_mobileno);
                            }
                        }

                        if(ctype_digit($hod_mobileno)){
                            if (strlen($hod_mobileno) == 10) {
                        $hod_smscontent = 'Dear '.$data_tom_send_mail[$i]['hod_name'].', '.$data_tom_send_mail[$i]['leave_processed']['type'].' Application on '.Carbon::parse($data_tom_send_mail[$i]['leave_processed']['stdate'])->format('d, M Y h:i:s A').' to '.Carbon::parse($data_tom_send_mail[$i]['leave_processed']['etdate'])->format('d, M Y h:i:s A').' submitted for Approval by '.$data_tom_send_mail[$i]['employee_name'].'('.$data_tom_send_mail[$i]['leave_processed']['employeeid'].'). Kindly check your official mail/employee login.'; 
                        Log::info('Seding SMS for approval copy to hod = '.$hod_mobileno);
                        $hod_status = $this->smscurl($hod_smscontent, $hod_mobileno);               
                        DB::connection('mysql6')->table('sms_sent_data')->insert(['employeeid' => $data_tom_send_mail[$i]['leave_processed']['employeeid'],'sentdatetime' => Carbon::now()->toDateTimeString()]);
                            }
                        }                        
                        
                       
                    
                   
                   DB::connection('mysql6')->table('lms_mail_queue')->where(['reference_id'=>$app['id']])
                   ->update(['sent_to_hod' => Carbon::now()->toDateTimeString()]);
                   
                   
                   
                        $i = $i + 1;
                    }
                    
                    //tohod mail and copy to employee
                    }

                    if (($arr['sent_to_hod'] != null) && ($arr['hod_session_key'] == null) && ($arr['admin_session_key'] != null) && ($arr['sent_to_admin'] == null)&& ($arr['processed'] == '0')) {
                            
                        $getlms_application = DB::connection('mysql6')->table('leave_processed')->where(['id'=>$arr['reference_id']])->get();
                        foreach ($getlms_application as $key1 => $value1) {
                            $data_tom_send_mail = [];
                            $app = (array) $value1;
                            
                            $employee_details = $this->getemployee($app['employeeid']);
                            
                            $data_tom_send_mail[$i]['admin_name'] = 'Admin';
                            $data_tom_send_mail[$i]['employee_name'] = $employee_details['First_Name'].' '.$employee_details['Last_Name'];
                            $data_tom_send_mail[$i]['employee_details'] = $employee_details;
                            $data_tom_send_mail[$i]['admin_off_mail'] = "hrincharge@vgn.in";
                            $employee_mobileno = $employee_details['Personal_Mobile'];
                            $data_tom_send_mail[$i]['employee_off_mail'] = $employee_details['Office_Email'];
                            $data_tom_send_mail[$i]['hash_key'] = $arr['admin_session_key'];
                            $data_tom_send_mail[$i]['leave_processed'] = $app;
    
                            $compoff_reference = DB::connection('mysql6')->table('compoff_reference')->where(['app_ref_id'=>$arr['reference_id']])->get();
                            if (count($compoff_reference) > 0) {
                                foreach ($compoff_reference as $key2 => $value2) {
                                    $value2->punches_taken = json_decode($value2->punches_taken);
                                    $data_tom_send_mail[$i]['compoff_processed'][] = (array) $value2;
                                }
                            }
                            else{
                                $data_tom_send_mail[$i]['compoff_processed'] = [];
                            }
                            $od_reference = DB::connection('mysql6')->table('od_reference')->where(['app_ref_id'=>$arr['reference_id']])->get();
                            if (count($od_reference) > 0) {
                                foreach ($od_reference as $key3 => $value3) {
                                    $value3->puncheslist = json_decode($value3->puncheslist);
                                    $data_tom_send_mail[$i]['od_reference'][] = (array) $value3;
                                }
                            }
                            else{
                                $data_tom_send_mail[$i]['od_reference'] = [];
                            }
    
                            $data_tom_send_mail[$i]['member'] = 'Admin';
                            $adminmobileno = "04443439999";
                            
                            if ($data_tom_send_mail[$i]['leave_processed']['hod_status'] == 'Approved') {

                                foreach ($data_tom_send_mail as $key222 => $value222) {
                                    $newmaildata = $value222;
                                }

                                if (!empty($data_tom_send_mail[$i]['admin_off_mail'])) {
                                    $ss = strtolower($data_tom_send_mail[$i]['admin_off_mail']);
                                    if (!filter_var($ss, FILTER_VALIDATE_EMAIL)) { Log::info('Not a valid address = '.$ss); }else{
				    if (in_array($ss, $exception_emails) === false) {
                                    Mail::to($ss)->send(new finalcommonlmsmail($newmaildata));
                                    }
				     }
                                }
                                if (!empty($data_tom_send_mail[$i]['employee_off_mail'])) {
                                    $jj = strtolower($data_tom_send_mail[$i]['employee_off_mail']);
                                    if (!filter_var($jj, FILTER_VALIDATE_EMAIL)) { Log::info('Not a valid address = '.$jj); }else{
					if (in_array($jj, $exception_emails) === false) {
                                    Mail::to($jj)->send(new finalempcommonlmsmail($newmaildata));
                                    }
				  }
                                }

                                if(ctype_digit($employee_mobileno)){
                                    if (strlen($employee_mobileno) == 10) {
                                $emp_smscontent = 'Dear '.$data_tom_send_mail[$i]['employee_name'].', Your '.$data_tom_send_mail[$i]['leave_processed']['type'].' Application on '.Carbon::parse($data_tom_send_mail[$i]['leave_processed']['stdate'])->format('d, M Y h:i:s A').' to '.Carbon::parse($data_tom_send_mail[$i]['leave_processed']['etdate'])->format('d, M Y h:i:s A').' Approved by HOD. Sent for Admin/HR final level approval.';                                 
                                $employee_status = $this->smscurl($emp_smscontent, $employee_mobileno);     
                                DB::connection('mysql6')->table('sms_sent_data')->insert(['employeeid' => $data_tom_send_mail[$i]['leave_processed']['employeeid'],'sentdatetime' => Carbon::now()->toDateTimeString()]);
                                    }
                                }
                                if(ctype_digit($adminmobileno)){
                                    if (strlen($adminmobileno) == 10) {                                
                                $admin_smscontent = 'Dear admin, '.$data_tom_send_mail[$i]['leave_processed']['type'].' Application on '.Carbon::parse($data_tom_send_mail[$i]['leave_processed']['stdate'])->format('d, M Y h:i:s A').' to '.Carbon::parse($data_tom_send_mail[$i]['leave_processed']['etdate'])->format('d, M Y h:i:s A').' submitted for Approval by '.$data_tom_send_mail[$i]['employee_name'].'('.$data_tom_send_mail[$i]['leave_processed']['employeeid'].'). Waiting for your final level approval!'; 
                                $admin_status = $this->smscurl($admin_smscontent, $adminmobileno);               
                                DB::connection('mysql6')->table('sms_sent_data')->insert(['employeeid' => $data_tom_send_mail[$i]['leave_processed']['employeeid'],'sentdatetime' => Carbon::now()->toDateTimeString()]);
                                    }
                                }

                                
                                
                                DB::connection('mysql6')->table('lms_mail_queue')->where(['reference_id'=>$app['id']])
                                ->update(['sent_to_admin' => Carbon::now()->toDateTimeString()]); 
                                
                            }
                            elseif($data_tom_send_mail[$i]['leave_processed']['hod_status'] == 'Rejected'){

                                foreach ($data_tom_send_mail as $key222 => $value222) {
                                    $newmaildata = $value222;
                                }
                               
                                if (!empty($data_tom_send_mail[$i]['employee_off_mail'])) {
                                    $jj = strtolower($data_tom_send_mail[$i]['employee_off_mail']);
                                    if (!filter_var($jj, FILTER_VALIDATE_EMAIL)) { Log::info('Not a valid address = '.$jj); }else{
				   if (in_array($jj, $exception_emails) === false) {
                                    Mail::to($jj)->send(new finalempcommonlmsmail($newmaildata));
                                    }
			           }
                                }

                                if(ctype_digit($employee_mobileno)){
                                    if (strlen($employee_mobileno) == 10) {
                                $emp_smscontent = 'Dear '.$data_tom_send_mail[$i]['employee_name'].', Your '.$data_tom_send_mail[$i]['leave_processed']['type'].' Application on '.Carbon::parse($data_tom_send_mail[$i]['leave_processed']['stdate'])->format('d, M Y h:i:s A').' to '.Carbon::parse($data_tom_send_mail[$i]['leave_processed']['etdate'])->format('d, M Y h:i:s A').' has been Rejected by HOD. Kindly check the employee login for details';                                 
                                $employee_status = $this->smscurl($emp_smscontent, $employee_mobileno);     
                                DB::connection('mysql6')->table('sms_sent_data')->insert(['employeeid' => $data_tom_send_mail[$i]['leave_processed']['employeeid'],'sentdatetime' => Carbon::now()->toDateTimeString()]);
                                
                                    }
                                }
                                                
                                
                                 DB::connection('mysql6')->table('lms_mail_queue')->where(['reference_id'=>$app['id']])
                                ->update(['admin_session_key' => null,'sent_to_admin' => Carbon::now()->toDateTimeString(), 'processed' => '1']);   
                                
                            }
                            else{
                                //no need to send mail
                            }
                    
    
                            $i = $i + 1;
                        }
    
                        
    
                        
                        //tohod mail and copy to employee
                        }

                        if (($arr['sent_to_hod'] != null)&& ($arr['hod_session_key'] == null)&& ($arr['sent_to_admin'] != null) && ($arr['admin_session_key'] == null) && ($arr['processed'] == '0')) {
    
    
                            $getlms_application = DB::connection('mysql6')->table('leave_processed')->where(['id'=>$arr['reference_id']])->get();
                            foreach ($getlms_application as $key1 => $value1) {
                                $data_tom_send_mail = [];
                                $app = (array) $value1;
                                $employee_details = $this->getemployee($app['employeeid']);
                                
                                $data_tom_send_mail[$i]['admin_name'] = 'Admin';
                                $data_tom_send_mail[$i]['employee_name'] = $employee_details['First_Name'].' '.$employee_details['Last_Name'];
                                $data_tom_send_mail[$i]['employee_details'] = $employee_details;
                                $data_tom_send_mail[$i]['admin_off_mail'] = "hrincharge@vgn.in";
                                $data_tom_send_mail[$i]['employee_off_mail'] = $employee_details['Office_Email'];
                                $employee_mobileno = $employee_details['Personal_Mobile'];
                                $data_tom_send_mail[$i]['hash_key'] = $arr['admin_session_key'];
                                $data_tom_send_mail[$i]['leave_processed'] = $app;
        
                                $compoff_reference = DB::connection('mysql6')->table('compoff_reference')->where(['app_ref_id'=>$arr['reference_id']])->get();
                                if (count($compoff_reference) > 0) {
                                    foreach ($compoff_reference as $key2 => $value2) {
                                        $value2->punches_taken = json_decode($value2->punches_taken);
                                        $data_tom_send_mail[$i]['compoff_processed'][] = (array) $value2;
                                    }
                                }
                                else{
                                    $data_tom_send_mail[$i]['compoff_processed'] = [];
                                }
                                $od_reference = DB::connection('mysql6')->table('od_reference')->where(['app_ref_id'=>$arr['reference_id']])->get();
                                if (count($od_reference) > 0) {
                                    foreach ($od_reference as $key3 => $value3) {
                                        $value3->puncheslist = json_decode($value3->puncheslist);
                                        $data_tom_send_mail[$i]['od_reference'][] = (array) $value3;
                                    }
                                }
                                else{
                                    $data_tom_send_mail[$i]['od_reference'] = [];
                                }
        
                                $data_tom_send_mail[$i]['member'] = 'finaladmin';
                                
                                //dd($data_tom_send_mail);
                                
                                foreach ($data_tom_send_mail as $key222 => $value222) {
                                    $newmaildata = $value222;
                                }

                                if (!empty($data_tom_send_mail[$i]['employee_off_mail'])) {
                                    Log::info('Sending Mail for final status to employee ='.$data_tom_send_mail[$i]['employee_off_mail']);
                                    $jj = strtolower($data_tom_send_mail[$i]['employee_off_mail']);
                                    if (!filter_var($jj, FILTER_VALIDATE_EMAIL)) { Log::info('Not a valid address = '.$jj); }else{
				    if (in_array($jj, $exception_emails) === false) {
				
                                    Mail::to($jj)->send(new finalempcommonlmsmail($newmaildata));
                                    }
					}
                                }
                                

                                if(ctype_digit($employee_mobileno)){
                                    if (strlen($employee_mobileno) == 10) {
                                $emp_smscontent = 'Dear '.$data_tom_send_mail[$i]['employee_name'].', Your '.$data_tom_send_mail[$i]['leave_processed']['type'].' Application on '.Carbon::parse($data_tom_send_mail[$i]['leave_processed']['stdate'])->format('d, M Y h:i:s A').' to '.Carbon::parse($data_tom_send_mail[$i]['leave_processed']['etdate'])->format('d, M Y h:i:s A').' '.$data_tom_send_mail[$i]['leave_processed']['admin_status'].' by HOD.';                                 
                                $employee_status = $this->smscurl($emp_smscontent, $employee_mobileno);     
                               DB::connection('mysql6')->table('sms_sent_data')->insert(['employeeid' => $data_tom_send_mail[$i]['leave_processed']['employeeid'],'sentdatetime' => Carbon::now()->toDateTimeString()]);
                               Log::info('Sending SMS for final status to employee ='.$employee_mobileno);
                                
                                    }
                                }

                                
                           
                           
                           DB::connection('mysql6')->table('lms_mail_queue')->where(['reference_id'=>$app['id']])
                           ->update(['processed' => '1','sent_to_admin' => Carbon::now()->toDateTimeString()]);   
                           
        
                                $i = $i + 1;
                            }
        
                            
        
                            
                            //tohod mail and copy to employee
                            }


                            if (($arr['sent_to_hod'] != null)&& ($arr['hod_session_key'] == null)&& ($arr['sent_to_admin'] == null) && ($arr['admin_session_key'] == null) && ($arr['processed'] == '0')) {
    
    
        
                                $getlms_application = DB::connection('mysql6')->table('leave_processed')->where(['id'=>$arr['reference_id']])->get();
                                foreach ($getlms_application as $key1 => $value1) {
                                    $data_tom_send_mail = [];
                                    $app = (array) $value1;
                                    $employee_details = $this->getemployee($app['employeeid']);
                                    
                                    $data_tom_send_mail[$i]['admin_name'] = 'Admin';
                                    $data_tom_send_mail[$i]['employee_name'] = $employee_details['First_Name'].' '.$employee_details['Last_Name'];
                                    $data_tom_send_mail[$i]['employee_details'] = $employee_details;
                                    $data_tom_send_mail[$i]['admin_off_mail'] = "hrincharge@vgn.in";
                                    $data_tom_send_mail[$i]['employee_off_mail'] = $employee_details['Office_Email'];
                                    $employee_mobileno = $employee_details['Personal_Mobile'];
                                    $data_tom_send_mail[$i]['hash_key'] = $arr['admin_session_key'];
                                    $data_tom_send_mail[$i]['leave_processed'] = $app;
            
                                    $compoff_reference = DB::connection('mysql6')->table('compoff_reference')->where(['app_ref_id'=>$arr['reference_id']])->get();
                                    if (count($compoff_reference) > 0) {
                                        foreach ($compoff_reference as $key2 => $value2) {
                                            $value2->punches_taken = json_decode($value2->punches_taken);
                                            $data_tom_send_mail[$i]['compoff_processed'][] = (array) $value2;
                                        }
                                    }
                                    else{
                                        $data_tom_send_mail[$i]['compoff_processed'] = [];
                                    }
                                    $od_reference = DB::connection('mysql6')->table('od_reference')->where(['app_ref_id'=>$arr['reference_id']])->get();
                                    if (count($od_reference) > 0) {
                                        foreach ($od_reference as $key3 => $value3) {
                                            $value3->puncheslist = json_decode($value3->puncheslist);
                                            $data_tom_send_mail[$i]['od_reference'][] = (array) $value3;
                                        }
                                    }
                                    else{
                                        $data_tom_send_mail[$i]['od_reference'] = [];
                                    }
            
                                    $data_tom_send_mail[$i]['member'] = 'finaladmin';
                                    
                                    //dd($data_tom_send_mail);
                                     foreach ($data_tom_send_mail as $key222 => $value222) {
                                        $newmaildata = $value222;
                                    }
    
                                if (!empty($data_tom_send_mail[$i]['employee_off_mail'])) {
                                    $jj = strtolower($data_tom_send_mail[$i]['employee_off_mail']);
                                    if (!filter_var($jj, FILTER_VALIDATE_EMAIL)) { Log::info('Not a valid address = '.$jj); }else{
					if (in_array($jj, $exception_emails) === false) {
                                    Mail::to($jj)->send(new finalempcommonlmsmail($newmaildata));
                                    }
					}
                                }
    
                                    if(ctype_digit($employee_mobileno)){
                                        if (strlen($employee_mobileno) == 10) {
                                    $emp_smscontent = 'Dear '.$data_tom_send_mail[$i]['employee_name'].', Your '.$data_tom_send_mail[$i]['leave_processed']['type'].' Application on '.Carbon::parse($data_tom_send_mail[$i]['leave_processed']['stdate'])->format('d, M Y h:i:s A').' to '.Carbon::parse($data_tom_send_mail[$i]['leave_processed']['etdate'])->format('d, M Y h:i:s A').' '.$data_tom_send_mail[$i]['leave_processed']['admin_status'].' by Admin/HR.';                                 
                                    $employee_status = $this->smscurl($emp_smscontent, $employee_mobileno);     
                                    DB::connection('mysql6')->table('sms_sent_data')->insert(['employeeid' => $data_tom_send_mail[$i]['leave_processed']['employeeid'],'sentdatetime' => Carbon::now()->toDateTimeString()]);
                                    
                                        }
                                    }
    
                                   
                               
                               DB::connection('mysql6')->table('lms_mail_queue')->where(['reference_id'=>$app['id']])
                               ->update(['processed' => '1', 'sent_to_admin' => Carbon::now()->toDateTimeString()]);   
                               
            
                                    $i = $i + 1;
                                }
            
                                
            
                                
                                //tohod mail and copy to employee
                                }
                }
            }
        }
        Log::info('LMS1 Mail and SMS process finished... ');
	dd('Completed');
        
    }

    public function getleavebalancedata(Request $request)
    {
        if ($request->session()->has('employeesession')) {
            $encrypt = $request->session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $employeeid = $split[0];

        $leave_type = $request->leave_type;
        $leave_date_range = $request->leave_date_range;
        $splitrange = explode('-',$leave_date_range);
        $startdate = $this->dateformatreturnddmmyytoyymmdd(trim($splitrange[0]));
        $enddate = $this->dateformatreturnddmmyytoyymmdd(trim($splitrange[1]));

        //$getmonth = $this->formatforempdat_returnmonth(trim($splitrange[0]));
        //$getyear = $this->formatforempdat_returnyear(trim($splitrange[0]));
        $getmonth = Carbon::now()->format('m');
        $getyear = Carbon::now()->format('Y');
        
            $alter1 = substr(trim($splitrange[0]), 0,10);
            $alter2 = substr(trim($splitrange[1]), 0,10);
            
        /**
         * find difference between two dates
         */
        //$diff = $this->formatforempdat_differbtwtwodates($this->dateformatreturnddmmyytoyymmdd($alter1), $this->dateformatreturnddmmyytoyymmdd($alter2));
        $diff = $this->formatforempdat_differbtwtwodates($startdate, $enddate);
            
        /**
         * end find difference between two dates
         */

        $getemployeebalance = DB::connection('mysql6')->table('leave_balance')->where(['employeeid' => $employeeid, 'month'=>$getmonth, 'year'=>$getyear])->get();

        if(count($getemployeebalance) > 0){
            return response()
            ->json(['balance' => $getemployeebalance[0] ,'message' => 'Authorized', 'difference' => $diff], 200);
        }else{
            return response()
            ->json(['balance' => '' ,'message' => 'Authorized'], 200);
        }
        

        }
        
        return response()
            ->json(['message' => "Unauthorized"], 401);

    }

    public function hodleaveoperation($hod_status, $hashedkey)
    {
        $check = DB::connection('mysql6')->table('lms_mail_queue')->where(['hod_session_key' => $hashedkey])->count();
        if ($check == '1') {
            $check1 = DB::connection('mysql6')->table('lms_mail_queue')->where(['hod_session_key' => $hashedkey])->get();
            foreach ($check1 as $key => $value) {
                $ref_id = $value->reference_id;
            }
            if ($hod_status == 'approve') {
            $getlms_application = DB::connection('mysql6')->table('leave_processed')->where(['id'=>$ref_id, 'hod_status' => 'Pending'])->get();
                
            if (count($getlms_application) > 0) {
                foreach ($getlms_application as $key1 => $value1) {
                    $subordinateid = $value1->employeeid;
                }

                $newar = [];
                $newar['employeeid'] = $subordinateid;
                
                foreach ($getlms_application as $key => $value) {
                    $sap_fromdate = $value->stdate;
                    $sap_todate = $value->etdate;
                    $sap_no_of_days = $value->no_of_days;
                    $sap_partial_days = $value->partial_days;
                    $sap_leave_type = $value->type;
                }
                

                if ($sap_partial_days == 'full') {
                
                    $newar['from_date'] = substr($sap_fromdate,0,10);
                    $newar['to_date'] = substr($sap_todate,0,10);
                    $newar['starttime'] = '';
                    $newar['endtime'] = '';

                }
                elseif($sap_partial_days == 'first_half'){
                    $newar['from_date'] = substr($sap_fromdate,0,10);
                    $newar['to_date'] = substr($sap_todate,0,10);
                    $newar['starttime'] = substr($sap_fromdate,11,5);
                    $newar['endtime'] = substr($sap_todate,11,5);

                }
                elseif($sap_partial_days == 'second_half'){
                    $newar['from_date'] = substr($sap_fromdate,0,10);
                    $newar['to_date'] = substr($sap_todate,0,10);
                    $newar['starttime'] = substr($sap_fromdate,11,5);
                    $newar['endtime'] = substr($sap_todate,11,5);

                }else{
                    //sd
                }
                $newar['leave_type'] = $sap_leave_type;
                /*if ($sap_leave_type == 'Permission') {
                    $newar['leave_type'] = 'Onduty';    
                }
                else{
                    $newar['leave_type'] = $sap_leave_type;
                }*/
                
                
               //$this->insert_applicationtosapfinal($newar);
                DB::connection('mysql6')->table('send_sap_leave_details')->insert(['details' => json_encode($newar), 'created_datetime' => Carbon::now()->toDateTimeString()]);
                
                /* old for admin login
                DB::connection('mysql6')->table('leave_processed')
                ->where(['id'=>$ref_id,'employeeid' => $subordinateid, 'hod_status' => 'Pending'])
                ->update([
                    'hod_status' => 'Approved',
                    'hod_reason' => null,
                    'hod_created_date' => Carbon::now()->toDateTimeString()
                ]);

               
            

            $randomno1 = rand(1, 5000);
            $toencrypt1 = $subordinateid.'-#admin#-'.$randomno1;
            $adminencrypt = Crypt::encrypt($toencrypt1);

            $get_lms_mailqueue_table = DB::connection('mysql6')->table('lms_mail_queue')->where(['reference_id'=>$ref_id, 'processed' => '0'])->get();

            if (count($get_lms_mailqueue_table) > 0) {
                DB::connection('mysql6')->table('lms_mail_queue')
                ->where(['reference_id'=>$ref_id])
                ->update([
                    'admin_session_key' => $adminencrypt,
                    'hod_session_key' => null
                ]);
            }
            old for admin login */

            /*new for finallevel hod only */

            DB::connection('mysql6')->table('leave_processed')
            ->where(['id'=>$ref_id,'employeeid' => $subordinateid, 'hod_status' => 'Pending'])
            ->update([
                'hod_status' => 'Approved',
                'hod_reason' => null,
                'admin_status' => 'Approved',
                'hod_created_date' => Carbon::now()->toDateTimeString(),
                'admin_created_date' => Carbon::now()->toDateTimeString(),
                'final_status' => 'Approved'
            ]);


        $get_lms_mailqueue_table = DB::connection('mysql6')->table('lms_mail_queue')->where(['reference_id'=>$ref_id, 'processed' => '0'])->get();

        if (count($get_lms_mailqueue_table) > 0) {
            DB::connection('mysql6')->table('lms_mail_queue')
            ->where(['reference_id'=>$ref_id])
            ->update([
                'sent_to_hod' => Carbon::now()->toDateTimeString(),
                'admin_session_key' => null,
                'hod_session_key' => null,
                'sent_to_admin' => Carbon::now()->toDateTimeString()
            ]);
        }

        $get_date_diff = DB::connection('mysql6')->table('datetime_ref')->where(['reference_id'=>$ref_id,'final_status' => 'Pending'])->get();
            if (count($get_date_diff) > 0) {

                DB::connection('mysql6')->table('datetime_ref')
                ->where(['reference_id'=>$ref_id,'employeeid' => $subordinateid, 'final_status' => 'Pending'])
                ->update([
                    'final_status' => 'Approved'
                ]);
            }

            /*new for finallevel hod only */
            dd('Application Approved!');
        }
            dd('Application Already Approved or rejected!');
            }
            else{
                $getdata = DB::connection('mysql6')->table('leave_processed')->where(['id' => $ref_id])->get();
            return view('newemployeezone.lms.hod_operation')->with(['getdata'=>$getdata, 'hashedkey' => $hashedkey, 'hod_status' => $hod_status]);
            }
            
        }else{
            //return redirect()->route('newemployee_home');
            dd('Application Already Approved or rejected!');
        }
    }

    public function posthodleaveoperation(Request $request)
    {
        $validate = $this->validate($request, [
            'hod_reason' => 'required|min:4|max:200',
            ]);

            $path = $request->getPathInfo();
            $arr = explode('/', $path);
            
            $check = DB::connection('mysql6')->table('lms_mail_queue')->where(['hod_session_key' => $arr[5]])->get();
            if (count($check) > 0) {
                foreach ($check as $key => $value) {
                    $id = $value->reference_id;
                }
                $getlms_application = DB::connection('mysql6')->table('leave_processed')->where(['id'=>$id, 'hod_status' => 'Pending'])->get();
                
            if (count($getlms_application) > 0) {
                foreach ($getlms_application as $key1 => $value1) {
                    $subordinateid = $value1->employeeid;
                }

                
                DB::connection('mysql6')->table('leave_processed')
                ->where(['id'=>$id,'employeeid' => $subordinateid, 'hod_status' => 'Pending'])
                ->update([
                    'hod_status' => 'Rejected',
                    'hod_reason' => $request->hod_reason,
                    'admin_status' => 'Rejected',
                    'final_status' => 'Rejected',
                    'admin_created_date' => Carbon::now()->toDateTimeString(),
                    'admin_reason' => null,
                    'hod_created_date' => Carbon::now()->toDateTimeString(),
                ]);
            

            $get_date_diff = DB::connection('mysql6')->table('datetime_ref')->where(['reference_id'=>$id,'final_status' => 'Pending'])->get();
            if (count($get_date_diff) > 0) {

                DB::connection('mysql6')->table('datetime_ref')
                ->where(['reference_id'=>$id,'employeeid' => $subordinateid, 'final_status' => 'Pending'])
                ->update([
                    'final_status' => 'Rejected'
                ]);

                $count = 0;
                $current_month = Carbon::now()->format('m');
                $current_year = Carbon::now()->format('Y');

                foreach ($get_date_diff as $key22 => $value22) {
                    $applied_month = $value22->applied_month;
                    $applied_year = $value22->applied_year;
                    $type = $value22->type;
                    $application_month = $value22->month;
                    $application_year = $value22->year;
                    $application_partial_days = $value22->partial_days;
                    
                    if (($type == 'Permission') || ($type == 'Mispunch')) {
                        $count = $count + 1;
                    }
                    else{
                    if ($application_partial_days == 'full') {
                        $count = $count + 1;
                    }
                    else {
                        $count = $count + 0.5;
                    }

                    }
                }

                
                        
                if (($current_month == $applied_month) || ($current_month > $applied_month)) {
                    $getbalance = DB::connection('mysql6')->table('leave_balance')->where(['employeeid'=>$subordinateid,'month' => $applied_month,'year' => $applied_year])
                    ->get();
                    foreach ($getbalance as $key33 => $value33) {
                        $balance = $value33->$type;
                    }
                    if (($type == 'CL') || ($type == 'SL') || ($type == 'PL') || ($type == 'ML') || ($type == 'RH') || ($type == 'Permission')) {
                        $toupdate = $balance + $count;
                    }
                    else{
                        $toupdate = $balance - $count;
                    }
                    DB::connection('mysql6')->table('leave_balance')->where(['employeeid'=>$subordinateid,'month' => $applied_month,'year' => $applied_year])
                    ->update([
                        $type => $toupdate
                    ]);

                    $formarr = DB::connection('mysql6')->table('leave_balance')->where(['employeeid'=>$subordinateid,'month' => $applied_month,'year' => $applied_year])->get()->toArray();

                    if (count($formarr) > 0) {
                        foreach ($formarr as $key => $value) {
                            $arr = (array) $value;    
                        }
                        if ($arr['Onduty'] == null) { $arr['Onduty'] = ''; }
                        if ($arr['Tour'] == null) { $arr['Tour'] = ''; }
                        if ($arr['Compoff'] == null) { $arr['Compoff'] = ''; }
                        if ($arr['Mispunch'] == null) { $arr['Mispunch'] = ''; }
                        if ($arr['Onduty'] == null) { $arr['Onduty'] = ''; }
                        $this->updateleave_balance($arr);
                        // DB::connection('mysql6')->table('send_sap_leave_details')->insert(
                        //     ['details' => json_encode($arr), 'created_datetime' => Carbon::now()->toDateTimeString()]
                        // );
                    }
                }
                
                if (($current_month < $applied_month)) {
                    $getbalance = DB::connection('mysql6')->table('leave_balance')->where(['employeeid'=>$subordinateid,'month' => $applied_month,'year' => $applied_year])
                    ->get();
                    
                    foreach ($getbalance as $key33 => $value33) {
                        $balance = $value33->$type;
                    }
                    if (($type == 'CL') || ($type == 'SL') || ($type == 'PL') || ($type == 'ML') || ($type == 'RH') || ($type == 'Permission')) {
                        $toupdate = $balance + $count;
                    }
                    else{
                        $toupdate = $balance - $count;
                    }
                    DB::connection('mysql6')->table('leave_balance')->where(['employeeid'=>$subordinateid,'month' => $current_month,'year' => $current_year])
                    ->update([
                        $type => $toupdate
                    ]);

                    $formarr = DB::connection('mysql6')->table('leave_balance')->where(['employeeid'=>$subordinateid,'month' => $current_month,'year' => $current_year])->get();

                    if (count($formarr) > 0) {
                        $arr = (array)$formarr;
                        if ($arr['Onduty'] == null) { $arr['Onduty'] = ''; }
                        if ($arr['Tour'] == null) { $arr['Tour'] = ''; }
                        if ($arr['Compoff'] == null) { $arr['Compoff'] = ''; }
                        if ($arr['Mispunch'] == null) { $arr['Mispunch'] = ''; }
                        if ($arr['Onduty'] == null) { $arr['Onduty'] = ''; }
                        $this->updateleave_balance($arr);
                        // DB::connection('mysql6')->table('send_sap_leave_details')->insert(
                        //     ['details' => json_encode($arr), 'created_datetime' => Carbon::now()->toDateTimeString()]
                        // );
                    }
                }

            }
/*old with admin approval
            $randomno1 = rand(1, 5000);
            $toencrypt1 = $subordinateid.'-#admin#-'.$randomno1;
            $adminencrypt = Crypt::encrypt($toencrypt1);

            $get_lms_mailqueue_table = DB::connection('mysql6')->table('lms_mail_queue')->where(['reference_id'=>$id, 'processed' => '0'])->get();

            if (count($get_lms_mailqueue_table) > 0) {
                DB::connection('mysql6')->table('lms_mail_queue')
                ->where(['reference_id'=>$id])
                ->update([
                    'admin_session_key' => $adminencrypt,
                    'hod_session_key' => null
                ]);
            }

     end of old admin approval   */

     /** new only hod approval */
     $get_lms_mailqueue_table = DB::connection('mysql6')->table('lms_mail_queue')->where(['reference_id'=>$id, 'processed' => '0'])->get();

            if (count($get_lms_mailqueue_table) > 0) {
                DB::connection('mysql6')->table('lms_mail_queue')
                ->where(['reference_id'=>$id])
                ->update([
                    'sent_to_hod' => Carbon::now()->toDateTimeString(),
                    'admin_session_key' => null,
                    'hod_session_key' => null,
                    'sent_to_admin' => Carbon::now()->toDateTimeString()
                ]);
            }

     /** new only hod approval */
            dd('Application Rejected!');
        }else{
            //return redirect()->route('newemployee_home');
            dd('Application Already Approved or rejected!');
        }

            }
            else{
                //return redirect()->route('newemployee_home');
                dd('Application Already Approved or rejected!');
            }
            

           
            

    }

    public function adminleaveoperation($admin_status, $hashedkey)
    {
        //start
        $check = DB::connection('mysql6')->table('lms_mail_queue')->where(['admin_session_key' => $hashedkey])->count();
        if ($check == '1') {
            $check1 = DB::connection('mysql6')->table('lms_mail_queue')->where(['admin_session_key' => $hashedkey])->get();
            foreach ($check1 as $key => $value) {
                $ref_id = $value->reference_id;
            }
            if ($admin_status == 'approve') {
            $getlms_application = DB::connection('mysql6')->table('leave_processed')->where(['id'=>$ref_id, 'admin_status' => 'Pending'])->get();
                
            if (count($getlms_application) > 0) {
                foreach ($getlms_application as $key1 => $value1) {
                    $subordinateid = $value1->employeeid;
                }

                $newar = [];
                $newar['employeeid'] = $subordinateid;

                foreach ($getlms_application as $key26 => $value26) {
                    $sap_fromdate = $value26->stdate;
                    $sap_todate = $value26->etdate;
                    $sap_no_of_days = $value26->no_of_days;
                    $sap_partial_days = $value26->partial_days;
                    $sap_leave_type = $value26->type;
                }
                

                if ($sap_partial_days == 'full') {
                
                    $newar['from_date'] = substr($sap_fromdate,0,10);
                    $newar['to_date'] = substr($sap_todate,0,10);
                    $newar['starttime'] = '';
                    $newar['endtime'] = '';

                }
                elseif($sap_partial_days == 'first_half'){
                    $newar['from_date'] = substr($sap_fromdate,0,10);
                    $newar['to_date'] = substr($sap_todate,0,10);
                    $newar['starttime'] = substr($sap_fromdate,11,5);
                    $newar['endtime'] = substr($sap_todate,11,5);

                }
                elseif($sap_partial_days == 'second_half'){
                    $newar['from_date'] = substr($sap_fromdate,0,10);
                    $newar['to_date'] = substr($sap_todate,0,10);
                    $newar['starttime'] = substr($sap_fromdate,11,5);
                    $newar['endtime'] = substr($sap_todate,11,5);

                }else{
                    //sd
                }
                $newar['leave_type'] = $sap_leave_type;
                /*if ($sap_leave_type == 'Permission') {
                    $newar['leave_type'] = 'Onduty';    
                }
                else{
                    $newar['leave_type'] = $sap_leave_type;
                }*/
                
                

               //$this->insert_applicationtosapfinal($newar);
               DB::connection('mysql6')->table('send_sap_leave_details')->insert(['details' => json_encode($newar), 'created_datetime' => Carbon::now()->toDateTimeString()]);
                
                DB::connection('mysql6')->table('leave_processed')
                ->where(['id'=>$ref_id,'employeeid' => $subordinateid, 'admin_status' => 'Pending'])
                ->update([
                    'admin_status' => 'Approved',
                    'admin_reason' => null,
                    'final_Status' => 'Approved',
                    'admin_created_date' => Carbon::now()->toDateTimeString()
                ]);
            

            $randomno1 = rand(1, 5000);
            $toencrypt1 = $subordinateid.'-#admin#-'.$randomno1;
            $adminencrypt = Crypt::encrypt($toencrypt1);

            $get_lms_mailqueue_table = DB::connection('mysql6')->table('lms_mail_queue')->where(['reference_id'=>$ref_id, 'processed' => '0'])->get();

            if (count($get_lms_mailqueue_table) > 0) {
                DB::connection('mysql6')->table('lms_mail_queue')
                ->where(['reference_id'=>$ref_id])
                ->update([
                    'admin_session_key' => null,
                    'hod_session_key' => null
                ]);
            }

            $get_date_diff = DB::connection('mysql6')->table('datetime_ref')->where(['reference_id'=>$ref_id,'final_status' => 'Pending'])->get();
            if (count($get_date_diff) > 0) {

                DB::connection('mysql6')->table('datetime_ref')
                ->where(['reference_id'=>$ref_id,'employeeid' => $subordinateid, 'final_status' => 'Pending'])
                ->update([
                    'final_status' => 'Approved'
                ]);

                $count = 0;
                $current_month = Carbon::now()->format('m');
                $current_year = Carbon::now()->format('Y');

                foreach ($get_date_diff as $key22 => $value22) {
                    $applied_month = $value22->applied_month;
                    $applied_year = $value22->applied_year;
                    $type = $value22->type;
                    $application_month = $value22->month;
                    $application_year = $value22->year;
                }

                if (($current_month == $applied_month) || ($current_month > $applied_month)) {
                    $getbalance = DB::connection('mysql6')->table('leave_balance')->where(['employeeid'=>$subordinateid,'month' => $applied_month,'year' => $applied_year])
                    ->get();
                    
                    $formarr = DB::connection('mysql6')->table('leave_balance')->where(['employeeid'=>$subordinateid,'month' => $applied_month,'year' => $applied_year])->get()->toArray();
                    
                    if (count($formarr) > 0) {
                        foreach ($formarr as $key => $value) {
                            $arr = (array) $value;    
                        }
                        if ($arr['Onduty'] == null) { $arr['Onduty'] = ''; }
                        if ($arr['Tour'] == null) { $arr['Tour'] = ''; }
                        if ($arr['Compoff'] == null) { $arr['Compoff'] = ''; }
                        if ($arr['Mispunch'] == null) { $arr['Mispunch'] = ''; }
                        if ($arr['Onduty'] == null) { $arr['Onduty'] = ''; }
                        $this->updateleave_balance($arr);
                        // DB::connection('mysql6')->table('send_sap_leave_details')->insert(
                        //     ['details' => json_encode($arr), 'created_datetime' => Carbon::now()->toDateTimeString()]
                        // );
                    }

                }
                
                if (($current_month < $applied_month)) {
                                        
                    $formarr = DB::connection('mysql6')->table('leave_balance')->where(['employeeid'=>$subordinateid,'month' => $current_month,'year' => $current_year])
                    ->get()->toArray();

                    if (count($formarr) > 0) {
                        foreach ($formarr as $key => $value) {
                            $arr = (array) $value;    
                        }
                        if ($arr['Onduty'] == null) { $arr['Onduty'] = ''; }
                        if ($arr['Tour'] == null) { $arr['Tour'] = ''; }
                        if ($arr['Compoff'] == null) { $arr['Compoff'] = ''; }
                        if ($arr['Mispunch'] == null) { $arr['Mispunch'] = ''; }
                        if ($arr['Onduty'] == null) { $arr['Onduty'] = ''; }
                        $this->updateleave_balance($arr);
                        // DB::connection('mysql6')->table('send_sap_leave_details')->insert(
                        //     ['details' => json_encode($arr), 'created_datetime' => Carbon::now()->toDateTimeString()]
                        // );
                    }
                }
            }
        }
            dd('Application Approved!');
            }
            else{
                $getdata = DB::connection('mysql6')->table('leave_processed')->where(['id' => $ref_id])->get();
            return view('newemployeezone.lms.admin_operation')->with(['getdata'=>$getdata, 'hashedkey' => $hashedkey, 'admin_status' => $admin_status]);
            }
            
        }else{
            return redirect()->route('newemployee_home');
        }
        //end
    }


    public function postadminleaveoperation(Request $request)
    {
        $validate = $this->validate($request, [
            'admin_reason' => 'required|min:4|max:200',
            ]);

            $path = $request->getPathInfo();
            $arr = explode('/', $path);
            
            $check = DB::connection('mysql6')->table('lms_mail_queue')->where(['admin_session_key' => $arr[5]])->get();
            if (count($check) > 0) {
                foreach ($check as $key => $value) {
                    $id = $value->reference_id;
                }
                $getlms_application = DB::connection('mysql6')->table('leave_processed')->where(['id'=>$id, 'admin_status' => 'Pending'])->get();
                
            if (count($getlms_application) > 0) {
                foreach ($getlms_application as $key1 => $value1) {
                    $subordinateid = $value1->employeeid;
                }

                
                DB::connection('mysql6')->table('leave_processed')
                ->where(['id'=>$id,'employeeid' => $subordinateid, 'admin_status' => 'Pending'])
                ->update([
                    'admin_status' => 'Rejected',
                    'final_status' => 'Rejected',
                    'admin_reason' => $request->admin_reason,
                    'admin_created_date' => Carbon::now()->toDateTimeString(),
                ]);
            

            $get_date_diff = DB::connection('mysql6')->table('datetime_ref')->where(['reference_id'=>$id,'final_status' => 'Pending'])->get();
            if (count($get_date_diff) > 0) {

                DB::connection('mysql6')->table('datetime_ref')
                ->where(['reference_id'=>$id,'employeeid' => $subordinateid, 'final_status' => 'Pending'])
                ->update([
                    'final_status' => 'Rejected'
                ]);

                $count = 0;
                $current_month = Carbon::now()->format('m');
                $current_year = Carbon::now()->format('Y');

                foreach ($get_date_diff as $key22 => $value22) {
                    $applied_month = $value22->applied_month;
                    $applied_year = $value22->applied_year;
                    $type = $value22->type;
                    $application_month = $value22->month;
                    $application_year = $value22->year;
                    $application_partial_days = $value22->partial_days;
                    
                    if (($type == 'Permission') || ($type == 'Mispunch')) {
                        $count = $count + 1;
                    }
                    else{
                    if ($application_partial_days == 'full') {
                        $count = $count + 1;
                    }
                    else {
                        $count = $count + 0.5;
                    }

                    }
                }

                
                        
                if (($current_month == $applied_month) || ($current_month > $applied_month)) {
                    $getbalance = DB::connection('mysql6')->table('leave_balance')->where(['employeeid'=>$subordinateid,'month' => $applied_month,'year' => $applied_year])
                    ->get();
                    foreach ($getbalance as $key33 => $value33) {
                        $balance = $value33->$type;
                    }
                    if (($type == 'CL') || ($type == 'SL') || ($type == 'PL') || ($type == 'ML') || ($type == 'RH') || ($type == 'Permission')) {
                        $toupdate = $balance + $count;
                    }
                    else{
                        $toupdate = $balance - $count;
                    }
                    DB::connection('mysql6')->table('leave_balance')->where(['employeeid'=>$subordinateid,'month' => $applied_month,'year' => $applied_year])
                    ->update([
                        $type => $toupdate
                    ]);

                    $formarr = DB::connection('mysql6')->table('leave_balance')->where(['employeeid'=>$subordinateid,'month' => $applied_month,'year' => $applied_year])->get()->toArray();

                    if (count($formarr) > 0) {
                        foreach ($formarr as $key => $value) {
                            $arr = (array) $value;    
                        }
                        if ($arr['Onduty'] == null) { $arr['Onduty'] = ''; }
                        if ($arr['Tour'] == null) { $arr['Tour'] = ''; }
                        if ($arr['Compoff'] == null) { $arr['Compoff'] = ''; }
                        if ($arr['Mispunch'] == null) { $arr['Mispunch'] = ''; }
                        if ($arr['Onduty'] == null) { $arr['Onduty'] = ''; }
                        $this->updateleave_balance($arr);
                        // DB::connection('mysql6')->table('send_sap_leave_details')->insert(
                        //     ['details' => json_encode($arr), 'created_datetime' => Carbon::now()->toDateTimeString()]
                        // );
                    }
                }
                
                if (($current_month < $applied_month)) {
                    $getbalance = DB::connection('mysql6')->table('leave_balance')->where(['employeeid'=>$subordinateid,'month' => $applied_month,'year' => $applied_year])
                    ->get();
                    
                    foreach ($getbalance as $key33 => $value33) {
                        $balance = $value33->$type;
                    }
                    if (($type == 'CL') || ($type == 'SL') || ($type == 'PL') || ($type == 'ML') || ($type == 'RH') || ($type == 'Permission')) {
                        $toupdate = $balance + $count;
                    }
                    else{
                        $toupdate = $balance - $count;
                    }
                    DB::connection('mysql6')->table('leave_balance')->where(['employeeid'=>$subordinateid,'month' => $current_month,'year' => $current_year])
                    ->update([
                        $type => $toupdate
                    ]);

                    $formarr = DB::connection('mysql6')->table('leave_balance')->where(['employeeid'=>$subordinateid,'month' => $current_month,'year' => $current_year])->get()->toArray();

                    if (count($formarr) > 0) {
                        foreach ($formarr as $key => $value) {
                            $arr = (array) $value;    
                        }
                        if ($arr['Onduty'] == null) { $arr['Onduty'] = ''; }
                        if ($arr['Tour'] == null) { $arr['Tour'] = ''; }
                        if ($arr['Compoff'] == null) { $arr['Compoff'] = ''; }
                        if ($arr['Mispunch'] == null) { $arr['Mispunch'] = ''; }
                        if ($arr['Onduty'] == null) { $arr['Onduty'] = ''; }
                        $this->updateleave_balance($arr);
                        // DB::connection('mysql6')->table('send_sap_leave_details')->insert(
                        //     ['details' => json_encode($arr), 'created_datetime' => Carbon::now()->toDateTimeString()]
                        // );
                    }
                }

            }

           
            $get_lms_mailqueue_table = DB::connection('mysql6')->table('lms_mail_queue')->where(['reference_id'=>$id, 'processed' => '0'])->get();

            if (count($get_lms_mailqueue_table) > 0) {
                DB::connection('mysql6')->table('lms_mail_queue')
                ->where(['reference_id'=>$id])
                ->update([
                    'admin_session_key' => null,
                    'hod_session_key' => null,
                ]);
            }
            dd('Application Rejected!');
        }else{
            return redirect()->route('newemployee_home');
        }

            }
            else{
                return redirect()->route('newemployee_home');
            }
            

    }


 public function auto_rejection_script()
 {
    $current_datetime = Carbon::now()->toDateTimeString(); 
    $get_validity_exceeded_pending_applications = DB::connection('mysql6')->table('leave_processed')->where(['final_status'=>'Pending'])->where('valid_till', '<', $current_datetime)->get();

    $application = [];
    if (count($get_validity_exceeded_pending_applications) > 0) {
        foreach ($get_validity_exceeded_pending_applications as $key => $value) {
            $application[] = (array)$value;
        }
       
        
        foreach ($application as $key1 => $value1) {
            $id = $value1['id'];
            
            if (($value1['hod_status'] == 'Pending') && ($value1['admin_status'] == 'Pending')) {
                $getmail = DB::connection('mysql6')->table('lms_mail_queue')->where(['reference_id'=>$id])->where('hod_session_key', '!=', null)->get();
                foreach ($getmail as $key2 => $value2) {
                    $hod_sesssion_key = $value2->hod_session_key;
                }

                
                $check = DB::connection('mysql6')->table('lms_mail_queue')->where(['hod_session_key' => $hod_sesssion_key])->get();
            if (count($check) > 0) {
                foreach ($check as $key => $value) {
                    $id = $value->reference_id;
                }
                $getlms_application = DB::connection('mysql6')->table('leave_processed')->where(['id'=>$id, 'hod_status' => 'Pending'])->get();
                
            if (count($getlms_application) > 0) {
                foreach ($getlms_application as $key1 => $value1) {
                    $subordinateid = $value1->employeeid;
                }

                
                DB::connection('mysql6')->table('leave_processed')
                ->where(['id'=>$id,'employeeid' => $subordinateid, 'hod_status' => 'Pending'])
                ->update([
                    'hod_status' => 'Rejected',
                    'hod_reason' => 'This is system generated rejection. Application Approval validity exceeded by HOD.',
                    'admin_status' => 'Rejected',
                    'final_status' => 'Rejected',
                    'admin_reason' => null,
                    'hod_created_date' => Carbon::now()->toDateTimeString(),
                ]);
            

            $get_date_diff = DB::connection('mysql6')->table('datetime_ref')->where(['reference_id'=>$id,'final_status' => 'Pending'])->get();
            if (count($get_date_diff) > 0) {

                DB::connection('mysql6')->table('datetime_ref')
                ->where(['reference_id'=>$id,'employeeid' => $subordinateid, 'final_status' => 'Pending'])
                ->update([
                    'final_status' => 'Rejected'
                ]);

                $count = 0;
                $current_month = Carbon::now()->format('m');
                $current_year = Carbon::now()->format('Y');

                foreach ($get_date_diff as $key22 => $value22) {
                    $applied_month = $value22->applied_month;
                    $applied_year = $value22->applied_year;
                    $type = $value22->type;
                    $application_month = $value22->month;
                    $application_year = $value22->year;
                    $application_partial_days = $value22->partial_days;
                    
                    if (($type == 'Permission') || ($type == 'Mispunch')) {
                        $count = $count + 1;
                    }
                    else{
                    if ($application_partial_days == 'full') {
                        $count = $count + 1;
                    }
                    else {
                        $count = $count + 0.5;
                    }

                    }
                }

                
                        
                if (($current_month == $applied_month) || ($current_month > $applied_month)) {
                    $getbalance = DB::connection('mysql6')->table('leave_balance')->where(['employeeid'=>$subordinateid,'month' => $applied_month,'year' => $applied_year])
                    ->get();
                    foreach ($getbalance as $key33 => $value33) {
                        $balance = $value33->$type;
                    }
                    if (($type == 'CL') || ($type == 'SL') || ($type == 'PL') || ($type == 'ML') || ($type == 'RH') || ($type == 'Permission')) {
                        $toupdate = $balance + $count;
                    }
                    else{
                        $toupdate = $balance - $count;
                    }
                    DB::connection('mysql6')->table('leave_balance')->where(['employeeid'=>$subordinateid,'month' => $applied_month,'year' => $applied_year])
                    ->update([
                        $type => $toupdate
                    ]);
                }
                
                if (($current_month < $applied_month)) {
                    $getbalance = DB::connection('mysql6')->table('leave_balance')->where(['employeeid'=>$subordinateid,'month' => $applied_month,'year' => $applied_year])
                    ->get();
                    
                    foreach ($getbalance as $key33 => $value33) {
                        $balance = $value33->$type;
                    }
                    if (($type == 'CL') || ($type == 'SL') || ($type == 'PL') || ($type == 'ML') || ($type == 'RH') || ($type == 'Permission')) {
                        $toupdate = $balance + $count;
                    }
                    else{
                        $toupdate = $balance - $count;
                    }
                    DB::connection('mysql6')->table('leave_balance')->where(['employeeid'=>$subordinateid,'month' => $current_month,'year' => $current_year])
                    ->update([
                        $type => $toupdate
                    ]);
                }

            }

            /*old for admin approval

            $randomno1 = rand(1, 5000);
            $toencrypt1 = $subordinateid.'-#admin#-'.$randomno1;
            $adminencrypt = Crypt::encrypt($toencrypt1);

            $get_lms_mailqueue_table = DB::connection('mysql6')->table('lms_mail_queue')->where(['reference_id'=>$id, 'processed' => '0'])->get();

            if (count($get_lms_mailqueue_table) > 0) {
                DB::connection('mysql6')->table('lms_mail_queue')
                ->where(['reference_id'=>$id])
                ->update([
                    'admin_session_key' => $adminencrypt,
                    'hod_session_key' => null
                ]);
            }
            
            old for admin approval */

            $get_lms_mailqueue_table = DB::connection('mysql6')->table('lms_mail_queue')->where(['reference_id'=>$id, 'processed' => '0'])->get();

            if (count($get_lms_mailqueue_table) > 0) {
                DB::connection('mysql6')->table('lms_mail_queue')
                ->where(['reference_id'=>$id])
                ->update([
                    'admin_session_key' => null,
                    'hod_session_key' => null,
                    'sent_to_admin' => Carbon::now()->toDateTimeString()
                ]);
            }

        }
                
                
                
            }
        }
         /*old for admin approval
        if (($value1['admin_status'] == 'Pending') && ($value1['hod_status'] == 'Approved')) {

            $getmail = DB::connection('mysql6')->table('lms_mail_queue')->where(['reference_id'=>$id])->where('admin_session_key', '!=', null)->get();
                foreach ($getmail as $key2 => $value2) {
                    $admin_sesssion_key = $value2->admin_session_key;
                }
            $check = DB::connection('mysql6')->table('lms_mail_queue')->where(['admin_session_key' => $admin_sesssion_key])->get();
            if (count($check) > 0) {
                foreach ($check as $key => $value) {
                    $id = $value->reference_id;
                }
                $getlms_application = DB::connection('mysql6')->table('leave_processed')->where(['id'=>$id, 'admin_status' => 'Pending'])->get();
                
            if (count($getlms_application) > 0) {
                foreach ($getlms_application as $key1 => $value1) {
                    $subordinateid = $value1->employeeid;
                }

                
                DB::connection('mysql6')->table('leave_processed')
                ->where(['id'=>$id,'employeeid' => $subordinateid, 'admin_status' => 'Pending'])
                ->update([
                    'admin_status' => 'Rejected',
                    'final_status' => 'Rejected',
                    'admin_reason' => 'This is system generated rejection. Application Approval validity exceeded by Admin.',
                    'admin_created_date' => Carbon::now()->toDateTimeString(),
                ]);
            

            $get_date_diff = DB::connection('mysql6')->table('datetime_ref')->where(['reference_id'=>$id,'final_status' => 'Pending'])->get();
            if (count($get_date_diff) > 0) {

                DB::connection('mysql6')->table('datetime_ref')
                ->where(['reference_id'=>$id,'employeeid' => $subordinateid, 'final_status' => 'Pending'])
                ->update([
                    'final_status' => 'Rejected'
                ]);

                $count = 0;
                $current_month = Carbon::now()->format('m');
                $current_year = Carbon::now()->format('Y');

                foreach ($get_date_diff as $key22 => $value22) {
                    $applied_month = $value22->applied_month;
                    $applied_year = $value22->applied_year;
                    $type = $value22->type;
                    $application_month = $value22->month;
                    $application_year = $value22->year;
                    $application_partial_days = $value22->partial_days;
                    
                    if (($type == 'Permission') || ($type == 'Mispunch')) {
                        $count = $count + 1;
                    }
                    else{
                    if ($application_partial_days == 'full') {
                        $count = $count + 1;
                    }
                    else {
                        $count = $count + 0.5;
                    }

                    }
                }

                
                        
                if (($current_month == $applied_month) || ($current_month > $applied_month)) {
                    $getbalance = DB::connection('mysql6')->table('leave_balance')->where(['employeeid'=>$subordinateid,'month' => $applied_month,'year' => $applied_year])
                    ->get();
                    foreach ($getbalance as $key33 => $value33) {
                        $balance = $value33->$type;
                    }
                    if (($type == 'CL') || ($type == 'SL') || ($type == 'PL') || ($type == 'ML') || ($type == 'RH') || ($type == 'Permission')) {
                        $toupdate = $balance + $count;
                    }
                    else{
                        $toupdate = $balance - $count;
                    }
                    DB::connection('mysql6')->table('leave_balance')->where(['employeeid'=>$subordinateid,'month' => $applied_month,'year' => $applied_year])
                    ->update([
                        $type => $toupdate
                    ]);
                }
                
                if (($current_month < $applied_month)) {
                    $getbalance = DB::connection('mysql6')->table('leave_balance')->where(['employeeid'=>$subordinateid,'month' => $applied_month,'year' => $applied_year])
                    ->get();
                    
                    foreach ($getbalance as $key33 => $value33) {
                        $balance = $value33->$type;
                    }
                    if (($type == 'CL') || ($type == 'SL') || ($type == 'PL') || ($type == 'ML') || ($type == 'RH') || ($type == 'Permission')) {
                        $toupdate = $balance + $count;
                    }
                    else{
                        $toupdate = $balance - $count;
                    }
                    DB::connection('mysql6')->table('leave_balance')->where(['employeeid'=>$subordinateid,'month' => $current_month,'year' => $current_year])
                    ->update([
                        $type => $toupdate
                    ]);
                }

            }

           
            $get_lms_mailqueue_table = DB::connection('mysql6')->table('lms_mail_queue')->where(['reference_id'=>$id, 'processed' => '0'])->get();

            if (count($get_lms_mailqueue_table) > 0) {
                DB::connection('mysql6')->table('lms_mail_queue')
                ->where(['reference_id'=>$id])
                ->update([
                    'admin_session_key' => null,
                    'hod_session_key' => null,
                ]);
            }
            
        }else{
            return redirect()->route('newemployee_home');
        }

            }
        }
         old for admin approval */
    }


 }
}

public function getsubordinatepunches(Request $request)
{
    if ($request->session()->has('employeesession')) {
        $encrypt = $request->session()->get('employeesession');
        $decrypt = Crypt::decrypt($encrypt);
        $split = explode("-",$decrypt);
        $employeeid = $split[0];
    $daterange = $request->daterange;
    $employeeid = $request->employeeid;

    $splitrange = explode('-',$daterange);
    $startdate = $this->dateformatreturnddmmyytoyymmdd(trim($splitrange[0]));
    $enddate = $this->dateformatreturnddmmyytoyymmdd(trim($splitrange[1]));

    $getpunches = $this->getpunches($employeeid, Carbon::parse($startdate)->toDateString(), Carbon::parse($enddate)->toDateString());   

    $getemployee_details = $this->getemployee($employeeid);
    $empname = $getemployee_details['First_Name'].' '.$getemployee_details['Last_Name'];


    $res = [];                    
        $res['punchlist'] = [];
        $punches = [];
        if(!empty($getpunches)){
            if(array_key_exists('0', $getpunches['Sorted_Punches'])){
                $punches = $getpunches['Sorted_Punches'];
            }
            else{
                if ($getpunches['Sorted_Punches']['Emp_ID'] != '') {
                    $punches[] = $getpunches['Sorted_Punches'];    
                }else{
                    $punches = $getpunches['Sorted_Punches'];
                }
            }
            
            if(array_key_exists('0', $punches)){                                           
                
                $newarr = [];
                $i = 0;
                foreach ($punches as $key => $value) {
                    
                            $newarr[$i]['key'] = $value['Date'].' '.$value['Time'];
                        $newarr[$i]['val_name'] = Carbon::parse($value['Date'].' '.$value['Time'])->format('d, M Y h:i:s A');
                        $terminal = DB::connection('mysql6')->table('terminal_details')->where('terminal_id',$value['Terminal_ID'] )->get(); 
                        foreach ($terminal as $key => $value) {
                            $terminal_name = $value->terminal_name;
                        }
                        $newarr[$i]['terminal_name'] = $terminal_name;
                        $newarr[$i]['empid'] = $employeeid;
                        $newarr[$i]['empname'] = $empname;
                        
                        $i = $i+1;
                   
                    
                }
                
                return response()
            ->json(['punches' => $newarr], 200);
            }else{
                return response()
            ->json(['punches'=> [] ], 200);
            }
            
        }else{
            return response()
            ->json(['punches'=> [] ], 200);
        }
        
    }
    else{
        return response()
            ->json(['punches'=> [] ], 401);
    }

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

public function viewemployee_punches(Request $request)
{
    if ($request->session()->has('employeesession')) {
        $encrypt = $request->session()->get('employeesession');
        $decrypt = Crypt::decrypt($encrypt);
        $split = explode("-",$decrypt);
        $employeeid = $split[0];
        $mydetails = [];
        $getemployeedata = DB::connection('mysql6')->table('employee')->where('id', '=', $employeeid)->get();

        

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


        $getactiveemployees = $this->getallactiveemployees();
        
        $getsubordinates = [];
        $forpunchlist = [];

        if (count($getactiveemployees) > 0) {
            $i=0;
            $j = 0;
            foreach ($getactiveemployees['Details'] as $key => $value) {
                
                if($value['RM_ID'] == $employeeid){
                    $getsubordinates[$i]['empid'] = $value['Emp_ID'];
                    $getsubordinates[$i]['empname'] = $value['Emp_Name'];

                    $forpunchlist[$j]['empid'] = $value['Emp_ID'];
                    $forpunchlist[$j]['empname'] = $value['Emp_Name'];
                    $i += 1;
                    $j += 1;
                }

                if($value['Emp_ID'] == $employeeid){
                    $forpunchlist[$j]['empid'] = $value['Emp_ID'];
                    $forpunchlist[$j]['empname'] = $value['Emp_Name'];
                    $j += 1;
                }
            }    
        }
        

        return view('newemployeezone.lms.employee_punches')->with(['getemployeedata'=>$getemployeedata,'forpunchlist' => $forpunchlist,'profilepic'=>$profilepic, 'employeeid' => $employeeid]);

    }

    return view('newemployeezone.login');
}

public function daily_latescript()
{
    $check_late_is_processing = DB::connection('mysql6')->table('lmsscript_processing')->where('late', '=', 1)->count();
    if ($check_late_is_processing == 0) {
    $check_late_is_processing = DB::connection('mysql6')->table('lmsscript_processing')->where('late', '=', 0)->update(['late' => 1]);
    $shiftdetails = $this->shiftdetails();
    $carbonnow = Carbon::now()->toDateTimeString();
    //dd($shiftdetails);
    foreach ($shiftdetails['Shift_Details'] as $key => $value) {
        $starttime = Carbon::now()->toDateString().' '.$value['Start_Time'];
        $add120minutes = Carbon::parse($starttime)->addMinutes(420)->toDateTimeString();
        //$add120minutes = '2018-07-03 13:00:00';
        //dd($add120minutes);
        if (Carbon::parse($carbonnow)->gt(Carbon::parse($starttime)) && Carbon::parse($carbonnow)->lt(Carbon::parse($add120minutes))) {
            
                echo 'Late process start....';
                $active_emp = $this->getallactiveemployees();
                dd($active_emp);
                
                foreach ($active_emp['Details'] as $key1 => $value1) {
                    $getshiftdetails = $this->getshiftdetailsst_et_date($value1['Emp_ID'], Carbon::parse($starttime)->toDateString(), Carbon::parse($starttime)->toDateString());
                    foreach ($getshiftdetails['Shift_Details'] as $key3 => $value3) {
                        $getemployee = $this->getemployee($value1['Emp_ID']);
                        
                    }
                }
                echo '<br> Late process finished...';
            

        }
    }
        }
        else{
            echo 'Late process running...';
        }

}

public function updateemployeesfromsap()
{
    $select_employee_db = DB::connection('mysql6')->table('sap_update_employee')->count();
    //dd($select_employee_db);
    if ($select_employee_db == 0) {
        $active_emp = $this->getallactiveemployees();
        foreach ($active_emp['Details'] as $key => $value) {
            $insert = DB::connection('mysql6')->table('sap_update_employee')->insert([
                'id' => $value['Emp_ID'], 'title' => '',
                'name' => $value['Emp_Name'],
                'sap_id' => '',
                'gender' => '',
                'birthdate' => '',
                'maritalstatus' => '',
                'noofchildren' => '',
                'nationality' => '',
                'bloodgroup' => '',
                'personalmail' => '',
                'officialmail' => '',
                'personal_mobile' => '', 
                'bank_name' => '', 
                'bank_acnt_no' => '', 
                'panno' => '', 
                'pf_no' => '', 
                'esi_no' => '', 
                'doj' => '', 
                'company_name' => '', 
                'plantid' => '', 
                'plant_name' => '', 
                'department' => '', 
                'position' => '', 
                'created_date' => Carbon::now()->toDateTimeString(), 
                'reporting_manager' => '', 
                'shift_name' => '', 
                'shift_timings_in' => '', 
                'shift_timings_out' => '', 
                'role_code' => '', 
                'role_name' => '', 
                'cadre' => '', 
                'saleorder' => '',
                'processed' => 0
            ]);
        }
    }
    else{
        $select_employee = DB::connection('mysql6')->table('sap_update_employee')->where(['processed' => 0])->take(50)->get();
        if (count($select_employee) > 0) {
            foreach ($select_employee as $key => $value) {
                $employeeid = $value->id;
            
            $getemployee_details = $this->getemployee($employeeid);
            
            $update = DB::connection('mysql6')->table('sap_update_employee')->where(['id' => $employeeid])->update([
                'title' => $getemployee_details['Title'],
                'name' => $getemployee_details['First_Name'].' '.$getemployee_details['Last_Name'],
                'sap_id' => $getemployee_details['SAP_ID'],
                'gender' => $getemployee_details['Gender'],
                'birthdate' => substr($getemployee_details['Birth_Date'],0,4).'-'.substr($getemployee_details['Birth_Date'],4,2).'-'.substr($getemployee_details['Birth_Date'],6,2),
                'maritalstatus' => $getemployee_details['Marital_Status'],
                'noofchildren' => $getemployee_details['No_of_Childrens'],
                'nationality' => $getemployee_details['Nationality'],
                'bloodgroup' => $getemployee_details['Blood_Group'],
                'personalmail' => $getemployee_details['Personal_Email'],
                'officialmail' => $getemployee_details['Office_Email'],
                'personal_mobile' => $getemployee_details['Personal_Mobile'], 
                'bank_name' => $getemployee_details['Bank_Name'], 
                'bank_acnt_no' => $getemployee_details['Bank_Account_No'], 
                'panno' => $getemployee_details['PAN_No'], 
                'pf_no' => $getemployee_details['PF_No'], 
                'esi_no' => $getemployee_details['ESI_No'], 
                'doj' => substr($getemployee_details['Date_of_Joining'],0,4).'-'.substr($getemployee_details['Date_of_Joining'],4,2).'-'.substr($getemployee_details['Date_of_Joining'],6,2),
                'company_name' => $getemployee_details['Company_Name'], 
                'plantid' => $getemployee_details['Plant_ID'], 
                'plant_name' => $getemployee_details['Plant_Name'], 
                'department' => $getemployee_details['Department'], 
                'position' => $getemployee_details['Position'], 
                'created_date' => Carbon::now()->toDateTimeString(), 
                'reporting_manager' => $getemployee_details['Reporting_Manager'], 
                'shift_name' => $getemployee_details['Shift_Name'], 
                'shift_timings_in' => $getemployee_details['Shift_Timings_IN'], 
                'shift_timings_out' => $getemployee_details['Shift_Timings_OUT'], 
                'role_code' => $getemployee_details['Role_Code'], 
                'role_name' => $getemployee_details['Role_Name'], 
                'cadre' => $getemployee_details['Cadre'], 
                'saleorder' => '',
                'processed' => 1
            ]);
        }
        }
        else{
            dd('process finished');
            //DB::connection('mysql6')->table('sap_update_employee')->delete();
        }

    }
}

public function view_overall_employee_punches(Request $request)
{
    if ($request->session()->has('employeesession')) {
        $encrypt = $request->session()->get('employeesession');
        $decrypt = Crypt::decrypt($encrypt);
        $split = explode("-",$decrypt);
        $employeeid = $split[0];
        $mydetails = [];
        $getemployeedata = DB::connection('mysql6')->table('employee')->where('id', '=', $employeeid)->get();

        

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


        $getactiveemployees = $this->getallactiveemployees();
        
        $getsubordinates = [];
        $forpunchlist = [];

        if (count($getactiveemployees) > 0) {
            $i=0;
            $j = 0;
            foreach ($getactiveemployees['Details'] as $key => $value) {
                    $forpunchlist[$j]['empid'] = $value['Emp_ID'];
                    $forpunchlist[$j]['empname'] = $value['Emp_Name'];
                    $j += 1;
            }    
        }
        

        return view('newemployeezone.lms.employee_punches')->with(['getemployeedata'=>$getemployeedata,'forpunchlist' => $forpunchlist,'profilepic'=>$profilepic, 'employeeid' => $employeeid]);

    }

    return view('newemployeezone.login');
}


public function attendance_sheet(Request $request)
{
    if ($request->session()->has('employeesession')) {
        $encrypt = $request->session()->get('employeesession');
        $decrypt = Crypt::decrypt($encrypt);
        $split = explode("-",$decrypt);
        $employeeid = $split[0];
        $mydetails = [];
        $getemployee = $this->getemployee($employeeid);
        //$getemployee =  DB::connection('mysql6')->table('employee')->where('id',$employeeid )->get();
        $getpunches = $this->getpunches($employeeid, Carbon::now()->startOfMonth()->toDateString(), Carbon::now()->endOfMonth()->toDateString());

         //$punches = $this->getsortedpunches($getpunches);
        $newarr = [];

        foreach ($getpunches['Sorted_Punches'] as $key => $value) {
            $newarr[$value['Date']][] = $value['Time'];
        }
        
        $daterange_array = $this->createDateRange(Carbon::now()->startOfMonth()->toDateString(), Carbon::now()->endOfMonth()->toDateString(), $format = "Y-m-d");               
        
        $finalarr = [];
        $i = 0;
        foreach ($daterange_array as $key => $value) {

        	$finalarr['Attend_Details'][$i]['Date'] = $value;
                    $finalarr['Attend_Details'][$i]['Punch_IN'] = null;
                    $finalarr['Attend_Details'][$i]['Punch_OUT'] = null;
                    $finalarr['Attend_Details'][$i]['Punch_list'] = [];

            foreach ($newarr as $key1 => $value1) {
                if ($value == $key1) {
                    $finalarr['Attend_Details'][$i]['Date'] = $value;
                    $finalarr['Attend_Details'][$i]['Punch_IN'] = $newarr[$value][0];
                    $finalarr['Attend_Details'][$i]['Punch_OUT'] = $newarr[$value][count($value1) - 1];
                    $finalarr['Attend_Details'][$i]['Punch_list'] = $value1;
                }
            }
            $i = $i + 1;
        }
       

        $getshiftdetails = $this->getshiftdetailsst_et_date($employeeid, Carbon::now()->startOfMonth()->toDateString(), Carbon::now()->endOfMonth()->toDateString());
        $shiftdetails = $this->shiftdetails();
        //dd($shiftdetails);
        $finalarr2 = [];
        $j = 0;
        foreach ($getshiftdetails['Shift_Details'] as $key3 => $value3) {
            foreach ($finalarr['Attend_Details'] as $key4 => $value4) {
                if ($value4['Date'] == $value3['Shift_Date']) {

                    
                    $finalarr2['Attend_Details'][$j] = $value4;
                    $finalarr2['Attend_Details'][$j]['Shift_Code'] = $value3['Shift_Code'];
                    $finalarr2['Attend_Details'][$j]['Shift_Start'] = $value3['Start_Time'];
                    $finalarr2['Attend_Details'][$j]['Shift_End'] = $value3['End_Time'];
                    $finalarr2['Attend_Details'][$j]['Cadre'] = $getemployee['Cadre'];
                    foreach ($shiftdetails['Shift_Details'] as $key5 => $value5) {

                        if ($value3['Shift_Code'] == $value5['Shift_Code']) {
                            
                    $finalarr2['Attend_Details'][$j]['Shift_Name'] = $value5['Shift_Description'];        
                        }
                    }

                    $getweekoff_holiday = $this->forattendance_getholidayweekoff($employeeid, $finalarr2['Attend_Details'][$j]['Date'], $finalarr2['Attend_Details'][$j]['Date'], $getemployee['Role_Code']);

                    //start cadre for late check
                    if ($getemployee['Cadre'] == 'O') { $finalarr2['Attend_Details'][$j]['Grace_period'] = 16; }
                    elseif ($getemployee['Cadre'] == 'M') { $finalarr2['Attend_Details'][$j]['Grace_period'] = 31; }
                    else{ $finalarr2['Attend_Details'][$j]['Grace_period'] = 0; }
                    $shiftstarttime = $finalarr2['Attend_Details'][$j]['Date'].' '.$finalarr2['Attend_Details'][$j]['Shift_Start'];

                         $formattedmorninggracetime = Carbon::parse($shiftstarttime)->addMinutes($finalarr2['Attend_Details'][$j]['Grace_period'])->toDateTimeString();
                    $finalarr2['Attend_Details'][$j]['punchin_gracetime'] = $formattedmorninggracetime;
                    $finalarr2['Attend_Details'][$j]['latecount'] = 0;
                    $finalarr2['Attend_Details'][$j]['application'] = null;
                    $finalarr2['Attend_Details'][$j]['partial_days'] = null;
                    $finalarr2['Attend_Details'][$j]['app_start_end_time'] = null;
                    $finalarr2['Attend_Details'][$j]['Present'] = 1;

                    if (($getweekoff_holiday['weekoff_count'] == 0) && ($getweekoff_holiday['holiday_count'] == 0)) {
                    $org_firstpunch = $finalarr2['Attend_Details'][$j]['Date'].' '.$finalarr2['Attend_Details'][$j]['Punch_IN'];

                    /**
                    * get the leaves appplication 
                    */
                    $presentcount = 0;
                    $getapplications =  DB::connection('mysql6')->table('datetime_ref')->where([
                        'employeeid' => $employeeid,
                        'date' => $finalarr2['Attend_Details'][$j]['Date'],
                        'final_status' => 'Approved'
                    ] )->get();

                    if (count($getapplications) > 0) {
                        $finalarr2['Attend_Details'][$j]['application'] = $getapplications[0]->type;
                        $finalarr2['Attend_Details'][$j]['partial_days'] = $getapplications[0]->partial_days;
                        $finalarr2['Attend_Details'][$j]['app_start_end_time'] = $getapplications[0]->start_end_time;
                    }

                    if (($finalarr2['Attend_Details'][$j]['Punch_IN'] == null) && ($finalarr2['Attend_Details'][$j]['application'] == null)) {
                        $finalarr2['Attend_Details'][$j]['Present'] = 0;
                    }
                    elseif (($finalarr2['Attend_Details'][$j]['Punch_IN'] == null) && ($finalarr2['Attend_Details'][$j]['application'] != null)) {
                        
                        if (($finalarr2['Attend_Details'][$j]['partial_days']  == 'first_half') || ($finalarr2['Attend_Details'][$j]['partial_days']  == 'full')) {
                         $finalarr2['Attend_Details'][$j]['latecount'] = 0;                    
                         if ($finalarr2['Attend_Details'][$j]['partial_days']  == 'first_half'){
                                 $presentcount += 0.5;
                             }
                             if ($finalarr2['Attend_Details'][$j]['partial_days']  == 'full'){
                                 $finalarr2['Attend_Details'][$j]['Present'] = 1;
                             }    
                        }
                        elseif ($finalarr2['Attend_Details'][$j]['partial_days']  == 'second_half') {
                            $presentcount += 0.5;
                        }
                        else{

                        }
                        $finalarr2['Attend_Details'][$j]['Present'] = $presentcount;

                    }
                    elseif (($finalarr2['Attend_Details'][$j]['Punch_IN'] != null) && ($finalarr2['Attend_Details'][$j]['application'] == null)) {

                        if (Carbon::parse($org_firstpunch)->gt(Carbon::parse($formattedmorninggracetime))) {
                        //$diffinminutes = Carbon::parse($startdatetime)->diffInSeconds(Carbon::parse($enddatetime));
                        //$minutesdivide = $diffinminutes/2;
                        //$gmate = gmdate('H:i:s', $minutesdivide);
                        $finalarr2['Attend_Details'][$j]['latecount'] = 1;
                    }

                    }
                    else{

                        if (($finalarr2['Attend_Details'][$j]['partial_days']  == 'first_half') || ($finalarr2['Attend_Details'][$j]['partial_days']  == 'full')) {
                         $finalarr2['Attend_Details'][$j]['latecount'] = 0;                    
                         if ($finalarr2['Attend_Details'][$j]['partial_days']  == 'first_half'){
                                 $presentcount += 0.5;
                             }
                             if ($finalarr2['Attend_Details'][$j]['partial_days']  == 'full'){
                                 $finalarr2['Attend_Details'][$j]['Present'] = 1;
                             }    
                        }
                        elseif ($finalarr2['Attend_Details'][$j]['partial_days']  == 'second_half') {
                            $presentcount += 0.5;
                        }
                        else{

                        }
                        $finalarr2['Attend_Details'][$j]['Present'] = $presentcount;
                    }
                    
                    

                    }
                   
                    // end cadre for late check

                    


                    $j = $j + 1;
                }
            }
        }



        //lateprocess

       /* foreach ($finalarr2['Attend_Details'] as $key11 => $value11) {
        	dd($value11[''])
        }*/

        dd($finalarr2);



    }
    return view('newemployeezone.login');
}


public function explode_time($time) { 
        $time = explode(':', $time);
        $time = $time[0] * 3600 + $time[1] * 60;
        return $time;
}

public function second_to_hhmm($time) { 
        $hour = floor($time / 3600);
        $minute = strval(floor(($time % 3600) / 60));
        if ($minute == 0) {
            $minute = "00";
        } else {
            $minute = $minute;
        }
        $time = $hour . ":" . $minute;
        return $time;
}

public function sendlmsdatatosap()
{
    $getdata = DB::connection('mysql6')->table('send_sap_leave_details')->where(['sentosap' => 'N'])->take(10)->get();
    
    if (count($getdata) > 0) {
        
        foreach ($getdata as $k => $value) {
            $count = $value->sentcount + 1;
            DB::connection('mysql6')->table('send_sap_leave_details')->where(['id' => $value->id])->update(['sentosap' => 'Y', 'sentcount' => $count]);
            $data = json_decode($value->details);
                $status = $this->insert_applicationtosapfinal($data);
                echo $status['Status'].'-----'.$value->id.'<br>';
                if ($status['Status'] == 'Updated Successfully') {
                    DB::connection('mysql6')->table('send_sap_leave_details')->where(['id' => $value->id])->delete();
                }
        }    
    }
    else{
        $check = DB::connection('mysql6')->table('send_sap_leave_details')->get();
        if(count($check) > 0){
            //DB::connection('mysql6')->table('send_sap_leave_details')->update(['sentosap' => 'N']);
        }
        
        echo 'No Data to Send!';
    }
}


public function forattendance_getholidayweekoff($employeeid, $start_date, $end_date, $rolecode) 
    {
        $getemployee = $this->getemployee($employeeid);

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

               
                   //dd(($empvalue['role_code'] == '4000') && ($empvalue['department']))
                   $carbon_start_date = Carbon::parse($start_date);
                   $carbon_end_date = Carbon::parse($end_date);
                   
                   if((strpos($rolecode, 'SAL_TM') !== false) || strpos($rolecode, 'SAL_INC') !== false){
                        if(($carbon_start_date->isTuesday() == true) || ($carbon_end_date->isTuesday() == true)){
                            $weekoff_count = 1;
                        }else{
                            $weekoff_count = 0;
                        }   
                   }
                   elseif ((strpos($rolecode, 'SAP_INC') !== false) || (strpos($rolecode, 'SAP_TM') !== false)) {
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
               

              $result = [];
              $result['holiday_count'] = $holiday_count;
              $result['weekoff_count'] = $weekoff_count;
               
                return $result;

    }


    public function getpunchesforlatesprocess($employeeid, $date,$shiftcode,$getpunches)
    {
        $newpunch = [];
        if (($shiftcode == 'VGN_FNIG') || ($shiftcode == 'VGN_NIGT')) {
         $date2 = Carbon::parse($date)->addDay()->toDateString();
         if (array_key_exists('0', $getpunches['Sorted_Punches'])) {
        		foreach ($getpunches['Sorted_Punches'] as $key => $value) {
        			if ($value['Date'] == $date) {
        			$newpunch[] = $value['Date'].' '.$value['Time'];	
        			}
        			if ($value['Date'] == $date2) {
        			$newpunch[] = $value['Date'].' '.$value['Time'];	
        			}
            	}
        	}
        }
        else{    
        	if (array_key_exists('0', $getpunches['Sorted_Punches'])) {
        		foreach ($getpunches['Sorted_Punches'] as $key => $value) {
        			if ($value['Date'] == $date) {
        			$newpunch[] = $value['Date'].' '.$value['Time'];	
        			}
            	}
        	}
       }
        return $newpunch;
        
    }

   
   public function get_the_prev_working_day_from_this_date($array,$key)
    {
        if (($key >= 1) && ($array[$key]['shift_date'] != $array[count($array) - 1]['shift_date'])) {
            $key -= 1;
            for ($i=$key; $i >= 0; $i--) { 
                //dd($array[$i]['holiday']);
            if (($array[$i]['weekoff'] == false) && ($array[$i]['holiday'] == false)) {

                return $array[$i];
            }
            }
        }
        else{
            if (Carbon::parse($array[$key]['shift_date'].' 00:00:00')->startOfMonth()->toDateString() == $array[$key]['shift_date']) {
                return $array[$key];
            }
        }
        
    }
    public function get_the_next_working_day_from_this_date($array,$key)
    {
        if (($key >= 1) && ($array[$key]['shift_date'] != $array[count($array) - 1]['shift_date'])) {
            $key += 1;
            for ($i=$key; $i <= count($array) ; $i++) { 
           
		if (array_key_exists($i, $array)) { 
            if (($array[$i]['weekoff'] == false) && ($array[$i]['holiday'] == false)) {
                return $array[$i];
            }
}
            }
        }
        else{
            if (Carbon::parse($array[$key]['shift_date'].' 00:00:00')->endOfMonth()->toDateString() == $array[$key]['shift_date']) {
                return $array[$key];
            }
        }
        
    }

    public function weekoff_holiday_process($array)
    {
	$currentdate = Carbon::now()->toDateString();
        $updated_arr = [];
        foreach ($array as $key_arr1 => $value_arr1) {
            $updated_arr[$key_arr1] = $value_arr1;
        if ($key_arr1 == 0) {
            $updated_arr[$key_arr1]['previous_working_date'] = $value_arr1;
        }else{
            $updated_arr[$key_arr1]['previous_working_date'] = $array[$key_arr1 -1];
        }
        if ($value_arr1['shift_date'] == $array[count($array) -1]['shift_date']) {
            $updated_arr[$key_arr1]['next_working_date'] = $value_arr1;
        }
        else{
            $updated_arr[$key_arr1]['next_working_date'] = $array[$key_arr1 +1];
        }
        
            
            if (($value_arr1['weekoff'] == true) || ($value_arr1['holiday'] == true)) {
                
    $updated_arr[$key_arr1]['previous_working_date'] = $this->get_the_prev_working_day_from_this_date($array,$key_arr1);
     $updated_arr[$key_arr1]['next_working_date'] = $this->get_the_next_working_day_from_this_date($array,$key_arr1);
                
                //$updated_arr[$key_arr1] = $value_arr1;
            }
            
        }

        $finalupdatedarr = [];
        foreach ($updated_arr as $key_final1 => $value_final1) {
            $finalupdatedarr[$key_final1] = $value_final1;
            if (($value_final1['shift_date'] == $updated_arr[0]['shift_date']) && (($value_final1['weekoff'] == true) || ($value_final1['holiday'] == true)) ) {
                //no process...
            }
            elseif (($value_final1['shift_date'] == $updated_arr[count($updated_arr)-1]['shift_date']) && (($value_final1['weekoff'] == true) || ($value_final1['holiday'] == true))) {
                // no process...
            }
            else{
		
		if (($value_final1['weekoff'] == true) || ($value_final1['holiday'] == true) ) {
                if (!empty($value_final1['lms_applications'])) {
                    if (count($value_final1['lms_applications']) == 1) {
                        if ($value_final1['lms_applications'][0]->partial_days == 'full') {
                            continue;
                        }
                    }

                    if (count($value_final1['lms_applications']) == 2) {
                        if (($value_final1['lms_applications'][0]->type == 'Permission') && ($value_final1['lms_applications'][1]->partial_days != 'Permission')) {
                            continue;
                        }
                    }
                    
                }
            }
		$lteqcurrentdate = Carbon::parse($currentdate.' 00:00:00')->gt(Carbon::parse($value_final1['shift_date'].' 00:00:00'));
                if ((($value_final1['weekoff'] == true) || ($value_final1['holiday'] == true)) && $lteqcurrentdate) {
                    $valid = 0;
		
                    //dd($value_final1['previous_working_date']['punchlist']);
                    if (empty($value_final1['previous_working_date']['punchlist'])&&empty($value_final1['next_working_date']['punchlist'])) {
                        if (!empty($value_final1['previous_working_date']['lms_applications']) && !empty($value_final1['next_working_date']['lms_applications'])) {
                            $passed = 0;
                            $npassed = 0;
                            

                            $newprevpass = 0;
                            $newnextpass = 0;
                            $leavesarr = ['CL', 'SL','PL','ML','RH','Permission'];
                            if (count($value_final1['previous_working_date']['lms_applications']) == 1) 
                            {

                                    if (in_array($value_final1['previous_working_date']['lms_applications'][0]->type, $leavesarr) === true) {
                                        $newprevpass = 1;
                                    }
                                
                            }

                            if (count($value_final1['previous_working_date']['lms_applications']) == 2) 
                            {
                                $newprevpass1 = false;
                                $newprevpass2 = false;

                                if (($value_final1['previous_working_date']['lms_applications'][0]->partial_days == 'first_half') && (in_array($value_final1['previous_working_date']['lms_applications'][0]->type, $leavesarr) === true)) {
                                    $newprevpass1 = true;
                                }

                                if (($value_final1['previous_working_date']['lms_applications'][1]->partial_days == 'second_half') && (in_array($value_final1['previous_working_date']['lms_applications'][1]->type, $leavesarr) === true)) {
                                    $newprevpass2 = true;
                                }

                                if (($newprevpass1 == true) && ($newprevpass2 == true)) {
                                    $newprevpass = 1;
                                }
                                
                            }

                            

                            if (count($value_final1['next_working_date']['lms_applications']) == 1) 
                            {

                                    if (in_array($value_final1['next_working_date']['lms_applications'][0]->type, $leavesarr) === true) {
                                        $newnextpass = 1;
                                    }
                                
                            }

                            if (count($value_final1['next_working_date']['lms_applications']) == 2) 
                            {
                                $newnextpass1 = false;
                                $newnextpass2 = false;

                                if (($value_final1['next_working_date']['lms_applications'][0]->partial_days == 'first_half') && (in_array($value_final1['next_working_date']['lms_applications'][0]->type, $leavesarr) === true)) {
                                    $newnextpass1 = true;
                                }

                                if (($value_final1['next_working_date']['lms_applications'][1]->partial_days == 'second_half') && (in_array($value_final1['next_working_date']['lms_applications'][1]->type, $leavesarr) === true)) {
                                    $newnextpass2 = true;
                                }

                                if (($newnextpass1 == true) && ($newnextpass2 == true)) {
                                    $newnextpass = 1;
                                }
                                
                            }

                            
                            
                            if (($newprevpass == 1) && ($newnextpass == 1)) {
                                $finalupdatedarr[$key_final1]['absent'] = 1;
                                $finalupdatedarr[$key_final1]['present'] = 0; 
                            }else{
                                $finalupdatedarr[$key_final1]['absent'] = 0;
                                $finalupdatedarr[$key_final1]['present'] = 1; 
                            }
                            
                        }
                    }

                    if ((!empty($value_final1['previous_working_date']['punchlist']) && empty($value_final1['next_working_date']['punchlist'])) || (empty($value_final1['previous_working_date']['punchlist']) && !empty($value_final1['next_working_date']['punchlist']))) {
                         if (($value_final1['weekoff'] == false) && ($value_final1['holiday'] == true)&& ($value_final1['holiday_count'] == 0.5)&& (empty($value_final1['lms_applications']) == true)&& (empty($value_final1['punchlist']) == true)) {
                            $finalupdatedarr[$key_final1]['absent'] = 1;
                                $finalupdatedarr[$key_final1]['present'] = 0;
                         }else{

                                $finalupdatedarr[$key_final1]['absent'] = 0;
                                $finalupdatedarr[$key_final1]['present'] = 1;
                            }
                    }


                }
            }
        }

        return $finalupdatedarr;
    }  
 

   public function attendance_view(Request $request)
   {
       if ($request->session()->has('employeesession')) {
            $encrypt = $request->session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $employeeid = $split[0];
            $getemployeedata = DB::connection('mysql6')->table('employee')->where('id', '=', $employeeid)->get();
            $currentdate = Carbon::now()->toDateString();
             $month = date('F');
             $year = date('Y');

             $pwd_status = $this->is_emp_didnt_passwordchanged($employeeid);
            if ($pwd_status == 0) {
                $request->session()->flash("error_msg", 'Please change the default password. Only if you Change the default password , other functionalities on this portal will work. This is done for security purposes. Please do not share your password with anyone');
                return redirect()->route('newemployee_mydetails_passchange');
            }
                               
             $monthnumber = Carbon::now()->format('m');
             $monthyear = Carbon::now()->format('Y');
             
             $attendance = $this->newattendancesummary($employeeid, $monthnumber, $monthyear);
             
	     $processed_attendance = $this->weekoff_holiday_process($attendance);
             $attendance = $processed_attendance;
            // dd($attendance);
             $summary = [];

             $summary['total_days'] = 0;
             $summary['weekoff'] = 0;
             $summary['holiday'] = 0;

             $summary['absent'] = 0;
             $summary['present'] = 0;

             $summary['LOP'] = 0;
             $summary['CL'] = 0;
             $summary['SL'] = 0;
             $summary['PL'] = 0;
             $summary['Permission'] = 0;
             $summary['RH'] = 0;
             $summary['ML'] = 0;
             $summary['Onduty'] = 0;
             $summary['Tour'] = 0;
             $summary['Compoff'] = 0;
             $summary['Mispunch'] = 0;

             $summary['latecount'] = 0;
             $summary['earlyoutcount'] = 0;

             $summary['late_earlyout_lop'] = 0;

             foreach($attendance as $sum_key => $sum_val){
                 $currendate = Carbon::now()->toDateString();
                 if(Carbon::parse($sum_val['shift_date'])->lt(Carbon::parse($currentdate))){
                    $summary['total_days'] += 1;
                 }
                 if($sum_val['weekoff'] == true){
                    $summary['weekoff'] += 1;
                 }
                 if($sum_val['holiday'] == true){
                    $summary['holiday'] += 1;
                 }

                 if($sum_val['latecount'] != 0){
                    $summary['latecount'] += 1;
                 }

                 if($sum_val['earlyoutcount'] != 0){
                    $summary['earlyoutcount'] += 1;
                 }
                 
                    $summary['absent'] += $sum_val['absent'];
                    $summary['present'] += $sum_val['present'];
                    $summary['late_earlyout_lop'] += $sum_val['first_half_lop'] + $sum_val['second_half_lop'];


                    if (count($sum_val['lms_applications']) > 0) {
                        foreach($sum_val['lms_applications'] as $lms_key => $lms_val){
                            if($lms_val->type == 'Permission'){
                                if($lms_val->partial_days == 'full'){ $cc = 1;}else{ $cc = 1; }
                                $summary[$lms_val->type] += $cc;
                            }
                            elseif($lms_val->type == 'LOP'){
                                if($lms_val->partial_days == 'full'){ $cc = 1;}else{ $cc = 0.5; }
                                $summary[$lms_val->type] += $cc;
                                //$summary['late_earlyout_lop'] -= $cc;
                            }
                            else{
                                if($lms_val->partial_days == 'full'){ $cc = 1;}else{ $cc = 0.5; }
                                $summary[$lms_val->type] += $cc;
                            }
                            
                        }
                        
                    }
                    
                 
             }

             
             $dropdown_year = Carbon::now()->format('Y');
             $drop_down_months = Carbon::now()->format('m');
             $dropmontharray = [];
             for($i = 1; $i<=$drop_down_months; $i++){
                 $dropmontharray[$i] = Carbon::parse($dropdown_year.'-'.$i.'-01')->format('F');
             }    
             $currentmonthinno = $drop_down_months;         
             $cc = Carbon::now()->toDateString();
             if(Carbon::now()->format('m') == $currentmonthinno){
                $tt = 'Total Worked days as on '.Carbon::parse($cc)->subDay()->format('d.m.Y');
             }
             else{
                $tt = 'Total Worked days';
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
             

             //dd($summary);
             $summarytitle = Carbon::now()->format('F').' '.Carbon::now()->format('Y').' Attendance Summary';

             $listfiles = Storage::disk('s3')->files("/newcustomerzoneassets/employeeprofileimage/".$employeeid);             
             if(count($listfiles) > 0){
                $profilepic = config('app.AWS_URL')."/".$listfiles[0];
            }
             else
             {
                $profilepic = config('app.AWS_URL')."/newcustomerzoneassets/img/dummy_male.png";
             }
	
                        
             return view('newemployeezone.lms.attendance_view')->with(['getemployeedata'=> $getemployeedata,'workdaystext'=>$tt,'summarytitle'=>$summarytitle,'dropmontharray' => $dropmontharray,'dropdown_year' => $dropdown_year,'yeararray'=>$yeararray,'montharray' => $montharray,'currentmonthinno' => $currentmonthinno,'currentmonth' => $currentmonth,'currentyear' => $currentyear,'summary' => $summary,'attendance'=>$attendance,'profilepic' => $profilepic]);
             
              }
        else{
            return redirect()->route('newemployee_home');
        }
   }


   public function oldattendance(Request $request, $requestdate)
   {
    if ($request->session()->has('employeesession')) {
        $encrypt = $request->session()->get('employeesession');
        $decrypt = Crypt::decrypt($encrypt);
        $split = explode("-",$decrypt);
        $employeeid = $split[0];
        $getemployeedata = DB::connection('mysql6')->table('employee')->where('id', '=', $employeeid)->get();
        
        
                
        foreach ($getemployeedata as $ckey => $cvalue) {
             $cadre = $cvalue->cadre;
             $shift_name = $cvalue->shift_name;
             //dd($shift_name);
         }
        
        
        $month = Carbon::parse($requestdate)->format('F');
        $year = Carbon::parse($requestdate)->format('Y');
        
        
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
        
        //$postedmonth = $request->monthname;
        //$postedyear = $request->yearname;
        $postedmonth = Carbon::parse($requestdate)->format('F');
        $postedyear = Carbon::parse($requestdate)->format('Y');
        
        
           
         return view('newemployeezone.myattendance')->with(['getemployeedata'=> $getemployeedata, 'getattendance'=> $datearray,'montharray' => $montharray, 'yeararray'=>$yeararray,'currentyear' => $postedyear,'currentmonth'=>$postedmonth,'currentdate'=>$currentdate,'profilepic' => $profilepic]);
        
             }
    else{
        return redirect()->route('newemployee_home');
    }
}

   public function postattendance_view(Request $request)
   {

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
        
                $requested_month = Carbon::parse($request->yearname.'-'.$request->monthname.'-01')->toDateString();
                $newattendance_view_startdate = '2018-07-01';
                $crdate = Carbon::now()->startOfMonth()->toDateString();

                if(Carbon::parse($requested_month)->gt(Carbon::parse($crdate))){
                    return redirect()->back();
                }

                if(Carbon::parse($requested_month)->gte(Carbon::parse($newattendance_view_startdate))){
                    $monthnumber = Carbon::parse($requested_month)->format('m');
                    $monthyear = Carbon::parse($requested_month)->format('Y');
                    $attendance = $this->newattendancesummary($employeeid, $monthnumber, $monthyear);
		    $processed_attendance = $this->weekoff_holiday_process($attendance);
             $attendance = $processed_attendance;
                    //dd($attendance);
                }
                else{
                    return $this->oldattendance($requested_month);
                }
             
            $currentdate = Carbon::now()->toDateString();

             $summary = [];

             $summary['total_days'] = 0;
             $summary['weekoff'] = 0;
             $summary['holiday'] = 0;

             $summary['absent'] = 0;
             $summary['present'] = 0;

             $summary['LOP'] = 0;
             $summary['CL'] = 0;
             $summary['SL'] = 0;
             $summary['PL'] = 0;
             $summary['Permission'] = 0;
             $summary['RH'] = 0;
             $summary['ML'] = 0;
             $summary['Onduty'] = 0;
             $summary['Tour'] = 0;
             $summary['Compoff'] = 0;
             $summary['Mispunch'] = 0;

             $summary['latecount'] = 0;
             $summary['earlyoutcount'] = 0;

             $summary['late_earlyout_lop'] = 0;             

             foreach($attendance as $sum_key => $sum_val){
                 $currendate = Carbon::now()->toDateString();
                 if(Carbon::parse($sum_val['shift_date'])->lt(Carbon::parse($currentdate))){
                    $summary['total_days'] += 1;
                 }
                 if($sum_val['weekoff'] == true){
                    $summary['weekoff'] += 1;
                 }
                 if($sum_val['holiday'] == true){
                    $summary['holiday'] += 1;
                 }

                 if($sum_val['latecount'] != 0){
                    $summary['latecount'] += 1;
                 }

                 if($sum_val['earlyoutcount'] != 0){
                    $summary['earlyoutcount'] += 1;
                 }
                 
                    $summary['absent'] += $sum_val['absent'];
                    $summary['present'] += $sum_val['present'];

                    $summary['late_earlyout_lop'] += $sum_val['first_half_lop'] + $sum_val['second_half_lop'];


                    if (count($sum_val['lms_applications']) > 0) {
                        foreach($sum_val['lms_applications'] as $lms_key => $lms_val){
                            if($lms_val->type == 'Permission'){
                                if($lms_val->partial_days == 'full'){ $cc = 1;}else{ $cc = 1; }
                                $summary[$lms_val->type] += $cc;
                            }
                            elseif($lms_val->type == 'LOP'){
                                if($lms_val->partial_days == 'full'){ $cc = 1;}else{ $cc = 0.5; }
                                $summary[$lms_val->type] += $cc;
                                //$summary['late_earlyout_lop'] -= $cc;
                            }
                            else{
                                if($lms_val->partial_days == 'full'){ $cc = 1;}else{ $cc = 0.5; }
                                $summary[$lms_val->type] += $cc;
                            }
                            
                        }
                        
                    }
                    
                 
             }

             
             $dropdown_year = Carbon::now()->format('Y');
             $drop_down_months = Carbon::now()->format('m');
             $dropmontharray = [];
             for($i = 1; $i<=$drop_down_months; $i++){
                 $dropmontharray[$i] = Carbon::parse($dropdown_year.'-'.$i.'-01')->format('F');
             }    
             $currentmonthinno = Carbon::parse($requested_month)->format('m');  
             $cc = Carbon::now()->toDateString();
             if(Carbon::now()->format('m') == $currentmonthinno){
                $tt = 'Total Worked days as on '.Carbon::parse($cc)->subDay()->format('d.m.Y');
             }
             else{
                $tt = 'Total Worked days';
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

             $currentmonth = $request->monthname;
             $currentyear = $request->yearname;

             //dd($summary);
             $summarytitle = Carbon::parse($requested_month)->format('F').' '.Carbon::parse($requested_month)->format('Y').' Attendance Summary';

             $listfiles = Storage::disk('s3')->files("/newcustomerzoneassets/employeeprofileimage/".$employeeid);             
             if(count($listfiles) > 0){
                $profilepic = config('app.AWS_URL')."/".$listfiles[0];
            }
             else
             {
                $profilepic = config('app.AWS_URL')."/newcustomerzoneassets/img/dummy_male.png";
             }
                          
             return view('newemployeezone.lms.attendance_view')->with(['getemployeedata'=> $getemployeedata,'workdaystext' => $tt,'summarytitle'=>$summarytitle,'dropmontharray' => $dropmontharray,'dropdown_year' => $dropdown_year,'montharray' =>$montharray,'yeararray' => $yeararray,'currentmonth' => $currentmonth,'currentyear' => $currentyear,'currentmonthinno' => $currentmonthinno,'summary' => $summary,'attendance'=>$attendance,'profilepic' => $profilepic]);
             
              }
        else{
            return redirect()->route('newemployee_home');
        }


        
    }

    public function load_data_for_late_deduction()
    {
        $getcurrent_datetime = Carbon::now()->toDateTimeString();
        $startofmonth = Carbon::now()->startOfMonth()->toDateString();
        $getcurrenddate = Carbon::now()->toDateString();
        $seconddate = Carbon::parse($startofmonth)->addDay()->toDateString();

        if($getcurrenddate == $startofmonth){
            if((Carbon::parse($getcurrent_datetime)->gte(Carbon::parse($getcurrenddate.' 09:01:00'))) && (Carbon::parse($getcurrent_datetime)->lte(Carbon::parse($getcurrenddate.' 09:05:00'))) )
            {

                //start
                $getactiveemployees = $this->getallactiveemployees();
        $empid_to_process = [];
        foreach ($getactiveemployees['Details'] as $key => $value) {
            $securities = ['SCT_TM(PLANT)','SCT_TM(REG)'];
            $avoid_emp_ids = ['200577'];
            $position = ['SECURITY GUARDS', 'SECURITY OFFICER','ASSISTANT SECURITY OFFICER','ASSISTANT SECURITY OFFICE','GARDNER','HOUSE KEEPER','SCAVENGER','GYM TRAINER','PAINTER','DRIVER FOR HEAVY VEHICLES','NON TECHNICAL NMR','DRIVER FOR LIGHT VEHICLES'];
            if(!(in_array($value['Role_Code'], $securities)) && !(in_array($value['Position'], $position)) && !(in_array($value['Emp_ID'], $avoid_emp_ids)) && ($value['OnContract'] != 'C') && ($value['OnNotice'] != 'N') ){
                $empid_to_process[] = $value;
            }
        }

        $process_month = Carbon::parse($getcurrenddate)->subDays(10)->format('m');
        $process_year = Carbon::parse($getcurrenddate)->subDays(10)->format('Y');
        foreach ($empid_to_process as $latekey => $latevalue) {
                
            $getready_process =  DB::connection('mysql6')->table('lateacrual_process')->where(['employeeid'=>$latevalue['Emp_ID'], 'month' => $process_month, 'year'=> $process_year,'processed'=>'Y' ])->get();
            if (count($getready_process) == 0) {
                echo 'Feeding Employee - '.$latevalue['Emp_ID'].' , Name - '.$latevalue['Emp_Name'].'<br>';
                DB::connection('mysql6')->table('lateacrual_process')->insert(
                    ['employeeid'=>$latevalue['Emp_ID'],
                     'emp_name' => $latevalue['Emp_Name'],
                     'role_code' => $latevalue['Role_Code'],
                     'plant_code' => $latevalue['Plant_Code'],
                     'position' => $latevalue['Position'],
                     'department' => $latevalue['Department'],
                     'cadre' => $latevalue['Cadre'],
                     'doj' => $latevalue['DOJ'],
                     'month' => $process_month,
                     'year'=>$process_year,                     
                     'active_details' => json_encode($latevalue),
                     'processed'=>'Y',
                     'last_processed_date' => Carbon::now()->toDateTimeString()
                      ]);    
            }

        }
                //end
            }
        }

    }

    
    public function lateprocess_accrual()
    {
        $getcurrent_datetime = Carbon::now()->toDateTimeString();
        $startofmonth = Carbon::now()->startOfMonth()->toDateString();
        $getcurrenddate = Carbon::now()->toDateString();
        $seconddate = Carbon::parse($startofmonth)->addDay(1)->toDateString();
		
        return 'ok';
		
        
                //script start
        //$process_month = Carbon::parse($getcurrenddate)->subDays(10)->format('m');
        //$process_year = Carbon::parse($getcurrenddate)->subDays(10)->format('Y');
        $getready_process =  DB::connection('mysql6')->table('lateacrual_process')->where(['processed'=>'N' ])->orderBy('employeeid', 'desc')->take(5)->get();
        
        if (count($getready_process) > 0) {
            
            foreach ($getready_process as $key => $value) {

                $newmonth = Carbon::parse($getcurrenddate)->format('m');
                $newyear = Carbon::parse($getcurrenddate)->format('Y');
                $isvalid = DB::connection('mysql6')->table('leave_balance')->where(['employeeid' => $value->employeeid, 'month' => $newmonth, 'year' => $newyear])->get();

                if (count($isvalid) == 0) {
                    DB::connection('mysql6')->table('lateacrual_process')->where(['employeeid' => $value->employeeid, 'month' => $process_month, 'year' => $process_year])->delete();
                    continue;
                }

                $json_decoded_data = (array)json_decode($value->active_details);
                $employeeid = $value->employeeid;
                
                //started
                $attendance = $this->newattendancesummary($employeeid, "$process_month", "$process_year");
		$processed_attendance = $this->weekoff_holiday_process($attendance);
             $attendance = $processed_attendance;
                //dd($attendance);
                $latecount = 0;
                $earlyoutcount = 0;
                $absent = 0;
                $present = 0;
                $lop = 0;
                foreach($attendance as $newkey => $newvalue){

                  /*  $dd = Carbon::parse($newvalue['shift_startdatetime'])->format('Y-m-d');
                    if (Carbon::parse($dd.' 00:00:00')->gte(Carbon::parse('2019-06-26 00:00:00'))) {
                        continue;
                    }*/
                    
                     //timeget
    $diffinminutes = Carbon::parse($newvalue['shift_startdatetime'])->diffInSeconds(Carbon::parse($newvalue['shift_enddatetime']));
    $minutesdivide = $diffinminutes/2;
    $gmate = gmdate('H:i:s', $minutesdivide);
    
    $splitsub = explode(':', $gmate);
    if (($newvalue['shift_code'] == 'VGN_GEN') || ($newvalue['shift_code'] == 'VGN_GEN2') || ($newvalue['shift_code'] == 'VGN_RCP1') || ($newvalue['shift_code'] == 'VGN_RCP2') || ($newvalue['shift_code'] == 'VGN_SAP') || ($newvalue['shift_code'] == 'VGN_MGR') ) {
    $midtime = Carbon::parse($newvalue['shift_startdatetime'])->addHours($splitsub[0])->addMinutes($splitsub[1])->subMinutes(30)->toDateTimeString();
    }
    else{
        $midtime = Carbon::parse($newvalue['shift_startdatetime'])->addHours($splitsub[0])->addMinutes($splitsub[1])->toDateTimeString();
    }

    if (!empty($newvalue['punchlist'])) { $punchlist = json_encode($newvalue['punchlist']);}else{ $punchlist = null; }
    if (!empty($newvalue['lms_applications'])) { $lmsapp = json_encode($newvalue['lms_applications']);}else{ $lmsapp = null; }
    if (!empty($newvalue['first_half_considered_punches'])) { $first_half_considered_punches_list = json_encode($newvalue['first_half_considered_punches']);}else{ $first_half_considered_punches_list = null; }

                    //timeget
                    $add1hourmidtime = Carbon::parse($newvalue['shift_startdatetime'])->addMinutes(90);
                    $add3hourendtime = Carbon::parse($newvalue['shift_enddatetime'])->addHours(3);

                    $newcurrentdatetime = Carbon::now();
                    

          
                    if($newvalue['latecount'] != 0){
                        $latecount += 1;
                     }
    
                     if($newvalue['earlyoutcount'] != 0){
                        $earlyoutcount += 1;
                     }
                     
                        $absent += $newvalue['absent'];
                        $present += $newvalue['present'];

                    if((($newvalue['first_half_lop'] != 0) || ($newvalue['second_half_lop'] != 0)) && ($newvalue['absent'] == 0))
                    {
                        if($newvalue['first_half_lop'] == 0.5){


                            $checkprev = DB::connection('mysql6')->table('latededuction_finaltosap')->where([
                                'employeeid' => $employeeid ,
                            'month' => "$process_month", 
                            'year'=> "$process_year", 
                            'deduction_stdate_time'=> $newvalue['shift_startdatetime'], 
                            'deduction_etdate_time' => $midtime,
                            'partial_days' => 'first_half',
                            'type' => 'LATE'
                                 ])->count();

                            $explodetime1 = explode(' ', $newvalue['shift_startdatetime']);
                            $explodetime2 = explode(' ', $midtime);
                            $arr = [
                                'employeeid' => $employeeid,
                                "from_date"=> substr($newvalue['shift_startdatetime'],0,10),
                                "to_date"=> substr($midtime,0,10),
                                "leave_type"=> 'LATE',
                                "starttime"=> substr($explodetime1[1],0,5),
                                "endtime"=> substr($explodetime2[1],0,5)
                             ];
                            
                             $sentosap = 'Y';

                            
                             /*DB::connection('mysql6')->table('send_sap_leave_details')->insert(['details' => json_encode($arr), 'created_datetime' => Carbon::now()->toDateTimeString()]);*/
                             Log::info('SAP Late deduction sap error... '.$employeeid);
                             /*$is_updated_in_sap = $this->deduct_leave_forlate($arr);
                             
                             if ($is_updated_in_sap['Status'] == 'Updated Successfully') {
                                 $sentosap = 'Y';
                             }
                             else{
                                Log::info('SAP Late deduction sap error... '.$employeeid.' - Status: '.$is_updated_in_sap['Status'].' '.$newvalue['shift_startdatetime']);
                                 $sentosap = 'N';
                             }*/

                             if($checkprev == 0){

                            $getready_process =  DB::connection('mysql6')->table('latededuction_finaltosap')
                        ->insert([
                            'employeeid' => $employeeid ,
                            'emp_name' => $json_decoded_data['Emp_Name'],
                            'role_code' => $json_decoded_data['Role_Code'],
                            'plant_code' => $json_decoded_data['Plant_Code'],
                            'position' => $json_decoded_data['Position'],
                            'department' => $json_decoded_data['Department'],
                            'cadre' => $json_decoded_data['Cadre'],
                            'month' => "$process_month", 
                            'year'=> "$process_year", 
                            'deduction_stdate_time'=> $newvalue['shift_startdatetime'], 
                            'deduction_etdate_time' => $midtime,
                            'partial_days' => 'first_half',
                            'type' => 'LATE',
                            'punchlist' => $punchlist,
                            'lms_applications' => $lmsapp,
                            'first_half_lop' => $newvalue['first_half_lop'],
                            'second_half_lop' => $newvalue['second_half_lop'],
                            'latecount' => $newvalue['latecount'],
                            'latein_hours' => $newvalue['latein_hours'],
                            'laterange1' => $newvalue['laterange1'],
                            'laterange2' => $newvalue['laterange2'],
                            'laterange3' => $newvalue['laterange3'],
                            'earlyoutcount' => $newvalue['earlyoutcount'],
                            'earlyout_hours' => $newvalue['earlyout_hours'],
                            'absent' => $newvalue['absent'],
                            'present' => $newvalue['present'],
                            'first_half_considered_punches' => $first_half_considered_punches_list,
                            'sento_sap' => $sentosap,
                            'sento_sapdate' => Carbon::now()->toDateTimeString()
                             ]);

                            }
                            else
                            {
                                $getready_process =  DB::connection('mysql6')->table('latededuction_finaltosap')->where(
                                    ['employeeid' => $employeeid ,
                                    'month' => "$process_month", 
                                    'year'=> "$process_year", 
                                    'deduction_stdate_time'=> $newvalue['shift_startdatetime'], 
                                    'deduction_etdate_time' => $midtime,
                                    'partial_days' => 'first_half',
                                    'type' => 'LATE']
                                )->update([
                                    'sento_sap' => $sentosap,
                                    'sento_sapdate' => Carbon::now()->toDateTimeString()
                                ]);

                            }
                        }
                        if($newvalue['second_half_lop'] == 0.5){
                            $checkprev = DB::connection('mysql6')->table('latededuction_finaltosap')->where([
                                'employeeid' => $employeeid ,
                            'month' => "$process_month", 
                            'year'=> "$process_year", 
                            'deduction_stdate_time'=> $midtime, 
                            'deduction_etdate_time' => $newvalue['shift_enddatetime'],
                            'partial_days' => 'second_half',
                            'type' => 'LATE'
                                 ])->count();
                                 
                            $explodetime1 = explode(' ', $midtime);
                            $explodetime2 = explode(' ', $newvalue['shift_enddatetime']);
                            $arr = [
                                'employeeid' => $employeeid,
                                "from_date"=> substr($midtime,0,10),
                                "to_date"=> substr($newvalue['shift_enddatetime'],0,10),
                                "leave_type"=> 'LATE',
                                "starttime"=> substr($explodetime1[1],0,5),
                                "endtime"=> substr($explodetime2[1],0,5)
                             ];
                            
                             $sentosap = 'Y';
                             /*DB::connection('mysql6')->table('send_sap_leave_details')->insert(['details' => json_encode($arr), 'created_datetime' => Carbon::now()->toDateTimeString()]);*/
                             Log::info('SAP Late deduction sap error... '.$employeeid);
                             /*$is_updated_in_sap = $this->deduct_leave_forlate($arr);
                             if ($is_updated_in_sap['Status'] == 'Updated Successfully') {
                                 $sentosap = 'Y';
                             }
                             else{
                                Log::info('SAP Late deduction sap error... '.$employeeid.' - Status: '.$is_updated_in_sap['Status'].' '.$newvalue['firsth_end_sech_starttime']);
                                 $sentosap = 'N';
                             }*/

                             if($checkprev == 0){
                                $getready_process =  DB::connection('mysql6')->table('latededuction_finaltosap')
                                ->insert([
                                    'employeeid' => $employeeid ,
                                    'emp_name' => $json_decoded_data['Emp_Name'],
                                    'role_code' => $json_decoded_data['Role_Code'],
                                    'plant_code' => $json_decoded_data['Plant_Code'],
                                    'position' => $json_decoded_data['Position'],
                                    'department' => $json_decoded_data['Department'],
                                    'cadre' => $json_decoded_data['Cadre'],
                                    'month' => "$process_month", 
                                    'year'=> "$process_year", 
                                    'deduction_stdate_time'=> $midtime, 
                                    'deduction_etdate_time' => $newvalue['shift_enddatetime'],
                                    'partial_days' => 'second_half',
                                    'type' => 'LATE',
                                    'punchlist' => $punchlist,
                                    'lms_applications' => $lmsapp,
                                    'first_half_lop' => $newvalue['first_half_lop'],
                                    'second_half_lop' => $newvalue['second_half_lop'],
                                    'latecount' => $newvalue['latecount'],
                                    'latein_hours' => $newvalue['latein_hours'],
                                    'laterange1' => $newvalue['laterange1'],
                                    'laterange2' => $newvalue['laterange2'],
                                    'laterange3' => $newvalue['laterange3'],
                                    'earlyoutcount' => $newvalue['earlyoutcount'],
                                    'earlyout_hours' => $newvalue['earlyout_hours'],
                                    'absent' => $newvalue['absent'],
                                    'present' => $newvalue['present'],
                                    'first_half_considered_punches' => $first_half_considered_punches_list,
                                    'sento_sap' => $sentosap,
                                    'sento_sapdate' => Carbon::now()->toDateTimeString()
                                     ]);
                             }
                             else{
                                $getready_process =  DB::connection('mysql6')->table('latededuction_finaltosap')->where(
                                    ['employeeid' => $employeeid ,
                                    'month' => "$process_month", 
                                    'year'=> "$process_year", 
                                    'deduction_stdate_time'=> $midtime, 
                                    'deduction_etdate_time' => $newvalue['shift_enddatetime'],
                                    'partial_days' => 'second_half',
                                    'type' => 'LATE']
                                )->update([
                                    'sento_sap' => $sentosap,
                                    'sento_sapdate' => Carbon::now()->toDateTimeString()
                                ]);
                             }

                           
                        }
                    }
                    elseif((($newvalue['first_half_lop'] == 0) || ($newvalue['second_half_lop'] == 0)) && ($newvalue['absent'] == 1))
                    {                        
                        $checkprev = DB::connection('mysql6')->table('latededuction_finaltosap')->where([
                            'employeeid' => $employeeid ,
                        'month' => "$process_month", 
                        'year'=> "$process_year", 
                        'deduction_stdate_time'=> $newvalue['shift_startdatetime'], 
                        'deduction_etdate_time' => $newvalue['shift_enddatetime'],
                        'partial_days' => 'full',
                        'type' => 'LOP'
                             ])->count();
                             $lop += 1;

                        $explodetime1 = explode(' ', $newvalue['shift_startdatetime']);
                        $explodetime2 = explode(' ', $newvalue['shift_enddatetime']);
                        $arr = [
                            'employeeid' => $employeeid,
                            "from_date"=> substr($newvalue['shift_startdatetime'],0,10),
                            "to_date"=> substr($newvalue['shift_startdatetime'],0,10),
                            "leave_type"=> 'LOP',
                            "starttime"=> '',
                            "endtime"=> ''
                         ];
                        
                         $sentosap = 'Y';
                         /*DB::connection('mysql6')->table('send_sap_leave_details')->insert(['details' => json_encode($arr), 'created_datetime' => Carbon::now()->toDateTimeString()]);*/
                             Log::info('SAP LOP deduction sap error... '.$employeeid);
                         /*$is_updated_in_sap = $this->deduct_leave_forlate($arr);
                        if ($is_updated_in_sap['Status'] == 'Updated Successfully') {
                            $sentosap = 'Y';
                        }
                        else{
                            Log::info('SAP Late deduction sap error for LOP... '.$employeeid.' - Status: '.$is_updated_in_sap['Status'].' '.$newvalue['shift_startdatetime']);
                            $sentosap = 'N';
                        }*/

                        if($checkprev == 0){

                        $getready_process =  DB::connection('mysql6')->table('latededuction_finaltosap')
                        ->insert([
                            'employeeid' => $employeeid ,
                            'emp_name' => $json_decoded_data['Emp_Name'],
                            'role_code' => $json_decoded_data['Role_Code'],
                            'plant_code' => $json_decoded_data['Plant_Code'],
                            'position' => $json_decoded_data['Position'],
                            'department' => $json_decoded_data['Department'],
                            'cadre' => $json_decoded_data['Cadre'],
                            'month' => "$process_month", 
                            'year'=> "$process_year", 
                            'deduction_stdate_time'=> $newvalue['shift_startdatetime'], 
                            'deduction_etdate_time' => $newvalue['shift_enddatetime'],
                            'partial_days' => 'full',
                            'type' => 'LOP',
                            'punchlist' => $punchlist,
                            'lms_applications' => $lmsapp,
                            'first_half_lop' => $newvalue['first_half_lop'],
                            'second_half_lop' => $newvalue['second_half_lop'],
                            'latecount' => $newvalue['latecount'],
                            'latein_hours' => $newvalue['latein_hours'],
                            'laterange1' => $newvalue['laterange1'],
                            'laterange2' => $newvalue['laterange2'],
                            'laterange3' => $newvalue['laterange3'],
                            'earlyoutcount' => $newvalue['earlyoutcount'],
                            'earlyout_hours' => $newvalue['earlyout_hours'],
                            'absent' => $newvalue['absent'],
                            'present' => $newvalue['present'],
                            'first_half_considered_punches' => $first_half_considered_punches_list,
                            'sento_sap' => $sentosap,
                            'sento_sapdate' => Carbon::now()->toDateTimeString()
                             ]);
                        }else{
                            $getready_process =  DB::connection('mysql6')->table('latededuction_finaltosap')->where(
                                [
                                    'employeeid' => $employeeid ,
                                    'month' => "$process_month", 
                                    'year'=> "$process_year", 
                                    'deduction_stdate_time'=> $newvalue['shift_startdatetime'], 
                                    'deduction_etdate_time' => $newvalue['shift_enddatetime'],
                                    'partial_days' => 'full',
                                    'type' => 'LOP'
                                ]
                            )->update([
                                'sento_sap' => $sentosap,
                                'sento_sapdate' => Carbon::now()->toDateTimeString()
                            ]);
                        }
                    }
                    elseif((($newvalue['first_half_lop'] == 0) || ($newvalue['second_half_lop'] == 0)) && ($newvalue['absent'] == 0.5))
                    {
                        $starttime1 = $newvalue['shift_startdatetime'];
                        $endtime1 = $newvalue['shift_enddatetime'];
                        $partial_days1 = 'first_half';

                        $getapplop = DB::connection('mysql6')->table('datetime_ref')->where(['employeeid' => $employeeid ,'month' => "$process_month",'year'=> "$process_year",'date'=>$newvalue['shift_date'],'type' => 'LOP'])->get();
                                if(count($getapplop) > 0){
                                    foreach ($getapplop as $lkey => $lvalue) {
                                        $partial_half = $lvalue->partial_days;
                                    }

                                    if($partial_half == 'first_half'){
                                        $starttime1 = $newvalue['shift_startdatetime'];
                                        $endtime1 = $midtime;
                                        $partial_days1 = 'first_half';
                                        $lop += 0.5;
                                    }
                                    if($partial_half == 'second_half'){
                                        $starttime1 = $midtime;
                                        $endtime1 = $newvalue['shift_enddatetime'];
                                        $partial_days1 = 'second_half';
                                        $lop += 0.5;
                                    }

                            }

                        $checkprev = DB::connection('mysql6')->table('latededuction_finaltosap')->where([
                            'employeeid' => $employeeid ,
                        'month' => "$process_month", 
                        'year'=> "$process_year", 
                        'deduction_stdate_time'=> $starttime1, 
                        'deduction_etdate_time' => $endtime1,
                        'partial_days' => $partial_days1,
                        'type' => 'LOP'
                             ])->count();

                        $explodetime1 = explode(' ', $starttime1);
                        $explodetime2 = explode(' ', $endtime1);
                        $arr = [
                            'employeeid' => $employeeid,
                            "from_date"=> substr($starttime1,0,10),
                            "to_date"=> substr($endtime1,0,10),
                            "leave_type"=> 'LOP',
                            "starttime"=> substr($explodetime1[1],0,5),
                            "endtime"=> substr($explodetime2[1],0,5)
                         ];
                        
                         $sentosap = 'Y';
                         /*DB::connection('mysql6')->table('send_sap_leave_details')->insert(['details' => json_encode($arr), 'created_datetime' => Carbon::now()->toDateTimeString()]);*/
                             Log::info('SAP LOP deduction sap error... '.$employeeid);
                        /*$is_updated_in_sap = $this->deduct_leave_forlate($arr);
                        if ($is_updated_in_sap['Status'] == 'Updated Successfully') {
                            $sentosap = 'Y';
                        }
                        else{
                            Log::info('SAP Late deduction sap error for LOP... '.$employeeid.' - Status: '.$is_updated_in_sap['Status'].' '.$newvalue['shift_startdatetime']);
                            $sentosap = 'N';
                        }*/

                        if($checkprev == 0){

                        $getready_process =  DB::connection('mysql6')->table('latededuction_finaltosap')
                        ->insert([
                            'employeeid' => $employeeid ,
                            'emp_name' => $json_decoded_data['Emp_Name'],
                            'role_code' => $json_decoded_data['Role_Code'],
                            'plant_code' => $json_decoded_data['Plant_Code'],
                            'position' => $json_decoded_data['Position'],
                            'department' => $json_decoded_data['Department'],
                            'cadre' => $json_decoded_data['Cadre'],
                            'month' => "$process_month", 
                            'year'=> "$process_year", 
                            'deduction_stdate_time'=> $starttime1, 
                            'deduction_etdate_time' => $endtime1,
                            'partial_days' => $partial_days1,
                            'type' => 'LOP',
                            'punchlist' => $punchlist,
                            'lms_applications' => $lmsapp,
                            'first_half_lop' => $newvalue['first_half_lop'],
                            'second_half_lop' => $newvalue['second_half_lop'],
                            'latecount' => $newvalue['latecount'],
                            'latein_hours' => $newvalue['latein_hours'],
                            'laterange1' => $newvalue['laterange1'],
                            'laterange2' => $newvalue['laterange2'],
                            'laterange3' => $newvalue['laterange3'],
                            'earlyoutcount' => $newvalue['earlyoutcount'],
                            'earlyout_hours' => $newvalue['earlyout_hours'],
                            'absent' => $newvalue['absent'],
                            'present' => $newvalue['present'],
                            'first_half_considered_punches' => $first_half_considered_punches_list,
                            'sento_sap' => $sentosap,
                            'sento_sapdate' => Carbon::now()->toDateTimeString()
                             ]);
                        }else{
                            $getready_process =  DB::connection('mysql6')->table('latededuction_finaltosap')->where(
                                [
                                    'employeeid' => $employeeid ,
                                    'month' => "$process_month", 
                                    'year'=> "$process_year", 
                                    'deduction_stdate_time'=> $starttime1, 
                                    'deduction_etdate_time' => $endtime1,
                                    'partial_days' => $partial_days1,
                                    'type' => 'LOP'
                                ]
                            )->update([
                                'sento_sap' => $sentosap,
                                'sento_sapdate' => Carbon::now()->toDateTimeString()
                            ]);
                        }
                    }
                    elseif((($newvalue['first_half_lop'] != 0) || ($newvalue['second_half_lop'] != 0)) && ($newvalue['absent'] != 0)){
                        $checkfirsthalf_lop = DB::connection('mysql6')->table('datetime_ref')->where(['employeeid' => $employeeid ,'month' => "$process_month",'year'=> "$process_year",'date'=>$newvalue['shift_date'],'partial_days'=>'first_half','type' => 'LOP'])->get();
                        $checksecondhalf_lop = DB::connection('mysql6')->table('datetime_ref')->where(['employeeid' => $employeeid ,'month' => "$process_month",'year'=> "$process_year",'date'=>$newvalue['shift_date'],'partial_days'=>'second_half','type' => 'LOP'])->get();

                        if((count($checkfirsthalf_lop) > 0) && (count($checksecondhalf_lop) > 0)){                           

                        $checkprev = DB::connection('mysql6')->table('latededuction_finaltosap')->where([
                        'employeeid' => $employeeid ,
                        'month' => "$process_month", 
                        'year'=> "$process_year", 
                        'deduction_stdate_time'=> $newvalue['shift_startdatetime'], 
                        'deduction_etdate_time' => $newvalue['shift_enddatetime'],
                        'partial_days' => 'full',
                        'type' => 'LOP'
                             ])->count();
                             $lop += 1;
                        $explodetime1 = explode(' ', $newvalue['shift_startdatetime']);
                        $explodetime2 = explode(' ', $newvalue['shift_enddatetime']);
                        $arr = [
                            'employeeid' => $employeeid,
                            "from_date"=> substr($newvalue['shift_startdatetime'],0,10),
                            "to_date"=> substr($newvalue['shift_startdatetime'],0,10),
                            "leave_type"=> 'LOP',
                            "starttime"=> '',
                            "endtime"=> ''
                         ];
                        
                         $sentosap = 'Y';
                         /*DB::connection('mysql6')->table('send_sap_leave_details')->insert(['details' => json_encode($arr), 'created_datetime' => Carbon::now()->toDateTimeString()]);*/
                             Log::info('SAP LOP deduction sap error... '.$employeeid);
                        /* $is_updated_in_sap = $this->deduct_leave_forlate($arr);
                        if ($is_updated_in_sap['Status'] == 'Updated Successfully') {
                            $sentosap = 'Y';
                        }
                        else{
                            Log::info('SAP Late deduction sap error for LOP... '.$employeeid.' - Status: '.$is_updated_in_sap['Status'].' '.$newvalue['shift_startdatetime']);
                            $sentosap = 'N';
                        }*/

                        if($checkprev == 0){

                        $getready_process =  DB::connection('mysql6')->table('latededuction_finaltosap')
                        ->insert([
                            'employeeid' => $employeeid ,
                            'emp_name' => $json_decoded_data['Emp_Name'],
                            'role_code' => $json_decoded_data['Role_Code'],
                            'plant_code' => $json_decoded_data['Plant_Code'],
                            'position' => $json_decoded_data['Position'],
                            'department' => $json_decoded_data['Department'],
                            'cadre' => $json_decoded_data['Cadre'],
                            'month' => "$process_month", 
                            'year'=> "$process_year", 
                            'deduction_stdate_time'=> $newvalue['shift_startdatetime'], 
                            'deduction_etdate_time' => $newvalue['shift_enddatetime'],
                            'partial_days' => 'full',
                            'type' => 'LOP',
                            'punchlist' => $punchlist,
                            'lms_applications' => $lmsapp,
                            'first_half_lop' => $newvalue['first_half_lop'],
                            'second_half_lop' => $newvalue['second_half_lop'],
                            'latecount' => $newvalue['latecount'],
                            'latein_hours' => $newvalue['latein_hours'],
                            'laterange1' => $newvalue['laterange1'],
                            'laterange2' => $newvalue['laterange2'],
                            'laterange3' => $newvalue['laterange3'],
                            'earlyoutcount' => $newvalue['earlyoutcount'],
                            'earlyout_hours' => $newvalue['earlyout_hours'],
                            'absent' => $newvalue['absent'],
                            'present' => $newvalue['present'],
                            'first_half_considered_punches' => $first_half_considered_punches_list,
                            'sento_sap' => $sentosap,
                            'sento_sapdate' => Carbon::now()->toDateTimeString()
                             ]);
                        }else{
                            $getready_process =  DB::connection('mysql6')->table('latededuction_finaltosap')->where(
                                [
                                    'employeeid' => $employeeid ,
                                    'month' => "$process_month", 
                                    'year'=> "$process_year", 
                                    'deduction_stdate_time'=> $newvalue['shift_startdatetime'], 
                                    'deduction_etdate_time' => $newvalue['shift_enddatetime'],
                                    'partial_days' => 'full',
                                    'type' => 'LOP'
                                ]
                            )->update([
                                'sento_sap' => $sentosap,
                                'sento_sapdate' => Carbon::now()->toDateTimeString()
                            ]);
                        }
                        
                        }
                        elseif((count($checkfirsthalf_lop) == 0) && (count($checksecondhalf_lop) > 0)){

                            $starttime1 = $newvalue['shift_startdatetime'];
                            $endtime1 = $newvalue['shift_enddatetime'];
                            $partial_days1 = 'first_half';
    
                            $getapplop = DB::connection('mysql6')->table('datetime_ref')->where(['employeeid' => $employeeid ,'month' => "$process_month",'year'=> "$process_year",'date'=>$newvalue['shift_date'],'type' => 'LOP'])->get();
                                    if(count($getapplop) > 0){
                                        foreach ($getapplop as $lkey => $lvalue) {
                                            $partial_half = $lvalue->partial_days;
                                        }
    
                                        if($partial_half == 'second_half'){
                                            $starttime1 = $midtime;
                                            $endtime1 = $newvalue['shift_enddatetime'];
                                            $partial_days1 = 'second_half';
                                            $lop += 0.5;

                                            //start
                                            $checkprev1 = DB::connection('mysql6')->table('latededuction_finaltosap')->where([
                                                'employeeid' => $employeeid ,
                                            'month' => "$process_month", 
                                            'year'=> "$process_year", 
                                            'deduction_stdate_time'=> $starttime1, 
                                            'deduction_etdate_time' => $endtime1,
                                            'partial_days' => $partial_days1,
                                            'type' => 'LOP'
                                                 ])->count();
                    
                                            $explodetime1 = explode(' ', $starttime1);
                                            $explodetime2 = explode(' ', $endtime1);
                                            $arr = [
                                                'employeeid' => $employeeid,
                                                "from_date"=> substr($starttime1,0,10),
                                                "to_date"=> substr($endtime1,0,10),
                                                "leave_type"=> 'LOP',
                                                "starttime"=> substr($explodetime1[1],0,5),
                                                "endtime"=> substr($explodetime2[1],0,5)
                                             ];
                                            
                                             $sentosap = 'Y';
                                             /*DB::connection('mysql6')->table('send_sap_leave_details')->insert(['details' => json_encode($arr), 'created_datetime' => Carbon::now()->toDateTimeString()]);*/
                             Log::info('SAP LOP deduction sap error... '.$employeeid);
                                            /*$is_updated_in_sap = $this->deduct_leave_forlate($arr);
                                            if ($is_updated_in_sap['Status'] == 'Updated Successfully') {
                                                $sentosap = 'Y';
                                            }
                                            else{
                                                Log::info('SAP Late deduction sap error for LOP... '.$employeeid.' - Status: '.$is_updated_in_sap['Status'].' '.$newvalue['shift_startdatetime']);
                                                $sentosap = 'N';
                                            }*/
                    
                                            if($checkprev1 == 0){
                    
                                            $getready_process1 =  DB::connection('mysql6')->table('latededuction_finaltosap')
                                            ->insert([
                                                'employeeid' => $employeeid ,
                                                'emp_name' => $json_decoded_data['Emp_Name'],
                                                'role_code' => $json_decoded_data['Role_Code'],
                                                'plant_code' => $json_decoded_data['Plant_Code'],
                                                'position' => $json_decoded_data['Position'],
                                                'department' => $json_decoded_data['Department'],
                                                'cadre' => $json_decoded_data['Cadre'],
                                                'month' => "$process_month", 
                                                'year'=> "$process_year", 
                                                'deduction_stdate_time'=> $starttime1, 
                                                'deduction_etdate_time' => $endtime1,
                                                'partial_days' => $partial_days1,
                                                'type' => 'LOP',
                                                'punchlist' => $punchlist,
                                                'lms_applications' => $lmsapp,
                                                'first_half_lop' => $newvalue['first_half_lop'],
                                                'second_half_lop' => $newvalue['second_half_lop'],
                                                'latecount' => $newvalue['latecount'],
                                                'latein_hours' => $newvalue['latein_hours'],
                                                'laterange1' => $newvalue['laterange1'],
                                                'laterange2' => $newvalue['laterange2'],
                                                'laterange3' => $newvalue['laterange3'],
                                                'earlyoutcount' => $newvalue['earlyoutcount'],
                                                'earlyout_hours' => $newvalue['earlyout_hours'],
                                                'absent' => $newvalue['absent'],
                                                'present' => $newvalue['present'],
                                                'first_half_considered_punches' => $first_half_considered_punches_list,
                                                'sento_sap' => $sentosap,
                                                'sento_sapdate' => Carbon::now()->toDateTimeString()
                                                 ]);
                                            }else{
                                                $getready_process1 =  DB::connection('mysql6')->table('latededuction_finaltosap')->where(
                                                    [
                                                        'employeeid' => $employeeid ,
                                                        'month' => "$process_month", 
                                                        'year'=> "$process_year", 
                                                        'deduction_stdate_time'=> $starttime1, 
                                                        'deduction_etdate_time' => $endtime1,
                                                        'partial_days' => $partial_days1,
                                                        'type' => 'LOP'
                                                    ]
                                                )->update([
                                                    'sento_sap' => $sentosap,
                                                    'sento_sapdate' => Carbon::now()->toDateTimeString()
                                                ]);
                                            }
                                            //end



                                        }
    
                                }
                            
                            if($newvalue['first_half_lop'] == 0.5){


                                $checkprev = DB::connection('mysql6')->table('latededuction_finaltosap')->where([
                                    'employeeid' => $employeeid ,
                                'month' => "$process_month", 
                                'year'=> "$process_year", 
                                'deduction_stdate_time'=> $newvalue['shift_startdatetime'], 
                                'deduction_etdate_time' => $midtime,
                                'partial_days' => 'first_half',
                                'type' => 'LATE'
                                     ])->count();
    
                                $explodetime1 = explode(' ', $newvalue['shift_startdatetime']);
                                $explodetime2 = explode(' ', $midtime);
                                $arr = [
                                    'employeeid' => $employeeid,
                                    "from_date"=> substr($newvalue['shift_startdatetime'],0,10),
                                    "to_date"=> substr($midtime,0,10),
                                    "leave_type"=> 'LATE',
                                    "starttime"=> substr($explodetime1[1],0,5),
                                    "endtime"=> substr($explodetime2[1],0,5)
                                 ];
                                
                                 $sentosap = 'Y';
                                 /*DB::connection('mysql6')->table('send_sap_leave_details')->insert(['details' => json_encode($arr), 'created_datetime' => Carbon::now()->toDateTimeString()]);*/
                             Log::info('SAP LATE deduction sap error... '.$employeeid);
                                 /*$is_updated_in_sap = $this->deduct_leave_forlate($arr);
                                 
                                 if ($is_updated_in_sap['Status'] == 'Updated Successfully') {
                                     $sentosap = 'Y';
                                 }
                                 else{
                                    Log::info('SAP Late deduction sap error... '.$employeeid.' - Status: '.$is_updated_in_sap['Status'].' '.$newvalue['shift_startdatetime']);
                                     $sentosap = 'N';
                                 }*/
    
                                 if($checkprev == 0){
    
                                $getready_process =  DB::connection('mysql6')->table('latededuction_finaltosap')
                            ->insert([
                                'employeeid' => $employeeid ,
                                'emp_name' => $json_decoded_data['Emp_Name'],
                                'role_code' => $json_decoded_data['Role_Code'],
                                'plant_code' => $json_decoded_data['Plant_Code'],
                                'position' => $json_decoded_data['Position'],
                                'department' => $json_decoded_data['Department'],
                                'cadre' => $json_decoded_data['Cadre'],
                                'month' => "$process_month", 
                                'year'=> "$process_year", 
                                'deduction_stdate_time'=> $newvalue['shift_startdatetime'], 
                                'deduction_etdate_time' => $midtime,
                                'partial_days' => 'first_half',
                                'type' => 'LATE',
                                'punchlist' => $punchlist,
                                'lms_applications' => $lmsapp,
                                'first_half_lop' => $newvalue['first_half_lop'],
                                'second_half_lop' => $newvalue['second_half_lop'],
                                'latecount' => $newvalue['latecount'],
                                'latein_hours' => $newvalue['latein_hours'],
                                'laterange1' => $newvalue['laterange1'],
                                'laterange2' => $newvalue['laterange2'],
                                'laterange3' => $newvalue['laterange3'],
                                'earlyoutcount' => $newvalue['earlyoutcount'],
                                'earlyout_hours' => $newvalue['earlyout_hours'],
                                'absent' => $newvalue['absent'],
                                'present' => $newvalue['present'],
                                'first_half_considered_punches' => $first_half_considered_punches_list,
                                'sento_sap' => $sentosap,
                                'sento_sapdate' => Carbon::now()->toDateTimeString()
                                 ]);
    
                                }
                                else
                                {
                                    $getready_process =  DB::connection('mysql6')->table('latededuction_finaltosap')->where(
                                        ['employeeid' => $employeeid ,
                                        'month' => "$process_month", 
                                        'year'=> "$process_year", 
                                        'deduction_stdate_time'=> $newvalue['shift_startdatetime'], 
                                        'deduction_etdate_time' => $midtime,
                                        'partial_days' => 'first_half',
                                        'type' => 'LATE']
                                    )->update([
                                        'sento_sap' => $sentosap,
                                        'sento_sapdate' => Carbon::now()->toDateTimeString()
                                    ]);
    
                                }
                                
                            }


                        }
                        elseif((count($checkfirsthalf_lop) > 0) && (count($checksecondhalf_lop) == 0)){

                            $starttime1 = $newvalue['shift_startdatetime'];
                            $endtime1 = $newvalue['shift_enddatetime'];
                            $partial_days1 = 'first_half';
    
                            $getapplop = DB::connection('mysql6')->table('datetime_ref')->where(['employeeid' => $employeeid ,'month' => "$process_month",'year'=> "$process_year",'date'=>$newvalue['shift_date'],'type' => 'LOP'])->get();
                                    if(count($getapplop) > 0){
                                        foreach ($getapplop as $lkey => $lvalue) {
                                            $partial_half = $lvalue->partial_days;
                                        }
    
                                        if($partial_half == 'first_half'){
                                            $starttime1 = $newvalue['shift_startdatetime'];
                                            $endtime1 = $midtime;
                                            $partial_days1 = 'first_half';
                                            $lop += 0.5;

                                            //start
                                            $checkprev1 = DB::connection('mysql6')->table('latededuction_finaltosap')->where([
                                                'employeeid' => $employeeid ,
                                            'month' => "$process_month", 
                                            'year'=> "$process_year", 
                                            'deduction_stdate_time'=> $starttime1, 
                                            'deduction_etdate_time' => $endtime1,
                                            'partial_days' => $partial_days1,
                                            'type' => 'LOP'
                                                 ])->count();
                    
                                            $explodetime1 = explode(' ', $starttime1);
                                            $explodetime2 = explode(' ', $endtime1);
                                            $arr = [
                                                'employeeid' => $employeeid,
                                                "from_date"=> substr($starttime1,0,10),
                                                "to_date"=> substr($endtime1,0,10),
                                                "leave_type"=> 'LOP',
                                                "starttime"=> substr($explodetime1[1],0,5),
                                                "endtime"=> substr($explodetime2[1],0,5)
                                             ];
                                            
                                             $sentosap = 'Y';
                                             /*DB::connection('mysql6')->table('send_sap_leave_details')->insert(['details' => json_encode($arr), 'created_datetime' => Carbon::now()->toDateTimeString()]);*/
                             Log::info('SAP LOP deduction sap error... '.$employeeid);
                                             /*$is_updated_in_sap = $this->deduct_leave_forlate($arr);
                                            if ($is_updated_in_sap['Status'] == 'Updated Successfully') {
                                                $sentosap = 'Y';
                                            }
                                            else{
                                                Log::info('SAP Late deduction sap error for LOP... '.$employeeid.' - Status: '.$is_updated_in_sap['Status'].' '.$newvalue['shift_startdatetime']);
                                                $sentosap = 'N';
                                            }*/
                    
                                            if($checkprev1 == 0){
                    
                                            $getready_process1 =  DB::connection('mysql6')->table('latededuction_finaltosap')
                                            ->insert([
                                                'employeeid' => $employeeid ,
                                                'emp_name' => $json_decoded_data['Emp_Name'],
                                                'role_code' => $json_decoded_data['Role_Code'],
                                                'plant_code' => $json_decoded_data['Plant_Code'],
                                                'position' => $json_decoded_data['Position'],
                                                'department' => $json_decoded_data['Department'],
                                                'cadre' => $json_decoded_data['Cadre'],
                                                'month' => "$process_month", 
                                                'year'=> "$process_year", 
                                                'deduction_stdate_time'=> $starttime1, 
                                                'deduction_etdate_time' => $endtime1,
                                                'partial_days' => $partial_days1,
                                                'type' => 'LOP',
                                                'punchlist' => $punchlist,
                                                'lms_applications' => $lmsapp,
                                                'first_half_lop' => $newvalue['first_half_lop'],
                                                'second_half_lop' => $newvalue['second_half_lop'],
                                                'latecount' => $newvalue['latecount'],
                                                'latein_hours' => $newvalue['latein_hours'],
                                                'laterange1' => $newvalue['laterange1'],
                                                'laterange2' => $newvalue['laterange2'],
                                                'laterange3' => $newvalue['laterange3'],
                                                'earlyoutcount' => $newvalue['earlyoutcount'],
                                                'earlyout_hours' => $newvalue['earlyout_hours'],
                                                'absent' => $newvalue['absent'],
                                                'present' => $newvalue['present'],
                                                'first_half_considered_punches' => $first_half_considered_punches_list,
                                                'sento_sap' => $sentosap,
                                                'sento_sapdate' => Carbon::now()->toDateTimeString()
                                                 ]);
                                            }else{
                                                $getready_process1 =  DB::connection('mysql6')->table('latededuction_finaltosap')->where(
                                                    [
                                                        'employeeid' => $employeeid ,
                                                        'month' => "$process_month", 
                                                        'year'=> "$process_year", 
                                                        'deduction_stdate_time'=> $starttime1, 
                                                        'deduction_etdate_time' => $endtime1,
                                                        'partial_days' => $partial_days1,
                                                        'type' => 'LOP'
                                                    ]
                                                )->update([
                                                    'sento_sap' => $sentosap,
                                                    'sento_sapdate' => Carbon::now()->toDateTimeString()
                                                ]);
                                            }
                                            //end



                                        }
    
                                }

                            if($newvalue['second_half_lop'] == 0.5){
                                
                                $checkprev = DB::connection('mysql6')->table('latededuction_finaltosap')->where([
                                    'employeeid' => $employeeid ,
                                'month' => "$process_month", 
                                'year'=> "$process_year", 
                                'deduction_stdate_time'=> $midtime, 
                                'deduction_etdate_time' => $newvalue['shift_enddatetime'],
                                'partial_days' => 'second_half',
                                'type' => 'LATE'
                                     ])->count();
                                     
                                $explodetime1 = explode(' ', $midtime);
                                $explodetime2 = explode(' ', $newvalue['shift_enddatetime']);
                                $arr = [
                                    'employeeid' => $employeeid,
                                    "from_date"=> substr($midtime,0,10),
                                    "to_date"=> substr($newvalue['shift_enddatetime'],0,10),
                                    "leave_type"=> 'LATE',
                                    "starttime"=> substr($explodetime1[1],0,5),
                                    "endtime"=> substr($explodetime2[1],0,5)
                                 ];
                                
                                 $sentosap = 'Y';
                                 /*DB::connection('mysql6')->table('send_sap_leave_details')->insert(['details' => json_encode($arr), 'created_datetime' => Carbon::now()->toDateTimeString()]);*/
                             Log::info('SAP LATE deduction sap error... '.$employeeid);
                                 /*$is_updated_in_sap = $this->deduct_leave_forlate($arr);
                                 if ($is_updated_in_sap['Status'] == 'Updated Successfully') {
                                     $sentosap = 'Y';
                                 }
                                 else{
                                    Log::info('SAP Late deduction sap error... '.$employeeid.' - Status: '.$is_updated_in_sap['Status'].' '.$newvalue['firsth_end_sech_starttime']);
                                     $sentosap = 'N';
                                 }*/
    
                                 if($checkprev == 0){
                                    $getready_process =  DB::connection('mysql6')->table('latededuction_finaltosap')
                                    ->insert([
                                        'employeeid' => $employeeid ,
                                        'emp_name' => $json_decoded_data['Emp_Name'],
                                        'role_code' => $json_decoded_data['Role_Code'],
                                        'plant_code' => $json_decoded_data['Plant_Code'],
                                        'position' => $json_decoded_data['Position'],
                                        'department' => $json_decoded_data['Department'],
                                        'cadre' => $json_decoded_data['Cadre'],
                                        'month' => "$process_month", 
                                        'year'=> "$process_year", 
                                        'deduction_stdate_time'=> $midtime, 
                                        'deduction_etdate_time' => $newvalue['shift_enddatetime'],
                                        'partial_days' => 'second_half',
                                        'type' => 'LATE',
                                        'punchlist' => $punchlist,
                                        'lms_applications' => $lmsapp,
                                        'first_half_lop' => $newvalue['first_half_lop'],
                                        'second_half_lop' => $newvalue['second_half_lop'],
                                        'latecount' => $newvalue['latecount'],
                                        'latein_hours' => $newvalue['latein_hours'],
                                        'laterange1' => $newvalue['laterange1'],
                                        'laterange2' => $newvalue['laterange2'],
                                        'laterange3' => $newvalue['laterange3'],
                                        'earlyoutcount' => $newvalue['earlyoutcount'],
                                        'earlyout_hours' => $newvalue['earlyout_hours'],
                                        'absent' => $newvalue['absent'],
                                        'present' => $newvalue['present'],
                                        'first_half_considered_punches' => $first_half_considered_punches_list,
                                        'sento_sap' => $sentosap,
                                        'sento_sapdate' => Carbon::now()->toDateTimeString()
                                         ]);
                                 }
                                 else{
                                    $getready_process =  DB::connection('mysql6')->table('latededuction_finaltosap')->where(
                                        ['employeeid' => $employeeid ,
                                        'month' => "$process_month", 
                                        'year'=> "$process_year", 
                                        'deduction_stdate_time'=> $midtime, 
                                        'deduction_etdate_time' => $newvalue['shift_enddatetime'],
                                        'partial_days' => 'second_half',
                                        'type' => 'LATE']
                                    )->update([
                                        'sento_sap' => $sentosap,
                                        'sento_sapdate' => Carbon::now()->toDateTimeString()
                                    ]);
                                 }
    
                               
                            }
                        }
                        else{

                        }
                        
                    }
                    else{

                    }
                }
                //ended
                DB::connection('mysql6')->table('leave_balance')->where([
                    'employeeid' => $employeeid, 'month' => $process_month, 'year' =>$process_year
                ])->update([
                    'LOP' => $lop,
                    'Present' => $present,
                    'Absent' => $absent,
                    'late_count' => $latecount,
                    'early_out_count' => $earlyoutcount,
                    'completed' => 'Y'
                ]);

                //send to sap one shot
            $getinserteddata =  DB::connection('mysql6')->table('leave_balance')->where(['employeeid' =>$employeeid ,'month' => "$process_month", 'year'=> "$process_year" ])->get();
            $arr = [];
            if(count($getinserteddata) > 0){
                $arr = [];
                    if($getinserteddata[0]->Onduty == null){ $getinserteddata[0]->Onduty = ''; }
                    if($getinserteddata[0]->Tour == null){ $getinserteddata[0]->Tour = ''; }
                    if($getinserteddata[0]->Compoff == null){ $getinserteddata[0]->Compoff = ''; }
                    if($getinserteddata[0]->Mispunch == null){ $getinserteddata[0]->Mispunch = ''; }
                    
                    $arr['Leave_Details'] = [ "Employee_ID"=> $getinserteddata[0]->employeeid,
		"Month"=> $getinserteddata[0]->month,
		"Year"=> $getinserteddata[0]->year,
		"CL"=> $getinserteddata[0]->CL,
		"SL"=> $getinserteddata[0]->SL,
		"PL"=> $getinserteddata[0]->PL,
		"ML"=> $getinserteddata[0]->ML,
		"RH"=> $getinserteddata[0]->RH,
		"Permission"=> $getinserteddata[0]->Permission,
		"OnDuty"=> $getinserteddata[0]->Onduty,
		"Tour"=> $getinserteddata[0]->Tour,
		"Comp_Off"=> $getinserteddata[0]->Compoff,
		"Miss_Punch"=> $getinserteddata[0]->Mispunch,
		"Present"=> $getinserteddata[0]->Present,
		"LOP"=> $getinserteddata[0]->LOP,
		"Absent"=> $getinserteddata[0]->Absent,
		"Late_Count"=> $getinserteddata[0]->late_count,
		"Total_Late_Hours"=> $getinserteddata[0]->total_late_hours,
		"Early_Out_Count"=> $getinserteddata[0]->early_out_count,
		"Total_Early_Out_Hours"=>$getinserteddata[0]->total_early_out_hours,
        "Completed"=> 'Y' ];
                $bulkinsert = $this->bulkinsertleave_balance($arr);
            }
                


                DB::connection('mysql6')->table('lateacrual_process')->where(['employeeid' => $employeeid, 'month' => "$process_month", 'year' =>"$process_year"  ])->update([
                    'processed' => 'Y',
                    'last_processed_date' => Carbon::now()->toDateTimeString()
                ]);
            
                } 
        }
                //script end
                
            

                

    }

    public function load_data_for_accrualprocess()
    {
        $getcurrent_datetime = Carbon::now()->toDateTimeString();
        $startofmonth = Carbon::now()->startOfMonth()->toDateString();
        $getcurrenddate = Carbon::now()->toDateString();

        if($getcurrenddate == $startofmonth){
            if((Carbon::parse($getcurrent_datetime)->gte(Carbon::parse($getcurrenddate.' 05:00:00'))) && (Carbon::parse($getcurrent_datetime)->lte(Carbon::parse($getcurrenddate.' 05:10:00'))) )
            {
                //script start
                $getactiveemployees = $this->getallactiveemployees();
        $empid_to_process = [];
        foreach ($getactiveemployees['Details'] as $key => $value) {
            $securities = ['SCT_TM(PLANT)','SCT_TM(REG)'];
            $avoid_emp_ids = ['200577'];
	$position = ['SECURITY GUARDS', 'SECURITY OFFICER','ASSISTANT SECURITY OFFICER','ASSISTANT SECURITY OFFICE','GARDNER','HOUSE KEEPER','SCAVENGER','GYM TRAINER','PAINTER','DRIVER FOR HEAVY VEHICLES','NON TECHNICAL NMR','DRIVER FOR LIGHT VEHICLES', 'NON TECHNICAL NMR', 'PIPELINE HELPER5', 'HELPER NMR', 'EXECUTION HELPER NMR', 'Execution Helper', 'EHS HELPER'];
            if(!(in_array($value['Role_Code'], $securities)) && !(in_array($value['Position'], $position)) && !(in_array($value['Emp_ID'], $avoid_emp_ids)) && ($value['OnContract'] != 'C') && ($value['OnNotice'] != 'N') ){
                $empid_to_process[] = $value;
            }
        }

        $process_month = Carbon::parse($getcurrenddate)->format('m');
        $process_year = Carbon::parse($getcurrenddate)->format('Y');

        foreach ($empid_to_process as $leavekey => $leavevalue) {
            $getready_process =  DB::connection('mysql6')->table('leave_balance_acrual_process')->where(['employeeid'=>$leavevalue['Emp_ID'], 'month' => "$process_month", 'year'=> "$process_year",'processed'=>'N' ])->get();
            if (count($getready_process) == 0) {
                echo 'Feeding Employee - '.$leavevalue['Emp_ID'].' , Name - '.$leavevalue['Emp_Name'].'<br>';
                DB::connection('mysql6')->table('leave_balance_acrual_process')->insert(
                    ['employeeid'=> $leavevalue['Emp_ID'],
                     'emp_name' => $leavevalue['Emp_Name'],
                     'role_code' => $leavevalue['Role_Code'],
                     'plant_code' => $leavevalue['Plant_Code'],
                     'position' => $leavevalue['Position'],
                     'department' => $leavevalue['Department'],
                     'cadre' => $leavevalue['Cadre'],
                     'doj' => $leavevalue['DOJ'],
                     'month' => "$process_month",
                     'year'=> "$process_year",                     
                     'active_details' => json_encode($leavevalue),
                     'processed'=>'N',
                     'last_processed_date' => Carbon::now()->toDateTimeString()
                      ]);    
            }

        }
                //script end
            }
        }
    }

    public function leave_balance_accrual(){

        $getcurrent_datetime = Carbon::now()->toDateTimeString();
        $startofmonth = Carbon::now()->startOfMonth()->toDateString();
        $getcurrenddate = Carbon::now()->toDateString();

        if($startofmonth == $getcurrenddate){
            //05:15 -5:25
            if((Carbon::parse($getcurrent_datetime)->gte(Carbon::parse($getcurrenddate.' 05:15:00'))) && (Carbon::parse($getcurrent_datetime)->lte(Carbon::parse($getcurrenddate.' 05:25:00'))) )
            {
                
                //script start
                $now = Carbon::now()->toDateString();
            $process_month = Carbon::parse($getcurrenddate)->subDays(10)->format('m');
            $process_year = Carbon::parse($getcurrenddate)->subDays(10)->format('Y');
            $currentmonth = Carbon::now()->format('m');
            $currentyear = Carbon::now()->format('Y');
            $getready_process =  DB::connection('mysql6')->table('leave_balance_acrual_process')->where(['month' => "$currentmonth", 'year'=> "$currentyear",'processed'=>'N' ])->get();
            if(count($getready_process) > 0){
                foreach ($getready_process as $key => $value) {
                $employeeid = $value->employeeid;
                $dateofjoin = $value->doj;
                $add12months = Carbon::parse($dateofjoin)->addMonths(12)->toDateString();
                $getprevious_leavebal =  DB::connection('mysql6')->table('leave_balance')->where(['employeeid' => $employeeid,'month' => "$process_month", 'year'=> "$process_year" ])->get();

                /** new start el logic code */
                $doj1 = $value->doj;
                $addoneyr1 = Carbon::parse($doj1)->addYears(1)->toDateString();
           
                $getprev_month_16th_date = Carbon::parse($getcurrenddate)->subMonth()->startOfMonth()->addDays(15)->toDateString(); 
                $settocurrent_month_15th_date = Carbon::parse($getcurrenddate)->startOfMonth()->addDays(14)->toDateString();
                /** new end el logic code */

                //dd($add12months);
                if (count($getprevious_leavebal) > 0) {
                    $el = $getprevious_leavebal[0]->PL;
                    if($process_month == 12){

                        /**new start el logic code */
                         //echo '<h2>EL Encashment action processed</h2>';
                if (($addoneyr1 >= $getprev_month_16th_date) && ($addoneyr1 <= $settocurrent_month_15th_date)) {
                    $eltocreditintable = 12;
                    $currentelbalance = $el;
                    $encashmenttable = 0;
                }
                else{
                    if (Carbon::parse($addoneyr1)->gt(Carbon::parse($settocurrent_month_15th_date))) {
                        $eltocreditintable = 0;
                        $currentelbalance = $el;
                        $encashmenttable = 0;
                    }
                    else{
                        if ((Carbon::parse($addoneyr1)->format('m') == 12) && (Carbon::parse($addoneyr1)->format('Y') == $process_year)) {
                            $eltocreditintable = $el;
                            $currentelbalance = $el;
                            $encashmenttable = 0;
                        }
                        else{
                            if ((Carbon::parse($getcurrenddate)->format('m') == '01')) {
                                //oct - 10
                                //bal - 12
                                $startdate = Carbon::parse($process_year.'-01-01');
                                $endate = Carbon::parse($process_year.'11-01')->endOfMonth();

                                if ((Carbon::parse($addoneyr1)->gte($startdate)) && (Carbon::parse($addoneyr1)->lte($endate))) {
                                    
                                    $getencashpluscredit = 12 - Carbon::parse($addoneyr1)->format('m');
                                    $actualbal = $el + $getencashpluscredit;
                                    if($actualbal > 12){
                                        $encashmenttable = $actualbal - 12;
                                        $eltocreditintable = 12;
                                    }
                                    else{
                                        $encashmenttable = 0;
                                        $eltocreditintable = $actualbal;
                                    }
                                }
                                else{
                                        $encashmenttable = $el;
                                        $eltocreditintable = 12;
                                }
                            }
                           
                        }
                        
                    }
                }

                $pltoadd = $eltocreditintable;
                // $checkencashable = DB::connection('mysql6')->table('el_encashment')->where(['employeeid' => $value->employeeid ])->get();
                // if (count($checkencashable) > 0) {
                //     $getencashable = DB::connection('mysql6')->table('el_encashment')->where(['employeeid' => $value->employeeid ])->get();
                //     foreach ($getencashable as $encashkey => $encashvalue) {
                //         $prev_encash = $encashvalue->current_encashment;
                //     }
                //     DB::connection('mysql6')->table('el_encashment')->where(['employeeid' => $value->employeeid ])->update([
                //         'current_encashment' => $prev_encash + $encashmenttable,
                //         'last_updated_year' => $process_year,
                //         'last_updated_datetime' => Carbon::now()->toDateTimeString()
                //     ]);

                //     //DB::connection('mysql6')->table('leave_balance')->where(['employeeid' => $value->employeeid,'month' => $current_month,'year' ])->get();
                // }
                // else{
                //     DB::connection('mysql6')->table('el_encashment')->where(['employeeid' => $value->employeeid ])->insert([
                //         'employeeid' => $value->employeeid,
                //         'inital_loaded' => 0,
                //         'encashment_taken' => $encashmenttable,
                //         'last_el_bal_available' => $el,
                //         'last_updated_year' => $process_year,
                //         'el_credited_to_next_year' => $eltocreditintable,
                //         'last_updated_datetime' => Carbon::now()->toDateTimeString()
                //     ]);
                // }

                DB::connection('mysql6')->table('el_encashment')->insert([
                    'employeeid' => $value->employeeid,
                    'encashment_taken' => $encashmenttable,
                    'last_el_bal_available' => $el,
                    'last_updated_year' => $process_year,
                    'el_credited_to_next_year' => $eltocreditintable,
                    'last_updated_datetime' => Carbon::now()->toDateTimeString()
                ]);
                        /**new end el logic code */


                        if ((Carbon::parse($dateofjoin)->format('m') == $process_month) && (Carbon::parse($dateofjoin)->format('Y') == $process_year)) {
                            $nenddate = Carbon::parse($process_year.'-'.$process_month.'-01')->endOfMonth()->toDateString();
                            $diff = $this->formatforempdat_differbtwtwodates($dateofjoin, $nenddate);
                            if($diff < 15){
                                $cltoadd = 0.5; 
                                $sltoadd = 0.5; 
                                $pltoadd = 0; 
                                $mltoadd = 0;
                            }
                            else{
                                $cltoadd = 1;
                                $sltoadd = 1; 
                                $pltoadd = 0; 
                                $mltoadd = 0;
                            }
                            $permissiontoadd = 2;
                        }
                        else{

                        $getcl = 1;
                        if(($getprevious_leavebal[0]->SL >= 24) || ($getprevious_leavebal[0]->SL >= 23.5)){
                            $getsl = 24;
                        }
                        else{
                            $getsl = $getprevious_leavebal[0]->SL + 1;
                        }
                        
                        $getml = $getprevious_leavebal[0]->ML;
                        $getpl = $getprevious_leavebal[0]->PL;

                        $cltoadd = $getcl;
                        $sltoadd = $getsl;
                        $mltoadd = $getml;
                        //$pltoadd = $getpl;
                        $pltoadd = $pltoadd;
                        $permissiontoadd = 2;
                        }
                    }
                    else{


                        /** new start el logic code */
                         //echo '<h2>EL Encashment action not processed</h2>';
                if (($addoneyr1 >= $getprev_month_16th_date) && ($addoneyr1 <= $settocurrent_month_15th_date)) {
                    $eltocreditintable = 12;
                    $currentelbalance = $el;
                    $encashmenttable = 0;
            }
            else{
                if (Carbon::parse($addoneyr1)->gt(Carbon::parse($settocurrent_month_15th_date))) {
                    $eltocreditintable = 0;
                    $currentelbalance = $el;
                    $encashmenttable = 0;
                }
                else{
                    $eltocreditintable = 0;
                    $currentelbalance = $el;
                    $encashmenttable = $el;
                }
            }

            if ($eltocreditintable != 0) {
                $pltoadd = $eltocreditintable;
            }
            else{
                $pltoadd = $currentelbalance;
            }
                        /** new end el logic code */


                        if ((Carbon::parse($dateofjoin)->format('m') == $process_month) && (Carbon::parse($dateofjoin)->format('Y') == $process_year)) {
                            $nenddate = Carbon::parse($process_year.'-'.$process_month.'-01')->endOfMonth()->toDateString();
                            $diff = $this->formatforempdat_differbtwtwodates($dateofjoin, $nenddate);
                            if($diff < 15){
                                $cltoadd = 0.5; 
                                $sltoadd = 0.5; 
                                $pltoadd = 0; 
                                $mltoadd = 0;
                            }
                            else{
                                $cltoadd = 1;
                                $sltoadd = 1; 
                                $pltoadd = 0; 
                                $mltoadd = 0;
                            }
                            $permissiontoadd = 2;
                        }
                        else{

                        $getcl = $getprevious_leavebal[0]->CL;
                        
                        if(($getprevious_leavebal[0]->SL >= 24) || ($getprevious_leavebal[0]->SL >= 23.5)){
                            $getsl = 24;
                        }
                        else{
                            $getsl = $getprevious_leavebal[0]->SL + 1;
                        }

                        $getml = $getprevious_leavebal[0]->ML;
                        $getpl = $getprevious_leavebal[0]->PL;

                        $cltoadd = $getcl + 1;
                        $sltoadd = $getsl;
                        $mltoadd = $getml;
                        //$pltoadd = $getpl;
                        $pltoadd = $pltoadd;
                        $permissiontoadd = 2;

                        }

                    }

                    DB::connection('mysql6')->table('leave_balance')->insert([
                        'employeeid' => $employeeid, 
                        'month' => "$currentmonth", 
                        'year' => "$currentyear", 
                        'CL' => $cltoadd, 
                        'SL' => $sltoadd, 
                        'PL' => $pltoadd, 
                        'ML' => $mltoadd, 
                        'RH' => 0, 
                        'Permission' => $permissiontoadd, 
                        'Onduty' => null, 
                        'Tour' => null, 
                        'Compoff' => null, 
                        'Mispunch' => null, 
                        'Present' => 0, 
                        'LOP' => 0, 
                        'Absent' => 0, 
                        'late_count' => 0, 
                        'total_late_hours' => 0, 
                        'early_out_count' => 0, 
                        'total_early_out_hours' => 0, 
                        'completed' => 'N'
                        ]);

                        DB::connection('mysql6')->table('leave_balance_acrual_process')->where(['employeeid' => $employeeid, 'month' => "$currentmonth", 'year' => "$currentyear" ])->update([
                            'processed' => 'Y',
                            'last_processed_date' => Carbon::now()->toDateTimeString()
                        ]);


                }
                else{

                    //new joinee
                    if($process_month == 12){


                        if ((Carbon::parse($dateofjoin)->format('m') == $process_month) && (Carbon::parse($dateofjoin)->format('Y') == $process_year)) {
                            $nenddate = Carbon::parse($process_year.'-'.$process_month.'-01')->endOfMonth()->toDateString();
                            $diff = $this->formatforempdat_differbtwtwodates($dateofjoin, $nenddate);
                            if($diff < 15){
                                $cltoadd = 0.5; 
                                $sltoadd = 0.5; 
                                $pltoadd = 0; 
                                $mltoadd = 0;
                            }
                            else{
                                $cltoadd = 1;
                                $sltoadd = 1; 
                                $pltoadd = 0; 
                                $mltoadd = 0;
                            }
                            $permissiontoadd = 2;
                        }
                        else{

                        $getcl = 1;
                        if(($getprevious_leavebal[0]->SL >= 24) || ($getprevious_leavebal[0]->SL >= 23.5)){
                            $getsl = 24;
                        }
                        else{
                            $getsl = $getprevious_leavebal[0]->SL + 1;
                        }
                        
                        $getml = $getprevious_leavebal[0]->ML;
                        $getpl = $getprevious_leavebal[0]->PL;

                        $cltoadd = $getcl;
                        $sltoadd = $getsl;
                        $mltoadd = $getml;
                        $pltoadd = $getpl;
                        $permissiontoadd = 2;
                        }
                    }
                    else{


                        if ((Carbon::parse($dateofjoin)->format('m') == $process_month) && (Carbon::parse($dateofjoin)->format('Y') == $process_year)) {
                            $nenddate = Carbon::parse($process_year.'-'.$process_month.'-01')->endOfMonth()->toDateString();
                            $diff = $this->formatforempdat_differbtwtwodates($dateofjoin, $nenddate);
                            if($diff < 15){
                                $cltoadd = 0.5; 
                                $sltoadd = 0.5; 
                                $pltoadd = 0; 
                                $mltoadd = 0;
                            }
                            else{
                                $cltoadd = 1;
                                $sltoadd = 1; 
                                $pltoadd = 0; 
                                $mltoadd = 0;
                            }
                            $permissiontoadd = 2;
                        }
                        else{

                            if(empty($getprevious_leavebal[0]))
                            {
                                Log::info('Leave Balance not added for Emp ID:'.$employeeid);
                                continue;
                            }
                            
                        $getcl = $getprevious_leavebal[0]->CL;
                        
                        if(($getprevious_leavebal[0]->SL >= 24) || ($getprevious_leavebal[0]->SL >= 23.5)){
                            $getsl = 24;
                        }
                        else{
                            $getsl = $getprevious_leavebal[0]->SL + 1;
                        }

                        $getml = $getprevious_leavebal[0]->ML;
                        $getpl = $getprevious_leavebal[0]->PL;

                        $cltoadd = $getcl + 1;
                        $sltoadd = $getsl;
                        $mltoadd = $getml;
                        $pltoadd = $getpl;
                        $permissiontoadd = 2;

                        }

                    }

                    DB::connection('mysql6')->table('leave_balance')->insert([
                        'employeeid' => $employeeid, 
                        'month' => "$currentmonth", 
                        'year' => "$currentyear", 
                        'CL' => $cltoadd, 
                        'SL' => $sltoadd, 
                        'PL' => $pltoadd, 
                        'ML' => $mltoadd, 
                        'RH' => 0, 
                        'Permission' => $permissiontoadd, 
                        'Onduty' => null, 
                        'Tour' => null, 
                        'Compoff' => null, 
                        'Mispunch' => null, 
                        'Present' => 0, 
                        'LOP' => 0, 
                        'Absent' => 0, 
                        'late_count' => 0, 
                        'total_late_hours' => 0, 
                        'early_out_count' => 0, 
                        'total_early_out_hours' => 0, 
                        'completed' => 'N'
                        ]);

                        DB::connection('mysql6')->table('leave_balance_acrual_process')->where(['employeeid' => $employeeid, 'month' => "$currentmonth", 'year' => "$currentyear" ])->update([
                            'processed' => 'Y',
                            'last_processed_date' => Carbon::now()->toDateTimeString()
                        ]);
                        
                        //new joinee



                }
            }

            //send to sap one shot
            $getinserteddata =  DB::connection('mysql6')->table('leave_balance')->where(['month' => "$currentmonth", 'year'=> "$currentyear" ])->get();
            $arr = [];
            if(count($getinserteddata) > 0){
                foreach ($getinserteddata as $newkey => $newvalue) {
                    $arr['Leave_Details'][] = [ "Employee_ID"=> $newvalue->employeeid,
            "Month"=> $newvalue->month,
            "Year"=> $newvalue->year,
            "CL"=> $newvalue->CL,
            "SL"=> $newvalue->SL,
            "PL"=> $newvalue->PL,
            "ML"=> $newvalue->ML,
            "RH"=> $newvalue->RH,
            "Permission"=> $newvalue->Permission,
            "OnDuty"=> '',
            "Tour"=> '',
            "Comp_Off"=> '',
            "Miss_Punch"=> '',
            "Present"=> 0,
            "LOP"=> 0,
            "Absent"=> 0,
            "Late_Count"=> 0,
            "Total_Late_Hours"=> 0,
            "Early_Out_Count"=> 0,
            "Total_Early_Out_Hours"=> 0,
            "Completed"=> 'N' ];
                }
                $bulkinsert = $this->bulkinsertleave_balance($arr);
                if($bulkinsert['Status'] == 'Updated Successfully'){
                    Log::info('LMS Leave Balance Pushed to SAP... ');
                }
                else{
                    Log::info('LMS Error Leave Balance not pushed to SAP... ');
                }
            }
            
        }
                //script end
            }
        }
        
    }

   
    public function daily_process_load_data_for_late_deduction()
    {
        $getcurrent_datetime = Carbon::now()->toDateTimeString();
        $startofmonth = Carbon::now()->startOfMonth()->toDateString();
        $getcurrenddate = Carbon::now()->toDateString();
		

        $process = DB::connection('mysql6')->table('daily_lateprocess_iniate')->where(['process_iniated' => 1])->get();
        if(count($process) > 0){
            foreach ($process as $lokey => $lovalue) {
                $load_starttime = $lovalue->loadtime_start;
                $load_endtime = $lovalue->loadtime_end;    
            }
			
			
            
        	
            if((Carbon::parse($getcurrent_datetime)->gte(Carbon::parse($load_starttime))) && (Carbon::parse($getcurrent_datetime)->lte(Carbon::parse($load_endtime))) )
            {
				
                DB::connection('mysql6')->table('daily_lateacrual_process')->truncate();
                DB::connection('mysql6')->table('daily_latededuction_table')->truncate();
                DB::connection('mysql6')->table('daily_late_scriptprocess')->where('id','=', 1)->update(['split_run_completed' => 1, 'overal_completed' => 0]);
                

                //start
                $getactiveemployees = $this->getallactiveemployees();
				
        $empid_to_process = [];
        foreach ($getactiveemployees['Details'] as $key => $value) {
            $securities = ['SCT_TM(PLANT)','SCT_TM(REG)'];
            $avoid_emp_ids = ['200577','100000','100237'];
		$position = ['SECURITY GUARDS', 'SECURITY OFFICER','ASSISTANT SECURITY OFFICER','ASSISTANT SECURITY OFFICE','GARDNER','HOUSE KEEPER','SCAVENGER','GYM TRAINER','PAINTER','DRIVER FOR HEAVY VEHICLES','NON TECHNICAL NMR','DRIVER FOR LIGHT VEHICLES'];
            if(!(in_array($value['Role_Code'], $securities)) && !(in_array($value['Position'], $position)) && !(in_array($value['Emp_ID'], $avoid_emp_ids)) && ($value['OnContract'] != 'C') && ($value['OnNotice'] != 'N') ){
                $empid_to_process[] = $value;
            }
        }

        $process_month = Carbon::parse($getcurrenddate)->subDays(1)->format('m');
        $process_year = Carbon::parse($getcurrenddate)->subDays(1)->format('Y');
        foreach ($empid_to_process as $latekey => $latevalue) {
                
            $getready_process =  DB::connection('mysql6')->table('daily_lateacrual_process')->where(['employeeid'=>$latevalue['Emp_ID'], 'month' => $process_month, 'year'=> $process_year,'processed'=>'N' ])->get();
			
            if (count($getready_process) == 0) {
                echo 'Feeding Employee - '.$latevalue['Emp_ID'].' , Name - '.$latevalue['Emp_Name'].'<br>';
                DB::connection('mysql6')->table('daily_lateacrual_process')->insert(
                    ['employeeid'=>$latevalue['Emp_ID'],
                     'emp_name' => $latevalue['Emp_Name'],
                     'role_code' => $latevalue['Role_Code'],
                     'plant_code' => $latevalue['Plant_Code'],
                     'position' => $latevalue['Position'],
                     'department' => $latevalue['Department'],
                     'cadre' => $latevalue['Cadre'],
                     'doj' => $latevalue['DOJ'],
                     'month' => $process_month,
                     'year'=>$process_year,                     
                     'active_details' => json_encode($latevalue),
                     'processed'=>'N',
                     'last_processed_date' => Carbon::now()->toDateTimeString()
                      ]);    
            }

        }
                //end
            }
        }
        

    }

    public function latescriptrun()
    {
        $getcurrent_datetime = Carbon::now()->toDateTimeString();
        $startofmonth = Carbon::now()->startOfMonth()->toDateString();
        $getcurrenddate = Carbon::now()->toDateString();

        $process = DB::connection('mysql6')->table('daily_lateprocess_iniate')->where(['process_iniated' => 1])->get();
        if(count($process) > 0){
            foreach ($process as $lokey => $lovalue) {
                $load_starttime = $lovalue->laterun_time_start;
                $load_endtime = $lovalue->laterun_time_end;    
            }
        	//dd($load_starttime.' '.$load_endtime);
            if((Carbon::parse($getcurrent_datetime)->gte(Carbon::parse($load_starttime))) && (Carbon::parse($getcurrent_datetime)->lte(Carbon::parse($load_endtime))) )
            {
				//dd('ok');
                $getdailyprocess = DB::connection('mysql6')->table('daily_late_scriptprocess')->where(['split_run_completed' => 1,'overal_completed' => 0])->get();

                if(count($getdailyprocess) > 0){
                    
                    $this->daily_process_lateprocess_accrual();
                }

            }

        }
	else{
            echo 'No Data to Process Latescript run!';
        }
        
    }

    public function testinglms()
    {
        $attendance = $this->nn_daily_newattendancesummary('100032', "08", "2018");
        dd($attendance);
    }
    
    public function daily_process_lateprocess_accrual()
    {
        $getcurrent_datetime = Carbon::now()->toDateTimeString();
        $startofmonth = Carbon::now()->startOfMonth()->toDateString();
        $getcurrenddate = Carbon::now()->toDateString();

            
                //script start
        $process_month = Carbon::parse($getcurrenddate)->subDays(1)->format('m');
        $process_year = Carbon::parse($getcurrenddate)->subDays(1)->format('Y');
        $getready_process =  DB::connection('mysql6')->table('daily_lateacrual_process')->where(['month' => "$process_month", 'year'=> "$process_year",'processed'=>'N' ])->take(3)->get();
        
        if (count($getready_process) > 0) {
            DB::connection('mysql6')->table('daily_late_scriptprocess')->where(['id' => 1  ])->update(['split_run_completed' => 0, 'overal_completed' => 0]);
            foreach ($getready_process as $key => $value) {

                $json_decoded_data = (array)json_decode($value->active_details);
                $employeeid = $value->employeeid;
                
                //started
                $attendance = $this->nn_daily_newattendancesummary($employeeid, "$process_month", "$process_year");
		$processed_attendance = $this->weekoff_holiday_process($attendance);
             $attendance = $processed_attendance;
               //$attendance;
                $latecount = 0;
                $earlyoutcount = 0;
                $absent = 0;
                $present = 0;
                $lop = 0;
                foreach($attendance as $newkey => $newvalue){

                                      

                     //timeget
    $diffinminutes = Carbon::parse($newvalue['shift_startdatetime'])->diffInSeconds(Carbon::parse($newvalue['shift_enddatetime']));
    $minutesdivide = $diffinminutes/2;
    $gmate = gmdate('H:i:s', $minutesdivide);
    
    $splitsub = explode(':', $gmate);
    if (($newvalue['shift_code'] == 'VGN_GEN') || ($newvalue['shift_code'] == 'VGN_GEN2') || ($newvalue['shift_code'] == 'VGN_RCP1') || ($newvalue['shift_code'] == 'VGN_RCP2') || ($newvalue['shift_code'] == 'VGN_SAP') || ($newvalue['shift_code'] == 'VGN_MGR') ) {
    $midtime = Carbon::parse($newvalue['shift_startdatetime'])->addHours($splitsub[0])->addMinutes($splitsub[1])->subMinutes(30)->toDateTimeString();
    }
    else{
        $midtime = Carbon::parse($newvalue['shift_startdatetime'])->addHours($splitsub[0])->addMinutes($splitsub[1])->toDateTimeString();
    }

    if (!empty($newvalue['punchlist'])) { $punchlist = json_encode($newvalue['punchlist']);}else{ $punchlist = null; }
            if (!empty($newvalue['lms_applications'])) { $lmsapp = json_encode($newvalue['lms_applications']);}else{ $lmsapp = null; }
            if (!empty($newvalue['first_half_considered_punches'])) { $first_half_considered_punches_list = json_encode($newvalue['first_half_considered_punches']);}else{ $first_half_considered_punches_list = null; }

                            //timeget
                            $add1hourmidtime = Carbon::parse($newvalue['shift_startdatetime'])->addMinutes(90);
                            $add3hourendtime = Carbon::parse($newvalue['shift_enddatetime'])->addHours(3);

                            $newcurrentdatetime = Carbon::now();
                            

                    if($newvalue['latecount'] != 0){
                        $latecount += 1;
                     }
    
                     if($newvalue['earlyoutcount'] != 0){
                        $earlyoutcount += 1;
                     }
                     
                        $absent += $newvalue['absent'];
                        $present += $newvalue['present'];

                    if((($newvalue['first_half_lop'] != 0) || ($newvalue['second_half_lop'] != 0)) && ($newvalue['absent'] == 0))
                    {
                        if(($newvalue['first_half_lop'] == 0.5) && ($newcurrentdatetime->gte($add1hourmidtime))){


                            $checkprev = DB::connection('mysql6')->table('daily_latededuction_table')->where([
                                'employeeid' => $employeeid ,
                            'month' => "$process_month", 
                            'year'=> "$process_year", 
                            'deduction_stdate_time'=> $newvalue['shift_startdatetime'], 
                            'deduction_etdate_time' => $midtime,
                            'partial_days' => 'first_half',
                            'type' => 'LATE'
                                 ])->count();

                            $explodetime1 = explode(' ', $newvalue['shift_startdatetime']);
                            $explodetime2 = explode(' ', $midtime);
                            $arr = [
                                'employeeid' => $employeeid,
                                "from_date"=> substr($newvalue['shift_startdatetime'],0,10),
                                "to_date"=> substr($midtime,0,10),
                                "leave_type"=> 'LATE',
                                "starttime"=> substr($explodetime1[1],0,5),
                                "endtime"=> substr($explodetime2[1],0,5)
                             ];
                            
                             $sentosap = 'Y';
                            
            
                             if($checkprev == 0){

                            $getready_process =  DB::connection('mysql6')->table('daily_latededuction_table')
                        ->insert([
                            'employeeid' => $employeeid ,
                            'emp_name' => $json_decoded_data['Emp_Name'],
                            'role_code' => $json_decoded_data['Role_Code'],
                            'plant_code' => $json_decoded_data['Plant_Code'],
                            'position' => $json_decoded_data['Position'],
                            'department' => $json_decoded_data['Department'],
                            'cadre' => $json_decoded_data['Cadre'],
                            'month' => "$process_month", 
                            'year'=> "$process_year", 
                            'deduction_stdate_time'=> $newvalue['shift_startdatetime'], 
                            'deduction_etdate_time' => $midtime,
                            'partial_days' => 'first_half',
                            'type' => 'LATE',
                            'punchlist' => $punchlist,
                            'lms_applications' => $lmsapp,
                            'first_half_lop' => $newvalue['first_half_lop'],
                            'second_half_lop' => $newvalue['second_half_lop'],
                            'latecount' => $newvalue['latecount'],
                            'latein_hours' => $newvalue['latein_hours'],
                            'laterange1' => $newvalue['laterange1'],
                            'laterange2' => $newvalue['laterange2'],
                            'laterange3' => $newvalue['laterange3'],
                            'earlyoutcount' => $newvalue['earlyoutcount'],
                            'earlyout_hours' => $newvalue['earlyout_hours'],
                            'absent' => $newvalue['absent'],
                            'present' => $newvalue['present'],
                            'first_half_considered_punches' => $first_half_considered_punches_list,
                            'sento_sap' => $sentosap,
                            'sento_sapdate' => Carbon::now()->toDateTimeString()
                             ]);

                            }
                            else
                            {
                                $getready_process =  DB::connection('mysql6')->table('daily_latededuction_table')->where(
                                    ['employeeid' => $employeeid ,
                                    'month' => "$process_month", 
                                    'year'=> "$process_year", 
                                    'deduction_stdate_time'=> $newvalue['shift_startdatetime'], 
                                    'deduction_etdate_time' => $midtime,
                                    'partial_days' => 'first_half',
                                    'type' => 'LATE']
                                )->update([
                                    'sento_sap' => $sentosap,
                                    'sento_sapdate' => Carbon::now()->toDateTimeString()
                                ]);

                            }
                        }
                        
                        if(($newvalue['second_half_lop'] == 0.5) && ($newcurrentdatetime->gte($add3hourendtime))){
                            $checkprev = DB::connection('mysql6')->table('daily_latededuction_table')->where([
                                'employeeid' => $employeeid ,
                            'month' => "$process_month", 
                            'year'=> "$process_year", 
                            'deduction_stdate_time'=> $midtime, 
                            'deduction_etdate_time' => $newvalue['shift_enddatetime'],
                            'partial_days' => 'second_half',
                            'type' => 'LATE'
                                 ])->count();
                                 
                            $explodetime1 = explode(' ', $midtime);
                            $explodetime2 = explode(' ', $newvalue['shift_enddatetime']);
                            $arr = [
                                'employeeid' => $employeeid,
                                "from_date"=> substr($midtime,0,10),
                                "to_date"=> substr($newvalue['shift_enddatetime'],0,10),
                                "leave_type"=> 'LATE',
                                "starttime"=> substr($explodetime1[1],0,5),
                                "endtime"=> substr($explodetime2[1],0,5)
                             ];
                            
                             $sentosap = 'Y';
                            

                             if($checkprev == 0){
                                $getready_process =  DB::connection('mysql6')->table('daily_latededuction_table')
                                ->insert([
                                    'employeeid' => $employeeid ,
                                    'emp_name' => $json_decoded_data['Emp_Name'],
                                    'role_code' => $json_decoded_data['Role_Code'],
                                    'plant_code' => $json_decoded_data['Plant_Code'],
                                    'position' => $json_decoded_data['Position'],
                                    'department' => $json_decoded_data['Department'],
                                    'cadre' => $json_decoded_data['Cadre'],
                                    'month' => "$process_month", 
                                    'year'=> "$process_year", 
                                    'deduction_stdate_time'=> $midtime, 
                                    'deduction_etdate_time' => $newvalue['shift_enddatetime'],
                                    'partial_days' => 'second_half',
                                    'type' => 'LATE',
                                    'punchlist' => $punchlist,
                                    'lms_applications' => $lmsapp,
                                    'first_half_lop' => $newvalue['first_half_lop'],
                                    'second_half_lop' => $newvalue['second_half_lop'],
                                    'latecount' => $newvalue['latecount'],
                                    'latein_hours' => $newvalue['latein_hours'],
                                    'laterange1' => $newvalue['laterange1'],
                                    'laterange2' => $newvalue['laterange2'],
                                    'laterange3' => $newvalue['laterange3'],
                                    'earlyoutcount' => $newvalue['earlyoutcount'],
                                    'earlyout_hours' => $newvalue['earlyout_hours'],
                                    'absent' => $newvalue['absent'],
                                    'present' => $newvalue['present'],
                                    'first_half_considered_punches' => $first_half_considered_punches_list,
                                    'sento_sap' => $sentosap,
                                    'sento_sapdate' => Carbon::now()->toDateTimeString()
                                     ]);
                             }
                             else{
                                $getready_process =  DB::connection('mysql6')->table('daily_latededuction_table')->where(
                                    ['employeeid' => $employeeid ,
                                    'month' => "$process_month", 
                                    'year'=> "$process_year", 
                                    'deduction_stdate_time'=> $midtime, 
                                    'deduction_etdate_time' => $newvalue['shift_enddatetime'],
                                    'partial_days' => 'second_half',
                                    'type' => 'LATE']
                                )->update([
                                    'sento_sap' => $sentosap,
                                    'sento_sapdate' => Carbon::now()->toDateTimeString()
                                ]);
                             }

                           
                        }
                    }
                    elseif((($newvalue['first_half_lop'] == 0) || ($newvalue['second_half_lop'] == 0)) && ($newvalue['absent'] == 1))
                    {                        
                        $checkprev = DB::connection('mysql6')->table('daily_latededuction_table')->where([
                            'employeeid' => $employeeid ,
                        'month' => "$process_month", 
                        'year'=> "$process_year", 
                        'deduction_stdate_time'=> $newvalue['shift_startdatetime'], 
                        'deduction_etdate_time' => $newvalue['shift_enddatetime'],
                        'partial_days' => 'full',
                        'type' => 'LOP'
                             ])->count();
                             $lop += 1;

                        $explodetime1 = explode(' ', $newvalue['shift_startdatetime']);
                        $explodetime2 = explode(' ', $newvalue['shift_enddatetime']);
                        $arr = [
                            'employeeid' => $employeeid,
                            "from_date"=> substr($newvalue['shift_startdatetime'],0,10),
                            "to_date"=> substr($newvalue['shift_startdatetime'],0,10),
                            "leave_type"=> 'LOP',
                            "starttime"=> '',
                            "endtime"=> ''
                         ];
                        
                         $sentosap = 'Y';
                        
                        if($checkprev == 0){

                        $getready_process =  DB::connection('mysql6')->table('daily_latededuction_table')
                        ->insert([
                            'employeeid' => $employeeid ,
                            'emp_name' => $json_decoded_data['Emp_Name'],
                            'role_code' => $json_decoded_data['Role_Code'],
                            'plant_code' => $json_decoded_data['Plant_Code'],
                            'position' => $json_decoded_data['Position'],
                            'department' => $json_decoded_data['Department'],
                            'cadre' => $json_decoded_data['Cadre'],
                            'month' => "$process_month", 
                            'year'=> "$process_year", 
                            'deduction_stdate_time'=> $newvalue['shift_startdatetime'], 
                            'deduction_etdate_time' => $newvalue['shift_enddatetime'],
                            'partial_days' => 'full',
                            'type' => 'LOP',
                            'punchlist' => $punchlist,
                            'lms_applications' => $lmsapp,
                            'first_half_lop' => $newvalue['first_half_lop'],
                            'second_half_lop' => $newvalue['second_half_lop'],
                            'latecount' => $newvalue['latecount'],
                            'latein_hours' => $newvalue['latein_hours'],
                            'laterange1' => $newvalue['laterange1'],
                            'laterange2' => $newvalue['laterange2'],
                            'laterange3' => $newvalue['laterange3'],
                            'earlyoutcount' => $newvalue['earlyoutcount'],
                            'earlyout_hours' => $newvalue['earlyout_hours'],
                            'absent' => $newvalue['absent'],
                            'present' => $newvalue['present'],
                            'first_half_considered_punches' => $first_half_considered_punches_list,
                            'sento_sap' => $sentosap,
                            'sento_sapdate' => Carbon::now()->toDateTimeString()
                             ]);
                        }else{
                            $getready_process =  DB::connection('mysql6')->table('daily_latededuction_table')->where(
                                [
                                    'employeeid' => $employeeid ,
                                    'month' => "$process_month", 
                                    'year'=> "$process_year", 
                                    'deduction_stdate_time'=> $newvalue['shift_startdatetime'], 
                                    'deduction_etdate_time' => $newvalue['shift_enddatetime'],
                                    'partial_days' => 'full',
                                    'type' => 'LOP'
                                ]
                            )->update([
                                'sento_sap' => $sentosap,
                                'sento_sapdate' => Carbon::now()->toDateTimeString()
                            ]);
                        }
                    }
                    elseif((($newvalue['first_half_lop'] == 0) || ($newvalue['second_half_lop'] == 0)) && ($newvalue['absent'] == 0.5))
                    {
                        $starttime1 = $newvalue['shift_startdatetime'];
                        $endtime1 = $newvalue['shift_enddatetime'];
                        $partial_days1 = 'first_half';

                        $getapplop = DB::connection('mysql6')->table('datetime_ref')->where(['employeeid' => $employeeid ,'month' => "$process_month",'year'=> "$process_year",'date'=>$newvalue['shift_date'],'type' => 'LOP'])->get();
                                if(count($getapplop) > 0){
                                    foreach ($getapplop as $lkey => $lvalue) {
                                        $partial_half = $lvalue->partial_days;
                                    }

                                    if($partial_half == 'first_half'){
                                        $starttime1 = $newvalue['shift_startdatetime'];
                                        $endtime1 = $midtime;
                                        $partial_days1 = 'first_half';
                                        $lop += 0.5;
                                    }
                                    if($partial_half == 'second_half'){
                                        $starttime1 = $midtime;
                                        $endtime1 = $newvalue['shift_enddatetime'];
                                        $partial_days1 = 'second_half';
                                        $lop += 0.5;
                                    }

                            }

                        $checkprev = DB::connection('mysql6')->table('daily_latededuction_table')->where([
                            'employeeid' => $employeeid ,
                        'month' => "$process_month", 
                        'year'=> "$process_year", 
                        'deduction_stdate_time'=> $starttime1, 
                        'deduction_etdate_time' => $endtime1,
                        'partial_days' => $partial_days1,
                        'type' => 'LOP'
                             ])->count();

                        $explodetime1 = explode(' ', $starttime1);
                        $explodetime2 = explode(' ', $endtime1);
                        $arr = [
                            'employeeid' => $employeeid,
                            "from_date"=> substr($starttime1,0,10),
                            "to_date"=> substr($endtime1,0,10),
                            "leave_type"=> 'LOP',
                            "starttime"=> substr($explodetime1[1],0,5),
                            "endtime"=> substr($explodetime2[1],0,5)
                         ];
                        
                         $sentosap = 'Y';
                        
                        if($checkprev == 0){

                        $getready_process =  DB::connection('mysql6')->table('daily_latededuction_table')
                        ->insert([
                            'employeeid' => $employeeid ,
                            'emp_name' => $json_decoded_data['Emp_Name'],
                            'role_code' => $json_decoded_data['Role_Code'],
                            'plant_code' => $json_decoded_data['Plant_Code'],
                            'position' => $json_decoded_data['Position'],
                            'department' => $json_decoded_data['Department'],
                            'cadre' => $json_decoded_data['Cadre'],
                            'month' => "$process_month", 
                            'year'=> "$process_year", 
                            'deduction_stdate_time'=> $starttime1, 
                            'deduction_etdate_time' => $endtime1,
                            'partial_days' => $partial_days1,
                            'type' => 'LOP',
                            'punchlist' => $punchlist,
                            'lms_applications' => $lmsapp,
                            'first_half_lop' => $newvalue['first_half_lop'],
                            'second_half_lop' => $newvalue['second_half_lop'],
                            'latecount' => $newvalue['latecount'],
                            'latein_hours' => $newvalue['latein_hours'],
                            'laterange1' => $newvalue['laterange1'],
                            'laterange2' => $newvalue['laterange2'],
                            'laterange3' => $newvalue['laterange3'],
                            'earlyoutcount' => $newvalue['earlyoutcount'],
                            'earlyout_hours' => $newvalue['earlyout_hours'],
                            'absent' => $newvalue['absent'],
                            'present' => $newvalue['present'],
                            'first_half_considered_punches' => $first_half_considered_punches_list,
                            'sento_sap' => $sentosap,
                            'sento_sapdate' => Carbon::now()->toDateTimeString()
                             ]);
                        }else{
                            $getready_process =  DB::connection('mysql6')->table('daily_latededuction_table')->where(
                                [
                                    'employeeid' => $employeeid ,
                                    'month' => "$process_month", 
                                    'year'=> "$process_year", 
                                    'deduction_stdate_time'=> $starttime1, 
                                    'deduction_etdate_time' => $endtime1,
                                    'partial_days' => $partial_days1,
                                    'type' => 'LOP'
                                ]
                            )->update([
                                'sento_sap' => $sentosap,
                                'sento_sapdate' => Carbon::now()->toDateTimeString()
                            ]);
                        }
                    }
                    elseif((($newvalue['first_half_lop'] != 0) || ($newvalue['second_half_lop'] != 0)) && ($newvalue['absent'] != 0)){
                        $checkfirsthalf_lop = DB::connection('mysql6')->table('datetime_ref')->where(['employeeid' => $employeeid ,'month' => "$process_month",'year'=> "$process_year",'date'=>$newvalue['shift_date'],'partial_days'=>'first_half','type' => 'LOP'])->get();
                        $checksecondhalf_lop = DB::connection('mysql6')->table('datetime_ref')->where(['employeeid' => $employeeid ,'month' => "$process_month",'year'=> "$process_year",'date'=>$newvalue['shift_date'],'partial_days'=>'second_half','type' => 'LOP'])->get();

                        if((count($checkfirsthalf_lop) > 0) && (count($checksecondhalf_lop) > 0)){                           

                        $checkprev = DB::connection('mysql6')->table('daily_latededuction_table')->where([
                        'employeeid' => $employeeid ,
                        'month' => "$process_month", 
                        'year'=> "$process_year", 
                        'deduction_stdate_time'=> $newvalue['shift_startdatetime'], 
                        'deduction_etdate_time' => $newvalue['shift_enddatetime'],
                        'partial_days' => 'full',
                        'type' => 'LOP'
                             ])->count();
                             $lop += 1;
                        $explodetime1 = explode(' ', $newvalue['shift_startdatetime']);
                        $explodetime2 = explode(' ', $newvalue['shift_enddatetime']);
                        $arr = [
                            'employeeid' => $employeeid,
                            "from_date"=> substr($newvalue['shift_startdatetime'],0,10),
                            "to_date"=> substr($newvalue['shift_startdatetime'],0,10),
                            "leave_type"=> 'LOP',
                            "starttime"=> '',
                            "endtime"=> ''
                         ];
                        
                         $sentosap = 'Y';
                         

                        if($checkprev == 0){

                        $getready_process =  DB::connection('mysql6')->table('daily_latededuction_table')
                        ->insert([
                            'employeeid' => $employeeid ,
                            'emp_name' => $json_decoded_data['Emp_Name'],
                            'role_code' => $json_decoded_data['Role_Code'],
                            'plant_code' => $json_decoded_data['Plant_Code'],
                            'position' => $json_decoded_data['Position'],
                            'department' => $json_decoded_data['Department'],
                            'cadre' => $json_decoded_data['Cadre'],
                            'month' => "$process_month", 
                            'year'=> "$process_year", 
                            'deduction_stdate_time'=> $newvalue['shift_startdatetime'], 
                            'deduction_etdate_time' => $newvalue['shift_enddatetime'],
                            'partial_days' => 'full',
                            'type' => 'LOP',
                            'punchlist' => $punchlist,
                            'lms_applications' => $lmsapp,
                            'first_half_lop' => $newvalue['first_half_lop'],
                            'second_half_lop' => $newvalue['second_half_lop'],
                            'latecount' => $newvalue['latecount'],
                            'latein_hours' => $newvalue['latein_hours'],
                            'laterange1' => $newvalue['laterange1'],
                            'laterange2' => $newvalue['laterange2'],
                            'laterange3' => $newvalue['laterange3'],
                            'earlyoutcount' => $newvalue['earlyoutcount'],
                            'earlyout_hours' => $newvalue['earlyout_hours'],
                            'absent' => $newvalue['absent'],
                            'present' => $newvalue['present'],
                            'first_half_considered_punches' => $first_half_considered_punches_list,
                            'sento_sap' => $sentosap,
                            'sento_sapdate' => Carbon::now()->toDateTimeString()
                             ]);
                        }else{
                            $getready_process =  DB::connection('mysql6')->table('daily_latededuction_table')->where(
                                [
                                    'employeeid' => $employeeid ,
                                    'month' => "$process_month", 
                                    'year'=> "$process_year", 
                                    'deduction_stdate_time'=> $newvalue['shift_startdatetime'], 
                                    'deduction_etdate_time' => $newvalue['shift_enddatetime'],
                                    'partial_days' => 'full',
                                    'type' => 'LOP'
                                ]
                            )->update([
                                'sento_sap' => $sentosap,
                                'sento_sapdate' => Carbon::now()->toDateTimeString()
                            ]);
                        }
                        
                        }
                        elseif((count($checkfirsthalf_lop) == 0) && (count($checksecondhalf_lop) > 0)){

                            $starttime1 = $newvalue['shift_startdatetime'];
                            $endtime1 = $newvalue['shift_enddatetime'];
                            $partial_days1 = 'first_half';
    
                            $getapplop = DB::connection('mysql6')->table('datetime_ref')->where(['employeeid' => $employeeid ,'month' => "$process_month",'year'=> "$process_year",'date'=>$newvalue['shift_date'],'type' => 'LOP'])->get();
                                    if(count($getapplop) > 0){
                                        foreach ($getapplop as $lkey => $lvalue) {
                                            $partial_half = $lvalue->partial_days;
                                        }
    
                                        if($partial_half == 'second_half'){
                                            $starttime1 = $midtime;
                                            $endtime1 = $newvalue['shift_enddatetime'];
                                            $partial_days1 = 'second_half';
                                            $lop += 0.5;

                                            //start
                                            $checkprev1 = DB::connection('mysql6')->table('daily_latededuction_table')->where([
                                                'employeeid' => $employeeid ,
                                            'month' => "$process_month", 
                                            'year'=> "$process_year", 
                                            'deduction_stdate_time'=> $starttime1, 
                                            'deduction_etdate_time' => $endtime1,
                                            'partial_days' => $partial_days1,
                                            'type' => 'LOP'
                                                 ])->count();
                    
                                            $explodetime1 = explode(' ', $starttime1);
                                            $explodetime2 = explode(' ', $endtime1);
                                            $arr = [
                                                'employeeid' => $employeeid,
                                                "from_date"=> substr($starttime1,0,10),
                                                "to_date"=> substr($endtime1,0,10),
                                                "leave_type"=> 'LOP',
                                                "starttime"=> substr($explodetime1[1],0,5),
                                                "endtime"=> substr($explodetime2[1],0,5)
                                             ];
                                            
                                             $sentosap = 'Y';
                                            
                    
                                            if($checkprev1 == 0){
                    
                                            $getready_process1 =  DB::connection('mysql6')->table('daily_latededuction_table')
                                            ->insert([
                                                'employeeid' => $employeeid ,
                                                'emp_name' => $json_decoded_data['Emp_Name'],
                                                'role_code' => $json_decoded_data['Role_Code'],
                                                'plant_code' => $json_decoded_data['Plant_Code'],
                                                'position' => $json_decoded_data['Position'],
                                                'department' => $json_decoded_data['Department'],
                                                'cadre' => $json_decoded_data['Cadre'],
                                                'month' => "$process_month", 
                                                'year'=> "$process_year", 
                                                'deduction_stdate_time'=> $starttime1, 
                                                'deduction_etdate_time' => $endtime1,
                                                'partial_days' => $partial_days1,
                                                'type' => 'LOP',
                                                'punchlist' => $punchlist,
                                                'lms_applications' => $lmsapp,
                                                'first_half_lop' => $newvalue['first_half_lop'],
                                                'second_half_lop' => $newvalue['second_half_lop'],
                                                'latecount' => $newvalue['latecount'],
                                                'latein_hours' => $newvalue['latein_hours'],
                                                'laterange1' => $newvalue['laterange1'],
                                                'laterange2' => $newvalue['laterange2'],
                                                'laterange3' => $newvalue['laterange3'],
                                                'earlyoutcount' => $newvalue['earlyoutcount'],
                                                'earlyout_hours' => $newvalue['earlyout_hours'],
                                                'absent' => $newvalue['absent'],
                                                'present' => $newvalue['present'],
                                                'first_half_considered_punches' => $first_half_considered_punches_list,
                                                'sento_sap' => $sentosap,
                                                'sento_sapdate' => Carbon::now()->toDateTimeString()
                                                 ]);
                                            }else{
                                                $getready_process1 =  DB::connection('mysql6')->table('daily_latededuction_table')->where(
                                                    [
                                                        'employeeid' => $employeeid ,
                                                        'month' => "$process_month", 
                                                        'year'=> "$process_year", 
                                                        'deduction_stdate_time'=> $starttime1, 
                                                        'deduction_etdate_time' => $endtime1,
                                                        'partial_days' => $partial_days1,
                                                        'type' => 'LOP'
                                                    ]
                                                )->update([
                                                    'sento_sap' => $sentosap,
                                                    'sento_sapdate' => Carbon::now()->toDateTimeString()
                                                ]);
                                            }
                                            //end



                                        }
    
                                }
                            
                            if(($newvalue['first_half_lop'] == 0.5) && ($newcurrentdatetime->gte($add1hourmidtime))){


                                $checkprev = DB::connection('mysql6')->table('daily_latededuction_table')->where([
                                    'employeeid' => $employeeid ,
                                'month' => "$process_month", 
                                'year'=> "$process_year", 
                                'deduction_stdate_time'=> $newvalue['shift_startdatetime'], 
                                'deduction_etdate_time' => $midtime,
                                'partial_days' => 'first_half',
                                'type' => 'LATE'
                                     ])->count();
    
                                $explodetime1 = explode(' ', $newvalue['shift_startdatetime']);
                                $explodetime2 = explode(' ', $midtime);
                                $arr = [
                                    'employeeid' => $employeeid,
                                    "from_date"=> substr($newvalue['shift_startdatetime'],0,10),
                                    "to_date"=> substr($midtime,0,10),
                                    "leave_type"=> 'LATE',
                                    "starttime"=> substr($explodetime1[1],0,5),
                                    "endtime"=> substr($explodetime2[1],0,5)
                                 ];
                                
                                 $sentosap = 'Y';
                                 
    
                                 if($checkprev == 0){
    
                                $getready_process =  DB::connection('mysql6')->table('daily_latededuction_table')
                            ->insert([
                                'employeeid' => $employeeid ,
                                'emp_name' => $json_decoded_data['Emp_Name'],
                                'role_code' => $json_decoded_data['Role_Code'],
                                'plant_code' => $json_decoded_data['Plant_Code'],
                                'position' => $json_decoded_data['Position'],
                                'department' => $json_decoded_data['Department'],
                                'cadre' => $json_decoded_data['Cadre'],
                                'month' => "$process_month", 
                                'year'=> "$process_year", 
                                'deduction_stdate_time'=> $newvalue['shift_startdatetime'], 
                                'deduction_etdate_time' => $midtime,
                                'partial_days' => 'first_half',
                                'type' => 'LATE',
                                'punchlist' => $punchlist,
                                'lms_applications' => $lmsapp,
                                'first_half_lop' => $newvalue['first_half_lop'],
                                'second_half_lop' => $newvalue['second_half_lop'],
                                'latecount' => $newvalue['latecount'],
                                'latein_hours' => $newvalue['latein_hours'],
                                'laterange1' => $newvalue['laterange1'],
                                'laterange2' => $newvalue['laterange2'],
                                'laterange3' => $newvalue['laterange3'],
                                'earlyoutcount' => $newvalue['earlyoutcount'],
                                'earlyout_hours' => $newvalue['earlyout_hours'],
                                'absent' => $newvalue['absent'],
                                'present' => $newvalue['present'],
                                'first_half_considered_punches' => $first_half_considered_punches_list,
                                'sento_sap' => $sentosap,
                                'sento_sapdate' => Carbon::now()->toDateTimeString()
                                 ]);
    
                                }
                                else
                                {
                                    $getready_process =  DB::connection('mysql6')->table('daily_latededuction_table')->where(
                                        ['employeeid' => $employeeid ,
                                        'month' => "$process_month", 
                                        'year'=> "$process_year", 
                                        'deduction_stdate_time'=> $newvalue['shift_startdatetime'], 
                                        'deduction_etdate_time' => $midtime,
                                        'partial_days' => 'first_half',
                                        'type' => 'LATE']
                                    )->update([
                                        'sento_sap' => $sentosap,
                                        'sento_sapdate' => Carbon::now()->toDateTimeString()
                                    ]);
    
                                }
                                
                            }


                        }
                        elseif((count($checkfirsthalf_lop) > 0) && (count($checksecondhalf_lop) == 0)){

                            $starttime1 = $newvalue['shift_startdatetime'];
                            $endtime1 = $newvalue['shift_enddatetime'];
                            $partial_days1 = 'first_half';
    
                            $getapplop = DB::connection('mysql6')->table('datetime_ref')->where(['employeeid' => $employeeid ,'month' => "$process_month",'year'=> "$process_year",'date'=>$newvalue['shift_date'],'type' => 'LOP'])->get();
                                    if(count($getapplop) > 0){
                                        foreach ($getapplop as $lkey => $lvalue) {
                                            $partial_half = $lvalue->partial_days;
                                        }
    
                                        if($partial_half == 'first_half'){
                                            $starttime1 = $newvalue['shift_startdatetime'];
                                            $endtime1 = $midtime;
                                            $partial_days1 = 'first_half';
                                            $lop += 0.5;

                                            //start
                                            $checkprev1 = DB::connection('mysql6')->table('daily_latededuction_table')->where([
                                                'employeeid' => $employeeid ,
                                            'month' => "$process_month", 
                                            'year'=> "$process_year", 
                                            'deduction_stdate_time'=> $starttime1, 
                                            'deduction_etdate_time' => $endtime1,
                                            'partial_days' => $partial_days1,
                                            'type' => 'LOP'
                                                 ])->count();
                    
                                            $explodetime1 = explode(' ', $starttime1);
                                            $explodetime2 = explode(' ', $endtime1);
                                            $arr = [
                                                'employeeid' => $employeeid,
                                                "from_date"=> substr($starttime1,0,10),
                                                "to_date"=> substr($endtime1,0,10),
                                                "leave_type"=> 'LOP',
                                                "starttime"=> substr($explodetime1[1],0,5),
                                                "endtime"=> substr($explodetime2[1],0,5)
                                             ];
                                            
                                             $sentosap = 'Y';
                                            
                    
                                            if($checkprev1 == 0){
                    
                                            $getready_process1 =  DB::connection('mysql6')->table('daily_latededuction_table')
                                            ->insert([
                                                'employeeid' => $employeeid ,
                                                'emp_name' => $json_decoded_data['Emp_Name'],
                                                'role_code' => $json_decoded_data['Role_Code'],
                                                'plant_code' => $json_decoded_data['Plant_Code'],
                                                'position' => $json_decoded_data['Position'],
                                                'department' => $json_decoded_data['Department'],
                                                'cadre' => $json_decoded_data['Cadre'],
                                                'month' => "$process_month", 
                                                'year'=> "$process_year", 
                                                'deduction_stdate_time'=> $starttime1, 
                                                'deduction_etdate_time' => $endtime1,
                                                'partial_days' => $partial_days1,
                                                'type' => 'LOP',
                                                'punchlist' => $punchlist,
                                                'lms_applications' => $lmsapp,
                                                'first_half_lop' => $newvalue['first_half_lop'],
                                                'second_half_lop' => $newvalue['second_half_lop'],
                                                'latecount' => $newvalue['latecount'],
                                                'latein_hours' => $newvalue['latein_hours'],
                                                'laterange1' => $newvalue['laterange1'],
                                                'laterange2' => $newvalue['laterange2'],
                                                'laterange3' => $newvalue['laterange3'],
                                                'earlyoutcount' => $newvalue['earlyoutcount'],
                                                'earlyout_hours' => $newvalue['earlyout_hours'],
                                                'absent' => $newvalue['absent'],
                                                'present' => $newvalue['present'],
                                                'first_half_considered_punches' => $first_half_considered_punches_list,
                                                'sento_sap' => $sentosap,
                                                'sento_sapdate' => Carbon::now()->toDateTimeString()
                                                 ]);
                                            }else{
                                                $getready_process1 =  DB::connection('mysql6')->table('daily_latededuction_table')->where(
                                                    [
                                                        'employeeid' => $employeeid ,
                                                        'month' => "$process_month", 
                                                        'year'=> "$process_year", 
                                                        'deduction_stdate_time'=> $starttime1, 
                                                        'deduction_etdate_time' => $endtime1,
                                                        'partial_days' => $partial_days1,
                                                        'type' => 'LOP'
                                                    ]
                                                )->update([
                                                    'sento_sap' => $sentosap,
                                                    'sento_sapdate' => Carbon::now()->toDateTimeString()
                                                ]);
                                            }
                                            //end



                                        }
    
                                }

                            if(($newvalue['second_half_lop'] == 0.5) && ($newcurrentdatetime->gte($add3hourendtime))){
                                
                                $checkprev = DB::connection('mysql6')->table('daily_latededuction_table')->where([
                                    'employeeid' => $employeeid ,
                                'month' => "$process_month", 
                                'year'=> "$process_year", 
                                'deduction_stdate_time'=> $midtime, 
                                'deduction_etdate_time' => $newvalue['shift_enddatetime'],
                                'partial_days' => 'second_half',
                                'type' => 'LATE'
                                     ])->count();
                                     
                                $explodetime1 = explode(' ', $midtime);
                                $explodetime2 = explode(' ', $newvalue['shift_enddatetime']);
                                $arr = [
                                    'employeeid' => $employeeid,
                                    "from_date"=> substr($midtime,0,10),
                                    "to_date"=> substr($newvalue['shift_enddatetime'],0,10),
                                    "leave_type"=> 'LATE',
                                    "starttime"=> substr($explodetime1[1],0,5),
                                    "endtime"=> substr($explodetime2[1],0,5)
                                 ];
                                
                                 $sentosap = 'Y';
                                     
                                 if($checkprev == 0){
                                    $getready_process =  DB::connection('mysql6')->table('daily_latededuction_table')
                                    ->insert([
                                        'employeeid' => $employeeid ,
                                        'emp_name' => $json_decoded_data['Emp_Name'],
                                        'role_code' => $json_decoded_data['Role_Code'],
                                        'plant_code' => $json_decoded_data['Plant_Code'],
                                        'position' => $json_decoded_data['Position'],
                                        'department' => $json_decoded_data['Department'],
                                        'cadre' => $json_decoded_data['Cadre'],
                                        'month' => "$process_month", 
                                        'year'=> "$process_year", 
                                        'deduction_stdate_time'=> $midtime, 
                                        'deduction_etdate_time' => $newvalue['shift_enddatetime'],
                                        'partial_days' => 'second_half',
                                        'type' => 'LATE',
                                        'punchlist' => $punchlist,
                                        'lms_applications' => $lmsapp,
                                        'first_half_lop' => $newvalue['first_half_lop'],
                                        'second_half_lop' => $newvalue['second_half_lop'],
                                        'latecount' => $newvalue['latecount'],
                                        'latein_hours' => $newvalue['latein_hours'],
                                        'laterange1' => $newvalue['laterange1'],
                                        'laterange2' => $newvalue['laterange2'],
                                        'laterange3' => $newvalue['laterange3'],
                                        'earlyoutcount' => $newvalue['earlyoutcount'],
                                        'earlyout_hours' => $newvalue['earlyout_hours'],
                                        'absent' => $newvalue['absent'],
                                        'present' => $newvalue['present'],
                                        'first_half_considered_punches' => $first_half_considered_punches_list,
                                        'sento_sap' => $sentosap,
                                        'sento_sapdate' => Carbon::now()->toDateTimeString()
                                         ]);
                                 }
                                 else{
                                    $getready_process =  DB::connection('mysql6')->table('daily_latededuction_table')->where(
                                        ['employeeid' => $employeeid ,
                                        'month' => "$process_month", 
                                        'year'=> "$process_year", 
                                        'deduction_stdate_time'=> $midtime, 
                                        'deduction_etdate_time' => $newvalue['shift_enddatetime'],
                                        'partial_days' => 'second_half',
                                        'type' => 'LATE']
                                    )->update([
                                        'sento_sap' => $sentosap,
                                        'sento_sapdate' => Carbon::now()->toDateTimeString()
                                    ]);
                                 }
    
                               
                            }
                        }
                        else{

                        }
                        
                    }
                    else{

                    }
                }
                //ended
                /*DB::connection('mysql6')->table('leave_balance')->where([
                    'employeeid' => $employeeid, 'month' => $process_month, 'year' =>$process_year
                ])->update([
                    'LOP' => $lop,
                    'Present' => $present,
                    'Absent' => $absent,
                    'late_count' => $latecount,
                    'early_out_count' => $earlyoutcount
                ]);*/


                //send to sap one shot
                       
                DB::connection('mysql6')->table('daily_lateacrual_process')->where(['employeeid' => $employeeid, 'month' => "$process_month", 'year' =>"$process_year"  ])->update([
                    'processed' => 'Y',
                    'last_processed_date' => Carbon::now()->toDateTimeString()
                ]);
            
                } 
                DB::connection('mysql6')->table('daily_late_scriptprocess')->where(['id' => 1  ])->update(['split_run_completed' => 1, 'overal_completed' => 0]);
                
        }
        else{

        DB::connection('mysql6')->table('daily_late_scriptprocess')->where(['id' => 1  ])->update(['split_run_completed' => 1, 'overal_completed' => 1]);
        DB::connection('mysql6')->table('daily_lateprocess_iniate')->where(['process_iniated' => 1])->update(['process_iniated' => 0]);
        
        }
                //script end
                
                         

    }


    public function sendfullmonthod()
    {
        $employeeids = ['100000', '100237'];
        //$employeeids = ['100323'];
    

        $monthdate = Carbon::now()->subDays(10)->toDateString();
        $startdate = Carbon::parse($monthdate)->startOfMonth()->toDateString();
	    //$startdate = "2020-03-21";
        $enddate = Carbon::parse($monthdate)->endOfMonth()->toDateString();
        //$enddate = "2020-03-21";
        $leave_type = 'Tour';
        $partial_days = 'full';

        $daterange_array = $this->createDateRange($startdate, $enddate, $format = "Y-m-d");
        array_push($daterange_array, $enddate);
        //dd($daterange_array);
        $diff = count($daterange_array);
        foreach ($employeeids as $employeeid) {        
        //start
        

        $getshiftdetails = $this->getshiftdetailsst_et_date($employeeid, $startdate, $enddate);

        $hourtoadd = 0;
        $time = 0;
        $time_arr = [];
        $shift_arr = [];
        if (array_key_exists('0', $getshiftdetails['Shift_Details']) === false) {
            $shift_arr['Shift_Details'][0] = $getshiftdetails['Shift_Details'];
        }
        else{
            $shift_arr['Shift_Details'] = $getshiftdetails['Shift_Details'];
        }
        //dd($shift_arr);
            foreach ($shift_arr['Shift_Details'] as $key2 => $value2) {

                //dd($value2['Shift_Code']);

                    if (($value2['Shift_Code'] == 'VGN_NIGT') || ($value2['Shift_Code'] == 'VGN_FNIG')) {
                        $std = Carbon::parse($value2['Shift_Date'])->addDay()->toDateString();
                    }
                    else{
                        $std = $value2['Shift_Date'];
                    }

                    //$fhourtoadd = substr(Carbon::parse($value2['Shift_Date'].' '.$value2['Start_Time'])->diff(Carbon::parse($std.' '.$value2['End_Time']))->format('%H:%i:%s'), 0,2);
                    
                    //$hourtoadd = $fhourtoadd + $hourtoadd;
                    $diffintimehours = Carbon::parse($value2['Shift_Date'].' '.$value2['Start_Time'])->diffInSeconds(Carbon::parse($std.' '.$value2['End_Time']));
                    $newhours = gmdate('H:i', $diffintimehours); 
                    array_push($time_arr, $newhours);
                
            }
            
            foreach ($time_arr as $k => $time_val) {

                $time += $this->explode_time($time_val); 
            }

            $hourtoadd = $this->second_to_hhmm($time);
               

        if (($shift_arr['Shift_Details'][0]['Shift_Code'] == 'VGN_NIGT') || ($shift_arr['Shift_Details'][0]['Shift_Code'] == 'VGN_FNIG')) {
            
            $std_string = Carbon::parse($shift_arr['Shift_Details'][0]['Shift_Date'])->addDay()->toDateString();
            $startdatetime = $shift_arr['Shift_Details'][0]['Shift_Date'].' '.$shift_arr['Shift_Details'][0]['Start_Time'];

        }
        else{
            $startdatetime = $shift_arr['Shift_Details'][0]['Shift_Date'].' '.$shift_arr['Shift_Details'][0]['Start_Time'];
        }

        if (($shift_arr['Shift_Details'][count($shift_arr['Shift_Details']) - 1]['Shift_Code'] == 'VGN_NIGT') || ($shift_arr['Shift_Details'][count($shift_arr['Shift_Details']) - 1]['Shift_Code'] == 'VGN_FNIG')) {

            $std_string = Carbon::parse($shift_arr['Shift_Details'][count($shift_arr['Shift_Details']) - 1]['Shift_Date'])->addDay()->toDateString();
            $enddatetime = $std_string.' '.$shift_arr['Shift_Details'][count($shift_arr['Shift_Details']) - 1]['End_Time'];

        }
        else{
            $enddatetime = $shift_arr['Shift_Details'][count($shift_arr['Shift_Details']) - 1]['Shift_Date'].' '.$shift_arr['Shift_Details'][count($shift_arr['Shift_Details']) - 1]['End_Time'];
        }
        
        $no_of_hours = $hourtoadd;
        
        
        $month = Carbon::parse($startdate)->format('m');
        $currentmonth = Carbon::now()->format('m');
        $year = Carbon::parse($startdate)->format('Y');
        $currentyear = Carbon::now()->format('Y');
       $getid = DB::connection('mysql6')->table('leave_processed')->insertGetId([
            'employeeid' => $employeeid,
            'month' => $month,
            'year' => $year,
            'type' => $leave_type,
            'stdate' => $startdatetime,
            'etdate' => $enddatetime,
            'no_of_hours' => $no_of_hours,
            'no_of_days' => $diff,
            'partial_days' => $partial_days,
            'emp_reason' => 'auto generated',
            'created_date' => Carbon::now()->toDateTimeString(),
            'hod_status' => 'Approved',
            'hod_reason' => null,
            'hod_created_date' => Carbon::now()->toDateTimeString(),
            'admin_status' => 'Approved',
            'admin_reason' => null,
            'admin_created_date' => Carbon::now()->toDateTimeString(),
            'final_status' => 'Approved',
            'saved_file_path' => null,
            'valid_till' => Carbon::now()->addDays(5)->toDateTimeString()
        ]);
        
    foreach ($daterange_array as $key => $value) {
        foreach ($shift_arr['Shift_Details'] as $key3 => $value3) {
            if ($value == $value3['Shift_Date']) {
                DB::connection('mysql6')->table('datetime_ref')->insert([
                    'employeeid' => $employeeid,
                    'month' => Carbon::parse($value)->format('m'),
                    'year' => Carbon::parse($value)->format('Y'),
                    'applied_month' => $currentmonth,
                    'applied_year' => $currentyear,
                    'type' => $leave_type,
                    'shift_code' => $value3['Shift_Code'],
                    'final_status' => 'Approved',
                    'date' => $value,
                    'start_end_time' => $value3['Start_Time'].'-'.$value3['End_Time'],
                    'partial_days' => $partial_days,
                    'reference_id' => $getid
                ]);
            }
        }
      
    }

   
   
    
    DB::connection('mysql6')->table('leave_balance')->where(['employeeid' => $employeeid, 'month' => $currentmonth,'year' => $currentyear])
        ->update([
            $leave_type => $diff
        ]);
        //end

        $newar = [];
            $newar['employeeid'] = $employeeid;
            $newar['from_date'] = $startdate;
            $newar['to_date'] = $enddate;
            $newar['starttime'] = '';
            $newar['endtime'] = '';
            $newar['leave_type'] = $leave_type;
        
        
        
        DB::connection('mysql6')->table('send_sap_leave_details')->insert(['details' => json_encode($newar), 'created_datetime' => Carbon::now()->toDateTimeString()]);

    }

    dd('finished');
    }


     public function sendapplication_with_range()
    {
        $employeeids = ["200937",
"201002",
"201172"];
        //$employeeids = ['100323'];
    

        $monthdate = Carbon::now()->subDays(10)->toDateString();
        $startdate = Carbon::parse($monthdate)->startOfMonth()->toDateString();
        //$startdate = "2020-03-21";
       // $enddate = Carbon::parse($monthdate)->endOfMonth()->toDateString();
        $enddate = "2020-05-19";
        $leave_type = 'LOP';
        $partial_days = 'full';

        $daterange_array = $this->createDateRange($startdate, $enddate, $format = "Y-m-d");
        array_push($daterange_array, $enddate);
        //dd($daterange_array);
        $diff = count($daterange_array);
        foreach ($employeeids as $employeeid) {        
        //start
        

        $getshiftdetails = $this->getshiftdetailsst_et_date($employeeid, $startdate, $enddate);

        $hourtoadd = 0;
        $time = 0;
        $time_arr = [];
        $shift_arr = [];
        if (array_key_exists('0', $getshiftdetails['Shift_Details']) === false) {
            $shift_arr['Shift_Details'][0] = $getshiftdetails['Shift_Details'];
        }
        else{
            $shift_arr['Shift_Details'] = $getshiftdetails['Shift_Details'];
        }
        //dd($shift_arr);
            foreach ($shift_arr['Shift_Details'] as $key2 => $value2) {

                //dd($value2['Shift_Code']);

                    if (($value2['Shift_Code'] == 'VGN_NIGT') || ($value2['Shift_Code'] == 'VGN_FNIG')) {
                        $std = Carbon::parse($value2['Shift_Date'])->addDay()->toDateString();
                    }
                    else{
                        $std = $value2['Shift_Date'];
                    }

                    //$fhourtoadd = substr(Carbon::parse($value2['Shift_Date'].' '.$value2['Start_Time'])->diff(Carbon::parse($std.' '.$value2['End_Time']))->format('%H:%i:%s'), 0,2);
                    
                    //$hourtoadd = $fhourtoadd + $hourtoadd;
                    $diffintimehours = Carbon::parse($value2['Shift_Date'].' '.$value2['Start_Time'])->diffInSeconds(Carbon::parse($std.' '.$value2['End_Time']));
                    $newhours = gmdate('H:i', $diffintimehours); 
                    array_push($time_arr, $newhours);
                
            }
            
            foreach ($time_arr as $k => $time_val) {

                $time += $this->explode_time($time_val); 
            }

            $hourtoadd = $this->second_to_hhmm($time);
               

        if (($shift_arr['Shift_Details'][0]['Shift_Code'] == 'VGN_NIGT') || ($shift_arr['Shift_Details'][0]['Shift_Code'] == 'VGN_FNIG')) {
            
            $std_string = Carbon::parse($shift_arr['Shift_Details'][0]['Shift_Date'])->addDay()->toDateString();
            $startdatetime = $shift_arr['Shift_Details'][0]['Shift_Date'].' '.$shift_arr['Shift_Details'][0]['Start_Time'];

        }
        else{
            $startdatetime = $shift_arr['Shift_Details'][0]['Shift_Date'].' '.$shift_arr['Shift_Details'][0]['Start_Time'];
        }

        if (($shift_arr['Shift_Details'][count($shift_arr['Shift_Details']) - 1]['Shift_Code'] == 'VGN_NIGT') || ($shift_arr['Shift_Details'][count($shift_arr['Shift_Details']) - 1]['Shift_Code'] == 'VGN_FNIG')) {

            $std_string = Carbon::parse($shift_arr['Shift_Details'][count($shift_arr['Shift_Details']) - 1]['Shift_Date'])->addDay()->toDateString();
            $enddatetime = $std_string.' '.$shift_arr['Shift_Details'][count($shift_arr['Shift_Details']) - 1]['End_Time'];

        }
        else{
            $enddatetime = $shift_arr['Shift_Details'][count($shift_arr['Shift_Details']) - 1]['Shift_Date'].' '.$shift_arr['Shift_Details'][count($shift_arr['Shift_Details']) - 1]['End_Time'];
        }
        
        $no_of_hours = $hourtoadd;
        
        
        $month = Carbon::parse($startdate)->format('m');
        $currentmonth = Carbon::now()->format('m');
        $year = Carbon::parse($startdate)->format('Y');
        $currentyear = Carbon::now()->format('Y');
       $getid = DB::connection('mysql6')->table('leave_processed')->insertGetId([
            'employeeid' => $employeeid,
            'month' => $month,
            'year' => $year,
            'type' => $leave_type,
            'stdate' => $startdatetime,
            'etdate' => $enddatetime,
            'no_of_hours' => $no_of_hours,
            'no_of_days' => $diff,
            'partial_days' => $partial_days,
            'emp_reason' => 'auto generated',
            'created_date' => Carbon::now()->toDateTimeString(),
            'hod_status' => 'Approved',
            'hod_reason' => null,
            'hod_created_date' => Carbon::now()->toDateTimeString(),
            'admin_status' => 'Approved',
            'admin_reason' => null,
            'admin_created_date' => Carbon::now()->toDateTimeString(),
            'final_status' => 'Approved',
            'saved_file_path' => null,
            'valid_till' => Carbon::now()->addDays(5)->toDateTimeString()
        ]);
        
    foreach ($daterange_array as $key => $value) {
        foreach ($shift_arr['Shift_Details'] as $key3 => $value3) {
            if ($value == $value3['Shift_Date']) {
                DB::connection('mysql6')->table('datetime_ref')->insert([
                    'employeeid' => $employeeid,
                    'month' => Carbon::parse($value)->format('m'),
                    'year' => Carbon::parse($value)->format('Y'),
                    'applied_month' => $currentmonth,
                    'applied_year' => $currentyear,
                    'type' => $leave_type,
                    'shift_code' => $value3['Shift_Code'],
                    'final_status' => 'Approved',
                    'date' => $value,
                    'start_end_time' => $value3['Start_Time'].'-'.$value3['End_Time'],
                    'partial_days' => $partial_days,
                    'reference_id' => $getid
                ]);
            }
        }
      
    }

   
   
    
    DB::connection('mysql6')->table('leave_balance')->where(['employeeid' => $employeeid, 'month' => $currentmonth,'year' => $currentyear])
        ->update([
            $leave_type => $diff
        ]);
        //end

        $newar = [];
            $newar['employeeid'] = $employeeid;
            $newar['from_date'] = $startdate;
            $newar['to_date'] = $enddate;
            $newar['starttime'] = '';
            $newar['endtime'] = '';
            $newar['leave_type'] = $leave_type;
        
        
        
        DB::connection('mysql6')->table('send_sap_leave_details')->insert(['details' => json_encode($newar), 'created_datetime' => Carbon::now()->toDateTimeString()]);

    }

    dd('finished');
    }


    public function monthly_deductions_screen(Request $request)
    {
        if ($request->session()->has('employeesession')) {
            $encrypt = $request->session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $employeeid = $split[0];

            if (in_array($employeeid, config('newlmsconfig'))) {
                $valid = 1;
            }else{
                return redirect()->route('newemployee_home');
            }

            $getemployeedata =  DB::connection('mysql6')->table('employee')->where('id',$employeeid )->get();
            $daily_lateprocess_iniate =  DB::connection('mysql6')->table('daily_lateprocess_iniate')->where(['process_iniated' => 1] )->count();
            $toprocess =  DB::connection('mysql6')->table('daily_lateacrual_process')->where(['processed' => 'N'] )->count(); 
            //dd($daily_lateprocess_iniate);
            $startmonth =  Carbon::now()->startOfMonth()->format('d.m.Y');
            $currentday = Carbon::now()->toDateString();
            $currday = Carbon::parse($currentday)->format('d.m.Y');
            $title = $startmonth.' to '.$currday;

            $listfiles = Storage::disk('s3')->files("/newcustomerzoneassets/employeeprofileimage/".$employeeid);             
             if(count($listfiles) > 0){
                $profilepic = config('app.AWS_URL')."/".$listfiles[0];
            }
             else
             {
                $profilepic = config('app.AWS_URL')."/newcustomerzoneassets/img/dummy_male.png";
             }

           $getdeductions = DB::connection('mysql6')->table('daily_latededuction_table')->get();
             //dd($getdeductions);
           $departmentwisearray = [];
           
           if(count($getdeductions) > 0){
            $distinct_dept = DB::connection('mysql6')->table('daily_latededuction_table')->select('department')->groupBy('department')->get();
                foreach ($distinct_dept as $key => $value) {
                    $departmentwisearray[$key]['Department'] = $value->department;
                    $departmentwisearray[$key]['LATE'] = 0;
                    $departmentwisearray[$key]['LOP'] = 0;
                    foreach ($getdeductions as $key1 => $value1) {
                        if ($value1->department == $value->department) {
                            if($value1->type == 'LATE'){
                                $departmentwisearray[$key]['LATE'] += 0.5;
                            }
                            if($value1->type == 'LOP'){
                                $departmentwisearray[$key]['LOP'] += 1;
                            }
                        }
                    }
                }
           }

           //dd($departmentwisearray);

           return view('newemployeezone.lms.late_deduction')->with(['getemployeedata' => $getemployeedata,'toprocess' => $toprocess,'daily_lateprocess_iniate'=>$daily_lateprocess_iniate,'departmentwisearray' => $departmentwisearray,'getdeductions'=> $getdeductions,'title' => $title,'profilepic' => $profilepic]);


        }else{
            return view('newemployeezone.login');
        }
    }

    public function dailylatescript3hoursinterval()
    {
        $current_timeplus2minutes = Carbon::now()->addMinutes(1)->toDateTimeString();
        $current_timeplus2minutes1 = Carbon::parse($current_timeplus2minutes)->addMinutes(1)->toDateTimeString();
        $current_timeplus2minutes2 = Carbon::parse($current_timeplus2minutes1)->addMinutes(1)->toDateTimeString();
        $current_timeplus2minutes3 = Carbon::parse($current_timeplus2minutes2)->addMinutes(60)->toDateTimeString();
        DB::connection('mysql6')->table('daily_lateprocess_iniate')->where(['id' => 1])->update([
                'loadtime_start' => substr($current_timeplus2minutes,0,17).'00',
                'loadtime_end' => substr($current_timeplus2minutes1,0,17).'00',
                'laterun_time_start' => substr($current_timeplus2minutes2,0,17).'00',
                'laterun_time_end' => substr($current_timeplus2minutes3,0,17).'00',
                'process_iniated' => 1,
                'initated_time' => Carbon::now()->toDateTimeString()

            ]
        );

        return redirect()->route('daily_latededuction_screen');
    }

    public function overall_employeeattendance(Request $request)
    {
        if ($request->session()->has('employeesession')) {
            $encrypt = $request->session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $employeeid = $split[0];

            if (in_array($employeeid, config('newlmsconfig'))) {
                $valid = 1;
            }else{
                return redirect()->route('newemployee_home');
            }

            $getemployeedata =  DB::connection('mysql6')->table('employee')->where('id',$employeeid )->get();
            

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
        $forpunchlist = [];

        if (count($getactiveemployees) > 0) {
            $i=0;
            $j = 0;
            foreach ($getactiveemployees['Details'] as $key => $value) {
                    $forpunchlist[$j]['empid'] = $value['Emp_ID'];
                    $forpunchlist[$j]['empname'] = $value['Emp_Name'];
                    $j += 1;
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
             
             for($k=1; $k<=12; $k++){
                 $month = Carbon::createFromDate(2016, $k, 1, 'Asia/Kolkata');
                 $montharray[] = $month->format('F');
             }

           return view('newemployeezone.lms.overall_employeeattendance_screen')->with(['getemployeedata'=>$getemployeedata,'forpunchlist' => $forpunchlist,'montharray' => $montharray, 'yeararray'=>$yeararray,'currentyear' => $currentyear,'currentmonth'=>$currentmonth,'currentdate'=>$currentdate,'profilepic'=>$profilepic, 'employeeid' => $employeeid]);


        }else{
            return view('newemployeezone.login');
        }
    }


     public function postoverall_employeeattendance(Request $request)
   {

        if ($request->session()->has('employeesession')) {
            $encrypt = $request->session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $employeeid = $split[0];
            $getemployeedata = DB::connection('mysql6')->table('employee')->where('id', '=', $employeeid)->get();

            $validate = $this->validate($request, [
                'monthname' => 'required',
                'yearname' => 'required',
                'employeeid' => 'required'
                ]);
            $employeeid = $request->employeeid;

        
                $requested_month = Carbon::parse($request->yearname.'-'.$request->monthname.'-01')->toDateString();
                $newattendance_view_startdate = '2018-07-01';
                if(Carbon::parse($requested_month)->gte(Carbon::parse($newattendance_view_startdate))){
                    $monthnumber = Carbon::parse($requested_month)->format('m');
                    $monthyear = Carbon::parse($requested_month)->format('Y');
                    $attendance = $this->newattendancesummary($employeeid, $monthnumber, $monthyear);
		    $processed_attendance = $this->weekoff_holiday_process($attendance);
             $attendance = $processed_attendance;
                    //dd($attendance);
                }
                else{
                    return $this->oldattendance($requested_month);
                }
             
            $currentdate = Carbon::now()->toDateString();

             $summary = [];

             $summary['total_days'] = 0;
             $summary['weekoff'] = 0;
             $summary['holiday'] = 0;

             $summary['absent'] = 0;
             $summary['present'] = 0;

             $summary['LOP'] = 0;
             $summary['CL'] = 0;
             $summary['SL'] = 0;
             $summary['PL'] = 0;
             $summary['Permission'] = 0;
             $summary['RH'] = 0;
             $summary['ML'] = 0;
             $summary['Onduty'] = 0;
             $summary['Tour'] = 0;
             $summary['Compoff'] = 0;
             $summary['Mispunch'] = 0;

             $summary['latecount'] = 0;
             $summary['earlyoutcount'] = 0;

             $summary['late_earlyout_lop'] = 0;             

             foreach($attendance as $sum_key => $sum_val){
                 $currendate = Carbon::now()->toDateString();
                 if(Carbon::parse($sum_val['shift_date'])->lt(Carbon::parse($currentdate))){
                    $summary['total_days'] += 1;
                 }
                 if($sum_val['weekoff'] == true){
                    $summary['weekoff'] += 1;
                 }
                 if($sum_val['holiday'] == true){
                    $summary['holiday'] += 1;
                 }

                 if($sum_val['latecount'] != 0){
                    $summary['latecount'] += 1;
                 }

                 if($sum_val['earlyoutcount'] != 0){
                    $summary['earlyoutcount'] += 1;
                 }
                 
                    $summary['absent'] += $sum_val['absent'];
                    $summary['present'] += $sum_val['present'];

                    $summary['late_earlyout_lop'] += $sum_val['first_half_lop'] + $sum_val['second_half_lop'];


                    if (count($sum_val['lms_applications']) > 0) {
                        foreach($sum_val['lms_applications'] as $lms_key => $lms_val){
                            if($lms_val->type == 'Permission'){
                                if($lms_val->partial_days == 'full'){ $cc = 1;}else{ $cc = 1; }
                                $summary[$lms_val->type] += $cc;
                            }
                            elseif($lms_val->type == 'LOP'){
                                if($lms_val->partial_days == 'full'){ $cc = 1;}else{ $cc = 0.5; }
                                $summary[$lms_val->type] += $cc;
                                //$summary['late_earlyout_lop'] -= $cc;
                            }
                            else{
                                if($lms_val->partial_days == 'full'){ $cc = 1;}else{ $cc = 0.5; }
                                $summary[$lms_val->type] += $cc;
                            }
                            
                        }
                        
                    }
                    
                 
             }

             
             $dropdown_year = Carbon::now()->format('Y');
             $drop_down_months = Carbon::now()->format('m');
             $dropmontharray = [];
             for($i = 1; $i<=$drop_down_months; $i++){
                 $dropmontharray[$i] = Carbon::parse($dropdown_year.'-'.$i.'-01')->format('F');
             }    
             $currentmonthinno = Carbon::parse($requested_month)->format('m');  
             $cc = Carbon::now()->toDateString();
             if(Carbon::now()->format('m') == $currentmonthinno){
                $tt = 'Total Worked days as on '.Carbon::parse($cc)->subDay()->format('d.m.Y');
             }
             else{
                $tt = 'Total Worked days';
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

             $currentmonth = $request->monthname;
             $currentyear = $request->yearname;

             //dd($summary);
             $summarytitle = Carbon::parse($requested_month)->format('F').' '.Carbon::parse($requested_month)->format('Y').' Attendance Summary';

             $listfiles = Storage::disk('s3')->files("/newcustomerzoneassets/employeeprofileimage/".$employeeid);             
             if(count($listfiles) > 0){
                $profilepic = config('app.AWS_URL')."/".$listfiles[0];
            }
             else
             {
                $profilepic = config('app.AWS_URL')."/newcustomerzoneassets/img/dummy_male.png";
             }
                          
             return view('newemployeezone.lms.attendance_view')->with(['getemployeedata'=> $getemployeedata,'workdaystext' => $tt,'summarytitle'=>$summarytitle,'dropmontharray' => $dropmontharray,'dropdown_year' => $dropdown_year,'currentmonthinno' => $currentmonthinno,'summary' => $summary,'yeararray' => $yeararray, 'montharray' => $montharray,'currentmonth' => $currentmonth,'currentyear' => $currentyear,'attendance'=>$attendance,'profilepic' => $profilepic]);
             
              }
        else{
            return redirect()->route('newemployee_home');
        }


        
    }

	public function payroll_reportview(Request $request)
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

             

          $data['column'] = [];
	  $data['row'] = [];


             //dd($data);

        return view('newemployeezone.lms.payroll_reportview')->with(['getemployeedata'=> $getemployeedata,'data'=>$data,'profilepic' => $profilepic]);
        }else{
            return redirect()->route('newemployee_home');
        }
    }

    public function postpayroll_reportview(Request $request)
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

             //$prev_month = Carbon::now()->subMonth()->format('m');
             //$prev_month_year = Carbon::now()->subMonth()->format('Y');
             //$requestedmonthdate = Carbon::now()->subMonth()->toDateString();
		$prev_month = '06';
                $prev_month_year = '2020';
                $requestedmonthdate = $prev_month_year.'-'.$prev_month.'-01';

             //$get_lms_applications = DB::connection('mysql6')->table('datetime_ref')->where(['employeeid' => $employeeid,'month' => $prev_month, 'year' => $prev_month_year,'final_status' => 'Approved' ])->get();
             $data = $this->payroll_report_attendance($employeeid, $prev_month, $prev_month_year, $requestedmonthdate);


             //dd($data);

        return view('newemployeezone.lms.payroll_reportview')->with(['getemployeedata'=> $getemployeedata,'data'=>$data,'profilepic' => $profilepic]);
        }else{
            return redirect()->route('newemployee_home');
        }
    }

    public function remaindermail_sms()
    {

        $currentdate = Carbon::now()->toDateString();
        $endofcurrentmonth = Carbon::parse($currentdate)->endOfMonth()->toDateString();
        $getcurrentmonthlast6days_date = Carbon::parse($endofcurrentmonth)->subDays(6)->toDateString();
        $month = Carbon::now()->format('m');
        $year = Carbon::now()->format('Y');

        if ((Carbon::parse($currentdate)->gte(Carbon::parse($getcurrentmonthlast6days_date))) && (Carbon::parse($currentdate)->lte(Carbon::parse($endofcurrentmonth)))) {

        	 $getpending_data = DB::connection('mysql6')->table('leave_processed')->where([
            'month' => $month,
            'year' => $year,
            'hod_status' => 'Pending'
        ])->get();

        
        if (count($getpending_data) > 0) {
            DB::connection('mysql6')->table('remainder_sms_email_employee')->truncate();
            $grouping_data = [];
            foreach ($getpending_data as $key => $value) {
                $grouping_data[$value->employeeid][] = $value;
            }
        $getactiveemployees = $this->getallactiveemployees();
                
            foreach ($getactiveemployees['Details'] as $key1 => $value1) {
                  foreach ($grouping_data as $key3 => $value3) {
                      if ($value1['Emp_ID'] == $key3) {
                          $name = $value1['Emp_Name'];
                          $emailid = $value1['Official_Mail'];
                          $mobno = $value1['Personal_Mobile'];
                          $emp_details = json_encode($value3);
                          $reporting_id = $value1['RM_ID'];
                          $emp_msg_tosent = "Please get your pending leaves/OD approved by HOD earliest to avoid LOP.";
                          $reportind_name = null;
                          $reportind_mailid = null;
                          $reportind_number = null;
                          //dd($getactiveemployees['Details']);
                          foreach ($getactiveemployees['Details'] as $key4 => $value4) {
                                if ($value4['Emp_ID'] == $value1['RM_ID']) {
                                  $reportind_name = $value4['Emp_Name'];
                                  $reportind_mailid = $value4['Official_Mail'];
                                  $reportind_number = $value4['Personal_Mobile'];
                              }
                          }

                          if ($reportind_name != null) {
                            if (empty($emailid)) {
                                $emailid = 'noemail@vgn.in';
                            }
                            if (empty($reportind_mailid)) {
                                $reportind_mailid = 'noemail@vgn.in';
                            }
                               DB::connection('mysql6')->table('remainder_sms_email_employee')->insert([
                              'id' => null,
                              'reporting_id' => $reporting_id,
                              'reporting_name' => $reportind_name,
                              'reporting_mailid' => $reportind_mailid,
                              'reporting_number' => $reportind_number,
                              'reporting_msg' => 'Please approve the below pending leaves/OD which are awaiting for approval in your workflow.The leaves which are not approved on or before 31st will be considered as LOP.',
                              'employeeid' => $value1['Emp_ID'],
                              'empname' => $name,
                              'emp_emailid' => $emailid,
                              'emp_mobilenumber' => $mobno,
                              'employee_details' => $emp_details,
                              'employee_msg' => $emp_msg_tosent,
                              'created_datetime' => Carbon::now()->toDateTimeString(),
                              'mailsent_to_hod' => 'N',
                              'smssent_to_hod' => 'N',
                              'mailsent_to_emp' => 'N',
                              'smssent_to_emp' => 'N'
                          ]);
                          }
                          
                         
                          
                      }
                  }
            }


        dd('Data loaded to send remaindar email to hod...');

        }else{
            dd('No pending leaves...');
        }
        	
        }
        else{
        	dd('Time Period not meet...');
        }
       

        


        
    }

    public function sendremaindermail_hod()
    {
        $getdata = DB::connection('mysql6')->table('remainder_sms_email_employee')->where(['mailsent_to_hod' => 'N'])->get();
        if (count($getdata) > 0) {
            $newmaildata = [];

            foreach ($getdata as $key => $value) {
                $newmaildata[$value->reporting_id][] = (array)$value;
            }


            if (count($newmaildata) > 0) {
                $i =1;
                foreach ($newmaildata as $nkey => $nvalue) {
                    if ($i <= 5) {
                        $hodmailid = '';
                        
                        foreach ($nvalue as $key6 => $value6) {
                            $jsondecoded_val = json_decode($value6['employee_details']);
                            //dd(json_decode($value6['employee_details']));
                            $kk = [];

                            //$nvalue[$key6]['employee_details'] = $kk;
                            //dd($jsondecoded_val);
                            foreach ($jsondecoded_val as $key7 => $value7) {
                                $vv = (array)$value7;
                                $kk[$key7] = $vv;
                                $kk[$key7]['hashed_hod_key'] = null;
                                $getsessionhashkey = DB::connection('mysql6')->table('lms_mail_queue')->where(['reference_id' => $vv['id'], 'processed' => 0])->where('hod_session_key','!=', null)->get();

                                if(count($getsessionhashkey) > 0){
                                         foreach ($getsessionhashkey as $key5 => $value5) {
                                            $kk[$key7]['hashed_hod_key'] = $value5->hod_session_key;
                                         }
                                     }
                            }
                            $nvalue[$key6]['employee_details'] = $kk;
                    }

                    //dd($nvalue[0]['reporting_id']);
                        
                        if ($nvalue[0]['reporting_id'] == "100000") {
                            Log::info('LMS Remainder mail sent to... cc mdsecretary@vgn.in');
                            Mail::to("mdsecretary@vgn.in")->send(new lmsappremainderemailtohod($nvalue));  
                        }
                        $hodmailid = $nvalue[0]['reporting_mailid'];
                        //$hodmailid = 'naveenv@vgn.in';
                        Log::info('LMS Remainder mail sent to... '.$hodmailid );
                        Mail::to($hodmailid)->send(new lmsappremainderemailtohod($nvalue));
                        
                        foreach ($nvalue as $key3 => $value3) {
                            DB::connection('mysql6')->table('remainder_sms_email_employee')->where(['id' => $value3['id']])->update(['mailsent_to_hod' => 'Y']);
                        }
                        $i++;
                    }
                }
            }

            dd('ok remainder mail sent to employee');


            //Mail::to($jj)->send(new lmsappremainderemailtohod($newmaildata)); 
        }else{
            dd('No data to send mail...');
        }
        
    }

    public function sendremaindermail_emp()
    {
        $getdata = DB::connection('mysql6')->table('remainder_sms_email_employee')->where(['mailsent_to_emp' => 'N'])->get();

        
        if (count($getdata) > 0) {
            $newmaildata = [];

            foreach ($getdata as $key => $value) {
                $newmaildata[$value->reporting_id][] = (array)$value;
            }


            if (count($getdata) > 0) {
                $i =1;
                foreach ($getdata as $nkey => $nvalue) {
                    $nvalue = (array)$nvalue;
                    
                    if ($i <= 5) {
                        
                        $jsondecoded_val = json_decode($nvalue['employee_details']);
                        $kk = [];

                            //$nvalue[$key6]['employee_details'] = $kk;
                            //dd($jsondecoded_val);
                            foreach ($jsondecoded_val as $key7 => $value7) {
                                $vv = (array)$value7;
                                $kk[$key7] = $vv;
                                $kk[$key7]['hashed_hod_key'] = null;
                                $getsessionhashkey = DB::connection('mysql6')->table('lms_mail_queue')->where(['reference_id' => $vv['id'], 'processed' => 0])->where('hod_session_key','!=', null)->get();

                                if(count($getsessionhashkey) > 0){
                                         foreach ($getsessionhashkey as $key5 => $value5) {
                                            $kk[$key7]['hashed_hod_key'] = $value5->hod_session_key;
                                         }
                                     }
                            }
                            $nvalue['employee_details'] = $kk;
                        
                            //dd($nvalue['emp_emailid']);
                            $empmailid = $nvalue['emp_emailid'];
                            //$empmailid = 'naveenv@vgn.in';
                            Log::info('LMS Remainder mail sent to... '.$nvalue['emp_emailid'] );
                        Mail::to($empmailid)->send(new lmsappremainderemailtoemp($nvalue));
                        //dd($nvalue);
                        
                            DB::connection('mysql6')->table('remainder_sms_email_employee')->where(['id' => $nvalue['id']])->update(['mailsent_to_emp' => 'Y']);
                        
                        $i++;
                    }
                }
            }

            dd('ok remainder mail sent');


            //Mail::to($jj)->send(new lmsappremainderemailtohod($newmaildata)); 
        }
        else{
            dd('No data to send mail');
        }
        
    }
       
    public function leavecrudhr(Request $request)
    {
        if ($request->session()->has('employeesession')) {
            $encrypt = $request->session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $employeeid = $split[0];
            $mydetails = [];
            $getemployeedata = DB::connection('mysql6')->table('employee')->where('id', '=', $employeeid)->get();
    
            if (in_array($employeeid, config('newlmsconfig'))) {
                $valid = 1;
            }else{
                return redirect()->route('newemployee_home');
            }
    
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
    
    
            $getactiveemployees = $this->getallactiveemployees();
            
            $getsubordinates = [];
            $forpunchlist = [];
    
            if (count($getactiveemployees) > 0) {
                $i=0;
                $j = 0;
                foreach ($getactiveemployees['Details'] as $key => $value) {
                        $forpunchlist[$j]['empid'] = $value['Emp_ID'];
                        $forpunchlist[$j]['empname'] = $value['Emp_Name'];
                        $j += 1;
                }    
            }

            //dd($forpunchlist);
            
    
            return view('newemployeezone.lms.leavecrudhr')->with(['getemployeedata'=>$getemployeedata,'forpunchlist' => $forpunchlist,'profilepic'=>$profilepic, 'employeeid' => $employeeid]);
    
        }
    
        return view('newemployeezone.login');
    }

 public function postleavecrudhr_bal(Request $request)
    {
        if ($request->session()->has('employeesession')) {
            $encrypt = $request->session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $employeeid = $split[0];
            $mydetails = [];
            $getemployeedata = DB::connection('mysql6')->table('employee')->where('id', '=', $employeeid)->get();
    
            if (in_array($employeeid, config('newlmsconfig'))) {
                $valid = 1;
            }else{
                return redirect()->route('newemployee_home');
            }

            $request->month = trim($request->month);
            $request->year = trim($request->year);

            if ((($request->month >= 1) && ($request->month <= 12)) && ($request->year >= 2018)) {
                
                
                //return json_encode($daterange_array);
                
                $getapplications = DB::connection('mysql6')->table('leave_balance')->where(['employeeid' => $request->employeeid, 'month' => $request->month, 'year' => $request->year])->get();

                if (count($getapplications) > 0) {
                    return json_encode($getapplications);
                }
                else{
                    return 0;
                }
                

            }
            else{
                return 0;
            }

            

            

            
    
        }
    
        return 0;
    }

    public function postleavecrudhr(Request $request)
    {
        if ($request->session()->has('employeesession')) {
            $encrypt = $request->session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $employeeid = $split[0];
            $mydetails = [];
            $getemployeedata = DB::connection('mysql6')->table('employee')->where('id', '=', $employeeid)->get();
    
            if (in_array($employeeid, config('newlmsconfig'))) {
                $valid = 1;
            }else{
                return redirect()->route('newemployee_home');
            }

            $request->month = trim($request->month);
            $request->year = trim($request->year);

            if ((($request->month >= 1) && ($request->month <= 12)) && ($request->year >= 2018)) {
                
                $daterange_array = array();
                $startdate = Carbon::parse($request->year.'-'.$request->month.'-01')->toDateString();
                 $currentdate = Carbon::parse(Carbon::now())->toDateString();
                $enddate = Carbon::parse($startdate)->endOfMonth()->toDateString();
                if (Carbon::parse($startdate)->gt(Carbon::parse($currentdate))) {
                    return 0;
                }
                $daterange_array = $this->createDateRange($startdate, $enddate, $format = "Y-m-d");
                array_push($daterange_array, $enddate);

                //return json_encode($daterange_array);
                
                $getapplications = DB::connection('mysql6')->table('datetime_ref')->where(['employeeid' => $request->employeeid, 'month' => $request->month, 'year' => $request->year])->get();
                $first_step = [];
                foreach ($daterange_array as $key => $value) {
                    $first_step[$value]['first_half'] = '';
                    $first_step[$value]['second_half'] = '';
                    $first_step[$value]['full'] = '';

                    foreach ($getapplications as $key1 => $value1) {
                        if($value1->date == $value){
                            if (($value1->final_status == 'Approved') || ($value1->final_status == 'Pending')) {
                                $first_step[$value][$value1->partial_days] = $value1->type;    
                            }                            
                            
                        }
                    }


                }


                return json_encode($first_step);

            }
            else{
                return 0;
            }

            

            

            
    
        }
    
        return 0;
    }

    public function postdate_leavecrudhr(Request $request)
    {
         if ($request->session()->has('employeesession')) {
            $encrypt = $request->session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $employeeid = $split[0];
            $mydetails = [];
            $getemployeedata = DB::connection('mysql6')->table('employee')->where('id', '=', $employeeid)->get();
    
            if (in_array($employeeid, config('newlmsconfig'))) {
                $valid = 1;
            }else{
                return redirect()->route('newemployee_home');
            }

            $leavetypeselected = trim($request->leavetypeselected);
            $partialdaysselected = trim($request->partialdaysselected);
            $requesteddate = trim($request->requesteddate);
            $req_empid = trim($request->req_empid);
            $req_type = trim($request->req_type);
            $requesteddate = Carbon::parse($requesteddate)->toDateString();


            $requestedmonth = Carbon::parse($requesteddate)->format('m');
            $requestedyear = Carbon::parse($requesteddate)->format('Y');
            $currentmonth = Carbon::now()->format('m');
            $currentyear = Carbon::now()->format('Y');

            $check_payroll_runned = DB::connection('mysql6')->table('leave_balance')->where(['employeeid' => $req_empid, 'month' => $requestedmonth,'year' => $requestedyear, 'completed' => 'Y'])->get();

            if(count($check_payroll_runned) == 0){
                
                if (($leavetypeselected == 'Onduty') || ($leavetypeselected == 'Tour') || ($leavetypeselected == 'Compoff') || ($leavetypeselected == 'Mispunch') || ($leavetypeselected == 'LOP')) {
                    if ($leavetypeselected == 'Tour') {
                        if ($partialdaysselected != 'full') {
                            return 'Tour can contain only Full day!';
                        }
                    }
                    if ($leavetypeselected == 'Mispunch') {
                        if ($partialdaysselected == 'full') {
                            return 'Mispunch can contain only first/second Half!';
                        }
                    }

                    if ($req_type == 'admindelete') {
                        if (($requestedmonth == '12') && ($currentmonth == '01' )) {
                            return 'Calendar Year Accrual Process scheduled. Please contact Developer';
                        }
                        else{
                            
                                $checkleave_balance = DB::connection('mysql6')->table('leave_balance')->where(['employeeid' => $req_empid, 'month' => $requestedmonth,'year' => $requestedyear, 'completed' => 'N'])->get(); 
                                if (count($checkleave_balance) > 0) {
                                    foreach ($checkleave_balance as $key => $value) {
                                        $leavbalance = $value->$leavetypeselected;
                                    }           

                                    

                                        $checkanyapplicationcreated = DB::connection('mysql6')->table('datetime_ref')->where(['employeeid' => $req_empid, 'date' => $requesteddate,'type' => $leavetypeselected,'partial_days' => $partialdaysselected])->whereIn('final_status',['Approved','Pending'])->get();
                                        if(count($checkanyapplicationcreated) > 0){
                                            foreach($checkanyapplicationcreated as $k => $v){
                                                $primaryid = $v->reference_id;
                                                $final_status = $v->final_status;
                                                $application_type = $v->type;
                                                $application_partial_days = $v->partial_days;
                                            }


                                            if (($application_type == 'Onduty') || ($application_type == 'Compoff') || ($application_type == 'Mispunch')) {
                                                if ($application_partial_days == 'full') { $count = 1; }else{ $count = 0.5; }
                                                
                                                if ($leavbalance == null) {
                                                    $todededuct = 0;
                                                }else{
                                                $todededuct = $leavbalance - $count;
                                                }
                                               
                                            }
                                            else{
                                                $getdata = DB::connection('mysql6')->table('datetime_ref')->where(['reference_id' => $primaryid])->whereIn('final_status',['Approved','Pending'])->get();
                                                if ($application_partial_days == 'full') { $count = count($getdata); }else{ $count = 0.5; }
                                                if ($leavbalance == null) {
                                                    $todededuct = 0;
                                                }else{
                                                $todededuct = $leavbalance - $count;
                                                }

                                            }

                                            
                                            $getlms_application = DB::connection('mysql6')->table('leave_processed')->where(['employeeid' => $req_empid, 'id' => $primaryid,'type' => $leavetypeselected,'partial_days' => $partialdaysselected])->whereIn('final_status',['Approved','Pending'])->get();
                                            $newar = [];
                                            $newar['employeeid'] = $req_empid;
                            
                                            foreach ($getlms_application as $key26 => $value26) {
                                                $sap_fromdate = $value26->stdate;
                                                $sap_todate = $value26->etdate;
                                                $sap_no_of_days = $value26->no_of_days;
                                                $sap_partial_days = $value26->partial_days;
                                                $sap_leave_type = $value26->type;
                                            }
                                            
                            
                                            if ($sap_partial_days == 'full') {
                                            
                                                $newar['from_date'] = substr($sap_fromdate,0,10);
                                                $newar['to_date'] = substr($sap_todate,0,10);
                                                $newar['starttime'] = '';
                                                $newar['endtime'] = '';
                            
                                            }
                                            elseif($sap_partial_days == 'first_half'){
                                                $newar['from_date'] = substr($sap_fromdate,0,10);
                                                $newar['to_date'] = substr($sap_todate,0,10);
                                                $newar['starttime'] = substr($sap_fromdate,11,5);
                                                $newar['endtime'] = substr($sap_todate,11,5);
                            
                                            }
                                            elseif($sap_partial_days == 'second_half'){
                                                $newar['from_date'] = substr($sap_fromdate,0,10);
                                                $newar['to_date'] = substr($sap_todate,0,10);
                                                $newar['starttime'] = substr($sap_fromdate,11,5);
                                                $newar['endtime'] = substr($sap_todate,11,5);
                            
                                            }else{
                                                //sd
                                            }
                                            $newar['leave_type'] = $leavetypeselected;
                                            //return $newar;

                                            $deleteappl = $this->delete_leave_applied($newar);

                                            Log::info('Deleted application... '.$req_empid.' '.$leavetypeselected.' '.$sap_fromdate.' - '.$sap_todate.' - SAP Satus '.$deleteappl['Status']);

                                            if($deleteappl['Status'] == "Updated Successfully"){
                                            DB::connection('mysql6')->table('datetime_ref')->where(['employeeid' => $req_empid,'reference_id' => $primaryid])->delete();
                                            DB::connection('mysql6')->table('leave_processed')->where(['employeeid' => $req_empid,'id' => $primaryid])->delete();

                                           
                                                
                                            if ($requestedmonth != $currentmonth) {
                                                $xcheckleave_balance = DB::connection('mysql6')->table('leave_balance')->where(['employeeid' => $req_empid, 'month' => $currentmonth,'year' => $currentyear, 'completed' => 'N'])->get(); 
                                if (count($xcheckleave_balance) > 0) {
                                    foreach ($xcheckleave_balance as $kkey => $kvalue) {
                                        $kleavbalance = $kvalue->$leavetypeselected;
                                    }
                                    $todededuct = $kleavbalance - $count;

                                    DB::connection('mysql6')->table('leave_balance')->where(['employeeid' => $req_empid,'month' => $currentmonth,'year' => $currentyear, 'completed' => 'N'])->update([
                                                    $leavetypeselected => $todededuct
                                                ]);
                                }
                                                
                                            }
                                            else{
                                                 DB::connection('mysql6')->table('leave_balance')->where(['employeeid' => $req_empid,'month' => $requestedmonth,'year' => $requestedyear, 'completed' => 'N'])->update([
                                                    $leavetypeselected => $todededuct
                                                ]);
                                            }

                                            


                                                //to send data to sap remember
                                                return 'Application Deleted';
                                            }
                                            else{
                                                return 'Error Occured in SAP. Please check if any user accessing this employeeid in SAP';
                                            }

                                        }
                                        else{
                                            
                                            return 'There is no application found for the given data!';

                                        }
                                        
                                    
                                    
                                }
                                else{
                                    return 'No leave balance row created for the month - '.$requestedmonth;
                                }       
                            
                            
                        }

                    }

                    if ($req_type == 'admincreate') {
                    
                    $checkanyapplicationcreated = DB::connection('mysql6')->table('datetime_ref')->where(['employeeid' => $req_empid, 'date' => $requesteddate,'type' => $leavetypeselected,'partial_days' => $partialdaysselected])->whereIn('final_status',['Approved','Pending'])->get();
                                        if(count($checkanyapplicationcreated) > 0){
                                            return 'The same application created already. Please delete the application recreate!';
                                        }
                                        else{
                                            if (($partialdaysselected == 'first_half') || ($partialdaysselected == 'second_half')) {
                                            $ncheckanyapplicationcreated = DB::connection('mysql6')->table('datetime_ref')->where(['employeeid' => $req_empid, 'date' => $requesteddate,'partial_days' => 'full'])->whereIn('final_status',['Approved','Pending'])->get();
                                            if(count($ncheckanyapplicationcreated) > 0){
                                                return 'Application already applied for full day. Please delete application and try it!';
                                            }
                                        }

                                        if ($partialdaysselected == 'full') {
                                            $ncheckanyapplicationcreated = DB::connection('mysql6')->table('datetime_ref')->where(['employeeid' => $req_empid, 'date' => $requesteddate,'partial_days' => 'full'])->whereIn('final_status',['Approved','Pending'])->get();
                                            if(count($ncheckanyapplicationcreated) > 0){
                                                return 'Application already applied for full day. Please delete application and try it!';
                                            }
                                            $ycheckanyapplicationcreated = DB::connection('mysql6')->table('datetime_ref')->where(['employeeid' => $req_empid, 'date' => $requesteddate])->whereIn('partial_days',['first_half','second_half'])->whereIn('final_status',['Approved','Pending'])->get();
                                            if(count($ycheckanyapplicationcreated) > 0){
                                                return 'Application already applied for first/second half day. Please delete application and try full day!';
                                            }
                                        }

                                            $res = $this->leavecrud_create_application($req_empid, $requesteddate,$partialdaysselected,$leavetypeselected);
                                            if($res == 1){
                                                return 'Application Added!';
                                            }
                                            else{
                                                return 'Application Not Added!';    
                                            }
                                            

                                        }
                        }


                }
                elseif (($leavetypeselected == 'CL') || ($leavetypeselected == 'SL') || ($leavetypeselected == 'PL') || ($leavetypeselected == 'ML') || ($leavetypeselected == 'RH') || ($leavetypeselected == 'Permission')) {
                    if ($leavetypeselected == 'Permission') {
                        if ($partialdaysselected == 'full') {
                            return 'Permission can contain only first/second Half!';
                        }
                    }


                    if($partialdaysselected == 'full'){
                        $tominus = 1;
                    }
                    else{
                        $tominus = 0.5;
                    }
                    //check leave balance avaiable.

                    if ($req_type == 'admindelete') {
                        if (($requestedmonth == '12') && ($currentmonth == '01' )) {
                            return 'Calendar Year Accrual Process scheduled. Please contact Developer';
                        }
                        else{
                            
                                $checkleave_balance = DB::connection('mysql6')->table('leave_balance')->where(['employeeid' => $req_empid, 'month' => $requestedmonth,'year' => $requestedyear, 'completed' => 'N'])->get(); 
                                if (count($checkleave_balance) > 0) {
                                    foreach ($checkleave_balance as $key => $value) {
                                        $leavbalance = $value->$leavetypeselected;
                                    }           

                                    

                                        $checkanyapplicationcreated = DB::connection('mysql6')->table('datetime_ref')->where(['employeeid' => $req_empid, 'date' => $requesteddate,'type' => $leavetypeselected,'partial_days' => $partialdaysselected])->whereIn('final_status',['Approved','Pending'])->get();
                                        if(count($checkanyapplicationcreated) > 0){
                                            foreach($checkanyapplicationcreated as $k => $v){
                                                $primaryid = $v->reference_id;
                                                $final_status = $v->final_status;
                                                $application_type = $v->type;
                                                $application_partial_days = $v->partial_days;
                                            }

                                           
                                            if (($application_type == 'Permission')) {
                                                $count = 1;
                                                
                                                if ($leavbalance == null) {
                                                    $todededuct = 0 + $count;
                                                }else{
                                                $todededuct = $leavbalance + $count;
                                                }
                                               
                                            }
                                            else{
                                                $getdata = DB::connection('mysql6')->table('datetime_ref')->where(['reference_id' => $primaryid])->whereIn('final_status',['Approved','Pending'])->get();
                                                if ($application_partial_days == 'full') { $count = count($getdata); }else{ $count = 0.5; }
                                                if ($leavbalance == null) {
                                                    $todededuct = 0 + $count;
                                                }else{
                                                $todededuct = $leavbalance + $count;
                                                }

                                            }


                                            $getlms_application = DB::connection('mysql6')->table('leave_processed')->where(['employeeid' => $req_empid, 'id' => $primaryid,'type' => $leavetypeselected,'partial_days' => $partialdaysselected])->whereIn('final_status',['Approved','Pending'])->get();
                                            $newar = [];
                                            $newar['employeeid'] = $req_empid;
                            
                                            foreach ($getlms_application as $key26 => $value26) {
                                                $sap_fromdate = $value26->stdate;
                                                $sap_todate = $value26->etdate;
                                                $sap_no_of_days = $value26->no_of_days;
                                                $sap_partial_days = $value26->partial_days;
                                                $sap_leave_type = $value26->type;
                                            }
                                            
                            
                                            if ($sap_partial_days == 'full') {
                                            
                                                $newar['from_date'] = substr($sap_fromdate,0,10);
                                                $newar['to_date'] = substr($sap_todate,0,10);
                                                $newar['starttime'] = '';
                                                $newar['endtime'] = '';
                            
                                            }
                                            elseif($sap_partial_days == 'first_half'){
                                                $newar['from_date'] = substr($sap_fromdate,0,10);
                                                $newar['to_date'] = substr($sap_todate,0,10);
                                                $newar['starttime'] = substr($sap_fromdate,11,5);
                                                $newar['endtime'] = substr($sap_todate,11,5);
                            
                                            }
                                            elseif($sap_partial_days == 'second_half'){
                                                $newar['from_date'] = substr($sap_fromdate,0,10);
                                                $newar['to_date'] = substr($sap_todate,0,10);
                                                $newar['starttime'] = substr($sap_fromdate,11,5);
                                                $newar['endtime'] = substr($sap_todate,11,5);
                            
                                            }else{
                                                //sd
                                            }
                                            $newar['leave_type'] = $leavetypeselected;
                                            //return $newar;

                                            $deleteappl = $this->delete_leave_applied($newar);

                                            Log::info('Deleted application... '.$req_empid.' '.$leavetypeselected.' '.$sap_fromdate.' - '.$sap_todate.' - SAP Satus '.$deleteappl['Status']);

                                            if($deleteappl['Status'] == "Updated Successfully"){
                                                
                                            DB::connection('mysql6')->table('datetime_ref')->where(['employeeid' => $req_empid,'reference_id' => $primaryid])->delete();
                                            DB::connection('mysql6')->table('leave_processed')->where(['employeeid' => $req_empid,'id' => $primaryid])->delete();
                                           

                                            if ($requestedmonth != $currentmonth) {
                                                $xcheckleave_balance = DB::connection('mysql6')->table('leave_balance')->where(['employeeid' => $req_empid, 'month' => $currentmonth,'year' => $currentyear, 'completed' => 'N'])->get(); 
                                if (count($xcheckleave_balance) > 0) {
                                    foreach ($xcheckleave_balance as $kkey => $kvalue) {
                                        $kleavbalance = $kvalue->$leavetypeselected;
                                    }
                                    $todededuct = $kleavbalance + $count;

                                    DB::connection('mysql6')->table('leave_balance')->where(['employeeid' => $req_empid,'month' => $currentmonth,'year' => $currentyear, 'completed' => 'N'])->update([
                                                    $leavetypeselected => $todededuct
                                                ]);
                                }

                                
                                                
                                            }
                                            else{
                                                 DB::connection('mysql6')->table('leave_balance')->where(['employeeid' => $req_empid,'month' => $requestedmonth,'year' => $requestedyear, 'completed' => 'N'])->update([
                                                    $leavetypeselected => $todededuct
                                                ]);
                                            }

                                            return 'Application Deleted';
                                        }
                                        else{
                                            return 'Error Occured in SAP. Please check if any user accessing this employeeid in SAP';
                                        }

                                                //to send data to sap remember
                                                


                                        }
                                        else{
                                            
                                            return 'There is no application found for the given data!';

                                        }
                                        
                                    
                                    
                                }
                                else{
                                    return 'No leave balance row created for the month - '.$requestedmonth;
                                }       
                            
                            
                        }

                    }

                    if ($req_type == 'admincreate') {
                        
                        if (($requestedmonth == '12') && ($currentmonth == '01' )) {
                            return 'Calendar Year Accrual Process scheduled. Please contact Developer';
                        }
                        else{
                            
                                $checkleave_balance = DB::connection('mysql6')->table('leave_balance')->where(['employeeid' => $req_empid, 'month' => $requestedmonth,'year' => $requestedyear, 'completed' => 'N'])->get(); 
                                if (count($checkleave_balance) > 0) {
                                    foreach ($checkleave_balance as $key => $value) {
                                        $leavbalance = $value->$leavetypeselected;
                                    }           

                                    $checkbyminus = $leavbalance - $tominus;
                                    if ($checkbyminus >= 0) {

                                        $checkanyapplicationcreated = DB::connection('mysql6')->table('datetime_ref')->where(['employeeid' => $req_empid, 'date' => $requesteddate,'type' => $leavetypeselected,'partial_days' => $partialdaysselected])->whereIn('final_status',['Approved','Pending'])->get();
                                        
                                        if(count($checkanyapplicationcreated) > 0){
                                            return 'The same application created already. Please delete the application recreate!';
                                        }
                                        else{
                                            if (($partialdaysselected == 'first_half') || ($partialdaysselected == 'second_half')) {
                                            $ncheckanyapplicationcreated = DB::connection('mysql6')->table('datetime_ref')->where(['employeeid' => $req_empid, 'date' => $requesteddate,'partial_days' => 'full'])->whereIn('final_status',['Approved','Pending'])->get();
                                            if(count($ncheckanyapplicationcreated) > 0){
                                                return 'Application already applied for full day. Please delete application and try it!';
                                            }
                                        }

                                        if ($partialdaysselected == 'full') {
                                            $ncheckanyapplicationcreated = DB::connection('mysql6')->table('datetime_ref')->where(['employeeid' => $req_empid, 'date' => $requesteddate,'partial_days' => 'full'])->whereIn('final_status',['Approved','Pending'])->get();
                                            if(count($ncheckanyapplicationcreated) > 0){
                                                return 'Application already applied for full day. Please delete application and try it!';
                                            }
                                            $ycheckanyapplicationcreated = DB::connection('mysql6')->table('datetime_ref')->where(['employeeid' => $req_empid, 'date' => $requesteddate])->whereIn('partial_days',['first_half','second_half'])->whereIn('final_status',['Approved','Pending'])->get();
                                            if(count($ycheckanyapplicationcreated) > 0){
                                                return 'Application already applied for first/second half day. Please delete application and try full day!';
                                            }
                                        }

                                            $res = $this->leavecrud_create_application($req_empid, $requesteddate,$partialdaysselected,$leavetypeselected);
                                            if($res == 1){
                                                return 'Application Added!';
                                            }
                                            else{
                                                return 'Application Not Added!';    
                                            }
                                            

                                        }
                                        
                                    }
                                    else{
                                        return 'Please check the leave balance available!';
                                    }
                                }
                                else{
                                    return 'No leave balance row created for the month - '.$requestedmonth;
                                }       
                            
                            
                        }
                        


                    }

                    


                }
                else{
                     return 'Not a valid leave type!';  
                }


            }
            else{
                return 'Cannot Edit';   
            }


            



             }
    
        return 0;
    }


    public function leavecrud_create_application($employeeid, $startdate,$partial_days,$leave_type)
    {
        

         $getshiftdetails = $this->getshiftdetailsst_et_date($employeeid, $startdate, $startdate);
            
            if (($getshiftdetails['Shift_Details']['Shift_Code'] == 'VGN_NIGT') || ($getshiftdetails['Shift_Details']['Shift_Code'] == 'VGN_FNIG')) {
                $std = Carbon::parse($startdate)->addDay()->toDateString();
            }
            else{
                $std = $startdate;
            }

            $fhourtoadd = substr(Carbon::parse($startdate.' '.$getshiftdetails['Shift_Details']['Start_Time'])->diff(Carbon::parse($std.' '.$getshiftdetails['Shift_Details']['End_Time']))->format('%H:%i:%s'), 0,2);
            
            if ($partial_days == 'first_half') { 
               $hourtoadd = $fhourtoadd/2;
               $startdatetime = $startdate.' '.$getshiftdetails['Shift_Details']['Start_Time'];
               $enddatetime = $std.' '.$getshiftdetails['Shift_Details']['End_Time'];
               
               $no_of_days = 0.5;
              

               $diffinminutes = Carbon::parse($startdatetime)->diffInSeconds(Carbon::parse($enddatetime));
               $minutesdivide = $diffinminutes/2;
               $gmate = gmdate('H:i:s', $minutesdivide);
               
               $splitsub = explode(':', $gmate);
               
               if (($getshiftdetails['Shift_Details']['Shift_Code'] == 'VGN_GEN') || ($getshiftdetails['Shift_Details']['Shift_Code'] == 'VGN_GEN2') || ($getshiftdetails['Shift_Details']['Shift_Code'] == 'VGN_RCP1') || ($getshiftdetails['Shift_Details']['Shift_Code'] == 'VGN_RCP2') || ($getshiftdetails['Shift_Details']['Shift_Code'] == 'VGN_SAP') || ($getshiftdetails['Shift_Details']['Shift_Code'] == 'VGN_MGR') ) {
               $enddatetime = Carbon::parse($startdatetime)->addHours($splitsub[0])->addMinutes($splitsub[1])->subMinutes(30)->toDateTimeString();
               $diffintimehours = Carbon::parse($startdatetime)->diffInSeconds(Carbon::parse($enddatetime));
               $no_of_hours = gmdate('H:i:s', $diffintimehours);    
               }
               else{
                   $enddatetime = Carbon::parse($startdatetime)->addHours($splitsub[0])->addMinutes($splitsub[1])->toDateTimeString();
                   $no_of_hours = $gmate;
               }
               
               
            }
            elseif ($partial_days == 'second_half') {
                $hourtoadd = $fhourtoadd/2;
                $startdatetime = $startdate.' '.$getshiftdetails['Shift_Details']['Start_Time'];
               $enddatetime = $startdate.' '.$getshiftdetails['Shift_Details']['End_Time'];
               
                $no_of_days = 0.5;

                $diffinminutes = Carbon::parse($startdatetime)->diffInSeconds(Carbon::parse($enddatetime));
                $minutesdivide = $diffinminutes/2;
                $gmate = gmdate('H:i:s', $minutesdivide);
                
                $splitsub = explode(':', $gmate);
                if (($getshiftdetails['Shift_Details']['Shift_Code'] == 'VGN_GEN') || ($getshiftdetails['Shift_Details']['Shift_Code'] == 'VGN_GEN2') || ($getshiftdetails['Shift_Details']['Shift_Code'] == 'VGN_RCP1') || ($getshiftdetails['Shift_Details']['Shift_Code'] == 'VGN_RCP2') || ($getshiftdetails['Shift_Details']['Shift_Code'] == 'VGN_SAP') || ($getshiftdetails['Shift_Details']['Shift_Code'] == 'VGN_MGR') ) {
                $startdatetime = Carbon::parse($startdatetime)->addHours($splitsub[0])->addMinutes($splitsub[1])->subMinutes(30)->toDateTimeString();
                $diffintimehours = Carbon::parse($startdatetime)->diffInSeconds(Carbon::parse($enddatetime));
                $no_of_hours = gmdate('H:i:s', $diffintimehours); 
                }
                else{
                    $startdatetime = Carbon::parse($startdatetime)->addHours($splitsub[0])->addMinutes($splitsub[1])->toDateTimeString();
                    $no_of_hours = $gmate;
                }
            }
            else{
                $startdatetime = Carbon::parse($startdate.' '.$getshiftdetails['Shift_Details']['Start_Time'])->toDateTimeString();
                $enddatetime = Carbon::parse($std.' '.$getshiftdetails['Shift_Details']['End_Time'])->toDateTimeString();
                $diffinminutes = Carbon::parse($startdatetime)->diffInSeconds(Carbon::parse($enddatetime));
                $gmate = gmdate('H:i:s', $diffinminutes);
                $no_of_hours = $gmate;
                
                $no_of_days = 1;
            }
            
            if ($leave_type == 'Permission') {
                $no_of_hours = '01:30:00';
                $no_of_days = null;
                if ($partial_days == 'first_half') {
                    
                    $enddatetime = Carbon::parse($startdatetime)->addMinutes(90)->toDateTimeString();
                }
                if ($partial_days == 'second_half') {
                    $startdatetime = Carbon::parse($enddatetime)->subMinutes(90)->toDateTimeString();
                }
            }

            $month = Carbon::parse($startdate)->format('m');
            $currentmonth = Carbon::now()->format('m');
            $year = Carbon::parse($startdate)->format('Y');
            $currentyear = Carbon::now()->format('Y');
           $getid = DB::connection('mysql6')->table('leave_processed')->insertGetId([
                'employeeid' => $employeeid,
                'month' => $month,
                'year' => $year,
                'type' => $leave_type,
                'stdate' => $startdatetime,
                'etdate' => $enddatetime,
                'no_of_hours' => $no_of_hours,
                'no_of_days' => $no_of_days,
                'partial_days' => $partial_days,
                'emp_reason' => 'HR Updated Behalf of employee request',
                'created_date' => Carbon::now()->toDateTimeString(),
                'hod_status' => 'Approved',
                'hod_reason' => 'Approved By HR',
                'hod_created_date' => Carbon::now()->toDateTimeString(),
                'admin_status' => 'Approved',
                'admin_reason' => null,
                'admin_created_date' => Carbon::now()->toDateTimeString(),
                'final_status' => 'Approved',
                'saved_file_path' => null,
                'valid_till' => Carbon::now()->addDays(5)->toDateTimeString()
            ]);

            $newstarttime = explode(' ', $startdatetime);
            $newendtime = explode(' ', $enddatetime);
            
            DB::connection('mysql6')->table('datetime_ref')->insert([
                'employeeid' => $employeeid,
                'month' => Carbon::parse($startdate)->format('m'),
                'year' => Carbon::parse($startdate)->format('Y'),
                'applied_month' => $currentmonth,
                'applied_year' => $currentyear,
                'type' => $leave_type,
                'shift_code' => $getshiftdetails['Shift_Details']['Shift_Code'],
                'final_status' => 'Approved',
                'date' => $startdate,
                'start_end_time' => $newstarttime[1].'-'.$newendtime[1],
                'partial_days' => $partial_days,
                'reference_id' => $getid
            ]);

            if ($leave_type == 'Permission') {
                $no_of_days = 1;
            }

            $getbalance = DB::connection('mysql6')->table('leave_balance')->where(['employeeid' => $employeeid, 'month' => $currentmonth,'year' => $currentyear])->get();
            $bal = 0;
            foreach ($getbalance as $key6 => $value6) {
                $bal = $value6->$leave_type;
            }
            if (($leave_type == 'Onduty') || ($leave_type == 'Tour') || ($leave_type == 'Compoff') || ($leave_type == 'Mispunch') || ($leave_type == 'LOP')) {
                $minus_bal = $bal + $no_of_days;
            }
            else{
                $minus_bal = $bal - $no_of_days;    
            }
            
if ($leave_type == 'Permission') {
    if ($month != $currentmonth) {
        DB::connection('mysql6')->table('leave_balance')->where(['employeeid' => $employeeid, 'month' => $month,'year' => $year])
            ->update([
                $leave_type => $minus_bal
            ]);
    }
    else{
        DB::connection('mysql6')->table('leave_balance')->where(['employeeid' => $employeeid, 'month' => $currentmonth,'year' => $currentyear])
            ->update([
                $leave_type => $minus_bal
            ]);
    }
}
else{
    DB::connection('mysql6')->table('leave_balance')->where(['employeeid' => $employeeid, 'month' => $currentmonth,'year' => $currentyear])
            ->update([
                $leave_type => $minus_bal
            ]);
}
            


            $newar = [];
                $newar['employeeid'] = $employeeid;
                
                               

                if ($partial_days == 'full') {
                
                    $newar['from_date'] = substr($startdatetime,0,10);
                    $newar['to_date'] = substr($enddatetime,0,10);
                    $newar['starttime'] = '';
                    $newar['endtime'] = '';

                }
                elseif($partial_days == 'first_half'){
                    $newar['from_date'] = substr($startdatetime,0,10);
                    $newar['to_date'] = substr($enddatetime,0,10);
                    $newar['starttime'] = substr($startdatetime,11,5);
                    $newar['endtime'] = substr($enddatetime,11,5);

                }
                elseif($partial_days == 'second_half'){
                    $newar['from_date'] = substr($startdatetime,0,10);
                    $newar['to_date'] = substr($enddatetime,0,10);
                    $newar['starttime'] = substr($startdatetime,11,5);
                    $newar['endtime'] = substr($enddatetime,11,5);

                }else{
                    //sd
                }
                $newar['leave_type'] = $leave_type;
               
                
                
               
                DB::connection('mysql6')->table('send_sap_leave_details')->insert(['details' => json_encode($newar), 'created_datetime' => Carbon::now()->toDateTimeString()]);

                return 1;

    }




    public function employeedeleteleave(Request $request)
    {
        if ($request->session()->has('employeesession')) {
            $encrypt = $request->session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode('-', $decrypt);
            $employeeid = $split[0];
            $mydetails = [];
            $getemployeedata = DB::connection('mysql6')->table('employee')->where('id', '=', $employeeid)->get();

            $primaryid = $request->id;
            $leavetype = $request->leavetype;

            $getdata = DB::connection('mysql6')->table('leave_processed')->where(['id' => $primaryid, 'employeeid' => $employeeid, 'final_status' => 'Pending'])->get();
            if (count($getdata) > 0) {
                foreach ($getdata as $key => $value) {
                    $requesteddate = $value->stdate;
                    $partialdaysselected = trim($value->partial_days);
                    $leavetypeselected = $value->type;
                    $application_partial_days = trim($value->partial_days);
                }

                 
            
            $req_empid = trim($employeeid);
            $requesteddate = Carbon::parse($requesteddate)->toDateString();


            $requestedmonth = Carbon::parse($requesteddate)->format('m');
            $requestedyear = Carbon::parse($requesteddate)->format('Y');
            $currentmonth = Carbon::now()->format('m');
            $currentyear = Carbon::now()->format('Y');

                $check_payroll_runned = DB::connection('mysql6')->table('leave_balance')->where(['employeeid' => $employeeid, 'month' => $requestedmonth,'year' => $requestedyear, 'completed' => 'Y'])->get();

                if(count($check_payroll_runned) == 0){

                    if (($leavetypeselected == 'Onduty') || ($leavetypeselected == 'Tour') || ($leavetypeselected == 'Compoff') || ($leavetypeselected == 'Mispunch') || ($leavetypeselected == 'LOP')) {


                        if (($requestedmonth == '12') && ($currentmonth == '01' )) {
                            return 'Calendar Year Accrual Process scheduled. Please contact HR';
                        }
                        else{
                            
                                $checkleave_balance = DB::connection('mysql6')->table('leave_balance')->where(['employeeid' => $req_empid, 'month' => $requestedmonth,'year' => $requestedyear, 'completed' => 'N'])->get(); 
                                if (count($checkleave_balance) > 0) {

                                   
                                           foreach ($checkleave_balance as $key => $value) {
                                        $leavbalance = $value->$leavetypeselected;
                                    }           

                                                                                 


                                            if (($leavetypeselected == 'Onduty') || ($leavetypeselected == 'Compoff') || ($leavetypeselected == 'Mispunch')) {
                                                if ($partialdaysselected == 'full') { $count = 1; }else{ $count = 0.5; }
                                                
                                                if ($leavbalance == null) {
                                                    $todededuct = 0;
                                                }else{
                                                $todededuct = $leavbalance - $count;
                                                }
                                               
                                            }
                                            else{
                                                $getdata = DB::connection('mysql6')->table('datetime_ref')->where(['reference_id' => $primaryid])->whereIn('final_status',['Approved','Pending'])->get();
                                                if ($partialdaysselected == 'full') { $count = count($getdata); }else{ $count = 0.5; }
                                                if ($leavbalance == null) {
                                                    $todededuct = 0;
                                                }else{
                                                $todededuct = $leavbalance - $count;
                                                }

                                            }

                                            

                                            Log::info('Deleted application... '.$req_empid.' '.$leavetypeselected);
                                            $todelete = DB::connection('mysql6')->table('datetime_ref')->where(['employeeid' => $req_empid,'reference_id' => $primaryid])->get();

                                            DB::connection('mysql6')->table('datetime_ref')->where(['employeeid' => $req_empid,'reference_id' => $primaryid])->delete();
                                            DB::connection('mysql6')->table('leave_processed')->where(['employeeid' => $req_empid,'id' => $primaryid])->delete();

                                            foreach ($todelete as $vvkey => $rrvalue) {

                                                 DB::connection('mysql6')->table('delete_leave_applications_reference')->insert([
                                                'id' => null,
                                                'employeeid' => $rrvalue->employeeid,
                                                'month' => $rrvalue->month,
                                                'year' => $rrvalue->year,
                                                'applied_month' => $rrvalue->applied_month,
                                                'applied_year' => $rrvalue->applied_year,
                                                'type' => $rrvalue->type,
                                                'shift_code' => $rrvalue->shift_code,
                                                'final_status' => $rrvalue->final_status,
                                                'date' => $rrvalue->date,
                                                'start_end_time' => $rrvalue->start_end_time,
                                                'partial_days' => $rrvalue->partial_days,
                                                'deleted_datetime' => Carbon::now()->toDateTimeString(),
                                                
                                            ]);

                                            }

                                           
                                                
                                            if ($requestedmonth != $currentmonth) {
                                                $xcheckleave_balance = DB::connection('mysql6')->table('leave_balance')->where(['employeeid' => $req_empid, 'month' => $currentmonth,'year' => $currentyear, 'completed' => 'N'])->get(); 
                                                    if (count($xcheckleave_balance) > 0) {
                                                        foreach ($xcheckleave_balance as $kkey => $kvalue) {
                                                            $kleavbalance = $kvalue->$leavetypeselected;
                                                        }
                                                        $todededuct = $kleavbalance - $count;

                                                        DB::connection('mysql6')->table('leave_balance')->where(['employeeid' => $req_empid,'month' => $currentmonth,'year' => $currentyear, 'completed' => 'N'])->update([
                                                                        $leavetypeselected => $todededuct
                                                                    ]);
                                                    }
                                                
                                            }
                                            else{
                                                 DB::connection('mysql6')->table('leave_balance')->where(['employeeid' => $req_empid,'month' => $requestedmonth,'year' => $requestedyear, 'completed' => 'N'])->update([
                                                    $leavetypeselected => $todededuct
                                                ]);
                                            }

                                            
                                                return 'Application Deleted';

                                       
                                        
                                    
                                    
                                }
                                else{
                                    return 'No leave balance record created for the month - '.$requestedmonth;
                                }       
                            

                    }



                    }
                    elseif (($leavetypeselected == 'CL') || ($leavetypeselected == 'SL') || ($leavetypeselected == 'PL') || ($leavetypeselected == 'ML') || ($leavetypeselected == 'RH') || ($leavetypeselected == 'Permission')) {

                        //cl start
                             if($partialdaysselected == 'full'){
                        $tominus = 1;
                    }
                    else{
                        $tominus = 0.5;
                    }
                    

                    
                        if (($requestedmonth == '12') && ($currentmonth == '01' )) {
                            return 'Calendar Year Accrual Process scheduled. Please contact HR!';
                        }
                        else{
                            
                                $checkleave_balance = DB::connection('mysql6')->table('leave_balance')->where(['employeeid' => $req_empid, 'month' => $requestedmonth,'year' => $requestedyear, 'completed' => 'N'])->get(); 

                                if (count($checkleave_balance) > 0) {
                                   
                                        
                                         foreach ($checkleave_balance as $key => $value) {
                                        $leavbalance = $value->$leavetypeselected;
                                    }           
                                           

                                           
                                            if (($leavetypeselected == 'Permission')) {
                                                $count = 1;
                                                
                                                if ($leavbalance == null) {
                                                    $todededuct = 0 + $count;
                                                }else{
                                                $todededuct = $leavbalance + $count;
                                                }
                                               
                                            }
                                            else{
                                                $getdata = DB::connection('mysql6')->table('datetime_ref')->where(['reference_id' => $primaryid])->whereIn('final_status',['Pending'])->get();
                                                if ($application_partial_days == 'full') { $count = count($getdata); }else{ $count = 0.5; }
                                                if ($leavbalance == null) {
                                                    $todededuct = 0 + $count;
                                                }else{
                                                $todededuct = $leavbalance + $count;
                                                }

                                            }


                                            Log::info('Employee Deleted application... '.$req_empid.' '.$leavetypeselected);

                                           
                                           $todelete = DB::connection('mysql6')->table('datetime_ref')->where(['employeeid' => $req_empid,'reference_id' => $primaryid])->get();     
                                            DB::connection('mysql6')->table('datetime_ref')->where(['employeeid' => $req_empid,'reference_id' => $primaryid])->delete();
                                            DB::connection('mysql6')->table('leave_processed')->where(['employeeid' => $req_empid,'id' => $primaryid])->delete();

                                             foreach ($todelete as $vvkey => $rrvalue) {

                                                 DB::connection('mysql6')->table('delete_leave_applications_reference')->insert([
                                                'id' => null,
                                                'employeeid' => $rrvalue->employeeid,
                                                'month' => $rrvalue->month,
                                                'year' => $rrvalue->year,
                                                'applied_month' => $rrvalue->applied_month,
                                                'applied_year' => $rrvalue->applied_year,
                                                'type' => $rrvalue->type,
                                                'shift_code' => $rrvalue->shift_code,
                                                'final_status' => $rrvalue->final_status,
                                                'date' => $rrvalue->date,
                                                'start_end_time' => $rrvalue->start_end_time,
                                                'partial_days' => $rrvalue->partial_days,
                                                'deleted_datetime' => Carbon::now()->toDateTimeString(),
                                                
                                            ]);

                                            }
                                           

                                            if ($requestedmonth != $currentmonth) {
                                               
                                                $xcheckleave_balance = DB::connection('mysql6')->table('leave_balance')->where(['employeeid' => $req_empid, 'month' => $currentmonth,'year' => $currentyear, 'completed' => 'N'])->get(); 
                                if (count($xcheckleave_balance) > 0) {
                                    foreach ($xcheckleave_balance as $kkey => $kvalue) {
                                        $kleavbalance = $kvalue->$leavetypeselected;
                                    }
                                    $todededuct = $kleavbalance + $count;

                                    DB::connection('mysql6')->table('leave_balance')->where(['employeeid' => $req_empid,'month' => $currentmonth,'year' => $currentyear, 'completed' => 'N'])->update([
                                                    $leavetypeselected => $todededuct
                                                ]);
                                }

                                
                                                
                                            }
                                            else{
                                                 DB::connection('mysql6')->table('leave_balance')->where(['employeeid' => $req_empid,'month' => $requestedmonth,'year' => $requestedyear, 'completed' => 'N'])->update([
                                                    $leavetypeselected => $todededuct
                                                ]);
                                            }

                                            return 'Application Deleted';

                                                
                                        
                                    
                                    
                                }
                                else{
                                    return 'No leave balance record created for the month - '.$requestedmonth;
                                }       
                            
                            
                        }

                    
                        //cl end


                    }
                    else{
                        return 'Not a valid leave type';
                    }



                }
                else{
                    return 'Payroll process started. Please contact HR.';
                }
                
            }
            else{
                return 'Only Pending Application can be edited. Please check!';    
            }
            
        }
        else{
            return 0;
        }

            
    }



    public function employeedeleteleavereqfromhod_copyfn($leavetypeselected,$partialdaysselected,$employeeid,$requesteddate)
    {
       
            $req_empid = $employeeid;
            $req_type = 'admindelete';
            $requesteddate = Carbon::parse($requesteddate)->toDateString();


            $requestedmonth = Carbon::parse($requesteddate)->format('m');
            $requestedyear = Carbon::parse($requesteddate)->format('Y');
            $currentmonth = Carbon::now()->format('m');
            $currentyear = Carbon::now()->format('Y');

            $check_payroll_runned = DB::connection('mysql6')->table('leave_balance')->where(['employeeid' => $req_empid, 'month' => $requestedmonth,'year' => $requestedyear, 'completed' => 'Y'])->get();

            if(count($check_payroll_runned) == 0){
                
                if (($leavetypeselected == 'Onduty') || ($leavetypeselected == 'Tour') || ($leavetypeselected == 'Compoff') || ($leavetypeselected == 'Mispunch') || ($leavetypeselected == 'LOP')) {
                    if ($leavetypeselected == 'Tour') {
                        if ($partialdaysselected != 'full') {
                            return 'Tour can contain only Full day!';
                        }
                    }
                    if ($leavetypeselected == 'Mispunch') {
                        if ($partialdaysselected == 'full') {
                            return 'Mispunch can contain only first/second Half!';
                        }
                    }

                    if ($req_type == 'admindelete') {
                        if (($requestedmonth == '12') && ($currentmonth == '01' )) {
                            return 'Calendar Year Accrual Process scheduled. Please contact Developer';
                        }
                        else{
                            
                                $checkleave_balance = DB::connection('mysql6')->table('leave_balance')->where(['employeeid' => $req_empid, 'month' => $requestedmonth,'year' => $requestedyear, 'completed' => 'N'])->get(); 
                                if (count($checkleave_balance) > 0) {
                                    foreach ($checkleave_balance as $key => $value) {
                                        $leavbalance = $value->$leavetypeselected;
                                    }           

                                    

                                        $checkanyapplicationcreated = DB::connection('mysql6')->table('datetime_ref')->where(['employeeid' => $req_empid, 'date' => $requesteddate,'type' => $leavetypeselected,'partial_days' => $partialdaysselected])->whereIn('final_status',['Approved','Pending'])->get();
                                        if(count($checkanyapplicationcreated) > 0){
                                            foreach($checkanyapplicationcreated as $k => $v){
                                                $primaryid = $v->reference_id;
                                                $final_status = $v->final_status;
                                                $application_type = $v->type;
                                                $application_partial_days = $v->partial_days;
                                            }


                                            if (($application_type == 'Onduty') || ($application_type == 'Compoff') || ($application_type == 'Mispunch')) {
                                                if ($application_partial_days == 'full') { $count = 1; }else{ $count = 0.5; }
                                                
                                                if ($leavbalance == null) {
                                                    $todededuct = 0;
                                                }else{
                                                $todededuct = $leavbalance - $count;
                                                }
                                               
                                            }
                                            else{
                                                $getdata = DB::connection('mysql6')->table('datetime_ref')->where(['reference_id' => $primaryid])->whereIn('final_status',['Approved','Pending'])->get();
                                                if ($application_partial_days == 'full') { $count = count($getdata); }else{ $count = 0.5; }
                                                if ($leavbalance == null) {
                                                    $todededuct = 0;
                                                }else{
                                                $todededuct = $leavbalance - $count;
                                                }

                                            }

                                            
                                            $getlms_application = DB::connection('mysql6')->table('leave_processed')->where(['employeeid' => $req_empid, 'id' => $primaryid,'type' => $leavetypeselected,'partial_days' => $partialdaysselected])->whereIn('final_status',['Approved','Pending'])->get();
                                            $newar = [];
                                            $newar['employeeid'] = $req_empid;
                            
                                            foreach ($getlms_application as $key26 => $value26) {
                                                $sap_fromdate = $value26->stdate;
                                                $sap_todate = $value26->etdate;
                                                $sap_no_of_days = $value26->no_of_days;
                                                $sap_partial_days = $value26->partial_days;
                                                $sap_leave_type = $value26->type;
                                            }
                                            
                            
                                            if ($sap_partial_days == 'full') {
                                            
                                                $newar['from_date'] = substr($sap_fromdate,0,10);
                                                $newar['to_date'] = substr($sap_todate,0,10);
                                                $newar['starttime'] = '';
                                                $newar['endtime'] = '';
                            
                                            }
                                            elseif($sap_partial_days == 'first_half'){
                                                $newar['from_date'] = substr($sap_fromdate,0,10);
                                                $newar['to_date'] = substr($sap_todate,0,10);
                                                $newar['starttime'] = substr($sap_fromdate,11,5);
                                                $newar['endtime'] = substr($sap_todate,11,5);
                            
                                            }
                                            elseif($sap_partial_days == 'second_half'){
                                                $newar['from_date'] = substr($sap_fromdate,0,10);
                                                $newar['to_date'] = substr($sap_todate,0,10);
                                                $newar['starttime'] = substr($sap_fromdate,11,5);
                                                $newar['endtime'] = substr($sap_todate,11,5);
                            
                                            }else{
                                                //sd
                                            }
                                            $newar['leave_type'] = $leavetypeselected;
                                            //return $newar;

                                            $deleteappl = $this->delete_leave_applied($newar);

                                            Log::info('Deleted application... '.$req_empid.' '.$leavetypeselected.' '.$sap_fromdate.' - '.$sap_todate.' - SAP Satus '.$deleteappl['Status']);

                                            if($deleteappl['Status'] == "Updated Successfully"){
                                            $todelete = DB::connection('mysql6')->table('datetime_ref')->where(['employeeid' => $req_empid,'reference_id' => $primaryid])->get();

                                            DB::connection('mysql6')->table('datetime_ref')->where(['employeeid' => $req_empid,'reference_id' => $primaryid])->delete();
                                            DB::connection('mysql6')->table('leave_processed')->where(['employeeid' => $req_empid,'id' => $primaryid])->delete();

                                            foreach ($todelete as $vvkey => $rrvalue) {

                                                 DB::connection('mysql6')->table('delete_leave_applications_reference')->insert([
                                                'id' => null,
                                                'employeeid' => $rrvalue->employeeid,
                                                'month' => $rrvalue->month,
                                                'year' => $rrvalue->year,
                                                'applied_month' => $rrvalue->applied_month,
                                                'applied_year' => $rrvalue->applied_year,
                                                'type' => $rrvalue->type,
                                                'shift_code' => $rrvalue->shift_code,
                                                'final_status' => $rrvalue->final_status,
                                                'date' => $rrvalue->date,
                                                'start_end_time' => $rrvalue->start_end_time,
                                                'partial_days' => $rrvalue->partial_days,
                                                'deleted_datetime' => Carbon::now()->toDateTimeString(),
                                                
                                            ]);

                                            }

                                           
                                                
                                            if ($requestedmonth != $currentmonth) {
                                                $xcheckleave_balance = DB::connection('mysql6')->table('leave_balance')->where(['employeeid' => $req_empid, 'month' => $currentmonth,'year' => $currentyear, 'completed' => 'N'])->get(); 
                                if (count($xcheckleave_balance) > 0) {
                                    foreach ($xcheckleave_balance as $kkey => $kvalue) {
                                        $kleavbalance = $kvalue->$leavetypeselected;
                                    }
                                    $todededuct = $kleavbalance - $count;

                                    DB::connection('mysql6')->table('leave_balance')->where(['employeeid' => $req_empid,'month' => $currentmonth,'year' => $currentyear, 'completed' => 'N'])->update([
                                                    $leavetypeselected => $todededuct
                                                ]);
                                }
                                                
                                            }
                                            else{
                                                 DB::connection('mysql6')->table('leave_balance')->where(['employeeid' => $req_empid,'month' => $requestedmonth,'year' => $requestedyear, 'completed' => 'N'])->update([
                                                    $leavetypeselected => $todededuct
                                                ]);
                                            }

                                            


                                                //to send data to sap remember
                                                return 'Application Deleted';
                                            }
                                            else{
                                                return 'Error Occured in SAP. Please check if any user accessing this employeeid in SAP';
                                            }

                                        }
                                        else{
                                            
                                            return 'There is no application found for the given data!';

                                        }
                                        
                                    
                                    
                                }
                                else{
                                    return 'No leave balance row created for the month - '.$requestedmonth;
                                }       
                            
                            
                        }

                    }

                   


                }
                elseif (($leavetypeselected == 'CL') || ($leavetypeselected == 'SL') || ($leavetypeselected == 'PL') || ($leavetypeselected == 'ML') || ($leavetypeselected == 'RH') || ($leavetypeselected == 'Permission')) {
                    if ($leavetypeselected == 'Permission') {
                        if ($partialdaysselected == 'full') {
                            return 'Permission can contain only first/second Half!';
                        }
                    }


                    if($partialdaysselected == 'full'){
                        $tominus = 1;
                    }
                    else{
                        $tominus = 0.5;
                    }
                    //check leave balance avaiable.

                    if ($req_type == 'admindelete') {
                        if (($requestedmonth == '12') && ($currentmonth == '01' )) {
                            return 'Calendar Year Accrual Process scheduled. Please contact Developer';
                        }
                        else{
                            
                                $checkleave_balance = DB::connection('mysql6')->table('leave_balance')->where(['employeeid' => $req_empid, 'month' => $requestedmonth,'year' => $requestedyear, 'completed' => 'N'])->get(); 
                                if (count($checkleave_balance) > 0) {
                                    foreach ($checkleave_balance as $key => $value) {
                                        $leavbalance = $value->$leavetypeselected;
                                    }           

                                    

                                        $checkanyapplicationcreated = DB::connection('mysql6')->table('datetime_ref')->where(['employeeid' => $req_empid, 'date' => $requesteddate,'type' => $leavetypeselected,'partial_days' => $partialdaysselected])->whereIn('final_status',['Approved','Pending'])->get();
                                        if(count($checkanyapplicationcreated) > 0){
                                            foreach($checkanyapplicationcreated as $k => $v){
                                                $primaryid = $v->reference_id;
                                                $final_status = $v->final_status;
                                                $application_type = $v->type;
                                                $application_partial_days = $v->partial_days;
                                            }

                                           
                                            if (($application_type == 'Permission')) {
                                                $count = 1;
                                                
                                                if ($leavbalance == null) {
                                                    $todededuct = 0 + $count;
                                                }else{
                                                $todededuct = $leavbalance + $count;
                                                }
                                               
                                            }
                                            else{
                                                $getdata = DB::connection('mysql6')->table('datetime_ref')->where(['reference_id' => $primaryid])->whereIn('final_status',['Approved','Pending'])->get();
                                                if ($application_partial_days == 'full') { $count = count($getdata); }else{ $count = 0.5; }
                                                if ($leavbalance == null) {
                                                    $todededuct = 0 + $count;
                                                }else{
                                                $todededuct = $leavbalance + $count;
                                                }

                                            }


                                            $getlms_application = DB::connection('mysql6')->table('leave_processed')->where(['employeeid' => $req_empid, 'id' => $primaryid,'type' => $leavetypeselected,'partial_days' => $partialdaysselected])->whereIn('final_status',['Approved','Pending'])->get();
                                            $newar = [];
                                            $newar['employeeid'] = $req_empid;
                            
                                            foreach ($getlms_application as $key26 => $value26) {
                                                $sap_fromdate = $value26->stdate;
                                                $sap_todate = $value26->etdate;
                                                $sap_no_of_days = $value26->no_of_days;
                                                $sap_partial_days = $value26->partial_days;
                                                $sap_leave_type = $value26->type;
                                            }
                                            
                            
                                            if ($sap_partial_days == 'full') {
                                            
                                                $newar['from_date'] = substr($sap_fromdate,0,10);
                                                $newar['to_date'] = substr($sap_todate,0,10);
                                                $newar['starttime'] = '';
                                                $newar['endtime'] = '';
                            
                                            }
                                            elseif($sap_partial_days == 'first_half'){
                                                $newar['from_date'] = substr($sap_fromdate,0,10);
                                                $newar['to_date'] = substr($sap_todate,0,10);
                                                $newar['starttime'] = substr($sap_fromdate,11,5);
                                                $newar['endtime'] = substr($sap_todate,11,5);
                            
                                            }
                                            elseif($sap_partial_days == 'second_half'){
                                                $newar['from_date'] = substr($sap_fromdate,0,10);
                                                $newar['to_date'] = substr($sap_todate,0,10);
                                                $newar['starttime'] = substr($sap_fromdate,11,5);
                                                $newar['endtime'] = substr($sap_todate,11,5);
                            
                                            }else{
                                                //sd
                                            }
                                            $newar['leave_type'] = $leavetypeselected;
                                            //return $newar;

                                            $deleteappl = $this->delete_leave_applied($newar);

                                            Log::info('Deleted application... '.$req_empid.' '.$leavetypeselected.' '.$sap_fromdate.' - '.$sap_todate.' - SAP Satus '.$deleteappl['Status']);

                                            if($deleteappl['Status'] == "Updated Successfully"){

                                            $todelete = DB::connection('mysql6')->table('datetime_ref')->where(['employeeid' => $req_empid,'reference_id' => $primaryid])->get();
                                                
                                            DB::connection('mysql6')->table('datetime_ref')->where(['employeeid' => $req_empid,'reference_id' => $primaryid])->delete();
                                            DB::connection('mysql6')->table('leave_processed')->where(['employeeid' => $req_empid,'id' => $primaryid])->delete();

                                            foreach ($todelete as $vvkey => $rrvalue) {

                                                 DB::connection('mysql6')->table('delete_leave_applications_reference')->insert([
                                                'id' => null,
                                                'employeeid' => $rrvalue->employeeid,
                                                'month' => $rrvalue->month,
                                                'year' => $rrvalue->year,
                                                'applied_month' => $rrvalue->applied_month,
                                                'applied_year' => $rrvalue->applied_year,
                                                'type' => $rrvalue->type,
                                                'shift_code' => $rrvalue->shift_code,
                                                'final_status' => $rrvalue->final_status,
                                                'date' => $rrvalue->date,
                                                'start_end_time' => $rrvalue->start_end_time,
                                                'partial_days' => $rrvalue->partial_days,
                                                'deleted_datetime' => Carbon::now()->toDateTimeString(),
                                                
                                            ]);

                                            }

                                           

                                            if ($requestedmonth != $currentmonth) {
                                                $xcheckleave_balance = DB::connection('mysql6')->table('leave_balance')->where(['employeeid' => $req_empid, 'month' => $currentmonth,'year' => $currentyear, 'completed' => 'N'])->get(); 
                                if (count($xcheckleave_balance) > 0) {
                                    foreach ($xcheckleave_balance as $kkey => $kvalue) {
                                        $kleavbalance = $kvalue->$leavetypeselected;
                                    }
                                    $todededuct = $kleavbalance + $count;

                                    DB::connection('mysql6')->table('leave_balance')->where(['employeeid' => $req_empid,'month' => $currentmonth,'year' => $currentyear, 'completed' => 'N'])->update([
                                                    $leavetypeselected => $todededuct
                                                ]);
                                }

                                
                                                
                                            }
                                            else{
                                                 DB::connection('mysql6')->table('leave_balance')->where(['employeeid' => $req_empid,'month' => $requestedmonth,'year' => $requestedyear, 'completed' => 'N'])->update([
                                                    $leavetypeselected => $todededuct
                                                ]);
                                            }

                                            return 'Application Deleted';
                                        }
                                        else{
                                            return 'Error Occured in SAP. Please check if any user accessing this employeeid in SAP';
                                        }

                                                //to send data to sap remember
                                                


                                        }
                                        else{
                                            
                                            return 'There is no application found for the given data!';

                                        }
                                        
                                    
                                    
                                }
                                else{
                                    return 'No leave balance row created for the month - '.$requestedmonth;
                                }       
                            
                            
                        }

                    }

                   

                    


                }
                else{
                     return 'Not a valid leave type!';  
                }


            }
            else{
                return 'Cannot Edit';   
            }


        
    
        
        

            
    }




    public function employeedeleteleaverequest_tohod(Request $request)
    {
        if ($request->session()->has('employeesession')) {
            $encrypt = $request->session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode('-', $decrypt);
            $employeeid = $split[0];
            $mydetails = [];
            $getemployeedata = DB::connection('mysql6')->table('employee')->where('id', '=', $employeeid)->get();

            $primaryid = $request->id;
            $leavetype = $request->leavetype;

            $getdata = DB::connection('mysql6')->table('leave_processed')->where(['id' => $primaryid, 'employeeid' => $employeeid])->whereIn('final_status', ['Approved', 'Pending'])->get();
            if (count($getdata) > 0) {
                foreach ($getdata as $key => $value) {
                    $requesteddate = $value->stdate;
                    $stdate = $value->stdate;
                    $eddate = $value->etdate;
                    $partialdaysselected = trim($value->partial_days);
                    $leavetypeselected = $value->type;
                    $application_partial_days = trim($value->partial_days);
                }

                 
            
            $req_empid = trim($employeeid);
            $requesteddate = Carbon::parse($requesteddate)->toDateString();

            $emp_array = $this->getactivedetails($req_empid);
            $hod_array = $this->getactivedetails($emp_array['report_incharge_id']);

            $mailarray = [];
            $mailarray['empid'] = $req_empid;
            $mailarray['empmailid'] = $emp_array['emp_mailid'];
            $mailarray['empname'] = $emp_array['emp_name'];
            $mailarray['empmobileno'] = $emp_array['personal_mobile_no'];

            $mailarray['hodmailid'] = $hod_array['emp_mailid'];
            $mailarray['hodname'] = $hod_array['emp_name'];
            $mailarray['hodmobileno'] = $hod_array['personal_mobile_no'];

            $mailarray['leave_type'] = $leavetypeselected;
            $mailarray['app_stdate'] = $stdate;
            $mailarray['app_etdate'] = $eddate;

            


            $requestedmonth = Carbon::parse($requesteddate)->format('m');
            $requestedyear = Carbon::parse($requesteddate)->format('Y');
            $currentmonth = Carbon::now()->format('m');
            $currentyear = Carbon::now()->format('Y');

                $check_payroll_runned = DB::connection('mysql6')->table('leave_balance')->where(['employeeid' => $employeeid, 'month' => $requestedmonth,'year' => $requestedyear, 'completed' => 'Y'])->get();

                if(count($check_payroll_runned) == 0){

                    if (($leavetypeselected == 'Onduty') || ($leavetypeselected == 'Tour') || ($leavetypeselected == 'Compoff') || ($leavetypeselected == 'Mispunch') || ($leavetypeselected == 'LOP')) {


                        if (($requestedmonth == '12') && ($currentmonth == '01' )) {
                            return 'Calendar Year Accrual Process scheduled. Please contact HR';
                        }
                        else{
                            
                                $checkleave_balance = DB::connection('mysql6')->table('leave_balance')->where(['employeeid' => $req_empid, 'month' => $requestedmonth,'year' => $requestedyear, 'completed' => 'N'])->get(); 
                                if (count($checkleave_balance) > 0) {

                                   
                                    $before_hash_key = '#deleterequesthod#_'.$req_empid.'_'.$primaryid.'_'.$leavetypeselected.'_'.$application_partial_days;
                                    $hodencrypt_afterhash = Crypt::encrypt($before_hash_key);
                                    $mail_triggered_count = 0;

                                    $check_prev_appl = DB::connection('mysql6')->table('appl_delete_request')->where(['requested_empid' => $req_empid, 'req_month' => $requestedmonth,'req_year' => $requestedyear,'primary_id'=>$primaryid])->get(); 
                                    if (count($check_prev_appl) > 0) {
                                        foreach ($check_prev_appl as $keyz => $valuez) {
                                            $mail_triggered_count = $valuez->mail_triggered_count;
                                            $dbhashkey = $valuez->hash_key;
                                        }
                                        
                                        if ($mail_triggered_count < 5) {
                                            $mail_triggered_count += 1;

                                        $updatedeleteionrequest = DB::connection('mysql6')->table('appl_delete_request')->where(['requested_empid' => $req_empid, 'req_month' => $requestedmonth,'req_year' => $requestedyear,'primary_id'=>$primaryid])->update([
                                            'delete_req_raised_date' => Carbon::now()->toDateTimeString(),
                                            'hash_key' => $dbhashkey,
                                            'mail_triggered_count' => $mail_triggered_count
                                            ]);

                                            $mailarray['hash_key'] = $dbhashkey;

                                            $mailarray['ishod'] = 0;
                                            if (!empty($mailarray['hodmailid'])) {
                                                $mailarray['ishod'] = 1;
                                                $ss = strtolower($mailarray['hodmailid']);
                                                if (!filter_var($ss, FILTER_VALIDATE_EMAIL)) { Log::info('Not a valid address = '.$ss); }else{
                                                Log::info('Seding Delete Appl Email for approval copy to hod = '.$ss);
                                                    $md_sec = "mdsecretary@vgn.in";
                                                    if ($ss == 'md@vgn.in') { Mail::to($md_sec)->send(new deleterequestmailtohod($mailarray)); }
                                                    Mail::to($ss)->send(new deleterequestmailtohod($mailarray));
                                                    }
                                                }  
                                            if (!empty($mailarray['empmailid'])) {
                                                $mailarray['ishod'] = 0;
                                                $jj = strtolower($mailarray['empmailid']);
                                                if (!filter_var($jj, FILTER_VALIDATE_EMAIL)) { Log::info('Not a valid address = '.$jj); }else{
                                                Log::info('Seding Delete Email for applied copy to employee = '.$jj);
                                                Mail::to($jj)->send(new deleterequestmailtohod($mailarray));
                                                }
                                            }
                        
                        
                                                if(ctype_digit($mailarray['empmobileno'])){
                                                    if (strlen($mailarray['empmobileno']) == 10) {                                
                                                $emp_smscontent = 'Dear '.$mailarray['empname'].', Your '.$mailarray['leave_type'].' Application on '.Carbon::parse($mailarray['app_stdate'])->format('d, M Y h:i:s A').' to '.Carbon::parse($mailarray['app_etdate'])->format('d, M Y h:i:s A').' submitted for deletion Approval to HOD.'; 
                                                $employee_status = $this->smscurl($emp_smscontent, $mailarray['empmobileno']); 
                                                
                                                Log::info('Seding SMS for applied copy to employee = '.$mailarray['empmobileno']);
                                                    }
                                                }
                        
                                                if(ctype_digit($mailarray['hodmobileno'])){
                                                    if (strlen($mailarray['hodmobileno']) == 10) {
                                                $hod_smscontent = 'Dear '.$mailarray['hodname'].', '.$mailarray['leave_type'].' Application on '.Carbon::parse($mailarray['app_stdate'])->format('d, M Y h:i:s A').' to '.Carbon::parse($mailarray['app_etdate'])->format('d, M Y h:i:s A').' submitted for deletion Approval by '.$mailarray['empname'].'('.$req_empid.'). Kindly check your official mail.'; 
                                                Log::info('Seding SMS for approval copy to hod = '.$mailarray['hodmobileno']);
                                                $hod_status = $this->smscurl($hod_smscontent, $mailarray['hodmobileno']);               
                                                    }
                                                }

                                                                                       

                                            return "Mail Sent. You have requested $mail_triggered_count times to HOD for Deletion of application. Please check with HOD. (Max. attempt - 5)";
                                        }
                                        else{
                                            return "You have reached max no. of delete request attempts. Please check with HOD. (Max. attempt - 5)";
                                        }
                                    }
                                    else{
                                        
                                        $insertdeleteionrequest = DB::connection('mysql6')->table('appl_delete_request')->insert([
                                            'requested_empid' => $req_empid,
                                            'primary_id' => $primaryid,
                                            'req_month' => $requestedmonth,
                                            'req_year' => $requestedyear,
                                            'delete_req_raised_date' => Carbon::now()->toDateTimeString(),
                                            'hash_key' => $hodencrypt_afterhash,
                                            'mail_triggered_count' => 1
                                            ]); 


                                            $mailarray['hash_key'] = $hodencrypt_afterhash;

                                            $mailarray['ishod'] = 0;
                                            if (!empty($mailarray['hodmailid'])) {
                                                $mailarray['ishod'] = 1;
                                                $ss = strtolower($mailarray['hodmailid']);
                                                if (!filter_var($ss, FILTER_VALIDATE_EMAIL)) { Log::info('Not a valid address = '.$ss); }else{
                                                Log::info('Seding Delete Appl Email for approval copy to hod = '.$ss);
                                                    $md_sec = "mdsecretary@vgn.in";
                                                    if ($ss == 'md@vgn.in') { Mail::to($md_sec)->send(new deleterequestmailtohod($mailarray)); }
                                                    Mail::to($ss)->send(new deleterequestmailtohod($mailarray));
                                                    }
                                                }  
                                            if (!empty($mailarray['empmailid'])) {
                                                $mailarray['ishod'] = 0;
                                                $jj = strtolower($mailarray['empmailid']);
                                                if (!filter_var($jj, FILTER_VALIDATE_EMAIL)) { Log::info('Not a valid address = '.$jj); }else{
                                                Log::info('Seding Delete Email for applied copy to employee = '.$jj);
                                                Mail::to($jj)->send(new deleterequestmailtohod($mailarray));
                                                }
                                            }
                        
                        
                                                if(ctype_digit($mailarray['empmobileno'])){
                                                    if (strlen($mailarray['empmobileno']) == 10) {                                
                                                $emp_smscontent = 'Dear '.$mailarray['empname'].', Your '.$mailarray['leave_type'].' Application on '.Carbon::parse($mailarray['app_stdate'])->format('d, M Y h:i:s A').' to '.Carbon::parse($mailarray['app_etdate'])->format('d, M Y h:i:s A').' submitted for deletion Approval to HOD.'; 
                                                $employee_status = $this->smscurl($emp_smscontent, $mailarray['empmobileno']); 
                                                
                                                Log::info('Seding SMS for applied copy to employee = '.$mailarray['empmobileno']);
                                                    }
                                                }
                        
                                                if(ctype_digit($mailarray['hodmobileno'])){
                                                    if (strlen($mailarray['hodmobileno']) == 10) {
                                                $hod_smscontent = 'Dear '.$mailarray['hodname'].', '.$mailarray['leave_type'].' Application on '.Carbon::parse($mailarray['app_stdate'])->format('d, M Y h:i:s A').' to '.Carbon::parse($mailarray['app_etdate'])->format('d, M Y h:i:s A').' submitted for deletion Approval by '.$mailarray['empname'].'('.$req_empid.'). Kindly check your official mail.'; 
                                                Log::info('Seding SMS for approval copy to hod = '.$mailarray['hodmobileno']);
                                                $hod_status = $this->smscurl($hod_smscontent, $mailarray['hodmobileno']);               
                                                    }
                                                }

                                            return 'Mail Sent. Requested to HOD for Deletion of application. Please check with HOD.';
                                    }
                                    
                                }
                                else{
                                    return 'No leave balance record created for the month - '.$requestedmonth;
                                }       
                            

                    }



                    }
                    elseif (($leavetypeselected == 'CL') || ($leavetypeselected == 'SL') || ($leavetypeselected == 'PL') || ($leavetypeselected == 'ML') || ($leavetypeselected == 'RH') || ($leavetypeselected == 'Permission')) {

                        //cl start
                             if($partialdaysselected == 'full'){
                        $tominus = 1;
                    }
                    else{
                        $tominus = 0.5;
                    }
                    

                    
                        if (($requestedmonth == '12') && ($currentmonth == '01' )) {
                            return 'Calendar Year Accrual Process scheduled. Please contact HR!';
                        }
                        else{
                            
                                $checkleave_balance = DB::connection('mysql6')->table('leave_balance')->where(['employeeid' => $req_empid, 'month' => $requestedmonth,'year' => $requestedyear, 'completed' => 'N'])->get(); 

                                if (count($checkleave_balance) > 0) {
                                   
                                        
                                        
                                           

                                          

                                    $before_hash_key = '#deleterequesthod#_'.$req_empid.'_'.$primaryid.'_'.$leavetypeselected.'_'.$application_partial_days;
                                    $hodencrypt_afterhash = Crypt::encrypt($before_hash_key);
                                    $mail_triggered_count = 0;
                                    $check_prev_appl = DB::connection('mysql6')->table('appl_delete_request')->where(['requested_empid' => $req_empid, 'req_month' => $requestedmonth,'req_year' => $requestedyear,'primary_id'=>$primaryid])->get(); 
                                    if (count($check_prev_appl) > 0) {
                                        foreach ($check_prev_appl as $keyz => $valuez) {
                                            $mail_triggered_count = $valuez->mail_triggered_count;
                                            $dbhashkey = $valuez->hash_key;
                                        }

                                        if ($mail_triggered_count < 5) {
                                            $mail_triggered_count += 1;

                                        $updatedeleteionrequest = DB::connection('mysql6')->table('appl_delete_request')->where(['requested_empid' => $req_empid, 'req_month' => $requestedmonth,'req_year' => $requestedyear,'primary_id'=>$primaryid])->update([
                                            'delete_req_raised_date' => Carbon::now()->toDateTimeString(),
                                            'hash_key' => $dbhashkey,
                                            'mail_triggered_count' => $mail_triggered_count
                                            ]);


                                            $mailarray['hash_key'] = $dbhashkey;

                                            $mailarray['ishod'] = 0;
                                            if (!empty($mailarray['hodmailid'])) {
                                                $mailarray['ishod'] = 1;
                                                $ss = strtolower($mailarray['hodmailid']);
                                                if (!filter_var($ss, FILTER_VALIDATE_EMAIL)) { Log::info('Not a valid address = '.$ss); }else{
                                                Log::info('Sending Delete Appl Email for approval copy to hod = '.$ss);
                                                    $md_sec = "mdsecretary@vgn.in";
                                                    if ($ss == 'md@vgn.in') { Mail::to($md_sec)->send(new deleterequestmailtohod($mailarray)); }
                                                    Mail::to($ss)->send(new deleterequestmailtohod($mailarray));
                                                    }
                                                }  
                                            if (!empty($mailarray['empmailid'])) {
                                                $mailarray['ishod'] = 0;
                                                $jj = strtolower($mailarray['empmailid']);
                                                if (!filter_var($jj, FILTER_VALIDATE_EMAIL)) { Log::info('Not a valid address = '.$jj); }else{
                                                Log::info('Sending Delete Email for applied copy to employee = '.$jj);
                                                Mail::to($jj)->send(new deleterequestmailtohod($mailarray));
                                                }
                                            }
                        
                        
                                                if(ctype_digit($mailarray['empmobileno'])){
                                                    if (strlen($mailarray['empmobileno']) == 10) {                                
                                                $emp_smscontent = 'Dear '.$mailarray['empname'].', Your '.$mailarray['leave_type'].' Application on '.Carbon::parse($mailarray['app_stdate'])->format('d, M Y h:i:s A').' to '.Carbon::parse($mailarray['app_etdate'])->format('d, M Y h:i:s A').' submitted for deletion Approval to HOD.'; 
                                                $employee_status = $this->smscurl($emp_smscontent, $mailarray['empmobileno']); 
                                                
                                                Log::info('Sending SMS for applied copy to employee = '.$mailarray['empmobileno']);
                                                    }
                                                }
                        
                                                if(ctype_digit($mailarray['hodmobileno'])){
                                                    if (strlen($mailarray['hodmobileno']) == 10) {
                                                $hod_smscontent = 'Dear '.$mailarray['hodname'].', '.$mailarray['leave_type'].' Application on '.Carbon::parse($mailarray['app_stdate'])->format('d, M Y h:i:s A').' to '.Carbon::parse($mailarray['app_etdate'])->format('d, M Y h:i:s A').' submitted for deletion Approval by '.$mailarray['empname'].'('.$req_empid.'). Kindly check your official mail.'; 
                                                Log::info('Sending SMS for approval copy to hod = '.$mailarray['hodmobileno']);
                                                $hod_status = $this->smscurl($hod_smscontent, $mailarray['hodmobileno']);               
                                                    }
                                                }

                                            return "Mail Sent. You have requested $mail_triggered_count times to HOD for Deletion of application. Please check with HOD. (Max. attempt - 5)";
                                        }
                                        else{
                                            return "You have reached max no. of delete request attempts. Please check with HOD. (Max. attempt - 5)";
                                        }
                                        
                                    }
                                    else{
                                        
                                        $insertdeleteionrequest = DB::connection('mysql6')->table('appl_delete_request')->insert([
                                            'requested_empid' => $req_empid,
                                            'primary_id' => $primaryid,
                                            'req_month' => $requestedmonth,
                                            'req_year' => $requestedyear,
                                            'delete_req_raised_date' => Carbon::now()->toDateTimeString(),
                                            'hash_key' => $hodencrypt_afterhash,
                                            'mail_triggered_count' => 1
                                            ]); 

                                            $mailarray['hash_key'] = $hodencrypt_afterhash;

                                            $mailarray['ishod'] = 0;
                                            if (!empty($mailarray['hodmailid'])) {
                                                $mailarray['ishod'] = 1;
                                                $ss = strtolower($mailarray['hodmailid']);
                                                if (!filter_var($ss, FILTER_VALIDATE_EMAIL)) { Log::info('Not a valid address = '.$ss); }else{
                                                Log::info('Sending Delete Appl Email for approval copy to hod = '.$ss);
                                                    $md_sec = "mdsecretary@vgn.in";
                                                    if ($ss == 'md@vgn.in') { Mail::to($md_sec)->send(new deleterequestmailtohod($mailarray)); }
                                                    Mail::to($ss)->send(new deleterequestmailtohod($mailarray));
                                                    }
                                                }  
                                            if (!empty($mailarray['empmailid'])) {
                                                $mailarray['ishod'] = 0;
                                                $jj = strtolower($mailarray['empmailid']);
                                                if (!filter_var($jj, FILTER_VALIDATE_EMAIL)) { Log::info('Not a valid address = '.$jj); }else{
                                                Log::info('Sending Delete Email for applied copy to employee = '.$jj);
                                                Mail::to($jj)->send(new deleterequestmailtohod($mailarray));
                                                }
                                            }
                        
                        
                                                if(ctype_digit($mailarray['empmobileno'])){
                                                    if (strlen($mailarray['empmobileno']) == 10) {                                
                                                $emp_smscontent = 'Dear '.$mailarray['empname'].', Your '.$mailarray['leave_type'].' Application on '.Carbon::parse($mailarray['app_stdate'])->format('d, M Y h:i:s A').' to '.Carbon::parse($mailarray['app_etdate'])->format('d, M Y h:i:s A').' submitted for deletion Approval to HOD.'; 
                                                $employee_status = $this->smscurl($emp_smscontent, $mailarray['empmobileno']); 
                                                
                                                Log::info('Sending SMS for applied copy to employee = '.$mailarray['empmobileno']);
                                                    }
                                                }
                        
                                                if(ctype_digit($mailarray['hodmobileno'])){
                                                    if (strlen($mailarray['hodmobileno']) == 10) {
                                                $hod_smscontent = 'Dear '.$mailarray['hodname'].', '.$mailarray['leave_type'].' Application on '.Carbon::parse($mailarray['app_stdate'])->format('d, M Y h:i:s A').' to '.Carbon::parse($mailarray['app_etdate'])->format('d, M Y h:i:s A').' submitted for deletion Approval by '.$mailarray['empname'].'('.$req_empid.'). Kindly check your official mail.'; 
                                                Log::info('Sending SMS for approval copy to hod = '.$mailarray['hodmobileno']);
                                                $hod_status = $this->smscurl($hod_smscontent, $mailarray['hodmobileno']);               
                                                    }
                                                }

                                            return 'Mail Sent. Requested to HOD for Deletion of application. Please check with HOD.';
                                    }

                                    

                                    
                                    

                                                
                                        
                                    
                                    
                                }
                                else{
                                    return 'No leave balance record created for the month - '.$requestedmonth;
                                }       
                            
                            
                        }

                    
                        //cl end


                    }
                    else{
                        return 'Not a valid leave type';
                    }



                }
                else{
                    return 'Payroll process started. Please contact HR.';
                }
                
            }
            else{
                return 'Only Pending/Approved Application can be deleted. Please check!';    
            }
            
        }
        else{
            return 0;
        }

            
    }


    public function hoddeleteleaveurl($hashkey)
    {
        
        $checkkey = DB::connection('mysql6')->table('appl_delete_request')->where(['hash_key' => $hashkey])->get();

        if (count($checkkey) > 0) {
            

            $decrypt = Crypt::decrypt($hashkey);
            $split = explode("_",$decrypt);
            //dd($split);
            $requestedempid = $split[1];
            $primary_id = $split[2];
            $leavetype = $split[3];

            $checkapplication_exist = DB::connection('mysql6')->table('leave_processed')->where(['id' => $primary_id, 'employeeid'=> $requestedempid, 'final_status' => 'Approved'])->get();
            if (count($checkapplication_exist) > 0) {

                $emp_array = $this->getactivedetails($requestedempid);
        
                    $mailarray = [];
                    $mailarray['empid'] = $requestedempid;
                    $mailarray['empmailid'] = $emp_array['emp_mailid'];
                    $mailarray['empname'] = $emp_array['emp_name'];
                    $mailarray['leave_type'] = $leavetype;
                    $mailarray['empmobileno'] = $emp_array['personal_mobile_no'];
                    foreach ($checkapplication_exist as $key1 => $value1) {
                        $mailarray['app_stdate'] = $value1->stdate;
                        $mailarray['app_etdate'] = $value1->etdate;
                        $requesteddate = Carbon::parse($value1->stdate)->toDateString();
                        $partialdaysselected = $value1->partial_days;

                    }
                
                //$res_status = $this->employeedeleteleavereqfromhod_copyfn($primary_id, $leavetype,$requestedempid);
                $res_status = $this->employeedeleteleavereqfromhod_copyfn($leavetype,$partialdaysselected,$requestedempid,$requesteddate);
                
                if($res_status == 'Application Deleted'){
                    DB::connection('mysql6')->table('appl_delete_request')->where(['hash_key' => $hashkey])->delete();

                    
                    
                    if (!empty($mailarray['empmailid'])) {
                        $mailarray['ishod'] = 0;
                        $jj = strtolower($mailarray['empmailid']);
                        if (!filter_var($jj, FILTER_VALIDATE_EMAIL)) { Log::info('Not a valid address = '.$jj); }else{
                        Log::info('Sending Application Deleted confirmation Email for applied copy to employee = '.$jj);
                        Mail::to($jj)->send(new deleteconfirmationtoemployee($mailarray));
                        }
                    }


                        if(ctype_digit($mailarray['empmobileno'])){
                            if (strlen($mailarray['empmobileno']) == 10) {                                
                        $emp_smscontent = 'Dear '.$mailarray['empname'].', Your '.$leavetype.' Application on '.Carbon::parse($mailarray['app_stdate'])->format('d, M Y h:i:s A').' to '.Carbon::parse($mailarray['app_etdate'])->format('d, M Y h:i:s A').' has been deleted by HOD.'; 
                        $employee_status = $this->smscurl($emp_smscontent, $mailarray['empmobileno']); 
                        
                        Log::info('Sending delete confirmation SMS to employee = '.$mailarray['empmobileno']);
                            }
                        }

                        return('Application Deleted!');
                }
                else{
                    return $res_status;
                }
                

            }
            else{
                return 'Approved Application does not exist. Only Approved application can be deleted by HOD!';    
            }

        }
        else{
            return 'Application Expired. Please check with HR!';
        }
        
    }


    public function applications_delete_request(Request $request)
    {
        if ($request->session()->has('employeesession')) {
            $encrypt = $request->session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode('-', $decrypt);
            $employeeid = $split[0];
            $mydetails = [];
            $getemployeedata = DB::connection('mysql6')->table('employee')->where('id', '=', $employeeid)->get();


            
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


            $getactiveemployees = $this->getallactiveemployees();
            
            $getsubordinates = [];

            if (count($getactiveemployees) > 0) {
                $i=0;
                foreach ($getactiveemployees['Details'] as $key => $value) {
                    
                        if($value['RM_ID'] == $employeeid){
                        $getsubordinates[$i]['empid'] = $value['Emp_ID'];
                        $getsubordinates[$i]['empname'] = $value['Emp_Name'];
                        $i += 1;
                        }
                    
                }    
            }

            


                        $currentmonth = Carbon::now()->format('m');
                        $currentyear = Carbon::now()->format('Y');

            $applications = [];
            if (!empty($getsubordinates)) {
                $i = 0;
                foreach ($getsubordinates as $key1 => $value1) {
                    $getallapplications = DB::connection('mysql6')->table('appl_delete_request')->where(['requested_empid' => $value1['empid']])->orderBy('delete_req_raised_date', 'desc')->get()->toArray();   
                    if (count($getallapplications) > 0) {
                        foreach ($getallapplications as $key => $value) {
                            $applications[$i] = (array)$value; 

                            $leave_processed = DB::connection('mysql6')->table('leave_processed')->where(['id' => $value->primary_id,'final_status' => 'Approved'])->get();
                            foreach ($leave_processed as $key2 => $value2) {
                                $applications[$i]['leave_type'] = $value2->type;
                                $applications[$i]['stdate'] = $value2->stdate;
                                $applications[$i]['etdate'] = $value2->etdate;
                                $applications[$i]['emp_reason'] = $value2->emp_reason;
                                $applications[$i]['appl_created_date'] = $value2->created_date;
                            
                            }
                            $applications[$i]['empname'] = $value1['empname'];
                           
                            $i = $i + 1;
                        }
                    }
                }
            }
           
            //dd($applications);
            return view('newemployeezone.lms.applications_delete_request')->with(['getemployeedata'=>$getemployeedata,'getallapplications' => $applications, 'profilepic'=>$profilepic, 'employeeid' => $employeeid]);

        }
        else{
            return view('newemployeezone.login');
        }
        
    }


    public function createnewapplication_of_autorejectionapl($req_empid,$req_type, $leavetypeselected, $partialdaysselected, $requesteddate )
    {
        

           
            $requesteddate = Carbon::parse($requesteddate)->toDateString();


            $requestedmonth = Carbon::parse($requesteddate)->format('m');
            $requestedyear = Carbon::parse($requesteddate)->format('Y');
            $currentmonth = Carbon::now()->format('m');
            $currentyear = Carbon::now()->format('Y');

            $check_payroll_runned = DB::connection('mysql6')->table('leave_balance')->where(['employeeid' => $req_empid, 'month' => $requestedmonth,'year' => $requestedyear, 'completed' => 'Y'])->get();

            if(count($check_payroll_runned) == 0){
                
                if (($leavetypeselected == 'Onduty') || ($leavetypeselected == 'Tour') || ($leavetypeselected == 'Compoff') || ($leavetypeselected == 'Mispunch') || ($leavetypeselected == 'LOP')) {
                    if ($leavetypeselected == 'Tour') {
                        if ($partialdaysselected != 'full') {
                            return 'Tour can contain only Full day!';
                        }
                    }
                    if ($leavetypeselected == 'Mispunch') {
                        if ($partialdaysselected == 'full') {
                            return 'Mispunch can contain only first/second Half!';
                        }
                    }

                    
                    if ($req_type == 'admincreate') {
                    
                    $checkanyapplicationcreated = DB::connection('mysql6')->table('datetime_ref')->where(['employeeid' => $req_empid, 'date' => $requesteddate,'type' => $leavetypeselected,'partial_days' => $partialdaysselected])->whereIn('final_status',['Approved','Pending'])->get();
                                        if(count($checkanyapplicationcreated) > 0){
                                            return 'The same application created already. Please delete the application recreate!';
                                        }
                                        else{
                                            if (($partialdaysselected == 'first_half') || ($partialdaysselected == 'second_half')) {
                                            $ncheckanyapplicationcreated = DB::connection('mysql6')->table('datetime_ref')->where(['employeeid' => $req_empid, 'date' => $requesteddate,'partial_days' => 'full'])->whereIn('final_status',['Approved','Pending'])->get();
                                            if(count($ncheckanyapplicationcreated) > 0){
                                                return 'Application already applied for full day. Please delete application and try it!';
                                            }
                                        }

                                        if ($partialdaysselected == 'full') {
                                            $ncheckanyapplicationcreated = DB::connection('mysql6')->table('datetime_ref')->where(['employeeid' => $req_empid, 'date' => $requesteddate,'partial_days' => 'full'])->whereIn('final_status',['Approved','Pending'])->get();
                                            if(count($ncheckanyapplicationcreated) > 0){
                                                return 'Application already applied for full day. Please delete application and try it!';
                                            }
                                            $ycheckanyapplicationcreated = DB::connection('mysql6')->table('datetime_ref')->where(['employeeid' => $req_empid, 'date' => $requesteddate])->whereIn('partial_days',['first_half','second_half'])->whereIn('final_status',['Approved','Pending'])->get();
                                            if(count($ycheckanyapplicationcreated) > 0){
                                                return 'Application already applied for first/second half day. Please delete application and try full day!';
                                            }
                                        }

                                            $res = $this->leavecrud_create_application($req_empid, $requesteddate,$partialdaysselected,$leavetypeselected);
                                            if($res == 1){
                                                return 'Application Added!';
                                            }
                                            else{
                                                return 'Application Not Added!';    
                                            }
                                            

                                        }
                        }


                }
                elseif (($leavetypeselected == 'CL') || ($leavetypeselected == 'SL') || ($leavetypeselected == 'PL') || ($leavetypeselected == 'ML') || ($leavetypeselected == 'RH') || ($leavetypeselected == 'Permission')) {
                    if ($leavetypeselected == 'Permission') {
                        if ($partialdaysselected == 'full') {
                            return 'Permission can contain only first/second Half!';
                        }
                    }


                    if($partialdaysselected == 'full'){
                        $tominus = 1;
                    }
                    else{
                        $tominus = 0.5;
                    }
                    

                   

                    if ($req_type == 'admincreate') {
                        
                        if (($requestedmonth == '12') && ($currentmonth == '01' )) {
                            return 'Calendar Year Accrual Process scheduled. Please contact Developer';
                        }
                        else{
                            
                                $checkleave_balance = DB::connection('mysql6')->table('leave_balance')->where(['employeeid' => $req_empid, 'month' => $requestedmonth,'year' => $requestedyear, 'completed' => 'N'])->get(); 
                                if (count($checkleave_balance) > 0) {
                                    foreach ($checkleave_balance as $key => $value) {
                                        $leavbalance = $value->$leavetypeselected;
                                    }           

                                    $checkbyminus = $leavbalance - $tominus;
                                    if ($checkbyminus >= 0) {

                                        $checkanyapplicationcreated = DB::connection('mysql6')->table('datetime_ref')->where(['employeeid' => $req_empid, 'date' => $requesteddate,'type' => $leavetypeselected,'partial_days' => $partialdaysselected])->whereIn('final_status',['Approved','Pending'])->get();
                                        
                                        if(count($checkanyapplicationcreated) > 0){
                                            return 'The same application created already. Please delete the application recreate!';
                                        }
                                        else{
                                            if (($partialdaysselected == 'first_half') || ($partialdaysselected == 'second_half')) {
                                            $ncheckanyapplicationcreated = DB::connection('mysql6')->table('datetime_ref')->where(['employeeid' => $req_empid, 'date' => $requesteddate,'partial_days' => 'full'])->whereIn('final_status',['Approved','Pending'])->get();
                                            if(count($ncheckanyapplicationcreated) > 0){
                                                return 'Application already applied for full day. Please delete application and try it!';
                                            }
                                        }

                                        if ($partialdaysselected == 'full') {
                                            $ncheckanyapplicationcreated = DB::connection('mysql6')->table('datetime_ref')->where(['employeeid' => $req_empid, 'date' => $requesteddate,'partial_days' => 'full'])->whereIn('final_status',['Approved','Pending'])->get();
                                            if(count($ncheckanyapplicationcreated) > 0){
                                                return 'Application already applied for full day. Please delete application and try it!';
                                            }
                                            $ycheckanyapplicationcreated = DB::connection('mysql6')->table('datetime_ref')->where(['employeeid' => $req_empid, 'date' => $requesteddate])->whereIn('partial_days',['first_half','second_half'])->whereIn('final_status',['Approved','Pending'])->get();
                                            if(count($ycheckanyapplicationcreated) > 0){
                                                return 'Application already applied for first/second half day. Please delete application and try full day!';
                                            }
                                        }

                                            $res = $this->leavecrud_create_application($req_empid, $requesteddate,$partialdaysselected,$leavetypeselected);
                                            if($res == 1){
                                                return 'Application Added!';
                                            }
                                            else{
                                                return 'Application Not Added!';    
                                            }
                                            

                                        }
                                        
                                    }
                                    else{
                                        return 'Please check the leave balance available!';
                                    }
                                }
                                else{
                                    return 'No leave balance row created for the month - '.$requestedmonth;
                                }       
                            
                            
                        }
                        


                    }

                    


                }
                else{
                     return 'Not a valid leave type!';  
                }


            }
            else{
                return 'Cannot Edit';   
            }


           
    }

    public function autorejecton_approve(Request $request)
    {

    	if ($request->session()->has('employeesession')) {
            $encrypt = $request->session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $remployeeid = $split[0];


     


            if (in_array($remployeeid, config('newlmsconfig'))) {
                $valid = 1;
            }else{
                return 'Not a valid user';
            }

             $requestedmonthyear = $request->monthyear;
               $requestedcompany = $request->company;

               $explodemonthyear = explode('/', $requestedmonthyear);
               $month = $explodemonthyear[0];
               $year = $explodemonthyear[1];

               if ($requestedcompany == 4000) {
                   $starts_empid = "10";
               }
               elseif ($requestedcompany == 5000) {
                   $starts_empid = "20";
               }
               elseif ($requestedcompany == 7200) {
                $starts_empid = "70";
                }
               elseif ($requestedcompany == 6300) {
                $starts_empid = "60";
                }
               else{
                $starts_empid = "10";
               }




        //$month = '05';
    	//$month = Carbon::now()->format('m');
    	//$year = Carbon::now()->format('Y');

    	$getautorejected_applications = DB::connection('mysql6')->table('leave_processed')->where(['month' => $month, 'year' => $year, 'hod_status' => 'Rejected'])->where('hod_reason', 'like', '%This is system generated rejection%')->where('employeeid', 'LIKE', $starts_empid.'%')->get();

        //return json_encode($getautorejected_applications);

    	$v['toprocess_array'] = [];
    	$v['not_to_process'] = [];

    	if (count($getautorejected_applications) > 0) {
    		foreach ($getautorejected_applications as $key => $value) {

    			$daterange_array = $this->createDateRange(Carbon::parse($value->stdate)->toDateString(), Carbon::parse($value->etdate)->toDateString(), $format = "Y-m-d");
        		array_push($daterange_array, Carbon::parse($value->etdate)->toDateString());
        		$checkfor_another_applications = [];
        		foreach ($daterange_array as $key1 => $value1) {
        			
        			$checkfor_another_applications = DB::connection('mysql6')->table('datetime_ref')->where(['employeeid' => $value->employeeid, 'date' => $value1])->where('reference_id', '!=', $value->id)->whereIn('final_status',['Approved', 'Pending'])->get();
        			if (count($checkfor_another_applications) > 0) {
        				foreach ($checkfor_another_applications as $key3 => $value3) {
        					$getautorejected_applications[$key]->anotherappl_present[$value1] = $value3->employeeid.'_'.$value3->type.'_'.$value3->partial_days.'_'.$value3->final_status;
        				}
        				
        			}
        		}
    			

    		}


    		
    		foreach ($getautorejected_applications as $key4 => $value4) {

    			if (array_key_exists('anotherappl_present', $value4)) {
    				$v['not_to_process'][] = $value4;
    			}
    			else{
    				$v['toprocess_array'][] = $value4;
    				$daterange_array1 = $this->createDateRange(Carbon::parse($value4->stdate)->toDateString(), Carbon::parse($value4->etdate)->toDateString(), $format = "Y-m-d");

        			array_push($daterange_array1, Carbon::parse($value4->etdate)->toDateString());
        			
        			foreach ($daterange_array1 as $key5 => $value5) {
        				$res = $this->createnewapplication_of_autorejectionapl($value4->employeeid,'admincreate', $value4->type, $value4->partial_days, $value5 );
        				//echo $res.'<br>';
        			}

        			//dd('ok');
    				
    			}
    		}

    	}




    	return json_encode(['autoapproved_rejected' => count($v['toprocess_array'])]);
    }
    else{
    	return json_encode([]);
    }


    }



    public function pending_auto_approve($subordinateid,$status,$id ){
        if ($status == 1) {
            $mainstatus = 'Approved';
        }else{
            $mainstatus = 'Rejected';
        }

        if ($mainstatus == 'Approved') {
            $getlms_application = DB::connection('mysql6')->table('leave_processed')->where(['id'=>$id, 'hod_status' => 'Pending'])->get();
            /** start of new hod only approval */
            if (count($getlms_application) > 0) {
                $newar = [];
                $newar['employeeid'] = $subordinateid;

                foreach ($getlms_application as $key => $value) {
                    $sap_fromdate = $value->stdate;
                    $sap_todate = $value->etdate;
                    $sap_no_of_days = $value->no_of_days;
                    $sap_partial_days = $value->partial_days;
                    $sap_leave_type = $value->type;
                }


                if ($sap_partial_days == 'full') {
                    $newar['from_date'] = substr($sap_fromdate,0,10);
                    $newar['to_date'] = substr($sap_todate,0,10);
                    $newar['starttime'] = '';
                    $newar['endtime'] = '';
                }elseif($sap_partial_days == 'first_half'){
                    $newar['from_date'] = substr($sap_fromdate,0,10);
                    $newar['to_date'] = substr($sap_todate,0,10);
                    $newar['starttime'] = substr($sap_fromdate,11,5);
                    $newar['endtime'] = substr($sap_todate,11,5);
                }elseif($sap_partial_days == 'second_half'){
                    $newar['from_date'] = substr($sap_fromdate,0,10);
                    $newar['to_date'] = substr($sap_todate,0,10);
                    $newar['starttime'] = substr($sap_fromdate,11,5);
                    $newar['endtime'] = substr($sap_todate,11,5);
                }else{
                    //sd
                }
                $newar['leave_type'] = $sap_leave_type;
                //$this->insert_applicationtosapfinal($newar);
                DB::connection('mysql6')->table('send_sap_leave_details')->insert(['details' => json_encode($newar), 'created_datetime' => Carbon::now()->toDateTimeString()]);

                DB::connection('mysql6')->table('leave_processed')
                ->where(['id'=>$id,'employeeid' => $subordinateid, 'hod_status' => 'Pending'])
                ->update([
                    'hod_status' => 'Approved',
                    'hod_reason' => null,
                    'admin_status' => 'Approved',
                    'admin_created_date' => Carbon::now()->toDateTimeString(),
                    'final_status' => 'Approved',
                    'hod_created_date' => Carbon::now()->toDateTimeString()
                ]);
            }

            $get_lms_mailqueue_table = DB::connection('mysql6')->table('lms_mail_queue')->where(['reference_id'=>$id, 'processed' => '0'])->get();

            if (count($get_lms_mailqueue_table) > 0) {
                DB::connection('mysql6')->table('lms_mail_queue')
                    ->where(['reference_id'=>$id])
                    ->update([
                    'sent_to_hod' => Carbon::now()->toDateTimeString(),
                    'admin_session_key' => null,
                    'hod_session_key' => null,
                    'sent_to_admin' => Carbon::now()->toDateTimeString()
                    ]);
            }

            $get_date_diff = DB::connection('mysql6')->table('datetime_ref')->where(['reference_id'=>$id,'final_status' => 'Pending'])->get();
            if (count($get_date_diff) > 0) {
                DB::connection('mysql6')->table('datetime_ref')
                    ->where(['reference_id'=>$id,'employeeid' => $subordinateid, 'final_status' => 'Pending'])
                    ->update([
                    'final_status' => 'Approved'
                ]);
            }
            /** end of new hod only approval */

        }
        return 'Application added';
    }


    public function runautoapprove_forpending(Request $request){
    	if ($request->session()->has('employeesession')) {
            $encrypt = $request->session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $remployeeid = $split[0];

     


            if (in_array($remployeeid, config('newlmsconfig'))) {
                $valid = 1;

            }else{
                return 'Not a valid user';
            }

             $requestedmonthyear = $request->monthyear;
               $requestedcompany = $request->company;

               $explodemonthyear = explode('/', $requestedmonthyear);
               $month = $explodemonthyear[0];
               $year = $explodemonthyear[1];

               if ($requestedcompany == 4000) {
                   $starts_empid = "10";
               }
               elseif ($requestedcompany == 5000) {
                   $starts_empid = "20";
               }
               elseif ($requestedcompany == 7200) {
                $starts_empid = "70";
                }
               elseif ($requestedcompany == 6300) {
                $starts_empid = "60";
                }
               else{
                $starts_empid = "10";
               }
               
        //$month = '05';
        //$month = Carbon::now()->format('m');
        //$year = Carbon::now()->format('Y');

        $getpending_applications = DB::connection('mysql6')->table('leave_processed')->where(['month' => $month, 'year' => $year, 'hod_status' => 'Pending'])->where('employeeid', 'LIKE', $starts_empid.'%')->get();
        if(count($getpending_applications) > 0){
            foreach ($getpending_applications as $key => $value) {
              $res =   $this->pending_auto_approve($value->employeeid,'1',$value->id );
              //echo $res;

            }
            return json_encode(['pendingapp' => count($getpending_applications)]);
        }
        else{
            return json_encode([]);
        }

    }
    else{
    	return json_encode([]);
    }



        
    }


    public function make_a_newemployee_balance_record()
    {
        $current_month = Carbon::now()->format('m');
        $current_year = Carbon::now()->format('Y');
        $getcurrentmonth_balance_records = DB::connection('mysql6')->table('leave_balance')->where(['month' => $current_month, 'year' => $current_year])->get();
        $getactiveemployees = $this->getallactiveemployees();
        $currentmonth_joinees = [];
        $ccmonth = Carbon::now()->format('Y-m');
        foreach ($getactiveemployees['Details'] as $key => $value) {

            $join_month = Carbon::parse($value['DOJ'].' 00:00:00')->format('Y-m');
            if ($join_month == $ccmonth) {
                $currentmonth_joinees[] = $value;
            }
            
        }

        if (count($currentmonth_joinees) > 0) {

            foreach ($currentmonth_joinees as $key1 => $value1) {
                $currentmonth_joinees[$key1]['is_record_created'] = false;
                foreach ($getcurrentmonth_balance_records as $key2 => $value2) {
                    $present = false;
                    
                        if ($value1['Emp_ID'] == $value2->employeeid) {
                            $present = true;
                        }
                    

                    if ($present == true) {
                        $currentmonth_joinees[$key1]['is_record_created'] = true;
                    }
                }
            }

            foreach ($currentmonth_joinees as $key3 => $value3) {
                if ($value3['is_record_created'] == false) {
                    
                    DB::connection('mysql6')->table('leave_balance')->insert([
                        'id' => null,
                        'employeeid' => $value3['Emp_ID'],
                        'month' => $current_month,
                        'year' => $current_year,
                        'CL' => 0,
                        'SL' => 0,
                        'PL' => 0,
                        'ML' => 0,
                        'RH' => 0,
                        'Permission' => 2,
                        'Present' => 0,
                        'LOP' => 0,
                        'Absent' => 0,
                        'late_count' => 0,
                        'total_late_hours' => 0,
                        'early_out_count' => 0,
                        'total_early_out_hours' => 0,
                        'completed' => 'N',

                        ]);
                }
            }

        }
        dd($currentmonth_joinees);
    }
   



 public function reversesentloplate(Request $request)
    {

        if ($request->session()->has('employeesession')) {
            $encrypt = $request->session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $remployeeid = $split[0];

     


            if (in_array($remployeeid, config('newlmsconfig'))) {
                $valid = 1;
            }else{
                dd('Not a valid user');
            }

        $month = '08';
        $year = '2019';
        $getlms_application = DB::connection('mysql6')->table('latededuction_finaltosap')->where(['month' => $month,'year' => $year])->where('employeeid','>=','200937')->get();
	
         foreach ($getlms_application as $key26 => $value26) {
						$newar = [];
                                            $newar['employeeid'] = $value26->employeeid;
                                                $sap_fromdate = $value26->deduction_stdate_time;
                                                $sap_todate = $value26->deduction_etdate_time;
                                                
                                                $sap_partial_days = $value26->partial_days;
                                                $sap_leave_type = $value26->type;
                                            
                                            
                            
                                            if ($sap_partial_days == 'full') {
                                            
                                                $newar['from_date'] = substr($sap_fromdate,0,10);
                                                $newar['to_date'] = substr($sap_todate,0,10);
                                                $newar['starttime'] = '';
                                                $newar['endtime'] = '';
                            
                                            }
                                            elseif($sap_partial_days == 'first_half'){
                                                $newar['from_date'] = substr($sap_fromdate,0,10);
                                                $newar['to_date'] = substr($sap_todate,0,10);
                                                $newar['starttime'] = substr($sap_fromdate,11,5);
                                                $newar['endtime'] = substr($sap_todate,11,5);
                            
                                            }
                                            elseif($sap_partial_days == 'second_half'){
                                                $newar['from_date'] = substr($sap_fromdate,0,10);
                                                $newar['to_date'] = substr($sap_todate,0,10);
                                                $newar['starttime'] = substr($sap_fromdate,11,5);
                                                $newar['endtime'] = substr($sap_todate,11,5);
                            
                                            }else{
                                                //sd
                                            }
                                            $newar['leave_type'] = $sap_leave_type;
                                            //dd($newar);

                                            $deleteappl = $this->delete_leave_applied($newar);
					    Log::info('SAP result '.$sap_leave_type.'----'.$newar['employeeid'].'------'.$sap_partial_days.'-----'.$deleteappl['Status']);
					    echo 'SAP result '.$sap_leave_type.'----'.$newar['employeeid'].'------'.$sap_partial_days.'-----'.$deleteappl['Status'].'<br>';
                                        }
                                    }
                                    else{
                                        dd('Not a Valid User');
                                    }
    }


public function savepayrolldata()
    {
        $month = '03';
        $year = '2021';

        $getcount = DB::connection('mysql6')->table('payroll')->where(['month' => $month, 'year' => $year ])->count();
        if ($getcount == 0) {
            $gettoprocess = DB::connection('mysql6')->table('lateacrual_process')->where(['month' => $month, 'year' => $year ])->take(10)->get();
        }
        else{
            $gettoprocess = DB::connection('mysql6')->table('lateacrual_process')->where(['month' => $month, 'year' => $year ])->skip($getcount)->take(10)->get();
        }
        
        //dd($gettoprocess);
        if (count($gettoprocess) > 0) {

            foreach ($gettoprocess as $key => $value) {
                $employeeid = $value->employeeid;
            $requestedmonthdate = $year.'-'.$month.'-01';

            $check = DB::connection('mysql6')->table('payroll')->where(['employeeid' => $employeeid,'month' => $month, 'year' => $year ])->count();
            if ($check == 0) {
                DB::connection('mysql6')->table('payroll')->insert(['employeeid' => $employeeid,
                    'emp_name' => $value->emp_name,
                    'role_code' => $value->role_code,
                    'plant_code' => $value->plant_code,
                    'position' => $value->position,
                    'department' => $value->department,
                    'cadre' => $value->cadre,
                    'doj' => $value->doj,
                    'month' => $month,
                    'year' => $year,
                    'processed_date' => Carbon::now()->toDateTimeString()
                     ]);


            $data = $this->payroll_report_attendance($employeeid, $month, $year, $requestedmonthdate);
            $toupdatearr = [];
            //dd($data['row']["$employeeid"]);
            foreach ($data['row']["$employeeid"] as $key1 => $value1) {
                $leaves = null;
                $nn1 = null;
                $nn2 = null;
                if (!empty($value1['lms_attendance'])) {
                    if (array_key_exists('full',$value1['lms_attendance'])) {
                        $nn1 = $value1['lms_attendance']['full'];
                    }
                    if (array_key_exists('first_half',$value1['lms_attendance'])) {
                        $nn1 = 'FH'.$value1['lms_attendance']['first_half'];
                    }
                    if (array_key_exists('second_half',$value1['lms_attendance'])) {
                        $nn2 = 'SH'.$value1['lms_attendance']['second_half'];
                    }

                    

                    if (count($value1['lms_attendance']) == '2') {
                        $leaves = $nn1.'/'.$nn2;
                    }
                    else{
                            if (array_key_exists('second_half',$value1['lms_attendance'])) {
                                $leaves = $nn2;
                            }
                            else{
                                $leaves = $nn1;
                            }
                        
                    }

                }
                $subst = substr($key1, 8,2);
                $toupdatearr["$subst"] = $leaves;
                
                $toupdatearr['CL'] = $value1['CL'];
                $toupdatearr['SL'] = $value1['SL'];
                $toupdatearr['PL'] = $value1['PL'];
                $toupdatearr['ML'] = $value1['ML'];
                $toupdatearr['RH'] = $value1['RH'];
                $toupdatearr['Permission'] = $value1['Permission'];
                $toupdatearr['Onduty'] = $value1['Onduty'];
                $toupdatearr['Tour'] = $value1['Tour'];
                $toupdatearr['Compoff'] = $value1['Compoff'];
                $toupdatearr['Mispunch'] = $value1['Mispunch'];
                $toupdatearr['Absent'] = $value1['Absent'];
                $toupdatearr['LOP'] = $value1['LOP'];
                
                $toupdatearr['Present'] = $value1['Present'];

                
            }

            //dd($toupdatearr);
            DB::connection('mysql6')->table('payroll')->where(['employeeid' => $employeeid,'month'=>$month,'year' => $year])->update($toupdatearr);

            }
            
            }

            


        }
        dd($gettoprocess);
    }



public function sendcustom_leaves()
    {
        $employeeids = ["100011",
"100015",
"100016",
"100018",
"100019",
"100032",
"100043",
"100056",
"100138",
"100208",
"100233",
"100234",
"100250",
"100256",
"100302",
"100305",
"100307",
"100323",
"100327",
"100329",
"100331",
"100338",
"100341",
"100342",
"100345",
"100346",
"100374",
"100380",
"100382",
"100390",
"100392",
"100423",
"100441",
"100466",
"100467",
"100468",
"100498",
"100501",
"100511",
"100526",
"100527",
"100532",
"100535",
"100555",
"100556",
"100574",
"100588",
"100591",
"100645",
"100688",
"100700",
"100756",
"100759",
"100761",
"100767",
"100770",
"100775",
"100783",
"100794",
"100811",
"100823",
"100845",
"100849",
"100872",
"100873",
"100903",
"100912",
"200002",
"200003",
"200009",
"200012",
"200040",
"200062",
"200095",
"200120",
"200372",
"200406",
"200548",
"200559",
"200865",
"200880",
"200937",
"200977",
"201137",
"201141",
"201145",
"201162",
"201164",
"201172",
"201229"];
        //$employeeids = ['100323'];
        

        $monthdate = Carbon::now()->subDays(10)->toDateString();
        /*$startdate = Carbon::parse($monthdate)->startOfMonth()->toDateString();
        $enddate = Carbon::parse($monthdate)->endOfMonth()->toDateString();*/

        $startdate = '2019-12-14';
        $enddate = '2019-12-14';
        $leave_type = 'Tour';
        $partial_days = 'full';

        $daterange_array = $this->createDateRange($startdate, $enddate, $format = "Y-m-d");
        array_push($daterange_array, $enddate);
        //dd($daterange_array);
        $diff = count($daterange_array);
        foreach ($employeeids as $employeeid) {        
        //start
        

        $getshiftdetails = $this->getshiftdetailsst_et_date($employeeid, $startdate, $enddate);
        $hourtoadd = 0;
        $time = 0;
        $time_arr = [];
        
            foreach ($getshiftdetails['Shift_Details'] as $key2 => $value2) {

                    if (($value2['Shift_Code'] == 'VGN_NIGT') || ($value2['Shift_Code'] == 'VGN_FNIG')) {
                        $std = Carbon::parse($value2['Shift_Date'])->addDay()->toDateString();
                    }
                    else{
                        $std = $value2['Shift_Date'];
                    }

                    //$fhourtoadd = substr(Carbon::parse($value2['Shift_Date'].' '.$value2['Start_Time'])->diff(Carbon::parse($std.' '.$value2['End_Time']))->format('%H:%i:%s'), 0,2);
                    
                    //$hourtoadd = $fhourtoadd + $hourtoadd;
                    $diffintimehours = Carbon::parse($value2['Shift_Date'].' '.$value2['Start_Time'])->diffInSeconds(Carbon::parse($std.' '.$value2['End_Time']));
                    $newhours = gmdate('H:i', $diffintimehours); 
                    array_push($time_arr, $newhours);
                
            }
            
            foreach ($time_arr as $k => $time_val) {

                $time += $this->explode_time($time_val); 
            }

            $hourtoadd = $this->second_to_hhmm($time);
               

        if (($getshiftdetails['Shift_Details'][0]['Shift_Code'] == 'VGN_NIGT') || ($getshiftdetails['Shift_Details'][0]['Shift_Code'] == 'VGN_FNIG')) {
            
            $std_string = Carbon::parse($getshiftdetails['Shift_Details'][0]['Shift_Date'])->addDay()->toDateString();
            $startdatetime = $getshiftdetails['Shift_Details'][0]['Shift_Date'].' '.$getshiftdetails['Shift_Details'][0]['Start_Time'];

        }
        else{
            $startdatetime = $getshiftdetails['Shift_Details'][0]['Shift_Date'].' '.$getshiftdetails['Shift_Details'][0]['Start_Time'];
        }

        if (($getshiftdetails['Shift_Details'][count($getshiftdetails['Shift_Details']) - 1]['Shift_Code'] == 'VGN_NIGT') || ($getshiftdetails['Shift_Details'][count($getshiftdetails['Shift_Details']) - 1]['Shift_Code'] == 'VGN_FNIG')) {

            $std_string = Carbon::parse($getshiftdetails['Shift_Details'][count($getshiftdetails['Shift_Details']) - 1]['Shift_Date'])->addDay()->toDateString();
            $enddatetime = $std_string.' '.$getshiftdetails['Shift_Details'][count($getshiftdetails['Shift_Details']) - 1]['End_Time'];

        }
        else{
            $enddatetime = $getshiftdetails['Shift_Details'][count($getshiftdetails['Shift_Details']) - 1]['Shift_Date'].' '.$getshiftdetails['Shift_Details'][count($getshiftdetails['Shift_Details']) - 1]['End_Time'];
        }
        
        $no_of_hours = $hourtoadd;
        
        
        $month = Carbon::parse($startdate)->format('m');
        $currentmonth = Carbon::now()->format('m');
        $year = Carbon::parse($startdate)->format('Y');
        $currentyear = Carbon::now()->format('Y');
       $getid = DB::connection('mysql6')->table('leave_processed')->insertGetId([
            'employeeid' => $employeeid,
            'month' => $month,
            'year' => $year,
            'type' => $leave_type,
            'stdate' => $startdatetime,
            'etdate' => $enddatetime,
            'no_of_hours' => $no_of_hours,
            'no_of_days' => $diff,
            'partial_days' => $partial_days,
            'emp_reason' => 'auto generated',
            'created_date' => Carbon::now()->toDateTimeString(),
            'hod_status' => 'Approved',
            'hod_reason' => null,
            'hod_created_date' => Carbon::now()->toDateTimeString(),
            'admin_status' => 'Approved',
            'admin_reason' => null,
            'admin_created_date' => Carbon::now()->toDateTimeString(),
            'final_status' => 'Approved',
            'saved_file_path' => null,
            'valid_till' => Carbon::now()->addDays(5)->toDateTimeString()
        ]);
        
    foreach ($daterange_array as $key => $value) {
        foreach ($getshiftdetails['Shift_Details'] as $key3 => $value3) {
            if ($value == $value3['Shift_Date']) {
                DB::connection('mysql6')->table('datetime_ref')->insert([
                    'employeeid' => $employeeid,
                    'month' => Carbon::parse($value)->format('m'),
                    'year' => Carbon::parse($value)->format('Y'),
                    'applied_month' => $currentmonth,
                    'applied_year' => $currentyear,
                    'type' => $leave_type,
                    'shift_code' => $value3['Shift_Code'],
                    'final_status' => 'Approved',
                    'date' => $value,
                    'start_end_time' => $value3['Start_Time'].'-'.$value3['End_Time'],
                    'partial_days' => $partial_days,
                    'reference_id' => $getid
                ]);
            }
        }
      
    }

   
   
    
    DB::connection('mysql6')->table('leave_balance')->where(['employeeid' => $employeeid, 'month' => $currentmonth,'year' => $currentyear])
        ->update([
            $leave_type => $diff
        ]);
        //end

        $newar = [];
            $newar['employeeid'] = $employeeid;
            $newar['from_date'] = $startdate;
            $newar['to_date'] = $enddate;
            $newar['starttime'] = '';
            $newar['endtime'] = '';
            $newar['leave_type'] = $leave_type;
        
        
        
        DB::connection('mysql6')->table('send_sap_leave_details')->insert(['details' => json_encode($newar), 'created_datetime' => Carbon::now()->toDateTimeString()]);

    }

    dd('finished');
    }
    
    public function openpayrollmonthtoedit($month, $year)
    {
        if (session()->has('employeesession')) {
                $encrypt = session()->get('employeesession');
                $decrypt = Crypt::decrypt($encrypt);
                $split = explode("-",$decrypt);
                $remployeeid = $split[0];
    
                if (in_array($remployeeid, config('newlmsconfig'))) {
                     DB::connection('mysql6')->table('leave_balance')->where(['month' => $month, 'year' => $year])->update([
            'completed' => 'N'
        ]);
    
        return 'Opened to edit';
                }
                else{
                    return 'Not a valid user';
                }
        
       
        }
        else{
            return 'Not a valid user';
        }
    }
    
    public function viewapprovedapplication($empid,$month, $year)
    {
        if (session()->has('employeesession')) {
                $encrypt = session()->get('employeesession');
                $decrypt = Crypt::decrypt($encrypt);
                $split = explode("-",$decrypt);
                $remployeeid = $split[0];
    
                if (in_array($remployeeid, config('newlmsconfig'))) {
                    $getapp = DB::connection('mysql6')->table('datetime_ref')->where(['employeeid' => $empid,'month' => $month, 'year' => $year,'final_status' => 'Approved'])->orderBy('date','desc')->get();
    
                    if (count($getapp) > 0) {
                        foreach($getapp as $aa => $vv){
                            echo $vv->employeeid.'|'.$vv->type.'|<b>'.$vv->date.'</b>|'.$vv->start_end_time.'|'.$vv->partial_days.'|'.$vv->reference_id.'<br/>';
                        }
                        echo '<br/><br/><br/>';
                    }

                    $lateprocesscheck = DB::connection('mysql6')->table('lateacrual_process')->where(['month' => $month, 'year' => $year,'processed' => 'N'])->orderBy('employeeid','desc')->get();

                    if (count($lateprocesscheck) > 0) {
                        foreach ($lateprocesscheck as $key => $value) {
                            echo $value->employeeid.'|'.$value->emp_name.'|'.$value->plant_code.'|'.$value->department.'|'.$value->cadre.'|'.$value->doj.'<br>';
                        }
                        echo '<br/><br/><br/>';
                    }

                    $leave_balance = DB::connection('mysql6')->table('leave_balance')->where(['month' => $month, 'year' => $year])->orderBy('employeeid','desc')->get();

                    if (count($leave_balance) > 0) {
                        foreach ($leave_balance as $key1 => $value1) {
                            echo $value1->employeeid.'|'.$value1->CL.'|'.$value1->SL.'|'.$value1->PL.'|'.$value1->RH.'|'.$value1->Permission.'|'.$value1->Onduty.'|'.$value1->Tour.'|'.$value1->Compoff.'|'.$value1->Mispunch.'|'.$value1->Present.'|'.$value1->LOP.'|'.$value1->Absent.'|'.$value1->late_count.'|'.$value1->total_late_hours.'|'.$value1->early_out_count.'|'.$value1->total_early_out_hours.'|'.$value1->completed.'<br>';
                        }
                        echo '<br/><br/><br/>';
                    }


                    $lateprocesscheck1 = DB::connection('mysql6')->table('datetime_ref')->where(['month' => $month, 'year' => $year])->orderBy('employeeid','desc')->get();

                    if (count($lateprocesscheck1) > 0) {
                        foreach ($lateprocesscheck1 as $key2 => $value2) {
                            echo $value2->employeeid.'|'.$value2->month.'|'.$value2->year.'|'.$value2->type.'|'.$value2->shift_code.'|'.$value2->final_status.'|'.$value2->date.'|'.$value2->start_end_time.'|'.$value2->partial_days.'|'.$value2->reference_id.'<br>';
                        }
                        echo '<br/><br/><br/>';
                    }

                    $lateprocesscheck2 = DB::connection('mysql6')->table('leave_processed')->where(['month' => $month, 'year' => $year])->orderBy('employeeid','desc')->get();

                    if (count($lateprocesscheck2) > 0) {
                        foreach ($lateprocesscheck2 as $key3 => $value3) {
                            echo $value3->employeeid.'|'.$value3->month.'|'.$value3->year.'|'.$value3->type.'|'.$value3->stdate.'|'.$value3->etdate.'|'.$value3->partial_days.'|'.$value3->emp_reason.'|'.$value3->final_status.'<br>';
                        }
                        echo '<br/><br/><br/>';
                    }

                    $lateprocesscheck3 = DB::connection('mysql6')->table('send_sap_leave_details')->get();
                    dd($lateprocesscheck3);
    
        //return 'Late script open to edit';
                }
                else{
                    return 'Not a valid user';
                }
        
       
        }
        else{
            return 'Not a valid user';
        }
    }
    
    public function latescriptrunopen($month, $year)
    {
        if (session()->has('employeesession')) {
                $encrypt = session()->get('employeesession');
                $decrypt = Crypt::decrypt($encrypt);
                $split = explode("-",$decrypt);
                $remployeeid = $split[0];
    
                if (in_array($remployeeid, config('newlmsconfig'))) {
                     DB::connection('mysql6')->table('lateacrual_process')->where(['month' => $month, 'year' => $year])->update([
            'processed' => 'N'
        ]);
    
        return 'Late script open to edit';
                }
                else{
                    return 'Not a valid user';
                }
        
       
        }
        else{
            return 'Not a valid user';
        }
    }

    public function payrollprocess_screen()
    {
        if (session()->has('employeesession')) {
            $encrypt = session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $remployeeid = $split[0];
            
            

            if (in_array($remployeeid, config('newlmsconfig'))) {

                $getemployeedata = DB::connection('mysql6')->table('employee')->where('id', '=', $remployeeid)->get();
                $listfiles = Storage::disk('s3')->files("/newcustomerzoneassets/employeeprofileimage/".$remployeeid);             
                if(count($listfiles) > 0){
                   $profilepic = config('app.AWS_URL')."/".$listfiles[0];
               }
                else
                {
                   $profilepic = config('app.AWS_URL')."/newcustomerzoneassets/img/dummy_male.png";
                }

                if(session()->has('payrollprocess_session'))
                {
                    $payrolldata = session()->get('payrollprocess_session');
                }
                else{
                    $payrolldata = [];
                }
               //approvedapplprocess_session
               if(session()->has('approvedapplprocess_session'))
                {
                    $approveddata = session()->get('approvedapplprocess_session');
                }
                else{
                    $approveddata = [];
                }
                //$request->session()->put('payrollview_session', $payrollviewsession);
                if(session()->has('payrollview_session'))
                {
                    $payrollviewsession = session()->get('payrollview_session');
                }
                else{
                    $payrollviewsession = [];
                }

               return view('newemployeezone.lms.payrollprocess_screen')
                   ->with(['getemployeedata'=>$getemployeedata,
                                           'profilepic' => $profilepic, 'payrolldata' => $payrolldata,'approveddata' => $approveddata,'payrollviewsession' => $payrollviewsession]);


                
            }
            else{
                return redirect()->route('newemployee_home');
            }
        }
        else{
            return redirect()->route('newemployee_home');
        }
    }

    public function payrollprocess_clrduplicterecords(Request $request)
    {
        if (session()->has('employeesession')) {
            $encrypt = session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $remployeeid = $split[0];

            if (in_array($remployeeid, config('newlmsconfig'))) {

               $requestedmonthyear = $request->monthyear;
               $requestedcompany = $request->company;

               $explodemonthyear = explode('/', $requestedmonthyear);
               $month = $explodemonthyear[0];
               $year = $explodemonthyear[1];

               if ($requestedcompany == 4000) {
                   $starts_empid = "10";
               }
               elseif ($requestedcompany == 5000) {
                   $starts_empid = "20";
               }
               elseif ($requestedcompany == 7200) {
                $starts_empid = "70";
                }
               elseif ($requestedcompany == 6300) {
                $starts_empid = "60";
                }
               else{
                $starts_empid = "10";
               }


               $data = DB::connection('mysql6')->table('datetime_ref')->where(['month' => $month, 'year' => $year, 'final_status' => 'Approved'])->where('employeeid', 'LIKE', $starts_empid.'%')->get();
               //$ss = array_columns($data, 'employeeid','date');

               //return json_encode($ss);
               $dup_records = [];
               foreach ($data as $key1 => $value1) {
                   $v1 = $value1->employeeid.$value1->date.$value1->partial_days;
                   $applid = $value1->reference_id;
                   $dup_records[$v1][] = $value1;
               }

               $final_duplicates = [];
               if (count($dup_records) > 0) {
                $i = 0;
                   foreach ($dup_records as $keyq => $valueq) {
                       if (count($valueq) > 1) {
                           $final_duplicates[$i] = $valueq;
                           $i++;
                       }
                   }
               }
               
               return json_encode($final_duplicates);

                
            }
            else{
                return 0;
            }
        }
        else{
            return 0;
        }
    }

    public function startpayrollprocessinportal(Request $request)
    {
        if (session()->has('employeesession')) {
            $encrypt = session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $remployeeid = $split[0];

            if (in_array($remployeeid, config('newlmsconfig'))) {

               $requestedmonthyear = $request->monthyear;
               $requestedcompany = $request->company;

               $explodemonthyear = explode('/', $requestedmonthyear);
               $month = $explodemonthyear[0];
               $year = $explodemonthyear[1];

               if ($requestedcompany == 4000) {
                   $starts_empid = "10";
               }
               elseif ($requestedcompany == 5000) {
                   $starts_empid = "20";
               }
               elseif ($requestedcompany == 7200) {
                $starts_empid = "70";
                }
               elseif ($requestedcompany == 6300) {
                $starts_empid = "60";
                }
               else{
                $starts_empid = "10";
               }

               $now = Carbon::now();
               $prevstartmonthcheck = $now->subMonth();
               $requestedcheckformat = Carbon::parse($year.'-'.$month.'-01')->toDateString();
               $add10days = Carbon::parse($requestedcheckformat)->addDays(10);
               if (Carbon::parse($now)->gt(Carbon::parse($add10days))) {
                   return 11;
               }

               
               if($prevstartmonthcheck->startOfMonth()->format('Y-m-d') != $requestedcheckformat){
                   return 11;
               }
               
               $active_emp = $this->getallactiveemployees();

               if ($request->session()->has('payrollprocess_session')) {
                $payrolldata = $request->session()->get('payrollprocess_session');
                if($payrolldata != $starts_empid){
                    $request->session()->forget('payrollprocess_session');
                    $listtoaddinsession = [];

               foreach ($active_emp['Details'] as $key => $value) {
                   if(substr($value['Emp_ID'],0,2) == $starts_empid){
                    $listtoaddinsession[$starts_empid][$value['Emp_ID']] = $value;
                    $listtoaddinsession[$starts_empid][$value['Emp_ID']]['payrollprocessed'] = 0;
                   }
               }

                $request->session()->put('payrollprocess_session', $listtoaddinsession);
                return json_encode($listtoaddinsession);
                }

                return json_encode($payrolldata);
               }
               else{
               $listtoaddinsession = [];

               foreach ($active_emp['Details'] as $key => $value) {
                   if(substr($value['Emp_ID'],0,2) == $starts_empid){
                    $listtoaddinsession[$starts_empid][$value['Emp_ID']] = $value;
                    $listtoaddinsession[$starts_empid][$value['Emp_ID']]['payrollprocessed'] = 0;
                   }
               }

               $request->session()->put('payrollprocess_session', $listtoaddinsession);
               return json_encode($listtoaddinsession);
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

    public function sendlatetosapviaportal(Request $request)
    {

        Log::info(Carbon::now()->toDateTimeString());
        Log::info('------------Late request received----------');
        $requestdata[] = $request->recordstoprocess;

        $getcurrent_datetime = Carbon::now()->toDateTimeString();
        $startofmonth = Carbon::now()->startOfMonth()->toDateString();
        $getcurrenddate = Carbon::now()->toDateString();
        $seconddate = Carbon::parse($startofmonth)->addDay(1)->toDateString();

        if(session()->has('payrollprocess_session'))
        {
            $payrolldata = session()->get('payrollprocess_session');       
        }
        else{
            return 0;
        }
		//$payrolldata;
		//return $requestdata[0]['Emp_ID'];

        $lates = [];
        
                //script start
        $process_month = Carbon::parse($getcurrenddate)->subDays(10)->format('m');
        $process_year = Carbon::parse($getcurrenddate)->subDays(10)->format('Y');
        //$requestdata =  DB::connection('mysql6')->table('lateacrual_process')->where(['processed'=>'N' ])->orderBy('employeeid', 'desc')->take(5)->get();
        
        if (count($requestdata) > 0) {

            
            foreach ($requestdata as $key => $value) {
                //return $value;

                $newmonth = Carbon::parse($getcurrenddate)->format('m');
                $newyear = Carbon::parse($getcurrenddate)->format('Y');
                $isvalid = DB::connection('mysql6')->table('leave_balance')->where(['employeeid' => $value['Emp_ID'], 'month' => $newmonth, 'year' => $newyear])->get();
                $isvalidprev = DB::connection('mysql6')->table('leave_balance')->where(['employeeid' => $value['Emp_ID'], 'month' => $process_month, 'year' => $process_year])->get();

                if (count($isvalid) == 0) {
                    DB::connection('mysql6')->table('lateacrual_process')->where(['employeeid' => $value['Emp_ID'], 'month' => $process_month, 'year' => $process_year])->delete();
                    continue;
                }
                if (count($isvalidprev) == 0) {
                    DB::connection('mysql6')->table('lateacrual_process')->where(['employeeid' => $value['Emp_ID'], 'month' => $process_month, 'year' => $process_year])->delete();
                    continue;
                }

                $json_decoded_data = $value;
                $employeeid = $value['Emp_ID'];
                
                //started
                $attendance = $this->newattendancesummary($employeeid, "$process_month", "$process_year");
		$processed_attendance = $this->weekoff_holiday_process($attendance);
             $attendance = $processed_attendance;
                //return $attendance;
                $latecount = 0;
                $earlyoutcount = 0;
                $absent = 0;
                $present = 0;
                $lop = 0;
                foreach($attendance as $newkey => $newvalue){

                                     
                     //timeget
    $diffinminutes = Carbon::parse($newvalue['shift_startdatetime'])->diffInSeconds(Carbon::parse($newvalue['shift_enddatetime']));
    $minutesdivide = $diffinminutes/2;
    $gmate = gmdate('H:i:s', $minutesdivide);
    
    $splitsub = explode(':', $gmate);
    if (($newvalue['shift_code'] == 'VGN_GEN') || ($newvalue['shift_code'] == 'VGN_GEN2') || ($newvalue['shift_code'] == 'VGN_RCP1') || ($newvalue['shift_code'] == 'VGN_RCP2') || ($newvalue['shift_code'] == 'VGN_SAP') || ($newvalue['shift_code'] == 'VGN_MGR') ) {
    $midtime = Carbon::parse($newvalue['shift_startdatetime'])->addHours($splitsub[0])->addMinutes($splitsub[1])->subMinutes(30)->toDateTimeString();
    }
    else{
        $midtime = Carbon::parse($newvalue['shift_startdatetime'])->addHours($splitsub[0])->addMinutes($splitsub[1])->toDateTimeString();
    }

    if (!empty($newvalue['punchlist'])) { $punchlist = json_encode($newvalue['punchlist']);}else{ $punchlist = null; }
    if (!empty($newvalue['lms_applications'])) { $lmsapp = json_encode($newvalue['lms_applications']);}else{ $lmsapp = null; }
    if (!empty($newvalue['first_half_considered_punches'])) { $first_half_considered_punches_list = json_encode($newvalue['first_half_considered_punches']);}else{ $first_half_considered_punches_list = null; }

                    //timeget
                    $add1hourmidtime = Carbon::parse($newvalue['shift_startdatetime'])->addMinutes(90);
                    $add3hourendtime = Carbon::parse($newvalue['shift_enddatetime'])->addHours(3);

                    $newcurrentdatetime = Carbon::now();
                    

          
                    if($newvalue['latecount'] != 0){
                        $latecount += 1;
                     }
    
                     if($newvalue['earlyoutcount'] != 0){
                        $earlyoutcount += 1;
                     }
                     
                        $absent += $newvalue['absent'];
                        $present += $newvalue['present'];

                    if((($newvalue['first_half_lop'] != 0) || ($newvalue['second_half_lop'] != 0)) && ($newvalue['absent'] == 0))
                    {
                        if($newvalue['first_half_lop'] == 0.5){


                            $checkprev = DB::connection('mysql6')->table('latededuction_finaltosap')->where([
                                'employeeid' => $employeeid ,
                            'month' => "$process_month", 
                            'year'=> "$process_year", 
                            'deduction_stdate_time'=> $newvalue['shift_startdatetime'], 
                            'deduction_etdate_time' => $midtime,
                            'partial_days' => 'first_half',
                            'type' => 'LATE'
                                 ])->count();

                            $explodetime1 = explode(' ', $newvalue['shift_startdatetime']);
                            $explodetime2 = explode(' ', $midtime);
                            $arr = [
                                'employeeid' => $employeeid,
                                "from_date"=> substr($newvalue['shift_startdatetime'],0,10),
                                "to_date"=> substr($midtime,0,10),
                                "leave_type"=> 'LATE',
                                "starttime"=> substr($explodetime1[1],0,5),
                                "endtime"=> substr($explodetime2[1],0,5)
                             ];
                            
                             $sentosap = 'Y';
                             $lates[] = $arr;

                             Log::info('SAP Late deduction sap error... '.$employeeid);
                            

                             if($checkprev == 0){

                            $getready_process =  DB::connection('mysql6')->table('latededuction_finaltosap')
                        ->insert([
                            'employeeid' => $employeeid ,
                            'emp_name' => $json_decoded_data['Emp_Name'],
                            'role_code' => $json_decoded_data['Role_Code'],
                            'plant_code' => $json_decoded_data['Plant_Code'],
                            'position' => $json_decoded_data['Position'],
                            'department' => $json_decoded_data['Department'],
                            'cadre' => $json_decoded_data['Cadre'],
                            'month' => "$process_month", 
                            'year'=> "$process_year", 
                            'deduction_stdate_time'=> $newvalue['shift_startdatetime'], 
                            'deduction_etdate_time' => $midtime,
                            'partial_days' => 'first_half',
                            'type' => 'LATE',
                            'punchlist' => $punchlist,
                            'lms_applications' => $lmsapp,
                            'first_half_lop' => $newvalue['first_half_lop'],
                            'second_half_lop' => $newvalue['second_half_lop'],
                            'latecount' => $newvalue['latecount'],
                            'latein_hours' => $newvalue['latein_hours'],
                            'laterange1' => $newvalue['laterange1'],
                            'laterange2' => $newvalue['laterange2'],
                            'laterange3' => $newvalue['laterange3'],
                            'earlyoutcount' => $newvalue['earlyoutcount'],
                            'earlyout_hours' => $newvalue['earlyout_hours'],
                            'absent' => $newvalue['absent'],
                            'present' => $newvalue['present'],
                            'first_half_considered_punches' => $first_half_considered_punches_list,
                            'sento_sap' => $sentosap,
                            'sento_sapdate' => Carbon::now()->toDateTimeString()
                             ]);

                            }
                            else
                            {
                                $getready_process =  DB::connection('mysql6')->table('latededuction_finaltosap')->where(
                                    ['employeeid' => $employeeid ,
                                    'month' => "$process_month", 
                                    'year'=> "$process_year", 
                                    'deduction_stdate_time'=> $newvalue['shift_startdatetime'], 
                                    'deduction_etdate_time' => $midtime,
                                    'partial_days' => 'first_half',
                                    'type' => 'LATE']
                                )->update([
                                    'sento_sap' => $sentosap,
                                    'sento_sapdate' => Carbon::now()->toDateTimeString()
                                ]);

                            }
                        }
                        if($newvalue['second_half_lop'] == 0.5){
                            $checkprev = DB::connection('mysql6')->table('latededuction_finaltosap')->where([
                                'employeeid' => $employeeid ,
                            'month' => "$process_month", 
                            'year'=> "$process_year", 
                            'deduction_stdate_time'=> $midtime, 
                            'deduction_etdate_time' => $newvalue['shift_enddatetime'],
                            'partial_days' => 'second_half',
                            'type' => 'LATE'
                                 ])->count();
                                 
                            $explodetime1 = explode(' ', $midtime);
                            $explodetime2 = explode(' ', $newvalue['shift_enddatetime']);
                            $arr = [
                                'employeeid' => $employeeid,
                                "from_date"=> substr($midtime,0,10),
                                "to_date"=> substr($newvalue['shift_enddatetime'],0,10),
                                "leave_type"=> 'LATE',
                                "starttime"=> substr($explodetime1[1],0,5),
                                "endtime"=> substr($explodetime2[1],0,5)
                             ];
                            
                             $sentosap = 'Y';
                             $lates[] = $arr;
                             
                             Log::info('SAP Late deduction sap error... '.$employeeid);
                             

                             if($checkprev == 0){
                                $getready_process =  DB::connection('mysql6')->table('latededuction_finaltosap')
                                ->insert([
                                    'employeeid' => $employeeid ,
                                    'emp_name' => $json_decoded_data['Emp_Name'],
                                    'role_code' => $json_decoded_data['Role_Code'],
                                    'plant_code' => $json_decoded_data['Plant_Code'],
                                    'position' => $json_decoded_data['Position'],
                                    'department' => $json_decoded_data['Department'],
                                    'cadre' => $json_decoded_data['Cadre'],
                                    'month' => "$process_month", 
                                    'year'=> "$process_year", 
                                    'deduction_stdate_time'=> $midtime, 
                                    'deduction_etdate_time' => $newvalue['shift_enddatetime'],
                                    'partial_days' => 'second_half',
                                    'type' => 'LATE',
                                    'punchlist' => $punchlist,
                                    'lms_applications' => $lmsapp,
                                    'first_half_lop' => $newvalue['first_half_lop'],
                                    'second_half_lop' => $newvalue['second_half_lop'],
                                    'latecount' => $newvalue['latecount'],
                                    'latein_hours' => $newvalue['latein_hours'],
                                    'laterange1' => $newvalue['laterange1'],
                                    'laterange2' => $newvalue['laterange2'],
                                    'laterange3' => $newvalue['laterange3'],
                                    'earlyoutcount' => $newvalue['earlyoutcount'],
                                    'earlyout_hours' => $newvalue['earlyout_hours'],
                                    'absent' => $newvalue['absent'],
                                    'present' => $newvalue['present'],
                                    'first_half_considered_punches' => $first_half_considered_punches_list,
                                    'sento_sap' => $sentosap,
                                    'sento_sapdate' => Carbon::now()->toDateTimeString()
                                     ]);
                             }
                             else{
                                $getready_process =  DB::connection('mysql6')->table('latededuction_finaltosap')->where(
                                    ['employeeid' => $employeeid ,
                                    'month' => "$process_month", 
                                    'year'=> "$process_year", 
                                    'deduction_stdate_time'=> $midtime, 
                                    'deduction_etdate_time' => $newvalue['shift_enddatetime'],
                                    'partial_days' => 'second_half',
                                    'type' => 'LATE']
                                )->update([
                                    'sento_sap' => $sentosap,
                                    'sento_sapdate' => Carbon::now()->toDateTimeString()
                                ]);
                             }

                           
                        }
                    }
                    elseif((($newvalue['first_half_lop'] == 0) || ($newvalue['second_half_lop'] == 0)) && ($newvalue['absent'] == 1))
                    {                        
                        $checkprev = DB::connection('mysql6')->table('latededuction_finaltosap')->where([
                            'employeeid' => $employeeid ,
                        'month' => "$process_month", 
                        'year'=> "$process_year", 
                        'deduction_stdate_time'=> $newvalue['shift_startdatetime'], 
                        'deduction_etdate_time' => $newvalue['shift_enddatetime'],
                        'partial_days' => 'full',
                        'type' => 'LOP'
                             ])->count();
                             $lop += 1;

                        $explodetime1 = explode(' ', $newvalue['shift_startdatetime']);
                        $explodetime2 = explode(' ', $newvalue['shift_enddatetime']);
                        $arr = [
                            'employeeid' => $employeeid,
                            "from_date"=> substr($newvalue['shift_startdatetime'],0,10),
                            "to_date"=> substr($newvalue['shift_startdatetime'],0,10),
                            "leave_type"=> 'LOP',
                            "starttime"=> '',
                            "endtime"=> ''
                         ];
                        
                         $sentosap = 'Y';
                         $lates[] = $arr;
                             Log::info('SAP LOP deduction sap error... '.$employeeid);
                       

                        if($checkprev == 0){

                        $getready_process =  DB::connection('mysql6')->table('latededuction_finaltosap')
                        ->insert([
                            'employeeid' => $employeeid ,
                            'emp_name' => $json_decoded_data['Emp_Name'],
                            'role_code' => $json_decoded_data['Role_Code'],
                            'plant_code' => $json_decoded_data['Plant_Code'],
                            'position' => $json_decoded_data['Position'],
                            'department' => $json_decoded_data['Department'],
                            'cadre' => $json_decoded_data['Cadre'],
                            'month' => "$process_month", 
                            'year'=> "$process_year", 
                            'deduction_stdate_time'=> $newvalue['shift_startdatetime'], 
                            'deduction_etdate_time' => $newvalue['shift_enddatetime'],
                            'partial_days' => 'full',
                            'type' => 'LOP',
                            'punchlist' => $punchlist,
                            'lms_applications' => $lmsapp,
                            'first_half_lop' => $newvalue['first_half_lop'],
                            'second_half_lop' => $newvalue['second_half_lop'],
                            'latecount' => $newvalue['latecount'],
                            'latein_hours' => $newvalue['latein_hours'],
                            'laterange1' => $newvalue['laterange1'],
                            'laterange2' => $newvalue['laterange2'],
                            'laterange3' => $newvalue['laterange3'],
                            'earlyoutcount' => $newvalue['earlyoutcount'],
                            'earlyout_hours' => $newvalue['earlyout_hours'],
                            'absent' => $newvalue['absent'],
                            'present' => $newvalue['present'],
                            'first_half_considered_punches' => $first_half_considered_punches_list,
                            'sento_sap' => $sentosap,
                            'sento_sapdate' => Carbon::now()->toDateTimeString()
                             ]);
                        }else{
                            $getready_process =  DB::connection('mysql6')->table('latededuction_finaltosap')->where(
                                [
                                    'employeeid' => $employeeid ,
                                    'month' => "$process_month", 
                                    'year'=> "$process_year", 
                                    'deduction_stdate_time'=> $newvalue['shift_startdatetime'], 
                                    'deduction_etdate_time' => $newvalue['shift_enddatetime'],
                                    'partial_days' => 'full',
                                    'type' => 'LOP'
                                ]
                            )->update([
                                'sento_sap' => $sentosap,
                                'sento_sapdate' => Carbon::now()->toDateTimeString()
                            ]);
                        }
                    }
                    elseif((($newvalue['first_half_lop'] == 0) || ($newvalue['second_half_lop'] == 0)) && ($newvalue['absent'] == 0.5))
                    {
                        $starttime1 = $newvalue['shift_startdatetime'];
                        $endtime1 = $newvalue['shift_enddatetime'];
                        $partial_days1 = 'first_half';

                        $getapplop = DB::connection('mysql6')->table('datetime_ref')->where(['employeeid' => $employeeid ,'month' => "$process_month",'year'=> "$process_year",'date'=>$newvalue['shift_date'],'type' => 'LOP'])->get();
                                if(count($getapplop) > 0){
                                    foreach ($getapplop as $lkey => $lvalue) {
                                        $partial_half = $lvalue->partial_days;
                                    }

                                    if($partial_half == 'first_half'){
                                        $starttime1 = $newvalue['shift_startdatetime'];
                                        $endtime1 = $midtime;
                                        $partial_days1 = 'first_half';
                                        $lop += 0.5;
                                    }
                                    if($partial_half == 'second_half'){
                                        $starttime1 = $midtime;
                                        $endtime1 = $newvalue['shift_enddatetime'];
                                        $partial_days1 = 'second_half';
                                        $lop += 0.5;
                                    }

                            }

                        $checkprev = DB::connection('mysql6')->table('latededuction_finaltosap')->where([
                            'employeeid' => $employeeid ,
                        'month' => "$process_month", 
                        'year'=> "$process_year", 
                        'deduction_stdate_time'=> $starttime1, 
                        'deduction_etdate_time' => $endtime1,
                        'partial_days' => $partial_days1,
                        'type' => 'LOP'
                             ])->count();

                        $explodetime1 = explode(' ', $starttime1);
                        $explodetime2 = explode(' ', $endtime1);
                        $arr = [
                            'employeeid' => $employeeid,
                            "from_date"=> substr($starttime1,0,10),
                            "to_date"=> substr($endtime1,0,10),
                            "leave_type"=> 'LOP',
                            "starttime"=> substr($explodetime1[1],0,5),
                            "endtime"=> substr($explodetime2[1],0,5)
                         ];
                        
                         $sentosap = 'Y';
                         $lates[] = $arr;
                        Log::info('SAP LOP deduction sap error... '.$employeeid);
                       

                        if($checkprev == 0){

                        $getready_process =  DB::connection('mysql6')->table('latededuction_finaltosap')
                        ->insert([
                            'employeeid' => $employeeid ,
                            'emp_name' => $json_decoded_data['Emp_Name'],
                            'role_code' => $json_decoded_data['Role_Code'],
                            'plant_code' => $json_decoded_data['Plant_Code'],
                            'position' => $json_decoded_data['Position'],
                            'department' => $json_decoded_data['Department'],
                            'cadre' => $json_decoded_data['Cadre'],
                            'month' => "$process_month", 
                            'year'=> "$process_year", 
                            'deduction_stdate_time'=> $starttime1, 
                            'deduction_etdate_time' => $endtime1,
                            'partial_days' => $partial_days1,
                            'type' => 'LOP',
                            'punchlist' => $punchlist,
                            'lms_applications' => $lmsapp,
                            'first_half_lop' => $newvalue['first_half_lop'],
                            'second_half_lop' => $newvalue['second_half_lop'],
                            'latecount' => $newvalue['latecount'],
                            'latein_hours' => $newvalue['latein_hours'],
                            'laterange1' => $newvalue['laterange1'],
                            'laterange2' => $newvalue['laterange2'],
                            'laterange3' => $newvalue['laterange3'],
                            'earlyoutcount' => $newvalue['earlyoutcount'],
                            'earlyout_hours' => $newvalue['earlyout_hours'],
                            'absent' => $newvalue['absent'],
                            'present' => $newvalue['present'],
                            'first_half_considered_punches' => $first_half_considered_punches_list,
                            'sento_sap' => $sentosap,
                            'sento_sapdate' => Carbon::now()->toDateTimeString()
                             ]);
                        }else{
                            $getready_process =  DB::connection('mysql6')->table('latededuction_finaltosap')->where(
                                [
                                    'employeeid' => $employeeid ,
                                    'month' => "$process_month", 
                                    'year'=> "$process_year", 
                                    'deduction_stdate_time'=> $starttime1, 
                                    'deduction_etdate_time' => $endtime1,
                                    'partial_days' => $partial_days1,
                                    'type' => 'LOP'
                                ]
                            )->update([
                                'sento_sap' => $sentosap,
                                'sento_sapdate' => Carbon::now()->toDateTimeString()
                            ]);
                        }
                    }
                    elseif((($newvalue['first_half_lop'] != 0) || ($newvalue['second_half_lop'] != 0)) && ($newvalue['absent'] != 0)){
                        $checkfirsthalf_lop = DB::connection('mysql6')->table('datetime_ref')->where(['employeeid' => $employeeid ,'month' => "$process_month",'year'=> "$process_year",'date'=>$newvalue['shift_date'],'partial_days'=>'first_half','type' => 'LOP'])->get();
                        $checksecondhalf_lop = DB::connection('mysql6')->table('datetime_ref')->where(['employeeid' => $employeeid ,'month' => "$process_month",'year'=> "$process_year",'date'=>$newvalue['shift_date'],'partial_days'=>'second_half','type' => 'LOP'])->get();

                        if((count($checkfirsthalf_lop) > 0) && (count($checksecondhalf_lop) > 0)){                           

                        $checkprev = DB::connection('mysql6')->table('latededuction_finaltosap')->where([
                        'employeeid' => $employeeid ,
                        'month' => "$process_month", 
                        'year'=> "$process_year", 
                        'deduction_stdate_time'=> $newvalue['shift_startdatetime'], 
                        'deduction_etdate_time' => $newvalue['shift_enddatetime'],
                        'partial_days' => 'full',
                        'type' => 'LOP'
                             ])->count();
                             $lop += 1;
                        $explodetime1 = explode(' ', $newvalue['shift_startdatetime']);
                        $explodetime2 = explode(' ', $newvalue['shift_enddatetime']);
                        $arr = [
                            'employeeid' => $employeeid,
                            "from_date"=> substr($newvalue['shift_startdatetime'],0,10),
                            "to_date"=> substr($newvalue['shift_startdatetime'],0,10),
                            "leave_type"=> 'LOP',
                            "starttime"=> '',
                            "endtime"=> ''
                         ];
                        
                         $sentosap = 'Y';
                         $lates[] = $arr;
                        Log::info('SAP LOP deduction sap error... '.$employeeid);
                        

                        if($checkprev == 0){

                        $getready_process =  DB::connection('mysql6')->table('latededuction_finaltosap')
                        ->insert([
                            'employeeid' => $employeeid ,
                            'emp_name' => $json_decoded_data['Emp_Name'],
                            'role_code' => $json_decoded_data['Role_Code'],
                            'plant_code' => $json_decoded_data['Plant_Code'],
                            'position' => $json_decoded_data['Position'],
                            'department' => $json_decoded_data['Department'],
                            'cadre' => $json_decoded_data['Cadre'],
                            'month' => "$process_month", 
                            'year'=> "$process_year", 
                            'deduction_stdate_time'=> $newvalue['shift_startdatetime'], 
                            'deduction_etdate_time' => $newvalue['shift_enddatetime'],
                            'partial_days' => 'full',
                            'type' => 'LOP',
                            'punchlist' => $punchlist,
                            'lms_applications' => $lmsapp,
                            'first_half_lop' => $newvalue['first_half_lop'],
                            'second_half_lop' => $newvalue['second_half_lop'],
                            'latecount' => $newvalue['latecount'],
                            'latein_hours' => $newvalue['latein_hours'],
                            'laterange1' => $newvalue['laterange1'],
                            'laterange2' => $newvalue['laterange2'],
                            'laterange3' => $newvalue['laterange3'],
                            'earlyoutcount' => $newvalue['earlyoutcount'],
                            'earlyout_hours' => $newvalue['earlyout_hours'],
                            'absent' => $newvalue['absent'],
                            'present' => $newvalue['present'],
                            'first_half_considered_punches' => $first_half_considered_punches_list,
                            'sento_sap' => $sentosap,
                            'sento_sapdate' => Carbon::now()->toDateTimeString()
                             ]);
                        }else{
                            $getready_process =  DB::connection('mysql6')->table('latededuction_finaltosap')->where(
                                [
                                    'employeeid' => $employeeid ,
                                    'month' => "$process_month", 
                                    'year'=> "$process_year", 
                                    'deduction_stdate_time'=> $newvalue['shift_startdatetime'], 
                                    'deduction_etdate_time' => $newvalue['shift_enddatetime'],
                                    'partial_days' => 'full',
                                    'type' => 'LOP'
                                ]
                            )->update([
                                'sento_sap' => $sentosap,
                                'sento_sapdate' => Carbon::now()->toDateTimeString()
                            ]);
                        }
                        
                        }
                        elseif((count($checkfirsthalf_lop) == 0) && (count($checksecondhalf_lop) > 0)){

                            $starttime1 = $newvalue['shift_startdatetime'];
                            $endtime1 = $newvalue['shift_enddatetime'];
                            $partial_days1 = 'first_half';
    
                            $getapplop = DB::connection('mysql6')->table('datetime_ref')->where(['employeeid' => $employeeid ,'month' => "$process_month",'year'=> "$process_year",'date'=>$newvalue['shift_date'],'type' => 'LOP'])->get();
                                    if(count($getapplop) > 0){
                                        foreach ($getapplop as $lkey => $lvalue) {
                                            $partial_half = $lvalue->partial_days;
                                        }
    
                                        if($partial_half == 'second_half'){
                                            $starttime1 = $midtime;
                                            $endtime1 = $newvalue['shift_enddatetime'];
                                            $partial_days1 = 'second_half';
                                            $lop += 0.5;

                                            //start
                                            $checkprev1 = DB::connection('mysql6')->table('latededuction_finaltosap')->where([
                                                'employeeid' => $employeeid ,
                                            'month' => "$process_month", 
                                            'year'=> "$process_year", 
                                            'deduction_stdate_time'=> $starttime1, 
                                            'deduction_etdate_time' => $endtime1,
                                            'partial_days' => $partial_days1,
                                            'type' => 'LOP'
                                                 ])->count();
                    
                                            $explodetime1 = explode(' ', $starttime1);
                                            $explodetime2 = explode(' ', $endtime1);
                                            $arr = [
                                                'employeeid' => $employeeid,
                                                "from_date"=> substr($starttime1,0,10),
                                                "to_date"=> substr($endtime1,0,10),
                                                "leave_type"=> 'LOP',
                                                "starttime"=> substr($explodetime1[1],0,5),
                                                "endtime"=> substr($explodetime2[1],0,5)
                                             ];
                                            
                                             $sentosap = 'Y';
                                             $lates[] = $arr;
                             Log::info('SAP LOP deduction sap error... '.$employeeid);
                                            
                    
                                            if($checkprev1 == 0){
                    
                                            $getready_process1 =  DB::connection('mysql6')->table('latededuction_finaltosap')
                                            ->insert([
                                                'employeeid' => $employeeid ,
                                                'emp_name' => $json_decoded_data['Emp_Name'],
                                                'role_code' => $json_decoded_data['Role_Code'],
                                                'plant_code' => $json_decoded_data['Plant_Code'],
                                                'position' => $json_decoded_data['Position'],
                                                'department' => $json_decoded_data['Department'],
                                                'cadre' => $json_decoded_data['Cadre'],
                                                'month' => "$process_month", 
                                                'year'=> "$process_year", 
                                                'deduction_stdate_time'=> $starttime1, 
                                                'deduction_etdate_time' => $endtime1,
                                                'partial_days' => $partial_days1,
                                                'type' => 'LOP',
                                                'punchlist' => $punchlist,
                                                'lms_applications' => $lmsapp,
                                                'first_half_lop' => $newvalue['first_half_lop'],
                                                'second_half_lop' => $newvalue['second_half_lop'],
                                                'latecount' => $newvalue['latecount'],
                                                'latein_hours' => $newvalue['latein_hours'],
                                                'laterange1' => $newvalue['laterange1'],
                                                'laterange2' => $newvalue['laterange2'],
                                                'laterange3' => $newvalue['laterange3'],
                                                'earlyoutcount' => $newvalue['earlyoutcount'],
                                                'earlyout_hours' => $newvalue['earlyout_hours'],
                                                'absent' => $newvalue['absent'],
                                                'present' => $newvalue['present'],
                                                'first_half_considered_punches' => $first_half_considered_punches_list,
                                                'sento_sap' => $sentosap,
                                                'sento_sapdate' => Carbon::now()->toDateTimeString()
                                                 ]);
                                            }else{
                                                $getready_process1 =  DB::connection('mysql6')->table('latededuction_finaltosap')->where(
                                                    [
                                                        'employeeid' => $employeeid ,
                                                        'month' => "$process_month", 
                                                        'year'=> "$process_year", 
                                                        'deduction_stdate_time'=> $starttime1, 
                                                        'deduction_etdate_time' => $endtime1,
                                                        'partial_days' => $partial_days1,
                                                        'type' => 'LOP'
                                                    ]
                                                )->update([
                                                    'sento_sap' => $sentosap,
                                                    'sento_sapdate' => Carbon::now()->toDateTimeString()
                                                ]);
                                            }
                                            //end



                                        }
    
                                }
                            
                            if($newvalue['first_half_lop'] == 0.5){


                                $checkprev = DB::connection('mysql6')->table('latededuction_finaltosap')->where([
                                    'employeeid' => $employeeid ,
                                'month' => "$process_month", 
                                'year'=> "$process_year", 
                                'deduction_stdate_time'=> $newvalue['shift_startdatetime'], 
                                'deduction_etdate_time' => $midtime,
                                'partial_days' => 'first_half',
                                'type' => 'LATE'
                                     ])->count();
    
                                $explodetime1 = explode(' ', $newvalue['shift_startdatetime']);
                                $explodetime2 = explode(' ', $midtime);
                                $arr = [
                                    'employeeid' => $employeeid,
                                    "from_date"=> substr($newvalue['shift_startdatetime'],0,10),
                                    "to_date"=> substr($midtime,0,10),
                                    "leave_type"=> 'LATE',
                                    "starttime"=> substr($explodetime1[1],0,5),
                                    "endtime"=> substr($explodetime2[1],0,5)
                                 ];
                                
                                 $sentosap = 'Y';
                                 $lates[] = $arr;
                             Log::info('SAP LATE deduction sap error... '.$employeeid);
                                    
                                 if($checkprev == 0){
    
                                $getready_process =  DB::connection('mysql6')->table('latededuction_finaltosap')
                            ->insert([
                                'employeeid' => $employeeid ,
                                'emp_name' => $json_decoded_data['Emp_Name'],
                                'role_code' => $json_decoded_data['Role_Code'],
                                'plant_code' => $json_decoded_data['Plant_Code'],
                                'position' => $json_decoded_data['Position'],
                                'department' => $json_decoded_data['Department'],
                                'cadre' => $json_decoded_data['Cadre'],
                                'month' => "$process_month", 
                                'year'=> "$process_year", 
                                'deduction_stdate_time'=> $newvalue['shift_startdatetime'], 
                                'deduction_etdate_time' => $midtime,
                                'partial_days' => 'first_half',
                                'type' => 'LATE',
                                'punchlist' => $punchlist,
                                'lms_applications' => $lmsapp,
                                'first_half_lop' => $newvalue['first_half_lop'],
                                'second_half_lop' => $newvalue['second_half_lop'],
                                'latecount' => $newvalue['latecount'],
                                'latein_hours' => $newvalue['latein_hours'],
                                'laterange1' => $newvalue['laterange1'],
                                'laterange2' => $newvalue['laterange2'],
                                'laterange3' => $newvalue['laterange3'],
                                'earlyoutcount' => $newvalue['earlyoutcount'],
                                'earlyout_hours' => $newvalue['earlyout_hours'],
                                'absent' => $newvalue['absent'],
                                'present' => $newvalue['present'],
                                'first_half_considered_punches' => $first_half_considered_punches_list,
                                'sento_sap' => $sentosap,
                                'sento_sapdate' => Carbon::now()->toDateTimeString()
                                 ]);
    
                                }
                                else
                                {
                                    $getready_process =  DB::connection('mysql6')->table('latededuction_finaltosap')->where(
                                        ['employeeid' => $employeeid ,
                                        'month' => "$process_month", 
                                        'year'=> "$process_year", 
                                        'deduction_stdate_time'=> $newvalue['shift_startdatetime'], 
                                        'deduction_etdate_time' => $midtime,
                                        'partial_days' => 'first_half',
                                        'type' => 'LATE']
                                    )->update([
                                        'sento_sap' => $sentosap,
                                        'sento_sapdate' => Carbon::now()->toDateTimeString()
                                    ]);
    
                                }
                                
                            }


                        }
                        elseif((count($checkfirsthalf_lop) > 0) && (count($checksecondhalf_lop) == 0)){

                            $starttime1 = $newvalue['shift_startdatetime'];
                            $endtime1 = $newvalue['shift_enddatetime'];
                            $partial_days1 = 'first_half';
    
                            $getapplop = DB::connection('mysql6')->table('datetime_ref')->where(['employeeid' => $employeeid ,'month' => "$process_month",'year'=> "$process_year",'date'=>$newvalue['shift_date'],'type' => 'LOP'])->get();
                                    if(count($getapplop) > 0){
                                        foreach ($getapplop as $lkey => $lvalue) {
                                            $partial_half = $lvalue->partial_days;
                                        }
    
                                        if($partial_half == 'first_half'){
                                            $starttime1 = $newvalue['shift_startdatetime'];
                                            $endtime1 = $midtime;
                                            $partial_days1 = 'first_half';
                                            $lop += 0.5;

                                            //start
                                            $checkprev1 = DB::connection('mysql6')->table('latededuction_finaltosap')->where([
                                                'employeeid' => $employeeid ,
                                            'month' => "$process_month", 
                                            'year'=> "$process_year", 
                                            'deduction_stdate_time'=> $starttime1, 
                                            'deduction_etdate_time' => $endtime1,
                                            'partial_days' => $partial_days1,
                                            'type' => 'LOP'
                                                 ])->count();
                    
                                            $explodetime1 = explode(' ', $starttime1);
                                            $explodetime2 = explode(' ', $endtime1);
                                            $arr = [
                                                'employeeid' => $employeeid,
                                                "from_date"=> substr($starttime1,0,10),
                                                "to_date"=> substr($endtime1,0,10),
                                                "leave_type"=> 'LOP',
                                                "starttime"=> substr($explodetime1[1],0,5),
                                                "endtime"=> substr($explodetime2[1],0,5)
                                             ];
                                            
                                             $sentosap = 'Y';
                                             $lates[] = $arr;
                             Log::info('SAP LOP deduction sap error... '.$employeeid);
                    
                                            if($checkprev1 == 0){
                    
                                            $getready_process1 =  DB::connection('mysql6')->table('latededuction_finaltosap')
                                            ->insert([
                                                'employeeid' => $employeeid ,
                                                'emp_name' => $json_decoded_data['Emp_Name'],
                                                'role_code' => $json_decoded_data['Role_Code'],
                                                'plant_code' => $json_decoded_data['Plant_Code'],
                                                'position' => $json_decoded_data['Position'],
                                                'department' => $json_decoded_data['Department'],
                                                'cadre' => $json_decoded_data['Cadre'],
                                                'month' => "$process_month", 
                                                'year'=> "$process_year", 
                                                'deduction_stdate_time'=> $starttime1, 
                                                'deduction_etdate_time' => $endtime1,
                                                'partial_days' => $partial_days1,
                                                'type' => 'LOP',
                                                'punchlist' => $punchlist,
                                                'lms_applications' => $lmsapp,
                                                'first_half_lop' => $newvalue['first_half_lop'],
                                                'second_half_lop' => $newvalue['second_half_lop'],
                                                'latecount' => $newvalue['latecount'],
                                                'latein_hours' => $newvalue['latein_hours'],
                                                'laterange1' => $newvalue['laterange1'],
                                                'laterange2' => $newvalue['laterange2'],
                                                'laterange3' => $newvalue['laterange3'],
                                                'earlyoutcount' => $newvalue['earlyoutcount'],
                                                'earlyout_hours' => $newvalue['earlyout_hours'],
                                                'absent' => $newvalue['absent'],
                                                'present' => $newvalue['present'],
                                                'first_half_considered_punches' => $first_half_considered_punches_list,
                                                'sento_sap' => $sentosap,
                                                'sento_sapdate' => Carbon::now()->toDateTimeString()
                                                 ]);
                                            }else{
                                                $getready_process1 =  DB::connection('mysql6')->table('latededuction_finaltosap')->where(
                                                    [
                                                        'employeeid' => $employeeid ,
                                                        'month' => "$process_month", 
                                                        'year'=> "$process_year", 
                                                        'deduction_stdate_time'=> $starttime1, 
                                                        'deduction_etdate_time' => $endtime1,
                                                        'partial_days' => $partial_days1,
                                                        'type' => 'LOP'
                                                    ]
                                                )->update([
                                                    'sento_sap' => $sentosap,
                                                    'sento_sapdate' => Carbon::now()->toDateTimeString()
                                                ]);
                                            }
                                            //end



                                        }
    
                                }

                            if($newvalue['second_half_lop'] == 0.5){
                                
                                $checkprev = DB::connection('mysql6')->table('latededuction_finaltosap')->where([
                                    'employeeid' => $employeeid ,
                                'month' => "$process_month", 
                                'year'=> "$process_year", 
                                'deduction_stdate_time'=> $midtime, 
                                'deduction_etdate_time' => $newvalue['shift_enddatetime'],
                                'partial_days' => 'second_half',
                                'type' => 'LATE'
                                     ])->count();
                                     
                                $explodetime1 = explode(' ', $midtime);
                                $explodetime2 = explode(' ', $newvalue['shift_enddatetime']);
                                $arr = [
                                    'employeeid' => $employeeid,
                                    "from_date"=> substr($midtime,0,10),
                                    "to_date"=> substr($newvalue['shift_enddatetime'],0,10),
                                    "leave_type"=> 'LATE',
                                    "starttime"=> substr($explodetime1[1],0,5),
                                    "endtime"=> substr($explodetime2[1],0,5)
                                 ];
                                
                                 $sentosap = 'Y';
                                 $lates[] = $arr;
                             Log::info('SAP LATE deduction sap error... '.$employeeid);
                                    
                                 if($checkprev == 0){
                                    $getready_process =  DB::connection('mysql6')->table('latededuction_finaltosap')
                                    ->insert([
                                        'employeeid' => $employeeid ,
                                        'emp_name' => $json_decoded_data['Emp_Name'],
                                        'role_code' => $json_decoded_data['Role_Code'],
                                        'plant_code' => $json_decoded_data['Plant_Code'],
                                        'position' => $json_decoded_data['Position'],
                                        'department' => $json_decoded_data['Department'],
                                        'cadre' => $json_decoded_data['Cadre'],
                                        'month' => "$process_month", 
                                        'year'=> "$process_year", 
                                        'deduction_stdate_time'=> $midtime, 
                                        'deduction_etdate_time' => $newvalue['shift_enddatetime'],
                                        'partial_days' => 'second_half',
                                        'type' => 'LATE',
                                        'punchlist' => $punchlist,
                                        'lms_applications' => $lmsapp,
                                        'first_half_lop' => $newvalue['first_half_lop'],
                                        'second_half_lop' => $newvalue['second_half_lop'],
                                        'latecount' => $newvalue['latecount'],
                                        'latein_hours' => $newvalue['latein_hours'],
                                        'laterange1' => $newvalue['laterange1'],
                                        'laterange2' => $newvalue['laterange2'],
                                        'laterange3' => $newvalue['laterange3'],
                                        'earlyoutcount' => $newvalue['earlyoutcount'],
                                        'earlyout_hours' => $newvalue['earlyout_hours'],
                                        'absent' => $newvalue['absent'],
                                        'present' => $newvalue['present'],
                                        'first_half_considered_punches' => $first_half_considered_punches_list,
                                        'sento_sap' => $sentosap,
                                        'sento_sapdate' => Carbon::now()->toDateTimeString()
                                         ]);
                                 }
                                 else{
                                    $getready_process =  DB::connection('mysql6')->table('latededuction_finaltosap')->where(
                                        ['employeeid' => $employeeid ,
                                        'month' => "$process_month", 
                                        'year'=> "$process_year", 
                                        'deduction_stdate_time'=> $midtime, 
                                        'deduction_etdate_time' => $newvalue['shift_enddatetime'],
                                        'partial_days' => 'second_half',
                                        'type' => 'LATE']
                                    )->update([
                                        'sento_sap' => $sentosap,
                                        'sento_sapdate' => Carbon::now()->toDateTimeString()
                                    ]);
                                 }
    
                               
                            }
                        }
                        else{

                        }
                        
                    }
                    else{

                    }
                }
                //ended
                DB::connection('mysql6')->table('leave_balance')->where([
                    'employeeid' => $employeeid, 'month' => $process_month, 'year' =>$process_year
                ])->update([
                    'LOP' => $lop,
                    'Present' => $present,
                    'Absent' => $absent,
                    'late_count' => $latecount,
                    'early_out_count' => $earlyoutcount,
                    'completed' => 'Y'
                ]);

                //send to sap one shot
            $getinserteddata =  DB::connection('mysql6')->table('leave_balance')->where(['employeeid' =>$employeeid ,'month' => "$process_month", 'year'=> "$process_year" ])->get();
            $arr = [];
            if(count($getinserteddata) > 0){
                $arr = [];
                    if($getinserteddata[0]->Onduty == null){ $getinserteddata[0]->Onduty = ''; }
                    if($getinserteddata[0]->Tour == null){ $getinserteddata[0]->Tour = ''; }
                    if($getinserteddata[0]->Compoff == null){ $getinserteddata[0]->Compoff = ''; }
                    if($getinserteddata[0]->Mispunch == null){ $getinserteddata[0]->Mispunch = ''; }
                    
                    $arr['Leave_Details'] = [ "Employee_ID"=> $getinserteddata[0]->employeeid,
		"Month"=> $getinserteddata[0]->month,
		"Year"=> $getinserteddata[0]->year,
		"CL"=> $getinserteddata[0]->CL,
		"SL"=> $getinserteddata[0]->SL,
		"PL"=> $getinserteddata[0]->PL,
		"ML"=> $getinserteddata[0]->ML,
		"RH"=> $getinserteddata[0]->RH,
		"Permission"=> $getinserteddata[0]->Permission,
		"OnDuty"=> $getinserteddata[0]->Onduty,
		"Tour"=> $getinserteddata[0]->Tour,
		"Comp_Off"=> $getinserteddata[0]->Compoff,
		"Miss_Punch"=> $getinserteddata[0]->Mispunch,
		"Present"=> $getinserteddata[0]->Present,
		"LOP"=> $getinserteddata[0]->LOP,
		"Absent"=> $getinserteddata[0]->Absent,
		"Late_Count"=> $getinserteddata[0]->late_count,
		"Total_Late_Hours"=> $getinserteddata[0]->total_late_hours,
		"Early_Out_Count"=> $getinserteddata[0]->early_out_count,
		"Total_Early_Out_Hours"=>$getinserteddata[0]->total_early_out_hours,
        "Completed"=> 'N' ];
                $bulkinsert = $this->bulkinsertleave_balance($arr);
            }
                

                // DB::connection('mysql6')->table('lateacrual_process')->where(['employeeid' => $employeeid, 'month' => "$process_month", 'year' =>"$process_year"  ])->update([
                //     'processed' => 'Y',
                //     'last_processed_date' => Carbon::now()->toDateTimeString()
                // ]);
            
                } 
        }

                //script end
                //return $requestdata;

                if(count($payrolldata) != 0){
                    $request->session()->forget('payrollprocess_session');
                    unset($payrolldata[$request->recordkey][$requestdata[0]['Emp_ID']]);
                    $request->session()->put('payrollprocess_session', $payrolldata);
                }
                else{
                    $request->session()->forget('payrollprocess_session');
                }

                if(count($lates) > 0)
                {
                    //return $requestdata;
                    $lattable_process =  DB::connection('mysql6')->table('lateacrual_process')->where(['employeeid'=>$requestdata[0]['Emp_ID'], 'month' => $process_month, 'year'=> $process_year ])->get();
			
                    if (count($lattable_process) == 0) {
                        //echo 'Feeding Employee - '.$requestdata[0]['Emp_ID'].' , Name - '.$requestdata[0]['Emp_Name'].'<br>';
                        DB::connection('mysql6')->table('lateacrual_process')->insert(
                            ['employeeid'=>$requestdata[0]['Emp_ID'],
                             'emp_name' => $requestdata[0]['Emp_Name'],
                             'role_code' => $requestdata[0]['Role_Code'],
                             'plant_code' => $requestdata[0]['Plant_Code'],
                             'position' => $requestdata[0]['Position'],
                             'department' => $requestdata[0]['Department'],
                             'cadre' => $requestdata[0]['Cadre'],
                             'doj' => $requestdata[0]['DOJ'],
                             'month' => $process_month,
                             'year'=>$process_year,                     
                             'active_details' => json_encode($requestdata[0]),
                             'processed'=>'Y',
                             'last_processed_date' => Carbon::now()->toDateTimeString()
                              ]);    
                    }
                    else{
                       // echo 'Feeding Employee - '.$requestdata[0]['Emp_ID'].' , Name - '.$requestdata[0]['Emp_Name'].'<br>';
                        DB::connection('mysql6')->table('lateacrual_process')->where(['employeeid'=>$requestdata[0]['Emp_ID'], 'month' => $process_month, 'year'=> $process_year ])->update(
                            ['employeeid'=>$requestdata[0]['Emp_ID'],
                             'emp_name' => $requestdata[0]['Emp_Name'],
                             'role_code' => $requestdata[0]['Role_Code'],
                             'plant_code' => $requestdata[0]['Plant_Code'],
                             'position' => $requestdata[0]['Position'],
                             'department' => $requestdata[0]['Department'],
                             'cadre' => $requestdata[0]['Cadre'],
                             'doj' => $requestdata[0]['DOJ'],
                             'month' => $process_month,
                             'year'=>$process_year,                     
                             'active_details' => json_encode($requestdata[0]),
                             'processed'=>'Y',
                             'last_processed_date' => Carbon::now()->toDateTimeString()
                              ]);    
                    }
                Log::info(Carbon::now()->toDateTimeString());
                foreach ($lates as $keylate => $valuelate) {
                    Log::info('---------------start-------');
                    $is_updated_in_sap = $this->deduct_leave_forlate($valuelate);
                    if ($is_updated_in_sap['Status'] == 'Updated Successfully') {
                        Log::info('SAP Late deduction sap updated successfully... - '.$employeeid);
                    }
                    else{
                        Log::info('SAP Late deduction sap error... '.$employeeid.' - Status: '.$is_updated_in_sap['Status']);
                         //$sentosap = 'N';
                     }
                     Log::info('---------------end-------');
                }
                Log::info(Carbon::now()->toDateTimeString());
            }
               
        return 1;
        

    }


    public function sendapprovedappltosapviaportal(Request $request)
    {
        if (session()->has('employeesession')) {
            $encrypt = session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $remployeeid = $split[0];

            if (in_array($remployeeid, config('newlmsconfig'))) {

               $requestedmonthyear = $request->monthyear;
               $requestedcompany = $request->company;

               $explodemonthyear = explode('/', $requestedmonthyear);
               $month = $explodemonthyear[0];
               $year = $explodemonthyear[1];

               if ($requestedcompany == 4000) {
                   $starts_empid = "10";
               }
               elseif ($requestedcompany == 5000) {
                   $starts_empid = "20";
               }
               elseif ($requestedcompany == 7200) {
                $starts_empid = "70";
                }
               elseif ($requestedcompany == 6300) {
                $starts_empid = "60";
                }
               else{
                $starts_empid = "10";
               }

               $now = Carbon::now();
               $prevstartmonthcheck = $now->subMonth();
               $requestedcheckformat = Carbon::parse($year.'-'.$month.'-01')->toDateString();
               $add10days = Carbon::parse($requestedcheckformat)->addDays(10);
               if (Carbon::parse($now)->gt(Carbon::parse($add10days))) {
                   return 11;
               }

               
               if($prevstartmonthcheck->startOfMonth()->format('Y-m-d') != $requestedcheckformat){
                   return 11;
               }

               $data = DB::connection('mysql6')->table('leave_processed')->where(['month' => $month, 'year' => $year, 'final_status' => 'Approved'])->where('employeeid', 'LIKE', $starts_empid.'%')->get();
               
               if ($request->session()->has('approvedapplprocess_session')) {
                   
                $approveddata = $request->session()->get('approvedapplprocess_session');
                if($approveddata != $starts_empid){
                    $request->session()->forget('approvedapplprocess_session');
                    $listtoaddinsession = [];

               foreach ($data as $key => $value) {
                   if(substr($value->employeeid,0,2) == $starts_empid){
                    $listtoaddinsession[$starts_empid][$value->employeeid][] = $value;
                    
                   }
               }

                $request->session()->put('approvedapplprocess_session', $listtoaddinsession);
                return json_encode($listtoaddinsession);
                }

                return json_encode($approveddata);
               }
               else{
               $listtoaddinsession = [];
                
               foreach ($data as $key => $value) {
                  
                   if(substr($value->employeeid,0,2) == $starts_empid){
                    $listtoaddinsession[$starts_empid][$value->employeeid][] = $value;
                    
                   }
               }

               $request->session()->put('approvedapplprocess_session', $listtoaddinsession);
               return json_encode($listtoaddinsession);
            }


              // return json_encode($data);

            }
        }
    }

    public function sendapprovedapplicationsprocess(Request $request)
    {
        Log::info('Request received to insert approved application...');
        Log::info(Carbon::now()->toDateTimeString());
        $requestdata = $request->recordstoprocess;

        if(session()->has('approvedapplprocess_session'))
        {
            $approveddata = session()->get('approvedapplprocess_session');       
        }
        else{
            return 0;
        }
        //return $approveddata;
        //$getlms_application = DB::connection('mysql6')->table('leave_processed')->where(['final_status' => 'Approved'])->get();
                
            if (count($requestdata) > 0) {
              

                foreach ($requestdata as $key26 => $value26) {
                    $subordinateid = $value26['employeeid'];
                    $sap_fromdate = $value26['stdate'];
                    $sap_todate = $value26['etdate'];
                    $sap_no_of_days = $value26['no_of_days'];
                    $sap_partial_days = $value26['partial_days'];
                    $sap_leave_type = $value26['type'];
                
                $newar = [];
                $newar['employeeid'] = $subordinateid;

                if ($sap_partial_days == 'full') {
                
                    $newar['from_date'] = substr($sap_fromdate,0,10);
                    $newar['to_date'] = substr($sap_todate,0,10);
                    $newar['starttime'] = '';
                    $newar['endtime'] = '';

                }
                elseif($sap_partial_days == 'first_half'){
                    $newar['from_date'] = substr($sap_fromdate,0,10);
                    $newar['to_date'] = substr($sap_todate,0,10);
                    $newar['starttime'] = substr($sap_fromdate,11,5);
                    $newar['endtime'] = substr($sap_todate,11,5);

                }
                elseif($sap_partial_days == 'second_half'){
                    $newar['from_date'] = substr($sap_fromdate,0,10);
                    $newar['to_date'] = substr($sap_todate,0,10);
                    $newar['starttime'] = substr($sap_fromdate,11,5);
                    $newar['endtime'] = substr($sap_todate,11,5);

                }else{
                    //sd
                }
                $newar['leave_type'] = $sap_leave_type;
                             
                

              $insertapp = $this->deduct_leave_forlate($newar);
              Log::info('---------------start-------');
              if ($insertapp['Status'] == 'Updated Successfully') {
                Log::info('Inserted Apporved application to SAP successfully... - '.$subordinateid);
            }
            else{
                Log::info('Inserted Apporved application to SAP error... '.$subordinateid.' - Status: '.$insertapp['Status']);
                 //$sentosap = 'N';
             }
             Log::info('---------------end-------');


            }

            if(count($approveddata) != 0){
                $request->session()->forget('approvedapplprocess_session');
                unset($approveddata[$request->recordkey][$requestdata[0]['employeeid']]);
                $request->session()->put('approvedapplprocess_session', $approveddata);
            }
            else{
                $request->session()->forget('approvedapplprocess_session');
            }
                           
            return 1;
           
        }
    }


    public function downloadleavebalance(Request $request)
    {
        if (session()->has('employeesession')) {
            $encrypt = session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $remployeeid = $split[0];

            if (in_array($remployeeid, config('newlmsconfig'))) {

               $requestedmonthyear = $request->monthyear;
               $requestedcompany = $request->company;

               $explodemonthyear = explode('/', $requestedmonthyear);
               $month = $explodemonthyear[0];
               $year = $explodemonthyear[1];

               if ($requestedcompany == 4000) {
                   $starts_empid = "10";
               }
               elseif ($requestedcompany == 5000) {
                   $starts_empid = "20";
               }
               elseif ($requestedcompany == 7200) {
                $starts_empid = "70";
                }
               elseif ($requestedcompany == 6300) {
                $starts_empid = "60";
                }
               else{
                $starts_empid = "10";
               }

               
               
               $data = DB::connection('mysql6')->table('leave_balance')->where(['month' => $month, 'year' => $year])->where('employeeid', 'LIKE', $starts_empid.'%')->get();
               if (count($data) > 0) {
                
                return json_encode($data);
               }
               else{
                return json_encode([]);
               }
               

            }
        }
    }

    public function downloadleaveappl(Request $request)
    {
        if (session()->has('employeesession')) {
            $encrypt = session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $remployeeid = $split[0];

            if (in_array($remployeeid, config('newlmsconfig'))) {

               $requestedmonthyear = $request->monthyear;
               $requestedcompany = $request->company;

               $explodemonthyear = explode('/', $requestedmonthyear);
               $month = $explodemonthyear[0];
               $year = $explodemonthyear[1];

               if ($requestedcompany == 4000) {
                   $starts_empid = "10";
               }
               elseif ($requestedcompany == 5000) {
                   $starts_empid = "20";
               }
               elseif ($requestedcompany == 7200) {
                $starts_empid = "70";
                }
               elseif ($requestedcompany == 6300) {
                $starts_empid = "60";
                }
               else{
                $starts_empid = "10";
               }

               
               
               $data = DB::connection('mysql6')->table('leave_processed')->where(['month' => $month, 'year' => $year])->where('employeeid', 'LIKE', $starts_empid.'%')->get();
               if (count($data) > 0) {
                
                return json_encode($data);
               }
               else{
                return json_encode([]);
               }
               

            }
        }
    }

    public function downloadleavedatetimeref(Request $request)
    {
        if (session()->has('employeesession')) {
            $encrypt = session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $remployeeid = $split[0];

            if (in_array($remployeeid, config('newlmsconfig'))) {

               $requestedmonthyear = $request->monthyear;
               $requestedcompany = $request->company;

               $explodemonthyear = explode('/', $requestedmonthyear);
               $month = $explodemonthyear[0];
               $year = $explodemonthyear[1];

               if ($requestedcompany == 4000) {
                   $starts_empid = "10";
               }
               elseif ($requestedcompany == 5000) {
                   $starts_empid = "20";
               }
               elseif ($requestedcompany == 7200) {
                $starts_empid = "70";
                }
               elseif ($requestedcompany == 6300) {
                $starts_empid = "60";
                }
               else{
                $starts_empid = "10";
               }

               
               
               $data = DB::connection('mysql6')->table('datetime_ref')->where(['month' => $month, 'year' => $year])->where('employeeid', 'LIKE', $starts_empid.'%')->get();
               if (count($data) > 0) {
                
                return json_encode($data);
               }
               else{
                return json_encode([]);
               }
               

            }
        }
    }

    public function downloadlateappl(Request $request)
    {
        if (session()->has('employeesession')) {
            $encrypt = session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $remployeeid = $split[0];

            if (in_array($remployeeid, config('newlmsconfig'))) {

               $requestedmonthyear = $request->monthyear;
               $requestedcompany = $request->company;

               $explodemonthyear = explode('/', $requestedmonthyear);
               $month = $explodemonthyear[0];
               $year = $explodemonthyear[1];

               if ($requestedcompany == 4000) {
                   $starts_empid = "10";
               }
               elseif ($requestedcompany == 5000) {
                   $starts_empid = "20";
               }
               elseif ($requestedcompany == 7200) {
                $starts_empid = "70";
                }
               elseif ($requestedcompany == 6300) {
                $starts_empid = "60";
                }
               else{
                $starts_empid = "10";
               }

               
               
               $data = DB::connection('mysql6')->table('latededuction_finaltosap')->where(['month' => $month, 'year' => $year])->where('employeeid', 'LIKE', $starts_empid.'%')->get();
               if (count($data) > 0) {
                
                return json_encode($data);
               }
               else{
                return json_encode([]);
               }
               

            }
        }
    }

    public function intercompanytransfer(Request $request)
    {
        if (session()->has('employeesession')) {
            $encrypt = session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $remployeeid = $split[0];

            if (in_array($remployeeid, config('newlmsconfig'))) {

               $oldemp = $request->oldemp;
               $newemp = $request->newemp;

               $month = Carbon::now()->format('m');
               $year = Carbon::now()->format('Y');
               $checkrec = DB::connection('mysql6')->table('leave_balance')->where(['month' => $month, 'year' => $year, 'employeeid' => trim($newemp)])->get();
               if (count($checkrec) == 0) {
                
               $oldrecord = DB::connection('mysql6')->table('leave_balance')->where(['month' => $month, 'year' => $year, 'employeeid' => trim($oldemp)])->get();
               //return $oldrecord;
               if (count($oldrecord) > 0) {
                   foreach ($oldrecord as $key => $value) {
                       $newrecord = (array)$value;
                       $newrecord['employeeid'] = trim($newemp);
                       unset($newrecord['id']);
                   }
                   //$newrecord->employeeid = trim($newemp);
                  $ins = DB::connection('mysql6')->table('leave_balance')->insertGetId($newrecord);
                   return 1;
               }
               else{
                   return 0;
               }
               
            }
            else{
                return 2;
            }
              


            }
        }
    }

    public function addrestrictholiday(Request $request)
    {
        if (session()->has('employeesession')) {
            $encrypt = session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $remployeeid = $split[0];

            if (in_array($remployeeid, config('newlmsconfig'))) {

               $emp = $request->emp;
               $restmonth = $request->restmonth;

               $now = Carbon::now()->toDateTimeString();
               
               $year = Carbon::now()->format('Y');
               $checkrec = DB::connection('mysql6')->table('restricted_holiday')->where(['rh_month' => $restmonth, 'rh_year' => $year, 'employee_id' => trim($emp)])->get();
               if (count($checkrec) == 0) {
                
               $insertrec = DB::connection('mysql6')->table('restricted_holiday')->insert(['rh_month' => $restmonth, 'rh_year' => $year, 'employee_id' => trim($emp), 'created_by' => $remployeeid, 'created_date' => $now]);
               //return $oldrecord;
               if ($insertrec) {
                   
                  
                  $updateleave = DB::connection('mysql6')->table('leave_balance')->where(['employeeid' => $emp, 'month' => $restmonth, 'year' => $year])->update(['RH' => 1]);
                   return 1;
               }
               else{
                   return 0;
               }
               
            }
            else{
                return 2;
            }
              


            }
        }
    }

    public function downloadpayrollview(Request $request)
    {
        if (session()->has('employeesession')) {
            $encrypt = session()->get('employeesession');
            $decrypt = Crypt::decrypt($encrypt);
            $split = explode("-",$decrypt);
            $remployeeid = $split[0];

            if (in_array($remployeeid, config('newlmsconfig'))) {

               $requestedmonthyear = $request->monthyear;
               $requestedcompany = $request->company;

               $explodemonthyear = explode('/', $requestedmonthyear);
               $month = $explodemonthyear[0];
               $year = $explodemonthyear[1];

               if ($requestedcompany == 4000) {
                   $starts_empid = "10";
               }
               elseif ($requestedcompany == 5000) {
                   $starts_empid = "20";
               }
               elseif ($requestedcompany == 7200) {
                $starts_empid = "70";
                }
               elseif ($requestedcompany == 6300) {
                $starts_empid = "60";
                }
               else{
                $starts_empid = "10";
               }

               $now = Carbon::now();
               $prevstartmonthcheck = $now->subMonth();
               $requestedcheckformat = Carbon::parse($year.'-'.$month.'-01')->toDateString();
               
            //    $add10days = Carbon::parse($requestedcheckformat)->addDays(10);
            //    if (Carbon::parse($now)->gt(Carbon::parse($add10days))) {
            //        return 11;
            //    }

               
            //    if($prevstartmonthcheck->startOfMonth()->format('Y-m-d') != $requestedcheckformat){
            //        return 11;
            //    }

               $getdata = DB::connection('mysql6')->table('payroll')->where(['month' => $month, 'year' => $year])->where('employeeid', 'LIKE', $starts_empid.'%')->get();

               if (count($getdata) > 0) {
                   return json_encode($getdata);
               }
               elseif(count($getdata) == 0){

                $add10days = Carbon::parse($requestedcheckformat)->addDays(10);
                if (Carbon::parse($now)->gt(Carbon::parse($add10days))) {
                    return 11;
                }

               
                if($prevstartmonthcheck->startOfMonth()->format('Y-m-d') != $requestedcheckformat){
                    return 11;
                }

                //sessionadd
                if ($request->session()->has('payrollview_session')) {
                   
                    return 22;
                   }
                   else{
                       $payrollviewsession['month'] = $month;
                       $payrollviewsession['year'] = $year;
                    $request->session()->put('payrollview_session', $payrollviewsession);
                    return 114;

                   }

               }
               else{
                   return 2;
               }


            }
            else{
                return 111;
            }
        }
        else{
            return 111;
        }
    }

    public function payrollviewsession(Request $request)
    {
        if ($request->session()->has('payrollview_session')) {
            $payrollprocess = $request->session()->get('payrollview_session');
            
            $month = $payrollprocess['month'];
            $year = $payrollprocess['year'];

               
            $getcount = DB::connection('mysql6')->table('payroll')->where(['month' => $month, 'year' => $year ])->count();
            if ($getcount == 0) {
                $gettoprocess = DB::connection('mysql6')->table('lateacrual_process')->where(['month' => $month, 'year' => $year ])->take(10)->get();
            }
            else{
                $gettoprocess = DB::connection('mysql6')->table('lateacrual_process')->where(['month' => $month, 'year' => $year ])->skip($getcount)->take(10)->get();
            }
            
            //dd($gettoprocess);
            if (count($gettoprocess) > 0) {
    
                foreach ($gettoprocess as $key => $value) {
                    $employeeid = $value->employeeid;
                $requestedmonthdate = $year.'-'.$month.'-01';
    
                $check = DB::connection('mysql6')->table('payroll')->where(['employeeid' => $employeeid,'month' => $month, 'year' => $year ])->count();
                if ($check == 0) {
                    DB::connection('mysql6')->table('payroll')->insert(['employeeid' => $employeeid,
                        'emp_name' => $value->emp_name,
                        'role_code' => $value->role_code,
                        'plant_code' => $value->plant_code,
                        'position' => $value->position,
                        'department' => $value->department,
                        'cadre' => $value->cadre,
                        'doj' => $value->doj,
                        'month' => $month,
                        'year' => $year,
                        'processed_date' => Carbon::now()->toDateTimeString()
                         ]);
    
    
                $data = $this->payroll_report_attendance($employeeid, $month, $year, $requestedmonthdate);
                $toupdatearr = [];
                //dd($data['row']["$employeeid"]);
                foreach ($data['row']["$employeeid"] as $key1 => $value1) {
                    $leaves = null;
                    $nn1 = null;
                    $nn2 = null;
                    if (!empty($value1['lms_attendance'])) {
                        if (array_key_exists('full',$value1['lms_attendance'])) {
                            $nn1 = $value1['lms_attendance']['full'];
                        }
                        if (array_key_exists('first_half',$value1['lms_attendance'])) {
                            $nn1 = 'FH'.$value1['lms_attendance']['first_half'];
                        }
                        if (array_key_exists('second_half',$value1['lms_attendance'])) {
                            $nn2 = 'SH'.$value1['lms_attendance']['second_half'];
                        }
    
                        
    
                        if (count($value1['lms_attendance']) == '2') {
                            $leaves = $nn1.'/'.$nn2;
                        }
                        else{
                                if (array_key_exists('second_half',$value1['lms_attendance'])) {
                                    $leaves = $nn2;
                                }
                                else{
                                    $leaves = $nn1;
                                }
                            
                        }
    
                    }
                    $subst = substr($key1, 8,2);
                    $toupdatearr["$subst"] = $leaves;
                    
                    $toupdatearr['CL'] = $value1['CL'];
                    $toupdatearr['SL'] = $value1['SL'];
                    $toupdatearr['PL'] = $value1['PL'];
                    $toupdatearr['ML'] = $value1['ML'];
                    $toupdatearr['RH'] = $value1['RH'];
                    $toupdatearr['Permission'] = $value1['Permission'];
                    $toupdatearr['Onduty'] = $value1['Onduty'];
                    $toupdatearr['Tour'] = $value1['Tour'];
                    $toupdatearr['Compoff'] = $value1['Compoff'];
                    $toupdatearr['Mispunch'] = $value1['Mispunch'];
                    $toupdatearr['Absent'] = $value1['Absent'];
                    $toupdatearr['LOP'] = $value1['LOP'];
                    
                    $toupdatearr['Present'] = $value1['Present'];
    
                    
                }
    
                //dd($toupdatearr);
                DB::connection('mysql6')->table('payroll')->where(['employeeid' => $employeeid,'month'=>$month,'year' => $year])->update($toupdatearr);
    
                }
                
                }
    
                
    
    
            }
            else{
                $request->session()->forget('payrollview_session');
                return 1;
            }
            return 1;
        }
    }
    
}
