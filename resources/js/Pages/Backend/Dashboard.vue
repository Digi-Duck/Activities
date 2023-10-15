<!-- 後台儀表板頁面 -->

<script>
import Pagination from '@/Components/Public/Pagination.vue';
import { router } from '@inertiajs/vue3';
import student from '/images/icon/user-group-solid.svg';
import surfNumber from '/images/icon/computer-mouse-solid.svg';
import dataUp from '/images/icon/caret-up-solid.svg';
import dataDown from '/images/icon/caret-down-solid.svg';
import defaultImage from '/images/icon/default-image.png';
import book from '/images/icon/book-solid.svg';
import presenter from '/images/icon/person-chalkboard-solid.svg';
import Echart from '@/Components/Public/Echart.vue';

export default {
  components: { Pagination, Echart },
  props: {
    response: {
      type: Object,
      required: false,
      default: () => ({}),
    },
  },
  data() {
    const today = new Date();
    const fourteenDaysAgo = new Date(today);
    fourteenDaysAgo.setDate(today.getDate() - 14);

    return {
      title: '數據摘要',
      selectedType: 4,
      startDate: fourteenDaysAgo.toISOString().substr(0, 10),
      endDate: today.toISOString().substr(0, 10),
      startRecordDate: fourteenDaysAgo.toISOString().substr(0, 10),
      endRecordDate: today.toISOString().substr(0, 10),
      keyword: this.response?.rt_data?.keyword ?? '',
      images: {
        student,
        surfNumber,
        book,
        presenter,
        defaultImage,
        dataUp,
        dataDown,
      },
    };
  },

  computed: {
    rtData() {
      return this.response?.rt_data ?? {};
    },
    chartData() {
      return this.rtData.chartData ?? { xAxis: {
        type: 'category',
        data: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
      },
      yAxis: {
        type: 'value',
      },
      series: [
        {
          data: [120, 200, 150, 80, 70, 110, 1300],
          type: 'bar',
        },
      ] };
    },
    newBehaviors() {
      return this.rtData.newBehaviors ?? {};
    },
    behaviorRecord() {
      return this.rtData.behaviorRecord ?? {};
    },
    twoWeeksAgo() {
      return this.rtData.twoWeeksAgo ?? 0;
    },
    websiteViewCount() {
      return this.rtData.websiteViewCount ?? 0;
    },
    activityCount() {
      return this.rtData.activityCount ?? 0;
    },
    studentCount() {
      return this.rtData.studentCount ?? 0;
    },
    presenterCount() {
      return this.rtData.presenterCount ?? 0;
    },
    websiteViewCount14DaysAgo() {
      return this.rtData.websiteViewCount14DaysAgo ?? 0;
    },
    activityCount14DaysAgo() {
      return this.rtData.activityCount14DaysAgo ?? 0;
    },
    studentCount14DaysAgo() {
      return this.rtData.studentCount14DaysAgo ?? 0;
    },
    presenterCount14DaysAgo() {
      return this.rtData.presenterCount14DaysAgo ?? 0;
    },
  },
  created() {
  },
  methods: {
    searchRecord() {
      router.get(route('dashboard'), { keyword: this.keyword, startRecordDate: this.startRecordDate, endRecordDate: this.endRecordDate }, {
        preserveState: true,
        preserveScroll: true,
      });
    },
    searchChart() {
      router.get(route('dashboard'), { selectedType: this.selectedType, startDate: this.startDate, endDate: this.endDate }, {
        preserveScroll: true,
        preserveState: true,
      });
    },
  },
};
</script>

