<script>
// 👉 Images
import wallet from "@/assets/images/pages/1.png";
export default {
  setup() {
    const refInputEl = ref();

    const projectImage = {
      imageValue: "",
    };

    const projectImageLocal = ref({ ...projectImage });

    const resetAvatar = () => {
      projectImageLocal.value.imageValue = projectImage.imageValue;
    };

    const changeAvatar = (file) => {
      const fileReader = new FileReader();
      const { files } = file.target;
      if (files && files.length) {
        // Validasi tipe file sebelum menampilkan gambarnya
        if (
          files[0].type === "image/jpeg" ||
          files[0].type === "image/png" ||
          files[0].type === "image/jpg"
        ) {
          fileReader.readAsDataURL(files[0]);
          fileReader.onload = () => {
            if (typeof fileReader.result === "string") {
              projectImageLocal.value.imageValue = fileReader.result;
            }
          };
        } else {
          // Tindakan jika tipe file tidak valid
          alert("File harus berupa gambar dengan tipe jpeg, png, atau jpg.");
          resetAvatar();
        }
      }
    };
    return {
      refInputEl,
      projectImage,
      projectImageLocal,
      resetAvatar,
      changeAvatar,
      wallet,
    };
  },
};
</script>

<template>
  <VRow>
    <VCol>
      <div class="d-flex flex-wrap gap-2 float-right">
        <VBtn id="gambar" color="primary" @click="refInputEl?.click()">
          <VIcon icon="bx-cloud-upload" class="d-sm-none" />
          <span class="d-none d-sm-block">Upload new photo</span>
        </VBtn>

        <input
          ref="refInputEl"
          type="file"
          name="file"
          accept=".jpeg,.png,.jpg"
          hidden
          @change="changeAvatar"
        />
      </div>
    </VCol>
  </VRow>
  <VRow>
    <VCol cols="12" md="3" sm="6">
      <img style="width: 100%" :src="wallet" alt="image" />
    </VCol>
    <VCol cols="12" md="3" sm="6">
      <img style="width: 100%" :src="wallet" alt="image" />
    </VCol>
    <VCol cols="12" md="3" sm="6">
      <img style="width: 100%" :src="wallet" alt="image" />
    </VCol>
    <VCol cols="12" md="3" sm="6">
      <img style="width: 100%" :src="wallet" alt="image" />
    </VCol>
  </VRow>
</template>
