<template>
  <div>
    <div class='md-layout'>
      <div class='md-layout-item'>
        <div class='btn-row'>
          <md-button class='md-success' v-if="hasAccess(feature, 'create')" @click='onAdd'>
            {{ $t('button.add') }}
          </md-button>
        </div>
        <md-card>
          <transition name='fade'>
            <div v-if='isDataLoading' class='load-progress'>
              <md-progress-bar
                  class='progress-bar'
                  md-mode='indeterminate'
              ></md-progress-bar>
            </div>
          </transition>
          <md-card-header
              class='md-card-header-icon md-card-header-green card-icon'
          >
            <div class='card-icon'>
              <md-icon>view_list</md-icon>
            </div>
            <h4 class='title'>{{ $t('label.bill_of_quantities') }}</h4>
          </md-card-header>

          <md-card-content>
            <md-table
                :md-sort-fn='customSort'
                :md-sort-order.sync='currentSortOrder'
                :md-sort.sync='currentSort'
                :value='queriedData'
                class='paginated-table table-striped table-hover'
            >
              <md-table-toolbar>
                <md-field>
                  <label for='pages'>{{ $t('label.per_page') }}</label>
                  <md-select
                      :value='pagination.perPage'
                      name='pages'
                      @input='onChangePerPage'
                  >
                    <md-option
                        v-for='item in pagination.perPageOptions'
                        :key='item'
                        :label='item'
                        :value='item'
                    >
                      {{ item === 'all' ? $t('reports.table_all') : item }}
                    </md-option>
                  </md-select>
                </md-field>

                <md-field>
                  <md-input
                      v-model='searchQuery'
                      :placeholder="$t('label.search_records')"
                      class='mb-3'
                      clearable
                      style='width: 200px'
                      type='search'
                  ></md-input>
                </md-field>
              </md-table-toolbar>
              <md-table-empty-state
                  :md-label="$t('label.there_is_no_records')"
                  :md-description="``">
              </md-table-empty-state>
              <md-table-row slot='md-table-row' slot-scope='{item}'>

                <md-table-cell
                    :md-label='$t(`boq.boq_top`)'
                    md-sort-by='boq_top'>
                  {{ item.boq_top }}
                </md-table-cell>
                <md-table-cell
                    :md-label='$t(`boq.boq_id`)'
                    md-sort-by='boq_id'>
                  {{ item.boq_id }}
                </md-table-cell>
                <md-table-cell
                    :md-label='$t(`boq.boq_description`)'
                    md-sort-by='boq_description'>
                  {{ item.boq_description }}
                </md-table-cell>

                <md-table-cell
                    :md-label='$t(`label.unit`)'
                    md-sort-by='unit'>
                  {{ item.unit }}
                </md-table-cell>

                <md-table-cell
                    :md-label='$t(`label.comments`)'
                    md-sort-by='comments'>
                  {{ item.comments }}
                </md-table-cell>

                <md-table-cell
                    :md-label="$t('tables.actions')"
                    v-if="hasAccess(feature, 'update')"
                >
                  <div class='cell-actions'>
                    <md-button
                        class='md-raised md-sm md-primary'
                        @click.stop.prevent='onEdit(item)'
                    >
                      {{ $t('button.edit') }}
                    </md-button>
                  </div>
                </md-table-cell>
              </md-table-row>
            </md-table>
          </md-card-content>
          <md-card-actions md-alignment='space-between'>
            <div class>
              <p class='card-category'>
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
                v-model='pagination.currentPage'
                :per-page='pagination.perPage'
                :total='total'
                class='pagination-no-border pagination-success'
            ></pagination>
          </md-card-actions>
        </md-card>
      </div>
    </div>
    <md-dialog :md-active.sync='showProfileForm'>
      <md-dialog-content>
        {{
          $t(`lot.${profileFormAct === actAdd ? 'add' : 'edit'}_bill_of_quantities`)
        }}
        <md-field>
          <label>{{ $t("lot.boq_top") }}</label>
          <md-select v-model="editBill.boq_top">
            <md-option v-for="top in billTops" :value="top.id" :key="top.id">{{ top.id }} / {{ $t(top.name) }}</md-option>
          </md-select>
        </md-field>

        <md-field>
          <label>{{ $t("lot.boq_group") }}</label>
          <md-select v-model="editBill.boq_group">
            <md-option v-for="group in billSubGroupsByTop" :value="group.id" :key="group.id">{{ $t(group.name) }}</md-option>
          </md-select>
        </md-field>
        <md-field>
          <label>{{ $t('label.boq_id') }}</label>
          <md-input v-model='editBill.boq_id'></md-input>
        </md-field>
        <md-field>
          <label>{{ $t("lot.unit") }}</label>
          <md-select v-model="editBill.unit">
            <md-option v-for="unit in units" :value="unit.id" :key="unit.id">{{ $t(unit.name) }}</md-option>
          </md-select>
        </md-field>
        <md-field>
          <label>{{ $t('label.description') }}</label>
          <md-input v-model='editBill.boq_description'></md-input>
        </md-field>
        <md-field>
          <label>{{ $t('label.comments') }}</label>
          <md-input v-model='editBill.comments'></md-input>
        </md-field>
      </md-dialog-content>
      <md-dialog-actions>
        <md-button :disabled='false' class='md-success' @click='actBill'>{{ $t('button.apply') }}</md-button>
        <md-button class='md-simple' @click='showProfileForm = false'>{{ $t('button.close') }}</md-button>
      </md-dialog-actions>
    </md-dialog>
  </div>
