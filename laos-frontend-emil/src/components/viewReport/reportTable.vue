<template>
  <div>
    <div class="md-layout">
      <div class="md-layout-item">
        <md-card>
          <transition name="fade">
            <div v-if="isReportDataLoading" class="report-load-progress">
              <md-progress-bar
                md-mode="indeterminate"
                class="progress-bar"
              ></md-progress-bar>
            </div>
          </transition>
          <md-card-header
            class="md-card-header-icon md-card-header-green card-icon"
          >
            <div class="card-icon">
              <md-icon>view_list</md-icon>
            </div>
            <h4 class="title">{{ $t('label.reports') }}</h4>
            <div class="report-export-icon" @click="onExport">
              <i class="fas fa-file-export"></i>
            </div>
          </md-card-header>

          <md-card-content>
            <md-table
              :value="queriedData"
              :md-sort.sync="currentSort"
              :md-sort-order.sync="currentSortOrder"
              :md-sort-fn="customSort"
              class="paginated-table table-striped table-hover"
            >
              <md-table-toolbar>
                <md-field>
                  <label for="pages">{{ $t('label.per_page') }}</label>
                  <md-select
                    @input="onChangePerPage"
                    :value="pagination.perPage"
                    name="pages"
                  >
                    <md-option
                      v-for="item in pagination.perPageOptions"
                      :key="item"
                      :label="item"
                      :value="item"
                    >
                      {{ item === 'all' ? $t('reports.table_all') : item }}
                    </md-option>
                  </md-select>
                </md-field>

                <md-field>
                  <md-input
                    type="search"
                    class="mb-3"
                    clearable
                    style="width: 200px"
                    :placeholder="$t('label.search_records')"
                    v-model="searchQuery"
                  ></md-input>
                </md-field>
              </md-table-toolbar>
              <md-table-row slot="md-table-row" slot-scope="{item}">
                <md-table-cell
                  v-for="(cell_header, index) of report_headers"
                  :key="cell_header"
                  :md-label="$t(`road_rpt.${cell_header}`)"
                  :md-sort-by="cell_header"
                  :md-tooltip="$t(`road_rpt.${cell_header}`)"
                  :md-numeric="!isNaN(item[index])"
                >
                  {{ item[index] }}
                </md-table-cell>
              </md-table-row>
            </md-table>
          </md-card-content>
          <md-card-actions md-alignment="space-between">
            <div class>
              <p class="card-category">
              {{$t('pagination.showing')}} {{ from + 1 }} {{$t('pagination.to')}} {{ to }} of {{ total }} {{$t('pagination.entries')}}
            </p>
            </div>
            <pagination
              class="pagination-no-border pagination-success"
              v-model="pagination.currentPage"
              :per-page="pagination.perPage"
              :total="total"
            ></pagination>
          </md-card-actions>
        </md-card>
      </div>
    </div>
  </div>
</template>
<script>
import {mapState} from 'vuex'
import {Pagination} from '@/components'
import XLSX from 'xlsx'

export default {
  data() {
    return {
      currentSort: 'id',
      currentSortOrder: 'asc',
      pagination: {
        perPage: 10,
        currentPage: 1,
        perPageOptions: [5, 10, 25, 50, 'all'],
        total: 0
      },
      searchQuery: '',
      propsToSearch: ['key'],
      searchedData: [],
      fuseSearch: null
    }
  },
  props: {
    isReportDataLoading: {type: Boolean, required: true},
    reportName: {type: String, required: true}
  },
  components: {
    Pagination
  },
  created() {},

  computed: {
    ...mapState({
      report_data: (state) => state.Reports.report_data
    }),
    report_headers() {
      return [...this.report_data.headers]
    },
    report_rows() {
      return [...this.report_data.rows]
    },
    queriedData() {
      const result = !this.searchQuery
        ? this.tableData
        : this.searchedData
        ? this.searchedData
        : []
      return result.slice(this.from, this.to)
    },
    exportedData() {
      const result = !this.searchQuery
        ? this.tableData
        : this.searchedData
        ? this.searchedData
        : []
      return result
    },
    to() {
      let highBound = this.from + this.pagination.perPage
      if (this.total < highBound) {
        highBound = this.total
      }
      return highBound
    },
    from() {
      return this.pagination.perPage * (this.pagination.currentPage - 1)
    },
    total() {
      return this.searchQuery ? this.searchedData.length : this.tableData.length
    },
    tableData() {
      return this.report_rows
    }
  },
  methods: {
    onExport() {
      const headers = this.report_headers.map((header) =>
        this.$t(`translate.${header}`)
      )
      const export_data = [headers, ...this.exportedData]
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
    onChangePerPage(val) {
      const limit = val === 'all' ? this.total : val
      this.pagination.perPage = limit
    },
    isNumber(value) {
      return typeof value === 'number' && isFinite(value)
    },
    customSort(value) {
      const dataInd = this.report_headers.findIndex(
        (report) => report === this.currentSort
      )
      if (!~dataInd) {
        return
      }
      return value.sort((a, b) => {
        const sortBy = dataInd
        const aValue = a[sortBy] === null ? '' : a[sortBy].toString()
        const bValue = b[sortBy] === null ? '' : b[sortBy].toString()
        if (this.currentSortOrder === 'desc') {
          return aValue.localeCompare(bValue, undefined, {numeric: true})
        }
        return bValue.localeCompare(aValue, undefined, {numeric: true})
      })
    }
  },
  watch: {
    /**
     * Searches through the table data by a given query.
     * NOTE: If you have a lot of data, it's recommended to do the search on the Server Side and only display the results here.
     * @param value of the query
     */
    searchQuery(value) {
      let result = this.tableData
      const regex = new RegExp(`${value}`, 'i')
      if (value !== '') {
        result = this.tableData.filter((row) => {
          return row.reduce((incl, elem) => incl || regex.test(elem), false)
        }) //this.fuseSearch.search(this.searchQuery)
      }
      this.searchedData = result
    },
    report_headers() {}
  }
}
</script>

<style lang="scss">
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

.md-table-head-label {
  max-width: 150px;
}
.md-table-head-container {
  //text-align: center;
  white-space: inherit;
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
