<script>
import { Swiper, SwiperSlide } from 'swiper/vue';
import 'swiper/css';

export default {
  components: {
    Swiper,
    SwiperSlide,
  },
  setup() {
    const onSwiper = (swiper) => {
      console.log(swiper);
    };
    const onSlideChange = () => {
      console.log('slide change');
    };
    return {
      onSwiper,
      onSlideChange,
    };
  },
};
</script>

<template>
  <section id="create-activity">
    <Swiper :slides-per-view="3" :space-between="50" @swiper="onSwiper" @slide-change="onSlideChange">
      <SwiperSlide>
        <img src="https://web.nanya.edu.tw/mechanic/e-book/97B-001/HomePage/EnGrph/%E8%A6%96%E5%9C%96%E5%90%8D%E7%A8%B1.jpg" alt="">
      </SwiperSlide>
      <SwiperSlide>Slide 2</SwiperSlide>
      <SwiperSlide>Slide 3</SwiperSlide>
    </Swiper>
    <div class="flex justify-center gap-5 mb-5">
      <Link :href="route('register')" class="btn-base">註冊</Link>
      <Link :href="route('dashboard')" class="btn-base">登入</Link>
    </div>
  </section>
</template>

<style lang="scss" scoped>
#create-activity {
  @apply w-full h-full overflow-y-auto;

  .title {
    @apply text-[6.25rem] text-center;
  }

  .btn-base {
    @apply p-1.5 border-2 rounded-md border-green-500 cursor-pointer;
  }
}
</style>
