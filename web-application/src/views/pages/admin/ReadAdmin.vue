<template>
    <VRow>

        <VCol cols="12">
            <VCard>
                <!-- <VCardText> </VCardText> -->
                <VCardItem>
                    <div class="d-flex justify-end">
                        <VTextField v-model="dataSearch" append-inner-icon="bx-search">
                        </VTextField>
                        <VBtn class="ml-4" href="/data/format-1-create" prepend-icon="bx-plus">
                            Tambah
                        </VBtn>
                        <VBtn class="ml-4" @click="exportExcel" prepend-icon="bx-download">
                            Download
                        </VBtn>
                    </div>
                    <VTable>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Bayi</th>
                                <th>Tanggal Lahir</th>
                                <th>Nama Ayah</th>
                                <th>Nama Ibu</th>
                                <th style="width: 220px">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            <VProgressCircular v-if="isLoading" indeterminate color="primary" class="mt-5 float-center"
                                size="50">
                            </VProgressCircular>

                            <tr v-else v-for="(item, index) in dataAdmin" :key="item.dessert">
                                <td>
                                    {{ (page - 1) * 20 + (index + 1) }}
                                </td>
                                <td>
                                    {{ item.nama_bayi }}
                                </td>
                                <td>
                                    {{ item.tanggal_lahir_format }}
                                </td>
                                <td class="text-center">
                                    {{ item.nama_ayah }}
                                </td>
                                <td class="text-center">
                                    {{ item.nama_ibu }}
                                </td>
                                <td class="text-center">
                                    <v-dialog v-model="dialog[item.id_format_a]" persistent width="1024">
                                        <template v-slot:activator="{ props }">
                                            <v-btn color="primary" class="ml-2" v-bind="props">
                                                <v-icon>bx-edit</v-icon>
                                            </v-btn>
                                        </template>
                                        <v-card>
                                            <v-card-title>
                                                <span class="text-h5">Ubah Data</span>
                                            </v-card-title>
                                            <v-card-text>
                                                <v-container>
                                                    <v-row>
                                                        <VCol cols="12">
                                                            <VRow no-gutters>
                                                                <!-- 👉 First Name -->
                                                                <VCol cols="12" md="3">
                                                                    <label for="ayah">Nama Ayah</label>
                                                                </VCol>

                                                                <VCol cols="12" md="9">
                                                                    <VTextField id="ayah" v-model="item.nama_ayah"
                                                                        placeholder="Masukkan Nama Ayah"
                                                                        persistent-placeholder />
                                                                    <sup class="text-error">*Wajib diisi</sup>
                                                                </VCol>
                                                            </VRow>
                                                        </VCol>
                                                        <VCol cols="12">
                                                            <VRow no-gutters>
                                                                <!-- 👉 First Name -->
                                                                <VCol cols="12" md="3">
                                                                    <label for="ibu">Nama Ibu</label>
                                                                </VCol>

                                                                <VCol cols="12" md="9">
                                                                    <VTextField v-model="item.nama_ibu" id="ibu"
                                                                        placeholder="Masukkan Nama Ibu"
                                                                        persistent-placeholder />
                                                                    <sup class="text-error">*Wajib diisi</sup>
                                                                </VCol>
                                                            </VRow>
                                                        </VCol>
                                                        <VCol cols="12">
                                                            <VRow no-gutters>
                                                                <!-- 👉 First Name -->
                                                                <VCol cols="12" md="3">
                                                                    <label for="bayi">Nama Bayi</label>
                                                                </VCol>

                                                                <VCol cols="12" md="9">
                                                                    <VTextField v-model="item.nama_bayi" id="bayi"
                                                                        placeholder="Masukkan Nama Bayi"
                                                                        persistent-placeholder />
                                                                    <sup class="text-error">*Wajib diisi</sup>
                                                                </VCol>
                                                            </VRow>
                                                        </VCol>
                                                        <VCol cols="12">
                                                            <VRow no-gutters>
                                                                <!-- 👉 First Name -->
                                                                <VCol cols="12" md="3">
                                                                    <label for="kelamin">Jenis Kelamin</label>
                                                                </VCol>

                                                                <VCol cols="12" md="9">
                                                                    <VSelect v-model="item.jenis_kelamin"
                                                                        :items="['L', 'P']" />
                                                                    <sup class="text-error">*Wajib diisi</sup>
                                                                </VCol>
                                                            </VRow>
                                                        </VCol>
                                                        <VCol cols="12">
                                                            <VRow no-gutters>
                                                                <!-- 👉 First Name -->
                                                                <VCol cols="12" md="3">
                                                                    <label for="tanggal-lahir">Tanggal Lahir</label>
                                                                </VCol>

                                                                <VCol cols="12" md="9">
                                                                    <VTextField placeholder="" type="date"
                                                                        v-model="item.tanggal_lahir" />
                                                                    <sup class="text-error">*Wajib diisi</sup>
                                                                </VCol>
                                                            </VRow>
                                                        </VCol>
                                                        <VCol cols="12">
                                                            <VRow no-gutters>
                                                                <!-- 👉 First Name -->
                                                                <VCol cols="12" md="3">
                                                                    <label for="tanggal-meninggal-bayi">Tanggal Meninggal
                                                                        Bayi</label>
                                                                </VCol>

                                                                <VCol cols="12" md="9">
                                                                    <VTextField placeholder="" type="date"
                                                                        v-model="item.tanggal_meninggal_bayi" />
                                                                </VCol>
                                                            </VRow>
                                                        </VCol>
                                                        <VCol cols="12">
                                                            <VRow no-gutters>
                                                                <!-- 👉 First Name -->
                                                                <VCol cols="12" md="3">
                                                                    <label for="tanggal-meninggal-ibu">Tanggal Meninggal
                                                                        Ibu</label>
                                                                </VCol>

                                                                <VCol cols="12" md="9">
                                                                    <VTextField placeholder="" type="date"
                                                                        v-model="item.tanggal_meninggal_ibu" />
                                                                </VCol>
                                                            </VRow>
                                                        </VCol>
                                                        <VCol cols="12">
                                                            <VRow no-gutters>
                                                                <!-- 👉 First Name -->
                                                                <VCol cols="12" md="3">
                                                                    <label>Memiliki KIA</label>
                                                                </VCol>

                                                                <VCol cols="12" md="9">
                                                                    <VTextField v-model="item.memiliki_kia"
                                                                        placeholder="Masukkan KIA" persistent-placeholder />
                                                                </VCol>
                                                            </VRow>
                                                        </VCol>
                                                        <VCol cols="12">
                                                            <VRow no-gutters>
                                                                <!-- 👉 First Name -->
                                                                <VCol cols="12" md="3">
                                                                    <label>Memiliki KMS</label>
                                                                </VCol>

                                                                <VCol cols="12" md="9">
                                                                    <VTextField v-model="item.memiliki_kms"
                                                                        placeholder="Masukkan KMS" persistent-placeholder />
                                                                </VCol>
                                                            </VRow>
                                                        </VCol>
                                                        <VCol cols="12">
                                                            <VRow no-gutters>
                                                                <!-- 👉 First Name -->
                                                                <VCol cols="12" md="3">
                                                                    <label>RT/RW</label>
                                                                </VCol>

                                                                <VCol cols="12" md="9">
                                                                    <VTextField v-model="item.rt_rw"
                                                                        placeholder="Masukkan RT/RW"
                                                                        persistent-placeholder />
                                                                </VCol>
                                                            </VRow>
                                                        </VCol>
                                                        <VCol cols="12">
                                                            <VRow no-gutters>
                                                                <!-- 👉 First Name -->
                                                                <VCol cols="12" md="3">
                                                                    <label>Keterangan</label>
                                                                </VCol>

                                                                <VCol cols="12" md="9">
                                                                    <VTextField v-model="item.keterangan"
                                                                        placeholder="Masukkan Keterangan"
                                                                        persistent-placeholder />
                                                                </VCol>
                                                            </VRow>
                                                        </VCol>
                                                    </v-row>
                                                </v-container>
                                            </v-card-text>
                                            <v-card-actions>
                                                <v-spacer></v-spacer>
                                                <v-btn color="blue-darken-1" variant="text"
                                                    @click="dialog[item.id_format_a] = false">
                                                    Close
                                                </v-btn>
                                                <v-btn color="blue-darken-1" variant="text" @click="
                                                    putData(index);
                                                dialog[item.id_format_a] = false;
                                                ">
                                                    Save
                                                </v-btn>
                                            </v-card-actions>
                                        </v-card>
                                    </v-dialog>
                                    <!-- <VBtn> </VBtn> -->
                                    <VBtn class="ml-2" color="error" @click="deleteData(item.id_format_a)">
                                        <v-icon>bx-delete</v-icon>
                                    </VBtn>
                                </td>
                            </tr>
                        </tbody>
                    </VTable>
                </VCardItem>
            </VCard>
        </VCol>
    </VRow>
</template>
<script>
import axios from 'axios';
import config from "@/@core/config.vue";

export default {
    data() {
        return {
            dialog: [],
            data: [],
        }
    },
    methods: {
        async fetchData() {
            const response = await axios.get(`${config.urlServer}/api/admin`);
        }
    }
}
</script>