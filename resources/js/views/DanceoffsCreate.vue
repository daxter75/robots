<template>
    <div>
        <h1 class="mb-4 text-2xl font-bold">Create two teams</h1>
        <p>Choose 5 robots by every team. Robots with "out of order" are disabled and can't dance.</p>
        <div class="flex flex-row">
            <div>
                <input v-model="teamAname" placeholder="Insert a name of team A" />
                <div v-for="dancersA in teamA">
                    <div class="pl-4">
                        <input type="checkbox" :value="dancersA.id" v-model="checkedTeamA" :disabled="checkDisable(dancersA, checkedTeamB)">
                        <label :class="checkDisable(dancersA, checkedTeamB) ? 'text-gray-400 line-through' : ''">{{ dancersA.id }}. {{ dancersA.name }}</label>
                    </div>
                </div>
                <p>{{ teamAname }} <span :class="checkedTeamA.length === 5 ? 'text-green-400' : 'text-red-400'">{{ checkedTeamA }}</span></p>
            </div>
            <div>
                <input v-model="teamBname"  placeholder="Insert a name of team B" />
                <div v-for="dancersB in teamB">
                    <div class="pl-4">
                        <input type="checkbox" :value="dancersB.id" v-model="checkedTeamB" :disabled="checkDisable(dancersB, checkedTeamA)">
                        <label :class="checkDisable(dancersB, checkedTeamA) ? 'text-gray-400 line-through' : ''">{{ dancersB.id }}. {{ dancersB.name }}</label>
                    </div>
                </div>
                <p>{{ teamBname }} <span :class="checkedTeamB.length === 5 ? 'text-green-400' : 'text-red-400'">{{ checkedTeamB }}</span></p>
            </div>
        </div>
        <button @click="startDanceoff" :disabled="btnDisabled">Let's dance</button>
        <p v-html="matches"></p>
        <p v-html="teamWinner"></p>
        <button @click="clearAll" v-if="btnDisabled">Again?</button>
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
            if (lengthA !== 5 || lengthB !== 5) {
                alert('Number of dancers are not correct')
                return 0;
            }

            let myJson = {danceoffs: {}}
            let myDanceoffs = []
            let pointsA = 0
            let pointsB = 0
            for (let i = 0; i < 5; i++) {
                let obj = {}
                obj['winner'] = Math.random() < 0.5 ? this.checkedTeamA[i] : this.checkedTeamB[i]
                obj['opponents'] = [this.checkedTeamA[i], this.checkedTeamB[i]]
                this.matches += 'Dancer ' + this.checkedTeamA[i] + ' vs Dancer ' + this.checkedTeamB[i] + ', winner: ' + obj['winner'] + '<br />'
                parseInt(obj['winner']) === this.checkedTeamA[i] ? pointsA++ : pointsB++
                myDanceoffs.push(obj)
            }
            myJson.danceoffs = myDanceoffs

            this.teamWinner = pointsA > pointsB ? this.teamAname : this.teamBname
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
