'use strict'

import { getRangeVal} from './helper'
import proj4 from 'proj4'
import 'ol/ol.css'
import {Map, View, Overlay} from 'ol'
import {Vector as VectorLayer, Tile as TileLayer} from 'ol/layer'
import {
  ScaleLine,
  MousePosition,
  FullScreen,
  Control
} from 'ol/control'
//import SelectFeature from 'ol/control/Control'
import {GeoJSON, TopoJSON} from 'ol/format'
import {createStringXY} from 'ol/coordinate'
import {
  OSM,
  Stamen,
  Vector as VectorSource,
  /*CartoDB,*/ XYZ,
  TileDebug
} from 'ol/source'
import {LineString} from 'ol/geom'
import {
  Projection,
  transform,
  transformExtent,
  get as getProjection
} from 'ol/proj'
//import {getCenter, buffer, boundingExtent} from 'ol/extent'
import {ObjectEvent} from 'ol/Object'
import {register} from 'ol/proj/proj4'
import {Circle as CircleStyle, Style, Stroke, Fill, Icon} from 'ol/style'

proj4.defs([
  [
    'EPSG:3301',
    '+proj=lcc +lat_1=59.33333333333334 +lat_2=58 +lat_0=57.51755393055556 ' +
      '+lon_0=24 +x_0=500000 +y_0=6375000 +ellps=GRS80 +towgs84=0,0,0,0,0,0,0 +units=m +no_defs'
  ],
  [
    'EPSG:2006',
    '+proj=tmerc +lat_0=0 +lon_0=-62 +k=0.9995000000000001 +x_0=400000 +y_0=0 +ellps=clrk80 +towgs84=-149,128,296,0,0,0,0 +units=m +no_defs'
  ]
])

register(proj4)
class olMap {
  constructor(props = {}) {
    const {
      viewProjection = 'EPSG:3857',
      dataProjection = 'EPSG:4326',
      center = [0, 0],
      zoom = null,
      viewMaxZoomDefault = 18
    } = props

    this.map = null
    this.overlay = null
    this.viewMaxZoomDefault = viewMaxZoomDefault

    this.tileLayerTypes = {}
    this.tileLayer = 'osm'

    this.roadsLayer = new VectorLayer({
      source: new VectorSource({
        format: new GeoJSON({dataProjection: new Projection(dataProjection)})
      })
    })
    this.roadsLayer.set('name', 'roadsLayer')

    this.addRoadsLayer = new VectorLayer({
      source: new VectorSource({
        format: new GeoJSON({dataProjection: new Projection(dataProjection)})
      })
    })
    this.addRoadsLayer.set('name', 'addRoadsLayer')

    this.projection2006 = getProjection('EPSG:2006')
    this.projection2006.setExtent([
      499364.8127,
      1514280.3081,
      523333.5898,
      1560834.6035
    ])

    this.eventSelectFeature = new ObjectEvent()
    this.eventSelectFeature.key = 'selectposition'
    this.eventSelectFeature.type = 'changeselectposition'

    this.mapLayer = new TileLayer({})

    this.mapDebugLayer = new TileLayer({
      source: new TileDebug({projection: viewProjection})
    })

    this.geoFormat = new GeoJSON({
      dataProjection: new Projection(dataProjection)
    })

    this.topoFormat = new TopoJSON({
      dataProjection: new Projection(dataProjection)
    })

    this.dataProjection = dataProjection
    this.viewProjection = viewProjection
    this.defCenter = transform(center, dataProjection, viewProjection)

    this.defZoomLevel = zoom ? zoom : 11

    this.tilesFactory = {
      osm: (props) => {
        return new OSM({...props})
      },

      stamen: (props) => {
        return new Stamen({...props})
      },

      cartodb: (props) => {
        return new XYZ({...props})
      },

      xyz: (props) => {
        return new XYZ({...props})
      }
    }
  }

