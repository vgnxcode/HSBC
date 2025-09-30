@extends('customer-zone.layout')

@section('title')
VGN Property Developers |Customer Zone| Payment History Page
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
    <script type="text/javascript" src="{{ asset('portal/assets-minified/js-core/jquery-core.js') }}"></script>
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
			table tbody tr
			{
			text-align:center;
			}
			table
			{
			margin-top:20px;
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
									<span class="icon-separator"><i class="glyph-icon icon-list-ul"></i></span>
									<div class="header-wrapper">Payment History <span style="float:right;">Net Balance: {{ $customerdata->net_amt }}</span></div>
								</h3>
								<div class="content-box-wrapper">

                    <form>
											<table  cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="dynamic-table-example-1">
												<thead>
													<tr>
														<th>S.No</th>
														<th>Posting Date</th>
														<th>Document Number</th>
														<th align='right'>Invoice Amount</th>
														<th align='right'>Payment Amount</th>
													</tr>
												</thead>											  
												<tbody>
												@if(count($payment) > 0)
															<?php 
															$i = 0;
															$totalInv=(float)0.00;
															$totalPay=(float)0.00;
															$Payment=(float)0.00;
															?>
															@foreach($payment as $pay)
																<?php
																$Payment=number_format((float)$pay->inv_amt,2,'.','');
																
																if($pay->pay_type =="Invoice")//Payment_Amount
																$totalInv+=$Payment;
																if($pay->pay_type =="Payment")
																$totalPay+=$Payment;
																echo "<tr><td>".($i+1)."</td><td>".$pay->posteddate."</td><td>".$pay->doc_no."</td><td align='right'>";
																if($pay->pay_type =="Invoice")
																echo $Payment;
																echo "</td><td align='right'>";
																if($pay->pay_type =="Payment")
																echo $Payment;
																echo "</td></tr>";
																$i++;
																?>
															@endforeach
												@endif
												</tbody>
											</table>
											@if(count($payment) > 0)
											<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered">
												<thead>
													<tr >
														<th class="disappear">S.No</th>
														<th class="disappear">Posting Date</th>
														<th class="disappear">Document Number</th>
														<th align='right'>Invoice Amount</th>
														<th align='right'>Payment Amount</th>
													</tr>
												</thead>
												<tbody><tr ><td colspan="2" align="left"></td><td><hl><strong>Total:</strong></hl></td><td align='right'><hl><?php echo number_format((float)$totalInv,2,'.',''); ?></hl></td><td align='right'><hl><?php echo number_format((float)$totalPay,2,'.',''); ?></hl></td></tr>
													
												</tbody>
											</table>
											@endif
											<i>Disclaimer:</i> All payments are subject to realization.
											<br/><br/>
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