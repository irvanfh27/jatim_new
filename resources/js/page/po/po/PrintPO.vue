<template>
    <div id="PODetail">

        <table width="100%" style="table table-bordered" border=1>
            <tr>

                <td width="100%" height="51"><b><font = size ="6"> PT.JATIM PROPERTINDO JAYA</font></b>
                </td>
            </tr>
            <tr>
                <td width="100%"><b>
                    <font = size ="4">
                    <div align="center">Purchase Order</div>
                    </font>
                </b>
                </td>
            </tr>
            <tr>
                <td width="100%"><b>
                    <div align="center">
                    </div>
                </b>
                </td>
            </tr>
        </table>
        <table width="100%" style="table-layout:fixed; font-size: 9pt;">
            <tr>
                <td width="24%"><b>Supplier</b></td>
                <td width="2%">:</td>
                <td width="24%">{{ data.general_vendor_name }}</td>
                <td width="24%"><b>Stockpile</b></td>
                <td width="2%">:</td>
                <td width="24%">{{ data.stockpile_name}}</td>
            </tr>
            <tr>
                <td width="24%"><b>Address</b></td>
                <td width="2%">:</td>
                <td width="24%" rowspan="3">{{ data.general_vendor_address }}</td>
                <td width="24%"><b>No.Penawaran</b></td>
                <td width="2%">:</td>
                <td width="24%">{{ data.no_penawaran }}</td>
            </tr>
            <tr>
                <td width="24%">&nbsp;</td>
                <td width="2%">&nbsp;</td>
                <td width="24%"><b>Tanggal</b></td>
                <td width="2%">:</td>
                <td width="24%">{{ data.tanggal }}</td>
            </tr>
            <tr>
                <td width="24%">&nbsp;</td>
                <td width="2%">&nbsp;</td>
                <td width="24%">&nbsp;</td>
                <td width="2%">:</td>
                <td width="24%">&nbsp;</td>
            </tr>
            <tr>
                <td width="24%"><b>Phone</b></td>
                <td width="2%">:</td>
                <td width="24%">&nbsp;</td>
                <td width="24%">&nbsp;</td>
                <td width="2%">&nbsp;</td>
                <td width="24%">&nbsp;</td>
            </tr>
            <tr>
                <td width="24%"><b>Fax</b></td>
                <td width="2%">:</td>
                <td width="24%">&nbsp;</td>
                <td width="24%">&nbsp;</td>
                <td width="2%">&nbsp;</td>
                <td width="24%">&nbsp;</td>
            </tr>


        </table>

        <!--<br/>-->
        <table width="100%" class="table table-bordered table-striped" style="font-size: 9pt;">
            <thead>
            <tr>
                <th align="left">Remarks</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td v-if="data.memo">{{ data.memo }}</td>
                <td v-else style="height: 40px;"> {{ data.memo }}</td>
            </tr>
            </tbody>
        </table>
        <!--<br/>-->
        <table width="100%" class="table table-bordered table-striped" style="font-size: 9pt;">
            <thead>
            <tr>
                <th>Qty</th>
                <th>Harga</th>
                <th>Item Description</th>
                <th>Uom</th>
                <th>DPP</th>
                <th>PPN</th>
                <th>PPH</th>
                <th>Total</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(item, idx) in data.poDetails" :key="idx">
                <td>{{ item.qty}}</td>
                <td>{{ item.harga}}</td>
                <td>{{ item.item_name}}</td>
                <td>{{ item.uom_type}}</td>
                <td>{{ item.amount}}</td>
                <td>{{ item.ppn}}</td>
                <td>{{ item.pph}}</td>
                <td>{{ item.grandtotal}}</td>
            </tr>

            </tbody>
            <tfoot>

            <tr>
                <td colspan="3" style="text-align: right;">Total</td>
                <td colspan="1" style="text-align: right;">{{ data.grandtotal }}</td>
                <td colspan="1" style="text-align: right;">{{ data.totalppn }}</td>
                <td colspan="1" style="text-align: right;">{{ data.totalpph }}</td>
                <td colspan="1" style="text-align: right;">{{ data.totalall }}</td>
            </tr>

            <tr>


            </tr>
            </tfoot>
        </table>
        <table width="100%" class="table table-bordered table-striped" style="font-size: 9pt;">
            <thead>
            <tr>
                <th align="left">ToC</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td v-if="data.toc">{{ data.toc }}</td>
                <td v-else style="height: 40px;"> {{ data.toc }}</td>
            </tr>
            </tbody>
        </table>
        <table width="100%">
            <tbody>
            <tr>
                <td width="58%">
                    <table width="100%" border="1">
                        <tbody>
                        <tr>
                            <td width="17%">TT to</td>
                            <td width="83%">: {{ data.general_vendor_name }}></td>
                        </tr>
                        <tr>
                            <td>Bank</td>
                            <td>: {{ data.bank_name }}</td>
                        </tr>
                        <tr>
                            <td>Cabang</td>
                            <td>: {{ data.branch }}</td>
                        </tr>
                        <tr>
                            <td>No Rek</td>
                            <td>: {{ data.account_no }}</td>
                        </tr>
                        <tr>
                            <td>Swift Code</td>
                            <td>: {{ data.swift_code }}</td>
                        </tr>
                        </tbody>
                    </table>
                </td>
                <td width="42%">
                    <table width="100%" border="1">
                        <tbody>
                        <tr>
                            <td>Prepare by,</td>
                            <td>Check by,</td>
                            <td>Approval by,</td>
                        </tr>
                        <tr>
                            <td height="78">&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td height="23"><?php echo $prepareby ?></td>
                            <td><?php echo $checkby ?></td>
                            <td></td>
                        </tr>
                        </tbody>
                    </table>
                </td>

            </tr>
            </tbody>
        </table>
    </div>
    <hr>
    <div class="row-fluid">
        <div class="span12 lightblue">
            <button class="btn btn-primary" id="printPODetail">Print</button>
            <button class="btn" type="button" onclick="back()">Back</button>
            <button class="btn btn-warning" id="reject">Reject</button>
            <button class="btn btn-warning" id="cancel">Cancel</button>
        </div>
    </div>


</template>

<script>
    export default {
        name: "PrintPO",
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
                axios.get(this.$parent.MakeUrl("po/po/" + this.$route.params.uuid)).then(res => {
                    this.data = res.data;
                    console.log(res);
                });
            },
        }
    }
</script>

<style scoped>

</style>
