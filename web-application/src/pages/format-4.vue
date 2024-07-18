<template>
    <VRow>
        <VCol cols="12">
            <VCard>
                <VProgressCircular v-if="isLoadingHeader" indeterminate color="primary" class="mt-5 float-center"
                    size="50">
                </VProgressCircular>
                <VCardItem v-else style="min-height: 170px">
                    <h2>{{ judulFormatC }}</h2>
                    <h3 class="text-secondary mt-5">{{ namaPosyandu }} - {{ kota }}</h3>
                </VCardItem>
            </VCard>
        </VCol>

        <VCol cols="12">
            <VCard>
                <!-- <VCardText> </VCardText> -->
                <VCardItem>
                    <VRow>
                        <VCol cols="12">
                            <VTextField v-model="dataSearch" append-inner-icon="bx-search">
                            </VTextField>
                        </VCol>
                        <VCol cols="12">
                            <VBtn class="mb-3" href="/admin/data/format-4-create" prepend-icon="bx-plus">
                                Tambah
                            </VBtn>
                            <!--
                              <VBtn class="ml-4 mb-3" @click="exportExcel" prepend-icon="bx-download">
                              Download
                              </VBtn> 
                            -->
                        </VCol>
                    </VRow>
                    <VTable>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Wus & Pus</th>
                                <th>Umur</th>
                                <th>Nama Suami</th>
                                <th>Tahapan KS</th>
                                <th style="width: 220px">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            <VProgressCircular v-if="isLoadingTable" indeterminate color="primary"
                                class="mt-5 float-center" size="50">
                            </VProgressCircular>

                            <tr v-for="(item, index) in dataFormatD" v-else :key="item.dessert">
                                <td>
                                    {{ (page - 1) * 20 + (index + 1) }}
                                </td>
                                <td>
                                    {{ item.nama_ibu }}
                                </td>
                                <td class="text-center">{{ item.umur }} Bulan</td>
                                <td class="text-center">
                                    {{ item.umur }}
                                </td>
                                <td class="text-center">
                                    {{ item.kelompok_dasawisma }}
                                </td>
                                <td class="text-center">
                                    <VDialog v-model="dialog[index]" persistent width="1024">
                                        <template #activator="{ props }">
                                            <VBtn color="primary" class="ml-2" v-bind="props">
                                                <VIcon>bx-edit</VIcon>
                                            </VBtn>
                                        </template>
                                        <VCard>
                                            <VCardTitle>
                                                <span class="text-h5">Ubah Data</span>
                                            </VCardTitle>
                                            <VCardItem>
                                                <VRow>
                                                    <VCol cols="12">
                                                        <h2>Data orang tua</h2>
                                                        <VRow class="mb-5">
                                                            <VCol cols="12" md="4" lg="4">
                                                                <VRadioGroup v-model="data_tersedia">
                                                                    <VRadio label="Ubah data" :value="true"></VRadio>
                                                                </VRadioGroup>
                                                            </VCol>
                                                            <VCol cols="12" md="4" lg="4">
                                                                <VRadioGroup v-model="data_tersedia">
                                                                    <VRadio label="Pilih data lain" :value="false">
                                                                    </VRadio>
                                                                </VRadioGroup>
                                                            </VCol>
                                                        </VRow>
                                                        <VRow v-if="data_tersedia">
                                                            <VCol cols="12">
                                                                <VRow no-gutters>
                                                                    <!-- 👉 First Name -->
                                                                    <VCol cols="12" md="3">
                                                                        <label for="ayah">Nama Ayah</label>
                                                                    </VCol>

                                                                    <VCol cols="12" md="9">
                                                                        <VTextField id="ayah"
                                                                            v-model="dataFormatD[index].nama_ayah"
                                                                            placeholder="Masukkan Nama Ayah..."
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
                                                                        <VTextField id="ibu"
                                                                            v-model="dataFormatD[index].nama_ibu"
                                                                            placeholder="Masukkan Nama Ibu..."
                                                                            persistent-placeholder />
                                                                        <sup class="text-error">*Wajib diisi</sup>
                                                                    </VCol>
                                                                </VRow>
                                                            </VCol>
                                                            <VCol cols="12">
                                                                <VRow no-gutters>
                                                                    <!-- 👉 First Name -->
                                                                    <VCol cols="12" md="3">
                                                                        <label for="nik_ibu">NIK Ayah</label>
                                                                    </VCol>

                                                                    <VCol cols="12" md="9">
                                                                        <VTextField id="nik_ayah"
                                                                            v-model="dataFormatD[index].nik_ayah"
                                                                            placeholder="Masukkan NIK Ayah..."
                                                                            persistent-placeholder />
                                                                    </VCol>
                                                                </VRow>
                                                            </VCol>
                                                            <VCol cols="12">
                                                                <VRow no-gutters>
                                                                    <!-- 👉 First Name -->
                                                                    <VCol cols="12" md="3">
                                                                        <label for="nik_ibu">NIK Ibu</label>
                                                                    </VCol>

                                                                    <VCol cols="12" md="9">
                                                                        <VTextField id="nik_ibu"
                                                                            v-model="dataFormatD[index].nik_ibu"
                                                                            placeholder="Masukkan NIK Ibu..."
                                                                            persistent-placeholder />
                                                                    </VCol>
                                                                </VRow>
                                                            </VCol>
                                                            <VCol cols="12">
                                                                <VRow no-gutters>
                                                                    <!-- 👉 First Name -->
                                                                    <VCol cols="12" md="3">
                                                                        <label for="tanggal-meninggal-ibu">Tanggal
                                                                            Meninggal
                                                                            Ibu</label>
                                                                    </VCol>

                                                                    <VCol cols="12" md="9">
                                                                        <VTextField
                                                                            v-model="dataFormatD[index].tanggal_meninggal_ibu"
                                                                            placeholder="" type="date" />
                                                                    </VCol>
                                                                </VRow>
                                                            </VCol>
                                                            <VCol cols="12">
                                                                <VRow no-gutters>
                                                                    <!-- 👉 First Name -->
                                                                    <VCol cols="12" md="3">
                                                                        <label>Nomor yang bisa dihubungi</label>
                                                                    </VCol>

                                                                    <VCol cols="12" md="9">
                                                                        <VTextField v-model="dataFormatD[index].no_telp"
                                                                            placeholder="08xx" persistent-placeholder />
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
                                                                        <VTextField v-model="dataFormatD[index].rt_rw"
                                                                            placeholder="Masukkan RT/RW..."
                                                                            persistent-placeholder />
                                                                    </VCol>
                                                                </VRow>
                                                            </VCol>
                                                            <VCol cols="12">
                                                                <VRow no-gutters>
                                                                    <!-- 👉 First Name -->
                                                                    <VCol cols="12" md="3">
                                                                        <label for="ibu">Tempat Tinggal</label>
                                                                    </VCol>

                                                                    <VCol cols="12" md="9">
                                                                        <VTextarea
                                                                            v-model="dataFormatD[index].tempat_tinggal"
                                                                            placeholder="Alamat tempat tinggal..." />
                                                                    </VCol>
                                                                </VRow>
                                                            </VCol>
                                                        </VRow>
                                                        <VRow v-else>
                                                            <VCol cols="12">
                                                                <VAutocomplete v-model="ganti_id_ortu"
                                                                    label="Nama orang tua...." :items="listOrangTua">
                                                                </VAutocomplete>
                                                            </VCol>
                                                        </VRow>
                                                        <VRow>
                                                            <VCol cols="12">
                                                                <h2>Data ibu hamil</h2>
                                                                <VRow no-gutters>
                                                                    <!-- 👉 First Name -->
                                                                    <VCol cols="12" md="3">
                                                                        <label for="umur">Umur Ibu hamil</label>
                                                                    </VCol>

                                                                    <VCol cols="12" md="9">
                                                                        <VTextField id="umur"
                                                                            v-model="dataFormatD[index].umur"
                                                                            placeholder="tahun.." persistent-placeholder
                                                                            type="number" />
                                                                    </VCol>
                                                                </VRow>
                                                            </VCol>
                                                            <VCol cols="12">
                                                                <VRow no-gutters>
                                                                    <!-- 👉 First Name -->
                                                                    <VCol cols="12" md="3">
                                                                        <label for="dasawisma">Kelompok
                                                                            Dasawisma</label>
                                                                    </VCol>

                                                                    <VCol cols="12" md="9">
                                                                        <VTextField id="dasawisma"
                                                                            v-model="dataFormatD[index].kelompok_dasawisma"
                                                                            placeholder="Kelompok dasawisma.."
                                                                            persistent-placeholder />
                                                                    </VCol>
                                                                </VRow>
                                                            </VCol>
                                                            <VCol cols="12">
                                                                <VRow no-gutters>
                                                                    <!-- 👉 First Name -->
                                                                    <VCol cols="12" md="3">
                                                                        <label for="penggantian">Tanggal
                                                                            Pendaftaran</label>
                                                                    </VCol>

                                                                    <VCol cols="12" md="9">
                                                                        <VTextField id="penggantian"
                                                                            v-model="dataFormatD[index].tanggal_pendaftaran"
                                                                            placeholder="Tanggal Pendaftaran.."
                                                                            persistent-placeholder type="date" />
                                                                    </VCol>
                                                                </VRow>
                                                            </VCol>
                                                            <VCol cols="12">
                                                                <VRow no-gutters>
                                                                    <!-- 👉 First Name -->
                                                                    <VCol cols="12" md="3">
                                                                        <label for="umur_kehamilan">Umur
                                                                            kehamilan</label>
                                                                    </VCol>

                                                                    <VCol cols="12" md="9">
                                                                        <VTextField id="umur_kehamilan"
                                                                            v-model="dataFormatD[index].umur_kehamilan"
                                                                            placeholder="bulan.." persistent-placeholder
                                                                            type="number" />
                                                                    </VCol>
                                                                </VRow>
                                                            </VCol>
                                                            <VCol cols="12">
                                                                <VRow no-gutters>
                                                                    <!-- 👉 First Name -->
                                                                    <VCol cols="12" md="3">
                                                                        <label for="tanggal-lahir">Hamil ke</label>
                                                                    </VCol>

                                                                    <VCol cols="12" md="9">
                                                                        <VTextField id="lila"
                                                                            v-model="dataFormatD[index].hamil_ke"
                                                                            placeholder="Hamil ke berapa.."
                                                                            persistent-placeholder type="number" />
                                                                    </VCol>
                                                                </VRow>
                                                            </VCol>
                                                            <VCol cols="12">
                                                                <VRow no-gutters>
                                                                    <!-- 👉 First Name -->
                                                                    <VCol cols="12" md="3">
                                                                        <label for="lila">Ukuran LILA</label>
                                                                    </VCol>

                                                                    <VCol cols="12" md="9">
                                                                        <VTextField id="lila"
                                                                            v-model="dataFormatD[index].lila"
                                                                            placeholder="cm.." persistent-placeholder
                                                                            type="number" />
                                                                    </VCol>
                                                                </VRow>
                                                            </VCol>
                                                            <VCol cols="12">
                                                                <VRow no-gutters>
                                                                    <!-- 👉 First Name -->
                                                                    <VCol cols="12" md="3">
                                                                        <label for="pmt_pemulihan">PMT Pemulihan</label>
                                                                    </VCol>

                                                                    <VCol cols="12" md="9">
                                                                        <VTextField id="pmt_pemulihan"
                                                                            v-model="dataFormatD[index].pmt_pemulihan"
                                                                            placeholder="PMT Pemulihan.."
                                                                            persistent-placeholder />
                                                                    </VCol>
                                                                </VRow>
                                                            </VCol>
                                                            <VCol cols="12">
                                                                <VRow no-gutters>
                                                                    <!-- 👉 Pil Tambah Darah -->
                                                                    <VCol cols="12" md="3">
                                                                        <label for="penimbangan">Penimbangan</label>
                                                                    </VCol>

                                                                    <VCol cols="12" md="9">
                                                                        <VSelect id="penimbangan"
                                                                            v-model="dataFormatD[index].penimbangan"
                                                                            :items="[]" label="Penimbangan"
                                                                            placeholder="Pilih beberapa" multiple chips
                                                                            no-data-text="Masukan hasil penimbangan">
                                                                            <template #prepend-item>
                                                                                <VList>
                                                                                    <VListItemGroup>
                                                                                        <VListItem
                                                                                            v-for="( month, indexPenimbangan ) in months "
                                                                                            :key="indexPenimbangan"
                                                                                            ripple class="mb-3"
                                                                                            @mousedown.prevent>
                                                                                            {{ month }}
                                                                                            <VTextField id="penimbangan"
                                                                                                v-model="dataFormatD[index].penimbangan[indexPenimbangan]"
                                                                                                placeholder="kg.."
                                                                                                persistent-placeholder
                                                                                                type="number" />
                                                                                        </VListItem>
                                                                                    </VListItemGroup>
                                                                                </VList>
                                                                            </template>
                                                                        </VSelect>
                                                                    </VCol>
                                                                </VRow>
                                                            </VCol>
                                                            <VCol cols="12">
                                                                <VRow no-gutters>
                                                                    <!-- 👉 First Name -->
                                                                    <VCol cols="12" md="3">
                                                                        <label for="pil_tambah_darah">Pil Tambah
                                                                            Darah</label>
                                                                    </VCol>

                                                                    <VCol cols="12" md="9">
                                                                        <VSelect
                                                                            v-model="dataFormatD[index].pil_tambah_darah"
                                                                            :items="itemPilTambahDarah"
                                                                            label="pil tambah darah"
                                                                            placeholder="Pilih beberapa" multiple chips>
                                                                            <template #prepend-item>
                                                                                <VListItem ripple @mousedown.prevent
                                                                                    @click="toggleHasil(index)">
                                                                                    <VListItemAction>
                                                                                        <VIcon
                                                                                            :color="dataFormatD[index].pil_tambah_darah.length === itemPilTambahDarah.length ? 'primary' : 'secondary'">
                                                                                            {{ iconHasil(index) }}
                                                                                        </VIcon>
                                                                                        <Font class="ml-2"> Pilih Semua
                                                                                        </Font>
                                                                                    </VListItemAction>
                                                                                </VListItem>
                                                                                <VDivider class="mt-2"></VDivider>
                                                                            </template>
                                                                        </VSelect>
                                                                    </VCol>
                                                                </VRow>
                                                            </VCol>
                                                            <VCol cols="12">
                                                                <VRow no-gutters>
                                                                    <!-- 👉 Pil Tambah Darah -->
                                                                    <VCol cols="12" md="3">
                                                                        <label for="imunisasi">Imunisasi</label>
                                                                    </VCol>

                                                                    <VCol cols="12" md="9">
                                                                        <VSelect id="imunisasi"
                                                                            v-model="dataFormatD[index].imunisasi"
                                                                            :items="[]" label="Penimbangan"
                                                                            placeholder="Pilih beberapa" multiple chips
                                                                            no-data-text="Masukan hasil imunisasi">
                                                                            <template #prepend-item>
                                                                                <VList>
                                                                                    <VListItemGroup>
                                                                                        <VListItem
                                                                                            v-for="( month, indexImunisasi ) in listImunisasi "
                                                                                            :key="indexImunisasi" ripple
                                                                                            class="mb-3"
                                                                                            @mousedown.prevent>
                                                                                            Imunisasi {{ month }}
                                                                                            <VTextField id="imunisasi"
                                                                                                v-model="dataFormatD[index].imunisasi[indexImunisasi]"
                                                                                                placeholder="kg.."
                                                                                                persistent-placeholder
                                                                                                type="date" />
                                                                                        </VListItem>
                                                                                    </VListItemGroup>
                                                                                </VList>
                                                                            </template>
                                                                        </VSelect>
                                                                    </VCol>
                                                                </VRow>
                                                            </VCol>
                                                            <VCol cols="12">
                                                                <VRow no-gutters>
                                                                    <!-- 👉 First Name -->
                                                                    <VCol cols="12" md="3">
                                                                        <label for="vit_a">Vitamin A Bufas</label>
                                                                    </VCol>

                                                                    <VCol cols="12" md="9">
                                                                        <VCheckbox id="vit_a"
                                                                            v-model="dataFormatD[index].vit_a"
                                                                            label="Ya" />
                                                                    </VCol>
                                                                </VRow>
                                                            </VCol>
                                                            <VCol cols="12">
                                                                <VRow no-gutters>
                                                                    <!-- 👉 First Name -->
                                                                    <VCol cols="12" md="3">
                                                                        <label for="keterangan">Keterangan</label>
                                                                    </VCol>

                                                                    <VCol cols="12" md="9">
                                                                        <VTextField id="keterangan"
                                                                            v-model="dataFormatD[index].keterangan"
                                                                            placeholder="Keterangan.."
                                                                            persistent-placeholder />
                                                                    </VCol>
                                                                </VRow>
                                                            </VCol>
                                                            <!-- 👉 submit and reset button -->
                                                            <VCol offset-md="3" cols="12" md="9" class="d-flex gap-4">
                                                                <VBtn type="submit" :disabled="isLoading"
                                                                    @click="submitData">
                                                                    <VProgressCircular v-if="isLoading" indeterminate
                                                                        color="white">
                                                                    </VProgressCircular>

                                                                    <Font v-else>Simpan</Font>
                                                                </VBtn>
                                                            </VCol>
                                                        </VRow>
                                                    </VCol>
                                                </VRow>
                                            </VCardItem>
                                            <VCardActions>
                                                <VSpacer></VSpacer>
                                                <VBtn color="blue-darken-1" variant="text"
                                                    @click="dialog[index] = false">
                                                    Tutup
                                                </VBtn>
                                                <VBtn color="blue-darken-1" variant="text" @click="
                                                    putData(index);
                                                dialog[index] = false;
                                                ">
                                                    Simpan
                                                </VBtn>
                                            </VCardActions>
                                        </VCard>
                                    </VDialog>

                                    <VBtn class="ml-2" color="error" @click="deleteData(item.id_format_d)">
                                        <VIcon>bx-trash</VIcon>
                                    </VBtn>
                                </td>
                            </tr>
                        </tbody>
                    </VTable>
                </VCardItem>
            </VCard>
        </VCol>
    </VRow>
    <VRow>
        <VCol>
            <Font>Jumlah data: <Font class="text-primary">{{ jumlahData }}</Font>
            </Font>
            <VPagination v-model="page" class="float-right" :length="banyakPage" :total-visible="4" @click="fetchData">
            </VPagination>
        </VCol>
    </VRow>
