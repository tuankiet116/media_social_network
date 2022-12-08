<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=0">
  <title>{{ $title }}</title>
  <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
  <link rel="stylesheet" href="{{ asset('css/userAuth.css') }}">
  <script src="https://kit.fontawesome.com/62474f8a4e.js" crossorigin="anonymous"></script>
  <script src="{{ asset('js/particles.js') }}"></script>
  <script src="{{ asset('js/userAuth.js') }}"></script>
  @yield('js')
  @yield('css')
</head>
<body>
  @yield('content')
</body>
</html>
