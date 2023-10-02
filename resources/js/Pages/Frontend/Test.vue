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
      page1SlideData: [
        {
          imageUrl: 'https://picsum.photos/1980/901',
          title: 'Slide 1',
          description: 'Description for Slide 1',
        },
        {
          imageUrl: 'https://picsum.photos/1980/901',
          title: 'Slide 2',
          description: 'Description for Slide 2',
        },
        // 添加更多幻灯片数据
      ],
    };
  },
  created() {
  },
};
</script>

<template>
  <section id="swiper-test">
    <Swiper :slide-data="page1SlideData">
      <SwiperSlide>
        {{ index + 1 }}
        <img :src="page1SlideData.imageUrl" class="w-[700px] h-[700px]" alt="這是一張測視圖">
      </SwiperSlide>
    </Swiper>
  </section>
</template>

<style lang="scss" scoped>
#swiper-test {
  @apply w-full h-full overflow-y-auto;

  .title {
    @apply text-[6.25rem] text-center;
  }

  .btn-base {
    @apply p-1.5 border-2 rounded-md border-green-500 cursor-pointer;
  }
}
</style>
