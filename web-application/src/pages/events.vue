<script setup>
import { useRoute } from "vue-router";
import ReadEvents from "@/views/pages/events/ReadEvents.vue";
import CreateEvent from "@/views/pages/events/CreateEvent.vue";

const route = useRoute();
const activeTab = ref(route.params.tab);

// tabs
const tabs = [
  {
    title: "lihat",
    icon: "bx-book-open",
    tab: "read",
  },
  {
    title: "buat",
    icon: "bx-book-add",
    tab: "create",
  },
];
</script>

<template>
  <div>
    <VTabs v-model="activeTab" show-arrows>
      <VTab v-for="item in tabs" :key="item.icon" :value="item.tab">
        <VIcon size="20" start :icon="item.icon" />
        {{ item.title }}
      </VTab>
    </VTabs>
    <VDivider />

    <VWindow v-model="activeTab" class="mt-5">
      <!-- read -->
      <VWindowItem value="read">
        <ReadEvents />
      </VWindowItem>

      <!-- create -->
      <VWindowItem value="create">
        <CreateEvent />
      </VWindowItem>
    </VWindow>
  </div>
</template>
