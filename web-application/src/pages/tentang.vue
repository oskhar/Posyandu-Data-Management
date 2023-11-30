<script>
// 👉 Images
import posyandu from "@images/pages/3.png";
import langit from "@images/pages/2.png";
export default {
  data: () => ({
    dialog: false,
    posyandu: posyandu,
    langit: langit,
    profil: "Lorem ipsum dolor ",
    visi: "labore fugit assumenda ",
    misi: "corrupti veritatis quidem nostru",
  }),
  methods: {
    save() {
      this.profil = profil;
      this.visi = visi;
      this.misi = misi;
    },
  },
};
</script>

<template>
  <VRow>
    <div class="d-flex w-100 align-content-center">
      <VRow class="mx-1">
        <VCol cols="12">
          <v-row justify="center">
            <v-dialog v-model="dialog" persistent width="1024">
              <template v-slot:activator="{ props }">
                <div style="width: 100%" class="py-5 px-3">
                  <h1 class="text-primary float-left">POSYANDU MELATI</h1>
                  <v-btn color="primary" class="float-right" v-bind="props">
                    Edit
                  </v-btn>
                </div>
              </template>
              <v-card>
                <v-card-title>
                  <span class="text-h5">User Profile</span>
                </v-card-title>
                <v-card-text>
                  <v-container>
                    <v-row>
                      <v-col cols="12">
                        <VTextarea
                          label="Profil"
                          v-model="profil"
                          required
                        ></VTextarea>
                      </v-col>
                      <v-col cols="12">
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
                      </v-col>
                    </v-row>
                  </v-container>
                  <small>*indicates required field</small>
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
    <VCol cols="12">
      <img
        style="width: 100%; height: 500px; object-fit: cover"
        :src="langit"
        alt=""
      />
    </VCol>
    <VCol md="3" sm="12">
      <img
        style="width: 100%; height: 250px; object-fit: cover"
        :src="posyandu"
        alt=""
      />
    </VCol>
    <VCol md="9" sm="12">
      <VCard class="text-center text-sm-start">
        <VRow no-gutters>
          <VCol cols="12">
            <VCardItem>
              <VCardTitle class="text-md-h5 text-primary">
                PROFIL POSYANDU
              </VCardTitle>
            </VCardItem>

            <VCardText>
              <span>
                {{ profil }}
                <br />
                <br />
                Semoga dapat memudahkan masyarakat
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
              <VCardTitle class="text-md-h5 text-primary"> VISI </VCardTitle>
            </VCardItem>

            <VCardText>
              <span>
                {{ visi }}
                <br />
                <br />
                Semoga dapat memudahkan masyarakat
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
                <br />
                <br />
                Semoga dapat memudahkan masyarakat
              </span>
              <br />
            </VCardText>
          </VCol>
        </VRow>
      </VCard>
    </VCol>
  </VRow>
</template>
