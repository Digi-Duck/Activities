<template>
  <ul>
    <li v-for="(item, index) in items" :key="index">
      <slot :item="item" :index="index">
        <!-- 默认插槽内容：默认情况下渲染列表项的文本 -->
        {{ item.text }}
      </slot>
    </li>
  </ul>
</template>

<script>
export default {
  props: {
    items: {
      type: Array,
      required: true,
    },
  },
};
</script>
