<template>
    <div>
        <div v-if="visible" class="h-screen w-full absolute flex items-center justify-center z-50">
            <div class="bg-white rounded shadow-lg p-8 m-4 max-h-full text-center overflow-y-scroll">
                
                <h3>{{period.name}}</h3>

                <div class="flex flex-row mt-4">
                    <div v-for="building in buildings" v-if="buildings" class="p-4 rounded shadow mr-1 bg-grey-lightest">
                        <img :src="buildingMap[building.index].img" class="h-24 w-24"/>
                        <div class="mt-4">
                            <h5>{{building.name}}</h5>
                            <div class="bg-white flex pr-5 items-center border mt-8">
                                <div class="bg-orange text-white p-2 text-xs mr-5 flex items-center justify-center">
                                    <i class="fas fa-coins"></i>
                                </div>
                                <span class="mt-1">{{building.price}}</span>
                            </div>

                            <div class="bg-white flex pr-5 items-center border mt-1">
                                <div class="bg-red text-white p-2 text-xs mr-5 flex items-center justify-center">
                                    <i class="fas fa-shield-alt"></i>
                                </div>
                                <span class="mt-1">{{building.soldiers}}</span>
                            </div>

                            <button class="bg-white shadow-lg-lg flex pr-5 items-center mr-5 bg-blue hover:bg-blue-dark text-white w-full mt-4" v-if="parseInt(user.coins) >= parseInt(building.price)"  @click="buyBuilding(building.index)">
                                <div class="bg-blue-dark text-white p-2 text-xs mr-5 flex items-center">
                                    <i class="fas fa-check"></i>
                                </div>
                                <span class="mt-1">Koop</span>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="flex justify-center mt-8">
                    <button @click="closeModal()" class="flex-no-shrink text-white py-2 px-4 bg-red hover:bg-red-dark">Sluiten</button>
                </div>

            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['user', 'period'],

        data(){
            return {
                visible: false,
                buildings: null,
                buildingMap: [],
                Xi: 0,
                Yi: 0
            }
        },

        mounted() {
            this.loadHouses()

            EventBus.$on('openBuyBuilding', data => {
                this.buildingMap = window.GameDataObject.building
                if(Game.modalOpen) this.visible = true
                this.Xi = data.Xi
                this.Yi = data.Yi
            })
        },

        methods: {
            loadHouses() {
                axios.get('/api/building')
                .then(response => {
                    this.buildings = response.data
                })
            },

            closeModal(){
                this.visible = false
                
                setTimeout(() => {
                    Game.modalOpen = false
                }, 500);

            },

            buyBuilding(index){
                axios.post('/api/user/buildings/buy', {buildingId: index, Xi: this.Xi, Yi: this.Yi})
                    .then(response => {
                        if(response.data.success){
                            EventBus.$emit('reloadUserData', true)

                            this.closeModal()

                            this.$notify({
                                group: 'notify',
                                type:'success',
                                title: 'Gekocht',
                                text: 'Je hebt het gebouw gekocht'
                            })


                        } else{
                            this.$notify({
                                group: 'notify',
                                type:'error',
                                title: 'Er is iets fout gegaan',
                                text: response.data.error
                            })
                        }
                    })
            },
        }
    }
</script>
