<!-- 學員活動報名頁面 -->

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
  <section id="presenter-finished-activity" class="flex flex-col justify-between items-center gap-5">
    <CountDown class="absolute mt-[5%] left-[75%]"></CountDown>
    <ActivityDetailSwiper>
      <template #activity_type>
        <span v-if="response.rt_data.activity_type === 1">
          文化與藝術
        </span>
        <span v-else-if="response.rt_data.activity_type === 2">
          學術與培訓
        </span>
        <span v-else-if="response.rt_data.activity_type === 3">
          社交與社團
        </span>
        <span v-else-if="response.rt_data.activity_type === 4">
          旅遊與戶外
        </span>
        <span v-else-if="response.rt_data.activity_type === 5">
          健康與福祉
        </span>
        <span v-else-if="response.rt_data.activity_type === 6">
          商業與職業發展
        </span>
        <span v-else-if="response.rt_data.activity_type === 7">
          娛樂與文化慶典
        </span>
        <span v-else-if="response.rt_data.activity_type === 8">
          科技與創新
        </span>
        <span v-else>
          其他
        </span>
      </template>
      <template #activity_name>
        <span>
          {{ response.rt_data.activity_name }}
        </span>
      </template>
      <template #activity_info>
        <span>
          {{ response.rt_data.activity_info }}
        </span>
      </template>
      <template #activity_lowest_number_of_people>
        <span>
          {{ response.rt_data.activity_lowest_number_of_people }}
        </span>
      </template>
      <template #activity_highest_number_of_people>
        <span>
          {{ response.rt_data.activity_highest_number_of_people }}
        </span>
      </template>
      <template #activity_start_registration_time>
        <span>
          {{ response.rt_data.activity_start_registration_time }}
        </span>
      </template>
      <template #activity_end_registration_time>
        <span>
          {{ response.rt_data.activity_end_registration_time }}
        </span>
      </template>
      <template #activity_presenter>
        <span>
          {{ response.rt_data.activity_presenter }}
        </span>
      </template>
      <template #activity_start_time>
        <span>
          {{ response.rt_data.activity_start_time }}
        </span>
      </template>
      <template #activity_end_time>
        <span>
          {{ response.rt_data.activity_end_time }}
        </span>
      </template>
      <template #activity_address>
        <span>
          {{ response.rt_data.activity_address }}
        </span>
      </template>
      <template #activity_instruction>
        <span>
          {{ response.rt_data.activity_instruction }}
        </span>
      </template>
    </ActivityDetailSwiper>
    <!-- 這裡是活動詳情 -->
    <div class="w-full h-[811px] p-[100px] bg-[yellow]">
      <div v-html="response.rt_data.activity_information"></div>
    </div>
    <!-- 學員活動資訊填寫區 -->
    <ActivityEnroll></ActivityEnroll>
  </section>
</template>

<style lang="scss" scoped>
#presenter-finished-activity {
  @apply w-full h-full overflow-y-auto;

  .title {
    @apply text-[6.25rem] text-center;
  }

  .btn-base {
    @apply p-1.5 border-2 rounded-md border-green-500 cursor-pointer;
  }
}
</style>
