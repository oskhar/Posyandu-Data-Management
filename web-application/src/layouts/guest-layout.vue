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
  <v-app style="position: fixed;">
    <v-app-bar style="background-color: rgba(255, 255, 255, 0.75);position: fixed;">
      <!-- Logo di sebelah pojok kiri -->
      <v-app-bar-nav-icon @click="toggleDrawer" class="hide-md-and-up humburger ml-5"></v-app-bar-nav-icon>

      <router-link id="logo" to="/" style="margin: 10px">
        <img class="d-flex text-primary ml-5" src="/logo.svg">
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
              <img style="width: 100px;" src="/logo.svg">
            </center>
          </router-link>
        </v-list-item>
        <v-list-item v-for="(item, index) in mobileMenu" :key="index" @click="navigate(item.route)" class="text-primary">
          <v-list-item-content>{{ item.text }}</v-list-item-content>
        </v-list-item>
      </v-list>
    </v-navigation-drawer>
  </v-app>

  <RouterView />

  <footerGuest />
</template>

<script>
import UserProfile from "@/layouts/components/UserProfile.vue";
import footerGuest from "@/pages/footer-guest.vue";

export default {
  components: {
    UserProfile,
    footerGuest,
  },
  data() {
    return {
      fotoProfile: localStorage.getItem("foto_profile") ? localStorage.getItem("foto_profile") : false,
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
        { text: "Tentang", route: "/tentang-guest" },
      ],
    }
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
    window.addEventListener("resize", this.closeDrawerOnResize);
  },
  beforeUnmount() {
    // Hapus listener sebelum komponen diunmount
    window.removeEventListener("resize", this.closeDrawerOnResize);
  },
}
</script>