  init({overlayElem, mapElem}) {
    this.overlay = new Overlay({
      element: document.getElementById(overlayElem),
      positioning: 'bottom-center'
      //autoPan: true
      // autoPanAnimation: {
      //   duration: 250
      // }
    })

    this.map = new Map({
      target: mapElem,
      layers: [this.mapLayer, this.roadsLayer, this.addRoadsLayer],
      overlays: [this.overlay],
      loadTilesWhileAnimating: true,
      view: new View({
        projection: /*this.projection2006,*/ this.viewProjection,
        center: this.defCenter,
        zoom: this.defZoomLevel,
        maxZoom: 18
      }),
      selectposition: {}
    })

    this.eventSelectFeature.target = this.map

    this.map.addControl(new ScaleLine())
    this.map.addControl(new FullScreen())
    this.map.addControl(
      new MousePosition({
        coordinateFormat: createStringXY(6),
        projection: /*this.projection2006*/ this.dataProjection,
        undefinedHTML: '&nbsp;'
      })
    )

    this.map.addControl(
      new Control({element: document.getElementById('legend')})
    )
  }

  destroy() {
    const layers = this.map.getLayers()
    while (layers.getLength() > 0) {
      const layer = layers.item(0)
      if (layer.get('layerSourceType') === 'VECTOR') {
        layer.getSource().clear()
      }
      layer.getRenderer().dispose()
      layer.setSource(null)
      this.map.removeLayer(layer)
    }
    this.map.setTarget(null)
    this.map = null
  }

  setEventHandler(evn, fn) {
    this.map.on(evn, fn)
  }

  createTileLayers(tileTypes) {
    tileTypes.forEach((item) => {
      const layers = item.layers.map((layer) => {
        const {category = 'xyz', props} = layer
        const layerProps = {...props}
        return this.tilesFactory[category](layerProps)
      })
      const {zoom = [], max_zoom = this.viewMaxZoomDefault} = item
      this.tileLayerTypes[item.name] = {
        layers,
        zoomRange: zoom,
        zoomMax: max_zoom
      }
    })
    return this.getTileLayerList()
  }

  getTileLayerList() {
    return Object.keys(this.tileLayerTypes)
  }

  getActiveTileLayer() {
    return this.tileLayerTypes[this.tileLayer]
  }

  changeTileLayer(name) {
    this.tileLayer = name

    let sourceInd = 0
    const zoomLayerRange = this.getTileLayerZoomRange()
    const currZoomLevel = this.getZoom()
    const currZoomMax = this.getTileLayerZoomMax()
    if (zoomLayerRange.length > 0) {
      sourceInd = getRangeVal(currZoomLevel, zoomLayerRange)
    }
    this.map.getView().setMaxZoom(currZoomMax)
    this.mapLayer.setSource(this.getActiveTileLayer().layers[sourceInd])
  }

  getTileLayerZoomRange() {
    return this.getActiveTileLayer().zoomRange
  }

  getTileLayerZoomMax() {
    return this.getActiveTileLayer().zoomMax
  }

  getMapExtent() {
    return transformExtent(
      this.map.getView().calculateExtent(this.map.getSize()),
      this.viewProjection,
      this.dataProjection
    )
  }

  fitMapByExtent(extent) {
    if (!extent || extent.length === 0) {
      return
    }

    this.updateSize()
    this.map
      .getView()
      .fit(
        transformExtent(extent, this.dataProjection, this.viewProjection),
        this.map.getSize()
      )
  }

  updateSize() {
    this.map.updateSize()
  }

  getZoom() {
    return this.map.getView().getZoom()
  }

  async clearVectorSource(layer) {
    if (!layer) {
      return
    }
    this[layer].getSource().clear()
  }

  async updateVectorSource({layer = 'roadsLayer', source}) {
    const {type} = source
    console.time('readFeatures')
    const features = this[
      type === 'Topology' ? 'topoFormat' : 'geoFormat'
    ].readFeatures(source, {
      featureProjection: this.viewProjection,
      dataProjection: this.dataProjection
    })
    console.timeEnd('readFeatures')

    console.time('addFeatures')
    features.forEach((feature, index) => {
      const propStyle = feature.getProperties()['style']

      if (propStyle) {
        let styleImage = undefined

        const {
          radius = 0,
          image = '',
          type,
          stroke,
          fill,
          scale = 0
        } = propStyle

        const strokeStyle = new Stroke({
          color: stroke.color,
          width: stroke.width
        })

        const fillStyle = new Fill({
          color: fill ? fill.color : '#ffffff'
        })

        if (type) {
          if (type === 'circle') {
            styleImage = new CircleStyle({
              radius: radius,
              fill: fillStyle,
              stroke: strokeStyle
            })
          } else if (type === 'icon') {
            styleImage = new Icon({
              src: `data:image/svg+xml;utf8,${image}`,
              scale: scale,
              color: '#ffffff'
            })
          }
        }

        const style = new Style({
          stroke: strokeStyle
        })

        if (styleImage) {
          style.setImage(styleImage)
        }

        feature.setStyle(style)
        feature.setId(index)
      }
    })

    await this.clearVectorSource(layer)
    this[layer].getSource().addFeatures(features)
    console.timeEnd('addFeatures')
  }

