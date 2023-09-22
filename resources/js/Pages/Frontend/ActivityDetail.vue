<script>
import activity_address from '/images/icon/activity_address.svg';
import activity_end_time from '/images/icon/activity_end_time.svg';
import activity_presenter from '/images/icon/activity_presenter.svg';
import activity_start_time from '/images/icon/activity_start_time.svg';
import highest_number_of_people from '/images/icon/highest_number_of_people.svg';
import lowest_number_of_people from '/images/icon/lowest_number_of_people.svg';
import register_time from '/images/icon/register_time.svg';
import exclamation_triangle from '/images/icon/exclamation_triangle.svg';
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
      },
    };
  },
  created() {
  },
};
</script>

<template>
  <section id="test" class="flex flex-col">
    <div class="flex justify-center gap-5 mb-5">
      <div class="swiper w-full h-[900px] bg-gray-600 flex flex-col relative items-center">
        <div id="classificaiton" class="absolute top-[89px] left-0 flex">
          <div class="w-[175px] h-[41px] bg-white after:w-[20px] flex justify-center items-center text-xl border-e-2">活動分類</div>
          <div id="triangle" class="bg-transparent">
            <div id="triangle-top"></div>
            <div id="triangle-bottom"></div>
          </div>
        </div>
        <div id="activity-info" class="w-[288px] h-[219px] bg-transparent absolute top-[131px] left-[180px] flex flex-col justify-between">
          <div id="activity-name" class="text-[72px] font-bold">活動名稱</div>
          <div id="activity-slogan" class="text-[24px]">活動slogan</div>
          <button type="button" id="change-photo" class="text-[18px] btn w-[136px] h-[56px] bg-[#FFFFFF] rounded-[8px]">更改圖片</button>
        </div>
        <div id="activity-details" class="w-[90%] h-[289px] bg-[#f2f2f2b2] absolute top-[495px] pt-[10px] px-[60px] flex flex-wrap gap-5">
          <div class="w-[24%] h-[68px] flex border-e-4 border-e-gray-500">
            <img :src="images.lowest_number_of_people" alt="" class="w-[10%] pe-1">
            <input type="text" name="" id="" class="rounded-[5px] w-full text-2xl font-bold" placeholder="請輸入開課門檻">
          </div>
          <div class="w-[24%] h-[68px] flex border-e-4 border-e-gray-500">
            <img :src="images.highest_number_of_people" alt="" class="w-[10%] pe-1">
            <input type="text" name="" id="" class="rounded-[5px] w-full text-2xl font-bold" placeholder="請輸入人數上限">
          </div>
          <div class="w-[24%] h-[68px] flex border-e-4 border-e-gray-500">
            <img :src="images.register_time" alt="" class="w-[10%] pe-1">
            <input type="text" name="" id="" class="rounded-[5px] w-full text-2xl font-bold" placeholder="請輸入報名開始時間">
          </div>
          <div class="w-[24%] h-[68px] flex border-e-4 border-e-gray-500">
            <img :src="images.register_time" alt="" class="w-[10%] pe-1">
            <input type="text" name="" id="" class="rounded-[5px] w-full text-2xl font-bold" placeholder="請輸入報名截止時間">
          </div>
          <div class="w-[24%] h-[68px] flex border-e-4 border-e-gray-500">
            <img :src="images.activity_presenter" alt="" class="w-[10%] pe-1">
            <input type="text" name="" id="" class="rounded-[5px] w-full text-2xl font-bold" placeholder="請輸入主講者">
          </div>
          <div class="w-[24%] h-[68px] flex border-e-4 border-e-gray-500">
            <img :src="images.activity_start_time" alt="" class="w-[10%] pe-1">
            <input type="text" name="" id="" class="rounded-[5px] w-full text-2xl font-bold" placeholder="請點選活動開始時間">
          </div>
          <div class="w-[24%] h-[68px] flex border-e-4 border-e-gray-500">
            <img :src="images.activity_end_time" alt="" class="w-[10%] pe-1">
            <input type="text" name="" id="" class="rounded-[5px] w-full text-2xl font-bold" placeholder="請點選活動開始時間">
          </div>
          <div class="w-[24%] h-[68px] flex border-e-4 border-e-gray-500">
            <img :src="images.activity_address" alt="" class="w-[10%] pe-1">
            <input type="text" name="" id="" class="rounded-[5px] w-full text-2xl font-bold" placeholder="請輸入活動地點">
          </div>
          <div class="w-full h-[56px] flex items-center bg-[#ffffff5a] rounded-[14px] px-2">
            <img :src="images.exclamation_triangle" alt="" class="w-[40px] h-[40px]">
            <input type="text" name="" id="" placeholder="請輸入參加須知" class="w-full">
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<style lang="scss" scoped>
#test {
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
  .activity-details {
  }

  .title {
    @apply text-[6.25rem] text-center;
  }

  .btn-base {
    @apply p-1.5 border-2 rounded-md border-green-500 cursor-pointer;
  }
}
</style>
