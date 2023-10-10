<!-- 活動分類頁面 -->

<script>
import magnifer from '/images/icon/magnifer.svg';
import { router } from '@inertiajs/vue3';
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
      keyword: this.response?.rt_data?.keyword ?? '',
      images: {
        magnifer,
      },
    };
  },
  computed: {
    rtData() {
      return this.response?.rt_data ?? {};
    },
    activityClassification() {
      return this.rtData.activity;
    },
  },
  methods: {
    searchData() {
      router.get(route('activityClassification'), { keyword: this.keyword }, {
        preserveState: true,
        preserveScroll: true,
      });
    },
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
          <input v-model="keyword" type="search" @search="searchData" placeholder="Search">
          <img :src="images.magnifer" class="ms-[15px] w-[20px] h-[20px]" alt="我是放大鏡">
        </div>
      </div>
    </div>
    <!-- 主要卡片區 -->
    <Link v-for="(item, index) in activityClassification" :key="index" :href="route('studentActivityDetails', { id: item.id })" class="pt-3 pb-3 border-b-8 flex flex-col items-center">
      <!-- {{ item.activityPhotos }} -->
      <div class="w-full h-[345px] bg-pink-500 flex flex-row">
        <img :src="item.activityPhotos[0]?.activity_img_path ?? ''" alt="活動封面圖" class="w-[300%] max-w-[937.438px] object-fill bg-slate-500">
        <div class="w-full h-[345px] bg-[#974a4a] p-16 flex flex-col justify-center gap-2">
          <div class="w-full text-white text-[36px]">{{ item.activity_name }}</div>
          <div class="w-full text-black text-[18px]">{{ item.activity_end_registration_time }}</div>
          <div class="w-full text-white text-[18px]">{{ item.activity_info }}</div>
          <button type="button" class="text-black bg-[#a9bcc64f]">活動詳情</button>
        </div>
      </div>
    </Link>
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
