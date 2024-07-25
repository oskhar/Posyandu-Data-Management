<script setup>
import { useRoute } from "vue-router";
import ReadAdmin from "@/views/pages/admin/ReadAdmin.vue";
import CreateAdmin from "@/views/pages/admin/CreateAdmin.vue";

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

        <VWindow v-model="activeTab" class="mt-5" :touch="false">
            <!-- read -->
            <VWindowItem value="read">
                <ReadAdmin />
            </VWindowItem>

            <!-- create -->
            <VWindowItem value="create">
                <CreateAdmin />
            </VWindowItem>
        </VWindow>
    </div>
</template>
