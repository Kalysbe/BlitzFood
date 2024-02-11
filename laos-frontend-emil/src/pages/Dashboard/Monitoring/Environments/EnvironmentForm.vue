<template>
  <div class="md-layout">
    <div class="md-layout-item">
      <form>
        <md-card
          v-for="(card, cardIndex) in environmentInstance"
          :key="cardIndex"
        >
          <md-card-header
            :class="getClass(headerColor)"
            class="md-card-header-icon"
          >
            <div class="card-icon">
              <md-icon>public</md-icon>
            </div>
            <div class="card-title">
              <h4 class="title">
                {{ $t(`environment.${card.label}`) }}
              </h4>
              <!-- table add list habdler -->
              <template v-if="cardIndex == 1">
                <md-button
                  class="md-button md-success md-just-icon md-round md-sm md-theme-default"
                  @click.stop.prevent="toggleTableDialog"
                >
                  <md-icon>add</md-icon>
                </md-button>
              </template>

              <template v-if="cardIndex == 3">
                <md-button
                  class="md-button md-success md-just-icon md-round md-sm md-theme-default"
                  @click.stop.prevent="toggleGalleryDialog"
                >
                  <md-icon>add</md-icon>
                </md-button>
              </template>
              <!--  -->
            </div>
          </md-card-header>
          <md-card-content>
            <div class="md-layout md-size-100">
              <div class="md-layout">
                <template v-for="field in card.card">
                  <div
                    :class="`md-layout-item md-size-${field.row}`"
                    :key="field.field"
                  >
                    <template v-if="field.element === 'select'">
                      <md-field>
                        <label>
                          {{ $t(`environment.${field.field}`) }}
                        </label>
                        <md-select
                          v-model="field.value"
                          :disabled="field.field != 'province' && !provinceId"
                          @click="onFieldChange(field.field)"
                        >
                          <md-option
                            v-for="option in field.options"
                            :value="option.id || option.roadcode"
                            :key="option.id"
                          >
                            {{ option.name || option.roadnumber }}
                          </md-option>
                        </md-select>
                      </md-field>
                    </template>
                    <template v-if="field.element === 'input'">
                      <md-field
                        :class="[
                          {
                            'md-valid':
                              !errors.has(field.field) && touched[field.field]
                          },
                          {'md-error': errors.has(field.field)}
                        ]"
                      >
                        <label>
                          {{ $t(`environment.${field.field}`) }}
                        </label>

                        <md-input
                          v-model="field.value"
                          v-validate="modelValidations[field.field]"
                          :data-vv-name="`${field.field}`"
                          :type="`${field.field}`"
                          @input="onFieldChange(field.field)"
                        ></md-input>
                        <slide-y-down-transition>
                          <md-icon
                            v-show="errors.has(field.field)"
                            class="error"
                          >
                            close
                          </md-icon>
                        </slide-y-down-transition>

                        <slide-y-down-transition>
                          <md-icon
                            v-show="
                              !errors.has(field.field) && touched[field.field]
                            "
                            class="success"
                          >
                            done
                          </md-icon>
                        </slide-y-down-transition>
                      </md-field>
                    </template>
                    <template v-if="field.element === 'radio'">
                      <div class="title">
                        {{ $t(`environment.${field.field}`) }}
                      </div>
                      <div class="md-layout">
                        <div
                          class="input"
                          v-for="option in field.options"
                          :key="option.id"
                        >
                          <template v-if="act == 'upd'">
                            <md-radio
                              :value="
                                field.value != null &&
                                option &&
                                field.value.id == option.id
                                  ? false
                                  : true
                              "
                              @change="field.value = option"
                              @input="onFieldChange(field.field)"
                            >
                              {{ option.name }}
                            </md-radio>
                          </template>
                          <template v-else>
                            <md-radio
                              v-model="field.value"
                              :value="option"
                              @input="onFieldChange(field.field)"
                            >
                              {{ option.name }}
                            </md-radio>
                          </template>
                        </div>
                      </div>
                    </template>
                    <template v-if="field.element === 'file'">
                      <md-field>
                        <label>{{ $t(`environment.${field.field}`) }}</label>
                        <md-file v-model="field.value" />
                      </md-field>
                    </template>
                    <template v-if="field.element === 'table'">
                      <template v-for="(table, indexTable) in field.tables">
                        <field-table
                          :table="table"
                          :key="field.field + indexTable"
                          :isTableDialog="isTableDialog"
                          @toggleTableDialog="toggleTableDialog"
                        />
                      </template>
                    </template>
                    <template v-if="field.element === 'list'">
                      <md-table>
                        <!-- table head -->
                        <div class="md-layout md-gutter">
                          <div
                            class="md-layout-item"
                            v-for="head in field.headers"
                            :key="head"
                          >
                            {{ head }}
                          </div>
                        </div>
                        <!-- table body -->
                        <template v-if="field.options.length > 0">
                          <div
                            class="md-layout md-gutter md-alignment-center-center"
                            v-for="(row, rowIndex) in field.options"
                            :key="rowIndex"
                          >
                            <div class="md-layout-item">
                              {{ row.distributed }}
                            </div>

                            <div class="md-layout-item">
                              <md-switch v-model="row.active" />
                            </div>

                            <div class="md-layout-item">
                              <md-datepicker
                                v-if="row.active"
                                v-model="row.value"
                              />
                            </div>
                          </div>
                        </template>
                        <template v-else>
                          <md-table-row>
                            <md-table-cell colspan="5" class="text-center">
                              <h5>{{ $t(`environment.no_tables`) }}</h5>
                            </md-table-cell>
                          </md-table-row>
                        </template>
                        <!-- table row add handler -->
                      </md-table>
                    </template>
                    <template v-if="field.element === 'textarea'">
                      <md-field>
                        <label>{{ $t(`environment.${field.field}`) }}</label>
                        <md-textarea
                          v-model="field.value"
                          :md-counter="field.counter"
                          :md-autogrow="field.autogrow"
                        ></md-textarea>
                      </md-field>
                    </template>
                    <template v-if="field.element === 'fieldgroup'">
                      <template v-for="(group, indexGroup) in field.groups">
                        <div :key="field.field + indexGroup">
                          <label class="title">
                            {{ $t(`environment.fieldgroup.${field.field}`) }}
                          </label>
                          <div class="md-layout">
                            <template v-for="(groupitem, key) in group.fields">
                              <div
                                :class="`md-layout-item md-size-${groupitem.row}`"
                                :key="field.field + groupitem.field + key"
                              >
                                <template
                                  v-if="groupitem.element === 'textarea'"
                                >
                                  <md-field>
                                    <label>
                                      {{ $t(`environment.${groupitem.field}`) }}
                                    </label>
                                    <md-textarea
                                      v-model="groupitem.value"
                                      :md-counter="groupitem.counter"
                                      :md-autogrow="groupitem.autogrow"
                                    ></md-textarea>
                                  </md-field>
                                </template>
                                <template v-if="groupitem.element === 'select'">
                                  <md-field>
                                    <label>
                                      {{ $t(`environment.${groupitem.field}`) }}
                                    </label>
                                    <md-select v-model="groupitem.value">
                                      <md-option
                                        v-for="option in groupitem.options"
                                        :value="option.id"
                                        :key="option.id"
                                      >
                                        {{ option.name }}
                                      </md-option>
                                    </md-select>
                                  </md-field>
                                </template>
                                <template v-if="groupitem.element === 'input'">
                                  <md-field>
                                    <label>
                                      {{ $t(`environment.${groupitem.field}`) }}
                                    </label>

                                    <md-input
                                      v-model="groupitem.value"
                                      :data-vv-name="`${groupitem.field}`"
                                      :type="`${groupitem.field}`"
                                    ></md-input>
                                    <slide-y-down-transition>
                                      <md-icon
                                        v-show="errors.has(groupitem.field)"
                                        class="error"
                                      >
                                        close
                                      </md-icon>
                                    </slide-y-down-transition>

                                    <slide-y-down-transition>
                                      <md-icon
                                        v-show="
                                          !errors.has(groupitem.field) &&
                                          touched[groupitem.field]
                                        "
                                        class="success"
                                      >
                                        done
                                      </md-icon>
                                    </slide-y-down-transition>
                                  </md-field>
                                </template>
                                <template v-if="groupitem.element === 'date'">
                                  <md-datepicker v-model="groupitem.value">
                                    <label>Choose date</label>
                                  </md-datepicker>
                                </template>
                              </div>
                            </template>
                          </div>
                        </div>
                      </template>
                    </template>
                    <template v-if="field.element === 'image_gallery'">
                      <field-image-list
                        :images="field.images"
                        :isGalleryDialog="isGalleryDialog"
                        @toggleGalleryDialog="toggleGalleryDialog"
                      />
                    </template>
                  </div>
                </template>
              </div>
            </div>
          </md-card-content>
        </md-card>
        <div class="md-layout-item md-size-100 text-left">
          <md-button
            :disabled="nothingSave"
            class="md-success"
            native-type="submit"
            @click.native.prevent="validate"
          >
            {{ $t('button.save') }}
          </md-button>
          <md-button class="md-accent" @click.stop.prevent="onCancel">
            {{ $t('button.close') }}
          </md-button>
        </div>
      </form>
    </div>
  </div>
