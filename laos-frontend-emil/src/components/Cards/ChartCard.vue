<template>
  <md-card
      :data-count="hoverCount"
      class="md-card-chart"
      @mouseleave.native="onMouseLeave"
  >
    <md-card-header
        :class="[
        { hovered: imgHovered },
        { hinge: headerDown },
        { fadeInDown: fixedHeader },
        { animated: true },
        { [getClass(backgroundColor)]: true },
        { 'md-card-header-text': HeaderText },
        { 'md-card-header-icon': HeaderIcon }
      ]"
        :data-header-animation="headerAnimation"
        @mouseenter.native="onMouseOver"
    >
      <div v-if="chartInsideHeader" :id="chartId" class="ct-chart"></div>
      <slot name="chartInsideHeader"></slot>
    </md-card-header>

    <md-card-content>
      <div v-if="chartInsideContent" :id="chartId" class="ct-chart"></div>
      <div
          v-if="headerAnimation === 'true'"
          class="md-card-action-buttons text-center"
      >
        <md-button
            v-if="headerDown"
            class="md-danger md-simple fix-broken-card"
            @click="fixHeader"
        >
          <slot name="fixed-button"></slot>
          Fix Header!
        </md-button>
        <slot name="first-button"></slot>
        <slot name="second-button"></slot>
        <slot name="third-button"></slot>
      </div>
      <slot name="content"></slot>
    </md-card-content>

    <md-card-actions class="" v-if="!noFooter" md-alignment="left">
      <slot name="footer"></slot>
    </md-card-actions>
  </md-card>
</template>
<script>
export default {
  name: "chart-card",
  props: {
    HeaderText: Boolean,
    HeaderIcon: Boolean,
    noFooter: {type:Boolean, default:false},
    chartInsideContent: Boolean,
    chartInsideHeader: Boolean,
    chartType: {
      type: String,
      default: "Line" // Line | Pie | Bar
    },
    headerAnimation: {
      type: String,
      default: "true"
    },
    chartOptions: {
      type: Object,
      default: () => {
        return {}
      }
    },
    chartResponsiveOptions: {
      type: Array,
      default: () => {
        return []
      }
    },
    chartAnimation: {
      type: Array,
      default: () => {
        return []
      }
    },
    chartData: {
      type: Object,
      default: () => {
        return {
          labels: [],
          series: []
        }
      }
    },
    backgroundColor: {
      type: String,
      default: ""
    }
  },
  data() {
    return {
      hoverCount: 0,
      imgHovered: false,
      fixedHeader: false,
      chartId: "no-id"
    }
  },
  computed: {
    headerDown() {
      return this.hoverCount > 15
    }
  },
  methods: {
    headerBack: function () {
      this.fixedHeader = false
    },
    fixHeader: function () {
      this.hoverCount = 0
      this.fixedHeader = true

      setTimeout(this.headerBack, 480)
    },
    onMouseOver: function () {
      if (this.headerAnimation === "true") {
        this.imgHovered = true
        this.hoverCount++
      }
    },
    onMouseLeave: function () {
      if (this.headerAnimation === "true") {
        this.imgHovered = false
      }
    },

    getClass: function (backgroundColor) {
      return "md-card-header-" + backgroundColor + ""
    },
    /***
     * Initializes the chart by merging the chart options sent via props and the default chart options
     */
    initChart() {
      let chartIdQuery = `#${this.chartId}`
      this.$Chartist[this.chartType](
          chartIdQuery,
          this.chartData,
          this.chartOptions,
          this.chartAnimation
      ).on('draw', function (data) { // TODO it need transfer to plugin

        if (data.type === 'bar') {
          let elemColor = ""
          if (data.meta && data.meta.color) {
            elemColor = 'stroke:' + data.meta.color
          }
          //data.element.attr({class: ["ct-bar"].join(" ")})
          if (data.meta) {
            data.element.attr({
              style: `stroke-width: ${data.meta.stroke_width ? data.meta.stroke_width : 30}px; ${elemColor}`
            })
          }
        } else if (data.type === 'line' || data.type === 'point') {
          let elemColor = ""
          if (data.meta && data.meta.color) {
            elemColor = 'stroke:' + data.meta.color
          }

          //data.element.attr({class: ["ct-bar"].join(" ")})

          data.element.attr({
            style: `${elemColor}`
          })
        }
      })
    },
    /***
     * Assigns a random id to the chart
     */
    updateChartId() {
      var currentTime = new Date().getTime().toString()
      var randomInt = this.getRandomInt(0, currentTime)
      this.chartId = `div_${randomInt}`
    },
    getRandomInt(min, max) {
      return Math.floor(Math.random() * (max - min + 1)) + min
    }
  },
  mounted() {
    this.updateChartId()
    console.log("noFooter=",this.noFooter)
    this.$nextTick(this.initChart)
  }
}
</script>

<style lang="scss" scoped>
.md-card .md-card-actions {
  min-height: 35px;
}
</style>
