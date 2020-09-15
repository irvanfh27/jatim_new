import Table from "./components/Table";
import Error from "./components/Error";
import LoadingComponent from "./components/LoadingComponent";
import BackButtonComponent from "./components/BackButtonComponent";
import VFormsComponent from "./components/VFormsComponent";
import VTable from "./components/VTable";

Vue.component('d-table', VTable);
Vue.component('d-error', Error);
Vue.component('d-loading', LoadingComponent);
Vue.component('d-back-button', BackButtonComponent)
Vue.component('d-forms', VFormsComponent)
