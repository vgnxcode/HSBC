=============================================== -->

  <!-- Left side column. contains the sidebar -->
  <aside class="main-sidebar control-sidebar-light">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
   
     
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
        
        <li id="dashboard"><a href="{{ url('/')}}/employeezone/dashboard/{{$employee->id}}" ><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
        <li id="mydetails"><a href="{{ url('/')}}/employeezone/mydetails" ><i class="fa fa-user"></i> <span>My Details</span></a></li>
        <li id="mynoticeboard"><a href="{{ url('/')}}/employeezone/mynoticeboard" ><i class="fa fa-sort-alpha-asc"></i> <span>My Notice Board</span></a></li>
        <li id="mybankdetails"><a href="{{ url('/')}}/employeezone/empbankdetails" ><i class="fa fa-bank"></i> <span>My Bank Details</span></a></li>
        <!--<li id="complaints"><a href="{{ url('/')}}/employeezone/complaints" ><i class="fa fa-bullhorn"></i> <span>Complaints</span></a></li>-->
	<!-- <li class="treeview">
            <a href="#"><i class="fa fa-bullhorn"></i> <span>Complaints</span></a>

    <ul class="treeview-menu">
	<li id="complaints"><a href="{{ url('/')}}/employeezone/complaints" ><i class="fa fa-circle-o"></i> <span>General Complaints</span></a></li>
	 <li id="itcomplaints"><a href="{{ url('/')}}/employeezone/vgnticket_redirection" ><i class="fa fa-circle-o"></i> <span>IT Complaints</span></a></li>
    </ul>
</li> -->
<li id="vgnticket_redirection">
  <a href="{{ url('/')}}/employeezone/vgnticket_redirection" ><i class="fa fa-bullhorn"></i> <span>Complaints</span></a></li>
        <li class="treeview">
            <a href="#"><i class="fa fa-star"></i> <span>My Leaves & Approvals</span></a>

    <ul class="treeview-menu">

      <!--<li id="myattendance"><a href="{{ url('/')}}/employeezone/myattendance" ><i class="fa fa-circle-o"></i> My Attendance</a></li> -->
		<li id="myattendance"><a href="{{ url('/')}}/employeezone/lms/attendance_view" ><i class="fa fa-circle-o"></i> My Attendance</a></li>
		
		

      @if((session()->get('is_security') == '0') && (session()->get('is_notice_period') == '0'))

       <li id="leavemanagementsystem"><a href="{{ url('/')}}/employeezone/leavemanagementsystem" ><i class="fa fa-smile-o"></i>Leave Management System</a></li>
      @endif
      
      @if(session()->has('is_report_manager'))
      @if(session()->get('is_report_manager') == '1')
       <li id="subordinate_application"><a href="{{ url('/')}}/employeezone/lms/subordinate_application" ><i class="fa fa-users"></i> Leave Approvals</a></li>
       <li id="applications_delete_request"><a href="{{ url('/')}}/employeezone/lms/applications_delete_request" ><i class="fa fa-minus"></i> Requested for Deletion</a></li>
      <li id="viewemployee_punches"><a href="{{ url('/')}}/employeezone/lms/viewemployee_punches" ><i class="fa fa-users"></i> Employee Punches</a></li>
      @endif
      @endif
		
		  {{-- @if( $employee->id == '100770' '101397','101190','101280','101399') --}}
      @if(in_array($employee->id, ['100770', '101397', '101190', '101280', '101399']))
      <li id="overall_employeeattendance"><a href="{{ url('/')}}/employeezone/lms/overall_employeeattendance" ><i class="fa fa-circle-o"></i> Employee Attendance Check </a></li>
      @endif

      @if(in_array($employee->id, config('newlmsconfig')))
      <li id="admin_application"><a href="{{ url('/')}}/employeezone/lms/admin_application" ><i class="fa fa-users"></i> Leave Approvals</a></li>
      <li id="monthly_deductions_screen"><a href="{{ url('/')}}/employeezone/lms/monthly_deductions_screen" ><i class="fa fa-minus"></i> Late Deductions</a></li>
		<li id="overall_employeeattendance"><a href="{{ url('/')}}/employeezone/lms/overall_employeeattendance" ><i class="fa fa-circle-o"></i> Employee Attendance Check </a></li>
	
      <li id="view_overall_employee_punches"><a href="{{ url('/')}}/employeezone/lms/view_overall_employee_punches" ><i class="fa fa-users"></i> Overall Employee Punches</a></li>
      
      <!--<li id="view_overall_employee_punches"><a href="{{ url('/')}}/employeezone/lms/payroll_reportview" ><i class="fa fa-file"></i> Payroll Report View</a></li>-->
      @endif
      <!-- MD approval -->
      {{-- @if($employee->id == '100000') --}}
      @if(in_array($employee->id, ['100000','100770', '101397', '101190', '101280', '101399']))
      <li id="attendancecorrection"><a href="{{ url('/')}}/employeezone/lms/attendancecorrection" ><i class="fa fa-circle-o"></i> Employee Attendance Corrections </a></li>  
      @endif

      @if(($employee->department_code == '50000056')||($employee->id == '101116')) 
      <li id="payrollprocess_screen"><a href="{{ url('/')}}/employeezone/lms/payrollprocess_screen" ><i class="fa fa-users"></i> Payroll Process Screen</a></li>
      @endif
      @if($employee->department_code == '50000056')    
      <li id="getlistofvendorskycupdated"><a href="{{ url('/')}}/employeezone/getlistofvendorskycupdated" ><i class="fa fa-circle-o"></i> Vendor KYC Data </a></li>
      @endif

      <li id="holidaycalendar"><a href="{{ url('/')}}/employeezone/holidaycalendar" ><i class="fa fa-circle-o"></i> Holiday Calendar</a></li>
    </ul>
  </li>
      

  

