<!-- 學員會員介面 -->

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
    // 獲取已報名活動資料陣列
    registerActivityData() {
      return this.rtData.registerActivity ?? {};
    },

    // 獲取已收藏活動資料陣列
    favoriteActivityData() {
      return this.rtData.favoriteActivity ?? {};
    },

    // 獲取全部活動資料陣列
    allActivityData() {
      return this.rtData.allActivity ?? {};
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
    <ActivitySwiper :slide-data="registerActivityData?.data ?? []" href="studentActivityEdit">
      <template #activity_title_name>
        <span>
          已報名活動
        </span>
      </template>
    </ActivitySwiper>
    <!-- {{ response.rt_data.favoriteActivity }} -->
    <ActivitySwiper :slide-data="favoriteActivityData?.data ?? []" href="studentActivityDetails">
      <template #activity_title_name>
        <span>
          已收藏活動
        </span>
      </template>
    </ActivitySwiper>
    <ActivityDetailTable :table-data="allActivityData" :type-data="activityTypeData">
      <template #activity_title_type>
        <span>
          活動類型
        </span>
      </template>
      <template #activity_name>
        <span>
          我自己寫活動名稱
        </span>
      </template>
      <template #activity_type>
        <span>
        </span>
      </template>
      <template #activity_end_registration_time>
        <span>
          我自己寫活動時間
        </span>
      </template>
      <template #activity_lowest_number_of_people>
        <span>
          50
        </span>
      </template>
      <template #activity_highest_number_of_people>
        <span>
          150
        </span>
      </template>
    </ActivityDetailTable>
    <ActivitySwiper>
      <template #activity_title_name>
        <span>
          已上過的活動
        </span>
      </template>
      <template #activity_name>
        <span>
        </span>
      </template>
      <template #activity_start_time>
        <span>
        </span>
      </template>
      <template #activity_address>
        <span>
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
