@extends('newemployeezone.layout')

@section('title')
VGN Projects Estates Pvt Ltd |Employee Zone| Leads Followup Page
@endsection

@section('description')
    <meta name="description" content="">
@endsection

@section('keyword')  
@endsection


@section('style')
@include('newemployeezone.styles.commoncss')

<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/rowreorder/1.2.3/css/rowReorder.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.0/css/responsive.dataTables.min.css">

<!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="{{ config('app.AWS_URL')}}/newcustomerzoneassets/plugins/iCheck/all.css">
 <!-- bootstrap datepicker -->
  <link rel="stylesheet" href="{{ config('app.AWS_URL')}}/newcustomerzoneassets/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
   <!-- Bootstrap time Picker -->
  <link rel="stylesheet" href="{{ config('app.AWS_URL')}}/newcustomerzoneassets/plugins/timepicker/bootstrap-timepicker.min.css">

<style>
	.carousel-inner>.item>img
	{
		min-height: 280px;
	}
    #changedetailsForm label.col-sm-2 {
        font-weight: normal;
    }
    .modal-header{
        background-color: #EF5350;
        color: #fff;
        font-weight: bold;
    }
    .marg_left{
        margin-left: 10px;
    }
    .info-box{
      margin-bottom: 0px;
    }
    
    
    .small-box h3 {
    font-size: 22px;
    font-weight: 400;
    margin: 0 0 10px 0;
    white-space: nowrap;
    padding: 0;
}
    
    .card {
  box-shadow: 0 3px 6px rgba(0,0,0,0.16), 0 3px 6px rgba(0,0,0,0.23);
}
    .card:hover {
  box-shadow: 0 14px 28px rgba(0,0,0,0.25), 0 10px 10px rgba(0,0,0,0.22);
}
    #test li{
        list-style-type: none;
            margin-bottom: 5px;
    }
   div.info-box-content p {
   margin: 18px 0px;
  
    }
    div.info-box-content{
      margin-left: 0px;
      text-align: center;
    }
    div.info-box.card{
  background-color: #E44747;    
    }

  

#loading {position: fixed;width: 100%;height: 100%;left: 0;top: 0;right: 0;bottom: 0;display: block;background: #fff;z-index: 10000;}
      #loading img {position: absolute;top: 50%;left: 50%;margin: -23px 0 0 -23px;}

</style>

<script>
  function Converttimeformat(stime) {
// var time = $("#starttime").val();
var time = stime;
var hrs = Number(time.match(/^(\d+)/)[1]);
var mnts = Number(time.match(/:(\d+)/)[1]);
var format = time.match(/\s(.*)$/)[1];
if (format == "PM" && hrs < 12) hrs = hrs + 12;
if (format == "AM" && hrs == 12) hrs = hrs - 12;
var hours = hrs.toString();
var minutes = mnts.toString();
if (hrs < 10) hours = "0" + hours;
if (mnts < 10) minutes = "0" + minutes;
return hours + ":" + minutes;
}
</script>


@endsection

@section('bodycontent')
<body class="hold-transition skin-red sidebar-collapse sidebar-mini">

<!-- Site wrapper -->
<div class="wrapper">

