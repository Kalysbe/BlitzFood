<template>
  <div class="md-layout">
    <div class="md-layout-item">
      <md-card>
        <md-card-content>
          <h3>Open Information System</h3>
          <img v-bind:src="'/img/7.png'" />
        </md-card-content>
      </md-card>
    </div>
  </div>
</template>

<script>
import {} from '@/components'
import Content from './Layout/Content.vue'
import {mapActions} from 'vuex'

export default {
  components: {
    Content
  },
  data() {
    return {
      product1: '/img/card-2.jpg',
      product2: '/img/card-3.jpg',
      product3: '/img/card-1.jpg',
      seq2: 0,
      mapData: {
        AU: 760,
        BR: 550,
        CA: 120,
        DE: 1300,
        FR: 540,
        GB: 690,
        GE: 200,
        IN: 200,
        RO: 600,
        RU: 300,
        US: 2920
      },
      dailySalesChart: {
        data: {
          labels: ['M', 'T', 'W', 'T', 'F', 'S', 'S'],
          series: [[12, 17, 7, 17, 23, 18, 38]]
        },
        options: {
          lineSmooth: this.$Chartist.Interpolation.cardinal({
            tension: 0
          }),
          low: 0,
          high: 50, // creative tim: we recommend you to set the high sa the biggest value + something for a better look
          chartPadding: {
            top: 0,
            right: 0,
            bottom: 0,
            left: 0
          }
        }
      },
      dataCompletedTasksChart: {
        data: {
          labels: ['12am', '3pm', '6pm', '9pm', '12pm', '3am', '6am', '9am'],
          series: [[230, 750, 450, 300, 280, 240, 200, 190]]
        },

        options: {
          lineSmooth: this.$Chartist.Interpolation.cardinal({
            tension: 0
          }),
          low: 0,
          high: 1000, // creative tim: we recommend you to set the high sa the biggest value + something for a better look
          chartPadding: {
            top: 0,
            right: 0,
            bottom: 0,
            left: 0
          }
        }
      },
      emailsSubscriptionChart: {
        data: {
          labels: [
            'Ja',
            'Fe',
            'Ma',
            'Ap',
            'Mai',
            'Ju',
            'Jul',
            'Au',
            'Se',
            'Oc',
            'No',
            'De'
          ],
          series: [[542, 443, 320, 780, 553, 453, 326, 434, 568, 610, 756, 895]]
        },
        options: {
          axisX: {
            showGrid: false
          },
          low: 0,
          high: 1000,
          chartPadding: {
            top: 0,
            right: 5,
            bottom: 0,
            left: 0
          }
        },
        responsiveOptions: [
          [
            'screen and (max-width: 640px)',
            {
              seriesBarDistance: 5,
              axisX: {
                labelInterpolationFnc: function (value) {
                  return value[0]
                }
              }
            }
          ]
        ]
      }
    }
  },
  methods: {
    ...mapActions('auth', ['GET_ME'])
  },
  mounted() {
    
  }

}
</script>
