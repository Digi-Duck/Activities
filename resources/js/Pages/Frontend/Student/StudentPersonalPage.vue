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
    rtData() {
      return this.response?.rt_data ?? {};
    },
    registerActivityData() {
      return this.rtData.registerActivity ?? {};
    },
    favoriteActivityData() {
      return this.rtData.favoriteActivity ?? {};
    },
    allActivityData() {
      return this.rtData.allActivity ?? {};
    },
    finishedActivityData() {
      return this.rtData.finishedActivity ?? {};
    },
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
  <section id="presenter-personal-page" class="flex flex-col gap-1 items-center">
    <ActivitySwiper :slide-data="registerActivityData?.data ?? []" href="studentActivityEdit">
      <template #activity_title_name>
        <span>
          已報名活動
        </span>
      </template>
    </ActivitySwiper>
    <ActivitySwiper :slide-data="favoriteActivityData?.data ?? []" href="studentActivityDetails">
      <template #activity_title_name>
        <span>
          已收藏活動
        </span>
      </template>
    </ActivitySwiper>

    <div class="m-auto w-full max-w-[1400px] h-[505px] p-10 flex flex-col items-center">
      <div class="mb-[5px] w-full h-[48px] pt-[10px] pe-[10px] border-t-[#000] border-t-[1px] flex justify-end">
        <!-- 文字搜尋框 -->
        <div class="w-[40%] lg:w-[15%] h-full bg-[#80808012] flex justify-center items-center gap-3">
          <input v-model="keyword" type="search" class="w-[80%] h-[80%]" @search="searchData" placeholder="請輸入搜尋資訊">
          <button type="button" @click="searchData">
            <img :src="images.magnifer" class="w-[16px]" alt="搜尋">
          </button>
        </div>
      </div>
      <!-- 搜尋的表頭 -->
      <div class="w-full h-[64px] flex">
        <b class="flex-1 md:flex-none md:w-[40%] xl:w-[50%] border bg-[#5D8BA3] flex justify-center items-center text-[24px]">
          <slot name="activity_title_name">活動名稱</slot>
        </b>
        <b class="flex-1 md:flex-initial w-[15%] border bg-[#82ACC2] flex justify-center items-center text-[24px]">
          <slot name="activity_title_type">主講者</slot>
        </b>
        <b class="flex-1 md:flex-initial w-[15%] border bg-[#A9BCC6] flex justify-center items-center text-[24px]">
          <slot name="activity_title_time">報名截止時間</slot>
        </b>
        <b class="flex-1 md:flex-initial w-[30%] xl:w-[20%] border bg-[#A9BCC6] flex justify-center items-center text-[24px]">
          <slot name="activity_title_number">人數狀況</slot>
        </b>
      </div>
      <!-- 詳細搜尋內容 -->
      <div v-for="(item, index) in allActivityData?.data ?? []" :key="index" class="w-full h-[53px] flex">
        <Link :href="route('studentActivityDetails', { id: item.id })" class="flex-1 md:flex-none md:w-[40%] xl:w-[50%] ps-3 border bg-[#5d8aa37d] flex justify-start items-center text-[16px] font-bold underline decoration-1">
          {{ item.activity_name }}
        </Link>
        <div class="flex-1 md:flex-initial w-[15%] border bg-[#82acc27d] flex justify-center items-center text-[16px] font-semibold">
          <slot name="activity_info_type">
            {{ item.activity_presenter }}
          </slot>
        </div>
        <b class="flex-1 md:flex-initial w-[15%] ps-3 border bg-[#a9bcc67e] flex justify-start items-center text-[16px]">
          {{ item.activity_end_registration_time }}
        </b>
        <div class="flex-1 md:flex-initial w-[30%] xl:w-[20%] ps-3 border bg-[#a9bcc67e] flex justify-between items-center text-[16px]">
          <slot name="student_additional_remark">
            <div class="hidden md:block">
              <p>
                門檻:{{ item.activity_lowest_number_of_people.toLocaleString() }}
              </p>
              <p>
                名額:{{ item.activity_highest_number_of_people.toLocaleString() }}
              </p>
            </div>
            <div class="pe-3 flex items-center justify-center">
              目前人數：{{ item.registration_count.toLocaleString() }}
            </div>
          </slot>
        </div>
      </div>
      <div class="mt-[15px] w-[313px] h-[56px] bg-white rounded-[30px] border shadow-xl flex justify-center">
        <Pagination :pagination-data="allActivityData?.data" class="pt-3" />
      </div>
    </div>
    <ActivitySwiper :slide-data="finishedActivityData?.data ?? []" href="finishedActivity">
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
