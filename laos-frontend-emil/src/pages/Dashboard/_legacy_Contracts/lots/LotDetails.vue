<template>
  <form>
    <md-card class="md-card-height">
      <md-card-content>
        <md-card-header class="md-card-header-blue md-card-header-height">
          <h4 class="title" style="color:white; font-family:phetsarath_ot;">{{$t('lots.title')}}
            <md-button class="md-raised md-warning" style="float: right; margin-top: -7px;" @click="goback">{{$t('button.back')}}</md-button>
          </h4>
        </md-card-header>
        <div class="md-layout-item md-medium-size-100 md-xsmall-size-100 md-size-100">
          <md-card class="md-card-height">
            <md-card-content>
              <div class="md-layout">
                <div class="md-layout-item md-small-size-100 md-size-50">
                  <table>
                    <thead>
                      <tr>
                        <th class="tr0">{{$t('lots.description')}}</th>
                        <th class="tr1">{{$t('lots.data')}}</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td class="td1">{{$t('lots.lot_name')}}</td>
                        <td>{{lot_data.lot_name}}</td>
                      </tr>
                      <tr>
                        <td class="td1">{{$t('lots.province')}}</td>
                        <td>{{setTextProvince(lot_data.id_province)}}</td>
                      </tr>
                      <tr>
                        <td class="td1">{{$t('lots.district')}}</td>
                        <td>{{setTextDistrict(lot_data.id_district)}}</td>
                      </tr>
                      <tr>
                        <td class="td1">{{$t('lots.contract_value')}}</td>
                        <td>{{lot_data.contract_value | currency('LAK', 0, { symbolOnLeft: false, spaceBetweenAmountAndSymbol: true })}}</td>
                      </tr>
                      <tr>
                        <td class="td1">{{$t('lots.local_financing')}}</td>
                        <td>{{lot_data.local_financing | formatNumber}}</td>
                      </tr>
                      <tr>
                        <td class="td1">{{$t('lots.work_type')}}</td>
                        <td>{{setWorkTypes(lot_data.id_work_type)}}</td>
                      </tr>
                      <tr>
                        <td class="td1">{{$t('lots.asset_type')}}</td>
                        <td>{{setAsseType(lot_data.id_asset_type)}}</td>
                      </tr>
                      <!-- <tr>
                        <td class="td1">{{$t('lots.assets')}}</td>
                        <td>{{setAssetContent(lot_data.id_asset)}}</td>
                      </tr> -->
                    </tbody>
                  </table>
                </div>
                <div class="md-layout-item md-small-size-100 md-size-50">
                  <table>
                    <thead>
                      <tr>
                        <th class="tr0">{{$t('lots.description')}}</th>
                        <th class="tr1">{{$t('lots.data')}}</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td class="td1">{{$t('lots.road_id')}}</td>
                        <td>{{roadText(lot_data.id_road)}}</td>
                      </tr>
                      <tr>
                        <td class="td1">{{$t('lots.road_number')}}</td>
                        <td>{{roadText(lot_data.road_number)}}</td>
                      </tr>
                      <tr>
                        <td class="td1">{{$t('lots.start_m')}}</td>
                        <td>{{startText(lot_data.start_m) | formatNumber }}</td>
                      </tr>
                      <tr>
                        <td class="td1">{{$t('lots.end_m')}}</td>
                        <td>{{endText(lot_data.end_m) | formatNumber }}</td>
                      </tr>
                      <tr>
                        <td class="td1">{{$t('lots.road_length')}}</td>
                        <td>{{lot_data.road_length | formatNumber  }}</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </md-card-content>
            <!-- {{lot_data}} -->
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
      lot_data: {},
      asset_types: [],
      work_types: [],
      province_list_rows: [],
      district_list_rows_all: [],
      province_list: [],
      district_list: []
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
    goback(){
      // this.$parent.$emit('clicked', this.lot_data)
      this.$router.back();
    },
    // contractTypeText(id){
    //   // console.log("Contract ID::", id)
    //   const contractType = this.contract_type_list.find(c =>c.key == id )
    //   // console.log("Contract Type::", contractType)
    //   return contractType?contractType.value:null
    // },
    setWorkTypes(ids){
      var ft=[]
      var len = ids?ids.length:null
      if(len>1){
        // console.log("LEN-IDS:", len)
        for(let i=0; i<len; i++){
          var workType = this.typeValue(ids[i])
          ft[i] = workType
        }
        let str = ft.toString()
        str = str.substring(0, str.length - 1);
        // console.log("STR:", str)
        return str ? str : ''
        
      }else{
        const work = this.work_types.find(c =>c.key == ids[0] )
        // console.log("Funding Type::", fundingType)
        return work?work.value.toString():null
      }
      
    },
    
    setAssetType(id){
      return "ZZZ"
      const assetType = this.work_types.find(c =>c.key == id )
      // console.log("Contract Type::", contractType)
      return assetType?assetType.value:null
    },
    typeValue(id){
      // console.log("VAL:", id)
      const val = this.asset_types.find(c =>c.key == id)
      return val?val.value:''
    },
    setAsseType(ids) {
      console.log("IDS:", ids)
      // return
      var ft=[]
      var len = ids?ids.length:null
      if(len>1){
        // console.log("LEN-IDS:", len)
        for(let i=0; i<len; i++){
          var assetType = this.typeValue(ids[i])
          ft[i] = assetType
        }
        let str = ft.toString()
        str = str.substring(0, str.length - 1);
        // console.log("STR:", str)
        return str ? str : ""
        
      }else{
        const asset = this.asset_types.find(c =>c.key == ids[0] )
        // console.log("Funding Type::", fundingType)
        return asset?asset.value.toString():null
      }
    },

    roadText(item){
      return item ? item.toString() : ""
    },
    startText(item){
      return item ? item.toString() : ""
    },
    endText(item){
      return item ? item.toString() : ""
    },
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
    },

    convertArrayOfObjectProvince(){
      let rows = this.province_list_rows.rows
      let headers = this.province_list_rows.headers
      let prov_list = rows.map(a => {
          let obj = {};
          a.forEach((v,i) => {
            obj[headers[i]] = v;
          });
          return obj;
      });
      console.log("prov_list-RESULT:", prov_list);
      this.province_list = prov_list
    },
    convertArrayOfObjectDistrict(){
      let rows = this.district_list_all.rows
      let headers = this.district_list_all.headers
      let dist_list = rows.map(a => {
          let obj = {};
          a.forEach((v,i) => {
            obj[headers[i]] = v;
          });
          return obj;
      });
      console.log("Dist_list-RESULT:", dist_list);
      this.district_list = dist_list
    },
    setTextProvince(pid){
      console.log("tex-province:", this.province_list_rows.rows)
      const province = this.province_list.find(p => (p.id == pid))
      console.log("province:", province)
      return province ? province.name : null
    },
    setTextDistrict(did){
      const district = this.district_list.find(d => (d.district_number == did))
      console.log("district:", district)
      return district ? district.name : null
    },
  },

  async mounted() {
    // this.lot_data = this.$route.params
    // console.log("lot-data",this.lot_data)
    console.log("LOT-DATA-LOT-DETAIL:", this.$store.state.Lots.LOT_DATA)
    this.lot_data = this.$store.state.Lots.LOT_DATA
    
    this.asset_types = await this.$store.dispatch('LOAD_ASSET_TYPES')
    console.log("asset_types:",this.asset_types)
    this.work_types = await this.$store.dispatch('LOAD_WORK_TYPES')
    console.log("work_types:",this.work_types)

    this.province_list_rows = await this.$store.dispatch('Lots/LOAD_PROVINCE_LIST', this.domain)
    console.log("province_list_rows:", this.province_list_rows)
    this.convertArrayOfObjectProvince()

    // this.district_list_rows = await this.$store.dispatch('Lots/LOAD_DISTRICTS_LIST', 1, this.domain)
    // console.log("district_list_rows:", this.district_list_rows)

    this.district_list_all = await this.$store.dispatch('Lots/LOAD_DISTRICTS_LIST_ALL', this.domain)
    console.log("district_list_all:", this.district_list_all)
    this.convertArrayOfObjectDistrict()
    // const value = this.LotAmnt;
    // this.LotAmnt = value == '' ? null : Number(value).toLocaleString();
  }
};
</script>
<style>
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
    width: 30%;
    font-weight: bold;
    font-size: 16px !important;
    background-color: #1dd0b2;
    color: white;
    border: 1.2px solid #9f9d9d !important;
}
.tr1 {
    width: 70%;
    font-weight: bold;
    font-size: 16px !important;
    background-color: #1dd0b2;
    color: white;
    border: 1.2px solid #9f9d9d !important;
}
.td0 {
    text-align: right;
}
.td1 {
    text-align: left;
    font-family: phetsarath_ot;
}
.td2 {
    text-align: center;
    width: 250px;
}
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
