@extends('newemployeezone.layout')

@section('title')
VGN Projects Estates Pvt Ltd |Employee Zone| Employee Memos and Fine Deduction Page
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
                <h3 class="box-title"><i class="fa fa-list-ul margin-r-5"></i> MY MEMO ISSUES </h3>
                
                
                
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
                
                
                
                
                   <div class="row" style="margin-left:3px;">
                       <div class="col-md-12">
                           
                          <table id="example" class="display nowrap" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>S. No.</th>
				<th>Reason For Memo</th>
				<th>Date Of Issue</th>
            </tr>
        </thead>
       
        <tbody>
           
           <?php
                                                if(!empty($memo_array))
                                                {
                                                    $i = 0;
                                                    foreach($memo_array as $i=>$memo)
													{
                                                        if(!array_filter($memo)) {
    echo '<tr ><td colspan="3">No result found.</td></tr>';
}
                                                        else
                                                        {
														echo "<tr><td>".($i+1)."</td><td>".$memo['Reason_Memo']."</td><td>".substr($memo['Date_of_Issue'],6,2)."-".substr($memo['Date_of_Issue'],4,2)."-".substr($memo['Date_of_Issue'],0,4)."</td></tr>";
                                                        }
														
													}
                                                }
                                                    ?>         
        </tbody>
    </table>           
                                             
                       </div>
                   </div>
                            
                                
                
              

              
            </div>
            <!-- /.box-body -->
          </div>
          
          
          <div class="box box-danger">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-list-ul margin-r-5"></i> MY FINE DEDUCTIONS </h3>
                
                
                
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              
                             
                
                
                
                   <div class="row" style="margin-left:3px;">
                       <div class="col-md-12">
                           
                          <table id="example1" class="display nowrap" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>S. No.</th>
				<th>Reason for Fine</th>
				<th>Date of Issue</th>
				<th>Fine Amount</th>
            </tr>
        </thead>
       
        <tbody>
           
           <?php
                                                   if(!empty($fine_array))
                                                {
                                                       $i = 0;
                                                    foreach($fine_array as $i=>$fine)
													{
                                                        if(!array_filter($fine)) {
    echo '<tr ><td colspan="3">No result found.</td></tr>';
}
                                                        else
                                                        {
														echo "<tr><td>".($i+1)."</td><td>".$fine['REASON']."</td><td>".substr($fine['ISSUE_DATE'],6,2)."-".substr($fine['ISSUE_DATE'],4,2)."-".substr($fine['ISSUE_DATE'],0,4)."</td><td>".$fine['FINE_AMOUNT']."</td></tr>";
                                                        }
														
													}
                                                }
                                                    ?>         
        </tbody>
    </table>           
                                             
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
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js" ></script>
<script src="https://cdn.datatables.net/rowreorder/1.2.3/js/dataTables.rowReorder.min.js" ></script>
<script src="https://cdn.datatables.net/responsive/2.2.0/js/dataTables.responsive.min.js" ></script>
<script>
$(document).ready(function() {
    var table = $('#example').DataTable( {
        "order": [[ 2, "desc" ]],
        rowReorder: false,
        responsive: false,
        paging:false
    } );
    
     var table = $('#example1').DataTable( {
        "order": [[ 2, "desc" ]],
        rowReorder: false,
        responsive: false,
        paging:false
    } );
    
    
} );    
    
</script>




@endsection
