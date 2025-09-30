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


    /* Extra styling to ensure full borders */
    table.table-bordered > thead > tr > th,
    table.table-bordered > tbody > tr > td {
        border: 1px solid #111 !important;
        vertical-align: middle;
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
    <h4 class="m-4">List API Keys</h4>
    <a href="{{ url('/')}}/employeezone/vendro_auth_key_insert" class="btn btn-dark btn-sm">Add Vendor Key</a>
    </div>

    <hr>    
    
<table class="table table-bordered">
    <thead>
        <tr style="background-color: #dd4b39; color: #fff;">
            <th>#</th>
            <th>Vendor Name</th>
            <th>Username</th>
            <th>Password</th>
            <th>API Key</th>
            <th>Edit</th>
        </tr>
    </thead>
    <tbody>
        @forelse($apiKeys as $key => $record)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $record->v_name }}</td>
                <td>{{ $record->v_username }}</td>
               <td>
    <span id="password_display_{{ $record->id }}">******</span>

    @if(in_array($employee->id, ['101397']))
    <button type="button" class="btn btn-sm btn-secondary" onclick="togglePassword({{ $record->id }}, '{{ $record->password }}')">
        👁️
    </button>
       @endif
</td>
                <td>{{ $record->v_apikey }}</td>
                <td>
                    <a href="{{ url('/employeezone/vendro_auth_key_insert/' . $record->id) }}" class="btn btn-danger btn-sm">Edit</a>
                </td>
            </tr>
        @empty
            <tr><td colspan="6" class="text-center">No records found.</td></tr>
        @endforelse
    </tbody>
</table>



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

<script>
    function togglePassword(id, actualPassword) {
        const el = document.getElementById('password_display_' + id);

        if (el.innerText === '******') {
            el.innerText = actualPassword;
        } else {
            el.innerText = '******';
        }
    }
</script>


@endsection
