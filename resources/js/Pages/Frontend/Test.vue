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
      title: 'Hello World !',
    };
  },
  created() {
  },
};
</script>

<template>
  <section id="userInfo" class="w-[full] p-[100px] bg-[#ebd8d8] flex flex-col justify-center items-center">
    <div class="w-[35%] p-10 border-[3px] flex flex-col gap-3">

      <div class="ms-[calc(50%-50px)] w-[100px] h-[100px] bg-[yellow] rounded-full">
        照片
      </div>
      <div class="mt-4">
        <InputLabel for="user_role" value="帳號/Email" />

        <div class="mt-1 ps-[15px] w-full h-[40px] border rounded-[5px] shadow-sm shadow-slate-50 bg-[#838E94] text-white flex items-center">123</div>

        <!-- <InputError class="mt-2" :message="form.errors.email" /> -->
      </div>
      <div>
        <InputLabel for="name" value="暱稱" />

        <div class="mt-1 ps-[15px] w-full h-[40px] border rounded-[5px] shadow-sm shadow-slate-50 bg-[#838E94] text-white flex items-center">123</div>

        <!-- <InputError class="mt-2" :message="form.errors.name" /> -->
      </div>
      <div class="mt-4">
        <InputLabel for="user_role" value="身分狀態" />

        <div class="mt-1 ps-[15px] w-full h-[40px] border rounded-[5px] shadow-sm shadow-slate-50 bg-[#838E94] text-white flex items-center">123</div>

        <!-- <InputError class="mt-2" :message="form.errors.email" /> -->
      </div>

      <div class="mt-4">
        <InputLabel for="password" value="密碼" />

        <TextInput
          id="password"
          type="password"
          class="mt-1 block w-full"
          required
          autocomplete="new-password"
          placeholder="密碼"
        />

        <!-- <InputError class="mt-2" :message="form.errors.password" /> -->
      </div>

      <div class="mt-4">
        <InputLabel for="password_confirmation" value="確認密碼" />

        <TextInput
          id="password_confirmation"
          type="password"
          class="mt-1 block w-full"
          required
          autocomplete="new-password"
          placeholder="確認密碼"
        />

      </div>

      <div class="flex flex-col items-center justify-end mt-4 gap-[25px]">

        <PrimaryButton class="w-full h-[50px] bg-[#194F69] text-[37px] flex justify-center items-center">
          完成
        </PrimaryButton>
      </div></div>
  </section>
</template>

<style lang="scss" scoped>
#userInfo {
  @apply w-full h-full overflow-y-auto;

  .title {
    @apply text-[6.25rem] text-center;
  }

  .btn-base {
    @apply p-1.5 border-2 rounded-md border-green-500 cursor-pointer;
  }
}
</style>
