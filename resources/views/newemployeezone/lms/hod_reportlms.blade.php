@extends('newvendorzone.layout')

@section('title')
VGN Projects Estates Pvt Ltd |Employee Zone| HOD Report Page
@endsection

@section('description')
    <meta name="description" content="">
@endsection

@section('keyword')  
@endsection


@section('style')
@include('newvendorzone.styles.commoncss')
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


 
  @include('newemployeezone.header.index')
  @include('newemployeezone.aside.index')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
   
    <!-- Main content -->
    <section class="content">
	
	<div class="row">
		<div class="col-md-10 col-md-offset-1">

	@include('newemployeezone.contenttop')


      	</div>
	</div>



	<div class="row">
		
    <div class="col-md-10 col-md-offset-1">
      
      <div class="box box-danger">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-file margin-r-5"></i> Leave Report </h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              
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
                
                
                <form class="form-horizontal" method="post" action="{{url('/employeezone/lms/hodreport')}}" style="margin:0 5% !important;text-align:none !important;">
										{{csrf_field()}}
					
                                        <div class="row" id="leave_date_range_div">

<div class="col-lg-6  col-lg-offset-3">
<div class="form-group">
<label>Report Date range:</label>

<div class="input-group">
  <div class="input-group-addon">
    <i class="fa fa-calendar"></i>
  </div>
  <input type="text" class="form-control pull-right" name="leave_date_range" id="leave_date_range" value="{{old('leave_date_range')}}" >
  
  
</div>
{!! $errors->first('leave_date_range', '<span class="errortext text-red">:message</span>') !!}
<!-- /.input group -->
</div>
</div>


</div>

    <div class="row" id="employee_div">
                   <div class="col-lg-6  col-lg-offset-3">

                     <div class="form-group">
                  <label>Select Employee</label>
                  <select class="form-control" name="employee" id="employee">
                    <option value="" >Select</option>
                    @if(!empty($getsubordinates))
                    @foreach($getsubordinates as $emp)
                    <option value="{{$emp['empid']}}" >{{$emp['empname']}}</option>
                    @endforeach
                    @endif
                    <option value="all" >All</option>
                  </select>
                  {!! $errors->first('employee', '<span class="errortext text-red">:message</span>') !!}
                </div>

                   </div>
                 </div> 

                 <div class="row" id="employee_div">
                   <div class="col-lg-6  col-lg-offset-3">

                    <button type="submit" id="leave_submit" class="btn btn-primary pull-right"><i class="fa fa-send"></i> Generate</button>

                   </div>
                 </div>
											
				
              
            
            
              
            </div>
            <!-- /.box-body -->
            
              </form>
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
      
      
      $("#sickleavefile_div").hide();
      $("#maternity_div").hide();
           

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
