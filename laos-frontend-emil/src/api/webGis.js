/** ------------ WEB-GIS ------------------- */
import {paramsSerializer, type_json} from "@/api/utils";

/**
 * @typedef {Object} LayerData
 * @property {string} road - Road Id
 * @property {Array} values - Values
 */

/**
 * @typedef {Object} VectorLayer
 * @property {string} hash - Request hash
 * @property {LayerData[]} data - Layer data
 * @example
 * {
 *  "hash": "brown",
 *     "data": [
 *         {
 *           "road": "A10",
 *           "values": [
 *               {
 *                 "start": 0,
 *                 "end": 20,
 *                 "lat": 13.7297927736808,
 *                 "lon": -60.9515961042504,
 *                 "iri": 10.2
 *               }
 *           ]
 *         }
 *       ]
 *     },
 */

/**
 * @typedef {Object} BasemapTiles
 */

/**
 * @typedef {Object} AddVectorLayers
 * @property {string} key - Key
 * @property {string} value - Value
 */

/**
 * @typedef {Object} AddVector
 * @property {AddVectorLayers[]} layers - Layers
 */

export default Api => {
    return ({
        /** Returns vector data
         * @example webgis/data?lon_max=-61.05&lat_max=-61.4&lon_min=13.95&lat_min=14&zoom=10&var={iri,webGis,traffic}&hash=brown
         * @param {string} system
         * @param {Object} payload
         * @param {string} payload.hash - Hash
         * @param {number} payload.zoom - Zoom
         * @param {float} payload.lat_min - Lat min
         * @param {float} payload.lat_max - Lat max
         * @param {float} payload.lon_min - Lon min
         * @param {float} payload.lon_max - Lon max
         * @param {string} payload.type - Type
         * @param {string[]} payload.types - Types
         * @param {string} payload.filter_by - Filter By
         * @param {string[]} payload.filter_values - Filter values
         * @return {Promise<VectorLayer>} - 200 Default Response
         * @throws Error
         */
        async load_roads_data( payload) {
            const {
                zoom, lat_min, lat_max, lon_min,
                lon_max, hash, type, road, types,
                filter_by, filter_values
            } = payload

            const params = {
                zoom, lat_min, lat_max,
                lon_min, lon_max, hash,
                var: type, all_vars: types.join(','),
                road
            }

            if (filter_by) {
                params.filter_by = filter_by
                params.filter_values = filter_values
            }

            // if (params.var === 'road_photos') {
            //     return this.load_frames_by_roadname(params)
            // }

            //
            return await Api.get(
                `/webgis/data`, {
                    params,
                    paramsSerializer
                }, {
                    headers: {
                        ...type_json
                    }
                }
            )

        },

        /** Loads road list by type
         * @param {Object} payload - Payload
         * @param {string} payload.type - Type
         * @return {Promise<Road[]>} - webGis - 200 Default Response
         * @example {
         * "webGis": [
         *     {
         *         "roadcode": "A10",
         *         "road_name": "Vieux Fort to SoufriÃ¨re",
         *         "iri": 4.8
         *     }
         *   ]
         * }
         * @throws Error
         */
        async load_roads_list_by_type({type}) {
            return await Api.get(`/webgis/roads/${type}`, {
                headers: {
                    ...type_json
                }
            })
        },

        /** Loads map default params
         * webgis/default_parameters
         * @return {Promise<Object>} - 200    Default Response
         * @example
         * {
         *  "view_projection": "EPSG:3857",
         *  "data_projection": "EPSG:4326",
         *  "map_centre": [
         *      -60.98347663879394,
         *      13.91708027258394
         *  ],
         *  "zoom": 11,
         *  "max_zoom": 18,
         *  "additional_layers": true
         *  }
         * @throws Error
         */
        async load_map_default_params() {
            return await Api.get(`/webgis/default_parameters`, {
                headers: {
                    ...type_json
                }
            })
        },

        /** Loads vector types
         * webgis/layers
         * @return {Promise<AddVector>} - 200 Default Response
         * @example
         * {
         * "layers": [
         *     {
         *       "key": "iri",
         *       "value": "map_layers.iri"
         *     }
         *   ]
         * }
         * @throws Error
         */
        async load_vector_types() {
            return await Api.get(`/webgis/layers`, {
                headers: {
                    ...type_json
                }
            })
        },

        /** Loads addition vector types
         * /webgis/additional_layers
         * @return {Promise<AddVector>} - 200 Default Response
         * @example
         * {
         *  "layers": [
         *    {
         *     "key": "bli_points",
         *     "value": "map_layers.bli_points"
         *    }
         *  ]
         *}
         * @throws Error
         */
        async load_addition_vector_types() {
            const res = await Api.get(`/webgis/additional_layers`, {
                headers: {
                    ...type_json
                }
            })

            return res
        },

        /** Loads vector filters
         * @param {Object} params
         * @param {string} params.layer
         * @return {Promise<string[]>} - 200 Default Response
         */
        async load_vector_filters( params) {
            return Api.get(
                `/webgis/filters`,
                {params},
                {
                    headers: {
                        ...type_json
                    }
                }
            )
        },

        /** Loads basemaps
         * @return {Promise<BasemapTiles[]>} - 200 Default Response
         * @example
         * {
         *  "basemap_tiles": [
         *    {
         *    "category": "osm",
         *    "flavors": [
         *        {
         *          "name": "osm",
         *          "props": {
         *            "crossOrigin": "anonymous",
         *            "wrapX": false
         *           }
         *        }
         *     ]
         *    }
         *  ]
         * }
         * @throws Error
         */
        async load_basemaps() {
            return await Api.get(`/webgis/basemaps`, {
                headers: {
                    ...type_json
                }
            })
        }
    });
}