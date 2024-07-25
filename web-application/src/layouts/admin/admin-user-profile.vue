<script setup>
import { useRouter } from "vue-router";
import { clearAdminToken } from "@/utils/auth-token";
import Swal from "sweetalert2";
import { getSwalErrorMessage } from "@/utils/get-error-message";
import { useAdminRoleStore } from "@/stores/admin-role-store";
import { onMounted, ref } from "vue";
import { api } from "@/lib/api";
import { getFullImagePath } from "@/utils/get-full-image-path";
import { DEFAULT_PROFILE_PIC } from "@/constants";

const router = useRouter();

const adminRoleStore = useAdminRoleStore();
const isLoading = ref(true);
const fotoProfile = ref(null);
const namaLengkap = ref(null);
const jabatan = ref(null);

const logout = async () => {
  try {
    clearAdminToken();
    adminRoleStore.resetRole();
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
    const { data } = await api.post("/auth");
    const { foto_profile, nama_lengkap, jabatan: nama_jabatan } = data;

    fotoProfile.value = foto_profile;
    namaLengkap.value = nama_lengkap;
    jabatan.value = nama_jabatan;
  } catch (error) {
    console.log(error);
    await Swal.fire({
      icon: "error",
      title: "Error mengambil data admin",
      html: getSwalErrorMessage(error),
    });
  } finally {
    isLoading.value = false;
  }
});
</script>

<template>
  <VForm @submit="login">
    <VBadge dot location="bottom right" offset-x="3" offset-y="3" color="success" bordered>
      <VAvatar class="cursor-pointer" color="primary" variant="tonal">
        <VImg :src="getFullImagePath(fotoProfile ?? DEFAULT_PROFILE_PIC)" />

        <!-- SECTION Menu -->
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
              <VListItemSubtitle>{{ jabatan }}</VListItemSubtitle>
            </VListItem>
            <VDivider class="my-2" />

            <!-- 👉 Profile -->
            <VListItem link to="/admin/dashboard">
              <template #prepend>
                <VIcon class="me-2" icon="bx-home" size="22" />
              </template>

              <VListItemTitle>Dashboard</VListItemTitle>
            </VListItem>

            <!-- 👉 Profile -->
            <VListItem link to="/admin/account-settings">
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
        <!-- !SECTION -->
      </VAvatar>
    </VBadge>
  </VForm>
</template>
