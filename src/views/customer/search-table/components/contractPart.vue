<template>
  <ASpace direction="vertical" size="large" fill>
    <ASpace>
      <AButton type="primary" @click="handleAdd">add</AButton>
    </ASpace>

    <ATable
      :columns="columns"
      :data="contractList"
      :filter-icon-align-left="alignLeft"
      @change="handleCancel"
    >
      <template #Agency="{ record, rowIndex }">
        <div>
          <IconLaunch size="20" @click="handleShowEdit({ record, rowIndex })" />
          {{ record.agency_id }}
        </div>
      </template>
    </ATable>

    <!-- contract type selector -->
    <AModal
      v-model:visible="gdsShow"
      width="600px"
      :footer="false"
      title="Select you contract type"
      :unmount-on-close="true"
      :mask-closable="false"
      @cancel="handleGdsCancel"
      @before-ok="handleGdsBeforeOk"
    >
      <!-- display contract types -->
      <div class="select-contract-type">
        <ARadioGroup v-model="gds_type">
          <!-- contract type在写死的gdsList里面 -->
          <ARadio
            v-for="(item, index) in gdsList"
            :key="index"
            :value="item.value"
            >{{ item.name }}</ARadio
          >
        </ARadioGroup>
        <!-- 点击confirm之后弹出下一个窗口 -->
        <div class="text-right margin-top-20">
          <AButton type="primary" @click="handleSelectContractConfirm"
            >Confirm</AButton
          >
          <!-- <AButton type="outline" class="margin-left-20">back</AButton> -->
        </div>
      </div>
    </AModal>

    <AModal
      v-model:visible="visible"
      width="700px"
      :footer="false"
      title="Add/Edit Contract"
      :unmount-on-close="true"
      @cancel="handleCancel"
      @before-ok="handleBeforeOk"
    >
      <template #title>
        <div>
          <AButton class="btn-back" type="outline" @click="handleBack"
            >back</AButton
          >
          Add/Edit Contract
        </div>
      </template>
      <AForm
        v-if="!submitted"
        ref="formRef"
        :form="form"
        class="contract_edit"
        :model="form"
        :style="{ width: '600px' }"
        :label-col-props="{ span: 8 }"
        :wrapper-col-props="{ span: 16 }"
        @submit="handleSubmit"
      >
        <AFormItem field="start_date" label="Start date">
          <ADatePicker
            v-model="form.start_date"
            placeholder="Please select ..."
          />
        </AFormItem>
        <AFormItem field="end_date" label="End date">
          <ADatePicker
            v-model="form.end_date"
            placeholder="Please select ..."
          />
        </AFormItem>

        <AFormItem
          field="contract_type"
          label="Region"
          :rules="[{ required: true, message: 'must select one' }]"
        >
          <ARadioGroup v-model="form.contract_type">
            <ARadio value="1">US</ARadio>
            <ARadio value="2">CA</ARadio>
          </ARadioGroup>
        </AFormItem>
        <AFormItem
          field="paid_every"
          label="Paid Every"
          :rules="[{ required: true, message: 'must select one' }]"
        >
          <ARadioGroup v-model="form.paid_every">
            <ARadio value="1">Month</ARadio>
            <ARadio value="2">3 Months</ARadio>
            <ARadio value="3">6 Months</ARadio>
            <ARadio value="4">Year</ARadio>
          </ARadioGroup>
        </AFormItem>

        <AFormItem
          v-if="gds_type === 'Amadeus' && form.contract_type !== '1'"
          field="base_rate"
          label="Base rate"
        >
          <AInput v-model="form.base_rate" />
        </AFormItem>
        <AFormItem
          v-if="gds_type === 'Amadeus' && form.contract_type === '1'"
          field="domes_rate"
          label="Domestic base rate"
        >
          <AInput v-model="form.domes_rate" />
        </AFormItem>

        <AFormItem
          v-if="gds_type === 'Amadeus' && form.contract_type === '1'"
          field="inter_rate"
          label="International base rate"
        >
          <AInput v-model="form.inter_rate" />
        </AFormItem>
        <!-- <AFormItem
          field="gds"
          label="GDS"
          :rules="[{ required: true, message: 'must select one' }]"
        >
          <ARadioGroup v-model="form.gds">
            <ARadio value="Amadeus">Amadeus</ARadio>
            <ARadio value="Vacation">Vacation</ARadio>
            <ARadio value="Sirev">Sirev</ARadio>
            <ARadio value="Air">Air</ARadio>
            <ARadio value="Hotel">Hotel</ARadio>
          </ARadioGroup>
        </AFormItem> -->

        <AFormItem
          v-if="gds_type === 'Amadeus'"
          field="total_gds"
          label="Total GDS segments rate"
        >
          <AInput v-model="form.total_gds" placeholder="" />
        </AFormItem>

        <AFormItem
          v-if="gds_type === 'Amadeus'"
          field="commitment_percentage"
          label="Commitment Percentage"
        >
          <AInput v-model="form.commitment_percentage" placeholder="" />
        </AFormItem>

        <ACollapse
          v-if="gds_type === 'Amadeus'"
          :default-active-key="['1']"
          style="margin-bottom: 20px"
        >
          <ACollapseItem key="1" header="Advanced" class="advancedBox">
            <AFormItem
              field="ATA_contract_requested_date"
              label="Contract requested date"
            >
              <ADatePicker
                v-model="form.ATA_contract_requested_date"
                placeholder="Please select ..."
              />
            </AFormItem>
            <AFormItem
              field="ATA_contract_sent_date"
              label="Contract sent date"
            >
              <ADatePicker
                v-model="form.ATA_contract_sent_date"
                placeholder="Please select ..."
              />
            </AFormItem>
            <AFormItem
              field="ATA_contract_signed_date"
              label="Contract signed date"
            >
              <ADatePicker
                v-model="form.ATA_contract_signed_date"
                placeholder="Please select ..."
              />
            </AFormItem>
            <AFormItem
              field="docusign_requested_date"
              label="Docusign requested date"
            >
              <ADatePicker
                v-model="form.docusign_requested_date"
                placeholder="Please select ..."
              />
            </AFormItem>
            <AFormItem field="docusign_sent_date" label="Docusign sent date">
              <ADatePicker
                v-model="form.docusign_sent_date"
                placeholder="Please select ..."
              />
            </AFormItem>
            <AFormItem
              field="docusign_signed_date"
              label="Docusign signed date"
            >
              <ADatePicker
                v-model="form.docusign_signed_date"
                placeholder="Please select ..."
              />
            </AFormItem>
            <AFormItem
              field="Amadeus_install_received_date"
              label="Amadeus install received date"
            >
              <ADatePicker
                v-model="form.Amadeus_install_received_date"
                placeholder="Please select ..."
              />
            </AFormItem>
            <AFormItem
              field="Amadeus_ATID_installation_received_date"
              label="ATID installation received date"
            >
              <ADatePicker
                v-model="form.Amadeus_ATID_installation_received_date"
                placeholder="Please select ..."
              />
            </AFormItem>
            <AFormItem
              field="Amadeus_pro_printer_complete_date"
              label="Printer complete date"
            >
              <ADatePicker
                v-model="form.Amadeus_pro_printer_complete_date"
                placeholder="Please select ..."
              />
            </AFormItem>
            <AFormItem
              field="Amadeus_notified_date"
              label="Amadeus notified date"
            >
              <ADatePicker
                v-model="form.Amadeus_notified_date"
                placeholder="Please select ..."
              />
            </AFormItem>
          </ACollapseItem>
        </ACollapse>

        <AFormItem
          v-if="gds_type === 'Vacation'"
          field="vacation_sign_date"
          label="Vacation sign date"
        >
          <ADatePicker v-model="form.vacation_sign_date" placeholder="" />
        </AFormItem>
        <AFormItem
          v-if="gds_type === 'Vacation'"
          field="vacation_business_partner_no"
          label="Business partner no"
        >
          <AInput v-model="form.vacation_business_partner_no" placeholder="" />
        </AFormItem>
        <AFormItem
          v-if="gds_type === 'Vacation'"
          field="vacation_subscription_fee"
          label="Subscription fee"
        >
          <AInput v-model="form.vacation_subscription_fee" placeholder="" />
        </AFormItem>
        <AFormItem
          v-if="gds_type === 'Vacation'"
          field="vacation_one_time_fee"
          label="One time fee"
        >
          <AInput v-model="form.vacation_one_time_fee" placeholder="" />
        </AFormItem>
        <AFormItem
          v-if="gds_type === 'Vacation'"
          field="vacation_manulife_key"
          label="Manulife key"
        >
          <AInput v-model="form.vacation_manulife_key" placeholder="" />
        </AFormItem>
        <AFormItem
          v-if="gds_type === 'Vacation'"
          field="vacation_softvoyage_username"
          label="Softvoyage username"
        >
          <AInput v-model="form.vacation_softvoyage_username" placeholder="" />
        </AFormItem>
        <AFormItem
          v-if="gds_type === 'Vacation'"
          field="vacation_softvoyage_password"
          label="Softvoyage password"
        >
          <AInput v-model="form.vacation_softvoyage_password" placeholder="" />
        </AFormItem>
        <AFormItem
          v-if="gds_type === 'Vacation'"
          field="vacation_softvoyage_affiliate_code"
          label="Softvoyage affiliate code"
        >
          <AInput
            v-model="form.vacation_softvoyage_affiliate_code"
            placeholder=""
          />
        </AFormItem>

        <AFormItem
          v-if="gds_type === 'Sirev'"
          field="sirev_sign_date"
          label="Sirev sign date"
        >
          <ADatePicker v-model="form.sirev_sign_date" placeholder="" />
        </AFormItem>
        <AFormItem
          v-if="gds_type === 'Sirev'"
          field="sirev_start_date"
          label="Sirev start date"
        >
          <ADatePicker v-model="form.sirev_start_date" placeholder="" />
        </AFormItem>
        <AFormItem
          v-if="gds_type === 'Sirev'"
          field="sirev_end_date"
          label="Sirev end date"
        >
          <ADatePicker v-model="form.sirev_end_date" placeholder="" />
        </AFormItem>
        <AFormItem
          v-if="gds_type === 'Sirev'"
          field="sirev_subscription_fee"
          label="Sirev subscription fee"
        >
          <AInput v-model="form.sirev_subscription_fee" placeholder="" />
        </AFormItem>
        <AFormItem
          v-if="gds_type === 'Sirev'"
          field="sirev_one_time_fee"
          label="Sirev one time fee"
        >
          <AInput v-model="form.sirev_one_time_fee" placeholder="" />
        </AFormItem>
        <AFormItem
          v-if="gds_type === 'Sirev'"
          field="sirev_username"
          label="Sirev username"
        >
          <AInput v-model="form.sirev_username" placeholder="" />
        </AFormItem>
        <AFormItem
          v-if="gds_type === 'Sirev'"
          field="sirev_password"
          label="Sirev password"
        >
          <AInput v-model="form.sirev_password" placeholder="" />
        </AFormItem>

        <AFormItem
          v-if="gds_type === 'Air'"
          field="air_sign_date"
          label="Air sign date"
        >
          <ADatePicker v-model="form.sirev_sign_date" placeholder="" />
        </AFormItem>
        <AFormItem
          v-if="gds_type === 'Air'"
          field="air_start_date"
          label="Air start date"
        >
          <ADatePicker v-model="form.sirev_start_date" placeholder="" />
        </AFormItem>
        <AFormItem
          v-if="gds_type === 'Air'"
          field="air_end_date"
          label="Air end date"
        >
          <ADatePicker v-model="form.sirev_end_date" placeholder="" />
        </AFormItem>
        <AFormItem
          v-if="gds_type === 'Air'"
          field="air_subscription_fee"
          label="Air subscription fee"
        >
          <AInput v-model="form.sirev_subscription_fee" placeholder="" />
        </AFormItem>
        <AFormItem
          v-if="gds_type === 'Air'"
          field="air_one_time_fee"
          label="Air one time fee"
        >
          <AInput v-model="form.air_one_time_fee" placeholder="" />
        </AFormItem>
        <AFormItem
          v-if="gds_type === 'Air'"
          field="air_clearsale_key"
          label="Air clearsale key"
        >
          <AInput v-model="form.air_clearsale_key" placeholder="" />
        </AFormItem>
        <AFormItem
          v-if="gds_type === 'Air'"
          field="air_website_url"
          label="Air website url"
        >
          <AInput v-model="form.air_website_url" placeholder="" />
        </AFormItem>
        <AFormItem
          v-if="gds_type === 'Air'"
          field="air_website_username"
          label="Air website username"
        >
          <AInput v-model="form.air_website_username" placeholder="" />
        </AFormItem>
        <AFormItem
          v-if="gds_type === 'Air'"
          field="air_website_password"
          label="Air website password"
        >
          <AInput v-model="form.air_website_password" placeholder="" />
        </AFormItem>

        <AFormItem
          v-if="gds_type === 'Hotel'"
          field="air_sign_date"
          label="Hotel sign date"
        >
          <ADatePicker v-model="form.hotel_sign_date" placeholder="" />
        </AFormItem>
        <AFormItem
          v-if="gds_type === 'Hotel'"
          field="air_start_date"
          label="Hotel start date"
        >
          <ADatePicker v-model="form.hotel_start_date" placeholder="" />
        </AFormItem>
        <AFormItem
          v-if="gds_type === 'Hotel'"
          field="air_end_date"
          label="Hotel end date"
        >
          <ADatePicker v-model="form.hotel_end_date" placeholder="" />
        </AFormItem>
        <AFormItem
          v-if="gds_type === 'Hotel'"
          field="air_subscription_fee"
          label="Hotel subscription fee"
        >
          <AInput v-model="form.hotel_subscription_fee" placeholder="" />
        </AFormItem>
        <AFormItem
          v-if="gds_type === 'Hotel'"
          field="air_one_time_fee"
          label="Hotel one time fee"
        >
          <AInput v-model="form.hotel_one_time_fee" placeholder="" />
        </AFormItem>
        <AFormItem
          v-if="gds_type === 'Hotel'"
          field="air_website_url"
          label="Hotel website url"
        >
          <AInput v-model="form.hotel_website_url" placeholder="" />
        </AFormItem>
        <AFormItem
          v-if="gds_type === 'Hotel'"
          field="air_website_username"
          label="Hotel website username"
        >
          <AInput v-model="form.hotel_website_username" placeholder="" />
        </AFormItem>
        <AFormItem
          v-if="gds_type === 'Hotel'"
          field="air_website_password"
          label="Hotel website password"
        >
          <AInput v-model="form.hotel_website_password" placeholder="" />
        </AFormItem>

        <AFormItem>
          <ASpace>
            <AButton html-type="submit">Submit</AButton>
            <AButton @click="$refs.formRef.resetFields()">Reset</AButton>
          </ASpace>
        </AFormItem>
      </AForm>
      <div v-else>
        <p>表单已提交！</p>
        <!-- <a-button @click="submitted = false">编辑表单</a-button> -->
      </div>
    </AModal>
  </ASpace>
