import { createRouter, createWebHistory } from "vue-router";
import Home from "./pages/Home.vue";
import DefaultLayout from "./layouts/DefaultLayout.vue";

import NotFound from "./pages/errors/NotFound.vue";
import Forbidden from "./pages/errors/Forbidden.vue";

import User from "./pages/users/User.vue";
import Profil from "./pages/users/Profil.vue";

// Barang
import Barang from "./pages/product/Barang.vue";
import BarangDetail from "./pages/product/BarangDetail.vue";
import CreateBarang from "./pages/product/TambahData.vue";
import EditBarang from "./pages/product/EditData.vue";

// Kategori
import Kategori from "./pages/category/Kategori.vue";
import KategoriDetail from "./pages/category/KategoriDetail.vue";
import CreateKategori from "./pages/category/TambahData.vue";
import EditKategori from "./pages/category/EditData.vue";

//report dan kasir
import Kasir from "./pages/Kasir.vue";
import Report from "./pages/report/Report.vue";
import ReportDetail from "./pages/report/ReportDetail.vue";
import ReportUser from "./pages/report/LaporanUser.vue";
import ReportTransaksi from "./pages/report/LaporanTransaksi.vue";
import ReportBarang from "./pages/report/LaporanBarang.vue";

// Authentication
import Login from "./pages/auth/Login.vue";
import Register from "./pages/auth/Register.vue";
import EditUser from "./pages/EditUser.vue";

const routes = [
    {
        path: "/",
        name: "DefaultLayout",
        component: DefaultLayout,
        redirect: "/",

        children: [
            {
                path: "/",
                name: "Home",
                component: Home,
            },
            {
                path: "/kasir",
                name: "Kasir",
                component: Kasir,
            },
            // barang
            {
                path: "/barang",
                name: "Barang",
                component: Barang,
            },
            {
                path: "/barang/:id?",
                name: "BarangDetail",
                component: BarangDetail,
                props: true,
            },
            {
                path: "/barang/create",
                name: "BarangCreate",
                component: CreateBarang,
            },
            {
                path: "/barang/:id/edit",
                name: "BarangEdit",
                component: EditBarang,
                props: true,
            },
            // end barang

            // kategori
            {
                path: "/kategori",
                name: "Kategori",
                component: Kategori,
            },
            {
                path: "/kategori/:id?",
                name: "KategoriDetail",
                component: KategoriDetail,
                props: true,
            },
            {
                path: "/kategori/create",
                name: "KategoriCreate",
                component: CreateKategori,
            },
            {
                path: "/kategori/:id/edit",
                name: "KategoriEdit",
                component: EditKategori,
                props: true,
            },
            //end kategori

            // report
            {
                path: "/report",
                name: "Report",
                component: Report,
            },
            {
                path: "/report/laporan-transcation",
                name: "ReportTransaksi",
                component: ReportTransaksi,
            },

            {
                path: "/transaction/:id?",
                name: "ReportDetail",
                component: ReportDetail,
                props: true,
            },
            {
                path: "/report/laporan-barang",
                name: "ReportBarang",
                component: ReportBarang,
            },
            {
                path: "/report/laporan-user",
                name: "ReportUser",
                component: ReportUser,
            },
            //end report

            {
                path: "/user",
                name: "User",
                component: User,
            },
            {
                path: "/user/:id?",
                name: "Profil",
                component: Profil,
                props: true,
            },
            {
                path: "/user/:id/edit",
                name: "EditUser",
                component: EditUser,
                props: true,
            },
            {
                path: "/register",
                name: "Register",
                component: Register,
            },
        ],
    },
    // Authentication
    {
        path: "/login",
        name: "Login",
        component: Login,
    },

    {
        path: "/:pathMatch(.*)",
        name: "NotFound",
        component: NotFound,
    },

    {
        path: "/forbidden",
        name: "Forbidden",
        component: Forbidden,
    },
];

const router = createRouter({
    // linkActiveClass: "active",
    history: createWebHistory(),
    routes,
});

export default router;
