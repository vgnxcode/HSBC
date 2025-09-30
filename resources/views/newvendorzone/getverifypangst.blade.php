@extends('newvendorzone.layout')

@section('title')
VGN Projects Estates Pvt Ltd |Vendor Zone| Vendor Verify PAN/GST Page
@endsection

@section('description')
<META NAME="Subject" CONTENT="VGN Projects Estates - Vendor Verify PAN/GST Page">
<meta name="description" content="VGN Projects Estates - Vendor Verify PAN/GST Page">
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

<script src="{{ config('app.AWS_URL')}}/newcustomerzoneassets/dist/js/defines.js"></script>
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
    #registration_proof_number
    {
        text-transform: uppercase;
    }
    .error
    {
        color: red;
        visibility: hidden;
    }

    #contactpersonpan
    {
        text-transform: uppercase;
    }
    #registration_proof_number
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
 <div class="col-md-6 col-md-offset-3">
<div class="mainbox box box-danger">
  <div class="login-logo">
   <a href="{{ url('/')}}"> <img src="{{ config('app.AWS_URL')}}/images/custom/vgn-logo.png" align="center" ></a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body box-body">
    <h4 class="login-box-msg" style="background-color:#f7f7f7; font-size: 18px; text-align: center; padding: 7px 10px; margin-top: 0;">Vendor KYC Verification</h4>
    <br>

<div class="col-sm-12">
         
                <div class="alert alert-danger">
                
                <h4><i class="icon fa fa-info-circle"></i> Note:</h4>
                <p>Dear {{$mmvend['vendorname']}},<br/>As per government regulation, we are in the process of updating our vendor KYC details. Kindly update your valid data to process future payments.</p>
              </div>
                <br>
         
                
              </div>
    <form id="myForm" class="form-horizontal" method="POST" action="{{ url('/vendorzone/getverifypangst')}}/{{$vcode}}" enctype="multipart/form-data">
    {{ csrf_field() }}
      
      <div class="form-group">
                  <label for="contactperson" class="col-sm-4 control-label">Vendor Id*</label>

                  <div class="col-sm-8">
                    <input type="text" class="form-control"  value="{{$mmvend['vendorid']}}" readonly="true">
                  </div>
                </div>
     
      <div class="form-group">
                  <label for="contactperson" class="col-sm-4 control-label">Vendor Name*</label>

                  <div class="col-sm-8">
                    <input type="text" class="form-control"  value="{{$mmvend['vendorname']}}" readonly="true">
                  </div>
                </div>
              

                <div class="form-group">
                  <label for="registration_proof" class="col-sm-4 control-label">Registration Proof*</label>

                  <div class="col-sm-8">
                    @if($proofoption == '')
                    <label class="radio-inline"><input type="radio" name="registration_proof" value="gstno" checked>GST Number</label>
<label class="radio-inline"><input type="radio" name="registration_proof" value="panno" >PAN Number</label>
                    {!! $errors->first('registration_proof', '<span class="errortext text-red">:message</span>') !!}
                    @else
                    <label class="radio-inline"><input type="radio" name="registration_proof" checked="true" >{{strtoupper($proofoption)}} Number</label>
                    @endif
                  </div>
                  
     </div>

     <div class="form-group">
                  <label for="registration_proof_number" class="col-sm-4 control-label">Registration Proof Number*</label>

                  <div class="col-sm-8">
                    @if($proofoptionvalue == '')
                   <input type="text" class="form-control" name="registration_proof_number" id="registration_proof_number" placeholder="Enter GST Registration No." value="{{old('registration_proof_number')}}" required="true">
                   <span id="lblRegproofCard" class="error">Invalid PAN Number</span>
                    {!! $errors->first('registration_proof_number', '<span class="errortext text-red">:message</span>') !!}
                    @else
                    <input type="text" class="form-control" name="registration_proof_number" id="registration_proof_number" placeholder="Enter GST Registration No." value="{{$proofoptionvalue}}" readonly="true">
                    @endif

                  </div>
                </div>

                
              
                @if($mmvend['mobilenumber'] == '')
                <div class="form-group">
                  <label for="update_mobile_number" class="col-sm-4 control-label">Update Mobile Number*</label>

                  <div class="col-sm-8">
                    @if($updatedmobilenumber == '')
                   <input type="number" class="form-control" name="update_mobile_number" id="update_mobile_number" placeholder="Enter Mobile Number." value="" required="true">
                   <span id="lblmobileCard" class="error">Mobile Number already registered</span>
                   <span class="text-success pull-right verifytext" style="font-size: bold;"><i class="fa fa-check"></i> Verified</span>

                    <button class="btn btn-warning pull-right" type="button" id="getmobileotp">Get Mobile OTP</button>
                    
                    @else
                    <input type="number" class="form-control" name="update_mobile_number" id="update_mobile_number" value="{{$updatedmobilenumber}}" readonly="true">
                    @endif

                  </div>
                </div>


                <div style="text-align:center" id="loadergif">
