import Vue from 'vue'
import VueRouter from 'vue-router';
import Dashboard from "./page/Dashboard";
import IndexStockpiles from "./page/stockpiles/IndexStockpiles";
import CreateStockpile from "./page/stockpiles/CreateStockpile";

Vue.use(VueRouter);
const router = new VueRouter({
    mode: 'abstract',
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
    ],
});
router.replace('/dashboard');
export default router;
