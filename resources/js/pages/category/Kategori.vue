<template>
    <div v-if="is('admin', userData)">
        <h1 class="mt-5">Kategori</h1>
        <div class="content">
            <div class="header">
                <h5>List Kategori</h5>
                <a href="" class="btn btn-primary" @click.prevent="createData()"
                    >Tambah Data</a
                >
            </div>

            <div class="body">
                <div class="table">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Kategori</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="(category, index) in categories"
                                :key="category.id"
                            >
                                <td>{{ index + 1 }}</td>
                                <td>{{ category.nama_kategori }}</td>
                                <td>
                                    <a
                                        href=""
                                        class="btn btn-success"
                                        @click.prevent="showDetail(category.id)"
                                    >
                                        <font-awesome-icon
                                            icon="fa-solid fa-eye"
                                        />
                                    </a>
                                    <a
                                        href=""
                                        class="btn btn-danger"
                                        @click.prevent="
                                            handlingDelete(category.id)
                                        "
                                    >
                                        <font-awesome-icon
                                            icon="fa-solid fa-trash"
                                        />
                                    </a>
                                    <a
                                        href=""
                                        class="btn btn-warning"
                                        @click.prevent="editData(category.id)"
                                    >
                                        <font-awesome-icon
                                            icon="fa-solid fa-edit"
                                        />
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div v-else>
        <Forbidden />
    </div>
</template>

<script>
import { ref, onMounted } from "vue";
import axios from "axios";
import { useRouter } from "vue-router";
import { inject } from "vue";
import { useNotification } from "@kyvg/vue3-notification";
import Forbidden from "../errors/Forbidden.vue";

export default {
    components: {
        Forbidden,
    },
    setup() {
        const { getUser } = inject("getUser");
        const categories = ref([]);
        const router = useRouter();
        const { notify } = useNotification();

        const getCategories = () => {
            axios.get("/api/kategori").then((response) => {
                categories.value = response.data.data;
            });
        };

        const showDetail = (id) => {
            router.push({
                name: "KategoriDetail",
                params: { id },
            });
        };

        const createData = () => {
            router.push({ name: "KategoriCreate" });
        };

        const handlingDelete = (id) => {
            if (confirm("Apakah anda yakin ingin menghapus data ini?")) {
                axios.delete("/api/kategori/" + id).then((response) => {
                    console.log(response);
                    if (response.data.status) {
                        notify({
                            type: "success",
                            text: response.data.message,
                            speed: 500,
                        });
                        getCategories();
                    }
                });
            }
        };

        const editData = (id) => {
            router.push({
                name: "KategoriEdit",
                params: { id },
            });
        };

        const userData = getUser();
        console.log(userData.data.roles);

        const is = (role, userData) => {
            if (userData && userData.data.roles) {
                return userData.data.roles.includes(role);
            }
            return false;
        };

        const hasAnyRole = (roles, userData) => {
            if (userData && userData.roles) {
                const userRoles = userData.roles;
                return roles
                    .split("|")
                    .some((role) => userRoles.includes(role));
            }
            return false;
        };

        onMounted(() => {
            getCategories();
        });

        return {
            categories,
            getCategories,
            showDetail,
            createData,
            handlingDelete,
            editData,
            is,
            hasAnyRole,
            userData,
        };
    },
};
</script>

<style scoped>
.content {
    padding: 1rem;
    border: 1px solid #ccc;
    border-radius: 4px;
}

.content .header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1px solid #ccc;
    padding: 1rem 0;
}

.content .header a.btn-primary {
    background-color: rgb(0, 144, 144);
}
.content .body {
    margin-top: 1rem;
}

.content .body .table {
    overflow-x: auto;
}

.content .body .table table {
    width: 100%;
    border-collapse: collapse;
}

.content .body .table table thead tr th {
    padding: 0.5rem 1rem;
    border: 1px solid #ccc;
    background-color: rgb(0, 144, 144);
    color: white;
    text-align: center;
}

.content .body .table table tbody tr td {
    padding: 0.5rem 1rem;
    border: 1px solid #ccc;
    text-align: center;
}

.content .body .table table tbody tr td a.btn {
    margin-right: 0.5rem;
}

.content .body .table table tbody tr td a.btn-success {
    background-color: rgb(0, 144, 144);
}

.content .body .table table tbody tr td a.btn-danger {
    background-color: rgb(255, 0, 0);
}

.content .body .table table tbody tr td a.btn-warning {
    background-color: rgb(255, 165, 0);
}

.content .body .table table tbody tr td a.btn-success:hover {
    background-color: rgb(0, 144, 144);
}

.content .body .table table tbody tr td a.btn-danger:hover {
    background-color: rgb(255, 0, 0);
}

.content .body .table table tbody tr td a.btn-warning:hover {
    background-color: rgb(255, 165, 0);
}
</style>
