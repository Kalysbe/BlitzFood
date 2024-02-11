/**
 * Chartist.js plugin to display a data label on top of the points in a line chart.
 *
 */
///* global Chartist */

const createSvgElementNS = (type) => {
  return document.createElementNS('http://www.w3.org/2000/svg', type)
}

import Chartist from 'chartist'
;(function(window, document, Chartist) {
  'use strict'
  var defaultOptions = {}

  Chartist.plugins = Chartist.plugins || {}
  Chartist.plugins.ctPointLabels = function(options) {
    const opt = options
    options = Chartist.extend({}, defaultOptions, opt)

    return function ctPointLabels(chart) {
      const div = document.createElement('div')
      div.className = 'crosshairCursor'
      div.style.height = '95%'
      div.style.width = '1px'
      let prevPointSelected = null

      chart.on('created', function(/*data*/) {
        //const $chart = chart.container

        const elem = document.querySelector('.ct-chart-line')
        const dataArea = document.querySelector('.rect-data-area')
        const pointNodes = elem.querySelectorAll('.ct-series .ct-point')
        const points = Array.prototype.slice.call(pointNodes)

        const {x: xa, /*y: ya,*/ height} = dataArea.getBoundingClientRect()
        const dataAreaX = +dataArea.getAttribute('x')
        const dataAreaY = +dataArea.getAttribute('y')
        const dataAreaWidth = +dataArea.getAttribute('width')
        //const dataAreaHeight = +dataArea.getAttribute('height')

        const pointTextGroup = createSvgElementNS('g')
        pointTextGroup.setAttribute('class', 'group-point-text')
        const pointTextMeta = createSvgElementNS('tspan')
        pointTextMeta.setAttribute('class', 'point-text-meta')
        const pointTextData = createSvgElementNS('tspan')
        pointTextData.setAttribute('class', 'point-text-data')

        const pointTextRect = createSvgElementNS('rect')
        pointTextRect.setAttribute('class', 'point-label-box')

        pointTextRect.setAttribute('ry', 5)

        const pointText = createSvgElementNS('text')

        pointText.setAttribute('class', 'point-text')
        pointText.setAttribute('text-anchor', 'left')
        pointText.setAttribute('y', 17)
        pointText.setAttribute('x', 5)

        pointText.setAttribute('alignment-baseline', 'middle')
        pointText.append(pointTextMeta, pointTextData)
        pointTextGroup.append(pointTextRect, pointText)

        const pointerLine = createSvgElementNS('line')
        pointerLine.setAttribute('id', 'line2')
        pointerLine.setAttribute('class', 'crosshairCursor')
        pointerLine.setAttribute('x1', dataAreaX)
        pointerLine.setAttribute('y1', dataAreaY)
        pointerLine.setAttribute('x2', dataAreaX)
        pointerLine.setAttribute('y2', height + dataAreaY)
        pointerLine.setAttribute('stroke', '#9e9e9e')
        pointerLine.setAttribute('opacity', 0)

        elem.append(pointerLine, pointTextGroup)

        const crosshairCursor = document.querySelector('.crosshairCursor')

        crosshairCursor.style.position = 'absolute'

        elem.addEventListener('mouseover', function(/*evt*/) {
          const crosshairCursor = document.querySelector('.crosshairCursor')
          crosshairCursor.setAttribute('opacity', 1)
          pointTextGroup.setAttribute('opacity', 1)
        })

        //elem.addEventListener('mouseout', function(evt) {})

        chart.eventEmitter.addEventHandler('onActivePoint', (measure) => {
          let metaDataMeasure
          const selectedPoint = points.find((point) => {
            const metaAttr = Chartist.deserialize(point.getAttribute('ct:meta'))
            if (typeof metaAttr === 'object' && metaAttr.measure) {
              metaDataMeasure = metaAttr.measure
            } else {
              metaDataMeasure = metaAttr
            }
            return metaDataMeasure === measure
          })

          if (selectedPoint) {
            displayPointLabel(selectedPoint)
            const pointerX = selectedPoint.getAttribute('x1')
            const crosshairCursor = document.querySelector('.crosshairCursor')
            crosshairCursor.setAttribute('x1', pointerX)
            crosshairCursor.setAttribute('x2', pointerX)
          }
        })

        dataArea.addEventListener('mousemove', function(evt) {
          if (points.length === 0) {
            return
          }

          const pointerX = evt.clientX - xa + dataAreaX
          let bestPointX = dataAreaX

          const selectedPoint = points.reduce((prev, curr) => {
            const pointX1 = Math.round(curr.getAttribute('x1'))
            const pointX2 = Math.round(curr.getAttribute('x2'))
            const currPointAvgPos = Math.round((pointX2 + pointX1) / 2)

            let result
            if (
              Math.abs(bestPointX - pointerX) >
              Math.abs(currPointAvgPos - pointerX)
            ) {
              bestPointX = currPointAvgPos
              result = curr
            } else {
              result = prev
            }
            return result
          })

          const metaSourceContent = Chartist.deserialize(
            selectedPoint.getAttribute('ct:meta')
          )

          chart.eventEmitter.emit('selectfeature', metaSourceContent)
          displayPointLabel(selectedPoint)
        })

        function displayPointLabel(selectedPoint) {
          if (prevPointSelected) {
            prevPointSelected.setAttribute('style', 'opacity:0')
          }
          const offsetX = 40
          //const selectedPointY = selectedPoint.getAttribute('y1')
          const selectedPointX = +selectedPoint.getAttribute('x1')

          const crosshairCursor = document.querySelector('.crosshairCursor')
          crosshairCursor.setAttribute('x1', selectedPointX)
          crosshairCursor.setAttribute('x2', selectedPointX)
          crosshairCursor.setAttribute('opacity', 1)
          pointTextGroup.setAttribute('opacity', 1)

          //const dataContent = selectedPoint.getAttribute('ct:value')
          const metaSourceContent = selectedPoint.getAttribute('ct:meta')

          const metaData = Chartist.deserialize(metaSourceContent)
          let metaContent = ''
          if (typeof metaData === 'object') {
            metaContent = metaData.info
          } else {
            metaContent = metaData
          }

          prevPointSelected = selectedPoint
          selectedPoint.setAttribute('style', 'opacity:1')
          pointTextMeta.textContent = `${metaContent}`

          const bBox = pointText.getBBox()
          const pointTextRectWidth = +bBox.width + 10
          const pointTextRectHeight = +bBox.height + 4

          const halfTextRectWidth = Math.round(pointTextRectWidth / 2)
          const textPosX =
            selectedPointX - offsetX + halfTextRectWidth + 1 >= dataAreaWidth
              ? dataAreaWidth - pointTextRectWidth + offsetX - 1
              : Math.round(selectedPointX - offsetX) <= halfTextRectWidth
              ? offsetX + 1
              : selectedPointX - halfTextRectWidth

          const textPosY = 33

          pointTextRect.setAttribute('width', pointTextRectWidth)
          pointTextRect.setAttribute('height', pointTextRectHeight)
          pointTextGroup.setAttribute(
            'transform',
            `translate(${textPosX},${textPosY - 17})`
          )
        }
      })
    }
  }
})(window, document, Chartist)
