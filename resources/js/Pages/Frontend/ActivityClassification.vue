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
  <section id="activity-classification" class="flex flex-col px-[182px]">
    <div class="w-full h-[164px] bg-black flex flex-col">
      <div class="bg-white text-5xl text-black">當前類型</div>
      <div class="w-full">
        <button type="button" class="btn">熱門</button>
        <button type="button" class="btn">美術</button>
        <button type="button" class="btn">科技</button>
        <div>Search</div>
      </div>
    </div>
    <div class="container flex flex-col items-center">
      <div class="w-[80%] h-[345px] bg-pink-500 flex flex-row">
        <img src="" alt="" class="w-[200%] bg-slate-500">
        <div class="w-full h-[345px] bg-yellow-500 p-16 flex flex-col justify-between border-b-4">
          <div class="w-full text-white text-[24px]">活動名稱</div>
          <div class="w-full text-black text-[14px]">活動截止時間</div>
          <div class="w-full text-white text-[14px]">活動info</div>
          <button type="button" class="text-black bg-[#a9bcc64f]">活動詳情</button>
        </div>
      </div>
    </div>
  </section>
</template>

<style lang="scss" scoped>
#activity-classification {
  @apply w-full h-full overflow-y-auto;

  .title {
    @apply text-[6.25rem] text-center;
  }

  .btn-base {
    @apply p-1.5 border-2 rounded-md border-green-500 cursor-pointer;
  }
}
</style>