@foreach($getemployeedata as $employee)


 
  @include('newemployeezone.header.index')
  @include('newemployeezone.aside.index')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
   <div id="loading">
      <img src="{{ config('app.AWS_URL')}}/images/spinner/loader-dark.gif" alt="Loading...">
    </div>
    <!-- Main content -->
    <section class="content">
	
	<div class="row">
		      	
      	
        
        
        <div class="col-md-4 col-sm-6 col-xs-12">
          <div class="info-box card">
           

            <div class="info-box-content">
              <p><button class="btn btn-default btn-sm" id="leadsfollowbtn" style="width: 57%;">Lead Followup</button></p>
              <p><button class="btn btn-default btn-sm" id="esalesdiarybtn" style="width: 57%;">E-Sales Diary</button></p>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        
        <div class="col-md-4 col-sm-6 col-xs-12">
          <div class="info-box card">
            

            <div class="info-box-content">
              <p><button class="btn btn-default btn-sm" id="quotation" style="width: 57%;">Quotation</button></p>
              <p><button class="btn btn-default btn-sm" id="avail_status" style="width: 57%;">Availability Status</button></p>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        
        <div class="col-md-4 col-sm-6 col-xs-12">
          <div class="info-box card">
            

            <div class="info-box-content">
              <p><a href="#" class="btn btn-default btn-sm" id="smsgreet_mass" style="width: 57%;text-align: left;">SMS - Greetings Project E-Brochure Mass</a></p>
              <p><a href="#" class="btn btn-default btn-sm" id="smsinvite_mass" style="width: 57%;text-align: left;">SMS - Invitation for Site visit Mass</a></p>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        
	</div>
	
	<div class="row">
		      	
      	
      	
        
        
        <div class="col-md-4 col-sm-6 col-xs-12">
          <div class="info-box card">
            

            <div class="info-box-content">
              <p><a href="{{ url('/employeezone/script/')}}/{{$type}}" class="btn btn-default btn-sm" style="width: 57%;">Scripts for {{$type}} leads</a></p>
              
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        
       
        
        <div class="col-md-4 col-sm-6 col-xs-12">
          
              @if($type == 'hot')
              <div class="info-box card">
            
            <div class="info-box-content">
              <p><a href="{{ url('/employeezone/leadsdetail/') }}/{{$type}}/HOT_OD" class="btn btn-default btn-sm" style="width: 57%;text-align: left;">Last 60 Days Site visit completed</a></p>
            </div>
          </div>
             @endif
              @if($type == 'warm')
              <div class="info-box card">
            
            <div class="info-box-content">
              <p><a href="{{ url('/employeezone/leadsdetail/') }}/{{$type}}/WARM_SV" class="btn btn-default btn-sm" style="width: 57%;text-align: left;">Overdue site visits last 180 days</a></p>
              <p><a href="{{ url('/employeezone/leadsdetail/') }}/{{$type}}/WARM1" class="btn btn-default btn-sm" style="width: 57%;text-align: left;">Next 30 days scheduled site visit</a></p>
            </div>
          </div>
             @endif
          
        </div>
        

         <div class="col-md-4 col-sm-6 col-xs-12">
          <div class="info-box card">
            
            <!-- /.box-header -->
            <div class="info-box-content">
              <ul id="test" style="padding:0px;">
                  <li><button class="btn btn-default btn-sm" id="smsgreet_single" style="width: 57%;text-align: left;">SMS - Greetings Project E-Brochure</button></li>
                  <li><a href="#" class="btn btn-default btn-sm" id="smsinvite_single" style="width: 57%;text-align: left;">SMS - Invitation for Site visit</a></li>
                  @if($type != 'hot')
                  <li><a href="#" class="btn btn-default btn-sm" id="smsschedule_single" style="width: 57%;text-align: left;">SMS - Schedule for Site visit</a></li>
                  @endif
                  @if($type == 'warm')
                  <li><a href="#" class="btn btn-default btn-sm" id="smscompletion_single" style="width: 57%;text-align: left;">SMS - Completion for Site visit</a></li>
                  @endif
                  <li><a href="#" class="btn btn-default btn-sm" id="smsschedulecallback_single" style="width: 57%;text-align: left;">Schedule Callback</a></li>
                  <li><a href="#" class="btn btn-default btn-sm" id="smsemailsms_single" style="width: 57%;text-align: left;">Email/SMS for quotation</a></li>
                  <!-- <li><a href="#" class="btn btn-default btn-sm" id="smsbooked_single" style="width: 57%;text-align: left;">SMS - Booked Indicator</a></li> -->
              </ul>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        
	</div>



	<div class="row">
		
    <div class="col-md-12">
      
      <div class="box box-danger" style="margin-top: 5px;">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-diamond margin-r-5"></i> Sales Leads Follow Up </h3>
                
                <span class="pull-right"><a href="/employeezone/leadsfollowup" class="btn btn-danger btn-xs"><i class="fa fa-backward margin-r-5"></i>Leads Followup Homepage</a></span>
                
                
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              
               <h5 style="font-weight: 600;">Lead Class: {{ strtoupper($type) }} Leads</h5>

              <h5 style="font-weight: 600;">Employee Name: {{ $employee->name }}</h5>
              <h5 style="font-weight: 600;">Plant Code: {{ $selectedplant }}</h5>
               <div class="col-sm-6 col-sm-offset-3">
				 @if(session()->has('error_msg'))
				        <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                {{Session::get('error_msg')}}
              </div>
				        <br>
				 @endif
                 @if(session()->has('suc_msg'))
				        
				        <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-check"></i> Alert!</h4>
                {{Session::get('suc_msg')}}
              </div>
				        <br>
				 @endif
              </div>
                
                <form style="overflow:auto;" action="{{ url('/employeezone/complaints')}}" name="closeform" method="post">
		{{ csrf_field()}}
		<input type="hidden" name="close" value="#" id="closevalue">
		</form>
                
                <form id="changedetailsForm" method="POST" action="{{ url('/employeezone/changemydetails') }}" class="form-horizontal" >
                {{ csrf_field() }}
                   <div class="row" style="margin-left:3px;">
                       <div class="col-md-12">
                           
                          <table id="example" class="display nowrap" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Select</th>
                <th>S.No</th>
				<th>Created Date</th>
        @if($type == 'warm')
				<th>Schedule Site Visit Date</th>
        <th>Schedule Site Visit Time</th>
        @endif
        @if($type == 'hot')
        <th>Expected Date Of Booking</th>
        @endif
        <th>Callback Date</th>
        <th>Callback Time</th>
        
				<th>Request for Cold Approval</th>
				<th>Project Description</th>
        
				<th>Lead no</th>
				<th>Name of the prospect</th>
        <th>Email ID</th>
						

				<th>Lead Source</th>

				<th>Project</th>
        <th>Lead Stage</th>   
				<th>Lead Type</th>
				<th>Sub Lead Type</th>
				<th>Budget range</th>
				<th>Created by</th>
				<th>Created Time</th>
				<th>Referred by</th>
				<th>Sales Manager</th>
				<th>SMS Greetings & Proj E Brochures</th>
				<th>Invitation For Site Visit</th>
				<th>Schedule for Site Visit</th>
				<th>Completion of Site Visit</th>
				<th>Quotation Email</th>
				<th>Booked Ind</th>
				<th>Lead From Telecaller</th>
        
				
				
            </tr>
        </thead>
       
        <tbody>
           
            @if(count($mainarray) > 0)
													<?php $count = 1; ?>
													@foreach($mainarray as $leads)
                          @if($leads['Project'] != $selectedplant)
                              @continue
                          @endif
														<tr>
														<td>
														    
                <label>
                  <input type="radio" class="flat-red" name="leadcheck" value="{{$leads['Lead_No']}}/{{$leads['Lead_Name']}}">
                </label>
                
              
														</td>
														<td id="snoid">{{$count}}</td>
								                        <td id="c_date">
                                                           <?php
                                                            if($leads['Cr_Date'] != ''){
                                                           //echo substr($leads['Cr_Date'],0,4).'-'.substr($leads['Cr_Date'],4,2).'-'.substr($leads['Cr_Date'],6,2);
                                                            echo substr($leads['Cr_Date'],6,2).'-'.substr($leads['Cr_Date'],4,2).'-'.substr($leads['Cr_Date'],0,4);
                                                            } ?></td>
                                                            @if($leads['Lead_Stage'] == 'WARM')
														                              <td id="schedule_sitevisitdate">
                                                            @if($leads['Sch_SV_Date'] != '0000-00-00')
                                                          {{$leads['Sch_SV_Date']}}
                                                          @endif
                                                          </td>
                                                          <td id="schedule_sitevisittime">
                                                            @if($leads['Sch_SV_Time'] != '00:00:00')
                                                          {{$leads['Sch_SV_Time']}}
                                                          @endif
                                                          </td>
                                                          @endif

                                                           @if($type == 'hot')
                            
                            <td id="expected_dateof_booking">
                            <div class="input-group">
  <div class="input-group-addon">
    <i class="fa fa-calendar"></i>
  </div>
  @if(!empty($leads['Expected_Booking_Date']) && ($leads['Expected_Booking_Date'] != '0000-00-00'))
  <input type="text" class="form-control pull-right expected_datebook" name="expected_datebook[]" readonly="true" value = "{{$leads['Expected_Booking_Date']}}" >
  @else
  <input type="text" class="form-control pull-right expected_datebook" name="expected_datebook[]" readonly="true" value = "" >
  @endif
  
