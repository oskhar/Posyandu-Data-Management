<template>
  <VRow>
    <VCol cols="12">
      <VCard title="Format 1">
        <!-- <VCardText> </VCardText> -->
        <VTable height="550" fixed-header>
          <thead>
            <tr>
              <th class="text-uppercase">Nama Anak</th>
              <th>Nama Ayah</th>
              <th>Nama Ibu</th>
            </tr>
          </thead>

          <tbody>
            <tr v-for="item in desserts" :key="item.dessert">
              <td>
                {{ item.namaAnak }}
              </td>
              <td class="text-center">
                {{ item.namaAyah }}
              </td>
              <td class="text-center">
                {{ item.namaIbu }}
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
      dataEdukasi: ref([]),
      urlServer: config.urlServer,
      refInput: ref(),
      page: 1,
      banyakPage: 5,
      desserts: [
        {
          namaAnak: "anak1",
          namaAyah: "ayah1",
          namaIbu: "ibu1",
        },
        {
          namaAnak: "anak1",
          namaAyah: "ayah1",
          namaIbu: "ibu1",
        },
        {
          namaAnak: "anak1",
          namaAyah: "ayah1",
          namaIbu: "ibu1",
        },
        {
          namaAnak: "anak1",
          namaAyah: "ayah1",
          namaIbu: "ibu1",
        },
        {
          namaAnak: "anak1",
          namaAyah: "ayah1",
          namaIbu: "ibu1",
        },
        {
          namaAnak: "anak1",
          namaAyah: "ayah1",
          namaIbu: "ibu1",
        },
        {
          namaAnak: "anak1",
          namaAyah: "ayah1",
          namaIbu: "ibu1",
        },
        {
          namaAnak: "anak1",
          namaAyah: "ayah1",
          namaIbu: "ibu1",
        },
        {
          namaAnak: "anak1",
          namaAyah: "ayah1",
          namaIbu: "ibu1",
        },
        {
          namaAnak: "anak1",
          namaAyah: "ayah1",
          namaIbu: "ibu1",
        },
        {
          namaAnak: "anak1",
          namaAyah: "ayah1",
          namaIbu: "ibu1",
        },
        {
          namaAnak: "anak1",
          namaAyah: "ayah1",
          namaIbu: "ibu1",
        },
        {
          namaAnak: "anak1",
          namaAyah: "ayah1",
          namaIbu: "ibu1",
        },
      ],
    };
  },

  methods: {},
};
</script>
