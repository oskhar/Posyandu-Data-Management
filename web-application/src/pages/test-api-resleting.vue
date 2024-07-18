<template></template>

<script>
import config from "@/@core/config";
import axios from "axios";

export default {
  mounted() {
    // this.deleteTantangan();
    // this.getTantangan();
    // this.registerUser();

    // this.loginUser();
    // this.authUser();
    // this.putUser();
    this.resetPasswordUser();
  },
  methods: {
    // Data AUTENTIKASI USER
    registerUser: async () => {
      const data = {
        email: "user@gmail.com",
        password: "1234568",
        nama: "user",
        whatsapp: "98765434567",
      };

      const response = await axios.post(
        `${config.urlServer}/api/user/register`,
        data,
        {
          headers: {
            Authorization: localStorage.getItem("tokenAuth"),
          },
        }
      );

      console.log(response);
    },
    loginUser: async () => {
      const data = {
        email: "user@gmail.com",
        password: "1234568",
      };

      const response = await axios.post(
        `${config.urlServer}/api/user/login`,
        data,
        {
          headers: {
            Authorization: localStorage.getItem("tokenAuth"),
          },
        }
      );

      localStorage.setItem("tokenAuth", "Bearer " + response.data.token);

      console.log(response);
    },
    authUser: async () => {
      const data = {};

      const response = await axios.post(
        `${config.urlServer}/api/user/auth`,
        data,
        {
          headers: {
            Authorization: localStorage.getItem("tokenAuth"),
          },
        }
      );

      console.log(response);
    },
    putUser: async () => {
      const data = {
        email: "user@gmail.com",
        password: "1234568",
        nama: "user",
        whatsapp: "98765434567",
        foto_profile: "tes foto",
      };

      const response = await axios.put(`${config.urlServer}/api/user`, data, {
        headers: {
          Authorization: localStorage.getItem("tokenAuth"),
        },
      });

      console.log(response);
    },
    resetPasswordUser: async () => {
      const data = {
        old_password: "1234568",
        new_password: "123456",
        confirm_password: "123456",
      };

      const response = await axios.put(
        `${config.urlServer}/api/user/reset-password`,
        data,
        {
          headers: {
            Authorization: localStorage.getItem("tokenAuth"),
          },
        }
      );

      console.log(response);
    },

    // Data TANTANGAN
    getTantangan: async () => {
      const response = await axios.get(
        `${config.urlServer}/api/resleting/tantangan?page=1&length=1`,
        {
          headers: {
            Authorization: localStorage.getItem("tokenAuth"),
          },
        }
      );

      console.log(response);
    },
    postTantangan: async () => {
      const data = {
        judul: "Tantangan Poster Edukasi Stunting",
        gambar: "https://example.com/images/poster-edukasi-stunting.jpg",
        deskripsi:
          "Buatlah poster yang edukatif dan menarik tentang pentingnya pencegahan stunting pada anak-anak. Poster harus menyertakan informasi tentang penyebab stunting, dampak stunting pada perkembangan anak, dan langkah-langkah yang bisa diambil untuk mencegah stunting.",
        overview:
          "Tantangan ini bertujuan untuk meningkatkan kesadaran remaja tentang masalah stunting dan bagaimana mereka dapat berkontribusi dalam upaya pencegahannya melalui media kreatif seperti poster.",
        tanggal_mulai: "2024-08-01",
        tanggal_selesai: "2024-08-31",
      };

      const response = await axios.post(
        `${config.urlServer}/api/resleting/tantangan`,
        data,
        {
          headers: {
            Authorization: localStorage.getItem("tokenAuth"),
          },
        }
      );

      console.log(response);
    },
    putTantangan: async () => {
      const data = {
        judul: "Put Tesdoang",
        gambar: "https://example.com/images/poster-edukasi-stunting.jpg",
        deskripsi:
          "Buatlah poster yang edukatif dan menarik tentang pentingnya pencegahan stunting pada anak-anak. Poster harus menyertakan informasi tentang penyebab stunting, dampak stunting pada perkembangan anak, dan langkah-langkah yang bisa diambil untuk mencegah stunting.",
        overview:
          "Tantangan ini bertujuan untuk meningkatkan kesadaran remaja tentang masalah stunting dan bagaimana mereka dapat berkontribusi dalam upaya pencegahannya melalui media kreatif seperti poster.",
        tanggal_mulai: "2024-08-01",
        tanggal_selesai: "2024-08-31",
        foto_profile: "foto_profile",
      };

      const response = await axios.put(
        `${config.urlServer}/api/resleting/tantangan/1`,
        data,
        {
          headers: {
            Authorization: localStorage.getItem("tokenAuth"),
          },
        }
      );

      console.log(response);
    },
    deleteTantangan: async () => {
      const response = await axios.delete(
        `${config.urlServer}/api/resleting/tantangan/1`,
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
