<script>
import VerticalNavLayout from "@layouts/components/VerticalNavLayout.vue"
import UserProfile from "@/layouts/admin/admin-user-profile.vue"
import VerticalNavItems from "@/components/vertical-nav-items.vue";
import { ADMIN_DASHBOARD_MENU } from "@/constants/admin-constants";

export default {
  components: {
    VerticalNavLayout,
    VerticalNavItems,
    UserProfile,
  },
  data() {
    return {
      adminMenuItems: ADMIN_DASHBOARD_MENU,
    }
  },
}
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
      <VList>
        <VerticalNavItems :menu-items="adminMenuItems[8].menu" />
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
