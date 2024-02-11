<template>
  <div>
    <div class="md-layout">
      <div class="md-layout-item">
        <div class='btn-row'>
          <md-button class='md-success' v-if="hasAccess(feature, 'create')" @click='onAdd'>
            {{ $t('button.add') }}
          </md-button>
        </div>
        <md-card>
          <transition name="fade">
            <div v-if="isDataLoading" class="load-progress">
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
            <h4 class="title">{{ $t('label.contracts') }}</h4>
            <div class="export-icon" @click="onExport">
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
                      {{ item === 'all' ? $t('table.table_all') : item }}
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
                <md-table-cell :md-tooltip="$t('lots.lot_name')" :md-label="$t('lots.lot_name')">
                  <div class="lot-num-details">
                    <md-button
                        class="md-just-icon md-simple md-success"
                        @click='onInspections(item[indexByName(dataHeaders, "id")])'
                        :title="$t('button.daily_inspections')"
                    >
                      <md-icon class="lot-inspection-icon">playlist_add_check</md-icon>

                    </md-button>
                    <span>
                    {{ item[indexByName(dataHeaders, "lot_name")] }}
                    </span>

                  </div>

                </md-table-cell>
                <md-table-cell :md-label="$t('contracts.lot_no')" :md-tooltip="$t('contracts.lot_no')" md-numeric>
                  {{ item[indexByName(dataHeaders, "lot_no")] }}
                </md-table-cell>
                <md-table-cell :md-label="$t('contracts.contract_number')" :md-tooltip="$t('contracts.contract_number')" md-numeric>
                  {{ item[indexByName(dataHeaders, "contract_id")] }}
                </md-table-cell>
                <md-table-cell :md-tooltip="$t('lots.lot_value')" :md-label="$t('lots.lot_value')" md-numeric>
                  {{ item[indexByName(dataHeaders, "lot_value")] | formatNumber }}
                </md-table-cell>
                <md-table-cell :md-tooltip="$t('lots.local_financing')" :md-label="$t('lots.local_financing')" md-numeric>
                  {{ item[indexByName(dataHeaders, "local_financing")] | formatNumber }}
                </md-table-cell>
                <md-table-cell :md-tooltip="$t('lots.manager')" :md-label="$t('lots.manager')" md-numeric>{{
                    item[indexByName(dataHeaders, "manager_id")]
                  }}
                </md-table-cell>


                <md-table-cell
                    :md-label="$t('tables.actions')"
                    v-if="hasAccess(feature, 'update')"
                >
                  <div class='cell-actions'>
                    <md-button
                        class='md-raised md-sm md-primary'
                        @click.stop.prevent='onEdit(item[indexByName(dataHeaders, "id")])'
                    >
                      {{ $t('button.edit') }}
                    </md-button>
                    <md-button
                        class='md-raised md-sm md-info'
                        @click.stop.prevent='onLotContent(item[indexByName(dataHeaders, "id")])'
                    >
                      {{ $t('button.content') }}
                    </md-button>
                  </div>
                </md-table-cell>
                <!--md-table-cell

                    v-for="(cell_header, index) of dataHeaders"
                    :key="cell_header"
                    :md-label="$t(`translate.${cell_header}`)"
                    :md-sort-by="cell_header"
                    :md-numeric="!isNaN(item[index])"
                >
                  {{ dataLocalisation.includes(index) ? $t(item[index]) : item[index] }}
                </md-table-cell-->
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
import {Pagination} from '@/components'
import {utils, writeFile} from 'xlsx'
import {permMixin} from "@/mixins/permission"

export default {
  name: "contract-lot-list",
  props: {
    contractId: {type: Number}
  },
  data() {
    return {
      feature: 'contract-lots',
      formData: {headers: [], rows: [], length, translate: []},
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
      fuseSearch: null,
      isDataLoading: false,
    }
  },

  mixins: [permMixin],
  components: {
    Pagination
  },
  async created() {
    try {
      this.isDataLoading = true
      this.formData = await this.$store.dispatch('LOAD_CONTRACT_LOTS', this.contractId)
    } catch (err) {
      throw err
    } finally {
      this.isDataLoading = false
    }
  },
  computed: {
    dataHeaders() {
      return [...this.formData.headers]
    },
    dataRows() {
      return [...this.formData.rows]
    },
    dataLocalisation() {
      const localisation = this.formData.translate
      return (localisation && Array.isArray(localisation)) ? [...localisation] : []
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
      return this.dataRows
    }
  },
  methods: {
    onInspections(lotId) {
      this.$router.push({name: "contract-daily-inspections", params: {contractId: this.contractId, lotId: lotId}})
    },
    onAdd() {
      this.$router.push({name: "contract-lot-add",})
    },
    onEdit(lotId) {
      this.$router.push({name: "contract-lot-upd", params: {contractId: this.contractId, lotId: lotId}})
    },
    onContractLots(lotId) {

    },
    onLotContent(lotId) {
      this.$router.push({name: "contract-lot-content", params: {contractId: this.contractId, lotId: lotId}})
    },
    indexByName(arr, name) {
      return arr.findIndex(item => item === name)
    },
    onExport() {
      const headers = this.dataHeaders.map((header) =>
          this.$t(`translate.${header}`)
      )
      const export_data = [headers, ...this.exportedData]
      const today = new Date().toJSON().slice(0, 10)
      const worksheet = utils.aoa_to_sheet(export_data)
      const new_workbook = utils.book_new()
      const filter_name = !this.searchQuery
          ? ''
          : `_filter(${this.searchQuery})`

      utils.book_append_sheet(
          new_workbook,
          worksheet,
          `${this.name}${filter_name}`
      )
      writeFile(
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
      const dataInd = this.dataHeaders.findIndex(
          (elem) => elem === this.currentSort
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
    // unitCostHeaders() {
    // }
  }
}
</script>

<style lang="scss">
@import '@/assets/scss/md/_variables.scss';

//.md-table-head-label {
//  height: auto;
//  max-width: 170px;
//  padding-right: 32px;
//  padding-left: 2px;
//  display: inline-block;
//  position: relative;
//  line-height: 20px;
//}
//
//.md-table-head-container, .md-table-head-label {
//  overflow: hidden;
//  white-space: inherit;
//}
.lot-num-details {
  display: flex;
  flex-direction: row;
  align-items: center;
  cursor: pointer;
  gap: 1em;

  .md-button {
    i {
      font-size: 1.1em !important;
    }
  }
}


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

.md-table-head-container {
  //text-align: center;
}

.load-progress {
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

.export-icon {
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

.fade-enter, .fade-leave-to /* .fade-leave-active до версии 2.1.8 */
{
  opacity: 0;
}
</style>
<style lang="scss">

.btn-row {
  width: 100%;
  display: flex;
  justify-content: flex-end;
}

.md-table-head-label {
  height: 40px;
  max-width: 150px;
  padding-right: 32px;
  padding-left: 2px;
  display: inline-block;
  position: relative;
  line-height: 20px;
}

.md-table-head-container, .md-table-head-label {
  overflow: hidden;
  white-space: inherit;
}

</style>
