<template>
    <div>
        <div v-if="loading">Loadnig...</div>
        <div v-else>
            <div v-if="robots.length === 0">
                <p>No leaderboard list.</p>
            </div>
            <div v-for="(robot, index) in robots">
                <router-link :to="'/robots/' + robot.winner.id" class="mb-4 pl-4">
                    <p class="text-blue-600">
                        <span>{{ index+1 }}</span>.
                        <span class="font-bold">{{ robot.winner.name }}</span>,
                        <span class="text-gray-400">{{ robot.wins }}</span>
                            <span v-if="robot.wins > 1" class="text-gray-400"> wins</span>
                            <span v-else class="text-gray-400"> win</span>
                    </p>
                </router-link>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "LeaderboardList",
    data() {
        return {
            loading: true,
            robots: null,
            position: 0
        }
    },
    props: [
        'endpoint'
    ],
    mounted() {
        axios.get(this.endpoint)
            .then(response => {
                this.robots = response.data
                this.loading = false
            })
            .catch(error => {
                this.loading = false
                alert('Unable to fetch leaderboard list.')
            })
    },
}
</script>

<style scoped>

</style>
