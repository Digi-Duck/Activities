<!-- 前台首頁頁面 -->
<script>
import arrowLeft from '/images/icon/icon-arrow-left.svg';
import arrowRight from '/images/icon/icon-arrow-right.svg';

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
      rtData: this.response?.rt_data ?? {},
      prevButton: null, // 在這裡定義 prevButton 和 nextButton
      nextButton: null,
      images: {
        arrowLeft,
        arrowRight,
      },
    };
  },
  computed: {
    // 獲取活動資料陣列
    activityData() {
      return this.rtData.activity ?? {};
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
  },
};
</script>

<template>
  <section id="frontend-index">
    <!-- 熱門活動Swiper -->
    <div class="relative w-full h-[602px] bg-[#031926] overflow-hidden">
      <!-- 這組是按鈕 -->
      <div class="absolute top-[50%] left-[2.5%] w-[95%] flex justify-between">
        <button ref="btnPrev" id="prevBtn" class="h-[50px] w-[50px] z-50 rounded-[50px] bg-white" type="button">
          <img :src="images.arrowLeft" alt="活動照片海報向左移動按鈕">
        </button>
        <button ref="btnNext" id="nextBtn" class="h-[50px] w-[50px] z-50 rounded-[50px] bg-white" type="button">
          <img :src="images.arrowRight" alt="活動照片海報向右移動按鈕">
        </button>
      </div>

      <!-- 活動資訊 -->
      <h2 class="absolute left-[1223px] top-[88px] text-[64px] text-white">
        活動名稱
      </h2>
      <div class="absolute top-[173px] w-full h-[59px] bg-[#ffffff57] text-[48px] text-white">
        <h3 class="absolute left-[1223px] z-10">
          活動Slogan
        </h3>
      </div>

      <!-- 這裡長了一個斜的Swiper -->
      <!-- 活動封面照片組合Swiper -->
      <Swiper v-slot="{ slide }" :slide-data="activityData.data ?? []" :slides-per-view=4 :space-between=30 class="relative -left-[50px] top-[400px] rotate-[10deg]" :btn-prev="prevButton" :btn-next="nextButton">
        <Link :href="route('studentActivityDetails', { id: slide.id })">
          <img :src="slide.cover_photo" class="w-[512px] h-[384px] object-cover" alt="產業類別圖片">
        </Link>
      </Swiper>
    </div>
    <!-- 活動行事曆 -->
    <div class="w-full h-[340px] bg-white"></div>
    <!-- 最夯活動Banner -->
    <Link :href="route('studentActivityDetails', { id: hottestActivityData.id })" v-if="hottestActivityData.activity_type_name" class="w-[1440px] h-[765px] pt-[38px] bg-[#F3F3F1] rounded-[64px] flex flex-col justify-between items-center">
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
      <figure class="relative w-full h-[450px] flex">
        <img :src="hottestActivityData.cover_photo" class="absolute w-[770px] h-full rounded-[64px] opacity-[20%] bg-green-600" alt="">
        <img :src="hottestActivityData.cover_photo" class="absolute ms-[20%] w-[900px] h-full z-10 rounded-[64px]" alt="">
        <img :src="hottestActivityData.cover_photo" class="absolute end-0 w-[770px] h-full rounded-[64px] opacity-[20%] bg-blue-600" alt="">
      </figure>
    </Link>
    <div v-else></div>

    <ActivitySwiper :slide-data="activityData?.data ?? []" href="studentActivityDetails" />

    <!-- 近期活動查詢表 -->
    <ActivityDetailTable :table-data="activityData" :type-data="activityTypeData">
      <template #activity_title_type>
        <span>
          主講者
        </span>
      </template>
    </ActivityDetailTable>
  </section>
</template>

<style lang="scss" scoped>
#frontend-index {
  @apply flex justify-center items-center flex-col gap-5;
}
</style>
