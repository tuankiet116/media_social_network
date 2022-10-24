const { default: axios } = require("axios");

$(document).ready(function () {
    window.fbAsyncInit = function () {
        FB.init({
            appId: '520447719756704',
            xfbml: true,
            version: 'v15.0'
        });
        FB.AppEvents.logPageView();
        FB.getLoginStatus(async function (result) {
            if (result.status == "connected") {
                let data = result.authResponse;
                let res = await getUserFbInfor();
                data.name = res.name;
                data.email = res.email;
                await userFbAuthHandle(data);
            }
        });

        FB.Event.subscribe('auth.authResponseChange', async function (result) {
            if (result.status == "connected") {
                let data = result.authResponse;
                let res = await getUserFbInfor();
                data.name = res.name;
                data.email = res.email;
                await userFbAuthHandle(data);
            }
        });
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

function getUserFbInfor() {
    return new Promise(async function (resolve, reject) {
        await FB.api('/me?fields=name,id,email', function (response) {
            resolve(response);
        });
    });
}

function userFbAuthHandle(data) {
    return new Promise(function (resolve, reject) {
        axios({
            method: 'POST',
            url: '/api/user/facebook_login',
            data: data
        }).then(function (result) {
            if (result.data.code == 200) {
                location.href = '/';
            }
        });
    });
}