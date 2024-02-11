<template>
  <div>
    <div class="md-layout">
      <div class="md-layout-item">
        <div class="btn-row">
          <div class="btn-row">
            <md-button
              class="md-success"
              v-if="hasAccess(feature, 'create')"
              @click="onAdd"
            >
              {{ $t('button.add') }}
            </md-button>
          </div>
        </div>
        <md-card>
          <transition name="fade">
            <div v-if="isDataLoading" class="load-progress">
              <md-progress-bar
                class="progress-bar"
                md-mode="indeterminate"
              ></md-progress-bar>
            </div>
          </transition>
          <md-card-header
            class="md-card-header-icon md-card-header-green card-icon"
          >
            <div class="card-icon">
              <md-icon>public</md-icon>
            </div>
            <h4 class="title">{{ $t('label.environments') }}</h4>
          </md-card-header>

          <md-card-content>
            <md-table
              :md-sort-fn="customSort"
              :md-sort-order.sync="currentSortOrder"
              :md-sort.sync="currentSort"
              :value="queriedData"
              class="paginated-table table-striped table-hover"
            >
              <md-table-toolbar>
                <md-field>
                  <label for="pages">{{ $t('label.per_page') }}</label>
                  <md-select
                    :value="pagination.perPage"
                    name="pages"
                    @input="onChangePerPage"
                  >
                    <md-option
                      v-for="item in pagination.perPageOptions"
                      :key="item"
                      :label="item"
                      :value="item"
                    >
                      {{ item === 'all' ? $t('lable.table_all') : item }}
                    </md-option>
                  </md-select>
                </md-field>

                <md-field>
                  <md-input
                    v-model="searchQuery"
                    :placeholder="$t('label.search_records')"
                    class="mb-3"
                    clearable
                    style="width: 200px"
                    type="search"
                  ></md-input>
                </md-field>
              </md-table-toolbar>
              <md-table-empty-state
                :md-label="$t('label.there_is_no_records')"
                :md-description="``"
              ></md-table-empty-state>
              <md-table-row slot="md-table-row" slot-scope="{item}">
                <md-table-cell
                  :md-label="$t(`environments.environment_id`)"
                  md-sort-by="environments"
                >
                  {{ item.environment_id }}
                </md-table-cell>
                <md-table-cell
                  :md-label="$t(`environments.province`)"
                  md-sort-by="province"
                >
                  {{ item.province }}
                </md-table-cell>
                <md-table-cell
                  :md-label="$t(`environments.location`)"
                  md-sort-by="location"
                >
                  {{ item.location && item.location.name }}
                </md-table-cell>
                <md-table-cell
                  :md-label="$t(`environments.type_of_monitoring`)"
                  md-sort-by="type_of_monitoring"
                >
                  {{ item.type_of_monitoring && item.type_of_monitoring.name }}
                </md-table-cell>
                <md-table-cell
                  :md-label="$t(`environments.detail_description`)"
                  md-sort-by="detail_description"
                >
                  {{ item.detail_description }}
                </md-table-cell>
                <md-table-cell
                  :md-label="$t('tables.actions')"
                  v-if="hasAccess(feature, 'update')"
                >
                  <div class="cell-actions">
                    <md-button
                      class="md-raised md-sm md-primary"
                      @click.stop.prevent="onEdit(item.environment_id)"
                    >
                      {{ $t('button.edit') }}
                    </md-button>
                    <md-button
                      class="md-raised md-sm md-danger"
                      @click.stop.prevent="onDelete(item.environment_id)"
                    >
                      {{ $t('button.delete') }}
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
              v-model="pagination.currentPage"
              :per-page="pagination.perPage"
              :total="total"
              class="pagination-no-border pagination-success"
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
import {permMixin} from '@/mixins/permission'
import Swal from 'sweetalert2'

export default {
  name: 'Environments',
  mixins: [permMixin],
  data() {
    return {
      feature: 'environments',
      isDataLoading: true,
      dataList: [],
      currencyList: [],
      currentSort: 'name',
      currentSortOrder: 'desc',
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
  components: {
    Pagination
  },
  async created() {
    this.isDataLoading = true
    try {
      this.dataList = await this.$store.dispatch('LOAD_ENVIRONMENTS')
    } finally {
      this.isDataLoading = false
    }
  },

  computed: {
    ...mapState({}),
    queriedData() {
      const result = !this.searchQuery
        ? this.tableData
        : this.searchedData
        ? this.searchedData
        : []
      return result.slice(this.from, this.to)
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
      return this.dataList
    }
  },
  methods: {
    formatDate(src) {
      const year = src.getFullYear()
      const month = src.getMonth() + 1
      const day = src.getDate()
      return `${year}-${month}-${day}`
    },
    onAdd() {
      this.$router.push({name: 'environment-add'})
    },
    onEdit(environmentId) {
      this.$router.push({
        name: 'environment-upd',
        params: {environmentId}
      })
    },
    onDelete(item) {
      Swal.fire({
        title: 'Are you sure?',
        text: `You won't be able to revert this!`,
        type: 'warning',
        showCancelButton: true,
        confirmButtonClass: 'md-button md-success btn-fill',
        cancelButtonClass: 'md-button md-danger btn-fill',
        confirmButtonText: 'Yes, delete it!',
        buttonsStyling: false
      }).then(async (result) => {
        if (result.value) {
          try {
            await this.$store.dispatch('DELETE_ACCIDENT', item.accident_id)
            const ind = this.dataList.findIndex(
              (row) => row.accident_id === item.accident_id
            )
            console.log({ind})
            this.dataList.splice(ind, 1)
            await Swal.fire({
              title: 'Deleted!',
              text: `You deleted accident #${item.accident_id}`,
              type: 'success',
              confirmButtonClass: 'md-button md-success btn-fill',
              buttonsStyling: false
            })
          } catch (err) {
            await Swal.fire({
              title: 'Error!',
              text: `Accident #${item.accident_id} was not deleted, err: ${err}`,
              type: 'error',
              confirmButtonClass: 'md-button md-success btn-fill',
              buttonsStyling: false
            })
          } finally {
          }
        }
      })
    },
    onChangePerPage(val) {
      const limit = val === 'all' ? this.total : val
      this.pagination.perPage = limit
    },
    isNumber(value) {
      return typeof value === 'number' && isFinite(value)
    },
    customSort(value) {
      return value.sort((a, b) => {
        const sortBy = this.currentSort
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
          return Object.keys(row).reduce(
            (incl, elem) => incl || regex.test(row[elem]),
            false
          )
        })
      } //this.fuseSearch.search(this.searchQuery)
      this.searchedData = result
    }
  }
}
</script>

<style lang='scss'>
@import '@/assets/scss/md/_variables.scss';

.valign-center {
  display: flex;
  align-items: center;

  span {
    padding-left: 5px;
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

.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.7s;
}

.fade-enter, .fade-leave-to /* .fade-leave-active до версии 2.1.8 */ {
  opacity: 0;
}
</style>
