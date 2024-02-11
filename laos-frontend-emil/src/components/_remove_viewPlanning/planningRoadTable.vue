<template>
  <div class="md-layout">
    <div class="md-layout-item">
      <div style="position: relative;">
        <div style="color:white">
          {{ pagination.perPage }}
        </div>
        <div class="plan-right-icon">
          <i
            class="fas fa-cog"
            @click="onEditParams"
            :title="$t('button.plan_properties')"
          ></i>
          <i
            v-if="isCommitEnable"
            class="fas fa-lock "
            @click="onCommitPlanTypeChanges"
            :title="$t('button.fix_the_plan_type_state')"
          ></i>
          <i
            v-if="isCommitEnable"
            class="fas fa-sync-alt "
            :class="{'fa-spinner': isPlanDataGenerating}"
            @click="onGenPlanData"
            :title="$t('button.planning_data_regeneration')"
          ></i>
          <i
            v-if="isCommitEnable"
            class="fas fa-save"
            @click="onSavePlanData"
            :title="$t('button.save_planning_changes')"
          ></i>
          <i
            class="fas fa-file-export"
            @click="onExport"
            :class="{'fa-spinner': isPlanExportDataLoading}"
            :title="$t('button.export_data_to_xlsx')"
          ></i>
        </div>
      </div>

      <md-card :style="{opacity: isPlanDataGenerating ? 0.3 : 1}">
        <transition name="fade">
          <div v-if="isPlanDataLoading" class="report-load-progress">
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
          <h4 class="title">{{ $t('label._remove_planning') }}</h4>
          <div class="card-right-icon">
            <i
              class="fas fa-reply"
              :style="{opacity: hasParent ? 1 : 0}"
              @click="onGoToPrev"
              :title="$t('button.return_to_group_of_data')"
            ></i>
          </div>
        </md-card-header>

        <md-card-content>
          <md-table
            :value="queriedData"
            :md-sort.sync="currentSort"
            :md-sort-order.sync="currentSortOrder"
            :md-sort-fn="customSort"
            class="paginated-table table-striped table-hover"
            @md-selected="onRowSelect"
            :md-selected-value.sync="selectedRows"
            @md-sorted="onSortChange"
            v-if="!isPlanDataLoading"
          >
            <md-table-toolbar>
              <div class="md-layout md-gutter md-alignment-center-space-around">
                <div class="md-layout-item md-layout md-gutter">
                  <md-field>
                    <label for="pages">{{ $t('label.per_page') }}</label>
                    <md-select
                      @input="onChangePagPerPage"
                      v-model="pagination.perPage"
                      name="pagination_perpage"
                      id="pagination_perpage"
                    >
                      <md-option
                        v-for="item in pagination.perPageOptions"
                        :key="item"
                        :label="item"
                        :value="item === 'all' ? table_length : item"
                      >
                        {{
                          item === 'all'
                            ? `${$t('reports.table_all')} (${table_length})`
                            : item
                        }}
                      </md-option>
                    </md-select>
                  </md-field>
                </div>
                <div
                  class="md-layout-item md-layout md-gutter md-alignment-center-right "
                >
                  <div class="search-block">
                    <md-field>
                      <md-input
                        class="mb-3"
                        style="width: 230px"
                        :placeholder="$t('label.search_records')"
                        v-model="searchQuery"
                        @keyup.enter="onSearch"
                      ></md-input>
                      <md-button
                        class="md-just-icon md-simple button-clear"
                        @click="onClearSearch"
                        v-if="searchQuery.length > 0"
                      >
                        <md-icon>clear</md-icon>
                      </md-button>
                      <md-button
                        class="md-just-icon md-simple "
                        @click="onSearch"
                      >
                        <md-icon>search</md-icon>
                      </md-button>
                    </md-field>
                    <Filter-box
                      :filterList="filterList"
                      :filterDefOptions="filterQueryDef"
                      @setFilter="setFilter"
                    ></Filter-box>
                  </div>
                </div>
              </div>
            </md-table-toolbar>
            <md-table-empty-state
              v-if="table_length === 0"
              md-label="No records found"
              :md-description="
                `No work found for this '${searchQueryDef}' query. Try a different search term.`
              "
            ></md-table-empty-state>

            <md-table-row
              slot="md-table-row"
              slot-scope="{item}"
              :md-selectable="'multiple'"
              :selected="hasParent"
              :md-disabled="!hasParent"
              :md-indeterminate="true"
            >
              <md-table-cell
                v-for="(cell_header, index) of table_headers"
                :key="cell_header"
                :md-label="
                  cell_header !== 'selected'
                    ? $t(`planning.table_${cell_header}`)
                    : ''
                "
                :md-sort-by="cell_header !== 'selected' ? cell_header : ''"
              >
                <template v-if="cell_header === 'roadcode' && !hasParent">
                  <a href="#" @click="onOpenSubTable(item[index])">
                    {{ item[index] }}
                  </a>
                </template>
                <template
                  v-else-if="
                    ['preselected_percent', 'user_modified_percent'].includes(
                      cell_header
                    )
                  "
                >
                  <div class="modified-percent">
                    <md-progress-bar
                      md-mode="determinate"
                      :md-value="item[index]"
                    ></md-progress-bar>
                    <span class="percent-val">{{ `${item[index]}%` }}</span>
                  </div>
                </template>
                <template v-else-if="cell_header === 'selected'"></template>
                <template v-else>
                  <span
                    :class="{
                      'field-description': cell_header === 'work_description'
                    }"
                  >
                    {{
                      table_rows_to_localise.includes(index)
                        ? Array.isArray(item[index])
                          ? item[index].map((elem) => $t(elem)).join(', ')
                          : $t(item[index])
                        : item[index]
                    }}
                  </span>
                </template>
              </md-table-cell>
            </md-table-row>
          </md-table>
        </md-card-content>
        <md-card-actions md-alignment="space-between">
          <div class>
            <p class="card-category">
              {{
                $t('label.showing_from_to_of_entries', {
                  from: to === 0 ? 0 : from + 1,
                  to: to,
                  total
                })
              }}
            </p>
          </div>
          <pagination
            class="pagination-no-border pagination-success"
            :value="pagCurrentPage"
            @input="onChangePagPage"
            :per-page="pagination.perPage"
            :total="total"
          ></pagination>
        </md-card-actions>
      </md-card>
    </div>
  </div>
