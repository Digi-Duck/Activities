<!-- 後台活動管理頁面 -->

<script>
import Pagination from '@/Components/Public/Pagination.vue';
import { router } from '@inertiajs/vue3';

export default {
  components: { Pagination },
  props: {
    response: {
      type: Object,
      required: false,
      default: () => ({}),
    },
  },
  data() {
    return {
      title: '活動管理',
      keyword: this.response?.rt_data?.keyword ?? '',
      selectedStatus: this.response?.rt_data?.status ?? '',
    };
  },
  computed: {
    rtData() {
      return this.response?.rt_data ?? {};
    },
    activityData() {
      return this.rtData.activity ?? {};
    },
  },
  methods: {
    searchData() {
      router.get(route('activityManage'), { keyword: this.keyword, status: this.selectedStatus }, {
        preserveState: true,
        preserveScroll: true,
      });
    },
  },
};
</script>

<template>
  <section id="backend-studentmanage" class="p-10 flex flex-col items-center">
    <h1 class="w-[80%] pb-1 border-b-4 title flex">{{ title }}</h1>
    <div class="w-[80%] mb-5 mt-5 flex flex-col justify-between items-center gap-10">
      <!-- 搜尋欄 -->
      <div class="w-full h-[57px] px-10 py-1 bg-[#ffc0cb4a] border flex justify-start items-center gap-5">
        <input v-model="keyword" type="search" class="w-[700px] h-[39px] rounded-[5px] text-[24px]" placeholder="請輸入活動講師、活動名稱、活動時間、活動分類、活動地點" @search="searchData">
        <select v-model="selectedStatus" class="h-[39px] rounded-[5px] text-[24px] flex justify-center" placeholder="活動狀態">
          <option value="">所有活動</option>
          <option value="1">正常</option>
          <option value="0">停權</option>
        </select>
        <button type="button" @click="searchData" class="w-[90px] h-[38px] bg-[#a0bcc650] rounded-[5px] text-[24px]">搜尋</button>
      </div>
      <!-- 表格內容 -->
      <div class="w-[100%] h-[385px] flex flex-col">
        <!-- 表頭 -->
        <div class="w-[100%] h-[55px] bg-[#5D8BA3] flex text-[24px]">
          <div class="w-[10.685%] ps-5 flex-none border font-semibold flex items-center">活動講師</div>
          <div class="w-[23.461%] ps-5 flex-initial border font-semibold flex items-center">活動名稱</div>
          <div class="w-[18.641%] ps-5 flex-initial border font-semibold flex items-center">活動時間</div>
          <div class="w-[10.743%] ps-5 flex-initial border font-semibold flex items-center">活動分類</div>
          <div class="w-[18.234%] ps-5 flex-initial border font-semibold flex items-center">活動地點</div>
          <div class="w-[9.175%] ps-5 flex-initial border font-semibold flex items-center">活動狀態</div>
          <div class="ps-5 flex-1 border font-semibold flex items-center">操作</div>
        </div>
        <!-- 內容 -->
        <div v-for="(item, index) in activityData?.data ?? []" :key="index" class="w-[100%] h-[55px] bg-[#ABC2CE] flex text-[24px]">
          <div class="w-[10.685%] ps-5 flex-none border font-semibold flex items-center">{{ item.activity_presenter }}</div>
          <div class="w-[23.461%] ps-5 flex-initial border font-semibold flex items-center">{{ item.activity_name }}</div>
          <div class="w-[18.641%] ps-5 flex-initial border font-semibold flex items-center">{{ item.activity_start_time }}~{{ item.activity_end_time }}</div>
          <div class="w-[10.743%] ps-5 flex-initial border font-semibold flex items-center">{{ item.activity_type }}</div>
          <div class="w-[18.234%] ps-5 flex-initial border font-semibold flex items-center">{{ item.activity_address }}</div>
          <div class="w-[9.175%] ps-5 flex-initial border font-semibold flex items-center">{{ item.activity_status }}</div>
          <div class="ps-5 flex-1 border font-semibold flex justify-between items-center">操作
            <button type="button" class="me-3 mt-1 rounded-full border">^</button>
          </div>
        </div>
      </div>
      <div class="w-[313px] h-[56px] bg-white rounded-[30px] flex justify-center">
        <Pagination :pagination-data="activityData"></Pagination>
      </div>
    </div>
    <!-- <Link :href="route('register')" class="btn-base">註冊</Link>
    <Link :href="route('dashboard')" class="btn-base">登入</Link> -->
  </section>
</template>

<style lang="scss" scoped>
#backend-studentmanage {
  @apply w-full h-full overflow-y-auto;

  .title {
    @apply text-[56px] text-center font-bold;
  }

  .btn-base {
    @apply p-1.5 border-2 rounded-md border-green-500 cursor-pointer;
  }
}
</style>
