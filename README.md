# Aplikasi Posyandu Melati

Proyek kuliah sebagai wadah untuk berkolaborasi, memahami, dan mengembangkan konsep-konsep rekayasa perangkat lunak secara praktis. Menggunakan metodologi yang relevan dan praktik terbaik untuk merancang, mengembangkan, dan mendokumentasikan perangkat lunak.

## Tech Stack
- PHP -- version ^8.1 -- myversion 8.2.10
- Laravel -- version 10.13.0
- Vue -- version 3.3.4
- Materio-Templat -- version 2.0
- NPM -- myversion 9.8.1
- Composer -- myversion 2.5.2
- vite -- version ^4.2.3

## Project Setup

#### 1. Install list depedensi composer
Dengan menjalankan `composer install` pada console (terminal/cmd), anda akan menginstall semua depedensi yang dibutuhkan pada aplikasi ini.
```sh
composer install
```
> **Note**: Pastikan composer menginstall semuanya dengan baik
> - [Error dan cara mengatasinya](/docs/errors/composer_install.md)
> - [Tempat diksusi tentang error](https://vitejs.dev/config/)

#### 2. Install node module
Menginstall semua kebutuhan front end untuk menghias web menggunakan alat alat yang disediakan dalam javascript

```sh
npm install
```
> **Note**: Pastikan npm (node package manager) menginstall semuanya dengan baik
> - [Error dan cara mengatasinya](/docs/errors/npm_install.md)
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
