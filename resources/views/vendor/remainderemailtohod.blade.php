<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<body>
    <style>
        @media only screen and (max-width: 600px) {
            .inner-body {
                width: 100% !important;
            }

            .footer {
                width: 100% !important;
            }
        }

        @media only screen and (max-width: 500px) {
            .button {
                width: 100% !important;
            }
        }




    </style>

   
<h3>Dear {{$data[0]['reporting_name']}},<h3>
<p>Please approve the below pending applications, which are awaiting for approval in your workflow.</p>
<p>Note: The leaves which are not approved on or before 30/31st will be considered as LOP.</p>


<div class="w3-example" style="background-color: #f1f1f1;
    padding: 0.01em 16px;
    margin: 20px 0;
    box-shadow: 0 2px 4px 0 rgba(0,0,0,0.16),0 2px 10px 0 rgba(0,0,0,0.12)!important;" >
<h3>Pending Application Details</h3>
<div style="color: #000!important;
    background-color: #fff!important;padding: 8px 16px!important;">
<table class="table table-striped" style="display:table;border-color: grey; width:100%;" cellpadding="10">
<thead>
<tr>
<th style="text-align:left;">Employee Id</th>
<th style="text-align:left;">Employee Name</th>
<th style="text-align:left;">Leave Type</th>
<th style="text-align:left;">Start Datetime</th>
<th style="text-align:left;">End Datetime</th>
<th style="text-align:left;">Partial Days</th>
<th style="text-align:left;">Attachments</th>
<th style="text-align:left;">Reason</th>
<th style="text-align:left;">Created Date</th>
<th style="text-align:left;">Approve</th>
<th style="text-align:left;">Reject</th>
</tr>
</thead>
<tbody >

@foreach($data as $k => $v)
@foreach($v['employee_details'] as $k1 => $v1)
<tr style="margin:2px;">
<td>{{$v['employeeid']}}</td>
<td>{{$v['empname']}}</td>
<td>{{$v1['type']}}</td>
<td>{{ Carbon\Carbon::parse($v1['stdate'])->format('d, M Y h:i A')}}</td>
<td>{{ Carbon\Carbon::parse($v1['etdate'])->format('d, M Y h:i A')}}</td>
<td>
@if($v1['partial_days'] == 'first_half')
    First Half
    @elseif($v1['partial_days'] == 'second_half')
    Second Half
    @elseif($v1['partial_days'] == 'full')
    Full Day
    @else
    -
    @endif
</td>
<td>
@if($v1['saved_file_path'] != null)
<a href="{{url('/')}}/{{$v1['saved_file_path']}}">View</a>
@else
Nil
@endif
</td>
<td>{{$v1['emp_reason']}}</td>
<td>{{ Carbon\Carbon::parse($v1['created_date'])->format('d, M Y h:i A')}}</td>
<td><a target="_blank" href="{{ url()->full() }}/employeezone/lms/hodoperation/approve/{{$v1['hashed_hod_key']}}" style="color: #FFFFFF;background-color: #4CAF50; padding:15px;">Approve</a></td>
<td><a target="_blank" href="{{ url()->full() }}/employeezone/lms/hodoperation/reject/{{$v1['hashed_hod_key']}}" style="color: #FFFFFF;background-color: red;padding:15px;">Reject</a></td>
</tr>
@endforeach
@endforeach


</tbody>
</table>
</div>
</div>
<br>



<ol style="color:#968c7e; font-style:italic;" type="i">
<p style="font-style:italic;"><b>Note:<b></p>
<li>The leaves which are not approved on or before 30/31st will be considered as LOP.</li>
<li>This is system generated mail. Please do not reply.</li>
</ol>





</body>
</html>
