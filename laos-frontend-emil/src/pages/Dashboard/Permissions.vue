<template>
  <div>
    <PermissionsTable
        v-if="!isDataUpload"
        :tableData=permissionsTable
        @changePermission="changePermission"
    />

  </div>
</template>

<script>
import PermissionsTable from "./Tables/Permissions"

export default {
  name: "permissions",
  data() {
    return {
      isDataUpload: true,
      roles: [],
      featuresStructs: [],
      permissionsList: []
    }
  },
  components: {
    PermissionsTable
  },
  async created() {
    try {
      this.isDataUpload = true

      const [roles, featuresStructs] = await Promise.all(
          [this.$store.dispatch("LOAD_ROLES"),
            this.$store.dispatch("LOAD_FEATURES_STRUCTS")])
      this.roles = [...roles.map(role => role.role_name)]
      this.featuresStructs = [...featuresStructs]
      this.permissionsList = await this.$store.dispatch("LOAD_PERMISSIONS")
    } catch (e) {
      throw e
    } finally {
      this.isDataUpload = false
    }
  },
  methods: {
    notify({verticalAlign = "top", horizontalAlign = "right", color, message = ""}) {
      this.$notify({
        message: message,
        icon: "add_alert",
        horizontalAlign: horizontalAlign,
        verticalAlign: verticalAlign,
        type: color
      })
    },
    findPermission(role, feature, action) {
      const ind = this.permissionsList.findIndex(permission => {
        return permission.sub === role && permission.feature === feature && permission.action === action
      })
      return ind > -1
    },
    async changePermission(payload) {
      let operationMessage = ""
      try {
        const {target, role} = payload
        const [feature, action] = target.split(":")
        const ind = this.permissionsList.findIndex(perm => {
          return perm.sub === role && perm.feature === feature && perm.action === action
        })


        if (~ind) {
          await this.$store.dispatch("REVOKE_PERMISSION", {sub: role, feature, action})
          this.permissionsList.splice(ind, 1)
          operationMessage = this.$t("permission.revoked")
        } else {
          await this.$store.dispatch("GRANT_PERMISSION", {sub: role, feature, action})
          this.permissionsList.push({sub: role, feature, action})
          operationMessage = this.$t("permission.granted")
        }
        this.notify({message: operationMessage, color: "success"})
      } catch (err) {
        this.notify({message: err, color: "danger"})
        throw err
      }
    }
  },
  computed: {
    permissionsTable: function () {
      const roles = [...this.roles]
      const headers = ["features.action", ...roles]
      const rows = []
      this.featuresStructs.filter(feature => feature.actions.length > 0).forEach(feature => {
            const featureName = feature.feature_name
            feature.actions.forEach(action => {
              const row = {}
              roles.forEach(role => {
                row[role] = this.findPermission(role, featureName, action)
              })
              rows.push({action: `${featureName}:${action}`, ...row})

            })

          }
      )
      return {headers: headers, rows: rows}
    }
  }
}
</script>

<style lang="scss">

</style>