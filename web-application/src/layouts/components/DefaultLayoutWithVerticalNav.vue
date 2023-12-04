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
        <!-- 👉 Vertical nav toggle in overlay mode -->

        <!-- 👉 Search -->
        <!-- <div
          class="d-flex align-center cursor-pointer"
          style="user-select: none;"
        > -->
        <!-- 👉 Search Trigger button -->
        <!-- <IconBtn>
            <VIcon icon="bx-search" />
          </IconBtn> -->

        <!-- <span class="d-none d-md-flex align-center text-disabled">
            <span class="me-3">Search</span>
            <span class="meta-key">&#8984;K</span>
          </span>
        </div> -->

        <!-- <VSpacer /> -->

        <!-- <IconBtn
          class="me-2"
          href="https://github.com/themeselection/sneat-vuetify-vuejs-admin-template-free"
          target="_blank"
          rel="noopener noreferrer"
        >
          <VIcon icon="bxl-github" />
        </IconBtn> -->

        <!-- <IconBtn class="me-2">
          <VIcon icon="bx-bell" />
        </IconBtn> -->
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
            <NavbarThemeSwitcher class="mr-3 float-right" />
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
              title: 'Format 1',
              to: '/data/format-1',
            },
            {
              title: 'Format 2',
              to: '/data/format-2',
            },
            {
              title: 'Format 3',
              to: '/data/format-3',
            },
            {
              title: 'Format 4',
              to: '/data/format-4',
            },
            {
              title: 'Format 5',
              to: '/data/format-5',
            },
            {
              title: 'Format 6',
              to: '/data/format-6',
            },
            {
              title: 'Format 7',
              to: '/data/format-7',
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
          title: 'Pengaturan Akun',
          icon: 'mdi-account-cog-outline',
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
