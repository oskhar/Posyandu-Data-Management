<script setup>
import avatar1 from "@images/avatars/avatar-1.png";
import axios from "axios";
import config from "@/@core/config";
import { useRouter } from "vue-router";

const router = useRouter()

const fotoProfile = localStorage.getItem("foto_profile");
const namaLengkap = localStorage.getItem("nama_lengkap");
const jabatan = localStorage.getItem("jabatan");

const logout = async () => {
  const response = await axios.post(
    `${config.urlServer}/api/logout`,
    {},
    {
      headers: {
        Authorization: "Bearer " + localStorage.getItem("tokenAuth"),
      },
    },
  );

  localStorage.clear();
  router.push("/login");
};
</script>

<template>
  <VForm @submit="login">
    <VBadge dot location="bottom right" offset-x="3" offset-y="3" color="success" bordered>
      <VAvatar class="cursor-pointer" color="primary" variant="tonal">
        <VImg :src="fotoProfile" />

        <!-- SECTION Menu -->
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
