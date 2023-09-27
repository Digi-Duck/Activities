<!-- 學員活動報名頁面 -->

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
    <CountDown class="absolute mt-[5%] left-[75%]"></CountDown>
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
