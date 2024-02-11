<template>
  <div>
    <md-table v-model="paymentdetails" table-header-color="black" table-header-bkcolor="grey" 
    table-header-fontweight="semi-bold" table-header-gridlines="true" table-cell-gridlines="true" 
    table-margin-right="true">
      <md-table-row slot="md-table-row" slot-scope="{ item }" class="iram-row">
        <md-table-cell md-label="ID">{{ item.id }}</md-table-cell>
        <md-table-cell md-label="Sum">{{ item.sum }}</md-table-cell>
        <md-table-cell md-label="Paid">{{ item.paid }}</md-table-cell>
        <md-table-cell md-label="Date Paid">{{ item.datepaid }}</md-table-cell>
        <md-table-cell md-label="DL">{{ item.dl }}</md-table-cell>
      </md-table-row>
    </md-table>
    <!-- <md-button class="md-raised md-success" id="btn-payment">Add Payment</md-button> -->
  </div>
</template>

<script>
export default {
  name: "payment-details",
  props: {
    tableHeaderColor: {
      type: String,
      default: "",
    },
  },
  data() {
    return {
      selected: [],
      paymentdetails: [
        {
          id: "324",
          sum: "10,393",
          paid: "Yes",
          datepaid: "25.01.2022",
          dl: "25.01.2022",
        },
        {
          id: "4322",
          sum: "21,409",
          paid: "No",
          datepaid: "-",
          dl: "04.02.2022",
        },
        {
          id: "423",
          sum: "2,111",
          paid: "No",
          datepaid: "-",
          dl: "06.02.2022",
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
#btn-payment {
  margin-left:77%;
}
</style>