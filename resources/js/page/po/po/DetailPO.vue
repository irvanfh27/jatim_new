<template>
    <v-app id="inspire">
        <v-form>
            <v-card>
                <v-card-title>
                    <span class="headline">Detail PO</span>
                </v-card-title>
                <v-card-text>
                    <v-container>
                        <v-row>
                            <v-col cols="12" md="4" v-for="(form, idx) in headers" v-bind:key="idx">
                                <v-text-field
                                    v-model="data[form.value]"
                                    :label="form.text"
                                    readonly
                                />
                            </v-col>
                            <v-col cols="12">
                                <v-simple-table fixed-header height="300px" v-if="data.po_details.length > 0">
                                    <template v-slot:default>
                                        <thead>
                                        <tr>
                                            <th class="text-left">Shipment No</th>
                                            <th class="text-left">Stockpile</th>
                                            <th class="text-left">Keterangan</th>
                                            <th class="text-left">Uom</th>
                                            <th class="text-left">Qty</th>
                                            <th class="text-left">Harga</th>
                                            <th class="text-left">DPP</th>
                                            <th class="text-left">PPN</th>
                                            <th class="text-left">PPH</th>
                                            <th class="text-left">Total</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="(item, idx) in data.po_details" :key="item.idx">
                                            <td>{{ item.shipment_no }}</td>
                                            <td>{{ item.stockpile }}</td>
                                            <td>{{ item.item_name}}</td>
                                            <td>{{ item.uom_type}}</td>
                                            <td>{{ item.qty}}</td>
                                            <td>{{ item.harga}}</td>
                                            <td>{{ item.amount}}</td>
                                            <td>{{ item.ppn}}</td>
                                            <td>{{ item.pph}}</td>
                                            <td>{{ item.grandtotal}}</td>
                                        </tr>
                                        </tbody>
                                    </template>
                                </v-simple-table>
                            </v-col>
                        </v-row>
                    </v-container>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <d-back-button/>
                    <div class="my-2">
                        <v-btn depressed color="error" v-on:click="updateStatus(4)">Cancel</v-btn>
                    </div>&nbsp;
                    <div class="my-2">
                        <v-btn depressed color="warning" v-on:click="updateStatus(3)">Reject</v-btn>
                    </div>&nbsp;
                    <div class="my-2">
                        <v-btn depressed color="success" v-on:click="updateStatus(1)">Approve</v-btn>
                    </div>
                </v-card-actions>
            </v-card>
        </v-form>
    </v-app>
</template>


<script>
    export default {
        // props: ["forms", "config"],
        data() {
            return {
                data: {},
                errors: [],
                loadingSubmit: false,
                loading: false,
                modal: false,
            };
        },
        mounted() {
            this.getData();
        },
        methods: {
            getData() {
                if (this.$route.params.uuid) {
                    axios.get(this.$parent.MakeUrl("po/po/" + this.$route.params.uuid)).then(res => {
                        this.data = res.data;
                        console.log(res);
                    });
                }
            },
            updateStatus(status) {
                Vue.swal({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Confirm it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        axios.post(BaseUrl("po/updateStatusPO?status=" + status + "&uuid=" + this.$route.params.uuid));
                        Vue.swal(
                            'Confirmed!',
                            'Your data has been Approved/Rejected.',
                            'success'
                        ).then((next) => {
                            window.history.length > 1 ? this.$router.go(-1) : this.$router.push('/')
                        });
                    }
                });
            }
        },
        computed: {
            headers() {
                return [
                    {
                        text: "Stockpile",
                        align: "left",
                        sortable: false,
                        value: "stockpile_name",
                    },
                    {
                        text: "Nomor PO",
                        value: "no_po",
                    },
                    {
                        text: "Tanggal",
                        value: "tanggal",
                    },
                    {
                        text: "Vendor",
                        value: "general_vendor_name",
                    },
                    {
                        text: "No Penawaran",
                        value: "no_penawaran",
                    },
                    {
                        text: "DPP",
                        value: "grandtotal",
                        type: "numeric"
                    },
                    {
                        text: "PPN",
                        value: "totalppn",
                    },
                    {
                        text: "PPH",
                        value: "totalpph",

                    },
                    {
                        text: "Total",
                        value: "totalall",
                    },
                    {
                        text: "Status",
                        value: "status_po",
                    },
                ];
            }
        },
    }
</script>

<style scoped>

</style>
