<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# Cyberpunkwaifus gallery engine type-blog
### Description: 
Cbpw allows you to create an album and upload images.
Manage your images with an amazing full one page menu, developed from scratch with Laravel and Livewire technology.

### Features:
* Admin Panel and Permissions System
* Relational Database design from Scratch
* Dropzone to upload images
* Front-end developed with Boostrap 4 and Livewire to asyncronous request. Masonry, FancyBox and Infinite Scroll use to show Images
* Image render with thumbnail generator using Intervention Image 2.0, and Laravel-FFMPEG/Lakshmaji-Thumbnail to generate thumbnails from Videos
technologies
### Technologies:
* Laravel 8, Livewire 2.0, PHP 7.4, Boostrap 4, CSS, Javascript, AlpineJS, Jquery

### Preview:
<p> <img src="https://github.com/kuronneko/kuronneko.github.io/blob/master/assets/img/portfoliocbpw.png" width="450"> </p>

## How to install
* cp .env.example .env
* composer install
* php artisan key:generate
* php artisan storage:link
* php artisan migrate
* create new account and set it with level 5 (admin) privileges

## License
The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
