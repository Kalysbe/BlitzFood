<template>
  <div class="md-layout">
    <div class="md-layout-item md-size-100">
      <md-card>
        <md-card-header class="md-card-header-icon md-card-header-green">
            <div class="card-icon">
                <md-icon>assignment</md-icon>
            </div>
            <h4 class="title">{{ $t('contracts_list.list') }}</h4>
            <!-- --------------filter on contract------------------------------ -->
            <!-- <NewContract style="float: right;"></NewContract> -->
            <md-button
                style="float: right; font-family: phetsarath_ot;"
                class="md-success md-wd"
                @click.native="addContract()"
                >
                <md-tooltip md-direction="top">{{ $t('add') }}</md-tooltip>
                {{ $t('contracts_list.add_new_contract')}}
            </md-button>

        </md-card-header>
        <md-card-content>
          <md-table 
            :value="queriedData"
            :md-sort.sync="currentSort"
            :md-sort-order.sync="currentSortOrder"
            :md-sort-fn="customSort"
            class="paginated-table table-striped table-hover"
            table-header-color="green"
          >
          <!-- v-model="contract_list" -->
            <md-table-toolbar>
              <md-field>
                <label for="pages">Per page</label>
                <md-select v-model="pagination.perPage" name="pages">
                  <md-option
                    v-for="item in pagination.perPageOptions"
                    :key="item"
                    :label="item"
                    :value="item"
                  >
                    {{ item }}
                  </md-option>
                </md-select>
              </md-field>

              <md-field>
                <!-- <label for="search">{{ $t('search_record') }}</label> -->
                <md-input
                  type="search"
                  class="mb-3"
                  clearable
                  style="width: 200px"
                  placeholder="Search for a contract"
                  v-model="searchQuery"
                >
                </md-input>
              </md-field>
            </md-table-toolbar> 
            <md-table-row slot="md-table-row" slot-scope="{ item }">
              
              <md-table-cell :md-label="$t('contracts_list.contract_number')" style="font-family: phetsarath_ot;">{{ item.contract_number }}</md-table-cell>
              <md-table-cell :md-label="$t('contracts_list.contract_title')">{{ item.contract_title}}</md-table-cell>
              <md-table-cell :md-label="$t('contracts_list.project_name')">{{ item.project_name}}</md-table-cell>
              <md-table-cell :md-label="$t('contracts_list.contract_type')">{{ item.contract_type }}</md-table-cell>
              <md-table-cell :md-label="$t('contracts_list.contractor_name')">{{ item.contractor }}</md-table-cell>
              <md-table-cell :md-label="$t('contracts_list.employer')">{{ item.id_employer }}</md-table-cell>
              <md-table-cell :md-label="$t('contracts_list.contract_duration')">{{ item.contract_duration }}</md-table-cell>
              <md-table-cell :md-label="$t('contracts_list.total_lenght')">{{ item.total_road_length_m | formatNumber}}</md-table-cell>

              <!-- <md-table-cell :md-label="$t('contracts_list.work_type')"></md-table-cell> -->
              <!-- <md-table-cell :md-label="$t('contracts_list.initial_cost(A)')">{{ item.initial_cost | currency('LAK', 0, { symbolOnLeft: false, spaceBetweenAmountAndSymbol: true })}}</md-table-cell> -->
              <!-- <md-table-cell :md-label="$t('contracts_list.revise_cost(B)')">{{ item.revised_cost | currency('LAK', 0, { symbolOnLeft: false, spaceBetweenAmountAndSymbol: true })}}</md-table-cell> -->
              <!-- <md-table-cell :md-label="$t('contracts_list.current_cost')">{{item.initial_cost + item.revised_cost | currency('LAK', 0, { symbolOnLeft: false, spaceBetweenAmountAndSymbol: true })}}</md-table-cell> -->
              <!-- <md-table-cell :md-label="$t('contracts_list.payment')">{{ (item.payments/(item.initial_cost + item.revised_cost)) | formatPercent}}</md-table-cell> -->
              <!-- <md-table-cell :md-label="$t('contracts_list.progress')">{{ item.progress_percentage/100 | formatPercent}}</md-table-cell> -->
              <!-- <md-table-cell :md-label="$t('contracts_list.status')" style="width:100px;padding:2px 0px;text-align:center;">{{ item.status }}</md-table-cell> -->
            <!-- actions: edit delete -->
                <md-table-cell :md-label="$t('contracts_list.actions')">
                  <md-button
                    style="margin-right: 2px;"
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
                    style="margin-left: 2px;"
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
        <md-card-actions md-alignment="space-between">
          <div class="">
            <p class="card-category">
              Showing {{ from + 1 }} to {{ to }} of {{ total }} entries
            </p>
          </div>
          <pagination
            class="pagination-no-border pagination-success"
            v-model="pagination.currentPage"
            :per-page="pagination.perPage"
            :total="total"
          >
          </pagination>
        </md-card-actions>
      </md-card>
      <NewContract :showForm="showform" :edit_data="edit_data" :editedIndex="editedIndex"></NewContract>
    </div>
  </div>
