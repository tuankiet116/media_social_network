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

let partJson = {
    "particles": {
      "number": {
        "value": 500,
        "density": {
          "enable": true,
          "value_area": 800
        }
      },
      "color": {
        "value": "#ffffff"
      },
      "shape": {
        "type": "circle",
        "stroke": {
          "width": 0,
          "color": "#000000"
        },
        "polygon": {
          "nb_sides": 5
        },
        "image": {
          "src": "img/github.svg",
          "width": 100,
          "height": 100
        }
      },
      "opacity": {
        "value": 0.5,
        "random": false,
        "anim": {
          "enable": false,
          "speed": 1,
          "opacity_min": 0.1,
          "sync": false
        }
      },
      "size": {
        "value": 3,
        "random": true,
        "anim": {
          "enable": false,
          "speed": 40,
          "size_min": 0.1,
          "sync": false
        }
      },
      "line_linked": {
        "enable": true,
        "distance": 150,
        "color": "#ffffff",
        "opacity": 0.4,
        "width": 1
      },
      "move": {
        "enable": true,
        "speed": 6,
        "direction": "none",
        "random": false,
        "straight": false,
        "out_mode": "out",
        "bounce": false,
        "attract": {
          "enable": false,
          "rotateX": 600,
          "rotateY": 1200
        }
      }
    },
    "interactivity": {
      "detect_on": "canvas",
      "events": {
        "onhover": {
          "enable": true,
          "mode": "repulse"
        },
        "onclick": {
          "enable": true,
          "mode": "push"
        },
        "resize": true
      },
      "modes": {
        "grab": {
          "distance": 400,
          "line_linked": {
            "opacity": 1
          }
        },
        "bubble": {
          "distance": 400,
          "size": 40,
          "duration": 2,
          "opacity": 8,
          "speed": 3
        },
        "repulse": {
          "distance": 200,
          "duration": 0.4
        },
        "push": {
          "particles_nb": 4
        },
        "remove": {
          "particles_nb": 2
        }
      }
    },
    "retina_detect": true
  };
  var jsonUri = "data:text/plain;base64,"+window.btoa(JSON.stringify(partJson));
  /* particlesJS.load(@dom-id, @path-json, @callback (optional)); */
  particlesJS.load('particles-js', jsonUri, function() {
    console.log('callback - particles.js config loaded');
  });