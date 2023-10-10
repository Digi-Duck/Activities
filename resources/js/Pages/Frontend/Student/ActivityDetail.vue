<!-- 學員活動報名頁面 -->
<script>
import { router } from '@inertiajs/vue3';
import Swal from 'sweetalert2';
import QRCode from 'qrcode';

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
      rtData: this.response?.rt_data ?? {},
      formData: {
        studentName: '',
        studentPhoneNumber: '',
        studentEmail: '',
        studentAdditionalRemark: '',
      },
      activityType: {
        favorited: 1,
        registered: 2,
      },
      qrcodeNumber: '',
      qrcodeImage: '',
    };
  },
  computed: {
    // 獲取活動資料陣列
    activityData() {
      return this.rtData.activity ?? {};
    },
    // 獲取活動類別資料陣列
    activityTypeData() {
      return this.rtData.activityTypeData ?? [];
    },
    // 確認是否已收藏
    favoriteCheck() {
      return this.rtData.favoriteCheck ?? 0;
    },
  },
  methods: {
    favorite() {
      router.visit(route('createFavorite'), {
        method: 'post',
        data: { ...this.rtData, activity_id: this.response.rt_data.activity.id, ...this.activityType },
        onSuccess: ({ props }) => {
          if (props.flash.message.rt_code === 1) {
            Swal.fire({
              title: '收藏成功',
              showDenyButton: false,
              confirmButtonText: '回列表',
            }).then((result) => {
              if (result.isConfirmed) {
                router.get(route('studentActivityDetails', { id: this.response.rt_data.activity.id }));
              }
            });
          }
        },
      });
    },
    cancelFavorite() {
      router.visit(route('cancelFavorite'), {
        method: 'delete',
        data: { activity_id: this.response.rt_data.activity.id, ...this.activityType },
        onSuccess: ({ props }) => {
          if (props.flash.message.rt_code === 1) {
            Swal.fire({
              title: '取消成功',
              showDenyButton: false,
              confirmButtonText: '回列表',
            }).then((result) => {
              if (result.isConfirmed) {
                router.get(route('studentActivityDetails', { id: this.response.rt_data.activity.id }));
              }
            });
          }
        },
      });
    },
    generateRandomString() {
      const charset = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
      let qrcodeNumber = '';
      for (let i = 0; i < 20; i++) {
        const randomIndex = Math.floor(Math.random() * charset.length);
        qrcodeNumber += charset.charAt(randomIndex);
      }
      // let row_password = Array(10).fill('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz').map(function (x) { return x[Math.floor(Math.random() * x.length)]; }).join('');
      this.qrcodeNumber = qrcodeNumber;
    },
    generateQRCode() {
      this.generateRandomString();
      const qrCodeContent = this.qrcodeNumber.toString();
      QRCode.toDataURL(qrCodeContent, (err, url) => {
        if (err) {
          console.error(err);
        } else {
          this.qrcodeImage = url;
        }
      });
    },
    submitData() {
      const { generateQRCode, formData, activityType, response } = this;
      generateQRCode();
      const data = {
        ...formData,
        ...activityType,
        activity_id: response.rt_data.activity.id,
        qrcodeNumber: this.qrcodeNumber,
        qrcodeImage: this.qrcodeImage,
      };
      router.visit(route('registerStore'), {
        method: 'post',
        data,
        preserveState: true,
        onSuccess: ({ props }) => {
          if (props.flash.message.rt_code === 1) {
            Swal.fire({
              title: '報名成功',
              showDenyButton: false,
              confirmButtonText: '回列表',
            }).then((result) => {
              if (result.isConfirmed) {
                router.get(route('index'));
              }
            });
          }
        },
      });
    },
  },
};
</script>

