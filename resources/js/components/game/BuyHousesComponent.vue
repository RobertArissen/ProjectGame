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
                                <div class="bg-red text-white p-2 text-xs mr-5 flex items-center justify-center">
                                    <i class="fas fa-coins"></i>
                                </div>
                                <span class="mt-1">{{building.price}}</span>
                            </div>

                            <button class="bg-white shadow-lg-lg flex pr-5 items-center mr-5 bg-blue hover:bg-blue-dark text-white w-full mt-2" v-if="user.coins >= building.price">
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
            }
        },

        mounted() {
            this.buildingMap = window.GameDataObject.building
            this.loadHouses()

            EventBus.$on('openBuyBuilding', data => {
                if(Game.buyModalOpen) this.visible = true
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
                    Game.buyModalOpen = false
                }, 500);

            }
        }
    }
</script>
