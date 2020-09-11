<template>
    <div class="row mt">
        <div class="col-sm-12">
            <section class="panel">
                <div class="panel-body minimal">
                    <v-app id="inspire">
                        <v-data-table
                            :headers="headers"
                            :items="data"
                            sort-by="code"
                            class="elevation-1"
                        >
                            <template v-slot:top>
                                <v-toolbar flat color="white">
                                    <v-toolbar-title>PO</v-toolbar-title>
                                    <v-divider
                                        class="mx-4"
                                        inset
                                        vertical
                                    ></v-divider>
                                    <v-btn
                                        color="primary"
                                        dark
                                        class="mb-1"
                                        @click="addData"
                                    >Add Data
                                    </v-btn>
                                    <v-spacer></v-spacer>
                                    <v-dialog v-model="dialog" max-width="500px">
                                        <!--                                        <template v-slot:activator>-->
                                        <!--                                            <v-btn-->
                                        <!--                                                color="primary"-->
                                        <!--                                                dark-->
                                        <!--                                                class="mb-2"-->
                                        <!--                                                @click="addData"-->
                                        <!--                                            >New Item-->
                                        <!--                                            </v-btn>-->
                                        <!--                                        </template>-->
                                        <v-card>
                                            <v-card-title>
                                                <span class="headline">{{ formTitle }}</span>
                                            </v-card-title>

                                            <v-card-text>
                                                <v-container>
                                                    <v-row>
                                                        <v-col cols="12" sm="6" md="4">
                                                            <v-text-field v-model="editedItem.name"
                                                                          label="Dessert name"></v-text-field>
                                                        </v-col>
                                                        <v-col cols="12" sm="6" md="4">
                                                            <v-text-field v-model="editedItem.calories"
                                                                          label="Calories"></v-text-field>
                                                        </v-col>
                                                        <v-col cols="12" sm="6" md="4">
                                                            <v-text-field v-model="editedItem.fat"
                                                                          label="Fat (g)"></v-text-field>
                                                        </v-col>
                                                        <v-col cols="12" sm="6" md="4">
                                                            <v-text-field v-model="editedItem.carbs"
                                                                          label="Carbs (g)"></v-text-field>
                                                        </v-col>
                                                        <v-col cols="12" sm="6" md="4">
                                                            <v-text-field v-model="editedItem.protein"
                                                                          label="Protein (g)"></v-text-field>
                                                        </v-col>
                                                    </v-row>
                                                </v-container>
                                            </v-card-text>

                                            <v-card-actions>
                                                <v-spacer></v-spacer>
                                                <v-btn color="blue darken-1" text @click="close">Cancel</v-btn>
                                                <v-btn color="blue darken-1" text @click="save">Save</v-btn>
                                            </v-card-actions>
                                        </v-card>
                                    </v-dialog>
                                </v-toolbar>
                            </template>
                            <template v-slot:item.actions="{ item }">
                                <v-icon
                                    small
                                    class="mr-2"
                                    @click="editItem(item)"
                                >
                                    mdi-pencil
                                </v-icon>
                                <v-icon
                                    small
                                    @click="deleteItem(item)"
                                >
                                    mdi-delete
                                </v-icon>
                            </template>
                            <template v-slot:no-data>
                                <v-btn color="primary" @click="getData">Reset</v-btn>
                            </template>
                            <template v-slot:body.prepend>
                                <tr>
                                    <td v-for="form in headers" v-if="form.filter">
                                        <v-text-field v-model="search[form.value]" type="text"
                                                      :label="form.text"></v-text-field>
                                    </td>
                                </tr>
                            </template>
                        </v-data-table>
                    </v-app>
                </div>
                <!--                <div class="panel-body" v-else>-->
                <!--                    <d-loading/>-->
                <!--                </div>-->
            </section>
        </div>
    </div>
</template>
<script>
    export default {
        data: () => ({
            dialog: false,
            data: [],
            editedIndex: -1,
            editedItem: {
                code: '',
                name: 0,
                address: 0,
                status: 0,
            },
            defaultItem: {
                code: '',
                name: 0,
                address: 0,
                status: 0,
            },
            search: {}

        }),
        computed: {
            formTitle() {
                return this.editedIndex === -1 ? 'New Item' : 'Edit Item'
            },
            headers() {
                return [
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
                    {text: 'Actions', value: 'actions', sortable: false},
                ];
            }
        },
        watch: {
            dialog(val) {
                val || this.close()
            },
        },
        created() {
            this.getData();
        },
        methods: {
            addData() {
                this.$router.push({name: 'po.create'});
            },
            getData() {
                axios.get(this.$parent.MakeUrl('po/po')).then(res => {
                    this.data = res.data;
                    this.loading = true;
                    console.log(res);
                }).catch(e => {
                    console.log(e.response);
                });
            },
            editItem(item) {
                console.log(item);
                this.editedIndex = this.data.indexOf(item)
                this.editedItem = Object.assign({}, item)
                this.dialog = true
            },
            deleteItem(item) {
                const index = this.data.indexOf(item)
                confirm('Are you sure you want to delete this item?') && this.data.splice(index, 1)
            },
            close() {
                this.dialog = false
                this.$nextTick(() => {
                    this.editedItem = Object.assign({}, this.defaultItem)
                    this.editedIndex = -1
                })
            },

            save() {
                if (this.editedIndex > -1) {
                    Object.assign(this.data[this.editedIndex], this.editedItem)
                } else {
                    this.data.push(this.editedItem)
                }
                this.close()
            },
        }
    }

</script>
