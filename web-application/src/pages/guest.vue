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
        <strong style="font-size: 35px">KATEGORI - KATEGORI</strong>
      </div>
      <div class="card-tiga">
        <v-card class="mx-auto" width="380">
          <!-- <v-img
            class="align-end text-white"
            height="200"
            src="https://cdn.vuetifyjs.com/images/cards/docks.jpg"
            cover
          >
          </v-img> -->
          <center>
            <svg
              xmlns="http://www.w3.org/2000/svg"
              width="224"
              height="224"
              viewBox="0 0 24 24"
              style="fill: rgba(84, 104, 255, 1); transform: ; msfilter; "
            >
              <path
                d="M19 4h-2V2h-2v2H9V2H7v2H5c-1.103 0-2 .897-2 2v14c0 1.103.897 2 2 2h14c1.103 0 2-.897 2-2V6c0-1.103-.897-2-2-2zm-3.648 11.711L12.002 19l-3.349-3.289a2.129 2.129 0 0 1 0-3.069 2.224 2.224 0 0 1 3.125 0l.224.219.224-.219a2.225 2.225 0 0 1 3.126 0 2.129 2.129 0 0 1 0 3.069zM19 9H5V7h14v2z"
              ></path>
            </svg>
          </center>

          <h2 class="pt-4 text-center" style="margin: 20px">
            <strong>EDUKASI</strong>
          </h2>
        </v-card>

        <v-card class="mx-auto" width="380">
          <!-- <v-img
            class="align-end text-white"
            height="200"
            src="https://cdn.vuetifyjs.com/images/cards/docks.jpg"
            cover
          >
          </v-img> -->

          <center>
            <svg
              xmlns="http://www.w3.org/2000/svg"
              width="224"
              height="224"
              viewBox="0 0 24 24"
              style="
                fill: rgba(84, 104, 255, 1);
                transform: scaleY(-1);
                msfilter: progid:DXImageTransform.Microsoft.BasicImage(rotation=2, mirror=1);
              "
            >
              <path
                d="M20 3H4c-1.103 0-2 .897-2 2v14c0 1.103.897 2 2 2h16c1.103 0 2-.897 2-2V5c0-1.103-.897-2-2-2zm-1 4v2h-5V7h5zm-5 4h5v2h-5v-2zM4 19V5h7v14H4z"
              ></path>
            </svg>
          </center>

          <h2 class="pt-4 text-center" style="margin: 20px">
            <strong>BERITA & ACARA</strong>
          </h2>
        </v-card>

        <v-card class="mx-auto" width="380">
          <!-- <v-img
            class="align-end text-white"
            height="200"
            src="https://cdn.vuetifyjs.com/images/cards/docks.jpg"
            cover
          >
          </v-img> -->
          <center>
            <svg
              xmlns="http://www.w3.org/2000/svg"
              width="224"
              height="224"
              viewBox="0 0 24 24"
              style="fill: rgba(84, 104, 255, 1); transform: ; msfilter: "
            >
              <path
                d="m12.223 11.641-.223.22-.224-.22a2.224 2.224 0 0 0-3.125 0 2.13 2.13 0 0 0 0 3.07L12 18l3.349-3.289a2.13 2.13 0 0 0 0-3.07 2.225 2.225 0 0 0-3.126 0z"
              ></path>
              <path
                d="m21.707 11.293-9-9a.999.999 0 0 0-1.414 0l-9 9A1 1 0 0 0 3 13h1v7c0 1.103.897 2 2 2h12c1.103 0 2-.897 2-2v-7h1a1 1 0 0 0 .707-1.707zM18.001 20H6v-9.585l6-6 6 6V15l.001 5z"
              ></path>
            </svg>
          </center>

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
