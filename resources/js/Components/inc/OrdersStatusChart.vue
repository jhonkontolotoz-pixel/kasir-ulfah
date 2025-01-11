
<template>
    <div class="card flex justify-center">
        <Chart type="doughnut" :data="chartData" :options="chartOptions" class="w-full md:w-[30rem]" />
    </div>
</template>

<script setup>
import { ref, onMounted } from "vue";

onMounted(async () => {
    chartData.value =await setChartData();
    chartOptions.value = setChartOptions();
});

const chartData = ref();
const chartOptions = ref(null);
const labels = ref([])
const data = ref([])

const setChartData = async () => {
    const documentStyle = getComputedStyle(document.body);
    
    await axios.get(`/api/ordersStatusChart`)
        .then(res => {
           labels.value = res.data.data.labels
           data.value = res.data.data.datasets
        }).catch(err => {
            console.log(err)
        })

    return {
        labels: labels.value,
        datasets: [
            {
                data: data.value,
                backgroundColor: [documentStyle.getPropertyValue('--p-cyan-500'), documentStyle.getPropertyValue('--p-orange-500'), documentStyle.getPropertyValue('--p-gray-500')],
                hoverBackgroundColor: [documentStyle.getPropertyValue('--p-cyan-400'), documentStyle.getPropertyValue('--p-orange-400'), documentStyle.getPropertyValue('--p-gray-400')]
            }
        ]
    };
};

const setChartOptions = () => {
    const documentStyle = getComputedStyle(document.documentElement);
    const textColor = documentStyle.getPropertyValue('--p-text-color');

    return {
        plugins: {
            legend: {
                labels: {
                    cutout: '60%',
                    color: textColor
                }
            }
        }
    };
};
</script>
