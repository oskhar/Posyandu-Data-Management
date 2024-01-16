<template>
  <VRow>
    <VCol cols="12" md="12">
      <VCard title="Data orang tua" class="mb-5">
        <VCardText>
          <VBtn class="mb-4" prepend-icon="bx-plus">Tambah data orang tua</VBtn>
          <VAutocomplete label="Nama orang tua..."
            :items="['California', 'Colorado', 'Florida', 'Georgia', 'Texas', 'Wyoming']"></VAutocomplete>
        </VCardText>
      </VCard>
      <!-- 👉 Horizontal Form -->
      <VCard title="Tambah Data Bayi">
        <VCardText>
          <VForm @submit="submitData">
            <VRow>
              <VCol cols="12">
                <VRow no-gutters>
                  <!-- 👉 First Name -->
                  <VCol cols="12" md="3">
                    <label for="ks">Tahapan KS</label>
                  </VCol>

                  <VCol cols="12" md="9">
                    <VTextField v-model="tahapan_ks" id="ks" placeholder="Tahapan KS.." persistent-placeholder />
                    <sup class="text-error">*Wajib diisi</sup>
                  </VCol>
                </VRow>
              </VCol>
              <VCol cols="12">
                <VRow no-gutters>
                  <!-- 👉 First Name -->
                  <VCol cols="12" md="3">
                    <label for="dasawisma">Kelompok Dasawisma</label>
                  </VCol>

                  <VCol cols="12" md="9">
                    <VTextField v-model="kelompok_dasawisma" id="dasawisma" placeholder="Kelompok dasawisma.."
                      persistent-placeholder />
                    <sup class="text-error">*Wajib diisi</sup>
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
                    <VTextField v-model="kelompok_lila" id="lila" placeholder="cm.." persistent-placeholder
                      type="number" />
                    <sup class="text-error">*Wajib diisi</sup>
                  </VCol>
                </VRow>
              </VCol>
              <VCol cols="12">
                <VRow no-gutters>
                  <!-- 👉 First Name -->
                  <VCol cols="12" md="3">
                    <label for="tanggal-lahir">Jumlah anak</label>
                  </VCol>

                  <VCol cols="6" md="4">
                    <VTextField placeholder="Hidup.." v-model="anak_hidup" />
                    <sup class="text-error">*Wajib diisi</sup>
                  </VCol>

                  <VCol cols="6" class="ml-5" md="4">
                    <VTextField placeholder="Meninggal.." v-model="anak_meninggal" />
                    <sup class="text-error">*Wajib diisi</sup>
                  </VCol>
                </VRow>
              </VCol>
              <VCol cols="12">
                <VRow no-gutters>
                  <!-- 👉 First Name -->
                  <VCol cols="12" md="3">
                    <label for="imunisasi">Imunisasi</label>
                  </VCol>

                  <VCol cols="12" md="9">
                    <VSelect v-model="pilihImunisasi" :items="itemImunisasi" label="imunisasi"
                      placeholder="Pilih beberapa" multiple chips>
                      <template v-slot:prepend-item>
                        <v-list-item ripple @mousedown.prevent @click="toggleHasil">
                          <v-list-item-action>
                            <v-icon :color="pilihImunisasi.length === itemImunisasi.length ? 'primary' : 'secondary'">
                              {{ iconHasil }}
                            </v-icon>
                            <font class="ml-2"> Pilih Semua </font>
                          </v-list-item-action>
                        </v-list-item>
                        <v-divider class="mt-2"></v-divider>
                      </template>
                    </VSelect>
                  </VCol>
                </VRow>
              </VCol>
              <VCol cols="12">
                <VRow no-gutters>
                  <!-- 👉 First Name -->
                  <VCol cols="12" md="3">
                    <label for="kontrasepsi">Jenis Kontrasepsi</label>
                  </VCol>

                  <VCol cols="12" md="9">
                    <VTextField v-model="jenis_kontrasepsi" id="kontrasepsi" placeholder="jenis.."
                      persistent-placeholder />
                    <sup class="text-error">*Wajib diisi</sup>
                  </VCol>
                </VRow>
              </VCol>
              <VCol cols="12">
                <VRow no-gutters>
                  <!-- 👉 First Name -->
                  <VCol cols="12" md="3">
                    <label for="penggantian">Tanggal Penggantian</label>
                  </VCol>

                  <VCol cols="12" md="9">
                    <VTextField v-model="tanggal_penggantian" id="penggantian" placeholder="Tanggal Penggantian.."
                      persistent-placeholder type="date" />
                    <sup class="text-error">*Wajib diisi</sup>
                  </VCol>
                </VRow>
              </VCol>
              <VCol cols="12">
                <VRow no-gutters>
                  <!-- 👉 First Name -->
                  <VCol cols="12" md="3">
                    <label for="kontrasepsi">Penggantian</label>
                  </VCol>

                  <VCol cols="12" md="9">
                    <VTextField v-model="penggantian_jenis_kontrasepsi" id="kontrasepsi" placeholder="jenis kontrasepsi.."
                      persistent-placeholder />
                    <sup class="text-error">*Wajib diisi</sup>
                  </VCol>
                </VRow>
              </VCol>
              <!-- 👉 submit and reset button -->
              <VCol offset-md="3" cols="12" md="9" class="d-flex gap-4">
                <VBtn type="submit" :disabled="isLoading">
                  <VProgressCircular v-if="isLoading" indeterminate color="white">
                  </VProgressCircular>

                  <font v-else>Submit</font>
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
import config from "@/@core/config.vue";
import Swal from "sweetalert2";
import { ref } from "vue";

