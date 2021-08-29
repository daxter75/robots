<template>
    <robots-list :endpoint="'/api/robots'"></robots-list>
</template>

<script>
import RobotsList from "../components/RobotsList";

export default {
    name: "RobotsIndex",
    components: {
        'robots-list': RobotsList
    }
}
</script>

<style scoped>

</style>
