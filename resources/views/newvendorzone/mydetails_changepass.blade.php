@extends('newvendorzone.layout')

@section('title')
VGN Projects Estates Pvt Ltd |Vendor Zone| MyDetails Change Page
@endsection

@section('description')
    <meta name="description" content="">
@endsection

@section('keyword')  
@endsection


@section('style')
@include('newvendorzone.styles.commoncss')
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<style>
	.carousel-inner>.item>img
	{
		min-height: 280px;
	}
    #changedetailsForm label.col-sm-2 {
        font-weight: normal;
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
                <h3 class="box-title"><i class="fa fa-edit margin-r-5"></i> Change Password </h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              
               <div class="col-sm-6 col-sm-offset-3">
				 @if(session()->has('error_msg'))
				        <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                {{Session::get('error_msg')}}
              </div>
				        <br>
				 @endif
                 @if(session()->has('suc_msg'))
				        
				        <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-check"></i> Alert!</h4>
                {{Session::get('suc_msg')}}
              </div>
				        <br>
				 @endif
              </div>
              <div class="row">
                <div class="col-md-4 col-md-offset-4">
              <button class="btn btn-danger btn-lg" id="editvend_passworddetails"><i class="fa fa-lock"></i> <span id="editpasswordspantext">Authorize to Change Password</span></button>
              <div id="spinner1">
        <div class="text-center">
    <img src="{{ config('app.AWS_URL')}}/images/loader11.gif" width="60" height="60" alt="img loader">
    </div>
  </div>

              <h3 style="color: green; font-weight: bold;font-size: 18px;text-decoration: underline;text-transform: uppercase;" id="verifiedtickeditpassword"><i class="fa fa-check"></i> Authorized to Change Password</h3>

              </div>
              </div>
                
                <div id="Authorizepassword">
                
                <form id="changedetailsForm" method="POST" action="{{ url('/vendorzone/mydetails_changepassword') }}" class="form-horizontal" >
                {{ csrf_field() }}
                   <div class="row" style="margin-left:3px;">
                       <div class="col-md-12">
                           
                          
									<div class="form-group">
										<label for="inputPassword2" class="col-sm-2 labelalign">New Password</label>
										<div class="col-sm-4">
											<input class="form-control" id="field_pwd1" title="Type Your New Password" type="password" name="newpass" placeholder="New Password">
                                            {!! $errors->first('newpass', '<span class="errortext text-red">:message</span>') !!}
										</div>
									</div>
									<div class="form-group">
										<label for="inputPassword3" class="col-sm-2 labelalign">Re-type New Password</label>
										<div class="col-sm-4">
											<input class="form-control" id="field_pwd2" title="Please enter the same Password as above." type="password" name="retypepass" placeholder="Re-type New Password">
                                            {!! $errors->first('retypepass', '<span class="errortext text-red">:message</span>') !!}
										</div>
									</div>
									<div class="form-group" style="margin-left:25%;">
										<div class="col-sm-12">
												<div class="col-sm-3">
												
												<input class="submitbtn btn btn-danger" id="submit" type="submit" value="Update"/>
												</div>								
											</div>
										</div>     
                                 
                                     
                                             
                       </div>
                   </div>
                            
                                
                </form>
              
                </div>
              
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
   
           if (pp.type == 'editpassworddetails') {
            $("#editpasswordspantext").text('');
            $("#editpasswordspantext").text("Retry Authorize request to Edit Password("+pp.attempt+")");                  
           }

           if ((pp.id != '') ) {
            $.post('/vendorzone/editpasswordstep2', {_token: "{{csrf_token()}}", vendetails: pp}, function(data){
              console.log(data);
                if (data == 1) {
                  $("#editvend_passworddetails").hide();
                }
                else if(data == 12){              
                  window.location.reload();
                }
                else{
                  $("#verifiedtickeditpassword").hide();                  
                }
            });
           }

  
}
  </script>
  <script>
  $(document).ready(function () {
    
   

   $("#Authorizepassword").hide();
   $("#verifiedtickeditpassword").hide();
   $("#spinner1").hide();

   $("#editvend_passworddetails").on("click", function(){

     swal({
  title: "Approval Request Confirmation",
  text: "Required Approval to change the password. Click `Send Request Link` button to send approval link to your registered Mobile Number and Email ID. ",
  icon: "warning",
  buttons: ["Cancel", "Send Request Link"],
  dangerMode: true,
})
.then((willsendrequest) => {
  if (willsendrequest) {

    $.post("/vendorzone/editpasswordstep1", {_token:"{{csrf_token()}}"}, function(data){
      console.log(data);
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
            @if(!empty(Session::has('vend_auth_editpassword')))
              var apprvmsgsess = @json(Session::get('vend_auth_editpassword'));
              processfunc(apprvmsgsess);
              setInterval(function(){ processfunc(apprvmsgsess); }, 5000);

            @endif

            
            @if(!empty(Session::has('vendapprovededitpassword')))
            $("#spinner1").show();
              var apprv = @json(Session::get('vendapprovededitpassword'));

              $("#editvend_passworddetails").hide();
              $("#verifiedtickeditpassword").show();

              swal("Successfully Authenticated!", {  icon: "success",});
              
                $("#Authorizepassword").show();
                $("#spinner1").hide();

            @endif
            //flash session mobile 1 end


  });
</script>

@endsection
