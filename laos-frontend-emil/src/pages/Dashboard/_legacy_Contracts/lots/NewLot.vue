<template>
  <div>
    <!-- <md-card md-dynamic-height>
        <md-card-content> -->
            <md-dialog :md-active.sync="showDialog" md-fullscreen>
                <md-dialog-title style="font-family: phetsarath_ot;">{{ formTitle }}</md-dialog-title>
                <!-- row-1 -->
                <div class="md-layout md-size-100">
                    <div class="md-layout-item md-size-20">
                        <md-field>
                            <label>{{ $t('lots.lot_no') }}</label>
                            <md-input v-model="editedItem.lot_no" 
                            type="text"></md-input>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-30">
                        <md-field>
                            <label>{{ $t('lots.lot_name') }}</label>
                            <md-input v-model="editedItem.lot_name" 
                            type="text"></md-input>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-25">
                        <md-field>
                            <label>{{ $t('lots.local_financing') }}</label>
                            <md-input 
                                v-model="editedItem.local_financing" 
                                type="text"
                                @focus="unformatNumber"
                                @blur="formatNumber($event)"
                                @keypress="isNumber($event)" 
                                :disabled="this.editedIndex===1"
                                ></md-input>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-25">
                        <md-field>
                            <label>{{ $t('lots.contract_value') }}</label>
                            <md-input 
                                v-model="editedItem.contract_value" 
                                type="text"
                                @focus="unformatNumber"
                                @blur="formatNumber($event)"
                                @keypress="isNumber($event)" 
                                :disabled="this.editedIndex===1"
                            ></md-input>
                        </md-field>
                    </div>
                </div>
                <!-- row-2 -->
                <div class="md-layout md-size-100">
                    <div class="md-layout-item md-size-25">
                        <md-field>
                            <label for="province">{{ $t('lots.province') }}</label>
                            <md-select 
                                v-model="editedItem.id_province" 
                                name="provinces"
                                @md-selected="setDistrictList(editedItem.id_province)"
                            >
                            <md-option
                                v-for="item in Provinces"
                                :key="item.key"
                                :label="item.value"
                                :value="item.key"
                                
                            >
                                {{ item.value }}
                            </md-option>
                            </md-select>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-25">
                        <md-field>
                            <label for="District">{{ $t('lots.district') }}</label>
                            <md-select v-model="editedItem.id_district" name="district">
                            <md-option
                                v-for="item in Districts"
                                :key="item.key"
                                :label="item.value"
                                :value="item.key"
                            >
                                {{ item.value }}
                            </md-option>
                            </md-select>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-25">
                        <md-field>
                            <label for="WorkType">{{ $t('lots.work_type') }}</label>
                            <md-select v-model="editedItem.id_work_type" name="WorkType">
                                <md-option
                                    v-for="item in WorkTypes"
                                    :key="item.key"
                                    :label="item.value"
                                    :value="item.key"
                                >
                                    {{ item.value }}
                                </md-option>
                            </md-select>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-25">
                        <md-field>
                            <label for="AssetType">{{ $t('lots.asset_type') }}</label>
                            <md-select v-model="editedItem.id_asset_type" name="AssetType" multiple>
                                <md-option
                                    v-for="item in AssetTypes"
                                    :key="item.key"
                                    :label="item.value"
                                    :value="item.key"
                                >
                                    {{ item.value }}
                                </md-option>
                            </md-select>
                        </md-field>
                    </div>
                </div>
                <!-- row3 -->
                <div class="md-layout md-size-100">
                    <!-- <div class="md-layout-item md-size-25">
                        <md-field>
                            <label for="Assets">{{ $t('lots.assets') }}</label>
                            <md-input v-model="editedItem.id_asset" 
                            type="text"></md-input>
                        </md-field>
                    </div> -->
                    <div class="md-layout-item md-size-25">
                        <md-field>
                            <label for="Road">{{ $t('lots.road_number') }}</label>
                            <md-select v-model="editedItem.road_number" name="RoadNumber" multiple>
                                <md-option
                                    v-for="item in Roads"
                                    :key="item.key"
                                    :label="item.value"
                                    :value="item.value"
                                >
                                    {{ item.value }}
                                </md-option>
                            </md-select>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-20">
                        <md-field>
                            <label>{{ $t('lots.start_m') }}</label>
                            <md-input v-model="editedItem.start_m" type="text"></md-input>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-20">
                        <md-field>
                            <label>{{ $t('lots.end_m') }}</label>
                            <md-input v-model="editedItem.end_m" type="text"></md-input>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-20">
                        <md-field>
                            <label>{{ $t('lots.road_length') }}</label>
                            <md-input v-model="editedItem.road_length_m" type="text"></md-input>
                        </md-field>
                    </div>
                </div>
                <div class="md-layout md-size-100">
                    <div class="md-layout-item md-size-20">
                        <md-field>
                            <md-datepicker v-model="editedItem.start_date">
                                <label>{{ $t('contract.start_date') }}</label>
                            </md-datepicker>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-20">
                        <md-field>
                            <md-datepicker v-model="editedItem.end_date">
                                <label>{{ $t('contract.end_date') }}</label>
                            </md-datepicker>
                        </md-field>
                    </div>
                </div>
                <div>
                    <md-dialog-actions>
                    <md-button class="md-warning" @click.native="closeForm">{{ $t('contract.close') }}</md-button>
                    <md-button class="md-success" @click.native="saveForm()">{{ $t('contract.save') }}</md-button>
                </md-dialog-actions>
                </div>
                <!-- {{ edit_data }} -->
            </md-dialog>
            
        <!-- </md-card-content>
    </md-card> -->
    <!-- <md-button class="md-success md-raised" @click="showDialog = true">Add New Contract</md-button> -->
  </div>
