<template>
    <section class="wrapper">
        <div class="nav-bar">
            <SideBar v-if="userData" :name="userData?.user?.name" />
        </div>
        <div class="main">
            <router-view :user-data="userData?.user?.name" />
            <Footer />
        </div>
    </section>
</template>

<script>
import SideBar from "../components/SideBar.vue";
import Footer from "../components/Footer.vue";
import { useCookies } from "vue3-cookies";
import { useRouter } from "vue-router";
import { onMounted, ref } from "vue";

import axios from "axios";
import Kasir from "../pages/Kasir.vue";
export default {
    setup() {
        const { cookies } = useCookies();
        const router = useRouter();
        const userData = ref({});

        const api_token = () => {
            if (!cookies.get("api_token")) {
                router.push({ name: "Login" });
            }
        };

        const getUser = () => {
            const api_token = cookies.get("api_token");

            const config = {
                headers: { Authorization: `Bearer ${api_token}` },
            };

            axios.get("/api/user", config).then((response) => {
                userData.value = response.data;
                // cookies.set("roles", userData.value.roles);
                // console.log(userData.value);
            });

            return userData;
        };

        onMounted(() => {
            api_token();
            getUser();
        });

        return { getUser, api_token, userData };
    },
    components: {
        SideBar,
        Footer,
        Kasir,
    },
    Kasir,
};
</script>

<style scoped>
.wrapper {
    width: 100%;
}
.wrapper .nav-bar {
    width: 15%;
    position: fixed;
    top: 0;
    left: 0;
    bottom: 0;
    background-color: rgb(101, 223, 223);
}

.wrapper .main {
    position: relative;
    margin-left: 15%;
    padding: 1rem;
    min-height: 100vh;
}

footer {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    display: grid;
    place-items: center;
}
</style>
