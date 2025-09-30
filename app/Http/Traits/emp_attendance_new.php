<?php

namespace vgn\Http\Traits;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

trait emp_attendance_new
{
 

    public function pushToSapAttendance($employeeData)
    {
        $wsdl = config('employee_constants_attendance.putemployee_attendance_wsdl');
        require_once('nusoap.php');

        $paramRQ = [
            'DETAILS' => [
                'Employee_ID'  => $employeeData['emp_id'],
                'Date'         => $employeeData['date'],       // YYYYMMDD
                'Punch_Time'   => $employeeData['punch_time'], // HHMMSS
                'Terminal_ID'  => $employeeData['terminal'],
            ]
        ];

        $client = new \nusoap_client($wsdl, true);
        $client->setCredentials(config('employee_constants_attendance.sapusername'), config('employee_constants_attendance.sappassword'), 'basic');
        $client->setUseCURL(true);
        $client->useHTTPPersistentConnection();
        $proxy = $client->getProxy();

        if (empty($proxy)) {
            throw new \Exception("SOAP Proxy is not available");
        }

        // Log::info("Request Payload", ['request' => $paramRQ]);
        // Log::info("SOAP Raw Request", ['xml' => $client->request]);

        $result = $proxy->SI_EMPLOYEE_PUNCH_OUT($paramRQ);
        Log::info("Proxy REs", ['return' => $result]);
        return $result;
    }

}