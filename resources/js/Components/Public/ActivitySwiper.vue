<!-- 各別活動輪播Swiper -->
<script>
import heart from '/images/icon/icon-heart.svg';
import filled_heart from '/images/icon/icon-filled-heart.svg';

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
      images: {
        heart,
        filled_heart,
      },
    };
  },
  created() {
  },
};
</script>

<template>
  <div class="text-[48px] self-start ps-[400px]">
    近期活動
  </div>
  <Swiper :slide-data="[1, 2, 3, 4, 5]" slides-per-view="5" :btn-prev="$refs.btnPrev" :btn-next="$refs.btnNext">
    <SwiperSlide class="relative m-auto w-[296px] h-[358px] p-3 bg-white border flex flex-col items-center">
      <img src="https://picsum.photos/1980/901" class="w-[275px] h-[275px] object-cover" alt="產業類別圖片">
      <div class="w-full ps-3 flex flex-col gap-1">
        <div class="text-[16px] font-semibold">活動名稱</div>
        <div class="text-[10px]">活動時間</div>
        <div class="text-[10px]">活動地點</div>
      </div>
      <div class="absolute bottom-[2px] right-[6px] w-[40px] h-[18px] px-1 rounded-[15px] bg-[#D19191] flex justify-between items-center">
        <img :src="images.heart" class="w-[20px] h-[20px]" alt="收藏人數">
        1
      </div>
    </SwiperSlide>
  </Swiper>
</template>

<style lang="scss" scoped>
#card-test {
  @apply w-full h-full overflow-y-auto;

  .title {
    @apply text-[6.25rem] text-center;
  }

  .btn-base {
    @apply p-1.5 border-2 rounded-md border-green-500 cursor-pointer;
  }
}
</style>
