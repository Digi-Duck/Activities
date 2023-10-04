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
      title: 'Hello World !',
      prevButton: null, // 在这里定义 prevButton 和 nextButton
      nextButton: null,
      images: {
        arrowLeft,
        arrowRight,
      },
    };
  },
  created() {
  },
  mounted() {
    // 通过类名或其他方式获取按钮元素并赋值给 prevButton 和 nextButton
    this.prevButton = this.$refs.btnPrev;
    this.nextButton = this.$refs.btnNext;
  },
};
</script>

<template>
  <!-- {{ response.rt_data }} -->
  <!-- {{ response.rt_data.activity }} -->
  <!-- <hr> -->
  <!-- {{ response.rt_data.hottestActivity }} -->
  <section class="flex justify-center items-center flex-col gap-5">
    <!-- <Swiper v-slot="{ slide }" :slide-data="response?.rt_data.activity ?? ''" :slides-per-view=1 :space-between=30 class="relative w-full h-[602px] bg-[#031926]" :btn-prev="prevButton" :btn-next="nextButton">
      這裡有寫字
      <div class="absolute left-[1223px] top-[88px] text-[64px] text-white">
        {{ slide.activity_name }}
      </div>
      <div class="absolute top-[173px] w-full h-[59px] bg-[#ffffff57] text-[48px] text-white">
        <div class="absolute left-[1223px] z-10">
          {{ slide.activity_info }}
        </div>
      </div>
      <div>
        {{ slide.activityPhotos[0].activity_img_path }}
        <img :src="slide.activityPhotos[0].activity_img_path" class="object-fill" alt="產業類別圖片">
      </div>
    </Swiper> -->
    <!-- 熱門活動Swiper -->
    <div class="relative w-full h-[602px] bg-[#031926] overflow-hidden">
      <!-- 這裡長了一個斜的Swiper -->
      <!-- 這組是按鈕 -->
      <div class="absolute top-[50%] left-[2.5%] w-[95%] flex justify-between">
        <button ref="btnPrev" id="prevBtn" class="h-[50px] w-[50px] z-50 rounded-[50px] bg-white" type="button">
          <img :src="images.arrowLeft" alt="活動照片海報向左移動按鈕">
        </button>
        <button ref="btnNext" id="nextBtn" class="h-[50px] w-[50px] z-50 rounded-[50px] bg-white" type="button">
          <img :src="images.arrowRight" alt="活動照片海報向右移動按鈕">
        </button>
      </div>
      <!-- 這裡有寫字 -->
      <h2 class="absolute left-[1223px] top-[88px] text-[64px] text-white">
        活動名稱
      </h2>
      <div class="absolute top-[173px] w-full h-[59px] bg-[#ffffff57] text-[48px] text-white">
        <h4 class="absolute left-[1223px] z-10">
          活動Slogan
        </h4>
      </div>
      <Swiper v-slot="{ slide }" :slide-data="response?.rt_data.activity ?? ''" :slides-per-view=4 :space-between=30 class="relative -left-[50px] top-[400px] rotate-[10deg]" :btn-prev="prevButton" :btn-next="nextButton">
        <div>
          <!-- {{ slide.activityPhotos?.[0].activity_img_path ?? '' }} -->
          <img :src="slide.activityPhotos?.[0].activity_img_path ?? ''" class="w-[512px] h-[384px] object-cover" alt="產業類別圖片">
        </div>
      </Swiper>
    </div>
    <!-- 活動行事曆 -->
    <div class="w-full h-[340px] bg-white"></div>
    <!-- 最夯活動Banner -->
    <div v-if="response.rt_data.hottestActivity" class="w-[1440px] h-[765px] pt-[38px] bg-[#F3F3F1] flex flex-col justify-between items-center">
      <!-- 活動快速資訊 -->
      <div class="text-[17px] flex gap-1">
        <!-- 活動類型 -->
        <div class="text-[17px]">
          <span v-if="response.rt_data.hottestActivity.activity_type === 1">
            文化與藝術
          </span>
          <span v-else-if="response.rt_data.hottestActivity.activity_type === 2">
            學術與培訓
          </span>
          <span v-else-if="response.rt_data.hottestActivity.activity_type === 3">
            社交與社團
          </span>
          <span v-else-if="response.rt_data.hottestActivity.activity_type === 4">
            旅遊與戶外
          </span>
          <span v-else-if="response.rt_data.hottestActivity.activity_type === 5">
            健康與福祉
          </span>
          <span v-else-if="response.rt_data.hottestActivity.activity_type === 6">
            商業與職業發展
          </span>
          <span v-else-if="response.rt_data.hottestActivity.activity_type === 7">
            娛樂與文化慶典
          </span>
          <span v-else-if="response.rt_data.hottestActivity.activity_type === 8">
            科技與創新
          </span>
          <span v-else>
            其他
          </span>
        </div>
        <img src="" alt="活動收藏熱門進度條">
        <div class="text-[17px]">課程熱度</div>
      </div>
      <div class="flex flex-col items-center">
        <div class="text-[55px]">
          {{ response.rt_data.hottestActivity.activity_name }}
        </div>
        <div class="text-[55px]">
          {{ response.rt_data.hottestActivity.activity_presenter }}
        </div>
        <time class="text-[30px]">
          {{ response.rt_data.hottestActivity.activity_start_time }}
        </time>
      </div>
      <div class="relative mb-[50px] w-full h-[388px] flex">
        <div class="absolute w-[770px] h-full rounded-[64px] bg-green-600"></div>
        <img :src="response.rt_data.hottestActivity.activityPhotos?.[0].activity_img_path" class="absolute ms-[25%] w-[770px] h-full z-10 rounded-[64px] bg-red-600" alt="">
        <div class="absolute end-0 w-[770px] h-full rounded-[64px] bg-blue-600"></div>
      </div>
    </div>
    <div v-else></div>

    <ActivitySwiper :slide-data="response.rt_data.activity">

    </ActivitySwiper>

    <!-- 近期活動查詢表 -->
    <!-- {{ response.rt_data }} -->
    <ActivityDetailTable :table-data="response.rt_data.activity">
      <template #activity_title_type>
        <span>
          主講者
        </span>
      </template>
    </ActivityDetailTable>
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
