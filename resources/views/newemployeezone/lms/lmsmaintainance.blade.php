
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	<title>LMS Coming Soon Pages</title>

	<!-- web-fonts -->
	<link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
	<!-- font-awesome -->
	<link href="{{ config('app.AWS_URL')}}/lms_maintainance_assets/font-awesome.min.css" rel="stylesheet">
	<!-- Style CSS -->
	<link href="{{ config('app.AWS_URL')}}/lms_maintainance_assets/lms_maintainancestyle.css" rel="stylesheet">

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
      <![endif]-->
  </head>
  <body>
  	<section class="wraper">
  		<header class="header">
  			<h1>Leave Management System</h1>
  			<h2>Page Under Maintainance, will be active in</h2>
  		</header>
  		<!-- .header -->


  		<section class="countdown-wrapper">
  			<ul id="back-countdiown">
  				<li>                    
  					<span class="days">00</span>
  					<p>days</p>
  				</li>
  				<li>
  					<span class="hours">00</span>
  					<p>hours </p>
  				</li>
  				<li>
  					<span class="minutes">00</span>
  					<p>minutes</p>
  				</li>
  				<li>
  					<span class="seconds">00</span>
  					<p>seconds</p>
  				</li>               
  			</ul><!-- #back-countdiown -->
  		</section><!-- .countdown-wrapper -->
  		
  	</section>


  	<div class="fullscreen-bg">
  		<video loop muted autoplay poster="/lms_maintainance_assets/videoframe.jpg" class="fullscreen-bg__video">
  			<source src="/lms_maintainance_assets/video-bg.mp4" type="video/mp4">
  		</video>
  	</div> <!-- .fullscreen-bg -->

  	<!-- Script -->
  	<script src="{{ config('app.AWS_URL')}}/lms_maintainance_assets/jquery-2.1.4.min.js"></script>
  	<script src="{{ config('app.AWS_URL')}}/lms_maintainance_assets/coundown-timer.js"></script>
  	<script src="{{ config('app.AWS_URL')}}/lms_maintainance_assets/scripts.js"></script>

  	</body>
</html>