<template>
  <VRow>
    <!-- 👉 Popular Uses Of The Internet -->
    <VCol v-for="data in dataEdukasi" cols="12" md="4" sm="6">
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

          <EditEdukasi />
        </VCardText>
      </VCard>
    </VCol>
  </VRow>
</template>
<script>
import images from "@images/pages/2.png";
import EditEdukasi from "./EditEdukasi.vue";
export default {
  setup() {
    const dataEdukasi = [
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
      dataEdukasi,
    };
  },

  components: {
    EditEdukasi,
  },
};
</script>
