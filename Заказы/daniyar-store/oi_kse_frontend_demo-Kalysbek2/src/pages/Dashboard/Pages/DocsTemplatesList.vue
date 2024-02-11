<template>
  <div class="md-layout">
    <div class="md-layout-item">
      <md-card>
        <md-card-header class="md-card-header-icon md-card-header-blue">
          <div class="card-icon">
            <md-icon>note_add</md-icon>
          </div>
          <h4 class="title">Документы</h4>
        </md-card-header>
        <md-card-content>
          <md-table class="paginated-table table-striped table-hover">
            <md-table-row slot="md-table-row">
              <md-table-cell md-label="Название документа">
                <h4>Отчеты</h4>
              </md-table-cell>
              <md-table-cell md-label="Название документа"></md-table-cell>
            </md-table-row>
            <md-table-row
              v-for="item in getReportList"
              :key="item.id"
              slot="md-table-row"
            >
              <md-table-cell md-label="Название документа" md-sort-by="title">
                {{ item.title }}
              </md-table-cell>

              <md-table-cell>
                <md-button
                  class="md-primary custom-select-button"
                  @click.native="selectDocTypeHandler(item.name)"
                >
                  Выбрать
                </md-button>
              </md-table-cell>
            </md-table-row>
            <md-table-row slot="md-table-row">
              <md-table-cell md-label="Название документа">
                <h4>Существенные факты</h4>
              </md-table-cell>
              <md-table-cell md-label="Название документа"></md-table-cell>
            </md-table-row>
            <md-table-row
              v-for="item in getFactList"
              :key="item.id"
              slot="md-table-row"
            >
              <md-table-cell md-label="Название документа" md-sort-by="title">
                {{ item.title }}
              </md-table-cell>

              <md-table-cell>
                <md-button
                  class="md-primary custom-select-button"
                  @click.native="selectDocTypeHandler(item.name)"
                >
                  Выбрать
                </md-button>
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
                    <div class="md-table-head-container md-ripple md-disabled">
                      <div class="md-table-head-label">
                        {{ item }}
                      </div>
                    </div>
                  </th>
                </tr>
              </tfoot>
            </table>
          </div>
        </md-card-content>
      </md-card>
    </div>
  </div>
</template>

<script>
import Fuse from 'fuse.js'
import { mapActions, mapGetters } from 'vuex'
export default {
  computed: {
    ...mapGetters('documents', ['getDocList', 'getFactList', 'getReportList']),
    /***
     * Returns a page from the searched data or the whole data. Search is performed in the watch section below
     */
  },
  data() {
    return {
      currentSort: 'title',
      currentSortOrder: 'asc',
      footerTable: ['Название документа', ''],
      searchQuery: '',
      propsToSearch: ['title'],
      tableData: [],
      searchedData: [],
      fuseSearch: null
    }
  },
  methods: {
    ...mapActions('documents', ['GET_DOC_LIST']),
    selectDocTypeHandler(name) {
      const path =
        name == 'uploadfile'
          ? '/' + this.$i18n.locale + `/dashboard/${name}`
          : '/' + this.$i18n.locale + `/dashboard/template/${name}/new`
      this.$router.push({path})
    }
  },
  async mounted() {
    await this.GET_DOC_LIST()
  }
}
</script>

<style lang="css" scoped>
.md-card .md-card-actions {
  border: 0;
  margin-left: 20px;
  margin-right: 20px;
}
.custom-select-button {
  width: 5rem;
  height: 2rem;
}
</style>
