<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Project

Website yang memberikan layanan kepada Shalltears Clothing Store, untuk membantu menentukan desain produksi dengan sistem voting. Desainer Terdaftar dapat berkontribusi, webiste ini juga membantu toko menjual produknya. Dibangun dengan Laravel dan terintegrasi dengan external payment gateway (Midtrans). Website ini juga sudah menerapkan sistem pemesanan dengan keranjang dan memastikan stok produk tetap konsisten.

## How To Use

- composer install
- php artisan migrate:fresh --seed
- php artisan queue:work
- npm install
- npm run dev


## Built With

- Laravel 9
- MySQL
- PHP Midtrans Payment Gateway (Snap version)
- Laravel dompdf
- Bootstrap
- Jquery

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
