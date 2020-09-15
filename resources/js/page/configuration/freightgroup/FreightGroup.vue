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
                                    <v-toolbar-title>Freight Group</v-toolbar-title>
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
                        text: "Freight Group Id",
                        align: "left",
                        sortable: false,
                        value: "freight_group_id",
                        filter: f => {
                            if (!this.search.freight_group_id) return true;
                            return (f + '').toLowerCase().includes(this.search.freight_group_id.toLowerCase())
                        }
                    },
                    {
                        text: "Group Name",
                        align: "left",
                        sortable: false,
                        value: "group_name",
                        filter: f => {
                            if (!this.search.group_name) return true;
                            return (f + '').toLowerCase().includes(this.search.group_name.toLowerCase())
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
                this.$router.push({name: 'freightgroup.create'});
            },
            getData() {
                axios.get(this.$parent.MakeUrl('configuration/freight-group')).then(res => {
                    this.data = res.data;

                    this.loading = true;
                    console.log(res);
                }).catch(e => {
                    console.log(e.response);
                });
            }
        }
    }

</script>
