<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Employee Payslip</title>
	      <link rel="shortcut icon" href="{{ config('app.AWS_URL')}}/images/vgnfavicon.png" >
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{{ config('app.AWS_URL')}}/newcustomerzoneassets/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" type="text/css" href="{{ config('app.AWS_URL')}}/careersportal/employee-zone/payslip/style.css" />

  <link rel="stylesheet" type="text/css" href="{{ config('app.AWS_URL')}}/careersportal/assets-minified/helpers/helpers-all.css">
<link rel="stylesheet" type="text/css" href="{{ config('app.AWS_URL')}}/careersportal/assets-minified/elements/elements-all.css">
<link rel="stylesheet" type="text/css" href="{{ config('app.AWS_URL')}}/careersportal/assets-minified/icons/fontawesome/fontawesome.css">		
<link rel="stylesheet" type="text/css" href="{{ config('app.AWS_URL')}}/careersportal/assets-minified/snippets/snippets-all.css">
<!--<link rel="stylesheet" type="text/css" href="../assets-minified/applications/mailbox.css">
	
	<link rel="stylesheet" type="text/css" href="../assets-minified/demo-widgets.css">-->
<link rel="stylesheet" type="text/css" href="{{ config('app.AWS_URL')}}/careersportal/assets-minified/themes/supina/layout.css">

<link id="layout-color" rel="stylesheet" type="text/css" href="{{ config('app.AWS_URL')}}/careersportal/assets-minified/themes/supina/default/layout-color.css">
<link id="framework-color" rel="stylesheet" type="text/css" href="{{ config('app.AWS_URL')}}/careersportal/assets-minified/themes/supina/default/framework-color.css">
<link rel="stylesheet" type="text/css" href="{{ config('app.AWS_URL')}}/careersportal/assets-minified/themes/supina/border-radius.css">
<link rel="stylesheet" type="text/css" href="{{ config('app.AWS_URL')}}/careersportal/assets-minified/helpers/colors.css">
<link rel="stylesheet" type="text/css" href="{{ config('app.AWS_URL')}}/careersportal/assets/style.css">
<link rel="stylesheet" type="text/css" href="{{ config('app.AWS_URL')}}/careersportal/assets/emp-style.css">
<link rel="stylesheet" type="text/css" href="{{ config('app.AWS_URL')}}/careersportal/assets/jquery.dataTables.min.css">	
<link rel="stylesheet" href="{{ config('app.AWS_URL')}}/careersportal/assets/jquery-ui.css">

		<script type="text/javascript" src="{{ config('app.AWS_URL')}}/careersportal/assets-minified/js-core.js"></script>
<script type="text/javascript" src="{{ config('app.AWS_URL')}}/careersportal/assets/js-core/jquery-core.js"></script>
<script src="{{ config('app.AWS_URL')}}/careersportal/assets/jquery-ui.js"></script>
			<script type="text/javascript" src="{{ config('app.AWS_URL')}}/careersportal/assets/widgets/dropdown/dropdown.js"></script>
<!--<script type="text/javascript" src="../assets/js-core/jquery-ui-core.js"></script> 
<script type="text/javascript" src="../assets-minified/demo-widgets.js"></script>-->
<script type="text/javascript" src="{{ config('app.AWS_URL')}}/careersportal/assets/css-pop.js"></script>
<script type="text/javascript" src="{{ config('app.AWS_URL')}}/careersportal/assets/defines.js"></script>

<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
  <script type="text/javascript">
			$(window).load(function(){
			
				setTimeout(function() {
					$('#loading').fadeOut( 400, "linear" );
				}, 300);
				
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
			});
			
		</script>
		<style>
			  
		</style>
