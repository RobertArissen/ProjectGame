<template>
    <div v-if="visible" class="h-screen w-full absolute flex items-center justify-center z-50">
        <div class="bg-white rounded shadow-lg p-8 m-4 max-h-full text-center overflow-y-scroll">
            <div v-if="introStage">
                <h1>Beantwoord vragen</h1>

                <div class="mt-5">
                    <div v-if="this.questions.length === 0">
                        Er zijn geen vragen meer die je kunt beantwoorden.
                    </div>
                    <div v-if="this.questions.length === 1">
                        Je kunt nog 1 vraag beantwoorden.
                    </div>
                    <div v-if="this.questions.length > 1">
                        Je kunt nog {{this.questions.length}} vragen beantwoorden.
                    </div>
                </div>

                <div class="mt-5">
                    <button 
                    class="text-white font-bold py-2 px-4  bg-blue hover:bg-blue-dark"
                    @click="startQuiz"
                    v-if="this.questions.length > 0" >
                        START!
                    </button>
                    
                    <button class="flex-no-shrink text-white py-2 px-4 bg-red hover:bg-red-dark"
                    @click="closeModal">
                        Sluiten
                    </button>
                </div>
            </div>

            <div v-if="questionStage">
                <div class="mb-2">
                    <span>
                        Vraag: {{currentQuestion + 1}} van de {{this.questions.length}}
                    </span><br/>
                    <span>
                        Juist: {{correct}} van de {{questionsAnswered}}
                    </span><br/>
                    <span>
                        Punten verdiend: {{pointsEarned}}
                    </span>
                </div>
                <question-component :question="questions[currentQuestion]" :answerIsCorrect="answerIsCorrect" :correctAnswer="correctAnswer" :timer="timer" v-on:answer="handleAnswer" v-on:stopQuiz="stopQuiz"></question-component>
            </div>

            <div class="m-6" v-if="resultsStage">
                <div v-if="this.questions.length === questionsAnswered">
                    Er zijn geen vragen meer die je kunt beantwoorden.
                </div>
                <div v-else>
                    Je bent gestopt met het beantwoorden van de vragen.
                </div>
                <div>
                    Hieronder zie je een samenvatting over de beantwoordde vraag/vragen:
                </div>

                <div class="mt-3 border border-gray">
                    <span>
                        Vragen beantwoord: {{questionsAnswered}}
                    </span><br/>
                    <span>
                        Juist: {{correct}}
                    </span><br/>
                    <span>
                        Punten verdiend: {{pointsEarned}}
                    </span>
                </div>

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
export default {
    data() {
        return {
            visible: false,

            introStage: false,
            questionStage: false,
            resultsStage: false,

            questions: [],
            currentQuestion: 0,

            correct: 0,
            pointsEarned: 0,
            questionsAnswered: 0,
            timer: 0,

            answerIsCorrect: null,
            correctAnswer: null,
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
            this.introStage = false;
            this.questionStage = false;
            this.resultsStage = false;

            this.currentQuestion = 0;

            this.correct = 0;
            this.pointsEarned = 0;
            this.questionsAnswered = 0;
            this.timer = 0;

            this.answerIsCorrect = null;
            this.correctAnswer = null;

            this.questions = [];

            axios.get('/api/question')
            .then(response => {
                this.questions = response.data;
                this.introStage = true;
            });
        },
        startQuiz() {
            this.introStage = false;
            this.resultsStage = false;
            this.questionStage = true;
        },
        stopQuiz() {
            this.introStage = false;
            this.questionStage = false;
            this.resultsStage = true;
        },
        handleAnswer(e) {
            this.questionsAnswered++;
            let questionId = e.questionId;
            let answer = e.answer;

            axios.post('/api/question/answer',
                {questionId: questionId, answer: answer}
            )
            .then(response => {
                this.answerIsCorrect = response.data.answerIsCorrect;
                this.pointsEarned += response.data.pointsEarned;

                if (this.answerIsCorrect) this.correct++;

                axios.get('/api/question/'+questionId+'/answer')
                .then(response => {
                    this.correctAnswer = response.data;

                    let timeOut = 6000;

                    this.timer = ( 100 / (timeOut / 100));
                    let interval = setInterval(() => {
                        this.timer += ( 100 / (timeOut / 100));
                        if (this.timer >= 100) {
                            clearInterval(interval);
                        }
                    }, 100);

                    setTimeout(() => {
                        this.timer = 0;

                        if (this.questions.length === this.currentQuestion +1) {
                            this.stopQuiz();
                            EventBus.$emit('reloadUserData', true);
                        } else {
                            this.correctAnswer = null;
                            this.answerIsCorrect = null;
                            this.currentQuestion++;
                        }
                    }, timeOut);
                });
            });
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
