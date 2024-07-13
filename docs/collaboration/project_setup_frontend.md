## Project Setup

Dalam pembuatan software, terutama saat kolaborasi kita perlu memikirkan berbagai teknologi yang sekiranya dapat digunakan oleh tim dengan baik. Pada bagian ini akan dijelaskan mengenai berbagai persiapan yang perlu dilakukan menggunakan teknologi yang sudah disepakati.

### Install and Config for `Prepare`

#### 1. Install node module

Menginstall semua kebutuhan front end untuk menghias web menggunakan alat alat yang disediakan dalam javascript

```sh
npm install
```

> **Note**: Pastikan npm (node package manager) menginstall semuanya dengan baik
>
> - [Error dan cara mengatasinya](../errors/npm_install.md)
> - [Tempat diksusi tentang error](https://vitejs.dev/config/)

### Mempersiapkan Environment Variables

Copy file `.env.example` dan ubah namanya menjadi `.env`. Jika sudah, kita bisa mengisi variable-variable tersebut sesuai dengan lingkungan development kita.

### Compile and Hot-Reload for `Development`

```sh
npm run dev
```

### Type-Check, Compile and Minify for `Production`

#### Launch masa production

> **Note**: Hanya dijalankan jika app sudah sepenuhnya selesai

```sh
npm run build
```
