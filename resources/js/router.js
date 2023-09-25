import { createRouter, createWebHistory } from "vue-router";
import Home from "./pages/Home.vue";
import Kasir from "./pages/Kasir.vue";
const routes = [
    {
        path: "/home",
        name: "Home",
        component: Home,
    },
    {
        path: "/kasir",
        name: "Kasir",
        component: Kasir,
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
