<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ __("user::auth.login.form_title") }}</title>
    <script language="JavaScript" type="text/javascript" src="{{ asset("vue/js/app.js")}}"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset("vue/css/app.css") }}">
</head>

<body>
    <div class="container">
        <div class="form-group">
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Email address</label>
                <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">
            </div>
            <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">Example textarea</label>
                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3">
                </textarea>
            </div>
        </div>
    </div>
</body>

</html>