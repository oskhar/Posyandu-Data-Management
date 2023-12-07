<template>
  <VRow>
    <VCol cols="12">
      <VCard title="Format 1">
        <!-- <VCardText> </VCardText> -->
        <VCardItem>
          <div class="d-flex justify-end">
            <VBtn class="ml-4" href="/data/format-1-create"> Tambah </VBtn>
            <VBtn class="ml-4"> Export </VBtn>
            <VBtn class="ml-4" to="/"> Import </VBtn>
          </div>
          <VTable>
            <thead>
              <tr>
                <th class="text-uppercase">Nama Anak</th>
                <th>Nama Ayah</th>
                <th>Nama Ibu</th>
                <th style="width: 220px">Aksi</th>
              </tr>
            </thead>

            <tbody>
              <tr v-for="item in dataFormatA" :key="item.dessert">
                <td>
                  {{ item.nama_bayi }}
                </td>
                <td class="text-center">
                  {{ item.nama_ayah }}
                </td>
                <td class="text-center">
                  {{ item.nama_ibu }}
                </td>
                <td class="text-center">
                  <VBtn> <v-icon>mdi-edit</v-icon></VBtn>
                  <VBtn class="ml-2" color="error">
                    <v-icon>mdi-delete</v-icon></VBtn
                  >
                </td>

                <!-- <td class="text-center">
                {{ item.carbs }}
              </td>
              <td class="text-center">
                {{ item.protein }}
              </td> -->
              </tr>
            </tbody>
          </VTable>
        </VCardItem>
      </VCard>
    </VCol>
  </VRow>
  <VRow>
    <VCol>
      <div class="text-center my-3 float-right">
        <v-pagination
          v-model="page"
          :length="banyakPage"
          :total-visible="4"
        ></v-pagination>
      </div>
    </VCol>
  </VRow>
</template>

<script>
//import EditEdukasi from "./EditEdukasi.vue";
import axios from "axios";
import config from "@/@core/config.vue";
import { ref } from "vue";
import Swal from "sweetalert2";

export default {
  data() {
    return {
      dialog: ref([]),
      urlServer: config.urlServer,
      refInput: ref(),
      page: 1,
      banyakPage: 5,
      dataFormatA: [],
    };
  },

  methods: {
    async fetchData() {
      const response = await axios.get(
        `${config.urlServer}/api/format-a?length=20&start=${this.page}`,
        {
          headers: {
            Authorization: localStorage.getItem("tokenAuth"),
          },
        }
      );
      this.dataFormatA = response.data.format_a;
      this.banyakPage = Math.ceil(response.data.jumlah_data / 20);
    },
  },
  mounted() {
    this.fetchData();
  },
};
</script>
