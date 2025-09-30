@extends('newcustomerzone.layout')

@section('title')
VGN Projects Estates Pvt Ltd |Customer Zone| Dashboard Page
@endsection

@section('description')
    <meta name="description" content="">
@endsection

@section('keyword')  
@endsection


@section('style')
@include('newcustomerzone.styles.commoncss')
<style>
	.carousel-inner>.item>img
	{
		min-height: 280px;
	}
</style>

@endsection

@section('bodycontent')
<body class="hold-transition skin-red fixed sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">

@foreach($getcustomerdata as $customer)
 
  @include('newcustomerzone.header.index')
  @include('newcustomerzone.aside.index')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
   
    <!-- Main content -->
    <section class="content">
	
	<div class="row">
		<div class="col-md-10 col-md-offset-1">

	@include('newcustomerzone.contenttop')


      	</div>
	</div>


<?php
if(strpos($customer->net_amt,'-') !== false){
  $netamt = 0;
}
else{
  $netamt = $customer->net_amt;
}
?>

	<div class="row">
		
		<div class="col-md-6">
			<div class="box box-danger">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-dashboard margin-r-5"></i> Dashboard</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <strong><i class="fa fa-pencil margin-r-5"></i> You have changed your details on</strong>

              <ul>
               <li> {{ $customer->updated }}</li>
              </ul>

             
              <hr>

              <strong><i class="fa fa-bullhorn margin-r-5"></i> Complaints</strong>

              	<ul>
                <li>Raised - {{ $customer->comp_raised }}</li>
                <li>Pending - {{ $customer->comp_pending }}</li>
                <li>Closed - {{ $customer->comp_closed }}</li>
				</ul>
              

              <hr>
              <strong><i class="fa fa-lock margin-r-5"></i> Password</strong>

              <ul>
                <li>No. of times changed - {{ $customer->pwd_count }}</li>
                <li>Last Modified Date - {{ $customer->pwd_updated }}</li>
              </ul>

               <hr>
              <strong><i class="fa fa-rupee margin-r-5"></i> Payment</strong>

              <ul>
                <li>Outstanding - {{ $netamt }}</li>
              </ul>
				
				 <hr>
              <strong><i class="fa fa-building margin-r-5"></i> Projects</strong>

              <ul>
                <li>No of projects Booked - {{ $customer->nou }}</li>
              </ul>

            </div>
            <!-- /.box-body -->
          </div>
		</div>

		<div class="col-md-6">
			
			
			<div class="box box-solid">
            
            <!-- /.box-header -->
            <div class="box-body">
              <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                  <li data-target="#carousel-example-generic" data-slide-to="0" class=""></li>
                  <li data-target="#carousel-example-generic" data-slide-to="1" class=""></li>
                  <li data-target="#carousel-example-generic" data-slide-to="2" class="active"></li>
                  <li data-target="#carousel-example-generic" data-slide-to="3" class=""></li>
                  <li data-target="#carousel-example-generic" data-slide-to="4" class=""></li>
                  <li data-target="#carousel-example-generic" data-slide-to="5" class=""></li>
                </ol>
                <div class="carousel-inner">
                  <div class="item">
                    <img src="{{ config('app.AWS_URL')}}/newcustomerzoneassets/img/dashboard/2.jpg" alt="Slide1">
                  </div>
                  <div class="item">
                    <img src="{{ config('app.AWS_URL')}}/newcustomerzoneassets/img/dashboard/4.jpg" alt="Slide2">
                  </div>
                  <div class="item active">
                    <img src="{{ config('app.AWS_URL')}}/newcustomerzoneassets/img/dashboard/5.jpg" alt="Slide3">
                  </div>
                  <div class="item">
                    <img src="{{ config('app.AWS_URL')}}/newcustomerzoneassets/img/dashboard/5.jpg" alt="Slide4">
                  </div>
                  <div class="item">
                    <img src="{{ config('app.AWS_URL')}}/newcustomerzoneassets/img/dashboard/1.jpg" alt="Slide5">
                  </div>
                  <div class="item">
                    <img src="{{ config('app.AWS_URL')}}/newcustomerzoneassets/img/dashboard/109.jpg" alt="Slide6">
                  </div>
                </div>
                <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
                  <span class="fa fa-angle-left"></span>
                </a>
                <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
                  <span class="fa fa-angle-right"></span>
                </a>
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

  @include('newcustomerzone.footer')
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->



@endsection

@section('script')
@include('newcustomerzone.js.commonjs')
<script>
  $(document).ready(function () {
    $('.sidebar-menu').tree()
  })
</script>
@endsection
