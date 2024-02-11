<template>
  <div style="text-align:right;">
    <md-button class="md-raised md-blue" id="btn-payments" @click="addDailyWork()">Add Payment (IPC)</md-button>
    <md-table v-model="lotpaymentdetails" id="tbl-payments" table-header-color="black" table-header-bkcolor="grey" 
    table-header-fontweight="semi-bold" table-header-gridlines="true" table-cell-gridlines="true">
      <md-table-row slot="md-table-row" slot-scope="{ item }" class="iram-row" md-selectable="single">
        <md-table-cell md-label="ID" style="width:10px;">{{ item.id }}</md-table-cell>
        <md-table-cell md-label="Description">{{ item.description }}</md-table-cell>
        <md-table-cell md-label="Sum" style="width:100px;" md-numeric>{{ item.amnt }}</md-table-cell>        <!--<md-table-cell md-label="Paid" style="width:10px;">{{ item.paid }}</md-table-cell>-->
        <md-table-cell md-label="Paid" style="width:10px;">
          <md-checkbox v-model=item.paid disabled md-checkbox-readonly="true"></md-checkbox>
        </md-table-cell> 
        <md-table-cell md-label="Date Paid" style="width:96px;text-align:center;">{{ item.datepaid }}</md-table-cell>
        <md-table-cell md-label="DL" style="width:102px;">{{ item.dl }}</md-table-cell>
        <md-table-cell md-label="Actions" class="md-cell-action" style="width:90px;padding:2px 0px;text-align:center;">
          <md-button 
            class="md-just-icon md-info md-wd"
              @click.native="handleDetail(item)"
            >
            <md-tooltip md-direction="top">View Lot Payment Details</md-tooltip>
            <md-icon>view_list</md-icon>
          </md-button>
          <md-button 
            class="md-just-icon md-success md-wd"
              @click.native="handleEdit(item)"
            >
            <md-tooltip md-direction="top">Edit Lot Payment</md-tooltip>
            <md-icon>dvr</md-icon>
          </md-button>
          <md-button 
          class="md-just-icon md-warning md-wd"
              @click.native="handleDelete(item)"
            >
            <md-tooltip md-direction="top">Delete Lot Payment</md-tooltip>
            <md-icon>close</md-icon>
          </md-button>
        </md-table-cell>
      </md-table-row>
    </md-table>
    <NewLotPayment :showForm="showform" :edit_data="edit_data" :editedIndex="editedIndex"></NewLotPayment>
  </div>
</template>

<script>
/* === For Future Reference ===
import $ from 'jquery'

$(document).ready(function(){
  $(".md-checkbox").on('mousedown', function (event) {
      alert(this);
  });
});*/
import Swal from "sweetalert2";
import { mapActions } from 'vuex';
import NewLotPayment from './NewLotPayment'

const LotPaymentFromServer = [
    {
      id: "324",
      description: "IPC No.1",
      amnt: 10393,
      paid: true,
      datepaid: "2022-01-25",
      dl: "2022-01-25",
    },
    {
      id: "4322",
      description: "IPC No.2",
      amnt: 21409,
      paid: false,
      datepaid: "-",
      dl: "2022-02-04",
    },
    {
      id: "423",
      description: "IPC No.3",
      amnt: 2111,
      paid: false,
      datepaid: "-",
      dl: "2022-02-06",
    },
  ];

LotPaymentFromServer.map(formatFieldNumber);

function formatFieldNumber(el) {
  Object.keys(el).forEach(function(key, id) {
    if (id==2) {
      el[key] = Number(el[key]).toLocaleString();
    }
  });
}

export default {
  name: "lot-payments",
  components: { NewLotPayment },
  props: {
    tableHeaderColor: {
      type: String,
      default: "",
    },
  },
  data() {
    return {
      selected: [],
      lotpaymentdetails: LotPaymentFromServer,
      editedIndex: 0,
      edit_data: {},
      showform: false,
    };
  },
  methods: {
    ...mapActions('Contract',[
      'showLotPaymentForm'
    ]),
    addDailyWork(){
      console.log("Add Lot Payment")
      this.editedIndex = -1
      this.showLotPaymentForm(true)
      this.showform = true;
    },
    handleDetail(item){
      console.log("Lot Payment Item:",item)
      this.editedIndex = 1
      this.edit_data = item
      this.showLotPaymentForm(true)
      this.showform = true;
    },
    handleEdit(item){
      this.editedIndex = 0
      this.edit_data = item
      this.showLotPaymentForm(true)
      this.showform = true;
    },
    handleDelete(item) {
      Swal.fire({
        title: "Are You Sure?",
        text: `You won't be able to revert this!`,
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: "md-button md-success btn-fill",
        cancelButtonClass: "md-button md-danger btn-fill",
        confirmButtonText: "Yes, delete it!",
        buttonsStyling: false
      }).then(result => {
        if (result.value) {
          this.deleteRow(item);
          Swal.fire({
            title: "Deleted",
            text: `You deleted ${item.name}`,
            type: "success",
            confirmButtonClass: "md-button md-success btn-fill",
            buttonsStyling: false
          });
        }
      });
    },
    deleteRow(item) {
      let indexToDelete = this.lotpaymentdetails.findIndex(
        tableRow => tableRow.id === item.id
      );
      if (indexToDelete >= 0) {
        this.lotpaymentdetails.splice(indexToDelete, 1);
      }
    },
  }
};
</script>
<style>
.iram-row {
  font-weight: 400 !important;
}

#btn-payments{
  vertical-align:middle;
  margin-top:-24px;
  margin-right:0px;
}
#tbl-payments{
  height: 180px;
  text-align: left;
  vertical-align:middle;
}

.md-checkbox {
  display: flex;
  margin: 0px;
}
.md-checkbox .md-checkbox-label {
  width: 0px;
}
</style>