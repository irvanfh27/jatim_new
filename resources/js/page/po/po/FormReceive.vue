<template>
    <v-app id="inspire">
        <v-form>
            <v-card>
                <v-card-title>
                    <span class="headline">Receive PO</span>
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
                                <v-simple-table fixed-header height="300px">
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
                                            <th class="text-left">Qty Confirm</th>
                                            <th class="text-left" width="50px">Receive Date</th>
                                            <th class="text-left">Receiver</th>
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
                                            <td>
                                                <v-text-field
                                                    v-model="item.qty_confirm"
                                                />
                                            </td>
                                            <td width="50px">
                                                <v-text-field
                                                    v-model="item.receive_date"
                                                />
                                                <!--                                                <v-menu-->
                                                <!--                                                    v-model="date"-->
                                                <!--                                                    :close-on-content-click="false"-->
                                                <!--                                                    :nudge-right="40"-->
                                                <!--                                                    transition="scale-transition"-->
                                                <!--                                                    offset-y-->
                                                <!--                                                    min-width="290px"-->
                                                <!--                                                >-->
                                                <!--                                                    <template v-slot:activator="{ on, attrs }">-->
                                                <!--                                                        <v-text-field-->
                                                <!--                                                            v-model="item.receive_date"-->
                                                <!--                                                            label="Picker without buttons"-->
                                                <!--                                                            prepend-icon="event"-->
                                                <!--                                                            readonly-->
                                                <!--                                                            v-bind="attrs"-->
                                                <!--                                                            v-on="on"-->
                                                <!--                                                        ></v-text-field>-->
                                                <!--                                                    </template>-->
                                                <!--                                                    <v-date-picker v-model="item.receive_date"-->
                                                <!--                                                                   @input="date = false"></v-date-picker>-->
                                                <!--                                                </v-menu>-->
                                            <td>
                                                <v-text-field
                                                    v-model="item.receiver"
                                                />
                                            </td>
                                        </tr>
                                        </tbody>
                                    </template>
                                </v-simple-table>
                            </v-col>
                            <v-col cols="12">
                                <v-checkbox
                                    label="Checklist If All Items Have Been Received"
                                    value="1"
                                    v-model="checked"
                                />
                            </v-col>
                        </v-row>
                    </v-container>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <d-back-button/>
                    <div class="my-2">
                        <v-btn depressed color="success" v-on:click="submitForm()">Submit</v-btn>
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
                receive_date: [],
                checked: 0,
                date: false,
                model: '',
                po_details: []
            };
        },
        mounted() {
            this.getData();
        },
        methods: {
            async submitForm() {
                this.loadingSubmit = true;
                const payload = {
                    uuid: this.$route.params.uuid,
                    checked: this.checked,
                    _method: "PATCH",
                    po_details: this.po_details.map((item, idx) => ({
                        id: item.id,
                        qty_confirm: item.qty_confirm,
                        receive_date: item.receive_date,
                        receiver: item.receiver,
                    }))

                };
                try {
                    const res = await axios.post(this.$parent.MakeUrl("po/po-detail/confirm-receive-po"), payload);
                    Vue.swal({
                        icon: "success",
                        title: "Success!",
                        text: "Successfully Confirm PO!"
                    }).then(next => {
                        window.history.length > 1 ? this.$router.go(-1) : this.$router.push('/')
                    });
                    console.log(res);
                } catch (e) {
                    this.errors = e.response.data.errors;
                    this.loadingSubmit = false;
                    console.error(e.response.data);
                }
            },
            getData() {
                axios.get(this.$parent.MakeUrl("po/po/" + this.$route.params.uuid)).then(res => {
                    this.data = res.data;
                    this.po_details = res.data.po_details;
                    console.log(res);
                });
            },
            sendDate(val) {
                console.log(val);
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
                        axios.post(BaseUrl("po/po/updateStatus?status=" + status + "&uuid=" + this.$route.params.uuid));
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
