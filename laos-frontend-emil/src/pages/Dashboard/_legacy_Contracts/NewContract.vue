<template>
  <div>
    <!-- <md-card md-dynamic-height>
        <md-card-content> -->
            <md-dialog :md-active.sync="showDialog" md-fullscreen>
                <md-dialog-title class="form_title">{{ formTitle }}</md-dialog-title>
                <!-- rom1 -->
                <md-divider></md-divider>
                <form>
                    <div class="md-layout">
                        <div class="md-layout-item md-size-35">
                            <md-field>
                                <label>{{ $t('contracts_list.project_name') }}</label>
                                <md-input v-model="editedItem.project_name" 
                                type="text"></md-input>
                            </md-field>
                        </div>
                        <div class="md-layout-item md-size-35">
                            <md-field>
                                <label>{{ $t('contracts_list.contract_title') }}</label>
                                <md-input v-model="editedItem.contract_title" 
                                type="text"></md-input>
                            </md-field>
                        </div>
                        <div class="md-layout-item md-size-30">
                            <md-field>
                                <label>{{ $t('contracts_list.contract_number') }}</label>
                                <md-input v-model="editedItem.contract_number" 
                                type="text"></md-input>
                            </md-field>
                        </div>
                    </div>
                        <!-- row-2 -->
                    <div class="md-layout">
                        <div class="md-layout-item md-size-40">
                            <md-field>
                                <label for="Contractor">{{ $t('contracts_list.contractor_name') }}</label>
                                <md-select v-model="editedItem.id_contractor" name="Contractor">
                                    <md-option
                                        v-for="item in Contractors"
                                        :key="item.key"
                                        :label="item.value"
                                        :value="item.key"
                                    >
                                        {{ item.value }}
                                    </md-option>
                                </md-select>
                            </md-field>
                        </div>
                        <div class="md-layout-item md-size-40">
                            <md-field>
                                <label for="ContractTypes">{{ $t('contracts_list.contract_type') }}</label>
                                <md-select v-model="editedItem.id_contract_type" name="ContractTypes">
                                    <md-option
                                        v-for="item in ContractTypes"
                                        :key="item.key"
                                        :label="item.value"
                                        :value="item.key"
                                    >
                                        {{ item.value }}
                                    </md-option>
                                </md-select>
                            </md-field>
                        </div>
                        <div class="md-layout-item md-size-20">
                            <md-field>
                                <label for="Employer">{{ $t('contracts_list.employer') }}</label>
                                <md-select v-model="editedItem.id_employer" name="Employer">
                                    <md-option
                                        v-for="(item) in Employers"
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
                        <!-- row2 -->
                    <div class="md-layout">
                        <div class="md-layout-item md-size-30">
                            <md-field>
                                <label for="FundingType">{{ $t('contract.funding_type') }}</label>
                                <md-select v-model="editedItem.id_funding_type" name="FundingType" multiple>
                                    <md-option
                                        v-for="item in FundingTypes"
                                        :key="item.key"
                                        :label="item.value"
                                        :value="item.key"
                                    >
                                        {{ item.value }}
                                    </md-option>
                                </md-select>
                            </md-field>
                        </div>
                        <div class="md-layout-item md-size-30">
                            <md-field>
                                <label for="FundingSource">{{ $t('contract.funding_source') }}</label>
                                <md-select v-model="editedItem.id_funding_source" name="FundingSource" multiple>
                                    <md-option
                                        v-for="item in FundingSources"
                                        :key="item.key"
                                        :label="item.value"
                                        :value="item.key"
                                    >
                                        {{ item.value }}
                                    </md-option>
                                </md-select>
                            </md-field>
                        </div>                  
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
                        <!-- <div class="md-layout-item md-size-15">
                            <md-field>
                                <label for="WorkType">{{ $t('contract.work_type') }}</label>
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
                        </div> -->
                        <!-- <div class="md-layout-item md-size-15">
                            <md-field>
                                <label for="AssetType">{{ $t('contract.asset_type') }}</label>
                                <md-select v-model="editedItem.id_asset_type" name="AssetType">
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
                        </div> -->
                        <!-- <div class="md-layout-item md-size-25">
                            <md-field>
                                <label for="Assets">{{ $t('contract.assets') }}</label>
                                <md-input v-model="editedItem.id_asset" 
                                type="text"></md-input>
                            </md-field>
                        </div> -->
                    
                    <!-- row3 -->
                    <!-- <div class="md-layout">
                        <div class="md-layout-item md-size-15">
                            <md-field>
                                <label for="Road">{{ $t('contract.road_number') }}</label>
                                <md-select v-model="editedItem.road_number" name="RoadNumber" multiple>
                                    <md-option
                                        v-for="item in Roads"
                                        :key="item.key"
                                        :label="item.value"
                                        :value="item.key"
                                    >
                                        {{ item.value }}
                                    </md-option>
                                </md-select>
                            </md-field>
                        </div> -->
                        <!-- <div class="md-layout-item md-size-15">
                            <md-field>
                                <label>{{ $t('contract.chainage') }}</label>
                                <md-input v-model="editedItem.chainage" type="text"></md-input>
                            </md-field>
                        </div> -->
                        <!-- <div class="md-layout-item md-size-15">
                            <md-field>
                                <label>{{ $t('contract.total_length') }}</label>
                                <md-input v-model="editedItem.total_road_length_m" type="text"></md-input>
                            </md-field>
                        </div> -->
                        
                    <!-- </div> -->
                    <!-- <md-divider class="md-inset"></md-divider> -->
                    <md-divider></md-divider>
                    <div>
                        <md-dialog-actions>
                        <md-button class="md-warning" @click.native="closeForm">{{ $t('contract.close') }}</md-button>
                        <md-button class="md-success" @click="saveForm()">{{ $t('contract.save') }}</md-button>
                    </md-dialog-actions>
                    </div>
                </form>
            </md-dialog>
            
        <!-- </md-card-content>
    </md-card> -->
    <!-- <md-button class="md-success md-raised" @click="showDialog = true">Add New Contract</md-button> -->
  </div>
