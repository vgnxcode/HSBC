@extends('newcustomerzone.layout')

@section('title')
VGN Projects Estates Pvt Ltd |Vendor Zone| MyDetails Page
@endsection

@section('description')
    <meta name="description" content="">
@endsection

@section('keyword')  
@endsection


@section('style')
@include('newcustomerzone.styles.commoncss')
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="{{ config('app.AWS_URL')}}/newcustomerzoneassets/dist/js/defines.js"></script>
<style>
	.carousel-inner>.item>img
	{
		min-height: 280px;
	}
  .swal-text, .swal-title{
    color: #000;
  }
</style>

@endsection

@section('bodycontent')
<body class="hold-transition skin-red fixed sidebar-mini">

<!-- Site wrapper -->
<div class="wrapper">

@foreach($getvendordata as $vendor)


 
  @include('newvendorzone.header.index')
  @include('newvendorzone.aside.index')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
   
    <!-- Main content -->
    <section class="content">
	
	<div class="row">
		<div class="col-md-10 col-md-offset-1">

	@include('newvendorzone.contenttop')


      	</div>
	</div>



	<div class="row">
		
    <div class="col-md-10 col-md-offset-1">
      
      <div class="box box-danger">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-user margin-r-5"></i> My Details </h3><span class="pull-right" ><a href="{{ url('/vendorzone/mydetails_changepassword') }}" class="btn btn-danger btn-xs"><i class="fa fa-edit margin-r-5"></i>Change Password</a></span>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              
              <strong><i class="fa fa-map-marker margin-r-5"></i> Location</strong>

               <ul>
               <li> House Number  - {{ $vendor->houseno }}</li>
               <li> Street Address 1  - {{ $vendor->street1 }}</li>
               <li> Street Address 2  - {{ $vendor->street2 }}</li>
               <li> Street Address 3  - {{ $vendor->street3 }}</li>
               <li> City / Postal Code  - {{ $vendor->city }} / {{ $vendor->pin }}</li>
               <li> Country  - <span id="ctry">{{ $vendor->country }}</span></li>
               <li> Region  - <span id="stat">{{ $vendor->region }}</span></li>
              </ul>

              <hr>

              <strong><i class="fa fa-envelope margin-r-5"></i> Communication</strong>

            <ul>
            <li> Telephone  - {{ $vendor->tel }}</li>
                
               <li> <span class="mobspan">Mobile Phone  - <span class="mobtext">{{ $vendor->mobile }}</span> <span style="color:green; font-weight: bold;" class="verifiedtick"><i class="fa fa-check"></i> Verified</span><button id="editphone" class="btn btn-xs btn-danger"><i class="fa fa-edit"></i> <span id="editphonespan">Edit</span></button>
               </span>
               <div id="spinner1">
        <div class="text-center">
    <img src="{{ config('app.AWS_URL')}}/images/loader11.gif" width="60" height="60" alt="img loader">
    </div>
  </div>
               <div class="row" id="sendmobotp" >
                 <div class="col-md-3"><input type="text" class="form-control" name="newnumber" id="newnumber" placeholder="Enter New Mobile Number." required="true"></div>
                 <div class="col-md-2"><button id="sendotpmob" class="btn btn-md btn-danger"><i class="fa fa-send"></i> <span id="editphoneotpspan">Send OTP</span></button></div>
               </div>
               <div class="row" id="votpresponsetext">
        
       

      </div>
               </li>
               <li> Fax  - {{ $vendor->fax }}</li>
               <li> <span class="emailspan">Email  - <span class="emailtext">{{ $vendor->email }}</span> <span style="color:green; font-weight: bold;" class="verifiedtickemail"><i class="fa fa-check"></i> Verified</span><button id="editemail" class="btn btn-xs btn-danger"><i class="fa fa-edit"></i> <span id="editemailspan">Edit</span></button></span>
                <div id="spinner2">
        <div class="text-center">
    <img src="{{ config('app.AWS_URL')}}/images/loader11.gif" width="60" height="60" alt="img loader">
    </div>
  </div>
               <div class="row" id="sendemailotp" >
                 <div class="col-md-3"><input type="email" class="form-control" name="newemail" id="newemail" placeholder="Enter New Email Address." required="true"></div>
                 <div class="col-md-2"><button id="sendotpemail" class="btn btn-md btn-danger"><i class="fa fa-send"></i> <span id="editemailotpspan">Send OTP</span></button></div>
               </div>
               <div class="row" id="votpresponsetextemail">
        
       

      </div>
               </li>

    @if($vendor->pan_no == '0') <li> PAN Number  - </li>  @else  <li> PAN Number  - {{$vendor->pan_no}} </li>  @endif

    @if($vendor->type_of_org == '0') <li> Type of Organization - </li>  @else  <li> Type of Organization  - {{$vendor->type_of_org}} </li>  @endif

    @if($vendor->type_of_business == '0') <li> Type of Business - </li>  @else  <li> Type of Business - {{$vendor->type_of_business}} </li>  @endif

     @if($vendor->vendor_acc_group == '0') <li> Vendor Account Group - </li>  @else  <li> Vendor Account Group - {{$vendor->vendor_acc_group}} </li>  @endif

      @if($vendor->contact_person == '0') <li> Contact Person - </li>  @else  <li> Contact Person - {{$vendor->contact_person}} </li>  @endif

               
              </ul>

              
            </div>
            <!-- /.box-body -->
          </div>

    </div>


		

		
	</div>
