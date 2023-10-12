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
import Forbidden from "../errors/Forbidden.vue";
import BarangComponent from "../../components/barang/BarangComponent.vue";
import { useCookies } from "vue3-cookies";
import { ref, onMounted } from "vue";

export default {
    components: {
        BarangComponent,
        Forbidden,
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
