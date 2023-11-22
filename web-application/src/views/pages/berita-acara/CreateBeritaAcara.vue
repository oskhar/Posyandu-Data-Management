<template>
  <VRow>
    <VCol cols="12" md="12">
      <!-- 👉 Horizontal Form -->
      <VCard title="Buat Edukasi">
        <VCardText>
          <FormEdukasi />
        </VCardText>
      </VCard>
    </VCol>
  </VRow>
</template>

<script>
import FormEdukasi from "@/views/pages/form-layouts/FormEdukasi.vue";
export default {
  components: {
    FormEdukasi,
  },
  setup() {
    return {};
  },
};
</script>
