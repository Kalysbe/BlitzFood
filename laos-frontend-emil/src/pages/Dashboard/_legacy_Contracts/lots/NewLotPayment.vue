<template>
    <md-dialog :md-active.sync="showDialog" md-fullscreen>
    <md-dialog-title style="height:20px;font-family:phetsarath_ot;" :style="{'color': getTitleColor()}">{{ formTitle }}</md-dialog-title>
        <md-card>
            <md-card-content>
                <div class="md-layout">
                    <div class="md-layout-item md-small-size-100 md-size-30">
                        <md-field>
                        <label>ID</label>
                        <md-input v-model="editedItem.id" type="text" :disabled="this.editedIndex===1"></md-input>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-small-size-100 md-size-30">
                        <md-field>
                            <label>Description</label>
                            <md-input v-model="editedItem.description" type="text" :disabled="this.editedIndex===1"></md-input>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-small-size-100 md-size-30">
                        <md-field>
                        <label>Sum</label>
                        <md-input v-model="editedItem.amnt" type="text" @focus="unformatNumber" @blur="formatNumber($event)"
                            @keypress="isNumber($event)" :disabled="this.editedIndex===1"></md-input>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-small-size-100 md-size-30">
                        <div id="chkPaid">
                            <md-field><input type="checkbox" v-model="editedItem.paid" :disabled="this.editedIndex===1">
                                <i style="width:13px;"></i><i style="color:#B0B0B0;font-weight:bold;font-style:normal;">Paid</i>
                            </md-field>
                        </div>
                    </div>
                    <div class="md-layout-item md-small-size-100 md-size-30">
                        <md-datepicker v-show="this.editedIndex!=1" v-model="editedItem.datepaid" md-immediately :disabled="this.editedIndex===1">
                            <label>Date Paid</label>
                        </md-datepicker>
                        <md-field v-show="this.editedIndex==1">
                            <label>Date Paid</label>
                            <md-input v-model="editedItem.datepaid" type="text" :disabled="this.editedIndex===1"></md-input>
                        </md-field>              
                    </div>
                    <div class="md-layout-item md-small-size-100 md-size-30">
                        <md-datepicker v-show="this.editedIndex!=1" v-model="editedItem.dl" md-immediately :disabled="this.editedIndex===1">
                            <label>DL</label>
                        </md-datepicker>
                        <md-field v-show="this.editedIndex==1">
                            <label>DL</label>
                            <md-input v-model="editedItem.dl" type="text" :disabled="this.editedIndex===1"></md-input>
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
        name: 'NewLotPayment',
        props: ['showForm', 'edit_data', 'editedIndex'],
        data: () => ({
            editedIndexForm: -1,
            editedItem: {
                id: '',
                description: '',
                amnt: null,
                paid: false,
                datepaid: null,
                dl: new Date().toISOString().substr(0, 10),
            },
            defaultItem: {
                id: '',
                description: '',
                amnt: null,
                paid: false,
                datepaid: null,
                dl: new Date().toISOString().substr(0, 10),
            },
        }),
        computed: {
            ...mapState('Contract', [
                'show_new_lotpayment_form'
            ]),
            showDialog(){
                if(this.editedIndex > -1){
                    this.setEditForm()
                }else{
                    this.clearForm()
                }
                
                return this.show_new_lotpayment_form
            },
            formTitle () {
                return (this.editedIndex == -1 ? "New Lot Payment" : (this.editedIndex == 0 ? "Edit Lot Payment" : "View Lot Payment"));
            },
        },
        watch: {
            
        },
        methods: {
            ...mapActions('Contract',[
                'showLotPaymentForm'
            ]),
            getTitleColor() {
                return (this.editedIndex == -1 ? '#345DA6' : (this.editedIndex == 0 ? '#47A44B' : '#00AEC5'));
            },
            clearForm() {
                this.editedItem.id = ''
                this.editedItem.description = ''
                this.editedItem.amnt = null
                this.editedItem.paid = false
                this.editedItem.datepaid = null
                this.editedItem.dl = new Date().toISOString().substr(0, 10)
            },
            closeForm(){
                this.editedItem = {}
                this.clearForm() 
                this.showLotPaymentForm(false)
            },
            setEditForm(){
                this.editedItem.id = this.edit_data.id
                this.editedItem.description = this.edit_data.description
                this.editedItem.amnt = this.edit_data.amnt
                this.editedItem.paid = this.edit_data.paid
                this.editedItem.datepaid = this.edit_data.datepaid
                this.editedItem.dl = this.edit_data.dl
            },
            saveForm(){
                this.editedItem.id_contract = ''
                console.log("DATA-FORM:", this.editedItem)
                Swal.fire({
                    title: `Lot payment is saved...`,
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
        mounted() {
            
        },
        create(){
 
        }
    }
</script>

<style lang="scss" scoped>
// here replace /deep/ by ::v-deep
  .md-dialog ::v-deep .md-dialog-container {
    max-width: 900px;
    min-height: 180px;
  }
  .md-layout{
    width:800px;
  }
  input[type='checkbox'] {
    width:18px;
    height:18px;
    background:white;
    border-radius:5px;
    border:2px solid #555;
    margin-bottom: 12px;
    cursor: pointer;
  }
  input[type='checkbox']:checked {
    background: #abd;
  }
  #chkPaid{
    margin-top: 19px;
  }
  .md-dialog-actions{
    margin-top:12px;
    margin-right:50px;
  }
</style>