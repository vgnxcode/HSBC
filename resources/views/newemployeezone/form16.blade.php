@extends('newvendorzone.layout')

@section('title')
VGN Projects Estates Pvt Ltd |Employee Zone| Employee Form-16
@endsection

@section('description')
    <meta name="description" content="">
@endsection

@section('keyword')  
@endsection


@section('style')
@include('newvendorzone.styles.commoncss')

<style>
	.carousel-inner>.item>img
	{
		min-height: 280px;
	}
    #changedetailsForm label.col-sm-2 {
        font-weight: normal;
    }
     .box-header.with-border {
    border-bottom: 1px solid #f4f4f4;
    background: #dd4b39;
    color: #fff;
}
    
    .titl h2 {
    font-size: 18px;
    text-align: center;
    font-weight: 400;
    margin-top: 0px;
        
    /*line-height: 1.5;*/
    /*color: #01427a;*/
}
    
    .invoice{
        border: 0px;
            border-top: 3px solid #dd4b39;
    }
    .fweight600{
        font-weight: 600;
    }
    .greycolor{
        background: #f9f9f9;
    }
    .table-bordered>tbody>tr>td{
            border: 1px solid #A9A9A9;
    }
    
</style>



@endsection

@section('bodycontent')
<body class="hold-transition skin-red fixed sidebar-mini">

<!-- Site wrapper -->
<div class="wrapper">

@foreach($getemployeedata as $employee)


 
  @include('newemployeezone.header.index')
  @include('newemployeezone.aside.index')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
   
    <!-- Main content -->
    <section class="content">
	
	<div class="row">
		<div class="col-md-10 col-md-offset-1">

	@include('newemployeezone.contenttop')


      	</div>
	</div>



	<div class="row">
		
    <div class="col-md-10 col-md-offset-1">
      
      <div class="box box-danger">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-download margin-r-5"></i> Form-16 </h3>
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
              
                
                
                <form class="form-horizontal" method="post" action="{{url('/employeezone/form16')}}" >
										{{csrf_field()}}
							   
                 <div class="row">
                   
                  
                  <div class="col-md-4 col-md-offset-4">
                  <h5 style="font-weight: bold;"><i class="fa fa-search"></i> Search for Form-16 File</h5>
                 <select class="form-control userdropdown" name="req_year" id="req_year" required>
                              
                           @foreach($optionkey as $optionkeys => $optionvalue)           
        <option value="{{$optionkeys}}" "@if(old('req_year') == $optionkeys) selected=selected @endif " >{{$optionvalue}}</option>
                                 @endforeach
                            </select>
                            <br>

                            <input type="submit" class="btn btn-danger" name="submit" value="Download" style="float: right;">
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

@include('newemployeezone.footer')
  
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->



@endsection

@section('script')
@include('newemployeezone.js.commonjs')


@endsection
