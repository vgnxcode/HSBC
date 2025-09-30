<header id="navigation" class="root-sec white nav" style="padding-bottom: 10px;">
      <div class="container">
        <div class="row">
          <div class="col-sm-12">
            <div class="nav-inner">
              <!-- Dropdown Structure -->
              <ul id="dropdown1" class="dropdown-content dropcss">
              
                <li><a href="#"><i class="fa fa-pencil fa-fw"></i>Login <i class="fa fa-caret-up fa-fw pull-right"></i></a></li>
                <li><a href="{{ url('/portal/customer-zone/customer-login.php')}}">Customer Login</a></li>
                <li><a href="{{ url('/portal/vendor-zone/vendor-login.php')}}" >Vendor Login</a></li>
                <li><a href="{{ url('/portal/vendor-zone/vend-reg.php')}}" >Vendor Registration</a></li>
                <li><a href="{{ url('/portal/employee-zone/employee-login.php')}}" >Employee Login</a></li>
              </ul>
              
              <nav class="primary-nav">
                <div class="clearfix nav-wrapper">
                <li class="pull-right hide-on-small-only" style="padding-top:-5px;"><a href="tel:04443439999" style="color: #F44336; font-size: 21px;"><i class="fa fa-phone"></i> 044 43439999</a></li>
                  <a href="{{url('/')}}" class="left brand-logo img-responsive"><img src="{{ config('app.AWS_URL')}}/images/custom/vgn-logo.png" alt="">
                  </a>
                  <a href="#" data-activates="mobile-demo" class="button-collapse" style="color:#F44336;"><i class="mdi-navigation-menu"></i></a>
                   <ul  class="right static-menu hide-on-large-only">

                     <li class="search-form-li">
                      <a href="#" class="">&nbsp; </a>
                      
                    </li>

                   
                   
                  </ul>
                  
                  <ul class="inline-menu side-nav" id="mobile-demo">

                  <!-- Mini Profile // only visible in Tab and Mobile -->
                    <li class="mobile-profile">
                     <div class="profile-inner">
                        <span id="closetag" class="close"><i class="fa fa-close fa-fw"></i>
                        <img src="{{ config('app.AWS_URL')}}/images/custom/vgn-logo.png" alt="vgn logo">
                      </div>
                    </li><!-- mini profile end-->


        
                    <li><a href="#location" data-section="#location" class="menu-smooth-scroll"><i class="fa fa-user fa-fw"></i>Location</a>
                    </li>
                    <!-- <li><a href="#amenities" data-section="#amenities" class="menu-smooth-scroll" ><i class="fa fa-file-text fa-fw"></i>Amenities</a>
                    </li> -->
                   

                  </ul>
                  

                </div>
              </nav>
            </div>
          </div>
        </div>
      </div>
      <!-- .container end -->
    </header>
