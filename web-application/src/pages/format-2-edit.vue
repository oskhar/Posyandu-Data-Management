<template>
  <VRow>
    <VCol cols="12" md="12">
      <VCard title="Tambah Data Bayi">
        <VCardText>
          <VForm @submit="submitData">
            <VRow>
              <VCol cols="12">
                <h4 class="my-5">Umur 0 Bulan</h4>
                <VRow>
                  <VCol cols="12" sm="4">
                    <VTextField
                      v-model="a"
                      label="Berat Badan"
                      placeholder="John"
                    />
                  </VCol>
                  <VCol cols="12" sm="4">
                    <VTextField
                      v-model="b"
                      label="N/T/O/B & BGM"
                      placeholder="John"
                    />
                  </VCol>
                  <VCol cols="12" sm="4">
                    <VTextField
                      v-model="c"
                      label="Asi Ekskulusif"
                      placeholder="John"
                    />
                  </VCol>
                </VRow>
                <h4 class="my-5">Umur 0 Bulan</h4>
                <VRow>
                  <VCol cols="12" sm="4">
                    <VTextField
                      v-model="a"
                      label="Berat Badan"
                      placeholder="John"
                    />
                  </VCol>
                  <VCol cols="12" sm="4">
                    <VTextField
                      v-model="b"
                      label="N/T/O/B & BGM"
                      placeholder="John"
                    />
                  </VCol>
                  <VCol cols="12" sm="4">
                    <VTextField
                      v-model="c"
                      label="Asi Ekskulusif"
                      placeholder="John"
                    />
                  </VCol>
                </VRow>
                <h4 class="my-5">Umur 0 Bulan</h4>
                <VRow>
                  <VCol cols="12" sm="4">
                    <VTextField
                      v-model="a"
                      label="Berat Badan"
                      placeholder="John"
                    />
                  </VCol>
                  <VCol cols="12" sm="4">
                    <VTextField
                      v-model="b"
                      label="N/T/O/B & BGM"
                      placeholder="John"
                    />
                  </VCol>
                  <VCol cols="12" sm="4">
                    <VTextField
                      v-model="c"
                      label="Asi Ekskulusif"
                      placeholder="John"
                    />
                  </VCol>
                </VRow>
                <h4 class="my-5">Umur 0 Bulan</h4>
                <VRow>
                  <VCol cols="12" sm="4">
                    <VTextField
                      v-model="a"
                      label="Berat Badan"
                      placeholder="John"
                    />
                  </VCol>
                  <VCol cols="12" sm="4">
                    <VTextField
                      v-model="b"
                      label="N/T/O/B & BGM"
                      placeholder="John"
                    />
                  </VCol>
                  <VCol cols="12" sm="4">
                    <VTextField
                      v-model="c"
                      label="Asi Ekskulusif"
                      placeholder="John"
                    />
                  </VCol>
                </VRow>
                <h4 class="my-5">Umur 0 Bulan</h4>
                <VRow>
                  <VCol cols="12" sm="4">
                    <VTextField
                      v-model="a"
                      label="Berat Badan"
                      placeholder="John"
                    />
                  </VCol>
                  <VCol cols="12" sm="4">
                    <VTextField
                      v-model="b"
                      label="N/T/O/B & BGM"
                      placeholder="John"
                    />
                  </VCol>
                  <VCol cols="12" sm="4">
                    <VTextField
                      v-model="c"
                      label="Asi Ekskulusif"
                      placeholder="John"
                    />
                  </VCol>
                </VRow>
                <h4 class="my-5">Umur 0 Bulan</h4>
                <VRow>
                  <VCol cols="12" sm="4">
                    <VTextField
                      v-model="a"
                      label="Berat Badan"
                      placeholder="John"
                    />
                  </VCol>
                  <VCol cols="12" sm="4">
                    <VTextField
                      v-model="b"
                      label="N/T/O/B & BGM"
                      placeholder="John"
                    />
                  </VCol>
                  <VCol cols="12" sm="4">
                    <VTextField
                      v-model="c"
                      label="Asi Ekskulusif"
                      placeholder="John"
                    />
                  </VCol>
                </VRow>
              </VCol>
              <VCol cols="12" md="9" class="d-flex gap-4">
                <VBtn type="submit"> Submit </VBtn>
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
      nama_ayah: ref(""),
      nama_ibu: ref(""),
      nama_bayi: ref(""),
      jenis_kelamin: ref("L"),
      tanggal_lahir: ref(""),
      tanggal_meninggal_bayi: ref(""),
      tanggal_meninggal_ibu: ref(""),
      keterangan: ref(""),
    };
  },
  methods: {
    async submitData(formData) {
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
        console.log(error);
      }
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
    },
  },
};
</script>
