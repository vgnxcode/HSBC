@extends('newvendorzone.layout')

@section('title')
VGN Projects Estates Pvt Ltd |Vendor Zone| Communications Page
@endsection

@section('description')
    <meta name="description" content="">
@endsection

@section('keyword')  
@endsection


@section('style')
@include('newcustomerzone.styles.commoncss')
<script src="{{ config('app.AWS_URL')}}/newvendorzoneassets/dist/js/defines.js"></script>
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
                <h3 class="box-title"><i class="fa fa-envelope margin-r-5"></i> Communications </h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              
              <div class="box-group" id="accordion">
               
               
               <div class="pull-right">
                   <ul class="btn-group">
                       <?php
                       if(count($mailarray['pages']) > 0){
                       
                           for($i = 0; $i < count($mailarray['pages']); $i++ ){
                               if(count($mailarray['mails']) > 0){
                               if($mailarray['mails'][0]['pagenoactive'] == $mailarray['pages'][$i]['pageno']){
                           ?>
                       <a href="<?php echo $mailarray['pages'][$i]['link'] ?>" class="btn btn-danger"><?php echo $i+1; ?></a>
                           
                           <?php
                               }
                               else{
                                   ?>
                                   <a href="<?php echo $mailarray['pages'][$i]['link'] ?>" class="btn btn-default"><?php echo $i+1; ?></a>
                                   <?php
                               }
                             }
                             else
                             {
                              echo '<script>alert("No communication available in this section!");</script>';
                              echo '<script>window.location.href="/vendorzone/dashboard";</script>';
                             }
                           }
                       }else
                       {
                           echo '<script>
                           alert("No Communication Mails received!");
                           window.location.href="/vendorzone/dashboard";</script>';
                       }
                       ?>
                        
                   </ul>
               </div>
               <br>
               <br>
                <!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
                <?php
                  if(count($mailarray['mails']) > 0){
                       
                           for($i = 0; $i < count($mailarray['mails']); $i++ ){
                  ?>
                <div class="panel box box-primary">
                  <div class="box-header with-border">
                    <h4 class="box-title">
                      <a data-toggle="collapse" data-parent="#accordion" href="#collapse{{$i}}" aria-expanded="false" class="collapsed">
                        {{ $mailarray['mails'][$i]['subject'] }}
                      </a>
                    </h4>
                  </div>
                  <div id="collapse{{$i}}" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                    <div class="box-body">
                      {!! $mailarray['mails'][$i]['body'] !!}
                        <?php
                        if(!empty($mailarray['mails'][$i]['attachment'])){
                            ?>
                        <a href="{{$mailarray['mails'][$i]['attachment']}}" class="btn btn-default" target="_blank"><i class="fa fa-file margin-r-5"></i>{{$mailarray['mails'][$i]['attachmentfilename']}}</a>
                            <?php
                        }
                        ?>
                    </div>
                  </div>
                </div>
                <?php
                           }
                  }
                               ?>
                
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

@endsection
