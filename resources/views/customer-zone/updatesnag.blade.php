@extends('customer-zone.layout')

@section('title')
VGN Property Developers |Customer Zone| Inspection Snag Page
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
			#popUpDiv1 {
    position: fixed;
    width: 500px;
    height: 400px;
    z-index: 9001;
    background-color: #fff;
    overflow: auto;
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
    <link rel="stylesheet" href="{{ asset('portal/assets/alert/sweetalert.css') }}">
	<script src="{{ asset('portal/assets/alert/sweetalert.min.js') }}"></script>

    

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
									<span class="icon-separator"><i class="glyph-icon icon-comment"></i></span>
									<div class="header-wrapper">Update Snag</div>
								</h3>
								<div class="content-box-wrapper">




                                 <form id="myForm" method="POST" action="{{ url('/customerzone/updatesnag') }}" class="form-horizontal" onsubmit="return validate(this);" >
											{{ csrf_field() }}
											<script type="text/javascript">
												$(document).ready(function(){
													
													$('#desc').keydown(function () {
														var max = 255;
														$(this).attr('maxlength',max);
														var len = $(this).val().length+($(this).val().match(/\n/g)||[]).length;
														if (len >= max) {
															$('#charNum').text(' You have reached the limit');
															} else {
															var char = max - len;
															$('#charNum').text(char + ' characters left');
														}
													});
													$('#desc').keydown();
												});
												
											</script>
											
@if(count($snag) > 0)
<?php $i = 1; ?>
  @foreach($snag as $snagdata)		

        @if ($snagdata->vgn_status == 'CLOSED') 
														
													
	<div class="form-group">
    <label for="compdesc" class="col-sm-2 control-label" style="width: 0px;"><?php echo $i; ?>: </label>
    <div class="col-sm-4">
			<p style="padding-top: 8px;">{{ $snagdata->snag_desc }}</p>
</div>
</div><br>
														
@else

<div class="form-group">
    <label for="compdesc" class="col-sm-2 control-label" style="width: 0px;"><?php echo $i; ?>: </label>
    <div class="col-sm-4">
		<input type="text" class="form-control" name="snag[desc-snag][{{$snagdata->uniqueno}}]" value="{{$snagdata->snag_desc}}" required>
		</div>
		</div><br>
@endif


<?php $i++; ?>
  @endforeach

  	<br/><br/>
											<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-blue-alt">Update</button> <a href="{{ url('/customerzone/inspectionsnag') }}" style="background-color:#65a6ff;color: #fff;padding: 9px;border-radius: 3px;">Cancel<!-- 	<input class="submitbtn btn btn-blue-alt" type="reset" value="Cancel"/> --></a>
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
                        </div>
                    </div>					
						
					</div>
					
				</div>
				
			</div>
		</div>
	@endforeach
	</div>



@endsection