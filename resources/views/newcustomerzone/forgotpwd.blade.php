@extends('newcustomerzone.layout')

@section('title')
VGN Projects Estates Pvt Ltd |Customer Zone| Login Page
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
        background: url("{{ config('app.AWS_URL')}}/newcustomerzoneassets/img/pattern.jpg") repeat;
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
    <h4 class="login-box-msg" style="background-color:#f7f7f7; font-size: 18px; text-align: center; padding: 7px 10px; margin-top: 0;">Forgot Password</h4>
    <br>

    <form id="myForm" method="POST" action="{{ url('/customerzone/forgotpassword')}}">
    {{ csrf_field() }}
      <div class="form-group has-feedback">
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
        <input type="text" class="form-control" name="forgotusername" id="cid"  value="{{ old('username')}}" placeholder="Customer-Id/EmailId/Mobile No.">
        {!! $errors->first('forgotusername', '<span class="errortext">:message</span>') !!}
        
      </div>
      
      <div class="row">
        <div class="col-xs-8">
         
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-danger btn-block btn-flat">Submit</button>
        </div>
        <!-- /.col -->
      </div>
    </form>

    <div class="social-auth-links text-center">
      <p>To know your customer-Id or registered email/phone. Contact our customer care at <a href="tel:04443439977">044 43439977</a></p>
      
    </div>
    <!-- /.social-auth-links -->

    <a href="{{ url('/customerzone/customerlogin') }}"><i class="fa fa-backward margin-r-5"></i>Customer Login</a><br>
    

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->
@endsection

@section('script')
@include('newcustomerzone.js.signinjs')
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
