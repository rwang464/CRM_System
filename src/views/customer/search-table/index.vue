<template>
  <div class="container">
    <div v-if="$route.name !== 'BasicInfo'">
      <Breadcrumb :items="['menu.customer', 'menu.customer.searchTable']" />
      <a-card class="general-card" :title="$t('menu.customer.searchTable')">
        <a-row>
          <a-col :flex="1">
            <a-form
              :model="formModel"
              :label-col-props="{ span: 6 }"
              :wrapper-col-props="{ span: 18 }"
              label-align="left"
            >
              <a-row :gutter="16">
                <a-col :span="8">
                  <a-form-item
                    field="agencyName"
                    :label="$t('searchTable.form.agencyName')"
                  >
                    <a-input
                      v-model="formModel.agencyName"
                      :placeholder="
                        $t('searchTable.form.agencyName.placeholder')
                      "
                      @input="debouncedHandleSearch"
                    />
                  </a-form-item>
                </a-col>
                <a-col :span="8">
                  <a-form-item
                    field="customerNumber"
                    :label="$t('searchTable.customer.number')"
                  >
                    <a-input
                      v-model="formModel.customerNumber"
                      :placeholder="
                        $t('searchTable.customer.number.placeholder')
                      "
                      @input="debouncedHandleCustomerIdSearch"
                    />
                  </a-form-item>
                </a-col>
                <a-col :span="8">
                  <a-form-item
                    field="market"
                    :label="$t('searchTable.form.market')"
                  >
                    <a-select
                      v-model="formModel.market"
                      :options="marketTypeOptions"
                      :placeholder="$t('searchTable.form.selectDefault')"
                      @change="onMarketChange"
                    />
                  </a-form-item>
                </a-col>
                <a-col :span="8">
                  <a-form-item
                    field="country"
                    :label="$t('searchTable.form.country')"
                  >
                    <a-select
                      v-model="formModel.country"
                      :options="countryTypeOptions"
                      :placeholder="$t('searchTable.form.selectDefault')"
                      @change="onCountryChange"
                    />
                  </a-form-item>
                </a-col>
                <a-col :span="8">
                  <a-form-item
                    field="status"
                    :label="$t('searchTable.form.status')"
                  >
                    <a-select
                      v-model="formModel.status"
                      :options="statusOptions"
                      :placeholder="$t('searchTable.form.selectDefault')"
                      @change="onStatusChange"
                    />
                  </a-form-item>
                </a-col>
              </a-row>
            </a-form>
          </a-col>
          <a-divider style="height: 84px" direction="vertical" />
        </a-row>
        <a-divider style="margin-top: 0" />
        <a-row style="margin-bottom: 16px">
          <a-col :span="12">
            <a-space>
              <a-button type="primary" @click="handleClick">
                <template #icon>
                  <icon-plus />
                </template>
                {{ $t('searchTable.operation.create') }}
              </a-button>
              <a-modal
                v-model:visible="visible"
                width="55%"
                @cancel="handleCancel"
                @before-ok="handleBeforeOk"
              >
                <template #title>
                  {{ $t('searchTable.form.title') }}
                </template>
                <a-form :model="formCreated">
                  <a-form-item
                    :label="$t('searchTable.created.customernumber')"
                    required
                  >
                    <a-input-number
                      v-model="formCreated.customerNumber"
                      :placeholder="
                        $t('searchTable.created.customernumber.placeholder')
                      "
                    />
                  </a-form-item>
                  <a-form-item
                    :label="$t('searchTable.created.officeID')"
                    required
                  >
                    <a-input-number
                      v-model="formCreated.officeID"
                      :placeholder="
                        $t('searchTable.created.officeID.placeholder')
                      "
                    />
                  </a-form-item>
                  <a-form-item
                    :label="$t('searchTable.created.amadeus')"
                    required
                  >
                    <a-input-number
                      v-model="formCreated.amadeus"
                      :placeholder="
                        $t('searchTable.created.amadeus.placeholder')
                      "
                    />
                  </a-form-item>
                  <a-form-item
                    v-if="false"
                    :label="$t('searchTable.created.agencyname')"
                    required
                  >
                    <a-input
                      v-model="formCreated.agencyName"
                      :placeholder="
                        $t('searchTable.created.agencyname.placeholder')
                      "
                      :disabled="true"
                    />
                  </a-form-item>

                  <a-form-item
                    :label="$t('searchTable.created.firstname')"
                    required
                  >
                    <a-input
                      v-model="formCreated.firstName"
                      :placeholder="
                        $t('searchTable.created.firstname.placeholder')
                      "
                    />
                  </a-form-item>
                  <a-form-item
                    :label="$t('searchTable.created.lastname')"
                    required
                  >
                    <a-input
                      v-model="formCreated.lastName"
                      :placeholder="
                        $t('searchTable.created.lastname.placeholder')
                      "
                    />
                  </a-form-item>
                  <a-form-item
                    :label="$t('searchTable.created.email')"
                    required
                  >
                    <a-input
                      v-model="formCreated.email"
                      :placeholder="$t('searchTable.created.email.placeholder')"
                    />
                  </a-form-item>
                  <a-form-item
                    :label="$t('searchTable.created.phonenumber')"
                    required
                  >
                    <a-input-number
                      v-model="formCreated.phoneNumber"
                      :placeholder="
                        $t('searchTable.created.phonenumber.placeholder')
                      "
                    />
                  </a-form-item>
                  <a-collapse :default-active-key="[]">
                    <a-collapse-item key="1" header="Advanced">
                      <a-form-item :label="$t('searchTable.created.IATA')">
                        <a-input-number
                          v-model="formCreated.IATA"
                          :placeholder="
                            $t('searchTable.created.IATA.placeholder')
                          "
                        />
                      </a-form-item>
                      <a-form-item
                        :label="$t('searchTable.created.officenumber')"
                      >
                        <a-input-number
                          v-model="formCreated.officeNumber"
                          :placeholder="
                            $t('searchTable.created.officenumber.placeholder')
                          "
                        />
                      </a-form-item>
                      <a-form-item
                        :label="$t('searchTable.created.directusername')"
                      >
                        <a-input
                          v-model="formCreated.directUsername"
                          :placeholder="
                            $t('searchTable.created.directusername.placeholder')
                          "
                        />
                      </a-form-item>
                      <a-form-item
                        :label="$t('searchTable.created.directpassword')"
                      >
                        <a-input
                          v-model="formCreated.directPassword"
                          :placeholder="
                            $t('searchTable.created.directpassword.placeholder')
                          "
                        />
                      </a-form-item>
                      <a-form-item
                        :label="$t('searchTable.created.amadeususername')"
                      >
                        <a-input
                          v-model="formCreated.amadeusUsername"
                          :placeholder="
                            $t(
                              'searchTable.created.amadeususername.placeholder'
                            )
                          "
                        />
                      </a-form-item>
                      <a-form-item
                        :label="$t('searchTable.created.amadeuspassword')"
                      >
                        <a-input
                          v-model="formCreated.amadeusPassword"
                          :placeholder="
                            $t(
                              'searchTable.created.amadeuspassword.placeholder'
                            )
                          "
                        />
                      </a-form-item>
                      <a-form-item
                        :label="$t('searchTable.created.targetmarket')"
                      >
                        <a-select
                          v-model="formCreated.targetMarket"
                          :placeholder="
                            $t('searchTable.created.targetmarket.placeholder')
                          "
                        >
                          <a-option value="China">China</a-option>
                          <a-option value="Africa">Africa</a-option>
                          <a-option value="Europe">Europe</a-option>
                          <a-option value="India">India</a-option>
                          <a-option value="Middle East">Middle East</a-option>
                          <a-option value="South Africa">South Africa</a-option>
                        </a-select>
                      </a-form-item>
                      <a-form-item :label="$t('searchTable.created.language')">
                        <a-select
                          v-model="formCreated.language"
                          :placeholder="
                            $t('searchTable.created.language.placeholder')
                          "
                        >
                          <a-option value="Chinese">Chinese</a-option>
                          <a-option value="English">English</a-option>
                        </a-select>
                      </a-form-item>
                      <a-form-item
                        :label="$t('searchTable.created.agencyaddress')"
                      >
                        <a-input
                          v-model="formCreated.agencyAddress"
                          :placeholder="
                            $t('searchTable.created.agencyaddress.placeholder')
                          "
                        />
                      </a-form-item>
                      <a-form-item :label="$t('searchTable.created.city')">
                        <a-input
                          v-model="formCreated.city"
                          :placeholder="
                            $t('searchTable.created.city.placeholder')
                          "
                        />
                      </a-form-item>
                      <a-form-item :label="$t('searchTable.created.state')">
                        <a-input
                          v-model="formCreated.state"
                          :placeholder="
                            $t('searchTable.created.state.placeholder')
                          "
                        />
                      </a-form-item>
                      <a-form-item
                        :label="$t('searchTable.created.postalcode')"
                      >
                        <a-input
                          v-model="formCreated.postalCode"
                          :placeholder="
                            $t('searchTable.created.postalcode.placeholder')
                          "
                        />
                      </a-form-item>
                      <a-form-item :label="$t('searchTable.created.country')">
                        <a-select
                          v-model="formCreated.country"
                          :placeholder="
                            $t('searchTable.created.country.placeholder')
                          "
                        >
                          <a-option value="Canada">Canada</a-option>
                          <a-option value="USA">USA</a-option>
                        </a-select>
                      </a-form-item>
                      <a-form-item
                        :label="$t('searchTable.created.agencywebsite')"
                      >
                        <a-input
                          v-model="formCreated.agencyWebsite"
                          :placeholder="
                            $t('searchTable.created.agencywebsite.placeholder')
                          "
                        />
                      </a-form-item>
                      <a-form-item :label="$t('searchTable.created.logo')">
                        <div class="upload-container">
                          <a-upload
                            :accept="'jpg/png/jepg'"
                            :on-before-upload="handleBeforeUpload"
                            :custom-request="customUpload"
                            list-type="picture-card"
                            action="/"
                            image-preview
                          >
                          </a-upload>
                          <div class="upload-hint">{{
                            $t('searchTable.created.logo.reminder')
                          }}</div>
                        </div>
                      </a-form-item>
                    </a-collapse-item>
                  </a-collapse>
                </a-form>
              </a-modal>

              <a-upload
                :accept="'csv,xls,xlsx'"
                :on-before-upload="handleBeforeUpload"
                :custom-request="customUpload"
              >
                <template #upload-button>
                  <a-button>
                    {{ $t('searchTable.operation.import') }}
                  </a-button>
                </template>
              </a-upload>
              <a-button @click="reset">
                <template #icon>
                  <icon-refresh />
                </template>
                {{ $t('searchTable.form.reset') }}
              </a-button>
            </a-space>
          </a-col>
          <a-col
            :span="12"
            style="display: flex; align-items: center; justify-content: end"
          >
            <a-button @click="exportCSV()">
              <template #icon>
                <icon-download />
              </template>
              {{ $t('searchTable.operation.download') }}
            </a-button>
            <a-tooltip :content="$t('searchTable.actions.refresh')">
              <div class="action-icon" @click="search"
                ><icon-refresh size="18"
              /></div>
            </a-tooltip>
            <a-dropdown @select="handleSelectDensity">
              <a-tooltip :content="$t('searchTable.actions.density')">
                <div class="action-icon"><icon-line-height size="18" /></div>
              </a-tooltip>
              <template #content>
                <a-doption
                  v-for="item in densityList"
                  :key="item.value"
                  :value="item.value"
                  :class="{ active: item.value === size }"
                >
                  <span>{{ item.name }}</span>
                </a-doption>
              </template>
            </a-dropdown>
            <a-tooltip :content="$t('searchTable.actions.columnSetting')">
              <a-popover
                trigger="click"
                position="bl"
                @popup-visible-change="popupVisibleChange"
              >
                <div class="action-icon"><icon-settings size="18" /></div>
                <template #content>
                  <div id="tableSetting">
                    <div
                      v-for="(item, index) in showColumns"
                      :key="item.dataIndex"
                      class="setting"
                    >
                      <div style="margin-right: 4px; cursor: move">
                        <icon-drag-arrow />
                      </div>
                      <div>
                        <a-checkbox
                          v-model="item.checked"
                          @change="
                            handleChange($event, item as TableColumnData, index)
                          "
                        >
                        </a-checkbox>
                      </div>
                      <div class="title">
                        {{ item.title === '#' ? '序列号' : item.title }}
                      </div>
                    </div>
                  </div>
                </template>
              </a-popover>
            </a-tooltip>
          </a-col>
        </a-row>
        <a-table
          row-key="id"
          :loading="loading"
          :pagination="pagination"
          :columns="(cloneColumns as TableColumnData[])"
          :data="renderData"
          :bordered="false"
          :size="size"
          @page-change="onPageChange"
        >
          <template #index="{ rowIndex }">
            {{ rowIndex + 1 + (pagination.current - 1) * pagination.pageSize }}
          </template>
          <template #contentType="{ record }">
            <a-space>
              <a-avatar
                v-if="record.contentType === 'img'"
                :size="16"
                shape="square"
              >
                <img
                  alt="avatar"
                  src="//p3-armor.byteimg.com/tos-cn-i-49unhts6dw/581b17753093199839f2e327e726b157.svg~tplv-49unhts6dw-image.image"
                />
              </a-avatar>
              <a-avatar
                v-else-if="record.contentType === 'horizontalVideo'"
                :size="16"
                shape="square"
              >
                <img
                  alt="avatar"
                  src="//p3-armor.byteimg.com/tos-cn-i-49unhts6dw/77721e365eb2ab786c889682cbc721c1.svg~tplv-49unhts6dw-image.image"
                />
              </a-avatar>
              <a-avatar v-else :size="16" shape="square">
                <img
                  alt="avatar"
                  src="//p3-armor.byteimg.com/tos-cn-i-49unhts6dw/ea8b09190046da0ea7e070d83c5d1731.svg~tplv-49unhts6dw-image.image"
                />
              </a-avatar>
              {{ $t(`searchTable.form.contentType.${record.contentType}`) }}
            </a-space>
          </template>
          <template #filterType="{ record }">
            {{ $t(`searchTable.form.filterType.${record.filterType}`) }}
          </template>
          <template #status="{ record }">
            <span v-if="record.status === 'offline'" class="circle"></span>
            <span v-else class="circle pass"></span>
            {{ $t(`searchTable.form.status.${record.status}`) }}
          </template>

          <template #operations="{ record }">
            <a-button type="text" size="small" @click="viewUserInfo(record)">
              {{ $t('searchTable.columns.operations.view') }}
            </a-button>
            <!-- <button>查看用户信息</button> -->
          </template>
        </a-table>
      </a-card>
    </div>
    <div v-else>
      <Breadcrumb
        :items="[
          'menu.customer',
          'menu.customer.searchTable',
          'menu.customer.basicInfo',
        ]"
      />
      <router-view></router-view>
    </div>
  </div>
