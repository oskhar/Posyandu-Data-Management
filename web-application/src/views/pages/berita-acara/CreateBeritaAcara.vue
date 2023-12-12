<template>
  <VRow>
    <VCol cols="12" md="12">
      <!-- 👉 Horizontal Form -->
      <VCard title="Buat Berita Acara">
        <VCardText>
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
                    <sup class="text-error">*wajib diisi</sup>
                    <br />
                    <sup class="text-error">*harus unik</sup>
                  </VCol>
                </VRow>
              </VCol>

              <VCol cols="12">
                <VRow no-gutters>
                  <!-- 👉 Email -->
                  <VCol cols="12" md="3">
                    <label for="deskripsi">Materi</label>
                  </VCol>

                  <VCol cols="12" md="9">
                    <VTextarea
                      id="deskripsi"
                      v-model="deskripsi"
                      placeholder="Masukkan Isi Materi"
                      persistent-placeholder
                    />
                  </VCol>
                </VRow>
              </VCol>

              <VCol cols="12">
                <VRow no-gutters>
                  <!-- 👉 First Name -->
                  <VCol cols="12" md="3">
                    <label for="tanggalPelaksanaan">Tanggal Pelaksanaan</label>
                  </VCol>

                  <VCol cols="12" md="9">
                    <VTextField
                      type="date"
                      id="tanggalPelaksanaan"
                      v-model="tanggal_pelaksanaan"
                      placeholder="Masukkan tanggal"
                      persistent-placeholder
                    />
                    <sup class="text-error">*wajib diisi</sup>
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
                        <VBtn
                          id="gambar"
                          color="primary"
                          @click="refInputEl?.click()"
                        >
                          <VIcon icon="bx-cloud-upload" class="d-sm-none" />
                          <span class="d-none d-sm-block"
                            >Upload new photo</span
                          >
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
                <VBtn type="submit">
                  <VProgressCircular
                    v-if="isLoading"
                    indeterminate
                    color="white"
                  >
                  </VProgressCircular>

                  <font v-else>Submit</font>
                </VBtn>
              </VCol>
            </VRow>
          </VForm>
        </VCardText>
      </VCard>
    </VCol>
  </VRow>
</template>

<script>
import axios from "axios";
import config from "@/@core/config.vue";
import Swal from "sweetalert2";

export default {
  setup() {
    let isLoading = ref(false);
    const judul = ref("");
    const deskripsi = ref("");
    const tanggal_pelaksanaan = ref("");
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
        isLoading.value = true;

        const data = new FormData();
        data.append("id_admin", localStorage.getItem("id_admin"));
        data.append("judul", judul.value);
        data.append("deskripsi", deskripsi.value);
        data.append("tanggal_pelaksanaan", tanggal_pelaksanaan.value);
        data.append("gambar", projectImageLocal.value.imageValue);
        const response = await axios.post(
          `${config.urlServer}/api/berita`,
          data,
          {
            headers: {
              Authorization: localStorage.getItem("tokenAuth"),
            },
          }
        );
        if (response.data.success) {
          await Swal.fire({
            toast: true,
            position: "top",
            iconColor: "white",
            color: "white",
            background: "rgb(var(--v-theme-success))",
            showConfirmButton: false,
            timerProgressBar: true,
            timer: 1000,
            icon: "success",
            title: response.data.success.message,
          });
        }

        window.location.href = "/berita-acara";
      } catch (error) {
        console.log(error);
      }
      isLoading.value = false;
    };
    return {
      refInputEl,
      judul,
      deskripsi,
      tanggal_pelaksanaan,
      projectImage,
      projectImageLocal,
      resetAvatar,
      changeAvatar,
      submitData,
      isLoading,
    };
  },
};
</script>
