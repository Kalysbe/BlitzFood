<template>
  <div class="md-layout md-size-100">
    <div class="md-layout-item md-size-100">
      <md-card>
          <md-card-header class="md-card-header-icon md-card-header-green">
              <div class="card-icon">
                  <md-icon>assignment</md-icon>
              </div>
              <h4 class="title">{{ $t('lots.list') }}</h4>
              <md-button style="float: right; font-family: phetsarath_ot;" class="md-success md-wd" @click.native="addLot()">
                  <md-tooltip md-direction="top">{{ $t('add') }}</md-tooltip>
                  {{ $t('lots.add_new_lot')}}
              </md-button>
          </md-card-header>
          <md-card-content>
              <md-table v-model="lots_list" table-header-color="black" table-header-bkcolor="grey"
                  table-header-fontweight="semi-bold" table-header-gridlines="true" table-cell-gridlines="true" 
                  table-margin-right="true" style="width: 1250px;"
              >
                  <md-table-row slot="md-table-row" slot-scope="{ item }" class="iram-row">
                      <md-table-cell :md-label="$t('lots.contract_id')">{{ item.id_contract }}</md-table-cell>
                      <md-table-cell :md-label="$t('lots.lot_no')">{{ item.lot_no }}</md-table-cell>
                      <md-table-cell :md-label="$t('lots.lot_name')">{{ item.lot_name }}</md-table-cell>
                      <md-table-cell :md-label="$t('lots.province')">{{ setTextProvince(item.id_province) }}</md-table-cell>
                      <md-table-cell :md-label="$t('lots.district')">{{ setTextDistrict(item.id_district) }}</md-table-cell>
                      <md-table-cell :md-label="$t('lots.road_number')">{{ roadText(item.road_number) }}</md-table-cell>
                      <md-table-cell :md-label="$t('lots.road_length')">{{ item.road_length_m | formatNumber }}</md-table-cell>
                      <md-table-cell :md-label="$t('lots.start_m')">{{ startText(item.start_m) | formatNumber }}</md-table-cell>
                      <md-table-cell :md-label="$t('lots.end_m')">{{ endText(item.end_m) | formatNumber }}</md-table-cell>
                      <md-table-cell :md-label="$t('lots.contract_value')">{{ item.contract_value | currency('LAK', 0, { symbolOnLeft: false, spaceBetweenAmountAndSymbol: true })}}</md-table-cell>
                      
                      <!-- actions -->
                      <md-table-cell :md-label="$t('contracts_list.actions')">
                          <md-button
                              style="margin-right: 4px;"
                              class="md-just-icon md-info md-wd"
                              @click.native="handleDetail(item)"
                          >
                              <md-tooltip md-direction="top">{{ $t('tooltips.view_detail') }}</md-tooltip>
                              <md-icon>view_list</md-icon>
                          </md-button>
                          <md-button
                              class="md-just-icon md-success md-wd"
                              @click.native="handleEdit(item)"
                          >
                              <md-tooltip md-direction="top">{{ $t('tooltips.edit') }}</md-tooltip>
                              <md-icon>dvr</md-icon>
                          </md-button>
                          <md-button
                              style="margin-left: 4px;"
                              class="md-just-icon md-warning md-wd"
                              @click.native="handleDelete(item)"
                          >
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
    domain: {type: String},
    contract_data: {}
  },
  data() {
    return {
      selected: [],
      lots_list: [],
      lots_list_rows: [],
      province_list_rows: [],
      district_list_rows: [],
      district_list_all: [],
      district_list: [],
      Roads: [],

      province_list: [],
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
    // contract_data_lot() {
    //   this.contract_data
    // },
  },
  methods: {
    ...mapActions('Contract',[
      'showLotForm'
    ]),
    convertArrayOfObjectProvince(){
      let rows = this.province_list_rows.rows
      let headers = this.province_list_rows.headers
      let prov_list = rows.map(a => {
          let obj = {};
          a.forEach((v,i) => {
            obj[headers[i]] = v;
          });
          return obj;
      });
      console.log("prov_list-RESULT:", prov_list);
      this.province_list = prov_list
    },
    convertArrayOfObjectDistrict(){
      let rows = this.district_list_all.rows
      let headers = this.district_list_all.headers
      let dist_list = rows.map(a => {
          let obj = {};
          a.forEach((v,i) => {
            obj[headers[i]] = v;
          });
          return obj;
      });
      console.log("Dist_list-RESULT:", dist_list);
      this.district_list = dist_list
    },
    setTextProvince(pid){
      console.log("tex-province:", this.province_list_rows.rows)
      const province = this.province_list.find(p => (p.id == pid))
      console.log("province:", province)
      return province ? province.name : null
    },
    setTextDistrict(did){
      const district = this.district_list.find(d => (d.district_number == did))
      console.log("district:", district)
      return district ? district.name : null
    },
    roadText(item){
      return item.toString()
    },
    startText(item){
      return item.toString()
    },
    endText(item){
      return item.toString()
    },
    addLot(){
      console.log("ADD LOT")
      this.editedIndex = -1
      // this.formTitle = "New Contract"
      this.showLotForm(true)
      this.showform = true;
    },
    async handleDetail(item){
        console.log("Lot item:",item)
        await this.$store.dispatch('Lots/setLotData', item)
        console.log("LOT-DATA", await this.$store.state.Lots.LOT_DATA)

        this.$router.push({name:'lotdetails',params: item})
    },
    async handleEdit(item){
       console.log("lot-item:", item)
      this.editedIndex = 0
      
      // this.formTitle = "Edit Contract"
      this.edit_data = item
      // this.$router.push({name:'lotdetails',params: item})
      
      this.showLotForm(true)
      // Swal.fire({
      //   title: `You want to edit ${item.name}`,
      //   buttonsStyling: false,
      //   confirmButtonClass: "md-button md-info"
      // });
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
    convertArrayObject(){
      let rows = this.lots_list_rows.rows
      let headers = this.lots_list_rows.headers
      let lots_list = rows.map(a => {
          let obj = {};
          a.forEach((v,i) => {
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
    // this.id_contract = 1
    // console.log("DATA-STORE:", await this.$store.state.Lots.lots_list)
    // this.lot_contract = await this.contract_data
    // console.log("CONTRACT-ID-LOT-1:", await this.contract_data)
    // console.log("CONTRACT-ID-LOT-2:", await this.contract_data.id)
    console.log("CONTRACT_DATA-CONTRAC-DETAIL:", this.$store.state.Contract.CONTRACT_DATA)
    this.lots_list_rows = await this.$store.dispatch('Lots/LOAD_LOTS_LIST', this.$store.state.Contract.CONTRACT_DATA.id, this.domain)
    // this.lots_list = this.$store.state.Lots.lots_list
    console.log("LOTS-LIST_ROWS:", this.lots_list_rows)
    this.convertArrayObject()

    this.province_list_rows = await this.$store.dispatch('Lots/LOAD_PROVINCE_LIST', this.domain)
    console.log("province_list_rows:", this.province_list_rows)
    this.convertArrayOfObjectProvince()
    
    this.Roads = await this.$store.dispatch('Lots/LOAD_ROADS_LIST', 0, this.domain)
    //list of provinces if privice_id : 0 => national webGis, 99: morethan one provinces covered
    console.log("Roads:", this.Roads)

    // to do later
    this.district_list_rows = await this.$store.dispatch('Lots/LOAD_DISTRICTS_LIST', 1, this.domain)
    console.log("district_list_rows:", this.district_list_rows)

    this.district_list_all = await this.$store.dispatch('Lots/LOAD_DISTRICTS_LIST_ALL', this.domain)
    console.log("district_list_all:", this.district_list_all)
    this.convertArrayOfObjectDistrict()
  }
};
</script>
<style lang="scss">
.iram-row {
  font-weight: 400 !important;
}
#btn-payment {
  margin-left:77%;
}
    
.table-transparent {
  background-color: transparent !important;
}

.mt-0 {
  margin-top: 0 !important;
}
.md-card .md-card-actions{
  border: 0;
  margin-left: 20px;
  margin-right: 20px;
}
// .md-card-lot {
//     background-color: rgba(214, 218, 218, 0.599) !important;
// }
.my-popup{
  position:absolute;
  top: 48px;
  left: 104px;
  width:1200px !important;
  height:600px !important;
  background-color:gray;
      z-index: 999;
    overflow: auto;
}
// .md-table-cell-width {
//   width: 50px !important;
// }
.card-content {
  // width: auto!important;
  width: 1300px!important;
}
// .md-table-cell-container {
//     padding: 10px !important;
// }
</style>