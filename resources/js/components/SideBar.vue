<template>
    <div class="header">
        <h1>{{ title }}</h1>
        <p>Hello, {{ get.data ? get.data.user.name : "" }}</p>
        <!-- <p>{{ get.data.roles.name }}</p> -->
    </div>
    <div class="wrapper">
        <aside>
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
import { reactive, onMounted } from "vue";
import { useCookies } from "vue3-cookies";
import { useRouter } from "vue-router";
import axios from "axios";

export default {
    setup() {
        const title = "SB Store";
        const get = reactive({ data: null });
        // const role = reactive({roles=""});
        const { cookies } = useCookies();
        const router = useRouter();

        const getUser = () => {
            const api_token = cookies.get("api_token");
            const config = {
                headers: { Authorization: `Bearer ${api_token}` },
            };

            axios.get("/api/user", config).then((res) => {
                console.log(res.data);
                get.data = res.data;
            });
        };

        const logout = () => {
            axios.post("/api/logout").then((res) => {
                console.log(res.data);
                router.push({ name: "Login" });
                cookies.remove("api_token");
            });
        };

        const is = (role) => {
            if (get.data && get.data.roles) {
                return get.data.roles.includes(role);
            }
            return false;
        };

        const hasAnyRole = (roles) => {
            if (get.data && get.data.roles) {
                const userRoles = get.data.roles;
                return roles
                    .split("|")
                    .some((role) => userRoles.includes(role));
            }
            return false;
        };

        onMounted(() => {
            getUser();
        });

        return {
            getUser,
            title,
            get,
            logout,
            is,
            hasAnyRole,
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
