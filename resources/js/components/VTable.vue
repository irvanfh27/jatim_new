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
                                    <v-toolbar-title>{{ config.title }}</v-toolbar-title>
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
        props: ['headers', 'config', 'search'],
        data: () => ({
            data: [],

        }),
        created() {
            this.getData();
        },
        methods: {
            addData() {
                this.$router.push({name: this.config.routeAdd});
            },
            getData() {
                axios.get(BaseUrl(this.config.urlAPI)).then(res => {
                    this.data = res.data;
                    this.loading = true;
                    console.log(res);
                }).catch(e => {
                    console.log(e.response);
                });
            },
            editItem(item) {
                this.$router.push({name: this.config.routeEdit, params: {uuid: item.uuid}});
            },
            deleteItem(uuid) {

            }
        }
    }

</script>
