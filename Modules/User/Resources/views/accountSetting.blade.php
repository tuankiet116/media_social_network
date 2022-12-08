<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=0">
  <title>{{ __('auth.setting_account.title') }}</title>
  <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
  <script src="https://kit.fontawesome.com/62474f8a4e.js" crossorigin="anonymous"></script>
  <script src="{{ asset('js/accountSetting.js') }}" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
  <link rel="stylesheet" href="{{ asset('css/accountSetting.css') }}">
</head>

<body>
  <div class="container container-header">
    <h1 class="title">Welcome, {{ auth()->user()->name }} !</h1>
    <p>First, you need to setup your account and the basic information.</p>
  </div>
  <div class="container">
    <div class="step_section columns is-mobile">
      <div class="column has-text-centered">
        <progress class="progress is-info p-0 mb-1 step1" value="0" max="100"></progress>
        <span>{{ __('auth.setting_account.step_1') }}</span>
        <p>{{ __('auth.setting_account.step_1_desc') }}</p>
      </div>
      <div class="column has-text-centered">
        <progress class="progress is-info p-0 mb-1 step2" value="0" max="100"></progress>
        <span>{{ __('auth.setting_account.step_2') }}</span>
        <p>{{ __('auth.setting_account.step_2_desc') }}</p>
      </div>
    </div>
    <form method="POST" enctype="multipart/form-data">
      @csrf
      <section class="step_1 box is-active-step animate__backInLeft">
        <div class="columns is-mobile m-0 field">
          <label class="column-2 label">Ảnh đại diện: </label>
          <div class="column-6">
            <figure class="image avatar-image is-128x128 ml-3">
              <img class="is-rounded" src="https://bulma.io/images/placeholders/128x128.png">
              <a class="button is-rounded is-info button-avatar-image">
                <i class="fa-solid fa-camera"></i>
              </a>
            </figure>
          </div>
          <input class="file input-avatar-image" name="avatar_image" type="file">
          <input id="avatar_image_choose" name="avatar_image_choose" type="hidden">
        </div>
        <p class="content mt-2">Or you can choosed one of those image for your avatar: </p>
        <div class="select-default-avatar is-flex is-justify-content-center">
          @foreach ($avatarImages['files'] as $avatar)
            <figure class="image is-128x128 m-3 image-choosing">
              <div class="image-tick">
                <img class="is-rounded" style="background-color: #bfd5d6" src="{{ asset('images/default/tick_image.png') }}">
              </div>
              <img class="is-rounded" style="background-color: #bfd5d6" src="{{ $avatar }}">
            </figure>
          @endforeach
        </div>

        <div class="columns mt-3 is-mobile m-0 field">
          <label class="column-2 label">Ảnh bìa: </label>
          <div class="column">
            <figure class="banner-image image ml-3">
              <img src="{{ asset('images/default/866-1000x520.jpg') }}">
              <a class="button is-rounded is-info button-banner-image">
                <i class="fa-solid fa-camera"></i>
              </a>
            </figure>
          </div>
          <input class="file input-banner-image" name="banner_image" type="file">
        </div>

        <div class="fields mt-3 columns is-justify-content-end">
          <a class="button step_btn is-info is-1-desktop column is-full-mobile mt-2 to_step_2">
            <p>Next</p>
          </a>
        </div>
      </section>
      <section class="step_2 box">
        <div class="field">
          <label class="label">Where do you live?</label>
          <div class="control has-icons-left has-icons-right">
            <input class="input is-success" type="text" name="living_place" value="">
            <span class="icon is-small is-left">
              <i class="fa-solid fa-house"></i>
            </span>
          </div>
        </div>
        <div class="field">
          <label class="label">Where do you work?</label>
          <div class="control has-icons-left has-icons-right">
            <input class="input is-success" type="text" name="working_place" value="">
            <span class="icon is-small is-left">
              <i class="fa-solid fa-house"></i>
            </span>
          </div>
        </div>
        <div class="columns">
          <div class="field column">
            <label class="label">What's your high school?</label>
            <div class="control has-icons-left has-icons-right">
              <input class="input is-success" type="text" name="highschool_name" value="">
              <span class="icon is-small is-left">
                <i class="fa-solid fa-school"></i>
              </span>
            </div>
          </div>
          <div class="field column">
            <label class="label">Start Year?</label>
            <div class="control">
              <div class="select">
                <select class="year-select" name="highschool_start">
                </select>
              </div>
            </div>
          </div>
          <div class="field column">
            <label class="label">Graduated Year?</label>
            <div class="control">
              <div class="select">
                <select class="year-select" name="highschool_gradueted">
                </select>
              </div>
            </div>
          </div>
        </div>
        <div class="columns">
          <div class="field column">
            <label class="label">What's your university?</label>
            <div class="control has-icons-left has-icons-right">
              <input class="input is-success" name="university_name" type="text" value="">
              <span class="icon is-small is-left">
                <i class="fa-solid fa-school"></i>
              </span>
            </div>
          </div>
          <div class="field column">
            <label class="label">Start Year?</label>
            <div class="control">
              <div class="select">
                <select class="year-select" name="university_start">
                </select>
              </div>
            </div>
          </div>
          <div class="field column">
            <label class="label">Graduated Year?</label>
            <div class="control">
              <div class="select">
                <select class="year-select" name="university_gradueted">
                </select>
              </div>
            </div>
          </div>
        </div>
        <div class="field">
          <label class="label">I'm a ...</label>
          <div class="control">
            <div class="select">
              <select name="gender">
                <option>Male</option>
                <option>Female</option>
                <option>Other</option>
              </select>
            </div>
          </div>
        </div>
        <div class="fields is-grouped mt-3 columns is-justify-content-end">
          <a class="button step_btn is-1-desktop is-full-mobile mt-2 column to_step_1">
            <p>Previous</p>
          </a>
          <button class="button step_btn is-info is-1-desktop column is-full-mobile mt-2">
            <p>Submit</p>
          </button>
        </div>
      </section>
    </form>
  </div>
</body>

</html>