</div>
</td>
                            @endif

                                                          <td id="callbackdate">
                                                            @if($leads['Call_Back_Date'] != '0000-00-00')
                                                          {{$leads['Call_Back_Date']}}
                                                          @endif
                                                          </td>
                                                          <td id="callbacktime">
                                                            @if($leads['Call_Back_Time'] != '00:00:00')
                                                          {{$leads['Call_Back_Time']}}
                                                          @endif
                                                          </td>
                                                            <td>
                                                            <?php
                                                            if($leads['Cold_Reason'] == 'REQ_APP'){
                                                              echo 'Request for COLD Approval';
                                                            }
                                                            elseif ($leads['Cold_Reason'] == 'REJECTED') {
                                                              echo 'Rejected';
                                                            }
                                                            else{
                                                              //nothing
                                                            }
                                                              ?>
                                                            </td>
														
														
														<td id="desc">{{$leads['Project_Desc']}}</td>
														<td id="leadno">{{$leads['Lead_No']}}</td>
														<td id="leadname">{{$leads['Lead_Name']}}</td>
                            <td ><a href="mailto:{{$leads['Mail_ID']}}" id="mailid">{{$leads['Mail_ID']}}</a></td>
														
														<td id="leadsource">{{$leads['Lead_Source']}}</td>
														<td id="projectid">{{$leads['Project']}}</td>
                            <td id="leadstage">{{$leads['Lead_Stage']}}</td>
														<td id="leadtype">{{$leads['Lead_Type']}}</td>
														<td id="subleadtype">{{$leads['Sublead_Type']}}</td>
														<td id="budgetrange">{{$leads['Budget_Range']}}</td>
														<td id="crby">
														<?php
                                                            if($leads['Cr_By'] != ''){
                                                            echo substr($leads['Cr_By'],0,2).':'.substr($leads['Cr_By'],2,2).':'.substr($leads['Cr_By'],4,2);}
                                                            ?>
														</td>
														<td id="crtime">
														<?php
														if($leads['Cr_Time'] != ''){
                                                            echo substr($leads['Cr_Time'],0,2).':'.substr($leads['Cr_Time'],2,2).':'.substr($leads['Cr_Time'],4,2);}
                                                            ?>
														</td>
														<td id="refby">{{$leads['Ref_By']}}</td>
														<td id="salmanager">{{$leads['Sal_Manager']}}</td>
														<td id="smsgreet">
														    <input type="checkbox" "@if($leads['SMS_Greet_Eb'] == 'X') checked=true @endif" disabled>
														    
														</td>
														<td id="inv_sitevisit"><input type="checkbox" "@if($leads['Inv_SV'] == 'X') checked=true @endif" disabled></td>
														<td id="schedule_sitevisit"><input type="checkbox" "@if($leads['Sc_SV'] == 'X') checked=true @endif" disabled></td>
														
														<td id="comp_sitevisit"><input type="checkbox" "@if($leads['C_SV'] == 'X') checked=true @endif" disabled></td>
														
														<td id="quo_email"><input type="checkbox" "@if($leads['Quo_Email'] == 'X') checked=true @endif" disabled></td>
														
														<td id="book_ind"><input type="checkbox" "@if($leads['Booked_Ind'] == 'X') checked=true @endif" disabled></td>
														
														<td id="leadfromtele"><input type="checkbox" "@if($leads['Lead_Tele'] == 'X') checked=true @endif" disabled></td>
                            
                           
                            
														
														</tr>
														<?php $count++; ?>
													@endforeach
													@endif            
        </tbody>
    </table>           
                                             
                       </div>
                   </div>
                            
                                
                </form>
              

              
            </div>
            <!-- /.box-body -->
          </div>

    </div>


		

		
	</div>
	


    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  @include('newemployeezone.footer')
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->


