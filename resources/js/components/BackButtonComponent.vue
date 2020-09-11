<template>
    <div class="my-2">
        <v-btn depressed v-on:click="goBack">Back</v-btn>
    </div>
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
