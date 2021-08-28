<template>
    <div class="h-screen bg-white">
        <div class="flex">
            <div class="hidden sm:block pl-6 bg-gray-200 w-48 h-screen">
                <nav class="pt-4">
                    <router-link to="/" class="flex items-center py-2 hover:text-indigo-600 text-sm">HOME</router-link>
                    <p class="pt-12 text-gray-500 text-xs uppercase font-bold">ROBOTS</p>
                    <router-link to="/robots" class="flex items-center py-2 hover:text-indigo-600 text-sm">Robot list</router-link>
                </nav>
            </div>
            <div class="flex flex-col flex-1 h-screen overflow-y-hidden">
                <div class="h-20 md:h-16 bg-gray-200 md:flex flex-row-reverse items-center justify-end md:justify-between">
                    <div class="flex p-2 items-center w-full justify-end">
                        RoboDance
                    </div>
                    <div class="px-4 py-2 bg-gradient-to-r from-indigo-700 text-white font-bold to-transparent rounded-tl-xl md:gray-200 md:w-full md:rounded-l-xl md:py-4">
                        {{ title }}
                    </div>
                </div>
                <div class="flex flex-col overflow-y-hidden flex-1">
                    <router-view class="p-6 overflow-x-hidden"></router-view>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "App",
    data() {
        return {
            title: 'welcome',
        }
    },
    created() {
        this.title = this.$route.meta.title
    },
    watch: {
        $route(to, from) {
            this.title = to.meta.title
        },
    }
}

</script>

<style scoped>

</style>
