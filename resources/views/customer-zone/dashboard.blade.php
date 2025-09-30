@extends('customer-zone.layout')

@section('title')
VGN Property Developers |Customer Zone| Dashboard Page
@endsection

@section('description')
    <meta name="description" content="">
@endsection

@section('keyword')  
@endsection

@section('stylesheet')
	<link rel="stylesheet" href="{{ asset('assets/css/normalize.css') }}">
    <script src="{{ asset('portal/assets-minified/js-core.js') }}"></script>
    <script type="text/javascript" src=".{{ asset('portal/assets-minified/js-core/raphael.js') }}"></script>
	<script type="text/javascript" src="{{ asset('portal/assets-minified/widgets/charts/justgage/justgage.js') }}"></script>
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
	<link rel="stylesheet" type="text/css" href="{{ asset('portal/assets-minified/widgets/charts/justgage/justgage.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('portal/assets-minified/demo-widgets.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('portal/assets/jquery.bxslider.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('portal/assets/style.css') }}">
	<script type="text/javascript" src="{{ asset('portal/assets-minified/demo-widgets.js') }}"></script>
	<script type="text/javascript" src="{{ asset('portal/assets/jquery.bxslider.js') }}"></script>
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
		
		$(function () {	
			$("#slideshow > div:gt(0)").hide();
			
			setInterval(function() { 
				$('#slideshow > div:first')
				.fadeOut(1000)
				.next()
				.fadeIn(1000)
				.end()
				.appendTo('#slideshow');
			},  8000);
		}());
		$(document).ready(function(){
			$('.bxslider').bxSlider({auto: true,speed:1000,infiniteLoop:true,easing:'swing',speed:500,startSlide:0});
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
						
						<div class="col-md-6">
						
							<div class="content-box mrg25T mrg25B">
								<h3 class="content-box-header content-box-header-alt bg-white">	
									<span class="icon-separator"><i class="glyph-icon icon-linecons-tv"></i></span>
									<div class="header-wrapper">Dashboard</div>
									
								</h3>
								<div class="content-box-wrapper">
									<ul style="margin-left: 3%;">
										
										<li>You have changed your details on : <b style="font-size:15px;">{{ $customerdata->updated }}</b></li>
										<div class="divider divwidth"></div>
										<li>Total number of Complaints Raised : <b style="font-size:15px;">{{ $customerdata->comp_raised }}</b></li>
										<div class="divider divwidth"></div>
										<li>Total number of Complaints Closed : <b style="font-size:15px;">{{ $customerdata->comp_closed }}</b></li>
										<div class="divider divwidth"></div>
										<li>Total number of Complaints Pending : <b style="font-size:15px;">{{ $customerdata->comp_pending }}</b></li>
										<div class="divider divwidth"></div>
										<li>Number of times Password Changed : <b style="font-size:15px;">{{ $customerdata->pwd_count }}</b></li>
										<div class="divider divwidth"></div>
										<li>Last date for change of password : <b style="font-size:15px;">{{ $customerdata->pwd_updated }}</b></li>
										<div class="divider divwidth"></div>
										<li>Payment outstanding value : <b style="font-size:15px;">{{ $customerdata->net_amt }}</b></li>
										<div class="divider divwidth"></div>
										<li>Number of project booked in : <b style="font-size:15px;">{{ $customerdata->nou }}</b></li>
										
										
									</ul>
								</div>
							</div>
							
						</div>
						<div  class="col-md-6">
							
							<ul class="bxslider">
								<li><img src="{{ url('portal/images/coasta.jpg') }}" /></li>
								<li><img src="{{ url('wp-content/uploads/2015/05/coasta.jpg') }}" /></li>
								<li><img src="{{ url('wp-content/uploads/2015/05/imperia-ph4.JPG') }}" /></li>
							</ul>
							
						</div>
					</div>
					
				</div>
				
			</div>
		</div>
	@endforeach
	</div>



@endsection