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
                                    <v-btn color="primary" dark class="mb-1" @click="addData" v-if="config.routeAdd">
                                        Add Data
                                    </v-btn>
                                    <v-spacer></v-spacer>
                                </v-toolbar>
                            </template>
                            <template v-slot:item.actions="{ item }">
                                <v-icon
                                    small
                                    class="mr-2"
                                    @click="editItem(item)"
                                    v-if="config.routeEdit && item.status == 0  || item.status == 3"
                                >
                                    mdi-pencil
                                </v-icon>
                                <v-icon
                                    small
                                    @click="detailItem(item)"
                                    v-if="config.routeDetail"
                                >
                                    mdi-book
                                </v-icon>
                                <v-icon
                                    small
                                    @click="deleteItem(item)"
                                    v-if="config.routeDelete && item.status == 0"
                                >
                                    mdi-delete
                                </v-icon>
                                <v-icon
                                    small
                                    @click="printItem(item)"
                                    v-if="config.routePrint && item.status == 0"
                                >
                                    mdi-printer
                                </v-icon>

                            </template>
                            <template v-slot:no-data>
                                <div v-if="loading">
                                    <div class="text-center p-3 text-muted">
                                        <h5>No Results</h5>
                                        <p>Looks like you have not added any data yet!</p>
                                    </div>
                                </div>
                                <div v-else>
                                    <v-progress-circular
                                        :size="200"
                                        :width="20"
                                        color="green"
                                        indeterminate
                                    ></v-progress-circular>
                                </div>
                            </template>
                            <template v-slot:body.prepend>
                                <tr>
                                    <td></td>
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
            loading: false,
        }),
        created() {
            this.getData();
        },
        methods: {
            addData() {
                this.$router.push({name: this.config.routeAdd});
            },
            getData() {
                console.log("click")
                this.loading = false;
                axios.get(BaseUrl(this.config.urlAPI)).then(res => {
                    this.data = res.data;
                    this.loading = true;
                }).catch(e => {
                    console.log(e.response);
                });
            },
            editItem(item) {
                this.$router.push({name: this.config.routeEdit, params: {uuid: item.uuid}});
            },
            printItem(item) {
                this.$router.push({name: this.config.routePrint, params: {uuid: item.uuid}});
            },
            detailItem(item) {
                this.$router.push({name: this.config.routeDetail, params: {uuid: item.uuid}});
            },
            deleteItem(item) {
                Vue.swal({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        axios.post(BaseUrl(this.config.urlAPI) + '/' + item.uuid, {_method: 'DELETE'});
                        Vue.swal(
                            'Deleted!',
                            'Your data has been deleted.',
                            'success'
                        ).then((next) => {
                            this.getData();
                        });
                    }
                });
            }
        }
    }

</script>
