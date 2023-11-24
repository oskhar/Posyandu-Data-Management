<script setup>
import { VDataTable } from "vuetify/labs/VDataTable";

const isCurrentPasswordVisible = ref(false);
const isNewPasswordVisible = ref(false);
const isConfirmPasswordVisible = ref(false);
const currentPassword = ref("12345678");
const newPassword = ref("87654321");
const confirmPassword = ref("87654321");

const passwordRequirements = ["Minimal 8 karakter"];
</script>

<template>
  <VRow>
    <!-- SECTION: Change Password -->
    <VCol cols="12">
      <VCard title="Ubah Password">
        <VForm>
          <VCardText>
            <!-- 👉 Current Password -->
            <VRow>
              <VCol cols="12" md="6">
                <!-- 👉 current password -->
                <VTextField
                  v-model="currentPassword"
                  :type="isCurrentPasswordVisible ? 'text' : 'password'"
                  :append-inner-icon="
                    isCurrentPasswordVisible ? 'bx-hide' : 'bx-show'
                  "
                  label="Password Saat Ini"
                  placeholder="············"
                  @click:append-inner="
                    isCurrentPasswordVisible = !isCurrentPasswordVisible
                  "
                />
              </VCol>
            </VRow>

            <!-- 👉 New Password -->
            <VRow>
              <VCol cols="12" md="6">
                <!-- 👉 new password -->
                <VTextField
                  v-model="newPassword"
                  :type="isNewPasswordVisible ? 'text' : 'password'"
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

              <VCol cols="12" md="6">
                <!-- 👉 confirm password -->
                <VTextField
                  v-model="confirmPassword"
                  :type="isConfirmPasswordVisible ? 'text' : 'password'"
                  :append-inner-icon="
                    isConfirmPasswordVisible ? 'bx-hide' : 'bx-show'
                  "
                  label="Konfirmasi Password Baru"
                  placeholder="············"
                  @click:append-inner="
                    isConfirmPasswordVisible = !isConfirmPasswordVisible
                  "
                />
              </VCol>
            </VRow>
          </VCardText>

          <!-- 👉 Password Requirements -->
          <VCardText>
            <p class="text-base font-weight-medium mt-2">Syarat Password:</p>

            <ul class="d-flex flex-column gap-y-3">
              <li
                v-for="item in passwordRequirements"
                :key="item"
                class="d-flex"
              >
                <div>
                  <VIcon size="7" icon="bxs-circle" class="me-3" />
                </div>
                <span class="font-weight-medium">{{ item }}</span>
              </li>
            </ul>
          </VCardText>

          <!-- 👉 Action Buttons -->
          <VCardText class="d-flex flex-wrap gap-4">
            <VBtn>Simpan Perubahan</VBtn>

            <VBtn type="reset" color="secondary" variant="tonal"> Reset </VBtn>
          </VCardText>
        </VForm>
      </VCard>
    </VCol>
    <!-- !SECTION -->

    <!-- SECTION Two-steps verification -->
    <!-- <VCol cols="12">
      <VCard title="Two-steps verification">
        <VCardText>
          <p class="font-weight-semibold">
            Two factor authentication is not enabled yet.
          </p>
          <p>
            Two-factor authentication adds an additional layer of security to
            your account by requiring more than just a password to log in.
            <a href="javascript:void(0)" class="text-decoration-none"
              >Learn more.</a
            >
          </p>

          <VBtn> Enable 2FA </VBtn>
        </VCardText>
      </VCard>
    </VCol> -->
    <!-- !SECTION -->

    <!-- <VCol cols="12">
      SECTION: Create an API key
      <VCard title="Create an API key">
        <VRow>
          👉 Choose API Key
          <VCol cols="12" md="5" order-md="0" order="1">
            <VCardText>
              <VForm @submit.prevent="() => {}">
                <VRow>
                  👉 Choose API Key
                  <VCol cols="12">
                    <VSelect
                      label="Choose the API key type you want to create"
                      placeholder="Select API key type"
                      :items="[
                        'Full Control',
                        'Modify',
                        'Read & Execute',
                        'List Folder Contents',
                        'Read Only',
                        'Read & Write',
                      ]"
                    />
                  </VCol>

                  👉 Name the API Key
                  <VCol cols="12">
                    <VTextField
                      label="Name the API key"
                      placeholder="Name the API key"
                    />
                  </VCol>

                  👉 Create Key Button
                  <VCol cols="12">
                    <VBtn type="submit" block> Create Key </VBtn>
                  </VCol>
                </VRow>
              </VForm>
            </VCardText>
          </VCol>
        </VRow>
      </VCard>
      !SECTION
    </VCol> -->

    <!-- <VCol cols="12">
      SECTION: API Keys List
      <VCard title="API Key List &amp; Access">
        <VCardText>
          An API key is a simple encrypted string that identifies an application
          without any principal. They are useful for accessing public data
          anonymously, and are used to associate API requests with your project
          for quota and billing.
        </VCardText>

        👉 Server Status
        <VCardText class="d-flex flex-column gap-y-4">
          <div
            v-for="serverKey in serverKeys"
            :key="serverKey.key"
            class="bg-var-theme-background pa-4"
          >
            <div class="d-flex align-center flex-wrap mb-3">
              <h6 class="text-h6 mb-0 me-3">
                {{ serverKey.name }}
              </h6>
              <VChip label color="primary" size="small">
                {{ serverKey.permission }}
              </VChip>
            </div>
            <p class="text-base font-weight-medium">
              <span class="me-3">{{ serverKey.key }}</span>
              <VIcon :size="18" icon="bx-copy" class="cursor-pointer" />
            </p>
            <span>Created on {{ serverKey.createdOn }}</span>
          </div>
        </VCardText>
      </VCard>
      !SECTION
    </VCol> -->

    <!-- SECTION Recent Devices -->
    <!-- <VCol cols="12">
      👉 Table
      <VCard title="Recent Devices">
        <VDataTable
          :headers="recentDevicesHeaders"
          :items="recentDevices"
          class="text-no-wrap rounded-0 text-sm"
        >
          <template #item.browser="{ item }">
            <div class="d-flex">
              <VIcon
                start
                :icon="item.raw.deviceIcon.icon"
                :color="item.raw.deviceIcon.color"
              />
              <span class="text-high-emphasis text-base">
                {{ item.raw.browser }}
              </span>
            </div>
          </template>
          TODO Refactor this after vuetify provides proper solution for removing default footer
          <template #bottom />
        </VDataTable>
      </VCard>
    </VCol> -->
    <!-- !SECTION -->
  </VRow>
</template>
