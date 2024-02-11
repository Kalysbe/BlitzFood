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
                                <md-table-cell
                                    v-for="col in visibleHeaders"
                                    :key="col"
                                    :md-tooltip="$t(`contracts.${col}`)" :md-label="$t(`contracts.${col}`)"
                                :md-numeric="!isNaN(item[indexByName(dataHeaders, col)]) || ['revised_end', 'updated_at'].includes(col)">
                                    {{ item[indexByName(dataHeaders, col)] }}
                                </md-table-cell>

                                <md-table-cell
                                        :md-label="$t('tables.actions')"
                                        v-if="hasAccess(feature, 'update')"
                                >
                                    <div class='cell-actions'>
                                        <md-button
                                                class='md-raised md-sm md-primary'
                                                @click.prevent='onEdit(item[indexByName(dataHeaders, "id_contract")])'
                                        >
                                            {{ $t('button.edit') }}
                                        </md-button>
                                    </div>
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
    name: "contract-variation-list",
    data() {
        return {
            feature: 'contract-variations',
            formData: {headers: [], rows: [], length, translate: []},
            currentSort: 'id',
            currentSortOrder: 'asc',
            pagination: {
                perPage: 10,
                currentPage: 1,
                perPageOptions: [5, 10, 25, 50, 'all'],
                total: 0
            },
            visibleHeaders: [
                'id_contract',
                'variation_number',
                'revised_cost',
                'revised_end',
                'updated_at',
                'updated_by',
                'comments',],
            searchQuery: '',
            propsToSearch: ['key'],
            searchedData: [],
            fuseSearch: null,
            isDataLoading: false,
            statusList: []

        }
    },
    mixins: [permMixin],
    components: {
        Pagination
    },
    props: ["contractId"],
    async created() {
        try {
            this.isDataLoading = true
            this.formData = await this.$store.dispatch('LOAD_CONTRACT_VARIATIONS', this.contractId)
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
        onAdd() {
            this.$router.push({name: "contract-variations-add",params: {contractId:this.contractId}})
        },
        onEdit(variationId) {
            this.$router.push({name: "contract-variations-upd", params: {contractId:this.contractId, variationId}})
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
.contract-num-details {
  display: flex;
  flex-direction: row;
  align-items: center;

  i {
    padding-right: 3px;
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

.btn-row {
  width: 100%;
  display: flex;
  justify-content: flex-end;
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
