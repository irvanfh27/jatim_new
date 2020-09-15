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
                    {
                        text: "Code",
                        align: "left",
                        sortable: false,
                        value: "code",
                        filter: f => {
                            if (!this.search.code) return true;
                            return (f + '').toLowerCase().includes(this.search.code.toLowerCase())
                        }
                    },
                    {
                        text: "Name",
                        value: "name",
                        filter: f => {
                            if (!this.search.name) return true;
                            return (f + '').toLowerCase().includes(this.search.name.toLowerCase())
                        }
                    },
                    {
                        text: "Address",
                        value: "address",
                        filter: f => {
                            if (!this.search.address) return true;
                            return (f + '').toLowerCase().includes(this.search.address.toLowerCase())
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
                    {text: 'Actions', value: 'actions', sortable: false},
                ];
            }
        },

    }

</script>