</template>

<script lang="ts" setup>
  import { useRouter } from 'vue-router';
  import { computed, ref, reactive, watch, nextTick } from 'vue';
  import { useI18n } from 'vue-i18n';
  import useLoading from '@/hooks/loading';
  import { PolicyRecord, PolicyParams, getCustomer } from '@/api/list';
  import { Pagination } from '@/types/global';
  import type { SelectOptionData } from '@arco-design/web-vue/es/select/interface';
  import type { TableColumnData } from '@arco-design/web-vue/es/table/interface';
  import { Message, Modal } from '@arco-design/web-vue';
  import cloneDeep from 'lodash/cloneDeep';
  import Sortable from 'sortablejs';
  import debounce from 'lodash.debounce';

  type SizeProps = 'mini' | 'small' | 'medium' | 'large';
  type Column = TableColumnData & { checked?: true };

  const generateFormModel = () => {
    return {
      customerNumber: '',
      agencyName: '',
      name: '',
      contractDate: '',
      filterType: '',
      market: '',
      createdTime: [],
      status: '',
      customerData: [],
      country: '',
      manager: '',
      agencyId: '',
    };
  };
  const tableCreatedModel = () => {
    return {
      customerNumber: '',
      officeID: '',
      amadeus: '',
      officeNumber: '',
      agencyName: '',
      directUsername: '',
      directPassword: '',
      IATA: '',
      firstName: '',
      lastName: '',
      email: '',
      phoneNumber: '',
      agencyAddress: '',
      postalCode: '',
      city: '',
      state: '',
      country: '',
      targetMarket: '',
      accountManager: '',
      amadeusUsername: '',
      amadeusPassword: '',
      language: '',
      agencyWebsite: '',
      logo: '',
    };
  };
  const { loading, setLoading } = useLoading(true);
  const { t } = useI18n();
  const renderData = ref<PolicyRecord[]>([]);
  const formModel = ref(generateFormModel());
  const cloneColumns = ref<Column[]>([]);
  const showColumns = ref<Column[]>([]);
  const formCreated = ref(tableCreatedModel());

  const visible = ref(false);
  const form = reactive({
    name: '',
    post: '',
  });

  const handleClick = () => {
    visible.value = true;
  };

  const handleBeforeOk = (done: () => void) => {
    // eslint-disable-next-line no-console
    console.log(form);
    window.setTimeout(() => {
      done();
      // prevent close
      // done(false)
    }, 3000);
  };

  function convertTableToCSV(data) {
    const header = [
      'Agency Name',
      'Customer Number',
      'Office Number',
      'City',
      'State',
      'Country',
      'Market',
      'Total Unpaid Payouts',
      'Contract Expiry Date',
      'Status',
    ];

    const csvRows = [];

    // 添加表头
    csvRows.push(header.join(','));

    // 添加数据
    data.forEach((row) => {
      const rowData = [
        row.agencyName,
        row.customerNumber,
        row.officeNumber,
        row.city,
        row.province,
        row.country,
        row.market,
        row.totalUnpaid,
        row.contractExpiryDate,
        row.status,
      ];
      csvRows.push(rowData.join(','));
    });

    return csvRows.join('\n');
  }

  const handleCancel = () => {
    visible.value = false;
  };
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

  const size = ref<SizeProps>('medium');
  type MarketOptions = {
    [key: string]: string;
  };
  type CountryOptions = {
    [key: string]: string;
  };
  const basePagination: Pagination = {
    current: 1,
    pageSize: 20,
  };
  const pagination = reactive({
    ...basePagination,
  });
  const densityList = computed(() => [
    {
      name: t('searchTable.size.mini'),
      value: 'mini',
    },
    {
      name: t('searchTable.size.small'),
      value: 'small',
    },
    {
      name: t('searchTable.size.medium'),
      value: 'medium',
    },
    {
      name: t('searchTable.size.large'),
      value: 'large',
    },
  ]);
  const columns = computed<TableColumnData[]>(() => [
    {
      title: t('searchTable.columns.index'),
      dataIndex: 'index',
      slotName: 'index',
    },
    {
      title: t('searchTable.columns.agency.name'),
      dataIndex: 'agencyName',
      width: 180,
      sortable: {
        sortDirections: ['ascend', 'descend'],
      },
    },
    {
      title: t('searchTable.columns.customer.number'),
      dataIndex: 'customerNumber',
      sortable: {
        sortDirections: ['ascend', 'descend'],
      },
    },
    {
      title: t('searchTable.created.officenumber'),
      dataIndex: 'officeNumber',
      sortable: {
        sortDirections: ['ascend', 'descend'],
      },
    },
    {
      title: t('searchTable.columns.city'),
      dataIndex: 'city',
      sortable: {
        sortDirections: ['ascend', 'descend'],
      },
    },
    {
      title: t('searchTable.columns.province'),
      dataIndex: 'province',
      filterable: {
        filters: [
          {
            text: 'CA',
            value: 'CA',
          },
          {
            text: 'IL',
            value: 'Il',
          },
          {
            text: 'BC',
            value: 'BC',
          },
          {
            text: 'ON',
            value: 'ON',
          },
          {
            text: 'QC',
            value: 'QC',
          },
        ],
        filter: (value, row) => row.address.includes(value),
      },
    },
    {
      title: t('searchTable.columns.unpaidpayouts'),
      dataIndex: 'totalUnpaid',
      sortable: {
        sortDirections: ['ascend', 'descend'],
      },
    },
    {
      title: t('searchTable.columns.contractDate'),
      dataIndex: 'contractExpiryDate',
      // slotName: 'contentType',
      sortable: {
        sortDirections: ['ascend', 'descend'],
      },
    },

    {
      title: t('searchTable.columns.status'),
      dataIndex: 'status',
      slotName: 'status',
      sortable: {
        sortDirections: ['ascend', 'descend'],
      },
    },
    {
      title: t('searchTable.columns.operations'),
      dataIndex: 'operations',
      slotName: 'operations',
    },
  ]);
  const marketOptions: MarketOptions = {
    C: 'China',
    I: 'India',
    A: 'Africa',
    E: 'Europe',
    M: 'Middle East',
    S: 'South Asia',
  };
  const onMarketChange = () => {
    const market = formModel.value.market[0];
    // console.log('market', market);
    fetchData({ ...basePagination, market });
  };

  const marketTypeOptions = ref<SelectOptionData[]>([]);
  const marketOptionsRendered = ref(false);

  const renderMarketData = (data) => {
    const markets = new Set(data.map((item) => item.Market));
    marketTypeOptions.value = Array.from(markets).map((market) => ({
      label: marketOptions[market] || market,
      value: market,
    }));
  };

  const countryOptions: CountryOptions = {
    C: 'Canada',
    U: 'USA',
  };
  const countryTypeOptions = ref<SelectOptionData[]>([]);
  const countryOptionsRendered = ref(false);

  const onCountryChange = () => {
    const countryAbbreviation = formModel.value.country[0];
    const country = countryOptions[countryAbbreviation];
    fetchData({ ...basePagination, country });
  };

  const renderCountryData = (data) => {
    const countries = new Set(data.map((item) => item.Country));
    countryTypeOptions.value = Array.from(countries).map((country) => ({
      label: country,
      value: country,
    }));
  };

  const onStatusChange = () => {
    const { status } = formModel.value;
    const statusValue = status === 'online' ? '1' : '0';
    fetchData({ ...basePagination, status: statusValue });
  };

  const statusOptions = computed<SelectOptionData[]>(() => [
    {
      label: t('searchTable.form.status.online'),
      value: 'online',
    },
    {
      label: t('searchTable.form.status.offline'),
      value: 'offline',
    },
  ]);

  const router = useRouter();
  const viewUserInfo = (agencyId: any) => {
    router.push({
      path: '/customer/search-table/BasicInfo',
      query: {
        agencyId: encodeURIComponent(agencyId.agencyId),
      },
    });
  };
  const handleAgencyNameSearch = () => {
    const search = formModel.value.agencyName;
    fetchData({ ...basePagination, search });
  };
  const handleCustomerIdSearch = () => {
    const customer = formModel.value.customerNumber;
    fetchData({ ...basePagination, customer });
  };

  const debouncedHandleSearch = debounce(handleAgencyNameSearch, 700);
  const debouncedHandleCustomerIdSearch = debounce(handleCustomerIdSearch, 700);
  const fetchData = async (
    params: PolicyParams = { current: 1, pageSize: 20 }
  ) => {
    setLoading(true);
    // 从后端获取数据
    try {
      const searchParam = params.search ? `search=${params.search}` : '';
      const customerIdParam = params.customer
        ? `customer=${params.customer}`
        : '';
      const marketParam = params.market ? `market=${params.market}` : '';
      const countryParam = params.country ? `country=${params.country}` : '';
      const statusParam = params.status ? `status=${params.status}` : '';
      const queryParams = [
        searchParam,
        customerIdParam,
        marketParam,
        countryParam,
        statusParam,
      ]
        .filter(Boolean)
        .join('&');
      const dataFromGetData = await getCustomer(
        `http://localhost:3000/src/views/api/api.php?action=customer&${queryParams}`
      );
      // eslint-disable-next-line no-console
      console.log(dataFromGetData);
      if (dataFromGetData.length === 0) {
        // eslint-disable-next-line no-console
        console.log('no result');
      } else {
        const formattedData = dataFromGetData.map((item, index) => {
          return {
            index: index + 1,
            agencyName: item.AgencyName,
            customerNumber: item.CustomerNumber,
            contractExpiryDate: item.TotalExpiry,
            city: item.City,
            totalUnpaid: item.TotalUnpaid,
            officeNumber: item.OfficeNumber,
            province: item.PostCode,
            status: item.Status === '1' ? 'online' : 'offline',
            country: item.Country,
            market: item.Market,
            agencyId: item.agencyId,
          };
        });

        if (!marketOptionsRendered.value) {
          renderMarketData(dataFromGetData.filter((item) => item.Market));
          marketOptionsRendered.value = true;
        }
        if (!countryOptionsRendered.value) {
          renderCountryData(dataFromGetData.filter((item) => item.Country));
          countryOptionsRendered.value = true;
        }
        renderData.value = formattedData;
        pagination.current = params.current;
        // 设置总数据量，可以从响应中获取
        pagination.total = formattedData.length;
      }
    } catch (err) {
      // you can report use errorHandler or other
    } finally {
      setLoading(false);
    }
  };

  const search = () => {
    fetchData({
      ...basePagination,
      ...formModel.value,
    } as unknown as PolicyParams);
  };
  const onPageChange = (current: number) => {
    fetchData({ ...basePagination, current });
  };

  fetchData();
  const reset = () => {
    formModel.value = generateFormModel();
    fetchData();
  };
  const handleBeforeUpload = (file) => {
    const fileType = file.name.slice(file.name.lastIndexOf('.'));
    if (
      !['.csv', '.xls', '.xlsx', '.jpg', '.png', '.jepg'].includes(fileType)
    ) {
      Message.error('Invalid file format.');
      return false;
    }
    const fileSize = file.size / 1024 < 10000;
    if (!fileSize) {
      Message.error('File Size should below 10MB');
      return false;
    }

    return new Promise((resolve, reject) => {
      Modal.confirm({
        title: 'Before Upload',
        content: `Please Confirm file name: ${file.name}`,
        onOk: () => resolve(true),
        onCancel: () => reject(new Error('cancel')),
      });
    });
  };
  const customUpload = (option) => {
    const { onProgress, onError, onSuccess, fileItem, name } = option;
    const xhr = new XMLHttpRequest();
    if (xhr.upload) {
      xhr.upload.onprogress = (event) => {
        let percent;
        if (event.total > 0) {
          // 0 ~ 1
          percent = event.loaded / event.total;
        }
        onProgress(percent, event);
      };
    }
    xhr.onerror = function error(e) {
      onError(e);
    };
    xhr.onload = function onload() {
      if (xhr.status < 200 || xhr.status >= 300) {
        return onError(xhr.responseText);
      }
      // Check if the response contains "has been uploaded" to confirm the file was uploaded successfully
      if (xhr.responseText.includes('has been uploaded')) {
        // eslint-disable-next-line no-console
        console.log('File uploaded successfully:', xhr.responseText);
        // Display a success message or perform any other action you'd like
      } else {
        // eslint-disable-next-line no-console
        console.log('Failed to upload:', xhr.responseText);
        return onError(xhr.responseText);
      }

      return onSuccess(xhr.response);
    };

    const formData = new FormData();
    formData.append(name || 'file', fileItem.file);
    xhr.open(
      'post',
      'http://localhost:3000/src/views/api/api.php?action=upload',
      true
    );
    xhr.send(formData);

    return {
      abort() {
        xhr.abort();
      },
    };
  };

  const handleSelectDensity = (
    val: string | number | Record<string, any> | undefined,
    e: Event
  ) => {
    size.value = val as SizeProps;
  };

  const handleChange = (
    checked: boolean | (string | boolean | number)[],
    column: Column,
    index: number
  ) => {
    if (!checked) {
      cloneColumns.value = showColumns.value.filter(
        (item) => item.dataIndex !== column.dataIndex
      );
    } else {
      cloneColumns.value.splice(index, 0, column);
    }
  };

  const exchangeArray = <T extends Array<any>>(
    array: T,
    beforeIdx: number,
    newIdx: number,
    isDeep = false
  ): T => {
    const newArray = isDeep ? cloneDeep(array) : array;
    if (beforeIdx > -1 && newIdx > -1) {
      // 先替换后面的，然后拿到替换的结果替换前面的
      newArray.splice(
        beforeIdx,
        1,
        newArray.splice(newIdx, 1, newArray[beforeIdx]).pop()
      );
    }
    return newArray;
  };

  const popupVisibleChange = (val: boolean) => {
    if (val) {
      nextTick(() => {
        const el = document.getElementById('tableSetting') as HTMLElement;
        const sortable = new Sortable(el, {
          onEnd(e: any) {
            const { oldIndex, newIndex } = e;
            exchangeArray(cloneColumns.value, oldIndex, newIndex);
            exchangeArray(showColumns.value, oldIndex, newIndex);
          },
        });
      });
    }
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
    name: 'SearchTable',
  };
</script>

<style scoped lang="less">
  .container {
    padding: 0 20px 20px;
  }

  :deep(.arco-table-th) {
    &:last-child {
      .arco-table-th-item-title {
        margin-left: 16px;
      }
    }
  }

  .action-icon {
    margin-left: 12px;
    cursor: pointer;
  }

  .active {
    color: #0960bd;
    background-color: #e3f4fc;
  }

  .setting {
    display: flex;
    align-items: center;
    width: 200px;

    .title {
      margin-left: 12px;
      cursor: pointer;
    }
  }

  .upload-hint {
    margin-top: 8px;
    color: #888;
    font-size: 12px;
  }

  .upload-container {
    display: flex;
    flex-direction: column;
  }
</style>
