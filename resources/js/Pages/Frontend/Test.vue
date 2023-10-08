<script>
import { QRCode } from 'qrcode';
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
      QRCode.toDataURL('I am a pony!', (err, url) => {
        if (err) {
          console.error(err);
          console.log(url);
        } else {
          // 將QR Code圖像顯示在<img>元素中
          const qrCodeImage = document.getElementById('qrcode-image');
          qrCodeImage.src = 'https://png.pngtree.com/png-vector/20221222/ourmid/pngtree-super-cute-cartoon-vector-bear-png-image_6504049.png';
        }
      });
    },
  },
};
</script>

<template>
  <section id="test">
    <button type="button" class="h-[100px] w-[100px] bg-[pink] rounded-full" @click="generateQRCode">按按鈕</button>
    <img id="qrcode-image" alt="QR Code" />
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
