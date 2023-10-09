<template>
    <section v-if="id">
        <h1 class="mt-5">
            {{ title }}
        </h1>
        <div class="card">
            <div class="card-header">
                No Transaksi: {{ detailTransaction.no_transaksi }}
            </div>
            <div class="card-body">
                <ol>
                    <li>
                        <p>
                            Tanggal Transaksi:
                            <strong>{{
                                detailTransaction.tanggal_transaksi
                            }}</strong>
                        </p>
                    </li>
                    <li>
                        <h5>List barang:</h5>
                        <ul>
                            <li
                                v-for="item in detailTransaction.transaction_details"
                                :key="item.id"
                            >
                                <p>
                                    Kode Barang:
                                    <strong>{{
                                        item.barang.kode_barang
                                    }}</strong>
                                </p>
                                <p>
                                    Nama barang:
                                    <strong>{{
                                        item.barang.nama_barang
                                    }}</strong>
                                </p>
                                <p>
                                    Harga:
                                    <strong>{{
                                        formatRupiah(item.barang.harga_barang)
                                    }}</strong>
                                </p>
                                <p>
                                    Jumlah:
                                    <strong>{{ item.qty }}</strong>
                                </p>
                            </li>
                        </ul>
                        <h5>
                            Total Harga:
                            <strong>{{
                                formatRupiah(detailTransaction.total_harga)
                            }}</strong>
                        </h5>
                    </li>
                </ol>
                <a
                    href="#"
                    class="btn btn-primary m-3"
                    @click.prevent="backToReport"
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
            detailTransaction: {},
            title: "Detail Transaksi",
        };
    },
    mounted() {
        this.getData();
    },
    methods: {
        getData() {
            axios.get("/api/transaction/" + this.id).then((Response) => {
                this.detailTransaction = Response.data.data;
                console.log(Response.data.data);
            });
        },
        backToReport() {
            this.$router.push({ name: "Report" });
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
    },
};
</script>

<style scoped></style>
