<template>
    <div>
        <div class="fixed flex flex-row" style="left:50px; top: 20px">
            <div class="bg-white shadow-lg-lg flex pr-5 items-center mr-5 bg-blue text-white">
                <div class="bg-blue-dark text-white p-2 text-xs mr-5 flex items-center">
                <i class="fas fa-question"></i>
                </div>
                <span class="mt-1">Beantwoord vragen</span>
            </div>

            <div class="bg-white shadow-lg flex pr-5 items-center bg-green text-white">
                <div class="bg-green-dark text-white p-2 text-xs mr-5 flex items-center">
                <i class="fas fa-star"></i>
                </div>
                <span class="mt-1">Bekijk scorebord</span>
            </div>
        </div>

        <div class="fixed flex flex-row" style="right:50px; top: 20px">
            <div class="bg-white shadow-lg flex pr-5 items-center mr-5">
                <div class="bg-blue text-white p-2 text-xs mr-5 flex items-center">
                <i class="fas fa-users"></i>
                </div>
                <span class="mt-1" v-if="user.class">{{user.class.name}}</span>
            </div>

            <div class="bg-white shadow-lg flex pr-5 items-center mr-5">
                <div class="bg-green text-white p-2 text-xs mr-5 flex items-center">
                <i class="fas fa-clock"></i>
                </div>
                <span class="mt-1">{{period.name}}</span>
            </div>

            <div class="bg-white shadow-lg flex pr-5 items-center">
                <div class="bg-red text-white p-2 text-xs mr-5 flex items-center justify-center">
                <i class="fas fa-coins"></i>
                </div>
                <span class="mt-1">{{user.coins}}</span>
            </div>
        </div>

        <buy-houses-compontent :period="period" :user="user"></buy-houses-compontent>
        
        <canvas id="isocanvas"></canvas>

        <notifications group="notify" />
    </div>
</template>

<script>
    export default {
        data(){
            return {
                user: {},
                period: {}
            }
        },

        mounted() {
            Game.load()
            this.loadUser();

            EventBus.$on('reloadUserData', data => this.loadUser()) 
        },

        methods: {
            loadUser(){
                console.log('hee')
                axios.get('/api/user')
                .then(response => {
                    this.user = response.data;
                    
                    this.loadBuildings()

                    return response.data
                }).then((user) => {
                    axios.get('/api/period/' + user.class.periods_id)
                        .then(response => {
                            this.period = response.data;
                        })
                });
            },
            
            loadBuildings(){
                axios.get('/api/user/buildings')
                    .then(response => {
                        const result = response.data;

                        Object.keys(result).forEach(function(key) {
                            EventBus.$emit('addBuilding', result[key])
                        });
                    })
            },
        }
    }
</script>
