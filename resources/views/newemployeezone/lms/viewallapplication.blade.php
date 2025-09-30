@extends('newemployeezone.layout') @section('title') VGN Projects Estates Pvt Ltd |Employee Zone| Leave Management System | View All Applications
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
                    <h3 class="box-title"><i class="fa fa-bullhorn margin-r-5"></i> Application History </h3>
                    
                    <span class="pull-right" ><a href="{{ url('/employeezone/leavemanagementsystem') }}" class="btn btn-danger btn-xs"><i class="fa fa-backward margin-r-5"></i>LMS Dashboard</a></span>
                    
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  
                                       
                                      
                    
                    
                       <div class="row" style="margin-left:3px;">
                           <div class="col-md-12">
							   
							    <div class="alert alert-danger col col-md-10" style="background-color: #c55243 !important;">
                                <strong>Notes:</strong> 
                                <ol>
                                  <li>If the Leave is applied wrongly, then it can be deleted by the employee under Leave Management System - > Your Applications -> Delete the respective leave. Please note if the leave applied is approved by the HOD then the same can’t be deleted but only a request can be sent to their immediate HOD.</li>
                                  <li>If the Leave is been approved by his/her immediate HOD  and same needs to be cancelled, then only a cancellation request can sent to his/her HOD. Leave cancellation request sent by the employee can be approved via mail or by logging in VGN LMS Portal of the HOD.</li>
                                </ol>

                              </div>
                               
                              <table id="example" class="display nowrap" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>S. No.</th>
                    <th>Delete Appl.</th>
                    <th>Employee Id</th>
                    <th>Application Type</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Partial Days</th>
                    <th>No.of Days</th>
                    
                    <th>HOD Status</th>
		    <th>HOD Reason</th>
                    <th>Final Status</th>
                    
                    <th>Application Created Date</th>
                    
                </tr>
            </thead>
           
            <tbody>
               
                @if(count($getallapplications) > 0)
                                                        <?php $count = 1; ?>
                                                        @foreach($getallapplications as $appliedkey => $appliedvalue)
                                                        <tr>
                                                        <td>{{$count}}</td>
                                                        <td class="text-center">
                                                        @if($appliedvalue->final_status == 'Approved')
                                                        @if(\Carbon\Carbon::parse($appliedvalue->stdate)->format('m Y') == \Carbon\Carbon::now()->format('m Y'))
                                                          @if($appliedvalue->raised_delete_req == 0)
                                                          <a href="#" class="label label-danger" id="delete" onclick="send_datato_delete_tohod({{$appliedvalue->id}}, '{{$appliedvalue->type}}');" >Delete</a>
                                                          @else
                                                          <a href="#" class="label label-danger" id="delete" onclick="send_datato_delete_tohod({{$appliedvalue->id}}, '{{$appliedvalue->type}}');"  >Req. for Deletion</a>
                                                          @endif
                                                        @else
                                                        -
                                                        @endif
                                                        @elseif($appliedvalue->final_status == 'Pending')
                                                        <a href="#" class="label label-danger" id="delete" onclick="send_datato_delete({{$appliedvalue->id}}, '{{$appliedvalue->type}}');" >Delete</a>
                                                        @else
                                                        -
                                                        @endif
                                                        </td>
                                                        <td>{{$appliedvalue->employeeid}}</td>
          <td>
          
            
          {{$appliedvalue->type}}
          
          </td>
          <td>
            
            {{ \Carbon\Carbon::parse($appliedvalue->stdate)->format('d, M Y H:i:s') }}
            
          </td>
          <td>
         
            {{ \Carbon\Carbon::parse($appliedvalue->etdate)->format('d, M Y H:i:s') }}
            
            </td>
          <td>@if($appliedvalue->partial_days == 'full')
            Full Day
          @elseif($appliedvalue->partial_days == 'first_half')
          Forenoon
          @else
          Afternoon
          @endif
          </td>

          <td>{{$appliedvalue->no_of_days}}</td>
          
          <td>
            @if($appliedvalue->hod_status == 'Pending')
            <span class="label label-warning">Pending</span>
            @elseif ($appliedvalue->hod_status == 'Approved')
            <span class="label label-success">Approved</span>
            @else
            <span class="label label-danger">Rejected</span>
            @endif
          </td>
	
	  <td>
            @if(empty($appliedvalue->hod_reason))
            <p class="text-success">Nil</p>
            @else
            @if($appliedvalue->hod_status == 'Rejected')
            <p class="text-danger">{{$appliedvalue->hod_reason}}</p>
            @else
            <p class="text-success">{{$appliedvalue->hod_reason}}</p>
            @endif
            
            @endif
          </td>
         
          <td>
          @if($appliedvalue->final_status == 'Pending')
            <span class="label label-warning">Pending</span>
            @elseif ($appliedvalue->final_status == 'Approved')
            <span class="label label-success">Approved</span>
            @else
            <span class="label label-danger">Rejected</span>
            @endif
          </td>
         
         
          <!--<td>{{ \Carbon\Carbon::parse($appliedvalue->created_date)->format('d, M Y H:i:s A') }}</td>-->
		<td>{{ $appliedvalue->created_date }}</td>

          
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

<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js" ></script>
<script src="https://cdn.datatables.net/rowreorder/1.2.3/js/dataTables.rowReorder.min.js" ></script>
<script src="https://cdn.datatables.net/responsive/2.2.0/js/dataTables.responsive.min.js" ></script>
  
<script>

function send_datato_delete(id, leavetype){
  
  $("#delete").prop('disabled',true);
  
  $('#preloader').show();
  $('#status').show();
  

  $.post('/employeezone/lms/employeedeleteleave', {_token:'{{csrf_token()}}',id: id, leavetype: leavetype}, function(data){
    alert(data);
    $("#delete").prop('disabled',false);
    
    $('#preloader').hide();
  $('#status').hide();
    window.location.href="/employeezone/lms/viewallapplication";
});

}

function send_datato_delete_tohod(id, leavetype) {
  $("#delete").prop('disabled',true);

  $('#preloader').show();
  $('#status').show();

  $.post('/employeezone/lms/employeedeleteleaverequest_tohod', {_token:'{{csrf_token()}}',id: id, leavetype: leavetype}, function(data){
    alert(data);
    $("#delete").prop('disabled',false);
    $('#preloader').hide();
  $('#status').hide();
    window.location.href="/employeezone/lms/viewallapplication";
});
}

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
      
    var table = $('#example').DataTable( {
        "order": [[ 11, "desc" ]],
        rowReorder: false,
        responsive: true
    } );
    
      
      
  });
</script>

  @endsection
