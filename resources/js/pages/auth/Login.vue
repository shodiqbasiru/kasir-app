<template>
    <section class="wrapper">
        <div class="card">
            <div class="header text-center mb-5">
                <h3>Aplikasi Kasir SB Store</h3>
                <h5>Login</h5>
            </div>
            <form>
                <!-- <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <select
                        name="username"
                        id="username"
                        class="form-control"
                        v-model="form.username"
                    >
                        <option value="">Pilih Role</option>
                        <option
                            v-for="role in roles"
                            :key="role.id"
                            :value="role.id"
                        >
                            {{ role.name }}
                        </option>
                    </select>
                </div> -->
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input
                        type="text"
                        name="username"
                        class="form-control"
                        id="username"
                        v-model="form.username"
                    />
                    <div class="error" v-if="form.error.username">
                        {{ form.error.username[0] }}
                    </div>
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
                    <div class="error" v-if="form.error.password">
                        {{ form.error.password[0] }}
                    </div>
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
import { ref, reactive, onMounted } from "vue";
import { useCookies } from "vue3-cookies";
import { useRouter } from "vue-router";
import { useNotification } from "@kyvg/vue3-notification";

export default {
    setup() {
        const router = useRouter();
        const form = reactive({
            username: "",
            password: "",
            // role: "",
            error: {},
        });
        // const roles = ref([]);
        const { cookies } = useCookies();
        const { notify } = useNotification();

        const login = () => {
            axios
                .post("/api/login", form)
                .then((res) => {
                    cookies.set("api_token", res.data.api_token, {
                        expires: "1D",
                    });
                    cookies.set("roles", res.data.roles);
                    router.push({ name: "DefaultLayout" });
                    notify({
                        title: "Success",
                        text: res.data.message,
                        type: "success",
                    });
                })
                .catch((error) => {
                    form.error = error.response.data.errors;
                });
        };

        // const getDataRoles = () => {
        //     axios.get("/api/roles").then((res) => {
        //         roles.value = res.data;
        //         console.log(roles.value);
        //     });
        // };

        onMounted(() => {
            // getDataRoles();
            if (cookies.get("api_token")) {
                router.push({ name: "Home" });
            }
        });

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

.error {
    color: red;
    font-size: 12px;
}
</style>
