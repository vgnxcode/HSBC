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
    <script type="text/javascript" src="{{ asset('portal/assets-minified/widgets/datatable/datatable.js') }}"></script>
	<script type="text/javascript" src="{{ asset('portal/assets-minified/widgets/datatable/datatable-bootstrap.js') }}"></script>
	<script type="text/javascript" src="{{ asset('portal/assets-minified/widgets/datatable/datatable-bootstrap.js') }}"></script>
	<link rel="stylesheet" type="text/css" href="{{ asset('portal/assets-minified/widgets/datatable/datatable.css') }}">
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
    <script type="text/javascript" src="{{ asset('portal/assets/css-pop.js') }}"></script>
	<script type="text/javascript" src="{{ asset('portal/assets/defines.js') }}"></script>

    <script type="text/javascript">

		$(document).ready(function() {
		$('#responsive-open-menu').on('click',function(){$('#page-sidebar').toggle();});
			$('#dynamic-table-example-1').dataTable();
			
			/* Add sorting icons */
			
			$("table.dataTable .sorting").append('<i class="glyph-icon"></i>');
			$("table.dataTable .sorting_asc").append('<i class="glyph-icon"></i>');
			$("table.dataTable .sorting_desc").append('<i class="glyph-icon"></i>');
			
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
									<span class="icon-separator"><i class="glyph-icon icon-comment"></i></span>
									<div class="header-wrapper">Inspection Snag</div>
								</h3>
								<div class="content-box-wrapper">
					@if(count($snag) > 0)
								<script type="text/javascript">
												$(document).ready(function(){
													var data=<?php echo json_encode($snag);?>;
													
													var length=data.length;
													
													$(".more").on('click',function(){
														var result1="";
														//var distinct1=[];
														var ss = 1;
														for(i=0;i<length;i++)
														{
															
															if(($(this).attr('data-unit')==data[i]['unit_no'])&&$(this).attr('data-projectid')==data[i]['project_id'])
															{
																
																result1+= ss+". "+stripslashes(data[i]['snag_desc'])+" : VGN Status - "+data[i]['vgn_status']+"<br>";
																
																ss++;
															}
														}
														var newres = "<field>Complaint Description:</field><value>"+ result1+"</value>";
														$("#popUpcontent").html(newres);
													});
												
												});
												
											</script>
								@endif

								<div class="col-sm-6 col-sm-offset-3">
									@if(session()->has('error_msg'))
											<err>{{Session::get('error_msg')}}</err>
									@endif
                                    @if(session()->has('suc_msg'))
											<suc>{{Session::get('suc_msg')}}</suc>
									@endif
                                    </div>
									
									@if(count($projects) > 0)

									<?php 
									$valid = 0;
									$overallsnagperproject_created = 0;
									 ?>
									@foreach($projects as $pro)
										@if($pro->snagcreatedbyuser != null)
											<?php $overallsnagperproject_created +=  1; ?>
										@endif

										 @if(($pro->milestone == 'X')&&($pro->posession == null))
										<?php $valid +=  1; ?>
										@endif
									@endforeach

									@if($valid == 0)
										<script>swal("Alert", "Not a Valid to create Snag!", "warning");
										window.location.href="/customerzone/dashboard";
										</script>
										
									@endif

									@if($overallsnagperproject_created == 0)
									@if($customerdata->valid != 2)
									<a style="float:right;" class="raise-comp" href="{{ url('customerzone/createsnag') }}"><i class="glyph-icon icon-plus"></i> Create Snag</a>
									<br>
									<br>
									@endif
									@endif
											
									@else
									<script>swal("Alert", "Not a Valid to create Snag!", "warning");
										window.location.href="/customerzone/dashboard";
										</script>

								@endif
									
    <table class="table table-striped table-bordered" style="margin-top:4%;" id="dynamic-table-example-1">
												<thead>
													<tr>
														
														<th>Project Name</th>
														<th>Flat Number</th>
														<th>Snag Description</th>
														<th>Overall Completion Status</th>
														<th>Snag Created Date</th>
														<th>Update Snag</th>
                                                        <th>Expected Date of Completion</th>
														
													</tr>
												</thead>											  
												<tbody>
												@if((count($projects) > 0)&&(count($snag) > 0))
													@foreach($projects as $proj)
														@if($proj->snagcreatedbyuser != null)
															<tr>
															<td>{{$proj->pname}}</td>
															<td>{{$proj->unit_nm}}</td>
															<td align='center'><a href="#" class="more" data-projectid='{{$proj->project_id}}' data-unit="{{$proj->unit}}" onclick=popup('popUpDiv') >Click to View</a></td>
															<td>
															<?php
															$overall = 0;
															foreach ($snag as $value) {
																if (($value->project_id == $proj->project_id)&&($value->unit_no == $proj->unit)) {
																		if ($value->vgn_status == 'OPEN') {
																			$overall += 1;	
																		}
																	}
																
															}

															if ($overall == 0) {
																echo 'CLOSED';
															}
															if ($overall > 0) {
																echo 'OPEN';
															}
															?>
															
															</td>
															<td>
															
															<?php
																foreach ($snag as $value1) {
																if (($value1->project_id == $proj->project_id)&&($value1->unit_no == $proj->unit)) {
																		echo $value1->snag_created_date;
																	}
																	break;																
																}
															?>
															
															</td>
															<td align='center'>
															<?php
																foreach ($snag as $value2) {
																if (($value2->project_id == $proj->project_id)&&($value2->unit_no == $proj->unit)) {
																	

																	$date=date_create($value2->snag_created_date);
																	date_add($date,date_interval_create_from_date_string("1 days"));
																	$converteddate = date_format($date,"Y-m-d H:i:s");

																	$todaydatetime = date('Y-m-d H:i:s');

																	

																	if ($todaydatetime > $converteddate) {
																		echo '-';
																	}
																	else
																	{
																		?>
																		<a href="{{ url('/customerzone/updatesnag')}}/{{$proj->project_id}}/{{$proj->unit}}">Update Snag</a>
																		<?php
																	}

																	
															
																	}
																	break;																
																}
															?>
															</td>
															@if($snag[0]->Expecteddateofcomp != null)
															<td>{{$snag[0]->Expecteddateofcomp}}</td>
															@else
															<td>-</td>
															@endif
															
															
															</tr>
														@endif
													@endforeach
												@endif

                                                </tbody>
                                    </table>
									<div id="blanket" style="display:none"></div>
													<div id="popUpDiv" style="display:none">
														<a href="#" class="closepopup" onclick="popup('popUpDiv')" >X</a>
														<div id="popUpcontent">
														</div>
													</div>
						<br/><br/>
											<div class="well">
											<h5 style="text-decoration: underline;"><b>Note:</b></h5>
												<ul>
													<li>Snag points created can be edited within 24 hours from the date of snag created for the flat.</li>
												</ul>
											</div>
                        
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