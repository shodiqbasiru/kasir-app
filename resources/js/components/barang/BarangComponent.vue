<template>
    <div class="table">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th>Harga Barang</th>
                    <th>Stok Barang</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(item, index) in items" :key="item.id">
                    <td>{{ index + 1 }}</td>
                    <td>{{ item.kode_barang }}</td>
                    <td>{{ item.nama_barang }}</td>
                    <td>{{ formatRupiah(item.harga_barang) }}</td>
                    <td>{{ item.stok_barang }}</td>
                    <td>
                        <a
                            href=""
                            class="btn btn-success"
                            @click.prevent="showDetailBarang(item.id)"
                        >
                            <font-awesome-icon icon="fa-solid fa-eye" />
                        </a>
                        <a
                            href=""
                            class="btn btn-danger"
                            @click.prevent="handlingDelete(item.id)"
                        >
                            <font-awesome-icon icon="fa-solid fa-trash" />
                        </a>

                        <a
                            href=""
                            class="btn btn-warning"
                            @click.prevent="editData(item.id)"
                        >
                            <font-awesome-icon icon="fa-solid fa-edit" />
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
    setup() {
        const items = ref([]);
        const router = useRouter();
        const { notify } = useNotification();

        const getItems = () => {
            axios.get("/api/barang").then((response) => {
                items.value = response.data.data;
                console.log(response.data);
            });
        };

        const showDetailBarang = (id) => {
            router.push({
                name: "BarangDetail",
                params: { id },
            });
        };

        const createData = () => {
            router.push({
                name: "BarangCreate",
            });
        };

        const editData = (id) => {
            router.push({
                name: "BarangEdit",
                params: { id },
            });
        };

        const handlingDelete = (id) => {
            if (confirm("Apakah anda yakin ingin menghapus data ini?")) {
                axios.delete("/api/barang/" + id).then((response) => {
                    console.log(response);
                    if (response.data.status) {
                        notify({
                            type: "success",
                            text: response.data.message,
                            speed: 500,
                        });
                        getItems();
                    }
                });
            }
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

        onMounted(() => {
            getItems();
        });

        return {
            items,
            getItems,
            showDetailBarang,
            createData,
            editData,
            handlingDelete,
            formatRupiah,
        };
    },
};
</script>

<style scoped>
a.btn {
    text-decoration: none;
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 4px;
    font-size: 14px;
    border: none;
}

.table {
    overflow-x: auto;
}

.table table {
    width: 100%;
    border-collapse: collapse;
}

.table table thead tr th {
    padding: 0.5rem 1rem;
    border: 1px solid #ccc;
    background-color: rgb(0, 144, 144);
    color: white;
    text-align: center;
}

.table table tbody tr td {
    padding: 0.5rem 1rem;
    border: 1px solid #ccc;
    text-align: center;
}

.table table tbody tr td a.btn {
    margin-right: 0.5rem;
}

.table table tbody tr td a.btn-success {
    background-color: rgb(0, 144, 144);
}

.table table tbody tr td a.btn-danger {
    background-color: rgb(255, 0, 0);
}

.table table tbody tr td a.btn-warning {
    background-color: rgb(255, 165, 0);
}

.table table tbody tr td a.btn-success:hover {
    background-color: rgb(0, 144, 144);
}

.table table tbody tr td a.btn-danger:hover {
    background-color: rgb(255, 0, 0);
}

.table table tbody tr td a.btn-warning:hover {
    background-color: rgb(255, 165, 0);
}
</style>
