<template>
  <div class='md-layout'>
    <div class='md-layout-item'>
      <form>
        <md-card>
          <transition name="fade">
            <div v-if="isDataLoading" class="load-progress">
              <md-progress-bar
                  md-mode="indeterminate"
                  class="progress-bar"
              ></md-progress-bar>
            </div>
          </transition>
          <md-card-header
              :class='getClass(headerColor)'
              class='md-card-header-icon'
          >
            <div class='card-icon'>
              <md-icon>{{ act === "add" ? "note_add" : "description" }}</md-icon>
            </div>
            <h4 class='title'>
              {{ $t(`lot.properties`) }}
              <small></small>
            </h4>
          </md-card-header>
          <md-card-content>
            <div class='md-layout '>
              <div class='md-layout-item md-small-size-100 md-size-50'>
                <md-field
                    :class="[
                      {'md-valid': !errors.has('lotNo') && touched['lotNo']},
                      {'md-error': errors.has('lotNo')}
                    ]"
                >

                  <label>
                    {{ $t(`lot.lot_no`) }}
                  </label>
                  <md-input
                      v-model='lotProps.lot_no'
                      :v-validate='modelValidations.lotNo'
                      :data-vv-name='"lotNo"'
                      type='number'
                      @input='onFieldChange("lotNo")'
                  ></md-input>
                  <slide-y-down-transition>
                    <md-icon v-show='errors.has("lotNo")' class='error'>
                      close
                    </md-icon>
                  </slide-y-down-transition>
                  <!--slide-y-down-transition>
                    <md-icon
                        v-show='!errors.has(prop.key) && touched[prop.key]'
                        class='success'
                    >
                      done
                    </md-icon>
                  </slide-y-down-transition-->

                </md-field>
              </div>
              <div class='md-layout-item md-small-size-100 md-size-50'>
                <md-field
                    :class="[
                      {'md-valid': !errors.has('lotName') && touched['lotName']},
                      {'md-error': errors.has('lotName')}
                    ]"
                >

                  <label>
                    {{ $t(`lot.lot_name`) }}
                  </label>
                  <md-input
                      v-model='lotProps.lot_name'
                      :v-validate='modelValidations.lotName'
                      :data-vv-name='"lotName"'
                      type='text'
                      @input='onFieldChange("lotName")'
                  ></md-input>
                  <slide-y-down-transition>
                    <md-icon v-show='errors.has("lotName")' class='error'>
                      close
                    </md-icon>
                  </slide-y-down-transition>
                  <!--slide-y-down-transition>
                    <md-icon
                        v-show='!errors.has(prop.key) && touched[prop.key]'
                        class='success'
                    >
                      done
                    </md-icon>
                  </slide-y-down-transition-->

                </md-field>
              </div>
              <div class='md-layout-item md-small-size-100 md-size-50'>
                <md-field>
                  <label>
                    {{ $t(`lot.province`) }}
                  </label>
                  <md-select
                      v-model='lotProps.id_province'
                  >
                    <md-option v-for='province in provinces' :key='province.id' :value='province.id'>
                      {{ province.name }}
                    </md-option>
                  </md-select>
                  <slide-y-down-transition>
                    <md-icon v-show="errors.has('province')" class='error'>close</md-icon>
                  </slide-y-down-transition>
                </md-field>
              </div>
              <div class='md-layout-item md-small-size-100 md-size-50'>
                <md-field>
                  <label>
                    {{ $t(`lot.district`) }}
                  </label>
                  <md-select
                      v-model='lotProps.id_district'
                      :disabled="lotProps.id_province===undefined"
                  >
                    <md-option v-for='district in districts' :key='district.id' :value='district.id'>
                      {{ district.name }}
                    </md-option>
                  </md-select>
                  <slide-y-down-transition>
                    <md-icon v-show="errors.has('district')" class='error'>close</md-icon>
                  </slide-y-down-transition>
                </md-field>
              </div>
              <div class='md-layout-item md-small-size-100 md-size-50'>
                <md-field>
                  <label>
                    {{ $t(`lot.road`) }}
                  </label>
                  <md-select
                      v-model='lotProps.id_road'
                      :disabled="lotProps.id_district===undefined"
                  >
                    <md-option v-for='road in roads' :key='road.id' :value='road.id'>
                      {{ road.name }}
                    </md-option>
                  </md-select>
                  <slide-y-down-transition>
                    <md-icon v-show="errors.has('road')" class='error'>close</md-icon>
                  </slide-y-down-transition>
                </md-field>
              </div>
              <div class='md-layout-item md-small-size-100 md-size-50'></div>
              <div class='md-layout-item md-small-size-100 md-size-50'>
                <md-field
                    :class="[
                      {'md-valid': !errors.has('startM') && touched['startM']},
                      {'md-error': errors.has('startM')}
                    ]"
                >

                  <label>
                    {{ $t(`lot.start_m`) }}
                  </label>
                  <md-input
                      v-model='lotProps.start_m'
                      :v-validate='modelValidations.startM'
                      :data-vv-name='"startM"'
                      type='number'
                      @input='onFieldChange("startM")'
                  ></md-input>
                  <slide-y-down-transition>
                    <md-icon v-show='errors.has("startM")' class='error'>
                      close
                    </md-icon>
                  </slide-y-down-transition>
                  <slide-y-down-transition>
                    <md-icon
                        v-show='!errors.has("startM") && touched["startM"]'
                        class='success'
                    >
                      done
                    </md-icon>
                  </slide-y-down-transition>

                </md-field>
              </div>
              <div class='md-layout-item md-small-size-100 md-size-50'>
                <md-field
                    :class="[
                      {'md-valid': !errors.has('endM') && touched['endM']},
                      {'md-error': errors.has('endM')}
                    ]"
                >

                  <label>
                    {{ $t(`lot.end_m`) }}
                  </label>
                  <md-input
                      v-model='lotProps.end_m'
                      :v-validate='modelValidations.endM'
                      :data-vv-name='"endM"'
                      type='number'
                      @input='onFieldChange("endM")'
                  ></md-input>
                  <slide-y-down-transition>
                    <md-icon v-show='errors.has("endM")' class='error'>
                      close
                    </md-icon>
                  </slide-y-down-transition>
                  <slide-y-down-transition>
                    <md-icon
                        v-show='!errors.has("endM") && touched["endM"]'
                        class='success'
                    >
                      done
                    </md-icon>
                  </slide-y-down-transition>

                </md-field>
              </div>

              <div class='md-layout-item md-size-100 text-right'>
                <md-button
                    :disabled='nothingSave'
                    class='md-success'
                    native-type='submit'
                    @click.native.prevent='validate'
                >
                  {{ $t('button.save') }}
                </md-button>
                <md-button class='md-accent' @click.stop.prevent='onCancel'>
                  {{ $t('button.close') }}
                </md-button>
              </div>
            </div>
          </md-card-content>
        </md-card>
      </form>
    </div>
  </div>
