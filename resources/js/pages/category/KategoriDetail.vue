<template>
    <div v-if="is('admin', userData)">
        <section v-if="id">
            <h1 class="mt-5">
                Kategori {{ data.detailKategori.nama_kategori }}
            </h1>
            <div class="card">
                <div class="card-header">
                    <h5>{{ data.detailKategori.nama_kategori }}</h5>
                </div>
                <div
                    class="card-body"
                    v-if="
                        data.detailKategori.barang &&
                        data.detailKategori.barang.length > 0
                    "
                >
                    <ol>
                        <li
                            v-for="barang in data.detailKategori.barang"
                            :key="barang.id"
                        >
                            <p>
                                Nama Barang:
                                <strong>{{ barang.nama_barang }}</strong>
                            </p>
                            <p>
                                Harga:
                                <strong>Rp.{{ barang.harga_barang }}</strong>
                            </p>
                            <p>
                                Stok: <strong>{{ barang.stok_barang }}</strong>
                            </p>
                        </li>
                    </ol>
                    <a
                        href="#"
                        class="btn btn-primary m-3"
                        @click.prevent="backToKategori"
                        >Kembali</a
                    >
                </div>
                <div class="card-body" v-else>
                    <p>Belum ada data</p>
                    <a
                        href="#"
                        class="btn btn-primary m-3"
                        @click.prevent="backToKategori"
                        >Kembali</a
                    >
                </div>
            </div>
        </section>
    </div>
    <div v-else>
        <Forbidden />
    </div>
</template>

<script>
import axios from "axios";
import { ref, onMounted, inject } from "vue";
import { useRouter } from "vue-router";
import Forbidden from "../errors/Forbidden.vue";

export default {
    props: ["id"],
    components: {
        Forbidden,
    },
    setup(props) {
        const data = ref({ detailKategori: {} });
        const { getUser } = inject("getUser");
        const router = useRouter();

        const getKategori = () => {
            axios.get("/api/kategori/" + props.id).then((Response) => {
                data.value.detailKategori = Response.data.data;
                console.log(data.value.detailKategori);
            });
        };

        const backToKategori = () => {
            router.push({ name: "Kategori" });
        };

        const userData = getUser();
        const is = (role, userData) => {
            if (userData && userData.data && userData.data.roles) {
                return userData.data.roles.includes(role);
            }
            return false;
        };

        const hasAnyRole = (roles, userData) => {
            if (userData && userData.data.roles) {
                const userRoles = userData.roles;
                return roles
                    .split("|")
                    .some((role) => userRoles.includes(role));
            }

            return false;
        };

        onMounted(() => {
            if (props.id) {
                getKategori();
            }
        });
        return { userData, getKategori, backToKategori, data, is, hasAnyRole };
    },
};
</script>

<style scoped></style>
