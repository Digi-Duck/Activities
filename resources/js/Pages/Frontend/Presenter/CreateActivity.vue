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
      title: 'Hello World !',
      prevButton: null, // 在这里定义 prevButton 和 nextButton
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
    // 通过类名或其他方式获取按钮元素并赋值给 prevButton 和 nextButton
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
              title: '新增成功',
              showDenyButton: true,
              confirmButtonText: '回列表',
              denyButtonText: '取消',
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
      console.log(data);
      this.formData.activityInformation = data;
    },
    uploadOtherImage(event) {
      const reader = new FileReader();
      reader.readAsDataURL(event.target.files[0]);
      reader.onload = () => {
        this.formData.activityPhoto.push({
          // id: this.formData.activityPhoto.length + 1,
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
  <section id="create-activity" class="flex flex-col">
    <!-- 建立活動資訊填寫 -->
    <form @submit.prevent="submitData()" action="">
      <div class="relative mt-5 h-[901px] bg-[#dac3c3] flex flex-col">
        <div class="relative w-full z-10">
          <div class="absolute top-[80px] w-[175px] h-[41px] bg-white text-[20px] font-semibold flex justify-center items-center">
            <select v-model="formData.activityType" name="activity_type" class="h-full text-[10px] border-none flex justify-center" required placeholder="活動分類">
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
            <div id="triangle" class="absolute left-[175px] -top-[0px] w-[10px] h-[10px] border-s">
              <div id="triangle-top"></div>
              <div id="triangle-bottom"></div>
            </div>
          </div>
          <div class="absolute left-[265px] top-[131px] w-[288px] h-[219px] flex flex-col justify-between items-start gap-3">
            <div class="text-[72px] font-bold">
              <input v-model="formData.activityName" type="text" name="activity_name" id="" class="border-none text-[72px] font-bold" required placeholder="請輸入活動名稱">
            </div>
            <div class="w-[100%] bg-[#ffffff9b] text-[24px]">
              <input v-model="formData.activityInfo" type="text" name="activity_info" id="" class="border-none text-[24px] font-semibold" required placeholder="請輸入活動Slogan">
            </div>
            <label class="border border-dashed w-[136px] h-[56px] aspect-[4/3] bg-[#FFF] rounded-[8px] flex justify-center items-center text-[16px] text-[#072F54] cursor-pointer">
              新增圖片
              <input type="file" class="hidden" name="" id="" @change="(event) => uploadOtherImage(event)">
            </label>
            <div class="flex flex-nowrap gap-[30px]">
              <div v-for="item in formData.activityPhoto" :key="item.id" class="relative">
                <img :src="item.activity_img_path" alt="" class="border border-dashed w-[150px] aspect-[4/3] flex justify-center items-center text-[48px] cursor-pointer">
                <button type="button" class="absolute top-0 right-0 translate-x-1/2 -translate-y-1/2 rounded-full w-[20px] h-[20px] flex justify-center items-center bg-[red] text-white" @click="removeImage(item.id)">X</button>
              </div>
            </div>
            <!-- 測試上傳多圖完 -->
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
          <div class="absolute left-[100px] top-[495px] w-[90%] h-[289px] pt-[15px] px-[60px] rounded-[14px] bg-[#f2f2f2b2] flex flex-wrap gap-5">
            <div class="w-[24%] h-[68px] flex border-e-4 border-e-gray-500">
              <img :src="images.lowestNumberOfPeople" alt="開課門檻" class="w-[10%] pe-1">
              <input v-model="formData.activityLowestNumberOfPeople" type="number" name="activity_lowest_number_of_people" id="" class="rounded-[5px] w-full text-2xl font-bold" min="0" required placeholder="請輸入開課門檻">
            </div>
            <div class="w-[24%] h-[68px] flex border-e-4 border-e-gray-500">
              <img :src="images.highestNumberOfPeople" alt="人數上限" class="w-[10%] pe-1">
              <input v-model="formData.activityHighestNumberOfPeople" type="number" name="activity_highest_number_of_people" id="" class="rounded-[5px] w-full text-2xl font-bold" min="0" required placeholder="請輸入人數上限">
            </div>
            <div class="w-[24%] h-[68px] flex border-e-4 border-e-gray-500">
              <img :src="images.registerTime" alt="報名開始時間" class="w-[10%] pe-1">
              <input v-model="formData.activityStartRegistrationTime" type="datetime" name="activity_start_registration_time" id="" class="rounded-[5px] w-full text-2xl font-bold" required placeholder="請輸入報名開始時間">
            </div>
            <div class="w-[24%] h-[68px] flex border-e-4 border-e-gray-500">
              <img :src="images.registerTime" alt="報名截止時間" class="w-[10%] pe-1">
              <input v-model="formData.activityEndRegistrationTime" type="datetime" name="activity_end_registration_time" id="" class="rounded-[5px] w-full text-2xl font-bold" required placeholder="請輸入報名截止時間">
            </div>
            <div class="w-[24%] h-[68px] flex border-e-4 border-e-gray-500">
              <img :src="images.activityPresenter" alt="主講者" class="w-[10%] pe-1">
              <input v-model="formData.activityPresenter" type="text" name="activity_presenter" id="" class="rounded-[5px] w-full text-2xl font-bold" required placeholder="請輸入主講者">
            </div>
            <div class="w-[24%] h-[68px] flex border-e-4 border-e-gray-500">
              <img :src="images.activityStartTime" alt="活動開始時間" class="w-[10%] pe-1">
              <input v-model="formData.activityStartTime" type="datetime" name="activity_start_time" id="" class="rounded-[5px] w-full text-2xl font-bold" required placeholder="請點選活動開始時間">
            </div>
            <div class="w-[24%] h-[68px] flex border-e-4 border-e-gray-500">
              <img :src="images.activityEndTime" alt="活動結束時間" class="w-[10%] pe-1">
              <input v-model="formData.activityEndTime" type="datetime" name="activity_end_time" id="" class="rounded-[5px] w-full text-2xl font-bold" required placeholder="請點選活動結束時間">
            </div>
            <div class="w-[24%] h-[68px] flex border-e-4 border-e-gray-500">
              <img :src="images.activityAddress" alt="活動地點" class="w-[10%] pe-1">
              <input v-model="formData.activityAddress" type="text" name="activity_address" id="" class="rounded-[5px] w-full text-2xl font-bold" required placeholder="請輸入活動地點">
            </div>
            <div class="w-full h-[56px] flex items-center bg-[#ffffff5a] rounded-[14px] px-2">
              <img :src="images.exclamationTriangle" alt="參加須知" class="w-[40px] h-[40px]">
              <input v-model="formData.activityInstruction" type="text" name="activity_instruction" id="" required placeholder="請輸入參加須知" class="w-full">
            </div>
          </div>
        </div>
        <!-- Swiper引用 -->
        <Swiper v-slot="{ slide }" :slide-data="formData.activityPhoto" class="w-[full] max-w-[1600px] h-[1000px]" :btn-prev="prevButton" :btn-next="nextButton">
          <div class="opacity-60 w-full flex justify-center items-center">
            <img :src="slide.activity_img_path" class="w-full h-full" alt="測試圖片">
          </div>
        </Swiper>
      </div>
      <!-- 編輯工具列；所見即所得區 -->
      <Editor class="h-[500px]" @update-content="information"></Editor>
      <!-- <editor v-model="editorValue" :init="editorInit" class="min-h-[500px]" @update-content="test" /> -->
      <div class="flex w-full justify-center gap-[45px] py-5">
        <Link :href="route('index')" class="px-[30px] py-[15px] bg-[#690926] rounded-[5px] flex justify-center items-center text-white">取消開課</Link>
        <button type="submit" class="px-[30px] py-[15px] bg-[#095269] rounded-[5px] flex justify-center items-center text-white">確認開課</button>
      </div>
    </form>
  </section>
</template>

<style lang="scss" scoped>
#create-activity {
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
  }

  .title {
    @apply text-[6.25rem] text-center;
  }

  .btn-base {
    @apply p-1.5 border-2 rounded-md border-green-500 cursor-pointer;
  }
</style>
