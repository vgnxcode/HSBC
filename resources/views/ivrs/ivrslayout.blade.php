<!DOCTYPE html>
<html lang="en">
  <head>
    <title>IVRS Login</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="{{asset('/images/vgnfavicon.png')}}">

    <title>IVRS Report signin</title>

    <link href="{{ asset('assets/libs/bootstrap-4/css/bootstrap.min.css') }}" rel="stylesheet">
    @yield('style')
    
  </head>

  <body>

    @yield('content')

    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap-4/js/popper.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap-4/js/bootstrap.min.js') }}"></script>
    @yield('script')
  </body>
</html>
