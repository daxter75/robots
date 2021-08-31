<template>
    <div>
        <div v-if="loading">Loadnig...</div>
        <div v-else>
            <div v-if="danceoffs.length === 0">
                <p>No Danceoffs.</p>
            </div>
            <div v-for="danceoff in danceoffs">
                <div class="mb-4 pl-4">
                    <p class="text-blue-600 text-sm md:text-base">
                        Danceoff {{ danceoff.id }}<br />
                        Winner: <span class="font-bold">{{ danceoff.winner.name }}</span>,
                        Loser: <span class="font-bold text-blue-400">{{ danceoff.loser.name }}</span>
                    </p>
                    <p class="text-gray-400 w-full text-xs">Danced at: <time>{{ formatDateTime(danceoff.dancedAt) }}</time></p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import moment from 'moment'

export default {
    name: "DanceoffsList",
    data() {
        return {
            loading: true,
            danceoffs: null
        }
    },
    props: [
        'endpoint'
    ],
    mounted() {
        axios.get(this.endpoint)
            .then(response => {
                this.danceoffs = response.data
                this.loading = false
            })
            .catch(error => {
                this.loading = false
                alert('Unable to fetch danceoffs.')
            })
    },
    methods: {
        formatDateTime(val) {
            return val ? moment(val).format('DD.MM.YYYY HH:mm:ss') : ''
        },
    }
}
</script>

<style scoped>

</style>
