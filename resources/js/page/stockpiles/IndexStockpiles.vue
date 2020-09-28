<template>
    <d-table :headers="headers" :config="config" :search="search">
    </d-table>
</template>
<script>
    export default {
        data: () => ({
            config: {
                title: 'Stockpiles',
                routeAdd: 'stockpiles.create',
                routeEdit: 'stockpiles.edit',
                urlAPI: 'configuration/stockpiles'
            },
            search: {}

        }),
        computed: {
            headers() {
                return [
                    {text: 'Actions', value: 'actions', sortable: false},
                    {
                        text: "Code",
                        align: "left",
                        sortable: false,
                        value: "stockpile_code",
                        filter: f => {
                            if (!this.search.stockpile_code) return true;
                            return (f + '').toLowerCase().includes(this.search.stockpile_code.toLowerCase())
                        }
                    },
                    {
                        text: "Name",
                        value: "stockpile_name",
                        filter: f => {
                            if (!this.search.stockpile_name) return true;
                            return (f + '').toLowerCase().includes(this.search.stockpile_name.toLowerCase())
                        }
                    },
                    {
                        text: "Address",
                        value: "stockpile_address",
                        filter: f => {
                            if (!this.search.stockpile_address) return true;
                            return (f + '').toLowerCase().includes(this.search.stockpile_address.toLowerCase())
                        }
                    },
                    {
                        text: "Status",
                        value: "status",
                        filter: f => {
                            if (!this.search.status) return true;
                            return (f + '').toLowerCase().includes(this.search.status.toLowerCase())
                        }
                    },
                ];
            }
        },

    }

</script>
