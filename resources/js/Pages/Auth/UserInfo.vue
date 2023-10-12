<script setup>
import { useForm } from '@inertiajs/vue3';

const form = useForm({
  name: '',
  email: '',
  user_role: '',
  password: '',
  password_confirmation: '',
});

// const submit = () => {
//   form.post(route('register'), {
//     onFinish: () => form.reset('password', 'password_confirmation'),
//   });
// };
</script>

<template>
  <div class="w-[full] p-[100px] bg-[#ebd8d8] flex flex-col justify-center items-center">
    <div class="w-[35%] p-10 border-[3px] bg-[#FEFFFE] flex flex-col gap-3">

      <div class="ms-[calc(50%-50px)] w-[100px] h-[100px] bg-[yellow] rounded-full">
        照片
      </div>

      <div class="mt-4">
        <InputLabel for="user_role" value="帳號/Email" />

        <div class="mt-1 ps-[15px] w-full h-[40px] border rounded-[5px] shadow-sm shadow-slate-50 bg-[#FFFFFF] flex items-center">123</div>

        <InputError class="mt-2" :message="form.errors.email" />
      </div>
      <div class="mt-4">
        <InputLabel for="user_role" value="暱稱" />

        <div class="mt-1 ps-[15px] w-full h-[40px] border rounded-[5px] shadow-sm shadow-slate-50 bg-[#FFFFFF] flex items-center">123</div>

        <InputError class="mt-2" :message="form.errors.email" />
      </div>
      <div class="mt-4">
        <InputLabel for="user_role" value="密碼" />

        <div class="mt-1 ps-[15px] w-full h-[40px] border rounded-[5px] shadow-sm shadow-slate-50 bg-[#FFFFFF] flex items-center">123</div>

        <InputError class="mt-2" :message="form.errors.email" />
      </div>
      <div class="mt-4">
        <InputLabel for="user_role" value="角色選擇" />

        <div class="mt-1 ps-[15px] w-full h-[40px] border rounded-[5px] shadow-sm shadow-slate-50 bg-[#FFFFFF] flex items-center">123</div>

        <InputError class="mt-2" :message="form.errors.email" />
      </div>

      <div class="flex flex-col items-center justify-end mt-4 gap-[25px]">

        <PrimaryButton class="w-full h-[50px] bg-[#194F69] text-[37px] flex justify-center items-center" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
          完成
        </PrimaryButton>
      </div>
    </div>
  </div>
</template>

<style lang="scss" scoped>

</style>
