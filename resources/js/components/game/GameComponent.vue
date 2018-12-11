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
                <span class="mt-1">{{user.group}}</span>
            </div>

            <div class="bg-white shadow-lg flex pr-5 items-center mr-5">
                <div class="bg-green text-white p-2 text-xs mr-5 flex items-center">
                <i class="fas fa-clock"></i>
                </div>
                <span class="mt-1">476 n.Chr.</span>
            </div>

            <div class="bg-white shadow-lg flex pr-5 items-center">
                <div class="bg-red text-white p-2 text-xs mr-5 flex items-center justify-center">
                <i class="fas fa-coins"></i>
                </div>
                <span class="mt-1">{{user.coins}}</span>
            </div>
        </div>

        <canvas id="isocanvas"></canvas>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                user: {
                    coins: 30,
                    group: '1B'
                }
            }
        },

        mounted() {
            Game.load()

            axios.get('/api/user')
            .then(response => {
                console.log(response.data);
            });
        },
    }
</script>
