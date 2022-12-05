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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
  <script src="https://kit.fontawesome.com/62474f8a4e.js" crossorigin="anonymous"></script>
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
        <input class="file input-avatar-image" type="file">
      </div>

      <div class="columns mt-3 is-mobile m-0 field">
        <label class="column-2 label">Ảnh bìa: </label>
        <div class="column">
          <figure class="banner-image image ml-3">
            <img src="https://bulma.io/images/placeholders/128x128.png">
            <a class="button is-rounded is-info button-banner-image">
              <i class="fa-solid fa-camera"></i>
            </a>
          </figure>
        </div>
        <input class="file input-banner-image" type="file">
      </div>

      <div class="fields mt-3 columns is-justify-content-end">
        <a class="button is-1-desktop is-full-mobile mt-2 column">Skip</a>
        <a class="button is-info is-1-desktop column is-full-mobile mt-2 to_step_2">Next</a>
      </div>

      <div class="modal">
        <div class="modal-background"></div>
        <div class="modal-content">
          <p class="image is-4by3">
            <img src="https://bulma.io/images/placeholders/1280x960.png" alt="">
          </p>
        </div>
        <button class="modal-close is-large" aria-label="close"></button>
      </div>
    </section>
    <section class="step_2 box">
      <div class="field">
        <label class="label">Name</label>
        <div class="control">
          <input class="input" type="text" placeholder="Text input">
        </div>
      </div>

      <div class="field">
        <label class="label">Username</label>
        <div class="control has-icons-left has-icons-right">
          <input class="input is-success" type="text" placeholder="Text input" value="bulma">
          <span class="icon is-small is-left">
            <i class="fas fa-user"></i>
          </span>
          <span class="icon is-small is-right">
            <i class="fas fa-check"></i>
          </span>
        </div>
        <p class="help is-success">This username is available</p>
      </div>

      <div class="field">
        <label class="label">Gender</label>
        <div class="control">
          <div class="select">
            <select>
              <option>Male</option>
              <option>Female</option>
              <option>Other</option>
            </select>
          </div>
        </div>
      </div>

      <div class="field is-grouped">
        <div class="control">
          <button class="button is-link">Submit</button>
        </div>
        <div class="control">
          <button class="button is-link is-light">Cancel</button>
        </div>
      </div>
      <div class="fields mt-3 columns is-justify-content-end">
        <a class="button is-1-desktop is-full-mobile mt-2 column to_step_1">Previous</a>
        <a class="button is-info is-1-desktop column is-full-mobile mt-2">Submit</a>
      </div>
    </section>
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

  input[type='file'] {
    display: none
  }

  .avatar-image {
    cursor: pointer;
  }

  .avatar-image img {
    width: 128px !important;
    height: 128px !important;
  }

  .button.is-rounded {
    padding-bottom: calc(0.5em - 1px);
    padding-left: calc(0.75em - 1px);
    padding-right: calc(0.75em - 1px);
    padding-top: calc(0.5em - 1px);
  }

  .button-avatar-image {
    position: absolute;
    bottom: 0;
    right: 0;
  }

  .banner-image,
  .banner-image img {
    height: 20rem !important;
    width: 40rem !important;
  }

  .is-active-step {
    display: block !important;
  }

  @media only screen and (max-width: 540px) {

    .banner-image,
    .banner-image img {
      height: 7rem !important;
      width: 14rem !important;
    }

    .container-header,
    .step_section {
      padding: 1rem
    }
  }

  @media only screen and (max-width: 320px) {

    .banner-image,
    .banner-image img {
      height: 5rem !important;
      width: 10rem !important;
    }
  }

  .button-banner-image {
    position: absolute;
    bottom: -1rem;
    right: -1rem;
  }

  section {
    padding-bottom: 4rem;
    display: none !important;
  }

  a.is-1-desktop {
    margin-right: 1rem;
  }

  .animate__backInLeft {
    animation-duration: 0.5s;
  }

  .animate__backOutLeft {
    animation-duration: 0.5s;
  }

  .animate__backInRight {
    animation-duration: 0.5s;
  }

  .animate__backOutRight {
    animation-duration: 0.5s;
  }
</style>
<script>
  $('.avatar-image').click(function() {
    $('.input-avatar-image').click();
  });

  $('.banner-image').click(function() {
    $('.input-banner-image').click();
  });

  $('.input-avatar-image').change(function(e) {
    let img = $('.avatar-image>img');
    let reader = new FileReader();

    reader.readAsDataURL(this.files[0]);
    reader.addEventListener('load', function() {
      img[0].src = reader.result;
    });
  });

  $('.input-banner-image').change(function(e) {
    let img = $('.banner-image>img');
    let reader = new FileReader();

    reader.readAsDataURL(this.files[0]);
    reader.addEventListener('load', function() {
      img[0].src = reader.result;
    });
  });

  increaseValueProgress('.step1', start = 0, end = 50);

  $('.to_step_1').click(async function() {
    await decreaseValueProgress('.step2', start = 50, end = 0);
    await decreaseValueProgress('.step1', start = 100, end = 50);
    await $('.step_2').removeClass('animate__backInRight');
    await setTimeOutPromise(500, () => {
      $('.step_2').addClass('animate__backOutRight');
    });
    await $('.step_2').removeClass('is-active-step');
    await $('.step_2').removeClass('animate__backOutRight');


    await $('.step_1').addClass('is-active-step');
    await setTimeOutPromise(500, () => {
      $('.step_1').addClass('animate__backInLeft');
    });
  });

  $('.to_step_2').click(async function() {
    await increaseValueProgress('.step1', start = 50, end = 100);
    await increaseValueProgress('.step2', start = 0, end = 50);
    await $('.step_1').removeClass('animate__backInLeft');
    await setTimeOutPromise(500, () => {
      $('.step_1').addClass('animate__backOutLeft');
    });
    await $('.step_1').removeClass('is-active-step');
    await $('.step_1').removeClass('animate__backOutLeft');


    await $('.step_2').addClass('is-active-step');
    await setTimeOutPromise(500, () => {
      $('.step_2').addClass('animate__backInRight');
    });
  });

  function increaseValueProgress(stepEl, start = 0, end = 50) {
    return new Promise((resolve, reject) => {
      let loop = setInterval(() => {
        let i = start++;
        $(stepEl).attr('value', i);
        if (i == end) {
          clearInterval(loop);
          resolve('end');
        }
      }, 0.5);
    });
  }

  function decreaseValueProgress(stepEl, start = 100, end = 0) {
    return new Promise((resolve, reject) => {
      let loop = setInterval(() => {
        let i = start--;
        $(stepEl).attr('value', i);
        if (i == end) {
          clearInterval(loop);
          resolve('end');
        }
      }, 0.5);
    });
  }

  function setTimeOutPromise(milisecond, func) {
    return new Promise(async (resolve, reject) => {
      await func();
      setTimeout(async () => {
        resolve('end');
      }, milisecond);
    })
  }
</script>

</html>
