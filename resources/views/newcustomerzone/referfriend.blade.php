@extends('newcustomerzone.layout')

@section('title')
VGN Projects Estates Pvt Ltd |Customer Zone| Refer Friend Page
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
    .redbg{
    	background-color: #e81b24;
    	padding: 5px;
    	color: #ffffff;
    	text-align: center;
    	text-transform: uppercase;
    	border-radius: 6px;
    	box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
    }
    .yellowbg{
    	background-color: #ffd400;
    	color: #000;
    	padding: 16px;
    	text-transform: initial;
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
                <h3 class="box-title"><i class="fa fa-group margin-r-5"></i> My Referrals </h3>
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
               
               
                
                
                <form id="myForm" method="POST" action="{{ url('/customerzone/referfriend') }}" class="form-horizontal" >
                {{ csrf_field() }}

                <div class="row" style="text-align: center;">

                	<div class="col-md-10 col-md-offset-1">
                	<h1 style="color: #e81b24;text-transform: uppercase; font-weight: bold;">Family & Friends <span style="color: #000;">Rewards.</span></h1>
					
					<div class="row">
					<div class="redbg col-md-4 col-md-offset-4">
						<h4>Refer your friends and family to book flat/plot in VGN</h4>
						<h3 class="yellowbg">Get upto &#8377; 100* per Sq.FT.</h3>
					</div>
					
					</div>
						
					</div>

					</div>
					<br>
					<br>
                   <div class="row" >
                       <div class="col-md-10 col-md-offset-1">
                                                      
                             
                                <div class="form-group">
												<label for="name" class="col-sm-2 ">Name of the Prospect</label>
												<div class="col-sm-4">
													<input type="text" class="form-control" id="unit-no" placeholder="Name of the Prospect" name='name' required>
													{!! $errors->first('name', '<span class="errortext text-red">:message</span>') !!}
												</div>
											</div>
											<div class="form-group">
												<label for="mobile" class="col-sm-2 ">Mobile No</label>
												<div class="col-sm-4">
													<input type="text" class="form-control" id="nature-comp" placeholder="Mobile No" name='mobile'  required maxlength='10'>
													{!! $errors->first('mobile', '<span class="errortext text-red">:message</span>') !!}
												</div>
											</div>
											<div class="form-group">
												<label for="inputPassword3" class="col-sm-2">Email ID</label>
												<div class="col-sm-4">
													<input type="text" class="form-control" id="nature-comp" placeholder="Email ID" name='email' required>
													{!! $errors->first('email', '<span class="errortext text-red">:message</span>') !!}
												</div>
											</div>
											<div class="form-group">
												<label for="inputPassword3" class="col-sm-2">Interested Project</label>
												
													<div class="col-sm-4">
														
													<select class="form-control userdropdown" name='intr' required>
												  <option value="">Select</option>   
												  @foreach($ongoingprojects as $k=>$ongoing)
                                                  <option value="{{$ongoing['Project_No']}}">{{$ongoing['Project_Name']}}</option>
                                                  @endforeach
												</select>
													{!! $errors->first('intr', '<span class="errortext text-red">:message</span>') !!}
													</div>									
												
											</div>
											
											
											
											<br/><br/>
											<div class="form-group">
												<div class="col-sm-7"> 
													<input class="submitbtn btn btn-danger" type="submit" value="Refer" id="submit" />
													<a href="{{ url('/customerzone/dashboard') }}" class="btn btn-warning">Cancel</a>
												</div> 
											</div>
                                 
                                     

                                             
                       </div>
                   </div>
                            
                                
                </form>
              

              <br>
              <br>
              								<blockquote>
               
											<h4 style="text-decoration: underline;"><b>Note:</b></h4>
												<ol>
													<li>Terms & Conditions apply: Referral amount will vary project to project.</li>
													<li>Existing Customer has to submit his referral online only.</li>
													<li>Referral by way of e-mail or letter are not acceptable and invalid.</li>
													<li>Refferal amount will be adjusted against your final payment.</li>
												</ol>
											</blockquote>

              
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
				});				
		    </script>
@endsection
