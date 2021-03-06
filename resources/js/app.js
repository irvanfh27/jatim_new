/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
window.Vue = require('vue');

require('./bootstrap');
require('./component');
require('./library');
import VueNumeric from 'vue-numeric'
import router from './router';
import Vuetify from 'vuetify';

axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
    'Authorization': 'Bearer ' + AccessToken
};
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
Vue.use(Vuetify);
const app = new Vue({
    el: '#app',
    vuetify: new Vuetify(),
    router,
    data() {
        return {
            user: AuthUser,
        }
    },
    methods: {
        userCan(permission) {
            if (this.user && this.user.allPermissions.includes(permission)) {
                return true;
            }
            return false;
        },
        userRole(role) {
            if (this.user && this.user.all_roles.includes(role)) {
                return true;
            }
            return false;
        },
        userID() {
            return JSON.parse(this.user);
        },
        MakeUrl(path) {
            return BaseUrl(path);
        }
    },
    components: {
        VueNumeric
    }
});

export default new Vuetify({
    icons: {
        iconfont: 'mdi', // default - only for display purposes
    },
})

