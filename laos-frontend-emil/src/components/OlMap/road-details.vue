<template>
  <div class="road-details-chart" @click="onClick">
    <transition name="fade">
      <div v-if="vectorData.length === 0" class="chart-load-progress">
        <md-progress-bar
          md-mode="indeterminate"
          class="progress-bar"
        ></md-progress-bar>
      </div>
    </transition>
    <div
      id="road-chart"
      class="ct-chart"
      ref="chartNode"
      :class="[vectorData.length === 0 ? 'hidden-chart' : 'showed-chart']"
    ></div>
  </div>
</template>

<script>
import './chartistLabelPlugin'
import './chartistBackgroundPlugin'

export default {
  name: 'road-details-page',
  props: {
    vectorDetails: {type: Object, default: () => {}},
    vectorData: {type: Array, default: () => []},
    mapHighlightedFeatureItem: {type: Object}
  },
  data() {
    return {
      measureFieldId: 1,
      dimensionFieldId: 2,

      chartData: {
        labels: [],
        series: []
      },
      chartOptions: {
        backgroundLevels: {},
        vectorName: '',
        width: '100%',
        height: '245px',
        showArea: false,
        showLine: true,
        showPoint: true,
        fullWidth: true,
        axisX: {
          showLabel: true,
          showGrid: false,
          offset: 60
        },

        axisY: {
          onlyInteger: true,
          labelOffset: {
            x: 0,
            y: 7
          },
          high: 0,
          showGrid: true,
          type: this.$Chartist.FixedScaleAxis,
          ticks: []
        },
        chartPadding: {
          right: 0,
          left: 0,
          bottom: 0
        },
        lineSmooth: this.$Chartist.Interpolation.simple({
          divisor: 3
        })
      },
      roadChartInst: undefined,
      chartBackgroundLevels: []
    }
  },
  created() {
    this.updateChartOptions()
  },
  mounted() {
    console.log('mounted!')
    this.initChart()
  },

  methods: {
    updateChartOptions() {
      const {graph = {}} = this.vectorDetails

      const {
        variable_x_id: measureFieldId = 1,
        variable_y_id: dimensionFieldId = 2,
        min_height: chartLow = 0,
        max_height: chartHigh = 0,
        levels: backgroundStyle = [],
        ticks: chartTicks = []
      } = graph

      this.measureFieldId = measureFieldId
      this.dimensionFieldId = dimensionFieldId
      this.chartLow = chartLow
      this.chartHigh = chartHigh
      this.chartTicks = chartTicks
      this.chartBackgroundLevels = [...backgroundStyle]
    },
    metaInfo: (text, values) => {
      let result = text
      values.forEach((value, index) => {
        result = result.replace(`%${index}`, value)
      })
      return result
    },

    onClick() {
      this.roadChartInst.eventEmitter.emit('onActivePoint', '0-202')
    },

    handlerSelectFeature(pointdata) {
      const {
        feature_data,
        feature_id,
        localisation,
        section_id = null
      } = pointdata
      this.$emit('setHighlightedFeatureItem', {
        feature_data,
        feature_id,
        localisation,
        section_id
      })
    },

    initChart() {
      const divNode = this.$refs.chartNode

      this.roadChartInst = this.$Chartist.Line(divNode, this.chartData, {
        ...this.chartOptions,
        plugins: [
          //
          this.$Chartist.plugins.ctPointLabels({
            vectorName: this.vectorName.toUpperCase()
          }),
          this.$Chartist.plugins.ctBackground({})
        ]
      })

      this.roadChartInst.on('selectfeature', this.handlerSelectFeature)

      this.roadChartInst.on('created', function(data) {
        const heightAccum = data.axisY.projectValue(data.options.axisY.high)
        data.svg.elem('rect', {
          class: 'rect-data-area',
          x: data.chartRect.x1,
          y: data.chartRect.y1 - heightAccum,
          width: data.chartRect.x2 - data.chartRect.x1,
          height: heightAccum,
          style: `fill-opacity:0`
        })
      })
    },
    async updateChartData() {
      console.time('updateChartData-data-prep')
      const data = this.roadProps.map((prop) => {
        return !Array.isArray(prop.feature_data[this.measureFieldId])
          ? {
              value: prop.feature_data[this.dimensionFieldId],
              meta: {
                ...prop,
                measure: prop.feature_data[this.measureFieldId],
                val: prop.feature_data[this.dimensionFieldId],
                info: this.metaInfo(
                  `${this.$t(
                    prop.localisation[this.measureFieldId]
                  )}: %0, ${this.$t(
                    prop.localisation[this.dimensionFieldId]
                  )}: %1`,
                  [
                    prop.feature_data[this.measureFieldId],
                    prop.feature_data[this.dimensionFieldId]
                  ]
                )
              }
            }
          : prop.feature_data[this.measureFieldId].map((item, index) => {
              const {feature_id, localisation} = prop
              return {
                value: 1,
                meta: {
                  feature_id,
                  localisation,
                  feature_data: prop.feature_data.map((elem) =>
                    Array.isArray(elem) ? elem[index] : elem
                  ),
                  measure: item,
                  section_id: index,
                  val: 1,
                  info: this.metaInfo(
                    `${this.$t(prop.localisation[this.measureFieldId])}: %0`,
                    [item]
                  )
                }
              }
            })
      })
      console.timeEnd('updateChartData-data-prep')
      console.time('updateChartData-series')
      this.chartData.series = [{data: data.flat()}]
      console.timeEnd('updateChartData-series')
      console.time('updateChartData-labels')
      const labels = this.roadProps
        .map((prop) => {
          return !Array.isArray(prop.feature_data[this.measureFieldId])
            ? prop.feature_data[this.measureFieldId]
            : [...prop.feature_data[this.measureFieldId]]
        })
        .flat()

      const propsLength = labels.length
      const labelCount = Math.round(propsLength / 8 /*axisY point*/)

      this.chartData.labels = [
        ...labels.map((label, index) => {
          return index === propsLength - 1 ||
            (index % labelCount === 0 && index < propsLength - labelCount / 2)
            ? label.toString().split('-')[0]
            : ''
        })
      ]
      console.timeEnd('updateChartData-labels')
      const maxAxisValue =
        this.chartHigh === 0
          ? this.roadProps.reduce((accum, currVal) => {
              if (accum < currVal[1]) {
                accum = currVal[1]
              }
            }, 0)
          : this.chartHigh

      this.chartOptions.high = maxAxisValue

      this.chartOptions.low = this.chartLow
      this.chartOptions.axisY.low = this.chartLow
      this.chartOptions.axisY.high = maxAxisValue

      if (this.chartTicks.length > 0) {
        this.chartOptions.axisY.type = this.$Chartist.FixedScaleAxis
        this.chartOptions.axisY.ticks = [...this.chartTicks]
      } else {
        this.chartOptions.axisY.type = undefined
      }
      this.chartOptions.backgroundLevels = this.chartBackgroundLevels
      this.chartOptions.vectorName = this.vectorName
      console.time('updateChartData-update')
      await this.roadChartInst.update(this.chartData, this.chartOptions)
      console.timeEnd('updateChartData-update')
    }
  },
  watch: {
    mapHighlightedFeatureItem(newVal) {
      if (!newVal) {
        return
      }
      const {feature_data} = newVal
      this.roadChartInst.eventEmitter.emit('onActivePoint', feature_data[1])
    },
    async vectorData(newVal) {
      if (newVal.length > 0) {
        this.updateChartData()
      }
    },

    vectorName() {
      this.updateChartOptions()
    }
  },
  computed: {
    vectorName() {
      const {key} = this.vectorDetails
      return key
    },
    roadProps() {
      const vectors = [...this.vectorData]
      return vectors.sort(function(a, b) {
        return a.feature_data[1].split('-')[0] - b.feature_data[1].split('-')[0]
      })
    },
    roadName() {
      return this.roadProps ? this.roadProps[0] : ''
    },
    roadData() {
      return this.roadProps ? this.roadProps[1] : []
    }
  }
}
</script>
<style lang="scss">
@import '@/assets/scss/md/_colors';

