@extends('newemployeezone.layout') @section('title') VGN Projects Estates Pvt Ltd |Employee Zone| Leave Management System | Monthly Late deductions
Page @endsection @section('description')
<meta name="description" content=""> @endsection @section('keyword') @endsection @section('style') @include('newemployeezone.styles.commoncss')
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
                    <h3 class="box-title"><i class="fa fa-bullhorn margin-r-5"></i>Late Deduction Data</h3>
                     <span class="pull-right" >@if($daily_lateprocess_iniate == 1){{$toprocess}} more to Process...<i class="fa fa-refresh fa-spin"></i><a href="{{ url('/employeezone/lms/dailylatescript3hoursintervel') }}" class="btn btn-info">Regenerate Report</a>@else<a href="{{ url('/employeezone/lms/dailylatescript3hoursintervel') }}" class="btn btn-info">Generate Report</a>@endif &nbsp;&nbsp;
                    <a href="{{ url('/employeezone/leavemanagementsystem') }}" class="btn btn-danger btn-xs"><i class="fa fa-backward margin-r-5"></i>LMS Dashboard</a></span>
                    
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  
                                       
                                      
                    <div class="row" style="margin-left:3px;">

                    
                    <div class="col-md-8 col-md-offset-2 card">
                    <h3 class="text-center">Department-wise Deductions from {{$title}}</h3>

                           <table id="example1" class="display nowrap" cellspacing="0" width="100%">
                           <thead>
                           <tr>
                           
                           <th>Department</th>
                           <th>Late (in days)</th>
                           <th>LOP (in days)</th>
                           <th>Gross</th>
                           </tr>
                           </thead>
                           <tbody>
                           @if(count($departmentwisearray) > 0)
                           <?php
                           $glate = 0;
                           $glop = 0;
                           $ggross = 0;
                           $i = 1; ?>
                            @foreach($departmentwisearray as $deptval)
                            
                                <tr>
                                
                                <td>@if($deptval['Department'] == '') Blank @else{{$deptval['Department']}}@endif</td>
                                <td>{{$deptval['LATE']}}</td>
                                <td>{{$deptval['LOP']}}</td>
                                <td>{{$deptval['LATE'] + $deptval['LOP']}}</td>
                                </tr>
                                <?php
                                $glate += $deptval['LATE'];
                                $glop += $deptval['LOP'];
                                $ggross += $deptval['LOP'] + $deptval['LATE'];
                                $i++; ?>
                            @endforeach
                           
                           
                           </tbody>
                           <tfoot>
                           <tr>
                           <th>Total</th>
                           <th>{{$glate}}</th>
                           <th>{{$glop}}</th>
                           <th>{{$ggross}}</th>
                           </tr>
                           </tfoot>
                           @endif
                           </table>
                    </div>
                    </div>
                    <br>

                       <div class="row" style="margin-left:3px;">
                           <div class="col-md-12 card">


                           
                <h3 class="text-center">Late Deductions from {{$title}}</h3>
                                                          
                              <table id="example" class="display nowrap" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>S. No.</th>
                    
                    <th>Employee Id</th>
                    
                    <th>Employee Name</th>
                    <th>Deduction Start</th>
                    <th>Deduction End</th>
                    <th>Partial Days</th>
                    <th>Deduction Type</th>
                    <th>Late Count</th>
                    <th>Late in Hours</th>
                    <th>Late Range 1 (15 min delay)</th>
                    <th>Late Range 2 (30 min delay)</th>
                    <th>Late Range 3 (45 min delay)</th>
                    <th>Early Out Count</th>
                    
                    <th>Department</th>
                    <th>Position</th>
                    
                    <th>Cadre</th>
                    <th>Role Code</th>
                    <th>Plant Code</th>
                    
                    

                    
                    
                </tr>
            </thead>
           
            <tbody>
               
                @if(count($getdeductions) > 0)
                                                        <?php $count = 1; ?>
                                                        @foreach($getdeductions as $appliedkey => $appliedvalue)
                                                        <tr>
                                                        <td>{{$count}}</td>
                                                        
                                                        <td>{{ $appliedvalue->employeeid }}</td>
                                                        <td>{{ $appliedvalue->emp_name }}</td>
                                                        <td>{{ $appliedvalue->deduction_stdate_time }}</td>
                                                        <td>{{ $appliedvalue->deduction_etdate_time }}</td>
                                                        <td>
                                                        @if($appliedvalue->partial_days == 'first_half')
                                                        First Half
                                                        @elseif($appliedvalue->partial_days == 'second_half')
                                                        Second Half
                                                        @elseif($appliedvalue->partial_days == 'full')
                                                        Full Day
                                                        @else
                                                        @endif
                                                        </td>
                                                        <td>{{ $appliedvalue->type }}</td>

                                                        <td>{{ $appliedvalue->latecount }}</td>
                                                        <td>{{ $appliedvalue->latein_hours }}</td>
                                                        <td>{{ $appliedvalue->laterange1 }}</td>
                                                        <td>{{ $appliedvalue->laterange2 }}</td>
                                                        <td>{{ $appliedvalue->laterange3 }}</td>
                                                        <td>{{ $appliedvalue->earlyoutcount }}</td>
                                                        

                                                        <td>@if($appliedvalue->department == '') Blank @else{{ $appliedvalue->department }}@endif</td>
                                                        <td>{{ $appliedvalue->position }}</td>
                                                        
                                                        <td>{{ $appliedvalue->cadre }}</td>
                                                        <td>{{ $appliedvalue->role_code }}</td>
                                                        <td>{{ $appliedvalue->plant_code }}</td>
                                                        
                                                        



         
          
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

    @if($daily_lateprocess_iniate == 1)
    setTimeout(function () {
        window.location.reload();
    }, 60000);
    @endif


      
  });
</script>

  @endsection
