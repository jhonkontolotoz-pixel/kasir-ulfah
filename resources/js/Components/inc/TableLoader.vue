<template>
   <div class="w-full z-40">
    <table class="min-w-full">
      <thead>
        <tr>
          <th v-for="col in props.cols" :key="'th-'+col"></th>
        </tr>
      </thead>

      <tbody>
        <tr v-for="row in props.rows" :key="'row-'+row">
          <td style="padding: 5px;" v-for="col in props.cols" :key="'td-'+col">
            <div class="flex items-center" :style="{ height: '3rem', 'flex-grow': '1', overflow: 'hidden' }">
                <Skeleton width="60%" height="1rem" />
            </div>
          </td>
        </tr>
      </tbody>
    </table>
   </div>
</template>

<script setup>
// Tips: gunakan props.rows karena kamu sudah mendefinisikannya di defineProps
const props = defineProps({
  cols: { type: Number, default: 5 },
  rows: { type: Number, default: 10 }, // Nilai default ditingkatkan agar skeleton terlihat
})
</script>