@extends('newcustomerzone.layout')

@section('title')
VGN Projects Estates Pvt Ltd |Customer Zone| Inspection Snag Page
@endsection

@section('description')
    <meta name="description" content="">
@endsection

@section('keyword')  
@endsection


@section('style')
@include('newcustomerzone.styles.commoncss')
<script src="{{ config('app.AWS_URL')}}/newcustomerzoneassets/dist/js/defines.js"></script>
<style>
	.carousel-inner>.item>img
	{
		min-height: 280px;
	}
    #changedetailsForm label.col-sm-2 {
        font-weight: normal;
    }
</style>

@endsection

@section('bodycontent')
<body class="hold-transition skin-red fixed sidebar-mini">

<!-- Site wrapper -->
<div class="wrapper">

@foreach($getcustomerdata as $customer)


 
  @include('newcustomerzone.header.index')
  @include('newcustomerzone.aside.index')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
   
    <!-- Main content -->
    <section class="content">
	
	<div class="row">
		<div class="col-md-10 col-md-offset-1">

	@include('newcustomerzone.contenttop')


      	</div>
	</div>



	<div class="row">
		
    <div class="col-md-10 col-md-offset-1">
      
      <div class="box box-danger">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-plus margin-r-5"></i> Create Snag </h3><span class="pull-right" ><a href="{{ url('/customerzone/inspectionsnag') }}" class="btn btn-danger btn-xs"><i class="fa fa-back margin-r-5"></i>Back</a></span>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              
               <div class="col-sm-6 col-sm-offset-3">
				 @if(session()->has('error_msg'))
				        <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                {{Session::get('error_msg')}}
              </div>
				        <br>
				 @endif
                 @if(session()->has('suc_msg'))
				        
				        <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-check"></i> Alert!</h4>
                {{Session::get('suc_msg')}}
              </div>
				        <br>
				 @endif
              </div>
               
   @if(count($projects) > 0)

   <?php $valid = 0;

?>
    @foreach($projects as $pro)
		
        @if(($pro->milestone == 'X')&&($pro->posession == null)&&($pro->snagcreatedbyuser == null))
        <?php $valid += 1; ?>
        @endif
    @endforeach

@if($valid == 0)
    <script>alert("Not Valid to create Snag!");
    window.location.href="/customerzone/dashboard";
    </script>
    
@endif




@endif            
                
              @if(count($projects) > 0)
@if($valid != 0)  
                <form id="myForm" method="POST" action="{{ url('/customerzone/createsnag') }}" class="form-horizontal" onsubmit="return validate(this);" >
                {{ csrf_field() }}
                   <div class="row" style="margin-left:3px;">
                       <div class="col-md-12">
                                                      
                             
                                <div class="form-group">
												<label for="projectid" class="col-sm-2 ">Project Name</label>
												<div class="col-sm-4">
													<select class="form-control userdropdown" name="projectid" id="Projects" required>
  <option value="">Select*</option> 
</select>
													{!! $errors->first('projectid', '<span class="errortext text-red">:message</span>') !!}
												</div>
											</div>
											<div class="form-group">
												<label for="unitno" class="col-sm-2 ">Unit No</label>
												<div class="col-sm-4">
													<select class="form-control userdropdown" name="unitno" id="Units" required>
  		<option value="">Select*</option>
</select>
													{!! $errors->first('unitno', '<span class="errortext text-red">:message</span>') !!}
												</div>
											</div>
											<div class="form-group">
												<label for="inputPassword3" class="col-sm-2">Description of Snag</label>
												<div class="col-sm-9">
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
											</div>
																				
											
											
											<br/><br/>
											<div class="form-group">
												<div class="col-sm-7"> 
													<input class="submitbtn btn btn-danger" type="submit" value="Submit" id="submit" />
													<a href="{{ url('/customerzone/inspectionsnag') }}" class="btn btn-warning">Cancel</a>
												</div> 
											</div>
                                 
                                     
                                             
                       </div>
                   </div>
                            
                                
                </form>
              @endif
					 @else
					 <script>
					 		alert("Not Valid to create Snag!");
    						window.location.href="/customerzone/dashboard";
					 </script>
					 @endif 

              
            </div>
            <!-- /.box-body -->
          </div>

    </div>


		

		
	</div>
@endforeach
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  @include('newcustomerzone.footer')
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->



@endsection

@section('script')
@include('newcustomerzone.js.commonjs')


<script type="text/javascript">
											
				$(document).ready(function(){
                    
                        $('.sidebar-menu').tree();

													
    var max_fields      = 200; //maximum input boxes allowed
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




													var data= <?php echo json_encode($projects); ?>;
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
@endsection
