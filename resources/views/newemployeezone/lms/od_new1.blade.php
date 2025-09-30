@extends('newemployeezone.layout') @section('title') VGN Projects Estates Pvt Ltd |Employee Zone| Leave Management System | Onduty Application
Page @endsection @section('description')
<meta name="description" content=""> @endsection @section('keyword')
 @endsection 
@section('style')
 @include('newemployeezone.styles.commoncss')
   <!-- bootstrap datepicker -->
   <link rel="stylesheet" href="{{ config('app.AWS_URL')}}/newcustomerzoneassets/bower_components/bootstrap-daterangepicker/daterangepicker.css">
<style>
    .maximg{
    max-width:120px;
    max-height:120px;
  }

   /* Preloader */

#preloader {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #fff;
  /* change if the mask should have another color then white */
  z-index: 99;
  /* makes sure it stays on top */
}

#status {
  width: 200px;
  height: 200px;
  position: absolute;
  left: 50%;
  /* centers the loading animation horizontally one the screen */
  top: 50%;
  /* centers the loading animation vertically one the screen */
  background-image: url("{{ config('app.AWS_URL')}}/images/Preloader.gif");
  /* path to your loading animation */
  background-repeat: no-repeat;
  background-position: center;
  margin: -100px 0 0 -100px;
  /* is width and height divided by two */
}
</style>

@endsection
 @section('bodycontent')

<body class="hold-transition skin-red fixed sidebar-mini">
  <!-- Site wrapper -->
  <div class="wrapper">

    @foreach($getemployeedata as $employee)
    
     @include('newemployeezone.header.index') @include('newemployeezone.aside.index')


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div id="preloader">
  <div id="status">&nbsp;</div>
</div>
      
      <section class="content">

       <div class="row">
		<div class="col-md-10 col-md-offset-1">

	@include('newemployeezone.contenttop')


      	</div>
  </div>

      <section class="content-header">
        <h1>
          Leave Management System
          <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
          <li>
            <a href="#">
              <i class="fa fa-dashboard"></i> Home</a>
          </li>
          <li>My Leaves & Approvals</li>
          <li class="active">Leave Management System</li>
        </ol>
      </section>
        
        <div class="row" style="margin-top:55px;">
        <div class="col-md-6 col-md-offset-3" style="margin-top:5px;">

           @if(session()->has('error_msg'))
                <div class="row" id="error_box">
                    <div class="col-lg-8 col-lg-offset-2">

                    <div class="box box-danger box-solid">
                    <div class="box-header with-border">
              <h3 class="box-title">Error</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
              <!-- /.box-tools -->
            </div>
            <div class="box-body">
                <ol>
                @foreach(Session::get('error_msg') as $k => $v)
                <li>{{$v}}</li>
                @endforeach
                </ol>
