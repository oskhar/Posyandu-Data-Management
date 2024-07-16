<script setup>
import logo from "@images/logo.svg";
import axios from "axios";
import config from "@/@core/config";
import Swal from "sweetalert2";
import { useRouter } from "vue-router";

const router = useRouter();
let isLoading = ref(false);

const form = ref({
  email: "",
  password: "",
  remember: false,
});

const login = async formLogin => {
  formLogin.preventDefault();
  isLoading.value = true;
  try {
    const response = await axios.post(`${config.urlServer}/api/login`, {
      email_admin: form.value.email,
      password: form.value.password,
    });

    localStorage.setItem("tokenAuth", "Bearer " + response.data.token);
    localStorage.setItem("id_admin", response.data.id_admin);
    localStorage.setItem(
      "foto_profile",
      config.imagePath + response.data.foto_profile,
    );
    localStorage.setItem("nama_lengkap", response.data.nama_lengkap);
    localStorage.setItem("jabatan", response.data.jabatan);


    router.push("/admin/dashboard");
  } catch (error) {
    Swal.fire({
      toast: true,
      position: "top",
      iconColor: "white",
      color: "white",
      background: "rgb(var(--v-theme-error))",
      showConfirmButton: false,
      timerProgressBar: true,
      timer: 2000,
      icon: "error",
      title: "Email atau Password salah",
    });
  }
  isLoading.value = false;
};

const isPasswordVisible = ref(false);
</script>

<template>
  <div class="auth-wrapper d-flex align-center justify-center pa-4">
    <VCard class="auth-card pa-4 pt-7" max-width="448">
      <VCardItem class="justify-center">
        <template #prepend>
          <div class="d-flex">
            <img class="d-flex text-primary" :src="logo" />
          </div>
        </template>

        <VCardTitle class="text-2xl font-weight-bold"> </VCardTitle>
      </VCardItem>

      <VCardText class="pt-2">
        <h5 class="text-h5 mb-1">Selamat datang di Posyandu!👋🏻</h5>
        <p class="mb-0">Mohon sign-in ke akun anda</p>
      </VCardText>

      <VCardText>
        <VForm @submit="login">
          <VRow>
            <!-- email -->
            <VCol cols="12">
              <VTextField v-model="form.email" autofocus placeholder="posyandu@email.com" label="Email" type="email" />
            </VCol>

            <!-- password -->
            <VCol cols="12">
              <VTextField v-model="form.password" class="mb-5" label="Password" placeholder="············"
                :type="isPasswordVisible ? 'text' : 'password'"
                :append-inner-icon="isPasswordVisible ? 'bx-hide' : 'bx-show'"
                @click:append-inner="isPasswordVisible = !isPasswordVisible" />

              <!-- remember me checkbox -->
              <div class="mt-1 mb-4">
                <RouterLink class="text-primary ms-2 mb-1" to="javascript:void(0)">
                  Lupa Password?
                </RouterLink>
              </div>

              <!-- login button -->

              <VBtn type="submit" :disabled="isLoading" style="width: 448px">
                <VProgressCircular v-if="isLoading" indeterminate color="white">
                </VProgressCircular>

                <Font v-else>masuk</Font>
              </VBtn>
            </VCol>
            <!-- auth providers -->
            <VCol cols="12" class="text-center">
              <!-- <AuthProvider /> -->
            </VCol>
          </VRow>
        </VForm>
      </VCardText>

      <RouterLink to="./">
        <div>
          <VIcon>bx-chevron-left</VIcon>
          Halaman Depan
        </div>
      </RouterLink>
    </VCard>
  </div>
</template>

<style lang="scss">
@use "@core/scss/template/pages/page-auth.scss";
</style>
