<!-- 後台儀表板頁面 -->

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
      title: '本周摘要',
    };
  },
  created() {
  },
};
</script>

<template>
  <section id="backend-dashboard" class="p-10 flex flex-col items-center">
    <h1 class="w-[80%] pb-1 border-b-4 title flex">{{ title }}</h1>
    <div class="w-[80%] mb-5 mt-5 flex flex-col justify-between items-center gap-10">
      <!-- 資訊小卡區 -->
      <div class="w-full flex flex-row justify-between gap-5 mb-5">
        <!-- 資訊預覽小卡 -->
        <div class="w-full h-[159px] border rounded-[10px] bg-white flex flex-col">
          <div class="relative h-full p-5 rounded-t-[10px] bg-white flex justify-between">
            <div>
              <div class="border-b-2 text-[36px]">123,456</div>
              <div class="text-[24px]">網站流量</div>
            </div>
            <!-- 資料icon -->
            <img src="" class="absolute right-[50px] top-[25px] w-[48.15px] h-[56.65px] bg-red-600" alt="">
          </div>
          <div class="h-[112px] p-5 rounded-b-[10px] bg-[#F08B8B] text-[16px] flex justify-between">上升10%
            <img src="" class="w-[33px] h-[33px]" alt="">
          </div>
        </div>
        <div class="w-full h-[159px] border rounded-[10px] bg-white flex flex-col">
          <div class="relative h-full p-5 rounded-t-[10px] bg-white flex justify-between">
            <div>
              <div class="border-b-2 text-[36px]">123,456</div>
              <div class="text-[24px]">網站流量</div>
            </div>
            <!-- 資料icon -->
            <img src="" class="absolute right-[50px] top-[25px] w-[48.15px] h-[56.65px] bg-red-600" alt="">
          </div>
          <div class="h-[112px] p-5 rounded-b-[10px] bg-[#F08B8B] text-[16px] flex justify-between">上升10%
            <img src="" class="w-[33px] h-[33px]" alt="">
          </div>
        </div>
        <div class="w-full h-[159px] border rounded-[10px] bg-white flex flex-col">
          <div class="relative h-full p-5 rounded-t-[10px] bg-white flex justify-between">
            <div>
              <div class="border-b-2 text-[36px]">123,456</div>
              <div class="text-[24px]">網站流量</div>
            </div>
            <!-- 資料icon -->
            <img src="" class="absolute right-[50px] top-[25px] w-[48.15px] h-[56.65px] bg-red-600" alt="">
          </div>
          <div class="h-[112px] p-5 rounded-b-[10px] bg-[#F08B8B] text-[16px] flex justify-between">上升10%
            <img src="" class="w-[33px] h-[33px]" alt="">
          </div>
        </div>
        <div class="w-full h-[159px] border rounded-[10px] bg-white flex flex-col">
          <div class="relative h-full p-5 rounded-t-[10px] bg-white flex justify-between">
            <div>
              <div class="border-b-2 text-[36px]">123,456</div>
              <div class="text-[24px]">網站流量</div>
            </div>
            <!-- 資料icon -->
            <img src="" class="absolute right-[50px] top-[25px] w-[48.15px] h-[56.65px] bg-red-600" alt="">
          </div>
          <div class="h-[112px] p-5 rounded-b-[10px] bg-[#F08B8B] text-[16px] flex justify-between">上升10%
            <img src="" class="w-[33px] h-[33px]" alt="">
          </div>
        </div>
      </div>
      <!-- 詳細圖表及最新消息區 -->
      <div class="w-full h-[728.5px] flex flex-row justify-between gap-5 mb-5">
        <!-- 詳細圖表 -->
        <div class="w-[988px] rounded-[10px] bg-slate-400"></div>
        <!-- 最新消息 -->
        <div class="w-[559px] rounded-[10px] border-2 border-[#000000] text-white flex flex-col gap-3">
          <!-- 最新消息表頭 -->
          <div class="w-full h-[106px] ps-5 rounded-t-[10px] bg-[#397AC4] text-[48px] flex items-center">最新消息</div>
          <!-- 最新消息內容 -->
          <div class="w-full h-[112px] p-5 bg-[#4D7F95] text-[16px] flex flex-row justify-between items-center">
            <!-- 會員頭像 -->
            <img src="" class="w-[66px] h-[66px] rounded-full bg-white" alt="">
            <!-- 會員資訊 -->
            <div class="w-[45%] ps-10 flex-initial flex flex-col">
              <div>會員姓名</div>
              <div>活動時間</div>
            </div>
            <!-- 會員行為 -->
            <div class="w-[40%] flex-initial">報名了中興大學Bootcamp</div>
          </div>
        </div>
      </div>
      <!-- 事件紀錄表 -->
      <div class="w-full h-[671px] p-3 bg-[#234E66] rounded-[10px] flex flex-col items-center gap-3">
        <!-- 搜尋欄 -->
        <div class="w-full h-[59px] ps-10 bg-white flex items-center gap-5 text-[48px] font-semibold">
          事件紀錄
          <!-- 起始日期 -->
          <input type="date">
          ~
          <!-- 結束日期 -->
          <input type="date">
          <input type="search" name="" id="">
          <button type="button" class="w-[86px] h-[38px] bg-[gray] rounded-[4px] text-[22px]">搜尋</button>
        </div>
        <!-- 搜尋內容 -->
        <div class="w-full flex flex-col text-[48px] text-white">
          <!-- 表頭 -->
          <div class="flex bg-[#285F87]">
            <div class="w-[20%] flex-initial border flex justify-center items-center">使用者名稱</div>
            <div class="w-[10%] flex-initial border flex justify-center items-center">類別</div>
            <div class="w-[30%] flex-initial border flex justify-center items-center">日期</div>
            <div class="w-[40%] flex-initial border flex justify-center items-center">行為</div>
          </div>
          <!-- 詳細資料 -->
          <div class="bg-[#A9BCC6] flex">
            <div class="w-[20%] flex-initial border flex justify-center items-center">潘國偉</div>
            <div class="w-[10%] flex-initial border flex justify-center items-center">學員</div>
            <div class="w-[30%] flex-initial border flex justify-center items-center">2023/09/07 12:00</div>
            <div class="w-[40%] flex-initial border flex justify-center items-center">取消了BootCamp</div>
          </div>
        </div>
        <div class="w-[313px] h-[56px] bg-white rounded-[30px] flex justify-center">
          <Pagination></Pagination>
        </div>
      </div>
    </div>
    <!-- <Link :href="route('register')" class="btn-base">註冊</Link>
    <Link :href="route('dashboard')" class="btn-base">登入</Link> -->
  </section>
</template>

<style lang="scss" scoped>
#backend-dashboard {
  @apply w-full h-full overflow-y-auto;

  .title {
    @apply text-[56px] text-center font-bold;
  }

  .btn-base {
    @apply p-1.5 border-2 rounded-md border-green-500 cursor-pointer;
  }
}
</style>
