@extends('customer-zone.layout')

@section('title')
VGN Property Developers |Customer Zone| MyDetails Page
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
	<script type="text/javascript" src="{{ asset('portal/assets/defines.js') }}"></script>
	<script type="text/javascript" src="{{ asset('portal/assets-minified/demo-widgets.js') }}"></script>
    <style>
			  #loading {position: fixed;width: 100%;height: 100%;left: 0;top: 0;right: 0;bottom: 0;display: block;background: #fff;z-index: 10000;}
			#loading img {position: absolute;top: 50%;left: 50%;margin: -23px 0 0 -23px;}
			body{background: url(/portal/assets/pattern.jpg) repeat;}
			.submitbtn
			{
				margin-left:32%;
			}
</style>


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
									<span class="icon-separator"><i class="glyph-icon icon-user"></i></span>
									<div class="header-wrapper">My Details</div>
								</h3>
								<div class="content-box-wrapper">
                                
<script type="text/javascript">
									
	$(document).ready(function(){
	        $.each( countries, function( i, val ) {
					if(val['c_id']=="{{ $customerdata->country }}")
					$('#ctry').html(val['c_nm']);
			});
	
	        genArea();
                function genArea()
                    {
                        $.each( states, function( i, val ) {
                                if(val['s_id']=="{{ $customerdata->region }}")
                                $('#stat').html(val['s_nm']);
                        });
                    };
	});
												
</script>


<form class="form-horizontal" role="form" style="margin-left:8% !important;text-align:none !important;">
										<div class="col-sm-12">
												<a style="float:right;" class="raise-comp" href="{{ url('/customerzone/mydetails_changepassword') }}">Change Password</a>
											</div>
										<div class="form-group">
											<label for="inputEmail3" class="col-sm-2">Customer No:</label>
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
											<label for="inputPassword3" class="col-sm-2 ">Street Address 1</label>
											<div class="col-sm-4">
												<span>{{ $customerdata->street1 }}</span>
											</div>
										</div>
										<div class="form-group">
											<label for="inputPassword3" class="col-sm-2 ">Street Address 2</label>
											<div class="col-sm-4">
												<span>{{ $customerdata->street2 }}</span>
											</div>
										</div>
										<div class="form-group">
											<label for="inputPassword3" class="col-sm-2">Street Address 3</label>
											<div class="col-sm-4">
												<span>{{ $customerdata->street3 }}</span>
											</div>
										</div>
										<div class="form-group">
											<label for="inputPassword3" class="col-sm-2">House Number</label>
											<div class="col-sm-12">
												<div class="col-sm-4">
												
												<span>{{ $customerdata->houseno }}</span>
											</div>
										</div>
                                        </div>
										<div class="form-group">
											<label for="inputPassword3" class="col-sm-2">City / Postal Code</label>
											<div class="col-sm-12">
												<div class="col-sm-2">
												<span>{{ $customerdata->city }}</span>
												</div> 
											<div class="col-sm-2">
												<span>{{ $customerdata->pin }}</span>
												</div>	
											</div>
										</div>
										<div class="form-group">
											<label for="inputPassword3" class="col-sm-2">Country</label>
											<div class="col-sm-4">
												<span id="ctry">{{ $customerdata->country }}</span>
											</div>
										</div>
										<div class="form-group">
											<label for="inputPassword3" class="col-sm-2">Region</label>
											<div class="col-sm-4">
												<span id="stat">{{ $customerdata->region }}</span>
											</div>
										</div><br>
										<div class="form-group">
											<span class="bs-label label-info fieldlabel" style="margin-left:1%;">Communications:</span>
										</div>
										<div class="form-group">
											<label for="inputPassword3" class="col-sm-2">Telephone</label>
											<div class="col-sm-4">
											<span>{{ $customerdata->tel }}</span>
											</div>
										</div>
										<div class="form-group">
											<label for="inputPassword3" class="col-sm-2">Mobile Phone</label>
											<div class="col-sm-4">
												<span>{{ $customerdata->mobile }}</span>
											</div>
										</div>
										<div class="form-group">
											<label for="inputPassword3" class="col-sm-2">Fax</label>
											<div class="col-sm-4">
												<span>{{ $customerdata->fax }}</span>
											</div>
										</div>
										<div class="form-group">
											<label for="inputPassword3" class="col-sm-2">Email</label>
											<div class="col-sm-4">
												<span>{{ $customerdata->email }}</span>
											</div>
										</div>
																				<br><br>
										<div class="form-group" style="">
											<div class="col-sm-7">
												<a class="submitbtn btn raise-comp edit" href="{{ url('/customerzone/changemydetails') }}">Edit</a>
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