<script setup>
import { WA_POSYANDU } from '@/constants';
import { getErrorMessage } from '@/utils/get-error-message';
import { sendWhatsapp } from '@/utils/send-whatsapp';
import debounce from 'just-debounce';
import Swal from 'sweetalert2';
import { onMounted, ref, watch } from 'vue';
import z from "zod";

const formValidation = z.object({
	nama: z.string().trim().min(1, "Nama tidak boleh kosong"),
	pesan: z.string().trim().min(1, "Pesan tidak boleh kosong"),
});

const form = ref({ nama: "", pesan: "" });
const isFormValid = ref(false);


const revalidateForm = debounce(async () => {
	const { success } = await formValidation.safeParseAsync(form.value)

	isFormValid.value = success;
}, 500)

onMounted(revalidateForm)
watch(form, revalidateForm, { deep: true });


const handleSendKonsultasi = async () => {
	try {
		const validatedForm = await formValidation.parseAsync(form.value);
		const { nama, noTelepon, pesan } = validatedForm

		sendWhatsapp(
			WA_POSYANDU
				`Halo, saya ${nama}. Saya ingin konsultasi stunting. Pesan saya:\n ${pesan}`);
	} catch (error) {
		await Swal.fire({
			icon: "error",
			text: getErrorMessage(error, "Terjadi kesalahan saat mengirim pesan konsultasi!"),
			showCloseButton: true,
		});
	}
}
</script>

<template>
	<VRow tag="section" class="px-5 pt-8 pb-16">
		<VCol cols="12" md="9" class="mx-auto">
			<VCard>
				<VRow class="pa-8">
					<VCol cols="12" md="6">
						<h2 class="text-h5 text-lg-h4 font-weight-bold text-primary">Konsultasi Stunting</h2>
						<p class="text-subtitle-1 mt-4">
							Kami menyediakan konsultasi langsung terkait stunting, penyebabnya, dan cara
							penanganannya.
						</p>
						<p class="text-subtitle-1 mt-4">
							Dapatkan informasi akurat dan terpercaya dari para ahli kami
							untuk memastikan anak Anda tumbuh dengan sehat dan optimal. Hubungi kami
							untuk diskusi lebih lanjut dan kerja sama dalam penanganan stunting.
						</p>
					</VCol>

					<VCol cols="12" md="6" class="d-flex">
						<VForm class="d-flex flex-column gap-4 flex-grow w-100" @submit.prevent="handleSendKonsultasi">
							<VTextField v-model="form.nama" label="Nama Anda" />
							<VTextarea v-model="form.pesan" height='100%' label="Pesan Konsultasi" />

							<VBtn :disabled="!isFormValid" type="submit" class="w-100" prepend-icon="bx-paper-plane">Kirim</VBtn>
						</VForm>
					</VCol>
				</VRow>
			</VCard>
		</VCol>
	</VRow>
</template>