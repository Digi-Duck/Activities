<!-- 前台首頁頁面 -->
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
  {{ response }}
  <section class="flex justify-center items-center flex-col gap-5">
    <!-- 熱門活動Swiper -->
    <div class="relative w-full h-[602px] bg-[#031926] overflow-hidden">
      <div class="absolute left-[1223px] top-[88px] text-[64px] text-white">
        活動名稱
      </div>
      <div class="absolute top-[173px] w-full h-[59px] bg-[#ffffff57] text-[48px] text-white">
        <div class="absolute left-[1223px] z-10">
          活動Slogan
        </div>
      </div>
      <Swiper :slide-data="[1, 2, 3, 4, 5, 6]" slides-per-view="4" space-between="30" class="absolute -left-[50px] top-[400px] rotate-[10deg]" :btn-prev="$refs.btnPrev" :btn-next="$refs.btnNext">
        <SwiperSlide>
          <img src="https://picsum.photos/1980/901" class="w-[512px] h-[384px] object-cover" alt="產業類別圖片">
        </SwiperSlide>
      </Swiper>
    </div>
    <!-- 活動行事曆 -->
    <div class="w-full h-[340px] bg-white"></div>
    <!-- 最夯活動Banner -->
    <div class="w-[1440px] h-[765px] pt-[38px] bg-[#F3F3F1] flex flex-col justify-between items-center">
      <!-- 活動快速資訊 -->
      <div class="text-[17px] flex gap-1">
        <div class="text-[17px]">活動類型</div>
        <img src="" alt="活動收藏熱門進度條">
        <div class="text-[17px]">課程熱度</div>
      </div>
      <div class="flex flex-col items-center">
        <div class="text-[55px]">
          活動名稱
        </div>
        <div class="text-[55px]">
          主講者
        </div>
        <div class="text-[30px]">
          活動開始時間
        </div>
      </div>
      <div class="relative mb-[50px] w-full h-[388px] flex">
        <div class="absolute w-[770px] h-full rounded-[64px] bg-green-600"></div>
        <div class="absolute ms-[25%] w-[770px] h-full z-10 rounded-[64px] bg-red-600"></div>
        <div class="absolute end-0 w-[770px] h-full rounded-[64px] bg-blue-600"></div>
      </div>
    </div>
    <!-- 近期活動Swiper -->
    <ActivitySwiper></ActivitySwiper>
    <!-- 近期活動查詢表 -->
    <ActivityDetailTable></ActivityDetailTable>
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
