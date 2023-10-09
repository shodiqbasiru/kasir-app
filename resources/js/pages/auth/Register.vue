<template>
    <div v-if="hasAnyRole('admin|pemilik', userData)">
        <section>
            <div class="card">
                <div class="header text-center mb-5">
                    <h1>{{ title }}</h1>
                </div>
                <form action="">
                    <div class="mb-3">
                        <label for="name" class="form-label"
                            >Nama Pengguna</label
                        >
                        <input
                            type="text"
                            name="name"
                            class="form-control"
                            id="name"
                            v-model="form.name"
                        />
                    </div>
                    <div class="mb-3">
                        <label for="username" class="form-label"
                            >Username</label
                        >
                        <input
                            type="text"
                            name="username"
                            class="form-control"
                            id="username"
                            v-model="form.username"
                        />
                    </div>
                    <div class="mb-3">
                        <label for="roles" class="form-label">Role</label>
                        <select
                            name="roles"
                            id="roles"
                            class="form-control"
                            v-model="form.selectedRole"
                        >
                            <option value="">Pilih Role</option>
                            <option
                                v-for="role in role.roles"
                                :key="role.id"
                                :value="role.id"
                            >
                                {{ role.name }}
                            </option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label"
                            >Email address</label
                        >
                        <input
                            type="email"
                            name="email"
                            class="form-control"
                            id="email"
                            v-model="form.email"
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
                        @click.prevent="createUser()"
                        class="btn btn-primary"
                    >
                        Tambah
                    </button>
                </form>
            </div>
        </section>
    </div>
    <forbidden v-else />
</template>

<script>
import axios from "axios";
import { ref, onMounted, inject } from "vue";
import { useRouter } from "vue-router";
import Forbidden from "../errors/Forbidden.vue";
import { useNotification } from "@kyvg/vue3-notification";

export default {
    components: {
        Forbidden,
    },
    setup() {
        const title = ref("Registrasi Pengguna");
        const form = ref({
            name: "",
            username: "",
            email: "",
            password: "",
            selectedRole: "",
        });
        const role = ref({ roles: [] });
        const { getUser } = inject("getUser");
        const { notify } = useNotification();

        const errors = ref({});
        const router = useRouter();

        const createUser = () => {
            axios
                .post("/api/register", form.value)
                .then((response) => {
                    console.log("saved", response.data);
                    router.push({ name: "User" });
                    notify({
                        title: "Success",
                        text: "Data berhasil disimpan",
                        type: "success",
                    });
                })
                .catch((error) => {
                    errors.value = error.response.data.errors;
                    notify({
                        title: "Error",
                        text: "Data gagal disimpan",
                        type: "error",
                    });
                });
        };

        const getDataRoles = () => {
            axios.get("/api/roles").then((response) => {
                role.value.roles = response.data; // Populate role.value.roles
                console.log(role.value.roles);
            });
        };

        const userData = getUser();

        const is = (role, userData) => {
            if (userData && userData.data.roles) {
                return userData.data.roles.includes(role);
            }
            return false;
        };

        const hasAnyRole = (roles, userData) => {
            if (userData && userData.data.roles) {
                const userRoles = userData.data.roles;
                return roles
                    .split("|")
                    .some((role) => userRoles.includes(role));
            }
            return false;
        };

        onMounted(() => {
            getDataRoles();
        });

        return {
            title,
            form,
            errors,
            createUser,
            getDataRoles,
            role,
            is,
            userData,
            hasAnyRole,
        };
    },
};
</script>

<style scoped>
.card {
    width: 50%;
    margin: 0 auto;
    margin-top: 10%;
    padding: 1rem;
}

.card form {
    width: 100%;
    padding: 0.5rem;
}
</style>
