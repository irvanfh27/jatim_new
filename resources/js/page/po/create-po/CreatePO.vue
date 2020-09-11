<template>
    <v-app id="inspire">
        <v-form v-model="valid" v-if="!loading">
            <v-card>
                <v-card-title>
                    <span class="headline">Create PO</span>
                </v-card-title>
                <v-card-text>
                    <v-container>
                        <v-row>
                            <v-col cols="12" md="4">
                                <v-text-field
                                    v-model="form.noPO"
                                    label="Generate PO NO."
                                    required
                                    readonly
                                ></v-text-field>
                            </v-col>

                            <v-col cols="12" md="4">
                                <v-text-field
                                    v-model="form.noPenawaran"
                                    :rules="nameRules"
                                    label="No Penawaran"
                                    required
                                ></v-text-field>
                            </v-col>

                            <v-col cols="12" sm="6" md="4">
                                <v-dialog
                                    ref="dialog"
                                    v-model="modal"
                                    :return-value.sync="date"
                                    persistent
                                    width="290px"
                                >
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-text-field
                                            v-model="date"
                                            label="Tanggal PO"
                                            prepend-icon="event"
                                            readonly
                                            v-bind="attrs"
                                            v-on="on"
                                        ></v-text-field>
                                    </template>
                                    <v-date-picker v-model="date" scrollable>
                                        <v-spacer></v-spacer>
                                        <v-btn text color="primary" @click="modal = false">Cancel</v-btn>
                                        <v-btn text color="primary" @click="$refs.dialog.save(date)">OK
                                        </v-btn>
                                    </v-date-picker>
                                </v-dialog>
                            </v-col>

                            <v-col cols="12" sm="6">
                                <v-autocomplete
                                    :items="data.signs"
                                    v-model="form.checkBy"
                                    item-text="name"
                                    item-value="idmaster_sign"
                                    label="Check By"
                                ></v-autocomplete>
                            </v-col>

                            <v-col cols="12" sm="6">
                                <v-autocomplete
                                    :items="data.currency"
                                    v-model="form.currency"
                                    item-text="currency_name"
                                    item-value="currency_id"
                                    label="Currency"
                                ></v-autocomplete>
                            </v-col>
                            <v-col cols="12" sm="6">
                                <v-autocomplete
                                    :items="data.vendors"
                                    v-model="form.vendorId"
                                    item-text="general_vendor_name"
                                    item-value="general_vendor_id"
                                    @change="getVendorBank"
                                    label="Vendor"
                                ></v-autocomplete>
                            </v-col>
                            <v-col cols="12" sm="6">
                                <v-autocomplete
                                    :items="data.vendorBank"
                                    v-model="form.vendorBankId"
                                    item-text="bank_name"
                                    item-value="gv_bank_id"
                                    label="Vendor Bank"
                                    v-if="form.vendorId">
                                </v-autocomplete>
                            </v-col>
                            <!--                            Modal Add Data-->
                            <v-col cols="12" sm="6" v-if="form.vendorId">
                                <v-dialog v-model="dialog" persistent max-width="600px">
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-btn
                                            color="warning"
                                            dark
                                            v-bind="attrs"
                                            v-on="on"
                                        >
                                            Add Data
                                        </v-btn>
                                    </template>
                                    <v-card>
                                        <v-card-title>
                                            <span class="headline">Insert New</span>
                                        </v-card-title>
                                        <v-card-text>
                                            <v-container>
                                                <v-row>
                                                    <v-col cols="12" sm="6" md="4">
                                                        <v-autocomplete
                                                            :items="data.stockpiles"
                                                            v-model="formModal.stockpileId"
                                                            item-text="name"
                                                            item-value="stockpile_id"
                                                            label="Stockpiles"
                                                        >
                                                        </v-autocomplete>
                                                    </v-col>
                                                    <v-col cols="12" sm="6" md="4">
                                                        <v-autocomplete
                                                            :items="data.shipments"
                                                            v-model="formModal.shipmentId"
                                                            item-text="shipment_no"
                                                            item-value="shipment_id"
                                                            label="Shipment Code"
                                                        >
                                                        </v-autocomplete>
                                                    </v-col>
                                                    <v-col cols="12" sm="6" md="4">
                                                        <v-autocomplete
                                                            :items="data.groupItems"
                                                            v-model="formModal.groupItemId"
                                                            item-text="group_name"
                                                            item-value="idmaster_groupitem"
                                                            @change="getItems"
                                                            label="Group Item"
                                                        >
                                                        </v-autocomplete>
                                                    </v-col>

                                                    <v-col cols="12" sm="6">
                                                        <v-autocomplete
                                                            :items="data.items"
                                                            v-model="formModal.itemId"
                                                            item-text="item_full"
                                                            item-value="idmaster_item"
                                                            label="Items"
                                                            v-if="formModal.groupItemId"
                                                        >
                                                        </v-autocomplete>
                                                    </v-col>

                                                    <v-col cols="12">
                                                        <v-text-field
                                                            v-model="formModal.qty"
                                                            label="Qty"
                                                            required
                                                        ></v-text-field>
                                                    </v-col>

                                                    <v-col cols="12">
                                                        <v-text-field
                                                            v-model="formModal.unitPrice"
                                                            label="Unit Price"
                                                            required
                                                        ></v-text-field>
                                                    </v-col>

                                                    <v-col cols="12">
                                                        <v-text-field
                                                            v-model="totalAmount"
                                                            label="Amount"
                                                            readonly
                                                        ></v-text-field>
                                                    </v-col>
                                                    <v-col cols="12">
                                                        <v-text-field
                                                            v-model="totalPPN"
                                                            label="PPN"
                                                            readonly
                                                        ></v-text-field>
                                                    </v-col>
                                                    <v-col cols="12" sm="6">
                                                        <v-autocomplete
                                                            :items="data.pph"
                                                            v-model="formModal.pph"
                                                            item-text="tax_name"
                                                            item-value="pph_tax_id"
                                                            label="PPH"
                                                        >
                                                        </v-autocomplete>
                                                    </v-col>
                                                </v-row>
                                            </v-container>
                                            <small>*indicates required field</small>
                                        </v-card-text>
                                        <v-card-actions>
                                            <v-spacer></v-spacer>
                                            <v-btn color="blue darken-1" text @click="dialog = false">Close</v-btn>
                                            <v-btn color="blue darken-1" text @click="dialog = false">Save</v-btn>
                                        </v-card-actions>
                                    </v-card>
                                </v-dialog>
                            </v-col>
                            <v-col cols="12">
                                <v-simple-table fixed-header height="300px" v-if="form.poDetails.length">
                                    <template v-slot:default>
                                        <thead>
                                        <tr>
                                            <th class="text-left">Shipment Code</th>
                                            <th class="text-left">Stockpile</th>
                                            <th class="text-left">Keterangan</th>
                                            <th class="text-left">Qty</th>
                                            <th class="text-left">Harga</th>
                                            <th class="text-left">DPP</th>
                                            <th class="text-left">PPN</th>
                                            <th class="text-left">PPH</th>
                                            <th class="text-left">Total</th>
                                            <th class="text-left">Action</th>

                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="item in form.poDetails" :key="item.name">
                                            <td>{{ item.shipmentCode }}</td>
                                            <td>{{ item.stockpile }}</td>
                                        </tr>
                                        </tbody>
                                    </template>
                                </v-simple-table>
                            </v-col>
                            <v-col cols="12">
                                <v-textarea
                                    label="Remarks"
                                    v-model="form.remarks"
                                >
                                </v-textarea>
                            </v-col>
                            <v-col cols="12">
                                <v-textarea
                                    label="Terms of Condition"
                                    v-model="form.termsOfCondition"
                                >
                                </v-textarea>
                            </v-col>
                        </v-row>
                    </v-container>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <div class="my-2">
                        <v-btn depressed>Back</v-btn>
                    </div>
                    <div class="my-2">
                        <v-btn depressed color="primary">Submit</v-btn>
                    </div>
                </v-card-actions>
            </v-card>
        </v-form>
        <div class="text-center" v-else>
            <v-progress-circular
                :size="200"
                :width="20"
                color="green"
                indeterminate
            ></v-progress-circular>
        </div>
    </v-app>