</template>

<script lang="ts">
  import { reactive, ref } from 'vue';
  // import axios from 'axios';
  import { Notification } from '@arco-design/web-vue';
  import HttpHelper from '@/utils/httpHelper';

  export default {
    setup() {
      const alignLeft = ref(false);
      const columns = [
        {
          title: 'AgencyId',
          dataIndex: 'agency_id',
          slotName: 'Agency',
          sortable: {
            sortDirections: ['ascend', 'descend'],
          },
        },
        {
          title: 'AgencyName',
          dataIndex: 'agency_name',
          sortable: {
            sortDirections: ['ascend', 'descend'],
          },
        },
        {
          title: 'Customer#',
          dataIndex: 'amadeus_customer_no',
          sortable: {
            sortDirections: ['ascend', 'descend'],
          },
        },
        {
          title: 'Start Date',
          dataIndex: 'start_date',
          sortable: {
            sortDirections: ['ascend', 'descend'],
          },
        },
        {
          title: 'End Date',
          dataIndex: 'end_date',
          sortable: {
            sortDirections: ['ascend', 'descend'],
          },
        },
        {
          title: 'Pay Schedule',
          dataIndex: 'payout_period',
          sortable: {
            sortDirections: ['ascend', 'descend'],
          },
        },
        {
          title: 'Contract Type',
          dataIndex: 'contract_type_name',
          sortable: {
            sortDirections: ['ascend', 'descend'],
          },
        },
      ];
      const data = reactive([]);

      return {
        alignLeft,
        columns,
        data,
      };
    },
    data() {
      return {
        submitted: false,
        params: {},
        visible: false,
        currentIndex: -1,
        currentItem: {},
        contractList: [],
        editedRowIndex: null,
        editedContract: {},
        gds_type: '',
        gdsShow: false,
        gdsList: [
          { name: 'ATA Amadeus', value: 'Amadeus' },
          { name: 'ATA hotels (Hotel planner)', value: 'Hotel' },
          { name: 'ATA Vacation(Sunbook)', value: 'Vacation' },
          { name: 'ATA Excursions(Viator)', value: 'Viator' },
          { name: 'ATA Monthly payment', value: 'monthpayment' },
          { name: 'ATA Air Booking', value: 'Air' },
          { name: 'ATA Tours(TBA)', value: 'tba' },
          { name: 'ATA Vacation(Sirev)', value: 'Sirev' },
          { name: 'ATA Cruise(Odysseus)', value: 'Odysseus' },
        ],
        form: {
          start_date: '',
          end_date: '',
          contract_type: '',
          paid_every: '',
          base_rate: '',
          gds: '',
          total_gds: '',
          commitment_percentage: '',
          domes_rate: '',
          inter_rate: '',
          ATA_contract_requested_date: '',
          ATA_contract_sent_date: '',
          ATA_contract_signed_date: '',
          docusign_requested_date: '',
          docusign_sent_date: '',
          docusign_signed_date: '',
          Amadeus_install_received_date: '',
          Amadeus_ATID_installation_received_date: '',
          Amadeus_pro_printer_complete_date: '',
          Amadeus_notified_date: '',
          vacation_sign_date: '',
          vacation_payment_cycle: '',
          vacation_business_partner_no: '',
          vacation_subscription_fee: '',
          vacation_one_time_fee: '',
          vacation_manulife_key: '',
          vacation_softvoyage_username: '',
          vacation_softvoyage_password: '',
          vacation_softvoyage_affiliate_code: '',
          sirev_sign_date: '',
          sirev_start_date: '',
          sirev_end_date: '',
          sirev_payment_cycle: '',
          sirev_subscription_fee: '',
          sirev_one_time_fee: '',
          sirev_username: '',
          sirev_password: '',
          air_one_time_fee: '',
          air_clearsale_key: '',
          air_website_url: '',
          air_website_password: '',
          hotel_sign_date: '',
          hotel_start_date: '',
          hotel_end_date: '',
          hotel_payment_cycle: '',
          hotel_subscription_fee: '',
          hotel_one_time_fee: '',
          hotel_website_url: '',
          hotel_website_username: '',
          hotel_website_password: '',
          id: '',
          air_website_username: '',
        },
      };
    },
    mounted() {
      this.getContractData();
      const { params } = this.$route;
      this.params = params;
    },
    methods: {
      // handle的几个method用来控制窗口切换
      handleBack() {
        this.gdsShow = true;
        this.visible = false;
      },
      handleGdsCancel() {
        this.gds_type = '';
        this.gdsShow = false;
      },
      handleSelectContractConfirm() {
        this.gdsShow = false;
        this.visible = true;
      },
      handleGdsBeforeOk() {
        //
      },
      handleAdd() {
        this.currentItem = {};
        this.currentIndex = -1;
        this.gdsShow = true;
      },
      handleShowEdit(option: { record: any; rowIndex: any }) {
        const { record, rowIndex } = option;
        this.currentItem = record;
        this.currentIndex = rowIndex;
        this.visible = true;
      },
      handleCancel() {
        //
      },
      handleBeforeOk() {
        //
      },
      handleSubmit() {
        // 获取用户在表单中选择或输入的数据
        const { start_date: startDate, end_date: endDate } = this.form;
        // 更新对应列中已有的数据
        // your code here...
        if (this.currentItem && this.currentItem.id) {
          // edit
        } else {
          // save
          // 设置结束日期必须大于开始日期
          if (endDate < startDate) {
            Notification.error({ title: 'Error', content: 'Wrong End Date!' });
            return;
          }
          const customeData = HttpHelper.getValue('customer_record');
          HttpHelper.post('contract', {
            agency_id: customeData.agencyId,
            ...this.form,
            gds: this.gds_type,
          });
        }
        this.submitted = true;
      },
      handleReset() {
        this.$refs.formRef.resetFields(); // 重置表单
      },
      async getContractData() {
        const customerRecord = HttpHelper.getValue('customer_record');
        // const res = await axios.get(
        //   'http://localhost:3000/src/views/api/api.php?action=contract?agencyId='+customerRecord.agencyId
        // );
        const res = await HttpHelper.get('contract', {
          agencyId: customerRecord.agencyId,
        });
        this.contractList = res.data;
      },
    },
  };
</script>

<style>
  .btn-back {
    position: absolute;
    left: 10px;
  }
  .contract_edit .arco-form-item-label-col {
    display: flex;
    flex-shrink: 0;
    justify-content: initial;
    line-height: 32px;
    white-space: nowrap;
  }
  .advancedBox .arco-form-item-content-flex {
    justify-content: flex-end;
  }
  .select-contract-type .arco-radio {
    margin-top: 10px;
    margin-bottom: 10px;
  }
  .select-contract-type .arco-radio .arco-radio-label {
    width: 200px;
  }
  .text-right {
    text-align: right;
  }
  .margin-left-20 {
    margin-left: 20px;
  }
  .margin-top-20 {
    margin-top: 20px;
  }
</style>
