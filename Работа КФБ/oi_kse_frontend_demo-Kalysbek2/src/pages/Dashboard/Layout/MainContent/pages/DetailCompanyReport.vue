<template>
<div v-if="reportsByType && reportsByType.length"  class="section-document toggle-section">
            <div width="100%" style="width: 100%">
              <a
                data-toggle="collapse"
                :aria-expanded="!isClosedDocument"
                @click.stop="toggleDocument"
                @click.capture="clicked"
              >
                <span
                  style="
                    width: 100%;
                    display: flex;
                    justify-content: space-between;
                    cursor: pointer;
                  "
                >
                  <h3>{{type == 1 ? $t('pageDetailCompanyReport.documents') : $t('pageDetailCompanyReport.news')}} ({{reportsByType.length}})</h3>
                  <h3 style="border: 1px solid #49b9c4; border-radius: 100%">
                    <md-icon
                      class="caret material-icons"
                      style="width: 40px; height: 40px; color: #49b9c4"
                      >keyboard_arrow_down</md-icon
                    >
                  </h3>
                </span>
              </a>
              <collapse-transition>
                <div v-show="!isClosedDocument">
                  <!-- <div class="select-params">
                    <div>
                      <md-field>
                        <label for="selectDocument">Тип документа:</label>
                        <md-select
                          v-model="selectDocument"
                       
                          name="selectDocument"
                          id="selectDocument"
                          md-dense
                        >
                          <md-option class="md-info" value="1"
                            >Квартальный отчет</md-option
                          >
                          <md-option value="2">Существенный факт</md-option>
                        </md-select>
                      </md-field>
                    </div>
                  </div> -->

                 <md-table v-model="reportsByType">
                    <md-table-row slot="md-table-row" slot-scope="{ item }">
                      <md-table-cell  :md-label="$t('pageDetailCompanyReport.dateDocument')">{{
                        getDate(item.confirmdate)
                      }}</md-table-cell>
                      <md-table-cell
                        class="md-primary clip"
                        :md-label="$t('pageDetailCompanyReport.nameDocument')">
                        <span @click="ReportView(item.id)" class="md-primary" style="color: #42a5af">{{
                          item.typedoc
                        }}</span></md-table-cell>
                    </md-table-row>
      </md-table>
                </div>
              </collapse-transition>
            </div>
          </div>
      
</template>

<script>
import {mapActions, mapGetters} from 'vuex'
import ReportsVue from '../../../Pages/Reports.vue'
import {CollapseTransition} from 'vue2-transitions'

export default {
props: ["type"],
data: () => ({
     
    expandSingle: false,
    isClosedDocument: true,
  }),
  methods: {
    ...mapActions('company', [
      'GET_COMPANY_BYID',
      'GET_COMPANY_REPORTS',
    ]),
    getReports(type) {
      this.GET_COMPANY_REPORTS({kod: this.$route.params.kod , type})
    },
    ReportView(id) {
      let OpenReport = this.$router.resolve({
        path: 'report/' + id
      })
      window.open(OpenReport.href, '_blank')
    },
    clicked: function (e) {
      e.preventDefault()
    },
 toggleDocument: function () {
      this.isClosedDocument = !this.isClosedDocument
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
    }
  },
  computed: {
    ...mapGetters('company', [
      'getCompanyById',
      'getCompanyReports',
    ]),
    reportsByType(){
        if(this.type == 1){
            return this.getCompanyReports.kvar
        }else {
            return this.getCompanyReports.news
        }
    }
    
  },
  mounted() {
    this.getReports(this.type)
  },
    components: {
        CollapseTransition
    }
}
</script>

<style lang="scss" scoped>
.clip {
  cursor: pointer;
}
</style>