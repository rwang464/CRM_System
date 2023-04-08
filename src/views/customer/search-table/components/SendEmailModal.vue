<template>
  <a-modal
    v-model="visible"
    title="Send Email"
    :footer="false"
    @cancel="hideModal"
  >
    <a-form :model="emailForm" :style="{ width: '480px' }">
      <a-form-item field="emailTo" label="To:" style="margin-left: -18px">
        <a-input v-model="emailForm.emailTo" />
      </a-form-item>
      <a-divider style="margin-top: -10px" />

      <a-form-item field="emailSub" style="margin-left: -50px">
        <a-input v-model="emailForm.emailSub" placeholder="Subject" />
      </a-form-item>
      <a-divider style="margin-top: -10px" />

      <a-textarea
        :default-value="`Hello!\n\nThank you for using Amadeus, we have calculated incentives for your segments. Please find attached a PDF copy of the payout and let us know if you have questions.`"
        :auto-size="{
          minRows: 8,
          maxRows: 50,
        }"
        style="width: 90%; margin-top: 20px; margin-left: 25px"
      />
    </a-form>
  </a-modal>
</template>

<script lang="ts" setup>
  import { ref, reactive } from 'vue';

  //   import { Modal, Input, Textarea, Button, Space } from '@arco-design/web-vue';

  const tableCreatedModel = () => {
    return {
      emailSent: ' ',
      emailTo: '',
      emailSub: 'Your payout is ready',
    };
  };
  const emailForm = ref(tableCreatedModel());

  const visible = ref(false);

  const hideModal = () => {
    visible.value = false;
  };

  const sendEmail = () => {
    // 这里可以添加发送邮件的逻辑
    hideModal();
  };
</script>

<style scoped>
  .arco-modal {
    width: 540px;
  }

  .arco-input-focus {
    margin-left: -15px;
    border-color: white;
    outline: none;
  }

  .arco-input-wrapper {
    margin-left: -20px;
    background-color: white;
    border: none;
    outline: none;
    box-shadow: none;
  }

  /* .arco-form-item-content-wrapper{
margin-left: -40px;

} */

  .arco-divider-horizontal {
    width: 100%;
    max-width: 88%;
  }

  .arco-textarea-focus {
    border-color: white;
    outline: none;
  }

  .arco-textarea-wrapper {
    background-color: white;
  }
</style>
