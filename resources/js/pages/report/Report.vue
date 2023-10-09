<template>
    <!-- <div v-if="hasAnyRole('admin|pemilik', userData)"> -->
    <h1 v-text="title" class="mt-5"></h1>
    <div class="wrapper">
        <ReportComponent
            v-for="item in datas"
            :key="item.id"
            :title="item.title"
            :name="item.name"
        />
    </div>
    <!-- </div> -->
    <!-- <Forbidden v-else /> -->
</template>

<script>
import { ref } from "vue";
import axios from "axios";
import Forbidden from "../errors/Forbidden.vue";
import ReportComponent from "../../components/report/ReportComponent.vue";
export default {
    components: {
        Forbidden,
        ReportComponent,
    },
    setup() {
        const title = "Laporan";
        const datas = ref([
            { id: 1, title: "Laporan Data Transaksi", name: "ReportTransaksi" },
            { id: 2, title: "Laporan Data Barang", name: "ReportBarang" },
            { id: 3, title: "Laporan Data Pengguna", name: "ReportUser" },
        ]);

        // const userData = getUser();

        // const hasAnyRole = (roles, userData) => {
        //     if (userData) {
        //         const userRoles = userData.data.roles;
        //         return roles
        //             .split("|")
        //             .some((role) => userRoles.includes(role));
        //     }
        //     return false;
        // };

        // onMounted(() => {
        //     getUser();
        // });

        return {
            title,
            datas,
            // userData,
            // hasAnyRole,
        };
    },
};
</script>

<style scoped>
a {
    text-decoration: none;
    color: #000;
}

.wrapper {
    display: grid;
    /* grid-template-rows: ; */
    grid-template-columns: repeat(3, 1fr);
    gap: 1rem;
    margin: 1rem;
}

@media screen and (max-width: 997px) {
    .wrapper {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media screen and (max-width: 768px) {
    .wrapper {
        grid-template-columns: repeat(1, 1fr);
    }
}
</style>
