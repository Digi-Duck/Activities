<!-- 學員已完成活動頁面 -->

<script>
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
      qrCodeVisible: true,
    };
  },
  computed: {
    activityData() {
      return this.rtData.activity ?? {};
    },
    activityTypeData() {
      return this.rtData.activityTypeData ?? [];
    },
    registerData() {
      return this.rtData.registerData ?? [];
    },
  },
  methods: {
    getActivityType(type) {
      const activityTypes = {
        1: '文化與藝術',
        2: '學術與培訓',
        3: '社交與社團',
        4: '旅遊與戶外',
        5: '健康與福祉',
        6: '商業與職業發展',
        7: '娛樂與文化慶典',
        8: '科技與創新',
      };
      return activityTypes[type] || '其他';
    },
    toggleQRCodeVisibility() {
      this.qrCodeVisible = !this.qrCodeVisible;
    },
  },
};
</script>

<template>
  <img v-if="qrCodeVisible" :src="rtData.qrcode.qrcode_path" class="absolute right-[300px] top-[30%] md:top-[25%] z-[100] h-[250px] w-[250px]" alt="QRcode圖片">
  <button @click="toggleQRCodeVisibility" type="button" class="absolute top-[175px] md:top-[215px] left-[40px] z-50 w-[140px] h-[40px] rounded-[15px] bg-[#fff] text-[20px] font-semibold flex justify-center items-center">
    {{ qrCodeVisible ? '隱藏QRcode' : '顯示QRcode' }}
  </button>
  <section id="presenter-finished-activity" class="relative flex flex-col justify-between items-center gap-5">
    <!-- 這是QRcode的位置 -->
    <ActivityDetailSwiper :slide-data="[activityData]">
      <template #activity_type>
        <span>{{ getActivityType(activityData.activity_type) }}</span>
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
          {{ activityData.activity_lowest_number_of_people.toLocaleString() }}
        </span>
      </template>
      <template #activity_highest_number_of_people>
        <span>
          {{ activityData.activity_highest_number_of_people.toLocaleString() }}
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
    <div class="mt-[200px] lg:mt-0 w-full p-[100px] bg-[#d7a5a565]">
      <div v-html="activityData.activity_information"></div>
    </div>
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
