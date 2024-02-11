<template>
  <div>
    <!-- <h4>Summary 2</h4> -->
    <md-table v-model="contractsummary" table-header-color="black" table-header-bkcolor="grey" 
    table-header-fontweight="semi-bold" table-header-gridlines="true" table-cell-gridlines="true">
      <md-table-row slot="md-table-row" slot-scope="{ item }" class="iram-row">
        <md-table-cell md-label="Contract value">{{ item.contract_id }}</md-table-cell>
        <md-table-cell md-label="Contract value">{{ item.contractvalue }}</md-table-cell>
        <md-table-cell md-label="Local financing">{{ item.localfinancing }}</md-table-cell>
        <md-table-cell md-label="Advance payment">{{ item.advancepayment }}</md-table-cell>
        <md-table-cell md-label="Retention (%)">{{ item.retention }}</md-table-cell>
        <md-table-cell md-label="Currency">{{ item.currency }}</md-table-cell>
        <md-table-cell md-label="Bank details">{{ item.bankdetails }}</md-table-cell>
        <md-table-cell md-label="Value revised">{{ item.valuerevised }}</md-table-cell>
        <md-table-cell md-label="Acceptance date">{{ item.acceptancedate }}</md-table-cell>
        <md-table-cell md-label="Start date">{{ item.startdate }}</md-table-cell>
        <md-table-cell md-label="End date">{{ item.enddate }}</md-table-cell>
      </md-table-row>
    </md-table>
  </div>
</template>

<script>
export default {
  name: "contract-summary2",
  props: {
    tableHeaderColor: {
      type: String,
      default: "",
    },
  },
  data() {
    return {
      selected: [],
      contractsummary: [
        {
          contractvalue: "1.1M",
          localfinancing: "No",
          advancepayment: "200,000",
          retention: "3",
          currency: "USD",
          bankdetails: "-",
          valuerevised: "-",
          acceptancedate: "12.03.2022",
          startdate: "14.04.2022",
          enddate: "03.06.2022",
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