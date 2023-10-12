import "./bootstrap";
import { createApp } from "vue";
import router from "./router";
import App from "./App.vue";

// Import Cookie
import VueCookies from "vue3-cookies";

// Import Bootstrap an BootstrapVue CSS files (order is important)
import "bootstrap/dist/css/bootstrap.css";
import "bootstrap/dist/js/bootstrap.js";

// Import Notifications
import Notifications from "@kyvg/vue3-notification";

// Import laravel permission to vue js
import RolesPermissionsToVue from "../../vendor/geowrgetudor/laravel-spatie-permissions-vue/src/js";
// import LaravelPermissionToVueJS from "laravel-permission-to-vuejs";

/* import the fontawesome core */
import { library } from "@fortawesome/fontawesome-svg-core";

/* import specific icons */
import { faTrash } from "@fortawesome/free-solid-svg-icons";
import { faEdit } from "@fortawesome/free-solid-svg-icons";
import { faEye } from "@fortawesome/free-solid-svg-icons";
import { faHome } from "@fortawesome/free-solid-svg-icons";
import { faCashRegister } from "@fortawesome/free-solid-svg-icons";
import { faBox } from "@fortawesome/free-solid-svg-icons";
import { faUser } from "@fortawesome/free-solid-svg-icons";
import { faList } from "@fortawesome/free-solid-svg-icons";
import { faSignOut } from "@fortawesome/free-solid-svg-icons";
import { faPrint } from "@fortawesome/free-solid-svg-icons";
import { faCheckToSlot } from "@fortawesome/free-solid-svg-icons";
import { faCartPlus } from "@fortawesome/free-solid-svg-icons";
import { faFile } from "@fortawesome/free-solid-svg-icons";

library.add(
    faTrash,
    faEdit,
    faEye,
    faHome,
    faCashRegister,
    faBox,
    faUser,
    faList,
    faSignOut,
    faPrint,
    faCheckToSlot,
    faCartPlus,
    faFile
);

/* import font awesome icon component */
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";

createApp(App)
    .use(router)
    .use(Notifications)
    .use(VueCookies)
    .use(RolesPermissionsToVue)
    .component("font-awesome-icon", FontAwesomeIcon)
    .mount("#app");
