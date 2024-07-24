<script setup>
import { ref } from 'vue';
import EditTantanganTab from './components/tabs-detail-tantangan/edit-tantangan-tab.vue';
import SubmissionTantanganTab from './components/tabs-detail-tantangan/submission-tantangan-tab.vue';
import { useRoute } from 'vue-router';

const route = useRoute();


const tabs = [
	{
		title: "Edit Tantangan",
		icon: "bx-file",
		tab: "edit-tantangan",
	},
	{
		title: "Submission",
		icon: "bx-folder-open",
		tab: "submission",
	},
];

const activeTab = ref(tabs[0].tab);
</script>

<template>
	<VBtn prepend-icon="bx-left-arrow-alt" variant="text" to="/admin/layanan/resleting/tantangan" class="mb-4">
		Kembali
	</VBtn>


	<VTabs v-model="activeTab" show-arrows>
		<VTab v-for="item in tabs" :key="item.icon" :value="item.tab">
			<VIcon size="20" start :icon="item.icon" />
			{{ item.title }}
		</VTab>
	</VTabs>
	<VDivider />

	<VWindow v-model="activeTab" class="mt-5 disable-tab-transition">
		<VWindowItem :value="tabs[0].tab">
			<EditTantanganTab v-if="activeTab === tabs[0].tab" />
		</VWindowItem>

		<VWindowItem :value="tabs[1].tab">
			<SubmissionTantanganTab v-if="activeTab === tabs[1].tab" :tantangan-id="route.params.id" />
		</VWindowItem>
	</VWindow>
</template>
