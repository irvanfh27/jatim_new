<template>
    <button class="btn btn-dark" v-on:click="goBack">Back</button>
</template>

<script>
    export default {
        name: "BackButtonComponent",
        methods: {
            goBack() {
                window.history.length > 1 ? this.$router.go(-1) : this.$router.push('/')
            }
        }
    }
</script>

<style scoped>

</style>
