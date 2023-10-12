<template>
    <div v-if="hasAnyRole('admin|pemilik')">
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
    </div>
    <Forbidden v-else />
</template>

<script>
import { ref, onMounted } from "vue";
import { useCookies } from "vue3-cookies";
import Forbidden from "../errors/Forbidden.vue";
import UserComponent from "../../components/user/UserComponent.vue";

export default {
    components: {
        Forbidden,
        UserComponent,
    },
    setup() {
        const { cookies } = useCookies();
        const role = ref([]);

        const hasAnyRole = (roles) => {
            const rolesSplit = roles.split("|");
            role.value = cookies.value;

            if (role.value) {
                return rolesSplit.some((roleSplit) =>
                    role.value.includes(roleSplit)
                );
            }

            return false;
        };

        onMounted(() => {
            cookies.value = cookies.get("roles");
        });

        return {
            hasAnyRole,
        };
    },
};
</script>
