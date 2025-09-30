<!-- =============================================== -->

  <!-- Left side column. contains the sidebar -->
  <aside class="main-sidebar control-sidebar-light">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
   
     
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
        
        <li id="dashboard"><a href="{{ url('/')}}/vendorzone/dashboard/{{$vendor->id}}" ><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
        <li id="mydetails"><a href="{{ url('/')}}/vendorzone/mydetails" ><i class="fa fa-user"></i> <span>My Details</span></a></li>
        <li id="mybankdetails"><a href="{{ url('/')}}/vendorzone/mybankdetails" ><i class="fa fa-bank"></i> <span>My Bank Details</span></a></li>
        <li id="communication"><a href="{{ url('/')}}/vendorzone/communication" ><i class="fa fa-envelope"></i> <span>Communications</span></a></li>
        <li id="complaints"><a href="{{ url('/')}}/vendorzone/complaints" ><i class="fa fa-bullhorn"></i> <span>Complaints</span></a></li>
        <!-- <li id="paymenthistory"><a href="{{ url('/')}}/vendorzone/paymenthistory" ><i class="fa fa-rupee"></i> <span>Payment History</span></a></li> -->
	    @if($vendor->channel_partner  == 'X')
        <li id="channel_partner_leadcreation"><a href="{{ url('/')}}/vendorzone/channel_partner_leadcreation" ><i class="fa fa-edit"></i> <span>Create Leads</span></a></li>
      @else
        <li id="newbidcorner"><a href="{{ url('/')}}/vendorzone/newbidcorner" ><i class="fa fa-diamond"></i> <span>New Bid Corner</span></a></li>
        <li id="myrecentbids"><a href="{{ url('/')}}/vendorzone/myrecentbids" ><i class="fa fa-cubes"></i> <span>My Recent Bids</span></a></li>
        <li id="invoice_attachment"><a href="{{ url('/')}}/vendorzone/invoiceattachment" ><i class="fa fa-cubes"></i> <span>Submit Invoice</span></a></li>
        <li id="referfriend"><a href="{{ url('/')}}/vendorzone/referfriend" ><i class="fa fa-group"></i> <span>Refer a Friend</span></a></li>
      @endif
        
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- =============================================== -->
