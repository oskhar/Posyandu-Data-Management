<template>
  <VRow>
    <VCol cols="12">
      <VCard>
        <!-- <VCardText> </VCardText> -->
        <VCardItem>
          <div class="d-flex justify-end">
          </div>
          <VTable>
            <thead>
              <tr>
                <th>No</th>
                <th>Email Admin</th>
                <th>Nama Lengkap</th>
                <th>Jabatan</th>
                <th>Aksi</th>
              </tr>
            </thead>

            <tbody>
              <VProgressCircular v-if="isLoading" indeterminate color="primary" class="mt-5 float-center" size="50">
              </VProgressCircular>

              <tr v-for="(item, index) in dataAdmin " v-else :key="item.dessert">
                <td>
                  {{ (page - 1) * 20 + (index + 1) }}
                </td>
                <td>
                  {{ item.email_admin }}
                </td>
                <td>
                  {{ item.nama_lengkap }}
                </td>
                <td>
                  <VDialog v-model="dialogJabatan[index]" persistent width="1024">
                    <template #activator="{ props }">
                      <VBtn class="ml-2 text-none text-subtitle-1" v-bind="props" style="width: 210px" variant="tonal">
                        {{ listJabatan[item.id_jabatan] }}
                      </VBtn>
                    </template>
                    <VCard>
                      <VCardTitle>
                        <span class="text-h5">Ubah Jabatan</span>
                      </VCardTitle>
                      <VCardText>
                        <VContainer>
                          <VRow>
                            <VCol cols="12">
                              <VSelect v-model="dataAdmin[index].id_jabatan" :items="[
                                { title: 'PELINDUNG', value: 1 },
                                { title: 'PENANGGUNG JAWAB', value: 2 },
                                { title: 'SEKRETARIS', value: 3 },
                                { title: 'BENDAHARA', value: 4 },
                                { title: 'PENDAFTARAN', value: 5 },
                                { title: 'PENIMBANGAN', value: 6 },
                                { title: 'PENCATATAN', value: 7 },
                                { title: 'PENYULUHAN', value: 8 },
                              ]" placeholder="Pilih Jabatan" />
                            </VCol>
                          </VRow>
                        </VContainer>
                      </VCardText>
                      <VCardActions>
                        <VSpacer></VSpacer>
                        <VBtn color="blue-darken-1" variant="text" @click="dialogJabatan[index] = false; fetchData()">
                          Tutup
                        </VBtn>
                        <VBtn color="success" variant="text" @click="putDataJabatan(index)">
                          Simpan
                        </VBtn>
                      </VCardActions>
                    </VCard>
                  </VDialog>
                </td>
                <td class="text-center">
                  <VDialog v-model="dialog[index]" persistent width="1024">
                    <template #activator="{ props }">
                      <VBtn color="primary" class="ml-2" v-bind="props" prepend-icon="bx-key">
                        password
                      </VBtn>
                    </template>
                    <VCard>
                      <VCardTitle>
                        <span class="text-h5">Ubah Password</span>
                      </VCardTitle>
                      <VCardText>
                        <VContainer>
                          <VRow>
                            <VCol cols="12">
                              <!-- 👉 First Name -->

                              <!-- 👉 new password -->
                              <VTextField v-model="newPassword" :type="isNewPasswordVisible ? 'text' : 'password'
                                " :append-inner-icon="isNewPasswordVisible ? 'bx-hide' : 'bx-show'"
                                label="Password Baru" placeholder="············" @click:append-inner="
                                  isNewPasswordVisible = !isNewPasswordVisible
                                  " />
                            </VCol>

                            <VCol cols="12">
                              <!-- 👉 confirm password -->
                              <VTextField v-model="confirmPassword" :type="isConfirmPasswordVisible ? 'text' : 'password'
                                " :append-inner-icon="isConfirmPasswordVisible ? 'bx-hide' : 'bx-show'"
                                label="Konfirmasi Password Baru" placeholder="············" @click:append-inner="
                                  isConfirmPasswordVisible =
                                  !isConfirmPasswordVisible
                                  " />
                            </VCol>
                          </VRow>
                        </VContainer>
                      </VCardText>
                      <VCardActions>
                        <VSpacer></VSpacer>
                        <VBtn color="blue-darken-1" variant="text" @click="dialog[index] = false">
                          Tutup
                        </VBtn>
                        <VBtn color="success" variant="text" @click="putData(index)">
                          Simpan
                        </VBtn>
                      </VCardActions>
                    </VCard>
                  </VDialog>
                  <!-- <VBtn> </VBtn> -->
                  <VBtn class="ml-2" color="error" @click="deleteData(item.id_admin)">
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
</template>