</template>

<script>
    import {mapActions, mapState} from 'vuex'
    import Swal from "sweetalert2"
    import OldContracts from "@/store/oldContract";
    export default {
        name: 'NewContract',
        props: ['showForm', 'edit_data', 'editedIndex'],
        data: () => ({
            editedIndexForm: -1,
            editedItem: {
                project_name: '',
                contract_title: '',
                contract_number: '',
                id_contract_type: '',
                id_contractor: '',
                id_employer: '',
                id_funding_type: [],
                id_funding_source: [],
                start_date: new Date().toISOString().substr(0, 10),
                end_date: new Date().toISOString().substr(0, 10),
                // total_road_length_m: 0,
            },
            defaultItem: {
                project_name: '',
                contract_title: '',
                contract_number: '',
                id_contract_type: '',
                id_contractor: '',
                id_employer: '',
                id_funding_type: [],
                id_funding_source: [],
                start_date: new Date().toISOString().substr(0, 10),
                end_date: new Date().toISOString().substr(0, 10),
                // total_road_length_m: 0,
            },
            Roads: [
                {
                    key: 1, value: '123'
                },
                {
                    key: 2, value: '456'
                },
                {
                    key: 3, value: '789'
                },
            ],
            Employers: [
                {
                    key: 1, value: 'MPWT'
                },
                {
                    key: 2, value: 'DPWT'
                },
                {
                    key: 3, value: 'OTHER'
                },
            ],
            Provinces: [],
            ContractTypes: [],
            AssetTypes: [],
            WorkTypes: [],
            FundingTypes: [],
            FundingSources: [],
            Contractors: [],
            // showDialog: false
        }),
        computed: {
            ...mapState(['show_new_contract_form']),
            showDialog(){
                console.log("MODE:", this.editedIndex)
                // if(this.editedIndex == 0){
                //     this.setEditForm()
                // }else{
                //     this.clearForm()
                // }
                if(this.editedIndex == 0){
                    this.setEditForm()
                }
                if(this.editedIndex == -1){
                    this.clearForm()
                }
                return this.show_new_contract_form
            },
            formTitle () {
                // if(this.$i18n.locale == "en"){

                // }
                return this.editedIndex === -1 ? this.$t('contract.new_contract') : this.$t('contract.edit_contract')
            },
            
        },
        watch: {
            
        },
        methods: {
            ...mapActions(['showContracForm']),
            clearForm() {
                // this.editedItem = {}
                this.editedItem.project_name = ''
                this.editedItem.contract_title = ''
                this.editedItem.contract_number = ''
                // this.editedItem.id_employer = ''
                this.editedItem.id_contractor = ''
                this.editedItem.id_contract_type = ''
                this.editedItem.id_funding_type = []
                this.editedItem.id_funding_source = []
                this.editedItem.start_date = new Date().toISOString().substr(0, 10),
                this.editedItem.end_date = new Date().toISOString().substr(0, 10)
            },
            closeForm(){
                // this.editedItem = {}
                // this.clearForm() 
                this.showContracForm(false)
                // this.editedItem = -1
            },
            setEditForm(){
                this.editedItem.project_name = this.edit_data.project_name
                this.editedItem.contract_title = this.edit_data.contract_title
                this.editedItem.contract_number = this.edit_data.contract_number
                // this.editedItem.id_employer = this.edit_data.id_employer
                this.editedItem.id_contractor = this.edit_data.id_contractor
                this.editedItem.id_contract_type = this.edit_data.id_contract_type
                this.editedItem.id_funding_type = this.edit_data.id_funding_type
                // this.editedItem.id_funding_source = this.edit_data.id_funding_source
                this.editedItem.start_date = this.edit_data.start_date
                this.editedItem.end_date = this.edit_data.end_date
            },
            saveForm(){
                console.log("DATA-FORM:", this.editedItem)
                // return
                const result = this.$store.dispatch('AddNewContract', this.editedItem)
                console.log("Result-post:", result)
                Swal.fire({
                    title: `Contract is saved...`,
                    buttonsStyling: false,
                    type: "success",
                    confirmButtonClass: "md-button md-success"
                });
                // this.closeForm();
            }
            
        },
        async mounted() {
            const contrac_types_list = await this.$store.dispatch('LOAD_CONTRACT_REPORTS_LIST')

            console.log("data_list:", contrac_types_list)
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
            this.FundingTypes = [...fundingtypes_list]
            console.log("this.FundingTypes:", this.FundingTypes)
            const fundingsources_list = await this.$store.dispatch('LOAD_FUNDING_SOURCES')
            this.FundingSources = [...fundingsources_list]

            // this.editedIndex = -1
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
  .form_title {
    font-family: phetsarath_ot;
    background-color: rgb(10, 139, 83);
  }
</style>