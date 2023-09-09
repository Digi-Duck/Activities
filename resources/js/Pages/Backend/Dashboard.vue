<!-- 後台儀表板頁面 -->

<script>
export default {
  data() {
    return {};
  },
  methods: {
    /**
     * 登出
     */
    logout() {
      this.$inertia.post(route('logout'));
    },
  },
};
</script>

<template>
  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="flex justify-center gap-5 mb-5">
        <button type="button" class="btn-base" @click="logout">登出</button>
      </div>
      <div class="flex items-center bg-green-500 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 font-bold">歡迎登入</div>
      </div>
    </div>
  </div>
</template>

<style lang="scss" scoped>
.btn-base {
  @apply p-1.5 border-2 rounded-md border-green-500 cursor-pointer;
}
</style>
