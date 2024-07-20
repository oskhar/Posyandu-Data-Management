<script setup>
import { getSwalErrorMessage } from "@/utils/get-error-message";
import Swal from "sweetalert2";
import { onMounted, ref, watch } from "vue";
import { getTags } from "../api/si-kambing-pages-api";

const emit = defineEmits(["change"]);

const menu = ref(false);

const selectedTags = ref([]);
const tags = ref();


const handleTagsChange = newTags => {
	produkStore.selectedTags = newTags;
	emit("change", newTags);
};

onMounted(async () => {
	try {
		tags.value = await getTags()
	} catch (error) {
		await Swal.fire({
			icon: "error",
			title: "Gagal mengambil data tag produk!",
			html: getSwalErrorMessage(error, "Gagal mengambil data tag produk!"),
		});
	}
})
watch(selectedTags, handleTagsChange);
</script>

<template>
	<div class="text-center">
		<VMenu v-model="menu" :close-on-content-click="false" location="bottom end">
			<template #activator="{ props }">
				<VBtn icon="bx-filter-alt" variant="outlined" color="secondary" v-bind="props">
				</VBtn>
			</template>

			<VCard min-width="300" max-width="500" class="mt-2">
				<VCardItem>
					<VCardTitle class="text-subtitle-1 font-weight-medium">Pilih Tag Produk</VCardTitle>
				</VCardItem>
				<VCardText>
					<VCombobox v-model="selectedTags" class="overflow-auto" chips multiple :items="tags"
						@change="handleTagsChange">
					</VCombobox>
				</VCardText>
			</VCard>
		</VMenu>
	</div>
</template>
