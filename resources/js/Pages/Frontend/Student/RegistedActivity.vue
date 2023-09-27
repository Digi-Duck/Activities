<!-- 學員編輯活動頁面 -->
<!-- 學員已報名活動編輯頁面 -->

<script>
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
};
</script>

<template>
  <section id="presenter-finished-activity" class="flex flex-col justify-between items-center gap-5">
    <!-- 這是點我收藏按鈕 -->
    <button type="button" class="absolute mt-[5%] left-[75%] w-[137px] h-[41px] z-30 bg-white rounded-[15px] flex justify-center items-center text-[20px] font-bold">點我收藏</button>
    <CountDown class="absolute mt-[7.5%] left-[75%]"></CountDown>
    <!-- 這是QRcode的位置 -->
    <div class="absolute mt-[5%] left-[60%]">
      <img src="" class="w-[261px] h-[261px] bg-black" alt="">
    </div>
    <ActivityDetailSwiper></ActivityDetailSwiper>
    <!-- 這裡是活動詳情 -->
    <div class="w-full h-[811px] bg-[pink]"></div>
    <!-- 學員活動資訊填寫區 -->
    <ActivityEnroll></ActivityEnroll>
  </section>
</template>

<style lang="scss" scoped>
#presenter-finished-activity {
  @apply w-full h-full overflow-y-auto;

  .title {
    @apply text-[6.25rem] text-center;
  }

  .btn-base {
    @apply p-1.5 border-2 rounded-md border-green-500 cursor-pointer;
  }
}
</style>
