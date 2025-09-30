@extends('newemployeezone.layout')

@section('title')
VGN Projects Estates Pvt Ltd |Employee Zone| View Payslip Page
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
		<h2 style="margin-top:0px; font-size:21px;text-transform: uppercase;"><?php echo $getpayslip['result']['Company_Code_Text']; ?></h2>
		<p><?php echo $getpayslip['result']['Payslip_Info']; ?></p>
		
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
	<span class="col-md-6 labl">Employee No</span>
	<span class="col-md-6 ans"><?php if($getpayslip['result']['Employee_No'] != ''){ echo ltrim($getpayslip['result']['Employee_No'], '0'); } ?></span>
	</div>
	<div class="frm-grp">
	<span class="col-md-6 labl">Employee Name</span>
	<span class="col-md-6 ans"><?php if($getpayslip['result']['Employee_Name'] != ''){ echo $getpayslip['result']['Employee_Name']; } ?></span>
	</div>
	<div class="frm-grp">
	<span class="col-md-6 labl">Date of Joining</span>
	<span class="col-md-6 ans">
	<?php if($getpayslip['result']["Date_of_Joining"] != '')
{ echo substr($getpayslip['result']["Date_of_Joining"],6,2)."-".substr($getpayslip['result']["Date_of_Joining"],4,2)."-".substr($getpayslip['result']["Date_of_Joining"],0,4); }else{ echo "-" ; } ?></span>
	</div>
	<div class="frm-grp">
	<span class="col-md-6 labl">UAN Number</span>
	<span class="col-md-6 ans"><?php if($getpayslip['result']['PF_No'] != ''){ echo $getpayslip['result']['PF_No']; } ?></span>
	</div>
	<div class="frm-grp">
	<span class="col-md-6 labl">Total Working Days</span>
	<span class="col-md-6 ans"><?php echo $getpayslip['result']['Total_Working_Days']; ?></span>
	</div>
	<div class="frm-grp">
	<span class="col-md-6 labl">Monthly CTC</span>
	<span class="col-md-6 ans"><?php echo $getpayslip['result']['New_Basic_Salary']; ?></span>
	</div>
	<div class="frm-grp">
	<span class="col-md-6 labl">Leave Taken</span>
	<span class="col-md-6 ans">
	    
	    <span>EL - <?php echo number_format((float)$getpayslip['result']["el"],1)?></span>&nbsp;<span>SL - <?php echo number_format((float)$getpayslip['result']["sl"],1)?></span>&nbsp;<span>CL - <?php echo number_format((float)$getpayslip['result']["cl"],1)?></span>
	    
	</span>
	</div>

<div class="frm-grp">
	<span class="col-md-6 labl"></span>
	<span class="col-md-6 ans"></span>
	</div>
		
</div>
<div class="tbl2 col-md-6 col-xs-6">
<div class="frm-grp">
<span class="col-md-6 labl">Department</span>
	<span class="col-md-6 ans"><?php echo $getpayslip['result']['Dept_Text']; ?></span>
</div>
<div class="frm-grp">
	<span class="col-md-6 labl">Designation</span>
	<span class="col-md-6 ans"><?php echo $getpayslip['result']['Designation']; ?></span>
</div>
	
	<div class="frm-grp">
	<span class="col-md-6 labl">Location</span>
	<span class="col-md-6 ans"><?php echo $getpayslip['result']['Location']; ?></span>
	</div>
	<div class="frm-grp">
	<span class="col-md-6 labl">Bank Name</span>
	<span class="col-md-6 ans"><?php echo $getpayslip['result']['Bank_Name']; ?></span>
	</div>
	<div class="frm-grp">
	<span class="col-md-6 labl">Bank A/c No</span>
	<span class="col-md-6 ans"><?php echo $getpayslip['result']['bankn']; ?></span>
	</div>
	<div class="frm-grp">
	<span class="col-md-6 labl">Payable Days</span>
	<span class="col-md-6 ans"><?php echo $getpayslip['result']['Paid_Days']; ?></span>
	</div>
	<div class="frm-grp">
	<span class="col-md-6 labl">ESI No / PAN No</span>	
	<span class="col-md-6 ans"><?php echo $getpayslip['result']["ESI_No"]?> / <?php echo $getpayslip['result']["PAN_No"]?></span>
	
	</div>
	<div class="frm-grp">
	<span class="col-md-6 labl">Absnt Days</span>
	<span class="col-md-6 ans">
	    <span>LOP - <?php echo number_format((float)$getpayslip['result']["LOP"],1)?></span>&nbsp;<span>ABSENT - <?php echo number_format((float)$getpayslip['result']["Absent"],1)?></span>
	</span>
	</div>
	
	
