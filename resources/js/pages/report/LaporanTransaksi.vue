<template>
    <div v-if="hasAnyRole('admin|pemilik')">
        <div class="container">
            <div class="row justify-content-center">
                <h1 class="mt-5">Laporan Transaksi</h1>
                <TransaksiComponent />
            </div>
            <a
                href=""
                class="btn btn-primary"
                @click.prevent="$router.push({ name: 'Report' })"
                >Kembali</a
            >
        </div>
    </div>
    <Forbidden v-else />
</template>

<script>
import { ref, onMounted } from "vue";
import { useCookies } from "vue3-cookies";
import Forbidden from "../errors/Forbidden.vue";
import TransaksiComponent from "../../components/transaksi/TransaksiComponent.vue";

export default {
    components: {
        Forbidden,
        TransaksiComponent,
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
