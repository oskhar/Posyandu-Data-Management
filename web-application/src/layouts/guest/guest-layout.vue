<script>
import UserProfile from "@/components/UserProfile.vue";
import { MENU_ITEMS } from "@/constants";
import FooterGuest from "@/layouts/guest/footer-guest.vue";

export default {
  components: {
    UserProfile,
    FooterGuest,
  },
  data() {
    return {
      fotoProfile: localStorage.getItem("foto_profile") && localStorage.getItem("tokenAuth") ? localStorage.getItem("foto_profile") : false,
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
  <VAppBar :elevation="2">
    <VRow>
      <VCol cols="12" md="9" class="d-flex justify-space-between align-center px-5 mx-auto">
        <!-- Logo di sebelah pojok kiri -->
        <VAppBarNavIcon class="hide-md-and-up hamburger ma-0" @click="toggleDrawer"></VAppBarNavIcon>

        <RouterLink to="/" class="mr-4">
          <img class="hidden-sm-and-down" src="/logo.svg" />
        </RouterLink>

        <!-- Navigasi desktop -->
        <VRow class="hidden-sm-and-down justify-center gap-1">
          <template v-for="(item, index) in menu" :key="index">
            <VBtn v-if="item.childrens">
              {{ item.text }}

              <VMenu open-on-hover open-on-focus location="bottom center" origin="auto" activator="parent">
                <VList class="text-primary">
                  <VListItem v-for="(child, childIndex) in item.childrens" :key="childIndex" :to="child.route" exact>
                    <VListItemContent>{{ child.text }}</VListItemContent>
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
          <UserProfile v-if="fotoProfile" class="hide-md-and-up" />
          <VBtn v-else class="hide-md-and-up" to="/login" exact>Login</VBtn>
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

      <template v-for="(item, index) in menu" :key="index">
        <VListItem v-if="item.childrens">
          <VExpansionPanels>
            <VExpansionPanel class="text-primary">
              <VExpansionPanelTitle class="pa-0">{{ item.text }}</VExpansionPanelTitle>

              <VExpansionPanelText class="list-item-accordion">
                <VList class="text-primary">
                  <VListItem v-for="(child) in item.childrens" :key="child.text" :to="child.route" exact>
                    {{ child.text }}
                  </VListItem>
                </VList>
              </VExpansionPanelText>

            </VExpansionPanel>
          </VExpansionPanels>
        </VListItem>
        <VListItem v-else class="text-primary" :to="item.route" exact>
          <VListItemContent>{{ item.text }}</VListItemContent>
        </VListItem>
      </template>
    </VList>
  </VNavigationDrawer>

  <RouterView />

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

.list-item-accordion>.v-expansion-panel-text__wrapper {
  padding: 0;
}
</style>
