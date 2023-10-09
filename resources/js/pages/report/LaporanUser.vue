<template>
    <h1>Laporan Data Pengguna</h1>
    <div>
        <UserComponent />
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
import Forbidden from "../errors/Forbidden.vue";
import UserComponent from "../../components/user/UserComponent.vue";

export default {
    components: {
        Forbidden,
        UserComponent,
    },
    setup() {
        const { getUser } = inject("getUser");
        const userData = getUser();

        const is = (role, userData) => {
            if (userData) {
                return userData.data.roles.includes(role);
            }
            return false;
        };

        const hasAnyRole = (roles, userData) => {
            if (userData) {
                const userRoles = userData.data.roles;
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
        };
    },
};
</script>
