<template>
  <div>
    <div class="md-layout">
              <modal v-if="classicModal" @close="classicModalHide">
                <template slot="header">
                  <h4 class="modal-title"></h4>
                  <md-button
                    class="md-simple md-just-icon md-round modal-default-button"
                    @click="classicModalHide"
                  >
                    <md-icon>clear</md-icon>
                  </md-button>
                </template>

                <template slot="body">
                  <p>
                    <ReportView :id="docs[showReport].type" :mode="docs[showReport].mode" :saveMode="true" @saveRep="getReportFromComponent"></ReportView>
                  </p>
                </template>
                <template slot="footer">
                  <md-button
                    class="md-danger md-simple"
                    @click="classicModalHide"
                  >
                    Закрыть
                  </md-button>
                </template>
              </modal>
      <div class="md-layout-item md-size-100 md-padding">
        <md-card>
          <md-card-header class="md-card-header-text md-card-header-blue">
            <div class="card-text">
              <h4 class="title">{{ title }}</h4>
            </div>
          </md-card-header>

          <md-card-content v-show="!getPosition">
            <div class="md-layout md-gutter">
              <div class="md-layout-item">
                <md-field>
                  <label for="year">Год</label>
                  <md-select v-model="year" name="year" id="year">
                    <md-option :value="`202${y}`" v-for="y in 5" :key="y">{{
                        `202${y}`
                    }}</md-option>
                  </md-select>
                </md-field>
              </div>
              <div class="md-layout-item">
                <md-field>
                  <label for="kvartal">Квартал</label>
                  <md-select v-model="kvartal" name="kvartal" id="kvartal">
                    <md-option :value="k == 5 ? `Годовой отчет` : `Квартал ${k}`" v-for="k in 5" :key="k">{{
                        k == 5 ? `Годовой отчет` : `Квартал ${k}`
                    }}</md-option>
                  </md-select>
                </md-field>
              </div>
            </div>
            <md-table>
              <md-table-row>
                <md-table-head>Названия документа</md-table-head>
                <md-table-head></md-table-head>
                <md-table-head>Файл</md-table-head>
              </md-table-row>

              <md-table-row v-for="(doc, key) in DocsArray" :key="key">
                <md-table-cell width="40%">{{ doc.title }}</md-table-cell>
                <md-table-cell width="30%">
                  <md-button  v-if="doc.form" @click="classicModalShow(key)" class="md-success">Заполнить</md-button >
                </md-table-cell>
                <md-table-cell width="30%">
                  <template v-if="doc.id != 12 && doc.id != 5">
                    <input :id="`file-upload` + key" type="file" @change="uploadFile(doc)" :ref="doc.type"
                      accept=".pdf, .docx, .doc, .xls, .xlsx" />
                    <label :for="`file-upload` + key">Загрузить файл</label>
                  </template>
                  
                  <!-- <md-field style="width: 50%">
                    <label>{{ doc.title }}</label>
                    <md-file id="file-upload" @change="uploadFile(doc)" :ref="doc.type" accept=".pdf, .docx, .doc, .xls, .xlsx"/>
                  </md-field> -->

                  
                </md-table-cell>
              </md-table-row>
            </md-table>
          </md-card-content>
          <div class="progress-pie-chart" v-bind:class="{ gt50: isActive }" :data-percent="getPercent"
            v-show="getPosition">
            <div class="ppc-progress">
              <div class="ppc-progress-fill" v-bind:style="{ transform: 'rotate(' + test + 'deg)' }"></div>
            </div>
            <div class="ppc-percents">
              <div class="pcc-percents-wrapper">
                <span>{{ getPercent }} %</span>
              </div>
            </div>
          </div>
          <md-card-actions style="border-top: 0px">
            <md-button class="md-success" @click="sendFile">
              Загрузить
            </md-button>
          </md-card-actions>
        </md-card>
      </div>
    </div>
  </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'
