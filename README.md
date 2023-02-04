<p align="center">
    <image style="border-radius: 100%;" src="./public/favicon.ico" width="100px"></image>
    <h2 style="color: #92A8D1; font-size:20px; font-family: `Niconne`, cursive" align="center">Media Social Network</h2>
</p>
<div>
<h4 style="color: #92A8D1">
    1. Requirement
</h4>
<ul>
<li>Composer</li>
<li>PHP 7.4 and Apache, Mysql</li>
<li>Nodejs, Npm</li>
<li>Vue3, Laravel 8</li>
</ul>
</div>

<h4 style="color: #92A8D1">
    2. How to setup this project?
</h4>
<ul>
<li>cd path/to/project</li>
<li>composer install</li>
<li>npm install</li>
<li>Config your env and APP_URL in env that need to be the same with URL in Facebook Developer Console</li>
<li>Run php artisan serve</li>
<li>Run php artisan migrate</li>
<li>Run php artisan db:seed</li>
<li>Run php artisan queue:listen</li>
<li>Run php artisan storage:link</li>
<li>npm run watch</li>
</ul>
<h4 style="color: #92A8D1">
    3. Prepare files default
</h4>
<ul>
    <li>First, go to /storage/app/public and create defaults/avatars and defaults/background</li>
    <li>With setting up background default image you need create a background.png file. This is the default background image of user in case when user setting up their account has no choose any image of background.</li>
    <li>As same as above, with avatar image default, you should add more images into this folder with any name you want. All of these images gonna be choises for user setting up their account.</li>
</ul>
</div>
