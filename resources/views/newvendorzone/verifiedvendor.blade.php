@extends('newvendorzone.layout')

@section('title')
VGN Projects Estates Pvt Ltd |Vendor Zone| Verified Vendor Registration Page
@endsection

@section('description')
<META NAME="Subject" CONTENT="VGN Projects Estates - Verified Vendor Registration Page">
<meta name="description" content="VGN Projects Estates - Vendor Registration Page">

@endsection

@section('keyword')  
@endsection


@section('style')
@include('newvendorzone.styles.commoncss')
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="{{ config('app.AWS_URL')}}/newcustomerzoneassets/dist/js/defines.js"></script>
<style>
.login-page{
        background: url("{{ config('app.AWS_URL')}}/newcustomerzoneassets/img/pattern.jpg") repeat;
    }

    .swal-text, .swal-title{
    color: #000;
  }

    .errorcolor{
      border-color: red;
    box-shadow: 0 0 0 0.2rem #d24c3b;
    }

    .successcolor{
       border-color: green;
    }

    #contactpersonpan
    {
        text-transform: uppercase;
    }
    #registration_proof_number
    {
        text-transform: uppercase;
    }
    .error
    {
        color: red;
        visibility: hidden;
    }
  
  .mainbox
  {
    background: #fff;
    padding-top:8px;
    position: relative;
  top: 10%;
  
  }
  .errortext {
    color: #c7254e;
  }
  .mainbox {
    margin: 2% auto;
  }
</style>
@endsection

@section('bodycontent')
<body class="hold-transition login-page" id="bgimg">

																		@if(session()->has('error_msg'))
                                        
                                        
                                        <div class="row" style="padding-top:15px;">
  <div class="col-md-4 col-md-offset-4">
     <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                {!! Session::get('error_msg') !!}
              </div>
  </div>
</div>
																				@endif
																				@if(session()->has('suc_msg'))
                                        
                                               <div class="row" style="padding-top:15px;">
  <div class="col-md-4 col-md-offset-4">
     <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                {!! Session::get('suc_msg') !!}
              </div>
  </div>
</div>
																				@endif

<div class="row">
 <div class="col-md-6 col-md-offset-3">
