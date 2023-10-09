<template>
    <div class="mb-3">
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
                        <span v-for="(role, index) in user.roles" :key="index">
                            {{ role.name }}
                            <span v-if="index < user.roles.length - 1">, </span>
                        </span>
                    </td>
                    <td>
                        <a
                            href=""
                            class="btn btn-info text-white"
                            @click.prevent="editUsers(user.id)"
                        >
                            <font-awesome-icon icon="fa-solid fa-edit" />
                        </a>
                        <a
                            href=""
                            class="btn btn-danger text-white"
                            @click.prevent="handlingDelete(user.id)"
                        >
                            <font-awesome-icon icon="fa-solid fa-trash" />
                        </a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
<script>
import { ref, onMounted } from "vue";
import axios from "axios";
import { useRouter } from "vue-router";
import { useNotification } from "@kyvg/vue3-notification";

export default {
    // props: ["userData"],
    setup() {
        const router = useRouter();
        const { notify } = useNotification();
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
        });

        return {
            users,
            editUsers,
            getUsers,
            showUserProfil,
            handlingDelete,
        };
    },
};
</script>

<style scoped>
table {
    width: 100%;
    margin: 0 auto;
    border-collapse: collapse;
    border-spacing: 0;
    border: 1px solid #ddd;
}

th,
td {
    text-align: left;
    padding: 16px;
}

tr:nth-child(even) {
    background-color: #f2f2f2;
}

th {
    background-color: #4caf50;
    color: white;
}

.btn {
    margin: 0 0.5rem;
    border: none;
}
</style>
