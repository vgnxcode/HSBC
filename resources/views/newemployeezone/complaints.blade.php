@extends('newemployeezone.layout')

@section('title')
VGN Projects Estates Pvt Ltd |Employee Zone| Complaints Page
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
                <h3 class="box-title"><i class="fa fa-bullhorn margin-r-5"></i> Complaints </h3>
                
                <span class="pull-right" ><a href="{{ url('/employeezone/raisecomplaints') }}" class="btn btn-danger btn-xs"><i class="fa fa-microphone margin-r-5"></i>Raise Complaints</a></span>
                
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
                
                <form style="overflow:auto;" action="{{ url('/employeezone/complaints')}}" name="closeform" method="post">
		{{ csrf_field()}}
		<input type="hidden" name="close" value="#" id="closevalue">
		</form>
                
                <form id="changedetailsForm" method="POST" action="{{ url('/employeezone/changemydetails') }}" class="form-horizontal" >
                {{ csrf_field() }}
                   <div class="row" style="margin-left:3px;">
                       <div class="col-md-12">
                           
                          <table id="example" class="display nowrap" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>S. No.</th>
				<th>Complaint No.</th>
				<th>Date of Complaint Raised</th>
				<th>Nature of Complaint.</th>
				<th>Description</th>
				<th>HR Care Name</th>
				<th>HR Status</th>
				<th>Employee Status</th>				
				<th>Close Complaint</th>
				
            </tr>
        </thead>
       
        <tbody>
           
            @if(count($getcomplaints) > 0)
													<?php $count = 1; ?>
													@foreach($getcomplaints as $complaint)
														<tr>
														<td>{{$count}}</td>
														<td>{{$complaint->complaint_no}}</td>
														<td>{{$complaint->complaint_date}}</td>
														<td>{{$complaint->nature_of_complaint}}</td>
														<td align='center'><a href="#" class="btn btn-danger btn-xs marg_left" onclick="popmodal('{{$complaint->complaint_no}}')"><i class="fa  fa-hand-pointer-o margin-r-5"></i> View</a></td>
														<td>{{$complaint->hrcare_name}}</td>
														<td>{{$complaint->hr_status}}</td>
														<td>{{$complaint->emp_status}}</td>
														
                                                            
														
                                                            
														
														<td >
														<a href="#" class="btn btn-danger btn-xs marg_left" id="closeid" onclick="clickclose('{{$complaint->complaint_no}}')" ><i class="fa fa-close margin-r-5"></i>Close</a>
														</td>
														
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
    
    function popmodal(complaintid){
        var data=<?php echo json_encode($getcomplaints);?>;
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
				        
                        result1+= stripslashes(data[i]['description'])+"<br>";
																
				
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
        "order": [[ 2, "desc" ]],
        rowReorder: false,
        responsive: true
    } );
    
    
} );    
    
</script>




@endsection
