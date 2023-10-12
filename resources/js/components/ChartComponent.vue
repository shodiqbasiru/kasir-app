<template>
    <div>
        <canvas id="myChart"></canvas>
    </div>
</template>

<script>
import Chart from "chart.js/auto";
import { reactive, ref, onMounted } from "vue";

export default {
    setup() {
        const transactions = ref([]);
        const labels = ["1 - 7", "8 - 14", "15 - 21", "22 - 28", "29 - 31"];
        const data = {
            labels: labels,
            datasets: [
                {
                    label: "My First Dataset",
                    data: [65, 59, 80, 81, 56, 55, 40],
                    backgroundColor: [
                        "rgba(255, 99, 132, 0.2)",
                        "rgba(255, 159, 64, 0.2)",
                        "rgba(255, 205, 86, 0.2)",
                        "rgba(75, 192, 192, 0.2)",
                        "rgba(54, 162, 235, 0.2)",
                        "rgba(153, 102, 255, 0.2)",
                        "rgba(201, 203, 207, 0.2)",
                    ],
                    borderColor: [
                        "rgb(255, 99, 132)",
                        "rgb(255, 159, 64)",
                        "rgb(255, 205, 86)",
                        "rgb(75, 192, 192)",
                        "rgb(54, 162, 235)",
                        "rgb(153, 102, 255)",
                        "rgb(201, 203, 207)",
                    ],
                    borderWidth: 1,
                },
            ],
        };
        const config = {
            type: "bar",
            data: data,
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                    },
                },
            },
        };

        const getTransactions = () => {
            axios.get("/api/transaction").then((response) => {
                transactions.value = response.data.data;
                console.log(transactions.value.tanggal_transaksi);
            });
        };

        onMounted(() => {
            getTransactions();
            new Chart(document.getElementById("myChart"), config);
        });

        return {
            getTransactions,
        };
    },
};
</script>
