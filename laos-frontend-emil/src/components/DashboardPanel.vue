<template>
  <div>
    <div class='md-layout'>
      <div v-for='(panel,p_index) of panel_data'
           :key='p_index'
           :class='`md-medium-size-${panel.width}`'
           class='md-layout-item md-xsmall-size-100'>
        <div class='md-layout '>
          <div
              v-for='(item, i_index) in panel.items'
              :key='i_index'
              :class='`md-medium-size-${item.width} md-size-${item.width}`'
              class='md-layout-item  md-xsmall-size-100'
          >
            <template v-if="item.type==='card'">
              <stats-card :header-color='item.content.color'>
                <template slot='header'>
                  <div class='card-icon'>
                    <md-icon>{{ item.content.icon }}</md-icon>
                  </div>
                  <p class='category'>{{ $t(item.content.text) }}</p>
                  <h3 class='title'>
                    <animated-number :value='item.content.value'></animated-number>
                  </h3>
                </template>
                <template slot='footer'>
                  <div class='stats'>
                    {{ $t(item['sub-text']) }}
                  </div>
                </template>
              </stats-card>
            </template>
            <template v-else-if="item.type==='chart'">
              <chart-card
                  ref='chartcard'
                  :background-color='item.content.color'
                  :chart-data='{
                labels: item.content.data.labels.map((label) =>  $t(label)),
                series: item.content.data.series.map((ser) => {
                  return Array.isArray(ser)
                    ? ser.map((el) => {
                        return {
                          ...el,
                          meta: tranformMeta(el.meta)
                        }
                      })
                    : {
                        ...ser,
                        meta: tranformMeta(ser.meta)
                      }
                })
              }'
                  :chart-options="{
                ...item.content.options,
                labelInterpolationFnc: function (value) {
                  return value === 0 ? '' : value;
                },
                height: item.content.height? item.content.height:'300px',
                plugins: [
                  $Chartist.plugins.tooltip({
                    tooltipOffset: {x: -10, y: -22},
                    anchorToPoint: false,
                    currency:true,
                    tooltipFnc: function(meta, value) {
                      const oMeta = JSON.parse(meta)
                      return `${$t(oMeta.data.title)}: ${value}`
                    }
                  }),
                  $Chartist.plugins.ctAxisTitle({
                    axisX: {
                      axisTitle: getAxisXTitle(item.content.options),
                      axisClass: 'ct-axis-title',
                      offset: {
                        x: 0,
                        y: 33
                      },
                      textAnchor: 'middle'
                    },
                    axisY: {
                      axisTitle: getAxisYTitle(item.content.options),
                      axisClass: 'ct-axis-title',
                      offset: {
                        x: 0,
                        y: 11
                      },
                      textAnchor: 'middle',
                      flipTitle: true
                    }
                  })
                ]
              }"
                  :chart-type='
                item.content.type.charAt(0).toUpperCase() + item.content.type.slice(1)
              '
                  :distributeSeries='true'
                  :no-footer='item.content.hasFooter==100000'
                  chart-inside-content
                  header-animation='false'
                  header-icon
              >
                <template slot='chartInsideHeader'>
                  <div class='card-icon'>
                    <md-icon>{{ item.content.icon }}</md-icon>
                  </div>
                  <h4 class='title'>
                    {{ $t(item.content.title) }}
                  </h4>
                </template>
                <template slot='footer'>
                  <div class='md-layout'>
                    <div v-if='item.content.options.legend.title' class='md-layout-item md-size-100'>
                      <h6 class='category'>{{ $t('graph.legend') }}</h6>
                    </div>
                    <template v-if='item.content.options.legend.items'>
                      <div
                          v-for='(elem) in item.content.options.legend.items'
                          :key='elem.name'
                          class='md-layout-item legend-label md-medium-size-30 md-small-size-100'
                      >
                        <i
                            :class='elem.icon_class'
                            :style='{color:elem.color}'

                        ></i>
                        {{ $t(elem.name) }}
                      </div>
                    </template>
                  </div>
                </template>
              </chart-card>
            </template>

          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import './ChartistPlugin/chartist-plugin-tooltip'
