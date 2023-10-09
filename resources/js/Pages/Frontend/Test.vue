<script>
import QRCode from 'qrcode';
export default {
  props: {
    response: {
      type: Object,
      required: false,
      default: () => ({}),
    },
  },
  data() {
    return {
      title: 'Hello World !',
      qrcodeImage: '123',
    };
  },
  created() {
  },
  methods: {
    // 在需要時生成QR Code
    generateQRCode() {
      // 這是要生成QR Code的數據，您可以使用您的數據
      // const qrData = '123';

      // 創建QR Code
      QRCode.toDataURL(this.qrcodeImage, (err, url) => {
        if (!err) {
          this.qrcodeImage = url;
        }
      });
    },
  },
};
</script>

<template>
  <section id="test">
    <button type="button" class="h-[100px] w-[100px] bg-[pink] rounded-full" @click="generateQRCode">按按鈕</button>
    <img :src="qrcodeImage" id="qrcode-image" alt="QR Code" />
  </section>
</template>

<style lang="scss" scoped>
#test {
  @apply w-full h-full overflow-y-auto;

  .title {
    @apply text-[6.25rem] text-center;
  }

  .btn-base {
    @apply p-1.5 border-2 rounded-md border-green-500 cursor-pointer;
  }
}
</style>
