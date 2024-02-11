<template>
  <div>
    <div class="md-layout">
      <div class="md-layout-item">
        <div class="btn-row">
          <md-button class="md-success" @click="translateProfile">
            {{ $t('button.add') }}
          </md-button>
        </div>
        <md-card>
          <md-card-header class="md-card-header-icon md-card-header-green">
            <div class="card-icon">
              <md-icon>translate</md-icon>
            </div>
            <h4 class="title">{{ $t('label.translate_list') }}</h4>
            <md-field class="category-select">
              <label for="category">{{ $t('label.categories') }}</label>
              <md-select
                v-model="selected_category"
                name="category"
                id="category"
                @md-selected="onCategoryChange"
              >
                <md-option
                  v-for="category in categories"
                  :key="category.id"
                  :value="category.id"
                >
                  {{ category.name }}
                </md-option>
              </md-select>
            </md-field>
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
                    :placeholder="$t('label.search_records')"
                    v-model="searchQuery"
                  ></md-input>
                </md-field>
              </md-table-toolbar>

              <md-table-row slot="md-table-row" slot-scope="{item}">
                <md-table-cell
                  :md-label="$t('translate.category')"
                  md-sort-by="category"
                >
                  {{ item.category }}
                </md-table-cell>
                <md-table-cell :md-label="$t('translate.key')" md-sort-by="key">
                  <span>{{ item.key }}</span>
                </md-table-cell>
                <md-table-cell
                  v-for="lang_item in localesCodes"
                  :key="lang_item"
                  :md-label="$t(`translate.${lang_item}`)"
                  :md-sort-by="`${lang_item}`"
                >
                  <span v-if="!isSelectedRow(item)">{{ item[lang_item] }}</span>
                  <div
                    v-else
                    class="md-layout-item md-small-size-100 md-size-50"
                  >
                    <md-field
                      :class="[
                        {
                          'md-valid':
                            !errors.has(`${lang_item}`) && touched[lang_item]
                        },
                        {'md-error': errors.has(`${lang_item}`)}
                      ]"
                    >
                      <md-input
                        v-model="edit[lang_item]"
                        type="text"
                        :data-vv-name="edit[lang_item]"
                        required
                        :v-validate="modelValidations[edit[lang_item]]"
                      ></md-input>
                      <slide-y-down-transition>
                        <md-icon class="error" v-show="errors.has(lang_item)">
                          close
                        </md-icon>
                      </slide-y-down-transition>
                      <slide-y-down-transition>
                        <md-icon
                          class="success"
                          v-show="!errors.has(lang_item) && touched[lang_item]"
                        >
                          done
                        </md-icon>
                      </slide-y-down-transition>
                    </md-field>
                  </div>
                </md-table-cell>

                <md-table-cell
                  class="btn-cont"
                  :md-label="$t('tables.actions')"
                >
                  <div class="cell-actions">
                    <template v-if="!isSelectedRow(item)">
                      <md-button
                        class="md-raised md-sm md-primary"
                        @click.stop.prevent="onEditRow(item)"
                      >
                        {{ $t('button.edit') }}
                      </md-button>
                    </template>
                    <template v-else>
                      <md-button
                        class="md-success md-raised md-sm"
                        @click.stop.prevent="onSave(item)"
                      >
                        {{ $t('button.save') }}
                      </md-button>
                      <md-button
                        class="md-default md-raised md-sm"
                        @click.stop.prevent="onCancel()"
                      >
                        {{ $t('button.cancel') }}
                      </md-button>
                    </template>
                  </div>
                </md-table-cell>
              </md-table-row>
            </md-table>
            <div class="footer-table md-table">
              <table>
                <tfoot>
                  <tr>
                    <th
                      v-for="item in footerTable"
                      :key="item.name"
                      class="md-table-head"
                    >
                      <div
                        class="md-table-head-container md-ripple md-disabled"
                      >
                        <div class="md-table-head-label">{{ item }}</div>
                      </div>
                    </th>
                  </tr>
                </tfoot>
              </table>
            </div>
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
import {mapState} from 'vuex'
import {Pagination} from '@/components'
import {SlideYDownTransition} from 'vue2-transitions'
import Fuse from 'fuse.js'

export default {
  data() {
    return {
      selected_category: null,
      edit_row: {category: null, key: null},
      edit: {},
      currentSort: 'key',
      currentSortOrder: 'asc',
      pagination: {
        perPage: 5,
        currentPage: 1,
        perPageOptions: [5, 10, 25, 50],
        total: 0
      },
      footerTable: [],
      searchQuery: '',
      propsToSearch: ['key'],
      searchedData: [],
      fuseSearch: null,
      categories: [],
      touched: {},
      modelValidations: {}
    }
  },
  components: {
    Pagination,
    SlideYDownTransition
  },
  created() {
    this.$store.dispatch('LOAD_TRANSLATION_LIST').then(() => {
      const cat_obj = {}
      this.tableData.forEach((item) => {
        if (!cat_obj[item.category]) {
          cat_obj[item.category] = true
        }
      })

      this.categories = Object.keys(cat_obj)
        .map((item) => {
          return {id: item, name: item}
        })
        .sort(function(a, b) {
          return a.id.localeCompare(b.id)
        })

      this.locales.forEach((locale) => {
        this.edit[locale.code] = ''
        this.touched[locale.code] = false
        this.modelValidations[locale.code] = {
          required: true,
          min: 3
        }
      })

      // Fuse search initialization.
      this.fuseSearch = new Fuse(this.tableData, {
        keys: ['key', 'category', ...this.locales.map((locale) => locale.code)],
        threshold: 0.3
      })
    })
  },
  computed: {
    ...mapState({
      tr_list: (state) => state.i18nStore.tr_list,
      locales: (state) => state.i18nStore.locales,
      localeActive: (state) => state.i18nStore.active
    }),
    localesCodes() {
      return this.locales.map((locale) => locale.code)
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
      return this.selected_category
        ? this.tr_list.filter((item) => {
            return item.category === this.selected_category
          })
        : this.tr_list
    }
  },
  methods: {
    translateProfile() {
      this.$router.push('localisation_add')
    },
    isSelectedRow(item) {
      if (!this.edit_row) {
        return false
      }
      return (
        item.category === this.edit_row.category &&
        item.key === this.edit_row.key &&
        item.id === this.edit_row.id
      )
    },
    onCategoryChange() {},
    onEditRow(item) {
      const {category, key, id, ...langs} = item
      this.edit = {...langs}
      this.edit_row = {category, key, id}
    },
    customSort(value) {
      return value.sort((a, b) => {
        const sortBy = this.currentSort
        if (this.currentSortOrder === 'asc') {
          return a[sortBy]
            .toString()
            .localeCompare(b[sortBy].toString(), undefined, {numeric: true})
        }
        return b[sortBy]
          .toString()
          .localeCompare(a[sortBy].toString(), undefined, {numeric: true})
      })
    },
    onSave() {
      const {key, category} = this.edit_row
      this.$store
        .dispatch('UPD_TRANSLATE_ENTRY', {
          ...this.edit_row,
          item: {...this.edit, key, category}
        })
        .then(() => {
          this.edit_row = {category: null, key: null}
        })
    },
    onCancel() {
      this.edit_row = {category: null, key: null}
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
      if (value !== '') {
        result = this.fuseSearch.search(this.searchQuery)
      }
      this.searchedData = result
    }
  }
}
</script>

<style lang="scss" scoped>
.md-table .md-table-head {
  text-align: center;
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
.md-table-cell-container .md-button {
  //margin-left: 20px;
}
</style>
