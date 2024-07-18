<template>
    <VRow>
        <VCol cols="12" md="12">
            <!-- 👉 Horizontal Form -->
            <VCard title="Buat Edukasi">
                <VCardText>
                    <VForm @submit="submitData">
                        <VRow>
                            <VCol cols="12">
                                <VRow no-gutters>
                                    <!-- 👉 Email -->
                                    <VCol cols="12" md="3">
                                        <label for="nama_lengkap">Nama Lengkap</label>
                                    </VCol>

                                    <VCol cols="12" md="9">
                                        <VTextField id="nama_lengkap" v-model="nama_lengkap"
                                            placeholder="Masukkan Isi Nama Lengkap" persistent-placeholder />
                                    </VCol>
                                </VRow>
                            </VCol>

                            <VCol cols="12">
                                <VRow no-gutters>
                                    <!-- 👉 First Name -->
                                    <VCol cols="12" md="3">
                                        <label for="email_admin">Email</label>
                                    </VCol>

                                    <VCol cols="12" md="9">
                                        <VTextField id="email_admin" v-model="email_admin" placeholder="Masukkan Email"
                                            persistent-placeholder />
                                    </VCol>
                                </VRow>
                            </VCol>

                            <VCol cols="12">
                                <VRow no-gutters>
                                    <!-- 👉 First Name -->
                                    <VCol cols="12" md="3">
                                        <label for="password">Password</label>
                                    </VCol>

                                    <VCol cols="12" md="9">
                                        <VTextField v-model="password" :type="isPasswordVisible ? 'text' : 'password'"
                                            :append-inner-icon="isPasswordVisible ? 'bx-hide' : 'bx-show'"
                                            label="Password Baru" placeholder="············"
                                            @click:append-inner="isPasswordVisible = !isPasswordVisible" />
                                    </VCol>
                                </VRow>
                            </VCol>

                            <VCol cols="12">
                                <VRow no-gutters>
                                    <!-- 👉 First Name -->
                                    <VCol cols="12" md="3">
                                        <label for="id_jabatan">Jabatan</label>
                                    </VCol>

                                    <VCol cols="12" md="9">
                                        <VSelect id="id_jabatan" v-model="id_jabatan" :items="listJabatan"
                                            placeholder="Masukkan Jabatan" persistent-placeholder />
                                    </VCol>
                                </VRow>
                            </VCol>

                            <!-- 👉 submit and reset button -->
                            <VCol offset-md="3" cols="12" md="9" class="d-flex gap-4">
                                <VBtn type="submit" :disabled="isLoading">
                                    <VProgressCircular v-if="isLoading" indeterminate color="white">
                                    </VProgressCircular>

                                    <span v-else>Simpan</span>
                                </VBtn>
                            </VCol>
                        </VRow>
                    </VForm>
                </VCardText>
            </VCard>
        </VCol>
    </VRow>
</template>

<script>
import axios from "axios";
import config from "@/@core/config";
import Swal from "sweetalert2";

export default {
    data() {
        return {
            isLoading: false,
            id_jabatan: null,
            email_admin: "",
            nama_lengkap: "",
            listJabatan: [],
            password: "",
            isPasswordVisible: true,
        }
    },
    mounted() {
        this.getListJabatan();
    },
    methods: {
        async getListJabatan() {
            const response = await axios.get(
                `${config.urlServer}/api/jabatan`,
            );

            this.listJabatan = response.data;
        },
        async submitData(formData) {
            try {
                formData.preventDefault();
                this.isLoading = true;

                const data = new FormData();

                data.append("id_jabatan", this.id_jabatan);
                data.append("email_admin", this.email_admin);
                data.append("nama_lengkap", this.nama_lengkap);
                data.append("password", this.password);

                const response = await axios.post(
                    `${config.urlServer}/api/admin`,
                    data,
                    {
                        headers: {
                            Authorization: localStorage.getItem("tokenAuth"),
                        },
                    },
                );

                if (response.data.success) {
                    await Swal.fire({
                        toast: true,
                        position: "top",
                        iconColor: "white",
                        color: "white",
                        background: "rgb(var(--v-theme-success))",
                        showConfirmButton: false,
                        timerProgressBar: true,
                        timer: 1500,
                        icon: "success",
                        title: response.data.success.message,
                    });
                }

                window.location.href = "/admin/data/admin";
            } catch (get) {
                const errorMessage = Object.values(get.response.data.errors).join(" - ");

                await Swal.fire({
                    toast: true,
                    position: "top",
                    iconColor: "white",
                    color: "white",
                    background: "rgb(var(--v-theme-error))",
                    showConfirmButton: false,
                    timerProgressBar: true,
                    timer: 1500,
                    icon: "error",
                    title: errorMessage,
                });
            }
            this.isLoading = false;
        },
    },
};
</script>