</template>

<script>
    import {mapActions, mapState} from 'vuex'
    import Swal from "sweetalert2"
    export default {
        name: 'NewLot',
        props: ['showForm', 'edit_data', 'editedIndex'],
        data: () => ({
            editedIndexForm: -1,
            // editedIndex: -1,
            editedItem: {
                id_contract:"",         // missing from backend api
                lot_no: "",
                lot_name: "",
                contract_value: 0,
                local_financing: 0,
                id_province: '',
                id_district: '',
                id_work_type: '',
                id_asset_type: [],
                id_asset: null,
                id_road: null,
                road_number: [],
                start_m: 0,
                end_m: 0,
                road_length_m: 0,
                start_date: new Date().toISOString().substr(0, 10),
                end_date: new Date().toISOString().substr(0, 10),
            },
            defaultItem: {
                id_contract:"",         // missing from backend api
                lot_no: "",
                lot_name: "",
                contract_value: 0,
                local_financing: 0,
                id_province: '',
                id_district: '',
                id_work_type: '',
                id_asset_type: [],
                id_asset: null,
                id_road: null,
                road_number: [],
                start_m: 0,
                end_m: 0,
                road_length_m: 0,
                start_date: new Date().toISOString().substr(0, 10),
                end_date: new Date().toISOString().substr(0, 10),
            },
            Roads: [],
            province_list_rows: [],
            district_list_rows: [],
            Provinces: [],
            Districts: [],
            ContractTypes: [],
            AssetTypes: [],
            WorkTypes: [],
            FundingTypes: [],
            FundingSources: [],
            Contractors: [],
            // showDialog: false
        }),
        computed: {
            ...mapState('Contract', [
                'show_new_lot_form'
            ]),
            showDialog(){
                if(this.editedIndex == 0){
                    this.setEditForm()
                }else{
                    this.clearForm()
                }
                
                return this.show_new_lot_form
            },
            formTitle () {
                return this.editedIndex === -1 ? this.$t('lots.add_new_lot'): this.$t('lots.edit_lot') 
            },
            
        },
        watch: {
            
        },
        methods: {
            ...mapActions('Contract',[
                'showLotForm'
            ]),

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

            clearForm() {
                this.editedItem.id_contract = ''
                this.editedItem.lot_no = ''
                this.editedItem.lot_name = ''
                this.editedItem.contract_value = 0
                this.editedItem.road_number = []
                this.editedItem.road_length_m = 0
                this.editedItem.id_province = 0
                this.editedItem.id_district = 0
                this.editedItem.id_work_type = 0
                this.editedItem.id_asset_type = []
                this.editedItem.start_m = 0
                this.editedItem.end_m = 0
                this.editedItem.road_length_m = 0
                this.editedItem.local_financing = 0
                this.editedItem.start_date = new Date().toISOString().substr(0, 10),
                this.editedItem.end_date = new Date().toISOString().substr(0, 10)
            },
            closeForm(){
                this.editedItem = {}
                this.clearForm() 
                this.showLotForm(false)
            },
            setEditForm(){
                this.editedItem.id_contract = ''        // missing from backend api
                this.editedItem.lot_no = this.edit_data.lot_no
                this.editedItem.lot_name = this.edit_data.lot_name
                this.editedItem.contract_value = this.edit_data.contract_value
                this.editedItem.road_number = this.edit_data.road_number
                this.editedItem.road_length_m = this.edit_road_length_m
                this.editedItem.id_province = this.edit_data.id_province
                this.editedItem.id_district = this.edit_data.id_district
                this.editedItem.id_work_type = this.edit_data.id_work_type
                this.editedItem.id_asset_type = this.edit_data.id_asset_type
                this.editedItem.start_m = this.edit_data.start_m
                this.editedItem.end_m = this.edit_data.end_m
                this.editedItem.road_length_m = this.edit_data.road_length_m
                this.editedItem.local_financing = this.edit_data.local_financing
                this.editedItem.start_date = this.edit_data.start_date
                this.editedItem.end_date = this.edit_data.end_date
            },
            saveForm(){
                this.editedItem.id_contract = this.$store.state.Contract.CONTRACT_DATA.id
                console.log("LOT-DAT:", this.editedItem)
                const result = this.$store.dispatch('Lots/ADD_NEW_LOT', this.editedItem)
                if(result){
                    Swal.fire({
                    title: `Lot is created...`,
                    buttonsStyling: false,
                    type: "success",
                    confirmButtonClass: "md-button md-success"
                    });
                }else{
                     Swal.fire({
                        title: `Lot creation is failed...`,
                        buttonsStyling: false,
                        type: "warning",
                        confirmButtonClass: "md-button md-warning"
                    });
                }
               
                // this.closeForm();
            },
            async setDistrictList(pid){
                const districts_list = await this.$store.dispatch('Lots/LOAD_DISTRICT_LIST_KV', pid, this.domain)
                this.Districts = [...districts_list]
                console.log("this.Districts:", this.Districts)

                //list of provinces if privice_id : 0 => national webGis, 99: morethan one provinces covered
                this.editedItem.road_number = []
                const load_list = await this.$store.dispatch('Lots/LOAD_ROADS_LIST_VK', pid, this.domain)
                this.Roads = [...load_list]
                console.log("Roads:", this.Roads)
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
            this.Provinces = prov_list
            },
            convertArrayOfObjectDistrict(){
            let rows = this.district_list_rows.rows
            let headers = this.district_list_rows.headers
            let dist_list = rows.map(a => {
                let obj = {};
                a.forEach((v,i) => {
                    obj[headers[i]] = v;
                });
                return obj;
            });
            console.log("Dist_list-RESULT:", dist_list);
            this.Districts = dist_list
            },
            
        },
        
        async mounted() {
            const contrac_types_list = await this.$store.dispatch('LOAD_CONTRACT_REPORTS_LIST')
            // console.log("data_list:", contrac_types_list)
            this.ContractTypes = [...contrac_types_list]
            console.log("ContractTypes:", this.ContractTypes)
            const asset_types_list = await this.$store.dispatch('LOAD_ASSET_TYPES')
            // console.log("asset_types_list:", asset_types_list)
            this.AssetTypes = [...asset_types_list]
            // console.log("ASSET_Types:", this.AssetTypes)
            const contractors_list = await this.$store.dispatch('LOAD_CONTRACTORS')
            this.Contractors = [...contractors_list]
            const worktypes_list = await this.$store.dispatch('LOAD_WORK_TYPES')
            this.WorkTypes = [...worktypes_list]
            const fundingtypes_list = await this.$store.dispatch('LOAD_FUNDING_TYPES')
            console.log("fundingtypes_list:", fundingtypes_list)
            this.FundingTypes = [...fundingtypes_list]
            
            const fundingsources_list = await this.$store.dispatch('LOAD_FUNDING_SOURCES')
            this.FundingSources = [...fundingsources_list]

            const provinces_list = await this.$store.dispatch('Lots/LOAD_PROVINCE_LIST_KV', this.domain)
            console.log("provinces_list:", provinces_list)
            this.Provinces = [...provinces_list]
            console.log("this.Provinces:", this.Provinces)
            // // this.convertArrayOfObjectProvince()

            

            // this.convertArrayOfObjectDistrict()
        },
        create(){
            
        }
    }
</script>

<style lang="scss" scoped>
// here replace /deep/ by ::v-deep
  .md-dialog ::v-deep .md-dialog-container {
    min-width: 768px;
    min-height: 400px;
  }
</style>