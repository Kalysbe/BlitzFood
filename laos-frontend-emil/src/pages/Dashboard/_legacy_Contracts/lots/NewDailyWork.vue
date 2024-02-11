<template>
    <md-dialog :md-active.sync="showDialog" md-fullscreen>
    <md-dialog-title style="height:20px;font-family:phetsarath_ot;" :style="{'color': getTitleColor()}">{{ formTitle }}</md-dialog-title>
        <md-card>
            <md-card-content>
                <div class="md-layout">
                    <div class="md-layout-item md-small-size-100 md-size-30">
                        <md-field>
                            <label for="LotNo">Lot No.</label>
                            <md-select v-show="this.editedIndex!=1" v-model="editedItem.lotno" name="LotNumber">
                                <md-option
                                    v-for="item in LotNos"
                                    :key="item.key"
                                    :label="item.value"
                                    :value="item.key"
                                >
                                    {{ item.value }}
                                </md-option>
                            </md-select>
                            <md-input v-show="this.editedIndex==1" v-model="editedItem.lotno" type="text" :disabled="this.editedIndex===1"></md-input>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-small-size-100 md-size-30">
                        <md-field>
                        <label>BoQ/MAC</label>
                        <md-input v-model="editedItem.boq_mac" type="text" :disabled="this.editedIndex===1"></md-input>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-small-size-100 md-size-30">
                        <md-field>
                        <label>Work Description</label>
                        <md-input v-model="editedItem.description" type="text" :disabled="this.editedIndex===1"></md-input>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-small-size-100 md-size-30">
                        <md-field>
                        <label>Road No.</label>
                        <md-input v-model="editedItem.roadno" type="text" :disabled="this.editedIndex===1"></md-input>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-small-size-100 md-size-30">
                        <md-field>
                        <label>Link No.</label>
                        <md-input v-model="editedItem.linkno" type="text" :disabled="this.editedIndex===1"></md-input>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-small-size-100 md-size-30">
                        <md-field>
                        <label>Start Milleage</label>
                        <md-input v-model="editedItem.start_m" type="text" :disabled="this.editedIndex===1"></md-input>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-small-size-100 md-size-30">
                        <md-field>
                        <label>End Milleage</label>
                        <md-input v-model="editedItem.end_m" type="text" :disabled="this.editedIndex===1"></md-input>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-small-size-100 md-size-30">
                        <md-field>
                        <label>Quantity</label>
                        <md-input v-model="editedItem.quantity" type="text" @focus="unformatNumber" @blur="formatNumber($event)"
                            @keypress="isNumber($event)" :disabled="this.editedIndex===1"></md-input>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-small-size-100 md-size-30">
                        <md-datepicker v-show="this.editedIndex!=1" v-model="editedItem.date" md-immediately :disabled="this.editedIndex===1">
                            <label>Date</label>
                        </md-datepicker>
                        <md-field v-show="this.editedIndex==1">
                            <label>Date</label>
                            <md-input v-model="editedItem.date" type="text" :disabled="this.editedIndex===1"></md-input>
                        </md-field>
                    </div>
                </div>
            </md-card-content>

            <md-dialog-actions>
                <md-button class="md-warning" @click.native="closeForm">{{ $t('contract.close') }}</md-button>
                <md-button v-show="this.editedIndex!=1" class="md-success" @click.native="saveForm()">{{ $t('contract.save') }}</md-button>
            </md-dialog-actions>
        </md-card>
    </md-dialog>
</template>

<script>
    import {mapActions, mapState} from 'vuex'
    import Swal from "sweetalert2"
    export default {
        name: 'NewDailyWork',
        props: ['showForm', 'edit_data', 'editedIndex'],
        data: () => ({
            editedIndexForm: -1,
            editedItem: {
                lotno: '',
                boq_mac: '',
                description: '',
                roadno: '',
                linkno: '',
                start_m: '',
                end_m: '',
                quantity: null,
                date: new Date().toISOString().substr(0, 10),
            },
            defaultItem: {
                lotno: '',
                boq_mac: '',
                description: '',
                roadno: '',
                linkno: '',
                start_m: '',
                end_m: '',
                quantity: null,
                date: new Date().toISOString().substr(0, 10),
            },
            LotNos: [
                {key: 1, value: '1'}, {key: 2, value: '2'}, {key: 3, value: '3'},
                {key: 4, value: '4'}, {key: 5, value: '5'}, {key: 6, value: '6'},
                {key: 7, value: '7'}, {key: 8, value: '8'}, {key: 9, value: '9'},
                {key: 10, value: '10'},
            ],
        }),
        computed: {
            ...mapState('Contract', [
                'show_new_dailywork_form'
            ]),
            showDialog(){
                if(this.editedIndex > -1){
                    this.setEditForm()
                }else{
                    this.clearForm()
                }
                
                return this.show_new_dailywork_form
            },
            formTitle () {
                return (this.editedIndex == -1 ? "New Daily Work" : (this.editedIndex == 0 ? "Edit Daily Work" : "View Daily Work"));
            },
        },
        watch: {
            
        },
        methods: {
            ...mapActions('Contract',[
                'showDailyWorkForm'
            ]),
            getTitleColor() {
                return (this.editedIndex == -1 ? '#345DA6' : (this.editedIndex == 0 ? '#47A44B' : '#00AEC5'));
            },
            clearForm() {
                this.editedItem.lotno = '' 
                this.editedItem.boq_mac = ''
                this.editedItem.description = ''
                this.editedItem.roadno = ''
                this.editedItem.linkno = ''
                this.editedItem.start_m = ''
                this.editedItem.end_m = ''
                this.editedItem.quantity = null
                this.editedItem.date = new Date().toISOString().substr(0, 10)
            },
            closeForm(){
                this.editedItem = {}
                this.clearForm() 
                this.showDailyWorkForm(false)
            },
            setEditForm(){
                this.editedItem.lotno = this.edit_data.lotno
                this.editedItem.boq_mac = this.edit_data.boq_mac
                this.editedItem.description = this.edit_data.description
                this.editedItem.roadno = this.edit_data.roadno
                this.editedItem.linkno = this.edit_data.linkno
                this.editedItem.start_m = this.edit_data.start_m
                this.editedItem.end_m = this.edit_data.end_m
                this.editedItem.quantity = this.edit_data.quantity
                this.editedItem.date = this.edit_data.date
            },
            saveForm(){
                this.editedItem.id_contract = ''
                console.log("DATA-FORM:", this.editedItem)
                Swal.fire({
                    title: `Daily work is saved...`,
                    buttonsStyling: false,
                    type: "success",
                    confirmButtonClass: "md-button md-success"
                });
                this.closeForm();
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
            }
        },
        async mounted() {

        },
        create(){
            
        }
    }
</script>

<style lang="scss" scoped>
// here replace /deep/ by ::v-deep
  .md-dialog ::v-deep .md-dialog-container {
    max-width: 900px;
    min-height: 380px;
  }
  .md-layout{
    width:800px;
  }
  
  .md-dialog-actions{
    margin-top:12px;
    margin-right:50px;
  }
</style>