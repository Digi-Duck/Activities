<!-- 活動詳細資訊或個人活動資訊 -->
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
      title: 'Hello World !',
    };
  },
  computed: {
    // 後端傳來的分頁資料
    paginationData() {
      return this.response?.rt_data ?? {};
    },
  },
};
</script>

<template>
  <section class="w-[1400px]">
    <div class="m-auto w-full h-[505px] p-10 border flex flex-col items-center">
      <!-- 搜尋欄位 -->
      <div class="w-full h-[48px] border flex justify-between">
        <!-- 活動種類篩選器 -->
        <select class="h-full text-[10px] flex justify-center" placeholder="活動分類">
          <option value="Taipei">文化與藝術</option>
          <option value="Taoyuan">學術與培訓</option>
          <option value="Hsinchu">社交與社團</option>
          <option value="Miaoli">旅遊與戶外</option>
          <option value="Taipei">健康與福祉</option>
          <option value="Taoyuan">商業與職業發展</option>
          <option value="Hsinchu">娛樂與文化慶典</option>
          <option value="Miaoli">科技與創新</option>
          <option value="Miaoli">其他</option>
        </select>
        <!-- 文字搜尋框 -->
        <div class="w-[15%] h-full bg-[yellow] flex items-center">
          <img src="" class="w-[20%]" alt="搜尋">
          <input type="search" class="w-full">
        </div>
      </div>
      <!-- 搜尋的表頭 -->
      <div class="w-full h-[64px] flex">
        <div class="flex-none w-[50%] border bg-[#5D8BA3] flex justify-center items-center text-[24px]">
          活動名稱
        </div>
        <div class="flex-initial w-[10%] border bg-[#82ACC2] flex justify-center items-center text-[24px]">
          <slot name="activity_title_type">活動類型</slot>
        </div>
        <div class="flex-initial w-[20%] border bg-[#A9BCC6] flex justify-center items-center text-[24px]">
          報名截止時間
        </div>
        <div class="flex-initial w-[20%] border bg-[#A9BCC6] flex justify-center items-center text-[24px]">
          人數狀況
        </div>
      </div>
      <!-- 詳細搜尋內容 -->
      <div class="w-full h-[53px] flex">
        <div class="flex-none w-[50%] ps-3 border bg-[#a9bcc67e] flex justify-start items-center text-[16px]">
          <slot name="activity_name">
            活動名稱
          </slot>
        </div>
        <div class="flex-initial w-[10%] border bg-[#82acc27d] flex justify-center items-center text-[16px] font-semibold">
          <slot name="activity_type">
            活動類型
          </slot>
        </div>
        <div class="flex-initial w-[20%] ps-3 border bg-[#a9bcc67e] flex justify-start items-center text-[16px]">
          <slot name="activity_end_registration_time">
            報名截止時間
          </slot>
        </div>
        <div class="flex-initial w-[20%] ps-3 border bg-[#a9bcc67e] flex justify-start items-center text-[16px]">
          開課門檻:<slot name="activity_lowest_number_of_people">開課門檻</slot>
          人數限制:<slot name="activity_highest_number_of_people">人數限制</slot>
        </div>
      </div>
      <Pagination :pagination-data="paginationData" class="pt-3" />
    </div>
  </section>
</template>

<style lang="scss" scoped>
#Activity-details {
  @apply w-full h-full overflow-y-auto;

  .title {
    @apply text-[6.25rem] text-center;
  }

  .btn-base {
    @apply p-1.5 border-2 rounded-md border-green-500 cursor-pointer;
  }
}
</style>
