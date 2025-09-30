@extends('newvendorzone.layout')

@section('title')
VGN Projects Estates Pvt Ltd |Vendor Zone| Vendor Registration OTP Page
@endsection

@section('description')
    <meta name="description" content="">
@endsection

@section('keyword')  
@endsection


@section('style')
@include('newvendorzone.styles.commoncss')

<style>
.login-page{
        background: url("{{ config('app.AWS_URL')}}/newcustomerzoneassets/img/pattern.jpg") repeat;
    }
  
  .mainbox
  {
    background: #fff;
    padding-top:8px;
    position: relative;
  top: 10%;
  
  }
  .errortext {
    color: #c7254e;
  }
  .mainbox {
    margin: 2% auto;
  }
</style>
@endsection

@section('bodycontent')
<body class="hold-transition login-page" id="bgimg">

																		@if(session()->has('error_msg'))
                                        
                                        
                                        <div class="row" style="padding-top:15px;">
  <div class="col-md-4 col-md-offset-4">
     <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                {!! Session::get('error_msg') !!}
              </div>
  </div>
</div>
																				@endif
																				@if(session()->has('suc_msg'))
                                        
                                               <div class="row" style="padding-top:15px;">
  <div class="col-md-4 col-md-offset-4">
     <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                {!! Session::get('suc_msg') !!}
              </div>
  </div>
</div>
																				@endif

<div class="row">
 <div class="col-md-4 col-md-offset-4">
<div class="mainbox box box-danger">
  <div class="login-logo">
   <a href="{{ url('/')}}"> <img src="{{ config('app.AWS_URL')}}/images/custom/vgn-logo.png" align="center" ></a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body box-body">
    <h4 class="login-box-msg" style="background-color:#f7f7f7; font-size: 18px; text-align: center; padding: 7px 10px; margin-top: 0;">Vendor Registration </h4>
    <br>

    <form id="myForm" class="form-horizontal" method="POST" action="{{ url('/vendorzone/otpregistration')}}">
    {{ csrf_field() }}
      
      <div class="form-group">
                  <label for="nameoforganization" class="col-sm-4 control-label">Enter OTP*</label>

                  <div class="col-sm-8">
                    <input type="text" class="form-control" name="otp" id="otp" placeholder="OTP" value="{{old('otp')}}">
                    <span style="color: #ccc;">Enter the otp code received to your mobile number.</span>
                    {!! $errors->first('otp', '<span class="errortext text-red">:message</span>') !!}
                  </div>
     </div>
     
             
       
      
      <div class="row">
        
        <!-- /.col -->
        <div class="col-xs-4 col-xs-offset-4">
          <button type="submit" class="btn btn-danger btn-block btn-flat">Register</button>
        </div>
        <!-- /.col -->
      </div>
    </form>

    
    

  </div>
  <!-- /.login-box-body -->
</div>
</div>
</div>
<!-- /.login-box -->
@endsection

@section('script')

@include('newvendorzone.js.commonjs')



@endsection
