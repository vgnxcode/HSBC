@extends('newemployeezone.layout')

@section('title')
VGN Projects Estates Pvt Ltd |Employee Zone| Employee Lead Followup Page
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
                <h3 class="box-title"><i class="fa fa-star margin-r-5"></i> Sales Lead Followup - {{ $selectedplant }}</h3>
                <span class="pull-right"><a href="/employeezone/leadsfollowup" class="btn btn-danger btn-xs"><i class="fa fa-backward margin-r-5"></i>Leads Followup Homepage</a></span>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              
              @if($show_mngr_link == '1')
                <div class="row" id="main">
                <div class="col-sm-12 ">

                  <div class="row">
                  <div class="col-sm-4 col-sm-offset-4">
                   <a href="{{ url('/employeezone/getleadstypedata/hot')}}">
                    <div class="info-box card">
                      <div class="info-box-content">
                        <h4>Hot Leads(Site Visit Completed)</h4>
                        
                      </div>
                    </div>   
                             </a>        
                  </div>
                </div>
                  <div class="row">
                  <div class="col-sm-4 col-sm-offset-4">
                  <a href="{{ url('/employeezone/getleadstypedata/warm')}}">
                   <div class="info-box card">
                      <div class="info-box-content">
                        <h4>Warm Leads(Site Visit Scheduled)</h4>
                        
                      </div>
                    </div>
                    </a>
                  </div>
                </div>
                  <div class="row">
                  <div class="col-sm-4 col-sm-offset-4">
                    <a href="{{ url('/employeezone/getleadstypedata/underfollowup')}}">
                    <div class="info-box card">
                      <div class="info-box-content">
                        <h4>Under Followup Leads(Fresh Leads)</h4>
                        
                      </div>
                    </div>
                    </a>
                  </div>
                </div>
                  <div class="row">
                  <div class="col-sm-4 col-sm-offset-4">
                    <a href="{{ url('/employeezone/requestforcoldapproval')}}">
                    <div class="info-box card">
                      <div class="info-box-content">
                        <h4>Request for Cold Approval</h4>
                        
                      </div>
                    </div>
                    </a>
                  </div>
                  </div>

                  <div class="row">
                  <div class="col-sm-4 col-sm-offset-4">
                    <a href="{{ url('/employeezone/todayfollowup')}}">
                    <div class="info-box card">
                      <div class="info-box-content">
                        <h4>Today's Followup Report</h4>
                        
                      </div>
                    </div>
                    </a>
                  </div>
                  </div>

                </div>
                
                </div>
                @endif

                @if($show_mngr_link == '0')
                <div class="row" id="main">
                <div class="col-sm-8 col-sm-offset-2 ">
                  <div class="row">
                  <div class="col-sm-4 col-sm-offset-4">
                   <a href="{{ url('/employeezone/getleadstypedata/hot')}}">
                    <div class="info-box card">
                      <div class="info-box-content">
                        <h4>Hot Leads(Site Visit Completed)</h4>
                        
                      </div>
                    </div>   
                             </a>        
                  </div>
                  </div>
                  <div class="row">
                  <div class="col-sm-4 col-sm-offset-4">
                  <a href="{{ url('/employeezone/getleadstypedata/warm')}}">
                   <div class="info-box card">
                      <div class="info-box-content">
                        <h4>Warm Leads(Site Visit Scheduled)</h4>
                        
                      </div>
                    </div>
                    </a>
                  </div>
                  </div>

                  <div class="row">
                  <div class="col-sm-4 col-sm-offset-4">
                    <a href="{{ url('/employeezone/getleadstypedata/underfollowup')}}">
                    <div class="info-box card">
                      <div class="info-box-content">
                        <h4>Under Followup Leads(Fresh Leads)</h4>
                        
                      </div>
                    </div>
                    </a>
                  </div>
                  </div>
                  
                  <div class="row">
                  <div class="col-sm-4 col-sm-offset-4">
                    <a href="{{ url('/employeezone/todayfollowup')}}">
                    <div class="info-box card">
                      <div class="info-box-content">
                        <h4>Today's Followup Report</h4>
                        
                      </div>
                    </div>
                    </a>
                  </div>
                  </div>
                  
                </div>
                
                </div>
                @endif
                
                
                   
                            
                                
                
              

              
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
