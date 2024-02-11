<template>
  <div class="md-layout">
    <div class="md-layout-item md-size-100">
      <md-card>
        <md-card-header class="md-card-header-icon md-card-header-green">
            <div class="card-icon">
                <md-icon>assignment</md-icon>
            </div>
            <h4 class="title">Contract List</h4>
            <!-- --------------filter on contract------------------------------ -->
            
            <md-button
                style="float: right;"
                class="md-success md-wd"
                @click.native="showContractForm()"
                >
                Add New Contract
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
                <md-input
                  type="search"
                  class="mb-3"
                  clearable
                  style="width: 200px"
                  placeholder="Search records"
                  v-model="searchQuery"
                >
                </md-input>
              </md-field>
            </md-table-toolbar>
            <!-- new way contract headers -->
            <md-table-row slot="md-table-row" slot-scope="{item}">
                <md-table-cell
                  v-for="(cell_header) of contract_headers"
                  :key="cell_header"
                  :md-label="$t(`translate.${cell_header}`)"
                  :md-sort-by="cell_header"
                >
                {{item[`${cell_header}`]}}
                  <!-- {{ item[index] }} -->
                </md-table-cell>
              </md-table-row>
              <!-- amkha -->
            <!-- <md-table-row slot="md-table-row" slot-scope="{ item }">
              <md-table-cell md-label="Contract Number">{{ item.contract_number }}</md-table-cell>
              <md-table-cell md-label="Road">{{ roadText(item.road_number) }}</md-table-cell>
              <md-table-cell md-label="Province"></md-table-cell>
              <md-table-cell md-label="Chainage"></md-table-cell>
              <md-table-cell md-label="lenght">{{ item.total_road_length_m | formatNumber}}</md-table-cell>
              <md-table-cell md-label="Work type"></md-table-cell>
              <md-table-cell md-label="Initial Cost(A)">{{ item.initial_cost | currency('LAK', 0, { symbolOnLeft: false, spaceBetweenAmountAndSymbol: true })}}</md-table-cell>
              <md-table-cell md-label="Revise Cost(B)">{{ item.revised_cost | currency('LAK', 0, { symbolOnLeft: false, spaceBetweenAmountAndSymbol: true })}}</md-table-cell>
              <md-table-cell md-label="Current Cost">{{item.initial_cost + item.revised_cost | currency('LAK', 0, { symbolOnLeft: false, spaceBetweenAmountAndSymbol: true })}}</md-table-cell>
              <md-table-cell md-label="Paymnet">{{ (item.payments/(item.initial_cost + item.revised_cost)) | formatPercent}}</md-table-cell>
              <md-table-cell md-label="Progress">{{ item.progress_percentage/100 | formatPercent}}</md-table-cell>
              <md-table-cell md-label="Status">{{ item.status }}</md-table-cell>
                <md-table-cell md-label="Actions">
                  <md-button
                    class="md-just-icon md-success md-wd"
                    @click.native="handleDetail(item)"
                  >
                    <md-icon>view_list</md-icon>
                  </md-button>
                  <md-button
                    class="md-just-icon md-warning md-simple"
                    @click.native="handleEdit(item)"
                  >
                    <md-icon>dvr</md-icon>
                  </md-button>
                  <md-button
                    class="md-just-icon md-danger md-simple"
                    @click.native="handleDelete(item)"
                  >
                    <md-icon>close</md-icon>
                  </md-button>
                </md-table-cell>
            </md-table-row>  -->
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
      <ContractForm/>
    </div>
  <!-- </div> -->
   <!-- popu form  -->
  <!-- <div> -->
  <md-dialog :md-active.sync="IsPopup" class="my-popup" id="myPopUp">
  <div class="md-dialog-content">
    <!-- <div class="my-popup" id="myPopUp"> -->
      <div class="md-layout-item md-size-360">
        <md-card>
          <md-card-header class="md-card-header-icon md-card-header-green">
            <div class="card-icon">
              <md-icon>assignment</md-icon>
            </div>
            <h4 class="title">New Contract</h4>
          </md-card-header>
          <md-card-content>
              <!-- first row -->
            <div class="md-layout">
              <div class="md-layout-item md-size-30">
                <md-field>
                  <label>Contract ID</label>
                  <md-input v-model="layout1" type="text"></md-input>
                </md-field>
              </div>
              <div class="md-layout-item md-size-30">
                <md-field>
                  <label for="Road">Road</label>
                  <md-select v-model="layout2" name="layout2">
                    <md-option
                      v-for="item in Roads"
                      :key="item"
                      :label="item"
                      :value="item"
                    >
                      {{ item }}
                    </md-option>
                  </md-select>
                </md-field>
              </div>
              <div class="md-layout-item md-size-30">
                <md-field>
                  <label for="Province">Province</label>
                  <md-select v-model="layout3" name="layout3">
                    <md-option
                      v-for="item in Provinces"
                      :key="item"
                      :label="item"
                      :value="item"
                    >
                      {{ item }}
                    </md-option>
                  </md-select>
                </md-field>
              </div>
              <div class="md-layout-item md-size-30">
                <md-field>
                  <label>Chainage</label>
                  <md-input v-model="layout3" type="text"></md-input>
                </md-field>
              </div>
              <div class="md-layout-item md-size-30">
                <md-field>
                  <label>Length(m)</label>
                  <md-input v-model="layout3" type="text"></md-input>
                </md-field>
              </div>
              <div class="md-layout-item md-size-30">
                <md-field>
                  <label for="ContractTypes">Conytract Type</label>
                  <md-select v-model="layout4" name="layout4">
                    <md-option
                      v-for="item in ContractTypes"
                      :key="item"
                      :label="item"
                      :value="item"
                    >
                      {{ item }}
                    </md-option>
                  </md-select>
                </md-field>
              </div>
            </div>
            <!-- second row -->
            <div class="md-layout">
              <div class="md-layout-item md-size-30">
                <md-field>
                  <label for="WorkType">Work Type</label>
                  <md-select v-model="layout5" name="layout5">
                    <md-option
                      v-for="item in WorkTypes"
                      :key="item"
                      :label="item"
                      :value="item"
                    >
                      {{ item }}
                    </md-option>
                  </md-select>
                </md-field>
              </div>
              <div class="md-layout-item md-size-30">
                <md-field>
                  <label>Contract Start</label>
                  <md-input v-model="layout2" type="text"></md-input>
                </md-field>
              </div>
              <div class="md-layout-item md-size-30">
                <md-field>
                  <label>Contract End</label>
                  <md-input v-model="layout3" type="text"></md-input>
                </md-field>
              </div>
              <div class="md-layout-item md-size-30">
                <md-field>
                  <label for="FundingType">Funding Type</label>
                  <md-select v-model="layout6" name="layout6">
                    <md-option
                      v-for="item in FundingTypes"
                      :key="item"
                      :label="item"
                      :value="item"
                    >
                      {{ item }}
                    </md-option>
                  </md-select>
                </md-field>
              </div>
              <div class="md-layout-item md-size-30">
                <md-field>
                  <label for="FundingSource">Funding Source</label>
                  <md-select v-model="layout6" name="layout6">
                    <md-option
                      v-for="item in FundingSources"
                      :key="item"
                      :label="item"
                      :value="item"
                    >
                      {{ item }}
                    </md-option>
                  </md-select>
                </md-field>
              </div>
              <div class="md-layout-item md-size-30">
                <md-field>
                  <label for="Contractor">Contractor ID</label>
                  <md-select v-model="layout7" name="layout7">
                    <md-option
                      v-for="item in Contractors"
                      :key="item"
                      :label="item"
                      :value="item"
                    >
                      {{ item }}
                    </md-option>
                  </md-select>
                </md-field>
              </div>
            </div>
            <div>
                <md-button
                  style="float: right; margin-left: 10px;"
                  class="md-success md-wd"
                  @click="saveContract()"
                  >
                  Save Contract
                </md-button>
                <md-button
                  style="float: right;"
                  class="md-warning md-wd"
                  @click="canCel()"
                  >
                  Cancel
                </md-button>
            </div>
          </md-card-content>
        </md-card>
      </div>
    </div>
  <!-- </div> -->
  </md-dialog>
  <!-- </div> -->
  </div>
