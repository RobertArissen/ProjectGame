<template>
    <div>
        <div v-if="visible" class="h-screen w-full absolute flex items-center justify-center z-50">
            <div class="bg-white rounded shadow-lg p-8 m-4 max-h-full text-center overflow-y-scroll" style="width: 600px;">
                
                <h3 v-if="user.class">Klas: {{user.class.name}}</h3>

                <table class="table w-full mt-5 shadow">
                    <thead class="bg-blue-dark text-white">
                        <tr>
                        <th scope="col">#</th>
                        <th scope="col">Naam</th>
                        <th scope="col">Leger punten</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(classUser, index) in classUsers" v-bind:class="{ 'bg-blue-light': classUser.id === user.id }">
                            <th scope="row">{{parseInt(index)+1}}</th>
                            <td>{{classUser.name}}</td>
                            <td>{{classUser.soldiers}}</td>
                        </tr>
                    </tbody>
                </table>


                <div class="flex justify-center mt-8">
                    <button @click="closeModal()" class="flex-no-shrink text-white py-2 px-4 bg-red hover:bg-red-dark">Sluiten</button>
                </div>

            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['user'],

        data(){
            return {
                visible: false,
                classUsers: [],
            }
        },

        mounted() {
    
            EventBus.$on('openLeaderBoardModal', data => {
                this.init()
                this.visible = true
                Game.modalOpen = true
            })
        },

        methods: {
            init(){
                axios.post('/api/class/leaderboard', {classId: this.user.class.id}).then((response)=>{
                    this.classUsers = response.data
                }).catch((error)=>{
                    console.log(error.response.data)
                });
            },

            closeModal(){
                this.visible = false
                
                setTimeout(() => {
                    Game.modalOpen = false
                }, 500);

            },

        }
    }
</script>