<script>
import axios from "axios";
import config from "@/@core/config";
import Swal from "sweetalert2";

export default {
  data() {
    return {
      dialog: [],
      dialogJabatan: [],
      dataAdmin: [],
      page: 1,
      currentIdAdmin: localStorage.getItem("id_admin"),
      isNewPasswordVisible: false,
      isConfirmPasswordVisible: false,
      newPassword: null,
      confirmPassword: null,
      listJabatan: {
        1: 'PELINDUNG',
        2: 'PENANGGUNG JAWAB',
        3: 'SEKRETARIS',
        4: 'BENDAHARA',
        5: 'PENDAFTARAN',
        6: 'PENIMBANGAN',
        7: 'PENCATATAN',
        8: 'PENYULUHAN',
      },
    };
  },
  mounted() {
    this.fetchData();
  },
  methods: {
    async fetchData() {
      const response = await axios.get(`${config.urlServer}/api/admin`, {
        headers: {
          Authorization: localStorage.getItem("tokenAuth"),
        },
      });

      this.dataAdmin = response.data.admin;
    },

    async putDataJabatan(indexAdmin) {
      this.dialogJabatan[indexAdmin] = false;
      try {
        const data = {
          id_admin: this.dataAdmin[indexAdmin].id_admin,
          id_jabatan: this.dataAdmin[indexAdmin].id_jabatan,
        };

        const response = await axios.put(
          `${config.urlServer}/api/admin`,
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
            timer: 2000,
            icon: "success",
            title: response.data.success.message,
          });
        }
      } catch (get) {
        const errorMessage = Object.values(get.response.data.errors).join(
          " - ",
        );

        Swal.fire({
          toast: true,
          position: "top",
          iconColor: "white",
          color: "white",
          background: "rgb(var(--v-theme-error))",
          showConfirmButton: false,
          timerProgressBar: true,
          timer: 2000,
          icon: "error",
          title: errorMessage,
        });
        this.fetchData();
      }
    },

    async putData(indexAdmin) {
      this.dialog[indexAdmin] = false;
      try {
        const data = {
          id_admin: this.dataAdmin[indexAdmin].id_admin,
          new_password: this.newPassword,
          confirm_password: this.confirmPassword,
        };

        const response = await axios.put(
          `${config.urlServer}/api/reset-password`,
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
            timer: 2000,
            icon: "success",
            title: response.data.success.message,
          });
        }
      } catch (get) {
        const errorMessage = Object.values(get.response.data.errors).join(
          " - ",
        );

        Swal.fire({
          toast: true,
          position: "top",
          iconColor: "white",
          color: "white",
          background: "rgb(var(--v-theme-error))",
          showConfirmButton: false,
          timerProgressBar: true,
          timer: 2000,
          icon: "error",
          title: errorMessage,
        });
      }
    },

    async deleteData(id_admin) {
      try {
        const ask = await Swal.fire({
          title: "Anda yakin ingin menghapus?",
          showConfirmButton: false,
          showDenyButton: true,
          showCancelButton: true,
          denyButtonText: "Hapus",
        });

        if (ask.isDenied) {
          const response = await axios.delete(
            `${config.urlServer}/api/admin?id_admin=${id_admin}`,
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
              timer: 2000,
              icon: "success",
              title: response.data.success.message,
            });
            this.fetchData();
          }
        }
      } catch (get) {
        const errorMessage = Object.values(get.response.data.errors).join(
          " - ",
        );

        Swal.fire({
          toast: true,
          position: "top",
          iconColor: "white",
          color: "white",
          background: "rgb(var(--v-theme-error))",
          showConfirmButton: false,
          timerProgressBar: true,
          timer: 2000,
          icon: "error",
          title: errorMessage,
        });
        this.fetchData();
      }
    },
  },
};
</script>
