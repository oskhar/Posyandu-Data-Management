<template>
  <VRow>
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
                    <label for="ayah">Nama Ayah</label>
                  </VCol>

                  <VCol cols="12" md="9">
                    <VTextField
                      id="ayah"
                      v-model="nama_ayah"
                      placeholder="Masukkan Nama Ayah"
                      persistent-placeholder
                    />
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
                    <VTextField
                      v-model="nama_ibu"
                      id="ibu"
                      placeholder="Masukkan Nama Ibu"
                      persistent-placeholder
                    />
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
                    <VTextField
                      v-model="nama_bayi"
                      id="bayi"
                      placeholder="Masukkan Nama Bayi"
                      persistent-placeholder
                    />
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
                    <VTextField
                      placeholder=""
                      type="date"
                      v-model="tanggal_lahir"
                    />
                    <sup class="text-error">*Wajib diisi</sup>
                  </VCol>
                </VRow>
              </VCol>
              <VCol cols="12">
                <VRow no-gutters>
                  <!-- 👉 First Name -->
                  <VCol cols="12" md="3">
                    <label for="tanggal-meninggal-bayi"
                      >Tanggal Meninggal Bayi</label
                    >
                  </VCol>

                  <VCol cols="12" md="9">
                    <VTextField
                      placeholder=""
                      type="date"
                      v-model="tanggal_meninggal_bayi"
                    />
                  </VCol>
                </VRow>
              </VCol>
              <VCol cols="12">
                <VRow no-gutters>
                  <!-- 👉 First Name -->
                  <VCol cols="12" md="3">
                    <label for="tanggal-meninggal-ibu"
                      >Tanggal Meninggal Ibu</label
                    >
                  </VCol>

                  <VCol cols="12" md="9">
                    <VTextField
                      placeholder=""
                      type="date"
                      v-model="tanggal_meninggal_ibu"
                    />
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
              <VCol cols="12">
                <VRow no-gutters>
                  <!-- 👉 First Name -->
                  <VCol cols="12" md="3">
                    <label>Berat Lahir</label>
                  </VCol>

                  <VCol cols="12" md="9">
                    <VTextField
                      v-model="berat_lahir"
                      placeholder="Masukkan Berat Lahir"
                      persistent-placeholder
                    />
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
                    <VTextField
                      v-model="rt_rw"
                      placeholder="Masukkan RT/RW"
                      persistent-placeholder
                    />
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
                    <VTextField
                      v-model="keterangan"
                      placeholder="Masukkan Keterangan"
                      persistent-placeholder
                    />
                  </VCol>
                </VRow>
              </VCol>

              <!-- 👉 submit and reset button -->
              <VCol offset-md="3" cols="12" md="9" class="d-flex gap-4">
                <VBtn type="submit" :disabled="isLoading">
                  <VProgressCircular
                    v-if="isLoading"
                    indeterminate
                    color="white"
                  >
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
      nama_ayah: ref(""),
      nama_ibu: ref(""),
      nama_bayi: ref(""),
      jenis_kelamin: ref("L"),
      tanggal_lahir: ref(""),
      tanggal_meninggal_bayi: ref(""),
      tanggal_meninggal_ibu: ref(""),
      keterangan: ref(""),
      rt_rw: ref(""),
      memiliki_kia: ref(""),
      memiliki_kms: ref(""),
      berat_lahir: ref(""),
    };
  },
  methods: {
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
        console.log(data);
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
