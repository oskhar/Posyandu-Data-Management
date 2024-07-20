<script setup lang="ts">
import { ITEM_BULAN } from '@/constants';
import { api } from '@/lib/api';
import { createDownloadFromBlob } from '@/utils/file';
import { getSwalErrorMessage } from '@/utils/get-error-message';
import debounce from 'just-debounce';
import Swal from 'sweetalert2';
import { ref, watch, onMounted } from 'vue';

const { tab } = defineProps({
  tab: { type: String, required: true },
});

// Reactive state
const dialog = ref(false);
const dataSearch = ref("");
const page = ref(1);
const banyakPage = ref(5);
const dataFormatBA = ref([]);
const judulFormatBA = ref("");
const namaPosyandu = ref("");
const kota = ref("");
const jumlahData = ref(0);
const tahun = ref(new Date().getFullYear());
const listTahunLahir = ref([new Date().getFullYear()]);
const bulan = ref(new Date().getMonth() + 1);
const isLoading = ref(false);

const fetchData = async () => {
  try {
    isLoading.value = true;

    const response = await api.get(
      `/format-ba`,
      {
        params: {
          length: 20,
          start: page.value,
          tahun: tahun.value,
          search: dataSearch.value,
          tab,
        },
      },
    );

    banyakPage.value = Math.ceil(response.data.jumlah_data / 20);
    jumlahData.value = response.data.jumlah_data;
    dataFormatBA.value = response.data.format_ba;
    isLoading.value = false;

    return response;
  } catch (error) {
    await Swal.fire({
      icon: 'error',
      title: "Gagal mengambil data screening balita",
      html: getSwalErrorMessage(error, "Gagal mengambil data screening balita!"),
    });
  }

};

const debouncedFetchData = debounce(fetchData, 500);


const exportExcel = async () => {
  try {
    const response = await api.get(
      `/export/format-b?tahun=${tahun.value}`,
      { params: { tab, tahun: tahun.value }, responseType: 'blob' },
    );

    createDownloadFromBlob(response.data, 'xlsx', `Format-2_tab-${tab}`);
  } catch (error) {
    await Swal.fire({
      icon: 'error',
      title: "Gagal download data",
      html: getSwalErrorMessage(error, "Gagal download data !"),
    });
  }
};

const exportExcelLaporan = async () => {
  try {
    const response = await api.get(
      `/export/laporan-b`,
      {
        params: { tahun: tahun.value, bulan: bulan.value },
        responseType: 'blob',
      },
    );

    // Membuat objek Date yang merepresentasikan waktu saat ini
    createDownloadFromBlob(response.data, `xlsx`, `Format-2_tab-${tab}`);
  } catch (error) {
    await Swal.fire({
      icon: 'error',
      title: "Gagal download laporan",
      html: getSwalErrorMessage(error, "Gagal download laporan !"),
    });
  }
};

onMounted(async () => {
  const response = await fetchData();

  judulFormatBA.value = response.data.judul_format;
  namaPosyandu.value = response.data.nama_posyandu;
  kota.value = response.data.kota;

  const response2 = await api.get(`/listtahun`, {
    params: { tab },
  });

  listTahunLahir.value = response2.data;
});
watch(tahun, debouncedFetchData);
watch(dataSearch, debouncedFetchData);
</script>

<template>
  <VRow>
    <VCol cols="12">
      <VCard>
        <VProgressCircular v-if="isLoading" indeterminate color="primary" class="mt-5 float-center" size="50">
        </VProgressCircular>
        <VCardItem v-else style="min-height: 170px">
          <h2>{{ judulFormatBA }}</h2>
          <h3 class="text-secondary mt-5">{{ namaPosyandu }} - {{ kota }}</h3>
        </VCardItem>
        <VCardItem>
          <VSelect v-model="tahun" :items="listTahunLahir" />
        </VCardItem>
      </VCard>
    </VCol>

    <VCol cols="12">
      <VCard>
        <VCardItem>
          <VRow>
            <VCol cols="12">
              <VTextField v-model="dataSearch" label="Cari Data Screening Balita" prepend-inner-icon="bx-search"
                class="mt-2">
              </VTextField>
            </VCol>
            <VCol cols="12">
              <VBtn class="mb-3" prepend-icon="bx-download" @click="exportExcel">
                Data
              </VBtn>

              <VDialog v-model="dialog" persistent width="1024">
                <template #activator="{ props }">
                  <VBtn color="primary" class="mb-3 ml-3" v-bind="props" prepend-icon="bx-download">
                    Laporan
                  </VBtn>
                </template>
                <VCard>
                  <VCardTitle>
                    <span class="text-h5">Laporan Bulanan</span>
                  </VCardTitle>
                  <VCardItem>
                    <VContainer>
                      <VRow>
                        <VCol cols="12">
                          <VSelect v-model="bulan" :items="ITEM_BULAN" label="Pilih bulan laporan"
                            placeholder="Pilih bulan" />
                        </VCol>
                      </VRow>
                    </VContainer>
                  </VCardItem>
                  <VCardActions>
                    <VSpacer></VSpacer>
                    <VBtn color="secondary" variant="text" @click="dialog = false">
                      Batal
                    </VBtn>
                    <VBtn color="primary" variant="text" @click="
                      exportExcelLaporan();
                    dialog = false;
                    ">
                      Download
                    </VBtn>
                  </VCardActions>
                </VCard>
              </VDialog>
            </VCol>
          </VRow>
          <VTable>
            <thead>
              <tr>
                <th>No</th>
                <th>Nama Anak</th>
                <th>Umur</th>
                <th>Bulan</th>
                <th>Kelamin</th>
                <th>Berat Badan</th>
                <th>Asi Eksklusif</th>
                <th>N/T/O/B & BGM</th>
                <th style="width: 220px">Detail</th>
              </tr>
            </thead>

            <tbody>
              <VProgressCircular v-if="isLoading" indeterminate color="primary" class="mt-5 float-center" size="50">
              </VProgressCircular>

              <tr v-for="(item, index) in dataFormatBA" v-else :key="item.dessert">
                <td>
                  {{ (page - 1) * 20 + (index + 1) }}
                </td>
                <td>
                  {{ item.nama_bayi }}
                </td>
                <td class="text-center">{{ item.umur }} Bulan</td>
                <td class="text-center">
                  {{ item.bulan }}
                </td>
                <td class="text-center">
                  {{ item.jenis_kelamin }}
                </td>
                <td class="text-center">
                  <p v-if="item.berat_badan">{{ item.berat_badan }}</p>
                  <p v-else> - </p>
                </td>
                <td class="text-center">
                  <p v-if="item.asi_eksklusif">{{ item.asi_eksklusif }}</p>
                  <p v-else> - </p>
                </td>
                <td class="text-center">
                  <p v-if="item.ntob">{{ item.ntob }}</p>
                  <p v-else> - </p>
                </td>
                <td class="text-center">
                  <VBtn color="primary" class="ml-2" :to="`/layanan/screening-balita/${item.id_bayi}`">
                    <VIcon>bx-detail</VIcon>
                  </VBtn>
                </td>
              </tr>
            </tbody>
          </VTable>
        </VCardItem>
      </VCard>
    </VCol>
  </VRow>

  <div class="d-flex justify-space-between mt-6 align-center">
    <span>Jumlah data: <span class="text-primary">{{ jumlahData }}</span>
    </span>
    <VPagination v-model="page" size="x-large" :length="banyakPage" :total-visible="6" @click="fetchData">
    </VPagination>
  </div>
</template>
