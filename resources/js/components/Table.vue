<template>
    <div class="row mt">
        <div class="col-sm-12">
            <section class="panel">
                <header class="panel-heading wht-bg">
                    <h4 class="gen-case">
                        {{ config.title }}
                        <div class="pull-right mail-src-position">
                            <div class="input-append">
                                <input type="text" class="form-control" placeholder="Search" v-on:keyup.enter="search"
                                       v-model="params.query">
                            </div>
                        </div>
                    </h4>
                </header>
                <div class="panel-body minimal" v-if="loading">
                    <div class="mail-option">
                        <router-link
                            v-if="config.route_create"
                            class="btn btn-theme"
                            :to="{ name: config.route_create }"
                        ><i class="fa fa-plus"></i> Add
                            Data
                        </router-link>
                        <ul class="unstyled inbox-pagination">
                            <li><span>1-50 of 99</span></li>
                            <li>
                                <a class="np-btn" href="#"><i class="fa fa-angle-left  pagination-left"></i></a>
                            </li>
                            <li>
                                <a class="np-btn" href="#"><i class="fa fa-angle-right pagination-right"></i></a>
                            </li>
                        </ul>
                    </div>
                    <table class="table table-bordered table-striped table-condensed cf">
                        <thead class="cf">
                        <tr>
                            <th>Action</th>
                            <th
                                v-for="column in columns"
                                style="overflow:hidden; white-space:nowrap"
                            >{{ column.title }}
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(item, index) in data">
                            <td v-if="config.action">
                                <router-link
                                    v-if="config.route_view"
                                    class="badge badge-primary"
                                    :to="{ name: config.route_view , params: { id: item.id }}"
                                >View
                                </router-link>

                                <router-link
                                    v-if="config.route_edit && item.status === 1 && item.is_printed === 0"
                                    class="badge badge-warning"
                                    :to="{ name: config.route_edit , params: { id: item.id }}"
                                >Edit
                                </router-link>

                                <router-link
                                    v-if="config.route_confirm"
                                    class="badge badge-warning"
                                    :to="{ name: config.route_confirm , params:{ id: item.id }}"
                                >Confirm
                                </router-link>
                                <button
                                    @click="replenish(item.id)"
                                    class="badge badge-warning"
                                    v-if="config.route_replenish && item.status === 3"
                                >Replenish
                                </button>
                            </td>
                            <td v-for="column in columns">
                                <span v-html="item[column.field]" v-if="column.type === 'html'"></span>
                                <p v-else-if="column.type === 'file'">
                                    <a
                                        href="#"
                                        class="badge badge-info"
                                        @click="showFile(item[column.field], item.file)"
                                        v-if="column.type === 'file' && item.file !== '' && item.file !== null"
                                    >{{ item.file }}</a>
                                </p>
                                <p
                                    v-else-if="column.type === 'price'"
                                >{{ item[column.field] | toIDR }}</p>
                                <p v-else>{{ item[column.field] }}</p>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="panel-body" v-else>
                    <d-loading/>
                </div>
            </section>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Table",
        props: ["columns", "config"],
        data() {
            return {
                user: {},
                perPages: ["5", "10", "25", "50", "100", "150", "300"],
                buttonClasses: "btn btn-primary",
                selected: [0],
                data: [],
                loading: false,
                pagination: {
                    current_page: 1
                },
                params: {
                    query: null,
                    start: null,
                    page: 1,
                    end: null,
                    perPage: 5
                }
            };
        },
        async mounted() {
            await this.getData();
            this.user = AuthUser;
        },
        methods: {
            async search() {
                this.loading = false;
                this.pagination = null;
                try {
                    await this.getData();
                    this.loading = true;
                } catch (e) {
                    console.log(e);
                }
            },
            async getData() {
                axios
                    .get(this.config.base_url, {
                        params: this.params
                        // params: {
                        //     query: this.params.query,
                        //     start: this.params.start,
                        //     end: this.params.end,
                        //     perPage: this.params.perPage,
                        //     page: this.pagination.current_page
                        // }
                    })
                    .then(res => {
                        this.data = res.data.data;
                        this.pagination = {
                            first: res.data.links.first,
                            last: res.data.links.last,
                            prev: res.data.links.prev,
                            next: res.data.links.next,
                            from: res.data.meta.from,
                            to: res.data.meta.to,
                            total: res.data.meta.total,
                            current_page: res.data.meta.current_page,
                            last_page: res.data.meta.last_page,
                            path: res.data.meta.path
                        };

                        this.loading = true;
                    })
                    .catch(e => {
                        if (e.response.status === 500) {
                            this.getData();
                        }
                        console.log(e.response);
                    });
            },
            changePage(page) {
                if (page > this.pagination.last_page) {
                    page = this.pagination.last_page;
                }
                this.params.page = page;
                this.getData();
            },
            print() {
                this.$router.push({
                    name: this.config.route_multiple_print,
                    query: {id: this.selected}
                });
            }
        },
        computed: {
            selectAll: {
                get: function () {
                    return this.data
                        ? this.selected.length === this.data.length
                        : false;
                },
                set: function (value) {
                    let selected = [];
                    if (value) {
                        this.data.forEach(function (data) {
                            selected.push(data.id);
                        });
                    }
                    this.selected = selected;
                }
            }
        }
    }
</script>

<style scoped>

</style>
