<template>
<div class="md-layout">
  <div class="md-layout-item md-size-100">
     <h1 class="title-analytics">{{$t('pageAnalytics.title')}}</h1>
  </div>
<div class="md-layout-item md-size-100">
    <md-table v-model="analyticsList">
      <md-table-row slot="md-table-row" slot-scope="{ item }" class="analytics-list">
        <md-table-cell :md-label="$t('pageDetailCompanyReport.dateDocument')">
          {{item.cr_date}}
        </md-table-cell>
        <md-table-cell @click.native="viewAnalytics(item.blog_id)" class="analytic-name" :md-label="$t('pageDetailCompanyReport.nameDocument')">
            {{item.title}}
        </md-table-cell>
      </md-table-row> 
    </md-table>
</div>
</div>
</template>

<script>
  import {mapActions} from 'vuex'
  export default {
      name: 'locale-changer',
    data() {
    return {
      user: '',
      res:[], 
      analyticsList:[]
    }
  },
  methods: {
    clicked: function (e) {
      e.preventDefault()
    },
    toggleMenu: function () {
      this.isClosed = !this.isClosed
    },
    ...mapActions('company',['GET_ANALYTICS_LIST']),
      viewAnalytics(id) {
       let OpenAnalytic = this.$router.resolve({
        path: 'analytics/detailanalytics/' + id
      })
      window.open(OpenAnalytic.href, '_blank')
    },
  },

  async mounted() {
      this.res = await this.GET_ANALYTICS_LIST()
      this.analyticsList = this.res.data
  }

  }
</script>

<style lang="scss" scoped>
.analytic-name {
  color:#42a5af;
  cursor:pointer;
}
.analytic-name:hover {
  color:gray;
}
.title-analytics {
  font-size: 32px;
  color: #42a5af;
  margin-bottom: 10px;
  padding: 0px;
}
</style>