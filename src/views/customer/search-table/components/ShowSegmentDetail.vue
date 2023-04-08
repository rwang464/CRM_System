<template>
  <a-modal
    v-model="visible"
    title="Incentive"
    :footer="false"
    width="70%"
    @cancel="hideModal"
  >
    <a-space direction="vertical" :size="16" style="display: block">
      <a-row class="grid-demo">
        <a-col :span="12">
          <div>Agency Name</div>
        </a-col>
        <a-col :span="12">
          <div
            v-if="
              segmentDetail.value && segmentDetail.value[0] && !loading.value
            "
          >
            {{ segmentDetail.value[0].AgencyName }}
          </div>
          <div v-else>Loading...</div>
        </a-col>
      </a-row>
      <a-row class="grid-demo">
        <a-col :span="12">
          <div>Customer Number</div>
        </a-col>
        <a-col :span="12">
          <div>100123</div>
        </a-col>
      </a-row>
      <a-row class="grid-demo">
        <a-col :span="12">
          <div>Month - Year</div>
        </a-col>
        <a-col :span="12">
          <div>June 2022</div>
        </a-col>
      </a-row>
      <a-row class="grid-demo">
        <a-col :span="12">
          <div>Created at</div>
        </a-col>
        <a-col :span="12">
          <div>2023-03-29 00:00:00</div>
        </a-col>
      </a-row>
      <a-divider />
      <a-row class="grid-demo">
        <a-col :span="6">
          <div>Item Description</div>
        </a-col>
        <a-col :span="6">
          <div>Segments</div>
        </a-col>
        <a-col :span="6">
          <div>Rate</div>
        </a-col>
        <a-col :span="6">
          <div>Item Total</div>
        </a-col>
      </a-row>
      <a-row class="grid-demo">
        <a-col :span="6">
          <div>Incentive For International Segments</div>
        </a-col>
        <a-col :span="6">
          <div>13</div>
        </a-col>
        <a-col :span="6">
          <div>$1.00</div>
        </a-col>
        <a-col :span="6">
          <div>13</div>
        </a-col>
      </a-row>
      <a-row class="grid-demo">
        <a-col :span="6">
          <div>Incentive For Domestic Segments</div>
        </a-col>
        <a-col :span="6">
          <div>13</div>
        </a-col>
        <a-col :span="6">
          <div>$1.00</div>
        </a-col>
        <a-col :span="6">
          <div>13</div>
        </a-col>
      </a-row>
      <a-row class="grid-demo">
        <a-col :span="6">
          <div>Total</div>
        </a-col>
        <a-col :span="6">
          <div></div>
        </a-col>
        <a-col :span="6">
          <div></div>
        </a-col>
        <a-col :span="6">
          <div>$26.00 USD</div>
        </a-col>
      </a-row>
    </a-space>
    <a-button @click="printSegmentDetail">Print Segment Detail</a-button>
  </a-modal>
</template>

<script lang="ts" setup>
  import { ref, watch } from 'vue';
  import { getCustomer } from '@/api/list';

  const props = defineProps({
    record: {
      type: Object,
      default: () => ({}),
    },
  });

  const loading = ref(true);

  interface SegmentDetailItem {
    AgencyName: string;
    // 其他需要的属性
  }
  const visible = ref(false);
  const segmentDetail = ref<SegmentDetailItem[]>([]);

  const printSegmentDetail = () => {
    console.log('segmentDetail:', segmentDetail.value[0]);
  };
  const hideModal = () => {
    visible.value = false;
  };

  const getSegmentDetail = async () => {
    if (props.record.segment_id) {
      const segmentId = props.record.segment_id;
      try {
        const response = await getCustomer(
          `http://localhost:3000/src/views/api/api.php?action=segmentInfo&segmentId=${segmentId}`
        );
        segmentDetail.value = [];
        segmentDetail.value = Array.isArray(response) ? response : [response];
        console.log(segmentDetail.value[0].AgencyName);
      } catch (error) {
        console.log(error);
      } finally {
        loading.value = false;
      }
    }
  };
  watch(
    () => props.record.segment_id,
    async (newSegmentId, oldSegmentId) => {
      if (newSegmentId) {
        console.log(newSegmentId);
        await getSegmentDetail();
      }
    },
    {
      immediate: true,
    }
  );
</script>
