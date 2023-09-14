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
> **Note**: Pastikan semuanya terinstall dengan baik
> - [Error dan cara mengatasinya](/docs/errors/composer.md)
> - [Error issue discussion](https://vitejs.dev/config/)
```sh
composer install
```

#### 2. Install node module

> **Note**: Pastikan semuanya terinstall dengan baik
```sh
npm install
```

```sh
npm run build:icons
```

#### 3. Meng-generate key enkripsi milik laravel
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
