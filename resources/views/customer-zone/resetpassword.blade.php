@extends('customer-zone.layout')

@section('title')
VGN Property Developers |Customer Zone| Reset Password Page
@endsection

@section('description')
    <meta name="description" content="">
@endsection

@section('keyword')  
@endsection

@section('stylesheet')
	<link rel="stylesheet" href="{{ asset('assets/css/normalize.css') }}">
	<link rel="stylesheet" href="{{ asset('portal/assets-minified/icons/fontawesome/fontawesome.css') }}">
    <script src="{{ asset('portal/assets-minified/js-core.js') }}"></script>
    <script src="{{ asset('portal/loader.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('portal/assets-minified/helpers/helpers-all.css') }}">
	<link rel="stylesheet" href="{{ asset('portal/assets-minified/elements/elements-all.css') }}">
	
	<link rel="stylesheet" href="{{ asset('portal/assets-minified/themes/supina/layout.css') }}">
	<link id="framework-color" rel="stylesheet" href="{{ asset('portal/assets-minified/themes/supina/default/framework-color.css') }}">
	<link rel="stylesheet" href="{{ asset('portal/assets-minified/helpers/colors.css') }}">
	<link rel="stylesheet" href="{{ asset('portal/assets/style.css') }}">
    <style>
			   img.img-home
            {
			width: 80px;
			height: 100%;
			padding-top: 20px;
			padding-left: 20px;
    
			}
			#loading {position: fixed;width: 100%;height: 100%;left: 0;top: 0;right: 0;bottom: 0;display: block;background: #fff;z-index: 10000;}
			#loading img {position: absolute;top: 50%;left: 50%;margin: -23px 0 0 -23px;}
			td {padding: 13px 40px;}
			.submitbtn {margin-left:32%;}
			.btn{border-radius:0px !important;}	
			.content-box-header-alt{padding:28px 10px 14px !important;}
			body{background: url(/portal/assets/pattern.jpg) repeat;}
			.content-box {
				background-color:rgba(255, 255, 255, 0.42) !important;
				box-shadow: 0px 0px 1px rgba(0, 0, 0, 0.43)  !important;;
				border: none;
			}
			#page-content, #page-content-wrapper {
				background: none !important; 
			}
			.btn-blue-alt:hover,.btn-info:hover{background: #386B98 !important;}
			#page-wrapper1{
				position: relative;
				padding-top: 50px;
				overflow: hidden;
			}
			#page-content1{
				padding: 17px;
			}
			.errortext
			{
				color: red;
			}
</style>
		<script type="text/javascript">
		/* function isNumberKey(evt)
          {
             var charCode = (evt.which) ? evt.which : event.keyCode
             if (charCode > 31 && (charCode < 48 || charCode > 57))
                return false;
 
             return true;
          } */
		</script> 
@endsection

@section('header')
    
@endsection

@section('content')
<div class="homebutton">
			    
                <a href="{{ url('/')}}">
                <img src="{{ url('portal/images/Home-icon.png') }}" alt="home-logo" class="img-home">
                </a>
			</div>
	<div class="bg"></div>
		
		<div id="loading">
			<img src="{{ url('portal/assets-minified/images/spinner/loader-dark.gif') }}" alt="Loading...">
		</div>
		<div id="sb-site">
			<div id="page-wrapper1">
				<div class="row">
					
					<div class="col-md-6 col-md-offset-3" align="center">
						<img src="{{ url('images/custom/vgn-logo.png') }}" align="center" >
					</div>
					
				</div>
				<div id="" class="rm-transition">
					<div id="page-content1">
						<div class="row">
						<div class="col-md-4"></div>
							
							<div class="col-md-4">
								<div class="content-box mrg25T mrg25B">
									
									<h3 class="content-box-header content-box-header-alt">	
									<!--<span class="icon-separator"><i class="glyph-icon icon-linecons-cog"></i></span>-->
									<div class="header-wrapper styles2">Reset Password</div>
								</h3>
									<div class="content-box-wrapper">
										
																				
																				<form id="myForm" method="POST" action="{{ url('/customerzone/resetpassword')}}/{{$customerid}}/{{$token}}" class="form-horizontal" >
																				{{ csrf_field() }}

																				<div class="col-sm-12">
									@if(session()->has('error_msg'))
											<err>{!! Session::get('error_msg') !!}</err>
									@endif
                                    @if(session()->has('suc_msg'))
											<suc>{!! Session::get('suc_msg') !!}</suc>
									@endif
                                    </div>
																				
																						<table class="" align="center">
												
												
												<div class="form-group">
										<label for="inputPassword2" class="col-sm-4 labelalign">New Password</label>
										<div class="col-sm-6">
											<input class="form-control" id="field_pwd1" title="Type Your New Password" type="password" name="newpass" placeholder="New Password">
                                            {!! $errors->first('newpass', '<span class="errortext">:message</span>') !!}
										</div>
									</div>
									<div class="form-group">
										<label for="inputPassword3" class="col-sm-4 labelalign">Re-type Password</label>
										<div class="col-sm-6">
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
												
											</table><br/>
											
											
											
										</form>
									</div>
								</div>
								
							</div>
							<div class="col-md-4"></div>
							
						</div>
					</div>
				</div>
			</div>
@endsection
