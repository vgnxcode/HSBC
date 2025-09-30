@extends('newcustomerzone.layout')

@section('title')
VGN Projects Estates Pvt Ltd |Customer Zone| MyDetails Page
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
                <h3 class="box-title"><i class="fa fa-user margin-r-5"></i> My Details </h3><span class="pull-right" ><a href="{{ url('/customerzone/mydetails_changepassword') }}" class="btn btn-danger btn-xs"><i class="fa fa-edit margin-r-5"></i>Change Password</a></span>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              
              <strong><i class="fa fa-map-marker margin-r-5"></i> Location</strong>

               <ul>
               <li> House Number  - {{ $customer->houseno }}</li>
               <li> Street Address 1  - {{ $customer->street1 }}</li>
               <li> Street Address 2  - {{ $customer->street2 }}</li>
               <li> Street Address 3  - {{ $customer->street3 }}</li>
               <li> City / Postal Code  - {{ $customer->city }} / {{ $customer->pin }}</li>
               <li> Country  - <span id="ctry">{{ $customer->country }}</span></li>
               <li> Region  - <span id="stat">{{ $customer->region }}</span></li>
              </ul>

              <hr>

              <strong><i class="fa fa-envelope margin-r-5"></i> Communication</strong>

            <ul>
               <li> Telephone  - {{ $customer->tel }}</li>
               <li> Mobile Phone  - {{ $customer->mobile }}</li>
               <li> Fax  - {{ $customer->fax }}</li>
               <li> Email  - {{ $customer->email }}</li>
              </ul>

              
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
<script>
  $(document).ready(function () {
    $('.sidebar-menu').tree();

@foreach($getcustomerdata as $customer)
    $.each( countries, function( i, val ) {
          if(val['c_id']=="{{ $customer->country }}")
          $('#ctry').html(val['c_nm']);
      });
  
          genArea();
                function genArea()
                    {
                        $.each( states, function( i, val ) {
                                if(val['s_id']=="{{ $customer->region }}")
                                $('#stat').html(val['s_nm']);
                        });
                    };
          @endforeach

  });
</script>
@endsection
