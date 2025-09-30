@extends('newcustomerzone.layout')

@section('title')
VGN Projects Estates Pvt Ltd |Customer Zone| Registration Details Page
@endsection

@section('description')
    <meta name="description" content="">
@endsection

@section('keyword')  
@endsection


@section('style')
@include('newcustomerzone.styles.commoncss')
<link rel="stylesheet" href="{{ config('app.AWS_URL')}}/newcustomerzoneassets/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">

<style>
	
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
                <h3 class="box-title"><i class="fa fa-files-o margin-r-5"></i> Details For Registration & Agreements </h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              
               <div class="col-sm-10 col-sm-offset-1">

               @if(session()->has('error_msg'))
                <div class="row" id="error_box">
                    <div class="col-lg-8 col-lg-offset-2">

                    <div class="box box-danger box-solid">
                    <div class="box-header with-border">
              <h3 class="box-title">Error</h3>

              
              <!-- /.box-tools -->
            </div>
            <div class="box-body">
                <ol>
                @foreach(Session::get('error_msg') as $k => $v)
                <li>{{$v}}</li>
                @endforeach
                </ol>
          </div>
              </div>
              
                    </div>

                </div>
                @endif

                 @if(session()->has('suc_msg'))
                <div class="row" id="error_box">
                    <div class="col-lg-8 col-lg-offset-2">

                    <div class="box box-success box-solid">
                    <div class="box-header with-border">
              <h3 class="box-title">Success</h3>

              
              <!-- /.box-tools -->
            </div>
            <div class="box-body">
            <p>{{Session::get('suc_msg')}}</p>
            </div>
              </div>
              
                    </div>

                </div>
                @endif
                
              </div>
               
               
                
                
                <form id="changedetailsForm" method="POST" action="{{ url('/customerzone/registrationdetails') }}" class="form-horizontal" autocomplete="off" enctype= "multipart/form-data" >
                {{ csrf_field() }}
                   <div class="row" style="margin-left:3px;">

                       <div class="col-md-12">
                      
                       <div id="1stapplicantdiv">


                           <div class="form-group">
                        <label for="project" class="col-sm-2">Project Name*</label>
												<div class="col-sm-6">
													<select class="form-control userdropdown" name="project" id="Projects">
														<option value="">Select*</option> 
													</select>
													{!! $errors->first('project', '<span class="errortext text-red">:message</span>') !!}
												</div>
											</div>
											
											<div class="form-group">
												<label for="unit" class="col-sm-2">Unit No*</label>
												<div class="col-sm-6">
													<select class="form-control userdropdown" name="unit" id="Units">
															<option value="">Select</option>
														</select>
													{!! $errors->first('unit', '<span class="errortext text-red">:message</span>') !!}
												</div>
											</div>


                       <div class="form-group">
												<label for="applicant_1_name" class="col-sm-2">1st Applicant Name*</label>
												<div class="col-sm-6">
                          <input type="text" class="form-control" name="applicant_1_name" id="applicant_1_name" value="{{old('applicant_1_name')}}" placeholder="1st Applicant Name">
													{!! $errors->first('applicant_1_name', '<span class="errortext text-red">:message</span>') !!}
												</div>
											</div>

                                <div class="form-group">
                                <label for="name1title" class="col-sm-2 ">&nbsp;</label>
												<div class="col-sm-2">
													<select class="form-control userdropdown" name="name1title" id="name1title">
                          <option value="sof" @if(old('name1title') == 'sof') selected="selected" @endif >Son Of</option> 
                            <option value="wof" @if(old('name1title') == 'wof') selected="selected" @endif >Wife Of</option> 
                            <option value="dof" @if(old('name1title') == 'dof') selected="selected" @endif >Daughter Of</option> 
													</select>
													{!! $errors->first('name1title', '<span class="errortext text-red">:message</span>') !!}
												</div>

                        <div class="col-sm-4">
													<input type="text" name="title_1_name" class="form-control" id="title_1_name" value="{{old('title_1_name')}}" placeholder="Name*">
													{!! $errors->first('title_1_name', '<span class="errortext text-red">:message</span>') !!}
												</div>
											</div>
											<div class="form-group">
												<label for="applicant_1_age" class="col-sm-2 ">Age*</label>
												<div class="col-sm-2">
													<input type="text" class="form-control" name="applicant_1_age" id="applicant_1_age" value="{{old('applicant_1_age')}}" placeholder="Age">
													{!! $errors->first('applicant_1_age', '<span class="errortext text-red">:message</span>') !!}
												</div>
											</div>
											
											<div class="form-group">
												<label for="houseflatno" class="col-sm-2">Address For Registration*</label>
													<div class="col-sm-4">
                            <input type="text" name="houseflatno" class="form-control" value="{{old('houseflatno')}}" placeholder="House/Flat no.*" id="houseflatno">
                            {!! $errors->first('houseflatno', '<span class="errortext text-red">:message</span>') !!}
													</div>	
                          <div class="col-sm-4">
                            <input type="text" name="street_name_1" value="{{old('street_name_1')}}" class="form-control" placeholder="Street Name*" id="street_name_1">
                            {!! $errors->first('street_name_1', '<span class="errortext text-red">:message</span>') !!}
													</div>									
											</div>
                     
                      <div class="form-group">
												<label for="street_name_2" class="col-sm-2">&nbsp;</label>
													<div class="col-sm-4">
                            <input type="text" name="street_name_2" value="{{old('street_name_2')}}" class="form-control" placeholder="Area*" id="street_name_2">
                            {!! $errors->first('street_name_2', '<span class="errortext text-red">:message</span>') !!}
													</div>
                          <div class="col-sm-4">
                            <input type="text" name="pincode1" value="{{old('pincode1')}}" class="form-control" placeholder="Pincode*" id="pincode1">
                            {!! $errors->first('pincode1', '<span class="errortext text-red">:message</span>') !!}
													</div>										
											</div>
                      <div class="form-group">
												<label for="listBox" class="col-sm-2">&nbsp;</label>
													<div class="col-sm-4">
                          <select class="form-control" name="first_app_state" id="listBox1" onchange="selct_district(this.value, 'first_app_city')"></select>
                          {!! $errors->first('first_app_state', '<span class="errortext text-red">:message</span>') !!}
													</div>
                          <div class="col-sm-4">
                          <select class="form-control secondlist" name="first_app_city" id='first_app_city'>
                            <option value="">Select City</option>
                          </select>
                          {!! $errors->first('first_app_city', '<span class="errortext text-red">:message</span>') !!}
													</div>											
											</div>
                      

                      <div class="form-group">
												<label for="panno_1" class="col-sm-2">PAN Number*</label>
													<div class="col-sm-4">
                            <input type="text" name="panno_1" class="form-control" value="{{old('panno_1')}}" placeholder="PAN No." id="panno_1">
                            {!! $errors->first('panno_1', '<span class="errortext text-red">:message</span>') !!}
													</div>		
                          <div class="col-sm-4">
                            <input type="file" name="panfile_1" class="form-control" placeholder="Attach PAN Copy" id="panfile_1">
                            {!! $errors->first('panfile_1', '<span class="errortext text-red">:message</span>') !!}
                            <span id="file1download"></span>
													</div>									
											</div>

                      <div class="form-group">
												<label for="religion_1" class="col-sm-2">Religion*</label>
													<div class="col-sm-4">
                            <input type="text" name="religion_1" value="{{old('religion_1')}}" class="form-control" placeholder="Religion" id="religion_1">
                            {!! $errors->first('religion_1', '<span class="errortext text-red">:message</span>') !!}
													</div>			
											</div>


                      <div class="form-group">
												<label for="Emailid_1" class="col-sm-2">EmailId*</label>
													<div class="col-sm-4">
                            <input type="text" name="Emailid_1" value="{{old('Emailid_1')}}" class="form-control" placeholder="EmailId" id="Emailid_1">
                            {!! $errors->first('Emailid_1', '<span class="errortext text-red">:message</span>') !!}
													</div>			
											</div>

                      <div class="form-group">
												<label for="contactno_1" class="col-sm-2">Contact Number*</label>
													<div class="col-sm-4">
                            <input type="text" name="contactno_1" value="{{old('contactno_1')}}" class="form-control" placeholder="Contact Number" id="contactno_1">
                            {!! $errors->first('contactno_1', '<span class="errortext text-red">:message</span>') !!}
													</div>			
											</div>

                      <div class="form-group">
                          <label for="2ndapplicant" class="col-sm-2">&nbsp;</label>
                        
													<div class="col-sm-4">
                          <div class="checkbox">
                            <label>
                              <input type="checkbox" name="secondndapplicantchecked" id="secondndapplicantchecked"> 2nd Applicant (If Any)
                            </label>
                          </div>
													</div>
                      </div>

                          </div>
                          <div class="text-center" id="loader">
                          <img src="{{ config('app.AWS_URL')}}/images/regdetails/loadergif.gif" width="90" alt="loader">
                          </div>

                          <div id="2ndapplicantdiv">

                              <div class="form-group">
												<label for="applicant_2_name" class="col-sm-2">2nd Applicant Name</label>
												<div class="col-sm-6">
													<input type="text" class="form-control" placeholder="2nd Applicant Name" value="{{old('applicant_2_name')}}" name="applicant_2_name" id="applicant_2_name">
													{!! $errors->first('applicant_2_name', '<span class="errortext text-red">:message</span>') !!}
												</div>
											</div>

                      <div class="form-group">
                                <label for="name2title" class="col-sm-2 ">&nbsp;</label>
												<div class="col-sm-2">
													<select class="form-control userdropdown" name="name2title" id="name2title">
                            <option value="sof" @if(old('name2title') == 'sof') selected="selected" @endif >Son Of</option> 
                            <option value="wof" @if(old('name2title') == 'wof') selected="selected" @endif >Wife Of</option> 
                            <option value="dof" @if(old('name2title') == 'dof') selected="selected" @endif >Daughter Of</option> 
													</select>
													{!! $errors->first('name2title', '<span class="errortext text-red">:message</span>') !!}
												</div>

                        <div class="col-sm-4">
													<input type="text" name="title_2_name" placeholder="Name*" class="form-control" value="{{old('title_2_name')}}" id="title_2_name">
													{!! $errors->first('title_2_name', '<span class="errortext text-red">:message</span>') !!}
												</div>
											</div>
											<div class="form-group">
												<label for="applicant_2_age" class="col-sm-2 ">Age*</label>
												<div class="col-sm-2">
													<input type="text" class="form-control" placeholder="Age" name="applicant_2_age" value="{{old('applicant_2_age')}}" id="applicant_2_age">
													{!! $errors->first('applicant_2_age', '<span class="errortext text-red">:message</span>') !!}
												</div>
											</div>
											
											<div class="form-group">
												<label for="houseflatno2" class="col-sm-2">Address For Registration*</label>
													<div class="col-sm-4">
                            <input type="text" name="houseflatno2" class="form-control" placeholder="House/Flat no.*" value="{{old('houseflatno2')}}" id="houseflatno2">
                            {!! $errors->first('houseflatno2', '<span class="errortext text-red">:message</span>') !!}
													</div>	
                          <div class="col-sm-4">
                            <input type="text" name="sec_street_name_1" class="form-control" placeholder="Street Name*" value="{{old('sec_street_name_1')}}" id="sec_street_name_1">
                            {!! $errors->first('sec_street_name_1', '<span class="errortext text-red">:message</span>') !!}
													</div>									
											</div>
                     
                      <div class="form-group">
												<label for="street_name_2" class="col-sm-2">&nbsp;</label>
													<div class="col-sm-4">
                            <input type="text" name="sec_street_name_2" class="form-control" placeholder="Area*" value="{{old('sec_street_name_2')}}" id="sec_street_name_2">
                            {!! $errors->first('sec_street_name_2', '<span class="errortext text-red">:message</span>') !!}
													</div>
                          <div class="col-sm-4">
                            <input type="text" name="sec_pincode2" class="form-control" placeholder="Pincode*" value="{{old('sec_pincode2')}}" id="sec_pincode2">
                            {!! $errors->first('sec_pincode2', '<span class="errortext text-red">:message</span>') !!}
													</div>										
											</div>
                      <div class="form-group">
												<label for="listBox" class="col-sm-2">&nbsp;</label>
													<div class="col-sm-4">
                          <select class="form-control" name="second_app_state" id="listBox2" onchange="selct_district(this.value, 'second_app_city')"></select>
                          {!! $errors->first('second_app_state', '<span class="errortext text-red">:message</span>') !!}
													</div>
                          <div class="col-sm-4">
                          <select class="form-control secondlist" name="second_app_city" id='second_app_city'>
                            <option value="">Select City</option>
                          </select>
                          {!! $errors->first('second_app_city', '<span class="errortext text-red">:message</span>') !!}
													</div>											
											</div>
                      

                      <div class="form-group">
												<label for="panno_1" class="col-sm-2">PAN Number*</label>
													<div class="col-sm-4">
                            <input type="text" name="panno_2" class="form-control" placeholder="PAN No." value="{{old('panno_2')}}" id="panno_2">
                            {!! $errors->first('panno_2', '<span class="errortext text-red">:message</span>') !!}
													</div>		
                          <div class="col-sm-4">
                            <input type="file" name="panfile_2" class="form-control" placeholder="Attach PAN Copy" id="panfile_2">
                            {!! $errors->first('panfile_2', '<span class="errortext text-red">:message</span>') !!}
                            <span id="file2download"></span>
													</div>									
											</div>

                      <div class="form-group">
												<label for="religion_2" class="col-sm-2">Religion*</label>
													<div class="col-sm-4">
                            <input type="text" name="religion_2" class="form-control" placeholder="Religion" value="{{old('religion_2')}}" id="religion_2">
                            {!! $errors->first('religion_2', '<span class="errortext text-red">:message</span>') !!}
													</div>			
											</div>


                      <div class="form-group">
												<label for="Emailid_2" class="col-sm-2">EmailId*</label>
													<div class="col-sm-4">
                            <input type="text" name="Emailid_2" class="form-control" placeholder="EmailId" value="{{old('Emailid_2')}}" id="Emailid_2">
                            {!! $errors->first('Emailid_2', '<span class="errortext text-red">:message</span>') !!}
													</div>			
											</div>

                      <div class="form-group">
												<label for="contactno_2" class="col-sm-2">Contact Number*</label>
													<div class="col-sm-4">
                            <input type="text" name="contactno_2" class="form-control" placeholder="Contact Number" value="{{old('contactno_2')}}" id="contactno_2">
                            {!! $errors->first('contactno_2', '<span class="errortext text-red">:message</span>') !!}
													</div>			
											</div>

                          </div>

                          <div class="form-group" id="poadivcheckbox">
                          <label for="thirdapplicantchecked" class="col-sm-2">&nbsp;</label>
                        
													<div class="col-sm-4">
                          <div class="checkbox">
                            <label>
                              <input type="checkbox" name="thirdapplicantchecked" id="thirdapplicantchecked"> Power of Attorney (if any)
                            </label>
                          </div>
													</div>
                      </div>

                          <div class="text-center" id="loader1">
                          <img src="{{ config('app.AWS_URL')}}/images/regdetails/loadergif.gif" width="90" alt="loader1">
                          </div>

                          <div id="3ndapplicantdiv">

                              <div class="form-group">
												<label for="poaname" class="col-sm-2">Name*</label>
												<div class="col-sm-6">
													<input type="text" class="form-control" value="{{old('poaname')}}" name="poaname" placeholder="Name" id="poaname">
													{!! $errors->first('poaname', '<span class="errortext text-red">:message</span>') !!}
												</div>
											</div>

                      <div class="form-group">
                                <label for="poafathersname" class="col-sm-2 ">Father's Name*</label>
												 <div class="col-sm-4">
													<input type="text" name="poafathersname" value="{{old('poafathersname')}}" placeholder="Father's Name" class="form-control" id="poafathersname">
													{!! $errors->first('poafathersname', '<span class="errortext text-red">:message</span>') !!}
												</div>
											</div>
											<div class="form-group">
												<label for="poaage" class="col-sm-2 ">POA Age*</label>
												<div class="col-sm-2">
													<input type="text" class="form-control" value="{{old('poaage')}}" placeholder="Age" name="poaage" id="poaage">
													{!! $errors->first('poaage', '<span class="errortext text-red">:message</span>') !!}
												</div>
											</div>
											
											<div class="form-group">
												<label for="poaaddress" class="col-sm-2">POA Address*</label>
													<div class="col-sm-4">
                            <input type="text" name="poahouseflatno" class="form-control" value="{{old('poahouseflatno')}}" placeholder="House/Flat no.*" id="poahouseflatno">
                            {!! $errors->first('poahouseflatno', '<span class="errortext text-red">:message</span>') !!}
													</div>	
                          <div class="col-sm-4">
                            <input type="text" name="poa_street_name" class="form-control" value="{{old('poa_street_name')}}" placeholder="Street Name*" id="poa_street_name">
                            {!! $errors->first('poa_street_name', '<span class="errortext text-red">:message</span>') !!}
													</div>									
											</div>
                     
                      <div class="form-group">
												<label for="poa_area" class="col-sm-2">&nbsp;</label>
													<div class="col-sm-4">
                            <input type="text" name="poa_area" class="form-control" value="{{old('poa_area')}}" placeholder="Area*" id="poa_area">
                            {!! $errors->first('poa_area', '<span class="errortext text-red">:message</span>') !!}
													</div>
                          <div class="col-sm-4">
                            <input type="text" name="poa_pincode" class="form-control" value="{{old('poa_pincode')}}" placeholder="Pincode*" id="poa_pincode">
                            {!! $errors->first('poa_pincode', '<span class="errortext text-red">:message</span>') !!}
													</div>										
											</div>
                      <div class="form-group">
												<label for="listBox" class="col-sm-2">&nbsp;</label>
													<div class="col-sm-4">
                          <select class="form-control" id="listBox3" name="poastate" onchange="selct_district(this.value, 'poacity')"></select>
                          {!! $errors->first('poastate', '<span class="errortext text-red">:message</span>') !!}
													</div>
                          <div class="col-sm-4">
                          <select class="form-control secondlist" id='poacity' name="poacity">
                            <option value="">Select City</option>
                          </select>
                          {!! $errors->first('poacity', '<span class="errortext text-red">:message</span>') !!}
													</div>											
											</div>
                      

                      <div class="form-group">
												<label for="poa_panno_2" class="col-sm-2">PAN Number*</label>
													<div class="col-sm-4">
                            <input type="text" name="poa_panno_2" class="form-control" value="{{old('poa_panno_2')}}" placeholder="PAN No." id="poa_panno_2">
                            {!! $errors->first('poa_panno_2', '<span class="errortext text-red">:message</span>') !!}
													</div>		
                          <div class="col-sm-4">
                            <input type="file" name="poa_panfile_2" class="form-control" value="{{old('poa_panfile_2')}}" placeholder="Attach PAN Copy" id="poa_panfile_2">
                            {!! $errors->first('poa_panfile_2', '<span class="errortext text-red">:message</span>') !!}
                            <span id="file3download"></span>
													</div>									
											</div>

                      <div class="form-group">
												<label for="poa_religion_2" class="col-sm-2">Religion*</label>
													<div class="col-sm-4">
                            <input type="text" name="poa_religion_2" class="form-control" value="{{old('poa_religion_2')}}" placeholder="Religion" id="poa_religion_2">
                            {!! $errors->first('poa_religion_2', '<span class="errortext text-red">:message</span>') !!}
													</div>			
											</div>


                      <div class="form-group">
												<label for="poa_Emailid_2" class="col-sm-2">EmailId*</label>
													<div class="col-sm-4">
                            <input type="text" name="poa_Emailid_2" class="form-control" value="{{old('poa_Emailid_2')}}" placeholder="EmailId" id="poa_Emailid_2">
                            {!! $errors->first('poa_Emailid_2', '<span class="errortext text-red">:message</span>') !!}
													</div>			
											</div>

                      <div class="form-group">
												<label for="poa_contactno_2" class="col-sm-2">Contact Number*</label>
													<div class="col-sm-4">
                            <input type="text" name="poa_contactno_2" class="form-control" value="{{old('poa_contactno_2')}}" placeholder="Contact Number" id="poa_contactno_2">
                            {!! $errors->first('poa_contactno_2', '<span class="errortext text-red">:message</span>') !!}
													</div>			
                      </div>
                      
                      <div class="form-group">
												<label for="poafile" class="col-sm-2">POA (Copy to be attached)</label>
													<div class="col-sm-4">
                            <input type="file" name="poafile" class="form-control" id="poafile">
                            {!! $errors->first('poafile', '<span class="errortext text-red">:message</span>') !!}
                            <span id="file4download"></span>
													</div>			
                      </div>
                      
                      <div class="form-group">
												<label for="poafile" class="col-sm-2">POA Registered*</label>
													<div class="col-sm-4">
                          <div class="form-group">
                  <div class="radio" style="padding-left: 15px;">
                    <label>
                      <input type="radio" name="poa_registerd" id="poa_registerd1" value="yes">
                      Yes
                    </label>&nbsp;
                    <label>
                      <input type="radio" name="poa_registerd" id="poa_registerd2" value="no" checked="true">
                      No
                    </label>
                  </div>
            
                </div>
													</div>			
                      </div>
                      
                      <div class="form-group" id="poa_doc_no_div">
												<label for="poa_doc_no" class="col-sm-2">POA Document Number*</label>
													<div class="col-sm-4">
                            <input type="text" name="poa_doc_no" class="form-control" value="{{old('poa_doc_no')}}" id="poa_doc_no" placeholder="POA Document Number">
                            {!! $errors->first('poa_doc_no', '<span class="errortext text-red">:message</span>') !!}
													</div>			
                      </div>


                      <div class="form-group">
												<label for="poaforeign_power" class="col-sm-2">In case of Foreign Power - Whether Adjudicated In India*</label>
													<div class="col-sm-4">
                          <div class="form-group">
                  <div class="radio" style="padding-left: 15px;">
                    <label>
                      <input type="radio" name="poaforeign_power" id="poaforeign_power1" value="yes">
                      Yes
                    </label>&nbsp;
                    <label>
                      <input type="radio" name="poaforeign_power" id="poaforeign_power2" value="no" checked="true">
                      No
                    </label>
                  </div>
            
                </div>
													</div>			
                      </div>

                      <div class="form-group" id="poa_adj_date_no_div">
												<label for="poa_adj_date_no" class="col-sm-2">POA - Adjudication Date and Number*</label>
													<div class="col-sm-3">                          
                             <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control pull-right" name="poa_adj_date" readonly='true' id="poa_adj_date" value="{{old('poa_adj_date')}}" >
                  
                </div>
                {!! $errors->first('poa_adj_date', '<span class="errortext text-red">:message</span>') !!}
                          </div>			
                          
                          <div class="col-sm-3">
                            <input type="text" name="poa_adj_no" class="form-control" id="poa_adj_no" placeholder="POA Adjudication Number" value="{{old('poa_adj_no')}}">
                            {!! $errors->first('poa_adj_no', '<span class="errortext text-red">:message</span>') !!}
													</div>
                      </div>
                      
                          </div>
                 
                          

                      <div id="4ndapplicantdiv">
                      <div class="form-group">
												<label for="need_home_loan" class="col-sm-2">Availing Home Loan*</label>
													<div class="col-sm-4">
                          <div class="form-group">
                  <div class="radio" style="padding-left: 15px;">
                    <label>
                      <input type="radio" name="need_home_loan" id="need_home_loan1" value="yes">
                      Yes
                    </label>&nbsp;
                    <label>
                      <input type="radio" name="need_home_loan" id="need_home_loan2" value="no" checked="true">
                      No
                    </label>
                  </div>
            
                </div>
													</div>			
                      </div>

                      <div class="form-group" id="bankdetails_div">
												<label for="bankdetails" class="col-sm-2">Bank Details*</label>
													<div class="col-sm-4">
														<select name="bankdetails" id="bankdetails" class="form-control">
                              <option value="">Select Bank</option>
                              @if(count($bankdetails) > 0)
                              @foreach($bankdetails as $k => $bank)
                              <option value="{{$bank}}" @if(old('bankdetails') == $bank) selected="selected" @endif >{{$bank}}</option>
                              @endforeach
                              @endif
                            </select>
                            {!! $errors->first('bankdetails', '<span class="errortext text-red">:message</span>') !!}
													</div>			
                      </div>
											</div>
											
											
											<div class="form-group" id="submitdiv" style="text-align:center;">
												<div class="col-sm-7"> 
													<input class="submitbtn btn btn-danger" type="submit" value="Submit" id="submit" />
													<a href="{{ url('/customerzone/dashboard') }}" class="btn btn-warning">Cancel</a>
												</div> 
											</div>
                                 
                      <div class="row">
                      <blockquote>
                    <h4 style="font-weight:bold;">Note:</h4>
                    <ol>
                    <li>Changes in the above fields can be made only before sale deed is done.</li>
                    </ol>
                    </blockquote>
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
<script src="{{ config('app.AWS_URL')}}/newcustomerzoneassets/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>

