@extends('newcustomerzone.layout')

@section('title')
VGN Projects Estates Pvt Ltd |Customer Zone| Raise Complaint Page
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
                <h3 class="box-title"><i class="fa fa-microphone margin-r-5"></i> Raise Complaints </h3><span class="pull-right" ><a href="{{ url('/customerzone/complaints') }}" class="btn btn-danger btn-xs"><i class="fa fa-back margin-r-5"></i>Back</a></span>
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
               
               
                
                
                <form id="changedetailsForm" method="POST" action="{{ url('/customerzone/raisecomplaints') }}" class="form-horizontal" >
                {{ csrf_field() }}
                   <div class="row" style="margin-left:3px;">
                       <div class="col-md-12">
                                                      
                             
                                <div class="form-group">
												<label for="complaintproject" class="col-sm-2 ">Project Name</label>
												<div class="col-sm-4">
													<select class="form-control userdropdown" name="complaintproject" id="Projects">
														<option value="">Select*</option> 
													</select>
													{!! $errors->first('complaintproject', '<span class="errortext text-red">:message</span>') !!}
												</div>
											</div>
											<div class="form-group">
												<label for="inputPassword3" class="col-sm-2 ">Unit No</label>
												<div class="col-sm-4">
													<select class="form-control userdropdown" name="complaintunit" id="Units" required>
															<option value="">Select</option>
														</select>
													{!! $errors->first('complaintunit', '<span class="errortext text-red">:message</span>') !!}
												</div>
											</div>
											<div class="form-group">
												<label for="inputPassword3" class="col-sm-2">Nature of Complaint</label>
												<div class="col-sm-4">
													<select class="form-control userdropdown" name="complaintnature" id="nature-comp" required>
															<option value="">Select</option>
															
																@foreach($getnoc as $noc)
																
																<option value="{{ $noc->natureofcomplaint }}">{{ $noc->natureofcomplaint }}</option>
																@endforeach
															
														</select>
													{!! $errors->first('complaintnature', '<span class="errortext text-red">:message</span>') !!}
												</div>
											</div>
											<div class="form-group">
												<label for="inputPassword3" class="col-sm-2">Description of Complaint</label>
												
													<div class="col-sm-4">
														
													<textarea id="desc" class="form-control" name="desccomp" rows="10" cols="100" required></textarea><div id="charNum"></div>
													{!! $errors->first('desccomp', '<span class="errortext text-red">:message</span>') !!}
													</div>									
												
											</div>
											
											
											
											<br/><br/>
											<div class="form-group">
												<div class="col-sm-7"> 
													<input class="submitbtn btn btn-danger" type="submit" value="Submit" id="submit" />
													<a href="{{ url('/customerzone/complaints') }}" class="btn btn-warning">Cancel</a>
												</div> 
											</div>
                                 
                                     
                                             
                       </div>
                   </div>
                            
                                
                </form>
              

              
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
@endsection
