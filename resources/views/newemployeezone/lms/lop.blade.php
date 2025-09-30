@extends('newemployeezone.layout') @section('title') VGN Projects Estates Pvt Ltd |Employee Zone| Leave Management System | Loss Of Pay Application
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
              <h2 class="box-title">Loss of Pay Application</h2>
              <a href="{{url('/employeezone/leavemanagementsystem')}}" class="pull-right btn btn-danger btn-sm ad-click-event" ><i class="fa fa-backward"></i> LMS Home Page</a>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" id="leaveform" autocomplete="off" method="post" action="{{url('/employeezone/lms/lop')}}" enctype="multipart/form-data">
            {{csrf_field()}}
              <div class="box-body">

               <input type="hidden" name="leave_type" id="leave_type" value="LOP" required>

                <div class="row" id="leave_date_range_div">

                <div class="col-lg-8  col-lg-offset-2">
                <div class="form-group">
                <label>Leave Date range:</label>

                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control pull-right" name="leave_date_range" readonly='true' id="leave_date_range" value="{{old('leave_date_range')}}" >
                  
                  
                </div>
                {!! $errors->first('leave_date_range', '<span class="errortext text-red">:message</span>') !!}
                
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

                 <div class="row" id="leave_reason_div">
                   <div class="col-lg-8  col-lg-offset-2">
                 <div class="form-group">
                  <label>Reason</label>
                  <textarea class="form-control" rows="3" placeholder="LOP reason ..." name="leave_reason" id="leave_reason">{{old('leave_reason')}}</textarea>
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


            <div class="row"   style="margin-right:0px; margin-left:0px;">
            <div class="col-lg-12" id="instructions">
            <ol>
              <h4>Instructions:</h4>
              <li>Employee who have no leave balance and going on for leave with the approval of HOD, then they should apply for Loss of Pay.</li>
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
   <script src="{{ config('app.AWS_URL')}}/newcustomerzoneassets/bower_components/moment/min/moment.min.js"></script>
   <!-- bootstrap datepicker -->
