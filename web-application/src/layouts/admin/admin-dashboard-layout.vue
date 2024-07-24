<script setup>
import VerticalNavLayout from "@layouts/components/VerticalNavLayout.vue"
import UserProfile from "@/layouts/admin/admin-user-profile.vue"
import VerticalNavItems from "@/components/vertical-nav-items.vue";
import { ADMIN_DASHBOARD_MENU } from "@/constants/admin-constants";
import { useAdminRoleStore } from "@/stores/admin-role-store";
import { computed, watch } from "vue";
import { clearAdminToken } from "@/utils/auth-token";

const adminRoleStore = useAdminRoleStore();
const router = useRouter();


const activeNavigation = computed(() => {
  return ADMIN_DASHBOARD_MENU.find(menu => {
    return menu.id_jabatan === adminRoleStore.currentRole
  });
})

watch(activeNavigation.value, () => {
  if (!activeNavigation.value) {
    clearAdminToken();
    router.push("/login");
  }
})
</script>


<template>
  <VerticalNavLayout>
    <!-- 👉 navbar -->
    <template #navbar="{ toggleVerticalOverlayNavActive }">
      <div class="d-flex h-100 align-center">
        <VRow>
          <VCol>
            <IconBtn class="ms-n3 d-lg-none" @click="toggleVerticalOverlayNavActive(true)">
              <VIcon icon="bx-menu" />
            </IconBtn>
          </VCol>
          <VCol>
            <UserProfile class="float-right" />
          </VCol>
        </VRow>
      </div>
    </template>


    <template #vertical-nav-content>
      <VList v-if="activeNavigation">
        <VerticalNavItems :menu-items="activeNavigation.menu" />
      </VList>
    </template>

    <!-- 👉 Pages -->
    <RouterView />
  </VerticalNavLayout>
</template>

<style lang="scss">
// As we are using `layouts` plugin we need its styles to be imported
@use "@layouts/styles/default-layout";

.meta-key {
  border: thin solid rgba(var(--v-border-color), var(--v-border-opacity));
  border-radius: 6px;
  block-size: 1.5625rem;
  line-height: 1.3125rem;
  padding-block: 0.125rem;
  padding-inline: 0.25rem;
}
</style>