export default {
  data() {
    return {
      isLoading: false,
      nama_ayah: "",
      nama_ibu: "",
      nama_bayi: "",
      jenis_kelamin: "L",
      tanggal_lahir: "",
      tanggal_meninggal_bayi: "",
      tanggal_meninggal_ibu: "",
      keterangan: "",
      rt_rw: "",
      memiliki_kia: "",
      memiliki_kms: "",
      berat_lahir: "",
      pilihImunisasi: [],
      itemImunisasi: [
        'Imunisasi I',
        'Imunisasi II',
        'Imunisasi III',
        'Imunisasi IV',
        'Imunisasi V',
      ],
    };
  },
  computed: {
    pilihSemuaHasil() {
      return this.pilihImunisasi.length === this.itemImunisasi.length
    },
    iconHasil() {
      if (this.pilihSemuaHasil) return 'mdi-close-box'
      return 'mdi-checkbox-blank-outline'
    },
  },
  methods: {
    toggleHasil() {
      this.$nextTick(() => {
        if (this.pilihSemuaHasil) {
          this.pilihImunisasi = []
        } else {
          this.pilihImunisasi = this.itemImunisasi.slice()
        }
      })
    },

    async submitData(formData) {
      this.isLoading = true;
      try {
        formData.preventDefault();

        const data = {
          nama_ayah: this.nama_ayah,
          nama_ibu: this.nama_ibu,
          nama_bayi: this.nama_bayi,
          jenis_kelamin: this.jenis_kelamin,
          tanggal_lahir: this.tanggal_lahir,
          tanggal_meninggal_bayi: this.tanggal_meninggal_bayi,
          tanggal_meninggal_ibu: this.tanggal_meninggal_ibu,
          keterangan: this.keterangan,
          rt_rw: this.rt_rw,
          memiliki_kia: this.memiliki_kia,
          memiliki_kms: this.memiliki_kms,
          berat_lahir: this.berat_lahir,
        };
        const response = await axios.post(
          `${config.urlServer}/api/format-a`,
          data,
          {
            headers: {
              Authorization: localStorage.getItem("tokenAuth"),
            },
          }
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
          this.resetData();
        }
      } catch (error) {
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
          title: "Data Tidak Lengkap",
        });
      }
      this.isLoading = false;
    },
    resetData() {
      this.nama_ayah = ref("");
      this.nama_ibu = ref("");
      this.nama_bayi = ref("");
      this.jenis_kelamin = ref("L");
      this.tanggal_lahir = ref("");
      this.tanggal_meninggal_bayi = ref("");
      this.tanggal_meninggal_ibu = ref("");
      this.keterangan = ref("");
      this.rt_rw = ref("");
      this.memiliki_kia = ref("");
      this.memiliki_kms = ref("");
      this.berat_lahir = ref("");
    },
  },
};
</script>
