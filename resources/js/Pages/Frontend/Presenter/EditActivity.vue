<!-- 講師修改活動的頁面 -->

<script>
import CountDown from '@/Components/Public/CountDown.vue';

export default {
  components: { CountDown },
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
      formData: {
        activityName: this.response?.rt_data?.activityName ?? '',
        activityInfo: this.response?.rt_data?.activityInfo ?? '',
        activityType: this.response?.rt_data?.activityType ?? '',
        activityPresenter: this.response?.rt_data?.activityPresenter ?? '',
        activityLowestNumberOfPeople: this.response?.rt_data?.activityLowestNumberOfPeople ?? '',
        activityHighestNumberOfPeople: this.response?.rt_data?.activityHighestNumberOfPeople ?? '',
        activityStartRegistrationTime: this.response?.rt_data?.activityStartRegistrationTime ?? '',
        activityEndRegistrationTime: this.response?.rt_data?.activityEndRegistrationTime ?? '',
        activityStartTime: this.response?.rt_data?.activityStartTime ?? '',
        activityEndTime: this.response?.rt_data?.activityEndTime ?? '',
        activityAddress: this.response?.rt_data?.activityAddress ?? '',
        activityInstruction: this.response?.rt_data?.activityInstruction ?? '',
        activityInformation: this.response?.rt_data?.activityInformation ?? '',
      },
    };
  },
  methods: {
    information(data) {
      console.log(data);
      this.formData.activityInformation = data;
    },
  },
};
</script>

<template>
  <section id="create-activity" class="relative flex flex-col">
    <!-- 建立活動資訊填寫 -->
    <CountDown class="absolute mt-[5%] left-[75%]"></CountDown>
    <!-- <ActivityDetailSwiper>
    </ActivityDetailSwiper> -->
    <!-- 編輯工具列；所見即所得區 -->
    <Editor @update-content="information"></Editor>
    <div class="flex w-full justify-end gap-[45px] px-20 py-5">
      <div class="pe-[35%] flex gap-5">
        <button type="button" class="px-[30px] py-[15px] bg-[#690926] rounded-[5px] flex justify-center items-center text-white">取消修改</button>
        <button type="button" class="px-[30px] py-[15px] bg-[#095269] rounded-[5px] flex justify-center items-center text-white">確認修改</button>
      </div>
      <button type="button" class="px-[30px] py-[15px] bg-[#690926b9] rounded-[5px] flex justify-center items-center text-white">刪除活動</button>
    </div>
  </section>
</template>

<style lang="scss" scoped>
#create-activity {
    @apply w-full h-full overflow-y-auto overflow-x-hidden;
  }

  .title {
    @apply text-[6.25rem] text-center;
  }

  .btn-base {
    @apply p-1.5 border-2 rounded-md border-green-500 cursor-pointer;
  }
</style>
