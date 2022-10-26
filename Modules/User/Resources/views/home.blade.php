<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ env('APP_NAME') }}</title>
    <link href="{{ asset('/css/bulma.css') }}" rel="stylesheet">
    <script src="https://kit.fontawesome.com/62474f8a4e.js" crossorigin="anonymous"></script>
</head>
<body>
    <div id="app"></div>
    <script src="{{ asset('vue/js/app.js') }}"></script>
</body>
</html>