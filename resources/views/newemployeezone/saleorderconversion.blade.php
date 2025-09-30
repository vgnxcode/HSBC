@extends('newemployeezone.layout')

@section('title')
VGN Projects Estates Pvt Ltd |Employee Zone| Saleorder Conversion Page
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
    #changedetailsForm label.col-sm-2 {
        font-weight: normal;
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
		
    <div class="col-md-10 col-md-offset-1">
      
      <div class="box box-danger">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-edit margin-r-5"></i> Sale Order Creation </h3>
                <span class="pull-right" ><a href="{{ url('/employeezone/customercreationstep2') }}" class="btn btn-danger btn-xs"><i class="fa fa-backward margin-r-5"></i>Back</a></span>&nbsp;&nbsp;<span class="pull-right" ><a href="{{ url('/employeezone/filterleadselection') }}" class="btn btn-danger btn-xs"><i class="fa fa-search margin-r-5"></i></a></span>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              
               <div class="col-sm-6 col-sm-offset-3">
				 @if(session()->has('error_msg'))
				        <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                {!! Session::get('error_msg') !!}
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
                
                @if(count($selectedviewquote) == 0)
                <form id="changedetailsForm" method="POST" action="{{ url('/employeezone/viewquote') }}" class="form-horizontal" >
                {{ csrf_field() }}
                   <div class="row" style="margin-left:3px;">
                       <div class="col-md-12">
                           
                            
											
											<div class="form-group">
												<label for="plantcode" class="col-sm-2">Plant Code*</label>
												<div class="col-sm-4">
													
													<select class="form-control userdropdown" name="plantcode" id="projectno" required>

														<option selected value="">Select</option>
												@foreach ($getprojectnames['UNSOLD_PROJECTS'] as $value) 
												<option value="{{$value['Project_No']}}">{{$value['Project_No']}} - {{$value['Project_Name']}}</option>
																@endforeach
														
													</select>	
													{!! $errors->first('plantcode', '<span class="errortext text-red">:message</span>') !!}
													
												</div>
												
											</div>
											
											
											<div class="row">
											  			<div class="col-sm-12">
											  				
											  				<div class="form-group" style="padding:4px;">
														<label for="unitno" class="col-sm-2">Unit No.</label>
														<div class="col-sm-4">
														<select class="form-control" name="unitno" id="unitno" required>
															
															</select>
														
														</div>
														
														
													</div>

											  			</div>
											  		</div>

											  		<div class="row">
											  			<div class="col-sm-12">
											  				
											  				<div class="form-group" style="padding:4px;">
														<label for="paymentterms" class="col-sm-2">Payment Terms</label>
														<div class="col-sm-4">

														<select class="form-control" name="paymentterms" id="paymentterms" required>
															
															</select>
														
														</div>
														
														
													</div>

											  			</div>
											  		</div>
											
											
											
											
											<br/><br/>
											<div class="form-group">
												<div class="col-sm-7"> 
													<input class="submitbtn btn btn-danger" type="submit" value="View Quote" id="submit" />
													<a href="{{ url('/employeezone/leadselection') }}" class="btn btn-warning">Cancel</a>
												</div> 
											</div>
                                 
                                     
                                             
                       </div>
                   </div>
                            
                                
                </form>
              @else
              
              
              
              
              
              <form class="form-horizontal dropzone" role="form" name="myform" id="myform" action="{{url('/employeezone/uploadsaleorderfile')}}" method="post" style="margin:0 2% !important;text-align:none !important;" enctype="multipart/form-data">	
{{csrf_field()}}
										<div class="panel panel-default">
											  <div class="panel-body">

											  <div class="row">
											  	<div class="col-sm-6 col-sm-offset-3" >
											  		
											  		<div class="row">
											  		
											  			<div class="col-sm-12">
											  				
											  				<div class="form-group" style="padding:4px;">
														<label for="projectno" class="col-sm-2">Project No.</label>
														<div class="col-sm-8">

														<select class="form-control" name="sprojectno" id="sprojectno" required disabled="true">
															<option value="">Select</option>
															<?php 

									foreach ($getprojectnames['UNSOLD_PROJECTS'] as $key => $value) {
										if ($value['Project_No'] == $selectedviewquote['selectedplant']) {
											echo '<option value="'.$value['Project_No'].'" selected>'.$value['Project_No'].' - '.$value['Project_Name'].'</option>';
										}
																	
																}

															 ?>
														</select>
														
														</div>
														
														
													</div>

											  			</div>
											  		</div>


											  		<div class="row">
											  			<div class="col-sm-12">
											  				
											  				<div class="form-group" style="padding:4px;">
														<label for="unitno" class="col-sm-2">Unit No.</label>
														<div class="col-sm-8">
														<select class="form-control" name="sunitno" id="sunitno" required disabled="true">
															<?php
                                            
														foreach ($getunitlist as $key => $value) {
															if ($value['Unit_No'] == $selectedviewquote['selectedunit']) {

													echo '<option value="'.$value['Unit_No'].'" selected>'.$value['Unit_No'].' - '.$value['Unit_Description'].'</option>';

															}
														}
															 ?>
															</select>
														
														</div>
														
														
													</div>

											  			</div>
											  		</div>



											  		<div class="row">
											  			<div class="col-sm-12">
											  				
											  				<div class="form-group" style="padding:4px;">
														<label for="paymentterms" class="col-sm-2">Payment Terms</label>
														<div class="col-sm-8">

														<select class="form-control" name="spaymentterms" id="spaymentterms" required disabled="true">

														<?php
														foreach ($paymentlistarray as $key => $value) {
                                                            
															if ($value['Payment_Terms'] == $selectedviewquote['selectedpaymentterms']) {

													echo '<option value="'.$value['Payment_Terms'].'" selected>'.$value['Payment_Terms'].'</option>';

															}
														}
															 ?>
															
															</select>
														
														</div>
														
														
													</div>

											  			</div>
											  		</div>

											  		<div class="row">
											  			<div class="col-sm-12">
											  				
											  				<div class="form-group" style="padding:4px;">
														<label for="paymentterms" class="col-sm-2">Upload PDF Files</label>
														<div class="col-sm-8">

														<input type="file" class="form-control" name="customersignedpdf[]" multiple="multiple" required>
														
														</div>
														
														
													</div>

											  			</div>
											  		</div>

											  		<div class="row">
											  			
											  			<div class="col-sm-6 col-sm-offset-3">
											  				
											  				<button class="btn btn-primary" name="uploadcustomerpdf" type="submit"><i class="glyph-icon icon-upload"></i> Upload Customer Signed Document</button>

											  			</div>

											  		</div>

											  	</div>
											  	
											  </div>

											  </div>

											 

											  

										</form>
              
              
              	<br>
										
									 <?php 
										$customercode = $customer[0]['result']['Status2'];

      									$dir = "customersignedpdf/".$customercode;

      									if (is_dir($dir)) {
      										$scanned_directory = array_diff(scandir($dir), array('..', '.'));

      										if (!empty($scanned_directory)) {
      											
      										
										 ?>
										 <div class="" style="text-align: center;padding: 15px;">
										<div class="row">
										<div class="col-sm-12">
										<div class="col-sm-6">
											<a href="{{url('/employeezone/viewuploadedsaleorderfiles')}}" class="btn btn-md btn-warning"><i class="fa fa-file-text"></i> View Uploaded Signed Document</a>
										</div>
										<div class="col-sm-6">
											<form action="{{url('employeezone/createsaleorder')}}" method="post" name="createsaleorder">
											{{csrf_field()}}
												<button type="submit" name="createsaleorder" class="btn btn-md btn-warning"><i class="fa fa-thumbs-up"></i> Create Sale Order</button>
											</form>
											</div>

											</div>
										</div>
										</div>

										<?php
											}
										 }

										
										  ?>
              
              
              
              
              
              
              
              
              @endif

              
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

