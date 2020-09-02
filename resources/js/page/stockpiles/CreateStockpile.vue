<template>
    <d-forms :forms="forms" :config="config"/>
</template>

<script>
    export default {
        name: "CreateStockpile",
        data() {
            return {
                config: {
                    title: "Add Stockpile",
                    url: this.$parent.MakeUrl('configuration/stockpiles'),
                },
                forms: [
                    {
                        title: 'Code',
                        model: 'code',
                        mandatory: true,
                    },
                    {
                        title: 'Name',
                        model: 'name',
                        mandatory: true,
                    },
                    {
                        title: 'Address',
                        model: 'address',
                        type: 'textarea',
                        placeholder: "",
                        mandatory: false,
                    },
                    {
                        title: 'Freight Weight Rule',
                        model: 'freight_weight_rule',
                        type: "option",
                        mandatory: true,
                        data: [
                            {
                                title: "Lowest",
                                value: 0,
                            },
                            {
                                title: "Send Weight",
                                value: 1,
                            },
                            {
                                title: "Netto Weight",
                                value: 2,
                            },
                        ],
                    },
                    {
                        title: 'Curah Weight Rule',
                        model: 'curah_weight_rule',
                        mandatory: true,
                        type: "option",
                        data: [
                            {
                                title: "Lowest",
                                value: 0,
                            },
                            {
                                title: "Send Weight",
                                value: 1,
                            },
                            {
                                title: "Netto Weight",
                                value: 2,
                            },
                        ],
                    },
                    {
                        title: 'Status',
                        model: 'active',
                        type: "option",
                        mandatory: true,
                        data: [
                            {
                                title: "Active",
                                value: 1,
                            },
                            {
                                title: "Inactive",
                                value: 0,
                            },
                        ],
                    }
                ],
            };
        }
    }
</script>

<style scoped>

</style>
