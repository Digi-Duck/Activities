<!-- 各別活動輪播Swiper -->
<script>
import heart from '/images/icon/icon-heart.svg';
import filledHeart from '/images/icon/icon-filled-heart.svg';
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
};
</script>

<template>
  <div id="activity-swiper" class="relative p-5 flex flex-col items-center">
    <div class="pb-5 text-[48px] self-start ps-[400px]">
      <slot name="activity_title_name">
        近期活動
      </slot>
    </div>
    <div class="absolute top-[50%] z-10 w-[97.5%] flex justify-between">
      <button ref="btnPrev" id="prevBtn" class="h-[50px] w-[50px] rounded-[50px] bg-white" type="button">
        <img :src="images.arrowLeft" alt="活動照片海報向左移動按鈕">
      </button>
      <button ref="btnNext" id="nextBtn" class="h-[50px] w-[50px] rounded-[50px] bg-white" type="button">
        <img :src="images.arrowRight" alt="活動照片海報向右移動按鈕">
      </button>
    </div>
    <Swiper :slide-data="[1, 2, 3, 4, 5, 6, 7, 8]" slides-per-view="5" :btn-prev="prevButton" :btn-next="nextButton">
      <SwiperSlide class="relative m-auto w-[296px] h-[358px] p-3 bg-white border flex flex-col items-center">
        <img src="https://picsum.photos/1980/901" class="w-[275px] h-[275px] object-cover" alt="產業類別圖片">
        <div class="w-full ps-3 flex flex-col gap-1">
          <div class="text-[16px] font-semibold">
            <slot name="activity_name">活動名稱</slot>
          </div>
          <div class="text-[10px]">
            <slot name="activity_start_time">活動時間</slot>
          </div>
          <div class="text-[10px]">
            <slot name="activity_address">活動地點</slot>
          </div>
        </div>
        <div class="absolute bottom-[2px] right-[6px] w-[40px] h-[18px] px-1 rounded-[15px] bg-[#D19191] flex justify-between items-center">
          <img :src="images.heart" class="w-[20px] h-[20px]" alt="收藏人數">
          1
        </div>
      </SwiperSlide>
    </Swiper>
  </div>
</template>

<style lang="scss" scoped>
#activity-swiper {
  @apply w-full h-full overflow-y-auto;

  .title {
    @apply text-[6.25rem] text-center;
  }

  .btn-base {
    @apply p-1.5 border-2 rounded-md border-green-500 cursor-pointer;
  }
}
</style>
