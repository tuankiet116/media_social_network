<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }}</title>

    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('css/userLogin.css') }}">
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <script src="{{ asset('js/userLogin.js') }}"></script>
    <script src="https://kit.fontawesome.com/62474f8a4e.js" crossorigin="anonymous"></script>
    @yield('js')
    @yield('css')
</head>

<body>
    @yield('content')
</body>

</html>