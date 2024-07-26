<script setup lang="ts">
const { visi, misi } = defineProps({
	visi: { type: String, required: true },
	misi: { type: String, required: true },
});
</script>

<template>
	<VRow tag="section" class="px-5">
		<VCol cols="12" md="9" class="mx-auto">
			<VRow>
				<VCol cols="12">
					<div class="text-center">
						<h2 class="text-h5 font-weight-bold text-primary">
							Visi Kami
						</h2>

						<p class="mx-auto" style="max-width: 600px">
							{{ visi }}
						</p>
					</div>
				</VCol>
			</VRow>
		</Vcol>
	</VRow>
</template>