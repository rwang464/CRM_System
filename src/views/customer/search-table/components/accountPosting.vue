<template>
  <div>
    <a-space direction="vertical" size="large" fill>
      <a-table
        row-key="name"
        :columns="(cloneColumns as TableColumnData[])"
        :data="renderData"
        :row-selection="rowSelection"
      >
        <template #index="{ rowIndex }">
          {{ rowIndex + 1 + (pagination.current - 1) * pagination.pageSize }}
        </template>
        <template #paidStatus="{ record }">
          <div>
            <a-switch v-model="record.paidStatus" />
            <span style="margin-left: 10px">Unpaid</span>
          </div>
        </template>
        <template #actionBuild="{ record }">
          <a-button
            v-if="record.actionBuild.includes('Mail')"
            @click="showEmail(record)"
          >
            <template #icon>
              <icon-email />
            </template>
          </a-button>
          <a-button
            v-if="record.actionBuild.includes('Pdf')"
            @click="previewPdf(record)"
          >
            <template #icon>
              <icon-file-pdf />
            </template>
          </a-button>
          <send-email-modal
            v-model:visible="isShowSendEmailModal"
            :record="currentRecord"
          />
          <!-- <PDFPreview
            :trigger-render="pdfRenderTrigger"
            :record="currentRecord"
          /> -->

          <a-button v-if="record.actionBuild.includes('Connection')">
            <template #icon>
              <icon-relation />
            </template>
          </a-button>
          <a-button v-if="record.actionBuild.includes('Info')">
            <template #icon>
              <icon-info-circle-fill />
            </template>
          </a-button>
        </template>
      </a-table>
    </a-space>
  </div>
</template>

<script lang="ts" setup>
  import { useRouter } from 'vue-router';
  import type { TableColumnData } from '@arco-design/web-vue/es/table/interface';
  import { computed, ref, reactive, watch } from 'vue';
  import { Pagination } from '@/types/global';
  import cloneDeep from 'lodash/cloneDeep';
  import { PolicyRecord } from '@/api/list';
  import * as pdfjsLib from 'pdfjs-dist/legacy/build/pdf';
  import SendEmailModal from './SendEmailModal.vue';

  const workerURL = new URL(
    'pdfjs-dist/legacy/build/pdf.worker.js',
    import.meta.url
  );
  pdfjsLib.GlobalWorkerOptions.workerSrc = workerURL.href;
  type Column = TableColumnData & { checked?: true };
  const renderData = ref<PolicyRecord[]>([]);
  const cloneColumns = ref<Column[]>([]);
  const showColumns = ref<Column[]>([]);
  const basePagination: Pagination = {
    current: 1,
    pageSize: 20,
  };
  const pagination = reactive({
    ...basePagination,
  });
  const rowSelection = reactive({
    type: 'checkbox',
    showCheckedAll: true,
  });

  const columns = computed<TableColumnData[]>(() => [
    {
      title: 'Agency',
      dataIndex: 'agencyName',
    },
    {
      title: 'Period',
      dataIndex: 'periodTime',
    },
    {
      title: 'Amount',
      dataIndex: 'moneyAmount',
    },
    {
      title: 'Paid',
      dataIndex: 'paidStatus',
      slotName: 'paidStatus',
    },
    {
      title: 'Action',
      dataIndex: 'actionBuild',
      slotName: 'actionBuild',
    },
  ]);

  const accountPostingData = reactive<PolicyRecord[]>([
    {
      agencyName: 'TestOne',
      periodTime: '20',
      moneyAmount: '20',
      paidStatus: false,
      actionBuild: ['Mail', 'Pdf', 'Connection', 'Info'] as string[],
    },
  ]);

  renderData.value = accountPostingData;

  const isShowSendEmailModal = ref(false); // 是否显示发送邮件的模态框组件
  const currentRecord = ref({}); // 当前点击的数据
  // const isShowPDFPreviewModal = ref(false);

  const showEmail = (record: string) => {
    currentRecord.value = record;
    isShowSendEmailModal.value = true;
  };
  const pdfRenderTrigger = ref(0);

  const router = useRouter();

  const previewPdf = (record: string) => {
    currentRecord.value = record;
    pdfRenderTrigger.value += 1;
    const pdfUrl = '/api/atatravel.space/image/file.pdf';
    window.open(
      `${window.location.origin}/pdf-viewer?pdfUrl=${encodeURIComponent(
        pdfUrl
      )}`
    );
  };

  watch(
    () => columns.value,
    (val) => {
      cloneColumns.value = cloneDeep(val);
      cloneColumns.value.forEach((item, index) => {
        item.checked = true;
      });
      showColumns.value = cloneDeep(cloneColumns.value);
    },
    { deep: true, immediate: true }
  );
</script>
