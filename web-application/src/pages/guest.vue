<script setup>
import cardEdukasi from "./card-edukasi.vue";
import cardBeritaAcara from "./card-berita-acara.vue";
import cardGaleri from "./card-galeri-guest.vue";
import footerGuest from "./footer-guest.vue";
import Sambutan from "./tentang-guest-atas.vue";
import langit from "@images/pages/2.png";

import UserProfile from "@/layouts/components/UserProfile.vue";
import { ref } from "vue";
import { onMounted } from "vue";
import axios from "axios";
import config from "@/@core/config.vue";

const urlServer = config.urlServer;
let statEdukasi = ref(0);
let statBerita = ref(0);
let statBayi = ref(0);
const fotoProfile = localStorage.getItem("foto_profile") ? localStorage.getItem("foto_profile") : false;

const statGambar = ref(0);

const fetchEdukasi = async () => {
  const response = await axios.get(`${urlServer}/api/edukasi?start=0&length=0`);
  statEdukasi.value = response.data.jumlah_data;
};

const fetchBerita = async () => {
  const response = await axios.get(`${urlServer}/api/berita?start=0&length=0`);
  statBerita.value = response.data.jumlah_data;
};

const fetchGambar = async () => {
  const response = await axios.get(`${urlServer}/api/gambar?start=0&length=0`);
  statGambar.value = response.data.jumlah_data;
};

const fetchBayi = async () => {
  const response = await axios.get(`${urlServer}/api/jumlah-bayi`);
  statBayi.value = response.data;
};

onMounted(() => {
  fetchBerita();
  fetchEdukasi();
  fetchGambar();
  fetchBayi();
});
</script>

<style>
@media screen and (min-width: 800px) {
  .humburger {
    display: none;
  }

  .hide-sm-and-down {
    display: none;
  }

  #logo-mobile {
    display: none;
  }

}

@media screen and (max-width: 800px) {
  #logo {
    display: none;
  }
}

#gambarPosyandu:hover {
  filter: brightness(0.7);
}
</style>

