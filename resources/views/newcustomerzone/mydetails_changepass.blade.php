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
<script src="{{ config('app.AWS_URL')}}/newcustomerzoneassets/dist/js/defines.js"></script>
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
		
    <div class="col-md-10 col-md-offset-1">
      
      <div class="box box-danger">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-edit margin-r-5"></i> Change Password </h3>
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
                
                
                <form id="changedetailsForm" method="POST" action="{{ url('/customerzone/mydetails_changepassword') }}" class="form-horizontal" >
                {{ csrf_field() }}
                   <div class="row" style="margin-left:3px;">
                       <div class="col-md-12">
                           
                           <div class="form-group">
										<label for="inputPassword1" class="col-sm-2 labelalign">Old Password</label>
										<div class="col-sm-4">
											<input class="form-control" id="field_username" title="Old Password must not be blank" type="password" name="oldpasword" placeholder="Old Password">
                                            {!! $errors->first('oldpasword', '<span class="errortext text-red">:message</span>') !!}
										</div>
									</div>
									<div class="form-group">
										<label for="inputPassword2" class="col-sm-2 labelalign">New Password</label>
										<div class="col-sm-4">
											<input class="form-control" id="field_pwd1" title="Type Your New Password" type="password" name="newpass" placeholder="New Password">
                                            {!! $errors->first('newpass', '<span class="errortext text-red">:message</span>') !!}
										</div>
									</div>
									<div class="form-group">
										<label for="inputPassword3" class="col-sm-2 labelalign">Re-type New Password</label>
										<div class="col-sm-4">
											<input class="form-control" id="field_pwd2" title="Please enter the same Password as above." type="password" name="retypepass" placeholder="Re-type New Password">
                                            {!! $errors->first('retypepass', '<span class="errortext text-red">:message</span>') !!}
										</div>
									</div>
									<div class="form-group" style="margin-left:25%;">
										<div class="col-sm-12">
												<div class="col-sm-3">
												
												<input class="submitbtn btn btn-danger" id="submit" type="submit" value="Update"/>
												</div>								
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

@include('newcustomerzone.footer')

  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->



@endsection

@section('script')
@include('newcustomerzone.js.commonjs')

@endsection
