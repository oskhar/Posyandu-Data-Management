<template>
  <VRow>
    <VCol cols="12">
      <VCard>
        <!-- <VCardText> </VCardText> -->
        <VCardItem>
          <div class="d-flex justify-end">
            <VTextField v-model="dataSearch" append-inner-icon="bx-search">
            </VTextField>
          </div>
          <VTable>
            <thead>
              <tr>
                <th>No</th>
                <th>Email Admin</th>
                <th>Nama Lengkap</th>
                <th>Jabatin</th>
                <th>Aksi</th>
              </tr>
            </thead>

            <tbody>
              <VProgressCircular
                v-if="isLoading"
                indeterminate
                color="primary"
                class="mt-5 float-center"
                size="50"
              >
              </VProgressCircular>

              <tr v-else v-for="(item, index) in dataAdmin" :key="item.dessert">
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
                  <VSelect
                    v-model="item.id_jabatan"
                    style="width: 237px"
                    :items="[
                      { title: 'PELINDUNG', value: 1 },
                      { title: 'PENANGGUNG JAWAB', value: 2 },
                      { title: 'SEKRETARIS', value: 3 },
                      { title: 'BENDAHARA', value: 4 },
                      { title: 'PENDAFTARAN', value: 5 },
                      { title: 'PENIMBANGAN', value: 6 },
                      { title: 'PENCATATAN', value: 7 },
                      { title: 'PENYULUHAN', value: 8 },
                    ]"
                    placeholder="Pilih Jabatan"
                  />
                </td>
                <td class="text-center">
                  <v-dialog
                    v-model="dialog[item.id_bayi]"
                    persistent
                    width="1024"
                  >
                    <template v-slot:activator="{ props }">
                      <VBtn
                        color="primary"
                        class="ml-2"
                        v-bind="props"
                        prepend-icon="bx-key"
                      >
                        password
                      </VBtn>
                    </template>
                    <v-card>
                      <v-card-title>
                        <span class="text-h5">Ubah Password</span>
                      </v-card-title>
                      <v-card-text>
                        <v-container>
                          <VRow>
                            <VCol cols="12">
                              <!-- 👉 First Name -->

                              <!-- 👉 new password -->
                              <VTextField
                                v-model="newPassword"
                                :type="
                                  isNewPasswordVisible ? 'text' : 'password'
                                "
                                :append-inner-icon="
                                  isNewPasswordVisible ? 'bx-hide' : 'bx-show'
                                "
                                label="Password Baru"
                                placeholder="············"
                                @click:append-inner="
                                  isNewPasswordVisible = !isNewPasswordVisible
                                "
                              />
                            </VCol>

                            <VCol cols="12">
                              <!-- 👉 confirm password -->
                              <VTextField
                                v-model="confirmPassword"
                                :type="
                                  isConfirmPasswordVisible ? 'text' : 'password'
                                "
                                :append-inner-icon="
                                  isConfirmPasswordVisible
                                    ? 'bx-hide'
                                    : 'bx-show'
                                "
                                label="Konfirmasi Password Baru"
                                placeholder="············"
                                @click:append-inner="
                                  isConfirmPasswordVisible =
                                    !isConfirmPasswordVisible
                                "
                              />
                            </VCol>
                          </VRow>
                        </v-container>
                      </v-card-text>
                      <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn
                          color="blue-darken-1"
                          variant="text"
                          @click="dialog[item.id_bayi] = false"
                        >
                          Close
                        </v-btn>
                        <v-btn
                          color="blue-darken-1"
                          variant="text"
                          @click="putData(index)"
                        >
                          Save
                        </v-btn>
                      </v-card-actions>
                    </v-card>
                  </v-dialog>
                  <!-- <VBtn> </VBtn> -->
                  <VBtn
                    class="ml-2"
                    color="error"
                    @click="deleteData(item.id_bayi)"
                  >
                    <v-icon>bx-trash</v-icon>
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
import config from "@/@core/config.vue";
import Swal from "sweetalert2";

export default {
  data() {
    return {
      dialog: [],
      dataAdmin: [],
      page: 1,
      isNewPasswordVisible: false,
      isConfirmPasswordVisible: false,
      newPassword: null,
      confirmPassword: null,
      kategori: "PELINDUNG",
    };
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
    async putData(indexAdmin) {
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
        }
        dialog[this.dataAdmin[indexAdmin].id_admin] = false;
      } catch (get) {
        const errorMessage = Object.values(get.response.data.errors).join(
          " - "
        );
        await Swal.fire({
          toast: true,
          position: "top",
          iconColor: "white",
          color: "white",
          background: "rgb(var(--v-theme-error))",
          showConfirmButton: false,
          timerProgressBar: true,
          timer: 1500,
          icon: "error",
          title: errorMessage,
        });
      }
    },

    async deleteData(id_admin) {
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
          this.fetchData();
        }
      }
    },
  },
  mounted() {
    this.fetchData();
  },
};
</script>
