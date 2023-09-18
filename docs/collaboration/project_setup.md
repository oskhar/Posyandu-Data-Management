## Project Setup

Dalam pembuatan software, terutama saat kolaborasi kita perlu memikirkan berbagai teknologi yang sekiranya dapat digunakan oleh tim dengan baik. Pada bagian ini akan dijelaskan mengenai berbagai persiapan yang perlu dilakukan menggunakan teknologi yang sudah disepakati.

### Install and Config for **Prepare**
#### 1. Install list depedensi composer
Dengan menjalankan `composer install` pada console (terminal/cmd), anda akan menginstall semua depedensi yang dibutuhkan pada aplikasi ini.
```sh
composer install
```
> **Note**: Pastikan composer menginstall semuanya dengan baik
> - [Error dan cara mengatasinya](../errors/composer_install.md)
> - [Tempat diksusi tentang error](https://vitejs.dev/config/)

#### 2. Install node module
Menginstall semua kebutuhan front end untuk menghias web menggunakan alat alat yang disediakan dalam javascript

```sh
npm install
```
> **Note**: Pastikan npm (node package manager) menginstall semuanya dengan baik
> - [Error dan cara mengatasinya](../errors/npm_install.md)
> - [Tempat diksusi tentang error](https://vitejs.dev/config/)

```sh
npm run build:icons
```

#### 3. Meng-generate key enkripsi
```sh
php artisan key:generate
```

### Compile and Hot-Reload for **Development**

```sh
php artisan serve
```

```sh
npm run dev
```

### Type-Check, Compile and Minify for **Production**

#### Launch masa production

> **Note**: Hanya dijalankan jika app sudah sepenuhnya selesai
```sh
npm run build
```
