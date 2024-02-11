<template>
    <div style="text-align:right; margin-top:10px;">
        <md-toolbar class="md-info emd-environment">
        <h4 class="md-title">Impact Evaluation Data</h4>
        </md-toolbar>
        <md-table v-model="iedetails" id="tbl-emd" table-header-color="black" table-header-bkcolor="grey" 
        table-header-fontweight="semi-bold" table-header-gridlines="true" table-cell-gridlines="true" :md-selected-value="iedetails[selRowId]">
            <md-table-row slot="md-table-row" slot-scope="{ item }" class="iram-row" md-selectable="single">
                <md-table-cell md-label="ID" style="width:10px;text-align:center;">{{ item.id }}</md-table-cell>
                <md-table-cell md-label="Act. Key" style="width:22px;">{{ item.actkey }}</md-table-cell>
                <md-table-cell md-label="Act. Name" >{{ item.actname }}</md-table-cell>      
                <md-table-cell md-label="Act. Impl. Value" style="width:22px;text-align:center;">{{ item.actimplemval }}</md-table-cell>
                <md-table-cell md-label="Comments" style="width:220px;">{{ item.comments }}</md-table-cell>
                <md-table-cell md-label="Actions" class="md-cell-action" style="width:8px;padding:0px;text-align:center;">
                <md-button 
                class="md-just-icon md-warning md-wd"
                    @click.native="handleDeleteIE(item)"
                    >
                    <md-tooltip md-direction="top">Delete Impact Evaluation Data</md-tooltip>
                    <md-icon>close</md-icon>
                </md-button>
                </md-table-cell>
        </md-table-row>
        </md-table>

        <md-button class="md-blue" style="height:22px;" @click.native="addNewIEData()">
            <md-tooltip md-direction="top">New Impact Evaluation Data</md-tooltip>
            <md-icon>add</md-icon>
        </md-button>
    </div>
</template>

<script>
import Swal from "sweetalert2";

const IEFromServer = [
    {
    id: "1",
    actkey: "IE100",
    actname: "jkjjljlktyuuiuiu",
    actimplemval: "Good",
    comments: "",
    },
    {
    id: "2",
    actkey: "IE200",
    actname: "nbmbxvcxcxcvxxcvv",
    actimplemval: "Satisfactory",
    comments: "",
    },
    {
    id: "3",
    actkey: "IE300",
    actname: "efjoiijoojioxccnnn",
    actimplemval: "Poor",
    comments: "",
    },
];

export default {
  name: 'ImpactEvaluation',
  props: {
    tableHeaderColor: {
       type: String,
       default: "",
    },
  },
  data() {
    return {
    selected: [],
    iedetails: IEFromServer,
    editedIndex: 0,
    edit_data: {},
    showform: false,
    selRowId: 0,
    };
  },
  methods: {
    addNewIEData() {
        var newIndex = this.iedetails.length + 1;
        this.iedetails.unshift({ id: newIndex.toString(), actkey: '', actname: '', actimplemval: '', comments: '' });

        this.selRowId = 0;
    },
    handleDeleteIE(item) {
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
            this.deleteRowIE(item);
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
    deleteRowIE(item) {
        let indexToDelete = this.iedetails.findIndex(
            tableRow => tableRow.id === item.id
        );
        if (indexToDelete >= 0) {
            this.iedetails.splice(indexToDelete, 1);
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