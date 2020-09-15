<template>
    <d-forms :forms="forms" :config="config"/>
</template>

<script>
    export default {
        data() {
            return {
                config: {
                    title: "Add Freight Group",
                    url: this.$parent.MakeUrl('configuration/freight-group'),
                },
                forms: [
                    {
                        label: 'Group Name',
                        model: 'group_name',
                        mandatory: true,
                    },
                ],
            };
        }
    }
</script>

<style scoped>

</style>
