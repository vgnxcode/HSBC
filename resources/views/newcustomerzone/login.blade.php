@extends('newcustomerzone.layout')

@section('title')
VGN Projects Estates Pvt Ltd |Customer Zone| Login Page
@endsection

@section('description')
     <META NAME="Subject" CONTENT="Flats and apartments in Chennai">
<meta name="description" content="VGN Customer Login">
<meta name="keywords" content="Nungambakkam flats for sale, Buy flats in guindy chennai, Premium flats in guindy, Flats and apartments in chennai, Premium builders in chennai">
<META NAME="Language" CONTENT="English">
<META NAME="Distribution" CONTENT="Global">
<META NAME="Robots" CONTENT="All">
<META NAME="Revisit-After" CONTENT="7 Days">

<meta property='og:locale' content='en_US'/>
<meta property='og:title' content='Flats and apartments in chennai| Premium builders in chennai'/>
<meta property='og:description' content='Pick well planned flats and apartments in chennai from VGN premium builders in chennai at prime areas for superior lifestyle.'/>
<meta property='og:url' content='http://vgn.in/customerzone/customerlogin'/>
<meta property='og:site_name' content='VGN Projects Estates Pvt Ltd'/>
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
  .footer_bg{
    background-color: #2a3036;
    font-size: 12px;
    color: #7e8082;
    position: absolute;
    bottom:0px;
    padding: 10px;
    width: 100%;
    /* line-height: 40px; */
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

 
<div class="login-box">
 <a href="{{ url('/')}}">
  <div class="login-logo">
    <img src="{{ config('app.AWS_URL')}}/images/custom/vgn-logo.png" align="center" >
  </div>
  </a>
  <!-- /.login-logo -->
  <div class="login-box-body box-body">
    <h4 class="login-box-msg" style="background-color:#f7f7f7; font-size: 18px; text-align: center; padding: 7px 10px; margin-top: 0;">Customer Login</h4>
    <br>  

      <div id="spinner">
        <div class="text-center">
    <img src="{{ config('app.AWS_URL')}}/images/loader11.gif" width="60" height="60" alt="img loader">
    </div>
  </div>

    <form id="signinform" method="POST" action="{{ url('/customerzone/customerlogin')}}">
    @csrf
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


<form id="forgotform" action="">
      <div class="form-group has-feedback">
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
        <input type="text" class="form-control" id="forgotusername" name="forgotusername" id="fcid"  value="" placeholder="Enter Customer ID (or) Regd. Mail ID (or) Mobile">
                
      </div>

      <div class="row">
        <div class="col-xs-6">
         
        </div>
        <!-- /.col -->
        <div class="col-xs-6">
          <button type="button" id="sendotp" class="btn btn-danger btn-block btn-flat">Send OTP</button>
        </div>        
        <!-- /.col -->
      </div>

      

    </form>
    
  <div class="row" id="otpresponsetext" style="margin: 2px;">
        
      </div>
    
    <!-- /.social-auth-links -->
    
    <a href="#" id="forgotpwd"><i class="fa fa-question-circle margin-r-5"></i> I forgot my password</a>
    <a href="#" id="clogin"><i class="fa fa-user margin-r-5"></i> Customer Login</a><br>  
    
    
    

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->
</div>
<footer class="footer_bg">
    <div class="container text-center p-2 pt-3 pb-1 ">
        <p class=""> Copyright &#xa9; 2023 VGN Projects Estates Pvt Ltd, All Rights Reserved.</p>        
    </div>
</footer>
@endsection

@section('script')
@include('newcustomerzone.js.signinjs')
<script>
  
    var CCOUNT;
    

  $("document").ready(function() {
    $("#spinner").hide();
    $("#clogin").hide();

    $("#forgotform").hide();
    $("#forgotpwd").on("click", function(){
      $("#signinform").removeAttr("style").hide();
      $("#forgotpwd").removeAttr("style").hide();
	var user = $("#cid").val();
      if (user != '') {
        $("#forgotusername").val(user);
      }
      else{
       $("#forgotusername").val(''); 
      } 
      $("#spinner").show();
      $(".login-box-msg").text('Forgot Password');
      setTimeout(function(){
        
        $("#forgotform").show();
        $("#clogin").show();
         
      $("#spinner").removeAttr("style").hide();  
      },400);
      
    });

    $("#clogin").on("click", function(){
      $("#forgotform").removeAttr("style").hide();
      $("#clogin").removeAttr("style").hide();
      $("#spinner").show();
      $(".login-box-msg").text('Customer Login');
      setTimeout(function(){
        $("#signinform").show();
        
      
      $("#forgotpwd").show();
      $("#spinner").removeAttr("style").hide();
      },400);
    });


    $("#sendotp").on("click", function(){
      var username = $("#forgotusername").val();
      $("#otpresponsetext").html('');
      $("#spinner").show();
      if (username != '') {
        $.post("{{ url('/customerzone/forgotpassword')}}",{_token:'{{csrf_token()}}','forgotusername' : username}, function(data){
          $("#spinner").hide();
          console.log(data);
          if (data == '1') {
            $("#sendotp").text('Resend OTP');
            $("#sendotp").attr('disabled',true);
            $("#otpresponsetext").html(`<div clas="row" id="otpdiv"><p style="margin-top:5px; font-weight:500;">Please enter the OTP Sent to your registered mobile number and Mail ID. OTP expires in <span id="otpexpirycounter" style="font-weight:bold;">90</span> Seconds.</p>
              <br>

              <div class="form-group has-feedback">
        <span class="glyphicon glyphicon-pencil form-control-feedback"></span>
        <input type="text" class="form-control" id="submitotp" name="submitotp" value="" placeholder="Enter OTP">
        <p class="errortext" id="otperror"></p>
      </div>

      <div class="row">
        <div class="col-xs-6">
         
        </div>
        <div class="col-xs-6">
          <button type="button" onclick="submitotpfn();" class="btn btn-danger btn-block btn-flat">Submit OTP</button>
        </div>        
      </div>
              </div>`);
            CCOUNT  = '90';
            cdreset(); 
            countdown();         

            $("#otpdiv").show(); 

            
          }
          else{
            alert(data);
            window.location.href="/customerzone/customerlogin";
          }
          //$("#otpsubmit").show();
        });  
      }
      else{
        alert('Please fill the required field!');
        $("#spinner").hide();
      }
      
    });
    
  });

  var t, count = 90;

  function submitotpfn(){
  var username1 = $("#forgotusername").val();
  var submitotp = $("#submitotp").val();

  $("#spinner").show();
  
  if ((username1 != '') && (submitotp != '')) {
    $.post("{{ url('/customerzone/otpvalidation')}}",{_token:'{{csrf_token()}}','forgotusername' : username1,'submitotp': submitotp}, function(data){
      $("#spinner").hide();
        if(data == '1'){
            window.location.href='/customerzone/resetlink';
        }
        else{
          $("#otperror").text('Invalid OTP Code.');
        }
    });
  }
}

function cddisplay() {
    document.getElementById('otpexpirycounter').innerHTML = count;
}

function countdown() {
    // starts countdown
    cddisplay();
    if (count === 0) {
        $("#sendotp").attr('disabled',false);
        $("#otpdiv").hide();
    } else {
        count--;
        t = setTimeout(countdown, 1000);
    }
}

function cdpause() {
    // pauses countdown
    clearTimeout(t);
}

function cdreset() {
    // resets countdown
    cdpause();
    count = CCOUNT;
    cddisplay();
}

</script>
@endsection