<script src="{{ config('app.AWS_URL')}}/newcustomerzoneassets/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<script>
 function updateleavebal (leave_type,leave_date_range,partial_days ) {
        $.post('/employeezone/lms/getleavebalance',{_token:'{{csrf_token()}}',leave_type: leave_type,leave_date_range:leave_date_range}, function(data){
              console.log(data);
              if(data.balance.length  != 0){
              if(data.balance.leave_type != 'undefined'){
                
                console.log(data.difference);
                
                $( "#leave_bal_text" ).fadeIn( "slow", function() {

                  if (leave_type == 'ML') {
                    $( "#maternity_div" ).fadeIn( "slow", function() {
                    $("#maternity_div").show();
                    //$("#sickleavefile").prop('required', true);
                    });
                  }else{
                    $( "#maternity_div" ).fadeOut( "slow", function() {
                    $("#maternity_div").hide();
                   // $("#sickleavefile").prop('required', false);
                    });
                  }
                //$("#leave_bal_text").show();

                if(data.difference > '1'){
                  $( "#partial_days_div" ).fadeIn( "slow", function() {
                    $( "#partial_days_div" ).show();
                  $("#partial_days option[value='first_half']").remove();
                  $("#partial_days option[value='second_half']").remove();
                  });



                  if(data.difference > 2){
                    if(leave_type == 'SL'){
                    $( "#sickleavefile_div" ).fadeIn( "slow", function() {
                    $("#sickleavefile_div").show();
                    //$("#sickleavefile").prop('required', true);
                    });
                    }else{
                      $( "#sickleavefile_div" ).fadeOut( "slow", function() {
                    $("#sickleavefile_div").hide();
                   // $("#sickleavefile").prop('required', false);
                    });
                    }

                  }else{
                    $( "#sickleavefile_div" ).fadeOut( "slow", function() {
                    $("#sickleavefile_div").hide();
                   // $("#sickleavefile").prop('required', false);
                    });
                  }
                }

                if(data.difference == '1'){
                  $( "#partial_days_div" ).fadeIn( "slow", function() {
                    $( "#partial_days_div" ).show();
                    if($("#partial_days option[value='first_half']").length <= 0) {
                      
                      $("#partial_days").append( $('<option></option>').val('first_half').html('First Half') );

                      }
                      if($("#partial_days option[value='second_half']").length <= 0) {
                      
                      $("#partial_days").append( $('<option></option>').val('second_half').html('Second Half') );

                      }
                  
                  
                  });

                   $( "#sickleavefile_div" ).fadeOut( "slow", function() {
                    $("#sickleavefile_div").hide();
                    $("#sickleavefile").prop('required', false);
                    });
                }

                if((data.balance[leave_type] - data.difference) < '0'){
                  $("#leave_balance").text(data.balance[leave_type] - data.difference);
                  $("#available_balance").text(data.balance[leave_type]);
                  
                  if(partial_days == 'first_half'){
                    $("#appliedcount").text(0.5);
                    $("#leave_balance").text((data.balance[leave_type] - data.difference) + 0.5);
                  }
                  if(partial_days == 'second_half'){
                    
                    $("#leave_balance").text((data.balance[leave_type] - data.difference) + 0.5);
                  }
                  if(partial_days == 'full'){
                    
                    $("#leave_balance").text((data.balance[leave_type] - data.difference));
                  }
                  

                }else{
                  $("#leave_balance").text(data.balance[leave_type] - data.difference);
                  $("#available_balance").text(data.balance[leave_type]);
                  
                  if(partial_days == 'first_half'){
                    
                    $("#leave_balance").text(data.balance[leave_type] - 0.5);
                  }
                  if(partial_days == 'second_half'){
                    
                    $("#leave_balance").text(data.balance[leave_type] - 0.5);
                  }
                  if(partial_days == 'full'){
                    
                    $("#leave_balance").text((data.balance[leave_type] - data.difference));
                  }

                
                }
                
                });
              }
              }else{

                   $( "#leave_bal_text" ).fadeIn( "slow", function() {
                $("#leave_bal_text").show();

                if (leave_type != 'ML') {
                  
                
                //$("#leave_balance").text('0');
               // alert('No leave balance Updated for this month. Try start to end date of current month.');
                //window.location.reload();
                }
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

      var leavetype = $("#leave_type").val();
      
      
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
        }else{
          $("#formloader").hide();          
        }
});
           

      $('#leave_date_range').daterangepicker(
        {
          locale: {
            format: 'DD/MM/YYYY'
        },
        ranges   : {
          'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Today'       : [moment(), moment()],
          'Tommorow'   : [moment().add(1, 'days'), moment().add(1, 'days')],          
        },
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
updateleavebal(leavetype, leave_date_range,'0');
}


$("#leave_type").on("change", function(){

  var leave_type = $("#leave_type").val();
  if(leave_type != ''){

    $( "#leave_date_range_div" ).fadeIn( "slow", function() {
      leave_date_range = $("#leave_date_range").val();
      if(leave_date_range != ''){
                
      updateleavebal(leave_type, leave_date_range,'0');
      }
      
    });

  }else{
    $( "#leave_date_range_div" ).fadeOut( "slow", function() {

      
      $("#leave_bal_text").hide();

    });
  }

});

      $("#leave_date_range").on("change", function(){
        
        var leave_date_range = $(this).val();
        var leave_type = $("#leave_type").val();
       if(leave_type != ''){
        
                
        updateleavebal(leave_type, leave_date_range, '0');
        $( "#leave_bal_text" ).show();
       
        }

      });

      $("#partial_days").on("change", function(){
        
        var leave_date_range = $("#leave_date_range").val();
        var leave_type = $("#leave_type").val();
        var partial_days = $("#partial_days").val();
       if(partial_days != ''){
        
        updateleavebal(leave_type, leave_date_range,partial_days);
       
        }

      })

     


//end


      

    })
  </script>
  @endsection
