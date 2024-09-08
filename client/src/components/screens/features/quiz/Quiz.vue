<template>
  <div class="quiz_container">
    <div v-if="quiz">
      <QuizStartScreen v-if="quizState === QUIZ_STATES.START" :name="quiz.name" :questionsLength="quiz.questions.length"
        @start="start"></QuizStartScreen>
      <QuizQuestionsScreen v-if="quizState === QUIZ_STATES.QUESTIONS" :name="quiz.name" :questions="quiz.questions"
        :currentIndex="currentQuestionIndex" :userAnswers="userAnswers" @next="nextQuestion" @back="prevQuestion" @update="updateUsersAnswer">
      </QuizQuestionsScreen>
      <QuizResultScreen v-if="quizState === QUIZ_STATES.RESULT" :name="quiz.name" :quizResults="quizResults"></QuizResultScreen>
    </div>
    <div v-else-if="errors">
      <span>{{ errors }}</span>
    </div>
    <div v-else>Loading...</div>
  </div>
</template>

<script>
import QuizStartScreen from './startScreen/QuizStartScreen.vue'
import QuizQuestionsScreen from './questionsScreen/QuizQuestionsScreen.vue'
import QuizResultScreen from './resultScreen/QuizResultScreen.vue'
import { useUserStore } from '@/stores/user'

const QUIZ_STATES = {
  START: 'start',
  QUESTIONS: 'questions',
  RESULT: 'result'
}

export default {
  name: 'Quiz',
  components: {
    QuizStartScreen,
    QuizQuestionsScreen,
    QuizResultScreen
  },
  props: {
    data: {
      type: Object,
      required: false
    }
  },
  data() {
    return {
      QUIZ_STATES,
      quizState: QUIZ_STATES.START,
      quiz: null, // will populate from fetch. e.g. { name: 'Test Quiz', questions: [...] }
      errors: null,
      currentQuestionIndex: 0,
      userAnswers: {},
      quizResults: null
    }
  },
  methods: {
    async fetchQuizDetails() {
      try {
        const response = await fetch('http://localhost:3000/api/quiz/1', {
          method: 'GET',
          headers: {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${localStorage.getItem('token')}`
          }
        });
        if (response.ok) {
          const data = await response.json();
          this.quiz = data;
        } else if (response.status === 401) {
          const store = useUserStore()
          store.logout();
          this.$router.go({ name: 'login' });
        } else {
          console.error('Failed to fetch quiz details - check network tab for more info');
          this.errors = 'Failed to fetch quiz details';
        }
      } catch (error) {
        console.error('Error fetching quiz details:', error);
        this.errors = 'Error fetching quiz details';
      }
    },
    async submitUserAnswers() {
      try {
        // Convert the answers object to an array of objects
        const answersArray = Object.entries(this.userAnswers).map(([question_id, answer]) => ({
          question_id: Number(question_id),
          answer: answer
        }));

        const response = await fetch('http://localhost:3000/api/activity/1', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${localStorage.getItem('token')}`
          },
          body: JSON.stringify({ answers: answersArray })
        });
        if (response.ok) {
          const data = await response.json();
        } else if (response.status === 401) {
          const store = useUserStore()
          store.logout();
          this.$router.go({ name: 'login' });
        } else {
          console.error('Failed to submit quiz answers - check network tab for more info');
          this.errors = 'Failed to submit quiz answers';
        }
      } catch (error) {
        console.error('Error submitting quiz answers:', error);
        this.errors = 'Error submitting quiz answers';
      }
    },
    async fetchQuizResults() {
      try {
        const response = await fetch('http://localhost:3000/api/activity/1', {
          method: 'GET',
          headers: {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${localStorage.getItem('token')}`
          }
        });
        if (response.ok) {
          const data = await response.json();
          this.quizResults = data;
        } else if (response.status === 401) {
          const store = useUserStore()
          store.logout();
          this.$router.go({ name: 'login' });
        } else {
          console.error('Failed to fetch quiz results - check network tab for more info');
          this.errors = 'Failed to fetch quiz results';
        }
      } catch (error) {
        console.error('Error fetching quiz results:', error);
        this.errors = 'Error fetching quiz results';
      }
    },
    start() {
      this.quizState = QUIZ_STATES.QUESTIONS
    },
    async nextQuestion() {
      if (this.currentQuestionIndex < this.quiz.questions.length - 1) {
        this.currentQuestionIndex++;
      } else {
        await this.submitUserAnswers();
        await this.fetchQuizResults();
        this.quizState = QUIZ_STATES.RESULT
      }
    },
    prevQuestion() {
      if (this.currentQuestionIndex > 0) {
        this.currentQuestionIndex--;
      }
    },
    updateUsersAnswer(questionId, answerId) {
      this.userAnswers[questionId] = answerId;
      console.log('userAnswers:', this.userAnswers);
    },
  },
  created() {
    this.fetchQuizDetails();
  }
}
</script>

<style lang="scss" scoped></style>
