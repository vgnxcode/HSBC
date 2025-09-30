@extends('newemployeezone.layout')

@section('title')
VGN Projects Estates Pvt Ltd |Employee Zone| Sale Order Uploaded files Page
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
                <h3 class="box-title"><i class="fa fa-file-text margin-r-5"></i> VIEW UPLOADED SALE ORDER FILES </h3>
                <span class="pull-right" ><a href="{{ url('/employeezone/saleorderconversion') }}" class="btn btn-danger btn-xs"><i class="fa fa-backward margin-r-5"></i>Back</a></span>
                
                
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
                
                
                
                
                   <div class="row" style="margin-left:3px;">
                       <div class="col-md-12">
                           
                          <?php 
										$customercode = $customerdata['Status2'];

      									$dir = "customersignedpdf/".$customercode;

      									if (is_dir($dir)) {
										 ?>
										 <div class="container" style="padding: 5px;">
										<div class="row">
										<div class="col-sm-12">
										<div class="panel panel-default">
											  <div class="panel-body">
											<?php 

											$scanned_directory = array_diff(scandir($dir), array('..', '.'));
											echo '<h5>Click the Below link to view the file.</h5>';
											echo '<ol>';
											foreach ($scanned_directory as $key => $value) {
												echo '<li>';
												echo '<a href="/'.$dir.'/'.$value.'">'.$value.'</a>';
												echo "</li>";
											}
											echo '</ol>';

											 ?>
											 </div>
											 </div>
										</div>
										

											</div>
										</div>
										</div>
										<?php }
										else{
											echo '<script>alert("No files found!");</script>';
											echo '<script>window.location.href="employeezone/saleorderconversion";</script>';
											} ?> 
                                            
                                                       
                                       
                                             
                       </div>
                   </div>
                            
                                
                
              

              
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







@endsection
