<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>@yield('title')</title>
  @yield('description')
  @yield('keyword')
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <meta name="theme-color" content="#e21f25"/>
  <link rel="shortcut icon" href="{{ config('app.AWS_URL')}}/images/vgnfavicon.png" >
  @yield('style')
  <style>
  
  a{ text-decoration: none !important;}
  html, body { 
    height: 100%;
    width: auto!important; 
    overflow-x: hidden!important;  
    overflow-y: auto; 
    scroll-behavior: smooth;
    background-color: #e21f25;
}
  </style>
</head>
@yield('bodycontent')

@yield('script')
<!-- <footer class="footer_bg ">
  <div class="container text-center p-2 pt-3 pb-1 ">
      <p class=""> Copyright &#xa9; 2023 VGN Projects Estates Pvt Ltd, All Rights Reserved. </p>        
  </div>
</footer> -->
</body>
</html>
