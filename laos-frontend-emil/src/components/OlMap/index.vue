<template>
  <div>
    <div id='zoomlevel'></div>
    <div id='map2' class='map2'></div>
    <div
      v-show='showLegendButton'
      id='legend'
      class='ol-legend ol-unselectable ol-control'
    >
      <button @click='toogleLegend'>
        <i class='fas fa-tags legend-icon'></i>
      </button>
      <div v-if='showLegendBox' class='legend-box'>
        <div v-for='elem in vectorLegend' :key='elem.name' class='legend-label'>
          <i
            :style='{
              color: elem.colour
            }'
            class='fa fa-circle'
          ></i>
          <span>
            {{ $t(elem.name) }}
          </span>
        </div>
      </div>
    </div>
    <Popups id='popup' :visible='popupBoxVisible' @onClose='onPopupBoxClose'>
      <span v-for='cont of popupContent' :key='cont' slot='content'>
        {{ cont }}
      </span>
    </Popups>
  </div>
</template>

<script>
import {arrayCompare, getRangeVal} from './helper'
import Popups from './popups'
import {mapState} from 'vuex'
import olMap from './olMap'

export default {
  props: {
    tileLayer: {type: String, default: 'osm'},
    roadsLayer: {type: String, default: 'roads'},
    addRoadsLayer: {type: String, default: 'none'},
    roadsSelected: {type: String},
    extent: {type: Array},
    mapHighlightedFeatureItem: {type: Object},
    mapDefaultParams: {type: Object},
    filterOptions: {type: Object},
    isShowRoadDetails: {type: Boolean, default: false},
    vectorLegend: {type: Array}
  },
  components: {
    Popups
  },
  watch: {
    isShowRoadDetails() {
      this.ol.updateSize()
    },
    tileLayer(/*newVal*/) {
      this.changeTileLayer()
    },
    roadsLayer() {
      this.onLoadLayerData('roadsLayer')
    },
    addRoadsLayer(newVal) {
      if (newVal === 'none') {
        this.onClearLayerData('addRoadsLayer')
      } else {
        this.onLoadLayerData('addRoadsLayer')
      }
    },
    roadsSelected(newVal) {
      if (newVal) {
        this.onUpdateAllLayers()
      }
      setTimeout(() => {
        this.refreshSizeByExtent()
      }, 500)
    },
    extent(/*newVal*/) {
      // if (newVal.length > 0) {
      // } else {
      // }
    },
    mapHighlightedFeatureItem(newVal, oldVal) {
      if (newVal === oldVal && !newVal) {
        return
      } else {
        this.displaySelectedFeatureInfo(newVal)
      }
    }
  },
  data() {
    return {
      currZoomLevel: 11,
      currExtent: null,
      roadUrlHash: '',
      zoomRangeVal: 0,
      vectorZoomRange: [13, 16],
      popupBoxVisible: false,
      popupContent: [],
      mapLayerTypes: {},
      viewTypesStyle: {},
      showLegendBox: true,
      ol: undefined,
      simUpdatedLayers: ['roadsLayer', 'addRoadsLayer'],
      domain: this.$route.params.domain
    }
  },

  beforeDestroy() {
    console.log('destroy map')
    this.ol.destroy()
  },

  async created() {
    //const {state} = this.$route.query

    const {
      map_centre,
      max_zoom,
      data_projection,
      view_projection,
      zoom
    } = this.mapDefaultParams

    this.ol = new olMap({
      center: map_centre,
      zoom: zoom,
      extent: this.extent,
      viewProjection: view_projection,
      dataProjection: data_projection,
      viewMaxZoomDefault: max_zoom
    })

    this.$store.dispatch('LOAD_BASEMAP_TYPES', this.domain).then((res) => {
      const {basemap_tiles = []} = res
      const tileList = this.ol.createTileLayers([...basemap_tiles])
      this.$emit('changeTileList', tileList)
      this.changeTileLayer()
      this.onUpdateAllLayers()
    })
  },
  mounted() {
    console.log('map mounted')
    this.$nextTick(function() {
      this.ol.init({overlayElem: 'popup', mapElem: 'map2'})

      this.refreshSizeByExtent()
      this.currExtent = this.ol.getMapExtent()
      this.currZoomLevel = this.ol.getZoom()

      this.ol.setEventHandler('moveend', this.onMapEvent)
      this.ol.setEventHandler('singleclick', this.onMapClick)
      this.ol.setEventHandler('pointermove', this.onPointerMove)
      this.ol.setEventHandler('changeselectposition', this.onSelectSection)
    })
  },
  computed: {
    ...mapState({roadsGeoJSON: (state) => state.WebGis.roadsGeoJSON}),
    showLegendButton() {
      return Boolean(this.vectorLegend)
    }
  },
  methods: {
    toogleLegend() {
      this.showLegendBox = !this.showLegendBox
    },
    onUpdateAllLayers() {
      this.simUpdatedLayers.forEach((item) => {
        if (this[item] !== 'none') {
          this.onLoadLayerData(item)
        }
      })
    },
    onSelectSection(/*evt*/) {
    },
    refreshSizeByExtent() {
      this.ol.fitMapByExtent(this.extent)
    },

    changeTileLayer() {
      this.ol.changeTileLayer(this.tileLayer)
    },
    onPopupBoxClose() {
      this.popupBoxVisible = false
    },

    async onPointerMove(evt) {
      if (evt.dragging) {
        return
      }

      this.setSelectedFeature(evt)
    },

    async onMapClick(evt) {
      this.setSelectedFeature(evt)
    },

    displaySelectedFeatureInfo(payload = null) {
      if (!payload) {
        if (this.popupBoxVisible) {
          this.onPopupBoxClose()
        }
        return
      }

      const {
        feature_id,
        feature_data,
        feature_layer,
        localisation,
        section_id
      } = payload

      this.ol.setPopupPosition({
        feature_id,
        feature_layer,
        feature_data,
        section_id
      })
      let content = []

      localisation.forEach((key, index) => {
        const val = feature_data[index]
        content.push(`${this.$i18n.t(key)}: ${val}`)
      })

      this.popupContent = content
      this.popupBoxVisible = true
    },

    async setSelectedFeature(evt) {
      //const coordinate = evt.coordinate
      const selectedPointInfo = this.ol.getFeatureInfoByCoord(evt)

      this.$emit(
        'setHighlightedFeatureItem',
        selectedPointInfo ? selectedPointInfo : null
      )
    },

    initMap() {
    },

    getLayerFeatures(layer) {
      return this.ol.getFeatures(layer)
    },

    getDataForChart(layer = 'roadsLayer') {
      console.log('getDataForChart')
      const features = this.getLayerFeatures(layer)
      return features
        .map((feature) => {
          const feature_id = feature.getId()
          const data = feature.getProperties().data
          const localisation = feature.getProperties().localisation_keys
          return data.map((item) => {
            return {feature_id, feature_data: item, localisation}
          })
        })
        .flat()
    },

    async onMapEvent(/*evt*/) {
      let onUpdateData = false
      let onUpdateTile = false

      const newViewExtent = this.ol.getMapExtent()
      const newZoomLevel = this.ol.getZoom()
      const newZoomRounded = Math.round(newZoomLevel)
      const currZoomRounded = Math.round(this.currZoomLevel)
      const tileZoomRange = this.ol.getTileLayerZoomRange()
      const vectorZoomRange = this.vectorZoomRange

      if (
        !this.roadsSelected &&
        (getRangeVal(newZoomRounded, vectorZoomRange) !==
          getRangeVal(currZoomRounded, vectorZoomRange) ||
          newZoomRounded < currZoomRounded)
      ) {
        onUpdateData = true
      }

      if (
        tileZoomRange.length > 0 &&
        getRangeVal(currZoomRounded, tileZoomRange) !==
        getRangeVal(newZoomRounded, tileZoomRange)
      ) {
        onUpdateTile = true
      }

      if (
        !this.roadsSelected &&
        !arrayCompare(this.currExtent, newViewExtent)
      ) {
        onUpdateData = true
      }

      this.currExtent = newViewExtent
      this.currZoomLevel = newZoomLevel

      const zoomInfo = `Zoom level= ${this.currZoomLevel}; rounded= ${newZoomRounded}`
      document.getElementById('zoomlevel').innerHTML = zoomInfo

      this.$emit('change-map-state', {
        extent: [...newViewExtent]
      })

      if (onUpdateTile) {
        this.changeTileLayer()
      }

      if (onUpdateData) {
        this.onUpdateAllLayers()
      }
    },

    async onClearLayerData(layer) {
      await this.ol.clearVectorSource(layer)
    },

    async onLoadLayerData(layer /*extent, resolution, projection*/) {
      const mapViewExtent = this.ol.getMapExtent()
      const mapViewZoom = Math.trunc(this.ol.getZoom())
      const filter_by = []
      const filter_values = []

      this.roadUrlHash = Math.random()
        .toString(36)
        .replace(/[^a-z]+/g, '')
        .substr(0, 10)

      try {
        console.time('dataLoad')

        this.$store.commit('SET_ROADS_LAST_REQUEST_HASH', {
          [layer]: this.roadUrlHash
        })

        const roadsData = {
          zoom: mapViewZoom,
          lat_min: mapViewExtent[1],
          lat_max: mapViewExtent[3],
          lon_min: mapViewExtent[0],
          lon_max: mapViewExtent[2],
          hash: this.roadUrlHash,
          type: this[layer],
          types: [
            this.roadsLayer,
            !this.addRoadsLayer || this.addRoadsLayer === 'none'
              ? 'none'
              : this.addRoadsLayer
          ]
        }

        Object.keys(this.filterOptions).forEach((key) => {
          if (this.filterOptions[key] !== '') {
            filter_by.push(key)
            filter_values.push(this.filterOptions[key])
          }
        })
        if (filter_by.length > 0) {
          roadsData.filter_by = filter_by
          roadsData.filter_values = filter_values
        }

        if (this.roadsSelected) {
          roadsData.road = this.roadsSelected.split(',')[0]
        }

        this.$emit('vectorSourceIsLoading', true)

        const roads_data = await this.$store.dispatch(
          'LOAD_ROADS_VECTOR_DATA',
          {layer, roadsData, domain: this.domain}
        )

        console.timeEnd('dataLoad')

        if (!roads_data) {
          return
        }

        await this.onClearLayerData(layer)

        await this.ol.updateVectorSource({layer, source: this.roadsGeoJSON})
      } catch (err) {
        console.log(`Error onLoadLayerData : ${err}`)
      } finally {
        this.$emit('vectorSourceIsLoading', false)
      }
    }
  }
}
</script>

