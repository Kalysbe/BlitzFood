<template>
  <div>
    <div class="md-layout-item md-size-100">
      <md-card>
        <!--md-card-header class="md-card-header-icon md-card-header-green">
          <div class="card-icon">
            <md-icon>assignment</md-icon>
          </div>
          <h4 class="title">Simple Table</h4>
        </md-card-header-->
        <md-card-content>
          <md-table v-model="tableRows">
            <md-table-row slot="md-table-row" slot-scope="{ item,index }">
              <md-table-cell :md-label="$t(tableHeaders[0])" :style="{fontWeight:500}">{{ item.action }}</md-table-cell>
              <md-table-cell v-for="role of tableHeaders.slice(1)" :key="`${item}-${role}`" :md-label="role">
                <md-checkbox v-model="tableRows[index][role]"
                             @change="changePermission(item.action, role)"
                             :disabled="role==='admin'"
                ></md-checkbox>
              </md-table-cell>
            </md-table-row>
          </md-table>
        </md-card-content>
      </md-card>
    </div>
  </div>
</template>
<script>
export default {
  name: "PermissionsTable",
  props: {tableData: Object},
  data() {
    return {}
  },
  computed: {
    tableRows() {
      return this.tableData.rows
    },
    tableHeaders() {
      return this.tableData.headers
    }
  },

  methods: {
    changePermission(action, role) {
      this.$emit("changePermission", {target: action, role})
    }
  }
}

</script>
<style>

</style>