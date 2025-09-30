@extends('customer-zone.layout')

@section('title')
VGN Property Developers |Customer Zone| MyDetails Change Page
@endsection

@section('description')
    <meta name="description" content="">
@endsection

@section('keyword')  
@endsection

@section('stylesheet')
	<link rel="stylesheet" href="{{ asset('assets/css/normalize.css') }}">
    <script src="{{ asset('portal/assets-minified/js-core.js') }}"></script>
    <script src="{{ asset('portal/loader.js') }}"></script>
   <link rel="stylesheet" type="text/css" href="{{ asset('portal/assets-minified/helpers/helpers-all.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ asset('portal/assets-minified/elements/elements-all.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ asset('portal/assets-minified/icons/fontawesome/fontawesome.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ asset('portal/assets-minified/icons/linecons/linecons.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ asset('portal/assets-minified/snippets/snippets-all.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ asset('portal/assets-minified/applications/mailbox.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ asset('portal/assets-minified/themes/supina/layout.css') }}">
		<link id="layout-color" rel="stylesheet" type="text/css" href="{{ asset('portal/assets-minified/themes/supina/default/layout-color.css') }}">
		<link id="framework-color" rel="stylesheet" type="text/css" href="{{ asset('portal/assets-minified/themes/supina/default/framework-color.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ asset('portal/assets-minified/themes/supina/border-radius.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ asset('portal/assets-minified/helpers/colors.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ asset('portal/assets-minified/demo-widgets.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ asset('portal/assets/style.css') }}">
		<script type="text/javascript" src="{{ asset('portal/assets-minified/demo-widgets.js') }}"></script>
		<script type="text/javascript" src="{{ asset('portal/assets/defines.js') }}"></script>
    <style>
			  #loading {position: fixed;width: 100%;height: 100%;left: 0;top: 0;right: 0;bottom: 0;display: block;background: #fff;z-index: 10000;}
			#loading img {position: absolute;top: 50%;left: 50%;margin: -23px 0 0 -23px;}
			body{background: url(/portal/assets/pattern.jpg) repeat;}
			.submitbtn
			{
				margin-left:32%;
			}
            .errortext
			{
				color: red;
			}
</style>
<script type="text/javascript">
											
				$(document).ready(function(){
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
				});				
		    </script>

@endsection

@section('header')
    
@endsection

@section('content')


<div id="loading">
		<img src="{{url('portal/assets-minified/images/spinner/loader-dark.gif')}}" alt="Loading...">
