<?php

namespace vgn\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use vgn\Http\Traits\employeetrait;
use vgn\Http\Traits\emp_attendance_new;

class AttendanceController extends Controller
{
    use employeetrait;
    use emp_attendance_new;
    // public function getattendancefromapi(Request $request)
    // {
    //     if ($request->has('from_date') && $request->has('to_date')) {
    //         $fromdate = Carbon::parse($request->from_date)->format('dmY');
    //         $todate = Carbon::parse($request->to_date)->format('dmY');
    //     } else {
    //         $fromdate = Carbon::now()->format('dmY');
    //         $todate = Carbon::now()->format('dmY');
    //     }
        
    
    //     $api_url = "https://vgn.matrixvyom.com/api.svc/v2/attendance-daily?action=get;field-name=userid,processdate_d,punch1,outpunch;date-range=$fromdate-$todate;format=json";
    
    //     $username = 'sa';
    //     $password = 'C0s$c@321';
    //     $auth = base64_encode("$username:$password");
    
    //     $curl = curl_init();
    
    //     curl_setopt_array($curl, array(
    //         CURLOPT_URL => $api_url,
    //         CURLOPT_RETURNTRANSFER => true,
    //         CURLOPT_HTTPHEADER => array(
    //             "Authorization: Basic $auth",
    //             "Content-Type: application/json"
    //         ),
    //     ));
    
    //     $response = curl_exec($curl);
    //     curl_close($curl);
    
    //     // Convert JSON response to PHP array
    //     $data = json_decode($response, true);
    
    //     // Extract attendance records
    //     $attendance = $data['attendance-daily'] ?? [];
    
    //     return view('list-attendance', compact('attendance', 'fromdate', 'todate'));
    // }
    public function getattendancefromapi(Request $request)
{

    if ($request->has('from_date') && $request->has('to_date')) {
        $fromdate = Carbon::parse($request->from_date)->format('Y-m-d');
        $todate = Carbon::parse($request->to_date)->format('Y-m-d');
    } else {
        $fromdate = Carbon::now()->format('Y-m-d');
        $todate = Carbon::now()->format('Y-m-d');
    }

    $api_url = "https://vgn.matrixvyom.com/api.svc/v2/attendance-daily?action=get;field-name=userid,processdate_d,punch1,outpunch;date-range=" . 
               Carbon::parse($fromdate)->format('dmY') . "-" . Carbon::parse($todate)->format('dmY') . ";format=json";

    $username = 'sa';
    $password = 'C0s$c@321';
    $auth = base64_encode("$username:$password");

    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => $api_url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => array(
            "Authorization: Basic $auth",
            "Content-Type: application/json"
        ),
    ));

    $response = curl_exec($curl);
    curl_close($curl);

    $data = json_decode($response, true);
    $attendance = $data['attendance-daily'] ?? [];
    return view('list-attendance', compact('attendance', 'fromdate', 'todate'));
}



    //push attendance  to sap via proxy
    public function pushsapattendance()
    {


           $fromdate = Carbon::now()->format('Y-m-d');
            //$fromdate ='2025-05-01';
            $todate   = Carbon::now()->format('Y-m-d');

            $api_url = "https://vgn.matrixvyom.com/api.svc/v2/attendance-daily?action=get;field-name=userid,processdate_d,punch1,outpunch;date-range=" .
                Carbon::parse($fromdate)->format('dmY') . "-" . Carbon::parse($todate)->format('dmY') . ";format=json";

            $username = 'sa';
            $password = 'C0s$c@321';
            $auth = base64_encode("$username:$password");

            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => $api_url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPHEADER => array(
                    "Authorization: Basic $auth",
                    "Content-Type: application/json"
                ),
            ));

            $response = curl_exec($curl);
            curl_close($curl);

            $data = json_decode($response, true);
            $attendance = $data['attendance-daily'] ?? [];

            foreach ($attendance as $record) {
                $userid   = $record['userid'];
                $punch1   = trim($record['punch1']);
                $outpunch = trim($record['outpunch']);

                $parsePunch = function ($datetimeStr) {
                    try {
                        $dt = Carbon::createFromFormat('d/m/Y H:i:s', $datetimeStr);
                        return [
                            'date' => $dt->format('Ymd'),
                            'time' => $dt->format('His')
                        ];
                    } catch (\Exception $e) {
                        return null;
                    }
                };

                // Push punch1 only if outpunch is empty
                if (!empty($punch1) && empty($outpunch)) {
                    $parsed = $parsePunch($punch1);
                    if ($parsed) {
                        $sapData = [
                            'emp_id'     => $userid,
                            'date'       => $parsed['date'],
                            'punch_time' => $parsed['time'],
                            'terminal'   => 1
                        ];

                        $response = $this->pushToSapAttendance($sapData);
                        Log::info("Punch1 pushed", ['user' => $userid, 'response' => $response]);
                    } else {
                        Log::warning("Invalid punch1 for user $userid");
                    }
                }

                // Always push outpunch if available
                if (!empty($outpunch)) {
                    $parsed = $parsePunch($outpunch);
                    if ($parsed) {
                        $sapData = [
                            'emp_id'     => $userid,
                            'date'       => $parsed['date'],
                            'punch_time' => $parsed['time'],
                            'terminal'   => 1
                        ];

                        $response = $this->pushToSapAttendance($sapData);
                        Log::info("Outpunch pushed", ['user' => $userid, 'response' => $response]);
                    } else {
                        Log::warning("Invalid outpunch for user $userid");
                    }
                }
            }
            

    }

    
}
