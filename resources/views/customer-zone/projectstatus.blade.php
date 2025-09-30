@extends('customer-zone.layout')

@section('title')
VGN Property Developers |Customer Zone| Project Status Page
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
    <style>
			#loading {position: fixed;width: 100%;height: 100%;left: 0;top: 0;right: 0;bottom: 0;display: block;background: #fff;z-index: 10000;}
			#loading img {position: absolute;top: 50%;left: 50%;margin: -23px 0 0 -23px;}
			body{background: url(/portal/assets/pattern.jpg) repeat;}
			td
			{
				padding: 13px 40px;
			}
			.col-md-row
			{
				width:93%
			}
			.submitbtn
			{
				margin-left:32%;
			}
			.clearbtn
			{
				margin-left:8%;
			}
			.tblalign
			{
				margin-left:2.7%;
			}
			.feedback
			{
				margin-bottom: 61px;
			}
			table tbody tr
			{
				text-align:center;
			}
			table
			{
				margin-top:20px;
			}
			.alert-info
			{
			  color: #444952 !important;

  				background: #FAFAFA !important;
			}

            .alert-info, .alert-info a {
                background: transparent !important;
            }
</style>

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
									<span class="icon-separator"><i class="glyph-icon icon-linecons-doc"></i></span>
									<div class="header-wrapper">Project Status</div>
								</h3>
								<div class="content-box-wrapper">

                                    @if(count($projects) > 0)
						<div class="alert alert-info"><h3 >Construction Photographs of Projects Booked in:</h3>
                        <br/>
                        @foreach($projects as $pro)
                            <?php $projname = str_replace('VGND','VGN',$pro->pname); ?>
							 @if(!empty($pro->projectlink))
							 Click the below link to view {{$projname}} construction pictures:<br/>
							 	<a href="{{$pro->projectlink}}">{{$pro->projectlink}}</a><br/><br/>
							 @endif
                        @endforeach
                        
                         </div><br>
                        @endif
						
						
					
						
                        
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