<template>
  <section id="presenter-finished-activity" class="flex flex-col justify-between items-center gap-5">
    <div class="absolute mt-[5%] left-[75%] z-50">
      <div v-if="rtData.timeDifferenceInDays > 0" class="z-50 w-[200px] p-3 bg-[#FFDD55] rounded-[5px] flex flex-col text-[48px] font-extrabold">倒數
        <div class="ps-5 flex flex-row">
          <span>{{ rtData.timeDifferenceInDays }}天！</span>
        </div>
      </div>
      <div v-else-if="rtData.timeDifferenceInDays === 0" class="z-50 w-[200px] p-3 bg-[#FFDD55] rounded-[5px] flex flex-col text-[48px] font-extrabold">就是
        <div class="ps-5 flex flex-row">
          <span>今天！</span>
        </div>
      </div>
      <div v-else>
      </div>
    </div>
    <button v-if="favoriteCheck === 0" @click="favorite()" type="button" class="absolute mt-[2.5%] left-[77.5%] z-50 w-[140px] h-[40px] rounded-[15px] bg-[#fff] text-[20px] font-semibold flex justify-center items-center">
      點我收藏
    </button>
    <button v-else @click="cancelFavorite()" type="button" class="absolute mt-[2.5%] left-[77.5%] z-50 w-[140px] h-[40px] rounded-[15px] bg-[#fff] text-[20px] font-semibold flex justify-center items-center">
      取消收藏
    </button>
    <ActivityDetailSwiper :slide-data="[activityData]">
      <template #activity_type>
        <span v-if="activityData.activity_type === 1">
          文化與藝術
        </span>
        <span v-else-if="activityData.activity_type === 2">
          學術與培訓
        </span>
        <span v-else-if="activityData.activity_type === 3">
          社交與社團
        </span>
        <span v-else-if="activityData.activity_type === 4">
          旅遊與戶外
        </span>
        <span v-else-if="activityData.activity_type === 5">
          健康與福祉
        </span>
        <span v-else-if="activityData.activity_type === 6">
          商業與職業發展
        </span>
        <span v-else-if="activityData.activity_type === 7">
          娛樂與文化慶典
        </span>
        <span v-else-if="activityData.activity_type === 8">
          科技與創新
        </span>
        <span v-else>
          其他
        </span>
      </template>
      <template #activity_name>
        <span>
          {{ activityData.activity_name }}
        </span>
      </template>
      <template #activity_info>
        <span>
          {{ activityData.activity_info }}
        </span>
      </template>
      <template #activity_lowest_number_of_people>
        <span>
          {{ activityData.activity_lowest_number_of_people }}
        </span>
      </template>
      <template #activity_highest_number_of_people>
        <span>
          {{ activityData.activity_highest_number_of_people }}
        </span>
      </template>
      <template #activity_start_registration_time>
        <span>
          {{ activityData.activity_start_registration_time }}
        </span>
      </template>
      <template #activity_end_registration_time>
        <span>
          {{ activityData.activity_end_registration_time }}
        </span>
      </template>
      <template #activity_presenter>
        <span>
          {{ activityData.activity_presenter }}
        </span>
      </template>
      <template #activity_start_time>
        <span>
          {{ activityData.activity_start_time }}
        </span>
      </template>
      <template #activity_end_time>
        <span>
          {{ activityData.activity_end_time }}
        </span>
      </template>
      <template #activity_address>
        <span>
          {{ activityData.activity_address }}
        </span>
      </template>
      <template #activity_instruction>
        <span>
          {{ activityData.activity_instruction }}
        </span>
      </template>
      <template #registerPeople>
        <span class="ps-[10px] text-[72px]">
          {{ rtData.registerPeople }}
        </span>
      </template>
    </ActivityDetailSwiper>
    <!-- 這裡是活動詳情 -->
    <div class="w-full h-[811px] p-[100px] bg-[#d7a5a565]">
      <div v-html="activityData.activity_information"></div>
    </div>
    <!-- 學員活動資訊填寫區 -->
    <form @submit.prevent="submitData()" action="" class="w-full h-[700px] px-10 py-5 bg-[#A9BCC6] flex flex-col gap-3 text-[24px]">
      <!-- 填入會員預設資料 -->
      <div class="w-full h-[30px] flex justify-end items-center gap-3">
        <div class="w-[274px] h-full bg-white flex justify-center items-center">代入會員資料</div>
        <input type="checkbox" class="w-[25px] h-[25px] rounded-full" name="" id="">
      </div>
      <!-- 填入活動報名資訊 -->
      <div class="w-full h-[30px] flex gap-[150px]">
        <div class="w-[274px] h-full bg-white flex justify-center items-center">姓名</div>
        <slot name="studentName">
          <input v-model="formData.studentName" type="text" class="w-full" name="" id="">
        </slot>
      </div>
      <div class="w-full h-[30px] flex gap-[150px]">
        <div class="w-[274px] h-full bg-white flex justify-center items-center">連絡電話</div>
        <slot name="studentPhoneNumber">
          <input v-model="formData.studentPhoneNumber" type="tel" class="w-full" name="" id="">
        </slot>
      </div>
      <div class="w-full h-[30px] flex gap-[150px]">
        <div class="w-[274px] h-full bg-white flex justify-center items-center">電子信箱</div>
        <slot name="studentEmail">
          <input v-model="formData.studentEmail" type="email" class="w-full" name="" id="">
        </slot>
      </div>
      <!-- 額外備註的地方 -->
      <div class="w-full h-[300px] flex flex-col justify-start gap-[25px]">
        <div class="w-[217.5px] h-[50px] bg-white flex justify-center items-center">額外備註</div>
        <slot name="studentAdditionalRemark">
          <textarea v-model="formData.studentAdditionalRemark" name="" id="" class="w-full h-full" cols="30" rows="10" resize="false"></textarea>
        </slot>
      </div>
      <div class="w-full h-[30px] flex gap-[150px]">
        <div class="w-[274px] h-full bg-white flex justify-center items-center">確認事項</div>
        <input type="text" class="w-full" name="" id="" :placeholder="activityData.activity_instruction">
      </div>
      <div class="pt-10 w-full flex justify-center gap-5 text-[24px]">
        <button type="button" class="w-[228px] h-[40px] bg-[#1C8AAD] rounded-[5px]">回上一頁</button>
        <button type="submit" class="w-[228px] h-[40px] bg-[#1C8AAD] rounded-[5px]">確認報名</button>
      </div>
    </form>
  </section>
</template>

<style lang="scss" scoped>
#presenter-finished-activity {
  @apply w-full h-full overflow-y-auto;

  .title {
    @apply text-[6.25rem] text-center;
  }

  .btn-base {
    @apply p-1.5 border-2 rounded-md border-green-500 cursor-pointer;
  }
}
</style>