<script src="{{ config('app.AWS_URL')}}/state.js"></script>
<script type="text/javascript">
											
				$(document).ready(function(){
          
          $("#loader").hide();
          $("#2ndapplicantdiv").hide();
          $("#loader1").hide();
          $("#3ndapplicantdiv").hide();  
                        $('.sidebar-menu').tree();



                        var availhomeloan = $("input[name='need_home_loan']:checked").val();
                        if (availhomeloan == 'yes') {
                          $("#bankdetails_div").fadeIn('slow', () => {
                              $("#bankdetails_div").show();
                          });
                            }else{
                              
                              $("#bankdetails_div").hide();
                              
                            }
                        $("input[name='need_home_loan']").on('change', () => {
                          var newavailhomeloan = $("input[name='need_home_loan']:checked").val();
                            if (newavailhomeloan == 'yes') {
                              $("#bankdetails_div").fadeIn('slow', () => {
                              $("#bankdetails_div").show();
                              });
                            }else{
                              $("#bankdetails_div").fadeOut('slow', () => {
                              $("#bankdetails_div").hide();
                              });
                            }
                        });

                        var poaforeign_power = $("input[name='poaforeign_power']:checked").val();
                        if (poaforeign_power == 'yes') {
                          $("#poa_adj_date_no_div").fadeIn('slow', () => {
                              $("#poa_adj_date_no_div").show();
                          });
                            }else{
                              $("#poa_adj_date_no_div").fadeOut('slow', () => {
                              $("#poa_adj_date_no_div").hide();
                              });
                            }
                        $("input[name='poaforeign_power']").on('change', () => {
                          var newpoaforeign_power = $("input[name='poaforeign_power']:checked").val();
                            if (newpoaforeign_power == 'yes') {
                              $("#poa_adj_date_no_div").fadeIn('slow', () => {
                              $("#poa_adj_date_no_div").show();
                              });
                            }else{
                              $("#poa_adj_date_no_div").fadeOut('slow', () => {
                              $("#poa_adj_date_no_div").hide();
                              });
                            }
                        });

                         var poa_registerd = $("input[name='poa_registerd']:checked").val();
                        if (poa_registerd == 'yes') {
                          $("#poa_doc_no_div").fadeIn('slow', () => {
                              $("#poa_doc_no_div").show();
                          });
                            }else{
                              $("#poa_doc_no_div").fadeOut('slow', () => {
                              $("#poa_doc_no_div").hide();
                              });
                            }
                        $("input[name='poa_registerd']").on('change', () => {
                          var newpoa_registerd = $("input[name='poa_registerd']:checked").val();
                            if (newpoa_registerd == 'yes') {
                              $("#poa_doc_no_div").fadeIn('slow', () => {
                                $("#poa_doc_no_div").show();
                              });
                              
                            }else{
                              $("#poa_doc_no_div").fadeOut('slow', () => {
                              $("#poa_doc_no_div").hide();
                              });
                            }
                        });


                         @if(old('project'))
                        setTimeout(() => {                          
                          $("#Projects").val("{{old('project')}}").trigger('change');
                        }, 600);
                        @endif

                         @if(old('unit'))
                        setTimeout(() => {                          
                          $("#Units").val("{{old('unit')}}");
                        }, 600);
                        @endif
                        

var handles = ["Select State", "Andhra Pradesh", "Arunachal Pradesh", "Assam", "Bihar", "Chhattisgarh", "Dadra and Nagar Haveli", "Daman and Diu", "Delhi", "Goa", "Gujarat", "Haryana", "Himachal Pradesh", "Jammu and Kashmir", "Jharkhand", "Karnataka",
  "Kerala", "Madhya Pradesh", "Maharashtra", "Manipur", "Meghalaya", "Mizoram", "Nagaland", "Orissa", "Puducherry", "Punjab", "Rajasthan", "Sikkim", "Tamil Nadu",
  "Telangana", "Tripura", "Uttar Pradesh", "Uttarakhand", "West Bengal"];
                        var options = '';
                        for (var i = 0; i < handles.length; i++) {                          
                          options += '<option value="' + handles[i] + '" >' + handles[i] + '</option>';
                        }

                        $('#listBox1').html(options);
                        $('#listBox2').html(options);
                        $('#listBox3').html(options);

                       
                        
                  $("#secondndapplicantchecked").on('change', function(){
                    if($(this).prop("checked") == true){
                      $("#loader").show();
                      setTimeout(() => {
                        $("#loader").hide();
                        $("#2ndapplicantdiv").fadeIn('slow', () => {
                        $("#2ndapplicantdiv").show();
                        });  
                      }, 1000);
                      
                    }
                    else{
                      $("#loader").show();
                      setTimeout(() => {
                        $("#loader").hide();
                        $("#2ndapplicantdiv").fadeOut('slow', () => {
                        $("#2ndapplicantdiv").hide();  
                        });
                      }, 1000);
                    }
                    
                  });


                  $("#thirdapplicantchecked").on('change', function(){
                    if($(this).prop("checked") == true){
                      $("#loader1").show();
                      setTimeout(() => {
                        $("#loader1").hide();
                        $("#3ndapplicantdiv").fadeIn('slow', () => {
                        $("#3ndapplicantdiv").show();  
                        });
                      }, 1000);
                      
                    }
                    else{
                      $("#loader1").show();
                      setTimeout(() => {
                        $("#loader1").hide();
                        $("#3ndapplicantdiv").fadeOut('slow', () => {
                        $("#3ndapplicantdiv").hide();  
                        });
                      }, 1000);
                    }
                    
                  });
                        

                        @if(old('first_app_state'))
                        setTimeout(() => {
                          $("#listBox1").val("{{old('first_app_state')}}");
                          selct_district("{{old('first_app_state')}}", 'first_app_city');
                          @if(old('first_app_city'))
                          setTimeout(() => {
                          $("#first_app_city").val("{{old('first_app_city')}}");
                          }, 600);
                          @endif
                        }, 600);
                        @endif

                        @if(old('second_app_state'))
                        setTimeout(() => {
                          $("#listBox2").val("{{old('second_app_state')}}");
                          selct_district("{{old('second_app_state')}}", 'second_app_city');
                          @if(old('second_app_city'))
                          setTimeout(() => {
                          $("#second_app_city").val("{{old('second_app_city')}}");
                          }, 600);
                          @endif
                        }, 600);
                        @endif

                          @if(old('poastate'))
                        setTimeout(() => {
                          $("#listBox3").val("{{old('poastate')}}");
                          selct_district("{{old('poastate')}}", 'poacity');
                          @if(old('poacity'))
                          setTimeout(() => {
                          $("#poacity").val("{{old('poacity')}}");
                          }, 600);
                          @endif
                        }, 600);
                        @endif

                        
                        @if(old('need_home_loan'))
                        
                        $("input[name='need_home_loan'][value='{{old('need_home_loan')}}']").prop('checked', true);
                        @if(old('need_home_loan') == 'yes')
                        $("#bankdetails_div").fadeIn('slow', () => {
                        $("#bankdetails_div").show();  
                        });
                        @endif
                        @endif

                         @if(old('poaforeign_power'))
                        
                        $("input[name='poaforeign_power'][value='{{old('poaforeign_power')}}']").prop('checked', true);
                        @if(old('poaforeign_power') == 'yes')
                        $("#poa_adj_date_no_div").fadeIn('slow', () => {
                        $("#poa_adj_date_no_div").show();  
                        });
                        @endif
                        @endif

                         @if(old('poa_registerd'))
                        
                        $("input[name='poa_registerd'][value='{{old('poa_registerd')}}']").prop('checked', true);
                        @if(old('poa_registerd') == 'yes')
                        $("#poa_doc_no_div").fadeIn('slow', () => {
                        $("#poa_doc_no_div").show();  
                        });
                        @endif
                        @endif

                        @if(old('secondndapplicantchecked'))
                        $("#loader").show();
                        setTimeout(() => {
                          $("#loader").hide();
                          $("#secondndapplicantchecked").prop('checked', true);
                          
                        $("#2ndapplicantdiv").fadeIn('slow', () => {
                        $("#2ndapplicantdiv").show();
                        });  
                        }, 600);
                        @endif

                         @if(old('thirdapplicantchecked'))
                        $("#loader1").show();
                        setTimeout(() => {
                          $("#loader1").hide();
                          $("#thirdapplicantchecked").prop('checked', true);
                          
                        $("#3ndapplicantdiv").fadeIn('slow', () => {
                        $("#3ndapplicantdiv").show();
                        });  
                        }, 600);
                        @endif

                        $("#panno_1, #applicant_1_name, #title_1_name, #houseflatno,#street_name_1,#street_name_2,#religion_1").on('keyup', (e) => {
                          $(e.target).val($(e.target).val().toUpperCase());
                        });

                        $("#panno_2, #applicant_2_name, #title_2_name, #houseflatno2,#sec_street_name_1,#sec_street_name_2,#religion_2").on('keyup', (e) => {
                          $(e.target).val($(e.target).val().toUpperCase());
                        });

                        $("#poaname, #poafathersname, #poahouseflatno, #poa_street_name,#poa_area,#poa_panno_2,#poa_religion_2").on('keyup', (e) => {
                          $(e.target).val($(e.target).val().toUpperCase());
                        });

                        $('#poa_adj_date').datepicker({
      autoclose: true,
      format: 'dd-mm-yyyy',
      endDate: 'yesterday'
    });


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

                              //$("#submit").prop('disabled', true);
                              //$("#submitdiv").hide();
                          
                          $("#Units").on('change', function(){

                            var projectcode = $('#Projects').val();
                            var unitcode = $('#Units').val();
                            var glob_saleagreement = '';
                            if ((projectcode != '') && (unitcode != '')) {

                              $.post('/customerzone/checkcustomersaleagreement',{_token:'{{csrf_token()}}',project: projectcode,unit:unitcode}, function(saledata){
                                var saleagreement = JSON.parse(saledata);

                                glob_saleagreement = saleagreement.Status;
                                /*if (glob_saleagreement == 'N') {
                                  $("#submit").prop('disabled', true);
                                  $("#submitdiv").hide();
                                }
                                else{
                                  $("#submit").prop('disabled', false);
                                  $("#submitdiv").show();
                                }*/
                              });


                              $.post('/customerzone/getcustomer_reg_details',{_token:'{{csrf_token()}}',project: projectcode,unit:unitcode}, function(data){
                                var jsondata = JSON.parse(data);
                                if (jsondata.Customer_ID != '' ) {

                                  $("#file1download").html('');
                                  $("#file2download").html('');
                                  $("#file3download").html('');
                                  $("#file4download").html('');
                                  var proj = $("#Projects").val();
                                  var units = $("#Units").val();
                                  $('#changedetailsForm')[0].reset();
                                  $("#Projects").val(proj).trigger("change");
                                  $("#Units").val(units);
                                  $("#2ndapplicantdiv").hide();
                                  $("#3ndapplicantdiv").hide();
                                  $("#poa_doc_no_div").hide();
                                  $("#poa_adj_date_no_div").hide();
                                  $("#bankdetails_div").hide();

                                  $("#applicant_1_name").val(jsondata.Name1);
                                  $("#name1title").val(jsondata.SO1_Drop);
                                  $("#title_1_name").val(jsondata.SO1_Name);
                                  $("#applicant_1_age").val(jsondata.Age1);

                                  var appl1_addr1 = jsondata.Address1_Line1.split('|#');
                                  $("#houseflatno").val(appl1_addr1[0]);
                                  $("#street_name_1").val(appl1_addr1[1]);

                                   var appl1_addr2 = jsondata.Address1_Line2.split('|#');
                                  $("#street_name_2").val(appl1_addr2[0]);
                                  $("#pincode1").val(appl1_addr2[1]);

                                   var appl1_addr3 = jsondata.Address1_Line3.split('|#');
                                  $("#listBox1").val(appl1_addr3[0]).trigger('change');
                                  setTimeout(() => {
                                    $("#first_app_city").val(appl1_addr3[1]);
                                  }, 600);
                                  if (jsondata.PAN1_File_Loc != '') {
                                    $("#file1download").html("<a href='/newcustomerzoneassets/registrationdetails/"+jsondata.PAN1_File_Loc+"' download><i class=\'fa fa-download\'> Download File</a>");    
                                  }
                                
                                  $("#panno_1").val(jsondata.PAN1);
                                  $("#religion_1").val(jsondata.Religion1);
                                  $("#Emailid_1").val(jsondata.Email1);
                                  $("#contactno_1").val(jsondata.Contact1);

                                  var checkappl2_present = jsondata.Name2;
                                  if (checkappl2_present != '') {
                                    setTimeout(() => {
                                  $("#secondndapplicantchecked").prop('checked', true);
                              
                                  $("#2ndapplicantdiv").fadeIn('slow', () => {
                                  $("#2ndapplicantdiv").show();
                                  });  
                              }, 600);

                                  $("#applicant_2_name").val(jsondata.Name2);
                                  $("#name2title").val(jsondata.SO2_Drop);
                                  $("#title_2_name").val(jsondata.SO2_Name);
                                  $("#applicant_2_age").val(jsondata.Age2);

                                  var appl2_addr1 = jsondata.Address2_Line1.split('|#');
                                  $("#houseflatno2").val(appl2_addr1[0]);
                                  $("#sec_street_name_1").val(appl2_addr1[1]);

                                   var appl2_addr2 = jsondata.Address2_Line2.split('|#');
                                  $("#sec_street_name_2").val(appl2_addr2[0]);
                                  $("#sec_pincode2").val(appl2_addr2[1]);

                                   var appl2_addr3 = jsondata.Address2_Line3.split('|#');
                                  $("#listBox2").val(appl2_addr3[0]).trigger('change');
                                  setTimeout(() => {
                                    $("#second_app_city").val(appl2_addr3[1]);
                                  }, 600);
                                  if (jsondata.PAN2_File_Loc != '') {
                                    $("#file2download").html("<a href='/newcustomerzoneassets/registrationdetails/"+jsondata.PAN2_File_Loc+"' download><i class=\'fa fa-download\'> Download File</a>");    
                                  }
                                
                                  $("#panno_2").val(jsondata.PAN2);
                                  $("#religion_2").val(jsondata.Religion2);
                                  $("#Emailid_2").val(jsondata.Email2);
                                  $("#contactno_2").val(jsondata.Contact2);
                                  }



                                   var checkappl3_present = jsondata.Name_POA;
                                  if (checkappl3_present != '') {
                                    setTimeout(() => {
                                  $("#thirdapplicantchecked").prop('checked', true);
                              
                                  $("#3ndapplicantdiv").fadeIn('slow', () => {
                                  $("#3ndapplicantdiv").show();
                                  });  
                              }, 600);

                                  $("#poaname").val(jsondata.Name_POA);
                                  $("#poafathersname").val(jsondata.Fname_POA);
                                  $("#poaage").val(jsondata.Age_POA);

                                  var appl3_addr1 = jsondata.Add_POA_1.split('|#');
                                  $("#poahouseflatno").val(appl3_addr1[0]);
                                  $("#poa_street_name").val(appl3_addr1[1]);

                                   var appl3_addr2 = jsondata.Add_POA_2.split('|#');
                                  $("#poa_area").val(appl3_addr2[0]);
                                  $("#poa_pincode").val(appl3_addr2[1]);

                                   var appl3_addr3 = jsondata.Add_POA_3.split('|#');
                                  $("#listBox3").val(appl3_addr3[0]).trigger('change');
                                  setTimeout(() => {
                                    $("#poacity").val(appl3_addr3[1]);
                                  }, 600);
                                  if (jsondata.PAN3_File_Loc != '') {
                                    $("#file3download").html("<a href='/newcustomerzoneassets/registrationdetails/"+jsondata.PAN3_File_Loc+"' download><i class=\'fa fa-download\'> Download File</a>");    
                                  }
                                
                                  $("#poa_panno_2").val(jsondata.PAN_POA);
                                  $("#poa_religion_2").val(jsondata.Religion_POA);
                                  $("#poa_Emailid_2").val(jsondata.Email_POA);
                                  $("#poa_contactno_2").val(jsondata.Contact_POA);
                                  if (jsondata.POA_File_Loc != '') {
                                    $("#file4download").html("<a href='/newcustomerzoneassets/registrationdetails/"+jsondata.POA_File_Loc+"' download><i class=\'fa fa-download\'> Download File</a>");  
                                  }
                                  
                                  
                                  $("input[name='poa_registerd'][value='"+jsondata.POA_Reg+"']").prop('checked', true);
                        if(jsondata.POA_Reg == 'yes'){
                        $("#poa_doc_no_div").fadeIn('slow', () => {
                          $("#poa_doc_no").val(jsondata.POA_DocNo);
                        $("#poa_doc_no_div").show();  
                        });
                        }

                        $("input[name='poaforeign_power'][value='"+jsondata.POA_Adj_Status+"']").prop('checked', true);
                        if(jsondata.POA_Adj_Status == 'yes'){
                        $("#poa_adj_date_no_div").fadeIn('slow', () => {
                          $("#poa_adj_date").val(jsondata.POA_Adj_Date);
                          $("#poa_adj_no").val(jsondata.POA_Adj_No);
                        $("#poa_adj_date_no_div").show();  
                        });
                        }

                         

                                  }

                                  if(jsondata.Bank_Details != ''){
                          $("input[name='need_home_loan'][value='yes']").prop('checked', true);
                        $("#bankdetails_div").fadeIn('slow', () => {
                          $("#bankdetails").val(jsondata.Bank_Details);
                        $("#bankdetails_div").show();  
                        });
                      }


                      /*if (glob_saleagreement == 'N') {
                        $("#1stapplicantdiv :input").not('#Projects').not('#Units').attr("disabled", true);
                        $("#2ndapplicantdiv :input").attr("disabled", true);
                        $("#3ndapplicantdiv :input").attr("disabled", true);
                        $("#4ndapplicantdiv :input").attr("disabled", true);
                        $("#poadivcheckbox :input").attr("disabled", true);
                      }
                      else{
                        $("#1stapplicantdiv :input").not('#Projects').not('#Units').attr("disabled", false);
                        $("#2ndapplicantdiv :input").attr("disabled", false);
                        $("#3ndapplicantdiv :input").attr("disabled", false);
                        $("#4ndapplicantdiv :input").attr("disabled", false);
                        $("#poadivcheckbox :input").attr("disabled", false);
                      }*/
 
                                }
                                else{
                                  $("#file1download").html('');
                                  $("#file2download").html('');
                                  $("#file3download").html('');
                                  $("#file4download").html('');
                                  var proj = $("#Projects").val();
                                  var units = $("#Units").val();
                                  $('#changedetailsForm')[0].reset();
                                  $("#Projects").val(proj).trigger("change");
                                  $("#Units").val(units);
                                  $("#2ndapplicantdiv").hide();
                                  $("#3ndapplicantdiv").hide();
                                  $("#poa_doc_no_div").hide();
                                  $("#poa_adj_date_no_div").hide();
                                  $("#bankdetails_div").hide();

                                  var customerdata = <?php echo json_encode($getcustomerdata); ?>;
                                  if (customerdata != '') {
                                    var cus_json_data = customerdata[0];
                                    $("#applicant_1_name").val(cus_json_data.name);
                                    $("#houseflatno").val(cus_json_data.houseno);
                                    $("#street_name_1").val(cus_json_data.street1+' '+cus_json_data.street2);
                                    $("#street_name_2").val(cus_json_data.street3);
                                    $("#pincode1").val(cus_json_data.pin);
                                    $("#contactno_1").val(cus_json_data.mobile);
                                    $("#Emailid_1").val(cus_json_data.email);
                                  }
                                  /*if (glob_saleagreement == 'N') {
                        $("#1stapplicantdiv :input").not('#Projects').not('#Units').attr("disabled", true);
                        $("#2ndapplicantdiv :input").attr("disabled", true);
                        $("#3ndapplicantdiv :input").attr("disabled", true);
                        $("#4ndapplicantdiv :input").attr("disabled", true);
                        $("#poadivcheckbox :input").attr("disabled", true);
                      }
                      else{
                        $("#1stapplicantdiv :input").not('#Projects').not('#Units').attr("disabled", false);
                        $("#2ndapplicantdiv :input").attr("disabled", false);
                        $("#3ndapplicantdiv :input").attr("disabled", false);
                        $("#4ndapplicantdiv :input").attr("disabled", false);
                        $("#poadivcheckbox :input").attr("disabled", false);
                      }*/
                                  // $('#changedetailsForm').find('input, select, textarea')
                                  // .not("#Projects").not("#name1title").not("#name2title").not("#Units").not("#submit").not("input[name='_token']").val('');
                                }
                                
                              
                            });  
                            }
                            
                            


                          });
								
													
												
				});				
		    </script>
@endsection
