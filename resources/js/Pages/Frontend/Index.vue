<!-- 前台首頁頁面 -->
<script>
import arrowLeft from '/images/icon/icon-arrow-left.svg';
import arrowRight from '/images/icon/icon-arrow-right.svg';
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
      prevButton: null,
      nextButton: null,
      keyword: this.response?.rt_data?.keyword ?? '',
      selectedType: this.response?.rt_data?.type ?? '',
      images: {
        arrowLeft,
        arrowRight,
        magnifer,
      },
    };
  },
  computed: {
    // 後端回傳資料
    rtData() {
      return this.response?.rt_data ?? {};
    },
    // 獲取活動資料陣列
    activityData() {
      return this.rtData.activity ?? [];
    },
    // 獲取活動搜尋欄資料陣列
    activityTableData() {
      return this.rtData.activityTable ?? {};
    },

    // 獲取最夯活動單筆資料
    hottestActivityData() {
      return this.rtData.hottestActivity ?? {};
    },

    // 獲取活動類別資料陣列
    activityTypeData() {
      return this.rtData.activityTypeData ?? [];
    },
  },
  mounted() {
    this.initSwiperBtn();
  },
  methods: {
    /**
     * 獲取按钮元素並賦值给 prevButton 和 nextButton
     */
    initSwiperBtn() {
      const { $refs } = this;
      this.prevButton = $refs.btnPrev;
      this.nextButton = $refs.btnNext;
    },
    searchData() {
      router.get(route('index'), { keyword: this.keyword, type: this.selectedType }, {
        preserveState: true,
        preserveScroll: true,
      });
    },
  },
};
</script>