</head>
<body>


	<?php
									
				
				if(count($getpayslip) > 0)
				{
					
				
							
				//$slip=$result["response"]["Payslip_Details"];
					$slip = $getpayslip['result'];
				
					
			?>
		<table align="center"  border="0" cellpadding="0" cellspacing="0" id="printTable" data-editable="text" class="payslip">
<tr>
<!--background: rgba(0, 66, 123, 0.05)-->
	<td align="left"  valign="top" style="padding:10px 27px 10px 7px;;margin:0;background:#FFF;    border-bottom: 1px solid rgb(33, 33, 33)">
		<div class="head">
		<div class="logo col-md-2">
		<img src="{{ config('app.AWS_URL')}}/newcustomerzoneassets/payslip/vgn-logo.png">
		</div>
		<div class="titl col-md-6">
		<h2><?php echo $slip["Company_Code_Text"]?></h2>
		<h2><?php echo $slip["Payslip_Info"]?></h2>
		</div>
		<div class="print col-md-3 pull-right">
		<div class="pull-right glyph-icon demo-icon tooltip-button icon-print hidden-print" title="Print" onclick="print()" data-original-title=".icon-print"></div>
		<div class="visible-print pull-right"><?php echo "printed on" . date("d.m.y") ;?></div>
		</div>
		</div>
	</td>
</tr>
<tr>
<td>
	<div class="tbl1 col-md-6">
	<div class="frm-grp">
	<span class="col-md-6 labl">Employee  No</span>
	<span class="col-md-6 ans"><?php echo $slip["Employee_No"]?></span>
	</div>
	<div class="frm-grp">
	<span class="col-md-6 labl">Employee Name</span>
	<span class="col-md-6 ans"><?php echo $slip["Employee_Name"]?></span>
	</div>
	<div class="frm-grp">
	<span class="col-md-6 labl">Date of Joining</span>
	<span class="col-md-6 ans"><?php echo isset($slip["Date_of_Joining"])?substr($slip["Date_of_Joining"],6,2)."-".substr($slip["Date_of_Joining"],4,2)."-".substr($slip["Date_of_Joining"],0,4):"" ;?></span>
	</div>
	<div class="frm-grp">
	<span class="col-md-6 labl">UAN Number</span>
	<span class="col-md-6 ans"><?php echo $slip["PF_No"]?></span>
	</div>
	<div class="frm-grp">
	<span class="col-md-6 labl">Total Working Days</span>
	<span class="col-md-6 ans"><?php echo $slip["Total_Working_Days"]?></span>
	</div>
	<div class="frm-grp">
	<span class="col-md-6 labl">Monthly CTC</span>
	<span class="col-md-6 ans"><?php echo $slip["New_Basic_Salary"]?></span>
	</div>
	<div class="frm-grp">
	<span class="col-md-6 labl">Leave Taken</span>
	<span class="col-md-6 ans"><span>EL - <?php echo number_format((float)$slip["el"],1)?></span><span>SL - <?php echo number_format((float)$slip["sl"],1)?></span><span>CL - <?php echo number_format((float)$slip["cl"],1)?></span></span>
	</div>
<div class="frm-grp">
	<span class="col-md-6 labl"></span>
	<span class="col-md-6 ans"></span>
	</div>	
</div>
<div class="tbl2 col-md-6">
<div class="frm-grp">
<span class="col-md-6 labl">Department</span>
	<span class="col-md-6 ans"><?php echo $slip["Dept_Text"]?></span>
</div>
<div class="frm-grp">
	<span class="col-md-6 labl">Designation</span>
	<span class="col-md-6 ans"><?php echo $slip["Designation"]?></span>
</div>
	<div class="frm-grp">
	<span class="col-md-6 labl">Location	</span>
	<span class="col-md-6 ans"><?php echo $slip["Location"]?></span>
	</div>
	<div class="frm-grp">
	<span class="col-md-6 labl">Bank Name</span>
	<span class="col-md-6 ans"><?php echo $getpayslip['result']['Bank_Name']; ?></span>
	</div>
	<div class="frm-grp">
	<span class="col-md-6 labl">Bank A/c No</span>
	<span class="col-md-6 ans"><?php echo $slip["bankn"]?></span>
	</div>
	<div class="frm-grp">
	<span class="col-md-6 labl">Payable Days</span>
	<span class="col-md-6 ans"><?php echo $slip["Paid_Days"]?></span>
	</div>
	<div class="frm-grp">
	<span class="col-md-6 labl">ESI No / PAN No</span>
	<span class="col-md-6 ans"><?php echo $slip["ESI_No"]?> / <?php echo $slip["PAN_No"]?></span>
	</div>
	<div class="frm-grp">
	<span class="col-md-6 labl">Absent Days</span>	
	<span class="col-md-6 ans"><span>LOP - <?php echo number_format((float)$slip["LOP"],1)?></span><span>ABSENT - <?php echo number_format((float)$slip["Absent"],1)?></span></span>
	</div>
</div>
</td>
</tr>
<tr>
<td>
			<table class="salary"  width="100%" cellpadding="0" cellspacing="0" data-editable="text">
			<th>Earnings</th>
			<th>Deduction</th>
			<tr>
			<td>
			 <?php if(isset($slip["Basic_Salary"])&&($slip["Basic_Salary"] != 0.0))
			echo "<div class='frm-grp'>
				<span class='col-md-6 labl'> Basic Salary</span>	
				<span class='col-md-5 ans'>".number_format((float)$slip['Basic_Salary'],2)."</span>
			</div>";
			?>
			<?php if(isset($slip["HRA"])&&($slip["HRA"] != 0.0))
			echo "<div class='frm-grp'>
				<span class='col-md-6 labl'> House Rent Allowance</span>	
				<span class='col-md-5 ans'>".number_format((float)$slip['HRA'],2)."</span>
			</div>";
			?>
			<?php if(isset($slip["Conveyance_Allowance"])&&($slip["Conveyance_Allowance"] != 0.0))
			echo "<div class='frm-grp'>
				<span class='col-md-6 labl'> Conveyance Reimbursement</span>	
				<span class='col-md-5 ans'>".number_format((float)$slip['Conveyance_Allowance'],2)."</span>
			</div>";
			?>
			<?php if(isset($slip["Medical_Allowance"])&&($slip["Medical_Allowance"] != 0.0))
			echo "<div class='frm-grp'>
				<span class='col-md-6 labl'> Medical Allowance</span>	
				<span class='col-md-5 ans'>".number_format((float)$slip['Medical_Allowance'],2)."</span>
			</div>";
			?>
			<?php if(isset($slip["Special_Allowence"])&&($slip["Special_Allowence"] != 0.0))
			echo "<div class='frm-grp'>
				<span class='col-md-6 labl'> Special Allowance</span>	
				<span class='col-md-5 ans'>".number_format((float)$slip['Special_Allowence'],2)."</span>
			</div>";
			?>
			<?php if(isset($slip["LTA"])&&($slip["LTA"] != 0.0))
			echo "<div class='frm-grp'>
				<span class='col-md-6 labl'> LTA amount</span>	
				<span class='col-md-5 ans'>".number_format((float)$slip['LTA'],2)."</span>
			</div>";
			?>
			<?php if(isset($slip["Child_Education"])&&($slip["Child_Education"] != 0.0))
			echo "<div class='frm-grp'>
				<span class='col-md-6 labl'> Children Education Allow.</span>	
				<span class='col-md-5 ans'>".number_format((float)$slip['Child_Education'],2)."</span>
			</div>";
			?>
			<?php if(isset($slip["Food_Coupons"])&&($slip["Food_Coupons"] != 0.0))
			echo "<div class='frm-grp'>
				<span class='col-md-6 labl'> Food Coupons</span>	
				<span class='col-md-5 ans'>".number_format((float)$slip['Food_Coupons'],2)."</span>
			</div>";
			?>
			<?php if(isset($slip["Reimbursement"])&&($slip["Reimbursement"] != 0.0))
			echo "<div class='frm-grp'>
				<span class='col-md-6 labl'> Monthly Reimbursement</span>	
				<span class='col-md-5 ans'>".number_format((float)$slip['Reimbursement'],2)."</span>
			</div>";
			?>
			<?php if(isset($slip["Office_Wage_Allowance"])&&($slip["Office_Wage_Allowance"] != 0.0))
			echo "<div class='frm-grp'>
				<span class='col-md-6 labl'> Uniform Reimbursement</span>	
				<span class='col-md-5 ans'>".number_format((float)$slip['Office_Wage_Allowance'],2)."</span>
			</div>";
			?>
			<?php if(isset($slip["Salse_Incentive"])&&($slip["Salse_Incentive"] != 0.0))
			echo "<div class='frm-grp'>
				<span class='col-md-6 labl'> Sales Incentive</span>	
				<span class='col-md-5 ans'>".number_format((float)$slip['Salse_Incentive'],2)."</span>
			</div>";
			?>
				<?php if(isset($slip["Salse_Incentive1"])&&($slip["Salse_Incentive1"] != 0.0))
			echo "<div class='frm-grp'>
				<span class='col-md-6 labl'> Performance Incentive</span>	
				<span class='col-md-5 ans'>".number_format((float)$slip['Salse_Incentive1'],2)."</span>
			</div>";
			?>
			
			<?php if(isset($slip["Arrears"])&&($slip["Arrears"] != 0.0))
			echo "<div class='frm-grp'>
				<span class='col-md-6 labl'> Arrear</span>	
				<span class='col-md-5 ans'>".number_format((float)$slip['Arrears'],2)."</span>
			</div>";
			?>
			<?php if(isset($slip["Leave_Encashment"])&&($slip["Leave_Encashment"] != 0.0))
			echo "<div class='frm-grp'>
				<span class='col-md-6 labl'> Leave Encashment</span>	
				<span class='col-md-5 ans'>".number_format((float)$slip['Leave_Encashment'],2)."</span>
			</div>";
			?>
			<?php if(isset($slip["Consolidated_Pay"])&&($slip["Consolidated_Pay"] != 0.0))
			echo "<div class='frm-grp'>
				<span class='col-md-6 labl'> Consolidated Pay</span>	
				<span class='col-md-5 ans'>".number_format((float)$slip['Consolidated_Pay'],2)."</span>
			</div>";
			?>
			<?php if(isset($slip["Basic_Salary_Arrears"])&&($slip["Basic_Salary_Arrears"] != 0.0))
			echo "<div class='frm-grp'>
				<span class='col-md-6 labl'> Basic Arrears</span>	
				<span class='col-md-5 ans'>".number_format((float)$slip['Basic_Salary_Arrears'],2)."</span>
			</div>";
			?>
			
		<?php if(isset($slip["HRA_Arrears"])&&($slip["HRA_Arrears"] != 0.0))
			echo "<div class='frm-grp'>
				<span class='col-md-6 labl'> HRA Arrears</span>	
				<span class='col-md-5 ans'>".number_format((float)$slip['HRA_Arrears'],2)."</span>
			</div>";
			?>
			<?php if(isset($slip["Conveyance_Allowance_Arrears"])&&($slip["Conveyance_Allowance_Arrears"] != 0.0))
			echo "<div class='frm-grp'>
				<span class='col-md-6 labl'> Convy. Arrear</span>	
				<span class='col-md-5 ans'>".number_format((float)$slip['Conveyance_Allowance_Arrears'],2)."</span>
			</div>";
			?>
			<?php if(isset($slip["Medical_Allowance_Arrears"])&&($slip["Medical_Allowance_Arrears"] != 0.0))
			echo "<div class='frm-grp'>
				<span class='col-md-6 labl'> Medical Arrear</span>	
				<span class='col-md-5 ans'>".number_format((float)$slip['Medical_Allowance_Arrears'],2)."</span>
			</div>";
			?>
			<?php if(isset($slip["Special_Allowance_Arrears"])&&($slip["Special_Allowance_Arrears"] != 0.0))
			echo "<div class='frm-grp'>
				<span class='col-md-6 labl'> Special Allow. Arrear</span>	
				<span class='col-md-5 ans'>".number_format((float)$slip['Special_Allowance_Arrears'],2)."</span>
			</div>";
			?>
			<?php if(isset($slip["LTA_Arrears"])&&($slip["LTA_Arrears"] != 0.0))
			echo "<div class='frm-grp'>
				<span class='col-md-6 labl'> LTA Arrear</span>	
				<span class='col-md-5 ans'>".number_format((float)$slip['LTA_Arrears'],2)."</span>
			</div>";
			?>
			<?php if(isset($slip["Child_Education_Arrears"])&&($slip["Child_Education_Arrears"] != 0.0))
			echo "<div class='frm-grp'>
				<span class='col-md-6 labl'> Child Ed. Arrear</span>	
				<span class='col-md-5 ans'>".number_format((float)$slip['Child_Education_Arrears'],2)."</span>
			</div>";
			?>
			<?php if(isset($slip["Food_Coupons_Arrears"])&&($slip["Food_Coupons_Arrears"] != 0.0))
			echo "<div class='frm-grp'>
				<span class='col-md-6 labl'> Food coup. Arrear</span>	
				<span class='col-md-5 ans'>".number_format((float)$slip['Food_Coupons_Arrears'],2)."</span>
			</div>";
			?>
			<?php if(isset($slip["Reimbursement_Arrears"])&&($slip["Reimbursement_Arrears"] != 0.0))
			echo "<div class='frm-grp'>
				<span class='col-md-6 labl'> Reim. Arrear</span>	
				<span class='col-md-5 ans'>".number_format((float)$slip['Reimbursement_Arrears'],2)."</span>
			</div>";
			?>
			<?php if(isset($slip["Office_Wage_Allowance_Arrears"])&&($slip["Office_Wage_Allowance_Arrears"] != 0.0))
			echo "<div class='frm-grp'>
				<span class='col-md-6 labl'>OWA Arrear</span>	
				<span class='col-md-5 ans'>".number_format((float)$slip['Office_Wage_Allowance_Arrears'],2)."</span>
			</div>";
			?>
			<?php if(isset($slip["Performance_Incentive_Arrears"])&&($slip["Performance_Incentive_Arrears"] != 0.0))
			echo "<div class='frm-grp'>
				<span class='col-md-6 labl'> Consolidated Pay Arrear</span>	
				<span class='col-md-5 ans'>".number_format((float)$slip['Performance_Incentive_Arrears'],2)."</span>
			</div>";
			?>
			
			<?php if(isset($slip["Award"])&&($slip["Award"] != 0.0))
			echo "<div class='frm-grp'>
				<span class='col-md-6 labl'> Award</span>	
				<span class='col-md-5 ans'>".number_format((float)$slip['Award'],2)."</span>
			</div>";
			?>
			
		
			</td>
			<td>
				<?php if(isset($slip["Employee_ESI"])&&($slip["Employee_ESI"] != 0.0))
				echo "<div class='frm-grp'>
				<span class='col-md-8 labl'>ESI contribution</span>	
				<span class='col-md-4 ans'>".number_format((float)$slip['Employee_ESI'],2)."</span>
			</div>";
			?>
			<?php if(isset($slip["Provident_Fund"])&&($slip["Provident_Fund"] != 0.0))
			echo "<div class='frm-grp'>
				<span class='col-md-8 labl'> PF contribution</span>	
				<span class='col-md-4 ans'>".number_format((float)$slip['Provident_Fund'],2)."</span>
			</div>";
			?>
			<?php if(isset($slip["Professional_Tax"])&&($slip["Professional_Tax"] != 0.0))
			echo "<div class='frm-grp'>
				<span class='col-md-8 labl'>Prof Tax</span>	
				<span class='col-md-4 ans'>".number_format((float)$slip['Professional_Tax'],2)."</span>
			</div>";
			?>
			<?php if(isset($slip["Income_Tax"])&&($slip["Income_Tax"] != 0.0))
			echo "<div class='frm-grp'>
				<span class='col-md-8 labl'> Income Tax</span>	
				<span class='col-md-4 ans'>".number_format((float)$slip['Income_Tax'],2)."</span>
			</div>";
			?>
			<?php if(isset($slip["Salary_Advance_LoanAdvance"])&&($slip["Salary_Advance_LoanAdvance"] != 0.0))
				echo "<div class='frm-grp'>
				<span class='col-md-8 labl'>Salary Adv. Recovery</span>	
				<span class='col-md-4 ans'>".number_format((float)$slip['Salary_Advance_LoanAdvance'],2)."</span>
			</div>";
			?>
			<?php if(isset($slip["Mobile_Deduction"])&&($slip["Mobile_Deduction"] != 0.0))
			echo "<div class='frm-grp'>
				<span class='col-md-8 labl'> Mobile Deduction</span>	
				<span class='col-md-4 ans'>".number_format((float)$slip['Mobile_Deduction'],2)."</span>
			</div>";
			?>
			<?php if(isset($slip["Other_Deduction_MiscellenousDed"])&&($slip["Other_Deduction_MiscellenousDed"] != 0.0))
			echo "<div class='frm-grp'>
				<span class='col-md-8 labl'>Misc. Deduction</span>	
				<span class='col-md-4 ans'>".number_format((float)$slip['Other_Deduction_MiscellenousDed'],2)."</span>
			</div>";
			?>
			<?php if(isset($slip["Meal_Vouchers"])&&($slip["Meal_Vouchers"] != 0.0))
			echo "<div class='frm-grp'>
				<span class='col-md-8 labl'> Meal Voucher</span>	
				<span class='col-md-4 ans'>".number_format((float)$slip['Meal_Vouchers'],2)."</span>
			</div>";
			?>
			<?php if(isset($slip["Notice_Pay_Recovery"])&&($slip["Notice_Pay_Recovery"] != 0.0))
				echo "<div class='frm-grp'>
				<span class='col-md-8 labl'>Notice Pay Recovery</span>	
				<span class='col-md-4 ans'>".number_format((float)$slip['Notice_Pay_Recovery'],2)."</span>
			</div>";
			?>
			<?php if(isset($slip["Fixed_Tax_10_Deductions"])&&($slip["Fixed_Tax_10_Deductions"] != 0.0))
			echo "<div class='frm-grp'>
				<span class='col-md-8 labl'> Fixed Tax 10% Deductions</span>	
				<span class='col-md-4 ans'>".number_format((float)$slip['Fixed_Tax_10_Deductions'],2)."</span>
			</div>";
			?>
			<?php if(isset($slip["Fixed_Tax_10_CarryFwd"])&&($slip["Fixed_Tax_10_CarryFwd"] != 0.0))
			echo "<div class='frm-grp'>
				<span class='col-md-8 labl'>Fixed Tax 10% Carry Fwd</span>	
				<span class='col-md-4 ans'>".number_format((float)$slip['Fixed_Tax_10_CarryFwd'],2)."</span>
			</div>";
			?>
			<?php if(isset($slip["Loan"])&&($slip["Loan"] != 0.0))
			echo "<div class='frm-grp'>
				<span class='col-md-8 labl'> Loan Deduction</span>	
				<span class='col-md-4 ans'>".number_format((float)$slip['Loan'],2)."</span>
			</div>";
			?>
				<?php if(isset($slip["Find_Deduction"])&&($slip["Find_Deduction"] != 0.0))
			echo "<div class='frm-grp'>
				<span class='col-md-8 labl'> Fine Deduction</span>	
				<span class='col-md-4 ans'>".number_format((float)$slip['Find_Deduction'],2)."</span>
			</div>";
			?>
			</td>
			</tr>
			<tr><td><br/></td></tr><tr><td></td></tr>
			<tfoot>
			<tr style="border:1px solid;">
			<td>
			
			<?php if(isset($slip["Total_Earnings"]))
			echo "<div class='frm-grp'>
				<span class='col-md-6 labl'> Total Earnings</span>	
				<span class='col-md-5 ans'>".number_format((float)$slip['Total_Earnings'],2)."</span>
			</div>";
			?>
			
			</td>
			<td>
			<?php if(isset($slip["Total_Deduction"]))
			echo "<div class='frm-grp'>
				<span class='col-md-8 labl'> Total Deduction</span>	
				<span class='col-md-4 ans'>".number_format((float)$slip['Total_Deduction'],2)."</span>
			</div>";
			?>
			
			</td>
			
			</tr>
			
			<tr>
			<td>
			</td>
			<td>
			<?php if(isset($slip["Net_Salary"]))
			echo "<div class='frm-grp'>
				<span class='col-md-8 labl'> Net Pay</span>	
				<span class='col-md-4 ans'>".number_format((float)$slip['Net_Salary'],2)."</span>
			</div>";
			?>
			
			</td>
			</tr>
			</tfoot>
			</table>
</td>
</tr>
</table>
<div class="ftr">(This is system generated Payslip,hence signature not required)</div>
		<?php
											
			
		
				
			}
			else
		{
			
			
			echo '<script type="text/javascript">alert("Invalid selection!!!");window.close();</script>';
			//var_dump($result);
		}
				
				
			
			
				
			?>
	
</body>
</html>