</div>
              </div>
              
                    </div>

                </div>
                @endif

                 @if(session()->has('suc_msg'))
                <div class="row" id="error_box">
                    <div class="col-lg-8 col-lg-offset-2">

                    <div class="box box-success box-solid">
                    <div class="box-header with-border">
              <h3 class="box-title">Success</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
              <!-- /.box-tools -->
            </div>
            <div class="box-body">
            <p>{{Session::get('suc_msg')}}</p>
            </div>
              </div>
              
                    </div>

                </div>
                @endif
        <div class="box box-primary card">
            <div class="box-header with-border">
              <h2 class="box-title">Onduty Application</h2>
              <a href="{{url('/employeezone/leavemanagementsystem')}}" class="pull-right btn btn-danger btn-sm ad-click-event" ><i class="fa fa-backward"></i> LMS Home Page</a>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" id="leaveform" autocomplete="off" method="post" action="{{url('/employeezone/lms/employee_request_application/')}}/{{$id}}" enctype="multipart/form-data">
            {{csrf_field()}}
              <div class="box-body">

               

              

                <div class="row" id="leave_date_range_div">

                <div class="col-lg-8  col-lg-offset-2">
                <div class="form-group">
                <label>Onduty range:</label>

                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control pull-right" name="leave_date_range" id="leave_date_range" value="{{old('leave_date_range')}}" >
                  
                  
                </div>
                {!! $errors->first('leave_date_range', '<span class="errortext text-red">:message</span>') !!}
                <span class="help-block">Note: Select the exact start or end date time, where the punches available</span>
                <!-- /.input group -->
              </div>
                </div>

               
                </div>

                <div class="row">
                <div class="col-lg-8  col-lg-offset-2">
                <div class="form-group">
                                <label>Punches Reference</label>
                                <div id="punches_ref">
                                <p>Nil</p>
                                </div>
                                </div>
                </div>
                </div>
      

                  <div class="row" id="partial_days_div">
                   <div class="col-lg-8  col-lg-offset-2">

                     <div class="form-group">
                  <label>Partial Days</label>
                  <select class="form-control" name="partial_days" id="partial_days">
                    <option value="" >Select</option>
                    @if(!empty($partial_days_array))
                      @foreach($partial_days_array as $partial_days_array_key => $partial_days_array_value)
                        <option value="{{$partial_days_array_key}}" @if(old('partial_days') == $partial_days_array_key) {{ 'selected' }} @endif>{{$partial_days_array_value}}</option>
                      @endforeach
                    @endif

                    
                  </select>
                  {!! $errors->first('partial_days', '<span class="errortext text-red">:message</span>') !!}
                </div>

                   </div>
                 </div> 

                  <div class="row" id="partial_days_div">
                   <div class="col-lg-8  col-lg-offset-2">

                     <div class="form-group">
                  <label>From Place</label>
                  <input type="text" class="form-control" name="from_address" id="from_address">
                  {!! $errors->first('from_address', '<span class="errortext text-red">:message</span>') !!}
                </div>

                   </div>
                 </div> 
                 <div class="row" id="partial_days_div">
                   <div class="col-lg-8  col-lg-offset-2">

                     <div class="form-group">
                  <label>To Place</label>
                  <input type="text" class="form-control" name="to_address" id="to_address">
                  {!! $errors->first('to_address', '<span class="errortext text-red">:message</span>') !!}
                </div>

                   </div>
                 </div> 

                   <div class="row" id="partial_days_div">
                   <div class="col-lg-8  col-lg-offset-2">

                     <div class="form-group">
                  <label>Mode Of Transport</label>
                  <select class="form-control" name="mode_of_transport" id="mode_of_transport">
                  <option value="" >Select</option>
                  <option value="Bike" >By Bike</option>
                  <option value="Car" >By Car</option>
                  <option value="Walk" >By Walk</option>
                  <option value="Other" >Other</option>
                  </select>
                  {!! $errors->first('mode_of_transport', '<span class="errortext text-red">:message</span>') !!}
                </div>

                   </div>
                 </div> 

                 <div class="row" id="leave_reason_div">
                   <div class="col-lg-8  col-lg-offset-2">
                 <div class="form-group">
                  <label>Reason</label>
                  <textarea class="form-control" rows="3" placeholder="Onduty reason ..." name="leave_reason" id="leave_reason">{{old('leave_reason')}}</textarea>
                  {!! $errors->first('leave_reason', '<span class="errortext text-red">:message</span>') !!}
                </div>
                </div>
                 </div> 



                 
                
                 
                 
                
                
              </div>
              <!-- /.box-body -->

              <div class="box-footer ">
              <div class="formloader" id="formloader" style="text-align:center;" >
            <img src="{{ config('app.AWS_URL')}}/images/formloader.gif" alt="formloader" style="width:60px;">
            </div>
                <a id="leave_submit" class="btn btn-primary pull-right">Submit</a>
              </div>
            </form>


            <div class="row"  style="margin-left:5px;">
            <div class="col-lg-12">
            <h3>Instructions:</h3>
            <ol>
              <h4>Onduty</h4>
              <li>
                <p>Visiting site/official purpose must apply their on duty the same day or next day in the LMS portal based on their biometric punches and it should be approved by the HOD/HR.</p>
              </li>
            </ol>
            </div>
          </div>

          </div>

          

      </div>
        </div>
        
        @endforeach

        
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <footer class="main-footer">
      <div class="pull-right hidden-xs">
        <b>Version</b> 2.4.0
      </div>
      <strong>Copyright &copy; 2019
        <a href="http://www.vgn.in">VGN Property Developers Pvt. Ltd</a>.</strong> All rights reserved.
    </footer>


    <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>
  </div>
  <!-- ./wrapper -->



  @endsection 
  @section('script')
   @include('newemployeezone.js.commonjs')
   <script src="{{ config('app.AWS_URL')}}/newcustomerzoneassets/bower_components/moment/min/moment.min.js"></script>
   <!-- bootstrap datepicker -->
