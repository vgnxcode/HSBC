@extends('customer-zone.layout')

@section('title')
VGN Property Developers |Customer Zone| Raise Complaint Page
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
    <script type="text/javascript" src="{{ asset('portal/assets/css-pop.js') }}"></script>
	<script type="text/javascript" src="{{ asset('portal/assets/defines.js') }}"></script>
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
									<span class="icon-separator"><i class="glyph-icon icon-linecons-cog"></i></span>
									<div class="header-wrapper">Raise Complaints</div>
								</h3>
								<div class="content-box-wrapper">
                                
                                <form id="myForm" method="POST" action="{{ url('/customerzone/raisecomplaints') }}" class="form-horizontal" >
								{{ csrf_field() }}
											<div class="col-sm-10 col-sm-offset-1">
									@if(session()->has('error_msg'))
											<err>{{Session::get('error_msg')}}</err>
									@endif
                                    @if(session()->has('suc_msg'))
											<suc>{{Session::get('suc_msg')}}</suc>
									@endif
                                    </div>
											<script type="text/javascript">
												$(document).ready(function(){
													var data=<?php echo json_encode($getproject);?>;
													var length=data.length;
													var result="<option value=''>Select*</option>";
													var distinct=[];
													for(i=0;i<length;i++)
													{
														if($.inArray(data[i]['project_id'],distinct)===-1){
															distinct.push(data[i]['project_id']);
															result=result+"<option value='"+data[i]['project_id']+"'>"+data[i]['pname']+"</option>";
															
														}
														
													}
													$("#Projects").html(result);
													$("#Projects").on('change',function(){
														
														var result1="<option value=''>Select*</option>";
														//var distinct1=[];
														for(i=0;i<length;i++)
														{
															
															if($('#Projects').val()==data[i]['project_id'])
															{
																//if($.inArray(data[i]['project_id'],distinct1)===-1){
																//distinct1.push(data[i]['project_id']);
																result1=result1+"<option value='"+data[i]['unit']+"'>"+data[i]['unit_nm']+"</option>";
																
																//}
															}
														}
														$("#Units").html(result1);
													});
													
													$('#desc').keydown(function () {
														var max = 900;
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
											<table class="tblalign">
												<tr >
													
													<td><label for="projname">Project Name</label></td>         
													<td><select class="form-control userdropdown" name="complaintproject" id="Projects">
														<option value="">Select*</option> 
													</select>
													</td>
												</tr>
												
												<tr >
													<td><label for="unitno">Unit No</label></td>
													<td>
														<select class="form-control userdropdown" name="complaintunit" id="Units" required>
															<option value="">Select</option>
														</select>	
													</td>
												</tr>
												<tr >
													<td><label for="natureofcomp">Nature of Complaint</label></td>
													<td>
														<select class="form-control userdropdown" name="complaintnature" id="nature-comp" required>
															<option value="">Select</option>
															
																@foreach($getnoc as $noc)
																
																<option value="{{ $noc->natureofcomplaint }}">{{ $noc->natureofcomplaint }}</option>
																@endforeach
															
														</select>	
													</td>
												</tr>	
												<tr >
													<td><label for="compdesc">Description of Complaint</label></td>
													<td><textarea id="desc" class="form-control" name="desccomp" rows="10" cols="100" required></textarea><div id="charNum"></div></td>
												</tr>
												
											</table><br/>
											<div class="form-group">
												<div class="col-sm-12"> 
													<input class="submitbtn btn btn-blue-alt" type="submit" value="Submit" />
													<a href="{{ url('/customerzone/complaints') }}" style="background-color:#65a6ff;color: #fff;padding: 9px;border-radius: 3px;">Cancel<!-- 	<input class="submitbtn btn btn-blue-alt" type="reset" value="Cancel"/> --></a>
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