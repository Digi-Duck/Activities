<!-- 活動詳細資訊Swiper的頁面 -->

<script>
import activityAddress from '/images/icon/activity_address.svg';
import activityEndTime from '/images/icon/activity_end_time.svg';
import activityPresenter from '/images/icon/activity_presenter.svg';
import activityStartTime from '/images/icon/activity_start_time.svg';
import highestNumberOfPeople from '/images/icon/highest_number_of_people.svg';
import lowestNumberOfPeople from '/images/icon/lowest_number_of_people.svg';
import registerTime from '/images/icon/register_time.svg';
import exclamationTriangle from '/images/icon/exclamation_triangle.svg';
import arrowLeft from '/images/icon/icon-arrow-left.svg';
import arrowRight from '/images/icon/icon-arrow-right.svg';

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
      prevButton: null, // 在这里定义 prevButton 和 nextButton
      nextButton: null,
      images: {
        activityAddress,
        activityEndTime,
        activityPresenter,
        activityStartTime,
        highestNumberOfPeople,
        lowestNumberOfPeople,
        registerTime,
        exclamationTriangle,
        arrowLeft,
        arrowRight,
      },
    };
  },
  mounted() {
    // 通过类名或其他方式获取按钮元素并赋值给 prevButton 和 nextButton
    this.prevButton = this.$refs.btnPrev;
    this.nextButton = this.$refs.btnNext;
  },
  // methods: {
  //   test(event) {
  //     console.log(event);
  //   },
  // },
};
</script>

