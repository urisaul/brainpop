<template>
  <div>
    <BackgroundWave />
    <section v-if="quizResults?.questions?.length > 0">
      <h1>Quiz Results</h1>
      <div v-for="q in quizResults?.questions">
        <p>{{ q.question_text }}</p>
        <div class="answers">
          <div v-for="answer in q?.answers" :key="answer.id" class="answer">
            <input type="radio" :id="q.id + '-' + answer.id" :name="'question-' + currentIndex" :value="answer.id" />
            <label :for="q.id + '-' + answer.id">{{ answer.text }}</label>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script>
import BackgroundWave from '@/components/base/backgrounds/wave/BackgroundWave.vue'

export default {
  name: 'QuizResultScreen',
  components: { BackgroundWave },
  props: {
    quizResults: {
      type: Array,
      required: true
    }
  }
}
</script>

<style lang="scss" scoped></style>
