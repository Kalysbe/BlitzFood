<template>
  <div>
    <div class="md-layout">
      <div class="md-layout-item md-size-100 item-back md-padding">
        <div class="md-group">
          <!-- <md-button @click="backToListHandler">
            <span class="md-label">
              <md-icon class="material-icons">keyboard_arrow_left</md-icon>
            </span>
            Назад
          </md-button> -->
          <md-button class="md-primary" @click="printHandler()">
            Сохранить как
          </md-button>
        </div>
      </div>
      <!-- {{getCompanyReportById.f_sign_doc}} -->
      <div
        id="printMe"
        class="md-layout-item md-size-100 md-padding"
        v-if="report"
      >
        <md-card>
          <md-card-header class="md-card-header-text md-card-header-blue">
            <div class="card-text">
              <h4
                v-if="
                  !(report.doc.title == 'Квитанция' || report.doc.title == 'Приложение 2-1')
                "
                class="title"
              >
                {{ report.doc.title }}
              </h4>
            </div>
          </md-card-header>
          <md-card-content>
            <template v-if="report.doc.title == 'Квитанция'">
              <div v-for="(field, key) in report.doc" v-bind:key="key">
                <!-- инпут  -->
                <template v-if="field.element === 'input'">
                  <div class="md-layout md-size-100 custom-md">
                    <template v-if="field.name">
                      <div style="padding-left: 50px; font-size: 14pt">
                        <label>{{ field.name }} {{ field.value }}</label>
                      </div>
                    </template>
                    <template v-else>
                      <label style="padding-left: 50px; font-size: 14pt">
                        {{ field.value }}</label
                      >
                    </template>
                  </div>
                </template>
                <!-- /инпут  -->

                <template v-if="field.element === 'img'">
                  <img
                    v-bind:src="'.' + field.name"
                    style="
                      width: 100%;
                      text-align: center;
                      padding: 15px 15px 80px 0px;
                    "
                  />
                </template>

                <!--  ----------- Изображение печати и подписа ---------- -->
                <!-- <template v-if="field.element === 'stump'">
                  <img
                    v-bind:src="'.' + field.name"
                    class="stump"
                    style="
                      width: 40%;
                      float: right;
                      margin: 1%;
                      padding-top: 200px;
                    "
                  />
                </template> -->
              </div>
              <template v-if="signers.length != 0">
                <div
                  v-for="(signer, i) in signers"
                  :key="i + 'key'"
                  style="
                    flex-direction: column;
                    border: 2px solid grey;
                    margin-left: 50px;
                    margin-top: 28%;
                    padding: 10px;
                    color: grey;
                    display: flex;
                    font-family: 'Andale Mono', monospace;
                    word-wrap: break-word;
                    width: 40%;
                  "
                >
                  <!-- <span>{{signer.token}}</span> -->
                  <span>Подписан ЭЦП: {{ signer.personFio }}</span>
                  <span
                    >Cрок действия ЭЦП: до
                    {{
                      signer.expireAt
                        .slice(0, 10)
                        .split('-')
                        .reverse()
                        .join('-')
                    }}</span
                  >
                </div>
              </template>
            </template>

            <template v-else-if="report.doc.title == 'Приложение 2-1'">
              <!-- парсинг структуры документа -->
              <div v-for="(field, key) in report.doc.fields" v-bind:key="key">
                <!-- заголовок -->
                <template v-if="field.element === 'header'">
                  <h5 style="width: 30%; float: right; margin: auto 0">
                    {{ report.doc.title }}
                  </h5>
                  <br />
                  <p style="width: 30%; float: right">{{ field.name }}</p>
                  <br />
                  <br />
                  <br />
                  <br />
                  <br />
                  <br />
                </template>
                <!-- /заголовок -->
                <!-- селектор -->
                <template
                  v-if="
                    field.element === 'select' &&
                    (!field.id == 'select_quarter' ||
                      !field.id == 'select_report_date')
                  "
                >
                  <div class="md-layout custom-md md-size-30">
                    <label>{{ field.name }} : {{ field.value }} </label>
                  </div>
                </template>
                <template
                  v-else-if="
                    field.element === 'select' && field.id == 'select_quarter'
                  "
                  ><h5>
                    {{ report.doc.fields[key].value }},
                    {{ report.doc.fields[key + 1].value }} года
                  </h5></template
                >

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
                <template v-if="field.element === 'h4' && field.value">
                  <div
                    style="
                      flex-direction: column;
                      width: 60%;
                      border: 2px solid grey;
                      padding: 10px;
                      color: grey;
                      display: flex;
                      font-family: 'Andale Mono', monospace;
                      word-wrap: break-word;
                    "
                  >
                    <!-- <span>{{field.value.token}}</span> -->
                    <!--Токен -->
                    <span>{{ field.name }}: {{ field.value.personFio }}</span>
                    <!-- <span>Cрок действия: {{ field.value.createAt }} до {{ field.value.expireAt }} </span> -->
                    <!--Подробная информация даты отчета-->
                    <span
                      >Cрок действия: до
                      {{
                        field.value.expireAt
                          .slice(0, 10)
                          .split('-')
                          .reverse()
                          .join('-')
                      }}</span
                    >
                  </div>
                </template>

                <template v-else-if="field.element === 'h4'">
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
                <template v-if="field.element === 'span'">
                  <span>{{ field.name }}</span>
                </template>
                <!-- /строки -->
                <!-- инпут  -->
                <template v-if="field.element === 'input'">
                  <div class="md-layout md-size-100 custom-md">
                    <template v-if="field.name">
                      <label>{{ field.name }} : {{ field.value }}</label>
                    </template>
                    <template v-else>
                      <label> {{ field.value }}</label>
                    </template>
                  </div>
                </template>
                <!-- /инпут  -->
                <!-- textarea   -->
                <template v-if="field.element === 'input-text-area'">
                  <div class="md-layout md-size-10 custom-md">
                    <template v-if="field.name">
                      <label>{{ field.name }} : {{ field.value }}</label>
                    </template>
                    <template v-else>
                      <label>{{ field.value }}</label>
                    </template>
                  </div>
                </template>
                <!-- /textarea -->
                <!-- групровые инпуты -->
                <template v-if="field.element === 'group'">
                  <div>
                    <!-- <h4>{{ field.name }}</h4> -->
                    <div
                      v-for="(item, key) in field.items"
                      v-bind:key="key"
                      class="md-layout-item md-size-100"
                    >
                      <label>{{ item.name }} : {{ item.value }}</label>
                    </div>
                  </div>
                </template>
                <!-- /групровые инпуты -->
                <!-- таблицы -->
                <template v-if="field.element === 'table'">
                  <h6 v-if="field.name != ''">{{ field.name }}</h6>
                  <md-table style="border-spacing: 0px" class="md-layout">
                    <md-table-row slot="md-table-header">
                      <template v-for="header in field.headers">
                        <template v-if="header != '*'">
                          <md-table-cell
                            style="border: 1px solid lightgrey"
                            :key="header"
                          >
                            {{ header }}
                          </md-table-cell>
                        </template>

                        <template v-else>
                          <md-table-cell
                            style="border-left: hidden"
                            :key="header"
                          >
                          </md-table-cell>
                        </template>
                      </template>
                    </md-table-row>

                    <md-table-row
                      slot="md-table-row"
                      v-for="(row, key) in field.rows"
                      v-bind:key="key"
                    >
                      <md-table-cell
                        v-for="(cell, key) in row.cells"
                        :key="key"
                        style="
                          border: 1px solid lightgrey;

                          border-spacing: 0px;
                        "
                      >
                        <template v-if="cell.element === 'input'">
                          {{ cell.value }}
                          <!-- <md-field>
                        <md-input disabled type="text" v-model="cell.value"></md-input> 
                        </md-field> -->
                        </template>
                        <template v-else-if="cell.element === 'label-input'">
                          <label class="md-label"
                            >{{ cell.name }} {{ cell.value }}</label
                          >
                        </template>

                        <template v-else>
                          {{ cell.name }}
                        </template>
                      </md-table-cell>
                    </md-table-row>
                  </md-table>
                </template>

                <!-- /таблицы -->
                <!-- изображение -->
                <template v-if="field.element === 'img'">
                  <img
                    v-bind:src="field.name"
                    style="
                      width: 100%;
                      text-align: center;
                      padding: 15px 15px 30px 0px;
                    "
                  />
                </template>

                <!-- /изображение -->
                <!-- /парсинг структуры документа -->
              </div>
            </template>

            <template v-else>
              <!-- парсинг структуры документа -->
              <div>
                <div v-for="(field, key) in report.doc.fields" v-bind:key="key">
                  <template v-if="field.element === 'header'">
                    <h5 style="width: 30%; float: right; margin: auto 0">
                      {{ report.doc.title }}
                    </h5>
                    <br />
                    <p style="width: 30%; float: right">{{ field.name }}</p>
                    <br />
                    <br />
                    <br />
                    <br />
                    <br />
                    <br />
                  </template>
                  <!-- /заголовок -->
                  <!-- селектор -->
                  <template
                    v-if="
                      field.element === 'select' &&
                      (!field.id == 'select_quarter' ||
                        !field.id == 'select_report_date')
                    "
                  >
                    <div class="md-layout custom-md md-size-30">
                      <label>{{ field.name }} : {{ field.value }} </label>
                    </div>
                  </template>
                  <template
                    v-else-if="
                      field.element === 'select' && field.id == 'select_quarter'
                    "
                    ><h5>
                      {{ report.doc.fields[key].value }},
                      {{ report.doc.fields[key + 1].value }} года
                    </h5></template
                  >
                </div>
                <table width="100%" border="1">
                  <template>
                    <tr v-for="(field, key) in report.doc.fields" v-bind:key="key">
                      <td
                        v-if="
                          field.element != 'select' && field.element != 'hide'
                        "
                        width="40%"
                      >
                        {{ field.name }}
                      </td>
                      <td
                        v-if="
                          field.element != 'select' && field.element != 'hide'
                        "
                        width="60%"
                      >
                        {{ field.value }}
                      </td>
                    </tr>
                  </template>
                </table>
              </div>
            </template>
          </md-card-content>
        </md-card>
      </div>
    </div>
  </div>
