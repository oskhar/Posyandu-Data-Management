<script setup>
const { menuItems, flipAccordionIcon } = defineProps({
	menuItems: { type: Array, required: true },
	flipAccordionIcon: { type: Boolean, required: false, default: false },
})
</script>

<template>
	<template v-for="(item, index) in menuItems" :key="index">
		<VListItem v-if="item.childrens" class="text-primary">
			<VExpansionPanels>
				<VExpansionPanel class="text-primary" :class="[{ 'custom-expansion-panel': !flipAccordionIcon }]">
					<VExpansionPanelTitle class="pa-0">{{ item.text }}</VExpansionPanelTitle>
					<VExpansionPanelText class="list-item-accordion">
						<VList class="text-primary">
							<VListItem v-for="(child, childIndex) in item.childrens" :key="childIndex" :to="child.route"
								:active="false">
								{{ child.text }}
							</VListItem>
						</VList>
					</VExpansionPanelText>
				</VExpansionPanel>
			</VExpansionPanels>
		</VListItem>
		<VListItem v-else class="non-expansion-list-item text-primary" :to="item.route" :active="false"
			:prepend-icon="item.icon">
			{{ item.text }}
		</VListItem>
	</template>
</template>

<style>
.custom-expansion-panel .v-expansion-panel-title {
	flex-direction: row-reverse;
	justify-content: start;
}

.custom-expansion-panel .v-expansion-panel-title__icon {
	margin-inline-start: 0;
	width: 40px;
}

.list-item-accordion>.v-expansion-panel-text__wrapper {
	padding: 0;
}

.non-expansion-list-item {
	height: 51px
}
</style>
