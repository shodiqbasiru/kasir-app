<template>
    <section>
        <div class="content">
            <div class="card card-1">
                <div class="card-body">
                    <h4>
                        Grafik penjualan <br />
                        <span class="small text-muted">Per 30 oktober</span>
                    </h4>
                    <ChartComponent />
                </div>
            </div>
            <div class="card card-2">
                <div class="card-body">
                    <h4>Total Pendapatan</h4>
                    <p>{{ formatRupiah(totalPrice) }}</p>
                </div>
            </div>
            <div class="card card-3">
                <div class="card-body">
                    <h4>Total Pengguna</h4>
                    <p>{{ countUsers }}</p>
                </div>
            </div>
            <div class="card card-4">
                <div class="card-body">
                    <h4>Total Barang</h4>
                    <p>{{ countBarang }}</p>
                </div>
            </div>
            <div class="card card-5">
                <div class="card-body">
                    <h4>Jumlah Pembeli</h4>
                    <p>{{ countBuyers }}</p>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import axios from "axios";
import { ref, onMounted, computed } from "vue";
import ChartComponent from "../components/ChartComponent.vue";

export default {
    components: {
        ChartComponent,
    },
    setup() {
        const users = ref([]);
        const items = ref([]);
        const transactions = ref([]);
        const getBarang = () => {
            axios.get("/api/barang").then((response) => {
                items.value = response.data.data;
            });
        };

        const getUsers = () => {
            axios.get("/api/users").then((response) => {
                users.value = response.data.data;
            });
        };

        const getTransaksi = () => {
            axios.get("/api/transaction").then((response) => {
                transactions.value = response.data.data;
                console.log(transactions.value);
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

        const countBarang = computed(() => {
            return items.value.length;
        });

        const countUsers = computed(() => {
            return users.value.length;
        });

        const totalPrice = computed(() => {
            return transactions.value.reduce((total, transaction) => {
                return total + transaction.total_harga;
            }, 0);
        });

        const countBuyers = computed(() => {
            return transactions.value.length;
        });

        onMounted(() => {
            getBarang();
            getUsers();
            getTransaksi();
        });

        return {
            items,
            countBarang,
            countUsers,
            getBarang,
            getUsers,
            getTransaksi,
            totalPrice,
            formatRupiah,
            countBuyers,
        };
    },
};
</script>

<style scoped>
h1 {
    font-size: 2em;
    text-align: center;
    color: #333;
    margin: 2rem 0;
}

.content {
    display: grid;
    margin: 1rem;
}

.content .card-1 {
    grid-column: 1 / span 2;
    grid-row: 1 / span 3;
}

.content .card-2 {
    grid-column: 3 / span 2;
    grid-row: 1;
}

.content .card-3 {
    grid-column: 3 / span 3;
    grid-row: 2;
}

.content .card-4 {
    grid-column: 3 / span 3;
    grid-row: 3;
}

.content .card-5 {
    grid-column: 5;
    grid-row: 1;
}

.card {
    margin: 1rem;
}

.card-body {
    text-align: center;
}

.card-body h4 {
    font-size: 1.5em;
}

.card-body p {
    font-size: 20px;
    font-weight: bold;
    color: #04c71e;
}
</style>
