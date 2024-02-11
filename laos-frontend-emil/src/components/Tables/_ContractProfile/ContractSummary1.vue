<template>
  <div>
    <md-table v-model="contractsummary" table-header-color="black" table-header-bkcolor="grey" 
    table-header-fontweight="semi-bold" table-header-gridlines="true" table-cell-gridlines="true">
      <md-table-row slot="md-table-row" slot-scope="{ item }" class="iram-row">
        <md-table-cell md-label="Contract ID">{{ setId(item)}}</md-table-cell>
        <md-table-cell md-label="Contract number">{{ contract_data.contract_number }}</md-table-cell>
        <md-table-cell md-label="Project">{{ contract_data.project_name }}</md-table-cell>
        <md-table-cell md-label="Province">{{ }}</md-table-cell>
        <md-table-cell md-label="District">{{  }}</md-table-cell>
        <md-table-cell md-label="Contract Type">{{ contractTypeText(contract_data.id_contract_type) }}</md-table-cell>
        <md-table-cell md-label="Contractor">{{  }}</md-table-cell>
        <md-table-cell md-label="Client">{{  }}</md-table-cell>
        <md-table-cell md-label="Funding Type">{{ fundingTypeText(contract_data.id_funding_type) }}</md-table-cell>
        <md-table-cell md-label="Funding Source">{{  }}</md-table-cell>
      </md-table-row>
    </md-table>
    <!-- {{contract_data}} -->
  </div>
</template>

<script>
export default {
  name: "contract-summary1",
  props: {
    contract_data: '',
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
    
  },
  methods: {
    
    setId(){
      // need id attribute in contract list
      return 1
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

</style>