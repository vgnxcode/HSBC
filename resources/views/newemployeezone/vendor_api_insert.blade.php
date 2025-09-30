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
  <div class="col-md-10">
  <div class="d-flex justify-content-between align-items-center">
    <h4 class="m-4">Add API Keys</h4>
    <a href="{{ url('/')}}/employeezone/list_api_key" class="btn btn-dark btn-sm">List Vendor Key</a>
    </div>

    <hr>    
    
  <!--Form Start-->
  @if ($errors->any())
  <div class="alert alert-danger">
    <ul class="mb-0">
      @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
@endif

@if (session('success'))
  <div class="alert alert-success">
    {{ session('success') }}
  </div>
@endif

<form action="{{ url('/employeezone/add_api_key') }}" method="post" autocomplete="off" name="add_form" id="add_form" novalidate>
    @csrf

    <div class="form-group row py-3">
        <label for="vendor_name" class="col-sm-2 col-form-label text-end">Vendor Name</label>
        <div class="col-sm-10">
            <input type="text" class="form-control @error('vendor_name') is-invalid @enderror" id="vendor_name" name="vendor_name" placeholder="Vendor Name" value="{{ old('vendor_name') }}">
            @error('vendor_name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="form-group row py-3">
        <label for="vendor_uname" class="col-sm-2 col-form-label text-end">Vendor User Name</label>
        <div class="col-sm-10">
            <input type="text" class="form-control @error('vendor_uname') is-invalid @enderror" id="vendor_uname" name="vendor_uname" placeholder="Vendor User Name" value="{{ old('vendor_uname') }}">
            @error('vendor_uname')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

     <div class="form-group row py-3">
        <label for="vendor_uname" class="col-sm-2 col-form-label text-end">Vendor User Password</label>
        <div class="col-sm-10">
            <input type="text" class="form-control @error('vendor_password') is-invalid @enderror" id="vendor_password" name="vendor_password" placeholder="Vendor Password" value="{{ old('vendor_password') }}">
            @error('vendor_password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>




    <div class="form-group row py-3">
        <label for="vendor_apikey" class="col-sm-2 col-form-label text-end">Vendor API Key</label>
        <div class="col-sm-10">
            <input type="text" class="form-control @error('vendor_apikey') is-invalid @enderror" id="vendor_apikey" name="vendor_apikey" placeholder="Vendor API Key" value="{{ old('vendor_apikey') }}">
            @error('vendor_apikey')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="form-group row">
        <div class="col-sm-12 d-flex justify-content-center">
            <input type="submit" id="submit" name="submit" value="Save" class="col-12 m-3 btn btn-sm btn btn-danger">
        </div>
    </div>
</form>



<!--Form End-->
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
