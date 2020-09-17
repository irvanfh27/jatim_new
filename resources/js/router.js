import Vue from 'vue'
import VueRouter from 'vue-router';
import Dashboard from "./page/Dashboard";
import IndexStockpiles from "./page/stockpiles/IndexStockpiles";
import IndexPO from "./page/po/create-po/IndexPO";
import FreightGroup from "./page/configuration/freightgroup/FreightGroup";
import CreateFreightGroup from "./page/configuration/freightgroup/CreateFreightGroup";
import FormStockpile from "./page/stockpiles/FormStockpile";
import FormPO from "./page/po/create-po/FormPO";

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
