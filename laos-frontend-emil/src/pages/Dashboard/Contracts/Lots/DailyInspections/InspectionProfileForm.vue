<template>
  <div class=''>
    <form>
      <div class='md-layout md-gutter md-alignment-top-space-between'>
        <div class='md-layout-item md-size-40 md-medium-size-100'>
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
                {{ $t(`daily_inspection.properties`) }}
                <small></small>
              </h4>
            </md-card-header>
            <md-card-content>
              <div class='md-layout '>
                <div class='md-layout-item md-small-size-100 md-size-50'>
                  <md-field>
                    <label>
                      {{ $t(`daily_inspection.report_type`) }}
                    </label>
                    <md-select
                        v-model='inspectionProps.report_type'
                        multiple
                    >
                      <md-option v-for='type in reportTypes' :key='type.id' :value='type.id'>
                        {{ type.name }}
                      </md-option>
                    </md-select>
                    <slide-y-down-transition>
                      <md-icon v-show="errors.has('report_type')" class='error'>close</md-icon>
                    </slide-y-down-transition>
                  </md-field>

                </div>
                <div class='md-layout-item md-small-size-100 md-size-50'>
                  <md-datepicker v-model="inspectionProps.date" md-immediately>
                    <label>{{ $t(`label.date`) }}</label>
                  </md-datepicker>
                </div>
                <div class='md-layout-item md-small-size-100 md-size-50'>
                  <md-field
                      :class="[
                      {'md-valid': !errors.has('work_start_at') && touched['work_start_at']},
                      {'md-error': errors.has('work_start_at')}
                    ]"
                  >

                    <label>
                      {{ $t(`daily_inspection.work_start_at`) }}
                    </label>
                    <md-input
                        v-model='inspectionProps.work_start_at'
                        :v-validate='modelValidations.work_start_at'
                        :data-vv-name='"work_start_at"'
                        type='time'
                        @input='onFieldChange("work_start_at")'
                    ></md-input>
                    <slide-y-down-transition>
                      <md-icon v-show='errors.has("work_start_at")' class='error'>
                        close
                      </md-icon>
                    </slide-y-down-transition>
                    <slide-y-down-transition>
                      <md-icon
                          v-show='!errors.has("work_start_at") && touched["work_start_at"]'
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
                      {'md-valid': !errors.has('duration') && touched['duration']},
                      {'md-error': errors.has('duration')}
                    ]"
                  >

                    <label>
                      {{ $t(`daily_inspection.duration`) }}
                    </label>
                    <md-input
                        v-model='inspectionProps.duration'
                        :v-validate='modelValidations.duration'
                        :data-vv-name='"duration"'
                        type='number'
                        @input='onFieldChange("duration")'
                    ></md-input>
                    <slide-y-down-transition>
                      <md-icon v-show='errors.has("duration")' class='error'>
                        close
                      </md-icon>
                    </slide-y-down-transition>
                    <slide-y-down-transition>
                      <md-icon
                          v-show='!errors.has("duration") && touched["duration"]'
                          class='success'
                      >
                        done
                      </md-icon>
                    </slide-y-down-transition>

                  </md-field>
                </div>

                <div class='md-layout-item md-small-size-100 md-size-100'>


                </div>

              </div>
            </md-card-content>
          </md-card>

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
        <div class='md-layout-item md-size-60 md-medium-size-100' v-if="!isNewInspection">
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
                class="md-card-header-icon md-card-header-green card-icon"
            >
              <div class="card-icon">
                <md-icon>view_list</md-icon>
              </div>
              <h4 class="title">{{ $t('label.daily_inspection_works') }}</h4>
              <div class="export-icon">
                <div @click="onExport">
                  <i class="fas fa-calendar-plus" style="color:green"></i>
                </div>
                <div @click="onExport">
                  <i class="fas fa-file-export"></i>
                </div>
              </div>

            </md-card-header>

            <md-card-content>
              <md-table v-model="inspectionWorks" class="table-full-width">
                <md-table-row
                    slot="md-table-row"
                    slot-scope="{ item }"
                    :class="getClass(item)"
                >
                  <md-table-cell :md-label="$t('daily_inspection.work_no')">{{ item.work_no }}</md-table-cell>
                  <md-table-cell :md-label="$t('daily_inspection.category_of_work')">{{ item.category_of_work }}</md-table-cell>
                  <md-table-cell :md-label="$t('daily_inspection.type_of_work')">{{ item.type_of_work }}</md-table-cell>
                  <md-table-cell :md-label="$t('daily_inspection.details')">{{
                      item.details
                    }}
                  </md-table-cell>
                  <md-table-cell :md-label="$t('daily_inspection.quantity')" md-numeric>{{ item.quantity }}</md-table-cell>
                  <md-table-cell
                      :md-label="$t('tables.actions')"
                      v-if="hasAccess(feature, 'update')"
                      md-numeric
                  >
                    <div class='cell-actions'>
                      <drop-down direction="down">
                        <md-button
                            slot="title"
                            class='md-button md-just-icon md-simple'
                            data-toggle="dropdown"
                        >
                          <md-icon>more_vert</md-icon>
                        </md-button>
                        <ul
                            class="dropdown-menu"
                            :class="{ 'dropdown-menu-right': !responsive }"
                        >
                          <li><a href="" @click.prevent='onInspectionWorkEdit'>{{ $t("button.edit") }}</a></li>
                          <li><a href="" @click.prevent='onInspectionWorkDelete'>{{ $t("button.delete") }}</a></li>
                        </ul>
                      </drop-down>
                    </div>
                  </md-table-cell>
                </md-table-row>
              </md-table>
            </md-card-content>
          </md-card>
        </div>
      </div>

      <div class='md-layout md-gutter md-alignment-top-space-between' v-if="!isNewInspection">
        <div class='md-layout-item md-small-size-100 md-medium-size-50 md-xlarge-size-33'>
          <SubTables
              :subTableTitle="'label.materials'"
              :tableData="materialsData"
              :tableDataHeaders="['description', 'unit', 'qty']"
              :header-color="'green'"
          ></SubTables>
        </div>
        <div class='md-layout-item md-small-size-100 md-medium-size-50 md-xlarge-size-33'>
          <SubTables
              :subTableTitle="'label.equipment'"
              :tableData="equipmentData"
              :tableDataHeaders="['description', 'unit', 'qty']"
              :header-color="'blue'"
          ></SubTables>
        </div>
        <div class='md-layout-item md-small-size-100 md-medium-size-50 md-xlarge-size-33'>
          <SubTables
              :subTableTitle="'label.labour'"
              :tableData="labourData"
              :tableDataHeaders="['description', 'unit', 'qty']"
              :header-color="'rose'"
          ></SubTables>
        </div>
      </div>

    </form>
  </div>

