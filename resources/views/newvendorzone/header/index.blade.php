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
      <a href="{{ url('/vendorzone/dashboard') }}" class="title">Vendor Zone</a>

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
              <li class="header text-center"><h4>{{ $vendor->Name }}</h4></li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  
                  <li>
                    <a href="{{ url('vendorzone/mydetails_changepassword')}}">
                      <i class="fa fa-lock text-aqua"></i> Change Password
                    </a>
                  </li>
                </ul>
              </li>
              
            </ul>
          </li>
          <li><a href="{{ url('/vendorzone/logout') }}"><i class="fa fa-power-off"></i> Logout</a></li>
          
          
        </ul>
      </div>
    </nav>
  </header>