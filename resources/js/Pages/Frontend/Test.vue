<script>
export default {
  data() {
    return {
      images: [
        'https://images.pexels.com/photos/1000366/pexels-photo-1000366.jpeg?auto=compress&cs=tinysrgb&w=1600',
        'https://images.pexels.com/photos/4226881/pexels-photo-4226881.jpeg?auto=compress&cs=tinysrgb&w=1600',
        'https://images.pexels.com/photos/4022082/pexels-photo-4022082.jpeg?auto=compress&cs=tinysrgb&w=1600',
      ],
      currentIndex: 0,
      startX: 0,
      distX: 0,
    };
  },
  computed: {
    currentImage() {
      return this.images[this.currentIndex];
    },
  },
  methods: {
    startSwipe(event) {
      this.startX = event.touches[0].clientX;
    },
    swipe(event) {
      this.distX = event.touches[0].clientX - this.startX;
    },
    endSwipe() {
      if (Math.abs(this.distX) > 50) { // Minimum swipe distance
        if (this.distX > 0) {
          this.prevImage();
        } else {
          this.nextImage();
        }
      }
      this.distX = 0;
    },
    prevImage() {
      this.currentIndex = (this.currentIndex - 1 + this.images.length) % this.images.length;
    },
    nextImage() {
      this.currentIndex = (this.currentIndex + 1) % this.images.length;
    },
  },
};
</script>

<template>
  <section id="test">
    <div class="carousel" @touchstart="startSwipe" @touchmove="swipe" @touchend="endSwipe">
      <transition name="fade" mode="out-in">
        <img :src="currentImage" :key="currentImage" alt="Carousel Image" />
      </transition>
      <button type="button" @click="prevImage">Previous</button>
      <button type="button" @click="nextImage">Next</button>
    </div>
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
