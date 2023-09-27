<script>
import activity_address from '/images/icon/activity_address.svg';
import activity_end_time from '/images/icon/activity_end_time.svg';
import activity_presenter from '/images/icon/activity_presenter.svg';
import activity_start_time from '/images/icon/activity_start_time.svg';
import highest_number_of_people from '/images/icon/highest_number_of_people.svg';
import lowest_number_of_people from '/images/icon/lowest_number_of_people.svg';
import register_time from '/images/icon/register_time.svg';
import exclamation_triangle from '/images/icon/exclamation_triangle.svg';
import swiper_test from '/images/icon/swiper_test.jpg.svg';

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
      images: {
        activity_address,
        activity_end_time,
        activity_presenter,
        activity_start_time,
        highest_number_of_people,
        lowest_number_of_people,
        register_time,
        exclamation_triangle,
        swiper_test,
      },
    };
  },
  methods: {
    test(event) {
      console.log(event);
    },
  },
};
</script>

<template>
  <section class="flex flex-col">
    <!-- 建立活動資訊填寫 -->
    <ActivityDetailSwiper></ActivityDetailSwiper>
    <!-- <div class="relative mt-5 flex">
      <div class="absolute w-full z-10">
        <div class="absolute top-[80px] w-[175px] h-[41px] bg-white text-[20px] font-semibold flex justify-center items-center">活動分類
          <div id="triangle" class="absolute left-[175px] -top-[0px] w-[10px] h-[10px]">
            <div id="triangle-top"></div>
            <div id="triangle-bottom"></div>
          </div>
        </div>
        <div class="absolute left-[265px] top-[131px] w-[288px] h-[219px] flex flex-col justify-between items-start">
          <div class="text-[72px] font-bold">活動名稱</div>
          <div class="text-[24px]">活動Slogan</div>
          <button type="button" class="w-[136px] h-[56px] bg-[#FFFFFF] text-[18px] font-semibold">更改圖片</button>
        </div>
        <div class="absolute left-[50px] top-[415px] w-[95%] flex justify-between">
          <button ref="btnPrev" class="h-[50px] w-[50px] rounded-[50px] bg-red-500" type="button">前面</button>
          <button ref="btnNext" class="h-[50px] w-[50px] rounded-[50px] bg-red-500" type="button">後面</button>
        </div>
        <div class="absolute left-[100px] top-[495px] w-[90%] h-[289px] pt-[10px] px-[60px] bg-[#f2f2f2b2] flex flex-wrap gap-5">
          <div class="w-[24%] h-[68px] flex border-e-4 border-e-gray-500">
            <img :src="images.lowest_number_of_people" alt="開課門檻" class="w-[10%] pe-1">
            <input type="text" name="" id="" class="rounded-[5px] w-full text-2xl font-bold" placeholder="請輸入開課門檻">
          </div>
          <div class="w-[24%] h-[68px] flex border-e-4 border-e-gray-500">
            <img :src="images.highest_number_of_people" alt="人數上限" class="w-[10%] pe-1">
            <input type="text" name="" id="" class="rounded-[5px] w-full text-2xl font-bold" placeholder="請輸入人數上限">
          </div>
          <div class="w-[24%] h-[68px] flex border-e-4 border-e-gray-500">
            <img :src="images.register_time" alt="報名開始時間" class="w-[10%] pe-1">
            <input type="text" name="" id="" class="rounded-[5px] w-full text-2xl font-bold" placeholder="請輸入報名開始時間">
          </div>
          <div class="w-[24%] h-[68px] flex border-e-4 border-e-gray-500">
            <img :src="images.register_time" alt="報名截止時間" class="w-[10%] pe-1">
            <input type="text" name="" id="" class="rounded-[5px] w-full text-2xl font-bold" placeholder="請輸入報名截止時間">
          </div>
          <div class="w-[24%] h-[68px] flex border-e-4 border-e-gray-500">
            <img :src="images.activity_presenter" alt="主講者" class="w-[10%] pe-1">
            <input type="text" name="" id="" class="rounded-[5px] w-full text-2xl font-bold" placeholder="請輸入主講者">
          </div>
          <div class="w-[24%] h-[68px] flex border-e-4 border-e-gray-500">
            <img :src="images.activity_start_time" alt="活動開始時間" class="w-[10%] pe-1">
            <input type="text" name="" id="" class="rounded-[5px] w-full text-2xl font-bold" placeholder="請點選活動開始時間">
          </div>
          <div class="w-[24%] h-[68px] flex border-e-4 border-e-gray-500">
            <img :src="images.activity_end_time" alt="活動結束時間" class="w-[10%] pe-1">
            <input type="text" name="" id="" class="rounded-[5px] w-full text-2xl font-bold" placeholder="請點選活動結束時間">
          </div>
          <div class="w-[24%] h-[68px] flex border-e-4 border-e-gray-500">
            <img :src="images.activity_address" alt="活動地點" class="w-[10%] pe-1">
            <input type="text" name="" id="" class="rounded-[5px] w-full text-2xl font-bold" placeholder="請輸入活動地點">
          </div>
          <div class="w-full h-[56px] flex items-center bg-[#ffffff5a] rounded-[14px] px-2">
            <img :src="images.exclamation_triangle" alt="參加須知" class="w-[40px] h-[40px]">
            <input type="text" name="" id="" placeholder="請輸入參加須知" class="w-full">
          </div>
        </div>
      </div>
      <swiper :slide-data="[1, 2]" class="absolute opacity-20" :btn-next="$refs.btnNext">
        <div>
          <img src="https://picsum.photos/1980/901" alt="產業類別圖片">
        </div>
      </swiper>
    </div> -->
    <!-- 編輯工具列；所見即所得區 -->
    <Editor></Editor>
    <!-- <editor v-model="editorValue" :init="editorInit" class="min-h-[500px]" @update-content="test" /> -->
    <div class="flex w-full justify-center gap-[45px] py-5">
      <button type="button" class="px-[30px] py-[15px] bg-[#690926] rounded-[5px] flex justify-center items-center text-white">取消開課</button>
      <button type="button" class="px-[30px] py-[15px] bg-[#095269] rounded-[5px] flex justify-center items-center text-white">確認開課</button>
    </div>
  </section>
</template>

<style lang="scss" scoped>
#swiper-test {
  @apply w-full h-full overflow-y-auto;
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