<div class="modal fade" id="myModalcallback" tabindex="-1" role="dialog" aria-labelledby="myModalLabelcallback">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabelcallback"></h4>
      </div>
      <div class="modal-body">
        
          
          <div class="form-group ">
                <label class="col-sm-2">Date:</label>

                <div class="input-group col-sm-6">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control" name="cbdate" data-inputmask="'alias': 'yyyy-mm-dd'" data-mask id="cbdatemask" required="true">
                </div>
                
              </div>

              <div class="form-group">
                  <label class="col-sm-2">Time</label>

                  <div class="input-group col-sm-6">
                  <div class="input-group-addon">
                      <i class="fa fa-clock-o"></i>
                    </div>
                    <input type="text" class="form-control timepicker" name="ctime" id="ctime" required="true">

                    
                  </div>
                  
                </div>
               
<div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <button type="button" id="callbacksingle" class="btn btn-primary">Submit</button>
              </div>
          </form>
      </div>
      
    </div>
  </div>
</div>

  
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"></h4>
      </div>
      <div class="modal-body">
        
          
          <div class="form-group ">
                <label class="col-sm-2">*Date:</label>

                <div class="input-group col-sm-6">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control" name="sddate" data-inputmask="'alias': 'dd-mm-yyy'" data-mask id="sdatemask" required="true">
                </div>
                
              </div>

              <div class="form-group">
                  <label class="col-sm-2">*Time</label>

                  <div class="input-group col-sm-6">
                  <div class="input-group-addon">
                      <i class="fa fa-clock-o"></i>
                    </div>
                    <input type="text" class="form-control timepicker" name="stime" id="stime" required="true">

                    
                  </div>
                  
                </div>

                <div class="form-group">
                  <label class="col-sm-2">Own Vehicle</label>

                  <div class="input-group col-sm-6">
                  <div class="form-check form-inline">
  
  <input  type="checkbox" name="inlineRadioOptions" id="inlineRadio2" value="yes"> 
</div>

                    
                  </div>
                  
                </div>
                <div class="form-group" id="showpickup" style="clear: both;">
                  <label class="col-sm-2">*Pickup Location</label>

                  <div class="input-group col-sm-6">
                  <div class="input-group-addon">
                      <i class="fa fa-map-o"></i>
                    </div>
                    <textarea class="form-control" name="pickuplocation" id="pickuplocation" ></textarea>

                    
                  </div>
                  
                </div>
<div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <button type="button" id="schedulevisitsingle" class="btn btn-primary">Submit</button>
              </div>
          </form>
      </div>
      
    </div>
  </div>
</div>


<div class="modal fade" id="myModalemail" tabindex="-1" role="dialog" aria-labelledby="myModalLabelemail">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabelemail"></h4>
      </div>
      <div class="modal-body">
        
          <form action="" class="form-horizontal"> 

            <div class="form-group">
                        <label for="plantcode" class="col-sm-2">Plant Code*</label>
                        <div class="col-sm-4">
                          
                          <select class="form-control userdropdown" name="plantcode" id="projectno" required>

                            <option selected value="">Select</option>
                        @foreach ($getprojectnames['UNSOLD_PROJECTS'] as $value) 
                        <option value="{{$value['Project_No']}}">{{$value['Project_No']}} - {{$value['Project_Name']}}</option>
                                @endforeach
                            
                          </select> 
                          {!! $errors->first('plantcode', '<span class="errortext text-red">:message</span>') !!}
                          
                        </div>
                        
                      </div>
                      
                      
                      <div class="row">
                              <div class="col-sm-12">
                                
                                <div class="form-group" style="padding:4px;">
                            <label for="unitno" class="col-sm-2">Unit No.</label>
                            <div class="col-sm-4">
                            <select class="form-control" name="unitno" id="punitno" required>
                              
                              </select>
                            
                            </div>
                            
                            
                          </div>

                              </div>
                            </div>
</form>
              
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <button type="button" id="emailsmssingle" class="btn btn-primary">Submit</button>
              </div>
          
      </div>
      
    </div>
  </div>
</div>

<div class="modal fade" id="myModalquotation" tabindex="-1" role="dialog" aria-labelledby="myModalLabelquotation">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabelquotation"></h4>
      </div>
      <div class="modal-body">
        
          <form action="{{ url('/employeezone/leadfollowupviewquote')}}" class="form-horizontal" method="post"> 
      {{csrf_field()}}
            <div class="form-group">
                        <label for="plantcode" class="col-sm-2">Plant Code*</label>
                        <div class="col-sm-4">
                          
                          <select class="form-control userdropdown" name="qplantcode" id="qprojectno" required>

                            <option selected value="">Select</option>
                        @foreach ($getprojectnames['UNSOLD_PROJECTS'] as $value) 
                        <option value="{{$value['Project_No']}}">{{$value['Project_No']}} - {{$value['Project_Name']}}</option>
                                @endforeach
                            
                          </select> 
                          {!! $errors->first('plantcode', '<span class="errortext text-red">:message</span>') !!}
                          
                        </div>
                        
                      </div>
                      <input type="hidden" name="leadno" id="qleadno">
                      <input type="hidden" name="leadname" id="qleadname">
                      
                      <div class="row">
                              <div class="col-sm-12">
                                
                                <div class="form-group" style="padding:4px;">
                            <label for="unitno" class="col-sm-2">Unit No.</label>
                            <div class="col-sm-4">
                            <select class="form-control" name="qunitno" id="qpunitno" required>
                              
                              </select>
                            
                            </div>
                            
                            
                          </div>

                              </div>
                            </div>

              
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <button type="submit" id="quotationsingle" class="btn btn-primary">Submit</button>
              </div>
        </form>  
      </div>
      
    </div>
  </div>
</div>


