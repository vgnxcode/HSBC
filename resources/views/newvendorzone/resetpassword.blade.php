@extends('newvendorzone.layout')

@section('title')
VGN Projects Estates Pvt Ltd |Vendor Zone| Reset Password Page
@endsection

@section('description')
    <meta name="description" content="">
@endsection

@section('keyword')  
@endsection


@section('style')
@include('newcustomerzone.styles.signincss')
<style>
.login-page{
        background: url("{{ config('app.AWS_URL')}}//newcustomerzoneassets/img/pattern.jpg") repeat;
    }
  
  .login-box
  {
    background: #fff;
    padding-top:8px;
    position: relative;
  top: 10%;
  
  }
  .errortext {
    color: #c7254e;
  }
  .login-box {
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
                                        <suc></suc>
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

 
<div class="login-box box box-danger">
  <div class="login-logo">
    <img src="{{ config('app.AWS_URL')}}/images/custom/vgn-logo.png" align="center" >
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body box-body">
    <h4 class="login-box-msg" style="background-color:#f7f7f7; font-size: 18px; text-align: center; padding: 7px 10px; margin-top: 0;">Reset Password</h4>
    <br>

    <form id="myForm" method="POST" action="{{ url('/vendorzone/resetpassword')}}/{{$vendorid}}/{{$token}}">
    {{ csrf_field() }}
      
      <div class="form-group has-feedback">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        <input type="password" class="form-control" name="newpass" id="pwd" placeholder="New Password">
        
        {!! $errors->first('newpass', '<span class="errortext">:message</span>') !!}
      </div>
      <div class="form-group has-feedback">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        <input type="password" class="form-control" name="retypepass" id="pwd" placeholder="Re-type Password">
        
        {!! $errors->first('retypepass', '<span class="errortext">:message</span>') !!}
      </div>
      <div class="row">
        <div class="col-xs-8">
         
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-danger btn-block btn-flat">Reset</button>
        </div>
        <!-- /.col -->
      </div>
    </form>

   
    <!-- /.social-auth-links -->

    <a href="{{ url('/vendorzone/forgotpassword') }}">I forgot my password</a><br>
    

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->
@endsection

@section('script')
@include('newvendorzone.js.signinjs')
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  });
</script>
@endsection
