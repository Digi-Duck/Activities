<!-- 後台學員管理頁面 -->

<script>
import Pagination from '@/Components/Public/Pagination.vue';

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
    };
  },
  created() {
  },
};
</script>

<template>
  <section id="backend-studentmanage" class="p-10 flex flex-col items-center">
    <h1 class="w-[80%] pb-1 border-b-4 title flex">{{ title }}</h1>
    <div class="w-[80%] mb-5 mt-5 flex flex-col justify-between items-center gap-10">
      <!-- 搜尋欄 -->
      <div class="w-full h-[57px] px-10 py-1 bg-[#ffc0cb4a] border flex justify-start items-center gap-5">
        <input type="search" name="" class="w-[482px] h-[39px] rounded-[5px] text-[24px]" id="" placeholder="請輸入學員名稱、電子信箱、加入時間">
        <select class="h-[39px] rounded-[5px] text-[24px] flex justify-center" placeholder="學員狀態">
          <option value="1">正常</option>
          <option value="0">凍結</option>
        </select>
        <button type="button" class="w-[90px] h-[38px] bg-[#a0bcc650] rounded-[5px] text-[24px]">搜尋</button>
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
        <div class="w-[100%] h-[55px] bg-[#ABC2CE] flex text-[20px]">
          <div class="w-[17.828%] ps-5 flex-none border font-semibold flex items-center">潘國偉</div>
          <div class="w-[31.939%] ps-5 flex-initial border font-semibold flex items-center">k5020420@gmail.com</div>
          <div class="w-[31.939%] ps-5 flex-initial border font-semibold flex items-center">2000-01-01</div>
          <div class="w-[9.175%] ps-5 flex-initial border font-semibold flex items-center">正常</div>
          <div class="ps-5 flex-1 border font-semibold flex justify-between items-center">操作
            <button type="button" class="me-3 mt-1 rounded-full border">^</button>
          </div>
        </div>
      </div>
      <div class="w-[313px] h-[56px] bg-white rounded-[30px] flex justify-center">
        <Pagination></Pagination>
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
