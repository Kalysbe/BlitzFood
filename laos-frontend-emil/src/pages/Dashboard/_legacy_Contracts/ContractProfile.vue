<template>
  <!-- <form> -->
    <md-card class="md-card-general">
      <md-card-content>
          <!-- Contract general information -->
        <div class="md-layout-item md-medium-size-100 md-xsmall-size-100 md-size-100">
          <md-card>
            <md-card-content>
              <ContractDetail :contract_data="view_data" table-header-color="green"></ContractDetail>
              <div class="gap"></div>
              <!-- <ContractSummary2 table-header-color="green"></ContractSummary2> -->
            </md-card-content>
          </md-card>
        </div>
          <!-- lots list -->
        <div class="md-layout-item md-medium-size-100 md-xsmall-size-100 md-size-100">
          <md-card>
            <!-- <md-card-header class="card-header-summary" data-background-color="white">
              <h4 class="title">Lots List</h4> -->
              <md-card-content>
                <LotsList :contract_data="view_data" table-header-color="green"></LotsList>
              </md-card-content>
            <!-- </md-card-header> -->
          </md-card>
        </div>

            <!-- BoQ -->
        <!-- <div class="md-layout-item md-medium-size-100 md-xsmall-size-100 md-size-100">
          <md-card>
            <md-card-header class="card-header" data-background-color="white">
              <h4 class="title">Bill of Quantities</h4>
            </md-card-header>
            <md-card-content>
              <contract-details table-header-color="green"></contract-details>
            </md-card-content>
          </md-card>
        </div> -->

        <div id="bottom-panel">
          <div class="md-layout-item md-medium-size-100 md-xsmall-size-100 md-size-100">
            <md-card>
              <md-card-header class="card-header" data-background-color="white">
                <h4 class="title">{{ $t('contract_payment_summary.title') }}</h4>
              </md-card-header>
              <md-card-content>
                <!-- <payment-details table-header-color="green"></payment-details> -->
                <ContractPaymentSummary></ContractPaymentSummary>
              </md-card-content>
            </md-card>
          </div>

          <!-- <div
            class="md-layout-item md-medium-size-100 md-xsmall-size-100 md-size-100"
          >
            <div id="div-contract-manipulation">
              <div id="dummy"></div>
              <div id="cmd-contract-lots">
                <md-button class="md-raised md-success">Contract Lots</md-button>
              </div>
              <div id="cmd-contract-delete">
                <md-button class="md-raised md-danger">Delete Contract</md-button>
              </div>
            </div>
          </div> -->
        
          <!-- <div
            class="md-layout-item md-medium-size-100 md-xsmall-size-100 md-size-100"
          >
            <md-card>
              <md-card-header class="card-header" data-background-color="white">
                <h4 class="title">Photos</h4>
              </md-card-header>
              <md-card-content>
                <road-photos id="photos-slider"></road-photos>
              </md-card-content>
            </md-card>
          </div> -->
        </div>

        <!-- <div class="md-layout-item five-columns">
          <md-button class="md-raised md-success">Environmental Monitoring Form</md-button>
          <md-button class="md-raised md-success">Impact Evaluation Form</md-button>
          <md-button class="md-raised md-success">Accident Form</md-button>
          <md-button class="md-raised md-success">Social Monitoring Form</md-button>
          <md-button class="md-raised md-success">Grievance Monitoring Form</md-button>
        </div> -->
      </md-card-content>
    </md-card>
  <!-- </form> -->
</template>

<script>
// import { ContractSummary1, ContractSummary2, ContractDetails, PaymentDetails, RoadPhotos } from "@/components/Tables";
import ContractDetail from './ContractDetail'
import ContractSummary2 from './ContractSummary2'
import ContractPaymentSummary from './ContractPaymentSummary'
import LotsList from "./lots/lots_list"
export default {
  name: "contractprofile",
  props: {
    dataBackgroundColor: {
      type: String,
      default: "",
    },
  },
  components: {
    ContractDetail,
    ContractSummary2,
    ContractPaymentSummary,
    LotsList,
    // ContractDetails,
    // PaymentDetails,
    // RoadPhotos
  },
  data() {
    return {
      contract: "Contract Data Detail",
      view_data: {}
    }
  },
  computed: {
    
  },
  methods: {
    goback(){
      this.$router.back();
    },
    onClickChild (value) {
      console.log("OnClick-Value:",value) // someValue
    }
  },
  mounted() {
    this.view_data = this.$route.params
    // console.log("view_data:", this.view_data)
    // this.$store.dispatch('setContractId', item.id)
    console.log("CONTRACT_DATA:", this.$store.state.Contract.CONTRACT_DATA)
  }
};
</script>
<style>
.md-card-general {
    margin-top: 0px;
    background-color: rgba(214, 218, 218, 0.599) !important;
}
.card-header {
  height: 28px;
}
.title {
  font-weight: 700 !important;
}
md-field {
  font-size: 14px;
  color:black;
}

.card-header-summary {
  height: 64px;
  padding-bottom: 0px;
  margin-bottom: 0px;
}

.gap {
  height: 15px;
}

#bottom-panel {
  display: table;
  width: 100%;
}
#bottom-panel > div {
  display: table-cell;
  width: 45%;
}
#bottom-panel > div:nth-child(2) {
  width: 10%;
}
#div-contract-manipulation {
  display: inline-flex;
  flex-direction: column;
  align-items: center;

  width: 200px;
}
#dummy {
  height:60px;
}
#cmd-contract-lots {
  margin-top:70px;
}
#cmd-contract-delete {
  margin-top:78px;
}
#photos-slider {
  margin-top: 7%;
  margin-bottom: 54px;
}

.five-columns {
  display: flex; 
  justify-content: space-between;
}
.md-raised {
  margin-left: 80px;
  margin-right: 80px;
}
</style>
