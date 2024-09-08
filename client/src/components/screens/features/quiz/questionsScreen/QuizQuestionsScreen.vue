<template>
  <div>
    <BackgroundWave />
    <section v-if="questions.length > 0">
      <div class="d-flex">
        <span class="question-number">{{ currentIndex + 1 }}</span>
        <p>{{ questions[currentIndex].question_text }}</p>
      </div>
      <div class="answers">
        <button v-for="answer in questions[currentIndex].answers" :key="answer.id"
          :class="['answer', { selected: userAnswers[questions[currentIndex].id] === answer.id }]"
          @click="updateUsersAnswer(answer.id)">
          <span>{{ answer.id }}</span> {{ answer.text }}
        </button>
      </div>
    </section>
    <footer class="d-flex f-end">
      <BaseButton v-if="currentIndex !== 0" :theme="BUTTON_THEMES.SECONDARY" @click="prevQuestion" class="no-fill">Back
      </BaseButton>
      <BaseButton :theme="BUTTON_THEMES.SECONDARY" @click="nextQuestion">{{ currentIndex === questions.length - 1 ?
        "Submit" : "Next" }}</BaseButton>
    </footer>
  </div>
</template>

<script>
// CONFIGURATIONS
import { THEMES as BUTTON_THEMES } from '@/components/base/button/config.js'

// COMPONENTS
import BackgroundWave from '@/components/base/backgrounds/wave/BackgroundWave.vue'
import BaseButton from '@/components/base/button/BaseButton.vue';

export default {
  name: 'QuizQuestionsScreen',
  components: { BaseButton, BackgroundWave },
  props: {
    questions: {
      type: Array,
      required: true
    },
    currentIndex: {
      type: Number,
      required: true
    },
    userAnswers: {
      type: Object,
      required: true
    }
  },
  data() {
    return {
      BUTTON_THEMES
    }
  },
  methods: {
    nextQuestion() {
      this.$emit('next');
    },
    prevQuestion() {
      this.$emit('back');
    },
    updateUsersAnswer(answerId) {
      this.$emit('update', this.questions[this.currentIndex].id, answerId);
    }
  }
}
</script>

<style lang="scss" scoped>
section {
  min-width: 400px;
}

span.question-number {
  font-size: 3rem;
  font-weight: bold;
  margin-right: 1rem;
}

.answers {
  display: flex;
  flex-direction: column;
  gap: 1rem;
}

.answer {
  display: flex;
  align-items: center;
  gap: 1rem;
  padding: 0.5rem;
  border-radius: 0.5rem;
  background-color: #f8f9fa;
  cursor: pointer;
  box-shadow: -4px 3px 5px rgba(0, 0, 0, 0.1);
  border: 1px solid grey;
}

.answer:hover {
  background-color: #e9ecef;
}

.answer.selected {
  background-color: #EDFDFE;
  border: 1px solid #2F82F6;
}

.answer span {
  font-size: 1rem;
  font-weight: bold;
  padding: 5px;
  border: 1px solid black;
  height: 1rem;
  width: 1rem;
  border-radius: 50%;
}

// button.no-fill {
//   background-color: transparent;
//   color: #008080;
//   border: 4px solid #008080;
//   box-sizing: border-box;
//   -moz-box-sizing: border-box;
//   -webkit-box-sizing: border-box;
// }

footer {
  position: fixed;
  bottom: 0;
  left: 0;
  width: 98%;
  padding: 1em;
  border-top: 1px solid grey;
}

.d-flex {
  display: flex;
}

.f-end {
  justify-content: flex-end;
}
</style>
