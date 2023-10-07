<!-- 講師掃描QRcode頁面 -->

<script>
import Swal from 'sweetalert2';
import { router } from '@inertiajs/vue3';
import { Html5Qrcode } from 'html5-qrcode';

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
      handling: false,
      hasDevices: true,
    };
  },
  mounted() {
    this.openCamera();
  },
  methods: {
    /**
     * 開啟相機
     */
    openCamera() {
      Html5Qrcode.getCameras().then((devices) => {
        if (!devices || !devices?.length) {
          this.hasDevices = false;
          return;
        }

        const html5QrCode = new Html5Qrcode('reader');
        const qrCodeSuccessCallback = (decodedText) => {
          if (this.handling) return;

          this.handling = true;
          showScanningTip(decodedText);
        };

        const config = {
          fps: 10,
          qrbox: this.qrboxSize,
        };

        html5QrCode.start({ facingMode: 'environment' }, config, qrCodeSuccessCallback);
      });
    },

    /**
     * 掃描器的範圍
     * @param {number} viewfinderWidth 可視寬度
     * @param {number} viewfinderHeight 可視高度
     * @return {object} 回傳掃描器的範圍尺寸
     */
    qrboxSize(viewfinderWidth, viewfinderHeight) {
      const minEdgePercentage = 0.7;
      const minEdgeSize = Math.min(viewfinderWidth, viewfinderHeight);
      const qrboxSize = Math.floor(minEdgeSize * minEdgePercentage);
      return {
        width: qrboxSize,
        height: qrboxSize,
      };
    },

    /**
     * 是否掃描提醒
     * @param {string} code 代碼
     */
    showScanningTip(code) {
      if (!code) {
        Swal.fire({
          icon: 'error',
          title: '請掃描正確的QR-code',
        }).then((result) => {
          if (result.isConfirmed) {
            this.handling = false;
          }
        });

        return;
      }

      Swal.fire({
        title: '是否確認掃描',
        showCancelButton: true,
        confirmButtonText: '確認',
        cancelButtonText: '取消',
      }).then((result) => {
        if (result.isConfirmed) {
          this.sendScanningRes(code);
        } else {
          this.handling = false;
        }
      });
    },

    /**
     * 送出掃描
     * @param {string} code 代碼
     */
    sendScanningRes(code) {
      router.post('這裡要填入路由', { code }, {
        preserveState: true,
        preserveScroll: true,
        onSuccess: ({ props: { flash: { message = {} } = {} } = {} } = {}) => {
          const rtMessage = message?.rt_code ? 'success' : 'fail';
          const { icon, title } = {
            success: { icon: 'tip', title: '報到成功' },
            fail: { icon: 'error', title: message?.rt_message ?? '' },
          }[rtMessage];

          Swal.fire({ icon, title }).then((result) => {
            if (result.isConfirmed) {
              this.handling = false;
            }
          });
        },
      });
    },
  },
};
</script>

<template>
  <section id="presenter-scanner">
    <CountDown class="absolute mt-[5%] left-[75%]" />
    <ActivityDetailSwiper />
    <!-- 掃描區域 -->
    <div class="relative w-full p-5 bg-[#194e694e] flex flex-col items-center gap-5">
      <!-- 顯示報到狀況人數 -->
      <div class="flex gap-[100px] text-[35px]">
        <div class="flex items-center gap-3">
          <img src="" class="w-[50px] h-[50px] bg-[yellow]" alt="">
          總報名人數</div>
        <div class="flex items-center gap-3">
          <img src="" class="w-[50px] h-[50px] bg-[yellow]" alt="">
          已報到人數</div>
      </div>

      <!-- 這是掃描區域 -->
      <b class="absolute top-1/2 -translate-y-1/2 text-6xl text-white">
        {{ hasDevices ? '請稍等相機開啟' : '無法開啟相機' }}
      </b>
      <div id="reader" class="w-full min-h-[500px] bg-black"></div>
      <button type="button" class="w-[299px] h-[54px] bg-[#1C8AAD] rounded-[5px] text-white flex justify-center items-center">掃描報到</button>
    </div>
    <!-- 活動的參加名單 -->
    <ActivityDetailTable />
  </section>
</template>

<style lang="scss" scoped>
#presenter-scanner {
  @apply w-full h-full overflow-y-auto flex flex-col items-center gap-5;
}
</style>
