<template>
  <div class="overflow-x-auto min-w-full">
    <table class="min-w-full divide-y divide-gray-200">
      <thead>
        <tr>
          <th
            v-for="col in cols"
            :key="col"
            class="px-4 py-2 bg-gray-100 text-left text-sm font-medium text-gray-500"
          >
            &nbsp;
          </th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-200 animate-pulse">
        <tr v-for="row in rows" :key="row">
          <td
            v-for="col in cols"
            :key="col"
            class="px-4 py-4 whitespace-nowrap"
          >
            <div class="h-4 bg-gray-300 rounded"></div>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
export default {
  name: "TableSkeleton",
  props: {
    cols: {
      type: Number,
      required: true,
    },
    rows: {
      type: Number,
      default: 10, // Default to 5 rows if not provided
    },
  },
};
</script>