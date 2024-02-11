<template>
    <md-dialog :md-active.sync="showDialog" md-fullscreen>
    <md-dialog-title style="height:20px;font-family:phetsarath_ot;" :style="{'color': getTitleColor()}">{{ formTitle }}</md-dialog-title>
        <md-card style="padding-top:10px">
            <md-card-content>
                <md-tabs class="md-primary" @md-changed="tabChanged">
                    <md-tab id="tab-environment" md-label="Environmental Monitoring" md-icon="eco" @click.native="changeTab"></md-tab>
                    <md-tab id="tab-impact" md-label="Impact Evaluation" md-icon="healing"></md-tab>
                    <md-tab id="tab-accident" md-label="Accident" md-icon="taxi_alert"></md-tab>
                    <md-tab id="tab-social" md-label="Social Monitoring" md-icon="group"></md-tab>
                    <md-tab id="tab-grievance" md-label="Grievance Monitoring" md-icon="forum"></md-tab>
                </md-tabs>

                <div v-show='selectedTab=="tab-environment"'>
                    <EnvironmentMonitor></EnvironmentMonitor>
                </div>
                <div v-show='selectedTab=="tab-impact"'>
                    <ImpactEvaluation></ImpactEvaluation>
                </div>
                <div v-show='selectedTab=="tab-accident"'>
                    <Accident></Accident>
                </div>
                <div v-show='selectedTab=="tab-social"'>
                    <SocialMonitoring></SocialMonitoring>
                </div>
                <div v-show='selectedTab=="tab-grievance"'>
                    <GrievanceMonitoring></GrievanceMonitoring>
                </div>

            </md-card-content>

            <md-dialog-actions>
                <md-button class="md-success" @click.native="saveForm()">{{ $t('contract.save') }}
                    <md-tooltip md-direction="top">Save Mass Selection Change</md-tooltip>
                </md-button>      
                <md-button class="md-blue" @click.native="closeForm">{{ $t('contract.close') }}
                </md-button>      
            </md-dialog-actions>
        </md-card>
    </md-dialog>
</template>

<script>
    import Swal from "sweetalert2";
    
    import '@/components/EditableTable/slick.grid.css';
    import '@/components/EditableTable/controls/slick.pager.css';
    import '@/components/EditableTable/css/smoothness/jquery-ui.css';
    import '@/components/EditableTable/iram2.css';
    import '@/components/EditableTable/controls/slick.columnpicker.css'
    import '@/components/EditableTable/plugins/slick.headermenu.css'
    import '@/components/EditableTable/plugins/slick.cellmenu.css'
    import '@/components/EditableTable/plugins/slick.contextmenu.css'
    import '@/components/EditableTable/plugins/slick.rowdetailview.css'
    import '@/components/EditableTable/plugins/slick.headerbuttons.css'

    import '@/components/EditableTable/lib/firebugx.js'

    import '@/components/EditableTable/lib/jquery-1.12.4.min.js'
    import '@/components/EditableTable/lib/jquery-ui.min.js'
    import '@/components/EditableTable/lib/jquery.event.drag-2.3.0.js'

    import '@/components/EditableTable/slick.core.js'
    import '@/components/EditableTable/slick.formatters.js'
    import '@/components/EditableTable/slick.editors.js'
    import '@/components/EditableTable/plugins/slick.rowselectionmodel.js'
    import '@/components/EditableTable/slick.grid.js'
    import '@/components/EditableTable/slick.dataview.js'
    import '@/components/EditableTable/controls/slick.pager.js'
    import '@/components/EditableTable/controls/slick.columnpicker.js'
    import '@/components/EditableTable/plugins/slick.headermenu.js'
    import '@/components/EditableTable/plugins/slick.checkboxselectcolumn.js'
    import '@/components/EditableTable/plugins/slick.cellmenu.js'
    import '@/components/EditableTable/plugins/slick.contextmenu.js'
    import '@/components/EditableTable/plugins/slick.rowdetailview.js'
    import '@/components/EditableTable/slick.compositeeditor.js'
    import '@/components/EditableTable/plugins/slick.headerbuttons.js'

    import {mapActions, mapState} from 'vuex'
    import EnvironmentMonitor from './emd/EnvironmentMonitor'
    import ImpactEvaluation from './emd/ImpactEvaluation'
    import Accident from './emd/Accident'
    import SocialMonitoring from './emd/SocialMonitoring'
    import GrievanceMonitoring from './emd/GrievanceMonitoring'

    export default {
        name: 'ContractEnvironment',
        props: ['showForm'],
        data: () => ({
            editedItem: {},
            selectedTab: '',
        }),
        components: {
            EnvironmentMonitor,
            ImpactEvaluation,
            Accident,
            SocialMonitoring,
            GrievanceMonitoring
        },
        computed: {
            ...mapState('Contract', [
                'show_roadenvironment_form'
            ]),
            showDialog(){
                return this.show_roadenvironment_form
            },
            formTitle () {
                return "Road Contract Environment Information";
            },
        },
        watch: {
            
        },
        methods: {
            ...mapActions('Contract',[
                'showRoadEnvironmentForm'
            ]),
            getTitleColor() {
                return '#47A44B';
            },
            closeForm(){
                this.showRoadEnvironmentForm(false)
            },
            saveForm(){
                this.editedItem.id_contract = ''
                Swal.fire({
                    title: `Road Contract Environment Information is saved...`,
                    buttonsStyling: false,
                    type: "success",
                    confirmButtonClass: "md-button md-success"
                });
                //this.closeForm();
            },
            tabChanged(activeTab){
                //console.log(activeTab);
                this.selectedTab = activeTab;
            }
        },
        mounted() {
            
        },
        create(){
 
        }
    }
</script>

<style lang="scss" scoped>
  .md-tabs + .md-tabs {
    margin-top: 24px;
  }
  .md-dialog{
    height: 800px; 
   }
  .md-dialog ::v-deep .md-dialog-container {
    max-width: 1000px;
    min-width: 1000px;
    min-height: 410px;
  }
  .md-layout, .md-card-content{
    width: 1000px;
    height: 480px;
  }

  .md-dialog-actions{
    margin-top:12px;
    margin-right:30px;
  }

</style>