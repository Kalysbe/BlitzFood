<template>
  <form>
    <md-card class="md-card-height">
      <md-card-content>
        <md-card-header class="md-card-header-green md-card-header-height">
          <h4 class="title" style="color:white;">Contract Lot General Information</h4>
        </md-card-header>
        <div class="md-layout-item md-medium-size-100 md-xsmall-size-100 md-size-100">
          <md-card class="md-card-height">
            <md-card-content>
              <div class="md-layout">
                <div class="md-layout-item md-small-size-100 md-size-30">
                  <md-field>
                    <label>Contract No.</label>
                    <md-input v-model="ContractNo" type="text" style="font-weight:bold;" disabled></md-input>
                  </md-field>
                </div>
                <div class="md-layout-item md-small-size-100 md-size-30">
                  <md-field>
                    <label>Lot No.</label>
                    <md-input v-model="LotNo" type="text" style="font-weight:bold;" disabled></md-input>
                  </md-field>
                </div>
                <div class="md-layout-item md-small-size-100 md-size-30">
                  <md-field>
                    <label>Lot Value (LAK)</label>
                    <md-input v-model="LotAmnt" type="text" @focus="unformatNumber" @blur="formatNumber($event)"
                      @keypress="isNumber($event)"></md-input>
                  </md-field>
                </div>
                <div class="md-layout-item md-small-size-100 md-size-30">
                  <md-datepicker v-model="LotComplDate" md-immediately>
                    <label>Lot Completion Date</label>
                  </md-datepicker>
                </div>
                <div class="md-layout-item md-small-size-100 md-size-30">
                  <md-datepicker v-model="BegPeriod" md-immediately>
                    <label>Period Start</label>
                  </md-datepicker>
                </div>
                <div class="md-layout-item md-small-size-100 md-size-30">
                  <md-datepicker v-model="EndPeriod" md-immediately>
                    <label>Period End</label>
                  </md-datepicker>
                </div>
              </div>
            </md-card-content>
            {{lot_data}}
          </md-card>
        </div>

        <div class="md-layout-item md-medium-size-100 md-xsmall-size-100 md-size-100">
          <md-card>
            <md-card-header class="card-header" data-background-color="white">
              <h4 class="title">Daily Works Inspection</h4>
            </md-card-header>
            <md-card-content class="my-table-container">
              <LotDailyWorks table-header-color="green"></LotDailyWorks>
            </md-card-content>
          </md-card>
        </div>

        <div id="bottom-panel">
          <div class="md-layout-item md-medium-size-100 md-xsmall-size-100 md-size-50">
            <md-card>
              <md-card-header class="card-header" data-background-color="white">
                <h4 class="title">Payments</h4>
              </md-card-header>
              <md-card-content class="my-table-container">
                <LotPayments table-header-color="green"></LotPayments>
              </md-card-content>
            </md-card>
          </div>

          <div class="md-layout-item md-medium-size-100 md-xsmall-size-100 md-size-50">
            <md-card>
              <md-card-header class="card-header" data-background-color="white">
                <h4 class="title">Photos</h4>
              </md-card-header>
              <md-card-content>
                <LotRoadPhotos id="photos-slider"></LotRoadPhotos>
              </md-card-content>
            </md-card>
          </div>
        </div>

      </md-card-content>
    </md-card>
  </form>
</template>

<script>
// import { LotDailyWorks, LotPayments, LotRoadPhotos } from "@/components/Tables";
import LotDailyWorks from './LotDailyWorks.vue'
import LotPayments from './LotPayments.vue'
import LotRoadPhotos from './LotRoadPhotos.vue'

export default {
  name: "lotdetails",
  components: [
    LotDailyWorks,
    LotPayments,
    LotRoadPhotos
  ],
  data() {
    return {
      ContractNo: 'BRK01234567',
      LotNo: '1',
      LotAmnt: 1500000000, //Number(1500000000).toLocaleString(), //Intl.NumberFormat().format(1500000000),
      LotComplDate: new Date('2022-12-25'),
      BegPeriod: new Date('2022-09-10'),
      EndPeriod: new Date('2022-12-05'),
      lot_data: {}
    };
  },
  components: {
    LotDailyWorks,
    LotPayments,
    LotRoadPhotos
  },
  // mounted() {
  //   this.view_data = this.$route.params
  //   console.log("view_data:", this.view_data)
  // },
  methods: {
    isNumber: function (evt) {
      evt = (evt) ? evt : window.event;
      var charCode = (evt.which) ? evt.which : evt.keyCode;
      if ((charCode > 31 && (charCode < 48 || charCode > 57)) && charCode !== 46) {
        evt.preventDefault();;
      } else {
        return true;
      }
    },

    formatNumber: function (e) {
      const value = e.target.value;
      e.target.value = value == '' ? null : Number(value).toLocaleString();
    },

    unformatNumber(event) {
      event.target.value = event.target.value.replaceAll(',', '');
    }
  },
  
  mounted() {
    this.lot_data = this.$route.params
    console.log("lot-data",this.lot_data)
    // const value = this.LotAmnt;
    // this.LotAmnt = value == '' ? null : Number(value).toLocaleString();
  }
};
</script>
<style>
.md-card-height {
  margin-top: 0px;
}

.card-header {
  height: 38px !important;
}

.title {
  font-weight: 700 !important;
}

.my-table-container {
  margin-top: -10px;
}

md-field {
  font-size: 14px;
  color: black;
}

#bottom-panel {
  display: table;
  width: 100%;
  margin-top: -28px;
}

#bottom-panel>div {
  display: table-cell;
  width: 45%;
}

#bottom-panel>div:nth-child(2) {
  width: 10%;
}

#photos-slider {
  margin-top: 7%;
  margin-bottom: 54px;
}
</style>
