<!-- 學員編輯活動報名資訊頁面 -->
<script>
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
      rtData: this.response?.rt_data ?? {},
      formData: {
        studentName: this.response?.rt_data?.registerData.student_name ?? '',
        studentPhoneNumber: this.response?.rt_data?.registerData.student_phone_number ?? '',
        studentEmail: this.response?.rt_data?.registerData.student_email ?? '',
        studentAdditionalRemark: this.response?.rt_data?.registerData.student_additional_remark ?? '',
      },
      activityType: {
        favorited: 1,
        registered: 2,
      },
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
    // 獲取學員報名資料陣列
    registerData() {
      return this.rtData.registerData ?? [];
    },
  },
  methods: {
    submitData() {
      Swal.fire({
        title: `確認更新: ${this.response.rt_data.activity.activity_name ?? ''}報名資訊?`,
        showDenyButton: true,
        confirmButtonText: '更新',
        denyButtonText: '取消',
      }).then((result) => {
        if (result.isConfirmed) {
          router.visit(route('registerUpdate'), {
            method: 'put',
            data: { ...this.formData, activity_id: this.response.rt_data.activity.id, ...this.activityType },
            preserveState: true,
            onSuccess: ({ props }) => {
              if (props.flash.message.rt_code === 1) {
                Swal.fire({
                  title: '更新成功',
                  showDenyButton: true,
                  confirmButtonText: '回列表',
                  denyButtonText: '取消',
                }).then((result) => {
                  if (result.isConfirmed) {
                    router.get(route('studentActivityEdit', { id: response.rt_data.activity.id }));
                  }
                });
              }
            },
          });
        }
      });
    },
    deleteRegister(id) {
      Swal.fire({
        title: `確認取消:  ${this.rtData.activity.activity_name ?? ''} 的報名 ?`,
        showDenyButton: true,
        confirmButtonText: '確定',
        denyButtonText: '取消',
      }).then((result) => {
        if (result.isConfirmed) {
          router.visit(route('registerDelete'), { method: 'delete', data: { id: id } });
        }
      });
    },
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
                router.get(route('studentActivityEdit', { id: this.response.rt_data.activity.id }));
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
                router.get(route('studentActivityEdit', { id: this.response.rt_data.activity.id }));
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
    <CountDown class="absolute mt-[5%] left-[75%] z-50">
      <template #count-down>
        <span>
          20
        </span>
      </template>
    </CountDown>
    <button v-if="!rtData.favoriteCheck" @click="favorite()" type="button" class="absolute mt-[2.5%] left-[77.5%] z-50 w-[140px] h-[40px] rounded-[15px] bg-[#fff] text-[20px] font-semibold flex justify-center items-center">
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
        <input v-model="formData.student_name" type="checkbox" class="w-[25px] h-[25px] rounded-full" name="" id="">
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
      <div class="flex w-full justify-center gap-[45px] px-20 py-5">
        <div class="pe-[35%] flex gap-5">
          <Link :href="route('studentPersonalPage')" class="w-[228px] h-[40px] bg-[#1C8AAD] rounded-[5px] flex justify-center items-center">回個人頁</Link>
          <button type="submit" class="w-[228px] h-[40px] bg-[#edc431] rounded-[5px]">更新資訊</button>
        </div>
        <button type="button" class="px-[30px] py-[15px] bg-[#690926b9] rounded-[5px] flex justify-center items-center text-white" @click="deleteRegister(rtData.registerData.id)">取消報名</button>
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