<div class="modal fade" id="myModalavailstatus" tabindex="-1" role="dialog" aria-labelledby="myModalLabelavailstatus">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabelavailstatus"></h4>
      </div>
      <div class="modal-body">
        
          <form action="" class="form-horizontal" > 
      
            <div class="form-group">
                        <label for="plantcode" class="col-sm-2">Plant Code*</label>
                        <div class="col-sm-4">
                          
                          <select class="form-control userdropdown" name="aplantcode" id="aprojectno" required>

                            <option selected value="">Select</option>
                        @foreach ($getprojectnames['UNSOLD_PROJECTS'] as $value) 
                        <option value="{{$value['Project_No']}}">{{$value['Project_No']}} - {{$value['Project_Name']}}</option>
                                @endforeach
                            
                          </select> 
                          {!! $errors->first('plantcode', '<span class="errortext text-red">:message</span>') !!}
                          
                        </div>
                        
                      </div>
                     
        </form>                
                                
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <button type="submit" id="availstatussingle" class="btn btn-primary">Submit</button>
              </div>
        
      </div>
      
    </div>
  </div>
</div>


<div class="modal fade" id="myModalbooked" tabindex="-1" role="dialog" aria-labelledby="myModalLabelbooked">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabelbooked"></h4>
      </div>
      <div class="modal-body">
        
          <p>Booking Indicator is flagged for this lead '<span id="bookedindleadno"></span> / {{$employee->name}}'. This lead will disappear from this screen. Do you really want to confirm the same.'</p>
              
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <button type="button" id="bookedsingle" class="btn btn-primary">Confirm</button>
              </div>
          
      </div>
      
    </div>
  </div>
</div>
@endforeach
@endsection

@section('script')
@include('newemployeezone.js.commonjs')
<script>
    function stripslashes(str) {
str=str.replace(/\\'/g,'\'');
str=str.replace(/\\"/g,'"');
str=str.replace(/\\0/g,'\0');
str=str.replace(/\\\\/g,'\\');
return str;
}
    
    
</script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js" ></script>
<script src="https://cdn.datatables.net/rowreorder/1.2.3/js/dataTables.rowReorder.min.js" ></script>
<script src="https://cdn.datatables.net/responsive/2.2.0/js/dataTables.responsive.min.js" ></script>
<!-- iCheck 1.0.1 -->
<script src="{{ config('app.AWS_URL')}}/newcustomerzoneassets/plugins/iCheck/icheck.min.js"></script>


<!-- InputMask -->
<script src="{{ config('app.AWS_URL')}}/newcustomerzoneassets/plugins/input-mask/jquery.inputmask.js"></script>
<script src="{{ config('app.AWS_URL')}}/newcustomerzoneassets/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="{{ config('app.AWS_URL')}}/newcustomerzoneassets/plugins/input-mask/jquery.inputmask.extensions.js"></script>
<!-- bootstrap datepicker -->
<script src="{{ config('app.AWS_URL')}}/newcustomerzoneassets/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- bootstrap time picker -->
<script src="{{ config('app.AWS_URL')}}/newcustomerzoneassets/plugins/timepicker/bootstrap-timepicker.min.js"></script>

<script>
    
    function readCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for(var i=0;i < ca.length;i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1,c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
    }
    return null;
}
    
    function delete_cookie(name) {
    document.cookie = name + '=;expires=Thu, 01 Jan 1970 00:00:01 GMT;path=/';
};
    var value = readCookie('leadsfolloupviewquote');
    
    var value2 = readCookie('selectedlead');
    if(value == "leadsfolloupviewquoteloaded"){
        delete_cookie('leadsfolloupviewquote');
        window.location.reload();
    }
    delete_cookie('selectedlead');

    var checkedlead = readCookie('checkedlead');
    if(checkedlead == "followup"){
        delete_cookie('checkedlead');
        window.location.reload();
    }

</script>
<script>
      $(window).on('load',function(){
             setTimeout(function() {
                 $('#loading').fadeOut( 400, "linear" );
              }, 300);
      });
      
    </script>



<script>



