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
    <script src="{{ asset('js/User/user.js') }}"></script>\
    <script src="https://kit.fontawesome.com/62474f8a4e.js" crossorigin="anonymous"></script>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v14.0&appId=520447719756704&autoLogAppEvents=1" nonce="lMhgNhPU"></script>
</head>

<body>
    @yield('content')
</body>

</html>