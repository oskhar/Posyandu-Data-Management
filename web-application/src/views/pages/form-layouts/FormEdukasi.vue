<template>
  <VForm @submit="submitData">
    <VRow>
      <VCol cols="12">
        <VRow no-gutters>
          <!-- 👉 First Name -->
          <VCol cols="12" md="3">
            <label for="judul">Judul</label>
          </VCol>

          <VCol cols="12" md="9">
            <VTextField
              id="judul"
              v-model="judul"
              placeholder="Masukkan Judul"
              persistent-placeholder
            />
          </VCol>
        </VRow>
      </VCol>

      <VCol cols="12">
        <VRow no-gutters>
          <!-- 👉 Email -->
          <VCol cols="12" md="3">
            <label for="materi">Materi</label>
          </VCol>

          <VCol cols="12" md="9">
            <VTextarea
              id="materi"
              v-model="materi"
              placeholder="Masukkan Isi Materi"
              persistent-placeholder
            />
          </VCol>
        </VRow>
      </VCol>

      <VCol cols="12">
        <VRow no-gutters>
          <VCol cols="12" md="3">
            <label for="gambar">Gambar</label>
          </VCol>
          <VCol cols="12" md="9">
            <div class="d-flex flex-column justify-center gap-5">
              <div class="d-flex flex-wrap gap-2">
                <VBtn id="gambar" color="primary" @click="refInputEl?.click()">
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
        </VRow>
        <!-- 👉 Upload Photo -->
      </VCol>

      <!-- 👉 submit and reset button -->
      <VCol offset-md="3" cols="12" md="9" class="d-flex gap-4">
        <VBtn type="submit"> Submit </VBtn>
        <VBtn color="secondary" variant="tonal" type="reset"> Reset </VBtn>
      </VCol>
    </VRow>
  </VForm>
</template>

<script>
import axios from "axios";
import config from "@/@core/config.vue";
export default {
  setup() {
    const judul = ref("");
    const materi = ref("");
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

    const submitData = async (formData) => {
      try {
        formData.preventDefault();

        const data = new FormData();
        data.append("id_admin", 1);
        data.append("judul", judul.value);
        data.append("materi", materi.value);
        data.append("gambar", projectImageLocal.value.imageValue);
        const response = await axios.post(
          `${config.urlServer}/api/edukasi`,
          data
        );
        if (response.data.success) {
          alert(response.data.success.message);
        }
      } catch (error) {
        console.log(error);
      }
    };
    return {
      refInputEl,
      judul,
      materi,
      projectImage,
      projectImageLocal,
      resetAvatar,
      changeAvatar,
      submitData,
    };
  },
};
</script>
