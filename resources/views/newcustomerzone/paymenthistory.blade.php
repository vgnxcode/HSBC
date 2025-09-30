@extends('newcustomerzone.layout')

@section('title')
VGN Projects Estates Pvt Ltd |Customer Zone| Payment History Page
@endsection

@section('description')
    <meta name="description" content="">
@endsection

@section('keyword')  
@endsection


@section('style')
@include('newcustomerzone.styles.commoncss')

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


<?php
if(strpos($customer->net_amt,'-') !== false){
  $netamt = 0;
}
else{
  $netamt = $customer->net_amt;
}
?>
	<div class="row">
		
    <div class="col-md-12">
      
      <div class="box box-danger">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-rupee margin-r-5"></i> Payment History </h3><span class="pull-right text-red" style="font-weight:bold;" >Net Balance: {{ $netamt }}</span>
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
                
                
                <form id="changedetailsForm" method="POST" action="{{ url('/customerzone/changemydetails') }}" class="form-horizontal" >
                {{ csrf_field() }}
                   <div class="row" style="margin-left:3px;">
                       <div class="col-md-12">
                           
                          <table id="example" class="display nowrap" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>S.No</th>
                <th>Posting Date</th>
				<th>Document Number</th>
				<th>Invoice Amount</th>
				<th>Payment Amount</th>
            </tr>
        </thead>
         
        <tbody>
           
            @if(count($payment) > 0)
			    <?php 
															$i = 0;
															$totalInv=(float)0.00;
															$totalPay=(float)0.00;
															$Payment=(float)0.00;
															?>
															@foreach($payment as $pay)
																<?php
																$Payment=number_format((float)$pay->inv_amt,2,'.','');
																
																if($pay->pay_type =="Invoice")//Payment_Amount
																$totalInv+=$Payment;
																if($pay->pay_type =="Payment")
																$totalPay+=$Payment;
																echo "<tr><td>".($i+1)."</td><td>".$pay->posteddate."</td><td>".$pay->doc_no."</td><td align='right'>";
																if($pay->pay_type =="Invoice")
																echo $Payment;
																echo "</td><td align='right'>";
																if($pay->pay_type =="Payment")
																echo $Payment;
																echo "</td></tr>";
																$i++;
																?>
															@endforeach										
            @endif            
        </tbody>
         @if(count($payment) > 0)
        <tfoot>
            <tr>
                <th style="color:transparent;">S.No</th>
                <th style="color:transparent;">Posting Date</th>
				<th style="text-align:right;"><strong>Total:</strong></th>
				<th style="text-align:right;"><?php echo number_format((float)$totalInv,2,'.',''); ?></th>
				<th style="text-align:right;"><?php echo number_format((float)$totalPay,2,'.',''); ?></th>
            </tr>
        </tfoot>
        @endif
    </table>
    <i>Disclaimer:</i> All payments are subject to realization.
											<br/><br/>                       
        
											<br/><br/>           
                                             
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

<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js" ></script>
<script src="https://cdn.datatables.net/rowreorder/1.2.3/js/dataTables.rowReorder.min.js" ></script>
<script src="https://cdn.datatables.net/responsive/2.2.0/js/dataTables.responsive.min.js" ></script>
<script>
$(document).ready(function() {
    var table = $('#example').DataTable( {
        
        "order": [[ 1, "desc" ]],
        rowReorder: false,
        responsive: true
    } );
} );    
</script>


@endsection
