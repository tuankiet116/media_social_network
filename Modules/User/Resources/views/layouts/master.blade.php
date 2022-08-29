<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }}</title>

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/User/user.css') }}">
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <script src="{{ asset('js/User/user.js') }}"></script>
</head>

<body>
    @yield('content')
</body>

</html>