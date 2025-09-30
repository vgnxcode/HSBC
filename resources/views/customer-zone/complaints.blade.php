@extends('customer-zone.layout')

@section('title')
VGN Property Developers |Customer Zone| Complaint Page
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
	<script type="text/javascript">
			function close(id)
			{
				// document.getElementById('comp_id').value=id;
				document.complaintsform.comp_id.value=id;
				console.log(id);
				//document.complaintsform.submit();
			}
			$(document).ready(function(){
				$('.close').on('click',function(){
					$("#closevalue").val("#");
					crm=confirm('Are you sure want to close the Complaint?');
					if(crm)
					{
						var newval = $(this).attr('value');
						$("#closevalue").val(newval);
						$('#comp_id').val($(this).attr('value'));
						console.log($(this).attr('value'));
						document.closeform.submit();
					}
				});
			});
		</script>
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
									<div class="header-wrapper">Complaints</div>
								</h3>
								<div class="content-box-wrapper">
								
@if(count($getcomplaints) > 0)
								<script type="text/javascript">
												$(document).ready(function(){
													var data=<?php echo json_encode($getcomplaints);?>;
													var length=data.length;
													$(".more").on('click',function(){
														var result1="";
														//var distinct1=[];
														for(i=0;i<length;i++)
														{
															if($(this).attr('value')==data[i]['complaint_no'])
															{
																
																result1+="<field>Complaint Description:</field><value>"+stripslashes(data[i]['description'])+"</value>";
																
																
															}
														}
														$("#popUpcontent").html(result1);
													});
													$(".more1").on('click',function(){
														var result1="";
														
														for(i=0;i<length;i++)
														{
															if($(this).attr('value')==data[i]['complaint_no'])
															{
																
															if(data[i]['vgn_remarks'] == null)
															{
																result1+="<field>VGN Remarks:</field><value></value>";
															}
															else{
																result1+="<field>VGN Remarks:</field><value>"+stripslashes(data[i]['vgn_remarks'])+"</value>";
															}
																														
															}
														}

														console.log(result1);
														$("#popUpcontent1").html(result1);
													});
												});
												
											</script>
		@endif
		<form style="overflow:auto;" action="{{ url('/customerzone/complaints')}}" name="closeform" method="post">
		{{ csrf_field()}}
		<input type="hidden" name="close" value="#" id="closevalue">
		</form>
                                <form style="overflow:auto;" action="{{ url('/customerzone/complaints')}}" name="complaintsform" method="post">
								<div class="col-sm-10 col-sm-offset-1">
									@if(session()->has('error_msg'))
											<err>{{Session::get('error_msg')}}</err>
									@endif
                                    @if(session()->has('suc_msg'))
											<suc>{{Session::get('suc_msg')}}</suc>
									@endif
                                    </div>
								{{ csrf_field()}}
											@if($customerdata->valid != 2)
											<div class="col-sm-12">
												<a style="float:right;" class="raise-comp" href="{{ url('/customerzone/raisecomplaints') }}">Raise Complaints</a>
											</div>
											@endif
											<table class="table table-striped table-bordered" style="margin-top:4%;">
												<thead>
													<tr>
														<th>S. No.</th>
														<th>Complaint No.</th>
														<th>Project Name</th>
														<th>Unit No.</th>
														<th>Nature of Complaint.</th>
														<th>Complaint Description</th>
														<th>VGN Status</th>
														<th>Customer Status</th>
														<th>Final Status</th>
														<th>VGN Remarks</th>
														<th>Date</th>
														<th>Close</th>
														<th>Expected Date of Completion</th>
													</tr>
												</thead>											  
												<tbody>
													@if(count($getcomplaints) > 0)
													<?php $count = 1; ?>
													@foreach($getcomplaints as $complaint)
														<tr>
														<td>{{$count}}</td>
														<td>{{$complaint->complaint_no}}</td>
														<td>{{$complaint->project}}</td>
														<td>{{$complaint->unit}}</td>
														<td>{{$complaint->nature}}</td>
														<td align='center'><a href='#' class='more' value='{{$complaint->complaint_no}}' onclick=popup('popUpDiv') >Click to View</a></td>
														<td>{{$complaint->vgn_status}}</td>
														<td>{{$complaint->cust_status}}</td>
														<td>{{$complaint->final_status}}</td>
														<td align='center'><a href='#' class='more1' value='{{$complaint->complaint_no}}' onclick=popup('popUpDiv1')>Click to View</a></td>
														<td>{{$complaint->date}}</td>
														<td align="center">
														<button type="button" id="close0" class="close" value="{{$complaint->complaint_no}}"><input type="hidden" name="close" value="{{$complaint->complaint_no}}"><img src="{{ url('/wp-content/plugins/uji-popup/modal/css/close.png') }}" title="Close Complaint" alt="Close Complaint"></button>
														</td>
														@if($complaint->Expecteddateofcomp == null)
														<td>Will be Updated Soon</td>
														@else
														<td>{{$complaint->Expecteddateofcomp}}</td>
														@endif
														</tr>
														<?php $count++; ?>
													@endforeach
													@endif
													<div id="blanket" style="display:none"></div>
													<div id="popUpDiv" style="display:none">
														<a href="#" class="closepopup" onclick="popup('popUpDiv')" >X</a>
														<div id="popUpcontent">
														</div>
													</div>
													<div id="popUpDiv1" style="display:none">
														<a href="#" class="closepopup" onclick="popup('popUpDiv1')" >X</a>
														<div id="popUpcontent1">
														</div>
													</div>
												</tbody>
											</table>
											<br/><br/>
											@if($customerdata->valid != 2)
											<div class="col-sm-12">
												<a style="float:right;" class="raise-comp" href="{{ url('/customerzone/raisecomplaints') }}">Raise Complaints</a>
												<!-- <input class="submitbtn btn btn-blue-alt" type="submit" value="Raise Complaints"/> -->
											</div>
											@endif
											<input name="comp_id" type="hidden" id="comp_id" value=""/>
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