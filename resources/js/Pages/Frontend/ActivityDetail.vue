<!-- 活動詳細頁面 -->

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
  <section id="activity-detail" class="flex justify-center items-center flex-col">
    <div id="swiper" class="w-full h-[602px] bg-[#031926]"></div>
    <div id="calendar" class="w-full h-[340px] bg-white"></div>
    <div id="top-activity" class="w-[1440px] h-[765px] bg-[#F3F3F1]"></div>
    <div id="recent-activity" class="w-[1909px] h-[537px] bg-[#9898b3]"></div>
    <div id="recent-activity-detail" class="w-[1400px] h-[505px] bg-black"></div>
  </section>
</template>

<style lang="scss" scoped>
#activity-detail {
  @apply w-full h-full overflow-y-auto;

  .title {
    @apply text-[6.25rem] text-center;
  }

  .btn-base {
    @apply p-1.5 border-2 rounded-md border-green-500 cursor-pointer;
  }
}
</style>
