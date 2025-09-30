@extends('newcustomerzone.layout')

@section('title')
VGN Projects Estates Pvt Ltd |Customer Zone| MyDetails Change Page
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
                <h3 class="box-title"><i class="fa fa-edit margin-r-5"></i> Change Details </h3><span class="pull-right" ><a href="{{ url('/customerzone/mydetails_changepassword') }}" class="btn btn-danger btn-xs"><i class="fa fa-edit margin-r-5"></i>Change Password</a></span>
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
                
                
                <form id="changedetailsForm" method="POST" action="{{ url('/customerzone/changemydetails') }}" class="form-horizontal" >
                {{ csrf_field() }}
                   <div class="row" style="margin-left:3px;">
                       <div class="col-md-12">
                           <h4 class="text-red"> <i class="fa fa-map-marker margin-r-5"></i> Location </h4>
                            
                             
                                <div class="form-group">
												<label for="inputPassword3" class="col-sm-2 ">Street Address 1*</label>
												<div class="col-sm-4">
													<input type="text" class="form-control" placeholder="Street Address 1" value="{{ $customer->street1 }}" name="addr1" id="addr1" required>
													{!! $errors->first('addr1', '<span class="errortext text-red">:message</span>') !!}
												</div>
											</div>
											<div class="form-group">
												<label for="inputPassword3" class="col-sm-2 ">Street Address 2*</label>
												<div class="col-sm-4">
													<input type="text" class="form-control" placeholder="Street Address 2" value="{{ $customer->street2 }}" name="addr2" id="addr2"  required>
													{!! $errors->first('addr2', '<span class="errortext text-red">:message</span>') !!}
												</div>
											</div>
											<div class="form-group">
												<label for="inputPassword3" class="col-sm-2">Street Address 3*</label>
												<div class="col-sm-4">
													<input type="text" class="form-control" placeholder="Street Address 3" value="{{ $customer->street3 }}" name="addr3" id="addr3"  required>
													{!! $errors->first('addr3', '<span class="errortext text-red">:message</span>') !!}
												</div>
											</div>
											<div class="form-group">
												<label for="inputPassword3" class="col-sm-2">House Number*</label>
												
													<div class="col-sm-4">
														
													<input type="text" class="form-control" placeholder="House No." value="{{ $customer->houseno }}" name="houseno" id="h_no" required>
													{!! $errors->first('houseno', '<span class="errortext text-red">:message</span>') !!}
													</div>									
												
											</div>
											<div class="form-group">
												<label for="inputPassword3" class="col-sm-2">City / Postal Code*</label>
												
													<div class="col-sm-2">
													<input type="text" class="form-control" placeholder="City" value="{{ $customer->city }}" name="city" id="city" required>
													{!! $errors->first('city', '<span class="errortext text-red">:message</span>') !!}
													</div>
													<div class="col-sm-2">
													<input type="num" class="form-control" placeholder="Postal Code" value="{{ $customer->pin }}" name="pincode" id="pincode" onkeypress="return isNumberKey(event)"  required />
													{!! $errors->first('pincode', '<span class="errortext text-red">:message</span>') !!}
													</div>									
												
											</div>
											<div class="form-group">
												<label for="inputPassword3" class="col-sm-2">Country*</label>
												<div class="col-sm-4">
													
													<select class="form-control userdropdown" name="country" id="ctry" country="true" default="{{ $customer->country }}" required>

														<option value="">Select*</option>
														
													</select>	
													{!! $errors->first('country', '<span class="errortext text-red">:message</span>') !!}
												</div>
											</div>
											<div class="form-group">
												<label for="inputPassword3" class="col-sm-2">Region*</label>
												<div class="col-sm-4">
	
													<select class="form-control userdropdown" name="region" id="reg" state="true" default="{{ $customer->region }}" required>
														<option value="">Select*</option>
														
													</select>	
													{!! $errors->first('region', '<span class="errortext text-red">:message</span>') !!}
												</div>
											</div>
											<h4 class="text-red"><i class="fa fa-envelope margin-r-5"></i> Communication</h4>
											<div class="form-group">
												<label for="inputPassword3" class="col-sm-2">Telephone</label>
												<div class="col-sm-4">
													<input type="text" class="form-control" placeholder="Telephone" value="{{ $customer->tel }}" name="telephone" id="tel" onkeypress="return isNumberKey(event)" >
													{!! $errors->first('telephone', '<span class="errortext text-red">:message</span>') !!}
												</div>
											</div>
											<div class="form-group">
												<label for="inputPassword3" class="col-sm-2">Mobile Phone*</label>
												<div class="col-sm-4">
													<input type="text" class="form-control" placeholder="Mobile Phone" value="{{ $customer->mobile }}" name="mobile" id="mobile" onkeypress="return isNumberKey(event)" required maxlength='10'>
													{!! $errors->first('mobile', '<span class="errortext text-red">:message</span>') !!}
												</div>
											</div>
											<div class="form-group">
												<label for="inputPassword3" class="col-sm-2">Fax</label>
												<div class="col-sm-4">
													<input type="text" class="form-control" placeholder="Fax" value="{{ $customer->fax }}" name="fax" id="fax" onkeypress="return isNumberKey(event)" />
													{!! $errors->first('fax', '<span class="errortext text-red">:message</span>') !!}
												</div>
											</div>
											<div class="form-group">
												<label for="inputPassword3" class="col-sm-2">Email*</label>
												<div class="col-sm-13">
													<div class="col-sm-4">{{ $customer->email }}</div>
													<span id="emailerr" class="err"></span>
													
												</div>
											</div>
											<br/><br/>
											<div class="form-group">
												<div class="col-sm-7"> 
													<input class="submitbtn btn btn-danger" type="submit" value="Update" id="submit" />
													<a href="{{ url('/customerzone/mydetails') }}" class="btn btn-warning">Cancel</a>
												</div> 
											</div>
                                 
                                     
                                             
                       </div>
                   </div>
                            
                                
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

@foreach($getcustomerdata as $customer)
                    
					var country='<option value="">Select*</option>';
						$.each( countries, function( i, val ) {
							country += '<option value="'+val['c_id']+'"';
							if(val['c_id']==$('select[country]').attr('default'))
							country+=' selected ';
							country+='>'+val['c_nm']+'</option>';	
						});
											
					$('select[country]').html(country);	
						genArea();
						$('select[country]').on('change',function(){genArea();})
							function genArea()
							{
				    	var parent=$('select[country]').val();													
						var output='<option value="">Select*</option>';
							$.each( states, function( i, val ) {
									if(val['c_id']==parent)
									{	
								output += '<option value="'+val['s_id']+'"';
								if(val['s_id']==$('select[state]').attr('default'))
										output+=' selected ';
								output+='>'+val['s_nm']+'</option>';
									}  
								$('select[state]').html(output);
								});
						};
                    @endforeach
				});				
		    </script>
@endsection
