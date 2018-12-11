<template>
    <div class="container mx-auto h-full flex justify-center items-center">
        <div class="w-1/3">
            <h1 class="font-hairline mb-6 text-center">GameNaam</h1>
            <div class="border-blue p-8 border-t-4 bg-white mb-6 shadow-lg">
                <div>
                    <div class="relative">
                        <select class="block appearance-none w-full bg-grey-lighter border border-grey-lighter text-grey-darker py-3 px-4 pr-8 leading-tight focus:outline-none focus:bg-white focus:border-grey" v-model="form.classId" v-on:change="getUsersByClass">
                            <option selected disabled value="0">Selecteer je klas</option>
                            <option v-for="item in classes" :key="item.id" :value="item.id">{{item.name}}</option>
                        </select>
                        <div class="pointer-events-none absolute pin-y pin-r flex items-center px-2 text-grey-darker">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                        </div>
                    </div>
                </div>

                 <div class="mt-4" v-if="users.length > 0">
                    <div class="relative">
                        <select class="block appearance-none w-full bg-grey-lighter border border-grey-lighter text-grey-darker py-3 px-4 pr-8 leading-tight focus:outline-none focus:bg-white focus:border-grey" v-model="form.user">
                            <option selected disabled value="0">Selecteer je naam</option>
                            <option v-for="item in users"  :value="item">{{item.name}}</option>
                        </select>
                        <div class="pointer-events-none absolute pin-y pin-r flex items-center px-2 text-grey-darker">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                        </div>
                    </div>
                </div>


                <div class="mt-6" v-if="form.user !== 0">
                    <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-password">
                        Code
                    </label>
                    <input class="appearance-none block w-full bg-grey-lighter text-grey-darker border rounded border-grey-lighter py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-grey" id="grid-password" type="password" placeholder="******">
                </div>

                <button class="bg-blue hover:bg-blue-dark text-white font-bold py-2 px-4 focus:outline-none focus:shadow-outline mt-4 w-full" type="button" v-if="form.user !== 0">
                   Log in
                </button>

            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                classes: [],
                users: [],
                form: {
                    classId: 0,
                    user: 0,
                }
            }
        },

        mounted() {
            this.getClasses()
        },

        methods: {
            getClasses(){
                axios.get('/api/class').then((response)=>{
                    this.classes = response.data
                }).catch((error)=>{
                    console.log(error.response.data)
                });
            },

            getUsersByClass(){
                axios.post('/api/class/users', {classId: this.form.classId}).then((response)=>{
                    this.users = response.data
                }).catch((error)=>{
                    console.log(error.response.data)
                });
            }
        }
    }
</script>
