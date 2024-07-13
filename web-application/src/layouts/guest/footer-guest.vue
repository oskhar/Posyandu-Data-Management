<script setup>
import { FOOTER_MENU_ITEMS } from "@/constants";
import { RouterLink } from "vue-router";

const currentYear = new Date().getFullYear()
</script>

<template>
  <VFooter class="bg-white px-0 py-0 pt-10  d-flex flex-column">
    <VRow class="w-100">
      <VCol cols="12" md="9" class="px-5 mx-auto">
        <VRow class="d-flex justify-space-between">
          <VCol cols="12" md="6">
            <VRow>
              <VCol cols="3">
                <img src="/logo.svg" class="w-100" />
              </VCol>
            </VRow>

            <VRow>
              <VCol v-for="menu in FOOTER_MENU_ITEMS" :key="menu.title" class="text-start" cols="12" sm="6" md="4"
                lg="3">
                <h3 class="mb-2 text-primary text-h6 font-weight-bold">{{ menu.title }}</h3>

                <ul class="footer-menu">
                  <li v-for="item in menu.items" :key="item.text" class="footer-menu-item text-subtitle-1">
                    <RouterLink :to="item.route" class="text-secondary">
                      {{ item.text }}
                    </RouterLink>
                  </li>
                </ul>
              </VCol>
            </VRow>
          </VCol>

          <VCol cols="12" md="6" class="d-flex flex-column">
            <h3 class="text-h6 font-weight-bold text-primary">
              <VIcon>bx-pin</VIcon>
              Lokasi Kami
            </h3>
            <p class="mt-2">
              Jl. Mutiara Pluit No.40, RT.002/RW.009, Periuk, Tangerang City, Banten
              15131
            </p>

            <iframe
              src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d247.92158966534308!2d106.59650325935067!3d-6.164836192435555!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69ff12e11dcac5%3A0x63c17ba223d307d6!2sLapangan%20Hengki!5e0!3m2!1sen!2sid!4v1720891923520!5m2!1sen!2sid"
              class="w-100 rounded elevation-10 border flex-1-1" style="min-height: 300px;" allowfullscreen=""
              loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
          </VCol>
        </VRow>
      </VCol>
    </VRow>

    <VRow class="bg-primary mt-12 w-100 py-2">
      <VCol cols="12" md="9" class="px-5 mx-auto">
        <p class="text-center my-0">
          &copy; {{ currentYear }} SiDilan | Sistem Informasi Posyandu Melati RW.9
        </p>
      </VCol>
    </VRow>
  </VFooter>
</template>

<style scoped lang="scss">
.footer-menu {
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
  width: max-content;
}

.footer-menu-item {
  list-style: none;

  &:hover {
    text-decoration: underline;
  }
}
</style>