/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!*************************************************!*\
  !*** ./Modules/User/Resources/assets/js/app.js ***!
  \*************************************************/
$(document).ready(function () {
  window.fbAsyncInit = function () {
    FB.init({
      appId: '520447719756704',
      xfbml: true,
      version: 'v15.0'
    });
    FB.AppEvents.logPageView();
    checkUserFBLogin();
  };
  (function (d, s, id) {
    var js,
      fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) {
      return;
    }
    js = d.createElement(s);
    js.id = id;
    js.src = "https://connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
  })(document, 'script', 'facebook-jssdk');
});
function checkUserFBLogin() {
  FB.getLoginStatus(function (response) {
    if (response.status == "connected") {
      FB.api('/me?fields=name,id,email', function (response) {
        debugger;
      });
    }
  });
}
function userAPI() {
  $.ajax('');
}
/******/ })()
;