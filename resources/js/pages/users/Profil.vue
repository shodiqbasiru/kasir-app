<template>
    <section v-if="id">
        <h1 class="title">Hello {{ detailUser.name }}</h1>
        <ul>
            <li>Email :{{ detailUser.email }}</li>
            <li>{{ detailUser.email_verified_at }}</li>
        </ul>
        <router-link :to="{ name: 'User' }">Kembali</router-link>
    </section>
</template>

<script>
export default {
    props: ["id"],
    data() {
        return {
            detailUser: {},
        };
    },
    mounted() {
        this.getUser();
    },
    methods: {
        getUser() {
            axios.get("/api/users/" + this.id).then((Response) => {
                this.detailUser = Response.data;
            });
        },
    },
};
</script>

<style>
.title {
    text-transform: capitalize;
}
</style>
