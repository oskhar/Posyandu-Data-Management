<script setup>
// 👉 Images
import wallet from "@/assets/images/pages/1.png";

const vos = ref("mehh");
vos.value = "hai";
console.log(vos.value);
</script>

<template>
  <VRow>
    <VCol>
      <VBtn class="float-right"> Upload Image </VBtn>
    </VCol>
  </VRow>
  <VRow>
    <VCol cols="12" md="4">
      <img style="width: 100%" :src="wallet" alt="image" />
    </VCol>
    <VCol cols="12" md="4">
      <img style="width: 100%" :src="wallet" alt="image" />
    </VCol>
    <VCol cols="12" md="4">
      <img style="width: 100%" :src="wallet" alt="image" />
    </VCol>
  </VRow>
</template>
