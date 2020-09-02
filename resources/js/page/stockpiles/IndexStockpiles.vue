<template>
    <!--    <div v-if="$parent.userRole('Admin')">-->
    <d-table :config="config" :columns="columns"></d-table>
    <!--    </div>-->
    <!--    <div v-else>-->
    <!--        <d-error :error="error"></d-error>-->
    <!--    </div>-->
</template>
<script>
    export default {
        data() {
            return {
                config: {
                    title: 'Stockpiles',
                    action: true,
                    base_url: this.$parent.MakeUrl('configuration/stockpiles'),
                    // route_search: 'admin.marketing.sales_order.index',
                    route_create: 'stockpiles.create',
                    route_view: 'delivery_order.print',
                    route_multiple_print: 'delivery_order.multiplePrint',
                },
                columns: [
                    {
                        title: 'Code',
                        field: 'code',
                        filterable: true,
                    },
                    {
                        title: 'Name',
                        field: 'name',
                        filterable: true,
                    },
                    {
                        title: 'Address',
                        field: 'addresss',
                        filterable: true,
                    },
                    {
                        title: 'Status',
                        field: 'status',
                        filterable: false,
                    }
                ],
                error: {
                    code: 403,
                    description: 'You do not have access to this page'
                }
            }
        },
    }
</script>
