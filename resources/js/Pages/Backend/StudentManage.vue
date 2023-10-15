<!-- 後台學員管理頁面 -->

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
      title: '學員管理',
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
    studentData() {
      return this.rtData.student ?? {};
    },
  },
  methods: {
    searchData() {
      router.get(route('studentManage'), { keyword: this.keyword, status: this.selectedStatus }, {
        preserveState: true,
        preserveScroll: true,
      });
    },
    changeStatus(id) {
      Swal.fire({
        title: '確認更改學員狀態?',
        showDenyButton: true,
        confirmButtonText: '確定',
        denyButtonText: '取消',
      }).then((result) => {
        if (result.isConfirmed) {
          router.visit(route('studentUpdate'), {
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
        <input v-model="keyword" type="search" class="w-[482px] h-[39px] rounded-[5px] text-[24px]" placeholder="請輸入學員名稱、電子信箱、加入時間" @search="searchData">
        <select v-model="selectedStatus" class="h-[39px] rounded-[5px] text-[24px] flex justify-center" placeholder="學員狀態">
          <option value="">所有學員</option>
          <option value="1">正常</option>
          <option value="0">停權</option>
        </select>
        <button type="button" @click="searchData" class="w-[90px] h-[38px] bg-[#a0bcc650] rounded-[5px] text-[24px]">搜尋</button>
      </div>
      <!-- 表格內容 -->
      <div class="w-[100%] h-[385px] flex flex-col">
        <!-- 表頭 -->
        <div class="w-[100%] h-[55px] bg-[#5D8BA3] flex text-[24px]">
          <div class="w-[17.828%] ps-5 flex-none border font-semibold flex items-center">學員名稱</div>
          <div class="w-[31.939%] ps-5 flex-initial border font-semibold flex items-center">電子信箱</div>
          <div class="w-[31.939%] ps-5 flex-initial border font-semibold flex items-center">加入時間</div>
          <div class="w-[9.175%] ps-5 flex-initial border font-semibold flex items-center">狀態</div>
          <div class="ps-5 flex-1 border font-semibold flex items-center">操作</div>
        </div>
        <!-- 內容 -->
        <div v-for="(item, index) in studentData?.data ?? []" :key="index" :class="{ 'bg-red-200': item.status === '停權' }" class="w-[100%] h-[55px] bg-[#ABC2CE] flex text-[20px]">
          <div class="w-[17.828%] ps-5 flex-none border font-semibold flex items-center">{{ item.name }}</div>
          <div class="w-[31.939%] ps-5 flex-initial border font-semibold flex items-center">{{ item.email }}</div>
          <div class="w-[31.939%] ps-5 flex-initial border font-semibold flex items-center">{{ item.created_at }}</div>
          <div class="w-[9.175%] ps-5 flex-initial border font-semibold flex items-center">{{ item.status }}</div>
          <div class="ps-5 flex-1 border font-semibold flex justify-between items-center">更改狀態
            <button type="button" class="me-3 mt-1" @click="changeStatus(item.id)">
              <img :src="images.optionUp" class="w-[20px] h-[20px]" alt="操作按鈕">
            </button>
          </div>
        </div>
      </div>

      <div class="w-[313px] h-[56px] bg-white rounded-[30px] border shadow-xl flex justify-center">
        <Pagination :pagination-data="studentData"></Pagination>
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