</div>
</td>
</tr>


<tr>
<td>
  <div class="row">
   <div class="col-md-6 col-xs-6">
    <table width="100%" cellpadding="0" cellspacing="0" data-editable="text" id="csstable">
			<thead>
			<tr>
			<th colspan="2" style="text-align:center;">Earnings</th>
			
			</tr></thead>
			<tbody>
        <?php if(isset($getpayslip['result']["Basic_Salary"])&&($getpayslip['result']["Basic_Salary"] != 0.0))
			echo "<tr>
				<td> Basic Salary</td>	
				<td>".number_format((float)$getpayslip['result']['Basic_Salary'],2)."</td>
			</tr>";
			?>
			<?php if(isset($getpayslip['result']["HRA"])&&($getpayslip['result']["HRA"] != 0.0))
			echo "<tr>
				<td> House Rent Allowance</td>	
				<td>".number_format((float)$getpayslip['result']['HRA'],2)."</td>
			</tr>";
			?>
			<?php if(isset($getpayslip['result']["Conveyance_Allowance"])&&($getpayslip['result']["Conveyance_Allowance"] != 0.0))
			echo "<tr>
				<td> Coveyance Reimbursement</td>	
				<td>".number_format((float)$getpayslip['result']['Conveyance_Allowance'],2)."</td>
			</tr>";
			?>
			<?php if(isset($getpayslip['result']["Medical_Allowance"])&&($getpayslip['result']["Medical_Allowance"] != 0.0))
			echo "<tr>
				<td> Medical Allowance</td>	
				<td>".number_format((float)$getpayslip['result']['Medical_Allowance'],2)."</td>
			</tr>";
			?>
			<?php if(isset($getpayslip['result']["Special_Allowence"])&&($getpayslip['result']["Special_Allowence"] != 0.0))
			echo "<tr>
				<td> Special Allowance</td>	
				<td>".number_format((float)$getpayslip['result']['Special_Allowence'],2)."</td>
			</tr>";
			?>
			<?php if(isset($getpayslip['result']["LTA"])&&($getpayslip['result']["LTA"] != 0.0))
			echo "<tr>
				<td> LTA amount</td>	
				<td>".number_format((float)$getpayslip['result']['LTA'],2)."</td>
			</tr>";
			?>
			<?php if(isset($getpayslip['result']["Child_Education"])&&($getpayslip['result']["Child_Education"] != 0.0))
			echo "<tr>
				<td> Children Education Allow.</td>	
				<td>".number_format((float)$getpayslip['result']['Child_Education'],2)."</td>
			</tr>";
			?>
			<?php if(isset($getpayslip['result']["Food_Coupons"])&&($getpayslip['result']["Food_Coupons"] != 0.0))
			echo "<tr>
				<td> Food Coupons</td>	
				<td>".number_format((float)$getpayslip['result']['Food_Coupons'],2)."</td>
			</tr>";
			?>
			<?php if(isset($getpayslip['result']["Reimbursement"])&&($getpayslip['result']["Reimbursement"] != 0.0))
			echo "<tr>
				<td> Monthly Reimbursement</td>	
				<td>".number_format((float)$getpayslip['result']['Reimbursement'],2)."</td>
			</tr>";
			?>
			<?php if(isset($getpayslip['result']["Office_Wage_Allowance"])&&($getpayslip['result']["Office_Wage_Allowance"] != 0.0))
			echo "<tr>
				<td> Uniform Reimbursement</td>	
				<td>".number_format((float)$getpayslip['result']['Office_Wage_Allowance'],2)."</td>
			</tr>";
			?>
			<?php if(isset($getpayslip['result']["Salse_Incentive"])&&($getpayslip['result']["Salse_Incentive"] != 0.0))
			echo "<tr>
				<td> Sales Incentive</td>	
				<td>".number_format((float)$getpayslip['result']['Salse_Incentive'],2)."</td>
			</tr>";
			?>
				<?php if(isset($getpayslip['result']["Salse_Incentive1"])&&($getpayslip['result']["Salse_Incentive1"] != 0.0))
			echo "<tr>
				<td> Performance Incentive</td>	
				<td>".number_format((float)$getpayslip['result']['Salse_Incentive1'],2)."</td>
			</tr>";
			?>
			
			<?php if(isset($getpayslip['result']["Arrears"])&&($getpayslip['result']["Arrears"] != 0.0))
			echo "<tr>
				<td> Arrear</td>	
				<td>".number_format((float)$getpayslip['result']['Arrears'],2)."</td>
			</tr>";
			?>
			<?php if(isset($getpayslip['result']["Leave_Encashment"])&&($getpayslip['result']["Leave_Encashment"] != 0.0))
			echo "<tr>
				<td> Leave Encashment</td>	
				<td>".number_format((float)$getpayslip['result']['Leave_Encashment'],2)."</td>
			</tr>";
			?>
			<?php if(isset($getpayslip['result']["Consolidated_Pay"])&&($getpayslip['result']["Consolidated_Pay"] != 0.0))
			echo "<tr>
				<td> Consolidated Pay</td>	
				<td>".number_format((float)$getpayslip['result']['Consolidated_Pay'],2)."</td>
			</tr>";
			?>
			<?php if(isset($getpayslip['result']["Basic_Salary_Arrears"])&&($getpayslip['result']["Basic_Salary_Arrears"] != 0.0))
			echo "<tr>
				<td> Basic Arrears</td>	
				<td>".number_format((float)$getpayslip['result']['Basic_Salary_Arrears'],2)."</td>
			</tr>";
			?>
			
		<?php if(isset($getpayslip['result']["HRA_Arrears"])&&($getpayslip['result']["HRA_Arrears"] != 0.0))
			echo "<tr>
				<td> HRA Arrears</td>	
				<td>".number_format((float)$getpayslip['result']['HRA_Arrears'],2)."</td>
			</tr>";
			?>
			<?php if(isset($getpayslip['result']["Conveyance_Allowance_Arrears"])&&($getpayslip['result']["Conveyance_Allowance_Arrears"] != 0.0))
			echo "<tr>
				<td> Convy. Arrear</td>	
				<td>".number_format((float)$getpayslip['result']['Conveyance_Allowance_Arrears'],2)."</td>
			</tr>";
			?>
			<?php if(isset($getpayslip['result']["Medical_Allowance_Arrears"])&&($getpayslip['result']["Medical_Allowance_Arrears"] != 0.0))
			echo "<tr>
				<td> Medical Arrear</td>	
				<td>".number_format((float)$getpayslip['result']['Medical_Allowance_Arrears'],2)."</td>
			</tr>";
			?>
			<?php if(isset($getpayslip['result']["Special_Allowance_Arrears"])&&($getpayslip['result']["Special_Allowance_Arrears"] != 0.0))
			echo "<tr>
				<td> Special Allow. Arrear</td>	
				<td>".number_format((float)$getpayslip['result']['Special_Allowance_Arrears'],2)."</td>
			</tr>";
			?>
			<?php if(isset($getpayslip['result']["LTA_Arrears"])&&($getpayslip['result']["LTA_Arrears"] != 0.0))
			echo "<tr>
				<td> LTA Arrear</td>	
				<td>".number_format((float)$getpayslip['result']['LTA_Arrears'],2)."</td>
			</tr>";
			?>
			<?php if(isset($getpayslip['result']["Child_Education_Arrears"])&&($getpayslip['result']["Child_Education_Arrears"] != 0.0))
			echo "<tr>
				<td> Child Ed. Arrear</td>	
				<td>".number_format((float)$getpayslip['result']['Child_Education_Arrears'],2)."</td>
			</tr>";
			?>
			<?php if(isset($getpayslip['result']["Food_Coupons_Arrears"])&&($getpayslip['result']["Food_Coupons_Arrears"] != 0.0))
			echo "<tr>
				<td> Food coup. Arrear</td>	
				<td>".number_format((float)$getpayslip['result']['Food_Coupons_Arrears'],2)."</td>
			</tr>";
			?>
			<?php if(isset($getpayslip['result']["Reimbursement_Arrears"])&&($getpayslip['result']["Reimbursement_Arrears"] != 0.0))
			echo "<tr>
				<td> Reim. Arrear</td>	
				<td>".number_format((float)$getpayslip['result']['Reimbursement_Arrears'],2)."</td>
			</tr>";
			?>
			<?php if(isset($getpayslip['result']["Office_Wage_Allowance_Arrears"])&&($getpayslip['result']["Office_Wage_Allowance_Arrears"] != 0.0))
			echo "<tr>
				<td>OWA Arrear</td>	
				<td>".number_format((float)$getpayslip['result']['Office_Wage_Allowance_Arrears'],2)."</td>
			</tr>";
			?>
			<?php if(isset($getpayslip['result']["Performance_Incentive_Arrears"])&&($getpayslip['result']["Performance_Incentive_Arrears"] != 0.0))
			echo "<tr>
				<td> Consolidated Pay Arrear</td>	
				<td>".number_format((float)$getpayslip['result']['Performance_Incentive_Arrears'],2)."</td>
			</tr>";
			?>
			
			<?php if(isset($getpayslip['result']["Award"])&&($getpayslip['result']["Award"] != 0.0))
			echo "<tr>
				<td> Award</td>	
				<td>".number_format((float)$getpayslip['result']['Award'],2)."</td>
			</tr>";
			?>
			
			<?php if(isset($getpayslip['result']["Total_Earnings"]))
			echo "<tr style='font-weight:bold;'>
				<td> Total Earnings</td>	
				<td>".number_format((float)$getpayslip['result']['Total_Earnings'],2)."</td>
			</tr>";
			?>
			
        </tbody>
    </table>    	
			
