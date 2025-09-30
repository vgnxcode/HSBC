@extends('newcustomerzone.layout')

@section('title')
VGN Projects Estates Pvt Ltd |Vendor Zone| My Bank Details Page
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
</style>

@endsection

@section('bodycontent')
<body class="hold-transition skin-red fixed sidebar-mini">

<!-- Site wrapper -->
<div class="wrapper">

@foreach($getvendordata as $vendor)


 
  @include('newvendorzone.header.index')
  @include('newvendorzone.aside.index')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
   
    <!-- Main content -->
    <section class="content">
	
	<div class="row">
		<div class="col-md-10 col-md-offset-1">

	@include('newvendorzone.contenttop')


      	</div>
	</div>



	<div class="row">
		
    <div class="col-md-10 col-md-offset-1">
      
      <div class="box box-danger">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-bank margin-r-5"></i> My Bank Details </h3><span class="pull-right" ><a href="{{ url('/vendorzone/editbankdetails') }}" class="btn btn-danger btn-xs"><i class="fa fa-edit margin-r-5"></i>Edit</a></span>
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
              <div class="row">
                <div class="col-md-12">
              <h4 class="text-red"><i class="fa fa-info-circle margin-r-5"></i> Account Information</h4>

               <ul>
               <li> Bank Account No  - {{ $vendor->act_no }} </li>
               <li> Bank Name  - {{ $vendor->bank_name }} </li>
               <li> IFSC Code  - {{ $vendor->ifsc_code }} </li>
               <li> Branch Name  - {{ $vendor->branch_name }} </li>
              </ul>

              </div>
              </div>

              
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

  @include('newvendorzone.footer')
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->



@endsection

@section('script')
@include('newvendorzone.js.commonjs')
<script>
  $(document).ready(function () {
    $('.footer_bg ').hide();
    $('.sidebar-menu').tree();

@foreach($getvendordata as $vendor)
    $.each( countries, function( i, val ) {
          if(val['c_id']=="{{ $vendor->country }}")
          $('#ctry').html(val['c_nm']);
      });
  
          genArea();
                function genArea()
                    {
                        $.each( states, function( i, val ) {
                                if(val['s_id']=="{{ $vendor->region }}")
                                $('#stat').html(val['s_nm']);
                        });
                    };
          @endforeach

  });
</script>
@endsection
