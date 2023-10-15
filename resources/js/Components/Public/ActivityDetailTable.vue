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
      keyword: '',
      selectedStatus: '',
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
        <select v-model="selectedActivityType" @change="searchData" class="h-full bg-[#80808012] text-[10px] flex justify-center" placeholder="活動分類">
          <option value="">所有活動</option>
          <option v-for="activityType in typeData" :key="activityType.id" :value="activityType.id">
            {{ activityType.name }}
          </option>
        </select>
        <!-- 文字搜尋框 -->
        <div class="w-[15%] h-full bg-[#80808012] flex justify-center items-center gap-1">
          <img :src="images.magnifer" class="w-[16px]" alt="搜尋">
          <input v-model="keyword" type="search" class="w-[80%] h-[80%]" @input="searchData">
        </div>
      </div>
      <!-- 搜尋的表頭 -->
      <div class="w-full h-[64px] flex">
        <div class="flex-none w-[50%] border bg-[#5D8BA3] flex justify-center items-center text-[24px]">
          <slot name="activity_title_name">活動名稱</slot>
        </div>
        <div class="flex-initial w-[10%] border bg-[#82ACC2] flex justify-center items-center text-[24px]">
          <slot name="activity_title_type">活動類型</slot>
        </div>
        <div class="flex-initial w-[20%] border bg-[#A9BCC6] flex justify-center items-center text-[24px]">
          <slot name="activity_title_time">報名截止時間</slot>
        </div>
        <div class="flex-initial w-[20%] border bg-[#A9BCC6] flex justify-center items-center text-[24px]">
          <slot name="activity_title_number">人數狀況</slot>
        </div>
      </div>
      <!-- 詳細搜尋內容 -->
      <div v-for="(item, index) in tableData?.data ?? []" :key="index" class="w-full h-[53px] flex">
        <Link :href="route('studentActivityDetails', { id: item.id })" class="flex-none w-[50%] ps-3 border bg-[#a9bcc67e] flex justify-start items-center text-[16px]">
          {{ item.activity_name || item.student_email }}
        </Link>
        <div class="flex-initial w-[10%] border bg-[#82acc27d] flex justify-center items-center text-[16px] font-semibold">
          <slot name="activity_info_type">
            {{ item.activity_presenter || item.activity_type_name || item.student_name }}
          </slot>
        </div>
        <div class="flex-initial w-[20%] ps-3 border bg-[#a9bcc67e] flex justify-start items-center text-[16px]">
          {{ item.activity_end_registration_time || item.student_phone_number }}
        </div>
        <div class="flex-initial w-[20%] ps-3 border bg-[#a9bcc67e] flex justify-between items-center text-[16px]">
          <slot name="student_additional_remark">
            <span v-if="item.student_additional_remark">
              {{ item.student_additional_remark }}
            </span>
            <span v-else>
              門檻:{{ item.activity_lowest_number_of_people }}
              上限:{{ item.activity_highest_number_of_people }}
              <div class="pe-3 flex items-center justify-center">
                目前人數：{{ item.registration_count }}
              </div>
            </span>
          </slot>
        </div>
      </div>
      <div class="w-[313px] h-[56px] bg-white rounded-[30px] border shadow-xl flex justify-center">
        <Pagination :pagination-data="tableData" class="pt-3" />
      </div>
    </div>
  </section>
</template>

<style lang="scss" scoped>
#activity-details {
  @apply w-[1400px];
}
</style>
