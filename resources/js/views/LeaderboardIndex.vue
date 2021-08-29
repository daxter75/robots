<template>
    <leaderboard-list :endpoint="'/api/leaderboard'"></leaderboard-list>
</template>

<script>
import LeaderboardList from "../components/LeaderboardList";

export default {
    name: "LeaderboardIndex",
    components: {
        'leaderboard-list': LeaderboardList
    }
}
</script>

<style scoped>

</style>