import {Modal} from '@/components'
import ReportView from '../Components/ReportView.vue'
export default {
  props: {
    document: Array
  },
  components: {
    Modal,
    ReportView
  },
  computed: {
    ...mapGetters('upload_file', ['getPercent', 'getPosition']),
    DocsArray() {
      if (this.document) {
        return this.docs = this.document
      }
        
      return this.docs
    },
    test() {
      return 360 * this.getPercent / 100;
    },
    isActive() {
      if (this.getPercent > 50)
        return true
      return false
    }
  },
  data: () => ({
    kvartal: null,
    year: null,
    classicModal: false,
    docs: [
      { id: 10, title: 'Приложение 1', value: null, type: 'anex_1', form: true, mode: 'new' },
      { id: 11, title: 'Приложение 2', value: null, type: 'anex_2', form: true, mode: 'new' },
      { id: 12, title: 'Приложение 2-1', value: null, type: 'anex_2_1', form: true, mode: 'new' },
      { id: 5, title: 'Листинговый проспект', value: null, type: 'listing_prospectus', form: true, mode: 'new' },
      { id: 1, title: 'Бухгалтерский баланс', value: null, type: 'balance' },
      { id: 6, title: 'Отчет о финансовых результатах', value: null, type: 'fin_rep' },
      { id: 7, title: 'Отчет о движении денежных средств', value: null, type: 'cash_flow' },
      { id: 8, title: 'Отчет об изменениях в капитале', value: null, type: 'cap_rep' },
      { id: 9, title: 'Сведения о соблюдении экономических нормативов', value: null, type: 'analytics' },
      { id: 3, title: 'Аудиторское заключение', value: null, type: 'auditreport' },
      { id: 4, title: 'Кодекс корпоративного управления', value: null, type: 'corporate' },
    ],
    title: 'Создать отчет',
    showReport: 0,
    report: {
      anex_1: null,
      anex_2: null,
      anex_2_1: null,
      listing_prospectus: null
    }
  }),
  methods: {
    ...mapActions('upload_file', ['uploadFileReport', 'setReport']),
    classicModalHide: function () {
      this.classicModal = false
    },
    classicModalShow(id) {
      this.classicModal = true
      this.showReport = id
    },
    uploadFile({ type }) {
      for (let i = 0; i < this.docs.length; i++) {
        if (this.docs[i].type == type) {
          this.docs[i].value = this.$refs[type][0].files[0]
        }
      }
    },
    async sendFile() {
      if (this.kvartal && this.year) {
        const formData = new FormData()
        for (let i = 0; i < this.docs.length; i++) {
          if (this.docs[i].value != null) {
            formData.append(this.docs[i].type, this.docs[i].value)
            formData.append(this.docs[i].type, this.docs[i].title)
          }
        }
        formData.append('sender', localStorage.getItem('login'))
        formData.append('typedoc', this.title)
        formData.append('kvartal', this.kvartal)
        formData.append('year', this.year)
        formData.append('report', JSON.stringify(this.report))
        this.progressInfos = 0;
        const res = await this.uploadFileReport(formData)
        if (res.status == 200) {
          this.$router.push('/' + this.$i18n.locale + '/dashboard/reports')
        } else {
          console.log('Загрузка файла не удалась')
        }
        // for (var value of formData.values()) {
        //   console.log(value);
        // }
      } else {
        alert('Укажите год и квартал для отчета')
      }
    },
    getReportFromComponent(e) {
      console.log(e)
      if (e.typedoc == 'anex_1') {
        this.docs[0].mode = 'modal';
        this.setReport({type: 'anex_1', doc: e})
        this.report.anex_1 = e
      } else if (e.typedoc == 'anex_2') {
        this.docs[1].mode = 'modal';
        this.setReport({type: 'anex_2', doc: e})
        this.report.anex_2 = e
      } else if (e.typedoc == 'listing_prospectus') {
        this.docs[3].mode = 'modal';
        this.setReport({type: 'listing_prospectus', doc: e})
        this.report.listing_prospectus = e
      } else if (e.typedoc == 'anex_2_1') {
        this.docs[2].mode = 'modal';
        this.setReport({type: 'anex_2_1', doc: e})
        this.report.anex_2_1 = e
      }
      this.classicModal = false
    }
  }
}
</script>

<style scoped>

.modal-container {
  max-width: 70%;
}
.progress-pie-chart {
  width: 200px;
  height: 200px;
  border-radius: 50%;
  background-color: #E5E5E5;
  position: relative;
}

.progress-pie-chart.gt50 {
  background-color: #4baf51;
}

.ppc-progress {
  content: "";
  position: absolute;
  border-radius: 50%;
  left: calc(50% - 100px);
  top: calc(50% - 100px);
  width: 200px;
  height: 200px;
  clip: rect(0, 200px, 200px, 100px);
}

.ppc-progress .ppc-progress-fill {
  content: "";
  position: absolute;
  border-radius: 50%;
  left: calc(50% - 100px);
  top: calc(50% - 100px);
  width: 200px;
  height: 200px;
  clip: rect(0, 100px, 200px, 0);
  background: #4baf51;
  transform: rotate(60deg);
}

.gt50 .ppc-progress {
  clip: rect(0, 100px, 200px, 0);
}

.gt50 .ppc-progress .ppc-progress-fill {
  clip: rect(0, 200px, 200px, 100px);
  background: #E5E5E5;
}

.ppc-percents {
  content: "";
  position: absolute;
  border-radius: 50%;
  left: calc(50% - 173.9130434783px/2);
  top: calc(50% - 173.9130434783px/2);
  width: 173.9130434783px;
  height: 173.9130434783px;
  background: #fff;
  text-align: center;
  display: table;
}

.ppc-percents span {
  display: block;
  font-size: 2.6em;
  font-weight: bold;
  color: #4baf51;
}

.pcc-percents-wrapper {
  display: table-cell;
  vertical-align: middle;
}


.progress-pie-chart {
  margin: 50px auto 0;
}

.md-success {
  width: 150px;
  height: 30px;
  font-size: 13px;
  border-radius: 10px;
}
</style>
