<template>
  <div>
    <div class="md-layout report-types">
      <div class="md-layout-item">
        <md-field>
          <label for="tileType">{{ $t('report.reportTypes') }}</label>
          <md-select
              :value="reportType"
              @md-selected="onReportTypesChanged"
              name="reportType"
              id="reportType"
          >
            <md-option
                v-for="report of reportTypes"
                :key="report.key"
                :value="report.key"
            >
              {{ $t(report.value) }}
            </md-option>
          </md-select>
        </md-field>
      </div>
    </div>
    <ReportTable
        v-if="isShowReportTable"
        :isReportDataLoading="isReportDataLoading"
        :reportName="selectedReportName"
    ></ReportTable>
  </div>
</template>
<script>
import {ReportTable} from '@/components/viewReport'

export default {
  name: 'contracts-reports',
  components: {ReportTable},

  data() {
    return {
      reportTypes: [],
      isReportDataLoading: true,
    }
  },
  props: {
    reportType: {type: String}
  },
  watch: {
    reportType(newVal){
      if (newVal !== 'list') {
        this.loadReportData(this.reportType)
      }
    },
  },

  async created() {
    await this.loadReportsList()
    if (this.reportType !== 'list') {
      await this.loadReportData(this.reportType)
    }
  },
  methods: {
    async loadReportsList() {
      try {
        // TODO add real list downloading
        const list = [] //await this.$store.dispatch('LOAD_REPORTS_LIST')
        this.reportTypes = [...list]
      } catch (err) {
      } finally {
      }
    },
    async loadReportData(type) {
      this.isReportDataLoading = true
      try {
        await this.$store.dispatch('LOAD_REPORT_DATA', {type})
      } finally {
        this.isReportDataLoading = false
      }
    },
    onReportTypesChanged(type) {
      const rType = type === 'none' ? 'list' : type
      this.$router.push({name: 'contracts-reports', params: {reportType: rType}})
    }
  },
  computed: {
    selectedReportType() {
      return this.reportType === 'list' ? 'none' : this.reportType
    },
    isShowReportTable() {
      return this.reportType !== 'list'
    },
    selectedReportName() {
      const report = this.reportTypes.find(
          (type) => type.key === this.selectedReportType
      )
      return report ? report.value : ''
    }
  }
}
</script>
<style lang="scss">
.report-types {
  max-width: 500px;
}
</style>
