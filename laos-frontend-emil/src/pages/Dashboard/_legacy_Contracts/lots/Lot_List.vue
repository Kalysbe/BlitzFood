<template>
  <div>
    <md-card class="md-card-frame">
      <md-card-header class="md-card-header-blue header-elements">
        <h4 class="title" style="color:white; text-transform: uppercase;">{{ $t('lots.list') }}</h4>
        <md-button style="float: right; font-family: phetsarath_ot;" class="md-raised md-blue header-buttons"
          @click.native="addLot()">
          {{ $t('lots.add_new_lot') }}
        </md-button>
      </md-card-header>

      <md-card-content>
        <md-table v-model="lots_list" table-header-color="black" table-header-bkcolor="grey"
          table-header-fontweight="semi-bold" table-header-gridlines="true" table-cell-gridlines="true"
          table-margin-right="true" table-header-font="normal" style="width:100%;">
          <md-table-row slot="md-table-row" slot-scope="{ item }" class="iram-row">
            <md-table-cell :md-label="$t('lots.contract_id')" style="width:112px;text-align:center;">
              {{ item.id_contract }}</md-table-cell>
            <md-table-cell :md-label="$t('lots.lot_no')" style="width:112px;text-align:center;">
              {{ item.lot_no }}</md-table-cell>
            <md-table-cell :md-label="$t('lots.lot_name')" style="width:312px;">{{ item.lot_name }}</md-table-cell>
            <md-table-cell :md-label="$t('lots.province')" style="width:122px;">{{ item.id_province }}</md-table-cell>
            <md-table-cell :md-label="$t('lots.district')" style="width:122px;">{{ item.id_district }}</md-table-cell>
            <md-table-cell :md-label="$t('lots.road_number')" style="width:116px;text-align:center;">
              {{ roadText(item.road_number) }}</md-table-cell>
            <md-table-cell :md-label="$t('lots.road_length')" style="width:96px;" md-numeric>
              {{ item.road_length_m | formatNumber }}</md-table-cell>
            <md-table-cell :md-label="$t('lots.start_m')" style="width:96px;" md-numeric>
              {{ startText(item.start_m) | formatNumber }}</md-table-cell>
            <md-table-cell :md-label="$t('lots.end_m')" style="width:96px;" md-numeric>
              {{ endText(item.end_m) | formatNumber }}</md-table-cell>
            <md-table-cell :md-label="$t('lots.contract_value')" style="width:156px;" md-numeric>
              {{ item.contract_value | currency('LAK', 0, {
    symbolOnLeft: true, spaceBetweenAmountAndSymbol:
      true
  })
}}
            </md-table-cell>

            <!-- actions -->
            <md-table-cell :md-label="$t('contracts_list.actions')">
              <md-button class="md-just-icon md-info md-wd" @click.native="handleDetail(item)">
                <md-tooltip md-direction="top">{{ $t('tooltips.view_detail') }}</md-tooltip>
                <md-icon>view_list</md-icon>
              </md-button>
              <md-button class="md-just-icon md-success md-wd" @click.native="handleEdit(item)">
                <md-tooltip md-direction="top">{{ $t('tooltips.edit') }}</md-tooltip>
                <md-icon>dvr</md-icon>
              </md-button>
              <md-button class="md-just-icon md-warning md-wd" @click.native="handleDelete(item)">
                <md-tooltip md-direction="top">{{ $t('tooltips.delete') }}</md-tooltip>
                <md-icon>close</md-icon>
              </md-button>
            </md-table-cell>
          </md-table-row>
        </md-table>
      </md-card-content>
    </md-card>
    <NewLot :showForm="showform" :edit_data="edit_data" :editedIndex="editedIndex"></NewLot>
  </div>
</template>

<script>
import { mapActions } from 'vuex';
import Swal from "sweetalert2";
import NewLot from './NewLot'
export default {
  name: "lots-list",
  components: { NewLot },
  props: {
    tableHeaderColor: {
      type: String,
      default: "",
    },
    domain: { type: String },
    contract_data: {}
  },
  data() {
    return {
      selected: [],
      lots_list: [],
      lots_list_rows: [],

      Roads: [],
      Provinces: [],
      ContractTypess: [],
      WorkTypes: [],
      FundingTypes: [],
      FundingSources: [],
      Contractors: [],
      item: [],
      editedIndex: 0,
      edit_data: {},
      showform: false,
      lot_contract: {},
    }
  },
  computed: {

  },
  methods: {
    ...mapActions('Contract', [
      'showLotForm'
    ]),

    roadText(item) {
      return item.toString()
    },
    startText(item) {
      return item.toString()
    },
    endText(item) {
      return item.toString()
    },
    addLot() {
      console.log("ADD LOT")
      this.editedIndex = -1
      this.showLotForm(true)
      this.showform = true;
    },
    async handleDetail(item) {
      console.log("Lot item:", item)
      await this.$store.dispatch('Lots/setLotData', item)
      console.log("LOT-DATA", await this.$store.state.Lots.LOT_DATA)

      this.$router.push({ name: 'lotdetails', params: item })
    },
    async handleEdit(item) {
      console.log("lot-item:", item)
      this.editedIndex = 0
      this.edit_data = item
      this.showLotForm(true)
    },
    handleDelete(item) {
      Swal.fire({
        title: "Are you sure?",
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
            title: "Deleted!",
            text: `You deleted ${item.name}`,
            type: "success",
            confirmButtonClass: "md-button md-success btn-fill",
            buttonsStyling: false
          });
        }
      });
    },
    deleteRow(item) {
      let indexToDelete = this.lots_list.findIndex(
        tableRow => tableRow.id === item.id
      );
      if (indexToDelete >= 0) {
        this.lots_list.splice(indexToDelete, 1);
      }
    },
    convertArrayObject() {
      let rows = this.lots_list_rows.rows
      let headers = this.lots_list_rows.headers
      let lots_list = rows.map(a => {
        let obj = {};
        a.forEach((v, i) => {
          obj[headers[i]] = v;
        });
        return obj;
      });

      console.log("Lots_list-RES:", lots_list);
      this.lots_list = lots_list
    }
  },
  async created() {

  },
  async mounted() {
    console.log("CONTRACT_DATA-CONTRAC-DETAIL:", this.$store.state.Contract.CONTRACT_DATA)
    this.lots_list_rows = await this.$store.dispatch('Lots/LOAD_LOTS_LIST', this.$store.state.Contract.CONTRACT_DATA.id, this.domain)
    console.log("LOTS-LIST_ROWS:", this.lots_list_rows)
    this.convertArrayObject()
  }
};
</script>

<style lang="scss">
.md-card-frame {
  margin-top: 20px;
}

.header-elements {
  padding-bottom: 14px !important;
  display: flex;
  justify-content: space-between;
  margin-bottom: 14px;
}

.header-buttons {
  height: 38px;
  margin-right: 2.3px !important;
}

.iram-row {
  font-weight: 400 !important;
}

.md-card {
  border: 0;
  margin-left: 20px;
  margin-right: 20px;
}

.card-content {
  width: 1300px !important;
}

.md-table-cell {
  padding-top: 4px;
  padding-bottom: 4px;
}

.md-wd {
  margin-left: 3px;
}

// .md-table-cell-container {
//     padding: 10px !important;
// }
</style>