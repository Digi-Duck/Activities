<!-- 活動分類頁面 -->

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
  <section class="flex flex-col px-[250px] pt-[75px]">
    <!-- 功能按鈕 -->
    <div class="w-full pb-3 flex flex-col">
      <div class="pb-[10px] bg-white border-b-4 text-5xl text-black font-bold">當前類型</div>
      <div class="w-full pt-3 px-3 flex justify-between">
        <div class="flex gap-3">
          <button type="button" class="w-[112px] h-[44px] rounded-[100px] bg-[#d48f8f45] text-[28px] font-semibold btn">熱門</button>
          <button type="button" class="w-[112px] h-[44px] rounded-[100px] bg-[#d48f8f45] text-[28px] font-semibold btn">美術</button>
          <button type="button" class="w-[112px] h-[44px] rounded-[100px] bg-[#d48f8f45] text-[28px] font-semibold btn">科技</button>
        </div>
        <div class="flex items-center">
          <input type="search" name="" id="" placeholder="Search">
          <img src="" alt="我是放大鏡">
        </div>
      </div>
    </div>
    <!-- 主要卡片區 -->
    <!-- 正轉卡片 -->
    <div class="pt-3 pb-3 border-b-8 flex flex-col items-center">
      <div class="w-full h-[345px] bg-pink-500 flex flex-row">
        <img src="" alt="" class="w-[200%] bg-slate-500">
        <div class="w-full h-[345px] bg-yellow-500 p-16 flex flex-col justify-between">
          <div class="w-full text-white text-[24px]">活動名稱</div>
          <div class="w-full text-black text-[14px]">活動截止時間</div>
          <div class="w-full text-white text-[14px]">活動info</div>
          <button type="button" class="text-black bg-[#a9bcc64f]">活動詳情</button>
        </div>
      </div>
    </div>
    <!-- 逆轉卡片 -->
    <div class="pt-3 pb-3 border-b-8 flex flex-col items-center">
      <div class="w-full h-[345px] bg-pink-500 flex flex-row">
        <div class="w-full h-[345px] bg-yellow-500 p-16 flex flex-col justify-between">
          <div class="w-full text-white text-[24px]">活動名稱</div>
          <div class="w-full text-black text-[14px]">活動截止時間</div>
          <div class="w-full text-white text-[14px]">活動info</div>
          <button type="button" class="text-black bg-[#a9bcc64f]">活動詳情</button>
        </div>
        <img src="" alt="" class="w-[200%] bg-slate-500">
      </div>
    </div>
  </section>
</template>

<style lang="scss" scoped>
#activity-classification {
  @apply w-full h-full overflow-y-auto;

  .title {
    @apply text-[6.25rem] text-center;
  }

  .btn-base {
    @apply p-1.5 border-2 rounded-md border-green-500 cursor-pointer;
  }
}
</style>
