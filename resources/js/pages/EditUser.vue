<template>
    <section>
        <div class="card">
            <div class="header text-center mb-5">
                <h1>{{ title }}</h1>
            </div>
            <form action="/user" @submit.prevent="handleSubmit">
                <div class="mb-3">
                    <label for="name" class="form-label">Nama Pengguna</label>
                    <input
                        type="text"
                        name="name"
                        class="form-control"
                        id="name"
                        v-model="form.name"
                    />
                </div>
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
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

                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </section>
</template>

<script>
import axios from "axios";
import { ref } from "vue";
import { useRouter } from "vue-router";
import { useNotification } from "@kyvg/vue3-notification";

export default {
    props: ["id"],

    setup(props) {
        const title = ref("Edit Pengguna");
        const form = ref({
            name: "",
            username: "",
            selectedRole: "",
        });
        const role = ref({ roles: [] });
        const { notify } = useNotification();
        const errors = ref({});
        const router = useRouter();

        const handleSubmit = () => {
            axios.put("/api/users/" + props.id, form.value).then((response) => {
                console.log(response.data);
                router.push({ name: "User" });
                notify({
                    title: "Success",
                    text: response.data.message,
                    type: "success",
                });
            });
        };

        const getUser = () => {
            axios.get("/api/users/" + props.id + "/edit").then((response) => {
                form.value.name = response.data.name;
                form.value.username = response.data.username;
                form.value.email = response.data.email;
                form.value.selectedRole = response.data.roles[0].id;
            });
        };

        const getDataRoles = () => {
            axios.get("/api/roles").then((response) => {
                role.value.roles = response.data;
                console.log(role.value.roles);
            });
        };

        return {
            title,
            form,
            errors,
            getDataRoles,
            getUser,
            handleSubmit,
            role,
        };
    },

    mounted() {
        this.getDataRoles();
        this.getUser();
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
