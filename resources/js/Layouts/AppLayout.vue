<!-- 全域布局 -->
<script>
import facebook from '/images/icon/icon-facebook.svg';
import instagram from '/images/icon/icon-instagram.svg';
import youtube from '/images/icon/icon-youtube.svg';
import envelope from '/images/icon/envelope-regular.svg';
import { Link } from '@inertiajs/vue3';

export default {
  components: { Link },
  data() {
    return {
      images: {
        facebook,
        instagram,
        youtube,
        envelope,
      },
    };
  },
  methods: {},
};
</script>

<template>
  <section id="app-layout">
    <header class="relative h-[160.8px] bg-[#F9565C] flex flex-col">
      <Link href="" class="absolute top-[10px] left-[10px] h-[98px] w-[239px] rounded-[15px] bg-[#AB4C4C] opacity-75 text-5xl text-center leading-loose">
        Logo
      </Link>
      <nav class="h-[37.313%] pe-5 bg-[#FFFFFF] flex justify-end items-center gap-3">
        <Link href="" class="btn">會員中心</Link>
        <Link :href="route('login')" class="btn">登出/登入</Link>
      </nav>
      <nav class="pt-6 pe-5 flex justify-end gap-3">
        <Link href="" class="function-btn">首頁</Link>
        <Link href="" class="function-btn">活動建立</Link>
        <Link href="" class="function-btn">我的活動</Link>
        <Link href="" class="function-btn">報到掃描</Link>
      </nav>
    </header>
    <main id="main">
      <slot />
    </main>
    <footer class="h-[248px] bg-[#194F69]">
      <div class="w-[89.04%] h-[173px] mx-auto border-b border-b-black flex justify-between">
        <div class="ms-28 bg-transparent flex gap-3">
          <a href="https://instagram.com" class="contact-btn" target="_blank">
            <img id="instagram-btn" :src="images.instagram" alt="跳轉instagram按鈕" />
          </a>
          <a href="https://facebook.com" class="contact-btn" target="_blank">
            <img id="facebook-btn" :src="images.facebook" alt="跳轉facebook按鈕" />
          </a>
          <a href="https://youtube.com" class="contact-btn" target="_blank">
            <img id="youtube-btn" :src="images.youtube" alt="跳轉youtube按鈕" />
          </a>
        </div>
        <div class="me-28 flex-col items-end">
          <div class="ms-[275px] mt-[25px] pt-[15px] text-white">
            Copyright © 2023 Office of Student Affairs, NCHU
          </div>
          <div class="ms-[275px] mt-[25px] text-white flex gap-3">
            <button type="button">聯絡信箱</button>
            <img class="h-[25px] w-[25px] rounded bg-white border border-x-2" :src="images.envelope" alt="聯絡信箱按鈕" />
            <button type="button">service@gmail.com</button>
          </div>
        </div>
      </div>
      <div class="pe-64 pt-4 flex justify-end gap-3">
        <Link href="" class="btn">系統後台</Link>
        <Link href="" class="btn">相關聲明</Link>
      </div>
    </footer>
  </section>
</template>

<style lang="scss" scoped>
#app-layout {
    @apply w-full min-h-screen;
    .btn {
        @apply w-[90px] h-[38px] rounded-[4px] bg-[#a9bcc650] flex justify-center items-center font-semibold;
    }
}

#main {
    @apply bg-[#FAFAFA];
}

.function-btn {
    @apply w-[151.2px] h-[50px] bg-[#22293B] text-white text-2xl flex justify-center items-center font-bold shadow-[4px_5px_4px_0px_#000000];
}
.contact-btn {
    @apply w-[50px] h-[50px] bg-black rounded-full mt-[calc(50%-25px)] m-auto flex items-center justify-center;
    #youtube-btn {
        @apply w-[50px] h-[50px];
    }
    #instagram-btn {
        @apply w-[35px] h-[35px];
    }
    #facebook-btn {
        @apply w-[35px] h-[35px];
    }
}
</style>