<template>
  <section id="frontend-index" class="flex flex-col items-center">
    <!-- 熱門活動Swiper -->
    <div class="relative w-full h-[600px] bg-[#031926] overflow-hidden">
      <!-- 這組是按鈕 -->
      <div class="absolute top-[50%] left-[2.5%] w-[92.5%] flex justify-between items-center">
        <button ref="btnPrev" id="prevBtn" class="h-[50px] w-[50px] z-50 rounded-[50px] bg-white" type="button">
          <img :src="images.arrowLeft" alt="活動照片海報向左移動按鈕">
        </button>
        <button ref="btnNext" id="nextBtn" class="h-[50px] w-[50px] z-50 rounded-[50px] bg-white" type="button">
          <img :src="images.arrowRight" alt="活動照片海報向右移動按鈕">
        </button>
      </div>
      <!-- 活動資訊 -->
      <Swiper v-slot="{ slide }" :slide-data="activityData ?? []" class="absolute w-full h-[602px] text-center" :btn-prev="prevButton" :btn-next="nextButton">
        <img :src="slide.cover_photo" class="inline-block w-[90%] h-full object-contain" alt="活動背景圖">
        <h2 class="absolute top-[100px] w-full pe-[150px] bg-[#ffffff95] text-[64px] text-end text-white">
          {{ slide.activity_name }}
        </h2>
        <div class="absolute top-[200px] w-full h-[59px] pe-[150px] bg-[#ffffff3a] text-[48px] text-end text-white">
          <h3 class="z-10">
            {{ slide.activity_info }}
          </h3>
        </div>
      </Swiper>
      <!-- 活動封面照片組合Swiper -->
      <Swiper v-slot="{ slide }" :slide-data="activityData ?? []" :slides-per-view="3" :space-between="15" class="absolute -top-[15%] rotate-[10deg]" :btn-prev="prevButton" :btn-next="nextButton">
        <Link :href="route('studentActivityDetails', { id: slide.id })" class="inline-block border border-[black] w-[512px] h-[384px] bg-[white]">
          <img :src="slide.cover_photo" class="w-full h-full object-cover" alt="產業類別圖片">
        </Link>
      </Swiper>
    </div>

    <!-- 最夯活動Banner -->
    <Link :href="route('studentActivityDetails', { id: hottestActivityData.id })" v-if="hottestActivityData.activity_type_name" class="w-full max-w-[1400px] h-[765px] pt-[38px] bg-[#F3F3F1] rounded-[64px] flex flex-col justify-between items-center">
      <!-- 活動快速資訊 -->
      <div class="text-[17px] flex items-center gap-1">
        <!-- 活動類型 -->
        <div class="text-[17px]">
          活動類型:
          {{ hottestActivityData.activity_type_name }}
        </div>
        <div class="ps-[5px] border-s-8 border-[#000] text-[17px]">課程收藏人數:
          {{ hottestActivityData.collection_count }}
        </div>
      </div>
      <div class="flex flex-col items-center gap-3">
        <b class="text-[55px]">
          {{ hottestActivityData.activity_name }}
        </b>
        <h2>
          {{ hottestActivityData.activity_presenter }}
        </h2>
        <time class="text-[30px]">
          <span class="text-[24px]">
            活動開始時間：
          </span>
          {{ hottestActivityData.activity_start_time }}
        </time>
      </div>
      <figure class="relative w-full max-w-[1400px] h-[450px] flex">
        <img :src="hottestActivityData.cover_photo" class="absolute xl-hidden w-[770px] h-full rounded-[64px] opacity-[20%] bg-green-600" alt="半透明活動主照片">
        <img :src="hottestActivityData.cover_photo" class="absolute md:ms-[10%] xl:ms-[17.5%] w-[900px] h-full z-10 rounded-[64px]" alt="活動主照片">
        <img :src="hottestActivityData.cover_photo" class="absolute end-0 w-[770px] h-full rounded-[64px] opacity-[20%] bg-blue-600" alt="半透明活動主照片">
      </figure>
    </Link>
    <div v-else></div>

    <ActivitySwiper :slide-data="activityData ?? []" href="studentActivityDetails" />

    <div class="m-auto w-full max-w-[1400px] h-[505px] p-10 flex flex-col items-center">
      <!-- 搜尋欄位 -->
      <div class="mb-[5px] w-full h-[48px] pt-[10px] border-t-[#000] border-t-[1px] flex justify-between">
        <!-- 文字搜尋框 -->
        <div class="w-[15%] h-full bg-[#80808012] flex justify-center items-center gap-3">
          <input v-model="keyword" type="search" class="w-[80%] h-[80%]" @search="searchData" placeholder="請輸入搜尋資訊">
          <button type="button" @click="searchData">
            <img :src="images.magnifer" class="w-[16px]" alt="搜尋">
          </button>
        </div>
      </div>
      <!-- 搜尋的表頭 -->
      <div class="w-full h-[60px] flex">
        <div class="flex-none w-[50%] border bg-[#5D8BA3] flex justify-center items-center text-[24px]">
          <slot name="activity_title_name">活動名稱</slot>
        </div>
        <div class="flex-initial w-[10%] border bg-[#82ACC2] flex justify-center items-center text-[24px]">
          <slot name="activity_title_type">主講者</slot>
        </div>
        <div class="flex-initial w-[20%] border bg-[#A9BCC6] flex justify-center items-center text-[24px]">
          <slot name="activity_title_time">報名截止時間</slot>
        </div>
        <div class="flex-initial w-[20%] border bg-[#A9BCC6] flex justify-center items-center text-[24px]">
          <slot name="activity_title_number">人數狀況</slot>
        </div>
      </div>
      <!-- 詳細搜尋內容 -->
      <div v-for="(item, index) in activityTableData?.data ?? []" :key="index" class="w-full h-[53px] flex">
        <Link :href="route('studentActivityDetails', { id: item.id })" class="flex-none w-[50%] ps-3 border bg-[#a9bcc67e] flex justify-start items-center text-[16px]">
          {{ item.activity_name }}
        </Link>
        <div class="flex-initial w-[10%] border bg-[#82acc27d] flex justify-center items-center text-[16px] font-semibold">
          <slot name="activity_info_type">
            {{ item.activity_presenter }}
          </slot>
        </div>
        <div class="flex-initial w-[20%] ps-3 border bg-[#a9bcc67e] flex justify-start items-center text-[16px]">
          {{ item.activity_end_registration_time }}
        </div>
        <div class="flex-initial w-[20%] ps-3 border bg-[#a9bcc67e] flex justify-between items-center text-[16px]">
          <slot name="student_additional_remark">
            <div>
              門檻:{{ item.activity_lowest_number_of_people }}
              上限:{{ item.activity_highest_number_of_people }}
            </div>
            <div class="pe-3 flex items-center justify-center">
              目前人數：{{ item.registration_count }}
            </div>
          </slot>
        </div>
      </div>
      <Pagination :pagination-data="activityTableData" class="pt-3" />
    </div>
  </section>
</template>

<style lang="scss" scoped>
#frontend-index {
  @apply flex justify-center items-center flex-col gap-5;
}
</style>
