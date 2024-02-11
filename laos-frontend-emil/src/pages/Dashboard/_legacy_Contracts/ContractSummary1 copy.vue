<template>
  <div>
    <md-card class="md-card-height">
      <md-card-content>
        <md-card-header class="md-card-header-blue md-card-header-height">
          <h4 class="title" style="color:white;">Contract General Information</h4>
        </md-card-header>
        <div class="md-layout-item md-medium-size-100 md-xsmall-size-100 md-size-100">
          <md-card class="md-card-height">
            <md-card-content>
              <div class="md-layout">
                <div class="md-layout-item md-small-size-100 md-size-50">
                  <table>
                    <thead>
                      <tr>
                        <th class="tr0" style="font-family: phetsarath_ot">{{$t('contract.description')}}</th>
                        <th class="tr0" style="font-family: phetsarath_ot">{{$t('contract.data')}}</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <th style="font-family: phetsarath_ot">{{$t('contract.contract_id')}}</th>
                        <td>{{contract_data.id}}</td>
                      </tr>
                      <tr>
                        <th style="font-family: phetsarath_ot">{{$t('contract.contract_number')}}</th>
                        <td>{{contract_data.contract_number}}</td>
                      </tr>
                      <tr>
                        <th style="font-family: phetsarath_ot">{{$t('contract.project_name')}}</th>
                        <td>{{contract_data.project_name }}</td>
                      </tr>
                      <tr>
                        <th style="font-family: phetsarath_ot">{{$t('contract.contract_type')}}</th>
                        <td>{{contractTypeText(contract_data.id_contract_type)}}</td>
                      </tr>
                      <tr>
                        <th style="font-family: phetsarath_ot">{{$t('contract.funding_type')}}</th>
                        <td>{{fundingTypeText(contract_data.id_funding_type)}}</td>
                      </tr>
                      <tr>
                        <th style="font-family: phetsarath_ot">{{$t('contract.funding_source')}}</th>
                        <td>{{}}</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </md-card-content>
          </md-card>
        </div>
      </md-card-content>
    </md-card>
  </div>
</template>

<script>
export default {
  name: "contract-summary1",
  props: {
    contract_data: {},
    tableHeaderColor: 
      {
        type: String,
        default: "",
      },
  },
  data() {
    return {
      selected: [],
      contract_type_list: [],
      funding_type_list: [],
      // contractsummary: [],
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
    }
  },
  computed: {
    // contractsummary(){
    //   return this.contract_data
    // }
  },
  methods: {
    setId(){
      // need id attribute in contract list
      return this.contract_data.id
    },
    contractTypeText(id){
      // console.log("Contract ID::", id)
      const contractType = this.contract_type_list.find(c =>c.key == id )
      // console.log("Contract Type::", contractType)
      return contractType?contractType.value:null
    },
    typeValue(id){
      // console.log("VAL:", id)
      const val = this.funding_type_list.find(c =>c.key == id)
      return val?val.value:''
    },
    fundingTypeText(ids){
      // console.log("Funding ID::", ids)
      var ft=[]
      var len = ids?ids.length:null
      if(len>1){
        // console.log("LEN-IDS:", len)
        for(let i=0; i<len; i++){
          var fundtypes = this.typeValue(ids[i])
          ft[i] = fundtypes
        }
        let str = ft.toString()
        str = str.substring(0, str.length - 1);
        // console.log("STR:", str)
        return str
        
      }else{
        const fundingType = this.funding_type_list.find(c =>c.key == ids[0] )
        // console.log("Funding Type::", fundingType)
        return fundingType?fundingType.value.toString():null
      }
    }
  },
  async mounted() {
    console.log("this.contract_data:", await this.contract_data)
    console.log("this.contractsummary:", await this.contractsummary)

    this.contract_type_list = await this.$store.dispatch('LOAD_CONTRACT_REPORTS_LIST')
    // console.log("LOAD_CONTRACT_REPORTS_LIST-VUE:", this.contract_type_list)
    this.funding_type_list = await this.$store.dispatch('LOAD_FUNDING_TYPES')
    // console.log("LOAD_FUNDING_TYPES-VUE:", this.funding_type_list)
    
  }
}
</script>
<style scoped>
.iram-row {
  font-weight: 400 !important;
}
table {
  /* font-family: arial, sans-serif; */
  border-collapse: collapse;
  width: 100%;
}

td, th, tr {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}
.tr0 {
    font-weight: bold;
    font-size: 16px !important;
    background-color: #dddddd;
    border: 1.2px solid #9f9d9d !important;
}
</style>