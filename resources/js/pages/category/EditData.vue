<template>
    <div v-if="is('admin')">
        <h1>Kategori</h1>
        <form @submit.prevent="handleUpdate()" action="/kategori">
            <h3>Edit Data</h3>

            <div class="form-group">
                <label for="nama_kategori">Nama Kategori</label>
                <input
                    type="text"
                    name="nama_kategori"
                    id="nama_kategori"
                    class="form-control"
                    v-model="data.form.nama_kategori"
                />
                <div class="error" v-if="data.error.nama_kategori">
                    {{ data.error.nama_kategori[0] }}
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
    <div v-else>
        <Forbidden />
    </div>
</template>

<script>
import { ref, reactive, onMounted } from "vue";
import axios from "axios";
import { useRouter } from "vue-router";
import { useNotification } from "@kyvg/vue3-notification";
import Forbidden from "../errors/Forbidden.vue";
import { useCookies } from "vue3-cookies";
export default {
    props: ["id"],
    components: {
        Forbidden,
    },
    setup(props) {
        const data = reactive({ form: {}, error: {} });
        const { notify } = useNotification();
        const router = useRouter();
        const { cookies } = useCookies();
        const role = ref([]);

        const handleUpdate = () => {
            axios
                .put("/api/kategori/" + props.id, data.form)
                .then((response) => {
                    if (response.data.status) {
                        console.log(response);

                        notify({
                            type: "success",
                            text: response.data.message,
                            speed: 500,
                        });
                        router.push({ name: "Kategori" });
                    }
                })
                .catch((error) => {
                    if (error.response.status == 422) {
                        data.error = error.response.data.errors;
                    }
                });
        };
        const getCategory = () => {
            axios.get("/api/kategori/" + props.id).then((response) => {
                data.form = response.data.data;
                console.log(data.form);
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
            getCategory();

            console.log(role.value);
        });

        return { data, handleUpdate, is };
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

.error {
    color: red;
    font-size: 14px;
}
</style>
