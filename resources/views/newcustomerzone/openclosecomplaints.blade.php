@extends('newcustomerzone.layout')

@section('title')
VGN Projects Estates Pvt Ltd |Customer Zone| Sales Process Feedback
@endsection

@section('description')
    <meta name="description" content="">
@endsection

@section('keyword')  
@endsection


@section('style')
@include('newcustomerzone.styles.commoncss')
<script src="{{ config('app.AWS_URL')}}/newcustomerzoneassets/dist/js/defines.js"></script>

<style>
  .carousel-inner>.item>img
  {
    min-height: 280px;
  }
    #changedetailsForm label.col-sm-2 {
        font-weight: normal;
    }
    .grow { transition: all .2s ease-in-out; }
.grow:hover { transform: scale(1.1); }

.bgsuc{
  background: green;
  color: white;
}
.bgerr{
  background: red;
}

.btn {
  cursor:pointer;
}

.card2 {
  background: #fff;
  border-radius: 2px;
  display: inline-block;
  position: relative;
  box-shadow: 0 3px 6px rgba(0,0,0,0.16), 0 3px 6px rgba(0,0,0,0.23);
}

.card1 {
  background: #fff;
  border-radius: 2px;
  display: inline-block;
  position: relative;
  box-shadow: 0 3px 6px rgba(0,0,0,0.16), 0 3px 6px rgba(0,0,0,0.23);
}
.card2:hover {
  box-shadow: 0 14px 28px rgba(0,0,0,0.25), 0 10px 10px rgba(0,0,0,0.22);
}

</style>

@endsection

@section('bodycontent')
<body class="hold-transition fixed">

<!-- Site wrapper -->
<div class="wrapper">



  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper1">
    <!-- Content Header (Page header) -->
   
    <!-- Main content -->
    <section class="content">
  
  
  <div class="row" >
    
    <div class="col-md-10 col-md-offset-1" >
      
      <div class="box box-danger card1" >
            <div class="box-header with-border">
                <img src="{{ config('app.AWS_URL')}}/images/custom/vgn-logo.png" alt="vgn logo" class="img-responsive" id="logo">
            </div>
            <!-- /.box-header -->
            <div class="box-body">




<!--Start-->
<div class="col-md-10 col-md-offset-1">
          <div class="box box-default card2">
            <div class="box-header with-border">
              

              <h3 class="box-title" style="color:#dd4b39;font-weight:bold;"><i class="fa fa-bullhorn margin-r-5"></i> VGN Projects Estates Pvt Ltd - Customer Complaints</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body" style="padding:0px !important;">
              <div class="alert" style="background-color:#dd4b39;color: #fff;text-justify:distribute;">
                
                <h4 style="font-weight: normal;"><span style="line-height: 2.2em;">Dear {{ $name }},</span></h4>
                @if(session()->has('suc_msg'))
                <p>{{Session::get('suc_msg')}}</p>
                @else
                <p>We hope your complaint has been addressed? If resolved kindly click "Yes" to close the complaint or click "No" if not satisfied.</p><br>
                <a class="btn btn-sm btn-warning" id="yes" style="text-decoration:none;"><i class="fa fa-thumbs-up"></i> Yes</a>
                <a href="/customerzone/customerlogin" class="btn btn-sm btn-warning" id="no" style="text-decoration:none;"><i class="fa fa-thumbs-down"></i> No</a>
                @endif
              </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>

        
<!--End  -->
              

              
            </div>
            <!-- /.box-body -->
          </div>

    </div>


    

    
  </div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  



@endsection

@section('script')
@include('newcustomerzone.js.commonjs')


<script type="text/javascript">
                      
        $(document).ready(function(){

          $("#yes").on('click', function(){
            var url_string = window.location.href;
            var url = new URL(url_string);
            var c = url.searchParams.get("complaintno");
            $.post("/customerzone/closecomplaint", {_token: '{{csrf_token()}}','compno': c }, function(data){
              console.log(data);
                  window.location.reload();

            });

          });

    
        });       
        </script>
@endsection
