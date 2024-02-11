<template>
  <div>
    <md-table v-model="contractdetails" table-header-color="black" table-header-bkcolor="grey" 
    table-header-fontweight="semi-bold" table-header-gridlines="true" table-cell-gridlines="true">
      <md-table-row slot="md-table-row" slot-scope="{ item }" class="iram-row">
        <md-table-cell md-label="Code">{{ item.code }}</md-table-cell>
        <md-table-cell md-label="Description">{{ item.description }}</md-table-cell>
        <md-table-cell md-label="Unit">{{ item.unit }}</md-table-cell>
        <md-table-cell md-label="Quantity">{{ item.quantity }}</md-table-cell>
        <md-table-cell md-label="Unit Cost">{{ item.unitcost }}</md-table-cell>
        <md-table-cell md-label="Value">{{ item.value }}</md-table-cell>
      </md-table-row>
    </md-table>
  </div>
</template>

<script>
export default {
  name: "contract-details",
  props: {
    tableHeaderColor: {
      type: String,
      default: "",
    },
  },
  data() {
    return {
      selected: [],
      contractdetails: [
        {
          code: "38904",
          description: "Repair of asphalt",
          unit: "m2",
          quantity: 3,
          unitcost: "3,440",
          value: "10,320",
        },
        {
          code: "4323",
          description: "Pothole fill",
          unit: "m2",
          quantity: 3,
          unitcost: "7,000",
          value: "21,000",
        },
        {
          code: "42543",
          description: "Rutting repair",
          unit: "m2",
          quantity: 4,
          unitcost: "2,500",
          value: "10,000",
        },
        {
          code: "5344",
          description: "Sub-base repair",
          unit: "m2",
          quantity: 5,
          unitcost: "1,000",
          value: "5,000",
        },
      ],
    };
  },
};
</script>
<style>
.iram-row {
  font-weight: 400 !important;
}
</style>