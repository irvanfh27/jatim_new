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
                                    <v-btn color="primary" dark class="mb-1" @click="addData">
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
                                <v-progress-circular
                                    :size="200"
                                    :width="20"
                                    color="green"
                                    indeterminate
                                ></v-progress-circular>
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
