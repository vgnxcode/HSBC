@extends('newemployeezone.layout') @section('title') Employee Punch List @endsection @section('description')
<meta name="description" content=""> @endsection @section('keyword') @endsection @section('style') @include('newemployeezone.styles.commoncss')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/rowreorder/1.2.3/css/rowReorder.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.0/css/responsive.dataTables.min.css">
 <!-- bootstrap datepicker -->
 <link rel="stylesheet" href="{{ config('app.AWS_URL')}}/newcustomerzoneassets/bower_components/bootstrap-daterangepicker/daterangepicker.css">
 <!-- Select2 -->
 <link rel="stylesheet" href="{{ config('app.AWS_URL')}}/newcustomerzoneassets/bower_components/select2/dist/css/select2.min.css">
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
  .select2-container .select2-selection--single {
    height: 35px !important;
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
                    <h3 class="box-title"><i class="fa fa-file margin-r-5"></i>Employee Punches</h3>
                    
                    <span class="pull-right" ><a href="{{ url('/employeezone/leavemanagementsystem') }}" class="btn btn-danger btn-xs"><i class="fa fa-backward margin-r-5"></i>LMS Dashboard</a></span>
                    
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  
                           
                           <div class="row">
                           <div class="col-md-10 col-md-offset-1">

                           <div class="col-lg-4">
                <div class="form-group">
                <label>Date range:</label>

                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control" name="leave_date_range" id="leave_date_range" value="{{old('leave_date_range')}}" >
                  
                  
                </div>
                
                <!-- /.input group -->
              </div>
                </div>
                <div class="col-lg-4">

                     <div class="form-group">
                  <label>Employee</label>
                  <select class="form-control select2" name="punch_subid" id="punch_subid">
                    <option value="" >Select</option>
                     @if(count($forpunchlist) > 0)
                      @foreach($forpunchlist as $subordinate_value)
                        <option value="{{$subordinate_value['empid']}}" >{{$subordinate_value['empname']}} ({{$subordinate_value['empid']}})</option>
                      @endforeach
                    @endif

                    
                  </select>
                </div>

                   </div>

                   <div class="col-lg-2" style="margin-top:23px;">
                   <button class="btn btn-primary" class="form-control" id="view_punches">View Punches</button>
                   </div>
                </div>
              </div>

                                                
                                      
                    <br>
                    <br>
                    
                       <div class="row" style="margin-left:3px;">
                           <div class="col-md-12">

                           
                              <table id="example" class="display nowrap" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>S.No</th>
                    
                    <th>Employee Id</th>
                    <th>Employee Name</th>
                    <th>Date and time</th>
                    <th>Punch Location</th>
                </tr>
            </thead>
           
            <tbody id="punch_body">
               
                        
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
  <script src="{{ config('app.AWS_URL')}}/newcustomerzoneassets/bower_components/moment/min/moment.min.js"></script>
   <!-- bootstrap datepicker -->
<script src="{{ config('app.AWS_URL')}}/newcustomerzoneassets/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- Select2 -->
<script src="{{ config('app.AWS_URL')}}/newcustomerzoneassets/bower_components/select2/dist/js/select2.full.min.js"></script>
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
    $('.select2').select2()
        //Red color scheme for iCheck
        $("#punchlist").hide();
   
        $('#leave_date_range').daterangepicker(
        {
          locale: {
            format: 'DD/MM/YYYY'
        },
        ranges   : {
          'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Today'       : [moment(), moment()],   
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

    var table = $('#example').DataTable( {
         
        rowReorder: false,
        responsive: true,
        bPaginate: true,
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
        
    } );

    
    

     



$(document).on('click', '#view_punches', function(){

var daterange = $("#leave_date_range").val();
var subid = $("#punch_subid").val();
$('#example').DataTable().clear().draw();
if ((daterange != '') && (subid != '') ) {

  
  $.post("/employeezone/lms/getsubordinatepunches", {_token:'{{csrf_token()}}',daterange: daterange,employeeid:subid}, function(data){
    console.log(data);
    if (data.punches.length != 0) {
      var res = '';
      $("#punchlist").fadeIn( "slow", function() {
      });
      var i = 1;
      $.each( data.punches, function( key, value ) {
        
        if(value.val_name != undefined){

    $('#example').DataTable().row.add([i, value.empid,value.empname,value.val_name,value.terminal_name]).draw();

        i = i+1;  
        }

        
        

      });
    }
    else{
        //$("#punch_body").html('');
        
        $('#example').DataTable().clear().draw();
      alert('No Punches found for this selected duration!');
    }
  });
}
else{
 
  alert('Date Range and Employee must be selected!');
}

});


      
  });
</script>

  @endsection
