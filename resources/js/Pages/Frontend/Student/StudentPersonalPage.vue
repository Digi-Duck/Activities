<!-- 學員會員介面 -->

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
  <section id="presenter-personal-page" class="flex flex-col items-center">
    <!-- 這個是已報名還沒去的活動 -->
    <ActivitySwiper></ActivitySwiper>
    <!-- 這個是已收藏的活動 -->
    <ActivitySwiper></ActivitySwiper>
    <ActivityDetailTable></ActivityDetailTable>
    <ActivitySwiper></ActivitySwiper>
  </section>
</template>

<style lang="scss" scoped>
#presenter-personal-page {
  @apply w-full h-full overflow-y-auto;

  .title {
    @apply text-[6.25rem] text-center;
  }

  .btn-base {
    @apply p-1.5 border-2 rounded-md border-green-500 cursor-pointer;
  }
}
</style>
