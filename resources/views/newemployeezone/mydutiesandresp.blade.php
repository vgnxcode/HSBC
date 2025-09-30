@extends('newemployeezone.layout')

@section('title')
VGN Projects Estates Pvt Ltd |Employee Zone| Employee Duties and Responsibilities Page
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
	.carousel-inner>.item>img
	{
		min-height: 280px;
	}
    #changedetailsForm label.col-sm-2 {
        font-weight: normal;
    }
    .modal-header{
        background-color: #EF5350;
        color: #fff;
        font-weight: bold;
    }
    .marg_left{
        margin-left: 10px;
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
                <h3 class="box-title"><i class="fa fa-check margin-r-5"></i> My Duties and Responsibilities </h3>
                
                
                
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              
               <div class="col-md-12 space">
											
												<span name="st-desc" id="st-desc"></span>
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

<script>
    function removedots(str) {
    // var i = 0;
    // return str.replace(/\./g, function() {
    //     return ++i >= 2 ? '' : '.';
    // });
    var arr=str.split('.');
    var string='';
    $.each(arr,function(index,value){if(value!=='')string+=value+'<br><br>';})
    return string;
}
$(document).ready(function() {
                var data = <?php echo json_encode($resp); ?>;
				desc="";
				$.each(data,function(index,value){
				desc+=value;
				});
				
				
				
				desc=removedots(desc);
				
				$('#st-desc').html(desc);
				// $('#st-desc').html('<ul><li></li><li>'+(stripslashes(desc).replace(/\./g ,"</li><li>"))+'</li></ul>');
				//$('#st-desc').html(desc);
				//console.log(data);
		
    
    
} );    
    
</script>




@endsection
