<template>
  <VRow>
    <VCol cols="12">
      <VCard title="Data orang tua">
        <VCardItem>
          <VRow class="mb-5">
            <VCol cols="4">
              <VRadioGroup v-model="data_tersedia">
                <VRadio label="Pilih data tersedia" :value="true"></VRadio>
              </VRadioGroup>
            </VCol>
            <VCol cols="4">
              <VRadioGroup v-model="data_tersedia">
                <VRadio label="Tambah data" :value="false"></VRadio>
              </VRadioGroup>
            </VCol>
          </VRow>
          <VRow v-if="data_tersedia">
            <VCol cols="12">
              <VAutocomplete v-model="pilihOrangTua" label="Nama orang tua..." :items="listOrangTua"></VAutocomplete>
            </VCol>
          </VRow>
          <VRow v-else>
            <VCol cols="12">
              <VRow no-gutters>
                <!-- 👉 First Name -->
                <VCol cols="12" md="3">
                  <label for="ayah">Nama Ayah</label>
                </VCol>

                <VCol cols="12" md="9">
                  <VTextField id="ayah" v-model="nama_ayah" placeholder="Masukkan Nama Ayah" persistent-placeholder />
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
                  <VTextField v-model="nik_ayah" id="nik_ayah" placeholder="Masukkan NIK Ayah" persistent-placeholder />
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
                  <VTextField v-model="nama_ibu" id="ibu" placeholder="Masukkan Nama Ibu" persistent-placeholder />
                  <sup class="text-error">*Wajib diisi</sup>
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
                  <VTextField v-model="nik_ibu" id="nik_ibu" placeholder="Masukkan NIK Ibu" persistent-placeholder />
                </VCol>
              </VRow>
            </VCol>
            <VCol cols="12">
              <VRow no-gutters>
                <!-- 👉 First Name -->
                <VCol cols="12" md="3">
                  <label for="tanggal-meninggal-ibu">Tanggal Meninggal Ibu</label>
                </VCol>

                <VCol cols="12" md="9">
                  <VTextField placeholder="" type="date" v-model="tanggal_meninggal_ibu" />
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
                  <VTextField v-model="rt_rw" placeholder="Masukkan RT/RW" persistent-placeholder />
                </VCol>
              </VRow>
            </VCol>
            <VCol cols="12">
              <VRow no-gutters>
                <!-- 👉 First Name -->
                <VCol cols="12" md="3">
                  <label for="ibu">Provinsi</label>
                </VCol>

                <VCol cols="12" md="9">
                  <VSelect placeholder="Pilih..." v-model="provinceId" :items="provinces" />
                </VCol>
              </VRow>
            </VCol>
            <VCol cols="12" v-if="regencies.length > 0">
              <VRow no-gutters>
                <!-- 👉 First Name -->
                <VCol cols="12" md="3">
                  <label for="ibu">Kab/Kota</label>
                </VCol>

                <VCol cols="12" md="9">
                  <VSelect placeholder="Pilih..." v-model="regencyId" :items="regencies" />
                </VCol>
              </VRow>
            </VCol>
            <VCol cols="12" v-if="districts.length > 0">
              <VRow no-gutters>
                <!-- 👉 First Name -->
                <VCol cols="12" md="3">
                  <label for="ibu">Kecamatan</label>
                </VCol>

                <VCol cols="12" md="9">
                  <VSelect placeholder="Pilih..." v-model="districtId" :items="districts" />
                </VCol>
              </VRow>
            </VCol>
            <VCol cols="12" v-if="villages.length > 0">
              <VRow no-gutters>
                <!-- 👉 First Name -->
                <VCol cols="12" md="3">
                  <label for="ibu">Kelurahan</label>
                </VCol>

                <VCol cols="12" md="9">
                  <VSelect placeholder="Pilih..." v-model="villageId" :items="villages" />
                </VCol>
              </VRow>
            </VCol>
          </VRow>
        </VCardItem>
      </VCard>
    </VCol>
    <VCol cols="12" md="12">
      <!-- 👉 Horizontal Form -->
      <VCard title="Tambah Data Bayi">
        <VCardText>
          <VForm @submit="submitData">
            <VRow>
              <VCol cols="12">
                <VRow no-gutters>
                  <!-- 👉 First Name -->
                  <VCol cols="12" md="3">
                    <label for="bayi">Nama Bayi</label>
                  </VCol>

                  <VCol cols="12" md="9">
                    <VTextField v-model="nama_bayi" id="bayi" placeholder="Masukkan Nama Bayi" persistent-placeholder />
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
                    <VSelect v-model="jenis_kelamin" :items="['L', 'P']" />
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
                    <VTextField placeholder="" type="date" v-model="tanggal_lahir" />
                    <sup class="text-error">*Wajib diisi</sup>
                  </VCol>
                </VRow>
              </VCol>
              <VCol cols="12">
                <VRow no-gutters>
                  <!-- 👉 First Name -->
                  <VCol cols="12" md="3">
                    <label for="tanggal-meninggal-bayi">Tanggal Meninggal Bayi</label>
                  </VCol>

                  <VCol cols="12" md="9">
                    <VTextField placeholder="" type="date" v-model="tanggal_meninggal_bayi" />
                  </VCol>
                </VRow>
              </VCol>
              <VCol cols="12">
                <VRow no-gutters>
                  <!-- 👉 First Name -->
                  <VCol cols="12" md="3">
                    <label>Berat Lahir</label>
                  </VCol>

                  <VCol cols="12" md="9">
                    <VTextField v-model="berat_lahir" type="number" placeholder="Masukkan Berat Lahir"
                      persistent-placeholder />
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
                    <VTextField v-model="keterangan" placeholder="Masukkan Keterangan" persistent-placeholder />
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
                    <VCheckbox v-model="memiliki_kia" :label="`Ya`" />
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
                    <VCheckbox v-model="memiliki_kms" :label="`Ya`" />
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
      listOrangTua: [],
      pilihOrangTua: ref(),
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
      data_tersedia: true,
      berat_lahir: "",
      completed: false,
      fetchingProvinces: false,
      fetchingRegencies: false,
      fetchingDistricts: false,
      fetchingVillages: false,
      provinces: [],
      regencies: [],
      districts: [],
      villages: [],
      provinceId: ref(),
      regencyId: ref(),
      districtId: ref(),
      villageId: ref(),
    };
  },
  watch: {
    provinceId() {
      this.regencyId = ref()
      this.districtId = ref()
      this.villageId = ref()
      this.fetchRegencies()
      this.completed = false
    },
    regencyId() {
      this.districtId = ref()
      this.villageId = ref()
      this.fetchDistricts()
      this.completed = false
    },
    districtId() {
      this.villageId = ref()
      this.fetchVillages()
      this.completed = false
    },
    villageId() {
      this.completed = true
    }
  },
  mounted() {
    this.fetchProvinces();
    this.fetchListOrtu();
  },
  methods: {
    async fetchListOrtu() {

      const response = await axios.get(`${config.urlServer}/api/list-orang-tua`,
        {
          headers: {
            Authorization: localStorage.getItem("tokenAuth"),
          },
        });
      this.listOrangTua = response.data;
    },
    async fetchProvinces() {
      this.fetchingProvinces = true
      const response = await axios.get(`/api-wilayah-indonesia/provinces.json`)
      this.fetchingProvinces = false
      this.provinces = response.data.map(item => {
        let result = {
          title: item.name,
          value: item.id
        }
        return result
      })
    },
    async fetchRegencies() {
      if (!this.provinceId) {
        this.regencies = []
        return
      }
      this.fetchingRegencies = true
      const response = await axios.get(`/api-wilayah-indonesia/regencies/${this.provinceId}.json`)
      this.fetchingRegencies = false
      this.regencies = response.data.map(item => {
        let result = {
          title: item.name,
          value: item.id
        }
        return result
      })
    },
    async fetchDistricts() {
      if (!this.regencyId) {
        this.districts = []
        return
      }

      this.fetchingDistricts = true
      const response = await axios.get(`/api-wilayah-indonesia/districts/${this.regencyId}.json`)
      this.fetchingDistricts = false
      this.districts = response.data.map(item => {
        let result = {
          title: item.name,
          value: item.id
        }
        return result
      })
    },
    async fetchVillages() {
      if (!this.districtId) {
        this.villages = []
        return
      }

      this.fetchingVillages = true
      const response = await axios.get(`/api-wilayah-indonesia/villages/${this.districtId}.json`)
      this.fetchingVillages = false
      this.villages = response.data.map(item => {
        let result = {
          title: item.name,
          value: item.id
        }
        return result
      })
    },
    async submitData(formData) {
      this.isLoading = true;
      // if (!this.completed) {
      await Swal.fire({
        toast: true,
        position: "top",
        iconColor: "white",
        color: "white",
        background: "rgb(var(--v-theme-error))",
        showConfirmButton: false,
        timerProgressBar: true,
        timer: 4000,
        icon: "error",
        title: "Data alamat tidak lengkap!!",
      });
      return 0
      // }
      const tempat_tinggal = `${this.provinces.find(item => item.value === this.provinceId).title}, ${this.regencies.find(item => item.value === this.regencyId).title}, ${this.districts.find(item => item.value === this.districtId).title}, ${this.villages.find(item => item.value === this.villageId).title}`;
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
          tempat_tinggal: tempat_tinggal,
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
  },
};
</script>
