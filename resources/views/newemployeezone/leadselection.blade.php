@extends('newemployeezone.layout')

@section('title')
VGN Projects Estates Pvt Ltd |Employee Zone| Lead Selection Page
@endsection

@section('description')
    <meta name="description" content="">
@endsection

@section('keyword')  
@endsection


@section('style')
@include('newemployeezone.styles.commoncss')
<!-- bootstrap datepicker -->
  <link rel="stylesheet" href="{{ config('app.AWS_URL')}}/newcustomerzoneassets/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">

<style>
	.carousel-inner>.item>img
	{
		min-height: 280px;
	}
    #changedetailsForm label.col-sm-2 {
        font-weight: normal;
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
		
    <div class="col-md-10 col-md-offset-1">
      
      <div class="box box-danger">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-search margin-r-5"></i> LEAD SELECTION </h3>
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
                
                
                <form id="changedetailsForm" method="POST" action="{{ url('/employeezone/leadselection') }}" class="form-horizontal" >
                {{ csrf_field() }}
                   <div class="row" style="margin-left:3px;">
                       <div class="col-md-12">
                           <h4 class="text-red"> <i class="fa fa-search margin-r-5"></i> Search Lead </h4>
                            
											
											<div class="form-group">
												<label for="plantcode" class="col-sm-2">Plant Code*</label>
												<div class="col-sm-4">
													
													<select class="form-control userdropdown" name="plantcode" id="plantcode" required>

														<option selected value="">Select Project</option>
												@foreach ($getprojectnames['UNSOLD_PROJECTS'] as $value) 
												<option value="{{$value['Project_No']}}">{{$value['Project_No']}} - {{$value['Project_Name']}}</option>
																@endforeach
														
													</select>	
													{!! $errors->first('plantcode', '<span class="errortext text-red">:message</span>') !!}
													
												</div>
												
											</div>
											
											
											
											<div class="form-group">
												<label for="leadno" class="col-sm-2">Lead Number</label>
												<div class="col-sm-4">
													<input type="text" class="form-control" name="leadno" id="lead" maxlength="10" placeholder="Lead Number" onkeypress="return isNumberKey(this)">
												</div>
											</div>
											<div class="form-group">
												<label for="leadname" class="col-sm-2">Lead Name</label>
												<div class="col-sm-4">
													<input type="text" class="form-control" name="leadname" id="leadname" maxlength="35" placeholder="Lead Name">
												</div>
											</div>
											
											<div class="form-group">
                <label for="createddate" class="col-sm-2">Created Date</label>
                
                <div class="col-sm-4">
                <div class="input-group ">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control" name="createddate" data-inputmask="'alias': 'yyyy-mm-dd'" data-mask id="datemask">
                </div>
                <!-- /.input group -->
              </div></div>
											
											<br/><br/>
											<div class="form-group">
												<div class="col-sm-7"> 
													<input class="submitbtn btn btn-danger" type="submit" value="Submit" id="submit" />
													<a href="{{ url('/employeezone/dashboard') }}" class="btn btn-warning">Cancel</a>
												</div> 
											</div>
                                 
                                     
                                             
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
@include('newcustomerzone.js.commonjs')
<!-- InputMask -->
<script src="{{ config('app.AWS_URL')}}/newcustomerzoneassets/plugins/input-mask/jquery.inputmask.js"></script>
<script src="{{ config('app.AWS_URL')}}/newcustomerzoneassets/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="{{ config('app.AWS_URL')}}/newcustomerzoneassets/plugins/input-mask/jquery.inputmask.extensions.js"></script>

<script type="text/javascript">
											
				$(document).ready(function(){
                    
                        $('.sidebar-menu').tree();  
                    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('yyyy-mm-dd', { 'placeholder': 'yyyy-mm-dd' })
				});				
		    </script>
@endsection