@endforeach
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  @include('newvendorzone.footer')
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->



@endsection

@section('script')
@include('newvendorzone.js.commonjs')
<script>
  
  function processfunc(pp) {
    
           if (pp.type == 'Mobile') {
            $("#editphonespan").text('');
            $("#editphonespan").text("Retry Approval Request("+pp.attempt+")");                  
           }

           if ((pp.id != '') ) {
            $.post('/vendorzone/editdetailsstep2', {_token: "{{csrf_token()}}", vendetails: pp}, function(data){
              
                if (data == 1) {
                  $("#editphone").hide();
                }
                else if(data == 12){              
                  window.location.reload();
                }
                else{
                  $(".verifiedtick").hide();                  
                }
            });
           }

  
}

function processfuncem(ppm) {
    
           if (ppm.type == 'Email') {
            $("#editemailspan").text('');
            $("#editemailspan").text("Retry Approval Request("+ppm.attempt+")");                  
           }

           if ((ppm.id != '') ) {
            $.post('/vendorzone/editemaildetailsstep2', {_token: "{{csrf_token()}}", vendetails: ppm}, function(data){
              
                if (data == 1) {
                  $("#editemail").hide();
                }
                else if(data == 12){              
                  window.location.reload();
                }
                else{
                  $(".verifiedtickemail").hide();                  
                }
            });
           }

  
}

