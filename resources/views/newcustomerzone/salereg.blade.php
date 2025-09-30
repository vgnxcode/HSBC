@extends('newcustomerzone.layout')

@section('title')
Sale Agreement VGN
@endsection

@section('description')
    
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
  top: 50%;
  transform: translateY(+20%);
  }
  .errortext {
    color: #c7254e;
  }
  .login-box {
    margin: auto;
  }
 
</style>
@endsection

@section('bodycontent')
<body class="hold-transition login-page"  >
<div id="bgimg"></div>
<div id="bgimg1">

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
 <a href="{{ url()->full() }}">
  <div class="login-logo">
    <img src="{{ config('app.AWS_URL')}}/images/custom/vgn-logo.png" align="center" >
  </div>
  </a>
  <!-- /.login-logo -->
  <div class="login-box-body box-body">
    <h4 class="login-box-msg" style="background-color:#f7f7f7; font-size: 18px; text-align: center; padding: 7px 10px; margin-top: 0;">Customer KYC Update</h4>
    <br>

    <form id="myForm" method="POST" action="{{ url('/salereg')}}/{{$customerid}}">
    {{ csrf_field() }}
    <div class="row">
      <label for="customerid" class="col-md-5">CustomerId</label>
      <span class="col-md-5">{{$customerid}}</span>
    </div>
    <div class="row">
      <label for="customerid" class="col-md-5">Mobile Number</label>
      <span class="col-md-5">{{$mobile}}</span>
    </div>
    <div class="row">
      <label for="customerid" class="col-md-5">EmailId</label>
      <span class="col-md-5">{{$email}}</span>
    </div>
      <div class="form-group has-feedback">
        <span class="glyphicon glyphicon-key form-control-feedback"></span>
        <input type="text" class="form-control" name="otp" id="cid"  value="{{ old('otp')}}" placeholder="Enter OTP">
        {!! $errors->first('otp', '<span class="errortext">:message</span>') !!}
        
      </div>
  
      <div class="row">
        <div class="col-xs-6">
        <a class="btn btn-danger btn-block btn-flat" id="gen_otp">Generate OTP</a>
        </div>
        <!-- /.col -->
        <div class="col-xs-6">
          <button type="submit" class="btn btn-info btn-block btn-flat">Submit</button>
        </div>
        <!-- /.col -->
      </div>
    </form>
<div style="text-align:center" id="loadergif">
<img src="{{ config('app.AWS_URL')}}/images/loader11.gif" alt="loader" width="60">
</div>

  <div id="note">

  <br>
    <h4 style="font-weight:bold;">Note:</h4>
    <p><i class="fa fa-hand-o-right"></i> OTP Valid For 15 minutes.</p>
    <p><i class="fa fa-hand-o-right"></i> OTP Sent to your registered EmailId and Mobile Number.</p>
    <hr>
  </div>


    <div class="social-auth-links text-center">
      <p>To know your customer-Id or registered email/phone. Contact our customer care at <a href="tel:04443439977">044 43439977</a></p>
      
    </div>
    <!-- /.social-auth-links -->

    <a href="{{ url('/customerzone/customerlogin') }}"><i class="fa fa-user margin-r-5"></i>Customer Login</a><br>
    

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->
</div>
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

  $(document).ready(function(){
    $("#note").hide();
    $("#loadergif").hide();
    
    $("#gen_otp").on('click', function(){
      $("#loadergif").show();
      setTimeout(() => {
var cid = {{$customerid}};
$.post('/customerzone/generate_otp', {_token:'{{csrf_token()}}', customerid: cid }, function(data){
  if (data != '') {
    $("#loadergif").hide();
 $("#note").fadeIn(() => {
          $("#note").show();
        });
        $("#gen_otp").text('Regenerate OTP');

    alert(data);

  }
});

    }, 2000);
      

    });
  });
</script>
@endsection