<template>
  <section id="backend-dashboard" class="flex flex-col items-center">
    <h1 class="w-[80%] pb-1 border-b-4 title flex items-center gap-3">
      {{ title }}
      <span class="text-[24px]">form {{ twoWeeksAgo }} to {{ rtData.currentDate }}</span>
    </h1>
    <div class="w-[80%] mb-5 mt-5 flex flex-col justify-between items-center gap-10">
      <!-- 資訊小卡區 -->
      <div class="w-full flex-wrap flex flex-row justify-center gap-5 mb-5">
        <!-- 資訊預覽小卡 -->
        <div class="w-full md:w-[45%] mb-[30px] lg:flex-1 h-[159px] border rounded-[10px] bg-white flex flex-col">
          <div class="relative h-full p-5 rounded-t-[10px] bg-white flex justify-between">
            <div>
              <div class="border-b-2 text-[36px]">
                {{ websiteViewCount.toLocaleString() }}
              </div>
              <div class="text-[24px]">網站瀏覽量</div>
            </div>
            <!-- 資料icon -->
            <img :src="images.surfNumber" class="absolute right-[50px] top-[25px] w-[48.15px] h-[56.65px]" alt="數據圖標">
          </div>
          <div v-if="websiteViewCount > websiteViewCount14DaysAgo" class="h-[112px] p-5 rounded-b-[10px] bg-[#F08B8B] text-[16px] flex justify-between">
            <span>
              上升{{ ((websiteViewCount - websiteViewCount14DaysAgo) / websiteViewCount14DaysAgo * 100).toFixed(2) }}%
            </span>
            <img :src="images.dataUp" class="w-[33px] h-[33px]" alt="數據狀態圖標">
          </div>
          <div v-else class="h-[112px] p-5 rounded-b-[10px] bg-[green] text-[16px] flex justify-between">
            下降{{ ((websiteViewCount - websiteViewCount14DaysAgo) / websiteViewCount14DaysAgo * 100).toFixed(2) }}%
            <img :src="images.dataDown" class="w-[33px] h-[33px]" alt="數據狀態圖標">
          </div>
        </div>
        <div class="w-full md:w-[45%] mb-[30px] lg:flex-1 h-[159px] border rounded-[10px] bg-white flex flex-col">
          <div class="relative h-full p-5 rounded-t-[10px] bg-white flex justify-between">
            <div>
              <div class="border-b-2 text-[36px]">
                {{ activityCount }}
              </div>
              <div class="text-[24px]">新增活動數</div>
            </div>
            <!-- 資料icon -->
            <img :src="images.book" class="absolute right-[50px] top-[25px] w-[48.15px] h-[56.65px]" alt="數據圖標">
          </div>
          <div v-if="activityCount > activityCount14DaysAgo" class="h-[112px] p-5 rounded-b-[10px] bg-[#F08B8B] text-[16px] flex justify-between">
            <span>
              上升{{ ((activityCount - activityCount14DaysAgo) / activityCount14DaysAgo * 100).toFixed(2) }}%
            </span>
            <img :src="images.dataUp" class="w-[33px] h-[33px]" alt="數據狀態圖標">
          </div>
          <div v-else class="h-[112px] p-5 rounded-b-[10px] bg-[green] text-[16px] flex justify-between">
            下降{{ ((activityCount - activityCount14DaysAgo) / activityCount14DaysAgo * 100).toFixed(2) }}%
            <img :src="images.dataDown" class="w-[33px] h-[33px]" alt="數據狀態圖標">
          </div>
        </div>
        <div class="w-full md:w-[45%] mb-[30px] lg:flex-1 h-[159px] border rounded-[10px] bg-white flex flex-col">
          <div class="relative h-full p-5 rounded-t-[10px] bg-white flex justify-between">
            <div>
              <div class="border-b-2 text-[36px]">
                {{ studentCount }}
              </div>
              <div class="text-[24px]">新增學員數</div>
            </div>
            <!-- 資料icon -->
            <img :src="images.student" class="absolute right-[50px] top-[25px] w-[48.15px] h-[56.65px]" alt="數據圖標">
          </div>
          <div v-if="studentCount > studentCount14DaysAgo" class="h-[112px] p-5 rounded-b-[10px] bg-[#F08B8B] text-[16px] flex justify-between">
            <span>
              上升{{ ((studentCount - studentCount14DaysAgo) / studentCount14DaysAgo * 100).toFixed(2) }}%
            </span>
            <img :src="images.dataUp" class="w-[33px] h-[33px]" alt="數據狀態圖標">
          </div>
          <div v-else class="h-[112px] p-5 rounded-b-[10px] bg-[green] text-[16px] flex justify-between">
            下降{{ ((studentCount - studentCount14DaysAgo) / studentCount14DaysAgo * 100).toFixed(2) }}%
            <img :src="images.dataDown" class="w-[33px] h-[33px]" alt="數據狀態圖標">
          </div>
        </div>
        <div class="w-full md:w-[45%] mb-[30px] lg:flex-1 h-[159px] border rounded-[10px] bg-white flex flex-col">
          <div class="relative h-full p-5 rounded-t-[10px] bg-white flex justify-between">
            <div>
              <div class="border-b-2 text-[36px]">
                {{ presenterCount }}
              </div>
              <div class="text-[24px]">新增講師數</div>
            </div>
            <!-- 資料icon -->
            <img :src="images.presenter" class="absolute right-[50px] top-[25px] w-[48.15px] h-[56.65px]" alt="數據圖標">
          </div>
          <div v-if="presenterCount > presenterCount14DaysAgo" class="h-[112px] p-5 rounded-b-[10px] bg-[#F08B8B] text-[16px] flex justify-between">
            <span>
              上升{{ ((presenterCount - presenterCount14DaysAgo) / presenterCount14DaysAgo * 100).toFixed(2) }}%
            </span>
            <img :src="images.dataUp" class="w-[33px] h-[33px]" alt="數據狀態圖標">
          </div>
          <div v-else class="h-[112px] p-5 rounded-b-[10px] bg-[green] text-[16px] flex justify-between">
            下降{{ ((presenterCount - presenterCount14DaysAgo) / presenterCount14DaysAgo * 100).toFixed(2) }}%
            <img :src="images.dataDown" class="w-[33px] h-[33px]" alt="數據狀態圖標">
          </div>
        </div>
      </div>
      <!-- 詳細圖表及最新消息區 -->
      <div class="w-full 2xl:h-[728.5px] flex flex-col 2xl:flex-row justify-between gap-5 mb-5">
        <!-- 詳細圖表 -->
        <div class="flex-[0.7] rounded-[10px] border-2 border-[#000000] flex flex-col overflow-hidden">
          <div class="ps-[30px] w-full h-[106px] bg-[#397AC4] border flex justify-start items-center gap-1 lg:gap-[20px]">
            <b class="text-[18px] md:text-[24px] lg:text-[36px]">{{ rtData.title }}</b>
            <select v-model="selectedType" class="h-[50%] rounded-[5px]" @change="searchChart">
              <option value=4>網站瀏覽量</option>
              <option value=1>活動數量</option>
              <option value=2>講師數量</option>
              <option value=3>學員數量</option>
            </select>
            <div class="h-[50%] w-[25%] lg:w-[30%] rounded-[5px] border-black border bg-[white] flex gap-1">
              <input v-model="startDate" type="date" class="border-none" @change="searchChart">
              <span class="flex items-center">～</span>
              <input v-model="endDate" type="date" class="border-none" @change="searchChart">
            </div>
            <b class="text-[24px] flex items-center">共計 : {{ rtData.totalData.toLocaleString() }}</b>
          </div>
          <Echart class="h-[623px]" :response="chartData"></Echart>
        </div>
        <!-- 最新消息 -->
        <div class="flex-[0.3] rounded-[10px] border-2 border-[#000000] text-white overflow-hidden flex flex-col gap-3">
          <!-- 最新消息表頭 -->
          <div class="w-full h-[106px] ps-5 rounded-t-[10px] bg-[#397AC4] text-[48px] flex items-center">最新消息</div>
          <!-- 最新消息內容 -->
          <div v-for="(item, index) in newBehaviors" :key="index" :class="{ 'bg-[#5e2951a0]': item.user_type === '講師', 'bg-[#4d7f95b6]': item.user_type === '學員' }" class="w-full h-[112px] p-5 text-[16px] flex flex-row justify-between items-center">
            <!-- 會員頭像 -->
            <img v-if="item.student_image" :src="item.student_image" class="inline-block h-[66px] w-[66px] rounded-full ring-2 ring-white" alt="學員照片">
            <img v-else-if="item.presenter_image" :src="item.presenter_image" class="inline-block h-[66px] w-[66px] rounded-full ring-2 ring-white" alt="講師照片">
            <img v-else :src="images.defaultImage" class="inline-block h-[66px] w-[66px] rounded-full ring-2 ring-white" alt="預設照片">
            <!-- 會員資訊 -->
            <div class="w-[45%] ps-10 flex-initial flex flex-col">
              <div>{{ item.user_name }}</div>
              <div>{{ item.created_at }}</div>
            </div>
            <!-- 會員行為 -->
            <div class="w-[40%] flex-initial">{{ item.behavior }}</div>
          </div>
        </div>
      </div>
      <!-- 事件紀錄表 -->
      <div class="w-full h-full p-3 bg-[#234E66] rounded-[10px] flex flex-col items-center gap-3">
        <!-- 搜尋欄 -->
        <div class="w-full h-[59px] ps-3 bg-white flex justify-center items-center gap-3 text-[24px] lg:text-[36px] font-semibold">
          <span class="hidden md:inline">
            事件紀錄
          </span>
          <div class="h-[70%] w-[30%] max-w-[315px] rounded-[5px] border-black border bg-[white] flex gap-1">
            <input v-model="startRecordDate" type="date" class="border-none">
            <span class="flex text-[16px] items-center">～</span>
            <input v-model="endRecordDate" type="date" class="border-none">
          </div>
          <input v-model="keyword" type="search" class="w-[30%] max-w-[315px]" placeholder="請輸入搜尋使用者名稱、行為" @search="searchRecord">
          <button type="button" @click="searchRecord" class="w-[86px] h-[38px] bg-[gray] rounded-[4px] text-[22px]">搜尋</button>
        </div>
        <!-- 搜尋內容 -->
        <div class="w-full flex flex-col text-[36px] text-white">
          <!-- 表頭 -->
          <div class="flex text-[24px] bg-[#285F87]">
            <div class="w-[30%] flex-initial border flex justify-center items-center">日期</div>
            <div class="w-[20%] flex-initial border flex justify-center items-center">使用者名稱</div>
            <div class="w-[10%] flex-initial border flex justify-center items-center">類別</div>
            <div class="w-[40%] flex-initial border flex justify-center items-center">行為</div>
          </div>
          <!-- 詳細資料 -->
          <div v-for="(item, index) in behaviorRecord?.data ?? []" :class="{ 'bg-[#5e2951a0]': item.user_type === '講師', 'bg-[#4d7f95b6]': item.user_type === '學員' }" :key="index" class="bg-[#A9BCC6] text-[20px] flex">
            <div class="w-[30%] flex-initial border flex justify-center items-center">{{ item.created_at }}</div>
            <div class="w-[20%] flex-initial border flex justify-center items-center">{{ item.user_name }}</div>
            <div class="w-[10%] flex-initial border flex justify-center items-center">{{ item.user_type }}</div>
            <div class="w-[40%] flex-initial border flex justify-center items-center">{{ item.behavior }}</div>
          </div>
        </div>
        <div class="w-[313px] h-[56px] bg-white rounded-[30px] border shadow-xl flex justify-center">
          <Pagination :pagination-data="behaviorRecord"></Pagination>
        </div>
      </div>
    </div>
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
