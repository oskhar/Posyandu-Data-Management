<script setup>
const props = defineProps({
  item: {
    type: null,
    required: true,
  },
});
let menuActive = ref(false);
const active = () => {
  menuActive.value = menuActive.value ? false : true;
};
</script>

<template>
  <li class="nav-link nav-treeview" :class="{ disabled: item.disable }">
    <Component
      @click="active"
      :is="item.to ? 'RouterLink' : 'a'"
      :to="item.to"
      :href="item.href"
    >
      <VIcon icon="bx-down-arrow" class="nav-item-icon" />
      <!-- 👉 Title -->
      <span class="nav-item-title">
        {{ item.title }}
      </span>
    </Component>
  </li>
  <li
    v-for="data in item.children"
    v-if="menuActive"
    class="nav-link"
    :class="{ disabled: item.disable }"
  >
    <Component
      :is="data.to ? 'RouterLink' : 'a'"
      :to="data.to"
      :href="data.href"
    >
      <VIcon icon="bx-minus" class="nav-item-icon" />
      <!-- 👉 Title -->
      <span class="nav-item-title">
        {{ data.title }}
      </span>
    </Component>
  </li>
</template>

<style lang="scss">
.layout-vertical-nav {
  .nav-link a {
    display: flex;
    align-items: center;
    cursor: pointer;
  }
}
</style>
