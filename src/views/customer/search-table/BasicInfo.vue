<template>
  <div>
    <a-button type="text" @click="goBack()">Back</a-button>
    <a-tabs default-active-key="1">
      <a-tab-pane key="1" title="Agency Page">
        <agencyPage />
      </a-tab-pane>
      <a-tab-pane key="2" title="Contracts">
        <contractPart />
      </a-tab-pane>
      <a-tab-pane key="3">
        <template #title>Segment</template>
        <segemntPage />
      </a-tab-pane>
      <a-tab-pane key="4">
        <template #title>Account Payable</template>
        <accountPosting />
      </a-tab-pane>
    </a-tabs>
  </div>
</template>

<script lang="ts" setup>
  import { useRouter } from 'vue-router';
  import agencyPage from './components/agencyPage.vue';
  import segemntPage from './components/segmentPage.vue';
  import accountPosting from './components/accountPosting.vue';
  import contractPart from './components/contractPart.vue';

  const router = useRouter();

  const goBack = () => {
    router.push({
      path: '/customer/search-table',
    });
  };
</script>

<script lang="ts">
  export default {};
</script>
