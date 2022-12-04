<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=0">
  <title>{{ __('auth.setting_account.title') }}</title>
  <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
  <script src="https://kit.fontawesome.com/62474f8a4e.js" crossorigin="anonymous"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.js"
    integrity="sha512-LjPH94gotDTvKhoxqvR5xR2Nur8vO5RKelQmG52jlZo7SwI5WLYwDInPn1n8H9tR0zYqTqfNxWszUEy93cHHwg=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"
    integrity="sha512-6lplKUSl86rUVprDIjiW8DuOniNX8UDoRATqZSds/7t6zCQZfaCe3e5zcGaQwxa8Kpn5RTM9Fvl3X2lLV4grPQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css"
    integrity="sha512-cyzxRvewl+FOKTtpBzYjW6x6IAYUCZy3sGP40hn+DQkqeluGRCax7qztK2ImL64SA+C7kVWdLI6wvdlStawhyw=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.css"
    integrity="sha512-C4k/QrN4udgZnXStNFS5osxdhVECWyhMsK1pnlk+LkC7yJGCqoYxW4mH3/ZXLweODyzolwdWSqmmadudSHMRLA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
  <div class="container">
    <h1 class="title">Welcome, DO Tuan Kiet</h1>
  </div>
  <div class="container box">
    <div class="step_section columns">
      <div class="column has-text-centered">
        <progress class="progress is-info p-0 mb-1" value="50" max="100"></progress>
        <span>{{ __('auth.setting_account.step_1') }}</span>
        <p>{{ __('auth.setting_account.step_1_desc') }}</p>
      </div>
      <div class="column has-text-centered">
        <progress class="progress is-info p-0 mb-1" value="50" max="100"></progress>
        <span>{{ __('auth.setting_account.step_2') }}</span>
        <p>{{ __('auth.setting_account.step_2_desc') }}</p>
      </div>
    </div>
    <div>
      <section class="step_1 m-5">
        <div class="field">
          <label>Ảnh đại diện: </label>
          <figure class="image avatar-image is-128x128">
            <img class="is-rounded" src="https://bulma.io/images/placeholders/128x128.png">
          </figure>
          <input class="file input-avatar-image" type="file">
        </div>
      </section>
    </div>
  </div>
</body>

<style>
  .progress {
    border-radius: 0 !important;
    height: 0.5rem;
  }

  .container {
    margin: auto;
    margin-top: 3rem
  }

  .box {
    padding: 0;
  }

  .input-avatar-image {
    display: none
  }

  .avatar-image {
    cursor: pointer;
  }
</style>
<script>
    $('.avatar-image').click(function() {
        $('.input-avatar-image').click();
    });
</script>

</html>
