# Aplikasi Posyandu Melati

Proyek kuliah sebagai wadah untuk berkolaborasi, memahami, dan mengembangkan konsep-konsep rekayasa perangkat lunak secara praktis. Menggunakan metodologi yang relevan dan praktik terbaik untuk merancang, mengembangkan, dan mendokumentasikan perangkat lunak.

## Recommended IDE Setup

[VSCode](https://code.visualstudio.com/) + [Volar](https://marketplace.visualstudio.com/items?itemName=johnsoncodehk.volar) (and disable Vetur).

## Tech Stack
- Laravel <sup>(version 10.13.0)</sup>
- Vue <sup>(version 3.3.4)</sup>
- Materio-Laravel-Vue-Template<sup>(version 2.0)</sup>
- NPM <sup>(myVersion 9.8.1)</sup>
- Composer <sup>(myVersion 2.5.2)</sup>

## Customize configuration

See [Vite Configuration Reference](https://vitejs.dev/config/).

## Project Setup

#### 1. Install list depedensi composer
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
