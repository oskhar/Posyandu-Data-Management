<template>
  <v-row justify="center">
    <v-dialog v-model="dialog" persistent width="1024">
      <template v-slot:activator="{ props }">
        <VRow class="mt-3">
          <VCol>
            <VBtn> Lihat </VBtn>
            <v-btn color="primary" class="mx-3" v-bind="props"> Edit </v-btn>
            <VBtn color="error" class="float-right"> Hapus </VBtn>
          </VCol>
        </VRow>
      </template>
      <v-card>
        <v-card-title>
          <span class="text-h5">Edit</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-row>
              <!-- <v-col cols="12" sm="6" md="4">
                <v-text-field label="Legal first name*" required></v-text-field>
              </v-col>
              <v-col cols="12" sm="6" md="4">
                <v-text-field
                  label="Legal middle name"
                  hint="example of helper text only on focus"
                ></v-text-field>
              </v-col>
              <v-col cols="12" sm="6" md="4">
                <v-text-field
                  label="Legal last name*"
                  hint="example of persistent helper text"
                  persistent-hint
                  required
                ></v-text-field>
              </v-col> -->
              <v-col cols="12">
                <v-text-field label="Judul" required></v-text-field>
              </v-col>
              <v-col cols="12">
                <v-text-field label="Tanggal" required></v-text-field>
              </v-col>
              <v-col cols="12">
                <v-text-field label="Materi" required></v-text-field>
              </v-col>
              <VCol cols="12" md="9">
                <div class="d-flex flex-column justify-center gap-5">
                  <div class="d-flex flex-wrap gap-2">
                    <VBtn color="primary" @click="refInputEl?.click()">
                      <VIcon icon="bx-cloud-upload" class="d-sm-none" />
                      <span class="d-none d-sm-block">Upload new photo</span>
                    </VBtn>

                    <input
                      ref="refInputEl"
                      type="file"
                      name="file"
                      accept=".jpeg,.png,.jpg"
                      hidden
                      @change="changeAvatar"
                    />

                    <VBtn
                      type="reset"
                      color="error"
                      variant="tonal"
                      @click="resetAvatar"
                    >
                      <span class="d-none d-sm-block">Reset</span>
                      <VIcon icon="bx-refresh" class="d-sm-none" />
                    </VBtn>
                  </div>
                </div>
                <VAvatar
                  rounded="lg"
                  size="200"
                  class="me-1 mt-3"
                  :image="projectImageLocal.imageValue"
                  v-show="projectImageLocal.imageValue !== ''"
                />
              </VCol>
              <!-- <v-col cols="12" sm="6">
                <v-select
                  :items="['0-17', '18-29', '30-54', '54+']"
                  label="Age*"
                  required
                ></v-select>
              </v-col>
              <v-col cols="12" sm="6">
                <v-autocomplete
                  :items="['Skiing', 'Ice hockey', 'Soccer', 'Basketball', 'Hockey', 'Reading', 'Writing', 'Coding', 'Basejump']"
                  label="Interests"
                  multiple
                ></v-autocomplete>
              </v-col> -->
            </v-row>
          </v-container>
          <!-- <small>*indicates required field</small> -->
        </v-card-text>
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
</template>

<script>
export default {
  setup() {
    const dialog = ref(false);
    const refInputEl = ref();
    const projectImage = {
      imageValue: "",
    };

    const projectImageLocal = ref({ ...projectImage });

    const resetAvatar = () => {
      projectImageLocal.value.imageValue = projectImage.imageValue;
    };

    const changeAvatar = (file) => {
      const fileReader = new FileReader();
      const { files } = file.target;
      if (files && files.length) {
        // Validasi tipe file sebelum menampilkan gambarnya
        if (
          files[0].type === "image/jpeg" ||
          files[0].type === "image/png" ||
          files[0].type === "image/jpg"
        ) {
          fileReader.readAsDataURL(files[0]);
          fileReader.onload = () => {
            if (typeof fileReader.result === "string") {
              projectImageLocal.value.imageValue = fileReader.result;
            }
          };
        } else {
          // Tindakan jika tipe file tidak valid
          alert("File harus berupa gambar dengan tipe jpeg, png, atau jpg.");
          resetAvatar();
        }
      }
    };
    return {
      refInputEl,
      projectImage,
      projectImageLocal,
      resetAvatar,
      changeAvatar,
      dialog,
    };
  },
};
</script>
