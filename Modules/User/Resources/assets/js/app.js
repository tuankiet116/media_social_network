const { default: axios } = require("axios");

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
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) {
            return;
        }
        js = d.createElement(s);
        js.id = id;
        js.src = "https://connect.facebook.net/en_US/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
});

function checkUserFBLogin() {
    FB.getLoginStatus(function (result) {
        if (result.status == "connected") {
            let data = result.authResponse;
            FB.api('/me?fields=name,id,email', function (response) {
                data.email = response.email;
                data.name = response.name;
                userAPI(data).then((result) => {

                });
            });
        }
    });
}

function userAPI(data) {
    return axios({
        method: 'POST',
        url: '/api/user/facebook_login',
        data: data
    })
}