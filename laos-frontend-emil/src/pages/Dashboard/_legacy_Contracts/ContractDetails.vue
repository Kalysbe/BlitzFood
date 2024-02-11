<template>
  <div>
    <md-card class="md-card-frame">
      <md-card-header class="md-card-header-blue header-elements">
        <div style="display:inline-block;">
          <h4 class="title" style="color:white;">{{ $t('contract.title') }}
            <p class="contract-status">{{ setContractStatus(1) }}</p>
          </h4>
        </div>
        <md-button class="md-raised md-blue header-buttons" @click="relatedData">
          {{ $t('button.related_data') }}
        </md-button>
      </md-card-header>

      <md-card-content class="md-card-body">
        <div class="md-layout">
          <div class="md-layout-item md-small-size-100 md-size-50">
            <table>
              <thead>
                <tr>
                  <th class="tr0" style="font-family: phetsarath_ot">{{ $t('contract.description') }}</th>
                  <th class="tr1" style="font-family: phetsarath_ot">{{ $t('contract.data') }}</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <th style="font-family: phetsarath_ot">{{ $t('contract.contract_id') }}</th>
                  <td>{{ contract_data.id }}</td>
                </tr>
                <tr>
                  <th style="font-family: phetsarath_ot">{{ $t('contracts_list.contract_number') }}</th>
                  <td>{{ contract_data.contract_number }}</td>
                </tr>
                <tr>
                  <th style="font-family: phetsarath_ot">{{ $t('contract.project_name') }}</th>
                  <td>{{ contract_data.project_name }}</td>
                </tr>
                <tr>
                  <th style="font-family: phetsarath_ot">{{ $t('contracts_list.contract_type') }}</th>
                  <td>{{ contractTypeText(contract_data.id_contract_type) }}</td>
                </tr>
                <tr>
                  <th style="font-family: phetsarath_ot">{{ $t('contract.funding_type') }}</th>
                  <td>{{ fundingTypeText(contract_data.id_funding_type) }}</td>
                </tr>
                <tr>
                  <th style="font-family: phetsarath_ot">{{ $t('contract.funding_source') }}</th>
                  <td>{{ fundingSourceText(contract_data.id_funding_source) }}</td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="md-layout">
            <div class="md-layout-item md-small-size-100 md-size-100">
              <table>
                <thead>
                  <tr>
                    <th class="tr0" style="font-family: phetsarath_ot">{{ $t('contract.description') }}</th>
                    <th class="tr1" style="font-family: phetsarath_ot">{{ $t('contract.data') }}</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <th style="font-family: phetsarath_ot">{{ $t('contracts_list.contractor_name') }}</th>
                    <td>{{ contractorText(contract_data.id_contractor) }}</td>
                  </tr>
                  <tr>
                    <th style="font-family: phetsarath_ot">{{ $t('contracts_list.contract_duration') }}</th>
                    <td>{{ contract_data.contract_duration }}</td>
                  </tr>
                  <tr>
                    <th style="font-family: phetsarath_ot">{{ $t('contracts_list.construction_duration') }}</th>
                    <td>{{ contract_data.construction_duration }}</td>
                  </tr>
                  <tr>
                    <th style="font-family: phetsarath_ot">{{ $t('contracts_list.maintenance_duration') }}</th>
                    <td>{{ contractTypeText(contract_data.maintenance_duration) }}</td>
                  </tr>
                  <!--  <tr>
                    <th style="font-family: phetsarath_ot">{{$t('contract.funding_type')}}</th>
                    <td>{{fundingTypeText(contract_data.id_funding_type)}}</td>
                  </tr>
                  <tr>
                    <th style="font-family: phetsarath_ot">{{$t('contract.funding_source')}}</th>
                    <td>{{fundingSourceText(contract_data.id_funding_source)}}</td>
                  </tr> -->
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </md-card-content>
    </md-card>
    <ContractEnvironment />
  </div>
</template>