@if($employee->department_code == '50000062')
       <li id="jobapplications"><a href="{{ url('/')}}/employeezone/jobapplications" ><i class="fa fa-briefcase"></i> <span>Incoming Job Applications</span></a></li>
       @endif 
       <li id="empreferfriend"><a href="{{ url('/')}}/employeezone/empreferfriend" ><i class="fa fa-male"></i> <span>My Referrals</span></a></li>
       
       <li id="reportingstructure"><a href="{{ url('/')}}/employeezone/reportingstructure" ><i class="fa fa-sitemap"></i> <span>My Reporting Structure</span></a></li>
        <li id="empmemos"><a href="{{ url('/')}}/employeezone/empmemos" ><i class="fa fa-list-ul"></i> <span>My Memo / Fine Deductions </span></a></li>
        
        <li id="hrpolicy"><a href="{{ url('/')}}/employeezone/hrpolicy" ><i class="fa fa-tag"></i> <span>HR Policy </span></a></li>
        
         <li id="mydutiesandresponsibilities"><a href="{{ url('/')}}/employeezone/mydutiesandresponsibilities" ><i class="fa fa-check"></i> <span>My Duties and Responsibilities </span></a></li>
         
         @if($employee->saleorder == 1)
        
        
        <li id="leadsfollowup">
           <a href="{{ url('/employeezone/leadsfollowup')}}"><i class="fa fa-star"></i> <span>Leads Followup</span></a> </li>
        <li id="bulkleadupload">
           <a href="{{ url('/employeezone/bulkleadupload')}}"><i class="fa fa-upload"></i> <span>Bulk Lead Upload</span></a> </li>
        @endif
         
         
         @if($employee->saleorder == 1)
         <li id="leadselection"><a href="{{ url('/')}}/employeezone/leadselection" ><i class="fa fa-certificate"></i> <span>Create Sale Order </span></a></li>
         
         @endif
	
	@if($employee->department_code == '50000060')
         <li id="downloadcustomerphoto"><a href="{{ url('/')}}/employeezone/downloadcustomerphoto" ><i class="fa fa-download"></i> <span>Download Customer Photo</span></a></li>
         @endif         
         <li id="empeligibility"><a href="{{ url('/')}}/employeezone/empeligibility" ><i class="fa fa-share-alt"></i> <span>My Eligibilities </span></a></li>
         <li id="empstock"><a href="{{ url('/')}}/employeezone/empstock" ><i class="fa fa-ticket"></i> <span>My Stock, Loans & Advances </span></a></li>
         <li id="empstock"><a href="{{ url('/')}}/employeezone/payslip" ><i class="fa fa-file"></i> <span>My Payslip </span></a></li>
		    <li id="form16"><a href="{{ url('/')}}/employeezone/form16" ><i class="fa fa-download"></i> <span> Form-16 </span></a></li>
        <li id="medicalCard"><a href="https://mdindiaonline.com/E-Cardrequest.aspx" target="_blank" ><i class="fa  fa-user-md"></i> <span> Medical Card </span></a></li>
         <li id="emprequest"><a href="{{ url('/')}}/employeezone/emprequest" ><i class="fa fa-arrow-right"></i> <span>My Request </span></a></li>
         <li id="mytraining"><a href="{{ url('/')}}/employeezone/mytraining" ><i class="fa fa-file-text"></i> <span>My Training Schedule </span></a></li>
         <li id="feedback"><a href="{{ url('/')}}/employeezone/feedback" ><i class="fa fa-file-text"></i> <span>Feedback</span></a></li>
        

@if(in_array($employee->id, ['100000','101397']))
         <li id="feedback"><a href="{{ url('/')}}/employeezone/vendro_auth_key_insert" ><i class="fa fa-file-text"></i> <span>Add API key's</span></a></li>
          <li id="feedback"><a href="{{ url('/')}}/employeezone/list_api_key" ><i class="fa fa-file-text"></i> <span> List API key's</span></a></li>

   @endif
        
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- ===============================================
