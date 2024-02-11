<template>
  <!-- <div class="md-layout"> -->
  <div class="md-dialog-content">
  <div class="my-popup" v-show="IsPopup" id="myPopUp">
    <div class="md-layout-item md-size-200">
      <md-card>
        <md-card-header class="md-card-header-icon md-card-header-green">
          <div class="card-icon">
            <md-icon>assignment</md-icon>
          </div>
          <h4 class="title">New Contract</h4>
        </md-card-header>
        <md-card-content>
            <!-- first row -->
          <div class="md-layout">
            <div class="md-layout-item md-size-15">
              <md-field>
                <label>Contract ID</label>
                <md-input v-model="layout1" type="text"></md-input>
              </md-field>
            </div>
            <div class="md-layout-item md-size-15">
              <md-field>
                <label for="Road">Road</label>
                <md-select v-model="layout2" name="layout2">
                  <md-option
                    v-for="item in Roads"
                    :key="item"
                    :label="item"
                    :value="item"
                  >
                    {{ item }}
                  </md-option>
                </md-select>
              </md-field>
            </div>
            <div class="md-layout-item md-size-15">
              <md-field>
                <label for="Province">Province</label>
                <md-select v-model="layout3" name="layout3">
                  <md-option
                    v-for="item in Provinces"
                    :key="item"
                    :label="item"
                    :value="item"
                  >
                    {{ item }}
                  </md-option>
                </md-select>
              </md-field>
            </div>
            <div class="md-layout-item md-size-15">
              <md-field>
                <label>Chainage</label>
                <md-input v-model="layout3" type="text"></md-input>
              </md-field>
            </div>
            <div class="md-layout-item md-size-15">
              <md-field>
                <label>Length(m)</label>
                <md-input v-model="layout3" type="text"></md-input>
              </md-field>
            </div>
            <div class="md-layout-item md-size-15">
              <md-field>
                <label for="ContractTypes">Conytract Type</label>
                <md-select v-model="layout4" name="layout4">
                  <md-option
                    v-for="item in ContractTypess"
                    :key="item"
                    :label="item"
                    :value="item"
                  >
                    {{ item }}
                  </md-option>
                </md-select>
              </md-field>
            </div>
          </div>
          <!-- second row -->
          <div class="md-layout">
            <div class="md-layout-item md-size-15">
              <md-field>
                <label for="WorkType">Work Type</label>
                <md-select v-model="layout5" name="layout5">
                  <md-option
                    v-for="item in WorkTypes"
                    :key="item"
                    :label="item"
                    :value="item"
                  >
                    {{ item }}
                  </md-option>
                </md-select>
              </md-field>
            </div>
            <div class="md-layout-item md-size-15">
              <md-field>
                <label>Contract Start</label>
                <md-input v-model="layout2" type="text"></md-input>
              </md-field>
            </div>
            <div class="md-layout-item md-size-15">
              <md-field>
                <label>Contract End</label>
                <md-input v-model="layout3" type="text"></md-input>
              </md-field>
            </div>
            <div class="md-layout-item md-size-15">
              <md-field>
                <label for="FundingType">Funding Type</label>
                <md-select v-model="layout6" name="layout6">
                  <md-option
                    v-for="item in FundingTypes"
                    :key="item"
                    :label="item"
                    :value="item"
                  >
                    {{ item }}
                  </md-option>
                </md-select>
              </md-field>
            </div>
            <div class="md-layout-item md-size-15">
              <md-field>
                <label for="FundingSource">Funding Source</label>
                <md-select v-model="layout6" name="layout6">
                  <md-option
                    v-for="item in FundingSources"
                    :key="item"
                    :label="item"
                    :value="item"
                  >
                    {{ item }}
                  </md-option>
                </md-select>
              </md-field>
            </div>
            <div class="md-layout-item md-size-15">
              <md-field>
                <label for="Contractor">Contractor ID</label>
                <md-select v-model="layout7" name="layout7">
                  <md-option
                    v-for="item in Contractors"
                    :key="item"
                    :label="item"
                    :value="item"
                  >
                    {{ item }}
                  </md-option>
                </md-select>
              </md-field>
            </div>
          </div>
          <div>
              <md-button
                style="float: right;"
                class="md-success md-wd"
                @click.native="handleLike(item)"
                >
                Add Contract
              </md-button>
            <!-- </md-table-cell> -->
          </div>
        </md-card-content>
      </md-card>
    </div>
  </div>
  </div>
</template>
<script>
export default {
  name: 'conytactform',
  components: {},
  data() {
    return {
      IsPopup: false,
      layout1: null,
      layout2: null,
      layout3: null,
      layout4: null,
      layout5: null,
      layout6: null,
      layout7: null,
      layout8: null,
      layout9: null,
      emailadress: null,
      emailadress1: null,
      placeholder: null,
      password: null,
      success: null,
      error: null,
      password1: null,
      password2: null,
      boolean: false,
      disabled: null,
      boolean1: false,
      helper: null,
      checkbox1: null,
      checkbox2: null,
      checkbox3: null,
      checkbox4: null,
      checkbox5: null,
      checkbox6: true,
      checkbox7: null,
      checkbox8: true,
      checkbox9: null,
      radio: true,
      radio1: true,
      radio2: true,
      Roads: [],
      Provinces: [],
      ContractTypess: [],
      WorkTypes: [],
      FundingTypes: [],
      FundingSources: [],
      Contractors: [],
    };
  },
  methods: {
      handleLike(item) {
          Swal.fire({
            title: `You liked ${item.name}`,
            buttonsStyling: false,
            type: "success",
            confirmButtonClass: "md-button md-success"
          });
        },
  }
};
</script>
<style lang="scss" scoped>
.md-card .md-card-actions {
  border: none;
}

.md-inline-checkboxes {
  display: inline-flex;

  .md-checkbox {
    margin-top: 15px !important;
  }
}

.md-checkbox,
.md-radio {
  margin-top: 15px;
  margin-bottom: 0.5rem;
}

.md-checkbox,
.md-radio {
  display: flex;
}

// .md-radio /deep/ .md-radio-container {
//   margin-left: 5px;
//   position: relative;
//   left: -3px;
// }

.md-form-label + .md-layout-item .md-checkbox:not(:first-child),
.md-form-label + .md-layout-item + .md-layout-item .md-radio:not(:first-child),
.md-form-label + .md-layout-item .md-radio {
  margin-top: 0;
}

.form-control-static {
  margin-top: 6px;
}

.my-popup{
  position:absolute;
  top: 48px;
    left: 104px;
  width:250px;
  height:250px;
  background-color:gray;
      z-index: 999;
    overflow: auto;
}
md-dialog{
  width:40%;
}
</style>
