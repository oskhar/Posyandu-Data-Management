<script setup>
import { ref, onMounted } from "vue";
import { api } from "@/lib/api";
import Swal from "sweetalert2";
import { getSwalErrorMessage } from "@/utils/get-error-message";
import { getFullImagePath } from "@/utils/get-full-image-path";
import {
  convertBase64ToDataUri,
  convertBlobToBase64,
  validateFileInput,
} from "@/utils/file";
import { DEFAULT_PROFILE_PIC } from "@/constants";

const isLoading = ref(false);
const dataUser = ref({});

const fetchData = async () => {
  try {
    const response = await api.post("/user/auth");

    dataUser.value = response.data;
  } catch (error) {
    await Swal.fire({
      icon: "error",
      title: "Gagal mengambil data user!",
      html: getSwalErrorMessage(error),
    });
  }
};

const submitData = async formData => {
  formData.preventDefault();
  isLoading.value = true;

  try {
    const response = await api.put(`/user`, {
      foto_profile: dataUser.value.foto_profile,
      nama: dataUser.value.nama,
      whatsapp: dataUser.value.whatsapp,
    });

    if (response.data.success) {
      await Swal.fire({
        icon: "success",
        title: response.data.success.message,
        showCloseButton: true,
      });
    }
  } catch (error) {
    await Swal.fire({
      icon: "error",
      showCloseButton: true,
      html: getSwalErrorMessage(error),
    });
  } finally {
    isLoading.value = false;
  }
};

const uploadGambar = () => {
  document.querySelector("#image-upload-ref")?.click();
};

const changeAvatar = async event => {
  const [inputFile] = event.target.files;

  try {
    if (
      !validateFileInput(inputFile, "image/jpeg", 10 * 1024 * 1024) &&
      !validateFileInput(inputFile, "image/png", 10 * 1024 * 1024) &&
      !validateFileInput(inputFile, "image/jpg", 10 * 1024 * 1024)
    ) {
      await Swal.fire({
        icon: "error",
        text: "File harus berupa gambar dengan tipe jpeg, png, atau jpg.",
        showCloseButton: true,
      });

      return;
    }

    const foto_profile_base64 = await convertBlobToBase64(inputFile);

    const foto_profile_data_uri = convertBase64ToDataUri(
      foto_profile_base64,
      inputFile.type,
    );

    dataUser.value.foto_profile = foto_profile_data_uri;

    const { data } = await api.put(`/user`, {
      nama: dataUser.value.nama,
      whatsapp: dataUser.value.whatsapp,
      foto_profile: foto_profile_base64,
    });

    if (data.success) {
      await Swal.fire({
        icon: "success",
        showCloseButton: true,
        html: data.success.message,
      });

      await fetchData();
      localStorage.setItem("foto_profile", foto_profile_base64);
    }
  } catch (error) {
    await Swal.fire({
      icon: "error",
      showCloseButton: true,
      html: getSwalErrorMessage(error),
    });
  }
};

onMounted(fetchData);
</script>

<template>
  <VRow>
    <VCol cols="12">
      <VCard title="Account Details">
        <VCardText class="d-flex">
          <!-- 👉 Avatar -->
          <VAvatar rounded="lg" size="100" class="me-6"
            :image="getFullImagePath(dataUser.foto_profile ?? DEFAULT_PROFILE_PIC)" />

          <!-- 👉 Upload Photo -->
          <div class="d-flex flex-column justify-center gap-5">
            <div class="d-flex flex-wrap gap-2">
              <VBtn color="primary" @click="uploadGambar">
                <VIcon icon="bx-cloud-upload" class="d-sm-none" />
                <span class="d-none d-sm-block">Unggah foto baru</span>
              </VBtn>

              <input id="image-upload-ref" multiple="false" type="file" accept=".jpeg,.png,.jpg" hidden
                @input="changeAvatar($event)" />
            </div>

            <p class="text-body-1 mb-0">Diperbolehkan JPG atau PNG.</p>
          </div>
        </VCardText>

        <VDivider />

        <VCardText>
          <!-- 👉 Form -->
          <VForm class="mt-6" @submit="submitData">
            <VRow>
              <!-- 👉 Name -->
              <VCol cols="12">
                <VTextField v-model="dataUser.nama" label="Nama" />
              </VCol>

              <!-- 👉 WhatsApp Number -->
              <VCol cols="12">
                <VTextField v-model="dataUser.whatsapp" label="Nomor WhatsApp" type="number" />
              </VCol>

              <!-- 👉 Form Actions -->
              <VCol cols="12">
                <VBtn type="submit" :loading="isLoading"> Simpan </VBtn>
              </VCol>
            </VRow>
          </VForm>
        </VCardText>
      </VCard>
    </VCol>
  </VRow>
</template>
