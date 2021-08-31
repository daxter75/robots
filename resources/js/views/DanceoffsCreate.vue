<template>
    <div>
        <h1 class="mb-4 text-2xl font-bold">Create two teams</h1>
        <p class="text-sm">Give a name of both teams. Choose 5 robots by every team.</p>
        <p class="text-xs">Robots with "out of order" are disabled and can't dance.</p>

        <div class="flex flex-row justify-around mt-2">
            <div class="w-1/2 lg:w-5/12 bg-blue-100 rounded-xl p-2 md:p-6 border border-blue-200">
                <p class="mb-1 text-blue-900 text-xs">Name of team A:</p>
                <input v-model="teamAname" class="w-full bg-blue-50 focus:bg-white mb-4 p-2 rounded text-blue-900" placeholder="Insert name of team A" />
                <div v-for="dancersA in teamA">
                    <div class="text-blue-900">
                        <input type="checkbox" :value="dancersA.id" v-model="checkedTeamA" :disabled="checkDisable(dancersA, checkedTeamB)">
                        <label :class="checkDisable(dancersA, checkedTeamB) ? 'text-gray-400 line-through' : ''" class="text-xs md:text-sm lg:text-base">{{ dancersA.id }}. {{ dancersA.name }}</label>
                    </div>
                </div>
                <p v-if="teamAname" class="pt-8 text-blue-700 text-xs md:text-sm">Team {{ teamAname }}: <span v-if="checkedTeamA.length" :class="checkedTeamA.length === 5 ? 'text-green-400' : 'text-red-400'">{{ checkedTeamA }}</span></p>
            </div>
            <div class="w-1/2 lg:w-5/12 bg-blue-100 rounded-xl p-2 md:p-6 border border-blue-200">
                <p class="mb-1 text-blue-900 text-xs">Name of team B:</p>
                <input v-model="teamBname" class="w-full bg-blue-50 focus:bg-white mb-4 p-2 rounded text-blue-900" placeholder="Insert name of team B" />
                <div v-for="dancersB in teamB">
                    <div class="text-blue-900">
                        <input type="checkbox" :value="dancersB.id" v-model="checkedTeamB" :disabled="checkDisable(dancersB, checkedTeamA)">
                        <label :class="checkDisable(dancersB, checkedTeamA) ? 'text-gray-400 line-through' : ''" class="text-xs md:text-sm lg:text-base">{{ dancersB.id }}. {{ dancersB.name }}</label>
                    </div>
                </div>
                <p v-if="teamBname" class="pt-8 text-blue-700 text-xs md:text-sm">Team {{ teamBname }}: <span v-if="checkedTeamB.length" :class="checkedTeamB.length === 5 ? 'text-green-400' : 'text-red-400'">{{ checkedTeamB }}</span></p>
            </div>
        </div>

        <div class="w-full my-4 text-center">
            <button @click="startDanceoff" class="bg-blue-900 text-blue-200 hover:text-white px-8 py-2 rounded" :disabled="btnDisabled">Let's dance</button>
        </div>

        <div v-if="matches" class="mt-4 w-full text-center">
            <p v-html="matches" class="py-2 text-blue-800 text-sm border border-blue-800 rounded"></p>
            <p v-html="teamWinner" class="mt-2 font-bold text-green-700 text-xl"></p>
        </div>

        <button @click="clearAll" v-if="btnDisabled" class="bg-blue-900 text-blue-200 hover:text-white px-8 py-2 rounded">Again?</button>
    </div>
</template>

<script>
export default {
    name: "DanceoffsCreate",
    data() {
        return {
            teamA: null,
            teamB: null,
            teamAname: '',
            teamBname: '',
            checkedTeamA: [],
            checkedTeamB: [],
            matches: '',
            teamWinner: '',
            btnDisabled: false,
        }
    },
    props: [
        'endpoint'
    ],
    mounted() {
        this.btnDisabled = false,
        axios.get('/api/robots')
            .then(response => {
                this.teamA = response.data
                this.teamB = response.data
                this.loading = false
            })
            .catch(error => {
                this.loading = false
                alert('Unable to fetch robots.')
            })
    },
    methods: {
        startDanceoff() {
            let lengthA = this.checkedTeamA.length
            let lengthB = this.checkedTeamB.length
            if (!this.teamAname || !this.teamBname) {
                alert('Insert names of both teams')
                return 0;
            }
            if (lengthA !== 5 || lengthB !== 5) {
                alert('Number of dancers are not correct')
                return 0;
            }

            let myJson = {danceoffs: {}}
            let myDanceoffs = []
            let pointsA = 0
            let pointsB = 0
            this.matches = 'RESULTS <br/>'
            for (let i = 0; i < 5; i++) {
                let obj = {}
                obj['winner'] = Math.random() < 0.5 ? this.checkedTeamA[i] : this.checkedTeamB[i]
                obj['opponents'] = [this.checkedTeamA[i], this.checkedTeamB[i]]
                this.matches += 'Dancer ' + this.checkedTeamA[i] + ' vs Dancer ' + this.checkedTeamB[i] + ', winner: ' + obj['winner'] + '<br />'
                parseInt(obj['winner']) === this.checkedTeamA[i] ? pointsA++ : pointsB++
                myDanceoffs.push(obj)
            }
            myJson.danceoffs = myDanceoffs

            this.teamWinner = 'Team '
            this.teamWinner += pointsA > pointsB ? this.teamAname : this.teamBname
            this.teamWinner += ' wins!'

            axios.post('/api/danceoffs', myJson)
                .then(response => {
                    this.resp = JSON.stringify(response)
                    console.log(this.resp)
                    this.btnDisabled = true
                })
                .catch(error => {
                    this.errorMessage = error.message;
                    console.error("There was an error!", error);
                });
        },

        checkDisable(team, checked) {
            return team.outOfOrder || (checked).includes(team.id)
        },

        clearAll() {
            this.teamAname =  ''
            this.teamBname =  ''
            this.checkedTeamA =  []
            this.checkedTeamB =  []
            this.matches =  ''
            this.teamWinner =  ''
            this.btnDisabled = false
        }
    }
}
</script>

<style scoped>

</style>