</template>
<script>
import {mapActions, mapGetters} from 'vuex'
export default {
  data: () => ({
    signers: [],
    report: {}
  }),
  methods: {
    ...mapActions('company', ['GET_COMPANY_REPORT_BY_ID']),
    backToListHandler: function () {
      window.history.back()
    },
    printHandler: function () {
      const localOptions = {
        styles: ['../../../../mycss.css']
      }
      this.$htmlToPaper('printMe', localOptions)
    }
  },
  computed: {
    ...mapGetters('company', ['getCompanyReportById']),
    // doc() {
    //   return this.getCompanyReportById && this.getCompanyReportById.doc
    // }
  },
  async mounted() {
    await this.GET_COMPANY_REPORT_BY_ID(this.$route.params.id)
    console.log(this.getCompanyReportById)
    this.report = Object.assign({}, this.getCompanyReportById, this.$route.params.id)
    if (
      this.getCompanyReportById.f_sign_doc != null &&
      this.getCompanyReportById.typedoc === 'Квитанция'
    ) {
      this.signers.push(this.getCompanyReportById.f_sign_doc)
    } else if (
      this.getCompanyReportById.f_sign_doc != null &&
      this.getCompanyReportById.typedoc != 'Квитанция'
    ) {
      this.getCompanyReportById.doc.fields.push({
        id: 'first_sign',
        name: 'Подписан ЭЦП',
        element: 'h4',
        value: this.getCompanyReportById.f_sign_doc
      })
    }
    console.log('fields', this.report.doc)
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
.md-button {
  @media print {
    display: none;
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

.md-radio + .md-radio-container {
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
// .md-padding{

//   padding:0px 30px 0px 30px;

// }
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

.md-just-icon {
  float: right;
}
.input-custom {
  margin-left: 1rem;
}
.custom-md {
  margin-bottom: 0.5rem;
}

.title {
  @media print {
    color: black;
  }
}

.md-card-header-text {
  color: black;
}
.print-app {
  display: block;
}

.md-field:after,
:before {
  border-bottom: hide;
}
.eee {
  display: flex;
  justify-content: space-between;
  width: 100%;
}
table td {
  border: 1px solid #d3dbdf;
  padding: 10px;
}

table {
  border-collapse: collapse;
}
</style>