</template>

<script>
import Swal from "sweetalert2";
import {SlideYDownTransition} from 'vue2-transitions'
import {utils, writeFile} from "xlsx";
import {permMixin} from "@/mixins/permission"
import SubTables from "@/components/Tables/DailyInspection/SubTables.vue"

export default {
  name: "daily-inspection-profile",
  components: {
    SlideYDownTransition,
    SubTables
  },
  mixins: [permMixin],
  watch: {},
  data() {
    return {
      feature: "daily-inspection-form",
      responsive: false,
      inspectionProps: {
        date: "",
        work_start_at: "",
        duration: undefined,
        report_type: undefined
      },
      reportTypes: [
        {id: "general", name: "di_report_type.general"},
        {id: "road_works", name: "di_report_type.road_works"},
        {id: "structure_works", name: "di_report_type.structure_works"},
        {id: "drainage_works", name: "di_report_type.drainage_works"},
        {id: "miscellaneous_works", name: "di_report_type.miscellaneous_works"},
        {id: "street_lighting", name: "di_report_type.street_lighting"},
        {id: "building_and_other_works", name: "di_report_type.building_and_other_works"},
      ],
      loadedInspectionProps: {},
      touched: {
        date: false,
        work_start_at: false,
        duration: false,
      },
      modelValidations: {
        date: {
          require: true
        },
        work_start_at: {
          require: true
        },
        duration: {
          required: true,
        },
      },
      headerColor: "green",

      isDataLoading: false,
      nothingSave: true,

      inspectionWorks: [],
      equipmentData: [],
      materialsData: [],
      labourData: []
    }
  },

  props: {
    act: {type: String},
    contractId: {type: Number},
    lotId: {type: Number},
    insId: {type: Number}
  },
  methods: {
    onInspectionWorkEdit() {
      console.log("edit")
    },
    onInspectionWorkDelete() {
    },
    onExport() {
      const headers = this.dataHeaders.map((header) =>
          this.$t(`translate.${header}`)
      )
      const export_data = [headers, ...this.exportedData]
      const today = new Date().toJSON().slice(0, 10)
      const worksheet = utils.aoa_to_sheet(export_data)
      const new_workbook = utils.book_new()
      const filter_name = !this.searchQuery
          ? ''
          : `_filter(${this.searchQuery})`

      utils.book_append_sheet(
          new_workbook,
          worksheet,
          `${this.name}${filter_name}`
      )
      writeFile(
          new_workbook,
          `export_${this.$t(this.reportName)}_${today}.xlsx`
      )
    },
    async loadInsData() {
      this.isDataLoading = true
      const payload = {contractId: this.contractId, lotId: this.lotId, insId: this.insId}

      this.$store.dispatch('LOAD_DAILY_INSPECTION_WORKS_DATA', payload).then(works => {
        this.inspectionWorks = [...works]
      })
      // Load subTables data
      this.$store.dispatch('LOAD_DAILY_INSPECTION_EQUIPMENT_DATA', payload).then(data => {
        this.equipmentData = [...data]
      })
      this.$store.dispatch('LOAD_DAILY_INSPECTION_MATERIALS_DATA', payload).then(data => {
        this.materialsData = [...data]
      })
      this.$store.dispatch('LOAD_DAILY_INSPECTION_LABOUR_DATA', payload).then(data => {
        this.labourData = [...data]
      },)

      try {
        //this.inspectionProps = await this.$store.dispatch("LOAD_DAILY_INSPECTION_DETAILS", payload)
        this.loadedInspectionProps = {...this.inspectionProps}

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
          text: this.$t(`info.inspection_was_${operType}`),
          footer: ''
        }

        const instanceMap = this.lotInstanceMapByField
        try {
          const {id, ...data} = this.inspectionProps
          if (this.act === 'add') {
            await this.$store.dispatch('ADD_DAILY_INSPECTION', {contractId: this.contractId, data: data})
          } else if (this.act === 'upd') {
            await this.$store.dispatch('UPD_DAILY_INSPECTION', {contractId: this.contractId, lotId: this.lotId, insId: this.insId, data: data})
          } else {
            throw `bad operation type`
          }

          Swal.fire(alert).then(() => {
            this.$nextTick(() => this.$validator.reset())
          })

        } catch (err) {
          alert.type = 'error'
          alert.text = this.$t(`info.inspection_was_not_${operType}`)
          alert.footer = this.$t(err.message ? err.message : err)
          await Swal.fire(alert)
        }
      }
    }
  },
  created() {

    if (this.act === "upd") {
      this.loadInsData()
    }
  },
  computed: {
    isNewInspection(){
      return this.act === "add"
    }
  }
}
</script>

<style lang="scss" scoped>
@import '@/assets/scss/md/_variables.scss';

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

.export-icon {
  position: absolute;
  right: 5px;
  top: 15px;
  font-size: 25px;
  color: $gray-color;
  cursor: pointer;
  display: flex;
}

.cell-actions {
  display: flex;
  flex-direction: column;
  align-items: flex-end;

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

<style lang="scss">

.md-table-head-label {
  height: 40px;
  max-width: 120px;
  padding-right: 32px;
  padding-left: 2px;
  display: inline-block;
  position: relative;
  line-height: 20px;
}

.md-table-head-container, .md-table-head-label {
  overflow: hidden;
  white-space: inherit;
}

</style>