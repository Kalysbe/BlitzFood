<template>
  <div>
    <div class="md-layout">
      <div class="md-layout-item">
        <md-card>
          <md-card-header class="md-card-header-icon md-card-header-blue">
            <div class="card-icon">
              <md-icon>assignment</md-icon>
            </div>
            <h4 class="title">Отчеты</h4>
          </md-card-header>
          <md-card-content>

            <pagination class="pagination-no-border pagination-primary top-pagination" v-model="pagination.currentPage"
              :per-page="pagination.perPage" :total="getReportsCount"></pagination>
            <div class="load"></div>
            <md-table class="paginated-table table-hover">

              <md-table-toolbar>


                <md-field v-if="isAdmin">
                  <md-input type="search" class="mb-3" clearable style="width: 200px" placeholder="Поиск по названию"
                    v-model="searchQuery" v-on:keyup.enter="search()"></md-input>
                </md-field>
              </md-table-toolbar>

              <md-table-row>
                <md-table-head>Наименование компании</md-table-head>
                <md-table-head>Статус</md-table-head>
                <md-table-head>Дата отправки / принятия</md-table-head>
                <md-table-head>Тип документа</md-table-head>
                <md-table-head>Cсылка</md-table-head>
                <md-table-head>Подпись</md-table-head>
                <md-table-head></md-table-head>
                <md-table-head></md-table-head>
              </md-table-row>
              <md-table-row
                v-for="(item, key) in getReportList.list"
                :key="key"
                style="width=500px"
                slot="md-table-row"
              >
                <md-table-cell md-label="Наименование компании">
                  {{ item.name }}
                </md-table-cell>
                <md-table-cell md-label="Статус">
                  {{ getStatus(item.status) }}
                </md-table-cell>
                <md-table-cell md-label="Дата отправки / принятия ">
                  {{ getDate(item.datesend) }} / {{ getDate(item.confirmdate) }}
                </md-table-cell>
                <!-- <md-table-cell md-label="Дата принятия">
                  {{ getDate(item.confirmdate) }}
                </md-table-cell> -->
                <md-table-cell md-label="Тип документа">
                  <a class="clip" v-on:click="pushToPrintView(item.id)" :title="item.typedoc">
                    <template v-if="item.typedoc == 'Создать отчет'">
                      Отчет листинговых компаний
                    </template>
                    <template v-else>
                      {{ item.typedoc }}
                    </template>
                  </a>
                </md-table-cell>
                <!-- <md-table-cell md-label="Период">
                  {{ item.kvartal }}
                </md-table-cell> -->
                <md-table-cell md-label="Cсылка">
                  <a v-if="item.typedoc.includes('факт') || item.typedoc[0] == 'f'"
                    :href="'http://www.kse.kg/ru/RussianAllNewsBlog/' + item.linkkse" target="_blank">
                    {{ item.linkkse }}
                  </a>
                  <a v-else :href="
                    'http://www.kse.kg/files/BusinessReports/' + item.linkkse
                  " target="_blank">
                    {{ item.linkkse }}
                  </a>
                </md-table-cell>
                <md-table-cell md-label="Подпись">
                  <md-button title="Проверить первую подпись" v-if="item.first_sign"
                    class="md-just-icon md-simple md-primary" @click.native="checkSignHandler(item.id, 1)">
                    <span class="material-icons">verified</span>
                  </md-button>
                </md-table-cell>
                <md-table-cell md-label="">
                  <template v-if="isAdmin && item.status === 3">
                    <md-button class="md-just-icon md-simple md-danger" @click.native="rejectHandler(item.id)">
                      <span class="material-icons">cancel</span>
                    </md-button>
                  </template>
                </md-table-cell>

                <md-table-cell>
                  <template v-if="isUser">
                    <div class="md-group">
                      <md-button v-if="
                        (item.status === 1 || item.status === 4) &&
                        item.typedoc != 'Создать отчет'
                      " title="Редактировать" class="md-just-icon md-simple md-success"
                        @click.native="editHandler(item.id)">
                        <span class="material-icons">create</span>
                      </md-button>
                      <md-button v-if="item.status === 1 || item.status === 4" title="Удалить"
                        class="md-just-icon md-simple md-warning" @click.native="deleteHandler(item.id, key)">
                        <span class="material-icons">delete_forever</span>
                      </md-button>
                      <md-button v-if="
                        (item.is_first_signer &&
                          item.status === 1) ||
                        item.status === 4
                      " class="md-just-icon md-simple md-primary" v-on:click="signHandler(item.id, 1)"
                        title="Подписать">
                        <span class="material-icons">vpn_key</span>
                      </md-button>
                      <!-- отправить отчет -->
                      <md-button v-if="
                        item.status == 1 ||
                        item.status == 4 ||
                        item.status == 5
                      " title="Отправить" class="md-just-icon md-simple md-info"
                        @click.native="sendHandler(item.id, item.typedoc, key)">
                        <span class="material-icons">send</span>
                      </md-button>
                      <!--  -->
                    </div>
                  </template>

                  <template v-if="isUser && item.status === 2">
                    <md-button title="отменить отправку" class="md-warning custom-edit-button"
                      v-on:click="revokeHandler(item.id, key)">
                      <span class="material-icons">reply</span>
                    </md-button>
                  </template>
                  <template v-if="isAdmin && item.status === 2">
                    <div class="md-group">
                      <md-button class="md-just-icon md-simple md-success" @click.native="
                        confirmHandler(
                          item.id,
                          item.sender,
                          item.typedoc,
                          item.doc,
                          item.name,
                          item.kvartal,
                          item.datesend,
                          1,
                          item.f_sign_doc,
                          key
                        )
                      ">
                        <span class="material-icons">check_circle_outline</span>
                      </md-button>
                      <md-button class="md-just-icon md-simple md-danger" @click.native="rejectHandler(item.id, key)">
                        <span class="material-icons">cancel</span>
                      </md-button>
                      <md-button class="md-just-icon md-simple md-warning" @click.native="toCartHandler(item.id, key)">
                        <span class="material-icons">delete</span>
                      </md-button>
                    </div>
                  </template>

                  <template v-if="(isUser || isAdmin) && item.status === 3">
                    <md-button class="md-raised custom-edit-button" @click.native="refHandler(item.ref)">
                      квитанция
                    </md-button>
                  </template>
                </md-table-cell>
              </md-table-row>
            </md-table>
            <div class="footer-table md-table">
              <table>
                <tfoot>
                  <tr>
                    <th v-for="item in footerTable" :key="item.name" class="md-table-head">
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
          <md-card-actions md-alignment="space-between">
            <div class="">
              <p class="card-category">
                Показано с {{ from + 1 }} по {{ to }} из {{ getReportsCount }} документов
              </p>
            </div>
            <pagination class="pagination-no-border pagination-primary" v-model="pagination.currentPage"
              :per-page="pagination.perPage" :total="getReportsCount"></pagination>
          </md-card-actions>
        </md-card>
      </div>
    </div>
  </div>
