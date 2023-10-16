<!-- 講師創建活動的頁面 -->

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
import { router } from '@inertiajs/vue3';
import Swal from 'sweetalert2';

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
      prevButton: null,
      nextButton: null,
      formData: {
        activityName: '',
        activityInfo: '',
        activityType: '',
        activityPhoto: [],
        activityPresenter: '',
        activityLowestNumberOfPeople: '',
        activityHighestNumberOfPeople: '',
        activityStartRegistrationTime: '',
        activityEndRegistrationTime: '',
        activityStartTime: '',
        activityEndTime: '',
        activityAddress: '',
        activityInstruction: '',
        activityInformation: '',
      },
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
    this.prevButton = this.$refs.btnPrev;
    this.nextButton = this.$refs.btnNext;
  },
  methods: {
    submitData() {
      router.visit(route('activityStore'), {
        method: 'post',
        data: this.formData,
        preserveState: true,
        onSuccess: ({ props }) => {
          if (props.flash.message.rt_code === 1) {
            Swal.fire({
              title: '您成功創建了活動',
              showDenyButton: false,
              confirmButtonText: '回首頁',
            }).then((result) => {
              if (result.isConfirmed) {
                router.get(route('index'));
              }
            });
          }
        },
      });
    },
    information(data) {
      this.formData.activityInformation = data;
    },
    uploadOtherImage(event) {
      const reader = new FileReader();
      reader.readAsDataURL(event.target.files[0]);
      reader.onload = () => {
        this.formData.activityPhoto.push({
          id: Math.max(0, ...this.formData.activityPhoto.map(item => item.id)) + 1,
          activity_img_path: reader.result,
        });
      };
    },
    removeImage(id) {
      this.imageSize -= this.formData.activityPhoto.find((item) => item.id === id).size;
      this.formData.activityPhoto = this.formData.activityPhoto.filter((item) => item.id !== id);
    },
  },
};
</script>

