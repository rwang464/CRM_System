<template>
  <div style="height: 100%">
    <iframe :src="pdfUrl" frameborder="0" width="100%" height="1000px"></iframe>
  </div>
</template>

<script lang="ts">
  import { defineProps } from 'vue';

  export default {
    name: 'PDFViewer',
    props: {
      pdfUrl: {
        type: String,
        default: '/api/atatravel.space/image/file.pdf',
      },
    },
  };
</script>

<style>
  body,
  html {
    height: 100%;
  }
</style>
