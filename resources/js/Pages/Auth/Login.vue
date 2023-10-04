<script setup>
import { useForm } from '@inertiajs/vue3';

defineProps({
  canResetPassword: {
    type: Boolean,
  },
  status: {
    type: String,
  },
});

const form = useForm({
  email: '',
  password: '',
});

const submit = () => {
  form.post(route('login'), {
    onFinish: () => form.reset('password'),
  });
};
</script>

<template>
  <div class="w-[full] p-[100px] bg-[#ebd8d8] flex flex-col justify-center items-center">
    <div class="flex flex-col">
      <b class="w-full text-[72px]">
        哈囉，
      </b>
      <b class="w-full text-[72px]">
        一起參加活動吧！
      </b>
    </div>
    <form @submit.prevent="submit" class="w-[35%] p-10 border-[3px] flex flex-col gap-3">
      <div>
        <InputLabel for="email" value="帳號/Email" />

        <TextInput
          id="email"
          type="email"
          class="mt-1 block w-full"
          v-model="form.email"
          required
          autofocus
          autocomplete="username"
          placeholder="Email/帳號"
        />

        <InputError class="mt-2" :message="form.errors.email" />
      </div>

      <div class="mt-4">
        <InputLabel for="password" value="密碼" />

        <TextInput
          id="password"
          type="password"
          class="mt-1 block w-full"
          v-model="form.password"
          required
          autocomplete="current-password"
          placeholder="密碼"
        />

        <InputError class="mt-2" :message="form.errors.password" />
      </div>

      <div class="flex flex-col items-center justify-end mt-4 gap-[25px]">
        <PrimaryButton class="w-full h-[50px] bg-[#194F69] text-[37px] flex justify-center items-center" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
          登入
        </PrimaryButton>
        <Link
          v-if="canResetPassword"
          :href="route('register')"
          class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
        >
          還沒有帳號？
          <span class="text-[#8282f3]">現在註冊吧</span>
        </Link>

      </div>
    </form>
  </div>
</template>

<style lang="scss" scoped>

</style>
