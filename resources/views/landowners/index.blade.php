@extends('newvendorzone.layout')
@section('title')
VGN Projects Estates Pvt Ltd |Land Owners
@endsection

@section('description')
<META NAME="Subject" CONTENT="VGN Projects Estates - Land Owners">
<meta name="description" content="VGN Projects Estates - Land Owners">
<meta name="keywords" content="Premium real estate developers in chennai, Leading property developers in chennai, Plots promoters in chennai, Approved plots in ambattur, Approved residential plots in ambattur">
<META NAME="Language" CONTENT="English">
<META NAME="Distribution" CONTENT="Global">
<META NAME="Robots" CONTENT="All">
<META NAME="Revisit-After" CONTENT="7 Days">
@endsection

@section('keyword')  
@endsection


@section('style')
@include('newvendorzone.styles.commoncss')
<link rel="stylesheet" href="{{ asset('assets/libs/sweetalert/sweet-alert.css')}}">
<style>
.login-page{
        background: url("{{ config('app.AWS_URL')}}/newcustomerzoneassets/img/pattern.jpg") repeat;
    }

    .errorcolor{
      border-color: red;
    box-shadow: 0 0 0 0.2rem #d24c3b;
    }

    .successcolor{
       border-color: green;
    }

    #contactpersonpan
    {
        text-transform: uppercase;
    }
    .error
    {
        color: red;
        visibility: hidden;
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

																	

<div class="row">
 <div class="col-md-4 col-md-offset-4">
<div class="mainbox">
  <div class="login-logo">
   <a href="{{ url('/')}}"> <img src="{{ config('app.AWS_URL')}}/images/custom/vgn-logo.png" align="center" ></a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body box-body">
    <h4 class="login-box-msg" style="background-color:#f7f7f7; font-size: 18px; text-align: center; padding: 7px 10px; margin-top: 0;"><i class="fa fa-users"></i> For Land Owners</h4>
    <p  style="line-height: 1.2rem;text-align: center;">(For land owners, who are willing to sell their land/develop properties on joint venture basis.)</p>
    <br>

    @if($errors->count() > 0)
    <div id="ERROR_COPY" style="display: none;" class="alert alert-danger">
      <ol>
      @foreach($errors->all() as $error)
      <li>{{ $error }}</li>
      @endforeach
    </ol>
    </div>
  @endif

    <form id="myForm" class="form-horizontal" method="POST" action="{{ url('/landowners') }}">
    {{ csrf_field() }}
      
      <div class="form-group">
                  <label for="Name" class="col-sm-4 control-label">Name of the land owner*</label>

                  <div class="col-sm-8">
                    <input type="text" class="form-control" name="Name" id="Name" placeholder="Name of the land owner" value="{{old('Name')}}">
                    {!! $errors->first('Name', '<span class="errortext text-red">:message</span>') !!}
                  </div>
     </div>

     <!-- <div class="form-group">
                  <label for="Mobile" class="col-sm-4 control-label">Mobile Number*</label>

                  <div class="col-sm-8">
                    <input type="text" class="form-control" name="Mobile" id="Mobile" placeholder="Mobile Number" value="{{old('Mobile')}}">
                    {!! $errors->first('Mobile', '<span class="errortext text-red">:message</span>') !!}
                  </div>
     </div> -->
     <div class="form-group">
        <label for="Mobile" class="col-sm-4 control-label">Mobile Number*</label>
        <div class="col-sm-8">
          <input type="text" class="form-control" name="Mobile" id="Mobile" placeholder="Mobile Number" value="{{old('Mobile')}}" required="true">
          <span id="lblmobileCard" class="error">Mobile Number already registered</span>
          <span class="text-success pull-right verifytext" style="font-size: bold;"><i class="fa fa-check"></i> Verified</span>
          <!-- <button class="btn btn-warning pull-right" type="button" id="getmobileotp">Get Mobile OTP</button> -->
          {!! $errors->first('Mobile', '<span class="errortext text-red">:message</span>') !!}
        </div>
    </div>
    <!-- <div style="text-align:center" id="loadergif">
        <img src="{{ config('app.AWS_URL')}}/images/loader11.gif" alt="loader" width="60">
    </div> -->
    <!-- <div class="form-group" id="verifymobilediv">
        <label for="mobileotp" class="col-sm-4 control-label">Verify Mobile Number (Mobile)*</label>
        <div class="col-sm-8">
          <input type="text" class="form-control" placeholder="Enter Mobile OTP" id="mobileotp" name="mobileotp" aria-label="Enter Mobile OTP" >
          <button class="btn btn-danger pull-right" type="button" id="verifymobileotp"><i class="fa fa-check"></i> Verify Mobile</button>
        </div>
    </div> -->

      <div class="form-group">
                  <label for="Email" class="col-sm-4 control-label">Email Address (Optional)</label>

                  <div class="col-sm-8">
                    <input type="email" class="form-control" name="Email" id="Email" placeholder="Email Address" value="{{old('Email')}}">
                    {!! $errors->first('Email', '<span class="errortext text-red">:message</span>') !!}
                  </div>
     </div>

      

      <div class="form-group">
                  <label for="Location" class="col-sm-4 control-label">Land Location*</label>

                  <div class="col-sm-8">
                    <!-- <input type="text" class="form-control" name="Location" id="Location" placeholder="Land Location" value="{{old('Location')}}"> -->
                    <textarea name="Location" cols="5" rows="10" class="form-control" name="Location" id="Location" placeholder="Land Location" required="true"></textarea>
                    {!! $errors->first('Location', '<span class="errortext text-red">:message</span>') !!}
                  </div>
     </div>

     

      <div class="form-group">
                  <label for="Extent" class="col-sm-4 control-label">Land Extent in (Acres/Grounds)*</label>

                  <div class="col-sm-5">
                    <input type="text" class="form-control" name="Extent" id="Extent" placeholder="Extent" value="{{old('Extent')}}">
                    {!! $errors->first('Extent', '<span class="errortext text-red">:message</span>') !!}
                  </div>
                   <div class="col-sm-3">
                    <select class="form-control" name="extent_type" id="extent_type" required="true" >
      <option value="Acres" selected>Acres</option>
      <option value="Grounds">Grounds</option>
    </select>
                  </div>
     </div>
     
              
                
               
        

                
                 

                

                
              
       
      
      <div class="row">
        
        <!-- /.col -->
        <div class="col-sm-4 col-sm-offset-4">
          <button type="submit" class="btn btn-danger btn-block btn-flat" id="sub"><i class="fa fa-send"></i> Submit</button>
        </div>
        <!-- /.col -->
      </div>
    </form>

    <!-- <button type="submit" class="btn btn-danger btn-block btn-flat" id="formdata"><i class="fa fa-send"></i> DATA</button>    -->
    

  </div>
  <!-- /.login-box-body -->
</div>
</div>
</div>
<!-- /.login-box -->
@endsection

@section('script')

@include('newvendorzone.js.commonjs')
<script src="{{ asset('assets/libs/sweetalert/sweet-alert.min.js')}}"></script>

<script type="text/javascript">
  $(document).ready(function(){

    var has_errors = {{ ($errors->count() > 0) ? 'true' : 'false'}};
    if (has_errors) {
    console.log($("#ERROR_COPY").html());
    swal({
    title: "Errors!",
    type: "error",
    text: $("#ERROR_COPY").text(),
    showCloseButton: true
    });
    $("#Name").focus();
    }

    $("#verifymobilediv").hide();
    $("#loadergif").hide();
    $(".verifytext").hide();

    $("#getmobileotp").on("click", function () {


    $("#loadergif").show();


    var mobileno = $("#Mobile").val();


    if (mobileno != '') {
    $("#lblmobileCard").css("visibility", "hidden");
    $.post('/vendorzone/sendandsavevendor_registerotp', {
    _token: "{{csrf_token()}}",
    mobileotp: mobileno
    }, function (data) {

    $("#loadergif").hide();

    var res = JSON.parse(data);

    if (res.status == 1) {
      $("#getmobileotp").text('Resend OTP');

      $("#verifymobilediv").fadeIn(() => {
        $("#verifymobilediv").show();
      });


    } else if (res.status == 2) {
      $("#loadergif").hide();
      alert('Too Many attempts requested for OTP. Try after 30 Minutes!');
    } else if (res.status == 3) {
      $("#loadergif").hide();
      alert('Invalid Mobile Number!');
    } else if (res.status == 4) {
      $("#loadergif").hide();
      $("#Mobile").val('');
      $("#Mobile").addClass('errorcolor');
      $("#lblmobileCard").text('');
      //$("#lblmobileCard").text(`Vendor already exists for this Mobile Number!`);
      //$(".verifytextpan").hide();
      $("#lblmobileCard").css("visibility", "visible");
      //alert('Mobile Number already registered!');
    } else if (res.status == 5) {
      $("#loadergif").hide();
      $("#Mobile").val('');
      $("#Mobile").addClass('errorcolor');
      $("#lblmobileCard").text('');
     // $("#lblmobileCard").text(`Vendor Registration is in process for this Mobile Number!`);
      //$(".verifytextpan").hide();
      $("#lblmobileCard").css("visibility", "visible");
      //alert('Mobile Number already registered!');
    } else {
      $("#loadergif").hide();
      alert('Mobile OTP not sent. Try Again!');
    }
    });


    } else {
    alert('Mobile Number should not be empty!');
    $("#Mobile").focus();
    $("#loadergif").hide();
    }


    });

    // $("#formdata").on("click", function () {

    //   $.get('/landownersdata', {
    // _token: "{{csrf_token()}}",
    // }, function (data) {
    //   console.log(data);
    // });
    // }); 

    $("#verifymobileotp").on("click", function () {

    var mobileotp = $("#mobileotp").val();
    var mobileno1 = $("#Mobile").val();
    if (mobileotp != '') {
    $.post('/vendorzone/validatemobileotp', {
    _token: "{{csrf_token()}}",
    mobileotpbyuser: mobileotp,
    mobileno1: mobileno1
    }, function (data1) {

    var newdata1 = JSON.parse(data1);

    if (newdata1.otpverified == 0) {
      $("#mobileotp").addClass('errorcolor');
      $("#Mobile").removeClass('successcolor');
      
    } else {
      $("#mobileotp").removeClass('errorcolor');
      $("#Mobile").removeClass('errorcolor');
      $("#Mobile").addClass('successcolor');
      $("#Mobile").attr('readonly', true);


      $("#verifymobilediv").hide();
      $("#getmobileotp").hide();
      $(".verifytext").show();


    }
    });
    } else {
    alert('Enter Mobile OTP to verify!');
    $("#loadergif").hide();
    }


    });




  });


</script>

 @if(session()->has('suc_msg'))
<script>
  swal({
    title: "Successfully Submitted!",
    text: "Thanks for your interest. We will get back to you shortly.",
    type: "success"
  });
</script>
@endif
@if(session()->has('error_msg'))
<script>
  swal({
    title: "The mobile number is not verified.",
    text: "Try again!",
    type: "error"
  });
</script>

@endif

@endsection
