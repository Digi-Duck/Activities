<!-- 講師掃描QRcode頁面 -->

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
  <section id="presenter-scanner" class="flex flex-col items-center gap-5">
    <CountDown class="absolute mt-[5%] left-[75%]"></CountDown>
    <ActivityDetailSwiper></ActivityDetailSwiper>
    <!-- 掃描區域 -->
    <div class="w-full h-[997px] p-5 bg-[#194e694e] flex flex-col items-center gap-5">
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
      <div class="w-full h-[800px] bg-black"></div>
      <button type="button" class="w-[299px] h-[54px] bg-[#1C8AAD] rounded-[5px] text-white flex justify-center items-center">掃描報到</button>
    </div>
    <!-- 活動的參加名單 -->
    <ActivityDetailTable></ActivityDetailTable>
  </section>
</template>

<style lang="scss" scoped>
#presenter-scanner {
  @apply w-full h-full overflow-y-auto;

  .title {
    @apply text-[6.25rem] text-center;
  }

  .btn-base {
    @apply p-1.5 border-2 rounded-md border-green-500 cursor-pointer;
  }
}
</style>
