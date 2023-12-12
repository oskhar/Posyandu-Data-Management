<script>
import axios from "axios";
import config from "@/@core/config.vue";
import avatar1 from "@images/avatars/avatar-1.png";
import { onMounted } from "vue";

export default {
  data() {
    return {
      refInputEl: ref(),
      urlServer: config.urlServer,
      accountData: {
        avatarImg: avatar1,
        firstName: "jo",
        email: "posyandu@gmail.com",
        org: "ThemeSelection",
        phone: "857 9876 4532",
        address: "Jln. Mangga No.20 RT.02/12 ",
        tanggalLahir: "2024-12-12",
        zip: "10001",
        country: "PELINDUNG",
        kelamin: "Laki-laki",
        timezone: "(GMT-11:00) International Date Line West",
        currency: "USD",
      },
      refInputEl: ref(),
    };
  },
  components: {},
  mounted() {
    console.log(this.accountData);
  },
  methods: {
    uploadGambar() {
      document.querySelector("#gambar").click();
    },
    resetForm() {
      this.accountDataLocal.value = structuredClone(this.accountData);
    },
    resetAvatar() {
      this.accountDataLocal.value.avatarImg = this.accountData.avatarImg;
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
            if (typeof fileReader.result === "string")
              this.accountData.avatarImg = fileReader.result;
            const response = await axios.put();
          };
        }
      }
    },
  },
};
</script>

<template>
  <VRow>
    <VCol cols="12">
      <VCard title="Account Details">
        <VCardText class="d-flex">
          <!-- 👉 Avatar -->
          <VAvatar
            rounded="lg"
            size="100"
            class="me-6"
            :image="accountData.avatarImg"
          />

          <!-- 👉 Upload Photo -->
          <form class="d-flex flex-column justify-center gap-5">
            <div class="d-flex flex-wrap gap-2">
              <VBtn color="primary" @click="uploadGambar">
                <VIcon icon="bx-cloud-upload" class="d-sm-none" />
                <span class="d-none d-sm-block">Unggah foto baru</span>
              </VBtn>

              <input
                id="gambar"
                ref="refInputEl"
                type="file"
                name="file"
                accept=".jpeg,.png,.jpg,GIF"
                hidden
                @input="changeAvatar($event)"
              />
            </div>

            <p class="text-body-1 mb-0">Diperbolehkan JPG atau PNG.</p>
          </form>
        </VCardText>

        <VDivider />

        <VCardText>
          <!-- 👉 Form -->
          <VForm class="mt-6">
            <VRow>
              <!-- 👉 First Name -->
              <VCol md="6" cols="12">
                <VTextField
                  v-model="accountData.firstName"
                  label="Nama Lengkap"
                />
              </VCol>

              <!-- 👉 Email -->
              <VCol cols="12" md="6">
                <VTextField
                  v-model="accountData.email"
                  label="E-mail"
                  type="email"
                />
              </VCol>

              <!-- 👉 Phone -->
              <VCol cols="12" md="6">
                <VTextField
                  v-model="accountData.phone"
                  label="Nomor Telepon"
                  placeholder="858 8888 5555"
                  prefix="+62"
                />
              </VCol>

              <!-- 👉 Address -->
              <VCol cols="12" md="6">
                <VTextField
                  v-model="accountData.address"
                  label="Alamat"
                  placeholder="123 Main St, New York, NY 10001"
                />
              </VCol>

              <!-- 👉 tanggalLahir -->
              <VCol cols="12" md="6">
                <VTextField
                  v-model="accountData.tanggalLahir"
                  label="Tanggal Lahir"
                  placeholder=""
                  type="date"
                />
              </VCol>
              <VCol cols="12" md="6">
                <VSelect
                  v-model="accountData.country"
                  label="Jabatan"
                  :items="[
                    'PELINDUNG',
                    'PENANGGUNG JAWAB',
                    'SEKRETARIS',
                    'BENDAHARA',
                    'PENDAFTARAN',
                    'PENIMBANGAN',
                    'PENCATATAN',
                    'PENYULUHAN',
                  ]"
                  placeholder="Select Country"
                />
              </VCol>

              <!-- 👉 kelamin -->
              <VCol cols="12" md="6">
                <VSelect
                  v-model="accountData.kelamin"
                  label="Kelamin"
                  placeholder="Laki-laki"
                  :items="['Laki-laki', 'Perempuan']"
                />
              </VCol>

              <!-- 👉 Form Actions -->
              <VCol cols="12" class="d-flex flex-wrap gap-4">
                <VBtn>Simpan Perubahan</VBtn>
              </VCol>
            </VRow>
          </VForm>
        </VCardText>
      </VCard>
    </VCol>
  </VRow>
</template>
