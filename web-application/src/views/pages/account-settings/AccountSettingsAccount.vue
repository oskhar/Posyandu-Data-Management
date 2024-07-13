<template>
  <VRow>
    <VCol cols="12">
      <VCard title="Account Details">
        <VCardText class="d-flex">
          <!-- 👉 Avatar -->
          <VAvatar rounded="lg" size="100" class="me-6" :image="dataAdmin.foto_profile" />

          <!-- 👉 Upload Photo -->
          <form class="d-flex flex-column justify-center gap-5">
            <div class="d-flex flex-wrap gap-2">
              <VBtn color="primary" @click="uploadGambar">
                <VIcon icon="bx-cloud-upload" class="d-sm-none" />
                <span class="d-none d-sm-block">Unggah foto baru</span>
              </VBtn>

              <input id="gambar" ref="refInputEl" type="file" name="file" accept=".jpeg,.png,.jpg,GIF" hidden
                @input="changeAvatar($event)" />
            </div>

            <p class="text-body-1 mb-0">Diperbolehkan JPG atau PNG.</p>
          </form>
        </VCardText>

        <VDivider />

        <VCardText>
          <!-- 👉 Form -->
          <VForm class="mt-6" @submit="submitData">
            <VRow>
              <!-- 👉 First Name -->
              <VCol md="6" cols="12">
                <VTextField v-model="dataAdmin.nama_lengkap" label="Nama Lengkap" />
              </VCol>

              <!-- 👉 Email -->
              <VCol cols="12" md="6">
                <VTextField v-model="dataAdmin.email_admin" label="E-mail" type="email" />
              </VCol>

              <!-- 👉 Phone -->
              <VCol cols="12" md="6">
                <VTextField v-model="dataAdmin.no_telp" label="Nomor Telepon" type="number" placeholder="858 8888 5555"
                  prefix="+62" />
              </VCol>

              <!-- 👉 Address -->
              <VCol cols="12" md="6">
                <VTextField v-model="dataAdmin.alamat" label="Alamat" placeholder="123 Main St, New York, NY 10001" />
              </VCol>

              <!-- 👉 tanggalLahir -->
              <VCol cols="12" md="6">
                <VTextField v-model="dataAdmin.tanggal_lahir" label="Tanggal Lahir" placeholder="" type="date" />
              </VCol>

              <!-- 👉 kelamin -->
              <VCol cols="12" md="6">
                <VSelect v-model="dataAdmin.jenis_kelamin" label="Kelamin" placeholder="L" :items="['L', 'P']" />
              </VCol>

              <!-- 👉 Form Actions -->
              <VCol cols="12" md="9">
                <VBtn type="submit" :disabled="isLoading">
                  <VProgressCircular v-if="isLoading" indeterminate color="white">
                  </VProgressCircular>

                  <span v-else>Simpan</span>
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
import config from "@/@core/config";
import avatar1 from "@images/avatars/avatar-1.png";
import { ref } from "vue";
import Swal from "sweetalert2";

let isLoading = ref(false);

export default {
  components: {},
  data() {
    return {
      urlServer: config.urlServer,
      refInputEl: ref(),
      urlServer: config.urlServer,
      imagePath: config.imagePath,
      refInputEl: ref(),
      dataAdmin: ref([]),
      isLoading: isLoading,
    };
  },
  mounted() {
    this.fetchData();
  },
  methods: {
    async submitData(formData) {
      try {
        formData.preventDefault();
        isLoading.value = true;

        const response = await axios.put(
          `${config.urlServer}/api/admin`,
          {
            id_admin: localStorage.getItem("id_admin"),
            nama_lengkap: this.dataAdmin.nama_lengkap,
            email_admin: this.dataAdmin.email_admin,
            jenis_kelamin: this.dataAdmin.jenis_kelamin,
            tanggal_lahir: this.dataAdmin.tanggal_lahir,
            no_telp: this.dataAdmin.no_telp,
            id_jabatan: this.dataAdmin.id_jabatan,
            alamat: this.dataAdmin.alamat,
          },
          {
            headers: {
              Authorization: localStorage.getItem("tokenAuth"),
            },
          },
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
            timer: 1500,
            icon: "success",
            title: response.data.success.message,
          });
        }
      } catch (error) {
        await Swal.fire({
          toast: true,
          position: "top",
          iconColor: "white",
          color: "white",
          background: "rgb(var(--v-theme-error))",
          showConfirmButton: false,
          timerProgressBar: true,
          timer: 1500,
          icon: "error",
          title: "Harap isi form dengan sesuai!",
        });
      }
      isLoading.value = false;
    },
    async fetchData() {
      const response = await axios.get(
        `${config.urlServer}/api/admin?id_admin=${localStorage.getItem(
          "id_admin",
        )}`,
        {
          headers: {
            Authorization: localStorage.getItem("tokenAuth"),
          },
        },
      );

      this.dataAdmin = response.data;
      this.dataAdmin.foto_profile =
        this.imagePath + this.dataAdmin.foto_profile;
    },

    uploadGambar() {
      document.querySelector("#gambar").click();
    },
    resetForm() {
      this.accountDataLocal.value = structuredClone(this.accountData);
    },
    async changeAvatar(file) {
      const files = file.target.files[0];
      if (files) {
        const fileReader = new FileReader();

        // Validasi tipe file sebelum menampilkan gambarnya
        if (
          files.type === "image/jpeg" ||
          files.type === "image/png" ||
          files.type === "image/jpg"
        ) {
          fileReader.readAsDataURL(files);
          fileReader.onload = async () => {
            try {
              this.dataAdmin.foto_profile = fileReader.result;

              const response = await axios.put(
                `${this.urlServer}/api/admin`,
                {
                  id_admin: localStorage.getItem("id_admin"),
                  foto_profile: fileReader.result,
                },
                {
                  headers: { Authorization: localStorage.getItem("tokenAuth") },
                },
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
                  timer: 1500,
                  icon: "success",
                  title: response.data.success.message,
                });
                this.fetchData();
                localStorage.setItem("foto_profile", fileReader.result);
              }
            } catch (error) {
              await Swal.fire({
                toast: true,
                position: "top",
                iconColor: "white",
                color: "white",
                background: "rgb(var(--v-theme-error))",
                showConfirmButton: false,
                timerProgressBar: true,
                timer: 1500,
                icon: "error",
                title:
                  "terjadi kesalahan saat upload gambar! gambar hanya boleh menggunakan jpeg, png, jpg",
              });
            }
          };
        }
      }
    },
  },
};
</script>
