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
  <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
  <link rel="stylesheet" href="{{ asset('css/accountSetting.css') }}">
</head>

<body>
  <div class="container container-header">
    <h1 class="title">{{ __('auth.setting_account.welcome', ['name' => auth()->user()->name]) }}</h1>
    <p>{{ __('auth.setting_account.first_need') }}</p>
  </div>
  @if ($errors->any())
    <article class="message is-danger container">
      <div class="message-header">
        <p>Error</p>
        <button class="delete" aria-label="delete"></button>
      </div>
      <div class="message-body">
        @foreach ($errors->all() as $error)
          <p><strong><i class="fa-solid fa-circle-exclamation"></i></strong> {{ $error }}</p>
        @endforeach
      </div>
    </article>
  @endif
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
    <form method="POST" enctype="multipart/form-data" action="{{ route('user.post_setting') }}">
      @csrf
      <section class="step_1 box is-active-step animate__backInLeft">
        <div class="columns is-mobile m-0 field">
          <label class="column-2 label">{{ __('attributes.avatar_image') }}: </label>
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
        <p class="content mt-2">{{ __('auth.setting_account.or_choose_default') }}</p>
        <div class="select-default-avatar is-flex is-justify-content-center">
          @foreach ($avatarImages['files'] as $avatar)
            <figure class="image is-128x128 m-3 image-choosing">
              <div class="image-tick">
                <img class="is-rounded" style="background-color: #bfd5d6"
                  src="{{ asset('images/defaults/tick_image.png') }}">
              </div>
              <img class="is-rounded" style="background-color: #bfd5d6" src="{{ $avatar }}">
            </figure>
          @endforeach
        </div>

        <div class="columns mt-3 is-mobile m-0 field">
          <label class="column-2 label">{{ __('attributes.banner_image') }}: </label>
          <div class="column">
            <figure class="banner-image image ml-3">
              <img src="{{ asset('images/defaults/background/background.png') }}">
              <a class="button is-rounded is-info button-banner-image">
                <i class="fa-solid fa-camera"></i>
              </a>
            </figure>
          </div>
          <input class="file input-banner-image" name="banner_image" type="file">
        </div>

        <div class="fields mt-3 columns is-justify-content-end">
          <a class="button step_btn is-info is-1-desktop column is-full-mobile mt-2 to_step_2">
            <p>{{ __('auth.setting_account.next') }}</p>
          </a>
        </div>
      </section>
      <section class="step_2 box">
        <div class="field">
          <label class="label">{{ __('auth.setting_account.where_live') }}</label>
          <div class="control has-icons-left has-icons-right">
            <input class="input is-success" type="text" name="living_place" value="{{ old('living_place') }}">
            <span class="icon is-small is-left">
              <i class="fa-solid fa-house"></i>
            </span>
          </div>
        </div>
        <div class="field">
          <label class="label">{{ __('auth.setting_account.where_work') }}</label>
          <div class="control has-icons-left has-icons-right">
            <input class="input is-success" type="text" name="working_place" value="{{ old('working_place') }}">
            <span class="icon is-small is-left">
              <i class="fa-solid fa-house"></i>
            </span>
          </div>
        </div>
        <div class="columns">
          <div class="field column">
            <label class="label">{{ __('auth.setting_account.high_school') }}</label>
            <div class="control has-icons-left has-icons-right">
              <input class="input is-success" type="text" name="highschool_name"
                value="{{ old('highschool_name') }}">
              <span class="icon is-small is-left">
                <i class="fa-solid fa-school"></i>
              </span>
            </div>
          </div>
          <div class="field column">
            <label class="label">{{ __('auth.setting_account.time_range') }}</label>
            <div class="control">
              <div class="select">
                <input class="input time-select-highschool" />
                <input class="input" name="highschool_time_start" type="hidden"
                  value="{{ old('highschool_time_start') }}">
                <input class="input" name="highschool_time_end" type="hidden"
                  value="{{ old('highschool_time_end') }}">
              </div>
            </div>
          </div>
        </div>
        <div class="columns">
          <div class="field column">
            <label class="label">{{ __('auth.setting_account.university') }}</label>
            <div class="control has-icons-left has-icons-right">
              <input class="input is-success" name="university_name" type="text"
                value="{{ old('university_name') }}">
              <span class="icon is-small is-left">
                <i class="fa-solid fa-school"></i>
              </span>
            </div>
          </div>
          <div class="field column">
            <label class="label">{{ __('auth.setting_account.time_range') }}</label>
            <div class="control">
              <div class="select">
                <input class="input time-select-university" type="text" value="">
                <input class="input" name="university_time_start" type="hidden"
                  value="{{ old('university_time_start') }}">
                <input class="input" name="university_time_end" type="hidden"
                  value="{{ old('university_time_end') }}">
              </div>
            </div>
          </div>
        </div>
        <div class="field">
          <label class="label">{{ __('auth.setting_account.i_am') }}</label>
          <div class="control">
            <div class="select">
              <select name="gender">
                <option value="male">{{ __('auth.setting_account.male') }}</option>
                <option value="female">{{ __('auth.setting_account.female') }}</option>
                <option value="other">{{ __('auth.setting_account.other') }}</option>
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
<script>
  $(document).ready(function() {
    const formatDate = 'DD/MM/YYYY';
    const startFormat = moment().format(formatDate);
    const endFormat = moment().format(formatDate);

    let highschool_time_start = "{{ old('highschool_time_start') }}" == "" ? startFormat : "{{ old('highschool_time_start') }}";
    let highschool_time_end = "{{ old('highschool_time_end') }}" == "" ? endFormat : "{{ old('highschool_time_end') }}";
    let university_time_start = "{{ old('university_time_start') }}" == "" ? startFormat : "{{ old('university_time_start') }}";
    let university_time_end = "{{ old('university_time_end') }}" == "" ? endFormat : "{{ old('university_time_end') }}";

    $('input[name="highschool_time_start"]').val(highschool_time_start);
    $('input[name="highschool_time_end"]').val(highschool_time_end);
    $('input[name="university_time_start"]').val(university_time_start);
    $('input[name="university_time_end"]').val(university_time_end);

    console.log(highschool_time_end)
    $('.time-select-highschool').daterangepicker({
      opens: 'left',
      autoApply: true,
      startDate: highschool_time_start,
      endDate: highschool_time_end,
      locale: {
        format: formatDate
      }
    }, function(start, end, label) {
      const startFormat = start.format(formatDate);
      const endFormat = end.format(formatDate);
      $('input[name="highschool_time_start"]').val(startFormat);
      $('input[name="highschool_time_end"]').val(endFormat);
      return startFormat + ' - ' + endFormat
    });

    $('.time-select-university').daterangepicker({
      opens: 'left',
      autoApply: true,
      startDate: moment(new Date(university_time_start)).format(formatDate),
      endDate: moment(new Date(university_time_end)).format(formatDate),
      locale: {
        format: formatDate
      }
    }, function(start, end, label) {
      const startFormat = start.format(formatDate);
      const endFormat = end.format(formatDate);
      $('input[name="university_time_start"]').val(startFormat);
      $('input[name="university_time_end"]').val(endFormat);
      return startFormat + ' - ' + endFormat
    });
  });
</script>

</html>