</template>
<script>
import {mapState} from 'vuex'
import {SlideYDownTransition} from 'vue2-transitions'
import Swal from 'sweetalert2'
import FieldTable from '../../../../components/Monitoring/Environments/FieldTable.vue'
import ImageGallery from '../../../../components/ImageGallery.vue'
import ImageList from '../../../../components/ImageList/index.vue'
import FieldImageList from '../../../../components/Monitoring/Environments/FieldImageList.vue'

export default {
  name: 'environment-form',
  props: {
    headerColor: {
      type: String,
      default: ''
    },
    act: String
  },
  components: {
    SlideYDownTransition,
    FieldTable,
    ImageGallery,
    ImageList,
    FieldImageList
  },
  created() {
    this.$store.dispatch('LOAD_PROVINCES').then((data) => {
      this.environmentInstance[0].card.forEach((f) => {
        if (f.field == 'province') {
          f.options = data
        }
      })
    })
    if (this.act === 'upd') {
      this.$store
        .dispatch('GET_ENVIRONMENT_BY_ID', this.environmentId)
        .then((data) => {
          this.environmentInstance = this.environmentInstance.map(
            ({card, label}) => ({
              label,
              card: card.map((temp) => {
                if (
                  temp.element == 'input' ||
                  temp.element == 'radio' ||
                  temp.element == 'textarea' ||
                  temp.element == 'select' ||
                  temp.element == 'file'
                ) {
                  return {...temp, value: data[temp.field]}
                }
                if (temp.element == 'table') {
                  return {
                    ...temp,
                    tables: temp.tables.map(({template}) => ({
                      template,

                      ...data[temp.field][0]
                    }))
                  }
                }
                if (temp.element == 'list') {
                  return {...temp, options: data[temp.field]}
                }
                if (temp.element == 'fieldgroup') {
                  return {
                    ...temp,
                    groups: temp.groups.map(({fields, field}, i) => {
                      return {
                        field,
                        fields: fields.reduce((acc, curr) => {
                          return [
                            ...acc,
                            {
                              ...curr,
                              value: data[temp.field][i].fields[curr.field]
                            }
                          ]
                        }, [])
                      }
                    })
                  }
                }
                if (temp.element == 'image_gallery') {
                  return {
                    ...temp,
                    images: data[temp.field]
                  }
                }
              })
            })
          )
        })
    }
    if (this.act == 'upd' && this.provinceId) {
      this.loadDynamicOptions(this.provinceId, 'province')
    }
  },
  data() {
    return {
      environmentId: this.$route.params.environmentId,
      isTableDialog: false,
      isGalleryDialog: false,
      environmentProps: {},
      nothingSave: true,
      disabledDates: (date) => {
        return false
      },
      touched: {
        province: false,
        district: false,
        location: false,
        road_name: false,
        road_no: false,
        type_of_monitoring: false
      },
      modelValidations: {
        province: {
          required: true,
          min: 5
        },
        district: {
          required: true,
          min: 5
        },
        location: {
          required: true
        },
        road_name: {
          required: true,
          min: 5
        },
        road_no: {
          required: true,
          min: 5
        },
        type_of_monitoring: {
          required: true
        }
      },
      environmentInstance: [
        {
          label: 'province',
          card: [
            {
              element: 'select',
              field: 'province',
              value: '',
              options: [],
              row: '50'
            },
            {
              element: 'select',
              field: 'district',
              value: '',
              options: [],
              row: '50'
            },
            {
              element: 'select',
              field: 'road_name',
              value: '',
              options: [],
              row: '50'
            },
            {
              element: 'select',
              field: 'road_no',
              value: '',
              options: [],
              row: '50'
            },
            {
              element: 'input',
              field: 'link_no',
              value: '',
              row: '100'
            },
            {
              element: 'radio',
              field: 'type_of_monitoring',
              value: null,
              options: [
                {name: 'Regular', id: 1},
                {name: 'Periodic', id: 2},
                {name: 'Monthly/Quarterly', id: 3},
                {name: 'Annual/semi-annual', id: 4}
              ],
              row: '50'
            },
            {
              element: 'file',
              field: 'location',
              value: null,
              row: '50'
            },
            {
              element: 'textarea',
              field: 'detail_description',
              value: '',
              counter: '80',
              autogrow: false,
              row: '100'
            }
          ]
        },
        {
          label: 'activities',
          card: [
            {
              element: 'table',
              field: 'tables',
              row: '100',
              tables: [
                {
                  headers: [
                    'Activities',
                    'Implementation',
                    'Comments',
                    'Actions'
                  ],
                  template: [
                    {
                      element: 'select',
                      field: 'activities',
                      value: null,
                      options: [
                        {name: 'Activities 1', id: 1},
                        {name: 'Activities 2', id: 2},
                        {name: 'Activities 3', id: 3}
                      ],
                      row: '100'
                    },
                    {
                      element: 'select',
                      field: 'implementation',
                      value: null,
                      options: [
                        {name: 'Good', id: 1},
                        {name: 'Satisfactory', id: 2},
                        {name: 'Poor', id: 3}
                      ],
                      row: '100'
                    },
                    {
                      element: 'textarea',
                      field: 'comment',
                      value: '',
                      counter: '80',
                      autogrow: true,
                      row: '100'
                    }
                  ],
                  rows: []
                }
              ]
            }
          ]
        },
        {
          label: 'distributed',
          card: [
            {
              element: 'list',
              field: 'distributed',
              headers: ['Distributed', '', 'Date'],
              options: [
                {
                  distributed: 'MPWT-ESD/PTI',
                  active: false,
                  value: new Date().toISOString().slice(0, 10)
                },
                {
                  distributed: 'MPWT-TD/DOR',
                  active: false,
                  value: new Date().toISOString().slice(0, 10)
                },
                {
                  distributed: 'DPWT–ESU',
                  active: false,
                  value: new Date().toISOString().slice(0, 10)
                },
                {
                  distributed: 'MONRE/DONRE',
                  active: false,
                  value: new Date().toISOString().slice(0, 10)
                }
              ]
            },
            {
              element: 'fieldgroup',
              field: 'groups',
              row: '100',
              groups: [
                {
                  field: 'compiled',
                  fields: [
                    {
                      id: 10,
                      element: 'input',
                      field: 'name',
                      value: '',
                      row: '33'
                    },
                    {
                      id: 11,
                      element: 'input',
                      field: 'designation',
                      value: '',
                      row: '33'
                    },
                    {
                      id: 13,
                      element: 'date',
                      field: 'date',
                      value: null,
                      row: '33'
                    }
                  ]
                },
                {
                  field: 'verified',
                  fields: [
                    {
                      id: 10,
                      element: 'input',
                      field: 'name',
                      value: '',
                      row: '33'
                    },
                    {
                      id: 11,
                      element: 'input',
                      field: 'designation',
                      value: '',
                      row: '33'
                    },
                    {
                      id: 13,
                      element: 'date',
                      field: 'date',
                      value: null,
                      row: '33'
                    }
                  ]
                }
              ]
            }
          ]
        },
        {
          label: 'gallery',
          card: [
            {
              element: 'image_gallery',
              field: 'image_gallery',
              images: []
            }
          ]
        }
      ]
    }
  },
  methods: {
    onFieldChange(field) {
      this.nothingSave = false
      this.touched[field] = true
    },
    toggleTableDialog() {
      this.isTableDialog = !this.isTableDialog
    },
    toggleGalleryDialog() {
      this.isGalleryDialog = !this.isGalleryDialog
    },
    async setProvinceId(id) {
      this.provinceId = id
    },
    async loadDynamicOptions(id, field) {
      let actions = [
        {
          option: 'road_name',
          action: 'LOAD_PROVINCE_ROADS'
        }
      ]
      if (field == 'province') {
        actions = [
          ...actions,
          {
            option: 'district',
            action: 'LOAD_PROVINCE_DISTRICTS'
          }
        ]
      }
      actions.map(({action, option}) => {
        this.$store.dispatch(action, this.provinceId).then((data) => {
          this.environmentInstance[0].card.forEach((f) => {
            if (f.field == option) {
              f.options = data
            }
            if (
              (f.field == option && this.touched.province) ||
              (f.field == option && this.touched.district)
            ) {
              f.value = null
            }
          })
        })
      })
    },
    onCancel() {
      this.$router.go(-1)
    },
    getClass: function (headerColor) {
      return 'md-card-header-' + headerColor + ''
    },
    async validate() {
      const isValid = await this.$validator.validateAll()
      const operType = this.act === 'new' ? 'added' : 'updated'
      if (!isValid) {
        return
      } else {
        const alert = {
          type: 'success',
          text: this.$t(`environment.environment_was_${operType}`),
          footer: ''
        }
        try {
          if (this.act === 'new') {
            let environment = this.environmentInstance.reduce(
              (result, {card}) => {
                return Object.assign(
                  result,
                  card.reduce(
                    (
                      prev,
                      {field, value, element, tables, groups, options}
                    ) => {
                      if (
                        element === 'input' ||
                        element === 'radio' ||
                        element === 'textarea' ||
                        element === 'select' ||
                        element === 'file'
                      ) {
                        prev[field] = value
                      }
                      if (element === 'list') {
                        prev[field] = options
                      }
                      if (element === 'table') {
                        prev[field] = tables.map(({headers, rows}) => ({
                          headers,
                          rows
                        }))
                      }
                      if (element === 'fieldgroup') {
                        prev[field] = groups.reduce((acc, fg) => {
                          return [
                            ...acc,
                            {
                              field: fg.field,
                              fields: fg.fields.reduce(
                                (subacc, subfg) => (
                                  (subacc[subfg.field] = subfg.value), subacc
                                ),
                                {}
                              )
                            }
                          ]
                        }, [])
                      }
                      return prev
                    },
                    {}
                  )
                )
              },
              {}
            )

            // end - parsing
            await this.$store.dispatch('ADD_ENVIRONMENT', environment)
          } else if (this.act === 'upd') {
            console.log('update environmentInstance', this.environmentInstance)
          } else {
            throw `bad operation type`
          }

          this.nothingSave = true
          Swal.fire(alert).then(() => {
            this.$nextTick(() => this.$validator.reset())
          })
        } catch (err) {
          alert.type = 'error'
          alert.text = this.$t(`environment.error_${operType}`)
          alert.footer = this.$t(err.message ? err.message : err)
          Swal.fire(alert)
        }
      }
    }
  },
  watch: {
    provinceId(val) {
      this.loadDynamicOptions(val, 'province')
    },
    districtId(val) {
      this.loadDynamicOptions(val)
    }
  },
  computed: {
    ...mapState({}),
    provinceId() {
      return this.environmentInstance[0].card.filter(
        (f) => f.field === 'province'
      )[0].value
    },
    districtId() {
      return this.environmentInstance[0].card.filter(
        (f) => f.field === 'district'
      )[0].value
    }
  }
}
</script>
<style  lang='scss'>
.md-button + .md-button {
  margin-left: 10px;
}
.cell-actions {
  display: flex;
  flex-direction: column;
  align-items: flex-end;

  .md-button {
    margin: 3px 0;
    min-width: 100px;
  }
}
.card-title {
  display: flex;
  align-items: center;
  justify-content: space-between;
}
.card-title .md-button {
  margin-top: 10px;
}
</style>