<template>
  <section id="activity-detail-swiper" class="relative flex flex-col">
    <!-- 建立活動資訊填寫 -->
    <div class="relative mt-5 flex flex-col">
      <div class="relative w-full z-10">
        <div class="absolute top-[80px] w-[175px] h-[41px] bg-white text-[20px] font-semibold flex justify-center items-center">
          <slot name="activity_type">活動類型</slot>
          <div id="triangle" class="absolute left-[175px] -top-[0px] w-[10px] h-[10px]">
            <div id="triangle-top"></div>
            <div id="triangle-bottom"></div>
          </div>
        </div>
        <div class="absolute left-[265px] top-[131px] w-[288px] h-[219px] flex flex-col justify-between items-start">
          <div class="text-[72px] font-bold">
            <slot name="activity_name">活動名稱</slot>
          </div>
          <div class="w-[100%] bg-[#ffffff9b] text-[24px]">
            <slot name="activity_info">活動Slogan</slot>
          </div>
          <button type="button" class="w-[136px] h-[56px] bg-[#FFFFFF] text-[18px] font-semibold">更改圖片</button>
        </div>
        <div class="absolute left-[50px] top-[415px] w-[95%] flex justify-between">
          <button ref="btnPrev" id="prevBtn" class="h-[50px] w-[50px] z-50 rounded-[50px] bg-white" type="button">
            <img :src="images.arrowLeft" alt="活動照片海報向左移動按鈕">
          </button>
          <button ref="btnNext" id="nextBtn" class="h-[50px] w-[50px] z-50 rounded-[50px] bg-white" type="button">
            <img :src="images.arrowRight" alt="活動照片海報向右移動按鈕">
          </button>
        </div>
        <!-- 活動資訊框 -->
        <div class="absolute left-[100px] top-[495px] w-[90%] h-[289px] pt-[10px] px-[60px] bg-[#f2f2f2b2] flex flex-wrap gap-5">
          <div class="w-[24%] h-[68px] flex border-e-4 border-e-gray-500">
            <img :src="images.lowestNumberOfPeople" alt="開課門檻" class="w-[10%] pe-1">
            <div type="text" class="rounded-[5px] w-full text-2xl font-bold flex justify-start items-center">
              <slot name="activity_lowest_number_of_people">開課門檻</slot>
            </div>
          </div>
          <div class="w-[24%] h-[68px] flex border-e-4 border-e-gray-500">
            <img :src="images.highestNumberOfPeople" alt="人數上限" class="w-[10%] pe-1">
            <div type="text" name="" id="" class="rounded-[5px] w-full text-2xl font-bold flex justify-start items-center">
              <slot name="activity_highest_number_of_people">人數上限</slot>
            </div>
          </div>
          <div class="w-[24%] h-[68px] flex border-e-4 border-e-gray-500">
            <img :src="images.registerTime" alt="報名開始時間" class="w-[10%] pe-1">
            <div type="text" name="" id="" class="rounded-[5px] w-full text-2xl font-bold flex justify-start items-center">
              <slot name="activity_start_registration_time">報名開始時間</slot>
            </div>
          </div>
          <div class="w-[24%] h-[68px] flex border-e-4 border-e-gray-500">
            <img :src="images.registerTime" alt="報名截止時間" class="w-[10%] pe-1">
            <div type="text" name="" id="" class="rounded-[5px] w-full text-2xl font-bold flex justify-start items-center">
              <slot name="activity_end_registration_time">報名截止時間</slot>
            </div>
          </div>
          <div class="w-[24%] h-[68px] flex border-e-4 border-e-gray-500">
            <img :src="images.activityPresenter" alt="主講者" class="w-[10%] pe-1">
            <div type="text" name="" id="" class="rounded-[5px] w-full text-2xl font-bold flex justify-start items-center">
              <slot name="activity_presenter">講者</slot>
            </div>
          </div>
          <div class="w-[24%] h-[68px] flex border-e-4 border-e-gray-500">
            <img :src="images.activityStartTime" alt="開始時間" class="w-[10%] pe-1">
            <div type="text" name="" id="" class="rounded-[5px] w-full text-2xl font-bold flex justify-start items-center">
              <slot name="activity_start_time">開始時間</slot>
            </div>
          </div>
          <div class="w-[24%] h-[68px] flex border-e-4 border-e-gray-500">
            <img :src="images.activityEndTime" alt="結束時間" class="w-[10%] pe-1">
            <div type="text" name="" id="" class="rounded-[5px] w-full text-2xl font-bold flex justify-start items-center">
              <slot name="activity_end_time">結束時間</slot>
            </div>
          </div>
          <div class="w-[24%] h-[68px] flex border-e-4 border-e-gray-500">
            <img :src="images.activityAddress" alt="地點" class="w-[10%] pe-1">
            <div type="text" name="" id="" class="rounded-[5px] w-full text-2xl font-bold flex justify-start items-center">
              <slot name="activity_address">地點</slot>
            </div>
          </div>
          <div class="w-full h-[56px] flex items-center bg-[#ffffff5a] rounded-[14px] px-2">
            <img :src="images.exclamationTriangle" alt="參加須知" class="w-[40px] h-[40px]">
            <div type="text" name="" id="" placeholder="請輸入參加須知" class="w-full">
              <slot name="activity_instruction">參加須知</slot>
            </div>
          </div>
        </div>
      </div>
      <Swiper :slide-data="[1, 2]" class="absolute opacity-60" :btn-prev="prevButton" :btn-next="nextButton">
        <SwiperSlide class="m-auto">
          <img src="https://picsum.photos/1980/901" alt="產業類別圖片">
        </SwiperSlide>
      </Swiper>
    </div>
  </section>
</template>

<style lang="scss" scoped>
#activity-detail-swiper {
  @apply w-full h-full;
  #triangle {
    #triangle-top {
      border-width: 10px;
      border-style: solid;
      border-right-color: transparent;
      border-top-color: transparent;
      border-bottom-color: white;
      border-left-color: white;
    }
    #triangle-bottom {
      border-width: 10px;
      border-style: solid;
      border-right-color: transparent;
      border-top-color: white;
      border-bottom-color: transparent;
      border-left-color: white;
    }
  }

  .title {
    @apply text-[6.25rem] text-center;
  }

  .btn-base {
    @apply p-1.5 border-2 rounded-md border-green-500 cursor-pointer;
  }
}
</style>
