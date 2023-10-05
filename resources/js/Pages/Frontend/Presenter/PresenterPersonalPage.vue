<!-- 講師會員介面 -->

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
  },
};
</script>

<template>
  <section id="presenter-personal-page" class="flex flex-col items-center">
    <ActivitySwiper :slide-data="activityData?.data ?? []">
      <template #activity_title_name>
        <span>
          近期活動
        </span>
      </template>
    </ActivitySwiper>
    <ActivityDetailTable :table-data="activityData" :type-data="activityTypeData">
      <template #activity_title_type>
        <span>
          講者名稱
        </span>
      </template>
    </ActivityDetailTable>
    <!-- 已上完的活動資料尚未傳送 -->
    <ActivitySwiper :slide-data="activityData?.data ?? []">
      <template #activity_title_name>
        <span>
          已上完的活動
        </span>
      </template>
    </ActivitySwiper>
  </section>
</template>

<style lang="scss" scoped>
#presenter-personal-page {
  @apply w-full h-full overflow-y-auto;

  .title {
    @apply text-[6.25rem] text-center;
  }

  .btn-base {
    @apply p-1.5 border-2 rounded-md border-green-500 cursor-pointer;
  }
}
</style>
