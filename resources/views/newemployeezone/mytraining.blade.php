@extends('newemployeezone.layout')

@section('title')
VGN Projects Estates Pvt Ltd |Employee Zone| Employee TRAINING SCHEDULE Page
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
		
    <div class="col-md-12">
      
      <div class="box box-danger">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-file-text margin-r-5"></i> MY TRAINING SCHEDULE </h3>
                
                
                
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              
               <div class="callout callout-danger">
                                            <h4 ><span style="padding-right: 180px;">Training Frequency</span>: <b><?php echo $getmytraining['Training_Frequency']; ?></b></h4>
                                            <h4><span style="padding-right: 5px;">Last Department Training Conducted at Site</span>: <b><?php 
                                                echo substr($getmytraining['Dept_Last_Attended'], 6, 2).'-'.substr($getmytraining['Dept_Last_Attended'], 4, 2).'-'.substr($getmytraining['Dept_Last_Attended'], 0, 4);
                                                ?></b></h4>
                                            <h4 ><span style="padding-right: 90px;">Next Planned Training Schedule</span>: <b><?php 
                                                
                                                echo substr($getmytraining['Planned_Training_Schedule'], 6, 2).'-'.substr($getmytraining['Planned_Training_Schedule'], 4, 2).'-'.substr($getmytraining['Planned_Training_Schedule'], 0, 4);
                                                
                                                ?>(Last Department wise Training Date at Site + Frequency)</b></h4>
										</div>
                
                <form style="overflow:auto;" action="{{ url('/employeezone/emprequest')}}" name="closeform" method="post">
		{{ csrf_field()}}
		<input type="hidden" name="close" value="#" id="closevalue">
		</form>
                
                <form id="changedetailsForm" method="POST" action="{{ url('/employeezone/emprequest') }}" class="form-horizontal" >
                {{ csrf_field() }}
                   <div class="row" style="margin-left:3px;">
                       <div class="col-md-12">
                           
                          <table id="example" class="display nowrap" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>S.No</th>
				<th>Training Attended Date</th>
				<th>Training Duration</th>
				<th>Faculty Name</th>
				<th>Subject</th>
				
				
            </tr>
        </thead>
       
        <tbody>
           
            @if(count($getmytraining['Training_Attended']) > 0)
            <?php
            $mainarray = array();
            if(array_key_exists('0',$getmytraining['Training_Attended']) == false){
            $mainarray[0] = $getmytraining['Training_Attended'];
                
}
            else
            {
                $mainarray = $getmytraining['Training_Attended'];
                
            }
            
            
    ?>
                                                
													<?php $count = 1; ?>
													@foreach($mainarray as $request)
													@if($request['Last_Training_Attended'] != '')
														<tr>
														<td>{{$count}}</td>
														<td>
														@if($request['Last_Training_Attended'] != '')
														<?php echo substr($request['Last_Training_Attended'],0,4).'-'.substr($request['Last_Training_Attended'],4,2).'-'.substr($request['Last_Training_Attended'],6,2) ?>
														@endif
														</td>
														<td>
														    
														    @if($request['Training_Duration'] != '')
														<?php echo substr($request['Training_Duration'],0,2).':'.substr($request['Training_Duration'],2,2).':'.substr($request['Training_Duration'],4,2) ?>
														@endif
														    
														</td>
														<td>{{$request['Faculty_Name']}}</td>
														<td>{{$request['Subject']}}</td>
														
														</tr>
												    @endif
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
	
		<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"></h4>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
@endforeach
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 2.4.0
    </div>
    <strong>Copyright &copy; 2019 <a href="http://www.vgn.in">VGN Property Developers Pvt. Ltd</a>.</strong> All rights
    reserved.
  </footer>

  
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
$(document).ready(function() {
    var table = $('#example').DataTable( {
        "order": [[ 1, "desc" ]],
        rowReorder: false,
        responsive: true
    } );
    
    
} );    
    
</script>




@endsection
