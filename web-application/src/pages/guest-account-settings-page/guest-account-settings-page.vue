<script setup>
import { useRoute } from "vue-router";
import ProfileSettingsTab from "./components/profile-settings-tab.vue";
import SecuritySettingsTab from "./components/security-settings-tab.vue";


const route = useRoute();
const activeTab = ref(route.params.tab);

// tabs
const tabs = [
	{
		title: "Akun",
		icon: "bx-user",
		tab: "account",
	},
	{
		title: "Keamanan",
		icon: "bx-lock-open",
		tab: "security",
	},
];
</script>

<template>
	<VRow class="mt-16 mb-8">
		<VCol cols="12" md="9" class="mx-auto px-5">
			<VTabs v-model="activeTab" show-arrows>
				<VTab v-for="item in tabs" :key="item.icon" :value="item.tab">
					<VIcon size="20" start :icon="item.icon" />
					{{ item.title }}
				</VTab>
			</VTabs>
			<VDivider />

			<VWindow v-model="activeTab" class="mt-5 disable-tab-transition">
				<!-- Account -->
				<VWindowItem value="account">
					<ProfileSettingsTab />
				</VWindowItem>

				<!-- Security -->
				<VWindowItem value="security">
					<SecuritySettingsTab />
				</VWindowItem>
			</VWindow>
		</VCol>
	</VRow>
</template>
