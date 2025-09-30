@extends('customer-zone.layout')

@section('title')
VGN Property Developers |Customer Zone| Refer Friend Page
@endsection

@section('description')
    <meta name="description" content="">
@endsection

@section('keyword')  
@endsection

@section('stylesheet')
	<link rel="stylesheet" href="{{ asset('assets/css/normalize.css') }}">
    <script src="{{ asset('portal/assets-minified/js-core.js') }}"></script>
    <script src="{{ asset('portal/loader.js') }}"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('portal/assets-minified/helpers/helpers-all.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('portal/assets-minified/elements/elements-all.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('portal/assets-minified/icons/fontawesome/fontawesome.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('portal/assets-minified/icons/linecons/linecons.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('portal/assets-minified/snippets/snippets-all.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('portal/assets-minified/applications/mailbox.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('portal/assets-minified/themes/supina/layout.css') }}">
	<link id="layout-color" rel="stylesheet" type="text/css" href="{{ asset('portal/assets-minified/themes/supina/default/layout-color.css') }}">
	<link id="framework-color" rel="stylesheet" type="text/css" href="{{ asset('portal/assets-minified/themes/supina/default/framework-color.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('portal/assets-minified/themes/supina/border-radius.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('portal/assets-minified/helpers/colors.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('portal/assets-minified/demo-widgets.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('portal/assets/style.css') }}">
	<script type="text/javascript" src="{{ asset('portal/assets/defines.js') }}"></script>
	<script type="text/javascript" src="{{ asset('portal/assets-minified/demo-widgets.js') }}"></script>
    <style>
			  #loading {position: fixed;width: 100%;height: 100%;left: 0;top: 0;right: 0;bottom: 0;display: block;background: #fff;z-index: 10000;}
			#loading img {position: absolute;top: 50%;left: 50%;margin: -23px 0 0 -23px;}
			body{background: url(/portal/assets/pattern.jpg) repeat;}
			.submitbtn
			{
				margin-left:32%;
			}
             .errortext
			{
				color: red;
			}
</style>
<script type="text/javascript">
		function isNumberKey(evt)
          {
             var charCode = (evt.which) ? evt.which : event.keyCode
             if (charCode > 31 && (charCode < 48 || charCode > 57))
                return false;
 
             return true;
          }
		  
		  function checkNum()
		{
			if ((event.keyCode > 64 && event.keyCode < 91) || (event.keyCode > 96 && event.keyCode < 123) || event.keyCode == 8 || event.keyCode == 46 || event.keyCode == 32)
				return true;
			else
			{
				return false;
			}
 
		}
		
		function validateEmail()
      {
         var emailID = document.myForm.email.value;
         atpos = emailID.indexOf("@");
         dotpos = emailID.lastIndexOf(".");
         
         if (atpos < 1 || ( dotpos - atpos < 2 )) 
         {
            //alert("Please enter correct email ID")
			document.getElementById("emailerr").innerHTML="Enter Valid Email Address";
            document.myForm.email.focus() ;
            return false;
         }
		 else
		 {
			document.getElementById("emailerr").innerHTML="";
            
		 }
         return( true );
      }

		</script>


@endsection

@section('header')
    
@endsection

@section('content')


<div id="loading">
		<img src="{{url('portal/assets-minified/images/spinner/loader-dark.gif')}}" alt="Loading...">
</div>
	<div id="sb-site">
	@foreach($getcustomerdata as $customerdata)
		<div id="page-wrapper">
			@include('customer-zone.header.index')
			@include('customer-zone.sidebar')
			<div id="page-content-wrapper" class="rm-transition">

				<div id="page-content">
					<div class="row">
						@include('customer-zone.content-top')
						
                    <div class="col-md-12">


                        <div class="content-box mrg25T mrg25B">
								<h3 class="content-box-header content-box-header-alt bg-white">	
									<span class="icon-separator"><i class="glyph-icon icon-group"></i></span>
									<div class="header-wrapper">My Referrals</div>
								</h3>
								<div class="content-box-wrapper">
                                <form name="myForm" method="POST" action="{{ url('/customerzone/referfriend') }}">
                                {{ csrf_field() }}
								<div class="col-sm-10 col-sm-offset-1">
									@if(session()->has('error_msg'))
											<err>{{Session::get('error_msg')}}</err>
									@endif
                                    @if(session()->has('suc_msg'))
											<suc>{{Session::get('suc_msg')}}</suc>
									@endif
                                    </div>
										<table class="tblalign" style="width:65%">
										
										<tr >
											<td><label for="referralname">Name of the Prospect</label></td>
											<td><input type="text" class="form-control" id="unit-no" placeholder="Name of the Prospect" name='name' required>{!! $errors->first('name', '<span class="errortext">:message</span>') !!}</td>
										</tr>
										
										<tr >
											<td><label for="telephoneno">Mobile No</label></td>
											<td><input type="text" class="form-control" id="nature-comp" placeholder="Mobile No" onkeypress="return isNumberKey(event)" name='mobile'  required maxlength='10'>{!! $errors->first('mobile', '<span class="errortext">:message</span>') !!}</td>
										</tr>	
										<tr >
											<td><label for="email">Email ID</label></td>
										<td><input type="text" class="form-control" onblur="validateEmail(this.value)" id="nature-comp" placeholder="Email ID" name='email' required>{!! $errors->first('email', '<span class="errortext">:message</span>') !!}</td>
										<td><span id="emailerr" style="color:red;display: inline-block;vertical-align: -webkit-baseline-middle;"> </span></td>
										</tr>
										<tr >
											<td><label for="projname">Interested Project</label></td>         
											<td><select class="form-control userdropdown" name='intr' required>
												  <option value="">Select</option>   
												  @foreach($ongoingprojects as $k=>$ongoing)
                                                  <option value="{{$ongoing['Project_No']}}">{{$ongoing['Project_Name']}}</option>
                                                  @endforeach
												</select>
                                                {!! $errors->first('intr', '<span class="errortext">:message</span>') !!}
											</td>
										</tr>
										<tr >
											<td></td>
										<td align="center"><input class="btn btn-blue-alt" type="submit" id="submit" value="Refer"/><span class="submitbtn "></span><a href="{{ url('customerzone/dashboard') }}" style="background-color:#65a6ff;color: #fff;padding: 9px;border-radius: 3px;">Cancel</a></td>
										</tr>
																																
										</table>
										
										
									</form>        
                        
                                </div>
                        </div>
                    </div>					
						
					</div>
					
				</div>
				
			</div>
		</div>
	@endforeach
	</div>



@endsection