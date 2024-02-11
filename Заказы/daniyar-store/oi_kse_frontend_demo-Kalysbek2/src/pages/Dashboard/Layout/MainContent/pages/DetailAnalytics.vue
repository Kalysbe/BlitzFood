<template>
<div v-if="analyticsById">
  <h3 v-for="item in analyticsById" :key="item.key">
      <b> {{item.title}}</b>
  </h3> 
  <div id="mainAnalytics">
        
  </div>
</div>
</template>

<script>
import {mapActions} from 'vuex'
export default {
    data: () => ({
        res:{},
        analyticsById:[],
        detainAnalyticsPage:'',
        newSrc:'',
        headlines:'',
        AnalyticsInfo:''
    }), 
methods: {
    ...mapActions('company',['GET_ANALYTICS_BY_ID']),
    parseToHtml() {
        document.getElementById("mainAnalytics").innerHTML = this.analyticsById[0].text
        this.AnalyticsInfo = document.getElementById("mainAnalytics")
        this.newSrc = this.AnalyticsInfo.getElementsByTagName('img')
        for(let i = 0;i < this.newSrc.length;i++) {  
            this.newSrc[i].setAttribute('src','https://www.kse.kg' +this.newSrc[i].getAttribute('src'))
        }
        this.AnalyticsInfo.querySelectorAll('h3,h4').forEach((element) => {
            element.style.color = "#42a5af"
            element.style.margin = "0px"  
        });
         this.AnalyticsInfo.querySelectorAll('p').forEach((element) => {
            element.style.margin = "0px"
        });
    }
},
  async mounted() {
      this.res = await this.GET_ANALYTICS_BY_ID(this.$route.params.id)
      this.analyticsById = this.res.data
      this.parseToHtml()
  }

}
</script>

<style scoped>
 
</style>