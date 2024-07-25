<script setup>
import { EMAIL_POSYANDU, FORMATTED_WA_POSYANDU, IG_POSYANDU, WA_POSYANDU } from "@/constants";
import { getWhatsappLink } from "@/utils/send-whatsapp";

const currentYear = new Date().getFullYear()
</script>

<template>
  <VFooter id="kontak" class="bg-white px-0 py-0 pt-10  d-flex flex-column">
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
              <VCol class="text-start" cols="12">
                <h3 class="text-h6 font-weight-bold text-primary d-flex align-center gap-2">
                  <VIcon>bx-phone</VIcon>
                  Kontak Kami
                </h3>
              </VCol>

              <VCol class="text-start d-flex flex-column gap-4 font-weight-medium" cols="12">
                <a target="_blank" rel="noopener noreferrer" class="d-flex align-center gap-4"
                  :href="getWhatsappLink(WA_POSYANDU, 'Halo Posyandu 9')">
                  <VIcon color="#25D366" size="32">mdi-whatsapp</VIcon>
                  <span class="text-subtitle-1 font-weight-bold text-grey-600">{{ FORMATTED_WA_POSYANDU }}</span>
                </a>
                <a target="_blank" rel="noopener noreferrer" :href="`https://www.instagram.com/${IG_POSYANDU}/`"
                  class="d-flex align-center gap-4">
                  <VIcon color="#E52765" size="32">mdi-instagram</VIcon>
                  <span class="text-subtitle-1 font-weight-bold text-grey-600">{{
                    IG_POSYANDU }}</span>
                </a>
                <a class="d-flex align-center gap-4" target="_blank" rel="noopener noreferrer"
                  :href="`https://www.facebook.com/${IG_POSYANDU}/`">
                  <VIcon color="#4267B2" size="32">mdi-facebook</VIcon>
                  <span class="text-subtitle-1 font-weight-bold text-grey-600">{{ IG_POSYANDU }}</span>
                </a>
                <a :href="`mailto:${EMAIL_POSYANDU}`" class="d-flex align-center gap-4">
                  <VIcon color="#008cb5" size="32">mdi-email-outline</VIcon>
                  <span class="text-subtitle-1 font-weight-bold text-grey-600">{{ EMAIL_POSYANDU }}</span>
                </a>
              </VCol>
            </VRow>
          </VCol>

          <VCol cols="12" md="6" class="d-flex flex-column">
            <h3 class="text-h6 font-weight-bold text-primary">
              <VIcon size="small">bx-pin</VIcon>
              Lokasi Kami
            </h3>
            <p class="mt-2 text-subtitle-1">
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