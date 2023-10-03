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
  {{ response.rt_data }}
  <!-- <div class="flex" v-for="(item, index) in response.rt_data" :key="index">
    <Link class="w-[150px] h-[150px] bg-[pink] rounded-full" :href="route('studentActivityDetails', { id: item.id })">
      {{ index + 1 }}
      {{ response.rt_data[index].activity_presenter }}
    </Link>
  </div> -->
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
      <Swiper v-slot="{ slide }" :slide-data="response?.rt_data ?? ''" :slides-per-view=4 :space-between=30 class="absolute -left-[50px] top-[400px] rotate-[10deg]">
        <div>
          <!-- {{ slide.activityPhotos[0].activity_img_path }} -->
          <img :src="slide.activityPhotos[0].activity_img_path" class="w-[512px] h-[384px] object-cover" alt="產業類別圖片">
        </div>
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
          {{ response.rt_data[0].activity_name }}
        </div>
        <div class="text-[55px]">
          {{ response.rt_data[0].activity_presenter }}
        </div>
        <div class="text-[30px]">
          {{ response.rt_data[0].activity_start_time }}
        </div>
        <!-- {{ response.rt_data[0].activityPhotos[0].activity_img_path }} -->
      </div>
      <div class="relative mb-[50px] w-full h-[388px] flex">
        <div class="absolute w-[770px] h-full rounded-[64px] bg-green-600"></div>
        <img :src="response.rt_data[0].activityPhotos[0].activity_img_path" class="absolute ms-[25%] w-[770px] h-full z-10 rounded-[64px] bg-red-600" alt="">
        <div class="absolute end-0 w-[770px] h-full rounded-[64px] bg-blue-600"></div>
      </div>
    </div>
    <!-- 近期活動Swiper -->
    <!-- {{ response.rt_data[0].activityPhotos[0].activity_img_path }}
    <img :src="response.rt_data[0].activityPhotos[0].activity_img_path" alt="">
    {{ response.rt_data }} -->
    <ActivitySwiper :slide-data="response.rt_data">
      <!-- <template #activity_name>
        <span>
          {{ response.rt_data[2].activity_name }}
        </span>
      </template>
      <template #activity_start_time>
        <span>
          {{ response.rt_data[2].activity_start_time }}
        </span>
      </template>
      <template #activity_address>
        <span>
          {{ response.rt_data[2].activity_address }}
        </span>
      </template> -->
    </ActivitySwiper>
    <!-- 近期活動查詢表 -->
    <!-- {{ response.rt_data }} -->
    <ActivityDetailTable :table-data="response.rt_data">
      <template #activity_title_type>
        <span>
          主講人
        </span>
      </template>
      <template #activity_name>
        <span>
          {{ response.rt_data[0].activity_name }}
        </span>
      </template>
      <template #activity_type>
        <span>
          {{ response.rt_data[0].activity_presenter }}
        </span>
      </template>
      <template #activity_end_registration_time>
        <span>
          {{ response.rt_data[0].activity_end_registration_time }}
        </span>
      </template>
      <template #activity_lowest_number_of_people>
        <span>
          {{ response.rt_data[0].activity_lowest_number_of_people }}
        </span>
      </template>
      <template #activity_highest_number_of_people>
        <span>
          {{ response.rt_data[0].activity_highest_number_of_people }}
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
