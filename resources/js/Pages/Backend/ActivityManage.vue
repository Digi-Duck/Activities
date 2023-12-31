<!-- 後台活動管理頁面 -->

<script>
import Pagination from '@/Components/Public/Pagination.vue';
import { router } from '@inertiajs/vue3';
import Swal from 'sweetalert2';
import optionUp from '/images/icon/chevron-up-solid.svg';

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
      images: {
        optionUp,
      },
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
    changeStatus(id) {
      Swal.fire({
        title: '確認更改活動狀態?',
        showDenyButton: true,
        confirmButtonText: '確定',
        denyButtonText: '取消',
      }).then((result) => {
        if (result.isConfirmed) {
          router.visit(route('activityUpdate'), {
            method: 'put',
            data: { id: id },
          });
        }
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
          <option value="2">停權</option>
        </select>
        <button type="button" @click="searchData" class="w-[90px] h-[38px] bg-[#a0bcc650] rounded-[5px] text-[24px]">搜尋</button>
      </div>
      <!-- 表格內容 -->
      <div class="w-full h-[385px] flex flex-col">
        <!-- 表頭 -->
        <div class="w-full h-[55px] bg-[#5D8BA3] flex text-[20px]">
          <div class="flex-[0.1068] ps-5 border font-semibold flex items-center">活動講師</div>
          <div class="flex-[0.2346] ps-5 border font-semibold flex items-center">活動名稱</div>
          <div class="flex-[0.1864] ps-5 border font-semibold flex items-center">活動時間</div>
          <div class="flex-[0.1743] ps-5 border font-semibold flex items-center">活動分類</div>
          <div class="flex-[0.1823] ps-5 border font-semibold flex items-center">活動地點</div>
          <div class="flex-[0.0917] ps-5 border font-semibold flex items-center">活動狀態</div>
          <div class="ps-5 flex-[0.0911] border font-semibold flex items-center">操作</div>
        </div>
        <!-- 內容 -->
        <div v-for="(item, index) in activityData?.data ?? []" :key="index" :class="{ 'bg-red-200': item.activity_status === '停權' }" class="w-full h-[55px] bg-[#ABC2CE] flex text-[16px]">
          <div class="flex-[0.1068] ps-5 border font-semibold flex items-center">{{ item.activity_presenter }}</div>
          <div class="flex-[0.2346] ps-5 border font-semibold flex items-center">{{ item.activity_name }}</div>
          <div class="flex-[0.1864] ps-5 border font-semibold flex flex-col items-start justify-center">
            <p>
              開始:{{ item.activity_start_time }}
            </p>
            <p>
              結束:{{ item.activity_end_time }}
            </p>
          </div>
          <div class="flex-[0.1743] ps-5 border font-semibold flex items-center">{{ item.activity_type_name }}</div>
          <div class="flex-[0.1823] ps-5 border font-semibold flex items-center">{{ item.activity_address }}</div>
          <div class="flex-[0.0917] ps-5 border font-semibold flex items-center">{{ item.activity_status }}</div>
          <div class="ps-5 flex-[0.0911] border font-semibold flex justify-between items-center">更改狀態
            <button type="button" class="me-3 mt-1" @click="changeStatus(item.id)">
              <img :src="images.optionUp" class="w-[20px] h-[20px]" alt="操作按鈕">
            </button>
          </div>
        </div>
      </div>
      <div class="w-[313px] h-[56px] bg-white rounded-[30px] border shadow-xl flex justify-center">
        <Pagination :pagination-data="activityData"></Pagination>
      </div>
    </div>
  </section>
  <div class="fixed top-0 left-0 w-full h-[100vh] flex 2xl:hidden justify-center items-center bg-black text-white text-[72px]">
    為了您的用戶體驗，請使用電腦查看本網頁，謝謝！
  </div>
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
