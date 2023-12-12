<template>
  <v-footer
    class="bg-indigo-lighten-1 text-center d-flex flex-column bg-primary"
    style="margin-top: 100px"
  >
    <div class="">
      <v-btn
        v-for="icon in icons"
        :key="icon"
        class="mx-4"
        :icon="icon"
        variant="text"
        color="ffffff"
      ></v-btn>
    </div>

    <div class="pt-0">
      Alamat Posyandu
      <p>
        Jl. Mutiara Pluit No.40, RT.002/RW.009, Periuk, Tangerang City, Banten
        15131
      </p>
    </div>

    <div>
      <strong> CopyRight PosyanduMelati</strong>
    </div>
  </v-footer>
</template>
<script>
export default {
  data: () => ({
    icons: ["mdi-facebook", "mdi-twitter", "mdi-linkedin", "mdi-instagram"],
  }),
};
</script>
