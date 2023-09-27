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
  methods: {
    test(event) {
      console.log(event);
    },
  },
};
</script>

<template>
  <section id="test">
    <!-- <Editor class="h-[700px]" @update-content="test"></Editor> -->

    <Editor v-model="editorValue" :init="editorInit" class="min-h-[500px]" />
  </section>
</template>

<style lang="scss" scoped>
#test {
  @apply w-full h-full overflow-y-auto;

  .title {
    @apply text-[6.25rem] text-center;
  }

  .btn-base {
    @apply p-1.5 border-2 rounded-md border-green-500 cursor-pointer;
  }
}
</style>
