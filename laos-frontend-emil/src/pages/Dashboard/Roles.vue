<template>
  <div>
    <div class='md-layout'>
      <div class='md-layout-item'>
        <div class='btn-row'>
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
            <h4 class='title'>{{ $t('label.roles') }}</h4>
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
                    :md-label='$t(`role.name`)'
                    md-sort-by='role_name'>
                  {{ item.role_name }}
                </md-table-cell>

                <md-table-cell
                    :md-label='$t(`role.type`)'
                    md-sort-by='role_type'>
                  {{ item.role_type }}
                </md-table-cell>

                <md-table-cell
                    :md-label='$t(`role.description`)'>
                  {{ item.description }}
                </md-table-cell>

                <md-table-cell
                    :md-label="$t('tables.actions')"
                    class='btn-cont'
                >
                  <div class='cell-actions'>
                    <md-button
                        class='md-raised md-sm md-primary'
                        @click.stop.prevent='onShowUsers(item.role_name)'
                    >
                      {{ $t('button.users') }}
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
    <md-dialog :md-active.sync='showUsers'>
      <md-dialog-content>
        <template v-if='roleUsers.length===0'>
          <p>{{ $t('role.no_users') }}</p>
        </template>
        <md-list class='md-triple-line'>
          <md-list-item v-for='user in roleUsers' :key='user.login'>
            <md-avatar>
              <img alt='People' src='/img/default-avatar.png'>
            </md-avatar>
            <div class='md-list-item-text'>
              <span class='user-login' @click='onGoUserProps(user.login)'>{{ user.login }}</span>
              <span>{{ user.email }}</span>
              <p>{{ user.first_name }} {{ user.last_name }}</p>
            </div>
          </md-list-item>
        </md-list>
      </md-dialog-content>
      <md-dialog-actions>
        <md-button class='md-primary' @click='showUsers = false'>{{ $t('button.close') }}</md-button>
      </md-dialog-actions>
    </md-dialog>
  </div>

</template>
<script>
import {mapState} from 'vuex'
import {Pagination} from '@/components'

export default {
  name: 'Roles',
  data() {
    return {
      roleUsers: [],
      isDataLoading: true,
      dataList: [],
      currentSort: 'role_name',
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
      fuseSearch: null,
      showUsers: false
    }
  },
  components: {
    Pagination
  },
  async created() {
    this.isDataLoading = true
    try {
      this.dataList = await this.$store.dispatch('LOAD_ROLES')

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
    onGoUserProps(login) {
      this.$router.push({name: 'user-upd', params: {login: login}})
    },

    async onShowUsers(role_name) {
      try {
        this.roleUsers = await this.$store.dispatch('LOAD_ROLE_USERS', role_name)
        this.showUsers = true
      } catch (err) {
        console.log(err)
      }

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
      }
      this.searchedData = result
    }
    // bridges_headers() {
    // }
  }
}
</script>

<style lang='scss'>
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

.user-login {
  cursor: pointer;
  color: #0d47a1;
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
