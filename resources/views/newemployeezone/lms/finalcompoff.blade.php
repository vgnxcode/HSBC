@extends('newemployeezone.layout') @section('title') VGN Projects Estates Pvt Ltd |Employee Zone| Leave Management System | Request Compoff Application
Page @endsection @section('description')
<meta name="description" content=""> @endsection @section('keyword')
 @endsection 
@section('style')
 @include('newemployeezone.styles.commoncss')
   <!-- bootstrap datepicker -->
   <link rel="stylesheet" href="{{ config('app.AWS_URL')}}/newcustomerzoneassets/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
<style>
    .maximg{
    max-width:120px;
    max-height:120px;
  }
  #instructions {
    background: #f1dfc7;
    padding-top: 15px;
    padding-bottom: 10px;
    border-top-right-radius:10px;
    border-top-left-radius:10px;
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
              <h2 class="box-title">Compensatory-off Application</h2>
              <a href="{{url('/employeezone/leavemanagementsystem')}}" class="pull-right btn btn-danger btn-sm ad-click-event" ><i class="fa fa-backward"></i> LMS Home Page</a>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" id="leaveform" autocomplete="off" method="post" action="{{url('/employeezone/lms/compoff')}}" enctype="multipart/form-data">
            {{csrf_field()}}
              <div class="box-body">

               <div class="row" id="leave_date_range_div">

                <div class="col-lg-8  col-lg-offset-2">
                <div class="form-group">
                <label>Compensatory Off Worked Date</label>

                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control pull-right" name="compoff_date_range" readonly='true' id="compoff_date_range" value="{{old('compoff_date_range')}}" >
                  
                  {!! $errors->first('compoff_date_range', '<span class="errortext text-red">:message</span>') !!}
                </div>
                <!-- /.input group -->
              </div>
                </div>

               
                </div>

                <div class="row">
                <div class="formloader" id="formloader" style="text-align:center;" >
            <img src="{{ config('app.AWS_URL')}}/images/formloader.gif" alt="formloader" style="width:60px;">
            </div>
                <div class="col-lg-8  col-lg-offset-2">
                <p id="message"></p>
                </div>
                </div>


                

                 
                  <div class="row" id="leave_requireddate_div">

<div class="col-lg-8  col-lg-offset-2">
<div class="form-group">
<label>Leave Required Date</label>

<div class="input-group">
  <div class="input-group-addon">
    <i class="fa fa-calendar"></i>
  </div>
  <input type="text" class="form-control pull-right" name="leave_date_range" id="leave_date_range" readonly='true' value="{{old('leave_date_range')}}" >
  
  
</div>
{!! $errors->first('leave_date_range', '<span class="errortext text-red">:message</span>') !!}

<!-- /.input group -->
</div>
</div>


</div>
<input type="hidden" name="leave_type" id="leave_type" value="Compoff" required>

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

                
                 <div class="row" id="leave_reason_div">
                   <div class="col-lg-8  col-lg-offset-2">
                 <div class="form-group">
                  <label>Reason</label>
                  <textarea class="form-control" rows="3" placeholder="Leave reason ..." name="leave_reason" id="leave_reason">{{old('leave_reason')}}</textarea>
                  {!! $errors->first('leave_reason', '<span class="errortext text-red">:message</span>') !!}
                </div>
                </div>
                 </div> 
                
              </div>
              <!-- /.box-body -->

              <div class="box-footer ">
              <a id="leave_submit" id="leave_submit" class="btn btn-primary pull-right">Submit</a>
              </div>
            </form>


            <div class="row"   style="margin-right:0px; margin-left:0px;">
            <div class="col-lg-12" id="instructions">
            
            <ol>
              <h4>Compensatory Off</h4>
              <li>C-Off is eligible for employees if he/she works on a non-working day/Hours (Minimum their half day shift timing), If the same is not utilized within 30 days, it will be lapsed.</li>
              <li>If working overtime at night, Employee should punch in between 08:30pm to 09:00pm for SITE and 08:00pm to 08:30pm for office staff and then punch between 12:00am to 1:00am, which is mandatory to avail C-off.</li>
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

