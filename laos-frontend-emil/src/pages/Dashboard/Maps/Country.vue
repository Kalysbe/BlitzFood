<template>
  <div class="maps-area">
    <div class="md-layout md-gutter">
      <div
        class="md-layout-item md-size-25 md-small-size-50 md-xsmall-size-100"
      >
        <md-field>
          <label for="tileType">{{ $t('map.tile_types') }}</label>
          <md-select
            v-model="selectedTileType"
            @md-selected="onTileTypeChanged"
            name="tileType"
            id="tileType"
          >
            <md-option v-for="tile of tileTypes" :key="tile" :value="tile">
              {{ $t(`tile_types.${tile}`) }}
            </md-option>
          </md-select>
        </md-field>
      </div>
      <div class="md-layout-item" v-if="pagestyle !== 'plan'">
        <md-field>
          <label for="vectorType">{{ $t('map.vector_types') }}</label>
          <md-select
            v-model="selectedVectorType"
            @md-selected="onVectorTypeChanged"
            name="vectorType"
            id="vectorType"
          >
            <md-option
              v-for="vector of vectorTypes"
              :key="vector.key"
              :value="vector.key"
            >
              {{ $t(vector.value) }}
            </md-option>
          </md-select>
        </md-field>
      </div>
      <transition name="fade">
        <div
          class="md-layout-item"
          v-if="mapDefaultParams.additional_layers && pagestyle !== 'plan'"
        >
          <md-field>
            <label for="vectorAddit">{{ $t('map.vector_addit') }}</label>
            <md-select
              v-model="selectedVectorAdditType"
              @md-selected="onVectorAdditChanged"
              name="vectorAddit"
              id="vectorAddit"
            >
              <md-option
                v-for="vector of vectorAddit"
                :key="vector.key"
                :value="vector.key"
              >
                {{ $t(vector.value) }}
              </md-option>
            </md-select>
          </md-field>
        </div>
      </transition>

      <div class="md-layout-item" v-if="pagestyle !== 'plan'">
        <drop-down-input ref="dropDownRoadSearch">
          <template slot="input" class="dropdown-toggle" data-toggle="dropdown">
            <label>
              {{
                isRoadsListLoading
                  ? $t('map.road_list_is_updating')
                  : $t('map.road_search')
              }}
            </label>
            <md-input
              class="updating-road"
              @input="onChangeRoadSearch"
              :value="roadSearchValue"
            ></md-input>
            <div
              class="md-icon-clear"
              v-if="roadSearchValue !== ''"
              @click.stop.prevent="onRoadSearchClear"
            >
              <md-icon>
                clear
              </md-icon>
            </div>
          </template>

          <ul
            v-if="roadSearchList.length > 0"
            class="dropdown-menu dropdown-menu-left dropdown-menu-pos"
          >
            <li v-for="road in roadSearchList" :key="road.code">
              <a href="#" @click.stop.prevent="onRoadSelected(road.code)">
                {{ `${road.code} ${road.name ? '(' + road.name + ')' : ''}` }}
              </a>
            </li>
          </ul>
        </drop-down-input>
      </div>
      <div class="" v-if="pagestyle !== 'plan'">
        <Filter-box
          :filterList="filterList"
          :filterDefOptions="filterQueryDef"
          :isLoadingFilterListData="isLoadingFilterListData"
          :onlyOneEnable="true"
          @setFilter="setFilter"
        ></Filter-box>
      </div>
    </div>
    <div class="main-zone">
      <OlMap
        v-if="isMapDefaultParamsLoaded"
        class="map-zone"
        :style="{height: isShowRoadDetails ? 'calc( 100% - 250px' : '100%'}"
        ref="mapInstance"
        :tileLayer="selectedTileType"
        :roadsLayer="selectedVectorType"
        :addRoadsLayer="selectedVectorAdditType"
        :roadsSelected="selectedRoads.join(',')"
        :extent="mapExtent"
        :mapHighlightedFeatureItem="mapHighlightedFeatureItem"
        :mapDefaultParams="mapDefaultParams"
        :isShowRoadDetails="isShowRoadDetails"
        :vectorLegend="selectedVectorLegend"
        :filterOptions="filterQueryDef"
        @change-map-state="onChangeMapState"
        @changeTileList="onChangeTileList"
        @vectorSourceIsLoading="onMapVectorSourceIsLoading"
        @setHighlightedFeatureItem="setMapHighlightedFeatureItem"
      ></OlMap>
      <!--transition name="fade"-->
      <RoadDetails
        v-if="isShowRoadDetails"
        class="road-details-zone"
        :mapHighlightedFeatureItem="mapHighlightedFeatureItem"
        :vectorDetails="selectedVectorDetails"
        :vectorData="mapVectorSourceFeatures"
        @setHighlightedFeatureItem="setMapHighlightedFeatureItem"
      ></RoadDetails>
      <!--/transition-->
    </div>
  </div>
