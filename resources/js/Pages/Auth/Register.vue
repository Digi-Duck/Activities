<script setup>
import { useForm } from '@inertiajs/vue3';

const form = useForm({
  name: '',
  email: '',
  user_role: '',
  password: '',
  password_confirmation: '',
});

const submit = () => {
  form.post(route('register'), {
    onFinish: () => form.reset('password', 'password_confirmation'),
  });
};
</script>

<template>
  <div class="w-[full] p-[100px] bg-[#ebd8d8] flex flex-col justify-center items-center">
    <form @submit.prevent="submit" class="w-[35%] p-10 border-[3px] flex flex-col gap-3">

      <div class="ms-[calc(50%-50px)] w-[100px] h-[100px] bg-[yellow] rounded-full">
        照片
      </div>
      <div class="mt-4">
        <InputLabel for="email" value="帳號/Email" />

        <TextInput
          id="email"
          type="email"
          class="mt-1 block w-full"
          v-model="form.email"
          required
          autocomplete="username"
          placeholder="帳號/Email"
        />

        <InputError class="mt-2" :message="form.errors.email" />
      </div>
      <div>
        <InputLabel for="name" value="暱稱" />

        <TextInput
          id="name"
          type="text"
          class="mt-1 block w-full"
          v-model="form.name"
          required
          autofocus
          autocomplete="name"
          placeholder="暱稱"
        />

        <InputError class="mt-2" :message="form.errors.name" />
      </div>

      <div class="mt-4">
        <InputLabel for="password" value="密碼" />

        <TextInput
          id="password"
          type="password"
          class="mt-1 block w-full"
          v-model="form.password"
          required
          autocomplete="new-password"
          placeholder="密碼"
        />

        <InputError class="mt-2" :message="form.errors.password" />
      </div>

      <div class="mt-4">
        <InputLabel for="password_confirmation" value="確認密碼" />

        <TextInput
          id="password_confirmation"
          type="password"
          class="mt-1 block w-full"
          v-model="form.password_confirmation"
          required
          autocomplete="new-password"
          placeholder="確認密碼"
        />

        <InputError class="mt-2" :message="form.errors.password_confirmation" />
      </div>
      <div class="mt-4">
        <InputLabel for="user_role" value="角色選擇" />

        <select id="user_role"
          class="mt-1 block w-full"
          v-model="form.user_role"
          required
          placeholder="活動角色選擇"
          autocomplete="username">
          <option disabled selected value>- 請選擇活動角色 -</option>
          <option value="2">我是講師</option>
          <option value="3">我是學員</option>
        </select>

        <InputError class="mt-2" :message="form.errors.email" />
      </div>

      <div class="flex flex-col items-center justify-end mt-4 gap-[25px]">

        <PrimaryButton class="w-full h-[50px] bg-[#194F69] text-[37px] flex justify-center items-center" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
          註冊
        </PrimaryButton>
        <Link
          :href="route('login')"
          class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
        >
          已經有帳號？
          <span class="text-[#8282f3]">現在登入吧</span>
        </Link>
      </div>
    </form>
  </div>
</template>

<style lang="scss" scoped>

</style>
