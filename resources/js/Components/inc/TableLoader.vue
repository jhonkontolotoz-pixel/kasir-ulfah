<template>
  <!-- <button type="button" class="inline-flex items-center px-4 py-2 font-semibold leading-6 text-sm shadow rounded-md text-white bg-black hover:bg-indigo-400 transition ease-in-out duration-150 cursor-not-allowed" disabled="">
    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
      <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
      <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
    </svg>
    Loading...
  </button>
   -->

   <div  class="w-full z-40">
    <table class="min-w-full">
      <tr>
        <th v-for="col in props.cols" :key="col"></th>
      </tr>
      <tr v-for="row in props.rows" :key="row">
        <td style="padding: 5px;" v-for="col in props.cols" :key="col">
          <div class="flex items-center" :style="{ height: '3rem', 'flex-grow': '1', overflow: 'hidden' }">
                <Skeleton width="60%" height="1rem" />
            </div>
        </td>
      </tr>
    </table>
   </div>
</template>

<script setup>
import {ref} from 'vue'
const props = defineProps({
  cols: { type :Number , default : 5 },
  rows: { type :Number , default : 1 },
})
const rows = ref(10)
</script>