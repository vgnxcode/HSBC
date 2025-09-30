<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js">
<!--<![endif]-->
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  
  <title>@yield('title')</title>
  @yield('description')
  @yield('keyword')
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">

  <!-- Favicon-->
  <link rel="shortcut icon" href="{{ asset('images/vgnfavicon.png') }}" >

  <!-- Stylesheets -->
  @yield('stylesheet')
  
   
</head>

<body>

  

  <!-- Main Container -->
  <main id="app" class="main-section">
    <!-- header navigation start -->
    @yield('header')
    <!-- #header  navigation end -->

    <!-- #content Section end -->
    @yield('content')
    <!-- #content Section end -->

    <!-- Footer Section end -->
    @yield('footer')
    <!-- #footer end -->

  </main>
  <!-- Main Container end-->


  <!-- scripts -->
  @yield('scripts')
</body>
</html>