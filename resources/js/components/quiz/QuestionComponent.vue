<template>
  <div>
    <strong v-bind:class="{ 'text-green': answerIsCorrect === true, 'text-red': answerIsCorrect === false }">{{ question.name }}</strong> ({{question.points}} punten)

    <div class="flex flex-col items-center p-4" v-if="question.type.inCode === 'mc' || question.type.inCode === 'tf'">
        <div class="p-1" v-for="(element,index) in question.answers">
            <input type="radio" :id="'answer'+index" name="currentQuestion" v-model="answer" :value="element" :disabled="answerIsCorrect !== null">
            <label :for="'answer'+index">
            {{element.name}}
            </label><br/>
        </div>
    </div>

    <div class="flex justify-center p-4" v-if="question.type.inCode === 'sort'">
      <draggable class="w-1/2 p-1" v-model="question.answers" @start="drag=true" @end="drag=false" :options="{disabled: answerIsCorrect !== null}">
        <div class="border border-grey rounded-lg w-auto p-1 m-1 cursor-move text-center" :value="element" v-for="element in question.answers" :key="element.id">
            {{element.name}}
        </div>
      </draggable>
    </div>

    <div class="mt-5" v-if="answerIsCorrect === null">
        <button 
        class="flex-no-shrink text-white py-2 px-4 bg-red hover:bg-red-dark"
        @click="stopQuiz">
            Stop
        </button>
        
        <button 
        class="text-white font-bold py-2 px-4 bg-blue hover:bg-blue-dark"
        @click="submitAnswer">
            Antwoord
        </button>
    </div>

    <div class="mt-2" v-if="answerIsCorrect !== null">
        <div v-if="answerIsCorrect" v-bind:class="{ 'text-green': answerIsCorrect === true }">
            Jouw antwoord is juist!
        </div>
        <div v-else v-bind:class="{ 'text-red': answerIsCorrect === false }">
            Jouw antwoord is helaas fout. Het juiste antwoord is:
            <div v-for="(element,index) in correctAnswer">
                {{element.name}}<br/>
            </div>
        </div>

    </div>

    <div class="mt-5" v-if="answerIsCorrect !== null">
        <div class="mt-2 w-full h-2 bg-grey-light">
            <div class="p-1 h-full" v-bind:class="{ 'bg-green-light': answerIsCorrect === true, 'bg-red-light': answerIsCorrect === false }" v-bind:style="{width: timer +'%'}">
            </div>
        </div>
    </div>
</div>

</template>

<script>
import draggable from 'vuedraggable';

export default {
  name: 'Question',
  data() {
    return {
      answer: null
    }
  },
  components: {
      draggable,
  },
  props:['question', 'answerIsCorrect', 'correctAnswer', 'timer'],
  methods:{
      submitAnswer:function() {
        if (this.question.type.inCode === 'sort') {
            this.answer = this.question.answers;
        }
        this.$emit('answer', {questionId: this.question.id, answer:this.answer});
      },

      stopQuiz() {
        this.$emit('stopQuiz');
      },
  }
}
</script>

<style>

</style>
