<!-- 活動詳細資訊或個人活動資訊 -->
<script>
import magnifer from '/images/icon/magnifer.svg';

export default {
  props: {
    tableData: {
      type: Object,
      required: false,
      default: () => ({}),
    },
    typeData: {
      type: Array,
      required: false,
      default: () => [],
    },
  },
  data() {
    return {
      images: {
        magnifer,
      },
    };
  },
};
</script>

<template>
  <section id="activity-details">
    <div class="m-auto w-full h-[505px] p-10 flex flex-col items-center">
      <!-- 搜尋欄位 -->
      <div class="mb-[5px] w-full h-[48px] pt-[10px] border-t-[#000] border-t-[1px] flex justify-between">
        <!-- 活動種類篩選器 -->
        <select class="h-full bg-[#80808012] text-[10px] flex justify-center" placeholder="活動分類">
          <option v-for="activityType in typeData" :key="activityType.id" :value="activityType.id">
            {{ activityType.name }}
          </option>
        </select>
        <!-- 文字搜尋框 -->
        <div class="w-[15%] h-full bg-[#80808012] flex justify-center items-center gap-1">
          <img :src="images.magnifer" class="w-[16px]" alt="搜尋">
          <input type="search" class="w-[80%] h-[80%]">
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
      <div v-for="(item, index) in tableData?.data ?? []" :key="index" class="w-full h-[53px] flex">
        <Link :href="route('studentActivityDetails', { id: item.id })" class="flex-none w-[50%] ps-3 border bg-[#a9bcc67e] flex justify-start items-center text-[16px]">
          {{ item.activity_name }}
        </Link>
        <div class="flex-initial w-[10%] border bg-[#82acc27d] flex justify-center items-center text-[16px] font-semibold">
          <slot name="activity_info_type">
            {{ item.activity_presenter || item.activity_type_name }}
          </slot>
        </div>
        <div class="flex-initial w-[20%] ps-3 border bg-[#a9bcc67e] flex justify-start items-center text-[16px]">
          {{ item.activity_end_registration_time }}
        </div>
        <div class="flex-initial w-[20%] ps-3 border bg-[#a9bcc67e] flex justify-between items-center text-[16px]">
          門檻:{{ item.activity_lowest_number_of_people }}
          上限:{{ item.activity_highest_number_of_people }}
          <div class="pe-3 flex items-center justify-center">
            目前人數：{{ item.registration_count }}
          </div>
        </div>
      </div>
      <Pagination :pagination-data="tableData" class="pt-3" />
    </div>
  </section>
</template>

<style lang="scss" scoped>
#activity-details {
  @apply w-[1400px];
}
</style>
