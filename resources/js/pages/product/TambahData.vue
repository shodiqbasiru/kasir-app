<template>
    <div v-if="is('admin', userData)">
        <h1>Tambah Data</h1>
        <form @submit.prevent="handleSubmit()" action="/barang">
            <div class="form-group">
                <label for="id_barang">Kode Barang</label>
                <input
                    type="text"
                    name="id_barang"
                    id="id_barang"
                    class="form-control"
                    v-model="form.kode_barang"
                />
                <div class="error" v-if="error.kode_barang">
                    {{ error.kode_barang[0] }}
                </div>
            </div>
            <div class="form-group">
                <label for="nama_barang">Nama Barang</label>
                <input
                    type="text"
                    name="nama_barang"
                    id="nama_barang"
                    class="form-control"
                    v-model="form.nama_barang"
                />
                <div class="error" v-if="error.nama_barang">
                    {{ error.nama_barang[0] }}
                </div>
            </div>
            <div class="form-group">
                <label for="harga_barang">Harga Barang</label>
                <input
                    type="text"
                    name="harga_barang"
                    id="harga_barang"
                    class="form-control"
                    v-model="form.harga_barang"
                />
                <div class="error" v-if="error.harga_barang">
                    {{ error.harga_barang[0] }}
                </div>
            </div>
            <div class="form-group">
                <label for="stok_barang">Stok Barang</label>
                <input
                    type="text"
                    name="stok_barang"
                    id="stok_barang"
                    class="form-control"
                    v-model="form.stok_barang"
                />
                <div class="error" v-if="error.stok_barang">
                    {{ error.stok_barang[0] }}
                </div>
            </div>

            <!-- todo: perbaiki message error -->
            <div class="form-group">
                <label for="category_id">Kategori</label>
                <select
                    name="category_id"
                    id="category_id"
                    class="form-control"
                    v-model="form.category_id"
                >
                    <option value="">-- Pilih Kategori --</option>
                    <option
                        v-for="category in categories"
                        :key="category.id"
                        :value="category.id"
                    >
                        {{ category.nama_kategori }}
                    </option>
                </select>
                <div class="error" v-if="error.nama_kategori">
                    {{ error.nama_kategori[0] }}
                </div>
            </div>
            <!-- end  -->

            <div class="form-group">
                <label for="deskripsi_barang">Deskripsi Barang</label>
                <textarea
                    name="deskripsi_barang"
                    id="deskripsi_barang"
                    cols="30"
                    rows="10"
                    class="form-control"
                    v-model="form.deskripsi_barang"
                ></textarea>
                <div class="error" v-if="error.deskripsi_barang">
                    {{ error.deskripsi_barang[0] }}
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Tambah</button>
        </form>
    </div>
    <div v-else>
        <Forbidden />
    </div>
</template>

<script>
import axios from "axios";
import { ref, onMounted, inject } from "vue";
import { useRouter } from "vue-router";
import { useNotification } from "@kyvg/vue3-notification";
import Forbidden from "../errors/Forbidden.vue";
export default {
    components: {
        Forbidden,
    },
    setup() {
        const { notify } = useNotification();
        const router = useRouter();
        const { getUser } = inject("getUser");
        const form = ref({
            kode_barang: "",
            nama_barang: "",
            harga_barang: "",
            stok_barang: "",
            category_id: "",
            deskripsi_barang: "",
        });
        const categories = ref([]);
        const error = ref({ errors: {} });

        const getCategories = () => {
            axios.get("/api/kategori").then((response) => {
                categories.value = response.data.data;
                console.log(categories.value);
            });
        };
        const handleSubmit = () => {
            console.log(form.value);
            axios.post("/api/barang", form.value).then((response) => {
                if (response.data.status) {
                    console.log(response);

                    notify({
                        type: "success",
                        text: response.data.message,
                        speed: 500,
                    });
                    router.push({ name: "Barang" });
                }
            });
        };

        const userData = getUser();
        const is = (role, userData) => {
            if (userData && userData.data && userData.data.roles) {
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
            form,
            categories,
            error,
            handleSubmit,
            userData,
            is,
            hasAnyRole,
        };
    },
};
</script>

<style scoped>
form {
    width: 50%;
    margin: 0 auto;
    border: 1px solid #ccc;
    padding: 1rem;
    box-shadow: inset 0 0 3px rgba(0, 0, 0, 0.1);
}
.form-group {
    display: flex;
    flex-direction: column;
    margin-bottom: 1rem;
}

.form-group label {
    margin-bottom: 0.5rem;
    font-size: 16px;
    font-weight: 500;
}

.form-group input,
.form-group select {
    padding: 0.5rem;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 16px;
}

form button {
    padding: 0.5rem 1rem;
    border: 0;
    border-radius: 4px;
    background-color: #007bff;
    color: #fff;
    font-size: 16px;
    cursor: pointer;
}
</style>
