<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ env('APP_NAME') }}</title>
  <link href="{{ asset('/css/common.css') }}" rel="stylesheet">
  <link href="{{ asset('/css/bulma.css') }}" rel="stylesheet">
  <script src="https://kit.fontawesome.com/62474f8a4e.js" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bulma-quickview@2.0.0/dist/js/bulma-quickview.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js" integrity="sha512-STof4xm1wgkfm7heWqFJVn58Hm3EtS31XFaagaa8VMReCXAkQnJZ+jEy8PCC/iT18dFy95WcExNHFTqLyp72eQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>

<body>
  <div id="app"></div>
  <script src="{{ asset('vue/js/app.js') }}"></script>
  <script>
    window.onload = function() {
      var quickviews = bulmaQuickview.attach()
    };
  </script>
  <style>
    html, body, #app {
      width: 100%;
      background: #eceaea;
      height: 100%;
    }
  </style>
</body>

</html>
