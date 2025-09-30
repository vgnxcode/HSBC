<!DOCTYPE html>
<html lang="en">
  <head>
    <title>VGN Homes Lead report</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="{{ config('app.AWS_URL')}}/images/vgnfavicon.png">

    <title>VGN Homes Leads signin</title>

    <link href="{{ config('app.AWS_URL')}}/assets/libs/bootstrap-4/css/bootstrap.min.css" rel="stylesheet">
    @yield('style')
    
  </head>

  <body>

    @yield('content')

    <script src="{{ config('app.AWS_URL')}}/assets/js/jquery.min.js"></script>
    <script src="{{ config('app.AWS_URL')}}/assets/libs/bootstrap-4/js/popper.min.js"></script>
    <script src="{{ config('app.AWS_URL')}}/assets/libs/bootstrap-4/js/bootstrap.min.js"></script>
    @yield('script')
  </body>
</html>
