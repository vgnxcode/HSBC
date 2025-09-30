<style type="text/css">
  .sidebar::-webkit-scrollbar {
    width: 0.5em;
}
 
.sidebar::-webkit-scrollbar-track {
    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
}
 
.sidebar::-webkit-scrollbar-thumb {
  background-color: darkgrey;
  outline: 2px solid slategrey;
}
</style>
 <header class="main-header">
    <!-- Logo -->
    <a href="{{ url('/')}}" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>VGN</b></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><img src="{{ config('app.AWS_URL')}}/images/custom/vgn-logo.png" class="img-responsive" alt="vgn logo"></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>
      <a href="{{ url('/employeezone/dashboard') }}" class="title">Employee Zone</a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
        <li><a href="{{ url('/') }}"><i class="fa fa-home"></i> Home</a></li>
          <!-- Messages: style can be found in dropdown.less-->
          
          <!-- Notifications: style can be found in dropdown.less -->
          <li class="dropdown notifications-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-gears"></i> Settings
            </a>
            <ul class="dropdown-menu">
              <li class="header text-center"><h4>{{ $employee->name }}</h4></li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  <li>
                    <a href="{{ url('employeezone/changemydetails')}}">
                      <i class="fa fa-user text-aqua"></i> Edit Profile
                    </a>
                  </li>
                  <li>
                    <a href="{{ url('employeezone/mydetails_changepassword')}}">
                      <i class="fa fa-lock text-aqua"></i> Change Password
                    </a>
                  </li>
                </ul>
              </li>
              
            </ul>
          </li>
          <li><a href="{{ url('/employeezone/logout') }}"><i class="fa fa-power-off"></i> Logout</a></li>
          
          
        </ul>
      </div>
    </nav>
  </header>