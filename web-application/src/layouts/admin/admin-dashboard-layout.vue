<template>
  <VerticalNavLayout>
    <!-- 👉 navbar -->
    <template #navbar="{ toggleVerticalOverlayNavActive }">
      <div class="d-flex h-100 align-center">
        <VRow>
          <VCol>
            <IconBtn class="ms-n3 d-lg-none" @click="toggleVerticalOverlayNavActive(true)">
              <VIcon icon="bx-menu" />
            </IconBtn>
          </VCol>
          <VCol>
            <UserProfile class="float-right" />
          </VCol>
        </VRow>
      </div>
    </template>

    <template #vertical-nav-content>
      <VerticalNavLink :item="{
        title: 'Dashboard',
        icon: 'bx-home',
        to: '/admin/dashboard',
      }" />
      <VerticalNavLink :item="{
        title: 'Berita Acara',
        icon: 'bx-news',
        to: '/admin/berita-acara',
      }" />
      <VerticalNavLink :item="{
        title: 'Edukasi',
        icon: 'bx-book',
        to: '/admin/edukasi',
      }" />
      <VerticalNavLink :item="{
        title: 'Gambar',
        icon: 'bx-image',
        to: '/admin/galeri',
      }" />
      <VerticalNavLinkTree :item="{
        title: 'Master Data',
        children: [
          {
            title: 'Data Admin',
            to: '/admin/data/admin',
          },
          {
            title: 'Data Bayi',
            to: '/admin/data/format-1',
          },
          {
            title: 'WUS & PUS',
            to: '/admin/data/format-3',
          },
          {
            title: 'Ibu Hamil',
            to: '/admin/data/format-4',
          },
        ],
      }" />
      <VerticalNavLinkTree :item="{
        title: 'Layanan',
        children: [
          {
            title: 'Kader Gendong',
            to: '/admin/layanan/kader-gendong',
          },
          {
            title: 'Resleting',
            to: '/admin/layanan/remaja-peduli-stunting/tantangan',
          },
          {
            title: 'SiKambing',
            to: '/admin/layanan/si-kambing',
          },
          {
            title: 'Screening',
            to: '/admin/data/format-2',
          },
        ],
      }" />
      <VerticalNavLink :item="{
        title: 'Tentang',
        icon: 'bx-info-circle',
        to: '/admin/tentang',
      }" />
      <VerticalNavLink :item="{
        title: 'Profil',
        icon: 'bx-user',
        to: '/admin/account-settings',
      }" />
    </template>

    <!-- 👉 Pages -->
    <RouterView />
  </VerticalNavLayout>
</template>

<script>
import VerticalNavLayout from "@layouts/components/VerticalNavLayout.vue"
import VerticalNavLink from "@layouts/components/VerticalNavLink.vue"
import VerticalNavLinkTree from "@layouts/components/VerticalNavLinkTree.vue"
import UserProfile from "@/layouts/admin/admin-user-profile.vue"

export default {
  components: {
    VerticalNavLayout,
    VerticalNavLink,
    VerticalNavLinkTree,
    UserProfile,
  },
}
</script>

<style lang="scss">
// As we are using `layouts` plugin we need its styles to be imported
@use "@layouts/styles/default-layout";

.meta-key {
  border: thin solid rgba(var(--v-border-color), var(--v-border-opacity));
  border-radius: 6px;
  block-size: 1.5625rem;
  line-height: 1.3125rem;
  padding-block: 0.125rem;
  padding-inline: 0.25rem;
}
</style>
