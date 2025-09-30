

<style>
  a{
    text-decoration: none !important;
  }
  .main-header, .dropdown-item,.main-header .nav-link{
    font-family: 'Arial', sans-serif;
    /* font-family: 'Roboto', sans-serif; */
    color: #000 !important;
    /* text-transform: uppercase; */
    font-weight: 600;
    font-size: 15px;
    background-color:#fff !important;
    height: 70px;
    padding-top:15px;
}
.main-header a{
  font-size:24px;
  color:#c61a41;
  padding-top:7px;
}
.fa-fw{
  height:28px;
}

</style>

<nav class="navbar main-header shadow-none">
  <div class="container-fluid">
    <a class="navbar-brand" href="/">
      <img src="https://cdn.vgn.in/nodeserver/website/logo/vgn-logo.png" alt="VGN" width="" height="42" class="d-inline-block align-text-top p-0">
    </a>
    <a href="{{ url('/') }}" class="" style="float: right;">
      <i class="fa fa-home fa-fw"></i>
    </a>
  </div>
</nav>


<!-- <header id="navigation" class="root-sec white nav">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-12">
            <div class="nav-inner">
              <ul id="dropdown1" class="dropdown-content dropcss">
                <li><a href="#"><i class="fa fa-pencil fa-fw"></i>Login <i class="fa fa-caret-up fa-fw pull-right"></i></a>
                <ul style="overflow-y: scroll;height: 165px;">
                  <li><a href="{{ url('/customerzone/customerlogin')}}">Customer Login</a></li>
                  <li><a href="{{ url('/vendorzone/vendorlogin')}}" >Vendor Login</a></li>
                  <li><a href="{{ url('/vendorzone/registration')}}" >Vendor Registration</a></li>
                  <li><a href="{{ url('/employeezone/employeelogin')}}" >Employee Login</a></li>
                </ul>
                </li>
                
              </ul>

              <ul id="dropdown2" class="dropdown-content dropcss">
                <li><a href="#"><i class="fa fa-desktop fa-fw"></i> Social Media <i class="fa fa-caret-up fa-fw pull-right"></i></a>
                <ul style="overflow-y: scroll;height: 165px;">
                        <li class="hide-on-large-only"><a href="https://www.facebook.com/VGNProjectsEstates"><i class="fa fa-facebook fa-fw"></i> Facebook</a>
                            </li>
                          
                            <li class="hide-on-large-only"><a href="https://twitter.com/VGNProjects"><i class="fa fa-twitter fa-fw"></i> Twitter</a>
                            </li>

                            <li class="hide-on-large-only"><a href="https://www.youtube.com/user/vgndevelopers"><i class="fa fa-youtube fa-fw"></i> Youtube</a>
                            </li>
                            <li class="hide-on-large-only"><a href="https://www.instagram.com/vgn_projects_estates/" ><i class="fa fa-instagram fa-fw"></i> Instagram</a> </li>
                        <li class="hide-on-large-only"><a href="https://www.pinterest.ru/vgnprojectsestatespvtltd/" ><i class="fa fa-pinterest-square fa-fw"></i> Pinterest</a></li>
                        <li class="hide-on-large-only"><a href="https://www.linkedin.com/company/27106479" ><i class="fa fa-linkedin-square fa-fw"></i> Linkedin</a></li>
                </ul>
                </li>
                  
                
              </ul>

               <ul id="dropdown3" class="dropdown-content dropcss">
                <li><a href="#"><i class="fa fa-pencil fa-fw"></i>About Us <i class="fa fa-caret-up fa-fw pull-right"></i></a>
                <ul style="overflow-y: scroll;height: 165px;">
                  <li><a href="{{ url('/aboutus')}}">Who We Are</a></li>
				 
                  <li><a href="{{ url('/history_of_vgn')}}" >History</a></li>
				  <li><a href="{{ url('/sponsorships')}}" >Sponsorships</a></li>
				  <li><a href="{{ url('/awards')}}" >Awards</a></li>
					<li><a href="{{ url('/news?page=1')}}">News Room</a></li>
				<li><a href="{{ url('/blog')}}" >Blog</a></li>
                  
                </ul>
                </li>
                
              </ul>
              
              <nav class="primary-nav">
                <div class="clearfix nav-wrapper">
                  <a href="{{ url('/') }}" class="left brand-logo img-responsive"><img src="{{ config('app.AWS_URL')}}/images/custom/vgn-logo.png" alt="">
                  </a>
                  <a href="#" data-activates="mobile-demo" class="button-collapse" style="color:#F44336;"><i class="mdi-navigation-menu"></i></a>
                   <ul  class="right static-menu hide-on-large-only">

                     <li class="search-form-li">
                      <a href="{{ url('/') }}" class=""><i class="fa fa-home fa-fw"></i> </a>
                      
                    </li>

                    <li class="search-form-li">
                      <a href="{{ url('/search') }}" id="initSearchIcon" class=""><i class="fa fa-search fa-fw"></i> </a>
                      
                    </li>
                   
                  </ul>
                  
                  <ul class="inline-menu side-nav" id="mobile-demo">

                  
                    <li class="mobile-profile">
                      
                     <div class="profile-inner">
                        <span id="closetag" class="close"><i class="fa fa-close fa-fw"></i>
                        <img src="{{ config('app.AWS_URL')}}/images/custom/vgn-logo.png" alt="vgn logo">
                      </div>
                    </li>


                    <li><a href="#" id="logindrop3" class="menu-smooth-scroll dropdown-button" data-activates="dropdown3" ><i class="fa fa-pencil fa-fw"></i>About Us <i class="fa fa-caret-down"></i></a>
                    </li>
                    <li><a href="{{ url('/landownersform') }}" ><i class="fa fa-users fa-fw"></i>For Land Owners</a> </li>
                    <li><a href="{{ url('/Premium-Real-Estate-Developers-in-Chennai') }}" ><i class="fa fa-file-text fa-fw"></i>Ongoing Projects</a>
                    </li>
                    <li><a href="{{ url('/Flat-Builders-Chennai') }}" ><i class="fa fa-briefcase fa-fw"></i>Completed Projects</a>
                    </li>
                   
                  
                    <li><a href="#" id="logindrop" class="menu-smooth-scroll dropdown-button" data-activates="dropdown1" ><i class="fa fa-pencil fa-fw"></i>Login <i class="fa fa-caret-down"></i></a>
                    </li>

                     <li class="hide-on-med-and-down"><a href="{{ url('/search') }}" ><i class="fa fa-search fa-fw"></i>Search</a>
                    </li>
                    <li><a href="#" id="logindrop1" class="menu-smooth-scroll dropdown-button hide-on-large-only" data-activates="dropdown2"><i class="fa fa-desktop fa-fw"></i> Social Media <i class="fa fa-caret-down"></i></a>
                    </li>
					   <li><a href="{{ url('/contact_us') }}" ><i class="fa fa-phone fa-fw"></i>Contact Us</a>
                    </li>
                  </ul>
                  

                </div>
              </nav>
            </div>
          </div>
        </div>
      </div>
    </header> -->
