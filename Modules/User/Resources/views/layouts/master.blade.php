<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ $title }}</title>

  <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
  <link rel="stylesheet" href="{{ asset('css/userLogin.css') }}">
  <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
  <script  type = "text/javascript" src="{{ asset('js/bootstrap.js') }}"></script>
  <script  type = "text/javascript" src="{{ asset('js/userLogin.js') }}"></script>
  <script src="https://kit.fontawesome.com/62474f8a4e.js" crossorigin="anonymous"></script>
  @yield('js')
  @yield('css')
</head>

<body>
  <div class="background-container">
    <img src="../images/moon2.png" alt="">
    <div class="stars"></div>
    <div class="twinkling"></div>
    <div class="clouds"></div>
  </div>
  @yield('content')
</body>

</html>
