@extends('newemployeezone.layout') @section('title') VGN Projects Estates Pvt Ltd |Employee Zone| Leave Management System | Monthly Late deductions
Page @endsection @section('description')
<meta name="description" content=""> @endsection @section('keyword') @endsection @section('style') @include('newemployeezone.styles.commoncss')
<link rel="stylesheet" href="{{ config('app.AWS_URL')}}/newcustomerzoneassets/bower_components/bootstrap-daterangepicker/daterangepicker.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/rowreorder/1.2.3/css/rowReorder.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.0/css/responsive.dataTables.min.css">
   <!-- Google Font -->
  <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
<style>
  .carousel-inner>.item>img {
    min-height: 280px;
  }
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

.card {
    border: 1px solid;
    padding: 10px;
    box-shadow: 5px 10px #888888;
}
 
  
</style>

@endsection @section('bodycontent')

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

      <div class="row">
		<div class="col-md-10 col-md-offset-1">

	@include('newemployeezone.contenttop')


      	</div>
  </div>


<div class="row">
		
        <div class="col-md-12">
          
          <div class="box box-danger">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-bullhorn margin-r-5"></i>Attendance Report Data</h3>
                    
                    <a href="{{ url('/employeezone/leavemanagementsystem') }}" class="btn btn-danger btn-xs"><i class="fa fa-backward margin-r-5"></i>LMS Dashboard</a></span>
                    
                </div>
                <!-- /.box-header -->
                <div class="box-body">
			<form role="form" id="payrollform" autocomplete="off" method="post" action="{{url('/employeezone/lms/payroll_reportview')}}" enctype="multipart/form-data">
            {{csrf_field()}}
			<div class="row">
				<div class="col-md-12">

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
				</div>
			</div>			
		</form>
                       <div class="row" style="margin-left:3px;">
                           <div class="col-md-12 card">


                           
                <h3 class="text-center">Attendance Report</h3>
                                                          
                              <table id="example" class="display nowrap" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>S. No.</th>
                    <th>Employee Id</th>
                    @foreach($data['column'] as $k => $column)
                    <th>{{$column}}</th>
                    @endforeach

                    <th>CL</th>
                    <th>SL</th>
                    <th>EL</th>
                    <th>ML</th>
                    <th>RH</th>
                    <th>Permission</th>
                    <th>Onduty</th>
                    <th>Tour</th>
                    <th>Mispunch</th>

                    <th>Absent</th>
                    <th>LOP</th>
                    <th>Present</th>

                </tr>
            </thead>
           
            <tbody>
               
                @if(count($data) > 0)
                                                        <?php $count = 1; ?>
                                                        @foreach($data['row'] as $appliedkey => $appliedvalue)
                                                        <?php $m = ''; ?>
                                                        <tr>
                                                        <td>{{$count}}</td>
                                                        <td>{{$appliedkey}}</td>
                                                        
                                                        @foreach($data['column'] as $v => $ncolumn)
                                                          @foreach($data['row'][$appliedkey] as $b => $bvalue)
                                                          <?php $m = $ncolumn; ?>
                                                            @if($ncolumn == $b)
                                                              <td>
                                                                @if(!empty($bvalue['lms_attendance']))
                                                                  @foreach($bvalue['lms_attendance'] as $keykk => $kk)
                                                                  @if($kk == 'Onduty')<?php $kk ='OD'; ?>@endif
                                                                  @if($kk == 'Permission')<?php $kk ='Per'; ?>@endif
                                                                  @if($kk == 'Mispunch')<?php $kk ='Misp'; ?>@endif
                                                                  @if($kk == 'Compoff')<?php $kk ='Coff'; ?>@endif
                                                                  @if($keykk == 'first_half')FH{{$kk}}@endif
                                                                  @if($keykk == 'second_half')SH{{$kk}}@endif
                                                                  @if($keykk == 'full'){{$kk}}@endif
                                                                    
                                                                  @endforeach
                                                                @endif
                                                                @if(!empty($bvalue['late_attendance']))
                                                                   @foreach($bvalue['late_attendance'] as $keykv => $kv)
                                                                   @if($kv == 'Onduty')<?php $kv ='OD'; ?>@endif
                                                                  @if($kv == 'Permission')<?php $kv ='Per'; ?>@endif
                                                                  @if($kv == 'Mispunch')<?php $kv ='Misp'; ?>@endif
                                                                  @if($kv == 'Compoff')<?php $kv ='Coff'; ?>@endif
                                                                    @if($keykv == 'first_half')FH{{$kv}}@endif
                                                                  @if($keykv == 'second_half')SH{{$kv}}@endif
                                                                  @if($keykv == 'full'){{$kv}}@endif
                                                                   @endforeach
                                                                @endif
                                                              </td>
                                                             
                                                            @endif
                                                          @endforeach
                                                          

                                                             
                                                              
                                                        @endforeach

                                                         <td>{{$data['row'][$appliedkey][$m]['CL']}}</td>
                                                              <td>{{$data['row'][$appliedkey][$m]['SL']}}</td>
                                                              <td>{{$data['row'][$appliedkey][$m]['PL']}}</td>
                                                              <td>{{$data['row'][$appliedkey][$m]['ML']}}</td>
                                                              <td>{{$data['row'][$appliedkey][$m]['RH']}}</td>
                                                              <td>{{$data['row'][$appliedkey][$m]['Permission']}}</td>
                                                              <td>{{$data['row'][$appliedkey][$m]['Onduty']}}</td>
                                                              <td>{{$data['row'][$appliedkey][$m]['Tour']}}</td>
                                                              <td>{{$data['row'][$appliedkey][$m]['Mispunch']}}</td>

                                                              <td>{{$data['row'][$appliedkey][$m]['Absent']}}</td>
                                                              <td>{{$data['row'][$appliedkey][$m]['LOP']}}</td>
                                                              <td>{{$data['row'][$appliedkey][$m]['Present']}}</td>

                                                        
         
          
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



  @endsection @section('script') @include('newemployeezone.js.commonjs')

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

<script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js" ></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js" ></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js" ></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js" ></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js" ></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js" ></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js" ></script>

<!-- ChartJS -->
<script src="{{ config('app.AWS_URL')}}/newcustomerzoneassets/bower_components/chart.js/Chart.js"></script>
<!-- FastClick -->
<script src="{{ config('app.AWS_URL')}}/newcustomerzoneassets/bower_components/fastclick/lib/fastclick.js"></script>

<script src="{{ config('app.AWS_URL')}}/newcustomerzoneassets/bower_components/moment/min/moment.min.js"></script>
   <!-- bootstrap datepicker -->
<script src="{{ config('app.AWS_URL')}}/newcustomerzoneassets/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
  
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
    $("#spin").hide();
    var table = $('#example').DataTable( {
        rowReorder: false,
        responsive: false,
        "scrollX": true,
		    paging: true,
         dom: 'Bfrtip',
         buttons: [
             'copy', 'csv', 'excel', 'pdf', 'print'
         ],
         pageLength: 10
    } );


    $('#example1').DataTable( {
        "order": [[ 3, "desc" ]],
        rowReorder: false,
        responsive: false,
        "scrollX": true,
		    paging: true,
            pageLength: 25
         
    } );

$('#leave_date_range').daterangepicker(
        {
          locale: {
            format: 'MM/YYYY'
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
   


      
  });
</script>

  @endsection
