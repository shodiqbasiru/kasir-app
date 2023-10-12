<template>
    <div v-if="hasAnyRole('pemilik|admin')">
        <section>
            <h1 class="mt-5">Daftar User</h1>
            <router-link :to="{ name: 'Register' }" class="btn btn-primary">
                Tambah Pengguna
            </router-link>
            <UserComponent />
        </section>
    </div>
    <forbidden v-else />
</template>

<script>
import { ref, onMounted } from "vue";
import Forbidden from "../errors/Forbidden.vue";
import UserComponent from "../../components/user/UserComponent.vue";
import { useCookies } from "vue3-cookies";

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

<style scoped></style>
