<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<html lang="en" class="no-js">
<!--<![endif]-->
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="google-site-verification" content="9gGBlE4cebDHUqAypUBExQ77K-Vf-tppM8cSNWoVO2Q" />
  <title>@yield('title')</title>
  @yield('description')
  @yield('keyword')
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
  <meta name="theme-color" content="#e21f25"/>

    <!-- Favicon-->
  <link rel="shortcut icon" href="{{ config('app.AWS_URL').'/images/vgnfavicon.png' }}" >

  <!-- Stylesheets -->
  @yield('stylesheet')
   @if(View::exists('pixelcodes.vgn_google.vgn_google_analytics'))
      @include('pixelcodes.vgn_google.vgn_google_analytics')
    @endif
	
	<?php  if(substr( Request::path(), 0, 7 ) != 'google/'){ ?>
	
	@include('chatbot.style')
	<?php } ?>

  <!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-P5MLT26');</script>
<!-- End Google Tag Manager -->

<!-- Global site tag (gtag.js) - Google Ads: 689958085 -->
<script async src="https://www.googletagmanager.com/gtag/js?id=AW-689958085"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'AW-689958085');
</script>

<!-- Start of HubSpot Embed Code -->
<script type="text/javascript" id="hs-script-loader" async defer src="//js.hs-scripts.com/6662966.js"></script>
<!-- End of HubSpot Embed Code -->
   
</head>

<body>
  <!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-P5MLT26"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

  <!-- Main Container -->
  <main id="app" class="main-section">
    <!-- header navigation start -->
    @yield('header')
    <!-- #header  navigation end -->

    <!-- #content Section end -->
    @yield('content')
    <!-- #content Section end -->

    <!-- Footer Section end -->
	  <?php  if(substr( Request::path(), 0, 7 ) != 'google/'){   ?>
	  @include('chatbot.file')
	  <?php } ?>
    @yield('footer')
    <!-- #footer end -->

  </main>
  <!-- Main Container end-->


  <!-- scripts -->
  @yield('scripts')
	<?php  if(substr( Request::path(), 0, 7 ) != 'google/'){  ?>
	<script src="{{ config('app.AWS_URL').'/assets/js/chatbot29012021.js' }}"></script>
	<?php } ?>

<!-- Facebook Pixel Code -->
<script>
  !function(f,b,e,v,n,t,s)
  {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
  n.callMethod.apply(n,arguments):n.queue.push(arguments)};
  if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
  n.queue=[];t=b.createElement(e);t.async=!0;
  t.src=v;s=b.getElementsByTagName(e)[0];
  s.parentNode.insertBefore(t,s)}(window, document,'script',
  'https://connect.facebook.net/en_US/fbevents.js');
  fbq('init', '492036698880166');
  fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
  src="https://www.facebook.com/tr?id=492036698880166&ev=PageView&noscript=1"
/></noscript>
<!-- End Facebook Pixel Code -->

</body>
</html>
