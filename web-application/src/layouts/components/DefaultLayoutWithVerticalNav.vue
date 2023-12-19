<script setup>
import { useTheme } from "vuetify";
import VerticalNavSectionTitle from "@/@layouts/components/VerticalNavSectionTitle.vue";
import upgradeBannerDark from "@images/pro/upgrade-banner-dark.png";
import upgradeBannerLight from "@images/pro/upgrade-banner-light.png";
import VerticalNavLayout from "@layouts/components/VerticalNavLayout.vue";
import VerticalNavLink from "@layouts/components/VerticalNavLink.vue";
import VerticalNavLinkTree from "@layouts/components/VerticalNavLinkTree.vue";

// Components
import Footer from "@/layouts/components/Footer.vue";
import NavbarThemeSwitcher from "@/layouts/components/NavbarThemeSwitcher.vue";
import UserProfile from "@/layouts/components/UserProfile.vue";

const vuetifyTheme = useTheme();

const upgradeBanner = computed(() => {
  return vuetifyTheme.global.name.value === "light"
    ? upgradeBannerLight
    : upgradeBannerDark;
});
</script>

<template>
  <VerticalNavLayout>
    <!-- 👉 navbar -->
    <template #navbar="{ toggleVerticalOverlayNavActive }">
      <div class="d-flex h-100 align-center">
        <VRow>
          <VCol>
            <IconBtn
              class="ms-n3 d-lg-none"
              @click="toggleVerticalOverlayNavActive(true)"
            >
              <VIcon icon="bx-menu" />
            </IconBtn>
          </VCol>
          <VCol>
            <UserProfile class="float-right" />
            <!-- <NavbarThemeSwitcher class="mr-3 float-right" /> -->
          </VCol>
        </VRow>
      </div>
    </template>

    <template #vertical-nav-content>
      <VerticalNavLink
        :item="{
          title: 'Dashboard',
          icon: 'bx-home',
          to: '/dashboard',
        }"
      />
      <VerticalNavLink
        :item="{
          title: 'Berita Acara',
          icon: 'bx-news',
          to: '/berita-acara',
        }"
      />
      <VerticalNavLink
        :item="{
          title: 'Edukasi',
          icon: 'bx-book',
          to: '/edukasi',
        }"
      />
      <VerticalNavLink
        :item="{
          title: 'Gambar',
          icon: 'bx-image',
          to: '/galeri',
        }"
      />
      <VerticalNavLinkTree
        :item="{
          title: 'Data',
          children: [
            {
              title: 'Data Admin',
              to: '/data/admin',
            },
            {
              title: 'Data Bayi',
              to: '/data/format-1',
            },
            {
              title: 'Registrasi Bayi',
              to: '/data/format-2',
            },
          ],
        }"
      />
      <VerticalNavLink
        :item="{
          title: 'Tentang',
          icon: 'bx-info-circle',
          to: '/tentang',
        }"
      />
      <VerticalNavLink
        :item="{
          title: 'Profil',
          icon: 'bx-user',
          to: '/account-settings',
        }"
      />
    </template>

    <!-- 👉 Pages -->
    <slot />

    <!-- 👉 Footer -->
    <!-- <template #footer>
      <Footer />
    </template> -->
  </VerticalNavLayout>
</template>

<style lang="scss" scoped>
.meta-key {
  border: thin solid rgba(var(--v-border-color), var(--v-border-opacity));
  border-radius: 6px;
  block-size: 1.5625rem;
  line-height: 1.3125rem;
  padding-block: 0.125rem;
  padding-inline: 0.25rem;
}
</style>
