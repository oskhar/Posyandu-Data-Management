<script setup>
import { useTheme } from "vuetify";
import illustrationJohnDark from "@images/cards/illustration-john-dark.png";
import illustrationJohnLight from "@images/cards/illustration-john-light.png";

const { global } = useTheme();
const illustrationJohn = computed(() =>
  global.name.value === "dark" ? illustrationJohnDark : illustrationJohnLight
);
</script>

<template>
  <VCard class="text-center text-sm-start">
    <VRow no-gutters>
      <VCol cols="12" sm="8" order="2" order-sm="1">
        <VCardItem>
          <VCardTitle class="text-md-h5 text-primary">
            Selamat Datang Di Posyandu
          </VCardTitle>
        </VCardItem>

        <VCardText>
          <span>
            Posyandu merupakan pusat pelayanan kesehatan masyarakat yang memiliki peran krusial dalam pemantauan dan
            perawatan kesehatan ibu dan anak. Dengan platform ini, Anda memiliki akses ke berbagai fitur untuk membantu
            Anda dalam mengelola kegiatan Posyandu dengan lebih efisien.
          </span>
          <br />
          <VBtn variant="tonal" class="mt-4" size="small" to="/tentang">
            Selengkapnya
          </VBtn>
        </VCardText>
      </VCol>

      <VCol cols="12" sm="4" order="1" order-sm="2" class="text-center">
        <img :src="illustrationJohn" :height="$vuetify.display.xs ? '150' : '175'"
          :class="$vuetify.display.xs ? 'mt-6 mb-n2' : 'position-absolute'" class="john-illustration flip-in-rtl" />
      </VCol>
    </VRow>
  </VCard>
</template>

<style lang="scss" scoped>
.john-illustration {
  inset-block-end: -0.0625rem;
  inset-inline-end: 3rem;
}
</style>
