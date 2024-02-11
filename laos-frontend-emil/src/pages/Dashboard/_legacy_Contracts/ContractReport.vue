<template>
<div>
    <div class="md-layout md-gutter report-types">
      <div class="md-layout-item">
        <md-field>
          <label for="tileType">{{ $t('report.report_types') }}</label>
          <!-- @md-selected="onReportTypesChanged" -->
          <md-select
            v-model="selectedReportType"
            @md-selected="filterContractReport(selectedReportType)"
            name="reportType"
            id="reportType"
          >
            <md-option
              v-for="report of reportTypes"
              :key="report.key"
              :value="report.key"
            >
              {{ $t(translate(report.key)) }}
            </md-option>
          </md-select>
        </md-field>
      </div>
    </div>
    
    <md-card>
      <md-card-header
        class="md-card-header-icon md-card-header-green card-icon"
      >
        <div class="card-icon">
          <md-icon>view_list</md-icon>
        </div>
        <h4 class="title">{{ $t('contracts_list.title_rpt') }}</h4>
        <div class="report-export-icon" @click="onExport">
          <i class="fas fa-file-export" style='color: green'></i>
        </div>
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
          </md-table-toolbar>
          <md-table-row slot="md-table-row" slot-scope="{ item }">
            <md-table-cell :md-label="$t('contracts_list.contract_number')" style="font-family: phetsarath_ot;">{{ item.contract_number }}</md-table-cell>
              <md-table-cell :md-label="$t('contracts_list.contract_title')">{{ item.contract_title}}</md-table-cell>
              <md-table-cell :md-label="$t('contracts_list.project_name')">{{ item.project_name}}</md-table-cell>
              <md-table-cell :md-label="$t('contracts_list.contract_type')">{{ contractTypeText(item.id_contract_type) }}</md-table-cell>
              <md-table-cell :md-label="$t('contracts_list.contractor_name')">{{ contractorText(item.id_contractor) }}</md-table-cell>
              <md-table-cell :md-label="$t('contracts_list.employer')">{{ employerText(item.id_employer) }}</md-table-cell>
              <md-table-cell :md-label="$t('contracts_list.contract_duration')">{{ item.contract_duration }}</md-table-cell>
              <md-table-cell :md-label="$t('contracts_list.total_lenght')">{{ item.total_road_length_m | formatNumber}}</md-table-cell>

            <!-- <md-table-cell :md-label="$t('contracts_list.contract_number')">{{ item.contract_number }}</md-table-cell> -->
            <!-- <md-table-cell :md-label="$t('contracts_list.road_number')">{{ roadText(item.road_number) }}</md-table-cell> -->
            <!-- <md-table-cell md-label="Province"></md-table-cell> -->
            <!-- <md-table-cell md-label="Chainage"></md-table-cell> -->
            <!-- <md-table-cell md-label="Start">item.item[4].start_m</md-table-cell>
            <md-table-cell md-label="End">item.item[5].end_m</md-table-cell> -->
            <!-- <md-table-cell :md-label="$t('contracts_list.total_lenght')">{{ item.total_road_length_m | formatNumber}}</md-table-cell> -->
            <!-- <md-table-cell :md-label="$t('contracts_list.work_type')"></md-table-cell> -->
            <!-- <md-table-cell :md-label="$t('contracts_list.initial_cost(A)')">{{ item.initial_cost | currency('LAK', 0, { symbolOnLeft: false, spaceBetweenAmountAndSymbol: true })}}</md-table-cell> -->
            <!-- <md-table-cell :md-label="$t('contracts_list.revise_cost(B)')">{{ item.revised_cost | currency('LAK', 0, { symbolOnLeft: false, spaceBetweenAmountAndSymbol: true })}}</md-table-cell> -->
            <!-- <md-table-cell :md-label="$t('contracts_list.current_cost')">{{item.initial_cost + item.revised_cost | currency('LAK', 0, { symbolOnLeft: false, spaceBetweenAmountAndSymbol: true })}}</md-table-cell> -->
            <!-- <md-table-cell :md-label="$t('contracts_list.payment')">{{ (item.payments/(item.initial_cost + item.revised_cost)) | formatPercent}}</md-table-cell> -->
            <!-- <md-table-cell :md-label="$t('contracts_list.progress')">{{ item.progress_percentage/100 | formatPercent}}</md-table-cell> -->
            <!-- <md-table-cell :md-label="$t('contracts_list.status')">{{ item.status }}</md-table-cell> -->
            
          </md-table-row>
        </md-table>
      </md-card-content>
      
      <md-card-actions md-alignment="space-between">
        <div class="">
          <p class="card-category">
            {{$t('pagination.showing')}} {{ from + 1 }} {{$t('pagination.to')}} {{ to }} of {{ total }} {{$t('pagination.entries')}}
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
</div>
</template>
<script>
import { Pagination } from "@/components";
import Fuse from "fuse.js";
import XLSX from 'xlsx';
export default {
    name: 'contract-report',
    components: {Pagination,},
    data() {
        return {
            selectedReportType: 'none',
            reportTypes: [],
            isReportDataLoading: true,
            regtabledata: [],
            contract_list: [],
            contract_list_filtered: [],
            fuseSearch: null,
            currentSort: "name",
            currentSortOrder: "asc",
            searchedData: [],
            searchQuery: "",
            pagination: {
              perPage: 5,
              currentPage: 1,
              perPageOptions: [5, 10, 25, 50],
              total: 0
            },
            excel_rows: [],
            cont_report_type: [
              { 
                value: 1, 
                text_eng: 'Community Performance-based contract',
                text_lao: 'ອີງໃສ່ປະສິດທິພາບຂອງ​ການ​ມີ​ສ່ວນ​ຮ່ວມ​ຂອງ​ສະ​ມາ​ຄົມ'
              },
              { 
                value: 2, 
                text_eng: 'Contractor Performance-based contract',
                text_lao: '​ອີງໃສ່ປະສິດທິພາບຂອງ​ຜູ້​ຮັບ​ເໝົາ'
              },
              { 
                value: 3, 
                text_eng: 'Unit price contract', 
                text_lao: 'ສັນ​ຍາ​ຄິດ​ໄລ່​ຕາມ​ຫົວ​ໜ່ວຍ'
              },
              { 
                value: 4, 
                text_eng: 'Output Performance Based Road Contract', 
                text_lao: 'ອີງໃສ່​ຜົນ​ສຳ​ເລັດຂອງ​ການ​ສ້າງ​ເສັ້ນ​ທາງ'
              },
              { 
                value: 5, 
                text_eng: 'Admeasurement contract', 
                text_lao: 'ສັນ​ຍາ​ຕາມ​ການ​ວັດ​ແທກ'
              },
              { 
                value: 6, 
                text_eng: 'Lump sump contract', 
                text_lao: '​ສັນ​ຍາ​​ແບບ​ໝູນ​ຄ່າກໍ່​ສ້າງ'
              },
              { 
                value: 7, 
                text_eng: 'Cost plus contstruction contract', 
                text_lao: 'ສັນ​ຍາ​ທີ່​ເປັນ​ມູນ​ຄ່າ​ເພີ່ມ​ຂອງ​ການກໍ່​ສ້າງ'
              },
              { 
                value: 8, 
                text_eng: 'Target cost contstruction contract', 
                text_lao: '​ສັນ​ຍາ​ຕາມ​ລາ​ຄາ​ເປົ້າ​ໝາຍ​ຂອງ​ການກໍ່​ສ້າງ'
              }
            ],
             contractors_list: [] 
          }
    },
    props: {
        reportType: {
        type: String,
        required: true
        }
    },

    computed: {
        isShowReportTable() {
            return this.reportType !== 'list'
        },
        selectedReportName() {
          const report = this.reportTypes.find(
            (type) => type.key === this.selectedReportType
          )
          return report ? report.value : ''
        },
        report_headers() {
          return [...this.regtabledata.headers]
        },
        report_rows() {
          return [...this.contract_list_filtered.rows]
          // not used in contract report, use this.excel_rows instead
        },
        exportedData() {
          const result = !this.searchQuery
            ? this.contract_list_filtered
            : this.searchedData
            ? this.searchedData
            : []
          return result
        },
        /***
         * Returns a page from the searched data or the whole data. Search is performed in the watch section below
         */
        queriedData() {
          let result = this.contract_list_filtered;
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
            : this.contract_list_filtered.length;
        }
    },
    methods: {
      translate(value){
        // console.log("Value:", value)
        // console.log("Value-text:", this.cont_report_type[value-1])
        if(this.$i18n.locale == 'la'){
            return this.cont_report_type[value-1].text_lao
        }else {
          return this.cont_report_type[value-1].text_eng
        }
      },
      //  roadText(item){
      //   console.log("ROAD_NO:", item)
      //   return item.toString()
      // },
      contractTypeText(id){
        const cont_type = this.reportTypes.find(c =>c.key == id)
        console.log("cont_type:", cont_type)
        return cont_type.value
      },
      contractorText(id){
        const contractors = this.contractors_list.find(c =>c.key == id)
        console.log("contractor:", contractors)
        return  contractors ? contractors.value : ''
      },
      employerText(id){
        return id
      },
      getClass: ({ id }) => ({
        "table-success": id === 1,
        "table-info": id === 3,
        "table-danger": id === 5,
        "table-warning": id === 7
      }),
      customSort(value) {
        return value.sort((a, b) => {
          const sortBy = this.currentSort;
          if (this.currentSortOrder === "desc") {
            return a[sortBy].localeCompare(b[sortBy]);
          }
          return b[sortBy].localeCompare(a[sortBy]);
        });
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
    
    async filterContractReport(type) {
      this.regtabledata = await this.$store.dispatch('LOAD_CONTRACT_LIST', this.domain)
      console.log("REG-DATA:", this.regtabledata)
      this.excel_rows = this.regtabledata.rows.filter(t => t[4] == type)
      console.log("excel_rows:", this.excel_rows)
      await this.mapTableData()
      this.contract_list_filtered = this.contract_list.filter(t => t.id_contract_type == type)

      console.log("FILTER-DATA:", this.contract_list_filtered)
    },
    // not used in contract report
    async onReportTypesChanged(type) {
      
      // this.$router.push({path: `/contract/contracts_types/${type}`})
      this.$router.push({path: `/contract/funding_types/${type}`})

      this.isReportDataLoading = true

      try {
        await this.$store.dispatch('LOAD_CONTRACT_REPORT_DATA', type)
        this.contractors_list = await this.$store.state.Contract.contractors_list
        console.log("this.contractors_list:",this.contractors_list)
      } finally {
        this.isReportDataLoading = false
      }
    },
    onExport() {
      const headers = this.report_headers.map((header) =>
        this.$t(`translate.${header}`)
      )
      // const export_data = [headers, ...this.exportedData]
      const export_data = [headers, ...this.excel_rows]
      console.log("export_data:", export_data)
      const today = new Date().toJSON().slice(0, 10)
      const worksheet = XLSX.utils.aoa_to_sheet(export_data)
      const new_workbook = XLSX.utils.book_new()
      const filter_name = !this.searchQuery
        ? ''
        : `_filter(${this.searchQuery})`

      XLSX.utils.book_append_sheet(
        new_workbook,
        worksheet,
        `Report${filter_name}`
      )
      XLSX.writeFile(
        new_workbook,
        `export_${this.$t(this.reportName)}_${today}.xlsx`
      )
    },
  },
  watch: {
    /**
     * Searches through the table data by a given query.
     * NOTE: If you have a lot of data, it's recommended to do the search on the Server Side and only display the results here.
     * @param value of the query
     */
    searchQuery(value) {
      console.log("VALUE:",value)
      let result = this.contract_list_filtered;
      if (value !== "") {
        result = this.fuseSearch.search(this.searchQuery);
      }
      console.log("RESULT::",result)
      this.searchedData = result;
    }
  },
  async created() {
    // load contractor
        const ctr = await this.$store.dispatch('LOAD_CONTRACTORS')
        // this.contractors_list = [...ctr]
        this.contractors_list = await this.$store.state.Contract.contractors_list
        console.log("this.contractors_list:",this.contractors_list)
  },
     async mounted() {
      console.log("Lang:", this.$i18n.locale)
        //this.reportType = 'list'
        try {
            
            // const list = await this.$store.dispatch('LOAD_REPORTS_LIST')
            const list = await this.$store.dispatch('LOAD_CONTRACT_REPORTS_LIST')
            console.log("LOAD_CONTRACT_REPORTS_LIST-VUE:",list)
            this.reportTypes = [...list]
            console.log("this.reportTypes:",this.reportTypes)
            if (this.reportType !== 'list') {
                this.selectedReportType = this.reportType
            }

        } catch (err) {

        } finally {
        }

      this.fuseSearch = new Fuse(this.contract_list_filtered, {
        keys: ["contract_number", "road_number"],
        threshold: 0.3
      });

  }
}
</script>
<style lang="scss">
.report-types {
  max-width: 500px;
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
@import '@/assets/scss/md/_variables.scss';
.cell-actions {
  display: flex;
  flex-direction: column;
  align-items: flex-end;
  .md-button {
    margin: 3px 0;
    min-width: 100px;
  }
}
.category-select {
  max-width: 300px;
  top: 20px;
  margin-left: auto;
}
.btn-row {
  width: 100%;
  display: flex;
  justify-content: flex-end;
}

.report-load-progress {
  position: absolute;
  width: 100%;
  /* height: 100%; */
  top: 0px;
  display: flex;
  flex-direction: column;
  align-items: center;
  .progress-bar {
    width: 100%;
  }
}
.card-icon {
  z-index: 10;
}

.report-export-icon {
  position: absolute;
  right: 10px;
  top: 15px;
  font-size: 25px;
  color: $gray-color;
  cursor: pointer;
}
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.7s;
}
.fade-enter, .fade-leave-to /* .fade-leave-active до версии 2.1.8 */ {
  opacity: 0;
}
</style>