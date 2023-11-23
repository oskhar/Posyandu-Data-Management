<script setup>
import AnalyticsCongratulations from "@/views/dashboard/AnalyticsCongratulations.vue";
import AnalyticsFinanceTabs from "@/views/dashboard/AnalyticsFinanceTab.vue";
import AnalyticsOrderStatistics from "@/views/dashboard/AnalyticsOrderStatistics.vue";
import AnalyticsProfitReport from "@/views/dashboard/AnalyticsProfitReport.vue";
import AnalyticsTotalRevenue from "@/views/dashboard/AnalyticsTotalRevenue.vue";
import AnalyticsTransactions from "@/views/dashboard/AnalyticsTransactions.vue";

// 👉 Images
import chart from "@images/cards/chart-success.png";
import posyandu from "@images/pages/3.png";
import langit from "@images/pages/2.png";

const jumlahBerita = 1;
const jumlahEdukasi = 90;
const jumlahGambar = 72;
const jumlahPengurus = 69;
</script>

<template>
  <VRow>
    <VCol cols="12">
      <h1 class="text-primary">POSYANDU MELATI</h1>
    </VCol>
    <VCol cols="12">
      <img
        style="width: 100%; height: 500px; object-fit: cover"
        :src="posyandu"
        alt=""
      />
    </VCol>
    <VCol md="3" sm="12">
      <img
        style="width: 100%; height: 250px; object-fit: cover"
        :src="posyandu"
        alt=""
      />
    </VCol>
    <VCol md="9" sm="12">
      <VCard class="text-center text-sm-start">
        <VRow no-gutters>
          <VCol cols="12">
            <VCardItem>
              <VCardTitle class="text-md-h5 text-primary">
                PROFIL POSYANDU
              </VCardTitle>
            </VCardItem>

            <VCardText>
              <span>
                Lorem ipsum dolor sit amet consectetur adipisicing elit.
                Voluptatum fugit explicabo fugiat quidem nobis praesentium
                facere. Expedita tempore architecto quo suscipit, adipisci
                consequuntur sed ipsa labore fugit assumenda ratione possimus
                vero minus quae eos nesciunt nulla perferendis ad totam laborum.
                Neque ad corrupti veritatis quidem nostrum, nesciunt repudiandae
                inventore odio quod hic maiores consequuntur minima voluptatum.
                Adipisci hic debitis est temporibus possimus similique rem non,
                fugiat fuga vel doloremque eligendi ut nulla ea rerum iste
                accusamus doloribus! Hic similique possimus repellendus porro
                reiciendis impedit quisquam, tempora exercitationem rem pariatur
                maiores. Dolorum laboriosam fugiat libero fuga voluptatum illum
                quidem, culpa minima!
                <br />
                <br />
                Semoga dapat memudahkan masyarakat
              </span>
              <br />
            </VCardText>
          </VCol>
        </VRow>
      </VCard>
    </VCol>
    <VCol cols="12">
      <VCard class="text-center text-sm-start">
        <VRow no-gutters>
          <VCol cols="12">
            <VCardItem>
              <VCardTitle class="text-md-h5 text-primary"> VISI </VCardTitle>
            </VCardItem>

            <VCardText>
              <span>
                Lorem ipsum dolor sit amet consectetur adipisicing elit.
                Voluptatum fugit explicabo fugiat quidem nobis praesentium
                facere. Expedita tempore architecto quo suscipit, adipisci
                consequuntur sed ipsa labore fugit assumenda ratione possimus
                vero minus quae eos nesciunt nulla perferendis ad totam laborum.
                Neque ad corrupti veritatis quidem nostrum, nesciunt repudiandae
                inventore odio quod hic maiores consequuntur minima voluptatum.
                Adipisci hic debitis est temporibus possimus similique rem non,
                fugiat fuga vel doloremque eligendi ut nulla ea rerum iste
                accusamus doloribus! Hic similique possimus repellendus porro
                reiciendis impedit quisquam, tempora exercitationem rem pariatur
                maiores. Dolorum laboriosam fugiat libero fuga voluptatum illum
                quidem, culpa minima!
                <br />
                <br />
                Semoga dapat memudahkan masyarakat
              </span>
              <br />
            </VCardText>
          </VCol>
        </VRow>
      </VCard>
    </VCol>
    <VCol cols="12">
      <VCard class="text-center text-sm-start">
        <VRow no-gutters>
          <VCol cols="12">
            <VCardItem>
              <VCardTitle class="text-md-h5 text-primary"> MISI </VCardTitle>
            </VCardItem>

            <VCardText>
              <span>
                Lorem ipsum dolor sit amet consectetur adipisicing elit.
                Voluptatum fugit explicabo fugiat quidem nobis praesentium
                facere. Expedita tempore architecto quo suscipit, adipisci
                consequuntur sed ipsa labore fugit assumenda ratione possimus
                vero minus quae eos nesciunt nulla perferendis ad totam laborum.
                Neque ad corrupti veritatis quidem nostrum, nesciunt repudiandae
                inventore odio quod hic maiores consequuntur minima voluptatum.
                Adipisci hic debitis est temporibus possimus similique rem non,
                fugiat fuga vel doloremque eligendi ut nulla ea rerum iste
                accusamus doloribus! Hic similique possimus repellendus porro
                reiciendis impedit quisquam, tempora exercitationem rem pariatur
                maiores. Dolorum laboriosam fugiat libero fuga voluptatum illum
                quidem, culpa minima!
                <br />
                <br />
                Semoga dapat memudahkan masyarakat
              </span>
              <br />
            </VCardText>
          </VCol>
        </VRow>
      </VCard>
    </VCol>
  </VRow>
</template>
