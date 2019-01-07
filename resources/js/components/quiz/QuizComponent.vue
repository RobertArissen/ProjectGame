<template>
    <div v-if="visible" class="h-screen w-full absolute flex items-center justify-center z-50">
        <div class="bg-white rounded shadow-lg p-8 m-4 max-h-full text-center overflow-y-scroll">
            <div v-if="introStage">
                <h1>Welkom bij: {{title}}</h1>

                <div class="mt-5">
                    <button 
                    class="text-white font-bold py-2 px-4  bg-blue hover:bg-blue-dark"
                    @click="startQuiz">
                        START!
                    </button>
                    
                    <button class="flex-no-shrink text-white py-2 px-4 bg-red hover:bg-red-dark"
                    @click="closeModal">
                        Sluiten
                    </button>
                </div>
            </div>

            <div v-if="questionStage">
                <question-component :question="questions[currentQuestion]" v-on:answer="handleAnswer" v-on:closeModal="closeModal" :question-number="currentQuestion+1"></question-component>
            </div>

            <div v-if="resultsStage">
                Je hebt {{correct}} van de {{questions.length}} vragen goed. Het percentage is {{perc}}%.
                    <div class="mt-5">                  
                    <button class="flex-no-shrink text-white py-2 px-4 bg-red hover:bg-red-dark"
                    @click="closeModal">
                        Sluiten
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import data from "./questions.json";

export default {
    data() {
        return {
            introStage: false,
            questionStage: false,
            resultsStage: false,
            visible: false,
            title: "",
            questions: [],
            currentQuestion: 0,
            answers: [],
            correct: 0,
            perc: null,
            data
        };
    },

    mounted() {
        EventBus.$on('openQuizModal', data => {
            this.init();
            this.visible = true
            Game.modalOpen = true
        })
    },

    methods: {
        init() {
            this.questionStage = false;
            this.resultsStage = false;

            this.title = data.title;
            this.questions = data.questions;
            this.introStage = true;
            this.currentQuestion = 0;
            this.answers = [];
            this.perc = null;
        },
        startQuiz() {
            this.introStage = false;
            this.questionStage = true;
        },
        handleAnswer(e) {
            this.answers[this.currentQuestion] = e.answer;
            if (this.currentQuestion + 1 === this.questions.length) {
                this.handleResults();
                this.questionStage = false;
                this.resultsStage = true;
            } else {
                this.currentQuestion++;
            }
        },
        handleResults() {
            this.questions.forEach((question, questionNumber) => {
                let yourAnswers = this.answers[questionNumber];
                let questionAnswers = question.answer;

                if (yourAnswers === questionAnswers) {
                    this.correct++;
                }

                if (yourAnswers instanceof Array) {
                    if (yourAnswers.length != questionAnswers.length) return;

                    for (let i = 0; i < yourAnswers.length; ++i) {
                        if (yourAnswers[i] !== questionAnswers[i]) return;
                    }
                    this.correct++;
                }
            });
            this.perc = ((this.correct / this.questions.length) * 100).toFixed(2);
        },
        closeModal() {
            this.visible = false
            
            setTimeout(() => {
                Game.modalOpen = false
            }, 500);
        }
    }
};
</script>

<style>
</style>
