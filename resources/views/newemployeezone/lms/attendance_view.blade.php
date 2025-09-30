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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">


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
    .padd_col{
      padding: 3px 11px;
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
  background-image: url("{{ config('app.AWS_URL')}}/images/Preloader.gif");
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
                            <button type="submit" class="btn btn-danger" >Submit</button>
                            </div>
                            
                         </div>               
                <br>
                <br>
                
                 <div class="row" style="margin-left:3px;margin-top: 15px;">
                <div class="col-md-12">
                <div class="panel panel-default">
                <div class="panel-heading widget-user-header bg-red box-title text-center"><h4>{{$summarytitle}}</h4></div>
                <div class="panel-body">
                	
					<!--<marquee direction="left" scrollamount="3" onmouseover="this.stop();" onmouseout="this.start();">
    <p><b><i class="fa fa-info-circle"></i> Leaves/Attendances taken during period from 26.06.2018 to 15.07.2018 will be updated  end of the month.</b></p>
  
    </marquee> -->
					
                  <div class="col-md-3">
                          <ul class="nav nav-stacked">
                        <li><a href="#" style="background:#faebd7;border-bottom: 1px dashed #fff;">{{$workdaystext}} <span class="pull-right badge bg-blue padd_col">{{$summary['total_days']}}</span></a></li>
                        <li><a href="#" style="background:#faebd7;border-bottom: 1px dashed #fff;">Present <span class="pull-right badge bg-green padd_col">{{$summary['present']}}</span></a></li>
                        <li><a href="#" style="background:#faebd7;border-bottom: 1px dashed #fff;">Absent <span class="pull-right badge bg-red padd_col">{{$summary['absent']}}</span></a></li>
                        <li><a href="#" style="background:#faebd7;border-bottom: 1px dashed #fff;">Loss Of Pay <span class="pull-right badge bg-red padd_col">{{$summary['LOP']}}</span></a></li>
                        
                      </ul>
                  </div>

                  <div class="col-md-3">
                  <ul class="nav nav-stacked">
                        <li><a href="#" style="background:#faebd7;border-bottom: 1px dashed #fff;">Casual Leave <span class="pull-right badge bg-blue">{{$summary['CL']}}</span></a></li>
                        <li><a href="#" style="background:#faebd7;border-bottom: 1px dashed #fff;">Sick Leave <span class="pull-right badge bg-blue">{{$summary['SL']}}</span></a></li>
                        <li><a href="#" style="background:#faebd7;border-bottom: 1px dashed #fff;">Earned Leave <span class="pull-right badge bg-blue">{{$summary['PL']}}</span></a></li>
                        <li><a href="#" style="background:#faebd7;border-bottom: 1px dashed #fff;">Permission <span class="pull-right badge bg-blue">{{$summary['Permission']}}</span></a></li>
                        @if($summary['RH'] != 0)<li><a href="#" style="background:#faebd7;border-bottom: 1px dashed #fff;">Restricted Holiday <span class="pull-right badge bg-blue">{{$summary['RH']}}</span></a></li>@endif
                        @if($summary['ML'] != 0)<li><a href="#" style="background:#faebd7;border-bottom: 1px dashed #fff;">Maternity Leave <span class="pull-right badge bg-blue">{{$summary['ML']}}</span></a></li>@endif
                      </ul>
                  </div>
                  <div class="col-md-3">
                  <ul class="nav nav-stacked">
                        <li><a href="#" style="background:#faebd7;border-bottom: 1px dashed #fff;">Onduty  <span class="pull-right badge bg-purple">{{$summary['Onduty']}}</span></a></li>
                        <li><a href="#" style="background:#faebd7;border-bottom: 1px dashed #fff;">Tour  <span class="pull-right badge bg-purple">{{$summary['Tour']}}</span></a></li>
                        <li><a href="#" style="background:#faebd7;border-bottom: 1px dashed #fff;">Compensatory Off <span class="pull-right badge bg-purple">{{$summary['Compoff']}}</span></a></li>
                        <li><a href="#" style="background:#faebd7;border-bottom: 1px dashed #fff;">Mispunch <span class="pull-right badge bg-purple">{{$summary['Mispunch']}}</span></a></li>
                        
                      </ul>
                  </div>

                  <div class="col-md-3">
                  <ul class="nav nav-stacked">
                        <li><a href="#" style="background:#faebd7;border-bottom: 1px dashed #fff;">Late Count  <span class="pull-right badge bg-red">{{$summary['latecount']}}</span></a></li>
                        <li><a href="#" style="background:#faebd7;border-bottom: 1px dashed #fff;">Early Out Count <span class="pull-right badge bg-red">{{$summary['earlyoutcount']}}</span></a></li>
                        <li><a href="#" style="background:#faebd7;border-bottom: 1px dashed #fff;">Late/early out deduction <span class="pull-right badge bg-red">{{$summary['late_earlyout_lop']}}</span></a></li>
                        
                      </ul>
                  </div>
                  
                
                
                </div>
              </div>
                </div>
                </div> 
                
                
               
                   <div class="row" style="margin-left:3px;">
                       <div class="col-md-12">
                           
                            <table id="example1" class="table table-bordered table-striped dataTable" cellspacing="0" width="100%" style="text-align:center;">
        <thead>
            <tr>
                
        <th>Date</th>
        <th>Shift Time</th>
        <th>Punch Details</th>
        <th>Late In</th>
        <th>Early Out</th>
        <th>Leave Applications</th>
        <th>First Half Deduction</th>
        <th>Second Half Deduction</th>
        <th>Absent</th>
        <th>Present</th>
        
            </tr>
        </thead>
       
        <tbody>
          @if(count($attendance) > 0)
            @foreach($attendance as $key => $data)
              <tr>
                <td>{{ Carbon\Carbon::parse($data['shift_date'])->format('d.m.Y')}}
                  <br>
                  {{ Carbon\Carbon::parse($data['shift_date'])->format('l')}}
                </td>
                <td>{{ Carbon\Carbon::parse($data['shift_startdatetime'])->format('H:i')}} to {{ Carbon\Carbon::parse($data['shift_enddatetime'])->format('H:i')}}</td>
                
                  @if(!empty($data['punchlist']))
                  <?php
                  $punches = '';
                  foreach($data['punchlist'] as $k=>$v){
                  $punches .= Carbon\Carbon::parse($v)->format('d.m.Y h:i:s A').'<br>'; 
                  } ?>
                  <td class="column1" id="{{ Carbon\Carbon::parse($data['shift_date'])->format('Y-m-d')}}" data-html="true" title="{{$punches}}">
                  IN: {{Carbon\Carbon::parse($data['punchlist'][0])->format('H:i:s')}}<br>
                  OUT: {{Carbon\Carbon::parse($data['punchlist'][count($data['punchlist']) - 1])->format('H:i:s')}}
                  @else
                  <td title="No Punches!">

                  @endif
                </td>
                
                @if($data['latecount'] != 0) <td style="background: #e06767;color: #fff;"> {{$data['latein_hours']}} @else <td>@endif</td>
                @if($data['earlyoutcount'] != 0) <td style="background: #e06767;color: #fff;"> {{$data['earlyoutcount']}} @else <td> @endif</td>
                <td>
                @if(!empty($data['lms_applications']))
                 @foreach($data['lms_applications'] as $k => $v)
                  {{$v->type}} - @if($v->partial_days == 'full') Full Day @elseif($v->partial_days == 'first_half') First Half @else Second Half @endif<br>
                 @endforeach
                @endif
                </td>
                <td>@if($data['first_half_lop'] != 0){{$data['first_half_lop']}}@endif</td>
                <td>@if($data['second_half_lop'] != 0){{$data['second_half_lop']}}@endif</td>
                <td>@if($data['absent'] != 0){{$data['absent']}}@endif</td>
                <td>{{$data['present']}}</td>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
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
   $('#example1').tooltip({
      content: function() {
        var element = $( this );
        console.log(element);
        if ( element.is( "[title]" ) ) {
          return element.attr( "title" );
        }
      },
     show: {
         effect: "slideDown",
         delay: 250
       },
       hide: {
         effect: "explode",
         delay: 250
       }
   });

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
    var table = $('#example1').DataTable( {
        searching: false,
        paging: false,
        rowReorder: false,
        responsive: true
    } );

        
    
} );    
    
</script>




@endsection
