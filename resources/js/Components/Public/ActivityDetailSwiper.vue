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
import registeredPeople from '/images/icon/user-group-solid.svg';

export default {
  props: {
    response: {
      type: Object,
      required: false,
      default: () => ({}),
    },
    slideData: {
      type: Array,
      default: () => [],
    },
  },
  data() {
    return {
      prevButton: null,
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
        registeredPeople,
      },
    };
  },
  mounted() {
    this.prevButton = this.$refs.btnPrev;
    this.nextButton = this.$refs.btnNext;
  },
};
</script>

<template>
  <section id="activity-detail-swiper" class="relative flex flex-col">
    <!-- 建立活動資訊填寫 -->
    <div class="relative mt-5 h-[901px] bg-[#eadada4d] flex flex-col">
      <div class="relative w-full z-10">
        <div class="absolute top-[40px] md:top-[80px] w-[175px] h-[41px] bg-white text-[20px] font-semibold flex justify-center items-center">
          <slot name="activity_type">活動類型</slot>
          <div id="triangle" class="absolute left-[175px] -top-[0px] w-[10px] h-[10px] border-s">
            <div id="triangle-top"></div>
            <div id="triangle-bottom"></div>
          </div>
        </div>
        <div class="absolute left-[20px] lg:left-[100px] top-[90px] lg:top-[120px] w-[full] h-[219px] bg-[#d1d0d050] flex flex-col justify-center items-start">
          <div class="text-[28px] sm:text-[50px] lg:text-[72px] font-bold">
            <slot name="activity_name">活動名稱</slot>
          </div>
          <div class="w-full text-[20px] sm:text-[36px]">
            <slot name="activity_info">活動Slogan</slot>
          </div>
        </div>
        <div class="absolute left-[2.5%] top-[415px] w-[95%] flex justify-between">
          <button ref="btnPrev" id="prevBtn" class="h-[50px] w-[50px] z-50 rounded-[50px] bg-white" type="button">
            <img :src="images.arrowLeft" alt="活動照片海報向左移動按鈕">
          </button>
          <button ref="btnNext" id="nextBtn" class="h-[50px] w-[50px] z-50 rounded-[50px] bg-white" type="button">
            <img :src="images.arrowRight" alt="活動照片海報向右移動按鈕">
          </button>
        </div>
        <!-- 活動資訊框 -->
        <div class="absolute left-[5%] top-[495px] w-[90%] lg:h-[289px] pt-[10px] px-[5px] md:px-[60px] bg-[#f2f2f2b2] rounded-[15px] flex flex-col gap-2 lg:gap-5">
          <div class="flex flex-col gap-2 lg:gap-0 lg:flex-row">
            <div class="flex-1 h-[68px] flex border-e-4 border-e-gray-500">
              <img :src="images.lowestNumberOfPeople" alt="開課門檻" class="w-[10%] pe-1">
              <div type="text" class="rounded-[5px] w-full bg-transparent text-2xl font-bold flex justify-start items-center">開課門檻:
                <slot name="activity_lowest_number_of_people">開課門檻</slot>人
              </div>
            </div>
            <div class="flex-1 h-[68px] flex border-e-4 border-e-gray-500">
              <img :src="images.highestNumberOfPeople" alt="人數上限" class="w-[10%] pe-1">
              <div type="text" name="" class="rounded-[5px] w-full bg-transparent text-2xl font-bold flex justify-start items-center">人數上限:
                <slot name="activity_highest_number_of_people">人數上限</slot>人
              </div>
            </div>
            <div class="flex-1 h-[68px] flex border-e-4 border-e-gray-500">
              <img :src="images.registerTime" alt="報名開始時間" class="w-[10%] pe-1">
              <div type="text" name="" class="rounded-[5px] w-full bg-transparent text-2xl font-bold flex justify-start items-center">報名開始:
                <slot name="activity_start_registration_time">報名開始時間</slot>
              </div>
            </div>
            <div class="flex-1 h-[68px] flex border-e-4 border-e-gray-500">
              <img :src="images.registerTime" alt="報名截止時間" class="w-[10%] pe-1">
              <div type="text" name="" class="rounded-[5px] w-full bg-transparent text-2xl font-bold flex justify-start items-center">報名截止:
                <slot name="activity_end_registration_time">報名截止時間</slot>
              </div>
            </div>
          </div>
          <div class="flex flex-col gap-2 lg:gap-0 lg:flex-row">
            <div class="flex-1 h-[68px] flex border-e-4 border-e-gray-500">
              <img :src="images.activityPresenter" alt="主講者" class="w-[10%] pe-1">
              <div type="text" name="" class="rounded-[5px] w-full bg-transparent text-2xl font-bold flex justify-start items-center">活動講師:
                <slot name="activity_presenter">講者</slot>
              </div>
            </div>
            <div class="flex-1 h-[68px] flex border-e-4 border-e-gray-500">
              <img :src="images.activityStartTime" alt="開始時間" class="w-[10%] pe-1">
              <div type="text" name="" class="rounded-[5px] w-full bg-transparent text-2xl font-bold flex justify-start items-center">活動開始:
                <slot name="activity_start_time">開始時間</slot>
              </div>
            </div>
            <div class="flex-1 h-[68px] flex border-e-4 border-e-gray-500">
              <img :src="images.activityEndTime" alt="結束時間" class="w-[10%] pe-1">
              <div type="text" name="" class="rounded-[5px] w-full bg-transparent text-2xl font-bold flex justify-start items-center">活動結束:
                <slot name="activity_end_time">結束時間</slot>
              </div>
            </div>
            <div class="flex-1 h-[68px] flex border-e-4 border-e-gray-500">
              <img :src="images.activityAddress" alt="地點" class="w-[10%] pe-1">
              <div type="text" name="" class="rounded-[5px] w-full bg-transparent text-2xl font-bold flex justify-start items-center">地點:
                <slot name="activity_address">地點</slot>
              </div>
            </div>
          </div>
          <div class="w-full h-[56px] flex items-center rounded-[14px] px-2">
            <!-- 活動須知 -->
            <div class="flex w-full">
              <img :src="images.exclamationTriangle" alt="參加須知" class="w-[40px] h-[40px]">
              <div type="text" name="" placeholder="請輸入參加須知" class="w-full bg-transparent">
                <slot name="activity_instruction">參加須知</slot>
              </div>
            </div>
            <figure class="w-[45%] h-[90%] text-[16px] lg:text-[30px] font-semibold flex justify-center items-center">
              <img :src="images.registeredPeople" class="w-[15%] p-1" alt="已報名人數icon">
              報名人數:
              <slot name="registerPeople">0</slot>
            </figure>
          </div>
        </div>
      </div>
      <Swiper v-slot="{ slide }" :slide-data="slideData[0]?.activityPhotos ?? []" class="w-[full] max-w-[1920px] h-full max-h-[901px]" :btn-prev="prevButton" :btn-next="nextButton">
        <div class="opacity-60 w-full h-full flex justify-center items-center">
          <img :src="slide" class="w-full h-full" alt="產業類別圖片">
        </div>
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
}
</style>