</div>
   <div class="col-md-6 col-xs-6">
   <table width="100%" cellpadding="0" cellspacing="0" data-editable="text" id="csstable">
			<thead>
			<tr>
			<th colspan="2" style="text-align:center;">Deduction</th>
			</tr></thead>
			<tbody>
       
       <?php if(isset($getpayslip['result']["Employee_ESI"])&&($getpayslip['result']["Employee_ESI"] != 0.0))
				echo "<dtr>
				<td>ESI contribution</td>	
				<td>".number_format((float)$getpayslip['result']['Employee_ESI'],2)."</td>
			</tr>";
			?>
			<?php if(isset($getpayslip['result']["Provident_Fund"])&&($getpayslip['result']["Provident_Fund"] != 0.0))
			echo "<tr>
				<td> PF contribution</td>	
				<td>".number_format((float)$getpayslip['result']['Provident_Fund'],2)."</td>
			</tr>";
			?>
			<?php if(isset($getpayslip['result']["Professional_Tax"])&&($getpayslip['result']["Professional_Tax"] != 0.0))
			echo "<tr>
				<td>Prof Tax</td>	
				<td>".number_format((float)$getpayslip['result']['Professional_Tax'],2)."</td>
			</tr>";
			?>
			<?php if(isset($getpayslip['result']["Income_Tax"])&&($getpayslip['result']["Income_Tax"] != 0.0))
			echo "<tr>
				<td> Income Tax</td>	
				<td>".number_format((float)$getpayslip['result']['Income_Tax'],2)."</td>
			</tr>";
			?>
			<?php if(isset($getpayslip['result']["Salary_Advance_LoanAdvance"])&&($getpayslip['result']["Salary_Advance_LoanAdvance"] != 0.0))
				echo "<tr>
				<td>Salary Adv. Recovery</td>	
				<td>".number_format((float)$getpayslip['result']['Salary_Advance_LoanAdvance'],2)."</td>
			</tr>";
			?>
			<?php if(isset($getpayslip['result']["Mobile_Deduction"])&&($getpayslip['result']["Mobile_Deduction"] != 0.0))
			echo "<tr>
				<td> Mobile Deduction</td>	
				<td>".number_format((float)$getpayslip['result']['Mobile_Deduction'],2)."</td>
			</tr>";
			?>
			<?php if(isset($getpayslip['result']["Other_Deduction_MiscellenousDed"])&&($getpayslip['result']["Other_Deduction_MiscellenousDed"] != 0.0))
			echo "<tr>
				<td>Misc. Deduction</td>	
				<td>".number_format((float)$getpayslip['result']['Other_Deduction_MiscellenousDed'],2)."</td>
			</tr>";
			?>
			<?php if(isset($getpayslip['result']["Meal_Vouchers"])&&($getpayslip['result']["Meal_Vouchers"] != 0.0))
			echo "<tr>
				<td> Meal Voucher</td>	
				<td>".number_format((float)$getpayslip['result']['Meal_Vouchers'],2)."</td>
			</tr>";
			?>
			<?php if(isset($getpayslip['result']["Notice_Pay_Recovery"])&&($getpayslip['result']["Notice_Pay_Recovery"] != 0.0))
				echo "<tr>
				<td>Notice Pay Recovery</td>	
				<td>".number_format((float)$getpayslip['result']['Notice_Pay_Recovery'],2)."</td>
			</tr>";
			?>
			<?php if(isset($getpayslip['result']["Fixed_Tax_10_Deductions"])&&($getpayslip['result']["Fixed_Tax_10_Deductions"] != 0.0))
			echo "<tr>
				<td> Fixed Tax 10% Deductions</td>	
				<td>".number_format((float)$getpayslip['result']['Fixed_Tax_10_Deductions'],2)."</td>
			</tr>";
			?>
			<?php if(isset($getpayslip['result']["Fixed_Tax_10_CarryFwd"])&&($getpayslip['result']["Fixed_Tax_10_CarryFwd"] != 0.0))
			echo "<tr>
				<td>Fixed Tax 10% Carry Fwd</td>	
				<td>".number_format((float)$getpayslip['result']['Fixed_Tax_10_CarryFwd'],2)."</td>
			</tr>";
			?>
			<?php if(isset($getpayslip['result']["Loan"])&&($getpayslip['result']["Loan"] != 0.0))
			echo "<tr>
				<td> Loan Deduction</td>	
				<td>".number_format((float)$getpayslip['result']['Loan'],2)."</td>
			</tr>";
			?>
				<?php if(isset($getpayslip['result']["Find_Deduction"])&&($getpayslip['result']["Find_Deduction"] != 0.0))
			echo "<tr>
				<td> Fine Deduction</td>	
				<td>".number_format((float)$getpayslip['result']['Find_Deduction'],2)."</td>
			</tr>";
			?>
       <?php if(isset($getpayslip['result']["Total_Deduction"]))
			echo "<tr style='font-weight:bold;'>
				<td> Total Deduction</td>	
				<td>".number_format((float)$getpayslip['result']['Total_Deduction'],2)."</td>
			</tr>";
			?>
        </tbody>
    </table>   
    </div>
    </div>
</td>
</tr>
<tr>
    <td>
        <div class="row" >
    
    <div class="col-md-4 col-md-offset-4 col-xs-4 col-xs-offset-4">
          <div class="info-box" style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);border: 1px solid #A9A9A9;">
            <span class="info-box-icon bg-red"><i class="fa fa-rupee"></i></span>

            <div class="info-box-content">
              
              <?php if(isset($getpayslip['result']["Net_Salary"]))
			echo "
				<span class='info-box-text'>Net Pay</span>	
				<span class='info-box-number' id='gross'>".number_format((float)$getpayslip['result']['Net_Salary'],2)."</span>
			";
			?>
              </div>
        </div>
            </div>
        </div>
        <div class="row" style="text-align:center;">
            <h5>(This is system generated Payslip,hence signature not required)</h5>
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
                
                title:'View Payslip',
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
