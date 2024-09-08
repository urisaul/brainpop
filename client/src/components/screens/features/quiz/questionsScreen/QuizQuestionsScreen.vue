<template>
  <div>
    <Navigator :items="[
      { text: name, to: `/feature/quiz` },
      { text: 'Quiz', to: '' }
    ]" />
    <main v-if="questions.length > 0" class="main-content">
      <div class="question-text d-flex">
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
    </main>
    <footer class="d-flex f-end">
      <BaseButton v-if="currentIndex !== 0" :theme="BUTTON_THEMES.SECONDARY" @click="prevQuestion" class="no-fill mr-1">
        Back
      </BaseButton>
      <BaseButton :theme="BUTTON_THEMES.SECONDARY" :disabled="!isAnswered" @click="nextQuestion">{{ currentIndex ===
        questions.length - 1 ?
        "Submit" : "Next" }}</BaseButton>
    </footer>
  </div>
</template>

<script>
// CONFIGURATIONS
import { THEMES as BUTTON_THEMES } from '@/components/base/button/config.js'

// COMPONENTS
import Navigator from '@/components/compositions/navigator/Navigator.vue'
import BaseButton from '@/components/base/button/BaseButton.vue';

export default {
  name: 'QuizQuestionsScreen',
  components: { BaseButton, Navigator },
  props: {
    name: {
      type: String,
      required: true
    },
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
  computed: {
    isAnswered() {
      // Check if the current question has an answer
      return this.userAnswers.hasOwnProperty(this.questions[this.currentIndex].id);
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
.main-content {
  margin-block: 100px auto;
  display: flex;
  flex-direction: column;
  align-items: center;
  width: 100%;
  gap: 1.2rem;
  min-width: 450px;
  align-items: flex-start;
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
  width: 100%;
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

button.no-fill {
  background-color: transparent;
  color: #008080;
  border: 4px solid #008080;
  box-sizing: border-box;
  -moz-box-sizing: border-box;
  -webkit-box-sizing: border-box;
}

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

.mr-1 {
  margin-right: 1rem;
}
</style>
