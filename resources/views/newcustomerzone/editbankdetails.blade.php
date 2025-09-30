@extends('newcustomerzone.layout')

@section('title')
VGN Projects Estates Pvt Ltd |Customer Zone| My Bank Details Page
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
                <h3 class="box-title"><i class="fa fa-bank margin-r-5"></i> My Bank Details </h3><span class="pull-right" ><a href="{{ url('/customerzone/mybankdetails') }}" class="btn btn-danger btn-xs">Back</a></span>
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
               <form id="changedetailsForm" method="POST" action="{{ url('/customerzone/editbankdetails') }}" class="form-horizontal" >
                {{ csrf_field() }}
                   <div class="row" style="margin-left:3px;">
                       <div class="col-md-12">
                           <h4 class="text-red"> <i class="fa fa-info-circle margin-r-5"></i> Edit Account Information </h4>
                            
                             
                                <div class="form-group">
                        <label for="bank_act_no" class="col-sm-2 ">Bank Account No*</label>
                        <div class="col-sm-4">
                          <input type="text" class="form-control" value="@if(!empty(old('bank_account_no'))){{old('bank_account_no')}}@else{{ $customer->act_no }}@endif" name="bank_account_no" id="bank_act_no" required>
                          {!! $errors->first('bank_account_no', '<span class="errortext text-red">:message</span>') !!}
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="retype_bank_account_no" class="col-sm-2 ">Retype Bank Account No*</label>
                        <div class="col-sm-4">
                          <input type="text" class="form-control" value="{{ old('confirm_bank_account_no') }}" name="retype_bank_account_no" id="confirm_bank_account_no" required>
                          {!! $errors->first('retype_bank_account_no', '<span class="errortext text-red">:message</span>') !!}
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="bank_name" class="col-sm-2 ">Bank Name*</label>
                        <div class="col-sm-4">
                          <input type="text" class="form-control" value="@if(!empty(old('bank_name'))){{old('bank_name')}}@else{{$customer->bank_name}}@endif" name="bank_name" id="bank_name"  required>
                          {!! $errors->first('bank_name', '<span class="errortext text-red">:message</span>') !!}
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="ifsc_code" class="col-sm-2">IFSC Code*</label>
                        <div class="col-sm-4">
                          <input type="text" class="form-control" value="@if(!empty(old('ifsc_code'))){{old('ifsc_code')}}@else{{$customer->ifsc_code}}@endif" name="ifsc_code" id="ifsc_code"  required>
                          {!! $errors->first('ifsc_code', '<span class="errortext text-red">:message</span>') !!}
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="branch_name" class="col-sm-2">Branch Name*</label>
                        
                          <div class="col-sm-4">
                            
                          <input type="text" class="form-control" value="@if(!empty(old('branch_name'))){{old('branch_name')}}@else{{$customer->branch_name}}@endif" name="branch_name" id="branch_name" required>
                          {!! $errors->first('branch_name', '<span class="errortext text-red">:message</span>') !!}
                          </div>                  
                        
                      </div>
                      
                      
                      <br/><br/>
                      <div class="form-group">
                        <div class="col-sm-7"> 
                          <input class="submitbtn btn btn-danger" type="submit" value="Update" id="submit" />
                          <a href="{{ url('/customerzone/mybankdetails') }}" class="btn btn-warning">Cancel</a>
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
<script>
  $(document).ready(function () {
    $('.sidebar-menu').tree();

        $('#bank_name, #ifsc_code, #branch_name').on('keyup',function(){
    $(this).val($(this).val().toUpperCase());
});
          $('#bank_name, #ifsc_code, #branch_name').on('change',function(){
    $(this).val($(this).val().toUpperCase());
});
   

  });
</script>
@endsection
