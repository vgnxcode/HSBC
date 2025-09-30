@extends('newcustomerzone.layout')

@section('title')
Sales Sitevisit Feedback
@endsection

@section('description')
    
@endsection

@section('keyword')  
@endsection


@section('style')
<!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{{ config('app.AWS_URL')}}/newcustomerzoneassets/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ config('app.AWS_URL')}}/newcustomerzoneassets/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{ config('app.AWS_URL')}}/newcustomerzoneassets/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ config('app.AWS_URL')}}/newcustomerzoneassets/dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{ config('app.AWS_URL')}}/newcustomerzoneassets/plugins/iCheck/minimal/red.css">

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  

<style>
    .login-page{
        background: url("{{ config('app.AWS_URL')}}/newcustomerzoneassets/img/pattern.jpg") repeat;
    }
  
  .login-box
  {
    background: #fff;
    padding-top:8px;
    position: relative;
  top: 20%;
  transform: translateY(+5%);
  
  }
  .errortext {
    color: #c7254e;
  }
  .login-box {
    margin: auto;
  }

 .card {
  box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
  transition: 0.3s;
}

.card:hover {
  box-shadow: 0 12px 32px 0 rgba(0,0,0,0.2);
}
</style>
@endsection

@section('bodycontent')
<body class="hold-transition login-page"  >

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

 
<div class="login-box box box-danger card">
 <a href="{{ url()->full() }}">
  <div class="login-logo">
    <img src="{{ config('app.AWS_URL')}}/images/custom/vgn-logo.png" align="center" >
  </div>
  </a>
  <!-- /.login-logo -->
  <div class="login-box-body box-body" >
    <h4 class="login-box-msg" style="background-color: #F44336; font-size: 18px; text-align: center; padding: 7px 10px; margin-top: 0;color: #fff;border-radius: 3px;font-weight: 600;">Sales Sitevisit Feedback</h4>
    <br>

    <form id="myForm" method="POST" action="{{ url('/svfb/')}}/{{$leadno}}">
    {{ csrf_field() }}
    <div class="row">
      <label for="customerid" class="col-md-12" style="font-weight: 600;">1. Whether our sales representative  helped you to locate the site easily?</label>
      
    </div>
    <div class="row" style="margin-left: 3px;">
      <span class="col-md-12"> <!-- radio -->
              <div class="form-group" >
                <label style="font-weight: 600;">
                  <input type="radio" name="r2" value="Y" class="minimal-red" checked>
                  Yes
                </label>&nbsp;&nbsp;
                <label style="font-weight: 600;">
                  <input type="radio" name="r2" value="N" class="minimal-red">
                  No
                </label>
               
              </div></span>
    </div>
    <br>
    <div class="row">
      <label for="customerid" class="col-md-12" style="font-weight: 600;">2. How long did you wait to meet our sales representative after reaching the site?</label>
      
    </div>
    <div class="row" style="margin-left: 3px;">
      <span class="col-md-12">
        <div class="form-group">
                <label style="font-weight: 600;">
                  <input type="radio" name="r3" value="LT3" class="minimal-red" checked>
                  Less than 3 Minutes
                </label>
                <label style="font-weight: 600;">&nbsp;&nbsp;
                  <input type="radio" name="r3" value="MT3" class="minimal-red">
                  More than 3 Minutes
                </label>
               
              </div></span>
    </div>
    <br>
    <div class="row">
      <label for="customerid" class="col-md-12" style="font-weight: 600;">3. Are you happy with the knowledge level of our sales representative with regards to the project?</label>
      
    </div>
    <div class="row" style="margin-left: 3px;">
      <span class="col-md-12">
        <div class="form-group" >
                <label style="font-weight: 600;">
                  <input type="radio" name="r4" value="Y" class="minimal-red" checked>
                  Yes
                </label>&nbsp;&nbsp;
                <label style="font-weight: 600;">
                  <input type="radio" name="r4" value="N" class="minimal-red">
                  No
                </label>
               
              </div></span>
    </div>
      
  
      <div class="row">
        
        <!-- /.col -->
        <div class="col-xs-8 col-xs-offset-2">
          <button type="submit" id="subt"  class="btn btn-danger btn-block btn-flat">Submit</button>
        </div>
        <!-- /.col -->
      </div>
    </form>
<div style="text-align:center" id="loadergif">
<img src="{{ config('app.AWS_URL')}}/images/loader11.gif" alt="loader" width="60">
</div>    

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->
</div>
@endsection

@section('script')
@include('newcustomerzone.js.signinjs')
<script>
  @if((session()->has('suc_msg')) || (session()->has('error_msg')))
  $("#loadergif").hide();
  $("#subt").hide();
    setTimeout(function(){
      window.location.href= '{{ url()->full() }}/Premium-Real-Estate-Developers-in-Chennai';
    },3000);
  @endif
  $(function () {
   //Red color scheme for iCheck
    $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
      checkboxClass: 'icheckbox_minimal-red',
      radioClass   : 'iradio_minimal-red'
    });

$("#loadergif").hide();

$("#subt").on('click', function () {
$("#loadergif").show();  
$("#subt").hide();
})

  });

  
</script>
@endsection
