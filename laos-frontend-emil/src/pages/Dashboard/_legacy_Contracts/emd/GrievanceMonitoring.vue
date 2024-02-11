<template>
    <div style="text-align:right; margin-top:10px;">
        <md-toolbar class="md-info emd-environment">
        <h4 class="md-title">Grievance Monitoring Data</h4>
        </md-toolbar>
        <md-table v-model="gmdetails" id="tbl-emd" table-header-color="black" table-header-bkcolor="grey" 
        table-header-fontweight="semi-bold" table-header-gridlines="true" table-cell-gridlines="true" :md-selected-value="gmdetails[selRowId]">
            <md-table-row slot="md-table-row" slot-scope="{ item }" class="iram-row" md-selectable="single">
                <md-table-cell md-label="ID" style="width:10px;text-align:center;">{{ item.id }}</md-table-cell>
                <md-table-cell md-label="Act. Key" style="width:22px;">{{ item.actkey }}</md-table-cell>
                <md-table-cell md-label="Act. Name" >{{ item.actname }}</md-table-cell>      
                <md-table-cell md-label="Act. Impl. Value" style="width:22px;text-align:center;">{{ item.actimplemval }}</md-table-cell>
                <md-table-cell md-label="Comments" style="width:220px;">{{ item.comments }}</md-table-cell>
                <md-table-cell md-label="Actions" class="md-cell-action" style="width:8px;padding:0px;text-align:center;">
                <md-button 
                class="md-just-icon md-warning md-wd"
                    @click.native="handleDeleteGM(item)"
                    >
                    <md-tooltip md-direction="top">Delete Grievance Monitoring  Data</md-tooltip>
                    <md-icon>close</md-icon>
                </md-button>
                </md-table-cell>
        </md-table-row>
        </md-table>

        <md-button class="md-blue" style="height:22px;" @click.native="addNewGMData()">
            <md-tooltip md-direction="top">New Grievance Monitoring  Data</md-tooltip>
            <md-icon>add</md-icon>
        </md-button>
    </div>
</template>

<script>
import Swal from "sweetalert2";

const GMFromServer = [
    {
    id: "1",
    actkey: "GM100",
    actname: "jkjjljlktyuuiuiu",
    actimplemval: "Good",
    comments: "",
    },
    {
    id: "2",
    actkey: "GM200",
    actname: "nbmbxvcxcxcvxxcvv",
    actimplemval: "Satisfactory",
    comments: "",
    },
    {
    id: "3",
    actkey: "GM300",
    actname: "efjoiijoojioxccnnn",
    actimplemval: "Poor",
    comments: "",
    },
];

export default {
  name: 'GrievanceMonitoring',
  props: {
    tableHeaderColor: {
       type: String,
       default: "",
    },
  },
  data() {
    return {
    selected: [],
    gmdetails: GMFromServer,
    editedIndex: 0,
    edit_data: {},
    showform: false,
    selRowId: 0,
    };
  },
  methods: {
    addNewGMData() {
        var newIndex = this.gmdetails.length + 1;
        this.gmdetails.unshift({ id: newIndex.toString(), actkey: '', actname: '', actimplemval: '', comments: '' });

        this.selRowId = 0;
    },
    handleDeleteGM(item) {
        Swal.fire({
            title: "Are You Sure?",
            text: `You won't be able to revert this!`,
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "md-button md-success btn-fill",
            cancelButtonClass: "md-button md-danger btn-fill",
            confirmButtonText: "Yes, delete it!",
            buttonsStyling: false
        }).then(result => {
            if (result.value) {
            this.deleteRowGM(item);
            Swal.fire({
                title: "Deleted",
                text: `You deleted ${item.actname}`,
                type: "success",
                confirmButtonClass: "md-button md-success btn-fill",
                buttonsStyling: false
            });
            }
        });
    },
    deleteRowGM(item) {
        let indexToDelete = this.gmdetails.findIndex(
            tableRow => tableRow.id === item.id
        );
        if (indexToDelete >= 0) {
            this.gmdetails.splice(indexToDelete, 1);
        }
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
  }
}
</script>

<style lang="scss" scoped>
.iram-row {
    font-weight: 400 !important;
}

.emd-environment{
    height:20px; /* No result! */
}
#tbl-emd{
    height: 156px;
    text-align: left;
    vertical-align:middle;
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
</style>