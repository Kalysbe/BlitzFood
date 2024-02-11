<template>
  <div>
    <div class="md-layout">
      <div class="md-layout-item">
        <md-card>
          <md-card-header class="md-card-header-icon md-card-header-blue">
            <div class="card-icon">
              <md-icon>delete</md-icon>
            </div>
            <h4 class="title">Корзина</h4>
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
                  <label for="pages">Документов на странице</label>
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
                    placeholder="Поиск по названию"
                    v-model="searchQuery"
                  ></md-input>
                </md-field>
              </md-table-toolbar>

              <md-table-row slot="md-table-row" slot-scope="{item}">
                <md-table-cell md-label="Наименование компании">
                  {{ item.name }}
                </md-table-cell>
                <md-table-cell md-label="Статус документа">
                  {{ getStatus(item.status) }}
                </md-table-cell>
                <md-table-cell md-label="Дата отправки / принятия ">
                  {{ getDate(item.datesend) }} / {{ getDate(item.confirmdate) }}
                </md-table-cell>
                <md-table-cell md-label="Тип документа">
                  {{ item.typedoc }}
                </md-table-cell>
                <md-table-cell md-label="Квартал">{{
                  item.kvartal
                }}</md-table-cell>

                <md-table-cell v-if="isAdmin">
                  <div class="md-group">
                    <md-button
                      @click.native="deleteHandler(item.id)"
                      class="md-just-icon md-simple md-danger"
                    >
                      <span class="material-icons">delete</span>
                    </md-button>
                    <md-button
                      class="md-just-icon md-simple md-success"
                      @click.native="restoreHandler(item.id)"
                    >
                      <span class="material-icons">restore_page</span>
                    </md-button>
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
          <md-card-actions md-alignment="space-between">
            <div class="">
              <p class="card-category">
                Показано с {{ from + 1 }} по {{ to }} из {{ total }} документов
              </p>
            </div>
            <pagination
              class="pagination-no-border pagination-primary"
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
import Fuse from 'fuse.js'
import Swal from 'sweetalert2'
import { mapActions } from 'vuex'

