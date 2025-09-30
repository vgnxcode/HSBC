@extends('newvendorzone.layout')

@section('title')
VGN Projects Estates Pvt Ltd |Employee Zone| Notice Board Page
@endsection

@section('description')
    <meta name="description" content="">
@endsection

@section('keyword')  
@endsection


@section('style')
@include('newvendorzone.styles.commoncss')

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
                <h3 class="box-title"><i class="fa fa-sort-alpha-asc margin-r-5"></i> My Notice Board </h3>
                
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
                
                <form id="changedetailsForm" method="POST" action="{{ url('/vendorzone/changemydetails') }}" class="form-horizontal" >
                {{ csrf_field() }}
                   <div class="row" style="margin-left:3px;">
                       <div class="col-md-12">
                           
                          <table id="example" class="display nowrap" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>S. No.</th>
				<th>Communication Ref No</th>
				<th>Title</th>
				<th>Created By</th>
				<th>Created Date</th>
				<th>Description</th>
				
				
            </tr>
        </thead>
       
        <tbody>
           
            @if(count($notice_data) > 0)
													<?php $count = 1; ?>
													@foreach($notice_data as $notice)
														<tr>
														<td>{{$count}}</td>
														<td>{{$notice['Comm_Ref_No']}}</td>
														<td>{{$notice['Title']}}</td>
														<td>{{$notice['Created_By']}}</td>
														<td>{{$notice['Created_Date']}}</td>
														
														
                                                            <td align='center'><a href="#" class="btn btn-danger btn-xs marg_left" onclick="popmodal('{{$notice['Comm_Ref_No']}}')"><i class="fa  fa-hand-pointer-o margin-r-5"></i> View</a></td>
														
                                    														
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
@include('newvendorzone.js.commonjs')
<script>
    function stripslashes(str) {
str=str.replace(/\\'/g,'\'');
str=str.replace(/\\"/g,'"');
str=str.replace(/\\0/g,'\0');
str=str.replace(/\\\\/g,'\\');
return str;
}
    
    function popmodal(complaintid){
        var data=<?php echo json_encode($notice_data);?>;
        var length=data.length;
        
        $("#myModalLabel").html("Notice Board");
        var result1="";
        var k;
				//var distinct1=[];
				for(i=0;i<length;i++)
				{
				if(complaintid == data[i]['Comm_Ref_No'])
					{
                        k = i+1;
				        
                        for(var j=1; j<=200; j++){
                            if(data[i]['LINE'+j] != ''){
                        result1+= k+". "+stripslashes(data[i]['LINE'+j])+"<br>";
                            }
                        }
																
				
					}
				}
				
        $(".modal-body").html(result1);
        $('#myModal').modal('show'); 
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
