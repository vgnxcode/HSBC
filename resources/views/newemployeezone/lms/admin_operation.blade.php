@extends('newvendorzone.layout')

@section('title')
VGN Projects Estates Pvt Ltd |Employee Zone| Admin LMS Operation Page
@endsection

@section('description')
    <meta name="description" content="">
@endsection

@section('keyword')  
@endsection


@section('style')
@include('newvendorzone.styles.signincss')
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
 <a href="http://www.vgn.in">
  <div class="login-logo">
    <img src="{{ config('app.AWS_URL')}}/images/custom/vgn-logo.png" align="center" >
  </div>
  </a>
  <!-- /.login-logo -->
  <div class="login-box-body box-body">
    <h4 class="login-box-msg" style="background-color:#f7f7f7; font-size: 18px; text-align: center; padding: 7px 10px; margin-top: 0;">Employee Application</h4>
    <br>

    @foreach($getdata as $k)
<div class="row">
            <div class="form-group">
                  <label for="inputEmail3" class="col-sm-6 control-label">Employee Id</label>

                  <div class="col-sm-6">
                    {{$k->employeeid}}
                  </div>
                </div>

</div>

<div class="row">

                 <div class="form-group">
                  <label for="inputEmail3" class="col-sm-6 control-label">Leave Application</label>

                  <div class="col-sm-6">
                    {{$k->type}}
                  </div>
                </div>
  </div>

  <div class="row">
            <div class="form-group">
                  <label for="inputEmail3" class="col-sm-6 control-label">Start Date</label>

                  <div class="col-sm-6">
                    {{ \Carbon\Carbon::parse($k->stdate)->format('d M, Y H:i:s') }}
                  </div>
                </div>

  </div>

   <div class="row">
            <div class="form-group">
                  <label for="inputEmail3" class="col-sm-6 control-label">End Date</label>

                  <div class="col-sm-6">
                    {{ \Carbon\Carbon::parse($k->etdate)->format('d M, Y H:i:s') }}
                  </div>
                </div>

   </div>

   <div class="row">
            <div class="form-group">
                  <label for="inputEmail3" class="col-sm-6 control-label">Employee Reason</label>

                  <div class="col-sm-6">
                    {{ $k->emp_reason }}
                  </div>
                </div>
   </div>

    <div class="row">
            <div class="form-group">
                  <label for="inputEmail3" class="col-sm-6 control-label">HOD Status</label>

                  <div class="col-sm-6">
                    Approved
                  </div>
                </div>
      </div>

      

@endforeach

    <form id="myForm" method="POST" action="{{ url('/employeezone/lms/adminoperation')}}/reject/{{$hashedkey}}">
    {{ csrf_field() }}

      <div class="form-group has-feedback">
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
        <textarea class="form-control" name="admin_reason" id="admin_reason" cols="30" rows="10" placeholder="Comments..." required></textarea>
        {!! $errors->first('admin_reason', '<span class="errortext">:message</span>') !!}
        
      </div>
 
      <div class="row">
        <div class="col-xs-8">
         
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-danger btn-block btn-flat">Submit</button>
        </div>
        <!-- /.col -->
      </div>
    </form>

    <div class="social-auth-links text-center">
     <!-- <p>To know your Vendor-Id or registered email/phone. Contact our customer care at <a href="tel:04443439977">044 43439977</a></p>-->
      
    </div>
    <!-- /.social-auth-links -->

    
    

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
