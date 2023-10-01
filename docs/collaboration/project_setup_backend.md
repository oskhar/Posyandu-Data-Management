## Project Setup

Dalam pembuatan software, terutama saat kolaborasi kita perlu memikirkan berbagai teknologi yang sekiranya dapat digunakan oleh tim dengan baik. Pada bagian ini akan dijelaskan mengenai berbagai persiapan yang perlu dilakukan menggunakan teknologi yang sudah disepakati.

### Install and Config for `Prepare`

#### 1. Install list depedensi composer

Dengan menjalankan `composer install` pada console (terminal/cmd), anda akan menginstall semua depedensi yang dibutuhkan pada aplikasi ini.

```sh
composer install
```

> **Note**: Pastikan composer menginstall semuanya dengan baik
>
> - [Error dan cara mengatasinya](../errors/composer_install.md)
> - [Tempat diksusi tentang error](https://vitejs.dev/config/)

#### 2. Meng-generate key enkripsi

```sh
php artisan key:generate
```

### Compile and Hot-Reload for `Development`

```sh
php artisan serve
```