<img src="{{ config('app.AWS_URL')}}/images/loader11.gif" alt="loader" width="60">
</div>

<div class="form-group" id="verifymobilediv">
  <label for="mobileotp" class="col-sm-4 control-label">Verify Mobile Number (Mobile)*</label>
<div class="col-sm-8">
                  
  <input type="text" class="form-control" placeholder="Enter Mobile OTP" id="mobileotp" name="mobileotp" aria-label="Enter Mobile OTP" >
  
    
    <button class="btn btn-danger pull-right" type="button" id="verifymobileotp"><i class="fa fa-check"></i> Verify Mobile</button>
  

</div>
</div>
                @endif

                 @if($mmvend['emailid'] == '')
                <div class="form-group">
                  <label for="update_email_address" class="col-sm-4 control-label">Update Email Address*</label>

                  <div class="col-sm-8">
                    @if($updatedemailid == '')
                   <input type="email" class="form-control" name="update_email_address" id="update_email_address" placeholder="Enter Email Address." value="{{old('update_email_address')}}" required="true">
                    <span id="lblemailidCard" class="error">Emailid already registered</span>
                    <span class="text-success pull-right verifytextemail" style="font-size: bold;"><i class="fa fa-check"></i> Verified</span>
                    <button class="btn btn-warning pull-right" type="button" id="getemailotp">Get Email OTP</button>
                    @else
                    <input type="email" class="form-control" name="update_email_address" id="update_email_address" value="{{$updatedemailid}}" readonly="true">
                    @endif

                  </div>
                </div>

                <div style="text-align:center" id="loadergifemail">
<img src="{{ config('app.AWS_URL')}}/images/loader11.gif" alt="loader" width="60">
</div>
                <div class="form-group" id="verifyemaildiv">
  <label for="emailotp" class="col-sm-4 control-label">Verify Email Address*</label>
<div class="col-sm-8">
                  
  <input type="text" class="form-control" placeholder="Enter Email OTP" id="emailotp" name="emailotp" aria-label="Enter Email OTP" >
  
    
    <button class="btn btn-danger pull-right" type="button" id="verifyemailotp"><i class="fa fa-check"></i> Verify Email</button>
  

</div>
</div>
                @endif

                
                

                @if($updatedtime != '')
                <div class="form-group">
                  <label for="createdtime" class="col-sm-4 control-label">Data Created Time*</label>

                  <div class="col-sm-8">
                    
                    <input type="text" class="form-control" name="createdtime" id="createdtime" placeholder="Enter GST Registration No." value="{{ \Carbon\Carbon::parse($updatedtime)->format('d M, Y H:i:s A')}}" readonly="true">

                  </div>
                </div>
                @endif


       
      
      <div class="row">
        @if($proofoption == '')
        <!-- /.col -->
        <div class="col-sm-4 col-sm-offset-4">
          <button type="submit" class="btn btn-danger btn-block btn-flat" id="sub">Submit</button>
        </div>
        @endif
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



