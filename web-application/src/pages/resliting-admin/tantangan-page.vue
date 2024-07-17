<script setup>
import { ref } from 'vue';
import ListTantanganTab from './components/tabs-tantangan/list-tantangan-tab.vue';
import CreateTantanganTab from './components/tabs-tantangan/create-tantangan-tab.vue';

const tabs = [
	{
		title: "Semua Tantangan",
		icon: "bx-list-ul",
		tab: "semua-tantangan",
	},
	{
		title: "Buat Tantangan",
		icon: "bx-add-to-queue",
		tab: "buat-tantangan",
	},
];

const activeTab = ref(tabs[0].tab);
</script>

<template>
	<VTabs v-model="activeTab" show-arrows>
		<VTab v-for="item in tabs" :key="item.icon" :value="item.tab">
			<VIcon size="20" start :icon="item.icon" />
			{{ item.title }}
		</VTab>
	</VTabs>
	<VDivider />

	<VWindow v-model="activeTab" class="mt-5 disable-tab-transition">
		<VWindowItem :value="tabs[0].tab">
			<ListTantanganTab />
		</VWindowItem>

		<VWindowItem :value="tabs[1].tab">
			<CreateTantanganTab />
		</VWindowItem>
	</VWindow>
</template>