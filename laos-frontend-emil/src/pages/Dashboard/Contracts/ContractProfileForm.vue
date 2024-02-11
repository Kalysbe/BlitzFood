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
              {{ $t(`contract.properties`) }}
              <small></small>
            </h4>
          </md-card-header>
          <md-card-content>
            <div class='md-layout '>
              <div v-for="prop in contractInstance" :key="prop.key" class='md-layout-item md-small-size-100 md-size-50'>
                <template v-if="prop.elem==='text'">
                  <md-field
                      :class="[
                      {'md-valid': !errors.has(prop.key) && touched[prop.key]},
                      {'md-error': errors.has(prop.key)}
                    ]"
                  >

                    <label>
                      {{ $t(`contract.${prop.field}`) }}
                    </label>
                    <md-input
                        v-model='contractProps[prop.field]'
                        :v-validate='modelValidations[prop.key]'
                        :data-vv-name='prop.key'
                        :type='prop.type'
                        @input='onFieldChange(prop.key)'
                    ></md-input>
                    <slide-y-down-transition>
                      <md-icon v-show='errors.has(prop.key)' class='error'>
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
                </template>
                <template v-if="prop.elem==='list'">
                  <md-field>
                    <label>
                      {{ $t(`contract.${prop.key}`) }}
                    </label>
                    <md-select
                        v-model='contractProps[prop.field]'
                        :multiple="prop.multiSelect"
                    >
                      <md-option v-for='opt in listByName(prop.options)' :key='opt.id' :value='opt.id'>
                        {{ $t(opt.name) }}
                      </md-option>
                    </md-select>
                    <slide-y-down-transition>
                      <md-icon v-show="errors.has(prop.key)" class='error'>close</md-icon>
                    </slide-y-down-transition>
                  </md-field>
                </template>
                <template v-if="prop.elem==='date'">
                  <md-datepicker v-model="contractProps[prop.field]" md-immediately>
                    <label>{{ $t(`contract.${prop.key}`) }}</label>
                  </md-datepicker>
                </template>

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
  name: "ContractProfile",
  components: {
    SlideYDownTransition
  },

  data() {
    return {
      contractInstance: [
        {key: "projectName", field: "project_name", type: "text", elem: "text"},
        {key: "contractTitle", field: "contract_title", type: "text", elem: "text"},
        {key: "contractNumber", field: "contract_number", type: "text", elem: "text"},
        {key: "contractor", field: "id_contractor", type: "number", elem: "list", options: "contractors"},
        {key: "contractType", field: "id_contract_type", type: "number", elem: "list", options: "contractTypes"},
        {key: "employer", field: "id_employer", type: "number", elem: "list", options: "employers"},
        {key: "fundingSource", field: "id_funding_source", type: "number", elem: "list", options: "fundingSources", multiSelect: true},
        {key: "fundingType", field: "id_funding_type", type: "number", elem: "list", options: "fundingTypes", multiSelect: true},
        // {key: "contractDuration", field: "contract_duration", type: "number", elem: "text"},
        // {key: "constructionDuration", field: "construction_duration", type: "number", elem: "text"},
        // {key: "maintenanceDuration", field: "maintenance_duration", type: "number", elem: "text"},
                  {key: "startDate", field: "start_date", elem: "date"},
        {key: "endDate", field: "end_date", elem: "date"},
        {key: "signingDate", field: "signing_date", elem: "date"},
        {key: "acceptanceDate", field: "acceptance_date", elem: "date"},
        {key: "currency", field: "currency", type: "number", elem: "list", options: "currencyList",},
        {key: "eArchiveUrl", field: "e_archive_url", type: "text", elem: "text"},
        // {key: "eshsPerformamnceSecurityAmount", field: "eshs_performamnce_security_amount", type: "number", elem: "text"},
        // {key: "equipmentPerformamnceSecurityAmount", field: "equipment_performamnce_security_amount", type: "number", elem: "text"},
        {key: "comments", field: "comments", type: "text", elem: "text"},
        {key: "contractStatus", field: "status", type: "number", elem: "list", options: "statusList"},


      ],
      contractProps: {},
      loadedContractProps: {},
      touched: {
        projectName: false,
        contractTitle: false,
        contractNumber: false,
        contractor: false,
        employer: false,
        fundingType: false,
        fundingSources: false,
      },
      modelValidations: {
        contractor: {},
        employer: {
          require: true
        },
        projectName: {
          required: true,
          min: 5
        },
        contractTitle: {
          required: true,
          min: 5
        },
        contractNumber: {
          required: true,
          min: 5
        },

      },
      headerColor: "green",
      contractId: this.$route.params.contractId,
      contractors: [],
      contractTypes: [],
      employers: [],
      fundingTypes: [],
      fundingSources: [],
      statusList: [],
      currencyList: [],
      isDataLoading: false,
      nothingSave: true
    }
  },

  props: {act: {type: String}},
  methods: {
    listByName(name) {
      return [...this[name]]
    },
    fillDataObject(data) {
      this.contractFields.forEach(field => {
        if (data.hasOwnProperty(field)) {
          this.contractProps[field] = data[field]
          this.loadedContractProps[field] = data[field]
        }
      })
      this.nothingSave = true
    },

    async loadContractData() {
      this.isDataLoading = true
      try {
        const data = await this.$store.dispatch("LOAD_CONTRACT_DETAILS", this.contractId)
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
      this.$router.push({name:"contract-list"})
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
          text: this.$t(`info.contract_was_${operType}`),
          footer: ''
        }
        let data = {}
        let diffContractProps = {}
        const instanceMap = this.contractInstanceMapByField
        try {
          delete this.contractProps.id
          if (this.act === 'add') {
            Object.keys(this.contractProps).forEach(prop => {
              diffContractProps[prop] = instanceMap[prop].hasOwnProperty('type') && instanceMap[prop].type === 'number' && instanceMap[prop].elem !== 'list' ?
                  Number(this.contractProps[prop]) : this.contractProps[prop]
            })
            data = await this.$store.dispatch('ADD_CONTRACT', {data: diffContractProps})

          } else if (this.act === 'upd') {
            Object.keys(this.contractProps).forEach(prop => {
              if (!this.loadedContractProps.hasOwnProperty(prop) || this.loadedContractProps[prop] !== this.contractProps[prop]) {
                diffContractProps[prop] = instanceMap[prop].hasOwnProperty('type') && instanceMap[prop].type === 'number' && instanceMap[prop].elem !== 'list' ?
                    Number(this.contractProps[prop]) : this.contractProps[prop]
              }
            })
            data = await this.$store.dispatch('UPD_CONTRACT', {id: this.contractId, data: diffContractProps})
          } else {
            throw `bad operation type`
          }

          this.fillDataObject(data)
          Swal.fire(alert).then(() => {
            this.$nextTick(() => this.$validator.reset())
          })

        } catch (err) {
          alert.type = 'error'
          alert.text = this.$t(`info.contract_was_not_${operType}`)
          alert.footer = this.$t(err.message ? err.message : err)
          await Swal.fire(alert)
        }
      }
    }
  },
  created() {
    this.$store.dispatch('LOAD_CONTRACTOR_LIST').then(contractors => {
      this.contractors = [...contractors]
    })

    this.$store.dispatch('LOAD_CONTRACT_TYPES').then(types => {
      this.contractTypes = [...types]
    })

    this.$store.dispatch('LOAD_EMPLOYERS').then(employers => {
      this.employers = [...employers]
    })

    this.$store.dispatch('LOAD_FUNDING_TYPES').then(types => {
      this.fundingTypes = [...types]
    })

    this.$store.dispatch('LOAD_FUNDING_SOURCES').then(sources => {
      this.fundingSources = [...sources]
    })

    this.$store.dispatch('LOAD_CONTRACT_STATUS_LIST').then(items => {
      this.statusList = [...items]
    })

    if (this.act === "upd") {
      this.loadContractData()
    }
  },
  computed: {
    contractInstanceMapByField() {
      const instance = {}
      this.contractInstance.forEach(item => {
        instance[item.field] = item
      })
      return instance
    },
    contractFields() {
      return this.contractInstance.map(item => item.field)
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