</template>
<script>
import ContractForm from './ContractForm';
import setimmediate from 'setimmediate';
import { Pagination } from "@/components";
import Fuse from "fuse.js";
import Swal from "sweetalert2";
export default {
  name: 'contracts',
  props: {domain: {type: String}},
  components: {
    Pagination,
    ContractForm
  },
  data() {
    return {
      selected: [],
      regtabledata: [],
      contract_list: [],
      contract_list_flat: [],

      currentSort: "name",
      currentSortOrder: "asc",
      pagination: {
        perPage: 5,
        currentPage: 1,
        perPageOptions: [5, 10, 25, 50],
        total: 0
      },
      footerTable: ["Name", "Email", "Age", "Salary", "Actions"],
      searchQuery: "",
      propsToSearch: ["name", "email", "age"],
      searchedData: [],
      fuseSearch: null,
      //---testing only--------------
      IsPopup: false,
      layout1: null,
      layout2: null,
      layout3: null,
      layout4: null,
      layout5: null,
      layout6: null,
      layout7: null,
      layout8: null,
      layout9: null,
      Roads: [],
      Provinces: [],
      ContractTypes: [],
      WorkTypes: [],
      FundingTypes: [],
      FundingSources: [],
      Contractors: [],
      item: [],
    };
  },
  computed: {
    //----------amkha-----------------------------------
    contract_headers() {
      // this.regtabledata.headers
      return [...this.regtabledata.headers]
    },
    contract_rows() {
      return [...this.regtabledata.rows]
    },
    tableData() {
      return this.contract_rows
    },

    //========================================================
    /***
     * Returns a page from the searched data or the whole data. Search is performed in the watch section below
     */
    // queriedData() {
    //   let result = this.tableData;
    //   if (this.searchedData.length > 0) {
    //     result = this.searchedData;
    //   }
    //   return result.slice(this.from, this.to);
    // },
    queriedData() {
      const result = !this.searchQuery
        ? this.contract_list
        : this.searchedData
        ? this.searchedData
        : []
      return result.slice(this.from, this.to)
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
 
  created() {
  },
  async mounted(){
    this.regtabledata = await this.$store.dispatch('LOAD_CONTRACT_LIST', this.domain)
    console.log("REG-DATA:", this.regtabledata)

    // Convert an array of arrays to an array of objects with mapped properties
    // https://stackoverflow.com/questions/58209695/convert-an-array-of-arrays-to-an-array-of-objects-with-mapped-properties
    //----cool thing heree---------------
    await this.mapTableData()
    //---------------------------------------------------

    this.fuseSearch = new Fuse(this.contract_list, {
      keys: ["contract_number", "road_number"],
      threshold: 0.3
    });
  },
  watch: {
    /**
     * Searches through the table data by a given query.
     * NOTE: If you have a lot of data, it's recommended to do the search on the Server Side and only display the results here.
     * @param value of the query
     */
    searchQuery(value) {
      console.log("VALUE:",value)
      let result = this.contract_list;
      if (value !== "") {
        result = this.fuseSearch.search(this.searchQuery);
      }
      console.log("RESULT::",result)
      this.searchedData = result;
    },
    // searchQuery(value) {
    //   let result = this.tableData
    //   const regex = new RegExp(`${value}`, 'i')
    //   if (value !== '') {
    //     result = this.tableData.filter((row) => {
    //       return row.reduce((incl, elem) => incl || regex.test(elem), false)
    //     }) //this.fuseSearch.search(this.searchQuery)
    //   }
    //   this.searchedData = result
    // },
  },
  methods: {
    showContractForm(){
      console.log("OK:", this.IsPopup );
      this.IsPopup = true;
      console.log("AFTER:", this.IsPopup );
    },
    roadText(item){
      console.log("ROAD_NO:", item)
      return item.toString()
    },
    getClass: ({ id }) => ({
      "table-success": id === 1,
      "table-info": id === 3,
      "table-danger": id === 5,
      "table-warning": id === 7
    }),
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

      console.log("Cancel", this.IsPopup)
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
    handleLike(item) {
      Swal.fire({
        title: `You liked ${item.name}`,
        buttonsStyling: false,
        type: "success",
        confirmButtonClass: "md-button md-success"
      });
    },
    handleDetail(item){
      Swal.fire({
        title: `You want to View Detail ${item.name}`,
        buttonsStyling: false,
        confirmButtonClass: "md-button md-info"
      });
    },
    handleEdit(item) {
      Swal.fire({
        title: `You want to edit ${item.name}`,
        buttonsStyling: false,
        confirmButtonClass: "md-button md-info"
      });
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
  }
}
</script> 
<style lang="scss" scoped>
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
// .md-dialog .md-dialog-content {
//     width: 1000px!important;
//   }
.card-content {
  width: 1200px!important;
}
/* md-dialog{
  width:1000px !important;
  height:500px !important; 
} */
</style>
