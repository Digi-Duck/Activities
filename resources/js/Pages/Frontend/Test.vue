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
    };
  },
  methods: {
  },
};
</script>

<template>
  <div>
    <a :href="route('googleLogin')">Login with Google</a>
  </div>
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
