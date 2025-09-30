@extends('newemployeezone.layout')

@section('title')
VGN Projects Estates Pvt Ltd |Employee Zone| Online Payment Response Page
@endsection

@section('description')
    <meta name="description" content="">
@endsection

@section('keyword')  
@endsection


@section('style')

<!--<link rel="stylesheet" type="text/css" href="{{ asset('/newcustomerzoneassets/payslip/style.css') }}" />-->
        <link rel="shortcut icon" href="{{ config('app.AWS_URL')}}/images/vgnfavicon.png" >
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{{ config('app.AWS_URL')}}/newcustomerzoneassets/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ config('app.AWS_URL')}}/newcustomerzoneassets/bower_components/font-awesome/css/font-awesome.min.css">
 <!-- Theme style -->
  <link rel="stylesheet" href="{{ config('app.AWS_URL')}}/newcustomerzoneassets/dist/css/AdminLTE.min.css">



		<style>
            
            .bg-red{
                background-color: #ed1c24!important;
            }
            .titl h2 {
    font-size: 18px;
    text-align: center;
    line-height: 1.5;
                color: #fff;
}
            .logo img
{
	    background: #fff;
		padding: 5px;
		border-radius: 6px;
	}
            table.payslip {
    border: 2px solid #000;
	    
    background-repeat: no-repeat;
    background-size: cover;
	font-size: 14px;
	width:60%
}
			.titl p {
    font-size: 16px;
    text-align: center;
    line-height: 1;
    color: #fff;

    }

    .imptext {
    font-size: 14px;
    text-align: center;
    line-height: 1.5;
    color: #000;

    }
	
	table#csstable {
		border: 1px solid #000;
		margin: 10px 0px;
	}

	table#csstable caption {

		font-size: 16px;
		font-weight: bold;
		border-top: 1px solid #000;
		text-align: center;
    	padding: 5px;
    	background: #fd5c63;
        color: #fff;
	}
     table#csstable thead th {
     	border: 1px solid #000;
    	text-align: center;
    	padding: 5px;
    	background: #ed1c24;
         color: #fff;
    }

     table#csstable tbody tr td {
     	border: 1px solid #000;
    	text-align: center;
    	padding: 3px;
    	background: #fff;
    }
            .demo-icon {
    font-size: 22px;
    line-height: 40px;
    float: left;
    width: 40px;
    height: 40px;
    margin: 10px;
    text-align: center;
    color: #fff;
    border: 1px solid #fafafa;
    border-radius: 3px;
}
            .demo-icon:hover {
    color: #fff;
    cursor: pointer;
            }
		</style>

<script>
	function print() {
    printData();
}
function printData()
{
   var divToPrint=document.getElementById("printTable");
   newWin= window.open("");
   newWin.document.write(divToPrint.outerHTML);
   newWin.print();
   newWin.close();
}
</script>
@endsection

@section('bodycontent')
<body class="hold-transition skin-red fixed sidebar-mini">

<!-- Site wrapper -->


@foreach($getemployeedata as $employee)
@if(count($getpayslip) > 0)
<table align="center"  border="0" cellpadding="0" cellspacing="0" id="printTable" data-editable="text" class="payslip">
<tr>
	<td align="left"  valign="top" style="padding:8px 27px 10px 7px;;margin:0;background: #ed1c24;    border-bottom: 1px solid rgb(33, 33, 33)">
		<div class="head">
		<div class="logo col-md-2 col-xs-2">
		<img src="{{ config('app.AWS_URL')}}/newcustomerzoneassets/payslip/vgn-logo.png" class="vgnlogo">
		</div>
		<div class="titl col-md-9 col-xs-9">
		<h2 style="margin-top:0px; font-size:21px;text-transform: uppercase;">VGN Property Developers Pvt. Ltd.</h2>
		<p>Online Payment Invoice</p>
		
		</div>
		<div class="print col-md-1 col-xs-1 pull-right">
		<div class="pull-right glyph-icon demo-icon tooltip-button icon-print hidden-print" title="Print" data-original-title=".icon-print" id="clickprint" style="border: 1px solid #ccc;"> <i class="fa fa-print"></i></div>
		
		<div class="visible-print pull-right"><?php echo "printed on" . date("d.m.y") ;?></div>
		</div>
		</div>
	</td>
