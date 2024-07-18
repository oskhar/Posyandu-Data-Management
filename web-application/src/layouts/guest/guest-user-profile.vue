<script setup>
import { useRouter } from "vue-router";
import { api } from "@/lib/api";
import { getSwalErrorMessage } from "@/utils/get-error-message";

const router = useRouter()

const fotoProfile = localStorage.getItem("foto_profile");
const namaLengkap = localStorage.getItem("nama_lengkap");
const poinUser = localStorage.getItem("poin");

const logout = async () => {
  try {
    await api.post(`/user/logout`);
  } catch (error) {
    await Swal.fire({
      icon: "error",
      title: "Error. Tidak Dapat Logout",
      html: getSwalErrorMessage(error),
    })
  } finally {
    localStorage.clear();
    router.push("/login");
  }
};
</script>

<template>
  <VBadge dot location="bottom right" offset-x="3" offset-y="3" color="success" bordered>
    <VAvatar class="cursor-pointer" color="primary" variant="tonal">
      <VImg :src="fotoProfile" />

      <VMenu activator="parent" width="230" location="bottom end" offset="14px">
        <VList>

          <!-- 👉 User Avatar & Name -->
          <VListItem>
            <template #prepend>
              <VListItemAction start>
                <VBadge dot location="bottom right" offset-x="3" offset-y="3" color="success">
                  <VAvatar color="primary" variant="tonal">
                    <VImg :src="fotoProfile" />
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
