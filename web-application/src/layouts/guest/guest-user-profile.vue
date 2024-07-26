<script setup>
import { useRouter } from "vue-router";
import { getSwalErrorMessage } from "@/utils/get-error-message";
import Swal from "sweetalert2";
import { clearUserToken } from "@/utils/auth-token";
import { getFullImagePath } from "@/utils/get-full-image-path";
import { api } from "@/lib/api";
import { DEFAULT_PROFILE_PIC } from "@/constants";

const router = useRouter();

const fotoProfile = ref(null);
const namaLengkap = ref(null);
const poinUser = ref(null);

const logout = async () => {
  try {
    clearUserToken();
  } catch (error) {
    await Swal.fire({
      icon: "error",
      title: "Error. Tidak Dapat Logout",
      html: getSwalErrorMessage(error),
    });
  } finally {
    router.push("/login");
  }
};


onMounted(async () => {
  try {
    const { data } = await api.post("/user/auth");
    const { foto_profile, nama, poin } = data;

    fotoProfile.value = foto_profile;
    namaLengkap.value = nama;
    poinUser.value = poin;
  } catch (error) {
    await Swal.fire({
      icon: "error",
      title: "Error mengambil data admin",
      html: getSwalErrorMessage(error),
    });

    clearUserToken();
    router.push("/login")
  }
});
</script>

<template>
  <VBadge dot location="bottom right" offset-x="3" offset-y="3" color="success" bordered>
    <VAvatar class="cursor-pointer" color="primary" variant="tonal">
      <VImg :src="getFullImagePath(fotoProfile ?? DEFAULT_PROFILE_PIC)" />

      <VMenu activator="parent" width="230" location="bottom end" offset="14px">
        <VList>
          <!-- 👉 User Avatar & Name -->
          <VListItem>
            <template #prepend>
              <VListItemAction start>
                <VBadge dot location="bottom right" offset-x="3" offset-y="3" color="success">
                  <VAvatar color="primary" variant="tonal">
                    <VImg :src="getFullImagePath(fotoProfile ?? DEFAULT_PROFILE_PIC)" />
                  </VAvatar>
                </VBadge>
              </VListItemAction>
            </template>

            <VListItemTitle class="font-weight-semibold">
              {{ namaLengkap }}
            </VListItemTitle>
            <VListItemSubtitle>Poin: {{ poinUser }}</VListItemSubtitle>
          </VListItem>
          <VDivider class="my-2" />

          <!-- 👉 Profile -->
          <VListItem link to="/account-settings">
            <template #prepend>
              <VIcon class="me-2" icon="bx-user" size="22" />
            </template>

            <VListItemTitle>Profile</VListItemTitle>
          </VListItem>

          <!-- Divider -->
          <VDivider class="my-2" />

          <!-- 👉 Logout -->
          <VListItem @click="logout">
            <template #prepend>
              <VIcon class="me-2" icon="bx-log-out" size="22" />
            </template>

            <VListItemTitle>Logout</VListItemTitle>
          </VListItem>
        </VList>
      </VMenu>
    </VAvatar>
  </VBadge>
</template>
