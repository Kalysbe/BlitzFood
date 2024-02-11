<template>
  <div>
    <div class="md-layout">
      <div class="md-layout-item md-size-100 md-padding" v-if="!isDataLoading">
        <md-card>
          <md-card-header class="md-card-header-text md-card-header-blue">
            <div class="card-text">
              <h4 class="title">{{ doc.title }}</h4>
            </div>
          </md-card-header>

          <md-card-content>
            <!--  модальное окно для описания документа -->
            <template v-if="doc.description != null">
              <md-button class="md-just-icon classic-modal" @click="classicModal = true">
                <span class="material-icons">help_outline</span>
              </md-button>
              <modal v-if="classicModal" @close="classicModalHide">
                <template slot="header">
                  <h4 class="modal-title"></h4>
                  <md-button class="md-simple md-just-icon md-round modal-default-button" @click="classicModalHide">
                    <md-icon>clear</md-icon>
                  </md-button>
                </template>

                <template slot="body">
                  <p>
                    {{ doc.description }}
                  </p>
                </template>
                <template slot="footer">
                  <md-button class="md-danger md-simple" @click="classicModalHide">
                    Закрыть
                  </md-button>
                </template>
              </modal>
              <!--  /модальное окно для описания документа -->
            </template>

            <!-- начало парсинга структуры документа -->
            <div v-for="(field, key) in doc.fields" v-bind:key="key">
              <!-- заголовок -->
              <template v-if="field.element === 'header'">
                <span class="header">{{ field.name }}</span>
                <br />
                <br />
                <br />
                <br />
                <br />
              </template>
              <!-- /заголовок -->
              <!-- селектор -->

              <template v-if="field.element === 'select' && selectView">
                <template v-if="isEditMode">
                  <div class="md-layout custom-md">
                    <md-field class="md-layout-item md-size-30">
                      <label for="reportType">{{ field.name }}</label>
                      <md-input v-model="field.value" disabled type="text"></md-input>
                    </md-field>
                  </div>
                </template>
                <template v-else>
                  <!-- тип отчета ********************************************* -->
                  <div class="md-layout custom-md">
                    <md-field class="md-layout-item md-size-30">
                      <label for="reportType">{{ field.name }}</label>
                      <md-select v-model="field.value">
                        <md-option v-for="(option, key) in field.options" v-bind:key="key" :value="option">
                          {{ option }}
                        </md-option>
                      </md-select>
                    </md-field>
                  </div>
                </template>
              </template>

              <!-- /селектор -->
              <!-- строки -->
              <template v-if="field.element === 'h1'">
                <h1>{{ field.name }}</h1>
              </template>
              <template v-if="field.element === 'h2'">
                <h2>{{ field.name }}</h2>
              </template>
              <template v-if="field.element === 'h3'">
                <h3>{{ field.name }}</h3>
              </template>

              <template v-if="
                field.element === 'h4' &&
                doc.fields[1].value != 'Годовой отчет' &&
                field.id != 'audit_report_label'
              ">
                <h4>{{ field.name }}</h4>
              </template>

              <template v-else-if="
                field.element === 'h4' &&
                doc.fields[1].value === 'Годовой отчет'
              ">
                <h4>{{ field.name }}</h4>
              </template>

              <template v-if="field.element === 'h5'">
                <h5>{{ field.name }}</h5>
              </template>
              <template v-if="field.element === 'h6'">
                <h6>{{ field.name }}</h6>
              </template>
              <template v-if="field.element === 'p'">
                <p>{{ field.name }}</p>
              </template>
              <template v-if="field.element === 'label'">
                <label class="label-custom">{{ field.name }}</label>
              </template>
              <template v-if="field.element === 'span'">
                <span>{{ field.name }}</span>
              </template>
              <!-- /строки -->
              <!-- инпут  -->
              <template v-if="field.element === 'input'">
                <div class="md-layout md-size-100">
                  <md-field class="md-layout-item custom-md">
                    <label>{{ field.name }}</label>
                    <md-input v-model="field.value" type="text-area"></md-input>
                  </md-field>
                </div>
              </template>
              <!-- /инпут  -->
              <!-- textarea   -->
              <template v-if="
                field.element === 'input-text-area' &&
                doc.fields[1].value != 'Годовой отчет' &&
                field.id != 'audit_report'
              ">
                <div class="md-layout">
                  <label class="md-layout-item md-size-100">
                    {{ field.name }}
                  </label>
                  <div class="md-layout-item">
                    <md-field>
                      <md-textarea v-model="field.value"></md-textarea>
                    </md-field>
                  </div>
                </div>
                <br />
              </template>
              <template v-if="
                field.element === 'input-text-area' &&
                doc.fields[1].value === 'Годовой отчет'
              ">
                <div class="md-layout">
                  <label class="md-layout-item md-size-100">
                    {{ field.name }}
                  </label>
                  <div class="md-layout-item">
                    <md-field>
                      <md-textarea v-model="field.value"></md-textarea>
                    </md-field>
                  </div>
                </div>
                <br />
                <!-- <div class="md-layout md-size-100">
                  <md-field class="md-layout-item custom-md">
                    <label class="custom-text-area">{{ field.name }}</label>
                    <md-textarea
                      v-model="field.value"
                      type="text-area"
                    ></md-textarea>
                  </md-field>
                </div> -->
              </template>
              <!-- /textarea -->
              <!-- групровые инпуты -->
              <template v-if="field.element === 'group'">
                <template>
                  <h4>{{ field.name }}</h4>
                  <div v-for="(item, key) in field.items" :key="key">
                    <template>
                      <div class="md-layout-item">
                        <label> {{ item.name }} :</label>
                        <md-field>
                          <md-input v-model="item.value"></md-input>
                        </md-field>
                      </div>
                    </template>
                  </div>
                </template>
              </template>
              <!-- /групровые инпуты -->
              <!-- таблицы -->
              <template v-if="field.element === 'table'">
                <div class="md-layout-item">
                  <div class="md-layout">
                    <div class="md-layout-item md-small-size-100 md-size-50">
                      <h6 v-if="field.name != ''" style="margin: 0">
                        {{ field.name }}
                      </h6>
                    </div>
                    <!-- <div class="md-layout md-small-size-100 md-size-30"  v-if="field.id === 'fin_statements_1_tbl'">
                      <div style="padding-right: 0" class="md-layout-item md-small-size-100 md-size-70">
                        <h6 style="margin: 0; color: green;">Выберите единицу измерения (сом или тыс.сом)</h6>
                      </div>
                      <div
                        style="padding: 0; margin-top: -8px"
                        class="md-layout-item md-small-size-100 md-size-30"
                      >
                        <md-field style="margin-top: 0;">
                          <md-select style="width: 30px" v-model="com" placeholder="выберите">
                            <md-option value="сом">сом</md-option>
                            <md-option value="тыс.сом">тыс.сом</md-option>
                          </md-select>
                        </md-field>
                      </div>
                    </div> -->
                  </div>

                  <md-table class="md-layout md-size-100" table-header-color="green">
                    <md-table-row slot="md-table-header">
                      <md-table-cell v-for="(header) in field.headers" :key="header">
                        <template v-if="header != '*'">
                          <!-- <template v-if="i==2">
                            <template v-if="i==2 || i == 3">{{ field.headers[2] }} {{field.id == 'fin_statements_1_tbl' ? com : null}} {{field.id == 'fin_statements_2_tbl' ? com : null}} {{field.id == 'fin_statements_3_tbl' ? com : null}}</template>
                          </template> -->
                          <template>
                            {{ header }}
                          </template>
                        </template>
                      </md-table-cell>
                    </md-table-row>

                    <!-- <md-table-row slot="md-table-header">
                      <md-table-cell>
                        <template>{{ field.headers[0] }}</template>
                      </md-table-cell>
                      <md-table-cell>
                        <template>{{ field.headers[1] }}</template>
                      </md-table-cell>
                      <md-table-cell>
                        <template>{{ field.headers[2] }} {{field.id == 'fin_statements_1_tbl' ? com : null}} {{field.id == 'fin_statements_2_tbl' ? com : null}} {{field.id == 'fin_statements_3_tbl' ? com : null}}</template>
                      </md-table-cell>
                      <md-table-cell>
                        <template>{{ field.headers[3] }} {{field.id == 'fin_statements_1_tbl' ? com : null}} {{field.id == 'fin_statements_2_tbl' ? com : null}} {{field.id == 'fin_statements_3_tbl' ? com : null}}</template>
                      </md-table-cell>
                    </md-table-row> -->

                    <md-table-row slot="md-table-row" v-for="(row, key) in field.rows" v-bind:key="key">
                      <md-table-cell v-for="(cell, key) in row.cells" :key="key">
                        <template v-if="cell.element === 'input'">
                          <md-field>
                            <md-input type="text" v-model="cell.value"></md-input>
                          </md-field>
                        </template>
                        <template v-else-if="cell.element === 'label-input'">
                          <md-field>
                            <label class="md-label">{{ cell.name }}</label>
                            <md-input class="input-custom" type="text" v-model="cell.value"></md-input>
                          </md-field>
                        </template>

                        <template v-else>
                          {{ cell.name }}
                        </template>
                      </md-table-cell>
                    </md-table-row>
                  </md-table>

                  <div v-if="field.isButtonAvailable && !btnView" class="item-back">
                    <div class="md-group">
                      <md-button class="md-success" v-on:click="addButtonHandler(field.id)">
                        Добавить
                      </md-button>
                      <md-button class="md-just-icon md-danger" @click.native="delButtonHandler(field.id)">
                        <span class="material-icons">clear</span>
                      </md-button>
                    </div>
                  </div>
                </div>
              </template>

              <!-- /таблицы -->

              <!-- изображение -->
              <!-- <template v-if="field.element === 'img'">
                <img v-bind:src="field.name" class="img" />
              </template>
              <template v-if="field.element === 'stump'">
                <img v-bind:src="field.name" class="stump" />
              </template> -->
              <!-- /изображение -->

              <!-- /парсинг структуры документа -->
            </div>
            <!-- конец парсинга структуры документа -->

          </md-card-content>
        </md-card>
      </div>
      <div class="md-layout-item md-size-100 item-back md-padding" v-if="!btnView">
        <div class="md-group">
          <md-button @click="backToListHandler">
            <span class="md-label">
              <md-icon class="material-icons">keyboard_arrow_left</md-icon>
            </span>
            Назад
          </md-button>
          <md-button v-if="isNewDoc && !isAdmin" class="md-danger" @click="saveHandler()">
            Сохранить
          </md-button>
          <md-button v-if="isEditMode" class="md-info" @click="updateHandler()">
            Обновить
          </md-button>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import { Modal } from '@/components'
