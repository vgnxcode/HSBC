@extends('newcustomerzone.layout')

@section('title')
VGN Property Developers |Customer Zone| Show Occupants Details Update Page
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
                <h3 class="box-title"><i class="fa fa-users margin-r-5"></i> Owner/Tenant Details </h3><span class="pull-right" ><a href="{{ url('/customerzone/occupantdetails') }}" class="btn btn-danger btn-xs"><i class="fa fa-backward margin-r-5"></i> Back</a></span>
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
               
                              @if(count($occupantdetails) > 0)
                              @foreach($occupantdetails as $occup)
                              <blockquote>
                                <p>Project Name - {{$occup->projectname}}</p>
                                <p>Unit Name - {{$occup->unitname}}</p>
                                <p>Occupant Type - {{$occup->typename}}</p>
                                <p>No. of Occupants - {{$occup->occupantcount}}</p>
                                <h4 style="text-decoration: underline; font-weight: bold;">Occupant Details</h4>
                                <ol>
                                @foreach(json_decode($occup->occupantdata) as $occ)
                                <li>@if ($occ->name != '') <p>Name: {{$occ->name}}</p> @endif
                              @if ($occ->mobile != '') <p>Mobile: {{$occ->mobile}}</p> @endif
                              @if ($occ->email != '') <p>Email: {{$occ->email}}</p> @endif</li>
                              <br>
                                @endforeach
                                </ol>

                              </blockquote>
                              @endforeach                        
                              @endif

										
																				
											
											
											<br/><br/>
											
                                 
                             
              <div class="row" style="margin-left:3px;">
                       <div class="col-md-12">
                           
                            
                
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
    <strong>Copyright &copy; 2019 <a href="http://www.vgn.in">VGN Projects Estates Pvt. Ltd</a>.</strong> All rights
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

<script type="text/javascript">
											
				$(document).ready(function(){
                    
                        $('.sidebar-menu').tree();
                        
												
											
				});				
		    </script>
@endsection
