<template>
  <div>
    <a-card title="Basic Information">
      <a-button type="text" class="edit_button" @click="onEdit()">
        <template #icon>
          <icon-edit />
        </template>
        <!-- Use the default slot to avoid extra spaces -->
        <template #default>Edit</template>
      </a-button>
      <a-grid
        :cols="{ xs: 1, sm: 2, md: 3, lg: 4, xl: 5, xxl: 6 }"
        :col-gap="12"
        :row-gap="16"
        class="grid-demo-grid"
      >
        <a-grid-item class="demo-item">Customer Number</a-grid-item>
        <a-grid-item
          v-if="agencyData && agencyData[0]"
          class="demo-item"
          :span="{ xl: 4, xxl: 6 }"
          suffix
        >
          {{ agencyData[0].CustomerNumber }}
          <!-- {{ agencyData[0].CustomerNumber }} -->
        </a-grid-item>
        <a-grid-item class="demo-item">Agency Name</a-grid-item>
        <a-grid-item
          v-if="agencyData && agencyData[0]"
          class="demo-item"
          :span="{ xl: 4, xxl: 6 }"
          suffix
        >
          {{ agencyData[0].AgencyName }}
        </a-grid-item>
        <a-grid-item class="demo-item">Manager</a-grid-item>
        <a-grid-item
          v-if="agencyData && agencyData[0]"
          class="demo-item"
          :span="{ xl: 4, xxl: 6 }"
          suffix
        >
          <a-input
            v-if="agencyData[0].editable"
            v-model="agencyData[0].manager_name"
          />

          <template v-else>
            {{ agencyData[0].manager_name }}
          </template>
        </a-grid-item>
        <a-grid-item class="demo-item">Market</a-grid-item>
        <a-grid-item
          v-if="agencyData && agencyData[0]"
          class="demo-item"
          :span="{ xl: 4, xxl: 6 }"
          suffix
        >
          <a-input
            v-if="agencyData[0].editable"
            v-model="agencyData[0].Market"
          />

          <template v-else>
            {{ agencyData[0].Market }}
          </template>
        </a-grid-item>
        <a-grid-item class="demo-item">Name</a-grid-item>
        <a-grid-item
          v-if="agencyData && agencyData[0]"
          class="demo-item"
          :span="{ xl: 4, xxl: 6 }"
          suffix
        >
          <a-input v-if="agencyData[0].editable" v-model="agencyData[0].Name" />
          <template v-else>{{ agencyData[0].Name }}</template>
        </a-grid-item>
        <a-grid-item class="demo-item">Email</a-grid-item>
        <a-grid-item
          v-if="agencyData && agencyData[0]"
          class="demo-item"
          :span="{ xl: 4, xxl: 6 }"
          suffix
        >
          <a-input
            v-if="agencyData[0].editable"
            v-model="agencyData[0].email"
          />

          <template v-else> {{ agencyData[0].email }}</template>
        </a-grid-item>
        <a-grid-item class="demo-item">Phone</a-grid-item>
        <a-grid-item
          v-if="agencyData && agencyData[0]"
          class="demo-item"
          :span="{ xl: 4, xxl: 6 }"
          suffix
        >
          <a-input
            v-if="agencyData[0].editable"
            v-model="agencyData[0].phone_num"
          />

          <template v-else>
            {{ agencyData[0].phone_num }}
          </template>
        </a-grid-item>
        <a-grid-item class="demo-item">Address</a-grid-item>
        <a-grid-item
          v-if="agencyData && agencyData[0]"
          class="demo-item"
          :span="{ xl: 4, xxl: 6 }"
          suffix
        >
          <a-input
            v-if="agencyData[0].editable"
            v-model="agencyData[0].address"
          />

          <template v-else>
            {{ agencyData[0].address }}
          </template>
        </a-grid-item>
      </a-grid>
    </a-card>

    <a-card title="Amadeus Direct Information">
      <a-grid
        :cols="{ xs: 1, sm: 2, md: 3, lg: 4, xl: 5, xxl: 6 }"
        :col-gap="12"
        :row-gap="16"
        class="grid-demo-grid"
      >
        <a-grid-item class="demo-item">Offer Number</a-grid-item>
        <a-grid-item
          v-if="agencyData && agencyData[0]"
          class="demo-item"
          :span="{ xl: 4, xxl: 6 }"
          suffix
        >
          <a-input
            v-if="agencyData[0].editable"
            v-model="agencyData[0].office_no"
          />

          <template v-else>
            {{ agencyData[0].office_no }}
          </template>
        </a-grid-item>
        <a-grid-item class="demo-item">Direct Username</a-grid-item>
        <a-grid-item
          v-if="agencyData && agencyData[0]"
          class="demo-item"
          :span="{ xl: 4, xxl: 6 }"
          suffix
        >
          <a-input
            v-if="agencyData[0].editable"
            v-model="agencyData[0].direct_username"
          />

          <template v-else>
            {{ agencyData[0].direct_username }}
          </template>
        </a-grid-item>
        <a-grid-item class="demo-item">Direct Password</a-grid-item>
        <a-grid-item
          v-if="agencyData && agencyData[0]"
          class="demo-item"
          :span="{ xl: 4, xxl: 6 }"
          suffix
        >
          <a-input
            v-if="agencyData[0].editable"
            v-model="agencyData[0].direct_pwd"
          />

          <template v-else>
            {{ agencyData[0].direct_pwd }}
          </template>
        </a-grid-item>
        <a-grid-item class="demo-item">Contract Number</a-grid-item>
        <a-grid-item
          v-if="agencyData && agencyData[0]"
          class="demo-item"
          :span="{ xl: 4, xxl: 6 }"
          suffix
        >
          <a-input
            v-if="agencyData[0].editable"
            v-model="agencyData[0].contract_no"
          />

          <template v-else>
            {{ agencyData[0].contract_no }}
          </template>
        </a-grid-item>
        <a-grid-item class="demo-item">IATA Number</a-grid-item>
        <a-grid-item
          v-if="agencyData && agencyData[0]"
          class="demo-item"
          :span="{ xl: 4, xxl: 6 }"
          suffix
        >
          <a-input
            v-if="agencyData[0].editable"
            v-model="agencyData[0].IATA_id"
          />

          <template v-else>
            {{ agencyData[0].IATA_id }}
          </template>
        </a-grid-item>
        <a-grid-item class="demo-item">Amadeus Tour User</a-grid-item>
        <a-grid-item
          v-if="agencyData && agencyData[0]"
          class="demo-item"
          :span="{ xl: 4, xxl: 6 }"
          suffix
        >
          <a-input
            v-if="agencyData[0].editable"
            v-model="agencyData[0].amadeus_user"
          />

          <template v-else>
            {{ agencyData[0].amadeus_user }}
          </template>
        </a-grid-item>
        <a-grid-item class="demo-item">Amadeous Tour Password</a-grid-item>
        <a-grid-item
          v-if="agencyData && agencyData[0]"
          class="demo-item"
          :span="{ xl: 4, xxl: 6 }"
          suffix
        >
          <a-input
            v-if="agencyData[0].editable"
            v-model="agencyData[0].amadeus_pwd"
          />

          <template v-else>
            {{ agencyData[0].amadeus_pwd }}
          </template>
        </a-grid-item>
      </a-grid>
      <template v-if="showSaveButton">
        <a-button type="text" class="save_button" @click="onSave()">
          <template #icon>
            <icon-check />
          </template>
          <template #default> Save</template>
        </a-button>
      </template>
    </a-card>
  </div>