<style lang='scss'>
#map2 {
  width: 100%;
  height: 100%;

  canvas {
    max-width: unset;
  }

  &:hover {
    .ol-mouse-position {
      background: white;
    }
  }
}

.ol-full-screen {
  // left: unset;
  // right: 0.5em;
  // top: 3.8em;
}

.ol-zoom {
  top: 2.5em;
  left: 0.5em;
}

.ol-legend {
  right: 0.5em;
  top: 2.8em;

  button {
    i {
      font-size: 0.8em;
    }
  }

  .legend-box {
    position: absolute;
    padding: 10px;
    margin-top: 7px;
    border-radius: 10px;
    right: 0.2em;
    background-color: rgba(255, 255, 255, 0.7);
    //width: 100px;
    //height: 100px;
    .legend-label {
      display: flex;
      align-items: center;

      i {
        margin-top: 3px;
      }

      span {
        white-space: nowrap;
        padding-left: 10px;
        font-weight: 500;
      }
    }
  }
}

.ol-mouse-position {
  border-radius: 5px;
  padding: 1px 3px;
  top: 8px;
  right: unset;
  left: 8px;
  position: absolute;
  //background: white;
}

.ol-zoomslider {
  top: 6.3em;
}

#zoomlevel {
  display: none;
}
</style>