<div class="mainbox box box-danger">
  <div class="login-logo">
   <a href="{{ url('/')}}"> <img src="{{ config('app.AWS_URL')}}/images/custom/vgn-logo.png" align="center" ></a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body box-body">
    <h4 class="login-box-msg" style="background-color:#38a34a;color: #ffffff; font-size: 18px; text-align: center; padding: 7px 10px; margin-top: 0;">Details Confirmation for Vendor Registration</h4>
    <br>

    <form id="myForm" class="form-horizontal" method="POST" action="{{ url('/vendorzone/verifiedvendor')}}">
    {{ csrf_field() }}
      
      <div class="form-group">
                  <label for="typeoforganization" class="col-sm-4 control-label">Name of the Organization*</label>

                  <div class="col-sm-8"><input type="text" class="form-control" value="{{$sessdata['name_org']}}" readonly="true">    </div>
                </div> 
      
     
              <div class="form-group">
                  <label for="typeoforganization" class="col-sm-4 control-label">Type of the Organization*</label>

                  <div class="col-sm-8"> <input type="text" class="form-control" value="{{$sessdata['type_org']}}" readonly="true">             </div>
                </div> 

                <div class="form-group">
                  <label for="registration_proof" class="col-sm-4 control-label">Registration Proof*</label>

                 
                  <div class="col-sm-8">
                    @if($sessdata['register_proof'] == 'panno')
                    <input type="text" class="form-control" value="PAN Number" readonly="true"> 
                    @elseif($sessdata['register_proof'] == 'gstno')
                    <input type="text" class="form-control" value="GST Number" readonly="true"> 
                    @endif($sessdata['register_proof'] == 'adharno')
                    <input type="text" class="form-control" value="AADHAR Number" readonly="true">    
                  </div>
                  
     </div>

     <div class="form-group">
                  <label for="registration_proof_number" class="col-sm-4 control-label">Registration Proof Number*</label>

                  <div class="col-sm-8">
                    
                   <input type="text" class="form-control" value="{{$sessdata['register_proof_number']}}" readonly="true">  
                  </div>
                </div>

                 <div class="form-group">
                  <label for="materialorservice" class="col-sm-4 control-label">Material / Service Category*</label>

                  <div class="col-sm-8">
                    
                    <select class="form-control" name="Material_or_service_category" id="materialorservice">
                    <option value="">Select</option>
                  </select>
                  {!! $errors->first('Material_or_service_category', '<span class="errortext text-red">:message</span>') !!}
                  </div>
                </div>
                <div class="form-group">
                  <label for="typeofbuisness" class="col-sm-4 control-label">Type of Business*</label>

                  <div class="col-sm-8">
                    
                    <select class="form-control" name="Type_of_Business" id="typeofbuisness">
                    <option value="">Select</option>
                  </select>
                  {!! $errors->first('Type_of_Business', '<span class="errortext text-red">:message</span>') !!}
                  </div>
                </div>
                <div class="form-group">
                  <label for="vendoractgroup" class="col-sm-4 control-label">Vendor Account Group*</label>

                  <div class="col-sm-8">
                    
                    <select class="form-control" name="Vendor_Account_Group" id="vendoractgroup">
                    <option value="">Select</option>
                  </select>
                  {!! $errors->first('Vendor_Account_Group', '<span class="errortext text-red">:message</span>') !!}
                  </div>
                </div>
                <div class="form-group">
                  <label for="contactperson" class="col-sm-4 control-label">Contact Person*</label>

                  <div class="col-sm-8">
                    
                    <input type="text" class="form-control" value="{{$sessdata['cnct']}}" readonly="true">  
                  </div>
                </div>
                <div class="form-group">
                  <label for="contactnomobile" class="col-sm-4 control-label">Contact Number (Mobile)*</label>

                  <div class="col-sm-8">
                    
                    <input type="text" class="form-control" value="{{$sessdata['mob']}}" readonly="true">  
                  </div>
              </div>                
              @if(($sessdata['filearray']) > 0)
              @foreach($sessdata['filearray'] as $vv)
               <div class="form-group">
                  <label for="file1" class="col-sm-4 control-label">{{ ucwords(strtolower($vv['vgnsapname'])) }}</label>

                  <div class="col-sm-8">
                   {{$vv['user_uploadedfname']}} - <a href="{{$vv['temp_path']}}" target="_blank">View File</a>
                    
                  </div>
                </div>   
              @endforeach
              @endif
                 
                
                <div class="form-group">
                  <label for="contactnotelephone" class="col-sm-4 control-label">Contact Number (Telephone)*</label>

                  <div class="col-sm-8">
                    
                    <input type="text" class="form-control" value="{{$sessdata['tel']}}" readonly="true">  
                  </div>
                </div>
                 <div class="form-group">
                  <label for="contactpersonemail" class="col-sm-4 control-label">Email*</label>

                  <div class="col-sm-8">
                    
                    <input type="text" class="form-control" value="{{$sessdata['email']}}" readonly="true">  
                  </div>
                </div>

                                  

                <div class="form-group">
                  <label for="country" class="col-sm-4 control-label">Country*</label>

                  <div class="col-sm-8">
                    
                    <select class="form-control" name="country" id="country" readonly="true">
                    
                    <option value="IN" @if($sessdata['ctry'] == 'IN') selected @endif>INDIA</option>
                    
                  </select>
                  
                  </div>
                </div>
                <div class="form-group">
                  <label for="region" class="col-sm-4 control-label">Region*</label>

                  <div class="col-sm-8">
                    
                    <select class="form-control" name="region" id="region" readonly="true">
                    
                    <?php
                        $region = array();
                        if(array_key_exists('0',$gethelp['Region_Search_Help'])){
                            $region = $gethelp['Region_Search_Help'];
                        }
                        else
                        {
                            $region[0] = $gethelp['Region_Search_Help'];
                        }
                        ?>
                    @foreach($region as $reg)
                    <option value="{{$reg['Vendor_Region']}}" @if($sessdata['region'] == $reg['Vendor_Region']) selected @endif>{{$reg['Vendor_Region']}}</option>
                    @endforeach
                  </select>
                  
                  </div>
                </div>
       
      
      <div class="row">
        
        <!-- /.col -->
        <div class="col-sm-4 col-sm-offset-1">
          <button type="submit" class="btn btn-success btn-block btn-flat" id="sub">Confirm</button>
          
        </div>

        <div class="col-sm-4 col-sm-offset-1">
          
          <a href="/vendorzone/verifiedvendorlogout" class="btn btn-danger btn-block btn-flat" id="sub">Refill form</a>
        </div>
        <!-- /.col -->
      </div>
    </form>


    
    

  </div>
  <br>
   
  <!-- /.login-box-body -->
