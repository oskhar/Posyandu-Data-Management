<script setup lang="ts">
import { api } from '@/lib/api';
import { getSwalErrorMessage } from '@/utils/get-error-message';
import debounce from 'just-debounce';
import Swal from 'sweetalert2';
import { ref, watch, onMounted } from 'vue';

const { tab } = defineProps({
  tab: { type: String, required: true },
});

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
const isInitialLoading = ref(true);
const isLoading = ref(false);

const fetchData = async () => {
  try {
    isLoading.value = true;

    const response = await api.get(
      `/format-ba/unique`,
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
  } finally {
    isInitialLoading.value = false;
  }

};

const debouncedFetchData = debounce(fetchData, 500);

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
        <VSkeletonLoader v-if="isLoading && isInitialLoading" type="heading, subtitle" />
        <VCardItem v-else>
          <h2>{{ judulFormatBA }}</h2>
          <h3 class="text-secondary mt-5">{{ namaPosyandu }} - {{ kota }}</h3>
        </VCardItem>
        <VCardItem>
          <VSkeletonLoader v-if="isLoading && isInitialLoading" type="heading" />
          <VSelect v-else v-model="tahun" :items="listTahunLahir" />
        </VCardItem>
      </VCard>
    </VCol>

    <VCol cols="12">
      <VCard>
        <VCardItem>
          <VTextField v-model="dataSearch" label="Cari Data Screening Balita" prepend-inner-icon="bx-search"
            class="mt-2">
          </VTextField>

          <VSkeletonLoader v-if="isLoading" type="table" />
          <VTable class="mt-4">
            <thead>
              <tr>
                <th>No</th>
                <th>Nama Anak</th>
                <th>Umur</th>
                <th>N/T/O/B & BGM</th>
                <th style="width: 220px">Detail</th>
              </tr>
            </thead>

            <tbody>
              <tr v-if='dataFormatBA.length === 0'>
                <td cols="12">Belum ada data</td>
              </tr>
              <tr v-for="(item, index) in dataFormatBA" :key="item.dessert">
                <td>
                  {{ (page - 1) * 20 + (index + 1) }}
                </td>
                <td>
                  {{ item.nama_bayi }}
                </td>
                <td class="text-center">{{ item.umur }} Bulan</td>
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
    <span>Jumlah data: <span class="text-primary">{{ jumlahData || 0 }}</span>
    </span>
    <VPagination v-model="page" size="x-large" :length="banyakPage" :total-visible="6" @click="fetchData">
    </VPagination>
  </div>
</template>
