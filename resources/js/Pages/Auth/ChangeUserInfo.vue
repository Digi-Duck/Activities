<script>
import defaultImage from '/images/icon/default-image.png';
import { router } from '@inertiajs/vue3';
import Swal from 'sweetalert2';
import editImage from '/images/icon/edit.svg';

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
        editImage,
      },
      image: '',
      phoneNumber: this.response?.rt_data?.phoneNumber,
      password: '',
      confirmPassword: '',
      isPasswordMatched: false,
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
  methods: {
    uploadImage(event) {
      const reader = new FileReader();
      reader.readAsDataURL(event.target.files[0]);
      reader.onload = () => {
        this.image = reader.result;
      };
    },
    checkPasswordMatch() {
      this.isPasswordMatched = this.password === this.confirmPassword;
      if (!this.isPasswordMatched) {
        Swal.fire({
          title: '密碼不一樣餒',
        });
      }
      if (this.password.length < 8) {
        Swal.fire({
          title: '密碼至少需要8個字符',
        });
      }
    },
    submitData() {
      this.checkPasswordMatch();
      if (!this.isPasswordMatched) return;
      Swal.fire({
        title: '確定更新會員資訊?',
        showDenyButton: true,
        confirmButtonText: '更新',
        denyButtonText: '取消',
      }).then((result) => {
        if (result.isConfirmed) {
          router.visit(route('userInfoUpdate'), {
            method: 'put',
            data: { password: this.password, id: this.userData.id, phoneNumber: this.phoneNumber, user_role: this.userData.user_role, image: this.image },
            preserveState: true,
            onSuccess: ({ props }) => {
              if (props.flash.message.rt_code === 1) {
                Swal.fire({
                  title: '您成功修改了會員資訊',
                  confirmButtonText: '回首頁',
                }).then((result) => {
                  if (result.isConfirmed) {
                    router.get(route('index'));
                  }
                });
              }
            },
          });
        }
      });
    },
  },
};
</script>

<template>
  <form @submit.prevent="submitData" action="">
    <section id="changePassword">
      <div class="w-[full] p-[100px] bg-[#ebd8d8] flex flex-col justify-center items-center">
        <div class="w-[35%] p-10 border-[3px] bg-[#FEFFFE] flex flex-col gap-3">

          <label class="cursor-pointer">
            <div class="relative ms-[calc(50%-50px)] w-[100px] h-[100px] bg-[yellow] rounded-full">
              <img v-if="image" :src="image" class="w-full h-full rounded-full" alt="">
              <img v-else-if="rtData.imgPath" :src="rtData.imgPath" class="w-full h-full rounded-full" alt="">
              <img v-else :src="images.defaultImage" alt="">
              <input type="file" class="hidden" name="image" accept="image/*" @change="(event) => uploadImage(event)">
              <img :src="images.editImage" class="absolute bottom-0 right-0 h-[20px] w-[20px]" alt="編輯圖片">
            </div>
          </label>

          <div class="mt-4">
            <InputLabel value="帳號/Email" />

            <div class="mt-1 ps-[15px] w-full h-[40px] border rounded-[5px] shadow-sm shadow-slate-50 bg-[#838E94] text-white flex items-center">{{ userData.email }}</div>
          </div>
          <div class="mt-4">
            <InputLabel value="暱稱" />

            <div class="mt-1 ps-[15px] w-full h-[40px] border rounded-[5px] shadow-sm shadow-slate-50 bg-[#838E94] text-white flex items-center">{{ userData.name }}</div>
          </div>
          <div class="mt-4">
            <InputLabel value="角色狀態" />

            <div class="mt-1 ps-[15px] w-full h-[40px] border rounded-[5px] shadow-sm shadow-slate-50 bg-[#838E94] text-white flex items-center">{{ userRoleText }}</div>
          </div>
          <div class="mt-4">
            <InputLabel value="連絡電話" />

            <input v-model="phoneNumber" type="text" class="mt-1 ps-[15px] w-full h-[40px] border rounded-[5px] shadow-sm shadow-slate-50 bg-[#FFFFFF] flex items-center">
          </div>
          <div class="mt-4">
            <InputLabel for="user_role" value="密碼" />
            <input type="password" class="mt-1 ps-[15px] w-full h-[40px] border rounded-[5px] shadow-sm shadow-slate-50 bg-[#FFFFFF] flex items-center" v-model="password" />
          </div>
          <div class="mt-4">
            <InputLabel for="user_role" value="確認密碼" />
            <input type="password" class="mt-1 ps-[15px] w-full h-[40px] border rounded-[5px] shadow-sm shadow-slate-50 bg-[#FFFFFF] flex items-center" v-model="confirmPassword" />
          </div>

          <div class="flex flex-col items-center justify-end mt-4 gap-[25px]">
            <button type="submit" :href="route('userInfoUpdate')" class="w-full h-[50px] bg-[#194F69] text-[37px] flex justify-center items-center cursor-pointer">
              確認修改
            </button>
          </div>
        </div>
      </div>
    </section>
  </form>
</template>

<style lang="scss" scoped>
#changePassword {
  @apply w-full h-full overflow-y-auto;

  .title {
    @apply text-[6.25rem] text-center;
  }

  .btn-base {
    @apply p-1.5 border-2 rounded-md border-green-500 cursor-pointer;
  }
}
</style>
