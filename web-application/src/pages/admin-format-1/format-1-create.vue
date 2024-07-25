<template>
  <VRow>
    <VCol cols="12">
      <VBtn prepend-icon="bx-left-arrow-alt" variant="text" to="/admin/data/format-1" class="mb-4">
        Kembali
      </VBtn>

      <VCard title="Data orang tua">
        <VCardItem>
          <VRow class="mb-5">
            <VCol cols="12" md="4" lg="4">
              <VRadioGroup v-model="data_tersedia">
                <VRadio label="Pilih data tersedia" :value="true" />
              </VRadioGroup>
            </VCol>
            <VCol cols="12" md="4" lg="4">
              <VRadioGroup v-model="data_tersedia">
                <VRadio label="Tambah data" :value="false"></VRadio>
              </VRadioGroup>
            </VCol>
          </VRow>
          <VRow v-if="data_tersedia">
            <VCol cols="12">
              <VAutocomplete v-model="pilihOrangTua" label="Nama orang tua...." :items="listOrangTua"></VAutocomplete>
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
                  <VTextField id="ayah" v-model="nama_ayah" placeholder="Masukkan Nama Ayah..."
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
                  <VTextField id="ibu" v-model="nama_ibu" placeholder="Masukkan Nama Ibu..." persistent-placeholder />
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
                  <VTextField id="nik_ayah" v-model="nik_ayah" placeholder="Masukkan NIK Ayah..."
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
                  <VTextField id="nik_ibu" v-model="nik_ibu" placeholder="Masukkan NIK Ibu..." persistent-placeholder />
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
                  <VTextField v-model="tanggal_meninggal_ibu" placeholder="" type="date" />
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
                  <VTextField v-model="no_telp" placeholder="08xx" persistent-placeholder />
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
                  <VTextField v-model="rt_rw" placeholder="Masukkan RT/RW..." persistent-placeholder />
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
                  <VAutocomplete v-model="provinceId" placeholder="Pilih...." :items="provinces" />
                </VCol>
              </VRow>
            </VCol>
            <VCol v-if="regencies.length > 0" cols="12">
              <VRow no-gutters>
                <!-- 👉 First Name -->
                <VCol cols="12" md="3">
                  <label for="ibu">Kab/Kota</label>
                </VCol>

                <VCol cols="12" md="9">
                  <VAutocomplete v-model="regencyId" placeholder="Pilih...." :items="regencies" />
                </VCol>
              </VRow>
            </VCol>
            <VCol v-if="districts.length > 0" cols="12">
              <VRow no-gutters>
                <!-- 👉 First Name -->
                <VCol cols="12" md="3">
                  <label for="ibu">Kecamatan</label>
                </VCol>

                <VCol cols="12" md="9">
                  <VAutocomplete v-model="districtId" placeholder="Pilih...." :items="districts" />
                </VCol>
              </VRow>
            </VCol>
            <VCol v-if="villages.length > 0" cols="12">
              <VRow no-gutters>
                <!-- 👉 First Name -->
                <VCol cols="12" md="3">
                  <label for="ibu">Kelurahan</label>
                </VCol>

                <VCol cols="12" md="9">
                  <VAutocomplete v-model="villageId" placeholder="Pilih...." :items="villages" />
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
          <VRow>
            <VCol cols="12">
              <VRow no-gutters>
                <!-- 👉 First Name -->
                <VCol cols="12" md="3">
                  <label for="bayi">Nama Bayi</label>
                </VCol>

                <VCol cols="12" md="9">
                  <VTextField id="bayi" v-model="nama_bayi" placeholder="Masukkan Nama Bayi..."
                    persistent-placeholder />
                  <sup class="text-error">*Wajib diisi</sup>
                </VCol>
              </VRow>
            </VCol>
            <VCol cols="12">
              <VRow no-gutters>
                <!-- 👉 First Name -->
                <VCol cols="12" md="3">
                  <label>Bayi memiliki NIK</label>
                </VCol>

                <VCol cols="12" md="9">
                  <VCheckbox v-model="bayi_memiliki_nik" label="Ya" />
                </VCol>
              </VRow>
            </VCol>
            <VCol v-if="bayi_memiliki_nik" cols="12">
              <VRow no-gutters>
                <!-- 👉 First Name -->
                <VCol cols="12" md="3">
                  <label for="nik_bayi">NIK bayi</label>
                </VCol>

                <VCol cols="12" md="9">
                  <VTextField id="nik_bayi" v-model="nik_bayi" placeholder="Masukkan NIK bayi..."
                    persistent-placeholder />
                </VCol>
              </VRow>
            </VCol>
            <VCol cols="12">
              <VRow no-gutters>
                <!-- 👉 First Name -->
                <VCol cols="12" md="3">
                  <label>Anak ke berapa?</label>
                </VCol>

                <VCol cols="12" md="9">
                  <VTextField v-model="anak_ke" type="number" placeholder="Masukkan panjang Lahir..."
                    persistent-placeholder />
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
                  <VSelect v-model="jenis_kelamin" :items="['L', 'P']" placeholder="Pilih jenis kelamin.." />
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
                  <VTextField v-model="tanggal_lahir" placeholder="" type="date" />
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
                  <VTextField v-model="tanggal_meninggal_bayi" placeholder="" type="date" />
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
                  <VTextField v-model="berat_lahir" type="number" placeholder="Masukkan Berat Lahir..."
                    persistent-placeholder />
                </VCol>
              </VRow>
            </VCol>
            <VCol cols="12">
              <VRow no-gutters>
                <!-- 👉 First Name -->
                <VCol cols="12" md="3">
                  <label>Panjang saat lahir</label>
                </VCol>

                <VCol cols="12" md="9">
                  <VTextField v-model="tinggi_lahir" type="number" placeholder="Masukkan panjang Lahir..."
                    persistent-placeholder />
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
                  <VCheckbox v-model="memiliki_kia" label="Ya" />
                </VCol>
              </VRow>
            </VCol>
            <VCol cols="12">
              <VRow no-gutters>
                <!-- 👉 First Name -->
                <VCol cols="12" md="3">
                  <label>IMD</label>
                </VCol>

                <VCol cols="12" md="9">
                  <VCheckbox v-model="imd" label="Ya" />
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
                  <VCheckbox v-model="memiliki_kms" label="Ya" />
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
            <!-- 👉 submit and reset button -->
            <VCol offset-md="3" cols="12" md="9" class="d-flex gap-4">
              <VBtn :disabled="isLoading" @click="submitData">
                <VProgressCircular v-if="isLoading" indeterminate color="white">
                </VProgressCircular>

                <Font v-else>Simpan</Font>
              </VBtn>
            </VCol>
          </VRow>
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
      listOrangTua: [],
      data_tersedia: true,
      pilihOrangTua: null,
      nama_ayah: "",
      nik_ayah: "",
      nama_ibu: "",
      nik_ibu: "",
      tanggal_meninggal_ibu: "",
      no_telp: "",
      rt_rw: "",
      nama_bayi: "",
      nik_bayi: "",
      anak_ke: "",
      jenis_kelamin: "",
      tanggal_lahir: "",
      tanggal_meninggal_bayi: "",
      berat_lahir: "",
      tinggi_lahir: "",
      memiliki_kia: false,
      imd: false,
      memiliki_kms: false,
      keterangan: "",
      bayi_memiliki_nik: false,
      completed: false,
      fetchingProvinces: false,
      fetchingRegencies: false,
      fetchingDistricts: false,
      fetchingVillages: false,
      provinces: [],
      regencies: [],
      districts: [],
      villages: [],
      provinceId: null,
      regencyId: null,
      districtId: null,
      villageId: null,
    };
  },
  watch: {
    provinceId() {
      this.regencyId = null
      this.districtId = null
      this.villageId = null
      this.fetchRegencies()
      this.completed = false
    },
    regencyId() {
      this.districtId = null
      this.villageId = null
      this.fetchDistricts()
      this.completed = false
    },
    districtId() {
      this.villageId = null
      this.fetchVillages()
      this.completed = false
    },
    villageId() {
      this.completed = true
    },
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

      const response = await axios.get(`${config.urlServer}/api/indonesia/provinces`)

      this.fetchingProvinces = false
      this.provinces = response.data.map(item => {
        return {
          title: item.name,
          value: item.id,
        }
      })
    },
    async fetchRegencies() {
      if (!this.provinceId) {
        this.regencies = []

        return
      }
      this.fetchingRegencies = true

      const response = await axios.get(`${config.urlServer}/api/indonesia/regencies?province_id=${this.provinceId}`)

      this.fetchingRegencies = false
      this.regencies = response.data.map(item => {
        return {
          title: item.name,
          value: item.id,
        }
      })
    },
    async fetchDistricts() {
      if (!this.regencyId) {
        this.districts = []

        return
      }

      this.fetchingDistricts = true

      const response = await axios.get(`${config.urlServer}/api/indonesia/districts?regency_id=${this.regencyId}`)

      this.fetchingDistricts = false
      this.districts = response.data.map(item => {
        return {
          title: item.name,
          value: item.id,
        }
      })
    },
    async fetchVillages() {
      if (!this.districtId) {
        this.villages = []

        return
      }

      this.fetchingVillages = true

      const response = await axios.get(`${config.urlServer}/api/indonesia/villages?district_id=${this.districtId}`)

      this.fetchingVillages = false
      this.villages = response.data.map(item => {
        return {
          title: item.name,
          value: item.id,
        }
      })
    },
    resetData() {
      this.data_tersedia = true;
      this.pilihOrangTua = null;
      this.nama_ayah = "";
      this.nik_ayah = "";
      this.nama_ibu = "";
      this.nik_ibu = "";
      this.tanggal_meninggal_ibu = "";
      this.no_telp = "";
      this.rt_rw = "";
      this.nama_bayi = "";
      this.nik_bayi = "";
      this.anak_ke = "";
      this.jenis_kelamin = "";
      this.tanggal_lahir = "";
      this.tanggal_meninggal_bayi = "";
      this.berat_lahir = "";
      this.tinggi_lahir = "";
      this.memiliki_kia = false;
      this.imd = false;
      this.memiliki_kms = false;
      this.keterangan = "";
      this.bayi_memiliki_nik = false;
      this.completed = false;
      this.fetchingProvinces = false;
      this.fetchingRegencies = false;
      this.fetchingDistricts = false;
      this.fetchingVillages = false;
    },
    async submitData() {
      this.isLoading = true;
      let tempat_tinggal = null;
      if (this.completed) {
        tempat_tinggal = `${this.provinces.find(item => item.value === this.provinceId).title}, ${this.regencies.find(item => item.value === this.regencyId).title}, ${this.districts.find(item => item.value === this.districtId).title}, ${this.villages.find(item => item.value === this.villageId).title}`;
      } else if (!this.data_tersedia) {
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
        this.isLoading = false;

        return 0;
      }
      try {

        const data = {
          id_orang_tua: this.data_tersedia ? this.pilihOrangTua : null,
          nama_ayah: this.nama_ayah,
          nik_ayah: this.nik_ayah,
          nama_ibu: this.nama_ibu,
          nik_ibu: this.nik_ibu,
          tanggal_meninggal_ibu: this.tanggal_meninggal_ibu,
          no_telp: this.no_telp,
          rt_rw: this.rt_rw,
          nama_bayi: this.nama_bayi,
          nik_bayi: this.nik_bayi,
          anak_ke: this.anak_ke,
          jenis_kelamin: this.jenis_kelamin,
          tanggal_lahir: this.tanggal_lahir,
          tanggal_meninggal_bayi: this.tanggal_meninggal_bayi,
          berat_lahir: this.berat_lahir,
          tinggi_lahir: this.tinggi_lahir,
          memiliki_kia: this.memiliki_kia,
          imd: this.imd,
          memiliki_kms: this.memiliki_kms,
          keterangan: this.keterangan,
          tempat_tinggal: tempat_tinggal,
        };

        const response = await axios.post(
          `${config.urlServer}/api/format-a`,
          data,
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
          this.resetData();
          this.fetchListOrtu();
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
          title: "Data Tidak Lengkap",
        });
      }
      this.isLoading = false;
    },
  },
};
</script>
