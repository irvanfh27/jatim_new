<template>
    <d-table :headers="headers" :config="config" :search="search">
    </d-table>
</template>
<script>
    export default {
        data: () => ({
            search: {},
            config: {
                title: 'PO',
                routeAdd: 'po.create',
                routeEdit: 'po.edit',
                routeDelete: false,
                urlAPI: 'po/po'
            },
        }),
        computed: {
            headers() {
                return [
                    {text: 'Actions', value: 'actions', sortable: false},
                    {
                        text: "Stockpile",
                        align: "left",
                        sortable: false,
                        value: "stockpile_name",
                        filter: f => {
                            if (!this.search.stockpile_name) return true;
                            return (f + '').toLowerCase().includes(this.search.stockpile_name.toLowerCase())
                        }
                    },
                    {
                        text: "Nomor PO",
                        value: "no_po",
                        filter: f => {
                            if (!this.search.no_po) return true;
                            return (f + '').toLowerCase().includes(this.search.no_po.toLowerCase())
                        }
                    },
                    {
                        text: "Tanggal",
                        value: "tanggal",
                        filter: f => {
                            if (!this.search.tanggal) return true;
                            return (f + '').toLowerCase().includes(this.search.tanggal.toLowerCase())
                        }
                    },
                    {
                        text: "Vendor",
                        value: "general_vendor_name",
                        filter: f => {
                            if (!this.search.general_vendor_name) return true;
                            return (f + '').toLowerCase().includes(this.search.general_vendor_name.toLowerCase())
                        }
                    },
                    {
                        text: "No Penawaran",
                        value: "no_penawaran",
                        filter: f => {
                            if (!this.search.no_penawaran) return true;
                            return (f + '').toLowerCase().includes(this.search.no_penawaran.toLowerCase())
                        }
                    },
                    {
                        text: "DPP",
                        value: "grandtotal",
                        filter: f => {
                            if (!this.search.grandtotal) return true;
                            return (f + '').toLowerCase().includes(this.search.grandtotal.toLowerCase())
                        }
                    },
                    {
                        text: "PPN",
                        value: "totalppn",
                        filter: f => {
                            if (!this.search.totalppn) return true;
                            return (f + '').toLowerCase().includes(this.search.totalppn.toLowerCase())
                        }
                    },
                    {
                        text: "PPH",
                        value: "totalpph",
                        filter: f => {
                            if (!this.search.totalpph) return true;
                            return (f + '').toLowerCase().includes(this.search.totalpph.toLowerCase())
                        }
                    },
                    {
                        text: "Total",
                        value: "totalall",
                        filter: f => {
                            if (!this.search.totalall) return true;
                            return (f + '').toLowerCase().includes(this.search.totalall.toLowerCase())
                        }
                    },
                    {
                        text: "Status",
                        value: "status_po",
                        filter: f => {
                            if (!this.search.status_po) return true;
                            return (f + '').toLowerCase().includes(this.search.status_po.toLowerCase())
                        }
                    },
                ];
            }
        },
    }

</script>