export default {
  async created() {
    if (localStorage.getItem('user') === 'user') {
      this.isUser = true
    } else if (localStorage.getItem('user') === 'admin') {
      this.isAdmin = true
    }
  },
  components: {
    Pagination
  },
  computed: {
    /***
     * Returns a page from the searched data or the whole data. Search is performed in the watch section below
     */
    queriedData() {
      let result = this.tableData
      if (this.searchedData.length > 0) {
        result = this.searchedData
      }
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
      return this.searchedData.length > 0
        ? this.searchedData.length
        : this.tableData.length
    }
  },
  data() {
    return {
      isUser: false,
      isAdmin: false,
      currentSort: 'title',
      currentSortOrder: 'desc',
      pagination: {
        perPage: 10,
        currentPage: 1,
        perPageOptions: [5, 10, 25, 50],
        total: 0
      },
      footerTable: [
        // 'Наименование компании',
        // 'Статус документа',
        // 'Дата регистрации',
        // 'Тип документа',
        // ''
      ],
      searchQuery: '',
      propsToSearch: ['typedoc', 'name'],
      tableData: [],
      searchedData: [],
      fuseSearch: null
    }
  },

  methods: {
    ...mapActions('report', ['DELETE_REPORT_FROM_CART', 'MOVE_TO_CART_REPORT', 'GET_CART_LIST', 'RESTORE_REPORT_FROM_CART', 'GET_CART_LIST']),
    pushToPrintView(id) {
      this.$router.push({path: '/' + this.$i18n.locale + '/printview/' + id})
    },
    editHandler(id) {
      this.$router.push({path: '/' + this.$i18n.locale + '/template/' + id + '/' + 'edit'})
      //console.log(item)
    },
    deleteHandler(id) {
      Swal.fire({
        title: '',
        text: `Вы уверены, что хотите удалить? После удаления невозможно будет восстановить документ!`,
        type: 'warning',
        showCancelButton: true,
        confirmButtonClass: 'md-button md-success',
        cancelButtonClass: 'md-button md-danger',
        cancelButtonText: 'Закрыть',
        confirmButtonText: 'Да, удалить!',
        buttonsStyling: false
      }).then((result) => {
        if (result.value) {
          if (this.DELETE_REPORT_FROM_CART(id)) {
            let index = this.tableData.findIndex((el) => el.id === id)
            this.tableData.splice(index, 1)
            Swal.fire({
              title: 'Удален!',
              text: 'Ваш документ был  успешно удален!',
              type: 'success',
              confirmButtonClass: 'md-button md-success',
              buttonsStyling: false
            })
          }
        }
      })
    },

    customSort(value) {
      return value.sort((a, b) => {
        const sortBy = this.currentSort
        if (this.currentSortOrder === 'asc') {
          return a[sortBy].localeCompare(b[sortBy])
        }
        return b[sortBy].localeCompare(a[sortBy])
      })
    },
    getDate(date) {
      // Форматирование даты в формат d.m.Y
      if (date != undefined) {
        var options = {
          day: 'numeric',
          month: 'numeric',
          year: 'numeric'
        }
        let newDate = new Date(date)
        return newDate.toLocaleString('ru', options)
      }
    },
    getStatus(status) {
      switch (status) {
        case 1:
          return 'Готов к отправке'

        case 2:
          return 'Отправлен'

        case 3:
          return 'Принят'

        case 4:
          return 'Отклонен'
      }
    },
    restoreHandler(id) {
      Swal.fire({
        title: '',
        text: `Вы действительно хотите восстановить документ?`,
        type: 'warning',
        showCancelButton: true,
        confirmButtonClass: 'md-button md-success',
        cancelButtonClass: 'md-button md-danger',
        cancelButtonText: 'Закрыть',
        confirmButtonText: 'Да, восстановить!',
        buttonsStyling: false
      }).then((result) => {
        if (result.value) {
          if (this.RESTORE_REPORT_FROM_CART(id)) {
            Swal.fire({
              title: 'Восстановлен!',
              text: 'Ваш документ успешно восстановлен!',
              type: 'success',
              confirmButtonClass: 'md-button md-success',
              buttonsStyling: false
            }).then(() => {
              this.GET_CART_LIST().then((response) => {
                this.tableData = response
              })
            })
          }
        }
      })
    },

    toCartHandler(id) {
      Swal.fire({
        title: '',
        text: `Вы уверены, что хотите переместить документ в корзину?`,
        type: 'warning',
        showCancelButton: true,
        confirmButtonClass: 'md-button md-success',
        cancelButtonClass: 'md-button md-danger',
        cancelButtonText: 'Закрыть',
        confirmButtonText: 'Да, переместить!',
        buttonsStyling: false
      }).then((result) => {
        if (result.value) {
          if (this.MOVE_TO_CART_REPORT(id)) {
            let index = this.tableData.findIndex((el) => el.id === id)
            this.tableData.splice(index, 1)
            Swal.fire({
              title: 'Перемещен!',
              text: '',
              type: 'success',
              confirmButtonClass: 'md-button md-success',
              buttonsStyling: false
            })
          }
        }
      })
    }
  },
  async mounted() {
    this.tableData = await this.GET_CART_LIST()
    this.fuseSearch = new Fuse(this.tableData, {
      keys: ['typedoc', 'name'],
      threshold: 0.3
    })
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

<style lang="css" scoped>
.md-card .md-card-actions {
  border: 0;
  margin-left: 20px;
  margin-right: 20px;
}
.custom-select-button {
  height: 2rem;
}
.custom-md-group {
  width: 10rem;
}
.custom-edit-button {
  text-align: center;
  width: 7rem;
  height: 2rem;
  font-size: 0.6rem;
}
</style>
