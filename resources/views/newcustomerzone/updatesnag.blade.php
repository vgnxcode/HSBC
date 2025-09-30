@extends('newcustomerzone.layout')

@section('title')
VGN Projects Estates Pvt Ltd |Customer Zone| Inspection Snag Page
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



	<div class="row">
		
    <div class="col-md-10 col-md-offset-1">
      
      <div class="box box-danger">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-edit margin-r-5"></i> Update Snag </h3><span class="pull-right" ><a href="{{ url('/customerzone/inspectionsnag') }}" class="btn btn-danger btn-xs"><i class="fa fa-back margin-r-5"></i>Back</a></span>
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
               
            
                

                <form id="myForm" method="POST" action="{{ url('/customerzone/updatesnag') }}" class="form-horizontal" onsubmit="return validate(this);" >
                {{ csrf_field() }}
                   <div class="row" style="margin-left:3px;">
                       <div class="col-md-12">
                                                      
                             @if(count($snag) > 0)
<?php $i = 1; ?>
  @foreach($snag as $snagdata)		

        @if ($snagdata->vgn_status == 'CLOSED') 
                                <div class="form-group">
												<label for="projectid" class="col-sm-2 "><?php echo $i; ?>:</label>
												<div class="col-sm-4">
													<p style="padding-top: 8px;">{{ $snagdata->snag_desc }}</p>
												</div>
											</div>
	@else
    <div class="form-group">
												<label for="projectid" class="col-sm-2 "><?php echo $i; ?>:</label>
												<div class="col-sm-4">
													<input type="text" class="form-control" name="snag[desc-snag][{{$snagdata->uniqueno}}]" value="{{$snagdata->snag_desc}}" required>
												</div>
											</div>
    @endif
    <?php $i++; ?>
  @endforeach		
																				
											
											
											<br/><br/>
											<div class="form-group">
												<div class="col-sm-7"> 
													<input class="submitbtn btn btn-danger" type="submit" value="Update" id="submit" />
													<a href="{{ url('/customerzone/inspectionsnag') }}" class="btn btn-warning">Cancel</a>
												</div> 
											</div>
                                 
                                     
                                             
                       </div>
                   </div>
                    
                               <br/><br/>
											<div class="well">
											<h5 style="text-decoration: underline;"><b>Note:</b></h5>
												<ul>
													<li>Snag points created can be edited within 24 hours from the date of snag created for the flat.</li>
												</ul>
											</div>
  @endif        
                                
                </form>
              
					 

              
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


<script type="text/javascript">
											
				$(document).ready(function(){
                    
                        $('.sidebar-menu').tree();

											
				});				
		    </script>
@endsection
