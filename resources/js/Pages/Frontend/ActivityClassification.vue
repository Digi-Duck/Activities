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
      selectedType: this.response?.rt_data?.type ?? '',
      images: {
        magnifer,
      },
    };
  },
  computed: {
    rtData() {
      return this.response?.rt_data ?? {};
    },
    title() {
      return this.rtData.title ?? '活動列表';
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
    searchType(id) {
      router.get(route('activityClassification'), { type: id }, {
        preserveState: true,
        preserveScroll: true,
      });
    },
  },
};
</script>

<template>
  <section class="flex flex-col px-[50px] lg:px-[250px] pt-[75px]">
    <!-- 功能按鈕 -->
    <div class="w-full pb-3 flex flex-col">
      <div class="pb-[10px] bg-[#FAFAFA] border-b-[1px] border-b-black text-5xl text-black font-bold">{{ title }}</div>
      <div class="w-full pt-3 px-3 flex justify-between">
        <button type="button" class="px-[15px] rounded-[100px] bg-[#d48f8f45] text-[28px] font-semibold" @click="searchData('')">全部</button>
        <div v-for="(item, index) in rtData.firstHotActivity" :key="index" class="flex gap-3">
          <button type="button" class="p-[5px] rounded-[100px] bg-[#d48f8f45] text-[28px] font-semibold" @click="searchType(item.activity_type)">{{ item.activity_type_name }}</button>
        </div>
        <div class="border bg-white flex items-center">
          <input v-model="keyword" type="search" @search="searchData" class="border-none bg-transparent" placeholder="Search">
          <button type="button" @click="searchData" class="pe-[10px]">
            <img :src="images.magnifer" class="ms-[15px] w-[20px] h-[20px]" alt="我是放大鏡">
          </button>
        </div>
      </div>
    </div>
    <!-- 主要卡片區 -->
    <div v-for="(item, index) in activityClassification" :key="index" class="pt-6 pb-6 border-b-[1px] border-b-black flex flex-col items-center">
      <div class="w-full max-w-[1400px] h-[345px] flex flex-row justify-center">
        <img :src="item.cover_photo ?? ''" alt="活動封面圖" class="inline-block w-[70%] md:w-[50%] 2xl:w-[65%] max-w-[800px] object-cover bg-slate-500">
        <div class="w-[50%] 2xl:w-[35%] h-[345px] bg-[#974a4a] p-8 lg:p-16 flex flex-col justify-evenly gap-2">
          <div class="w-full text-white text-[16px] md:text-[24px] xl:text-[36px]">{{ item.activity_name }}</div>
          <b class="w-full text-black text-[12px] hidden sm:flex xl:text-[18px] items-center">報名截止時間 : {{ item.activity_end_registration_time }}</b>
          <div class="w-full text-white text-[12px] hidden lg:flex xl:text-[18px]">{{ item.activity_info }}</div>
          <PrimaryButton class="flex justify-center">
            <Link :href="route('studentActivityDetails', { id: item.id })">
              查看詳情
            </Link>
          </PrimaryButton>
        </div>
      </div>
    </div>
    <Link class="fixed right-[2.5%] bottom-[2.5%] text-gray-900 bg-gradient-to-r from-red-200 via-red-300 to-yellow-200 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-red-100 dark:focus:ring-red-400 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">回到頁首</Link>
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
