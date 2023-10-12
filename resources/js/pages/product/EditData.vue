<template>
    <div v-if="is('admin')">
        <h1>Edit Data</h1>
        <form @submit.prevent="handleUpdate()" action="/barang">
            <div class="form-group">
                <label for="id_barang">Kode Barang</label>
                <input
                    type="text"
                    name="id_barang"
                    id="id_barang"
                    class="form-control"
                    v-model="data.form.kode_barang"
                />
                <div class="error" v-if="data.error.kode_barang">
                    {{ data.error.kode_barang[0] }}
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
                <div class="error" v-if="data.error.nama_barang">
                    {{ data.error.nama_barang[0] }}
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
                <div class="error" v-if="data.error.harga_barang">
                    {{ data.error.harga_barang[0] }}
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
                <div class="error" v-if="data.error.stok_barang">
                    {{ data.error.stok_barang[0] }}
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
                <div class="error" v-if="data.error.nama_kategori">
                    {{ data.error.nama_kategori[0] }}
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
                <div class="error" v-if="data.error.deskripsi_barang">
                    {{ data.error.deskripsi_barang[0] }}
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
    props: ["id"],
    components: {
        Forbidden,
    },
    setup(props) {
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
            error: {},
        });
        const categories = ref([]);

        const getCategories = () => {
            axios.get("/api/kategori").then((response) => {
                categories.value = response.data.data;
                // console.log(categories.value);
            });
        };
        const handleUpdate = () => {
            axios
                .put(`/api/barang/${props.id}`, data.form)
                .then((response) => {
                    if (response.data.status) {
                        console.log(response);
                        notify({
                            type: "success",
                            text: response.data.message,
                            speed: 500,
                        });

                        router.push({ name: "Barang" });
                    }
                })
                .catch((error) => {
                    if (error.response.status == 422) {
                        error.value = error.response.data.errors;
                    }
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

        const getItem = () => {
            axios.get(`/api/barang/${props.id}`).then((response) => {
                data.form.kode_barang = response.data.kode_barang;
                data.form.nama_barang = response.data.nama_barang;
                data.form.harga_barang = response.data.harga_barang;
                data.form.stok_barang = response.data.stok_barang;
                data.form.category_id = response.data.category_id;
                data.form.deskripsi_barang = response.data.deskripsi_barang;
            });
        };

        onMounted(() => {
            getItem();
            getCategories();
            role.value = cookies.get("roles");
        });

        return {
            data,
            categories,
            handleUpdate,
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
