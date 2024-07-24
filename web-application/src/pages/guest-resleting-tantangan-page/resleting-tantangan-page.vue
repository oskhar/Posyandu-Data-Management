<script setup>
import { ref, computed } from 'vue';
import FollowedTantanganTab from './components/tabs/followed-tantangan-tab.vue';
import AvailableTantanganTab from './components/tabs/available-tantangan-tab.vue';

const isAdminOrUnauthorized = ref(localStorage.getItem("id_admin") !== null || !localStorage.getItem("tokenAuth"));

const tabs = [
	{
		title: "Semua Tantangan",
		icon: "bx-list-ul",
		tab: "semua-tantangan",
	},
	{
		title: "Tantangan Yang Diikuti",
		icon: "bx-list-check",
		tab: "tantangan-yang-diikuti",
	},
];

const activeTab = ref(tabs[0].tab);

const filteredTabs = computed(() => {
	return isAdminOrUnauthorized.value ? [tabs[0]] : tabs;
});
</script>

<template>
	<VRow tag="section" class="px-5 mb-4">
		<VCol cols="12" md="9" class="mx-auto">
			<VBtn prepend-icon="bx-left-arrow-alt" variant="text" to="/layanan/resleting" class="mb-4">Kembali
			</VBtn>

			<h1 class="text-primary text-h5 font-weight-bold">Tantangan</h1>
			<p class="text-secondary text-subtitle-1">
				Tantangan yang anda dapat ikuti, menangkan dan dapatkan hadiahnya!
			</p>

			<VTabs v-model="activeTab" show-arrows>
				<VTab v-for="item in filteredTabs" :key="item.icon" :value="item.tab">
					<div>
						<VIcon size="20" start :icon="item.icon" />
						{{ item.title }}
					</div>
				</VTab>
			</VTabs>
			<VDivider />

			<VWindow v-model="activeTab" class="mt-5 disable-tab-transition">
				<VWindowItem :value="tabs[0].tab">
					<AvailableTantanganTab v-if="activeTab === tabs[0].tab" />
				</VWindowItem>

				<VWindowItem v-if="!isAdminOrUnauthorized" :value="tabs[1].tab">
					<FollowedTantanganTab v-if="activeTab === tabs[1].tab" />
				</VWindowItem>
			</VWindow>
		</VCol>
	</VRow>
</template>
