$(document).ready(function() {
    // Year Dropdown
    for(let i = 1970; i<= new Date().getFullYear() + 20; i++) {
        $('.year-select').append(`<option>${i}</option>`);
    }



    $('.avatar-image').click(function () {
        $('.input-avatar-image').click();
    });
    
    $('.banner-image').click(function () {
        $('.input-banner-image').click();
    });
    
    $('.input-avatar-image').change(function (e) {
        let img = $('.avatar-image>img');
        let reader = new FileReader();
    
        reader.readAsDataURL(this.files[0]);
        reader.addEventListener('load', function () {
            img[0].src = reader.result;
        });
    });
    
    $('.input-banner-image').change(function (e) {
        let img = $('.banner-image>img');
        let reader = new FileReader();
    
        reader.readAsDataURL(this.files[0]);
        reader.addEventListener('load', function () {
            img[0].src = reader.result;
        });
    });
    
    increaseValueProgress('.step1', start = 0, end = 50);
    
    $('.to_step_1').click(async function () {
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
    
    $('.to_step_2').click(async function () {
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
});
