<template>
    <d-table :headers="headers" :config="config" :search="search">
    </d-table>
</template>
<script>
    export default {
        data: () => ({
            search: {},
            config: {
                title: 'Users',
                routeDelete: true,
                urlAPI: 'configuration/users'
            },
        }),
        computed: {
            headers() {
                return [
                    {text: 'Actions', value: 'actions', sortable: false},
                    {
                        text: "Name",
                        align: "left",
                        sortable: false,
                        value: "name",
                        filter: f => {
                            if (!this.search.name) return true;
                            return (f + '').toLowerCase().includes(this.search.name.toLowerCase())
                        }
                    },
                    {
                        text: "Email",
                        value: "email",
                        filter: f => {
                            if (!this.search.email) return true;
                            return (f + '').toLowerCase().includes(this.search.email.toLowerCase())
                        }
                    },
                    {
                        text: "Stockpile",
                        value: "stockpile_name",
                        filter: f => {
                            if (!this.search.stockpile_name) return true;
                            return (f + '').toLowerCase().includes(this.search.stockpile_name.toLowerCase())
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
