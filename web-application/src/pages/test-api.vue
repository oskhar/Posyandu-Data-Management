<template></template>

<script>
import config from "@/@core/config.vue";
import axios from "axios";

export default {
  methods: {
    // Data EDUKASI
    getEdukasi: async () => {
      const response = await axios.get(
        `${config.urlServer}/api/edukasi?start=1&length=10&search=Veritatis aut est magni eum labore debitis`,
        {
          headers: {
            Authorization: localStorage.getItem("tokenAuth"),
          },
        }
      );
      console.log(response);
    },

    // Data SURAT
    getSurat: async () => {
      const response = await axios.get(
        `${config.urlServer}/api/kader-gendong?page=2&length=1`,
        {
          headers: {
            Authorization: localStorage.getItem("tokenAuth"),
          },
        }
      );
      console.log(response);
    },
    postSurat: async () => {
      const data = {
        penanda_tangan: "Dr. Susilo Bambang",
        tanggal_surat: "2024-07-20",
        nomor: "SPK/IV/2024",
        kalimat_pembuka: "<p>Dengan hormat,</p>",
        isi_surat: `<p>Sehubungan dengan program kerja sama antar posyandu yang membutuhkan kader gendong, kami menugaskan beberapa kader untuk membantu dalam kegiatan tersebut. Kegiatan ini akan dilaksanakan mulai tanggal 1 Agustus 2024 hingga 31 Agustus 2024. Diharapkan kader yang ditugaskan dapat bekerja sama dengan baik dan menjalankan tugas dengan penuh tanggung jawab.</p>`,
        kalimat_penutup:
          "<p>Demikian surat penugasan ini kami buat, untuk dilaksanakan dengan sebaik-baiknya. Atas perhatian dan kerjasamanya, kami ucapkan terima kasih.</p>",
        ditugaskan: [
          {
            nama: "Siti Aminah",
            jabatan: "Kader Gendong",
            alamat: "Jl. Melati No. 123, Jakarta",
          },
          {
            nama: "Rina Kusuma",
            jabatan: "Kader Gendong",
            alamat: "Jl. Mawar No. 45, Jakarta",
          },
          {
            nama: "Dewi Lestari",
            jabatan: "Kader Gendong",
            alamat: "Jl. Kenanga No. 78, Jakarta",
          },
        ],
      };
      const response = await axios.post(
        `${config.urlServer}/api/kader-gendong`,
        data,
        {
          headers: {
            Authorization: localStorage.getItem("tokenAuth"),
          },
        }
      );
      console.log(response);
    },
    downloadSurat: async () => {
      try {
        const response = await axios.get(
          `${config.urlServer}/api/kader-gendong/2`,
          {
            headers: {
              Authorization: localStorage.getItem("tokenAuth"),
            },
            responseType: "json", // Mengharapkan respons dalam format JSON
          }
        );

        // Mendapatkan konten base64 dari respons
        const base64PDF = response.data;

        // Mengonversi base64 menjadi blob
        const byteCharacters = atob(base64PDF);
        const byteNumbers = new Array(byteCharacters.length);
        for (let i = 0; i < byteCharacters.length; i++) {
          byteNumbers[i] = byteCharacters.charCodeAt(i);
        }
        const byteArray = new Uint8Array(byteNumbers);
        const blob = new Blob([byteArray], { type: "application/pdf" });

        // Membuat objek Date yang merepresentasikan waktu saat ini
        const currentDate = new Date();

        // Mendapatkan tahun, bulan, tanggal, jam, menit, dan detik
        const year = currentDate.getFullYear();
        const month = currentDate.getMonth() + 1; // Perlu ditambah 1 karena indeks bulan dimulai dari 0
        const day = currentDate.getDate();
        const hours = currentDate.getHours();
        const minutes = currentDate.getMinutes();
        const seconds = currentDate.getSeconds();
        const currentDateTime = `_${year}-${month}-${day}_${hours}:${minutes}:${seconds}`;
        const namaFile = `Surat Tugas - ${currentDateTime}.pdf`;

        // Membuat URL blob dan elemen link untuk mengunduh file
        const url = window.URL.createObjectURL(blob);
        const link = document.createElement("a");
        link.href = url;
        link.setAttribute("download", namaFile);
        document.body.appendChild(link);
        link.click();

        // Membersihkan URL blob dan elemen link
        window.URL.revokeObjectURL(url);
        document.body.removeChild(link);
      } catch (error) {
        console.error("Error downloading the PDF:", error);
      }
    },

    // Data DRAF SURAT
    getDrafSurat: async () => {
      const response = await axios.get(
        `${config.urlServer}/api/kader-gendong/draf?page=2&length=1`,
        {
          headers: {
            Authorization: localStorage.getItem("tokenAuth"),
          },
        }
      );
      console.log(response);
    },
    postDrafSurat: async () => {
      const data = {
        penanda_tangan: "Dr. Susilo Bambang",
        tanggal_surat: "2024-07-20",
        nomor: "SPK/XI/2024",
        kalimat_pembuka: "<p>Dengan hormat,</p>",
        isi_surat: `<p>Sehubungan dengan program kerja sama antar posyandu yang membutuhkan kader gendong, kami menugaskan beberapa kader untuk membantu dalam kegiatan tersebut. Kegiatan ini akan dilaksanakan mulai tanggal 1 Agustus 2024 hingga 31 Agustus 2024. Diharapkan kader yang ditugaskan dapat bekerja sama dengan baik dan menjalankan tugas dengan penuh tanggung jawab.</p>`,
        kalimat_penutup:
          "<p>Demikian surat penugasan ini kami buat, untuk dilaksanakan dengan sebaik-baiknya. Atas perhatian dan kerjasamanya, kami ucapkan terima kasih.</p>",
        ditugaskan: [
          {
            nama: "Siti Aminah",
            jabatan: "Kader Gendong",
            alamat: "Jl. Melati No. 123, Jakarta",
          },
          {
            nama: "Rina Kusuma",
            jabatan: "Kader Gendong",
            alamat: "Jl. Mawar No. 45, Jakarta",
          },
          {
            nama: "Dewi Lestari",
            jabatan: "Kader Gendong",
            alamat: "Jl. Kenanga No. 78, Jakarta",
          },
        ],
      };
      const response = await axios.post(
        `${config.urlServer}/api/kader-gendong/draf`,
        data,
        {
          headers: {
            Authorization: localStorage.getItem("tokenAuth"),
          },
        }
      );
      console.log(response);
    },
    putDrafSurat: async () => {
      const data = {
        penanda_tangan: "Dr. Tesdoang",
        tanggal_surat: "2024-07-20",
        nomor: "SPK/XI/2024",
        kalimat_pembuka: "<p>Dengan hormat,</p>",
        isi_surat: `<p>Sehubungan dengan program kerja sama antar posyandu yang membutuhkan kader gendong, kami menugaskan beberapa kader untuk membantu dalam kegiatan tersebut. Kegiatan ini akan dilaksanakan mulai tanggal 1 Agustus 2024 hingga 31 Agustus 2024. Diharapkan kader yang ditugaskan dapat bekerja sama dengan baik dan menjalankan tugas dengan penuh tanggung jawab.</p>`,
        kalimat_penutup:
          "<p>Demikian surat penugasan ini kami buat, untuk dilaksanakan dengan sebaik-baiknya. Atas perhatian dan kerjasamanya, kami ucapkan terima kasih.</p>",
        ditugaskan: [
          {
            nama: "Siti Aminah",
            jabatan: "Kader Gendong",
            alamat: "Jl. Melati No. 123, Jakarta",
          },
          {
            nama: "Tes lagi",
            jabatan: "Kader Gendong",
            alamat: "Jl. Mawar No. 45, Jakarta",
          },
        ],
      };
      const response = await axios.put(
        `${config.urlServer}/api/kader-gendong/draf/15`,
        data,
        {
          headers: {
            Authorization: localStorage.getItem("tokenAuth"),
          },
        }
      );
      console.log(response);
    },
    deleteDrafSurat: async () => {
      const response = await axios.delete(
        `${config.urlServer}/api/kader-gendong/draf/14`,
        {
          headers: {
            Authorization: localStorage.getItem("tokenAuth"),
          },
        }
      );
      console.log(response);
    },
    postCetakDrafSurat: async () => {
      const response = await axios.post(
        `${config.urlServer}/api/kader-gendong/draf/cetak/15`,
        {},
        {
          headers: {
            Authorization: localStorage.getItem("tokenAuth"),
          },
        }
      );
      console.log(response);
    },
  },
  mounted() {
    // this.getEdukasi();
    this.getSurat();
    // this.postSurat();
    // this.downloadSurat();
    this.getDrafSurat();
    // this.postDrafSurat();
    // this.putDrafSurat();
    // this.postCetakDrafSurat();
    this.deleteDrafSurat();
  },
};
</script>
