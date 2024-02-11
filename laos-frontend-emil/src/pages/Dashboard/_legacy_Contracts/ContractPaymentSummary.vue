<template>
  <div>
    <md-table v-model="payment_summary_list" table-header-color="black" table-header-bkcolor="grey" 
    table-header-fontweight="semi-bold" table-header-gridlines="true" table-cell-gridlines="true">
      <md-table-row slot="md-table-row" slot-scope="{ item }" class="iram-row">
        <md-table-cell :md-label="$t('contract_payment_summary.payment_no')">{{ item.payment_no }}</md-table-cell>
        <md-table-cell :md-label="$t('contract_payment_summary.lot_no')">{{ item.lot_no }}</md-table-cell>
        <md-table-cell :md-label="$t('contract_payment_summary.previous_amount')">{{ item.previous_amount }}</md-table-cell>
        <md-table-cell :md-label="$t('contract_payment_summary.actual_amount')">{{ item.actual_amount }}</md-table-cell>
        <md-table-cell :md-label="$t('contract_payment_summary.accumulated_amount')">{{ item.accumulated_amount }}</md-table-cell>
        <md-table-cell :md-label="$t('contract_payment_summary.payment_progress')">{{ item.payment_progress }}</md-table-cell>
        <md-table-cell :md-label="$t('contract_payment_summary.payment_date')">{{ item.payment_date }}</md-table-cell>
      </md-table-row>
    </md-table>
  </div>
</template>

<script>
export default {
  name: "contract-payment-summary",
  props: {
    tableHeaderColor: {
      type: String,
      default: "",
    },
  },
  data() {
    return {
      selected: [],
      payment_summary_list: [
        {
          id: 1,
          payment_no: 1,
          lot_no: "1",
          previous_amount: 500000000,
          actual_amount: 1000000000,
          accumulated_amount: 1500000000,
          payment_progress: "20%",
          payment_date: "31-10-2021"
        },
        {
          id: 2,
          payment_no: 2,
          lot_no: "1",
          previous_amount: 1500000000,
          actual_amount: 3000000000,
          accumulated_amount: 4500000000,
          payment_progress: "60%",
          payment_date: "01-01-2022"
        },
        {
          id: 3,
          payment_no: 3,
          lot_no: "2",
          previous_amount: 100000000,
          actual_amount: 2000000000,
          accumulated_amount: 2100000000,
          payment_progress: "10%",
          payment_date: "31-12-2021"
        },
        
        {
          id: 4,
          payment_no: 4,
          lot_no: "3",
          previous_amount: 0,
          actual_amount: 700000000,
          accumulated_amount: 700000000,
          payment_progress: "5%",
          payment_date: "01-09-2022"
        }
      ],
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