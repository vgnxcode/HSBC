@extends('newvendorzone.layout')

@section('title')
  VGN Projects Estates Pvt Ltd |Vendor Zone| Vendor Registration Page
@endsection

@section('description')
  <META NAME="Subject" CONTENT="VGN Projects Estates - Vendor Registration">
  <meta name="description" content="VGN Projects Estates - Vendor Registration Page">
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
  .text-muted-aadhar{
   display:inline-block;
  }
  .footer_bg{
    background-color: #2a3036;
    font-size: 12px;
    color: #7e8082;
    /* position: absolute; */
    padding: 10px;
    bottom:0px;
    width: 100%;
    /* line-height: 40px; */
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
        <div class="mainbox">
          <div class="login-logo">
              <a href="{{ url('/')}}"> <img src="{{ config('app.AWS_URL')}}/images/custom/vgn-logo.png" align="center" ></a>
          </div>
          <!-- /.login-logo -->
          <div class="login-box-body box-body">
              <h4 class="login-box-msg" style="background-color:#f7f7f7; font-size: 18px; text-align: center; padding: 7px 10px; margin-top: 0;">Vendor Registration</h4>
              <br>
              <form id="myForm" class="form-horizontal" method="POST" action="{{ url('/vendorzone/registration')}}" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="typeoforganization" class="col-sm-4 control-label">Type of the Organization*</label>
                    <div class="col-sm-8">
                      <select class="form-control" name="type_of_the_organization" id="typeoforganization">
                          <option value="">Select</option>
                          <option value="Sole Proprietor"  @if(old('type_of_the_organization') == 'Sole Proprietor') {{ 'selected' }} @endif >Sole Proprietor</option>
                          <option value="Partnership Firm" @if(old('type_of_the_organization') == 'Partnership Firm') {{ 'selected' }} @endif>Partnership Firm</option>
                          <option value="Company" @if(old('type_of_the_organization') == 'Company') {{ 'selected' }} @endif>Company</option>
                      </select>
                      {!! $errors->first('type_of_the_organization', '<span class="errortext text-red">:message</span>') !!}
                    </div>
                </div>
                <div class="form-group">
                    <label for="registration_proof" class="col-sm-4 control-label">Registration Proof*</label>
                    @if(old('registration_proof') == 'gstno')
                    <div class="col-sm-8">
                      <label class="radio-inline"><input type="radio" name="registration_proof" value="gstno" @if(old('registration_proof') == 'gstno') checked @endif>GST Number</label>
                      <label class="radio-inline"><input type="radio" name="registration_proof" value="panno" @if(old('registration_proof') == 'panno') checked @endif>PAN Number</label>
                      <label class="radio-inline adharoptionshowhide"><input type="radio" name="registration_proof" value="adharno" @if(old('registration_proof') == 'adharno') checked @endif>Aadhar Number</label>
                      {!! $errors->first('registration_proof', '<span class="errortext text-red">:message</span>') !!}
                    </div>
                    @else
                    <div class="col-sm-8">
                      <label class="radio-inline"><input type="radio" name="registration_proof" value="gstno" checked>GST Number</label>
                      <label class="radio-inline"><input type="radio" name="registration_proof" value="panno" >PAN Number</label>
                      <label class="radio-inline adharoptionshowhide" ><input type="radio" name="registration_proof" value="adharno" >Aadhar Number</label>
                      {!! $errors->first('registration_proof', '<span class="errortext text-red">:message</span>') !!}
                    </div>
                    @endif
                </div>
                <div class="form-group">
                    <label for="registration_proof_number" class="col-sm-4 control-label">Registration Proof Number*</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" name="registration_proof_number" id="registration_proof_number" maxlength="15" placeholder="Enter GST Registration No." value="{{old('registration_proof_number')}}" required="true">
                      <span id="lblRegproofCard" class="error">Invalid PAN Number</span>
                      <span class="text-success pull-right verifytextaadhar" style="font-size: bold;"><i class="fa fa-check"></i> Verified</span>
                      <button class="btn btn-warning pull-right" type="button" id="getaadharotp">Get AADHAR OTP</button>
                      <div class="text-muted text-muted-aadhar"></div>
                      {!! $errors->first('registration_proof_number', '<span class="errortext text-red">:message</span>') !!}
                    </div>
                </div>
                <div style="text-align:center" id="loaderaadhargif">
                    <img src="{{ config('app.AWS_URL')}}/images/loader11.gif" alt="loader" width="60">
                </div>
                <div class="form-group" id="verifyaadhardiv">
                    <label for="aadharotp" class="col-sm-4 control-label">Verify Aadhar Number*</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" placeholder="Enter Aadhar OTP" id="aadharotp" name="aadharotp" aria-label="Enter Aadhar OTP" >
                      <span id="aadharClientId"></span>
                      <button class="btn btn-danger pull-right" type="button" id="verifyaadharotp"><i class="fa fa-check"></i> Verify Aadhar</button>
                    </div>
                </div>
                  <div class="form-group">
                     <input type="hidden" class="form-control" id="aadharValidName"  name="aadharValidName" >
                  </div>
                <div class="form-group">
                    <label for="materialorservice" class="col-sm-4 control-label">Material / Service Category*</label>
                    <div class="col-sm-8">
                      <select class="form-control" name="Material_or_service_category" id="materialorservice">
                          <option value="">Select</option>
                      </select>
                      {!! $errors->first('Material_or_service_category', '<span class="errortext text-red">:message</span>') !!}
                    </div>
                </div>
                <div class="form-group">
                    <label for="typeofbuisness" class="col-sm-4 control-label">Type of Business*</label>
                    <div class="col-sm-8">
                      <select class="form-control" name="Type_of_Business" id="typeofbuisness">
                          <option value="">Select</option>
                      </select>
                      {!! $errors->first('Type_of_Business', '<span class="errortext text-red">:message</span>') !!}
                    </div>
                </div>
                <div class="form-group">
                    <label for="vendoractgroup" class="col-sm-4 control-label">Vendor Account Group*</label>
                    <div class="col-sm-8">
                      <select class="form-control" name="Vendor_Account_Group" id="vendoractgroup">
                          <option value="">Select</option>
                      </select>
                      {!! $errors->first('Vendor_Account_Group', '<span class="errortext text-red">:message</span>') !!}
                    </div>
                </div>
                <div id="files_requireddiv">
                </div>
                <div class="form-group">
                    <label for="contactperson" class="col-sm-4 control-label">Contact Person*</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" name="Contact_Person" id="contactperson" placeholder="Contact Person" value="{{old('Contact_Person')}}">
                      {!! $errors->first('Contact_Person', '<span class="errortext text-red">:message</span>') !!}
                    </div>
                </div>
                <div class="form-group">
                    <label for="contactnomobile" class="col-sm-4 control-label">Contact Number (Mobile)*</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" name="mobile_number" id="contactnomobile" placeholder="Mobile Number" value="{{old('mobile_number')}}" required="true">
                      <span id="lblmobileCard" class="error">Mobile Number already registered</span>
                      <span class="text-success pull-right verifytext" style="font-size: bold;"><i class="fa fa-check"></i> Verified</span>
                      <button class="btn btn-warning pull-right" type="button" id="getmobileotp">Get Mobile OTP</button>
                      {!! $errors->first('mobile_number', '<span class="errortext text-red">:message</span>') !!}
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
                <div class="form-group">
                    <label for="contactnotelephone" class="col-sm-4 control-label">Contact Number (Telephone)*</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" name="telephone_number" id="contactnotelephone" placeholder="Telephone Number" value="{{old('telephone_number')}}">
                      {!! $errors->first('telephone_number', '<span class="errortext text-red">:message</span>') !!}
                    </div>
                </div>
                <div class="form-group">
                    <label for="contactpersonemail" class="col-sm-4 control-label">Email*</label>
                    <div class="col-sm-8">
                      <input type="email" class="form-control" name="email_id" id="contactpersonemail" placeholder="EmailId" value="{{old('email_id')}}" required="true">
                      <span id="lblemailidCard" class="error">Emailid already registered</span>
                      <span class="text-success pull-right verifytextemail" style="font-size: bold;"><i class="fa fa-check"></i> Verified</span>
                      <button class="btn btn-warning pull-right" type="button" id="getemailotp">Get Email OTP</button>
                      {!! $errors->first('email_id', '<span class="errortext text-red">:message</span>') !!}
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
                <div class="form-group">
                    <label for="country" class="col-sm-4 control-label">Country*</label>
                    <div class="col-sm-8">
                      <select class="form-control" name="country" id="country">
                          <option value="">Select</option>
                          <option value="IN">INDIA</option>
                      </select>
                      {!! $errors->first('country', '<span class="errortext text-red">:message</span>') !!}
                    </div>
                </div>
                <div class="form-group">
                    <label for="region" class="col-sm-4 control-label">Region*</label>
                    <div class="col-sm-8">
                      <select class="form-control" name="region" id="region">
                          <option value="">Select</option>
                          <?php
                            $region = array();
                            if(array_key_exists('0',$gethelp['Region_Search_Help'])){
                            $region = $gethelp['Region_Search_Help'];
                            }
                            else
                            {
                            $region[0] = $gethelp['Region_Search_Help'];
                            }
                            ?>
                          @foreach($region as $reg)
                          <option value="{{$reg['Vendor_Region']}}">{{$reg['Vendor_Region']}}</option>
                          @endforeach
                      </select>
                      {!! $errors->first('region', '<span class="errortext text-red">:message</span>') !!}
                    </div>
                </div>
                <div class="row">
                    <!-- /.col -->
                    <div class="col-sm-4 col-sm-offset-4">
                      <button type="submit" class="btn btn-danger btn-block btn-flat submitBtnShowHide" id="sub">Submit</button>
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

  <footer class="footer_bg ">
  <div class="container text-center p-2 pt-3 pb-1 ">
      <p class=""> Copyright &#xa9; 2023 VGN Projects Estates Pvt Ltd, All Rights Reserved. </p>        
  </div>
</footer>
@endsection

@section('script')

@include('newvendorzone.js.commonjs')

<script type = "text/javascript">

$(document).ready(function () {

var isAdharBoolean = false;
$('.adharshowhide').hide();
$('.adharoptionshowhide').hide();
$('#getaadharotp').hide();
$('#aadharClientId').hide();

var typeofbuisness = false;
var materialorservice = false;
var vendoractgroup = false;



   /* $("#sub").on('click', function (argument) {
   $(selector).trigger("change");
   });*/
   $('input[type=radio][name=registration_proof]').change(function () {
      if (this.value == 'gstno') {
          $("#lblRegproofCard").css("visibility", "hidden");
          $("#registration_proof_number").val('');
          $("#registration_proof_number").attr({
          "placeholder": "Enter GST Registration No.",
          "maxlength"  : 15
          });
          $('.text-muted-aadhar').html('');
          $('#getaadharotp').hide();
          $('#verifyaadhardiv').hide();
          $(".verifytextaadhar").hide();
          $('.adharshowhide').hide();
          isAdharBoolean = false;
      } else if (this.value == 'panno') {
          $("#lblRegproofCard").css("visibility", "hidden");
          $("#registration_proof_number").val('');
          $("#registration_proof_number").attr({
          "placeholder": "Enter PAN No.",
          "maxlength"  : 10
          });
          $('.text-muted-aadhar').html('');
          $('#getaadharotp').hide();
          $('#verifyaadhardiv').hide();
          $(".verifytextaadhar").hide();
          $('.adharshowhide').hide();
          isAdharBoolean = false;
      } else if (this.value == 'adharno') {
          $("#lblRegproofCard").css("visibility", "hidden");
          $("#registration_proof_number").val('');
          $("#registration_proof_number").attr({
          "placeholder": "Enter AADHAR No.",
          "maxlength"  : 12
          });
          $('.adharshowhide').show();
          $('.text-muted-aadhar').html('Note: Material / Service Category - HR SERVICES, Type of Business - EMPLOYEE VENDOR, Contact Person - EMPLOYEE VENDOR only support.');
          isAdharBoolean = true;
      }
      registationBtn();
      $("#registration_proof_number").removeClass('errorcolor');
      // $("#registration_proof_number").addClass('successcolor');
      
   });

  $('#registration_proof_number').keyup(function(e){
    if(isAdharBoolean){
      var value = $(this).val();
      value = value.replace(/\D/g, "")//;.split(/(?:([\d]{4}))/g).filter(s => s.length > 0).join("-");
      $(this).val(value);
      //console.log($(this).val());
    }
  });

  
//typeofbuisness && materialorservice && vendoractgroup
  function registationBtn(){
   if(isAdharBoolean){
      $('.submitBtnShowHide').prop("disabled", true);
      if(typeofbuisness && materialorservice && vendoractgroup){
         $('.submitBtnShowHide').prop("disabled", false);
      }
   }else{
      $('.submitBtnShowHide').prop("disabled", false);
   }
  }


  $("#typeoforganization").change(function(e){
    //console.log($(this).prop('selectedIndex'));
    if($(this).prop('selectedIndex') == 1){
      $('.adharoptionshowhide').show();
      $('.text-muted-aadhar').html('');
    }else{
      $('.adharoptionshowhide').hide();
      $("#registration_proof_number").val('');
    }

    // $("#lblRegproofCard").hide();//lblRegproofCard
    $("#registration_proof_number").val('');
    $("#registration_proof_number").attr({
    "placeholder": "Enter GST Registration No.",
    "maxlength"  : 15
    });
    isAdharBoolean = false;
  });
    

   $("#lblRegproofCard").text('');


   $("#registration_proof_number").on('change', function () {
      var panregex = /([A-Z]){5}([0-9]){4}([A-Z]){1}$/;
      var gstregex = /^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$/;
      var adharregex = /[0-9]{12}$/;///-?[0-9]{4}-?[0-9]{4}-?[0-9]{4}$/;
      var regchecked = $('input[name=registration_proof]:checked').val();
      $("#lblRegproofCard").hide();
      //alert(regchecked);
      var inptype = '';
      
      if ((regchecked == 'panno') || (regchecked == 'gstno')|| (regchecked == 'adharno')) {
         var regproofval = $("#registration_proof_number").val();

         if (regproofval != '') {
            regproofval = regproofval.toUpperCase();

            if (regchecked == 'panno') {
               if (panregex.test(regproofval)) {
                  $("#lblRegproofCard").css("visibility", "hidden");
                  inptype = 'PAN';

               } else {
                  $("#lblRegproofCard").show();
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
                  $("#lblRegproofCard").show();
                  $("#lblRegproofCard").text('');
                  $("#lblRegproofCard").text(`Invalid GST Number!`);
                  $("#lblRegproofCard").css("visibility", "visible");
                  return false;
               }
            }
            if (regchecked == 'adharno') {
              if(adharregex.test(regproofval)){
                $("#lblRegproofCard").css("visibility", "hidden");
                inptype = 'AADHAAR';
                $('#getaadharotp').show();
              }else{
                $("#lblRegproofCard").show();
                $("#lblRegproofCard").text('');
                $("#lblRegproofCard").text(`Invalid AADHAAR Number!`);
                $("#lblRegproofCard").css("visibility", "visible");
                $("#getaadharotp").hide();
                return false;
              }
              
            }

            $.post('/vendorzone/panno_validation', {
               _token: "{{csrf_token()}}",
               panno: regproofval
            }, function (data) {
               //$("#loadergifpan").hide();
               var res = JSON.parse(data);
                  console.log(res);
               if (res.status == 1) {
                  $("#registration_proof_number").removeClass('errorcolor');
                  $("#registration_proof_number").addClass('successcolor');
                  //$(".verifytextpan").show();
                  // $('#getaadharotp').hide();
                  return true;

               } else if (res.status == 4) {
                  $("#registration_proof_number").val('');
                  $("#registration_proof_number").addClass('errorcolor');
                  $("#lblRegproofCard").show();
                  $("#lblRegproofCard").text('');
                  $("#lblRegproofCard").text(`Vendor already exists for this ${res.pan} ${inptype} Number!`);
                  $('#getaadharotp').hide();
                  $("#lblRegproofCard").css("visibility", "visible");
                  return false;
               } else if (res.status == 5) {
                  $("#registration_proof_number").val('');
                  $("#registration_proof_number").addClass('errorcolor');
                  $("#lblRegproofCard").show();
                  $("#lblRegproofCard").text('');
                  $("#lblRegproofCard").text(`Vendor Registration is in process for this ${res.pan} ${inptype} Number!`);
                  $('#getaadharotp').hide();

                  $("#lblRegproofCard").css("visibility", "visible");
                  return false;
               } else {
                  $("#registration_proof_number").val('');
                  $("#registration_proof_number").addClass('errorcolor');
                  $("#lblRegproofCard").show();
                  $("#lblRegproofCard").text('');
                  $("#lblRegproofCard").text(`Invalid ${inptype} Number!`);
                  $("#lblRegproofCard").css("visibility", "visible");
                  return false;
               }
            });


         } else {
            alert('Registration Proof No required!');
         }


      }
   });


   $(".verifytext").hide();
   $(".verifytextemail").hide();
   $(".verifytextpan").hide();
   $(".verifytextaadhar").hide();


   $("#verifymobilediv").hide();
   $("#verifyemaildiv").hide();
   $("#verifyaadhardiv").hide();

   $("#loadergif").hide();
   $("#loadergifemail").hide();
   $("#loadergifpan").hide();
   $("#loaderaadhargif").hide();

   var search = <?php echo json_encode($gethelp);?>;

   //var country='<option value="" selected>Select*</option>';
   var materials = '<option value="" selected>Select*</option>';
   var tmpcon = [];

   // $("#contactpersonpan").on('change', function () {
   //    //alert( "Handler for .submit() called." );
   //    $("#loadergifpan").show();
   //    //alert('PAN No required!');
   //    $("#lblPANCard").text('');
   //    $("#lblPANCard").text('Invalid PANO No');
   //    var panno = $("#contactpersonpan").val();
   //    var regex = /([A-Z]){5}([0-9]){4}([A-Z]){1}$/;

   //    if (panno != '') {
   //       panno = panno.toUpperCase();
   //       if (regex.test($("#contactpersonpan").val().toUpperCase())) {
   //          $("#lblPANCard").css("visibility", "hidden");

   //          $.post('/vendorzone/panno_validation', {
   //             _token: "{{csrf_token()}}",
   //             panno: panno
   //          }, function (data) {
   //             $("#loadergifpan").hide();
   //             var res = JSON.parse(data);
   //                console.log(res);
   //             if (res.status == 1) {
   //                $("#contactpersonpan").removeClass('errorcolor');
   //                $("#contactpersonpan").addClass('successcolor');
   //                $(".verifytextpan").show();
   //                $("#contactpersonpan").attr('readonly', true);
   //                return true;

   //             } else if (res.status == 4) {
   //                $("#contactpersonpan").val('');
   //                $("#contactpersonpan").addClass('errorcolor');
   //                $("#lblPANCard").text('');
   //                $("#lblPANCard").text(`Vendor already exists for this ${res.pan} PAN Number!`);
   //                $(".verifytextpan").hide();
   //                $("#lblPANCard").css("visibility", "visible");
   //                return false;
   //             } else if (res.status == 5) {
   //                $("#contactpersonpan").val('');
   //                $("#contactpersonpan").addClass('errorcolor');
   //                $("#lblPANCard").text('');
   //                $("#lblPANCard").text(`Vendor Registration is in process for this ${res.pan} PAN Number!`);
   //                $(".verifytextpan").hide();
   //                $("#lblPANCard").css("visibility", "visible");
   //                return false;
   //             } else {
   //                $("#contactpersonpan").val('');
   //                $("#contactpersonpan").addClass('errorcolor');
   //                $("#lblPANCard").text('');
   //                $("#lblPANCard").text(`Invalid PAN Number!`);
   //                $(".verifytextpan").hide();
   //                $("#lblPANCard").css("visibility", "visible");
   //                return false;
   //             }
   //          });


   //       } else {
   //          $("#lblPANCard").css("visibility", "visible");
   //          return false;
   //       }
   //    } else {
   //       alert('PAN No required!');
   //    }


   // });


   //lblmobileCard

   /*$.each( search['Region_Search_Help'], function( i, val ) {

   if($.inArray(val['Country_Code'],tmpcon)===-1)
   {

   tmpcon.push(val['Country_Code']);
   country += '<option value="'+val['Country_Code']+'"';
   if(val['Country_Code']==$('select[country]').attr('default'))
   country+=' selected ';
   country+='>'+val['Country']+'</option>';	
   }
   });		

   $('#country').html(country);*/

   
   
   //loadergifpan



   $("#getaadharotp").on("click", function () {


      $("#loaderaadhargif").show();
      var aadharno = $("#registration_proof_number").val();

      if (aadharno != '') {
         // $("#lblmobileCard").css("visibility", "hidden");
         $.post('/aadhaarverify/genotp', {
            _token: "{{csrf_token()}}",
            Aadhar_Number: aadharno
         }, function (data) {

            // $("#loaderaadhargif").hide();

            var res = JSON.parse(data);
      //{"Client_ID":"aadhaar_v2_OWoirGKSsCvgnPvFRcGx","Status_Code":200,"OTP_Sent":true,"Valid_Aadhaar":true}
            console.log(data);
            if (res.Status_Code == 422) {
            //    $("#getmobileotp").text('Resend OTP');
            //    $("#verifyaadhardiv").fadeIn(() => {
            //       $("#verifyaadhardiv").show();
            //    });


            // } else if (res.status == 2) {
            //    $("#loadergif").hide();
            //    alert('Too Many attempts requested for OTP. Try after 30 Minutes!');
            // } else if (res.status == 3) {
            //    $("#loadergif").hide();
            //    alert('Invalid Mobile Number!');
            // } else if (res.status == 4) {
            //    $("#loadergif").hide();
            //    $("#contactnomobile").val('');
            //    $("#contactnomobile").addClass('errorcolor');
            //    $("#lblmobileCard").text('');
            //    $("#lblmobileCard").text(`Vendor already exists for this Mobile Number!`);
            //    //$(".verifytextpan").hide();
            //    $("#lblmobileCard").css("visibility", "visible");
            //    //alert('Mobile Number already registered!');
            // } else if (res.status == 5) {
            //    $("#loadergif").hide();
            //    $("#contactnomobile").val('');
            //    $("#contactnomobile").addClass('errorcolor');
            //    $("#lblmobileCard").text('');
            //    $("#lblmobileCard").text(`Vendor Registration is in process for this Mobile Number!`);
            //    //$(".verifytextpan").hide();
            //    $("#lblmobileCard").css("visibility", "visible");
            //    //alert('Mobile Number already registered!');
            }else if(res.Status_Code == 200){

               $("#getaadharotp").text('Resend OTP');
               $("#verifyaadhardiv").fadeIn(() => {
                  $("#verifyaadhardiv").show();
               });

               $("#aadharClientId").html(res.Client_ID);
            } else {
               alert('Aadhar OTP not sent. Try Again!');
            }
            $("#loaderaadhargif").hide();
         });
      } else {
         alert('Aadhar Number should not be empty!');
         // $("#contactnomobile").focus();
         // $("#loadergif").hide();
      }


   });


   $("#verifyaadharotp").on("click", function () {

      var aadharotp = $("#aadharotp").val();
      var aadhar_client_id = $("#aadharClientId").html();
      console.log(aadhar_client_id, aadharotp);
      if (aadharotp != '') {
         $.post('/aadhaarverify/submitotp', {
            _token: "{{csrf_token()}}",
            OTP: aadharotp,
            Client_ID: aadhar_client_id
         }, function (data) {
            var res = JSON.parse(data);
            console.log(res);
            if(res.Status_Code == 200){
               $("#verifyaadhardiv").hide();
               $('#getaadharotp').hide();
               $(".verifytextaadhar").show();
               $("#aadharValidName").attr('value',res.Name);

            }
            $("#loaderaadhargif").hide();
            // if (newdata1.otpverified == 0) {
            //    $("#mobileotp").addClass('errorcolor');
            //    $("#contactnomobile").removeClass('successcolor');
            // } else {
            //    $("#mobileotp").removeClass('errorcolor');
            //    $("#contactnomobile").removeClass('errorcolor');
            //    $("#contactnomobile").addClass('successcolor');
            //    $("#contactnomobile").attr('readonly', true);


            //    $("#verifymobilediv").hide();
            //    $("#getmobileotp").hide();
            //    $(".verifytext").show();


            // }
         });
      } else {
         alert('Enter Aadhar OTP to verify!');
         $("#loaderaadhargif").hide();
      }


   });


   $("#getmobileotp").on("click", function () {


      $("#loadergif").show();


      var mobileno = $("#contactnomobile").val();


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
               $("#contactnomobile").val('');
               $("#contactnomobile").addClass('errorcolor');
               $("#lblmobileCard").text('');
               $("#lblmobileCard").text(`Vendor already exists for this Mobile Number!`);
               //$(".verifytextpan").hide();
               $("#lblmobileCard").css("visibility", "visible");
               //alert('Mobile Number already registered!');
            } else if (res.status == 5) {
               $("#loadergif").hide();
               $("#contactnomobile").val('');
               $("#contactnomobile").addClass('errorcolor');
               $("#lblmobileCard").text('');
               $("#lblmobileCard").text(`Vendor Registration is in process for this Mobile Number!`);
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
         $("#contactnomobile").focus();
         $("#loadergif").hide();
      }


   });


   $("#verifymobileotp").on("click", function () {

      var mobileotp = $("#mobileotp").val();
      var mobileno1 = $("#contactnomobile").val();
      if (mobileotp != '') {
         $.post('/vendorzone/validatemobileotp', {
            _token: "{{csrf_token()}}",
            mobileotpbyuser: mobileotp,
            mobileno1: mobileno1
         }, function (data1) {

            var newdata1 = JSON.parse(data1);

            if (newdata1.otpverified == 0) {
               $("#mobileotp").addClass('errorcolor');
               $("#contactnomobile").removeClass('successcolor');
               
            } else {
               $("#mobileotp").removeClass('errorcolor');
               $("#contactnomobile").removeClass('errorcolor');
               $("#contactnomobile").addClass('successcolor');
               $("#contactnomobile").attr('readonly', true);


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


   $("#getemailotp").on("click", function () {

      $("#loadergifemail").show();


      var emailid = $("#contactpersonemail").val();


      if (emailid != '') {
         var materialorservice = $("#materialorservice").val();

         if (materialorservice == '') {
            $("#loadergifemail").hide();
            alert('Please select type of business!');
            return false;
         }
         $("#lblemailidCard").css("visibility", "hidden");
         $.post('/vendorzone/sendandsavevendor_registerotpemail', {
            _token: "{{csrf_token()}}",
            emailotp: emailid,
            materialorservice: materialorservice
         }, function (data) {

            $("#loadergifemail").hide();

            var res = JSON.parse(data);

            if (res.status1 == 1) {
               $("#getemailotp").text('Resend Email OTP');

               $("#verifyemaildiv").fadeIn(() => {
                  $("#verifyemaildiv").show();
               });


            } else if (res.status1 == 2) {
               $("#loadergifemail").hide();
               alert('Too Many attempts requested for OTP. Try after 30 Minutes!');
            } else if (res.status1 == 3) {
               $("#loadergifemail").hide();
               alert('Invalid Email Address!');
            } else if (res.status1 == 4) {
               $("#loadergifemail").hide();
               $("#contactpersonemail").val('');
               $("#contactpersonemail").addClass('errorcolor');
               $("#lblemailidCard").text('');
               $("#lblemailidCard").text(`Vendor already exists for this Emailid!`);
               //$(".verifytextpan").hide();
               $("#lblemailidCard").css("visibility", "visible");
               //alert('Mobile Number already registered!');
            } else if (res.status1 == 5) {
               $("#loadergifemail").hide();
               $("#contactpersonemail").val('');
               $("#contactpersonemail").addClass('errorcolor');
               $("#lblemailidCard").text('');
               $("#lblemailidCard").text(`Vendor Registration is in process for this Emailid!`);
               //$(".verifytextpan").hide();
               $("#lblemailidCard").css("visibility", "visible");
               //alert('Mobile Number already registered!');
            } else if (res.status1 == 88) {
               $("#loadergifemail").hide();
               $("#contactpersonemail").val('');
               $("#contactpersonemail").addClass('errorcolor');
               $("#lblemailidCard").text('');
               $("#lblemailidCard").text(`Please enter the official mailid for this business type!`);
               //$(".verifytextpan").hide();
               $("#lblemailidCard").css("visibility", "visible");
               //alert('Mobile Number already registered!');
            } else {
               $("#loadergifemail").hide();
               alert('Email OTP Not sent. Try again!');
            }
         });


      } else {
         $("#contactpersonemail").focus();
         $("#loadergifemail").hide();
         alert('Emailid should not be empty!');
      }


   });

   $("#verifyemailotp").on("click", function () {

      var emailotp = $("#emailotp").val();
      var email1 = $("#contactpersonemail").val();
      if (emailotp != '') {
         $.post('/vendorzone/validateemailotp', {
            _token: "{{csrf_token()}}",
            emailotpbyuser: emailotp,
            email1: email1
         }, function (data1) {

            var newdata1 = JSON.parse(data1);

            if (newdata1.emailotpverified == 0) {
               $("#emailotp").addClass('errorcolor');
               $("#contactpersonemail").removeClass('successcolor');
            } else {
               $("#emailotp").removeClass('errorcolor');
               $("#contactpersonemail").removeClass('errorcolor');
               $("#contactpersonemail").addClass('successcolor');
               $("#contactpersonemail").attr('readonly', true);
               $("#verifytextemail").show();

               $("#verifyemaildiv").hide();
               $("#getemailotp").hide();
               $(".verifytextemail").show();


            }
         });
      } else {
         alert('Enter Email OTP to verify!');
      }


   });

   var tmp = [];
   $.each(search['Search_table_01'], function (i, val) {
      if ($.inArray(val['Material_Service_cat_Code'], tmp) === -1) {
         tmp.push(val['Material_Service_cat_Code']);
         materials += '<option value="' + val['Material_Service_cat_Code'] + '"';
         materials += '>' + val['Material_Service_cat_Des'] + '</option>';
      }

   });

   $('#materialorservice').html(materials);
   
   //genArea();
   //$('#country').on('change',function(){genArea();})
   $('#materialorservice').on('change', function () {
      
      genTOB();
      $("#contactpersonemail").attr('readonly', false);
      $("#contactpersonemail").val('');
      $("#contactpersonemail").removeClass('successcolor');
      $(".verifytextemail").hide();
      $("#getemailotp").text('Get Email OTP');
      $("#getemailotp").show();

      $("#contactpersonemail").removeClass('successcolor');
      $("#emailotp").val('');
      $("#verifyemaildiv").hide();

      if(isAdharBoolean){
         if(this.value == '2009'){
            // console.log(this.value);
            materialorservice = true;
         }else {
            materialorservice = false;
         }
         registationBtn();
      }

   })
   $('#typeofbuisness').on('change', function () {
      genVenGrp();
      if(isAdharBoolean){
         if(this.value == 'EMPLOYEE VENDOR'){
            // console.log(this.value);
            typeofbuisness = true;
         }else {
            typeofbuisness = false;
         }
         registationBtn();
      }
   });

   $('#vendoractgroup').on('change', function () {
      if(isAdharBoolean){
         if(this.value == 'V005'){
            // console.log(this.value);
            vendoractgroup = true;
            
         }else {
            vendoractgroup = false;
         }
         registationBtn();
      }
      var vendaccountid = $("#vendoractgroup").val();
      $("#files_requireddiv").html('');
      

      //alert(vendaccountid);
      if (vendaccountid != '') {
         $.post("/vendorzone/vendorreg_filesrequired", {
            _token: "{{csrf_token()}}",
            vendaccountid: vendaccountid
         }, function (data) {
            //console.log(data);
            if (data != 0) {
               var filecontent = '';
               var newdata = JSON.parse(data);
               //console.log(newdata);
               var aa = 0;
               $.each(newdata.Doc_Name, function (ki, kval) {
                  var isreq = newdata.Attachment_Ind[aa];
                  var kk1 = aa + 1;

                  if (isreq == 'Y') {
                     filecontent += `<div class="form-group">
<label for="file` + kk1 + `" class="col-sm-4 control-label">` + kval + `*</label>

<div class="col-sm-8">

<input type="file" class="form-control fileval" name="file` + kk1 + `" id="file` + kk1 + `id"  required="true" >
<span class="text-muted">Note: Upload Pdf, image files and file should be less than 2MB</span>
</div>
</div>

`;
                  } else {
                     filecontent += `<div class="form-group">
<label for="file` + kk1 + `" class="col-sm-4 control-label">` + kval + ` (Optional)</label>

<div class="col-sm-8">

<input type="file" class="form-control fileval" name="file` + kk1 + `" id="file` + kk1 + `id" >
<span class="text-muted">Note: Upload Pdf, image files and file should be less than 2MB</span>

</div>
</div>

`;
                  }


                  aa++;
               });

               $("#files_requireddiv").html(filecontent);

            } else {
               console.log('No data');
            }
         });
      } else {
         alert('Vendor Account Group required.');
      }
   });

   function genArea() {
      var parent = $('#country').val();
      var output = '<option value="">Select*</option>';
      $.each(search['Region_Search_Help'], function (i, val) {
         if (val['Country_Code'] == parent) {
            output += '<option value="' + val['Vendor_Region'] + '"';
            if (val['Vendor_Region'] == $('#region').attr('default'))
               output += ' selected ';
            output += '>' + val['Vendor_Region'] + '</option>';
         }
      });

      $('#region').html(output);
   };

   function genTOB() {

      var tobs = '<option value="" selected>Select*</option>';
      var tmp = [];
      $.each(search['Search_table_01'], function (i, val) {
         if (val['Material_Service_cat_Code'] == $('#materialorservice').val()) {
            tmp.push({
               'id': val['Material_Service_cat_Code'],
               'tob': val['Type_Of_Business']
            });
            tobs += '<option value="' + val['Type_Of_Business'] + '"';
            tobs += '>' + val['Type_Of_Business'] + '</option>';
         }

      });
      $('#typeofbuisness').html(tobs);

   }

   function genVenGrp() {

      var venGrps = '<option value="" selected>Select*</option>';
      var tmp = [];
      $.each(search['Search_table_02'], function (i, val) {
         if (val['Type_Of_Business'] == $('#typeofbuisness').val()) {
            tmp.push({
               'id': val['Vendor_Acc_Group_Code'],
               'name': val['Vendor_Acc_Group_Des'],
               'tob': val['Type_Of_Business']
            });
            venGrps += '<option value="' + val['Vendor_Acc_Group_Code'] + '"';
            venGrps += '>' + val['Vendor_Acc_Group_Des'] + '</option>';
         }

      });
      $('#vendoractgroup').html(venGrps);
   }

   $(document).delegate(':file', 'change', function () {

      var files = $(this)[0].files[0];
      var file_size = $(this)[0].files[0].size;
      var file_type = $(this)[0].files[0].type;
      var rfilesize = Math.round((file_size / 1024));


      if ((file_type == 'image/jpeg') || (file_type == 'image/png') || (file_type == 'application/pdf')) {} else {
         alert('Invalid File type. Please upload pdf or image');
         $(this).val('');
      }

      if (rfilesize < 5) {
         alert('File too small, please select a file greater than 5kb');
         $(this).val('');
      }

      if (rfilesize > 2048) {
         alert('File too Big, please select a file less than 2mb');
         $(this).val('');
      }


   });
});

</script>

  @endsection

