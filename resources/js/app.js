/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
window._ = require('lodash');

import Notifications from 'vue-notification'
Vue.use(Notifications)

/* Game Files */
require('./game/map');
require('./game/index');


/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key)))

Vue.component('login-compontent', require('./components/LoginComponent.vue'));
Vue.component('game-compontent', require('./components/game/GameComponent.vue'));
Vue.component('buy-houses-compontent', require('./components/game/BuyHousesComponent.vue'));
Vue.component('quiz-component', require('./components/quiz/QuizComponent.vue'));
Vue.component('question-component', require('./components/quiz/QuestionComponent.vue'));


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

window.EventBus = new Vue();

const app = new Vue({
    el: '#app'
});
