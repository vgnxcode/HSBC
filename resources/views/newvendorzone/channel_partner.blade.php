@extends('newcustomerzone.layout')

@section('title')
VGN Property Developers |Vendor Zone| My Bank Details Page
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
  #mobile_no{
    display: inline-block;
    width: 72.8%;
  }
  .cc-picker{
    top: -1.4px;
    padding: 7.7px;
    border: 1px solid #d2d6de;
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
                <h3 class="box-title"><i class="fa fa-edit margin-r-5"></i> Create Leads</h3>
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
               <form id="changedetailsForm" method="POST" action="{{ url('/vendorzone/channel_partner_leadcreation') }}" class="form-horizontal" >
                {{ csrf_field() }}
                   <div class="row" style="margin-left:3px;">
                       <div class="col-md-12">
                           <h4 class="text-red"> <i class="fa fa-info-circle margin-r-5"></i> Lead Information </h4>
                            
                             
                                <div class="form-group">
                        <label for="lead_name" class="col-sm-2 ">Name*</label>
                        <div class="col-sm-4">
                          <input type="text" class="form-control" value="@if(!empty(old('lead_name'))){{old('lead_name')}}@endif" name="lead_name" id="lead_name" placeholder="Lead Name" required>
                          {!! $errors->first('lead_name', '<span class="errortext text-red">:message</span>') !!}
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="mobile_no" class="col-sm-2 ">Mobile No*</label>
                        <div class="col-sm-4">
                          <input type="text" class="form-control" value="{{ old('mobile_no') }}" name="mobile_no" id="mobile_no" class="phone-field" placeholder="Mobile Number" maxlength="10" required>
                          {!! $errors->first('mobile_no', '<span class="errortext text-red">:message</span>') !!}
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="emailid" class="col-sm-2 ">EmailId*</label>
                        <div class="col-sm-4">
                          <input type="email" class="form-control" value="@if(!empty(old('emailid'))){{old('emailid')}}@endif" name="emailid" id="emailid" placeholder="Email-Id"  required>
                          {!! $errors->first('emailid', '<span class="errortext text-red">:message</span>') !!}
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="city" class="col-sm-2">City*</label>
                        <div class="col-sm-4">
                          <input type="text" class="form-control" value="@if(!empty(old('city'))){{old('city')}}@endif" name="city" id="city" placeholder="City"  required>
                          {!! $errors->first('city', '<span class="errortext text-red">:message</span>') !!}
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="message" class="col-sm-2">Message</label>
                        
                          <div class="col-sm-4">
                            
                          <textarea name="message" id="message" class="form-control" rows="4" column="30" placeholder="Message (Optional)"></textarea>
                          <div id="textarea_feedback" class="text-muted pull-right"></div>
                          {!! $errors->first('message', '<span class="errortext text-red">:message</span>') !!}
                          </div>                  
                        
                      </div>

                      <div class="form-group">
                        <label for="project" class="col-sm-2">Select Project*</label>
                        
                          <div class="col-sm-4">
                            
                          <select class="form-control" name="project" id="project" required>
                            <option value="">Select</option>
                            @if(count($campaign_details) > 0)
                            @foreach($campaign_details as $camp)
                            <option value="{{$camp['Plant_ID']}}" "@if(old('project') == $camp['Plant_ID']) selected=selected @endif">VGN {{$camp['Plant_Name']}}</option>
                            @endforeach
                            @endif
                          </select>
                          {!! $errors->first('project', '<span class="errortext text-red">:message</span>') !!}
                          </div>                  
                        
                      </div>
                      
                      
                      <br/><br/>
                      <div class="form-group">
                        <div class="col-sm-8 col-sm-offset-2"> 
                          <input class="submitbtn btn btn-danger" type="submit" value="Submit" id="submit" />
                          <a href="{{ url('/vendorzone/dashboard') }}" class="btn btn-warning">Cancel</a>
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

  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 2.4.0
    </div>
    <strong>Copyright &copy; 2019 <a href="http://www.vgn.in">VGN Projects Estates Pvt. Ltd</a>.</strong> All rights
    reserved.
  </footer>

  
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
    $("#mobile_no").CcPicker({"countryCode":"in"});
    $('.sidebar-menu').tree();

      var text_max = 90;
    $('#textarea_feedback').html(text_max + ' characters left');

    $('#message').keyup(function() {
        var text_length = $('#message').val().length;
        var text_remaining = text_max - text_length;

        $('#textarea_feedback').html(text_remaining + ' characters left');
    });

        $('#lead_name, #branch_name').on('keyup',function(){
        $(this).val($(this).val().toUpperCase());
      });


      $('#mobile_no').keyup(function(e){
        var value = $(this).val();
        value = value.replace(/\D/g, "");//.split(/(?:([\d]{4}))/g).filter(s => s.length > 0).join("-");
        $(this).val(value);
    }); 
   

  });
</script>
@endsection