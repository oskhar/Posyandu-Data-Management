<script>
import GuestUserProfile from "@/layouts/guest/guest-user-profile.vue";
import AdminUserProfile from "@/layouts/admin/admin-user-profile.vue";
import { MENU_ITEMS, WA_POSYANDU } from "@/constants";
import FooterGuest from "@/layouts/guest/footer-guest.vue";
import { getWhatsappLink } from "@/utils/send-whatsapp";
import { isUserLoggedIn, isAdminLoggedIn } from "@/utils/auth-token"
import VerticalNavItems from "@/components/vertical-nav-items.vue";

export default {
  components: {
    VerticalNavItems,
    GuestUserProfile,
    AdminUserProfile,
    FooterGuest,
  },
  data() {
    return {
      WA_POSYANDU,
      drawer: false,
      menu: MENU_ITEMS,
    };
  },
  mounted() {
    window.addEventListener("resize", this.closeDrawerOnResize);
  },
  beforeUnmount() {
    window.removeEventListener("resize", this.closeDrawerOnResize);
  },
  methods: {
    isAdminLoggedIn,
    isUserLoggedIn,
    getWhatsappLink,
    toggleDrawer() {
      this.drawer = !this.drawer;
    },
    closeDrawerOnResize() {
      if (window.innerWidth >= 800) {
        this.drawer = false;
      }
    },
  },
};
</script>

<template>
  <VAppBar :elevation="2" height="90">
    <VRow>
      <VCol cols="12" md="9" class="d-flex justify-space-between align-center px-5 mx-auto">
        <!-- Logo di sebelah pojok kiri -->
        <VAppBarNavIcon class="hide-md-and-up hamburger ma-0" @click="toggleDrawer"></VAppBarNavIcon>

        <RouterLink to="/">
          <img class="hidden-sm-and-down" style="width: 80px;" src="/logo.svg" />
        </RouterLink>

        <!-- Navigasi desktop -->
        <VRow class="hidden-sm-and-down justify-center gap-1">
          <template v-for="(item, index) in menu" :key="index">
            <VBtn v-if="item.childrens">
              {{ item.text }}

              <VMenu open-on-hover open-on-focus location="bottom center" origin="auto" activator="parent">
                <VList class="text-primary">
                  <VListItem v-for="(child, childIndex) in item.childrens" :key="childIndex" :to="child.route" exact>
                    <VListItemContent style="text-transform: uppercase !important; font-size: 14px;">{{ child.text }}
                    </VListItemContent>
                  </VListItem>
                </VList>
              </VMenu>
            </VBtn>
            <VBtn v-else text :to="item.route" exact>
              {{ item.text }}
            </VBtn>
          </template>
        </VRow>

        <!-- Tombol login di pojok kanan -->
        <div class="ml-auto">
          <AdminUserProfile v-if="isAdminLoggedIn()" class="hide-md-and-up" />
          <GuestUserProfile v-else-if="isUserLoggedIn()" class="hide-md-and-up" />
          <VBtn v-else class="hide-md-and-up" to="/login" variant="flat" prepend-icon="bx-log-in-circle" exact>Login
          </VBtn>
        </div>
      </VCol>
    </VRow>
  </VAppBar>

  <!-- Drawer untuk tampilan mobile -->
  <VNavigationDrawer v-model="drawer" app class="hide-md-and-up">
    <VList>
      <VListItem exact to="/" class="d-block w-100" :active="false">
        <img src=" /logo.svg" />
      </VListItem>

      <VerticalNavItems :menu-items="menu" />
    </VList>
  </VNavigationDrawer>

  <a :href="getWhatsappLink(WA_POSYANDU, 'Halo Posyandu Melati, Saya butuh bantuan pada website SiDilan.')"
    target="_blank" rel="noopener noreferrer" class="wa-help-button position-fixed"
    style="z-index: 10; right: 60px; bottom: 36px">
    <VFab icon="mdi-whatsapp" location="bottom end" size="52" fixed app color="#25D366" />
    <VTooltip class="text-subtitle-1" activator="parent" location="start">Butuh bantuan? Klik tombol
      ini!
    </VTooltip>
  </a>

  <div style="margin-top: 120px;">
    <RouterView />
  </div>

  <FooterGuest />
</template>

<style>
@media screen and (min-width: 960px) {
  .hamburger {
    display: none;
  }

  .hide-sm-and-down {
    display: none;
  }
}

.mobile-menu-logo>.v-list-item__overlay {
  background-color: transparent !important;
}


.wa-help-button .v-icon {
  color: white !important;
}
</style>
