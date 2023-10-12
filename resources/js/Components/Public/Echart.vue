<script>
import { use } from 'echarts/core';
import { CanvasRenderer } from 'echarts/renderers';
import { BarChart } from 'echarts/charts';
import { GridComponent } from 'echarts/components';
import {
  TooltipComponent,
  LegendComponent,
} from 'echarts/components';
import VChart from 'vue-echarts';
import { defineComponent } from 'vue';

use([
  CanvasRenderer,
  BarChart,
  GridComponent,
  TooltipComponent,
  LegendComponent,
]);

export default defineComponent({
  name: 'Echart',
  components: {
    VChart,
  },
  props: {
    response: {
      type: Object,
      required: false,
      default: () => ({}),
    },
  },
});
</script>

<template>
  <VChart :option="response" class="w-full" />
</template>

<style scoped>
</style>
