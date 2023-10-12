<!-- 後台儀表板頁面 -->

<script>
import Pagination from '@/Components/Public/Pagination.vue';
import { router } from '@inertiajs/vue3';
import student from '/images/icon/user-group-solid.svg';
import surfNumber from '/images/icon/arrow-pointer-solid.svg';
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
      selectedType: 1,
      startDate: fourteenDaysAgo.toISOString().substr(0, 10), // Set to 14 days ago
      endDate: today.toISOString().substr(0, 10), // Set to today
      startRecordDate: fourteenDaysAgo.toISOString().substr(0, 10), // Set to 14 days ago
      endRecordDate: today.toISOString().substr(0, 10), // Set to today
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
    activityCount() {
      return this.rtData.activityCount ?? 0;
    },
    studentCount() {
      return this.rtData.studentCount ?? 0;
    },
    presenterCount() {
      return this.rtData.presenterCount ?? 0;
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
      <span class="text-[24px]">form {{ twoWeeksAgo }} to now</span>
    </h1>
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
            <img :src="images.student" class="absolute right-[50px] top-[25px] w-[48.15px] h-[56.65px]" alt="數據圖標">
          </div>
          <div class="h-[112px] p-5 rounded-b-[10px] bg-[#F08B8B] text-[16px] flex justify-between">上升10%
            <img src="" class="w-[33px] h-[33px]" alt="數據狀態圖標">
          </div>
        </div>
        <div class="w-full h-[159px] border rounded-[10px] bg-white flex flex-col">
          <div class="relative h-full p-5 rounded-t-[10px] bg-white flex justify-between">
            <div>
              <div class="border-b-2 text-[36px]">
                {{ activityCount }}
              </div>
              <div class="text-[24px]">新增活動數</div>
            </div>
            <!-- 資料icon -->
            <img :src="images.student" class="absolute right-[50px] top-[25px] w-[48.15px] h-[56.65px]" alt="數據圖標">
          </div>
          <div v-if="activityCount > activityCount14DaysAgo" class="h-[112px] p-5 rounded-b-[10px] bg-[#F08B8B] text-[16px] flex justify-between">
            <span>
              上升{{ ((activityCount - activityCount14DaysAgo) / activityCount14DaysAgo) * 100 }}%%
            </span>
            <img :src="images.dataUp" class="w-[33px] h-[33px]" alt="數據狀態圖標">
          </div>
          <div v-else class="h-[112px] p-5 rounded-b-[10px] bg-[green] text-[16px] flex justify-between">
            下降{{ ((activityCount - activityCount14DaysAgo) / activityCount14DaysAgo) * 100 }}%
            <img :src="images.dataDown" class="w-[33px] h-[33px]" alt="數據狀態圖標">
          </div>
        </div>
        <div class="w-full h-[159px] border rounded-[10px] bg-white flex flex-col">
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
              上升{{ ((studentCount - studentCount14DaysAgo) / studentCount14DaysAgo) * 100 }}%%
            </span>
            <img :src="images.dataUp" class="w-[33px] h-[33px]" alt="數據狀態圖標">
          </div>
          <div v-else class="h-[112px] p-5 rounded-b-[10px] bg-[green] text-[16px] flex justify-between">
            下降{{ ((studentCount - studentCount14DaysAgo) / studentCount14DaysAgo) * 100 }}%
            <img :src="images.dataDown" class="w-[33px] h-[33px]" alt="數據狀態圖標">
          </div>
        </div>
        <div class="w-full h-[159px] border rounded-[10px] bg-white flex flex-col">
          <div class="relative h-full p-5 rounded-t-[10px] bg-white flex justify-between">
            <div>
              <div class="border-b-2 text-[36px]">
                {{ presenterCount }}
              </div>
              <div class="text-[24px]">新增講師數</div>
            </div>
            <!-- 資料icon -->
            <img :src="images.student" class="absolute right-[50px] top-[25px] w-[48.15px] h-[56.65px]" alt="數據圖標">
          </div>
          <div v-if="presenterCount > presenterCount14DaysAgo" class="h-[112px] p-5 rounded-b-[10px] bg-[#F08B8B] text-[16px] flex justify-between">
            <span>
              上升{{ ((presenterCount - presenterCount14DaysAgo) / presenterCount14DaysAgo) * 100 }}%%
            </span>
            <img :src="images.dataUp" class="w-[33px] h-[33px]" alt="數據狀態圖標">
          </div>
          <div v-else class="h-[112px] p-5 rounded-b-[10px] bg-[green] text-[16px] flex justify-between">
            下降{{ ((presenterCount - presenterCount14DaysAgo) / presenterCount14DaysAgo) * 100 }}%
            <img :src="images.dataDown" class="w-[33px] h-[33px]" alt="數據狀態圖標">
          </div>
        </div>
      </div>
      <!-- 詳細圖表及最新消息區 -->
      <div class="w-full h-[728.5px] flex flex-row justify-between gap-5 mb-5">
        <!-- 詳細圖表 -->
        <div class="w-[1008px] rounded-[10px] border-2 border-[#000000] flex flex-col overflow-hidden">
          <div class="w-full h-[106px] bg-[#397CA4] flex justify-start items-center gap-[20px]">
            <select v-model="selectedType" class="h-[70%]" id="" @change="searchChart">
              <option value=1>新增活動數量</option>
              <option value=2>新增講師數量</option>
              <option value=3>新增學員數量</option>
            </select>
            <div class="h-[70%] bg-[white] flex gap-1">
              <input v-model="startDate" type="date" id="" @change="searchChart">
              <span class="flex items-center">～</span>
              <input v-model="endDate" type="date" id="" @change="searchChart">
            </div>
            <button type="button" @click="searchChart" class="w-[90px] h-[38px] bg-[#a0bcc650] rounded-[5px] text-[24px]">搜尋</button>
          </div>
          <Echart class="h-[623px]" :response="chartData"></Echart>
        </div>
        <!-- 最新消息 -->
        <div class="w-[559px] rounded-[10px] border-2 border-[#000000] text-white overflow-hidden flex flex-col gap-3">
          <!-- 最新消息表頭 -->
          <div class="w-full h-[106px] ps-5 rounded-t-[10px] bg-[#397AC4] text-[48px] flex items-center">最新消息</div>
          <!-- 最新消息內容 -->
          <div v-for="(item, index) in newBehaviors" :key="index" class="w-full h-[112px] p-5 bg-[#4D7F95] text-[16px] flex flex-row justify-between items-center">
            <!-- 會員頭像 -->
            <img v-if="item.student_image" :src="item.student_image" class="w-[66px] h-[66px] rounded-full bg-white" alt="學員照片">
            <img v-else-if="item.presenter_image" :src="item.presenter_image" class="w-[66px] h-[66px] rounded-full bg-white" alt="講師照片">
            <img v-else :src="images.defaultImage" class="w-[66px] h-[66px] rounded-full bg-white" alt="預設照片">
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
        <div class="w-full h-[59px] ps-10 bg-white flex items-center gap-5 text-[48px] font-semibold">
          事件紀錄
          <div class="h-[70%] bg-[white] flex gap-1">
            <input v-model="startRecordDate" type="date" id="">
            <span class="flex items-center">～</span>
            <input v-model="endRecordDate" type="date" id="">
          </div>
          <input v-model="keyword" type="search" placeholder="請輸入搜尋使用者名稱、行為" @search="searchRecord">
          <button type="button" @click="searchRecord" class="w-[86px] h-[38px] bg-[gray] rounded-[4px] text-[22px]">搜尋</button>
        </div>
        <!-- 搜尋內容 -->
        <div class="w-full flex flex-col text-[36px] text-white">
          <!-- 表頭 -->
          <div class="flex bg-[#285F87]">
            <div class="w-[30%] flex-initial border flex justify-center items-center">日期</div>
            <div class="w-[20%] flex-initial border flex justify-center items-center">使用者名稱</div>
            <div class="w-[10%] flex-initial border flex justify-center items-center">類別</div>
            <div class="w-[40%] flex-initial border flex justify-center items-center">行為</div>
          </div>
          <!-- 詳細資料 -->
          <div v-for="(item, index) in behaviorRecord?.data ?? []" :key="index" class="bg-[#A9BCC6] flex">
            <div class="w-[30%] flex-initial border flex justify-center items-center">{{ item.created_at }}</div>
            <div class="w-[20%] flex-initial border flex justify-center items-center">{{ item.user_name }}</div>
            <div class="w-[10%] flex-initial border flex justify-center items-center">{{ item.user_type }}</div>
            <div class="w-[40%] flex-initial border flex justify-center items-center">{{ item.behavior }}</div>
          </div>
        </div>
        <div class="w-[313px] h-[56px] bg-white rounded-[30px] flex justify-center">
          <Pagination :pagination-data="behaviorRecord"></Pagination>
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
