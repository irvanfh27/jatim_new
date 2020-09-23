import Vue from 'vue'
import VueRouter from 'vue-router';
import Dashboard from "./page/Dashboard";
import IndexStockpiles from "./page/stockpiles/IndexStockpiles";
import IndexPO from "./page/po/po/IndexPO";
import FreightGroup from "./page/configuration/freightgroup/FreightGroup";
import CreateFreightGroup from "./page/configuration/freightgroup/CreateFreightGroup";
import FormStockpile from "./page/stockpiles/FormStockpile";
import FormPO from "./page/po/po/FormPO";
import DetailPO from "./page/po/po/DetailPO";
import IndexApprovalPO from "./page/po/po/IndexApprovalPO";
import IndexReceivePO from "./page/po/po/IndexReceivePO";
import FormReceive from "./page/po/po/FormReceive";

Vue.use(VueRouter);
const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/dashboard',
            name: "dashboard",
            component: Dashboard
        },
        {
            path: '/dashboard/stockpiles',
            name: "stockpiles",
            component: IndexStockpiles
        },
        {
            path: '/dashboard/stockpiles/create',
            name: "stockpiles.create",
            component: FormStockpile
        },
        {
            path: '/dashboard/stockpiles/:uuid/edit',
            name: "stockpiles.edit",
            component: FormStockpile
        },
        {
            path: '/dashboard/po',
            name: "po",
            component: IndexPO
        },
        {
            path: '/dashboard/po/create',
            name: "po.create",
            component: FormPO
        },
        {
            path: '/dashboard/po/:uuid/edit',
            name: "po.edit",
            component: FormPO
        },
        {
            path: '/dashboard/po/:uuid/detail',
            name: "po.detail",
            component: DetailPO
        },
        {
            path: '/dashboard/po-approve',
            name: "poApprove",
            component: IndexApprovalPO
        },
        {
            path: '/dashboard/po-approve/:uuid/detail',
            name: "poApprove.detail",
            component: DetailPO
        },

        {
            path: '/dashboard/po-receive',
            name: "poReceive",
            component: IndexReceivePO
        },
        {
            path: '/dashboard/po-receive/:uuid/detail',
            name: "poReceive.detail",
            component: FormReceive
        },
        {
            path: '/dashboard/configuration/freightgroup',
            name: "freightgroup",
            component: FreightGroup
        },
        {
            path: '/dashboard/configuration/freightgroup/create',
            name: "freightgroup.create",
            component: CreateFreightGroup
        },
    ],
});
// router.replace('/dashboard');
export default router;