</template>

<script>
//import EditEdukasi from "./EditEdukasi.vue";
import axios from "axios";
import AnalyticsBarCharts from "@/views/dashboard/AnalyticsBarCharts.vue";
import config from "@/@core/config";
import VueApexCharts from "vue3-apexcharts";
import Swal from "sweetalert2";

export default {
    components: {
        AnalyticsBarCharts,
        VueApexCharts,
    },
    data() {
        const d = new Date();

        return {
            dialog: [],
            months: [
                'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember',
            ],
            listImunisasi: [
                'I', 'II', 'III', 'IV', 'V',
            ],
            itemPilTambahDarah: [
                'BKS I',
                'BKS II',
                'BKS III',
            ],
            data_tersedia: true,
            ganti_id_ortu: null,
            dataSearch: "",
            listOrangTua: [],
            urlServer: config.urlServer,
            page: 1,
            banyakPage: 5,
            dataFormatD: [],
            judulFormatC: "",
            namaPosyandu: "",
            kota: "",
            jumlahData: 0,
            jumlahLahiran: "",
            jumlahMeninggal: "",
            tahun: d.getFullYear(),
            listTahunLahir: [d.getFullYear()],
            isLoadingTable: false,
            isLoadingHeader: false,
            chartOptions: {},
        };
    },

    watch: {
        // Properti tahun akan dipantau
        tahun: function () {
            // Ketika tahun berubah, panggil fungsi fetchData
            this.page = 1;
            this.fetchData();
        },
        dataSearch: function () {
            this.fetchData();
        },
        bulan: function () {
            // Ketika tahun berubah, panggil fungsi fetchData
            this.page = 1;
            this.fetchData();
        },
    },
    async mounted() {
        this.fetchListOrtu();
        this.isLoadingHeader = true;

        const response = await this.fetchData();

        this.judulFormatC = response.data.judul_format;
        this.namaPosyandu = response.data.nama_posyandu;
        this.kota = response.data.kota;

        const response2 = await axios.get(`${config.urlServer}/api/listtahun?tab=1`, {
            headers: {
                Authorization: localStorage.getItem("tokenAuth"),
            },
        });

        this.listTahunLahir = response2.data;
        this.isLoadingHeader = false;
    },
    methods: {
        pilihSemuaHasil(index) {
            return this.dataFormatD[index].pil_tambah_darah.length === this.itemPilTambahDarah.length
        },
        iconHasil(index) {
            if (this.pilihSemuaHasil(index)) return 'mdi-close-box'

            return 'mdi-checkbox-blank-outline'
        },
        toggleHasil(index) {
            this.$nextTick(() => {
                if (this.pilihSemuaHasil(index)) {
                    this.dataFormatD[index].pil_tambah_darah = []
                } else {
                    this.dataFormatD[index].pil_tambah_darah = this.itemPilTambahDarah.slice()
                }
            })
        },
        async fetchListOrtu() {

            const response = await axios.get(`${config.urlServer}/api/list-orang-tua`,
                {
                    headers: {
                        Authorization: localStorage.getItem("tokenAuth"),
                    },
                });

            this.listOrangTua = response.data;
        },
        async exportExcel() {
            const response = await axios({
                method: "get",
                url: `${this.urlServer}/api/export/format-b?tahun=${this.tahun}&tab=1`,
                responseType: "blob",
                headers: {
                    Authorization: localStorage.getItem("tokenAuth"),
                },
            });


            // Membuat objek Date yang merepresentasikan waktu saat ini
            const currentDate = new Date();

            // Mendapatkan tahun, bulan, tanggal, jam, menit, dan detik
            const year = currentDate.getFullYear();
            const month = currentDate.getMonth() + 1; // Perlu ditambah 1 karena indeks bulan dimulai dari 0
            const day = currentDate.getDate();
            const hours = currentDate.getHours();
            const minutes = currentDate.getMinutes();
            const seconds = currentDate.getSeconds();
            const currentDateTime = `_${year}-${month}-${day}_${hours}:${minutes}:${seconds}`;
            const namaFile = `Format-2_tab-1${currentDateTime}.xlsx`;

            const url = window.URL.createObjectURL(new Blob([response.data]));
            const link = document.createElement("a");

            link.href = url;
            link.setAttribute("download", namaFile);
            document.body.appendChild(link);
            link.click();
        },
        async fetchData() {
            this.isLoadingTable = true;

            const response = await axios.get(
                `${config.urlServer}/api/format-d?length=20&start=${this.page}&tahun=${this.tahun}&search=${this.dataSearch}&tab=1`,
                {
                    headers: {
                        Authorization: localStorage.getItem("tokenAuth"),
                    },
                },
            );

            this.banyakPage = Math.ceil(response.data.jumlah_data / 20);
            this.jumlahData = response.data.jumlah_data;
            this.dataFormatD = response.data.format_d;
            this.isLoadingTable = false;

            return response;
        },

        async putData(indexFormatD) {
            try {
                this.dataFormatD[indexFormatD].ganti_id_ortu = this.data_tersedia ? null : this.ganti_id_ortu;

                const response = await axios.put(
                    `${this.urlServer}/api/format-d`,
                    this.dataFormatD[indexFormatD],
                    {
                        headers: {
                            Authorization: localStorage.getItem("tokenAuth"),
                        },
                    },
                );

                if (response.data.success) {
                    Swal.fire({
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
            } catch (error) {
                console.log(error)
                Swal.fire({
                    toast: true,
                    position: "top",
                    iconColor: "white",
                    color: "white",
                    background: "rgb(var(--v-theme-error))",
                    showConfirmButton: false,
                    timerProgressBar: true,
                    timer: 4000,
                    icon: "error",
                    title: "Data Tidak Lengkap atau Salah",
                });
            }
        },

        async deleteData(id_format_d) {
            const ask = await Swal.fire({
                title: "Anda yakin ingin menghapus?",
                showConfirmButton: false,
                showDenyButton: true,
                showCancelButton: true,
                denyButtonText: "Hapus",
            });

            if (ask.isDenied) {
                const response = await axios.delete(
                    `${this.urlServer}/api/format-d?id_format_d=${id_format_d}`,
                    {
                        headers: {
                            Authorization: localStorage.getItem("tokenAuth"),
                        },
                    },
                );

                if (response.data.success) {
                    Swal.fire({
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
                    this.fetchData();
                }
            }
        },
    },
};
</script>