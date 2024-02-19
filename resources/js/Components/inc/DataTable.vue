<template>
    <div>
        <table class="table table-bordered text-center">
            <thead>
                <tr>
                    <th v-for="col,index in cols" :key="index" scope="col">{{ col }}</th>
                </tr>
            </thead>
        </table>
    </div>

</template>
<script setup>

defineProps({

    cols ,
    data 
})

</script>