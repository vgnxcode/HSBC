@extends('newvendorzone.layout')

@section('title')
VGN Projects Estates Pvt Ltd |Billdesk Payment Page
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
    .error
    {
        color: red;
        visibility: hidden;
    }
  
  .form-horizontal .form-group {
    margin-right: 0px;
    margin-left: 0px;
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

  #sub:hover{
    background: #f39c12;
    color: #fff;
    border: 1px solid #e08e0b;
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
 <div class="col-md-4 col-md-offset-4">
<div class="mainbox box box-danger" style="box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2); transition: 0.3s;margin: 10px;">
  <div class="login-logo">
   <a href="{{ url('/')}}"> <img src="{{ config('app.AWS_URL')}}/images/custom/vgn-logo.png" align="center" ></a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body box-body" style="padding: 10px 0px;">
    <h4 class="login-box-msg" style="background-color: #dd4b39; color: #fff; font-size: 18px; text-align: center; padding: 7px 10px; margin-top: 0; text-transform: uppercase;">Payment Details</h4>
    <br>

    <form id="myForm" class="form-horizontal" method="POST" action="{{ url('/bps')}}/{{$shortcode}}">
    {{ csrf_field() }}

     @if(count($getcodedata) > 0)
      @foreach($getcodedata as $data)
      
       <div class="form-group" style="padding: 5px;">
                  <label for="cid" class="col-sm-5 control-label">Customer ID :</label>

                  <div class="col-sm-7" >
                    <input type="text" name="cid" class="form-control" value="{{$data->customerid}}" readonly="true">
                  </div>
     </div>
      <div class="form-group" style="padding: 5px;">
                  <label for="name" class="col-sm-5 control-label">Customer Name :</label>

                  <div class="col-sm-7" >
                    <input type="text" name="name" class="form-control" value="{{$data->name}}" readonly="true">
                  </div>
     </div>

     <div class="form-group" style="padding: 5px;">
                  <label for="plantname" class="col-sm-5 control-label">Project Name :</label>

                  <div class="col-sm-7" >
                    <input type="text" name="plantname" class="form-control" value="{{$data->plantname}}" readonly="true">
                  </div>
     </div>

     <div class="form-group" style="padding: 5px;">
                  <label for="unitdesc" class="col-sm-5 control-label">Unit Description :</label>

                  <div class="col-sm-7 " >
                    <input type="text" name="unit_desc" class="form-control" value="{{$data->unit_desc}}" readonly="true">
                  </div>
     </div>

      <div class="form-group" style="padding: 5px;">
                  <label for="paymenttype" class="col-sm-5 control-label">Payment Type :</label>

                  <div class="col-sm-7">
                    <input type="text" name="payment_type" class="form-control" value="{{$ptype}}" readonly="true">
                  </div>
     </div>

     <div class="form-group" style="padding: 5px;">
                  <label for="Outstandingbal" class="col-sm-5 control-label">Outstanding Balance :</label>

                  <div class="col-sm-7">
                    <input type="text" name="Outstandingbal" class="form-control" value="{{$outstandingbal}}" readonly="true">
                  </div>
     </div>

      <div class="form-group" style="padding: 5px;">
                  <label for="amount" class="col-sm-5 control-label">Invoice Amount :</label>

                  <div class="col-sm-7">
                    <input type="text" name="amount" class="form-control" value="{{$data->amount}}" readonly="true">
                  </div>
     </div>

     <div class="form-group" style="padding: 5px;">
                  <label for="enteramount" class="col-sm-5 control-label">Enter Amount to Pay :</label>

                  <div class="col-sm-7">
                    <input type="number" name="enteramount" class="form-control" value="{{$data->amount}}" step=".01" required="true">
                    <span class="text-muted">Note: Amount should not be less than invoice amount.</span>
                  </div>
     </div>
     
              
                 
                
             
       
      
      <div class="row">
        
        <!-- /.col -->
        <div class="col-sm-6 col-sm-offset-3 col-xs-6 col-xs-offset-3">
          <button type="submit" class="btn btn-danger btn-block btn-flat" id="sub"><i class="fa fa-send"></i> Pay</button>
        </div>
        <!-- /.col -->
      </div>

       @endforeach
      @endif
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


                     
                  });
                  
                </script>

@endsection
