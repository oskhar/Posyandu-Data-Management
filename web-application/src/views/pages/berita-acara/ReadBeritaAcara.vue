<template>
  <VRow>
    <!-- 👉 Popular Uses Of The Internet -->
    <VCol v-for="data in dataBeritaAcara" cols="12" md="4" sm="6">
      <VCard>
        <VImg :src="data.gambar" cover max-height="280" />

        <VCardItem>
          <VCardTitle>{{ data.judul }}</VCardTitle>
          <sup>{{ data.tanggal }}</sup>
        </VCardItem>

        <VCardText>
          <div class="mb-4">
            {{ data.materi }}
          </div>

          <EditBeritaAcara />
        </VCardText>
      </VCard>
    </VCol>
  </VRow>
</template>
<script>
import images from "@images/pages/5.jpg";
import EditBeritaAcara from "./EditBeritaAcara.vue";
export default {
  setup() {
    const dataBeritaAcara = [
      {
        id_edukasi: 0,
        email: "ha@gmail.com",
        nama_lengkap: "Nama penulis",
        judul: "Ini Judul",
        materi: "lorem ipsum",
        gambar: images,
        tanggal: "12/12/2023",
      },
      {
        id_edukasi: 0,
        email: "ha@gmail.com",
        nama_lengkap: "Nama penulis",
        judul: "Ini Judul",
        materi: "lorem ipsum",
        gambar: images,
        tanggal: "12/12/2023",
      },
      {
        id_edukasi: 0,
        email: "ha@gmail.com",
        nama_lengkap: "Nama penulis",
        judul: "Ini Judul",
        materi: "lorem ipsum",
        gambar: images,
        tanggal: "12/12/2023",
      },
      {
        id_edukasi: 0,
        email: "ha@gmail.com",
        nama_lengkap: "Nama penulis",
        judul: "Ini Judul",
        materi: "lorem ipsum",
        gambar: images,
        tanggal: "12/12/2023",
      },
    ];

    return {
      dataBeritaAcara,
    };
  },

  components: {
    EditBeritaAcara,
  },
};
</script>
