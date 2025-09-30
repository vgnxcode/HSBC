@extends('newvendorzone.layout')

@section('title')
VGN Projects Estates Pvt Ltd |Employee Zone| MyDetails Customer Creation Step1 Page
@endsection

@section('description')
    <meta name="description" content="">
@endsection

@section('keyword')  
@endsection


@section('style')
@include('newvendorzone.styles.commoncss')

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
                <h3 class="box-title"><i class="fa fa-edit margin-r-5"></i> SALE ORDER CREATION </h3> <span class="pull-right" ><a href="{{ url('/employeezone/filterleadselection') }}" class="btn btn-danger btn-xs"><i class="fa fa-backward margin-r-5"></i>Back</a></span>
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
                
                
                <form id="changedetailsForm" method="POST" action="{{ url('/employeezone/customercreationstep1') }}/{{$newleadno}}" class="form-horizontal" >
                {{ csrf_field() }}
                   <div class="row" style="margin-left:3px;">
                       <div class="col-md-12">
                           
                           
                           <div class="form-group">
										<label for="inputPassword1" class="col-sm-2 labelalign">Lead Number*</label>
										<div class="col-sm-4">
											{{$newleadno}}
											<input type="hidden" class="form-control" name="{{$newleadno}}" id="leadno" placeholder="Lead Number" onkeypress="return isNumberKey(this)" value="<?php echo $newleadno; ?>" readonly required>
										</div>
									</div>
                           <div class="form-group">
										<label for="panno" class="col-sm-2 labelalign">PAN Number</label>
										<div class="col-sm-4">
											<input type="text" class="form-control" name="panno" id="mail" maxlength="10" placeholder="PAN No" >
                                            {!! $errors->first('panno', '<span class="errortext text-red">:message</span>') !!}
										</div>
									</div>
									<div class="form-group">
										<label for="inputPassword2" class="col-sm-2 labelalign">Passport Number</label>
										<div class="col-sm-4">
											<input type="text" class="form-control" name="passportno" id="mail" maxlength="10" placeholder="Passport No" >
                                            {!! $errors->first('passportno', '<span class="errortext text-red">:message</span>') !!}
										</div>
									</div>
									
									<div class="form-group" style="margin-left:25%;">
										<div class="col-sm-12">
												<div class="col-sm-3">
												
												<input class="submitbtn btn btn-danger" id="submit" type="submit" value="Submit"/>
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
