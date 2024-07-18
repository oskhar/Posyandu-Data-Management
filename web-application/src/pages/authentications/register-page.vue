<script setup>
import logo from '@images/logo.svg'
import Swal from 'sweetalert2';
import { useRouter } from 'vue-router';
import { registerUser } from './api/authentication-api';
import { getApiResponse } from '@/utils/get-api-response';
import { getSwalErrorMessage } from '@/utils/get-error-message';
import { onMounted } from 'vue';
import { clearAdminToken, clearUserToken } from '@/utils/auth-token';

const router = useRouter();

const form = ref({
  nama: '',
  email: '',
  password: '',
  whatsapp: '',
})

const isPasswordVisible = ref(false)


const handleRegisterUser = async () => {
  try {
    const response = await registerUser({
      nama: form.value.nama,
      email: form.value.email,
      password: form.value.password,
      whatsapp: form.value.whatsapp,
    });

    await Swal.fire({
      icon: 'success',
      title: 'Berhasil!',
      text: getApiResponse(response).message,
      showCloseButton: true,
    });

    router.push("/login");
  } catch (error) {
    await Swal.fire({
      icon: "error",
      title: "Gagal Registrasi",
      html: getSwalErrorMessage(error),
      showCloseButton: true,
    });
  }
}

onMounted(() => {
  clearAdminToken();
  clearUserToken();
})
</script>

<template>
  <div class="auth-wrapper d-flex align-center justify-center pa-4">
    <VCard class="auth-card pa-4 pt-7" max-width="448">
      <VBtn to="/" variant="text">
        <div>
          <VIcon>bx-chevron-left</VIcon>
          Halaman Depan
        </div>
      </VBtn>


      <VCardItem class="justify-center">
        <img class="d-flex text-primary" :src="logo" />
      </VCardItem>

      <VCardText class="pt-2">
        <h5 class="text-h5 mb-1">Selamat datang di Posyandu!👋🏻</h5>
        <p class="mb-0">Mohon sign-in ke akun anda</p>
      </VCardText>

      <VCardText>
        <VForm @submit.prevent="handleRegisterUser">
          <VRow>
            <!-- Nama -->
            <VCol cols="12">
              <VTextField v-model="form.nama" autofocus label="Nama" />
            </VCol>

            <!-- email -->
            <VCol cols="12">
              <VTextField v-model="form.email" label="Email" type="email" />
            </VCol>

            <!-- No.Whatsapp -->
            <VCol cols="12">
              <VTextField v-model="form.whatsapp" label="No. Whatsapp" placeholder="0812123456" type="email" />
            </VCol>

            <!-- password -->
            <VCol cols="12">
              <VTextField v-model="form.password" label="Password" :type="isPasswordVisible ? 'text' : 'password'"
                :append-inner-icon="isPasswordVisible ? 'bx-hide' : 'bx-show'"
                @click:append-inner="isPasswordVisible = !isPasswordVisible" />

              <VBtn block type="submit" class="mt-5">
                Register
              </VBtn>
            </VCol>

          </VRow>
          <VBtn variant="text" class="w-100 mt-4" to="/login">
            Sudah punya akun? Login
          </VBtn>
        </VForm>
      </VCardText>
    </VCard>
  </div>
</template>

<style lang="scss">
@use "@core/scss/template/pages/page-auth.scss";
</style>