<template>
  <RouterView />
  <v-app style="position: fixed;">
    <v-app-bar style="background-color: rgba(255, 255, 255, 0.65);position: fixed;">
      <!-- Logo di sebelah pojok kiri -->
      <v-app-bar-nav-icon @click="toggleDrawer" class="hide-md-and-up humburger ml-5"></v-app-bar-nav-icon>

      <router-link id="logo" to="/" style="margin: 10px">
        <img class="d-flex text-primary ml-5" src="logo.svg">
      </router-link>

      <!-- Navigasi desktop -->
      <v-row class="hidden-sm-and-down" dense>
        <div v-for="(item, index) in desktopMenu" :key="index">
          <v-btn text @click="navigate(item.route)" style="flex-grow: 0px">
            {{ item.text }}
          </v-btn>
        </div>
      </v-row>

      <!-- Tombol login di pojok kanan -->
      <v-spacer></v-spacer>
      <UserProfile v-if="fotoProfile" class="hide-md-and-up mr-5" />
      <v-btn v-else text @click="navigate('/login')" class="hide-md-and-up mr-5">Login</v-btn>
    </v-app-bar>

    <!-- Drawer untuk tampilan mobile -->
    <v-navigation-drawer v-model="drawer" app class="hide-md-and-up"
      style="background-color: rgba(255, 255, 255, 0.65);position: fixed;">
      <v-list style="background-color: transparent;">
        <v-list-item>
          <router-link id="logo-mobile" to="/" style="margin: 10px;width: 100%;">
            <center>
              <img style="width: 100px;" src="logo.svg">
            </center>
          </router-link>
        </v-list-item>
        <v-list-item v-for="(item, index) in mobileMenu" :key="index" @click="navigate(item.route)" class="text-primary">
          <v-list-item-content>{{ item.text }}</v-list-item-content>
        </v-list-item>
      </v-list>
    </v-navigation-drawer>
  </v-app>

  <!-- Konten halaman -->
  <main>
    <img style="
        width: 100vw;
        height: 550px;
        object-fit: cover;
        position: relative;
        top: 0px;
        filter: brightness(0.8)" :src="langit" alt="" />
    <!-- Isi halaman utama Anda di sini -->
    <div style="position: absolute;top: 200px;width: 100vw;">
      <center>
        <h3 class="text-white text-no-wrap text-h5">SELAMAT DATANG DI</h3>
        <h1 class="text-white text-no-wrap text-h3">POSYANDU MELATI</h1>
      </center>
    </div>
  </main>

  <!-- CARD 3 -->
  <section class="container mt-5">
    <VRow>
      <VCol cols="11" md="9" lg="9" class="mx-auto">
        <!-- 👉 Profit -->
        <VCard>
          <VCardItem>
            <VRow class="text-center">
              <VCol cols="6" md="3" lg="3">
                <h1 class="text-primary">
                  <VIcon>bx-news</VIcon>
                </h1>
                <h2 class="mb-1 text-h5 text-no-wrap">
                  Berita Acara
                </h2>
                <h5 class="text-h5 text-no-wrap mb-3">
                  {{ statBerita }}
                </h5>
              </VCol>

              <!-- 👉 Sales -->
              <VCol cols="6" md="3" lg="3">
                <h1 class="text-primary">
                  <VIcon>bx-book</VIcon>
                </h1>
                <h2 class="mb-1 text-h5 text-no-wrap">
                  Edukasi
                </h2>
                <h5 class="text-h5 text-no-wrap mb-3">
                  {{ statEdukasi }}
                </h5>
              </VCol>
              <VCol cols="6" md="3" lg="3">
                <h1 class="text-primary">
                  <VIcon>bx-image</VIcon>
                </h1>
                <h2 class="mb-1 text-h5 text-no-wrap">
                  Galeri
                </h2>
                <h5 class="text-h5 text-no-wrap mb-3">
                  {{ statGambar }}
                </h5>
              </VCol>
              <VCol cols="6" md="3" lg="3">
                <h1 class="text-primary">
                  <VIcon>bx-face</VIcon>
                </h1>
                <h2 class="mb-1 text-h5 text-no-wrap">
                  Bayi Terdata
                </h2>
                <h5 class="text-h5 text-no-wrap mb-3">
                  {{ statBayi }}
                </h5>
              </VCol>
            </VRow>
          </VCardItem>
        </VCard>
        <Sambutan class="my-5" />
      </VCol>
    </VRow>
    <VCard class="mt-5">
      <VCardItem>
        <VRow>
          <VCol cols="11" md="9" lg="9" class="mx-auto py-5">
            <cardEdukasi />
            <cardBeritaAcara />
          </VCol>
        </VRow>
      </VCardItem>
    </VCard>
    <VRow>
      <VCol cols="11" md="9" lg="9" class="mx-auto">
        <cardGaleri />
      </VCol>
    </VRow>
  </section>
  <footerGuest />
</template>

<script>
export default {
  data() {
    return {
      drawer: false,
      desktopMenu: [
        { text: "Home", route: "/" },
        { text: "Edukasi", route: "/selengkapnya-card-edukasi" },
        { text: "Berita", route: "/selengkapnya-card-beritaacara" },
        { text: "Tentang", route: "/tentang-guest" },
      ],
      mobileMenu: [
        { text: "Home", route: "/" },
        { text: "Edukasi", route: "/selengkapnya-card-edukasi" },
        { text: "Berita", route: "/selengkapnya-card-beritaacara" },
        { text: "Tentang", route: "/" },
      ],
    };
  },
  methods: {
    toggleDrawer() {
      this.drawer = !this.drawer;
    },
    navigate(route) {
      this.$router.push(route);
      this.drawer = false; // Tutup drawer setelah mengklik menu pada tampilan mobile
    },
    closeDrawerOnResize() {
      // Fungsi ini akan menutup drawer saat lebar layar mencapai 800px
      if (window.innerWidth >= 800) {
        this.drawer = false;
      }
    },
  },
  mounted() {
    // Tambahkan listener saat komponen dimount
    window.addEventListener("resize", this.closeDrawerOnResize);
  },
  beforeUnmount() {
    // Hapus listener sebelum komponen diunmount
    window.removeEventListener("resize", this.closeDrawerOnResize);
  },
};
</script>

