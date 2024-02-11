<template>
  <div style="text-align:right;">
    <md-button class="md-raised md-blue" id="btn-daily-works" @click="addDailyWork()">Add Daily Work</md-button>
    <md-table v-model="dailyworks" id="tbl-daily-works" table-header-color="black" table-header-bkcolor="grey" 
    table-header-fontweight="semi-bold" table-header-gridlines="true" table-cell-gridlines="true">
      <md-table-row slot="md-table-row" slot-scope="{ item }" class="iram-row" md-selectable="single" style="text-align: left;">
        <md-table-cell md-label="Lot No." style="width:10px;text-align:center;">{{ item.lotno }}</md-table-cell>
        <md-table-cell md-label="BoQ/MAC" style="width:10px;">{{ item.boq_mac }}</md-table-cell>
        <md-table-cell md-label="Work Description">{{ item.description }}</md-table-cell>
        <md-table-cell md-label="Road No." style="width:10px;text-align:center;">{{ item.roadno }}</md-table-cell>
        <md-table-cell md-label="Link No." style="width:10px;text-align:center;">{{ item.linkno }}</md-table-cell>
        <md-table-cell md-label="Start Mil.">{{ item.start_m }}</md-table-cell>
        <md-table-cell md-label="End Mil.">{{ item.end_m }}</md-table-cell>
        <md-table-cell md-label="Quantity" style="width:10px;" md-numeric>{{ item.quantity }}</md-table-cell>
        <md-table-cell md-label="Date" style="width:100px;text-align:center;">{{ item.date }}</md-table-cell>
        <md-table-cell md-label="Actions" class="md-cell-action" style="width:90px;padding:2px 0px;text-align:center;">
          <md-button 
            class="md-just-icon md-info md-wd"
              @click.native="handleDetail(item)"
            >
            <md-tooltip md-direction="top">View Daily Work Details</md-tooltip>
            <md-icon>view_list</md-icon>
          </md-button>
          <md-button 
            class="md-just-icon md-success md-wd"
              @click.native="handleEdit(item)"
            >
            <md-tooltip md-direction="top">Edit Daily Work</md-tooltip>
            <md-icon>dvr</md-icon>
          </md-button>
          <md-button 
          class="md-just-icon md-warning md-wd"
              @click.native="handleDelete(item)"
            >
            <md-tooltip md-direction="top">Delete Daily Work</md-tooltip>
            <md-icon>close</md-icon>
          </md-button>
        </md-table-cell>
      </md-table-row>
    </md-table>
    <NewDailyWork :showForm="showform" :edit_data="edit_data" :editedIndex="editedIndex"></NewDailyWork>
  </div>
</template>

<script>
import Swal from "sweetalert2";
import { mapActions } from 'vuex';
import NewDailyWork from './NewDailyWork'

const DailyWorksFromServer = [
        {
          lotno: 1,
          boq_mac: "38",
          description: "Repair of asphalt",
          roadno: "15",
          linkno: "103",
          start_m: "Km235+00",
          end_m: "Km235+15",
          quantity: 3,
          date: '2022-02-04',
        },
        {
          lotno: 2,
          boq_mac: "43",
          description: "Pothole fill",
          roadno: "67",
          linkno: "98",
          start_m: "Km453+00",
          end_m: "Km453+09",
          quantity: 3,
          date: '2022-02-16',
        },
        {
          lotno: 3,
          boq_mac: "143",
          description: "Rutting repair",
          roadno: "83",
          linkno: "111",
          start_m: "Km512+00",
          end_m: "Km512+12",
          quantity: 4,
          date: '2022-02-14',
        },
        {
          lotno: 4,
          boq_mac: "44",
          description: "Sub-base repair",
          roadno: "59",
          linkno: "126",
          start_m: "Km388+00",
          end_m: "Km388+20",
          quantity: 5,
          date: '2022-02-10',
        },
      ];

DailyWorksFromServer.map(formatFieldNumber);

function formatFieldNumber(el) {
  Object.keys(el).forEach(function(key, id) {
    if (id==7) {
      el[key] = Number(el[key]).toLocaleString();
    }
  });
}

export default {
  name: "lot-daily-works",
  components: { NewDailyWork },
  props: {
    tableHeaderColor: {
      type: String,
      default: "",
    },
  },
  data() {
    return {
      selected: [],
      dailyworks: DailyWorksFromServer,
      editedIndex: 0,
      edit_data: {},
      showform: false
    };
  },
  methods: {
    ...mapActions('Contract',[
      'showDailyWorkForm'
    ]),
    addDailyWork(){
      console.log("Add Lot Daily Work")
      this.editedIndex = -1
      this.showDailyWorkForm(true)
      this.showform = true;
    },
    handleDetail(item){
      console.log("Daily Work Item:",item)
      this.editedIndex = 1
      this.edit_data = item
      this.showDailyWorkForm(true)
      this.showform = true;
    },
    handleEdit(item){
      this.editedIndex = 0
      this.edit_data = item
      this.showDailyWorkForm(true)
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
      let indexToDelete = this.dailyworks.findIndex(
        tableRow => tableRow.id === item.id
      );
      if (indexToDelete >= 0) {
        this.dailyworks.splice(indexToDelete, 1);
      }
    },
  }
};
</script>
<style>
.iram-row {
  font-weight: 400 !important;
}
#btn-daily-works{
  vertical-align:middle;
  margin-top:-24px;
  margin-right:0px;
}
#tbl-daily-works{
  height: 180px;
  text-align: left;
  vertical-align:middle;
}
</style>