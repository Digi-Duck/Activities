<!-- 學員會員介面 -->

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
  {{ $props.response.rt_data }}
  <div v-for="(item, index) in response.rt_data" :key="item.id">
    <div>{{ index + 1 }}</div>
    <Link :href="route('activityEdit', { id: item.id })">
      <button type="button" class="border border-black px-3 py-2 rounded-[5px]">編輯</button>
      <div class="w-[300px] h-[300px] bg-[blue]">{{ item.activity_name }}</div>
    </Link>
  </div>
  <section id="presenter-personal-page" class="flex flex-col items-center">
    <ActivitySwiper>
      <template #activity_title_name>
        <span>
          近期活動
        </span>
      </template>
      <template #activity_name>
        <span>
          我是新的活動名稱
        </span>
      </template>
      <template #activity_start_time>
        <span>
          我是新的活動時間
        </span>
      </template>
      <template #activity_address>
        <span>
          我是新的活動地點
        </span>
      </template>
    </ActivitySwiper>
    <ActivityDetailTable>
      <template #activity_title_type>
        <span>
          活動類型
        </span>
      </template>
      <template #activity_name>
        <span>
          我自己寫活動名稱
        </span>
      </template>
      <template #activity_type>
        <span>
          我自己寫活動類型
        </span>
      </template>
      <template #activity_end_registration_time>
        <span>
          我自己寫活動時間
        </span>
      </template>
      <template #activity_lowest_number_of_people>
        <span>
          50
        </span>
      </template>
      <template #activity_highest_number_of_people>
        <span>
          150
        </span>
      </template>
    </ActivityDetailTable>
    <ActivitySwiper>
      <template #activity_title_name>
        <span>
          已上完的活動
        </span>
      </template>
      <template #activity_name>
        <span>
          我是上過的活動名稱
        </span>
      </template>
      <template #activity_start_time>
        <span>
          我是上過的活動時間
        </span>
      </template>
      <template #activity_address>
        <span>
          我是上過的活動地點
        </span>
      </template>
    </ActivitySwiper>
  </section>
</template>

<style lang="scss" scoped>
#presenter-personal-page {
  @apply w-full h-full overflow-y-auto;

  .title {
    @apply text-[6.25rem] text-center;
  }

  .btn-base {
    @apply p-1.5 border-2 rounded-md border-green-500 cursor-pointer;
  }
}
</style>
