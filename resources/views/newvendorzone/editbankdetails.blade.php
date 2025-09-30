@extends('newcustomerzone.layout')

@section('title')
VGN Projects Estates Pvt Ltd |Vendor Zone| My Bank Details Page
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
                <h3 class="box-title"><i class="fa fa-bank margin-r-5"></i> My Bank Details </h3><span class="pull-right" ><a href="{{ url('/vendorzone/mybankdetails') }}" class="btn btn-danger btn-xs">Back</a></span>
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
              <button class="btn btn-danger btn-lg" id="editvend_bankdetails"><i class="fa fa-lock"></i> <span id="editbankspantext">Authorize to Edit Bank Details</span></button>
              <div id="spinner1">
        <div class="text-center">
    <img src="{{ config('app.AWS_URL')}}/images/loader11.gif" width="60" height="60" alt="img loader">
    </div>
  </div>

              <h3 style="color: green; font-weight: bold;font-size: 18px;text-decoration: underline;text-transform: uppercase;" id="verifiedtickeditbank"><i class="fa fa-check"></i> Authorized to edit bank details</h3>

              </div>
              </div>
              <div id="Authorize">
               <form id="changedetailsForm" method="POST" action="{{ url('/vendorzone/editbankdetails') }}" class="form-horizontal" >
                {{ csrf_field() }}
                   <div class="row" style="margin-left:3px;">
                       <div class="col-md-12">
                           <h4 class="text-red"> <i class="fa fa-info-circle margin-r-5"></i> Edit Account Information </h4>
                            
                             
                                <div class="form-group">
                        <label for="bank_act_no" class="col-sm-2 ">Bank Account No*</label>
                        <div class="col-sm-4">
                        <input type="text" class="form-control" value="{{ old('bank_account_no') }}" name="bank_account_no" id="bank_act_no" required>
                          {!! $errors->first('bank_account_no', '<span class="errortext text-red">:message</span>') !!}
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="retype_bank_account_no" class="col-sm-2 ">Retype Bank Account No*</label>
                        <div class="col-sm-4">
                          <input type="text" class="form-control" value="{{ old('confirm_bank_account_no') }}" name="retype_bank_account_no" id="confirm_bank_account_no" required>
                          {!! $errors->first('retype_bank_account_no', '<span class="errortext text-red">:message</span>') !!}
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="bank_name" class="col-sm-2 ">Bank Name*</label>
                        <div class="col-sm-4">
                        <input type="text" class="form-control" value="{{ old('bank_name') }}" name="bank_name" id="bank_name"  required>
                          {!! $errors->first('bank_name', '<span class="errortext text-red">:message</span>') !!}
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="ifsc_code" class="col-sm-2">IFSC Code*</label>
                        <div class="col-sm-4">
                        <input type="text" class="form-control" value="{{ old('ifsc_code') }}" name="ifsc_code" id="ifsc_code"  required>
                          {!! $errors->first('ifsc_code', '<span class="errortext text-red">:message</span>') !!}
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="branch_name" class="col-sm-2">Branch Name*</label>
                        
                          <div class="col-sm-4">
                            
                          <input type="text" class="form-control" value="{{ old('branch_name') }}" name="branch_name" id="branch_name" required>
                          {!! $errors->first('branch_name', '<span class="errortext text-red">:message</span>') !!}
                          </div>                  
                        
                      </div>
                      
                      
                      <br/><br/>
                      <div class="form-group">
                        <div class="col-sm-7"> 
                          <input class="submitbtn btn btn-danger" type="submit" value="Update" id="submit" />
                          <a href="{{ url('/vendorzone/mybankdetails') }}" class="btn btn-warning">Cancel</a>
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
    
    if (pp.type == 'editbankdetails') {
     $("#editbankspantext").text('');
     $("#editbankspantext").text("Retry Authorize request to Edit Bank Details("+pp.attempt+")");                  
    }

    if ((pp.id != '') ) {
     $.post('/vendorzone/editbankdetailsstep2', {_token: "{{csrf_token()}}", vendetails: pp}, function(data){
       
         if (data == 1) {
           $("#editvend_bankdetails").hide();
         }
         else if(data == 12){              
           window.location.reload();
         }
         else{
           $("#verifiedtickeditbank").hide();                  
         }
     });
    }


}
</script>
<script>
  $(document).ready(function () {
    $('.sidebar-menu').tree();

        $('#bank_name, #ifsc_code, #branch_name').on('keyup',function(){
    $(this).val($(this).val().toUpperCase());
});
          $('#bank_name, #ifsc_code, #branch_name').on('change',function(){
    $(this).val($(this).val().toUpperCase());
});
   
$("#Authorize").hide();
   $("#verifiedtickeditbank").hide();
   $("#spinner1").hide();

   $("#editvend_bankdetails").on("click", function(){

     swal({
  title: "Approval Request Confirmation",
  text: "Required Approval to change the bank details. Click `Send Request Link` button to send approval link to your registered Mobile Number and registered Email ID. ",
  icon: "warning",
  buttons: ["Cancel", "Send Request Link"],
  dangerMode: true,
})
.then((willsendrequest) => {
  if (willsendrequest) {

    $.post("/vendorzone/editbankdetailsstep1", {_token:"{{csrf_token()}}"}, function(data){
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
            @if(!empty(Session::has('vend_auth_editbank')))
              var apprvmsgsess = @json(Session::get('vend_auth_editbank'));
              processfunc(apprvmsgsess);
              setInterval(function(){ processfunc(apprvmsgsess); }, 5000);

            @endif

            
            @if(!empty(Session::has('vendapprovededitbank')))
            $("#spinner1").show();
              var apprv = @json(Session::get('vendapprovededitbank'));
              $("#editvend_bankdetails").hide();
              $("#verifiedtickeditbank").show();

              swal("Successfully Authenticated!", {  icon: "success",});
              
                $("#Authorize").show();
                $("#spinner1").hide();

            @endif
            //flash session mobile 1 end


  });
</script>
@endsection
