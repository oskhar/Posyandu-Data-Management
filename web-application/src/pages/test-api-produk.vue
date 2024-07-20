<template>
  <h1>Tesdoang</h1>
  <h1>Tesdoang</h1>
  <h1>Tesdoang</h1>
  <h1>Tesdoang</h1>
  <h1>Tesdoang</h1>
  <h1>Tesdoang</h1>
</template>

<script>
import config from "@/@core/config";
import axios from "axios";

export default {
  mounted() {
    this.getProduk();
    this.postProduk();
    // this.deleteProduk();
  },
  methods: {

    // Data PRODUK
    getProduk: async () => {
      try {
        const response = await axios.get(
          `${config.urlServer}/api/produk`,
          {
            params: {
              page: 1,
              length: 8,
            },
        });

        console.log(response);
      } catch (error) {
        console.log(error);
      }
    },
    postProduk: async () => {
      const data = {
        
      };

      const response = await axios.post(
        `${config.urlServer}/api/produk`,
        data,
        {
          headers: {
            Authorization: localStorage.getItem("tokenAuth"),
          },
        }
      );

      console.log(response);
    },
    putProduk: async () => {
      const data = {
        judul: "Put Tesdoang",
        gambar: "https://example.com/images/poster-edukasi-stunting.jpg",
        deskripsi:
          "Buatlah poster yang edukatif dan menarik tentang pentingnya pencegahan stunting pada anak-anak. Poster harus menyertakan informasi tentang penyebab stunting, dampak stunting pada perkembangan anak, dan langkah-langkah yang bisa diambil untuk mencegah stunting.",
        overview:
          "Produk ini bertujuan untuk meningkatkan kesadaran remaja tentang masalah stunting dan bagaimana mereka dapat berkontribusi dalam upaya pencegahannya melalui media kreatif seperti poster.",
        tanggal_mulai: "2024-08-01",
        tanggal_selesai: "2024-08-31",
        foto_profile: "foto_profile",
      };

      const response = await axios.put(
        `${config.urlServer}/api/produk/1`,
        data,
        {
          headers: {
            Authorization: localStorage.getItem("tokenAuth"),
          },
        }
      );

      console.log(response);
    },
    deleteProduk: async () => {
      const response = await axios.delete(
        `${config.urlServer}/api/produk/1`,
        {
          headers: {
            Authorization: localStorage.getItem("tokenAuth"),
          },
        }
      );

      console.log(response);
    },
  },
};
</script>