</template>

<script>
import Swal from "sweetalert2";
import {SlideYDownTransition} from 'vue2-transitions'

export default {
  name: "ContractLotProfile",
  components: {
    SlideYDownTransition
  },
  watch: {
    ["lotProps.id_province"](newVal) {
      this.reloadDistrict(newVal)
    }
  },
  data() {
    return {
      lotInstance: [
        {key: "lotNo", field: "lot_no", type: "number", elem: "text"},
        {key: "lotName", field: "lot_name", type: "text", elem: "text"},
        {key: "province", field: "id_province", type: "number", elem: "list", options: "provinces"},
        {key: "district", field: "id_district", type: "number", elem: "list", options: "districts"},
        {key: "road", field: "id_road", type: "number", elem: "list", options: "roads"},
        {key: "startM", field: "start_m", type: "number", elem: "text"},
        {key: "endM", field: "end_m", type: "number", elem: "text"},
      ],
      lotProps: {
        lot_no: "",
        lot_name: "",
        id_province: undefined,
        id_district: undefined,
        id_road: undefined,
        start_m: 0,
        end_m: 0,

      },
      loadedLotProps: {},
      touched: {
        lotNo: false,
        lotName: false,
        province: false,
        district: false,
        road: false,
        startM: false,
        endM: false,
      },
      modelValidations: {
        lotNo: {
          require: true
        },
        lotName: {
          require: true
        },
        province: {
          required: true,
        },
        district: {
          required: true,
        },
        road: {
          required: true,
        },
        startM: {
          required: true,
          number: true
        },
        endM: {
          required: true,
          number: true
        },

      },
      headerColor: "green",
      provinces: [],
      districts: [],
      roads: [],
      isDataLoading: false,
      nothingSave: true
    }
  },

  props: {
    act: {type: String},
    contractId: {type: Number},
    lotId: {type: Number},
  },
  methods: {
    reloadDistrict() {
      this.districts = []
      this.lotProps.id_district = undefined
      this.$store.dispatch('LOAD_PROVINCE_DISTRICTS', this.lotProps.id_province).then(districts => {
        this.districts = [...districts]
      })
    },
    listByName(name) {
      return [...this[name]]
    },
    fillDataObject(data) {
      this.lotFields.forEach(field => {
        if (data.hasOwnProperty(field)) {
          this.lotProps[field] = data[field]
          this.loadedLotProps[field] = data[field]
        }
      })
      this.nothingSave = true
    },

    async loadLotData() {
      this.isDataLoading = true
      try {
        const data = await this.$store.dispatch("LOAD_LOT_DETAILS", {contractId: this.contractId, lotId: this.lotId})
        this.fillDataObject(data)
      } finally {
        this.isDataLoading = false
      }

    },
    onFieldChange(field) {
      this.nothingSave = false
      this.touched[field] = true
    },
    onCancel() {
      this.$router.go(-1)
    },
    getClass: function (headerColor) {
      return 'md-card-header-' + headerColor + ''
    },
    async validate() {
      const isValid = await this.$validator.validateAll()
      const operType = this.act === 'add' ? 'added' : 'updated'
      if (!isValid) {
        return
      } else {
        const alert = {
          type: 'success',
          text: this.$t(`info.lot_was_${operType}`),
          footer: ''
        }
        let data = {}
        let diffLotProps = {}
        const instanceMap = this.lotInstanceMapByField
        try {
          delete this.lotProps.id
          if (this.act === 'add') {
            Object.keys(this.lotProps).forEach(prop => {
              diffLotProps[prop] = instanceMap[prop].hasOwnProperty('type') && instanceMap[prop].type === 'number' && instanceMap[prop].elem !== 'list' ?
                  Number(this.lotProps[prop]) : this.lotProps[prop]
            })
            data = await this.$store.dispatch('ADD_LOT', {contractId: this.contractId, data: diffLotProps})

          } else if (this.act === 'upd') {
            Object.keys(this.lotProps).forEach(prop => {
              if (!this.loadedLotProps.hasOwnProperty(prop) || this.loadedLotProps[prop] !== this.lotProps[prop]) {
                diffLotProps[prop] = instanceMap[prop].hasOwnProperty('type') && instanceMap[prop].type === 'number' && instanceMap[prop].elem !== 'list' ?
                    Number(this.lotProps[prop]) : this.lotProps[prop]
              }
            })
            data = await this.$store.dispatch('UPD_LOT', {contractId: this.contractId, lotId: this.lotId, data: diffLotProps})
          } else {
            throw `bad operation type`
          }

          this.fillDataObject(data)
          Swal.fire(alert).then(() => {
            this.$nextTick(() => this.$validator.reset())
          })

        } catch (err) {
          alert.type = 'error'
          alert.text = this.$t(`info.lot_was_not_${operType}`)
          alert.footer = this.$t(err.message ? err.message : err)
          await Swal.fire(alert)
        }
      }
    }
  },
  created() {

    this.$store.dispatch('LOAD_PROVINCES').then(provinces => {
      this.provinces = [...provinces]
    })

    if (this.act === "upd") {
      this.loadLotData()
    }
  },
  computed: {
    lotInstanceMapByField() {
      const instance = {}
      this.lotInstance.forEach(item => {
        instance[item.field] = item
      })
      return instance
    },
    lotFields() {
      return this.lotInstance.map(item => item.field)
    },
  }
}
</script>

<style lang="scss" scoped>
.md-button + .md-button {
  margin-left: 10px;
}

.load-progress {
  position: absolute;
  width: 100%;
  /* height: 100%; */
  top: 0px;
  display: flex;
  flex-direction: column;
  align-items: center;

  .progress-bar {
    width: 100%;
  }
}

.card-icon {
  position: relative;
  z-index: 10 !important;
}

.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.7s;
}

.fade-enter, .fade-leave-to /* .fade-leave-active до версии 2.1.8 */
{
  opacity: 0;
}
</style>