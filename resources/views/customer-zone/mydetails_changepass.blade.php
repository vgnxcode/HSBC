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
            .errortext
			{
				color: red;
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
									<span class="icon-separator"><i class="glyph-icon icon-edit"></i></span>
									<div class="header-wrapper">Change Password</div>
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
								<form id="myForm" method="POST" action="{{ url('/customerzone/mydetails_changepassword') }}" class="form-horizontal" style="margin-left:8% !important;margin-top:4%;text-align:none !important;">
                                {{ csrf_field() }}
                                
									<div class="form-group">
										<label for="inputPassword1" class="col-sm-4 labelalign">Old Password</label>
										<div class="col-sm-4">
											<input class="form-control" id="field_username" title="Old Password must not be blank" type="password" name="oldpasword" placeholder="Old Password">
                                            {!! $errors->first('oldpasword', '<span class="errortext">:message</span>') !!}
										</div>
									</div>
									<div class="form-group">
										<label for="inputPassword2" class="col-sm-4 labelalign">New Password</label>
										<div class="col-sm-4">
											<input class="form-control" id="field_pwd1" title="Type Your New Password" type="password" name="newpass" placeholder="New Password">
                                            {!! $errors->first('newpass', '<span class="errortext">:message</span>') !!}
										</div>
									</div>
									<div class="form-group">
										<label for="inputPassword3" class="col-sm-4 labelalign">Re-type Password</label>
										<div class="col-sm-4">
											<input class="form-control" id="field_pwd2" title="Please enter the same Password as above." type="password" name="retypepass" placeholder="Re-type New Password">
                                            {!! $errors->first('retypepass', '<span class="errortext">:message</span>') !!}
										</div>
									</div>
									<div class="form-group" style="margin-left:25%;">
										<div class="col-sm-12">
												<div class="col-sm-3">
												
												<input class="submitbtn btn btn-blue-alt" id="submit" type="submit" value="Update"/>
												</div>								
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