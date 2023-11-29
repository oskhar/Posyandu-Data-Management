<script setup>
import axios from "axios";
import config from "@/@core/config.vue";
import avatar1 from "@images/avatars/avatar-1.png";
import { onMounted } from "vue";

const myAcc = [];
const urlServer = config.urlServer;

const accountData = {
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
};

const refInputEl = ref();
const accountDataLocal = ref(structuredClone(accountData));

const resetForm = () => {
  accountDataLocal.value = structuredClone(accountData);
};

const changeAvatar = (file) => {
  const fileReader = new FileReader();
  const { files } = file.target;
  if (files && files.length) {
    fileReader.readAsDataURL(files[0]);
    fileReader.onload = () => {
      if (typeof fileReader.result === "string")
        accountDataLocal.value.avatarImg = fileReader.result;
    };
  }
};

// reset avatar image
const resetAvatar = () => {
  accountDataLocal.value.avatarImg = accountData.avatarImg;
};

// onMounted(async () => {
//   const response = await axios.get(`${urlServer}/api/admin`);
//   myAcc = response.data;
// });
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
            :image="accountDataLocal.avatarImg"
          />

          <!-- 👉 Upload Photo -->
          <form class="d-flex flex-column justify-center gap-5">
            <div class="d-flex flex-wrap gap-2">
              <VBtn color="primary" @click="refInputEl?.click()">
                <VIcon icon="bx-cloud-upload" class="d-sm-none" />
                <span class="d-none d-sm-block">Unggah foto baru</span>
              </VBtn>

              <input
                ref="refInputEl"
                type="file"
                name="file"
                accept=".jpeg,.png,.jpg,GIF"
                hidden
                @input="changeAvatar"
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

            <p class="text-body-1 mb-0">Diperbolehkan JPG, GIF or PNG.</p>
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
                  v-model="accountDataLocal.firstName"
                  label="Nama Lengkap"
                />
              </VCol>

              <!-- 👉 Email -->
              <VCol cols="12" md="6">
                <VTextField
                  v-model="accountDataLocal.email"
                  label="E-mail"
                  type="email"
                />
              </VCol>

              <!-- 👉 Phone -->
              <VCol cols="12" md="6">
                <VTextField
                  v-model="accountDataLocal.phone"
                  label="Nomor Telepon"
                  placeholder="858 8888 5555"
                  prefix="+62"
                />
              </VCol>

              <!-- 👉 Address -->
              <VCol cols="12" md="6">
                <VTextField
                  v-model="accountDataLocal.address"
                  label="Alamat"
                  placeholder="123 Main St, New York, NY 10001"
                />
              </VCol>

              <!-- 👉 tanggalLahir -->
              <VCol cols="12" md="6">
                <VTextField
                  v-model="accountDataLocal.tanggalLahir"
                  label="Tanggal Lahir"
                  placeholder=""
                  type="date"
                />
              </VCol>
              <VCol cols="12" md="6">
                <VSelect
                  v-model="accountDataLocal.country"
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
                  v-model="accountDataLocal.kelamin"
                  label="Kelamin"
                  placeholder="Laki-laki"
                  :items="['Laki-laki', 'Perempuan']"
                />
              </VCol>

              <!-- 👉 Form Actions -->
              <VCol cols="12" class="d-flex flex-wrap gap-4">
                <VBtn>Simpan Perubahan</VBtn>

                <VBtn
                  color="secondary"
                  variant="tonal"
                  type="reset"
                  @click.prevent="resetForm"
                >
                  Reset
                </VBtn>
              </VCol>
            </VRow>
          </VForm>
        </VCardText>
      </VCard>
    </VCol>
  </VRow>
</template>
