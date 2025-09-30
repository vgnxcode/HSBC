@extends('newemployeezone.layout')

@section('title')
VGN Projects Estates Pvt Ltd |Employee Zone| My Attendance Page
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
    
    
     .issunday{
      /* background: #FFE57F !important; */
      font-weight: 600;
  }
  .issecondsat{
      /* background: #FFCD94 !important; */
      font-weight: 600;
  } 
    .holiday{
        background: coral !important;
        font-weight: 600;
    }
    .late{
      background: #fd8e8e !important;
      font-weight: bold;
    }
    .early{
      background: #fd8e8e !important;
      font-weight: bold;
    }

</style>
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
  background-image: url({{url('/images/Preloader.gif')}});
  /* path to your loading animation */
  background-repeat: no-repeat;
  background-position: center;
  margin: -100px 0 0 -100px;
  /* is width and height divided by two */
}

.margintop30px {
  margin-top: 30px;
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
    <div id="preloader">
  <div id="status">&nbsp;</div>
</div>
    <!-- Main content -->
    <section class="content">
	
	<div class="row" id="content_topdiv">
		<div class="col-md-10 col-md-offset-1">

	@include('newemployeezone.contenttop')


      	</div>
	</div>



	<div class="row" id="content_div">
		
    <div class="col-md-12">
      
      <div class="box box-danger">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-calendar margin-r-5"></i> My Attendance </h3> 
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
                
                 <form id="changedetailsForm" method="POST" action="{{ url('/employeezone/lms/attendance_view') }}" class="form-horizontal" >
                {{ csrf_field() }}
                
                
                    <div class="col-md-12">
                        <label for="monthname" class="col-md-2 control-label">Select Month/Year</label>
                            
                            <div class="col-md-4">
                                
                               <select class="form-control" name="monthname" style="margin-bottom:5px;">
                                   <option value="">Select</option>
                                    @foreach($montharray as $vv => $month)
        <option value="{{ $month }}" @if($month == $currentmonth) selected = selected @endif >{{ $month }}</option>
                                   @endforeach
																			
                  </select>
                           
                            </div>
                            <div class="col-md-4">
                             <select class="form-control" name="yearname" style="margin-bottom:5px;">
                             <option value="">Select</option>
                   @foreach($yeararray as $kk => $year)
                                 <option value="{{ $year }}" @if($year == $currentyear) selected = selected @endif >{{ $year }}</option>
                   @endforeach
															
                  </select>
                            </div>
                            <div class="col-md-2">
                            <button type="submit" class="btn btn-danger">Submit</button>
                            </div>
                            
                         </div>               
                <br>
                <br>
                <h3 class="text-center" style="text-decoration:underline;">Attendance for {{$currentmonth}} {{$currentyear}}</h3>
                
                <br>
                
               
                   <div class="row" style="margin-left:3px;">
                       <div class="col-md-12">
                           
                          <table id="example" class="display nowrap" cellspacing="0" width="100%" style="text-align:center;">
        <thead>
            <tr>
                
				<th>Date</th>
				<th>Shift Name</th>
				<th>Shift Start</th>
				<th>Shift End</th>
				<th>Punch In</th>
				<th>Punch Out</th>
            </tr>
        </thead>
       
        <tbody>
           
            @if(count($getattendance) > 0)
													
													@foreach($getattendance as $attendance)
													
												@if($attendance['is_sunday'] == true)
                                                    @if($attendance['holiday_name'] != '')
                                                        <tr class="holiday">
                                                    @else
														<tr class="issunday">
												    @endif
												@else
													@if($attendance['second_saturday'] == true)
													@if($attendance['holiday_name'] != '')
													   <tr class="holiday">
													@else
														<tr class="issecondsat">
												    @endif
														
													@else
													    @if($attendance['holiday_name'] != '')
													    <tr class="holiday">
													    @else
														<tr>
														@endif
													@endif
												@endif
                                                    
                                                    @if($currentdate == $attendance['attendancedate'])
                                                    <td id="todayactive">
                                                    @else
														<td>
												    @endif
														
														{{$attendance['created_date']}}<br>
												@if($attendance['second_saturday'] == true)
														@if($attendance['holiday_name'] != '')
														
														(Second {{$attendance['dayname']}})<br>
														({{$attendance['holiday_name']}} - {{$attendance['holiday_count']}} day)
														
														@else
														(Second {{$attendance['dayname']}})
														@endif
												@else
														
														@if($attendance['holiday_name'] != '')
														
														({{$attendance['dayname']}})<br>
														({{$attendance['holiday_name']}} - {{$attendance['holiday_count']}} day)
														
												        @else
														({{$attendance['dayname']}})
														@endif
												@endif
														</td>														
														<td>{{$attendance['shift_name'] }}</td>														
														<td>{{$attendance['shift_start'] }}</td>														
														<td>{{$attendance['shift_end'] }}</td>														
													<td @if($attendance['is_punchin_deviate'] == true) class="late" @endif>{{$attendance['punch_in'] }}</td>														
														<td @if($attendance['is_punchout_deviate'] == true) class="early" @endif>{{$attendance['punch_out'] }}</td>														
														
														</tr>
														
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
<script>
  $(window).on('load', function() { 
  setTimeout(function() {
     // makes sure the whole site is loaded 
  $('#status').fadeOut(); // will first fade out the loading animation 
  $('#preloader').delay(600).fadeOut('slow'); // will fade out the white DIV that covers the website. 
  $('body').delay(600).css({'overflow':'visible'});
  }, 1000);
 
})
$(document).ready(function() {

    if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
    //console.log('mobile');
    $("#content_topdiv").hide();
    $('#content_div').addClass('margintop30px');
}
else
{
  $("#content_topdiv").show();
  $('#content_div').removeClass('margintop30px');
}
    
    if($("#todayactive").length > 0) {
  $('html, body').animate({ scrollTop: $('#todayactive').offset().top }, 'slow');
}
    var table = $('#example').DataTable( {
        "order": [[ 0, "asc" ]],
        "pageLength": 31,
        rowReorder: false,
        responsive: true
    } );
    
    
} );    
    
</script>




@endsection
