<style>
	a.user-ico.clearfix span {
    color: #fff;
}
a.user-ico.clearfix span i {
    font-size: 18px;
    margin: 0px 6px;
 
}
.user-info ul {
    list-style-type: none;
    padding: 0;
	    margin: 5px 0px;
}
.login-box1 {
    padding: 5px 15px;
}

.box-sm1 {
    width: 250px;
}
.login-box .user-info li a {
    padding: 5px 5px;
    margin: 5px 0;
    line-height: 0;
	font-size:14px;
	    color: #7e7e7e;
}
.dropdown-menu .user-info li>a:hover {
    color: #01427C;
 background:none;
}
.user-profile a {
    color: snow;
}
.user-profile a i {
    font-size: 17px;
    margin: 0 5px 0 0;
}
.user-profile>a .icon-chevron-down {
    color: #E0DADA;
    font-size: 15px;
}
@media screen and (max-width:506px)
{
	a.user-ico.clearfix span {
    display:none;
}
.user-profile>a .icon-chevron-down {
    
    font-size: 15px;
}
.user-profile a span {
display:none;    
}
	
}
.dash-title{
	float: left;padding: 6px 15px;color: #fff;font-size:26px;
}
@media screen and (max-width:365px){
	.dash-title{
	padding: 10px 5px;
    
    font-size: 20px;
	}
}
@media screen and (max-width:300px){
	.dash-title{
	    padding: 12px 0px;
    font-size: 18px;
	}
}
	</style>

			
<div id="page-header" class="clearfix">
					<div id="header-logo" class="rm-transition">
						<a href="#" class="tooltip-button hidden-desktop" title="Navigation Menu" id="responsive-open-menu">
							<i class="glyph-icon icon-align-justify"></i>
						</a> 
						<span><img src="{{ url('portal/assets/vgn-logo.png')}}"></span> 
						<!-- <a id="collapse-sidebar" href="#" title=""><i class="glyph-icon icon-chevron-left"></i></a> -->
					</div>
					<!-- 	<div id="sidebar-search"><input type="text" placeholder="Search..." class="autocomplete-input input tooltip-button" data-placement="bottom" title="Type &apos;jav&apos; to see the available tags..." id="" name=""> <i class="glyph-icon icon-search"></i></div> -->
					<span class="dash-title">Customer Zone</span>
					<div id="header-right">
					<div class="user-profile">
							
								<!--<img width="36" src="../../assets-minified/dummy-images/gravatar.jpg" alt=""> -->
								<a href="{{url('/customerzone/logout')}}"><i class="glyph-icon icon-power-off"></i><span> Logout</span></a>
								
								
								</div>
					<div class="user-profile dropdown">
							<a href="#" title="" class="user-ico clearfix" data-toggle="dropdown">
								<!--<img width="36" src="../../assets-minified/dummy-images/gravatar.jpg" alt=""> -->
								<i class="glyph-icon icon-linecons-cog"></i>
								<span> Settings</span>
								<i class="glyph-icon icon-chevron-down"></i></a>
							
							
							
							<div class="dropdown-menu pad0B float-right">
								<div class="box-sm1">
									<div class="login-box clearfix">
										<!-- <div class="user-img">
											<a href="#" title="" class="change-img">Change photo</a>
											<img src="../../assets-minified/dummy-images/gravatar.jpg" alt="">
										</div> -->
										<div class="user-info">
											<span name="vendor-name" id="vendor-name">{{ $customerdata->name }}</span>
											
											<ul>
											<li><a href="{{ url('/customerzone/changemydetails') }}" title="Edit Profile">Edit Profile</a> </li>
											<li><a href="{{ url('/customerzone/mydetails_changepassword') }}" title="Change Password">Change Password</a></li>
											</ul>
											<!-- <a href="#" title="">View notifications</a> -->
										</div>
									</div>
									<!--<div class="pad5A button-pane button-pane-alt text-center">
										<a href="vendor-login.php" class="btn display-block font-normal btn-danger">
											<i class="glyph-icon icon-power-off"></i> Logout</a>
									</div>-->
								</div>
							</div>
						</div>
					
						<div class="user-profile">
			<!--<img width="36" src="../../assets-minified/dummy-images/gravatar.jpg" alt=""> -->
			<a href="http://vgn.in/"><i class="glyph-icon icon-home"></i><span>Home</span></a>
		</div>
	
					</div>
				</div>
