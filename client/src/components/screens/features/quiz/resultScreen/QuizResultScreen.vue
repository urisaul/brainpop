<template>
  <div>
    <Navigator :items="[
      { text: name, to: `/feature/quiz` },
      { text: 'Quiz', to: '' }
    ]" />
    <header>
      Scored {{ quizResults.questions?.filter(i => i.is_correct).length }}/{{ quizResults.questions.length }}
    </header>
    <main v-if="quizResults.questions?.length > 0" class="main-content">
      <div v-for="(q, index) in quizResults?.questions" :key="index" class="question">
        <div class="question-text d-flex">
          <span class="question-number">{{ index + 1 }}</span>
          <p>{{ q.question_text }}</p>
        </div>
        <div class="answers">
          <button v-for="answer in q.answers" :key="answer.id"
            :class="['answer', { selected: q.user_answer === answer.id }, { correct: q.is_correct }, { incorrect: !q.is_correct }]">
            <span>{{ answer.id }}</span> {{ answer.text }}
          </button>
        </div>
      </div>
    </main>
  </div>
</template>

<script>
import Navigator from '@/components/compositions/navigator/Navigator.vue'

export default {
  name: 'QuizResultScreen',
  components: { Navigator },
  props: {
    quizResults: {
      type: Array,
      required: true
    },
    name: {
      type: String,
      required: true
    }
  }
}
</script>

<style lang="scss" scoped>
div.question {
  padding-bottom: 1rem;
  margin-bottom: 1rem;
  border-bottom: 1px solid grey;
  width: 100%;
}

header {
  font-size: 1.5rem;
  font-weight: bold;
  text-align: center;
  background: #EEF7F7;
  position: absolute;
  left: 0;
  top: 62px;
  width: 100%;
  padding: 5px;
  padding-bottom: 15px;
}

.main-content {
  margin-block: 150px auto;
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
  box-shadow: -4px 3px 5px rgba(0, 0, 0, 0.1);
  border: 1px solid grey;
}

.answer.selected {
  position: relative;
}

.answer.selected.correct {
  background-color: #F0FFF0;
  border: 1px solid #5FB57C;
}

.answer.selected.correct::after {
  content: "✅";
  position: absolute;
  right: -25px;
}

.answer.selected.incorrect {
  background-color: #FDF7F7;
  border: 1px solid #EE5286;
}

.answer.selected.incorrect::after {
  content: "❌";
  position: absolute;
  right: -25px;
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
