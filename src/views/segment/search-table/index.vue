<template>
  <div class="container">
    <a-layout style="height: 40px"> </a-layout>
    <a-row>
      <a-col :flex="1">
        <a-form
          :model="segmentModel"
          :label-col-props="{ span: 6 }"
          :wrapper-col-props="{ span: 18 }"
          label-align="left"
        >
          <a-row :gutter="16">
            <a-col :span="8">
              <a-form-item
                field="segmentDate"
                :label="$t('searchTable.form.date')"
              >
                <a-month-picker v-model="selectedMonth" style="width: 200px" />
              </a-form-item>
            </a-col>
            <a-col :span="8">
              <a-button type="text" class="export-button" @click="exportCSV()">
                <template #icon>
                  <icon-download />
                </template>
                <template #default>EXPORT</template>
              </a-button>
            </a-col>
          </a-row>
        </a-form>
      </a-col>
    </a-row>
    <a-table
      :columns="(cloneColumns as TableColumnData[])"
      :sticky-header="100"
      :data="renderData"
      @page-change="onPageChange"
    >
      <template #index="{ rowIndex }">
        {{ rowIndex + 1 + (pagination.current - 1) * pagination.pageSize }}
      </template>

      <template #detail="{ record }">
        <a-button
          v-if="record.detail === ''"
          type="text"
          @click="showSegment(record)"
        >
          view
        </a-button>

        <show-segment-detail
          v-model:visible="isShowSegmentModal"
          :record="currentRecord"
        />
      </template>
    </a-table>
  </div>
</template>

<script lang="ts" setup>
  //   import useLoading from '@/hooks/loading';
  import type { TableColumnData } from '@arco-design/web-vue/es/table/interface';
  import { computed, ref, reactive, watch } from 'vue';
  import useLoading from '@/hooks/loading';
  import { Pagination } from '@/types/global';
  import cloneDeep from 'lodash/cloneDeep';
  import { PolicyRecord, PolicyParams, getCustomer } from '@/api/list';
  import ShowSegmentDetail from '../../customer/search-table/components/ShowSegmentDetail.vue';

  type Column = TableColumnData & { checked?: true };
  const { setLoading } = useLoading(true);
  const renderData = ref<PolicyRecord[]>([]);
  const cloneColumns = ref<Column[]>([]);
  const basePagination: Pagination = {
    current: 1,
    pageSize: 20,
  };
  const pagination = reactive({
    ...basePagination,
  });
  const segmentFormModel = () => {
    return {
      segmentDate: '',
    };
  };

  const showColumns = ref<Column[]>([]);
  const segmentModel = ref(segmentFormModel());

  const columns = computed<TableColumnData[]>(() => [
    {
      title: 'Agency',
      dataIndex: 'agencyName',
      sortable: {
        sortDirections: ['ascend', 'descend'],
      },
    },
    {
      title: 'Customer #',
      dataIndex: 'customerNumber',
      sortable: {
        sortDirections: ['ascend', 'descend'],
      },
    },
    {
      title: 'Year',
      dataIndex: 'segmentYear',
      sortable: {
        sortDirections: ['ascend', 'descend'],
      },
    },
    {
      title: 'Month',
      dataIndex: 'segmentMonth',
      sortable: {
        sortDirections: ['ascend', 'descend'],
      },
    },
    {
      title: 'Total',
      dataIndex: 'segmentTotal',
      sortable: {
        sortDirections: ['ascend', 'descend'],
      },
    },
    {
      title: 'Domestic Segment',
      dataIndex: 'domesticSegment',
      sortable: {
        sortDirections: ['ascend', 'descend'],
      },
    },
    {
      title: 'Details',
      dataIndex: 'detail',
      slotName: 'detail',
    },
  ]);
  const isShowSegmentModal = ref(false);
  const currentRecord = ref({});

  const showSegment = (record: string) => {
    currentRecord.value = record;
    isShowSegmentModal.value = true;
  };

  const segmentData = ref<PolicyRecord[]>([
    {
      agencyName: 'TestOne',
      customerNumber: 123,
      segmentYear: '2023',
      segmentMonth: 3,
      segmentTotal: '100',
      domesticSegment: 90,
      detail: '',
    },
  ]);
  renderData.value = segmentData.value;

  const fetchData = async (
    params: PolicyParams = { current: 1, pageSize: 20 }
  ) => {
    setLoading(true);
    try {
      console.log(renderData);
    } catch (error) {
      // you can report use errorHandler or other
    } finally {
      setLoading(false);
    }
  };

  function convertTableToCSV(data) {
    const header = [
      'Agency',
      'Customer #',
      'Year',
      'Month',
      'Total',
      'Domestic Segment',
    ];

    const csvRows = [];

    // 添加表头
    csvRows.push(header.join(','));

    // 添加数据
    data.forEach((row) => {
      const rowData = [
        row.agencyName,
        row.customerNumber,
        row.segmentYear,
        row.segmentMonth,
        row.segmentTotal,
        row.domesticSegment,
      ];
      csvRows.push(rowData.join(','));
    });

    return csvRows.join('\n');
  }

  const exportCSV = () => {
    const data = computed(() => renderData.value);

    const csvContent = convertTableToCSV(data.value);

    // 创建一个 Blob 对象，用于存储 CSV 文件内容
    const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });

    // 创建一个下载链接
    const link = document.createElement('a');
    const url = URL.createObjectURL(blob);
    link.href = url;
    link.setAttribute('download', 'export.csv');
    document.body.appendChild(link);

    // 模拟点击事件以触发下载
    link.click();

    // 清理 DOM 和释放内存
    document.body.removeChild(link);
    URL.revokeObjectURL(url);
  };

  const onPageChange = (current: number) => {
    fetchData({ ...basePagination, current });
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

<script lang="ts">
  export default {
    data() {
      return {
        selectedMonth: new Date(),
      };
    },
  };
</script>

<style scoped lang="less">
  .export-button {
    margin-left: 150%;
  }

  .container {
    padding: 0 20px 20px;
  }
</style>
