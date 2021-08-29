<template>
    <danceoffs-list :endpoint="'/api/danceoffs/populated'"></danceoffs-list>
</template>

<script>
import DanceoffsList from "../components/DanceoffsList";

export default {
    name: "DanceoffsIndex",
    components: {
        'danceoffs-list': DanceoffsList
    }
}
</script>

<style scoped>

</style>
