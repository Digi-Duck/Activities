<!-- 講師已完成的活動頁面 -->

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
      rtData: this.response?.rt_data ?? {},
    };
  },
  computed: {
    // 獲取活動資料陣列
    activityData() {
      return this.rtData.activity ?? {};
    },
    // 獲取活動類別資料陣列
    activityTypeData() {
      return this.rtData.activityTypeData ?? [];
    },
    // 獲取學員報名資料陣列
    registerData() {
      return this.rtData.registerData ?? [];
    },
  },
  methods: {
    getActivityTypeLabel(activityType) {
      const activityTypeLabels = {
        1: '文化與藝術',
        2: '學術與培訓',
        3: '社交與社團',
        4: '旅遊與戶外',
        5: '健康與福祉',
        6: '商業與職業發展',
        7: '娛樂與文化慶典',
        8: '科技與創新',
      };
      return activityTypeLabels[activityType] || '其他';
    },
  },
};
</script>

<template>
  <section id="presenter-finished-activity" class="flex flex-col gap-5">

    <ActivityDetailSwiper :slide-data="[activityData]">
      <template #activity_type>
        <span>{{ getActivityTypeLabel(activityData.activity_type) }}</span>
      </template>
      <template #activity_name>
        <span>
          {{ activityData.activity_name }}
        </span>
      </template>
      <template #activity_info>
        <span>
          {{ activityData.activity_info }}
        </span>
      </template>
      <template #activity_lowest_number_of_people>
        <span>
          {{ activityData.activity_lowest_number_of_people }}
        </span>
      </template>
      <template #activity_highest_number_of_people>
        <span>
          {{ activityData.activity_highest_number_of_people }}
        </span>
      </template>
      <template #activity_start_registration_time>
        <span>
          {{ activityData.activity_start_registration_time }}
        </span>
      </template>
      <template #activity_end_registration_time>
        <span>
          {{ activityData.activity_end_registration_time }}
        </span>
      </template>
      <template #activity_presenter>
        <span>
          {{ activityData.activity_presenter }}
        </span>
      </template>
      <template #activity_start_time>
        <span>
          {{ activityData.activity_start_time }}
        </span>
      </template>
      <template #activity_end_time>
        <span>
          {{ activityData.activity_end_time }}
        </span>
      </template>
      <template #activity_address>
        <span>
          {{ activityData.activity_address }}
        </span>
      </template>
      <template #activity_instruction>
        <span>
          {{ activityData.activity_instruction }}
        </span>
      </template>
      <template #registerPeople>
        <span class="ps-[10px] text-[72px]">
          {{ rtData.registerPeople }}
        </span>
      </template>
    </ActivityDetailSwiper>
    <div class="mt-[200px] lg:mt-0 w-full p-[100px] bg-[#d7a5a565]">
      <div v-html="activityData.activity_information"></div>
    </div>
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
