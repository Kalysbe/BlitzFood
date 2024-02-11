<template>
    <div class="md-layout">
      <div class="md-layout-item">
        <md-card>
          <md-card-header class="md-card-header-icon md-card-header-blue">
            <div class="card-icon">
              <md-icon>manage_accounts</md-icon>
            </div>
            <h4 class="title">Категории</h4>
          </md-card-header>
          <md-card-content>
            <md-table
             v-model="data"
              class="paginated-table table-striped table-hover"
            >
              <md-table-toolbar class="md-layout">
                <md-field>
            
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
                <md-table-cell md-sort-by="login">
                  {{ item.value }}
                </md-table-cell>
             
  
                <md-table-cell>
                  <md-button
                    class="md-icon-button md-dense md-raised md-danger"
                    @click="deleteCategory(item.id)">
                    <md-icon>delete</md-icon>
                    <md-tooltip md-direction="left">Удалить категорию</md-tooltip>
                  </md-button>
                </md-table-cell>
              </md-table-row>
            </md-table>
          </md-card-content>
        </md-card>
      </div>
     
      
  
  
  
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
        data:[]
      }
    },
    computed: {
      ...mapGetters('category', ['getCategory']),
    },
    methods: {
      ...mapActions('category', ['addCategory','GET_CATEGORY','DELETE_CATEGORY']),
    
      addCompanyHandler() {
        Swal.fire({
          title: 'Добавить новую категорию',
          showCancelButton: true,
          confirmButtonClass: 'md-button md-success',
          cancelButtonClass: 'md-button md-danger',
          cancelButtonText: 'Закрыть',
          confirmButtonText: 'Добавить',
          buttonsStyling: false,
          html: `<div class="md-field md-theme-default"> 
                    <input type="text" placeholder="Категория" required id="md-input-1" class="md-input">
                </div>
                `,
          preConfirm: () => {
            return [document.getElementById('md-input-1').value]
          }
        }).then((result) => {
          if(result.dismiss == 'cancel') return
          if(result.value && result.value[0].trim() == ''){
            Swal.fire({
                  title: `Заполните все поля!`,
                  type: 'warning',
                  buttonsStyling: false,
                  confirmButtonClass: 'md-button md-success'
            })
            return
          }    
          this.addCategory(
            {
              value: result.value[0],
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
      },
      deleteCategory(id) {
        this.DELETE_CATEGORY(id)
      }
    },
   
    async mounted() {
      if (this.getCategory.length == 0) {
        this.data = await this.GET_CATEGORY()
           
      } else {
            console.log('error')
      }
      //this.page = +this.$route.query.page ? +this.$route.query.page : 1
      
      
      //if (search && search != '') this.searchCompany(search)
    },

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
  