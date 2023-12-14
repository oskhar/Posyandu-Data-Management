<script setup>
import langit from "@images/pages/2.png";
import cardEdukasi from "./card-edukasi.vue";
import cardBeritaAcara from "./card-berita-acara.vue";
import tentangGuest from "./tentang-guest.vue";
import footerGuest from "./footer-guest.vue";
</script>

<template>
  <RouterView />
  <div class="container">
    <div class="container-dua d-flex" style="justify-content: space-between">
      <div>
        <router-link to="/">Logo</router-link>
      </div>
      <router-link to="./login">
        <VBtn> Log in </VBtn>
      </router-link>
    </div>

    <img
      class="mt-5"
      style="width: 100%; height: 500px; object-fit: cover"
      :src="langit"
      alt=""
    />

    <!-- CARD 3 -->
    <div class="card">
      <div class="text-center" style="margin-top: 200px">
        <strong style="font-size: 35px">JUDUL TIGA CARD</strong>
      </div>
      <div class="card-tiga">
        <v-card class="mx-auto" width="380">
          <v-img
            class="align-end text-white"
            height="200"
            src="https://cdn.vuetifyjs.com/images/cards/docks.jpg"
            cover
          >
          </v-img>

          <h2 class="pt-4 text-center" style="margin: 20px">
            <strong>EDUKASI</strong>
          </h2>
        </v-card>

        <v-card class="mx-auto" width="380">
          <v-img
            class="align-end text-white"
            height="200"
            src="https://cdn.vuetifyjs.com/images/cards/docks.jpg"
            cover
          >
          </v-img>
          <h2 class="pt-4 text-center" style="margin: 20px">
            <strong>BERITA & ACARA</strong>
          </h2>
        </v-card>

        <v-card class="mx-auto" width="380">
          <v-img
            class="align-end text-white"
            height="200"
            src="https://cdn.vuetifyjs.com/images/cards/docks.jpg"
            cover
          >
          </v-img>
          <h2 class="pt-4 text-center" style="margin: 20px">
            <strong>TENTANG POSYANDU</strong>
          </h2>
        </v-card>
      </div>
    </div>
    <cardEdukasi />
    <cardBeritaAcara />
    <tentangGuest />
  </div>
  <footerGuest />
</template>

<script></script>

<style scope>
.container {
  padding: 0 10px;
  margin: 30px;
}

/* card 3 */
.card-tiga {
  display: flex;
  justify-content: space-between;
  margin-top: 50px;
}
</style>
