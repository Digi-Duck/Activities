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
  <form @submit.prevent="submit" class="p-10">
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
      />

      <InputError class="mt-2" :message="form.errors.name" />
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

    <div class="mt-4">
      <InputLabel for="email" value="Email" />

      <TextInput
        id="email"
        type="email"
        class="mt-1 block w-full"
        v-model="form.email"
        required
        autocomplete="username"
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
        autocomplete="new-password"
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
      />

      <InputError class="mt-2" :message="form.errors.password_confirmation" />
    </div>

    <div class="flex items-center justify-end mt-4">
      <Link
        :href="route('login')"
        class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
      >
        Already registered?
      </Link>

      <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
        Register
      </PrimaryButton>
    </div>
  </form>
</template>

<style lang="scss" scoped>

</style>
