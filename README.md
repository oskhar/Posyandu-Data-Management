# Application Architecture

![](/docs/Conclusion.png)

- Software Requirement Specification [download.](/docs/architecture/system/SRS.pdf)
- Rincian mengenai rancangan basis data click [di sini.](/docs/architecture/database/README.md)
- Konsep rancangan click [di sini.](/docs/architecture/Application-Architecture.png)

# Aplikasi Posyandu Melati

Proyek kuliah sebagai wadah untuk berkolaborasi, memahami, dan mengembangkan konsep-konsep rekayasa perangkat lunak secara praktis. Menggunakan metodologi yang relevan dan praktik terbaik untuk merancang, mengembangkan, dan mendokumentasikan perangkat lunak.

## Tech Stack

- PHP -- version ^8.1 -- myversion 8.2.10
- Laravel -- version 10.25.0
- Vue -- version 3.3.4
- Vuetify -- version 3.3.1
- NPM -- myversion 9.8.1
- Composer -- myversion 2.5.2
- vite -- version ^4.2.3
- Materio -- version 2.0
- Sneat -- version 1.0

## Model SDLC

- Untuk proses pada tahap awal kita mengadopsi `model prototyping`
- Tahap implementasi kita menggunakan metodelogi pengembangan software `scrum`
- Secara keseluruhan penerapan model yang kita gunakan lebih condong ke model `RAD` (Rapid Application Development)

> **Note**: Model ini merupakan pendekatan yang dipakai dalam pengembangan aplikasi. Dan sifatnya tidak absolute, mengikuti penyesuaianan yang ada, tapi tetap memenuhi standar yang sudah ditentukan tanpa merusak alurnya. Perubahan bisa saja terjadi dalam tahap penilaian dari Dosen Bu Dewi (sebagai penguji independen).
>
> - [Rincian setiap model](/docs/SDLC/rincian.md)
> - [Alasan penggunaan model](/docs/SDLC/alasan.md)

## Collaboration Setup

Project ini hanya berfokus pada penyelesaian tugas. Tapi kontibusi dari pihak luar juga sangat diterima di sini, kami berharap project ini dapat berguna untuk jangkauan luas.

- [Cara setup project - Front-End](/docs/collaboration/project_setup_frontend.md)
- [Cara setup project - Back-End](/docs/collaboration/project_setup_backend.md)

#### Menjalankan API Laravel

```sh
cd laravel
```

```sh
npm php artisan serve
```

#### Menjalankan aplikasi Vue

```sh
cd vue
```

```sh
npm run dev
```
