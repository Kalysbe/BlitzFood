/**
 * Chartist.js plugin to display a data label on top of the points in a line chart.
 *
 */
// global Chartist */

import Chartist from 'chartist'

(function (window, document, Chartist) {
    'use strict'
    var defaultOptions = {}

    Chartist.plugins = Chartist.plugins || {}
    // eslint-disable-next-line no-unused-vars
    Chartist.plugins.ctBackground = function (options) {
        options = Chartist.extend({}, defaultOptions, options)

        return function ctBackground(chart) {
            chart.on('created', function (data) {
                //const $chart = chart.container

                let heightAccum = 0
                const {backgroundLevels = []} = data.options
                if (backgroundLevels.length > 0) {
                    backgroundLevels
                        .sort(function (a, b) {
                            if (a.min > b.min) {
                                return 1
                            }
                            if (a.min < b.min) {
                                return -1
                            }
                            return 0
                        })
                        .forEach((item, index) => {
                            const {min, max, colour} = item
                            const maxVal =
                                index === backgroundLevels.length - 1
                                    ? data.options.axisY.high
                                    : max
                            const linePosx = data.chartRect.x1

                            const h =
                                data.axisY.projectValue(maxVal) - data.axisY.projectValue(min)

                            const linePosy = data.chartRect.y1 - (h + heightAccum)

                            data.svg.elem(
                                'rect',
                                {
                                    x: linePosx,
                                    y: linePosy,
                                    width: data.chartRect.x2 - data.chartRect.x1,
                                    height: h,
                                    style: `fill:${colour};fill-opacity:0.3`
                                },
                                '',
                                true
                            )
                            heightAccum += h
                        })
                } else {
                    heightAccum = data.axisY.projectValue(data.options.axisY.high)
                }
            })
        }
    }
})(window, document, Chartist)