</div>
</div>
</div>
<!-- /.login-box -->
@endsection

@section('script')

@include('newvendorzone.js.commonjs')

<script type="text/javascript">


										$(document).ready(function(){

                        swal({
  title: "Vendor Details Confirmation",
  text: "Please click the `Confirm` button after checking all the details are valid to register as a Vendor.",
  icon: "success",
});


                     /* $("#sub").on('click', function (argument) {
                        $(selector).trigger("change");
                      });*/
                      //registration_proof
                    


                      $("#lblRegproofCard").text('');


                      
          
											$(".verifytext").hide();
                      $(".verifytextemail").hide();
                      $(".verifytextpan").hide();
										var search=<?php echo json_encode($gethelp);?>;
                    var sessc = <?php echo json_encode($sessdata); ?>;

                  
										
										//var country='<option value="" selected>Select*</option>';
										var materials='';
										var tmpcon=[];

               



                  


                    

                    
										
										var tmp=[];
										$.each( search['Search_table_01'], function( i, val ) {
											if($.inArray(val['Material_Service_cat_Code'],tmp)===-1)
											{
											tmp.push(val['Material_Service_cat_Code']);
                      if(sessc.mat == val['Material_Service_cat_Code']){
											materials += '<option value="'+val['Material_Service_cat_Code']+'"';
											materials+=' selected>'+val['Material_Service_cat_Des']+'</option>';	
                    }
                    else{
                      
                    }

											}
											
										});				
									
										$('#materialorservice').html(materials);
                    $('#materialorservice').attr('readonly',true);	
										
										//genArea();
										//$('#country').on('change',function(){genArea();})
										

                      genTOB();
                      


                  
										$('#typeofbuisness').on('change',function(){genVenGrp();})
										
										function genArea()
										{
											var parent=$('#country').val();
											 var output='';
											$.each( search['Region_Search_Help'], function( i, val ) {
												if(val['Country_Code']==parent)
												{	
                          
													output += '<option value="'+val['Vendor_Region']+'"';
													if(val['Vendor_Region']==$('#region').attr('default'))
													output+=' selected ';
													output+='>'+val['Vendor_Region']+'</option>';
												}
											}); 
											  
												$('#region').html(output);
										};
										function genTOB()
										{
										
										var tobs='';
										var tmp=[];
										$.each( search['Search_table_01'], function( i, val ) {
											if(val['Material_Service_cat_Code']==$('#materialorservice').val())
											{
											tmp.push({'id':val['Material_Service_cat_Code'],'tob':val['Type_Of_Business']});
                        if(sessc.type_bus == val['Type_Of_Business']){
											tobs += '<option value="'+val['Type_Of_Business']+'"';
											tobs+=' selected>'+val['Type_Of_Business']+'</option>';	
                    }
                    else{
                      
                    }

											}
											
										});
										$('#typeofbuisness').html(tobs);	
                    $('#typeofbuisness').attr('readonly',true); 
                    genVenGrp(); 
										
										}
									function genVenGrp()
										{
										
										var venGrps='';
										var tmp=[];
										$.each( search['Search_table_02'], function( i, val ) {
											if(val['Type_Of_Business']==$('#typeofbuisness').val())
											{
											tmp.push({'id':val['Vendor_Acc_Group_Code'],'name':val['Vendor_Acc_Group_Des'],'tob':val['Type_Of_Business']});
                      if(sessc.ven_acc == val['Vendor_Acc_Group_Code']){
											venGrps += '<option value="'+val['Vendor_Acc_Group_Code']+'"';
											venGrps+=' selected>'+val['Vendor_Acc_Group_Des']+'</option>';	
                    }
                    else{
                     
                    }

											}
											
										});
										$('#vendoractgroup').html(venGrps);	
                    $('#vendoractgroup').attr('readonly',true); 
										
										}
									});
									
								</script>

@endsection
