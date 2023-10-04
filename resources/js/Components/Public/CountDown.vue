<script>
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
      title: 'Hello World !',
    };
  },
  created() {
  },
};
</script>

<template>
  <section id="count-down">
    <div class="z-50 w-[200px] p-3 bg-[#FFDD55] rounded-[5px] flex flex-col text-[48px] font-extrabold">倒數
      <div class="ps-5 flex flex-row">
        <slot name="count-down">10</slot>
        天！
      </div>
    </div>
  </section>
</template>

<style lang="scss" scoped>
#count-down {
  @apply overflow-y-auto;

  .title {
    @apply text-[6.25rem] text-center;
  }

  .btn-base {
    @apply p-1.5 border-2 rounded-md border-green-500 cursor-pointer;
  }
}
</style>