import './ChartistPlugin/chartist-plugin-axistitle'

import {AnimatedNumber, ChartCard, StatsCard} from '@/components'
import {mapState} from 'vuex'

export default {
  components: {
    StatsCard,
    AnimatedNumber,
    ChartCard
  },

  data() {
    return {
      items: [],
      chartLegendColor: [
        'text-info',
        'text-danger',
        'text-warning',
        'text-primary',
        'text-success'
      ]
    }
  },
  watch: {
    locale_active() {
      this.$nextTick(() => {
        this.$refs.chartcard.forEach((graph, index) => {
          graph['chart-data'] = {
            labels: this.panel_graphs[index].data.labels.map((label) =>
                this.$t(label)
            )
          }
          graph.updateChart()
        })
      })
    }
  },
  methods: {
    getAxisXTitle(options) {
      let title = ''
      if (options.axisX && options.axisX.title) {
        title = options.axisX.title
      }
      return this.$t(title)
    },
    getAxisYTitle(options) {
      let title = ''
      if (options.axisY && options.axisY.title) {
        title = options.axisY.title
      }
      return this.$t(title)
    },
    tranformMeta(meta) {
      return typeof meta === 'object'
          ? {...meta, title: this.$t(meta.title)}
          : {title: this.$t(meta)}
    }
    ,
    getMetaColor(meta) {
      return typeof meta === 'object' && meta.color ? meta.color : false
    }
    ,
    popupFormat() {
      return '<p>{{title}}: {{value}}</p>'
    }
  },
  created() {
    //console.log(this.$Chartist.plugins)
  }
  ,
  computed: {
    chart_data() {
      return []
    }
    ,
    ...mapState({
      panel_data: (state) => state.Kpi.panel_data,
      locale_active: (state) => state.i18nStore.active
    }),

    panel_cards() {
      return this.panel_data['dashboard-cards']
    }
    ,
    panel_graphs() {
      return this.panel_data['dashboard-graphs']
    }
  }
}
</script>
<style lang='scss'>
@import '~@/assets/scss/md/_colors.scss';
@import './ChartistPlugin/chartist-plugin-tooltip.css';

p.category {
  min-height: 4rem;
}

.legend-label {
  i:first-child {
    padding-left: 0;
  }

  i {
    padding-left: 10px;
  }
}

.fill-great-color {
  fill: #58A942;
  color: #58A942;
}

.fill-good-color {
  fill: #9FFD65;
  color: #9FFD65
}

.fill-fear-color {
  fill: #FBFF03;
  color: #FBFF03
}

.fill-poor-color {
  fill: #F6BE4F;
  color: #F6BE4F
}

.fill-very-poor-color {
  fill: #FF0000;
  color: #FF0000;
}

.missing-color{
  fill: #EBEBEB;
  color: #EBEBEB;
}


.stroke-great-color {
  stroke: #58A942
}

.stroke-good-color {
  stroke: #9FFD65
}

.stroke-fear-color {
  stroke: #FBFF03
}

.stroke-poor-color {
  stroke: #F6BE4F
}

.stroke-very-poor-color {
  stroke: #FF0000
}


.my-custom-class-one {
  stroke: white;
  stroke-width: 2;
}

svg.ct-chart-bar, svg.ct-chart-line {
  overflow: visible;
}

.rotated .ct-label.ct-horizontal.ct-end {
  position: relative;
  justify-content: flex-end;
  text-align: right;
  transform-origin: 100% 0;
  transform: translate(-50%) rotate(-45deg);
  white-space: normal;
  word-wrap: break-word;
}

.left-minus-15 .ct-label.ct-horizontal.ct-end {
  left: -15px
}

//.ct-label.ct-horizontal {
//  position: relative;
//  transform: rotate(45deg);
//  transform-origin: left top;
//}

.ct-axis-title {
  stroke: #4b4b4b;
  stroke-width: 0.5;
  fill: none;
}

</style>