@include('newemployeezone.footer')
  
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->



@endsection

@section('script')
@include('newcustomerzone.js.commonjs')
<script>
    
    function readCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for(var i=0;i < ca.length;i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1,c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
    }
    return null;
}
    
    function delete_cookie(name) {
    document.cookie = name + '=;expires=Thu, 01 Jan 1970 00:00:01 GMT;path=/';
};
    var value = readCookie('viewquote');
    if(value == "viewquoteloaded"){
        delete_cookie('viewquote');
        window.location.reload();
    }

</script>

<script type="text/javascript">
									
				$(document).ready(function(){
                    
                  
                    
                    /*if ($.cookie('viewquoteloaded') != 'undefined'){
                        var viewquotecheck =  $.cookie("viewquoteloaded");
                    console.log(viewquotecheck);
                        //$.cookie("viewquoteloaded", null);
                    }*/ 
                    
                        $('.sidebar-menu').tree();  
                    //Datemask dd/mm/yyyy
                    
                    
                    $('#projectno').on('change', function(){
					var projectcode = $(this).val();
					$('#unitno').val('') ;
					$('#paymentterms').val('') ;

					$.post( "{{url('/employeezone/getunits')}}",{"_token": "{{csrf_token()}}",'projectcode': projectcode}, function( data ) {
                        
					  var output='<option value="">Select*</option>';

					  	var newdata = JSON.parse(data);
					  	if (!$.isArray(newdata)){ newdata = [newdata];} 

					  $.each(newdata, function(index,val){
						    
						    if (val['Unit_No'] != '') {
						    output += '<option value="'+val['Unit_No']+'"';
								
								output+='>'+val['Unit_No']+' - '+val['Unit_Description']+'</option>';
									  
								$('#unitno').html(output);
							}

						});


					});

					$.post( "{{url('/employeezone/getpaymentterms')}}",{"_token": "{{csrf_token()}}",'projectcode': projectcode}, function( data ) {
                        
					  var output='<option value="">Select*</option>';

					  	
					  	var newdata = JSON.parse(data);
					  	if (!$.isArray(newdata)){ newdata = [newdata];} 
					  	
					  $.each(newdata, function(index,val){
						    
						     if (val['Payment_Terms'] != '') {
						     output += '<option value="'+val['Payment_Terms']+'"';
								
							 	output+='>'+val['Payment_Terms']+'</option>';
									  
								$('#paymentterms').html(output);
							 }

						});


					});

				});
    
				});				
		    </script>
@endsection
