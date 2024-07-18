<script setup>
import logo from "@images/logo.svg";
import Swal from "sweetalert2";
import { useRouter } from "vue-router";
import { clearAdminToken, clearUserToken, setAdminToken, setUserToken } from "@/utils/auth-token";
import { loginAdmin, loginUser } from "./api/authentication-api";
import { getSwalErrorMessage } from "@/utils/get-error-message";
import { onMounted } from "vue";

const router = useRouter();
let isLoading = ref(false);

const form = ref({
  email: "",
  password: "",
  remember: false,
});

const isAdminLogin = ref(false);
const isPasswordVisible = ref(false);


const handleLoginAdmin = async () => {
  try {
    const response = await loginAdmin({
      email: form.value.email,
      password: form.value.password,
    });

    setAdminToken({
      authToken: response.data.token,
      idAdmin: response.data.id_admin,
      fotoProfile: response.data.foto_profile,
      namaLengkap: response.data.nama_lengkap,
      jabatan: response.data.jabatan,
    })

    router.push("/admin/dashboard");
  } catch (error) {
    await Swal.fire({
      icon: "error",
      title: "Gagal login",
      html: getSwalErrorMessage(error),
      showCloseButton: true,
    });
  }
};

const handleLoginUser = async () => {
  try {
    const response = await loginUser({
      email: form.value.email,
      password: form.value.password,
    });

    setUserToken({ authToken: response.token, nama: response.nama, whatsapp: response.whatsapp });
    router.push("/");
  } catch (error) {
    await Swal.fire({
      icon: "error",
      title: "Gagal login",
      html: getSwalErrorMessage(error),
      showCloseButton: true,
    });
  }
}

const login = async () => {
  if (isAdminLogin.value) {
    await handleLoginAdmin();
  } else {
    await handleLoginUser();
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
        <VForm @submit.prevent="login">
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

              <div class="mt-1 mb-4 d-flex align-center justify-space-between">
                <RouterLink class="text-primary mt-2 mb-1" to="javascript:void(0)">
                  Lupa Password?
                </RouterLink>

                <VCheckbox v-model="isAdminLogin" label="Login Admin" />
              </div>

              <!-- login button -->
              <VBtn type="submit" :loading="isLoading" :disabled="isLoading" style="width: 448px">
                Masuk
              </VBtn>
            </VCol>
          </VRow>

          <VBtn variant="text" class="w-100 mt-4 mb-1" to="/register">
            Belum punya akun? Register disini.
          </VBtn>
        </VForm>
      </VCardText>


    </VCard>
  </div>
</template>

<style lang="scss">
@use "@core/scss/template/pages/page-auth.scss";
</style>