</template>
<script>
import {Pagination, FilterBox} from '@/components'
import {mapState} from 'vuex'

//import Fuse from 'fuse.js'
//import Swal from 'sweetalert2'

export default {
  data() {
    return {
      currentSort: 'start_m',
      currentSortOrder: 'asc',
      pagination: {
        perPage: 50,
        perPageOptions: [5, 10, 25, 50, 'all'],
        total: 0
      },
      propsToSearch: ['key'],
      searchedData: [],
      fuseSearch: null,
      selectedRows: [],
      startSelectedRows: [],
      oldSelectedRows: [],
      searchQuery: ''
    }
  },
  props: {
    isPlanDataLoading: {type: Boolean, required: true},
    isPlanDataGenerating: {type: Boolean, required: true},
    isPlanExportDataLoading: {type: Boolean, required: true},
    plan_data: {type: Object, required: true},
    plan_id: {type: String, required: true},
    hasParent: {type: Boolean, required: true},
    isCommitEnable: {type: Boolean, required: true},
    pagPerPage: {type: Number},
    pagCurrentPage: {type: Number},
    searchQueryDef: {type: String, default: ''},
    lsort: {type: String},
    filterQueryDef: {type: Object}
  },
  components: {
    Pagination,
    FilterBox
    //SlideYDownTransition
  },
  async created() {
    this.searchQuery = this.searchQueryDef
  },

  computed: {
    ...mapState({filterList: (state) => state.Planning.filter_list}),
    table_headers() {
      return this.plan_data.headers
    },
    table_rows() {
      return this.plan_data.rows
    },
    table_rows_to_localise() {
      return this.plan_data.to_localise
    },

    table_length() {
      return this.plan_data.length
    },
    queriedData() {
      return this.tableData
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
      let highBound = this.from + this.pagPerPage
      if (this.total < highBound) {
        highBound = this.total
      }
      return highBound
    },
    from() {
      return this.pagPerPage * (this.pagCurrentPage - 1)
    },
    total() {
      return this.table_length
    },
    tableData() {
      return this.table_rows
    },
    indSelected() {
      return this.plan_data.headers.indexOf('selected')
    },
    indCost() {
      return this.plan_data.headers.indexOf('cost')
    },
    indId() {
      return this.plan_data.headers.indexOf('id')
    }
  },
  methods: {
    onSortChange(sort) {
      const sortDirect =
        this.currentSort === sort && this.currentSortOrder === 'asc' ? '-' : ''
      this.$emit('onChangeSort', `${sortDirect}${sort}`)
    },
    onSavePlanData() {
      this.$emit('onSavePlanData')
    },
    onChangePagPage(val) {
      if (val !== this.pagCurrentPage) {
        this.$emit('onGoToPage', val)
      }
    },
    onClearSearch() {
      this.searchQuery = ''
      if (this.searchQueryDef) {
        this.$emit('onSearch', 'none')
      }
    },
    onSearch() {
      if (this.searchQuery !== this.searchQueryDef) {
        const search = this.searchQuery ? this.searchQuery : 'none'
        this.$emit('onSearch', search)
      }
    },
    setFilter(filter) {
      this.$emit('setFilter', filter)
    },
    onCommitPlanTypeChanges() {
      this.$emit('onCommitCurrentPlanTypeChanges')
    },
    onGenPlanData() {
      this.$emit('onGenPlanData')
      this.pagination.currentPage = 1
    },
    onOpenSubTable(roadcode) {
      this.$emit('onChangeLevelNext', {roadcode})
    },
    onGoToPrev() {
      if (this.hasParent) {
        this.$emit('onChangeLevelPrev', {roadcode: 'none'})
      }
    },
    onRowSelect(selected) {
      if (!this.isPlanDataLoading) {
        let changed = []
        //let wasModified = false
        let sumDif = 0

        const old_selected_ids = this.oldSelectedRows.map((row) => {
          return {secId: row[this.indId], secCost: row[this.indCost]}
        })

        const curr_selected_ids = selected.map((row) => {
          return {secId: row[this.indId], secCost: row[this.indCost]}
        })

        old_selected_ids.forEach(({secId, secCost}) => {
          if (!~curr_selected_ids.findIndex((item) => item.secId === secId)) {
            changed.push({id: secId, act: 'deleted'})
            sumDif -= secCost
          }
        })

        curr_selected_ids.forEach(({secId, secCost}) => {
          if (!~old_selected_ids.findIndex((item) => item.secId === secId)) {
            changed.push({id: secId, act: 'added'})
            sumDif += secCost
          }
        })
        this.oldSelectedRows = [...selected]

        if (changed.length > 0) {
          this.$emit('changedCurrentPlanCost', sumDif)
          this.$emit('onModifyTableData', changed)
        }
      }
    },
    onEditParams() {
      this.$emit('onChangePlanParams')
    },
    onExport() {
      this.$emit('onExport')
    },
    onChangePagPerPage(val) {
      this.$emit('onChangePerPage', val)
    },
    isNumber(value) {
      return typeof value === 'number' && isFinite(value)
    },
    customSort(value) {
      const dataInd = this.table_headers.findIndex(
        (report) => report === this.currentSort
      )
      if (!~dataInd) {
        return
      }

      const sorted = value.sort((a, b) => {
        const sortBy = dataInd
        const aValue = a[sortBy] === null ? '' : a[sortBy].toString()
        const bValue = b[sortBy] === null ? '' : b[sortBy].toString()
        if (this.currentSortOrder === 'asc') {
          return aValue.localeCompare(bValue, undefined, {numeric: true})
        }
        return bValue.localeCompare(aValue, undefined, {numeric: true})
      })
      return sorted
    }
  },
  watch: {
    lsort(newVal /*,oldVal*/) {
      this.currentSortOrder = newVal.startsWith('-') ? `desc` : `asc`
      this.currentSort = newVal.startsWith('-')
        ? `${newVal.substring(1)}`
        : `${newVal}`
    },
    isPlanDataLoading(newVal /*, oldValue*/) {
      if (newVal === false) {
        this.selectedRows = this.table_rows.filter(
          (row) => row[this.indSelected]
        )

        this.startSelectedRows = [...this.selectedRows]
        this.oldSelectedRows = [...this.selectedRows]
        this.searchQuery = this.searchQueryDef

        this.pagination.perPage = this.pagPerPage
      } else {
        this.selectedRows = []
      }
    },
    table_headers() {}
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

.search-block {
  display: flex;
  icon {
    color: white;
    &:hover {
      color: grey;
    }
  }
  .button-clear {
    position: absolute;
    right: 41px;
  }
}

.paginated-table table > tbody > tr > td {
  max-width: unset;
  width: unset;
}

.md-table.md-theme-default .md-table-head {
  position: relative;
  z-index: 1;
}

.md-table {
  overflow-x: unset;
}
.paginated-table table > tbody > tr > td:first-child {
  //padding-left: 10px;
  //color: red;
}

.md-table-head-container {
  //text-align: center;
}
.md-table-cell-container {
  span.field-description {
    white-space: pre;
  }
  .modified-percent {
    display: flex;
    width: 100%;
    align-items: center;
    padding: 0 5px;
    .md-progress-bar {
      width: 100%;
      margin: 4px 5px;
    }
    span {
      width: 4rem;
    }
  }
}

.md-table.md-theme-default .md-table-row.md-selected {
  background-color: #e0f5da;
  font-weight: 700;
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

.plan-right-icon {
  position: absolute;
  top: 15px;
  right: 0px;
  font-size: 25px;
  display: flex;
  justify-content: center;
  i {
    color: $grey-400;
    margin-right: 7px;
    border-radius: 2px;
    text-decoration: none;
    border: 1px solid #ffffff;
    cursor: pointer;
    &:hover {
      //border: 1px solid $grey-300;
      color: $gray-color;
      text-decoration: none;
    }
  }
  .succes-color:hover {
    color: $brand-success;
  }
}

.card-right-icon {
  i {
    color: $grey-400;
    border-radius: 2px;
    text-decoration: none;
    border: 1px solid #ffffff;
    margin-right: 5px;
    cursor: pointer;
    &:hover {
      //border: 1px solid $grey-300;
      color: $gray-color;
      text-decoration: none;
    }
  }
}
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.7s;
}
.fade-enter, .fade-leave-to /* .fade-leave-active до версии 2.1.8 */ {
  opacity: 0;
}

/* Define an animation behavior */
@keyframes spinner {
  to {
    transform: rotate(360deg);
  }
}
/* This is the class name given by the Font Awesome component when icon contains 'spinner' */
.fa-spinner {
  /* Apply 'spinner' keyframes looping once every second (1s)  */
  animation: spinner 1s linear infinite;
  color: $brand-primary !important;
}
</style>