</template>

<script>
import { Pagination } from '@/components'
import Fuse from 'fuse.js'
import Swal from 'sweetalert2'
import { mapActions, mapGetters } from 'vuex'

export default {
  async created() {
    document.body.scrollTop = 0 // For Safari
    document.documentElement.scrollTop = 0 // For Chrome, Firefox, IE and Opera
    if (localStorage.getItem('user') === 'user') {
      this.isUser = true
    } else if (localStorage.getItem('user') === 'admin') {
      this.isAdmin = true
    }
    //this.pagination.currentPage = this.$route.query.page
  },
  components: {
    Pagination
  },
  computed: {
    ...mapGetters('report', ['getReportList', 'getReportsCount']),
    /***
     * Returns a page from the searched data or the whole data. Search is performed in the watch section below
     */
    to() {
      let highBound = this.from + this.pagination.perPage
      if (this.total < highBound) {
        highBound = this.total
      }
      return highBound
    },
    from() {
      return this.pagination.perPage * (this.pagination.currentPage - 1)
    }
  },
  data() {
    return {
      isUser: false,
      isAdmin: false,
      pagination: {
        perPage: 25,
        currentPage: 1,
        perPageOptions: [5, 10, 25, 50],
        total: 0
      },
      footerTable: [
        // 'Наименование компании',
        // 'Статус документа',
        // 'Дата регистрации',
        // 'Тип документа',
      ],
      searchQuery: '',
      propsToSearch: ['typedoc', 'name', 'kvartal'],
      tableData: [],
      searchedData: [],
      fuseSearch: null,
      limit: 25
    }
  },

  methods: {
    ...mapActions('report', [
      'DELETE_REPORT',
      'GET_REPORT_LIST',
      'SEND_REPORT_TO_ADMIN',
      'GET_USER_PIN',
      'SIGN_REPORT',
      'CHECK_SIGN_REPORT',
      'GET_REPORT_RECEIPT',
      'DELETE_CONFIRM_REPORT',
      'SEND_NEWS_TO_KSE',
      'SEND_REPORTS_TO_KSE',
      'ADD_LINK_TO_KSE',
      'REVOKE_REPORT',
      'REJECT_REPORT',
      'MOVE_TO_CART_REPORT',
      'ADD_LINK_FILE_TO_KSE',
      'SEARCH_REPORT'
    ]),
    pushToPrintView(id) {
      this.$router.push({
        path: '/' + this.$i18n.locale + '/dashboard/printview/' + id
      })
    },
    editHandler(id) {
      this.$router.push({
        path:
          '/' + this.$i18n.locale + '/dashboard/template/' + id + '/' + 'edit'
      })
    },
    refHandler(id) {
      this.$router.push({
        path: '/' + this.$i18n.locale + '/dashboard/printview/' + id
      })
    },
    async deleteHandler(id, key) {
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
          this.DELETE_REPORT({ id, key }).then(() => {
            //let index = this.tableData.findIndex((el) => el.id === id)
            //this.tableData.splice(index, 1)
            Swal.fire({
              title: 'Удален!',
              text: 'Ваш документ был  успешно удален!',
              type: 'success',
              confirmButtonClass: 'md-button md-success',
              buttonsStyling: false
            })
          })
        }
      })
    },
    async signHandler(id, order) {
      Swal.fire({
        title: '',
        text: `Вы уверены, что хотите подписать документ?`,
        type: 'warning',
        showCancelButton: true,
        confirmButtonClass: 'md-button md-success',
        cancelButtonClass: 'md-button md-danger',
        cancelButtonText: 'Закрыть',
        confirmButtonText: 'Да, подписать!',
        buttonsStyling: false
      }).then((result) => {
        if (result.value) {
          this.GET_USER_PIN()
            .then((response) => {
              if (
                typeof response === 'object' &&
                response.request.status === 200
              ) {
                Swal.fire({
                  title: 'Введите Пин код!',
                  html:
                    `<div><h4>` +
                    response.data.message +
                    `</h4></div><div class="md-field md-theme-default"> 
                       <input type="number" required id="md-input" class="md-input"></div>`,
                  preConfirm: () => {
                    return [document.getElementById('md-input').value]
                  },
                  showCancelButton: true,
                  confirmButtonClass: 'md-button md-success',
                  cancelButtonClass: 'md-button md-danger',
                  cancelButtonText: 'Закрыть',
                  buttonsStyling: false,
                  allowOutsideClick: false
                }).then((result) => {
                  if (result.value[0]) {
                    let pin = result.value[0]
                    this.SIGN_REPORT({ id, pin, order })
                      .then((response) => {
                        if (response.request.status === 200) {
                          Swal.fire({
                            title: `Документ успешно подписан!`,
                            type: 'success',
                            buttonsStyling: false,
                            confirmButtonClass: 'md-button md-success'
                          })
                          this.GET_REPORT_LIST({
                            limit: this.pagination.perPage,
                            page: this.pagination.currentPage
                          })
                        } else if (response.request.status === 403) {
                          Swal.fire({
                            text: 'Произошла ошибка на сервере! Попробуйте еще раз!',
                            buttonsStyling: false,
                            confirmButtonClass: 'md-button md-success'
                          })
                        } else {
                          let { message } = JSON.parse(response.request.response)
                          Swal.fire({
                            text: message,
                            buttonsStyling: false,
                            confirmButtonClass: 'md-button md-success'
                          })
                        }
                      })
                  } else {
                  }
                })
              } else {
                Swal.fire({
                  text: response,
                  buttonsStyling: false,
                  confirmButtonClass: 'md-button md-success'
                })
              }
            })
            .catch((error) => {
              Swal.fire({
                text: error,
                buttonsStyling: false,
                confirmButtonClass: 'md-button md-success'
              })
            })
        }
      })
    },
    checkSignHandler(id, order) {
      this.CHECK_SIGN_REPORT({ id, order }).then((res) => {
        if (res.data.message.errorCode) {
          Swal.fire({
            text: res.data.message.errorMessage,
            buttonsStyling: false,
            confirmButtonClass: 'md-button md-success'
          })
        } else {
          let date = new Date(res.data.message.timestamp)
          let strData =
            date.getDate() +
            '/' +
            (date.getMonth() + 1) +
            '/' +
            date.getFullYear() +
            ' ' +
            date.getHours() +
            ':' +
            date.getMinutes() +
            ':' +
            date.getSeconds()
          Swal.fire({
            html:
              `<style>
                .mytable {
                  border:0.5px dotted grey;
                  border-collapse: collapse;
                }
                td{
                 text-align: left;
                  max-width : 100px; 
                  text-overflow: ellipsis;
                }
                </style>
                <div>
                <h3>Подпись</h3>
                <table width=100% class="mytable">
                <tr class="mytable"><td class="mytable">ИНН физ.лица</td><td class="mytable">` +
              res.data.message.personIdnp +
              `</td></tr>
                <tr class="mytable"><td></td><td class="mytable">` +
              res.data.message.personFio +
              `</td></tr>
                <tr class="mytable"><td>ИНН организации</td><td class="mytable">` +
              res.data.message.organizationInn +
              `</td></tr>
                <tr class="mytable"><td  class="mytable">Название организации</td><td class="mytable">` +
              res.data.message.organizationName +
              `</td></tr>
                <tr class="mytable"><td class="mytable">Сертификат</td><td class="mytable">` +
              res.data.message.certName +
              `</td></tr>
                <tr class="mytable"><td>Дата</td><td class="mytable">` +
              strData +
              `</td></tr>
               <tr class="mytable"><td>Подпись</td><td class="mytable">подтверждена</td></tr>
                </table></div>`,
            buttonsStyling: false,
            confirmButtonClass: 'md-button md-success'
          })
        }
      })
    },
    async sendHandler(id, type, key) {
      Swal.fire({
        title: '',
        text: `Вы уверены, что хотите отправить документ на подтверждение?`,
        type: 'warning',
        showCancelButton: true,
        confirmButtonClass: 'md-button md-success',
        cancelButtonClass: 'md-button md-danger',
        cancelButtonText: 'Закрыть',
        confirmButtonText: 'Да, отправить!',
        buttonsStyling: false
      }).then((result) => {
        if (result.value) {
          this.SEND_REPORT_TO_ADMIN({ id, type, key }).then(() => {
            Swal.fire({
              title: 'Отправлен!',
              text: 'Ваш документ был  успешно отправлен на подтверждение!',
              type: 'success',
              confirmButtonClass: 'md-button md-success',
              buttonsStyling: false
            })
          })
        }
      })
    },
    async confirmHandler(
      id,
      sender,
      typedoc,
      doc,
      companyName,
      kvartal,
      datesend,
      order,
      fsigndoc,
      key
    ) {
      // Подтвердить документ - code begin
      Swal.fire({
        title: '',
        text: `Вы уверены, что хотите подтвердить документ?`,
        type: 'warning',
        showCancelButton: true,
        confirmButtonClass: 'md-button md-success',
        cancelButtonClass: 'md-button md-danger',
        cancelButtonText: 'Закрыть',
        confirmButtonText: 'Да, подтвердить!',
        buttonsStyling: false
      }).then((result) => {
        // report receipt
        if (result.value) {
          this.GET_REPORT_RECEIPT({
            // Формирование квитанции для отчета из таблицы docslayout и дальнейшее подтверждение
            id,
            sender,
            companyName,
            typedoc,
            kvartal,
            datesend,
            key
          })
            .then((id_doc) => {
              // тип документа - Существенный факт
              if (typedoc.includes('Существенный')) {
                // let doAddEntry = 'test'
                // let BlogId = '3'
                // start - push f_sign_doc before send to kse
                // if (fsigndoc != null) {
                //     newDoc.push(`Подписано с помощью ЭЦП: ${fsigndoc.personFio}`)
                // }
                // end - push f_sign_doc before send to kse

                // вводить пин код для подписи - code begin
                this.GET_USER_PIN() // получение ИНН из базы инфоком
                  .then((response) => {
                    if (
                      typeof response === 'object' &&
                      response.request.status === 200
                    ) {
                      Swal.fire({
                        title: 'Введите Пин код!',
                        html:
                          `<div><h4>` +
                          response.data.message +
                          `</h4></div><div class="md-field md-theme-default"> 
                                      <input type="number" required id="md-input" class="md-input"></div>`,
                        preConfirm: () => {
                          return [document.getElementById('md-input').value]
                        },
                        showCancelButton: true,
                        confirmButtonClass: 'md-button md-success',
                        cancelButtonClass: 'md-button md-danger',
                        cancelButtonText: 'Закрыть',
                        buttonsStyling: false,
                        allowOutsideClick: false
                      }).then((result) => {
                        if (result.value[0]) {
                          let pin = result.value[0]
                          this.SIGN_REPORT({
                            // Отправка документа на подпись
                            id: id_doc,
                            pin,
                            order
                          })
                            .then((response) => {
                              if (response.request.status === 200) {
                                let newDoc = []
                                let fact = {}
                                let titles = {}
                                let j = 0
                                for (let i = 0; i < doc.fields.length; i++) {
                                  if (
                                    doc.fields[i].element === 'label' ||
                                    doc.fields[i].element === 'h6' ||
                                    doc.fields[i].element === 'h4'
                                  ) {
                                    titles['title' + [j]] = {
                                      text: doc.fields[i].name,
                                      type: 'header'
                                    }
                                    j++
                                  } else if (
                                    doc.fields[i].element === 'input' ||
                                    doc.fields[i].element === 'input-text-area'
                                  ) {
                                    newDoc.push(doc.fields[i].value)
                                    if (doc.fields[i].name) {
                                      titles['title' + [j]] = doc.fields[i].name
                                      j++
                                    } else {
                                      titles['title' + [j - 1]] =
                                        doc.fields[i - 1].name
                                    }
                                  }
                                }
                                fact['titles'] = titles
                                let name = companyName + ' : ' + doc.title
                                this.sendToKSE(
                                  // отправка сущ факта в json формате на базу kse
                                  name,
                                  newDoc,
                                  companyName,
                                  fact
                                ).then((response) => {
                                  let link = response.data
                                  let idfact = id.toString()
                                  if (
                                    this.ADD_LINK_TO_KSE({
                                      // добавление ссылки на отправленный сущ факт в базу oi
                                      idfact,
                                      link
                                    })
                                  ) {
                                    Swal.fire({
                                      title: `Документ успешно подписан!`,
                                      type: 'success',
                                      buttonsStyling: false,
                                      confirmButtonClass: 'md-button md-success'
                                    })
                                  }
                                })
                              } else if (response.request.status === 403) {
                                Swal.fire({
                                  text: 'Произошла ошибка на сервере! Попробуйте еще раз!',
                                  buttonsStyling: false,
                                  confirmButtonClass: 'md-button md-success'
                                })
                                this.DELETE_CONFIRM_REPORT( // удаление подтверждения при возникновении ошибки
                                  {
                                    id_doc: id,
                                    id_receipt: id_doc,
                                    sender,
                                    kvartal,
                                    key
                                  }
                                )
                              } else {
                                let { message } = JSON.parse(
                                  response.request.response
                                )
                                Swal.fire({
                                  text: message,
                                  buttonsStyling: false,
                                  confirmButtonClass: 'md-button md-success'
                                })
                                this.DELETE_CONFIRM_REPORT( // удаление подтверждения при возникновении ошибки
                                  {
                                    id_doc: id,
                                    id_receipt: id_doc,
                                    sender,
                                    kvartal,
                                    key
                                  }
                                )
                              }
                            })
                        }
                      })
                    } else {
                      Swal.fire({
                        text: response,
                        buttonsStyling: false,
                        confirmButtonClass: 'md-button md-success'
                      }).then((response) => {
                        this.DELETE_CONFIRM_REPORT( // удаление подтверждения при возникновении ошибки
                          {
                            id_doc: id,
                            id_receipt: id_doc,
                            sender,
                            kvartal,
                            key
                          }
                        )
                      })
                    }
                  })
                  .catch((error) => {
                    let { message } = JSON.parse(response.request.response)
                    Swal.fire({
                      text: message,
                      buttonsStyling: false,
                      confirmButtonClass: 'md-button md-success'
                    })
                  })
                // вводить пин код для подписи - code end
              } else if (typedoc.includes('Создать')) {
                this.ADD_LINK_FILE_TO_KSE({ doc, companyName, kvartal }) // отправка ссылки на отчет в виде файла на базу kse после подтверждения
                  .then((response) => {
                    console.log(response)
                    if (response.data.includes('Запись не была добавлена')) {
                      Swal.fire({
                        title: response.data,
                        type: 'success',
                        buttonsStyling: false,
                        confirmButtonClass: 'md-button md-success'
                      })
                      this.DELETE_CONFIRM_REPORT({
                        id_doc: id,
                        id_receipt: id_doc,
                        sender,
                        kvartal,
                        key
                      })
                    }
                  })
                //console.log(doc)
              }
              // тип документа - Не существенный факт
              else {
                // start - push f_sign_doc before send to kse
                // if (fsigndoc != null) {
                //     doc.fields.push({
                //         element: "h4",
                //         id: "f_sign_doc",
                //         name: `Подписано с помощью ЭЦП: ${fsigndoc.personFio}`
                //     })
                // }
                // end - push f_sign_doc before send to kse
                this.GET_USER_PIN()
                  .then((response) => {
                    if (
                      typeof response === 'object' &&
                      response.request.status === 200
                    ) {
                      Swal.fire({
                        title: 'Введите Пин код!',
                        html:
                          `<div><h4>` +
                          response.data.message +
                          `</h4></div><div class="md-field md-theme-default"> 
                                <input type="number" required id="md-input" class="md-input"></div>`,
                        preConfirm: () => {
                          return [document.getElementById('md-input').value]
                        },
                        showCancelButton: true,
                        confirmButtonClass: 'md-button md-success',
                        cancelButtonClass: 'md-button md-danger',
                        cancelButtonText: 'Закрыть',
                        buttonsStyling: false,
                        allowOutsideClick: false
                      }).then((result) => {
                        if (result.value[0]) {
                          let pin = result.value[0]
                          this.SIGN_REPORT({
                            id: id_doc,
                            pin,
                            order
                          })
                            .then((response) => {
                              if (response.request.status === 200) {
                                let company_name = companyName
                                this.SEND_REPORTS_TO_KSE({
                                  kvartal,
                                  doc,
                                  company_name
                                })
                                  .then((response) => {
                                    let link = response.data
                                    let idfact = id.toString()
                                    if (
                                      this.ADD_LINK_TO_KSE({
                                        idfact,
                                        link
                                      })
                                    ) {
                                      Swal.fire({
                                        title: `Документ успешно подписан!`,
                                        type: 'success',
                                        buttonsStyling: false,
                                        confirmButtonClass:
                                          'md-button md-success'
                                      })
                                    }
                                  })
                              } else if (response.request.status === 403) {
                                Swal.fire({
                                  text: 'Произошла ошибка на сервере! Попробуйте еще раз!',
                                  buttonsStyling: false,
                                  confirmButtonClass: 'md-button md-success'
                                })
                                this.DELETE_CONFIRM_REPORT({
                                  id_doc: id,
                                  id_receipt: id_doc,
                                  sender,
                                  kvartal,
                                  key
                                })
                              } else {
                                let { message } = JSON.parse(
                                  response.request.response
                                )
                                Swal.fire({
                                  text: message,
                                  buttonsStyling: false,
                                  confirmButtonClass: 'md-button md-success'
                                })
                                this.DELETE_CONFIRM_REPORT({
                                  id_doc: id,
                                  id_receipt: id_doc,
                                  sender,
                                  kvartal,
                                  key
                                })
                              }
                            })
                        }
                      })
                    } else {
                      Swal.fire({
                        text: response,
                        buttonsStyling: false,
                        confirmButtonClass: 'md-button md-success'
                      })
                    }
                  })
                  .catch((error) => {
                    Swal.fire({
                      text: error,
                      buttonsStyling: false,
                      confirmButtonClass: 'md-button md-success'
                    })
                  })
              }
            }
            )
        }
      })
    },
    sendToKSE(mEntryName, mEntryText, mEntryCompany, titles) {
      let doAddEntry = 'test'
      let BlogId = '3'
      return this.SEND_NEWS_TO_KSE({
        doAddEntry,
        BlogId,
        mEntryText,
        mEntryName,
        mEntryCompany,
        titles
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

        case 5:
          return 'Подписан первой ЭЦП'

        case 6:
          return 'Подписан второй ЭЦП'
      }
    },
    async revokeHandler(id, key) {
      Swal.fire({
        title: '',
        text: `Вы действительно хотите отменить отправку?`,
        type: 'warning',
        showCancelButton: true,
        confirmButtonClass: 'md-button md-success',
        cancelButtonClass: 'md-button md-danger',
        cancelButtonText: 'Закрыть',
        confirmButtonText: 'Да, отменить!',
        buttonsStyling: false
      }).then((result) => {
        if (result.value) {
          this.REVOKE_REPORT({ id, key }).then(() => {
            Swal.fire({
              title: 'Отправка отменена!',
              text: 'Ваш документ готов к редактированию!',
              type: 'success',
              confirmButtonClass: 'md-button md-success',
              buttonsStyling: false
            })
          })
        }
      })
    },
    rejectHandler(id, key) {
      Swal.fire({
        title: '',
        text: `Вы действительно хотите отклонить?`,
        type: 'warning',
        showCancelButton: true,
        confirmButtonClass: 'md-button md-success',
        cancelButtonClass: 'md-button md-danger',
        cancelButtonText: 'Закрыть',
        confirmButtonText: 'Да, отклонить!',
        buttonsStyling: false
      }).then((result) => {
        if (result.value) {
          if (this.REJECT_REPORT({ id, key })) {
            Swal.fire({
              title: 'Отклонен!',
              text: '',
              type: 'success',
              confirmButtonClass: 'md-button md-success',
              buttonsStyling: false
            })
          }
        }
      })
    },
    toCartHandler(id, key) {
      Swal.fire({
        title: '',
        text: `Вы уверены, что хотите переместить документ в корзину ?`,
        type: 'warning',
        showCancelButton: true,
        confirmButtonClass: 'md-button md-success',
        cancelButtonClass: 'md-button md-danger',
        cancelButtonText: 'Закрыть',
        confirmButtonText: 'Да, переместить!',
        buttonsStyling: false
      }).then((result) => {
        if (result.value) {
          if (this.MOVE_TO_CART_REPORT({ id, key })) {
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
    },
    search(search = '', page = 1) {
      search = this.searchQuery.toLowerCase()
      this.$router.push({ query: { page, search } })
      this.SEARCH_REPORT({
        search,
        limit: this.pagination.perPage,
        page
      })
    }
  },
  async mounted() {
    if (!this.getReportList.list) {
      this.GET_REPORT_LIST({
        limit: this.pagination.perPage,
        page: this.pagination.currentPage
      }) // получение первых 25 отчетов и значение общего кол-во
    } else {
      this.pagination.currentPage = +this.getReportList.page
    }
  },

  watch: {
    /**
     * Searches through the table data by a given query.
     * NOTE: If you have a lot of data, it's recommended to do the search on the Server Side and only display the results here.
     * @param value of the query
     */
    'pagination.currentPage': async function (val,oldValue) {
      // переход между страницами пагинации для отчетов
      let search = this.$route.query.search
      this.$router.push({ query: { page: val, search } })
      if (this.searchQuery === undefined || this.searchQuery == '') {
        this.GET_REPORT_LIST({
          limit: this.pagination.perPage,
          page: +this.$route.query.page
        })
      } else {
        this.SEARCH_REPORT({
          search: search.toLowerCase(),
          limit: this.pagination.perPage,
          page: +this.$route.query.page
        })
      }
    }
  }
}
</script>

<style lang="css" scoped>
.top-pagination {
  z-index: 20;
  position: absolute;
  right: 1%;
}

.md-card .md-card-actions {
  border: 0;
  margin-left: 20px;
  margin-right: 20px;
}

.custom-select-button {
  height: 2rem;
}

.custom-md-group {
  width: 13rem;
}

.custom-edit-button {
  vertical-align: top;
  white-space: normal;
  cursor: pointer;
  overflow: hidden;
  text-align: center;
  width: 7rem;
  height: 3rem;
  line-height: 1rem;
  font-size: 0.775rem;
  display: inline-block;
  align-items: center;
  justify-content: center;
  top: 0px;
}

.clip {
  overflow: hidden;
  text-overflow: ellipsis;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  cursor: pointer;
}
</style>
