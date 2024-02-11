<template>
    <div class="md-layout">
      <div class="md-layout-item">
        <md-card>
          <md-card-header class="md-card-header-icon md-card-header-blue">
            <div class="card-icon">
              <md-icon>manage_accounts</md-icon>
            </div>
            <h4 class="title">Пользователи</h4>
          </md-card-header>
          <md-card-content>
            <md-table
              :value="queriedData"
              :md-sort.sync="currentSort"
              :md-sort-order.sync="currentSortOrder"
              class="paginated-table table-striped table-hover"
            >
              <md-table-toolbar class="md-layout">
                <md-field>
                  <label for="pages">Данные на странице</label>
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
  
                <md-field md-clearable>
                  <md-input
                    type="search"
                    class="mb-3"
                    clearable
                    placeholder="Поиск"
                    v-model="searchQuery"
                  ></md-input>
                </md-field>
                <md-field >
                  <md-button 
                    class="md-success"
                    @click="addCompanyHandler()"
                    >
                    <md-icon>person_add_alt_1</md-icon>
                  </md-button>
                
                </md-field>
              </md-table-toolbar>
  
              <md-table-row slot="md-table-row" slot-scope="{item}">
                <md-table-cell md-label="Логин" md-sort-by="login">
                  {{ item.login }}
                </md-table-cell>
                <md-table-cell md-label="Компания">
                  {{ item.name }}
                </md-table-cell>
  
                <md-table-cell>
                  <md-button
                    class="md-icon-button md-dense md-raised md-success"
                    @click="getConfirm(item.id)"
                  >
                    <md-icon>restart_alt</md-icon>
                    <md-tooltip md-direction="left">Сбросить пароль</md-tooltip>
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
          </md-card-content>
        </md-card>
      </div>
      <md-snackbar
        md-position="center"
        :md-active="getShowSnackbar"
        md-persistent
      >
        <span>Пароль пользователя изменен на 123</span>
      </md-snackbar>
  
      <md-dialog :md-active.sync="active">
        <md-dialog-title>Вы уверены что хотите сбросить пароль ?</md-dialog-title>
        <md-dialog-actions>
          <md-button class="md-danger" @click="active = false">Нет</md-button>
          <md-button class="md-primary" @click="getUserId">Да</md-button>
        </md-dialog-actions>
      </md-dialog>
      
  
  
  
      <!-- <md-button class="md-primary md-raised" @click="showDialog = true">Show Dialog</md-button>
  
      <md-dialog-confirm
        :md-active.sync="active"
        md-title="Вы уверены что хотите сбросить пароль ?"
        
        md-confirm-text="Да"
        md-cancel-text="Нет"
        @md-cancel="active = false"
        @md-confirm="getUserId"
      /> -->
    </div>
  </template>
  
  <script>
  import {mapGetters, mapActions} from 'vuex'
  import Buttons from '../Components/Buttons.vue'
  import {Pagination} from '@/components'
  import Fuse from 'fuse.js'
  import Swal from 'sweetalert2'
  
  export default {
    components: {Buttons, Pagination},
  
    data() {
      return {
        currentSort: 'title',
        currentSortOrder: 'asc',
        pagination: {
          perPage: 25,
          currentPage: 1,
          perPageOptions: [5, 10, 25, 50],
          total: 0
        },
        footerTable: ['Название документа', ''],
        searchQuery: '',
        propsToSearch: ['title'],
        tableData: [],
        searchedData: [],
        fuseSearch: null,
        active: false,
        value: null,
        selectedId: null,
        login: '',
        companyName: '',
        code: ''
      }
    },
    methods: {
      ...mapActions('clothes', ['addClothes']),
      getUser() {
        this.getUserList(this.login)
      },
      async updateUserList(){
        await this.getUserList()
        this.tableData = this.getAllUsersList
        this.fuseSearch = new Fuse(this.tableData, {
          keys: ['login', 'name'],
          threshold: 0.3
        })
      },
      getUserId() {
        this.active = false
        this.resetUser(this.selectedId)
      },
      getConfirm(id) {
        this.active = true
        this.selectedId = id
      },
      addCompanyHandler() {
        Swal.fire({
          title: 'Добавить новый товар',
          // text: `Добавить новую компанию`,
          // type: 'warning',
          showCancelButton: true,
          confirmButtonClass: 'md-button md-success',
          cancelButtonClass: 'md-button md-danger',
          cancelButtonText: 'Закрыть',
          confirmButtonText: 'Добавить',
          buttonsStyling: false,
          html: `<div class="md-field md-theme-default"> 
                    <input type="text" placeholder="Категория" required id="md-input-1" class="md-input">
                </div>
                <div class="md-field md-theme-default"> 
                    <input type="text" maxlength="8" placeholder="Под категория" required id="md-input-2" class="md-input">
                </div>
                <div class="md-field md-theme-default"> 
                    <input type="text" placeholder="Цена товара" required id="md-input-3" class="md-input">
                </div>
                `,
          preConfirm: () => {
            return [document.getElementById('md-input-1').value, document.getElementById('md-input-2').value, document.getElementById('md-input-3').value]
          }
        }).then((result) => {
          if(result.dismiss == 'cancel') return
          if(result.value && result.value[0].trim() == '' || result.value[1].trim() == ''||result.value[2].trim() == ''){
            Swal.fire({
                  title: `Заполните все поля!`,
                  type: 'warning',
                  buttonsStyling: false,
                  confirmButtonClass: 'md-button md-success'
            })
            return
          }    
          this.addClothes(
            {
              type: result.value[0],
              name: result.value[1],
              price: result.value[2]
            }
          )
          .then((res) => {
                if(res.status === 200){
                  Swal.fire({
                  title: `Компания успешна добавлена!`,
                  type: 'success',
                  buttonsStyling: false,
                  confirmButtonClass: 'md-button md-success'
                  })
                  this.updateUserList()
                  return
                }
                Swal.fire({
                  title: `Ошибка при добавлении`,
                  type: 'error',
                  buttonsStyling: false,
                  confirmButtonClass: 'md-button md-error'
                  })
                
              })
        })
      }
    },
    computed: {
      ...mapGetters('manage_accounts', ['getAllUsersList', 'getShowSnackbar']),
  
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
    async mounted() {
      await this.getUserList()
      this.tableData = this.getAllUsersList
      this.fuseSearch = new Fuse(this.tableData, {
        keys: ['login', 'name'],
        threshold: 0.3
      })
    },
    watch: {
     
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
    width: 5rem;
    height: 2rem;
  }
  </style>
  