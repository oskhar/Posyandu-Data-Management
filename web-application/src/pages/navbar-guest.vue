<template>
  <v-app>
    <v-app-bar class="navbarGuest">
      <!-- Logo di sebelah pojok kiri -->
      <v-app-bar-nav-icon
        @click="toggleDrawer"
        class="hide-md-and-up humburger"
      ></v-app-bar-nav-icon>
      <router-link to="/" style="margin: 10px">
        <div class="d-flex text-primary" v-html="logo"></div>
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
      <v-btn text @click="navigate('/login')" class="hide-md-and-up"
        >Login</v-btn
      >
    </v-app-bar>

    <!-- Drawer untuk tampilan mobile -->
    <v-navigation-drawer v-model="drawer" app class="hide-md-and-up">
      <v-list>
        <v-list-item
          v-for="(item, index) in mobileMenu"
          :key="index"
          @click="navigate(item.route)"
        >
          <v-list-item-content>{{ item.text }}</v-list-item-content>
        </v-list-item>
      </v-list>
    </v-navigation-drawer>

    <!-- Konten halaman -->
    <v-main>
      <!-- Isi halaman utama Anda di sini -->
      <router-view>
        <div style="z-index: 100; position: relative; margin-top: 100px">
          <center>
            <h4 style="color: white; font-size: 3vw">SELAMAT DATANG DI</h4>
            <strong style="color: white; font-size: 6vw"
              >POSYANDU MELATI</strong
            >
          </center>
        </div>
        <img
          style="
            width: 100%;
            height: 690px;
            object-fit: cover;
            position: absolute;
            margin: 0px auto;
            top: 0px;
          "
          :src="langit"
          alt=""
        />
      </router-view>
    </v-main>
  </v-app>
</template>

<script setup>
import langit from "@images/pages/2.png";
import logo from "@images/logo.svg?raw";
</script>

<script>
export default {
  data() {
    return {
      drawer: false,
      desktopMenu: [
        { text: "Home", route: "/" },
        { text: "Edukasi", route: "/selengkapnya-card-edukasi" },
        { text: "Berita", route: "/selengkapnya-card-beritaacara" },
        { text: "Tentang", route: "/" },
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

<style scoped>
.navbarGuest {
  background-color: rgba(0, 0, 0, 0.2);
  position: fixed;
}

@media screen and (min-width: 800px) {
  .humburger {
    display: none;
  }
  .hide-sm-and-down {
    display: none;
  }
}
</style>