</template>


<script>
    export default {
        name: "CreatePO",
        data() {
            return {
                dialog: false,
                data: {
                    signs: [],
                    currency: [],
                    vendors: [],
                    stockpiles: [],
                    vendorBank: [],
                    shipments: [],
                    groupItems: [],
                    items: [],
                    pph: [],
                    ppn: {}
                },
                errors: [],
                loadingSubmit: false,
                loading: true,
                valid: false,
                modal: false,
                model: null,
                formModal: {
                    stockpileId: 0,
                    shipmentId: 0,
                    groupItemId: 0,
                    itemId: 0,
                    qty: 0,
                    unitPrice: 0,
                    amount: 0,
                    ppn: 0,
                    pph: '',
                    checkPPN: null
                },
                form: {
                    vendorId: 0,
                    vendorBankId: 0,
                    noPO: '',
                    noPenawaran: '',
                    checkBy: 0,
                    remarks: '',
                    termsOfCondition: '',
                    poDetails: []
                },

                date: '',
                nameRules: [
                    v => !!v || 'Name is required',
                    v => v.length <= 10 || 'Name must be less than 10 characters',
                ],
                email: '',
                emailRules: [
                    v => !!v || 'E-mail is required',
                    v => /.+@.+/.test(v) || 'E-mail must be valid',
                ],
            };
        },
        mounted() {
            this.getData();
        },
        methods: {
            async submitForm() {
                this.loadingSubmit = true;
                const payload = {
                    items: this.orders_detail.map((item, idx) => ({
                        skuid: item.skuid,
                        qty: item.qty,
                        notes: item.notes
                    })),
                };
                try {
                    const res = await axios.post(this.config.url, payload);
                    Vue.swal({
                        icon: "success",
                        title: "Success!",
                        text: "Successfully Insert Data!"
                    }).then(next => {
                        window.history.length > 1 ? this.$router.go(-1) : this.$router.push('/');
                    });
                    console.log(res);
                    // console.log(config.url);
                } catch (e) {
                    this.errors = e.response.data.errors;
                    console.error(e.response.data);
                    this.loadingSubmit = false;
                }
            },
            getData() {
                axios.all([
                    axios.get(this.$parent.MakeUrl("po/sign?type=option")),
                    axios.get(this.$parent.MakeUrl("configuration/stockpiles?type=option")),
                    axios.get(this.$parent.MakeUrl("configuration/general-vendor?type=option")),
                    axios.get(this.$parent.MakeUrl("configuration/currency?type=option")),
                    axios.get(this.$parent.MakeUrl("configuration/shipment?type=option")),
                    axios.get(this.$parent.MakeUrl("po/group-item?type=option")),
                    axios.get(this.$parent.MakeUrl("po/getPONo"))

                ]).then(
                    axios.spread((signs, stockpiles, vendor, currency, shipments, groupItems, po) => {
                        this.data.stockpiles = stockpiles.data.data;
                        this.data.vendors = vendor.data;
                        this.data.currency = currency.data;
                        this.data.shipments = shipments.data;
                        this.data.groupItems = groupItems.data;
                        this.form.noPO = po.data;
                        this.loading = false;
                    })
                ).catch(err => {

                });
            },

            getVendorBank() {
                this.loading = true;
                axios.all([
                    axios.get(this.$parent.MakeUrl("configuration/general-vendor-bank?type=option&generalVendorId=" + this.form.vendorId)),
                    axios.get(this.$parent.MakeUrl("general-vendor-pph?type=option&vendorId=" + this.form.vendorId)),
                    axios.get(this.$parent.MakeUrl("vendor-ppn?vendorId=" + this.form.vendorId)),

                ]).then(axios.spread((vendorBank, vendorPPH, ppn) => {
                    const pph = [
                        {
                            pph_tax_id: '',
                            tax_name: "-- Please Select --"
                        },
                        {
                            pph_tax_id: 0,
                            tax_name: "NONE"
                        }
                    ];
                    this.data.vendorBank = vendorBank.data;
                    this.data.pph = pph.concat(vendorPPH.data);
                    this.data.ppn = ppn.data;
                    this.loading = false;
                    console.log(ppn.data);
                })).catch(err => {

                });
            },
            getItems() {
                axios.get(this.$parent.MakeUrl("po/items?type=option&groupItemId=" + this.formModal.groupItemId))
                    .then(res => {
                        this.data.items = res.data;
                    });
            },
            pushPoDetails() {
                return this.data.poDetails.push({
                    total_amount: 0,
                    qty: 0,
                    skuid: this.item.skuid,
                    uom: this.item.uom,
                    item_name: this.item.item_name,
                    amount: this.item.amount,
                    notes: null
                });
            }
        },
        computed: {
            totalAmount: function () {
                return this.formModal.qty * this.formModal.unitPrice;
            },
            totalPPN: function () {
                console.log(this.data.ppn);
                return this.totalAmount ? (this.totalAmount / 100) * this.data.ppn.tax_value : 0;
            }
        }
    }
</script>

<style scoped>

</style>
