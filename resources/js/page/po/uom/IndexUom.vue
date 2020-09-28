<template>
    <d-table :headers="headers" :config="config" :search="search">
    </d-table>
</template>
<script>
    export default {
        data: () => ({
            search: {},
            config: {
                title: 'UOM',
                routeDelete: true,
                urlAPI: 'po/uom'
            },
        }),
        computed: {
            headers() {
                return [
                    {text: 'Actions', value: 'actions', sortable: false},
                    {
                        text: "Uom Type",
                        align: "left",
                        value: "uom_type",
                        filter: f => {
                            if (!this.search.uom_type) return true;
                            return (f + '').toLowerCase().includes(this.search.uom_type.toLowerCase())
                        }
                    },
                    {
                        text: "Entry Date",
                        value: "entry_date",
                    },
                ];
            }
        },
    }

</script>
