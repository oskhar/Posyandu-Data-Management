## Rincian terkait SDLC

Pada bagian ini akan dibahas mengenai model SDLC yang akan digunakan untuk pendekatan perancangan program yang tim kita gunakan. Pembuatan aplikasi terdiri dari beberapa tahapan tahapan berikut:

- sosialisasi awal
- observasi sistem yang akan dibuat
- merancang srs (unstable)
- membuat UI
- wawancara dengan client
- merancang srs (fix)
- Pemodelan database
- Skema API
- Pembuatan aplikasi backend dan frontend kerja secara pararel
- iterasi testing dan fix
- meluncurkan production

### Model Prototype

Kami mengadopsi model prototype pada bagian awal pembuatan aplikasi. Yaitu dengan memperlihatkan aplikasi ke client menggunakan Figma UI yang kami buat berdasarkan SRS (Software Requirement Specification). Dan itu diulang, sampai dapat hasil yang disetujui kedua belah pihak.

Hal ini bertujuan agar client leluasa dalam memberikan pendapatnya terhadap aplikasi yang akan dibuat. Berdasarkan pengalaman kami sebelumnya, pendekatan dengan client hanya dibantu PPT atau teks terkait list list fitur hanya akan membingungkan client dan terkesan terlalu teknis terlebih untuk client yang tidak memiliki background IT.

### Model RAD (Rapid Application Development)

Secara keseluruhan kami menggunakan model RAD, RAD juga memiliki pendekatan dengan client yang terbilang mirip dengan model prototype, tapi bedanya model RAD hanya menggunakan prototype sebagai landasan awal untuk membuat hasil akhir, sedangkan model Prototype melakukan pengujian iterasi (secara terus menerus) sampai batas dimana client puas.

> **Note**: Itu juga salah satu kelemahan model prototype, developer jadi terpaku dengan intrupsi dari client. Cara untuk menanggulangi kelemahan model prototype adalah dengan membuat kesepakatan di awal, atau mengajukan surat perjanjian mengenai standar atau aturan yang harus dipatuhi oleh client.

Penggunaan model prototype kami di awal berguna sebagai landasan awal yang intens agar dapat membangun berbagai skema aplikasi (seperti skema data, skema bisnis, dan skema API) yang baik dan stabil. Yang nantinya akan kami lakukan implementasi program secara pararel (Berjalan masing masing antara backend dan frontend) yang berpedoman dengan skema API yang sudah ditentukan menggunakan standar API yaitu OPENAPI, ini sesuai dengan pola pengembangan model RAD (Rapid Application Development).

### Metodelogi Scrum

Scrum merupakan pertemuan rutin dari tim untuk memberikan tinjauan kemajuan dan prioritas dari pekerjaan yang harus dikerjakan pada hari itu, Scrum akan kami laksanakan dalam tahap implementasi (saat pemrograman aplikasi berlangsung). Dengan tahapan kasar sebagai berikut:

- Planing task yang akan dikerjakan
- Pengerjaan task
- Pengujian (Check, Fix, dan Refactoring)
