<template>
    <div>
        <div v-if="loading">Loadnig...</div>
        <div v-else>
            <article class="max-w-4xl mx-auto lg:grid lg:grid-cols-12 gap-x-10 rounded-xl bg-blue-100 border border-gray-200">
                <div class="col-span-2 lg:text-center lg:pt-6 mb-4">
                    <img :src="robot.avatar" alt="" class="rounded-xl">
                </div>

                <div class="col-span-10 ml-2">
                    <h1 class="font-bold text-2xl lg:text-3xl my-4">
                        {{ robot.name }}
                    </h1>

                    <div class="space-y-2 text-base mb-4">
                        <p>Powermove: {{ robot.powermove }}</p>
                        <p>Experience: {{ robot.experience }}</p>
                        <p v-if="!robot.outOfOrder">Not out of order</p>
                        <p v-else class="text-red-600">Out of order</p>
                    </div>
                </div>

            </article>
        </div>
    </div>
</template>

<script>
export default {
    name: "RobotsShow",
    data() {
        return {
            loading: true,
            robot: null
        }
    },
    mounted() {
        axios.get('/api/robots/' + this.$route.params.id)
            .then(response => {
                this.robot = response.data
                this.loading = false
            })
            .catch(error => {
                this.loading = false
                if (error.response.status === 404) {
                    this.$router.push('/robots')
                }
            })
    },
}
</script>

<style scoped>

</style>