</script>
<script>
  var CCOUNT;
  var CCOUNTEMAIL;

  $(document).ready(function () {
    $('.footer_bg ').hide();
    $('.sidebar-menu').tree();

    $(".verifiedtick").hide();
    $(".verifiedtickemail").hide();

    $("#sendmobotp").hide();
    $("#sendemailotp").hide();

      $("#spinner1").hide();
      $("#spinner2").hide();
      $("#otpdiv").hide(); 
      $("#otpdivemail").hide(); 

@foreach($getvendordata as $vendor)
    $.each( countries, function( i, val ) {
          if(val['c_id']=="{{ $vendor->country }}")
          $('#ctry').html(val['c_nm']);
      });
  
          genArea();
                function genArea()
                    {
                        $.each( states, function( i, val ) {
                                if(val['s_id']=="{{ $vendor->region }}")
                                $('#stat').html(val['s_nm']);
                        });
                    };
          @endforeach


//mobile
          $("#editphone").on("click", function(){
            
            swal({
  title: "Approval Request Confirmation",
  text: "Required Approval to change the mobile number. Click `Send Request Link` button to send approval link to your registered Mobile Number and registered Email ID. ",
  icon: "warning",
  buttons: ["Cancel", "Send Request Link"],
  dangerMode: true,
})
.then((willsendrequest) => {
  if (willsendrequest) {

    $.post("/vendorzone/editdetailsstep1", {_token:"{{csrf_token()}}"}, function(data){
      var res = JSON.parse(data);
      if (res.status == 1) {
        swal(res.message, {
      icon: "success",
    });
        setTimeout(function(){
          window.location.reload();
        },3000);
        
      }
      else{
         swal(res.message, {
      icon: "error",
    });
      }
    });

    
  } else {
    swal.close();
  }
});

          });

//email
$("#editemail").on("click", function(){
            
            swal({
  title: "Approval Request Confirmation",
  text: "Required Approval to change the Email ID. Click `Send Request Link` button to send approval link to your registered Mobile Number and registered Email ID. ",
  icon: "warning",
  buttons: ["Cancel", "Send Request Link"],
  dangerMode: true,
})
.then((willsendrequest) => {
  if (willsendrequest) {

    $.post("/vendorzone/editemaildetailsstep1", {_token:"{{csrf_token()}}"}, function(data){
      var res = JSON.parse(data);
      if (res.status == 1) {
        swal(res.message, {
      icon: "success",
    });
        setTimeout(function(){
          window.location.reload();
        },3000);
      }
      else{
         swal(res.message, {
      icon: "error",
    });
      }
    });

    
  } else {
    swal.close();
  }
});

          });
          

          //flash session mobile 1
            @if(!empty(Session::has('vend_auth_mobile')))
              var apprvmsgsess = @json(Session::get('vend_auth_mobile'));
              processfunc(apprvmsgsess);
              setInterval(function(){ processfunc(apprvmsgsess); }, 5000);

            @endif

            
            @if(!empty(Session::has('vendapproved')))
            $("#spinner1").show();
              var apprv = @json(Session::get('vendapproved'));
              $("#editphone").hide();
              $(".verifiedtick").show();

              swal("Successfully Authenticated!", {  icon: "success",});
              
                $("#sendmobotp").show();
                $("#spinner1").hide();

            @endif
            //flash session mobile 1 end

            //flash session email 1
            @if(!empty(Session::has('vend_auth_email')))
              var apprvmsgsessem = @json(Session::get('vend_auth_email'));
              processfuncem(apprvmsgsessem);
              setInterval(function(){ processfuncem(apprvmsgsessem); }, 5000);

            @endif

            
            @if(!empty(Session::has('vendapprovedemail')))
            $("#spinner2").show();
              var apprvem = @json(Session::get('vendapprovedemail'));
              $("#editemail").hide();
              $(".verifiedtickemail").show();

              swal("Successfully Authenticated!", {  icon: "success",});
              
                $("#sendemailotp").show();
                $("#spinner2").hide();

            @endif
            //flash session email 1 end


      
//mobile sendotpclick

      $("#sendotpmob").on("click", function(){
      var newnumber = $("#newnumber").val();
      $("#votpresponsetext").html('');
      $("#spinner1").show();
      if (newnumber != '') {
        $.post("{{ url('/vendorzone/editdetailsstep3')}}",{_token:'{{csrf_token()}}',newnumber : newnumber,apprv:apprv}, function(data){
          console.log(data);
          $("#spinner1").hide();
          
          if (data == '1') {
            $("#sendotpmob").text('Resend OTP');
            $("#sendotpmob").attr('disabled',true);
            $("#votpresponsetext").html(`<div clas="row" id="otpdiv">
          <div class="col-md-4">
          <p style="margin-top:5px; font-weight:500;">Please enter the OTP Sent to your new mobile number. OTP expires in <span id="otpexpirycounter" style="font-weight:bold;">90</span> Seconds.</p>
              <br>

            
        
        <input type="text" class="form-control" id="submitotp" name="submitotp" value="" placeholder="Enter OTP" required>
        <p class="errortext" id="otperror"></p>
    

      <div class="row">
        <div class="col-xs-6">
         
        </div>
        <div class="col-xs-6">
          <button type="button" onclick="mobileotpclickfn();" id="mobileotpclickfn" class="btn btn-danger btn-block btn-flat">Submit OTP</button>
        </div>        
      </div>
    </div><div class="col-md-8"></div>
              </div>`);
            CCOUNT  = '90';
            vdreset(); 
            countdown();         

            $("#otpdiv").show(); 

            
          }
          else if(data == 77){
            swal("New data cannot be same as old one!", {
      icon: "error",
    }); 
          }
          else{
             swal("Token Expired. Try Again", {
      icon: "error",
    }); 
             setTimeout(function(){
             window.location.reload();
           },3000);
          }
          //$("#otpsubmit").show();
        });  
      }
      else{
        alert('Please fill the required field!');
        $("#spinner").hide();
      }
      
    });

//send otp emailclick

       $("#sendotpemail").on("click", function(){
      var newemail = $("#newemail").val();
      $("#votpresponsetextemail").html('');
      $("#spinner2").show();
      if (newemail != '') {
        $.post("{{ url('/vendorzone/editemaildetailsstep3')}}",{_token:'{{csrf_token()}}',newemail : newemail,apprv:apprvem}, function(data){
          $("#spinner2").hide();
          
          if (data == '1') {
            $("#sendotpemail").text('Resend OTP');
            $("#sendotpemail").attr('disabled',true);
            $("#votpresponsetextemail").html(`<div clas="row" id="otpdivemail">
          <div class="col-md-4">
          <p style="margin-top:5px; font-weight:500;">Please enter the OTP Sent to your new Email ID. OTP expires in <span id="otpexpirycounter1" style="font-weight:bold;">90</span> Seconds.</p>
              <br>

            
        
        <input type="text" class="form-control" id="submitotp1" name="submitotp1" value="" placeholder="Enter OTP" required>
        <p class="errortext" id="otperror"></p>
    

      <div class="row">
        <div class="col-xs-6">
         
        </div>
        <div class="col-xs-6">
          <button type="button" onclick="vsubmitotpfn1();" class="btn btn-danger btn-block btn-flat">Submit OTP</button>
        </div>        
      </div>
    </div><div class="col-md-8"></div>
              </div>`);
            CCOUNTEMAIL  = '90';
            vdresetemail(); 
            countdownemail();         

            $("#otpdivemail").show(); 

            
          }
          else if(data == 77){
            swal("New data cannot be same as old one!", {
      icon: "error",
    }); 
          }
          else{
             swal("Token Expired. Try Again", {
      icon: "error",
    }); 
             setTimeout(function(){
             window.location.reload();
           },3000);
          }
          //$("#otpsubmit").show();
        });  
      }
      else{
        alert('Please fill the required field!');
        $("#spinner2").hide();
      }
      
    });


       



  });

  var t, count = 90;
  var t1, count1 = 90;


  function mobileotpclickfn(){
var typetochangeval = '';
var submitotp = '';
    @if(!empty(Session::has('vendapproved')))
            
              var fapprv = @json(Session::get('vendapproved'));
      if (fapprv.type == 'Mobile') {
        typetochangeval = $("#newnumber").val();
      }


      submitotp = $("#submitotp").val();

              //swal("Successfully Authenticated!", {  icon: "success",});
              
                $("#sendmobotp").show();
                $("#spinner1").hide();


    @else
    swal("Invlaid Request.Try Later!", {  icon: "error",});
    setTimeout(function(){
             window.location.reload();
           },3000);

            @endif
  
  

  $("#spinner1").show();
  
  if ((typetochangeval != '') && (submitotp != '')) {
    $.post("{{ url('/vendorzone/editdetailsstep4')}}",{_token:'{{csrf_token()}}',fapprv: fapprv,typetochangeval : typetochangeval,submitotp: submitotp}, function(data){
      console.log('Mobile otp');
      console.log(data);
      
      $("#spinner1").hide();
        if(data == 1){
            swal("Successfully Updated!", {  icon: "success",});
            setTimeout(function(){
             window.location.reload();
           },3000);
        }
        else if(data == 77){
            swal("New data cannot be same as old one!", {
      icon: "error",
    }); 
          }
        else if(data == 10){
          swal("OTP Expired", {  icon: "error",});
            setTimeout(function(){
             window.location.reload();
           },3000);
        }
        else if(data == 11){
          swal("Cannot Change the OTP Mobile Number", {  icon: "error",});
            setTimeout(function(){
             window.location.reload();
           },3000);
        }
        else{
          swal("Invalid OTP Code", {  icon: "error",});
        }
    });
  }
  else{
    swal("Invalid OTP Code1", {  icon: "error",});
    $("#spinner1").hide();
  }
}


