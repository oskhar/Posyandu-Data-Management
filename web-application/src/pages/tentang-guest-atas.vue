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
                <v-card-text>
                  <v-container>
                    <v-row>
                      <!-- <VCard>
                        <v-col cols="12">
                          <VTextarea
                            label="Profil"
                            v-model="profil"
                            required
                          ></VTextarea>
                        </v-col>
                      </VCard> -->
                      <!-- <v-col cols="12">
                        <VTextarea
                          label="Visi"
                          v-model="visi"
                          required
                        ></VTextarea>
                      </v-col>
                      <v-col cols="12">
                        <VTextarea
                          label="Misi"
                          v-model="misi"
                          required
                        ></VTextarea>
                      </v-col> -->
                    </v-row>
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
    <!-- <VCol cols="12">
      <VCard class="text-center text-sm-start">
        <VRow no-gutters>
          <VCol cols="12">
            <VCardItem>
              <VCardTitle class="text-md-h5 text-primary"> VISI </VCardTitle>
            </VCardItem>

            <VCardText>
              <span>
                {{ visi }}
              </span>
              <br />
            </VCardText>
          </VCol>
        </VRow>
      </VCard>
    </VCol>
    <VCol cols="12">
      <VCard class="text-center text-sm-start">
        <VRow no-gutters>
          <VCol cols="12">
            <VCardItem>
              <VCardTitle class="text-md-h5 text-primary"> MISI </VCardTitle>
            </VCardItem>

            <VCardText>
              <span>
                {{ misi }}
              </span>
              <br />
            </VCardText>
          </VCol>
        </VRow>
      </VCard>
    </VCol> -->
  </VRow>
</template>