$(document).ready(function() {

  //snoid

  

  

  /*$("#showpickup").hide();*/

  $('input[type=checkbox][name=inlineRadioOptions]').change(function() {
    var checkedbox = $('input[type=checkbox][name=inlineRadioOptions]:checked').val();
    
    if (checkedbox === undefined) {
        $("#showpickup").show();
    }
    else if (checkedbox == 'yes') {

        $("#showpickup").hide();
    }
});

    var table = $('#example').DataTable( {
        "order": [[ 1, "asc" ]],
        rowReorder: false,
        responsive: false,
        "scrollX": true,
        "scrollY": "300",
		paging: false
    } );
    var future45days = new Date();
    future45days.setDate(future45days.getDate()+44);
    $('.expected_datebook').datepicker({
      autoclose: true,
      format: 'yyyy-mm-dd',
      startDate: 'today',
      endDate: future45days
    });
    
    //Flat red color scheme for iCheck
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
      checkboxClass: 'icheckbox_flat-red',
      radioClass   : 'iradio_flat-red'
    });
     //$('#sdatemask').inputmask('yyyy-mm-dd', { 'placeholder': 'yyyy-mm-dd' })
     //Date picker
    $('#sdatemask').datepicker({
      autoclose: true,
      format: 'dd-mm-yyyy',
      startDate: 'today'
    });

    $('#cbdatemask').datepicker({
      format: 'dd-mm-yyyy',
      autoclose: true
    });
     //Timepicker
    $('.timepicker').timepicker({
      showInputs: false,
       use24hours: true
    });


    $('.expected_datebook').on('change', function(){
      $('#loading').show();
      //var row = $(this).closest('tr');
           //var leadno = $.trim(row.find('#leadno').text());
          // var expdob = $(this).val();
      var rows = $("#example > tbody tr");
      var count = 0;
      $.each(rows, function(i, v){
        var leadno = $.trim($(this).find("#leadno").text());
        var expdate = $.trim($(this).find(".expected_datebook").val());
        if (expdate == '') {
          count += 1;
        }
      });


      
        var req = {};
        var k = 0;
         $.each(rows, function(i, v){
        var nleadno = $.trim($(this).find("#leadno").text());
        var nexpdate = $.trim($(this).find(".expected_datebook").val());
        if (nexpdate != '') {
          req[k] = {'Lead_No': nleadno, 'Expected_Booking_Date': nexpdate};
          //['Details' => ['Emp_ID'=>$empname, 'Lead_No' => $leadno, 'Expected_Booking_Date' => $exp_date ] ];
          k = k + 1;
        }
      });
            

           $.post('/employeezone/expecteddob',{_token:'{{csrf_token()}}',exp_dateob:req}, function(data){
              $('#loading').hide();
              console.log(data);
                 if(data == 1){
                  
                     alert('Expected Date of Booking Updated Successfully!');
                     window.location.reload();
                 }
                 else{
                  alert('Failed to update. Try Again');
                     window.location.reload();
                 }
            });   

         //console.log(req);

      
      
          // console.log(row);

           /* if ((leadno != '') && (expdob != '')) {
              var r = confirm("Please confirm to update lead:" + leadno+' with Expected Date of Booking: '+expdob);
        if (r == true) {
              $.post('/employeezone/expecteddob',{_token:'{{csrf_token()}}',leadno: leadno,exp_dateob:expdob}, function(data){
              $('#loading').hide();
              
                 if(data == 1){
                  
                     alert('Expected Date of Booking Updated Successfully!');
                     window.location.reload();
                 }
                 else{
                  alert('Failed to update. Try Again');
                     window.location.reload();
                 }
            });   
        }
            }*/
            $('#loading').hide();
           
    });


     $('#projectno').on('change', function(){
          var projectcode = $(this).val();
          $('#punitno').val('') ;
          

          $.post( "{{url('/employeezone/getsingleunits')}}",{_token: "{{csrf_token()}}",projectcode: projectcode}, function( data ) {
            
                        
            var output='<option value="">Select*</option>';

              var newdata = JSON.parse(data);
              if (!$.isArray(newdata)){ newdata = [newdata];} 

            $.each(newdata, function(index,val){
                
                if (val['Unit_No'] != '') {
                output += '<option value="'+val['Unit_No']+'"';
                
                output+='>'+val['Unit_No']+' - '+val['Unit_Description']+'</option>';
                    
                $('#punitno').html(output);
              }

            });


          });

         

        });



      $('#qprojectno').on('change', function(){
          var projectcode = $(this).val();
          $('#qpunitno').val('') ;
          

          $.post( "{{url('/employeezone/getsingleunits')}}",{_token: "{{csrf_token()}}",projectcode: projectcode}, function( data ) {
            
                        
            var output='<option value="">Select*</option>';

              var newdata = JSON.parse(data);
              if (!$.isArray(newdata)){ newdata = [newdata];} 

            $.each(newdata, function(index,val){
                
                if (val['Unit_No'] != '') {
                output += '<option value="'+val['Unit_No']+'"';
                
                output+='>'+val['Unit_No']+' - '+val['Unit_Description']+'</option>';
                    
                $('#qpunitno').html(output);
              }

            });


          });

         

        });
    
} );    
    
    $("#smsgreet_single").on('click', function(){
        $('#loading').show();
        var checkedstatus = $('input[name=leadcheck]:checked').val();
        if(checkedstatus == undefined){
          $('#loading').hide();
            alert('Select one lead from the table.');
        }
        else{
          checkedstatus = checkedstatus.split('/');
            $.post('/employeezone/sendsmsforleads',{_token:'{{csrf_token()}}',leadno: checkedstatus[0],type:'smsgreet_single'}, function(data){
              $('#loading').hide();
                if(data == 1){
                  
                    alert('Greetings Project E-Brochure SMS Sent Successfully!');
                    window.location.reload();
                }
            });
        }
    });

    $("#smsgreet_mass").on('click', function(){
        
       $('#loading').show();
          
           $.post('/employeezone/sendsmsforleads',{_token:'{{csrf_token()}}',cadr: "{{$type}}",type:'smsgreet_mass'}, function(data){
            //console.log(data);
              $('#loading').hide();
                if(data == 1){

                    alert('Greetings Project E-Brochure Mass SMS Sent Successfully!');
                    window.location.reload();
                }
            });
        
    });

    $("#smsinvite_mass").on('click', function(){
        
       $('#loading').show();
          
           $.post('/employeezone/sendsmsforleads',{_token:'{{csrf_token()}}',cadr: "{{$type}}",type:'smsinvite_mass'}, function(data){
              $('#loading').hide();
                if(data == 1){
                    alert('Invitation for Site Visit Mass Sent Successfully!');
                    window.location.reload();
                }
            });
        
    });



    
     $("#smsinvite_single").on('click', function(){
        $('#loading').show();
        var checkedstatus = $('input[name=leadcheck]:checked').val();
        if(checkedstatus == undefined){
          $('#loading').hide();
            alert('Select one lead from the table.');
        }
        else{
          checkedstatus = checkedstatus.split('/');
            $.post('/employeezone/sendsmsforleads',{_token:'{{csrf_token()}}',leadno: checkedstatus[0],type:'smsinvite_single'}, function(data){
              $('#loading').hide();
                if(data == 1){
                    alert('Invitation for Site visit SMS Sent Successfully!');
                    window.location.reload();
                }
            });
        }
    });

     $("#schedulevisitsingle").on('click', function(){
      $('#loading').show();
      var err = 0;
        var checkedstatus = $('input[name=leadcheck]:checked').val();
        if(checkedstatus == undefined){
          $('#loading').hide();
            alert('Select one lead from the table.');
        }
        else{
         var sdate = $("#sdatemask").val();
         var stime = $("#stime").val();
         if(($.trim(sdate) == '') || ($.trim(stime) == '')){
          err = 1;
         }
         var pckuploc = $("#pickuplocation").val();
         var ownvehicle = $('input[type=checkbox][name=inlineRadioOptions]:checked').val();
         
         if(ownvehicle === undefined){
          if($.trim(pckuploc) == ''){
            alert('Please enter the pickup location field!');
            err = 1;
          }
          if(($.trim(pckuploc).length > 100)){
            alert('Maximum 100 characters are allowed ');
            err = 1;
          }
          ownind = '';
         }

         if(ownvehicle == 'yes'){
          ownind = 'X'
         }
        
        
         
         var aa = Converttimeformat(stime);

          
          checkedstatus = checkedstatus.split('/');
          var newdate = sdate.split("-");

          sdate = newdate[2]+'-'+newdate[1]+'-'+newdate[0];
          
          
          if(err <= 0){
          $.post('/employeezone/sendsmsforleads',{_token:'{{csrf_token()}}',leadno: checkedstatus[0],type:'smsschedule_single',sdate: sdate, stime: aa,'pickuplocation': pckuploc,'ownind':ownind }, function(data){
            console.log(data);
              $('#loading').hide();
                if(data == 1){
                    alert('Schedule for Site visit SMS Sent Successfully!');
                    $('#myModal').modal('hide');
                    window.location.reload();
                }
                else{
                  alert('Please fill the required fields!');
                }
            });
            }
            else{
              $('#loading').hide();
              alert('Please fill the required fields!');
              //$('#myModal').modal('show');
            }
        }

     });


     $("#callbacksingle").on('click', function(){
      $('#loading').show();
        var checkedstatus = $('input[name=leadcheck]:checked').val();
        if(checkedstatus == undefined){
          $('#loading').hide();
            alert('Select one lead from the table.');
        }
        else{
         var cdate = $("#cbdatemask").val();
         var ctime = $("#ctime").val();
         
         
         var aa = Converttimeformat(ctime);
          
          checkedstatus = checkedstatus.split('/');
          var newdate = cdate.split("-");

          cdate = newdate[2]+'-'+newdate[1]+'-'+newdate[0];

          
          $.post('/employeezone/sendsmsforleads',{_token:'{{csrf_token()}}',leadno: checkedstatus[0],type:'smsschedulecallback_single',cdate: cdate, ctime: aa}, function(data){
            console.log(data);
              $('#loading').hide();
                if(data == 1){
                    alert('Callback Updated Successfully!');
                    $('#myModalcallback').modal('hide');
                    window.location.reload();
                }
                else{
                  alert('Please fill the required fields!');
                }
            });
        }

     });

     $("#emailsmssingle").on('click', function(){
      $('#loading').show();
        var checkedstatus = $('input[name=leadcheck]:checked').val();
        if(checkedstatus == undefined){
          $('#loading').hide();
            alert('Select one lead from the table.');
        }
        else{
         var sprojectno = $("#projectno").val();
         var sunitno = $("#punitno").val();
         
          
          checkedstatus = checkedstatus.split('/');
          
          $.post('/employeezone/sendsmsforleads',{_token:'{{csrf_token()}}',leadno: checkedstatus[0],type:'emailsmssingle',sprojno: sprojectno, sunit: sunitno}, function(data){
              $('#loading').hide();
                if(data == 1){
                    alert('Email/SMS for quotation Sent Successfully!');
                    window.location.reload();
                }
            });
        }

     });

     

     $("#smsschedule_single").on('click', function(){
        $('#loading').show();

        var checkedstatus = $('input[name=leadcheck]:checked').val();
        if(checkedstatus == undefined){
          $('#loading').hide();
            alert('Select one lead from the table.');
        }
        else{
          $("#myModalLabel").html("Schedule Site Visit");
          $('#loading').hide();
           
        $('#myModal').modal('show'); 

        }
    });

     $("#smsschedulecallback_single").on('click', function(){
        $('#loading').show();
        var checkedstatus = $('input[name=leadcheck]:checked').val();
        if(checkedstatus == undefined){
          $('#loading').hide();
            alert('Select one lead from the table.');
        }
        else{
          $("#myModalLabelcallback").html("Schedule Callback Date");
          $('#loading').hide();
           
        $('#myModalcallback').modal('show'); 

        }
    });

      $("#smscompletion_single").on('click', function(){

        var checkedstatus = $('input[name=leadcheck]:checked').val();
        if(checkedstatus == undefined){
            alert('Select one lead from the table.');
        }
        else{
         

          checkedstatus = checkedstatus.split('/');
          
          $.post('/employeezone/sendsmsforleads',{_token:'{{csrf_token()}}',leadno: checkedstatus[0],type:'smscompletion_single'}, function(data){
              
                if(data == 1){
                    alert('Completion for Site visit SMS Sent Successfully!');
                    window.location.reload();
                }
            });
        }

     });


      $("#smsbooked_single").on('click', function(){

        var checkedstatus = $('input[name=leadcheck]:checked').val();
        if(checkedstatus == undefined){
            alert('Select one lead from the table.');
        }
        else{
          $('#bookedindleadno').html('');
          checkedstatus = checkedstatus.split('/');
         $('#bookedindleadno').html(checkedstatus[0]);
              $("#myModalLabelbooked").html("Booked Indicator");
          
           
        $('#myModalbooked').modal('show'); 
        }

     });


      $("#bookedsingle").on('click', function(){

        var checkedstatus = $('input[name=leadcheck]:checked').val();
        if(checkedstatus == undefined){
            alert('Select one lead from the table.');
        }
        else{
          checkedstatus = checkedstatus.split('/');
         $.post('/employeezone/sendsmsforleads',{_token:'{{csrf_token()}}',leadno: checkedstatus[0],type:'smsbooked_single'}, function(data){
              
                if(data == 1){
                    alert('Booked Indicator SMS Sent Successfully!');
                    window.location.reload();
                }
            });
        }

     });

       $("#leadsfollowbtn").on('click', function(){

        var checkedstatus = $('input[name=leadcheck]:checked').val();
        if(checkedstatus == undefined){
            alert('Select one lead from the table.');
        }
        else{
          checkedstatus = checkedstatus.split('/');

           var row = $("#example input[name=leadcheck]:checked").closest('tr');

           var seleclted_obj = {};
           seleclted_obj.c_date = $.trim(row.find('#c_date').text());
           seleclted_obj.projectid = $.trim(row.find('#projectid').text());
           seleclted_obj.desc = $.trim(row.find('#desc').text());
           seleclted_obj.leadno = $.trim(row.find('#leadno').text());
           seleclted_obj.leadname = $.trim(row.find('#leadname').text());
           seleclted_obj.leadstage = $.trim(row.find('#leadstage').text());
           seleclted_obj.leadsource = $.trim(row.find('#leadsource').text());
           seleclted_obj.teleno = '';
           seleclted_obj.mailid = $.trim(row.find('#mailid').text());
           seleclted_obj.leadtype = $.trim(row.find('#leadtype').text());
           seleclted_obj.subleadtype = $.trim(row.find('#subleadtype').text());
           seleclted_obj.budgetrange = $.trim(row.find('#budgetrange').text());
           seleclted_obj.crby = $.trim(row.find('#crby').text());
           seleclted_obj.crtime = $.trim(row.find('#crtime').text());
           seleclted_obj.refby = $.trim(row.find('#refby').text());
           seleclted_obj.salmanager = $.trim(row.find('#salmanager').text());
           seleclted_obj.smsgreet = ($.trim(row.find('#smsgreet')[0].innerHTML).indexOf('checked') > 0)?true:false;
           seleclted_obj.inv_sitevisit = ($.trim(row.find('#inv_sitevisit')[0].innerHTML).indexOf('checked') > 0)?true:false;
           seleclted_obj.schedule_sitevisit = ($.trim(row.find('#schedule_sitevisit')[0].innerHTML).indexOf('checked') > 0)?true:false;
           seleclted_obj.comp_sitevisit = ($.trim(row.find('#comp_sitevisit')[0].innerHTML).indexOf('checked') > 0)?true:false;
           seleclted_obj.quo_email = ($.trim(row.find('#quo_email')[0].innerHTML).indexOf('checked') > 0)?true:false;
           seleclted_obj.book_ind = ($.trim(row.find('#book_ind')[0].innerHTML).indexOf('checked') > 0)?true:false;
           seleclted_obj.leadfromtele = ($.trim(row.find('#leadfromtele')[0].innerHTML).indexOf('checked') > 0)?true:false;
  
           //console.log(seleclted_obj);
                     var now = new Date();
var time = now.getTime();
time += 3600 * 1000;
now.setTime(time);

    document.cookie = 
'selectedlead='+JSON.stringify(seleclted_obj)+'; expires=' + now.toUTCString() + 
'; path=/'; 

          window.location.href="/employeezone/leadsfollowreference/{{$type}}/"+checkedstatus[0];
        }

     });



        $("#availstatussingle").on('click', function(){

          var plantcodeavail = $("#aprojectno").val();
          if (plantcodeavail != '') {
          window.location.href="/employeezone/availstatus/"+plantcodeavail;
        }
        

     });

          $("#esalesdiarybtn").on('click', function(){

          //checkedstatus = checkedstatus.split('/');
          window.location.href="/employeezone/esalesdiary/{{$type}}";
        

     });


        
        

       $("#smsemailsms_single").on('click', function(){
        
        var checkedstatus = $('input[name=leadcheck]:checked').val();
        if(checkedstatus == undefined){
            alert('Select one lead from the table.');
        }
        else{
          $("#myModalLabelemail").html("Email/SMS for quotation");
          
           
        $('#myModalemail').modal('show'); 
        }
    });

         $("#avail_status").on('click', function(){
      
          $("#myModalLabelavailstatus").html("Availability Status");
          
           
        $('#myModalavailstatus').modal('show'); 
        
    });

        $("#quotation").on('click', function(){
        
        var checkedstatus = $('input[name=leadcheck]:checked').val();
        if(checkedstatus == undefined){
            alert('Select one lead from the table.');
        }
        else{
          checkedstatus = checkedstatus.split('/');
          
          $("#myModalLabelquotation").html("View Quotation");
          $("#qleadno").val(checkedstatus[0]);
          $("#qleadname").val(checkedstatus[1]);
           
        $('#myModalquotation').modal('show'); 
        }
    });



    
</script>




@endsection
