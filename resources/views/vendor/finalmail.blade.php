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

   
@if($data['member'] == 'HOD')
<h3>Dear {{$data['hod_name']}},<h3>
<p>{{$data['leave_processed']['type']}} Application requested  from {{$data['employee_name']}} ({{$data['leave_processed']['employeeid']}}). Kindly do the needful.</p>
@endif

@if($data['member'] == 'Admin')
<h3>Dear {{$data['admin_name']}},<h3>
<p>{{$data['leave_processed']['type']}} Application requested  from {{$data['employee_name']}} ({{$data['leave_processed']['employeeid']}}). Kindly do the needful.</p>
@endif

<div class="w3-example" style="background-color: #f1f1f1;
    padding: 0.01em 16px;
    margin: 20px 0;
    box-shadow: 0 2px 4px 0 rgba(0,0,0,0.16),0 2px 10px 0 rgba(0,0,0,0.12)!important;width:550px;" >
<h3>Application Details</h3>
<div style="color: #000!important;
    background-color: #fff!important;padding: 8px 16px!important;">
<table class="table table-striped" style="display:table;border-color: grey;" cellpadding="10">

<tbody style="display: table-row-group;
    vertical-align: middle;
    border-color: inherit;">
<tr style="background-color: #f9f9f9;">
    <td>Employee Id</td>
    <td>{{$data['leave_processed']['employeeid']}}</td>
  </tr>
  <tr>
    <td>Employee Name</td>
    <td>{{$data['employee_name']}}</td>
  </tr>
  <tr style="background-color: #f9f9f9;">
    <td>Department</td>
    <td>{{$data['employee_details']['Department']}}</td>
  </tr>
  <tr>
    <td>Designation</td>
    <td>{{$data['employee_details']['Position']}}</td>
  </tr>

  <tr style="background-color: #f9f9f9;">
    <td>Application Type</td>
    <td>{{$data['leave_processed']['type']}}</td>
  </tr>
 
  <tr>
    <td>Start Date</td>
    <td>{{$data['leave_processed']['stdate']}}</td>
  </tr>
  <tr style="background-color: #f9f9f9;">
    <td>End Date</td>
    <td>{{$data['leave_processed']['etdate']}}</td>
  </tr>
  
    
  <tr>
    <td>Partial Days</td>
    <td>
    @if($data['leave_processed']['partial_days'] == 'first_half')
    First Half
    @elseif($data['leave_processed']['partial_days'] == 'second_half')
    Second Half
    @elseif($data['leave_processed']['partial_days'] == 'full')
    Full Day
    @else
    -
    @endif
    </td>
  </tr>
  @if(($data['leave_processed']['type'] != 'Mispunch') || ($data['leave_processed']['type'] != 'Onduty') || ($data['leave_processed']['type'] != 'Compoff') || ($data['leave_processed']['type'] != 'RH'))
  <tr style="background-color: #f9f9f9;">
    <td>No. of days</td>
    <td>{{$data['leave_processed']['no_of_days']}}</td>
  </tr>
  @endif
  @if(!empty($data['compoff_processed']))
  <tr style="background-color: #f9f9f9;">
    <td>Compoff Worked Date</td>
    <td>{{ Carbon\Carbon::parse($data['compoff_processed'][0]['compoff_worked_date'])->format('d, M Y')}}</td>
  </tr>
  <tr style="background-color: #f9f9f9;">
    <td>Punches Reference</td>
    <td>
    @foreach($data['compoff_processed'][0]['punches_taken'] as $key => $value)
    <p>{{ Carbon\Carbon::parse($value->key)->format('d, M Y h:i:s A')}} - {{$value->terminal_name}}</p>
    @endforeach
    </td>
  </tr>
  @endif
  @if(!empty($data['od_reference']))
  <tr style="background-color: #f9f9f9;">
    <td>Onduty Datetime</td>
    <td>{{ Carbon\Carbon::parse($data['od_reference'][0]['od_datetime'])->format('d, M Y h:i:s A')}}</td>
  </tr>
  <tr style="background-color: #f9f9f9;">
    <td>Punches Reference</td>
    <td>
    @foreach($data['od_reference'][0]['puncheslist'] as $key => $value)
    <p>{{ Carbon\Carbon::parse($value->key)->format('d, M Y h:i:s A')}} - {{$value->terminal_name}}</p>
    @endforeach
    </td>
  </tr>
  @endif
  <tr>
    <td>Reason</td>
    <td>{{$data['leave_processed']['emp_reason']}}</td>
  </tr>
  <tr style="background-color: #f9f9f9;">
    <td>Application Created Datetime</td>
    <td>{{$data['leave_processed']['created_date']}}</td>
  </tr>
</tbody>
</table>
</div>
</div>
<br>
@if($data['member'] == 'HOD')
<div class="row">
<a target="_blank" href="{{ url()->full() }}/employeezone/lms/hodoperation/approve/{{$data['hash_key']}}" style="color: #FFFFFF;background-color: #4CAF50; padding:15px;">Approve</a>
<a target="_blank" href="{{ url()->full() }}/employeezone/lms/hodoperation/reject/{{$data['hash_key']}}" style="color: #FFFFFF;background-color: red;padding:15px;">Reject</a>
</div>
@endif
@if($data['member'] == 'Admin')
<div class="row">
<a target="_blank" href="{{ url()->full() }}/employeezone/lms/adminoperation/approve/{{$data['hash_key']}}" style="color: #FFFFFF;background-color: #4CAF50; padding:15px;">Approve</a>
<a target="_blank" href="{{ url()->full() }}/employeezone/lms/adminoperation/reject/{{$data['hash_key']}}" style="color: #FFFFFF;background-color: red;padding:15px;">Reject</a>
</div>
@endif

<br>
<br>



<ol style="color:#968c7e; font-style:italic;" type="i">
<p style="font-style:italic;"><b>Note:<b></p>
<li>Pending applications will be rejected automatically after 5 days.</li>
<li>This is system generated mail. Please do not reply.</li>
</ol>





</body>
</html>
