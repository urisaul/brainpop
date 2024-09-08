<template>
  <BackgroundWave />
  QUESTIONS
  <section>
    <p v-if="likes > 0">
      This video has {{ likes }} 👍
    </p>
    <p v-else>
      No body likes this video
    </p>
    <button v-on:click="incrimentLikes()">👍</button>
  </section>
</template>

<script>
import BackgroundWave from '@/components/base/backgrounds/wave/BackgroundWave.vue'

export default {
  name: 'QuizQuestionsScreen',
  components: { BackgroundWave },
  data() {
    return {
      likes: 0
    }
  },
  methods: {
    incrimentLikes() {
      this.likes++;
    }
  }
}
</script>

<style lang="scss" scoped></style>
