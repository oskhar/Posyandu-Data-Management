<script>
// 👉 Images
import posyandu from "@images/pages/3.png";
// import langit from "@images/pages/2.png";
export default {
  data: () => ({
    dialog: false,
    posyandu: posyandu,
    // langit: langit,
    profil: "Bapak / Ibu (Nama Lengkap)",
    // visi: "Belum ada ",
    // misi: "Belum ada",
  }),
  methods: {
    save() {
      this.profil = profil;
      //   this.visi = visi;
      //   this.misi = misi;
    },
  },
};
</script>

<template>
  <VRow>
    <div class="w-100 align-content-center" style="margin-top: 150px">
      <VRow class="mx-1 mt-5">
        <VCol cols="12">
          <v-row justify="center">
            <v-dialog v-model="dialog" persistent width="1024">
              <template v-slot:activator="{ props }"> </template>
              <v-card>
                <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn color="blue-darken-1" variant="text" @click="dialog = false">
                    Close
                  </v-btn>
                  <v-btn color="blue-darken-1" variant="text" @click="dialog = false">
                    Save
                  </v-btn>
                </v-card-actions>
              </v-card>
            </v-dialog>
          </v-row>
        </VCol>
      </VRow>
    </div>

    <VCol md="8" sm="12">
      <VCol cols="12">
        <VCardItem>
          <VCardTitle class="text-md-h5 text-primary">
            Sambutan Ketua Posyandu
          </VCardTitle>
        </VCardItem>

        <VCardText>
          <span>
            {{ profil }}
            <br />
            <br />

            Assalamu’alaikum Warahmatullahi Wabarakaatuh.
            <br />
            Salam sejahtera untuk kita semua. Selamat datang di website
            Posyandu Melati. Website ini dibangun sebagai sarana atau media
            informasi dan komunikasi masyarakat, karena sejalan dengan
            perkembangan teknologi industri 4.0 yang berguna untuk memudahkan
            mencari informasi tentang POSYANDU MELATI.
          </span>
          <br />
          <br />
          <VBtn color="primary" v-bind="props"> Selengkapnya </VBtn>
        </VCardText>
      </VCol>
    </VCol>
    <VCol md="4" sm="12">
      <VCard class="pt-5">
        <img style="width: 250px; height: 250px; object-fit: cover; border-radius: 4px;" class="mx-auto d-block"
          :src="posyandu" alt="" />
        <div class="text-center mt-3">
          <h2 style="line-height: 0.8rem;">Nama Ketua</h2>
          <p>Jabatan</p>
        </div>
      </VCard>
    </VCol>
  </VRow>
</template>