</tr>

<tr>
<td style="padding-top:14px;">
	<div class="tbl1 col-md-6 col-xs-6">
	<div class="frm-grp">
	<span class="col-md-6 labl">CustomerId</span>
	<span class="col-md-6 ans">{{$customerid}}</span>
	</div>
	<div class="frm-grp">
	<span class="col-md-6 labl">Customer Name</span>
	<span class="col-md-6 ans">{{$customername}}</span>
	</div>
	<div class="frm-grp">
	<span class="col-md-6 labl">Application Number</span>
	<span class="col-md-6 ans">{{$appno}}</span>
	</div>
	<div class="frm-grp">
	<span class="col-md-6 labl">Reference Number</span>
	<span class="col-md-6 ans">{{$reference_number}}</span>
	</div>

  <div class="frm-grp">
	<span class="col-md-6 labl">Payment Description</span>
	<span class="col-md-6 ans">{{$paymentdescription}}</span>
	</div>
	
		
</div>
<div class="tbl2 col-md-6 col-xs-6">
<div class="frm-grp">
<span class="col-md-6 labl">Project Name</span>
	<span class="col-md-6 ans">{{$projectname}}</span>
</div>
<div class="frm-grp">
	<span class="col-md-6 labl">Unit Name</span>
	<span class="col-md-6 ans">{{$unitname}}</span>
</div>
	
<div class="frm-grp">
	<span class="col-md-6 labl">Payment Amount</span>
	<span class="col-md-6 ans">{{$paymentamount}}</span>
	</div>
	<div class="frm-grp">
	<span class="col-md-6 labl">Payment Date</span>
	<span class="col-md-6 ans">{{$payment_date}}</span>
	</div>
	<div class="frm-grp">
	<span class="col-md-6 labl">Payment Status</span>
	<span class="col-md-6 ans">{{$paymentstatus}}</span>
	</div>
	
	
</div>
</td>
</tr>



<tr>
    <td>
        
        <div class="row" style="text-align:center;">
            <h5>(This is system generated Payment Message)</h5>
        </div>
    </td>
</tr>

</table>
 @endif
 
@endforeach


@endsection

@section('script')
<!-- jQuery 3 -->
<script src="{{ config('app.AWS_URL')}}/newcustomerzoneassets/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{ config('app.AWS_URL')}}/newcustomerzoneassets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="{{ config('app.AWS_URL')}}/newcustomerzoneassets/dist/js/payslip/printPreview.js"></script>



<script type="text/javascript">
        $(function(){
            
           
            
            $("#clickprint").printPreview({
                obj2print:'#printTable',
                
                title:'View Payment Message',
                resizable : 'yes'
                
                /*optional properties with default values*/
                //obj2print:'body',     /*if not provided full page will be printed*/
                //style:'',             /*if you want to override or add more css assign here e.g: "<style>#masterContent:background:red;</style>"*/
                //width: '670',         /*if width is not provided it will be 670 (default print paper width)*/
                //height:screen.height, /*if not provided its height will be equal to screen height*/
                //top:0,                /*if not provided its top position will be zero*/
                //left:'center',        /*if not provided it will be at center, you can provide any number e.g. 300,120,200*/
                //resizable : 'yes',    /*yes or no default is yes, * do not work in some browsers*/
                //scrollbars:'yes',     /*yes or no default is yes, * do not work in some browsers*/
                //status:'no',          /*yes or no default is yes, * do not work in some browsers*/
                //title:'Print Preview' /*title of print preview popup window*/
                
            });
              
        });
    </script>


@endsection
