<!-- 全域布局 -->
<script>
import facebook from '/images/icon/icon-facebook.svg';
import instagram from '/images/icon/icon-instagram.svg';
import youtube from '/images/icon/icon-youtube.svg';
import envelope from '/images/icon/envelope-regular.svg';

export default {
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
    <header id="header">
      <button type="button" id="logo">Logo</button>
      <div id="header-top">
        <button type="button" class="btn">會員中心</button>
        <button type="button" class="btn">登出/登入</button>
      </div>
      <div id="header-bottom">
        <button type="button" class="function-btn">首頁</button>
        <button type="button" class="function-btn">活動建立</button>
        <button type="button" class="function-btn">我的活動</button>
        <button type="button" class="function-btn">報到掃描</button>
      </div>
    </header>
    <main id="main">
      <slot />
    </main>
    <footer id="footer">
      <div id="footer-top">
        <div id="footer-top-left">
          <button type="button" class="contact-btn">
            <img id="instagram-btn" :src="images.instagram" alt="">
          </button>
          <button type="button" class="contact-btn">
            <img id="facebook-btn" :src="images.facebook" alt="">
          </button>
          <button type="button" class="contact-btn">
            <img id="youtube-btn" :src="images.youtube" alt="">
          </button>
        </div>
        <div id="footer-top-right">
          <div id="footer-top-right-top">Copyright © 2023 Office of Student Affairs, NCHU</div>
          <div id="footer-top-right-bottom">
            <button type="button">聯絡信箱</button>
            <img id="mail" :src="images.envelope" alt="">
            <button type="button" id="mail-info">service@gmail.com</button>
          </div>
        </div>
      </div>
      <div id="footer-bottom">
        <button type="button" id="system" class="btn">系統後台</button>
        <button type="button" id="relative" class="btn">相關聲明</button>
      </div>
    </footer>
  </section>
</template>

<style lang="scss" scoped>
#app-layout {
  @apply w-full min-h-screen;
  .btn {
      @apply w-[90px] h-[38px] bg-[#a9bcc650] rounded-[4px] flex justify-center items-center mt-5 font-semibold;
    }
}

#main {
  @apply h-[calc(100dvh-42px)] bg-[#FAFAFA];
}

#header {
  @apply h-[160.8px] bg-[#F9565C] relative;
  #logo {
    @apply h-[98px] w-[239px] bg-[#AB4C4C] rounded-[15px] top-[10px] left-[10px] opacity-75 absolute text-5xl text-center leading-loose;
  }
  #header-top {
    @apply h-[37.313%] bg-[#FFFFFF] flex justify-end gap-3 pe-5;
    .btn {
      @apply mt-auto mb-auto;
    }
  }
  #header-bottom {
    @apply flex justify-end gap-3 pt-6 pe-5;
    .function-btn {
      @apply w-[151.2px] h-[50px] bg-[#22293B] text-white text-2xl flex justify-center items-center font-bold shadow-[4px_5px_4px_0px_#000000];
    }
  }
}
#footer {
  @apply h-[248px] bg-[#194F69];
  #footer-top {
    @apply w-[89.04%] h-[173px] border-b mx-auto border-b-black flex justify-between;
    #footer-top-left {
      @apply bg-transparent flex gap-3 ms-28;
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
    }
    #footer-top-right {
      @apply flex-col items-end me-28;
      #footer-top-right-top {
        @apply text-white ms-[275px] mt-[25px] pt-[15px];
      }
      #footer-top-right-bottom {
        @apply text-white ms-[275px] mt-[25px] flex gap-3;
        #mail {
          @apply h-[25px] w-[25px] bg-white rounded border border-x-2;
        }
        img {
          @apply w-[25px] h-[25px] text-white object-cover;
        }
      }
    }
  }
  #footer-bottom {
    @apply flex justify-end gap-3 pe-64;
  }
}
</style>
