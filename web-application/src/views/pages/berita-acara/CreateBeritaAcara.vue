<template>
  <VRow>
    <VCol cols="12" md="12">
      <!-- 👉 Horizontal Form -->
      <VCard title="Buat Berita Acara">
        <VCardText>
          <FormEdukasi />
        </VCardText>
      </VCard>
    </VCol>
  </VRow>
</template>

<script>
import FormEdukasi from "@/views/pages/form-layouts/FormBeritaAcara.vue";
export default {
  components: {
    FormEdukasi,
  },
  setup() {
    return {};
  },
};
</script>
