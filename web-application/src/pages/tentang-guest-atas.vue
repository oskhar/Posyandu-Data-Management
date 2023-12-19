<script>
// 👉 Images
import posyandu from "@images/pages/3.png";
// import langit from "@images/pages/2.png";
export default {
  data: () => ({
    dialog: false,
    posyandu: posyandu,
    profil: "Bapak / Ibu (Nama Lengkap)",
  }),
  methods: {
    save() {
      this.profil = profil;
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
                <v-card-text>
                  <v-container>
                    <v-row> </v-row>
                  </v-container>
                </v-card-text>
                <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn
                    color="blue-darken-1"
                    variant="text"
                    @click="dialog = false"
                  >
                    Close
                  </v-btn>
                  <v-btn
                    color="blue-darken-1"
                    variant="text"
                    @click="dialog = false"
                  >
                    Save
                  </v-btn>
                </v-card-actions>
              </v-card>
            </v-dialog>
          </v-row>
        </VCol>
      </VRow>
    </div>

    <VCol md="9" sm="12">
      <VRow no-gutters>
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
      </VRow>
    </VCol>
    <VCol md="3" sm="12">
      <VCard>
        <img
          style="width: 100%; height: 250px; object-fit: cover"
          :src="posyandu"
          alt=""
        />
      </VCard>
    </VCol>
  </VRow>
</template>