import { off } from 'process'
import { mapActions, mapGetters } from 'vuex'
export default {
  name: 'ReportView',
  props: {
    id: String,
    mode: String,
    saveMode: {
      type: Boolean,
      default: false
    },
    btnView: {
      type: Boolean,
      default: false
    },
    selectView: {
      type: Boolean,
      default: false
    }
  },
  async created() {
    if (localStorage.getItem('user') === 'admin') {
      this.isAdmin = true
    }
    let searchedFact = this.id ? this.id : this.$route.params.id
    let mode = this.mode ? this.mode : this.$route.params.mode
    if (mode == 'new') {
      this.doc = await this.GET_DOC_PROPS(searchedFact)
      this.companyInfo = await this.GET_COMPANY_DATA()

      for (let i = 0; i < this.doc.fields.length; i++) {
        if (this.doc.name != 'listing_prospectus' && this.doc.fields[i].id.includes('emitent_info_tbl')) {
          this.doc.fields[i].items[0].value = this.companyInfo.name
          this.doc.fields[i].items[1].value = this.companyInfo.opforma
          this.doc.fields[i].items[2].value = this.companyInfo.address
          this.doc.fields[i].items[3].value = this.companyInfo.activity
        } else if (this.doc.name != 'listing_prospectus' && this.doc.fields[i].id.includes('#')) {
          this.doc.fields[i].items[0].value = this.companyInfo.name
        } else if (this.doc.fields[i].id.includes('director')) {
          this.doc.fields[i].name =
            this.companyInfo.sepervisor.position +
            ': ' +
            this.companyInfo.sepervisor.dir
        } else if (
          this.doc.fields[i].id.includes('accountant') &&
          this.companyInfo.sepervisor.buh
        ) {
          this.doc.fields[i].name =
            'Главный бухгалтер: ' + this.companyInfo.sepervisor.buh
        }
      }

      this.isDataLoading = false
    } else if (mode == 'edit') {
      this.report = Object.assign(
        {},
        await this.GET_REPORT_BY_ID(searchedFact)
        //this.getReportByType(searchedFact)
      )
      // console.log(this.getReportByType.xmldoc)
      // for (let i = 0; i <= this.getReportByType.length; i++) {
      //   if (this.getReportByType[i].typedoc == this.id) {
      //     this.doc = this.getReportByType[i].xmldoc
      //   }
      // }
      this.doc = this.report.doc
      this.isDataLoading = false
      this.isNewDoc = false
      this.isEditMode = true
    } else if (mode == 'modal') {
      if (searchedFact == 'anex_1')
        this.report = JSON.parse(this.getReportByType.anex_1.xmldoc)
      else if (searchedFact == 'anex_2')
        this.report = JSON.parse(this.getReportByType.anex_2.xmldoc)
      else if (searchedFact == 'anex_2_1')
        this.report = JSON.parse(this.getReportByType.anex_2_1.xmldoc)
      else if (searchedFact == 'listing_prospectus')
        this.report = JSON.parse(this.getReportByType.listing_prospectus.xmldoc)
      this.doc = this.report
      this.isDataLoading = false
      this.isNewDoc = false
      this.isEditMode = true
      // console.log(this.report.doc)
      // console.log(this.report)
    }
  },
  computed: {
    ...mapGetters('upload_file', ['getReportByType'])
  },
  components: {
    Modal
  },
  data() {
    return {
      classicModal: false,
      isDataLoading: true,
      report: {},
      doc: {},
      isNewDoc: true,
      isEditMode: false,
      isAdmin: false,
      companyInfo: {},
      // com: 'сом'
    }
  },
  methods: {
    ...mapActions('documents', ['GET_DOC_PROPS']),
    ...mapActions('company', ['GET_COMPANY_DATA']),
    ...mapActions('report', ['INSERT_REPORT', 'UPDATE_REPORT', 'GET_REPORT_BY_ID']),
    classicModalHide: function () {
      this.classicModal = false
    },
    backToListHandler: function () {
      if (this.$route.params.mode == 'new') {
        this.$router.push({ path: '/' + this.$i18n.locale + `/templates` })
      } else {
        this.$router.push({ path: '/' + this.$i18n.locale + `/dashboard/reports` })
      }
    },
    addButtonHandler: function (id) {
      let index = this.doc.fields.findIndex((fields) => fields.id === id)
      let namedRow = JSON.parse(
        JSON.stringify(
          this.doc.fields[index].rows[this.doc.fields[index].rows.length - 1]
        )
      )
      namedRow.cells[0].name = Number(namedRow.cells[0].name, 10) + 1
      for (let i = 1; i < namedRow.cells.length; i++) {
        namedRow.cells[i].value = ''
        namedRow.cells[i].id =
          namedRow.cells[i].id + '_' + namedRow.cells[0].name
      }

      this.doc.fields[index].rows.push(namedRow)
    },
    delButtonHandler: function (id) {
      let index = this.doc.fields.findIndex((fields) => fields.id === id)

      if (this.doc.fields[index].rows.length - 1 > 0) {
        this.doc.fields[index].rows.pop()
      }
    },
    updateHandler() {
      let doc = JSON.stringify(this.doc)
      let id = this.report.id
      let status = 1
      if (!this.saveMode) {
        let kvartal = this.report.kvartal.toString()
        let typedoc = this.report.typedoc.toString()
        if (
          this.UPDATE_REPORT({
            id,
            doc,
            status,
            kvartal,
            typedoc
          })
        ) {
          this.$router.push({ path: '/' + this.$i18n.locale + `/dashboard/reports` })
        }
      } else {
        this.$emit('saveRep', {
          docslayoutid: this.doc.id,
          typedoc: this.id,
          xmldoc: doc
        })
      }
    },
    saveHandler() {
      let docslayoutid = this.doc.id
      let xmldoc = JSON.stringify(this.doc)
      let sender = localStorage.getItem('login')
      let status = 1
      if (this.doc.name.includes('fact') || this.doc.name.includes('anex')) {
        
        let typedoc
        this.doc.fields =
          this.doc.fields[1].value != 'Годовой отчет' ? this.doc.fields.filter((item) => item.id != 'audit_report_label' && item.id != 'audit_report')
            : this.doc.fields
        let kvartal
        const str = this.doc.fields[1].value
        const res = str.split(' ')
        kvartal = this.doc.fields[2].value + '; ' + res[1] + ' квартал'
        if (this.doc.fields[0].value === '' && this.doc.fields[1].value.includes('Квартал')) {
          typedoc = 'Квартальный отчет ' + '(' + this.doc.title + ')'
        }
        else if (this.doc.fields[0].value === '' && this.doc.fields[1].value.includes('Годовой')) {
          typedoc = this.doc.fields[1].value + ' (' + this.doc.title + ')'
          kvartal = this.doc.fields[2].value
        }
        else if (this.doc.fields[0].value.includes('Существенный факт')) {
          typedoc = this.doc.fields[0].value + ' (' + this.doc.title + ')'
          kvartal = '; '
        }
        else {
          typedoc = this.doc.fields[0].value
        }
        if (!this.saveMode) {
          if ((this.doc.fields[1].value != '' && this.doc.fields[2].value != '') || this.doc.fields[0].value.includes('Существенный факт')) {
            //отправить отчет Существенный факт
            this.INSERT_REPORT(
              {
                docslayoutid,
                typedoc,
                xmldoc,
                sender,
                status,
                kvartal
              }).then(() => { this.$router.push({ path: '/' + this.$i18n.locale + `/dashboard/reports` }) })
          }
        } else {
          this.$emit('saveRep', {
            docslayoutid,
            typedoc: this.id,
            xmldoc
          })
        }
      } else {
        if (!this.saveMode) {
          let typedoc = this.doc.title
          let kvartal = null
          this.INSERT_REPORT(
            {
              docslayoutid,
              typedoc,
              xmldoc,
              sender,
              status,
              kvartal
            }).then(() => { this.$router.push({ path: '/' + this.$i18n.locale + `/dashboard/reports` }) })
        } else {
          this.$emit('saveRep', {
            docslayoutid,
            typedoc: this.id,
            xmldoc
          })
        }
        
      }
    }
  }
}
</script>
<style lang="scss" scoped>
.md-card .md-card-actions {
  border: none;
}

.md-inline-checkboxes {
  display: inline-flex;

  .md-checkbox {
    margin-top: 15px !important;
  }
}

.md-checkbox,
.md-radio {
  margin-top: 15px;
  margin-bottom: 0.5rem;
}

.md-checkbox,
.md-radio {
  display: flex;
}

.md-radio+.md-radio-container {
  margin-left: 5px;
  position: relative;
  left: -3px;
}

.md-form-label + .md-layout-item .md-checkbox:not(:first-child),
.md-form-label + .md-layout-item + .md-layout-item .md-radio:not(:first-child),
.md-form-label + .md-layout-item .md-radio {
  margin-top: 0;
}

.form-control-static {
  margin-top: 6px;
}

.item-back {
  text-align: right;
}

.text-center {
  justify-content: center !important;
}

.label-custom {
  margin-bottom: none;
  padding-bottom: none;
  color: lightslategray;
  font-style: bold;
}

.img {
  width: 50%;
}

.stump {
  width: 20%;
  float: right;
  margin: 1%;
}

.header {
  float: right;
  width: 25%;
}

.md-just-icon {
  float: right;
}

.input-custom {
  margin-left: 1rem;
}

.custom-md {
  margin-bottom: 0.5rem;
}
</style>