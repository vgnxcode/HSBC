@extends('newemployeezone.layout')

@section('title')
VGN Projects Estates Pvt Ltd |Employee Zone| MyDetails Change Page
@endsection

@section('description')
    <meta name="description" content="">
@endsection

@section('keyword')  
@endsection


@section('style')
@include('newemployeezone.styles.commoncss')

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
                <h3 class="box-title"><i class="fa fa-edit margin-r-5"></i> Change Details </h3><span class="pull-right" ><a href="{{ url('/employeezone/mydetails_changepassword') }}" class="btn btn-danger btn-xs"><i class="fa fa-edit margin-r-5"></i>Change Password</a></span>
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
                
                
                <form id="changedetailsForm" method="POST" action="{{ url('/employeezone/changemydetails') }}" class="form-horizontal" >
                {{ csrf_field() }}
                   <div class="row" style="margin-left:3px;">
                       <div class="col-md-12">
                           <h4 class="text-red"> <i class="fa fa-map-marker margin-r-5"></i> Temporary Address </h4>
                            @foreach($getemployeeaddress as $address)
											<div class="form-group">
												<label for="inputPassword3" class="col-sm-2">House No*</label>
												
													<div class="col-sm-4">
														
													<input type="text" class="form-control" placeholder="House No." value="{{ $address->street_house_no }}" name="houseno" id="h_no" required>
													{!! $errors->first('houseno', '<span class="errortext text-red">:message</span>') !!}
													</div>									
												
											</div>
											<div class="form-group">
												<label for="inputPassword3" class="col-sm-2 ">Street Address*</label>
												<div class="col-sm-4">
													<input type="text" class="form-control" placeholder="Street Address 2" value="{{ $address->street_house_no1 }}" name="addr2" id="addr2"  required>
													{!! $errors->first('addr2', '<span class="errortext text-red">:message</span>') !!}
												</div>
											</div>
											<div class="form-group">
												<label for="inputPassword3" class="col-sm-2">City / Postal Code*</label>
												
													<div class="col-sm-2">
													<input type="text" class="form-control" placeholder="City" value="{{ $address->city }}" name="city" id="city" required>
													{!! $errors->first('city', '<span class="errortext text-red">:message</span>') !!}
													</div>
													<div class="col-sm-2">
													<input type="num" class="form-control" placeholder="Postal Code" value="{{ $address->postal_code }}" name="pincode" id="pincode" onkeypress="return isNumberKey(event)"  required />
													{!! $errors->first('pincode', '<span class="errortext text-red">:message</span>') !!}
													</div>									
												
											</div>
											<div class="form-group">
												<label for="inputPassword3" class="col-sm-2">Country*</label>
												<div class="col-sm-4">
													
													<select class="form-control userdropdown" name="country" id="ctry" country="true" default="{{ $address->country }}" required>

														<option selected value="">Select your country</option>
																<option value="Andorran">Andorran</option>
																<option value="Utd.Arab Emir.">Utd.Arab Emir.</option>
																<option value="Afghanistan">Afghanistan</option>
																<option value="Antigua/Barbuda">Antigua/Barbuda</option>
																<option value="Anguilla">Anguilla</option>
																<option value="Albania">Albania</option>
																<option value="Armenia">Armenia</option>
																<option value="Dutch Antilles">Dutch Antilles</option>
																<option value="Angola">Angola</option>
																<option value="Antarctica">Antarctica</option>
																<option value="Argentina">Argentina</option>
																<option value="Samoa, America">Samoa, America</option>
																<option value="Austria">Austria</option>
																<option value="Australia">Australia</option>
																<option value="Aruba">Aruba</option>
																<option value="Azerbaijan">Azerbaijan</option>
																<option value="Bosnia-Herz.">Bosnia-Herz.</option>
																<option value="Barbados">Barbados</option>
																<option value="Bangladesh">Bangladesh</option>
																<option value="Belgium">Belgium</option>
																<option value="Burkina Faso">Burkina Faso</option>
																<option value="Bulgaria">Bulgaria</option>
																<option value="Bahrain">Bahrain</option>
																<option value="Burundi">Burundi</option>
																<option value="Benin">Benin</option>
																<option value="Blue">Blue</option>
																<option value="Bermuda">Bermuda</option>
																<option value="Brunei Daruss.">Brunei Daruss.</option>
																<option value="Bolivia">Bolivia</option>
																<option value="Brazil">Brazil</option>
																<option value="Bahamas">Bahamas</option>
																<option value="Bhutan">Bhutan</option>
																<option value="Bouvet Islands">Bouvet Islands</option>
																<option value="Botswana">Botswana</option>
																<option value="Belarus">Belarus</option>
																<option value="Belize">Belize</option>
																<option value="Canada">Canada</option>
																<option value="Coconut Islands">Coconut Islands</option>
																<option value="Dem. Rep. Congo">Dem. Rep. Congo</option>
																<option value="CAR">CAR</option>
																<option value="Rep.of Congo">Rep.of Congo</option>
																<option value="Switzerland">Switzerland</option>
																<option value="Cote d'Ivoire">Cote d'Ivoire</option>
																<option value="Cook Islands">Cook Islands</option>
																<option value="Chile">Chile</option>
																<option value="Cameroon">Cameroon</option>
																<option value="China">China</option>
																<option value="Colombia">Colombia</option>
																<option value="Costa Rica">Costa Rica</option>
																<option value="Serbia/Monten.">Serbia/Monten.</option>
																<option value="Cuba">Cuba</option>
																<option value="Cape Verde">Cape Verde</option>
																<option value="Christmas Islnd">Christmas Islnd</option>
																<option value="Cyprus">Cyprus</option>
																<option value="Czech Republic">Czech Republic</option>
																<option value="Germany">Germany</option>
																<option value="Djibouti">Djibouti</option>
																<option value="Denmark">Denmark</option>
																<option value="Dominica">Dominica</option>
																<option value="Dominican Rep.">Dominican Rep.</option>
																<option value="lgeria">lgeria</option>
																<option value="Ecuador">Ecuador</option>
																<option value="Estonia">Estonia</option>
																<option value="Egypt">Egypt</option>
																<option value="West Sahara">West Sahara</option>
																<option value="Eritrea">Eritrea</option>
																<option value="Spain">Spain</option>
																<option value="Ethiopia">Ethiopia</option>
																<option value="European Union">European Union</option>
																<option value="Finland">Finland</option>
																<option value="Fiji">Fiji</option>
																<option value="Falkland Islnds">Falkland Islnds</option>
																<option value="Micronesia">Micronesia</option>
																<option value="Faroe Islands">Faroe Islands</option>
																<option value="France">France</option>
																<option value="Gabon">Gabon</option>
																<option value="United Kingdom">United Kingdom</option>
																<option value="Grenada">Grenada</option>
																<option value="Georgia">Georgia</option>
																<option value="French Guayana">French Guayana</option>
																<option value="Ghana">Ghana</option>
																<option value="Gibraltar">Gibraltar</option>
																<option value="Greenland">Greenland</option>
																<option value="Gambia">Gambia</option>
																<option value="Guinea">Guinea</option>
																<option value="Guadeloupe">Guadeloupe</option>
																<option value="Equatorial Guin">Equatorial Guin</option>
																<option value="Greece">Greece</option>
																<option value="S. Sandwich Ins">S. Sandwich Ins</option>
																<option value="Guatemala">Guatemala</option>
																<option value="Guam">Guam</option>
																<option value="Guinea-Bissau">Guinea-Bissau</option>
																<option value="Guyana">Guyana</option>
																<option value="Hong Kong">Hong Kong</option>
																<option value="Heard/McDon.Isl">Heard/McDon.Isl</option>
																<option value="Honduras">Honduras</option>
																<option value="Croatia">Croatia</option>
																<option value="Haiti">Haiti</option>
																<option value="Hungary">Hungary</option>
																<option value="Indonesia">Indonesia</option>
																<option value="Ireland">Ireland</option>
																<option value="Israel">Israel</option>
																<option value="India">India</option>
																<option value="Brit.Ind.Oc.Ter">Brit.Ind.Oc.Ter</option>
																<option value="Iraq">Iraq</option>
																<option value="Iran">Iran</option>
																<option value="Iceland">Iceland</option>
																<option value="Italy">Italy</option>
																<option value="Jamaica">Jamaica</option>
																<option value="Jordan">Jordan</option>
																<option value="Japan">Japan</option>
																<option value="Kenya">Kenya</option>
																<option value="Kyrgyzstan">Kyrgyzstan</option>
																<option value="Cambodia">Cambodia</option>
																<option value="Kiribati">Kiribati</option>
																<option value="Comoros">Comoros</option>
																<option value="St Kitts&Nevis">St Kitts&Nevis </option>
																<option value="North Korea">North Korea</option>
																<option value="South Korea">South Korea</option>
																<option value="Kuwait">Kuwait</option>
																<option value="Cayman Islands">Cayman Islands</option>
																<option value="Kazakhstan">Kazakhstan</option>
																<option value="Laos">Laos</option>
																<option value="Lebanon">Lebanon</option>
																<option value="St. Lucia">St. Lucia</option>
																<option value="Liechtenstein">Liechtenstein</option>
																<option value="Sri Lanka">Sri Lanka</option>
																<option value="Liberia">Liberia</option>
																<option value="Lesotho">Lesotho</option>
																<option value="Lithuania">Lithuania</option>
																<option value="Luxembourg">Luxembourg</option>
																<option value="Latvia">Latvia</option>
																<option value="Libya">Libya</option>
																<option value="Morocco">Morocco</option>
																<option value="Monaco">Monaco</option>
																<option value="Moldova">Moldova</option>
																<option value="Madagascar">Madagascar</option>
																<option value="Marshall Islnds">Marshall Islnds</option>
																<option value="Macedonia">Macedonia</option>
																<option value="Mali">Mali</option>
																<option value="Burma">Burma</option>
																<option value="Mongolia">Mongolia</option>
																<option value="Macau">Macau</option>
																<option value="N.Mariana Islnd">N.Mariana Islnd</option>
																<option value="Martinique">Martinique</option>
																<option value="Mauretania">Mauretania</option>
																<option value="Montserrat">Montserrat</option>
																<option value="Malta">Malta</option>
																<option value="Mauritius">Mauritius</option>
																<option value="Maldives">Maldives</option>
																<option value="Malawi">Malawi</option>
																<option value="Mexico">Mexico</option>
																<option value="Malaysia">Malaysia</option>
																<option value="Mozambique">Mozambique</option>
																<option value="Namibia">Namibia</option>
																<option value="New Caledonia">New Caledonia</option>
																<option value="Niger">Niger</option>
																<option value="Norfolk Islands">Norfolk Islands</option>
																<option value="Nigeria">Nigeria</option>
																<option value="Nicaragua">Nicaragua</option>
																<option value="Netherlands">Netherlands</option>
																<option value="Norway">Norway</option>
																<option value="Nepal">Nepal</option>
																<option value="Nauru">Nauru</option>
																<option value="NATO">NATO</option>
																<option value="Niue">Niue</option>
																<option value="New Zealand">New Zealand</option>
																<option value="Oman">Oman</option>
																<option value="Orange">Orange</option>
																<option value="Panama">Panama</option>
																<option value="Peru">Peru</option>
																<option value="Frenc.Polynesia">Frenc.Polynesia</option>
																<option value="Pap. New Guinea">Pap. New Guinea</option>
																<option value="Philippines">Philippines</option>
																<option value="Pakistan">Pakistan</option>
																<option value="Poland">Poland</option>
																<option value="St.Pier,Miquel.">St.Pier,Miquel.</option>
																<option value="Pitcairn Islnds">Pitcairn Islnds</option>
																<option value="Puerto Rico">Puerto Rico</option>
																<option value="Palestine">Palestine</option>
																<option value="Portugal">Portugal</option>
																<option value="Palau">Palau</option>
																<option value="Paraguay">Paraguay</option>
																<option value="Qatar">Qatar</option>
																<option value="Reunion">Reunion</option>
																<option value="Romania">Romania</option>
																<option value="Russian Fed.">Russian Fed.</option>
																<option value="Rwanda">Rwanda</option>
																<option value="Saudi Arabia">Saudi Arabia</option>
																<option value="Solomon Islands">Solomon Islands</option>
																<option value="Seychelles">Seychelles</option>
																<option value="Sudan">Sudan</option>
																<option value="Sweden">Sweden</option>
																<option value="Singapore">Singapore</option>
																<option value="Saint Helena">Saint Helena</option>
																<option value="Slovenia">Slovenia</option>
																<option value="Svalbard">Svalbard</option>
																<option value="Slovakia">Slovakia</option>
																<option value="Sierra Leone">Sierra Leone</option>
																<option value="San Marino">San Marino</option>
																<option value="Senegal">Senegal</option>
																<option value="Somalia">Somalia</option>
																<option value="Suriname">Suriname</option>
																<option value="S.Tome,Principe">S.Tome,Principe</option>
																<option value="El Salvador">El Salvador</option>
																<option value="Syria">Syria</option>
																<option value="Swaziland">Swaziland</option>
																<option value="Turksh Caicosin">Turksh Caicosin</option>
																<option value="Chad">Chad</option>
																<option value="French S.Territ">French S.Territ</option>
																<option value="Togo">Togo</option>
																<option value="Thailand">Thailand</option>
																<option value="Tajikistan">Tajikistan</option>
																<option value="Tokelau Islands">Tokelau Islands</option>
																<option value="East Timor">East Timor</option>
																<option value="Turkmenistan">Turkmenistan</option>
																<option value="Tunisia">Tunisia</option>
																<option value="Tonga">Tonga</option>
																<option value="East Timor">East Timor</option>
																<option value="Turkey">Turkey</option>
																<option value="Trinidad,Tobago">Trinidad,Tobago</option>
																<option value="Tuvalu">Tuvalu</option>
																<option value="Taiwan">Taiwan</option>
																<option value="Tanzania">Tanzania</option>
																<option value="Ukraine">Ukraine</option>
																<option value="Uganda">Uganda</option>
																<option value="Minor Outl.Isl.">Minor Outl.Isl.</option>
																<option value="United Nations">United Nations</option>
																<option value="USA">USA</option>
																<option value="Uruguay">Uruguay</option>
																<option value="Uzbekistan">Uzbekistan</option>
																<option value="Vatican City">Vatican City</option>
																<option value="St. Vincent">St. Vincent</option>
																<option value="Venezuela">Venezuela</option>
																<option value="Brit.Virgin Is.">Brit.Virgin Is.</option>
																<option value="Amer.Virgin Is.">Amer.Virgin Is.</option>
																<option value="Vietnam">Vietnam</option>
																<option value="Vanuatu">Vanuatu</option>
																<option value="Wallis,Futuna">Wallis,Futuna</option>
																<option value="Samoa">Samoa</option>
																<option value="Yemen">Yemen</option>
																<option value="Mayotte">Mayotte</option>
																<option value="South Africa">South Africa</option>
																<option value="Zambia">Zambia</option>
																<option value="Zimbabwe">Zimbabwe</option>
														
													</select>	
													{!! $errors->first('country', '<span class="errortext text-red">:message</span>') !!}
												</div>
											</div>
											@endforeach
											<h4 class="text-red"><i class="fa fa-envelope margin-r-5"></i> Communication</h4>
											
											<div class="form-group">
												<label for="inputPassword3" class="col-sm-2">Personal Mobile*</label>
												<div class="col-sm-4">
													<input type="text" class="form-control" placeholder="Mobile Phone" value="{{ $employee->personal_mobile }}" name="mobile" id="mobile" onkeypress="return isNumberKey(event)" required maxlength='10'>
													{!! $errors->first('mobile', '<span class="errortext text-red">:message</span>') !!}
												</div>
											</div>
											<div class="form-group">
												<label for="inputPassword3" class="col-sm-2">Personal Mail*</label>
												<div class="col-sm-4">
													<input type="email" class="form-control" placeholder="EmailId" value="{{ $employee->personalmail }}" name="personalmail" id="fax"  />
													{!! $errors->first('personalmail', '<span class="errortext text-red">:message</span>') !!}
												</div>
											</div>
											
											<br/><br/>
											<div class="form-group">
												<div class="col-sm-7"> 
													<input class="submitbtn btn btn-danger" type="submit" value="Update" id="submit" />
													<a href="{{ url('/employeezone/mydetails') }}" class="btn btn-warning">Cancel</a>
												</div> 
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

  @include('newemployeezone.footer')
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
