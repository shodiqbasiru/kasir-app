<template>
    <!-- <div v-if="is('admin', userData)"> -->
    <h1 class="title mt-5">Data Barang</h1>

    <div class="content">
        <div class="header">
            <h5>List Barang</h5>
            <a href="" class="btn btn-primary" @click.prevent="createData()"
                >Tambah Data</a
            >
        </div>
        <div class="body">
            <BarangComponent />
        </div>
    </div>
    <!-- </div> -->
    <!-- <div v-else>
        <Forbidden />
    </div> -->
</template>

<script>
import { inject } from "vue";
import { useRouter } from "vue-router";
import Forbidden from "../errors/Forbidden.vue";
import BarangComponent from "../../components/barang/BarangComponent.vue";

export default {
    components: {
        BarangComponent,
        Forbidden,
    },
    setup() {
        const { getUser } = inject("getUser");
        const router = useRouter();
        const userData = getUser();

        const createData = () => {
            router.push({
                name: "BarangCreate",
            });
        };

        const is = (role, userData) => {
            if (userData && userData.data.roles) {
                return userData.data.roles.includes(role);
            }
            return false;
        };

        const hasAnyRole = (roles, userData) => {
            if (userData && userData.roles) {
                const userRoles = userData.roles;
                return roles
                    .split("|")
                    .some((role) => userRoles.includes(role));
            }
            return false;
        };
        return {
            userData,
            is,
            hasAnyRole,
            createData,
        };
    },
};
</script>

<style scoped>
.content {
    padding: 1rem;
    border: 1px solid #ccc;
    border-radius: 4px;
}

.content .header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1px solid #ccc;
    /* margin: 1rem 0; */
    padding: 1rem 0;
}

.content .header h5 {
    margin: 0;
}

.content a.btn {
    text-decoration: none;
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 4px;
    font-size: 14px;
    border: none;
}

.content .header a.btn-primary {
    background-color: rgb(0, 144, 144);
}
.content .body {
    margin-top: 1rem;
}

.content .body .table {
    overflow-x: auto;
}

.content .body .table table {
    width: 100%;
    border-collapse: collapse;
}

.content .body .table table thead tr th {
    padding: 0.5rem 1rem;
    border: 1px solid #ccc;
    background-color: rgb(0, 144, 144);
    color: white;
    text-align: center;
}

.content .body .table table tbody tr td {
    padding: 0.5rem 1rem;
    border: 1px solid #ccc;
    text-align: center;
}

.content .body .table table tbody tr td a.btn {
    margin-right: 0.5rem;
}

.content .body .table table tbody tr td a.btn-success {
    background-color: rgb(0, 144, 144);
}

.content .body .table table tbody tr td a.btn-danger {
    background-color: rgb(255, 0, 0);
}

.content .body .table table tbody tr td a.btn-warning {
    background-color: rgb(255, 165, 0);
}

.content .body .table table tbody tr td a.btn-success:hover {
    background-color: rgb(0, 144, 144);
}

.content .body .table table tbody tr td a.btn-danger:hover {
    background-color: rgb(255, 0, 0);
}

.content .body .table table tbody tr td a.btn-warning:hover {
    background-color: rgb(255, 165, 0);
}
</style>
