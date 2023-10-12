<template>
    <div v-if="is('admin')">
        <h1>Tambah Data</h1>
        <form @submit.prevent="handleSubmit()" action="/barang">
            <div class="form-group">
                <label for="id_barang">Kode Barang</label>
                <input
                    type="text"
                    name="id_barang"
                    id="id_barang"
                    class="form-control"
                    v-model="data.form.kode_barang"
                />
                <div class="error" v-if="data.errors.kode_barang">
                    {{ data.errors.kode_barang[0] }}
                </div>
            </div>
            <div class="form-group">
                <label for="nama_barang">Nama Barang</label>
                <input
                    type="text"
                    name="nama_barang"
                    id="nama_barang"
                    class="form-control"
                    v-model="data.form.nama_barang"
                />
                <div class="error" v-if="data.errors.nama_barang">
                    {{ data.errors.nama_barang[0] }}
                </div>
            </div>
            <div class="form-group">
                <label for="harga_barang">Harga Barang</label>
                <input
                    type="text"
                    name="harga_barang"
                    id="harga_barang"
                    class="form-control"
                    v-model="data.form.harga_barang"
                />
                <div class="error" v-if="data.errors.harga_barang">
                    {{ data.errors.harga_barang[0] }}
                </div>
            </div>
            <div class="form-group">
                <label for="stok_barang">Stok Barang</label>
                <input
                    type="text"
                    name="stok_barang"
                    id="stok_barang"
                    class="form-control"
                    v-model="data.form.stok_barang"
                />
                <div class="error" v-if="data.errors.stok_barang">
                    {{ data.errors.stok_barang[0] }}
                </div>
            </div>

            <!-- todo: perbaiki message error -->
            <div class="form-group">
                <label for="category_id">Kategori</label>
                <select
                    name="category_id"
                    id="category_id"
                    class="form-control"
                    v-model="data.form.category_id"
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
                <div class="error" v-if="data.errors.nama_kategori">
                    {{ data.errors.nama_kategori[0] }}
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
                    v-model="data.form.deskripsi_barang"
                ></textarea>
                <div class="error" v-if="data.errors.deskripsi_barang">
                    {{ data.errors.deskripsi_barang[0] }}
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
import { ref, reactive, onMounted } from "vue";
import { useRouter } from "vue-router";
import { useNotification } from "@kyvg/vue3-notification";
import { useCookies } from "vue3-cookies";
import Forbidden from "../errors/Forbidden.vue";
export default {
    components: {
        Forbidden,
    },
    setup() {
        const { notify } = useNotification();
        const router = useRouter();
        const { cookies } = useCookies();
        const role = ref([]);
        const data = reactive({
            form: {
                kode_barang: "",
                nama_barang: "",
                harga_barang: "",
                stok_barang: "",
                category_id: "",
                deskripsi_barang: "",
            },
            errors: {},
        });
        const categories = ref([]);

        const getCategories = () => {
            axios.get("/api/kategori").then((response) => {
                categories.value = response.data.data;
                // console.log(categories.value);
            });
        };
        const handleSubmit = () => {
            console.log(data.form);
            axios
                .post("/api/barang", data.form)
                .then((response) => {
                    if (response.data.status) {
                        // console.log(response);

                        notify({
                            type: "success",
                            text: response.data.message,
                            speed: 500,
                        });
                        router.push({ name: "Barang" });
                    }
                })
                .catch((error) => {
                    data.errors = error.response.data.errors;
                });
        };

        const is = (roles) => {
            if (role.value === roles) {
                return true;
            } else {
                return false;
            }
        };

        onMounted(() => {
            role.value = cookies.get("roles");
            getCategories();
        });

        return {
            data,
            categories,
            handleSubmit,
            is,
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
