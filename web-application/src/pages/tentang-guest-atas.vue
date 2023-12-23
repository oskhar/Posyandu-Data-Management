<template>
  <VRow>
    <VCol md="8" cols="12">
      <VCardItem>
        <VCardTitle class="text-md-h5 text-primary">
          Sambutan Ketua Posyandu
        </VCardTitle>
      </VCardItem>

      <VCardText style="white-space: pre-line;">
        {{ posyandu.penyampaian_ketua }}
      </VCardText>
    </VCol>
    <VCol cols="12" md="4" sm="12">
      <VCard class="pt-5">
        <VCardItem>
          <img style="width: 250px; height: 250px; object-fit: cover; border-radius: 4px;" class="mx-auto d-block"
            :src="imagePath + posyandu.foto_profile_ketua" alt="" />
          <div class="text-center mt-3">
            <h2 style="line-height: 0.8rem;">{{ posyandu.nama_lengkap_ketua }}</h2>
            <p>{{ posyandu.jabatan_ketua }}</p>
          </div>
        </VCardItem>
      </VCard>
    </VCol>
  </VRow>
</template>

<script>
import axios from 'axios';
import config from '@/@core/config.vue';

export default {
  data() {
    return {
      imagePath: config.imagePath,
      posyandu: {},
    }
  },
  methods: {
    async fetchData() {

      const responsePosyandu = await axios.get(`${config.urlServer}/api/posyandu`);
      this.posyandu = responsePosyandu.data;

    },
  },
  mounted() {
    this.fetchData();
  }
}
</script>