<template>
  <section id="create-activity" class="flex flex-col overflow-hidden">
    <!-- 建立活動資訊填寫 -->
    <form @submit.prevent="submitData()" action="">
      <div class="relative mt-5 w-full h-[901px] bg-[#dac3c3] flex flex-col">
        <div class="relative z-10 w-full flex">
          <div class="absolute top-[80px] w-[175px] h-[41px] bg-white text-[20px] font-semibold flex justify-center items-center">
            <select v-model="formData.activityType" name="activity_type" class="ps-[30px] h-full text-[20px] border-none flex justify-center" required placeholder="活動分類">
              <option disabled selected value>- 請選擇活動類型 -</option>
              <option value="1">文化與藝術</option>
              <option value="2">學術與培訓</option>
              <option value="3">社交與社團</option>
              <option value="4">旅遊與戶外</option>
              <option value="5">健康與福祉</option>
              <option value="6">商業與職業發展</option>
              <option value="7">娛樂與文化慶典</option>
              <option value="8">科技與創新</option>
              <option value="9">其他</option>
            </select>
          </div>
          <div class="absolute left-[10%] top-[131px] w-[full] h-[219px] flex flex-col justify-between items-start gap-3">
            <div class="text-[72px] font-bold">
              <input v-model="formData.activityName" type="text" name="activity_name" class="border-none text-[72px] font-bold" required placeholder="請輸入活動名稱">
            </div>
            <div class="w-full bg-[#ffffff9b] text-[24px]">
              <input v-model="formData.activityInfo" type="text" name="activity_info" class="w-full border-none text-[24px] font-semibold" required placeholder="請輸入活動Slogan">
            </div>
            <label class="border border-dashed w-[136px] h-[56px] aspect-[4/3] bg-[#FFF] rounded-[8px] flex justify-center items-center text-[16px] text-[#072F54] font-semibold cursor-pointer">
              新增圖片
              <input type="file" class="hidden" required @change="(event) => uploadOtherImage(event)">
            </label>
            <div class="flex flex-nowrap gap-[30px]">
              <div v-for="item in formData.activityPhoto" :key="item.id" class="relative">
                <img :src="item.activity_img_path" alt="活動照片" class="border border-dashed w-[150px] aspect-[4/3] flex justify-center items-center text-[48px] cursor-pointer">
                <button type="button" class="absolute top-0 right-0 translate-x-1/2 -translate-y-1/2 rounded-full w-[20px] h-[20px] flex justify-center items-center bg-[red] text-white" @click="removeImage(item.id)">X</button>
              </div>
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
                <input v-model="formData.activityLowestNumberOfPeople" type="number" name="activity_lowest_number_of_people" class="rounded-[5px] w-full text-2xl font-bold" min="0" required placeholder="請輸入開課門檻">
              </div>
              <div class="flex-1 h-[68px] flex border-e-4 border-e-gray-500">
                <img :src="images.highestNumberOfPeople" alt="人數上限" class="w-[10%] pe-1">
                <input v-model="formData.activityHighestNumberOfPeople" type="number" name="activity_highest_number_of_people" class="rounded-[5px] w-full text-2xl font-bold" min="0" required placeholder="請輸入人數上限">
              </div>
              <div class="flex-1 h-[68px] flex border-e-4 border-e-gray-500">
                <img :src="images.registerTime" alt="報名開始時間" class="w-[10%] pe-1">
                <input v-model="formData.activityStartRegistrationTime" type="datetime-local" name="activity_start_registration_time" class="rounded-[5px] w-full text-2xl font-bold" required placeholder="開始報名 ex:2000-01-01 10:00">
              </div>
              <div class="flex-1 h-[68px] flex border-e-4 border-e-gray-500">
                <img :src="images.registerTime" alt="報名截止時間" class="w-[10%] pe-1">
                <input v-model="formData.activityEndRegistrationTime" type="datetime-local" name="activity_end_registration_time" class="rounded-[5px] w-full text-2xl font-bold" required placeholder="截止報名 ex:2000-01-01 10:00">
              </div>
            </div>
            <div class="flex flex-col gap-2 lg:gap-0 lg:flex-row">
              <div class="flex-1 h-[68px] flex border-e-4 border-e-gray-500">
                <img :src="images.activityPresenter" alt="主講者" class="w-[10%] pe-1">
                <input v-model="formData.activityPresenter" type="text" name="activity_presenter" class="rounded-[5px] w-full text-2xl font-bold" required placeholder="請輸入主講者">
              </div>
              <div class="flex-1 h-[68px] flex border-e-4 border-e-gray-500">
                <img :src="images.activityStartTime" alt="活動開始時間" class="w-[10%] pe-1">
                <input v-model="formData.activityStartTime" type="datetime-local" name="activity_start_time" class="rounded-[5px] w-full text-2xl font-bold" required placeholder="活動開始 ex:2000-01-01 10:00">
              </div>
              <div class="flex-1 h-[68px] flex border-e-4 border-e-gray-500">
                <img :src="images.activityEndTime" alt="活動結束時間" class="w-[10%] pe-1">
                <input v-model="formData.activityEndTime" type="datetime-local" name="activity_end_time" class="rounded-[5px] w-full text-2xl font-bold" required placeholder="活動結束 ex:2000-01-01 10:00">
              </div>
              <div class="flex-1 h-[68px] flex border-e-4 border-e-gray-500">
                <img :src="images.activityAddress" alt="活動地點" class="w-[10%] pe-1">
                <input v-model="formData.activityAddress" type="text" name="activity_address" class="rounded-[5px] w-full text-2xl font-bold" required placeholder="請輸入活動地點">
              </div>
            </div>
            <div class="flex-1 h-[56px] flex items-center bg-[#ffffff5a] rounded-[14px] px-2">
              <img :src="images.exclamationTriangle" alt="參加須知" class="w-[40px] h-[40px]">
              <input v-model="formData.activityInstruction" type="text" name="activity_instruction" required placeholder="請輸入參加須知" class="w-full">
            </div>
          </div>
        </div>
        <!-- Swiper引用 -->
        <Swiper v-slot="{ slide }" :slide-data="formData.activityPhoto" class="w-[full] max-w-[1600px] h-full max-h-[900px]" :btn-prev="prevButton" :btn-next="nextButton">
          <div class="opacity-60 w-full h-full flex justify-center items-center">
            <img :src="slide.activity_img_path" class="w-full h-full" alt="測試圖片">
          </div>
        </Swiper>
      </div>
      <Editor class="mt-[200px] lg:mt-0 w-full h-[500px]" @update-content="information"></Editor>
      <div class="flex w-full justify-center gap-[45px] py-5">
        <Link :href="route('index')" class="px-[30px] py-[15px] bg-[#690926] rounded-[5px] flex justify-center items-center text-white">取消開課</Link>
        <button type="submit" class="px-[30px] py-[15px] bg-[#095269] rounded-[5px] flex justify-center items-center text-white">確認開課</button>
      </div>
    </form>
    <Link class="fixed right-[2.5%] bottom-[2.5%] text-gray-900 bg-gradient-to-r from-red-200 via-red-300 to-yellow-200 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-red-100 dark:focus:ring-red-400 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">回到頁首</Link>
  </section>
</template>

<style lang="scss" scoped>
#create-activity {
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

  .title {
    @apply text-[6.25rem] text-center;
  }

  .btn-base {
    @apply p-1.5 border-2 rounded-md border-green-500 cursor-pointer;
  }
</style>
