<script>
import UserProfile from "@/components/UserProfile.vue";
import footerGuest from "@/layouts/guest/footer-guest.vue";

export default {
  components: {
    UserProfile,
    footerGuest,
  },
  data() {
    return {
      fotoProfile: localStorage.getItem("foto_profile") && localStorage.getItem("tokenAuth") ? localStorage.getItem("foto_profile") : false,
      drawer: false,
      menu: [
        { text: "Home", route: "/" },
        { text: "Edukasi", route: "/selengkapnya-card-edukasi" },
        { text: "Berita", route: "/selengkapnya-card-beritaacara" },
        { text: "Tentang", route: "/tentang-guest" },
      ],
    }
  },
  mounted() {
    window.addEventListener("resize", this.closeDrawerOnResize);
  },
  beforeUnmount() {
    // Hapus listener sebelum komponen diunmount
    window.removeEventListener("resize", this.closeDrawerOnResize);
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
}
</script>

<template>
  <VAppBar :elevation="2" class="d-flex justify-space-between align-center px-5">
    <!-- Logo di sebelah pojok kiri -->
    <VAppBarNavIcon class="hide-md-and-up hamburger ma-0" @click="toggleDrawer"></VAppBarNavIcon>

    <RouterLink to="/" class="mr-4">
      <img class="hidden-sm-and-down" src="/logo.svg">
    </RouterLink>

    <!-- Navigasi desktop -->
    <VRow class="hidden-sm-and-down" dense>
      <div v-for="(item, index) in menu" :key="index">
        <VBtn text style="flex-grow: 0px" @click="navigate(item.route)">
          {{ item.text }}
        </VBtn>
      </div>
    </VRow>

    <!-- Tombol login di pojok kanan -->
    <div class="ml-auto">
      <UserProfile v-if="fotoProfile" class="hide-md-and-up" />
      <VBtn v-else class="hide-md-and-up" @click="navigate('/login')">Login</VBtn>
    </div>
  </VAppBar>

  <!-- Drawer untuk tampilan mobile -->
  <VNavigationDrawer v-model="drawer" app class="hide-md-and-up">
    <VList style="background-color: transparent;">
      <VListItem>
        <RouterLink to="/" class="d-block w-100">
          <img src="/logo.svg">
        </RouterLink>
      </VListItem>
      <VListItem v-for="(item, index) in menu" :key="index" class="text-primary" @click="navigate(item.route)">
        <VListItemContent>{{ item.text }}</VListItemContent>
      </VListItem>
    </VList>
  </VNavigationDrawer>

  <RouterView />

  <FooterGuest />
</template>

<style scoped>
@media screen and (min-width: 960px) {
  .hamburger {
    display: none;
  }

  .hide-sm-and-down {
    display: none;
  }
}
</style>