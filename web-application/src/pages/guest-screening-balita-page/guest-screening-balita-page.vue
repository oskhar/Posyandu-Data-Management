<script setup>
import DataScreeningTab from "./components/data-screening-tab.vue";

// tabs
const tabs = [
	{
		title: "0-5 Bulan",
		icon: "bx-book-add",
		tab: "tab1",
	},
	{
		title: "6-11 Bulan",
		icon: "bx-book-add",
		tab: "tab2",
	},
	{
		title: "12-23 Bulan",
		icon: "bx-book-add",
		tab: "tab3",
	},
	{
		title: "24-59 Bulan",
		icon: "bx-book-add",
		tab: "tab4",
	},
];

const activeTab = ref(tabs[0].tab);
</script>

<template>
	<VRow tag="section" class="px-5 mb-4">
		<VCol cols="12" md="9" class="mx-auto">

			<h1 class="text-primary text-h5 font-weight-bold">Data Screening Balita</h1>
			<p class="text-secondary text-subtitle-1">
				Data screening balita yang telah dilakukan oleh petugas posyandu.
			</p>

			<VTabs v-model="activeTab" show-arrows>
				<VTab v-for="item in tabs" :key="item.icon" :value="item.tab">
					<VIcon size="20" start :icon="item.icon" />
					{{ item.title }}
				</VTab>
			</VTabs>

			<VWindow v-model="activeTab" class="mt-5" :touch="false">
				<VWindowItem :value="tabs[0].tab">
					<DataScreeningTab tab="1" />
				</VWindowItem>
				<VWindowItem :value="tabs[1].tab">
					<DataScreeningTab tab="2" />
				</VWindowItem>
				<VWindowItem :value="tabs[2].tab">
					<DataScreeningTab tab="3" />
				</VWindowItem>
				<VWindowItem :value="tabs[3].tab">
					<DataScreeningTab tab="4" />
				</VWindowItem>
			</VWindow>
		</VCol>
	</VRow>
</template>