</template>
<script>
import {mapState} from 'vuex'
import {Pagination} from '@/components'
import {permMixin} from "@/mixins/permission"
import Swal from "sweetalert2";

export default {
  name: 'bill-of-quantities',
  mixins: [permMixin],
  data() {
    return {
      feature: 'bill-of-quantities',
      isDataLoading: true,
      dataList: [],
      currentSort: 'id',
      currentSortOrder: 'desc',
      pagination: {
        perPage: 10,
        currentPage: 1,
        perPageOptions: [5, 10, 25, 50, 'all'],
        total: 0
      },
      billTops: [],
      billSubGroups: [],
      units: [],
      searchQuery: '',
      propsToSearch: ['key'],
      searchedData: [],
      fuseSearch: null,
      showProfileForm: false,
      profileFormAct: undefined,
      actAdd: "add",
      actUpd: "upd",
      editBill: {
        boq_top: undefined,
        boq_group: undefined,
        boq_id: "",
        boq_description: "",
        unit: "",
        comments: ""
      }
    }
  },
  components: {
    Pagination
  },
  async created() {
    this.isDataLoading = true
    try {
      this.dataList = await this.$store.dispatch('LOAD_BILLS_OF_QUANTITIES')
    } finally {
      this.isDataLoading = false
    }
  },

  computed: {
    ...mapState({}),
    billSubGroupsByTop() {
      const top = this.editBill.boq_top
      if (top && top > 0) {
        return this.billSubGroups.filter(group => {
          return group.top === top
        })
      }
    },
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
    },
    NextDataId() {
      const maxId = this.dataList.reduce((accum, curr) => {
        return accum > curr.id ? accum : curr.id
      }, 0)
      return maxId + 1
    }
  },
  methods: {
    async actBill() {
      const actName = this.profileFormAct === this.actAdd ? "added" : "updated"
      let alert = {
        type: 'success',
        text: this.$t(`lot.boq_item_was_${actName}`),
        footer: ''
      }
      const {id, ...data} = this.editBill
      try {
        if (this.profileFormAct === this.actAdd) {
          await this.$store.dispatch("ADD_BOQ_ITEM", {data})
          this.dataList.push({id: this.NextDataId, ...data})
          this.showProfileForm = false
        } else if (this.profileFormAct === this.actUpd) {
          await this.$store.dispatch("UPD_BOQ_ITEM", {id, data})
          const ind = this.dataList.findIndex(item => item.id === id)
          this.$set(this.dataList, ind, {...data})
          alert.text = this.$t(`lot.boq_item_was_updated`)
          this.showProfileForm = false
        } else {
          return
        }
      } catch (err) {
        alert.type = "error"
        alert.text = this.$t(`lot.boq_item_was_not_${actName}`)
        alert.footer = err.message ? err.message : err
      } finally {
        Swal.fire(alert)
      }

    },
    onAdd() {
      this.editBill = {
        boq_top: undefined,
        boq_group: undefined,
        boq_id: "",
        boq_description: "",
        unit: "",
        comments: ""
      }
      this.profileFormAct = this.actAdd
      this.downloadReferences()
      this.showProfileForm = true
    },
    onEdit(item) {
      this.profileFormAct = this.actUpd
      this.downloadReferences()
      const {boq_description, boq_id, boq_top, comments, unit, id} = item
      this.editBill = {...this.editBill, boq_description, boq_id, boq_top, comments, unit, id}
      this.showProfileForm = true
    },
    downloadReferences() {
      this.$store.dispatch("LOAD_BOQ_TOPS").then(list => {
        this.billTops = [...list]
      })
      this.$store.dispatch("LOAD_UNITS").then(list => {
        this.units = [...list]
      })
      this.$store.dispatch("LOAD_BOQ_SUBGROUPS").then(list => {
        this.billSubGroups = [...list]
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
          return Object.keys(row).reduce((incl, elem) => incl || regex.test(row[elem]), false)
        })

      } //this.fuseSearch.search(this.searchQuery)
      this.searchedData = result
    },
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

.fade-enter, .fade-leave-to /* .fade-leave-active до версии 2.1.8 */
{
  opacity: 0;
}
</style>
