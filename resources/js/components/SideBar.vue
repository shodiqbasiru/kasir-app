<template>
    <div class="header">
        <h1>{{ title }}</h1>
        <p>Hello, {{ name }} ({{ role }})</p>
    </div>
    <div class="wrapper">
        <aside v-if="role">
            <ul>
                <li>
                    <router-link :to="{ name: 'Home' }">
                        <font-awesome-icon icon="fa-solid fa-home" />
                        Beranda
                    </router-link>
                </li>
                <li v-if="is('kasir')">
                    <router-link :to="{ name: 'Kasir' }">
                        <font-awesome-icon icon="fa-solid fa-cash-register" />
                        Kasir
                    </router-link>
                </li>
                <li v-if="is('admin')">
                    <router-link :to="{ name: 'Barang' }">
                        <font-awesome-icon icon="fa-solid fa-box" />
                        Produk
                    </router-link>
                </li>

                <li v-if="is('admin')">
                    <router-link :to="{ name: 'Kategori' }">
                        <font-awesome-icon icon="fa-solid fa-list" />
                        Kategori
                    </router-link>
                </li>
                <li v-if="hasAnyRole('admin|pemilik')">
                    <router-link :to="{ name: 'Report' }">
                        <font-awesome-icon icon="fa-solid fa-file" />
                        Laporan
                    </router-link>
                </li>
                <li v-if="hasAnyRole('admin|pemilik')">
                    <router-link :to="{ name: 'User' }">
                        <font-awesome-icon icon="fa-solid fa-user" />
                        Pengguna
                    </router-link>
                </li>
                <li>
                    <a href="" @click.prevent="logout()">
                        <font-awesome-icon icon="fa-solid fa-sign-out" />

                        Log Out</a
                    >
                </li>
            </ul>
        </aside>
    </div>
</template>

<script>
import { reactive, ref, onMounted, onBeforeMount } from "vue";
import { useCookies } from "vue3-cookies";
import { useRouter } from "vue-router";
import axios from "axios";

export default {
    props: ["name"],
    setup() {
        const title = "SB Store";
        const get = reactive({ data: null });
        const role = ref([]);
        const { cookies } = useCookies();
        const router = useRouter();

        const logout = () => {
            axios.post("/api/logout").then((res) => {
                console.log(res.data);
                router.push({ name: "Login" });
                cookies.remove(["api_token"]);
                cookies.remove(["roles"]);
            });
        };

        const is = (roles) => {
            if (role.value === roles) {
                return true;
            } else {
                return false;
            }
        };

        const hasAnyRole = (roles) => {
            const rolesSplit = roles.split("|");
            return rolesSplit.includes(role.value);
        };

        // onMounted(() => {
        //     role.value = cookies.get("roles");
        //     console.log(role.value); // Tambahkan ini
        // });

        onBeforeMount(() => {
            role.value = cookies.get("roles");
        });

        return {
            title,
            get,
            logout,
            is,
            hasAnyRole,
            role,
        };
    },
};
</script>

<style scoped>
aside {
    display: flex;
    gap: 1rem;
    flex-direction: column;
    width: 100%;
}

aside ul {
    list-style: none;
    padding: 0;
}

aside ul li {
    margin: 1rem 0;
}

aside ul li a {
    display: block;
    width: 100%;
    color: black;
    text-decoration: none;
    font-size: 18px;
    font-weight: 600;
    padding: 0.5rem 1rem;
    letter-spacing: 1.3px;
    transition: all 0.1s ease-in;
}

aside ul li a:hover {
    background-color: aquamarine;
    transition: all 0.1s ease-in;
}

.wrapper {
    display: flex;
    flex-direction: column;
    width: 100%;
    height: 100%;
}

.header {
    padding: 1rem;
    background-color: rgb(0, 144, 144);
    color: white;
}

.header h1 {
    margin: 0;
    font-size: 28px;
    font-weight: 600;
}

.header p {
    margin: 0;
    font-size: 18px;
    font-weight: 500;
}
</style>
