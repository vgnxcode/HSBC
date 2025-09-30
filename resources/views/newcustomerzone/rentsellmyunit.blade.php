@extends('newcustomerzone.layout')

@section('title')
VGN Projects Estates |Customer Zone| Rent My Unit Page
@endsection

@section('description')
    <meta name="description" content="">
@endsection

@section('keyword')  
@endsection


@section('style')
@include('newcustomerzone.styles.commoncss')
<script src="{{ config('app.AWS_URL')}}/newcustomerzoneassets/dist/js/defines.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/rowreorder/1.2.3/css/rowReorder.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.0/css/responsive.dataTables.min.css">
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
                <h3 class="box-title"><i class="fa fa-exchange margin-r-5"></i> Rent My Unit </h3><span class="pull-right" ><a href="{{ url('/customerzone/occupantdetails') }}" class="btn btn-danger btn-xs"><i class="fa fa-backward"></i> Back</a></span>
                
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
		
        @if($pro->posession == 'X')
        <?php $valid +=  1; ?>
        @endif
    @endforeach

@if($valid == 0)
    <script>alert("Not Valid to create Occupants!");
    window.location.href="/customerzone/dashboard";
    </script>
    
@endif



@endif            
                
              @if(count($projects) > 0)
@if($valid != 0)  
                <form id="myForm" method="POST" action="{{ url('/customerzone/rentsellmyunit') }}" class="form-horizontal" onsubmit="return validate(this);" >
                {{ csrf_field() }}
                   <div class="row" style="margin-left:3px;">
                       <div class="col-md-12">


                        <div class="row" style="text-align:center;">
                       <div class="col-md-12" >
                        <h3 class="text-bold">I would like VGN to:</h3>

                           <div class="col-md-6 col-sm-12 grow"  style="text-align:center;">
                           <div class="checkbox">
                            <label style="font-weight: bold;">
                           <img src="/forrent.jpg" class="rent img-responsive" alt="renting" style=" height: 260px"><br>
                           <input type="checkbox" name="rent" value="1" id="rent"  class="p3"> Rent my unit.</label>
                            </div>

                           </div>

            
                       </div>
                   </div>
                                                      
                             <br>
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


                      
<div class="row">
                            <div class="col-md-8 col-md-offset-2">
                     <div class="alert text-justify" style="background-color: #fbc0c0;color: #020202;box-shadow: 4px 4px 8px #eee;">
         <h5 style="font-weight: normal;"><span style="line-height: 2.2em; font-weight: 600;">Dear {{ $getcustomerdata[0]->name }},</span></h5><p> We are delighted to inform that we have now introduced a new service where you can rent your home. We will ensure  a hassle free experience in finding you a prospective tenant apart from taking care of the complete documentation . Just let us know what you think by selecting the above checkbox and our facility management team will be in touch with you shortly !</p>
      </div>
<p class="pull-right text-bold">* Applicable only for possession taken units</p>
    </div>
                         </div>   
                    

                      

									
																				
											
											
											<br/><br/>
											<div class="form-group">
												<div class="col-sm-7"> 
													<input class="submitbtn btn btn-danger" type="submit" value="Submit" id="submit" />
													<a href="{{ url('/customerzone/dashboard') }}" class="btn btn-warning">Cancel</a>
												</div> 
											</div>
                                 
                                                                                    
                                             
                       </div>
                   </div>
                            
                                
                </form>
              @endif
					 @else
					 <script>

					 		alert("Not Valid to create Occupants!");
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

  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 2.4.0
    </div>
    <strong>Copyright &copy; 2020 <a href="http://www.vgn.in">VGN Projects Estates Pvt. Ltd</a>.</strong> All rights
    reserved.
  </footer>

  
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->



@endsection

@section('script')
@include('newcustomerzone.js.commonjs')
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js" ></script>
<script src="https://cdn.datatables.net/rowreorder/1.2.3/js/dataTables.rowReorder.min.js" ></script>
<script src="https://cdn.datatables.net/responsive/2.2.0/js/dataTables.responsive.min.js" ></script>

<script type="text/javascript">
											
				$(document).ready(function(){
                    
                        $('.sidebar-menu').tree();
                        var table = $('#example').DataTable( {
        rowReorder: false,
        responsive: true
    } );

                      
     $("#rent").on('click',function(){
            var rent = $("#rent").val();
            if (rent == 1) {

              var projj = $('#Projects').val();
                            var unitnoo = $('#Units').val();

                            if ((projj != '') && (unitnoo != '')) {
                            }else{
                              $('#rent').prop('checked', false);
                              $('#sell').prop('checked', false);
                              alert('Please select the Project Name and Unit No!');
                              return false;
                            }

            }
          });

          $("#sell").on('click',function(){
            var rent = $("#rent").val();
            if (rent == 1) {

              var projj = $('#Projects').val();
                            var unitnoo = $('#Units').val();

                            if ((projj != '') && (unitnoo != '')) {
                            }else{
                              $('#rent').prop('checked', false);
                              $('#sell').prop('checked', false);
                              alert('Please select the Project Name and Unit No!');
                              return false;
                            }

            }
          });
   




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
                                                                
                                                                if(data[i]['posession'] == 'X'){
                                                                    
																result1=result1+"<option value='"+data[i]['unit']+"'>"+data[i]['unit_nm']+"</option>";
                                                                }
																
															}
														}
														$("#Units").html(result1);
													});


                          $("#Units").on('change',function(){
                            var proj = $('#Projects').val();
                            var unitno = $('#Units').val();

                            if ((proj != '') && (unitno != '')) {
                              $.post("/checkrsu",{_token:'{{csrf_token()}}', plantid: proj, unitid: unitno},function(data){
                                if (data != 0) {
                                  var yy = JSON.parse(data);
                                  if(yy[0].rent == 'X'){
                                    $('#rent').prop('checked', true);
                                  }

                                  if(yy[0].sell == 'X'){
                                    $('#sell').prop('checked', true);
                                  }
                                  
                                }
                                
                              });
                            }

                          });
													
												
												
												
											
				});				
		    </script>
@endsection
