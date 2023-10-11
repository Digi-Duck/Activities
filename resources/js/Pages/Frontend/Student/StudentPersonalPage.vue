<!-- 學員會員介面 -->

<script>
import magnifer from '/images/icon/magnifer.svg';
import { router } from '@inertiajs/vue3';
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
      keyword: this.response?.rt_data?.keyword ?? '',
      selectedType: this.response?.rt_data?.type ?? '',
      images: {
        magnifer,
      },
    };
  },
  computed: {
    // 後端回傳資料
    rtData() {
      return this.response?.rt_data ?? {};
    },
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
    // 獲取已完成活動資料陣列
    finishedActivityData() {
      return this.rtData.finishedActivity ?? {};
    },

    // 獲取活動類別資料陣列
    activityTypeData() {
      return this.rtData.activityTypeData ?? [];
    },
  },
  methods: {
    searchData() {
      router.get(route('studentPersonalPage'), { keyword: this.keyword, type: this.selectedType }, {
        preserveState: true,
        preserveScroll: true,
      });
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

    <!-- <ActivityDetailTable :table-data="allActivityData" :type-data="activityTypeData">
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
    </ActivityDetailTable> -->

    <div class="m-auto w-full max-w-[1400px] h-[505px] p-10 flex flex-col items-center">
      <!-- 搜尋欄位 -->
      <div class="mb-[5px] w-full h-[48px] pt-[10px] border-t-[#000] border-t-[1px] flex justify-end">
        <!-- 文字搜尋框 -->
        <div class="w-[15%] h-full bg-[#80808012] flex justify-center items-center gap-1">
          <input v-model="keyword" type="search" class="w-[80%] h-[80%]" @search="searchData" placeholder="請輸入搜尋資訊">
          <button type="button" @click="searchData">
            <img :src="images.magnifer" class="w-[16px]" alt="搜尋">
          </button>
        </div>
      </div>
      <!-- 搜尋的表頭 -->
      <div class="w-full h-[64px] flex">
        <div class="flex-none w-[50%] border bg-[#5D8BA3] flex justify-center items-center text-[24px]">
          <slot name="activity_title_name">活動名稱</slot>
        </div>
        <div class="flex-initial w-[10%] border bg-[#82ACC2] flex justify-center items-center text-[24px]">
          <slot name="activity_title_type">主講者</slot>
        </div>
        <div class="flex-initial w-[20%] border bg-[#A9BCC6] flex justify-center items-center text-[24px]">
          <slot name="activity_title_time">報名截止時間</slot>
        </div>
        <div class="flex-initial w-[20%] border bg-[#A9BCC6] flex justify-center items-center text-[24px]">
          <slot name="activity_title_number">人數狀況</slot>
        </div>
      </div>
      <!-- 詳細搜尋內容 -->
      <div v-for="(item, index) in allActivityData?.data ?? []" :key="index" class="w-full h-[53px] flex">
        <Link :href="route('studentActivityDetails', { id: item.id })" class="flex-none w-[50%] ps-3 border bg-[#a9bcc67e] flex justify-start items-center text-[16px]">
          {{ item.activity_name }}
        </Link>
        <div class="flex-initial w-[10%] border bg-[#82acc27d] flex justify-center items-center text-[16px] font-semibold">
          <slot name="activity_info_type">
            {{ item.activity_presenter }}
          </slot>
        </div>
        <div class="flex-initial w-[20%] ps-3 border bg-[#a9bcc67e] flex justify-start items-center text-[16px]">
          {{ item.activity_end_registration_time }}
        </div>
        <div class="flex-initial w-[20%] ps-3 border bg-[#a9bcc67e] flex justify-between items-center text-[16px]">
          <slot name="student_additional_remark">
            <span>
              門檻:{{ item.activity_lowest_number_of_people }}
              上限:{{ item.activity_highest_number_of_people }}
              <div class="pe-3 flex items-center justify-center">
                目前人數：{{ item.registration_count }}
              </div>
            </span>
          </slot>
        </div>
      </div>
      <Pagination :pagination-data="allActivityData?.data" class="pt-3" />
    </div>
    <ActivitySwiper :slide-data="finishedActivityData?.data ?? []">
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