</template>
<script>
import NewContract from './NewContract'
// import ContractForm from './ContractForm';
// import setimmediate from 'setimmediate';
import { Pagination } from "@/components";
import Fuse from "fuse.js";
import Swal from "sweetalert2";
import { mapActions } from 'vuex';
export default {
  name: 'contracts',
  props: {domain: {type: String}},
  components: {
    Pagination,
    // ContractForm,
    NewContract
  },
  data() {
    return {
      selected: [],
      regtabledata: [],
      contract_list: [],
      contract_list_flat: [],
      contract_number: "Contract Number",
      road_number: "Road Number",

      currentSort: "name",
      currentSortOrder: "asc",
      pagination: {
        perPage: 5,
        currentPage: 1,
        perPageOptions: [5, 10, 25, 50],
        total: 0
      },
      footerTable: [],
      searchQuery: "",
      propsToSearch: ["name", "email", "age"],
      searchedData: [],
      fuseSearch: null,
      IsPopup: false,
      
      Roads: [],
      Provinces: [],
      ContractTypes: [],
      WorkTypes: [],
      FundingTypes: [],
      FundingSources: [],
      Contractors: [],
      item: [],
      editedIndex: 0,
      edit_data: {},
      showform: false,

      employers: [
        {
          key: 1, 
          value: 'MPWT'
        },
        {
          key: 2, 
          value: 'DPWT'
        },
        {
          key: 3, 
          value: 'Other'
        },
      ],
    };
  },
  computed: {
    //----------amkha--------------
    // tooltipView(){
    //   return tooltipView
    // },
    contract_headers() {
      // this.regtabledata.headers
      return [...this.regtabledata.headers]
    },
    /***
     * Returns a page from the searched data or the whole data. Search is performed in the watch section below
     */
    queriedData() {
      let result = this.contract_list;
      if (this.searchedData.length > 0) {
        result = this.searchedData;
      }
      return result.slice(this.from, this.to);
    },
    to() {
      let highBound = this.from + this.pagination.perPage;
      if (this.total < highBound) {
        highBound = this.total;
      }
      return highBound;
    },
    from() {
      return this.pagination.perPage * (this.pagination.currentPage - 1);
    },
    total() {
      return this.searchedData.length > 0
        ? this.searchedData.length
        : this.contract_list.length;
    }
  },
 
  async mounted(){

    await this.loadAllList()

    this.regtabledata = await this.$store.dispatch('LOAD_CONTRACT_LIST', this.domain)
    // console.log("REG-DATA:", this.regtabledata)

    // Convert an array of arrays to an array of objects with mapped properties
    // https://stackoverflow.com/questions/58209695/convert-an-array-of-arrays-to-an-array-of-objects-with-mapped-properties
    //----cool thing heree---------------
    await this.mapTableData()
    //---------------------------------------------------

    this.fuseSearch = new Fuse(this.contract_list, {
      keys: ["contract_number", "road_number"],
      threshold: 0.3
    });
    console.log("MESS-LIST:", this.$i18n.messages.la.contracts_list.contract_number)


  },
  watch: {
    /**
     * Searches through the table data by a given query.
     * NOTE: If you have a lot of data, it's recommended to do the search on the Server Side and only display the results here.
     * @param value of the query
     */
    searchQuery(value) {
      // console.log("VALUE:",value)
      let result = this.contract_list;
      if (value !== "") {
        result = this.fuseSearch.search(this.searchQuery);
      }
      // console.log("RESULT::",result)
      this.searchedData = result;
    }
  },
  methods: {
    ...mapActions(['showContracForm']),
    mapTableData(){
      let rows = this.regtabledata.rows
      let headers = this.regtabledata.headers
      let contract_list = rows.map(a => {
          let obj = {};
          a.forEach((v,i) => {
            obj[headers[i]] = v;
          });
          return obj;
      });
      console.log("contract_list-RESULT:", contract_list);
      this.contract_list = contract_list
    },
    _addContract(){
      this.editedIndex = -1
      // this.formTitle = "New Contract"
      this.showform = true;
      this.showContracForm(true)
    },
    handleEdit(item) {
      //  console.log("item:", item)
      this.editedIndex = 0
      // this.formTitle = "Edit Contract"
      this.edit_data = item
      this.showContracForm(true)
      // Swal.fire({
      //   title: `You want to edit ${item.name}`,
      //   buttonsStyling: false,
      //   confirmButtonClass: "md-button md-info"
      // });
    },
    roadText(item){
      // console.log("ROAD_NO:", item)
      return (item != null ? item.toString() : '')
    },
    contractTypeText(id){
      const type = this.ContractTypes.find(c => c.key == id)
      return type.value
    },
    contractorText(cid){
      const type = this.Contractors.find(c => c.key == cid)
      return type ? type.value : null
    },
    employerText(id){
      const type = this.employers.find(c => c.key == id)
      return type.value
    },
    async loadAllList(){
      const contrac_types_list = await this.$store.dispatch('LOAD_CONTRACT_REPORTS_LIST')
      // console.log("data_list:", contrac_types_list)
      this.ContractTypes = [...contrac_types_list]
      console.log("ContractTypes:", this.ContractTypes)
      // const asset_types_list = await this.$store.dispatch('LOAD_ASSET_TYPES')
      // console.log("asset_types_list:", asset_types_list)
      // this.AssetTypes = [...asset_types_list]
      // console.log("ASSET_Types:", this.AssetTypes)
      const contractors_list = await this.$store.dispatch('LOAD_CONTRACTORS')
      this.Contractors = [...contractors_list]
      console.log("this.Contractors:", this.Contractors)
      // const worktypes_list = await this.$store.dispatch('LOAD_WORK_TYPES')
      // this.WorkTypes = [...worktypes_list]
      const fundingtypes_list = await this.$store.dispatch('LOAD_FUNDING_TYPES')
      this.FundingTypes = [...fundingtypes_list]
      console.log("this.FundingTypes:", this.FundingTypes)
      const fundingsources_list = await this.$store.dispatch('LOAD_FUNDING_SOURCES')
      this.FundingSources = [...fundingsources_list]
    },
    // getClass: ({ id }) => ({
    //   "table-success": id === 1,
    //   "table-info": id === 3,
    //   "table-danger": id === 5,
    //   "table-warning": id === 7
    // }),
    /////////////pagination data///////////////////
    customSort(value) {
      return value.sort((a, b) => {
        const sortBy = this.currentSort;
        if (this.currentSortOrder === "desc") {
          return a[sortBy].localeCompare(b[sortBy]);
        }
        return b[sortBy].localeCompare(a[sortBy]);
      });
    },
    canCel(){
      
      this.IsPopup = false;
      Swal.fire({
        title: `The Contract is Canceled`,
        buttonsStyling: false,
        type: "warning",
        confirmButtonClass: "md-button md-warning"
      });

      // console.log("Cancel", this.IsPopup)
    },
    saveContract(){
      this.IsPopup = false;
      Swal.fire({
        title: `Thec Contract is saved`,
        buttonsStyling: false,
        type: "success",
        confirmButtonClass: "md-button md-success"
      });
    },
    
    async handleDetail(item){
      // console.log("View:", item)
      await this.$store.dispatch('setContractData', item)
      console.log("CONTRACT_ID:", await this.$store.state.Contract.CONTRACT_DATA)
      this.$router.push({name:'contractprofile',params: item})
      // Swal.fire({
      //   title: `You want to View Detail ${item.name}`,
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
      let indexToDelete = this.contract_list.findIndex(
        tableRow => tableRow.id === item.id
      );
      if (indexToDelete >= 0) {
        this.contract_list.splice(indexToDelete, 1);
      }
    },
    
  }
}
</script> 
<style lang="scss" scoped>
.id_width {
  width: 30px !important;
  height: 100px !important;
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
.body {
  font-family: "phetsarath_ot"!important;
}
.md-table-head-label {
  font-family: "phetsarath_ot"!important;
}
.table_head_label {
  font-family: "phetsarath_ot"!important;
  color: #4caf50 !important;
}
.card-content {
  font-family: "phetsarath_ot", "Helvetica", "Arial", sans-serif !important;
  width: 1200px!important;
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
