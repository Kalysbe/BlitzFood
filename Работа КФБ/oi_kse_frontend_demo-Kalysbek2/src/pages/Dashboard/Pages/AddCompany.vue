<template>
  <div class="md-layout">
    <div class="md-layout-item md-small-size-100">
      <md-card>
        <md-card-header class="md-card-header-icon md-card-header-blue">
          <div class="card-icon">
            <md-icon>mail_outline</md-icon>
          </div>
          <h4 class="title">Stacked Form</h4>
        </md-card-header>

        <md-card-content>
          <md-field>
            <label>Email Adress</label>
            <md-input v-model="emailadress" type="email"></md-input>
          </md-field>
          <md-field>
            <label>Password</label>
            <md-input v-model="password" type="password"></md-input>
          </md-field>
          <md-checkbox v-model="boolean">Subscribe to newsletter</md-checkbox>
        </md-card-content>

        <md-card-actions md-alignment="left">
          <md-button class="md-success">Submit</md-button>
        </md-card-actions>
      </md-card>
    </div>
  </div>
</template>
<script>
export default {
  components: {},
  data() {
    return {
      layout1: null,
      layout2: null,
      layout3: null,
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
      radio2: true
    }
  }
}
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

.md-radio /deep/ .md-radio-container {
  margin-left: 5px;
  position: relative;
  left: -3px;
}

.md-form-label + .md-layout-item .md-checkbox:not(:first-child),
.md-form-label + .md-layout-item + .md-layout-item .md-radio:not(:first-child),
.md-form-label + .md-layout-item .md-radio {
  margin-top: 0;
}

.form-control-static {
  margin-top: 6px;
}
</style>
