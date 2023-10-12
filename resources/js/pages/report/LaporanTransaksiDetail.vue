<template>
    <div v-if="hasAnyRole('admin|pemilik')">
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
                                            formatRupiah(
                                                item.barang.harga_barang
                                            )
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
    </div>
    <Forbidden v-else />
</template>

<script>
import axios from "axios";
import { ref, onMounted } from "vue";
import { useRouter } from "vue-router";
import { useCookies } from "vue3-cookies";
import Forbidden from "../errors/Forbidden.vue";

export default {
    props: ["id"],
    components: {
        Forbidden,
    },
    setup(props) {
        const title = ref("Detail Transaksi");
        const detailTransaction = ref({});
        const router = useRouter();
        const { cookies } = useCookies();
        const role = ref([]);

        const getData = () => {
            axios.get("/api/transaction/" + props.id).then((Response) => {
                detailTransaction.value = Response.data.data;
                console.log(detailTransaction.value);
            });
        };

        const backToReport = () => {
            router.push({ name: "ReportTransaksi" });
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

        const hasAnyRole = (roles) => {
            const rolesSplit = roles.split("|");
            role.value = cookies.value;

            if (role.value) {
                return rolesSplit.some((roleSplit) =>
                    role.value.includes(roleSplit)
                );
            }

            return false;
        };

        onMounted(() => {
            cookies.value = cookies.get("roles");
        });

        return {
            title,
            detailTransaction,
            getData,
            backToReport,
            formatRupiah,
            hasAnyRole,
        };
    },
};
</script>

<style scoped></style>
