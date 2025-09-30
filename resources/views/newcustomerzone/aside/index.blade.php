<!-- =============================================== -->

  <!-- Left side column. contains the sidebar -->
  <aside class="main-sidebar control-sidebar-light">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
   
     
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
        
        <li id="dashboard"><a href="{{ url('/')}}/customerzone/dashboard/{{$customer->id}}" ><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
        <li id="mydetails"><a href="{{ url('/')}}/customerzone/mydetails" ><i class="fa fa-user"></i> <span>My Details</span></a></li>
        <li id="mybankdetails"><a href="{{ url('/')}}/customerzone/mybankdetails" ><i class="fa fa-bank"></i> <span>My Bank Details</span></a></li>
        <li id="communication"><a href="{{ url('/')}}/customerzone/communication" ><i class="fa fa-envelope"></i> <span>Communications</span></a></li>
        <li id="complaints"><a href="{{ url('/')}}/customerzone/complaints" ><i class="fa fa-bullhorn"></i> <span>Complaints</span></a></li>
	      <li id="customerphotoupload"><a href="{{ url('/')}}/customerzone/customerphotoupload" ><i class="fa fa-image"></i> <span>Customer Id Card & Vehicle Pass</span></a></li>
        <li id="paymenthistory"><a href="{{ url('/')}}/customerzone/paymenthistory" ><i class="fa fa-rupee"></i> <span>Payment History</span></a></li>
        <li id="projectstatus"><a href="{{ url('/')}}/customerzone/projectstatus" ><i class="fa fa-building"></i> <span>Project Status</span></a></li>
        <li id="inspectionsnag"><a href="{{ url('/')}}/customerzone/inspectionsnag" ><i class="fa fa-commenting"></i> <span>Inspection Snag</span></a></li>
	      <li id="occupantdetails"><a href="{{ url('/')}}/customerzone/occupantdetails" ><i class="fa fa-users"></i> <span> Owner/Tenant Details</span></a></li>
        <li id="onlinepayment"><a href="{{ url('/')}}/customerzone/payonline" ><i class="fa fa-credit-card"></i> <span>Online Payment</span></a></li>
        <li id="registrationdetails"><a href="{{ url('/')}}/customerzone/registrationdetails" ><i class="fa fa-files-o"></i> <span>Details For Registration</span></a></li>
        <li id="customer_satisfaction_survey"><a href="{{ url('/')}}/customerzone/customer_satisfaction_survey" ><i class="fa fa-line-chart"></i> <span>Customer Satisfaction Survey</span></a></li>
        <li id="referfriend"><a href="{{ url('/')}}/customerzone/referfriend" ><i class="fa fa-group"></i> <span>Refer a Friend</span></a></li>
        
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- =============================================== -->
