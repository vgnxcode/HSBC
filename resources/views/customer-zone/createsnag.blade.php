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
									<div class="header-wrapper">Create Snag</div>
								</h3>
								<div class="content-box-wrapper">

@if(count($projects) > 0)

<?php $valid = 0;
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
    <script>swal("Alert", "Not Valid to create Snag!", "warning");
    window.location.href="/customerzone/dashboard";
    </script>
    
@endif

@if($overallsnagperproject_created != 0)
    <script>swal("Alert", "Your snag creation is completed!", "warning");
    window.location.href="/customerzone/inspectionsnag";
    </script>
    
@endif


@endif

@if(count($projects) > 0)
@if($valid != 0)

                                 <form id="myForm" method="POST" action="{{ url('/customerzone/createsnag') }}" class="form-horizontal" onsubmit="return validate(this);" >
											{{ csrf_field() }}
											<script type="text/javascript">
												$(document).ready(function(){


													
    var max_fields      = 50; //maximum input boxes allowed
    var wrapper         = $(".input_fields_wrap"); //Fields wrapper
    var add_button      = $(".add_field_button"); //Add button ID
    
    var x = 5; //initlal text box count
    $(add_button).click(function(e){ //on add input button click
        e.preventDefault();
        if(x < max_fields){ //max input box allowed
            x++; //text box increment #<a href="#" class="remove_field pull-right">Remove</a>
            $(wrapper).append('<div><div class="input-group"><div class="input-group-addon">'+x+'.</div><input type="text" name="snag[desc-snag][]" class="form-control" placeholder="Description" maxlength="255" /></div></div>'); //add input box
        }
    });
    
    $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('div').remove(); x--;
    })




													var data= <?php echo json_encode($projects);?>;
													console.log(data);
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
																console.log(data[i]['project_id']);
                                                                
                                                                if((data[i]['milestone'] == 'X')&&(data[i]['posession'] == '')&&(data[i]['snagcreatedbyuser'] == null)){
                                                                    
																result1=result1+"<option value='"+data[i]['unit']+"'>"+data[i]['unit_nm']+"</option>";
                                                                }
																
															}
														}
														$("#Units").html(result1);
													});
													
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
											

  <div class="form-group">
    <label for="projname" class="col-sm-2 control-label">Project Name</label>
    <div class="col-sm-4">
      <select class="form-control userdropdown" name="projectid" id="Projects" required>
  <option value="">Select*</option> 
</select>
{!! $errors->first('projectid', '<span class="errortext">:message</span>') !!}
    </div>
  </div>
  <div class="form-group">
    <label for="unitno" class="col-sm-2 control-label">Unit No</label>
    <div class="col-sm-4">
      <select class="form-control userdropdown" name="unitno" id="Units" required>
  		<option value="">Select*</option>
</select>
{!! $errors->first('unitno', '<span class="errortext">:message</span>') !!}
    </div>
  </div>

  <div class="form-group">
    <label for="compdesc" class="col-sm-2 control-label">Description of Snag</label>
    <div class="col-sm-10">
      <div class="input_fields_wrap">
    <button class="add_field_button">Add More Snags</button>
    <div>
    <div class="input-group">
		<div class="input-group-addon">1.</div>
     <input type="text" class="form-control" name="snag[desc-snag][]" placeholder="Description" required maxlength="255">
     </div>
     </div>

     <div>
    <div class="input-group">
		<div class="input-group-addon">2.</div>
     <input type="text" class="form-control" name="snag[desc-snag][]" placeholder="Description" maxlength="255">
     </div>
     </div>

     <div>
    <div class="input-group">
		<div class="input-group-addon">3.</div>
     <input type="text" class="form-control" name="snag[desc-snag][]" placeholder="Description" maxlength="255">
     </div>
     </div>

     <div>
    <div class="input-group">
		<div class="input-group-addon">4.</div>
     <input type="text" class="form-control" name="snag[desc-snag][]" placeholder="Description" maxlength="255">
     </div>
     </div>

     <div>
    <div class="input-group">
		<div class="input-group-addon">5.</div>
     <input type="text" class="form-control" name="snag[desc-snag][]" placeholder="Description" maxlength="255">
     </div>
     </div>
    
</div>
    </div>
  </div>
  
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-blue-alt">Submit</button> <a href="{{ url('/customerzone/inspectionsnag') }}" style="background-color:#65a6ff;color: #fff;padding: 9px;border-radius: 3px;">Cancel<!-- 	<input class="submitbtn btn btn-blue-alt" type="reset" value="Cancel"/> --></a>
    </div>
  </div>

											
											
										</form>  
						
                     @endif
					 @else
					 <script>
					 		swal("Alert", "Not Valid to create Snag!", "warning");
    						window.location.href="/customerzone/dashboard";
					 </script>
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