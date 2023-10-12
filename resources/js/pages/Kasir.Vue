<template>
    <div v-if="is('kasir')">
        <div class="content">
            <h1 class="title mt-5">SB|Kasir</h1>
            <form action="/kasir">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="form-group">
                                <label for="tanggal_transaksi"
                                    >Tgl Transaksi</label
                                >
                                <input
                                    type="text"
                                    class="form-control"
                                    v-model="datas.tanggal_transaksi"
                                    disabled
                                />
                            </div>
                            <div class="form-group">
                                <label for="kode_barang">Kode Barang</label>
                                <select
                                    name="kode_barang"
                                    id="kode_barang"
                                    class="form-control"
                                    v-model="selectedProduct"
                                    @change="handleChange()"
                                >
                                    <option value="">
                                        --- Pilih Kode Barang ---
                                    </option>
                                    <option
                                        v-for="item in products"
                                        :key="item.id"
                                        :value="item.id"
                                    >
                                        {{ item.kode_barang }}
                                    </option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="nama_barang">Nama Barang</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    v-model="form.nama_barang"
                                    disabled
                                />
                            </div>
                            <div class="form-group">
                                <label for="harga">Harga</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    v-model="form.harga"
                                    disabled
                                />
                            </div>
                            <div class="form-group">
                                <label for="qty">Quantity</label>
                                <input
                                    type="number"
                                    class="form-control"
                                    v-model="form.qty"
                                    @input="updateSubTotal()"
                                />
                            </div>
                            <div class="form-group">
                                <label for="">Sub Total</label>
                                <input
                                    type="number"
                                    class="form-control"
                                    v-model="form.sub_total"
                                    disabled
                                />
                            </div>
                            <div
                                class="d-grid gap-2 d-md-flex justify-content-md-end cart"
                            >
                                <button
                                    class="btn btn-primary"
                                    type="button"
                                    @click.prevent="inputToCart()"
                                >
                                    <font-awesome-icon
                                        icon="fa-solid fa-cart-plus"
                                    />
                                    Tambah
                                </button>
                            </div>
                            <hr />
                            <div class="form-group m-0">
                                <label for="bayar">Bayar</label>
                                <div class="input-group mb-3">
                                    <input
                                        type="number"
                                        class="form-control"
                                        v-model="amount"
                                        placeholder="0"
                                        :disabled="dataCart.length === 0"
                                    />
                                    <button
                                        class="form-control btn btn-primary"
                                        type="button"
                                        @click.prevent="inputBayar()"
                                        :disabled="dataCart.length === 0"
                                    >
                                        Bayar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div id="print-content" class="card">
                            <div class="card-header text-center">
                                <h4>SB Store</h4>
                                <p>
                                    JL. Jakarta Perumahan Griya SYeiban Permai
                                    A.1 Kecamatan Kota Tengah, Kota Gorontalo,
                                    Provinsi Gorontalo
                                </p>
                                <p>
                                    Telp: 0822-5555-5555 | Email:
                                    blablabla@gmail.com
                                </p>
                            </div>
                            <div class="card-body">
                                <div
                                    class="header-body d-flex justify-content-between"
                                >
                                    <table>
                                        <tr>
                                            <td>No Transaksi</td>
                                            <td>:</td>
                                            <td>
                                                {{ datas.no_transaksi }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Kasir</td>
                                            <td>:</td>
                                            <td>
                                                {{ userData }}
                                            </td>
                                        </tr>
                                    </table>
                                    <table>
                                        <tr>
                                            <td>Tanggal</td>
                                            <td>:</td>
                                            <td>
                                                {{ datas.tanggal_transaksi }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Jam</td>
                                            <td>:</td>
                                            <td>{{ time }}</td>
                                        </tr>
                                    </table>
                                </div>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">Nama Barang</th>
                                            <th scope="col">Qty</th>
                                            <th scope="col">Harga</th>
                                            <th scope="col">Sub Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr
                                            v-for="item in dataCart"
                                            v-bind:key="item.id"
                                        >
                                            <td>{{ item.nama_barang }}</td>
                                            <td>{{ item.qty }}</td>
                                            <td>
                                                {{ formatRupiah(item.harga) }}
                                            </td>
                                            <td>
                                                {{
                                                    formatRupiah(item.sub_total)
                                                }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="body-footer">
                                    <div class="d-flex justify-content-between">
                                        <p>Total</p>
                                        <input
                                            :value="formatRupiah(form.total)"
                                            class="nota mb-3"
                                            disabled
                                        />
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <p>Bayar</p>
                                        <input
                                            :value="formatRupiah(form.bayar)"
                                            class="nota mb-3"
                                            disabled
                                        />
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <p>Kembalian</p>
                                        <input
                                            :value="
                                                formatRupiah(form.kembalian)
                                            "
                                            class="nota mb-3"
                                            disabled
                                        />
                                    </div>
                                    <div class="actions">
                                        <a
                                            href=""
                                            v-if="showPrintButton"
                                            @click.prevent="download"
                                            class="btn btn-primary export-hidden"
                                        >
                                            <font-awesome-icon
                                                icon="fa-solid fa-print"
                                            />
                                            Print</a
                                        >
                                        <button
                                            class="btn btn-primary export-hidden"
                                            type="submit"
                                            @click.prevent="getDataToPost()"
                                        >
                                            <font-awesome-icon
                                                icon="fa-solid fa-check-to-slot"
                                            />
                                            Selesai
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="new-transaction">
                            <a
                                href=""
                                class="btn btn-warning"
                                @click.prevent="newTransaction"
                                >New Transaction</a
                            >
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <forbidden v-else />
</template>
<script>
import { ref, onMounted, reactive } from "vue";
import axios from "axios";
import { useNotification } from "@kyvg/vue3-notification";
import Forbidden from "./errors/Forbidden.vue";
import { useCookies } from "vue3-cookies";
import jsPDF from "jspdf";
import html2canvas from "html2canvas";
import { useRouter } from "vue-router";

export default {
    props: {
        userData: "",
    },
    components: { Forbidden },
    setup() {
        const products = ref([]);
        const datas = ref({
            no_transaksi: "",
            tanggal_transaksi: "",
            total_harga: "",
            transaction_id: "",
            barang_id: "",
            qty: "",
            total_harga: "",
        });

        const form = ref({
            kode_barang: "",
            nama_barang: "",
            harga: "",
            qty: "",
            sub_total: "",
            bayar: "",
            kembalian: "",
            total: 0,
        });
        const time = ref("");
        const selectedProduct = ref(null);
        const dataCart = ref([]);
        const amount = ref("");
        const { notify } = useNotification();
        const showPrintButton = ref(false);

        const getDataToPost = () => {
            const transaction_details = dataCart.value.map((item) => {
                return {
                    barang_id: item.barang_id,
                    qty: item.qty,
                    total_harga: item.sub_total,
                };
            });

            // console.log(transaction_details);

            const formattedDate = datas.value.tanggal_transaksi
                .split("-")
                .reverse()
                .join("-");

            if (dataCart.value.length === 0 || form.value.bayar === "") {
                validation();
            } else {
                axios
                    .post("/api/transaction", {
                        tanggal_transaksi: formattedDate,
                        total_harga: form.value.total,
                        details: transaction_details,
                    })
                    .then((response) => {
                        console.log(response);
                        const transactionNumber =
                            response.data.transaction.no_transaksi;

                        datas.value.no_transaksi = transactionNumber;

                        notify({
                            type: "success",
                            text: response.data.message,
                            speed: 500,
                        });
                        // resetForm();
                    })
                    .catch((error) => {
                        console.error(error);
                    });
                showPrintButton.value = true;
            }

            console.log(dataCart.value);
        };

        const getBarangs = () => {
            axios.get("/api/barang").then((response) => {
                products.value = response.data.data;
                selectedProduct.value = "";
            });
        };

        const handleChange = () => {
            const product = products.value.find(
                (product) => product.id === selectedProduct.value
            );
            if (product) {
                form.value.kode_barang = product.kode_barang;
                form.value.nama_barang = product.nama_barang;
                form.value.harga = product.harga_barang;
                form.value.qty = 1;
                form.value.sub_total = product.harga_barang * 1;
                console.log(product);
            } else {
                form.value.kode_barang = "";
                form.value.nama_barang = "";
                form.value.harga = "";
                form.value.qty = "";
                form.value.sub_total = "";
            }
        };

        const updateSubTotal = () => {
            form.value.sub_total = form.value.harga * form.value.qty;
            if (form.value.qty < 0) {
                form.value.qty = 0;
                form.value.sub_total = 0;
            }
        };

        const inputBayar = () => {
            form.value.bayar = amount.value;
            if (form.value.bayar < form.value.total) {
                form.value.bayar = "";
                form.value.kembalian = "";
                notify({
                    type: "error",
                    text: "Jumlah uang yang dibayarkan kurang",
                    speed: 500,
                });
            } else {
                form.value.kembalian = form.value.bayar - form.value.total;
                notify({
                    type: "success",
                    text: "Berhasil membayar",
                    speed: 500,
                });
                amount.value = "";
            }
        };

        const inputToCart = () => {
            form.value.total += form.value.sub_total;

            const barangId = products.value.find(
                (product) => product.id === selectedProduct.value
            );

            dataCart.value.push({
                barang_id: barangId.id,
                kode_barang: form.value.kode_barang,
                nama_barang: form.value.nama_barang,
                harga: form.value.harga,
                qty: form.value.qty,
                sub_total: form.value.sub_total,
            });

            selectedProduct.value = "";
            form.value.nama_barang = "";
            form.value.harga = "";
            form.value.qty = "";
            form.value.sub_total = "";
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
                return "Rp. " + 0;
            }
        };

        const getNow = () => {
            const today = new Date();
            const date =
                today.getDate() +
                "-" +
                (today.getMonth() + 1) +
                "-" +
                today.getFullYear();

            datas.value.tanggal_transaksi = date;
        };

        const getTime = () => {
            const today = new Date();
            const waktu = today.getHours() + ":" + today.getMinutes();
            time.value = waktu;
        };

        const resetForm = () => {
            dataCart.value = [];
            form.value = {
                kode_barang: "",
                nama_barang: "",
                harga: "",
                qty: "",
                sub_total: "",
                bayar: "",
                kembalian: "",
                total: 0,
            };
            datas.value = {
                no_transaksi: "",
            };
        };

        const validation = () => {
            if (dataCart.value.length === 0) {
                notify({
                    type: "error",
                    text: "Tidak ada barang yang dipilih",
                    speed: 500,
                });
            } else if (form.value.bayar === "") {
                notify({
                    type: "error",
                    text: "Masukkan jumlah uang yang dibayarkan",
                    speed: 500,
                });
            } else if (form.value.bayar < form.value.total) {
                notify({
                    type: "error",
                    text: "Jumlah uang yang dibayarkan kurang",
                    speed: 500,
                });
            } else {
                getDataToPost();
            }
        };

        const { cookies } = useCookies();
        const role = ref([]);

        const is = (roles) => {
            // console.log(role.value);
            if (role.value === roles) {
                return true;
            } else {
                return false;
            }
        };

        const download = () => {
            const elementsToHide = document.querySelectorAll(".export-hidden");
            elementsToHide.forEach((element) => {
                element.style.display = "none";
            });

            const content = document.getElementById("print-content");
            const pdf = new jsPDF({
                orientation: "p",
                unit: "mm",
                format: "a4",
            });

            html2canvas(content).then((canvas) => {
                const imgData = canvas.toDataURL("image/png");

                pdf.addImage(imgData, "PNG", 10, 10, 190, 0); // Adjust the width as needed

                pdf.save("transaction_receipt.pdf");
            });
        };

        const router = useRouter();
        const newTransaction = () => {
            router.go();
        };

        onMounted(() => {
            getBarangs();
            getNow();
            getTime();
            role.value = cookies.get("roles");
        });

        return {
            products,
            datas,
            newTransaction,
            form,
            time,
            selectedProduct,
            dataCart,
            amount,
            handleChange,
            updateSubTotal,
            inputToCart,
            inputBayar,
            formatRupiah,
            getDataToPost,
            validation,
            is,
            showPrintButton,
            download,
        };
    },
};
</script>

<style scoped>
.new-transaction {
    display: flex;
    justify-content: flex-end;
}
.content {
    margin-top: 20px;
}

.content .title {
    text-align: center;
    font-weight: 600;
    letter-spacing: 1.5px;
}

.content .card {
    position: relative;
    padding: 20px;
    border-radius: 4px;
    box-shadow: 0 0 4px rgba(0, 0, 0, 0.2);
    border: none;
    margin: 1rem 0;
}

.content .card .form-group {
    display: flex;
    margin-bottom: 1rem;
    gap: 2rem;
}

.content .card .form-group label {
    width: 30%;
    font-size: 16px;
    font-weight: 500;
}

.content .card .form-group input {
    width: 70%;
    padding: 0.5rem;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 16px;
}

.content .card .form-group select {
    width: 70%;
    padding: 0.5rem;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 16px;
}

.content .card .form-group button {
    width: 70%;
    padding: 0.5rem;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 16px;
}

.content .card .form-group button:hover {
    background-color: rgb(0, 144, 144);
    color: white;
}

.content .card .form-group .input-group {
    width: 70%;
    border: none;
    border-radius: 4px;
    font-size: 16px;
    display: flex;
    flex: nowrap;
}

.content .card .form-group .input-group input {
    width: 80%;
}

.content .card .form-group .input-group button {
    width: 20%;
    border: none;
    border-radius: 4px;
    font-size: 16px;
    background-color: rgb(0, 144, 144);
    color: white;
}

.cart {
    margin-bottom: 1rem;
}

.actions {
    display: flex;
    justify-content: flex-end;
    gap: 1rem;
}

.nota {
    border: none;
    font-size: 16px;
    font-weight: 500;
    text-align: right;
}
</style>
