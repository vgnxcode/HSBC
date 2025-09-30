@extends('newcustomerzone.layout')

@section('title')
VGN Projects Estates Pvt Ltd |Employee Zone| MyDetails Page
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
                <h3 class="box-title"><i class="fa fa-user margin-r-5"></i> My Details </h3><span class="pull-right" ><a href="{{ url('/employeezone/mydetails_changepassword') }}" class="btn btn-danger btn-xs"><i class="fa fa-edit margin-r-5"></i>Change Password</a></span><span class="pull-right" style="padding-right:3px;"><a href="{{ url('/employeezone/changemydetails') }}" class="btn btn-danger btn-xs"><i class="fa fa-edit margin-r-5"></i>Edit</a></span>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              
              <strong><i class="fa fa-user margin-r-5"></i> Personal Details</strong>

               <ul>
               <li> Title  - {{ $employee->title }}</li>
               <li> Name  - {{ $employee->name }}</li>
               <li> Gender  - {{ $employee->gender }}</li>
               <li> Birth Date  - {{ $employee->birthdate }}</li>
               <li> Marital Status - {{ $employee->maritalstatus }}</li>
               <li> Nationality  - {{ $employee->nationality }}</li>
               <li> Blood Group  - {{ $employee->bloodgroup }}</li>
              </ul>

              
                @if(count($getemployeeaddress) > 0)
                <hr>
            <div class="row">
              <strong class="col-md-12"><i class="fa fa-building margin-r-5"></i> Address & Contact Details</strong>
              </div>    
              <div class="row">
              @foreach($getemployeeaddress as $address)
              @if($address->address_type == 'T')
              <div class="col-md-6">
            <h5 class="text-bold" style="text-decoration:underline;">Temporary Address:</h5>
            <ul>
               <li> House No  - {{ $address->street_house_no }}</li>
               <li> Street Address  - {{ $address->street_house_no1 }}</li>
               <li> City / Postal Code  - {{ $address->city }} / {{ $address->postal_code }}</li>
                <li> Country  - <span class="ctry">{{ $address->country }}</span></li>
               
              </ul>
              </div>
              @endif
              @if($address->address_type == 'P')
              
              <div class="col-md-6">
            <h5 class="text-bold" style="text-decoration:underline;">Permanent Address:</h5>
            <ul>
               <li> House No  - {{ $address->street_house_no }}</li>
               <li> Street Address - {{ $address->street_house_no1 }}</li>
               <li> City / Postal Code  - {{ $address->city }} / {{ $address->postal_code }}</li>
                <li> Country  - <span class="ctry">{{ $address->country }}</span></li>
               
              </ul>
                </div>
              @endif
               @endforeach
                @endif
                </div>
                
                <hr>
                <strong><i class="fa fa-envelope margin-r-5"></i> Communication</strong>

               <ul>
               <li> Official Mail  - {{ $employee->officialmail }}</li>
               <li> Personal Mail  - {{ $employee->personalmail }}</li>
               <li> Personal Mobile  - {{ $employee->personal_mobile }}</li>
               
              </ul>
              
               <hr>
                <strong><i class="fa fa-bank margin-r-5"></i> PF / ESI Details</strong>
               <ul>
               <!-- <li> Bank Name  - {{ $employee->bank_name }}</li>
               <li> Bank Account No  - {{ $employee->bank_acnt_no }}</li> -->
               <li> PAN No  - {{ $employee->panno }}</li>
               <li> UAN No  - {{ $employee->pf_no }}</li>
               <li> ESI No  - {{ $employee->esi_no }}</li>
               
              </ul>
              
              <hr>
                <strong><i class="fa fa-clock-o margin-r-5"></i> Plant / Shift / Role Details</strong>

               <ul>
               <li> Company Name  - {{ $employee->company_name }}</li>
               <li> Plant Code  - {{ $employee->plantid }}</li>
               <li> Plant Name  - {{ $employee->plant_name }}</li>
               <li> Department  - {{ $employee->department }}</li>
               <li> Position  - {{ $employee->position }}</li>
               <li> Date of Joining  - {{ $employee->doj }}</li>
               <li> Shift Name  - {{ $employee->shift_name }}</li>
               <li> Shift Timing  - {{ substr($employee->shift_timings_in,0,2) }}:{{ substr($employee->shift_timings_in,2,2)}}&nbsp;<i class="fa fa-long-arrow-right margin-r-5"></i>{{ substr($employee->shift_timings_out,0,2) }}:{{ substr($employee->shift_timings_out,2,2)}}</li>
               <li> Role Code  - {{ $employee->role_code }}</li>
               <li> Role Name  - {{ $employee->role_name }}</li>
               
              </ul>
              
              <hr>
                <strong><i class="fa fa-graduation-cap margin-r-5"></i> Education</strong>

               <table class="table table-striped">
                  <thead class="box-primary">
                   <tr>
                       <th>Type of Graduation</th>
                       <th>Certificate</th>
                       <th>School / University</th>
                       <th>From Date</th>
                       <th>To Date</th>
                   </tr>
                   </thead>
                   <tbody>
                      @if(count($getemployeeeducation) > 0)
                      @foreach($getemployeeeducation as $education)
                       <tr>
                           <td>{{ $education->type_of_education }}</td>
                           <td>{{ $education->certificate }}</td>
                           <td>{{ $education->school_and_univercity }}</td>
                           <td>{{ $education->from_date }}</td>
                           <td>{{ $education->to_date }}</td>
                       </tr>
                       @endforeach
                       @endif
                   </tbody>
               </table>
               
               <hr>
                <strong><i class="fa fa-briefcase margin-r-5"></i> Previous Experience</strong>

               <table class="table table-striped">
                  <thead class="box-primary">
                   <tr>
                       <th>Name of Employer</th>
                       <th>From Date</th>
                       <th>To Date</th>
                       
                   </tr>
                   </thead>
                   <tbody>
                      @if(count($getemployeeexperience) > 0)
                      @foreach($getemployeeexperience as $experience)
                       <tr>
                           <td>{{ $experience->employer }}</td>
                           <td>{{ $experience->from_date }}</td>
                           <td>{{ $experience->to_date }}</td>
                       </tr>
                       @endforeach
                       @endif
                   </tbody>
               </table>
              
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
<script>
  $(document).ready(function () {
    $('.sidebar-menu').tree();

@foreach($getemployeeaddress as $address)
    $.each( countries, function( i, val ) {
          if(val['c_id']=="{{ $address->country }}")
          $('.ctry').html(val['c_nm']);
      });
  
          
          @endforeach

  });
</script>
@endsection
