<template>
    <div class="card flex justify-between gap-3">
                <div>
                    <SelectButton v-model="filters.type" :options="salesChartFilterOptions" />
                </div>
                <div class="flex justify-between gap-3">
                    <DatePicker v-model="filters.date_from" showIcon fluid iconDisplay="input" inputId="icondisplay" placeholder="From"/>
                    <DatePicker v-model="filters.date_to" showIcon fluid iconDisplay="input" inputId="icondisplay" placeholder="To"/>
                    
                </div>

            </div>
            <Chart type="bar" :data="chartData" :options="chartOptions" class="h-[20rem]" />
</template>

<script setup>
import { onMounted, ref , reactive} from 'vue';
import { useRoute,useRouter } from 'vue-router';

import { watchEffect } from 'vue';
onMounted(() => {
    chartOptions.value = setChartOptions();
});

const route = useRoute()
const router = useRouter()
const chartData = ref()
const loadingSalesChart = ref(false)
const salesChartFilterOptions = ref(['daily', 'weekly', 'monthly', 'yearly'])

const filters = reactive({
    type :  'yearly',
    date_from :  '' ,
    date_to : ''
})

const chartOptions = ref(null);
const labels = ref([])
const data = ref([])

const setChartData = async () => {
    const documentStyle = getComputedStyle(document.documentElement);

    loadingSalesChart.value = true

    const params = new URLSearchParams({
        type : filters.type,
        date_from : filters.date_from ? (new Date(filters.date_from)).toISOString() : '' ,
        date_to : filters.date_to ? (new Date(filters.date_to)).toISOString() : ''
    }).toString();

    /* router.replace({
         query : 
         {
         type : filters.type ,
         date_from : filters.date_from ? (new Date(filters.date_from)).toISOString() : '' ,
         date_to : filters.date_to ? (new Date(filters.date_to)).toISOString() : ''  
        } })
         */
    await axios.get(`/api/salesChart?${params}`)
        .then(res => {
            labels.value = res.data.data.labels
            data.value = res.data.data.datasets
        }).catch(err => {
            console.log(err)
        }).finally(() => {
            loadingSalesChart.value = false
        })

    return {
        labels: labels.value,
        datasets: [
            {
                label : 'Orders',
                backgroundColor: documentStyle.getPropertyValue('--p-cyan-500'),
                borderColor: documentStyle.getPropertyValue('--p-cyan-500'),
                data: data.value
            }
        ]
    };
};
const setChartOptions = () => {
    const documentStyle = getComputedStyle(document.documentElement);
    const textColor = documentStyle.getPropertyValue('--p-text-color');
    const textColorSecondary = documentStyle.getPropertyValue('--p-text-muted-color');
    const surfaceBorder = documentStyle.getPropertyValue('--p-content-border-color');

    return {
        maintainAspectRatio: false,
        aspectRatio: 0.8,
        plugins: {
            legend: {
                labels: {
                    color: textColor
                }
            }
        },
        scales: {
            x: {
                ticks: {
                    color: textColorSecondary,
                    font: {
                        weight: 500
                    }
                },
                grid: {
                    display: false,
                    drawBorder: false
                }
            },
            y: {
                ticks: {
                    color: textColorSecondary
                },
                grid: {
                    color: surfaceBorder,
                    drawBorder: false
                }
            }
        }
    };
}



watchEffect(async () => {
     
    if(filters.date_from && filters.date_to)
    {
        chartData.value = await setChartData()
    }

    if(filters.type && (!filters.date_from || !filters.date_to))
    {
        
        chartData.value = await setChartData()
    } 
})

</script>
