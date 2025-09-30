<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>@yield('title')</title>
  @yield('description')
  @yield('keyword')
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="shortcut icon" href="{{ config('app.AWS_URL')}}/images/vgnfavicon.png" >
  @yield('style')
</head>
@yield('bodycontent')

@yield('script')
</body>
</html>
