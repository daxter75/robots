<template>
    <div>
        <div v-if="loading">Loadnig...</div>
        <div v-else>
            <div v-if="robots.length === 0">
                <p>No robots.</p>
            </div>
            <div v-for="robot in robots">
                <router-link :to="'/robots/' + robot.id" class="flex items-center border-b border-gray-200 p-4 hover:bg-blue-50 focus:outline-none">
                    <div class="pl-4">
                        <p class="text-blue-600 w-full">{{ robot.name}}</p>
                        <p class="text-gray-400 text-xs">
                            Powermove: <span class="font-bold">{{ robot.powermove}}</span>,
                            Experience: <span class="font-bold">{{ robot.experience }}</span>
                        </p>
                    </div>
                </router-link>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "RobotsList",
    data() {
        return {
            loading: true,
            robots: null
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
            alert('Unable to fetch robots.')
        })
    }
}
</script>

<style scoped>

</style>
