@extends('newcustomerzone.layout')

@section('title')
VGN Projects Estates Pvt Ltd |Customer Zone| MyDetails Change Page
@endsection

@section('description')
    <meta name="description" content="">
@endsection

@section('keyword')  
@endsection


@section('style')
@include('newcustomerzone.styles.commoncss')

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

@foreach($getcustomerdata as $customer)


 
  @include('newcustomerzone.header.index')
  @include('newcustomerzone.aside.index')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
   
    <!-- Main content -->
    <section class="content">
	
	<div class="row">
		<div class="col-md-10 col-md-offset-1">

	@include('newcustomerzone.contenttop')


      	</div>
	</div>



	<div class="row">
		
    <div class="col-md-12">
      
      <div class="box box-danger">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-bullhorn margin-r-5"></i> Complaints </h3>
                @if($validtoraisecomplaints != 0)
                <span class="pull-right" ><a href="{{ url('/customerzone/raisecomplaints') }}" class="btn btn-danger btn-xs"><i class="fa fa-microphone margin-r-5"></i>Raise Complaints</a></span>
                @endif
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
                
                <form style="overflow:auto;" action="{{ url('/customerzone/complaints')}}" name="closeform" method="post">
		{{ csrf_field()}}
		<input type="hidden" name="close" value="#" id="closevalue">
		</form>
                
                <form id="changedetailsForm" method="POST" action="{{ url('/customerzone/changemydetails') }}" class="form-horizontal" >
                {{ csrf_field() }}
                   <div class="row" style="margin-left:3px;">
                       <div class="col-md-12">
                           
                          <table id="example" class="display nowrap" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>S. No.</th>
				<th>Complaint No.</th>
				<th>Project Name</th>
				<th>Unit No.</th>
				<th>Nature of Complaint.</th>
				<th>VGN Status</th>
				<th>Customer Status</th>
				<th>Final Status</th>
				<th>Date</th>
				
				<th>Complaint Description</th>
				
				<th>VGN Remarks</th>
				
				<th>Close Complaint</th>
				<th>Expected Date of Completion</th>
				<th>Scheduled inspection/Call Date</th>
            </tr>
        </thead>
       
        <tbody>
           
            @if(count($getcomplaints) > 0)
													<?php $count = 1; ?>
													@foreach($getcomplaints as $complaint)
														@if($complaint->cust_status != 'CLOSED')
														<tr>
														<td>{{$count}}</td>
														<td>{{$complaint->complaint_no}}</td>
														<td>{{$complaint->project}}</td>
														<td>{{$complaint->unit}}</td>
														<td>{{$complaint->nature}}</td>
														<td>{{$complaint->vgn_status}}</td>
														<td>{{$complaint->cust_status}}</td>
														<td>{{$complaint->final_status}}</td>
														<td>{{$complaint->date}}</td>
														
                                                            <td align='center'><a href="#" class="btn btn-danger btn-xs marg_left" onclick="popmodal('{{$complaint->complaint_no}}')"><i class="fa  fa-hand-pointer-o margin-r-5"></i> View</a></td>
														
                                                            <td align='center'><a href="#" class="btn btn-danger btn-xs marg_left" onclick="popmodalvgnremarks('{{$complaint->complaint_no}}')" ><i class="fa  fa-hand-pointer-o margin-r-5"></i> View</a></td>
														
														<td >
														<a href="#" class="btn btn-danger btn-xs marg_left" id="closeid" onclick="clickclose('{{$complaint->complaint_no}}')" ><i class="fa fa-close margin-r-5"></i>Close</a>
														</td>
														@if($complaint->Expecteddateofcomp == null)
														<td>Will be Updated Soon</td>
														@else
														<td>{{$complaint->Expecteddateofcomp}}</td>
														@endif
															<td>@if($complaint->Scheduled_date == null) Will be Updated Soon @else {{ Carbon\Carbon::parse($complaint->Scheduled_date)->format('d, M Y')}} @if($complaint->Scheduled_time != null) <b>Time</b> {{Carbon\Carbon::parse($complaint->Scheduled_time)->format('H:i:s A')}} @endif @endif</td>
														</tr>
														<?php $count++; ?>
														@endif
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

  @include('newcustomerzone.footer')
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->



@endsection

@section('script')
@include('newcustomerzone.js.commonjs')
<script>
    function stripslashes(str) {
str=str.replace(/\\'/g,'\'');
str=str.replace(/\\"/g,'"');
str=str.replace(/\\0/g,'\0');
str=str.replace(/\\\\/g,'\\');
return str;
}
    
    function popmodal(complaintid){
        var data=<?php echo json_encode($getcomplaints); ?>;
        var length=data.length;
        
        $("#myModalLabel").html("Complaint Description");
        var result1="";
        var k;
				//var distinct1=[];
				for(i=0;i<length;i++)
				{
				if(complaintid == data[i]['complaint_no'])
					{
                        k = i+1;
				        
                        result1+= k+". "+stripslashes(data[i]['description'])+"<br>";
																
				
					}
				}
				
        $(".modal-body").html(result1);
        $('#myModal').modal('show'); 
    }
    
    function popmodalvgnremarks(complaintid){
        var data=<?php echo json_encode($getcomplaints); ?>;
        var length=data.length;
        
        $("#myModalLabel").html("VGN Remarks");
        var result1="";
        var k;
				//var distinct1=[];
				for(i=0;i<length;i++)
				{
				if(complaintid == data[i]['complaint_no'])
					{
                        k = i+1;
				        if(data[i]['vgn_remarks'] != null){
                        result1+= k+". "+stripslashes(data[i]['vgn_remarks'])+"<br>";
                        }
																
				
					}
				}
				
        $(".modal-body").html(result1);
        $('#myModal').modal('show'); 
    }
    
    function clickclose(complaintid){
        
        
                    console.log('clicked');
					$("#closevalue").val("#");
					crm=confirm('Are you sure want to close the Complaint?');
					if(crm)
					{
						var newval = $(this).attr('value');
						$("#closevalue").val(complaintid);
						$('#comp_id').val(complaintid);
						console.log(complaintid);
						document.closeform.submit();
					}
				
    }
</script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js" ></script>
<script src="https://cdn.datatables.net/rowreorder/1.2.3/js/dataTables.rowReorder.min.js" ></script>
<script src="https://cdn.datatables.net/responsive/2.2.0/js/dataTables.responsive.min.js" ></script>
<script>
$(document).ready(function() {
    var table = $('#example').DataTable( {
        rowReorder: false,
        responsive: true
    } );
    
    
} );    
    
</script>




@endsection