<script src="{{ config('app.AWS_URL')}}/newcustomerzoneassets/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<script>
function updatepunches(startdate) {
  $("#formloader").show();
  //console.log(startdate);
  
  
  
        $.each($("#shift_time_to_compensate option" ) , function( key, value ) {
            if($(this).val() != '' ){
                $(this).remove();
            }
        });
       
        
        $.post('/employeezone/lms/getodpunches',{_token:'{{csrf_token()}}',startdate: startdate}, function(data){
            console.log(data);
            $("#formloader").hide();
            $("#punches_ref").html('No records found!');
            if (data[0].length != 0) {
              
              var res = '';

                $.each( data[0]['punches'], function( key, value ) {

                        console.log(value);
                    if(value != undefined){
                        
                   // $("#startpunch").append( $('<option></option>').val(value.Date +' '+ value.Time).html(value.Date +' '+ value.Time) );
                    //$("#endpunch").append( $('<option></option>').val(value.Date +' '+ value.Time).html(value.Date +' '+ value.Time) );
                      res += '<p>'+value+'</p>';
                                                           

                    }
                    $("#punches_ref").html(res);

                    });

            }

        });

        
}
</script>
  <script>
 
 $(window).on('load', function() { 
  setTimeout(function() {
     // makes sure the whole site is loaded 
  $('#status').fadeOut(); // will first fade out the loading animation 
  $('#preloader').delay(600).fadeOut('slow'); // will fade out the white DIV that covers the website. 
  $('body').delay(600).css({'overflow':'visible'});
  }, 1000);
 
})

    $(document).ready(function () {
      $('.sidebar-menu').tree();
      $( "#leave_bal_text" ).hide();
      $("#formloader").hide();

      $("#leave_submit").on('click', function( event ) {
        $("#formloader").show();
        event.preventDefault();
        var r = confirm("Please confirm if everything entered is correct?");
        if (r == true) {
          $("#leave_submit").addClass('disabled');
          setTimeout(() => {
            $( "#leaveform" ).submit();
            
          }, 2000);        
        }

        //$("#formloader").hide();   
});

      var leavetype = $("#leave_type").val();
      
      
      $("#sickleavefile_div").hide();
      $("#maternity_div").hide();
           

      $('#leave_date_range').daterangepicker(
        {
          locale: {
            format: 'DD/MM/YYYY h:mm A'
        },
        timePicker: true, timePickerIncrement: 1,
       
        @if(old('leave_date_range') != '')
        <?php $sp = explode('-', old('leave_date_range')); ?>
        startDate: "{{$sp[0]}}",
        endDate  : "{{$sp[1]}}"
        @else
        startDate: moment(),
        endDate  : moment()
        @endif
        
        }
      );


//start

var leave_date_range = $("#leave_date_range").val();
if(leavetype != ''){
    updatepunches(leave_date_range);
}



      $("#leave_date_range").on("change", function(){
        
        var leave_date_range = $(this).val();
        var leave_type = $("#leave_type").val();
       if(leave_type != ''){
        
                
        updatepunches(leave_date_range);
        
       
        }

      });

      $("#partial_days").on("change", function(){
        
        var leave_date_range = $("#leave_date_range").val();
        var leave_type = $("#leave_type").val();
        var partial_days = $("#partial_days").val();
       if(partial_days != ''){
        
        updatepunches(leave_date_range);
       
        }

      })

     


//end


      

    })
  </script>
  @endsection
