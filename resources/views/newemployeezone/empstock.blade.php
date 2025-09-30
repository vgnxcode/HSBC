@extends('newemployeezone.layout')

@section('title')
VGN Projects Estates Pvt Ltd |Employee Zone| Employee Stocks Loans & Advances Page
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
    
    .box-header.with-border {
    border-bottom: 1px solid #f4f4f4;
    background: #dd4b39;
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
                <h3 class="box-title"><i class="fa fa-ticket margin-r-5"></i> MY STOCK & LOANS </h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              
              
              <div class="box box-danger">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-list-ul margin-r-5"></i> Stock Details </h3>
                
                
                
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              
                             
                
                
                
                   <div class="row" style="margin-left:3px;">
                       <div class="col-md-12">
                           
                          <table id="example1" class="display nowrap" cellspacing="0" width="100%">
        <thead>
            <tr>
                 <th>S. No.</th>
				<th>Material Code</th>
				<th>Material Description</th>
				<th>Quantity</th>
            </tr>
        </thead>
       
        <tbody>
           <?php 
												if(isset($vgn_stock['STOCK_DETAILS'])) {
													$tmp=array();
													if(array_key_exists('S_No', $vgn_stock['STOCK_DETAILS']))
													{
														$tmp[]=$vgn_stock['STOCK_DETAILS'];
														$vgn_stock['STOCK_DETAILS']=$tmp;
													}
													$loans=$vgn_stock['STOCK_DETAILS'];
													if(!empty($loans[0]["S_No"]))
													{
													foreach($vgn_stock['STOCK_DETAILS'] as $i=>$stock)
													{
														echo "<tr><td>".($i+1)."</td><td>".$stock['Material_No']."</td><td>".$stock['Material_Description']."</td><td>".$stock['Total_Quantity']."</td></tr>";
														
													}
													}
													else
													{
													echo "<tr><td colspan='4'>No record found</td></tr>".(isset($error)?$error:"");
													}
												}
												else{
																				
												echo "<tr><td colspan='4'>No record found</td></tr>";
												//var_dump($vgn_careers);
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
            <!-- /.box-body -->
          </div>

  
         
         
          
          
          <div class="box box-danger">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-list-ul margin-r-5"></i> Loan Details </h3>
                
                
                
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              
                             
                
                
                
                   <div class="row" style="margin-left:3px;">
                       <div class="col-md-12">
                           
                          <table id="example2" class="display nowrap" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>S. No.</th>
				<th>Posting Date</th>
				<th>Doc No</th>
				<th>Total Loan & Advance Issued</th>
				<th>Loan & Advance Recovered</th>
            </tr>
        </thead>
       
        <tbody>
           
          <?php 
												if(isset($vgn_stock['LOAN_DETAILS'])) {
                          //var_dump($vgn_stock['LOAN_DETAILS']);
													$tmp=array();
													if(array_key_exists('S_No', $vgn_stock['LOAN_DETAILS']))
													{
														$tmp[]=$vgn_stock['LOAN_DETAILS'];
														$vgn_stock['LOAN_DETAILS']=$tmp;
													}
													$totalIss=(float)0.00;
													$totalRec=(float)0.00;
													$issued=(float)0.00;
													$recovered=(float)0.00;
													$loans=$vgn_stock['LOAN_DETAILS'];
													if(!empty($loans[0]["S_No"]))
													{
													foreach($vgn_stock['LOAN_DETAILS'] as $i=>$stock)
													{
														$issued=number_format((float)$stock['Total_Loan_Advance_Issued'],2,'.','');
														$recovered=number_format((float)$stock['Loan_Advance_Recovered'],2,'.','');
														//if($stock['Total_Loan_Advance_Issued']=="Invoice")
														$totalIss+=$issued;
														//if($stock['Loan_Advance_Recovered']=="Payment")
														$totalRec+=$recovered;
														echo "<tr><td>".($i+1)."</td><td>".date_format( date_create($stock['Posting_Date']),"Y-m-d")."</td><td>".$stock['Doc_No']."</td><td>".number_format((float)$stock['Total_Loan_Advance_Issued'])."</td><td>".number_format((float)$stock['Loan_Advance_Recovered'])."</td></tr>";
													}
													}
													else
													{
													echo "<tr><td colspan='5'>No record found</td></tr>";
													}
													
												}
												else{
												
																				
												echo "<tr><td colspan='5'>No record found</td></tr>";
												//var_dump($vgn_careers);
											}
												?>
												<tr ><td colspan="2" align="left"></td><td><hl><strong>Total:</strong></hl></td><td align='left'>
													<hl><?php if(isset($totalIss))echo number_format($totalIss); ?></hl></td><td align='left'><hl><?php if(isset($totalRec))echo number_format($totalRec); ?></hl></td></tr>       
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
    var table = $('#example1').DataTable( {
        "order": [[ 0, "asc" ]],
        rowReorder: false,
        responsive: true,
        paging:false
    } );
    
     var table = $('#example2').DataTable( {
        "order": [[ 1, "desc" ]],
        rowReorder: false,
        responsive: true,
        paging:false
    } );
    
    
} );    
    
</script>




@endsection
