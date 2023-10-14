<script>
export default {
  props: {
    response: {
      type: Object,
      required: false,
      default: () => ({}),
    },
    name: String,
    phone: String,
    email: String,
  },
  data() {
    return {
      title: 'Hello World !',
    };
  },
  created() {
  },
};
</script>

<template>
  <section id="activity-enroll">
    <div class="w-full h-[819px] px-10 py-5 bg-[#A9BCC6] flex flex-col gap-3 text-[24px]">
      <!-- 填入會員預設資料 -->
      <div class="w-full h-[30px] flex justify-end items-center gap-3">
        <div class="w-[274px] h-full bg-white flex justify-center items-center">代入會員資料</div>
        <input type="checkbox" class="w-[25px] h-[25px] rounded-full" name="">
      </div>
      <!-- 填入活動報名資訊 -->
      <div class="w-full h-[30px] flex gap-[150px]">
        <div class="w-[274px] h-full bg-white flex justify-center items-center">姓名</div>
        <slot name="student_name">
          <input type="text" class="w-full" name="">
        </slot>
      </div>
      <div class="w-full h-[30px] flex gap-[150px]">
        <div class="w-[274px] h-full bg-white flex justify-center items-center">連絡電話</div>
        <slot name="student_phone_number">
          <input type="tel" class="w-full" name="">
        </slot>
      </div>
      <div class="w-full h-[30px] flex gap-[150px]">
        <div class="w-[274px] h-full bg-white flex justify-center items-center">電子信箱</div>
        <slot name="student_email">
          <input type="email" class="w-full" name="">
        </slot>
      </div>
      <!-- 額外備註的地方 -->
      <div class="w-full h-[300px] flex flex-col justify-start gap-[25px]">
        <div class="w-[217.5px] h-[50px] bg-white flex justify-center items-center">額外備註</div>
        <slot name="student_additional_remark">
          <textarea name="" class="w-full h-full" cols="30" rows="10" resize="false"></textarea>
        </slot>
      </div>
      <div class="w-full h-[30px] flex gap-[150px]">
        <div class="w-[274px] h-full bg-white flex justify-center items-center">確認事項</div>
        <input type="email" class="w-full" name="">
      </div>
      <div class="pt-10 w-full flex justify-center gap-5 text-[24px]">
        <button type="button" class="w-[228px] h-[40px] bg-[#1C8AAD] rounded-[5px]">回上一頁</button>
        <button type="button" class="w-[228px] h-[40px] bg-[#1C8AAD] rounded-[5px]">確認報名</button>
      </div>
    </div>
  </section>
</template>

<style lang="scss" scoped>
#activity-enroll {
  @apply w-full h-full overflow-y-auto;

  .title {
    @apply text-[6.25rem] text-center;
  }

  .btn-base {
    @apply p-1.5 border-2 rounded-md border-green-500 cursor-pointer;
  }
}
</style>