@include('newemployeezone.footer')
    <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>
  </div>
  <!-- ./wrapper -->



  @endsection 
  @section('script')
   @include('newemployeezone.js.commonjs')
   <!-- bootstrap datepicker -->
<script src="{{ config('app.AWS_URL')}}/newcustomerzoneassets/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script>
function updatepunches(startdate) {
    $("#message").html('');
    $("#formloader").show();
    document.getElementById("message").className = '';
           
        $.post('/employeezone/lms/getcompoffpunches',{_token:'{{csrf_token()}}',startdate: startdate}, function(data){
            console.log(data);
            if (data.compoffhours != '') {


                $("#message").html(data.message + ' with '+data.eligible+' day!' );
                $("#message").addClass('text-success');
                $("#message").addClass('text-bold');
                if (data.eligible == '0.5') {
                  $('#leave_date_range').datepicker('setStartDate', new Date(data.leavemindate));
                    $("#leave_requireddate_div").show();
                    $("#partial_days_div").show();
                    $("#leave_reason_div").show();
                    $("#leave_submit").show();
                    $("#partial_days option[value='full']").remove();                    
                }
                if (data.eligible == '1') {
                    $("#leave_requireddate_div").show();
                    $('#leave_date_range').datepicker('setStartDate', new Date(data.leavemindate));
                    $("#partial_days_div").show();
                    $("#leave_reason_div").show();
                    $("#leave_submit").show();
                    if($("#partial_days option[value='full']").length <= 0) {
                      
                      $("#partial_days").append( $('<option></option>').val('full').html('Full Day') );

                      }
                    
                }
                if (data.eligible == '0') {
                    $("#leave_requireddate_div").hide();
                    $("#partial_days_div").hide();
                    $("#leave_reason_div").hide();
                    $("#leave_submit").hide();
                    $("#message").html('Compoff not eligible for this date!');
                    $("#message").addClass('text-danger');
                    $("#message").addClass('text-bold');
                   
                    
                }

               

            }
            else{
                $("#leave_requireddate_div").hide();
                $("#partial_days_div").hide();
                $("#leave_reason_div").hide();
                $("#leave_submit").hide();
                $("#message").html(data.message);
                $("#message").addClass('text-danger');
                $("#message").addClass('text-bold');
            }
            $("#formloader").hide();

        });

        
}

 var od_date = $('#compoff_date_range').val();

 if (od_date != '') {
    
     updatepunches(od_date);

     @if(old('compoff_date_range') != '')
     setTimeout(function(){
         $("#compoff_date_range option[value='{{old('compoff_date_range')}}']").attr("selected", "selected");
     }, 1000);
        
     @endif
 }

 var leave_date_range = $('#leave_date_range').val();

if (leave_date_range != '') {
   
    @if(old('leave_date_range') != '')
    setTimeout(function(){
        $("#leave_date_range option[value='{{old('leave_date_range')}}']").attr("selected", "selected");
    }, 1000);
       
    @endif
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
      $("#formloader").hide();

      var leavetype = $("#leave_type").val();
      $("#leave_submit").on('click', function( event ) {
        
        event.preventDefault();
        var r = confirm("Please confirm if everything entered is correct?");
        if (r == true) {
          $("#leave_submit").addClass('disabled');
          setTimeout(() => {
            $( "#leaveform" ).submit();
            
          }, 2000);        
        }
        else{
        $("#formloader").hide();     
        }

        
});
      
      $("#leave_requireddate_div").hide();
      $("#partial_days_div").hide();
      $("#leave_reason_div").hide();
      $("#leave_submit").hide();
           
//Date picker
$('#compoff_date_range').datepicker({
      autoclose: true,
      format: 'dd/mm/yyyy',
      startDate: '-30d',
      endDate: 'today'
    });

    $('#leave_date_range').datepicker({
      autoclose: true,
      format: 'dd/mm/yyyy',
      endDate: '+30d'
    });
    


     $('#compoff_date_range').on("change", function(){
         var startdate = $(this).val();        
         updatepunches(startdate);
        
     });

               

    })
  </script>
  @endsection
