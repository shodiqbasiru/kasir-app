<template>
    <div v-if="hasAnyRole('pemilik|admin', userData)">
        <section>
            <h1 class="mt-5">Daftar User</h1>
            <router-link :to="{ name: 'Register' }" class="btn btn-primary">
                Tambah Pengguna
            </router-link>
            <div>
                <table class="table table-striped mt-3">
                    <thead>
                        <tr>
                            <th scope="col">Nama</th>
                            <th scope="col">Username</th>
                            <th scope="col">Email</th>
                            <th scope="col">Role</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="user in users" :key="user.id">
                            <td>{{ user.name }}</td>
                            <td>{{ user.username }}</td>
                            <td>{{ user.email }}</td>
                            <td>
                                <span
                                    v-for="(role, index) in user.roles"
                                    :key="index"
                                >
                                    {{ role.name }}
                                    <span v-if="index < user.roles.length - 1"
                                        >,
                                    </span>
                                </span>
                            </td>
                            <td>
                                <a
                                    href=""
                                    class="btn btn-info text-white"
                                    @click.prevent="editUsers(user.id)"
                                >
                                    <font-awesome-icon
                                        icon="fa-solid fa-edit"
                                    />
                                </a>
                                <a
                                    href=""
                                    class="btn btn-danger text-white"
                                    @click.prevent="handlingDelete(user.id)"
                                >
                                    <font-awesome-icon
                                        icon="fa-solid fa-trash"
                                    />
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
    </div>
    <forbidden v-else />
</template>

<script>
import { ref, onMounted, inject } from "vue";
import axios from "axios";
import { useRouter } from "vue-router";
import { useNotification } from "@kyvg/vue3-notification";
import Forbidden from "../errors/Forbidden.vue";

export default {
    components: {
        Forbidden,
    },
    setup() {
        const router = useRouter();
        const { notify } = useNotification();
        const { getUser } = inject("getUser");
        const users = ref([]);

        const getUsers = () => {
            axios
                .get("/api/users")
                .then((response) => {
                    users.value = response.data.data;
                })
                .catch((error) => {
                    notify({
                        title: "Error",
                        body: error.message,
                        type: "danger",
                    });
                });
        };

        const editUsers = (id) => {
            router.push({
                name: "EditUser",
                params: { id },
            });
        };

        const showUserProfil = (id) => {
            router.push({
                name: "Profil",
                params: { id },
            });
        };

        const userData = getUser();

        const is = (role, userData) => {
            if (userData) {
                return userData.data.roles.includes(role);
            }
            return false;
        };

        const hasAnyRole = (roles, userData) => {
            if (userData) {
                const userRoles = userData.data.roles;
                return roles
                    .split("|")
                    .some((role) => userRoles.includes(role));
            }
            return false;
        };

        const handlingDelete = (id) => {
            if (confirm("Apakah anda yakin ingin menghapus data ini?")) {
                axios
                    .delete(`/api/users/${id}`)
                    .then((response) => {
                        notify({
                            title: "Success",
                            body: response.data.message,
                            type: "success",
                        });
                        getUsers();
                    })
                    .catch((error) => {
                        notify({
                            title: "Error",
                            body: error.message,
                            type: "danger",
                        });
                    });
            }
        };

        onMounted(() => {
            getUsers();
            console.log(userData.data.roles);
        });

        return {
            users,
            editUsers,
            getUsers,
            showUserProfil,
            userData,
            is,
            hasAnyRole,
            handlingDelete,
        };
    },
};
</script>

<style scoped></style>
