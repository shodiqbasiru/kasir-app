<template>
    <div v-if="hasAnyRole('admin|pemilik', userData)">
        <div class="container">
            <div class="row justify-content-center">
                <h1 class="mt-5">Laporan Transaksi</h1>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">No Transaksi</th>
                            <th scope="col">Tgl Transaksi</th>
                            <th scope="col">Kode Barang</th>
                            <th scope="col">Total Harga</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template v-for="(item, index) in items">
                            <tr :key="item.id" v-if="item.id">
                                <td>{{ index + 1 }}</td>
                                <td>{{ item.no_transaksi }}</td>
                                <td>{{ item.tanggal_transaksi }}</td>
                                <td>{{ getKodeBarang(item) }}</td>
                                <td>{{ formatRupiah(item.total_harga) }}</td>
                                <td>
                                    <a
                                        href=""
                                        class="btn btn-success"
                                        @click.prevent="showDetail(item.id)"
                                    >
                                        <font-awesome-icon
                                            icon="fa-solid fa-eye"
                                        />
                                    </a>
                                    <a
                                        href=""
                                        class="btn btn-danger"
                                        @click.prevent="handlingDelete(item.id)"
                                    >
                                        <font-awesome-icon
                                            icon="fa-solid fa-trash"
                                        />
                                    </a>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
            <a
                href=""
                class="btn btn-primary"
                @click.prevent="$router.push({ name: 'Report' })"
                >Kembali</a
            >
        </div>
    </div>
    <Forbidden v-else />
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
        const items = ref([]);
        const router = useRouter();
        const { notify } = useNotification();
        const { getUser } = inject("getUser");

        const getDataTransaction = () => {
            axios.get("/api/transaction").then((response) => {
                console.log(response.data.data);
                items.value = response.data.data;
            });
        };
        const getKodeBarang = (item) => {
            return item.transaction_details
                .map((detail) => detail.barang.kode_barang)
                .join(", ");
        };
        const showDetail = (id) => {
            // console.log(id);
            router.push({ name: "ReportDetail", params: { id } });
        };
        const handlingDelete = (id) => {
            if (!confirm("Apakah anda yakin ingin menghapus data ini?")) return;
            axios.delete(`/api/transaction/${id}`).then((response) => {
                console.log(response.data);
                notify({
                    type: "success",
                    text: response.data.message,
                    speed: 500,
                });
                getDataTransaction();
            });
        };
        const formatRupiah = (angka) => {
            if (typeof angka !== "undefined") {
                var number_string = angka.toString(),
                    split = number_string.split(","),
                    sisa = split[0].length % 3,
                    rupiah = split[0].substr(0, sisa),
                    ribuan = split[0].substr(sisa).match(/\d{3}/gi);

                if (ribuan) {
                    var separator = sisa ? "." : "";
                    rupiah += separator + ribuan.join(".");
                }

                rupiah =
                    split[1] !== undefined ? rupiah + "," + split[1] : rupiah;
                return "Rp. " + rupiah;
            } else {
                return "Rp. 0";
            }
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

        onMounted(() => {
            getDataTransaction();
            console.log(userData.data.roles);
        });

        return {
            items,
            getKodeBarang,
            showDetail,
            handlingDelete,
            formatRupiah,
            is,
            hasAnyRole,
            userData,
        };
    },
};
</script>

<style scoped>
table {
    margin-top: 1rem;
}

table thead tr th {
    text-align: center;
    padding: 0.5rem 1rem;
    border: 1px solid #ccc;
    background-color: rgb(0, 144, 144);
    color: white;
    text-align: center;
}

table tbody tr td {
    text-align: center;
    padding: 0.5rem 1rem;
    border: 1px solid #ccc;
    text-align: center;
}

table tbody tr td button {
    margin: 0 0.5rem;
    border: none;
}

table tbody tr td button.btn-success {
    background-color: rgb(0, 144, 144);
}

table tbody tr td button.btn-success:hover {
    background-color: rgb(20, 159, 159);
}
table tbody tr td button.btn-primary {
    background-color: rgb(255, 165, 0);
}

table tbody tr td button.btn-primary:hover {
    background-color: rgb(255, 199, 95);
}

table tbody tr td button.btn-danger {
    background-color: rgb(255, 0, 0);
}

table tbody tr td button.btn-danger:hover {
    background-color: rgb(255, 79, 79);
}
</style>
