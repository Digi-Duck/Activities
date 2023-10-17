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
    rtData() {
      return this.response?.rt_data ?? {};
    },
    activityData() {
      return this.rtData.activity ?? [];
    },
    activityTableData() {
      return this.rtData.activityTable ?? {};
    },
    hottestActivityData() {
      return this.rtData.hottestActivity ?? {};
    },
    activityTypeData() {
      return this.rtData.activityTypeData ?? [];
    },
  },
  mounted() {
    this.initSwiperBtn();
  },
  methods: {
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

    <div class="relative w-full h-[600px] bg-[#031926] overflow-hidden">

      <div class="absolute top-[50%] left-[2.5%] w-[92.5%] flex justify-between items-center">
        <button ref="btnPrev" id="prevBtn" class="h-[50px] w-[50px] z-50 rounded-[50px] bg-white" type="button">
          <img :src="images.arrowLeft" alt="活動照片海報向左移動按鈕">
        </button>
        <button ref="btnNext" id="nextBtn" class="h-[50px] w-[50px] z-50 rounded-[50px] bg-white" type="button">
          <img :src="images.arrowRight" alt="活動照片海報向右移動按鈕">
        </button>
      </div>

      <Swiper v-slot="{ slide }" :slide-data="activityData ?? []" class="absolute w-full h-[602px] text-start" :btn-prev="prevButton" :btn-next="nextButton">
        <img :src="slide.cover_photo" class="inline-block w-[90%] h-full object-contain" alt="活動背景圖">
        <h2 class="absolute top-10 sm:top-0 md:top-[100px] w-full pe-[150px] bg-[#3f3d3d95] text-[32px] md:text-[64px] text-end text-white">
          {{ slide.activity_name }}
        </h2>
        <div class="absolute top-[100px] md:top-[200px] w-full h-[59px] pe-[150px] hidden 2xl:block bg-[#ffffff3a] text-[48px] text-end text-white">
          <h3 class="z-10">
            {{ slide.activity_info }}
          </h3>
        </div>
      </Swiper>

      <Swiper v-slot="{ slide }" :slide-data="activityData ?? []" :slides-per-view="4" :space-between="300" class="absolute -top-[28%] -left-[3%] border-t-[10px] border-t-[#ffffff9d] lg:rotate-[10deg]" :btn-prev="prevButton" :btn-next="nextButton">
        <Link :href="route('studentActivityDetails', { id: slide.id })" class="inline-block w-[512px] h-[384px] border-[2px] border-[black] border-t-[0px] rounded-[5px] bg-[white]">
          <img :src="slide.cover_photo" class="w-full h-full opacity-80 object-cover hover:opacity-100 hover:transform-[150%]" alt="產業類別圖片">
        </Link>
      </Swiper>
    </div>

    <div v-if="hottestActivityData.activity_type_name" class="w-full max-w-[1400px] h-[765px] pt-[38px] bg-[#F3F3F1] rounded-[64px] flex flex-col justify-center items-center gap-1">
      <div class="text-[17px] flex items-center gap-1">
        <b class="text-[17px]">
          活動類型:
          {{ hottestActivityData.activity_type_name }}
        </b>
        <b class="ps-[5px] border-s-8 border-[#000] text-[17px]">課程收藏人數:
          {{ hottestActivityData.collection_count }}
        </b>
      </div>
      <b class="flex gap-3 items-center">
        報名狀態
        <div class="w-64 h-4 bg-gray-300 rounded-full">
          <div class="h-full text-center text-white bg-[#00B67A] rounded-full transition-all transform flex items-center justify-center" :style="'width:' + hottestActivityData.registration_count + '%'">
            {{ hottestActivityData.registration_count }}%
          </div>
        </div>
      </b>
      <div class="flex flex-col items-center gap-3">
        <b class="text-[55px]">
          {{ hottestActivityData.activity_name }}
        </b>
        <b class="text-[45px] text-[#2665D6]">
          {{ hottestActivityData.activity_presenter }}
        </b>
        <time class="text-[30px] font-semibold">
          <span class="text-[24px]">
            活動開始時間：
          </span>
          {{ hottestActivityData.activity_start_time }}
        </time>
      </div>
      <figure class="relative w-full max-w-[1400px] h-[450px] flex">
        <img :src="hottestActivityData.cover_photo" class="absolute xl-hidden w-[770px] h-full rounded-[64px] aspect-square opacity-[20%] bg-green-600" alt="半透明活動主照片">
        <Link :href="route('studentActivityDetails', { id: hottestActivityData.id })">
          <img :src="hottestActivityData.cover_photo" class="absolute ms-0 lg:ms-[6.5%] xl:ms-[17.5%] w-[900px] h-full z-10 rounded-[64px] object-cover" alt="活動主照片">
        </Link>
        <img :src="hottestActivityData.cover_photo" class="absolute end-0 w-[770px] h-full rounded-[64px] aspect-square opacity-[20%] bg-blue-600" alt="半透明活動主照片">
      </figure>
    </div>
    <div v-else></div>

    <ActivitySwiper :slide-data="activityData ?? []" href="studentActivityDetails" />

    <div class="w-full max-w-[1400px] h-[505px] p-10 flex flex-col items-center">
      <!-- 搜尋欄位 -->
      <div class="mb-[5px] w-full h-[48px] pt-[10px] pe-[10px] border-t-[#000] border-t-[1px] flex justify-end">
        <!-- 文字搜尋框 -->
        <div class="w-[40%] lg:w-[15%] h-full bg-[#80808012] flex justify-center items-center gap-3">
          <input v-model="keyword" type="search" class="w-[80%] h-[80%]" @search="searchData" placeholder="請輸入搜尋資訊">
          <button type="button" @click="searchData">
            <img :src="images.magnifer" class="w-[16px]" alt="搜尋">
          </button>
        </div>
      </div>
      <!-- 搜尋的表頭 -->
      <div class="w-full h-[60px] flex">
        <b class="flex-1 md:flex-none md:w-[40%] xl:w-[50%] border bg-[#5D8BA3] flex justify-center items-center text-[24px]">
          <slot name="activity_title_name">活動名稱</slot>
        </b>
        <b class="flex-1 md:flex-initial w-[15%] border bg-[#82ACC2] flex justify-center items-center text-[24px]">
          <slot name="activity_title_type">主講者</slot>
        </b>
        <b class="flex-1 md:flex-initial w-[15%] border bg-[#A9BCC6] flex justify-center items-center text-[24px]">
          <slot name="activity_title_time">報名截止時間</slot>
        </b>
        <b class="flex-1 md:flex-initial w-[30%] xl:w-[20%] border bg-[#A9BCC6] flex justify-center items-center text-[24px]">
          <slot name="activity_title_number">人數狀況</slot>
        </b>
      </div>
      <!-- 詳細搜尋內容 -->
      <div v-for="(item, index) in activityTableData?.data ?? []" :key="index" class="w-full h-[53px] flex">
        <Link :href="route('studentActivityDetails', { id: item.id })" class="flex-1 md:flex-none md:w-[40%] xl:w-[50%] ps-3 border bg-[#5d8aa37d] flex justify-start items-center text-[16px] font-bold underline decoration-1">
          {{ item.activity_name }}
        </Link>
        <div class="flex-1 md:flex-initial w-[15%] ps-3 border bg-[#82acc27d] flex justify-start items-center text-[16px] font-semibold">
          <slot name="activity_info_type">
            {{ item.activity_presenter }}
          </slot>
        </div>
        <b class="flex-1 md:flex-initial w-[15%] ps-3 border bg-[#a9bcc67e] flex justify-start items-center text-[16px]">
          {{ item.activity_end_registration_time }}
        </b>
        <div class="flex-1 md:flex-initial w-[30%] xl:w-[20%] ps-3 border bg-[#a9bcc67e] flex justify-between items-center text-[16px]">
          <slot name="student_additional_remark">
            <div class="hidden md:block">
              <p>
                門檻:{{ item.activity_lowest_number_of_people.toLocaleString() }}
              </p>
              <p>
                名額:{{ item.activity_highest_number_of_people.toLocaleString() }}
              </p>
            </div>
            <div class="pe-3 flex items-center justify-center">
              目前人數：{{ item.registration_count.toLocaleString() }}
            </div>
          </slot>
        </div>
      </div>
      <div class="mt-[15px] w-[313px] h-[56px] bg-white rounded-[30px] border shadow-xl flex justify-center">
        <Pagination :pagination-data="activityTableData" class="pt-3" />
      </div>
    </div>
  </section>
</template>

<style lang="scss" scoped>
#frontend-index {
  @apply flex justify-center items-center flex-col gap-5 transition-all;
}
</style>
