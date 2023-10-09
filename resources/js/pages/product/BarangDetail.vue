<template>
    <section v-if="id">
        <h1 class="mt-5">Detail Barang</h1>
        <div class="card">
            <h5 class="card-header">{{ detailBarang.nama_barang }}</h5>
            <div class="card-body">
                <h5 class="card-title">
                    {{ formatRupiah(detailBarang.harga_barang) }}
                </h5>
                <p>Jumlah : {{ detailBarang.stok_barang }}</p>
                <p>Jenis Kategori : {{ detailBarang.category_id }}</p>
                <p>
                    Deskripsi : <br />
                    {{ detailBarang.deskripsi_barang }}
                </p>
                <a
                    href="#"
                    class="btn btn-primary"
                    @click.prevent="backToBarang"
                    >Kembali</a
                >
            </div>
        </div>
    </section>
</template>

<script>
export default {
    props: ["id"],
    data() {
        return {
            detailBarang: {},
        };
    },
    mounted() {
        this.getItem();
    },
    methods: {
        getItem() {
            axios.get("/api/barang/" + this.id).then((Response) => {
                this.detailBarang = Response.data;
                console.log(this.detailBarang);
            });
        },
        formatRupiah(angka) {
            if (typeof angka !== "undefined") {
                var number_string = angka.toString(),
                    split = number_string.split(","),
                    sisa = split[0].length % 3,
                    rupiah = split[0].substr(0, sisa),
                    ribuan = split[0].substr(sisa).match(/\d{3}/gi);

                // tambahkan titik jika yang di input sudah menjadi angka ribuan
                if (ribuan) {
                    var separator = sisa ? "." : "";
                    rupiah += separator + ribuan.join(".");
                }

                rupiah =
                    split[1] !== undefined ? rupiah + "," + split[1] : rupiah;
                return "Rp. " + rupiah;
            } else {
                return "Rp. 0"; // Atau sesuaikan dengan pesan yang sesuai jika angka tidak didefinisikan
            }
        },
        backToBarang() {
            this.$router.push({
                name: "Barang",
            });
        },
    },
};
</script>

<style scoped>
.card {
    margin-top: 2rem;
}

.card-header {
    background-color: #f5f5f5;
    border-bottom: 1px solid #e3e3e3;
}

.card-body {
    padding: 1rem;
}

.card-body .card-title {
    font-size: 1.25rem;
    font-weight: 500;
    margin-bottom: 0.5rem;
}

.card-body p {
    margin-bottom: 0.25rem;
}

.card-body p:last-child {
    margin-bottom: 0;
}

.card-body a {
    text-decoration: none;
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 4px;
    font-size: 14px;
    border: none;
}

.card-body a.btn-primary {
    background-color: rgb(0, 144, 144);
}

.card-body a.btn-primary:hover {
    background-color: rgb(11, 173, 173);
}
</style>