<script type="text/javascript">

  
										$(document).ready(function(){

                      
                     /* $("#sub").on('click', function (argument) {
                        $(selector).trigger("change");
                      });*/
                      //registration_proof
                      $('input[type=radio][name=registration_proof]').change(function() {
    if (this.value == 'gstno') {
      $("#lblRegproofCard").css("visibility", "hidden");
      
        $("#registration_proof_number").val('');
        $("#registration_proof_number").attr("placeholder", "Enter GST Registration No.");
    }
    else if (this.value == 'panno') {
      $("#lblRegproofCard").css("visibility", "hidden");
        
        $("#registration_proof_number").val('');
        $("#registration_proof_number").attr("placeholder", "Enter PAN No.");
    }
});


                     $("#lblRegproofCard").text('');


                      $("#registration_proof_number").on('change', function(){
                        var panregex = /([A-Z]){5}([0-9]){4}([A-Z]){1}$/;
                        var gstregex = /^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$/;
                        var regchecked = $('input[name=registration_proof]:checked').val();
                        //alert(regchecked);
                        var inptype = '';
                        if ((regchecked == 'panno') || (regchecked == 'gstno')) {
                          var regproofval = $("#registration_proof_number").val();

                          if (regproofval != '') {
                        regproofval = regproofval.toUpperCase();

                        if (regchecked == 'panno') {
            if (panregex.test(regproofval)) {
                $("#lblRegproofCard").css("visibility", "hidden");
                inptype = 'PAN';

                } else {
              $("#lblRegproofCard").text('');
                     $("#lblRegproofCard").text(`Invalid PAN Number!`);
                $("#lblRegproofCard").css("visibility", "visible");
                return false;
            }
          }

          if (regchecked == 'gstno') {
            if (gstregex.test(regproofval)) {
                $("#lblRegproofCard").css("visibility", "hidden");
                inptype = 'GST';

                } else {
              $("#lblRegproofCard").text('');
                     $("#lblRegproofCard").text(`Invalid GST Number!`);
                $("#lblRegproofCard").css("visibility", "visible");
                return false;
            }
          }

                

                
            
          }
          else{
            alert('Registration Proof No required!');
          }


                        }

                        

                      });





                      $(".verifytext").hide();
                      $("#verifymobilediv").hide();
                    $("#verifyemaildiv").hide();
                    $("#loadergif").hide();
                    $("#loadergifemail").hide();
                      //$("#lblmobileCard").text('');
                       $("#getmobileotp").on("click", function(){


                      

                         $("#loadergif").show();
 
 
                      var mobileno = $("#update_mobile_number").val();

                    


                      if (mobileno != '') {
                        $("#lblmobileCard").css("visibility", "hidden");
                        $.post('/vendorzone/getverifysendandsavevendor_registerotp', {_token: "{{csrf_token()}}", mobileotp: mobileno}, function(data){
                         
                          $("#loadergif").hide();

                          var res = JSON.parse(data);
                          
                          if (res.status == 1) {
$("#getmobileotp").text('Resend OTP');

$("#verifymobilediv").fadeIn(() => {
          $("#verifymobilediv").show();
        });

                         



                          }
                          else if(res.status == 2){
                            $("#loadergif").hide();
                            alert('Too Many attempts requested for OTP. Try after 30 Minutes!');
                          }
                          else if(res.status == 3){
                            $("#loadergif").hide();
                            alert('Invalid Mobile Number!');
                          }
                          else if(res.status == 4){
                            $("#loadergif").hide();
                           $("#update_mobile_number").val('');
                    $("#update_mobile_number").addClass('errorcolor');
                    $("#lblmobileCard").text('');
                     $("#lblmobileCard").text(`Vendor already exists for this Mobile Number!`);
                     //$(".verifytextpan").hide();
                    $("#lblmobileCard").css("visibility", "visible");
                            //alert('Mobile Number already registered!');
                          }
                           else if(res.status == 5){
                            $("#loadergif").hide();
                           $("#update_mobile_number").val('');
                    $("#update_mobile_number").addClass('errorcolor');
                    $("#lblmobileCard").text('');
                     $("#lblmobileCard").text(`Vendor Registration is in process for this Mobile Number!`);
                     //$(".verifytextpan").hide();
                    $("#lblmobileCard").css("visibility", "visible");
                            //alert('Mobile Number already registered!');
                          }
                          else{
                           $("#loadergif").hide();
                            alert('Mobile OTP not sent. Try Again!');
                          }
                        });
                        

                        

                        
                      }
                      else{
                        alert('Mobile Number should not be empty!');
                        $( "#update_mobile_number" ).focus();
                        $("#loadergif").hide();
                      }
                      

                      
                    });


                        $("#verifymobileotp").on("click", function(){

                      var mobileotp = $("#mobileotp").val();
                      var mobileno1 = $("#update_mobile_number").val();
                      if (mobileotp != '') {
                     $.post('/vendorzone/getverifyvalidatemobileotp', {_token: "{{csrf_token()}}", mobileotpbyuser: mobileotp, mobileno1: mobileno1 }, function(data1){
                            
                            var newdata1 = JSON.parse(data1);
                            
                            if (newdata1.otpverified == 0) {
                              $("#mobileotp").addClass('errorcolor');
                              $("#update_mobile_number").removeClass('successcolor');
                            }
                            else{
                             $("#mobileotp").removeClass('errorcolor'); 
                             $("#update_mobile_number").removeClass('errorcolor'); 
                             $("#update_mobile_number").addClass('successcolor');
                              $("#update_mobile_number").attr('readonly', true);

                             
                        $("#verifymobilediv").hide();
                        $("#getmobileotp").hide();
                        $(".verifytext").show();
        

                            }
  });
                   }else{
                    alert('Enter Mobile OTP to verify!');
                    $("#loadergif").hide();
                   }


                    });

                        $(".verifytextemail").hide();
                         $("#getemailotp").on("click", function(){

                         $("#loadergifemail").show();
 
 
                      var emailid = $("#update_email_address").val();

                    


                      if (emailid != '') {


                        $("#lblemailidCard").css("visibility", "hidden");
                        $.post('/vendorzone/getverifysendandsavevendor_registerotpemail', {_token: "{{csrf_token()}}", emailotp: emailid}, function(data){
                          //console.log(data);
                          $("#loadergifemail").hide();

                          var res = JSON.parse(data);
                          
                          if (res.status1 == 1) {
$("#getemailotp").text('Resend Email OTP');

$("#verifyemaildiv").fadeIn(() => {
          $("#verifyemaildiv").show();
        });

                         



                          }
                          else if(res.status1 == 2){
                            $("#loadergifemail").hide();
                            alert('Too Many attempts requested for OTP. Try after 30 Minutes!');
                          }
                          else if(res.status1 == 3){
                            $("#loadergifemail").hide();
                            alert('Invalid Email Address!');
                          }
                          else if(res.status1 == 4){
                            $("#loadergifemail").hide();
                           $("#update_email_address").val('');
                    $("#update_email_address").addClass('errorcolor');
                    $("#lblemailidCard").text('');
                     $("#lblemailidCard").text(`Vendor already exists for this Emailid!`);
                     //$(".verifytextpan").hide();
                    $("#lblemailidCard").css("visibility", "visible");
                            //alert('Mobile Number already registered!');
                          }
                          else if(res.status1 == 5){
                            $("#loadergifemail").hide();
                           $("#update_email_address").val('');
                    $("#update_email_address").addClass('errorcolor');
                    $("#lblemailidCard").text('');
                     $("#lblemailidCard").text(`Vendor Registration is in process for this Emailid!`);
                     //$(".verifytextpan").hide();
                    $("#lblemailidCard").css("visibility", "visible");
                            //alert('Mobile Number already registered!');
                          }
                          else if(res.status1 == 88){
                            $("#loadergifemail").hide();
                           $("#update_email_address").val('');
                    $("#update_email_address").addClass('errorcolor');
                    $("#lblemailidCard").text('');
                     $("#lblemailidCard").text(`Please enter the official mailid for this business type!`);
                     //$(".verifytextpan").hide();
                    $("#lblemailidCard").css("visibility", "visible");
                            //alert('Mobile Number already registered!');
                          }

                          else{
                            $("#loadergifemail").hide();
                            alert('Email OTP Not sent. Try again!');
                          }
                        });
                        

                        

                        
                      }
                      else{
                        $( "#update_email_address" ).focus();
                        $("#loadergifemail").hide();
                        alert('Emailid should not be empty!');
                      }
                      

                      
                    });

                    $("#verifyemailotp").on("click", function(){

                      var emailotp = $("#emailotp").val();
                      var email1 = $("#update_email_address").val();
                      if (emailotp != '') {
                     $.post('/vendorzone/getverifyvalidateemailotp', {_token: "{{csrf_token()}}", emailotpbyuser: emailotp, email1: email1 }, function(data1){
                            
                            var newdata1 = JSON.parse(data1);
                            
                            if (newdata1.emailotpverified == 0) {
                              $("#emailotp").addClass('errorcolor');
                              $("#update_email_address").removeClass('successcolor');
                            }
                            else{
                             $("#emailotp").removeClass('errorcolor'); 
                             $("#update_email_address").removeClass('errorcolor'); 
                             $("#update_email_address").addClass('successcolor');
                              $("#update_email_address").attr('readonly', true);
                              $("#verifytextemail").show();

                             
                        $("#verifyemaildiv").hide();
                        $("#getemailotp").hide();
                        $(".verifytextemail").show();
        

                            }
  });
                   }else{
                    alert('Enter Email OTP to verify!');
                   }


                    });

          
							
									});
									
								</script>

@endsection