function vsubmitotpfn1(){
var typetochangeval = '';
var submitotp = '';
    @if(!empty(Session::has('vendapprovedemail')))
            
              var fapprvem = @json(Session::get('vendapprovedemail'));
      if (fapprvem.type == 'Email') {
        typetochangeval = $("#newemail").val();
      }


      submitotp = $("#submitotp1").val();

              //swal("Successfully Authenticated!", {  icon: "success",});
              
                $("#sendemailotp").show();
                $("#spinner2").hide();


    @else
    swal("Invlaid Request.Try Later!", {  icon: "error",});
    setTimeout(function(){
             window.location.reload();
           },3000);

            @endif
  
  

  $("#spinner2").show();
  
  if ((typetochangeval != '') && (submitotp != '')) {
    $.post("{{ url('/vendorzone/editemaildetailsstep4')}}",{_token:'{{csrf_token()}}',fapprv: fapprvem,typetochangeval : typetochangeval,submitotp: submitotp}, function(data){
      console.log('ok');
      console.log(data);
      $("#spinner2").hide();
        if(data == 1){
            swal("Successfully Updated!", {  icon: "success",});
            setTimeout(function(){
             window.location.reload();
           },3000);
        }
        else if(data == 77){
            swal("New data cannot be same as old one!", {
      icon: "error",
    }); 
          }
        else if(data == 10){
          swal("OTP Expired", {  icon: "error",});
            setTimeout(function(){
             window.location.reload();
           },3000);
        }
        else if(data == 11){
          swal("Cannot Change the OTP Email Address", {  icon: "error",});
            setTimeout(function(){
             window.location.reload();
           },3000);
        }
        else{
          swal("Invalid OTP Code", {  icon: "error",});
        }
    });
  }
  else{
    swal("Invalid OTP Code1", {  icon: "error",});
    $("#spinner2").hide();
  }
}

      function vddisplay() {
    document.getElementById('otpexpirycounter').innerHTML = count;
}
function vddisplayemail() {
    document.getElementById('otpexpirycounter1').innerHTML = count1;
}

function countdown() {
    // starts countdown
    vddisplay();
    if (count === 0) {
        $("#sendotpmob").attr('disabled',false);
        $("#otpdiv").hide();
    } else {
        count--;
        t = setTimeout(countdown, 1000);
    }
}
function countdownemail() {
    // starts countdown
    vddisplayemail();
    if (count1 === 0) {
        $("#sendotpemail").attr('disabled',false);
        $("#otpdivemail").hide();
    } else {
        count1--;
        t = setTimeout(countdownemail, 1000);
    }
}

function vdpause() {
    // pauses countdown
    clearTimeout(t);
}

function vdreset() {
    // resets countdown
    vdpause();
    count = CCOUNT;
    vddisplay();
}

function vdpauseemail() {
    // pauses countdown
    clearTimeout(t1);
}

function vdresetemail() {
    // resets countdown
    vdpauseemail();
    count1 = CCOUNTEMAIL;
    vddisplayemail();
}    
</script>
@endsection
