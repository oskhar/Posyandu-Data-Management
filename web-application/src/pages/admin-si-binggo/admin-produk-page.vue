<script setup>
import { ref } from 'vue';
import ListProdukTab from './components/tabs-produk/list-produk-tab.vue';
import CreateProdukTab from './components/tabs-produk/create-produk-tab.vue';
import ProdukTerPin from './components/tabs-produk/produk-ter-pin.vue';

const tabs = [
	{
		title: "Semua Produk",
		icon: "bx-list-ul",
		tab: "semua-produk",
	},
	{
		title: "Produk Yang Di Pin",
		icon: "bx-list-ul",
		tab: "pinned-produk",
	},
	{
		title: "Buat Produk",
		icon: "bx-add-to-queue",
		tab: "buat-produk",
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
			<ListProdukTab v-if="activeTab === tabs[0].tab" />
		</VWindowItem>

		<VWindowItem :value="tabs[1].tab">
			<ProdukTerPin v-if="activeTab === tabs[1].tab" />
		</VWindowItem>

		<VWindowItem :value="tabs[2].tab">
			<CreateProdukTab v-if="activeTab === tabs[2].tab" />
		</VWindowItem>
	</VWindow>
</template>