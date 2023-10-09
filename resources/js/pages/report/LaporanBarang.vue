<template>
    <div>
        <h1>Laporan Data Barang</h1>
    </div>
    <div>
        <BarangComponent />
    </div>
    <a
        href=""
        class="btn btn-primary"
        @click.prevent="$router.push({ name: 'Report' })"
        >Kembali</a
    >
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
