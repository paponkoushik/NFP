<script setup>
import { ref, onMounted, watch } from "vue";
import { useDashboardStore } from "@/stores/DashboardStore";
import { useUserStore} from "@/stores/UserStore";
import { useUrlFunc } from "@/composables/useUrlFunc.js";
import NfpFilter from "@/components/Nfp/NfpFilter";

import UserList from "@/components/User";


const store = useUserStore();

onMounted(() => {
  store.nfpDashboard();
});
</script>

<template>

  <div class="row">

    <div class="col-md-4">

<NfpFilter></NfpFilter>
<!-- Add more cards here -->
</div>

    <div class="col-md-12">
        <div class="row">
          <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
            <div class="card">
              <div class="card-body pb-0">
                <span class="d-block fw-semibold mb-1">Total Registration</span>
                <h3 class="card-title mb-1" v-if="store.cardData.getTotalRegistration">{{ store.cardData.getTotalRegistration }}</h3>
                <h3 class="card-title mb-1" v-else>0</h3>
              </div>
            </div>
          </div>
          <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
            <div class="card">
              <div class="card-body pb-0">
                <span class="d-block fw-semibold mb-1">Total Nfp Registration</span>
                <h3 class="card-title mb-1" v-if="store.cardData.getTotalNfpRegistration">{{ store.cardData.getTotalNfpRegistration }}</h3>
                <h3 class="card-title mb-1" v-else>0</h3>
              </div>
            </div>
          </div>
          <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
            <div class="card">
              <div class="card-body pb-0">
                <span class="d-block fw-semibold mb-1">Individual Registration</span>
                <h3 class="card-title mb-1" v-if="store.cardData.getTotalIndiRegistration">{{ store.cardData.getTotalIndiRegistration }}</h3>
                <h3 class="card-title mb-1" v-else>0</h3>
              </div>
            </div>
          </div>
          <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
            <div class="card">
              <div class="card-body pb-0">
                <span class="d-block fw-semibold mb-1">Charity Registration</span>
                <h3 class="card-title mb-1" v-if="store.cardData.getTotalCharityRegistration">{{ store.cardData.getTotalCharityRegistration }}</h3>
                <h3 class="card-title mb-1" v-else>0</h3>
              </div>
            </div>
          </div>
          <!-- Add more cards here -->
        </div>
      </div>
    <!-- Total Revenue -->
    <div class="col-12 col-lg-12 order-2 order-md-3 order-lg-2 mb-4">
      <div class="card">
        <div class="row row-bordered g-0">
          <div class="col-md-12">
            <UserList></UserList>
          </div>
        </div>
      </div>
    </div>
    <!--/ Total Revenue -->

</div>

</template>