</div>
	<div id="sb-site">
	@foreach($getcustomerdata as $customerdata)
		<div id="page-wrapper">
			@include('customer-zone.header.index')
			@include('customer-zone.sidebar')
			<div id="page-content-wrapper" class="rm-transition">

				<div id="page-content">
					<div class="row">
						@include('customer-zone.content-top')
						
                    <div class="col-md-12">


                        <div class="content-box mrg25T mrg25B">
								<h3 class="content-box-header content-box-header-alt bg-white">	
									<span class="icon-separator"><i class="glyph-icon icon-wrench"></i></span>
									<div class="header-wrapper">Change Details</div>
								</h3>
								<div class="content-box-wrapper">

                                <div class="col-sm-6 col-sm-offset-3">
									@if(session()->has('error_msg'))
											<err>{{Session::get('error_msg')}}</err>
									@endif
                                    @if(session()->has('suc_msg'))
											<suc>{{Session::get('suc_msg')}}</suc>
									@endif
                                    </div>
                                    <br>
                                    
										
								<form id="myForm" method="POST" action="{{ url('/customerzone/changemydetails') }}" class="form-horizontal" style="margin-left:8% !important;margin-top:4%;text-align:none !important;">
                                {{ csrf_field() }}
                                
									<div class="col-sm-12">
												<a style="float:right;" class="raise-comp" href="{{ url('/customerzone/mydetails_changepassword') }}">Change Password</a>
											</div>
											<div class="form-group">
												<label for="inputEmail3" class="col-sm-2">Customer No</label>
												<div class="col-sm-2">
													<span>{{ $customerdata->id }}</span>
												</div>
												
											</div>
											<div class="form-group">
												<label for="inputPassword3" class="col-sm-2">Name</label>
												<div class="col-sm-4">
													<span>{{ $customerdata->name }}</span>
												</div>
											</div><br>
											<div class="form-group">
												<span class="bs-label label-info fieldlabel" style="margin-left:1%;">Address:</span>
											</div>
											<div class="form-group">
												<label for="inputPassword3" class="col-sm-2 ">Street Address 1*</label>
												<div class="col-sm-4">
													<input type="text" class="form-control" placeholder="Street Address 1" value="{{ $customerdata->street1 }}" name="addr1" id="addr1" required>
													{!! $errors->first('addr1', '<span class="errortext">:message</span>') !!}
												</div>
											</div>
											<div class="form-group">
												<label for="inputPassword3" class="col-sm-2 ">Street Address 2*</label>
												<div class="col-sm-4">
													<input type="text" class="form-control" placeholder="Street Address 2" value="{{ $customerdata->street2 }}" name="addr2" id="addr2"  required>
													{!! $errors->first('addr2', '<span class="errortext">:message</span>') !!}
												</div>
											</div>
											<div class="form-group">
												<label for="inputPassword3" class="col-sm-2">Street Address 3*</label>
												<div class="col-sm-4">
													<input type="text" class="form-control" placeholder="Street Address 3" value="{{ $customerdata->street3 }}" name="addr3" id="addr3"  required>
													{!! $errors->first('addr3', '<span class="errortext">:message</span>') !!}
												</div>
											</div>
											<div class="form-group">
												<label for="inputPassword3" class="col-sm-2">House Number*</label>
												<div class="col-sm-12">
													<div class="col-sm-4">
														
													<input type="text" class="form-control" placeholder="House No." value="{{ $customerdata->houseno }}" name="houseno" id="h_no" required>
													{!! $errors->first('houseno', '<span class="errortext">:message</span>') !!}
													</div>									
												</div>
											</div>
											<div class="form-group">
												<label for="inputPassword3" class="col-sm-2">City / Postal Code*</label>
												<div class="col-sm-12">
													<div class="col-sm-2">
													<input type="text" class="form-control" placeholder="City" value="{{ $customerdata->city }}" name="city" id="city" required>
													{!! $errors->first('city', '<span class="errortext">:message</span>') !!}
													</div>
													<div class="col-sm-2">
													<input type="num" class="form-control" placeholder="Postal Code" value="{{ $customerdata->pin }}" name="pincode" id="pincode" onkeypress="return isNumberKey(event)"  required />
													{!! $errors->first('pincode', '<span class="errortext">:message</span>') !!}
													</div>									
												</div>
											</div>
											<div class="form-group">
												<label for="inputPassword3" class="col-sm-2">Country*</label>
												<div class="col-sm-4">
													
													<select class="form-control userdropdown" name="country" id="ctry" country="true" default="{{ $customerdata->country }}" required>

														<option value="">Select*</option>
														
													</select>	
													{!! $errors->first('country', '<span class="errortext">:message</span>') !!}
												</div>
											</div>
											<div class="form-group">
												<label for="inputPassword3" class="col-sm-2">Region*</label>
												<div class="col-sm-4">
	
													<select class="form-control userdropdown" name="region" id="reg" state="true" default="{{ $customerdata->region }}" required>
														<option value="">Select*</option>
														
													</select>	
													{!! $errors->first('region', '<span class="errortext">:message</span>') !!}
												</div>
											</div><br>
											<div class="form-group">
												<span class="bs-label label-info fieldlabel" style="margin-left:1%;">Communications:</span>
											</div>
											<div class="form-group">
												<label for="inputPassword3" class="col-sm-2">Telephone</label>
												<div class="col-sm-4">
													<input type="text" class="form-control" placeholder="Telephone" value="{{ $customerdata->tel }}" name="telephone" id="tel" onkeypress="return isNumberKey(event)" >
													{!! $errors->first('telephone', '<span class="errortext">:message</span>') !!}
												</div>
											</div>
											<div class="form-group">
												<label for="inputPassword3" class="col-sm-2">Mobile Phone*</label>
												<div class="col-sm-4">
													<input type="text" class="form-control" placeholder="Mobile Phone" value="{{ $customerdata->mobile }}" name="mobile" id="mobile" onkeypress="return isNumberKey(event)" required maxlength='10'>
													{!! $errors->first('mobile', '<span class="errortext">:message</span>') !!}
												</div>
											</div>
											<div class="form-group">
												<label for="inputPassword3" class="col-sm-2">Fax</label>
												<div class="col-sm-4">
													<input type="text" class="form-control" placeholder="Fax" value="{{ $customerdata->fax }}" name="fax" id="fax" onkeypress="return isNumberKey(event)" />
													{!! $errors->first('fax', '<span class="errortext">:message</span>') !!}
												</div>
											</div>
											<div class="form-group">
												<label for="inputPassword3" class="col-sm-2">Email*</label>
												<div class="col-sm-13">
													<div class="col-sm-4">{{ $customerdata->email }}</div>
													<span id="emailerr" class="err"></span>
													
												</div>
											</div>
											<br/><br/>
											<div class="form-group">
												<div class="col-sm-7"> 
													<input class="submitbtn btn btn-blue-alt" type="submit" value="Update" id="submit" />
													<a href="{{ url('/customerzone/mydetails') }}" style="background-color:#65a6ff;color: #fff;padding: 9px;">Cancel<!-- 	<input class="submitbtn btn btn-blue-alt" type="reset" value="Cancel"/> --></a>
												</div> 
											</div>
                                </form>
                            
                                </div>
                        </div>
                    </div>					
						
					</div>
					
				</div>
				
			</div>
		</div>
	@endforeach
	</div>



@endsection