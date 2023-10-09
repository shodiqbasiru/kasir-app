<template>
    <section class="wrapper">
        <div class="card">
            <div class="header text-center mb-5">
                <h1></h1>
                <h3>Selamat Datang di Aplikasi Kasir</h3>
                <h5>Login</h5>
            </div>
            <form>
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input
                        type="username"
                        name="username"
                        class="form-control"
                        id="username"
                        v-model="form.username"
                    />
                </div>
                <div class="mb-3">
                    <label for="pasword" class="form-label">Password</label>
                    <input
                        type="password"
                        name="password"
                        v-model="form.password"
                        class="form-control"
                        id="pasword"
                    />
                </div>

                <button
                    type="submit"
                    @click.prevent="login()"
                    class="btn btn-primary"
                >
                    Login
                </button>
            </form>
        </div>
    </section>
</template>

<script>
import { reactive } from "vue";
import { useCookies } from "vue3-cookies";
import { useRouter } from "vue-router";
import { useNotification } from "@kyvg/vue3-notification";

export default {
    setup() {
        const router = useRouter();
        const form = reactive({ username: "", password: "" });
        const { cookies } = useCookies();
        const { notify } = useNotification();

        const login = () => {
            axios.post("/api/login", form).then((res) => {
                cookies.set("api_token", res.data.api_token, {
                    expires: "1D",
                });

                router.push({ name: "Home" });
                notify({
                    title: "Success",
                    text: res.data.message,
                    type: "success",
                });
            });
        };

        return { cookies, login, form };
    },
};
</script>

<style scoped>
.wrapper {
    width: 100%;
    height: 100vh;
    background-color: rgb(101, 223, 223);
    display: grid;
    place-items: center;
}

.card {
    width: 30%;
    padding: 2rem;
    background-color: white;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
}

.card .header {
    padding-bottom: 1rem;
    border-bottom: 1px solid #ccc;
}
</style>
