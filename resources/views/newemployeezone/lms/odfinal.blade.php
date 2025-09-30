@extends('newemployeezone.layout') @section('title') VGN Projects Estates Pvt Ltd |Employee Zone| Leave Management System | Request OnDuty Application
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
                <label>Onduty Date</label>
                <input type="hidden" name="leave_type" value="Onduty" required>

                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control pull-right" name="leave_date_range" readonly='true' id="leave_date_range" value="{{old('leave_date_range')}}" >
                  
                  
                </div>
                {!! $errors->first('leave_date_range', '<span class="errortext text-red">:message</span>') !!}
                <span class="help-block">Note: Date will be refreshed on every page load. Select Proper Date range.</span>
                <!-- /.input group -->
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
                  <label>Onduty Period</label>
                  <input type="text" class="form-control" name="od_period" id="od_period" readonly value="" required>
                  {!! $errors->first('od_period', '<span class="errortext text-red">:message</span>') !!}
                </div>

                   </div>
                 </div> 

                    
                 

                 <div class="row" id="partial_days_div">
                   <div class="col-lg-8  col-lg-offset-2">
                   <div class="formloader" id="formloader" style="text-align:center;" >
            <img src="{{ config('app.AWS_URL')}}/images/formloader.gif" alt="formloader" style="width:60px;">
            </div>

                     <div class="form-group">
                  <label>Punches Reference</label>
                  <div id="punches_ref">
                  <div class="form-group" id="punch_ref">
                  
                  </div
                  </div>
                </div>

                   </div>
                 </div> 

                 

                 <div class="row">
                 <div class="col-lg-8  col-lg-offset-2">
                 <p id="cal" class="text-success text-bold"></p>
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
                <div class="formloader" id="formloader1" style="text-align:center;" >
            <img src="{{ config('app.AWS_URL')}}/images/formloader.gif" alt="formloader" style="width:60px;">
            </div>
                <a id="leave_submit" class="btn btn-primary pull-right">Submit</a>
              </div>
            </form>


            <div class="row"   style="margin-right:0px; margin-left:0px;">
            <div class="col-lg-12" id="instructions">
            <ol>
              <h4>Instructions:</h4>
              <li>Visiting site/official purpose must apply their On-duty the same day or past 3 days based on their biometric punches and it should be approved.</li>
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
function updatepunches(startdate, partial_days) {
  $("#formloader").show();
var startdateformat = startdate.split('/');
var newformat = startdateformat[2]+'-'+startdateformat[1]+'-'+startdateformat[0];
    
  
        $.each($("#shift_time_to_compensate option" ) , function( key, value ) {
            if($(this).val() != '' ){
                $(this).remove();
            }
        });
       
        
        $.post('/employeezone/lms/getfinaloneodpunch',{_token:'{{csrf_token()}}',startdate: newformat, partial_days: partial_days}, function(data){
            //console.log(data);
            $("#formloader").hide();
            $("#od_period").val(data.startpunch+" to "+data.endpunch);
            $("#punches_ref").html('No records found!');
            console.log(data);
            if (data.punches.length != 0) {
              
              var res = '';
              
                $.each( data.punches, function( key, value ) {

                        
                    if(value.val_name != undefined){
                        
                   // $("#startpunch").append( $('<option></option>').val(value.Date +' '+ value.Time).html(value.Date +' '+ value.Time) );
                    //$("#endpunch").append( $('<option></option>').val(value.Date +' '+ value.Time).html(value.Date +' '+ value.Time) );
                      //res += '<p>'+value.val_name+', '+value.terminal_name+'</p>';
                      res += `
                      <div class="radio">
                    <label>
                      <input type="radio" name="punch_ref" id="punch_ref" value="`+value.key+`">
                      `+value.val_name+`, `+value.terminal_name+`
                    </label>
                  </div>
                      `;
                                                           
                        $("#punch_ref").attr("required",true);
                    }
                    $("#punches_ref").html(res);

                    });

            }

        });

        
}


 var od_date = $('#leave_date_range').val();

 if (od_date != '') {
    
     updatepunches(od_date);

     @if(old('shift_time_to_compensate') != '')
     console.log("{{old('shift_time_to_compensate')}}");
     setTimeout(function(){
         $("#shift_time_to_compensate option[value='{{old('shift_time_to_compensate')}}']").attr("selected", "selected");
     }, 2000);
        
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
      
      
      $("#sickleavefile_div").hide();
      $("#formloader1").hide();
      $("#maternity_div").hide();

$("#leave_submit").on('click', function( event ) {
        $("#formloader1").show();
        event.preventDefault();
        var r = confirm("Please confirm if everything entered is correct?");
        if (r == true) {
          $("#leave_submit").addClass('disabled');
          setTimeout(() => {
            $( "#leaveform" ).submit();
            
          }, 2000);        
        }else{
          $("#formloader1").hide();          
        }
});
           
//Date picker
$('#leave_date_range').datepicker({
      autoclose: true,
      format: 'dd/mm/yyyy',
      startDate: '-31d',
      endDate: 'today'
    });

   
    $('#partial_days').on("change", function(){
      var partial_days = $(this).val();
      var leave_date_range = $('#leave_date_range').val();

      if ((leave_date_range != '') && (partial_days != '') ) {
        updatepunches(leave_date_range, partial_days);
      }

    });
    


    

      $('#leave_date_range').on("change", function(){
         //var shiftworked = $(this).val();
         var startdate = $("#leave_date_range").val();
         var partial_days = $("#partial_days").val();

         if ((startdate != '') && (partial_days != '')) {
             
            updatepunches(startdate, partial_days);
         }
         
        
         //updatepunches(startdate, $enddate);
        
     });
           

    })
  </script>
  @endsection
