@extends('newcustomerzone.layout')

@section('title')
VGN:Flats and apartments in Chennai| Premium builders in Chennai
@endsection

@section('description')
     <META NAME="Subject" CONTENT="Flats and apartments in Chennai">
<meta name="description" content="Pick well planned flats and apartments in chennai from VGN premium builders in chennai at prime areas for superior lifestyle.">
<meta name="keywords" content="Nungambakkam flats for sale, Buy flats in guindy chennai, Premium flats in guindy, Flats and apartments in chennai, Premium builders in chennai">
<META NAME="Language" CONTENT="English">
<META NAME="Distribution" CONTENT="Global">
<META NAME="Robots" CONTENT="All">
<META NAME="Revisit-After" CONTENT="7 Days">

<meta property='og:locale' content='en_US'/>
<meta property='og:title' content='Flats and apartments in chennai| Premium builders in chennai'/>
<meta property='og:description' content='Pick well planned flats and apartments in chennai from VGN premium builders in chennai at prime areas for superior lifestyle.'/>
<meta property='og:url' content='http://vgn.in/customerzone/customerlogin'/>
<meta property='og:site_name' content='VGN Property Developers Pvt Ltd'/>
<meta property='og:type' content='article'/>
@endsection

@section('keyword')  
@endsection


@section('style')
@include('newcustomerzone.styles.signincss')
<script>

  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){

  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),

  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)

  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-90663039-1', 'auto');

  ga('send', 'pageview');

</script>    

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
    <h4 class="login-box-msg" style="background-color:#f7f7f7; font-size: 18px; text-align: center; padding: 7px 10px; margin-top: 0;">Customer Login</h4>
    <br>

    <form id="myForm" method="POST" action="{{ url('/customerzone/customerlogin')}}">
    {{ csrf_field() }}
      <div class="form-group has-feedback">
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
        <input type="text" class="form-control" name="username" id="cid"  value="{{ old('username')}}" placeholder="Enter Customer ID (or) Regd. Mail ID (or) Mobile">
        {!! $errors->first('username', '<span class="errortext">:message</span>') !!}
        
      </div>
      <div class="form-group has-feedback">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        <input type="password" class="form-control" name="password" id="pwd" placeholder="****">
        
        {!! $errors->first('password', '<span class="errortext">:message</span>') !!}
      </div>
      <div class="row">
        <div class="col-xs-8">
         
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-danger btn-block btn-flat">Sign In</button>
        </div>
        <!-- /.col -->
      </div>
    </form>

    <div class="social-auth-links text-center">
      <p>To know your customer-Id or registered email/phone. Contact our customer care at <a href="tel:04443439977">044 43439977</a></p>
      
    </div>
    <!-- /.social-auth-links -->

    <a href="{{ url('/customerzone/forgotpassword') }}"><i class="fa fa-question-circle margin-r-5"></i> I forgot my password</a><br>
    

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
</script>
@endsection