  clearOverlayPos() {
    this.overlay.setPosition(undefined)
  }

  getFeatures(layer) {
    if (!this[layer]) {
      return []
    }

    return this[layer].getSource().getFeatures()
  }

  setPopupPosition(payload) {
    let coordinate = undefined
    let segIter = 0

    const {feature_layer, feature_id, feature_data, section_id = null} = payload
    const vectorSource = !feature_layer
      ? this.roadsLayer.getSource()
      : this[feature_layer].getSource()

    const feature = vectorSource.getFeatureById(feature_id)
    const featureType = feature.getGeometry().getType()
    const featureProps = feature.getProperties()

    const selFeature = featureProps.data.findIndex((section) => {
      return section.reduce((accum, item, index) => {
        return (
          accum &&
          (Array.isArray(item)
            ? item[section_id] === feature_data[index]
            : item === feature_data[index])
        )
      }, true)
    })

    if (featureType === 'MultiLineString') {
      const lineString = feature.getGeometry().getLineString(selFeature)
      if (section_id !== null) {
        lineString.forEachSegment(function(start, end) {
          if (segIter === section_id) {
            const checkLine = new LineString([start, end])
            coordinate = checkLine.getCoordinateAt(0.5)
          }
          segIter += 1
        })
      } else {
        coordinate = lineString.getCoordinateAt(0.5)
      }
    } else if (featureType === 'MultiPoint') {
      const checkPoint = feature.getGeometry().getPoint(selFeature)
      coordinate = checkPoint.getCoordinates()
    }

    this.overlay.setPosition(coordinate)
  }

  getFeatureInfoByCoord(evt) {
    let props = null
    let ind = undefined
    let subInd = null // selected LineString section Id

    const {coordinate, pixel} = evt
    const feature_at_pixel = this.map.forEachFeatureAtPixel(
      pixel,
      (feature, layer) => {
        return {feature, layer}
      }
    )

    if (!feature_at_pixel) {
      this.clearOverlayPos()
      return
    }
    const {feature, layer} = feature_at_pixel

    const featureType = feature.getGeometry().getType()
    if (featureType === 'MultiLineString') {
      const closestPoint = feature.getGeometry().getClosestPoint(coordinate)
      const lineStrings = feature.getGeometry().getLineStrings()
      ind = lineStrings.findIndex((item) => {
        return item.intersectsCoordinate(closestPoint)
      })

      if (~ind) {
        const line = feature.getGeometry().getLineString(ind)
        let segId = 0
        line.forEachSegment(function(start, end) {
          const checkLine = new LineString([start, end])
          if (checkLine.intersectsCoordinate(closestPoint)) {
            subInd = segId
          }
          segId += 1
        })
      } else {
        return
      }

      props = feature.getProperties().data[ind]
    } else if (featureType === 'MultiPoint') {
      const closestPointCoord = feature
        .getGeometry()
        .getClosestPoint(coordinate)
      const points = feature.getGeometry().getPoints()
      ind = points.findIndex((item) => {
        const item_coord = item.getCoordinates()
        return (
          item_coord[0] === closestPointCoord[0] &&
          item_coord[1] === closestPointCoord[1]
        )
      })

      props = feature.getProperties().data[ind]
    } else {
      props = feature.getProperties()
    }

    const localisation = feature.getProperties().localisation_keys
    const feature_id = feature.getId()
    const feature_data =
      subInd !== null
        ? props.map((prop) => {
            return Array.isArray(prop) ? prop[subInd] : prop
          })
        : props

    const feature_layer = layer.get('name')
    return {
      feature_id,
      feature_layer,
      feature_data,
      section_id: subInd,
      localisation
    }
  }
}

export default olMap
