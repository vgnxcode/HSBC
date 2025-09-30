@extends('newemployeezone.layout')

@section('title')
VGN Projects Estates Pvt Ltd |Employee Zone| Employee Plant Select Leads Followup Page
@endsection

@section('description')
    <meta name="description" content="">
@endsection

@section('keyword')  
@endsection


@section('style')
@include('newemployeezone.styles.commoncss')

<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/rowreorder/1.2.3/css/rowReorder.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.0/css/responsive.dataTables.min.css">


<style>
	  .card {
  box-shadow: 0 3px 6px rgba(0,0,0,0.16), 0 3px 6px rgba(0,0,0,0.23);
}
    .card:hover {
  box-shadow: 0 14px 28px rgba(0,0,0,0.25), 0 10px 10px rgba(0,0,0,0.22);
}
    #test li{
        list-style-type: none;
            margin-bottom: 5px;
    }
   div.info-box-content p {
  margin: 20px 0px;
  
    }
    div.info-box.card{
  background-color: #dd4b39;    
    }
    .info-box-content {
    padding: 5px;
    
}
.info-box-content {
  text-align: center;
  margin-left: 0px;
}

 .info-box-content h4 {
    margin-top: 9px;
    font-size: 14px;
    
}
.info-box {
  min-height: 25px;
  }
#main a{
  color: #fff;
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
		
    <div class="col-md-12">
      
      <div class="box box-danger">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-star margin-r-5"></i> Sales Lead Followup </h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">

                
                <div class="row" id="main">
                <div class="col-sm-8 col-sm-offset-2 ">
                  <form action="" method="post" accept-charset="utf-8">
                    {{csrf_field()}}

                    <div class="row" style="margin-left: 3px;">
                      
                      <div class="form-group">
                        <label for="plantcode" class="col-sm-2 " style="margin-top: 5px;">Plant Code</label>
                        <div class="col-sm-4">
                          <select class="form-control userdropdown" name="plantcode" id="plantcode">
                            <option value="">Select*</option> 
                            @foreach($listplant as $kk)
                            <option value="{{$kk}}">{{$kk}}</option>
                            @endforeach
                            
                          </select>
                          {!! $errors->first('plantcode', '<span class="errortext text-red">:message</span>') !!}
                        </div>
                      </div>


                      <br/><br/>
                      <div class="form-group">
                        <div class="col-sm-8 col-sm-offset-2"> 
                          <input class="submitbtn btn btn-danger" type="submit" value="Submit" id="submit" />
                          <a href="{{ url('/customerzone/newdashboard') }}" class="btn btn-warning">Cancel</a>
                        </div> 
                      </div>


                    </div>
                                      
                  </form>
                                    
                 
                  
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
   function stripslashes(str) {
str=str.replace(/\\'/g,'\'');
str=str.replace(/\\"/g,'"');
str=str.replace(/\\0/g,'\0');
str=str.replace(/\\\\/g,'\\');
return str;
}
    
    
    
    
</script>





@endsection
