<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ env('APP_NAME') }}</title>
    <link href="{{ asset('/css/common.css') }}" rel="stylesheet">
    <script src="https://kit.fontawesome.com/62474f8a4e.js" crossorigin="anonymous"></script>
</head>
<body>
    <div id="app"></div>
    <script src="{{ asset('vue/js/app.js') }}"></script>
</body>
</html>