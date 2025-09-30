@extends('newemployeezone.layout')

@section('title')
VGN Projects Estates Pvt Ltd |Employee Zone| Dashboard Page
@endsection

@section('description')
    <meta name="description" content="">
@endsection

@section('keyword')  
@endsection


@section('style')
@include('newemployeezone.styles.commoncss')
<style>
	.carousel-inner>.item>img
	{
		min-height: 280px;
	}
  /*.centered {
  height: 95px;
    position: absolute;
    top: 60%;
    left: 50%;
    transform: translate(-50%, -50%);
    overflow: hidden;
}*/

.centered {
  height: 95px;
 /*   position: absolute;
    top: 60%;
    left: 50%;
    transform: translate(-50%, -50%);*/
    overflow: hidden;
}
</style>

@endsection

@section('bodycontent')
<body class="hold-transition skin-red fixed sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">

@foreach($getemployeedata as $employee)
 
  @include('newemployeezone.header.index')
  @include('newemployeezone.aside.index')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
   
    <!-- Main content -->
    <section class="content">
	
	<div class="row">
		<div class="col-md-10 col-md-offset-1">

	@include('newemployeezone.contenttop')


      	</div>
	</div>



	<div class="row">
		
		<div class="col-md-6">
			<div class="box box-danger">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-dashboard margin-r-5"></i> Dashboard</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
             
@foreach($getdashboard as $dashboard)
              <strong><i class="fa fa-pencil margin-r-5"></i> Details</strong>

              	<ul>
                <li>Last Modified Date - @if($dashboard->last_details_changed != null){{ $dashboard->last_details_changed }}@else Nil @endif</li>
				</ul>
              

              <hr>
              <strong><i class="fa fa-lock margin-r-5"></i> Password</strong>

              <ul>
                
                <li>Last Modified Date - @if($dashboard->last_password_changed != null){{ $dashboard->last_password_changed }}@else Nil @endif</li>
              </ul>

               <hr>
               <strong><i class="fa fa-tasks margin-r-5"></i> Training</strong>

              <ul>
                
                <li>Next Training Date - @if($dashboard->next_training_date != null){{ $dashboard->next_training_date }}@else Nil @endif</li>
              </ul>

               <hr>
              <strong><i class="fa fa-rupee margin-r-5"></i> Ledger Balance</strong>
              
              @if ((preg_match("/-/m", $dashboard-> loans_and_advances)) == 0)
                <ul>
                  <li>Balance Due - {{ $dashboard-> loans_and_advances }}</li>
                </ul>
              @else
                <ul>
                  <li>Balance Due - 0.00</li>
                </ul>
              @endif
              <hr>
              <strong><i class="fa fa-bullhorn margin-r-5"></i> Complaints</strong>

              <ul>
                <li>Raised - {{ $dashboard->t_comp_raised }}</li>
                <li>Closed - {{ $dashboard->t_comp_closed }}</li>
                <li>Pending - {{ $dashboard->t_comp_pending }}</li>
              </ul>
              <hr>
              <strong><i class="fa fa-exchange margin-r-5"></i> Request</strong>

              <ul>
                <li>Pending - {{ $dashboard->t_pending_req }}</li>
                
              </ul>
              <hr>
              <strong><i class="fa fa-warning margin-r-5"></i> Memos</strong>

              <ul>
                <li>Issued - {{ $dashboard->t_memos_issued }}</li>
                
              </ul>
				@endforeach
            </div>
            <!-- /.box-body -->
          </div>
		</div>

	  

    <div class="col-md-5 col">
      <div class="row">
      <div class="box box-solid card">
            <div class="box-header with-border bg-red">
              

              <h3 class="box-title display-3"><i class="fa fa-users"></i> Employee Birthday Wishes & Greetings!</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">

              <!--start -->
              <div class="centered">
        <marquee direction="up" loop="infinite" scrollamount="3" scrolldelay="0" onmouseover="this.stop();" onmouseout="this.start();" class="marq1">

          @if(count($getbirthday_employees) > 0)
          @foreach($getbirthday_employees as $birthday)
          <?php $dep = strtolower($birthday->Department);
          $cc = '';
          $title = '';
            if ($birthday->Gender == 'Male') {
              $cc = 'his';
	      $kk = 'him';
              $title = 'Mr '; 
            }
            else{
              $cc = 'her';
	      $kk = 'her';
              $title = 'Ms ';
            }
           ?>

        <p><i class="fa fa-birthday-cake"></i> {{$title}}{{$birthday->Emp_Name}} from {{$dep}} celebrating {{$cc}} birthday! VGN wishes {{$kk}} success and happiness.</p>
        @endforeach
        @endif


         @if(count($experience) > 0)
          @foreach($experience as $exp)
          <?php $dep = strtolower($exp->Department);
          $cc = '';
          $title = '';
            if ($exp->Gender == 'Male') {
              $cc = 'his';
              $title = 'Mr '; 
            }
            else{
              $cc = 'her';
              $title = 'Ms ';
            }

            if ($exp->differeinyears != 0) {            
           ?>


        <p><i class="fa fa-user"></i> {{$title}}{{$exp->Emp_Name}} from {{$dep}} completed {{$cc}} {{$exp->differeinyears}} years of service in VGN!</p>
        <?php
          }
        ?>
        @endforeach
        @endif

        @if((count($experience) == 0) && (count($getbirthday_employees) == 0))
        <p style="text-transform: capitalize;"><i class="fa fa-user"></i> Employee doesn't have Birthday or Work Anniversary today!</p>
        @endif

        
      </marquee>
      </div>
              <!-- end -->

            </div>
          </div>

        </div>

       
    </div>

	</div>
@endforeach
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  @include('newemployeezone.footer')

  
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->



@endsection

@section('script')
@include('newemployeezone.js.commonjs')
<script>
  $(document).ready(function () {
    $('.sidebar-menu').tree();
     if ($(document).width() <= 938) {
      $('.centered').css('height', '100px');
      $('.marq1').css('height', '100px');
      $('.marq2').css('height', '100px');
    }
    else{
      $('.centered').css('height', '200px');
      $('.marq1').css('height', '200px');
      $('.marq2').css('height', '200px');
    }
  })
</script>
@endsection