</template>

<script lang="ts">
  //   import { useRouter } from 'vue-router';
  import axios from 'axios';
  import { update } from 'lodash';
  // import { IconEdit, IconCheck } from '@arco-design/web-vue/es/icon';

  interface AgencyDataItem {
    CustomerNumber: string;
    AgencyName: string;
    manager_name: string;
    Market: string;
    Name: string;
    email: string;
    phone_num: number;
    address: string;
    office_no: string;
    direct_username: string;
    direct_pwd: string;
    contract_no: string;
    IATA_id: string;
    amadeus_user: string;
    amadeus_pwd: string;
    editable: boolean;
  }
  export default {
    data() {
      return {
        agencyData: [] as AgencyDataItem[],
        showSaveButton: false,
      };
    },
    created() {
      const agencyId = decodeURIComponent(this.$route.query.agencyId);
      this.getAgency(agencyId);
      // console.log(customerNumber);
    },
    methods: {
      async getAgency(agencyId: number) {
        try {
          const response = await axios.get(
            `http://localhost:3000/src/views/api/api.php?action=agencyName&agencyId=${agencyId}`
          );
          this.agencyData = Array.isArray(response.data)
            ? response.data
            : [response.data];
          this.agencyData.forEach((item) => {
            item.editable = false;
          });
          // eslint-disable-next-line no-console
          console.log(this.agencyData);
        } catch (error) {
          // eslint-disable-next-line no-console
          console.error('Error fetching data:', error);
        }
      },
      async updateAgencyData() {
        try {
          // Create an object containing only the editable fields
          const updatedFields = {};
          // eslint-disable-next-line no-console
          // console.log(this.agencyData);

          this.agencyData.forEach((item) => {
            updatedFields.manager_name = item.manager_name;
            updatedFields.Market = item.Market;
            updatedFields.Name = item.Name;
            updatedFields.email = item.email;
            updatedFields.phone_num = item.phone_num;
            updatedFields.address = item.address;
            updatedFields.office_no = item.office_no;
            updatedFields.direct_username = item.direct_username;
            updatedFields.direct_pwd = item.direct_pwd;
            updatedFields.contract_no = item.contract_no;
            updatedFields.IATA_id = item.IATA_id;
            updatedFields.amadeus_user = item.amadeus_user;
            updatedFields.amadeus_pwd = item.amadeus_pwd;
          });

          // Add the CustomerNumber to the updatedFields object
          updatedFields.CustomerNumber = this.agencyData[0].CustomerNumber;
          // console.log(updatedFields)
          const response = await axios.post(
            'http://localhost:3000/src/views/api/api.php?action=updateInfo',
            { agencyData: updatedFields }
          );

          if (response.data.affected_rows >= 1) {
            this.$message.success('Data updated successfully');
            this.getAgency(this.agencyData[0].CustomerNumber);
          } else if (response.data.custom_warning) {
            this.$message.info('No changes were made');
          } else {
            // eslint-disable-next-line no-console
            console.log(response.data);
            this.$message.error('Failed to update data');
          }
        } catch (error) {
          // eslint-disable-next-line no-console
          console.error('Error updating data:', error);
          this.$message.error('Failed to update data');
        }
      },

      onEdit() {
        this.agencyData.forEach((item) => {
          item.editable = true;
        });
        this.showSaveButton = true;
        // eslint-disable-next-line no-console
        // console.log('here is onEdit');
      },
      onSave() {
        this.agencyData.forEach((item) => {
          item.editable = false;
        });
        this.showSaveButton = false;
        // eslint-disable-next-line no-console
        // console.log('here is onSave');
        this.updateAgencyData();
      },
    },
  };
</script>

<style scoped lang="less">
  .edit_button {
    position: absolute;
    top: 2%;
    margin-left: 86%;
  }
  @media (max-width: 768px) {
    .edit_button {
      position: absolute;
      margin-left: 78%;
    }
  }

  .save_button {
    position: relative;
    margin-top: 2%;
    margin-left: 88.5%;
  }
</style>
