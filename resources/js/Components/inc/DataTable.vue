<template>
    <table class="table table-bordered text-center">
      <thead>
        <tr>
          <th v-for="column in columns" :key="column">{{ column }}</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="row in data" :key="getRowKey(row)">
          <td v-for="(value, key) in row" :key="key">{{ value }}</td>
        </tr>
      </tbody>
    </table>
  </template>
  
  <script>
  export default {
    props: {
      columns: {
        type: Array,
        required: true,
      },
      data: {
        type: Array,
        required: true,
      },
    },
    methods: {
      getRowKey(row) {
        // Generate a unique key for each row
        return JSON.stringify(row);
      },
    },
  };
  </script>
<!-- <template>
    <div>
        <table class="table table-bordered text-center">
            <thead>
                <tr>
                    <th v-for="col,index in cols" :key="index" scope="col">{{ col }}</th>
                </tr>
            </thead>
            <tbody>
                
            </tbody>
        </table>
    </div>

</template>
<script setup>

defineProps({

    cols ,
    data 
})

</script> -->
