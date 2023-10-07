<!-- 各別活動輪播Swiper -->
<script>
import { router } from '@inertiajs/vue3';
import heart from '/images/icon/icon-heart.svg';
import filledHeart from '/images/icon/icon-filled-heart.svg';
import arrowLeft from '/images/icon/icon-arrow-left.svg';
import arrowRight from '/images/icon/icon-arrow-right.svg';

export default {
  props: {
    slideData: {
      type: Array,
      required: false,
      default: () => [],
    },
    href: {
      type: String,
      required: false,
      default: '',
    },
  },
  data() {
    return {
      prevButton: null,
      nextButton: null,
      images: {
        heart,
        filledHeart,
        arrowLeft,
        arrowRight,
      },
    };
  },
  mounted() {
    // 通过类名或其他方式获取按钮元素并赋值给 prevButton 和 nextButton
    this.prevButton = this.$refs.btnPrev;
    this.nextButton = this.$refs.btnNext;
  },
  methods: {
    linkHref(id) {
      router.get(route(this.href, id));
    },
  },
};
</script>

<template>
  <!-- :href="route('studentActivityDetails', { id: slide.id }) -->
  <div id="activity-swiper" class="relative p-5 flex flex-col items-center">
    <div class="pb-5 text-[48px] self-start ps-[400px]">
      <h2>
        <slot name="activity_title_name">
          近期活動
        </slot>
      </h2>
    </div>
    <div class="absolute top-[50%] z-10 w-[97.5%] flex justify-between">
      <button ref="btnPrev" id="prevBtn" class="h-[50px] w-[50px] rounded-[50px] bg-white" type="button">
        <img :src="images.arrowLeft" alt="活動照片海報向左移動按鈕">
      </button>
      <button ref="btnNext" id="nextBtn" class="h-[50px] w-[50px] rounded-[50px] bg-white" type="button">
        <img :src="images.arrowRight" alt="活動照片海報向右移動按鈕">
      </button>
    </div>

    <Swiper v-slot="{ slide }" :slide-data="slideData ?? []" :slides-per-view=5 :btn-prev="prevButton" :btn-next="nextButton">
      <Link type="button" class="relative m-auto w-[296px] h-[387px] p-3 bg-white border flex flex-col items-center" @click="linkHref(slide.id)">
        <figure>
          <img :src="slide.cover_photo" class="w-[275px] h-[275px] object-cover" alt="產業類別圖片">
          <div class="w-full ps-3 flex flex-col gap-1">
            <div class="text-[16px] font-semibold">
              {{ slide.activity_name }}
              <slot name="activity_name" />
            </div>
            <div class="text-[10px]">
              {{ slide.activity_start_time }}
              <slot name="activity_start_time" />
            </div>
            <div class="text-[10px]">
              {{ slide.activity_address }}
              <slot name="activity_address" />
            </div>
          </div>
          <div class="absolute bottom-[2px] right-[6px] w-[40px] h-[18px] px-1 rounded-[15px] bg-[#D19191] flex justify-between items-center">
            <img :src="images.heart" class="w-[20px] h-[20px]" alt="收藏人數">
            {{ slide.collection_count }}
          </div>
        </figure>
      </Link>
    </Swiper>
  </div>
</template>

<style lang="scss" scoped>
#activity-swiper {
  @apply w-full h-full overflow-y-auto;
}
</style>