<script>
import { mapActions } from 'vuex';
import ContractEnvironment from './ContractEnvironment'
export default {
  name: "contract-detail",
  components: { ContractEnvironment },
  props: {
    tableHeaderColor:
    {
      type: String,
      default: "",
    },
  },
  data() {
    return {
      showform: false,
      contract_data: {},
      selected: [],
      contract_type_list: [],
      funding_type_list: [],
      funding_source_list: [],
      Contractors: [],
      contractsummary: [
        {
          id: '1',
          contractid: "C134",
          contractno: "24",
          project: "P24",
          province: "Vientiane",
          district: "V11",
          contracttype: "Lump-Sum",
          contractor: "CON32",
          client: "Vientiane",
          fundingtype: "Loan",
          fundingsource: "WB",
        },
      ],
      contract_status: [
        {
          id: 1,
          color: 'primary',
          text_eng: 'On going',
          text_lao: 'ກຳ​ລັງ​ປະ​ຕິ​ບັດ'
        },
        {
          id: 2,
          color: 'success',
          text_eng: 'Finished',
          text_lao: 'ສຳ​ລັດ'
        },
        {
          id: 3,
          color: 'secondary',
          text_eng: 'Canceled',
          text_lao: '​ຍົກ​ເລີກ'
        },
        {
          id: 4,
          color: 'warning',
          text_eng: 'Disputed',
          text_lao: 'ໂຕ້ແຍ້ງ'
        }

      ]
    }
  },
  computed: {
    // contractsummary(){
    //   return this.contract_data
    // }
  },
  methods: {
    ...mapActions('Contract', [
      'showRoadEnvironmentForm'
    ]),
    contractorText(cid) {
      const type = this.Contractors.find(c => c.key == cid)
      return type ? type.value : null
    },
    setContractStatus(status) {
      let cont_status = this.contract_status.filter(t => t.id == status)
      if (this.$i18n.locale == 'la') {
        return cont_status[0].text_lao
      } else {
        return cont_status[0].text_eng
      }
    },
    setContractColor(status) {
      let cont_status = this.contract_status.filter(t => t.id == status)
      return cont_status[0].color
    },
    relatedData() {
      console.log("RELATED-DATA")
      this.showRoadEnvironmentForm(true)
      this.showform = true;
    },
    setId() {
      return this.contract_data.id
    },
    contractTypeText(id) {
      const contractType = this.contract_type_list.find(c => c.key == id)
      return contractType ? contractType.value : null
    },
    typeValue(id) {
      const val = this.funding_type_list.find(c => c.key == id)
      return val ? val.value : ''
    },
    typeValueSource(id) {
      const val = this.funding_source_list.find(c => c.key == id)
      return val ? val.value : ''
    },
    fundingSourceText(ids) {
      var ft = []
      var len = ids ? ids.length : null
      if (len > 1) {
        for (let i = 0; i < len; i++) {
          var fundtypes = this.typeValueSource(ids[i])
          ft[i] = fundtypes
        }
        let str = ft.toString()
        str = str.substring(0, str.length - 1);
        return str
      } else {
        const fundingSource = this.funding_source_list.find(c => c.key == ids[0])
        return fundingSource ? fundingSource.value.toString() : null
      }
    },
    fundingTypeText(ids) {
      var ft = []
      var len = ids ? ids.length : null
      if (len > 1) {
        for (let i = 0; i < len; i++) {
          var fundtypes = this.typeValue(ids[i])
          ft[i] = fundtypes
        }
        let str = ft.toString()
        str = str.substring(0, str.length - 1);
        return str

      } else {
        const fundingType = this.funding_type_list.find(c => c.key == ids[0])
        return fundingType ? fundingType.value.toString() : null
      }
    }
  },
  async mounted() {
    console.log("CONTRACT_DATA-CONTRAC-DETAIL:", this.$store.state.Contract.CONTRACT_DATA)
    this.contract_data = this.$store.state.Contract.CONTRACT_DATA
    console.log("this.contract_data:", this.contract_data)

    this.contract_type_list = await this.$store.dispatch('LOAD_CONTRACT_REPORTS_LIST')
    this.funding_type_list = await this.$store.dispatch('LOAD_FUNDING_TYPES')
    console.log("LOAD_FUNDING_TYPES-VUE:", this.funding_type_list)

    this.funding_source_list = await this.$store.dispatch('LOAD_FUNDING_SOURCES')
    console.log("LOAD_FUNDING_SOURCES-VUE:", this.funding_source_list)
    const contractors_list = await this.$store.dispatch('LOAD_CONTRACTORS')
    this.Contractors = [...contractors_list]
    console.log("this.Contractors:", this.Contractors)

  }
}
</script>

<style scoped>
.md-card-frame {
  margin-top: 20px;
}

.header-elements {
  padding-bottom: 0px !important;
  display: flex;
  justify-content: space-between;
  margin-bottom: 14px;
}

.header-buttons {
  height: 39px;
  margin-right: 2.3px !important;
}

.md-card-body {
  margin-top: -16px;
  padding-bottom: 20px;
}

.contract-status {
  font-size: 0.8em;
  text-align: center;
  text-transform: uppercase;
}

table {
  border-collapse: collapse;
  width: 100%;
}

td,
th,
tr {
  text-align: left;
  font-size: 1.1em !important;
  padding: 8px;
  border-bottom: 1px solid #f5f5f5;
}

.tr0 {
  width: 30%;
  font-weight: bold;
  font-size: 1.3em !important;
  color: #00acc1;
  border-left: none;
  border-right: none;
  border-top: none;
  border-bottom: 1px solid #f5f5f5;
}

.tr1 {
  width: 70%;
  font-weight: bold;
  font-size: 1.3em !important;
  color: #00acc1;
  border-left: none;
  border-right: none;
  border-top: none;
  border-bottom: 1px solid #f5f5f5;
}
</style>