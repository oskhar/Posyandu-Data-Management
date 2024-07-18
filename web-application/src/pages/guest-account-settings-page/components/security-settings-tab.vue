<script setup>
import Swal from "sweetalert2";
import { api } from "@/lib/api";
import { getSwalErrorMessage } from "@/utils/get-error-message";

const isCurrentPasswordVisible = ref(false);
const isNewPasswordVisible = ref(false);
const isConfirmPasswordVisible = ref(false);
const currentPassword = ref("");
const newPassword = ref("");
const confirmPassword = ref("");
const isLoading = ref(false);

const submitkan = async formData => {
  formData.preventDefault();

  try {
    isLoading.value = true;

    const response = await api.put(
      `/user/reset-password`,
      {
        old_password: currentPassword.value,
        new_password: newPassword.value,
        confirm_password: confirmPassword.value,
      },
    );

    await Swal.fire({
      icon: "success",
      showCloseButton: true,
      title: response.data.success.message,
    });

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

const passwordRequirements = ["Minimal 8 karakter"];
</script>

<template>
  <VRow>
    <!-- SECTION: Change Password -->
    <VCol cols="12">
      <VCard title="Ubah Password">
        <VForm @submit="submitkan">
          <VCardText>
            <!-- 👉 Current Password -->
            <VRow>
              <VCol cols="12" sm="4">
                <!-- 👉 current password -->
                <VTextField v-model="currentPassword" :type="isCurrentPasswordVisible ? 'text' : 'password'"
                  :append-inner-icon="isCurrentPasswordVisible ? 'bx-hide' : 'bx-show'
                    " label="Password Saat Ini" placeholder="············" @click:append-inner="
                      isCurrentPasswordVisible = !isCurrentPasswordVisible
                      " />
              </VCol>
              <VCol cols="12" sm="4">
                <!-- 👉 new password -->
                <VTextField v-model="newPassword" :type="isNewPasswordVisible ? 'text' : 'password'" :append-inner-icon="isNewPasswordVisible ? 'bx-hide' : 'bx-show'
                  " label="Password Baru" placeholder="············" @click:append-inner="
                    isNewPasswordVisible = !isNewPasswordVisible
                    " />
              </VCol>

              <VCol cols="12" sm="4">
                <!-- 👉 confirm password -->
                <VTextField v-model="confirmPassword" :type="isConfirmPasswordVisible ? 'text' : 'password'"
                  :append-inner-icon="isConfirmPasswordVisible ? 'bx-hide' : 'bx-show'
                    " label="Konfirmasi Password Baru" placeholder="············" @click:append-inner="
                      isConfirmPasswordVisible = !isConfirmPasswordVisible
                      " />
              </VCol>
            </VRow>

            <!-- 👉 New Password -->
          </VCardText>

          <!-- 👉 Password Requirements -->
          <VCardText>
            <p class="text-base font-weight-medium mt-2">Syarat Password:</p>

            <ul class="d-flex flex-column gap-y-3">
              <li v-for="item in passwordRequirements" :key="item" class="d-flex">
                <div>
                  <VIcon size="7" icon="bxs-circle" class="me-3" />
                </div>
                <span class="font-weight-medium">{{ item }}</span>
              </li>
            </ul>
          </VCardText>

          <!-- 👉 Action Buttons -->
          <VCardText class="d-flex flex-wrap gap-4">
            <VBtn type="submit">Simpan Perubahan</VBtn>
          </VCardText>
        </VForm>
      </VCard>
    </VCol>
  </VRow>
</template>