.road-details-chart {
  padding-top: 5px;
  position: relative;

  .chart-load-progress {
    position: absolute;
    width: 100%;
    /* height: 100%; */
    top: 5px;
    display: flex;
    flex-direction: column;
    align-items: center;
    .progress-bar {
      width: 100%;
    }
  }

  .ct-chart {
    .ct-series-a .ct-line {
      stroke: #263238;
      stroke-width: 1px;
      fill: transparent;
      cursor: pointer;
    }

    .rect-data-area {
    }

    .ct-series-a .ct-point {
      /* Colour of your points */
      stroke: $blue-900; // #428bca;
      stroke-width: 10px;
      opacity: 0;
    }

    .point-text {
      paint-order: stroke;
      stroke: #000000;
      stroke-width: 1px;
      stroke-linecap: butt;
      stroke-linejoin: miter;

      fill: $blue-900;
    }

    .ct-label.ct-label.ct-horizontal.ct-end {
      position: relative;
      justify-content: flex-end;
      text-align: right;
      transform-origin: 100% 0;
      transform: translate(-100%) rotate(-45deg);
      white-space: nowrap;
    }

    .point-label-box {
      //#fff transparent;
      fill: #ffffff;
      opacity: 0.85;
    }
  }
}

.hidden-chart {
  opacity: 0;
}
.showed-chart {
  opacity: 1;
}

.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.7s;
}
.fade-enter,
.fade-leave-to {
  opacity: 0;
}
</style>
