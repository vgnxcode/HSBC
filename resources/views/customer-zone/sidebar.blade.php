<script type="text/javascript">
$(document).ready(function(){
$('#sidebar-menu a').each(function(){
if($(this).attr('href').substring($(this).attr('href').lastIndexOf("/")+1)==$(location).attr('pathname').substring($(location).attr('pathname').lastIndexOf("/")+1))
{
$(this).addClass('dash');
}
});
});
</script>
<div id="page-sidebar" class="rm-transition">
					<div id="page-sidebar-wrapper">
						<div id="sidebar-top">
							<div class="tab-content">
								<div class="tab-pane clearfix fade active in" id="tab-example-1">
									<!--<div class="user-profile-sm clearfix">
										<img width="45" class="img-rounded" src="../assets-minified/dummy-images/gravatar.jpg" alt="">
										<div class="user-welcome">Welcome back, <b>Customer</b></div>		
									</div>-->
								</div>
							</div>
						</div>
						<div id="sidebar-menu">
							<ul>
								<li>
									<a href="{{ url('/customerzone/dashboard')}}" title="Dashboard"><i class="glyph-icon icon-dashboard"></i> <span>Dashboard</span> <sup>R</sup></a>
								</li>	
								<li class="divider"></li>
								<li>
									<a href="{{ url('/customerzone/mydetails')}}" title="My Details" ><i class="glyph-icon icon-user"></i><span>My Details</</span> <sup>R</sup></a>
								</li>
								<li class="divider"></li>
								<!--<li>
									<a href="cust-change-pwd.php" title="Change Password"><i class="glyph-icon icon-edit"></i><span>Change Password</span> <sup>W</sup></a>		
								</li>
								<li class="divider"></li>-->
								<li>
									<a href="{{ url('/customerzone/communication') }}" title="Communications"><i class="glyph-icon icon-inbox"></i> <span>Communications</span> <sup>M</sup></a>
								</li>
								<li class="divider"></li>
								<li>
									<a href="{{ url('/customerzone/complaints') }}" title="Complaints" ><i class="glyph-icon icon-microphone"></i> <span>Complaints</span> <sup>R</sup></a>
								</li>
								<div class="divider"></div>
								<li>
									<a href="{{ url('/customerzone/paymenthistory') }}" title="Payment History"><i class="glyph-icon icon-rupee"></i> <span>Payment History</span> <sup>R</sup></a>
								</li>
								<div class="divider"></div>
								<li>
									<a href="{{ url('/customerzone/projectstatus') }}" title="Project Status"><i class="glyph-icon icon-flag"></i> <span>Project Status</span> <sup>C</sup></a>
								</li>
								<div class="divider"></div>
								<li>
									<a href="{{ url('/customerzone/inspectionsnag') }}" title="Inspection Snag"><i class="glyph-icon icon-comment"></i> <span>Inspection Snag</span> <sup>C</sup></a>
								</li>
								<div class="divider"></div>
								<li>
									<a href="{{ url('/customerzone/referfriend') }}" title="My Referrals"><i class="glyph-icon icon-group"></i> <span>Refer a friend</span> <sup>R</sup></a>
								</li>
							</ul>
						</div>
						<div class="divider"></div>
					</div>
				</div>