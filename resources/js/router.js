import Vue from 'vue'
import VueRouter from 'vue-router';
import Dashboard from "./page/Dashboard";
import IndexStockpiles from "./page/stockpiles/IndexStockpiles";
import CreateStockpile from "./page/stockpiles/CreateStockpile";
import IndexPO from "./page/po/create-po/IndexPO";
import CreatePO from "./page/po/create-po/CreatePO";
import FreightGroup from "./page/configuration/freightgroup/FreightGroup";
import CreateFreightGroup from "./page/configuration/freightgroup/CreateFreightGroup";

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
            component: CreateStockpile
        },
        {
            path: '/dashboard/stockpiles/:uuid/edit',
            name: "stockpiles.edit",
            component: CreateStockpile
        },
        {
            path: '/dashboard/po',
            name: "po",
            component: IndexPO
        },
        {
            path: '/dashboard/po/create',
            name: "po.create",
            component: CreatePO
        },
        {
            path: '/dashboard/po/:uuid/edit',
            name: "po.edit",
            component: CreatePO
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