</template>
<script>
import OlMap from '@/components/OlMap'
import {FilterBox} from '@/components'
import RoadDetails from '@/components/OlMap/road-details'
import {mapState} from 'vuex'

export default {
  name: 'country-map-page',
  data() {
    return {
      tileTypes: [],
      vectorTypes: [],
      selectedTileType: 'osm',
      selectedVectorType: 'roads',
      selectedVectorAdditType: 'none',
      vectorAddit: [],
      roadsList: [],
      roadSearchValue: '',
      selectedRoads: [],
      maper: '',
      mapExtent: [],
      isRoadsListLoading: false,
      mapVectorSourceFeatures: [],
      mapHighlightedFeatureItem: null,
      isMapDefaultParamsLoaded: false,
      pagestyle: '',
      filterQueryDef: {},
      filterList: [],
      isLoadingFilterListData: false
    }
  },
  components: {
    OlMap,
    RoadDetails,
    FilterBox
  },
  async created() {
    const {
      vector,
      tile,
      roads = '',
      state = '',
      vector_add,
      pagestyle = '',
      filter_by = [],
      filter_values = []
    } = this.$route.query

    this.pagestyle = pagestyle
    if (vector_add) {
      this.selectedVectorAdditType = vector_add
    }

    if (tile) {
      this.selectedTileType = tile
    }
    if (state) {
      const attr = JSON.parse(atob(state))
      if (typeof attr === 'object') {
        const {extent} = attr
        this.mapExtent = extent
      }
    }

    if (filter_by) {
      if (!Array.isArray(filter_by)) {
        this.filterQueryDef[filter_by] = filter_values
      } else {
        filter_by.forEach((field, index) => {
          this.filterQueryDef[field] = filter_values[index]
        })
      }
    }

    this.selectedRoads = roads ? roads.split(',') : []

    this.$store.dispatch('LOAD_MAP_DEFAULT_PARAMS').then(() => {
      this.isMapDefaultParamsLoaded = true
      if (this.mapDefaultParams.additional_layers) {
        this.$store.dispatch('LOAD_ADDITION_VECTOR_TYPES').then((res) => {
          const {layers} = res
          this.vectorAddit = [
            {key: 'none', value: 'map_layers.none'},
            ...layers
          ]
        })
      }
    })
    this.$store.dispatch('LOAD_VECTOR_TYPES').then((res) => {
      this.vectorTypes = [...res.layers]
      if (vector) {
        this.selectedVectorType = vector
      }
      this.updateVectorRoadsList()
    })
  },

  methods: {
    setFilter(filter) {
      const filter_by = []
      const filter_values = []
      const filter_opt = {}
      Object.keys(filter).forEach((key) => {
        if (filter[key] !== '') {
          filter_by.push(key)
          filter_values.push(filter[key])
        }
      })

      if (filter_by) {
        if (!Array.isArray(filter_by)) {
          filter_opt[filter_by] = filter_values
        } else {
          filter_by.forEach((field, index) => {
            filter_opt[field] = filter_values[index]
          })
        }
      }

      this.filterQueryDef = {...filter_opt}

      this.routerQueryUpdate({
        filter_by: filter_by.length > 0 ? filter_by : 'none',
        filter_values: filter_values.length > 0 ? filter_values : 'none'
      })
      this.$nextTick(() => {
        this.$refs.mapInstance.onUpdateAllLayers()
      })
    },

    async onVectorAdditChanged(type) {
      this.routerQueryUpdate({vector_add: type})
    },

    setMapHighlightedFeatureItem(content) {
      this.mapHighlightedFeatureItem = content
    },

    onMapVectorSourceIsLoading(state) {
      if (state) {
        this.mapVectorSourceFeatures = []
      } else {
        if (this.selectedRoads.length > 0) {
          const chartData = this.$refs.mapInstance.getDataForChart('roadsLayer')
          this.mapVectorSourceFeatures = [...chartData]
        }
      }
    },
    async updateVectorFilterList() {
      this.isLoadingFilterListData = true
      try {
        const filter_list = await this.$store.dispatch(
          'LOAD_VECTOR_FILTER_LIST',
          {layer: this.selectedVectorType}
        )
        this.filterList = [...filter_list]
      } catch (err) {
        this.filterList = []
      } finally {
        this.isLoadingFilterListData = false
      }
    },
    async updateVectorRoadsList() {
      if (this.pagestyle === 'plan') {
        return false
      }
      this.isRoadsListLoading = true
      this.roadsList = []
      try {
        const road_list = await this.$store.dispatch(
          'LOAD_ROADS_LIST_BY_TYPE',
          {type: this.selectedVectorType}
        )
        this.roadsList = [...road_list.roads]
        this.roadSearchValue = this.findRoadInList(this.selectedRoads[0])
      } catch (err) {
        this.roadSearchValue = ''
      } finally {
        this.isRoadsListLoading = false
      }
    },

    routerQueryUpdate(params) {
      const modQuery = {...this.$route.query}
      Object.keys(params).forEach((item) => {
        if (params[item] === 'none') {
          delete modQuery[item]
        } else {
          modQuery[item] = params[item]
        }
      })
      this.$router.push({path: 'web-gis', query: modQuery})
    },

    onChangeTileList(list) {
      this.tileTypes = [...list]
    },

    onChangeMapState(payload) {
      const map_state = btoa(JSON.stringify({...payload}))
      this.routerQueryUpdate({state: map_state})
    },

    onTileTypeChanged(tile) {
      this.routerQueryUpdate({tile})
    },

    async onVectorTypeChanged(type) {
      this.updateVectorFilterList()
      this.filterQueryDef = {}
      await this.updateVectorRoadsList()
      this.routerQueryUpdate({
        vector: type,
        filter_by: 'none',
        filter_values: 'none'
      })
    },

    onChangeRoadSearch(val) {
      if (val === '') {
        this.selectedRoads = []
        this.routerQueryUpdate({roads: 'none'})
      }
      this.roadSearchValue = val
    },

    onRoadSelected(roads) {
      const roadOpt = this.roadsList.find((road) => road.roadcode === roads)
      const {extent} = roadOpt
      this.mapExtent = [...extent]

      this.selectedRoads = roads.split(',')
      this.roadSearchValue =
        this.selectedRoads.length > 0
          ? this.findRoadInList(this.selectedRoads[0])
          : ''

      this.$refs.dropDownRoadSearch.closeDropDown()
      const map_state = btoa(JSON.stringify(extent))
      this.routerQueryUpdate({roads, state: map_state})
    },

    onRoadSearchClear() {
      this.roadSearchValue = ''
      this.selectedRoads = []
      this.$refs.dropDownRoadSearch.closeDropDown()
    },

    findRoadInList(str) {
      if (!str) {
        return ''
      }
      const re = new RegExp(str, 'i')
      return this.roadsList
        .filter((item) => re.test(item.roadcode) || re.test(item.road_name))
        .map(
          (road) =>
            `${road.roadcode}${
              road.road_name ? ' (' + road.road_name + ')' : ''
            }`
        )[0]
    }
  },
  computed: {
    ...mapState({
      mapDefaultParams: (state) => state.WebGis.mapDefaultParams
    }),
    selectedVectorLegend() {
      return this.selectedVectorDetails && this.selectedVectorDetails.legend
        ? this.selectedVectorDetails.legend
        : []
    },

    selectedVectorDetails() {
      return this.vectorTypes.find(
        (vector) => vector.key === this.selectedVectorType
      )
    },
    isShowRoadDetails() {
      const isExistsGraph =
        this.selectedVectorDetails &&
        this.selectedVectorDetails.hasOwnProperty('graph')

      return (
        this.selectedRoads.length > 0 &&
        this.vectorTypes.length > 0 &&
        isExistsGraph
      )
    },
    filteredRoadsList() {
      const searchStr = this.roadSearchValue
        ? this.roadSearchValue.replace(/\(|\)/gi, (str) => `\\${str}`)
        : ''
      const re = new RegExp(searchStr, 'i')
      return this.roadsList.length > 0
        ? this.roadsList.filter(
            (item) => re.test(item.roadcode) || re.test(item.road_name)
          )
        : []
    },
    roadSearchList() {
      return this.filteredRoadsList.map((road) => {
        return {name: road.road_name, code: road.roadcode}
      })
    }
  }
}
</script>
<style lang="scss">
.maps-area {
  position: absolute;
  padding: 0 12px;
  left: 0;
  //height: calc(100% - 100px);
  width: 100%;
}
.dropdown-menu-pos {
  top: 35px;
  max-height: 300px;
  overflow: auto;
}
.main-zone {
  display: flex;
  flex-direction: column;
  height: calc(90vh - 70px);
}
.md-icon-clear {
  display: flex;
  flex-direction: row;
  cursor: pointer;
}

.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.5s;
}
.fade-enter,
.fade-leave-to {
  opacity: 0;
}
</style>
