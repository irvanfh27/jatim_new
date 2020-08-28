import Vue from 'vue'
import VueRouter from 'vue-router';
import Dashboard from "./page/Dashboard";

Vue.use(VueRouter);
const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/home',
            name: "dashboard",
            component: Dashboard
        },
    ],
});
// router.replace('/');
export default router;
