<!-- 全域布局 -->

<script>
export default {
  data() {
    return {};
  },
  methods: {},
};
</script>

<template>
  <section id="app-layout">
    <header id="header"></header>
    <main id="main">
      <slot />
    </main>
    <footer id="footer"></footer>
  </section>
</template>

<style lang="scss" scoped>
#app-layout {
  @apply w-full min-h-screen;
}

#main {
  @apply h-[calc(100dvh-42px)];
}

#header, #footer {
  @apply h-[21px] bg-[#00bd89];
}
</style>
