<script>
import defaultImage from '/images/icon/default-image.png';

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
      images: {
        defaultImage,
      },
    };
  },
  computed: {
    rtData() {
      return this.response?.rt_data ?? {};
    },
    userData() {
      return this.rtData.userData ?? {};
    },
    userRoleText() {
      const userRole = this.userData.user_role;
      if (userRole === 1) {
        return '管理';
      } else if (userRole === 2) {
        return '講師';
      } else if (userRole === 3) {
        return '學員';
      }
      return '未知';
    },
  },
};
</script>

<template>
  <section id="userInfo" class="w-[full] p-[100px] bg-[#ebd8d8] flex flex-col justify-center items-center">
    <div class="p-10 w-[35%] min-w-[400px] bg-white shadow-xl border-[3px] flex flex-col gap-3">

      <div class="ms-[calc(50%-50px)] w-[100px] h-[100px] bg-[#cecece] rounded-full overflow-hidden">
        <img v-if="rtData.imgPath" :src="rtData.imgPath" class="w-full h-full" alt="">
        <img v-else :src="images.defaultImage" alt="">
      </div>
      <div class="mt-4">
        <InputLabel for="user_role" value="帳號/Email" />

        <div class="mt-1 ps-[15px] w-full h-[40px] border rounded-[5px] shadow-sm shadow-slate-50 bg-[#838E94] text-white flex items-center">{{ userData.email }}</div>

      </div>
      <div>
        <InputLabel for="name" value="暱稱" />

        <div class="mt-1 ps-[15px] w-full h-[40px] border rounded-[5px] shadow-sm shadow-slate-50 bg-[#838E94] text-white flex items-center">{{ userData.name }}</div>

      </div>
      <div>
        <InputLabel for="name" value="連絡電話" />

        <div class="mt-1 ps-[15px] w-full h-[40px] border rounded-[5px] shadow-sm shadow-slate-50 bg-[#838E94] text-white flex items-center">{{ rtData.phoneNumber }}</div>

      </div>
      <div class="mt-4">
        <InputLabel for="user_role" value="身分狀態" />

        <div class="mt-1 ps-[15px] w-full h-[40px] border rounded-[5px] shadow-sm shadow-slate-50 bg-[#838E94] text-white flex items-center">{{ userRoleText }}</div>

      </div>

      <div class="flex flex-col items-center justify-end mt-4 gap-[25px]">

        <Link :href="route('index')" class="w-full justify-center inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
          完成
        </Link>
        <Link :href="route('changeUserInfo', { id: userData.id })" class="w-full justify-center inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
          修改資料
        </Link>
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
